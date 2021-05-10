<p><?php echo $message;?></p>

<!--<iframe src="https://i.simmer.io/@Henrylllll/cdu-waste-management-map" style="width:350px;height:600px;border:0"></iframe>-->
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <script type="text/javascript" src="../lib/views/css/dropdowns/jquery.js"></script>
    <script type="text/javascript" src="../lib/views/css/dropdowns/awselect.js"></script>
  <!--pop up style start-->
  <sytle>
    mapPopUpOverlay {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(0, 0, 0, 0.7);
      transition: opacity 500ms;
      visibility: hidden;
      opacity: 0;
      z-index: 15;
    }

    mapPopUpOverlay:target {
      visibility: visible;
      opacity: 1;

    }

    mapPopUpMain {
      margin: 100px auto;
      padding: 20px;
      background: #fff;
      border-radius: 5px;
      width: 300px;
      position: relative;
    }

    mapPopUpMain mapPopUpClose {
      position: absolute;
      top: 20px;
      right: 20px;
      transition: all 200ms;
      font-size: 30px;
      font-weight: bold;
      text-decoration: none;
      color: black;
    }

    mapPopupOutClose {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      transition: all 200ms;
      font-size: 30px;
      opacity: 0;
    }

    mapPopUpMain mapPopUpClose:hover {
      color: red;
    }
    mapPopUpMain mapPopUpContent {
      max-height: 30%;
      overflow: auto;
    }
   </style>
   <!--pop up style end-->
</head>

<!--Pop up information start-->
<a width="50px" height="50px" href="#mapPopUp">&#8505;</a>
<div id="mapPopUp" class="mapPopUpOverlay">
      <a class="mapPopupOutClose" href="#"></a>
      <div class="mapPopUpMain">
        <h2>Map information title</h2>
        <a class="mapPopUpClose" href="#">&times;</a>
        <div class="mapPopUpContent">
          <p>map information content</p>
        </div>
      </div>
    </div>
<!--pop up information end-->

<div id="map" style="z-index:1;height:400px;color:black;"></div>
<div class="mapbtns">
  <button class="btn btn-primary mapbtn" id='findme'>Find me!</button>
  <button class="btn btn-primary mapbtn" id='centercdu'>CDU Center</button>
</div>

<?php
$user = $user[0];
// if user is not empty
if(!empty($user) && $user['isadmin'] == 1){
?>
<form action="/addbin" method='POST'>
  <input type='hidden' name='_method' value='post' />

  <p class="acctext">Bin Position:</p>
  <div class="inputBox">
      <input type="text" name="latlng" id="latlng">
  </div>
 
  <select id="btype" name="btype" data-placeholder="Select a bin Type">
    <option value="gw">General Waste</option>
    <option value="com">Co-mingled</option>
    <option value="cardpap">Cardboard And Paper</option>
    <option value="env">Enviro-Collective</option>
  </select>

  <select id="bcolour" name="bcolour" data-placeholder="Select a building colour">
    <option value="Red">Red</option>
    <option value="Orange">Orange</option>
    <option value="Green">Green</option>
    <option value="Blue">Blue</option>
    <option value="Yellow">Yellow</option>
    <option value="Pink">Pink</option>
    <option value="Purple">Purple</option>
    <option value="Brown">Brown</option>
  </select>

  <input type="hidden" id="latValue" name="latValue" value="" />
  <input type="hidden" id="lngValue" name="lngValue" value="" />

  <select id="bnum" name="bnum" data-placeholder="Select a building number">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
  </select>
  <br/>
  <input type="submit" name="submit" value="Add Single Bin">
</form>
<?php
}
?>

<br/>
<br/>
<br/>
<br/>
<br/>

<script>
$(document).ready(function(){ 
     $("select").awselect();
});

/*
document.getElementById('btype').addEventListener('change', updateinputbtype);

function updateinputbtype(evt) {
  var x = document.getElementById("btype");
  console.log(x.value);
  document.getElementByName(id).value=x.value;
}
*/

function updateinputbnum(evt) {
  var x = document.getElementById("bnum");
  console.log(x.value);
  document.getElementByName(id).value=x.value;
}

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

function addMarker(latlng, msg="",icon = "") {
  if (icon != ""){
    var markerOptions = {
      title: "BinLocation",
      clickable: true,
      draggable: false,
      icon: icon
    }
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

function onMapClick(e) {
  var msg = "Recently Clicked "+e.latlng.toString();
  alert(msg);
  try {
    addMarker(e.latlng,msg);
    sessionStorage.setItem("binloc",e.latlng.toString());
    document.getElementById("latValue").value = e.latlng.lat;
    document.getElementById("lngValue").value = e.latlng.lng;
    addBin();
  } catch (error) {
    console.log(error)
  }
}
<?php
$user = $user[0];
// if user is not empty
if(!empty($user) && $user['isadmin'] == 1){
?>
  map.on('click', onMapClick);
<?php
}
?>


function addBin(){
  var latlng = sessionStorage.getItem("binloc");
  document.getElementById("latlng").value = latlng;
}

if("geolocation" in navigator)
{

} else {

}
navigator.geolocation.getCurrentPosition(
    function(position) {
        console.log(position);
        console.log('latitude: ${position.coords.latitude}, longitude:${position.coords.longitude}');
        var loc = new L.LatLng(position.coords.latitude, position.coords.longitude);
        addMarker(loc,"You are here");
    }
)

$('#findme').on('click', function() {
  locateUser();
});

$('#centercdu').on('click', function() {
    var loc = new L.LatLng(-12.37206, 130.86938);
    map.setView(loc, 17, {animation: true}); 
});

</script>
<?php
// Unoptimized code, solution idea: save $mapmarkers to a javascript variable and iterate through in JS rather than PHP.
if(!empty($mapmarkers)){
  $n = 1;
  foreach($mapmarkers As $marker){
    $bcolour = htmlspecialchars($marker['buildingcolour'],ENT_QUOTES, 'UTF-8');
    $bnum = htmlspecialchars($marker['buildingnum'],ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($marker['btype'],ENT_QUOTES, 'UTF-8');
    $lat = htmlspecialchars($marker['lat'],ENT_QUOTES, 'UTF-8');
    $long = htmlspecialchars($marker['lng'],ENT_QUOTES, 'UTF-8');
    ?>
    <script>
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
            var myIcon = L.icon({
              iconUrl: '../lib/views/images/garbagered.png',
              iconSize: [20, 20]
            });
            break;
          case "com":
            type = "Co-mingled"
            var myIcon = L.icon({
              iconUrl: '../lib/views/images/com.png',
              iconSize: [20, 20]
            });
            break;
          case "cardpap":
            type = "Carboard and Paper"
            var myIcon = L.icon({
              iconUrl: '../lib/views/images/cardpap.png',
              iconSize: [20, 20]
            });
            break;
          case "gwcom":
            type = "General Waste and Co-mingled"
            var myIcon = L.icon({
              iconUrl: '../lib/views/images/gwcom.png',
              iconSize: [20, 20]
            });
            break;
          case "env":
            type = "Enviro-collective"
            var myIcon = L.icon({
              iconUrl: '../lib/views/images/green2.png',
              iconSize: [20, 20]
            });
            break;
        default:
          type = type
        }
        
        msg = bcolour+" "+bnum+" "+type;
        addMarker(loc,msg,myIcon)
      }
    </script>
<?php
    $n+=1;
  }
}
?>