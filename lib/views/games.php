<style>
.card img{
    margin-left: -10px;
    width:275px;
    height: 200px;
    text-align: center;
    padding: 10px;
}
</style>

<p><?php echo $message ?></p>

<?php
$user = $user[0];
if ($user['userNo'] == ""){
  echo "<p>Continueing as guest, <a href='/signin'>sign in</a> to earn points!</p>";
}else{
  ?>
  <p style="text-align: center;">Your Score: <?php echo $user['score'];?></p>
  <?php
}
?>
<h2>Select from a game below</h2>
<div class="card" style="background-color:#FF6347;">
  <h3 style="color:white"><img src="lib/views/images/Paper-Toss.jpg"/><a href="/game/1">Recycling Game</a></h3>
  <p></p>
</div>


