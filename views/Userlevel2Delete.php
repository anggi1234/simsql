<?php

namespace PHPMaker2021\simrs;

// Page object
$Userlevel2Delete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuserlevel2delete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fuserlevel2delete = currentForm = new ew.Form("fuserlevel2delete", "delete");
    loadjs.done("fuserlevel2delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.userlevel2) ew.vars.tables.userlevel2 = <?= JsonEncode(GetClientVar("tables", "userlevel2")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fuserlevel2delete" id="fuserlevel2delete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevel2">
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
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
        <th class="<?= $Page->UserLevelID->headerCellClass() ?>"><span id="elh_userlevel2_UserLevelID" class="userlevel2_UserLevelID"><?= $Page->UserLevelID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
        <th class="<?= $Page->UserLevelName->headerCellClass() ?>"><span id="elh_userlevel2_UserLevelName" class="userlevel2_UserLevelName"><?= $Page->UserLevelName->caption() ?></span></th>
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
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
        <td <?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_userlevel2_UserLevelID" class="userlevel2_UserLevelID">
<span<?= $Page->UserLevelID->viewAttributes() ?>>
<?= $Page->UserLevelID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
        <td <?= $Page->UserLevelName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_userlevel2_UserLevelName" class="userlevel2_UserLevelName">
<span<?= $Page->UserLevelName->viewAttributes() ?>>
<?= $Page->UserLevelName->getViewValue() ?></span>
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
