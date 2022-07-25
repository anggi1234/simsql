<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$VRawatInapDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_RAWAT_INAPdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fV_RAWAT_INAPdelete = currentForm = new ew.Form("fV_RAWAT_INAPdelete", "delete");
    loadjs.done("fV_RAWAT_INAPdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.V_RAWAT_INAP) ew.vars.tables.V_RAWAT_INAP = <?= JsonEncode(GetClientVar("tables", "V_RAWAT_INAP")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fV_RAWAT_INAPdelete" id="fV_RAWAT_INAPdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_RAWAT_INAP">
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
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_NO_REGISTRATION" class="V_RAWAT_INAP_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_THENAME" class="V_RAWAT_INAP_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th class="<?= $Page->THEADDRESS->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_THEADDRESS" class="V_RAWAT_INAP_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_CLINIC_ID" class="V_RAWAT_INAP_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th class="<?= $Page->TREATMENT->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_TREATMENT" class="V_RAWAT_INAP_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_TREAT_DATE" class="V_RAWAT_INAP_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_DESCRIPTION" class="V_RAWAT_INAP_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th class="<?= $Page->CLASS_ROOM_ID->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_CLASS_ROOM_ID" class="V_RAWAT_INAP_CLASS_ROOM_ID"><?= $Page->CLASS_ROOM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th class="<?= $Page->KELUAR_ID->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_KELUAR_ID" class="V_RAWAT_INAP_KELUAR_ID"><?= $Page->KELUAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <th class="<?= $Page->BED_ID->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_BED_ID" class="V_RAWAT_INAP_BED_ID"><?= $Page->BED_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_EMPLOYEE_ID" class="V_RAWAT_INAP_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NO_SURAT_KET->Visible) { // NO_SURAT_KET ?>
        <th class="<?= $Page->NO_SURAT_KET->headerCellClass() ?>"><span id="elh_V_RAWAT_INAP_NO_SURAT_KET" class="V_RAWAT_INAP_NO_SURAT_KET"><?= $Page->NO_SURAT_KET->caption() ?></span></th>
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
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_NO_REGISTRATION" class="V_RAWAT_INAP_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_THENAME" class="V_RAWAT_INAP_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_THEADDRESS" class="V_RAWAT_INAP_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_CLINIC_ID" class="V_RAWAT_INAP_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_TREATMENT" class="V_RAWAT_INAP_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_TREAT_DATE" class="V_RAWAT_INAP_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_DESCRIPTION" class="V_RAWAT_INAP_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_CLASS_ROOM_ID" class="V_RAWAT_INAP_CLASS_ROOM_ID">
<span<?= $Page->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Page->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_KELUAR_ID" class="V_RAWAT_INAP_KELUAR_ID">
<span<?= $Page->KELUAR_ID->viewAttributes() ?>>
<?= $Page->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
        <td <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_BED_ID" class="V_RAWAT_INAP_BED_ID">
<span<?= $Page->BED_ID->viewAttributes() ?>>
<?= $Page->BED_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_EMPLOYEE_ID" class="V_RAWAT_INAP_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NO_SURAT_KET->Visible) { // NO_SURAT_KET ?>
        <td <?= $Page->NO_SURAT_KET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_V_RAWAT_INAP_NO_SURAT_KET" class="V_RAWAT_INAP_NO_SURAT_KET">
<span<?= $Page->NO_SURAT_KET->viewAttributes() ?>>
<?= $Page->NO_SURAT_KET->getViewValue() ?></span>
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
