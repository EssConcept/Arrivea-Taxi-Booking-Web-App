<?php
    /*include('header_driver.php');
    session_start();
    include("connection.php");
	include("functions.php");

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $query = "SELECT u.username, e.company_id FROM users u LEFT JOIN employee e ON u.user_id = e.driver_id WHERE u.user_id = $user_id";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $username = $user_data['username'];
        $company_id = $user_data['company_id'];
    } else {
        $username = "Unknown";
        $company_id = null;
    }
    
    if (isset($_POST['select_vehicle'])) {

        $driver_id = $_POST['driver_id'];
        $vehicle_id = $_POST['vehicle_id'];


        $delete_query = "DELETE FROM using_vehicle WHERE driver_id = $driver_id";
        $delete_result = mysqli_query($con, $delete_query);

        if ($delete_result || mysqli_affected_rows($con) == 0) {

            $insert_query = "INSERT INTO using_vehicle (driver_id, vehicle_id) VALUES ($driver_id, $vehicle_id)";
            $insert_result = mysqli_query($con, $insert_query);
        }
        if ($insert_result) {
            echo "";
        } 
    }
*/

include('header_driver.php');
session_start();
include("connection.php");
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT u.username, e.company_id FROM users u LEFT JOIN employee e ON u.user_id = e.driver_id WHERE u.user_id = $user_id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $username = $user_data['username'];
    $company_id = $user_data['company_id'];
} else {
    $username = "Unknown";
    $company_id = null;
}

if (isset($_POST['select_vehicle'])) {

    $driver_id = $_POST['driver_id'];
    $vehicle_id = $_POST['vehicle_id'];

    $delete_query = "DELETE FROM using_vehicle WHERE driver_id = $driver_id";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result || mysqli_affected_rows($con) == 0) {

        $insert_query = "INSERT INTO using_vehicle (driver_id, vehicle_id) VALUES ($driver_id, $vehicle_id)";
        $insert_result = mysqli_query($con, $insert_query);
    }
    if ($insert_result) {
        echo "";
    }
} elseif (isset($_POST['return_vehicle'])) {
    $driver_id = $_POST['driver_id'];
    $return_vehicle_query = "DELETE FROM using_vehicle WHERE driver_id = $driver_id";
    $return_vehicle_result = mysqli_query($con, $return_vehicle_query);
    if ($return_vehicle_result) {
        
    }
}

?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&family=Raleway&display=swap');

    *{
        font-family: 'Poppins', sans-serif;
    }
    body{
        display:flex;
        justify-content:center;
        align-items:center;
        margin:auto;
    }
    .container{
        margin-top:200px;
        border: 1px solid black;
        width:900px;
        border-radius:5px;
        padding:50px;
    }

    .welc{
        font-weight:600px;
        font-size:26px;
        padding-bottom:5px;
        text-align:left;
    }
    .username{
        font-weight:600;
        font-size:20px;

    }
    .desc{
        font-size:14px;
        transform:translateY(-30px);
    }

    .list{
        padding-top:150px;
        font-weight:600;
        font-size:20px;
        text-align:left;
    }
    .v-list{
        text-align:center;
    }

    .v-list, td{
        padding:3px;
        border:none;
    }

    .title{
        border:none;
    }

    .request{
        font-weight:600;
        font-size:20px;
        padding-top:60px;
        border:none;
        text-align:left;
    }

    .r-list, .r1{
        padding:10px;
        
        
    }

    .r1{
        border:1px bold black;
    }

    .r-list {
        border-collapse: collapse;
        width: 100%;
        padding-top: 50px;
        margin-bottom:500px;
    }
    .r-list, .r-list td {
        padding: 8px;
        text-align: center;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
    }
    .action-buttons button {
        margin: 10px;
    }

    .r-list , .r-list td {
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    
    .reject-btn{
        background-color:#E53935;
        color:black;
    }

    .reject-btn:hover{
        background-color:black;
        color:#E53935;
    }

    .accept-btn{
        background-color:#6BB66E;
    }

    .accept-btn:hover{
        background-color:black;
        color:#6BB66E;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver │ ARRIVEA</title>
</head>
<body>
<div class="outline" id="profile">
    <div>
    <table border="0px" class="container" >
        <th class="welc">Welcome!</th>
        <tr>
            <td rowspan="2" width="100px"><img src="driver_pfp.png" alt="driver" width="100px" height="100px"></td>
            <td class="username"><?php echo $username?></td>
            <td rowspan="2">Today's Total Drives: 0</td>
            <td rowspan="2">Today's Total Distance: 0</td>
        </tr>
        <tr>
            <td class="desc">Taxi Driver</td>
            
        </tr>
        <tr>
        <td colspan="3">Vehicle Status: <?php /*
                    // Check if a vehicle is selected by the driver
                    $status_query = "SELECT * FROM using_vehicle WHERE driver_id = $user_id";
                    $status_result = mysqli_query($con, $status_query);

                    if ($status_result && mysqli_num_rows($status_result) > 0) {
                        echo "Selected <img src='Online.png' width='20px' height='20px'>";
                    } else {
                        echo "Not Selected <img src='Offline.png' width='20px' height='20px'>";
                    }
                */
            $status_query = "SELECT * FROM using_vehicle WHERE driver_id = $user_id";
            $status_result = mysqli_query($con, $status_query);

            if ($status_result && mysqli_num_rows($status_result) > 0) {
                $using_vehicle_data = mysqli_fetch_assoc($status_result);
                echo "Selected <img src='Online.png' width='20px' height='20px'>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='driver_id' value='$user_id'>";
                echo "<input type='hidden' name='vehicle_id' value='" . $using_vehicle_data['vehicle_id'] . "'>";
                echo "<button type='submit' name='return_vehicle' class='return_vehicles'>Return Vehicle</button>";
                echo "</form>";
            } else {
                echo "Not Selected <img src='Offline.png' width='20px' height='20px'>";
            }
                ?></td>
        </tr>
    </table>
    </div>

    <div>
    <table border="0px" class="v-list" id="vehicles">
        <tr >
            <td colspan="4" class="list">Choose your vehicle:</td></tr>
        <tr>
            <td><?php
    
    if ($company_id !== null) {
        
        $vehicles_query = "SELECT * FROM vehicle WHERE company_id = $company_id";
        $vehicles_result = mysqli_query($con, $vehicles_query);

      
        if ($vehicles_result && mysqli_num_rows($vehicles_result) > 0) {
            echo "<form method='post'>";
            echo "<table border='1px'>";
            echo "<tr class='title'><td>Vehicle ID</td><td>Vehicle Name</td><td>Number of Seats</td></tr>";

            while ($vehicle_data = mysqli_fetch_assoc($vehicles_result)) {
                echo "<tr>";
                echo "<td>".$vehicle_data['vehicle_id']."</td>";
                echo "<td>".$vehicle_data['vehicle_name']."</td>";
                echo "<td>".$vehicle_data['num_seats']."</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='driver_id' value='$user_id'>";
                echo "<input type='hidden' name='vehicle_id' value='" . $vehicle_data['vehicle_id'] . "'>";
                echo "<button type='submit' name='select_vehicle'>Select</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            

            echo "</table>";
        } else {
            echo "<p>No vehicles available for your company.</p>";
        }
    } else {
        echo "<p>You are not associated with any company.</p>";
    }
    ?></td>
        </tr>
    </table>
    </div>

    <table border="0px" class="r-list" id="requests">
        <th class="request">Requests</th>
        <tr>
            <td class="r1" >Passanger_id</td>
            <td class="r1" >Pickup Location</td>
            <td class="r1" >Destination</td>
            <td class="r1" >Order Time</td>
            <td class="r1" >Distance</td>
        </tr>
        <?php
        $drive_query = "SELECT passanger_id, pickup_location, destination, order_time, distance FROM drive";
        $drive_result = mysqli_query($con, $drive_query);

        if ($drive_result && mysqli_num_rows($drive_result) > 0) {
            while ($drive_data = mysqli_fetch_assoc($drive_result)) {
                echo "<tr>";
                echo "<td class='r1'>".$drive_data['passanger_id']."</td>";
                echo "<td class='r1'>".$drive_data['pickup_location']."</td>";
                echo "<td class='r1'>".$drive_data['destination']."</td>";
                echo "<td class='r1'>".$drive_data['order_time']."</td>";
                echo "<td class='r1'>".$drive_data['distance']."</td>";
                echo "<td class='action-buttons'>";
                echo "<button type='button'class='accept-btn'>Accept</button>";
                echo "<button type='button' class='reject-btn'>Reject</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No requests available.</td></tr>";
        }
        ?>
    </table>
</div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('header ul li a[href^="#"]');
            links.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: "smooth"
                        });
                    }
                });
            });
        });
</script>
</html>