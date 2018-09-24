<?php
	include 'dbconn.php';
	include 'config.php';
	include 'getxmlconfig.php';
	include 'functions.php';

	$selhang = $_POST['selhang']-1;

	$seldata = $sensname[$selhang];

		$datefield = "DTLINEUPDATE";
		$seldata = ' '.$datefield.', '.substr($seldata,0,-2);
		$sql = 'SELECT '.$seldata.' FROM '.$tblname;
		$data = [];
	if($conn){
		
		$firstid = odbc_result(odbc_exec($conn, 'SELECT MIN("ID") FROM '.$tblname),1)+0;
		$lastid = odbc_result(odbc_exec($conn, 'SELECT MAX("ID") FROM '.$tblname),1)+0;
//		$len = odbc_result(odbc_exec($conn, 'SELECT COUNT(*) FROM '.$tblname),1)+0;
		$x = 0;
		for($i = $firstid; $i<=$lastid;$i++){
			$res = odbc_exec($conn, $sql.' WHERE "ID"='.$i);
			$tempdata[$i] = odbc_fetch_array($res);
			$y = 0;
			foreach($tempdata[$i] as $key => $value){
				if($key == $datefield){
					$data[$y][$x] = substr($value, 0,16).':00';
				}
				else{
					$data[$y][$x] = mcalc($value);
				}
				$y++;
			}
			$x++;
		}

		odbc_free_result($res);
		odbc_close($conn);

	if($_POST['selhang']!=null){
		echo json_encode($data);
	}

	}else{
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}
?>