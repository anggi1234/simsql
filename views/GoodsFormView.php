<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsFormView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOODS_FORMview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fGOODS_FORMview = currentForm = new ew.Form("fGOODS_FORMview", "view");
    loadjs.done("fGOODS_FORMview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.GOODS_FORM) ew.vars.tables.GOODS_FORM = <?= JsonEncode(GetClientVar("tables", "GOODS_FORM")) ?>;
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
<form name="fGOODS_FORMview" id="fGOODS_FORMview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS_FORM">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
    <tr id="r_FORM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_FORM_FORM_ID"><?= $Page->FORM_ID->caption() ?></span></td>
        <td data-name="FORM_ID" <?= $Page->FORM_ID->cellAttributes() ?>>
<span id="el_GOODS_FORM_FORM_ID">
<span<?= $Page->FORM_ID->viewAttributes() ?>>
<?= $Page->FORM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FORM_ID2->Visible) { // FORM_ID2 ?>
    <tr id="r_FORM_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_FORM_FORM_ID2"><?= $Page->FORM_ID2->caption() ?></span></td>
        <td data-name="FORM_ID2" <?= $Page->FORM_ID2->cellAttributes() ?>>
<span id="el_GOODS_FORM_FORM_ID2">
<span<?= $Page->FORM_ID2->viewAttributes() ?>>
<?= $Page->FORM_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FORM_GOODS->Visible) { // FORM_GOODS ?>
    <tr id="r_FORM_GOODS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_FORM_FORM_GOODS"><?= $Page->FORM_GOODS->caption() ?></span></td>
        <td data-name="FORM_GOODS" <?= $Page->FORM_GOODS->cellAttributes() ?>>
<span id="el_GOODS_FORM_FORM_GOODS">
<span<?= $Page->FORM_GOODS->viewAttributes() ?>>
<?= $Page->FORM_GOODS->getViewValue() ?></span>
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
