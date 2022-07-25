<?php

namespace PHPMaker2021\simrs;

// Page object
$UserlevelpermissionDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuserlevelpermissiondelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fuserlevelpermissiondelete = currentForm = new ew.Form("fuserlevelpermissiondelete", "delete");
    loadjs.done("fuserlevelpermissiondelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.userlevelpermission) ew.vars.tables.userlevelpermission = <?= JsonEncode(GetClientVar("tables", "userlevelpermission")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fuserlevelpermissiondelete" id="fuserlevelpermissiondelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevelpermission">
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
        <th class="<?= $Page->UserLevelID->headerCellClass() ?>"><span id="elh_userlevelpermission_UserLevelID" class="userlevelpermission_UserLevelID"><?= $Page->UserLevelID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_TableName->Visible) { // TableName ?>
        <th class="<?= $Page->_TableName->headerCellClass() ?>"><span id="elh_userlevelpermission__TableName" class="userlevelpermission__TableName"><?= $Page->_TableName->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Permission->Visible) { // Permission ?>
        <th class="<?= $Page->_Permission->headerCellClass() ?>"><span id="elh_userlevelpermission__Permission" class="userlevelpermission__Permission"><?= $Page->_Permission->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_userlevelpermission_UserLevelID" class="userlevelpermission_UserLevelID">
<span<?= $Page->UserLevelID->viewAttributes() ?>>
<?= $Page->UserLevelID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_TableName->Visible) { // TableName ?>
        <td <?= $Page->_TableName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_userlevelpermission__TableName" class="userlevelpermission__TableName">
<span<?= $Page->_TableName->viewAttributes() ?>>
<?= $Page->_TableName->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Permission->Visible) { // Permission ?>
        <td <?= $Page->_Permission->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_userlevelpermission__Permission" class="userlevelpermission__Permission">
<span<?= $Page->_Permission->viewAttributes() ?>>
<?= $Page->_Permission->getViewValue() ?></span>
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
