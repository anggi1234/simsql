<?php

namespace PHPMaker2021\simrs;

// Page object
$CallStoredProcedure = &$Page;
?>
<?php
$serverName = "localhost, 50201"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array("Database" => "RSUD_BESEMAH_VCLAIM_V11", "UID" => "sa", "PWD" => "Agussalim7");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn) {
    echo "Connection established.<br />";
} else {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
}

?>
<div class="card">
    <div class="card-header">
        <h5 class="m-0">Latest News</h5>
    </div>
    <div class="card-body">
        <h6 class="card-title">2020/09/07 - PHPMaker 2021 Released</h6>
        <p class="card-text">For more information, please visit PHPMaker website.</p>
        <a href="https://phpmaker.dev" class="btn btn-primary">Go to PHPMaker website</a>
    </div>
</div>

<?= GetDebugMessage() ?>
