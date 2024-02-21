<?php 
session_start();

include("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}

$con = new mysqli("localhost:3008", "root", "chat", "covid");
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");

while ($result = mysqli_fetch_assoc($query)) {
    $res_Uname = $result['Username'];
    $res_Email = $result['Email'];
    $res_Age = $result['Age'];
    $res_id = $result['Id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
    
</head>

<body style="background-image:  url('covid-vaccine-syringe.jpg');background-repeat: no-repeat;height:100vh; background-size: cover;background-position: center;max-width: 100%;overflow-x: hidden; "> 
  <div class="full-page-image">
    <div class="nav">
        <div class="logo">
            <!--<p><a href="home.php">logo</a> </p>-->
            <h4> Welcome to Vaccination Center !</h4>
        </div>

        <div class="right-links">
            <?php
            echo "<a href='edit.php?Id=$res_id'>Change Profile</a>";
            ?>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <main >

      
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search...">
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="search-results">
            <?php include('search.php'); ?>
        </div>

    </main>
</div>
</body>

</html>
