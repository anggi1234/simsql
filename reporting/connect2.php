<?php
// $token  = 'sbSDGe3fn123';
$mysqli = new mysqli('localhost', 'root', '', 'simrs_3');
// && $token == $_GET['token']
if ($mysqli->connect_errno) {
    // JIKA KONEKSI BERMASALAH
    die('kesalahan saat membuat koneksi ke database. <br>' . $mysqli->error);
}
?>
