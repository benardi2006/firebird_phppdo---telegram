<?php
		session_start();
		include ('view/login_view.php');
		if (isset($_SESSION["username"]))
		{
			header('Location:home');
		}

?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
	<link href="assets/css/datepicker3.css" rel="stylesheet">
	<link href="assets/css/styles.css" rel="stylesheet">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>
	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/menu_program.js"></script>
	<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>