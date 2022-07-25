<?php

namespace PHPMaker2021\simrs;

// Page object
$Icd9Add = &$Page;
?>
<script>
var currentForm, currentPageID;
var ficd9add;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ficd9add = currentForm = new ew.Form("ficd9add", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "icd9")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.icd9)
        ew.vars.tables.icd9 = currentTable;
    ficd9add.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["deskripsi_panjang", [fields.deskripsi_panjang.visible && fields.deskripsi_panjang.required ? ew.Validators.required(fields.deskripsi_panjang.caption) : null], fields.deskripsi_panjang.isInvalid],
        ["deskripsi_pendek", [fields.deskripsi_pendek.visible && fields.deskripsi_pendek.required ? ew.Validators.required(fields.deskripsi_pendek.caption) : null], fields.deskripsi_pendek.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ficd9add,
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
    ficd9add.validate = function () {
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
    ficd9add.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ficd9add.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ficd9add");
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
<form name="ficd9add" id="ficd9add" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="icd9">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_icd9_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_icd9_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="icd9" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deskripsi_panjang->Visible) { // deskripsi_panjang ?>
    <div id="r_deskripsi_panjang" class="form-group row">
        <label id="elh_icd9_deskripsi_panjang" for="x_deskripsi_panjang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deskripsi_panjang->caption() ?><?= $Page->deskripsi_panjang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deskripsi_panjang->cellAttributes() ?>>
<span id="el_icd9_deskripsi_panjang">
<input type="<?= $Page->deskripsi_panjang->getInputTextType() ?>" data-table="icd9" data-field="x_deskripsi_panjang" name="x_deskripsi_panjang" id="x_deskripsi_panjang" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->deskripsi_panjang->getPlaceHolder()) ?>" value="<?= $Page->deskripsi_panjang->EditValue ?>"<?= $Page->deskripsi_panjang->editAttributes() ?> aria-describedby="x_deskripsi_panjang_help">
<?= $Page->deskripsi_panjang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deskripsi_panjang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deskripsi_pendek->Visible) { // deskripsi_pendek ?>
    <div id="r_deskripsi_pendek" class="form-group row">
        <label id="elh_icd9_deskripsi_pendek" for="x_deskripsi_pendek" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deskripsi_pendek->caption() ?><?= $Page->deskripsi_pendek->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deskripsi_pendek->cellAttributes() ?>>
<span id="el_icd9_deskripsi_pendek">
<input type="<?= $Page->deskripsi_pendek->getInputTextType() ?>" data-table="icd9" data-field="x_deskripsi_pendek" name="x_deskripsi_pendek" id="x_deskripsi_pendek" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->deskripsi_pendek->getPlaceHolder()) ?>" value="<?= $Page->deskripsi_pendek->EditValue ?>"<?= $Page->deskripsi_pendek->editAttributes() ?> aria-describedby="x_deskripsi_pendek_help">
<?= $Page->deskripsi_pendek->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deskripsi_pendek->getErrorMessage() ?></div>
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
    ew.addEventHandlers("icd9");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
