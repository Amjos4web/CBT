<?php
// connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "cbt2";

// connection string to the database
$conn = new mysqli($hostname, $username, $password, $dbname);
// check connection
if ($conn->connect_error) {
	die ('Error connecting to database' . $conn->connect_error);
}
?>