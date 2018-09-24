<?php

		$sql = 'SELECT '.$sseldata.' FROM '.$tblname.' WHERE "ID"='.$lastid;
		$res = odbc_exec($conn, $sql);
		$tdata = odbc_fetch_array($res);
		odbc_free_result($res);
		odbc_close($conn);

		$temp = array_chunk($tdata,$usflsens);

		$temper = [];
		for($i=0;$i<count($temp);$i++){
			$temper[$i] = [];
			for($j=0;$j<count($temp[$j]);$j++){
				$temper[$i][$j] = mcalc($temp[$i][$j]);
			}
		}

		$maxtemp = [];
		for($i=0;$i<count($temp);$i++){
			$max = 0.0;
			for($j=0;$j<count($temp[$i]);$j++){
					$temp_r = round(($temp[$i][$j]/16) - 273.15,1);
					if($temp_r>$max && $temp_r<120){
						$max = $temp_r;
					}
			}
			($max==0.0) ? $maxtemp[$i] = 'n/a' : $maxtemp[$i] = $max;
		}

		$mmaxtemp = array_chunk($maxtemp, $hang);

		for($i = 0; $i < count($temp); $i++){
			$temp[$i] = array_reverse($temp[$i]);
		}

		$ttemp = transp_2d($temp);

// ******* bodies *******
print('<h3 style="text-align:center">Силкорпуси</h3>');
print('<div class="row t1">');
	for($k=0; $k<$corps;$k++){
		print('<div class="col-lg-'.$maxcol_bootstrap/$corps.'">');
			print('<div class="silcorp" onclick="ScrollToMark(\'#hdl'.($k+1).'\')">');
//				print('<table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="grey">');
					$silmax = -50;
					$silnum = '';
					$rn = 0;
				for($i=$k*$rows;$i<$rows*($k+1);$i++){
					$rn++;
//					print('<tr>');
						for($j = 0; $j<$hang; $j++){
							if($mmaxtemp[$i][$j]>$silmax){
								if($j<9){
									$silnum = ($k+1).$rn.'0'.($j+1);
								}
								else{
									$silnum = ($k+1).$rn.($j+1);
								}
								$silmax = $mmaxtemp[$i][$j];
							}
//						  	print('<td class="sil_cell">'.$mmaxtemp[$i][$j].'</td>');
						}
//					print('</tr>');
				}
					print('<b>Cилкорпус '.($k+1).'</b><br/>');
					print('Максимальна температура<br/>');
					print('<b><span id="max'.$k.'">'.$silmax.'</span>°C'.'</b><br/>');
					print('Силос '.$silnum);
//				print('</table>');
			print('</div>');
		print('</div>');
	}
print('</div>');
// ******* tables *******
	for($k = 0; $k<$corps; $k++){
		print('<hr/><h4 class="headlink" id="hdl'.($k+1).'" data-toggle="tooltip" title="Перейти до силкорпуса '.($k+1).'" onclick="ScrollToMark(\'#hdt'.($k+1).'\')">Максимальні температури силкорпуса <b>'.($k+1).'</b></h4>');

		print('<div class="row t'.($k%2).' maxtable" id="mtab'.$k.'">');
				print('<table width="100%" border="1" cellspacing="1" cellpadding="1" bgcolor="grey">');
				$rn = 0;			
				for($i=$k*$rows;$i<$rows*($k+1);$i++){
					$rn++;
					print('<tr>');
						for($j = 0; $j<$hang; $j++){
							if($j<9){
								$silnum = ($k+1).$rn.'0'.($j+1);
							}
							else{
								$silnum = ($k+1).$rn.($j+1);
							}
						  	print("<td class='shdata' data-toggle='tooltip' title='Силос ".$silnum."' id='mdata$i$j' onclick='showHang(".$silnum.",".$i.",".$j.")'>".$mmaxtemp[$i][$j]."</td>");
						}
					print('</tr>');
				}
				print('</table>');
		print('</div>');
	}

// ***********************
		$corpnum = 1;
		for($k = 0; $k<$tables; $k++){

			if($k%$rows==0){
				print('<span  id="hdt'.$corpnum.'"><br/><hr/></span><h4 class="headlink" data-toggle="tooltip" title="Вгору" onclick="ScrollToMark(\'#siteheader\')">Силкорпус <b>'.$corpnum.'</b></h4><hr/>');
				$corpnum++;
			}
			$startsil = ($corpnum-1).($k%$rows + 1).'01';
			if($hang<10){
				$endsil = ($corpnum-1).($k%$rows + 1).'0'.$hang;
			}
			else{
				$endsil = ($corpnum-1).($k%$rows + 1).$hang;
			}

//			print('<h6 style="text-align:center; padding:10px">Силоси від <b>'.($k*$hang + 1).' до '.($k+1)*$hang.'</b></h6>');
			print('<h6 style="text-align:center; padding:10px">Силоси від <b>'.$startsil.' до '.$endsil.'</b></h6>');	
				print('<div class="row t'.($k%2).'" style="background:grey; padding:7px" id="tab'.$k.'">');
					print('<table width="100%" border="1" cellspacing="1" cellpadding="1" bgcolor="#FFFFFF">');
					// ********* header ********
					  print('<tr bgcolor="lightgrey">');
					    print('<td height="22" class="theader"><b>Силос</b></td>');

					    for($i = 1; $i<=$hang; $i++){
					    	if($i<10){
					    		$silnum = ($corpnum-1).($k%$rows + 1).'0'.$i;
					    	}
					    	else{
					    		$silnum = ($corpnum-1).($k%$rows + 1).$i;
					    	}
					    	print('<td height="22" class="theader"><b>'.$silnum.'</b></td>');
					    }
					  print('</tr>');
					// ********* data **********
				  	for($i=0; $i<count($ttemp); $i++){
				  		print ("<tr>");
				  		print ("<td class='hcol'>Датчик ".(count($ttemp) - $i)."</td>");
						
						for($j=0; $j<count($ttemp[$i])/$tables; $j++){
							$temp_r = mcalc($ttemp[$i][$k*$hang+$j]);
							if($j<9){
								$silnum = ($corpnum-1).($k%$rows + 1).'0'.($j + 1);
							}
							else{
								$silnum = ($corpnum-1).($k%$rows + 1).($j + 1);
							}

						print ('<td class="hdata" id="hdata'.($k*$hang+$j+1).(count($ttemp)-$i).'" data-toggle="tooltip" title="Силос '.$silnum.'. Датчик '.(count($ttemp)-$i).'." onclick="showSingle('.$silnum.','.($k*$hang+$j+1).','.(count($ttemp)-$i).')">'.$temp_r.'</td>');
						}
						print ("</tr>");
				  	}
					print('</table>');
				print('</div>');
		}
		$_POST = null;
?>