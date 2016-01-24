<?php
// From http://stackoverflow.com/questions/12507274/how-to-get-bounds-of-a-google-static-map
// USAGE
// $centerLat = 49.141404;
// $centerLon = -121.960988;
// $zoom = 10;
// $mapWidth = 640;
// $mapHeight = 640;
// $centerPoint = new G_LatLng($centerLat, $centerLon);
// $corners = getCorners($centerPoint, $zoom, $mapWidth, $mapHeight);
// $mapURL = "http://maps.googleapis.com/maps/api/staticmap?center={$centerLat},{$centerLon}&zoom={$zoom}&size={$mapWidth}x{$mapHeight}&scale=2&maptype=roadmap&sensor=false";

define("MERCATOR_RANGE", 256);

function degreesToRadians($deg) {
  return $deg * (M_PI / 180);
}

function radiansToDegrees($rad) {
  return $rad / (M_PI / 180);
}

function bound($value, $opt_min, $opt_max) {
  if ($opt_min != null) $value = max($value, $opt_min);
  if ($opt_max != null) $value = min($value, $opt_max);
  return $value;
}

class G_Point {
    public $x,$y;
    function G_Point($x=0, $y=0){
        $this->x = $x;
        $this->y = $y;
    }
}

class G_LatLng {
    public $lat,$lng;
    function G_LatLng($lt, $ln){
        $this->lat = $lt;
        $this->lng = $ln;
    }
}

class MercatorProjection {

    private $pixelOrigin_, $pixelsPerLonDegree_, $pixelsPerLonRadian_;

    function MercatorProjection() {
      $this->pixelOrigin_ = new G_Point( MERCATOR_RANGE / 2, MERCATOR_RANGE / 2);
      $this->pixelsPerLonDegree_ = MERCATOR_RANGE / 360;
      $this->pixelsPerLonRadian_ = MERCATOR_RANGE / (2 * M_PI);
    }

    public function fromLatLngToPoint($latLng, $opt_point=null) {
      $me = $this;

      $point = $opt_point ? $opt_point : new G_Point(0,0);

      $origin = $me->pixelOrigin_;
      $point->x = $origin->x + $latLng->lng * $me->pixelsPerLonDegree_;
      // NOTE(appleton): Truncating to 0.9999 effectively limits latitude to
      // 89.189.  This is about a third of a tile past the edge of the world tile.
      $siny = bound(sin(degreesToRadians($latLng->lat)), -0.9999, 0.9999);
      $point->y = $origin->y + 0.5 * log((1 + $siny) / (1 - $siny)) * -$me->pixelsPerLonRadian_;
      return $point;
    }

    public function fromPointToLatLng($point) {
      $me = $this;

      $origin = $me->pixelOrigin_;
      $lng = ($point->x - $origin->x) / $me->pixelsPerLonDegree_;
      $latRadians = ($point->y - $origin->y) / -$me->pixelsPerLonRadian_;
      $lat = radiansToDegrees(2 * atan(exp($latRadians)) - M_PI / 2);
      return new G_LatLng($lat, $lng);
    }

    //pixelCoordinate = worldCoordinate * pow(2,zoomLevel)
}

function getCorners($center, $zoom, $mapWidth, $mapHeight){
    $scale = pow(2, $zoom);
    $proj = new MercatorProjection();
    $centerPx = $proj->fromLatLngToPoint($center);
    $SWPoint = new G_Point($centerPx->x-($mapWidth/2)/$scale, $centerPx->y+($mapHeight/2)/$scale);
    $SWLatLon = $proj->fromPointToLatLng($SWPoint);
    $NEPoint = new G_Point($centerPx->x+($mapWidth/2)/$scale, $centerPx->y-($mapHeight/2)/$scale);
    $NELatLon = $proj->fromPointToLatLng($NEPoint);
    return array(
        'N' => $NELatLon->lat,
        'E' => $NELatLon->lng,
        'S' => $SWLatLon->lat,
        'W' => $SWLatLon->lng,
    );
}
?>