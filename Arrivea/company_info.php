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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&family=Raleway&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins';
}

table{
    margin-top:200px;
    border-collapse: collapse;
    width: 100%;
    display:flex;
    justify-content:center;
    align-items:center;
}

table th{
    font-size:28px;
    display:flex;
    justify-content:left;
    padding-bottom:15px;
}

table td{
    padding-bottom:5px;
}

input[type='text'],
input[type='number'] {
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.button {
    padding: 5px 10px;
    background-color: #FFF94E;
    color: black;
    border-style: none;
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: black;
    color:#FFF94E;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
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
    <hr>
    <table>
        <th colspan="2">Edit your profile</th>
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
                                        <input type='submit' class='button'>
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