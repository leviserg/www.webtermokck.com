<?php include 'redir.php'; ?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<title>Firebird DB</title>
		<link rel="shortcut icon" href="styles/favicon.ico">
	<!-- css -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/font-awesome.css">
		<link rel="stylesheet" href="styles/mystyles.css">
	<!-- scripts -->	
		<script src="jquery/jquery.js"></script>
		<script src="bootstrap/js/popper.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
	</head>
<!--**********************************************************-->
	<body style="background: grey">	
		<div class="parent">
			<div style="width:250px;">
			    <div class="card card-login">
			        <div class="card-header">Вхід в систему</div>
				    <div class="card-body">
				        <form action="" method="post">
				        	<?php include('errors.php') ?>
				            <div class="form-group">
				                <label>Логін</label>
				                <input class="form-control" type="text" name="login" style="text-align: center">
				            </div>
				            <div class="form-group">
				                <label>Пароль</label>
				                <input class="form-control" type="password" name="pwd" style="text-align: center">
				            </div>
				            <button type="submit" class="btn btn-primary btn-block">Увійти</button>
				        </form>
			        </div>
			    </div>
			</div>
		</div>
	</body>
</html>
