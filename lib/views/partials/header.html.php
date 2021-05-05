<?php
if ($_SESSION['userno'] != ""){$userno = $_SESSION['userno'];}?>
<style>
.nav2 {
  display:grid;
  grid-template-columns: auto auto;
}
</style>
<header class="navbar">
  <!--<span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>-->
  <a href="/"><span><img src="https://cdn.pixabay.com/photo/2013/07/12/14/28/bin-148264_960_720.png" width="50px" height="50px"></span></a>
  <h2 class="main-h2">CDU WasteAware</h2>
  <a href="<?php if ($userno != ""){echo "/myaccount/{$userno}";}else{echo "/myaccount/123";}?>"><span class="material-icons" style="font-size:32px;color:<?php if ($userno != ""){echo "#fff";}else{echo "#b6b1a6";}?>;">account_circle</span></a>
  <!--
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    
    
    <h2 class="form-h2 navforms"><img class="logo-nav" src="https://cdn.pixabay.com/photo/2013/07/12/14/28/bin-148264_960_720.png" width="150px"></h2>

    <h2 class="form-h2 navforms">Manage</h2>
    
    <hr style="margin-bottom:0;"/>
    <div class="navforms forms">
    <?php
      if (is_authenticated()){
    ?>
      <a href="<?php if ($_SESSION['userno'] != ""){echo "/myaccount/{$_SESSION['userno']}";}else{echo "/myaccount/123";}?>"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe869</span>My Account</p></a>
      <a href="<?php if ($_SESSION['userno'] != ""){echo "/change/{$_SESSION['userno']}";}else{echo "/change/123";}?>"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Change Password</p></a>
      <a href="/signout"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signout</p></a>
      </div>
      <h2 class="form-h2 navforms">Navigation</h2>
        <div class="nav2">
        <a href="/" style="width: 85%; color: #007a87;"><span class="material-icons" style="font-size: 3rem;">home</span><p style="margin: auto; font-size: 1.2rem;">Home</p></a>
        <a href="/map_main" style="width: 85%; color: #007a87;"><span class="material-icons" style="font-size: 3rem;">location_on</span><p style="margin: auto; font-size: 1.2rem;">Bins</p></a>
        <a href="/leaderboard" style="width: 85%; color: #007a87;"><span class="material-icons" style="font-size: 3rem;">equalizer</span><p style="margin: auto; font-size: 1.2rem;">Leaderboard</p></a>
        <a href="/all_rubbish" style="width: 85%; color: #007a87;"><span class="material-icons" style="font-size: 3rem;">auto_delete</span><p style="margin: auto; font-size: 1.2rem;">Waste Items</p></a>
        </div>
    <?php
        }else{
    ?>
      <a href="/signup"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signup</p></a>
      <a href="/signin"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signin</p></a>
    <?php
      }
    ?>
    -->
</header>