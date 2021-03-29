<h2 class="log-h2">EasyReeci loaded</h2>
<p>Loaded using Get.</p>

<?php
/*
$retrieveOrderResponse = get_order('AEZxfaOGax3sMXi7OlXdltqeV');
$orderResponse = json_decode(json_encode($retrieveOrderResponse), true);

# Go through the layers of the array
print_r($orderResponse);
$order = $orderResponse['order'];
$lineitems = $order['line_items'];

$items = array();
# For each item, save name and price.
foreach($lineitems as $item){
    #echo $item['name']."<br>";
    $items[$item['name']]=$item['total_money'];
    #$total_money = $item['total_money'];
    #echo $total_money['amount']."<br>";
}
$total = $order['total_money'];
$items["Total"]=$total['amount'];
echo Json_Encode($items);
*/
?>