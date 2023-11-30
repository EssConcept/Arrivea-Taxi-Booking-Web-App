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