<?php 

include ("process_data.php");
$data = new process_data();
//$data->user_login("ben");
//$data->all_namabarang();
$json = $data->get_piutang_jatem();

//$data->get_piutang_percustomer('ABACUS');
//echo "<br>";
//$data->get_stokbarang('411');
//$a = '2018-01-20';
//$b = '201L8-08-20';
//$c = 'REQ';
//$d = 'ILOGO';
//$json = $data->filter_salesorder_percust($a,$b,$c,$d);
echo $json;
/*$decode = json_decode($json);
foreach($decode as $a)
{
    echo "<tr><td>".$a->KODE."</td></tr><br>";
}

?>*/
