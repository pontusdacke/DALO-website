<?php

class Calendar
{
  public $events;
  public $year;
  public $month;
  public $url;

  function __construct($inUrl = null)
  {
    $this->year = getdate()['year'];
    if (isset($_GET["m"]))
    {
      $this->month = getdate()['mon'] + $_GET["m"];
      $this->year += floor(($this->month-1) / 12);
      $this->month = $this->month % 12;
    }
    else
    {
      $this->month = getdate()['mon'];
    }

    if (!empty($inUrl)) $this->url = $inUrl;
    else
    {
      echo "no url in calendar class. shame on you";
      die();
    }
    $events = array();

    // Create query. Get event where date in column 'time' = this iteration
    $query = "SELECT * FROM event";
    include "expert/config.php";
    include_once("event_class.php");
    // Fetch Events
    if ($result = $mysqli->query($query))
    {
        while ($row = $result->fetch_row())
        {
          $myEvent = new Event($row[0], $row[1], $row[2], $row[3], $row[4]);
          $this->events[$row[0]] = $myEvent;
        }
        $result->close();
    }
    $mysqli->close();
  }

  function get_event_description($date)
  {
    $arr = array();
    foreach ($this->events as $key => $ev)
    {
      if (date("Y-m-d", strtotime($ev->time)) == $date)
      {
        array_push($arr, $ev);
      }
    }
    return $arr;
  }

  function print_cal()
  {
    /* Useful variables */
    // Todays day.
    $today_day = ltrim(date("d"), '0');
    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Monday','Tuesday','Wednessday','Thursday','Friday','Saturday', 'Sunday');
    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0,0,0,$this->month,1,$this->year);
    // How many days does this month contain?
    $numberDays = date('t',$firstDayOfMonth);
    // Retrieve some information about the first day of the month in question.
    $dateComponents = getdate($firstDayOfMonth);
    // What is the name of the month in question?
    $monthName = $dateComponents['month'];
    // What is the index value (0-6) of the first day of the month in question.
    $dayOfWeek = $dateComponents['wday'] - 1; // -1 to start on monday
    // if case to start on monday instead of sunday.
    if ($dayOfWeek < 0) { $dayOfWeek = 6; }

    /* Print header and link arrows */
    // Month counter for browsing dates
    $monthOffset = 0;
    if (isset($_GET["m"]))
    {
      $monthOffset = $_GET["m"];
      $this->month + $_GET["m"];
    }

    $mLeft = $monthOffset-1;
    $mRight = $monthOffset+1;
    // Create the table tag opener and day headers
    $calendar = "<table class='calendar'>";
    $calendar .= "<header id='calHeader'>";
    $calendar .= "<span><a href='$this->url?m=$mLeft'><img src='img/left.png'></a> <span id='calCaption'>$monthName $this->year</span> <a href='$this->url?m=$mRight'><img src='img/left.png' id='reverse'></a></span>";
    $calendar .= "</header>";
    $calendar .= "<tr>";
    // Create the calendar headers
    foreach($daysOfWeek as $day)
    {
      $calendar .= "<th class='header'>$day</th>";
    }

    /* Print rest of calender */
    // Initiate the day counter, starting with the 1st.
    $currentDay = 1;
    $calendar .= "</tr><tr>";
    // The variable $dayOfWeek is used to ensure that the calendar
    // display consists of exactly 7 columns.
    if ($dayOfWeek > 0) { $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; }

    $this->month = str_pad($this->month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays)
    {
      // Seventh column (Saturday) reached. Start a new row.
      if ($dayOfWeek == 7)
      {
        $dayOfWeek = 0;
        $calendar .= "</tr><tr>";
      }
      $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
      $date = "$this->year-$this->month-$currentDayRel";
      // Add the <td>
      $calendar .= "<td class='day'";
      if ($currentDayRel == $today_day && $this->month == getdate()["mon"] && $this->year == getdate()["year"])
      {
        $calendar .= "id='today_date'";
      }
      $calendar .= "rel='$date'><p>$currentDay</p>";

      // Add the event
      if (isset($this->events))
      {
        foreach ($this->events as $key => $ev)
        {
          $currentDate = $this->year . "-" . $this->month . "-" . "$currentDayRel";
          if (date("Y-m-d", strtotime($currentDate)) == date("Y-m-d", strtotime($ev->time)))
          {
            $calendar .= "<span class='event'>";
            $calendar .= "<a class='btn' data-popup-open='popup-1' value='$ev->time' href='#'>";
            $calendar .= $this->events[$key]->name;
            $calendar .= "</a>";
            $calendar .= "</span>";
          }
        }
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
    echo $calendar;
  }
}

?>
