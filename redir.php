<?php session_start();
	$errors = array();
	$usrdata = require 'access.php';
	$acc = 0;
	if (isset($_POST["login"]) && isset($_POST["pwd"])){
		for($i=0; $i<count($usrdata); $i++){
			if($_POST["login"]==$usrdata[$i]["login"] && $_POST["pwd"]==$usrdata[$i]["password"]){
				$acc = 1;
				$_SESSION['username'] = $_POST["login"];
				header('location:main.php');
			}
		}
		if($acc==0){
			array_push($errors,"Невірний логін/пароль");
		}
	}
	// ===================================
	if(isset($_GET['logout'])){
		$acc = 0;
		session_destroy();
		unset($_SESSION['username']);
		header('location:index.php');
	}
	// ===================================	

?>