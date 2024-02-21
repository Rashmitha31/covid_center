<?php
// Include your database connection file
include("php/config.php");
$con = new mysqli("localhost:3008", "root", "chat", "covid");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["center_id"])) {
    // Retrieve center_id from request parameters
    $centerId = mysqli_real_escape_string($con, $_POST["center_id"]);

    // Retrieve number of booked slots for the center
    $bookedSlotsQuery = "SELECT COUNT(*) AS booked_slots FROM bookings WHERE center_id = '$centerId'";
    $bookedSlotsResult = mysqli_query($con, $bookedSlotsQuery);
    $bookedSlotsData = mysqli_fetch_assoc($bookedSlotsResult);
    $bookedSlots = $bookedSlotsData['booked_slots'];

    // Delete the vaccination center
    $deleteQuery = "DELETE FROM vaccination_centers WHERE center_id = '$centerId'";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Update slots_available by adding back the booked slots
        $updateSlotsQuery = "UPDATE vaccination_centers SET slots_available = slots_available + $bookedSlots";
        mysqli_query($con, $updateSlotsQuery);

        // Redirect back to the search page or display a success message
        header("Location: search.php?deleted=true");
        exit();
    } else {
        echo "Error deleting center: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>
