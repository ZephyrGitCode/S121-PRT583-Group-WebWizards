<?php
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

/* Here is our Controller code i.e. API if you like.  */

// Start get ---------------------------------------
get("/",function($app){
   require MODEL;
   $app->set_message("title","CDU Waste Aware");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"home");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"home");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
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
   $app->set_message("title","My Account");
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

get("/leaderboard",function($app){
   require MODEL;
   $app->set_message("title","CDU WasteAware Leaderboard");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", yearly_leaderboard());

      if($is_authenticated == True){
         $app->render(LAYOUT,"leaderboard");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"leaderboard");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the leaderboards.");
      $app->render(LAYOUT,"home");
   } 
});

get("/monthly_leaderboard",function($app){
   require MODEL;
   $app->set_message("title","CDU WasteAware Monthly Leaderboard");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", monthly_leaderboard());

      if($is_authenticated == True){
         $app->render(LAYOUT,"monthly_leaderboard");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"monthly_leaderboard");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the leaderboards.");
      $app->render(LAYOUT,"home");
   } 
});

get("/alltime_leaderboard",function($app){
   require MODEL;
   $app->set_message("title","CDU WasteAware All-Time Leaderboard");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", alltime_leaderboard());

      if($is_authenticated == True){
         $app->render(LAYOUT,"alltime_leaderboard");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"alltime_leaderboard");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the leaderboards.");
      $app->render(LAYOUT,"home");
   } 
});



get("/waste_classification",function($app){
   require MODEL;
   $app->set_message("title","Waste Classification");
   $email = $_SESSION["email"];
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"waste_classification");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"waste_classification");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});
get("/recycle_waste",function($app){
   require MODEL;
   $app->set_message("title","Recyclable Waste");
   $email = $_SESSION["email"];
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"recycle_waste");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"recycle_waste");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/co-mingled_waste",function($app){
   require MODEL;
   $app->set_message("title","Co-mingle Recyclable Waste");
   $email = $_SESSION["email"];
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"co-mingled_waste");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"co-mingled_waste");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/general_waste",function($app){
   require MODEL;
   $app->set_message("title","General Waste");
   $email = $_SESSION["email"];
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"general_waste");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"general_waste");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/specialisedwaste",function($app){
   require MODEL;
   $app->set_message("title"," Specialised Waste");
   $email = $_SESSION["email"];
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"specialisedwaste");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"specialisedwaste");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/games",function($app){
   require MODEL;
   $app->set_message("title"," Specialised Waste");
   $email = $_SESSION["email"];
   $id = get_user_id();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->set_message("user", get_user($id));
         $app->render(LAYOUT,"games");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"games");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/game/:id;[\d]+",function($app){
   $id = $app->route_var("id");
   $app->set_message("title","Games");
   require MODEL;
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->set_message("user", get_user($id));
         $app->render(LAYOUT,"game".$id);
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"game".$id);
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
   $app->set_message("note", "You must be logged in to see your account");
   $app->render(LAYOUT,"/signin");
});

get("/siteinfo",function($app){
   require MODEL;
   $app->set_message("title","Site info");
   $email = $_SESSION["email"];
   $id = get_user_id();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"siteinfo");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"siteinfo");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/map",function($app){
   require MODEL;
   $app->set_message("title","Map");
   $email = $_SESSION["email"];
   $filter = "gw,com,cardpap,env";
   $id = get_user_id();
   try{
      // change to isadmin?
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->set_message("mapmarkers", mapmarkers());
         $app->set_message("filter", $filter);
         $app->set_message("user", get_user($id));
         $app->render(LAYOUT,"map");
      }
      else{
         $app->set_message("mapmarkers", mapmarkers());
         $app->set_message("filter", $filter);
         $app->render(LAYOUT,"map");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

get("/quiz",function($app){
   require MODEL;
   $app->set_message("title","Waste Awareness Quiz");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"quiz");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"quiz");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});
get("/quiz2",function($app){
   require MODEL;
   $app->set_message("title","Waste Awareness Quiz");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"quiz2");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"quiz2");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});
get("/quiz3",function($app){
   require MODEL;
   $app->set_message("title","Waste Awareness Quiz");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $app->render(LAYOUT,"quiz3");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"quiz3");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->render(LAYOUT,"signin");
   } 
});

// End get ----------------------------------------
// Start Post -------------------------------------

post("/addbin", function($app){
   require MODEL;
   try{
      $is_authenticated = is_authenticated();
      if($is_authenticated == True){
         $lat = $app->form('latValue');
         $lng = $app->form('lngValue');
         $latlng = $app->form('latlng');
         $btype = $app->form('btype');
         $bcolour = $app->form('bcolour');
         $bnum = $app->form('bnum');
         if($latlng && $btype && $bcolour && $bnum){
            try{
              addbin($bcolour,$bnum,$btype,$lat, $lng);
              $app->set_flash("Bin ".$bcolour." ".$btype." added at building number ".$bnum." location: ".$latlng); 
              $app->render(LAYOUT,"map");  
           }
           catch(Exception $e){
                $app->set_flash($e->getMessage());  
                $app->redirect_to("map");          
           }
        }
        else{
           $app->set_flash("You are not signed up. Try again and don't leave any fields blank.");  
           $app->redirect_to("map");
        }

      }
      else{
         $app->set_flash("You are not authorized to add bin locations");
         $app->render(LAYOUT,"map");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the Maps.");
      $app->render(LAYOUT,"map");
   } 
});

post("/leaderboard",function($app){
   require MODEL;
   $app->set_message("title","CDU WasteAware Yearly Leaderboard");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", yearly_leaderboard());

      if($is_authenticated == True){
         $app->render(LAYOUT,"leaderboard");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"leaderboard");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the leaderboards.");
      $app->render(LAYOUT,"home");
   } 
});


post("/monthly_leaderboard",function($app){
   require MODEL;
   $app->set_message("title","CDU WasteAware Yearly Monthly Leaderboard");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", monthly_leaderboard());

      if($is_authenticated == True){
         $app->render(LAYOUT,"monthly_leaderboard");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"monthly_leaderboard");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the leaderboards.");
      $app->render(LAYOUT,"home");
   } 
});

post("/alltime_leaderboard",function($app){
   require MODEL;
   $app->set_message("title","CDU WasteAware All-Time Leaderboard");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", alltime_leaderboard());

      if($is_authenticated == True){
         $app->render(LAYOUT,"alltime_leaderboard");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"alltime_leaderboard");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the leaderboards.");
      $app->render(LAYOUT,"home");
   } 
});


post("/waste_classification",function($app){
   require MODEL;
   $app->set_message("title","Waste Classification");
   session_start();
   $email = $_SESSION["email"];
   session_write_close();
   try{
      $is_authenticated = is_authenticated();
      $app->set_message("list", wasteclassification());

      if($is_authenticated == True){
         $app->render(LAYOUT,"waste_classification");
      }
      else{
         #$app->render(LAYOUT,"signin");
         $app->render(LAYOUT,"waste_classification");
      }
   }
   catch(Exception $e){
      $app->set_message("message",$e->getMessage($app));
      $app->set_flash("Something wrong with the item search.");
      $app->render(LAYOUT,"home");
   } 
});


post("/signup",function($app){
    require MODEL;
    try{
        if(!is_authenticated()){
          $fname = $app->form('fname');
          $lname = $app->form('lname');
          $studentnum = $app->form('studentnum');
          $email = $app->form('email');
          $pw = $app->form('password');
          $confirm = $app->form('passw-c');
   
          if($fname && $email && $studentnum && $pw && $confirm){
              try{
                sign_up($fname,$lname,$email,$studentnum,$pw,$confirm);
                sign_in($email,$pw);
                $app->set_flash("Welcome ".$fname." ".$lname." to CDU WasteAware!"); 
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
         $studentnum = $app->form('studentnum');
         try{
            update_details($id,$fname,$lname,$email,$studentnum);
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

put("/map",function($app){
   $app->set_message("title","CDU WasteAware");
   require MODEL;
   try{
      $id = get_user_id();
      $gwc = $app->form('gwc');
      $comc = $app->form('comc');
      $cardpapc = $app->form('cardpapc');
      $envc = $app->form('envc');
      try{
         $app->set_message("mapmarkers", mapmarkers());
         $app->set_message("filter", $gwc.",".$comc.",".$cardpapc.",".$envc);
         $app->render(LAYOUT,"map");  
      }
      catch(Exception $e){
         $app->set_flash($e->getMessage());  
         $app->render(LAYOUT,"map");        
      }
   }
   catch(Exception $e){
        $app->set_flash("{$e->getMessage()}");  
        $app->render(LAYOUT,"map");
   }
});

// End put ---------------------------------------
// Start delete ----------------------------------

/*
# The Delete call back is left for you to work out
delete("/user",function($app){
   //query to delete
   $app->set_flash("User has been deleted");
   $app->redirect_to("/");
});
*/

// Now. If it get this far then page not found
resolve();