<?php
require_once("_DATABASE/db_function.php");
class process_data {
    
    private $periode;
    private $trx;

    function __construct()
    {
        $this->periode = date('Ym');
        $this->trx = new db_function();
    }

    function get_piutang_percustomer($kode)
    {
        $sql        = "SELECT 
                    CUSTOMER.NAMA,
                    CAST(PIUTANG.TGL AS DATE) AS TGL,
                    PIUTANG.KODECUSTOMER,
                    PIUTANG.NOFAKTUR,
                    PIUTANG.SISA
                    FROM PIUTANG 
                    JOIN CUSTOMER ON PIUTANG.KODECUSTOMER = CUSTOMER.KODE" ;
        $filter     = "(CUSTOMER.NAMA LIKE '%$kode%' AND SISA > 1 AND PERIODE = '$this->periode') 
                    OR (CUSTOMER.KODE LIKE '%$kode%' AND SISA > 1 AND PERIODE = '$this->periode') 
                    GROUP BY NAMA,NOFAKTUR,TGL,KODECUSTOMER,SISA";    
        $sql        = "$sql WHERE $filter";
        $rows       = $this->trx->get_data($sql);
        echo $rows; //--- UNTUK TEST HASIL
        //return $rows;
    }
    function sum_piutang_percustomer($kode)
    {
        $sql    = "SELECT SUM(PIUTANG.SISA) AS TOTAL_PIUTANG
                FROM PIUTANG 
                JOIN CUSTOMER ON PIUTANG.KODECUSTOMER = CUSTOMER.KODE" ;
        $filter = "SISA > 1 AND PERIODE = '$this->periode' AND CUSTOMER.NAMA LIKE '%$kode%' 
                GROUP BY KODECUSTOMER";    
        $sql    = "$sql WHERE $filter";
        $rows   = $this->trx->get_data($sql);
        echo $rows; //--- UNTUK TEST HASIL
        //return $rows;
    }
    
    function all_piutang_globalpercustomer()
    {
        $sql    = "SELECT 
                        CUSTOMER.NAMA NAMACUSTOMER,
                        CUSTOMER.KOTA KOTA,
                        CAST(SUM(PIUTANG.SISA) AS DOUBLE PRECISION) TOTALPIUTANG
                FROM PIUTANG 
                JOIN CUSTOMER ON PIUTANG.KODECUSTOMER = CUSTOMER.KODE" ;
        $filter = "SISA > 1 AND PERIODE = '$this->periode'";    
        $sql    = "$sql WHERE $filter GROUP BY NAMACUSTOMER,KOTA";
        $rows   = $this->trx->get_data($sql);
        //echo $rows; //--- UNTUK TEST HASIL
        return $rows;
    }
    function total_penjualan_by30date()
    {   
        $now = date('Y-m-d'); 
        $now30 =  date('Y-m-d',strtotime('-30 day',strtotime($now)));
        
        $sql    = "SELECT 
                    CAST(B.TGL AS DATE) TGL, 
                    CAST(SUM(A.JUMLAH3) AS DOUBLE PRECISION) JUMLAH
                    FROM JUAL_D A
                    JOIN JUAL_H B ON A.NOFAKTUR = B.NOFAKTUR";
        $filter =  "B.TGL <= '$now' AND B.TGL >= '$now30  ' GROUP BY TGL";
        $sql    = "$sql WHERE $filter";
        $rows   = $this->trx->get_data($sql);
        return $rows;
    }

    function get_nobukti_salesorder()
    {   
        $now = date('Ym'); 
        $sql     = "SELECT FIRST 1 NOBUKTI FROM SALESORDER_H";
        $filter  =  "NOBUKTI LIKE '$now%' ORDER BY NOBUKTI DESC";
        $sql     = "$sql WHERE $filter";
        $nobukti = $this->trx->get_data($sql);
        $decode = json_decode($nobukti);
        if (count($decode) > 0)
        {
            $hasil = $decode[0]->NOBUKTI + 1;
        }
        else
        {
            $hasil = $now."0001";
        }

        return json_encode($hasil);
    }

    function insert_salesorde2r()
    {   
        echo "benardi";
    
        //return json_encode($hasil);
    }


    function filter_piutang_globalpercustomer($customer)
    {   
        $customer = $customer ;
        $sql    = "SELECT 
                        B.NAMA NAMACUSTOMER,
                        B.KOTA KOTA,
                        CAST(SUM(A.SISA) AS DOUBLE PRECISION) TOTALPIUTANG
                FROM PIUTANG A 
                JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE" ;
        $filter = "SISA > 1 AND PERIODE = '$this->periode' AND B.NAMA LIKE '%$customer%'";    
        $sql    = "$sql WHERE $filter GROUP BY NAMACUSTOMER,KOTA";
        $rows   = $this->trx->get_data($sql);
        return $rows;
    }

    function filter_penjualan_pertanggal($awal,$akhir)
    {   
        $sql    = "SELECT 
                        B.NAMA NAMACUSTOMER,
                        A.NOFAKTUR,
                        CAST(A.TGL AS DATE) TGL,
                        D.NAMA NAMABARANG,
                        CAST(C.QTY AS DOUBLE PRECISION) QTY,
                        CAST(C.HARGAJUAL AS DOUBLE PRECISION) HARGA
                FROM JUAL_H A 
                JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE
                JOIN JUAL_D C ON A.NOFAKTUR = C.NOFAKTUR
                JOIN BARANG D ON C.KODEBARANG = D.KODE" ;
        $filter = "A.TGL >= '$awal' AND A.TGL <= '$akhir' ORDER BY TGL,NAMACUSTOMER,NOFAKTUR ASC";    
        $sql    = "$sql WHERE $filter";
        $rows   = $this->trx->get_data($sql);
        //echo $rows; //--- UNTUK TEST HASIL
        return $rows;
    }
    function filter_penjualan_pertgl_percust($awal,$akhir,$customer)
    {   
        $sql    = "SELECT 
                        B.NAMA NAMACUSTOMER,
                        A.NOFAKTUR,
                        CAST(A.TGL AS DATE) TGL,
                        D.NAMA NAMABARANG,
                        CAST(C.QTY AS DOUBLE PRECISION) QTY,
                        CAST(C.HARGAJUAL AS DOUBLE PRECISION) HARGA
                FROM JUAL_H A 
                JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE
                JOIN JUAL_D C ON A.NOFAKTUR = C.NOFAKTUR
                JOIN BARANG D ON C.KODEBARANG = D.KODE" ;
        $filter = "A.TGL >= '$awal' AND A.TGL <= '$akhir' AND B.NAMA LIKE UPPER('%$customer%') ORDER BY TGL,NAMACUSTOMER,NOFAKTUR ASC";    
        $sql    = "$sql WHERE $filter";
        $rows   = $this->trx->get_data($sql);
        //echo $rows; //--- UNTUK TEST HASIL
        return $rows;
    }

    function filter_salesorder_nfpercust()
    {   
        $sql    = "SELECT 
                        A.NOBUKTI,
                        B.NAMA NAMACUSTOMER,
                        D.NAMA NAMASALESMAN,
                        CAST(A.TGL AS DATE) TGL,
                        A.STATUS
                FROM SALESORDER_H A 
                JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE
                JOIN SALESMAN D ON A.KODESALESMAN = D.KODE";
        $filter = "NOT A.STATUS = 'CLEAR'";    
        $sql    = "$sql WHERE $filter";
        $rows   = $this->trx->get_data($sql);
        return $rows;
    }

    function filter_salesorder_percust($tgla,$tglb,$status,$customer)
    {   
        $sql    = "SELECT 
                        A.NOBUKTI,
                        B.NAMA NAMACUSTOMER,
                        D.NAMA NAMASALESMAN,
                        CAST(A.TGL AS DATE) TGL,
                        A.STATUS
                FROM SALESORDER_H A 
                JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE
                JOIN SALESORDER_D C ON A.NOBUKTI = C.NOBUKTI
                JOIN SALESMAN D ON A.KODESALESMAN = D.KODE";
        $filter = "A.STATUS = '$status' AND A.TGL >= '$tgla' AND A.TGL <= '$tglb' AND B.NAMA LIKE '%$customer%'";    
        $sql    = "$sql WHERE $filter";
        $rows   = $this->trx->get_data($sql);
        return $rows;
    }
    function get_idbaranglast($nobukti)
    {   
        $sql    = "SELECT FIRST 1
                        cast(A.ID as smallint) ID
                FROM SALESORDER_D A";
        $filter = "A.NOBUKTI = '$nobukti'";    
        $sql    = "$sql WHERE $filter ORDER BY ID DESC";
        $rows   = $this->trx->get_value($sql);
        return $rows;
    }

    ####################
    #PERSEDIAAN
    ####################  
    function cek_persediaan($kode)
    {

        $sql    = "SELECT FIRST 10
                BARANG.NAMA
                FROM PERSEDIAAN
                JOIN BARANG ON PERSEDIAAN.KODEBARANG = BARANG.KODE";
        $filter = "PERIODE= '$this->periode' AND BARANG.NAMA LIKE '%$kode%' AND SISA > 0 
                GROUP BY BARANG.NAMA";    
        $sql = "$sql WHERE $filter" ;

        $rows = $this->trx->get_data($sql); 
        echo $rows; //--- UNTUK TEST HASIL
        //return $rows;
    }

    function cek_gudang_persediaan2()
    {

        $sql    = "SELECT KODE FROM GUDANG";
        $filter = "AKTIF = 'YA' AND KODE LIKE '%AG%' ORDER BY KODE ASC";    
        $sql = "$sql WHERE $filter" ;

        $rows = $this->trx->get_data($sql); 
        //echo $rows; //--- UNTUK TEST HASIL
        return $rows;
    }
    function cek_gudang_persediaan()
    {

        $sql    = "SELECT KODEGUDANG FROM PERSEDIAAN";
        $filter = "PERIODE = '201809'  GROUP BY KODEGUDANG HAVING COUNT(KODEGUDANG) > 10 ORDER BY KODEGUDANG ASC ";    
        $sql = "$sql WHERE $filter" ;

        $rows = $this->trx->get_data($sql); 
        //echo $rows; //--- UNTUK TEST HASIL
        return $rows;
    }
    function gudang()
    {
        $list = $this->cek_gudang_persediaan();
        $decode = json_decode($list);
        $sql = array();
        foreach ($decode as $k)
        {
            $ben = "CAST(SUM(CASE WHEN KODEGUDANG='".$k->KODEGUDANG."'AND PERIODE='201809' AND SISA > 0 THEN PERSEDIAAN.SISA ELSE(0) END) AS DOUBLE PRECISION) AS GUDANG_".$k->KODEGUDANG."";
            array_push($sql,$ben);
        }
        $hasil = implode(",",$sql);
        return $hasil;
    }

    function hasil()
    {
        $sqlatas = $this->gudang();
        $contoh = "SELECT KODEBARANG,".$sqlatas." FROM PERSEDIAAN WHERE PERIODE='201809' GROUP BY KODEBARANG HAVING SUM(SISA) > 0" ;
        $rows = $this->trx->get_data($contoh); 
        return $rows;
    }

    function get_persediaanbarang($kode)
    {
        
        $sql    = "SELECT NAMA,KODEGUDANG,CAST(SUM(SISA) AS SMALLINT) AS SISA
                FROM PERSEDIAAN
                JOIN BARANG ON PERSEDIAAN.KODEBARANG = BARANG.KODE";
        $filter = "PERIODE = '$this->periode' AND NAMA LIKE '%$kode%' AND SISA > 0 
                GROUP BY NAMA,KODEGUDANG";
        $sql = "$sql WHERE $filter";
        $rows = $this->trx->get_data($sql); 
        echo $rows; //--- UNTUK TEST HASIL
        //return $rows;
    }
    
    function all_persediaanbarang($barang)
    {
      
        $sql    = "SELECT NAMA,KODEGUDANG,CAST(SUM(SISA) AS SMALLINT) AS SISA
                FROM PERSEDIAAN
                JOIN BARANG ON PERSEDIAAN.KODEBARANG = BARANG.KODE";
        $filter = "PERIODE = $this->periode AND NAMA LIKE '%$barang%' AND SISA > 0 GROUP BY NAMA,KODEGUDANG";
        $sql = "$sql WHERE $filter";
        $rows = $this->trx->get_data($sql); 
        echo $rows; //--- UNTUK TEST HASIL
        //return $rows;
    }

    function get_namabarang($kode)
    {
        $FILTER = "KODE LIKE UPPER('%$kode%') OR NAMA LIKE UPPER('%$kode%')" ;
        $query = "SELECT FIRST 10
                    BARANG.KODE KODE,
                    BARANG.NAMA NAMA
                 FROM BARANG";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $query = " $query ORDER BY IT DESCENDING";
        $rows  = $this->trx->get_data($query);
        //echo $rows; //--- UNTUK TEST HASIL
        return $rows;
    }
    function all_namabarang()
    {
        $FILTER = "" ;
        $query = "SELECT FIRST 290
                    BARANG.KODE KODE,
                    BARANG.NAMA NAMA
                 FROM BARANG";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $query = " $query ORDER BY IT DESCENDING";
        $rows  = $this->trx->get_data($query);
        //$rows; //--- UNTUK TEST HASIL
        return $rows;
    }

    function get_namasales($kode)
    {
        $FILTER = "NAMA LIKE '%$kode%' AND AKTIF = 'YA' OR KODE LIKE '%$kode%' AND AKTIF = 'YA'" ;
        $query = "SELECT FIRST 10
                    A.KODE KODE,
                    A.NAMA NAMA
                 FROM SALESMAN A";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $query = " $query ORDER BY KODE ASC";
        $rows  = $this->trx->get_data($query);
        return $rows;
    }

    function get_namacustomer($kode)
    {
        $FILTER = "NAMA LIKE '%$kode%' AND AKTIF = 'YA' OR KODE LIKE '%$kode%' AND AKTIF = 'YA'" ;
        $query = "SELECT FIRST 10
                    A.KODE KODE,
                    A.NAMA NAMA
                 FROM CUSTOMER A";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $query = " $query ORDER BY KODE ASC";
        $rows  = $this->trx->get_data($query);
        return $rows;
    }

    function insert_salesorderh($data)
    {
        $sql    = "UPDATE OR INSERT INTO SALESORDER_H (NOBUKTI,TGL,KODESALESMAN,KODECUSTOMER,CATATAN,TERM,TERCETAK,USERID,DISCOUNT,IT,STATUS,KODEGUDANG,PPN,PPN_JENIS,MTU) VALUES
                  (:nobukti,:tgl,:kodesalesman,:kodecustomer,:catatan,:term,:tercetak,:userid,:discount,:it,:status,:kodegudang,:ppn,:ppn_jenis,:mtu)" ;

        $rows = $this->trx->insert_query($sql,$data);
        return $rows;
    }
    function insert_salesorderd($data)
    {
        $sql    = "INSERT INTO SALESORDER_D (NOBUKTI,ID,KODEBARANG,QTY,HARGAJUAL,DISCOUNTITEM,IT) VALUES
                    (:nobukti,:id,:kodebarang,:qty,:hargajual,:discountitem,:it)" ;
        $rows2 = $this->trx->insert_query($sql,$data);
        return $rows2;
    }
    function update_salesorderd($data)
    {
        $sql    = "UPDATE SALESORDER_D SET KODEBARANG = :kodebarang, QTY = :qty,HARGAJUAL= :hargajual,ET = :et  WHERE NOBUKTI = :nobukti AND ID = :id " ;
        $rows = $this->trx->insert_query($sql,$data);
        return $rows;
    }

    function get_piutang_jatem()
    {
        $now = date('Y-m-d');
        $sql = "SELECT 
                B.NAMA NAMACUSTOMER,
                A.NOFAKTUR NOFAKTUR,
                CAST(A.TGL AS DATE) TGL,
                C.NAMA NAMASALESMAN,
                CAST(A.SISA AS DOUBLE PRECISION) SISA,
                CAST(A.JATUHTEMPO AS DATE) JATUHTEMPO
                FROM PIUTANG A
                JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE
                JOIN SALESMAN C ON A.KODESALESMAN = C.KODE 
                WHERE JATUHTEMPO <= '$now' AND SISA > 0 AND PERIODE = '$this->periode';";
        $rows  = $this->trx->get_data($sql);
        return $rows;
    }
    function get_salesorderd($nobukti)
    {
        $FILTER = "NOBUKTI = '$nobukti'" ;
        $query = "SELECT 
                    A.NOBUKTI NOBUKTI,
                    A.ID ID,
                    A.KODEBARANG KODE,
                    B.NAMA NAMABARANG,
                    CAST(A.QTY AS SMALLINT) QTY,
                    CAST(A.HARGAJUAL AS DOUBLE PRECISION) HARGA,
                    CAST(A.JUMLAH3 AS DOUBLE PRECISION) TOTAL
                 FROM SALESORDER_D A
                 JOIN BARANG B ON A.KODEBARANG = B.KODE";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $rows  = $this->trx->get_data($query);
        return $rows;
    }

    function get_salesorderh($nobukti)
    {
        $FILTER = "NOBUKTI = '$nobukti'" ;
        $query = "SELECT 
                    A.NOBUKTI NOBUKTI,
                    A.KODECUSTOMER KODECUSTOMER,
                    B.NAMA NAMACUSTOMER,
                    A.KODESALESMAN KODESALESMAN,
                    C.NAMA NAMASALESMAN,
                    CAST(A.TGL AS DATE) TGL,
                    CAST(A.TERM AS SMALLINT) TERM,
                    A.CATATAN
                 FROM SALESORDER_H A
                 JOIN CUSTOMER B ON A.KODECUSTOMER = B.KODE
                 JOIN SALESMAN C ON A.KODESALESMAN = C.KODE ";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $rows  = $this->trx->get_data($query);
        return $rows;
    }

    function delete_salesorderd($nobukti)
    {
        $data   = array("nobukti"=>$nobukti);
        $sql    = "DELETE FROM SALESORDER_D WHERE NOBUKTI = :nobukti" ;      $rows   = $this->trx->insert_query($sql,$data);
    }
    function delete_salesorderh($nobukti)
    {
        $data   = array("nobukti"=>$nobukti);
        $sql    = "DELETE FROM SALESORDER_H WHERE NOBUKTI = :nobukti" ;
        //$sql2    = "DELETE FROM SALESORDER_H WHERE NOBUKTI = :nobukti" ;
        $rows   = $this->trx->insert_query($sql,$data);
        //$rows2   = $this->trx->insert_query($sql,$data);
    }
    function get_salesorderd_byid($nobukti,$id)
    {
        $sql    = "SELECT
                    A.NOBUKTI NOBUKTI,
                    A.ID ID,
                    A.KODEBARANG KODEBARANG,
                    B.NAMA NAMABARANG,
                    CAST(A.QTY AS SMALLINT) QTY,
                    CAST(A.HARGAJUAL AS INT) HARGAJUAL
                   FROM SALESORDER_D A
                   JOIN BARANG B ON A.KODEBARANG = B.KODE
                   WHERE NOBUKTI = '$nobukti' AND ID ='$id' " ;
        $rows   = $this->trx->get_data($sql);
        return $rows;  
    }
    function delete_salesorderd_byid($nobukti,$id)
    {
        $data   = array("nobukti"=>$nobukti,"id"=>$id);
        $sql    = "DELETE FROM SALESORDER_D WHERE NOBUKTI = :nobukti AND ID =:id " ;
        $rows   = $this->trx->insert_query($sql,$data);        
    }
    ####################
    # USER MANAGEMENT
    #################### 
    function login_proses($username,$password)
    {
        $FILTER = "NAMA = '$username' AND PASS = '$password'";    
        $sql    = "SELECT COUNT(*) FROM USERID" ;
        
        if ($FILTER<>"")
            { 
            $sql = " $sql WHERE $FILTER " ;
            }

        $rows = $this->trx->get_value($sql);
        return $rows;
    }

    function register_proses($username,$password,$telegramid)
    {
        $data   = array("telegramid"=>$telegramid,"uname"=>$username,"upass"=>$password);
        $sql    = "UPDATE USERID SET TELEGRAMID = :telegramid WHERE NAMA =:uname AND PASS = :upass" ;
        $rows   = $this->trx->insert_query($sql,$data);
        $FILTER = "NAMA = '$username' AND PASS = '$password' AND TELEGRAMID= '$telegramid'";    
        $cek    = "SELECT COUNT(*) FROM USERID" ;
        
        if ($FILTER<>"")
            { 
            $cek = " $cek WHERE $FILTER " ;
            }

        $rows = $this->trx->get_data($cek);
        Echo $rows;

    }


    function RemoveSpec($str)
    {
        $str = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str);
        $str = trim($str);
        return $str;
    }

    function user_login($userid)
    {
        $FILTER = "NAMA = '$userid'" ;
        $query = "SELECT NAMA,PASS
        FROM USERID";
        if ($FILTER<>"")
        { 
            $query = " $query WHERE $FILTER " ;
        }
        $query = " $query ORDER BY IT DESCENDING";
        $cari  = $this->trx->get_data($query);
        echo $cari;
    }


}
?>