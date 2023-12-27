<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


<link rel="stylesheet" href="styling/company_home.css">



<script>
  // Transfer data from PHP to JavaScript variables
  var orderTimeJson = <?php echo $order_time_json; ?>;
  var distanceJson = <?php echo $distanceJson; ?>;
  var distanceSumJson = <?php echo $distance_sum_json; ?>;
  var totalDrivesJson = <?php echo $total_drives_json; ?>;

  // Function to calculate the day for a given date
  function getDayFromDate(dateString) {
    const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const date = new Date(dateString);
    const dayIndex = date.getDay();
    return daysOfWeek[dayIndex];
  }

  // Function to create chart data
  function createChartData(orderTimeJson) {
    const currentDay = getDayFromDate(new Date().toISOString()); // Get the current day
    const labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',''];

    // Move the current day to the front of the labels array
    const currentDayIndex = labels.indexOf(currentDay);
    if (currentDayIndex !== -1) {
      labels.unshift(labels.splice(currentDayIndex, 1)[0]);
    }

    const data = Array(labels.length).fill(0); // Initialize data array with zeros for each day

    // Count the number of drives for each day
    orderTimeJson.forEach(orderTime => {
      const day = getDayFromDate(orderTime);
      const dayIndex = labels.indexOf(day);
      if (dayIndex !== -1) {
        data[dayIndex]++;
      }
    });

    return {
      labels: labels,
      datasets: [{
        label: 'Number of drives',
        data: data,
        borderWidth: 2,
        backgroundColor: '#073cfa',
      }]
    };
  }

  // Example usage: Create chart data
  const chartData = createChartData(orderTimeJson);

  // Existing chart configuration
  const ctx = document.getElementById('drives');

  new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>



<script>
    const today = new Date();
    const labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', ''];

    // Create a date object for 7 days ago
    const sevenDaysAgo = new Date(today);
    sevenDaysAgo.setDate(today.getDate() - 6);

    const filteredOrders = orderTimeJson.filter(orderTime => {
      const orderDate = new Date(orderTime);
      return orderDate >= sevenDaysAgo && orderDate <= today;
    });

    const data = Array(labels.length).fill(0);

    filteredOrders.forEach(orderTime => {
      
    });
</script>