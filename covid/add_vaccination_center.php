
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vaccination Center</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image:  url('images2.jpeg');background-repeat: no-repeat;height:100vh; background-size: cover;background-position: center;">
    <h1 class="add" style="color:white">Add Vaccination Center</h1>

    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>
    
    <form action="process_add_center.php" class="form_add" method="post">
        <div class="field_1 input_1">
            <label for="center_name" class="label_1">Center Name:</label>
            <input type="text" name="center_name" id="center_name" required>
        </div>

        <div class="field_1 input_1">
            <label for="location" class="label_1">Location:</label>
            <input type="text" name="location" id="location" required>
        </div>

        <div class="field_1 input_1">
            <label for="vaccination_type" class="label_1">Vaccination Type:</label>
            <input type="text" name="vaccination_type" id="vaccination_type" required>
        </div>

        <div class="field_1 input_1">
            <label for="slots_available" class="label_1">Number of Slots Available:</label>
            <input type="number" name="slots_available" id="slots_available" required>
        </div>

        <div class="field_1 input_1">
            <label for="pincode" class="label_1">Pincode:</label>
            <input type="text" name="pincode" id="pincode" required>
        </div>

        <div class="field_1 input_1">
            <label for="city" class="label_1">City:</label>
            <input type="text" name="city" id="city" required>
        </div>

        <div class="field_1 input_1">
            <label for="state" class="label_1">State:</label>
            <input type="text" name="state" id="state" required>
        </div>

        <!-- Add more fields as needed -->

        <div class="field_1">
            <input type="submit" class="btn_1" name="submit" value="Add Center">
        </div>
    </form>
    <br>
    <h2><a href="admin_dashboard.php" class="back">Back to Dashboard</a></h2>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for errors
            var urlParams = new URLSearchParams(window.location.search);
            var error = urlParams.get('error');
            var errorDiv = document.getElementById('error-message');

            if (error) {
                var errorMessage;
                if (error === 'duplicate') {
                    errorMessage = "Error: Duplicate vaccination center. Please choose a different name or location.";
                } else if (error === 'validation') {
                    errorMessage = "Error: Please fill in all required fields.";
                } else if (error === 'database') {
                    errorMessage = "Error: Failed to add vaccination center to the database. Please try again.";
                }
                // Add more conditions as needed

                errorDiv.innerHTML = errorMessage;
                errorDiv.style.display = 'block';
            }
        });
    </script>
</body>
</html>

