<?php

namespace PHPMaker2021\simrs;

// Page object
$TreatmentAkomodasiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_AKOMODASIedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fTREATMENT_AKOMODASIedit = currentForm = new ew.Form("fTREATMENT_AKOMODASIedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "TREATMENT_AKOMODASI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.TREATMENT_AKOMODASI)
        ew.vars.tables.TREATMENT_AKOMODASI = currentTable;
    fTREATMENT_AKOMODASIedit.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["TREAT_DATE", [fields.TREAT_DATE.visible && fields.TREAT_DATE.required ? ew.Validators.required(fields.TREAT_DATE.caption) : null], fields.TREAT_DATE.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null], fields.KELUAR_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null], fields.BED_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["NOTA_NO", [fields.NOTA_NO.visible && fields.NOTA_NO.required ? ew.Validators.required(fields.NOTA_NO.caption) : null], fields.NOTA_NO.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fTREATMENT_AKOMODASIedit,
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
    fTREATMENT_AKOMODASIedit.validate = function () {
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
    fTREATMENT_AKOMODASIedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fTREATMENT_AKOMODASIedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fTREATMENT_AKOMODASIedit.lists.CLASS_ROOM_ID = <?= $Page->CLASS_ROOM_ID->toClientList($Page) ?>;
    fTREATMENT_AKOMODASIedit.lists.KELUAR_ID = <?= $Page->KELUAR_ID->toClientList($Page) ?>;
    fTREATMENT_AKOMODASIedit.lists.BED_ID = <?= $Page->BED_ID->toClientList($Page) ?>;
    fTREATMENT_AKOMODASIedit.lists.EMPLOYEE_ID = <?= $Page->EMPLOYEE_ID->toClientList($Page) ?>;
    loadjs.done("fTREATMENT_AKOMODASIedit");
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
<form name="fTREATMENT_AKOMODASIedit" id="fTREATMENT_AKOMODASIedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_AKOMODASI">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "PASIEN_VISITATION") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="PASIEN_VISITATION">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_DIANTAR_OLEH" value="<?= HtmlEncode($Page->THENAME->getSessionValue()) ?>">
<input type="hidden" name="fk_VISITOR_ADDRESS" value="<?= HtmlEncode($Page->THEADDRESS->getSessionValue()) ?>">
<input type="hidden" name="fk_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_NO_REGISTRATION" data-hidden="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_ID->getDisplayValue($Page->VISIT_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_VISIT_ID" data-hidden="1" name="x_VISIT_ID" id="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_CLINIC_ID" data-hidden="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <div id="r_TREATMENT" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_TREATMENT" for="x_TREATMENT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREATMENT->caption() ?><?= $Page->TREATMENT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TREATMENT->getDisplayValue($Page->TREATMENT->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_TREATMENT" data-hidden="1" name="x_TREATMENT" id="x_TREATMENT" value="<?= HtmlEncode($Page->TREATMENT->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
    <div id="r_TREAT_DATE" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_TREAT_DATE" for="x_TREAT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREAT_DATE->caption() ?><?= $Page->TREAT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TREAT_DATE->getDisplayValue($Page->TREAT_DATE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_TREAT_DATE" data-hidden="1" name="x_TREAT_DATE" id="x_TREAT_DATE" value="<?= HtmlEncode($Page->TREAT_DATE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="TREATMENT_AKOMODASI" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <div id="r_CLASS_ROOM_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_CLASS_ROOM_ID" for="x_CLASS_ROOM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ROOM_ID->caption() ?><?= $Page->CLASS_ROOM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_CLASS_ROOM_ID">
<div class="input-group ew-lookup-list" aria-describedby="x_CLASS_ROOM_ID_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_CLASS_ROOM_ID"><?= EmptyValue(strval($Page->CLASS_ROOM_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->CLASS_ROOM_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->CLASS_ROOM_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->CLASS_ROOM_ID->ReadOnly || $Page->CLASS_ROOM_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_CLASS_ROOM_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage() ?></div>
<?= $Page->CLASS_ROOM_ID->getCustomMessage() ?>
<?= $Page->CLASS_ROOM_ID->Lookup->getParamTag($Page, "p_x_CLASS_ROOM_ID") ?>
<input type="hidden" is="selection-list" data-table="TREATMENT_AKOMODASI" data-field="x_CLASS_ROOM_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->CLASS_ROOM_ID->displayValueSeparatorAttribute() ?>" name="x_CLASS_ROOM_ID" id="x_CLASS_ROOM_ID" value="<?= $Page->CLASS_ROOM_ID->CurrentValue ?>"<?= $Page->CLASS_ROOM_ID->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_KELUAR_ID">
    <select
        id="x_KELUAR_ID"
        name="x_KELUAR_ID"
        class="form-control ew-select<?= $Page->KELUAR_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_AKOMODASI_x_KELUAR_ID"
        data-table="TREATMENT_AKOMODASI"
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
    var el = document.querySelector("select[data-select2-id='TREATMENT_AKOMODASI_x_KELUAR_ID']"),
        options = { name: "x_KELUAR_ID", selectId: "TREATMENT_AKOMODASI_x_KELUAR_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_AKOMODASI.fields.KELUAR_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <div id="r_BED_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_BED_ID" for="x_BED_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BED_ID->caption() ?><?= $Page->BED_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_BED_ID">
    <select
        id="x_BED_ID"
        name="x_BED_ID"
        class="form-control ew-select<?= $Page->BED_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_AKOMODASI_x_BED_ID"
        data-table="TREATMENT_AKOMODASI"
        data-field="x_BED_ID"
        data-value-separator="<?= $Page->BED_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->BED_ID->getPlaceHolder()) ?>"
        <?= $Page->BED_ID->editAttributes() ?>>
        <?= $Page->BED_ID->selectOptionListHtml("x_BED_ID") ?>
    </select>
    <?= $Page->BED_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->BED_ID->getErrorMessage() ?></div>
<?= $Page->BED_ID->Lookup->getParamTag($Page, "p_x_BED_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_AKOMODASI_x_BED_ID']"),
        options = { name: "x_BED_ID", selectId: "TREATMENT_AKOMODASI_x_BED_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_AKOMODASI.fields.BED_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_EMPLOYEE_ID">
    <select
        id="x_EMPLOYEE_ID"
        name="x_EMPLOYEE_ID"
        class="form-control ew-select<?= $Page->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="TREATMENT_AKOMODASI_x_EMPLOYEE_ID"
        data-table="TREATMENT_AKOMODASI"
        data-field="x_EMPLOYEE_ID"
        data-value-separator="<?= $Page->EMPLOYEE_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>"
        <?= $Page->EMPLOYEE_ID->editAttributes() ?>>
        <?= $Page->EMPLOYEE_ID->selectOptionListHtml("x_EMPLOYEE_ID") ?>
    </select>
    <?= $Page->EMPLOYEE_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage() ?></div>
<?= $Page->EMPLOYEE_ID->Lookup->getParamTag($Page, "p_x_EMPLOYEE_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='TREATMENT_AKOMODASI_x_EMPLOYEE_ID']"),
        options = { name: "x_EMPLOYEE_ID", selectId: "TREATMENT_AKOMODASI_x_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.TREATMENT_AKOMODASI.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<?php if ($Page->THENAME->getSessionValue() != "") { ?>
<span id="el_TREATMENT_AKOMODASI_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->THENAME->getDisplayValue($Page->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_THENAME" name="x_THENAME" value="<?= HtmlEncode($Page->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_TREATMENT_AKOMODASI_THENAME">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="TREATMENT_AKOMODASI" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?> aria-describedby="x_THENAME_help">
<?= $Page->THENAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_THEADDRESS" for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEADDRESS->caption() ?><?= $Page->THEADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
<?php if ($Page->THEADDRESS->getSessionValue() != "") { ?>
<span id="el_TREATMENT_AKOMODASI_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->THEADDRESS->getDisplayValue($Page->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_THEADDRESS" name="x_THEADDRESS" value="<?= HtmlEncode($Page->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_TREATMENT_AKOMODASI_THEADDRESS">
<input type="<?= $Page->THEADDRESS->getInputTextType() ?>" data-table="TREATMENT_AKOMODASI" data-field="x_THEADDRESS" name="x_THEADDRESS" id="x_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Page->THEADDRESS->EditValue ?>"<?= $Page->THEADDRESS->editAttributes() ?> aria-describedby="x_THEADDRESS_help">
<?= $Page->THEADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
    <div id="r_NOTA_NO" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_NOTA_NO" for="x_NOTA_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NOTA_NO->caption() ?><?= $Page->NOTA_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NOTA_NO->getDisplayValue($Page->NOTA_NO->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_NOTA_NO" data-hidden="1" name="x_NOTA_NO" id="x_NOTA_NO" value="<?= HtmlEncode($Page->NOTA_NO->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_TRANS_ID" data-hidden="1" name="x_TRANS_ID" id="x_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID" class="form-group row">
        <label id="elh_TREATMENT_AKOMODASI_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="TREATMENT_AKOMODASI" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("TREATMENT_AKOMODASI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
