<?php

namespace PHPMaker2021\simrs;

// Page object
$ObstetriView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fOBSTETRIview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fOBSTETRIview = currentForm = new ew.Form("fOBSTETRIview", "view");
    loadjs.done("fOBSTETRIview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.OBSTETRI) ew.vars.tables.OBSTETRI = <?= JsonEncode(GetClientVar("tables", "OBSTETRI")) ?>;
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
<form name="fOBSTETRIview" id="fOBSTETRIview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="OBSTETRI">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_OBSTETRI_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
    <tr id="r_OBSTETRI_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_OBSTETRI_ID"><?= $Page->OBSTETRI_ID->caption() ?></span></td>
        <td data-name="OBSTETRI_ID" <?= $Page->OBSTETRI_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_OBSTETRI_ID">
<span<?= $Page->OBSTETRI_ID->viewAttributes() ?>>
<?= $Page->OBSTETRI_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->HPHT->Visible) { // HPHT ?>
    <tr id="r_HPHT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_HPHT"><?= $Page->HPHT->caption() ?></span></td>
        <td data-name="HPHT" <?= $Page->HPHT->cellAttributes() ?>>
<span id="el_OBSTETRI_HPHT">
<span<?= $Page->HPHT->viewAttributes() ?>>
<?= $Page->HPHT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->HTP->Visible) { // HTP ?>
    <tr id="r_HTP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_HTP"><?= $Page->HTP->caption() ?></span></td>
        <td data-name="HTP" <?= $Page->HTP->cellAttributes() ?>>
<span id="el_OBSTETRI_HTP">
<span<?= $Page->HTP->viewAttributes() ?>>
<?= $Page->HTP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
    <tr id="r_PASIEN_DIAGNOSA_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PASIEN_DIAGNOSA_ID"><?= $Page->PASIEN_DIAGNOSA_ID->caption() ?></span></td>
        <td data-name="PASIEN_DIAGNOSA_ID" <?= $Page->PASIEN_DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_PASIEN_DIAGNOSA_ID">
<span<?= $Page->PASIEN_DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->PASIEN_DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <tr id="r_DIAGNOSA_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DIAGNOSA_ID"><?= $Page->DIAGNOSA_ID->caption() ?></span></td>
        <td data-name="DIAGNOSA_ID" <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_OBSTETRI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KOHORT_NB->Visible) { // KOHORT_NB ?>
    <tr id="r_KOHORT_NB">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_KOHORT_NB"><?= $Page->KOHORT_NB->caption() ?></span></td>
        <td data-name="KOHORT_NB" <?= $Page->KOHORT_NB->cellAttributes() ?>>
<span id="el_OBSTETRI_KOHORT_NB">
<span<?= $Page->KOHORT_NB->viewAttributes() ?>>
<?= $Page->KOHORT_NB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
    <tr id="r_BIRTH_NB">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_NB"><?= $Page->BIRTH_NB->caption() ?></span></td>
        <td data-name="BIRTH_NB" <?= $Page->BIRTH_NB->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_NB">
<span<?= $Page->BIRTH_NB->viewAttributes() ?>>
<?= $Page->BIRTH_NB->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
    <tr id="r_BIRTH_DURATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_DURATION"><?= $Page->BIRTH_DURATION->caption() ?></span></td>
        <td data-name="BIRTH_DURATION" <?= $Page->BIRTH_DURATION->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DURATION">
<span<?= $Page->BIRTH_DURATION->viewAttributes() ?>>
<?= $Page->BIRTH_DURATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
    <tr id="r_BIRTH_PLACE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_PLACE"><?= $Page->BIRTH_PLACE->caption() ?></span></td>
        <td data-name="BIRTH_PLACE" <?= $Page->BIRTH_PLACE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_PLACE">
<span<?= $Page->BIRTH_PLACE->viewAttributes() ?>>
<?= $Page->BIRTH_PLACE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
    <tr id="r_ANTE_NATAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ANTE_NATAL"><?= $Page->ANTE_NATAL->caption() ?></span></td>
        <td data-name="ANTE_NATAL" <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el_OBSTETRI_ANTE_NATAL">
<span<?= $Page->ANTE_NATAL->viewAttributes() ?>>
<?= $Page->ANTE_NATAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <tr id="r_EMPLOYEE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
    <tr id="r_BIRTH_WAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_WAY"><?= $Page->BIRTH_WAY->caption() ?></span></td>
        <td data-name="BIRTH_WAY" <?= $Page->BIRTH_WAY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_WAY">
<span<?= $Page->BIRTH_WAY->viewAttributes() ?>>
<?= $Page->BIRTH_WAY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
    <tr id="r_BIRTH_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_BY"><?= $Page->BIRTH_BY->caption() ?></span></td>
        <td data-name="BIRTH_BY" <?= $Page->BIRTH_BY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_BY">
<span<?= $Page->BIRTH_BY->viewAttributes() ?>>
<?= $Page->BIRTH_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
    <tr id="r_BIRTH_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_DATE"><?= $Page->BIRTH_DATE->caption() ?></span></td>
        <td data-name="BIRTH_DATE" <?= $Page->BIRTH_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DATE">
<span<?= $Page->BIRTH_DATE->viewAttributes() ?>>
<?= $Page->BIRTH_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
    <tr id="r_GESTASI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_GESTASI"><?= $Page->GESTASI->caption() ?></span></td>
        <td data-name="GESTASI" <?= $Page->GESTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_GESTASI">
<span<?= $Page->GESTASI->viewAttributes() ?>>
<?= $Page->GESTASI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
    <tr id="r_PARITY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PARITY"><?= $Page->PARITY->caption() ?></span></td>
        <td data-name="PARITY" <?= $Page->PARITY->cellAttributes() ?>>
<span id="el_OBSTETRI_PARITY">
<span<?= $Page->PARITY->viewAttributes() ?>>
<?= $Page->PARITY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
    <tr id="r_NB_BABY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_NB_BABY"><?= $Page->NB_BABY->caption() ?></span></td>
        <td data-name="NB_BABY" <?= $Page->NB_BABY->cellAttributes() ?>>
<span id="el_OBSTETRI_NB_BABY">
<span<?= $Page->NB_BABY->viewAttributes() ?>>
<?= $Page->NB_BABY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
    <tr id="r_BABY_DIE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BABY_DIE"><?= $Page->BABY_DIE->caption() ?></span></td>
        <td data-name="BABY_DIE" <?= $Page->BABY_DIE->cellAttributes() ?>>
<span id="el_OBSTETRI_BABY_DIE">
<span<?= $Page->BABY_DIE->viewAttributes() ?>>
<?= $Page->BABY_DIE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
    <tr id="r_ABORTUS_KE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ABORTUS_KE"><?= $Page->ABORTUS_KE->caption() ?></span></td>
        <td data-name="ABORTUS_KE" <?= $Page->ABORTUS_KE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_KE">
<span<?= $Page->ABORTUS_KE->viewAttributes() ?>>
<?= $Page->ABORTUS_KE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
    <tr id="r_ABORTUS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ABORTUS_ID"><?= $Page->ABORTUS_ID->caption() ?></span></td>
        <td data-name="ABORTUS_ID" <?= $Page->ABORTUS_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_ID">
<span<?= $Page->ABORTUS_ID->viewAttributes() ?>>
<?= $Page->ABORTUS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
    <tr id="r_ABORTION_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ABORTION_DATE"><?= $Page->ABORTION_DATE->caption() ?></span></td>
        <td data-name="ABORTION_DATE" <?= $Page->ABORTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTION_DATE">
<span<?= $Page->ABORTION_DATE->viewAttributes() ?>>
<?= $Page->ABORTION_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
    <tr id="r_BIRTH_CAT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_CAT"><?= $Page->BIRTH_CAT->caption() ?></span></td>
        <td data-name="BIRTH_CAT" <?= $Page->BIRTH_CAT->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CAT">
<span<?= $Page->BIRTH_CAT->viewAttributes() ?>>
<?= $Page->BIRTH_CAT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
    <tr id="r_BIRTH_CON">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_CON"><?= $Page->BIRTH_CON->caption() ?></span></td>
        <td data-name="BIRTH_CON" <?= $Page->BIRTH_CON->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CON">
<span<?= $Page->BIRTH_CON->viewAttributes() ?>>
<?= $Page->BIRTH_CON->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
    <tr id="r_BIRTH_RISK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_RISK"><?= $Page->BIRTH_RISK->caption() ?></span></td>
        <td data-name="BIRTH_RISK" <?= $Page->BIRTH_RISK->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_RISK">
<span<?= $Page->BIRTH_RISK->viewAttributes() ?>>
<?= $Page->BIRTH_RISK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
    <tr id="r_RISK_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_RISK_TYPE"><?= $Page->RISK_TYPE->caption() ?></span></td>
        <td data-name="RISK_TYPE" <?= $Page->RISK_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_RISK_TYPE">
<span<?= $Page->RISK_TYPE->viewAttributes() ?>>
<?= $Page->RISK_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
    <tr id="r_FOLLOW_UP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_FOLLOW_UP"><?= $Page->FOLLOW_UP->caption() ?></span></td>
        <td data-name="FOLLOW_UP" <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el_OBSTETRI_FOLLOW_UP">
<span<?= $Page->FOLLOW_UP->viewAttributes() ?>>
<?= $Page->FOLLOW_UP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
    <tr id="r_DIRUJUK_OLEH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DIRUJUK_OLEH"><?= $Page->DIRUJUK_OLEH->caption() ?></span></td>
        <td data-name="DIRUJUK_OLEH" <?= $Page->DIRUJUK_OLEH->cellAttributes() ?>>
<span id="el_OBSTETRI_DIRUJUK_OLEH">
<span<?= $Page->DIRUJUK_OLEH->viewAttributes() ?>>
<?= $Page->DIRUJUK_OLEH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
    <tr id="r_INSPECTION_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_INSPECTION_DATE"><?= $Page->INSPECTION_DATE->caption() ?></span></td>
        <td data-name="INSPECTION_DATE" <?= $Page->INSPECTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_INSPECTION_DATE">
<span<?= $Page->INSPECTION_DATE->viewAttributes() ?>>
<?= $Page->INSPECTION_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
    <tr id="r_PORSIO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PORSIO"><?= $Page->PORSIO->caption() ?></span></td>
        <td data-name="PORSIO" <?= $Page->PORSIO->cellAttributes() ?>>
<span id="el_OBSTETRI_PORSIO">
<span<?= $Page->PORSIO->viewAttributes() ?>>
<?= $Page->PORSIO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
    <tr id="r_PEMBUKAAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PEMBUKAAN"><?= $Page->PEMBUKAAN->caption() ?></span></td>
        <td data-name="PEMBUKAAN" <?= $Page->PEMBUKAAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PEMBUKAAN">
<span<?= $Page->PEMBUKAAN->viewAttributes() ?>>
<?= $Page->PEMBUKAAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
    <tr id="r_KETUBAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_KETUBAN"><?= $Page->KETUBAN->caption() ?></span></td>
        <td data-name="KETUBAN" <?= $Page->KETUBAN->cellAttributes() ?>>
<span id="el_OBSTETRI_KETUBAN">
<span<?= $Page->KETUBAN->viewAttributes() ?>>
<?= $Page->KETUBAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
    <tr id="r_PRESENTASI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PRESENTASI"><?= $Page->PRESENTASI->caption() ?></span></td>
        <td data-name="PRESENTASI" <?= $Page->PRESENTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_PRESENTASI">
<span<?= $Page->PRESENTASI->viewAttributes() ?>>
<?= $Page->PRESENTASI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
    <tr id="r_POSISI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_POSISI"><?= $Page->POSISI->caption() ?></span></td>
        <td data-name="POSISI" <?= $Page->POSISI->cellAttributes() ?>>
<span id="el_OBSTETRI_POSISI">
<span<?= $Page->POSISI->viewAttributes() ?>>
<?= $Page->POSISI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
    <tr id="r_PENURUNAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PENURUNAN"><?= $Page->PENURUNAN->caption() ?></span></td>
        <td data-name="PENURUNAN" <?= $Page->PENURUNAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PENURUNAN">
<span<?= $Page->PENURUNAN->viewAttributes() ?>>
<?= $Page->PENURUNAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->HEART_ID->Visible) { // HEART_ID ?>
    <tr id="r_HEART_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_HEART_ID"><?= $Page->HEART_ID->caption() ?></span></td>
        <td data-name="HEART_ID" <?= $Page->HEART_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_HEART_ID">
<span<?= $Page->HEART_ID->viewAttributes() ?>>
<?= $Page->HEART_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->JANIN_ID->Visible) { // JANIN_ID ?>
    <tr id="r_JANIN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_JANIN_ID"><?= $Page->JANIN_ID->caption() ?></span></td>
        <td data-name="JANIN_ID" <?= $Page->JANIN_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_JANIN_ID">
<span<?= $Page->JANIN_ID->viewAttributes() ?>>
<?= $Page->JANIN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FREK_DJJ->Visible) { // FREK_DJJ ?>
    <tr id="r_FREK_DJJ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_FREK_DJJ"><?= $Page->FREK_DJJ->caption() ?></span></td>
        <td data-name="FREK_DJJ" <?= $Page->FREK_DJJ->cellAttributes() ?>>
<span id="el_OBSTETRI_FREK_DJJ">
<span<?= $Page->FREK_DJJ->viewAttributes() ?>>
<?= $Page->FREK_DJJ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
    <tr id="r_PLACENTA">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_PLACENTA"><?= $Page->PLACENTA->caption() ?></span></td>
        <td data-name="PLACENTA" <?= $Page->PLACENTA->cellAttributes() ?>>
<span id="el_OBSTETRI_PLACENTA">
<span<?= $Page->PLACENTA->viewAttributes() ?>>
<?= $Page->PLACENTA->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->LOCHIA->Visible) { // LOCHIA ?>
    <tr id="r_LOCHIA">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_LOCHIA"><?= $Page->LOCHIA->caption() ?></span></td>
        <td data-name="LOCHIA" <?= $Page->LOCHIA->cellAttributes() ?>>
<span id="el_OBSTETRI_LOCHIA">
<span<?= $Page->LOCHIA->viewAttributes() ?>>
<?= $Page->LOCHIA->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BAB_TYPE->Visible) { // BAB_TYPE ?>
    <tr id="r_BAB_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BAB_TYPE"><?= $Page->BAB_TYPE->caption() ?></span></td>
        <td data-name="BAB_TYPE" <?= $Page->BAB_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_BAB_TYPE">
<span<?= $Page->BAB_TYPE->viewAttributes() ?>>
<?= $Page->BAB_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
    <tr id="r_BAB_BAB_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BAB_BAB_TYPE"><?= $Page->BAB_BAB_TYPE->caption() ?></span></td>
        <td data-name="BAB_BAB_TYPE" <?= $Page->BAB_BAB_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_BAB_BAB_TYPE">
<span<?= $Page->BAB_BAB_TYPE->viewAttributes() ?>>
<?= $Page->BAB_BAB_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
    <tr id="r_RAHIM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_RAHIM_ID"><?= $Page->RAHIM_ID->caption() ?></span></td>
        <td data-name="RAHIM_ID" <?= $Page->RAHIM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_ID">
<span<?= $Page->RAHIM_ID->viewAttributes() ?>>
<?= $Page->RAHIM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
    <tr id="r_BIR_RAHIM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIR_RAHIM_ID"><?= $Page->BIR_RAHIM_ID->caption() ?></span></td>
        <td data-name="BIR_RAHIM_ID" <?= $Page->BIR_RAHIM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_BIR_RAHIM_ID">
<span<?= $Page->BIR_RAHIM_ID->viewAttributes() ?>>
<?= $Page->BIR_RAHIM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <tr id="r_VISIT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></td>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
    <tr id="r_BLOODING">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BLOODING"><?= $Page->BLOODING->caption() ?></span></td>
        <td data-name="BLOODING" <?= $Page->BLOODING->cellAttributes() ?>>
<span id="el_OBSTETRI_BLOODING">
<span<?= $Page->BLOODING->viewAttributes() ?>>
<?= $Page->BLOODING->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_OBSTETRI_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_OBSTETRI_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <tr id="r_MODIFIED_FROM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></td>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_OBSTETRI_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
    <tr id="r_RAHIM_SALIN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_RAHIM_SALIN"><?= $Page->RAHIM_SALIN->caption() ?></span></td>
        <td data-name="RAHIM_SALIN" <?= $Page->RAHIM_SALIN->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_SALIN">
<span<?= $Page->RAHIM_SALIN->viewAttributes() ?>>
<?= $Page->RAHIM_SALIN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
    <tr id="r_RAHIM_NIFAS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_RAHIM_NIFAS"><?= $Page->RAHIM_NIFAS->caption() ?></span></td>
        <td data-name="RAHIM_NIFAS" <?= $Page->RAHIM_NIFAS->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_NIFAS">
<span<?= $Page->RAHIM_NIFAS->viewAttributes() ?>>
<?= $Page->RAHIM_NIFAS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BAK_TYPE->Visible) { // BAK_TYPE ?>
    <tr id="r_BAK_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BAK_TYPE"><?= $Page->BAK_TYPE->caption() ?></span></td>
        <td data-name="BAK_TYPE" <?= $Page->BAK_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_BAK_TYPE">
<span<?= $Page->BAK_TYPE->viewAttributes() ?>>
<?= $Page->BAK_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <tr id="r_THENAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_THENAME"><?= $Page->THENAME->caption() ?></span></td>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_OBSTETRI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <tr id="r_THEADDRESS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></td>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_OBSTETRI_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <tr id="r_THEID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_THEID"><?= $Page->THEID->caption() ?></span></td>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el_OBSTETRI_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <tr id="r_ISRJ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ISRJ"><?= $Page->ISRJ->caption() ?></span></td>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_OBSTETRI_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <tr id="r_AGEYEAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></td>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_OBSTETRI_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <tr id="r_AGEMONTH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></td>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_OBSTETRI_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <tr id="r_AGEDAY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></td>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_OBSTETRI_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_OBSTETRI_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <tr id="r_CLASS_ROOM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></td>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <tr id="r_BED_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BED_ID"><?= $Page->BED_ID->caption() ?></span></td>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <tr id="r_KELUAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></td>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <tr id="r_DOCTOR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></td>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el_OBSTETRI_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
    <tr id="r_NB_OBSTETRI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_NB_OBSTETRI"><?= $Page->NB_OBSTETRI->caption() ?></span></td>
        <td data-name="NB_OBSTETRI" <?= $Page->NB_OBSTETRI->cellAttributes() ?>>
<span id="el_OBSTETRI_NB_OBSTETRI">
<span<?= $Page->NB_OBSTETRI->viewAttributes() ?>>
<?= $Page->NB_OBSTETRI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
    <tr id="r_OBSTETRI_DIE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_OBSTETRI_DIE"><?= $Page->OBSTETRI_DIE->caption() ?></span></td>
        <td data-name="OBSTETRI_DIE" <?= $Page->OBSTETRI_DIE->cellAttributes() ?>>
<span id="el_OBSTETRI_OBSTETRI_DIE">
<span<?= $Page->OBSTETRI_DIE->viewAttributes() ?>>
<?= $Page->OBSTETRI_DIE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <tr id="r_KAL_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_KAL_ID"><?= $Page->KAL_ID->caption() ?></span></td>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
    <tr id="r_DIAGNOSA_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_DIAGNOSA_ID2"><?= $Page->DIAGNOSA_ID2->caption() ?></span></td>
        <td data-name="DIAGNOSA_ID2" <?= $Page->DIAGNOSA_ID2->cellAttributes() ?>>
<span id="el_OBSTETRI_DIAGNOSA_ID2">
<span<?= $Page->DIAGNOSA_ID2->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->APGAR_ID->Visible) { // APGAR_ID ?>
    <tr id="r_APGAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_APGAR_ID"><?= $Page->APGAR_ID->caption() ?></span></td>
        <td data-name="APGAR_ID" <?= $Page->APGAR_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_APGAR_ID">
<span<?= $Page->APGAR_ID->viewAttributes() ?>>
<?= $Page->APGAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
    <tr id="r_BIRTH_LAST_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_BIRTH_LAST_ID"><?= $Page->BIRTH_LAST_ID->caption() ?></span></td>
        <td data-name="BIRTH_LAST_ID" <?= $Page->BIRTH_LAST_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_LAST_ID">
<span<?= $Page->BIRTH_LAST_ID->viewAttributes() ?>>
<?= $Page->BIRTH_LAST_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_OBSTETRI_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el_OBSTETRI_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
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
