<?php

/*
try {
   $locationsApi = $client->getLocationsApi();
   $apiResponse = $locationsApi->listLocations();

   if ($apiResponse->isSuccess()) {
       $listLocationsResponse = $apiResponse->getResult();
       $locationsList = $listLocationsResponse->getLocations();
       foreach ($locationsList as $location) {
       print_r($location);
       }
   } else {
       print_r($apiResponse->getErrors());
   }
} catch (ApiException $e) {
   print_r("Recieved error while calling Square: " . $e->getMessage());
}
*/


/* SET to display all warnings in development. Comment next two lines out for production mode*/
ini_set('display_errors','On');
error_reporting(E_ERROR | E_PARSE);

/* Set the path to the Application folder */
DEFINE("LIB",$_SERVER['DOCUMENT_ROOT']."/lib");

/* SET VIEWS path */
DEFINE("VIEWS",LIB."/views");
DEFINE("PARTIALS",VIEWS."/partials");

# Paths to actual files
DEFINE("MODEL",LIB."/model.php");
DEFINE("APP",LIB."/application.php");

# Define layout
DEFINE("LAYOUT","standard");

# This inserts our application code which handles the requests and other things
require APP;

require 'vendor/autoload.php';

/* Here is our Controller code i.e. API if you like.  */

// Start get ---------------------------------------
get("/",function($app){
   require MODEL;
   $app->set_message("title","EasyReeci Home");
   session_start();
   $email = $_SESSION["email"];
   $phone = $_SESSION["phone"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->set_message("invoices", get_invoices($phone,$email));
         $app->render(LAYOUT,"home");
      }
      else{
         $app->render(LAYOUT,"signin");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/sendinvoice",function($app){
   require MODEL;
   require LIB.'/squareapi.php';
   $app->set_message("title","EasyRecci Invoice");
   $app->render(LAYOUT,"sendinvoice");
});

get("/sendinvoicetest",function($app){
   require MODEL;
   require LIB.'/squareapi.php';
   $app->set_message("title","EasyRecci Invoice Test");
   session_start();
   if (!isset($_SESSION["testcount"])){
      $_SESSION["testcount"] = 0;
   }elseif ($_SESSION["testcount"] > 3){
      #$app->redirect_to("/");
      print("d");
   }
   $email = $_SESSION["email"];
   $phone = $_SESSION["phone"];
   session_write_close();

   // Processing form data when form is submitted
   if($_SERVER["REQUEST_METHOD"] == "GET"){
      $response = testinvoice($email,$phone);
      
      echo $response;

      //header("location: index.php?");
      //exit();
   }

   session_start();
   $_SESSION["testcount"] += 1;
   session_write_close();

   $app->set_flash("Test invoice complete!"); 
   $app->redirect_to("/");
});

get("/signup",function($app){ 
   require MODEL;
   $is_authenticated=false;
   try{
      $is_authenticated = is_authenticated();
   }
   catch(Exception $e){
      $app->set_flash("Failed to signup"); 
      $app->redirect_to("/");
   }   
   if($is_authenticated){
       header("location: /");
   }
  $app->set_message("title","Sign up");
  $app->render(LAYOUT,"signup");
});

get("/signin",function($app){
   $app->set_message("title","Sign in");
   require MODEL;
   try{
     if(is_authenticated()){
        $app->redirect_to("/"); 
      }   
   }
   catch(Exception $e){
       $app->set_message("message",$e->getMessage($app));
   }
   $app->render(LAYOUT,"signin");
});

get("/myaccount/:id;[\d]+",function($app){
   $id = $app->route_var("id");
   $app->set_message("title","Darwin Art Company");
   require MODEL;
   if ($id != get_user_id()){
      $app->redirect_to("/myaccount/".get_user_id()."");
   }
   try{
      if(is_authenticated()){
         try{
            $app->set_message("user", get_user($id));
            $app->render(LAYOUT,"myaccount");
         }catch(Exception $e){
            $app->set_flash("Could not access your page");
         }
       }   
    }
    catch(Exception $e){
        $app->set_message("message",$e->getMessage($app));
    }
   $app->set_message("note", "You must be logged in to see your account");
   $app->render(LAYOUT,"signin");
});

get("/singleitem/:id;[\d]+",function($app){
   require MODEL;
   $id = $app->route_var("id");
   $app->set_message("invoice", get_invoice($id));
   $app->set_message("id", $id);
   session_start();
   $app->set_message("isadmin", $_SESSION['isadmin']);
   session_write_close();
   $app->render(LAYOUT,"singleitem");
});

get("/change/:id;[\d]+",function($app){
   $id = $app->route_var("id");
   $app->set_message("title","Change password");
   require MODEL;
   try{
      if(is_authenticated()){
         try{
            $app->set_message("user", get_user($id));
            $app->render(LAYOUT,"change_pass");
         }catch(Exception $e){
            // Failed to load DB
         }
       }
    }
    catch(Exception $e){
        $app->set_message("message",$e->getMessage($app));
    }
   $app->set_message("note", "You must be logged in to see your account");
   $app->render(LAYOUT,"/signin");
});

get("/signout",function($app){
   // should this be GET or POST or PUT?????
   require MODEL;
   if(is_authenticated()){
      try{
         sign_out();
         $app->set_flash("You are now signed out.");
         $app->redirect_to("/");
      }
      catch(Exception $e){
        $app->set_flash("Something wrong with the sessions.");
        $app->redirect_to("/");        
     }
   }
   else{
        $app->redirect_to("/signin");
   }   
});
// End get ----------------------------------------
// Start Post -------------------------------------
post("/signup",function($app){
    require MODEL;
    try{
        if(!is_authenticated()){
          $fname = $app->form('fname');
          $lname = $app->form('lname');
          $phone = $app->form('phone');
          $email = $app->form('email');
          $pw = $app->form('password');
          $confirm = $app->form('passw-c');
   
          if($fname && $lname && $email && $phone && $pw && $confirm){
              try{
                sign_up($fname,$lname,$email,$phone,$pw,$confirm);
                $app->set_flash("Welcome ".$fname.", now please sign in"); 
                $app->redirect_to("/");   
             }
             catch(Exception $e){
                  $app->set_flash($e->getMessage());  
                  $app->redirect_to("/signup");          
             }
          }
          else{
             $app->set_flash("You are not signed up. Try again and don't leave any fields blank.");  
             $app->redirect_to("/signup");
          }
          $app->redirect_to("/signup");
        }
        else{
           $app->set_flash("You are not authenticated, please login");  
           $app->redirect_to("/");           
        }
    }
    catch(Exception $e){
         $app->set_flash("{$e->getMessage()}");  
         $app->redirect_to("/");
    }
});

post("/signin",function($app){
  $email = $app->form('email');
  $password = $app->form('password');
  if($email && $password){
    require MODEL;
    try{
       sign_in($email,$password);
    }
    catch(Exception $e){
      $app->set_flash("Could not sign you in. Try again. {$e->getMessage()}");
      $app->redirect_to("/signin");      
    }
  }
  else{
     $app->set_flash("Invalid email or password, please enter all fields and try again.");
     $app->redirect_to("/signin");
  }
  $app->set_flash("Lovely, you are now signed in!");
  $app->redirect_to("/");
});

/*
post("/singleitem", function($app){
   require MODEL;
   # post single item
});
*/

post("/sendinvoice",function($app){
   require MODEL;
   require LIB.'/squareapi.php';

   # Send text to database - test using square
   # https://developer.squareup.com/docs/webhooks-api/what-it-does

   # TO DO:
   # Only accept from Square server - Validate requests
   # Web scrap for last 4 digits of card number

   /*
   $jsonobj = '{"merchant_id":"MLJ8KHZ5ZYKYZ","location_id":"LT8SSWSSJ2WZS","type":"invoice.payment_made","event_id":"f3ba7013-34f4-5d7d-9bc6-1b85bfeae669","created_at":"2020-12-17T05:47:19Z","data":{"type":"invoice","id":"Bgf46BswyV_RfquZm22pGA","object":{"invoice":{"created_at":"2020-12-17T05:44:05Z","id":"Bgf46BswyV_RfquZm22pGA","invoice_number":"00001235","location_id":"LT8SSWSSJ2WZS","order_id":"fv80Zf22wgOaw5x0xV29qNxz5VKZY","payment_requests":[{"computed_amount_money":{"amount":1234,"currency":"AUD"},"due_date":"2020-12-17","request_method":"EMAIL","request_type":"BALANCE","total_completed_amount_money":{"amount":1234,"currency":"AUD"},"uid":"113a4b6a-9299-472c-989d-04fce7a6c2e2"}],"primary_recipient":{"customer_id":"XS99AMJ93GYA53H8KYDVDVS0GM","email_address":"zephyr.dobson@outlook.com","family_name":"Dobson","given_name":"Zephyr","phone_number":"0427748158"},"public_url":"https://squareupsandbox.com/pay-invoice/Bgf46BswyV_RfquZm22pGA","status":"PAID","timezone":"UTC","title":"TestingWebhook","updated_at":"2020-12-17T05:47:19Z","version":3}}}}';

   $obj = json_decode($jsonobj, true);
   echo $title;
   echo $date;
   echo $given_name;
   echo $family_name;
   echo $total;
   echo $email;
   echo $phone;
   */
  # validate requests - https://developer.squareup.com/docs/webhooks-api/validate-notifications
  #$notificationSignature = $_SERVER['x-square-signature'];
  #$notificationBody = stream_get_contents(STDIN);
  //echo "gerer".$notificationSignature.$notificationBody;
  //$app->render(LAYOUT,"sendinvoice");
  #isValidSignature($notificationBody,$url,$notificationSignature);
   try{
      $text = file_get_contents('php://input');
      $blob = '';
      $orderid = '';
      # Go through the layers of the array
      $blob = json_decode($text, true);
      
      if ($blob == ''){
         $app->set_flash("No data found, failed entry"); 
         #$app->redirect_to("/");
      }
      
      $data = $blob['data'];
      $object = $data['object'];
      $payment = $object['payment'];
      $orderid = $payment['order_id'];
      $receiptid = $payment['receipt_number'];
      $date = $payment['created_at'];
      if($blob['email'] != null){
         $email = $blob['email'];
         $phone = $blob['phone'];
      }

      # For invoice
      #$invoice = $object['invoice'];
      #$orderid = $invoice['order_id'];
      #$payment = $invoice['payment_requests'][0];
      #$amount = $payment['total_completed_amount_money'];
      #$recipient = $invoice['primary_recipient'];
      
      #Grab variables
      #$title = $invoice['title'];
      
      #$given_name = $recipient['given_name'];
      #$family_name = $recipient['family_name'];
      #$raw_total = $amount['amount'];
      

      #$email = $recipient['email_address'];
      #$phone = $recipient['phone_number'];

      if ($orderid == ''){
         $app->set_flash("No data found, failed entry"); 
         $app->redirect_to("/");
      }
      
      # Go through content, retrieve line items
      $retrieveOrderResponse = get_order($orderid);
      $orderResponse = json_decode(json_encode($retrieveOrderResponse), true);

      # Go through the layers of the array
      $order = $orderResponse['order'];
      $tenders = $order['tenders'];
      $customerid = $tenders[0]['customer_id'];
      
      $retrieveCustomerResponse = get_customer($customerid);
      $customerResponse = json_decode(json_encode($retrieveCustomerResponse), true);

      # Go through user info
      $customer = $customerResponse['customer'];
      $given_name = $customer['given_name'];
      $family_name = $customer['family_name'];

      if ($email == '' && $phone == ''){
         $email = $customer['email_address'];
         $phone = $customer['phone_number'];
      }
      
      $orderitems = $order['line_items'];
      $items = array();
      # For each item, save name and price.
      foreach($orderitems as $item){
         $items[$item['name']]=$item['total_money'];
      }
      $total_money = $order['total_money'];
      $items["Total"]=$total_money['amount'];
      $total = number_format(($items["Total"]/100),2);
      //$total = floatval($total_money['amount']);
      $lineitems = Json_Encode($items);

   }
   catch(Exception $e){
      $app->set_flash("Failed when filtering data, {$e->getMessage()}");  
      $app->redirect_to("/");
   }

   #&& isset($lineitems)
   
   #if text and lineitems
   if(isset($text)) {
      try{
         insertinvoice($email,$phone,$receiptid,$date,$given_name,$family_name,$total,$lineitems,$text);
         $app->set_flash("Data successfuly stored in database");
      }
      catch(Exception $e){
         $app->set_flash("Data exists, failed to send data. {$e->getMessage()}");    
      }
   }
   else{
      $app->set_flash("No data to send, try again.");
      $app->redirect_to("/"); 
   }
   // Success, return home
  $app->redirect_to("/");
   
 });

// End post ----------------------------------------
// Start put ---------------------------------------
put("/myaccount/:id[\d]+",function($app){
   $app->set_message("title","Darwin Art Company Account");
   require MODEL;
   try{
       if(is_authenticated()){
         $id = get_user_id();
         $fname = $app->form('fname');
         $lname = $app->form('lname');
         $email = $app->form('email');
         $phone = $app->form('phone');
         try{
            update_details($id,$fname,$lname,$email,$phone);
            $app->set_flash("Details Successfully updated");
            $app->redirect_to("/");   
         }
         catch(Exception $e){
            $app->set_flash($e->getMessage());  
            $app->redirect_to("/");          
         }
       }
       else{
          $app->set_flash("You are not authenticated, please login correctly");  
          $app->redirect_to("/");           
       }
   }
   catch(Exception $e){
        $app->set_flash("{$e->getMessage()}");  
        $app->redirect_to("/");
   }
});

put("/change/:id;[\d]+",function($app){
   require MODEL;
   $id = $app->route_var("id");
   $userid = get_user_id();
   $app->set_message("title","Change password");
   try{
      if(is_authenticated()){
         $pw_old = $app->form('old-password');
         $pw_new = $app->form('password');
         $pw_confirm = $app->form('passw-c');
         if($pw_old && $pw_new && $pw_confirm){
            try{
               change_password($userid,$pw_old,$pw_new,$pw_confirm);
               $app->set_flash("Password successfully changed. Please now signin.");
               $app->redirect_to("/");   
            }
            catch(Exception $e){
               $app->set_flash($e->getMessage());  
               $app->redirect_to("/change/".$id);         
            }
         }
         else{
            $app->set_flash("You must enter all fields.");  
            $app->redirect_to("/change/".$id);
         }
      }
      else{
         $app->set_flash("You are not logged in.");  
         $app->redirect_to("/change/".$id);           
      }
   }
   catch(Exception $e){
      $app->set_flash("{$e->getMessage()}");  
      $app->redirect_to("/");
   }
});

// End put ---------------------------------------
// Start delete ----------------------------------
# The Delete call back is left for you to work out

delete("/cart", function($app){
   require MODEL;
   $id = $app->form("cartNo");
   #removefromcart($id);
   $app->set_flash("item has been removed from cart");
   $app->redirect_to("/cart");
});

delete("/user",function($app){
   //query to delete
   $app->set_flash("User has been deleted");
   $app->redirect_to("/");
});

// Now. If it get this far then page not found
resolve();