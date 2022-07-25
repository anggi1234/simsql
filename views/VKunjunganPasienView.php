<?php

namespace PHPMaker2021\simrs;

// Page object
$VKunjunganPasienView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_KUNJUNGAN_PASIENview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fV_KUNJUNGAN_PASIENview = currentForm = new ew.Form("fV_KUNJUNGAN_PASIENview", "view");
    loadjs.done("fV_KUNJUNGAN_PASIENview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.V_KUNJUNGAN_PASIEN) ew.vars.tables.V_KUNJUNGAN_PASIEN = <?= JsonEncode(GetClientVar("tables", "V_KUNJUNGAN_PASIEN")) ?>;
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
<form name="fV_KUNJUNGAN_PASIENview" id="fV_KUNJUNGAN_PASIENview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_KUNJUNGAN_PASIEN">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <tr id="r_VISIT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></td>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <tr id="r_DIANTAR_OLEH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH"><?= $Page->DIANTAR_OLEH->caption() ?></span></td>
        <td data-name="DIANTAR_OLEH" <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH">
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<?= $Page->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <tr id="r_AGEYEAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></td>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SERVED_INAP->Visible) { // SERVED_INAP ?>
    <tr id="r_SERVED_INAP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_SERVED_INAP"><?= $Page->SERVED_INAP->caption() ?></span></td>
        <td data-name="SERVED_INAP" <?= $Page->SERVED_INAP->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_SERVED_INAP">
<span<?= $Page->SERVED_INAP->viewAttributes() ?>>
<?= $Page->SERVED_INAP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <tr id="r_TRANS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KUNJUNGAN_PASIEN_TRANS_ID"><?= $Page->TRANS_ID->caption() ?></span></td>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("PASIEN_DIAGNOSA", explode(",", $Page->getCurrentDetailTable())) && $PASIEN_DIAGNOSA->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("PASIEN_DIAGNOSA", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PasienDiagnosaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("V_AKOMODASI_KAMAR", explode(",", $Page->getCurrentDetailTable())) && $V_AKOMODASI_KAMAR->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("V_AKOMODASI_KAMAR", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "VAkomodasiKamarGrid.php" ?>
<?php } ?>
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
