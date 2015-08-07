<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Project Thought</title>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/statutes.css" type="text/css" rel="stylesheet">

  
  <script src="js/jquery-2.1.4.min.js"></script>
</head>
<body>
  <div id="content">
    <?php include("header.php"); ?>
    <section class='article'>
      <?php
      $file = file_get_contents('data/statutes.txt', FILE_USE_INCLUDE_PATH);
      echo $file;
      ?>
    </section>
  </div>
</body>
</html>
