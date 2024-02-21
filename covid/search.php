<?php
// Include your database connection file
include("php/config.php");
$con = new mysqli("localhost:3008", "root", "chat", "covid");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    // Validate and sanitize user input
    $pincode = mysqli_real_escape_string($con, $_GET["search"]);

    // Query the database based on pincode
    $query = "SELECT * FROM vaccination_centers WHERE pincode = '$pincode'";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Display search results
           // echo "<div class='search-results'>";
            //echo "<div class='search-results' style='background-image: url(" . 'C:\\xampp\\htdocs\\covid\\covid3.jpeg'  . "); background-size: cover; background-repeat: no-repeat; padding: 20px;'>";
            //echo "<div class='search-results' style='background-image: url(\"http://localhost/covid/covid4.jpeg\"); background-size: cover; background-repeat: no-repeat; padding: 20px; height:90%;'>;
            echo "<div class='search-results' style='background-image: url(\"http://localhost/covid/covid4.jpeg\"); background-size: cover; background-repeat: no-repeat; padding: 20px; height:100%;'>";

            echo '<h3 class="sh3" style="color:black;">COVID CENTERS</h3>';

            echo '<div class="recent-centers-content">';
            
            while ($row = mysqli_fetch_assoc($result)) {
               echo "<div class='vaccination-center1'>";
               echo "<h3>Center-" . $row['center_id'] . "</h3>";
               echo "<p><strong>Name:</strong> " . $row['center_name'] . "</p>";
               echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
               echo "<p><strong>Vaccination Type:</strong> " . $row['vaccination_type'] . "</p>";
               echo "<p><strong>Slots Available:</strong> " . $row['slots_available'] . "</p>";
               echo "<p><strong>Pincode:</strong> " . $row['pincode'] . "</p>";
               echo "<p><strong>City:</strong> " . $row['city'] . "</p>";
               echo "<p><strong>State:</strong> " . $row['state'] . "</p>";

               

               echo "<form action='booking_page.php' method='GET'>";
               echo "<input type='hidden' name='center_id' value='" . $row['center_id'] . "'>";
               echo "<input type='submit' value='Book Slot' style='color: black; background-color:light green;'>";
               

               echo "</form>";

               echo "</div>";

               
            }

        

            echo "</div>";
            echo "</div>";
        } else {
            echo "<p style='text-align: center; font-size: 40px; color: red; margin-top: 200px;'>No vaccination centers found for the provided pincode.</p>";

        }
    } else {
        echo "<p>Error executing query: " . mysqli_error($con) . "</p>";
    }
}
?>
<link rel="stylesheet" href="style.css">










