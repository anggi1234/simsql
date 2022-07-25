<?php

namespace PHPMaker2021\simrs;

// Page object
$AuditTrailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fAuditTraildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fAuditTraildelete = currentForm = new ew.Form("fAuditTraildelete", "delete");
    loadjs.done("fAuditTraildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.AuditTrail) ew.vars.tables.AuditTrail = <?= JsonEncode(GetClientVar("tables", "AuditTrail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fAuditTraildelete" id="fAuditTraildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="AuditTrail">
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
        <th class="<?= $Page->Id->headerCellClass() ?>"><span id="elh_AuditTrail_Id" class="AuditTrail_Id"><?= $Page->Id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DateTime->Visible) { // DateTime ?>
        <th class="<?= $Page->DateTime->headerCellClass() ?>"><span id="elh_AuditTrail_DateTime" class="AuditTrail_DateTime"><?= $Page->DateTime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Script->Visible) { // Script ?>
        <th class="<?= $Page->Script->headerCellClass() ?>"><span id="elh_AuditTrail_Script" class="AuditTrail_Script"><?= $Page->Script->caption() ?></span></th>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
        <th class="<?= $Page->User->headerCellClass() ?>"><span id="elh_AuditTrail_User" class="AuditTrail_User"><?= $Page->User->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Action->Visible) { // Action ?>
        <th class="<?= $Page->_Action->headerCellClass() ?>"><span id="elh_AuditTrail__Action" class="AuditTrail__Action"><?= $Page->_Action->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Table->Visible) { // Table ?>
        <th class="<?= $Page->_Table->headerCellClass() ?>"><span id="elh_AuditTrail__Table" class="AuditTrail__Table"><?= $Page->_Table->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Field->Visible) { // Field ?>
        <th class="<?= $Page->Field->headerCellClass() ?>"><span id="elh_AuditTrail_Field" class="AuditTrail_Field"><?= $Page->Field->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_AuditTrail_Id" class="AuditTrail_Id">
<span<?= $Page->Id->viewAttributes() ?>>
<?= $Page->Id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DateTime->Visible) { // DateTime ?>
        <td <?= $Page->DateTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_DateTime" class="AuditTrail_DateTime">
<span<?= $Page->DateTime->viewAttributes() ?>>
<?= $Page->DateTime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Script->Visible) { // Script ?>
        <td <?= $Page->Script->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_Script" class="AuditTrail_Script">
<span<?= $Page->Script->viewAttributes() ?>>
<?= $Page->Script->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
        <td <?= $Page->User->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_User" class="AuditTrail_User">
<span<?= $Page->User->viewAttributes() ?>>
<?= $Page->User->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Action->Visible) { // Action ?>
        <td <?= $Page->_Action->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail__Action" class="AuditTrail__Action">
<span<?= $Page->_Action->viewAttributes() ?>>
<?= $Page->_Action->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Table->Visible) { // Table ?>
        <td <?= $Page->_Table->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail__Table" class="AuditTrail__Table">
<span<?= $Page->_Table->viewAttributes() ?>>
<?= $Page->_Table->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Field->Visible) { // Field ?>
        <td <?= $Page->Field->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_Field" class="AuditTrail_Field">
<span<?= $Page->Field->viewAttributes() ?>>
<?= $Page->Field->getViewValue() ?></span>
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
