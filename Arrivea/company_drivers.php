<?php

session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);

?>
<style>
table{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top:200px;
}

th, td {
    padding: 8px;
    text-align: left;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

a {
    text-decoration: none;
    color: blue;
}

a:hover {
    text-decoration: underline;
}

.gender{
    text-transform: uppercase;
    text-align:center;
}
</style>
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
    <script>
        $(function(){
            $("#header").load("header_company.php");
        });
    </script>
</head>
<body>
    <div id="header"></div><br>
    <table>
        <th><h1>Employees</h1></th>
        <tr>
        
        <td>Name and Surname</td>
        <td>Email</td>
        <td>Phone number</td>
        <td>Username</td>
        <td>Gender</td>
    
                <?php
                
                    $query = "SELECT e.driver_id
                              FROM employee e
                              JOIN company c ON e.company_id = c.company_id
                              JOIN users u ON c.username = u.username";
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $driver_id = $row['driver_id'];
                            $inner_query = "SELECT * FROM users WHERE user_id = '$driver_id'";
                            $inner_result = mysqli_query($con, $inner_query);
                            if(mysqli_num_rows($inner_result) > 0){
                                while($inner_row = mysqli_fetch_assoc($inner_result)){
                                    $name = $inner_row['name'];
                                    $surname = $inner_row['surname'];
                                    $gender = $inner_row['gender'];
                                    $phone_number = $inner_row['phone_number'];
                                    $email = $inner_row['email'];
                                    $username = $inner_row['username'];

                                    if(!empty($name) && !empty($surname) && !empty($gender) && !empty($phone_number) && !empty($email) && !empty($username)){
                                       
                                         echo"
                                            <tr>
                                                <td>$surname $name</td>
                                                <td>$email</td>
                                                <td>$phone_number</td>
                                                <td>$username</td>
                                                <td class='gender'>$gender</td>
                                                <td><a href='company_driver_stat.php?driver_id=$driver_id'>Driver statistics</a></td>
                                                <td><a href='company_remove_user.php?driver_id=$driver_id'>Remove user</a></td>
                                            </tr>";
                                    }
                                }
                            }
                        }
                    } 
                
                ?>
        </tr>
    </table>
</body>
</html>