<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodGfDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOOD_GFdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fGOOD_GFdelete = currentForm = new ew.Form("fGOOD_GFdelete", "delete");
    loadjs.done("fGOOD_GFdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.GOOD_GF) ew.vars.tables.GOOD_GF = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fGOOD_GFdelete" id="fGOOD_GFdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
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
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_GOOD_GF_ORG_UNIT_CODE" class="GOOD_GF_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th class="<?= $Page->ORG_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th class="<?= $Page->ROOMS_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Page->ROOMS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <th class="<?= $Page->FROM_ROOMS_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_FROM_ROOMS_ID" class="GOOD_GF_FROM_ROOMS_ID"><?= $Page->FROM_ROOMS_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <th class="<?= $Page->ISOUTLET->headerCellClass() ?>"><span id="elh_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET"><?= $Page->ISOUTLET->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th class="<?= $Page->DISTRIBUTION_TYPE->headerCellClass() ?>"><span id="elh_GOOD_GF_DISTRIBUTION_TYPE" class="GOOD_GF_DISTRIBUTION_TYPE"><?= $Page->DISTRIBUTION_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <th class="<?= $Page->CONDITION->headerCellClass() ?>"><span id="elh_GOOD_GF_CONDITION" class="GOOD_GF_CONDITION"><?= $Page->CONDITION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th class="<?= $Page->ALLOCATED_DATE->headerCellClass() ?>"><span id="elh_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE"><?= $Page->ALLOCATED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <th class="<?= $Page->STOCKOPNAME_DATE->headerCellClass() ?>"><span id="elh_GOOD_GF_STOCKOPNAME_DATE" class="GOOD_GF_STOCKOPNAME_DATE"><?= $Page->STOCKOPNAME_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <th class="<?= $Page->ORG_UNIT_FROM->headerCellClass() ?>"><span id="elh_GOOD_GF_ORG_UNIT_FROM" class="GOOD_GF_ORG_UNIT_FROM"><?= $Page->ORG_UNIT_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <th class="<?= $Page->ITEM_ID_FROM->headerCellClass() ?>"><span id="elh_GOOD_GF_ITEM_ID_FROM" class="GOOD_GF_ITEM_ID_FROM"><?= $Page->ITEM_ID_FROM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_GOOD_GF_MODIFIED_DATE" class="GOOD_GF_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_GOOD_GF_MODIFIED_BY" class="GOOD_GF_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <th class="<?= $Page->STOCK_OPNAME->headerCellClass() ?>"><span id="elh_GOOD_GF_STOCK_OPNAME" class="GOOD_GF_STOCK_OPNAME"><?= $Page->STOCK_OPNAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <th class="<?= $Page->STOK_AWAL->headerCellClass() ?>"><span id="elh_GOOD_GF_STOK_AWAL" class="GOOD_GF_STOK_AWAL"><?= $Page->STOK_AWAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <th class="<?= $Page->STOCK_KOREKSI->headerCellClass() ?>"><span id="elh_GOOD_GF_STOCK_KOREKSI" class="GOOD_GF_STOCK_KOREKSI"><?= $Page->STOCK_KOREKSI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><span id="elh_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <th class="<?= $Page->MONTH_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_MONTH_ID" class="GOOD_GF_MONTH_ID"><?= $Page->MONTH_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th class="<?= $Page->YEAR_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_YEAR_ID" class="GOOD_GF_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <th class="<?= $Page->DOC_NO->headerCellClass() ?>"><span id="elh_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO"><?= $Page->DOC_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <th class="<?= $Page->ORDER_ID->headerCellClass() ?>"><span id="elh_GOOD_GF_ORDER_ID" class="GOOD_GF_ORDER_ID"><?= $Page->ORDER_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_GOOD_GF_ISCETAK" class="GOOD_GF_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
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
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_UNIT_CODE" class="GOOD_GF_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td <?= $Page->ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td <?= $Page->FROM_ROOMS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="GOOD_GF_FROM_ROOMS_ID">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Page->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <td <?= $Page->ISOUTLET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET">
<span<?= $Page->ISOUTLET->viewAttributes() ?>>
<?= $Page->ISOUTLET->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE" class="GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <td <?= $Page->CONDITION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_CONDITION" class="GOOD_GF_CONDITION">
<span<?= $Page->CONDITION->viewAttributes() ?>>
<?= $Page->CONDITION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE" class="GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Page->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Page->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td <?= $Page->ORG_UNIT_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_UNIT_FROM" class="GOOD_GF_ORG_UNIT_FROM">
<span<?= $Page->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Page->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td <?= $Page->ITEM_ID_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ITEM_ID_FROM" class="GOOD_GF_ITEM_ID_FROM">
<span<?= $Page->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Page->ITEM_ID_FROM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MODIFIED_DATE" class="GOOD_GF_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MODIFIED_BY" class="GOOD_GF_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td <?= $Page->STOCK_OPNAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCK_OPNAME" class="GOOD_GF_STOCK_OPNAME">
<span<?= $Page->STOCK_OPNAME->viewAttributes() ?>>
<?= $Page->STOCK_OPNAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td <?= $Page->STOK_AWAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOK_AWAL" class="GOOD_GF_STOK_AWAL">
<span<?= $Page->STOK_AWAL->viewAttributes() ?>>
<?= $Page->STOK_AWAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td <?= $Page->STOCK_KOREKSI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCK_KOREKSI" class="GOOD_GF_STOCK_KOREKSI">
<span<?= $Page->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Page->STOCK_KOREKSI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <td <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MONTH_ID" class="GOOD_GF_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_YEAR_ID" class="GOOD_GF_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <td <?= $Page->DOC_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <td <?= $Page->ORDER_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORDER_ID" class="GOOD_GF_ORDER_ID">
<span<?= $Page->ORDER_ID->viewAttributes() ?>>
<?= $Page->ORDER_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISCETAK" class="GOOD_GF_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
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
