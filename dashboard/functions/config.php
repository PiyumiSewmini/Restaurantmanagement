<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = ''; 
$database = 'icbt';

// Attempt to connect to MySQL database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
