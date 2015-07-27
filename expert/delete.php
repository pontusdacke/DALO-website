<?php
  $servername = "localhost";
  $username = "root";
  $password = "";

  // Create connection
  $mysqli = new mysqli($servername, $username, $password);

  // Check connection
  if ($mysqli->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $mysqli->select_db("thought");
  $query = "DELETE FROM newspost WHERE id=" . $_GET["id"] . "";
  $resultText = "";
  if ($result = $mysqli->query($query))
  {
    $resultText = "News deleted";
  }
  else
  {
    $resultText = "FAILED TO DELETE: " . $mysqli->error;
  }

  header("Location: manage.php")
?>
