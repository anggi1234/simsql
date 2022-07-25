<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodGfEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOOD_GFedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fGOOD_GFedit = currentForm = new ew.Form("fGOOD_GFedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOOD_GF)
        ew.vars.tables.GOOD_GF = currentTable;
    fGOOD_GFedit.addFields([
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["ALLOCATED_DATE", [fields.ALLOCATED_DATE.visible && fields.ALLOCATED_DATE.required ? ew.Validators.required(fields.ALLOCATED_DATE.caption) : null, ew.Validators.datetime(0)], fields.ALLOCATED_DATE.isInvalid],
        ["STOCKOPNAME_DATE", [fields.STOCKOPNAME_DATE.visible && fields.STOCKOPNAME_DATE.required ? ew.Validators.required(fields.STOCKOPNAME_DATE.caption) : null, ew.Validators.datetime(0)], fields.STOCKOPNAME_DATE.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["BRAND_NAME", [fields.BRAND_NAME.visible && fields.BRAND_NAME.required ? ew.Validators.required(fields.BRAND_NAME.caption) : null], fields.BRAND_NAME.isInvalid],
        ["idx", [fields.idx.visible && fields.idx.required ? ew.Validators.required(fields.idx.caption) : null], fields.idx.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOOD_GFedit,
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
    fGOOD_GFedit.validate = function () {
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
    fGOOD_GFedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOOD_GFedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fGOOD_GFedit.lists.BRAND_ID = <?= $Page->BRAND_ID->toClientList($Page) ?>;
    loadjs.done("fGOOD_GFedit");
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
<form name="fGOOD_GFedit" id="fGOOD_GFedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "MUTATION_DOCS") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="MUTATION_DOCS">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ORG_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label id="elh_GOOD_GF_BRAND_ID" for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_ID->caption() ?><?= $Page->BRAND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_ID">
<?php $Page->BRAND_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list" aria-describedby="x_BRAND_ID_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_BRAND_ID"><?= EmptyValue(strval($Page->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->BRAND_ID->ReadOnly || $Page->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
<?= $Page->BRAND_ID->getCustomMessage() ?>
<?= $Page->BRAND_ID->Lookup->getParamTag($Page, "p_x_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x_BRAND_ID" id="x_BRAND_ID" value="<?= $Page->BRAND_ID->CurrentValue ?>"<?= $Page->BRAND_ID->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
    <div id="r_ROOMS_ID" class="form-group row">
        <label id="elh_GOOD_GF_ROOMS_ID" for="x_ROOMS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ROOMS_ID->caption() ?><?= $Page->ROOMS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ROOMS_ID->cellAttributes() ?>>
<?php if ($Page->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ROOMS_ID->getDisplayValue($Page->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_ROOMS_ID" name="x_ROOMS_ID" value="<?= HtmlEncode($Page->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_GOOD_GF_ROOMS_ID">
<input type="<?= $Page->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x_ROOMS_ID" id="x_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Page->ROOMS_ID->EditValue ?>"<?= $Page->ROOMS_ID->editAttributes() ?> aria-describedby="x_ROOMS_ID_help">
<?= $Page->ROOMS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
    <div id="r_ALLOCATED_DATE" class="form-group row">
        <label id="elh_GOOD_GF_ALLOCATED_DATE" for="x_ALLOCATED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ALLOCATED_DATE->caption() ?><?= $Page->ALLOCATED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_DATE">
<input type="<?= $Page->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x_ALLOCATED_DATE" id="x_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Page->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Page->ALLOCATED_DATE->EditValue ?>"<?= $Page->ALLOCATED_DATE->editAttributes() ?> aria-describedby="x_ALLOCATED_DATE_help">
<?= $Page->ALLOCATED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ALLOCATED_DATE->ReadOnly && !$Page->ALLOCATED_DATE->Disabled && !isset($Page->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Page->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFedit", "x_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
    <div id="r_STOCKOPNAME_DATE" class="form-group row">
        <label id="elh_GOOD_GF_STOCKOPNAME_DATE" for="x_STOCKOPNAME_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCKOPNAME_DATE->caption() ?><?= $Page->STOCKOPNAME_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCKOPNAME_DATE">
<input type="<?= $Page->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x_STOCKOPNAME_DATE" id="x_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Page->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Page->STOCKOPNAME_DATE->EditValue ?>"<?= $Page->STOCKOPNAME_DATE->editAttributes() ?> aria-describedby="x_STOCKOPNAME_DATE_help">
<?= $Page->STOCKOPNAME_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Page->STOCKOPNAME_DATE->ReadOnly && !$Page->STOCKOPNAME_DATE->Disabled && !isset($Page->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Page->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFedit", "x_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label id="elh_GOOD_GF_INVOICE_ID" for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?><?= $Page->INVOICE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_INVOICE_ID">
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?> aria-describedby="x_INVOICE_ID_help">
<?= $Page->INVOICE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
    <div id="r_BRAND_NAME" class="form-group row">
        <label id="elh_GOOD_GF_BRAND_NAME" for="x_BRAND_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_NAME->caption() ?><?= $Page->BRAND_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_NAME">
<input type="<?= $Page->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x_BRAND_NAME" id="x_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Page->BRAND_NAME->EditValue ?>"<?= $Page->BRAND_NAME->editAttributes() ?> aria-describedby="x_BRAND_NAME_help">
<?= $Page->BRAND_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BRAND_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idx->Visible) { // idx ?>
    <div id="r_idx" class="form-group row">
        <label id="elh_GOOD_GF_idx" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idx->caption() ?><?= $Page->idx->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idx->cellAttributes() ?>>
<span id="el_GOOD_GF_idx">
<span<?= $Page->idx->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idx->getDisplayValue($Page->idx->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="GOOD_GF" data-field="x_idx" data-hidden="1" name="x_idx" id="x_idx" value="<?= HtmlEncode($Page->idx->CurrentValue) ?>">
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
