<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$PoInvoiceitemEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_INVOICEITEMedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fPO_INVOICEITEMedit = currentForm = new ew.Form("fPO_INVOICEITEMedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "PO_INVOICEITEM")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.PO_INVOICEITEM)
        ew.vars.tables.PO_INVOICEITEM = currentTable;
    fPO_INVOICEITEMedit.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["ITEM_ID", [fields.ITEM_ID.visible && fields.ITEM_ID.required ? ew.Validators.required(fields.ITEM_ID.caption) : null], fields.ITEM_ID.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["BRAND_NAME", [fields.BRAND_NAME.visible && fields.BRAND_NAME.required ? ew.Validators.required(fields.BRAND_NAME.caption) : null], fields.BRAND_NAME.isInvalid],
        ["ORDER_DATE", [fields.ORDER_DATE.visible && fields.ORDER_DATE.required ? ew.Validators.required(fields.ORDER_DATE.caption) : null, ew.Validators.datetime(11)], fields.ORDER_DATE.isInvalid],
        ["ATP_DATE", [fields.ATP_DATE.visible && fields.ATP_DATE.required ? ew.Validators.required(fields.ATP_DATE.caption) : null, ew.Validators.datetime(11)], fields.ATP_DATE.isInvalid],
        ["DELIVERY_DATE", [fields.DELIVERY_DATE.visible && fields.DELIVERY_DATE.required ? ew.Validators.required(fields.DELIVERY_DATE.caption) : null, ew.Validators.datetime(111)], fields.DELIVERY_DATE.isInvalid],
        ["PO", [fields.PO.visible && fields.PO.required ? ew.Validators.required(fields.PO.caption) : null], fields.PO.isInvalid],
        ["UNIT_PRICE", [fields.UNIT_PRICE.visible && fields.UNIT_PRICE.required ? ew.Validators.required(fields.UNIT_PRICE.caption) : null, ew.Validators.float], fields.UNIT_PRICE.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["ORDER_QUANTITY", [fields.ORDER_QUANTITY.visible && fields.ORDER_QUANTITY.required ? ew.Validators.required(fields.ORDER_QUANTITY.caption) : null, ew.Validators.float], fields.ORDER_QUANTITY.isInvalid],
        ["RECEIVED_QUANTITY", [fields.RECEIVED_QUANTITY.visible && fields.RECEIVED_QUANTITY.required ? ew.Validators.required(fields.RECEIVED_QUANTITY.caption) : null, ew.Validators.float], fields.RECEIVED_QUANTITY.isInvalid],
        ["DISCOUNT", [fields.DISCOUNT.visible && fields.DISCOUNT.required ? ew.Validators.required(fields.DISCOUNT.caption) : null, ew.Validators.float], fields.DISCOUNT.isInvalid],
        ["DISCOUNT2", [fields.DISCOUNT2.visible && fields.DISCOUNT2.required ? ew.Validators.required(fields.DISCOUNT2.caption) : null, ew.Validators.float], fields.DISCOUNT2.isInvalid],
        ["DISCOUNTOFF", [fields.DISCOUNTOFF.visible && fields.DISCOUNTOFF.required ? ew.Validators.required(fields.DISCOUNTOFF.caption) : null, ew.Validators.float], fields.DISCOUNTOFF.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["SIZE_GOODS", [fields.SIZE_GOODS.visible && fields.SIZE_GOODS.required ? ew.Validators.required(fields.SIZE_GOODS.caption) : null, ew.Validators.float], fields.SIZE_GOODS.isInvalid],
        ["MEASURE_DOSIS", [fields.MEASURE_DOSIS.visible && fields.MEASURE_DOSIS.required ? ew.Validators.required(fields.MEASURE_DOSIS.caption) : null, ew.Validators.integer], fields.MEASURE_DOSIS.isInvalid],
        ["AMOUNT_PAID", [fields.AMOUNT_PAID.visible && fields.AMOUNT_PAID.required ? ew.Validators.required(fields.AMOUNT_PAID.caption) : null, ew.Validators.float], fields.AMOUNT_PAID.isInvalid],
        ["ORDER_PRICE", [fields.ORDER_PRICE.visible && fields.ORDER_PRICE.required ? ew.Validators.required(fields.ORDER_PRICE.caption) : null, ew.Validators.float], fields.ORDER_PRICE.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID3", [fields.MEASURE_ID3.visible && fields.MEASURE_ID3.required ? ew.Validators.required(fields.MEASURE_ID3.caption) : null, ew.Validators.integer], fields.MEASURE_ID3.isInvalid],
        ["SIZE_KEMASAN", [fields.SIZE_KEMASAN.visible && fields.SIZE_KEMASAN.required ? ew.Validators.required(fields.SIZE_KEMASAN.caption) : null, ew.Validators.float], fields.SIZE_KEMASAN.isInvalid],
        ["MEASURE_ID2", [fields.MEASURE_ID2.visible && fields.MEASURE_ID2.required ? ew.Validators.required(fields.MEASURE_ID2.caption) : null, ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null, ew.Validators.datetime(0)], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["BATCH_NO", [fields.BATCH_NO.visible && fields.BATCH_NO.required ? ew.Validators.required(fields.BATCH_NO.caption) : null], fields.BATCH_NO.isInvalid],
        ["SERIAL_NB", [fields.SERIAL_NB.visible && fields.SERIAL_NB.required ? ew.Validators.required(fields.SERIAL_NB.caption) : null], fields.SERIAL_NB.isInvalid],
        ["EXPIRY_DATE", [fields.EXPIRY_DATE.visible && fields.EXPIRY_DATE.required ? ew.Validators.required(fields.EXPIRY_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXPIRY_DATE.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["MONTH_ID", [fields.MONTH_ID.visible && fields.MONTH_ID.required ? ew.Validators.required(fields.MONTH_ID.caption) : null, ew.Validators.integer], fields.MONTH_ID.isInvalid],
        ["YEAR_ID", [fields.YEAR_ID.visible && fields.YEAR_ID.required ? ew.Validators.required(fields.YEAR_ID.caption) : null, ew.Validators.integer], fields.YEAR_ID.isInvalid],
        ["IDX", [fields.IDX.visible && fields.IDX.required ? ew.Validators.required(fields.IDX.caption) : null], fields.IDX.isInvalid],
        ["CLINIC_ID", [fields.CLINIC_ID.visible && fields.CLINIC_ID.required ? ew.Validators.required(fields.CLINIC_ID.caption) : null], fields.CLINIC_ID.isInvalid],
        ["PPN", [fields.PPN.visible && fields.PPN.required ? ew.Validators.required(fields.PPN.caption) : null, ew.Validators.integer], fields.PPN.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fPO_INVOICEITEMedit,
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
    fPO_INVOICEITEMedit.validate = function () {
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
    fPO_INVOICEITEMedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fPO_INVOICEITEMedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fPO_INVOICEITEMedit");
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
<form name="fPO_INVOICEITEMedit" id="fPO_INVOICEITEMedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICEITEM">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <div id="r_ORG_UNIT_CODE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ORG_UNIT_CODE" for="x_ORG_UNIT_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_CODE->caption() ?><?= $Page->ORG_UNIT_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<input type="<?= $Page->ORG_UNIT_CODE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ORG_UNIT_CODE" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_CODE->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_CODE->EditValue ?>"<?= $Page->ORG_UNIT_CODE->editAttributes() ?> aria-describedby="x_ORG_UNIT_CODE_help">
<?= $Page->ORG_UNIT_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_CODE->getErrorMessage() ?></div>
<input type="hidden" data-table="PO_INVOICEITEM" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="o_ORG_UNIT_CODE" id="o_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->OldValue ?? $Page->ORG_UNIT_CODE->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
    <div id="r_ITEM_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ITEM_ID" for="x_ITEM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ITEM_ID->caption() ?><?= $Page->ITEM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ITEM_ID->cellAttributes() ?>>
<input type="<?= $Page->ITEM_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ITEM_ID" name="x_ITEM_ID" id="x_ITEM_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ITEM_ID->getPlaceHolder()) ?>" value="<?= $Page->ITEM_ID->EditValue ?>"<?= $Page->ITEM_ID->editAttributes() ?> aria-describedby="x_ITEM_ID_help">
<?= $Page->ITEM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ITEM_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="PO_INVOICEITEM" data-field="x_ITEM_ID" data-hidden="1" name="o_ITEM_ID" id="o_ITEM_ID" value="<?= HtmlEncode($Page->ITEM_ID->OldValue ?? $Page->ITEM_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_INVOICE_ID" for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?><?= $Page->INVOICE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_INVOICE_ID">
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?> aria-describedby="x_INVOICE_ID_help">
<?= $Page->INVOICE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_BRAND_ID" for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_ID->caption() ?><?= $Page->BRAND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_BRAND_ID">
<input type="<?= $Page->BRAND_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_BRAND_ID" name="x_BRAND_ID" id="x_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Page->BRAND_ID->EditValue ?>"<?= $Page->BRAND_ID->editAttributes() ?> aria-describedby="x_BRAND_ID_help">
<?= $Page->BRAND_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
    <div id="r_BRAND_NAME" class="form-group row">
        <label id="elh_PO_INVOICEITEM_BRAND_NAME" for="x_BRAND_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_NAME->caption() ?><?= $Page->BRAND_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_BRAND_NAME">
<input type="<?= $Page->BRAND_NAME->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_BRAND_NAME" name="x_BRAND_NAME" id="x_BRAND_NAME" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Page->BRAND_NAME->EditValue ?>"<?= $Page->BRAND_NAME->editAttributes() ?> aria-describedby="x_BRAND_NAME_help">
<?= $Page->BRAND_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BRAND_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
    <div id="r_ORDER_DATE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ORDER_DATE" for="x_ORDER_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_DATE->caption() ?><?= $Page->ORDER_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_ORDER_DATE">
<input type="<?= $Page->ORDER_DATE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ORDER_DATE" data-format="11" name="x_ORDER_DATE" id="x_ORDER_DATE" placeholder="<?= HtmlEncode($Page->ORDER_DATE->getPlaceHolder()) ?>" value="<?= $Page->ORDER_DATE->EditValue ?>"<?= $Page->ORDER_DATE->editAttributes() ?> aria-describedby="x_ORDER_DATE_help">
<?= $Page->ORDER_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ORDER_DATE->ReadOnly && !$Page->ORDER_DATE->Disabled && !isset($Page->ORDER_DATE->EditAttrs["readonly"]) && !isset($Page->ORDER_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEITEMedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEITEMedit", "x_ORDER_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
    <div id="r_ATP_DATE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ATP_DATE" for="x_ATP_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ATP_DATE->caption() ?><?= $Page->ATP_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ATP_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_ATP_DATE">
<input type="<?= $Page->ATP_DATE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ATP_DATE" data-format="11" name="x_ATP_DATE" id="x_ATP_DATE" placeholder="<?= HtmlEncode($Page->ATP_DATE->getPlaceHolder()) ?>" value="<?= $Page->ATP_DATE->EditValue ?>"<?= $Page->ATP_DATE->editAttributes() ?> aria-describedby="x_ATP_DATE_help">
<?= $Page->ATP_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ATP_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ATP_DATE->ReadOnly && !$Page->ATP_DATE->Disabled && !isset($Page->ATP_DATE->EditAttrs["readonly"]) && !isset($Page->ATP_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEITEMedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEITEMedit", "x_ATP_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
    <div id="r_DELIVERY_DATE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_DELIVERY_DATE" for="x_DELIVERY_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DELIVERY_DATE->caption() ?><?= $Page->DELIVERY_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DELIVERY_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_DELIVERY_DATE">
<input type="<?= $Page->DELIVERY_DATE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_DELIVERY_DATE" data-format="111" name="x_DELIVERY_DATE" id="x_DELIVERY_DATE" placeholder="<?= HtmlEncode($Page->DELIVERY_DATE->getPlaceHolder()) ?>" value="<?= $Page->DELIVERY_DATE->EditValue ?>"<?= $Page->DELIVERY_DATE->editAttributes() ?> aria-describedby="x_DELIVERY_DATE_help">
<?= $Page->DELIVERY_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DELIVERY_DATE->getErrorMessage() ?></div>
<?php if (!$Page->DELIVERY_DATE->ReadOnly && !$Page->DELIVERY_DATE->Disabled && !isset($Page->DELIVERY_DATE->EditAttrs["readonly"]) && !isset($Page->DELIVERY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEITEMedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEITEMedit", "x_DELIVERY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":111});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <div id="r_PO" class="form-group row">
        <label id="elh_PO_INVOICEITEM_PO" for="x_PO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO->caption() ?><?= $Page->PO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_PO">
<input type="<?= $Page->PO->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_PO" name="x_PO" id="x_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PO->getPlaceHolder()) ?>" value="<?= $Page->PO->EditValue ?>"<?= $Page->PO->editAttributes() ?> aria-describedby="x_PO_help">
<?= $Page->PO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UNIT_PRICE->Visible) { // UNIT_PRICE ?>
    <div id="r_UNIT_PRICE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_UNIT_PRICE" for="x_UNIT_PRICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UNIT_PRICE->caption() ?><?= $Page->UNIT_PRICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->UNIT_PRICE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_UNIT_PRICE">
<input type="<?= $Page->UNIT_PRICE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_UNIT_PRICE" name="x_UNIT_PRICE" id="x_UNIT_PRICE" size="30" placeholder="<?= HtmlEncode($Page->UNIT_PRICE->getPlaceHolder()) ?>" value="<?= $Page->UNIT_PRICE->EditValue ?>"<?= $Page->UNIT_PRICE->editAttributes() ?> aria-describedby="x_UNIT_PRICE_help">
<?= $Page->UNIT_PRICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UNIT_PRICE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <div id="r_COMPANY_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_COMPANY_ID" for="x_COMPANY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?><?= $Page->COMPANY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_COMPANY_ID">
<input type="<?= $Page->COMPANY_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_COMPANY_ID" name="x_COMPANY_ID" id="x_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ID->EditValue ?>"<?= $Page->COMPANY_ID->editAttributes() ?> aria-describedby="x_COMPANY_ID_help">
<?= $Page->COMPANY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
    <div id="r_ORDER_QUANTITY" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ORDER_QUANTITY" for="x_ORDER_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_QUANTITY->caption() ?><?= $Page->ORDER_QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_QUANTITY->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_ORDER_QUANTITY">
<input type="<?= $Page->ORDER_QUANTITY->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ORDER_QUANTITY" name="x_ORDER_QUANTITY" id="x_ORDER_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->ORDER_QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->ORDER_QUANTITY->EditValue ?>"<?= $Page->ORDER_QUANTITY->editAttributes() ?> aria-describedby="x_ORDER_QUANTITY_help">
<?= $Page->ORDER_QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
    <div id="r_RECEIVED_QUANTITY" class="form-group row">
        <label id="elh_PO_INVOICEITEM_RECEIVED_QUANTITY" for="x_RECEIVED_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RECEIVED_QUANTITY->caption() ?><?= $Page->RECEIVED_QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RECEIVED_QUANTITY->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_RECEIVED_QUANTITY">
<input type="<?= $Page->RECEIVED_QUANTITY->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_RECEIVED_QUANTITY" name="x_RECEIVED_QUANTITY" id="x_RECEIVED_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->RECEIVED_QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->RECEIVED_QUANTITY->EditValue ?>"<?= $Page->RECEIVED_QUANTITY->editAttributes() ?> aria-describedby="x_RECEIVED_QUANTITY_help">
<?= $Page->RECEIVED_QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RECEIVED_QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <div id="r_DISCOUNT" class="form-group row">
        <label id="elh_PO_INVOICEITEM_DISCOUNT" for="x_DISCOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT->caption() ?><?= $Page->DISCOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_DISCOUNT">
<input type="<?= $Page->DISCOUNT->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_DISCOUNT" name="x_DISCOUNT" id="x_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT->EditValue ?>"<?= $Page->DISCOUNT->editAttributes() ?> aria-describedby="x_DISCOUNT_help">
<?= $Page->DISCOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
    <div id="r_DISCOUNT2" class="form-group row">
        <label id="elh_PO_INVOICEITEM_DISCOUNT2" for="x_DISCOUNT2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT2->caption() ?><?= $Page->DISCOUNT2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_DISCOUNT2">
<input type="<?= $Page->DISCOUNT2->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_DISCOUNT2" name="x_DISCOUNT2" id="x_DISCOUNT2" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT2->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT2->EditValue ?>"<?= $Page->DISCOUNT2->editAttributes() ?> aria-describedby="x_DISCOUNT2_help">
<?= $Page->DISCOUNT2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
    <div id="r_DISCOUNTOFF" class="form-group row">
        <label id="elh_PO_INVOICEITEM_DISCOUNTOFF" for="x_DISCOUNTOFF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNTOFF->caption() ?><?= $Page->DISCOUNTOFF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_DISCOUNTOFF">
<input type="<?= $Page->DISCOUNTOFF->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_DISCOUNTOFF" name="x_DISCOUNTOFF" id="x_DISCOUNTOFF" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNTOFF->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNTOFF->EditValue ?>"<?= $Page->DISCOUNTOFF->editAttributes() ?> aria-describedby="x_DISCOUNTOFF_help">
<?= $Page->DISCOUNTOFF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNTOFF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <div id="r_MEASURE_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_MEASURE_ID" for="x_MEASURE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID->caption() ?><?= $Page->MEASURE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_MEASURE_ID">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_MEASURE_ID" name="x_MEASURE_ID" id="x_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?> aria-describedby="x_MEASURE_ID_help">
<?= $Page->MEASURE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
    <div id="r_SIZE_GOODS" class="form-group row">
        <label id="elh_PO_INVOICEITEM_SIZE_GOODS" for="x_SIZE_GOODS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_GOODS->caption() ?><?= $Page->SIZE_GOODS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_SIZE_GOODS">
<input type="<?= $Page->SIZE_GOODS->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_SIZE_GOODS" name="x_SIZE_GOODS" id="x_SIZE_GOODS" size="30" placeholder="<?= HtmlEncode($Page->SIZE_GOODS->getPlaceHolder()) ?>" value="<?= $Page->SIZE_GOODS->EditValue ?>"<?= $Page->SIZE_GOODS->editAttributes() ?> aria-describedby="x_SIZE_GOODS_help">
<?= $Page->SIZE_GOODS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_GOODS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
    <div id="r_MEASURE_DOSIS" class="form-group row">
        <label id="elh_PO_INVOICEITEM_MEASURE_DOSIS" for="x_MEASURE_DOSIS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_DOSIS->caption() ?><?= $Page->MEASURE_DOSIS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_MEASURE_DOSIS">
<input type="<?= $Page->MEASURE_DOSIS->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_MEASURE_DOSIS" name="x_MEASURE_DOSIS" id="x_MEASURE_DOSIS" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_DOSIS->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_DOSIS->EditValue ?>"<?= $Page->MEASURE_DOSIS->editAttributes() ?> aria-describedby="x_MEASURE_DOSIS_help">
<?= $Page->MEASURE_DOSIS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_DOSIS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
    <div id="r_AMOUNT_PAID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_AMOUNT_PAID" for="x_AMOUNT_PAID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AMOUNT_PAID->caption() ?><?= $Page->AMOUNT_PAID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_AMOUNT_PAID">
<input type="<?= $Page->AMOUNT_PAID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_AMOUNT_PAID" name="x_AMOUNT_PAID" id="x_AMOUNT_PAID" size="30" placeholder="<?= HtmlEncode($Page->AMOUNT_PAID->getPlaceHolder()) ?>" value="<?= $Page->AMOUNT_PAID->EditValue ?>"<?= $Page->AMOUNT_PAID->editAttributes() ?> aria-describedby="x_AMOUNT_PAID_help">
<?= $Page->AMOUNT_PAID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AMOUNT_PAID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
    <div id="r_ORDER_PRICE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ORDER_PRICE" for="x_ORDER_PRICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_PRICE->caption() ?><?= $Page->ORDER_PRICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_ORDER_PRICE">
<input type="<?= $Page->ORDER_PRICE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ORDER_PRICE" name="x_ORDER_PRICE" id="x_ORDER_PRICE" size="30" placeholder="<?= HtmlEncode($Page->ORDER_PRICE->getPlaceHolder()) ?>" value="<?= $Page->ORDER_PRICE->EditValue ?>"<?= $Page->ORDER_PRICE->editAttributes() ?> aria-describedby="x_ORDER_PRICE_help">
<?= $Page->ORDER_PRICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_PRICE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <div id="r_QUANTITY" class="form-group row">
        <label id="elh_PO_INVOICEITEM_QUANTITY" for="x_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->QUANTITY->caption() ?><?= $Page->QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_QUANTITY">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_QUANTITY" name="x_QUANTITY" id="x_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?> aria-describedby="x_QUANTITY_help">
<?= $Page->QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
    <div id="r_MEASURE_ID3" class="form-group row">
        <label id="elh_PO_INVOICEITEM_MEASURE_ID3" for="x_MEASURE_ID3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID3->caption() ?><?= $Page->MEASURE_ID3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_MEASURE_ID3">
<input type="<?= $Page->MEASURE_ID3->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_MEASURE_ID3" name="x_MEASURE_ID3" id="x_MEASURE_ID3" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID3->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID3->EditValue ?>"<?= $Page->MEASURE_ID3->editAttributes() ?> aria-describedby="x_MEASURE_ID3_help">
<?= $Page->MEASURE_ID3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
    <div id="r_SIZE_KEMASAN" class="form-group row">
        <label id="elh_PO_INVOICEITEM_SIZE_KEMASAN" for="x_SIZE_KEMASAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_KEMASAN->caption() ?><?= $Page->SIZE_KEMASAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_SIZE_KEMASAN">
<input type="<?= $Page->SIZE_KEMASAN->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_SIZE_KEMASAN" name="x_SIZE_KEMASAN" id="x_SIZE_KEMASAN" size="30" placeholder="<?= HtmlEncode($Page->SIZE_KEMASAN->getPlaceHolder()) ?>" value="<?= $Page->SIZE_KEMASAN->EditValue ?>"<?= $Page->SIZE_KEMASAN->editAttributes() ?> aria-describedby="x_SIZE_KEMASAN_help">
<?= $Page->SIZE_KEMASAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_KEMASAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <div id="r_MEASURE_ID2" class="form-group row">
        <label id="elh_PO_INVOICEITEM_MEASURE_ID2" for="x_MEASURE_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID2->caption() ?><?= $Page->MEASURE_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_MEASURE_ID2">
<input type="<?= $Page->MEASURE_ID2->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_MEASURE_ID2" name="x_MEASURE_ID2" id="x_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID2->EditValue ?>"<?= $Page->MEASURE_ID2->editAttributes() ?> aria-describedby="x_MEASURE_ID2_help">
<?= $Page->MEASURE_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_PO_INVOICEITEM_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_PO_INVOICEITEM_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <div id="r_PRINT_DATE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_PRINT_DATE" for="x_PRINT_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINT_DATE->caption() ?><?= $Page->PRINT_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_PRINT_DATE">
<input type="<?= $Page->PRINT_DATE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_PRINT_DATE" name="x_PRINT_DATE" id="x_PRINT_DATE" placeholder="<?= HtmlEncode($Page->PRINT_DATE->getPlaceHolder()) ?>" value="<?= $Page->PRINT_DATE->EditValue ?>"<?= $Page->PRINT_DATE->editAttributes() ?> aria-describedby="x_PRINT_DATE_help">
<?= $Page->PRINT_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINT_DATE->getErrorMessage() ?></div>
<?php if (!$Page->PRINT_DATE->ReadOnly && !$Page->PRINT_DATE->Disabled && !isset($Page->PRINT_DATE->EditAttrs["readonly"]) && !isset($Page->PRINT_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEITEMedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEITEMedit", "x_PRINT_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <div id="r_PRINTED_BY" class="form-group row">
        <label id="elh_PO_INVOICEITEM_PRINTED_BY" for="x_PRINTED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTED_BY->caption() ?><?= $Page->PRINTED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_PRINTED_BY">
<input type="<?= $Page->PRINTED_BY->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_PRINTED_BY" name="x_PRINTED_BY" id="x_PRINTED_BY" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PRINTED_BY->getPlaceHolder()) ?>" value="<?= $Page->PRINTED_BY->EditValue ?>"<?= $Page->PRINTED_BY->editAttributes() ?> aria-describedby="x_PRINTED_BY_help">
<?= $Page->PRINTED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label id="elh_PO_INVOICEITEM_PRINTQ" for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?><?= $Page->PRINTQ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_PRINTQ">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?> aria-describedby="x_PRINTQ_help">
<?= $Page->PRINTQ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
    <div id="r_BATCH_NO" class="form-group row">
        <label id="elh_PO_INVOICEITEM_BATCH_NO" for="x_BATCH_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BATCH_NO->caption() ?><?= $Page->BATCH_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_BATCH_NO">
<input type="<?= $Page->BATCH_NO->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_BATCH_NO" name="x_BATCH_NO" id="x_BATCH_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Page->BATCH_NO->getPlaceHolder()) ?>" value="<?= $Page->BATCH_NO->EditValue ?>"<?= $Page->BATCH_NO->editAttributes() ?> aria-describedby="x_BATCH_NO_help">
<?= $Page->BATCH_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BATCH_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
    <div id="r_SERIAL_NB" class="form-group row">
        <label id="elh_PO_INVOICEITEM_SERIAL_NB" for="x_SERIAL_NB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SERIAL_NB->caption() ?><?= $Page->SERIAL_NB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_SERIAL_NB">
<input type="<?= $Page->SERIAL_NB->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_SERIAL_NB" name="x_SERIAL_NB" id="x_SERIAL_NB" size="30" maxlength="75" placeholder="<?= HtmlEncode($Page->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Page->SERIAL_NB->EditValue ?>"<?= $Page->SERIAL_NB->editAttributes() ?> aria-describedby="x_SERIAL_NB_help">
<?= $Page->SERIAL_NB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SERIAL_NB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
    <div id="r_EXPIRY_DATE" class="form-group row">
        <label id="elh_PO_INVOICEITEM_EXPIRY_DATE" for="x_EXPIRY_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EXPIRY_DATE->caption() ?><?= $Page->EXPIRY_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_EXPIRY_DATE">
<input type="<?= $Page->EXPIRY_DATE->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_EXPIRY_DATE" name="x_EXPIRY_DATE" id="x_EXPIRY_DATE" placeholder="<?= HtmlEncode($Page->EXPIRY_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXPIRY_DATE->EditValue ?>"<?= $Page->EXPIRY_DATE->editAttributes() ?> aria-describedby="x_EXPIRY_DATE_help">
<?= $Page->EXPIRY_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EXPIRY_DATE->getErrorMessage() ?></div>
<?php if (!$Page->EXPIRY_DATE->ReadOnly && !$Page->EXPIRY_DATE->Disabled && !isset($Page->EXPIRY_DATE->EditAttrs["readonly"]) && !isset($Page->EXPIRY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fPO_INVOICEITEMedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fPO_INVOICEITEMedit", "x_EXPIRY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_STATUS_PASIEN_ID" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
    <div id="r_MONTH_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_MONTH_ID" for="x_MONTH_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MONTH_ID->caption() ?><?= $Page->MONTH_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_MONTH_ID">
<input type="<?= $Page->MONTH_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_MONTH_ID" name="x_MONTH_ID" id="x_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Page->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Page->MONTH_ID->EditValue ?>"<?= $Page->MONTH_ID->editAttributes() ?> aria-describedby="x_MONTH_ID_help">
<?= $Page->MONTH_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MONTH_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <div id="r_YEAR_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_YEAR_ID" for="x_YEAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->YEAR_ID->caption() ?><?= $Page->YEAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_YEAR_ID">
<input type="<?= $Page->YEAR_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_YEAR_ID" name="x_YEAR_ID" id="x_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Page->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Page->YEAR_ID->EditValue ?>"<?= $Page->YEAR_ID->editAttributes() ?> aria-describedby="x_YEAR_ID_help">
<?= $Page->YEAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->YEAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
    <div id="r_IDX" class="form-group row">
        <label id="elh_PO_INVOICEITEM_IDX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IDX->caption() ?><?= $Page->IDX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->IDX->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_IDX">
<input type="<?= $Page->IDX->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_IDX" name="x_IDX" id="x_IDX" placeholder="<?= HtmlEncode($Page->IDX->getPlaceHolder()) ?>" value="<?= $Page->IDX->EditValue ?>"<?= $Page->IDX->editAttributes() ?> aria-describedby="x_IDX_help">
<?= $Page->IDX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IDX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <div id="r_CLINIC_ID" class="form-group row">
        <label id="elh_PO_INVOICEITEM_CLINIC_ID" for="x_CLINIC_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CLINIC_ID->caption() ?><?= $Page->CLINIC_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_CLINIC_ID">
<input type="<?= $Page->CLINIC_ID->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_CLINIC_ID" name="x_CLINIC_ID" id="x_CLINIC_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CLINIC_ID->getPlaceHolder()) ?>" value="<?= $Page->CLINIC_ID->EditValue ?>"<?= $Page->CLINIC_ID->editAttributes() ?> aria-describedby="x_CLINIC_ID_help">
<?= $Page->CLINIC_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CLINIC_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
    <div id="r_PPN" class="form-group row">
        <label id="elh_PO_INVOICEITEM_PPN" for="x_PPN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PPN->caption() ?><?= $Page->PPN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PPN->cellAttributes() ?>>
<span id="el_PO_INVOICEITEM_PPN">
<input type="<?= $Page->PPN->getInputTextType() ?>" data-table="PO_INVOICEITEM" data-field="x_PPN" name="x_PPN" id="x_PPN" size="30" placeholder="<?= HtmlEncode($Page->PPN->getPlaceHolder()) ?>" value="<?= $Page->PPN->EditValue ?>"<?= $Page->PPN->editAttributes() ?> aria-describedby="x_PPN_help">
<?= $Page->PPN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PPN->getErrorMessage() ?></div>
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
    ew.addEventHandlers("PO_INVOICEITEM");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
