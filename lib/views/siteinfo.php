<p><?php echo $message ?></p>
<style>
.input-icons{
  margin-top:-100px;
}
.card a{
    padding: 60px;
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
#searchbutton{
  visibility: hidden;
}
</style>

<!-- <h2 style="text align: center; padding; 20px;"> Information of waste management</h2>
<p style="text align: center;"> there are info regarding waste management below </p> -->

<form method="post">
<input type="text" name="search" placeholder="Information about waste items">
<input id="searchbutton" type="submit" name="submit">


<div class="row col-lg-12">

    <div class="col-lg-3">
        <img src="../lib/views/images/glass-bin.jpg" alt="HTML5 Icon" width="128" height="128">
        <p style="text align: center;"> This bin is used for collecting material like glass and paper. </p>
    </div>

    

    <div class="col-lg-3">
        <img src="../lib/views/images/paper-bin.jpg" alt="HTML5 Icon" width="128" height="128">
        <p style="text align: center;"> This bin is used to collect wasted papers. </p>
    </div>

    <div class="col-lg-3">
        <img src="../lib/views/images/recyclinggreenwaste.png" alt="HTML5 Icon" width="128" height="128">
        <p style="text align: center;"> This bin is only for wasted food items.  </p>
    </div>

    <div class="col-lg-3">
        <img src="../lib/views/images/co-minglebin1.jpg" alt="HTML5 Icon" width="128" height="128">
        <p style="text align: center;"> This bin is only used for recycled items. </p>
    </div>
</div>