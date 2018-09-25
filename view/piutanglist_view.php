<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
		<ol class="breadcrumb">
			<li><a><em class="fa fa-home"></em></a></li>
			<li class="active">Laporan</li><li>Piutang</li>
		</ol>
</div><!--/.row-->
		
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Laporan Piutang Customer</h1>
		</div>
	</div><!--/.row-->

  <div class="panel panel-default">
					<div class="panel-heading" >
              <div class="input-group">
                <input id="piutang_txt" type="text" class="form-control input-md" placeholder="Cari piutang berdasarkan Nama / Kode Customer" />
                <span class="input-group-btn" >
    								<button class="btn btn-primary btn-md" id="cari_piutang_btn" style="width:50px"><i class="fa fa-search"></i></button>
                </span>
              </div>
          </div>
					<div class="panel-body">
                <table class="table table-striped" style="font-size: 11px">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama Customer</th>
                      <th>Kota</th>
                      <th>Jumlah Piutang</th>
                    </tr>
                  </thead>
                  <tbody id="piutangbody">
                  </tbody>
              </table>
					</div>
  </div>
</div>
<script type="text/javascript" language="javascript">
     $.ajax({
       type: "GET",
       url: "_proses/user_proses.php?action=allpiutangglobalcust",                          
       success: function(response){                    
           $("#piutangbody").html(response); 
       }
   });
</script>
	<script src="assets/js/menu_program.js"></script>