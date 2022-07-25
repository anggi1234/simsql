<?php

namespace PHPMaker2021\simrs;

// Page object
$PasienVisitationEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPASIEN_VISITATIONedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fPASIEN_VISITATIONedit = currentForm = new ew.Form("fPASIEN_VISITATIONedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PASIEN_VISITATION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PASIEN_VISITATION)
        ew.vars.tables.PASIEN_VISITATION = currentTable;
    fPASIEN_VISITATIONedit.addFields([
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["VISITOR_ADDRESS", [fields.VISITOR_ADDRESS.visible && fields.VISITOR_ADDRESS.required ? ew.Validators.required(fields.VISITOR_ADDRESS.caption) : null], fields.VISITOR_ADDRESS.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null], fields.VISIT_DATE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null], fields.KELUAR_ID.isInvalid],
        ["IN_DATE", [fields.IN_DATE.visible && fields.IN_DATE.required ? ew.Validators.required(fields.IN_DATE.caption) : null, ew.Validators.datetime(11)], fields.IN_DATE.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null], fields.AGEYEAR.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPASIEN_VISITATIONedit,
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
    fPASIEN_VISITATIONedit.validate = function () {
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

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fPASIEN_VISITATIONedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPASIEN_VISITATIONedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fPASIEN_VISITATIONedit.lists.KELUAR_ID = <?= $Page->KELUAR_ID->toClientList($Page) ?>;
    loadjs.done("fPASIEN_VISITATIONedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPASIEN_VISITATIONedit" id="fPASIEN_VISITATIONedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PASIEN_VISITATION">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_ID->getDisplayValue($Page->VISIT_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_VISIT_ID" data-hidden="1" name="x_VISIT_ID" id="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_PASIEN_VISITATION_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_NO_REGISTRATION" data-hidden="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_PASIEN_VISITATION_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIANTAR_OLEH">
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DIANTAR_OLEH->getDisplayValue($Page->DIANTAR_OLEH->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_DIANTAR_OLEH" data-hidden="1" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" value="<?= HtmlEncode($Page->DIANTAR_OLEH->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_PASIEN_VISITATION_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->GENDER->getDisplayValue($Page->GENDER->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_GENDER" data-hidden="1" name="x_GENDER" id="x_GENDER" value="<?= HtmlEncode($Page->GENDER->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
    <div id="r_VISITOR_ADDRESS" class="form-group row">
        <label id="elh_PASIEN_VISITATION_VISITOR_ADDRESS" for="x_VISITOR_ADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISITOR_ADDRESS->caption() ?><?= $Page->VISITOR_ADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISITOR_ADDRESS">
<span<?= $Page->VISITOR_ADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISITOR_ADDRESS->getDisplayValue($Page->VISITOR_ADDRESS->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_VISITOR_ADDRESS" data-hidden="1" name="x_VISITOR_ADDRESS" id="x_VISITOR_ADDRESS" value="<?= HtmlEncode($Page->VISITOR_ADDRESS->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <div id="r_VISIT_DATE" class="form-group row">
        <label id="elh_PASIEN_VISITATION_VISIT_DATE" for="x_VISIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_DATE->caption() ?><?= $Page->VISIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_DATE">
<span<?= $Page->VISIT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_DATE->getDisplayValue($Page->VISIT_DATE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_VISIT_DATE" data-hidden="1" name="x_VISIT_DATE" id="x_VISIT_DATE" value="<?= HtmlEncode($Page->VISIT_DATE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_CLINIC_ID" data-hidden="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->EMPLOYEE_ID->getDisplayValue($Page->EMPLOYEE_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_EMPLOYEE_ID" data-hidden="1" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" value="<?= HtmlEncode($Page->EMPLOYEE_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->STATUS_PASIEN_ID->getDisplayValue($Page->STATUS_PASIEN_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" value="<?= HtmlEncode($Page->STATUS_PASIEN_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_KELUAR_ID">
    <select
        id="x_KELUAR_ID"
        name="x_KELUAR_ID"
        class="form-control ew-select<?= $Page->KELUAR_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_KELUAR_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_KELUAR_ID"
        data-value-separator="<?= $Page->KELUAR_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>"
        <?= $Page->KELUAR_ID->editAttributes() ?>>
        <?= $Page->KELUAR_ID->selectOptionListHtml("x_KELUAR_ID") ?>
    </select>
    <?= $Page->KELUAR_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage() ?></div>
<?= $Page->KELUAR_ID->Lookup->getParamTag($Page, "p_x_KELUAR_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_KELUAR_ID']"),
        options = { name: "x_KELUAR_ID", selectId: "PASIEN_VISITATION_x_KELUAR_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.KELUAR_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IN_DATE->Visible) { // IN_DATE ?>
    <div id="r_IN_DATE" class="form-group row">
        <label id="elh_PASIEN_VISITATION_IN_DATE" for="x_IN_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IN_DATE->caption() ?><?= $Page->IN_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->IN_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_IN_DATE">
<input type="<?= $Page->IN_DATE->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_IN_DATE" data-format="11" name="x_IN_DATE" id="x_IN_DATE" placeholder="<?= HtmlEncode($Page->IN_DATE->getPlaceHolder()) ?>" value="<?= $Page->IN_DATE->EditValue ?>"<?= $Page->IN_DATE->editAttributes() ?> aria-describedby="x_IN_DATE_help">
<?= $Page->IN_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IN_DATE->getErrorMessage() ?></div>
<?php if (!$Page->IN_DATE->ReadOnly && !$Page->IN_DATE->Disabled && !isset($Page->IN_DATE->EditAttrs["readonly"]) && !isset($Page->IN_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_VISITATIONedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_VISITATIONedit", "x_IN_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label id="elh_PASIEN_VISITATION_AGEYEAR" for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEYEAR->caption() ?><?= $Page->AGEYEAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->AGEYEAR->getDisplayValue($Page->AGEYEAR->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_AGEYEAR" data-hidden="1" name="x_AGEYEAR" id="x_AGEYEAR" value="<?= HtmlEncode($Page->AGEYEAR->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="PASIEN_VISITATION" data-field="x_TRANS_ID" data-hidden="1" name="x_TRANS_ID" id="x_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="PASIEN_VISITATION" data-field="x_IDXDAFTAR" data-hidden="1" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?= HtmlEncode($Page->IDXDAFTAR->CurrentValue) ?>">
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_BILL") {
            $firstActiveDetailTable = "TREATMENT_BILL";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_BILL") ?>" href="#tab_TREATMENT_BILL" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_BILL", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_AKOMODASI") {
            $firstActiveDetailTable = "TREATMENT_AKOMODASI";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_AKOMODASI") ?>" href="#tab_TREATMENT_AKOMODASI" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_AKOMODASI", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_BILL") {
            $firstActiveDetailTable = "TREATMENT_BILL";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_BILL") ?>" id="tab_TREATMENT_BILL"><!-- page* -->
<?php include_once "TreatmentBillGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_AKOMODASI") {
            $firstActiveDetailTable = "TREATMENT_AKOMODASI";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_AKOMODASI") ?>" id="tab_TREATMENT_AKOMODASI"><!-- page* -->
<?php include_once "TreatmentAkomodasiGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("PASIEN_VISITATION");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
