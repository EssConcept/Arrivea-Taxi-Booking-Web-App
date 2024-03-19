<?php

session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);

?>

<style>
*{
    overflow:hidden;
}
.main_table {
    margin-top:200px;
    border-collapse: collapse;
    width: 100%;
    display:flex;
    justify-content:center;
    align-items:center;
}

.main_table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.table_columns {
    font-weight: bold;
    background-color: #f2f2f2;
}

.table_data {
    background-color: #fff;
}

.username{
    font-size:32px;
    font-weight:700;
    display:flex;
    justify-content:left;
    padding-bottom:0px;
}

.welc{
    font-size:24px;
    font-weight:600;
}

.status{
    transform:translateY(-40px);
    font-size:14px;
}

#status-sec td{
    border:none;
    padding-bottom:50px;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
    <table class="main_table">
        <tr>
            <td class="welc">Welcome, </td>
        </tr>
        <tr>
            <td colspan="0">
                <img src="company_pfp.png" alt=""></td>
                <td>
                    <?php
                    $username = $user_data['username'];
                    echo "<span class='username'> $username </span>";
                ?>
                </td>
                
        </tr>
        <tr id="status-sec">
            <td><a href="company_info.php">Edit profile</a></td>
            <td class="status">Company</td>
        </tr>
        
        <tr>
            <td class="table_columns" align="center">DRIVER</td>
            <td class="table_columns" align="center">E-MAIL</td>
            <td class="table_columns" align="center">PHONE NUMBER</td>
            <td class="table_columns" align="center">VEHICLE</td>
            <td class="table_columns" align="center">STATUS</td>
        </tr>
        <tr>
                <?php
                $username = $user_data['username'];
                $query = "SELECT company_id FROM company WHERE username = '$username'";

                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $company_id = $row['company_id'];

                        $inner_query = "SELECT users.* FROM users
                                        JOIN employee ON users.user_id = employee.driver_id
                                        WHERE employee.company_id = '$company_id'";
                        $inner_result = mysqli_query($con, $inner_query);
                        if(mysqli_num_rows($inner_result) > 0){
                            while($inner_row = mysqli_fetch_assoc($inner_result)){
                                $user_id = $inner_row['user_id'];
                                $name = $inner_row['name'];
                                $surname = $inner_row['surname'];
                                $email = $inner_row['email'];
                                $phone_number = $inner_row['phone_number'];

                                $inner_query_2 = "SELECT * FROM using_vehicle
                                                  WHERE driver_id = '$user_id'";
                                $inner_result_2 = mysqli_query($con, $inner_query_2);
                                if(mysqli_num_rows($inner_result_2) > 0){
                                    while($inner_row_2 = mysqli_fetch_assoc($inner_result_2)){
                                        $vehicle_id = $inner_row_2['vehicle_id'];

                                        $inner_query_3 = "SELECT * FROM vehicle WHERE vehicle_id = '$vehicle_id'";
                                        $inner_result_3 = mysqli_query($con, $inner_query_3);
                                        if(mysqli_num_rows($inner_result_3) > 0){
                                            while($inner_row_3 = mysqli_fetch_assoc($inner_result_3)){
                                                $vehicle_id = $inner_row_3['vehicle_id'];
                                                $vehicle_name = $inner_row_3['vehicle_name'];

                                                $inner_query_4 = "SELECT drive_id
                                                                  FROM drive
                                                                  WHERE NOT EXISTS (
                                                                  SELECT 1
                                                                  FROM finished_drives
                                                                  WHERE finished_drives.drive_id = drive.drive_id)";
                                                $inner_result_4 = mysqli_query($con, $inner_query_4);
                                                if(mysqli_num_rows($inner_result_4) > 0){

                                                    echo "<tr><td class='table_data' align='center'>$surname $name</td>
                                                    <td class='table_data' align='center'>$email</td>
                                                    <td class='table_data' align='center'>$phone_number</td>
                                                    <td class='table_data' align='center'>$vehicle_name</td>
                                                    <td class='table_data' align='center'>Active</td></tr>";
                                                }
                                                else{

                                                    echo "<tr><td class='table_data' align='center'>$surname $name</td>
                                                    <td class='table_data' align='center'>$email</td>
                                                    <td class='table_data' align='center'>$phone_number</td>
                                                    <td class='table_data' align='center'>$vehicle_name</td>
                                                    <td class='table_data' align='center'>Idle</td></tr>";
                                                }              
                                            }
                                        }
                                        else{
                                            echo "<td colspan='5'>Error</td>";
                                        }
                                    }
                                }

                            }
                        }
                        else{
                            echo "<td colspan='5'>You currently do not have any employees.<br>
                            <a href='company_drivers.php'>Click here to add employees</a></td>";
                        }
                    }
                }
                else{
                    echo "<td>ERROR</td>";
                }

                ?>  
        </tr>
    </table>
</body>
</html>