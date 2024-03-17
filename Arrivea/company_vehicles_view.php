<?php

session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $v_id = $_GET['vehicle_id'];
        $v_name = mysqli_real_escape_string($con, $_POST['vehicle_name']);
        $v_plate = mysqli_real_escape_string($con, $_POST['license_plate']);
        $v_mileage = (int)$_POST['total_mileage'];
        $v_seats = (int)$_POST['num_seats'];
        $v_lperkm = (float)$_POST['liters_per_hundred_km'];
        $v_prev = mysqli_real_escape_string($con, $_POST['next_inspection']);
        $v_next = mysqli_real_escape_string($con, $_POST['next_safety_inspection']);
    
        if (!empty($v_id)) {
            $update_query_vehicle = "UPDATE vehicle SET vehicle_name = '$v_name', num_seats = $v_seats WHERE vehicle_id = $v_id";
            $update_query_statistics = "UPDATE vehicle_statistics SET liters_per_hundred_km = $v_lperkm, total_mileage = $v_mileage,
            previous_safety_inspection_date = '$v_prev', next_safety_inspection_date = '$v_next', license_plate = '$v_plate'
            WHERE vehicle_id = $v_id";
    
            mysqli_query($con, $update_query_vehicle);
            mysqli_query($con, $update_query_statistics);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage vehicles</title>
    <link rel="stylesheet" href="company_vehicles_view.css">
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
    
</head>
<body>
    <div id="header"></div><br>
    <hr>
    <table class="table_main" border="1">
        <?php

        $vehicle_id = $_GET['vehicle_id'];
        $query = "SELECT vehicle.vehicle_name, vehicle.num_seats, vehicle_statistics.*
            FROM vehicle
            JOIN vehicle_statistics ON vehicle.vehicle_id = vehicle_statistics.vehicle_id
            WHERE vehicle.vehicle_id = $vehicle_id";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $vehicle_name = $row['vehicle_name']; //
                $num_seats = $row['num_seats']; //
                $liters_per_hundred_km = $row['liters_per_hundred_km']; //
                $total_mileage = $row['total_mileage']; //
                $prev_safety_inspection = $row['previous_safety_inspection_date']; //
                $next_safety_inspection = $row['next_safety_inspection_date']; //
                $license_plate = $row['license_plate']; //

                echo "<form method='POST'>
                <tr>
                    <td>
                        <label for='vehicle_name'>Vehicle name</label> 
                        <input type='text' value='$vehicle_name' id='vehicle_name' name='vehicle_name'>
                    </td>
                    <td>
                        <label for='license_plate'>License plate</label>
                        <input type='text' value='$license_plate' id='license_plate' name='license_plate'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='total_mileage'>Total mileage</label>
                        <input type='number' value='$total_mileage' id='total_mileage' name='total_mileage'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='num_seats'>Number of seats</label>
                        <input type='number' value='$num_seats' id='num_seats' name='num_seats'>
                    </td>
                    <td>
                        <label for='liters_per_hundred_km'>L/km</label>
                        <input type='number' value='$liters_per_hundred_km' id='liters_per_hundred_km' name='liters_per_hundred_km'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='prev_inspection'>Previous safety inspection</label>
                        <input type='text' value='$prev_safety_inspection' readonly id='prev_inspection' name='prev_inspection'>
                    </td>
                    <td>
                        <label for='next_inspection'>Next safety inspection</label>
                        <input type='text' value='$next_safety_inspection' readonly id='next_inspection' name='next_inspection'>
                    </td>
                    <td>
                        <label for='next_safety_inspection'>Enter a new date</label>
                        <input type='date' id='next_safety_inspection' name='next_safety_inspection'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type='submit'>
                    </td>
                </tr>
            </form>";
            }
        }
        else{
            echo "<tr><td>kebab</td></tr>";
        }
        ?>
        
        <tr>
            <td>
                <button><a href="company_vehicles.php">BACK</a></button>
            </td>
        </tr>
    </table>
</body>
</html>