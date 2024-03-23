<?php
    session_start();

	include("connection.php");
	include("functions.php");

    $user_id = $_SESSION['user_id'];
    $drive_id = $_SESSION['drive_id'];

    $query = "SELECT * FROM drive WHERE drive_id = $drive_id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Fetch data and store it in an array
    $drive = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $drive[] = $row;
    }

    // Close the database connection
    mysqli_close($con);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($drive);

?>