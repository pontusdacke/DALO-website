<?php
  $server = "localhost";
  $user = "root";
  $password = "";

  // Create connection
  $mysqli = new mysqli($server, $user, $password);

  // Check connection
  if ($mysqli->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $mysqli->set_charset('utf8');
  // Select main database
  $mysqli->select_db("thought");
?>
