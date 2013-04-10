<?php

function __autoload($className) {
      if (file_exists('classes/' . strtolower($className) . '.php')) {
          require_once 'classes/' . strtolower($className) . '.php';
          return true;
      }
      return false;
} 

	//mysql connection
	$user = "fluue_marproj";
	$pass = "mb3x0!";


	try {

    	$db = new PDO('mysql:host=localhost;dbname=mbex', $user, $pass);
   	}
	catch (PDOException $ex) {
    	echo "An Error occured!\n";
    	var_dump($db); //user friendly message
	}

session_start();

?>

<!--
Begin header 
-->