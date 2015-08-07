<?php
  session_start();

  if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"]) < 1800)
  {
    // Logged in

    // Posting news
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      if (!isset($_POST["name"]) || $_POST["name"] == ""
      || !isset($_POST["date"])
      || !isset($_POST["location"]) || $_POST["location"] == ""
      || !isset($_POST["description"]) || $_POST["description"] == ""
      || !isset($_POST["time"]))
      {
        echo "You need to fill name, date, time, location, and description.";
        die();
      }

      $name = clean($_POST["name"]);
      $date = clean($_POST["date"]);
      $time = clean($_POST["time"]);
      $location = clean($_POST["location"]);
      $description = clean($_POST["description"]);
      $author = $_SESSION["uid"];

      if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
      }

      include_once 'config.php';

      $query = "INSERT INTO event(name, time, location, description, author_key)
                VALUES ('$name', '$date .' '. $time', '$location', '$description', '$author')";
      $resultText = "";
      if ($result = $mysqli->query($query))
      {
        $resultText = "Event added";
      }
      else
      {
        $resultText = "FAILED TO ADD: " . $mysqli->error;
      }
    }
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

  function clean($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
  <title>Post news</title>
  <link href="../css/base.css" style="text/css" rel="stylesheet">
  <link href="css/post.css" style="text/css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php') ?>
  <div id="content">
    <article class="article">
      <form method="post" action="add_event.php" id="newsform">
        <table>
          <tr> <td><span style="padding: 3px"> Add event: </span></td> </tr>
          <tr>
            <td><input type="text" name="name" placeholder="Event name"></td>
          </tr>
          <tr>
            <td>
              <input type="date" name="date">
              <input type="time" name="time">
            </td>
          </tr>
          <tr>
            <td><input type="text" name="location" placeholder="Location"></td>
          </tr>
          <tr>
            <td><textarea name="description" rows="15" placeholder="Description"></textarea></td>
          </tr>
          <tr>
            <td><input type="submit"></td>
          </tr>
        </table>
      </form>
    </article>
  </div>
</body>
</html>
