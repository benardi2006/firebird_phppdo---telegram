$('#cari_penjualan_btn').click(function(e){
    e.preventDefault();
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
});

$('#cari_piutang_btn').click(function(e){
    e.preventDefault();
    var kode = $('#piutang_txt').val();
    $('#piutangbody').empty();
    $.ajax({
      type: "GET",
      url: "_proses/user_proses.php?action=filterpiutangglobalcust&kode=" + kode,                          
      success: function(response){                    
          $("#piutangbody").html(response); 
      }
  });
 });

 $('#cari_so_btn').click(function(e){
    e.preventDefault();
    var tgla = $('#tgl_awal_txt').val();
    var tglb = $('#tgl_akhir_txt').val();
    var status= $('#filter_select_txt').val();
    var customer = $('#cari_penjualan_txt').val();
    $('#sobody').empty();
      $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=filterso&tgla=" + tgla + "&tglb=" + tglb + "&status=" + status + "&customer=" + customer,
            success: function(response){
                //console.log(response);       
                $("#sobody").html(response);
            }
 });
});

$('#baru_so_btn').click(function(e){
    e.preventDefault();
    $('#menu_isi').empty();
    $("#menu_isi").load('view/salesorder_view.php');
});


$('#login').click(function(e){
        e.preventDefault();
        var button = $(e.target);
        if($('#username_txt').val().length === 0)
        {
          alert("Username Mohon diisi");
          return false;
        };
        if($('#password_txt').val().length === 0)
        {
          alert("Password Mohon diisi");
          return false;
        };
        $('#login').hide();
        $('#pesan').hide();
        var data2 = $('#loginform').serialize()
        + '&' + encodeURI(button.attr('name')) + '=' + encodeURI(button.attr('value'));
        $.ajax({
          type: 'POST',
          url:'_PROSES/user_proses.php',
          data: data2,
          success: function(resp)
          {
            if(resp =="SUKSES"){
              setTimeout('window.location= "home";',500);
            }else{
              setTimeout(function(){$('#proses_modal').modal('hide');$('#login').show();$('#pesan').show();
              }, 2000);
            }
            
          }
        })
});

$( "#namabarang_txt" ).autocomplete({
    source: "_proses/user_proses.php?tabel=barang",  
      minLength:2,
      select:function(event,ui){
          $("#namabarang_txt").val(ui.item.value);
          $("#kodebarang_txt").val(ui.item.id);
          return false;
      }
   });
   $( "#namasales_txt" ).autocomplete({
    source: "_proses/user_proses.php?tabel=salesman",  
      minLength:2,
      select:function(event,ui){
          $("#namasales_txt").val(ui.item.value);
          $("#kodesales_txt").val(ui.item.id);
          return false;
      }
   });
   $( "#namacustomer_txt" ).autocomplete({
    source: "_proses/user_proses.php?tabel=customer",  
      minLength:2,
      select:function(event,ui){
          $("#namacustomer_txt").val(ui.item.value);
          $("#kodecustomer_txt").val(ui.item.id);
          return false;
      }
   });

function getSO(e){
    // e.preventDefault();
     var nobukti = e.value;  
     $('#menu_isi').empty();            
     $("#menu_isi").load('view/salesorder_edit.php?nobukti=' + nobukti); 
}

function deleteSO(e) {
    var nobukti = e.value;  
    //
    $.ajax({
        type: "GET",
        url: "_proses/user_proses.php?action=deleteso&nobukti=" + nobukti,
        success: function(response){ 
           // $(this).parent().remove();
           alert(response);
           $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=listso",
            success: function(response){                    
                $("#sobody").html(response); 
            }
            });
        }
    });       
}

function deletedSO(e) {
    var nobukti = e.value;
    $.ajax({
        type: "GET",
        url: "_proses/user_proses.php?action=deletedetailso&" + nobukti,
        success: function(response){ 
           alert(response);
           $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=salesorderd&" + nobukti,
            success: function(response){                    
                $("#salesorder").html(response);}
            });
        }    
    });
}
function editdS2O(e) {
    var nobukti = e.value;
    $.ajax({
        type: "GET",
        url: "_proses/user_proses.php?action=deletedetailso&" + nobukti,
        success: function(response){ 
           alert(response);
           $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=salesorderd&" + nobukti,
            success: function(response){                    
                $("#salesorder").html(response);}
            });
        }    
    });
}

function getdSO(e) {
    var nobukti = e.value;
    //alert(nobukti);
    $.getJSON('_proses/user_proses.php?action=getdetailso&' + nobukti, function (data) {
        //console.log(data);
        var yanke = JSON.parse(JSON.stringify(data));
        $('#namabarang_txt').val(yanke[0]['NAMABARANG']);
        $('#kodebarang_txt').val(yanke[0]['KODEBARANG']);
        $('#qty_txt').val(yanke[0]['QTY']);
        $('#harga_txt').val(yanke[0]['HARGAJUAL']);
        $('#idbarang_txt').val(yanke[0]['ID']);
        $('#update_data').show();
        $('#save_data').hide();
     });
}
 function isNumber(evt) {
     evt = (evt) ? evt : window.event;
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
     }
     return true;
 }
 
 function getheader(nobukti) {
        $.getJSON('_proses/user_proses.php?action=getheaderso&nobukti=' + nobukti, function (data) {
            var yanke = JSON.parse(JSON.stringify(data));
            $('#namacustomer_txt').val(yanke[0]['NAMACUSTOMER']);
            $('#kodecustomer_txt').val(yanke[0]['KODECUSTOMER']);
            $('#namasales_txt').val(yanke[0]['NAMASALESMAN']);
            $('#kodesales_txt').val(yanke[0]['KODESALESMAN']);
            $('#tgl_txt').val(yanke[0]['TGL']);
            $('#catatan_txt').val(yanke[0]['CATATAN']);
            var term = yanke[0]['TERM'];
            $('#term_txt').val(term);
         });

         $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=salesorderd&nobukti=" + nobukti,                          
            success: function(response){                    
                $("#salesorder").html(response); 
            }
        });
}

function getnobukti() {
    $.getJSON('_proses/user_proses.php?action=getbukti', function (data) {
		$("#bukti_txt").val(data);
      });
}
/*function getlastid(nobukti) {
    $.getJSON('_proses/user_proses.php?action=getlastid&nobukti='+nobukti, function (data) {
		$("#bukti_txt").val(data);
      });
}*/




$('#barangmodal_btn').click(function(e){
  var nobukti = $('#bukti_txt').val();
  $.getJSON('_proses/user_proses.php?action=getlastid&nobukti='+ nobukti, function (data) {
    var x = parseInt(data) + 1;
    $('#idbarang_txt').val(x);
    $('#namabarang_txt').val("");
    $('#kodebarang_txt').val("");
    $('#qty_txt').val("");
    $('#harga_txt').val("");
    $('#update_data').hide();
    $('#save_data').show();
    });
});


$('#barangmodal_btn').click(function(e){
  e.preventDefault();

  var nobukti = $('#kodebukti_txt').val();
  var tgl = $('#tgl_txt').val();
  var kodesales = $('#kodesales_txt').val();
  var kodecustomer = $('#kodecustomer_txt').val();
  var kodesales = $('#kodesales_txt').val();
  var catatan = $('#catatan_txt').val();
  var term = $('#term_txt').val();

  if(kodesales.length === 0)
        {
          alert("Data Salesman tidak ada / kosong");
          return false;
        };
  
  if(kodecustomer.length === 0)
        {
      alert("Data Customer tidak ada / kosong");
          return false;
        };
  
  if(term.length === 0)
        {
      alert("Data term tidak ada / kosong");
            return false;
        };
});



$('#save_data').click(function(e){
  e.preventDefault();

  var nobukti = $('#bukti_txt').val();
  var tgl = $('#tgl_txt').val();
  var kodesales = $('#kodesales_txt').val();
  var kodecustomer = $('#kodecustomer_txt').val();
  var kodesales = $('#kodesales_txt').val();
  var catatan = $('#catatan_txt').val();
  var term = $('#term_txt').val();
  var idbarang = $('#idbarang_txt').val();
  var kodebarang = $('#kodebarang_txt').val();
  var harga = $('#harga_txt').val();
  var qty = $('#qty_txt').val();
  var data = {"action":"insertso","NOBUKTI":nobukti,"TGL":tgl,"KODESALESMAN":kodesales,"KODECUSTOMER":kodecustomer,"CATATAN":catatan,"TERM":term,"ID":idbarang,"HARGAJUAL":harga,"QTY":qty,"KODEBARANG":kodebarang};
  $.ajax({
    type : 'POST',
    url :'_PROSES/user_proses.php',
    data : data,
    success: function(data){
      if(data == "SUKSES" )
      {
        alert("Data Save: " + data);
         $('#namabarang_txt').val("");
         $('#kodebarang_txt').val("");
         $('#harga_txt').val("");
         $('#qty_txt').val("");
         $('#tgl_txt').prop('disabled', true);
        $('#namasales_txt').prop('disabled', true);
        $('#namacustomer_txt').prop('disabled', true);
        $('#kodesales_txt').prop('disabled', true);
        $('#catatan_txt').prop('disabled', true);
        $('#term_txt').prop('disabled', true);
        $.ajax({
          type: "GET",
          url: "_proses/user_proses.php?action=salesorderd&nobukti=" + nobukti,                          
          success: function(response){                    
            $("#salesorder").html(response); 
          }
        });
      }
      else
      {
        alert("Data Save: " + data);
      }
    }
  })
  var nobukti = $('#bukti_txt').val();
  $.getJSON('_proses/user_proses.php?action=getlastid&nobukti='+ nobukti, function (data) {
    var x = parseInt(data) + 1;
    $('#idbarang_txt').val(x);
      });
  
});

$('#update_data').click(function(e){
    e.preventDefault();
  
    var nobukti = $('#bukti_txt').val();
    var idbarang = $('#idbarang_txt').val();
    var kodebarang = $('#kodebarang_txt').val();
    var harga = $('#harga_txt').val();
    var qty = $('#qty_txt').val();
    var data = {"action":"updatesod","NOBUKTI":nobukti,"ID":idbarang,"HARGAJUAL":harga,"QTY":qty,"KODEBARANG":kodebarang};
    $.ajax({
      type : 'POST',
      url :'_PROSES/user_proses.php',
      data : data,
      success: function(data){
        if(data == "SUKSES" )
        {
          alert("Data Save: " + data);
           $('#namabarang_txt').val("");
           $('#kodebarang_txt').val("");
           $('#harga_txt').val("");
           $('#qty_txt').val("");
          $.ajax({
            type: "GET",
            url: "_proses/user_proses.php?action=salesorderd&nobukti=" + nobukti,                          
            success: function(response){                    
              $("#salesorder").html(response); 
            }
          });
        }
        else
        {
          alert("Data Save: " + data);
        }
      }
    })
    var nobukti = $('#bukti_txt').val();
    $.getJSON('_proses/user_proses.php?action=getlastid&nobukti='+ nobukti, function (data) {
      var x = parseInt(data) + 1;
      $('#idbarang_txt').val(x);
        });
    
  });