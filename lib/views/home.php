<p><?php echo $message ?></p>

<a href="/sendinvoicetest" style="margin: 50%;"><button  class="btn btn-primary"><p style="text-align:center;">Send Test Invoice</p></button></a>

<div class="main-container">

<div class="input-icons">
    <input class="input-field" type="text" placeholder="Search">
    <i class="fa fa-search icon-i" aria-hidden="true"></i>
</div>

<hr class="hr">

<?php
  if(!empty($invoices)){
    foreach($invoices As $invoice){
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
    <a href="<?php echo "/"."singleitem/"."{$invoicenum}"?>">
    <div class="card-two">
        <div class="card-heaer">
            <div class="logo-name">
                <div class="round-img">
                    <!--<img src="./images/uber.jpg" alt="">-->
                </div>
                <div>
                    <?php echo $title;?>
                </div>
            </div>
            <div class="date">
                <?php echo $date; ?> <!-- 6 Aug 2020 -->
            </div>
        </div>
        <?php
        if (isset($lineitems)) {
          $names = array_keys($lineitems);
          $items="";
          foreach($names As $name){
            if ($name !='Total') {
              if ($items=="") {
                $items =  "$name";
              }else{
                $items= $items.", $name";
              }
            }
          }
          echo "<li style='text-align:right;padding-right:5px;'>{$items}</li>";
        }
        ?>
        <div class="amount">
            Amount <span><?php echo "AUD \${$total}"?></span>
        </div>
        <div class="card-b">
            <div class="exp">
                <!--Exp. date 6 jan 2021-->
            </div>
            <div class="option">
                <i class="fa fa-trash-o icon" aria-hidden="true"></i>
                <i class="fa fa-file-text-o icon" aria-hidden="true"></i>
            </div>
            <div></div>
        </div>
    </div>
    </a>
    <?php
      }
    }
    else{
      echo "<h2>You currently have no invoices, try running \"Send Test Invoice\".</h2>";
    }
    ?>
</div>