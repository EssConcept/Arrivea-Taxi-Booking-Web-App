<?php

session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_GET['driver_id'])){
            $driver_id = $_GET['driver_id'];

            $query_1 = "DELETE FROM employee WHERE driver_id = '$driver_id'";
            mysqli_query($con, $query_1);

            $query_2 = "UPDATE users SET role = 'user' WHERE user_id = '$driver_id'";
            mysqli_query($con, $query_2);

            Header("Location:company_drivers.php");
        }
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kick driver</title>
    <link rel="stylesheet" href="company_drivers.css">
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
    <?php
    
    if(isset($_GET['driver_id'])){
        $driver_id = $_GET['driver_id'];

        $query = "SELECT * FROM users WHERE user_id = '$driver_id' LIMIT 1";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $name = $row['name'];
                $surname = $row['surname'];
                $email = $row['email'];
                $phone_number = $row['phone_number'];
                $pfp = $row['profile_picture_path'];

                echo "<table>
                <tr>
                    
                    <td>$surname $name</td>
                    <td>$email</td>
                    <td>$phone_number</td>
                    <td>$email</td>
                </tr>
                </table>";
            }
        }
    }
    else{
        Header("Location: company_drivers.php");
    }
    
    ?>
    <div>
        <form method="POST">
            <label for="confirm">Check the box and submit to kick your driver <input type="checkbox" value="agree" name="confirm" id="confirm" required></label>
            <br>
            <button onclick="window.location.href='company_drivers.php'" class="cancelbtn">Cancel</button>
            <input type="submit" class="submit">
        </form>
        
    </div>
    
</body>
</html>