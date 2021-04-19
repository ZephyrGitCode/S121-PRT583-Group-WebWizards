<p><?php echo $message ?></p>
<style>
.card a{
    padding: 20px;
}

.card img{
    width:100px;
    height: 150px;
    text-align: center;
}
.card h2{
    display: grid;
    grid-template-columns: auto auto;
}

</style>
<script>
function goBack() {
  window.history.back();
}
</script>

<button style="padding-right: 10px; padding-left: 5px; padding-top:3px; padding-bottom:3px; background-color: #007a87; border: none; border-radius: 50px; " onclick="goBack()"> < Back </button>

<h2 style="text-align: center; padding: 10px;">Waste Classification</h2>
<p style="text-align: center;">Click to see common items that belong to each group or search for a waste item:</p>
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
            <div class="card" style="background-color:#999900;">
              <a style="color:white" href="/info"><h2><img src="lib/views/images/recyclebin1.jpg"/> <img src="lib/views/images/recyclebin2.jpg"/></h2>
              <p>Paper & Cardboard Recycling</p></a>
            </div>

            <div class="card" style="background-color:#8B0000;">
              <a style="color:white" href="/howtopoints"><h2><img src="lib/views/images/generalbin1.jpg"/> <img src="lib/views/images/generalbin2.jpg"/></h2>
              <p>General Waste</p></a>
            </div>

            <div class="card" style="background-color:#4CAF50;">
              <a style="color:white" href="/map_main"><h2><img src="lib/views/images/co-minglebin1.jpg"/> <img src="lib/views/images/co-minglebin2.jpg"/></h2>
              <p>Co-mingle Recycling</p></a>
            </div>

         
        </div>
      </div>
    </div>
  </section>
</div>