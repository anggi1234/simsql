<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$PoInvoiceitemList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fPO_INVOICEITEMlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fPO_INVOICEITEMlist = currentForm = new ew.Form("fPO_INVOICEITEMlist", "list");
    fPO_INVOICEITEMlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fPO_INVOICEITEMlist");
});
var fPO_INVOICEITEMlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fPO_INVOICEITEMlistsrch = currentSearchForm = new ew.Form("fPO_INVOICEITEMlistsrch");

    // Dynamic selection lists

    // Filters
    fPO_INVOICEITEMlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fPO_INVOICEITEMlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fPO_INVOICEITEMlistsrch" id="fPO_INVOICEITEMlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fPO_INVOICEITEMlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="PO_INVOICEITEM">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> PO_INVOICEITEM">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fPO_INVOICEITEMlist" id="fPO_INVOICEITEMlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICEITEM">
<div id="gmp_PO_INVOICEITEM" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_PO_INVOICEITEMlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ORG_UNIT_CODE" class="PO_INVOICEITEM_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <th data-name="ITEM_ID" class="<?= $Page->ITEM_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ITEM_ID" class="PO_INVOICEITEM_ITEM_ID"><?= $Page->renderSort($Page->ITEM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th data-name="INVOICE_ID" class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_INVOICE_ID" class="PO_INVOICEITEM_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_BRAND_ID" class="PO_INVOICEITEM_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_BRAND_NAME" class="PO_INVOICEITEM_BRAND_NAME"><?= $Page->renderSort($Page->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <th data-name="ORDER_DATE" class="<?= $Page->ORDER_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ORDER_DATE" class="PO_INVOICEITEM_ORDER_DATE"><?= $Page->renderSort($Page->ORDER_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <th data-name="ATP_DATE" class="<?= $Page->ATP_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ATP_DATE" class="PO_INVOICEITEM_ATP_DATE"><?= $Page->renderSort($Page->ATP_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <th data-name="DELIVERY_DATE" class="<?= $Page->DELIVERY_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_DELIVERY_DATE" class="PO_INVOICEITEM_DELIVERY_DATE"><?= $Page->renderSort($Page->DELIVERY_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th data-name="PO" class="<?= $Page->PO->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_PO" class="PO_INVOICEITEM_PO"><?= $Page->renderSort($Page->PO) ?></div></th>
<?php } ?>
<?php if ($Page->UNIT_PRICE->Visible) { // UNIT_PRICE ?>
        <th data-name="UNIT_PRICE" class="<?= $Page->UNIT_PRICE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_UNIT_PRICE" class="PO_INVOICEITEM_UNIT_PRICE"><?= $Page->renderSort($Page->UNIT_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_COMPANY_ID" class="PO_INVOICEITEM_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <th data-name="ORDER_QUANTITY" class="<?= $Page->ORDER_QUANTITY->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ORDER_QUANTITY" class="PO_INVOICEITEM_ORDER_QUANTITY"><?= $Page->renderSort($Page->ORDER_QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <th data-name="RECEIVED_QUANTITY" class="<?= $Page->RECEIVED_QUANTITY->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_RECEIVED_QUANTITY" class="PO_INVOICEITEM_RECEIVED_QUANTITY"><?= $Page->renderSort($Page->RECEIVED_QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th data-name="DISCOUNT" class="<?= $Page->DISCOUNT->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_DISCOUNT" class="PO_INVOICEITEM_DISCOUNT"><?= $Page->renderSort($Page->DISCOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <th data-name="DISCOUNT2" class="<?= $Page->DISCOUNT2->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_DISCOUNT2" class="PO_INVOICEITEM_DISCOUNT2"><?= $Page->renderSort($Page->DISCOUNT2) ?></div></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th data-name="DISCOUNTOFF" class="<?= $Page->DISCOUNTOFF->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_DISCOUNTOFF" class="PO_INVOICEITEM_DISCOUNTOFF"><?= $Page->renderSort($Page->DISCOUNTOFF) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MEASURE_ID" class="PO_INVOICEITEM_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th data-name="SIZE_GOODS" class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_SIZE_GOODS" class="PO_INVOICEITEM_SIZE_GOODS"><?= $Page->renderSort($Page->SIZE_GOODS) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th data-name="MEASURE_DOSIS" class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MEASURE_DOSIS" class="PO_INVOICEITEM_MEASURE_DOSIS"><?= $Page->renderSort($Page->MEASURE_DOSIS) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th data-name="AMOUNT_PAID" class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_AMOUNT_PAID" class="PO_INVOICEITEM_AMOUNT_PAID"><?= $Page->renderSort($Page->AMOUNT_PAID) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th data-name="ORDER_PRICE" class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ORDER_PRICE" class="PO_INVOICEITEM_ORDER_PRICE"><?= $Page->renderSort($Page->ORDER_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_QUANTITY" class="PO_INVOICEITEM_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th data-name="MEASURE_ID3" class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MEASURE_ID3" class="PO_INVOICEITEM_MEASURE_ID3"><?= $Page->renderSort($Page->MEASURE_ID3) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th data-name="SIZE_KEMASAN" class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_SIZE_KEMASAN" class="PO_INVOICEITEM_SIZE_KEMASAN"><?= $Page->renderSort($Page->SIZE_KEMASAN) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MEASURE_ID2" class="PO_INVOICEITEM_MEASURE_ID2"><?= $Page->renderSort($Page->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_DESCRIPTION" class="PO_INVOICEITEM_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MODIFIED_DATE" class="PO_INVOICEITEM_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MODIFIED_BY" class="PO_INVOICEITEM_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_ISCETAK" class="PO_INVOICEITEM_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th data-name="PRINT_DATE" class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_PRINT_DATE" class="PO_INVOICEITEM_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th data-name="PRINTED_BY" class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_PRINTED_BY" class="PO_INVOICEITEM_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th data-name="PRINTQ" class="<?= $Page->PRINTQ->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_PRINTQ" class="PO_INVOICEITEM_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></div></th>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <th data-name="BATCH_NO" class="<?= $Page->BATCH_NO->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_BATCH_NO" class="PO_INVOICEITEM_BATCH_NO"><?= $Page->renderSort($Page->BATCH_NO) ?></div></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th data-name="SERIAL_NB" class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_SERIAL_NB" class="PO_INVOICEITEM_SERIAL_NB"><?= $Page->renderSort($Page->SERIAL_NB) ?></div></th>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th data-name="EXPIRY_DATE" class="<?= $Page->EXPIRY_DATE->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_EXPIRY_DATE" class="PO_INVOICEITEM_EXPIRY_DATE"><?= $Page->renderSort($Page->EXPIRY_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_STATUS_PASIEN_ID" class="PO_INVOICEITEM_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <th data-name="MONTH_ID" class="<?= $Page->MONTH_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_MONTH_ID" class="PO_INVOICEITEM_MONTH_ID"><?= $Page->renderSort($Page->MONTH_ID) ?></div></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th data-name="YEAR_ID" class="<?= $Page->YEAR_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_YEAR_ID" class="PO_INVOICEITEM_YEAR_ID"><?= $Page->renderSort($Page->YEAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
        <th data-name="IDX" class="<?= $Page->IDX->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_IDX" class="PO_INVOICEITEM_IDX"><?= $Page->renderSort($Page->IDX) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_CLINIC_ID" class="PO_INVOICEITEM_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th data-name="PPN" class="<?= $Page->PPN->headerCellClass() ?>"><div id="elh_PO_INVOICEITEM_PPN" class="PO_INVOICEITEM_PPN"><?= $Page->renderSort($Page->PPN) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_PO_INVOICEITEM", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <td data-name="ITEM_ID" <?= $Page->ITEM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ITEM_ID">
<span<?= $Page->ITEM_ID->viewAttributes() ?>>
<?= $Page->ITEM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME" <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <td data-name="ORDER_DATE" <?= $Page->ORDER_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORDER_DATE">
<span<?= $Page->ORDER_DATE->viewAttributes() ?>>
<?= $Page->ORDER_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <td data-name="ATP_DATE" <?= $Page->ATP_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ATP_DATE">
<span<?= $Page->ATP_DATE->viewAttributes() ?>>
<?= $Page->ATP_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <td data-name="DELIVERY_DATE" <?= $Page->DELIVERY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DELIVERY_DATE">
<span<?= $Page->DELIVERY_DATE->viewAttributes() ?>>
<?= $Page->DELIVERY_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PO->Visible) { // PO ?>
        <td data-name="PO" <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->UNIT_PRICE->Visible) { // UNIT_PRICE ?>
        <td data-name="UNIT_PRICE" <?= $Page->UNIT_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_UNIT_PRICE">
<span<?= $Page->UNIT_PRICE->viewAttributes() ?>>
<?= $Page->UNIT_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <td data-name="ORDER_QUANTITY" <?= $Page->ORDER_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORDER_QUANTITY">
<span<?= $Page->ORDER_QUANTITY->viewAttributes() ?>>
<?= $Page->ORDER_QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <td data-name="RECEIVED_QUANTITY" <?= $Page->RECEIVED_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_RECEIVED_QUANTITY">
<span<?= $Page->RECEIVED_QUANTITY->viewAttributes() ?>>
<?= $Page->RECEIVED_QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td data-name="DISCOUNT" <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <td data-name="DISCOUNT2" <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DISCOUNT2">
<span<?= $Page->DISCOUNT2->viewAttributes() ?>>
<?= $Page->DISCOUNT2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td data-name="DISCOUNTOFF" <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <td data-name="BATCH_NO" <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_BATCH_NO">
<span<?= $Page->BATCH_NO->viewAttributes() ?>>
<?= $Page->BATCH_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td data-name="SERIAL_NB" <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td data-name="EXPIRY_DATE" <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_EXPIRY_DATE">
<span<?= $Page->EXPIRY_DATE->viewAttributes() ?>>
<?= $Page->EXPIRY_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID" <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->IDX->Visible) { // IDX ?>
        <td data-name="IDX" <?= $Page->IDX->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_IDX">
<span<?= $Page->IDX->viewAttributes() ?>>
<?= $Page->IDX->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PPN->Visible) { // PPN ?>
        <td data-name="PPN" <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("PO_INVOICEITEM");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
