<?php

namespace PHPMaker2021\simrs;

// Page object
$ObstetriDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fOBSTETRIdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fOBSTETRIdelete = currentForm = new ew.Form("fOBSTETRIdelete", "delete");
    loadjs.done("fOBSTETRIdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.OBSTETRI) ew.vars.tables.OBSTETRI = <?= JsonEncode(GetClientVar("tables", "OBSTETRI")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fOBSTETRIdelete" id="fOBSTETRIdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="OBSTETRI">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <th class="<?= $Page->OBSTETRI_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_OBSTETRI_ID" class="OBSTETRI_OBSTETRI_ID"><?= $Page->OBSTETRI_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->HPHT->Visible) { // HPHT ?>
        <th class="<?= $Page->HPHT->headerCellClass() ?>"><span id="elh_OBSTETRI_HPHT" class="OBSTETRI_HPHT"><?= $Page->HPHT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->HTP->Visible) { // HTP ?>
        <th class="<?= $Page->HTP->headerCellClass() ?>"><span id="elh_OBSTETRI_HTP" class="OBSTETRI_HTP"><?= $Page->HTP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <th class="<?= $Page->PASIEN_DIAGNOSA_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_PASIEN_DIAGNOSA_ID" class="OBSTETRI_PASIEN_DIAGNOSA_ID"><?= $Page->PASIEN_DIAGNOSA_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <th class="<?= $Page->DIAGNOSA_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_DIAGNOSA_ID" class="OBSTETRI_DIAGNOSA_ID"><?= $Page->DIAGNOSA_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_OBSTETRI_NO_REGISTRATION" class="OBSTETRI_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <th class="<?= $Page->KOHORT_NB->headerCellClass() ?>"><span id="elh_OBSTETRI_KOHORT_NB" class="OBSTETRI_KOHORT_NB"><?= $Page->KOHORT_NB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <th class="<?= $Page->BIRTH_NB->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_NB" class="OBSTETRI_BIRTH_NB"><?= $Page->BIRTH_NB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <th class="<?= $Page->BIRTH_DURATION->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_DURATION" class="OBSTETRI_BIRTH_DURATION"><?= $Page->BIRTH_DURATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <th class="<?= $Page->BIRTH_PLACE->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_PLACE" class="OBSTETRI_BIRTH_PLACE"><?= $Page->BIRTH_PLACE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <th class="<?= $Page->ANTE_NATAL->headerCellClass() ?>"><span id="elh_OBSTETRI_ANTE_NATAL" class="OBSTETRI_ANTE_NATAL"><?= $Page->ANTE_NATAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_EMPLOYEE_ID" class="OBSTETRI_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_CLINIC_ID" class="OBSTETRI_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <th class="<?= $Page->BIRTH_WAY->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_WAY" class="OBSTETRI_BIRTH_WAY"><?= $Page->BIRTH_WAY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <th class="<?= $Page->BIRTH_BY->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_BY" class="OBSTETRI_BIRTH_BY"><?= $Page->BIRTH_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <th class="<?= $Page->BIRTH_DATE->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_DATE" class="OBSTETRI_BIRTH_DATE"><?= $Page->BIRTH_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
        <th class="<?= $Page->GESTASI->headerCellClass() ?>"><span id="elh_OBSTETRI_GESTASI" class="OBSTETRI_GESTASI"><?= $Page->GESTASI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
        <th class="<?= $Page->PARITY->headerCellClass() ?>"><span id="elh_OBSTETRI_PARITY" class="OBSTETRI_PARITY"><?= $Page->PARITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
        <th class="<?= $Page->NB_BABY->headerCellClass() ?>"><span id="elh_OBSTETRI_NB_BABY" class="OBSTETRI_NB_BABY"><?= $Page->NB_BABY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
        <th class="<?= $Page->BABY_DIE->headerCellClass() ?>"><span id="elh_OBSTETRI_BABY_DIE" class="OBSTETRI_BABY_DIE"><?= $Page->BABY_DIE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <th class="<?= $Page->ABORTUS_KE->headerCellClass() ?>"><span id="elh_OBSTETRI_ABORTUS_KE" class="OBSTETRI_ABORTUS_KE"><?= $Page->ABORTUS_KE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <th class="<?= $Page->ABORTUS_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_ABORTUS_ID" class="OBSTETRI_ABORTUS_ID"><?= $Page->ABORTUS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <th class="<?= $Page->ABORTION_DATE->headerCellClass() ?>"><span id="elh_OBSTETRI_ABORTION_DATE" class="OBSTETRI_ABORTION_DATE"><?= $Page->ABORTION_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <th class="<?= $Page->BIRTH_CAT->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_CAT" class="OBSTETRI_BIRTH_CAT"><?= $Page->BIRTH_CAT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <th class="<?= $Page->BIRTH_CON->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_CON" class="OBSTETRI_BIRTH_CON"><?= $Page->BIRTH_CON->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <th class="<?= $Page->BIRTH_RISK->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_RISK" class="OBSTETRI_BIRTH_RISK"><?= $Page->BIRTH_RISK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <th class="<?= $Page->RISK_TYPE->headerCellClass() ?>"><span id="elh_OBSTETRI_RISK_TYPE" class="OBSTETRI_RISK_TYPE"><?= $Page->RISK_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <th class="<?= $Page->FOLLOW_UP->headerCellClass() ?>"><span id="elh_OBSTETRI_FOLLOW_UP" class="OBSTETRI_FOLLOW_UP"><?= $Page->FOLLOW_UP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <th class="<?= $Page->DIRUJUK_OLEH->headerCellClass() ?>"><span id="elh_OBSTETRI_DIRUJUK_OLEH" class="OBSTETRI_DIRUJUK_OLEH"><?= $Page->DIRUJUK_OLEH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <th class="<?= $Page->INSPECTION_DATE->headerCellClass() ?>"><span id="elh_OBSTETRI_INSPECTION_DATE" class="OBSTETRI_INSPECTION_DATE"><?= $Page->INSPECTION_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
        <th class="<?= $Page->PORSIO->headerCellClass() ?>"><span id="elh_OBSTETRI_PORSIO" class="OBSTETRI_PORSIO"><?= $Page->PORSIO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <th class="<?= $Page->PEMBUKAAN->headerCellClass() ?>"><span id="elh_OBSTETRI_PEMBUKAAN" class="OBSTETRI_PEMBUKAAN"><?= $Page->PEMBUKAAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
        <th class="<?= $Page->KETUBAN->headerCellClass() ?>"><span id="elh_OBSTETRI_KETUBAN" class="OBSTETRI_KETUBAN"><?= $Page->KETUBAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
        <th class="<?= $Page->PRESENTASI->headerCellClass() ?>"><span id="elh_OBSTETRI_PRESENTASI" class="OBSTETRI_PRESENTASI"><?= $Page->PRESENTASI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
        <th class="<?= $Page->POSISI->headerCellClass() ?>"><span id="elh_OBSTETRI_POSISI" class="OBSTETRI_POSISI"><?= $Page->POSISI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
        <th class="<?= $Page->PENURUNAN->headerCellClass() ?>"><span id="elh_OBSTETRI_PENURUNAN" class="OBSTETRI_PENURUNAN"><?= $Page->PENURUNAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->HEART_ID->Visible) { // HEART_ID ?>
        <th class="<?= $Page->HEART_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_HEART_ID" class="OBSTETRI_HEART_ID"><?= $Page->HEART_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->JANIN_ID->Visible) { // JANIN_ID ?>
        <th class="<?= $Page->JANIN_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_JANIN_ID" class="OBSTETRI_JANIN_ID"><?= $Page->JANIN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <th class="<?= $Page->FREK_DJJ->headerCellClass() ?>"><span id="elh_OBSTETRI_FREK_DJJ" class="OBSTETRI_FREK_DJJ"><?= $Page->FREK_DJJ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
        <th class="<?= $Page->PLACENTA->headerCellClass() ?>"><span id="elh_OBSTETRI_PLACENTA" class="OBSTETRI_PLACENTA"><?= $Page->PLACENTA->caption() ?></span></th>
<?php } ?>
<?php if ($Page->LOCHIA->Visible) { // LOCHIA ?>
        <th class="<?= $Page->LOCHIA->headerCellClass() ?>"><span id="elh_OBSTETRI_LOCHIA" class="OBSTETRI_LOCHIA"><?= $Page->LOCHIA->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <th class="<?= $Page->BAB_TYPE->headerCellClass() ?>"><span id="elh_OBSTETRI_BAB_TYPE" class="OBSTETRI_BAB_TYPE"><?= $Page->BAB_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <th class="<?= $Page->BAB_BAB_TYPE->headerCellClass() ?>"><span id="elh_OBSTETRI_BAB_BAB_TYPE" class="OBSTETRI_BAB_BAB_TYPE"><?= $Page->BAB_BAB_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <th class="<?= $Page->RAHIM_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_RAHIM_ID" class="OBSTETRI_RAHIM_ID"><?= $Page->RAHIM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <th class="<?= $Page->BIR_RAHIM_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_BIR_RAHIM_ID" class="OBSTETRI_BIR_RAHIM_ID"><?= $Page->BIR_RAHIM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_VISIT_ID" class="OBSTETRI_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
        <th class="<?= $Page->BLOODING->headerCellClass() ?>"><span id="elh_OBSTETRI_BLOODING" class="OBSTETRI_BLOODING"><?= $Page->BLOODING->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_OBSTETRI_DESCRIPTION" class="OBSTETRI_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_OBSTETRI_MODIFIED_DATE" class="OBSTETRI_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_OBSTETRI_MODIFIED_BY" class="OBSTETRI_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><span id="elh_OBSTETRI_MODIFIED_FROM" class="OBSTETRI_MODIFIED_FROM"><?= $Page->MODIFIED_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <th class="<?= $Page->RAHIM_SALIN->headerCellClass() ?>"><span id="elh_OBSTETRI_RAHIM_SALIN" class="OBSTETRI_RAHIM_SALIN"><?= $Page->RAHIM_SALIN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <th class="<?= $Page->RAHIM_NIFAS->headerCellClass() ?>"><span id="elh_OBSTETRI_RAHIM_NIFAS" class="OBSTETRI_RAHIM_NIFAS"><?= $Page->RAHIM_NIFAS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <th class="<?= $Page->BAK_TYPE->headerCellClass() ?>"><span id="elh_OBSTETRI_BAK_TYPE" class="OBSTETRI_BAK_TYPE"><?= $Page->BAK_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_OBSTETRI_THENAME" class="OBSTETRI_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th class="<?= $Page->THEADDRESS->headerCellClass() ?>"><span id="elh_OBSTETRI_THEADDRESS" class="OBSTETRI_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th class="<?= $Page->THEID->headerCellClass() ?>"><span id="elh_OBSTETRI_THEID" class="OBSTETRI_THEID"><?= $Page->THEID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_STATUS_PASIEN_ID" class="OBSTETRI_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th class="<?= $Page->ISRJ->headerCellClass() ?>"><span id="elh_OBSTETRI_ISRJ" class="OBSTETRI_ISRJ"><?= $Page->ISRJ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th class="<?= $Page->AGEYEAR->headerCellClass() ?>"><span id="elh_OBSTETRI_AGEYEAR" class="OBSTETRI_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th class="<?= $Page->AGEMONTH->headerCellClass() ?>"><span id="elh_OBSTETRI_AGEMONTH" class="OBSTETRI_AGEMONTH"><?= $Page->AGEMONTH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th class="<?= $Page->AGEDAY->headerCellClass() ?>"><span id="elh_OBSTETRI_AGEDAY" class="OBSTETRI_AGEDAY"><?= $Page->AGEDAY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th class="<?= $Page->GENDER->headerCellClass() ?>"><span id="elh_OBSTETRI_GENDER" class="OBSTETRI_GENDER"><?= $Page->GENDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_CLASS_ROOM_ID" class="OBSTETRI_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th class="<?= $Page->BED_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_BED_ID" class="OBSTETRI_BED_ID"><?= $Page->BED_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_KELUAR_ID" class="OBSTETRI_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th class="<?= $Page->DOCTOR->headerCellClass() ?>"><span id="elh_OBSTETRI_DOCTOR" class="OBSTETRI_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <th class="<?= $Page->NB_OBSTETRI->headerCellClass() ?>"><span id="elh_OBSTETRI_NB_OBSTETRI" class="OBSTETRI_NB_OBSTETRI"><?= $Page->NB_OBSTETRI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <th class="<?= $Page->OBSTETRI_DIE->headerCellClass() ?>"><span id="elh_OBSTETRI_OBSTETRI_DIE" class="OBSTETRI_OBSTETRI_DIE"><?= $Page->OBSTETRI_DIE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th class="<?= $Page->KAL_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_KAL_ID" class="OBSTETRI_KAL_ID"><?= $Page->KAL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <th class="<?= $Page->DIAGNOSA_ID2->headerCellClass() ?>"><span id="elh_OBSTETRI_DIAGNOSA_ID2" class="OBSTETRI_DIAGNOSA_ID2"><?= $Page->DIAGNOSA_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->APGAR_ID->Visible) { // APGAR_ID ?>
        <th class="<?= $Page->APGAR_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_APGAR_ID" class="OBSTETRI_APGAR_ID"><?= $Page->APGAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <th class="<?= $Page->BIRTH_LAST_ID->headerCellClass() ?>"><span id="elh_OBSTETRI_BIRTH_LAST_ID" class="OBSTETRI_BIRTH_LAST_ID"><?= $Page->BIRTH_LAST_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_OBSTETRI_ID" class="OBSTETRI_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <td <?= $Page->OBSTETRI_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_OBSTETRI_ID" class="OBSTETRI_OBSTETRI_ID">
<span<?= $Page->OBSTETRI_ID->viewAttributes() ?>>
<?= $Page->OBSTETRI_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->HPHT->Visible) { // HPHT ?>
        <td <?= $Page->HPHT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_HPHT" class="OBSTETRI_HPHT">
<span<?= $Page->HPHT->viewAttributes() ?>>
<?= $Page->HPHT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->HTP->Visible) { // HTP ?>
        <td <?= $Page->HTP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_HTP" class="OBSTETRI_HTP">
<span<?= $Page->HTP->viewAttributes() ?>>
<?= $Page->HTP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <td <?= $Page->PASIEN_DIAGNOSA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PASIEN_DIAGNOSA_ID" class="OBSTETRI_PASIEN_DIAGNOSA_ID">
<span<?= $Page->PASIEN_DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->PASIEN_DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DIAGNOSA_ID" class="OBSTETRI_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_NO_REGISTRATION" class="OBSTETRI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <td <?= $Page->KOHORT_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KOHORT_NB" class="OBSTETRI_KOHORT_NB">
<span<?= $Page->KOHORT_NB->viewAttributes() ?>>
<?= $Page->KOHORT_NB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <td <?= $Page->BIRTH_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_NB" class="OBSTETRI_BIRTH_NB">
<span<?= $Page->BIRTH_NB->viewAttributes() ?>>
<?= $Page->BIRTH_NB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <td <?= $Page->BIRTH_DURATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_DURATION" class="OBSTETRI_BIRTH_DURATION">
<span<?= $Page->BIRTH_DURATION->viewAttributes() ?>>
<?= $Page->BIRTH_DURATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <td <?= $Page->BIRTH_PLACE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_PLACE" class="OBSTETRI_BIRTH_PLACE">
<span<?= $Page->BIRTH_PLACE->viewAttributes() ?>>
<?= $Page->BIRTH_PLACE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <td <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ANTE_NATAL" class="OBSTETRI_ANTE_NATAL">
<span<?= $Page->ANTE_NATAL->viewAttributes() ?>>
<?= $Page->ANTE_NATAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_EMPLOYEE_ID" class="OBSTETRI_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_CLINIC_ID" class="OBSTETRI_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <td <?= $Page->BIRTH_WAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_WAY" class="OBSTETRI_BIRTH_WAY">
<span<?= $Page->BIRTH_WAY->viewAttributes() ?>>
<?= $Page->BIRTH_WAY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <td <?= $Page->BIRTH_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_BY" class="OBSTETRI_BIRTH_BY">
<span<?= $Page->BIRTH_BY->viewAttributes() ?>>
<?= $Page->BIRTH_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <td <?= $Page->BIRTH_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_DATE" class="OBSTETRI_BIRTH_DATE">
<span<?= $Page->BIRTH_DATE->viewAttributes() ?>>
<?= $Page->BIRTH_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
        <td <?= $Page->GESTASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_GESTASI" class="OBSTETRI_GESTASI">
<span<?= $Page->GESTASI->viewAttributes() ?>>
<?= $Page->GESTASI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
        <td <?= $Page->PARITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PARITY" class="OBSTETRI_PARITY">
<span<?= $Page->PARITY->viewAttributes() ?>>
<?= $Page->PARITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
        <td <?= $Page->NB_BABY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_NB_BABY" class="OBSTETRI_NB_BABY">
<span<?= $Page->NB_BABY->viewAttributes() ?>>
<?= $Page->NB_BABY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
        <td <?= $Page->BABY_DIE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BABY_DIE" class="OBSTETRI_BABY_DIE">
<span<?= $Page->BABY_DIE->viewAttributes() ?>>
<?= $Page->BABY_DIE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <td <?= $Page->ABORTUS_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ABORTUS_KE" class="OBSTETRI_ABORTUS_KE">
<span<?= $Page->ABORTUS_KE->viewAttributes() ?>>
<?= $Page->ABORTUS_KE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <td <?= $Page->ABORTUS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ABORTUS_ID" class="OBSTETRI_ABORTUS_ID">
<span<?= $Page->ABORTUS_ID->viewAttributes() ?>>
<?= $Page->ABORTUS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <td <?= $Page->ABORTION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ABORTION_DATE" class="OBSTETRI_ABORTION_DATE">
<span<?= $Page->ABORTION_DATE->viewAttributes() ?>>
<?= $Page->ABORTION_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <td <?= $Page->BIRTH_CAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_CAT" class="OBSTETRI_BIRTH_CAT">
<span<?= $Page->BIRTH_CAT->viewAttributes() ?>>
<?= $Page->BIRTH_CAT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <td <?= $Page->BIRTH_CON->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_CON" class="OBSTETRI_BIRTH_CON">
<span<?= $Page->BIRTH_CON->viewAttributes() ?>>
<?= $Page->BIRTH_CON->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <td <?= $Page->BIRTH_RISK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_RISK" class="OBSTETRI_BIRTH_RISK">
<span<?= $Page->BIRTH_RISK->viewAttributes() ?>>
<?= $Page->BIRTH_RISK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <td <?= $Page->RISK_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RISK_TYPE" class="OBSTETRI_RISK_TYPE">
<span<?= $Page->RISK_TYPE->viewAttributes() ?>>
<?= $Page->RISK_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <td <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_FOLLOW_UP" class="OBSTETRI_FOLLOW_UP">
<span<?= $Page->FOLLOW_UP->viewAttributes() ?>>
<?= $Page->FOLLOW_UP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <td <?= $Page->DIRUJUK_OLEH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DIRUJUK_OLEH" class="OBSTETRI_DIRUJUK_OLEH">
<span<?= $Page->DIRUJUK_OLEH->viewAttributes() ?>>
<?= $Page->DIRUJUK_OLEH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <td <?= $Page->INSPECTION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_INSPECTION_DATE" class="OBSTETRI_INSPECTION_DATE">
<span<?= $Page->INSPECTION_DATE->viewAttributes() ?>>
<?= $Page->INSPECTION_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
        <td <?= $Page->PORSIO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PORSIO" class="OBSTETRI_PORSIO">
<span<?= $Page->PORSIO->viewAttributes() ?>>
<?= $Page->PORSIO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <td <?= $Page->PEMBUKAAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PEMBUKAAN" class="OBSTETRI_PEMBUKAAN">
<span<?= $Page->PEMBUKAAN->viewAttributes() ?>>
<?= $Page->PEMBUKAAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
        <td <?= $Page->KETUBAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KETUBAN" class="OBSTETRI_KETUBAN">
<span<?= $Page->KETUBAN->viewAttributes() ?>>
<?= $Page->KETUBAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
        <td <?= $Page->PRESENTASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PRESENTASI" class="OBSTETRI_PRESENTASI">
<span<?= $Page->PRESENTASI->viewAttributes() ?>>
<?= $Page->PRESENTASI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
        <td <?= $Page->POSISI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_POSISI" class="OBSTETRI_POSISI">
<span<?= $Page->POSISI->viewAttributes() ?>>
<?= $Page->POSISI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
        <td <?= $Page->PENURUNAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PENURUNAN" class="OBSTETRI_PENURUNAN">
<span<?= $Page->PENURUNAN->viewAttributes() ?>>
<?= $Page->PENURUNAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->HEART_ID->Visible) { // HEART_ID ?>
        <td <?= $Page->HEART_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_HEART_ID" class="OBSTETRI_HEART_ID">
<span<?= $Page->HEART_ID->viewAttributes() ?>>
<?= $Page->HEART_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->JANIN_ID->Visible) { // JANIN_ID ?>
        <td <?= $Page->JANIN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_JANIN_ID" class="OBSTETRI_JANIN_ID">
<span<?= $Page->JANIN_ID->viewAttributes() ?>>
<?= $Page->JANIN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <td <?= $Page->FREK_DJJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_FREK_DJJ" class="OBSTETRI_FREK_DJJ">
<span<?= $Page->FREK_DJJ->viewAttributes() ?>>
<?= $Page->FREK_DJJ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
        <td <?= $Page->PLACENTA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PLACENTA" class="OBSTETRI_PLACENTA">
<span<?= $Page->PLACENTA->viewAttributes() ?>>
<?= $Page->PLACENTA->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->LOCHIA->Visible) { // LOCHIA ?>
        <td <?= $Page->LOCHIA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_LOCHIA" class="OBSTETRI_LOCHIA">
<span<?= $Page->LOCHIA->viewAttributes() ?>>
<?= $Page->LOCHIA->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <td <?= $Page->BAB_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BAB_TYPE" class="OBSTETRI_BAB_TYPE">
<span<?= $Page->BAB_TYPE->viewAttributes() ?>>
<?= $Page->BAB_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <td <?= $Page->BAB_BAB_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BAB_BAB_TYPE" class="OBSTETRI_BAB_BAB_TYPE">
<span<?= $Page->BAB_BAB_TYPE->viewAttributes() ?>>
<?= $Page->BAB_BAB_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <td <?= $Page->RAHIM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RAHIM_ID" class="OBSTETRI_RAHIM_ID">
<span<?= $Page->RAHIM_ID->viewAttributes() ?>>
<?= $Page->RAHIM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <td <?= $Page->BIR_RAHIM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIR_RAHIM_ID" class="OBSTETRI_BIR_RAHIM_ID">
<span<?= $Page->BIR_RAHIM_ID->viewAttributes() ?>>
<?= $Page->BIR_RAHIM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_VISIT_ID" class="OBSTETRI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
        <td <?= $Page->BLOODING->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BLOODING" class="OBSTETRI_BLOODING">
<span<?= $Page->BLOODING->viewAttributes() ?>>
<?= $Page->BLOODING->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DESCRIPTION" class="OBSTETRI_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_MODIFIED_DATE" class="OBSTETRI_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_MODIFIED_BY" class="OBSTETRI_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_MODIFIED_FROM" class="OBSTETRI_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <td <?= $Page->RAHIM_SALIN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RAHIM_SALIN" class="OBSTETRI_RAHIM_SALIN">
<span<?= $Page->RAHIM_SALIN->viewAttributes() ?>>
<?= $Page->RAHIM_SALIN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <td <?= $Page->RAHIM_NIFAS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RAHIM_NIFAS" class="OBSTETRI_RAHIM_NIFAS">
<span<?= $Page->RAHIM_NIFAS->viewAttributes() ?>>
<?= $Page->RAHIM_NIFAS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <td <?= $Page->BAK_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BAK_TYPE" class="OBSTETRI_BAK_TYPE">
<span<?= $Page->BAK_TYPE->viewAttributes() ?>>
<?= $Page->BAK_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_THENAME" class="OBSTETRI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_THEADDRESS" class="OBSTETRI_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <td <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_THEID" class="OBSTETRI_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_STATUS_PASIEN_ID" class="OBSTETRI_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ISRJ" class="OBSTETRI_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_AGEYEAR" class="OBSTETRI_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_AGEMONTH" class="OBSTETRI_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_AGEDAY" class="OBSTETRI_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_GENDER" class="OBSTETRI_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_CLASS_ROOM_ID" class="OBSTETRI_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BED_ID" class="OBSTETRI_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KELUAR_ID" class="OBSTETRI_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DOCTOR" class="OBSTETRI_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <td <?= $Page->NB_OBSTETRI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_NB_OBSTETRI" class="OBSTETRI_NB_OBSTETRI">
<span<?= $Page->NB_OBSTETRI->viewAttributes() ?>>
<?= $Page->NB_OBSTETRI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <td <?= $Page->OBSTETRI_DIE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_OBSTETRI_DIE" class="OBSTETRI_OBSTETRI_DIE">
<span<?= $Page->OBSTETRI_DIE->viewAttributes() ?>>
<?= $Page->OBSTETRI_DIE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KAL_ID" class="OBSTETRI_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <td <?= $Page->DIAGNOSA_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DIAGNOSA_ID2" class="OBSTETRI_DIAGNOSA_ID2">
<span<?= $Page->DIAGNOSA_ID2->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->APGAR_ID->Visible) { // APGAR_ID ?>
        <td <?= $Page->APGAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_APGAR_ID" class="OBSTETRI_APGAR_ID">
<span<?= $Page->APGAR_ID->viewAttributes() ?>>
<?= $Page->APGAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <td <?= $Page->BIRTH_LAST_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_LAST_ID" class="OBSTETRI_BIRTH_LAST_ID">
<span<?= $Page->BIRTH_LAST_ID->viewAttributes() ?>>
<?= $Page->BIRTH_LAST_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <td <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ID" class="OBSTETRI_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
