<?php
    function cetakan()
    {
        // url sample
        // http://103.100.27.71:8080/jasperserver/rest_v2/reports/reports/ERetribusiKotim/master_tarif_all_skpd.pdf?tahun=2021&key=02.05.01

        // akses dari web iframe
        // BASE_URL/?m=paket&f=cetakan&thn=2021&key=02.05.01&download=0 => hanya lihat
        // BASE_URL/?m=paket&f=cetakan&thn=2021&key=02.05.01&download=1 => download file

        if (empty($_GET['id'])) {
            echo "Tidak ada cetakan";
        } else {
            
            //$id = anti_injeksi($_GET['id']);
            $id = htmlspecialchars($_GET['id']);

            $userJasper = "jasperadmin";
            $passJasper = "jasperadmin";

            $URL = "http://192.168.1.234:8080/jasperserver/rest_v2/reports/Laporan/SURAT_KETERANGAN_KEMATIAN.pdf";

            $parameters = http_build_query([
                'id' => $id,
            ]);

            $nama_file = "SURAT_KETERANGAN_KEMATIAN" . ".pdf";
            $download = htmlspecialchars($_GET['download']);
            // $download = 1;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $URL . '?' . $parameters);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD, "$userJasper:$passJasper");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $report = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
            $info = curl_getinfo($ch);
            curl_close($ch);

            if ($download) {
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename=' . $nama_file . '');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . strlen($report));
            }
            header('Content-Type: application/pdf');

            echo $report;
        }
    }
    cetakan();
?>