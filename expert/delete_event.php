<?php
  include 'config.php';

  $query = "DELETE FROM event WHERE id=" . $_GET["id"] . "";
  $resultText = "";
  if ($result = $mysqli->query($query))
  {
    $resultText = "Event deleted";
  }
  else
  {
    $resultText = "FAILED TO DELETE: " . $mysqli->error;
  }

  header("Location: remove_event.php")
?>
