<?php
  session_start();

  if (isset($_SESSION["username"]) && isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"]) < 1800)
  {
    echo "User " . $_SESSION["username"] . " logged in.";
    header("Location: index.php");
    die();
  }
  else
  {
    echo "Not logged in.";
  }
  $_SESSION["last_activity"] = time();

  include_once 'config.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($statement = $mysqli->prepare("SELECT username, password, id FROM users WHERE username=? and password=?"))
    {
      $statement->bind_param("ss", $username, $password);
      $statement->execute();
      $statement->bind_result($usr, $pwd, $uid);
      while ($statement->fetch())
      {
        if ($username == $usr && $password == $pwd)
        {
          echo $usr;
          $_SESSION["username"] = $usr;
          $_SESSION["uid"] = $uid;
          echo " set ";
          $_SESSION["last_activity"] = time() + (30 * 60);
          echo $_SESSION["last_activity"];
          $statement->close();
          $mysqli->close();
          header("Location: index.php");
          die();
        }
      }
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link href="../css/base.css" type="text/css" rel="stylesheet">
</head>
<body>
  <div style="top: 0; left: 0; display: table; position: absolute; height: 100%; width: 100%;">
    <div style="display: table-cell; vertical-align: middle">
      <div style="padding: 5px; margin-left: auto; margin-right: auto; width: 150px; background-color: #ffd90f; border-radius: 10px; overflow: hidden;">
        <span style="margin: 0 auto; display: table;"><b>Login</b></span>
        <form method="POST">
          <input type="text" name="username" placeholder="Username" style="display:block; width: 95%; margin: 5px;">
          <input type="password" name="password" placeholder="Password" style="display:block; width: 95%; margin: 5px;">
          <input type="submit" style="display:block; float:right; margin: 6px;">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
