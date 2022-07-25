<?php

namespace PHPMaker2021\simrs;

// Page object
$AnteNatalDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTE_NATALdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fANTE_NATALdelete = currentForm = new ew.Form("fANTE_NATALdelete", "delete");
    loadjs.done("fANTE_NATALdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ANTE_NATAL) ew.vars.tables.ANTE_NATAL = <?= JsonEncode(GetClientVar("tables", "ANTE_NATAL")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fANTE_NATALdelete" id="fANTE_NATALdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTE_NATAL">
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
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <th class="<?= $Page->ANTE_NATAL->headerCellClass() ?>"><span id="elh_ANTE_NATAL_ANTE_NATAL" class="ANTE_NATAL_ANTE_NATAL"><?= $Page->ANTE_NATAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ANTENATAL->Visible) { // ANTENATAL ?>
        <th class="<?= $Page->ANTENATAL->headerCellClass() ?>"><span id="elh_ANTE_NATAL_ANTENATAL" class="ANTE_NATAL_ANTENATAL"><?= $Page->ANTENATAL->caption() ?></span></th>
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
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <td <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTE_NATAL_ANTE_NATAL" class="ANTE_NATAL_ANTE_NATAL">
<span<?= $Page->ANTE_NATAL->viewAttributes() ?>>
<?= $Page->ANTE_NATAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ANTENATAL->Visible) { // ANTENATAL ?>
        <td <?= $Page->ANTENATAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTE_NATAL_ANTENATAL" class="ANTE_NATAL_ANTENATAL">
<span<?= $Page->ANTENATAL->viewAttributes() ?>>
<?= $Page->ANTENATAL->getViewValue() ?></span>
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
