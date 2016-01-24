<?php
include_once "config.php";
include_once "mercator.php";

$lon_marker = $lon;
$lon = (!empty($_POST['ro'])) ? ($lon + $_POST['ro']) : $lon;
$rw = (!empty($_POST['rw'])) ? $_POST['rw'] : 350;
$rh = (!empty($_POST['rh'])) ? $_POST['rh'] : 350;
$rz = (!empty($_POST['rz'])) ? $_POST['rz'] : $zoom;

$center = new G_LatLng($lat, $lon);
$corners = getCorners($center, $rz, $rw, $rh);
?>
<div style="width: <?php echo $rw; ?>px; height: <?php echo $rh; ?>px; background: url(https://maps.googleapis.com/maps/api/staticmap?maptype=hybrid&center=<?php echo $lat; ?>,<?php echo $lon; ?>&zoom=<?php echo $rz; ?>&size=<?php echo $rw; ?>x<?php echo $rh; ?>&markers=size:small|color:red|<?php echo $lat; ?>,<?php echo $lon_marker; ?>) center center no-repeat;">
  <img src="http://api.wunderground.com/api/<?php echo $wuapi; ?>/radar/image.gif?maxlat=<?php echo $corners['N']; ?>&maxlon=<?php echo $corners['E']; ?>&minlat=<?php echo $corners['S']; ?>&minlon=<?php echo $corners['W']; ?>&width=<?php echo $rw; ?>&height=<?php echo $rh; ?>&newmaps=0&timelabel=1&timelabel.x=0&timelabel.y=13&rainsnow=1&smooth=1&reproj.automerc=1&noclutter=1&bs=<?php echo time(); ?>" onerror="this.style.display='none'">
</div>