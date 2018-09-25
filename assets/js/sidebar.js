$( "#piutang" ).click(function() {
    $('#menu_isi').empty();
    $("#menu_isi").load('view/piutanglist_view.php');
    $("#laporan").addClass('active');
    $("#sales_order").removeClass('active');
    $("#dashboard").removeClass('active');
});
$( "#persediaan" ).click(function() {
    $('#menu_isi').empty();
    $("#menu_isi").load('view/stoklist_view.php');
    $("#laporan").addClass('active');
    $("#sales_order").removeClass('active');
    $("#dashboard").removeClass('active');
});
$( "#penjualan" ).click(function() {
    $('#menu_isi').empty();
    $("#menu_isi").load('view/penjualanlist_view.php');
    $("#laporan").addClass('active');
    $("#sales_order").removeClass('active');
    $("#dashboard").removeClass('active');
});
$( "#dashboard" ).click(function(){
    $('#menu_isi').empty();
    $( "#menu_isi" ).load('view/dashboard_view.php');
    $("#laporan").removeClass('active');
    $("#sales_order").removeClass('active');
    $("#dashboard").addClass('active');
});
$( "#sales_order" ).click(function(){
    $('#menu_isi').empty();
    $( "#menu_isi" ).load('view/salesorderlist_view.php');
    $("#laporan").removeClass('active');
    $("#dashboard").removeClass('active');
    $("#sales_order").addClass('active');
});
$( "#logout" ).click(function(){
    window.location.href = '_PROSES/user_proses.php?action=logout';
});
$(document).ready(function(){
    $( "#menu_isi" ).load('view/dashboard_view.php');
})