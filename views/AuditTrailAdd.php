<?php

namespace PHPMaker2021\simrs;

// Page object
$AuditTrailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fAuditTrailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fAuditTrailadd = currentForm = new ew.Form("fAuditTrailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "AuditTrail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.AuditTrail)
        ew.vars.tables.AuditTrail = currentTable;
    fAuditTrailadd.addFields([
        ["DateTime", [fields.DateTime.visible && fields.DateTime.required ? ew.Validators.required(fields.DateTime.caption) : null, ew.Validators.datetime(0)], fields.DateTime.isInvalid],
        ["Script", [fields.Script.visible && fields.Script.required ? ew.Validators.required(fields.Script.caption) : null], fields.Script.isInvalid],
        ["User", [fields.User.visible && fields.User.required ? ew.Validators.required(fields.User.caption) : null], fields.User.isInvalid],
        ["_Action", [fields._Action.visible && fields._Action.required ? ew.Validators.required(fields._Action.caption) : null], fields._Action.isInvalid],
        ["_Table", [fields._Table.visible && fields._Table.required ? ew.Validators.required(fields._Table.caption) : null], fields._Table.isInvalid],
        ["Field", [fields.Field.visible && fields.Field.required ? ew.Validators.required(fields.Field.caption) : null], fields.Field.isInvalid],
        ["KeyValue", [fields.KeyValue.visible && fields.KeyValue.required ? ew.Validators.required(fields.KeyValue.caption) : null], fields.KeyValue.isInvalid],
        ["OldValue", [fields.OldValue.visible && fields.OldValue.required ? ew.Validators.required(fields.OldValue.caption) : null], fields.OldValue.isInvalid],
        ["NewValue", [fields.NewValue.visible && fields.NewValue.required ? ew.Validators.required(fields.NewValue.caption) : null], fields.NewValue.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fAuditTrailadd,
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
    fAuditTrailadd.validate = function () {
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
    fAuditTrailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fAuditTrailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fAuditTrailadd");
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
<form name="fAuditTrailadd" id="fAuditTrailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="AuditTrail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->DateTime->Visible) { // DateTime ?>
    <div id="r_DateTime" class="form-group row">
        <label id="elh_AuditTrail_DateTime" for="x_DateTime" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DateTime->caption() ?><?= $Page->DateTime->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DateTime->cellAttributes() ?>>
<span id="el_AuditTrail_DateTime">
<input type="<?= $Page->DateTime->getInputTextType() ?>" data-table="AuditTrail" data-field="x_DateTime" name="x_DateTime" id="x_DateTime" placeholder="<?= HtmlEncode($Page->DateTime->getPlaceHolder()) ?>" value="<?= $Page->DateTime->EditValue ?>"<?= $Page->DateTime->editAttributes() ?> aria-describedby="x_DateTime_help">
<?= $Page->DateTime->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DateTime->getErrorMessage() ?></div>
<?php if (!$Page->DateTime->ReadOnly && !$Page->DateTime->Disabled && !isset($Page->DateTime->EditAttrs["readonly"]) && !isset($Page->DateTime->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fAuditTrailadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fAuditTrailadd", "x_DateTime", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Script->Visible) { // Script ?>
    <div id="r_Script" class="form-group row">
        <label id="elh_AuditTrail_Script" for="x_Script" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Script->caption() ?><?= $Page->Script->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Script->cellAttributes() ?>>
<span id="el_AuditTrail_Script">
<input type="<?= $Page->Script->getInputTextType() ?>" data-table="AuditTrail" data-field="x_Script" name="x_Script" id="x_Script" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Script->getPlaceHolder()) ?>" value="<?= $Page->Script->EditValue ?>"<?= $Page->Script->editAttributes() ?> aria-describedby="x_Script_help">
<?= $Page->Script->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Script->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->User->Visible) { // User ?>
    <div id="r_User" class="form-group row">
        <label id="elh_AuditTrail_User" for="x_User" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User->caption() ?><?= $Page->User->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->User->cellAttributes() ?>>
<span id="el_AuditTrail_User">
<input type="<?= $Page->User->getInputTextType() ?>" data-table="AuditTrail" data-field="x_User" name="x_User" id="x_User" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->User->getPlaceHolder()) ?>" value="<?= $Page->User->EditValue ?>"<?= $Page->User->editAttributes() ?> aria-describedby="x_User_help">
<?= $Page->User->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Action->Visible) { // Action ?>
    <div id="r__Action" class="form-group row">
        <label id="elh_AuditTrail__Action" for="x__Action" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Action->caption() ?><?= $Page->_Action->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_Action->cellAttributes() ?>>
<span id="el_AuditTrail__Action">
<input type="<?= $Page->_Action->getInputTextType() ?>" data-table="AuditTrail" data-field="x__Action" name="x__Action" id="x__Action" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Action->getPlaceHolder()) ?>" value="<?= $Page->_Action->EditValue ?>"<?= $Page->_Action->editAttributes() ?> aria-describedby="x__Action_help">
<?= $Page->_Action->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Action->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Table->Visible) { // Table ?>
    <div id="r__Table" class="form-group row">
        <label id="elh_AuditTrail__Table" for="x__Table" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Table->caption() ?><?= $Page->_Table->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_Table->cellAttributes() ?>>
<span id="el_AuditTrail__Table">
<input type="<?= $Page->_Table->getInputTextType() ?>" data-table="AuditTrail" data-field="x__Table" name="x__Table" id="x__Table" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Table->getPlaceHolder()) ?>" value="<?= $Page->_Table->EditValue ?>"<?= $Page->_Table->editAttributes() ?> aria-describedby="x__Table_help">
<?= $Page->_Table->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Table->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Field->Visible) { // Field ?>
    <div id="r_Field" class="form-group row">
        <label id="elh_AuditTrail_Field" for="x_Field" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Field->caption() ?><?= $Page->Field->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Field->cellAttributes() ?>>
<span id="el_AuditTrail_Field">
<input type="<?= $Page->Field->getInputTextType() ?>" data-table="AuditTrail" data-field="x_Field" name="x_Field" id="x_Field" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Field->getPlaceHolder()) ?>" value="<?= $Page->Field->EditValue ?>"<?= $Page->Field->editAttributes() ?> aria-describedby="x_Field_help">
<?= $Page->Field->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Field->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KeyValue->Visible) { // KeyValue ?>
    <div id="r_KeyValue" class="form-group row">
        <label id="elh_AuditTrail_KeyValue" for="x_KeyValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KeyValue->caption() ?><?= $Page->KeyValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KeyValue->cellAttributes() ?>>
<span id="el_AuditTrail_KeyValue">
<textarea data-table="AuditTrail" data-field="x_KeyValue" name="x_KeyValue" id="x_KeyValue" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->KeyValue->getPlaceHolder()) ?>"<?= $Page->KeyValue->editAttributes() ?> aria-describedby="x_KeyValue_help"><?= $Page->KeyValue->EditValue ?></textarea>
<?= $Page->KeyValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KeyValue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->OldValue->Visible) { // OldValue ?>
    <div id="r_OldValue" class="form-group row">
        <label id="elh_AuditTrail_OldValue" for="x_OldValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OldValue->caption() ?><?= $Page->OldValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OldValue->cellAttributes() ?>>
<span id="el_AuditTrail_OldValue">
<textarea data-table="AuditTrail" data-field="x_OldValue" name="x_OldValue" id="x_OldValue" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->OldValue->getPlaceHolder()) ?>"<?= $Page->OldValue->editAttributes() ?> aria-describedby="x_OldValue_help"><?= $Page->OldValue->EditValue ?></textarea>
<?= $Page->OldValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OldValue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NewValue->Visible) { // NewValue ?>
    <div id="r_NewValue" class="form-group row">
        <label id="elh_AuditTrail_NewValue" for="x_NewValue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NewValue->caption() ?><?= $Page->NewValue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NewValue->cellAttributes() ?>>
<span id="el_AuditTrail_NewValue">
<textarea data-table="AuditTrail" data-field="x_NewValue" name="x_NewValue" id="x_NewValue" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->NewValue->getPlaceHolder()) ?>"<?= $Page->NewValue->editAttributes() ?> aria-describedby="x_NewValue_help"><?= $Page->NewValue->EditValue ?></textarea>
<?= $Page->NewValue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NewValue->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("AuditTrail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
