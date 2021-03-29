<?php

function isValidSignature($notificationBody, $notificationUrl, $notificationSignature){
  // Concatenate your notification URL and
  // the JSON body of the webhook notification
  $stringToSign = $notificationUrl . $notificationBody;

  // Webhook subscription signature key defined in dev portal for app 
  // webhook listener endpoint: http://webhook.site/my-listener-endpoint
  // Note: Signature key is truncated for illustration
  $webhookSignatureKey = 'RHgLXS1PznLdaqFLevDJBQ';

  // Generate the HMAC-SHA1 signature of the string
  // signed with your webhook signature key
  $hash = hash_hmac('sha1', $stringToSign, $webhookSignatureKey, true);
  $generatedSignature = base64_encode($hash);

  // Compare HMAC-SHA1 signatures.
  if(hash_equals($generatedSignature, $notificationSignature)){
     return true;
   }
   else {
      return false;
   }
   return false;
}


function get_db(){
   $db = null;
   try{
      $db = new PDO('mysql:host=l7cup2om0gngra77.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;
        dbname=pqpzq5eaofu9gn91', 'czg1suqjc78gt24t','lfnapgmdhf17txed');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $e){
      throw new Exception("Something wrong with the database connection!".$e->getMessage());
   }
   return $db;
}

function get_user($id){
   $user = null;
   try{
      $db = get_db();
      $query = "SELECT * FROM user where userNo=?";
      if($statement = $db->prepare($query)){
         $binding = array($id);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
      }
      $user = $statement->fetchall(PDO::FETCH_ASSOC);
      return $user;
   }
   catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
   }
}

function get_invoice($id){
   $food = null;
   try{
      $db = get_db();
      $query = "SELECT * from invoice WHERE num = ?";
      if($statement = $db->prepare($query)){
         $binding = array($id);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
         $invoice = $statement->fetchall(PDO::FETCH_ASSOC);
         return $invoice;
      }
      else{
         throw new Exception("Could not prepare statement.");
      }
   }
   catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
   }
}

function get_invoices($phone,$email){
   $invoices = null;
   try{
      $db = get_db();
      $query = "SELECT * from invoice WHERE userPhone = ? OR userEmail = ?";
      if($statement = $db->prepare($query)){
         $binding = array($phone,$email);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
         $invoices = $statement->fetchall(PDO::FETCH_ASSOC);
         return $invoices;
      }
      else{
         throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
     throw new Exception($e->getMessage());
   }
   
}

function insertinvoice($email,$phone,$receiptid,$date,$given_name,$family_name,$total,$lineitems,$text){
   try{
      $db = get_db();
      $sameId = checkId($receiptid);
      if ($sameId == TRUE){
         new Exception("Not unique Receipt ID");
      }
      $query = "INSERT INTO invoice (userEmail,userPhone,receiptId,
         dateCreated,givenName,familyName,total,lineItems,receiptText) VALUES (?,?,?,?,?,?,?,?,?)";
      if($statement = $db->prepare($query)){
         $binding = array($email,$phone,$receiptid,$date,$given_name,$family_name,$total,$lineitems,$text);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
      }
      else{
         throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

function checkId($receiptid){
   try{
      $db = get_db();
      $query = "SELECT receiptId FROM invoice WHERE receiptId = ?";
      if($statement = $db->prepare($query)){
         $binding = array($receiptid);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
         $result = $statement->fetch(PDO::FETCH_ASSOC);
         if ($result['receiptId'] != null){
            return TRUE;
         }else{
            return FALSE;
         }
      }
      else{
         throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}
/*
function post_feedback($userid, $title, $message){
   try{
      $db = get_db();
      $query = "INSERT INTO feedback (feedback.userNo, title, messageText) VALUES (?,?,?)";
      if($statement = $db->prepare($query)){
         $binding = array($userid, $title, $message);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
      }
      else{
      throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
       throw new Exception($e->getMessage());
   }
}
*/

function sign_up($fname, $lname, $email, $phone, $password, $password_confirm){
   try{
      $db = get_db();
      if (validate_passwords($password, $password_confirm) != true){
         throw new Exception("Error: Passwords must match and Password must contain at least 8 characters, one Capital letter and one number.");
      }
      $salt = generate_salt();
      $password_hash = generate_password_hash($password,$salt);
      $query = "INSERT INTO user (fname,lname,email,phone,salt,hashed_password) VALUES (?,?,?,?,?,?)";
      if($statement = $db->prepare($query)){
        $binding = array($fname,$lname,$email,$phone,$salt,$password_hash);
        if(!$statement -> execute($binding)){
           throw new Exception("Could not execute query.");
         }
      }
      else{
         throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

function sign_in($useremail,$password){
   try{
      $db = get_db();
      if (validate_user_email($useremail)){
         throw new Exception("Email does not exist");
      }
      if (validate_password($password) === false){
         session_start();
         $_SESSION['logincount'] += 1;

         if ($_SESSION['logincount'] > 5){
            throw new Exception("Too many failed login attempts, please try again later.");
         }
         session_write_close();
         throw new Exception("Password incorrect. Password must contain at least 8 characters, one Capital letter and one number");
      }
      $query = "SELECT userNo, email, phone, salt, isadmin, hashed_password FROM user WHERE email=?";
      if($statement = $db->prepare($query)){
         $binding = array($useremail);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $salt = $result['salt'];
            $isadmin = $result['isadmin'];
            session_start();
            $_SESSION['salt'] = $salt;
            $_SESSION['hash'] = $result['hashed_password'];
            session_write_close();
            $hashed_password = $result['hashed_password'];
            if(generate_password_hash($password,$salt) != $hashed_password){
               throw new Exception("Password incorrect. Password must contain at least 8 characters, one Capital letter and one number.");
            }
            else{
               $email = $result["email"];
               $userno = $result["userNo"];
               $phone = $result["phone"];
               set_authenticated_session($email, $phone, $hashed_password, $userno, $isadmin);
            }
         }
      }
      else{
         throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

function validate_passwords($password, $password_confirm){
   if($password === $password_confirm && validate_password($password) === true){
      return true;
   }else{
      return false;
   }
}

function validate_password($password){
   $uppercase = preg_match('@[A-Z]@', $password);
   $lowercase = preg_match('@[a-z]@', $password);
   $number    = preg_match('@[0-9]@', $password);

   if($uppercase && $lowercase && $number && strlen($password) >= 8) {
      return true;
   }else{
      return false;
   }
}

function set_authenticated_session($email, $phone, $password_hash, $userno, $isadmin){
   session_start();
   // Make it a bit harder to session hijack
   session_regenerate_id(true);
   $_SESSION["userno"] = $userno;
   $_SESSION["email"] = $email;
   $_SESSION["phone"] = $phone;
   $_SESSION["isadmin"] = $isadmin;
   $_SESSION["hash"] = $password_hash;
   session_write_close();
}

function generate_password_hash($password,$salt){
return hash("sha256", $password.$salt, false);
}

function generate_salt(){
 $chars = "0123456789ABCDEF";
 return str_shuffle($chars);
}

function validate_user_email($email){
   try{
      $db = get_db();
      $query = "SELECT hashed_password FROM user WHERE email=?";
      if($statement = $db->prepare($query)){
      $binding = array($email);
         if(!$statement -> execute($binding)){
            return false;
         }
         else{
               $result = $statement->fetch(PDO::FETCH_ASSOC);
               if($result['email'] === $email){
               return true;
               }else{
                  return false;
               }
            }
         }
      }
   catch(Exception $e){
      throw new Exception("Authentication not working properly. {$e->getMessage()}");
   }
}

function is_authenticated(){
 $email = "";
 $hash="";
 session_start();
 if(!empty($_SESSION["email"]) && !empty($_SESSION["hash"])){
    $email = $_SESSION["email"];
    $hash = $_SESSION["hash"];
 }
 session_write_close();
 if(!empty($email) && !empty($hash)){
     try{
        $db = get_db();
        $query = "SELECT hashed_password FROM user WHERE email=?";
        if($statement = $db->prepare($query)){
          $binding = array($email);
          if(!$statement -> execute($binding)){
             return false;
          }
          else{
              $result = $statement->fetch(PDO::FETCH_ASSOC);
              if($result['hashed_password'] === $hash){
                return true;
              }
          }
        }
     }
     catch(Exception $e){
        throw new Exception("Authentication not working properly. {$e->getMessage()}");
     }
 
 }
 return false;

}

function sign_out(){
 session_start();
 if( !empty($_SESSION["email"]) && !empty($_SESSION["hash"]) && !empty($_SESSION["userno"]) ){
   unset($_SESSION["email"]);
    unset($_SESSION["hash"]);
    unset($_SESSION["userno"]);
    unset($_SESSION["phone"]);
    $_SESSION = array();
    session_destroy();                     
 }
 session_write_close();
}

function change_password($id, $old_pw, $new_pw, $pw_confirm){
try{
   $db = get_db();
   $query = "SELECT salt, hashed_password FROM user WHERE userNo=?";
   if($statement = $db->prepare($query)){
      $binding = array($id);
      if(!$statement -> execute($binding)){
              throw new Exception("Could not execute query.");
      }
      else{
         $result = $statement->fetch(PDO::FETCH_ASSOC);
         $salt = $result['salt'];
         $hash = $result['hashed_password'];
         if(generate_password_hash($old_pw,$salt) != $hash){
            throw new Exception("Old Password does not match.");
        }
        else{
            if (validate_passwords($new_pw, $pw_confirm)){
               $salt = generate_salt();
               $password_hash = generate_password_hash($new_pw,$salt);
               $query = "UPDATE user SET hashed_password=?, salt=? WHERE userNo=?";
               if($statement = $db->prepare($query)){
                  $binding = array($password_hash, $salt, $id);
                  if(!$statement -> execute($binding)){
                        throw new Exception("Could not execute query.");
                  }else{
                     sign_out();
                  }
               }
               else{
               throw new Exception("Could not prepare statement.");
               }
            }else{
               throw new Exception("Ensure that the New password and confirm password match, also both passwords must contain at least 8 characters, one Capital letter and one number.");
            }
         }
      }
   }
   else{
   throw new Exception("Could not prepare statement.");
   }

 }
 catch(Exception $e){
     throw new Exception($e->getMessage());
 }
}

function update_details($id,$fname,$lname,$email,$phone){
   try{
     $db = get_db();
     if(validate_user_email($email) !== true ){
         $query = "UPDATE user SET fname=?, lname=?, email=?, phone=? WHERE userNo=?";
         if($statement = $db->prepare($query)){
            $binding = array($fname,$lname,$email,$phone,$id);
            if(!$statement -> execute($binding)){
               throw new Exception("Could not execute query.");
            }else{
               session_start();  
               $_SESSION["email"] = $email;
               session_write_close();
            }
         }
         else{
         throw new Exception("Could not prepare statement.");
         }
     }
     else{
        throw new Exception("Please specify a unique email.");
     }
   }
   catch(Exception $e){
       throw new Exception($e->getMessage());
   }
}

function get_user_id(){
   $id="";
   session_start();  
   if(!empty($_SESSION["userno"])){
      $id = $_SESSION["userno"];
   }
   session_write_close();
   return $id;	
}

function get_user_name(){
   $id="";
   $name="";
   session_start();  
   if(!empty($_SESSION["userno"])){
      $id = $_SESSION["userno"];
   }
   session_write_close();
   if(empty($id)){
     throw new Exception("User has no valid id");	
   }
   try{
      $db = get_db();  
      $query = "SELECT fname FROM user WHERE userNo=?";
      if($statement = $db->prepare($query)){
         $binding = array($id);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $name = $result['fname'];
         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }

   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
   return $name;	
}

function testinvoice($email, $phone){
    //$content = json_encode($arr);
    
    $curl = curl_init();
   //https://easyreeci-receipt-test.herokuapp.com/sendinvoice
   //localhost/sendinvoice
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://easyreeci-receipt-test.herokuapp.com/sendinvoice',
        #CURLOPT_URL => 'localhost/sendinvoice',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        #"email":"'.$email.'","phone":"'.$phone.'",
        CURLOPT_POSTFIELDS =>'{"email":"'.$email.'","phone":"'.$phone.'","merchant_id":"MLC81NXFHSG1T","type":"payment.updated","event_id":"4072f0e0-9a83-4ac6-90ab-d65d72d49f63","created_at":"2021-01-25T09:54:25.606Z","data":{"type":"payment","id":"TR8AMJ3fbvinzuOrxi8wX3qzvaB","object":{"payment":{"amount_money":{"amount":455,"currency":"AUD"},"card_details":{"auth_result_code":"095414","avs_status":"AVS_NOT_CHECKED","card":{"bin":"518868","card_brand":"MASTERCARD","card_type":"DEBIT","exp_month":12,"exp_year":2021,"fingerprint":"sq-1-23bDd18S01PJf74H4kJhaQ7oTzyIaVXI8e_Nkxt-QSRVyCLxY0HFKfiinsKhgfMpuQ","last_4":"2048","prepaid_type":"NOT_PREPAID"},"cvv_status":"CVV_ACCEPTED","device_details":{"device_id":"DEVICE_INSTALLATION_ID:9b2ea238-39f4-4e78-9c6b-0c4cf14a3285","device_installation_id":"9b2ea238-39f4-4e78-9c6b-0c4cf14a3285","device_name":""},"entry_method":"KEYED","statement_description":"SQ *ME","status":"CAPTURED"},"created_at":"2021-01-25T09:54:14.622Z","id":"TR8AMJ3fbvinzuOrxi8wX3qzvaB","location_id":"LK2K5P21J2H7V","order_id":"UcKAQkyWQhVSNcRAVX0XfIqeV","processing_fee":[{"amount_money":{"amount":1,"currency":"AUD"},"effective_at":"2021-01-25T21:24:21.000Z","type":"ADJUSTMENT"},{"amount_money":{"amount":10,"currency":"AUD"},"effective_at":"2021-01-25T21:24:21.000Z","type":"INITIAL"}],"receipt_number":"'."1".'","receipt_url":"https://squareup.com/receipt/preview/TR8AMJ3fbvinzuOrxi8wX3qzvaB","source_type":"CARD","status":"COMPLETED","total_money":{"amount":500,"currency":"AUD"},"updated_at":"2021-01-25T09:54:21.014Z","version":4}}}}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    echo $response;

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    echo $status;
    
    //$response = json_decode($json_response, true);

    /*
    // Handle error
    if ( $status != 200 ) {
         //$loginerror =  $response['message'];
         //set_session_message('loginerror',$loginerror);
         curl_close($curl);
         header("location: index.php?new");
         exit();
    }
    */

    curl_close($curl);
    return $response;
}
/*
function curlget($url){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
    array("Content-type: application/json"));

    $json_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $response = json_decode($json_response, true);

    if ( $status != 200 ) {
        $verror = $response['message'];
        set_session_message('verror',$verror);
        header("location: index.php?");
        exit();
    }
    curl_close($curl);
    return $response;
}

function sessionlogin(){
    session_regenerate_id();
    $sessname = getSessionName();
    $sessid = getSessionId();
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["sessname"] = $sessname;
    $_SESSION["sessid"] = $sessid;
    $_SESSION["username"] = $_POST['username'];
    session_write_close();
    $msg = "Success";
    return $msg;
}
*/