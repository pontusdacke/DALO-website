<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
  <title>Manage content</title>
<link href="../css/base.css" style="text/css" rel="stylesheet">
<link href="css/manage.css" style="text/css" rel="stylesheet">
</head>
<body>

<?php
  include("../newspost_class.php");
  include("config.php");

  $query = "SELECT * FROM newspost ORDER BY id DESC";

  $postArray = array();
  if ($result = $mysqli->query($query))
  {
      while ($row = $result->fetch_row())
      {
        $myPost = new NewsPost($row[0], $row[1], $row[2], $row[3], $row[4]);
        array_push($postArray, $myPost);
      }
      $result->close();
  }
?>
<?php include('header.php') ?>
  <div id="content">
    <article class="article">
    <?php
      $counter = 0;
      echo "<table>";
      echo "<tr> <th>News title</th> <th></th> </tr>";
      foreach ($postArray as $post)
      {
        $color = "#ffffff";
        if ($counter % 2 == 0)
        {
          $color = "#dddddd";
        }
        $counter++;
        echo "<tr bgcolor=" . $color .">";
        echo "<td width='500px'>" . $post->title . "</td>";
        echo "<td><a onclick='if(window.confirm(\"Delete?\")){window.location.replace(\"delete_news.php?id=$post->id\", \"Deleted!\");}'>";
        echo "<img src='img/delete-icon.png' alt='delete'>";
        echo "</a></td>";
        echo "</tr>";
      }
      echo "</table>";
    $mysqli->close();
    ?>
  </article>
  </div>
</body>
</html>
