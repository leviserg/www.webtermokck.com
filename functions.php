<?php

	function transp_2d($result) {
	    $transpose = array(); //
	    foreach ($result as $key => $sub) {
	        foreach ($sub as $subkey => $subvalue) {
	            $transpose[$subkey][$key] = $subvalue;
	        }
	    }
	    return $transpose;
	}

	function mcalc($val){
		include 'config.php';
		$ret = null;
		if($val<$maxlim && $val>$minlim){
			$ret = round((($val/16) - 273.15),1);
		}
		else{
			$ret = 'n/a';
		}
		return $ret;
	}
?>