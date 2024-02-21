<?php
require_once("php/config.php");

// Establish a database connection
$con = new mysqli("localhost:3008", "root", "chat", "covid");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve recent vaccination centers from the database
$sql_get_recent_centers = "SELECT * FROM vaccination_centers ORDER BY center_id DESC LIMIT 10"; // Adjust the limit as needed
$result = $con->query($sql_get_recent_centers);

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Vaccination Centers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image:  url('images4.jpeg');background-repeat: no-repeat;height:100%; background-size: cover;">
    <h1 class="rh1" style="color:white">Recent Vaccination Centers</h1>

    <div class="recent-centers-content">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='vaccination-center'>";
                echo "<h3>Center-" . $row['center_id'] . "</h3>";
                echo "<p><strong>Name:</strong> " . $row['center_name'] . "</p>";
                echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                echo "<p><strong>Vaccination Type:</strong> " . $row['vaccination_type'] . "</p>";
                echo "<p><strong>Slots Available:</strong> " . $row['slots_available'] . "</p>";
                echo "<p><strong>Pincode:</strong> " . $row['pincode'] . "</p>";
                echo "<p><strong>City:</strong> " . $row['city'] . "</p>";
                echo "<p><strong>State:</strong> " . $row['state'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No recent vaccination centers found.</p>";
        }
        ?>
    </div>

    <a href="admin_dashboard.php" class="ar">Back to Dashboard</a>
</body>
</html> 

