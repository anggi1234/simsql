<?php
// include autoloader
require_once 'dompdf/autoload.inc.php';
require_once 'lib.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
// instantiate and use the dompdf class
$dompdf = new Dompdf($options);
$id = htmlspecialchars($_GET["id"]);
$today = date("d/m/Y H:i:s A"); 

$sql = "
SELECT
	a.no_sep, 
	a.tgl_sep, 
	a.nomr, 
	a.no_kartu, 
	a.pasien_nama, 
	a.pasien_tgl_lahir, 
	a.pasien_jenis_kelamin, 
	c.userlevelname, 
	a.faskesrujukan, 
	a.kode_diag, 
	a.catatan, 
	a.jnspeserta, 
	a.cob, 
	a.jnspelayanan, 
	a.kelas,
  a.count
FROM
	`data` AS a
	LEFT JOIN
	m_dokter AS b
	ON 
		b.kddokter = a.kode_dpjp
	LEFT JOIN
	userlevels AS c
	ON 
		a.userlevelid = c.userlevelid
WHERE
	a.idxdaftar = $id AND
	c.id_instalasi = 1;
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();


	$row["tgl_sep"]; 
	$row["nomr"]; 
	$row["no_kartu"]; 
	$row["pasien_nama"]; 
	$row["pasien_tgl_lahir"]; 
	$row["pasien_jenis_kelamin"]; 
	$row["userlevelname"]; 
	$row["faskesrujukan"]; 
	$row["kode_diag"]; 
	$row["catatan"]; 
	$row["jnspeserta"]; 
	$row["cob"]; 
	$row["jnspelayanan"]; 
	$row["kelas"]; 
  $count = $row["count"] + 1; 

ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
	@page { 
				size: 21cm 10cm ;
				margin: 20px; }
.style13 {font-size: small}
.style16 {font-size: large; font-weight: bold; }
.style14 {font-size: small;}
html { margin: 8px;  font-family: Arial, Helvetica, sans-serif;}
.style18 {font-size: medium; }
.style19 {font-size: large;	font-weight: bold;}
.style12 {font-size: small;}  
.style11 {font-size: x-small;	font-style: italic;}
.style20 {font-size: xx-small}
.style21 {font-size: medium}


</style>
</head>

<body>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" rowspan="2"><img src="http://localhost/simrs/bridging/bpjs.png" width="240" alt="bpjs" /></td>
    <td width="57%"><div align="center" class="style16">SURAT ELEGIBILITAS PESERTA </div></td>
    <td width="18%">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center" class="style16">RSUD BESEMAH</div></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td width="15%"><span class="style18" >No. SEP</span></td>
    <td width="1%">:</td>
    <td width="39%"><span class="style19"><?php echo $row["no_sep"]; ?></span></td>
    <td width="13%">&nbsp;</td>
    <td width="1%"></td>
    <td width="1%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style18" >Tgl. SEP</span></td>
    <td>:</td>
    <td><?php echo $row["no_sep"]; ?></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style18" >No.Kartu</span></td>
    <td>:</td>
    <td><?php echo $row["no_kartu"].' No.MR:'.$row["nomr"]; ?></td>
    <td class="style14">Peserta</td>
    <td>: </td>
    <td colspan="2"><?php echo $row["jnspeserta"];  ?></td>
  </tr>
  <tr>
    <td><span class="style18" >Nama Peserta </span></td>
    <td>:</td>
    <td><?php  echo $row["pasien_nama"]; ?></td>
    <td class="style14">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style14">Tgl.Lahir</span></td>
    <td>:</td>
    <td><span class="style12">
      <?php  echo date_format(date_create($row["pasien_tgl_lahir"]),"d/m/Y"); ?>
    </span></td>
    <td class="style14">COB</td>
    <td>:</td>
    <td colspan="2"><span class="style12"><?php echo $row["cob"];  ?></span></td>
  </tr>
  <tr>
    <td class="style14"><span class="style13">Jns.Kelamin</span></td>
    <td>:</td>
    <td><span class="style12"><?php echo $row["pasien_jenis_kelamin"]; ?></span></td>
    <td class="style14">Jns.Rawat</td>
    <td>:</td>
    <td colspan="2"><span class="style12"><?php echo $row["jnspelayanan"];  ?></span></td>
  </tr>
  <tr>
    <td class="style14"><span class="style13">Poli Tujuan</span></td>
    <td>:</td>
    <td><span class="style13"><?php echo $row["userlevelname"];  ?></span></td>
    <td class="style14">Kls.Rawat</td>
    <td>:</td>
    <td colspan="2"><span class="style12">
      <?php /*echo $resultarr['response']['klsRawat']['nmKelas']; */  echo 'Kelas '.$row["kelas"]; ?>
    </span></td>
  </tr>
  <tr>
    <td class="style14"><span class="style13">Asal Faskes</span></td>
    <td>:</td>
    <td><span class="style13"><?php echo $row["faskesrujukan"];  ?></span></td>
    <td class="style14">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style14"><span class="style13">Diagnosa Awal</span></td>
    <td>:</td>
    <td><span class="style12"><?php echo $row["kode_diag"];  ?></span></td>
    <td class="style14">Pasien/</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="style14"><span class="style12">Petugas</span></td>
  </tr>
  <tr>
    <td class="style14"><span class="style13">Catatan</span></td>
    <td>:</td>
    <td><span class="style12"><?php echo $row["catatan"];  ?></span></td>
    <td class="style14">Keluarga Pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="style14"><span class="style12" >BPJS Kesehatan</span></td>
  </tr>
  <tr>
    <td colspan="3" class="style14"><span class="style7 style11 style20" >*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan. </span></td>
    <td class="style14">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="style14"><span class="style7 style11 style20" >*SEP bukan sebagai bukti penjamin peserta </span></td>
    <td class="style14">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="style14"><span class="style14">Cetakan ke<span class="style14"><?php echo ' '.$count.' '.$today;  ?></span></span></td>
    <td class="style14">______________</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="style14">_____________</td>
  </tr>
</table>
</body>
</html>
<?php
$update_sql= "UPDATE `data` SET `count` = `count` + 1 WHERE idxdaftar = $id";
$eeeeee = $conn->query($update_sql);

$html = ob_get_contents();

ob_end_clean();
$dompdf->loadHtml($html);


// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');
// $customPaper = array(0,0,625,440);
// $dompdf->set_paper($customPaper);
// Render the HTML as PDF
$dompdf->render();



// Output the generated PDF to Browser
//$dompdf->stream();
$dompdf->stream('tampilkan.pdf',array('Attachment' => 0)); //display pdf
?>