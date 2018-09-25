<link href="assets/css/styles.css" rel="stylesheet">
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a><em class="fa fa-home"></em></a></li>
			<li class="active">Sales Order</li>
		</ol>
	</div><!--/.row-->
		
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Sales Order</h1>
		</div>
	</div><!--/.row-->
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-md-1 control-label">No.Bukti</label>
						<div class="col-md-2">
							<input id="bukti_txt" type="text" class="form-control"  readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-1 control-label" >Tanggal</label>
						<div class="col-md-3">
							<input id="tgl_txt" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" autofocus>
						</div>
						<label class="col-md-1 control-label" for="emai"></label>
						<div class="col-md-1">
							<input id="kodesales_txt" class="form-control" placeholder="kode sales" disabled style="display:none"><!--style="display:none"-->
						</div>
						<label class="col-md-1 control-label" for="emai">Salesman</label>
						<div class="col-md-3">
							<input id="namasales_txt" name="email" type="text" placeholder="Nama Salesman" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-1 control-label" for="emai">Customer</label>
						<div class="col-md-5">
							<input id="namacustomer_txt" name="email" type="text" placeholder="Nama Customer" class="form-control">
						</div>
						<label class="col-md-1 control-label" for="emai">Term</label>
						<div class="col-md-2">
							<input id="term_txt" class="form-control" placeholder="Term" onkeypress="return isNumber(event)">
						</div>
						<div class="col-md-2">
							<input id="kodecustomer_txt" class="form-control" placeholder="kodecustomer" disabled style="display:none">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-1 control-label">Catatan</label>
						<div class="col-md-5">
							<textarea class="form-control" id="catatan_txt" name="message" placeholder="Ketikan catatan disini ...." rows="5"></textarea>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="form-horizontal">
		        <table class="table table-striped" style="font-size: 11px">
	                <thead>
	                	<tr>
	                      <th>ID</th>
	                      <th>Nama Barang</th>
	                      <th>Nama Barang</th>
	                      <th>Qty</th>
	                      <th>Harga Jual</th>
						  <th>Total</th>
	                      <th>
						  	<button type="button" id="barangmodal_btn" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#barang_modal">
							  <i class='fa fa-plus'></i> Pesanan Barang
  							</button>
						  </th>
	                    </tr>
	                </thead>
	                <tbody id="salesorder">
	                </tbody>
				</table>
			</div>


		</div>
  	</div>
</div>
 <!--<script type="text/javascript">
 	$('#modalin').click(function(e){
 		e.preventDefault();
	setTimeout(function() {$('#exampleModal').modal('hide');}, 4000);
	})
 </script>-->

<?php include("modal_view.php"); ?>
<script>
	window.onload = getnobukti();
</script>
<script src="assets/js/menu_program.js"></script>

<script>


</script>