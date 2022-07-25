<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Set up and run Grid object
$Grid = Container("ObstetriGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fOBSTETRIgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fOBSTETRIgrid = new ew.Form("fOBSTETRIgrid", "grid");
    fOBSTETRIgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "OBSTETRI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.OBSTETRI)
        ew.vars.tables.OBSTETRI = currentTable;
    fOBSTETRIgrid.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
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
        var f = fOBSTETRIgrid,
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
    fOBSTETRIgrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fOBSTETRIgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "ORG_UNIT_CODE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "OBSTETRI_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "HPHT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "HTP", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PASIEN_DIAGNOSA_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIAGNOSA_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NO_REGISTRATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KOHORT_NB", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_NB", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_DURATION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_PLACE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ANTE_NATAL", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "EMPLOYEE_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLINIC_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_WAY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GESTASI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PARITY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NB_BABY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BABY_DIE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ABORTUS_KE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ABORTUS_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ABORTION_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_CAT", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_CON", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_RISK", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RISK_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "FOLLOW_UP", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIRUJUK_OLEH", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "INSPECTION_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PORSIO", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PEMBUKAAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KETUBAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PRESENTASI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "POSISI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PENURUNAN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "HEART_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "JANIN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "FREK_DJJ", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "PLACENTA", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "LOCHIA", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BAB_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BAB_BAB_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RAHIM_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIR_RAHIM_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "VISIT_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BLOODING", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DESCRIPTION", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_DATE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_BY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "MODIFIED_FROM", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RAHIM_SALIN", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "RAHIM_NIFAS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BAK_TYPE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THENAME", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEADDRESS", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "THEID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "STATUS_PASIEN_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ISRJ", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AGEYEAR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AGEMONTH", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "AGEDAY", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "GENDER", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "CLASS_ROOM_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BED_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KELUAR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DOCTOR", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "NB_OBSTETRI", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "OBSTETRI_DIE", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "KAL_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "DIAGNOSA_ID2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "APGAR_ID", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "BIRTH_LAST_ID", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fOBSTETRIgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fOBSTETRIgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fOBSTETRIgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> OBSTETRI">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fOBSTETRIgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_OBSTETRI" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_OBSTETRIgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th data-name="ORG_UNIT_CODE" class="<?= $Grid->ORG_UNIT_CODE->headerCellClass() ?>"><div id="elh_OBSTETRI_ORG_UNIT_CODE" class="OBSTETRI_ORG_UNIT_CODE"><?= $Grid->renderSort($Grid->ORG_UNIT_CODE) ?></div></th>
<?php } ?>
<?php if ($Grid->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <th data-name="OBSTETRI_ID" class="<?= $Grid->OBSTETRI_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_OBSTETRI_ID" class="OBSTETRI_OBSTETRI_ID"><?= $Grid->renderSort($Grid->OBSTETRI_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->HPHT->Visible) { // HPHT ?>
        <th data-name="HPHT" class="<?= $Grid->HPHT->headerCellClass() ?>"><div id="elh_OBSTETRI_HPHT" class="OBSTETRI_HPHT"><?= $Grid->renderSort($Grid->HPHT) ?></div></th>
<?php } ?>
<?php if ($Grid->HTP->Visible) { // HTP ?>
        <th data-name="HTP" class="<?= $Grid->HTP->headerCellClass() ?>"><div id="elh_OBSTETRI_HTP" class="OBSTETRI_HTP"><?= $Grid->renderSort($Grid->HTP) ?></div></th>
<?php } ?>
<?php if ($Grid->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <th data-name="PASIEN_DIAGNOSA_ID" class="<?= $Grid->PASIEN_DIAGNOSA_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_PASIEN_DIAGNOSA_ID" class="OBSTETRI_PASIEN_DIAGNOSA_ID"><?= $Grid->renderSort($Grid->PASIEN_DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <th data-name="DIAGNOSA_ID" class="<?= $Grid->DIAGNOSA_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_DIAGNOSA_ID" class="OBSTETRI_DIAGNOSA_ID"><?= $Grid->renderSort($Grid->DIAGNOSA_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th data-name="NO_REGISTRATION" class="<?= $Grid->NO_REGISTRATION->headerCellClass() ?>"><div id="elh_OBSTETRI_NO_REGISTRATION" class="OBSTETRI_NO_REGISTRATION"><?= $Grid->renderSort($Grid->NO_REGISTRATION) ?></div></th>
<?php } ?>
<?php if ($Grid->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <th data-name="KOHORT_NB" class="<?= $Grid->KOHORT_NB->headerCellClass() ?>"><div id="elh_OBSTETRI_KOHORT_NB" class="OBSTETRI_KOHORT_NB"><?= $Grid->renderSort($Grid->KOHORT_NB) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <th data-name="BIRTH_NB" class="<?= $Grid->BIRTH_NB->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_NB" class="OBSTETRI_BIRTH_NB"><?= $Grid->renderSort($Grid->BIRTH_NB) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <th data-name="BIRTH_DURATION" class="<?= $Grid->BIRTH_DURATION->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_DURATION" class="OBSTETRI_BIRTH_DURATION"><?= $Grid->renderSort($Grid->BIRTH_DURATION) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <th data-name="BIRTH_PLACE" class="<?= $Grid->BIRTH_PLACE->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_PLACE" class="OBSTETRI_BIRTH_PLACE"><?= $Grid->renderSort($Grid->BIRTH_PLACE) ?></div></th>
<?php } ?>
<?php if ($Grid->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <th data-name="ANTE_NATAL" class="<?= $Grid->ANTE_NATAL->headerCellClass() ?>"><div id="elh_OBSTETRI_ANTE_NATAL" class="OBSTETRI_ANTE_NATAL"><?= $Grid->renderSort($Grid->ANTE_NATAL) ?></div></th>
<?php } ?>
<?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th data-name="EMPLOYEE_ID" class="<?= $Grid->EMPLOYEE_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_EMPLOYEE_ID" class="OBSTETRI_EMPLOYEE_ID"><?= $Grid->renderSort($Grid->EMPLOYEE_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th data-name="CLINIC_ID" class="<?= $Grid->CLINIC_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_CLINIC_ID" class="OBSTETRI_CLINIC_ID"><?= $Grid->renderSort($Grid->CLINIC_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <th data-name="BIRTH_WAY" class="<?= $Grid->BIRTH_WAY->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_WAY" class="OBSTETRI_BIRTH_WAY"><?= $Grid->renderSort($Grid->BIRTH_WAY) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <th data-name="BIRTH_BY" class="<?= $Grid->BIRTH_BY->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_BY" class="OBSTETRI_BIRTH_BY"><?= $Grid->renderSort($Grid->BIRTH_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <th data-name="BIRTH_DATE" class="<?= $Grid->BIRTH_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_DATE" class="OBSTETRI_BIRTH_DATE"><?= $Grid->renderSort($Grid->BIRTH_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->GESTASI->Visible) { // GESTASI ?>
        <th data-name="GESTASI" class="<?= $Grid->GESTASI->headerCellClass() ?>"><div id="elh_OBSTETRI_GESTASI" class="OBSTETRI_GESTASI"><?= $Grid->renderSort($Grid->GESTASI) ?></div></th>
<?php } ?>
<?php if ($Grid->PARITY->Visible) { // PARITY ?>
        <th data-name="PARITY" class="<?= $Grid->PARITY->headerCellClass() ?>"><div id="elh_OBSTETRI_PARITY" class="OBSTETRI_PARITY"><?= $Grid->renderSort($Grid->PARITY) ?></div></th>
<?php } ?>
<?php if ($Grid->NB_BABY->Visible) { // NB_BABY ?>
        <th data-name="NB_BABY" class="<?= $Grid->NB_BABY->headerCellClass() ?>"><div id="elh_OBSTETRI_NB_BABY" class="OBSTETRI_NB_BABY"><?= $Grid->renderSort($Grid->NB_BABY) ?></div></th>
<?php } ?>
<?php if ($Grid->BABY_DIE->Visible) { // BABY_DIE ?>
        <th data-name="BABY_DIE" class="<?= $Grid->BABY_DIE->headerCellClass() ?>"><div id="elh_OBSTETRI_BABY_DIE" class="OBSTETRI_BABY_DIE"><?= $Grid->renderSort($Grid->BABY_DIE) ?></div></th>
<?php } ?>
<?php if ($Grid->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <th data-name="ABORTUS_KE" class="<?= $Grid->ABORTUS_KE->headerCellClass() ?>"><div id="elh_OBSTETRI_ABORTUS_KE" class="OBSTETRI_ABORTUS_KE"><?= $Grid->renderSort($Grid->ABORTUS_KE) ?></div></th>
<?php } ?>
<?php if ($Grid->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <th data-name="ABORTUS_ID" class="<?= $Grid->ABORTUS_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_ABORTUS_ID" class="OBSTETRI_ABORTUS_ID"><?= $Grid->renderSort($Grid->ABORTUS_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <th data-name="ABORTION_DATE" class="<?= $Grid->ABORTION_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_ABORTION_DATE" class="OBSTETRI_ABORTION_DATE"><?= $Grid->renderSort($Grid->ABORTION_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <th data-name="BIRTH_CAT" class="<?= $Grid->BIRTH_CAT->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_CAT" class="OBSTETRI_BIRTH_CAT"><?= $Grid->renderSort($Grid->BIRTH_CAT) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <th data-name="BIRTH_CON" class="<?= $Grid->BIRTH_CON->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_CON" class="OBSTETRI_BIRTH_CON"><?= $Grid->renderSort($Grid->BIRTH_CON) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <th data-name="BIRTH_RISK" class="<?= $Grid->BIRTH_RISK->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_RISK" class="OBSTETRI_BIRTH_RISK"><?= $Grid->renderSort($Grid->BIRTH_RISK) ?></div></th>
<?php } ?>
<?php if ($Grid->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <th data-name="RISK_TYPE" class="<?= $Grid->RISK_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_RISK_TYPE" class="OBSTETRI_RISK_TYPE"><?= $Grid->renderSort($Grid->RISK_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <th data-name="FOLLOW_UP" class="<?= $Grid->FOLLOW_UP->headerCellClass() ?>"><div id="elh_OBSTETRI_FOLLOW_UP" class="OBSTETRI_FOLLOW_UP"><?= $Grid->renderSort($Grid->FOLLOW_UP) ?></div></th>
<?php } ?>
<?php if ($Grid->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <th data-name="DIRUJUK_OLEH" class="<?= $Grid->DIRUJUK_OLEH->headerCellClass() ?>"><div id="elh_OBSTETRI_DIRUJUK_OLEH" class="OBSTETRI_DIRUJUK_OLEH"><?= $Grid->renderSort($Grid->DIRUJUK_OLEH) ?></div></th>
<?php } ?>
<?php if ($Grid->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <th data-name="INSPECTION_DATE" class="<?= $Grid->INSPECTION_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_INSPECTION_DATE" class="OBSTETRI_INSPECTION_DATE"><?= $Grid->renderSort($Grid->INSPECTION_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->PORSIO->Visible) { // PORSIO ?>
        <th data-name="PORSIO" class="<?= $Grid->PORSIO->headerCellClass() ?>"><div id="elh_OBSTETRI_PORSIO" class="OBSTETRI_PORSIO"><?= $Grid->renderSort($Grid->PORSIO) ?></div></th>
<?php } ?>
<?php if ($Grid->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <th data-name="PEMBUKAAN" class="<?= $Grid->PEMBUKAAN->headerCellClass() ?>"><div id="elh_OBSTETRI_PEMBUKAAN" class="OBSTETRI_PEMBUKAAN"><?= $Grid->renderSort($Grid->PEMBUKAAN) ?></div></th>
<?php } ?>
<?php if ($Grid->KETUBAN->Visible) { // KETUBAN ?>
        <th data-name="KETUBAN" class="<?= $Grid->KETUBAN->headerCellClass() ?>"><div id="elh_OBSTETRI_KETUBAN" class="OBSTETRI_KETUBAN"><?= $Grid->renderSort($Grid->KETUBAN) ?></div></th>
<?php } ?>
<?php if ($Grid->PRESENTASI->Visible) { // PRESENTASI ?>
        <th data-name="PRESENTASI" class="<?= $Grid->PRESENTASI->headerCellClass() ?>"><div id="elh_OBSTETRI_PRESENTASI" class="OBSTETRI_PRESENTASI"><?= $Grid->renderSort($Grid->PRESENTASI) ?></div></th>
<?php } ?>
<?php if ($Grid->POSISI->Visible) { // POSISI ?>
        <th data-name="POSISI" class="<?= $Grid->POSISI->headerCellClass() ?>"><div id="elh_OBSTETRI_POSISI" class="OBSTETRI_POSISI"><?= $Grid->renderSort($Grid->POSISI) ?></div></th>
<?php } ?>
<?php if ($Grid->PENURUNAN->Visible) { // PENURUNAN ?>
        <th data-name="PENURUNAN" class="<?= $Grid->PENURUNAN->headerCellClass() ?>"><div id="elh_OBSTETRI_PENURUNAN" class="OBSTETRI_PENURUNAN"><?= $Grid->renderSort($Grid->PENURUNAN) ?></div></th>
<?php } ?>
<?php if ($Grid->HEART_ID->Visible) { // HEART_ID ?>
        <th data-name="HEART_ID" class="<?= $Grid->HEART_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_HEART_ID" class="OBSTETRI_HEART_ID"><?= $Grid->renderSort($Grid->HEART_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->JANIN_ID->Visible) { // JANIN_ID ?>
        <th data-name="JANIN_ID" class="<?= $Grid->JANIN_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_JANIN_ID" class="OBSTETRI_JANIN_ID"><?= $Grid->renderSort($Grid->JANIN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <th data-name="FREK_DJJ" class="<?= $Grid->FREK_DJJ->headerCellClass() ?>"><div id="elh_OBSTETRI_FREK_DJJ" class="OBSTETRI_FREK_DJJ"><?= $Grid->renderSort($Grid->FREK_DJJ) ?></div></th>
<?php } ?>
<?php if ($Grid->PLACENTA->Visible) { // PLACENTA ?>
        <th data-name="PLACENTA" class="<?= $Grid->PLACENTA->headerCellClass() ?>"><div id="elh_OBSTETRI_PLACENTA" class="OBSTETRI_PLACENTA"><?= $Grid->renderSort($Grid->PLACENTA) ?></div></th>
<?php } ?>
<?php if ($Grid->LOCHIA->Visible) { // LOCHIA ?>
        <th data-name="LOCHIA" class="<?= $Grid->LOCHIA->headerCellClass() ?>"><div id="elh_OBSTETRI_LOCHIA" class="OBSTETRI_LOCHIA"><?= $Grid->renderSort($Grid->LOCHIA) ?></div></th>
<?php } ?>
<?php if ($Grid->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <th data-name="BAB_TYPE" class="<?= $Grid->BAB_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_BAB_TYPE" class="OBSTETRI_BAB_TYPE"><?= $Grid->renderSort($Grid->BAB_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <th data-name="BAB_BAB_TYPE" class="<?= $Grid->BAB_BAB_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_BAB_BAB_TYPE" class="OBSTETRI_BAB_BAB_TYPE"><?= $Grid->renderSort($Grid->BAB_BAB_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <th data-name="RAHIM_ID" class="<?= $Grid->RAHIM_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_RAHIM_ID" class="OBSTETRI_RAHIM_ID"><?= $Grid->renderSort($Grid->RAHIM_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <th data-name="BIR_RAHIM_ID" class="<?= $Grid->BIR_RAHIM_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_BIR_RAHIM_ID" class="OBSTETRI_BIR_RAHIM_ID"><?= $Grid->renderSort($Grid->BIR_RAHIM_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <th data-name="VISIT_ID" class="<?= $Grid->VISIT_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_VISIT_ID" class="OBSTETRI_VISIT_ID"><?= $Grid->renderSort($Grid->VISIT_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BLOODING->Visible) { // BLOODING ?>
        <th data-name="BLOODING" class="<?= $Grid->BLOODING->headerCellClass() ?>"><div id="elh_OBSTETRI_BLOODING" class="OBSTETRI_BLOODING"><?= $Grid->renderSort($Grid->BLOODING) ?></div></th>
<?php } ?>
<?php if ($Grid->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th data-name="DESCRIPTION" class="<?= $Grid->DESCRIPTION->headerCellClass() ?>"><div id="elh_OBSTETRI_DESCRIPTION" class="OBSTETRI_DESCRIPTION"><?= $Grid->renderSort($Grid->DESCRIPTION) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th data-name="MODIFIED_DATE" class="<?= $Grid->MODIFIED_DATE->headerCellClass() ?>"><div id="elh_OBSTETRI_MODIFIED_DATE" class="OBSTETRI_MODIFIED_DATE"><?= $Grid->renderSort($Grid->MODIFIED_DATE) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th data-name="MODIFIED_BY" class="<?= $Grid->MODIFIED_BY->headerCellClass() ?>"><div id="elh_OBSTETRI_MODIFIED_BY" class="OBSTETRI_MODIFIED_BY"><?= $Grid->renderSort($Grid->MODIFIED_BY) ?></div></th>
<?php } ?>
<?php if ($Grid->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <th data-name="MODIFIED_FROM" class="<?= $Grid->MODIFIED_FROM->headerCellClass() ?>"><div id="elh_OBSTETRI_MODIFIED_FROM" class="OBSTETRI_MODIFIED_FROM"><?= $Grid->renderSort($Grid->MODIFIED_FROM) ?></div></th>
<?php } ?>
<?php if ($Grid->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <th data-name="RAHIM_SALIN" class="<?= $Grid->RAHIM_SALIN->headerCellClass() ?>"><div id="elh_OBSTETRI_RAHIM_SALIN" class="OBSTETRI_RAHIM_SALIN"><?= $Grid->renderSort($Grid->RAHIM_SALIN) ?></div></th>
<?php } ?>
<?php if ($Grid->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <th data-name="RAHIM_NIFAS" class="<?= $Grid->RAHIM_NIFAS->headerCellClass() ?>"><div id="elh_OBSTETRI_RAHIM_NIFAS" class="OBSTETRI_RAHIM_NIFAS"><?= $Grid->renderSort($Grid->RAHIM_NIFAS) ?></div></th>
<?php } ?>
<?php if ($Grid->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <th data-name="BAK_TYPE" class="<?= $Grid->BAK_TYPE->headerCellClass() ?>"><div id="elh_OBSTETRI_BAK_TYPE" class="OBSTETRI_BAK_TYPE"><?= $Grid->renderSort($Grid->BAK_TYPE) ?></div></th>
<?php } ?>
<?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <th data-name="THENAME" class="<?= $Grid->THENAME->headerCellClass() ?>"><div id="elh_OBSTETRI_THENAME" class="OBSTETRI_THENAME"><?= $Grid->renderSort($Grid->THENAME) ?></div></th>
<?php } ?>
<?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <th data-name="THEADDRESS" class="<?= $Grid->THEADDRESS->headerCellClass() ?>"><div id="elh_OBSTETRI_THEADDRESS" class="OBSTETRI_THEADDRESS"><?= $Grid->renderSort($Grid->THEADDRESS) ?></div></th>
<?php } ?>
<?php if ($Grid->THEID->Visible) { // THEID ?>
        <th data-name="THEID" class="<?= $Grid->THEID->headerCellClass() ?>"><div id="elh_OBSTETRI_THEID" class="OBSTETRI_THEID"><?= $Grid->renderSort($Grid->THEID) ?></div></th>
<?php } ?>
<?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th data-name="STATUS_PASIEN_ID" class="<?= $Grid->STATUS_PASIEN_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_STATUS_PASIEN_ID" class="OBSTETRI_STATUS_PASIEN_ID"><?= $Grid->renderSort($Grid->STATUS_PASIEN_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->ISRJ->Visible) { // ISRJ ?>
        <th data-name="ISRJ" class="<?= $Grid->ISRJ->headerCellClass() ?>"><div id="elh_OBSTETRI_ISRJ" class="OBSTETRI_ISRJ"><?= $Grid->renderSort($Grid->ISRJ) ?></div></th>
<?php } ?>
<?php if ($Grid->AGEYEAR->Visible) { // AGEYEAR ?>
        <th data-name="AGEYEAR" class="<?= $Grid->AGEYEAR->headerCellClass() ?>"><div id="elh_OBSTETRI_AGEYEAR" class="OBSTETRI_AGEYEAR"><?= $Grid->renderSort($Grid->AGEYEAR) ?></div></th>
<?php } ?>
<?php if ($Grid->AGEMONTH->Visible) { // AGEMONTH ?>
        <th data-name="AGEMONTH" class="<?= $Grid->AGEMONTH->headerCellClass() ?>"><div id="elh_OBSTETRI_AGEMONTH" class="OBSTETRI_AGEMONTH"><?= $Grid->renderSort($Grid->AGEMONTH) ?></div></th>
<?php } ?>
<?php if ($Grid->AGEDAY->Visible) { // AGEDAY ?>
        <th data-name="AGEDAY" class="<?= $Grid->AGEDAY->headerCellClass() ?>"><div id="elh_OBSTETRI_AGEDAY" class="OBSTETRI_AGEDAY"><?= $Grid->renderSort($Grid->AGEDAY) ?></div></th>
<?php } ?>
<?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <th data-name="GENDER" class="<?= $Grid->GENDER->headerCellClass() ?>"><div id="elh_OBSTETRI_GENDER" class="OBSTETRI_GENDER"><?= $Grid->renderSort($Grid->GENDER) ?></div></th>
<?php } ?>
<?php if ($Grid->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <th data-name="CLASS_ROOM_ID" class="<?= $Grid->CLASS_ROOM_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_CLASS_ROOM_ID" class="OBSTETRI_CLASS_ROOM_ID"><?= $Grid->renderSort($Grid->CLASS_ROOM_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <th data-name="BED_ID" class="<?= $Grid->BED_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_BED_ID" class="OBSTETRI_BED_ID"><?= $Grid->renderSort($Grid->BED_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <th data-name="KELUAR_ID" class="<?= $Grid->KELUAR_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_KELUAR_ID" class="OBSTETRI_KELUAR_ID"><?= $Grid->renderSort($Grid->KELUAR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DOCTOR->Visible) { // DOCTOR ?>
        <th data-name="DOCTOR" class="<?= $Grid->DOCTOR->headerCellClass() ?>"><div id="elh_OBSTETRI_DOCTOR" class="OBSTETRI_DOCTOR"><?= $Grid->renderSort($Grid->DOCTOR) ?></div></th>
<?php } ?>
<?php if ($Grid->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <th data-name="NB_OBSTETRI" class="<?= $Grid->NB_OBSTETRI->headerCellClass() ?>"><div id="elh_OBSTETRI_NB_OBSTETRI" class="OBSTETRI_NB_OBSTETRI"><?= $Grid->renderSort($Grid->NB_OBSTETRI) ?></div></th>
<?php } ?>
<?php if ($Grid->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <th data-name="OBSTETRI_DIE" class="<?= $Grid->OBSTETRI_DIE->headerCellClass() ?>"><div id="elh_OBSTETRI_OBSTETRI_DIE" class="OBSTETRI_OBSTETRI_DIE"><?= $Grid->renderSort($Grid->OBSTETRI_DIE) ?></div></th>
<?php } ?>
<?php if ($Grid->KAL_ID->Visible) { // KAL_ID ?>
        <th data-name="KAL_ID" class="<?= $Grid->KAL_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_KAL_ID" class="OBSTETRI_KAL_ID"><?= $Grid->renderSort($Grid->KAL_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <th data-name="DIAGNOSA_ID2" class="<?= $Grid->DIAGNOSA_ID2->headerCellClass() ?>"><div id="elh_OBSTETRI_DIAGNOSA_ID2" class="OBSTETRI_DIAGNOSA_ID2"><?= $Grid->renderSort($Grid->DIAGNOSA_ID2) ?></div></th>
<?php } ?>
<?php if ($Grid->APGAR_ID->Visible) { // APGAR_ID ?>
        <th data-name="APGAR_ID" class="<?= $Grid->APGAR_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_APGAR_ID" class="OBSTETRI_APGAR_ID"><?= $Grid->renderSort($Grid->APGAR_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <th data-name="BIRTH_LAST_ID" class="<?= $Grid->BIRTH_LAST_ID->headerCellClass() ?>"><div id="elh_OBSTETRI_BIRTH_LAST_ID" class="OBSTETRI_BIRTH_LAST_ID"><?= $Grid->renderSort($Grid->BIRTH_LAST_ID) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_OBSTETRI", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE" <?= $Grid->ORG_UNIT_CODE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ORG_UNIT_CODE" class="form-group">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
<input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue ?? $Grid->ORG_UNIT_CODE->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Grid->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <td data-name="OBSTETRI_ID" <?= $Grid->OBSTETRI_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_OBSTETRI_ID" class="form-group">
<input type="<?= $Grid->OBSTETRI_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" name="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->OBSTETRI_ID->getPlaceHolder()) ?>" value="<?= $Grid->OBSTETRI_ID->EditValue ?>"<?= $Grid->OBSTETRI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OBSTETRI_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="o<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Grid->OBSTETRI_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" name="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->OBSTETRI_ID->getPlaceHolder()) ?>" value="<?= $Grid->OBSTETRI_ID->EditValue ?>"<?= $Grid->OBSTETRI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OBSTETRI_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="o<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->OldValue ?? $Grid->OBSTETRI_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_OBSTETRI_ID">
<span<?= $Grid->OBSTETRI_ID->viewAttributes() ?>>
<?= $Grid->OBSTETRI_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->HPHT->Visible) { // HPHT ?>
        <td data-name="HPHT" <?= $Grid->HPHT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HPHT" class="form-group">
<input type="<?= $Grid->HPHT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HPHT" name="x<?= $Grid->RowIndex ?>_HPHT" id="x<?= $Grid->RowIndex ?>_HPHT" placeholder="<?= HtmlEncode($Grid->HPHT->getPlaceHolder()) ?>" value="<?= $Grid->HPHT->EditValue ?>"<?= $Grid->HPHT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HPHT->getErrorMessage() ?></div>
<?php if (!$Grid->HPHT->ReadOnly && !$Grid->HPHT->Disabled && !isset($Grid->HPHT->EditAttrs["readonly"]) && !isset($Grid->HPHT->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_HPHT", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_HPHT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_HPHT" id="o<?= $Grid->RowIndex ?>_HPHT" value="<?= HtmlEncode($Grid->HPHT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HPHT" class="form-group">
<input type="<?= $Grid->HPHT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HPHT" name="x<?= $Grid->RowIndex ?>_HPHT" id="x<?= $Grid->RowIndex ?>_HPHT" placeholder="<?= HtmlEncode($Grid->HPHT->getPlaceHolder()) ?>" value="<?= $Grid->HPHT->EditValue ?>"<?= $Grid->HPHT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HPHT->getErrorMessage() ?></div>
<?php if (!$Grid->HPHT->ReadOnly && !$Grid->HPHT->Disabled && !isset($Grid->HPHT->EditAttrs["readonly"]) && !isset($Grid->HPHT->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_HPHT", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HPHT">
<span<?= $Grid->HPHT->viewAttributes() ?>>
<?= $Grid->HPHT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_HPHT" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_HPHT" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_HPHT" value="<?= HtmlEncode($Grid->HPHT->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_HPHT" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_HPHT" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_HPHT" value="<?= HtmlEncode($Grid->HPHT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->HTP->Visible) { // HTP ?>
        <td data-name="HTP" <?= $Grid->HTP->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HTP" class="form-group">
<input type="<?= $Grid->HTP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HTP" name="x<?= $Grid->RowIndex ?>_HTP" id="x<?= $Grid->RowIndex ?>_HTP" placeholder="<?= HtmlEncode($Grid->HTP->getPlaceHolder()) ?>" value="<?= $Grid->HTP->EditValue ?>"<?= $Grid->HTP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HTP->getErrorMessage() ?></div>
<?php if (!$Grid->HTP->ReadOnly && !$Grid->HTP->Disabled && !isset($Grid->HTP->EditAttrs["readonly"]) && !isset($Grid->HTP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_HTP", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_HTP" data-hidden="1" name="o<?= $Grid->RowIndex ?>_HTP" id="o<?= $Grid->RowIndex ?>_HTP" value="<?= HtmlEncode($Grid->HTP->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HTP" class="form-group">
<input type="<?= $Grid->HTP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HTP" name="x<?= $Grid->RowIndex ?>_HTP" id="x<?= $Grid->RowIndex ?>_HTP" placeholder="<?= HtmlEncode($Grid->HTP->getPlaceHolder()) ?>" value="<?= $Grid->HTP->EditValue ?>"<?= $Grid->HTP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HTP->getErrorMessage() ?></div>
<?php if (!$Grid->HTP->ReadOnly && !$Grid->HTP->Disabled && !isset($Grid->HTP->EditAttrs["readonly"]) && !isset($Grid->HTP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_HTP", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HTP">
<span<?= $Grid->HTP->viewAttributes() ?>>
<?= $Grid->HTP->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_HTP" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_HTP" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_HTP" value="<?= HtmlEncode($Grid->HTP->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_HTP" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_HTP" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_HTP" value="<?= HtmlEncode($Grid->HTP->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <td data-name="PASIEN_DIAGNOSA_ID" <?= $Grid->PASIEN_DIAGNOSA_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PASIEN_DIAGNOSA_ID" class="form-group">
<input type="<?= $Grid->PASIEN_DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_DIAGNOSA_ID->EditValue ?>"<?= $Grid->PASIEN_DIAGNOSA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="o<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PASIEN_DIAGNOSA_ID" class="form-group">
<input type="<?= $Grid->PASIEN_DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_DIAGNOSA_ID->EditValue ?>"<?= $Grid->PASIEN_DIAGNOSA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PASIEN_DIAGNOSA_ID">
<span<?= $Grid->PASIEN_DIAGNOSA_ID->viewAttributes() ?>>
<?= $Grid->PASIEN_DIAGNOSA_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td data-name="DIAGNOSA_ID" <?= $Grid->DIAGNOSA_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIAGNOSA_ID" class="form-group">
<input type="<?= $Grid->DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_ID->EditValue ?>"<?= $Grid->DIAGNOSA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIAGNOSA_ID" class="form-group">
<input type="<?= $Grid->DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_ID->EditValue ?>"<?= $Grid->DIAGNOSA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIAGNOSA_ID">
<span<?= $Grid->DIAGNOSA_ID->viewAttributes() ?>>
<?= $Grid->DIAGNOSA_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION" <?= $Grid->NO_REGISTRATION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NO_REGISTRATION" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NO_REGISTRATION" class="form-group">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NO_REGISTRATION" class="form-group">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<?= $Grid->NO_REGISTRATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <td data-name="KOHORT_NB" <?= $Grid->KOHORT_NB->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KOHORT_NB" class="form-group">
<input type="<?= $Grid->KOHORT_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KOHORT_NB" name="x<?= $Grid->RowIndex ?>_KOHORT_NB" id="x<?= $Grid->RowIndex ?>_KOHORT_NB" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->KOHORT_NB->getPlaceHolder()) ?>" value="<?= $Grid->KOHORT_NB->EditValue ?>"<?= $Grid->KOHORT_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KOHORT_NB->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KOHORT_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KOHORT_NB" id="o<?= $Grid->RowIndex ?>_KOHORT_NB" value="<?= HtmlEncode($Grid->KOHORT_NB->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KOHORT_NB" class="form-group">
<input type="<?= $Grid->KOHORT_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KOHORT_NB" name="x<?= $Grid->RowIndex ?>_KOHORT_NB" id="x<?= $Grid->RowIndex ?>_KOHORT_NB" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->KOHORT_NB->getPlaceHolder()) ?>" value="<?= $Grid->KOHORT_NB->EditValue ?>"<?= $Grid->KOHORT_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KOHORT_NB->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KOHORT_NB">
<span<?= $Grid->KOHORT_NB->viewAttributes() ?>>
<?= $Grid->KOHORT_NB->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KOHORT_NB" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KOHORT_NB" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KOHORT_NB" value="<?= HtmlEncode($Grid->KOHORT_NB->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_KOHORT_NB" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KOHORT_NB" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KOHORT_NB" value="<?= HtmlEncode($Grid->KOHORT_NB->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <td data-name="BIRTH_NB" <?= $Grid->BIRTH_NB->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_NB" class="form-group">
<input type="<?= $Grid->BIRTH_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_NB" name="x<?= $Grid->RowIndex ?>_BIRTH_NB" id="x<?= $Grid->RowIndex ?>_BIRTH_NB" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_NB->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_NB->EditValue ?>"<?= $Grid->BIRTH_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_NB->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_NB" id="o<?= $Grid->RowIndex ?>_BIRTH_NB" value="<?= HtmlEncode($Grid->BIRTH_NB->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_NB" class="form-group">
<input type="<?= $Grid->BIRTH_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_NB" name="x<?= $Grid->RowIndex ?>_BIRTH_NB" id="x<?= $Grid->RowIndex ?>_BIRTH_NB" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_NB->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_NB->EditValue ?>"<?= $Grid->BIRTH_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_NB->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_NB">
<span<?= $Grid->BIRTH_NB->viewAttributes() ?>>
<?= $Grid->BIRTH_NB->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_NB" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_NB" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_NB" value="<?= HtmlEncode($Grid->BIRTH_NB->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_NB" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_NB" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_NB" value="<?= HtmlEncode($Grid->BIRTH_NB->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <td data-name="BIRTH_DURATION" <?= $Grid->BIRTH_DURATION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_DURATION" class="form-group">
<input type="<?= $Grid->BIRTH_DURATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" name="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_DURATION->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_DURATION->EditValue ?>"<?= $Grid->BIRTH_DURATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_DURATION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="o<?= $Grid->RowIndex ?>_BIRTH_DURATION" value="<?= HtmlEncode($Grid->BIRTH_DURATION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_DURATION" class="form-group">
<input type="<?= $Grid->BIRTH_DURATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" name="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_DURATION->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_DURATION->EditValue ?>"<?= $Grid->BIRTH_DURATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_DURATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_DURATION">
<span<?= $Grid->BIRTH_DURATION->viewAttributes() ?>>
<?= $Grid->BIRTH_DURATION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_DURATION" value="<?= HtmlEncode($Grid->BIRTH_DURATION->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_DURATION" value="<?= HtmlEncode($Grid->BIRTH_DURATION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <td data-name="BIRTH_PLACE" <?= $Grid->BIRTH_PLACE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_PLACE" class="form-group">
<input type="<?= $Grid->BIRTH_PLACE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" name="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_PLACE->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_PLACE->EditValue ?>"<?= $Grid->BIRTH_PLACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_PLACE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="o<?= $Grid->RowIndex ?>_BIRTH_PLACE" value="<?= HtmlEncode($Grid->BIRTH_PLACE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_PLACE" class="form-group">
<input type="<?= $Grid->BIRTH_PLACE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" name="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_PLACE->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_PLACE->EditValue ?>"<?= $Grid->BIRTH_PLACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_PLACE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_PLACE">
<span<?= $Grid->BIRTH_PLACE->viewAttributes() ?>>
<?= $Grid->BIRTH_PLACE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_PLACE" value="<?= HtmlEncode($Grid->BIRTH_PLACE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_PLACE" value="<?= HtmlEncode($Grid->BIRTH_PLACE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <td data-name="ANTE_NATAL" <?= $Grid->ANTE_NATAL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ANTE_NATAL" class="form-group">
<input type="<?= $Grid->ANTE_NATAL->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ANTE_NATAL" name="x<?= $Grid->RowIndex ?>_ANTE_NATAL" id="x<?= $Grid->RowIndex ?>_ANTE_NATAL" size="30" placeholder="<?= HtmlEncode($Grid->ANTE_NATAL->getPlaceHolder()) ?>" value="<?= $Grid->ANTE_NATAL->EditValue ?>"<?= $Grid->ANTE_NATAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ANTE_NATAL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ANTE_NATAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ANTE_NATAL" id="o<?= $Grid->RowIndex ?>_ANTE_NATAL" value="<?= HtmlEncode($Grid->ANTE_NATAL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ANTE_NATAL" class="form-group">
<input type="<?= $Grid->ANTE_NATAL->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ANTE_NATAL" name="x<?= $Grid->RowIndex ?>_ANTE_NATAL" id="x<?= $Grid->RowIndex ?>_ANTE_NATAL" size="30" placeholder="<?= HtmlEncode($Grid->ANTE_NATAL->getPlaceHolder()) ?>" value="<?= $Grid->ANTE_NATAL->EditValue ?>"<?= $Grid->ANTE_NATAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ANTE_NATAL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ANTE_NATAL">
<span<?= $Grid->ANTE_NATAL->viewAttributes() ?>>
<?= $Grid->ANTE_NATAL->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ANTE_NATAL" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ANTE_NATAL" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ANTE_NATAL" value="<?= HtmlEncode($Grid->ANTE_NATAL->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_ANTE_NATAL" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ANTE_NATAL" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ANTE_NATAL" value="<?= HtmlEncode($Grid->ANTE_NATAL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID" <?= $Grid->EMPLOYEE_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_EMPLOYEE_ID" class="form-group">
<input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID->EditValue ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_EMPLOYEE_ID" class="form-group">
<input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID->EditValue ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Grid->EMPLOYEE_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID" <?= $Grid->CLINIC_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_CLINIC_ID" class="form-group">
<input type="<?= $Grid->CLINIC_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLINIC_ID" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID->EditValue ?>"<?= $Grid->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_CLINIC_ID" class="form-group">
<input type="<?= $Grid->CLINIC_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLINIC_ID" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID->EditValue ?>"<?= $Grid->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<?= $Grid->CLINIC_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLINIC_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_CLINIC_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <td data-name="BIRTH_WAY" <?= $Grid->BIRTH_WAY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_WAY" class="form-group">
<input type="<?= $Grid->BIRTH_WAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_WAY" name="x<?= $Grid->RowIndex ?>_BIRTH_WAY" id="x<?= $Grid->RowIndex ?>_BIRTH_WAY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BIRTH_WAY->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_WAY->EditValue ?>"<?= $Grid->BIRTH_WAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_WAY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_WAY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_WAY" id="o<?= $Grid->RowIndex ?>_BIRTH_WAY" value="<?= HtmlEncode($Grid->BIRTH_WAY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_WAY" class="form-group">
<input type="<?= $Grid->BIRTH_WAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_WAY" name="x<?= $Grid->RowIndex ?>_BIRTH_WAY" id="x<?= $Grid->RowIndex ?>_BIRTH_WAY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BIRTH_WAY->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_WAY->EditValue ?>"<?= $Grid->BIRTH_WAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_WAY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_WAY">
<span<?= $Grid->BIRTH_WAY->viewAttributes() ?>>
<?= $Grid->BIRTH_WAY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_WAY" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_WAY" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_WAY" value="<?= HtmlEncode($Grid->BIRTH_WAY->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_WAY" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_WAY" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_WAY" value="<?= HtmlEncode($Grid->BIRTH_WAY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <td data-name="BIRTH_BY" <?= $Grid->BIRTH_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_BY" class="form-group">
<input type="<?= $Grid->BIRTH_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_BY" name="x<?= $Grid->RowIndex ?>_BIRTH_BY" id="x<?= $Grid->RowIndex ?>_BIRTH_BY" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_BY->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_BY->EditValue ?>"<?= $Grid->BIRTH_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_BY" id="o<?= $Grid->RowIndex ?>_BIRTH_BY" value="<?= HtmlEncode($Grid->BIRTH_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_BY" class="form-group">
<input type="<?= $Grid->BIRTH_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_BY" name="x<?= $Grid->RowIndex ?>_BIRTH_BY" id="x<?= $Grid->RowIndex ?>_BIRTH_BY" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_BY->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_BY->EditValue ?>"<?= $Grid->BIRTH_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_BY">
<span<?= $Grid->BIRTH_BY->viewAttributes() ?>>
<?= $Grid->BIRTH_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_BY" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_BY" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_BY" value="<?= HtmlEncode($Grid->BIRTH_BY->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_BY" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_BY" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_BY" value="<?= HtmlEncode($Grid->BIRTH_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <td data-name="BIRTH_DATE" <?= $Grid->BIRTH_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_DATE" class="form-group">
<input type="<?= $Grid->BIRTH_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DATE" name="x<?= $Grid->RowIndex ?>_BIRTH_DATE" id="x<?= $Grid->RowIndex ?>_BIRTH_DATE" placeholder="<?= HtmlEncode($Grid->BIRTH_DATE->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_DATE->EditValue ?>"<?= $Grid->BIRTH_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->BIRTH_DATE->ReadOnly && !$Grid->BIRTH_DATE->Disabled && !isset($Grid->BIRTH_DATE->EditAttrs["readonly"]) && !isset($Grid->BIRTH_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_BIRTH_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_DATE" id="o<?= $Grid->RowIndex ?>_BIRTH_DATE" value="<?= HtmlEncode($Grid->BIRTH_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_DATE" class="form-group">
<input type="<?= $Grid->BIRTH_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DATE" name="x<?= $Grid->RowIndex ?>_BIRTH_DATE" id="x<?= $Grid->RowIndex ?>_BIRTH_DATE" placeholder="<?= HtmlEncode($Grid->BIRTH_DATE->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_DATE->EditValue ?>"<?= $Grid->BIRTH_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->BIRTH_DATE->ReadOnly && !$Grid->BIRTH_DATE->Disabled && !isset($Grid->BIRTH_DATE->EditAttrs["readonly"]) && !isset($Grid->BIRTH_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_BIRTH_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_DATE">
<span<?= $Grid->BIRTH_DATE->viewAttributes() ?>>
<?= $Grid->BIRTH_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DATE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_DATE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_DATE" value="<?= HtmlEncode($Grid->BIRTH_DATE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DATE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_DATE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_DATE" value="<?= HtmlEncode($Grid->BIRTH_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GESTASI->Visible) { // GESTASI ?>
        <td data-name="GESTASI" <?= $Grid->GESTASI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_GESTASI" class="form-group">
<input type="<?= $Grid->GESTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GESTASI" name="x<?= $Grid->RowIndex ?>_GESTASI" id="x<?= $Grid->RowIndex ?>_GESTASI" size="30" placeholder="<?= HtmlEncode($Grid->GESTASI->getPlaceHolder()) ?>" value="<?= $Grid->GESTASI->EditValue ?>"<?= $Grid->GESTASI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GESTASI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_GESTASI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GESTASI" id="o<?= $Grid->RowIndex ?>_GESTASI" value="<?= HtmlEncode($Grid->GESTASI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_GESTASI" class="form-group">
<input type="<?= $Grid->GESTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GESTASI" name="x<?= $Grid->RowIndex ?>_GESTASI" id="x<?= $Grid->RowIndex ?>_GESTASI" size="30" placeholder="<?= HtmlEncode($Grid->GESTASI->getPlaceHolder()) ?>" value="<?= $Grid->GESTASI->EditValue ?>"<?= $Grid->GESTASI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GESTASI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_GESTASI">
<span<?= $Grid->GESTASI->viewAttributes() ?>>
<?= $Grid->GESTASI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_GESTASI" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_GESTASI" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_GESTASI" value="<?= HtmlEncode($Grid->GESTASI->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_GESTASI" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_GESTASI" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_GESTASI" value="<?= HtmlEncode($Grid->GESTASI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PARITY->Visible) { // PARITY ?>
        <td data-name="PARITY" <?= $Grid->PARITY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PARITY" class="form-group">
<input type="<?= $Grid->PARITY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PARITY" name="x<?= $Grid->RowIndex ?>_PARITY" id="x<?= $Grid->RowIndex ?>_PARITY" size="30" placeholder="<?= HtmlEncode($Grid->PARITY->getPlaceHolder()) ?>" value="<?= $Grid->PARITY->EditValue ?>"<?= $Grid->PARITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PARITY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PARITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PARITY" id="o<?= $Grid->RowIndex ?>_PARITY" value="<?= HtmlEncode($Grid->PARITY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PARITY" class="form-group">
<input type="<?= $Grid->PARITY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PARITY" name="x<?= $Grid->RowIndex ?>_PARITY" id="x<?= $Grid->RowIndex ?>_PARITY" size="30" placeholder="<?= HtmlEncode($Grid->PARITY->getPlaceHolder()) ?>" value="<?= $Grid->PARITY->EditValue ?>"<?= $Grid->PARITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PARITY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PARITY">
<span<?= $Grid->PARITY->viewAttributes() ?>>
<?= $Grid->PARITY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PARITY" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PARITY" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PARITY" value="<?= HtmlEncode($Grid->PARITY->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PARITY" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PARITY" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PARITY" value="<?= HtmlEncode($Grid->PARITY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NB_BABY->Visible) { // NB_BABY ?>
        <td data-name="NB_BABY" <?= $Grid->NB_BABY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NB_BABY" class="form-group">
<input type="<?= $Grid->NB_BABY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_BABY" name="x<?= $Grid->RowIndex ?>_NB_BABY" id="x<?= $Grid->RowIndex ?>_NB_BABY" size="30" placeholder="<?= HtmlEncode($Grid->NB_BABY->getPlaceHolder()) ?>" value="<?= $Grid->NB_BABY->EditValue ?>"<?= $Grid->NB_BABY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NB_BABY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_BABY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NB_BABY" id="o<?= $Grid->RowIndex ?>_NB_BABY" value="<?= HtmlEncode($Grid->NB_BABY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NB_BABY" class="form-group">
<input type="<?= $Grid->NB_BABY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_BABY" name="x<?= $Grid->RowIndex ?>_NB_BABY" id="x<?= $Grid->RowIndex ?>_NB_BABY" size="30" placeholder="<?= HtmlEncode($Grid->NB_BABY->getPlaceHolder()) ?>" value="<?= $Grid->NB_BABY->EditValue ?>"<?= $Grid->NB_BABY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NB_BABY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NB_BABY">
<span<?= $Grid->NB_BABY->viewAttributes() ?>>
<?= $Grid->NB_BABY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_BABY" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_NB_BABY" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_NB_BABY" value="<?= HtmlEncode($Grid->NB_BABY->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_BABY" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_NB_BABY" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_NB_BABY" value="<?= HtmlEncode($Grid->NB_BABY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BABY_DIE->Visible) { // BABY_DIE ?>
        <td data-name="BABY_DIE" <?= $Grid->BABY_DIE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BABY_DIE" class="form-group">
<input type="<?= $Grid->BABY_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BABY_DIE" name="x<?= $Grid->RowIndex ?>_BABY_DIE" id="x<?= $Grid->RowIndex ?>_BABY_DIE" size="30" placeholder="<?= HtmlEncode($Grid->BABY_DIE->getPlaceHolder()) ?>" value="<?= $Grid->BABY_DIE->EditValue ?>"<?= $Grid->BABY_DIE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BABY_DIE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BABY_DIE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BABY_DIE" id="o<?= $Grid->RowIndex ?>_BABY_DIE" value="<?= HtmlEncode($Grid->BABY_DIE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BABY_DIE" class="form-group">
<input type="<?= $Grid->BABY_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BABY_DIE" name="x<?= $Grid->RowIndex ?>_BABY_DIE" id="x<?= $Grid->RowIndex ?>_BABY_DIE" size="30" placeholder="<?= HtmlEncode($Grid->BABY_DIE->getPlaceHolder()) ?>" value="<?= $Grid->BABY_DIE->EditValue ?>"<?= $Grid->BABY_DIE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BABY_DIE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BABY_DIE">
<span<?= $Grid->BABY_DIE->viewAttributes() ?>>
<?= $Grid->BABY_DIE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BABY_DIE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BABY_DIE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BABY_DIE" value="<?= HtmlEncode($Grid->BABY_DIE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BABY_DIE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BABY_DIE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BABY_DIE" value="<?= HtmlEncode($Grid->BABY_DIE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <td data-name="ABORTUS_KE" <?= $Grid->ABORTUS_KE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTUS_KE" class="form-group">
<input type="<?= $Grid->ABORTUS_KE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_KE" name="x<?= $Grid->RowIndex ?>_ABORTUS_KE" id="x<?= $Grid->RowIndex ?>_ABORTUS_KE" size="30" placeholder="<?= HtmlEncode($Grid->ABORTUS_KE->getPlaceHolder()) ?>" value="<?= $Grid->ABORTUS_KE->EditValue ?>"<?= $Grid->ABORTUS_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTUS_KE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_KE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ABORTUS_KE" id="o<?= $Grid->RowIndex ?>_ABORTUS_KE" value="<?= HtmlEncode($Grid->ABORTUS_KE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTUS_KE" class="form-group">
<input type="<?= $Grid->ABORTUS_KE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_KE" name="x<?= $Grid->RowIndex ?>_ABORTUS_KE" id="x<?= $Grid->RowIndex ?>_ABORTUS_KE" size="30" placeholder="<?= HtmlEncode($Grid->ABORTUS_KE->getPlaceHolder()) ?>" value="<?= $Grid->ABORTUS_KE->EditValue ?>"<?= $Grid->ABORTUS_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTUS_KE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTUS_KE">
<span<?= $Grid->ABORTUS_KE->viewAttributes() ?>>
<?= $Grid->ABORTUS_KE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_KE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ABORTUS_KE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ABORTUS_KE" value="<?= HtmlEncode($Grid->ABORTUS_KE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_KE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ABORTUS_KE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ABORTUS_KE" value="<?= HtmlEncode($Grid->ABORTUS_KE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <td data-name="ABORTUS_ID" <?= $Grid->ABORTUS_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTUS_ID" class="form-group">
<input type="<?= $Grid->ABORTUS_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_ID" name="x<?= $Grid->RowIndex ?>_ABORTUS_ID" id="x<?= $Grid->RowIndex ?>_ABORTUS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ABORTUS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ABORTUS_ID->EditValue ?>"<?= $Grid->ABORTUS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTUS_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ABORTUS_ID" id="o<?= $Grid->RowIndex ?>_ABORTUS_ID" value="<?= HtmlEncode($Grid->ABORTUS_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTUS_ID" class="form-group">
<input type="<?= $Grid->ABORTUS_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_ID" name="x<?= $Grid->RowIndex ?>_ABORTUS_ID" id="x<?= $Grid->RowIndex ?>_ABORTUS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ABORTUS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ABORTUS_ID->EditValue ?>"<?= $Grid->ABORTUS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTUS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTUS_ID">
<span<?= $Grid->ABORTUS_ID->viewAttributes() ?>>
<?= $Grid->ABORTUS_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ABORTUS_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ABORTUS_ID" value="<?= HtmlEncode($Grid->ABORTUS_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ABORTUS_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ABORTUS_ID" value="<?= HtmlEncode($Grid->ABORTUS_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <td data-name="ABORTION_DATE" <?= $Grid->ABORTION_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTION_DATE" class="form-group">
<input type="<?= $Grid->ABORTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTION_DATE" name="x<?= $Grid->RowIndex ?>_ABORTION_DATE" id="x<?= $Grid->RowIndex ?>_ABORTION_DATE" placeholder="<?= HtmlEncode($Grid->ABORTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ABORTION_DATE->EditValue ?>"<?= $Grid->ABORTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ABORTION_DATE->ReadOnly && !$Grid->ABORTION_DATE->Disabled && !isset($Grid->ABORTION_DATE->EditAttrs["readonly"]) && !isset($Grid->ABORTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_ABORTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ABORTION_DATE" id="o<?= $Grid->RowIndex ?>_ABORTION_DATE" value="<?= HtmlEncode($Grid->ABORTION_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTION_DATE" class="form-group">
<input type="<?= $Grid->ABORTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTION_DATE" name="x<?= $Grid->RowIndex ?>_ABORTION_DATE" id="x<?= $Grid->RowIndex ?>_ABORTION_DATE" placeholder="<?= HtmlEncode($Grid->ABORTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ABORTION_DATE->EditValue ?>"<?= $Grid->ABORTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ABORTION_DATE->ReadOnly && !$Grid->ABORTION_DATE->Disabled && !isset($Grid->ABORTION_DATE->EditAttrs["readonly"]) && !isset($Grid->ABORTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_ABORTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ABORTION_DATE">
<span<?= $Grid->ABORTION_DATE->viewAttributes() ?>>
<?= $Grid->ABORTION_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTION_DATE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ABORTION_DATE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ABORTION_DATE" value="<?= HtmlEncode($Grid->ABORTION_DATE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTION_DATE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ABORTION_DATE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ABORTION_DATE" value="<?= HtmlEncode($Grid->ABORTION_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <td data-name="BIRTH_CAT" <?= $Grid->BIRTH_CAT->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_CAT" class="form-group">
<input type="<?= $Grid->BIRTH_CAT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CAT" name="x<?= $Grid->RowIndex ?>_BIRTH_CAT" id="x<?= $Grid->RowIndex ?>_BIRTH_CAT" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BIRTH_CAT->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_CAT->EditValue ?>"<?= $Grid->BIRTH_CAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_CAT->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CAT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_CAT" id="o<?= $Grid->RowIndex ?>_BIRTH_CAT" value="<?= HtmlEncode($Grid->BIRTH_CAT->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_CAT" class="form-group">
<input type="<?= $Grid->BIRTH_CAT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CAT" name="x<?= $Grid->RowIndex ?>_BIRTH_CAT" id="x<?= $Grid->RowIndex ?>_BIRTH_CAT" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BIRTH_CAT->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_CAT->EditValue ?>"<?= $Grid->BIRTH_CAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_CAT->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_CAT">
<span<?= $Grid->BIRTH_CAT->viewAttributes() ?>>
<?= $Grid->BIRTH_CAT->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CAT" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_CAT" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_CAT" value="<?= HtmlEncode($Grid->BIRTH_CAT->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CAT" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_CAT" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_CAT" value="<?= HtmlEncode($Grid->BIRTH_CAT->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <td data-name="BIRTH_CON" <?= $Grid->BIRTH_CON->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_CON" class="form-group">
<input type="<?= $Grid->BIRTH_CON->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CON" name="x<?= $Grid->RowIndex ?>_BIRTH_CON" id="x<?= $Grid->RowIndex ?>_BIRTH_CON" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_CON->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_CON->EditValue ?>"<?= $Grid->BIRTH_CON->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_CON->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CON" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_CON" id="o<?= $Grid->RowIndex ?>_BIRTH_CON" value="<?= HtmlEncode($Grid->BIRTH_CON->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_CON" class="form-group">
<input type="<?= $Grid->BIRTH_CON->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CON" name="x<?= $Grid->RowIndex ?>_BIRTH_CON" id="x<?= $Grid->RowIndex ?>_BIRTH_CON" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_CON->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_CON->EditValue ?>"<?= $Grid->BIRTH_CON->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_CON->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_CON">
<span<?= $Grid->BIRTH_CON->viewAttributes() ?>>
<?= $Grid->BIRTH_CON->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CON" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_CON" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_CON" value="<?= HtmlEncode($Grid->BIRTH_CON->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CON" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_CON" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_CON" value="<?= HtmlEncode($Grid->BIRTH_CON->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <td data-name="BIRTH_RISK" <?= $Grid->BIRTH_RISK->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_RISK" class="form-group">
<input type="<?= $Grid->BIRTH_RISK->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_RISK" name="x<?= $Grid->RowIndex ?>_BIRTH_RISK" id="x<?= $Grid->RowIndex ?>_BIRTH_RISK" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_RISK->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_RISK->EditValue ?>"<?= $Grid->BIRTH_RISK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_RISK->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_RISK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_RISK" id="o<?= $Grid->RowIndex ?>_BIRTH_RISK" value="<?= HtmlEncode($Grid->BIRTH_RISK->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_RISK" class="form-group">
<input type="<?= $Grid->BIRTH_RISK->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_RISK" name="x<?= $Grid->RowIndex ?>_BIRTH_RISK" id="x<?= $Grid->RowIndex ?>_BIRTH_RISK" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_RISK->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_RISK->EditValue ?>"<?= $Grid->BIRTH_RISK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_RISK->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_RISK">
<span<?= $Grid->BIRTH_RISK->viewAttributes() ?>>
<?= $Grid->BIRTH_RISK->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_RISK" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_RISK" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_RISK" value="<?= HtmlEncode($Grid->BIRTH_RISK->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_RISK" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_RISK" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_RISK" value="<?= HtmlEncode($Grid->BIRTH_RISK->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <td data-name="RISK_TYPE" <?= $Grid->RISK_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RISK_TYPE" class="form-group">
<input type="<?= $Grid->RISK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RISK_TYPE" name="x<?= $Grid->RowIndex ?>_RISK_TYPE" id="x<?= $Grid->RowIndex ?>_RISK_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->RISK_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->RISK_TYPE->EditValue ?>"<?= $Grid->RISK_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RISK_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RISK_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RISK_TYPE" id="o<?= $Grid->RowIndex ?>_RISK_TYPE" value="<?= HtmlEncode($Grid->RISK_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RISK_TYPE" class="form-group">
<input type="<?= $Grid->RISK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RISK_TYPE" name="x<?= $Grid->RowIndex ?>_RISK_TYPE" id="x<?= $Grid->RowIndex ?>_RISK_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->RISK_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->RISK_TYPE->EditValue ?>"<?= $Grid->RISK_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RISK_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RISK_TYPE">
<span<?= $Grid->RISK_TYPE->viewAttributes() ?>>
<?= $Grid->RISK_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RISK_TYPE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RISK_TYPE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RISK_TYPE" value="<?= HtmlEncode($Grid->RISK_TYPE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_RISK_TYPE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RISK_TYPE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RISK_TYPE" value="<?= HtmlEncode($Grid->RISK_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <td data-name="FOLLOW_UP" <?= $Grid->FOLLOW_UP->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_FOLLOW_UP" class="form-group">
<input type="<?= $Grid->FOLLOW_UP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FOLLOW_UP" name="x<?= $Grid->RowIndex ?>_FOLLOW_UP" id="x<?= $Grid->RowIndex ?>_FOLLOW_UP" size="30" placeholder="<?= HtmlEncode($Grid->FOLLOW_UP->getPlaceHolder()) ?>" value="<?= $Grid->FOLLOW_UP->EditValue ?>"<?= $Grid->FOLLOW_UP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FOLLOW_UP->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_FOLLOW_UP" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FOLLOW_UP" id="o<?= $Grid->RowIndex ?>_FOLLOW_UP" value="<?= HtmlEncode($Grid->FOLLOW_UP->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_FOLLOW_UP" class="form-group">
<input type="<?= $Grid->FOLLOW_UP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FOLLOW_UP" name="x<?= $Grid->RowIndex ?>_FOLLOW_UP" id="x<?= $Grid->RowIndex ?>_FOLLOW_UP" size="30" placeholder="<?= HtmlEncode($Grid->FOLLOW_UP->getPlaceHolder()) ?>" value="<?= $Grid->FOLLOW_UP->EditValue ?>"<?= $Grid->FOLLOW_UP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FOLLOW_UP->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_FOLLOW_UP">
<span<?= $Grid->FOLLOW_UP->viewAttributes() ?>>
<?= $Grid->FOLLOW_UP->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_FOLLOW_UP" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_FOLLOW_UP" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_FOLLOW_UP" value="<?= HtmlEncode($Grid->FOLLOW_UP->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_FOLLOW_UP" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_FOLLOW_UP" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_FOLLOW_UP" value="<?= HtmlEncode($Grid->FOLLOW_UP->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <td data-name="DIRUJUK_OLEH" <?= $Grid->DIRUJUK_OLEH->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIRUJUK_OLEH" class="form-group">
<input type="<?= $Grid->DIRUJUK_OLEH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" name="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DIRUJUK_OLEH->getPlaceHolder()) ?>" value="<?= $Grid->DIRUJUK_OLEH->EditValue ?>"<?= $Grid->DIRUJUK_OLEH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIRUJUK_OLEH->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="o<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" value="<?= HtmlEncode($Grid->DIRUJUK_OLEH->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIRUJUK_OLEH" class="form-group">
<input type="<?= $Grid->DIRUJUK_OLEH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" name="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DIRUJUK_OLEH->getPlaceHolder()) ?>" value="<?= $Grid->DIRUJUK_OLEH->EditValue ?>"<?= $Grid->DIRUJUK_OLEH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIRUJUK_OLEH->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIRUJUK_OLEH">
<span<?= $Grid->DIRUJUK_OLEH->viewAttributes() ?>>
<?= $Grid->DIRUJUK_OLEH->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" value="<?= HtmlEncode($Grid->DIRUJUK_OLEH->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" value="<?= HtmlEncode($Grid->DIRUJUK_OLEH->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <td data-name="INSPECTION_DATE" <?= $Grid->INSPECTION_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_INSPECTION_DATE" class="form-group">
<input type="<?= $Grid->INSPECTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" name="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" placeholder="<?= HtmlEncode($Grid->INSPECTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->INSPECTION_DATE->EditValue ?>"<?= $Grid->INSPECTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INSPECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->INSPECTION_DATE->ReadOnly && !$Grid->INSPECTION_DATE->Disabled && !isset($Grid->INSPECTION_DATE->EditAttrs["readonly"]) && !isset($Grid->INSPECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_INSPECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="o<?= $Grid->RowIndex ?>_INSPECTION_DATE" value="<?= HtmlEncode($Grid->INSPECTION_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_INSPECTION_DATE" class="form-group">
<input type="<?= $Grid->INSPECTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" name="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" placeholder="<?= HtmlEncode($Grid->INSPECTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->INSPECTION_DATE->EditValue ?>"<?= $Grid->INSPECTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INSPECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->INSPECTION_DATE->ReadOnly && !$Grid->INSPECTION_DATE->Disabled && !isset($Grid->INSPECTION_DATE->EditAttrs["readonly"]) && !isset($Grid->INSPECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_INSPECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_INSPECTION_DATE">
<span<?= $Grid->INSPECTION_DATE->viewAttributes() ?>>
<?= $Grid->INSPECTION_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_INSPECTION_DATE" value="<?= HtmlEncode($Grid->INSPECTION_DATE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_INSPECTION_DATE" value="<?= HtmlEncode($Grid->INSPECTION_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PORSIO->Visible) { // PORSIO ?>
        <td data-name="PORSIO" <?= $Grid->PORSIO->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PORSIO" class="form-group">
<input type="<?= $Grid->PORSIO->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PORSIO" name="x<?= $Grid->RowIndex ?>_PORSIO" id="x<?= $Grid->RowIndex ?>_PORSIO" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PORSIO->getPlaceHolder()) ?>" value="<?= $Grid->PORSIO->EditValue ?>"<?= $Grid->PORSIO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PORSIO->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PORSIO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PORSIO" id="o<?= $Grid->RowIndex ?>_PORSIO" value="<?= HtmlEncode($Grid->PORSIO->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PORSIO" class="form-group">
<input type="<?= $Grid->PORSIO->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PORSIO" name="x<?= $Grid->RowIndex ?>_PORSIO" id="x<?= $Grid->RowIndex ?>_PORSIO" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PORSIO->getPlaceHolder()) ?>" value="<?= $Grid->PORSIO->EditValue ?>"<?= $Grid->PORSIO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PORSIO->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PORSIO">
<span<?= $Grid->PORSIO->viewAttributes() ?>>
<?= $Grid->PORSIO->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PORSIO" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PORSIO" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PORSIO" value="<?= HtmlEncode($Grid->PORSIO->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PORSIO" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PORSIO" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PORSIO" value="<?= HtmlEncode($Grid->PORSIO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <td data-name="PEMBUKAAN" <?= $Grid->PEMBUKAAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PEMBUKAAN" class="form-group">
<input type="<?= $Grid->PEMBUKAAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PEMBUKAAN" name="x<?= $Grid->RowIndex ?>_PEMBUKAAN" id="x<?= $Grid->RowIndex ?>_PEMBUKAAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PEMBUKAAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMBUKAAN->EditValue ?>"<?= $Grid->PEMBUKAAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMBUKAAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PEMBUKAAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PEMBUKAAN" id="o<?= $Grid->RowIndex ?>_PEMBUKAAN" value="<?= HtmlEncode($Grid->PEMBUKAAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PEMBUKAAN" class="form-group">
<input type="<?= $Grid->PEMBUKAAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PEMBUKAAN" name="x<?= $Grid->RowIndex ?>_PEMBUKAAN" id="x<?= $Grid->RowIndex ?>_PEMBUKAAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PEMBUKAAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMBUKAAN->EditValue ?>"<?= $Grid->PEMBUKAAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMBUKAAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PEMBUKAAN">
<span<?= $Grid->PEMBUKAAN->viewAttributes() ?>>
<?= $Grid->PEMBUKAAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PEMBUKAAN" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PEMBUKAAN" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PEMBUKAAN" value="<?= HtmlEncode($Grid->PEMBUKAAN->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PEMBUKAAN" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PEMBUKAAN" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PEMBUKAAN" value="<?= HtmlEncode($Grid->PEMBUKAAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KETUBAN->Visible) { // KETUBAN ?>
        <td data-name="KETUBAN" <?= $Grid->KETUBAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KETUBAN" class="form-group">
<input type="<?= $Grid->KETUBAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KETUBAN" name="x<?= $Grid->RowIndex ?>_KETUBAN" id="x<?= $Grid->RowIndex ?>_KETUBAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->KETUBAN->getPlaceHolder()) ?>" value="<?= $Grid->KETUBAN->EditValue ?>"<?= $Grid->KETUBAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KETUBAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KETUBAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KETUBAN" id="o<?= $Grid->RowIndex ?>_KETUBAN" value="<?= HtmlEncode($Grid->KETUBAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KETUBAN" class="form-group">
<input type="<?= $Grid->KETUBAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KETUBAN" name="x<?= $Grid->RowIndex ?>_KETUBAN" id="x<?= $Grid->RowIndex ?>_KETUBAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->KETUBAN->getPlaceHolder()) ?>" value="<?= $Grid->KETUBAN->EditValue ?>"<?= $Grid->KETUBAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KETUBAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KETUBAN">
<span<?= $Grid->KETUBAN->viewAttributes() ?>>
<?= $Grid->KETUBAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KETUBAN" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KETUBAN" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KETUBAN" value="<?= HtmlEncode($Grid->KETUBAN->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_KETUBAN" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KETUBAN" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KETUBAN" value="<?= HtmlEncode($Grid->KETUBAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PRESENTASI->Visible) { // PRESENTASI ?>
        <td data-name="PRESENTASI" <?= $Grid->PRESENTASI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PRESENTASI" class="form-group">
<input type="<?= $Grid->PRESENTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PRESENTASI" name="x<?= $Grid->RowIndex ?>_PRESENTASI" id="x<?= $Grid->RowIndex ?>_PRESENTASI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PRESENTASI->getPlaceHolder()) ?>" value="<?= $Grid->PRESENTASI->EditValue ?>"<?= $Grid->PRESENTASI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRESENTASI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PRESENTASI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRESENTASI" id="o<?= $Grid->RowIndex ?>_PRESENTASI" value="<?= HtmlEncode($Grid->PRESENTASI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PRESENTASI" class="form-group">
<input type="<?= $Grid->PRESENTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PRESENTASI" name="x<?= $Grid->RowIndex ?>_PRESENTASI" id="x<?= $Grid->RowIndex ?>_PRESENTASI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PRESENTASI->getPlaceHolder()) ?>" value="<?= $Grid->PRESENTASI->EditValue ?>"<?= $Grid->PRESENTASI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRESENTASI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PRESENTASI">
<span<?= $Grid->PRESENTASI->viewAttributes() ?>>
<?= $Grid->PRESENTASI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PRESENTASI" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PRESENTASI" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PRESENTASI" value="<?= HtmlEncode($Grid->PRESENTASI->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PRESENTASI" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PRESENTASI" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PRESENTASI" value="<?= HtmlEncode($Grid->PRESENTASI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->POSISI->Visible) { // POSISI ?>
        <td data-name="POSISI" <?= $Grid->POSISI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_POSISI" class="form-group">
<input type="<?= $Grid->POSISI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_POSISI" name="x<?= $Grid->RowIndex ?>_POSISI" id="x<?= $Grid->RowIndex ?>_POSISI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->POSISI->getPlaceHolder()) ?>" value="<?= $Grid->POSISI->EditValue ?>"<?= $Grid->POSISI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POSISI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_POSISI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POSISI" id="o<?= $Grid->RowIndex ?>_POSISI" value="<?= HtmlEncode($Grid->POSISI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_POSISI" class="form-group">
<input type="<?= $Grid->POSISI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_POSISI" name="x<?= $Grid->RowIndex ?>_POSISI" id="x<?= $Grid->RowIndex ?>_POSISI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->POSISI->getPlaceHolder()) ?>" value="<?= $Grid->POSISI->EditValue ?>"<?= $Grid->POSISI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POSISI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_POSISI">
<span<?= $Grid->POSISI->viewAttributes() ?>>
<?= $Grid->POSISI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_POSISI" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_POSISI" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_POSISI" value="<?= HtmlEncode($Grid->POSISI->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_POSISI" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_POSISI" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_POSISI" value="<?= HtmlEncode($Grid->POSISI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PENURUNAN->Visible) { // PENURUNAN ?>
        <td data-name="PENURUNAN" <?= $Grid->PENURUNAN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PENURUNAN" class="form-group">
<input type="<?= $Grid->PENURUNAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PENURUNAN" name="x<?= $Grid->RowIndex ?>_PENURUNAN" id="x<?= $Grid->RowIndex ?>_PENURUNAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PENURUNAN->getPlaceHolder()) ?>" value="<?= $Grid->PENURUNAN->EditValue ?>"<?= $Grid->PENURUNAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PENURUNAN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PENURUNAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PENURUNAN" id="o<?= $Grid->RowIndex ?>_PENURUNAN" value="<?= HtmlEncode($Grid->PENURUNAN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PENURUNAN" class="form-group">
<input type="<?= $Grid->PENURUNAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PENURUNAN" name="x<?= $Grid->RowIndex ?>_PENURUNAN" id="x<?= $Grid->RowIndex ?>_PENURUNAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PENURUNAN->getPlaceHolder()) ?>" value="<?= $Grid->PENURUNAN->EditValue ?>"<?= $Grid->PENURUNAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PENURUNAN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PENURUNAN">
<span<?= $Grid->PENURUNAN->viewAttributes() ?>>
<?= $Grid->PENURUNAN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PENURUNAN" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PENURUNAN" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PENURUNAN" value="<?= HtmlEncode($Grid->PENURUNAN->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PENURUNAN" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PENURUNAN" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PENURUNAN" value="<?= HtmlEncode($Grid->PENURUNAN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->HEART_ID->Visible) { // HEART_ID ?>
        <td data-name="HEART_ID" <?= $Grid->HEART_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HEART_ID" class="form-group">
<input type="<?= $Grid->HEART_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HEART_ID" name="x<?= $Grid->RowIndex ?>_HEART_ID" id="x<?= $Grid->RowIndex ?>_HEART_ID" size="30" placeholder="<?= HtmlEncode($Grid->HEART_ID->getPlaceHolder()) ?>" value="<?= $Grid->HEART_ID->EditValue ?>"<?= $Grid->HEART_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HEART_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_HEART_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_HEART_ID" id="o<?= $Grid->RowIndex ?>_HEART_ID" value="<?= HtmlEncode($Grid->HEART_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HEART_ID" class="form-group">
<input type="<?= $Grid->HEART_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HEART_ID" name="x<?= $Grid->RowIndex ?>_HEART_ID" id="x<?= $Grid->RowIndex ?>_HEART_ID" size="30" placeholder="<?= HtmlEncode($Grid->HEART_ID->getPlaceHolder()) ?>" value="<?= $Grid->HEART_ID->EditValue ?>"<?= $Grid->HEART_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HEART_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_HEART_ID">
<span<?= $Grid->HEART_ID->viewAttributes() ?>>
<?= $Grid->HEART_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_HEART_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_HEART_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_HEART_ID" value="<?= HtmlEncode($Grid->HEART_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_HEART_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_HEART_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_HEART_ID" value="<?= HtmlEncode($Grid->HEART_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->JANIN_ID->Visible) { // JANIN_ID ?>
        <td data-name="JANIN_ID" <?= $Grid->JANIN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_JANIN_ID" class="form-group">
<input type="<?= $Grid->JANIN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_JANIN_ID" name="x<?= $Grid->RowIndex ?>_JANIN_ID" id="x<?= $Grid->RowIndex ?>_JANIN_ID" size="30" placeholder="<?= HtmlEncode($Grid->JANIN_ID->getPlaceHolder()) ?>" value="<?= $Grid->JANIN_ID->EditValue ?>"<?= $Grid->JANIN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->JANIN_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_JANIN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_JANIN_ID" id="o<?= $Grid->RowIndex ?>_JANIN_ID" value="<?= HtmlEncode($Grid->JANIN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_JANIN_ID" class="form-group">
<input type="<?= $Grid->JANIN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_JANIN_ID" name="x<?= $Grid->RowIndex ?>_JANIN_ID" id="x<?= $Grid->RowIndex ?>_JANIN_ID" size="30" placeholder="<?= HtmlEncode($Grid->JANIN_ID->getPlaceHolder()) ?>" value="<?= $Grid->JANIN_ID->EditValue ?>"<?= $Grid->JANIN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->JANIN_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_JANIN_ID">
<span<?= $Grid->JANIN_ID->viewAttributes() ?>>
<?= $Grid->JANIN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_JANIN_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_JANIN_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_JANIN_ID" value="<?= HtmlEncode($Grid->JANIN_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_JANIN_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_JANIN_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_JANIN_ID" value="<?= HtmlEncode($Grid->JANIN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <td data-name="FREK_DJJ" <?= $Grid->FREK_DJJ->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_FREK_DJJ" class="form-group">
<input type="<?= $Grid->FREK_DJJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FREK_DJJ" name="x<?= $Grid->RowIndex ?>_FREK_DJJ" id="x<?= $Grid->RowIndex ?>_FREK_DJJ" size="30" placeholder="<?= HtmlEncode($Grid->FREK_DJJ->getPlaceHolder()) ?>" value="<?= $Grid->FREK_DJJ->EditValue ?>"<?= $Grid->FREK_DJJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FREK_DJJ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_FREK_DJJ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FREK_DJJ" id="o<?= $Grid->RowIndex ?>_FREK_DJJ" value="<?= HtmlEncode($Grid->FREK_DJJ->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_FREK_DJJ" class="form-group">
<input type="<?= $Grid->FREK_DJJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FREK_DJJ" name="x<?= $Grid->RowIndex ?>_FREK_DJJ" id="x<?= $Grid->RowIndex ?>_FREK_DJJ" size="30" placeholder="<?= HtmlEncode($Grid->FREK_DJJ->getPlaceHolder()) ?>" value="<?= $Grid->FREK_DJJ->EditValue ?>"<?= $Grid->FREK_DJJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FREK_DJJ->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_FREK_DJJ">
<span<?= $Grid->FREK_DJJ->viewAttributes() ?>>
<?= $Grid->FREK_DJJ->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_FREK_DJJ" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_FREK_DJJ" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_FREK_DJJ" value="<?= HtmlEncode($Grid->FREK_DJJ->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_FREK_DJJ" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_FREK_DJJ" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_FREK_DJJ" value="<?= HtmlEncode($Grid->FREK_DJJ->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->PLACENTA->Visible) { // PLACENTA ?>
        <td data-name="PLACENTA" <?= $Grid->PLACENTA->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PLACENTA" class="form-group">
<input type="<?= $Grid->PLACENTA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PLACENTA" name="x<?= $Grid->RowIndex ?>_PLACENTA" id="x<?= $Grid->RowIndex ?>_PLACENTA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->PLACENTA->getPlaceHolder()) ?>" value="<?= $Grid->PLACENTA->EditValue ?>"<?= $Grid->PLACENTA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PLACENTA->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PLACENTA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PLACENTA" id="o<?= $Grid->RowIndex ?>_PLACENTA" value="<?= HtmlEncode($Grid->PLACENTA->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PLACENTA" class="form-group">
<input type="<?= $Grid->PLACENTA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PLACENTA" name="x<?= $Grid->RowIndex ?>_PLACENTA" id="x<?= $Grid->RowIndex ?>_PLACENTA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->PLACENTA->getPlaceHolder()) ?>" value="<?= $Grid->PLACENTA->EditValue ?>"<?= $Grid->PLACENTA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PLACENTA->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_PLACENTA">
<span<?= $Grid->PLACENTA->viewAttributes() ?>>
<?= $Grid->PLACENTA->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PLACENTA" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PLACENTA" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_PLACENTA" value="<?= HtmlEncode($Grid->PLACENTA->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_PLACENTA" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PLACENTA" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_PLACENTA" value="<?= HtmlEncode($Grid->PLACENTA->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->LOCHIA->Visible) { // LOCHIA ?>
        <td data-name="LOCHIA" <?= $Grid->LOCHIA->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_LOCHIA" class="form-group">
<input type="<?= $Grid->LOCHIA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_LOCHIA" name="x<?= $Grid->RowIndex ?>_LOCHIA" id="x<?= $Grid->RowIndex ?>_LOCHIA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->LOCHIA->getPlaceHolder()) ?>" value="<?= $Grid->LOCHIA->EditValue ?>"<?= $Grid->LOCHIA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->LOCHIA->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_LOCHIA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_LOCHIA" id="o<?= $Grid->RowIndex ?>_LOCHIA" value="<?= HtmlEncode($Grid->LOCHIA->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_LOCHIA" class="form-group">
<input type="<?= $Grid->LOCHIA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_LOCHIA" name="x<?= $Grid->RowIndex ?>_LOCHIA" id="x<?= $Grid->RowIndex ?>_LOCHIA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->LOCHIA->getPlaceHolder()) ?>" value="<?= $Grid->LOCHIA->EditValue ?>"<?= $Grid->LOCHIA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->LOCHIA->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_LOCHIA">
<span<?= $Grid->LOCHIA->viewAttributes() ?>>
<?= $Grid->LOCHIA->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_LOCHIA" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_LOCHIA" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_LOCHIA" value="<?= HtmlEncode($Grid->LOCHIA->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_LOCHIA" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_LOCHIA" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_LOCHIA" value="<?= HtmlEncode($Grid->LOCHIA->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <td data-name="BAB_TYPE" <?= $Grid->BAB_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAB_TYPE" class="form-group">
<input type="<?= $Grid->BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_TYPE" name="x<?= $Grid->RowIndex ?>_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAB_TYPE->EditValue ?>"<?= $Grid->BAB_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAB_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAB_TYPE" id="o<?= $Grid->RowIndex ?>_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAB_TYPE" class="form-group">
<input type="<?= $Grid->BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_TYPE" name="x<?= $Grid->RowIndex ?>_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAB_TYPE->EditValue ?>"<?= $Grid->BAB_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAB_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAB_TYPE">
<span<?= $Grid->BAB_TYPE->viewAttributes() ?>>
<?= $Grid->BAB_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_TYPE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BAB_TYPE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_TYPE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_TYPE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BAB_TYPE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <td data-name="BAB_BAB_TYPE" <?= $Grid->BAB_BAB_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAB_BAB_TYPE" class="form-group">
<input type="<?= $Grid->BAB_BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" name="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAB_BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAB_BAB_TYPE->EditValue ?>"<?= $Grid->BAB_BAB_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAB_BAB_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="o<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_BAB_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAB_BAB_TYPE" class="form-group">
<input type="<?= $Grid->BAB_BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" name="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAB_BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAB_BAB_TYPE->EditValue ?>"<?= $Grid->BAB_BAB_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAB_BAB_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAB_BAB_TYPE">
<span<?= $Grid->BAB_BAB_TYPE->viewAttributes() ?>>
<?= $Grid->BAB_BAB_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_BAB_TYPE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_BAB_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <td data-name="RAHIM_ID" <?= $Grid->RAHIM_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_ID" class="form-group">
<input type="<?= $Grid->RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_ID" name="x<?= $Grid->RowIndex ?>_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_ID->EditValue ?>"<?= $Grid->RAHIM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RAHIM_ID" id="o<?= $Grid->RowIndex ?>_RAHIM_ID" value="<?= HtmlEncode($Grid->RAHIM_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_ID" class="form-group">
<input type="<?= $Grid->RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_ID" name="x<?= $Grid->RowIndex ?>_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_ID->EditValue ?>"<?= $Grid->RAHIM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_ID">
<span<?= $Grid->RAHIM_ID->viewAttributes() ?>>
<?= $Grid->RAHIM_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RAHIM_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RAHIM_ID" value="<?= HtmlEncode($Grid->RAHIM_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RAHIM_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RAHIM_ID" value="<?= HtmlEncode($Grid->RAHIM_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <td data-name="BIR_RAHIM_ID" <?= $Grid->BIR_RAHIM_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIR_RAHIM_ID" class="form-group">
<input type="<?= $Grid->BIR_RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" name="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->BIR_RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Grid->BIR_RAHIM_ID->EditValue ?>"<?= $Grid->BIR_RAHIM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIR_RAHIM_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="o<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" value="<?= HtmlEncode($Grid->BIR_RAHIM_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIR_RAHIM_ID" class="form-group">
<input type="<?= $Grid->BIR_RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" name="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->BIR_RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Grid->BIR_RAHIM_ID->EditValue ?>"<?= $Grid->BIR_RAHIM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIR_RAHIM_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIR_RAHIM_ID">
<span<?= $Grid->BIR_RAHIM_ID->viewAttributes() ?>>
<?= $Grid->BIR_RAHIM_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" value="<?= HtmlEncode($Grid->BIR_RAHIM_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" value="<?= HtmlEncode($Grid->BIR_RAHIM_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID" <?= $Grid->VISIT_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_VISIT_ID" class="form-group">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_VISIT_ID" class="form-group">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_VISIT_ID" class="form-group">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_VISIT_ID" class="form-group">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<?= $Grid->VISIT_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_VISIT_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_VISIT_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BLOODING->Visible) { // BLOODING ?>
        <td data-name="BLOODING" <?= $Grid->BLOODING->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BLOODING" class="form-group">
<input type="<?= $Grid->BLOODING->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BLOODING" name="x<?= $Grid->RowIndex ?>_BLOODING" id="x<?= $Grid->RowIndex ?>_BLOODING" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->BLOODING->getPlaceHolder()) ?>" value="<?= $Grid->BLOODING->EditValue ?>"<?= $Grid->BLOODING->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BLOODING->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BLOODING" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BLOODING" id="o<?= $Grid->RowIndex ?>_BLOODING" value="<?= HtmlEncode($Grid->BLOODING->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BLOODING" class="form-group">
<input type="<?= $Grid->BLOODING->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BLOODING" name="x<?= $Grid->RowIndex ?>_BLOODING" id="x<?= $Grid->RowIndex ?>_BLOODING" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->BLOODING->getPlaceHolder()) ?>" value="<?= $Grid->BLOODING->EditValue ?>"<?= $Grid->BLOODING->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BLOODING->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BLOODING">
<span<?= $Grid->BLOODING->viewAttributes() ?>>
<?= $Grid->BLOODING->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BLOODING" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BLOODING" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BLOODING" value="<?= HtmlEncode($Grid->BLOODING->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BLOODING" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BLOODING" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BLOODING" value="<?= HtmlEncode($Grid->BLOODING->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION" <?= $Grid->DESCRIPTION->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DESCRIPTION" class="form-group">
<input type="<?= $Grid->DESCRIPTION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DESCRIPTION" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION->EditValue ?>"<?= $Grid->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DESCRIPTION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DESCRIPTION" id="o<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DESCRIPTION" class="form-group">
<input type="<?= $Grid->DESCRIPTION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DESCRIPTION" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION->EditValue ?>"<?= $Grid->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DESCRIPTION">
<span<?= $Grid->DESCRIPTION->viewAttributes() ?>>
<?= $Grid->DESCRIPTION->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DESCRIPTION" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DESCRIPTION" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_DESCRIPTION" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DESCRIPTION" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE" <?= $Grid->MODIFIED_DATE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_DATE" class="form-group">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_DATE" class="form-group">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<?= $Grid->MODIFIED_DATE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY" <?= $Grid->MODIFIED_BY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_BY" class="form-group">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_BY" class="form-group">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<?= $Grid->MODIFIED_BY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_BY" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_BY" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM" <?= $Grid->MODIFIED_FROM->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_FROM" class="form-group">
<input type="<?= $Grid->MODIFIED_FROM->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_FROM->EditValue ?>"<?= $Grid->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_FROM" class="form-group">
<input type="<?= $Grid->MODIFIED_FROM->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_FROM->EditValue ?>"<?= $Grid->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_MODIFIED_FROM">
<span<?= $Grid->MODIFIED_FROM->viewAttributes() ?>>
<?= $Grid->MODIFIED_FROM->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <td data-name="RAHIM_SALIN" <?= $Grid->RAHIM_SALIN->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_SALIN" class="form-group">
<input type="<?= $Grid->RAHIM_SALIN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" name="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_SALIN->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_SALIN->EditValue ?>"<?= $Grid->RAHIM_SALIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_SALIN->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="o<?= $Grid->RowIndex ?>_RAHIM_SALIN" value="<?= HtmlEncode($Grid->RAHIM_SALIN->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_SALIN" class="form-group">
<input type="<?= $Grid->RAHIM_SALIN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" name="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_SALIN->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_SALIN->EditValue ?>"<?= $Grid->RAHIM_SALIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_SALIN->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_SALIN">
<span<?= $Grid->RAHIM_SALIN->viewAttributes() ?>>
<?= $Grid->RAHIM_SALIN->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RAHIM_SALIN" value="<?= HtmlEncode($Grid->RAHIM_SALIN->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RAHIM_SALIN" value="<?= HtmlEncode($Grid->RAHIM_SALIN->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <td data-name="RAHIM_NIFAS" <?= $Grid->RAHIM_NIFAS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_NIFAS" class="form-group">
<input type="<?= $Grid->RAHIM_NIFAS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" name="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_NIFAS->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_NIFAS->EditValue ?>"<?= $Grid->RAHIM_NIFAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_NIFAS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="o<?= $Grid->RowIndex ?>_RAHIM_NIFAS" value="<?= HtmlEncode($Grid->RAHIM_NIFAS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_NIFAS" class="form-group">
<input type="<?= $Grid->RAHIM_NIFAS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" name="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_NIFAS->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_NIFAS->EditValue ?>"<?= $Grid->RAHIM_NIFAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_NIFAS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_RAHIM_NIFAS">
<span<?= $Grid->RAHIM_NIFAS->viewAttributes() ?>>
<?= $Grid->RAHIM_NIFAS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" value="<?= HtmlEncode($Grid->RAHIM_NIFAS->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_RAHIM_NIFAS" value="<?= HtmlEncode($Grid->RAHIM_NIFAS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <td data-name="BAK_TYPE" <?= $Grid->BAK_TYPE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAK_TYPE" class="form-group">
<input type="<?= $Grid->BAK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAK_TYPE" name="x<?= $Grid->RowIndex ?>_BAK_TYPE" id="x<?= $Grid->RowIndex ?>_BAK_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAK_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAK_TYPE->EditValue ?>"<?= $Grid->BAK_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAK_TYPE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAK_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAK_TYPE" id="o<?= $Grid->RowIndex ?>_BAK_TYPE" value="<?= HtmlEncode($Grid->BAK_TYPE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAK_TYPE" class="form-group">
<input type="<?= $Grid->BAK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAK_TYPE" name="x<?= $Grid->RowIndex ?>_BAK_TYPE" id="x<?= $Grid->RowIndex ?>_BAK_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAK_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAK_TYPE->EditValue ?>"<?= $Grid->BAK_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAK_TYPE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BAK_TYPE">
<span<?= $Grid->BAK_TYPE->viewAttributes() ?>>
<?= $Grid->BAK_TYPE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAK_TYPE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BAK_TYPE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BAK_TYPE" value="<?= HtmlEncode($Grid->BAK_TYPE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BAK_TYPE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BAK_TYPE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BAK_TYPE" value="<?= HtmlEncode($Grid->BAK_TYPE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME" <?= $Grid->THENAME->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THENAME" class="form-group">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THENAME" class="form-group">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THENAME" class="form-group">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<?= $Grid->THENAME->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THENAME" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_THENAME" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_THENAME" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_THENAME" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS" <?= $Grid->THEADDRESS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->THEADDRESS->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEADDRESS" class="form-group">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->THEADDRESS->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEADDRESS" class="form-group">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEADDRESS" class="form-group">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<?= $Grid->THEADDRESS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEADDRESS" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_THEADDRESS" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID" <?= $Grid->THEID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->THEID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEID" class="form-group">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEID" name="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->THEID->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEID" class="form-group">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEID" name="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEID" class="form-group">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<?= $Grid->THEID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_THEID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_THEID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_THEID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID" <?= $Grid->STATUS_PASIEN_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_STATUS_PASIEN_ID" class="form-group">
<input type="<?= $Grid->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_PASIEN_ID->EditValue ?>"<?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_STATUS_PASIEN_ID" class="form-group">
<input type="<?= $Grid->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_PASIEN_ID->EditValue ?>"<?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Grid->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ" <?= $Grid->ISRJ->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ISRJ" class="form-group">
<input type="<?= $Grid->ISRJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ISRJ" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISRJ->getPlaceHolder()) ?>" value="<?= $Grid->ISRJ->EditValue ?>"<?= $Grid->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISRJ->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ISRJ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISRJ" id="o<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ISRJ" class="form-group">
<input type="<?= $Grid->ISRJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ISRJ" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISRJ->getPlaceHolder()) ?>" value="<?= $Grid->ISRJ->EditValue ?>"<?= $Grid->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISRJ->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_ISRJ">
<span<?= $Grid->ISRJ->viewAttributes() ?>>
<?= $Grid->ISRJ->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ISRJ" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ISRJ" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_ISRJ" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ISRJ" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR" <?= $Grid->AGEYEAR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEYEAR" class="form-group">
<input type="<?= $Grid->AGEYEAR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEYEAR" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Grid->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Grid->AGEYEAR->EditValue ?>"<?= $Grid->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEYEAR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEYEAR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEYEAR" id="o<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEYEAR" class="form-group">
<input type="<?= $Grid->AGEYEAR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEYEAR" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Grid->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Grid->AGEYEAR->EditValue ?>"<?= $Grid->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEYEAR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEYEAR">
<span<?= $Grid->AGEYEAR->viewAttributes() ?>>
<?= $Grid->AGEYEAR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEYEAR" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_AGEYEAR" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEYEAR" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_AGEYEAR" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH" <?= $Grid->AGEMONTH->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEMONTH" class="form-group">
<input type="<?= $Grid->AGEMONTH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEMONTH" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Grid->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Grid->AGEMONTH->EditValue ?>"<?= $Grid->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEMONTH->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEMONTH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEMONTH" id="o<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEMONTH" class="form-group">
<input type="<?= $Grid->AGEMONTH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEMONTH" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Grid->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Grid->AGEMONTH->EditValue ?>"<?= $Grid->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEMONTH->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEMONTH">
<span<?= $Grid->AGEMONTH->viewAttributes() ?>>
<?= $Grid->AGEMONTH->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEMONTH" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_AGEMONTH" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEMONTH" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_AGEMONTH" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY" <?= $Grid->AGEDAY->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEDAY" class="form-group">
<input type="<?= $Grid->AGEDAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEDAY" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" size="30" placeholder="<?= HtmlEncode($Grid->AGEDAY->getPlaceHolder()) ?>" value="<?= $Grid->AGEDAY->EditValue ?>"<?= $Grid->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEDAY->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEDAY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEDAY" id="o<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEDAY" class="form-group">
<input type="<?= $Grid->AGEDAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEDAY" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" size="30" placeholder="<?= HtmlEncode($Grid->AGEDAY->getPlaceHolder()) ?>" value="<?= $Grid->AGEDAY->EditValue ?>"<?= $Grid->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEDAY->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_AGEDAY">
<span<?= $Grid->AGEDAY->viewAttributes() ?>>
<?= $Grid->AGEDAY->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEDAY" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_AGEDAY" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEDAY" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_AGEDAY" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER" <?= $Grid->GENDER->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_GENDER" class="form-group">
<input type="<?= $Grid->GENDER->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" value="<?= $Grid->GENDER->EditValue ?>"<?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_GENDER" class="form-group">
<input type="<?= $Grid->GENDER->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" value="<?= $Grid->GENDER->EditValue ?>"<?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<?= $Grid->GENDER->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_GENDER" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_GENDER" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_GENDER" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_GENDER" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID" <?= $Grid->CLASS_ROOM_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_CLASS_ROOM_ID" class="form-group">
<input type="<?= $Grid->CLASS_ROOM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ROOM_ID->EditValue ?>"<?= $Grid->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_CLASS_ROOM_ID" class="form-group">
<input type="<?= $Grid->CLASS_ROOM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ROOM_ID->EditValue ?>"<?= $Grid->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_CLASS_ROOM_ID">
<span<?= $Grid->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $Grid->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID" <?= $Grid->BED_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BED_ID" class="form-group">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BED_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BED_ID" id="o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BED_ID" class="form-group">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BED_ID">
<span<?= $Grid->BED_ID->viewAttributes() ?>>
<?= $Grid->BED_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BED_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BED_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BED_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BED_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID" <?= $Grid->KELUAR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KELUAR_ID" class="form-group">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KELUAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KELUAR_ID" id="o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KELUAR_ID" class="form-group">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KELUAR_ID">
<span<?= $Grid->KELUAR_ID->viewAttributes() ?>>
<?= $Grid->KELUAR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KELUAR_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KELUAR_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_KELUAR_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KELUAR_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR" <?= $Grid->DOCTOR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DOCTOR" class="form-group">
<input type="<?= $Grid->DOCTOR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DOCTOR" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DOCTOR->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR->EditValue ?>"<?= $Grid->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DOCTOR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOCTOR" id="o<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DOCTOR" class="form-group">
<input type="<?= $Grid->DOCTOR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DOCTOR" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DOCTOR->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR->EditValue ?>"<?= $Grid->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DOCTOR">
<span<?= $Grid->DOCTOR->viewAttributes() ?>>
<?= $Grid->DOCTOR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DOCTOR" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DOCTOR" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_DOCTOR" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DOCTOR" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <td data-name="NB_OBSTETRI" <?= $Grid->NB_OBSTETRI->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NB_OBSTETRI" class="form-group">
<input type="<?= $Grid->NB_OBSTETRI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" name="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" size="30" placeholder="<?= HtmlEncode($Grid->NB_OBSTETRI->getPlaceHolder()) ?>" value="<?= $Grid->NB_OBSTETRI->EditValue ?>"<?= $Grid->NB_OBSTETRI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NB_OBSTETRI->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="o<?= $Grid->RowIndex ?>_NB_OBSTETRI" value="<?= HtmlEncode($Grid->NB_OBSTETRI->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NB_OBSTETRI" class="form-group">
<input type="<?= $Grid->NB_OBSTETRI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" name="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" size="30" placeholder="<?= HtmlEncode($Grid->NB_OBSTETRI->getPlaceHolder()) ?>" value="<?= $Grid->NB_OBSTETRI->EditValue ?>"<?= $Grid->NB_OBSTETRI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NB_OBSTETRI->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_NB_OBSTETRI">
<span<?= $Grid->NB_OBSTETRI->viewAttributes() ?>>
<?= $Grid->NB_OBSTETRI->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_NB_OBSTETRI" value="<?= HtmlEncode($Grid->NB_OBSTETRI->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_NB_OBSTETRI" value="<?= HtmlEncode($Grid->NB_OBSTETRI->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <td data-name="OBSTETRI_DIE" <?= $Grid->OBSTETRI_DIE->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_OBSTETRI_DIE" class="form-group">
<input type="<?= $Grid->OBSTETRI_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" name="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" size="30" placeholder="<?= HtmlEncode($Grid->OBSTETRI_DIE->getPlaceHolder()) ?>" value="<?= $Grid->OBSTETRI_DIE->EditValue ?>"<?= $Grid->OBSTETRI_DIE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OBSTETRI_DIE->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="o<?= $Grid->RowIndex ?>_OBSTETRI_DIE" value="<?= HtmlEncode($Grid->OBSTETRI_DIE->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_OBSTETRI_DIE" class="form-group">
<input type="<?= $Grid->OBSTETRI_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" name="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" size="30" placeholder="<?= HtmlEncode($Grid->OBSTETRI_DIE->getPlaceHolder()) ?>" value="<?= $Grid->OBSTETRI_DIE->EditValue ?>"<?= $Grid->OBSTETRI_DIE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OBSTETRI_DIE->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_OBSTETRI_DIE">
<span<?= $Grid->OBSTETRI_DIE->viewAttributes() ?>>
<?= $Grid->OBSTETRI_DIE->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" value="<?= HtmlEncode($Grid->OBSTETRI_DIE->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_OBSTETRI_DIE" value="<?= HtmlEncode($Grid->OBSTETRI_DIE->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID" <?= $Grid->KAL_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KAL_ID" class="form-group">
<input type="<?= $Grid->KAL_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KAL_ID" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KAL_ID->getPlaceHolder()) ?>" value="<?= $Grid->KAL_ID->EditValue ?>"<?= $Grid->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KAL_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KAL_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KAL_ID" id="o<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KAL_ID" class="form-group">
<input type="<?= $Grid->KAL_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KAL_ID" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KAL_ID->getPlaceHolder()) ?>" value="<?= $Grid->KAL_ID->EditValue ?>"<?= $Grid->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KAL_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_KAL_ID">
<span<?= $Grid->KAL_ID->viewAttributes() ?>>
<?= $Grid->KAL_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KAL_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KAL_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_KAL_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KAL_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <td data-name="DIAGNOSA_ID2" <?= $Grid->DIAGNOSA_ID2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIAGNOSA_ID2" class="form-group">
<input type="<?= $Grid->DIAGNOSA_ID2->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_ID2->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_ID2->EditValue ?>"<?= $Grid->DIAGNOSA_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" value="<?= HtmlEncode($Grid->DIAGNOSA_ID2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIAGNOSA_ID2" class="form-group">
<input type="<?= $Grid->DIAGNOSA_ID2->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_ID2->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_ID2->EditValue ?>"<?= $Grid->DIAGNOSA_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_DIAGNOSA_ID2">
<span<?= $Grid->DIAGNOSA_ID2->viewAttributes() ?>>
<?= $Grid->DIAGNOSA_ID2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" value="<?= HtmlEncode($Grid->DIAGNOSA_ID2->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" value="<?= HtmlEncode($Grid->DIAGNOSA_ID2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->APGAR_ID->Visible) { // APGAR_ID ?>
        <td data-name="APGAR_ID" <?= $Grid->APGAR_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_APGAR_ID" class="form-group">
<input type="<?= $Grid->APGAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_APGAR_ID" name="x<?= $Grid->RowIndex ?>_APGAR_ID" id="x<?= $Grid->RowIndex ?>_APGAR_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->APGAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->APGAR_ID->EditValue ?>"<?= $Grid->APGAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->APGAR_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_APGAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_APGAR_ID" id="o<?= $Grid->RowIndex ?>_APGAR_ID" value="<?= HtmlEncode($Grid->APGAR_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_APGAR_ID" class="form-group">
<input type="<?= $Grid->APGAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_APGAR_ID" name="x<?= $Grid->RowIndex ?>_APGAR_ID" id="x<?= $Grid->RowIndex ?>_APGAR_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->APGAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->APGAR_ID->EditValue ?>"<?= $Grid->APGAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->APGAR_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_APGAR_ID">
<span<?= $Grid->APGAR_ID->viewAttributes() ?>>
<?= $Grid->APGAR_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_APGAR_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_APGAR_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_APGAR_ID" value="<?= HtmlEncode($Grid->APGAR_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_APGAR_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_APGAR_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_APGAR_ID" value="<?= HtmlEncode($Grid->APGAR_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <td data-name="BIRTH_LAST_ID" <?= $Grid->BIRTH_LAST_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_LAST_ID" class="form-group">
<input type="<?= $Grid->BIRTH_LAST_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" name="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->BIRTH_LAST_ID->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_LAST_ID->EditValue ?>"<?= $Grid->BIRTH_LAST_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_LAST_ID->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="o<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" value="<?= HtmlEncode($Grid->BIRTH_LAST_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_LAST_ID" class="form-group">
<input type="<?= $Grid->BIRTH_LAST_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" name="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->BIRTH_LAST_ID->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_LAST_ID->EditValue ?>"<?= $Grid->BIRTH_LAST_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_LAST_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_OBSTETRI_BIRTH_LAST_ID">
<span<?= $Grid->BIRTH_LAST_ID->viewAttributes() ?>>
<?= $Grid->BIRTH_LAST_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" data-hidden="1" name="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="fOBSTETRIgrid$x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" value="<?= HtmlEncode($Grid->BIRTH_LAST_ID->FormValue) ?>">
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" data-hidden="1" name="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="fOBSTETRIgrid$o<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" value="<?= HtmlEncode($Grid->BIRTH_LAST_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid","load"], function () {
    fOBSTETRIgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_OBSTETRI", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td data-name="ORG_UNIT_CODE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_ORG_UNIT_CODE" class="form-group OBSTETRI_ORG_UNIT_CODE">
<input type="<?= $Grid->ORG_UNIT_CODE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Grid->ORG_UNIT_CODE->EditValue ?>"<?= $Grid->ORG_UNIT_CODE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ORG_UNIT_CODE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_ORG_UNIT_CODE" class="form-group OBSTETRI_ORG_UNIT_CODE">
<span<?= $Grid->ORG_UNIT_CODE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ORG_UNIT_CODE->getDisplayValue($Grid->ORG_UNIT_CODE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="x<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" id="o<?= $Grid->RowIndex ?>_ORG_UNIT_CODE" value="<?= HtmlEncode($Grid->ORG_UNIT_CODE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->OBSTETRI_ID->Visible) { // OBSTETRI_ID ?>
        <td data-name="OBSTETRI_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_OBSTETRI_ID" class="form-group OBSTETRI_OBSTETRI_ID">
<input type="<?= $Grid->OBSTETRI_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" name="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->OBSTETRI_ID->getPlaceHolder()) ?>" value="<?= $Grid->OBSTETRI_ID->EditValue ?>"<?= $Grid->OBSTETRI_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OBSTETRI_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_OBSTETRI_ID" class="form-group OBSTETRI_OBSTETRI_ID">
<span<?= $Grid->OBSTETRI_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->OBSTETRI_ID->getDisplayValue($Grid->OBSTETRI_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="x<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OBSTETRI_ID" id="o<?= $Grid->RowIndex ?>_OBSTETRI_ID" value="<?= HtmlEncode($Grid->OBSTETRI_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->HPHT->Visible) { // HPHT ?>
        <td data-name="HPHT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_HPHT" class="form-group OBSTETRI_HPHT">
<input type="<?= $Grid->HPHT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HPHT" name="x<?= $Grid->RowIndex ?>_HPHT" id="x<?= $Grid->RowIndex ?>_HPHT" placeholder="<?= HtmlEncode($Grid->HPHT->getPlaceHolder()) ?>" value="<?= $Grid->HPHT->EditValue ?>"<?= $Grid->HPHT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HPHT->getErrorMessage() ?></div>
<?php if (!$Grid->HPHT->ReadOnly && !$Grid->HPHT->Disabled && !isset($Grid->HPHT->EditAttrs["readonly"]) && !isset($Grid->HPHT->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_HPHT", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_HPHT" class="form-group OBSTETRI_HPHT">
<span<?= $Grid->HPHT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->HPHT->getDisplayValue($Grid->HPHT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_HPHT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_HPHT" id="x<?= $Grid->RowIndex ?>_HPHT" value="<?= HtmlEncode($Grid->HPHT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_HPHT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_HPHT" id="o<?= $Grid->RowIndex ?>_HPHT" value="<?= HtmlEncode($Grid->HPHT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->HTP->Visible) { // HTP ?>
        <td data-name="HTP">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_HTP" class="form-group OBSTETRI_HTP">
<input type="<?= $Grid->HTP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HTP" name="x<?= $Grid->RowIndex ?>_HTP" id="x<?= $Grid->RowIndex ?>_HTP" placeholder="<?= HtmlEncode($Grid->HTP->getPlaceHolder()) ?>" value="<?= $Grid->HTP->EditValue ?>"<?= $Grid->HTP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HTP->getErrorMessage() ?></div>
<?php if (!$Grid->HTP->ReadOnly && !$Grid->HTP->Disabled && !isset($Grid->HTP->EditAttrs["readonly"]) && !isset($Grid->HTP->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_HTP", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_HTP" class="form-group OBSTETRI_HTP">
<span<?= $Grid->HTP->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->HTP->getDisplayValue($Grid->HTP->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_HTP" data-hidden="1" name="x<?= $Grid->RowIndex ?>_HTP" id="x<?= $Grid->RowIndex ?>_HTP" value="<?= HtmlEncode($Grid->HTP->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_HTP" data-hidden="1" name="o<?= $Grid->RowIndex ?>_HTP" id="o<?= $Grid->RowIndex ?>_HTP" value="<?= HtmlEncode($Grid->HTP->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PASIEN_DIAGNOSA_ID->Visible) { // PASIEN_DIAGNOSA_ID ?>
        <td data-name="PASIEN_DIAGNOSA_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PASIEN_DIAGNOSA_ID" class="form-group OBSTETRI_PASIEN_DIAGNOSA_ID">
<input type="<?= $Grid->PASIEN_DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" name="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Grid->PASIEN_DIAGNOSA_ID->EditValue ?>"<?= $Grid->PASIEN_DIAGNOSA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PASIEN_DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PASIEN_DIAGNOSA_ID" class="form-group OBSTETRI_PASIEN_DIAGNOSA_ID">
<span<?= $Grid->PASIEN_DIAGNOSA_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PASIEN_DIAGNOSA_ID->getDisplayValue($Grid->PASIEN_DIAGNOSA_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PASIEN_DIAGNOSA_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" id="o<?= $Grid->RowIndex ?>_PASIEN_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->PASIEN_DIAGNOSA_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_ID->Visible) { // DIAGNOSA_ID ?>
        <td data-name="DIAGNOSA_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_DIAGNOSA_ID" class="form-group OBSTETRI_DIAGNOSA_ID">
<input type="<?= $Grid->DIAGNOSA_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_ID->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_ID->EditValue ?>"<?= $Grid->DIAGNOSA_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_DIAGNOSA_ID" class="form-group OBSTETRI_DIAGNOSA_ID">
<span<?= $Grid->DIAGNOSA_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIAGNOSA_ID->getDisplayValue($Grid->DIAGNOSA_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID" value="<?= HtmlEncode($Grid->DIAGNOSA_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td data-name="NO_REGISTRATION">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->NO_REGISTRATION->getSessionValue() != "") { ?>
<span id="el$rowindex$_OBSTETRI_NO_REGISTRATION" class="form-group OBSTETRI_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_NO_REGISTRATION" class="form-group OBSTETRI_NO_REGISTRATION">
<input type="<?= $Grid->NO_REGISTRATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->NO_REGISTRATION->getPlaceHolder()) ?>" value="<?= $Grid->NO_REGISTRATION->EditValue ?>"<?= $Grid->NO_REGISTRATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NO_REGISTRATION->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_NO_REGISTRATION" class="form-group OBSTETRI_NO_REGISTRATION">
<span<?= $Grid->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NO_REGISTRATION->getDisplayValue($Grid->NO_REGISTRATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="x<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NO_REGISTRATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" id="o<?= $Grid->RowIndex ?>_NO_REGISTRATION" value="<?= HtmlEncode($Grid->NO_REGISTRATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KOHORT_NB->Visible) { // KOHORT_NB ?>
        <td data-name="KOHORT_NB">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_KOHORT_NB" class="form-group OBSTETRI_KOHORT_NB">
<input type="<?= $Grid->KOHORT_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KOHORT_NB" name="x<?= $Grid->RowIndex ?>_KOHORT_NB" id="x<?= $Grid->RowIndex ?>_KOHORT_NB" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->KOHORT_NB->getPlaceHolder()) ?>" value="<?= $Grid->KOHORT_NB->EditValue ?>"<?= $Grid->KOHORT_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KOHORT_NB->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_KOHORT_NB" class="form-group OBSTETRI_KOHORT_NB">
<span<?= $Grid->KOHORT_NB->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KOHORT_NB->getDisplayValue($Grid->KOHORT_NB->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KOHORT_NB" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KOHORT_NB" id="x<?= $Grid->RowIndex ?>_KOHORT_NB" value="<?= HtmlEncode($Grid->KOHORT_NB->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KOHORT_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KOHORT_NB" id="o<?= $Grid->RowIndex ?>_KOHORT_NB" value="<?= HtmlEncode($Grid->KOHORT_NB->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_NB->Visible) { // BIRTH_NB ?>
        <td data-name="BIRTH_NB">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_NB" class="form-group OBSTETRI_BIRTH_NB">
<input type="<?= $Grid->BIRTH_NB->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_NB" name="x<?= $Grid->RowIndex ?>_BIRTH_NB" id="x<?= $Grid->RowIndex ?>_BIRTH_NB" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_NB->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_NB->EditValue ?>"<?= $Grid->BIRTH_NB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_NB->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_NB" class="form-group OBSTETRI_BIRTH_NB">
<span<?= $Grid->BIRTH_NB->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_NB->getDisplayValue($Grid->BIRTH_NB->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_NB" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_NB" id="x<?= $Grid->RowIndex ?>_BIRTH_NB" value="<?= HtmlEncode($Grid->BIRTH_NB->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_NB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_NB" id="o<?= $Grid->RowIndex ?>_BIRTH_NB" value="<?= HtmlEncode($Grid->BIRTH_NB->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_DURATION->Visible) { // BIRTH_DURATION ?>
        <td data-name="BIRTH_DURATION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_DURATION" class="form-group OBSTETRI_BIRTH_DURATION">
<input type="<?= $Grid->BIRTH_DURATION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" name="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_DURATION->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_DURATION->EditValue ?>"<?= $Grid->BIRTH_DURATION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_DURATION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_DURATION" class="form-group OBSTETRI_BIRTH_DURATION">
<span<?= $Grid->BIRTH_DURATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_DURATION->getDisplayValue($Grid->BIRTH_DURATION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="x<?= $Grid->RowIndex ?>_BIRTH_DURATION" value="<?= HtmlEncode($Grid->BIRTH_DURATION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DURATION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_DURATION" id="o<?= $Grid->RowIndex ?>_BIRTH_DURATION" value="<?= HtmlEncode($Grid->BIRTH_DURATION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_PLACE->Visible) { // BIRTH_PLACE ?>
        <td data-name="BIRTH_PLACE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_PLACE" class="form-group OBSTETRI_BIRTH_PLACE">
<input type="<?= $Grid->BIRTH_PLACE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" name="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_PLACE->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_PLACE->EditValue ?>"<?= $Grid->BIRTH_PLACE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_PLACE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_PLACE" class="form-group OBSTETRI_BIRTH_PLACE">
<span<?= $Grid->BIRTH_PLACE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_PLACE->getDisplayValue($Grid->BIRTH_PLACE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="x<?= $Grid->RowIndex ?>_BIRTH_PLACE" value="<?= HtmlEncode($Grid->BIRTH_PLACE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_PLACE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_PLACE" id="o<?= $Grid->RowIndex ?>_BIRTH_PLACE" value="<?= HtmlEncode($Grid->BIRTH_PLACE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ANTE_NATAL->Visible) { // ANTE_NATAL ?>
        <td data-name="ANTE_NATAL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_ANTE_NATAL" class="form-group OBSTETRI_ANTE_NATAL">
<input type="<?= $Grid->ANTE_NATAL->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ANTE_NATAL" name="x<?= $Grid->RowIndex ?>_ANTE_NATAL" id="x<?= $Grid->RowIndex ?>_ANTE_NATAL" size="30" placeholder="<?= HtmlEncode($Grid->ANTE_NATAL->getPlaceHolder()) ?>" value="<?= $Grid->ANTE_NATAL->EditValue ?>"<?= $Grid->ANTE_NATAL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ANTE_NATAL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_ANTE_NATAL" class="form-group OBSTETRI_ANTE_NATAL">
<span<?= $Grid->ANTE_NATAL->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ANTE_NATAL->getDisplayValue($Grid->ANTE_NATAL->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ANTE_NATAL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ANTE_NATAL" id="x<?= $Grid->RowIndex ?>_ANTE_NATAL" value="<?= HtmlEncode($Grid->ANTE_NATAL->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ANTE_NATAL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ANTE_NATAL" id="o<?= $Grid->RowIndex ?>_ANTE_NATAL" value="<?= HtmlEncode($Grid->ANTE_NATAL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td data-name="EMPLOYEE_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_EMPLOYEE_ID" class="form-group OBSTETRI_EMPLOYEE_ID">
<input type="<?= $Grid->EMPLOYEE_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->EMPLOYEE_ID->getPlaceHolder()) ?>" value="<?= $Grid->EMPLOYEE_ID->EditValue ?>"<?= $Grid->EMPLOYEE_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->EMPLOYEE_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_EMPLOYEE_ID" class="form-group OBSTETRI_EMPLOYEE_ID">
<span<?= $Grid->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->EMPLOYEE_ID->getDisplayValue($Grid->EMPLOYEE_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="x<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_EMPLOYEE_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" id="o<?= $Grid->RowIndex ?>_EMPLOYEE_ID" value="<?= HtmlEncode($Grid->EMPLOYEE_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td data-name="CLINIC_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_CLINIC_ID" class="form-group OBSTETRI_CLINIC_ID">
<input type="<?= $Grid->CLINIC_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLINIC_ID" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLINIC_ID->EditValue ?>"<?= $Grid->CLINIC_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLINIC_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_CLINIC_ID" class="form-group OBSTETRI_CLINIC_ID">
<span<?= $Grid->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLINIC_ID->getDisplayValue($Grid->CLINIC_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLINIC_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLINIC_ID" id="x<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLINIC_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLINIC_ID" id="o<?= $Grid->RowIndex ?>_CLINIC_ID" value="<?= HtmlEncode($Grid->CLINIC_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_WAY->Visible) { // BIRTH_WAY ?>
        <td data-name="BIRTH_WAY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_WAY" class="form-group OBSTETRI_BIRTH_WAY">
<input type="<?= $Grid->BIRTH_WAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_WAY" name="x<?= $Grid->RowIndex ?>_BIRTH_WAY" id="x<?= $Grid->RowIndex ?>_BIRTH_WAY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BIRTH_WAY->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_WAY->EditValue ?>"<?= $Grid->BIRTH_WAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_WAY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_WAY" class="form-group OBSTETRI_BIRTH_WAY">
<span<?= $Grid->BIRTH_WAY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_WAY->getDisplayValue($Grid->BIRTH_WAY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_WAY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_WAY" id="x<?= $Grid->RowIndex ?>_BIRTH_WAY" value="<?= HtmlEncode($Grid->BIRTH_WAY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_WAY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_WAY" id="o<?= $Grid->RowIndex ?>_BIRTH_WAY" value="<?= HtmlEncode($Grid->BIRTH_WAY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_BY->Visible) { // BIRTH_BY ?>
        <td data-name="BIRTH_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_BY" class="form-group OBSTETRI_BIRTH_BY">
<input type="<?= $Grid->BIRTH_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_BY" name="x<?= $Grid->RowIndex ?>_BIRTH_BY" id="x<?= $Grid->RowIndex ?>_BIRTH_BY" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_BY->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_BY->EditValue ?>"<?= $Grid->BIRTH_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_BY" class="form-group OBSTETRI_BIRTH_BY">
<span<?= $Grid->BIRTH_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_BY->getDisplayValue($Grid->BIRTH_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_BY" id="x<?= $Grid->RowIndex ?>_BIRTH_BY" value="<?= HtmlEncode($Grid->BIRTH_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_BY" id="o<?= $Grid->RowIndex ?>_BIRTH_BY" value="<?= HtmlEncode($Grid->BIRTH_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_DATE->Visible) { // BIRTH_DATE ?>
        <td data-name="BIRTH_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_DATE" class="form-group OBSTETRI_BIRTH_DATE">
<input type="<?= $Grid->BIRTH_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_DATE" name="x<?= $Grid->RowIndex ?>_BIRTH_DATE" id="x<?= $Grid->RowIndex ?>_BIRTH_DATE" placeholder="<?= HtmlEncode($Grid->BIRTH_DATE->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_DATE->EditValue ?>"<?= $Grid->BIRTH_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->BIRTH_DATE->ReadOnly && !$Grid->BIRTH_DATE->Disabled && !isset($Grid->BIRTH_DATE->EditAttrs["readonly"]) && !isset($Grid->BIRTH_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_BIRTH_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_DATE" class="form-group OBSTETRI_BIRTH_DATE">
<span<?= $Grid->BIRTH_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_DATE->getDisplayValue($Grid->BIRTH_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_DATE" id="x<?= $Grid->RowIndex ?>_BIRTH_DATE" value="<?= HtmlEncode($Grid->BIRTH_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_DATE" id="o<?= $Grid->RowIndex ?>_BIRTH_DATE" value="<?= HtmlEncode($Grid->BIRTH_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GESTASI->Visible) { // GESTASI ?>
        <td data-name="GESTASI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_GESTASI" class="form-group OBSTETRI_GESTASI">
<input type="<?= $Grid->GESTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GESTASI" name="x<?= $Grid->RowIndex ?>_GESTASI" id="x<?= $Grid->RowIndex ?>_GESTASI" size="30" placeholder="<?= HtmlEncode($Grid->GESTASI->getPlaceHolder()) ?>" value="<?= $Grid->GESTASI->EditValue ?>"<?= $Grid->GESTASI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GESTASI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_GESTASI" class="form-group OBSTETRI_GESTASI">
<span<?= $Grid->GESTASI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GESTASI->getDisplayValue($Grid->GESTASI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_GESTASI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GESTASI" id="x<?= $Grid->RowIndex ?>_GESTASI" value="<?= HtmlEncode($Grid->GESTASI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_GESTASI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GESTASI" id="o<?= $Grid->RowIndex ?>_GESTASI" value="<?= HtmlEncode($Grid->GESTASI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PARITY->Visible) { // PARITY ?>
        <td data-name="PARITY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PARITY" class="form-group OBSTETRI_PARITY">
<input type="<?= $Grid->PARITY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PARITY" name="x<?= $Grid->RowIndex ?>_PARITY" id="x<?= $Grid->RowIndex ?>_PARITY" size="30" placeholder="<?= HtmlEncode($Grid->PARITY->getPlaceHolder()) ?>" value="<?= $Grid->PARITY->EditValue ?>"<?= $Grid->PARITY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PARITY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PARITY" class="form-group OBSTETRI_PARITY">
<span<?= $Grid->PARITY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PARITY->getDisplayValue($Grid->PARITY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PARITY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PARITY" id="x<?= $Grid->RowIndex ?>_PARITY" value="<?= HtmlEncode($Grid->PARITY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PARITY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PARITY" id="o<?= $Grid->RowIndex ?>_PARITY" value="<?= HtmlEncode($Grid->PARITY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NB_BABY->Visible) { // NB_BABY ?>
        <td data-name="NB_BABY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_NB_BABY" class="form-group OBSTETRI_NB_BABY">
<input type="<?= $Grid->NB_BABY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_BABY" name="x<?= $Grid->RowIndex ?>_NB_BABY" id="x<?= $Grid->RowIndex ?>_NB_BABY" size="30" placeholder="<?= HtmlEncode($Grid->NB_BABY->getPlaceHolder()) ?>" value="<?= $Grid->NB_BABY->EditValue ?>"<?= $Grid->NB_BABY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NB_BABY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_NB_BABY" class="form-group OBSTETRI_NB_BABY">
<span<?= $Grid->NB_BABY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NB_BABY->getDisplayValue($Grid->NB_BABY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_BABY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NB_BABY" id="x<?= $Grid->RowIndex ?>_NB_BABY" value="<?= HtmlEncode($Grid->NB_BABY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_BABY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NB_BABY" id="o<?= $Grid->RowIndex ?>_NB_BABY" value="<?= HtmlEncode($Grid->NB_BABY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BABY_DIE->Visible) { // BABY_DIE ?>
        <td data-name="BABY_DIE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BABY_DIE" class="form-group OBSTETRI_BABY_DIE">
<input type="<?= $Grid->BABY_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BABY_DIE" name="x<?= $Grid->RowIndex ?>_BABY_DIE" id="x<?= $Grid->RowIndex ?>_BABY_DIE" size="30" placeholder="<?= HtmlEncode($Grid->BABY_DIE->getPlaceHolder()) ?>" value="<?= $Grid->BABY_DIE->EditValue ?>"<?= $Grid->BABY_DIE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BABY_DIE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BABY_DIE" class="form-group OBSTETRI_BABY_DIE">
<span<?= $Grid->BABY_DIE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BABY_DIE->getDisplayValue($Grid->BABY_DIE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BABY_DIE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BABY_DIE" id="x<?= $Grid->RowIndex ?>_BABY_DIE" value="<?= HtmlEncode($Grid->BABY_DIE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BABY_DIE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BABY_DIE" id="o<?= $Grid->RowIndex ?>_BABY_DIE" value="<?= HtmlEncode($Grid->BABY_DIE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ABORTUS_KE->Visible) { // ABORTUS_KE ?>
        <td data-name="ABORTUS_KE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_ABORTUS_KE" class="form-group OBSTETRI_ABORTUS_KE">
<input type="<?= $Grid->ABORTUS_KE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_KE" name="x<?= $Grid->RowIndex ?>_ABORTUS_KE" id="x<?= $Grid->RowIndex ?>_ABORTUS_KE" size="30" placeholder="<?= HtmlEncode($Grid->ABORTUS_KE->getPlaceHolder()) ?>" value="<?= $Grid->ABORTUS_KE->EditValue ?>"<?= $Grid->ABORTUS_KE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTUS_KE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_ABORTUS_KE" class="form-group OBSTETRI_ABORTUS_KE">
<span<?= $Grid->ABORTUS_KE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ABORTUS_KE->getDisplayValue($Grid->ABORTUS_KE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_KE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ABORTUS_KE" id="x<?= $Grid->RowIndex ?>_ABORTUS_KE" value="<?= HtmlEncode($Grid->ABORTUS_KE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_KE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ABORTUS_KE" id="o<?= $Grid->RowIndex ?>_ABORTUS_KE" value="<?= HtmlEncode($Grid->ABORTUS_KE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ABORTUS_ID->Visible) { // ABORTUS_ID ?>
        <td data-name="ABORTUS_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_ABORTUS_ID" class="form-group OBSTETRI_ABORTUS_ID">
<input type="<?= $Grid->ABORTUS_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTUS_ID" name="x<?= $Grid->RowIndex ?>_ABORTUS_ID" id="x<?= $Grid->RowIndex ?>_ABORTUS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->ABORTUS_ID->getPlaceHolder()) ?>" value="<?= $Grid->ABORTUS_ID->EditValue ?>"<?= $Grid->ABORTUS_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTUS_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_ABORTUS_ID" class="form-group OBSTETRI_ABORTUS_ID">
<span<?= $Grid->ABORTUS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ABORTUS_ID->getDisplayValue($Grid->ABORTUS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ABORTUS_ID" id="x<?= $Grid->RowIndex ?>_ABORTUS_ID" value="<?= HtmlEncode($Grid->ABORTUS_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTUS_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ABORTUS_ID" id="o<?= $Grid->RowIndex ?>_ABORTUS_ID" value="<?= HtmlEncode($Grid->ABORTUS_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ABORTION_DATE->Visible) { // ABORTION_DATE ?>
        <td data-name="ABORTION_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_ABORTION_DATE" class="form-group OBSTETRI_ABORTION_DATE">
<input type="<?= $Grid->ABORTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ABORTION_DATE" name="x<?= $Grid->RowIndex ?>_ABORTION_DATE" id="x<?= $Grid->RowIndex ?>_ABORTION_DATE" placeholder="<?= HtmlEncode($Grid->ABORTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->ABORTION_DATE->EditValue ?>"<?= $Grid->ABORTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ABORTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->ABORTION_DATE->ReadOnly && !$Grid->ABORTION_DATE->Disabled && !isset($Grid->ABORTION_DATE->EditAttrs["readonly"]) && !isset($Grid->ABORTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_ABORTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_ABORTION_DATE" class="form-group OBSTETRI_ABORTION_DATE">
<span<?= $Grid->ABORTION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ABORTION_DATE->getDisplayValue($Grid->ABORTION_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTION_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ABORTION_DATE" id="x<?= $Grid->RowIndex ?>_ABORTION_DATE" value="<?= HtmlEncode($Grid->ABORTION_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ABORTION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ABORTION_DATE" id="o<?= $Grid->RowIndex ?>_ABORTION_DATE" value="<?= HtmlEncode($Grid->ABORTION_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_CAT->Visible) { // BIRTH_CAT ?>
        <td data-name="BIRTH_CAT">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_CAT" class="form-group OBSTETRI_BIRTH_CAT">
<input type="<?= $Grid->BIRTH_CAT->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CAT" name="x<?= $Grid->RowIndex ?>_BIRTH_CAT" id="x<?= $Grid->RowIndex ?>_BIRTH_CAT" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->BIRTH_CAT->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_CAT->EditValue ?>"<?= $Grid->BIRTH_CAT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_CAT->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_CAT" class="form-group OBSTETRI_BIRTH_CAT">
<span<?= $Grid->BIRTH_CAT->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_CAT->getDisplayValue($Grid->BIRTH_CAT->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CAT" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_CAT" id="x<?= $Grid->RowIndex ?>_BIRTH_CAT" value="<?= HtmlEncode($Grid->BIRTH_CAT->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CAT" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_CAT" id="o<?= $Grid->RowIndex ?>_BIRTH_CAT" value="<?= HtmlEncode($Grid->BIRTH_CAT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_CON->Visible) { // BIRTH_CON ?>
        <td data-name="BIRTH_CON">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_CON" class="form-group OBSTETRI_BIRTH_CON">
<input type="<?= $Grid->BIRTH_CON->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_CON" name="x<?= $Grid->RowIndex ?>_BIRTH_CON" id="x<?= $Grid->RowIndex ?>_BIRTH_CON" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_CON->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_CON->EditValue ?>"<?= $Grid->BIRTH_CON->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_CON->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_CON" class="form-group OBSTETRI_BIRTH_CON">
<span<?= $Grid->BIRTH_CON->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_CON->getDisplayValue($Grid->BIRTH_CON->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CON" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_CON" id="x<?= $Grid->RowIndex ?>_BIRTH_CON" value="<?= HtmlEncode($Grid->BIRTH_CON->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_CON" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_CON" id="o<?= $Grid->RowIndex ?>_BIRTH_CON" value="<?= HtmlEncode($Grid->BIRTH_CON->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_RISK->Visible) { // BIRTH_RISK ?>
        <td data-name="BIRTH_RISK">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_RISK" class="form-group OBSTETRI_BIRTH_RISK">
<input type="<?= $Grid->BIRTH_RISK->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_RISK" name="x<?= $Grid->RowIndex ?>_BIRTH_RISK" id="x<?= $Grid->RowIndex ?>_BIRTH_RISK" size="30" placeholder="<?= HtmlEncode($Grid->BIRTH_RISK->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_RISK->EditValue ?>"<?= $Grid->BIRTH_RISK->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_RISK->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_RISK" class="form-group OBSTETRI_BIRTH_RISK">
<span<?= $Grid->BIRTH_RISK->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_RISK->getDisplayValue($Grid->BIRTH_RISK->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_RISK" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_RISK" id="x<?= $Grid->RowIndex ?>_BIRTH_RISK" value="<?= HtmlEncode($Grid->BIRTH_RISK->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_RISK" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_RISK" id="o<?= $Grid->RowIndex ?>_BIRTH_RISK" value="<?= HtmlEncode($Grid->BIRTH_RISK->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RISK_TYPE->Visible) { // RISK_TYPE ?>
        <td data-name="RISK_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_RISK_TYPE" class="form-group OBSTETRI_RISK_TYPE">
<input type="<?= $Grid->RISK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RISK_TYPE" name="x<?= $Grid->RowIndex ?>_RISK_TYPE" id="x<?= $Grid->RowIndex ?>_RISK_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->RISK_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->RISK_TYPE->EditValue ?>"<?= $Grid->RISK_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RISK_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_RISK_TYPE" class="form-group OBSTETRI_RISK_TYPE">
<span<?= $Grid->RISK_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RISK_TYPE->getDisplayValue($Grid->RISK_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RISK_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RISK_TYPE" id="x<?= $Grid->RowIndex ?>_RISK_TYPE" value="<?= HtmlEncode($Grid->RISK_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RISK_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RISK_TYPE" id="o<?= $Grid->RowIndex ?>_RISK_TYPE" value="<?= HtmlEncode($Grid->RISK_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->FOLLOW_UP->Visible) { // FOLLOW_UP ?>
        <td data-name="FOLLOW_UP">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_FOLLOW_UP" class="form-group OBSTETRI_FOLLOW_UP">
<input type="<?= $Grid->FOLLOW_UP->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FOLLOW_UP" name="x<?= $Grid->RowIndex ?>_FOLLOW_UP" id="x<?= $Grid->RowIndex ?>_FOLLOW_UP" size="30" placeholder="<?= HtmlEncode($Grid->FOLLOW_UP->getPlaceHolder()) ?>" value="<?= $Grid->FOLLOW_UP->EditValue ?>"<?= $Grid->FOLLOW_UP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FOLLOW_UP->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_FOLLOW_UP" class="form-group OBSTETRI_FOLLOW_UP">
<span<?= $Grid->FOLLOW_UP->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FOLLOW_UP->getDisplayValue($Grid->FOLLOW_UP->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_FOLLOW_UP" data-hidden="1" name="x<?= $Grid->RowIndex ?>_FOLLOW_UP" id="x<?= $Grid->RowIndex ?>_FOLLOW_UP" value="<?= HtmlEncode($Grid->FOLLOW_UP->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_FOLLOW_UP" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FOLLOW_UP" id="o<?= $Grid->RowIndex ?>_FOLLOW_UP" value="<?= HtmlEncode($Grid->FOLLOW_UP->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIRUJUK_OLEH->Visible) { // DIRUJUK_OLEH ?>
        <td data-name="DIRUJUK_OLEH">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_DIRUJUK_OLEH" class="form-group OBSTETRI_DIRUJUK_OLEH">
<input type="<?= $Grid->DIRUJUK_OLEH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" name="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DIRUJUK_OLEH->getPlaceHolder()) ?>" value="<?= $Grid->DIRUJUK_OLEH->EditValue ?>"<?= $Grid->DIRUJUK_OLEH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIRUJUK_OLEH->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_DIRUJUK_OLEH" class="form-group OBSTETRI_DIRUJUK_OLEH">
<span<?= $Grid->DIRUJUK_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIRUJUK_OLEH->getDisplayValue($Grid->DIRUJUK_OLEH->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="x<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" value="<?= HtmlEncode($Grid->DIRUJUK_OLEH->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIRUJUK_OLEH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" id="o<?= $Grid->RowIndex ?>_DIRUJUK_OLEH" value="<?= HtmlEncode($Grid->DIRUJUK_OLEH->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->INSPECTION_DATE->Visible) { // INSPECTION_DATE ?>
        <td data-name="INSPECTION_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_INSPECTION_DATE" class="form-group OBSTETRI_INSPECTION_DATE">
<input type="<?= $Grid->INSPECTION_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" name="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" placeholder="<?= HtmlEncode($Grid->INSPECTION_DATE->getPlaceHolder()) ?>" value="<?= $Grid->INSPECTION_DATE->EditValue ?>"<?= $Grid->INSPECTION_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->INSPECTION_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->INSPECTION_DATE->ReadOnly && !$Grid->INSPECTION_DATE->Disabled && !isset($Grid->INSPECTION_DATE->EditAttrs["readonly"]) && !isset($Grid->INSPECTION_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_INSPECTION_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_INSPECTION_DATE" class="form-group OBSTETRI_INSPECTION_DATE">
<span<?= $Grid->INSPECTION_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->INSPECTION_DATE->getDisplayValue($Grid->INSPECTION_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="x<?= $Grid->RowIndex ?>_INSPECTION_DATE" value="<?= HtmlEncode($Grid->INSPECTION_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_INSPECTION_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_INSPECTION_DATE" id="o<?= $Grid->RowIndex ?>_INSPECTION_DATE" value="<?= HtmlEncode($Grid->INSPECTION_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PORSIO->Visible) { // PORSIO ?>
        <td data-name="PORSIO">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PORSIO" class="form-group OBSTETRI_PORSIO">
<input type="<?= $Grid->PORSIO->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PORSIO" name="x<?= $Grid->RowIndex ?>_PORSIO" id="x<?= $Grid->RowIndex ?>_PORSIO" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PORSIO->getPlaceHolder()) ?>" value="<?= $Grid->PORSIO->EditValue ?>"<?= $Grid->PORSIO->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PORSIO->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PORSIO" class="form-group OBSTETRI_PORSIO">
<span<?= $Grid->PORSIO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PORSIO->getDisplayValue($Grid->PORSIO->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PORSIO" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PORSIO" id="x<?= $Grid->RowIndex ?>_PORSIO" value="<?= HtmlEncode($Grid->PORSIO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PORSIO" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PORSIO" id="o<?= $Grid->RowIndex ?>_PORSIO" value="<?= HtmlEncode($Grid->PORSIO->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PEMBUKAAN->Visible) { // PEMBUKAAN ?>
        <td data-name="PEMBUKAAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PEMBUKAAN" class="form-group OBSTETRI_PEMBUKAAN">
<input type="<?= $Grid->PEMBUKAAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PEMBUKAAN" name="x<?= $Grid->RowIndex ?>_PEMBUKAAN" id="x<?= $Grid->RowIndex ?>_PEMBUKAAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PEMBUKAAN->getPlaceHolder()) ?>" value="<?= $Grid->PEMBUKAAN->EditValue ?>"<?= $Grid->PEMBUKAAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PEMBUKAAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PEMBUKAAN" class="form-group OBSTETRI_PEMBUKAAN">
<span<?= $Grid->PEMBUKAAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PEMBUKAAN->getDisplayValue($Grid->PEMBUKAAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PEMBUKAAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PEMBUKAAN" id="x<?= $Grid->RowIndex ?>_PEMBUKAAN" value="<?= HtmlEncode($Grid->PEMBUKAAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PEMBUKAAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PEMBUKAAN" id="o<?= $Grid->RowIndex ?>_PEMBUKAAN" value="<?= HtmlEncode($Grid->PEMBUKAAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KETUBAN->Visible) { // KETUBAN ?>
        <td data-name="KETUBAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_KETUBAN" class="form-group OBSTETRI_KETUBAN">
<input type="<?= $Grid->KETUBAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KETUBAN" name="x<?= $Grid->RowIndex ?>_KETUBAN" id="x<?= $Grid->RowIndex ?>_KETUBAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->KETUBAN->getPlaceHolder()) ?>" value="<?= $Grid->KETUBAN->EditValue ?>"<?= $Grid->KETUBAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KETUBAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_KETUBAN" class="form-group OBSTETRI_KETUBAN">
<span<?= $Grid->KETUBAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KETUBAN->getDisplayValue($Grid->KETUBAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KETUBAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KETUBAN" id="x<?= $Grid->RowIndex ?>_KETUBAN" value="<?= HtmlEncode($Grid->KETUBAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KETUBAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KETUBAN" id="o<?= $Grid->RowIndex ?>_KETUBAN" value="<?= HtmlEncode($Grid->KETUBAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PRESENTASI->Visible) { // PRESENTASI ?>
        <td data-name="PRESENTASI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PRESENTASI" class="form-group OBSTETRI_PRESENTASI">
<input type="<?= $Grid->PRESENTASI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PRESENTASI" name="x<?= $Grid->RowIndex ?>_PRESENTASI" id="x<?= $Grid->RowIndex ?>_PRESENTASI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PRESENTASI->getPlaceHolder()) ?>" value="<?= $Grid->PRESENTASI->EditValue ?>"<?= $Grid->PRESENTASI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PRESENTASI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PRESENTASI" class="form-group OBSTETRI_PRESENTASI">
<span<?= $Grid->PRESENTASI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PRESENTASI->getDisplayValue($Grid->PRESENTASI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PRESENTASI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PRESENTASI" id="x<?= $Grid->RowIndex ?>_PRESENTASI" value="<?= HtmlEncode($Grid->PRESENTASI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PRESENTASI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PRESENTASI" id="o<?= $Grid->RowIndex ?>_PRESENTASI" value="<?= HtmlEncode($Grid->PRESENTASI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->POSISI->Visible) { // POSISI ?>
        <td data-name="POSISI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_POSISI" class="form-group OBSTETRI_POSISI">
<input type="<?= $Grid->POSISI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_POSISI" name="x<?= $Grid->RowIndex ?>_POSISI" id="x<?= $Grid->RowIndex ?>_POSISI" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->POSISI->getPlaceHolder()) ?>" value="<?= $Grid->POSISI->EditValue ?>"<?= $Grid->POSISI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->POSISI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_POSISI" class="form-group OBSTETRI_POSISI">
<span<?= $Grid->POSISI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->POSISI->getDisplayValue($Grid->POSISI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_POSISI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_POSISI" id="x<?= $Grid->RowIndex ?>_POSISI" value="<?= HtmlEncode($Grid->POSISI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_POSISI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_POSISI" id="o<?= $Grid->RowIndex ?>_POSISI" value="<?= HtmlEncode($Grid->POSISI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PENURUNAN->Visible) { // PENURUNAN ?>
        <td data-name="PENURUNAN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PENURUNAN" class="form-group OBSTETRI_PENURUNAN">
<input type="<?= $Grid->PENURUNAN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PENURUNAN" name="x<?= $Grid->RowIndex ?>_PENURUNAN" id="x<?= $Grid->RowIndex ?>_PENURUNAN" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->PENURUNAN->getPlaceHolder()) ?>" value="<?= $Grid->PENURUNAN->EditValue ?>"<?= $Grid->PENURUNAN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PENURUNAN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PENURUNAN" class="form-group OBSTETRI_PENURUNAN">
<span<?= $Grid->PENURUNAN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PENURUNAN->getDisplayValue($Grid->PENURUNAN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PENURUNAN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PENURUNAN" id="x<?= $Grid->RowIndex ?>_PENURUNAN" value="<?= HtmlEncode($Grid->PENURUNAN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PENURUNAN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PENURUNAN" id="o<?= $Grid->RowIndex ?>_PENURUNAN" value="<?= HtmlEncode($Grid->PENURUNAN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->HEART_ID->Visible) { // HEART_ID ?>
        <td data-name="HEART_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_HEART_ID" class="form-group OBSTETRI_HEART_ID">
<input type="<?= $Grid->HEART_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_HEART_ID" name="x<?= $Grid->RowIndex ?>_HEART_ID" id="x<?= $Grid->RowIndex ?>_HEART_ID" size="30" placeholder="<?= HtmlEncode($Grid->HEART_ID->getPlaceHolder()) ?>" value="<?= $Grid->HEART_ID->EditValue ?>"<?= $Grid->HEART_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->HEART_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_HEART_ID" class="form-group OBSTETRI_HEART_ID">
<span<?= $Grid->HEART_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->HEART_ID->getDisplayValue($Grid->HEART_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_HEART_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_HEART_ID" id="x<?= $Grid->RowIndex ?>_HEART_ID" value="<?= HtmlEncode($Grid->HEART_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_HEART_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_HEART_ID" id="o<?= $Grid->RowIndex ?>_HEART_ID" value="<?= HtmlEncode($Grid->HEART_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->JANIN_ID->Visible) { // JANIN_ID ?>
        <td data-name="JANIN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_JANIN_ID" class="form-group OBSTETRI_JANIN_ID">
<input type="<?= $Grid->JANIN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_JANIN_ID" name="x<?= $Grid->RowIndex ?>_JANIN_ID" id="x<?= $Grid->RowIndex ?>_JANIN_ID" size="30" placeholder="<?= HtmlEncode($Grid->JANIN_ID->getPlaceHolder()) ?>" value="<?= $Grid->JANIN_ID->EditValue ?>"<?= $Grid->JANIN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->JANIN_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_JANIN_ID" class="form-group OBSTETRI_JANIN_ID">
<span<?= $Grid->JANIN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->JANIN_ID->getDisplayValue($Grid->JANIN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_JANIN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_JANIN_ID" id="x<?= $Grid->RowIndex ?>_JANIN_ID" value="<?= HtmlEncode($Grid->JANIN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_JANIN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_JANIN_ID" id="o<?= $Grid->RowIndex ?>_JANIN_ID" value="<?= HtmlEncode($Grid->JANIN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->FREK_DJJ->Visible) { // FREK_DJJ ?>
        <td data-name="FREK_DJJ">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_FREK_DJJ" class="form-group OBSTETRI_FREK_DJJ">
<input type="<?= $Grid->FREK_DJJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_FREK_DJJ" name="x<?= $Grid->RowIndex ?>_FREK_DJJ" id="x<?= $Grid->RowIndex ?>_FREK_DJJ" size="30" placeholder="<?= HtmlEncode($Grid->FREK_DJJ->getPlaceHolder()) ?>" value="<?= $Grid->FREK_DJJ->EditValue ?>"<?= $Grid->FREK_DJJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->FREK_DJJ->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_FREK_DJJ" class="form-group OBSTETRI_FREK_DJJ">
<span<?= $Grid->FREK_DJJ->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->FREK_DJJ->getDisplayValue($Grid->FREK_DJJ->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_FREK_DJJ" data-hidden="1" name="x<?= $Grid->RowIndex ?>_FREK_DJJ" id="x<?= $Grid->RowIndex ?>_FREK_DJJ" value="<?= HtmlEncode($Grid->FREK_DJJ->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_FREK_DJJ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_FREK_DJJ" id="o<?= $Grid->RowIndex ?>_FREK_DJJ" value="<?= HtmlEncode($Grid->FREK_DJJ->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->PLACENTA->Visible) { // PLACENTA ?>
        <td data-name="PLACENTA">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_PLACENTA" class="form-group OBSTETRI_PLACENTA">
<input type="<?= $Grid->PLACENTA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_PLACENTA" name="x<?= $Grid->RowIndex ?>_PLACENTA" id="x<?= $Grid->RowIndex ?>_PLACENTA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->PLACENTA->getPlaceHolder()) ?>" value="<?= $Grid->PLACENTA->EditValue ?>"<?= $Grid->PLACENTA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->PLACENTA->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_PLACENTA" class="form-group OBSTETRI_PLACENTA">
<span<?= $Grid->PLACENTA->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->PLACENTA->getDisplayValue($Grid->PLACENTA->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_PLACENTA" data-hidden="1" name="x<?= $Grid->RowIndex ?>_PLACENTA" id="x<?= $Grid->RowIndex ?>_PLACENTA" value="<?= HtmlEncode($Grid->PLACENTA->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_PLACENTA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_PLACENTA" id="o<?= $Grid->RowIndex ?>_PLACENTA" value="<?= HtmlEncode($Grid->PLACENTA->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->LOCHIA->Visible) { // LOCHIA ?>
        <td data-name="LOCHIA">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_LOCHIA" class="form-group OBSTETRI_LOCHIA">
<input type="<?= $Grid->LOCHIA->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_LOCHIA" name="x<?= $Grid->RowIndex ?>_LOCHIA" id="x<?= $Grid->RowIndex ?>_LOCHIA" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->LOCHIA->getPlaceHolder()) ?>" value="<?= $Grid->LOCHIA->EditValue ?>"<?= $Grid->LOCHIA->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->LOCHIA->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_LOCHIA" class="form-group OBSTETRI_LOCHIA">
<span<?= $Grid->LOCHIA->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->LOCHIA->getDisplayValue($Grid->LOCHIA->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_LOCHIA" data-hidden="1" name="x<?= $Grid->RowIndex ?>_LOCHIA" id="x<?= $Grid->RowIndex ?>_LOCHIA" value="<?= HtmlEncode($Grid->LOCHIA->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_LOCHIA" data-hidden="1" name="o<?= $Grid->RowIndex ?>_LOCHIA" id="o<?= $Grid->RowIndex ?>_LOCHIA" value="<?= HtmlEncode($Grid->LOCHIA->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BAB_TYPE->Visible) { // BAB_TYPE ?>
        <td data-name="BAB_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BAB_TYPE" class="form-group OBSTETRI_BAB_TYPE">
<input type="<?= $Grid->BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_TYPE" name="x<?= $Grid->RowIndex ?>_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAB_TYPE->EditValue ?>"<?= $Grid->BAB_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAB_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BAB_TYPE" class="form-group OBSTETRI_BAB_TYPE">
<span<?= $Grid->BAB_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BAB_TYPE->getDisplayValue($Grid->BAB_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAB_TYPE" id="o<?= $Grid->RowIndex ?>_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BAB_BAB_TYPE->Visible) { // BAB_BAB_TYPE ?>
        <td data-name="BAB_BAB_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BAB_BAB_TYPE" class="form-group OBSTETRI_BAB_BAB_TYPE">
<input type="<?= $Grid->BAB_BAB_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" name="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAB_BAB_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAB_BAB_TYPE->EditValue ?>"<?= $Grid->BAB_BAB_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAB_BAB_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BAB_BAB_TYPE" class="form-group OBSTETRI_BAB_BAB_TYPE">
<span<?= $Grid->BAB_BAB_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BAB_BAB_TYPE->getDisplayValue($Grid->BAB_BAB_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="x<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_BAB_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAB_BAB_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" id="o<?= $Grid->RowIndex ?>_BAB_BAB_TYPE" value="<?= HtmlEncode($Grid->BAB_BAB_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RAHIM_ID->Visible) { // RAHIM_ID ?>
        <td data-name="RAHIM_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_RAHIM_ID" class="form-group OBSTETRI_RAHIM_ID">
<input type="<?= $Grid->RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_ID" name="x<?= $Grid->RowIndex ?>_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_ID->EditValue ?>"<?= $Grid->RAHIM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_RAHIM_ID" class="form-group OBSTETRI_RAHIM_ID">
<span<?= $Grid->RAHIM_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RAHIM_ID->getDisplayValue($Grid->RAHIM_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_RAHIM_ID" value="<?= HtmlEncode($Grid->RAHIM_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RAHIM_ID" id="o<?= $Grid->RowIndex ?>_RAHIM_ID" value="<?= HtmlEncode($Grid->RAHIM_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIR_RAHIM_ID->Visible) { // BIR_RAHIM_ID ?>
        <td data-name="BIR_RAHIM_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIR_RAHIM_ID" class="form-group OBSTETRI_BIR_RAHIM_ID">
<input type="<?= $Grid->BIR_RAHIM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" name="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->BIR_RAHIM_ID->getPlaceHolder()) ?>" value="<?= $Grid->BIR_RAHIM_ID->EditValue ?>"<?= $Grid->BIR_RAHIM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIR_RAHIM_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIR_RAHIM_ID" class="form-group OBSTETRI_BIR_RAHIM_ID">
<span<?= $Grid->BIR_RAHIM_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIR_RAHIM_ID->getDisplayValue($Grid->BIR_RAHIM_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="x<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" value="<?= HtmlEncode($Grid->BIR_RAHIM_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIR_RAHIM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" id="o<?= $Grid->RowIndex ?>_BIR_RAHIM_ID" value="<?= HtmlEncode($Grid->BIR_RAHIM_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->VISIT_ID->Visible) { // VISIT_ID ?>
        <td data-name="VISIT_ID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->VISIT_ID->getSessionValue() != "") { ?>
<span id="el$rowindex$_OBSTETRI_VISIT_ID" class="form-group OBSTETRI_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_VISIT_ID" class="form-group OBSTETRI_VISIT_ID">
<input type="<?= $Grid->VISIT_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_VISIT_ID" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->VISIT_ID->getPlaceHolder()) ?>" value="<?= $Grid->VISIT_ID->EditValue ?>"<?= $Grid->VISIT_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->VISIT_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_VISIT_ID" class="form-group OBSTETRI_VISIT_ID">
<span<?= $Grid->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->VISIT_ID->getDisplayValue($Grid->VISIT_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_VISIT_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_VISIT_ID" id="x<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_VISIT_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_VISIT_ID" id="o<?= $Grid->RowIndex ?>_VISIT_ID" value="<?= HtmlEncode($Grid->VISIT_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BLOODING->Visible) { // BLOODING ?>
        <td data-name="BLOODING">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BLOODING" class="form-group OBSTETRI_BLOODING">
<input type="<?= $Grid->BLOODING->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BLOODING" name="x<?= $Grid->RowIndex ?>_BLOODING" id="x<?= $Grid->RowIndex ?>_BLOODING" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->BLOODING->getPlaceHolder()) ?>" value="<?= $Grid->BLOODING->EditValue ?>"<?= $Grid->BLOODING->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BLOODING->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BLOODING" class="form-group OBSTETRI_BLOODING">
<span<?= $Grid->BLOODING->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BLOODING->getDisplayValue($Grid->BLOODING->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BLOODING" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BLOODING" id="x<?= $Grid->RowIndex ?>_BLOODING" value="<?= HtmlEncode($Grid->BLOODING->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BLOODING" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BLOODING" id="o<?= $Grid->RowIndex ?>_BLOODING" value="<?= HtmlEncode($Grid->BLOODING->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td data-name="DESCRIPTION">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_DESCRIPTION" class="form-group OBSTETRI_DESCRIPTION">
<input type="<?= $Grid->DESCRIPTION->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DESCRIPTION" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Grid->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Grid->DESCRIPTION->EditValue ?>"<?= $Grid->DESCRIPTION->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DESCRIPTION->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_DESCRIPTION" class="form-group OBSTETRI_DESCRIPTION">
<span<?= $Grid->DESCRIPTION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DESCRIPTION->getDisplayValue($Grid->DESCRIPTION->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DESCRIPTION" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DESCRIPTION" id="x<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DESCRIPTION" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DESCRIPTION" id="o<?= $Grid->RowIndex ?>_DESCRIPTION" value="<?= HtmlEncode($Grid->DESCRIPTION->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td data-name="MODIFIED_DATE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_MODIFIED_DATE" class="form-group OBSTETRI_MODIFIED_DATE">
<input type="<?= $Grid->MODIFIED_DATE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" placeholder="<?= HtmlEncode($Grid->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_DATE->EditValue ?>"<?= $Grid->MODIFIED_DATE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Grid->MODIFIED_DATE->ReadOnly && !$Grid->MODIFIED_DATE->Disabled && !isset($Grid->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Grid->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fOBSTETRIgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fOBSTETRIgrid", "x<?= $Grid->RowIndex ?>_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_MODIFIED_DATE" class="form-group OBSTETRI_MODIFIED_DATE">
<span<?= $Grid->MODIFIED_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_DATE->getDisplayValue($Grid->MODIFIED_DATE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="x<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_DATE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" id="o<?= $Grid->RowIndex ?>_MODIFIED_DATE" value="<?= HtmlEncode($Grid->MODIFIED_DATE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td data-name="MODIFIED_BY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_MODIFIED_BY" class="form-group OBSTETRI_MODIFIED_BY">
<input type="<?= $Grid->MODIFIED_BY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_BY" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_BY->EditValue ?>"<?= $Grid->MODIFIED_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_BY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_MODIFIED_BY" class="form-group OBSTETRI_MODIFIED_BY">
<span<?= $Grid->MODIFIED_BY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_BY->getDisplayValue($Grid->MODIFIED_BY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_BY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_BY" id="x<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_BY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_BY" id="o<?= $Grid->RowIndex ?>_MODIFIED_BY" value="<?= HtmlEncode($Grid->MODIFIED_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->MODIFIED_FROM->Visible) { // MODIFIED_FROM ?>
        <td data-name="MODIFIED_FROM">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_MODIFIED_FROM" class="form-group OBSTETRI_MODIFIED_FROM">
<input type="<?= $Grid->MODIFIED_FROM->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->MODIFIED_FROM->getPlaceHolder()) ?>" value="<?= $Grid->MODIFIED_FROM->EditValue ?>"<?= $Grid->MODIFIED_FROM->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->MODIFIED_FROM->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_MODIFIED_FROM" class="form-group OBSTETRI_MODIFIED_FROM">
<span<?= $Grid->MODIFIED_FROM->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->MODIFIED_FROM->getDisplayValue($Grid->MODIFIED_FROM->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" data-hidden="1" name="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="x<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_MODIFIED_FROM" data-hidden="1" name="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" id="o<?= $Grid->RowIndex ?>_MODIFIED_FROM" value="<?= HtmlEncode($Grid->MODIFIED_FROM->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RAHIM_SALIN->Visible) { // RAHIM_SALIN ?>
        <td data-name="RAHIM_SALIN">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_RAHIM_SALIN" class="form-group OBSTETRI_RAHIM_SALIN">
<input type="<?= $Grid->RAHIM_SALIN->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" name="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_SALIN->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_SALIN->EditValue ?>"<?= $Grid->RAHIM_SALIN->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_SALIN->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_RAHIM_SALIN" class="form-group OBSTETRI_RAHIM_SALIN">
<span<?= $Grid->RAHIM_SALIN->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RAHIM_SALIN->getDisplayValue($Grid->RAHIM_SALIN->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="x<?= $Grid->RowIndex ?>_RAHIM_SALIN" value="<?= HtmlEncode($Grid->RAHIM_SALIN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_SALIN" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RAHIM_SALIN" id="o<?= $Grid->RowIndex ?>_RAHIM_SALIN" value="<?= HtmlEncode($Grid->RAHIM_SALIN->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->RAHIM_NIFAS->Visible) { // RAHIM_NIFAS ?>
        <td data-name="RAHIM_NIFAS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_RAHIM_NIFAS" class="form-group OBSTETRI_RAHIM_NIFAS">
<input type="<?= $Grid->RAHIM_NIFAS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" name="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->RAHIM_NIFAS->getPlaceHolder()) ?>" value="<?= $Grid->RAHIM_NIFAS->EditValue ?>"<?= $Grid->RAHIM_NIFAS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->RAHIM_NIFAS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_RAHIM_NIFAS" class="form-group OBSTETRI_RAHIM_NIFAS">
<span<?= $Grid->RAHIM_NIFAS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->RAHIM_NIFAS->getDisplayValue($Grid->RAHIM_NIFAS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="x<?= $Grid->RowIndex ?>_RAHIM_NIFAS" value="<?= HtmlEncode($Grid->RAHIM_NIFAS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_RAHIM_NIFAS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_RAHIM_NIFAS" id="o<?= $Grid->RowIndex ?>_RAHIM_NIFAS" value="<?= HtmlEncode($Grid->RAHIM_NIFAS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BAK_TYPE->Visible) { // BAK_TYPE ?>
        <td data-name="BAK_TYPE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BAK_TYPE" class="form-group OBSTETRI_BAK_TYPE">
<input type="<?= $Grid->BAK_TYPE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BAK_TYPE" name="x<?= $Grid->RowIndex ?>_BAK_TYPE" id="x<?= $Grid->RowIndex ?>_BAK_TYPE" size="30" placeholder="<?= HtmlEncode($Grid->BAK_TYPE->getPlaceHolder()) ?>" value="<?= $Grid->BAK_TYPE->EditValue ?>"<?= $Grid->BAK_TYPE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BAK_TYPE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BAK_TYPE" class="form-group OBSTETRI_BAK_TYPE">
<span<?= $Grid->BAK_TYPE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BAK_TYPE->getDisplayValue($Grid->BAK_TYPE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAK_TYPE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BAK_TYPE" id="x<?= $Grid->RowIndex ?>_BAK_TYPE" value="<?= HtmlEncode($Grid->BAK_TYPE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BAK_TYPE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BAK_TYPE" id="o<?= $Grid->RowIndex ?>_BAK_TYPE" value="<?= HtmlEncode($Grid->BAK_TYPE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THENAME->Visible) { // THENAME ?>
        <td data-name="THENAME">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->THENAME->getSessionValue() != "") { ?>
<span id="el$rowindex$_OBSTETRI_THENAME" class="form-group OBSTETRI_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_THENAME" class="form-group OBSTETRI_THENAME">
<input type="<?= $Grid->THENAME->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THENAME" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->THENAME->getPlaceHolder()) ?>" value="<?= $Grid->THENAME->EditValue ?>"<?= $Grid->THENAME->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THENAME->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_THENAME" class="form-group OBSTETRI_THENAME">
<span<?= $Grid->THENAME->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THENAME->getDisplayValue($Grid->THENAME->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_THENAME" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THENAME" id="x<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THENAME" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THENAME" id="o<?= $Grid->RowIndex ?>_THENAME" value="<?= HtmlEncode($Grid->THENAME->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEADDRESS->Visible) { // THEADDRESS ?>
        <td data-name="THEADDRESS">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->THEADDRESS->getSessionValue() != "") { ?>
<span id="el$rowindex$_OBSTETRI_THEADDRESS" class="form-group OBSTETRI_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_THEADDRESS" class="form-group OBSTETRI_THEADDRESS">
<input type="<?= $Grid->THEADDRESS->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEADDRESS" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->THEADDRESS->getPlaceHolder()) ?>" value="<?= $Grid->THEADDRESS->EditValue ?>"<?= $Grid->THEADDRESS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEADDRESS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_THEADDRESS" class="form-group OBSTETRI_THEADDRESS">
<span<?= $Grid->THEADDRESS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEADDRESS->getDisplayValue($Grid->THEADDRESS->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEADDRESS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEADDRESS" id="x<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEADDRESS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEADDRESS" id="o<?= $Grid->RowIndex ?>_THEADDRESS" value="<?= HtmlEncode($Grid->THEADDRESS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->THEID->Visible) { // THEID ?>
        <td data-name="THEID">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->THEID->getSessionValue() != "") { ?>
<span id="el$rowindex$_OBSTETRI_THEID" class="form-group OBSTETRI_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_THEID" name="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_THEID" class="form-group OBSTETRI_THEID">
<input type="<?= $Grid->THEID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_THEID" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->THEID->getPlaceHolder()) ?>" value="<?= $Grid->THEID->EditValue ?>"<?= $Grid->THEID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->THEID->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_THEID" class="form-group OBSTETRI_THEID">
<span<?= $Grid->THEID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->THEID->getDisplayValue($Grid->THEID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_THEID" id="x<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_THEID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_THEID" id="o<?= $Grid->RowIndex ?>_THEID" value="<?= HtmlEncode($Grid->THEID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td data-name="STATUS_PASIEN_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_STATUS_PASIEN_ID" class="form-group OBSTETRI_STATUS_PASIEN_ID">
<input type="<?= $Grid->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Grid->STATUS_PASIEN_ID->EditValue ?>"<?= $Grid->STATUS_PASIEN_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_STATUS_PASIEN_ID" class="form-group OBSTETRI_STATUS_PASIEN_ID">
<span<?= $Grid->STATUS_PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->STATUS_PASIEN_ID->getDisplayValue($Grid->STATUS_PASIEN_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="x<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" id="o<?= $Grid->RowIndex ?>_STATUS_PASIEN_ID" value="<?= HtmlEncode($Grid->STATUS_PASIEN_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ISRJ->Visible) { // ISRJ ?>
        <td data-name="ISRJ">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_ISRJ" class="form-group OBSTETRI_ISRJ">
<input type="<?= $Grid->ISRJ->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_ISRJ" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->ISRJ->getPlaceHolder()) ?>" value="<?= $Grid->ISRJ->EditValue ?>"<?= $Grid->ISRJ->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ISRJ->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_ISRJ" class="form-group OBSTETRI_ISRJ">
<span<?= $Grid->ISRJ->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ISRJ->getDisplayValue($Grid->ISRJ->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_ISRJ" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ISRJ" id="x<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_ISRJ" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ISRJ" id="o<?= $Grid->RowIndex ?>_ISRJ" value="<?= HtmlEncode($Grid->ISRJ->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AGEYEAR->Visible) { // AGEYEAR ?>
        <td data-name="AGEYEAR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_AGEYEAR" class="form-group OBSTETRI_AGEYEAR">
<input type="<?= $Grid->AGEYEAR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEYEAR" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" size="30" placeholder="<?= HtmlEncode($Grid->AGEYEAR->getPlaceHolder()) ?>" value="<?= $Grid->AGEYEAR->EditValue ?>"<?= $Grid->AGEYEAR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEYEAR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_AGEYEAR" class="form-group OBSTETRI_AGEYEAR">
<span<?= $Grid->AGEYEAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AGEYEAR->getDisplayValue($Grid->AGEYEAR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEYEAR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AGEYEAR" id="x<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEYEAR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEYEAR" id="o<?= $Grid->RowIndex ?>_AGEYEAR" value="<?= HtmlEncode($Grid->AGEYEAR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AGEMONTH->Visible) { // AGEMONTH ?>
        <td data-name="AGEMONTH">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_AGEMONTH" class="form-group OBSTETRI_AGEMONTH">
<input type="<?= $Grid->AGEMONTH->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEMONTH" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" size="30" placeholder="<?= HtmlEncode($Grid->AGEMONTH->getPlaceHolder()) ?>" value="<?= $Grid->AGEMONTH->EditValue ?>"<?= $Grid->AGEMONTH->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEMONTH->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_AGEMONTH" class="form-group OBSTETRI_AGEMONTH">
<span<?= $Grid->AGEMONTH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AGEMONTH->getDisplayValue($Grid->AGEMONTH->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEMONTH" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AGEMONTH" id="x<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEMONTH" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEMONTH" id="o<?= $Grid->RowIndex ?>_AGEMONTH" value="<?= HtmlEncode($Grid->AGEMONTH->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->AGEDAY->Visible) { // AGEDAY ?>
        <td data-name="AGEDAY">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_AGEDAY" class="form-group OBSTETRI_AGEDAY">
<input type="<?= $Grid->AGEDAY->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_AGEDAY" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" size="30" placeholder="<?= HtmlEncode($Grid->AGEDAY->getPlaceHolder()) ?>" value="<?= $Grid->AGEDAY->EditValue ?>"<?= $Grid->AGEDAY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->AGEDAY->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_AGEDAY" class="form-group OBSTETRI_AGEDAY">
<span<?= $Grid->AGEDAY->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->AGEDAY->getDisplayValue($Grid->AGEDAY->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEDAY" data-hidden="1" name="x<?= $Grid->RowIndex ?>_AGEDAY" id="x<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_AGEDAY" data-hidden="1" name="o<?= $Grid->RowIndex ?>_AGEDAY" id="o<?= $Grid->RowIndex ?>_AGEDAY" value="<?= HtmlEncode($Grid->AGEDAY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->GENDER->Visible) { // GENDER ?>
        <td data-name="GENDER">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_GENDER" class="form-group OBSTETRI_GENDER">
<input type="<?= $Grid->GENDER->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_GENDER" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->GENDER->getPlaceHolder()) ?>" value="<?= $Grid->GENDER->EditValue ?>"<?= $Grid->GENDER->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->GENDER->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_GENDER" class="form-group OBSTETRI_GENDER">
<span<?= $Grid->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->GENDER->getDisplayValue($Grid->GENDER->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_GENDER" data-hidden="1" name="x<?= $Grid->RowIndex ?>_GENDER" id="x<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_GENDER" data-hidden="1" name="o<?= $Grid->RowIndex ?>_GENDER" id="o<?= $Grid->RowIndex ?>_GENDER" value="<?= HtmlEncode($Grid->GENDER->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <td data-name="CLASS_ROOM_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_CLASS_ROOM_ID" class="form-group OBSTETRI_CLASS_ROOM_ID">
<input type="<?= $Grid->CLASS_ROOM_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->CLASS_ROOM_ID->getPlaceHolder()) ?>" value="<?= $Grid->CLASS_ROOM_ID->EditValue ?>"<?= $Grid->CLASS_ROOM_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->CLASS_ROOM_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_CLASS_ROOM_ID" class="form-group OBSTETRI_CLASS_ROOM_ID">
<span<?= $Grid->CLASS_ROOM_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->CLASS_ROOM_ID->getDisplayValue($Grid->CLASS_ROOM_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="x<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_CLASS_ROOM_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" id="o<?= $Grid->RowIndex ?>_CLASS_ROOM_ID" value="<?= HtmlEncode($Grid->CLASS_ROOM_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BED_ID->Visible) { // BED_ID ?>
        <td data-name="BED_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BED_ID" class="form-group OBSTETRI_BED_ID">
<input type="<?= $Grid->BED_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BED_ID" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" size="30" placeholder="<?= HtmlEncode($Grid->BED_ID->getPlaceHolder()) ?>" value="<?= $Grid->BED_ID->EditValue ?>"<?= $Grid->BED_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BED_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BED_ID" class="form-group OBSTETRI_BED_ID">
<span<?= $Grid->BED_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BED_ID->getDisplayValue($Grid->BED_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BED_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BED_ID" id="x<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BED_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BED_ID" id="o<?= $Grid->RowIndex ?>_BED_ID" value="<?= HtmlEncode($Grid->BED_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <td data-name="KELUAR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_KELUAR_ID" class="form-group OBSTETRI_KELUAR_ID">
<input type="<?= $Grid->KELUAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KELUAR_ID" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" size="30" placeholder="<?= HtmlEncode($Grid->KELUAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->KELUAR_ID->EditValue ?>"<?= $Grid->KELUAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KELUAR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_KELUAR_ID" class="form-group OBSTETRI_KELUAR_ID">
<span<?= $Grid->KELUAR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KELUAR_ID->getDisplayValue($Grid->KELUAR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KELUAR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KELUAR_ID" id="x<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KELUAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KELUAR_ID" id="o<?= $Grid->RowIndex ?>_KELUAR_ID" value="<?= HtmlEncode($Grid->KELUAR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DOCTOR->Visible) { // DOCTOR ?>
        <td data-name="DOCTOR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_DOCTOR" class="form-group OBSTETRI_DOCTOR">
<input type="<?= $Grid->DOCTOR->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DOCTOR" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->DOCTOR->getPlaceHolder()) ?>" value="<?= $Grid->DOCTOR->EditValue ?>"<?= $Grid->DOCTOR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DOCTOR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_DOCTOR" class="form-group OBSTETRI_DOCTOR">
<span<?= $Grid->DOCTOR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DOCTOR->getDisplayValue($Grid->DOCTOR->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DOCTOR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DOCTOR" id="x<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DOCTOR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DOCTOR" id="o<?= $Grid->RowIndex ?>_DOCTOR" value="<?= HtmlEncode($Grid->DOCTOR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->NB_OBSTETRI->Visible) { // NB_OBSTETRI ?>
        <td data-name="NB_OBSTETRI">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_NB_OBSTETRI" class="form-group OBSTETRI_NB_OBSTETRI">
<input type="<?= $Grid->NB_OBSTETRI->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" name="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" size="30" placeholder="<?= HtmlEncode($Grid->NB_OBSTETRI->getPlaceHolder()) ?>" value="<?= $Grid->NB_OBSTETRI->EditValue ?>"<?= $Grid->NB_OBSTETRI->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->NB_OBSTETRI->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_NB_OBSTETRI" class="form-group OBSTETRI_NB_OBSTETRI">
<span<?= $Grid->NB_OBSTETRI->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->NB_OBSTETRI->getDisplayValue($Grid->NB_OBSTETRI->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" data-hidden="1" name="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="x<?= $Grid->RowIndex ?>_NB_OBSTETRI" value="<?= HtmlEncode($Grid->NB_OBSTETRI->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_NB_OBSTETRI" data-hidden="1" name="o<?= $Grid->RowIndex ?>_NB_OBSTETRI" id="o<?= $Grid->RowIndex ?>_NB_OBSTETRI" value="<?= HtmlEncode($Grid->NB_OBSTETRI->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->OBSTETRI_DIE->Visible) { // OBSTETRI_DIE ?>
        <td data-name="OBSTETRI_DIE">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_OBSTETRI_DIE" class="form-group OBSTETRI_OBSTETRI_DIE">
<input type="<?= $Grid->OBSTETRI_DIE->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" name="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" size="30" placeholder="<?= HtmlEncode($Grid->OBSTETRI_DIE->getPlaceHolder()) ?>" value="<?= $Grid->OBSTETRI_DIE->EditValue ?>"<?= $Grid->OBSTETRI_DIE->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->OBSTETRI_DIE->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_OBSTETRI_DIE" class="form-group OBSTETRI_OBSTETRI_DIE">
<span<?= $Grid->OBSTETRI_DIE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->OBSTETRI_DIE->getDisplayValue($Grid->OBSTETRI_DIE->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" data-hidden="1" name="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="x<?= $Grid->RowIndex ?>_OBSTETRI_DIE" value="<?= HtmlEncode($Grid->OBSTETRI_DIE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_OBSTETRI_DIE" data-hidden="1" name="o<?= $Grid->RowIndex ?>_OBSTETRI_DIE" id="o<?= $Grid->RowIndex ?>_OBSTETRI_DIE" value="<?= HtmlEncode($Grid->OBSTETRI_DIE->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->KAL_ID->Visible) { // KAL_ID ?>
        <td data-name="KAL_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_KAL_ID" class="form-group OBSTETRI_KAL_ID">
<input type="<?= $Grid->KAL_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_KAL_ID" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->KAL_ID->getPlaceHolder()) ?>" value="<?= $Grid->KAL_ID->EditValue ?>"<?= $Grid->KAL_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->KAL_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_KAL_ID" class="form-group OBSTETRI_KAL_ID">
<span<?= $Grid->KAL_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->KAL_ID->getDisplayValue($Grid->KAL_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_KAL_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_KAL_ID" id="x<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_KAL_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_KAL_ID" id="o<?= $Grid->RowIndex ?>_KAL_ID" value="<?= HtmlEncode($Grid->KAL_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->DIAGNOSA_ID2->Visible) { // DIAGNOSA_ID2 ?>
        <td data-name="DIAGNOSA_ID2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_DIAGNOSA_ID2" class="form-group OBSTETRI_DIAGNOSA_ID2">
<input type="<?= $Grid->DIAGNOSA_ID2->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->DIAGNOSA_ID2->getPlaceHolder()) ?>" value="<?= $Grid->DIAGNOSA_ID2->EditValue ?>"<?= $Grid->DIAGNOSA_ID2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->DIAGNOSA_ID2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_DIAGNOSA_ID2" class="form-group OBSTETRI_DIAGNOSA_ID2">
<span<?= $Grid->DIAGNOSA_ID2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->DIAGNOSA_ID2->getDisplayValue($Grid->DIAGNOSA_ID2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="x<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" value="<?= HtmlEncode($Grid->DIAGNOSA_ID2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_DIAGNOSA_ID2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" id="o<?= $Grid->RowIndex ?>_DIAGNOSA_ID2" value="<?= HtmlEncode($Grid->DIAGNOSA_ID2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->APGAR_ID->Visible) { // APGAR_ID ?>
        <td data-name="APGAR_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_APGAR_ID" class="form-group OBSTETRI_APGAR_ID">
<input type="<?= $Grid->APGAR_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_APGAR_ID" name="x<?= $Grid->RowIndex ?>_APGAR_ID" id="x<?= $Grid->RowIndex ?>_APGAR_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->APGAR_ID->getPlaceHolder()) ?>" value="<?= $Grid->APGAR_ID->EditValue ?>"<?= $Grid->APGAR_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->APGAR_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_APGAR_ID" class="form-group OBSTETRI_APGAR_ID">
<span<?= $Grid->APGAR_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->APGAR_ID->getDisplayValue($Grid->APGAR_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_APGAR_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_APGAR_ID" id="x<?= $Grid->RowIndex ?>_APGAR_ID" value="<?= HtmlEncode($Grid->APGAR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_APGAR_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_APGAR_ID" id="o<?= $Grid->RowIndex ?>_APGAR_ID" value="<?= HtmlEncode($Grid->APGAR_ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->BIRTH_LAST_ID->Visible) { // BIRTH_LAST_ID ?>
        <td data-name="BIRTH_LAST_ID">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_LAST_ID" class="form-group OBSTETRI_BIRTH_LAST_ID">
<input type="<?= $Grid->BIRTH_LAST_ID->getInputTextType() ?>" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" name="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->BIRTH_LAST_ID->getPlaceHolder()) ?>" value="<?= $Grid->BIRTH_LAST_ID->EditValue ?>"<?= $Grid->BIRTH_LAST_ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->BIRTH_LAST_ID->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_OBSTETRI_BIRTH_LAST_ID" class="form-group OBSTETRI_BIRTH_LAST_ID">
<span<?= $Grid->BIRTH_LAST_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->BIRTH_LAST_ID->getDisplayValue($Grid->BIRTH_LAST_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="x<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" value="<?= HtmlEncode($Grid->BIRTH_LAST_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="OBSTETRI" data-field="x_BIRTH_LAST_ID" data-hidden="1" name="o<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" id="o<?= $Grid->RowIndex ?>_BIRTH_LAST_ID" value="<?= HtmlEncode($Grid->BIRTH_LAST_ID->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fOBSTETRIgrid","load"], function() {
    fOBSTETRIgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fOBSTETRIgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
<?php } ?>
