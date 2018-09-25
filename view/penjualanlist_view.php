<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
      <ol class="breadcrumb">
        <li><a><em class="fa fa-home"></em></a></li>
        <li class="active">Laporan</li><li>Penjualan</li>
      </ol>
  </div><!--/.row-->
		
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Laporan Penjualan</h1>
		</div>
	</div><!--/.row-->
  <div class="panel panel-default">
					<div class="panel-heading" >
              <div class="form-inline" style="margin-top:-8px">
                <p class="form-control-static" style="height:35px">Filter &nbsp</p>
                <input id="tgl_awal_txt" type="date" class="form-control form-control-sm" style="width:180px;height:35px" value="<?php echo date('Y-m-d') ?>"/>
                <input id="tgl_akhir_txt" type="date" class="form-control form-control-sm" style="width:180px;height:35px" value="<?php echo date('Y-m-d') ?>"/>
                <input type="text" class="form-control" id="cari_penjualan_txt" placeholder="Nama / Kode Customer" style="width:400px;height:35px">
                <button id="cari_penjualan_btn" class="btn btn-primary" style="width:50px;height:35px"><i class="fa fa-search"></i></button>
              </div>
          </div>
					<div class="panel-body">
                <table class="table table-striped" style="font-size: 11px">
                  <thead>
                    <tr>
                      <th>Nama Customer</th>
                      <th>No.Faktur</th>
                      <th>Tanggal</th>
                      <th>Nama Barang</th>
                      <th>Qty</th>
                      <th>Harga Jual</th>
                    </tr>
                  </thead>
                  <tbody id="penjualanbody">
                  </tbody>
              </table>
					</div>
  </div>
</div>
<script src="assets/js/menu_program.js"></script>
<script>
    var awal = $('#tgl_awal_txt').val();
    var akhir = $('#tgl_akhir_txt').val();
    var cust = $('#cari_penjualan_txt').val();
    if(awal > akhir){
        alert('Inputan Tanggal awal lebih besar daripada akhir');
    } else {
        $('#penjualanbody').empty();
        $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=filterpenjualanpertanggal&awal="+awal+"&akhir="+akhir+"&customer="+cust,
            success: function(response){                    
                $("#penjualanbody").html(response); 
            }
        });
    }
</script>