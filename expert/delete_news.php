<?php
  include 'config.php';

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

  header("Location: remove_news.php")
?>
