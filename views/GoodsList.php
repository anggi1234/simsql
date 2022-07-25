<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOODSlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fGOODSlist = currentForm = new ew.Form("fGOODSlist", "list");
    fGOODSlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fGOODSlist");
});
var fGOODSlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fGOODSlistsrch = currentSearchForm = new ew.Form("fGOODSlistsrch");

    // Dynamic selection lists

    // Filters
    fGOODSlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fGOODSlistsrch");
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
<form name="fGOODSlistsrch" id="fGOODSlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fGOODSlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="GOODS">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> GOODS">
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
<form name="fGOODSlist" id="fGOODSlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS">
<div id="gmp_GOODS" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_GOODSlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->CODE_5->Visible) { // CODE_5 ?>
        <th data-name="CODE_5" class="<?= $Page->CODE_5->headerCellClass() ?>"><div id="elh_GOODS_CODE_5" class="GOODS_CODE_5"><?= $Page->renderSort($Page->CODE_5) ?></div></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Page->BRAND_ID->headerCellClass() ?>"><div id="elh_GOODS_BRAND_ID" class="GOODS_BRAND_ID"><?= $Page->renderSort($Page->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NAME->Visible) { // NAME ?>
        <th data-name="NAME" class="<?= $Page->NAME->headerCellClass() ?>"><div id="elh_GOODS_NAME" class="GOODS_NAME"><?= $Page->renderSort($Page->NAME) ?></div></th>
<?php } ?>
<?php if ($Page->OTHER_CODE->Visible) { // OTHER_CODE ?>
        <th data-name="OTHER_CODE" class="<?= $Page->OTHER_CODE->headerCellClass() ?>"><div id="elh_GOODS_OTHER_CODE" class="GOODS_OTHER_CODE"><?= $Page->renderSort($Page->OTHER_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->_BARCODE->Visible) { // BARCODE ?>
        <th data-name="_BARCODE" class="<?= $Page->_BARCODE->headerCellClass() ?>"><div id="elh_GOODS__BARCODE" class="GOODS__BARCODE"><?= $Page->renderSort($Page->_BARCODE) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_GOODS_DESCRIPTION" class="GOODS_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->REORDER_POINT->Visible) { // REORDER_POINT ?>
        <th data-name="REORDER_POINT" class="<?= $Page->REORDER_POINT->headerCellClass() ?>"><div id="elh_GOODS_REORDER_POINT" class="GOODS_REORDER_POINT"><?= $Page->renderSort($Page->REORDER_POINT) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th data-name="SIZE_GOODS" class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><div id="elh_GOODS_SIZE_GOODS" class="GOODS_SIZE_GOODS"><?= $Page->renderSort($Page->SIZE_GOODS) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th data-name="MEASURE_DOSIS" class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><div id="elh_GOODS_MEASURE_DOSIS" class="GOODS_MEASURE_DOSIS"><?= $Page->renderSort($Page->MEASURE_DOSIS) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><div id="elh_GOODS_MEASURE_ID" class="GOODS_MEASURE_ID"><?= $Page->renderSort($Page->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th data-name="MEASURE_ID2" class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><div id="elh_GOODS_MEASURE_ID2" class="GOODS_MEASURE_ID2"><?= $Page->renderSort($Page->MEASURE_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th data-name="SIZE_KEMASAN" class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><div id="elh_GOODS_SIZE_KEMASAN" class="GOODS_SIZE_KEMASAN"><?= $Page->renderSort($Page->SIZE_KEMASAN) ?></div></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th data-name="MEASURE_ID3" class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><div id="elh_GOODS_MEASURE_ID3" class="GOODS_MEASURE_ID3"><?= $Page->renderSort($Page->MEASURE_ID3) ?></div></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th data-name="COMPANY_ID" class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><div id="elh_GOODS_COMPANY_ID" class="GOODS_COMPANY_ID"><?= $Page->renderSort($Page->COMPANY_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NET_PRICE->Visible) { // NET_PRICE ?>
        <th data-name="NET_PRICE" class="<?= $Page->NET_PRICE->headerCellClass() ?>"><div id="elh_GOODS_NET_PRICE" class="GOODS_NET_PRICE"><?= $Page->renderSort($Page->NET_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_GOODS_MODIFIED_DATE" class="GOODS_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_GOODS_MODIFIED_BY" class="GOODS_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->TH->Visible) { // TH ?>
        <th data-name="TH" class="<?= $Page->TH->headerCellClass() ?>"><div id="elh_GOODS_TH" class="GOODS_TH"><?= $Page->renderSort($Page->TH) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_GOODS_STATUS_PASIEN_ID" class="GOODS_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->MATERIAL_ID->Visible) { // MATERIAL_ID ?>
        <th data-name="MATERIAL_ID" class="<?= $Page->MATERIAL_ID->headerCellClass() ?>"><div id="elh_GOODS_MATERIAL_ID" class="GOODS_MATERIAL_ID"><?= $Page->renderSort($Page->MATERIAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
        <th data-name="FORM_ID" class="<?= $Page->FORM_ID->headerCellClass() ?>"><div id="elh_GOODS_FORM_ID" class="GOODS_FORM_ID"><?= $Page->renderSort($Page->FORM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISGENERIC->Visible) { // ISGENERIC ?>
        <th data-name="ISGENERIC" class="<?= $Page->ISGENERIC->headerCellClass() ?>"><div id="elh_GOODS_ISGENERIC" class="GOODS_ISGENERIC"><?= $Page->renderSort($Page->ISGENERIC) ?></div></th>
<?php } ?>
<?php if ($Page->REGULATE_ID->Visible) { // REGULATE_ID ?>
        <th data-name="REGULATE_ID" class="<?= $Page->REGULATE_ID->headerCellClass() ?>"><div id="elh_GOODS_REGULATE_ID" class="GOODS_REGULATE_ID"><?= $Page->renderSort($Page->REGULATE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PREGNANCY_INDEX->Visible) { // PREGNANCY_INDEX ?>
        <th data-name="PREGNANCY_INDEX" class="<?= $Page->PREGNANCY_INDEX->headerCellClass() ?>"><div id="elh_GOODS_PREGNANCY_INDEX" class="GOODS_PREGNANCY_INDEX"><?= $Page->renderSort($Page->PREGNANCY_INDEX) ?></div></th>
<?php } ?>
<?php if ($Page->INDICATION->Visible) { // INDICATION ?>
        <th data-name="INDICATION" class="<?= $Page->INDICATION->headerCellClass() ?>"><div id="elh_GOODS_INDICATION" class="GOODS_INDICATION"><?= $Page->renderSort($Page->INDICATION) ?></div></th>
<?php } ?>
<?php if ($Page->TAKE_RULE->Visible) { // TAKE_RULE ?>
        <th data-name="TAKE_RULE" class="<?= $Page->TAKE_RULE->headerCellClass() ?>"><div id="elh_GOODS_TAKE_RULE" class="GOODS_TAKE_RULE"><?= $Page->renderSort($Page->TAKE_RULE) ?></div></th>
<?php } ?>
<?php if ($Page->SIDE_EFFECT->Visible) { // SIDE_EFFECT ?>
        <th data-name="SIDE_EFFECT" class="<?= $Page->SIDE_EFFECT->headerCellClass() ?>"><div id="elh_GOODS_SIDE_EFFECT" class="GOODS_SIDE_EFFECT"><?= $Page->renderSort($Page->SIDE_EFFECT) ?></div></th>
<?php } ?>
<?php if ($Page->INTERACTION->Visible) { // INTERACTION ?>
        <th data-name="INTERACTION" class="<?= $Page->INTERACTION->headerCellClass() ?>"><div id="elh_GOODS_INTERACTION" class="GOODS_INTERACTION"><?= $Page->renderSort($Page->INTERACTION) ?></div></th>
<?php } ?>
<?php if ($Page->CONTRA_INDICATION->Visible) { // CONTRA_INDICATION ?>
        <th data-name="CONTRA_INDICATION" class="<?= $Page->CONTRA_INDICATION->headerCellClass() ?>"><div id="elh_GOODS_CONTRA_INDICATION" class="GOODS_CONTRA_INDICATION"><?= $Page->renderSort($Page->CONTRA_INDICATION) ?></div></th>
<?php } ?>
<?php if ($Page->WARNING->Visible) { // WARNING ?>
        <th data-name="WARNING" class="<?= $Page->WARNING->headerCellClass() ?>"><div id="elh_GOODS_WARNING" class="GOODS_WARNING"><?= $Page->renderSort($Page->WARNING) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK->Visible) { // STOCK ?>
        <th data-name="STOCK" class="<?= $Page->STOCK->headerCellClass() ?>"><div id="elh_GOODS_STOCK" class="GOODS_STOCK"><?= $Page->renderSort($Page->STOCK) ?></div></th>
<?php } ?>
<?php if ($Page->ISACTIVE->Visible) { // ISACTIVE ?>
        <th data-name="ISACTIVE" class="<?= $Page->ISACTIVE->headerCellClass() ?>"><div id="elh_GOODS_ISACTIVE" class="GOODS_ISACTIVE"><?= $Page->renderSort($Page->ISACTIVE) ?></div></th>
<?php } ?>
<?php if ($Page->ISALKES->Visible) { // ISALKES ?>
        <th data-name="ISALKES" class="<?= $Page->ISALKES->headerCellClass() ?>"><div id="elh_GOODS_ISALKES" class="GOODS_ISALKES"><?= $Page->renderSort($Page->ISALKES) ?></div></th>
<?php } ?>
<?php if ($Page->SIZE_ORDER->Visible) { // SIZE_ORDER ?>
        <th data-name="SIZE_ORDER" class="<?= $Page->SIZE_ORDER->headerCellClass() ?>"><div id="elh_GOODS_SIZE_ORDER" class="GOODS_SIZE_ORDER"><?= $Page->renderSort($Page->SIZE_ORDER) ?></div></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th data-name="ORDER_PRICE" class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><div id="elh_GOODS_ORDER_PRICE" class="GOODS_ORDER_PRICE"><?= $Page->renderSort($Page->ORDER_PRICE) ?></div></th>
<?php } ?>
<?php if ($Page->ISFORMULARIUM->Visible) { // ISFORMULARIUM ?>
        <th data-name="ISFORMULARIUM" class="<?= $Page->ISFORMULARIUM->headerCellClass() ?>"><div id="elh_GOODS_ISFORMULARIUM" class="GOODS_ISFORMULARIUM"><?= $Page->renderSort($Page->ISFORMULARIUM) ?></div></th>
<?php } ?>
<?php if ($Page->ISESSENTIAL->Visible) { // ISESSENTIAL ?>
        <th data-name="ISESSENTIAL" class="<?= $Page->ISESSENTIAL->headerCellClass() ?>"><div id="elh_GOODS_ISESSENTIAL" class="GOODS_ISESSENTIAL"><?= $Page->renderSort($Page->ISESSENTIAL) ?></div></th>
<?php } ?>
<?php if ($Page->AVGDATE->Visible) { // AVGDATE ?>
        <th data-name="AVGDATE" class="<?= $Page->AVGDATE->headerCellClass() ?>"><div id="elh_GOODS_AVGDATE" class="GOODS_AVGDATE"><?= $Page->renderSort($Page->AVGDATE) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL->Visible) { // STOCK_MINIMAL ?>
        <th data-name="STOCK_MINIMAL" class="<?= $Page->STOCK_MINIMAL->headerCellClass() ?>"><div id="elh_GOODS_STOCK_MINIMAL" class="GOODS_STOCK_MINIMAL"><?= $Page->renderSort($Page->STOCK_MINIMAL) ?></div></th>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL_APT->Visible) { // STOCK_MINIMAL_APT ?>
        <th data-name="STOCK_MINIMAL_APT" class="<?= $Page->STOCK_MINIMAL_APT->headerCellClass() ?>"><div id="elh_GOODS_STOCK_MINIMAL_APT" class="GOODS_STOCK_MINIMAL_APT"><?= $Page->renderSort($Page->STOCK_MINIMAL_APT) ?></div></th>
<?php } ?>
<?php if ($Page->HET->Visible) { // HET ?>
        <th data-name="HET" class="<?= $Page->HET->headerCellClass() ?>"><div id="elh_GOODS_HET" class="GOODS_HET"><?= $Page->renderSort($Page->HET) ?></div></th>
<?php } ?>
<?php if ($Page->default_margin->Visible) { // default_margin ?>
        <th data-name="default_margin" class="<?= $Page->default_margin->headerCellClass() ?>"><div id="elh_GOODS_default_margin" class="GOODS_default_margin"><?= $Page->renderSort($Page->default_margin) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_GOODS", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->CODE_5->Visible) { // CODE_5 ?>
        <td data-name="CODE_5" <?= $Page->CODE_5->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_CODE_5">
<span<?= $Page->CODE_5->viewAttributes() ?>>
<?= $Page->CODE_5->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NAME->Visible) { // NAME ?>
        <td data-name="NAME" <?= $Page->NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_NAME">
<span<?= $Page->NAME->viewAttributes() ?>>
<?= $Page->NAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->OTHER_CODE->Visible) { // OTHER_CODE ?>
        <td data-name="OTHER_CODE" <?= $Page->OTHER_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_OTHER_CODE">
<span<?= $Page->OTHER_CODE->viewAttributes() ?>>
<?= $Page->OTHER_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_BARCODE->Visible) { // BARCODE ?>
        <td data-name="_BARCODE" <?= $Page->_BARCODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS__BARCODE">
<span<?= $Page->_BARCODE->viewAttributes() ?>>
<?= $Page->_BARCODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REORDER_POINT->Visible) { // REORDER_POINT ?>
        <td data-name="REORDER_POINT" <?= $Page->REORDER_POINT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_REORDER_POINT">
<span<?= $Page->REORDER_POINT->viewAttributes() ?>>
<?= $Page->REORDER_POINT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NET_PRICE->Visible) { // NET_PRICE ?>
        <td data-name="NET_PRICE" <?= $Page->NET_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_NET_PRICE">
<span<?= $Page->NET_PRICE->viewAttributes() ?>>
<?= $Page->NET_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TH->Visible) { // TH ?>
        <td data-name="TH" <?= $Page->TH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_TH">
<span<?= $Page->TH->viewAttributes() ?>>
<?= $Page->TH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MATERIAL_ID->Visible) { // MATERIAL_ID ?>
        <td data-name="MATERIAL_ID" <?= $Page->MATERIAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MATERIAL_ID">
<span<?= $Page->MATERIAL_ID->viewAttributes() ?>>
<?= $Page->MATERIAL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
        <td data-name="FORM_ID" <?= $Page->FORM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_FORM_ID">
<span<?= $Page->FORM_ID->viewAttributes() ?>>
<?= $Page->FORM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISGENERIC->Visible) { // ISGENERIC ?>
        <td data-name="ISGENERIC" <?= $Page->ISGENERIC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISGENERIC">
<span<?= $Page->ISGENERIC->viewAttributes() ?>>
<?= $Page->ISGENERIC->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->REGULATE_ID->Visible) { // REGULATE_ID ?>
        <td data-name="REGULATE_ID" <?= $Page->REGULATE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_REGULATE_ID">
<span<?= $Page->REGULATE_ID->viewAttributes() ?>>
<?= $Page->REGULATE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PREGNANCY_INDEX->Visible) { // PREGNANCY_INDEX ?>
        <td data-name="PREGNANCY_INDEX" <?= $Page->PREGNANCY_INDEX->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_PREGNANCY_INDEX">
<span<?= $Page->PREGNANCY_INDEX->viewAttributes() ?>>
<?= $Page->PREGNANCY_INDEX->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INDICATION->Visible) { // INDICATION ?>
        <td data-name="INDICATION" <?= $Page->INDICATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_INDICATION">
<span<?= $Page->INDICATION->viewAttributes() ?>>
<?= $Page->INDICATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAKE_RULE->Visible) { // TAKE_RULE ?>
        <td data-name="TAKE_RULE" <?= $Page->TAKE_RULE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_TAKE_RULE">
<span<?= $Page->TAKE_RULE->viewAttributes() ?>>
<?= $Page->TAKE_RULE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIDE_EFFECT->Visible) { // SIDE_EFFECT ?>
        <td data-name="SIDE_EFFECT" <?= $Page->SIDE_EFFECT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIDE_EFFECT">
<span<?= $Page->SIDE_EFFECT->viewAttributes() ?>>
<?= $Page->SIDE_EFFECT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INTERACTION->Visible) { // INTERACTION ?>
        <td data-name="INTERACTION" <?= $Page->INTERACTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_INTERACTION">
<span<?= $Page->INTERACTION->viewAttributes() ?>>
<?= $Page->INTERACTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONTRA_INDICATION->Visible) { // CONTRA_INDICATION ?>
        <td data-name="CONTRA_INDICATION" <?= $Page->CONTRA_INDICATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_CONTRA_INDICATION">
<span<?= $Page->CONTRA_INDICATION->viewAttributes() ?>>
<?= $Page->CONTRA_INDICATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->WARNING->Visible) { // WARNING ?>
        <td data-name="WARNING" <?= $Page->WARNING->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_WARNING">
<span<?= $Page->WARNING->viewAttributes() ?>>
<?= $Page->WARNING->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK->Visible) { // STOCK ?>
        <td data-name="STOCK" <?= $Page->STOCK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STOCK">
<span<?= $Page->STOCK->viewAttributes() ?>>
<?= $Page->STOCK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISACTIVE->Visible) { // ISACTIVE ?>
        <td data-name="ISACTIVE" <?= $Page->ISACTIVE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISACTIVE">
<span<?= $Page->ISACTIVE->viewAttributes() ?>>
<?= $Page->ISACTIVE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISALKES->Visible) { // ISALKES ?>
        <td data-name="ISALKES" <?= $Page->ISALKES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISALKES">
<span<?= $Page->ISALKES->viewAttributes() ?>>
<?= $Page->ISALKES->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->SIZE_ORDER->Visible) { // SIZE_ORDER ?>
        <td data-name="SIZE_ORDER" <?= $Page->SIZE_ORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIZE_ORDER">
<span<?= $Page->SIZE_ORDER->viewAttributes() ?>>
<?= $Page->SIZE_ORDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISFORMULARIUM->Visible) { // ISFORMULARIUM ?>
        <td data-name="ISFORMULARIUM" <?= $Page->ISFORMULARIUM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISFORMULARIUM">
<span<?= $Page->ISFORMULARIUM->viewAttributes() ?>>
<?= $Page->ISFORMULARIUM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISESSENTIAL->Visible) { // ISESSENTIAL ?>
        <td data-name="ISESSENTIAL" <?= $Page->ISESSENTIAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISESSENTIAL">
<span<?= $Page->ISESSENTIAL->viewAttributes() ?>>
<?= $Page->ISESSENTIAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AVGDATE->Visible) { // AVGDATE ?>
        <td data-name="AVGDATE" <?= $Page->AVGDATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_AVGDATE">
<span<?= $Page->AVGDATE->viewAttributes() ?>>
<?= $Page->AVGDATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_MINIMAL->Visible) { // STOCK_MINIMAL ?>
        <td data-name="STOCK_MINIMAL" <?= $Page->STOCK_MINIMAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STOCK_MINIMAL">
<span<?= $Page->STOCK_MINIMAL->viewAttributes() ?>>
<?= $Page->STOCK_MINIMAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STOCK_MINIMAL_APT->Visible) { // STOCK_MINIMAL_APT ?>
        <td data-name="STOCK_MINIMAL_APT" <?= $Page->STOCK_MINIMAL_APT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STOCK_MINIMAL_APT">
<span<?= $Page->STOCK_MINIMAL_APT->viewAttributes() ?>>
<?= $Page->STOCK_MINIMAL_APT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HET->Visible) { // HET ?>
        <td data-name="HET" <?= $Page->HET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_HET">
<span<?= $Page->HET->viewAttributes() ?>>
<?= $Page->HET->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->default_margin->Visible) { // default_margin ?>
        <td data-name="default_margin" <?= $Page->default_margin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_default_margin">
<span<?= $Page->default_margin->viewAttributes() ?>>
<?= $Page->default_margin->getViewValue() ?></span>
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
    ew.addEventHandlers("GOODS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
