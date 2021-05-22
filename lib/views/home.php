<p><?php echo $message ?></p>

<style media="screen">
  .card {
    -webkit-box-shadow: 9px 11px 13px 2px rgba(0, 0, 0, 0.54);
    -moz-box-shadow: 9px 11px 13px 2px rgba(0, 0, 0, 0.54);
    box-shadow: 9px 11px 13px 2px rgba(0, 0, 0, 0.54);
  }
</style>

<div class="input-icons">
  <div class="card" id="home-card" style="background-color:rgb(207, 41, 91);">
    <a style="color:white" href="/map"><h2><span class="glyphicon glyphicon-map-marker"></span></h2>
    <p style="left: 10;">Map</p><p>Want to find the nearest Bin?</p></a>
  </div>

  <div class="card" id="home-card" style="background-color:rgb(20 148 11);">
    <a style="color:white" href="/waste_classification">
    <h2><span class="glyphicon glyphicon-trash"></span></h2>
    <p style="left: 10;">Waste Classification</p><p>Where's that item go?</p></a>
  </div>

  <div class="card" id="home-card" style="background-color:rgb(153, 29, 224);">
    <a style="color:white" href="/leaderboard"><h2><span class="glyphicon glyphicon-equalizer"></span></h2>
    <p style="left: 10;">Leaderboard</p><p>Who's toping the charts?</p></a>
  </div>

  <div class="card" id="home-card" style="background-color:rgb(193, 29, 2);">
    <a style="color:white" href="/activities"><span class="material-icons">flaky</span> <span class="material-icons" style="font-size: 24px;">gamepad</span>
    <p style="left: 10;">Activities</p><p>Quizes and games!</p></a>
  </div>
</div>