<?php
  session_start();

  if (isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"]) < 1800)
  {
    // Logged in

    // Posting news
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      if (!isset($_POST["title"]) || !isset($_POST["content"]) || !isset($_POST["homerimage"]))
      {
        echo "You need to fill title, content and select a homer image.";
        die();
      }

      $title = clean($_POST["title"]);
      $post = clean($_POST["content"]);
      $author = $_SESSION["uid"];
      $moodimage = clean($_POST["homerimage"]);

      if (!preg_match("/^[a-zA-Z ]*$/", $title)) {
        $nameErr = "Only letters and white space allowed";
      }

      include_once 'config.php';

      $query = "INSERT IGNORE INTO newspost(title, post, author_key, moodimage)
                VALUES ('$title', '$post', '$author', '$moodimage')";
      $resultText = "";
      if ($result = $mysqli->query($query))
      {
        $resultText = "News posted";
      }
      else
      {
        $resultText = "FAILED TO POST: " . $mysqli->error;
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
  <link href="css/base.css" style="text/css" rel="stylesheet">
  <link href="css/post.css" style="text/css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
    <?php include('header.php') ?>
  <div id="content">
      <form method="post" action="post.php" id="newsform">
        <table>
          <tr> <td><span style="padding: 3px"> Post news: </span></td> </tr>
          <tr>
            <td><input type="text" name="title" placeholder="Type your title here."></td>
          </tr>
          <tr>
            <td><textarea name="content" cols="92" rows="15" placeholder="Write your news here."></textarea></td>
          </tr>
          <tr>
            <td>
              <span> Homer Image: </span>
              <select  name="homerimage" class="image-picker show-html">
                <option value="#"> Select a homer </option>
                <option value="img/homer-beer.png">  Beer  </option>
                <option value="img/homer-demand.png">  Demand  </option>
                <option value="img/homer-excited.png">  Excited  </option>
                <option value="img/homer-glasses.png">  Glasses  </option>
                <option value="img/homer-naked.png">  Naked  </option>
                <option value="img/homer-zombie.png">  Zombie  </option>
              </select>
            </td>
          </tr>
        <td>
          <img class="imagepreview" href="#">
        </td>
          <tr>
            <td><input type="submit"></td>
          </tr>
        </table>
      </form>
  </div>
  <script>
  $("select").change(function () {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).val();
    });
    if (str == "#")
    {
      $(".imagepreview").hide();
    }
    else
    {
      $(".imagepreview").show();
      $(".imagepreview").attr("src", str);

    }
  }).change();
  </script>
  <script src="image-picker/image-picker.min.js"></script>
</body>
</html>
