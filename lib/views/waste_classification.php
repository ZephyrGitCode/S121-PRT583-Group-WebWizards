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

#specialimg{
  width:200px;
  height: 150px;
}

.card h2{
    display: grid;
    grid-template-columns: auto auto;
}
#searchbutton{
  display:none;
}

</style>

<h2 style="text-align: center; padding: 10px;">Waste Classification</h2>
<p style="text-align: center;">Click to see common items that belong to each group or search for a waste item:</p>

<form method="post">
<input type="text" name="search" placeholder="Search waste item..">
<input id="searchbutton" type="submit" name="submit">

</form>

<?php
$con = get_db();

if (isset($_POST["submit"])) {
	$str = $_POST["search"];
	$sth = $con->prepare("SELECT * FROM binitems WHERE item LIKE'%$str%'");

	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth -> execute();

  if($rows = $sth->fetchall()){
    foreach($rows as $row){
      echo "<div class='info_card'";
        if($row->bintype == "Paper & Cardboard Recycling"){
          echo"<h3>$row->item belongs in $row->bintype<br/><img src='lib/views/images/recyclebin1.jpg' height='70px' width='70px'/> <img src='lib/views/images/recyclebin2.jpg' height='70px' width='70px'/></h3>
          </div>";
  }elseif($row->bintype == "General Waste"){
      echo"<h3>$row->item belongs in $row->bintype<br/><img src='lib/views/images/generalbin1.jpg' height='70px' width='70px'/> <img src='lib/views/images/generalbin2.jpg' height='70px' width='70px'/></h3>
      </div>";
  }elseif($row->bintype == "Co-mingle Recycling"){
    echo"<h3>$row->item belongs in $row->bintype<br/><img src='lib/views/images/co-minglebin1.jpg' height='70px' width='70px'/> <img src='lib/views/images/co-minglebin2.jpg' height='70px' width='70px'/></h3>
    </div>";
}else{
        echo "<h3>$row->item belongs in $row->bintype</h3>
          </div>";
}
}
    
	}else{
    echo "
    <div class='info_card' style='background-color:red;'>
          <h3>Item does not exist</h3>
            <p>Your searched item may not be in our database</p>
    </div>

            ";
  }}?>

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
              <a style="color:white" href="/recycle_waste"><h2><img src="lib/views/images/recyclebin1.jpg"/> <img src="lib/views/images/recyclebin2.jpg"/></h2>
              <p>Paper & Cardboard Recycling</p></a>
            </div>

            <div class="card" style="background-color:#8B0000;">
              <a style="color:white" href="/general_waste"><h2><img src="lib/views/images/generalbin1.jpg"/> <img src="lib/views/images/generalbin2.jpg"/></h2>
              <p>General Waste</p></a>
            </div>

            <div class="card" style="background-color:#4CAF50;">
              <a style="color:white" href="/co-mingled_waste"><h2><img src="lib/views/images/co-minglebin1.jpg"/> <img src="lib/views/images/co-minglebin2.jpg"/></h2>
              <p>Co-mingle Recycling</p></a>
            </div>

            <div class="card" style="background-color:	#FF6347;">
              <a style="color:white" href="/specialisedwaste"><h2><img id="specialimg" src="lib/views/images/specialized.jpg"/></h2>
              <p>Specialised Waste</p></a>
            </div>

         
        </div>
      </div>
    </div>
  </section>
</div>