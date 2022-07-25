<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodGfView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_GFview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fGOOD_GFview = currentForm = new ew.Form("fGOOD_GFview", "view");
    loadjs.done("fGOOD_GFview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.GOOD_GF) ew.vars.tables.GOOD_GF = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>;
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
<form name="fGOOD_GFview" id="fGOOD_GFview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <tr id="r_BRAND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></td>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
    <tr id="r_ROOMS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ROOMS_ID"><?= $Page->ROOMS_ID->caption() ?></span></td>
        <td data-name="ROOMS_ID" <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
    <tr id="r_ALLOCATED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_ALLOCATED_DATE"><?= $Page->ALLOCATED_DATE->caption() ?></span></td>
        <td data-name="ALLOCATED_DATE" <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
    <tr id="r_STOCKOPNAME_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_STOCKOPNAME_DATE"><?= $Page->STOCKOPNAME_DATE->caption() ?></span></td>
        <td data-name="STOCKOPNAME_DATE" <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Page->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Page->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <tr id="r_INVOICE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOOD_GF_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></td>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
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
