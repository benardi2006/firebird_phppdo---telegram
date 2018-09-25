  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
		<ol class="breadcrumb">
			<li><a><em class="fa fa-home"></em></a></li>
			<li class="active">Sales Order</li><li>Daftar</li>
		</ol>
	</div><!--/.row-->
		
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Daftar Sales Order</h1>
		</div>
	</div><!--/.row-->

<div class="panel panel-default" style="background-color: white;">
          <div class="panel-heading" >
            <div class="form-inline" style="margin-top:-8px">
              <p class="form-control-static" style="height:35px">Filter &nbsp</p>
              <input id="tgl_awal_txt" type="date" class="form-control form-control-lg" style="width:180px" value="<?php echo date('Y-m-d') ?>"/>
              <input id="tgl_akhir_txt" type="date" class="form-control form-control-lg" style="width:180px" value="<?php echo date('Y-m-d') ?>"/>
              <select class="form-control form-control-lg" id="filter_select_txt" style="width:150px;height: 46px">
                  <option value="REQ">Dalam Proses</option>
                  <option value="CLEAR">Clear</option>
              </select>              
              <input type="text" class="form-control form-control-lg" id="cari_penjualan_txt" placeholder="Nama / Kode Customer" style="width:290px;">
              <button id="cari_so_btn" class="btn btn-primary btn-lg" style="width:50px"><i class="fa fa-search"></i></button>
              <button id="baru_so_btn" class="btn btn-success btn-lg"><i class="fa fa-plus"></i></button>
            </div>
          </div>
					<div class="panel-body">
                <table class="table table-striped" style="font-size: 11px">
                  <thead>
                    <tr>
                      <th>No.Bukti</th>
                      <th>Tanggal</th>
                      <th>Nama Customer</th>
                      <th>Nama Salesman</th>
                      <th>Status</th>
                      <th>Check</th>
                    </tr>
                  </thead>
                  <tbody id="sobody">
                  </tbody>
              </table>
					</div>
  
</div>
  <div class="row">
    <div style='margin-left:2%;margin-right:1%;width:96%'>
      <table class="table table-striped" style="font-size: 11px" id='stokbody'>

        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" language="javascript">
        $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=listso",
            success: function(response){                    
                $("#sobody").html(response); 
            }
        });
</script>
<script src="assets/js/menu_program.js"></script>

