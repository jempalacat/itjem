<?php
session_start(); // Ensure session is started

// Include necessary files
include 'includes/db_connect.php';
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDICORDS</title>
    <link rel="stylesheet" href="css/home.css"> <!-- Example CSS file for styling -->
</head>
<body>

<?php

include 'includes/admits.php'; // Include modal or content for admits
include 'includes/added.php'; // Include modal or content for added
include 'includes/discharge.php'; // Include modal or content for discharge
include 'includes/records.php'; // Include modal or content for records
?>

<div class="grid-container"> 
    
    <div class="grid-item2" data-toggle="modal" data-target="#added">
        <div class="grid-content">
            <h1>12</h1>
            <h2>Added this day</h2>
        </div> 
    </div>

    <div class="grid-item3" data-toggle="modal" data-target="#discharge">
        <div class="grid-content">
            <h1>8</h1>
            <h2>Discharge</h2>
        </div>
    </div>
    
    <div class="grid-item5" data-toggle="modal" data-target="#admits">
        <div class="grid-content">
            <h1>30</h1>
            <h2>Admits</h2>
        </div>
    </div>

    <div class="grid-item4" data-toggle="modal" data-target="#totalrecords">
        <div class="grid-content">
            <h1>789</h1>
            <h2>Total Records</h2>
        </div>
    </div>

</div>

<?php

?>

</body>
</html>
