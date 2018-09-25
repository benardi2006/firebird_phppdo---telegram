
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
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
    <div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-6 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-blue"></em>
							<div class="large">120</div>
							<div class="text-muted">Penjualan Bulan <?php echo date('F'); ?></div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-6	 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-comments color-orange"></em>
							<div class="large">52</div>
							<div class="text-muted">Sisa Piutang</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading">
			Grafik Penjualan 30 Hari Terakhir
			<ul class="pull-right panel-settings panel-button-tab-right" style="height:40px;">
				<li><a class="pull-right"><em class="fa fa-filter" style="margin-top:8px;"></em></a></li>
			</ul>
			<span class="pull-right clickable panel-toggle panel-button-tab-left" style="height:40px;"><em class="fa fa-toggle-up" style="margin-top:10px;"></em></span>
		</div>
		<div class="panel-body timeline-container">
			<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading">
			Putang Jatuh Tempo
			<ul class="pull-right panel-settings panel-button-tab-right" style="height:40px;">
				<li><a class="pull-right"><em class="fa fa-filter" style="margin-top:8px;"></em></a></li>
			</ul>
			<span class="pull-right clickable panel-toggle panel-button-tab-left" style="height:40px;"><em class="fa fa-toggle-up" style="margin-top:10px;"></em></span>
		</div>
		<div class="panel-body timeline-container">
			<table class="table table-striped" style="font-size: 11px">
					<thead>
						<tr>
						<th>Nama Customer</th>
						<th>No.Faktur</th>
						<th>Tanggal Penjualan</th>
						<th>Nama Salesman</th>
						<th>Tanggal Jatuh Tempo</th>
						<th>Sisa</th>
						</tr>
					</thead>
					<tbody id="jatem">
					</tbody>
			</table>
		</div>
	</div>
</div>

<script src="assets/js/chart-data.js"></script>
<script src="assets/js/jatem.js" language="javascript"></script>