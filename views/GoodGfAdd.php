<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodGfAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOOD_GFadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fGOOD_GFadd = currentForm = new ew.Form("fGOOD_GFadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOOD_GF")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOOD_GF)
        ew.vars.tables.GOOD_GF = currentTable;
    fGOOD_GFadd.addFields([
        ["ORG_UNIT_CODE", [fields.ORG_UNIT_CODE.visible && fields.ORG_UNIT_CODE.required ? ew.Validators.required(fields.ORG_UNIT_CODE.caption) : null], fields.ORG_UNIT_CODE.isInvalid],
        ["ORG_ID", [fields.ORG_ID.visible && fields.ORG_ID.required ? ew.Validators.required(fields.ORG_ID.caption) : null], fields.ORG_ID.isInvalid],
        ["BATCH_NO", [fields.BATCH_NO.visible && fields.BATCH_NO.required ? ew.Validators.required(fields.BATCH_NO.caption) : null], fields.BATCH_NO.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["ROOMS_ID", [fields.ROOMS_ID.visible && fields.ROOMS_ID.required ? ew.Validators.required(fields.ROOMS_ID.caption) : null], fields.ROOMS_ID.isInvalid],
        ["SHELF_NO", [fields.SHELF_NO.visible && fields.SHELF_NO.required ? ew.Validators.required(fields.SHELF_NO.caption) : null, ew.Validators.integer], fields.SHELF_NO.isInvalid],
        ["EXPIRY_DATE", [fields.EXPIRY_DATE.visible && fields.EXPIRY_DATE.required ? ew.Validators.required(fields.EXPIRY_DATE.caption) : null, ew.Validators.datetime(0)], fields.EXPIRY_DATE.isInvalid],
        ["SERIAL_NB", [fields.SERIAL_NB.visible && fields.SERIAL_NB.required ? ew.Validators.required(fields.SERIAL_NB.caption) : null], fields.SERIAL_NB.isInvalid],
        ["FROM_ROOMS_ID", [fields.FROM_ROOMS_ID.visible && fields.FROM_ROOMS_ID.required ? ew.Validators.required(fields.FROM_ROOMS_ID.caption) : null], fields.FROM_ROOMS_ID.isInvalid],
        ["ISOUTLET", [fields.ISOUTLET.visible && fields.ISOUTLET.required ? ew.Validators.required(fields.ISOUTLET.caption) : null], fields.ISOUTLET.isInvalid],
        ["QUANTITY", [fields.QUANTITY.visible && fields.QUANTITY.required ? ew.Validators.required(fields.QUANTITY.caption) : null, ew.Validators.float], fields.QUANTITY.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["DISTRIBUTION_TYPE", [fields.DISTRIBUTION_TYPE.visible && fields.DISTRIBUTION_TYPE.required ? ew.Validators.required(fields.DISTRIBUTION_TYPE.caption) : null, ew.Validators.integer], fields.DISTRIBUTION_TYPE.isInvalid],
        ["CONDITION", [fields.CONDITION.visible && fields.CONDITION.required ? ew.Validators.required(fields.CONDITION.caption) : null, ew.Validators.integer], fields.CONDITION.isInvalid],
        ["ALLOCATED_DATE", [fields.ALLOCATED_DATE.visible && fields.ALLOCATED_DATE.required ? ew.Validators.required(fields.ALLOCATED_DATE.caption) : null, ew.Validators.datetime(0)], fields.ALLOCATED_DATE.isInvalid],
        ["STOCKOPNAME_DATE", [fields.STOCKOPNAME_DATE.visible && fields.STOCKOPNAME_DATE.required ? ew.Validators.required(fields.STOCKOPNAME_DATE.caption) : null, ew.Validators.datetime(0)], fields.STOCKOPNAME_DATE.isInvalid],
        ["INVOICE_ID", [fields.INVOICE_ID.visible && fields.INVOICE_ID.required ? ew.Validators.required(fields.INVOICE_ID.caption) : null], fields.INVOICE_ID.isInvalid],
        ["ALLOCATED_FROM", [fields.ALLOCATED_FROM.visible && fields.ALLOCATED_FROM.required ? ew.Validators.required(fields.ALLOCATED_FROM.caption) : null], fields.ALLOCATED_FROM.isInvalid],
        ["PRICE", [fields.PRICE.visible && fields.PRICE.required ? ew.Validators.required(fields.PRICE.caption) : null, ew.Validators.float], fields.PRICE.isInvalid],
        ["DISCOUNT", [fields.DISCOUNT.visible && fields.DISCOUNT.required ? ew.Validators.required(fields.DISCOUNT.caption) : null, ew.Validators.float], fields.DISCOUNT.isInvalid],
        ["DISCOUNT2", [fields.DISCOUNT2.visible && fields.DISCOUNT2.required ? ew.Validators.required(fields.DISCOUNT2.caption) : null, ew.Validators.float], fields.DISCOUNT2.isInvalid],
        ["DISCOUNTOFF", [fields.DISCOUNTOFF.visible && fields.DISCOUNTOFF.required ? ew.Validators.required(fields.DISCOUNTOFF.caption) : null, ew.Validators.float], fields.DISCOUNTOFF.isInvalid],
        ["ORG_UNIT_FROM", [fields.ORG_UNIT_FROM.visible && fields.ORG_UNIT_FROM.required ? ew.Validators.required(fields.ORG_UNIT_FROM.caption) : null], fields.ORG_UNIT_FROM.isInvalid],
        ["ITEM_ID_FROM", [fields.ITEM_ID_FROM.visible && fields.ITEM_ID_FROM.required ? ew.Validators.required(fields.ITEM_ID_FROM.caption) : null], fields.ITEM_ID_FROM.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["STOCK_OPNAME", [fields.STOCK_OPNAME.visible && fields.STOCK_OPNAME.required ? ew.Validators.required(fields.STOCK_OPNAME.caption) : null, ew.Validators.float], fields.STOCK_OPNAME.isInvalid],
        ["STOK_AWAL", [fields.STOK_AWAL.visible && fields.STOK_AWAL.required ? ew.Validators.required(fields.STOK_AWAL.caption) : null, ew.Validators.float], fields.STOK_AWAL.isInvalid],
        ["STOCK_LALU", [fields.STOCK_LALU.visible && fields.STOCK_LALU.required ? ew.Validators.required(fields.STOCK_LALU.caption) : null, ew.Validators.float], fields.STOCK_LALU.isInvalid],
        ["STOCK_KOREKSI", [fields.STOCK_KOREKSI.visible && fields.STOCK_KOREKSI.required ? ew.Validators.required(fields.STOCK_KOREKSI.caption) : null, ew.Validators.float], fields.STOCK_KOREKSI.isInvalid],
        ["DITERIMA", [fields.DITERIMA.visible && fields.DITERIMA.required ? ew.Validators.required(fields.DITERIMA.caption) : null, ew.Validators.float], fields.DITERIMA.isInvalid],
        ["DISTRIBUSI", [fields.DISTRIBUSI.visible && fields.DISTRIBUSI.required ? ew.Validators.required(fields.DISTRIBUSI.caption) : null, ew.Validators.float], fields.DISTRIBUSI.isInvalid],
        ["DIJUAL", [fields.DIJUAL.visible && fields.DIJUAL.required ? ew.Validators.required(fields.DIJUAL.caption) : null, ew.Validators.float], fields.DIJUAL.isInvalid],
        ["DIHAPUS", [fields.DIHAPUS.visible && fields.DIHAPUS.required ? ew.Validators.required(fields.DIHAPUS.caption) : null, ew.Validators.float], fields.DIHAPUS.isInvalid],
        ["DIMINTA", [fields.DIMINTA.visible && fields.DIMINTA.required ? ew.Validators.required(fields.DIMINTA.caption) : null, ew.Validators.float], fields.DIMINTA.isInvalid],
        ["DIRETUR", [fields.DIRETUR.visible && fields.DIRETUR.required ? ew.Validators.required(fields.DIRETUR.caption) : null, ew.Validators.float], fields.DIRETUR.isInvalid],
        ["PO", [fields.PO.visible && fields.PO.required ? ew.Validators.required(fields.PO.caption) : null], fields.PO.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["FUND_ID", [fields.FUND_ID.visible && fields.FUND_ID.required ? ew.Validators.required(fields.FUND_ID.caption) : null, ew.Validators.integer], fields.FUND_ID.isInvalid],
        ["INVOICE_ID2", [fields.INVOICE_ID2.visible && fields.INVOICE_ID2.required ? ew.Validators.required(fields.INVOICE_ID2.caption) : null], fields.INVOICE_ID2.isInvalid],
        ["MEASURE_ID3", [fields.MEASURE_ID3.visible && fields.MEASURE_ID3.required ? ew.Validators.required(fields.MEASURE_ID3.caption) : null, ew.Validators.integer], fields.MEASURE_ID3.isInvalid],
        ["SIZE_KEMASAN", [fields.SIZE_KEMASAN.visible && fields.SIZE_KEMASAN.required ? ew.Validators.required(fields.SIZE_KEMASAN.caption) : null, ew.Validators.float], fields.SIZE_KEMASAN.isInvalid],
        ["BRAND_NAME", [fields.BRAND_NAME.visible && fields.BRAND_NAME.required ? ew.Validators.required(fields.BRAND_NAME.caption) : null], fields.BRAND_NAME.isInvalid],
        ["MEASURE_ID2", [fields.MEASURE_ID2.visible && fields.MEASURE_ID2.required ? ew.Validators.required(fields.MEASURE_ID2.caption) : null, ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["RETUR_ID", [fields.RETUR_ID.visible && fields.RETUR_ID.required ? ew.Validators.required(fields.RETUR_ID.caption) : null], fields.RETUR_ID.isInvalid],
        ["SIZE_GOODS", [fields.SIZE_GOODS.visible && fields.SIZE_GOODS.required ? ew.Validators.required(fields.SIZE_GOODS.caption) : null, ew.Validators.float], fields.SIZE_GOODS.isInvalid],
        ["MEASURE_DOSIS", [fields.MEASURE_DOSIS.visible && fields.MEASURE_DOSIS.required ? ew.Validators.required(fields.MEASURE_DOSIS.caption) : null, ew.Validators.integer], fields.MEASURE_DOSIS.isInvalid],
        ["ORDER_PRICE", [fields.ORDER_PRICE.visible && fields.ORDER_PRICE.required ? ew.Validators.required(fields.ORDER_PRICE.caption) : null, ew.Validators.float], fields.ORDER_PRICE.isInvalid],
        ["STOCK_AVAILABLE", [fields.STOCK_AVAILABLE.visible && fields.STOCK_AVAILABLE.required ? ew.Validators.required(fields.STOCK_AVAILABLE.caption) : null, ew.Validators.float], fields.STOCK_AVAILABLE.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["MONTH_ID", [fields.MONTH_ID.visible && fields.MONTH_ID.required ? ew.Validators.required(fields.MONTH_ID.caption) : null, ew.Validators.integer], fields.MONTH_ID.isInvalid],
        ["YEAR_ID", [fields.YEAR_ID.visible && fields.YEAR_ID.required ? ew.Validators.required(fields.YEAR_ID.caption) : null, ew.Validators.integer], fields.YEAR_ID.isInvalid],
        ["CORRECTION_DOC", [fields.CORRECTION_DOC.visible && fields.CORRECTION_DOC.required ? ew.Validators.required(fields.CORRECTION_DOC.caption) : null], fields.CORRECTION_DOC.isInvalid],
        ["CORRECTIONS", [fields.CORRECTIONS.visible && fields.CORRECTIONS.required ? ew.Validators.required(fields.CORRECTIONS.caption) : null], fields.CORRECTIONS.isInvalid],
        ["CORRECTION_DATE", [fields.CORRECTION_DATE.visible && fields.CORRECTION_DATE.required ? ew.Validators.required(fields.CORRECTION_DATE.caption) : null], fields.CORRECTION_DATE.isInvalid],
        ["DOC_NO", [fields.DOC_NO.visible && fields.DOC_NO.required ? ew.Validators.required(fields.DOC_NO.caption) : null], fields.DOC_NO.isInvalid],
        ["ORDER_ID", [fields.ORDER_ID.visible && fields.ORDER_ID.required ? ew.Validators.required(fields.ORDER_ID.caption) : null], fields.ORDER_ID.isInvalid],
        ["ISCETAK", [fields.ISCETAK.visible && fields.ISCETAK.required ? ew.Validators.required(fields.ISCETAK.caption) : null], fields.ISCETAK.isInvalid],
        ["PRINT_DATE", [fields.PRINT_DATE.visible && fields.PRINT_DATE.required ? ew.Validators.required(fields.PRINT_DATE.caption) : null], fields.PRINT_DATE.isInvalid],
        ["PRINTED_BY", [fields.PRINTED_BY.visible && fields.PRINTED_BY.required ? ew.Validators.required(fields.PRINTED_BY.caption) : null], fields.PRINTED_BY.isInvalid],
        ["PRINTQ", [fields.PRINTQ.visible && fields.PRINTQ.required ? ew.Validators.required(fields.PRINTQ.caption) : null, ew.Validators.integer], fields.PRINTQ.isInvalid],
        ["avgprice", [fields.avgprice.visible && fields.avgprice.required ? ew.Validators.required(fields.avgprice.caption) : null, ew.Validators.float], fields.avgprice.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOOD_GFadd,
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
    fGOOD_GFadd.validate = function () {
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
    fGOOD_GFadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOOD_GFadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fGOOD_GFadd.lists.BRAND_ID = <?= $Page->BRAND_ID->toClientList($Page) ?>;
    loadjs.done("fGOOD_GFadd");
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
<form name="fGOOD_GFadd" id="fGOOD_GFadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOOD_GF">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "MUTATION_DOCS") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="MUTATION_DOCS">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID_TO" value="<?= HtmlEncode($Page->ORG_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_CLINIC_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->getSessionValue()) ?>">
<input type="hidden" name="fk_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
    <span id="el_GOOD_GF_ORG_UNIT_CODE">
    <input type="hidden" data-table="GOOD_GF" data-field="x_ORG_UNIT_CODE" data-hidden="1" name="x_ORG_UNIT_CODE" id="x_ORG_UNIT_CODE" value="<?= HtmlEncode($Page->ORG_UNIT_CODE->CurrentValue) ?>">
    </span>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <div id="r_ORG_ID" class="form-group row">
        <label id="elh_GOOD_GF_ORG_ID" for="x_ORG_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_ID->caption() ?><?= $Page->ORG_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_ID->cellAttributes() ?>>
<?php if ($Page->ORG_ID->getSessionValue() != "") { ?>
<span id="el_GOOD_GF_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ORG_ID->getDisplayValue($Page->ORG_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_ORG_ID" name="x_ORG_ID" value="<?= HtmlEncode($Page->ORG_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_GOOD_GF_ORG_ID">
<input type="<?= $Page->ORG_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_ID" name="x_ORG_ID" id="x_ORG_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_ID->getPlaceHolder()) ?>" value="<?= $Page->ORG_ID->EditValue ?>"<?= $Page->ORG_ID->editAttributes() ?> aria-describedby="x_ORG_ID_help">
<?= $Page->ORG_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
    <div id="r_BATCH_NO" class="form-group row">
        <label id="elh_GOOD_GF_BATCH_NO" for="x_BATCH_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BATCH_NO->caption() ?><?= $Page->BATCH_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el_GOOD_GF_BATCH_NO">
<input type="<?= $Page->BATCH_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BATCH_NO" name="x_BATCH_NO" id="x_BATCH_NO" size="30" maxlength="75" placeholder="<?= HtmlEncode($Page->BATCH_NO->getPlaceHolder()) ?>" value="<?= $Page->BATCH_NO->EditValue ?>"<?= $Page->BATCH_NO->editAttributes() ?> aria-describedby="x_BATCH_NO_help">
<?= $Page->BATCH_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BATCH_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label id="elh_GOOD_GF_BRAND_ID" for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_ID->caption() ?><?= $Page->BRAND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_ID">
<?php $Page->BRAND_ID->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
<div class="input-group ew-lookup-list" aria-describedby="x_BRAND_ID_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_BRAND_ID"><?= EmptyValue(strval($Page->BRAND_ID->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->BRAND_ID->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->BRAND_ID->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->BRAND_ID->ReadOnly || $Page->BRAND_ID->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_BRAND_ID',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
<?= $Page->BRAND_ID->getCustomMessage() ?>
<?= $Page->BRAND_ID->Lookup->getParamTag($Page, "p_x_BRAND_ID") ?>
<input type="hidden" is="selection-list" data-table="GOOD_GF" data-field="x_BRAND_ID" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->BRAND_ID->displayValueSeparatorAttribute() ?>" name="x_BRAND_ID" id="x_BRAND_ID" value="<?= $Page->BRAND_ID->CurrentValue ?>"<?= $Page->BRAND_ID->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ROOMS_ID->Visible) { // ROOMS_ID ?>
    <div id="r_ROOMS_ID" class="form-group row">
        <label id="elh_GOOD_GF_ROOMS_ID" for="x_ROOMS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ROOMS_ID->caption() ?><?= $Page->ROOMS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ROOMS_ID->cellAttributes() ?>>
<?php if ($Page->ROOMS_ID->getSessionValue() != "") { ?>
<span id="el_GOOD_GF_ROOMS_ID">
<span<?= $Page->ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ROOMS_ID->getDisplayValue($Page->ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_ROOMS_ID" name="x_ROOMS_ID" value="<?= HtmlEncode($Page->ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_GOOD_GF_ROOMS_ID">
<input type="<?= $Page->ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ROOMS_ID" name="x_ROOMS_ID" id="x_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Page->ROOMS_ID->EditValue ?>"<?= $Page->ROOMS_ID->editAttributes() ?> aria-describedby="x_ROOMS_ID_help">
<?= $Page->ROOMS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SHELF_NO->Visible) { // SHELF_NO ?>
    <div id="r_SHELF_NO" class="form-group row">
        <label id="elh_GOOD_GF_SHELF_NO" for="x_SHELF_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SHELF_NO->caption() ?><?= $Page->SHELF_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SHELF_NO->cellAttributes() ?>>
<span id="el_GOOD_GF_SHELF_NO">
<input type="<?= $Page->SHELF_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SHELF_NO" name="x_SHELF_NO" id="x_SHELF_NO" size="30" placeholder="<?= HtmlEncode($Page->SHELF_NO->getPlaceHolder()) ?>" value="<?= $Page->SHELF_NO->EditValue ?>"<?= $Page->SHELF_NO->editAttributes() ?> aria-describedby="x_SHELF_NO_help">
<?= $Page->SHELF_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SHELF_NO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
    <div id="r_EXPIRY_DATE" class="form-group row">
        <label id="elh_GOOD_GF_EXPIRY_DATE" for="x_EXPIRY_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EXPIRY_DATE->caption() ?><?= $Page->EXPIRY_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_EXPIRY_DATE">
<input type="<?= $Page->EXPIRY_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_EXPIRY_DATE" name="x_EXPIRY_DATE" id="x_EXPIRY_DATE" placeholder="<?= HtmlEncode($Page->EXPIRY_DATE->getPlaceHolder()) ?>" value="<?= $Page->EXPIRY_DATE->EditValue ?>"<?= $Page->EXPIRY_DATE->editAttributes() ?> aria-describedby="x_EXPIRY_DATE_help">
<?= $Page->EXPIRY_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EXPIRY_DATE->getErrorMessage() ?></div>
<?php if (!$Page->EXPIRY_DATE->ReadOnly && !$Page->EXPIRY_DATE->Disabled && !isset($Page->EXPIRY_DATE->EditAttrs["readonly"]) && !isset($Page->EXPIRY_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFadd", "x_EXPIRY_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
    <div id="r_SERIAL_NB" class="form-group row">
        <label id="elh_GOOD_GF_SERIAL_NB" for="x_SERIAL_NB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SERIAL_NB->caption() ?><?= $Page->SERIAL_NB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el_GOOD_GF_SERIAL_NB">
<input type="<?= $Page->SERIAL_NB->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SERIAL_NB" name="x_SERIAL_NB" id="x_SERIAL_NB" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->SERIAL_NB->getPlaceHolder()) ?>" value="<?= $Page->SERIAL_NB->EditValue ?>"<?= $Page->SERIAL_NB->editAttributes() ?> aria-describedby="x_SERIAL_NB_help">
<?= $Page->SERIAL_NB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SERIAL_NB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FROM_ROOMS_ID->Visible) { // FROM_ROOMS_ID ?>
    <div id="r_FROM_ROOMS_ID" class="form-group row">
        <label id="elh_GOOD_GF_FROM_ROOMS_ID" for="x_FROM_ROOMS_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FROM_ROOMS_ID->caption() ?><?= $Page->FROM_ROOMS_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FROM_ROOMS_ID->cellAttributes() ?>>
<?php if ($Page->FROM_ROOMS_ID->getSessionValue() != "") { ?>
<span id="el_GOOD_GF_FROM_ROOMS_ID">
<span<?= $Page->FROM_ROOMS_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->FROM_ROOMS_ID->getDisplayValue($Page->FROM_ROOMS_ID->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_FROM_ROOMS_ID" name="x_FROM_ROOMS_ID" value="<?= HtmlEncode($Page->FROM_ROOMS_ID->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_GOOD_GF_FROM_ROOMS_ID">
<input type="<?= $Page->FROM_ROOMS_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FROM_ROOMS_ID" name="x_FROM_ROOMS_ID" id="x_FROM_ROOMS_ID" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->FROM_ROOMS_ID->getPlaceHolder()) ?>" value="<?= $Page->FROM_ROOMS_ID->EditValue ?>"<?= $Page->FROM_ROOMS_ID->editAttributes() ?> aria-describedby="x_FROM_ROOMS_ID_help">
<?= $Page->FROM_ROOMS_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FROM_ROOMS_ID->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISOUTLET->Visible) { // ISOUTLET ?>
    <div id="r_ISOUTLET" class="form-group row">
        <label id="elh_GOOD_GF_ISOUTLET" for="x_ISOUTLET" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISOUTLET->caption() ?><?= $Page->ISOUTLET->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISOUTLET->cellAttributes() ?>>
<span id="el_GOOD_GF_ISOUTLET">
<input type="<?= $Page->ISOUTLET->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISOUTLET" name="x_ISOUTLET" id="x_ISOUTLET" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISOUTLET->getPlaceHolder()) ?>" value="<?= $Page->ISOUTLET->EditValue ?>"<?= $Page->ISOUTLET->editAttributes() ?> aria-describedby="x_ISOUTLET_help">
<?= $Page->ISOUTLET->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISOUTLET->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
    <div id="r_QUANTITY" class="form-group row">
        <label id="elh_GOOD_GF_QUANTITY" for="x_QUANTITY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->QUANTITY->caption() ?><?= $Page->QUANTITY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el_GOOD_GF_QUANTITY">
<input type="<?= $Page->QUANTITY->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_QUANTITY" name="x_QUANTITY" id="x_QUANTITY" size="30" placeholder="<?= HtmlEncode($Page->QUANTITY->getPlaceHolder()) ?>" value="<?= $Page->QUANTITY->EditValue ?>"<?= $Page->QUANTITY->editAttributes() ?> aria-describedby="x_QUANTITY_help">
<?= $Page->QUANTITY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->QUANTITY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <div id="r_MEASURE_ID" class="form-group row">
        <label id="elh_GOOD_GF_MEASURE_ID" for="x_MEASURE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID->caption() ?><?= $Page->MEASURE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_ID">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID" name="x_MEASURE_ID" id="x_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?> aria-describedby="x_MEASURE_ID_help">
<?= $Page->MEASURE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISTRIBUTION_TYPE->Visible) { // DISTRIBUTION_TYPE ?>
    <div id="r_DISTRIBUTION_TYPE" class="form-group row">
        <label id="elh_GOOD_GF_DISTRIBUTION_TYPE" for="x_DISTRIBUTION_TYPE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISTRIBUTION_TYPE->caption() ?><?= $Page->DISTRIBUTION_TYPE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISTRIBUTION_TYPE->cellAttributes() ?>>
<span id="el_GOOD_GF_DISTRIBUTION_TYPE">
<input type="<?= $Page->DISTRIBUTION_TYPE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUTION_TYPE" name="x_DISTRIBUTION_TYPE" id="x_DISTRIBUTION_TYPE" size="30" placeholder="<?= HtmlEncode($Page->DISTRIBUTION_TYPE->getPlaceHolder()) ?>" value="<?= $Page->DISTRIBUTION_TYPE->EditValue ?>"<?= $Page->DISTRIBUTION_TYPE->editAttributes() ?> aria-describedby="x_DISTRIBUTION_TYPE_help">
<?= $Page->DISTRIBUTION_TYPE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISTRIBUTION_TYPE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONDITION->Visible) { // CONDITION ?>
    <div id="r_CONDITION" class="form-group row">
        <label id="elh_GOOD_GF_CONDITION" for="x_CONDITION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONDITION->caption() ?><?= $Page->CONDITION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONDITION->cellAttributes() ?>>
<span id="el_GOOD_GF_CONDITION">
<input type="<?= $Page->CONDITION->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CONDITION" name="x_CONDITION" id="x_CONDITION" size="30" placeholder="<?= HtmlEncode($Page->CONDITION->getPlaceHolder()) ?>" value="<?= $Page->CONDITION->EditValue ?>"<?= $Page->CONDITION->editAttributes() ?> aria-describedby="x_CONDITION_help">
<?= $Page->CONDITION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONDITION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ALLOCATED_DATE->Visible) { // ALLOCATED_DATE ?>
    <div id="r_ALLOCATED_DATE" class="form-group row">
        <label id="elh_GOOD_GF_ALLOCATED_DATE" for="x_ALLOCATED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ALLOCATED_DATE->caption() ?><?= $Page->ALLOCATED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ALLOCATED_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_DATE">
<input type="<?= $Page->ALLOCATED_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_DATE" name="x_ALLOCATED_DATE" id="x_ALLOCATED_DATE" placeholder="<?= HtmlEncode($Page->ALLOCATED_DATE->getPlaceHolder()) ?>" value="<?= $Page->ALLOCATED_DATE->EditValue ?>"<?= $Page->ALLOCATED_DATE->editAttributes() ?> aria-describedby="x_ALLOCATED_DATE_help">
<?= $Page->ALLOCATED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ALLOCATED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->ALLOCATED_DATE->ReadOnly && !$Page->ALLOCATED_DATE->Disabled && !isset($Page->ALLOCATED_DATE->EditAttrs["readonly"]) && !isset($Page->ALLOCATED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFadd", "x_ALLOCATED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCKOPNAME_DATE->Visible) { // STOCKOPNAME_DATE ?>
    <div id="r_STOCKOPNAME_DATE" class="form-group row">
        <label id="elh_GOOD_GF_STOCKOPNAME_DATE" for="x_STOCKOPNAME_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCKOPNAME_DATE->caption() ?><?= $Page->STOCKOPNAME_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCKOPNAME_DATE->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCKOPNAME_DATE">
<input type="<?= $Page->STOCKOPNAME_DATE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCKOPNAME_DATE" name="x_STOCKOPNAME_DATE" id="x_STOCKOPNAME_DATE" placeholder="<?= HtmlEncode($Page->STOCKOPNAME_DATE->getPlaceHolder()) ?>" value="<?= $Page->STOCKOPNAME_DATE->EditValue ?>"<?= $Page->STOCKOPNAME_DATE->editAttributes() ?> aria-describedby="x_STOCKOPNAME_DATE_help">
<?= $Page->STOCKOPNAME_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCKOPNAME_DATE->getErrorMessage() ?></div>
<?php if (!$Page->STOCKOPNAME_DATE->ReadOnly && !$Page->STOCKOPNAME_DATE->Disabled && !isset($Page->STOCKOPNAME_DATE->EditAttrs["readonly"]) && !isset($Page->STOCKOPNAME_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOOD_GFadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOOD_GFadd", "x_STOCKOPNAME_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <div id="r_INVOICE_ID" class="form-group row">
        <label id="elh_GOOD_GF_INVOICE_ID" for="x_INVOICE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID->caption() ?><?= $Page->INVOICE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_INVOICE_ID">
<input type="<?= $Page->INVOICE_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID" name="x_INVOICE_ID" id="x_INVOICE_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID->EditValue ?>"<?= $Page->INVOICE_ID->editAttributes() ?> aria-describedby="x_INVOICE_ID_help">
<?= $Page->INVOICE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ALLOCATED_FROM->Visible) { // ALLOCATED_FROM ?>
    <div id="r_ALLOCATED_FROM" class="form-group row">
        <label id="elh_GOOD_GF_ALLOCATED_FROM" for="x_ALLOCATED_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ALLOCATED_FROM->caption() ?><?= $Page->ALLOCATED_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ALLOCATED_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ALLOCATED_FROM">
<input type="<?= $Page->ALLOCATED_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ALLOCATED_FROM" name="x_ALLOCATED_FROM" id="x_ALLOCATED_FROM" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ALLOCATED_FROM->getPlaceHolder()) ?>" value="<?= $Page->ALLOCATED_FROM->EditValue ?>"<?= $Page->ALLOCATED_FROM->editAttributes() ?> aria-describedby="x_ALLOCATED_FROM_help">
<?= $Page->ALLOCATED_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ALLOCATED_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRICE->Visible) { // PRICE ?>
    <div id="r_PRICE" class="form-group row">
        <label id="elh_GOOD_GF_PRICE" for="x_PRICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRICE->caption() ?><?= $Page->PRICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRICE->cellAttributes() ?>>
<span id="el_GOOD_GF_PRICE">
<input type="<?= $Page->PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRICE" name="x_PRICE" id="x_PRICE" size="30" placeholder="<?= HtmlEncode($Page->PRICE->getPlaceHolder()) ?>" value="<?= $Page->PRICE->EditValue ?>"<?= $Page->PRICE->editAttributes() ?> aria-describedby="x_PRICE_help">
<?= $Page->PRICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRICE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
    <div id="r_DISCOUNT" class="form-group row">
        <label id="elh_GOOD_GF_DISCOUNT" for="x_DISCOUNT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT->caption() ?><?= $Page->DISCOUNT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el_GOOD_GF_DISCOUNT">
<input type="<?= $Page->DISCOUNT->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT" name="x_DISCOUNT" id="x_DISCOUNT" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT->EditValue ?>"<?= $Page->DISCOUNT->editAttributes() ?> aria-describedby="x_DISCOUNT_help">
<?= $Page->DISCOUNT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
    <div id="r_DISCOUNT2" class="form-group row">
        <label id="elh_GOOD_GF_DISCOUNT2" for="x_DISCOUNT2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNT2->caption() ?><?= $Page->DISCOUNT2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el_GOOD_GF_DISCOUNT2">
<input type="<?= $Page->DISCOUNT2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNT2" name="x_DISCOUNT2" id="x_DISCOUNT2" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNT2->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNT2->EditValue ?>"<?= $Page->DISCOUNT2->editAttributes() ?> aria-describedby="x_DISCOUNT2_help">
<?= $Page->DISCOUNT2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNT2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
    <div id="r_DISCOUNTOFF" class="form-group row">
        <label id="elh_GOOD_GF_DISCOUNTOFF" for="x_DISCOUNTOFF" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISCOUNTOFF->caption() ?><?= $Page->DISCOUNTOFF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el_GOOD_GF_DISCOUNTOFF">
<input type="<?= $Page->DISCOUNTOFF->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISCOUNTOFF" name="x_DISCOUNTOFF" id="x_DISCOUNTOFF" size="30" placeholder="<?= HtmlEncode($Page->DISCOUNTOFF->getPlaceHolder()) ?>" value="<?= $Page->DISCOUNTOFF->EditValue ?>"<?= $Page->DISCOUNTOFF->editAttributes() ?> aria-describedby="x_DISCOUNTOFF_help">
<?= $Page->DISCOUNTOFF->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISCOUNTOFF->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORG_UNIT_FROM->Visible) { // ORG_UNIT_FROM ?>
    <div id="r_ORG_UNIT_FROM" class="form-group row">
        <label id="elh_GOOD_GF_ORG_UNIT_FROM" for="x_ORG_UNIT_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORG_UNIT_FROM->caption() ?><?= $Page->ORG_UNIT_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORG_UNIT_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ORG_UNIT_FROM">
<input type="<?= $Page->ORG_UNIT_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORG_UNIT_FROM" name="x_ORG_UNIT_FROM" id="x_ORG_UNIT_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORG_UNIT_FROM->getPlaceHolder()) ?>" value="<?= $Page->ORG_UNIT_FROM->EditValue ?>"<?= $Page->ORG_UNIT_FROM->editAttributes() ?> aria-describedby="x_ORG_UNIT_FROM_help">
<?= $Page->ORG_UNIT_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORG_UNIT_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ITEM_ID_FROM->Visible) { // ITEM_ID_FROM ?>
    <div id="r_ITEM_ID_FROM" class="form-group row">
        <label id="elh_GOOD_GF_ITEM_ID_FROM" for="x_ITEM_ID_FROM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ITEM_ID_FROM->caption() ?><?= $Page->ITEM_ID_FROM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ITEM_ID_FROM->cellAttributes() ?>>
<span id="el_GOOD_GF_ITEM_ID_FROM">
<input type="<?= $Page->ITEM_ID_FROM->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ITEM_ID_FROM" name="x_ITEM_ID_FROM" id="x_ITEM_ID_FROM" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ITEM_ID_FROM->getPlaceHolder()) ?>" value="<?= $Page->ITEM_ID_FROM->EditValue ?>"<?= $Page->ITEM_ID_FROM->editAttributes() ?> aria-describedby="x_ITEM_ID_FROM_help">
<?= $Page->ITEM_ID_FROM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ITEM_ID_FROM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_OPNAME->Visible) { // STOCK_OPNAME ?>
    <div id="r_STOCK_OPNAME" class="form-group row">
        <label id="elh_GOOD_GF_STOCK_OPNAME" for="x_STOCK_OPNAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_OPNAME->caption() ?><?= $Page->STOCK_OPNAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_OPNAME->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_OPNAME">
<input type="<?= $Page->STOCK_OPNAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_OPNAME" name="x_STOCK_OPNAME" id="x_STOCK_OPNAME" size="30" placeholder="<?= HtmlEncode($Page->STOCK_OPNAME->getPlaceHolder()) ?>" value="<?= $Page->STOCK_OPNAME->EditValue ?>"<?= $Page->STOCK_OPNAME->editAttributes() ?> aria-describedby="x_STOCK_OPNAME_help">
<?= $Page->STOCK_OPNAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_OPNAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOK_AWAL->Visible) { // STOK_AWAL ?>
    <div id="r_STOK_AWAL" class="form-group row">
        <label id="elh_GOOD_GF_STOK_AWAL" for="x_STOK_AWAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOK_AWAL->caption() ?><?= $Page->STOK_AWAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOK_AWAL->cellAttributes() ?>>
<span id="el_GOOD_GF_STOK_AWAL">
<input type="<?= $Page->STOK_AWAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOK_AWAL" name="x_STOK_AWAL" id="x_STOK_AWAL" size="30" placeholder="<?= HtmlEncode($Page->STOK_AWAL->getPlaceHolder()) ?>" value="<?= $Page->STOK_AWAL->EditValue ?>"<?= $Page->STOK_AWAL->editAttributes() ?> aria-describedby="x_STOK_AWAL_help">
<?= $Page->STOK_AWAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOK_AWAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_LALU->Visible) { // STOCK_LALU ?>
    <div id="r_STOCK_LALU" class="form-group row">
        <label id="elh_GOOD_GF_STOCK_LALU" for="x_STOCK_LALU" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_LALU->caption() ?><?= $Page->STOCK_LALU->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_LALU->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_LALU">
<input type="<?= $Page->STOCK_LALU->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_LALU" name="x_STOCK_LALU" id="x_STOCK_LALU" size="30" placeholder="<?= HtmlEncode($Page->STOCK_LALU->getPlaceHolder()) ?>" value="<?= $Page->STOCK_LALU->EditValue ?>"<?= $Page->STOCK_LALU->editAttributes() ?> aria-describedby="x_STOCK_LALU_help">
<?= $Page->STOCK_LALU->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_LALU->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_KOREKSI->Visible) { // STOCK_KOREKSI ?>
    <div id="r_STOCK_KOREKSI" class="form-group row">
        <label id="elh_GOOD_GF_STOCK_KOREKSI" for="x_STOCK_KOREKSI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_KOREKSI->caption() ?><?= $Page->STOCK_KOREKSI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_KOREKSI->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_KOREKSI">
<input type="<?= $Page->STOCK_KOREKSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_KOREKSI" name="x_STOCK_KOREKSI" id="x_STOCK_KOREKSI" size="30" placeholder="<?= HtmlEncode($Page->STOCK_KOREKSI->getPlaceHolder()) ?>" value="<?= $Page->STOCK_KOREKSI->EditValue ?>"<?= $Page->STOCK_KOREKSI->editAttributes() ?> aria-describedby="x_STOCK_KOREKSI_help">
<?= $Page->STOCK_KOREKSI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_KOREKSI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DITERIMA->Visible) { // DITERIMA ?>
    <div id="r_DITERIMA" class="form-group row">
        <label id="elh_GOOD_GF_DITERIMA" for="x_DITERIMA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DITERIMA->caption() ?><?= $Page->DITERIMA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DITERIMA->cellAttributes() ?>>
<span id="el_GOOD_GF_DITERIMA">
<input type="<?= $Page->DITERIMA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DITERIMA" name="x_DITERIMA" id="x_DITERIMA" size="30" placeholder="<?= HtmlEncode($Page->DITERIMA->getPlaceHolder()) ?>" value="<?= $Page->DITERIMA->EditValue ?>"<?= $Page->DITERIMA->editAttributes() ?> aria-describedby="x_DITERIMA_help">
<?= $Page->DITERIMA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DITERIMA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DISTRIBUSI->Visible) { // DISTRIBUSI ?>
    <div id="r_DISTRIBUSI" class="form-group row">
        <label id="elh_GOOD_GF_DISTRIBUSI" for="x_DISTRIBUSI" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DISTRIBUSI->caption() ?><?= $Page->DISTRIBUSI->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DISTRIBUSI->cellAttributes() ?>>
<span id="el_GOOD_GF_DISTRIBUSI">
<input type="<?= $Page->DISTRIBUSI->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DISTRIBUSI" name="x_DISTRIBUSI" id="x_DISTRIBUSI" size="30" placeholder="<?= HtmlEncode($Page->DISTRIBUSI->getPlaceHolder()) ?>" value="<?= $Page->DISTRIBUSI->EditValue ?>"<?= $Page->DISTRIBUSI->editAttributes() ?> aria-describedby="x_DISTRIBUSI_help">
<?= $Page->DISTRIBUSI->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DISTRIBUSI->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIJUAL->Visible) { // DIJUAL ?>
    <div id="r_DIJUAL" class="form-group row">
        <label id="elh_GOOD_GF_DIJUAL" for="x_DIJUAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIJUAL->caption() ?><?= $Page->DIJUAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIJUAL->cellAttributes() ?>>
<span id="el_GOOD_GF_DIJUAL">
<input type="<?= $Page->DIJUAL->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIJUAL" name="x_DIJUAL" id="x_DIJUAL" size="30" placeholder="<?= HtmlEncode($Page->DIJUAL->getPlaceHolder()) ?>" value="<?= $Page->DIJUAL->EditValue ?>"<?= $Page->DIJUAL->editAttributes() ?> aria-describedby="x_DIJUAL_help">
<?= $Page->DIJUAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIJUAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIHAPUS->Visible) { // DIHAPUS ?>
    <div id="r_DIHAPUS" class="form-group row">
        <label id="elh_GOOD_GF_DIHAPUS" for="x_DIHAPUS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIHAPUS->caption() ?><?= $Page->DIHAPUS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIHAPUS->cellAttributes() ?>>
<span id="el_GOOD_GF_DIHAPUS">
<input type="<?= $Page->DIHAPUS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIHAPUS" name="x_DIHAPUS" id="x_DIHAPUS" size="30" placeholder="<?= HtmlEncode($Page->DIHAPUS->getPlaceHolder()) ?>" value="<?= $Page->DIHAPUS->EditValue ?>"<?= $Page->DIHAPUS->editAttributes() ?> aria-describedby="x_DIHAPUS_help">
<?= $Page->DIHAPUS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIHAPUS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIMINTA->Visible) { // DIMINTA ?>
    <div id="r_DIMINTA" class="form-group row">
        <label id="elh_GOOD_GF_DIMINTA" for="x_DIMINTA" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIMINTA->caption() ?><?= $Page->DIMINTA->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIMINTA->cellAttributes() ?>>
<span id="el_GOOD_GF_DIMINTA">
<input type="<?= $Page->DIMINTA->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIMINTA" name="x_DIMINTA" id="x_DIMINTA" size="30" placeholder="<?= HtmlEncode($Page->DIMINTA->getPlaceHolder()) ?>" value="<?= $Page->DIMINTA->EditValue ?>"<?= $Page->DIMINTA->editAttributes() ?> aria-describedby="x_DIMINTA_help">
<?= $Page->DIMINTA->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIMINTA->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DIRETUR->Visible) { // DIRETUR ?>
    <div id="r_DIRETUR" class="form-group row">
        <label id="elh_GOOD_GF_DIRETUR" for="x_DIRETUR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DIRETUR->caption() ?><?= $Page->DIRETUR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DIRETUR->cellAttributes() ?>>
<span id="el_GOOD_GF_DIRETUR">
<input type="<?= $Page->DIRETUR->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DIRETUR" name="x_DIRETUR" id="x_DIRETUR" size="30" placeholder="<?= HtmlEncode($Page->DIRETUR->getPlaceHolder()) ?>" value="<?= $Page->DIRETUR->EditValue ?>"<?= $Page->DIRETUR->editAttributes() ?> aria-describedby="x_DIRETUR_help">
<?= $Page->DIRETUR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DIRETUR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
    <div id="r_PO" class="form-group row">
        <label id="elh_GOOD_GF_PO" for="x_PO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PO->caption() ?><?= $Page->PO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PO->cellAttributes() ?>>
<span id="el_GOOD_GF_PO">
<input type="<?= $Page->PO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PO" name="x_PO" id="x_PO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->PO->getPlaceHolder()) ?>" value="<?= $Page->PO->EditValue ?>"<?= $Page->PO->editAttributes() ?> aria-describedby="x_PO_help">
<?= $Page->PO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PO->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <div id="r_COMPANY_ID" class="form-group row">
        <label id="elh_GOOD_GF_COMPANY_ID" for="x_COMPANY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?><?= $Page->COMPANY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_COMPANY_ID">
<input type="<?= $Page->COMPANY_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_COMPANY_ID" name="x_COMPANY_ID" id="x_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ID->EditValue ?>"<?= $Page->COMPANY_ID->editAttributes() ?> aria-describedby="x_COMPANY_ID_help">
<?= $Page->COMPANY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FUND_ID->Visible) { // FUND_ID ?>
    <div id="r_FUND_ID" class="form-group row">
        <label id="elh_GOOD_GF_FUND_ID" for="x_FUND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FUND_ID->caption() ?><?= $Page->FUND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FUND_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_FUND_ID">
<input type="<?= $Page->FUND_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_FUND_ID" name="x_FUND_ID" id="x_FUND_ID" size="30" placeholder="<?= HtmlEncode($Page->FUND_ID->getPlaceHolder()) ?>" value="<?= $Page->FUND_ID->EditValue ?>"<?= $Page->FUND_ID->editAttributes() ?> aria-describedby="x_FUND_ID_help">
<?= $Page->FUND_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FUND_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INVOICE_ID2->Visible) { // INVOICE_ID2 ?>
    <div id="r_INVOICE_ID2" class="form-group row">
        <label id="elh_GOOD_GF_INVOICE_ID2" for="x_INVOICE_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INVOICE_ID2->caption() ?><?= $Page->INVOICE_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INVOICE_ID2->cellAttributes() ?>>
<span id="el_GOOD_GF_INVOICE_ID2">
<input type="<?= $Page->INVOICE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_INVOICE_ID2" name="x_INVOICE_ID2" id="x_INVOICE_ID2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->INVOICE_ID2->getPlaceHolder()) ?>" value="<?= $Page->INVOICE_ID2->EditValue ?>"<?= $Page->INVOICE_ID2->editAttributes() ?> aria-describedby="x_INVOICE_ID2_help">
<?= $Page->INVOICE_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INVOICE_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
    <div id="r_MEASURE_ID3" class="form-group row">
        <label id="elh_GOOD_GF_MEASURE_ID3" for="x_MEASURE_ID3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID3->caption() ?><?= $Page->MEASURE_ID3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_ID3">
<input type="<?= $Page->MEASURE_ID3->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID3" name="x_MEASURE_ID3" id="x_MEASURE_ID3" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID3->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID3->EditValue ?>"<?= $Page->MEASURE_ID3->editAttributes() ?> aria-describedby="x_MEASURE_ID3_help">
<?= $Page->MEASURE_ID3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
    <div id="r_SIZE_KEMASAN" class="form-group row">
        <label id="elh_GOOD_GF_SIZE_KEMASAN" for="x_SIZE_KEMASAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_KEMASAN->caption() ?><?= $Page->SIZE_KEMASAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el_GOOD_GF_SIZE_KEMASAN">
<input type="<?= $Page->SIZE_KEMASAN->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_KEMASAN" name="x_SIZE_KEMASAN" id="x_SIZE_KEMASAN" size="30" placeholder="<?= HtmlEncode($Page->SIZE_KEMASAN->getPlaceHolder()) ?>" value="<?= $Page->SIZE_KEMASAN->EditValue ?>"<?= $Page->SIZE_KEMASAN->editAttributes() ?> aria-describedby="x_SIZE_KEMASAN_help">
<?= $Page->SIZE_KEMASAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_KEMASAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
    <div id="r_BRAND_NAME" class="form-group row">
        <label id="elh_GOOD_GF_BRAND_NAME" for="x_BRAND_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_NAME->caption() ?><?= $Page->BRAND_NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el_GOOD_GF_BRAND_NAME">
<input type="<?= $Page->BRAND_NAME->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_BRAND_NAME" name="x_BRAND_NAME" id="x_BRAND_NAME" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->BRAND_NAME->getPlaceHolder()) ?>" value="<?= $Page->BRAND_NAME->EditValue ?>"<?= $Page->BRAND_NAME->editAttributes() ?> aria-describedby="x_BRAND_NAME_help">
<?= $Page->BRAND_NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BRAND_NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <div id="r_MEASURE_ID2" class="form-group row">
        <label id="elh_GOOD_GF_MEASURE_ID2" for="x_MEASURE_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID2->caption() ?><?= $Page->MEASURE_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_ID2">
<input type="<?= $Page->MEASURE_ID2->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_ID2" name="x_MEASURE_ID2" id="x_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID2->EditValue ?>"<?= $Page->MEASURE_ID2->editAttributes() ?> aria-describedby="x_MEASURE_ID2_help">
<?= $Page->MEASURE_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RETUR_ID->Visible) { // RETUR_ID ?>
    <div id="r_RETUR_ID" class="form-group row">
        <label id="elh_GOOD_GF_RETUR_ID" for="x_RETUR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RETUR_ID->caption() ?><?= $Page->RETUR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->RETUR_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_RETUR_ID">
<input type="<?= $Page->RETUR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_RETUR_ID" name="x_RETUR_ID" id="x_RETUR_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->RETUR_ID->getPlaceHolder()) ?>" value="<?= $Page->RETUR_ID->EditValue ?>"<?= $Page->RETUR_ID->editAttributes() ?> aria-describedby="x_RETUR_ID_help">
<?= $Page->RETUR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->RETUR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
    <div id="r_SIZE_GOODS" class="form-group row">
        <label id="elh_GOOD_GF_SIZE_GOODS" for="x_SIZE_GOODS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_GOODS->caption() ?><?= $Page->SIZE_GOODS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el_GOOD_GF_SIZE_GOODS">
<input type="<?= $Page->SIZE_GOODS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_SIZE_GOODS" name="x_SIZE_GOODS" id="x_SIZE_GOODS" size="30" placeholder="<?= HtmlEncode($Page->SIZE_GOODS->getPlaceHolder()) ?>" value="<?= $Page->SIZE_GOODS->EditValue ?>"<?= $Page->SIZE_GOODS->editAttributes() ?> aria-describedby="x_SIZE_GOODS_help">
<?= $Page->SIZE_GOODS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_GOODS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
    <div id="r_MEASURE_DOSIS" class="form-group row">
        <label id="elh_GOOD_GF_MEASURE_DOSIS" for="x_MEASURE_DOSIS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_DOSIS->caption() ?><?= $Page->MEASURE_DOSIS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el_GOOD_GF_MEASURE_DOSIS">
<input type="<?= $Page->MEASURE_DOSIS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MEASURE_DOSIS" name="x_MEASURE_DOSIS" id="x_MEASURE_DOSIS" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_DOSIS->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_DOSIS->EditValue ?>"<?= $Page->MEASURE_DOSIS->editAttributes() ?> aria-describedby="x_MEASURE_DOSIS_help">
<?= $Page->MEASURE_DOSIS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_DOSIS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
    <div id="r_ORDER_PRICE" class="form-group row">
        <label id="elh_GOOD_GF_ORDER_PRICE" for="x_ORDER_PRICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_PRICE->caption() ?><?= $Page->ORDER_PRICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el_GOOD_GF_ORDER_PRICE">
<input type="<?= $Page->ORDER_PRICE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_PRICE" name="x_ORDER_PRICE" id="x_ORDER_PRICE" size="30" placeholder="<?= HtmlEncode($Page->ORDER_PRICE->getPlaceHolder()) ?>" value="<?= $Page->ORDER_PRICE->EditValue ?>"<?= $Page->ORDER_PRICE->editAttributes() ?> aria-describedby="x_ORDER_PRICE_help">
<?= $Page->ORDER_PRICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_PRICE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_AVAILABLE->Visible) { // STOCK_AVAILABLE ?>
    <div id="r_STOCK_AVAILABLE" class="form-group row">
        <label id="elh_GOOD_GF_STOCK_AVAILABLE" for="x_STOCK_AVAILABLE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_AVAILABLE->caption() ?><?= $Page->STOCK_AVAILABLE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_AVAILABLE->cellAttributes() ?>>
<span id="el_GOOD_GF_STOCK_AVAILABLE">
<input type="<?= $Page->STOCK_AVAILABLE->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STOCK_AVAILABLE" name="x_STOCK_AVAILABLE" id="x_STOCK_AVAILABLE" size="30" placeholder="<?= HtmlEncode($Page->STOCK_AVAILABLE->getPlaceHolder()) ?>" value="<?= $Page->STOCK_AVAILABLE->EditValue ?>"<?= $Page->STOCK_AVAILABLE->editAttributes() ?> aria-describedby="x_STOCK_AVAILABLE_help">
<?= $Page->STOCK_AVAILABLE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_AVAILABLE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_GOOD_GF_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_STATUS_PASIEN_ID" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
    <div id="r_MONTH_ID" class="form-group row">
        <label id="elh_GOOD_GF_MONTH_ID" for="x_MONTH_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MONTH_ID->caption() ?><?= $Page->MONTH_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_MONTH_ID">
<input type="<?= $Page->MONTH_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_MONTH_ID" name="x_MONTH_ID" id="x_MONTH_ID" size="30" placeholder="<?= HtmlEncode($Page->MONTH_ID->getPlaceHolder()) ?>" value="<?= $Page->MONTH_ID->EditValue ?>"<?= $Page->MONTH_ID->editAttributes() ?> aria-describedby="x_MONTH_ID_help">
<?= $Page->MONTH_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MONTH_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <div id="r_YEAR_ID" class="form-group row">
        <label id="elh_GOOD_GF_YEAR_ID" for="x_YEAR_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->YEAR_ID->caption() ?><?= $Page->YEAR_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_YEAR_ID">
<input type="<?= $Page->YEAR_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_YEAR_ID" name="x_YEAR_ID" id="x_YEAR_ID" size="30" placeholder="<?= HtmlEncode($Page->YEAR_ID->getPlaceHolder()) ?>" value="<?= $Page->YEAR_ID->EditValue ?>"<?= $Page->YEAR_ID->editAttributes() ?> aria-describedby="x_YEAR_ID_help">
<?= $Page->YEAR_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->YEAR_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CORRECTION_DOC->Visible) { // CORRECTION_DOC ?>
    <div id="r_CORRECTION_DOC" class="form-group row">
        <label id="elh_GOOD_GF_CORRECTION_DOC" for="x_CORRECTION_DOC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CORRECTION_DOC->caption() ?><?= $Page->CORRECTION_DOC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CORRECTION_DOC->cellAttributes() ?>>
<span id="el_GOOD_GF_CORRECTION_DOC">
<input type="<?= $Page->CORRECTION_DOC->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTION_DOC" name="x_CORRECTION_DOC" id="x_CORRECTION_DOC" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->CORRECTION_DOC->getPlaceHolder()) ?>" value="<?= $Page->CORRECTION_DOC->EditValue ?>"<?= $Page->CORRECTION_DOC->editAttributes() ?> aria-describedby="x_CORRECTION_DOC_help">
<?= $Page->CORRECTION_DOC->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CORRECTION_DOC->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CORRECTIONS->Visible) { // CORRECTIONS ?>
    <div id="r_CORRECTIONS" class="form-group row">
        <label id="elh_GOOD_GF_CORRECTIONS" for="x_CORRECTIONS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CORRECTIONS->caption() ?><?= $Page->CORRECTIONS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CORRECTIONS->cellAttributes() ?>>
<span id="el_GOOD_GF_CORRECTIONS">
<input type="<?= $Page->CORRECTIONS->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_CORRECTIONS" name="x_CORRECTIONS" id="x_CORRECTIONS" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->CORRECTIONS->getPlaceHolder()) ?>" value="<?= $Page->CORRECTIONS->EditValue ?>"<?= $Page->CORRECTIONS->editAttributes() ?> aria-describedby="x_CORRECTIONS_help">
<?= $Page->CORRECTIONS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CORRECTIONS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DOC_NO->Visible) { // DOC_NO ?>
    <div id="r_DOC_NO" class="form-group row">
        <label id="elh_GOOD_GF_DOC_NO" for="x_DOC_NO" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DOC_NO->caption() ?><?= $Page->DOC_NO->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DOC_NO->cellAttributes() ?>>
<?php if ($Page->DOC_NO->getSessionValue() != "") { ?>
<span id="el_GOOD_GF_DOC_NO">
<span<?= $Page->DOC_NO->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->DOC_NO->getDisplayValue($Page->DOC_NO->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_DOC_NO" name="x_DOC_NO" value="<?= HtmlEncode($Page->DOC_NO->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_GOOD_GF_DOC_NO">
<input type="<?= $Page->DOC_NO->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_DOC_NO" name="x_DOC_NO" id="x_DOC_NO" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->DOC_NO->getPlaceHolder()) ?>" value="<?= $Page->DOC_NO->EditValue ?>"<?= $Page->DOC_NO->editAttributes() ?> aria-describedby="x_DOC_NO_help">
<?= $Page->DOC_NO->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DOC_NO->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_ID->Visible) { // ORDER_ID ?>
    <div id="r_ORDER_ID" class="form-group row">
        <label id="elh_GOOD_GF_ORDER_ID" for="x_ORDER_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_ID->caption() ?><?= $Page->ORDER_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_ID->cellAttributes() ?>>
<span id="el_GOOD_GF_ORDER_ID">
<input type="<?= $Page->ORDER_ID->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ORDER_ID" name="x_ORDER_ID" id="x_ORDER_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ORDER_ID->getPlaceHolder()) ?>" value="<?= $Page->ORDER_ID->EditValue ?>"<?= $Page->ORDER_ID->editAttributes() ?> aria-describedby="x_ORDER_ID_help">
<?= $Page->ORDER_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <div id="r_ISCETAK" class="form-group row">
        <label id="elh_GOOD_GF_ISCETAK" for="x_ISCETAK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISCETAK->caption() ?><?= $Page->ISCETAK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_GOOD_GF_ISCETAK">
<input type="<?= $Page->ISCETAK->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_ISCETAK" name="x_ISCETAK" id="x_ISCETAK" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISCETAK->getPlaceHolder()) ?>" value="<?= $Page->ISCETAK->EditValue ?>"<?= $Page->ISCETAK->editAttributes() ?> aria-describedby="x_ISCETAK_help">
<?= $Page->ISCETAK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISCETAK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <div id="r_PRINTQ" class="form-group row">
        <label id="elh_GOOD_GF_PRINTQ" for="x_PRINTQ" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PRINTQ->caption() ?><?= $Page->PRINTQ->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_GOOD_GF_PRINTQ">
<input type="<?= $Page->PRINTQ->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_PRINTQ" name="x_PRINTQ" id="x_PRINTQ" size="30" placeholder="<?= HtmlEncode($Page->PRINTQ->getPlaceHolder()) ?>" value="<?= $Page->PRINTQ->EditValue ?>"<?= $Page->PRINTQ->editAttributes() ?> aria-describedby="x_PRINTQ_help">
<?= $Page->PRINTQ->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PRINTQ->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->avgprice->Visible) { // avgprice ?>
    <div id="r_avgprice" class="form-group row">
        <label id="elh_GOOD_GF_avgprice" for="x_avgprice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->avgprice->caption() ?><?= $Page->avgprice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->avgprice->cellAttributes() ?>>
<span id="el_GOOD_GF_avgprice">
<input type="<?= $Page->avgprice->getInputTextType() ?>" data-table="GOOD_GF" data-field="x_avgprice" name="x_avgprice" id="x_avgprice" size="30" placeholder="<?= HtmlEncode($Page->avgprice->getPlaceHolder()) ?>" value="<?= $Page->avgprice->EditValue ?>"<?= $Page->avgprice->editAttributes() ?> aria-describedby="x_avgprice_help">
<?= $Page->avgprice->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->avgprice->getErrorMessage() ?></div>
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
    ew.addEventHandlers("GOOD_GF");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
