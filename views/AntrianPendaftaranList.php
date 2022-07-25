<?php

namespace PHPMaker2021\simrs;

// Page object
$AntrianPendaftaranList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fANTRIAN_PENDAFTARANlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fANTRIAN_PENDAFTARANlist = currentForm = new ew.Form("fANTRIAN_PENDAFTARANlist", "list");
    fANTRIAN_PENDAFTARANlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fANTRIAN_PENDAFTARANlist");
});
var fANTRIAN_PENDAFTARANlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fANTRIAN_PENDAFTARANlistsrch = currentSearchForm = new ew.Form("fANTRIAN_PENDAFTARANlistsrch");

    // Dynamic selection lists

    // Filters
    fANTRIAN_PENDAFTARANlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fANTRIAN_PENDAFTARANlistsrch");
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
<form name="fANTRIAN_PENDAFTARANlistsrch" id="fANTRIAN_PENDAFTARANlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fANTRIAN_PENDAFTARANlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ANTRIAN_PENDAFTARAN">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> ANTRIAN_PENDAFTARAN">
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
<form name="fANTRIAN_PENDAFTARANlist" id="fANTRIAN_PENDAFTARANlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_PENDAFTARAN">
<div id="gmp_ANTRIAN_PENDAFTARAN" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_ANTRIAN_PENDAFTARANlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->no_urut->Visible) { // no_urut ?>
        <th data-name="no_urut" class="<?= $Page->no_urut->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_no_urut" class="ANTRIAN_PENDAFTARAN_no_urut"><?= $Page->renderSort($Page->no_urut) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <th data-name="tanggal_daftar" class="<?= $Page->tanggal_daftar->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_tanggal_daftar" class="ANTRIAN_PENDAFTARAN_tanggal_daftar"><?= $Page->renderSort($Page->tanggal_daftar) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
        <th data-name="tanggal_panggil" class="<?= $Page->tanggal_panggil->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_tanggal_panggil" class="ANTRIAN_PENDAFTARAN_tanggal_panggil"><?= $Page->renderSort($Page->tanggal_panggil) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_nama" class="ANTRIAN_PENDAFTARAN_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->no_bpjs->Visible) { // no_bpjs ?>
        <th data-name="no_bpjs" class="<?= $Page->no_bpjs->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_no_bpjs" class="ANTRIAN_PENDAFTARAN_no_bpjs"><?= $Page->renderSort($Page->no_bpjs) ?></div></th>
<?php } ?>
<?php if ($Page->nomr->Visible) { // nomr ?>
        <th data-name="nomr" class="<?= $Page->nomr->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_nomr" class="ANTRIAN_PENDAFTARAN_nomr"><?= $Page->renderSort($Page->nomr) ?></div></th>
<?php } ?>
<?php if ($Page->jk->Visible) { // jk ?>
        <th data-name="jk" class="<?= $Page->jk->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_jk" class="ANTRIAN_PENDAFTARAN_jk"><?= $Page->renderSort($Page->jk) ?></div></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Page->alamat->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_ANTRIAN_PENDAFTARAN_alamat" class="ANTRIAN_PENDAFTARAN_alamat"><?= $Page->renderSort($Page->alamat) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_ANTRIAN_PENDAFTARAN", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->no_urut->Visible) { // no_urut ?>
        <td data-name="no_urut" <?= $Page->no_urut->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_no_urut">
<span<?= $Page->no_urut->viewAttributes() ?>>
<?= $Page->no_urut->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
        <td data-name="tanggal_daftar" <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_tanggal_daftar">
<span<?= $Page->tanggal_daftar->viewAttributes() ?>>
<?= $Page->tanggal_daftar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
        <td data-name="tanggal_panggil" <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_tanggal_panggil">
<span<?= $Page->tanggal_panggil->viewAttributes() ?>>
<?= $Page->tanggal_panggil->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_bpjs->Visible) { // no_bpjs ?>
        <td data-name="no_bpjs" <?= $Page->no_bpjs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_no_bpjs">
<span<?= $Page->no_bpjs->viewAttributes() ?>>
<?= $Page->no_bpjs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nomr->Visible) { // nomr ?>
        <td data-name="nomr" <?= $Page->nomr->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_nomr">
<span<?= $Page->nomr->viewAttributes() ?>>
<?= $Page->nomr->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jk->Visible) { // jk ?>
        <td data-name="jk" <?= $Page->jk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_jk">
<span<?= $Page->jk->viewAttributes() ?>>
<?= $Page->jk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ANTRIAN_PENDAFTARAN_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
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
    ew.addEventHandlers("ANTRIAN_PENDAFTARAN");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
