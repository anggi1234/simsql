<?php

namespace PHPMaker2021\simrs;

// Set up and run Grid object
$Grid = Container("GoodGfGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOOD_GFgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fGOOD_GFgrid = new ew.Form("fGOOD_GFgrid", "grid");
    fGOOD_GFgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOOD_GF)
        ew.vars.tables.GOOD_GF = currentTable;
    fGOOD_GFgrid.addFields([
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
        var f = fGOOD_GFgrid,
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
    fGOOD_GFgrid.validate = function () {
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
    fGOOD_GFgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_CODE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORG_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ROOMS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "FROM_ROOMS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISOUTLET", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "QUANTITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MEASURE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DISTRIBUTION_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CONDITION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ALLOCATED_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCKOPNAME_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ITEM_ID_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_OPNAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOK_AWAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STOCK_KOREKSI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BRAND_NAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MONTH_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "YEAR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOC_NO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ORDER_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISCETAK", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fGOOD_GFgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOOD_GFgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fGOOD_GFgrid.lists.BRAND_ID = <?= $Grid->BRAND_ID->toClientList($Grid) ?>;
    loadjs.done("fGOOD_GFgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> GOOD_GF">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fGOOD_GFgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_GOOD_GF" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_GOOD_GFgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Grid->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_UNIT_CODE" class="GOOD_GF_ORG_UNIT_CODE"><?= $Grid->renderSort($Grid->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <th data-name="ORG_ID" class="<?= $Grid->ORG_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_ID" class="GOOD_GF_ORG_ID"><?= $Grid->renderSort($Grid->ORG_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <th data-name="BRAND_ID" class="<?= $Grid->BRAND_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_ID" class="GOOD_GF_BRAND_ID"><?= $Grid->renderSort($Grid->BRAND_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <th data-name="ROOMS_ID" class="<?= $Grid->ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ROOMS_ID" class="GOOD_GF_ROOMS_ID"><?= $Grid->renderSort($Grid->ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <th data-name="FROM_ROOMS_ID" class="<?= $Grid->FROM_ROOMS_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_FROM_ROOMS_ID" class="GOOD_GF_FROM_ROOMS_ID"><?= $Grid->renderSort($Grid->FROM_ROOMS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <th data-name="ISOUTLET" class="<?= $Grid->ISOUTLET->headerCellClass() ?>"><div id="elh_GOOD_GF_ISOUTLET" class="GOOD_GF_ISOUTLET"><?= $Grid->renderSort($Grid->ISOUTLET) ?></div></th>
<?php } ?>
<?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <th data-name="QUANTITY" class="<?= $Grid->QUANTITY->headerCellClass() ?>"><div id="elh_GOOD_GF_QUANTITY" class="GOOD_GF_QUANTITY"><?= $Grid->renderSort($Grid->QUANTITY) ?></div></th>
<?php } ?>
<?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th data-name="MEASURE_ID" class="<?= $Grid->MEASURE_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MEASURE_ID" class="GOOD_GF_MEASURE_ID"><?= $Grid->renderSort($Grid->MEASURE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <th data-name="DISTRIBUTION_TYPE" class="<?= $Grid->DISTRIBUTION_TYPE->headerCellClass() ?>"><div id="elh_GOOD_GF_DISTRIBUTION_TYPE" class="GOOD_GF_DISTRIBUTION_TYPE"><?= $Grid->renderSort($Grid->DISTRIBUTION_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->CONDITION->Visible) { // CONDITION ?>
        <th data-name="CONDITION" class="<?= $Grid->CONDITION->headerCellClass() ?>"><div id="elh_GOOD_GF_CONDITION" class="GOOD_GF_CONDITION"><?= $Grid->renderSort($Grid->CONDITION) ?></div></th>
<?php } ?>
<?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <th data-name="ALLOCATED_DATE" class="<?= $Grid->ALLOCATED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_ALLOCATED_DATE" class="GOOD_GF_ALLOCATED_DATE"><?= $Grid->renderSort($Grid->ALLOCATED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <th data-name="STOCKOPNAME_DATE" class="<?= $Grid->STOCKOPNAME_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCKOPNAME_DATE" class="GOOD_GF_STOCKOPNAME_DATE"><?= $Grid->renderSort($Grid->STOCKOPNAME_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <th data-name="ORG_UNIT_FROM" class="<?= $Grid->ORG_UNIT_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ORG_UNIT_FROM" class="GOOD_GF_ORG_UNIT_FROM"><?= $Grid->renderSort($Grid->ORG_UNIT_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <th data-name="ITEM_ID_FROM" class="<?= $Grid->ITEM_ID_FROM->headerCellClass() ?>"><div id="elh_GOOD_GF_ITEM_ID_FROM" class="GOOD_GF_ITEM_ID_FROM"><?= $Grid->renderSort($Grid->ITEM_ID_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Grid->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_GOOD_GF_MODIFIED_DATE" class="GOOD_GF_MODIFIED_DATE"><?= $Grid->renderSort($Grid->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Grid->MODIFIED_BY->headerCellClass() ?>"><div id="elh_GOOD_GF_MODIFIED_BY" class="GOOD_GF_MODIFIED_BY"><?= $Grid->renderSort($Grid->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <th data-name="STOCK_OPNAME" class="<?= $Grid->STOCK_OPNAME->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_OPNAME" class="GOOD_GF_STOCK_OPNAME"><?= $Grid->renderSort($Grid->STOCK_OPNAME) ?></div></th>
<?php } ?>
<?php if ($Grid->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <th data-name="STOK_AWAL" class="<?= $Grid->STOK_AWAL->headerCellClass() ?>"><div id="elh_GOOD_GF_STOK_AWAL" class="GOOD_GF_STOK_AWAL"><?= $Grid->renderSort($Grid->STOK_AWAL) ?></div></th>
<?php } ?>
<?php if ($Grid->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <th data-name="STOCK_KOREKSI" class="<?= $Grid->STOCK_KOREKSI->headerCellClass() ?>"><div id="elh_GOOD_GF_STOCK_KOREKSI" class="GOOD_GF_STOCK_KOREKSI"><?= $Grid->renderSort($Grid->STOCK_KOREKSI) ?></div></th>
<?php } ?>
<?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th data-name="BRAND_NAME" class="<?= $Grid->BRAND_NAME->headerCellClass() ?>"><div id="elh_GOOD_GF_BRAND_NAME" class="GOOD_GF_BRAND_NAME"><?= $Grid->renderSort($Grid->BRAND_NAME) ?></div></th>
<?php } ?>
<?php if ($Grid->MONTH_ID->Visible) { // MONTH_ID ?>
        <th data-name="MONTH_ID" class="<?= $Grid->MONTH_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_MONTH_ID" class="GOOD_GF_MONTH_ID"><?= $Grid->renderSort($Grid->MONTH_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->YEAR_ID->Visible) { // YEAR_ID ?>
        <th data-name="YEAR_ID" class="<?= $Grid->YEAR_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_YEAR_ID" class="GOOD_GF_YEAR_ID"><?= $Grid->renderSort($Grid->YEAR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <th data-name="DOC_NO" class="<?= $Grid->DOC_NO->headerCellClass() ?>"><div id="elh_GOOD_GF_DOC_NO" class="GOOD_GF_DOC_NO"><?= $Grid->renderSort($Grid->DOC_NO) ?></div></th>
<?php } ?>
<?php if ($Grid->ORDER_ID->Visible) { // ORDER_ID ?>
        <th data-name="ORDER_ID" class="<?= $Grid->ORDER_ID->headerCellClass() ?>"><div id="elh_GOOD_GF_ORDER_ID" class="GOOD_GF_ORDER_ID"><?= $Grid->renderSort($Grid->ORDER_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <th data-name="ISCETAK" class="<?= $Grid->ISCETAK->headerCellClass() ?>"><div id="elh_GOOD_GF_ISCETAK" class="GOOD_GF_ISCETAK"><?= $Grid->renderSort($Grid->ISCETAK) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_GOOD_GF", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Grid->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_CODE" class="form-group">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->CurrentValue) ?>">
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_CODE" class="form-group">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID" <?= $Grid->ORG_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->ORG_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_ID->getDisplayValue($Grid->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<input type="<?= $Grid->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORG_ID->EditValue ?>"<?= $Grid->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_ID" id="o<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->ORG_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_ID->getDisplayValue($Grid->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID" class="form-group">
<input type="<?= $Grid->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORG_ID->EditValue ?>"<?= $Grid->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_ID">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<?= $Grid->ORG_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID" <?= $Grid->BRAND_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<?php $Grid->BRAND_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Grid->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->BRAND_ID->ReadOnly || $Grid->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
<?= $Grid->BRAND_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= $Grid->BRAND_ID->CurrentValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID" class="form-group">
<?php $Grid->BRAND_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Grid->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->BRAND_ID->ReadOnly || $Grid->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
<?= $Grid->BRAND_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= $Grid->BRAND_ID->CurrentValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_ID">
<span<?= $Grid->BRAND_ID->viewAttributes() ?>>
<?= $Grid->BRAND_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID" <?= $Grid->ROOMS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID" class="form-group">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ROOMS_ID">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<?= $Grid->ROOMS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ROOMS_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ROOMS_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td data-name="FROM_ROOMS_ID" <?= $Grid->FROM_ROOMS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->FROM_ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FROM_ROOMS_ID->getDisplayValue($Grid->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<input type="<?= $Grid->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->FROM_ROOMS_ID->EditValue ?>"<?= $Grid->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->FROM_ROOMS_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FROM_ROOMS_ID->getDisplayValue($Grid->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID" class="form-group">
<input type="<?= $Grid->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->FROM_ROOMS_ID->EditValue ?>"<?= $Grid->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_FROM_ROOMS_ID">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<?= $Grid->FROM_ROOMS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET" <?= $Grid->ISOUTLET->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISOUTLET" class="form-group">
<input type="<?= $Grid->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Grid->ISOUTLET->EditValue ?>"<?= $Grid->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISOUTLET->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISOUTLET" id="o<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISOUTLET" class="form-group">
<input type="<?= $Grid->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Grid->ISOUTLET->EditValue ?>"<?= $Grid->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISOUTLET->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISOUTLET">
<span<?= $Grid->ISOUTLET->viewAttributes() ?>>
<?= $Grid->ISOUTLET->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISOUTLET" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISOUTLET" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY" <?= $Grid->QUANTITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_QUANTITY" class="form-group">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<?= $Grid->QUANTITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_QUANTITY" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_QUANTITY" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID" <?= $Grid->MEASURE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID" class="form-group">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<?= $Grid->MEASURE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE" <?= $Grid->DISTRIBUTION_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE" class="form-group">
<input type="<?= $Grid->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUTION_TYPE->EditValue ?>"<?= $Grid->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE" class="form-group">
<input type="<?= $Grid->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUTION_TYPE->EditValue ?>"<?= $Grid->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Grid->DISTRIBUTION_TYPE->viewAttributes() ?>>
<?= $Grid->DISTRIBUTION_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CONDITION->Visible) { // CONDITION ?>
        <td data-name="CONDITION" <?= $Grid->CONDITION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CONDITION" class="form-group">
<input type="<?= $Grid->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Grid->CONDITION->getPlaceHolder()) ?>" value="<?= $Grid->CONDITION->EditValue ?>"<?= $Grid->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONDITION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CONDITION" id="o<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CONDITION" class="form-group">
<input type="<?= $Grid->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Grid->CONDITION->getPlaceHolder()) ?>" value="<?= $Grid->CONDITION->EditValue ?>"<?= $Grid->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONDITION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_CONDITION">
<span<?= $Grid->CONDITION->viewAttributes() ?>>
<?= $Grid->CONDITION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CONDITION" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CONDITION" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td data-name="ALLOCATED_DATE" <?= $Grid->ALLOCATED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="form-group">
<input type="<?= $Grid->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Grid->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_DATE->EditValue ?>"<?= $Grid->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ALLOCATED_DATE->ReadOnly && !$Grid->ALLOCATED_DATE->Disabled && !isset($Grid->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Grid->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_DATE" class="form-group">
<input type="<?= $Grid->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Grid->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_DATE->EditValue ?>"<?= $Grid->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ALLOCATED_DATE->ReadOnly && !$Grid->ALLOCATED_DATE->Disabled && !isset($Grid->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Grid->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ALLOCATED_DATE">
<span<?= $Grid->ALLOCATED_DATE->viewAttributes() ?>>
<?= $Grid->ALLOCATED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td data-name="STOCKOPNAME_DATE" <?= $Grid->STOCKOPNAME_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE" class="form-group">
<input type="<?= $Grid->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Grid->STOCKOPNAME_DATE->EditValue ?>"<?= $Grid->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->STOCKOPNAME_DATE->ReadOnly && !$Grid->STOCKOPNAME_DATE->Disabled && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE" class="form-group">
<input type="<?= $Grid->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Grid->STOCKOPNAME_DATE->EditValue ?>"<?= $Grid->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->STOCKOPNAME_DATE->ReadOnly && !$Grid->STOCKOPNAME_DATE->Disabled && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Grid->STOCKOPNAME_DATE->viewAttributes() ?>>
<?= $Grid->STOCKOPNAME_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td data-name="ORG_UNIT_FROM" <?= $Grid->ORG_UNIT_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_FROM" class="form-group">
<input type="<?= $Grid->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_FROM->EditValue ?>"<?= $Grid->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_FROM" class="form-group">
<input type="<?= $Grid->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_FROM->EditValue ?>"<?= $Grid->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORG_UNIT_FROM">
<span<?= $Grid->ORG_UNIT_FROM->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td data-name="ITEM_ID_FROM" <?= $Grid->ITEM_ID_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID_FROM" class="form-group">
<input type="<?= $Grid->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID_FROM->EditValue ?>"<?= $Grid->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID_FROM" class="form-group">
<input type="<?= $Grid->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID_FROM->EditValue ?>"<?= $Grid->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ITEM_ID_FROM">
<span<?= $Grid->ITEM_ID_FROM->viewAttributes() ?>>
<?= $Grid->ITEM_ID_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Grid->MODIFIED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<?= $Grid->MODIFIED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Grid->MODIFIED_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<?= $Grid->MODIFIED_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td data-name="STOCK_OPNAME" <?= $Grid->STOCK_OPNAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_OPNAME" class="form-group">
<input type="<?= $Grid->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_OPNAME->EditValue ?>"<?= $Grid->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_OPNAME" class="form-group">
<input type="<?= $Grid->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_OPNAME->EditValue ?>"<?= $Grid->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_OPNAME">
<span<?= $Grid->STOCK_OPNAME->viewAttributes() ?>>
<?= $Grid->STOCK_OPNAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td data-name="STOK_AWAL" <?= $Grid->STOK_AWAL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOK_AWAL" class="form-group">
<input type="<?= $Grid->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Grid->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Grid->STOK_AWAL->EditValue ?>"<?= $Grid->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOK_AWAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOK_AWAL" id="o<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOK_AWAL" class="form-group">
<input type="<?= $Grid->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Grid->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Grid->STOK_AWAL->EditValue ?>"<?= $Grid->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOK_AWAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOK_AWAL">
<span<?= $Grid->STOK_AWAL->viewAttributes() ?>>
<?= $Grid->STOK_AWAL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOK_AWAL" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOK_AWAL" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td data-name="STOCK_KOREKSI" <?= $Grid->STOCK_KOREKSI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_KOREKSI" class="form-group">
<input type="<?= $Grid->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_KOREKSI->EditValue ?>"<?= $Grid->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_KOREKSI" class="form-group">
<input type="<?= $Grid->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_KOREKSI->EditValue ?>"<?= $Grid->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_STOCK_KOREKSI">
<span<?= $Grid->STOCK_KOREKSI->viewAttributes() ?>>
<?= $Grid->STOCK_KOREKSI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME" <?= $Grid->BRAND_NAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_NAME" class="form-group">
<input type="<?= $Grid->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_NAME->EditValue ?>"<?= $Grid->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_NAME->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_NAME" id="o<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_NAME" class="form-group">
<input type="<?= $Grid->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_NAME->EditValue ?>"<?= $Grid->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_NAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_BRAND_NAME">
<span<?= $Grid->BRAND_NAME->viewAttributes() ?>>
<?= $Grid->BRAND_NAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_NAME" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_NAME" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID" <?= $Grid->MONTH_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MONTH_ID" class="form-group">
<input type="<?= $Grid->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Grid->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Grid->MONTH_ID->EditValue ?>"<?= $Grid->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MONTH_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MONTH_ID" id="o<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MONTH_ID" class="form-group">
<input type="<?= $Grid->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Grid->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Grid->MONTH_ID->EditValue ?>"<?= $Grid->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MONTH_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_MONTH_ID">
<span<?= $Grid->MONTH_ID->viewAttributes() ?>>
<?= $Grid->MONTH_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MONTH_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MONTH_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID" <?= $Grid->YEAR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_YEAR_ID" class="form-group">
<input type="<?= $Grid->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->YEAR_ID->EditValue ?>"<?= $Grid->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->YEAR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_YEAR_ID" id="o<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_YEAR_ID" class="form-group">
<input type="<?= $Grid->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->YEAR_ID->EditValue ?>"<?= $Grid->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->YEAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_YEAR_ID">
<span<?= $Grid->YEAR_ID->viewAttributes() ?>>
<?= $Grid->YEAR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_YEAR_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_YEAR_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <td data-name="DOC_NO" <?= $Grid->DOC_NO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->DOC_NO->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<input type="<?= $Grid->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOC_NO->getPlaceHolder()) ?>" value="<?= $Grid->DOC_NO->EditValue ?>"<?= $Grid->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOC_NO" id="o<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->DOC_NO->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO" class="form-group">
<input type="<?= $Grid->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOC_NO->getPlaceHolder()) ?>" value="<?= $Grid->DOC_NO->EditValue ?>"<?= $Grid->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_DOC_NO">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<?= $Grid->DOC_NO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DOC_NO" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DOC_NO" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ORDER_ID->Visible) { // ORDER_ID ?>
        <td data-name="ORDER_ID" <?= $Grid->ORDER_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_ID" class="form-group">
<input type="<?= $Grid->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_ID->EditValue ?>"<?= $Grid->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORDER_ID" id="o<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_ID" class="form-group">
<input type="<?= $Grid->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_ID->EditValue ?>"<?= $Grid->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ORDER_ID">
<span<?= $Grid->ORDER_ID->viewAttributes() ?>>
<?= $Grid->ORDER_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORDER_ID" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORDER_ID" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK" <?= $Grid->ISCETAK->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISCETAK" class="form-group">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_GOOD_GF_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<?= $Grid->ISCETAK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISCETAK" id="fGOOD_GFgrid$x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISCETAK" id="fGOOD_GFgrid$o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
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
loadjs.ready(["fGOOD_GFgrid","load"], function () {
    fGOOD_GFgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_GOOD_GF", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_CODE" class="form-group GOOD_GF_ORG_UNIT_CODE">
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->CurrentValue) ?>">
</span>
<?php } else { ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORG_ID->Visible) { // ORG_ID ?>
        <td data-name="ORG_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->ORG_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_GOOD_GF_ORG_ID" class="form-group GOOD_GF_ORG_ID">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_ID->getDisplayValue($Grid->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORG_ID" class="form-group GOOD_GF_ORG_ID">
<input type="<?= $Grid->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORG_ID->EditValue ?>"<?= $Grid->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORG_ID" class="form-group GOOD_GF_ORG_ID">
<span<?= $Grid->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_ID->getDisplayValue($Grid->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_ID" id="x<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_ID" id="o<?= $Grid->RowIndex ?>_ORG_ID" value="<?= HtmlEncode($Grid->ORG_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_ID->Visible) { // BRAND_ID ?>
        <td data-name="BRAND_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_ID" class="form-group GOOD_GF_BRAND_ID">
<?php $Grid->BRAND_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_BRAND_ID"><?= EmptyValue(strval($Grid->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->BRAND_ID->ReadOnly || $Grid->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->BRAND_ID->getErrorMessage() ?></div>
<?= $Grid->BRAND_ID->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Grid->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= $Grid->BRAND_ID->CurrentValue ?>"<?= $Grid->BRAND_ID->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_ID" class="form-group GOOD_GF_BRAND_ID">
<span<?= $Grid->BRAND_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BRAND_ID->getDisplayValue($Grid->BRAND_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BRAND_ID" id="x<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_ID" id="o<?= $Grid->RowIndex ?>_BRAND_ID" value="<?= HtmlEncode($Grid->BRAND_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ROOMS_ID->Visible) { // ROOMS_ID ?>
        <td data-name="ROOMS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<input type="<?= $Grid->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ROOMS_ID->EditValue ?>"<?= $Grid->ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ROOMS_ID" class="form-group GOOD_GF_ROOMS_ID">
<span<?= $Grid->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ROOMS_ID->getDisplayValue($Grid->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_ROOMS_ID" value="<?= HtmlEncode($Grid->ROOMS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
        <td data-name="FROM_ROOMS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->FROM_ROOMS_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_GOOD_GF_FROM_ROOMS_ID" class="form-group GOOD_GF_FROM_ROOMS_ID">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FROM_ROOMS_ID->getDisplayValue($Grid->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_FROM_ROOMS_ID" class="form-group GOOD_GF_FROM_ROOMS_ID">
<input type="<?= $Grid->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Grid->FROM_ROOMS_ID->EditValue ?>"<?= $Grid->FROM_ROOMS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_FROM_ROOMS_ID" class="form-group GOOD_GF_FROM_ROOMS_ID">
<span<?= $Grid->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FROM_ROOMS_ID->getDisplayValue($Grid->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="x<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" id="o<?= $Grid->RowIndex ?>_FROM_ROOMS_ID" value="<?= HtmlEncode($Grid->FROM_ROOMS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISOUTLET->Visible) { // ISOUTLET ?>
        <td data-name="ISOUTLET">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ISOUTLET" class="form-group GOOD_GF_ISOUTLET">
<input type="<?= $Grid->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Grid->ISOUTLET->EditValue ?>"<?= $Grid->ISOUTLET->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISOUTLET->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ISOUTLET" class="form-group GOOD_GF_ISOUTLET">
<span<?= $Grid->ISOUTLET->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISOUTLET->getDisplayValue($Grid->ISOUTLET->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISOUTLET" id="x<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISOUTLET" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISOUTLET" id="o<?= $Grid->RowIndex ?>_ISOUTLET" value="<?= HtmlEncode($Grid->ISOUTLET->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->QUANTITY->Visible) { // QUANTITY ?>
        <td data-name="QUANTITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_QUANTITY" class="form-group GOOD_GF_QUANTITY">
<input type="<?= $Grid->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" size="30" placeholder="<?= HtmlEncode($Grid->QUANTITY->getPlaceHolder()) ?>" value="<?= $Grid->QUANTITY->EditValue ?>"<?= $Grid->QUANTITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->QUANTITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_QUANTITY" class="form-group GOOD_GF_QUANTITY">
<span<?= $Grid->QUANTITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->QUANTITY->getDisplayValue($Grid->QUANTITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_QUANTITY" id="x<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_QUANTITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_QUANTITY" id="o<?= $Grid->RowIndex ?>_QUANTITY" value="<?= HtmlEncode($Grid->QUANTITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td data-name="MEASURE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID" class="form-group GOOD_GF_MEASURE_ID">
<input type="<?= $Grid->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Grid->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Grid->MEASURE_ID->EditValue ?>"<?= $Grid->MEASURE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MEASURE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MEASURE_ID" class="form-group GOOD_GF_MEASURE_ID">
<span<?= $Grid->MEASURE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MEASURE_ID->getDisplayValue($Grid->MEASURE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MEASURE_ID" id="x<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MEASURE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MEASURE_ID" id="o<?= $Grid->RowIndex ?>_MEASURE_ID" value="<?= HtmlEncode($Grid->MEASURE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
        <td data-name="DISTRIBUTION_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_DISTRIBUTION_TYPE" class="form-group GOOD_GF_DISTRIBUTION_TYPE">
<input type="<?= $Grid->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->DISTRIBUTION_TYPE->EditValue ?>"<?= $Grid->DISTRIBUTION_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DISTRIBUTION_TYPE" class="form-group GOOD_GF_DISTRIBUTION_TYPE">
<span<?= $Grid->DISTRIBUTION_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DISTRIBUTION_TYPE->getDisplayValue($Grid->DISTRIBUTION_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="x<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" id="o<?= $Grid->RowIndex ?>_DISTRIBUTION_TYPE" value="<?= HtmlEncode($Grid->DISTRIBUTION_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CONDITION->Visible) { // CONDITION ?>
        <td data-name="CONDITION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_CONDITION" class="form-group GOOD_GF_CONDITION">
<input type="<?= $Grid->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" size="30" placeholder="<?= HtmlEncode($Grid->CONDITION->getPlaceHolder()) ?>" value="<?= $Grid->CONDITION->EditValue ?>"<?= $Grid->CONDITION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CONDITION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_CONDITION" class="form-group GOOD_GF_CONDITION">
<span<?= $Grid->CONDITION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CONDITION->getDisplayValue($Grid->CONDITION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CONDITION" id="x<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_CONDITION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CONDITION" id="o<?= $Grid->RowIndex ?>_CONDITION" value="<?= HtmlEncode($Grid->CONDITION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
        <td data-name="ALLOCATED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ALLOCATED_DATE" class="form-group GOOD_GF_ALLOCATED_DATE">
<input type="<?= $Grid->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Grid->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ALLOCATED_DATE->EditValue ?>"<?= $Grid->ALLOCATED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ALLOCATED_DATE->ReadOnly && !$Grid->ALLOCATED_DATE->Disabled && !isset($Grid->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Grid->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ALLOCATED_DATE" class="form-group GOOD_GF_ALLOCATED_DATE">
<span<?= $Grid->ALLOCATED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ALLOCATED_DATE->getDisplayValue($Grid->ALLOCATED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="x<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" id="o<?= $Grid->RowIndex ?>_ALLOCATED_DATE" value="<?= HtmlEncode($Grid->ALLOCATED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
        <td data-name="STOCKOPNAME_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCKOPNAME_DATE" class="form-group GOOD_GF_STOCKOPNAME_DATE">
<input type="<?= $Grid->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Grid->STOCKOPNAME_DATE->EditValue ?>"<?= $Grid->STOCKOPNAME_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->STOCKOPNAME_DATE->ReadOnly && !$Grid->STOCKOPNAME_DATE->Disabled && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Grid->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFgrid", "x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCKOPNAME_DATE" class="form-group GOOD_GF_STOCKOPNAME_DATE">
<span<?= $Grid->STOCKOPNAME_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCKOPNAME_DATE->getDisplayValue($Grid->STOCKOPNAME_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="x<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" id="o<?= $Grid->RowIndex ?>_STOCKOPNAME_DATE" value="<?= HtmlEncode($Grid->STOCKOPNAME_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
        <td data-name="ORG_UNIT_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_FROM" class="form-group GOOD_GF_ORG_UNIT_FROM">
<input type="<?= $Grid->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_FROM->EditValue ?>"<?= $Grid->ORG_UNIT_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORG_UNIT_FROM" class="form-group GOOD_GF_ORG_UNIT_FROM">
<span<?= $Grid->ORG_UNIT_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_UNIT_FROM->getDisplayValue($Grid->ORG_UNIT_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_FROM" value="<?= HtmlEncode($Grid->ORG_UNIT_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
        <td data-name="ITEM_ID_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ITEM_ID_FROM" class="form-group GOOD_GF_ITEM_ID_FROM">
<input type="<?= $Grid->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Grid->ITEM_ID_FROM->EditValue ?>"<?= $Grid->ITEM_ID_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ITEM_ID_FROM" class="form-group GOOD_GF_ITEM_ID_FROM">
<span<?= $Grid->ITEM_ID_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ITEM_ID_FROM->getDisplayValue($Grid->ITEM_ID_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="x<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" id="o<?= $Grid->RowIndex ?>_ITEM_ID_FROM" value="<?= HtmlEncode($Grid->ITEM_ID_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MODIFIED_DATE" class="form-group GOOD_GF_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_DATE->getDisplayValue($Grid->MODIFIED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MODIFIED_BY" class="form-group GOOD_GF_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_BY->getDisplayValue($Grid->MODIFIED_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
        <td data-name="STOCK_OPNAME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_OPNAME" class="form-group GOOD_GF_STOCK_OPNAME">
<input type="<?= $Grid->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_OPNAME->EditValue ?>"<?= $Grid->STOCK_OPNAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_OPNAME" class="form-group GOOD_GF_STOCK_OPNAME">
<span<?= $Grid->STOCK_OPNAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_OPNAME->getDisplayValue($Grid->STOCK_OPNAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="x<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" id="o<?= $Grid->RowIndex ?>_STOCK_OPNAME" value="<?= HtmlEncode($Grid->STOCK_OPNAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOK_AWAL->Visible) { // STOK_AWAL ?>
        <td data-name="STOK_AWAL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOK_AWAL" class="form-group GOOD_GF_STOK_AWAL">
<input type="<?= $Grid->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Grid->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Grid->STOK_AWAL->EditValue ?>"<?= $Grid->STOK_AWAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOK_AWAL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOK_AWAL" class="form-group GOOD_GF_STOK_AWAL">
<span<?= $Grid->STOK_AWAL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOK_AWAL->getDisplayValue($Grid->STOK_AWAL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOK_AWAL" id="x<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOK_AWAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOK_AWAL" id="o<?= $Grid->RowIndex ?>_STOK_AWAL" value="<?= HtmlEncode($Grid->STOK_AWAL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
        <td data-name="STOCK_KOREKSI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_KOREKSI" class="form-group GOOD_GF_STOCK_KOREKSI">
<input type="<?= $Grid->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Grid->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Grid->STOCK_KOREKSI->EditValue ?>"<?= $Grid->STOCK_KOREKSI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_STOCK_KOREKSI" class="form-group GOOD_GF_STOCK_KOREKSI">
<span<?= $Grid->STOCK_KOREKSI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STOCK_KOREKSI->getDisplayValue($Grid->STOCK_KOREKSI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="x<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" id="o<?= $Grid->RowIndex ?>_STOCK_KOREKSI" value="<?= HtmlEncode($Grid->STOCK_KOREKSI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td data-name="BRAND_NAME">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_NAME" class="form-group GOOD_GF_BRAND_NAME">
<input type="<?= $Grid->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Grid->BRAND_NAME->EditValue ?>"<?= $Grid->BRAND_NAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BRAND_NAME->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_BRAND_NAME" class="form-group GOOD_GF_BRAND_NAME">
<span<?= $Grid->BRAND_NAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BRAND_NAME->getDisplayValue($Grid->BRAND_NAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BRAND_NAME" id="x<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_BRAND_NAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BRAND_NAME" id="o<?= $Grid->RowIndex ?>_BRAND_NAME" value="<?= HtmlEncode($Grid->BRAND_NAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MONTH_ID->Visible) { // MONTH_ID ?>
        <td data-name="MONTH_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_MONTH_ID" class="form-group GOOD_GF_MONTH_ID">
<input type="<?= $Grid->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Grid->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Grid->MONTH_ID->EditValue ?>"<?= $Grid->MONTH_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MONTH_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_MONTH_ID" class="form-group GOOD_GF_MONTH_ID">
<span<?= $Grid->MONTH_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MONTH_ID->getDisplayValue($Grid->MONTH_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MONTH_ID" id="x<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_MONTH_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MONTH_ID" id="o<?= $Grid->RowIndex ?>_MONTH_ID" value="<?= HtmlEncode($Grid->MONTH_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->YEAR_ID->Visible) { // YEAR_ID ?>
        <td data-name="YEAR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_YEAR_ID" class="form-group GOOD_GF_YEAR_ID">
<input type="<?= $Grid->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->YEAR_ID->EditValue ?>"<?= $Grid->YEAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->YEAR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_YEAR_ID" class="form-group GOOD_GF_YEAR_ID">
<span<?= $Grid->YEAR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->YEAR_ID->getDisplayValue($Grid->YEAR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_YEAR_ID" id="x<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_YEAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_YEAR_ID" id="o<?= $Grid->RowIndex ?>_YEAR_ID" value="<?= HtmlEncode($Grid->YEAR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DOC_NO->Visible) { // DOC_NO ?>
        <td data-name="DOC_NO">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->DOC_NO->getSessionValue() != "") { ?>
<span id="el$rowindex$_GOOD_GF_DOC_NO" class="form-group GOOD_GF_DOC_NO">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DOC_NO" class="form-group GOOD_GF_DOC_NO">
<input type="<?= $Grid->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DOC_NO->getPlaceHolder()) ?>" value="<?= $Grid->DOC_NO->EditValue ?>"<?= $Grid->DOC_NO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_DOC_NO" class="form-group GOOD_GF_DOC_NO">
<span<?= $Grid->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOC_NO->getDisplayValue($Grid->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOC_NO" id="x<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_DOC_NO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOC_NO" id="o<?= $Grid->RowIndex ?>_DOC_NO" value="<?= HtmlEncode($Grid->DOC_NO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ORDER_ID->Visible) { // ORDER_ID ?>
        <td data-name="ORDER_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ORDER_ID" class="form-group GOOD_GF_ORDER_ID">
<input type="<?= $Grid->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Grid->ORDER_ID->EditValue ?>"<?= $Grid->ORDER_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORDER_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ORDER_ID" class="form-group GOOD_GF_ORDER_ID">
<span<?= $Grid->ORDER_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORDER_ID->getDisplayValue($Grid->ORDER_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORDER_ID" id="x<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ORDER_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORDER_ID" id="o<?= $Grid->RowIndex ?>_ORDER_ID" value="<?= HtmlEncode($Grid->ORDER_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISCETAK->Visible) { // ISCETAK ?>
        <td data-name="ISCETAK">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_GOOD_GF_ISCETAK" class="form-group GOOD_GF_ISCETAK">
<input type="<?= $Grid->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISCETAK->getPlaceHolder()) ?>" value="<?= $Grid->ISCETAK->EditValue ?>"<?= $Grid->ISCETAK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISCETAK->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_GOOD_GF_ISCETAK" class="form-group GOOD_GF_ISCETAK">
<span<?= $Grid->ISCETAK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISCETAK->getDisplayValue($Grid->ISCETAK->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISCETAK" id="x<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="GOOD_GF" data-field="x_ISCETAK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISCETAK" id="o<?= $Grid->RowIndex ?>_ISCETAK" value="<?= HtmlEncode($Grid->ISCETAK->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fGOOD_GFgrid","load"], function() {
    fGOOD_GFgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
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
<input type="hidden" name="detailpage" value="fGOOD_GFgrid">
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
