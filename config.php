<?php
$host = "localhost";  // Your database host (usually localhost)
$user = "root";       // Your MySQL username (default is root)
$pass = "";           // Your MySQL password (default is empty)
$dbname = "idea_selection";  // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
