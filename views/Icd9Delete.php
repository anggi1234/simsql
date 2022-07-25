<?php

namespace PHPMaker2021\simrs;

// Page object
$Icd9Delete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ficd9delete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ficd9delete = currentForm = new ew.Form("ficd9delete", "delete");
    loadjs.done("ficd9delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.icd9) ew.vars.tables.icd9 = <?= JsonEncode(GetClientVar("tables", "icd9")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ficd9delete" id="ficd9delete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="icd9">
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
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_icd9_kode" class="icd9_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deskripsi_panjang->Visible) { // deskripsi_panjang ?>
        <th class="<?= $Page->deskripsi_panjang->headerCellClass() ?>"><span id="elh_icd9_deskripsi_panjang" class="icd9_deskripsi_panjang"><?= $Page->deskripsi_panjang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deskripsi_pendek->Visible) { // deskripsi_pendek ?>
        <th class="<?= $Page->deskripsi_pendek->headerCellClass() ?>"><span id="elh_icd9_deskripsi_pendek" class="icd9_deskripsi_pendek"><?= $Page->deskripsi_pendek->caption() ?></span></th>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <td <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_icd9_kode" class="icd9_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deskripsi_panjang->Visible) { // deskripsi_panjang ?>
        <td <?= $Page->deskripsi_panjang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_icd9_deskripsi_panjang" class="icd9_deskripsi_panjang">
<span<?= $Page->deskripsi_panjang->viewAttributes() ?>>
<?= $Page->deskripsi_panjang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deskripsi_pendek->Visible) { // deskripsi_pendek ?>
        <td <?= $Page->deskripsi_pendek->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_icd9_deskripsi_pendek" class="icd9_deskripsi_pendek">
<span<?= $Page->deskripsi_pendek->viewAttributes() ?>>
<?= $Page->deskripsi_pendek->getViewValue() ?></span>
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
