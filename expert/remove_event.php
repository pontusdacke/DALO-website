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
  include("../event_class.php");
  include("config.php");

  $query = "SELECT * FROM event ORDER BY id DESC";

  $eventArray = array();
  if ($result = $mysqli->query($query))
  {
      while ($row = $result->fetch_row())
      {
        $myEvent = new Event($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
        array_push($eventArray, $myEvent);
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
      echo "<tr> <th>Name</th> <th>Date</th> <th></th> </tr>";
      foreach ($eventArray as $event)
      {
        $color = "#ffffff";
        if ($counter % 2 == 0)
        {
          $color = "#dddddd";
        }
        $counter++;
        echo "<tr bgcolor=" . $color .">";
        echo "<td>" . $event->name . "</td>";
        echo "<td>" . $event->time . "</td>";
        echo "<td><a onclick='if(window.confirm(\"Delete?\")){window.location.replace(\"delete_event.php?id=$event->id\", \"Deleted!\");}'>";
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
