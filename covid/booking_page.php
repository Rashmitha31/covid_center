<?php
// Include your database connection file
include("php/config.php");
$con = new mysqli("localhost:3008", "root", "chat", "covid");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["center_id"])) {
    $centerId = mysqli_real_escape_string($con, $_GET["center_id"]);
    // Fetch additional details about the selected center if needed
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Booking Slot</title>
</head>

<body style="background-image:  url('images1.jpeg');background-repeat: no-repeat;height:100vh; background-size: cover;background-position: center;"> 
    <div style="margin-top:30px">
       <h1 class="bh3">Booking Slot for Center-<?php echo $centerId; ?></h1>
    </div>

    <form action="book_slot.php" class="booking" method="POST" style="margin-top: 150px">

        <input type="hidden" name="center_id" value="<?php echo $centerId; ?>">
        <label for="name" class="lab">Name:</label>
        <input type="text" name="name" class="in" required>

        <label for="email" class="lab">Email:</label>
        <input type="email" name="email" class="in" required>
        <?php
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='error'>Invalid email format</p>";
            }
        }
        ?>

        <label for="contact" class="lab">Contact:</label>
        <input type="text" name="contact" class="in" required>
        <?php
        if (isset($_POST['contact'])) {
            $contact = $_POST['contact'];
            if (!preg_match("/^[0-9]{10}$/", $contact)) {
                echo "<p class='error'>Invalid contact number (should be 10 digits)</p>";
                exit(); // Stop execution if contact number is invalid
            }
        }
        ?>

        <input type="submit" value="Submit Booking" class="in">
    </form>
</body>

</html>

<?php
} else {
    echo "Invalid request.";
}
?>



