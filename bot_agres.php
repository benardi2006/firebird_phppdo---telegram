<?php

require_once 'token.php';

// masukkan bot token di sini
define('BOT_TOKEN', $token);

// versi official telegram bot
 define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

// ambil databasenya
require_once 'data_proses/database/db_connector.php';
require_once 'data_proses/proses_database.php';

// aktifkan ini jika ingin menampilkan debugging poll
$debug = true;
echo 'SERVER SEDANG RUNNING'.PHP_EOL.date('Y-m-d H:i:s').PHP_EOL;


function exec_curl_request($handle)
{
    $response = curl_exec($handle);

    if ($response === false) {
        $errno = curl_errno($handle);
        $error = curl_error($handle);
        error_log("Curl returned error $errno: $error\n");
        curl_close($handle);

        return false;
    }

    $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
    curl_close($handle);

    if ($http_code >= 500) {
        // do not wat to DDOS server if something goes wrong
    sleep(10);

        return false;
    } elseif ($http_code != 200) {
        $response = json_decode($response, true);
        error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
        if ($http_code == 401) {
            throw new Exception('Invalid access token provided');
        }

        return false;
    } else {
        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successfull: {$response['description']}\n");
        }
        $response = $response['result'];
    }

    return $response;
}

function apiRequest($method, $parameters = null)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");

        return false;
    }

    if (!$parameters) {
        $parameters = [];
    } elseif (!is_array($parameters)) {
        error_log("Parameters must be an array\n");

        return false;
    }

    foreach ($parameters as $key => &$val) {
        // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
        $val = json_encode($val);
    }
    }
    $url = API_URL.$method.'?'.http_build_query($parameters);

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

    return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters)
{
    if (!is_string($method)) {
        error_log("Method name must be a string\n");

        return false;
    }

    if (!$parameters) {
        $parameters = [];
    } elseif (!is_array($parameters)) {
        error_log("Parameters must be an array\n");

        return false;
    }

    $parameters['method'] = $method;

    $handle = curl_init(API_URL);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
    curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    return exec_curl_request($handle);
}

// jebakan token, klo ga diisi akan mati
if (strlen(BOT_TOKEN) < 20) {
    die(PHP_EOL."-> -> Token BOT API nya mohon diisi dengan benar!\n");
}

function getUpdates($last_id = null)
{
    $params = [];
    if (!empty($last_id)) {
        $params = ['offset' => $last_id + 1, 'limit' => 1];
    }
  //echo print_r($params, true);
  return apiRequest('getUpdates', $params);
}

// matikan ini jika ingin bot berjalan
// die('baca dengan teliti yak!');

// ----------- pantengin mulai ini
function sendMessage($idpesan, $idchat, $pesan) 
{
    $data = [
    'chat_id'             => $idchat,
    'text'                => $pesan,
    'parse_mode'          => 'Markdown'
  ];

    return apiRequest('sendMessage', $data);
}

function processMessage($message)
{
    global $database;
    $proses_database = new proses_database();
    if ($GLOBALS['debug']) {
        print_r($message);
    }

  if (isset($message['message'])) 
  {
        $sumber = $message['message'];
        $idpesan = $sumber['message_id'];
        $idchat = $sumber['chat']['id'];

        $namamu = $sumber['from']['first_name'];
        $namamu = $sumber['from']['username'];
        $iduser = $sumber['from']['id'];
        $pecah2 = "";
    if (isset($sumber['text'])) 
    {
      $pesan = $sumber['text'];

      if (preg_match("/^piutang_((\w| )+)$/i", $pesan, $cocok)) 
            {
                $pesan = "/piutang $cocok[1]";
            }

      if (preg_match("/^\/hapus_(\d+)$/i", $pesan, $cocok)) 
            {
                $pesan = "/hapus $cocok[1]";
            }
     // print_r($pesan);*/

      $pecah = explode(' ', $pesan, 2);
      $fungsipencarian = strtolower($pecah[0]);
      switch ($fungsipencarian) 
      {
        case '/start':
          $text = "Hai `$namamu` Terima kasih telah bergabung dengan AGRES.ID.\n\nAGRES.ID adalah suatu platform Telegram berbasis algoritma untuk menjawab berbagai pertanyaan pengguna dan sales PT. Agres Info Teknologi yang ter-enkripsi guna melindungi kerahasian transmisi data dan percakapan anda.\n\nBagi anda yang sudah terdaftar dapat terhubung secara privat dengan sistem anda secara privat dengan cara melakukan sinkronisasi dengan cara mengaskes `register`.\n\nUntuk bantuan ketik: /bantuan";
          $hasil = sendMessage($idpesan, $idchat, $text);
        break;
        case '/register':
          $pecah = explode('#', $pesan, 2);
          $cekuser = $proses_database->login_proses($pecah[0],$pecah[1]);
          if($cekuser == 1)
          {
            $reg = $proses_database->register_proses($pecah[0],$pecah[1],$iduser);
            if($reg)
            {
              $text = "Registrasi berhasil. Selamat beraktifitas.";
            }
            else
            {
              $text= "Registrasi gagal";
            } 
          }
          else
          {
            $text = $pecah[0].$pecah[1];
          }
          $hasil = sendMessage($idpesan, $idchat, $text);
        break;
        #################
        case '/piutang':
          
          if (preg_match("/^\/piutang ((\w| )+)$/i", $pesan, $data_dicari)) 
          {
              $pesanproses = $data_dicari[1];
              $customer = strtoupper($pesanproses);
              $qty = json_decode($proses_database->cek_customer($customer));
              if(count($qty) == 1)
              {
                $datapiutang = json_decode($proses_database->get_piutang_percustomer($customer));
                $totalpiutang = json_decode($proses_database->sum_piutang_percustomer($customer));
                $text = "*".$datapiutang[0]->NAMA."* \n";
                $text .= '`Total Piutang` : Rp. '.number_format($totalpiutang[0]->TOTAL_PIUTANG,2)."\n\n";
                foreach ($datapiutang as $row) 
                {
                $text .= "`".date("d/m",strtotime($row->TGL))."\t".$row->NOFAKTUR."\t Rp. ".number_format($row->SISA)."` \n";
                }
              }
              elseif(count($qty) > 1)
              {
                $text = "*Data Piutang Customer yang tersedia:*\n\n";
                foreach ($qty as $row) 
                {
                  $text .= "*".$row->KODECUSTOMER."* - ".$row->NAMA."\n".$row->ALAMAT;
                  $text .= "\n";
                }
              }
              else
              {
                $text = "Customer sudah lunas atau tidak ada nama customer tersebut";
              }
              //$text = "jumlah customer : *".count($qty)."*";
          } 
          else 
          {
            $text = '⛔️ *ERROR:* `Format penulisan salah !! Mohon pilih ` /bantuan `untuk panduan penulisan .`';
          }
          $hasil = sendMessage($idpesan, $idchat, $text);
      break;

      case '/stok':
          
          if (preg_match("/^\/stok ((\w| )+)$/i", $pesan, $data_dicari)) 
          {
              $pesanproses = $data_dicari[1];
              $stok = strtoupper($pesanproses);
              $qty = json_decode($proses_database->cek_persediaan($stok));
              if(count($qty) == 1)
              {
                $datastok = json_decode($proses_database->get_stokbarang($stok));
                $text = "*".$datastok[0]->NAMA."* \n";
                foreach ($datastok as $row) 
                {
                $text .= "`".$row->KODEGUDANG."\t=\t".$row->SISA."`\n";
                }
              }
              elseif(count($qty) > 1)
              {
                $text = "*Data persediaan yang tersedia:*\n\n";
                foreach ($qty as $row) 
                {
                  $text .= $row->NAMA;
                  $text .= "\n";
                }
              }
              else
              {
                $text = "Nama barang salah atau persediaan telah habis";
              }
          } 
          else 
          {
            $text = '⛔️ *ERROR:* `Format penulisan salah !! Mohon pilih ` /bantuan `untuk panduan penulisan .`';
          }
           $hasil = sendMessage($idpesan, $idchat, $text);
      break;

      case '/penjualan':
        
          if (preg_match("/^\/stok ((\w| )+)$/i", $pesan, $data_dicari)) 
          {

              $pesanproses = strtoupper($data_dicari[1]);
              $pecahpesan = explode('#', $pesanproses, 2);
              $qty = json_decode($proses_database->detail_faktur_customer($pecahpesan[0],$pecahpesan[1]));
              if(count($qty) == 1)
              {
                foreach ($qty as $row) 
                {
                $text .= "`".$row->NOFAKTUR."\t=\t".$row->QTY."`\n";
                }
              }
              else
              {
                $text = "Nama barang salah atau persediaan telah habis";
              }
              //$text = "jumlah customer : *".count($qty)."*";
          } 
          else 
          {
            $text = '⛔️ *ERROR:* `Format penulisan salah !! Mohon pilih ` /bantuan `untuk panduan penulisan .`';
          }
           $hasil = sendMessage($idpesan, $idchat, $text);
      break;


      case '/bantuan':
          $text = "*MENU DALAM TELEGRAM AGRES*\n\n\n";
          $text .= "1. */piutang* `[pesan]` untuk mencari piutang detail nota customer \n";
          $text .= "\t\t`*Contoh :*` \n";
          $text .= "\t\t\t`/piutang ca`\n";
          $text .= "\t\t\t`/piutang cash`\n";
          $text .= "\t\t\t`/piutang CASH`\n";
          $text .= "2. */stok* `[pesan]` untuk mencari persediaan barang per gudang \n";
          $text .= "\t\t`*Contoh :*` \n";
          $text .= "\t\t\t`/stok 455LF`\n";
          $text .= "\t\t\t`/stok X361t`\n\n";
          $text .= "3. */penjualan* untuk mendapatkan informasi nilai penjualan hari ini\n";
          $text .= "\t\t`*Contoh :*`\n";
          $text .= "\t\t\t`/penjualan`\n\n";
          $text .= "4. */register* `[username#password]` untuk meregister pengguna telegram \n";
          $text .= "\t\t`*Contoh :*`\n";
          $text .= "\t\t\t`/register agung#1234`\n\n";
          $text .= "5. */laporan* `[pesan]` untuk mendapatkan link membuka sebuah laporan\n";
          $text .= "\t\t`*Contoh :*`\n";
          $text .= "\t\t\t`/laporan penjualan`\n\n";
          $text .= "6. */bantuan* untuk membantu pengguna mengenai instruksi penggunaan \n";
          $text .= "\t\t`*Contoh :*`\n";
          $text .= "\t\t\t`/bantuan`\n\n";
          $hasil = sendMessage($idpesan, $idchat, $text);         
      break;
      case '/laporan':
          $text = "*MENU DALAM PENGEMBANGAN*\n\n\n";

          $text .= "\t\t\t`/bantuan`\n\n";
          $hasil = sendMessage($idpesan, $idchat, $text);         
      break;

      default:
          $text = "Menu belum ada mohon diperiksa kembali penulisan pesan !\n";
          $text .= $pesan;
          $text .= $pecah2;
          $hasil = sendMessage($idpesan, $idchat, $text);
      break;

      }
    }
  }


     
        if ($GLOBALS['debug']) {
            // hanya nampak saat metode poll dan debug = true;
            echo 'Pesan yang dikirim: '.$text.PHP_EOL;
            print_r($hasil);
        }

}
// pencetakan versi dan info waktu server, berfungsi jika test hook

function printUpdates($result)
{
    foreach ($result as $obj) {
        // echo $obj['message']['text'].PHP_EOL;
    processMessage($obj);
        $last_id = $obj['update_id'];
    }

    return $last_id;
}

// AKTIFKAN INI jika menggunakan metode poll
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$last_id = null;
while (true) {
    $result = getUpdates($last_id);
    if (!empty($result)) {
        echo '+';
        $last_id = printUpdates($result);
    } else {
        echo '-';
    }

    sleep(1);
}
?>