<?php

$conn = mysqli_connect("localhost", "root", "groot", "registration");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully , ";
?>