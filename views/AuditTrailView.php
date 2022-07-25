<?php

namespace PHPMaker2021\simrs;

// Page object
$AuditTrailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fAuditTrailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fAuditTrailview = currentForm = new ew.Form("fAuditTrailview", "view");
    loadjs.done("fAuditTrailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.AuditTrail) ew.vars.tables.AuditTrail = <?= JsonEncode(GetClientVar("tables", "AuditTrail")) ?>;
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
<form name="fAuditTrailview" id="fAuditTrailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="AuditTrail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->Id->Visible) { // Id ?>
    <tr id="r_Id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_Id"><?= $Page->Id->caption() ?></span></td>
        <td data-name="Id" <?= $Page->Id->cellAttributes() ?>>
<span id="el_AuditTrail_Id">
<span<?= $Page->Id->viewAttributes() ?>>
<?= $Page->Id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DateTime->Visible) { // DateTime ?>
    <tr id="r_DateTime">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_DateTime"><?= $Page->DateTime->caption() ?></span></td>
        <td data-name="DateTime" <?= $Page->DateTime->cellAttributes() ?>>
<span id="el_AuditTrail_DateTime">
<span<?= $Page->DateTime->viewAttributes() ?>>
<?= $Page->DateTime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Script->Visible) { // Script ?>
    <tr id="r_Script">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_Script"><?= $Page->Script->caption() ?></span></td>
        <td data-name="Script" <?= $Page->Script->cellAttributes() ?>>
<span id="el_AuditTrail_Script">
<span<?= $Page->Script->viewAttributes() ?>>
<?= $Page->Script->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
    <tr id="r_User">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_User"><?= $Page->User->caption() ?></span></td>
        <td data-name="User" <?= $Page->User->cellAttributes() ?>>
<span id="el_AuditTrail_User">
<span<?= $Page->User->viewAttributes() ?>>
<?= $Page->User->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Action->Visible) { // Action ?>
    <tr id="r__Action">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail__Action"><?= $Page->_Action->caption() ?></span></td>
        <td data-name="_Action" <?= $Page->_Action->cellAttributes() ?>>
<span id="el_AuditTrail__Action">
<span<?= $Page->_Action->viewAttributes() ?>>
<?= $Page->_Action->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Table->Visible) { // Table ?>
    <tr id="r__Table">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail__Table"><?= $Page->_Table->caption() ?></span></td>
        <td data-name="_Table" <?= $Page->_Table->cellAttributes() ?>>
<span id="el_AuditTrail__Table">
<span<?= $Page->_Table->viewAttributes() ?>>
<?= $Page->_Table->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Field->Visible) { // Field ?>
    <tr id="r_Field">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_Field"><?= $Page->Field->caption() ?></span></td>
        <td data-name="Field" <?= $Page->Field->cellAttributes() ?>>
<span id="el_AuditTrail_Field">
<span<?= $Page->Field->viewAttributes() ?>>
<?= $Page->Field->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KeyValue->Visible) { // KeyValue ?>
    <tr id="r_KeyValue">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_KeyValue"><?= $Page->KeyValue->caption() ?></span></td>
        <td data-name="KeyValue" <?= $Page->KeyValue->cellAttributes() ?>>
<span id="el_AuditTrail_KeyValue">
<span<?= $Page->KeyValue->viewAttributes() ?>>
<?= $Page->KeyValue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->OldValue->Visible) { // OldValue ?>
    <tr id="r_OldValue">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_OldValue"><?= $Page->OldValue->caption() ?></span></td>
        <td data-name="OldValue" <?= $Page->OldValue->cellAttributes() ?>>
<span id="el_AuditTrail_OldValue">
<span<?= $Page->OldValue->viewAttributes() ?>>
<?= $Page->OldValue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NewValue->Visible) { // NewValue ?>
    <tr id="r_NewValue">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_AuditTrail_NewValue"><?= $Page->NewValue->caption() ?></span></td>
        <td data-name="NewValue" <?= $Page->NewValue->cellAttributes() ?>>
<span id="el_AuditTrail_NewValue">
<span<?= $Page->NewValue->viewAttributes() ?>>
<?= $Page->NewValue->getViewValue() ?></span>
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
