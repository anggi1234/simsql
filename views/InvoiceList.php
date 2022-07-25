<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$InvoiceList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fINVOICElist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fINVOICElist = currentForm = new ew.Form("fINVOICElist", "list");
    fINVOICElist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fINVOICElist");
});
var fINVOICElistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fINVOICElistsrch = currentSearchForm = new ew.Form("fINVOICElistsrch");

    // Dynamic selection lists

    // Filters
    fINVOICElistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fINVOICElistsrch");
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
<form name="fINVOICElistsrch" id="fINVOICElistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fINVOICElistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="INVOICE">
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
<div class="ew-multi-column-grid">
<?php if (!$Page->isExport()) { ?>
<div>
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
<form name="fINVOICElist" id="fINVOICElist" class="ew-horizontal ew-form ew-list-form ew-multi-column-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="INVOICE">
<div class="row ew-multi-column-row">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_INVOICE", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
<div class="<?= $Page->getMultiColumnClass() ?>" <?= $Page->rowAttributes() ?>>
    <div class="card ew-card">
    <div class="card-body">
    <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
    <table class="table table-bordered table-hover ew-view-table">
    <?php } ?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></span></td>
            <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ORG_UNIT_CODE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INVOICE_ID"><?= $Page->renderSort($Page->INVOICE_ID) ?></span></td>
            <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INVOICE_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INVOICE_TYPE"><?= $Page->renderSort($Page->INVOICE_TYPE) ?></span></td>
            <td <?= $Page->INVOICE_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TYPE">
<span<?= $Page->INVOICE_TYPE->viewAttributes() ?>>
<?= $Page->INVOICE_TYPE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INVOICE_TYPE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_TYPE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TYPE">
<span<?= $Page->INVOICE_TYPE->viewAttributes() ?>>
<?= $Page->INVOICE_TYPE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INVOICE_NO"><?= $Page->renderSort($Page->INVOICE_NO) ?></span></td>
            <td <?= $Page->INVOICE_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_NO">
<span<?= $Page->INVOICE_NO->viewAttributes() ?>>
<?= $Page->INVOICE_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INVOICE_NO">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_NO->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_NO">
<span<?= $Page->INVOICE_NO->viewAttributes() ?>>
<?= $Page->INVOICE_NO->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INV_COUNTER"><?= $Page->renderSort($Page->INV_COUNTER) ?></span></td>
            <td <?= $Page->INV_COUNTER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_COUNTER">
<span<?= $Page->INV_COUNTER->viewAttributes() ?>>
<?= $Page->INV_COUNTER->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INV_COUNTER">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INV_COUNTER->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INV_COUNTER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_COUNTER">
<span<?= $Page->INV_COUNTER->viewAttributes() ?>>
<?= $Page->INV_COUNTER->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INV_DATE"><?= $Page->renderSort($Page->INV_DATE) ?></span></td>
            <td <?= $Page->INV_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_DATE">
<span<?= $Page->INV_DATE->viewAttributes() ?>>
<?= $Page->INV_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INV_DATE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INV_DATE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INV_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_DATE">
<span<?= $Page->INV_DATE->viewAttributes() ?>>
<?= $Page->INV_DATE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INVOICE_TRANS"><?= $Page->renderSort($Page->INVOICE_TRANS) ?></span></td>
            <td <?= $Page->INVOICE_TRANS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TRANS">
<span<?= $Page->INVOICE_TRANS->viewAttributes() ?>>
<?= $Page->INVOICE_TRANS->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INVOICE_TRANS">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_TRANS->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_TRANS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TRANS">
<span<?= $Page->INVOICE_TRANS->viewAttributes() ?>>
<?= $Page->INVOICE_TRANS->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_INVOICE_DUE"><?= $Page->renderSort($Page->INVOICE_DUE) ?></span></td>
            <td <?= $Page->INVOICE_DUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_DUE">
<span<?= $Page->INVOICE_DUE->viewAttributes() ?>>
<?= $Page->INVOICE_DUE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_INVOICE_DUE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_DUE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_DUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_DUE">
<span<?= $Page->INVOICE_DUE->viewAttributes() ?>>
<?= $Page->INVOICE_DUE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_REF_TYPE"><?= $Page->renderSort($Page->REF_TYPE) ?></span></td>
            <td <?= $Page->REF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_TYPE">
<span<?= $Page->REF_TYPE->viewAttributes() ?>>
<?= $Page->REF_TYPE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_REF_TYPE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_TYPE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_TYPE">
<span<?= $Page->REF_TYPE->viewAttributes() ?>>
<?= $Page->REF_TYPE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->REF_NO->Visible) { // REF_NO ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_REF_NO"><?= $Page->renderSort($Page->REF_NO) ?></span></td>
            <td <?= $Page->REF_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO">
<span<?= $Page->REF_NO->viewAttributes() ?>>
<?= $Page->REF_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_REF_NO">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_NO->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO">
<span<?= $Page->REF_NO->viewAttributes() ?>>
<?= $Page->REF_NO->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_REF_NO2"><?= $Page->renderSort($Page->REF_NO2) ?></span></td>
            <td <?= $Page->REF_NO2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO2">
<span<?= $Page->REF_NO2->viewAttributes() ?>>
<?= $Page->REF_NO2->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_REF_NO2">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_NO2->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_NO2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO2">
<span<?= $Page->REF_NO2->viewAttributes() ?>>
<?= $Page->REF_NO2->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_REF_DATE"><?= $Page->renderSort($Page->REF_DATE) ?></span></td>
            <td <?= $Page->REF_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_DATE">
<span<?= $Page->REF_DATE->viewAttributes() ?>>
<?= $Page->REF_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_REF_DATE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_DATE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_DATE">
<span<?= $Page->REF_DATE->viewAttributes() ?>>
<?= $Page->REF_DATE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ACCOUNT_ID"><?= $Page->renderSort($Page->ACCOUNT_ID) ?></span></td>
            <td <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ACCOUNT_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACCOUNT_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_YEAR_ID"><?= $Page->renderSort($Page->YEAR_ID) ?></span></td>
            <td <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_YEAR_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->YEAR_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ORG_ID"><?= $Page->renderSort($Page->ORG_ID) ?></span></td>
            <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ORG_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PROGRAM_ID"><?= $Page->renderSort($Page->PROGRAM_ID) ?></span></td>
            <td <?= $Page->PROGRAM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAM_ID">
<span<?= $Page->PROGRAM_ID->viewAttributes() ?>>
<?= $Page->PROGRAM_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PROGRAM_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PROGRAM_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROGRAM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAM_ID">
<span<?= $Page->PROGRAM_ID->viewAttributes() ?>>
<?= $Page->PROGRAM_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PROGRAMS"><?= $Page->renderSort($Page->PROGRAMS) ?></span></td>
            <td <?= $Page->PROGRAMS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAMS">
<span<?= $Page->PROGRAMS->viewAttributes() ?>>
<?= $Page->PROGRAMS->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PROGRAMS">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PROGRAMS->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROGRAMS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAMS">
<span<?= $Page->PROGRAMS->viewAttributes() ?>>
<?= $Page->PROGRAMS->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PACTIVITY_ID"><?= $Page->renderSort($Page->PACTIVITY_ID) ?></span></td>
            <td <?= $Page->PACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PACTIVITY_ID">
<span<?= $Page->PACTIVITY_ID->viewAttributes() ?>>
<?= $Page->PACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PACTIVITY_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PACTIVITY_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PACTIVITY_ID">
<span<?= $Page->PACTIVITY_ID->viewAttributes() ?>>
<?= $Page->PACTIVITY_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ACTIVITY_ID"><?= $Page->renderSort($Page->ACTIVITY_ID) ?></span></td>
            <td <?= $Page->ACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_ID">
<span<?= $Page->ACTIVITY_ID->viewAttributes() ?>>
<?= $Page->ACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ACTIVITY_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACTIVITY_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_ID">
<span<?= $Page->ACTIVITY_ID->viewAttributes() ?>>
<?= $Page->ACTIVITY_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ACTIVITY_NAME"><?= $Page->renderSort($Page->ACTIVITY_NAME) ?></span></td>
            <td <?= $Page->ACTIVITY_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_NAME">
<span<?= $Page->ACTIVITY_NAME->viewAttributes() ?>>
<?= $Page->ACTIVITY_NAME->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ACTIVITY_NAME">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACTIVITY_NAME->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACTIVITY_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_NAME">
<span<?= $Page->ACTIVITY_NAME->viewAttributes() ?>>
<?= $Page->ACTIVITY_NAME->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_KEPERLUAN"><?= $Page->renderSort($Page->KEPERLUAN) ?></span></td>
            <td <?= $Page->KEPERLUAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_KEPERLUAN">
<span<?= $Page->KEPERLUAN->viewAttributes() ?>>
<?= $Page->KEPERLUAN->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_KEPERLUAN">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->KEPERLUAN->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KEPERLUAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_KEPERLUAN">
<span<?= $Page->KEPERLUAN->viewAttributes() ?>>
<?= $Page->KEPERLUAN->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PPTK->Visible) { // PPTK ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PPTK"><?= $Page->renderSort($Page->PPTK) ?></span></td>
            <td <?= $Page->PPTK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK">
<span<?= $Page->PPTK->viewAttributes() ?>>
<?= $Page->PPTK->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PPTK">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPTK->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPTK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK">
<span<?= $Page->PPTK->viewAttributes() ?>>
<?= $Page->PPTK->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PPTK_NAME"><?= $Page->renderSort($Page->PPTK_NAME) ?></span></td>
            <td <?= $Page->PPTK_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_NAME">
<span<?= $Page->PPTK_NAME->viewAttributes() ?>>
<?= $Page->PPTK_NAME->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PPTK_NAME">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPTK_NAME->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPTK_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_NAME">
<span<?= $Page->PPTK_NAME->viewAttributes() ?>>
<?= $Page->PPTK_NAME->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></span></td>
            <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_TO"><?= $Page->renderSort($Page->COMPANY_TO) ?></span></td>
            <td <?= $Page->COMPANY_TO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TO">
<span<?= $Page->COMPANY_TO->viewAttributes() ?>>
<?= $Page->COMPANY_TO->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_TO">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_TO->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_TO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TO">
<span<?= $Page->COMPANY_TO->viewAttributes() ?>>
<?= $Page->COMPANY_TO->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_TYPE"><?= $Page->renderSort($Page->COMPANY_TYPE) ?></span></td>
            <td <?= $Page->COMPANY_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TYPE">
<span<?= $Page->COMPANY_TYPE->viewAttributes() ?>>
<?= $Page->COMPANY_TYPE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_TYPE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_TYPE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TYPE">
<span<?= $Page->COMPANY_TYPE->viewAttributes() ?>>
<?= $Page->COMPANY_TYPE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY->Visible) { // COMPANY ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY"><?= $Page->renderSort($Page->COMPANY) ?></span></td>
            <td <?= $Page->COMPANY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY">
<span<?= $Page->COMPANY->viewAttributes() ?>>
<?= $Page->COMPANY->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY">
<span<?= $Page->COMPANY->viewAttributes() ?>>
<?= $Page->COMPANY->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_CHIEF"><?= $Page->renderSort($Page->COMPANY_CHIEF) ?></span></td>
            <td <?= $Page->COMPANY_CHIEF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_CHIEF">
<span<?= $Page->COMPANY_CHIEF->viewAttributes() ?>>
<?= $Page->COMPANY_CHIEF->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_CHIEF">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_CHIEF->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_CHIEF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_CHIEF">
<span<?= $Page->COMPANY_CHIEF->viewAttributes() ?>>
<?= $Page->COMPANY_CHIEF->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_INFO"><?= $Page->renderSort($Page->COMPANY_INFO) ?></span></td>
            <td <?= $Page->COMPANY_INFO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_INFO">
<span<?= $Page->COMPANY_INFO->viewAttributes() ?>>
<?= $Page->COMPANY_INFO->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_INFO">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_INFO->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_INFO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_INFO">
<span<?= $Page->COMPANY_INFO->viewAttributes() ?>>
<?= $Page->COMPANY_INFO->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_CONTRACT_NO"><?= $Page->renderSort($Page->CONTRACT_NO) ?></span></td>
            <td <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_CONTRACT_NO">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONTRACT_NO->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->NPWP->Visible) { // NPWP ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_NPWP"><?= $Page->renderSort($Page->NPWP) ?></span></td>
            <td <?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_NPWP">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->NPWP->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_BANK"><?= $Page->renderSort($Page->COMPANY_BANK) ?></span></td>
            <td <?= $Page->COMPANY_BANK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_BANK">
<span<?= $Page->COMPANY_BANK->viewAttributes() ?>>
<?= $Page->COMPANY_BANK->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_BANK">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_BANK->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_BANK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_BANK">
<span<?= $Page->COMPANY_BANK->viewAttributes() ?>>
<?= $Page->COMPANY_BANK->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_COMPANY_ACCOUNT"><?= $Page->renderSort($Page->COMPANY_ACCOUNT) ?></span></td>
            <td <?= $Page->COMPANY_ACCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ACCOUNT">
<span<?= $Page->COMPANY_ACCOUNT->viewAttributes() ?>>
<?= $Page->COMPANY_ACCOUNT->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_COMPANY_ACCOUNT">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ACCOUNT->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ACCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ACCOUNT">
<span<?= $Page->COMPANY_ACCOUNT->viewAttributes() ?>>
<?= $Page->COMPANY_ACCOUNT->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PAGU->Visible) { // PAGU ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PAGU"><?= $Page->renderSort($Page->PAGU) ?></span></td>
            <td <?= $Page->PAGU->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU">
<span<?= $Page->PAGU->viewAttributes() ?>>
<?= $Page->PAGU->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PAGU">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAGU->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAGU->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU">
<span<?= $Page->PAGU->viewAttributes() ?>>
<?= $Page->PAGU->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PAGU_REALISASI"><?= $Page->renderSort($Page->PAGU_REALISASI) ?></span></td>
            <td <?= $Page->PAGU_REALISASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU_REALISASI">
<span<?= $Page->PAGU_REALISASI->viewAttributes() ?>>
<?= $Page->PAGU_REALISASI->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PAGU_REALISASI">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAGU_REALISASI->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAGU_REALISASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU_REALISASI">
<span<?= $Page->PAGU_REALISASI->viewAttributes() ?>>
<?= $Page->PAGU_REALISASI->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></span></td>
            <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_AMOUNT">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_AMOUNT_PAID"><?= $Page->renderSort($Page->AMOUNT_PAID) ?></span></td>
            <td <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_AMOUNT_PAID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT_PAID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PAYMENT_INSTRUCTIONS"><?= $Page->renderSort($Page->PAYMENT_INSTRUCTIONS) ?></span></td>
            <td <?= $Page->PAYMENT_INSTRUCTIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAYMENT_INSTRUCTIONS">
<span<?= $Page->PAYMENT_INSTRUCTIONS->viewAttributes() ?>>
<?= $Page->PAYMENT_INSTRUCTIONS->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PAYMENT_INSTRUCTIONS">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYMENT_INSTRUCTIONS->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYMENT_INSTRUCTIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAYMENT_INSTRUCTIONS">
<span<?= $Page->PAYMENT_INSTRUCTIONS->viewAttributes() ?>>
<?= $Page->PAYMENT_INSTRUCTIONS->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ISAPPROVED"><?= $Page->renderSort($Page->ISAPPROVED) ?></span></td>
            <td <?= $Page->ISAPPROVED->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISAPPROVED">
<span<?= $Page->ISAPPROVED->viewAttributes() ?>>
<?= $Page->ISAPPROVED->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ISAPPROVED">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISAPPROVED->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISAPPROVED->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISAPPROVED">
<span<?= $Page->ISAPPROVED->viewAttributes() ?>>
<?= $Page->ISAPPROVED->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_APPROVED_BY"><?= $Page->renderSort($Page->APPROVED_BY) ?></span></td>
            <td <?= $Page->APPROVED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_BY">
<span<?= $Page->APPROVED_BY->viewAttributes() ?>>
<?= $Page->APPROVED_BY->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_APPROVED_BY">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_BY->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_BY">
<span<?= $Page->APPROVED_BY->viewAttributes() ?>>
<?= $Page->APPROVED_BY->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_APPROVED_DATE"><?= $Page->renderSort($Page->APPROVED_DATE) ?></span></td>
            <td <?= $Page->APPROVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_DATE">
<span<?= $Page->APPROVED_DATE->viewAttributes() ?>>
<?= $Page->APPROVED_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_APPROVED_DATE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_DATE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_DATE">
<span<?= $Page->APPROVED_DATE->viewAttributes() ?>>
<?= $Page->APPROVED_DATE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></span></td>
            <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_ISCETAK">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PRINTQ"><?= $Page->renderSort($Page->PRINTQ) ?></span></td>
            <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PRINTQ">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PRINT_DATE"><?= $Page->renderSort($Page->PRINT_DATE) ?></span></td>
            <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PRINT_DATE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PRINTED_BY"><?= $Page->renderSort($Page->PRINTED_BY) ?></span></td>
            <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PRINTED_BY">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTED_BY->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></span></td>
            <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_MODIFIED_DATE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></span></td>
            <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_MODIFIED_BY">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_PPTK_TITLE"><?= $Page->renderSort($Page->PPTK_TITLE) ?></span></td>
            <td <?= $Page->PPTK_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_TITLE">
<span<?= $Page->PPTK_TITLE->viewAttributes() ?>>
<?= $Page->PPTK_TITLE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_PPTK_TITLE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPTK_TITLE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPTK_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_TITLE">
<span<?= $Page->PPTK_TITLE->viewAttributes() ?>>
<?= $Page->PPTK_TITLE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_APPROVED_ID"><?= $Page->renderSort($Page->APPROVED_ID) ?></span></td>
            <td <?= $Page->APPROVED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_ID">
<span<?= $Page->APPROVED_ID->viewAttributes() ?>>
<?= $Page->APPROVED_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_APPROVED_ID">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_ID->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_ID">
<span<?= $Page->APPROVED_ID->viewAttributes() ?>>
<?= $Page->APPROVED_ID->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <tr>
            <td class="ew-table-header <?= $Page->TableLeftColumnClass ?>"><span class="INVOICE_APPROVED_TITLE"><?= $Page->renderSort($Page->APPROVED_TITLE) ?></span></td>
            <td <?= $Page->APPROVED_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_TITLE">
<span<?= $Page->APPROVED_TITLE->viewAttributes() ?>>
<?= $Page->APPROVED_TITLE->getViewValue() ?></span>
</span>
</td>
        </tr>
        <?php } else { // Add/edit record ?>
        <div class="form-group row INVOICE_APPROVED_TITLE">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_TITLE->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_TITLE">
<span<?= $Page->APPROVED_TITLE->viewAttributes() ?>>
<?= $Page->APPROVED_TITLE->getViewValue() ?></span>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
    </table>
    <?php } ?>
    </div><!-- /.card-body -->
<?php if (!$Page->isExport()) { ?>
    <div class="card-footer">
        <div class="ew-multi-column-list-option">
<?php
// Render list options (body, bottom)
$Page->ListOptions->render("body", "bottom", $Page->RowCount);
?>
        </div><!-- /.ew-multi-column-list-option -->
        <div class="clearfix"></div>
    </div><!-- /.card-footer -->
<?php } ?>
    </div><!-- /.card -->
</div><!-- /.col-* -->
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
<?php } ?>
</div><!-- /.ew-multi-column-row -->
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
</div><!-- /.ew-multi-column-grid -->
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
    ew.addEventHandlers("INVOICE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
