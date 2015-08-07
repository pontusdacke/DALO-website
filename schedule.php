<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Project Thought</title>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/schedule.css" type="text/css" rel="stylesheet">
  <link href="css/calendar.css" type="text/css" rel="stylesheet">
  <link href="css/popup.css" type="text/css" rel="stylesheet">


  <script src="js/jquery-2.1.4.min.js"></script>
</head>
<body>
  <div id="content">
    <?php include("header.php"); ?>
    <section class='article'>
      <?php
      include "calendar_class.php";
      $cal = new Calendar('schedule.php');
      $cal->print_cal();

      ?>
      <script>
      $(function() {
          //----- OPEN
          $('[data-popup-open]').on('click', function(e)  {
              var targeted_popup_class = jQuery(this).attr('data-popup-open');
              var value = $( this ).attr("value");
              console.log(value);
              var arr = <?php echo json_encode($cal->events); ?>;
              var currentEvent;

              $.each(arr, function(key, ev){
                if (ev["time"] == value)
                  currentEvent = ev;
              });
              $('#popup-title').text(currentEvent["name"]);
              $('#popup-content').text(currentEvent["description"]);
              $('#popup-time').text("Tid: " + currentEvent["time"].split(' ')[1]);
              $('#popup-location').text("Plats: " + currentEvent["location"]);
              $('[data-popup="' + targeted_popup_class + '"]').fadeIn(10);

              e.preventDefault();
          });

          $(document).keyup(function(e) {
            if (e.keyCode == 27) $('[data-popup-close]').click();   // esc
          });

          //----- CLOSE
          $('[data-popup-close]').on('click', function(e)  {
              var targeted_popup_class = jQuery(this).attr('data-popup-close');
              $('[data-popup="' + targeted_popup_class + '"]').fadeOut(10);

              e.preventDefault();
          });


      });

      </script>
    </section>
  </div>
<div class="popup" data-popup="popup-1">
    <div class="popup-inner">
        <h2 id="popup-title"></h2>
        <p id="popup-time"></p>
        <p id="popup-location"></p>
        <p id="popup-content"></p>
        <p><a data-popup-close="popup-1" href="#">Close</a></p>
        <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
    </div>
</div>
<script src="js/popup.js"></script>
</body>
</html>
