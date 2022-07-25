<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOODSedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fGOODSedit = currentForm = new ew.Form("fGOODSedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "GOODS")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.GOODS)
        ew.vars.tables.GOODS = currentTable;
    fGOODSedit.addFields([
        ["CODE_5", [fields.CODE_5.visible && fields.CODE_5.required ? ew.Validators.required(fields.CODE_5.caption) : null], fields.CODE_5.isInvalid],
        ["BRAND_ID", [fields.BRAND_ID.visible && fields.BRAND_ID.required ? ew.Validators.required(fields.BRAND_ID.caption) : null], fields.BRAND_ID.isInvalid],
        ["NAME", [fields.NAME.visible && fields.NAME.required ? ew.Validators.required(fields.NAME.caption) : null], fields.NAME.isInvalid],
        ["OTHER_CODE", [fields.OTHER_CODE.visible && fields.OTHER_CODE.required ? ew.Validators.required(fields.OTHER_CODE.caption) : null], fields.OTHER_CODE.isInvalid],
        ["_BARCODE", [fields._BARCODE.visible && fields._BARCODE.required ? ew.Validators.required(fields._BARCODE.caption) : null], fields._BARCODE.isInvalid],
        ["DESCRIPTION", [fields.DESCRIPTION.visible && fields.DESCRIPTION.required ? ew.Validators.required(fields.DESCRIPTION.caption) : null], fields.DESCRIPTION.isInvalid],
        ["REORDER_POINT", [fields.REORDER_POINT.visible && fields.REORDER_POINT.required ? ew.Validators.required(fields.REORDER_POINT.caption) : null, ew.Validators.float], fields.REORDER_POINT.isInvalid],
        ["SIZE_GOODS", [fields.SIZE_GOODS.visible && fields.SIZE_GOODS.required ? ew.Validators.required(fields.SIZE_GOODS.caption) : null, ew.Validators.float], fields.SIZE_GOODS.isInvalid],
        ["MEASURE_DOSIS", [fields.MEASURE_DOSIS.visible && fields.MEASURE_DOSIS.required ? ew.Validators.required(fields.MEASURE_DOSIS.caption) : null, ew.Validators.integer], fields.MEASURE_DOSIS.isInvalid],
        ["MEASURE_ID", [fields.MEASURE_ID.visible && fields.MEASURE_ID.required ? ew.Validators.required(fields.MEASURE_ID.caption) : null, ew.Validators.integer], fields.MEASURE_ID.isInvalid],
        ["MEASURE_ID2", [fields.MEASURE_ID2.visible && fields.MEASURE_ID2.required ? ew.Validators.required(fields.MEASURE_ID2.caption) : null, ew.Validators.integer], fields.MEASURE_ID2.isInvalid],
        ["SIZE_KEMASAN", [fields.SIZE_KEMASAN.visible && fields.SIZE_KEMASAN.required ? ew.Validators.required(fields.SIZE_KEMASAN.caption) : null, ew.Validators.float], fields.SIZE_KEMASAN.isInvalid],
        ["MEASURE_ID3", [fields.MEASURE_ID3.visible && fields.MEASURE_ID3.required ? ew.Validators.required(fields.MEASURE_ID3.caption) : null, ew.Validators.integer], fields.MEASURE_ID3.isInvalid],
        ["COMPANY_ID", [fields.COMPANY_ID.visible && fields.COMPANY_ID.required ? ew.Validators.required(fields.COMPANY_ID.caption) : null], fields.COMPANY_ID.isInvalid],
        ["NET_PRICE", [fields.NET_PRICE.visible && fields.NET_PRICE.required ? ew.Validators.required(fields.NET_PRICE.caption) : null, ew.Validators.float], fields.NET_PRICE.isInvalid],
        ["MODIFIED_DATE", [fields.MODIFIED_DATE.visible && fields.MODIFIED_DATE.required ? ew.Validators.required(fields.MODIFIED_DATE.caption) : null, ew.Validators.datetime(0)], fields.MODIFIED_DATE.isInvalid],
        ["MODIFIED_BY", [fields.MODIFIED_BY.visible && fields.MODIFIED_BY.required ? ew.Validators.required(fields.MODIFIED_BY.caption) : null], fields.MODIFIED_BY.isInvalid],
        ["TH", [fields.TH.visible && fields.TH.required ? ew.Validators.required(fields.TH.caption) : null, ew.Validators.integer], fields.TH.isInvalid],
        ["STATUS_PASIEN_ID", [fields.STATUS_PASIEN_ID.visible && fields.STATUS_PASIEN_ID.required ? ew.Validators.required(fields.STATUS_PASIEN_ID.caption) : null, ew.Validators.integer], fields.STATUS_PASIEN_ID.isInvalid],
        ["MATERIAL_ID", [fields.MATERIAL_ID.visible && fields.MATERIAL_ID.required ? ew.Validators.required(fields.MATERIAL_ID.caption) : null, ew.Validators.integer], fields.MATERIAL_ID.isInvalid],
        ["FORM_ID", [fields.FORM_ID.visible && fields.FORM_ID.required ? ew.Validators.required(fields.FORM_ID.caption) : null, ew.Validators.integer], fields.FORM_ID.isInvalid],
        ["ISGENERIC", [fields.ISGENERIC.visible && fields.ISGENERIC.required ? ew.Validators.required(fields.ISGENERIC.caption) : null], fields.ISGENERIC.isInvalid],
        ["REGULATE_ID", [fields.REGULATE_ID.visible && fields.REGULATE_ID.required ? ew.Validators.required(fields.REGULATE_ID.caption) : null, ew.Validators.integer], fields.REGULATE_ID.isInvalid],
        ["PREGNANCY_INDEX", [fields.PREGNANCY_INDEX.visible && fields.PREGNANCY_INDEX.required ? ew.Validators.required(fields.PREGNANCY_INDEX.caption) : null], fields.PREGNANCY_INDEX.isInvalid],
        ["INDICATION", [fields.INDICATION.visible && fields.INDICATION.required ? ew.Validators.required(fields.INDICATION.caption) : null], fields.INDICATION.isInvalid],
        ["TAKE_RULE", [fields.TAKE_RULE.visible && fields.TAKE_RULE.required ? ew.Validators.required(fields.TAKE_RULE.caption) : null], fields.TAKE_RULE.isInvalid],
        ["SIDE_EFFECT", [fields.SIDE_EFFECT.visible && fields.SIDE_EFFECT.required ? ew.Validators.required(fields.SIDE_EFFECT.caption) : null], fields.SIDE_EFFECT.isInvalid],
        ["INTERACTION", [fields.INTERACTION.visible && fields.INTERACTION.required ? ew.Validators.required(fields.INTERACTION.caption) : null], fields.INTERACTION.isInvalid],
        ["CONTRA_INDICATION", [fields.CONTRA_INDICATION.visible && fields.CONTRA_INDICATION.required ? ew.Validators.required(fields.CONTRA_INDICATION.caption) : null], fields.CONTRA_INDICATION.isInvalid],
        ["WARNING", [fields.WARNING.visible && fields.WARNING.required ? ew.Validators.required(fields.WARNING.caption) : null], fields.WARNING.isInvalid],
        ["STOCK", [fields.STOCK.visible && fields.STOCK.required ? ew.Validators.required(fields.STOCK.caption) : null, ew.Validators.float], fields.STOCK.isInvalid],
        ["ISACTIVE", [fields.ISACTIVE.visible && fields.ISACTIVE.required ? ew.Validators.required(fields.ISACTIVE.caption) : null], fields.ISACTIVE.isInvalid],
        ["ISALKES", [fields.ISALKES.visible && fields.ISALKES.required ? ew.Validators.required(fields.ISALKES.caption) : null], fields.ISALKES.isInvalid],
        ["SIZE_ORDER", [fields.SIZE_ORDER.visible && fields.SIZE_ORDER.required ? ew.Validators.required(fields.SIZE_ORDER.caption) : null, ew.Validators.float], fields.SIZE_ORDER.isInvalid],
        ["ORDER_PRICE", [fields.ORDER_PRICE.visible && fields.ORDER_PRICE.required ? ew.Validators.required(fields.ORDER_PRICE.caption) : null, ew.Validators.float], fields.ORDER_PRICE.isInvalid],
        ["ISFORMULARIUM", [fields.ISFORMULARIUM.visible && fields.ISFORMULARIUM.required ? ew.Validators.required(fields.ISFORMULARIUM.caption) : null], fields.ISFORMULARIUM.isInvalid],
        ["ISESSENTIAL", [fields.ISESSENTIAL.visible && fields.ISESSENTIAL.required ? ew.Validators.required(fields.ISESSENTIAL.caption) : null], fields.ISESSENTIAL.isInvalid],
        ["AVGDATE", [fields.AVGDATE.visible && fields.AVGDATE.required ? ew.Validators.required(fields.AVGDATE.caption) : null, ew.Validators.datetime(0)], fields.AVGDATE.isInvalid],
        ["STOCK_MINIMAL", [fields.STOCK_MINIMAL.visible && fields.STOCK_MINIMAL.required ? ew.Validators.required(fields.STOCK_MINIMAL.caption) : null, ew.Validators.float], fields.STOCK_MINIMAL.isInvalid],
        ["STOCK_MINIMAL_APT", [fields.STOCK_MINIMAL_APT.visible && fields.STOCK_MINIMAL_APT.required ? ew.Validators.required(fields.STOCK_MINIMAL_APT.caption) : null, ew.Validators.float], fields.STOCK_MINIMAL_APT.isInvalid],
        ["HET", [fields.HET.visible && fields.HET.required ? ew.Validators.required(fields.HET.caption) : null, ew.Validators.float], fields.HET.isInvalid],
        ["default_margin", [fields.default_margin.visible && fields.default_margin.required ? ew.Validators.required(fields.default_margin.caption) : null], fields.default_margin.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fGOODSedit,
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
    fGOODSedit.validate = function () {
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
    fGOODSedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fGOODSedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fGOODSedit");
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
<form name="fGOODSedit" id="fGOODSedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->CODE_5->Visible) { // CODE_5 ?>
    <div id="r_CODE_5" class="form-group row">
        <label id="elh_GOODS_CODE_5" for="x_CODE_5" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CODE_5->caption() ?><?= $Page->CODE_5->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CODE_5->cellAttributes() ?>>
<span id="el_GOODS_CODE_5">
<input type="<?= $Page->CODE_5->getInputTextType() ?>" data-table="GOODS" data-field="x_CODE_5" name="x_CODE_5" id="x_CODE_5" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->CODE_5->getPlaceHolder()) ?>" value="<?= $Page->CODE_5->EditValue ?>"<?= $Page->CODE_5->editAttributes() ?> aria-describedby="x_CODE_5_help">
<?= $Page->CODE_5->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CODE_5->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <div id="r_BRAND_ID" class="form-group row">
        <label id="elh_GOODS_BRAND_ID" for="x_BRAND_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->BRAND_ID->caption() ?><?= $Page->BRAND_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->BRAND_ID->cellAttributes() ?>>
<input type="<?= $Page->BRAND_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_BRAND_ID" name="x_BRAND_ID" id="x_BRAND_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->BRAND_ID->getPlaceHolder()) ?>" value="<?= $Page->BRAND_ID->EditValue ?>"<?= $Page->BRAND_ID->editAttributes() ?> aria-describedby="x_BRAND_ID_help">
<?= $Page->BRAND_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->BRAND_ID->getErrorMessage() ?></div>
<input type="hidden" data-table="GOODS" data-field="x_BRAND_ID" data-hidden="1" name="o_BRAND_ID" id="o_BRAND_ID" value="<?= HtmlEncode($Page->BRAND_ID->OldValue ?? $Page->BRAND_ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NAME->Visible) { // NAME ?>
    <div id="r_NAME" class="form-group row">
        <label id="elh_GOODS_NAME" for="x_NAME" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NAME->caption() ?><?= $Page->NAME->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NAME->cellAttributes() ?>>
<span id="el_GOODS_NAME">
<input type="<?= $Page->NAME->getInputTextType() ?>" data-table="GOODS" data-field="x_NAME" name="x_NAME" id="x_NAME" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->NAME->getPlaceHolder()) ?>" value="<?= $Page->NAME->EditValue ?>"<?= $Page->NAME->editAttributes() ?> aria-describedby="x_NAME_help">
<?= $Page->NAME->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NAME->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->OTHER_CODE->Visible) { // OTHER_CODE ?>
    <div id="r_OTHER_CODE" class="form-group row">
        <label id="elh_GOODS_OTHER_CODE" for="x_OTHER_CODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->OTHER_CODE->caption() ?><?= $Page->OTHER_CODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->OTHER_CODE->cellAttributes() ?>>
<span id="el_GOODS_OTHER_CODE">
<input type="<?= $Page->OTHER_CODE->getInputTextType() ?>" data-table="GOODS" data-field="x_OTHER_CODE" name="x_OTHER_CODE" id="x_OTHER_CODE" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->OTHER_CODE->getPlaceHolder()) ?>" value="<?= $Page->OTHER_CODE->EditValue ?>"<?= $Page->OTHER_CODE->editAttributes() ?> aria-describedby="x_OTHER_CODE_help">
<?= $Page->OTHER_CODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->OTHER_CODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_BARCODE->Visible) { // BARCODE ?>
    <div id="r__BARCODE" class="form-group row">
        <label id="elh_GOODS__BARCODE" for="x__BARCODE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_BARCODE->caption() ?><?= $Page->_BARCODE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_BARCODE->cellAttributes() ?>>
<span id="el_GOODS__BARCODE">
<input type="<?= $Page->_BARCODE->getInputTextType() ?>" data-table="GOODS" data-field="x__BARCODE" name="x__BARCODE" id="x__BARCODE" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_BARCODE->getPlaceHolder()) ?>" value="<?= $Page->_BARCODE->EditValue ?>"<?= $Page->_BARCODE->editAttributes() ?> aria-describedby="x__BARCODE_help">
<?= $Page->_BARCODE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_BARCODE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <div id="r_DESCRIPTION" class="form-group row">
        <label id="elh_GOODS_DESCRIPTION" for="x_DESCRIPTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->DESCRIPTION->caption() ?><?= $Page->DESCRIPTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_GOODS_DESCRIPTION">
<input type="<?= $Page->DESCRIPTION->getInputTextType() ?>" data-table="GOODS" data-field="x_DESCRIPTION" name="x_DESCRIPTION" id="x_DESCRIPTION" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->DESCRIPTION->getPlaceHolder()) ?>" value="<?= $Page->DESCRIPTION->EditValue ?>"<?= $Page->DESCRIPTION->editAttributes() ?> aria-describedby="x_DESCRIPTION_help">
<?= $Page->DESCRIPTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->DESCRIPTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REORDER_POINT->Visible) { // REORDER_POINT ?>
    <div id="r_REORDER_POINT" class="form-group row">
        <label id="elh_GOODS_REORDER_POINT" for="x_REORDER_POINT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REORDER_POINT->caption() ?><?= $Page->REORDER_POINT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REORDER_POINT->cellAttributes() ?>>
<span id="el_GOODS_REORDER_POINT">
<input type="<?= $Page->REORDER_POINT->getInputTextType() ?>" data-table="GOODS" data-field="x_REORDER_POINT" name="x_REORDER_POINT" id="x_REORDER_POINT" size="30" placeholder="<?= HtmlEncode($Page->REORDER_POINT->getPlaceHolder()) ?>" value="<?= $Page->REORDER_POINT->EditValue ?>"<?= $Page->REORDER_POINT->editAttributes() ?> aria-describedby="x_REORDER_POINT_help">
<?= $Page->REORDER_POINT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REORDER_POINT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
    <div id="r_SIZE_GOODS" class="form-group row">
        <label id="elh_GOODS_SIZE_GOODS" for="x_SIZE_GOODS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_GOODS->caption() ?><?= $Page->SIZE_GOODS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el_GOODS_SIZE_GOODS">
<input type="<?= $Page->SIZE_GOODS->getInputTextType() ?>" data-table="GOODS" data-field="x_SIZE_GOODS" name="x_SIZE_GOODS" id="x_SIZE_GOODS" size="30" placeholder="<?= HtmlEncode($Page->SIZE_GOODS->getPlaceHolder()) ?>" value="<?= $Page->SIZE_GOODS->EditValue ?>"<?= $Page->SIZE_GOODS->editAttributes() ?> aria-describedby="x_SIZE_GOODS_help">
<?= $Page->SIZE_GOODS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_GOODS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
    <div id="r_MEASURE_DOSIS" class="form-group row">
        <label id="elh_GOODS_MEASURE_DOSIS" for="x_MEASURE_DOSIS" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_DOSIS->caption() ?><?= $Page->MEASURE_DOSIS->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_DOSIS">
<input type="<?= $Page->MEASURE_DOSIS->getInputTextType() ?>" data-table="GOODS" data-field="x_MEASURE_DOSIS" name="x_MEASURE_DOSIS" id="x_MEASURE_DOSIS" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_DOSIS->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_DOSIS->EditValue ?>"<?= $Page->MEASURE_DOSIS->editAttributes() ?> aria-describedby="x_MEASURE_DOSIS_help">
<?= $Page->MEASURE_DOSIS->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_DOSIS->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <div id="r_MEASURE_ID" class="form-group row">
        <label id="elh_GOODS_MEASURE_ID" for="x_MEASURE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID->caption() ?><?= $Page->MEASURE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_ID">
<input type="<?= $Page->MEASURE_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_MEASURE_ID" name="x_MEASURE_ID" id="x_MEASURE_ID" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID->EditValue ?>"<?= $Page->MEASURE_ID->editAttributes() ?> aria-describedby="x_MEASURE_ID_help">
<?= $Page->MEASURE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <div id="r_MEASURE_ID2" class="form-group row">
        <label id="elh_GOODS_MEASURE_ID2" for="x_MEASURE_ID2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID2->caption() ?><?= $Page->MEASURE_ID2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_ID2">
<input type="<?= $Page->MEASURE_ID2->getInputTextType() ?>" data-table="GOODS" data-field="x_MEASURE_ID2" name="x_MEASURE_ID2" id="x_MEASURE_ID2" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID2->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID2->EditValue ?>"<?= $Page->MEASURE_ID2->editAttributes() ?> aria-describedby="x_MEASURE_ID2_help">
<?= $Page->MEASURE_ID2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
    <div id="r_SIZE_KEMASAN" class="form-group row">
        <label id="elh_GOODS_SIZE_KEMASAN" for="x_SIZE_KEMASAN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_KEMASAN->caption() ?><?= $Page->SIZE_KEMASAN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el_GOODS_SIZE_KEMASAN">
<input type="<?= $Page->SIZE_KEMASAN->getInputTextType() ?>" data-table="GOODS" data-field="x_SIZE_KEMASAN" name="x_SIZE_KEMASAN" id="x_SIZE_KEMASAN" size="30" placeholder="<?= HtmlEncode($Page->SIZE_KEMASAN->getPlaceHolder()) ?>" value="<?= $Page->SIZE_KEMASAN->EditValue ?>"<?= $Page->SIZE_KEMASAN->editAttributes() ?> aria-describedby="x_SIZE_KEMASAN_help">
<?= $Page->SIZE_KEMASAN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_KEMASAN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
    <div id="r_MEASURE_ID3" class="form-group row">
        <label id="elh_GOODS_MEASURE_ID3" for="x_MEASURE_ID3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MEASURE_ID3->caption() ?><?= $Page->MEASURE_ID3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_ID3">
<input type="<?= $Page->MEASURE_ID3->getInputTextType() ?>" data-table="GOODS" data-field="x_MEASURE_ID3" name="x_MEASURE_ID3" id="x_MEASURE_ID3" size="30" placeholder="<?= HtmlEncode($Page->MEASURE_ID3->getPlaceHolder()) ?>" value="<?= $Page->MEASURE_ID3->EditValue ?>"<?= $Page->MEASURE_ID3->editAttributes() ?> aria-describedby="x_MEASURE_ID3_help">
<?= $Page->MEASURE_ID3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MEASURE_ID3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <div id="r_COMPANY_ID" class="form-group row">
        <label id="elh_GOODS_COMPANY_ID" for="x_COMPANY_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->COMPANY_ID->caption() ?><?= $Page->COMPANY_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_GOODS_COMPANY_ID">
<input type="<?= $Page->COMPANY_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_COMPANY_ID" name="x_COMPANY_ID" id="x_COMPANY_ID" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->COMPANY_ID->getPlaceHolder()) ?>" value="<?= $Page->COMPANY_ID->EditValue ?>"<?= $Page->COMPANY_ID->editAttributes() ?> aria-describedby="x_COMPANY_ID_help">
<?= $Page->COMPANY_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->COMPANY_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->NET_PRICE->Visible) { // NET_PRICE ?>
    <div id="r_NET_PRICE" class="form-group row">
        <label id="elh_GOODS_NET_PRICE" for="x_NET_PRICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->NET_PRICE->caption() ?><?= $Page->NET_PRICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->NET_PRICE->cellAttributes() ?>>
<span id="el_GOODS_NET_PRICE">
<input type="<?= $Page->NET_PRICE->getInputTextType() ?>" data-table="GOODS" data-field="x_NET_PRICE" name="x_NET_PRICE" id="x_NET_PRICE" size="30" placeholder="<?= HtmlEncode($Page->NET_PRICE->getPlaceHolder()) ?>" value="<?= $Page->NET_PRICE->EditValue ?>"<?= $Page->NET_PRICE->editAttributes() ?> aria-describedby="x_NET_PRICE_help">
<?= $Page->NET_PRICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->NET_PRICE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <div id="r_MODIFIED_DATE" class="form-group row">
        <label id="elh_GOODS_MODIFIED_DATE" for="x_MODIFIED_DATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_DATE->caption() ?><?= $Page->MODIFIED_DATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_GOODS_MODIFIED_DATE">
<input type="<?= $Page->MODIFIED_DATE->getInputTextType() ?>" data-table="GOODS" data-field="x_MODIFIED_DATE" name="x_MODIFIED_DATE" id="x_MODIFIED_DATE" placeholder="<?= HtmlEncode($Page->MODIFIED_DATE->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_DATE->EditValue ?>"<?= $Page->MODIFIED_DATE->editAttributes() ?> aria-describedby="x_MODIFIED_DATE_help">
<?= $Page->MODIFIED_DATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_DATE->getErrorMessage() ?></div>
<?php if (!$Page->MODIFIED_DATE->ReadOnly && !$Page->MODIFIED_DATE->Disabled && !isset($Page->MODIFIED_DATE->EditAttrs["readonly"]) && !isset($Page->MODIFIED_DATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOODSedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOODSedit", "x_MODIFIED_DATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <div id="r_MODIFIED_BY" class="form-group row">
        <label id="elh_GOODS_MODIFIED_BY" for="x_MODIFIED_BY" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MODIFIED_BY->caption() ?><?= $Page->MODIFIED_BY->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_GOODS_MODIFIED_BY">
<input type="<?= $Page->MODIFIED_BY->getInputTextType() ?>" data-table="GOODS" data-field="x_MODIFIED_BY" name="x_MODIFIED_BY" id="x_MODIFIED_BY" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->MODIFIED_BY->getPlaceHolder()) ?>" value="<?= $Page->MODIFIED_BY->EditValue ?>"<?= $Page->MODIFIED_BY->editAttributes() ?> aria-describedby="x_MODIFIED_BY_help">
<?= $Page->MODIFIED_BY->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MODIFIED_BY->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TH->Visible) { // TH ?>
    <div id="r_TH" class="form-group row">
        <label id="elh_GOODS_TH" for="x_TH" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TH->caption() ?><?= $Page->TH->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TH->cellAttributes() ?>>
<span id="el_GOODS_TH">
<input type="<?= $Page->TH->getInputTextType() ?>" data-table="GOODS" data-field="x_TH" name="x_TH" id="x_TH" size="30" placeholder="<?= HtmlEncode($Page->TH->getPlaceHolder()) ?>" value="<?= $Page->TH->EditValue ?>"<?= $Page->TH->editAttributes() ?> aria-describedby="x_TH_help">
<?= $Page->TH->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TH->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <div id="r_STATUS_PASIEN_ID" class="form-group row">
        <label id="elh_GOODS_STATUS_PASIEN_ID" for="x_STATUS_PASIEN_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STATUS_PASIEN_ID->caption() ?><?= $Page->STATUS_PASIEN_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_GOODS_STATUS_PASIEN_ID">
<input type="<?= $Page->STATUS_PASIEN_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_STATUS_PASIEN_ID" name="x_STATUS_PASIEN_ID" id="x_STATUS_PASIEN_ID" size="30" placeholder="<?= HtmlEncode($Page->STATUS_PASIEN_ID->getPlaceHolder()) ?>" value="<?= $Page->STATUS_PASIEN_ID->EditValue ?>"<?= $Page->STATUS_PASIEN_ID->editAttributes() ?> aria-describedby="x_STATUS_PASIEN_ID_help">
<?= $Page->STATUS_PASIEN_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STATUS_PASIEN_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->MATERIAL_ID->Visible) { // MATERIAL_ID ?>
    <div id="r_MATERIAL_ID" class="form-group row">
        <label id="elh_GOODS_MATERIAL_ID" for="x_MATERIAL_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->MATERIAL_ID->caption() ?><?= $Page->MATERIAL_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->MATERIAL_ID->cellAttributes() ?>>
<span id="el_GOODS_MATERIAL_ID">
<input type="<?= $Page->MATERIAL_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_MATERIAL_ID" name="x_MATERIAL_ID" id="x_MATERIAL_ID" size="30" placeholder="<?= HtmlEncode($Page->MATERIAL_ID->getPlaceHolder()) ?>" value="<?= $Page->MATERIAL_ID->EditValue ?>"<?= $Page->MATERIAL_ID->editAttributes() ?> aria-describedby="x_MATERIAL_ID_help">
<?= $Page->MATERIAL_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->MATERIAL_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
    <div id="r_FORM_ID" class="form-group row">
        <label id="elh_GOODS_FORM_ID" for="x_FORM_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->FORM_ID->caption() ?><?= $Page->FORM_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->FORM_ID->cellAttributes() ?>>
<span id="el_GOODS_FORM_ID">
<input type="<?= $Page->FORM_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_FORM_ID" name="x_FORM_ID" id="x_FORM_ID" size="30" placeholder="<?= HtmlEncode($Page->FORM_ID->getPlaceHolder()) ?>" value="<?= $Page->FORM_ID->EditValue ?>"<?= $Page->FORM_ID->editAttributes() ?> aria-describedby="x_FORM_ID_help">
<?= $Page->FORM_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->FORM_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISGENERIC->Visible) { // ISGENERIC ?>
    <div id="r_ISGENERIC" class="form-group row">
        <label id="elh_GOODS_ISGENERIC" for="x_ISGENERIC" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISGENERIC->caption() ?><?= $Page->ISGENERIC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISGENERIC->cellAttributes() ?>>
<span id="el_GOODS_ISGENERIC">
<input type="<?= $Page->ISGENERIC->getInputTextType() ?>" data-table="GOODS" data-field="x_ISGENERIC" name="x_ISGENERIC" id="x_ISGENERIC" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISGENERIC->getPlaceHolder()) ?>" value="<?= $Page->ISGENERIC->EditValue ?>"<?= $Page->ISGENERIC->editAttributes() ?> aria-describedby="x_ISGENERIC_help">
<?= $Page->ISGENERIC->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISGENERIC->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->REGULATE_ID->Visible) { // REGULATE_ID ?>
    <div id="r_REGULATE_ID" class="form-group row">
        <label id="elh_GOODS_REGULATE_ID" for="x_REGULATE_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->REGULATE_ID->caption() ?><?= $Page->REGULATE_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->REGULATE_ID->cellAttributes() ?>>
<span id="el_GOODS_REGULATE_ID">
<input type="<?= $Page->REGULATE_ID->getInputTextType() ?>" data-table="GOODS" data-field="x_REGULATE_ID" name="x_REGULATE_ID" id="x_REGULATE_ID" size="30" placeholder="<?= HtmlEncode($Page->REGULATE_ID->getPlaceHolder()) ?>" value="<?= $Page->REGULATE_ID->EditValue ?>"<?= $Page->REGULATE_ID->editAttributes() ?> aria-describedby="x_REGULATE_ID_help">
<?= $Page->REGULATE_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->REGULATE_ID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->PREGNANCY_INDEX->Visible) { // PREGNANCY_INDEX ?>
    <div id="r_PREGNANCY_INDEX" class="form-group row">
        <label id="elh_GOODS_PREGNANCY_INDEX" for="x_PREGNANCY_INDEX" class="<?= $Page->LeftColumnClass ?>"><?= $Page->PREGNANCY_INDEX->caption() ?><?= $Page->PREGNANCY_INDEX->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->PREGNANCY_INDEX->cellAttributes() ?>>
<span id="el_GOODS_PREGNANCY_INDEX">
<input type="<?= $Page->PREGNANCY_INDEX->getInputTextType() ?>" data-table="GOODS" data-field="x_PREGNANCY_INDEX" name="x_PREGNANCY_INDEX" id="x_PREGNANCY_INDEX" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->PREGNANCY_INDEX->getPlaceHolder()) ?>" value="<?= $Page->PREGNANCY_INDEX->EditValue ?>"<?= $Page->PREGNANCY_INDEX->editAttributes() ?> aria-describedby="x_PREGNANCY_INDEX_help">
<?= $Page->PREGNANCY_INDEX->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->PREGNANCY_INDEX->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INDICATION->Visible) { // INDICATION ?>
    <div id="r_INDICATION" class="form-group row">
        <label id="elh_GOODS_INDICATION" for="x_INDICATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INDICATION->caption() ?><?= $Page->INDICATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INDICATION->cellAttributes() ?>>
<span id="el_GOODS_INDICATION">
<input type="<?= $Page->INDICATION->getInputTextType() ?>" data-table="GOODS" data-field="x_INDICATION" name="x_INDICATION" id="x_INDICATION" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->INDICATION->getPlaceHolder()) ?>" value="<?= $Page->INDICATION->EditValue ?>"<?= $Page->INDICATION->editAttributes() ?> aria-describedby="x_INDICATION_help">
<?= $Page->INDICATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INDICATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->TAKE_RULE->Visible) { // TAKE_RULE ?>
    <div id="r_TAKE_RULE" class="form-group row">
        <label id="elh_GOODS_TAKE_RULE" for="x_TAKE_RULE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->TAKE_RULE->caption() ?><?= $Page->TAKE_RULE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->TAKE_RULE->cellAttributes() ?>>
<span id="el_GOODS_TAKE_RULE">
<input type="<?= $Page->TAKE_RULE->getInputTextType() ?>" data-table="GOODS" data-field="x_TAKE_RULE" name="x_TAKE_RULE" id="x_TAKE_RULE" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->TAKE_RULE->getPlaceHolder()) ?>" value="<?= $Page->TAKE_RULE->EditValue ?>"<?= $Page->TAKE_RULE->editAttributes() ?> aria-describedby="x_TAKE_RULE_help">
<?= $Page->TAKE_RULE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->TAKE_RULE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIDE_EFFECT->Visible) { // SIDE_EFFECT ?>
    <div id="r_SIDE_EFFECT" class="form-group row">
        <label id="elh_GOODS_SIDE_EFFECT" for="x_SIDE_EFFECT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIDE_EFFECT->caption() ?><?= $Page->SIDE_EFFECT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIDE_EFFECT->cellAttributes() ?>>
<span id="el_GOODS_SIDE_EFFECT">
<input type="<?= $Page->SIDE_EFFECT->getInputTextType() ?>" data-table="GOODS" data-field="x_SIDE_EFFECT" name="x_SIDE_EFFECT" id="x_SIDE_EFFECT" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->SIDE_EFFECT->getPlaceHolder()) ?>" value="<?= $Page->SIDE_EFFECT->EditValue ?>"<?= $Page->SIDE_EFFECT->editAttributes() ?> aria-describedby="x_SIDE_EFFECT_help">
<?= $Page->SIDE_EFFECT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIDE_EFFECT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->INTERACTION->Visible) { // INTERACTION ?>
    <div id="r_INTERACTION" class="form-group row">
        <label id="elh_GOODS_INTERACTION" for="x_INTERACTION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->INTERACTION->caption() ?><?= $Page->INTERACTION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->INTERACTION->cellAttributes() ?>>
<span id="el_GOODS_INTERACTION">
<input type="<?= $Page->INTERACTION->getInputTextType() ?>" data-table="GOODS" data-field="x_INTERACTION" name="x_INTERACTION" id="x_INTERACTION" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->INTERACTION->getPlaceHolder()) ?>" value="<?= $Page->INTERACTION->EditValue ?>"<?= $Page->INTERACTION->editAttributes() ?> aria-describedby="x_INTERACTION_help">
<?= $Page->INTERACTION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->INTERACTION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->CONTRA_INDICATION->Visible) { // CONTRA_INDICATION ?>
    <div id="r_CONTRA_INDICATION" class="form-group row">
        <label id="elh_GOODS_CONTRA_INDICATION" for="x_CONTRA_INDICATION" class="<?= $Page->LeftColumnClass ?>"><?= $Page->CONTRA_INDICATION->caption() ?><?= $Page->CONTRA_INDICATION->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->CONTRA_INDICATION->cellAttributes() ?>>
<span id="el_GOODS_CONTRA_INDICATION">
<input type="<?= $Page->CONTRA_INDICATION->getInputTextType() ?>" data-table="GOODS" data-field="x_CONTRA_INDICATION" name="x_CONTRA_INDICATION" id="x_CONTRA_INDICATION" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->CONTRA_INDICATION->getPlaceHolder()) ?>" value="<?= $Page->CONTRA_INDICATION->EditValue ?>"<?= $Page->CONTRA_INDICATION->editAttributes() ?> aria-describedby="x_CONTRA_INDICATION_help">
<?= $Page->CONTRA_INDICATION->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->CONTRA_INDICATION->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->WARNING->Visible) { // WARNING ?>
    <div id="r_WARNING" class="form-group row">
        <label id="elh_GOODS_WARNING" for="x_WARNING" class="<?= $Page->LeftColumnClass ?>"><?= $Page->WARNING->caption() ?><?= $Page->WARNING->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->WARNING->cellAttributes() ?>>
<span id="el_GOODS_WARNING">
<input type="<?= $Page->WARNING->getInputTextType() ?>" data-table="GOODS" data-field="x_WARNING" name="x_WARNING" id="x_WARNING" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->WARNING->getPlaceHolder()) ?>" value="<?= $Page->WARNING->EditValue ?>"<?= $Page->WARNING->editAttributes() ?> aria-describedby="x_WARNING_help">
<?= $Page->WARNING->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->WARNING->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK->Visible) { // STOCK ?>
    <div id="r_STOCK" class="form-group row">
        <label id="elh_GOODS_STOCK" for="x_STOCK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK->caption() ?><?= $Page->STOCK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK->cellAttributes() ?>>
<span id="el_GOODS_STOCK">
<input type="<?= $Page->STOCK->getInputTextType() ?>" data-table="GOODS" data-field="x_STOCK" name="x_STOCK" id="x_STOCK" size="30" placeholder="<?= HtmlEncode($Page->STOCK->getPlaceHolder()) ?>" value="<?= $Page->STOCK->EditValue ?>"<?= $Page->STOCK->editAttributes() ?> aria-describedby="x_STOCK_help">
<?= $Page->STOCK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISACTIVE->Visible) { // ISACTIVE ?>
    <div id="r_ISACTIVE" class="form-group row">
        <label id="elh_GOODS_ISACTIVE" for="x_ISACTIVE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISACTIVE->caption() ?><?= $Page->ISACTIVE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISACTIVE->cellAttributes() ?>>
<span id="el_GOODS_ISACTIVE">
<input type="<?= $Page->ISACTIVE->getInputTextType() ?>" data-table="GOODS" data-field="x_ISACTIVE" name="x_ISACTIVE" id="x_ISACTIVE" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISACTIVE->getPlaceHolder()) ?>" value="<?= $Page->ISACTIVE->EditValue ?>"<?= $Page->ISACTIVE->editAttributes() ?> aria-describedby="x_ISACTIVE_help">
<?= $Page->ISACTIVE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISACTIVE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISALKES->Visible) { // ISALKES ?>
    <div id="r_ISALKES" class="form-group row">
        <label id="elh_GOODS_ISALKES" for="x_ISALKES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISALKES->caption() ?><?= $Page->ISALKES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISALKES->cellAttributes() ?>>
<span id="el_GOODS_ISALKES">
<input type="<?= $Page->ISALKES->getInputTextType() ?>" data-table="GOODS" data-field="x_ISALKES" name="x_ISALKES" id="x_ISALKES" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->ISALKES->getPlaceHolder()) ?>" value="<?= $Page->ISALKES->EditValue ?>"<?= $Page->ISALKES->editAttributes() ?> aria-describedby="x_ISALKES_help">
<?= $Page->ISALKES->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISALKES->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->SIZE_ORDER->Visible) { // SIZE_ORDER ?>
    <div id="r_SIZE_ORDER" class="form-group row">
        <label id="elh_GOODS_SIZE_ORDER" for="x_SIZE_ORDER" class="<?= $Page->LeftColumnClass ?>"><?= $Page->SIZE_ORDER->caption() ?><?= $Page->SIZE_ORDER->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->SIZE_ORDER->cellAttributes() ?>>
<span id="el_GOODS_SIZE_ORDER">
<input type="<?= $Page->SIZE_ORDER->getInputTextType() ?>" data-table="GOODS" data-field="x_SIZE_ORDER" name="x_SIZE_ORDER" id="x_SIZE_ORDER" size="30" placeholder="<?= HtmlEncode($Page->SIZE_ORDER->getPlaceHolder()) ?>" value="<?= $Page->SIZE_ORDER->EditValue ?>"<?= $Page->SIZE_ORDER->editAttributes() ?> aria-describedby="x_SIZE_ORDER_help">
<?= $Page->SIZE_ORDER->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->SIZE_ORDER->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
    <div id="r_ORDER_PRICE" class="form-group row">
        <label id="elh_GOODS_ORDER_PRICE" for="x_ORDER_PRICE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ORDER_PRICE->caption() ?><?= $Page->ORDER_PRICE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el_GOODS_ORDER_PRICE">
<input type="<?= $Page->ORDER_PRICE->getInputTextType() ?>" data-table="GOODS" data-field="x_ORDER_PRICE" name="x_ORDER_PRICE" id="x_ORDER_PRICE" size="30" placeholder="<?= HtmlEncode($Page->ORDER_PRICE->getPlaceHolder()) ?>" value="<?= $Page->ORDER_PRICE->EditValue ?>"<?= $Page->ORDER_PRICE->editAttributes() ?> aria-describedby="x_ORDER_PRICE_help">
<?= $Page->ORDER_PRICE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ORDER_PRICE->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISFORMULARIUM->Visible) { // ISFORMULARIUM ?>
    <div id="r_ISFORMULARIUM" class="form-group row">
        <label id="elh_GOODS_ISFORMULARIUM" for="x_ISFORMULARIUM" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISFORMULARIUM->caption() ?><?= $Page->ISFORMULARIUM->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISFORMULARIUM->cellAttributes() ?>>
<span id="el_GOODS_ISFORMULARIUM">
<input type="<?= $Page->ISFORMULARIUM->getInputTextType() ?>" data-table="GOODS" data-field="x_ISFORMULARIUM" name="x_ISFORMULARIUM" id="x_ISFORMULARIUM" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISFORMULARIUM->getPlaceHolder()) ?>" value="<?= $Page->ISFORMULARIUM->EditValue ?>"<?= $Page->ISFORMULARIUM->editAttributes() ?> aria-describedby="x_ISFORMULARIUM_help">
<?= $Page->ISFORMULARIUM->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISFORMULARIUM->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ISESSENTIAL->Visible) { // ISESSENTIAL ?>
    <div id="r_ISESSENTIAL" class="form-group row">
        <label id="elh_GOODS_ISESSENTIAL" for="x_ISESSENTIAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ISESSENTIAL->caption() ?><?= $Page->ISESSENTIAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ISESSENTIAL->cellAttributes() ?>>
<span id="el_GOODS_ISESSENTIAL">
<input type="<?= $Page->ISESSENTIAL->getInputTextType() ?>" data-table="GOODS" data-field="x_ISESSENTIAL" name="x_ISESSENTIAL" id="x_ISESSENTIAL" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->ISESSENTIAL->getPlaceHolder()) ?>" value="<?= $Page->ISESSENTIAL->EditValue ?>"<?= $Page->ISESSENTIAL->editAttributes() ?> aria-describedby="x_ISESSENTIAL_help">
<?= $Page->ISESSENTIAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ISESSENTIAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->AVGDATE->Visible) { // AVGDATE ?>
    <div id="r_AVGDATE" class="form-group row">
        <label id="elh_GOODS_AVGDATE" for="x_AVGDATE" class="<?= $Page->LeftColumnClass ?>"><?= $Page->AVGDATE->caption() ?><?= $Page->AVGDATE->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->AVGDATE->cellAttributes() ?>>
<span id="el_GOODS_AVGDATE">
<input type="<?= $Page->AVGDATE->getInputTextType() ?>" data-table="GOODS" data-field="x_AVGDATE" name="x_AVGDATE" id="x_AVGDATE" placeholder="<?= HtmlEncode($Page->AVGDATE->getPlaceHolder()) ?>" value="<?= $Page->AVGDATE->EditValue ?>"<?= $Page->AVGDATE->editAttributes() ?> aria-describedby="x_AVGDATE_help">
<?= $Page->AVGDATE->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->AVGDATE->getErrorMessage() ?></div>
<?php if (!$Page->AVGDATE->ReadOnly && !$Page->AVGDATE->Disabled && !isset($Page->AVGDATE->EditAttrs["readonly"]) && !isset($Page->AVGDATE->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fGOODSedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fGOODSedit", "x_AVGDATE", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL->Visible) { // STOCK_MINIMAL ?>
    <div id="r_STOCK_MINIMAL" class="form-group row">
        <label id="elh_GOODS_STOCK_MINIMAL" for="x_STOCK_MINIMAL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_MINIMAL->caption() ?><?= $Page->STOCK_MINIMAL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_MINIMAL->cellAttributes() ?>>
<span id="el_GOODS_STOCK_MINIMAL">
<input type="<?= $Page->STOCK_MINIMAL->getInputTextType() ?>" data-table="GOODS" data-field="x_STOCK_MINIMAL" name="x_STOCK_MINIMAL" id="x_STOCK_MINIMAL" size="30" placeholder="<?= HtmlEncode($Page->STOCK_MINIMAL->getPlaceHolder()) ?>" value="<?= $Page->STOCK_MINIMAL->EditValue ?>"<?= $Page->STOCK_MINIMAL->editAttributes() ?> aria-describedby="x_STOCK_MINIMAL_help">
<?= $Page->STOCK_MINIMAL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_MINIMAL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL_APT->Visible) { // STOCK_MINIMAL_APT ?>
    <div id="r_STOCK_MINIMAL_APT" class="form-group row">
        <label id="elh_GOODS_STOCK_MINIMAL_APT" for="x_STOCK_MINIMAL_APT" class="<?= $Page->LeftColumnClass ?>"><?= $Page->STOCK_MINIMAL_APT->caption() ?><?= $Page->STOCK_MINIMAL_APT->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->STOCK_MINIMAL_APT->cellAttributes() ?>>
<span id="el_GOODS_STOCK_MINIMAL_APT">
<input type="<?= $Page->STOCK_MINIMAL_APT->getInputTextType() ?>" data-table="GOODS" data-field="x_STOCK_MINIMAL_APT" name="x_STOCK_MINIMAL_APT" id="x_STOCK_MINIMAL_APT" size="30" placeholder="<?= HtmlEncode($Page->STOCK_MINIMAL_APT->getPlaceHolder()) ?>" value="<?= $Page->STOCK_MINIMAL_APT->EditValue ?>"<?= $Page->STOCK_MINIMAL_APT->editAttributes() ?> aria-describedby="x_STOCK_MINIMAL_APT_help">
<?= $Page->STOCK_MINIMAL_APT->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->STOCK_MINIMAL_APT->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->HET->Visible) { // HET ?>
    <div id="r_HET" class="form-group row">
        <label id="elh_GOODS_HET" for="x_HET" class="<?= $Page->LeftColumnClass ?>"><?= $Page->HET->caption() ?><?= $Page->HET->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->HET->cellAttributes() ?>>
<span id="el_GOODS_HET">
<input type="<?= $Page->HET->getInputTextType() ?>" data-table="GOODS" data-field="x_HET" name="x_HET" id="x_HET" size="30" placeholder="<?= HtmlEncode($Page->HET->getPlaceHolder()) ?>" value="<?= $Page->HET->EditValue ?>"<?= $Page->HET->editAttributes() ?> aria-describedby="x_HET_help">
<?= $Page->HET->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->HET->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->default_margin->Visible) { // default_margin ?>
    <div id="r_default_margin" class="form-group row">
        <label id="elh_GOODS_default_margin" for="x_default_margin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->default_margin->caption() ?><?= $Page->default_margin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->default_margin->cellAttributes() ?>>
<span id="el_GOODS_default_margin">
<input type="<?= $Page->default_margin->getInputTextType() ?>" data-table="GOODS" data-field="x_default_margin" name="x_default_margin" id="x_default_margin" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->default_margin->getPlaceHolder()) ?>" value="<?= $Page->default_margin->EditValue ?>"<?= $Page->default_margin->editAttributes() ?> aria-describedby="x_default_margin_help">
<?= $Page->default_margin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->default_margin->getErrorMessage() ?></div>
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
    ew.addEventHandlers("GOODS");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
