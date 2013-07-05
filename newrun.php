<?php 

	//mysql connection
	$user = "mercury";
	$pass = "mIavkoXi";


	try {

    	$db = new PDO('mysql:host=lamp.it.marist.edu:3306;dbname=fluue_mbex', $user, $pass);
   	}
	catch (PDOException $ex) {
    	echo "An Error occured!\n";
    	var_dump($db); //user friendly message
	}

?>