<?php

namespace PHPMaker2021\simrs;

// Page object
$VAkomodasiKamarList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_AKOMODASI_KAMARlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fV_AKOMODASI_KAMARlist = currentForm = new ew.Form("fV_AKOMODASI_KAMARlist", "list");
    fV_AKOMODASI_KAMARlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fV_AKOMODASI_KAMARlist");
});
var fV_AKOMODASI_KAMARlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fV_AKOMODASI_KAMARlistsrch = currentSearchForm = new ew.Form("fV_AKOMODASI_KAMARlistsrch");

    // Dynamic selection lists

    // Filters
    fV_AKOMODASI_KAMARlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fV_AKOMODASI_KAMARlistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "V_KUNJUNGAN_PASIEN") {
    if ($Page->MasterRecordExists) {
        include_once "views/VKunjunganPasienMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fV_AKOMODASI_KAMARlistsrch" id="fV_AKOMODASI_KAMARlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fV_AKOMODASI_KAMARlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="V_AKOMODASI_KAMAR">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_AKOMODASI_KAMAR">
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
<form name="fV_AKOMODASI_KAMARlist" id="fV_AKOMODASI_KAMARlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_AKOMODASI_KAMAR">
<?php if ($Page->getCurrentMasterTable() == "V_KUNJUNGAN_PASIEN" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="V_KUNJUNGAN_PASIEN">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<input type="hidden" name="fk_DIANTAR_OLEH" value="<?= HtmlEncode($Page->THENAME->getSessionValue()) ?>">
<input type="hidden" name="fk_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_V_AKOMODASI_KAMAR" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_V_AKOMODASI_KAMARlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_VISIT_ID" class="V_AKOMODASI_KAMAR_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="V_AKOMODASI_KAMAR_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Page->THENAME->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_THENAME" class="V_AKOMODASI_KAMAR_THENAME"><?= $Page->renderSort($Page->THENAME) ?></div></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Page->THEADDRESS->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_THEADDRESS" class="V_AKOMODASI_KAMAR_THEADDRESS"><?= $Page->renderSort($Page->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Page->THEID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_THEID" class="V_AKOMODASI_KAMAR_THEID"><?= $Page->renderSort($Page->THEID) ?></div></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Page->TARIF_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TARIF_ID" class="V_AKOMODASI_KAMAR_TARIF_ID"><?= $Page->renderSort($Page->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_CLINIC_ID" class="V_AKOMODASI_KAMAR_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Page->TREATMENT->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TREATMENT" class="V_AKOMODASI_KAMAR_TREATMENT"><?= $Page->renderSort($Page->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_TREAT_DATE" class="V_AKOMODASI_KAMAR_TREAT_DATE"><?= $Page->renderSort($Page->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th data-name="CLINIC_TYPE" class="<?= $Page->CLINIC_TYPE->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="V_AKOMODASI_KAMAR_CLINIC_TYPE"><?= $Page->renderSort($Page->CLINIC_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <th data-name="sell_price" class="<?= $Page->sell_price->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_sell_price" class="V_AKOMODASI_KAMAR_sell_price"><?= $Page->renderSort($Page->sell_price) ?></div></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Page->QUANTITY->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_QUANTITY" class="V_AKOMODASI_KAMAR_QUANTITY"><?= $Page->renderSort($Page->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Page->amount_paid->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_amount_paid" class="V_AKOMODASI_KAMAR_amount_paid"><?= $Page->renderSort($Page->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Page->AMOUNT->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_AMOUNT" class="V_AKOMODASI_KAMAR_AMOUNT"><?= $Page->renderSort($Page->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Page->NOTA_NO->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_NOTA_NO" class="V_AKOMODASI_KAMAR_NOTA_NO"><?= $Page->renderSort($Page->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Page->TAGIHAN->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TAGIHAN" class="V_AKOMODASI_KAMAR_TAGIHAN"><?= $Page->renderSort($Page->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Page->TRANS_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TRANS_ID" class="V_AKOMODASI_KAMAR_TRANS_ID"><?= $Page->renderSort($Page->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_EXIT_DATE" class="V_AKOMODASI_KAMAR_EXIT_DATE"><?= $Page->renderSort($Page->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_BED_ID" class="V_AKOMODASI_KAMAR_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_KELUAR_ID" class="V_AKOMODASI_KAMAR_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_V_AKOMODASI_KAMAR", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" <?= $Page->CLINIC_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_TYPE">
<span<?= $Page->CLINIC_TYPE->viewAttributes() ?>>
<?= $Page->CLINIC_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" <?= $Page->sell_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Page->EXIT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_EXIT_DATE">
<span<?= $Page->EXIT_DATE->viewAttributes() ?>>
<?= $Page->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_AKOMODASI_KAMAR_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
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
<?php
// Render aggregate row
$Page->RowType = ROWTYPE_AGGREGATE;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->TotalRecords > 0 && !$Page->isGridAdd() && !$Page->isGridEdit()) { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (footer, left)
$Page->ListOptions->render("footer", "left");
?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" class="<?= $Page->VISIT_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_VISIT_ID" class="V_AKOMODASI_KAMAR_VISIT_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="V_AKOMODASI_KAMAR_NO_REGISTRATION">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" class="<?= $Page->THENAME->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_THENAME" class="V_AKOMODASI_KAMAR_THENAME">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" class="<?= $Page->THEADDRESS->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_THEADDRESS" class="V_AKOMODASI_KAMAR_THEADDRESS">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->THEID->Visible) { // THEID ?>
        <td data-name="THEID" class="<?= $Page->THEID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_THEID" class="V_AKOMODASI_KAMAR_THEID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" class="<?= $Page->TARIF_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TARIF_ID" class="V_AKOMODASI_KAMAR_TARIF_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_CLINIC_ID" class="V_AKOMODASI_KAMAR_CLINIC_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" class="<?= $Page->TREATMENT->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TREATMENT" class="V_AKOMODASI_KAMAR_TREATMENT">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" class="<?= $Page->TREAT_DATE->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TREAT_DATE" class="V_AKOMODASI_KAMAR_TREAT_DATE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" class="<?= $Page->CLINIC_TYPE->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="V_AKOMODASI_KAMAR_CLINIC_TYPE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" class="<?= $Page->sell_price->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_sell_price" class="V_AKOMODASI_KAMAR_sell_price">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" class="<?= $Page->QUANTITY->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_QUANTITY" class="V_AKOMODASI_KAMAR_QUANTITY">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" class="<?= $Page->amount_paid->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_amount_paid" class="V_AKOMODASI_KAMAR_amount_paid">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Page->amount_paid->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" class="<?= $Page->AMOUNT->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_AMOUNT" class="V_AKOMODASI_KAMAR_AMOUNT">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" class="<?= $Page->NOTA_NO->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_NOTA_NO" class="V_AKOMODASI_KAMAR_NOTA_NO">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" class="<?= $Page->TAGIHAN->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TAGIHAN" class="V_AKOMODASI_KAMAR_TAGIHAN">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" class="<?= $Page->TRANS_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TRANS_ID" class="V_AKOMODASI_KAMAR_TRANS_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" class="<?= $Page->EXIT_DATE->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_EXIT_DATE" class="V_AKOMODASI_KAMAR_EXIT_DATE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" class="<?= $Page->BED_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_BED_ID" class="V_AKOMODASI_KAMAR_BED_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_KELUAR_ID" class="V_AKOMODASI_KAMAR_KELUAR_ID">
        &nbsp;
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Page->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
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
    ew.addEventHandlers("V_AKOMODASI_KAMAR");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
