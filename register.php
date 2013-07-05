<?php 
    require_once("phpStart.php");
    require_once('recaptchalib.php');


    $errors = array();
    if($_POST['submitCheck'] == 1){


        //recaptcha
          $privatekey = "6LepJMESAAAAAPql7-Vq8HPOaU5E6WOz_I6Ey378";
          $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
        //end recaptcha
        if(!$resp->is_valid)
        {
             die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
             "(reCAPTCHA said: " . $resp->error . ")");
        }    

        if($_POST['username'] == "" || $_POST['password'] == "" || $_POST['email'] == "")
        {
            $_SESSION['REGISTER.ERROR'] = "Please fill in all fields.";
            header('Location: register.php');
            exit;
        } else {
            if($user->register($_POST['username'], $_POST['password'], $_POST['email'])){
                header('Location: index.php');
                
            } else {
                 header('Location: register.php');
                exit;
            }

        }

    }


    require_once("header.php");


?>



    <div class="row">
        <div class="twelve columns directions">
            <h3 class="directions">Register</h3>
                <?php 
                    if(isset($_SESSION['REGISTER.ERROR']) && $_SESSION['REGISTER.ERROR'] != "")
                    { 
                        echo "<div class='four columns push_four'>
                            <li class='danger alert'>";
                        echo $_SESSION['REGISTER.ERROR']; $_SESSION['REGISTER.ERROR'] = FALSE;
                        echo "</li></div>";
                    } 
                ?>
            <form action="register.php" name="register" id="register" method="POST">
                <div class="row center">
                   <ul class="six columns push_three">
                        <li class="field center"><input class="text input" name="username" id="username" type="text" placeholder="Username" /></li>
                        <li class="field center"><input class="password input" name="password" id="password" type="password" placeholder="Password" /></li>
                        <li class="field center"><input class="email input" name="email" id="email" type="text" placeholder="Email" /></li>
                        <li class="center">       <?php
                                require_once('recaptchalib.php');
                                $publickey = "6LepJMESAAAAAAKNZg7fWu7ebpVHkk38CUsPxHa8"; // you got this from the signup page
                                echo recaptcha_get_html($publickey);
                                ?>
                        </li>
                          <div class="medium primary btn"><input type="submit" value="Submit" /></div>
                   </ul>
                   <input type="hidden" value="1" name="submitCheck" />
            </form>
        </div>
    </div>

    <div class="row">

    </div>


<?php
    require_once("footer.php");
?>