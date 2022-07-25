<?php
require_once 'lib.php';

$signature = getSignature();
$key = $_GET['key'];

function getData($no,$signature){
global $response;

if (strlen($no)==19) {
$request_url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/".$no;} 
else {
$request_url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/Peserta/".$no;};

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
}

$asalfas = $response->response->asalFaskes;
$nokartu = $response->response->rujukan->peserta->noKartu;
$jnspelayanan = $response->response->rujukan->pelayanan->kode;
$kls = $response->response->rujukan->peserta->hakKelas->kode;
$nomr = $response->response->rujukan->peserta->mr->noMR;
$notelp = $response->response->rujukan->peserta->mr->noTelepon;
$diagawal = $response->response->rujukan->diagnosa->kode;
$user = $response->response->rujukan->peserta->nama;
$tglrujukan = $response->response->rujukan->tglKunjungan;
$ppkrujukan = $response->response->rujukan->provPerujuk->kode;
$asal = $response->response->rujukan->provPerujuk->nama;
$kodepoli = $response->response->rujukan->poliRujukan->kode;
$norujukan = htmlspecialchars($_GET['rujukan']);
$eksekutif = htmlspecialchars($_GET['eksekutif']);
$nosurat = htmlspecialchars($_GET['nosurat']);
$dpjp = htmlspecialchars($_GET['dpjp']);
$id = htmlspecialchars($_GET['id']);
$catatan = htmlspecialchars($_GET['catatan']);

//print_r($response);
// function insertSEP ($signature){
// global $sep;
$url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/SEP/1.1/insert";
$data = array(
    'request' => array(
    't_sep' => array(
        'noKartu' => $nokartu,
        'tglSep' => date("Y-m-d"),
        'ppkPelayanan' => '0613R001', 
        'jnsPelayanan' => $jnspelayanan,
        'klsRawat' => $kls,
        'noMR' => $nomr,
        'rujukan' => array(
        'asalRujukan' => $asalfas,
        'tglRujukan' => $tglrujukan,
        'noRujukan' => $norujukan,
        'ppkRujukan' => $ppkrujukan // PUSKESMAS PEMBUAT RUJUKAN
        ),
        'catatan' => $catatan,
        'diagAwal' => $diagawal, // icd-10
        'poli' => array(
        'tujuan' => $kodepoli,
        'eksekutif' => $eksekutif
        ),
        'cob' => array(
        'cob' => '0' // asuransi
        ),
        'katarak' => array(
        'katarak' => '0'
        ),
        'jaminan' => array(
        'lakaLantas' => '0',
        'penjamin' => array(
            'penjamin' => '1',
            'tglKejadian' => '',
            'keterangan' => '',
            'suplesi' => array(
            'suplesi' => '0',
            'noSepSuplesi' => '',
            'lokasiLaka' => array(
                'kdPropinsi' => '',
                'kdKabupaten' => '',
                'kdKecamatan' => ''
            )
            )
        )
        ),
        'skdp' => array(
        'noSurat' => $nosurat,
        'kodeDPJP' => $dpjp
        ),
        'noTelp' => $notelp,
        'user' => $user
    )
    )
);
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $signature);
//curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// print_r($data);
$sep= curl_exec($ch);
$error = curl_error($ch);
//print_r($sep);
curl_close($ch);
$sep = json_decode($sep);

$nosep = $sep->response->sep->noSep;
$tglsep = $sep->response->sep->tglSep;
$diagnosa = $sep->response->sep->diagnosa;
$peserta = $sep->response->sep->peserta->jnsPeserta;
$pelayanan = $sep->response->sep->jnsPelayanan;

$update =
"UPDATE `data` 
SET no_sep = '$nosep', kode_diag = '$diagnosa', tgl_sep = '$tglsep', faskesrujukan ='$asal', jnspeserta = '$peserta', jnspelayanan = '$pelayanan' WHERE idxdaftar = $id";

if ($conn->query($update) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  
$conn->close();

header("location:../simrs/DataList");
?>

