<!-- db.php -->

<?php

// Include the Database class file
include('Database.php');

// Create an instance of the Database class
$database = new Database();

// Get the database connection
$conn = $database->getConnection();

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally, set character set (adjust based on your needs)
mysqli_set_charset($conn, "utf8");

// Perform other database-related configurations if needed

?>

