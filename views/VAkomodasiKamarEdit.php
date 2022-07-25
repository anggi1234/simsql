<?php

namespace PHPMaker2021\simrs;

// Page object
$VAkomodasiKamarEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_AKOMODASI_KAMARedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fV_AKOMODASI_KAMARedit = currentForm = new ew.Form("fV_AKOMODASI_KAMARedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_AKOMODASI_KAMAR")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_AKOMODASI_KAMAR)
        ew.vars.tables.V_AKOMODASI_KAMAR = currentTable;
    fV_AKOMODASI_KAMARedit.addFields([
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_AKOMODASI_KAMARedit,
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
    fV_AKOMODASI_KAMARedit.validate = function () {
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
    fV_AKOMODASI_KAMARedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_AKOMODASI_KAMARedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fV_AKOMODASI_KAMARedit.lists.TARIF_ID = <?= $Page->TARIF_ID->toClientList($Page) ?>;
    loadjs.done("fV_AKOMODASI_KAMARedit");
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
<form name="fV_AKOMODASI_KAMARedit" id="fV_AKOMODASI_KAMARedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_AKOMODASI_KAMAR">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "V_KUNJUNGAN_PASIEN") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="V_KUNJUNGAN_PASIEN">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<input type="hidden" name="fk_DIANTAR_OLEH" value="<?= HtmlEncode($Page->THENAME->getSessionValue()) ?>">
<input type="hidden" name="fk_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
    <div id="r_TARIF_ID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_TARIF_ID" for="x_TARIF_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TARIF_ID->caption() ?><?= $Page->TARIF_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_TARIF_ID">
<?php $Page->TARIF_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list" aria-describedby="x_TARIF_ID_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_TARIF_ID"><?= EmptyValue(strval($Page->TARIF_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->TARIF_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->TARIF_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->TARIF_ID->ReadOnly || $Page->TARIF_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_TARIF_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->TARIF_ID->getErrorMessage() ?></div>
<?= $Page->TARIF_ID->getCustomMessage() ?>
<?= $Page->TARIF_ID->Lookup->getParamTag($Page, "p_x_TARIF_ID") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_TARIF_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->TARIF_ID->displayValueSeparatorAttribute() ?>" name="x_TARIF_ID" id="x_TARIF_ID" value="<?= $Page->TARIF_ID->CurrentValue ?>"<?= $Page->TARIF_ID->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_CLINIC_ID" data-hidden="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
    <div id="r_TREATMENT" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_TREATMENT" for="x_TREATMENT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TREATMENT->caption() ?><?= $Page->TREATMENT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_TREATMENT">
<input type="<?= $Page->TREATMENT->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TREATMENT" name="x_TREATMENT" id="x_TREATMENT" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->TREATMENT->getPlaceHolder()) ?>" value="<?= $Page->TREATMENT->EditValue ?>"<?= $Page->TREATMENT->editAttributes() ?> aria-describedby="x_TREATMENT_help">
<?= $Page->TREATMENT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TREATMENT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <div id="r_QUANTITY" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_QUANTITY" for="x_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->QUANTITY->caption() ?><?= $Page->QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_QUANTITY">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_QUANTITY" name="x_QUANTITY" id="x_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?> aria-describedby="x_QUANTITY_help">
<?= $Page->QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ID->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_AKOMODASI_KAMAR" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
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
    ew.addEventHandlers("V_AKOMODASI_KAMAR");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
