<?php

namespace PHPMaker2021\simrs;

// Page object
$AntrianFarmasiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_FARMASIdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fANTRIAN_FARMASIdelete = currentForm = new ew.Form("fANTRIAN_FARMASIdelete", "delete");
    loadjs.done("fANTRIAN_FARMASIdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ANTRIAN_FARMASI) ew.vars.tables.ANTRIAN_FARMASI = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_FARMASI")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fANTRIAN_FARMASIdelete" id="fANTRIAN_FARMASIdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_FARMASI">
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
<?php if ($Page->Id->Visible) { // Id ?>
        <th class="<?= $Page->Id->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_Id" class="ANTRIAN_FARMASI_Id"><?= $Page->Id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <th class="<?= $Page->no_urut->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_no_urut" class="ANTRIAN_FARMASI_no_urut"><?= $Page->no_urut->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <th class="<?= $Page->tanggal_daftar->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_tanggal_daftar" class="ANTRIAN_FARMASI_tanggal_daftar"><?= $Page->tanggal_daftar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
        <th class="<?= $Page->tanggal_panggil->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_tanggal_panggil" class="ANTRIAN_FARMASI_tanggal_panggil"><?= $Page->tanggal_panggil->caption() ?></span></th>
<?php } ?>
<?php if ($Page->loket->Visible) { // loket ?>
        <th class="<?= $Page->loket->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_loket" class="ANTRIAN_FARMASI_loket"><?= $Page->loket->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_panggil->Visible) { // status_panggil ?>
        <th class="<?= $Page->status_panggil->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_status_panggil" class="ANTRIAN_FARMASI_status_panggil"><?= $Page->status_panggil->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_NO_REGISTRATION" class="ANTRIAN_FARMASI_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_THENAME" class="ANTRIAN_FARMASI_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_ANTRIAN_FARMASI_VISIT_ID" class="ANTRIAN_FARMASI_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
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
<?php if ($Page->Id->Visible) { // Id ?>
        <td <?= $Page->Id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_Id" class="ANTRIAN_FARMASI_Id">
<span<?= $Page->Id->viewAttributes() ?>>
<?= $Page->Id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <td <?= $Page->no_urut->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_no_urut" class="ANTRIAN_FARMASI_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <td <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_tanggal_daftar" class="ANTRIAN_FARMASI_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
        <td <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_tanggal_panggil" class="ANTRIAN_FARMASI_tanggal_panggil">
<span<?= $Page->tanggal_panggil->viewAttributes() ?>>
<?= $Page->tanggal_panggil->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->loket->Visible) { // loket ?>
        <td <?= $Page->loket->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_loket" class="ANTRIAN_FARMASI_loket">
<span<?= $Page->loket->viewAttributes() ?>>
<?= $Page->loket->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_panggil->Visible) { // status_panggil ?>
        <td <?= $Page->status_panggil->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_status_panggil" class="ANTRIAN_FARMASI_status_panggil">
<span<?= $Page->status_panggil->viewAttributes() ?>>
<?= $Page->status_panggil->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_NO_REGISTRATION" class="ANTRIAN_FARMASI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_THENAME" class="ANTRIAN_FARMASI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_FARMASI_VISIT_ID" class="ANTRIAN_FARMASI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
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
