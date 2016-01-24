<?php include_once "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Weather Clock</title>
  <link rel="stylesheet" href="inc/style.css">
  <meta name="viewport" content="width=device-width">
  <script type="text/javascript" src="inc/jquery-1.12.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#current').load('current.php');
      setInterval(function() { $('#current').load('current.php') }, <?php echo $weather_refresh; ?>);
      var radar_width = $("#radar").width();
      var radar_height = $("#radar").height();
      $('#radar').load('radar.php', { rw:radar_width, rh:radar_height, rz:<?php echo $zoom; ?>, ro:<?php echo $lon_offset1; ?> });
      setInterval(function() { $('#radar').load('radar.php', { rw:radar_width, rh:radar_height, rz:<?php echo $zoom; ?>, ro:<?php echo $lon_offset1; ?> }); }, <?php echo $radar_refresh; ?>);
      var radar2_width = $("#radar2").width();
      var radar2_height = $("#radar2").height();
      $('#radar2').load('radar.php', { rw:radar2_width, rh:radar2_height, rz:<?php echo $zoom2; ?>, ro:<?php echo $lon_offset2; ?> });
      setInterval(function() { $('#radar2').load('radar.php', { rw:radar2_width, rh:radar2_height, rz:<?php echo $zoom2; ?>, ro:<?php echo $lon_offset2; ?> }); }, <?php echo $radar_refresh; ?>);
      $('#forecast').load('forecast.php');
      setInterval(function() { $('#forecast').load('forecast.php') }, <?php echo $weather_refresh; ?>);
      $.ajaxSetup({ cache: false });
    });

    function startTime() {
      var today = new Date();

      var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
      var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
      document.getElementById('date').innerHTML = days[today.getDay()] + ", " + months[today.getMonth()] + " " + today.getDate() + ", " + today.getFullYear();

      var h = (today.getHours() + 24) % 12 || 12;
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      var ap = today.getHours() > 11 ? "PM" : "AM";
      document.getElementById('clock').innerHTML = "<div id=\"hour-min\">" + h + ":" + m + "</div><div id=\"sec-ap\">" + s + "<br>" + ap + "</div>";

      var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }
  </script>
</head>
<body onload="startTime()">

<!-- <div style="width: 1024px; height: 600px; outline: 1px solid black;"> -->

<div class="left-col">
  <div id="current"></div>
  <div id="radar"></div>
</div>

<div class="right-col">
  <div id="date"></div>
  <div id="clock"></div>
  <div id="radar2"></div>
  <div id="forecast"></div>
</div>

<!-- </div> -->

</body>
</html>