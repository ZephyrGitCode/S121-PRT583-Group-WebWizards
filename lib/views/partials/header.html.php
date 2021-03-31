<header class="navbar">
  <span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>
  <a href="/"><span><img src="https://cdn.pixabay.com/photo/2013/07/12/14/28/bin-148264_960_720.png" width="50px" height="50px"></span></a>
  <!--<h2 class="main-h2">EasyRecci</h2>-->
  <a href="<?php if ($_SESSION['userno'] != ""){echo "/myaccount/{$_SESSION['userno']}";}else{echo "/myaccount/123";}?>"><span class="material-icons usericon">&#xe8a6</span></a>
  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    
    
    <h2 class="form-h2 navforms"><img class="logo-nav" src="https://cdn.pixabay.com/photo/2013/07/12/14/28/bin-148264_960_720.png" width="150px"></h2>
    <hr style="margin-bottom:0;"/>
    <h2 class="form-h2 navforms">Menu SideBar</h2>
    <hr style="margin-bottom:0;"/>
    <div class="navforms forms">
    </div>

    <h2 class="form-h2 navforms">Manage</h2>
    
    <hr style="margin-bottom:0;"/>
    <div class="navforms forms">
    <?php
      if (is_authenticated()){
    ?>
      <a href="<?php if ($_SESSION['userno'] != ""){echo "/myaccount/{$_SESSION['userno']}";}else{echo "/myaccount/123";}?>"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe869</span>My Account</p></a>
      <a href="<?php if ($_SESSION['userno'] != ""){echo "/change/{$_SESSION['userno']}";}else{echo "/change/123";}?>"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Change Password</p></a>
      <a href="/signout"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signout</p></a>
    <?php
        }else{
    ?>
      <a href="/signup"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signup</p></a>
      <a href="/signin"><p><span class="material-icons" style="font-size: 1.6rem;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signin</p></a>
    <?php
      }
    ?>
</header>