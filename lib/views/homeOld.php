<p><?php echo $message ?></p>

<a href="/sendinvoicetest" style="margin: 50%;"><button  class="btn primary"><p style="text-align:center;">Send Test Invoice</p></button></a>


<div class="invoicemenu">

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

      <div class="menuitem">
        <a class="invoice" href="<?php echo "/"."singleitem/"."{$invoicenum}"?>">
        <!--
          <div class="fimage">
            <img href="" src="<?php echo "{$itemimage}"?>" class="itemimage"/>
          </div>
        -->
        <?php
        echo "<div class=\"singlelist\">";
        echo "<li>{$title}</li>";
        echo "<li style='font-size:.7rem;color:#B6B1A6;'>{$date}</li>";
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
          
        echo "<li style='text-align:right;padding-right:5px;'>\${$total}</li>";
        echo "</div>";
        ?>
        </a>
      </div>
  <?php
      }
    }
    else{
      echo "<h2>You currently have no invoices, try running \"Send Test Invoice\".</h2>";
  }
  ?>
</div>