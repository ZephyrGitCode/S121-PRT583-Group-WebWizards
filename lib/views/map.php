<p><?php echo $message ?></p>

<!--<iframe src="https://i.simmer.io/@Henrylllll/cdu-waste-management-map" style="width:350px;height:600px;border:0"></iframe>-->
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
</head>

<div id="map" style = "width:100%; height:580px;color:black;"></div>
<div id='findme'><a href='#'>Find me!</a></div>
<div id='centercdu'><a href='#'>CDU Center</a></div>

<script>
var map;
function initMap() {
  map = new L.Map("map", {
      center: new L.LatLng(-12.37206, 130.86938),
      zoom: 17,
      layers: new L.TileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png")
  });
}
initMap();
setTimeout(function () { map.invalidateSize() }, 800);

//map.addLayer(marker);

function addMarker(latlng, msg="") {
  /*
  // Icon options
  var iconOptions = {
    iconSize: [50, 50]
  }
  // Creating a custom icon
  var customIcon = L.icon(iconOptions);
  */
  var markerOptions = {
    title: "BinLocation",
    clickable: true,
    draggable: true,
    //icon: customIcon
  }
  try {
    var marker = new L.Marker(latlng,markerOptions);
    marker.bindPopup(msg).openPopup();
    marker.addTo(map);
  } catch (error) {
    console.log(error)
  }
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

function onMapClick(e) {
  var msg = "Recently Clicked "+e.latlng.toString();
  alert(msg);
  try {
    addMarker(e.latlng,msg);
    sessionStorage.setItem()
  } catch (error) {
    console.log(error)
  }
}
map.on('click', onMapClick);

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
    var loc = new L.LatLng(-12.37206, 130.86938);
    map.setView(loc, 17, {animation: true}); 
});

</script>
<?php
if(!empty($mapmarkers)){
  $n = 1;
  ?>
  <script>
  //localStorage.clear()
  </script>
  <?php
  foreach($mapmarkers As $marker){
    $bcolour = htmlspecialchars($marker['buildingcolour'],ENT_QUOTES, 'UTF-8');
    $bnum = htmlspecialchars($marker['buildingnum'],ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($marker['type'],ENT_QUOTES, 'UTF-8');
    $lat = htmlspecialchars($marker['lat'],ENT_QUOTES, 'UTF-8');
    $long = htmlspecialchars($marker['long'],ENT_QUOTES, 'UTF-8');
    ?>
    <script>
      //loc = $lat+", "+$long
      //Storage.setItem(<?php echo $n ?>,loc)
      var lat = <?php echo $lat ?>;
      var long = <?php echo $long ?>;
      var bcolour = "<?php echo $bcolour ?>";
      var bnum = "<?php echo $bnum ?>";
      var type = "<?php echo $type ?>";
      if (lat != ""){
        console.log(lat+" "+long);
        var loc = new L.LatLng(lat, long);
        switch(type)
        {
          case "gw":
            type = "General Waste"
            break;
          case "com":
            type = "Co-mingled"
            break;
          case "cardpap":
            type = "Carboard and Paper"
            break;
          case "gwcom":
            type = "General Waste and Co-mingled"
            break;
          case "env":
            type = "Enviro-collective"
            break;
        default:
          type = type
        }
        
        msg = bcolour+" "+bnum+" "+type;
        addMarker(loc,msg)
      }
    </script>
<?php
    $n+=1;
  }
}
?>