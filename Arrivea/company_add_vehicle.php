<?php

session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $v_name = $_POST['vehicle_name'];
        $v_seats = $_POST['num_seats'];
        $v_lperkm = $_POST['lperkm'];
        $v_mileage = $_POST['total_mileage'];
        $v_lastinspection = $_POST['last_inspection'];
        $v_nextinspection = $_POST['next_inspection'];
        $v_plate = $_POST['license_plate'];
        
        $user_id = $user_data['user_id'];

        $query1 = "SELECT company.company_id
                    FROM company
                    JOIN users ON company.username = users.username
                    WHERE users.user_id = $user_id";
    
        $result = mysqli_query($con, $query1);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $company_id = $row['company_id'];
    
                // Insert into "vehicle" table
                $query2 = "INSERT INTO vehicle (vehicle_name, num_seats, company_id)
                           VALUES ('$v_name', $v_seats, $company_id)";
                mysqli_query($con, $query2);
    
                // Retrieve the last inserted vehicle_id
                $last_inserted_id = mysqli_insert_id($con);
    
                // Insert into "vehicle_statistics" table
                $query3 = "INSERT INTO vehicle_statistics (vehicle_id, liters_per_hundred_km, total_mileage, previous_safety_inspection_date, next_safety_inspection_date, license_plate)
                           VALUES ($last_inserted_id, $v_lperkm, $v_mileage, '$v_lastinspection', '$v_nextinspection', '$v_plate')";
                mysqli_query($con, $query3);
            }
        }
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage vehicles</title>
    <link rel="stylesheet" href="styling/company_vehicles_view.css">
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
    
</head>
<body>
    <div id="header"></div><br>
    <hr>
    <table>
        <form method="POST">
            <tr>
                <td>
                    Car name:
                </td>
                <td>
                    <input type="text" id="vehicle_name" name="vehicle_name" required>
                </td>
                <td>
                    Number of seats:
                </td>
                <td>
                    <input type="number" id="num_seats" name="num_seats" required>
                </td>
            </tr>
            <tr>
                <td>
                    L/km:
                </td>
                <td>
                    <input type="number" id="lperkm" name="lperkm" required>
                </td>
                <td>
                    Mileage:
                </td>
                <td>
                    <input type="number" id="total_mileage" name="total_mileage" required>
                </td>
            </tr>
            <tr>
                <td>
                    Last safety inspection:
                </td>
                <td>
                    <input type="date" id="last_inspection" name="last_inspection" required>
                </td>
                <td>
                   Next safety inspection:
                </td>
                <td>
                    <input type="date" id="next_inspection" name="next_inspection" required>
                </td>
            </tr>
            <tr>
                <td>
                    License plate:
                </td>
                <td>
                    <input type="text" id="license_plate" name="license_plate" required>
                </td>
                <td></td>
                <td>
                    <input type="submit">
                </td>
            </tr>
        </form>
    </table>
</body>
</html>