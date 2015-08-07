<!DOCTYPE html>
<html lang="se">
<head>
  <meta charset="utf-8">
  <title>Project Thought</title>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <?php include 'simpson/simpson-css.php' ?>
  <script src="js/jquery-2.1.4.min.js"></script>
</head>
<body>
  <?php
  include("header.php");
  include("newspost_class.php");
  include("expert/config.php");

  $count = 5; // Standard news count
  if (isset($_GET["count"]))
  {
    $count = $_GET["count"];
  }

  $query = "SELECT * FROM newspost ORDER BY id DESC LIMIT " . $count;

  $postArray = array();
  if ($result = $mysqli->query($query))
  {
      while ($row = $result->fetch_row())
      {
        $myPost = new NewsPost($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
        array_push($postArray, $myPost);
      }
      $result->close();
  }

  ?>
  <section id="content">
    <?php
      /* Print X number of news */
        if (empty($postArray))
        {
          echo "<article class='article'> ";
          echo "<header><h2>No news!</h2></header>";
          echo "<span>There is nothing here...</span><br><br>";
          echo "</article>";
        }
        else
        {
          foreach ($postArray as $post)
          {
            $phpdate = strtotime(  $post->datePosted );
            $mysqldate = date( 'Y-m-d H:i', $phpdate );

            echo "<article class='article'> ";
            if ($post->moodImageUrl != "#")
              echo "<img src=" . $post->moodImageUrl ." alt='A homer mood image'>";
            else
            {
              echo "<div class='simpson'>";
              include 'simpfunc.php';
              getSimpById(0);
              echo "</div>";
            }

            echo "<h2 class='articleTitle'>" . $post->title . "</h2>";
            echo "<p class='articleDate'>" . $mysqldate . "</p>";
            echo "<span class='articleContent'>" . $post->post . "</span>";
            echo "<p class='articleAuthor'>Skriven av: " . ucwords($post->author) . "</p>";
            echo "</article>";
          }
        }

      $mysqli->close();
    /* Print X number of news end*/

    /* Calculate more news-count */
      $count = 10; // Standard news count
      if (isset($_GET["count"]))
      {
        $count = $_GET["count"] + 5;
      }
    /* Calculate more news-count end*/
    ?>
  <p><a href="index.php?count=<?php echo $count;?>">Mer nyheter...</a></p>
  </section>

</body>
</html>
