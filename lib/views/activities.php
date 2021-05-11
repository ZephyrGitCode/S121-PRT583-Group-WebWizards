<style>
.card img{
    margin-left: -10px;
    text-align: center;
    padding: 10px;
}
</style>

<p><?php echo $message ?></p>

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

<div class="card" style="width: 18rem; background-color:rgb(153, 29, 2);">
  <img class="card-img-top" src="lib/views/images/Paper-Toss.jpg" alt="Card image cap" width="150px" height="150px" style="border-radius:20px;">
  <div class="card-body">
    <h5 class="card-title">Quizes</h5>
    <p class="card-text">Do you know where all the items belong?</p>
    <a href="/quiz" class="btn btn-primary">Quiz Time!</a>
  </div>
</div>


<div class="card" style="width: 18rem; background-color:rgb(153, 29, 2);">
  <img class="card-img-top" src="lib/views/images/Paper-Toss.jpg" alt="Card image cap" width="150px" height="150px" style="border-radius:20px;">
  <div class="card-body">
    <h5 class="card-title">Quizes</h5>
    <p class="card-text">How many can you land?</p>
    <a href="/game/1" class="btn btn-primary">Recycling Game!</a>
  </div>
</div>


