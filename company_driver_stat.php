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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
    </script>
    <!-- HEADER SCRIPT -->
    <script>
        $(function(){
            $("#header").load("header_company.php");
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="styling/company_driver_stat.css">
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

        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            
            $order_time_array[] = $row['order_time'];
            $distance_array[] = $row['distance'];
            $distance_sum += $row['distance'];
            $total_drives += 1;
          }
        }

        $order_time_json = json_encode($order_time_array);
        $distanceJson = json_encode($distance_array);
        $distance_sum_json = json_encode($distance_sum);
        $total_drives_json = json_encode($total_drives);
        
      }
      else{
        Header("Location:Company_drivers.php");
      }
            
    ?>
    <hr>

<!-- FIRST GRAPF -->
  <div class="col-4 offset-4">
    <canvas id="drives"></canvas>
  </div>
  <div class="col-4 offset-4 my-5">
    <canvas id="distance"></canvas>
  </div>



<!-- GRAPH CODES -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<script>
  // Transfer data from PHP to JavaScript variables
  var orderTimeJson = <?php echo $order_time_json; ?>;
  var distanceJson = <?php echo $distanceJson; ?>;
  var distanceSumJson = <?php echo $distance_sum_json; ?>;
  var totalDrivesJson = <?php echo $total_drives_json; ?>;

  // Calculate the day for a given date
  function getDayFromDate(dateString) {
    const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const date = new Date(dateString);
    const dayIndex = date.getDay();
    return daysOfWeek[dayIndex];
  }

  // Function to create chart data for the past 7 days -------------------------------------------
  function createChartData(orderTimeJson) {
    const today = new Date();
    const labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', ''];

    // Create a date object for 7 days ago
    const sevenDaysAgo = new Date(today);
    sevenDaysAgo.setDate(today.getDate() - 6); // 7 days ago

    // Filter orders for the past 7 days
    const filteredOrders = orderTimeJson.filter(orderTime => {
      const orderDate = new Date(orderTime);
      return orderDate >= sevenDaysAgo && orderDate <= today;
    });

    const data = Array(labels.length).fill(0); // Data array (0 at default)

    // Num. drives for each day
    filteredOrders.forEach(orderTime => {
      const day = getDayFromDate(orderTime);
      const dayIndex = labels.indexOf(day);
      if (dayIndex !== -1) {
        data[dayIndex]++;
      }
    });

    return {
      labels: labels,
      datasets: [{
        categoryPercentage: 0.5, // Bar width
        label: 'Number of drives (Past 7 days)',
        data: data,
        borderWidth: 2,
        backgroundColor: '#073cfa',
      }]
    };
  }









  // Chart data for distance per day for last 7 days ---------------------------------------
  function createChartDataDistance(orderTimeJson, distanceJson) {
    const today = new Date();
    const labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', ''];

    // Create a date object for 7 days ago
    const sevenDaysAgo = new Date(today);
    sevenDaysAgo.setDate(today.getDate() - 6); // 7 days ago

    // Initialize an array to store the total distance for each day
    const distanceData = Array(7).fill(0);

    // Loop through the orders for the past 7 days
    orderTimeJson.forEach((orderTime, index) => {
      const orderDate = new Date(orderTime);
      if (orderDate >= sevenDaysAgo && orderDate <= today) {
        const dayIndex = orderDate.getDay();
        distanceData[dayIndex] += distanceJson[index];
      }
    });

    // Create the chart data format
    const chartData = {
      labels: labels,
      datasets: [{
        label: 'Total Distance (Last 7 days)',
        data: distanceData,
        fill: false,
        borderColor: '#ff5733', // Choose a different color for the line
        borderWidth: 2,
        pointRadius: 5,
      }]
    };

    return chartData;
  }


  


  // Create chart data
  const chartData = createChartData(orderTimeJson);
  const chartDataDistance = createChartDataDistance(orderTimeJson, distanceJson);

  // Chart display
  const chart_drives = document.getElementById('drives');
  const chart_distances = document.getElementById('distance');

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
</script>







</body>
</html>