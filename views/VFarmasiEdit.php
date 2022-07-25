<?php

namespace PHPMaker2021\simrs;

// Page object
$VFarmasiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fV_FARMASIedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fV_FARMASIedit = currentForm = new ew.Form("fV_FARMASIedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "V_FARMASI")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.V_FARMASI)
        ew.vars.tables.V_FARMASI = currentTable;
    fV_FARMASIedit.addFields([
        ["NO_REGISTRATION", [fields.NO_REGISTRATION.visible && fields.NO_REGISTRATION.required ? ew.Validators.required(fields.NO_REGISTRATION.caption) : null], fields.NO_REGISTRATION.isInvalid],
        ["VISIT_ID", [fields.VISIT_ID.visible && fields.VISIT_ID.required ? ew.Validators.required(fields.VISIT_ID.caption) : null], fields.VISIT_ID.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null], fields.STATUS_PASIEN_ID.isInvalid],
        ["VISIT_DATE", [fields.VISIT_DATE.visible && fields.VISIT_DATE.required ? ew.Validators.required(fields.VISIT_DATE.caption) : null], fields.VISIT_DATE.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["DIANTAR_OLEH", [fields.DIANTAR_OLEH.visible && fields.DIANTAR_OLEH.required ? ew.Validators.required(fields.DIANTAR_OLEH.caption) : null], fields.DIANTAR_OLEH.isInvalid],
        ["GENDER", [fields.GENDER.visible && fields.GENDER.required ? ew.Validators.required(fields.GENDER.caption) : null], fields.GENDER.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["EMPLOYEE_ID", [fields.EMPLOYEE_ID.visible && fields.EMPLOYEE_ID.required ? ew.Validators.required(fields.EMPLOYEE_ID.caption) : null], fields.EMPLOYEE_ID.isInvalid],
        ["TICKET_NO", [fields.TICKET_NO.visible && fields.TICKET_NO.required ? ew.Validators.required(fields.TICKET_NO.caption) : null], fields.TICKET_NO.isInvalid],
        ["AGEYEAR", [fields.AGEYEAR.visible && fields.AGEYEAR.required ? ew.Validators.required(fields.AGEYEAR.caption) : null], fields.AGEYEAR.isInvalid],
        ["TRANS_ID", [fields.TRANS_ID.visible && fields.TRANS_ID.required ? ew.Validators.required(fields.TRANS_ID.caption) : null], fields.TRANS_ID.isInvalid],
        ["IDXDAFTAR", [fields.IDXDAFTAR.visible && fields.IDXDAFTAR.required ? ew.Validators.required(fields.IDXDAFTAR.caption) : null], fields.IDXDAFTAR.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fV_FARMASIedit,
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
    fV_FARMASIedit.validate = function () {
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
    fV_FARMASIedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fV_FARMASIedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fV_FARMASIedit");
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
<form name="fV_FARMASIedit" id="fV_FARMASIedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_FARMASI">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <div id="r_NO_REGISTRATION" class="form-group row">
        <label id="elh_V_FARMASI_NO_REGISTRATION" for="x_NO_REGISTRATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NO_REGISTRATION->caption() ?><?= $Page->NO_REGISTRATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_FARMASI_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->NO_REGISTRATION->getDisplayValue($Page->NO_REGISTRATION->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_NO_REGISTRATION" data-hidden="1" name="x_NO_REGISTRATION" id="x_NO_REGISTRATION" value="<?= HtmlEncode($Page->NO_REGISTRATION->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <div id="r_VISIT_ID" class="form-group row">
        <label id="elh_V_FARMASI_VISIT_ID" for="x_VISIT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_ID->caption() ?><?= $Page->VISIT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_ID->getDisplayValue($Page->VISIT_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_VISIT_ID" data-hidden="1" name="x_VISIT_ID" id="x_VISIT_ID" value="<?= HtmlEncode($Page->VISIT_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_V_FARMASI_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->STATUS_PASIEN_ID->getDisplayValue($Page->STATUS_PASIEN_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_STATUS_PASIEN_ID" data-hidden="1" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" value="<?= HtmlEncode($Page->STATUS_PASIEN_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <div id="r_VISIT_DATE" class="form-group row">
        <label id="elh_V_FARMASI_VISIT_DATE" for="x_VISIT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->VISIT_DATE->caption() ?><?= $Page->VISIT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_VISIT_DATE">
<span<?= $Page->VISIT_DATE->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->VISIT_DATE->getDisplayValue($Page->VISIT_DATE->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_VISIT_DATE" data-hidden="1" name="x_VISIT_DATE" id="x_VISIT_DATE" value="<?= HtmlEncode($Page->VISIT_DATE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_V_FARMASI_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->CLINIC_ID->getDisplayValue($Page->CLINIC_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_CLINIC_ID" data-hidden="1" name="x_CLINIC_ID" id="x_CLINIC_ID" value="<?= HtmlEncode($Page->CLINIC_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <div id="r_DIANTAR_OLEH" class="form-group row">
        <label id="elh_V_FARMASI_DIANTAR_OLEH" for="x_DIANTAR_OLEH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIANTAR_OLEH->caption() ?><?= $Page->DIANTAR_OLEH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_FARMASI_DIANTAR_OLEH">
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DIANTAR_OLEH->getDisplayValue($Page->DIANTAR_OLEH->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_DIANTAR_OLEH" data-hidden="1" name="x_DIANTAR_OLEH" id="x_DIANTAR_OLEH" value="<?= HtmlEncode($Page->DIANTAR_OLEH->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <div id="r_GENDER" class="form-group row">
        <label id="elh_V_FARMASI_GENDER" for="x_GENDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->GENDER->caption() ?><?= $Page->GENDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_V_FARMASI_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->GENDER->getDisplayValue($Page->GENDER->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_GENDER" data-hidden="1" name="x_GENDER" id="x_GENDER" value="<?= HtmlEncode($Page->GENDER->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <div id="r_EMPLOYEE_ID" class="form-group row">
        <label id="elh_V_FARMASI_EMPLOYEE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EMPLOYEE_ID->caption() ?><?= $Page->EMPLOYEE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->EMPLOYEE_ID->getDisplayValue($Page->EMPLOYEE_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_EMPLOYEE_ID" data-hidden="1" name="x_EMPLOYEE_ID" id="x_EMPLOYEE_ID" value="<?= HtmlEncode($Page->EMPLOYEE_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { // TICKET_NO ?>
    <div id="r_TICKET_NO" class="form-group row">
        <label id="elh_V_FARMASI_TICKET_NO" for="x_TICKET_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TICKET_NO->caption() ?><?= $Page->TICKET_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TICKET_NO->cellAttributes() ?>>
<span id="el_V_FARMASI_TICKET_NO">
<span<?= $Page->TICKET_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TICKET_NO->getDisplayValue($Page->TICKET_NO->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_TICKET_NO" data-hidden="1" name="x_TICKET_NO" id="x_TICKET_NO" value="<?= HtmlEncode($Page->TICKET_NO->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <div id="r_AGEYEAR" class="form-group row">
        <label id="elh_V_FARMASI_AGEYEAR" for="x_AGEYEAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AGEYEAR->caption() ?><?= $Page->AGEYEAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_V_FARMASI_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->AGEYEAR->getDisplayValue($Page->AGEYEAR->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_AGEYEAR" data-hidden="1" name="x_AGEYEAR" id="x_AGEYEAR" value="<?= HtmlEncode($Page->AGEYEAR->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <div id="r_TRANS_ID" class="form-group row">
        <label id="elh_V_FARMASI_TRANS_ID" for="x_TRANS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TRANS_ID->caption() ?><?= $Page->TRANS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->TRANS_ID->getDisplayValue($Page->TRANS_ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_TRANS_ID" data-hidden="1" name="x_TRANS_ID" id="x_TRANS_ID" value="<?= HtmlEncode($Page->TRANS_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
    <div id="r_IDXDAFTAR" class="form-group row">
        <label id="elh_V_FARMASI_IDXDAFTAR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IDXDAFTAR->caption() ?><?= $Page->IDXDAFTAR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_FARMASI_IDXDAFTAR">
<span<?= $Page->IDXDAFTAR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->IDXDAFTAR->getDisplayValue($Page->IDXDAFTAR->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="V_FARMASI" data-field="x_IDXDAFTAR" data-hidden="1" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?= HtmlEncode($Page->IDXDAFTAR->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("TREATMENT_OBAT", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_OBAT->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_OBAT") {
            $firstActiveDetailTable = "TREATMENT_OBAT";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_OBAT") ?>" href="#tab_TREATMENT_OBAT" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_OBAT", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_BILL") {
            $firstActiveDetailTable = "TREATMENT_BILL";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("TREATMENT_BILL") ?>" href="#tab_TREATMENT_BILL" data-toggle="tab"><?= $Language->tablePhrase("TREATMENT_BILL", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("TREATMENT_OBAT", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_OBAT->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_OBAT") {
            $firstActiveDetailTable = "TREATMENT_OBAT";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_OBAT") ?>" id="tab_TREATMENT_OBAT"><!-- page* -->
<?php include_once "TreatmentObatGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "TREATMENT_BILL") {
            $firstActiveDetailTable = "TREATMENT_BILL";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("TREATMENT_BILL") ?>" id="tab_TREATMENT_BILL"><!-- page* -->
<?php include_once "TreatmentBillGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
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
    ew.addEventHandlers("V_FARMASI");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
