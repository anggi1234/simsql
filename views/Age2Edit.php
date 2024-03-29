<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$Age2Edit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fAGE2edit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fAGE2edit = currentForm = new ew.Form("fAGE2edit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "AGE2")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.AGE2)
        ew.vars.tables.AGE2 = currentTable;
    fAGE2edit.addFields([
        ["CAT", [fields.CAT.visible && fields.CAT.required ? ew.Validators.required(fields.CAT.caption) : null, ew.Validators.integer], fields.CAT.isInvalid],
        ["GROUP_ID", [fields.GROUP_ID.visible && fields.GROUP_ID.required ? ew.Validators.required(fields.GROUP_ID.caption) : null, ew.Validators.integer], fields.GROUP_ID.isInvalid],
        ["BAT_BAWAH", [fields.BAT_BAWAH.visible && fields.BAT_BAWAH.required ? ew.Validators.required(fields.BAT_BAWAH.caption) : null, ew.Validators.integer], fields.BAT_BAWAH.isInvalid],
        ["BAT_ATAS", [fields.BAT_ATAS.visible && fields.BAT_ATAS.required ? ew.Validators.required(fields.BAT_ATAS.caption) : null, ew.Validators.integer], fields.BAT_ATAS.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fAGE2edit,
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
    fAGE2edit.validate = function () {
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
    fAGE2edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fAGE2edit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fAGE2edit");
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
<form name="fAGE2edit" id="fAGE2edit" class="<?= $Page->FormClassName ?>" action="<?= HtmlEncode(GetUrl(CurrentPageName())) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="AGE2">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CAT->Visible) { // CAT ?>
    <div id="r_CAT" class="form-group row">
        <label id="elh_AGE2_CAT" for="x_CAT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CAT->caption() ?><?= $Page->CAT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CAT->cellAttributes() ?>>
<input type="<?= $Page->CAT->getInputTextType() ?>" data-table="AGE2" data-field="x_CAT" name="x_CAT" id="x_CAT" size="30" placeholder="<?= HtmlEncode($Page->CAT->getPlaceHolder()) ?>" value="<?= $Page->CAT->EditValue ?>"<?= $Page->CAT->editAttributes() ?> aria-describedby="x_CAT_help">
<?= $Page->CAT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CAT->getErrorMessage() ?></div>
<input type="hidden" data-table="AGE2" data-field="x_CAT" data-hidden="1" name="o_CAT" id="o_CAT" value="<?= HtmlEncode($Page->CAT->OldValue ?? $Page->CAT->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GROUP_ID->Visible) { // GROUP_ID ?>
    <div id="r_GROUP_ID" class="form-group row">
        <label id="elh_AGE2_GROUP_ID" for="x_GROUP_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GROUP_ID->caption() ?><?= $Page->GROUP_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GROUP_ID->cellAttributes() ?>>
<input type="<?= $Page->GROUP_ID->getInputTextType() ?>" data-table="AGE2" data-field="x_GROUP_ID" name="x_GROUP_ID" id="x_GROUP_ID" size="30" placeholder="<?= HtmlEncode($Page->GROUP_ID->getPlaceHolder()) ?>" value="<?= $Page->GROUP_ID->EditValue ?>"<?= $Page->GROUP_ID->editAttributes() ?> aria-describedby="x_GROUP_ID_help">
<?= $Page->GROUP_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GROUP_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="AGE2" data-field="x_GROUP_ID" data-hidden="1" name="o_GROUP_ID" id="o_GROUP_ID" value="<?= HtmlEncode($Page->GROUP_ID->OldValue ?? $Page->GROUP_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BAT_BAWAH->Visible) { // BAT_BAWAH ?>
    <div id="r_BAT_BAWAH" class="form-group row">
        <label id="elh_AGE2_BAT_BAWAH" for="x_BAT_BAWAH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BAT_BAWAH->caption() ?><?= $Page->BAT_BAWAH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAT_BAWAH->cellAttributes() ?>>
<span id="el_AGE2_BAT_BAWAH">
<input type="<?= $Page->BAT_BAWAH->getInputTextType() ?>" data-table="AGE2" data-field="x_BAT_BAWAH" name="x_BAT_BAWAH" id="x_BAT_BAWAH" size="30" placeholder="<?= HtmlEncode($Page->BAT_BAWAH->getPlaceHolder()) ?>" value="<?= $Page->BAT_BAWAH->EditValue ?>"<?= $Page->BAT_BAWAH->editAttributes() ?> aria-describedby="x_BAT_BAWAH_help">
<?= $Page->BAT_BAWAH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BAT_BAWAH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BAT_ATAS->Visible) { // BAT_ATAS ?>
    <div id="r_BAT_ATAS" class="form-group row">
        <label id="elh_AGE2_BAT_ATAS" for="x_BAT_ATAS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BAT_ATAS->caption() ?><?= $Page->BAT_ATAS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAT_ATAS->cellAttributes() ?>>
<span id="el_AGE2_BAT_ATAS">
<input type="<?= $Page->BAT_ATAS->getInputTextType() ?>" data-table="AGE2" data-field="x_BAT_ATAS" name="x_BAT_ATAS" id="x_BAT_ATAS" size="30" placeholder="<?= HtmlEncode($Page->BAT_ATAS->getPlaceHolder()) ?>" value="<?= $Page->BAT_ATAS->EditValue ?>"<?= $Page->BAT_ATAS->editAttributes() ?> aria-describedby="x_BAT_ATAS_help">
<?= $Page->BAT_ATAS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BAT_ATAS->getErrorMessage() ?></div>
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
    ew.addEventHandlers("AGE2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
