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
    <title>Account Registration</title>
    <link rel="stylesheet" href="styling/register_user.css">
</head>
<body>
    <table>
        <form method="post">
            <tr>
                <!-- PRVI GUMB... delaj gumb po classu "step" pa se bojo spremenil vsi naenkrat... 
                also pri register_company je use isto sam en gumb zram pa vec contenta -->
                
                <td class="step">
                    <button type="button" onclick="showStep('step_1')">1</button>
                </td>
                <!-- SPODNJI TD JE ZA BOX V KATEREM SE DISPLAY-A INPUT... USAK DIV JE POL POSEBEJ NA DISPLAYI  -->
                <td rowspan="4" id="content-box">

                    <div id="step_1" class="step-content active-step" align="center">
                        <br>
                        <input type="text" placeholder="E-mail" name="email" id="email" required><br><br>
                        <input type="password" placeholder="Password" name="password1" id="password1" required><br><br>
                        <input type="password" placeholder="Password" name="password2" id="password2" required>
                    </div>

                    <div id="step_2" class="step-content" align="center">
                        <br>
                        <input type="text" name="name" id="name" placeholder="Name" required><br><br>
                        <input type="text" name="surname" id="surname" placeholder="Surname" required><br><br>

                        <label>Gender: </label>
                        <label for="male">Male</label>
                        <input type="radio" id="male" name="gender" value="m" required>
                        
                        <label for="female">Female</label>
                        <input type="radio" id="female" name="gender" value="f" required>
                    </div>

                    <div id="step_3" class="step-content" align="center">
                        <br>
                        <input type="text" name="username" id="username" placeholder="Username" required><br><br>
                        <input type="tel" name="tel" id="tel" placeholder="Phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><br><br>
                    </div>

                    <div id="step_4" class="step-content" align="center">
                        <br>
                        <input type="checkbox" id="checkbox" name="checkbox" required>
                        <label for="checkbox">Agree to user terms and conditions.</label>
                        <br>
                        <br>
                        <button type="submit">Register</button>
                    </div>
                </td>
            </tr>
            <!-- GUMBI (LEVA STRAN) -->
            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_2')">2</button>
                </td>
            </tr>

            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_3')">3</button>
                </td>
            </tr>

            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_4')">4</button>
                </td>
            </tr>
        </form>
        <tr>
            <td colspan="10" align="center">
                    <?php
                    
                    echo "Click on the numbers on the left for the next step.";

                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $email = $_POST['email'];
                        $password1 = $_POST['password1'];
                        $password2 = $_POST['password2'];
                        $name = $_POST['name'];
                        $surname = $_POST['surname'];
                        $gender = $_POST['gender'];
                        $username = $_POST['username'];
                        $phone_number = $_POST['tel'];

                        if(!empty($email) && !empty($password1) && !empty($password2) && !empty($name) && !empty($surname) && !empty($gender)
                        && !empty($username) && !empty($phone_number)){
                            if($password1 == $password2){
                                $query = "INSERT INTO users(username, email, password, name, surname, gender, role, profile_picture_path, phone_number)
                                          VALUES('$username', '$email', '$password1', '$name', '$surname', '$gender', 'user', 'profilepictures/me.png', '$phone_number')";
                                mysqli_query($con, $query);
                                Header("Location: login.php?email=$email&password=$password1");
                            }
                            else{
                                echo "<br>";
                                echo "Passwords are not matching!";
                            }
                        }
                        else{
                            echo "<br>";
                            echo "Complete the whole form and accept user terms and conditions before submitting the form!";
                        }
                    }
                    
                    ?>
            </td>
            <td>
                <a href="login.php">Back</a>
            </td>
        </tr>
    </table>

    <script>
        function showStep(stepId) {
            var steps = document.querySelectorAll('.step-content');

            steps.forEach(function(step) {
                step.classList.remove('active-step');
            });

            var selectedStep = document.getElementById(stepId);
            if (selectedStep) {
                selectedStep.classList.add('active-step');
            }
        }
    </script>
</body>
</html>