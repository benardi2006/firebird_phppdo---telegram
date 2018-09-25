<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
		<ol class="breadcrumb">
			<li><a><em class="fa fa-home"></em></a></li>
			<li class="active">Laporan</li><li>Persediaan</li>
		</ol>
	</div><!--/.row-->
		
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Laporan Persediaan Barang</h1>
		</div>
	</div><!--/.row-->

<div class="panel panel-default" style="background-color: white;">
<div class="progress" id="progres" >
  <div class="progress-bar progress-bar-info" role="progressbar" id="progres_stok" aria-valuenow="40"
  aria-valuemin="0" aria-valuemax="100" width="0%" height="200px"></div>
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

    var elem = document.getElementById("progres_stok"); 
    var width = 10;
    var id = setInterval(frame, 20);
    function frame() {
        if (width >= 100) {
            clearInterval(id);
        } else {
            width++; 
            elem.style.width = width + '%'; 
        }
    }

     $.ajax({
       type: "GET",
       url: "_proses/user_proses.php?action=liststok",                          
       success: function(response){   
          setTimeout(function(){$('#progres').hide();}, 1000);
          setTimeout(function(){$("#stokbody").html(response);}, 1000);   
       }
   });
</script>