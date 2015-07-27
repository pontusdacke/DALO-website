<?php
  function build_calendar($month,$year, $url)
  {
    $today_day = ltrim(date("d"), '0');

    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Monday','Tuesday','Wednessday','Thursday','Friday','Saturday', 'Sunday');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    // How many days does this month contain?
    $numberDays = date('t',$firstDayOfMonth);

    // Retrieve some information about the first day of the month in question.
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the month in question.
    $dayOfWeek = $dateComponents['wday'] - 1;
    if ($dayOfWeek < 0)
    {
      $dayOfWeek = 6;
    }

    // Month counter for browsing dates
    $mCounter = 0;
    if (isset($_GET["m"]))
    {
      $mCounter = $_GET["m"];
    }
    $mLeft = $mCounter-1;
    $mRight = $mCounter+1;

    // Create the table tag opener and day headers
    $calendar = "<table class='calendar'>";
    $calendar .= "<header id='calHeader'>";
    $calendar .= "<span><a href='$url?m=$mLeft'><img src='img/left.png'></a> <span id='calCaption'>$monthName $year</span> <a href='$url?m=$mRight'><img src='img/left.png' id='reverse'></a></span>";
    $calendar .= "</header>";
    $calendar .= "<tr>";

    // Create the calendar headers
    foreach($daysOfWeek as $day)
    {
      $calendar .= "<th class='header'>$day</th>";
    }

    // Create the rest of the calendar
    // Initiate the day counter, starting with the 1st.
    $currentDay = 1;
    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.
    if ($dayOfWeek > 0)
    {
      $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($currentDay <= $numberDays)
    {
      // Seventh column (Saturday) reached. Start a new row.
      if ($dayOfWeek == 7)
      {
        $dayOfWeek = 0;
        $calendar .= "</tr><tr>";
      }
      $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
      $date = "$year-$month-$currentDayRel";

      // Connect to database for events
      include("expert/config.php");
      include_once("event_class.php");

      // Create query. Get event where date in column 'time' = this iteration
      $query = "SELECT * FROM event WHERE DATE(time) = '$year-$month-$currentDayRel'";

      // Fetch Events
      $eventArray = array();
      if ($result = $mysqli->query($query))
      {
          while ($row = $result->fetch_row())
          {
            $myEvent = new Event($row[0], $row[1], $row[2], $row[3], $row[4]);
            array_push($eventArray, $myEvent);
          }
          $result->close();
      }

      // Add the <td>
      $calendar .= "<td class='day'";
      if ($currentDayRel == $today_day && $month == getdate()["mon"] && $year == getdate()["year"])
      {
        $calendar .= "id='today_date'";
      }
      $calendar .= "rel='$date'><p>$currentDay</p>";

      // Add the event
      foreach ($eventArray as $ev)
      {
        $calendar .= "<span class='event'>";
        $calendar .= "$ev->name";
        $calendar .= "</span>";
      }
      $calendar .= "</td>";

      // Increment counters
      $currentDay++;
      $dayOfWeek++;
    }

    // Complete the row of the last week in month, if necessary
    if ($dayOfWeek != 7)
    {
      $remainingDays = 7 - $dayOfWeek;
      $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }
    $calendar .= "</tr>";
    $calendar .= "</table>";
    return $calendar;
  }
?>
