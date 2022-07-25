<?php

namespace PHPMaker2021\simrs;

// Page object
$MutationDocsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fMUTATION_DOCSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fMUTATION_DOCSview = currentForm = new ew.Form("fMUTATION_DOCSview", "view");
    loadjs.done("fMUTATION_DOCSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.MUTATION_DOCS) ew.vars.tables.MUTATION_DOCS = <?= JsonEncode(GetClientVar("tables", "MUTATION_DOCS")) ?>;
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
<form name="fMUTATION_DOCSview" id="fMUTATION_DOCSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="MUTATION_DOCS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
    <tr id="r_DOC_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_DOC_NO"><?= $Page->DOC_NO->caption() ?></span></td>
        <td data-name="DOC_NO" <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID_TO->Visible) { // CLINIC_ID_TO ?>
    <tr id="r_CLINIC_ID_TO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_CLINIC_ID_TO"><?= $Page->CLINIC_ID_TO->caption() ?></span></td>
        <td data-name="CLINIC_ID_TO" <?= $Page->CLINIC_ID_TO->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_CLINIC_ID_TO">
<span<?= $Page->CLINIC_ID_TO->viewAttributes() ?>>
<?= $Page->CLINIC_ID_TO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MUTATION_DATE->Visible) { // MUTATION_DATE ?>
    <tr id="r_MUTATION_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_MUTATION_DATE"><?= $Page->MUTATION_DATE->caption() ?></span></td>
        <td data-name="MUTATION_DATE" <?= $Page->MUTATION_DATE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_DATE">
<span<?= $Page->MUTATION_DATE->viewAttributes() ?>>
<?= $Page->MUTATION_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
    <tr id="r_ORDER_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_ORDER_VALUE"><?= $Page->ORDER_VALUE->caption() ?></span></td>
        <td data-name="ORDER_VALUE" <?= $Page->ORDER_VALUE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_ORDER_VALUE">
<span<?= $Page->ORDER_VALUE->viewAttributes() ?>>
<?= $Page->ORDER_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MUTATION_VALUE->Visible) { // MUTATION_VALUE ?>
    <tr id="r_MUTATION_VALUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_MUTATION_VALUE"><?= $Page->MUTATION_VALUE->caption() ?></span></td>
        <td data-name="MUTATION_VALUE" <?= $Page->MUTATION_VALUE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_VALUE">
<span<?= $Page->MUTATION_VALUE->viewAttributes() ?>>
<?= $Page->MUTATION_VALUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
    <tr id="r_RECEIVED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_RECEIVED_BY"><?= $Page->RECEIVED_BY->caption() ?></span></td>
        <td data-name="RECEIVED_BY" <?= $Page->RECEIVED_BY->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_RECEIVED_BY">
<span<?= $Page->RECEIVED_BY->viewAttributes() ?>>
<?= $Page->RECEIVED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
    <tr id="r_DISTRIBUTION_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_MUTATION_DOCS_DISTRIBUTION_TYPE"><?= $Page->DISTRIBUTION_TYPE->caption() ?></span></td>
        <td data-name="DISTRIBUTION_TYPE" <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("GOOD_GF", explode(",", $Page->getCurrentDetailTable())) && $GOOD_GF->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("GOOD_GF", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GoodGfGrid.php" ?>
<?php } ?>
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
