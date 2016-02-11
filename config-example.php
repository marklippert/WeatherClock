<?php
date_default_timezone_set("America/Chicago"); // Your time zone (http://php.net/manual/en/timezones.php)

$wuapi = "YOUR_WEATHER_UNDERGROUND_API"; // Your Weather Underground API (free to sign-up - http://www.wunderground.com/weather/api/)
$wploc = "pws:KWIMILWA44.json"; // JSON (or XML) of your weather location (can be lat/lon, PWS, zip code, state/city)

$lat = "43.0615430"; // Your latitude
$lon = "-87.8994390"; // Your longitude
$lon_offset1 = "-0.15"; // Shift marker left or right on radar 1
$lon_offset2 = "0"; // Shift marker left or right on radar 2
$zoom = 10; // Zoom level of radar 1
$zoom2 = 5; // Zoom level of radar 2

$current_refresh = 15 * 60000; // minutes multiplied by 60000 (milliseconds per minute)
$radar_refresh = 10 * 60000; // minutes multiplied by 60000 (milliseconds per minute)
$forecast_refresh = 60 * 60000; // minutes multiplied by 60000 (milliseconds per minute)
?>