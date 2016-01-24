<?php
session_start();

include_once "config.php";

$json = file_get_contents('http://api.wunderground.com/api/' . $wuapi . '/forecast10day/q/' . $wploc);
$obj = json_decode($json, true);
if(!is_array($obj)) $obj = $_SESSION['objf'];
$_SESSION['objf'] = $obj;
$fc = $obj['forecast']['simpleforecast']['forecastday'];

// Show today's forcast if it's before 5:00pm
if (date("G", time()) < 17) {
  $fs = 0; $fe = 6;
} else {
  $fs = 1; $fe = 7;
}

for ($x = $fs; $x < $fe; $x++) {
  $icon = pathinfo($fc[$x]['icon_url']);
?>
  <div class="fc-day">
    <strong><?php echo $fc[$x]['date']['weekday']; ?></strong><br>
    <img src="images/<?php echo $icon['filename']; ?>.svg" alt="<?php echo $fc[$x]['conditions']; ?>"><br>
    <?php echo $fc[$x]['conditions']; ?><br>
    <span class="hi"><?php echo $fc[$x]['high']['fahrenheit']; ?>&deg;</span> | <span class="lo"><?php echo $fc[$x]['low']['fahrenheit']; ?>&deg;</span>
  </div>
<?php } ?>
<div style="clear: both;"></div>