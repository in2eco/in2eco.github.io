<?php
$servername = "d3caf01e503c";
$username = "sa";
$password = "dockerStrongPwd123";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
