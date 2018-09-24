<?php
	include 'redir.php';
	if(empty($_SESSION['username'])){
		header('location:index.php');
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<title>Firebird DB</title>
		<link rel="shortcut icon" href="styles/favicon.ico">
	<!-- css -->
		<link rel="stylesheet" href="jquery/jquery-ui.css">
		<link rel="stylesheet" href="jquery/jquery-ui.theme.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/font-awesome.css">
		<link rel="stylesheet" href="styles/mystyles.css">
		<link rel="stylesheet" href="amcharts\style.css">
		<link rel="stylesheet" href="amcharts\export.css">
	<!-- scripts -->	
		<script src="jquery/jquery.js"></script>
		<script src="jquery/jquery.bgswitcher.js"></script>
		<script src="jquery/jquery-ui.js"></script>
		<script src="bootstrap/js/popper.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
		<script src="amcharts/amcharts.js"></script>
		<script src="amcharts/serial.js"></script>
		<script src="amcharts/amstock.js"></script>
		<script src="amcharts/export.js"></script>
		<script src="scripts/myscripts.js"></script> 
	</head>
<!--**********************************************************-->	
	<body onload='anim()'>
		 <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top" style="opacity:0.85">
		    <div class="navbar-header">
			    <a class="navbar-brand" href="#" id="ptitle"><b>КСК</b>-Термо</a>
		    </div>
		        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" style="color:white;"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
<!--                	
		<button class="btn btn-dark" style="margin-left:10px; padding:0px,10px,0px,10px; display:none" id="upd">Оновити</button>
		<button class="btn btn-dark" style="margin-left:10px; padding:0px,10px,0px,10px; display:none" id="chk">Перев.SQL</button>
-->
			<div class="headlabel">Дата/час виміру : </div>
		 		<form action='' method='post' name='selform'>
						<input type="text" id="datepicker" onchange="autofmt(this)" name='seldate' class='myhead'/>
						<input type="text" id="seltime" name='seltime' class='myhead' style="text-align: center"/>
					<!--	<input type="time" id="seltime" name='seltime' class='myhead' style="text-align: center"/> -->
						<button type="submit" name='selconf' value='selconf' class='myhead'>Перейти</button>
						<button type="submit" name='lastconf' value='lastconf' class='myhead'>В кінець</button>
				</form>
				<button class="myhead" id="trn">Тренди</button>
			 	<button class="myhead" id="sett">Налаштув.</button>
			 	<button class="myhead" id="back">Вгору</button>
			 	<form method="post" action="main.php?logout='1'">
					<input type="submit" class="myhead" value="Вийти" />
				</form>
			</div>
		</nav>
		<br id="siteheader"/><br/><br/>
<!--**********************************************************-->
 		<div class="container container-fluid">
 			<div class="row" style="">
			</div>
			<div class="row">
				<div class="container">
				<?php include 'tables.php'; ?>
				</div>
			</div>
		</div>
		<br/><br/>
<!--**********************************************************-->
	<div id="tempModal" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"><b><span id='tblname'></span></b></h6>
					<button class="close" data-dismiss="modal">х</button>
				</div>
				<div class='modal-body'>
					<table class='table table-sm' style="text-align: center" name="modalTblName">
						<tr>
							<th style="text-align: center;">Датчик</th>
							<th style="text-align: center;">Температура,°C</th>
						</tr>					
					</table>
					<div id="line1" class="line vertical"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" style="width:40%" id="selGrTrend">Тренди</button>
					<button class="btn btn-danger" style="width:40%" data-dismiss="modal">Закрити</button>
				</div>
			</div>
		</div>
	</div>
<!--**********************************************************-->
	<div id="trendModal" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modid">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"><b>Тренди</b></h6>
					<button class="close" data-dismiss="modal">х</button>
				</div>
				<div class='modal-body'>
					<div class="col-lg-12 container">
						<div class="row">
							<div class="col-lg-4">
								<label for="corpid" class="control-label" style="font-weight:normal"> Вибрати силкорпус </label>
									<select class="form-control" name="corpname" id="corpid" style="margin-bottom:15px">
										<option value="0">Вибрати силкорпус...</option>			
									</select>	
							</div>	
							<div class="col-lg-4">
								<label for="rowid" class="control-label" style="font-weight:normal"> Вибрати ряд </label>
									<select class="form-control" name="rowname" id="rowid" onchange="selHang()" style="margin-bottom:15px">
										<option value="0">Вибрати ряд...</option>
									</select>
							</div>
							<div class="col-lg-4">
								<label for="hangid" class="control-label" style="font-weight:normal"> Вибрати силос </label>
									<select class="form-control" name="hangname" id="hangid" onchange="selTrend(this)" style="margin-bottom:15px">
										<option value="0">Вибрати силос...</option>
									</select>
							</div>
						</div>			
						<div class="row">
							<div class="col-lg-12" id="chartdiv" style="height:380px; width:100%; background:#F7F7F7"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<hr/>
					<div class='mylim'>
						<label for='minY' class='limlabel'>Мін. осі температури,°C</label>
						<input type="text" id="minY" placeholder="0" maxlength="3" class="inplim"/>
						<label for='maxY' class='limlabel'>Макс. осі температури,°C</label>
						<input type="text" id="maxY" placeholder="50" maxlength="3" class="inplim"/>
					</div>
					<button class="btn btn-danger" data-dismiss="modal">Закрити</button>
				</div>
			</div>
		</div>
	</div>
<!--**********************************************************-->
	<div id="trendSinle" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modid">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"><b>Силос <span id="silo"></span>. Датчик <span id="sensor"></span>.</b></h6>
					<button class="close" data-dismiss="modal">х</button>
				</div>
				<div class='modal-body'>
					<div class="col-lg-12 container">			
						<div class="row">
							<div class="col-lg-12" id="chartsingle" style="height:380px; width:100%; background:#F7F7F7"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<hr/>
					<div class='mylim'>
						<label for='minYsingle' class='limlabel'>Мін. осі температури,°C</label>
						<input type="text" id="minYsingle" placeholder="0" maxlength="3" class="inplim"/>
						<label for='maxYsingle' class='limlabel'>Макс. осі температури,°C</label>
						<input type="text" id="maxYsingle" placeholder="50" maxlength="3" class="inplim"/>
					</div>
					<button class="btn btn-danger" data-dismiss="modal">Закрити</button>
				</div>
			</div>
		</div>
	</div>
<!--**********************************************************-->
	<div id="ColorSet" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm" id="modid">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"><b>Налаштування кольорів</b></h6>
					<button class="close" data-dismiss="modal">х</button>
				</div>
				<div class='modal-body'>
					<div class="container" style="margin-left:15px">
						<div class="row">
							<div style="background: hsl(0,100%,65%); margin:5px; height:20px; width:20px"></div>
							<div>
								 - <input type="text" placeholder="50.0" id="tempred" maxlength="5" style="width:60px; text-align: center;"/> °C
							</div>
						</div>
						<br/>
						<div class="row">
							<div style="background: hsl(125,100%,65%); margin:5px; height:20px; width:20px;"></div>
							<div>
								 - <span id="midtemp" style="margin-left:10px"></span> °C
							</div>
						</div>
						<br/>
						<div class="row">
							<div style="background: hsl(250,100%,65%); margin:5px; height:20px; width:20px;"></div>
							<div>
								 - <input type="text" placeholder="0.0" id="tempblue" maxlength="5" style="width:60px; text-align: center;"/> °C
							</div>
						</div>
						<br/>
						<div class="row" style="display:inline-block; vertical-align: middle">
							<input type="checkbox" id="upd" name="upd" checked="checked">
							<label for="upd"> - оновлення через 1 год</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<hr/>
					<button class="btn btn-success" style="width:40%" id="conf">ОК</button>
					<button class="btn btn-danger" style="width:40%" id="canc">Відміна</button>
				</div>
			</div>
		</div>
	</div>
<!--**********************************************************-->
	<div id="trendGrModal" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modid">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"><b><span id="grSilo"></span></b></h6>
					<button class="close" data-dismiss="modal">х</button>
				</div>
				<div class='modal-body'>
					<div class="col-lg-12 container">		
						<div class="row">
							<div class="col-lg-12" id="chartGrdiv" style="height:380px; width:100%; background:#F7F7F7"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<hr/>
					<div class='mylim'>
						<label for='minYgr' class='limlabel'>Мін. осі температури,°C</label>
						<input type="text" id="minYgr" placeholder="0" maxlength="3" class="inplim"/>
						<label for='maxYgr' class='limlabel'>Макс. осі температури,°C</label>
						<input type="text" id="maxYgr" placeholder="50" maxlength="3" class="inplim"/>
					</div>
					<button class="btn btn-danger" data-dismiss="modal">Закрити</button>
				</div>
			</div>
		</div>
	</div>

		<script src="bootstrap/js/bootstrap.js"></script>
	</body>
</html>
