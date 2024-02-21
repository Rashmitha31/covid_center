<?php
require_once("php/config.php");
$con = new mysqli("localhost:3008", "root", "chat", "covid");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve form data
$center_name = $_POST["center_name"];
$location = $_POST["location"];
$vaccination_type = $_POST["vaccination_type"];
$slots_available = $_POST["slots_available"];
$pincode = $_POST["pincode"];
$city = $_POST["city"];
$state = $_POST["state"];

// Validate form data (add more validation as needed)
if (empty($center_name) || empty($location) || empty($vaccination_type) || empty($slots_available) || empty($pincode) || empty($city) || empty($state)) {
    // Handle validation error, e.g., redirect back to the form with an error message
    header("Location: add_vaccination_center.php?error=validation");
    exit;
}

// Check for duplicates
$sql_check_duplicates = "SELECT * FROM vaccination_centers WHERE center_name = '$center_name' AND pincode = '$pincode'";
$result = $con->query($sql_check_duplicates);

if ($result->num_rows > 0) {
    // Duplicate found, handle accordingly (e.g., redirect back to the form with an error message)
    header("Location: add_vaccination_center.php?error=duplicate");
    exit;
}

// No duplicates found, insert the new record
$sql_insert_center = "INSERT INTO vaccination_centers (center_name, location, vaccination_type, slots_available, pincode, city, state) VALUES ('$center_name', '$location', '$vaccination_type', '$slots_available', '$pincode', '$city', '$state')";

if ($con->query($sql_insert_center) === TRUE) {
    // Record inserted successfully, redirect to the dashboard
    header("Location: admin_dashboard.php");
    exit;
} else {
    // Handle database insertion error (e.g., redirect back to the form with an error message)
    header("Location: add_vaccination_center.php?error=database");
    exit;
}

// Close the database connection
$con->close();
?>

