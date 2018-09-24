<?php
		$lastid = odbc_result(odbc_exec($conn, 'SELECT MAX("ID") FROM '.$tblname),1)+0;
		$sql = 'SELECT "DTLINECREATE" FROM '.$tblname.' WHERE "ID"='.$lastid;
		$res = odbc_exec($conn, $sql);
		$lastdate = odbc_result($res,1);

		$firstid = odbc_result(odbc_exec($conn, 'SELECT MIN("ID") FROM '.$tblname),1)+0;
		$sql = 'SELECT "DTLINECREATE" FROM '.$tblname.' WHERE "ID"='.$firstid;
		$res = odbc_exec($conn, $sql);
		$firstdate = odbc_result($res,1);

		print('<span id="hangs" style="display:none">'.$hang.'</span>');
		print('<span id="sens" style="display:none">'.$usflsens.'</span>');
		print('<span id="fdate" style="display:none">'.$firstdate.'</span>');
		print('<span id="rows" style="display:none">'.$rows.'</span>');
		print('<span id="corps" style="display:none">'.$corps.'</span>');		

		if (isset($_POST["selconf"])){
			print('<span id="ldate" style="display:none">'.$_POST["seldate"].' '.$_POST["seltime"].'</span>');
		}
		else{
			print('<span id="ldate" style="display:none">'.$lastdate.'</span>');
		}	

?>