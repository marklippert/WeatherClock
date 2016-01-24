<?php
session_start(); 

include_once "config.php";

$json = file_get_contents('http://api.wunderground.com/api/' . $wuapi . '/conditions/q/' . $wploc);
$obj = json_decode($json, true);
if(!is_array($obj)) $obj = $_SESSION['objc'];
$_SESSION['objc'] = $obj;
$cc = $obj['current_observation'];
$icon = pathinfo($cc['icon_url']);
?>

<?php if (time() > ($cc['observation_epoch'] + 3600)) { ?>
<div class="warning">DATA OUT OF DATE - CHECK CONNECTION</div>
<?php } ?>

<div class="two-col">
  <img src="images/<?php echo $icon['filename']; ?>.svg" alt="<?php echo $cc['weather']; ?>" class="icon">
  <?php echo $cc['weather']; ?>
  <div class="temp"><?php echo $cc['temp_f']; ?>&deg;F</div>
  Feels like <?php echo $cc['feelslike_f']; ?>&deg;F
</div>

<?php
$wind_deg = ($cc['wind_degrees'] < 0) ? 0 : $cc['wind_degrees'];
$wind_mph = ($cc['wind_mph'] < 0) ? 0 : $cc['wind_mph'];
$wind_dir = ($cc['wind_mph'] < 0) ? "variable" : "from " . $cc['wind_dir'];
?>
<div class="two-col">
  <div id="wind">
    <div id="windarrow" style="transform: rotate(<?php echo $wind_deg; ?>deg);"></div>
    <?php echo $wind_mph; ?>
  </div>
  Wind <?php echo $wind_dir; ?>

  <div id="dew">
    Humidity <?php echo $cc['relative_humidity']; ?><br>
    Dew Point <?php echo $cc['dewpoint_f']; ?>&deg;F<br>
    Pressure <?php echo $cc['pressure_in'] . "\""; ?>
  </div>
</div>

<div style="clear: both;"></div>

<div class="lastup"><?php echo $cc['observation_time']; ?></div>