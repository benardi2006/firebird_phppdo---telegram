<?php
session_start();
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PT. Agres Info Teknologi</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="assets/css/datepicker3.css" rel="stylesheet">
	<link href="assets/css/styles.css" rel="stylesheet">
	<link href="assets/css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<style>
	a {cursor: pointer;}
	.blinking{
    animation:blinkingText 4s infinite;
	}
	@keyframes blinkingText{
		0%{     color: #000;    }
		25%{    color: #bbb; }
		50%{    color: transparent; }
		75%{    color: #bbb;  }
		100%{   color: #000;    }
	}
	</style>
</head>
<body style="">
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand">PT. AGRES INFO TEKNOLOGI</a>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="assets/img/agres.png" class="img-responsive" style="height:60px;width:auto">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">
					<?php
						if (isset($_SESSION["username"]))
						{
							echo $_SESSION["username"];
						}
						else
						{
							header('Location:login');
						}
					?>
				</div>
				<div class="profile-usertitle-status blinking"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
			<li id="dashboard" class="active"><a><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li id="sales_order"><a><em class="fa fa-calendar">&nbsp;</em> Sales Order</a></li>
			<li id="laporan" class="parent"><a data-toggle="collapse" href="#sub-laporan" >
				<em class="fa fa-navicon">&nbsp;</em> Laporan <span style="margin-top:8px" data-toggle="collapse" href="#sub-laporan" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-laporan">
					<li id="piutang"><a>
						<span class="fa fa-arrow-right">&nbsp;</span> Piutang
					</a></li>
					<li id="persediaan"><a>
						<span class="fa fa-arrow-right">&nbsp;</span> Persediaan
					</a></li>
					<li id="penjualan" ><a class="" >
						<span class="fa fa-arrow-right">&nbsp;</span> Penjualan
					</a></li>
				</ul>
			</li>
			<li id="logout"><a><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->

	<div id="menu_isi">
		<div class="row">
			<ol class="breadcrumb">
				<li><a >
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
	</div>
	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="assets/js/sidebar.js"></script>
	<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

</body>

