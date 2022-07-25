<?php

namespace PHPMaker2021\simrs;

// Page object
$UserlevelpermissionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fuserlevelpermissionview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fuserlevelpermissionview = currentForm = new ew.Form("fuserlevelpermissionview", "view");
    loadjs.done("fuserlevelpermissionview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.userlevelpermission) ew.vars.tables.userlevelpermission = <?= JsonEncode(GetClientVar("tables", "userlevelpermission")) ?>;
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
<form name="fuserlevelpermissionview" id="fuserlevelpermissionview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevelpermission">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <tr id="r_UserLevelID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevelpermission_UserLevelID"><?= $Page->UserLevelID->caption() ?></span></td>
        <td data-name="UserLevelID" <?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el_userlevelpermission_UserLevelID">
<span<?= $Page->UserLevelID->viewAttributes() ?>>
<?= $Page->UserLevelID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_TableName->Visible) { // TableName ?>
    <tr id="r__TableName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevelpermission__TableName"><?= $Page->_TableName->caption() ?></span></td>
        <td data-name="_TableName" <?= $Page->_TableName->cellAttributes() ?>>
<span id="el_userlevelpermission__TableName">
<span<?= $Page->_TableName->viewAttributes() ?>>
<?= $Page->_TableName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Permission->Visible) { // Permission ?>
    <tr id="r__Permission">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevelpermission__Permission"><?= $Page->_Permission->caption() ?></span></td>
        <td data-name="_Permission" <?= $Page->_Permission->cellAttributes() ?>>
<span id="el_userlevelpermission__Permission">
<span<?= $Page->_Permission->viewAttributes() ?>>
<?= $Page->_Permission->getViewValue() ?></span>
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
