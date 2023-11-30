<input type="text" placeholder="E-mail" name="email" id="email">
<input type="password" placeholder="Password" name="password1" id="password1">
<input type="password" placeholder="Password" name="password2" id="password2">




<input type="text" placeholder="Name" name="name" id="name">
<input type="text" placeholder="Surname" name="surname" id="surname">

<input type="radio" id="male" name="gender" value="male">
<label for="male" class="gender-label">
<div class="dot male"></div> Male
</label>

<input type="radio" id="female" name="gender" value="female">
<label for="female" class="gender-label">
<div class="dot female"></div> Female
</label>




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
        }
    </script>



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

                        if(!empty($email) && !empty($password1) && !empty($password2) && !empty($name) && !empty($surname) && !empty($gender)
                        && !empty($username)){
                            if($password1 == $password2){
                                $query = "INSERT INTO users(username, email, password, name, surname, gender, role, profile_picture_path)
                                          VALUES('$username', '$email', '$password1', '$name', '$surname', '$gender', 'user', 'profilepictures/me.png')";
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