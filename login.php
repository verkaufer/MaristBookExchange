<?php 
	require_once("phpStart.php");

    /**
    *Check if we want to log out
    *
    */
    if($_GET['do'] == "logout"){
        $user->logout();
        exit;
    }
    

    if($user->loggedIn()){
        header('Location: index.php');
        exit;
    }
    


    /**
    *Otherwise we'll do the login validation
    **/
	if($_POST['submitCheck'] == 1){

		if($_POST['username'] == "" || $_POST['password'] == "")
		{
			$_SESSION['LOGIN.ERROR'] = "Please enter a username and password.";
			header('Location: login.php');
			exit;
		} else {
			if($user->login($_POST['username'], $_POST['password'])){

				header('Location: index.php');
			} else {
				$_SESSION['LOGIN.ERROR'] = "A user was not found with that username and password combination.";
				header('Location: login.php');
				exit;
			}

		}

	}


	require_once("header.php");

?>



    <div class="row">
        <div class="twelve columns directions">
            <h3 class="directions">Login</h3>
            	<?php 
            		if(isset($_SESSION['LOGIN.ERROR']) && $_SESSION['LOGIN.ERROR'] != "")
            		{ 
            			echo "<div class='four columns push_four'>
            				<li class='danger alert'>";
            			echo $_SESSION['LOGIN.ERROR']; $_SESSION['LOGIN.ERROR'] = FALSE;
            			echo "</li></div>";
            		} 
            	?>
            <form action="login.php" method="POST">
                <div class="row center">
                   <ul class="six columns push_three">
                        <li class="field center"><input class="text input" name="username" type="text" placeholder="Username" /></li>
                        <li class="field center"><input class="password input" name="password" type="password" placeholder="Password" /></li>
                          <div class="medium primary btn"><input type="submit" value="Submit" /></div>
                   </ul>
                   <input type="hidden" value="1" name="submitCheck" />
            </form>
        </div>
                    <p>Don't have an account? Click <a href="register.php"><u>here</u></a> to register!</p>
    </div>

	<div class="row">

	</div>



<?php
	require_once("footer.php");
?>