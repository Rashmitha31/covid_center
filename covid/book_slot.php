<?php
// book_slot.php

include("php/config.php");
$con = new mysqli("localhost:3008", "root", "chat", "covid");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["center_id"])) {
    $centerId = mysqli_real_escape_string($con, $_POST["center_id"]);
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $contact = mysqli_real_escape_string($con, $_POST["contact"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='error'>Invalid email format</p>";
        exit(); // Stop execution if email is invalid
    }

    // Validate contact number format
    if (!preg_match("/^[0-9]{10}$/", $contact)) {
        echo "<p class='error'>Invalid contact number (should be 10 digits)</p>";
        exit(); // Stop execution if contact number is invalid
    }

    // Check if the user has already booked two slots
    $userSlotsQuery = "SELECT COUNT(*) AS booked_slots FROM bookings WHERE email = '$email' AND center_id = '$centerId'";
    $userSlotsResult = mysqli_query($con, $userSlotsQuery);
    $userSlotsData = mysqli_fetch_assoc($userSlotsResult);
    $bookedSlots = $userSlotsData['booked_slots'];

    if ($bookedSlots >= 2) {
        echo "<p class='error' style='text-align: center; font-size: 40px; color: red; margin-top: 200px;'>You have already booked two slots</p>";
        exit(); // Stop execution if the user has already booked two slots
    }

    // Check the availability of slots for the specified center
    $slotsAvailableQuery = "SELECT slots_available FROM vaccination_centers WHERE center_id = '$centerId'";
    $slotsAvailableResult = mysqli_query($con, $slotsAvailableQuery);
    $slotsAvailableData = mysqli_fetch_assoc($slotsAvailableResult);
    $availableSlots = $slotsAvailableData['slots_available'];

    if ($availableSlots <= 0) {
        echo "<p class='error' style='text-align: center; font-size: 40px; color: red; margin-top: 200px;'>No slots available at the selected center</p>";
        exit(); // Stop execution if no slots are available
    }

    // Decrease the available slots in the vaccination center by 1
    $updateSlotsQuery = "UPDATE vaccination_centers SET slots_available = slots_available - 1 WHERE center_id = '$centerId'";
    mysqli_query($con, $updateSlotsQuery);

    
    // Insert the booking
    $insertQuery = "INSERT INTO bookings (center_id, name, email, contact) VALUES ('$centerId', '$name', '$email', '$contact')";

    if (mysqli_query($con, $insertQuery)) {
        echo"<p class='error' style='text-align: center; font-size: 40px; color: red; margin-top: 200px;'> Slot booked successfully!</p>";
    } else {
        echo "Error booking slot: " . mysqli_error($con);
    }

} else {
    echo "Invalid request.";
}
?>
