<?php

namespace PHPMaker2021\simrs;

// Page object
$Userlevel2View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fuserlevel2view;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fuserlevel2view = currentForm = new ew.Form("fuserlevel2view", "view");
    loadjs.done("fuserlevel2view");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.userlevel2) ew.vars.tables.userlevel2 = <?= JsonEncode(GetClientVar("tables", "userlevel2")) ?>;
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
<form name="fuserlevel2view" id="fuserlevel2view" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevel2">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <tr id="r_UserLevelID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevel2_UserLevelID"><?= $Page->UserLevelID->caption() ?></span></td>
        <td data-name="UserLevelID" <?= $Page->UserLevelID->cellAttributes() ?>>
<span id="el_userlevel2_UserLevelID">
<span<?= $Page->UserLevelID->viewAttributes() ?>>
<?= $Page->UserLevelID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
    <tr id="r_UserLevelName">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevel2_UserLevelName"><?= $Page->UserLevelName->caption() ?></span></td>
        <td data-name="UserLevelName" <?= $Page->UserLevelName->cellAttributes() ?>>
<span id="el_userlevel2_UserLevelName">
<span<?= $Page->UserLevelName->viewAttributes() ?>>
<?= $Page->UserLevelName->getViewValue() ?></span>
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
