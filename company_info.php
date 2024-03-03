<?php

session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = $_POST['company_name'];
        $city = $_POST['city'];
        $price = $_POST['price'];
        $id = $_POST['company_id'];

        $update_query = "UPDATE company SET company_name='$name', city='$city', price=$price WHERE company_id=$id";
        mysqli_query($con, $update_query);
        Header("Location: company_home.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Company</title>
    <link rel="stylesheet" href="styling/company_view.css">
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
        <?php
        
        $user_id = $user_data['user_id'];

        $query = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $username = $row['username'];
                $password = $row['password'];
                $phone_number = $row['phone_number'];

                $query2 = "SELECT * FROM company WHERE username = '$username' LIMIT 1";
                $result2 = mysqli_query($con, $query2);

                if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $company_id = $row2['company_id'];
                        $company_name = $row2['company_name'];
                        $city = $row2['city'];
                        $price = $row2['price'];
                        
                        echo "<form method='POST'>
                                <tr>
                                    <td>
                                        Company ID:
                                    </td>
                                    <td>
                                        <input type='text' value='$company_id' id='company_id' name='company_id' readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Company Name:
                                    </td>
                                    <td>
                                        <input type='text' value='$company_name' id='company_name' name='company_name' required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        City:
                                    </td>
                                    <td>
                                        <input type='text' value='$city' id='city' name='city' required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Price:
                                    </td>
                                    <td>
                                        <input type='number' value='$price' id='price' name='price' required>
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
            }
        }
        
        ?>
    </table>
</body>
</html>