<?php
    session_start();

	include("connection.php");
	include("functions.php");

    $query = "SELECT * FROM driver_location";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Fetch data and store it in an array
    $driver = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $driver[] = $row;
    }

    // Close the database connection
    mysqli_close($con);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($driver);

?>