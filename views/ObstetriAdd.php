<?php

namespace PHPMaker2021\simrs;

// Page object
$ObstetriAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fOBSTETRIadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fOBSTETRIadd = currentForm = new ew.Form("fOBSTETRIadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "OBSTETRI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.OBSTETRI)
        ew.vars.tables.OBSTETRI = currentTable;
    fOBSTETRIadd.addFields([
        ["OBSTETRI_ID", [fields.OBSTETRI_ID.visible && fields.OBSTETRI_ID.required ? ew.Validators.required(fields.OBSTETRI_ID.caption) : null], fields.OBSTETRI_ID.isInvalid],
        ["HPHT", [fields.HPHT.visible && fields.HPHT.required ? ew.Validators.required(fields.HPHT.caption) : null, ew.Validators.datetime(0)], fields.HPHT.isInvalid],
        ["HTP", [fields.HTP.visible && fields.HTP.required ? ew.Validators.required(fields.HTP.caption) : null, ew.Validators.datetime(0)], fields.HTP.isInvalid],
        ["PASIEN_DIAGNOSA_ID", [fields.PASIEN_DIAGNOSA_ID.visible && fields.PASIEN_DIAGNOSA_ID.required ? ew.Validators.required(fields.PASIEN_DIAGNOSA_ID.caption) : null], fields.PASIEN_DIAGNOSA_ID.isInvalid],
        ["DIAGNOSA_ID", [fields.DIAGNOSA_ID.visible && fields.DIAGNOSA_ID.required ? ew.Validators.required(fields.DIAGNOSA_ID.caption) : null], fields.DIAGNOSA_ID.isInvalid],
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["KOHORT_NB", [fields.KOHORT_NB.visible && fields.KOHORT_NB.required ? ew.Validators.required(fields.KOHORT_NB.caption) : null], fields.KOHORT_NB.isInvalid],
        ["BIRTH_NB", [fields.BIRTH_NB.visible && fields.BIRTH_NB.required ? ew.Validators.required(fields.BIRTH_NB.caption) : null, ew.Validators.integer], fields.BIRTH_NB.isInvalid],
        ["BIRTH_DURATION", [fields.BIRTH_DURATION.visible && fields.BIRTH_DURATION.required ? ew.Validators.required(fields.BIRTH_DURATION.caption) : null, ew.Validators.integer], fields.BIRTH_DURATION.isInvalid],
        ["BIRTH_PLACE", [fields.BIRTH_PLACE.visible && fields.BIRTH_PLACE.required ? ew.Validators.required(fields.BIRTH_PLACE.caption) : null, ew.Validators.integer], fields.BIRTH_PLACE.isInvalid],
        ["ANTE_NATAL", [fields.ANTE_NATAL.visible && fields.ANTE_NATAL.required ? ew.Validators.required(fields.ANTE_NATAL.caption) : null, ew.Validators.integer], fields.ANTE_NATAL.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["BIRTH_WAY", [fields.BIRTH_WAY.visible && fields.BIRTH_WAY.required ? ew.Validators.required(fields.BIRTH_WAY.caption) : null], fields.BIRTH_WAY.isInvalid],
        ["BIRTH_BY", [fields.BIRTH_BY.visible && fields.BIRTH_BY.required ? ew.Validators.required(fields.BIRTH_BY.caption) : null, ew.Validators.integer], fields.BIRTH_BY.isInvalid],
        ["BIRTH_DATE", [fields.BIRTH_DATE.visible && fields.BIRTH_DATE.required ? ew.Validators.required(fields.BIRTH_DATE.caption) : null, ew.Validators.datetime(0)], fields.BIRTH_DATE.isInvalid],
        ["GESTASI", [fields.GESTASI.visible && fields.GESTASI.required ? ew.Validators.required(fields.GESTASI.caption) : null, ew.Validators.integer], fields.GESTASI.isInvalid],
        ["PARITY", [fields.PARITY.visible && fields.PARITY.required ? ew.Validators.required(fields.PARITY.caption) : null, ew.Validators.integer], fields.PARITY.isInvalid],
        ["NB_BABY", [fields.NB_BABY.visible && fields.NB_BABY.required ? ew.Validators.required(fields.NB_BABY.caption) : null, ew.Validators.integer], fields.NB_BABY.isInvalid],
        ["BABY_DIE", [fields.BABY_DIE.visible && fields.BABY_DIE.required ? ew.Validators.required(fields.BABY_DIE.caption) : null, ew.Validators.integer], fields.BABY_DIE.isInvalid],
        ["ABORTUS_KE", [fields.ABORTUS_KE.visible && fields.ABORTUS_KE.required ? ew.Validators.required(fields.ABORTUS_KE.caption) : null, ew.Validators.integer], fields.ABORTUS_KE.isInvalid],
        ["ABORTUS_ID", [fields.ABORTUS_ID.visible && fields.ABORTUS_ID.required ? ew.Validators.required(fields.ABORTUS_ID.caption) : null], fields.ABORTUS_ID.isInvalid],
        ["ABORTION_DATE", [fields.ABORTION_DATE.visible && fields.ABORTION_DATE.required ? ew.Validators.required(fields.ABORTION_DATE.caption) : null, ew.Validators.datetime(0)], fields.ABORTION_DATE.isInvalid],
        ["BIRTH_CAT", [fields.BIRTH_CAT.visible && fields.BIRTH_CAT.required ? ew.Validators.required(fields.BIRTH_CAT.caption) : null], fields.BIRTH_CAT.isInvalid],
        ["BIRTH_CON", [fields.BIRTH_CON.visible && fields.BIRTH_CON.required ? ew.Validators.required(fields.BIRTH_CON.caption) : null, ew.Validators.integer], fields.BIRTH_CON.isInvalid],
        ["BIRTH_RISK", [fields.BIRTH_RISK.visible && fields.BIRTH_RISK.required ? ew.Validators.required(fields.BIRTH_RISK.caption) : null, ew.Validators.integer], fields.BIRTH_RISK.isInvalid],
        ["RISK_TYPE", [fields.RISK_TYPE.visible && fields.RISK_TYPE.required ? ew.Validators.required(fields.RISK_TYPE.caption) : null, ew.Validators.integer], fields.RISK_TYPE.isInvalid],
        ["FOLLOW_UP", [fields.FOLLOW_UP.visible && fields.FOLLOW_UP.required ? ew.Validators.required(fields.FOLLOW_UP.caption) : null, ew.Validators.integer], fields.FOLLOW_UP.isInvalid],
        ["DIRUJUK_OLEH", [fields.DIRUJUK_OLEH.visible && fields.DIRUJUK_OLEH.required ? ew.Validators.required(fields.DIRUJUK_OLEH.caption) : null], fields.DIRUJUK_OLEH.isInvalid],
        ["INSPECTION_DATE", [fields.INSPECTION_DATE.visible && fields.INSPECTION_DATE.required ? ew.Validators.required(fields.INSPECTION_DATE.caption) : null, ew.Validators.datetime(0)], fields.INSPECTION_DATE.isInvalid],
        ["PORSIO", [fields.PORSIO.visible && fields.PORSIO.required ? ew.Validators.required(fields.PORSIO.caption) : null], fields.PORSIO.isInvalid],
        ["PEMBUKAAN", [fields.PEMBUKAAN.visible && fields.PEMBUKAAN.required ? ew.Validators.required(fields.PEMBUKAAN.caption) : null], fields.PEMBUKAAN.isInvalid],
        ["KETUBAN", [fields.KETUBAN.visible && fields.KETUBAN.required ? ew.Validators.required(fields.KETUBAN.caption) : null], fields.KETUBAN.isInvalid],
        ["PRESENTASI", [fields.PRESENTASI.visible && fields.PRESENTASI.required ? ew.Validators.required(fields.PRESENTASI.caption) : null], fields.PRESENTASI.isInvalid],
        ["POSISI", [fields.POSISI.visible && fields.POSISI.required ? ew.Validators.required(fields.POSISI.caption) : null], fields.POSISI.isInvalid],
        ["PENURUNAN", [fields.PENURUNAN.visible && fields.PENURUNAN.required ? ew.Validators.required(fields.PENURUNAN.caption) : null], fields.PENURUNAN.isInvalid],
        ["HEART_ID", [fields.HEART_ID.visible && fields.HEART_ID.required ? ew.Validators.required(fields.HEART_ID.caption) : null, ew.Validators.integer], fields.HEART_ID.isInvalid],
        ["JANIN_ID", [fields.JANIN_ID.visible && fields.JANIN_ID.required ? ew.Validators.required(fields.JANIN_ID.caption) : null, ew.Validators.integer], fields.JANIN_ID.isInvalid],
        ["FREK_DJJ", [fields.FREK_DJJ.visible && fields.FREK_DJJ.required ? ew.Validators.required(fields.FREK_DJJ.caption) : null, ew.Validators.float], fields.FREK_DJJ.isInvalid],
        ["PLACENTA", [fields.PLACENTA.visible && fields.PLACENTA.required ? ew.Validators.required(fields.PLACENTA.caption) : null], fields.PLACENTA.isInvalid],
        ["LOCHIA", [fields.LOCHIA.visible && fields.LOCHIA.required ? ew.Validators.required(fields.LOCHIA.caption) : null], fields.LOCHIA.isInvalid],
        ["BAB_TYPE", [fields.BAB_TYPE.visible && fields.BAB_TYPE.required ? ew.Validators.required(fields.BAB_TYPE.caption) : null, ew.Validators.integer], fields.BAB_TYPE.isInvalid],
        ["BAB_BAB_TYPE", [fields.BAB_BAB_TYPE.visible && fields.BAB_BAB_TYPE.required ? ew.Validators.required(fields.BAB_BAB_TYPE.caption) : null, ew.Validators.integer], fields.BAB_BAB_TYPE.isInvalid],
        ["RAHIM_ID", [fields.RAHIM_ID.visible && fields.RAHIM_ID.required ? ew.Validators.required(fields.RAHIM_ID.caption) : null], fields.RAHIM_ID.isInvalid],
        ["BIR_RAHIM_ID", [fields.BIR_RAHIM_ID.visible && fields.BIR_RAHIM_ID.required ? ew.Validators.required(fields.BIR_RAHIM_ID.caption) : null], fields.BIR_RAHIM_ID.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["BLOODING", [fields.BLOODING.visible && fields.BLOODING.required ? ew.Validators.required(fields.BLOODING.caption) : null], fields.BLOODING.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_FROM", [fields.MODIFIED_FROM.visible && fields.MODIFIED_FROM.required ? ew.Validators.required(fields.MODIFIED_FROM.caption) : null], fields.MODIFIED_FROM.isInvalid],
        ["RAHIM_SALIN", [fields.RAHIM_SALIN.visible && fields.RAHIM_SALIN.required ? ew.Validators.required(fields.RAHIM_SALIN.caption) : null], fields.RAHIM_SALIN.isInvalid],
        ["RAHIM_NIFAS", [fields.RAHIM_NIFAS.visible && fields.RAHIM_NIFAS.required ? ew.Validators.required(fields.RAHIM_NIFAS.caption) : null], fields.RAHIM_NIFAS.isInvalid],
        ["BAK_TYPE", [fields.BAK_TYPE.visible && fields.BAK_TYPE.required ? ew.Validators.required(fields.BAK_TYPE.caption) : null, ew.Validators.integer], fields.BAK_TYPE.isInvalid],
        ["THENAME", [fields.THENAME.visible && fields.THENAME.required ? ew.Validators.required(fields.THENAME.caption) : null], fields.THENAME.isInvalid],
        ["THEADDRESS", [fields.THEADDRESS.visible && fields.THEADDRESS.required ? ew.Validators.required(fields.THEADDRESS.caption) : null], fields.THEADDRESS.isInvalid],
        ["THEID", [fields.THEID.visible && fields.THEID.required ? ew.Validators.required(fields.THEID.caption) : null], fields.THEID.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["ISRJ", [fields.ISRJ.visible && fields.ISRJ.required ? ew.Validators.required(fields.ISRJ.caption) : null], fields.ISRJ.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null, ew.Validators.integer], fields.AGEYEAR.isInvalid],
        ["AGEMONTH", [fields.AGEMONTH.visible && fields.AGEMONTH.required ? ew.Validators.required(fields.AGEMONTH.caption) : null, ew.Validators.integer], fields.AGEMONTH.isInvalid],
        ["AGEDAY", [fields.AGEDAY.visible && fields.AGEDAY.required ? ew.Validators.required(fields.AGEDAY.caption) : null, ew.Validators.integer], fields.AGEDAY.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["CLASS_ROOM_ID", [fields.CLASS_ROOM_ID.visible && fields.CLASS_ROOM_ID.required ? ew.Validators.required(fields.CLASS_ROOM_ID.caption) : null], fields.CLASS_ROOM_ID.isInvalid],
        ["BED_ID", [fields.BED_ID.visible && fields.BED_ID.required ? ew.Validators.required(fields.BED_ID.caption) : null, ew.Validators.integer], fields.BED_ID.isInvalid],
        ["KELUAR_ID", [fields.KELUAR_ID.visible && fields.KELUAR_ID.required ? ew.Validators.required(fields.KELUAR_ID.caption) : null, ew.Validators.integer], fields.KELUAR_ID.isInvalid],
        ["DOCTOR", [fields.DOCTOR.visible && fields.DOCTOR.required ? ew.Validators.required(fields.DOCTOR.caption) : null], fields.DOCTOR.isInvalid],
        ["NB_OBSTETRI", [fields.NB_OBSTETRI.visible && fields.NB_OBSTETRI.required ? ew.Validators.required(fields.NB_OBSTETRI.caption) : null, ew.Validators.integer], fields.NB_OBSTETRI.isInvalid],
        ["OBSTETRI_DIE", [fields.OBSTETRI_DIE.visible && fields.OBSTETRI_DIE.required ? ew.Validators.required(fields.OBSTETRI_DIE.caption) : null, ew.Validators.integer], fields.OBSTETRI_DIE.isInvalid],
        ["KAL_ID", [fields.KAL_ID.visible && fields.KAL_ID.required ? ew.Validators.required(fields.KAL_ID.caption) : null], fields.KAL_ID.isInvalid],
        ["DIAGNOSA_ID2", [fields.DIAGNOSA_ID2.visible && fields.DIAGNOSA_ID2.required ? ew.Validators.required(fields.DIAGNOSA_ID2.caption) : null], fields.DIAGNOSA_ID2.isInvalid],
        ["APGAR_ID", [fields.APGAR_ID.visible && fields.APGAR_ID.required ? ew.Validators.required(fields.APGAR_ID.caption) : null], fields.APGAR_ID.isInvalid],
        ["BIRTH_LAST_ID", [fields.BIRTH_LAST_ID.visible && fields.BIRTH_LAST_ID.required ? ew.Validators.required(fields.BIRTH_LAST_ID.caption) : null], fields.BIRTH_LAST_ID.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fOBSTETRIadd,
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
    fOBSTETRIadd.validate = function () {
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
    fOBSTETRIadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fOBSTETRIadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fOBSTETRIadd");
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
<form name="fOBSTETRIadd" id="fOBSTETRIadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="OBSTETRI">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
    <div id="r_OBSTETRI_ID" class="form-group row">
        <label id="elh_OBSTETRI_OBSTETRI_ID" for="x_OBSTETRI_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OBSTETRI_ID->caption() ?><?= $Page->OBSTETRI_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OBSTETRI_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_OBSTETRI_ID">
<input type="<?= $Page->OBSTETRI_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" name="x_OBSTETRI_ID" id="x_OBSTETRI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->OBSTETRI_ID->getPlaceHolder()) ?>" value="<?= $Page->OBSTETRI_ID->EditValue ?>"<?= $Page->OBSTETRI_ID->editAttributes() ?> aria-describedby="x_OBSTETRI_ID_help">
<?= $Page->OBSTETRI_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OBSTETRI_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HPHT->Visible) { // HPHT ?>
    <div id="r_HPHT" class="form-group row">
        <label id="elh_OBSTETRI_HPHT" for="x_HPHT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HPHT->caption() ?><?= $Page->HPHT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HPHT->cellAttributes() ?>>
<span id="el_OBSTETRI_HPHT">
<input type="<?= $Page->HPHT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HPHT" name="x_HPHT" id="x_HPHT" placeholder="<?= HtmlEncode($Page->HPHT->getPlaceHolder()) ?>" value="<?= $Page->HPHT->EditValue ?>"<?= $Page->HPHT->editAttributes() ?> aria-describedby="x_HPHT_help">
<?= $Page->HPHT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HPHT->getErrorMessage() ?></div>
<?php if (!$Page->HPHT->ReadOnly && !$Page->HPHT->Disabled && !isset($Page->HPHT->EditAttrs["readonly"]) && !isset($Page->HPHT->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIadd", "x_HPHT", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HTP->Visible) { // HTP ?>
    <div id="r_HTP" class="form-group row">
        <label id="elh_OBSTETRI_HTP" for="x_HTP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HTP->caption() ?><?= $Page->HTP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HTP->cellAttributes() ?>>
<span id="el_OBSTETRI_HTP">
<input type="<?= $Page->HTP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HTP" name="x_HTP" id="x_HTP" placeholder="<?= HtmlEncode($Page->HTP->getPlaceHolder()) ?>" value="<?= $Page->HTP->EditValue ?>"<?= $Page->HTP->editAttributes() ?> aria-describedby="x_HTP_help">
<?= $Page->HTP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HTP->getErrorMessage() ?></div>
<?php if (!$Page->HTP->ReadOnly && !$Page->HTP->Disabled && !isset($Page->HTP->EditAttrs["readonly"]) && !isset($Page->HTP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIadd", "x_HTP", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
    <div id="r_PASIEN_DIAGNOSA_ID" class="form-group row">
        <label id="elh_OBSTETRI_PASIEN_DIAGNOSA_ID" for="x_PASIEN_DIAGNOSA_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PASIEN_DIAGNOSA_ID->caption() ?><?= $Page->PASIEN_DIAGNOSA_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PASIEN_DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_PASIEN_DIAGNOSA_ID">
<input type="<?= $Page->PASIEN_DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" name="x_PASIEN_DIAGNOSA_ID" id="x_PASIEN_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PASIEN_DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Page->PASIEN_DIAGNOSA_ID->EditValue ?>"<?= $Page->PASIEN_DIAGNOSA_ID->editAttributes() ?> aria-describedby="x_PASIEN_DIAGNOSA_ID_help">
<?= $Page->PASIEN_DIAGNOSA_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PASIEN_DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
    <div id="r_DIAGNOSA_ID" class="form-group row">
        <label id="elh_OBSTETRI_DIAGNOSA_ID" for="x_DIAGNOSA_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIAGNOSA_ID->caption() ?><?= $Page->DIAGNOSA_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIAGNOSA_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_DIAGNOSA_ID">
<input type="<?= $Page->DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" name="x_DIAGNOSA_ID" id="x_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Page->DIAGNOSA_ID->EditValue ?>"<?= $Page->DIAGNOSA_ID->editAttributes() ?> aria-describedby="x_DIAGNOSA_ID_help">
<?= $Page->DIAGNOSA_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_OBSTETRI_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_OBSTETRI_NO_REGISTRATION">
<input type="<?= $Page->NO_REGISTRATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Page->NO_REGISTRATION->EditValue ?>"<?= $Page->NO_REGISTRATION->editAttributes() ?> aria-describedby="x_NO_REGISTRATION_help">
<?= $Page->NO_REGISTRATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KOHORT_NB->Visible) { // KOHORT_NB ?>
    <div id="r_KOHORT_NB" class="form-group row">
        <label id="elh_OBSTETRI_KOHORT_NB" for="x_KOHORT_NB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KOHORT_NB->caption() ?><?= $Page->KOHORT_NB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KOHORT_NB->cellAttributes() ?>>
<span id="el_OBSTETRI_KOHORT_NB">
<input type="<?= $Page->KOHORT_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KOHORT_NB" name="x_KOHORT_NB" id="x_KOHORT_NB" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->KOHORT_NB->getPlaceHolder()) ?>" value="<?= $Page->KOHORT_NB->EditValue ?>"<?= $Page->KOHORT_NB->editAttributes() ?> aria-describedby="x_KOHORT_NB_help">
<?= $Page->KOHORT_NB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KOHORT_NB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_NB->Visible) { // BIRTH_NB ?>
    <div id="r_BIRTH_NB" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_NB" for="x_BIRTH_NB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_NB->caption() ?><?= $Page->BIRTH_NB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_NB->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_NB">
<input type="<?= $Page->BIRTH_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_NB" name="x_BIRTH_NB" id="x_BIRTH_NB" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_NB->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_NB->EditValue ?>"<?= $Page->BIRTH_NB->editAttributes() ?> aria-describedby="x_BIRTH_NB_help">
<?= $Page->BIRTH_NB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_NB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
    <div id="r_BIRTH_DURATION" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_DURATION" for="x_BIRTH_DURATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_DURATION->caption() ?><?= $Page->BIRTH_DURATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_DURATION->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DURATION">
<input type="<?= $Page->BIRTH_DURATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" name="x_BIRTH_DURATION" id="x_BIRTH_DURATION" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_DURATION->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_DURATION->EditValue ?>"<?= $Page->BIRTH_DURATION->editAttributes() ?> aria-describedby="x_BIRTH_DURATION_help">
<?= $Page->BIRTH_DURATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_DURATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
    <div id="r_BIRTH_PLACE" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_PLACE" for="x_BIRTH_PLACE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_PLACE->caption() ?><?= $Page->BIRTH_PLACE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_PLACE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_PLACE">
<input type="<?= $Page->BIRTH_PLACE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" name="x_BIRTH_PLACE" id="x_BIRTH_PLACE" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_PLACE->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_PLACE->EditValue ?>"<?= $Page->BIRTH_PLACE->editAttributes() ?> aria-describedby="x_BIRTH_PLACE_help">
<?= $Page->BIRTH_PLACE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_PLACE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
    <div id="r_ANTE_NATAL" class="form-group row">
        <label id="elh_OBSTETRI_ANTE_NATAL" for="x_ANTE_NATAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ANTE_NATAL->caption() ?><?= $Page->ANTE_NATAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ANTE_NATAL->cellAttributes() ?>>
<span id="el_OBSTETRI_ANTE_NATAL">
<input type="<?= $Page->ANTE_NATAL->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ANTE_NATAL" name="x_ANTE_NATAL" id="x_ANTE_NATAL" size="30" placeholder="<?= HtmlEncode($Page->ANTE_NATAL->getPlaceHolder()) ?>" value="<?= $Page->ANTE_NATAL->EditValue ?>"<?= $Page->ANTE_NATAL->editAttributes() ?> aria-describedby="x_ANTE_NATAL_help">
<?= $Page->ANTE_NATAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ANTE_NATAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_OBSTETRI_EMPLOYEE_ID" for="x_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_EMPLOYEE_ID">
<input type="<?= $Page->EMPLOYEE_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Page->EMPLOYEE_ID->EditValue ?>"<?= $Page->EMPLOYEE_ID->editAttributes() ?> aria-describedby="x_EMPLOYEE_ID_help">
<?= $Page->EMPLOYEE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_OBSTETRI_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
    <div id="r_BIRTH_WAY" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_WAY" for="x_BIRTH_WAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_WAY->caption() ?><?= $Page->BIRTH_WAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_WAY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_WAY">
<input type="<?= $Page->BIRTH_WAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_WAY" name="x_BIRTH_WAY" id="x_BIRTH_WAY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BIRTH_WAY->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_WAY->EditValue ?>"<?= $Page->BIRTH_WAY->editAttributes() ?> aria-describedby="x_BIRTH_WAY_help">
<?= $Page->BIRTH_WAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_WAY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_BY->Visible) { // BIRTH_BY ?>
    <div id="r_BIRTH_BY" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_BY" for="x_BIRTH_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_BY->caption() ?><?= $Page->BIRTH_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_BY->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_BY">
<input type="<?= $Page->BIRTH_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_BY" name="x_BIRTH_BY" id="x_BIRTH_BY" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_BY->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_BY->EditValue ?>"<?= $Page->BIRTH_BY->editAttributes() ?> aria-describedby="x_BIRTH_BY_help">
<?= $Page->BIRTH_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
    <div id="r_BIRTH_DATE" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_DATE" for="x_BIRTH_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_DATE->caption() ?><?= $Page->BIRTH_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_DATE">
<input type="<?= $Page->BIRTH_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DATE" name="x_BIRTH_DATE" id="x_BIRTH_DATE" placeholder="<?= HtmlEncode($Page->BIRTH_DATE->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_DATE->EditValue ?>"<?= $Page->BIRTH_DATE->editAttributes() ?> aria-describedby="x_BIRTH_DATE_help">
<?= $Page->BIRTH_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_DATE->getErrorMessage() ?></div>
<?php if (!$Page->BIRTH_DATE->ReadOnly && !$Page->BIRTH_DATE->Disabled && !isset($Page->BIRTH_DATE->EditAttrs["readonly"]) && !isset($Page->BIRTH_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIadd", "x_BIRTH_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GESTASI->Visible) { // GESTASI ?>
    <div id="r_GESTASI" class="form-group row">
        <label id="elh_OBSTETRI_GESTASI" for="x_GESTASI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GESTASI->caption() ?><?= $Page->GESTASI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GESTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_GESTASI">
<input type="<?= $Page->GESTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GESTASI" name="x_GESTASI" id="x_GESTASI" size="30" placeholder="<?= HtmlEncode($Page->GESTASI->getPlaceHolder()) ?>" value="<?= $Page->GESTASI->EditValue ?>"<?= $Page->GESTASI->editAttributes() ?> aria-describedby="x_GESTASI_help">
<?= $Page->GESTASI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GESTASI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PARITY->Visible) { // PARITY ?>
    <div id="r_PARITY" class="form-group row">
        <label id="elh_OBSTETRI_PARITY" for="x_PARITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PARITY->caption() ?><?= $Page->PARITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PARITY->cellAttributes() ?>>
<span id="el_OBSTETRI_PARITY">
<input type="<?= $Page->PARITY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PARITY" name="x_PARITY" id="x_PARITY" size="30" placeholder="<?= HtmlEncode($Page->PARITY->getPlaceHolder()) ?>" value="<?= $Page->PARITY->EditValue ?>"<?= $Page->PARITY->editAttributes() ?> aria-describedby="x_PARITY_help">
<?= $Page->PARITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PARITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NB_BABY->Visible) { // NB_BABY ?>
    <div id="r_NB_BABY" class="form-group row">
        <label id="elh_OBSTETRI_NB_BABY" for="x_NB_BABY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NB_BABY->caption() ?><?= $Page->NB_BABY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NB_BABY->cellAttributes() ?>>
<span id="el_OBSTETRI_NB_BABY">
<input type="<?= $Page->NB_BABY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_BABY" name="x_NB_BABY" id="x_NB_BABY" size="30" placeholder="<?= HtmlEncode($Page->NB_BABY->getPlaceHolder()) ?>" value="<?= $Page->NB_BABY->EditValue ?>"<?= $Page->NB_BABY->editAttributes() ?> aria-describedby="x_NB_BABY_help">
<?= $Page->NB_BABY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NB_BABY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BABY_DIE->Visible) { // BABY_DIE ?>
    <div id="r_BABY_DIE" class="form-group row">
        <label id="elh_OBSTETRI_BABY_DIE" for="x_BABY_DIE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BABY_DIE->caption() ?><?= $Page->BABY_DIE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BABY_DIE->cellAttributes() ?>>
<span id="el_OBSTETRI_BABY_DIE">
<input type="<?= $Page->BABY_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BABY_DIE" name="x_BABY_DIE" id="x_BABY_DIE" size="30" placeholder="<?= HtmlEncode($Page->BABY_DIE->getPlaceHolder()) ?>" value="<?= $Page->BABY_DIE->EditValue ?>"<?= $Page->BABY_DIE->editAttributes() ?> aria-describedby="x_BABY_DIE_help">
<?= $Page->BABY_DIE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BABY_DIE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
    <div id="r_ABORTUS_KE" class="form-group row">
        <label id="elh_OBSTETRI_ABORTUS_KE" for="x_ABORTUS_KE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ABORTUS_KE->caption() ?><?= $Page->ABORTUS_KE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ABORTUS_KE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_KE">
<input type="<?= $Page->ABORTUS_KE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_KE" name="x_ABORTUS_KE" id="x_ABORTUS_KE" size="30" placeholder="<?= HtmlEncode($Page->ABORTUS_KE->getPlaceHolder()) ?>" value="<?= $Page->ABORTUS_KE->EditValue ?>"<?= $Page->ABORTUS_KE->editAttributes() ?> aria-describedby="x_ABORTUS_KE_help">
<?= $Page->ABORTUS_KE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ABORTUS_KE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
    <div id="r_ABORTUS_ID" class="form-group row">
        <label id="elh_OBSTETRI_ABORTUS_ID" for="x_ABORTUS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ABORTUS_ID->caption() ?><?= $Page->ABORTUS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ABORTUS_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTUS_ID">
<input type="<?= $Page->ABORTUS_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_ID" name="x_ABORTUS_ID" id="x_ABORTUS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->ABORTUS_ID->getPlaceHolder()) ?>" value="<?= $Page->ABORTUS_ID->EditValue ?>"<?= $Page->ABORTUS_ID->editAttributes() ?> aria-describedby="x_ABORTUS_ID_help">
<?= $Page->ABORTUS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ABORTUS_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
    <div id="r_ABORTION_DATE" class="form-group row">
        <label id="elh_OBSTETRI_ABORTION_DATE" for="x_ABORTION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ABORTION_DATE->caption() ?><?= $Page->ABORTION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ABORTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_ABORTION_DATE">
<input type="<?= $Page->ABORTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTION_DATE" name="x_ABORTION_DATE" id="x_ABORTION_DATE" placeholder="<?= HtmlEncode($Page->ABORTION_DATE->getPlaceHolder()) ?>" value="<?= $Page->ABORTION_DATE->EditValue ?>"<?= $Page->ABORTION_DATE->editAttributes() ?> aria-describedby="x_ABORTION_DATE_help">
<?= $Page->ABORTION_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ABORTION_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ABORTION_DATE->ReadOnly && !$Page->ABORTION_DATE->Disabled && !isset($Page->ABORTION_DATE->EditAttrs["readonly"]) && !isset($Page->ABORTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIadd", "x_ABORTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
    <div id="r_BIRTH_CAT" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_CAT" for="x_BIRTH_CAT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_CAT->caption() ?><?= $Page->BIRTH_CAT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_CAT->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CAT">
<input type="<?= $Page->BIRTH_CAT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CAT" name="x_BIRTH_CAT" id="x_BIRTH_CAT" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BIRTH_CAT->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_CAT->EditValue ?>"<?= $Page->BIRTH_CAT->editAttributes() ?> aria-describedby="x_BIRTH_CAT_help">
<?= $Page->BIRTH_CAT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_CAT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_CON->Visible) { // BIRTH_CON ?>
    <div id="r_BIRTH_CON" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_CON" for="x_BIRTH_CON" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_CON->caption() ?><?= $Page->BIRTH_CON->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_CON->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_CON">
<input type="<?= $Page->BIRTH_CON->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CON" name="x_BIRTH_CON" id="x_BIRTH_CON" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_CON->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_CON->EditValue ?>"<?= $Page->BIRTH_CON->editAttributes() ?> aria-describedby="x_BIRTH_CON_help">
<?= $Page->BIRTH_CON->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_CON->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
    <div id="r_BIRTH_RISK" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_RISK" for="x_BIRTH_RISK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_RISK->caption() ?><?= $Page->BIRTH_RISK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_RISK->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_RISK">
<input type="<?= $Page->BIRTH_RISK->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_RISK" name="x_BIRTH_RISK" id="x_BIRTH_RISK" size="30" placeholder="<?= HtmlEncode($Page->BIRTH_RISK->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_RISK->EditValue ?>"<?= $Page->BIRTH_RISK->editAttributes() ?> aria-describedby="x_BIRTH_RISK_help">
<?= $Page->BIRTH_RISK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_RISK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RISK_TYPE->Visible) { // RISK_TYPE ?>
    <div id="r_RISK_TYPE" class="form-group row">
        <label id="elh_OBSTETRI_RISK_TYPE" for="x_RISK_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RISK_TYPE->caption() ?><?= $Page->RISK_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RISK_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_RISK_TYPE">
<input type="<?= $Page->RISK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RISK_TYPE" name="x_RISK_TYPE" id="x_RISK_TYPE" size="30" placeholder="<?= HtmlEncode($Page->RISK_TYPE->getPlaceHolder()) ?>" value="<?= $Page->RISK_TYPE->EditValue ?>"<?= $Page->RISK_TYPE->editAttributes() ?> aria-describedby="x_RISK_TYPE_help">
<?= $Page->RISK_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RISK_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
    <div id="r_FOLLOW_UP" class="form-group row">
        <label id="elh_OBSTETRI_FOLLOW_UP" for="x_FOLLOW_UP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FOLLOW_UP->caption() ?><?= $Page->FOLLOW_UP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FOLLOW_UP->cellAttributes() ?>>
<span id="el_OBSTETRI_FOLLOW_UP">
<input type="<?= $Page->FOLLOW_UP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FOLLOW_UP" name="x_FOLLOW_UP" id="x_FOLLOW_UP" size="30" placeholder="<?= HtmlEncode($Page->FOLLOW_UP->getPlaceHolder()) ?>" value="<?= $Page->FOLLOW_UP->EditValue ?>"<?= $Page->FOLLOW_UP->editAttributes() ?> aria-describedby="x_FOLLOW_UP_help">
<?= $Page->FOLLOW_UP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FOLLOW_UP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
    <div id="r_DIRUJUK_OLEH" class="form-group row">
        <label id="elh_OBSTETRI_DIRUJUK_OLEH" for="x_DIRUJUK_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIRUJUK_OLEH->caption() ?><?= $Page->DIRUJUK_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIRUJUK_OLEH->cellAttributes() ?>>
<span id="el_OBSTETRI_DIRUJUK_OLEH">
<input type="<?= $Page->DIRUJUK_OLEH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" name="x_DIRUJUK_OLEH" id="x_DIRUJUK_OLEH" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DIRUJUK_OLEH->getPlaceHolder()) ?>" value="<?= $Page->DIRUJUK_OLEH->EditValue ?>"<?= $Page->DIRUJUK_OLEH->editAttributes() ?> aria-describedby="x_DIRUJUK_OLEH_help">
<?= $Page->DIRUJUK_OLEH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIRUJUK_OLEH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
    <div id="r_INSPECTION_DATE" class="form-group row">
        <label id="elh_OBSTETRI_INSPECTION_DATE" for="x_INSPECTION_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INSPECTION_DATE->caption() ?><?= $Page->INSPECTION_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INSPECTION_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_INSPECTION_DATE">
<input type="<?= $Page->INSPECTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" name="x_INSPECTION_DATE" id="x_INSPECTION_DATE" placeholder="<?= HtmlEncode($Page->INSPECTION_DATE->getPlaceHolder()) ?>" value="<?= $Page->INSPECTION_DATE->EditValue ?>"<?= $Page->INSPECTION_DATE->editAttributes() ?> aria-describedby="x_INSPECTION_DATE_help">
<?= $Page->INSPECTION_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INSPECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Page->INSPECTION_DATE->ReadOnly && !$Page->INSPECTION_DATE->Disabled && !isset($Page->INSPECTION_DATE->EditAttrs["readonly"]) && !isset($Page->INSPECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIadd", "x_INSPECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PORSIO->Visible) { // PORSIO ?>
    <div id="r_PORSIO" class="form-group row">
        <label id="elh_OBSTETRI_PORSIO" for="x_PORSIO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PORSIO->caption() ?><?= $Page->PORSIO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PORSIO->cellAttributes() ?>>
<span id="el_OBSTETRI_PORSIO">
<input type="<?= $Page->PORSIO->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PORSIO" name="x_PORSIO" id="x_PORSIO" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PORSIO->getPlaceHolder()) ?>" value="<?= $Page->PORSIO->EditValue ?>"<?= $Page->PORSIO->editAttributes() ?> aria-describedby="x_PORSIO_help">
<?= $Page->PORSIO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PORSIO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
    <div id="r_PEMBUKAAN" class="form-group row">
        <label id="elh_OBSTETRI_PEMBUKAAN" for="x_PEMBUKAAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PEMBUKAAN->caption() ?><?= $Page->PEMBUKAAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PEMBUKAAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PEMBUKAAN">
<input type="<?= $Page->PEMBUKAAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PEMBUKAAN" name="x_PEMBUKAAN" id="x_PEMBUKAAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PEMBUKAAN->getPlaceHolder()) ?>" value="<?= $Page->PEMBUKAAN->EditValue ?>"<?= $Page->PEMBUKAAN->editAttributes() ?> aria-describedby="x_PEMBUKAAN_help">
<?= $Page->PEMBUKAAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PEMBUKAAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KETUBAN->Visible) { // KETUBAN ?>
    <div id="r_KETUBAN" class="form-group row">
        <label id="elh_OBSTETRI_KETUBAN" for="x_KETUBAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KETUBAN->caption() ?><?= $Page->KETUBAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KETUBAN->cellAttributes() ?>>
<span id="el_OBSTETRI_KETUBAN">
<input type="<?= $Page->KETUBAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KETUBAN" name="x_KETUBAN" id="x_KETUBAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->KETUBAN->getPlaceHolder()) ?>" value="<?= $Page->KETUBAN->EditValue ?>"<?= $Page->KETUBAN->editAttributes() ?> aria-describedby="x_KETUBAN_help">
<?= $Page->KETUBAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KETUBAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRESENTASI->Visible) { // PRESENTASI ?>
    <div id="r_PRESENTASI" class="form-group row">
        <label id="elh_OBSTETRI_PRESENTASI" for="x_PRESENTASI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRESENTASI->caption() ?><?= $Page->PRESENTASI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRESENTASI->cellAttributes() ?>>
<span id="el_OBSTETRI_PRESENTASI">
<input type="<?= $Page->PRESENTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PRESENTASI" name="x_PRESENTASI" id="x_PRESENTASI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PRESENTASI->getPlaceHolder()) ?>" value="<?= $Page->PRESENTASI->EditValue ?>"<?= $Page->PRESENTASI->editAttributes() ?> aria-describedby="x_PRESENTASI_help">
<?= $Page->PRESENTASI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRESENTASI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->POSISI->Visible) { // POSISI ?>
    <div id="r_POSISI" class="form-group row">
        <label id="elh_OBSTETRI_POSISI" for="x_POSISI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->POSISI->caption() ?><?= $Page->POSISI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->POSISI->cellAttributes() ?>>
<span id="el_OBSTETRI_POSISI">
<input type="<?= $Page->POSISI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_POSISI" name="x_POSISI" id="x_POSISI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->POSISI->getPlaceHolder()) ?>" value="<?= $Page->POSISI->EditValue ?>"<?= $Page->POSISI->editAttributes() ?> aria-describedby="x_POSISI_help">
<?= $Page->POSISI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->POSISI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PENURUNAN->Visible) { // PENURUNAN ?>
    <div id="r_PENURUNAN" class="form-group row">
        <label id="elh_OBSTETRI_PENURUNAN" for="x_PENURUNAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PENURUNAN->caption() ?><?= $Page->PENURUNAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PENURUNAN->cellAttributes() ?>>
<span id="el_OBSTETRI_PENURUNAN">
<input type="<?= $Page->PENURUNAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PENURUNAN" name="x_PENURUNAN" id="x_PENURUNAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->PENURUNAN->getPlaceHolder()) ?>" value="<?= $Page->PENURUNAN->EditValue ?>"<?= $Page->PENURUNAN->editAttributes() ?> aria-describedby="x_PENURUNAN_help">
<?= $Page->PENURUNAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PENURUNAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HEART_ID->Visible) { // HEART_ID ?>
    <div id="r_HEART_ID" class="form-group row">
        <label id="elh_OBSTETRI_HEART_ID" for="x_HEART_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HEART_ID->caption() ?><?= $Page->HEART_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HEART_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_HEART_ID">
<input type="<?= $Page->HEART_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HEART_ID" name="x_HEART_ID" id="x_HEART_ID" size="30" placeholder="<?= HtmlEncode($Page->HEART_ID->getPlaceHolder()) ?>" value="<?= $Page->HEART_ID->EditValue ?>"<?= $Page->HEART_ID->editAttributes() ?> aria-describedby="x_HEART_ID_help">
<?= $Page->HEART_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HEART_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->JANIN_ID->Visible) { // JANIN_ID ?>
    <div id="r_JANIN_ID" class="form-group row">
        <label id="elh_OBSTETRI_JANIN_ID" for="x_JANIN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->JANIN_ID->caption() ?><?= $Page->JANIN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->JANIN_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_JANIN_ID">
<input type="<?= $Page->JANIN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_JANIN_ID" name="x_JANIN_ID" id="x_JANIN_ID" size="30" placeholder="<?= HtmlEncode($Page->JANIN_ID->getPlaceHolder()) ?>" value="<?= $Page->JANIN_ID->EditValue ?>"<?= $Page->JANIN_ID->editAttributes() ?> aria-describedby="x_JANIN_ID_help">
<?= $Page->JANIN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->JANIN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FREK_DJJ->Visible) { // FREK_DJJ ?>
    <div id="r_FREK_DJJ" class="form-group row">
        <label id="elh_OBSTETRI_FREK_DJJ" for="x_FREK_DJJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FREK_DJJ->caption() ?><?= $Page->FREK_DJJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FREK_DJJ->cellAttributes() ?>>
<span id="el_OBSTETRI_FREK_DJJ">
<input type="<?= $Page->FREK_DJJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FREK_DJJ" name="x_FREK_DJJ" id="x_FREK_DJJ" size="30" placeholder="<?= HtmlEncode($Page->FREK_DJJ->getPlaceHolder()) ?>" value="<?= $Page->FREK_DJJ->EditValue ?>"<?= $Page->FREK_DJJ->editAttributes() ?> aria-describedby="x_FREK_DJJ_help">
<?= $Page->FREK_DJJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FREK_DJJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PLACENTA->Visible) { // PLACENTA ?>
    <div id="r_PLACENTA" class="form-group row">
        <label id="elh_OBSTETRI_PLACENTA" for="x_PLACENTA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PLACENTA->caption() ?><?= $Page->PLACENTA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PLACENTA->cellAttributes() ?>>
<span id="el_OBSTETRI_PLACENTA">
<input type="<?= $Page->PLACENTA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PLACENTA" name="x_PLACENTA" id="x_PLACENTA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->PLACENTA->getPlaceHolder()) ?>" value="<?= $Page->PLACENTA->EditValue ?>"<?= $Page->PLACENTA->editAttributes() ?> aria-describedby="x_PLACENTA_help">
<?= $Page->PLACENTA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PLACENTA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->LOCHIA->Visible) { // LOCHIA ?>
    <div id="r_LOCHIA" class="form-group row">
        <label id="elh_OBSTETRI_LOCHIA" for="x_LOCHIA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->LOCHIA->caption() ?><?= $Page->LOCHIA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->LOCHIA->cellAttributes() ?>>
<span id="el_OBSTETRI_LOCHIA">
<input type="<?= $Page->LOCHIA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_LOCHIA" name="x_LOCHIA" id="x_LOCHIA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->LOCHIA->getPlaceHolder()) ?>" value="<?= $Page->LOCHIA->EditValue ?>"<?= $Page->LOCHIA->editAttributes() ?> aria-describedby="x_LOCHIA_help">
<?= $Page->LOCHIA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->LOCHIA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BAB_TYPE->Visible) { // BAB_TYPE ?>
    <div id="r_BAB_TYPE" class="form-group row">
        <label id="elh_OBSTETRI_BAB_TYPE" for="x_BAB_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BAB_TYPE->caption() ?><?= $Page->BAB_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAB_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_BAB_TYPE">
<input type="<?= $Page->BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_TYPE" name="x_BAB_TYPE" id="x_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Page->BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Page->BAB_TYPE->EditValue ?>"<?= $Page->BAB_TYPE->editAttributes() ?> aria-describedby="x_BAB_TYPE_help">
<?= $Page->BAB_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BAB_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
    <div id="r_BAB_BAB_TYPE" class="form-group row">
        <label id="elh_OBSTETRI_BAB_BAB_TYPE" for="x_BAB_BAB_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BAB_BAB_TYPE->caption() ?><?= $Page->BAB_BAB_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAB_BAB_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_BAB_BAB_TYPE">
<input type="<?= $Page->BAB_BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" name="x_BAB_BAB_TYPE" id="x_BAB_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Page->BAB_BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Page->BAB_BAB_TYPE->EditValue ?>"<?= $Page->BAB_BAB_TYPE->editAttributes() ?> aria-describedby="x_BAB_BAB_TYPE_help">
<?= $Page->BAB_BAB_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BAB_BAB_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RAHIM_ID->Visible) { // RAHIM_ID ?>
    <div id="r_RAHIM_ID" class="form-group row">
        <label id="elh_OBSTETRI_RAHIM_ID" for="x_RAHIM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RAHIM_ID->caption() ?><?= $Page->RAHIM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RAHIM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_ID">
<input type="<?= $Page->RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_ID" name="x_RAHIM_ID" id="x_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Page->RAHIM_ID->EditValue ?>"<?= $Page->RAHIM_ID->editAttributes() ?> aria-describedby="x_RAHIM_ID_help">
<?= $Page->RAHIM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RAHIM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
    <div id="r_BIR_RAHIM_ID" class="form-group row">
        <label id="elh_OBSTETRI_BIR_RAHIM_ID" for="x_BIR_RAHIM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIR_RAHIM_ID->caption() ?><?= $Page->BIR_RAHIM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIR_RAHIM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_BIR_RAHIM_ID">
<input type="<?= $Page->BIR_RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" name="x_BIR_RAHIM_ID" id="x_BIR_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->BIR_RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Page->BIR_RAHIM_ID->EditValue ?>"<?= $Page->BIR_RAHIM_ID->editAttributes() ?> aria-describedby="x_BIR_RAHIM_ID_help">
<?= $Page->BIR_RAHIM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIR_RAHIM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_OBSTETRI_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_VISIT_ID">
<input type="<?= $Page->VISIT_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_VISIT_ID" name="x_VISIT_ID" id="x_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Page->VISIT_ID->EditValue ?>"<?= $Page->VISIT_ID->editAttributes() ?> aria-describedby="x_VISIT_ID_help">
<?= $Page->VISIT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->VISIT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BLOODING->Visible) { // BLOODING ?>
    <div id="r_BLOODING" class="form-group row">
        <label id="elh_OBSTETRI_BLOODING" for="x_BLOODING" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BLOODING->caption() ?><?= $Page->BLOODING->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BLOODING->cellAttributes() ?>>
<span id="el_OBSTETRI_BLOODING">
<input type="<?= $Page->BLOODING->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BLOODING" name="x_BLOODING" id="x_BLOODING" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->BLOODING->getPlaceHolder()) ?>" value="<?= $Page->BLOODING->EditValue ?>"<?= $Page->BLOODING->editAttributes() ?> aria-describedby="x_BLOODING_help">
<?= $Page->BLOODING->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BLOODING->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_OBSTETRI_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_OBSTETRI_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_OBSTETRI_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_OBSTETRI_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIadd", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_OBSTETRI_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_OBSTETRI_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
    <div id="r_MODIFIED_FROM" class="form-group row">
        <label id="elh_OBSTETRI_MODIFIED_FROM" for="x_MODIFIED_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_FROM->caption() ?><?= $Page->MODIFIED_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_FROM->cellAttributes() ?>>
<span id="el_OBSTETRI_MODIFIED_FROM">
<input type="<?= $Page->MODIFIED_FROM->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" name="x_MODIFIED_FROM" id="x_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_FROM->EditValue ?>"<?= $Page->MODIFIED_FROM->editAttributes() ?> aria-describedby="x_MODIFIED_FROM_help">
<?= $Page->MODIFIED_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
    <div id="r_RAHIM_SALIN" class="form-group row">
        <label id="elh_OBSTETRI_RAHIM_SALIN" for="x_RAHIM_SALIN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RAHIM_SALIN->caption() ?><?= $Page->RAHIM_SALIN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RAHIM_SALIN->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_SALIN">
<input type="<?= $Page->RAHIM_SALIN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" name="x_RAHIM_SALIN" id="x_RAHIM_SALIN" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->RAHIM_SALIN->getPlaceHolder()) ?>" value="<?= $Page->RAHIM_SALIN->EditValue ?>"<?= $Page->RAHIM_SALIN->editAttributes() ?> aria-describedby="x_RAHIM_SALIN_help">
<?= $Page->RAHIM_SALIN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RAHIM_SALIN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
    <div id="r_RAHIM_NIFAS" class="form-group row">
        <label id="elh_OBSTETRI_RAHIM_NIFAS" for="x_RAHIM_NIFAS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RAHIM_NIFAS->caption() ?><?= $Page->RAHIM_NIFAS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RAHIM_NIFAS->cellAttributes() ?>>
<span id="el_OBSTETRI_RAHIM_NIFAS">
<input type="<?= $Page->RAHIM_NIFAS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" name="x_RAHIM_NIFAS" id="x_RAHIM_NIFAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->RAHIM_NIFAS->getPlaceHolder()) ?>" value="<?= $Page->RAHIM_NIFAS->EditValue ?>"<?= $Page->RAHIM_NIFAS->editAttributes() ?> aria-describedby="x_RAHIM_NIFAS_help">
<?= $Page->RAHIM_NIFAS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RAHIM_NIFAS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BAK_TYPE->Visible) { // BAK_TYPE ?>
    <div id="r_BAK_TYPE" class="form-group row">
        <label id="elh_OBSTETRI_BAK_TYPE" for="x_BAK_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BAK_TYPE->caption() ?><?= $Page->BAK_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BAK_TYPE->cellAttributes() ?>>
<span id="el_OBSTETRI_BAK_TYPE">
<input type="<?= $Page->BAK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAK_TYPE" name="x_BAK_TYPE" id="x_BAK_TYPE" size="30" placeholder="<?= HtmlEncode($Page->BAK_TYPE->getPlaceHolder()) ?>" value="<?= $Page->BAK_TYPE->EditValue ?>"<?= $Page->BAK_TYPE->editAttributes() ?> aria-describedby="x_BAK_TYPE_help">
<?= $Page->BAK_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BAK_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
    <div id="r_THENAME" class="form-group row">
        <label id="elh_OBSTETRI_THENAME" for="x_THENAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THENAME->caption() ?><?= $Page->THENAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THENAME->cellAttributes() ?>>
<span id="el_OBSTETRI_THENAME">
<input type="<?= $Page->THENAME->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THENAME" name="x_THENAME" id="x_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->THENAME->getPlaceHolder()) ?>" value="<?= $Page->THENAME->EditValue ?>"<?= $Page->THENAME->editAttributes() ?> aria-describedby="x_THENAME_help">
<?= $Page->THENAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THENAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
    <div id="r_THEADDRESS" class="form-group row">
        <label id="elh_OBSTETRI_THEADDRESS" for="x_THEADDRESS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEADDRESS->caption() ?><?= $Page->THEADDRESS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el_OBSTETRI_THEADDRESS">
<input type="<?= $Page->THEADDRESS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEADDRESS" name="x_THEADDRESS" id="x_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Page->THEADDRESS->EditValue ?>"<?= $Page->THEADDRESS->editAttributes() ?> aria-describedby="x_THEADDRESS_help">
<?= $Page->THEADDRESS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEADDRESS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
    <div id="r_THEID" class="form-group row">
        <label id="elh_OBSTETRI_THEID" for="x_THEID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->THEID->caption() ?><?= $Page->THEID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->THEID->cellAttributes() ?>>
<span id="el_OBSTETRI_THEID">
<input type="<?= $Page->THEID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEID" name="x_THEID" id="x_THEID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->THEID->getPlaceHolder()) ?>" value="<?= $Page->THEID->EditValue ?>"<?= $Page->THEID->editAttributes() ?> aria-describedby="x_THEID_help">
<?= $Page->THEID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->THEID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_OBSTETRI_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
    <div id="r_ISRJ" class="form-group row">
        <label id="elh_OBSTETRI_ISRJ" for="x_ISRJ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISRJ->caption() ?><?= $Page->ISRJ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el_OBSTETRI_ISRJ">
<input type="<?= $Page->ISRJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ISRJ" name="x_ISRJ" id="x_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISRJ->getPlaceHolder()) ?>" value="<?= $Page->ISRJ->EditValue ?>"<?= $Page->ISRJ->editAttributes() ?> aria-describedby="x_ISRJ_help">
<?= $Page->ISRJ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISRJ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label id="elh_OBSTETRI_AGEYEAR" for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEYEAR->caption() ?><?= $Page->AGEYEAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_OBSTETRI_AGEYEAR">
<input type="<?= $Page->AGEYEAR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEYEAR" name="x_AGEYEAR" id="x_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Page->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Page->AGEYEAR->EditValue ?>"<?= $Page->AGEYEAR->editAttributes() ?> aria-describedby="x_AGEYEAR_help">
<?= $Page->AGEYEAR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEYEAR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEMONTH->Visible) { // AGEMONTH ?>
    <div id="r_AGEMONTH" class="form-group row">
        <label id="elh_OBSTETRI_AGEMONTH" for="x_AGEMONTH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEMONTH->caption() ?><?= $Page->AGEMONTH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEMONTH->cellAttributes() ?>>
<span id="el_OBSTETRI_AGEMONTH">
<input type="<?= $Page->AGEMONTH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEMONTH" name="x_AGEMONTH" id="x_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Page->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Page->AGEMONTH->EditValue ?>"<?= $Page->AGEMONTH->editAttributes() ?> aria-describedby="x_AGEMONTH_help">
<?= $Page->AGEMONTH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEMONTH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEDAY->Visible) { // AGEDAY ?>
    <div id="r_AGEDAY" class="form-group row">
        <label id="elh_OBSTETRI_AGEDAY" for="x_AGEDAY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEDAY->caption() ?><?= $Page->AGEDAY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEDAY->cellAttributes() ?>>
<span id="el_OBSTETRI_AGEDAY">
<input type="<?= $Page->AGEDAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEDAY" name="x_AGEDAY" id="x_AGEDAY" size="30" placeholder="<?= HtmlEncode($Page->AGEDAY->getPlaceHolder()) ?>" value="<?= $Page->AGEDAY->EditValue ?>"<?= $Page->AGEDAY->editAttributes() ?> aria-describedby="x_AGEDAY_help">
<?= $Page->AGEDAY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AGEDAY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_OBSTETRI_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_OBSTETRI_GENDER">
<input type="<?= $Page->GENDER->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GENDER" name="x_GENDER" id="x_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->GENDER->getPlaceHolder()) ?>" value="<?= $Page->GENDER->EditValue ?>"<?= $Page->GENDER->editAttributes() ?> aria-describedby="x_GENDER_help">
<?= $Page->GENDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->GENDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
    <div id="r_CLASS_ROOM_ID" class="form-group row">
        <label id="elh_OBSTETRI_CLASS_ROOM_ID" for="x_CLASS_ROOM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLASS_ROOM_ID->caption() ?><?= $Page->CLASS_ROOM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_CLASS_ROOM_ID">
<input type="<?= $Page->CLASS_ROOM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" name="x_CLASS_ROOM_ID" id="x_CLASS_ROOM_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Page->CLASS_ROOM_ID->EditValue ?>"<?= $Page->CLASS_ROOM_ID->editAttributes() ?> aria-describedby="x_CLASS_ROOM_ID_help">
<?= $Page->CLASS_ROOM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BED_ID->Visible) { // BED_ID ?>
    <div id="r_BED_ID" class="form-group row">
        <label id="elh_OBSTETRI_BED_ID" for="x_BED_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BED_ID->caption() ?><?= $Page->BED_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BED_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_BED_ID">
<input type="<?= $Page->BED_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BED_ID" name="x_BED_ID" id="x_BED_ID" size="30" placeholder="<?= HtmlEncode($Page->BED_ID->getPlaceHolder()) ?>" value="<?= $Page->BED_ID->EditValue ?>"<?= $Page->BED_ID->editAttributes() ?> aria-describedby="x_BED_ID_help">
<?= $Page->BED_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BED_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KELUAR_ID->Visible) { // KELUAR_ID ?>
    <div id="r_KELUAR_ID" class="form-group row">
        <label id="elh_OBSTETRI_KELUAR_ID" for="x_KELUAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KELUAR_ID->caption() ?><?= $Page->KELUAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KELUAR_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_KELUAR_ID">
<input type="<?= $Page->KELUAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KELUAR_ID" name="x_KELUAR_ID" id="x_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Page->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Page->KELUAR_ID->EditValue ?>"<?= $Page->KELUAR_ID->editAttributes() ?> aria-describedby="x_KELUAR_ID_help">
<?= $Page->KELUAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KELUAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
    <div id="r_DOCTOR" class="form-group row">
        <label id="elh_OBSTETRI_DOCTOR" for="x_DOCTOR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOCTOR->caption() ?><?= $Page->DOCTOR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el_OBSTETRI_DOCTOR">
<input type="<?= $Page->DOCTOR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DOCTOR" name="x_DOCTOR" id="x_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->DOCTOR->getPlaceHolder()) ?>" value="<?= $Page->DOCTOR->EditValue ?>"<?= $Page->DOCTOR->editAttributes() ?> aria-describedby="x_DOCTOR_help">
<?= $Page->DOCTOR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOCTOR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
    <div id="r_NB_OBSTETRI" class="form-group row">
        <label id="elh_OBSTETRI_NB_OBSTETRI" for="x_NB_OBSTETRI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NB_OBSTETRI->caption() ?><?= $Page->NB_OBSTETRI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NB_OBSTETRI->cellAttributes() ?>>
<span id="el_OBSTETRI_NB_OBSTETRI">
<input type="<?= $Page->NB_OBSTETRI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" name="x_NB_OBSTETRI" id="x_NB_OBSTETRI" size="30" placeholder="<?= HtmlEncode($Page->NB_OBSTETRI->getPlaceHolder()) ?>" value="<?= $Page->NB_OBSTETRI->EditValue ?>"<?= $Page->NB_OBSTETRI->editAttributes() ?> aria-describedby="x_NB_OBSTETRI_help">
<?= $Page->NB_OBSTETRI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NB_OBSTETRI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
    <div id="r_OBSTETRI_DIE" class="form-group row">
        <label id="elh_OBSTETRI_OBSTETRI_DIE" for="x_OBSTETRI_DIE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OBSTETRI_DIE->caption() ?><?= $Page->OBSTETRI_DIE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OBSTETRI_DIE->cellAttributes() ?>>
<span id="el_OBSTETRI_OBSTETRI_DIE">
<input type="<?= $Page->OBSTETRI_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" name="x_OBSTETRI_DIE" id="x_OBSTETRI_DIE" size="30" placeholder="<?= HtmlEncode($Page->OBSTETRI_DIE->getPlaceHolder()) ?>" value="<?= $Page->OBSTETRI_DIE->EditValue ?>"<?= $Page->OBSTETRI_DIE->editAttributes() ?> aria-describedby="x_OBSTETRI_DIE_help">
<?= $Page->OBSTETRI_DIE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OBSTETRI_DIE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KAL_ID->Visible) { // KAL_ID ?>
    <div id="r_KAL_ID" class="form-group row">
        <label id="elh_OBSTETRI_KAL_ID" for="x_KAL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KAL_ID->caption() ?><?= $Page->KAL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KAL_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_KAL_ID">
<input type="<?= $Page->KAL_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KAL_ID" name="x_KAL_ID" id="x_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->KAL_ID->getPlaceHolder()) ?>" value="<?= $Page->KAL_ID->EditValue ?>"<?= $Page->KAL_ID->editAttributes() ?> aria-describedby="x_KAL_ID_help">
<?= $Page->KAL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KAL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
    <div id="r_DIAGNOSA_ID2" class="form-group row">
        <label id="elh_OBSTETRI_DIAGNOSA_ID2" for="x_DIAGNOSA_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIAGNOSA_ID2->caption() ?><?= $Page->DIAGNOSA_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIAGNOSA_ID2->cellAttributes() ?>>
<span id="el_OBSTETRI_DIAGNOSA_ID2">
<input type="<?= $Page->DIAGNOSA_ID2->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" name="x_DIAGNOSA_ID2" id="x_DIAGNOSA_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DIAGNOSA_ID2->getPlaceHolder()) ?>" value="<?= $Page->DIAGNOSA_ID2->EditValue ?>"<?= $Page->DIAGNOSA_ID2->editAttributes() ?> aria-describedby="x_DIAGNOSA_ID2_help">
<?= $Page->DIAGNOSA_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIAGNOSA_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APGAR_ID->Visible) { // APGAR_ID ?>
    <div id="r_APGAR_ID" class="form-group row">
        <label id="elh_OBSTETRI_APGAR_ID" for="x_APGAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APGAR_ID->caption() ?><?= $Page->APGAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APGAR_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_APGAR_ID">
<input type="<?= $Page->APGAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_APGAR_ID" name="x_APGAR_ID" id="x_APGAR_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->APGAR_ID->getPlaceHolder()) ?>" value="<?= $Page->APGAR_ID->EditValue ?>"<?= $Page->APGAR_ID->editAttributes() ?> aria-describedby="x_APGAR_ID_help">
<?= $Page->APGAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APGAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
    <div id="r_BIRTH_LAST_ID" class="form-group row">
        <label id="elh_OBSTETRI_BIRTH_LAST_ID" for="x_BIRTH_LAST_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BIRTH_LAST_ID->caption() ?><?= $Page->BIRTH_LAST_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BIRTH_LAST_ID->cellAttributes() ?>>
<span id="el_OBSTETRI_BIRTH_LAST_ID">
<input type="<?= $Page->BIRTH_LAST_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" name="x_BIRTH_LAST_ID" id="x_BIRTH_LAST_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->BIRTH_LAST_ID->getPlaceHolder()) ?>" value="<?= $Page->BIRTH_LAST_ID->EditValue ?>"<?= $Page->BIRTH_LAST_ID->editAttributes() ?> aria-describedby="x_BIRTH_LAST_ID_help">
<?= $Page->BIRTH_LAST_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BIRTH_LAST_ID->getErrorMessage() ?></div>
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
    ew.addEventHandlers("OBSTETRI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
