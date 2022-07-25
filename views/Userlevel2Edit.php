<?php

namespace PHPMaker2021\simrs;

// Page object
$Userlevel2Edit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuserlevel2edit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fuserlevel2edit = currentForm = new ew.Form("fuserlevel2edit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "userlevel2")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.userlevel2)
        ew.vars.tables.userlevel2 = currentTable;
    fuserlevel2edit.addFields([
        ["UserLevelID", [fields.UserLevelID.visible && fields.UserLevelID.required ? ew.Validators.required(fields.UserLevelID.caption) : null, ew.Validators.integer], fields.UserLevelID.isInvalid],
        ["UserLevelName", [fields.UserLevelName.visible && fields.UserLevelName.required ? ew.Validators.required(fields.UserLevelName.caption) : null], fields.UserLevelName.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fuserlevel2edit,
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
    fuserlevel2edit.validate = function () {
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
    fuserlevel2edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserlevel2edit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fuserlevel2edit");
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
<form name="fuserlevel2edit" id="fuserlevel2edit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevel2">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->UserLevelID->Visible) { // UserLevelID ?>
    <div id="r_UserLevelID" class="form-group row">
        <label id="elh_userlevel2_UserLevelID" for="x_UserLevelID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelID->caption() ?><?= $Page->UserLevelID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UserLevelID->cellAttributes() ?>>
<input type="<?= $Page->UserLevelID->getInputTextType() ?>" data-table="userlevel2" data-field="x_UserLevelID" name="x_UserLevelID" id="x_UserLevelID" size="30" placeholder="<?= HtmlEncode($Page->UserLevelID->getPlaceHolder()) ?>" value="<?= $Page->UserLevelID->EditValue ?>"<?= $Page->UserLevelID->editAttributes() ?> aria-describedby="x_UserLevelID_help">
<?= $Page->UserLevelID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelID->getErrorMessage() ?></div>
<input type="hidden" data-table="userlevel2" data-field="x_UserLevelID" data-hidden="1" name="o_UserLevelID" id="o_UserLevelID" value="<?= HtmlEncode($Page->UserLevelID->OldValue ?? $Page->UserLevelID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UserLevelName->Visible) { // UserLevelName ?>
    <div id="r_UserLevelName" class="form-group row">
        <label id="elh_userlevel2_UserLevelName" for="x_UserLevelName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UserLevelName->caption() ?><?= $Page->UserLevelName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UserLevelName->cellAttributes() ?>>
<span id="el_userlevel2_UserLevelName">
<input type="<?= $Page->UserLevelName->getInputTextType() ?>" data-table="userlevel2" data-field="x_UserLevelName" name="x_UserLevelName" id="x_UserLevelName" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->UserLevelName->getPlaceHolder()) ?>" value="<?= $Page->UserLevelName->EditValue ?>"<?= $Page->UserLevelName->editAttributes() ?> aria-describedby="x_UserLevelName_help">
<?= $Page->UserLevelName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UserLevelName->getErrorMessage() ?></div>
</span>
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
    ew.addEventHandlers("userlevel2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
