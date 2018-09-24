<?php
	include 'config.php';
	include 'functions.php';
	include 'dbconn.php';
	include 'getxmlconfig.php';
	
	if($conn){
		include 'lfdate.php';
		if (isset($_POST["selconf"])){
			$seldate = $_POST["seldate"].' '.$_POST["seltime"];
			include 'sel.php';
		}
		else{
			include 'last.php';
		}
	}else{
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}
?>