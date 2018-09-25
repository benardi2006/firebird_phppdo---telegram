<?php
include __DIR__ . '/../process_data.php';
session_start();
$data = new process_data();
	if(isset($_POST["action"]))
	{
		$action = strtolower($_POST["action"]);
		switch($action)
		{
			case "login":
			$username = $_POST["uname"];
			$password = $_POST["upass"];
			$hasil = $data->login_proses($username,$password);
			if ($hasil == 1)
			{
				$_SESSION["username"] = $username;
				echo "SUKSES";
			}
			exit();
			break;

			case "insertso":
			$hasil = array("nobukti"=>$_POST["NOBUKTI"],
							"tgl"=>$_POST["TGL"],
							"kodesalesman"=>$_POST["KODESALESMAN"],
							"kodecustomer"=>$_POST["KODECUSTOMER"],
							"catatan"=>$_POST["CATATAN"],
							"term"=>$_POST["TERM"],
							"tercetak"=>"N",
							"userid"=>$_SESSION["username"],
							"discount"=>"0",
							"it"=>date('Y-m-d h:i:s'),
							"status"=>"REQ",
							"kodegudang"=>"AG01",
							"ppn"=>"0",
							"ppn_jenis"=>"INCLUDE",
							"mtu"=>"IDR");

			$hasil2 = array("nobukti"=>$_POST["NOBUKTI"],
							"it"=>date('Y-m-d h:i:s'),	
							"id"=>$_POST["ID"],
							"kodebarang"=>$_POST["KODEBARANG"],
							"qty"=>$_POST["QTY"],
							"hargajual"=>$_POST["HARGAJUAL"],
							"discountitem"=>"0");
			//$insert = json_encode($hasil);
			$query1 = $data->insert_salesorderh($hasil);
			$query = $data->insert_salesorderd($hasil2);

			if($query == "" AND $query1 == "")
			{
				echo "SUKSES";
			}
			else{
				echo $query1 ;
				echo $query ;
			};
			exit();
			break;
			case "updatesod":
			$hasil = array("nobukti"=>$_POST["NOBUKTI"],
							"et"=>date('Y-m-d h:i:s'),	
							"id"=>$_POST["ID"],
							"kodebarang"=>$_POST["KODEBARANG"],
							"qty"=>$_POST["QTY"],
							"hargajual"=>$_POST["HARGAJUAL"]);
			$query = $data->update_salesorderd($hasil);

			if($query == "")
			{
				echo "SUKSES";
			}
			else{
				echo $query ;
			};
			exit();
			break;
			default:
			echo "busuk";
		}
	}

	if(isset($_GET["action"]))
	{
		$action = strtolower($_GET["action"]);
		switch($action)
		{
			case "logout":
			session_unset();
			session_destroy();
			header('Location:../login.php');
			exit();
			break;
			//===========
			case "allbarang":
			$json = $data->all_namabarang();
			echo $json;
			exit();
			break;
			//===========
			case "filterpiutangglobalcust":
			$kode = strtoupper($_GET["kode"]);
			$json = $data->filter_piutang_globalpercustomer($kode);
			$decode = json_decode($json);
			$i = 1;
			foreach($decode as $a)
			{
				echo "<tr>";
				echo "<td>".$i.".</td>";
				echo "<td>".$a->NAMACUSTOMER."</td>";
				echo "<td>".$a->KOTA."</td>";
				echo "<td> Rp. ".number_format($a->TOTALPIUTANG,0,",",".")."</td>";
				echo "</tr>";
				$i++;
			}
			exit();
			break;
			//===========
			case "allpiutangglobalcust":
			$json = $data->all_piutang_globalpercustomer();
			$decode = json_decode($json);
				$i = 1;
				foreach($decode as $a)
					{
						echo "<tr>";
						echo "<td>".$i.".</td>";
						echo "<td>".$a->NAMACUSTOMER."</td>";
						echo "<td>".$a->KOTA."</td>";
						echo "<td>Rp. ".number_format($a->TOTALPIUTANG,0,",",".")."</td>";
						echo "</tr>";
						$i++;
					}
			exit();
			break;
			//===========
			case "filterpenjualanpertanggal":
				$customer = $_GET["customer"];
				$awal = $_GET["awal"];
				$akhir = $_GET["akhir"];
				$json = $data->filter_penjualan_pertgl_percust($awal,$akhir,$customer);
				$decode = json_decode($json);
				foreach($decode as $a)
				{
					echo "<tr>";
					echo "<td>".$a->NAMACUSTOMER."</td>";
					echo "<td>".$a->NOFAKTUR."</td>";
					echo "<td>".date('d-m-Y',strtotime($a->TGL))."</td>";
					echo "<td>".$a->NAMABARANG."</td>";
					echo "<td>".number_format($a->QTY,0,",",".")."</td>";
					echo "<td> Rp. ".number_format($a->HARGA,0,",",".")."</td>";
					echo "</tr>";
				}
			exit();
			break;
			//===========
			case "liststok":
			$json = $data->cek_gudang_persediaan();
			$decode = json_decode($json);
			$kodegudang = array();
			echo "<thead><tr>";
			echo "<th>KODE BARANG</th>";

			foreach($decode as $a)
			{
				echo "<th>".$a->KODEGUDANG."</th>";
				array_push($kodegudang,"GUDANG_".$a->KODEGUDANG."");
			}
			echo "</tr></thead>";
			echo "<tbody>";
			$json2 = $data->hasil();
			$decode2 = json_decode($json2);
			foreach($decode2 as $b)
			{
				echo "<tr>";
				echo "<td>".$b->KODEBARANG."</td>";
				foreach($kodegudang as $k)
				{
					echo "<td>".number_format($b->$k,0,",",".")."</td>";
				}
				echo "</tr>";
			}
			echo "</tbody>";
			exit();
			break;
			//===========

			case "listso":
			$json 	= $data->filter_salesorder_nfpercust();
			$decode = json_decode($json);
			foreach($decode as $b)
			{
				echo "<tr>";
				echo "<td>".$b->NOBUKTI."</td>";
				echo "<td>".date("d-m-Y",strtotime($b->TGL))."</td>";
				echo "<td>".$b->NAMACUSTOMER."</td>";
				echo "<td>".$b->NAMASALESMAN."</td>";
				echo "<td>".$b->STATUS."</td>";
				echo "<td><div class='btn-group btn-group-sm' role='group' aria-label='Button group with nested dropdown'>
				<button type='button' id='view_so_btn' class='btn btn-secondary btn-primary' value='".$b->NOBUKTI."' onclick='getSO(this);'><i 
				class='fa fa-edit'></i></button>
				<button type='button' id='delete_so_btn' class='btn btn-secondary btn-danger' value='".$b->NOBUKTI."' onclick='deleteSO(this);'><i class='fa fa-trash'></i></button>
				</div></td>";
				echo "</tr>";
			}
			exit();
			break;
			//===========

			case "jatemlist":
			$json 	= $data->get_piutang_jatem();
			$decode = json_decode($json);
			foreach($decode as $b)
			{
				echo "<tr>";
				echo "<td>".$b->NAMACUSTOMER."</td>";
				echo "<td>".$b->NOBUKTI."</td>";
				echo "<td>".date("d-m-Y",strtotime($b->TGL))."</td>";
				echo "<td>".$b->NAMASALESMAN."</td>";
				echo "<td>".date("d-m-Y",strtotime($b->JATUHTEMPO))."</td>";
				echo "<td>".number_format($b->SISA,2)."</td>";
				echo "</tr>";
			}
			exit();
			break;

			case "datapenjualan":
			$json 	= $data->total_penjualan_by30date();
			$penjualan = array("penjualan" => json_decode($json));
			echo json_encode($penjualan);
			exit();
			break;
			case "filterso":
				$tgla = $_GET['tgla'];
				$tglb = $_GET['tglb'];
				$customer = strtoupper($_GET['customer']);
				$status = $_GET['status'];
				$json 	= $data->filter_salesorder_percust($tgla,$tglb,$status,$customer);
				$decode = json_decode($json);
				foreach($decode as $b)
				{
					echo "<tr>";
					echo "<td>".$b->NOBUKTI."</td>";
					echo "<td>".date("d-m-Y",strtotime($b->TGL))."</td>";
					echo "<td>".$b->NAMACUSTOMER."</td>";
					echo "<td>".$b->NAMASALESMAN."</td>";
					echo "<td>".$b->STATUS."</td>";
					echo "<td><div class='btn-group btn-group-sm' role='group' aria-label='Button group with nested dropdown'>
					<button type='button' id='view_so_btn' class='btn btn-secondary btn-primary' value='".$b->NOBUKTI."' onclick='getSO(this);'><i class='fa fa-edit'></i></button>
					<button type='button' id='delete_so_btn' class='btn btn-secondary btn-danger' value='".$b->NOBUKTI."' onclick='deleteSO(this);'><i class='fa fa-trash'></i></button>
					</div></td>";
					echo "</tr>";
				}
			//echo $json;
			exit();
			break;
			case "getbukti":
			$hasil = $data->get_nobukti_salesorder();
			echo $hasil;
			exit();
			break;
			case "getlastid":
			$hasil = $data->get_idbaranglast($_GET['nobukti']);
			if ($hasil == NULL)
			{
				$hasil = 0;
			}
			echo $hasil;
			exit();
			break;
			//===========

			case "salesorderd":
			$json 	= $data->get_salesorderd($_GET['nobukti']);
			$decode = json_decode($json);
			foreach($decode as $b)
			{
				echo "<tr>";
				//echo "<td>".$b->NOBUKTI."</td>";
				echo "<td>".$b->ID."</td>";
				echo "<td>".$b->KODE."</td>";
				echo "<td>".$b->NAMABARANG."</td>";
				echo "<td>".number_format($b->QTY,0)."</td>";
				echo "<td>Rp  ".number_format($b->HARGA,2)."</td>";
				echo "<td>Rp  ".number_format($b->TOTAL,2)."</td>";
				echo "<td>
				<div class='btn-group btn-group-sm pull-right' role='group' aria-label='Button group with nested dropdown'>
				<button type='button' id='edit_salesorderdetail_btn' class='btn btn-secondary btn-success' value='nobukti=".$b->NOBUKTI."&id=".$b->ID."' onclick='getdSO(this);' data-toggle='modal' data-target='#barang_modal'><i class='fa fa-edit'></i></button>
				<button type='button' id='delete_salesorderdetail_btn' class='btn btn-secondary btn-danger' value='nobukti=".$b->NOBUKTI."&id=".$b->ID."' onclick='deletedSO(this);'><i class='fa fa-trash'></i></button>
				</div>
				</td>";
				echo "</tr>";
			}
			exit();
			break;
			//===========
			case "getheaderso":
			$json 	= $data->get_salesorderh($_GET['nobukti']);
			//$decode = json_decode($json);
			//$decode2 = array("header" => $decode );
			echo  $json;//json_encode($decode2);
			exit();
			break;	
			//===========
			case "getdetailso":
			$json 	= $data->get_salesorderd_byid($_GET['nobukti'],$_GET['id']);
			//$decode = json_decode($json);
			//$decode2 = array("header" => $decode );
			echo  $json;//json_encode($decode2);
			exit();
			break;	
			//===========
			case "deleteso":
			$data->delete_salesorderd($_GET['nobukti']);
			$data->delete_salesorderh($_GET['nobukti']);
			$json = "berhasil";//$decode = json_decode($json);
			//$decode2 = array("header" => $decode );
			echo  $json;//json_encode($decode2);
			exit();
			break;
			case "deletedetailso":
			$data->delete_salesorderd_byid($_GET['nobukti'],$_GET['id']);
			$json = "berhasil";
			echo  $json;
			exit();
			break;
			default:
			echo "busuk";
		}
	}

	if(isset($_GET["term"]))
	{  
		$tabel = $_GET["tabel"];
		switch($tabel)
		{
			case "barang":
			$barang = trim(strip_tags($_GET["term"]));
			$hasil = $data->get_namabarang($barang);
			$decode = json_decode($hasil);
			foreach ($decode as $a)
			{
				$row['id'] = htmlentities(stripslashes($a->KODE));
				$row['value'] = htmlentities(stripslashes($a->NAMA));
				$row_set[] = $row;
			}
			echo json_encode($row_set);
			exit();
			break;
			case "salesman":
			$sales = strtoupper(trim(strip_tags($_GET["term"])));
			$hasil = $data->get_namasales($sales);
			$decode = json_decode($hasil);
			foreach ($decode as $a)
			{
				$row['id'] = htmlentities(stripslashes($a->KODE));
				$row['value'] = htmlentities(stripslashes($a->NAMA));
				$row_set[] = $row;
			}
			echo json_encode($row_set);
			exit();
			break;
			case "customer":
			$customer = strtoupper(trim(strip_tags($_GET["term"])));
			$hasil = $data->get_namacustomer($customer);
			$decode = json_decode($hasil);
			foreach ($decode as $a)
			{
				$row['id'] = htmlentities(stripslashes($a->KODE));
				$row['value'] = htmlentities(stripslashes($a->NAMA));
				$row_set[] = $row;
			}
			echo json_encode($row_set);
			exit();
			break;

			default:
			echo "busuk";
		}
    }
?>

