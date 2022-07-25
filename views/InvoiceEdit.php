<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$InvoiceEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fINVOICEedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fINVOICEedit = currentForm = new ew.Form("fINVOICEedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "INVOICE")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.INVOICE)
        ew.vars.tables.INVOICE = currentTable;
    fINVOICEedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["INVOICE_TYPE", [fields.INVOICE_TYPE.visible && fields.INVOICE_TYPE.required ? ew.Validators.required(fields.INVOICE_TYPE.caption) : null, ew.Validators.integer], fields.INVOICE_TYPE.isInvalid],
        ["INVOICE_NO", [fields.INVOICE_NO.visible && fields.INVOICE_NO.required ? ew.Validators.required(fields.INVOICE_NO.caption) : null], fields.INVOICE_NO.isInvalid],
        ["INV_COUNTER", [fields.INV_COUNTER.visible && fields.INV_COUNTER.required ? ew.Validators.required(fields.INV_COUNTER.caption) : null, ew.Validators.integer], fields.INV_COUNTER.isInvalid],
        ["INV_DATE", [fields.INV_DATE.visible && fields.INV_DATE.required ? ew.Validators.required(fields.INV_DATE.caption) : null, ew.Validators.datetime(0)], fields.INV_DATE.isInvalid],
        ["INVOICE_TRANS", [fields.INVOICE_TRANS.visible && fields.INVOICE_TRANS.required ? ew.Validators.required(fields.INVOICE_TRANS.caption) : null, ew.Validators.datetime(0)], fields.INVOICE_TRANS.isInvalid],
        ["INVOICE_DUE", [fields.INVOICE_DUE.visible && fields.INVOICE_DUE.required ? ew.Validators.required(fields.INVOICE_DUE.caption) : null, ew.Validators.datetime(0)], fields.INVOICE_DUE.isInvalid],
        ["REF_TYPE", [fields.REF_TYPE.visible && fields.REF_TYPE.required ? ew.Validators.required(fields.REF_TYPE.caption) : null, ew.Validators.integer], fields.REF_TYPE.isInvalid],
        ["REF_NO", [fields.REF_NO.visible && fields.REF_NO.required ? ew.Validators.required(fields.REF_NO.caption) : null], fields.REF_NO.isInvalid],
        ["REF_NO2", [fields.REF_NO2.visible && fields.REF_NO2.required ? ew.Validators.required(fields.REF_NO2.caption) : null], fields.REF_NO2.isInvalid],
        ["REF_DATE", [fields.REF_DATE.visible && fields.REF_DATE.required ? ew.Validators.required(fields.REF_DATE.caption) : null, ew.Validators.datetime(0)], fields.REF_DATE.isInvalid],
        ["ACCOUNT_ID", [fields.ACCOUNT_ID.visible && fields.ACCOUNT_ID.required ? ew.Validators.required(fields.ACCOUNT_ID.caption) : null], fields.ACCOUNT_ID.isInvalid],
        ["YEAR_ID", [fields.YEAR_ID.visible && fields.YEAR_ID.required ? ew.Validators.required(fields.YEAR_ID.caption) : null, ew.Validators.integer], fields.YEAR_ID.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["PROGRAM_ID", [fields.PROGRAM_ID.visible && fields.PROGRAM_ID.required ? ew.Validators.required(fields.PROGRAM_ID.caption) : null], fields.PROGRAM_ID.isInvalid],
        ["PROGRAMS", [fields.PROGRAMS.visible && fields.PROGRAMS.required ? ew.Validators.required(fields.PROGRAMS.caption) : null], fields.PROGRAMS.isInvalid],
        ["PACTIVITY_ID", [fields.PACTIVITY_ID.visible && fields.PACTIVITY_ID.required ? ew.Validators.required(fields.PACTIVITY_ID.caption) : null], fields.PACTIVITY_ID.isInvalid],
        ["ACTIVITY_ID", [fields.ACTIVITY_ID.visible && fields.ACTIVITY_ID.required ? ew.Validators.required(fields.ACTIVITY_ID.caption) : null], fields.ACTIVITY_ID.isInvalid],
        ["ACTIVITY_NAME", [fields.ACTIVITY_NAME.visible && fields.ACTIVITY_NAME.required ? ew.Validators.required(fields.ACTIVITY_NAME.caption) : null], fields.ACTIVITY_NAME.isInvalid],
        ["KEPERLUAN", [fields.KEPERLUAN.visible && fields.KEPERLUAN.required ? ew.Validators.required(fields.KEPERLUAN.caption) : null], fields.KEPERLUAN.isInvalid],
        ["PPTK", [fields.PPTK.visible && fields.PPTK.required ? ew.Validators.required(fields.PPTK.caption) : null], fields.PPTK.isInvalid],
        ["PPTK_NAME", [fields.PPTK_NAME.visible && fields.PPTK_NAME.required ? ew.Validators.required(fields.PPTK_NAME.caption) : null], fields.PPTK_NAME.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["COMPANY_TO", [fields.COMPANY_TO.visible && fields.COMPANY_TO.required ? ew.Validators.required(fields.COMPANY_TO.caption) : null], fields.COMPANY_TO.isInvalid],
        ["COMPANY_TYPE", [fields.COMPANY_TYPE.visible && fields.COMPANY_TYPE.required ? ew.Validators.required(fields.COMPANY_TYPE.caption) : null], fields.COMPANY_TYPE.isInvalid],
        ["COMPANY", [fields.COMPANY.visible && fields.COMPANY.required ? ew.Validators.required(fields.COMPANY.caption) : null], fields.COMPANY.isInvalid],
        ["COMPANY_CHIEF", [fields.COMPANY_CHIEF.visible && fields.COMPANY_CHIEF.required ? ew.Validators.required(fields.COMPANY_CHIEF.caption) : null], fields.COMPANY_CHIEF.isInvalid],
        ["COMPANY_INFO", [fields.COMPANY_INFO.visible && fields.COMPANY_INFO.required ? ew.Validators.required(fields.COMPANY_INFO.caption) : null], fields.COMPANY_INFO.isInvalid],
        ["CONTRACT_NO", [fields.CONTRACT_NO.visible && fields.CONTRACT_NO.required ? ew.Validators.required(fields.CONTRACT_NO.caption) : null], fields.CONTRACT_NO.isInvalid],
        ["NPWP", [fields.NPWP.visible && fields.NPWP.required ? ew.Validators.required(fields.NPWP.caption) : null], fields.NPWP.isInvalid],
        ["COMPANY_BANK", [fields.COMPANY_BANK.visible && fields.COMPANY_BANK.required ? ew.Validators.required(fields.COMPANY_BANK.caption) : null], fields.COMPANY_BANK.isInvalid],
        ["COMPANY_ACCOUNT", [fields.COMPANY_ACCOUNT.visible && fields.COMPANY_ACCOUNT.required ? ew.Validators.required(fields.COMPANY_ACCOUNT.caption) : null], fields.COMPANY_ACCOUNT.isInvalid],
        ["PAGU", [fields.PAGU.visible && fields.PAGU.required ? ew.Validators.required(fields.PAGU.caption) : null, ew.Validators.float], fields.PAGU.isInvalid],
        ["PAGU_REALISASI", [fields.PAGU_REALISASI.visible && fields.PAGU_REALISASI.required ? ew.Validators.required(fields.PAGU_REALISASI.caption) : null, ew.Validators.float], fields.PAGU_REALISASI.isInvalid],
        ["AMOUNT", [fields.AMOUNT.visible && fields.AMOUNT.required ? ew.Validators.required(fields.AMOUNT.caption) : null, ew.Validators.float], fields.AMOUNT.isInvalid],
        ["AMOUNT_PAID", [fields.AMOUNT_PAID.visible && fields.AMOUNT_PAID.required ? ew.Validators.required(fields.AMOUNT_PAID.caption) : null, ew.Validators.float], fields.AMOUNT_PAID.isInvalid],
        ["PAYMENT_INSTRUCTIONS", [fields.PAYMENT_INSTRUCTIONS.visible && fields.PAYMENT_INSTRUCTIONS.required ? ew.Validators.required(fields.PAYMENT_INSTRUCTIONS.caption) : null], fields.PAYMENT_INSTRUCTIONS.isInvalid],
        ["ISAPPROVED", [fields.ISAPPROVED.visible && fields.ISAPPROVED.required ? ew.Validators.required(fields.ISAPPROVED.caption) : null], fields.ISAPPROVED.isInvalid],
        ["APPROVED_BY", [fields.APPROVED_BY.visible && fields.APPROVED_BY.required ? ew.Validators.required(fields.APPROVED_BY.caption) : null], fields.APPROVED_BY.isInvalid],
        ["APPROVED_DATE", [fields.APPROVED_DATE.visible && fields.APPROVED_DATE.required ? ew.Validators.required(fields.APPROVED_DATE.caption) : null, ew.Validators.datetime(0)], fields.APPROVED_DATE.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["PPTK_TITLE", [fields.PPTK_TITLE.visible && fields.PPTK_TITLE.required ? ew.Validators.required(fields.PPTK_TITLE.caption) : null], fields.PPTK_TITLE.isInvalid],
        ["APPROVED_ID", [fields.APPROVED_ID.visible && fields.APPROVED_ID.required ? ew.Validators.required(fields.APPROVED_ID.caption) : null], fields.APPROVED_ID.isInvalid],
        ["APPROVED_TITLE", [fields.APPROVED_TITLE.visible && fields.APPROVED_TITLE.required ? ew.Validators.required(fields.APPROVED_TITLE.caption) : null], fields.APPROVED_TITLE.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fINVOICEedit,
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
    fINVOICEedit.validate = function () {
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
    fINVOICEedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fINVOICEedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fINVOICEedit");
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
<form name="fINVOICEedit" id="fINVOICEedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="INVOICE">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_INVOICE_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="INVOICE" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
<input type="hidden" data-table="INVOICE" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o_ORG_UNIT_CODE" id="o_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue ?? $Page->ORG_UNIT_CODE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label id="elh_INVOICE_INVOICE_ID" for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?><?= $Page->INVOICE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?> aria-describedby="x_INVOICE_ID_help">
<?= $Page->INVOICE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="INVOICE" data-field="x_INVOICE_ID" data-hidden="1" name="o_INVOICE_ID" id="o_INVOICE_ID" value="<?= HtmlEncode($Page->INVOICE_ID->OldValue ?? $Page->INVOICE_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
    <div id="r_INVOICE_TYPE" class="form-group row">
        <label id="elh_INVOICE_INVOICE_TYPE" for="x_INVOICE_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_TYPE->caption() ?><?= $Page->INVOICE_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_TYPE->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_TYPE">
<input type="<?= $Page->INVOICE_TYPE->getInputTextType() ?>" data-table="INVOICE" data-field="x_INVOICE_TYPE" name="x_INVOICE_TYPE" id="x_INVOICE_TYPE" size="30" placeholder="<?= HtmlEncode($Page->INVOICE_TYPE->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_TYPE->EditValue ?>"<?= $Page->INVOICE_TYPE->editAttributes() ?> aria-describedby="x_INVOICE_TYPE_help">
<?= $Page->INVOICE_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
    <div id="r_INVOICE_NO" class="form-group row">
        <label id="elh_INVOICE_INVOICE_NO" for="x_INVOICE_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_NO->caption() ?><?= $Page->INVOICE_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_NO->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_NO">
<input type="<?= $Page->INVOICE_NO->getInputTextType() ?>" data-table="INVOICE" data-field="x_INVOICE_NO" name="x_INVOICE_NO" id="x_INVOICE_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_NO->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_NO->EditValue ?>"<?= $Page->INVOICE_NO->editAttributes() ?> aria-describedby="x_INVOICE_NO_help">
<?= $Page->INVOICE_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
    <div id="r_INV_COUNTER" class="form-group row">
        <label id="elh_INVOICE_INV_COUNTER" for="x_INV_COUNTER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INV_COUNTER->caption() ?><?= $Page->INV_COUNTER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INV_COUNTER->cellAttributes() ?>>
<span id="el_INVOICE_INV_COUNTER">
<input type="<?= $Page->INV_COUNTER->getInputTextType() ?>" data-table="INVOICE" data-field="x_INV_COUNTER" name="x_INV_COUNTER" id="x_INV_COUNTER" size="30" placeholder="<?= HtmlEncode($Page->INV_COUNTER->getPlaceHolder()) ?>" value="<?= $Page->INV_COUNTER->EditValue ?>"<?= $Page->INV_COUNTER->editAttributes() ?> aria-describedby="x_INV_COUNTER_help">
<?= $Page->INV_COUNTER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INV_COUNTER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
    <div id="r_INV_DATE" class="form-group row">
        <label id="elh_INVOICE_INV_DATE" for="x_INV_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INV_DATE->caption() ?><?= $Page->INV_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INV_DATE->cellAttributes() ?>>
<span id="el_INVOICE_INV_DATE">
<input type="<?= $Page->INV_DATE->getInputTextType() ?>" data-table="INVOICE" data-field="x_INV_DATE" name="x_INV_DATE" id="x_INV_DATE" placeholder="<?= HtmlEncode($Page->INV_DATE->getPlaceHolder()) ?>" value="<?= $Page->INV_DATE->EditValue ?>"<?= $Page->INV_DATE->editAttributes() ?> aria-describedby="x_INV_DATE_help">
<?= $Page->INV_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INV_DATE->getErrorMessage() ?></div>
<?php if (!$Page->INV_DATE->ReadOnly && !$Page->INV_DATE->Disabled && !isset($Page->INV_DATE->EditAttrs["readonly"]) && !isset($Page->INV_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_INV_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
    <div id="r_INVOICE_TRANS" class="form-group row">
        <label id="elh_INVOICE_INVOICE_TRANS" for="x_INVOICE_TRANS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_TRANS->caption() ?><?= $Page->INVOICE_TRANS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_TRANS->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_TRANS">
<input type="<?= $Page->INVOICE_TRANS->getInputTextType() ?>" data-table="INVOICE" data-field="x_INVOICE_TRANS" name="x_INVOICE_TRANS" id="x_INVOICE_TRANS" placeholder="<?= HtmlEncode($Page->INVOICE_TRANS->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_TRANS->EditValue ?>"<?= $Page->INVOICE_TRANS->editAttributes() ?> aria-describedby="x_INVOICE_TRANS_help">
<?= $Page->INVOICE_TRANS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_TRANS->getErrorMessage() ?></div>
<?php if (!$Page->INVOICE_TRANS->ReadOnly && !$Page->INVOICE_TRANS->Disabled && !isset($Page->INVOICE_TRANS->EditAttrs["readonly"]) && !isset($Page->INVOICE_TRANS->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_INVOICE_TRANS", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
    <div id="r_INVOICE_DUE" class="form-group row">
        <label id="elh_INVOICE_INVOICE_DUE" for="x_INVOICE_DUE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_DUE->caption() ?><?= $Page->INVOICE_DUE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_DUE->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_DUE">
<input type="<?= $Page->INVOICE_DUE->getInputTextType() ?>" data-table="INVOICE" data-field="x_INVOICE_DUE" name="x_INVOICE_DUE" id="x_INVOICE_DUE" placeholder="<?= HtmlEncode($Page->INVOICE_DUE->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_DUE->EditValue ?>"<?= $Page->INVOICE_DUE->editAttributes() ?> aria-describedby="x_INVOICE_DUE_help">
<?= $Page->INVOICE_DUE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_DUE->getErrorMessage() ?></div>
<?php if (!$Page->INVOICE_DUE->ReadOnly && !$Page->INVOICE_DUE->Disabled && !isset($Page->INVOICE_DUE->EditAttrs["readonly"]) && !isset($Page->INVOICE_DUE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_INVOICE_DUE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
    <div id="r_REF_TYPE" class="form-group row">
        <label id="elh_INVOICE_REF_TYPE" for="x_REF_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_TYPE->caption() ?><?= $Page->REF_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_TYPE->cellAttributes() ?>>
<span id="el_INVOICE_REF_TYPE">
<input type="<?= $Page->REF_TYPE->getInputTextType() ?>" data-table="INVOICE" data-field="x_REF_TYPE" name="x_REF_TYPE" id="x_REF_TYPE" size="30" placeholder="<?= HtmlEncode($Page->REF_TYPE->getPlaceHolder()) ?>" value="<?= $Page->REF_TYPE->EditValue ?>"<?= $Page->REF_TYPE->editAttributes() ?> aria-describedby="x_REF_TYPE_help">
<?= $Page->REF_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REF_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REF_NO->Visible) { // REF_NO ?>
    <div id="r_REF_NO" class="form-group row">
        <label id="elh_INVOICE_REF_NO" for="x_REF_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_NO->caption() ?><?= $Page->REF_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_NO->cellAttributes() ?>>
<span id="el_INVOICE_REF_NO">
<input type="<?= $Page->REF_NO->getInputTextType() ?>" data-table="INVOICE" data-field="x_REF_NO" name="x_REF_NO" id="x_REF_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Page->REF_NO->getPlaceHolder()) ?>" value="<?= $Page->REF_NO->EditValue ?>"<?= $Page->REF_NO->editAttributes() ?> aria-describedby="x_REF_NO_help">
<?= $Page->REF_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REF_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
    <div id="r_REF_NO2" class="form-group row">
        <label id="elh_INVOICE_REF_NO2" for="x_REF_NO2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_NO2->caption() ?><?= $Page->REF_NO2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_NO2->cellAttributes() ?>>
<span id="el_INVOICE_REF_NO2">
<input type="<?= $Page->REF_NO2->getInputTextType() ?>" data-table="INVOICE" data-field="x_REF_NO2" name="x_REF_NO2" id="x_REF_NO2" size="30" maxlength="75" placeholder="<?= HtmlEncode($Page->REF_NO2->getPlaceHolder()) ?>" value="<?= $Page->REF_NO2->EditValue ?>"<?= $Page->REF_NO2->editAttributes() ?> aria-describedby="x_REF_NO2_help">
<?= $Page->REF_NO2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REF_NO2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
    <div id="r_REF_DATE" class="form-group row">
        <label id="elh_INVOICE_REF_DATE" for="x_REF_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REF_DATE->caption() ?><?= $Page->REF_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REF_DATE->cellAttributes() ?>>
<span id="el_INVOICE_REF_DATE">
<input type="<?= $Page->REF_DATE->getInputTextType() ?>" data-table="INVOICE" data-field="x_REF_DATE" name="x_REF_DATE" id="x_REF_DATE" placeholder="<?= HtmlEncode($Page->REF_DATE->getPlaceHolder()) ?>" value="<?= $Page->REF_DATE->EditValue ?>"<?= $Page->REF_DATE->editAttributes() ?> aria-describedby="x_REF_DATE_help">
<?= $Page->REF_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REF_DATE->getErrorMessage() ?></div>
<?php if (!$Page->REF_DATE->ReadOnly && !$Page->REF_DATE->Disabled && !isset($Page->REF_DATE->EditAttrs["readonly"]) && !isset($Page->REF_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_REF_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <div id="r_ACCOUNT_ID" class="form-group row">
        <label id="elh_INVOICE_ACCOUNT_ID" for="x_ACCOUNT_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACCOUNT_ID->caption() ?><?= $Page->ACCOUNT_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_INVOICE_ACCOUNT_ID">
<input type="<?= $Page->ACCOUNT_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_ACCOUNT_ID" name="x_ACCOUNT_ID" id="x_ACCOUNT_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ACCOUNT_ID->getPlaceHolder()) ?>" value="<?= $Page->ACCOUNT_ID->EditValue ?>"<?= $Page->ACCOUNT_ID->editAttributes() ?> aria-describedby="x_ACCOUNT_ID_help">
<?= $Page->ACCOUNT_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACCOUNT_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <div id="r_YEAR_ID" class="form-group row">
        <label id="elh_INVOICE_YEAR_ID" for="x_YEAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->YEAR_ID->caption() ?><?= $Page->YEAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el_INVOICE_YEAR_ID">
<input type="<?= $Page->YEAR_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_YEAR_ID" name="x_YEAR_ID" id="x_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Page->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Page->YEAR_ID->EditValue ?>"<?= $Page->YEAR_ID->editAttributes() ?> aria-describedby="x_YEAR_ID_help">
<?= $Page->YEAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->YEAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <div id="r_ORG_ID" class="form-group row">
        <label id="elh_INVOICE_ORG_ID" for="x_ORG_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_ID->caption() ?><?= $Page->ORG_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_INVOICE_ORG_ID">
<input type="<?= $Page->ORG_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_ORG_ID" name="x_ORG_ID" id="x_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_ID->getPlaceHolder()) ?>" value="<?= $Page->ORG_ID->EditValue ?>"<?= $Page->ORG_ID->editAttributes() ?> aria-describedby="x_ORG_ID_help">
<?= $Page->ORG_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
    <div id="r_PROGRAM_ID" class="form-group row">
        <label id="elh_INVOICE_PROGRAM_ID" for="x_PROGRAM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PROGRAM_ID->caption() ?><?= $Page->PROGRAM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROGRAM_ID->cellAttributes() ?>>
<span id="el_INVOICE_PROGRAM_ID">
<input type="<?= $Page->PROGRAM_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_PROGRAM_ID" name="x_PROGRAM_ID" id="x_PROGRAM_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PROGRAM_ID->getPlaceHolder()) ?>" value="<?= $Page->PROGRAM_ID->EditValue ?>"<?= $Page->PROGRAM_ID->editAttributes() ?> aria-describedby="x_PROGRAM_ID_help">
<?= $Page->PROGRAM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PROGRAM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
    <div id="r_PROGRAMS" class="form-group row">
        <label id="elh_INVOICE_PROGRAMS" for="x_PROGRAMS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PROGRAMS->caption() ?><?= $Page->PROGRAMS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PROGRAMS->cellAttributes() ?>>
<span id="el_INVOICE_PROGRAMS">
<input type="<?= $Page->PROGRAMS->getInputTextType() ?>" data-table="INVOICE" data-field="x_PROGRAMS" name="x_PROGRAMS" id="x_PROGRAMS" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->PROGRAMS->getPlaceHolder()) ?>" value="<?= $Page->PROGRAMS->EditValue ?>"<?= $Page->PROGRAMS->editAttributes() ?> aria-describedby="x_PROGRAMS_help">
<?= $Page->PROGRAMS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PROGRAMS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
    <div id="r_PACTIVITY_ID" class="form-group row">
        <label id="elh_INVOICE_PACTIVITY_ID" for="x_PACTIVITY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PACTIVITY_ID->caption() ?><?= $Page->PACTIVITY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PACTIVITY_ID->cellAttributes() ?>>
<span id="el_INVOICE_PACTIVITY_ID">
<input type="<?= $Page->PACTIVITY_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_PACTIVITY_ID" name="x_PACTIVITY_ID" id="x_PACTIVITY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PACTIVITY_ID->getPlaceHolder()) ?>" value="<?= $Page->PACTIVITY_ID->EditValue ?>"<?= $Page->PACTIVITY_ID->editAttributes() ?> aria-describedby="x_PACTIVITY_ID_help">
<?= $Page->PACTIVITY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PACTIVITY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
    <div id="r_ACTIVITY_ID" class="form-group row">
        <label id="elh_INVOICE_ACTIVITY_ID" for="x_ACTIVITY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACTIVITY_ID->caption() ?><?= $Page->ACTIVITY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACTIVITY_ID->cellAttributes() ?>>
<span id="el_INVOICE_ACTIVITY_ID">
<input type="<?= $Page->ACTIVITY_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_ACTIVITY_ID" name="x_ACTIVITY_ID" id="x_ACTIVITY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ACTIVITY_ID->getPlaceHolder()) ?>" value="<?= $Page->ACTIVITY_ID->EditValue ?>"<?= $Page->ACTIVITY_ID->editAttributes() ?> aria-describedby="x_ACTIVITY_ID_help">
<?= $Page->ACTIVITY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACTIVITY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
    <div id="r_ACTIVITY_NAME" class="form-group row">
        <label id="elh_INVOICE_ACTIVITY_NAME" for="x_ACTIVITY_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ACTIVITY_NAME->caption() ?><?= $Page->ACTIVITY_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ACTIVITY_NAME->cellAttributes() ?>>
<span id="el_INVOICE_ACTIVITY_NAME">
<input type="<?= $Page->ACTIVITY_NAME->getInputTextType() ?>" data-table="INVOICE" data-field="x_ACTIVITY_NAME" name="x_ACTIVITY_NAME" id="x_ACTIVITY_NAME" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->ACTIVITY_NAME->getPlaceHolder()) ?>" value="<?= $Page->ACTIVITY_NAME->EditValue ?>"<?= $Page->ACTIVITY_NAME->editAttributes() ?> aria-describedby="x_ACTIVITY_NAME_help">
<?= $Page->ACTIVITY_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ACTIVITY_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
    <div id="r_KEPERLUAN" class="form-group row">
        <label id="elh_INVOICE_KEPERLUAN" for="x_KEPERLUAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->KEPERLUAN->caption() ?><?= $Page->KEPERLUAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->KEPERLUAN->cellAttributes() ?>>
<span id="el_INVOICE_KEPERLUAN">
<input type="<?= $Page->KEPERLUAN->getInputTextType() ?>" data-table="INVOICE" data-field="x_KEPERLUAN" name="x_KEPERLUAN" id="x_KEPERLUAN" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->KEPERLUAN->getPlaceHolder()) ?>" value="<?= $Page->KEPERLUAN->EditValue ?>"<?= $Page->KEPERLUAN->editAttributes() ?> aria-describedby="x_KEPERLUAN_help">
<?= $Page->KEPERLUAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->KEPERLUAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPTK->Visible) { // PPTK ?>
    <div id="r_PPTK" class="form-group row">
        <label id="elh_INVOICE_PPTK" for="x_PPTK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPTK->caption() ?><?= $Page->PPTK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPTK->cellAttributes() ?>>
<span id="el_INVOICE_PPTK">
<input type="<?= $Page->PPTK->getInputTextType() ?>" data-table="INVOICE" data-field="x_PPTK" name="x_PPTK" id="x_PPTK" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PPTK->getPlaceHolder()) ?>" value="<?= $Page->PPTK->EditValue ?>"<?= $Page->PPTK->editAttributes() ?> aria-describedby="x_PPTK_help">
<?= $Page->PPTK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPTK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
    <div id="r_PPTK_NAME" class="form-group row">
        <label id="elh_INVOICE_PPTK_NAME" for="x_PPTK_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPTK_NAME->caption() ?><?= $Page->PPTK_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPTK_NAME->cellAttributes() ?>>
<span id="el_INVOICE_PPTK_NAME">
<input type="<?= $Page->PPTK_NAME->getInputTextType() ?>" data-table="INVOICE" data-field="x_PPTK_NAME" name="x_PPTK_NAME" id="x_PPTK_NAME" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->PPTK_NAME->getPlaceHolder()) ?>" value="<?= $Page->PPTK_NAME->EditValue ?>"<?= $Page->PPTK_NAME->editAttributes() ?> aria-describedby="x_PPTK_NAME_help">
<?= $Page->PPTK_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPTK_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <div id="r_COMPANY_ID" class="form-group row">
        <label id="elh_INVOICE_COMPANY_ID" for="x_COMPANY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?><?= $Page->COMPANY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_ID">
<input type="<?= $Page->COMPANY_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_ID" name="x_COMPANY_ID" id="x_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ID->EditValue ?>"<?= $Page->COMPANY_ID->editAttributes() ?> aria-describedby="x_COMPANY_ID_help">
<?= $Page->COMPANY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
    <div id="r_COMPANY_TO" class="form-group row">
        <label id="elh_INVOICE_COMPANY_TO" for="x_COMPANY_TO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_TO->caption() ?><?= $Page->COMPANY_TO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_TO->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_TO">
<input type="<?= $Page->COMPANY_TO->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_TO" name="x_COMPANY_TO" id="x_COMPANY_TO" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->COMPANY_TO->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_TO->EditValue ?>"<?= $Page->COMPANY_TO->editAttributes() ?> aria-describedby="x_COMPANY_TO_help">
<?= $Page->COMPANY_TO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_TO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
    <div id="r_COMPANY_TYPE" class="form-group row">
        <label id="elh_INVOICE_COMPANY_TYPE" for="x_COMPANY_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_TYPE->caption() ?><?= $Page->COMPANY_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_TYPE->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_TYPE">
<input type="<?= $Page->COMPANY_TYPE->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_TYPE" name="x_COMPANY_TYPE" id="x_COMPANY_TYPE" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->COMPANY_TYPE->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_TYPE->EditValue ?>"<?= $Page->COMPANY_TYPE->editAttributes() ?> aria-describedby="x_COMPANY_TYPE_help">
<?= $Page->COMPANY_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY->Visible) { // COMPANY ?>
    <div id="r_COMPANY" class="form-group row">
        <label id="elh_INVOICE_COMPANY" for="x_COMPANY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY->caption() ?><?= $Page->COMPANY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY">
<input type="<?= $Page->COMPANY->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY" name="x_COMPANY" id="x_COMPANY" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->COMPANY->getPlaceHolder()) ?>" value="<?= $Page->COMPANY->EditValue ?>"<?= $Page->COMPANY->editAttributes() ?> aria-describedby="x_COMPANY_help">
<?= $Page->COMPANY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
    <div id="r_COMPANY_CHIEF" class="form-group row">
        <label id="elh_INVOICE_COMPANY_CHIEF" for="x_COMPANY_CHIEF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_CHIEF->caption() ?><?= $Page->COMPANY_CHIEF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_CHIEF->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_CHIEF">
<input type="<?= $Page->COMPANY_CHIEF->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_CHIEF" name="x_COMPANY_CHIEF" id="x_COMPANY_CHIEF" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->COMPANY_CHIEF->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_CHIEF->EditValue ?>"<?= $Page->COMPANY_CHIEF->editAttributes() ?> aria-describedby="x_COMPANY_CHIEF_help">
<?= $Page->COMPANY_CHIEF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_CHIEF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
    <div id="r_COMPANY_INFO" class="form-group row">
        <label id="elh_INVOICE_COMPANY_INFO" for="x_COMPANY_INFO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_INFO->caption() ?><?= $Page->COMPANY_INFO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_INFO->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_INFO">
<input type="<?= $Page->COMPANY_INFO->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_INFO" name="x_COMPANY_INFO" id="x_COMPANY_INFO" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->COMPANY_INFO->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_INFO->EditValue ?>"<?= $Page->COMPANY_INFO->editAttributes() ?> aria-describedby="x_COMPANY_INFO_help">
<?= $Page->COMPANY_INFO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_INFO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
    <div id="r_CONTRACT_NO" class="form-group row">
        <label id="elh_INVOICE_CONTRACT_NO" for="x_CONTRACT_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONTRACT_NO->caption() ?><?= $Page->CONTRACT_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el_INVOICE_CONTRACT_NO">
<input type="<?= $Page->CONTRACT_NO->getInputTextType() ?>" data-table="INVOICE" data-field="x_CONTRACT_NO" name="x_CONTRACT_NO" id="x_CONTRACT_NO" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->CONTRACT_NO->getPlaceHolder()) ?>" value="<?= $Page->CONTRACT_NO->EditValue ?>"<?= $Page->CONTRACT_NO->editAttributes() ?> aria-describedby="x_CONTRACT_NO_help">
<?= $Page->CONTRACT_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONTRACT_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
    <div id="r_NPWP" class="form-group row">
        <label id="elh_INVOICE_NPWP" for="x_NPWP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NPWP->caption() ?><?= $Page->NPWP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NPWP->cellAttributes() ?>>
<span id="el_INVOICE_NPWP">
<input type="<?= $Page->NPWP->getInputTextType() ?>" data-table="INVOICE" data-field="x_NPWP" name="x_NPWP" id="x_NPWP" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->NPWP->getPlaceHolder()) ?>" value="<?= $Page->NPWP->EditValue ?>"<?= $Page->NPWP->editAttributes() ?> aria-describedby="x_NPWP_help">
<?= $Page->NPWP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NPWP->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
    <div id="r_COMPANY_BANK" class="form-group row">
        <label id="elh_INVOICE_COMPANY_BANK" for="x_COMPANY_BANK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_BANK->caption() ?><?= $Page->COMPANY_BANK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_BANK->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_BANK">
<input type="<?= $Page->COMPANY_BANK->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_BANK" name="x_COMPANY_BANK" id="x_COMPANY_BANK" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_BANK->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_BANK->EditValue ?>"<?= $Page->COMPANY_BANK->editAttributes() ?> aria-describedby="x_COMPANY_BANK_help">
<?= $Page->COMPANY_BANK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_BANK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
    <div id="r_COMPANY_ACCOUNT" class="form-group row">
        <label id="elh_INVOICE_COMPANY_ACCOUNT" for="x_COMPANY_ACCOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ACCOUNT->caption() ?><?= $Page->COMPANY_ACCOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ACCOUNT->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_ACCOUNT">
<input type="<?= $Page->COMPANY_ACCOUNT->getInputTextType() ?>" data-table="INVOICE" data-field="x_COMPANY_ACCOUNT" name="x_COMPANY_ACCOUNT" id="x_COMPANY_ACCOUNT" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ACCOUNT->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ACCOUNT->EditValue ?>"<?= $Page->COMPANY_ACCOUNT->editAttributes() ?> aria-describedby="x_COMPANY_ACCOUNT_help">
<?= $Page->COMPANY_ACCOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ACCOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAGU->Visible) { // PAGU ?>
    <div id="r_PAGU" class="form-group row">
        <label id="elh_INVOICE_PAGU" for="x_PAGU" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAGU->caption() ?><?= $Page->PAGU->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAGU->cellAttributes() ?>>
<span id="el_INVOICE_PAGU">
<input type="<?= $Page->PAGU->getInputTextType() ?>" data-table="INVOICE" data-field="x_PAGU" name="x_PAGU" id="x_PAGU" size="30" placeholder="<?= HtmlEncode($Page->PAGU->getPlaceHolder()) ?>" value="<?= $Page->PAGU->EditValue ?>"<?= $Page->PAGU->editAttributes() ?> aria-describedby="x_PAGU_help">
<?= $Page->PAGU->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAGU->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
    <div id="r_PAGU_REALISASI" class="form-group row">
        <label id="elh_INVOICE_PAGU_REALISASI" for="x_PAGU_REALISASI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAGU_REALISASI->caption() ?><?= $Page->PAGU_REALISASI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAGU_REALISASI->cellAttributes() ?>>
<span id="el_INVOICE_PAGU_REALISASI">
<input type="<?= $Page->PAGU_REALISASI->getInputTextType() ?>" data-table="INVOICE" data-field="x_PAGU_REALISASI" name="x_PAGU_REALISASI" id="x_PAGU_REALISASI" size="30" placeholder="<?= HtmlEncode($Page->PAGU_REALISASI->getPlaceHolder()) ?>" value="<?= $Page->PAGU_REALISASI->EditValue ?>"<?= $Page->PAGU_REALISASI->editAttributes() ?> aria-describedby="x_PAGU_REALISASI_help">
<?= $Page->PAGU_REALISASI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAGU_REALISASI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <div id="r_AMOUNT" class="form-group row">
        <label id="elh_INVOICE_AMOUNT" for="x_AMOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT->caption() ?><?= $Page->AMOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_INVOICE_AMOUNT">
<input type="<?= $Page->AMOUNT->getInputTextType() ?>" data-table="INVOICE" data-field="x_AMOUNT" name="x_AMOUNT" id="x_AMOUNT" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT->EditValue ?>"<?= $Page->AMOUNT->editAttributes() ?> aria-describedby="x_AMOUNT_help">
<?= $Page->AMOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
    <div id="r_AMOUNT_PAID" class="form-group row">
        <label id="elh_INVOICE_AMOUNT_PAID" for="x_AMOUNT_PAID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT_PAID->caption() ?><?= $Page->AMOUNT_PAID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el_INVOICE_AMOUNT_PAID">
<input type="<?= $Page->AMOUNT_PAID->getInputTextType() ?>" data-table="INVOICE" data-field="x_AMOUNT_PAID" name="x_AMOUNT_PAID" id="x_AMOUNT_PAID" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT_PAID->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT_PAID->EditValue ?>"<?= $Page->AMOUNT_PAID->editAttributes() ?> aria-describedby="x_AMOUNT_PAID_help">
<?= $Page->AMOUNT_PAID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT_PAID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
    <div id="r_PAYMENT_INSTRUCTIONS" class="form-group row">
        <label id="elh_INVOICE_PAYMENT_INSTRUCTIONS" for="x_PAYMENT_INSTRUCTIONS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PAYMENT_INSTRUCTIONS->caption() ?><?= $Page->PAYMENT_INSTRUCTIONS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PAYMENT_INSTRUCTIONS->cellAttributes() ?>>
<span id="el_INVOICE_PAYMENT_INSTRUCTIONS">
<input type="<?= $Page->PAYMENT_INSTRUCTIONS->getInputTextType() ?>" data-table="INVOICE" data-field="x_PAYMENT_INSTRUCTIONS" name="x_PAYMENT_INSTRUCTIONS" id="x_PAYMENT_INSTRUCTIONS" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->PAYMENT_INSTRUCTIONS->getPlaceHolder()) ?>" value="<?= $Page->PAYMENT_INSTRUCTIONS->EditValue ?>"<?= $Page->PAYMENT_INSTRUCTIONS->editAttributes() ?> aria-describedby="x_PAYMENT_INSTRUCTIONS_help">
<?= $Page->PAYMENT_INSTRUCTIONS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PAYMENT_INSTRUCTIONS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
    <div id="r_ISAPPROVED" class="form-group row">
        <label id="elh_INVOICE_ISAPPROVED" for="x_ISAPPROVED" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISAPPROVED->caption() ?><?= $Page->ISAPPROVED->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISAPPROVED->cellAttributes() ?>>
<span id="el_INVOICE_ISAPPROVED">
<input type="<?= $Page->ISAPPROVED->getInputTextType() ?>" data-table="INVOICE" data-field="x_ISAPPROVED" name="x_ISAPPROVED" id="x_ISAPPROVED" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISAPPROVED->getPlaceHolder()) ?>" value="<?= $Page->ISAPPROVED->EditValue ?>"<?= $Page->ISAPPROVED->editAttributes() ?> aria-describedby="x_ISAPPROVED_help">
<?= $Page->ISAPPROVED->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISAPPROVED->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
    <div id="r_APPROVED_BY" class="form-group row">
        <label id="elh_INVOICE_APPROVED_BY" for="x_APPROVED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_BY->caption() ?><?= $Page->APPROVED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_BY->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_BY">
<input type="<?= $Page->APPROVED_BY->getInputTextType() ?>" data-table="INVOICE" data-field="x_APPROVED_BY" name="x_APPROVED_BY" id="x_APPROVED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->APPROVED_BY->getPlaceHolder()) ?>" value="<?= $Page->APPROVED_BY->EditValue ?>"<?= $Page->APPROVED_BY->editAttributes() ?> aria-describedby="x_APPROVED_BY_help">
<?= $Page->APPROVED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
    <div id="r_APPROVED_DATE" class="form-group row">
        <label id="elh_INVOICE_APPROVED_DATE" for="x_APPROVED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_DATE->caption() ?><?= $Page->APPROVED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_DATE->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_DATE">
<input type="<?= $Page->APPROVED_DATE->getInputTextType() ?>" data-table="INVOICE" data-field="x_APPROVED_DATE" name="x_APPROVED_DATE" id="x_APPROVED_DATE" placeholder="<?= HtmlEncode($Page->APPROVED_DATE->getPlaceHolder()) ?>" value="<?= $Page->APPROVED_DATE->EditValue ?>"<?= $Page->APPROVED_DATE->editAttributes() ?> aria-describedby="x_APPROVED_DATE_help">
<?= $Page->APPROVED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->APPROVED_DATE->ReadOnly && !$Page->APPROVED_DATE->Disabled && !isset($Page->APPROVED_DATE->EditAttrs["readonly"]) && !isset($Page->APPROVED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_APPROVED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_INVOICE_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_INVOICE_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="INVOICE" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label id="elh_INVOICE_PRINTQ" for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?><?= $Page->PRINTQ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_INVOICE_PRINTQ">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="INVOICE" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?> aria-describedby="x_PRINTQ_help">
<?= $Page->PRINTQ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label id="elh_INVOICE_PRINT_DATE" for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?><?= $Page->PRINT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_INVOICE_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="INVOICE" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?> aria-describedby="x_PRINT_DATE_help">
<?= $Page->PRINT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <div id="r_PRINTED_BY" class="form-group row">
        <label id="elh_INVOICE_PRINTED_BY" for="x_PRINTED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTED_BY->caption() ?><?= $Page->PRINTED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_INVOICE_PRINTED_BY">
<input type="<?= $Page->PRINTED_BY->getInputTextType() ?>" data-table="INVOICE" data-field="x_PRINTED_BY" name="x_PRINTED_BY" id="x_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Page->PRINTED_BY->EditValue ?>"<?= $Page->PRINTED_BY->editAttributes() ?> aria-describedby="x_PRINTED_BY_help">
<?= $Page->PRINTED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_INVOICE_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_INVOICE_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="INVOICE" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fINVOICEedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fINVOICEedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_INVOICE_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_INVOICE_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="INVOICE" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
    <div id="r_PPTK_TITLE" class="form-group row">
        <label id="elh_INVOICE_PPTK_TITLE" for="x_PPTK_TITLE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPTK_TITLE->caption() ?><?= $Page->PPTK_TITLE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPTK_TITLE->cellAttributes() ?>>
<span id="el_INVOICE_PPTK_TITLE">
<input type="<?= $Page->PPTK_TITLE->getInputTextType() ?>" data-table="INVOICE" data-field="x_PPTK_TITLE" name="x_PPTK_TITLE" id="x_PPTK_TITLE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PPTK_TITLE->getPlaceHolder()) ?>" value="<?= $Page->PPTK_TITLE->EditValue ?>"<?= $Page->PPTK_TITLE->editAttributes() ?> aria-describedby="x_PPTK_TITLE_help">
<?= $Page->PPTK_TITLE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPTK_TITLE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
    <div id="r_APPROVED_ID" class="form-group row">
        <label id="elh_INVOICE_APPROVED_ID" for="x_APPROVED_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_ID->caption() ?><?= $Page->APPROVED_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_ID->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_ID">
<input type="<?= $Page->APPROVED_ID->getInputTextType() ?>" data-table="INVOICE" data-field="x_APPROVED_ID" name="x_APPROVED_ID" id="x_APPROVED_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->APPROVED_ID->getPlaceHolder()) ?>" value="<?= $Page->APPROVED_ID->EditValue ?>"<?= $Page->APPROVED_ID->editAttributes() ?> aria-describedby="x_APPROVED_ID_help">
<?= $Page->APPROVED_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVED_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
    <div id="r_APPROVED_TITLE" class="form-group row">
        <label id="elh_INVOICE_APPROVED_TITLE" for="x_APPROVED_TITLE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->APPROVED_TITLE->caption() ?><?= $Page->APPROVED_TITLE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->APPROVED_TITLE->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_TITLE">
<input type="<?= $Page->APPROVED_TITLE->getInputTextType() ?>" data-table="INVOICE" data-field="x_APPROVED_TITLE" name="x_APPROVED_TITLE" id="x_APPROVED_TITLE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->APPROVED_TITLE->getPlaceHolder()) ?>" value="<?= $Page->APPROVED_TITLE->EditValue ?>"<?= $Page->APPROVED_TITLE->editAttributes() ?> aria-describedby="x_APPROVED_TITLE_help">
<?= $Page->APPROVED_TITLE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->APPROVED_TITLE->getErrorMessage() ?></div>
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
    ew.addEventHandlers("INVOICE");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
