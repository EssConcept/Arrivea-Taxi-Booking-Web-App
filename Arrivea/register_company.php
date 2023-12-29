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
    <title>Company Registration│ARRIVEA</title>
    <link rel="stylesheet" href="register_company.css">
</head>
<body>
    <table border="0px">
        <th colspan="3" class="title">Register <span class="title-2nd">your company</span> </th>
        <form method="post">
            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_1')">1</button>
                    <hr class="step-divider">
                </td>
                <td rowspan="5" id="content-box">
                    <!-- Step 1 content -->
                    <div id="step_1" class="step-content active-step" align="center">
                        <br>
                        <input type="text" placeholder="E-mail" name="email" id="email"><br><br>
                        <input type="password" placeholder="Password" name="password1" id="password1"><br><br>
                        <input type="password" placeholder="Password" name="password2" id="password2">
                    </div>

                    <!-- Step 2 content -->
                    <div id="step_2" class="step-content" align="center">
                        <br>
                        <input type="text" name="name" id="name" placeholder="Name" required><br><br>
                        <input type="text" name="surname" id="surname" placeholder="Surname" required><br><br>
                    </div>

                    <!-- Step 3 content -->
                    <div id="step_3" class="step-content" align="center">
                        <br>
                        <input type="text" name="username" id="username" placeholder="Username" required><br><br>
                        <input type="text" name="company_name" id="company_name" placeholder="Company name"><br><br>
                        <input type="tel" name="tel" id="tel" placeholder="Phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"><br><br>
                        
                    </div>

                    <!-- Step 4 content -->
                    <div id="step_4" class="step-content" align="center">
                        <br>
                        <input type="text" name="city" id="city" placeholder="City"><br><br>
                        <input type="num" name="price" id="price" placeholder="Price (€/km)"><br><br>
                    </div>

                    <!-- Step 5 content -->
                    <div id="step_5" class="step-content" align="center">
                        <br>
                        <input type="checkbox" id="checkbox" name="checkbox" required>
                        <label for="checkbox">Agree to user terms and conditions.</label><br><br>
                        <button type="submit">Register</button>
                    </div>
                </td>
            </tr>

            <!-- Step 2 button -->
            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_2')">2</button>
                    <hr class="step-divider">
                </td>
            </tr>

            <!-- Step 3 button -->
            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_3')">3</button>
                    <hr class="step-divider">
                </td>
            </tr>

            <!-- Step 4 button -->
            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_4')">4</button>
                    <hr class="step-divider">
                </td>
            </tr>

            <!-- Step 5 button -->
            <tr>
                <td class="step">
                    <button type="button" onclick="showStep('step_5')">5</button>
                    <hr class="step-divider">
                </td>
            </tr>
            <tr>
                <td colspan="3" class="note">*Click on the numbers on the left for the next step.</td>
                <td></td>
            </tr>
        </form>
        <tr>
            <td colspan="10">
                <?php
                    
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $email = $_POST['email'];
                        $password1 = $_POST['password1'];
                        $password2 = $_POST['password2'];
                        $name = $_POST['name'];
                        $surname = $_POST['surname'];
                        $username = $_POST['username'];
                        $company_name = $_POST['company_name'];
                        $phone_number = $_POST['tel'];
                        $city = $_POST['city'];
                        $price = $_POST['price'];

                        if(!empty($email) && !empty($password1) && !empty($password2) && !empty($name) && !empty($surname)
                        && !empty($username) && !empty($company_name) && !empty($phone_number) && !empty($city) && !empty($price)){
                            if($password1 == $password2){

                                $query_1 = "INSERT INTO users(username, email, password, name, surname, role, profile_picture_path, phone_number)
                                          VALUES('$username', '$email', '$password1', '$name', '$surname', 'company', 'profilepictures/me.png', '$phone_number)";
                                mysqli_query($con, $query_1);
                                $query_2 = "INSERT INTO company(company_name, city, price)
                                            VALUES('$company_name', '$city', '$price'')";
                                mysqli_query($con, $query_2);

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
        </tr>
        <tr>
            <td colspan="3"><button class="learn-more" onclick="redirect()">
                <span class="circle" aria-hidden="true">
                <span class="icon arrow"></span>
                </span>
                <span class="button-text">Back</span>
                </button>
            </td>
        </tr>
    </table>
    

<script>
  function redirect() {
    window.location.href = "login.php";
  }
</script>
    <script>
        // Function to show the selected step
        function showStep(stepId) {
            // Get all step content elements
            var steps = document.querySelectorAll('.step-content');

            // Hide all steps
            steps.forEach(function(step) {
                step.classList.remove('active-step');
            });

            // Show the selected step
            var selectedStep = document.getElementById(stepId);
            if (selectedStep) {
                selectedStep.classList.add('active-step');
            }

            // Adjust the active step divider
            var dividers = document.querySelectorAll('.step-divider');
            dividers.forEach(function(divider) {
                divider.style.display = 'none'; // Hide all dividers

                // Adjust only the divider corresponding to the active button
                if (divider.previousElementSibling.classList.contains('active-step')) {
                    divider.style.display = 'block';
                }
            });
        }
    </script>
</body>
</html>