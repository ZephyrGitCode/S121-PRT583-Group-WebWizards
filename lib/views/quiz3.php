
<style media="screen">
  h5, h3, #scan{
    text-align: center;
  }

.center, .mainimg3{
margin: auto;
width: 50%;
}

#toggle, #toggle2, #toggle3, #toggle4, #toggle5, #toggle6, #toggle7, #toggle8, #toggle9{
  visibility: hidden;
  opacity: 0;
  position: relative;
  z-index: 3;
}

#toggle:checked ~ dialog, #toggle2:checked ~ dialog, #toggle3:checked ~ dialog , #toggle4:checked ~ dialog ,
#toggle5:checked ~ dialog , #toggle6:checked ~ dialog , #toggle7:checked ~ dialog , #toggle8:checked ~ dialog , #toggle9:checked ~ dialog   {
  display: block;
  z-index: 3;
}

#choice li{
  display: inline-block;
  text-align: center;
  width: 100px;

}

ul#choice{
  padding-left: 0px;
}

li {
  float: left;
  padding: 0px;
}
.correct{
  background-color: green;
}

.incorrect{
  background-color: red;
}


.mainimg3{
  width: 100%;
}

li img{
  width: 60%;
}
a{
  color: white;
}

.desc_activity1 ul{
margin-top:10px;
margin-left:auto;
margin-right:auto;
display: grid;
grid-template-columns: auto auto auto;  

}

</style>


<link rel="stylesheet" type="text/css" href="../lib/views/css/lightbox.min.css">
<script src ="..lib/views/css/lightbox.min.js" type="text/javascript"></script>

 <div class="main_content">
   <div class="container">
     <div class="progress">
       <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
         <span class="sr-only">100% Complete</span>
       </div>
     </div>
   </div>

<div class="desc_activity">
      <h2>Examine the photo and click the correct waste category </h2>

</div>
  <div class="desc_activity">
    <a href="../lib/views/images/battery.jpg" data-lightbox = "mygallery">
    <img src="../lib/views/images/battery.jpg" alt="" class="mainimg3" id="">
    </a>

  </div>

  <div class= "desc_activity1">

      <section>
        <ul id="choice">
          <li><img src="../lib/views/images/green2.png" alt="Academic integrity and Plagiarism clipart" class="rounded">
            <input name="radio" type="radio" id="toggle">
              <label for="toggle">&nbsp&nbsp&nbsp Recycle</label>
              <dialog class="incorrect">
                  <p>Not quite, take a closer look at the image</p>
            </dialog>  
          </li>

          <li><img id= "toggle2img" src="../lib/views/images/red.png" alt="Academic integrity and Plagiarism clipart" class="rounded">
            <input name="radio" type="radio" id="toggle2">
              <label for="toggle2">&nbsp&nbsp&nbsp General</label>
                <dialog class="incorrect">
                  <p>Not quite, take a closer look at the image</p>


            </dialog>


          </li>
          <li><img src="../lib/views/images/yellow.png" alt="Academic integrity and Plagiarism clipart" class="rounded">
            <input name="radio" type="radio" id="toggle3">
              <label for="toggle3">&nbsp&nbspComingled</label>
            <dialog class="correct">
                  <p>Correct! This item belongs to to recycling!</p>

                  <a href="/home"><label>Congrats you have completed the quiz successfully!</label></a>
            </dialog>

          </li>
        </ul>


              </section>

      </div>
    </div>