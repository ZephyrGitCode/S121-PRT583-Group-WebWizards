<section class="quickicon">
  <div class="footer-nav">
    <a href="/map" style="width: 85%;"><span class="material-icons" style="font-size: 24px;">location_on</span><p style="margin: auto;  font-size: 12px;">Map</p></a>
    <a href="/itemclass" style="width: 85%;"><span class="material-icons" style="font-size: 24px;">auto_delete</span><p style="margin: auto;  font-size: 12px;">Item Classify</p></a>
    <a href="/" style="width: 85%;"><span class="material-icons" style="font-size: 24px;">home</span><p style="margin: auto;  font-size: 12px;">Home</p></a>
    <a href="/leaderboard" style="width: 85%;"><span class="material-icons" style="font-size: 24px;">equalizer</span><p style="margin: auto;  font-size: 12px;">Leaderboard</p></a>
    <a href="<?php if ($_SESSION['userno'] != ""){echo "/myaccount/{$_SESSION['userno']}";}else{echo "/myaccount/123";}?>" style="width: 85%;"><span class="material-icons" style="font-size: 24px;">account_circle</span><p style="margin: auto;  font-size: 12px;">Account</p></a>
  </div>
</section>

<!--
<section class="footer">
  <div>
    <h2 class="font_2" style="line-height:1.4em;text-align:center;font-size:40px">Contact Us</h2>
    <p class="font_8" style="line-height:1.7em;text-align:center;font-size:15px"><span style="letter-spacing:0.2em"><span class="color_13"><object height="0"><a href="mailto:uglyduckling@cdu.edu.au">uglyduckling@cdu.edu.au</a></object> / TEL:&nbsp;</span></span><span style="color:#756F63">0889466163</span></p>
  </div>
  <div>
    <p class="font_9" style="line-height:1.4em;text-align:center;font-size:14px">Thank you for visiting Ugly Duckling!&nbsp;</p>
    <p class="font_9" style="line-height:1.4em;text-align:center;font-size:14px">For any Catering, Bulk orders or Inquiries, please feel free to contact us using below form or Call Us!</p>
    <form action='/' method='POST'>
      <input type='hidden' name='_method' value='post' />
      <label for='title'>Feedback Subject:</label>
      <input type='text' id='title' name='title' placeholder="Feedback Subject"/>
      <label for='message'>The detail:</label>
      <textarea id='message' name='message' placeholder="*Feedback Here*"></textarea>
      <input type="submit" class="btn btn-default cart" value="Send Feedback" name="Send Feedback">
    </form>
  </div>
</section>-->