<?php

namespace PHPMaker2021\simrs;

// Page object
$AntrianPendaftaranDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_PENDAFTARANdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fANTRIAN_PENDAFTARANdelete = currentForm = new ew.Form("fANTRIAN_PENDAFTARANdelete", "delete");
    loadjs.done("fANTRIAN_PENDAFTARANdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ANTRIAN_PENDAFTARAN) ew.vars.tables.ANTRIAN_PENDAFTARAN = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_PENDAFTARAN")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fANTRIAN_PENDAFTARANdelete" id="fANTRIAN_PENDAFTARANdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_PENDAFTARAN">
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
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <th class="<?= $Page->no_urut->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_no_urut" class="ANTRIAN_PENDAFTARAN_no_urut"><?= $Page->no_urut->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <th class="<?= $Page->tanggal_daftar->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_tanggal_daftar" class="ANTRIAN_PENDAFTARAN_tanggal_daftar"><?= $Page->tanggal_daftar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
        <th class="<?= $Page->tanggal_panggil->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_tanggal_panggil" class="ANTRIAN_PENDAFTARAN_tanggal_panggil"><?= $Page->tanggal_panggil->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_nama" class="ANTRIAN_PENDAFTARAN_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_bpjs->Visible) { // no_bpjs ?>
        <th class="<?= $Page->no_bpjs->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_no_bpjs" class="ANTRIAN_PENDAFTARAN_no_bpjs"><?= $Page->no_bpjs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nomr->Visible) { // nomr ?>
        <th class="<?= $Page->nomr->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_nomr" class="ANTRIAN_PENDAFTARAN_nomr"><?= $Page->nomr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jk->Visible) { // jk ?>
        <th class="<?= $Page->jk->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_jk" class="ANTRIAN_PENDAFTARAN_jk"><?= $Page->jk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_ANTRIAN_PENDAFTARAN_alamat" class="ANTRIAN_PENDAFTARAN_alamat"><?= $Page->alamat->caption() ?></span></th>
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
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <td <?= $Page->no_urut->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_no_urut" class="ANTRIAN_PENDAFTARAN_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <td <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_tanggal_daftar" class="ANTRIAN_PENDAFTARAN_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
        <td <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_tanggal_panggil" class="ANTRIAN_PENDAFTARAN_tanggal_panggil">
<span<?= $Page->tanggal_panggil->viewAttributes() ?>>
<?= $Page->tanggal_panggil->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_nama" class="ANTRIAN_PENDAFTARAN_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_bpjs->Visible) { // no_bpjs ?>
        <td <?= $Page->no_bpjs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_no_bpjs" class="ANTRIAN_PENDAFTARAN_no_bpjs">
<span<?= $Page->no_bpjs->viewAttributes() ?>>
<?= $Page->no_bpjs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nomr->Visible) { // nomr ?>
        <td <?= $Page->nomr->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_nomr" class="ANTRIAN_PENDAFTARAN_nomr">
<span<?= $Page->nomr->viewAttributes() ?>>
<?= $Page->nomr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jk->Visible) { // jk ?>
        <td <?= $Page->jk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_jk" class="ANTRIAN_PENDAFTARAN_jk">
<span<?= $Page->jk->viewAttributes() ?>>
<?= $Page->jk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_alamat" class="ANTRIAN_PENDAFTARAN_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
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
