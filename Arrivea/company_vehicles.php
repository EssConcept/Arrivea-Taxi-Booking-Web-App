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
    <title>Manage vehicles</title>

    <link rel="stylesheet" href="company_vehicles.css">
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
    <table class="table_main">
        <tr>
            <td>
                <table>
                    <th><h1>Vehicles</h1></th>
                    <tr>
                        <td>
                            Vehicle ID
                        </td>
                        <td>
                            Vehicle name
                        </td>
                        <td>
                            Number of seats
                        </td>
                        <td>
                            View details
                        </td>
                    </tr>

                    <?php
                    
                    $user_id = $user_data['user_id'];
                    $query = "SELECT *
                    FROM vehicle
                    JOIN company ON vehicle.company_id = company.company_id
                    JOIN users ON company.username = users.username";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $vehicle_id = $row['vehicle_id'];
                            $vehicle_name = $row['vehicle_name'];
                            $num_seats = $row['num_seats'];

                            echo "<tr>
                            <td>
                                $vehicle_id
                            </td>
                            <td>
                                $vehicle_name
                            </td>
                            <td>
                                $num_seats
                            </td>
                            <td>
                                <a href='company_vehicles_view.php?vehicle_id=$vehicle_id'>View</a>
                            </td>
                        </tr>";
                        }
                    }
                    
                    ?>
                    <tr>
                        <td>
                            <button class="button" onclick="location.href='company_add_vehicle.php'">ADD VEHICLE</button>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>