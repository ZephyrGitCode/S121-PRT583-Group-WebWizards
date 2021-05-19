<style>
.card img{
  text-align: center;
  padding: 10px;
  margin: auto;
}
.btn {
  font-size: 14px;
}
</style>

<?php
$user = $user[0];
if ($user['userNo'] == ""){
  echo "<p>Continuing as guest, <a href='/signin'>sign in</a> to earn points!</p>";
}else{
  ?>
  <p style="text-align: center;">Your Score: <?php echo $user['totalscore'];?></p>
  <?php
}
?>
<h2>Start earning points from an activity below!</h2>

<div class="card" style="background-color:#232d35;">
  <img class="" src="lib/views/images/quizimg.jpeg" alt="Quiz image" width="200px" height="150px" style="border-radius:20px;">
  <div class="card-body">
    <h3 class="card-title">Quizes</h3>
    <p class="card-text">Do you know where all the items belong?</p>
    <a href="/quiz" class="btn btn-primary">Quiz Time!</a>
  </div>
</div>

<div class="card" style="background-color:#232d35;">
  <img class="" src="lib/views/images/Paper-Toss.jpg" alt="Paper Toss img" width="150px" height="150px" style="border-radius:20px;">
  <div class="card-body">
    <h3 class="card-title">Paper Toss</h3>
    <p class="card-text">How many can you land?</p>
    <a href="/game/1" class="btn btn-primary">Paper Toss!</a>
  </div>
</div>


