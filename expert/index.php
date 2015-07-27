<?php
  session_start();

  if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"]) < 1800)
  {
    // Logged in
  }
  else
  {
    session_unset();
    session_destroy();
    echo "You are not logged in. Your IP has been stored.";
    header("Location: login.php");
    die();
  }
  $_SESSION["last_activity"] = time();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
  <title>Admin panel</title>
  <link href="css/base.css" style="text/css" rel="stylesheet">
</head>
<body>
  <div id="content">
    <?php include('header.php') ?>

  </div>
</body>
</html>
