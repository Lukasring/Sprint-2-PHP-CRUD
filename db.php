<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbName = 'sprint2';

$conn = mysqli_connect($servername, $username, $password, $dbName); // Create connection

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully\n";
