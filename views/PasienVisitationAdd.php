<?php

namespace PHPMaker2021\simrs;

// Page object
$PasienVisitationAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPASIEN_VISITATIONadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fPASIEN_VISITATIONadd = currentForm = new ew.Form("fPASIEN_VISITATIONadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PASIEN_VISITATION")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PASIEN_VISITATION)
        ew.vars.tables.PASIEN_VISITATION = currentTable;
    fPASIEN_VISITATIONadd.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["VISITOR_ADDRESS", [fields.VISITOR_ADDRESS.visible && fields.VISITOR_ADDRESS.required ? ew.Validators.required(fields.VISITOR_ADDRESS.caption) : null], fields.VISITOR_ADDRESS.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null, ew.Validators.datetime(11)], fields.VISIT_DATE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null], fields.KELUAR_ID.isInvalid],
        ["IN_DATE", [fields.IN_DATE.visible && fields.IN_DATE.required ? ew.Validators.required(fields.IN_DATE.caption) : null, ew.Validators.datetime(11)], fields.IN_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null, ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPASIEN_VISITATIONadd,
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
    fPASIEN_VISITATIONadd.validate = function () {
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
    fPASIEN_VISITATIONadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPASIEN_VISITATIONadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fPASIEN_VISITATIONadd.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.GENDER = <?= $Page->GENDER->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.CLINIC_ID = <?= $Page->CLINIC_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.EMPLOYEE_ID = <?= $Page->EMPLOYEE_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.STATUS_PASIEN_ID = <?= $Page->STATUS_PASIEN_ID->toClientList($Page) ?>;
    fPASIEN_VISITATIONadd.lists.KELUAR_ID = <?= $Page->KELUAR_ID->toClientList($Page) ?>;
    loadjs.done("fPASIEN_VISITATIONadd");
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
<form name="fPASIEN_VISITATIONadd" id="fPASIEN_VISITATIONadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PASIEN_VISITATION">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
    <span id="el_PASIEN_VISITATION_ORG_UNIT_CODE">
    <input type="hidden" data-table="PASIEN_VISITATION" data-field="x_ORG_UNIT_CODE" data-hidden="1" data-page="1" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->CurrentValue) ?>">
    </span>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_PASIEN_VISITATION_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<?php $Page->NO_REGISTRATION->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list" aria-describedby="x_NO_REGISTRATION_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="PASIEN_VISITATION" data-field="x_NO_REGISTRATION" data-page="1" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_PASIEN_VISITATION_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIANTAR_OLEH">
<input type="<?= $Page->DIANTAR_OLEH->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_DIANTAR_OLEH" data-page="1" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->DIANTAR_OLEH->getPlaceHolder()) ?>" value="<?= $Page->DIANTAR_OLEH->EditValue ?>"<?= $Page->DIANTAR_OLEH->editAttributes() ?> aria-describedby="x_DIANTAR_OLEH_help">
<?= $Page->DIANTAR_OLEH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIANTAR_OLEH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_PASIEN_VISITATION_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_GENDER">
<template id="tp_x_GENDER">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="PASIEN_VISITATION" data-field="x_GENDER" name="x_GENDER" id="x_GENDER"<?= $Page->GENDER->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_GENDER" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_GENDER"
    name="x_GENDER"
    value="<?= HtmlEncode($Page->GENDER->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_GENDER"
    data-target="dsl_x_GENDER"
    data-repeatcolumn="5"
    class="form-control<?= $Page->GENDER->isInvalidClass() ?>"
    data-table="PASIEN_VISITATION"
    data-field="x_GENDER"
    data-page="1"
    data-value-separator="<?= $Page->GENDER->displayValueSeparatorAttribute() ?>"
    <?= $Page->GENDER->editAttributes() ?>>
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
<?= $Page->GENDER->Lookup->getParamTag($Page, "p_x_GENDER") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
    <div id="r_VISITOR_ADDRESS" class="form-group row">
        <label id="elh_PASIEN_VISITATION_VISITOR_ADDRESS" for="x_VISITOR_ADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISITOR_ADDRESS->caption() ?><?= $Page->VISITOR_ADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISITOR_ADDRESS">
<input type="<?= $Page->VISITOR_ADDRESS->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_VISITOR_ADDRESS" data-page="1" name="x_VISITOR_ADDRESS" id="x_VISITOR_ADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->VISITOR_ADDRESS->getPlaceHolder()) ?>" value="<?= $Page->VISITOR_ADDRESS->EditValue ?>"<?= $Page->VISITOR_ADDRESS->editAttributes() ?> aria-describedby="x_VISITOR_ADDRESS_help">
<?= $Page->VISITOR_ADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISITOR_ADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <div id="r_VISIT_DATE" class="form-group row">
        <label id="elh_PASIEN_VISITATION_VISIT_DATE" for="x_VISIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_DATE->caption() ?><?= $Page->VISIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_DATE">
<input type="<?= $Page->VISIT_DATE->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_VISIT_DATE" data-page="1" data-format="11" name="x_VISIT_DATE" id="x_VISIT_DATE" placeholder="<?= HtmlEncode($Page->VISIT_DATE->getPlaceHolder()) ?>" value="<?= $Page->VISIT_DATE->EditValue ?>"<?= $Page->VISIT_DATE->editAttributes() ?> aria-describedby="x_VISIT_DATE_help">
<?= $Page->VISIT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->VISIT_DATE->ReadOnly && !$Page->VISIT_DATE->Disabled && !isset($Page->VISIT_DATE->EditAttrs["readonly"]) && !isset($Page->VISIT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_VISITATIONadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_VISITATIONadd", "x_VISIT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLINIC_ID">
    <select
        id="x_CLINIC_ID"
        name="x_CLINIC_ID"
        class="form-control ew-select<?= $Page->CLINIC_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_CLINIC_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_CLINIC_ID"
        data-page="1"
        data-value-separator="<?= $Page->CLINIC_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>"
        <?= $Page->CLINIC_ID->editAttributes() ?>>
        <?= $Page->CLINIC_ID->selectOptionListHtml("x_CLINIC_ID") ?>
    </select>
    <?= $Page->CLINIC_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
<?= $Page->CLINIC_ID->Lookup->getParamTag($Page, "p_x_CLINIC_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_CLINIC_ID']"),
        options = { name: "x_CLINIC_ID", selectId: "PASIEN_VISITATION_x_CLINIC_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.CLINIC_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EMPLOYEE_ID">
    <select
        id="x_EMPLOYEE_ID"
        name="x_EMPLOYEE_ID"
        class="form-control ew-select<?= $Page->EMPLOYEE_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_EMPLOYEE_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_EMPLOYEE_ID"
        data-page="1"
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
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_EMPLOYEE_ID']"),
        options = { name: "x_EMPLOYEE_ID", selectId: "PASIEN_VISITATION_x_EMPLOYEE_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.EMPLOYEE_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_STATUS_PASIEN_ID">
    <select
        id="x_STATUS_PASIEN_ID"
        name="x_STATUS_PASIEN_ID"
        class="form-control ew-select<?= $Page->STATUS_PASIEN_ID->isInvalidClass() ?>"
        data-select2-id="PASIEN_VISITATION_x_STATUS_PASIEN_ID"
        data-table="PASIEN_VISITATION"
        data-field="x_STATUS_PASIEN_ID"
        data-page="1"
        data-value-separator="<?= $Page->STATUS_PASIEN_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>"
        <?= $Page->STATUS_PASIEN_ID->editAttributes() ?>>
        <?= $Page->STATUS_PASIEN_ID->selectOptionListHtml("x_STATUS_PASIEN_ID") ?>
    </select>
    <?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
<?= $Page->STATUS_PASIEN_ID->Lookup->getParamTag($Page, "p_x_STATUS_PASIEN_ID") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='PASIEN_VISITATION_x_STATUS_PASIEN_ID']"),
        options = { name: "x_STATUS_PASIEN_ID", selectId: "PASIEN_VISITATION_x_STATUS_PASIEN_ID", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.PASIEN_VISITATION.fields.STATUS_PASIEN_ID.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
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
        data-page="1"
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
<input type="<?= $Page->IN_DATE->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_IN_DATE" data-page="1" data-format="11" name="x_IN_DATE" id="x_IN_DATE" placeholder="<?= HtmlEncode($Page->IN_DATE->getPlaceHolder()) ?>" value="<?= $Page->IN_DATE->EditValue ?>"<?= $Page->IN_DATE->editAttributes() ?> aria-describedby="x_IN_DATE_help">
<?= $Page->IN_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IN_DATE->getErrorMessage() ?></div>
<?php if (!$Page->IN_DATE->ReadOnly && !$Page->IN_DATE->Disabled && !isset($Page->IN_DATE->EditAttrs["readonly"]) && !isset($Page->IN_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPASIEN_VISITATIONadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fPASIEN_VISITATIONadd", "x_IN_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
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
<input type="<?= $Page->AGEYEAR->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_AGEYEAR" data-page="1" name="x_AGEYEAR" id="x_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Page->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Page->AGEYEAR->EditValue ?>"<?= $Page->AGEYEAR->editAttributes() ?> aria-describedby="x_AGEYEAR_help">
<?= $Page->AGEYEAR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEYEAR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_PASIEN_VISITATION_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_TRANS_ID">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="PASIEN_VISITATION" data-field="x_TRANS_ID" data-page="1" name="x_TRANS_ID" id="x_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?> aria-describedby="x_TRANS_ID_help">
<?= $Page->TRANS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_BILL") {
            $firstActiveDetailTable = "TREATMENT_BILL";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_BILL") ?>" href="#tab_TREATMENT_BILL" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_BILL", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailAdd) {
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
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_BILL") {
            $firstActiveDetailTable = "TREATMENT_BILL";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_BILL") ?>" id="tab_TREATMENT_BILL"><!-- page* -->
<?php include_once "TreatmentBillGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("TREATMENT_AKOMODASI", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_AKOMODASI->DetailAdd) {
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
