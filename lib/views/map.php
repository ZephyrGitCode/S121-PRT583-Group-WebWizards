<p><?php echo $message ?></p>

<!--<iframe src="https://i.simmer.io/@Henrylllll/cdu-waste-management-map" style="width:350px;height:600px;border:0"></iframe>-->
<head>
   <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
   <script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
</head>

<div id = "map" style = "width:900px; height:580px;"></div>
<div id='findme'><a href='#'>Find me!</a></div>
<div id='centercdu'><a href='#'>CDU Center</a></div>



<script>
var map;
function initMap() {
  map = new L.Map("map", {
      center: new L.LatLng(-12.37, 130.8730),
      zoom: 17,
      layers: new L.TileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png")
  });
}

function addMarker(lat, lng) {
  var marker = new L.Marker(new L.LatLng(lat, lng));
  marker.bindPopup("You are here");
  map.addLayer(marker);
  return marker;
}

function moveMarker(marker, lat, lng) {
  var newLatLng = new L.LatLng(lat, lng);
  marker.setLatLng(newLatLng);
  return marker;
}

function locateUser() {
  this.map.locate({
    setView: true
  });
}

function locateCenter() {
  this.map.locate({
    setView: true
  });
}

// Icon options
var iconOptions = {
    iconUrl: 'logo.png',
    iconSize: [50, 50]
}
// Creating a custom icon
var customIcon = L.icon(iconOptions);

// Creating Marker Options
var markerOptions = {
    title: "MyLocation",
    clickable: true,
    draggable: true,
    icon: customIcon
}
// Creating a Marker
var marker = L.marker([17.438139, 78.395830], markerOptions);

initMap();

if("geolocation" in navigator)
{

} else {

}
navigator.geolocation.getCurrentPosition(
    function(position) {
        console.log(position);
        console.log('latitude: ${position.coords.latitude}, longitude:${position.coords.longitude}');
        addMarker(position.coords.latitude,position.coords.longitude);
    }
)

$('#findme').find('a').on('click', function() {
  locateUser();
});

$('#centercdu').find('a').on('click', function() {
    var loc = new L.LatLng(-12.37, 130.8730);
    map.setView(loc, 17, { animation: true }); 
});
</script>