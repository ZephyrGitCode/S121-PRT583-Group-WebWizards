<?php
$invoice = $invoice[0];
// Can utilize the following code for single food info
if(!empty($invoice)){
  //foreach($items As $item){
  $invoicenum = htmlspecialchars($invoice['num'],ENT_QUOTES, 'UTF-8');
  if ($invoicenum == $id){
    $invoicenum = htmlspecialchars($invoice['num'],ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($invoice['invoiceTitle'],ENT_QUOTES, 'UTF-8');
    $date = substr(htmlspecialchars($invoice['dateCreated'],ENT_QUOTES, 'UTF-8'), 0, 10);
    $given = htmlspecialchars($invoice['givenName'],ENT_QUOTES, 'UTF-8');
    $family = htmlspecialchars($invoice['familyName'],ENT_QUOTES, 'UTF-8');
    $total = htmlspecialchars($invoice['total'],ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($invoice['userPhone'],ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($invoice['userEmail'],ENT_QUOTES, 'UTF-8');

    //$lineitems = htmlspecialchars($invoice['lineItems'],ENT_QUOTES, 'UTF-8');
    if (isset($invoice['lineItems'])) {
      $lineitems = json_decode($invoice['lineItems'],true);
    }

?>

<button class="btn" onclick="goBack()">&#8678; Back</button>

<script>
  function goBack() {
    window.history.back();
  }
</script>

<div class="main-container">
  <div class="h-title">
    Store Name (Square POS)
  </div>
  <div class="text-12">
    Store Address (Square POS)
  </div>

  <div class="card-one">
    <div class="price">
      <?php echo "AUD \${$total}"?>
    </div>
  </div>

  <div class="card-one">
    <div class="description">
      Description
    </div>
    <?php
    if (isset($lineitems)) {
      $names = array_keys($lineitems);
      $items="";
      foreach($names As $name){
        if ($name !='Total') {
          $price = (floatval($lineitems[$name]['amount'])/100);
    ?>
      <?php echo "<div class='description-body'><div class='left'><div class='name'>{$name}</div></div>";?>
      <?php echo "<div class='right'>\${$price}</div></div><hr class='hr-d'>";?>
    <?php
        }
      }
    }
    ?>
  </div>

  <div class="card-one">
    <div class="toggle-card">
      <div class="text-12">
        Get 12% discount on Google Nest mini
      </div>
      <label class="switch">
        <input type="checkbox">
        <span class="slider round"></span>
      </label>
    </div>
  </div>

  <div class="card-one">
    <div class="card-select">
      <div>
        <div class="text-12">
          Card selected
        </div>
        <div>
          xxxx xxxx xxxx xxxx
        </div>
      </div>
      <img src="./img/mastercard.png" alt="">
    </div>
  </div>

  <div class="card-one">
    <div class="warrenty">
      <div>
        <div class="warrenty-text">
          Warranty expires on 25-11-2021 <br>
          Find out more at
        </div>
        <i class="fa fa-calendar icon" aria-hidden="true"></i>
      </div>
      <div class="reminder">
        <div>
          Set reminder?
        </div>
        <button class="reminder-btn"> jbhifi.com.au </button>
      </div>
    </div>
  </div>

  <div class="card-one">
    <div class="rate-service">
      <div class="text-14">
        Rate your service
      </div>
      <div>
        <i class="fa fa-star icon star-yellow" aria-hidden="true"></i>
        <i class="fa fa-star icon star-yellow" aria-hidden="true"></i>
        <i class="fa fa-star icon star-yellow" aria-hidden="true"></i>
        <i class="fa fa-star icon star-yellow" aria-hidden="true"></i>
        <i class="fa fa-star icon" aria-hidden="true"></i>
      </div>
    </div>
  </div>

  <?php
    }
  }
  else{
    echo "<h2>Sorry, invoice failed to load</h2>";
}
?>