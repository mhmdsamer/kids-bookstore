<?php
// Database connection
$connection = mysqli_connect("localhost", "root", ""); // Adjust the username and password if necessary

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
$db = mysqli_select_db($connection, 'kids_bookstore');
if (!$db) {
    die("Database selection failed: " . mysqli_error($connection));
}
?>

