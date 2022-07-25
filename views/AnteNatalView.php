<?php

namespace PHPMaker2021\simrs;

// Page object
$AnteNatalView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fANTE_NATALview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fANTE_NATALview = currentForm = new ew.Form("fANTE_NATALview", "view");
    loadjs.done("fANTE_NATALview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ANTE_NATAL) ew.vars.tables.ANTE_NATAL = <?= JsonEncode(GetClientVar("tables", "ANTE_NATAL")) ?>;
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
<form name="fANTE_NATALview" id="fANTE_NATALview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTE_NATAL">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
    <tr id="r_ANTE_NATAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTE_NATAL_ANTE_NATAL"><?= $Page->ANTE_NATAL->caption() ?></span></td>
        <td data-name="ANTE_NATAL" <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el_ANTE_NATAL_ANTE_NATAL">
<span<?= $Page->ANTE_NATAL->viewAttributes() ?>>
<?= $Page->ANTE_NATAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ANTENATAL->Visible) { // ANTENATAL ?>
    <tr id="r_ANTENATAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ANTE_NATAL_ANTENATAL"><?= $Page->ANTENATAL->caption() ?></span></td>
        <td data-name="ANTENATAL" <?= $Page->ANTENATAL->cellAttributes() ?>>
<span id="el_ANTE_NATAL_ANTENATAL">
<span<?= $Page->ANTENATAL->viewAttributes() ?>>
<?= $Page->ANTENATAL->getViewValue() ?></span>
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
