<?php
use Square\SquareClient;
use Square\LocationsApi;
use Square\Exceptions\ApiException;
use Square\Http\ApiResponse;
use Square\Models\ListLocationsResponse;
use Square\Environment;

function get_order($orderid){

   $client = new SquareClient([
      'accessToken' => 'EAAAEKPJBW15v9nww1uR1v283c_a0PhfOmLeAhH8SpGXYQU7TmEozZ7ZVKVkmQZf',
      #'accessToken' => 'EAAAEEszVAcgJl_NwwMafC0mPtedumY8MKkdCteVhPLTFhAc4B4Esa67aM1MwypT',
      'environment' => Environment::PRODUCTION,
      #'environment' => Environment::SANDBOX,
   ]);

   $ordersApi = $client->getOrdersApi();
   #$orderId = 'jJGzjWdLO0bIFOw6C2UkceCmRAaZY';
   
   $apiResponse = $ordersApi->retrieveOrder($orderid);
   
   if ($apiResponse->isSuccess()) {
      $retrieveOrderResponse = $apiResponse->getResult();
      /*
      #Print json to make it easier
      $blob = json_encode($retrieveOrderResponse);
      print_r($blob);
      */
      return $retrieveOrderResponse;
   } else {
      $errors = $apiResponse->getErrors();
      return $errors;
   }
   
   // Get more response info...
   // $statusCode = $apiResponse->getStatusCode();
   // $headers = $apiResponse->getHeaders();
}

function get_customer($customerid){

   $client = new SquareClient([
      'accessToken' => 'EAAAEKPJBW15v9nww1uR1v283c_a0PhfOmLeAhH8SpGXYQU7TmEozZ7ZVKVkmQZf',
      #'accessToken' => 'EAAAEEszVAcgJl_NwwMafC0mPtedumY8MKkdCteVhPLTFhAc4B4Esa67aM1MwypT',
      'environment' => Environment::PRODUCTION,
      #'environment' => Environment::SANDBOX,
   ]);

   $api_response = $client->getCustomersApi()->retrieveCustomer($customerid);

   if ($api_response->isSuccess()) {
      $result = $api_response->getResult();
      return $result;
   } else {
      $errors = $api_response->getErrors();
      return $errors;
   }

   // Get more response info...
   // $statusCode = $apiResponse->getStatusCode();
   // $headers = $apiResponse->getHeaders();
}
?>