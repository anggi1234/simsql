<?php

namespace PHPMaker2021\simrs;

// Page object
$Icd9View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ficd9view;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ficd9view = currentForm = new ew.Form("ficd9view", "view");
    loadjs.done("ficd9view");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.icd9) ew.vars.tables.icd9 = <?= JsonEncode(GetClientVar("tables", "icd9")) ?>;
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
<form name="ficd9view" id="ficd9view" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="icd9">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_icd9_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_icd9_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deskripsi_panjang->Visible) { // deskripsi_panjang ?>
    <tr id="r_deskripsi_panjang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_icd9_deskripsi_panjang"><?= $Page->deskripsi_panjang->caption() ?></span></td>
        <td data-name="deskripsi_panjang" <?= $Page->deskripsi_panjang->cellAttributes() ?>>
<span id="el_icd9_deskripsi_panjang">
<span<?= $Page->deskripsi_panjang->viewAttributes() ?>>
<?= $Page->deskripsi_panjang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deskripsi_pendek->Visible) { // deskripsi_pendek ?>
    <tr id="r_deskripsi_pendek">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_icd9_deskripsi_pendek"><?= $Page->deskripsi_pendek->caption() ?></span></td>
        <td data-name="deskripsi_pendek" <?= $Page->deskripsi_pendek->cellAttributes() ?>>
<span id="el_icd9_deskripsi_pendek">
<span<?= $Page->deskripsi_pendek->viewAttributes() ?>>
<?= $Page->deskripsi_pendek->getViewValue() ?></span>
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
