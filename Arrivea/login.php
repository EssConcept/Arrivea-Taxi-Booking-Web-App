<?php

session_start();

	include("connection.php");
	include("functions.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <video autoplay loop muted plays-inline class="background-clip">
        <source src="arrivea_video.mp4" type="video/mp4">
    </video>
    <table>
        <th>Log In │ ARRIVEA</th>
        <form method="POST">
            <tr>
                <td colspan="2">
                    <input type="text" name="email" id="email" placeholder="E-mail" value="<?php
                    if(isset($_GET['email'])){
                        $email = $_GET['email'];
                        echo "$email";
                    }
                    ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="password" id="password" placeholder="Password" value="<?php
                    if(isset($_GET['password'])){
                        $password = $_GET['password'];
                        echo "$password";
                    }
                    ?>">
                </td>
                <td>
                    <!--<button type="button" onclick="togglePassword()" class="pass-btn">Show Password</button>-->
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="login_button" class="login-btn">Log In</button>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2" align="center" class="desc">Don't have an account yet? <a href="register_user.php">Register here</a></td>
            </tr>
            <tr><td colspan="2"><br></td></tr>
            <tr>
                <td colspan="2" align="center" class="desc">Create a <a href="register_company.php">business account</a></td>
            </tr>
        </form>
        <tr><td colspan="2"><br></td></tr>
        <tr>
            <td colspan="2" align="center">
                <?php
                
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
		            $email = $_POST['email'];
		            $password = $_POST['password'];

		            if (!empty($email) && !empty($password)) {

		
			            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
			            $result = mysqli_query($con, $query);

			            if ($result) {
				            if ($result && mysqli_num_rows($result) > 0) {
					            $user_data = mysqli_fetch_assoc($result);

					            if ($user_data['password'] === $password) {
						            $_SESSION['user_id'] = $user_data['user_id'];

						            if($user_data['role'] == 'admin'){
							            header("Location: admin_home.php");
						            }
						            else if($user_data['role'] == 'company'){
                                        header("Location: company_home.php");
                                    }
                                    else if($user_data['role'] == 'user'){
                                        header("Location: user_home.php");
                                    }
                                    else if($user_data['role'] == 'driver'){
                                        header("Location: driver_home.php");
                                    }
                                    else{
                                        echo "Error!";
                                    }
					            }
					            else{
						            echo "Wrong password!";
					            }
				            }
				            else{
					            echo "User does not exist";
				            }
			            }
		            }
                    else{
                        echo"empty";
                    }
	            }
                
                ?>
            </td>
        </tr>
    </table>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>