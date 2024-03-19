<?php

session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Company</title>
    
    <!-- GRAPF SCRIPT -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- HEADER SCRIPT -->
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
    </script>
    <script>
        $(function(){
            $("#header").load("header_company.php");
        });
    </script>
    <link rel="stylesheet" href="company_driver_stat.css">
</head>
<body>
    <div id="header"></div><br>

    <?php
            
      if(isset($_GET['driver_id'])){
        $driver_id = $_GET['driver_id'];
        
        $current_date = date("Y-m-d H:i:s");
        $date_week_ago = date("Y-m-d H:i:s", strtotime('-7 days', strtotime($current_date)));
        $query = "SELECT order_time, distance 
                  FROM drive 
                  WHERE driver_id = '$driver_id'
                  AND order_time BETWEEN '$date_week_ago' AND '$current_date'";
        $result = mysqli_query($con, $query);

        

        $order_time_array = array();
        $distance_array = array();
        $distance_sum = 0;
        $total_drives = 0;
        $price = 0;

        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            $order_time_array[] = $row['order_time'];
            $distance_array[] = $row['distance'];
            $distance_sum += $row['distance'];
            $total_drives += 1;

            
            $query2 = "SELECT c.price
              FROM company c
              JOIN employee e ON c.company_id = e.company_id
              WHERE e.driver_id = $driver_id";

            $result2 = mysqli_query($con, $query2);

            if (mysqli_num_rows($result2) > 0) {
              while ($row2 = mysqli_fetch_assoc($result2)) {
                $price = $row2['price'];
              }
            }
          }
        }

        $order_time_json = json_encode($order_time_array);
        $distanceJson = json_encode($distance_array);
        $distance_sum_json = json_encode($distance_sum);
        $total_drives_json = json_encode($total_drives);
        $price_json = json_encode($price);
      }
      else{
        Header("Location:Company_drivers.php");
      }
            
    ?>
    <hr>


  <table width="100%" class="my-table">
    <tr>
      <td width="50%">
        <div class="col-9 offset-2">
          <canvas id="drives"></canvas>
        </div>
      </td>
      <td width="50%">
        <div class="col-9 offset-1">
          <canvas id="profit"></canvas>
        </div>
      </td>
    </tr>
    <tr>
      <td width="50%">
        <div class="col-9 offset-2">
          <canvas id="distance"></canvas>
        </div>
      </td>
      <td width="50%">
        <div class="col-9 offset-1">
          <?php

            $monthly_profit = 0;
            $monthly_profit_tax = 0;
            $total_distance = 0;
            $date_month_ago = date('Y-m-d H:i:s', strtotime('-1 month', strtotime($current_date)));
            $query = "SELECT distance 
              FROM drive 
              WHERE driver_id = $driver_id 
              AND order_time BETWEEN 'date_month_ago' AND '$current_date'";

            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_assoc($result)){
                $temp_distance = $row['distance'];
                $total_distance += $temp_distance;
              }
            }

            if($total_distance > 0){
              $monthly_profit = $price * $total_distance;
              $monthly_profit_tax = $monthly_profit - ($monthly_profit / 100 * 2.5); //2.5% tax rate for services

              echo "<table>
                <tr>
                  <td>
                    Profit without tax:                  
                  </td>
                  <td align='right'>
                    $monthly_profit
                  </td>
                </tr>
                <tr>
                  <td>
                    Profit - tax included:
                  </td>
                  <td align='right'>
                    $monthly_profit_tax
                  </td>
                </tr>
              </table>";
              
            }
            else{
              echo "Driver did not make any profits for the last month";
            }
          
          ?>
        </div>
      </td>
    </tr>
  </table>
  
  
  

<!-- Graph import scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<script>

  //BOTH:

  // Transfer values from PHP to JavaScript
  var orderTimeJson = <?php echo $order_time_json; ?>;
  var distanceJson = <?php echo $distanceJson; ?>;
  var distanceSumJson = <?php echo $distance_sum_json; ?>;
  var totalDrivesJson = <?php echo $total_drives_json; ?>;
  var priceJson = <?php echo $price_json; ?>;

  // Calculate the day for a given date
  function getDayFromDate(dateString) {
    const daysOfWeek = ['Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday'];
    const date = new Date(dateString);
    const dayIndex = date.getDay();
    return daysOfWeek[dayIndex];
  }


  //NUM. OF DRIVES
  // Function to create chart data for the past 7 days
  function createChartData(orderTimeJson) {
  const today = new Date();
  const labels = ['Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday'];

  // Create a date object for 7 days ago
  const sevenDaysAgo = new Date(today);
  sevenDaysAgo.setDate(today.getDate() - 6); // 7 days ago

  // Filter drive orders for the past 7 days
  const filteredOrders = orderTimeJson.filter(orderTime => {
    const orderDate = new Date(orderTime);
    return orderDate >= sevenDaysAgo && orderDate <= today;
  });

  const data = Array(labels.length).fill(0); // Data array (0 at default)
  // Number of drives for each day
  filteredOrders.forEach(orderTime => {
    const day = getDayFromDate(orderTime);
    const dayIndex = (labels.indexOf(day) -1 + 7) % 7;
    if (dayIndex !== -1) {
      data[dayIndex]++;
    }
  });

  // Rearrange data array to start from today
  const daysUntilToday = today.getDay();
  const rearrangedData = data.slice(daysUntilToday).concat(data.slice(0, daysUntilToday));

  return {
      labels: labels,
      datasets: [{
        categoryPercentage: 0.5, // Bar width
        label: 'Number of drives (Past 7 days)',
        data: rearrangedData,
        borderWidth: 2,
        backgroundColor: '#073cfa',
      }]
    };
  }



  //TOTAL DISTANCE:
  // Chart data for distance per day for last 7 days
  function createChartDataDistance(orderTimeJson, distanceJson) {

    const today = new Date();
    const labels = ['Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday'];

    // Create a date object for 7 days ago
    const sevenDaysAgo = new Date(today);
    sevenDaysAgo.setDate(today.getDate() - 6); // 7 days ago

    // Initialize an array to store the total distance for each day
    const distanceData = Array(labels.length).fill(0);

    // Loop through the drive orders for the past 7 days
    orderTimeJson.forEach((orderTime, index) => {
      const orderDate = new Date(orderTime);
      if (orderDate >= sevenDaysAgo && orderDate <= today) {
        const dayIndex = (labels.indexOf(getDayFromDate(orderTime)) -1 + 7) % 7;
        // Assign a different distance value for each day
        distanceData[dayIndex] += getDistanceForDay(distanceJson[index], dayIndex);
      }
    });

    // Rearrange distanceData array to start from today
    const daysUntilToday = today.getDay();
    const rearrangedDistanceData = distanceData.slice(daysUntilToday).concat(distanceData.slice(0, daysUntilToday));

    // Create the chart data format
    const chartData = {
      labels: labels,
      datasets: [{
        label: 'Total Distance (Last 7 days)',
        data: rearrangedDistanceData,
        fill: false,
        borderColor: '#ff5733', // Choose a different color for the line
        borderWidth: 2,
        pointRadius: 5,
      }]
    };
    return chartData;
  }

// Helper function to get a different distance value for each day
function getDistanceForDay(originalDistance, dayIndex) {
    // You can customize the distance values for each day as needed
    const distanceMultiplier = [1, 1, 1, 1, 1, 1, 1][dayIndex];

    return originalDistance * distanceMultiplier;
}




  //PROFIT CHART:
  function createChartProfit(distanceJson, priceJson) {
  const today = new Date();
  const labels = ['Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday'];

  // Create a date object for 7 days ago
  const sevenDaysAgo = new Date(today);
  sevenDaysAgo.setDate(today.getDate() - 6); // 7 days ago

  // Initialize an array to store the total profit for each day
  const profitData = Array(7).fill(0);

  // Loop through the drive orders for the past 7 days
  orderTimeJson.forEach((orderTime, index) => {
    const orderDate = new Date(orderTime);
    if (orderDate >= sevenDaysAgo && orderDate <= today) {
      const dayIndex = (orderDate.getDay() - 1 + 7) % 7;
      // Calculate profit for each day
      profitData[dayIndex] += calculateProfitForDay(distanceJson[index], priceJson);
    }
  });

  const roundedProfitData = profitData.map(value => parseFloat(value.toFixed(2)));
  // Rearrange profitData array to start from today
  const daysUntilToday = today.getDay();
  const rearrangedProfitData = roundedProfitData.slice(daysUntilToday).concat(roundedProfitData.slice(0, daysUntilToday));

  // Create the chart data format
  const chartData = {
    labels: labels,
    datasets: [{
      label: 'Total Profit (Last 7 days)',
      data: rearrangedProfitData,
      fill: false,
      borderColor: '#00cc00', 
      borderWidth: 2,
      pointRadius: 5,
    }]
  };

  return chartData;
}
  function calculateProfitForDay(distance, price) {
    return distance * price;
  }




  // Create chart data
  const chartData = createChartData(orderTimeJson);
  const chartDataDistance = createChartDataDistance(orderTimeJson, distanceJson);
  const chartDataProfit = createChartProfit(distanceJson, priceJson);

  // Chart display
  const chart_drives = document.getElementById('drives');
  const chart_distances = document.getElementById('distance');
  const chart_profit = document.getElementById('profit');

  new Chart(chart_drives, {
    type: 'bar',
    data: chartData,
    options: {
      scales: {
        y: {
          beginAtZero: true,
        }
      }
    }
  });

  new Chart(chart_distances, {
    type: 'line',
    data: chartDataDistance, // CREATE DATA FOR THIS CHART
    options: {
      scales: {
        y: {
          beginAtZero: true,
        }
      }
    }
  })

  new Chart(chart_profit,{
    type: 'line',
    data: chartDataProfit,
    options:{
      scales:{
        y: {
          beginAtZero: true,
        }
      }
    }
  })

</script>
</body>
</html>