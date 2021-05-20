<?php
if ($_SESSION['userno'] != ""){$userno = $_SESSION['userno'];}?>
<style>
.nav2 {
  display:grid;
  grid-template-columns: auto auto;
}
</style>
<header class="navbar">
  <a href="/"><span><img src="lib/views/images/cdulogo.png" width="50px" height="50px"></span></a>
  <!--
  <a href="#mapPopUp"><img width="40px" height="40px" src="../lib/views/images/popupinforicon.png"></a>
  <div id="mapPopUp" class="mapPopUpOverlay">
    <a class="mapPopupOutClose" href="#"></a>
    <div class="mapPopUpMain">
      <h2 style="color:black">Map Page</h2>
      <a class="mapPopUpClose" href="#">&times;</a>
      <div class="mapPopUpContent">
        <p style="color:black">Here you can explore the bins available at CDU, see the legend below</p>
      </div>
    </div>
  </div>-->
  <h2 class="main-h2">CDU WasteAware</h2>
  <a href="<?php if ($userno != ""){echo "/myaccount/{$userno}";}else{echo "/myaccount/123";}?>"><span class="material-icons" style="font-size:32px;color:<?php if ($userno != ""){echo "#fff";}else{echo "#b6b1a6";}?>;">account_circle</span></a>
</header>