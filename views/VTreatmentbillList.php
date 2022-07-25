<?php

namespace PHPMaker2021\simrs;

// Page object
$VTreatmentbillList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_TREATMENTBILLlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fV_TREATMENTBILLlist = currentForm = new ew.Form("fV_TREATMENTBILLlist", "list");
    fV_TREATMENTBILLlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fV_TREATMENTBILLlist");
});
var fV_TREATMENTBILLlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fV_TREATMENTBILLlistsrch = currentSearchForm = new ew.Form("fV_TREATMENTBILLlistsrch");

    // Dynamic selection lists

    // Filters
    fV_TREATMENTBILLlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fV_TREATMENTBILLlistsrch");
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
<form name="fV_TREATMENTBILLlistsrch" id="fV_TREATMENTBILLlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fV_TREATMENTBILLlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="V_TREATMENTBILL">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_TREATMENTBILL">
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
<form name="fV_TREATMENTBILLlist" id="fV_TREATMENTBILLlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_TREATMENTBILL">
<div id="gmp_V_TREATMENTBILL" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_V_TREATMENTBILLlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <th data-name="NAME_OF_PASIEN" class="<?= $Page->NAME_OF_PASIEN->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_NAME_OF_PASIEN" class="V_TREATMENTBILL_NAME_OF_PASIEN"><?= $Page->renderSort($Page->NAME_OF_PASIEN) ?></div></th>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_NO_REGISTRATION" class="V_TREATMENTBILL_NO_REGISTRATION"><?= $Page->renderSort($Page->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_ORG_UNIT_CODE" class="V_TREATMENTBILL_ORG_UNIT_CODE"><?= $Page->renderSort($Page->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Page->date_of_birth->Visible) { // date_of_birth ?>
        <th data-name="date_of_birth" class="<?= $Page->date_of_birth->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_date_of_birth" class="V_TREATMENTBILL_date_of_birth"><?= $Page->renderSort($Page->date_of_birth) ?></div></th>
<?php } ?>
<?php if ($Page->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <th data-name="CONTACT_ADDRESS" class="<?= $Page->CONTACT_ADDRESS->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_CONTACT_ADDRESS" class="V_TREATMENTBILL_CONTACT_ADDRESS"><?= $Page->renderSort($Page->CONTACT_ADDRESS) ?></div></th>
<?php } ?>
<?php if ($Page->PHONE_NUMBER->Visible) { // PHONE_NUMBER ?>
        <th data-name="PHONE_NUMBER" class="<?= $Page->PHONE_NUMBER->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_PHONE_NUMBER" class="V_TREATMENTBILL_PHONE_NUMBER"><?= $Page->renderSort($Page->PHONE_NUMBER) ?></div></th>
<?php } ?>
<?php if ($Page->MOBILE->Visible) { // MOBILE ?>
        <th data-name="MOBILE" class="<?= $Page->MOBILE->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_MOBILE" class="V_TREATMENTBILL_MOBILE"><?= $Page->renderSort($Page->MOBILE) ?></div></th>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Page->KAL_ID->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_KAL_ID" class="V_TREATMENTBILL_KAL_ID"><?= $Page->renderSort($Page->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Page->PLACE_OF_BIRTH->Visible) { // PLACE_OF_BIRTH ?>
        <th data-name="PLACE_OF_BIRTH" class="<?= $Page->PLACE_OF_BIRTH->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_PLACE_OF_BIRTH" class="V_TREATMENTBILL_PLACE_OF_BIRTH"><?= $Page->renderSort($Page->PLACE_OF_BIRTH) ?></div></th>
<?php } ?>
<?php if ($Page->KALURAHAN->Visible) { // KALURAHAN ?>
        <th data-name="KALURAHAN" class="<?= $Page->KALURAHAN->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_KALURAHAN" class="V_TREATMENTBILL_KALURAHAN"><?= $Page->renderSort($Page->KALURAHAN) ?></div></th>
<?php } ?>
<?php if ($Page->name_of_clinic->Visible) { // name_of_clinic ?>
        <th data-name="name_of_clinic" class="<?= $Page->name_of_clinic->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_name_of_clinic" class="V_TREATMENTBILL_name_of_clinic"><?= $Page->renderSort($Page->name_of_clinic) ?></div></th>
<?php } ?>
<?php if ($Page->booked_Date->Visible) { // booked_Date ?>
        <th data-name="booked_Date" class="<?= $Page->booked_Date->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_booked_Date" class="V_TREATMENTBILL_booked_Date"><?= $Page->renderSort($Page->booked_Date) ?></div></th>
<?php } ?>
<?php if ($Page->visit_date->Visible) { // visit_date ?>
        <th data-name="visit_date" class="<?= $Page->visit_date->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_visit_date" class="V_TREATMENTBILL_visit_date"><?= $Page->renderSort($Page->visit_date) ?></div></th>
<?php } ?>
<?php if ($Page->visit_id->Visible) { // visit_id ?>
        <th data-name="visit_id" class="<?= $Page->visit_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_visit_id" class="V_TREATMENTBILL_visit_id"><?= $Page->renderSort($Page->visit_id) ?></div></th>
<?php } ?>
<?php if ($Page->isattended->Visible) { // isattended ?>
        <th data-name="isattended" class="<?= $Page->isattended->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_isattended" class="V_TREATMENTBILL_isattended"><?= $Page->renderSort($Page->isattended) ?></div></th>
<?php } ?>
<?php if ($Page->diantar_oleh->Visible) { // diantar_oleh ?>
        <th data-name="diantar_oleh" class="<?= $Page->diantar_oleh->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_diantar_oleh" class="V_TREATMENTBILL_diantar_oleh"><?= $Page->renderSort($Page->diantar_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->visitor_address->Visible) { // visitor_address ?>
        <th data-name="visitor_address" class="<?= $Page->visitor_address->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_visitor_address" class="V_TREATMENTBILL_visitor_address"><?= $Page->renderSort($Page->visitor_address) ?></div></th>
<?php } ?>
<?php if ($Page->address_of_rujukan->Visible) { // address_of_rujukan ?>
        <th data-name="address_of_rujukan" class="<?= $Page->address_of_rujukan->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_address_of_rujukan" class="V_TREATMENTBILL_address_of_rujukan"><?= $Page->renderSort($Page->address_of_rujukan) ?></div></th>
<?php } ?>
<?php if ($Page->rujukan_id->Visible) { // rujukan_id ?>
        <th data-name="rujukan_id" class="<?= $Page->rujukan_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_rujukan_id" class="V_TREATMENTBILL_rujukan_id"><?= $Page->renderSort($Page->rujukan_id) ?></div></th>
<?php } ?>
<?php if ($Page->patient_category_id->Visible) { // patient_category_id ?>
        <th data-name="patient_category_id" class="<?= $Page->patient_category_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_patient_category_id" class="V_TREATMENTBILL_patient_category_id"><?= $Page->renderSort($Page->patient_category_id) ?></div></th>
<?php } ?>
<?php if ($Page->payor_id->Visible) { // payor_id ?>
        <th data-name="payor_id" class="<?= $Page->payor_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_payor_id" class="V_TREATMENTBILL_payor_id"><?= $Page->renderSort($Page->payor_id) ?></div></th>
<?php } ?>
<?php if ($Page->reason_id->Visible) { // reason_id ?>
        <th data-name="reason_id" class="<?= $Page->reason_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_reason_id" class="V_TREATMENTBILL_reason_id"><?= $Page->renderSort($Page->reason_id) ?></div></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_DESCRIPTION" class="V_TREATMENTBILL_DESCRIPTION"><?= $Page->renderSort($Page->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Page->way_id->Visible) { // way_id ?>
        <th data-name="way_id" class="<?= $Page->way_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_way_id" class="V_TREATMENTBILL_way_id"><?= $Page->renderSort($Page->way_id) ?></div></th>
<?php } ?>
<?php if ($Page->follow_up->Visible) { // follow_up ?>
        <th data-name="follow_up" class="<?= $Page->follow_up->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_follow_up" class="V_TREATMENTBILL_follow_up"><?= $Page->renderSort($Page->follow_up) ?></div></th>
<?php } ?>
<?php if ($Page->isnew->Visible) { // isnew ?>
        <th data-name="isnew" class="<?= $Page->isnew->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_isnew" class="V_TREATMENTBILL_isnew"><?= $Page->renderSort($Page->isnew) ?></div></th>
<?php } ?>
<?php if ($Page->family_status_id->Visible) { // family_status_id ?>
        <th data-name="family_status_id" class="<?= $Page->family_status_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_family_status_id" class="V_TREATMENTBILL_family_status_id"><?= $Page->renderSort($Page->family_status_id) ?></div></th>
<?php } ?>
<?php if ($Page->class_room_id->Visible) { // class_room_id ?>
        <th data-name="class_room_id" class="<?= $Page->class_room_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_class_room_id" class="V_TREATMENTBILL_class_room_id"><?= $Page->renderSort($Page->class_room_id) ?></div></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_STATUS_PASIEN_ID" class="V_TREATMENTBILL_STATUS_PASIEN_ID"><?= $Page->renderSort($Page->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Page->fullname->Visible) { // fullname ?>
        <th data-name="fullname" class="<?= $Page->fullname->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_fullname" class="V_TREATMENTBILL_fullname"><?= $Page->renderSort($Page->fullname) ?></div></th>
<?php } ?>
<?php if ($Page->employee_id->Visible) { // employee_id ?>
        <th data-name="employee_id" class="<?= $Page->employee_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_employee_id" class="V_TREATMENTBILL_employee_id"><?= $Page->renderSort($Page->employee_id) ?></div></th>
<?php } ?>
<?php if ($Page->employee_id_from->Visible) { // employee_id_from ?>
        <th data-name="employee_id_from" class="<?= $Page->employee_id_from->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_employee_id_from" class="V_TREATMENTBILL_employee_id_from"><?= $Page->renderSort($Page->employee_id_from) ?></div></th>
<?php } ?>
<?php if ($Page->clinic_id->Visible) { // clinic_id ?>
        <th data-name="clinic_id" class="<?= $Page->clinic_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_clinic_id" class="V_TREATMENTBILL_clinic_id"><?= $Page->renderSort($Page->clinic_id) ?></div></th>
<?php } ?>
<?php if ($Page->clinic_id_FROM->Visible) { // clinic_id_FROM ?>
        <th data-name="clinic_id_FROM" class="<?= $Page->clinic_id_FROM->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_clinic_id_FROM" class="V_TREATMENTBILL_clinic_id_FROM"><?= $Page->renderSort($Page->clinic_id_FROM) ?></div></th>
<?php } ?>
<?php if ($Page->doctor->Visible) { // doctor ?>
        <th data-name="doctor" class="<?= $Page->doctor->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_doctor" class="V_TREATMENTBILL_doctor"><?= $Page->renderSort($Page->doctor) ?></div></th>
<?php } ?>
<?php if ($Page->bed_id->Visible) { // bed_id ?>
        <th data-name="bed_id" class="<?= $Page->bed_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_bed_id" class="V_TREATMENTBILL_bed_id"><?= $Page->renderSort($Page->bed_id) ?></div></th>
<?php } ?>
<?php if ($Page->keluar_id->Visible) { // keluar_id ?>
        <th data-name="keluar_id" class="<?= $Page->keluar_id->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_keluar_id" class="V_TREATMENTBILL_keluar_id"><?= $Page->renderSort($Page->keluar_id) ?></div></th>
<?php } ?>
<?php if ($Page->treat_date->Visible) { // treat_date ?>
        <th data-name="treat_date" class="<?= $Page->treat_date->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_treat_date" class="V_TREATMENTBILL_treat_date"><?= $Page->renderSort($Page->treat_date) ?></div></th>
<?php } ?>
<?php if ($Page->exit_date->Visible) { // exit_date ?>
        <th data-name="exit_date" class="<?= $Page->exit_date->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_exit_date" class="V_TREATMENTBILL_exit_date"><?= $Page->renderSort($Page->exit_date) ?></div></th>
<?php } ?>
<?php if ($Page->name_of_class->Visible) { // name_of_class ?>
        <th data-name="name_of_class" class="<?= $Page->name_of_class->headerCellClass() ?>"><div id="elh_V_TREATMENTBILL_name_of_class" class="V_TREATMENTBILL_name_of_class"><?= $Page->renderSort($Page->name_of_class) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_V_TREATMENTBILL", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->NAME_OF_PASIEN->Visible) { // NAME_OF_PASIEN ?>
        <td data-name="NAME_OF_PASIEN" <?= $Page->NAME_OF_PASIEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_NAME_OF_PASIEN">
<span<?= $Page->NAME_OF_PASIEN->viewAttributes() ?>>
<?= $Page->NAME_OF_PASIEN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->date_of_birth->Visible) { // date_of_birth ?>
        <td data-name="date_of_birth" <?= $Page->date_of_birth->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_date_of_birth">
<span<?= $Page->date_of_birth->viewAttributes() ?>>
<?= $Page->date_of_birth->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->CONTACT_ADDRESS->Visible) { // CONTACT_ADDRESS ?>
        <td data-name="CONTACT_ADDRESS" <?= $Page->CONTACT_ADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_CONTACT_ADDRESS">
<span<?= $Page->CONTACT_ADDRESS->viewAttributes() ?>>
<?= $Page->CONTACT_ADDRESS->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PHONE_NUMBER->Visible) { // PHONE_NUMBER ?>
        <td data-name="PHONE_NUMBER" <?= $Page->PHONE_NUMBER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_PHONE_NUMBER">
<span<?= $Page->PHONE_NUMBER->viewAttributes() ?>>
<?= $Page->PHONE_NUMBER->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->MOBILE->Visible) { // MOBILE ?>
        <td data-name="MOBILE" <?= $Page->MOBILE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_MOBILE">
<span<?= $Page->MOBILE->viewAttributes() ?>>
<?= $Page->MOBILE->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_KAL_ID">
<span<?= $Page->KAL_ID->viewAttributes() ?>>
<?= $Page->KAL_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->PLACE_OF_BIRTH->Visible) { // PLACE_OF_BIRTH ?>
        <td data-name="PLACE_OF_BIRTH" <?= $Page->PLACE_OF_BIRTH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_PLACE_OF_BIRTH">
<span<?= $Page->PLACE_OF_BIRTH->viewAttributes() ?>>
<?= $Page->PLACE_OF_BIRTH->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->KALURAHAN->Visible) { // KALURAHAN ?>
        <td data-name="KALURAHAN" <?= $Page->KALURAHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_KALURAHAN">
<span<?= $Page->KALURAHAN->viewAttributes() ?>>
<?= $Page->KALURAHAN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name_of_clinic->Visible) { // name_of_clinic ?>
        <td data-name="name_of_clinic" <?= $Page->name_of_clinic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_name_of_clinic">
<span<?= $Page->name_of_clinic->viewAttributes() ?>>
<?= $Page->name_of_clinic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->booked_Date->Visible) { // booked_Date ?>
        <td data-name="booked_Date" <?= $Page->booked_Date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_booked_Date">
<span<?= $Page->booked_Date->viewAttributes() ?>>
<?= $Page->booked_Date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->visit_date->Visible) { // visit_date ?>
        <td data-name="visit_date" <?= $Page->visit_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_visit_date">
<span<?= $Page->visit_date->viewAttributes() ?>>
<?= $Page->visit_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->visit_id->Visible) { // visit_id ?>
        <td data-name="visit_id" <?= $Page->visit_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_visit_id">
<span<?= $Page->visit_id->viewAttributes() ?>>
<?= $Page->visit_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isattended->Visible) { // isattended ?>
        <td data-name="isattended" <?= $Page->isattended->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_isattended">
<span<?= $Page->isattended->viewAttributes() ?>>
<?= $Page->isattended->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->diantar_oleh->Visible) { // diantar_oleh ?>
        <td data-name="diantar_oleh" <?= $Page->diantar_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_diantar_oleh">
<span<?= $Page->diantar_oleh->viewAttributes() ?>>
<?= $Page->diantar_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->visitor_address->Visible) { // visitor_address ?>
        <td data-name="visitor_address" <?= $Page->visitor_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_visitor_address">
<span<?= $Page->visitor_address->viewAttributes() ?>>
<?= $Page->visitor_address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->address_of_rujukan->Visible) { // address_of_rujukan ?>
        <td data-name="address_of_rujukan" <?= $Page->address_of_rujukan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_address_of_rujukan">
<span<?= $Page->address_of_rujukan->viewAttributes() ?>>
<?= $Page->address_of_rujukan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rujukan_id->Visible) { // rujukan_id ?>
        <td data-name="rujukan_id" <?= $Page->rujukan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_rujukan_id">
<span<?= $Page->rujukan_id->viewAttributes() ?>>
<?= $Page->rujukan_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->patient_category_id->Visible) { // patient_category_id ?>
        <td data-name="patient_category_id" <?= $Page->patient_category_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_patient_category_id">
<span<?= $Page->patient_category_id->viewAttributes() ?>>
<?= $Page->patient_category_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->payor_id->Visible) { // payor_id ?>
        <td data-name="payor_id" <?= $Page->payor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_payor_id">
<span<?= $Page->payor_id->viewAttributes() ?>>
<?= $Page->payor_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->reason_id->Visible) { // reason_id ?>
        <td data-name="reason_id" <?= $Page->reason_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_reason_id">
<span<?= $Page->reason_id->viewAttributes() ?>>
<?= $Page->reason_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->way_id->Visible) { // way_id ?>
        <td data-name="way_id" <?= $Page->way_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_way_id">
<span<?= $Page->way_id->viewAttributes() ?>>
<?= $Page->way_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->follow_up->Visible) { // follow_up ?>
        <td data-name="follow_up" <?= $Page->follow_up->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_follow_up">
<span<?= $Page->follow_up->viewAttributes() ?>>
<?= $Page->follow_up->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isnew->Visible) { // isnew ?>
        <td data-name="isnew" <?= $Page->isnew->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_isnew">
<span<?= $Page->isnew->viewAttributes() ?>>
<?= $Page->isnew->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->family_status_id->Visible) { // family_status_id ?>
        <td data-name="family_status_id" <?= $Page->family_status_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_family_status_id">
<span<?= $Page->family_status_id->viewAttributes() ?>>
<?= $Page->family_status_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->class_room_id->Visible) { // class_room_id ?>
        <td data-name="class_room_id" <?= $Page->class_room_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_class_room_id">
<span<?= $Page->class_room_id->viewAttributes() ?>>
<?= $Page->class_room_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fullname->Visible) { // fullname ?>
        <td data-name="fullname" <?= $Page->fullname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_fullname">
<span<?= $Page->fullname->viewAttributes() ?>>
<?= $Page->fullname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->employee_id->Visible) { // employee_id ?>
        <td data-name="employee_id" <?= $Page->employee_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<?= $Page->employee_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->employee_id_from->Visible) { // employee_id_from ?>
        <td data-name="employee_id_from" <?= $Page->employee_id_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_employee_id_from">
<span<?= $Page->employee_id_from->viewAttributes() ?>>
<?= $Page->employee_id_from->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->clinic_id->Visible) { // clinic_id ?>
        <td data-name="clinic_id" <?= $Page->clinic_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_clinic_id">
<span<?= $Page->clinic_id->viewAttributes() ?>>
<?= $Page->clinic_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->clinic_id_FROM->Visible) { // clinic_id_FROM ?>
        <td data-name="clinic_id_FROM" <?= $Page->clinic_id_FROM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_clinic_id_FROM">
<span<?= $Page->clinic_id_FROM->viewAttributes() ?>>
<?= $Page->clinic_id_FROM->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->doctor->Visible) { // doctor ?>
        <td data-name="doctor" <?= $Page->doctor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_doctor">
<span<?= $Page->doctor->viewAttributes() ?>>
<?= $Page->doctor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bed_id->Visible) { // bed_id ?>
        <td data-name="bed_id" <?= $Page->bed_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_bed_id">
<span<?= $Page->bed_id->viewAttributes() ?>>
<?= $Page->bed_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keluar_id->Visible) { // keluar_id ?>
        <td data-name="keluar_id" <?= $Page->keluar_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_keluar_id">
<span<?= $Page->keluar_id->viewAttributes() ?>>
<?= $Page->keluar_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->treat_date->Visible) { // treat_date ?>
        <td data-name="treat_date" <?= $Page->treat_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_treat_date">
<span<?= $Page->treat_date->viewAttributes() ?>>
<?= $Page->treat_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->exit_date->Visible) { // exit_date ?>
        <td data-name="exit_date" <?= $Page->exit_date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_exit_date">
<span<?= $Page->exit_date->viewAttributes() ?>>
<?= $Page->exit_date->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name_of_class->Visible) { // name_of_class ?>
        <td data-name="name_of_class" <?= $Page->name_of_class->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_TREATMENTBILL_name_of_class">
<span<?= $Page->name_of_class->viewAttributes() ?>>
<?= $Page->name_of_class->getViewValue() ?></span>
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
    ew.addEventHandlers("V_TREATMENTBILL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
