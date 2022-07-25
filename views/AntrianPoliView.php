<?php

namespace PHPMaker2021\simrs;

// Page object
$AntrianPoliView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fANTRIAN_POLIview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fANTRIAN_POLIview = currentForm = new ew.Form("fANTRIAN_POLIview", "view");
    loadjs.done("fANTRIAN_POLIview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ANTRIAN_POLI) ew.vars.tables.ANTRIAN_POLI = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_POLI")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fANTRIAN_POLIview" id="fANTRIAN_POLIview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_POLI">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->Id->Visible) { // Id ?>
    <tr id="r_Id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_Id"><?= $Page->Id->caption() ?></span></td>
        <td data-name="Id" <?= $Page->Id->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_Id">
<span<?= $Page->Id->viewAttributes() ?>>
<?= $Page->Id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_urut->Visible) { // no_urut ?>
    <tr id="r_no_urut">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_no_urut"><?= $Page->no_urut->caption() ?></span></td>
        <td data-name="no_urut" <?= $Page->no_urut->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
    <tr id="r_tanggal_daftar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_tanggal_daftar"><?= $Page->tanggal_daftar->caption() ?></span></td>
        <td data-name="tanggal_daftar" <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
    <tr id="r_tanggal_panggil">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_tanggal_panggil"><?= $Page->tanggal_panggil->caption() ?></span></td>
        <td data-name="tanggal_panggil" <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_tanggal_panggil">
<span<?= $Page->tanggal_panggil->viewAttributes() ?>>
<?= $Page->tanggal_panggil->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->loket->Visible) { // loket ?>
    <tr id="r_loket">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_loket"><?= $Page->loket->caption() ?></span></td>
        <td data-name="loket" <?= $Page->loket->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_loket">
<span<?= $Page->loket->viewAttributes() ?>>
<?= $Page->loket->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_panggil->Visible) { // status_panggil ?>
    <tr id="r_status_panggil">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_status_panggil"><?= $Page->status_panggil->caption() ?></span></td>
        <td data-name="status_panggil" <?= $Page->status_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_status_panggil">
<span<?= $Page->status_panggil->viewAttributes() ?>>
<?= $Page->status_panggil->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <tr id="r_THENAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_THENAME"><?= $Page->THENAME->caption() ?></span></td>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <tr id="r_VISIT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTRIAN_POLI_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></td>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_ANTRIAN_POLI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
