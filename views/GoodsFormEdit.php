<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsFormEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOODS_FORMedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fGOODS_FORMedit = currentForm = new ew.Form("fGOODS_FORMedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOODS_FORM")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOODS_FORM)
        ew.vars.tables.GOODS_FORM = currentTable;
    fGOODS_FORMedit.addFields([
        ["FORM_ID", [fields.FORM_ID.visible && fields.FORM_ID.required ? ew.Validators.required(fields.FORM_ID.caption) : null, ew.Validators.integer], fields.FORM_ID.isInvalid],
        ["FORM_ID2", [fields.FORM_ID2.visible && fields.FORM_ID2.required ? ew.Validators.required(fields.FORM_ID2.caption) : null], fields.FORM_ID2.isInvalid],
        ["FORM_GOODS", [fields.FORM_GOODS.visible && fields.FORM_GOODS.required ? ew.Validators.required(fields.FORM_GOODS.caption) : null], fields.FORM_GOODS.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOODS_FORMedit,
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
    fGOODS_FORMedit.validate = function () {
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
    fGOODS_FORMedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOODS_FORMedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fGOODS_FORMedit");
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
<form name="fGOODS_FORMedit" id="fGOODS_FORMedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS_FORM">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
    <div id="r_FORM_ID" class="form-group row">
        <label id="elh_GOODS_FORM_FORM_ID" for="x_FORM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FORM_ID->caption() ?><?= $Page->FORM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FORM_ID->cellAttributes() ?>>
<input type="<?= $Page->FORM_ID->getInputTextType() ?>" data-table="GOODS_FORM" data-field="x_FORM_ID" name="x_FORM_ID" id="x_FORM_ID" size="30" placeholder="<?= HtmlEncode($Page->FORM_ID->getPlaceHolder()) ?>" value="<?= $Page->FORM_ID->EditValue ?>"<?= $Page->FORM_ID->editAttributes() ?> aria-describedby="x_FORM_ID_help">
<?= $Page->FORM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FORM_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="GOODS_FORM" data-field="x_FORM_ID" data-hidden="1" name="o_FORM_ID" id="o_FORM_ID" value="<?= HtmlEncode($Page->FORM_ID->OldValue ?? $Page->FORM_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FORM_ID2->Visible) { // FORM_ID2 ?>
    <div id="r_FORM_ID2" class="form-group row">
        <label id="elh_GOODS_FORM_FORM_ID2" for="x_FORM_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FORM_ID2->caption() ?><?= $Page->FORM_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FORM_ID2->cellAttributes() ?>>
<span id="el_GOODS_FORM_FORM_ID2">
<input type="<?= $Page->FORM_ID2->getInputTextType() ?>" data-table="GOODS_FORM" data-field="x_FORM_ID2" name="x_FORM_ID2" id="x_FORM_ID2" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->FORM_ID2->getPlaceHolder()) ?>" value="<?= $Page->FORM_ID2->EditValue ?>"<?= $Page->FORM_ID2->editAttributes() ?> aria-describedby="x_FORM_ID2_help">
<?= $Page->FORM_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FORM_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FORM_GOODS->Visible) { // FORM_GOODS ?>
    <div id="r_FORM_GOODS" class="form-group row">
        <label id="elh_GOODS_FORM_FORM_GOODS" for="x_FORM_GOODS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FORM_GOODS->caption() ?><?= $Page->FORM_GOODS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FORM_GOODS->cellAttributes() ?>>
<span id="el_GOODS_FORM_FORM_GOODS">
<input type="<?= $Page->FORM_GOODS->getInputTextType() ?>" data-table="GOODS_FORM" data-field="x_FORM_GOODS" name="x_FORM_GOODS" id="x_FORM_GOODS" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->FORM_GOODS->getPlaceHolder()) ?>" value="<?= $Page->FORM_GOODS->EditValue ?>"<?= $Page->FORM_GOODS->editAttributes() ?> aria-describedby="x_FORM_GOODS_help">
<?= $Page->FORM_GOODS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FORM_GOODS->getErrorMessage() ?></div>
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
    ew.addEventHandlers("GOODS_FORM");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
