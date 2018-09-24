<?php
	$server = "localhost";
	$dbname = "C:/TempDB/SM2000_053.FDB";
	$user = "SYSDBA";
	$pwd = "masterkey";
	$tblname = "TABLE_MEASURE";
	$conn = odbc_connect("Driver={Firebird/InterBase(r) driver};Server=$server;Database=$dbname", $user, $pwd);
?>