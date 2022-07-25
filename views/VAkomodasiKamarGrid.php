<?php

namespace PHPMaker2021\simrs;

// Set up and run Grid object
$Grid = Container("VAkomodasiKamarGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_AKOMODASI_KAMARgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fV_AKOMODASI_KAMARgrid = new ew.Form("fV_AKOMODASI_KAMARgrid", "grid");
    fV_AKOMODASI_KAMARgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_AKOMODASI_KAMAR")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_AKOMODASI_KAMAR)
        ew.vars.tables.V_AKOMODASI_KAMAR = currentTable;
    fV_AKOMODASI_KAMARgrid.addFields([
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [fields.TREAT_DATE.visible && fields.TREAT_DATE.required ? ew.Validators.required(fields.TREAT_DATE.caption) : null, ew.Validators.datetime(11)], fields.TREAT_DATE.isInvalid],
        ["CLINIC_TYPE", [fields.CLINIC_TYPE.visible && fields.CLINIC_TYPE.required ? ew.Validators.required(fields.CLINIC_TYPE.caption) : null, ew.Validators.integer], fields.CLINIC_TYPE.isInvalid],
        ["sell_price", [fields.sell_price.visible && fields.sell_price.required ? ew.Validators.required(fields.sell_price.caption) : null, ew.Validators.float], fields.sell_price.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["amount_paid", [fields.amount_paid.visible && fields.amount_paid.required ? ew.Validators.required(fields.amount_paid.caption) : null, ew.Validators.float], fields.amount_paid.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["TAGIHAN", [fields.TAGIHAN.visible && fields.TAGIHAN.required ? ew.Validators.required(fields.TAGIHAN.caption) : null, ew.Validators.float], fields.TAGIHAN.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["EXIT_DATE", [fields.EXIT_DATE.visible && fields.EXIT_DATE.required ? ew.Validators.required(fields.EXIT_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXIT_DATE.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null, ew.Validators.integer], fields.BED_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null, ew.Validators.integer], fields.KELUAR_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_AKOMODASI_KAMARgrid,
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
    fV_AKOMODASI_KAMARgrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fV_AKOMODASI_KAMARgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "VISIT_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THENAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEADDRESS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TARIF_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREATMENT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TREAT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sell_price", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "amount_paid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AMOUNT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NOTA_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TAGIHAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "TRANS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EXIT_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BED_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KELUAR_ID", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fV_AKOMODASI_KAMARgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_AKOMODASI_KAMARgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fV_AKOMODASI_KAMARgrid.lists.NO_REGISTRATION = <?= $Grid->NO_REGISTRATION->toClientList($Grid) ?>;
    fV_AKOMODASI_KAMARgrid.lists.TARIF_ID = <?= $Grid->TARIF_ID->toClientList($Grid) ?>;
    fV_AKOMODASI_KAMARgrid.lists.CLINIC_ID = <?= $Grid->CLINIC_ID->toClientList($Grid) ?>;
    loadjs.done("fV_AKOMODASI_KAMARgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> V_AKOMODASI_KAMAR">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fV_AKOMODASI_KAMARgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_V_AKOMODASI_KAMAR" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_V_AKOMODASI_KAMARgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Grid->VISIT_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_VISIT_ID" class="V_AKOMODASI_KAMAR_VISIT_ID"><?= $Grid->renderSort($Grid->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="V_AKOMODASI_KAMAR_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Grid->THENAME->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_THENAME" class="V_AKOMODASI_KAMAR_THENAME"><?= $Grid->renderSort($Grid->THENAME) ?></div></th>
<?php } ?>
<?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Grid->THEADDRESS->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_THEADDRESS" class="V_AKOMODASI_KAMAR_THEADDRESS"><?= $Grid->renderSort($Grid->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Grid->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Grid->THEID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_THEID" class="V_AKOMODASI_KAMAR_THEID"><?= $Grid->renderSort($Grid->THEID) ?></div></th>
<?php } ?>
<?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <th data-name="TARIF_ID" class="<?= $Grid->TARIF_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TARIF_ID" class="V_AKOMODASI_KAMAR_TARIF_ID"><?= $Grid->renderSort($Grid->TARIF_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_CLINIC_ID" class="V_AKOMODASI_KAMAR_CLINIC_ID"><?= $Grid->renderSort($Grid->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <th data-name="TREATMENT" class="<?= $Grid->TREATMENT->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TREATMENT" class="V_AKOMODASI_KAMAR_TREATMENT"><?= $Grid->renderSort($Grid->TREATMENT) ?></div></th>
<?php } ?>
<?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th data-name="TREAT_DATE" class="<?= $Grid->TREAT_DATE->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_TREAT_DATE" class="V_AKOMODASI_KAMAR_TREAT_DATE"><?= $Grid->renderSort($Grid->TREAT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <th data-name="CLINIC_TYPE" class="<?= $Grid->CLINIC_TYPE->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="V_AKOMODASI_KAMAR_CLINIC_TYPE"><?= $Grid->renderSort($Grid->CLINIC_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <th data-name="sell_price" class="<?= $Grid->sell_price->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_sell_price" class="V_AKOMODASI_KAMAR_sell_price"><?= $Grid->renderSort($Grid->sell_price) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_QUANTITY" class="V_AKOMODASI_KAMAR_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <th data-name="amount_paid" class="<?= $Grid->amount_paid->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_amount_paid" class="V_AKOMODASI_KAMAR_amount_paid"><?= $Grid->renderSort($Grid->amount_paid) ?></div></th>
<?php } ?>
<?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <th data-name="AMOUNT" class="<?= $Grid->AMOUNT->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_AMOUNT" class="V_AKOMODASI_KAMAR_AMOUNT"><?= $Grid->renderSort($Grid->AMOUNT) ?></div></th>
<?php } ?>
<?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <th data-name="NOTA_NO" class="<?= $Grid->NOTA_NO->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_NOTA_NO" class="V_AKOMODASI_KAMAR_NOTA_NO"><?= $Grid->renderSort($Grid->NOTA_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <th data-name="TAGIHAN" class="<?= $Grid->TAGIHAN->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TAGIHAN" class="V_AKOMODASI_KAMAR_TAGIHAN"><?= $Grid->renderSort($Grid->TAGIHAN) ?></div></th>
<?php } ?>
<?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <th data-name="TRANS_ID" class="<?= $Grid->TRANS_ID->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_V_AKOMODASI_KAMAR_TRANS_ID" class="V_AKOMODASI_KAMAR_TRANS_ID"><?= $Grid->renderSort($Grid->TRANS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <th data-name="EXIT_DATE" class="<?= $Grid->EXIT_DATE->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_EXIT_DATE" class="V_AKOMODASI_KAMAR_EXIT_DATE"><?= $Grid->renderSort($Grid->EXIT_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Grid->BED_ID->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_BED_ID" class="V_AKOMODASI_KAMAR_BED_ID"><?= $Grid->renderSort($Grid->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Grid->KELUAR_ID->headerCellClass() ?>"><div id="elh_V_AKOMODASI_KAMAR_KELUAR_ID" class="V_AKOMODASI_KAMAR_KELUAR_ID"><?= $Grid->renderSort($Grid->KELUAR_ID) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_V_AKOMODASI_KAMAR", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Grid->VISIT_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_VISIT_ID" class="form-group">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_VISIT_ID" class="form-group">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_VISIT_ID" class="form-group">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<?= $Grid->VISIT_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Grid->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Grid->THENAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THENAME" class="form-group">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THENAME" class="form-group">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<?= $Grid->THENAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_THENAME" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_THENAME" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Grid->THEADDRESS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<?= $Grid->THEADDRESS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Grid->THEID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<?= $Grid->THEID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_THEID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_THEID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" <?= $Grid->TARIF_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TARIF_ID" class="form-group">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TARIF_ID" class="form-group">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<?= $Grid->TARIF_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Grid->CLINIC_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_ID" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="V_AKOMODASI_KAMAR_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="V_AKOMODASI_KAMAR"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Grid->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Grid->CLINIC_ID->editAttributes() ?>>
        <?= $Grid->CLINIC_ID->selectOptionListHtml("x{$Grid->RowIndex}_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
<?= $Grid->CLINIC_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_AKOMODASI_KAMAR_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "V_AKOMODASI_KAMAR_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_AKOMODASI_KAMAR.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_ID" class="form-group">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<?= $Grid->CLINIC_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" <?= $Grid->TREATMENT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TREATMENT" class="form-group">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<?= $Grid->TREATMENT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TREATMENT" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TREATMENT" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" <?= $Grid->TREAT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_AKOMODASI_KAMARgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TREAT_DATE" class="form-group">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_AKOMODASI_KAMARgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<?= $Grid->TREAT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" <?= $Grid->CLINIC_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="form-group">
<input type="<?= $Grid->CLINIC_TYPE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_TYPE->EditValue ?>"<?= $Grid->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="form-group">
<input type="<?= $Grid->CLINIC_TYPE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_TYPE->EditValue ?>"<?= $Grid->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_CLINIC_TYPE">
<span<?= $Grid->CLINIC_TYPE->viewAttributes() ?>>
<?= $Grid->CLINIC_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" <?= $Grid->sell_price->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_sell_price" class="form-group">
<input type="<?= $Grid->sell_price->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Grid->sell_price->getPlaceHolder()) ?>" value="<?= $Grid->sell_price->EditValue ?>"<?= $Grid->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sell_price->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sell_price" id="o<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_sell_price" class="form-group">
<input type="<?= $Grid->sell_price->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Grid->sell_price->getPlaceHolder()) ?>" value="<?= $Grid->sell_price->EditValue ?>"<?= $Grid->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sell_price->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_sell_price">
<span<?= $Grid->sell_price->viewAttributes() ?>>
<?= $Grid->sell_price->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_sell_price" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_sell_price" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Grid->QUANTITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<?= $Grid->QUANTITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_QUANTITY" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_QUANTITY" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" <?= $Grid->amount_paid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_amount_paid" class="form-group">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount_paid" id="o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_amount_paid" class="form-group">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_amount_paid">
<span<?= $Grid->amount_paid->viewAttributes() ?>>
<?= $Grid->amount_paid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_amount_paid" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_amount_paid" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" <?= $Grid->AMOUNT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_AMOUNT" class="form-group">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<?= $Grid->AMOUNT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_AMOUNT" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_AMOUNT" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" <?= $Grid->NOTA_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NOTA_NO" class="form-group">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<?= $Grid->NOTA_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" <?= $Grid->TAGIHAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TAGIHAN" class="form-group">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAGIHAN" id="o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TAGIHAN" class="form-group">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TAGIHAN">
<span<?= $Grid->TAGIHAN->viewAttributes() ?>>
<?= $Grid->TAGIHAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TAGIHAN" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TAGIHAN" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" <?= $Grid->TRANS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->TRANS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->TRANS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<?= $Grid->TRANS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" <?= $Grid->EXIT_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_EXIT_DATE" class="form-group">
<input type="<?= $Grid->EXIT_DATE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" placeholder="<?= HtmlEncode($Grid->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXIT_DATE->EditValue ?>"<?= $Grid->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXIT_DATE->ReadOnly && !$Grid->EXIT_DATE->Disabled && !isset($Grid->EXIT_DATE->EditAttrs["readonly"]) && !isset($Grid->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_AKOMODASI_KAMARgrid", "x<?= $Grid->RowIndex ?>_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EXIT_DATE" id="o<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_EXIT_DATE" class="form-group">
<input type="<?= $Grid->EXIT_DATE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" placeholder="<?= HtmlEncode($Grid->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXIT_DATE->EditValue ?>"<?= $Grid->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXIT_DATE->ReadOnly && !$Grid->EXIT_DATE->Disabled && !isset($Grid->EXIT_DATE->EditAttrs["readonly"]) && !isset($Grid->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_AKOMODASI_KAMARgrid", "x<?= $Grid->RowIndex ?>_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_EXIT_DATE">
<span<?= $Grid->EXIT_DATE->viewAttributes() ?>>
<?= $Grid->EXIT_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_EXIT_DATE" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_EXIT_DATE" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Grid->BED_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_BED_ID" class="form-group">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BED_ID" id="o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_BED_ID" class="form-group">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_BED_ID">
<span<?= $Grid->BED_ID->viewAttributes() ?>>
<?= $Grid->BED_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_BED_ID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_BED_ID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Grid->KELUAR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_KELUAR_ID" class="form-group">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KELUAR_ID" id="o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_KELUAR_ID" class="form-group">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_V_AKOMODASI_KAMAR_KELUAR_ID">
<span<?= $Grid->KELUAR_ID->viewAttributes() ?>>
<?= $Grid->KELUAR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_KELUAR_ID" id="fV_AKOMODASI_KAMARgrid$x<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->FormValue) ?>">
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" data-hidden="1" name="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_KELUAR_ID" id="fV_AKOMODASI_KAMARgrid$o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid","load"], function () {
    fV_AKOMODASI_KAMARgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_V_AKOMODASI_KAMAR", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_VISIT_ID" class="form-group V_AKOMODASI_KAMAR_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_VISIT_ID" class="form-group V_AKOMODASI_KAMAR_VISIT_ID">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_VISIT_ID" class="form-group V_AKOMODASI_KAMAR_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group V_AKOMODASI_KAMAR_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group V_AKOMODASI_KAMAR_NO_REGISTRATION">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_NO_REGISTRATION"><?= EmptyValue(strval($Grid->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->NO_REGISTRATION->ReadOnly || $Grid->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Grid->NO_REGISTRATION->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= $Grid->NO_REGISTRATION->CurrentValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="form-group V_AKOMODASI_KAMAR_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THENAME" class="form-group V_AKOMODASI_KAMAR_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THENAME" class="form-group V_AKOMODASI_KAMAR_THENAME">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THENAME" class="form-group V_AKOMODASI_KAMAR_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THEADDRESS" class="form-group V_AKOMODASI_KAMAR_THEADDRESS">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THEADDRESS" class="form-group V_AKOMODASI_KAMAR_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THEID" class="form-group V_AKOMODASI_KAMAR_THEID">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_THEID" class="form-group V_AKOMODASI_KAMAR_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TARIF_ID" class="form-group V_AKOMODASI_KAMAR_TARIF_ID">
<?php $Grid->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_TARIF_ID"><?= EmptyValue(strval($Grid->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->TARIF_ID->ReadOnly || $Grid->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->TARIF_ID->getErrorMessage() ?></div>
<?= $Grid->TARIF_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= $Grid->TARIF_ID->CurrentValue ?>"<?= $Grid->TARIF_ID->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TARIF_ID" class="form-group V_AKOMODASI_KAMAR_TARIF_ID">
<span<?= $Grid->TARIF_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TARIF_ID->getDisplayValue($Grid->TARIF_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TARIF_ID" id="x<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TARIF_ID" id="o<?= $Grid->RowIndex ?>_TARIF_ID" value="<?= HtmlEncode($Grid->TARIF_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_CLINIC_ID" class="form-group V_AKOMODASI_KAMAR_CLINIC_ID">
    <select
        id="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        name="x<?= $Grid->RowIndex ?>_CLINIC_ID"
        class="form-control ew-select<?= $Grid->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="V_AKOMODASI_KAMAR_x<?= $Grid->RowIndex ?>_CLINIC_ID"
        data-table="V_AKOMODASI_KAMAR"
        data-field="x_CLINIC_ID"
        data-value-separator="<?= $Grid->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Grid->CLINIC_ID->editAttributes() ?>>
        <?= $Grid->CLINIC_ID->selectOptionListHtml("x{$Grid->RowIndex}_CLINIC_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
<?= $Grid->CLINIC_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='V_AKOMODASI_KAMAR_x<?= $Grid->RowIndex ?>_CLINIC_ID']"),
        options = { name: "x<?= $Grid->RowIndex ?>_CLINIC_ID", selectId: "V_AKOMODASI_KAMAR_x<?= $Grid->RowIndex ?>_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.V_AKOMODASI_KAMAR.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_CLINIC_ID" class="form-group V_AKOMODASI_KAMAR_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TREATMENT" class="form-group V_AKOMODASI_KAMAR_TREATMENT">
<input type="<?= $Grid->TREATMENT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->TREATMENT->getPlaceHolder()) ?>" value="<?= $Grid->TREATMENT->EditValue ?>"<?= $Grid->TREATMENT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREATMENT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TREATMENT" class="form-group V_AKOMODASI_KAMAR_TREATMENT">
<span<?= $Grid->TREATMENT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREATMENT->getDisplayValue($Grid->TREATMENT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREATMENT" id="x<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREATMENT" id="o<?= $Grid->RowIndex ?>_TREATMENT" value="<?= HtmlEncode($Grid->TREATMENT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TREAT_DATE" class="form-group V_AKOMODASI_KAMAR_TREAT_DATE">
<input type="<?= $Grid->TREAT_DATE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-format="11" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" placeholder="<?= HtmlEncode($Grid->TREAT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->TREAT_DATE->EditValue ?>"<?= $Grid->TREAT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TREAT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->TREAT_DATE->ReadOnly && !$Grid->TREAT_DATE->Disabled && !isset($Grid->TREAT_DATE->EditAttrs["readonly"]) && !isset($Grid->TREAT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_AKOMODASI_KAMARgrid", "x<?= $Grid->RowIndex ?>_TREAT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TREAT_DATE" class="form-group V_AKOMODASI_KAMAR_TREAT_DATE">
<span<?= $Grid->TREAT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TREAT_DATE->getDisplayValue($Grid->TREAT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TREAT_DATE" id="x<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TREAT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TREAT_DATE" id="o<?= $Grid->RowIndex ?>_TREAT_DATE" value="<?= HtmlEncode($Grid->TREAT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="form-group V_AKOMODASI_KAMAR_CLINIC_TYPE">
<input type="<?= $Grid->CLINIC_TYPE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->CLINIC_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_TYPE->EditValue ?>"<?= $Grid->CLINIC_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="form-group V_AKOMODASI_KAMAR_CLINIC_TYPE">
<span<?= $Grid->CLINIC_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_TYPE->getDisplayValue($Grid->CLINIC_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="x<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" id="o<?= $Grid->RowIndex ?>_CLINIC_TYPE" value="<?= HtmlEncode($Grid->CLINIC_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_sell_price" class="form-group V_AKOMODASI_KAMAR_sell_price">
<input type="<?= $Grid->sell_price->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" size="30" placeholder="<?= HtmlEncode($Grid->sell_price->getPlaceHolder()) ?>" value="<?= $Grid->sell_price->EditValue ?>"<?= $Grid->sell_price->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sell_price->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_sell_price" class="form-group V_AKOMODASI_KAMAR_sell_price">
<span<?= $Grid->sell_price->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sell_price->getDisplayValue($Grid->sell_price->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sell_price" id="x<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_sell_price" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sell_price" id="o<?= $Grid->RowIndex ?>_sell_price" value="<?= HtmlEncode($Grid->sell_price->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_QUANTITY" class="form-group V_AKOMODASI_KAMAR_QUANTITY">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_QUANTITY" class="form-group V_AKOMODASI_KAMAR_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY->getDisplayValue($Grid->QUANTITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_amount_paid" class="form-group V_AKOMODASI_KAMAR_amount_paid">
<input type="<?= $Grid->amount_paid->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" size="30" placeholder="<?= HtmlEncode($Grid->amount_paid->getPlaceHolder()) ?>" value="<?= $Grid->amount_paid->EditValue ?>"<?= $Grid->amount_paid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount_paid->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_amount_paid" class="form-group V_AKOMODASI_KAMAR_amount_paid">
<span<?= $Grid->amount_paid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->amount_paid->getDisplayValue($Grid->amount_paid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amount_paid" id="x<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_amount_paid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount_paid" id="o<?= $Grid->RowIndex ?>_amount_paid" value="<?= HtmlEncode($Grid->amount_paid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_AMOUNT" class="form-group V_AKOMODASI_KAMAR_AMOUNT">
<input type="<?= $Grid->AMOUNT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" size="30" placeholder="<?= HtmlEncode($Grid->AMOUNT->getPlaceHolder()) ?>" value="<?= $Grid->AMOUNT->EditValue ?>"<?= $Grid->AMOUNT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AMOUNT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_AMOUNT" class="form-group V_AKOMODASI_KAMAR_AMOUNT">
<span<?= $Grid->AMOUNT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AMOUNT->getDisplayValue($Grid->AMOUNT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AMOUNT" id="x<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_AMOUNT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AMOUNT" id="o<?= $Grid->RowIndex ?>_AMOUNT" value="<?= HtmlEncode($Grid->AMOUNT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_NOTA_NO" class="form-group V_AKOMODASI_KAMAR_NOTA_NO">
<input type="<?= $Grid->NOTA_NO->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NOTA_NO->getPlaceHolder()) ?>" value="<?= $Grid->NOTA_NO->EditValue ?>"<?= $Grid->NOTA_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NOTA_NO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_NOTA_NO" class="form-group V_AKOMODASI_KAMAR_NOTA_NO">
<span<?= $Grid->NOTA_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NOTA_NO->getDisplayValue($Grid->NOTA_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NOTA_NO" id="x<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_NOTA_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NOTA_NO" id="o<?= $Grid->RowIndex ?>_NOTA_NO" value="<?= HtmlEncode($Grid->NOTA_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TAGIHAN" class="form-group V_AKOMODASI_KAMAR_TAGIHAN">
<input type="<?= $Grid->TAGIHAN->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" size="30" placeholder="<?= HtmlEncode($Grid->TAGIHAN->getPlaceHolder()) ?>" value="<?= $Grid->TAGIHAN->EditValue ?>"<?= $Grid->TAGIHAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TAGIHAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TAGIHAN" class="form-group V_AKOMODASI_KAMAR_TAGIHAN">
<span<?= $Grid->TAGIHAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TAGIHAN->getDisplayValue($Grid->TAGIHAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TAGIHAN" id="x<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TAGIHAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TAGIHAN" id="o<?= $Grid->RowIndex ?>_TAGIHAN" value="<?= HtmlEncode($Grid->TAGIHAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->TRANS_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group V_AKOMODASI_KAMAR_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group V_AKOMODASI_KAMAR_TRANS_ID">
<input type="<?= $Grid->TRANS_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Grid->TRANS_ID->EditValue ?>"<?= $Grid->TRANS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_TRANS_ID" class="form-group V_AKOMODASI_KAMAR_TRANS_ID">
<span<?= $Grid->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->TRANS_ID->getDisplayValue($Grid->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_TRANS_ID" id="x<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_TRANS_ID" id="o<?= $Grid->RowIndex ?>_TRANS_ID" value="<?= HtmlEncode($Grid->TRANS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_EXIT_DATE" class="form-group V_AKOMODASI_KAMAR_EXIT_DATE">
<input type="<?= $Grid->EXIT_DATE->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" placeholder="<?= HtmlEncode($Grid->EXIT_DATE->getPlaceHolder()) ?>" value="<?= $Grid->EXIT_DATE->EditValue ?>"<?= $Grid->EXIT_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EXIT_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->EXIT_DATE->ReadOnly && !$Grid->EXIT_DATE->Disabled && !isset($Grid->EXIT_DATE->EditAttrs["readonly"]) && !isset($Grid->EXIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fV_AKOMODASI_KAMARgrid", "x<?= $Grid->RowIndex ?>_EXIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_EXIT_DATE" class="form-group V_AKOMODASI_KAMAR_EXIT_DATE">
<span<?= $Grid->EXIT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EXIT_DATE->getDisplayValue($Grid->EXIT_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EXIT_DATE" id="x<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_EXIT_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EXIT_DATE" id="o<?= $Grid->RowIndex ?>_EXIT_DATE" value="<?= HtmlEncode($Grid->EXIT_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_BED_ID" class="form-group V_AKOMODASI_KAMAR_BED_ID">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_BED_ID" class="form-group V_AKOMODASI_KAMAR_BED_ID">
<span<?= $Grid->BED_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BED_ID->getDisplayValue($Grid->BED_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_BED_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BED_ID" id="o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_KELUAR_ID" class="form-group V_AKOMODASI_KAMAR_KELUAR_ID">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_V_AKOMODASI_KAMAR_KELUAR_ID" class="form-group V_AKOMODASI_KAMAR_KELUAR_ID">
<span<?= $Grid->KELUAR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KELUAR_ID->getDisplayValue($Grid->KELUAR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_KELUAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KELUAR_ID" id="o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fV_AKOMODASI_KAMARgrid","load"], function() {
    fV_AKOMODASI_KAMARgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
<?php
// Render aggregate row
$Grid->RowType = ROWTYPE_AGGREGATE;
$Grid->resetAttributes();
$Grid->renderRow();
?>
<?php if ($Grid->TotalRecords > 0 && $Grid->CurrentMode == "view") { ?>
<tfoot><!-- Table footer -->
    <tr class="ew-table-footer">
<?php
// Render list options
$Grid->renderListOptions();

// Render list options (footer, left)
$Grid->ListOptions->render("footer", "left");
?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" class="<?= $Grid->VISIT_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_VISIT_ID" class="V_AKOMODASI_KAMAR_VISIT_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_NO_REGISTRATION" class="V_AKOMODASI_KAMAR_NO_REGISTRATION">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" class="<?= $Grid->THENAME->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_THENAME" class="V_AKOMODASI_KAMAR_THENAME">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" class="<?= $Grid->THEADDRESS->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_THEADDRESS" class="V_AKOMODASI_KAMAR_THEADDRESS">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID" class="<?= $Grid->THEID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_THEID" class="V_AKOMODASI_KAMAR_THEID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TARIF_ID->Visible) { // TARIF_ID ?>
        <td data-name="TARIF_ID" class="<?= $Grid->TARIF_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TARIF_ID" class="V_AKOMODASI_KAMAR_TARIF_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_CLINIC_ID" class="V_AKOMODASI_KAMAR_CLINIC_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TREATMENT->Visible) { // TREATMENT ?>
        <td data-name="TREATMENT" class="<?= $Grid->TREATMENT->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TREATMENT" class="V_AKOMODASI_KAMAR_TREATMENT">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td data-name="TREAT_DATE" class="<?= $Grid->TREAT_DATE->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TREAT_DATE" class="V_AKOMODASI_KAMAR_TREAT_DATE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->CLINIC_TYPE->Visible) { // CLINIC_TYPE ?>
        <td data-name="CLINIC_TYPE" class="<?= $Grid->CLINIC_TYPE->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_CLINIC_TYPE" class="V_AKOMODASI_KAMAR_CLINIC_TYPE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->sell_price->Visible) { // sell_price ?>
        <td data-name="sell_price" class="<?= $Grid->sell_price->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_sell_price" class="V_AKOMODASI_KAMAR_sell_price">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" class="<?= $Grid->QUANTITY->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_QUANTITY" class="V_AKOMODASI_KAMAR_QUANTITY">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->amount_paid->Visible) { // amount_paid ?>
        <td data-name="amount_paid" class="<?= $Grid->amount_paid->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_amount_paid" class="V_AKOMODASI_KAMAR_amount_paid">
        <span class="ew-aggregate"><?= $Language->phrase("TOTAL") ?></span><span class="ew-aggregate-value">
        <?= $Grid->amount_paid->ViewValue ?></span>
        </span></td>
    <?php } ?>
    <?php if ($Grid->AMOUNT->Visible) { // AMOUNT ?>
        <td data-name="AMOUNT" class="<?= $Grid->AMOUNT->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_AMOUNT" class="V_AKOMODASI_KAMAR_AMOUNT">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->NOTA_NO->Visible) { // NOTA_NO ?>
        <td data-name="NOTA_NO" class="<?= $Grid->NOTA_NO->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_NOTA_NO" class="V_AKOMODASI_KAMAR_NOTA_NO">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TAGIHAN->Visible) { // TAGIHAN ?>
        <td data-name="TAGIHAN" class="<?= $Grid->TAGIHAN->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TAGIHAN" class="V_AKOMODASI_KAMAR_TAGIHAN">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->TRANS_ID->Visible) { // TRANS_ID ?>
        <td data-name="TRANS_ID" class="<?= $Grid->TRANS_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_TRANS_ID" class="V_AKOMODASI_KAMAR_TRANS_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <td data-name="EXIT_DATE" class="<?= $Grid->EXIT_DATE->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_EXIT_DATE" class="V_AKOMODASI_KAMAR_EXIT_DATE">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" class="<?= $Grid->BED_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_BED_ID" class="V_AKOMODASI_KAMAR_BED_ID">
        &nbsp;
        </span></td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" class="<?= $Grid->KELUAR_ID->footerCellClass() ?>"><span id="elf_V_AKOMODASI_KAMAR_KELUAR_ID" class="V_AKOMODASI_KAMAR_KELUAR_ID">
        &nbsp;
        </span></td>
    <?php } ?>
<?php
// Render list options (footer, right)
$Grid->ListOptions->render("footer", "right");
?>
    </tr>
</tfoot>
<?php } ?>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fV_AKOMODASI_KAMARgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
