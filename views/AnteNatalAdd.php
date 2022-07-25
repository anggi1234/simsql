<?php

namespace PHPMaker2021\simrs;

// Page object
$AnteNatalAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTE_NATALadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fANTE_NATALadd = currentForm = new ew.Form("fANTE_NATALadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ANTE_NATAL")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ANTE_NATAL)
        ew.vars.tables.ANTE_NATAL = currentTable;
    fANTE_NATALadd.addFields([
        ["ANTE_NATAL", [fields.ANTE_NATAL.visible && fields.ANTE_NATAL.required ? ew.Validators.required(fields.ANTE_NATAL.caption) : null, ew.Validators.integer], fields.ANTE_NATAL.isInvalid],
        ["ANTENATAL", [fields.ANTENATAL.visible && fields.ANTENATAL.required ? ew.Validators.required(fields.ANTENATAL.caption) : null], fields.ANTENATAL.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fANTE_NATALadd,
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
    fANTE_NATALadd.validate = function () {
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
    fANTE_NATALadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fANTE_NATALadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fANTE_NATALadd");
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
<form name="fANTE_NATALadd" id="fANTE_NATALadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTE_NATAL">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
    <div id="r_ANTE_NATAL" class="form-group row">
        <label id="elh_ANTE_NATAL_ANTE_NATAL" for="x_ANTE_NATAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ANTE_NATAL->caption() ?><?= $Page->ANTE_NATAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el_ANTE_NATAL_ANTE_NATAL">
<input type="<?= $Page->ANTE_NATAL->getInputTextType() ?>" data-table="ANTE_NATAL" data-field="x_ANTE_NATAL" name="x_ANTE_NATAL" id="x_ANTE_NATAL" size="30" placeholder="<?= HtmlEncode($Page->ANTE_NATAL->getPlaceHolder()) ?>" value="<?= $Page->ANTE_NATAL->EditValue ?>"<?= $Page->ANTE_NATAL->editAttributes() ?> aria-describedby="x_ANTE_NATAL_help">
<?= $Page->ANTE_NATAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ANTE_NATAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ANTENATAL->Visible) { // ANTENATAL ?>
    <div id="r_ANTENATAL" class="form-group row">
        <label id="elh_ANTE_NATAL_ANTENATAL" for="x_ANTENATAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ANTENATAL->caption() ?><?= $Page->ANTENATAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ANTENATAL->cellAttributes() ?>>
<span id="el_ANTE_NATAL_ANTENATAL">
<input type="<?= $Page->ANTENATAL->getInputTextType() ?>" data-table="ANTE_NATAL" data-field="x_ANTENATAL" name="x_ANTENATAL" id="x_ANTENATAL" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ANTENATAL->getPlaceHolder()) ?>" value="<?= $Page->ANTENATAL->EditValue ?>"<?= $Page->ANTENATAL->editAttributes() ?> aria-describedby="x_ANTENATAL_help">
<?= $Page->ANTENATAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ANTENATAL->getErrorMessage() ?></div>
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
    ew.addEventHandlers("ANTE_NATAL");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
