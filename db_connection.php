<?php
// Replace these values with your database connection details
$host = "localhost";
$username = "root";
$password = "";
$database = "janu";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>