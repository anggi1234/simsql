<?php

namespace PHPMaker2021\simrs;

// Page object
$VAkomodasiKamarAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_AKOMODASI_KAMARadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fV_AKOMODASI_KAMARadd = currentForm = new ew.Form("fV_AKOMODASI_KAMARadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_AKOMODASI_KAMAR")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_AKOMODASI_KAMAR)
        ew.vars.tables.V_AKOMODASI_KAMAR = currentTable;
    fV_AKOMODASI_KAMARadd.addFields([
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["BILL_ID", [fields.BILL_ID.visible && fields.BILL_ID.required ? ew.Validators.required(fields.BILL_ID.caption) : null], fields.BILL_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["TARIF_ID", [fields.TARIF_ID.visible && fields.TARIF_ID.required ? ew.Validators.required(fields.TARIF_ID.caption) : null], fields.TARIF_ID.isInvalid],
        ["TREATMENT", [fields.TREATMENT.visible && fields.TREATMENT.required ? ew.Validators.required(fields.TREATMENT.caption) : null], fields.TREATMENT.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_AKOMODASI_KAMARadd,
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
    fV_AKOMODASI_KAMARadd.validate = function () {
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
    fV_AKOMODASI_KAMARadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_AKOMODASI_KAMARadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fV_AKOMODASI_KAMARadd.lists.NO_REGISTRATION = <?= $Page->NO_REGISTRATION->toClientList($Page) ?>;
    fV_AKOMODASI_KAMARadd.lists.TARIF_ID = <?= $Page->TARIF_ID->toClientList($Page) ?>;
    loadjs.done("fV_AKOMODASI_KAMARadd");
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
<form name="fV_AKOMODASI_KAMARadd" id="fV_AKOMODASI_KAMARadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_AKOMODASI_KAMAR">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "V_KUNJUNGAN_PASIEN") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="V_KUNJUNGAN_PASIEN">
<input type="hidden" name="fk_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->getSessionValue()) ?>">
<input type="hidden" name="fk_DIANTAR_OLEH" value="<?= HtmlEncode($Page->THENAME->getSessionValue()) ?>">
<input type="hidden" name="fk_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<?php if ($Page->VISIT_ID->getSessionValue() != "") { ?>
<span id="el_V_AKOMODASI_KAMAR_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_ID->getDisplayValue($Page->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_VISIT_ID" name="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_V_AKOMODASI_KAMAR_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BILL_ID->Visible) { // BILL_ID ?>
    <div id="r_BILL_ID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_BILL_ID" for="x_BILL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BILL_ID->caption() ?><?= $Page->BILL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BILL_ID->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_BILL_ID">
<input type="<?= $Page->BILL_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_BILL_ID" name="x_BILL_ID" id="x_BILL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BILL_ID->getPlaceHolder()) ?>" value="<?= $Page->BILL_ID->EditValue ?>"<?= $Page->BILL_ID->editAttributes() ?> aria-describedby="x_BILL_ID_help">
<?= $Page->BILL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BILL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Page->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el_V_AKOMODASI_KAMAR_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_NO_REGISTRATION" name="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_V_AKOMODASI_KAMAR_NO_REGISTRATION">
<div class="input-group ew-lookup-list" aria-describedby="x_NO_REGISTRATION_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_NO_REGISTRATION"><?= EmptyValue(strval($Page->NO_REGISTRATION->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->NO_REGISTRATION->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->NO_REGISTRATION->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->NO_REGISTRATION->ReadOnly || $Page->NO_REGISTRATION->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_NO_REGISTRATION',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<?= $Page->NO_REGISTRATION->Lookup->getParamTag($Page, "p_x_NO_REGISTRATION") ?>
<input type="hidden" is="selection-list" data-table="V_AKOMODASI_KAMAR" data-field="x_NO_REGISTRATION" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->NO_REGISTRATION->displayValueSeparatorAttribute() ?>" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= $Page->NO_REGISTRATION->CurrentValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?>>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<?php if ($Page->THENAME->getSessionValue() != "") { ?>
<span id="el_V_AKOMODASI_KAMAR_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->THENAME->getDisplayValue($Page->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_THENAME" name="x_THENAME" value="<?= HtmlEncode($Page->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_V_AKOMODASI_KAMAR_THENAME">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?> aria-describedby="x_THENAME_help">
<?= $Page->THENAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_THEADDRESS" for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEADDRESS->caption() ?><?= $Page->THEADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_THEADDRESS">
<input type="<?= $Page->THEADDRESS->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEADDRESS" name="x_THEADDRESS" id="x_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Page->THEADDRESS->EditValue ?>"<?= $Page->THEADDRESS->editAttributes() ?> aria-describedby="x_THEADDRESS_help">
<?= $Page->THEADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <div id="r_THEID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_THEID" for="x_THEID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEID->caption() ?><?= $Page->THEID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEID->cellAttributes() ?>>
<span id="el_V_AKOMODASI_KAMAR_THEID">
<input type="<?= $Page->THEID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_THEID" name="x_THEID" id="x_THEID" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->THEID->getPlaceHolder()) ?>" value="<?= $Page->THEID->EditValue ?>"<?= $Page->THEID->editAttributes() ?> aria-describedby="x_THEID_help">
<?= $Page->THEID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
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
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_V_AKOMODASI_KAMAR_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<?php if ($Page->TRANS_ID->getSessionValue() != "") { ?>
<span id="el_V_AKOMODASI_KAMAR_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_TRANS_ID" name="x_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_V_AKOMODASI_KAMAR_TRANS_ID">
<input type="<?= $Page->TRANS_ID->getInputTextType() ?>" data-table="V_AKOMODASI_KAMAR" data-field="x_TRANS_ID" name="x_TRANS_ID" id="x_TRANS_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->TRANS_ID->getPlaceHolder()) ?>" value="<?= $Page->TRANS_ID->EditValue ?>"<?= $Page->TRANS_ID->editAttributes() ?> aria-describedby="x_TRANS_ID_help">
<?= $Page->TRANS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TRANS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
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
    ew.addEventHandlers("V_AKOMODASI_KAMAR");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
