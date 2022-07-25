<?php

namespace PHPMaker2021\simrs;

// Page object
$ObstetriList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fOBSTETRIlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fOBSTETRIlist = currentForm = new ew.Form("fOBSTETRIlist", "list");
    fOBSTETRIlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fOBSTETRIlist");
});
var fOBSTETRIlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fOBSTETRIlistsrch = currentSearchForm = new ew.Form("fOBSTETRIlistsrch");

    // Dynamic selection lists

    // Filters
    fOBSTETRIlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fOBSTETRIlistsrch");
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
<form name="fOBSTETRIlistsrch" id="fOBSTETRIlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fOBSTETRIlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="OBSTETRI">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> OBSTETRI">
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
<form name="fOBSTETRIlist" id="fOBSTETRIlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="OBSTETRI">
<div id="gmp_OBSTETRI" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_OBSTETRIlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <th data-name="OBSTETRI_ID" class="<?= $Page->OBSTETRI_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_OBSTETRI_ID" class="OBSTETRI_OBSTETRI_ID"><?= $Page->renderSort($Page->OBSTETRI_ID) ?></div></th>
<?php } ?>
<?php if ($Page->HPHT->Visible) { // HPHT ?>
        <th data-name="HPHT" class="<?= $Page->HPHT->headerCellClass() ?>"><div id="elh_OBSTETRI_HPHT" class="OBSTETRI_HPHT"><?= $Page->renderSort($Page->HPHT) ?></div></th>
<?php } ?>
<?php if ($Page->HTP->Visible) { // HTP ?>
        <th data-name="HTP" class="<?= $Page->HTP->headerCellClass() ?>"><div id="elh_OBSTETRI_HTP" class="OBSTETRI_HTP"><?= $Page->renderSort($Page->HTP) ?></div></th>
<?php } ?>
<?php if ($Page->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <th data-name="PASIEN_DIAGNOSA_ID" class="<?= $Page->PASIEN_DIAGNOSA_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_PASIEN_DIAGNOSA_ID" class="OBSTETRI_PASIEN_DIAGNOSA_ID"><?= $Page->renderSort($Page->PASIEN_DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <th data-name="DIAGNOSA_ID" class="<?= $Page->DIAGNOSA_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_DIAGNOSA_ID" class="OBSTETRI_DIAGNOSA_ID"><?= $Page->renderSort($Page->DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_OBSTETRI_NO_REGISTRATION" class="OBSTETRI_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <th data-name="KOHORT_NB" class="<?= $Page->KOHORT_NB->headerCellClass() ?>"><div id="elh_OBSTETRI_KOHORT_NB" class="OBSTETRI_KOHORT_NB"><?= $Page->renderSort($Page->KOHORT_NB) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <th data-name="BIRTH_NB" class="<?= $Page->BIRTH_NB->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_NB" class="OBSTETRI_BIRTH_NB"><?= $Page->renderSort($Page->BIRTH_NB) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <th data-name="BIRTH_DURATION" class="<?= $Page->BIRTH_DURATION->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_DURATION" class="OBSTETRI_BIRTH_DURATION"><?= $Page->renderSort($Page->BIRTH_DURATION) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <th data-name="BIRTH_PLACE" class="<?= $Page->BIRTH_PLACE->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_PLACE" class="OBSTETRI_BIRTH_PLACE"><?= $Page->renderSort($Page->BIRTH_PLACE) ?></div></th>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <th data-name="ANTE_NATAL" class="<?= $Page->ANTE_NATAL->headerCellClass() ?>"><div id="elh_OBSTETRI_ANTE_NATAL" class="OBSTETRI_ANTE_NATAL"><?= $Page->renderSort($Page->ANTE_NATAL) ?></div></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_EMPLOYEE_ID" class="OBSTETRI_EMPLOYEE_ID"><?= $Page->renderSort($Page->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_CLINIC_ID" class="OBSTETRI_CLINIC_ID"><?= $Page->renderSort($Page->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <th data-name="BIRTH_WAY" class="<?= $Page->BIRTH_WAY->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_WAY" class="OBSTETRI_BIRTH_WAY"><?= $Page->renderSort($Page->BIRTH_WAY) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <th data-name="BIRTH_BY" class="<?= $Page->BIRTH_BY->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_BY" class="OBSTETRI_BIRTH_BY"><?= $Page->renderSort($Page->BIRTH_BY) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <th data-name="BIRTH_DATE" class="<?= $Page->BIRTH_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_DATE" class="OBSTETRI_BIRTH_DATE"><?= $Page->renderSort($Page->BIRTH_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
        <th data-name="GESTASI" class="<?= $Page->GESTASI->headerCellClass() ?>"><div id="elh_OBSTETRI_GESTASI" class="OBSTETRI_GESTASI"><?= $Page->renderSort($Page->GESTASI) ?></div></th>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
        <th data-name="PARITY" class="<?= $Page->PARITY->headerCellClass() ?>"><div id="elh_OBSTETRI_PARITY" class="OBSTETRI_PARITY"><?= $Page->renderSort($Page->PARITY) ?></div></th>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
        <th data-name="NB_BABY" class="<?= $Page->NB_BABY->headerCellClass() ?>"><div id="elh_OBSTETRI_NB_BABY" class="OBSTETRI_NB_BABY"><?= $Page->renderSort($Page->NB_BABY) ?></div></th>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
        <th data-name="BABY_DIE" class="<?= $Page->BABY_DIE->headerCellClass() ?>"><div id="elh_OBSTETRI_BABY_DIE" class="OBSTETRI_BABY_DIE"><?= $Page->renderSort($Page->BABY_DIE) ?></div></th>
<?php } ?>
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <th data-name="ABORTUS_KE" class="<?= $Page->ABORTUS_KE->headerCellClass() ?>"><div id="elh_OBSTETRI_ABORTUS_KE" class="OBSTETRI_ABORTUS_KE"><?= $Page->renderSort($Page->ABORTUS_KE) ?></div></th>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <th data-name="ABORTUS_ID" class="<?= $Page->ABORTUS_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_ABORTUS_ID" class="OBSTETRI_ABORTUS_ID"><?= $Page->renderSort($Page->ABORTUS_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <th data-name="ABORTION_DATE" class="<?= $Page->ABORTION_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_ABORTION_DATE" class="OBSTETRI_ABORTION_DATE"><?= $Page->renderSort($Page->ABORTION_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <th data-name="BIRTH_CAT" class="<?= $Page->BIRTH_CAT->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_CAT" class="OBSTETRI_BIRTH_CAT"><?= $Page->renderSort($Page->BIRTH_CAT) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <th data-name="BIRTH_CON" class="<?= $Page->BIRTH_CON->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_CON" class="OBSTETRI_BIRTH_CON"><?= $Page->renderSort($Page->BIRTH_CON) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <th data-name="BIRTH_RISK" class="<?= $Page->BIRTH_RISK->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_RISK" class="OBSTETRI_BIRTH_RISK"><?= $Page->renderSort($Page->BIRTH_RISK) ?></div></th>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <th data-name="RISK_TYPE" class="<?= $Page->RISK_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_RISK_TYPE" class="OBSTETRI_RISK_TYPE"><?= $Page->renderSort($Page->RISK_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <th data-name="FOLLOW_UP" class="<?= $Page->FOLLOW_UP->headerCellClass() ?>"><div id="elh_OBSTETRI_FOLLOW_UP" class="OBSTETRI_FOLLOW_UP"><?= $Page->renderSort($Page->FOLLOW_UP) ?></div></th>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <th data-name="DIRUJUK_OLEH" class="<?= $Page->DIRUJUK_OLEH->headerCellClass() ?>"><div id="elh_OBSTETRI_DIRUJUK_OLEH" class="OBSTETRI_DIRUJUK_OLEH"><?= $Page->renderSort($Page->DIRUJUK_OLEH) ?></div></th>
<?php } ?>
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <th data-name="INSPECTION_DATE" class="<?= $Page->INSPECTION_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_INSPECTION_DATE" class="OBSTETRI_INSPECTION_DATE"><?= $Page->renderSort($Page->INSPECTION_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
        <th data-name="PORSIO" class="<?= $Page->PORSIO->headerCellClass() ?>"><div id="elh_OBSTETRI_PORSIO" class="OBSTETRI_PORSIO"><?= $Page->renderSort($Page->PORSIO) ?></div></th>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <th data-name="PEMBUKAAN" class="<?= $Page->PEMBUKAAN->headerCellClass() ?>"><div id="elh_OBSTETRI_PEMBUKAAN" class="OBSTETRI_PEMBUKAAN"><?= $Page->renderSort($Page->PEMBUKAAN) ?></div></th>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
        <th data-name="KETUBAN" class="<?= $Page->KETUBAN->headerCellClass() ?>"><div id="elh_OBSTETRI_KETUBAN" class="OBSTETRI_KETUBAN"><?= $Page->renderSort($Page->KETUBAN) ?></div></th>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
        <th data-name="PRESENTASI" class="<?= $Page->PRESENTASI->headerCellClass() ?>"><div id="elh_OBSTETRI_PRESENTASI" class="OBSTETRI_PRESENTASI"><?= $Page->renderSort($Page->PRESENTASI) ?></div></th>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
        <th data-name="POSISI" class="<?= $Page->POSISI->headerCellClass() ?>"><div id="elh_OBSTETRI_POSISI" class="OBSTETRI_POSISI"><?= $Page->renderSort($Page->POSISI) ?></div></th>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
        <th data-name="PENURUNAN" class="<?= $Page->PENURUNAN->headerCellClass() ?>"><div id="elh_OBSTETRI_PENURUNAN" class="OBSTETRI_PENURUNAN"><?= $Page->renderSort($Page->PENURUNAN) ?></div></th>
<?php } ?>
<?php if ($Page->HEART_ID->Visible) { // HEART_ID ?>
        <th data-name="HEART_ID" class="<?= $Page->HEART_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_HEART_ID" class="OBSTETRI_HEART_ID"><?= $Page->renderSort($Page->HEART_ID) ?></div></th>
<?php } ?>
<?php if ($Page->JANIN_ID->Visible) { // JANIN_ID ?>
        <th data-name="JANIN_ID" class="<?= $Page->JANIN_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_JANIN_ID" class="OBSTETRI_JANIN_ID"><?= $Page->renderSort($Page->JANIN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <th data-name="FREK_DJJ" class="<?= $Page->FREK_DJJ->headerCellClass() ?>"><div id="elh_OBSTETRI_FREK_DJJ" class="OBSTETRI_FREK_DJJ"><?= $Page->renderSort($Page->FREK_DJJ) ?></div></th>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
        <th data-name="PLACENTA" class="<?= $Page->PLACENTA->headerCellClass() ?>"><div id="elh_OBSTETRI_PLACENTA" class="OBSTETRI_PLACENTA"><?= $Page->renderSort($Page->PLACENTA) ?></div></th>
<?php } ?>
<?php if ($Page->LOCHIA->Visible) { // LOCHIA ?>
        <th data-name="LOCHIA" class="<?= $Page->LOCHIA->headerCellClass() ?>"><div id="elh_OBSTETRI_LOCHIA" class="OBSTETRI_LOCHIA"><?= $Page->renderSort($Page->LOCHIA) ?></div></th>
<?php } ?>
<?php if ($Page->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <th data-name="BAB_TYPE" class="<?= $Page->BAB_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_BAB_TYPE" class="OBSTETRI_BAB_TYPE"><?= $Page->renderSort($Page->BAB_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <th data-name="BAB_BAB_TYPE" class="<?= $Page->BAB_BAB_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_BAB_BAB_TYPE" class="OBSTETRI_BAB_BAB_TYPE"><?= $Page->renderSort($Page->BAB_BAB_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <th data-name="RAHIM_ID" class="<?= $Page->RAHIM_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_RAHIM_ID" class="OBSTETRI_RAHIM_ID"><?= $Page->renderSort($Page->RAHIM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <th data-name="BIR_RAHIM_ID" class="<?= $Page->BIR_RAHIM_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_BIR_RAHIM_ID" class="OBSTETRI_BIR_RAHIM_ID"><?= $Page->renderSort($Page->BIR_RAHIM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Page->VISIT_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_VISIT_ID" class="OBSTETRI_VISIT_ID"><?= $Page->renderSort($Page->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
        <th data-name="BLOODING" class="<?= $Page->BLOODING->headerCellClass() ?>"><div id="elh_OBSTETRI_BLOODING" class="OBSTETRI_BLOODING"><?= $Page->renderSort($Page->BLOODING) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_OBSTETRI_DESCRIPTION" class="OBSTETRI_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_MODIFIED_DATE" class="OBSTETRI_MODIFIED_DATE"><?= $Page->renderSort($Page->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><div id="elh_OBSTETRI_MODIFIED_BY" class="OBSTETRI_MODIFIED_BY"><?= $Page->renderSort($Page->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Page->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_OBSTETRI_MODIFIED_FROM" class="OBSTETRI_MODIFIED_FROM"><?= $Page->renderSort($Page->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <th data-name="RAHIM_SALIN" class="<?= $Page->RAHIM_SALIN->headerCellClass() ?>"><div id="elh_OBSTETRI_RAHIM_SALIN" class="OBSTETRI_RAHIM_SALIN"><?= $Page->renderSort($Page->RAHIM_SALIN) ?></div></th>
<?php } ?>
<?php if ($Page->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <th data-name="RAHIM_NIFAS" class="<?= $Page->RAHIM_NIFAS->headerCellClass() ?>"><div id="elh_OBSTETRI_RAHIM_NIFAS" class="OBSTETRI_RAHIM_NIFAS"><?= $Page->renderSort($Page->RAHIM_NIFAS) ?></div></th>
<?php } ?>
<?php if ($Page->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <th data-name="BAK_TYPE" class="<?= $Page->BAK_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_BAK_TYPE" class="OBSTETRI_BAK_TYPE"><?= $Page->renderSort($Page->BAK_TYPE) ?></div></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Page->THENAME->headerCellClass() ?>"><div id="elh_OBSTETRI_THENAME" class="OBSTETRI_THENAME"><?= $Page->renderSort($Page->THENAME) ?></div></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Page->THEADDRESS->headerCellClass() ?>"><div id="elh_OBSTETRI_THEADDRESS" class="OBSTETRI_THEADDRESS"><?= $Page->renderSort($Page->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Page->THEID->headerCellClass() ?>"><div id="elh_OBSTETRI_THEID" class="OBSTETRI_THEID"><?= $Page->renderSort($Page->THEID) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_STATUS_PASIEN_ID" class="OBSTETRI_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Page->ISRJ->headerCellClass() ?>"><div id="elh_OBSTETRI_ISRJ" class="OBSTETRI_ISRJ"><?= $Page->renderSort($Page->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Page->AGEYEAR->headerCellClass() ?>"><div id="elh_OBSTETRI_AGEYEAR" class="OBSTETRI_AGEYEAR"><?= $Page->renderSort($Page->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Page->AGEMONTH->headerCellClass() ?>"><div id="elh_OBSTETRI_AGEMONTH" class="OBSTETRI_AGEMONTH"><?= $Page->renderSort($Page->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Page->AGEDAY->headerCellClass() ?>"><div id="elh_OBSTETRI_AGEDAY" class="OBSTETRI_AGEDAY"><?= $Page->renderSort($Page->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Page->GENDER->headerCellClass() ?>"><div id="elh_OBSTETRI_GENDER" class="OBSTETRI_GENDER"><?= $Page->renderSort($Page->GENDER) ?></div></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_CLASS_ROOM_ID" class="OBSTETRI_CLASS_ROOM_ID"><?= $Page->renderSort($Page->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Page->BED_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_BED_ID" class="OBSTETRI_BED_ID"><?= $Page->renderSort($Page->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_KELUAR_ID" class="OBSTETRI_KELUAR_ID"><?= $Page->renderSort($Page->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th data-name="DOCTOR" class="<?= $Page->DOCTOR->headerCellClass() ?>"><div id="elh_OBSTETRI_DOCTOR" class="OBSTETRI_DOCTOR"><?= $Page->renderSort($Page->DOCTOR) ?></div></th>
<?php } ?>
<?php if ($Page->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <th data-name="NB_OBSTETRI" class="<?= $Page->NB_OBSTETRI->headerCellClass() ?>"><div id="elh_OBSTETRI_NB_OBSTETRI" class="OBSTETRI_NB_OBSTETRI"><?= $Page->renderSort($Page->NB_OBSTETRI) ?></div></th>
<?php } ?>
<?php if ($Page->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <th data-name="OBSTETRI_DIE" class="<?= $Page->OBSTETRI_DIE->headerCellClass() ?>"><div id="elh_OBSTETRI_OBSTETRI_DIE" class="OBSTETRI_OBSTETRI_DIE"><?= $Page->renderSort($Page->OBSTETRI_DIE) ?></div></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Page->KAL_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_KAL_ID" class="OBSTETRI_KAL_ID"><?= $Page->renderSort($Page->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <th data-name="DIAGNOSA_ID2" class="<?= $Page->DIAGNOSA_ID2->headerCellClass() ?>"><div id="elh_OBSTETRI_DIAGNOSA_ID2" class="OBSTETRI_DIAGNOSA_ID2"><?= $Page->renderSort($Page->DIAGNOSA_ID2) ?></div></th>
<?php } ?>
<?php if ($Page->APGAR_ID->Visible) { // APGAR_ID ?>
        <th data-name="APGAR_ID" class="<?= $Page->APGAR_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_APGAR_ID" class="OBSTETRI_APGAR_ID"><?= $Page->renderSort($Page->APGAR_ID) ?></div></th>
<?php } ?>
<?php if ($Page->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <th data-name="BIRTH_LAST_ID" class="<?= $Page->BIRTH_LAST_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_LAST_ID" class="OBSTETRI_BIRTH_LAST_ID"><?= $Page->renderSort($Page->BIRTH_LAST_ID) ?></div></th>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_OBSTETRI_ID" class="OBSTETRI_ID"><?= $Page->renderSort($Page->ID) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_OBSTETRI", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <td data-name="OBSTETRI_ID" <?= $Page->OBSTETRI_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_OBSTETRI_ID">
<span<?= $Page->OBSTETRI_ID->viewAttributes() ?>>
<?= $Page->OBSTETRI_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HPHT->Visible) { // HPHT ?>
        <td data-name="HPHT" <?= $Page->HPHT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_HPHT">
<span<?= $Page->HPHT->viewAttributes() ?>>
<?= $Page->HPHT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HTP->Visible) { // HTP ?>
        <td data-name="HTP" <?= $Page->HTP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_HTP">
<span<?= $Page->HTP->viewAttributes() ?>>
<?= $Page->HTP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <td data-name="PASIEN_DIAGNOSA_ID" <?= $Page->PASIEN_DIAGNOSA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PASIEN_DIAGNOSA_ID">
<span<?= $Page->PASIEN_DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->PASIEN_DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td data-name="DIAGNOSA_ID" <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DIAGNOSA_ID">
<span<?= $Page->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <td data-name="KOHORT_NB" <?= $Page->KOHORT_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KOHORT_NB">
<span<?= $Page->KOHORT_NB->viewAttributes() ?>>
<?= $Page->KOHORT_NB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <td data-name="BIRTH_NB" <?= $Page->BIRTH_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_NB">
<span<?= $Page->BIRTH_NB->viewAttributes() ?>>
<?= $Page->BIRTH_NB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <td data-name="BIRTH_DURATION" <?= $Page->BIRTH_DURATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_DURATION">
<span<?= $Page->BIRTH_DURATION->viewAttributes() ?>>
<?= $Page->BIRTH_DURATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <td data-name="BIRTH_PLACE" <?= $Page->BIRTH_PLACE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_PLACE">
<span<?= $Page->BIRTH_PLACE->viewAttributes() ?>>
<?= $Page->BIRTH_PLACE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <td data-name="ANTE_NATAL" <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ANTE_NATAL">
<span<?= $Page->ANTE_NATAL->viewAttributes() ?>>
<?= $Page->ANTE_NATAL->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <td data-name="BIRTH_WAY" <?= $Page->BIRTH_WAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_WAY">
<span<?= $Page->BIRTH_WAY->viewAttributes() ?>>
<?= $Page->BIRTH_WAY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <td data-name="BIRTH_BY" <?= $Page->BIRTH_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_BY">
<span<?= $Page->BIRTH_BY->viewAttributes() ?>>
<?= $Page->BIRTH_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <td data-name="BIRTH_DATE" <?= $Page->BIRTH_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_DATE">
<span<?= $Page->BIRTH_DATE->viewAttributes() ?>>
<?= $Page->BIRTH_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GESTASI->Visible) { // GESTASI ?>
        <td data-name="GESTASI" <?= $Page->GESTASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_GESTASI">
<span<?= $Page->GESTASI->viewAttributes() ?>>
<?= $Page->GESTASI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PARITY->Visible) { // PARITY ?>
        <td data-name="PARITY" <?= $Page->PARITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PARITY">
<span<?= $Page->PARITY->viewAttributes() ?>>
<?= $Page->PARITY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
        <td data-name="NB_BABY" <?= $Page->NB_BABY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_NB_BABY">
<span<?= $Page->NB_BABY->viewAttributes() ?>>
<?= $Page->NB_BABY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
        <td data-name="BABY_DIE" <?= $Page->BABY_DIE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BABY_DIE">
<span<?= $Page->BABY_DIE->viewAttributes() ?>>
<?= $Page->BABY_DIE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <td data-name="ABORTUS_KE" <?= $Page->ABORTUS_KE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ABORTUS_KE">
<span<?= $Page->ABORTUS_KE->viewAttributes() ?>>
<?= $Page->ABORTUS_KE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <td data-name="ABORTUS_ID" <?= $Page->ABORTUS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ABORTUS_ID">
<span<?= $Page->ABORTUS_ID->viewAttributes() ?>>
<?= $Page->ABORTUS_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <td data-name="ABORTION_DATE" <?= $Page->ABORTION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ABORTION_DATE">
<span<?= $Page->ABORTION_DATE->viewAttributes() ?>>
<?= $Page->ABORTION_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <td data-name="BIRTH_CAT" <?= $Page->BIRTH_CAT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_CAT">
<span<?= $Page->BIRTH_CAT->viewAttributes() ?>>
<?= $Page->BIRTH_CAT->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <td data-name="BIRTH_CON" <?= $Page->BIRTH_CON->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_CON">
<span<?= $Page->BIRTH_CON->viewAttributes() ?>>
<?= $Page->BIRTH_CON->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <td data-name="BIRTH_RISK" <?= $Page->BIRTH_RISK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_RISK">
<span<?= $Page->BIRTH_RISK->viewAttributes() ?>>
<?= $Page->BIRTH_RISK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <td data-name="RISK_TYPE" <?= $Page->RISK_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RISK_TYPE">
<span<?= $Page->RISK_TYPE->viewAttributes() ?>>
<?= $Page->RISK_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <td data-name="FOLLOW_UP" <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_FOLLOW_UP">
<span<?= $Page->FOLLOW_UP->viewAttributes() ?>>
<?= $Page->FOLLOW_UP->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <td data-name="DIRUJUK_OLEH" <?= $Page->DIRUJUK_OLEH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DIRUJUK_OLEH">
<span<?= $Page->DIRUJUK_OLEH->viewAttributes() ?>>
<?= $Page->DIRUJUK_OLEH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <td data-name="INSPECTION_DATE" <?= $Page->INSPECTION_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_INSPECTION_DATE">
<span<?= $Page->INSPECTION_DATE->viewAttributes() ?>>
<?= $Page->INSPECTION_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PORSIO->Visible) { // PORSIO ?>
        <td data-name="PORSIO" <?= $Page->PORSIO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PORSIO">
<span<?= $Page->PORSIO->viewAttributes() ?>>
<?= $Page->PORSIO->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <td data-name="PEMBUKAAN" <?= $Page->PEMBUKAAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PEMBUKAAN">
<span<?= $Page->PEMBUKAAN->viewAttributes() ?>>
<?= $Page->PEMBUKAAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
        <td data-name="KETUBAN" <?= $Page->KETUBAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KETUBAN">
<span<?= $Page->KETUBAN->viewAttributes() ?>>
<?= $Page->KETUBAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
        <td data-name="PRESENTASI" <?= $Page->PRESENTASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PRESENTASI">
<span<?= $Page->PRESENTASI->viewAttributes() ?>>
<?= $Page->PRESENTASI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->POSISI->Visible) { // POSISI ?>
        <td data-name="POSISI" <?= $Page->POSISI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_POSISI">
<span<?= $Page->POSISI->viewAttributes() ?>>
<?= $Page->POSISI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
        <td data-name="PENURUNAN" <?= $Page->PENURUNAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PENURUNAN">
<span<?= $Page->PENURUNAN->viewAttributes() ?>>
<?= $Page->PENURUNAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->HEART_ID->Visible) { // HEART_ID ?>
        <td data-name="HEART_ID" <?= $Page->HEART_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_HEART_ID">
<span<?= $Page->HEART_ID->viewAttributes() ?>>
<?= $Page->HEART_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->JANIN_ID->Visible) { // JANIN_ID ?>
        <td data-name="JANIN_ID" <?= $Page->JANIN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_JANIN_ID">
<span<?= $Page->JANIN_ID->viewAttributes() ?>>
<?= $Page->JANIN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <td data-name="FREK_DJJ" <?= $Page->FREK_DJJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_FREK_DJJ">
<span<?= $Page->FREK_DJJ->viewAttributes() ?>>
<?= $Page->FREK_DJJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
        <td data-name="PLACENTA" <?= $Page->PLACENTA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_PLACENTA">
<span<?= $Page->PLACENTA->viewAttributes() ?>>
<?= $Page->PLACENTA->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->LOCHIA->Visible) { // LOCHIA ?>
        <td data-name="LOCHIA" <?= $Page->LOCHIA->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_LOCHIA">
<span<?= $Page->LOCHIA->viewAttributes() ?>>
<?= $Page->LOCHIA->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <td data-name="BAB_TYPE" <?= $Page->BAB_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BAB_TYPE">
<span<?= $Page->BAB_TYPE->viewAttributes() ?>>
<?= $Page->BAB_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <td data-name="BAB_BAB_TYPE" <?= $Page->BAB_BAB_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BAB_BAB_TYPE">
<span<?= $Page->BAB_BAB_TYPE->viewAttributes() ?>>
<?= $Page->BAB_BAB_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <td data-name="RAHIM_ID" <?= $Page->RAHIM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RAHIM_ID">
<span<?= $Page->RAHIM_ID->viewAttributes() ?>>
<?= $Page->RAHIM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <td data-name="BIR_RAHIM_ID" <?= $Page->BIR_RAHIM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIR_RAHIM_ID">
<span<?= $Page->BIR_RAHIM_ID->viewAttributes() ?>>
<?= $Page->BIR_RAHIM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BLOODING->Visible) { // BLOODING ?>
        <td data-name="BLOODING" <?= $Page->BLOODING->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BLOODING">
<span<?= $Page->BLOODING->viewAttributes() ?>>
<?= $Page->BLOODING->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_MODIFIED_FROM">
<span<?= $Page->MODIFIED_FROM->viewAttributes() ?>>
<?= $Page->MODIFIED_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <td data-name="RAHIM_SALIN" <?= $Page->RAHIM_SALIN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RAHIM_SALIN">
<span<?= $Page->RAHIM_SALIN->viewAttributes() ?>>
<?= $Page->RAHIM_SALIN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <td data-name="RAHIM_NIFAS" <?= $Page->RAHIM_NIFAS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_RAHIM_NIFAS">
<span<?= $Page->RAHIM_NIFAS->viewAttributes() ?>>
<?= $Page->RAHIM_NIFAS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <td data-name="BAK_TYPE" <?= $Page->BAK_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BAK_TYPE">
<span<?= $Page->BAK_TYPE->viewAttributes() ?>>
<?= $Page->BAK_TYPE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_AGEMONTH">
<span<?= $Page->AGEMONTH->viewAttributes() ?>>
<?= $Page->AGEMONTH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_AGEDAY">
<span<?= $Page->AGEDAY->viewAttributes() ?>>
<?= $Page->AGEDAY->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR" <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <td data-name="NB_OBSTETRI" <?= $Page->NB_OBSTETRI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_NB_OBSTETRI">
<span<?= $Page->NB_OBSTETRI->viewAttributes() ?>>
<?= $Page->NB_OBSTETRI->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <td data-name="OBSTETRI_DIE" <?= $Page->OBSTETRI_DIE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_OBSTETRI_DIE">
<span<?= $Page->OBSTETRI_DIE->viewAttributes() ?>>
<?= $Page->OBSTETRI_DIE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <td data-name="DIAGNOSA_ID2" <?= $Page->DIAGNOSA_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_DIAGNOSA_ID2">
<span<?= $Page->DIAGNOSA_ID2->viewAttributes() ?>>
<?= $Page->DIAGNOSA_ID2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->APGAR_ID->Visible) { // APGAR_ID ?>
        <td data-name="APGAR_ID" <?= $Page->APGAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_APGAR_ID">
<span<?= $Page->APGAR_ID->viewAttributes() ?>>
<?= $Page->APGAR_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <td data-name="BIRTH_LAST_ID" <?= $Page->BIRTH_LAST_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_BIRTH_LAST_ID">
<span<?= $Page->BIRTH_LAST_ID->viewAttributes() ?>>
<?= $Page->BIRTH_LAST_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID" <?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_OBSTETRI_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
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
    ew.addEventHandlers("OBSTETRI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
