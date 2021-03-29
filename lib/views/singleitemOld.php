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

<button class = "btn btn-primary" onclick="goBack()">&#8678; Back</button>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>

<div class="productcontainer rbackground">
  <div id="rstore">
    <h2 style="text-align:center;padding-top:5%;">JB Hi-Fi</h2>
    <img src="https://www.jbhifi.co.nz/Global/images/logos/5-JB_STACKED_RGB-notag-nobracket.gif" style="padding-bottom: 5px;margin:auto;" height="67px" width="67px">
  </div>
  <p>3/247 Trower Rd, Casuarina NT 0810<p>
  <div class="producttext">
    <p class="rpricebackground rpricenum"><?php echo "AUD \${$total} "?></p>
    <div class="ritemdesc">
      <table id="ritemtable">
        <tbody>
          <tr>
            <th><span style="font-size:.7rem">Description</span></th>
            <th><span style="font-size:.7rem">AUD $</span></th>
          </tr>
          
            <?php
            if (isset($lineitems)) {
              $names = array_keys($lineitems);
              $items="";
              foreach($names As $name){
                if ($name !='Total') {
                  $price = (floatval($lineitems[$name]['amount'])/100);
                  echo "<tr>";
                  echo "<td>{$name}</td>";
                  echo "<td>{$price}</td>";
                  echo "</tr>";
                }
              }
            }
            ?>
        </tbody>
      </table>
    
    </div>

    <p class='rcardnum'>Card XXXX</p>

    <img style="max-height:100%;max-width:100%;" src="https://imgur.com/2raFXXI.jpg"></img>

    
    
    <!--
    <p class="itemdesc"><?php echo "Purchased on: {$date}" ?></p>
    <p class="itemdesc"><?php echo "{$given} {$family}" ?></p>
    <p class="itemdesc"><?php echo "Email: {$email}" ?></p>
    <p class="itemdesc"><?php echo "Phone: {$phone}" ?></p>
    -->

    <!--   Keep for later, make purchase
    <form action="/singleitem" method="POST">
      <input type='hidden' name='_method' value='post' />
      <input type='hidden' name='itemNo' value='<?php echo($itemno) ?>' />
      <input type='hidden' name='vendorNo' value='<?php echo($vendorNo) ?>' />
      
      <div class="input-group plus-minus-input">
        <div class="input-group-button">
          <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity" id="decrease" onclick="decreaseValue()" value="Decrease Value">
            <i class="fa fa-minus" aria-hidden="true"></i>
          </button>
        </div>
        <div class="input-custom">
          <input class="input-group-field" type="number" id= "quantity" name="quantity" value="1" min="1">
        </div>
        <div class="input-group-button">
          <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity" id="increase" onclick="increaseValue()" value="Increase Value">
            <i class="fa fa-plus" aria-hidden="true"></i>
          </button>
        </div>
      </div>
      <p id="price">AUD $<?php echo "{$price}" ?></p>
    </form>-->


  </div>
</div>
<?php
    }
  }
  else{
    echo "<h2>Sorry, invoice failed to load</h2>";
}
?>
