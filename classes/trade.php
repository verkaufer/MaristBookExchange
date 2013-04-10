<?php

class Trade
{
	
	private $pdo;


	//use this like so:
	// $user = new User($db);
	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}
	
}

?>