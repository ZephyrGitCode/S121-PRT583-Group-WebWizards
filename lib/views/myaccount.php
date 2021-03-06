<head>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<div class="container signup-body userBox">
    <h3 class="accounth3">My Account</h3>
    <p style="color:red;text-align:center;"><?php echo $error ?> </p>   
    <div class="container form-container" style="text-align:left;">
        <?php
        $user = $user[0];
        // if user is not empty
        if(!empty($user) && $user['userNo'] == get_user_id()){
        ?>
        <p style="text-align: center;">Hey <?php echo $user['fname']?> | Your Score: <?php echo $user['totalscore'];?></p>

        <form action='/myaccount/<?php if(!empty($user['userNo']))echo $user['userNo']?>' method='POST'>
            <input type='hidden' name='_method' value='put' />

            <p class="acctext">Email:</p>
            <div class="inputBox">
                <input type="text" name="email" id="email" value="<?php echo $user['email']?>">
                <span><i class="fa fa-envelope fa-icon" aria-hidden="true"></i></span>
                <p id="emailtext"></p>
            </div>

            <p class="acctext">Student Number:</p>
            <div class="inputBox">
                <input type="text" id="studentnum" name="studentnum" value="<?php echo $user['studentnum']?>" pattern="^[sS][0-9]*$" title="format: s123456" maxlength="7">
                <span><i class="fa fa-user fa-icon" aria-hidden="true"></i></span>
            </div>

            <input type="submit" name="" value="Save">
        </form>
        
        <?php
        }else{
            echo "User data failed to load.";
        }
        ?>
    </div>
    
    

    <a href="<?php if ($_SESSION['userno'] != ""){echo "/change/{$_SESSION['userno']}";}else{echo "/change/123";}?>"><p><span class="material-icons" style="font-size: 20px;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Change Password</p></a>
    <a href="/signout"><p><span class="material-icons" style="font-size: 20px;padding: 0 8px 0 5px;vertical-align: bottom;">&#xe8a6</span>Signout</p></a>
    
</div>

<script>
    var email = document.getElementById('email');
    var etext = document.getElementById('emailtext');
    var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
    email.addEventListener('input', function() {
        if (email.value.match(regex))
        {
            etext.style.color = "Green"
            etext.innerHTML = "Email is Valid"
        }else{
            etext.style.color = "Red"
            etext.innerHTML = "Invalid Email"
        }
    });

    /* Restrict to numbers only
    onkeypress='return restrictAlphabets(event)'
    function restrictAlphabets(e){
       var x = e.which || e.keycode;
        if((x>=48 && x<=57))
            return true;
        else
            return false;
    }*/
</script>