<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$ClinicAddopt = &$Page;
?>
<script>
var currentForm, currentPageID;
var fCLINICaddopt;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "addopt";
    fCLINICaddopt = currentForm = new ew.Form("fCLINICaddopt", "addopt");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "CLINIC")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.CLINIC)
        ew.vars.tables.CLINIC = currentTable;
    fCLINICaddopt.addFields([
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["NAME_OF_CLINIC", [fields.NAME_OF_CLINIC.visible && fields.NAME_OF_CLINIC.required ? ew.Validators.required(fields.NAME_OF_CLINIC.caption) : null], fields.NAME_OF_CLINIC.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fCLINICaddopt,
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
    fCLINICaddopt.validate = function () {
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
        return true;
    }

    // Form_CustomValidate
    fCLINICaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fCLINICaddopt.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fCLINICaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fCLINICaddopt" id="fCLINICaddopt" class="ew-form ew-horizontal" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="CLINIC">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="CLINIC" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->NAME_OF_CLINIC->Visible) { // NAME_OF_CLINIC ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_NAME_OF_CLINIC"><?= $Page->NAME_OF_CLINIC->caption() ?><?= $Page->NAME_OF_CLINIC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->NAME_OF_CLINIC->getInputTextType() ?>" data-table="CLINIC" data-field="x_NAME_OF_CLINIC" name="x_NAME_OF_CLINIC" id="x_NAME_OF_CLINIC" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->NAME_OF_CLINIC->getPlaceHolder()) ?>" value="<?= $Page->NAME_OF_CLINIC->EditValue ?>"<?= $Page->NAME_OF_CLINIC->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->NAME_OF_CLINIC->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_ORG_ID"><?= $Page->ORG_ID->caption() ?><?= $Page->ORG_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->ORG_ID->getInputTextType() ?>" data-table="CLINIC" data-field="x_ORG_ID" name="x_ORG_ID" id="x_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_ID->getPlaceHolder()) ?>" value="<?= $Page->ORG_ID->EditValue ?>"<?= $Page->ORG_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ORG_ID->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("CLINIC");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
