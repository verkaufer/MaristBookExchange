<?php

  require_once("phpStart.php");

	if($_POST['action'] == 'delete'){
		$tradeID = $_POST['tradeID'];

		$trades->deleteTrade($tradeID);
		$_SESSION['FLASH.DATA'] = "Trade deleted successfully.";
		header('Location: index.php');
		exit;

	} else {
		header('Location: index.php');
		exit;
	}

?>