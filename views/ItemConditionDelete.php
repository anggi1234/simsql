<?php

namespace PHPMaker2021\simrs;

// Page object
$ItemConditionDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fITEM_CONDITIONdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fITEM_CONDITIONdelete = currentForm = new ew.Form("fITEM_CONDITIONdelete", "delete");
    loadjs.done("fITEM_CONDITIONdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ITEM_CONDITION) ew.vars.tables.ITEM_CONDITION = <?= JsonEncode(GetClientVar("tables", "ITEM_CONDITION")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fITEM_CONDITIONdelete" id="fITEM_CONDITIONdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ITEM_CONDITION">
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
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <th class="<?= $Page->CONDITION->headerCellClass() ?>"><span id="elh_ITEM_CONDITION_CONDITION" class="ITEM_CONDITION_CONDITION"><?= $Page->CONDITION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_ITEM_CONDITION_DESCRIPTION" class="ITEM_CONDITION_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
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
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <td <?= $Page->CONDITION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ITEM_CONDITION_CONDITION" class="ITEM_CONDITION_CONDITION">
<span<?= $Page->CONDITION->viewAttributes() ?>>
<?= $Page->CONDITION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ITEM_CONDITION_DESCRIPTION" class="ITEM_CONDITION_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
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
