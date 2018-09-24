<?php
	$xmlpath = "xml_config\STViewer2000v205.xml";
	$xml = simplexml_load_file($xmlpath);

	$i = 0;
	$silname = [];
	$sil_id = [];

	$corps = 0;
	foreach($xml->Silos as $child) {
		$corps++;
	}

	$rows = ((string)$xml->Silos->Type->attributes()->RowCount)+0;
	$hang = ((string)$xml->Silos->Type->attributes()->ColumnCount)+0;
	$tables = $rows*$corps;
	
//	die('tabs = '.$tabs.'; rows = '.$rows.'; cols = '.$cols);

	foreach($xml->Silos as $child) {
		foreach ($child->Bob as $key => $value) {
			$sname = $value->attributes()->Caption;
			$s_id = $value->attributes()->SerialNumber;
			$silname[$i] = (string)$sname;
			$sil_id[$i] = (string)$s_id;
			$i++;
		}
	}
	
	$sensname = [];
	$ssensname = [];
	for($i=0;$i<count($sil_id);$i++){
		$ssensname[$i] = [];
		$j = 0;
		foreach($xml->Bob as $child) {
			$silos = (string)$child->attributes()->SerialNumber;
			if($silos === $sil_id[$i]){
				foreach ($child->Sensor as $key => $value) {
					$sname = $value->attributes()->DataBaseName;
					$sensname[$i] .= (string)$sname.', ';
					$ssensname[$i][$j] = (string)$sname;
					$j++;
				}
			}
		}
	}

	$usflsens = count($ssensname[0]);

	for($i=0; $i<count($sensname); $i++){
		$sseldata .= $sensname[$i];
	}

	$sseldata = substr($sseldata,0,-2);
?>