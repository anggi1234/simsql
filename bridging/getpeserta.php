<?php
require_once 'lib.php';

$signature = getSignature();
$key = $_GET['key'];
$id = $_GET['id'];

function getData($no,$signature){
global $response;

$request_url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nokartu/".$no."/tglSEP/".date("Y-m-d");

$ch = curl_init($request_url);
//curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $signature);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
//curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


$response = curl_exec($ch);
$error = curl_error($ch);
//echo $response['response']['peserta']['jenisPeserta']['keterangan'];
$response = json_decode($response);     
curl_close($ch);
}

if (isset($key)) {
getData($key,$signature);
};


if ($response->metaData->code == 200) {
    $kelas = $response->response->peserta->hakKelas->kode;
    $jnspeserta = $response->response->peserta->jenisPeserta->kode;
    $nama = $response->response->peserta->nama;
    $nik = $response->response->peserta->nik;
    $pisa = $response->response->peserta->pisa;
    $penyedia = $response->response->peserta->provUmum->nmProvider;
    $sex = $response->response->peserta->sex;
    $status = $response->response->peserta->statusPeserta->kode;
    $cetak = $response->response->peserta->tglCetakKartu;
    $lahir = $response->response->peserta->tglLahir;
    $tat = $response->response->peserta->tglTAT;
    $tmt = $response->response->peserta->tglTMT;
    $umur = $response->response->peserta->umur->umurSekarang;

    $update = "UPDATE m_pasien 
    SET kelas = $kelas,
     id_jnspeserta = $jnspeserta,
      nama = '$nama',
       noktp = $nik,
       pisa = $pisa,
        bpjs_penyedia = '$penyedia',
        jeniskelamin = '$sex',
         bpjs_status = $status,
          bpjs_cetak = '$cetak',
           tgllahir = '$lahir',
            bpjs_tat = '$tat',
             bpjs_tmt = '$tmt',
              umur = '$umur'
    WHERE id = $id;";

    echo $update;

    if ($conn->query($update) === TRUE) {
        echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $conn->error;
      };
} else { 
    $msg = $response->metaData->message;
    
};


// } else { 
//     echo "<script type='text/javascript'>alert('Periksa Kembali Nomor BPJS & Nomor Rujukan');</script>";
// }

// $update =
// "UPDATE `data` 
// SET no_sep ='$nosep', kode_diag = '$diagnosa', tgl_sep = '$tglsep', faskesrujukan ='$asal', jnspeserta = '$peserta', jnspelayanan = '$pelayanan' WHERE idxdaftar = $id";


  
$conn->close();

header("location:https://192.168.1.234/simrs/VPasienEdit/".$id);
?>