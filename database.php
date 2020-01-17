<?php

function getConnection() {
  $db_servername = "localhost";
  $db_username = "localhost";
  $db_password = '';
  $db_name = "test";
  // Create connection
  $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}
?>
