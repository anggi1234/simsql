<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodGfList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_GFlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fGOOD_GFlist = currentForm = new ew.Form("fGOOD_GFlist", "list");
    fGOOD_GFlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOOD_GF)
        ew.vars.tables.GOOD_GF = currentTable;
    fGOOD_GFlist.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["FROM_ROOMS_ID", [fields.FROM_ROOMS_ID.visible && fields.FROM_ROOMS_ID.required ? ew.Validators.required(fields.FROM_ROOMS_ID.caption) : null], fields.FROM_ROOMS_ID.isInvalid],
        ["ISOUTLET", [fields.ISOUTLET.visible && fields.ISOUTLET.required ? ew.Validators.required(fields.ISOUTLET.caption) : null], fields.ISOUTLET.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["DISTRIBUTION_TYPE", [fields.DISTRIBUTION_TYPE.visible && fields.DISTRIBUTION_TYPE.required ? ew.Validators.required(fields.DISTRIBUTION_TYPE.caption) : null, ew.Validators.integer], fields.DISTRIBUTION_TYPE.isInvalid],
        ["CONDITION", [fields.CONDITION.visible && fields.CONDITION.required ? ew.Validators.required(fields.CONDITION.caption) : null, ew.Validators.integer], fields.CONDITION.isInvalid],
        ["ALLOCATED_DATE", [fields.ALLOCATED_DATE.visible && fields.ALLOCATED_DATE.required ? ew.Validators.required(fields.ALLOCATED_DATE.caption) : null, ew.Validators.datetime(0)], fields.ALLOCATED_DATE.isInvalid],
        ["STOCKOPNAME_DATE", [fields.STOCKOPNAME_DATE.visible && fields.STOCKOPNAME_DATE.required ? ew.Validators.required(fields.STOCKOPNAME_DATE.caption) : null, ew.Validators.datetime(0)], fields.STOCKOPNAME_DATE.isInvalid],
        ["ORG_UNIT_FROM", [fields.ORG_UNIT_FROM.visible && fields.ORG_UNIT_FROM.required ? ew.Validators.required(fields.ORG_UNIT_FROM.caption) : null], fields.ORG_UNIT_FROM.isInvalid],
        ["ITEM_ID_FROM", [fields.ITEM_ID_FROM.visible && fields.ITEM_ID_FROM.required ? ew.Validators.required(fields.ITEM_ID_FROM.caption) : null], fields.ITEM_ID_FROM.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["STOCK_OPNAME", [fields.STOCK_OPNAME.visible && fields.STOCK_OPNAME.required ? ew.Validators.required(fields.STOCK_OPNAME.caption) : null, ew.Validators.float], fields.STOCK_OPNAME.isInvalid],
        ["STOK_AWAL", [fields.STOK_AWAL.visible && fields.STOK_AWAL.required ? ew.Validators.required(fields.STOK_AWAL.caption) : null, ew.Validators.float], fields.STOK_AWAL.isInvalid],
        ["STOCK_KOREKSI", [fields.STOCK_KOREKSI.visible && fields.STOCK_KOREKSI.required ? ew.Validators.required(fields.STOCK_KOREKSI.caption) : null, ew.Validators.float], fields.STOCK_KOREKSI.isInvalid],
        ["BRAND_NAME", [fields.BRAND_NAME.visible && fields.BRAND_NAME.required ? ew.Validators.required(fields.BRAND_NAME.caption) : null], fields.BRAND_NAME.isInvalid],
        ["MONTH_ID", [fields.MONTH_ID.visible && fields.MONTH_ID.required ? ew.Validators.required(fields.MONTH_ID.caption) : null, ew.Validators.integer], fields.MONTH_ID.isInvalid],
        ["YEAR_ID", [fields.YEAR_ID.visible && fields.YEAR_ID.required ? ew.Validators.required(fields.YEAR_ID.caption) : null, ew.Validators.integer], fields.YEAR_ID.isInvalid],
        ["DOC_NO", [fields.DOC_NO.visible && fields.DOC_NO.required ? ew.Validators.required(fields.DOC_NO.caption) : null], fields.DOC_NO.isInvalid],
        ["ORDER_ID", [fields.ORDER_ID.visible && fields.ORDER_ID.required ? ew.Validators.required(fields.ORDER_ID.caption) : null], fields.ORDER_ID.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOOD_GFlist,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fGOOD_GFlist.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }
        return true;
    }

    // Form_CustomValidate
    fGOOD_GFlist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOOD_GFlist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fGOOD_GFlist.lists.BRAND_ID = <?= $Page->BRAND_ID->toClientList($Page) ?>;
    loadjs.done("fGOOD_GFlist");
});
var fGOOD_GFlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fGOOD_GFlistsrch = currentSearchForm = new ew.Form("fGOOD_GFlistsrch");

    // Dynamic selection lists

    // Filters
    fGOOD_GFlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fGOOD_GFlistsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "MUTATION_DOCS") {
    if ($Page->MasterRecordExists) {
        include_once "views/MutationDocsMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fGOOD_GFlistsrch" id="fGOOD_GFlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fGOOD_GFlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="GOOD_GF">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> GOOD_GF">
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
<form name="fGOOD_GFlist" id="fGOOD_GFlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<?php if ($Page->getCurrentMasterTable() == "MUTATION_DOCS" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="MUTATION_DOCS">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ORG_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_GOOD_GF" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_GOOD_GFlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_UNIT_CODE" class="GOOD_GF_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Page->ORG_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID"><?= $Page->renderSort($Page->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Page->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Page->renderSort($Page->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <th data-name="FROM_ROOMS_ID" class="<?= $Page->FROM_ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_FROM_ROOMS_ID" class="GOOD_GF_FROM_ROOMS_ID"><?= $Page->renderSort($Page->FROM_ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <th data-name="ISOUTLET" class="<?= $Page->ISOUTLET->headerCellClass() ?>"><div id="elh_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET"><?= $Page->renderSort($Page->ISOUTLET) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th data-name="DISTRIBUTION_TYPE" class="<?= $Page->DISTRIBUTION_TYPE->headerCellClass() ?>"><div id="elh_GOOD_GF_DISTRIBUTION_TYPE" class="GOOD_GF_DISTRIBUTION_TYPE"><?= $Page->renderSort($Page->DISTRIBUTION_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <th data-name="CONDITION" class="<?= $Page->CONDITION->headerCellClass() ?>"><div id="elh_GOOD_GF_CONDITION" class="GOOD_GF_CONDITION"><?= $Page->renderSort($Page->CONDITION) ?></div></th>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th data-name="ALLOCATED_DATE" class="<?= $Page->ALLOCATED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE"><?= $Page->renderSort($Page->ALLOCATED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <th data-name="STOCKOPNAME_DATE" class="<?= $Page->STOCKOPNAME_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCKOPNAME_DATE" class="GOOD_GF_STOCKOPNAME_DATE"><?= $Page->renderSort($Page->STOCKOPNAME_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <th data-name="ORG_UNIT_FROM" class="<?= $Page->ORG_UNIT_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_UNIT_FROM" class="GOOD_GF_ORG_UNIT_FROM"><?= $Page->renderSort($Page->ORG_UNIT_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <th data-name="ITEM_ID_FROM" class="<?= $Page->ITEM_ID_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ITEM_ID_FROM" class="GOOD_GF_ITEM_ID_FROM"><?= $Page->renderSort($Page->ITEM_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_MODIFIED_DATE" class="GOOD_GF_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_GOOD_GF_MODIFIED_BY" class="GOOD_GF_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <th data-name="STOCK_OPNAME" class="<?= $Page->STOCK_OPNAME->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_OPNAME" class="GOOD_GF_STOCK_OPNAME"><?= $Page->renderSort($Page->STOCK_OPNAME) ?></div></th>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <th data-name="STOK_AWAL" class="<?= $Page->STOK_AWAL->headerCellClass() ?>"><div id="elh_GOOD_GF_STOK_AWAL" class="GOOD_GF_STOK_AWAL"><?= $Page->renderSort($Page->STOK_AWAL) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <th data-name="STOCK_KOREKSI" class="<?= $Page->STOCK_KOREKSI->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_KOREKSI" class="GOOD_GF_STOCK_KOREKSI"><?= $Page->renderSort($Page->STOCK_KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME"><?= $Page->renderSort($Page->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <th data-name="MONTH_ID" class="<?= $Page->MONTH_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MONTH_ID" class="GOOD_GF_MONTH_ID"><?= $Page->renderSort($Page->MONTH_ID) ?></div></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th data-name="YEAR_ID" class="<?= $Page->YEAR_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_YEAR_ID" class="GOOD_GF_YEAR_ID"><?= $Page->renderSort($Page->YEAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <th data-name="DOC_NO" class="<?= $Page->DOC_NO->headerCellClass() ?>"><div id="elh_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO"><?= $Page->renderSort($Page->DOC_NO) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <th data-name="ORDER_ID" class="<?= $Page->ORDER_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORDER_ID" class="GOOD_GF_ORDER_ID"><?= $Page->renderSort($Page->ORDER_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Page->ISCETAK->headerCellClass() ?>"><div id="elh_GOOD_GF_ISCETAK" class="GOOD_GF_ISCETAK"><?= $Page->renderSort($Page->ISCETAK) ?></div></th>
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

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
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
$Page->EditRowCount = 0;
if ($Page->isEdit())
    $Page->RowIndex = 1;
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
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_GOOD_GF", "data-rowtype" => $Page->RowType]);

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
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_UNIT_CODE" class="form-group">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Page->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->ORG_ID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ORG_ID->getDisplayValue($Page->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_ORG_ID" name="x<?= $Page->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Page->ORG_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<input type="<?= $Page->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Page->RowIndex ?>_ORG_ID" id="x<?= $Page->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_ID->getPlaceHolder()) ?>" value="<?= $Page->ORG_ID->EditValue ?>"<?= $Page->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<?php $Page->BRAND_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Page->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Page->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->BRAND_ID->ReadOnly || $Page->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Page->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
<?= $Page->BRAND_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_BRAND_ID" id="x<?= $Page->RowIndex ?>_BRAND_ID" value="<?= $Page->BRAND_ID->CurrentValue ?>"<?= $Page->BRAND_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID" <?= $Page->ROOMS_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ROOMS_ID->getDisplayValue($Page->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_ROOMS_ID" name="x<?= $Page->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Page->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Page->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Page->RowIndex ?>_ROOMS_ID" id="x<?= $Page->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Page->ROOMS_ID->EditValue ?>"<?= $Page->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<?= $Page->ROOMS_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td data-name="FROM_ROOMS_ID" <?= $Page->FROM_ROOMS_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->FROM_ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->FROM_ROOMS_ID->getDisplayValue($Page->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_FROM_ROOMS_ID" name="x<?= $Page->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<input type="<?= $Page->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Page->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Page->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Page->FROM_ROOMS_ID->EditValue ?>"<?= $Page->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_FROM_ROOMS_ID">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Page->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET" <?= $Page->ISOUTLET->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISOUTLET" class="form-group">
<input type="<?= $Page->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Page->RowIndex ?>_ISOUTLET" id="x<?= $Page->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Page->ISOUTLET->EditValue ?>"<?= $Page->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISOUTLET->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISOUTLET">
<span<?= $Page->ISOUTLET->viewAttributes() ?>>
<?= $Page->ISOUTLET->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_QUANTITY" class="form-group">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Page->RowIndex ?>_QUANTITY" id="x<?= $Page->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MEASURE_ID" class="form-group">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Page->RowIndex ?>_MEASURE_ID" id="x<?= $Page->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE" <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE" class="form-group">
<input type="<?= $Page->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Page->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Page->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Page->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Page->DISTRIBUTION_TYPE->EditValue ?>"<?= $Page->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Page->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Page->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->CONDITION->Visible) { // CONDITION ?>
        <td data-name="CONDITION" <?= $Page->CONDITION->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_CONDITION" class="form-group">
<input type="<?= $Page->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Page->RowIndex ?>_CONDITION" id="x<?= $Page->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Page->CONDITION->getPlaceHolder()) ?>" value="<?= $Page->CONDITION->EditValue ?>"<?= $Page->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CONDITION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_CONDITION">
<span<?= $Page->CONDITION->viewAttributes() ?>>
<?= $Page->CONDITION->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td data-name="ALLOCATED_DATE" <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="form-group">
<input type="<?= $Page->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Page->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Page->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Page->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Page->ALLOCATED_DATE->EditValue ?>"<?= $Page->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ALLOCATED_DATE->ReadOnly && !$Page->ALLOCATED_DATE->Disabled && !isset($Page->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Page->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFlist", "x<?= $Page->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ALLOCATED_DATE">
<span<?= $Page->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Page->ALLOCATED_DATE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td data-name="STOCKOPNAME_DATE" <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE" class="form-group">
<input type="<?= $Page->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Page->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Page->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Page->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Page->STOCKOPNAME_DATE->EditValue ?>"<?= $Page->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Page->STOCKOPNAME_DATE->ReadOnly && !$Page->STOCKOPNAME_DATE->Disabled && !isset($Page->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Page->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFlist", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFlist", "x<?= $Page->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Page->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Page->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td data-name="ORG_UNIT_FROM" <?= $Page->ORG_UNIT_FROM->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_UNIT_FROM" class="form-group">
<input type="<?= $Page->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Page->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Page->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_FROM->EditValue ?>"<?= $Page->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORG_UNIT_FROM">
<span<?= $Page->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Page->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td data-name="ITEM_ID_FROM" <?= $Page->ITEM_ID_FROM->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ITEM_ID_FROM" class="form-group">
<input type="<?= $Page->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Page->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Page->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->ITEM_ID_FROM->EditValue ?>"<?= $Page->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ITEM_ID_FROM">
<span<?= $Page->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Page->ITEM_ID_FROM->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td data-name="STOCK_OPNAME" <?= $Page->STOCK_OPNAME->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCK_OPNAME" class="form-group">
<input type="<?= $Page->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Page->RowIndex ?>_STOCK_OPNAME" id="x<?= $Page->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Page->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Page->STOCK_OPNAME->EditValue ?>"<?= $Page->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCK_OPNAME">
<span<?= $Page->STOCK_OPNAME->viewAttributes() ?>>
<?= $Page->STOCK_OPNAME->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td data-name="STOK_AWAL" <?= $Page->STOK_AWAL->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOK_AWAL" class="form-group">
<input type="<?= $Page->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Page->RowIndex ?>_STOK_AWAL" id="x<?= $Page->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Page->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Page->STOK_AWAL->EditValue ?>"<?= $Page->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STOK_AWAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOK_AWAL">
<span<?= $Page->STOK_AWAL->viewAttributes() ?>>
<?= $Page->STOK_AWAL->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td data-name="STOCK_KOREKSI" <?= $Page->STOCK_KOREKSI->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCK_KOREKSI" class="form-group">
<input type="<?= $Page->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Page->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Page->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Page->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Page->STOCK_KOREKSI->EditValue ?>"<?= $Page->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_STOCK_KOREKSI">
<span<?= $Page->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Page->STOCK_KOREKSI->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME" <?= $Page->BRAND_NAME->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_NAME" class="form-group">
<input type="<?= $Page->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Page->RowIndex ?>_BRAND_NAME" id="x<?= $Page->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Page->BRAND_NAME->EditValue ?>"<?= $Page->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->BRAND_NAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID" <?= $Page->MONTH_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MONTH_ID" class="form-group">
<input type="<?= $Page->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Page->RowIndex ?>_MONTH_ID" id="x<?= $Page->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Page->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Page->MONTH_ID->EditValue ?>"<?= $Page->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->MONTH_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_YEAR_ID" class="form-group">
<input type="<?= $Page->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Page->RowIndex ?>_YEAR_ID" id="x<?= $Page->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Page->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Page->YEAR_ID->EditValue ?>"<?= $Page->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->YEAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
        <td data-name="DOC_NO" <?= $Page->DOC_NO->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->DOC_NO->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DOC_NO->getDisplayValue($Page->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_DOC_NO" name="x<?= $Page->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<input type="<?= $Page->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Page->RowIndex ?>_DOC_NO" id="x<?= $Page->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DOC_NO->getPlaceHolder()) ?>" value="<?= $Page->DOC_NO->EditValue ?>"<?= $Page->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<?= $Page->DOC_NO->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
        <td data-name="ORDER_ID" <?= $Page->ORDER_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORDER_ID" class="form-group">
<input type="<?= $Page->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Page->RowIndex ?>_ORDER_ID" id="x<?= $Page->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Page->ORDER_ID->EditValue ?>"<?= $Page->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORDER_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ORDER_ID">
<span<?= $Page->ORDER_ID->viewAttributes() ?>>
<?= $Page->ORDER_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISCETAK" class="form-group">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Page->RowIndex ?>_ISCETAK" id="x<?= $Page->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_GOOD_GF_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fGOOD_GFlist","load"], function () {
    fGOOD_GFlist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
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
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
