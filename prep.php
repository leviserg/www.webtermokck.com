<?php
	include 'config.php';
	$selcorp = $_POST['selcorp'];
	$selrow = $_POST['selrow'];

	$ret = [];//$selcorp*$selrow;
	$start = (($selcorp-1)*$rows + $selrow)*$hang - ($hang - 1);
	for($i = $start; $i<$start+$hang; $i++){
		$ret[$i] = $i;
	}

	if(isset($_POST['selrow'])){
		echo json_encode($ret);
	}
	
	unset($_POST);
?>