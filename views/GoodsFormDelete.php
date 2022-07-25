<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsFormDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOODS_FORMdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fGOODS_FORMdelete = currentForm = new ew.Form("fGOODS_FORMdelete", "delete");
    loadjs.done("fGOODS_FORMdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.GOODS_FORM) ew.vars.tables.GOODS_FORM = <?= JsonEncode(GetClientVar("tables", "GOODS_FORM")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fGOODS_FORMdelete" id="fGOODS_FORMdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS_FORM">
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
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
        <th class="<?= $Page->FORM_ID->headerCellClass() ?>"><span id="elh_GOODS_FORM_FORM_ID" class="GOODS_FORM_FORM_ID"><?= $Page->FORM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FORM_ID2->Visible) { // FORM_ID2 ?>
        <th class="<?= $Page->FORM_ID2->headerCellClass() ?>"><span id="elh_GOODS_FORM_FORM_ID2" class="GOODS_FORM_FORM_ID2"><?= $Page->FORM_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FORM_GOODS->Visible) { // FORM_GOODS ?>
        <th class="<?= $Page->FORM_GOODS->headerCellClass() ?>"><span id="elh_GOODS_FORM_FORM_GOODS" class="GOODS_FORM_FORM_GOODS"><?= $Page->FORM_GOODS->caption() ?></span></th>
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
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
        <td <?= $Page->FORM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_FORM_FORM_ID" class="GOODS_FORM_FORM_ID">
<span<?= $Page->FORM_ID->viewAttributes() ?>>
<?= $Page->FORM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FORM_ID2->Visible) { // FORM_ID2 ?>
        <td <?= $Page->FORM_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_FORM_FORM_ID2" class="GOODS_FORM_FORM_ID2">
<span<?= $Page->FORM_ID2->viewAttributes() ?>>
<?= $Page->FORM_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FORM_GOODS->Visible) { // FORM_GOODS ?>
        <td <?= $Page->FORM_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_FORM_FORM_GOODS" class="GOODS_FORM_FORM_GOODS">
<span<?= $Page->FORM_GOODS->viewAttributes() ?>>
<?= $Page->FORM_GOODS->getViewValue() ?></span>
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
