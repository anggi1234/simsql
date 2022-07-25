<?php

namespace PHPMaker2021\simrs;

// Page object
$AuditTrailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fAuditTraillist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fAuditTraillist = currentForm = new ew.Form("fAuditTraillist", "list");
    fAuditTraillist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fAuditTraillist");
});
var fAuditTraillistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fAuditTraillistsrch = currentSearchForm = new ew.Form("fAuditTraillistsrch");

    // Dynamic selection lists

    // Filters
    fAuditTraillistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fAuditTraillistsrch");
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
<form name="fAuditTraillistsrch" id="fAuditTraillistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fAuditTraillistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="AuditTrail">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> AuditTrail">
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
<form name="fAuditTraillist" id="fAuditTraillist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="AuditTrail">
<div id="gmp_AuditTrail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_AuditTraillist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->Id->Visible) { // Id ?>
        <th data-name="Id" class="<?= $Page->Id->headerCellClass() ?>"><div id="elh_AuditTrail_Id" class="AuditTrail_Id"><?= $Page->renderSort($Page->Id) ?></div></th>
<?php } ?>
<?php if ($Page->DateTime->Visible) { // DateTime ?>
        <th data-name="DateTime" class="<?= $Page->DateTime->headerCellClass() ?>"><div id="elh_AuditTrail_DateTime" class="AuditTrail_DateTime"><?= $Page->renderSort($Page->DateTime) ?></div></th>
<?php } ?>
<?php if ($Page->Script->Visible) { // Script ?>
        <th data-name="Script" class="<?= $Page->Script->headerCellClass() ?>"><div id="elh_AuditTrail_Script" class="AuditTrail_Script"><?= $Page->renderSort($Page->Script) ?></div></th>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
        <th data-name="User" class="<?= $Page->User->headerCellClass() ?>"><div id="elh_AuditTrail_User" class="AuditTrail_User"><?= $Page->renderSort($Page->User) ?></div></th>
<?php } ?>
<?php if ($Page->_Action->Visible) { // Action ?>
        <th data-name="_Action" class="<?= $Page->_Action->headerCellClass() ?>"><div id="elh_AuditTrail__Action" class="AuditTrail__Action"><?= $Page->renderSort($Page->_Action) ?></div></th>
<?php } ?>
<?php if ($Page->_Table->Visible) { // Table ?>
        <th data-name="_Table" class="<?= $Page->_Table->headerCellClass() ?>"><div id="elh_AuditTrail__Table" class="AuditTrail__Table"><?= $Page->renderSort($Page->_Table) ?></div></th>
<?php } ?>
<?php if ($Page->Field->Visible) { // Field ?>
        <th data-name="Field" class="<?= $Page->Field->headerCellClass() ?>"><div id="elh_AuditTrail_Field" class="AuditTrail_Field"><?= $Page->renderSort($Page->Field) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_AuditTrail", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->Id->Visible) { // Id ?>
        <td data-name="Id" <?= $Page->Id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_Id">
<span<?= $Page->Id->viewAttributes() ?>>
<?= $Page->Id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DateTime->Visible) { // DateTime ?>
        <td data-name="DateTime" <?= $Page->DateTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_DateTime">
<span<?= $Page->DateTime->viewAttributes() ?>>
<?= $Page->DateTime->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Script->Visible) { // Script ?>
        <td data-name="Script" <?= $Page->Script->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_Script">
<span<?= $Page->Script->viewAttributes() ?>>
<?= $Page->Script->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->User->Visible) { // User ?>
        <td data-name="User" <?= $Page->User->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_User">
<span<?= $Page->User->viewAttributes() ?>>
<?= $Page->User->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Action->Visible) { // Action ?>
        <td data-name="_Action" <?= $Page->_Action->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail__Action">
<span<?= $Page->_Action->viewAttributes() ?>>
<?= $Page->_Action->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Table->Visible) { // Table ?>
        <td data-name="_Table" <?= $Page->_Table->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail__Table">
<span<?= $Page->_Table->viewAttributes() ?>>
<?= $Page->_Table->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Field->Visible) { // Field ?>
        <td data-name="Field" <?= $Page->Field->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_AuditTrail_Field">
<span<?= $Page->Field->viewAttributes() ?>>
<?= $Page->Field->getViewValue() ?></span>
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
    ew.addEventHandlers("AuditTrail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
