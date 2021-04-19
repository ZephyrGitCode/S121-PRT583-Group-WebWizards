<p><?php echo $message ?></p>

<script>
function goBack() {
  window.history.back();
}
</script>

<button style="padding-right: 10px; padding-left: 5px; padding-top:3px; padding-bottom:3px; background-color: #007a87; border: none; border-radius: 50px; " onclick="goBack()"> < Back </button>

<h2 style="text-align: center; padding: 10px;">Waste Classification</h2>
<?php echo "<img src='recyclebin1.jpg' alt='Girl in a jacket'/>" ?>
<div class="input-icons">
  <section class="callaction">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">

        </div>
      </div>
    </div>
  </section>

  <section id="wastesorting">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="cardContainer">
            <div class="card" style="background-color:rgb(50, 41, 91);">
              <a style="color:white" href="/info"><h2><img src="recyclebin1.jpg"/></h2>
              <p>Paper & Cardboard Recycling</p></a>
            </div>

            <div class="card" style="background-color:rgb(153, 29, 2);">
              <a style="color:white" href="/howtopoints"><h2><span class="glyphicon glyphicon-star"></span></h2>
              <p>General Waste</p></a>
            </div>

            <div class="card" style="background-color:rgb(207, 41, 91);">
              <a style="color:white" href="/map_main"><h2><span class="glyphicon glyphicon-map-marker"></span></h2>
              <p>Co-mingle Recycling</p></a>
            </div>

         
        </div>
      </div>
    </div>
  </section>
</div>