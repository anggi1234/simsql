<?php

namespace PHPMaker2021\simrs;

// Page object
$AntrianFarmasiAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fANTRIAN_FARMASIadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fANTRIAN_FARMASIadd = currentForm = new ew.Form("fANTRIAN_FARMASIadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ANTRIAN_FARMASI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ANTRIAN_FARMASI)
        ew.vars.tables.ANTRIAN_FARMASI = currentTable;
    fANTRIAN_FARMASIadd.addFields([
        ["no_urut", [fields.no_urut.visible && fields.no_urut.required ? ew.Validators.required(fields.no_urut.caption) : null, ew.Validators.integer], fields.no_urut.isInvalid],
        ["tanggal_daftar", [fields.tanggal_daftar.visible && fields.tanggal_daftar.required ? ew.Validators.required(fields.tanggal_daftar.caption) : null, ew.Validators.datetime(0)], fields.tanggal_daftar.isInvalid],
        ["tanggal_panggil", [fields.tanggal_panggil.visible && fields.tanggal_panggil.required ? ew.Validators.required(fields.tanggal_panggil.caption) : null, ew.Validators.datetime(0)], fields.tanggal_panggil.isInvalid],
        ["loket", [fields.loket.visible && fields.loket.required ? ew.Validators.required(fields.loket.caption) : null], fields.loket.isInvalid],
        ["status_panggil", [fields.status_panggil.visible && fields.status_panggil.required ? ew.Validators.required(fields.status_panggil.caption) : null, ew.Validators.integer], fields.status_panggil.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fANTRIAN_FARMASIadd,
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
    fANTRIAN_FARMASIadd.validate = function () {
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
    fANTRIAN_FARMASIadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fANTRIAN_FARMASIadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fANTRIAN_FARMASIadd");
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
<form name="fANTRIAN_FARMASIadd" id="fANTRIAN_FARMASIadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ANTRIAN_FARMASI">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->no_urut->Visible) { // no_urut ?>
    <div id="r_no_urut" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_no_urut" for="x_no_urut" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_urut->caption() ?><?= $Page->no_urut->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_urut->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_no_urut">
<input type="<?= $Page->no_urut->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_no_urut" name="x_no_urut" id="x_no_urut" size="30" placeholder="<?= HtmlEncode($Page->no_urut->getPlaceHolder()) ?>" value="<?= $Page->no_urut->EditValue ?>"<?= $Page->no_urut->editAttributes() ?> aria-describedby="x_no_urut_help">
<?= $Page->no_urut->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_urut->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_daftar->Visible) { // tanggal_daftar ?>
    <div id="r_tanggal_daftar" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_tanggal_daftar" for="x_tanggal_daftar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_daftar->caption() ?><?= $Page->tanggal_daftar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_daftar->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_tanggal_daftar">
<input type="<?= $Page->tanggal_daftar->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_tanggal_daftar" name="x_tanggal_daftar" id="x_tanggal_daftar" placeholder="<?= HtmlEncode($Page->tanggal_daftar->getPlaceHolder()) ?>" value="<?= $Page->tanggal_daftar->EditValue ?>"<?= $Page->tanggal_daftar->editAttributes() ?> aria-describedby="x_tanggal_daftar_help">
<?= $Page->tanggal_daftar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_daftar->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_daftar->ReadOnly && !$Page->tanggal_daftar->Disabled && !isset($Page->tanggal_daftar->EditAttrs["readonly"]) && !isset($Page->tanggal_daftar->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_FARMASIadd", "x_tanggal_daftar", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_panggil->Visible) { // tanggal_panggil ?>
    <div id="r_tanggal_panggil" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_tanggal_panggil" for="x_tanggal_panggil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_panggil->caption() ?><?= $Page->tanggal_panggil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_tanggal_panggil">
<input type="<?= $Page->tanggal_panggil->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_tanggal_panggil" name="x_tanggal_panggil" id="x_tanggal_panggil" placeholder="<?= HtmlEncode($Page->tanggal_panggil->getPlaceHolder()) ?>" value="<?= $Page->tanggal_panggil->EditValue ?>"<?= $Page->tanggal_panggil->editAttributes() ?> aria-describedby="x_tanggal_panggil_help">
<?= $Page->tanggal_panggil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_panggil->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_panggil->ReadOnly && !$Page->tanggal_panggil->Disabled && !isset($Page->tanggal_panggil->EditAttrs["readonly"]) && !isset($Page->tanggal_panggil->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fANTRIAN_FARMASIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fANTRIAN_FARMASIadd", "x_tanggal_panggil", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->loket->Visible) { // loket ?>
    <div id="r_loket" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_loket" for="x_loket" class="<?= $Page->LeftColumnClass ?>"><?= $Page->loket->caption() ?><?= $Page->loket->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->loket->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_loket">
<input type="<?= $Page->loket->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_loket" name="x_loket" id="x_loket" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->loket->getPlaceHolder()) ?>" value="<?= $Page->loket->EditValue ?>"<?= $Page->loket->editAttributes() ?> aria-describedby="x_loket_help">
<?= $Page->loket->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->loket->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_panggil->Visible) { // status_panggil ?>
    <div id="r_status_panggil" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_status_panggil" for="x_status_panggil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status_panggil->caption() ?><?= $Page->status_panggil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_panggil->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_status_panggil">
<input type="<?= $Page->status_panggil->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_status_panggil" name="x_status_panggil" id="x_status_panggil" size="30" placeholder="<?= HtmlEncode($Page->status_panggil->getPlaceHolder()) ?>" value="<?= $Page->status_panggil->EditValue ?>"<?= $Page->status_panggil->editAttributes() ?> aria-describedby="x_status_panggil_help">
<?= $Page->status_panggil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_panggil->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_NO_REGISTRATION">
<input type="<?= $Page->NO_REGISTRATION->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_NO_REGISTRATION" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION->EditValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?> aria-describedby="x_NO_REGISTRATION_help">
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_THENAME">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?> aria-describedby="x_THENAME_help">
<?= $Page->THENAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_ANTRIAN_FARMASI_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_ANTRIAN_FARMASI_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="ANTRIAN_FARMASI" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
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
    ew.addEventHandlers("ANTRIAN_FARMASI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
