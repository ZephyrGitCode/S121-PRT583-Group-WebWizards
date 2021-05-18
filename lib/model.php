<?php

function get_db(){
   $db = null;
   try{
      $db = new PDO('mysql:host=lyn7gfxo996yjjco.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;
        dbname=d1d3fjrzeu397tmb', 'azerqdwnxq6q5yut','n7sxklekkykrhjn6');
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
      //$query = "SELECT *,SUM(score.score) AS totalscore FROM USER,score WHERE user.fname = score.Username AND user.userNo=35";
      $query = "SELECT *FROM USER WHERE userNo=?";
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


function sign_up($fname, $lname, $email, $studentnum, $password, $password_confirm){
   try{
      $db = get_db();
      if (validate_passwords($password, $password_confirm) != true){
         throw new Exception("Error: password was incorrect.");
      }
      $salt = generate_salt();
      $password_hash = generate_password_hash($password,$salt);
      $query = "INSERT INTO user (fname,lname,email,studentnum,salt,hashed_password) VALUES (?,?,?,?,?,?)";
      if($statement = $db->prepare($query)){
        $binding = array($fname,$lname,$email,$studentnum,$salt,$password_hash);
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
      $query = "SELECT userNo, email, studentnum, salt, isadmin, hashed_password FROM user WHERE email=?";
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
               $studentnum = $result["studentnum"];
               set_authenticated_session($email, $studentnum, $hashed_password, $userno, $isadmin);
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

function set_authenticated_session($email, $studentnum, $password_hash, $userno, $isadmin){
   session_start();
   // Make it a bit harder to session hijack
   session_regenerate_id(true);
   $_SESSION["userno"] = $userno;
   $_SESSION["email"] = $email;
   $_SESSION["studentnum"] = $studentnum;
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
    unset($_SESSION["studentnum"]);
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

function update_details($id,$fname,$lname,$email,$studentnum){
   try{
     $db = get_db();
     if(validate_user_email($email) !== true ){
         $query = "UPDATE user SET fname=?, lname=?, email=?, studentnum=? WHERE userNo=?";
         if($statement = $db->prepare($query)){
            $binding = array($fname,$lname,$email,$studentnum,$id);
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

function yearly_leaderboard(){
   session_start();
   try{
     $db = get_db();
     $query = "SELECT user.fname,user.lname, SUM(score.score),score.year FROM USER, SCORE WHERE user.fname = score.Username AND score.year = YEAR(CURRENT_TIMESTAMP()) GROUP BY user.fname ORDER BY SUM(score.score) DESC LIMIT 10";
     $statement = $db->prepare($query);
     $statement -> execute();
     $list = $statement->fetchall(PDO::FETCH_ASSOC);
     return $list;
   }
   catch(PDOException $e){
     throw new Exception($e->getMessage());
     return "";
   }
}
function alltime_leaderboard(){
   session_start();
   try{
     $db = get_db();
     $query = "SELECT user.fname,user.lname, SUM(score.score),score.year FROM USER, SCORE WHERE user.fname = score.Username GROUP BY user.fname ORDER BY SUM(score.score) DESC LIMIT 10";
     $statement = $db->prepare($query);
     $statement -> execute();
     $list = $statement->fetchall(PDO::FETCH_ASSOC);
     return $list;
   }
   catch(PDOException $e){
     throw new Exception($e->getMessage());
     return "";
   }
}

function mapmarkers(){
   session_start();
   try{
      $db = get_db();
      $query = "SELECT * FROM bin";
      if($statement = $db->prepare($query)){
         if(!$statement -> execute()){
            return false;
         }
         else{
            $mapmarkers = $statement->fetchall(PDO::FETCH_ASSOC);
            return $mapmarkers;
         }
      }
   }
   catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
   }
}

function monthly_leaderboard(){
   session_start();
   try{
     $db = get_db();
     $query = "SELECT user.fname, user.lname,score.score, score.month, score.year FROM USER, SCORE WHERE user.fname = score.Username AND score.month = MONTHNAME(CURRENT_TIMESTAMP ()) ORDER BY score.score DESC LIMIT 10";
     $statement = $db->prepare($query);
     $statement -> execute();
     $list = $statement->fetchall(PDO::FETCH_ASSOC);
     return $list;
   }
   catch(PDOException $e){
     throw new Exception($e->getMessage());
     return "";
   }

}

function wasteclassification(){
   session_start();
   try{
     $db = get_db();
     $query = "SELECT * FROM binitems";
     $statement = $db->prepare($query);
     $statement -> execute();
     $list = $statement->fetchall(PDO::FETCH_ASSOC);
     return $list;
   }
   catch(PDOException $e){
     throw new Exception($e->getMessage());
     return "";
   }

}


function addbin($bcolour,$bnum,$btype,$lat,$lng){
   try{
      $db = get_db();
      $query = "INSERT INTO bin (buildingcolour, buildingnum, btype, lat, lng) VALUES (?,?,?,?,?)";
      if($statement = $db->prepare($query)){
         $binding = array($bcolour,$bnum,$btype,$lat,$lng);
         if(!$statement -> execute($binding)){
            return false;
         }
         else{
            return true;
         }
      }
   }
   catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
   }

}
function updatescore($score,$id){
   try{
      $db = get_db();
      $query = "UPDATE score, user SET score.score = score.score + ? WHERE user.fname = score.Username AND score.month = MONTHNAME(CURRENT_TIMESTAMP ()) AND score.year = YEAR(CURRENT_TIMESTAMP()) AND user.userNo = ?";

      if($statement = $db->prepare($query)){
         $binding = array($score, $id);
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