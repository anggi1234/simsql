<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fGOODSview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fGOODSview = currentForm = new ew.Form("fGOODSview", "view");
    loadjs.done("fGOODSview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.GOODS) ew.vars.tables.GOODS = <?= JsonEncode(GetClientVar("tables", "GOODS")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fGOODSview" id="fGOODSview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CODE_5->Visible) { // CODE_5 ?>
    <tr id="r_CODE_5">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_CODE_5"><?= $Page->CODE_5->caption() ?></span></td>
        <td data-name="CODE_5" <?= $Page->CODE_5->cellAttributes() ?>>
<span id="el_GOODS_CODE_5">
<span<?= $Page->CODE_5->viewAttributes() ?>>
<?= $Page->CODE_5->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
    <tr id="r_BRAND_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></td>
        <td data-name="BRAND_ID" <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el_GOODS_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NAME->Visible) { // NAME ?>
    <tr id="r_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_NAME"><?= $Page->NAME->caption() ?></span></td>
        <td data-name="NAME" <?= $Page->NAME->cellAttributes() ?>>
<span id="el_GOODS_NAME">
<span<?= $Page->NAME->viewAttributes() ?>>
<?= $Page->NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->OTHER_CODE->Visible) { // OTHER_CODE ?>
    <tr id="r_OTHER_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_OTHER_CODE"><?= $Page->OTHER_CODE->caption() ?></span></td>
        <td data-name="OTHER_CODE" <?= $Page->OTHER_CODE->cellAttributes() ?>>
<span id="el_GOODS_OTHER_CODE">
<span<?= $Page->OTHER_CODE->viewAttributes() ?>>
<?= $Page->OTHER_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_BARCODE->Visible) { // BARCODE ?>
    <tr id="r__BARCODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS__BARCODE"><?= $Page->_BARCODE->caption() ?></span></td>
        <td data-name="_BARCODE" <?= $Page->_BARCODE->cellAttributes() ?>>
<span id="el_GOODS__BARCODE">
<span<?= $Page->_BARCODE->viewAttributes() ?>>
<?= $Page->_BARCODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
    <tr id="r_DESCRIPTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></td>
        <td data-name="DESCRIPTION" <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el_GOODS_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REORDER_POINT->Visible) { // REORDER_POINT ?>
    <tr id="r_REORDER_POINT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_REORDER_POINT"><?= $Page->REORDER_POINT->caption() ?></span></td>
        <td data-name="REORDER_POINT" <?= $Page->REORDER_POINT->cellAttributes() ?>>
<span id="el_GOODS_REORDER_POINT">
<span<?= $Page->REORDER_POINT->viewAttributes() ?>>
<?= $Page->REORDER_POINT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
    <tr id="r_SIZE_GOODS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></td>
        <td data-name="SIZE_GOODS" <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el_GOODS_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
    <tr id="r_MEASURE_DOSIS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></td>
        <td data-name="MEASURE_DOSIS" <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
    <tr id="r_MEASURE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></td>
        <td data-name="MEASURE_ID" <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
    <tr id="r_MEASURE_ID2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></td>
        <td data-name="MEASURE_ID2" <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
    <tr id="r_SIZE_KEMASAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></td>
        <td data-name="SIZE_KEMASAN" <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el_GOODS_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
    <tr id="r_MEASURE_ID3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></td>
        <td data-name="MEASURE_ID3" <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el_GOODS_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <tr id="r_COMPANY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></td>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_GOODS_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NET_PRICE->Visible) { // NET_PRICE ?>
    <tr id="r_NET_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_NET_PRICE"><?= $Page->NET_PRICE->caption() ?></span></td>
        <td data-name="NET_PRICE" <?= $Page->NET_PRICE->cellAttributes() ?>>
<span id="el_GOODS_NET_PRICE">
<span<?= $Page->NET_PRICE->viewAttributes() ?>>
<?= $Page->NET_PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_GOODS_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_GOODS_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TH->Visible) { // TH ?>
    <tr id="r_TH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_TH"><?= $Page->TH->caption() ?></span></td>
        <td data-name="TH" <?= $Page->TH->cellAttributes() ?>>
<span id="el_GOODS_TH">
<span<?= $Page->TH->viewAttributes() ?>>
<?= $Page->TH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_GOODS_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MATERIAL_ID->Visible) { // MATERIAL_ID ?>
    <tr id="r_MATERIAL_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_MATERIAL_ID"><?= $Page->MATERIAL_ID->caption() ?></span></td>
        <td data-name="MATERIAL_ID" <?= $Page->MATERIAL_ID->cellAttributes() ?>>
<span id="el_GOODS_MATERIAL_ID">
<span<?= $Page->MATERIAL_ID->viewAttributes() ?>>
<?= $Page->MATERIAL_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
    <tr id="r_FORM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_FORM_ID"><?= $Page->FORM_ID->caption() ?></span></td>
        <td data-name="FORM_ID" <?= $Page->FORM_ID->cellAttributes() ?>>
<span id="el_GOODS_FORM_ID">
<span<?= $Page->FORM_ID->viewAttributes() ?>>
<?= $Page->FORM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISGENERIC->Visible) { // ISGENERIC ?>
    <tr id="r_ISGENERIC">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_ISGENERIC"><?= $Page->ISGENERIC->caption() ?></span></td>
        <td data-name="ISGENERIC" <?= $Page->ISGENERIC->cellAttributes() ?>>
<span id="el_GOODS_ISGENERIC">
<span<?= $Page->ISGENERIC->viewAttributes() ?>>
<?= $Page->ISGENERIC->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REGULATE_ID->Visible) { // REGULATE_ID ?>
    <tr id="r_REGULATE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_REGULATE_ID"><?= $Page->REGULATE_ID->caption() ?></span></td>
        <td data-name="REGULATE_ID" <?= $Page->REGULATE_ID->cellAttributes() ?>>
<span id="el_GOODS_REGULATE_ID">
<span<?= $Page->REGULATE_ID->viewAttributes() ?>>
<?= $Page->REGULATE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PREGNANCY_INDEX->Visible) { // PREGNANCY_INDEX ?>
    <tr id="r_PREGNANCY_INDEX">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_PREGNANCY_INDEX"><?= $Page->PREGNANCY_INDEX->caption() ?></span></td>
        <td data-name="PREGNANCY_INDEX" <?= $Page->PREGNANCY_INDEX->cellAttributes() ?>>
<span id="el_GOODS_PREGNANCY_INDEX">
<span<?= $Page->PREGNANCY_INDEX->viewAttributes() ?>>
<?= $Page->PREGNANCY_INDEX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INDICATION->Visible) { // INDICATION ?>
    <tr id="r_INDICATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_INDICATION"><?= $Page->INDICATION->caption() ?></span></td>
        <td data-name="INDICATION" <?= $Page->INDICATION->cellAttributes() ?>>
<span id="el_GOODS_INDICATION">
<span<?= $Page->INDICATION->viewAttributes() ?>>
<?= $Page->INDICATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TAKE_RULE->Visible) { // TAKE_RULE ?>
    <tr id="r_TAKE_RULE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_TAKE_RULE"><?= $Page->TAKE_RULE->caption() ?></span></td>
        <td data-name="TAKE_RULE" <?= $Page->TAKE_RULE->cellAttributes() ?>>
<span id="el_GOODS_TAKE_RULE">
<span<?= $Page->TAKE_RULE->viewAttributes() ?>>
<?= $Page->TAKE_RULE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIDE_EFFECT->Visible) { // SIDE_EFFECT ?>
    <tr id="r_SIDE_EFFECT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_SIDE_EFFECT"><?= $Page->SIDE_EFFECT->caption() ?></span></td>
        <td data-name="SIDE_EFFECT" <?= $Page->SIDE_EFFECT->cellAttributes() ?>>
<span id="el_GOODS_SIDE_EFFECT">
<span<?= $Page->SIDE_EFFECT->viewAttributes() ?>>
<?= $Page->SIDE_EFFECT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INTERACTION->Visible) { // INTERACTION ?>
    <tr id="r_INTERACTION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_INTERACTION"><?= $Page->INTERACTION->caption() ?></span></td>
        <td data-name="INTERACTION" <?= $Page->INTERACTION->cellAttributes() ?>>
<span id="el_GOODS_INTERACTION">
<span<?= $Page->INTERACTION->viewAttributes() ?>>
<?= $Page->INTERACTION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CONTRA_INDICATION->Visible) { // CONTRA_INDICATION ?>
    <tr id="r_CONTRA_INDICATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_CONTRA_INDICATION"><?= $Page->CONTRA_INDICATION->caption() ?></span></td>
        <td data-name="CONTRA_INDICATION" <?= $Page->CONTRA_INDICATION->cellAttributes() ?>>
<span id="el_GOODS_CONTRA_INDICATION">
<span<?= $Page->CONTRA_INDICATION->viewAttributes() ?>>
<?= $Page->CONTRA_INDICATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->WARNING->Visible) { // WARNING ?>
    <tr id="r_WARNING">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_WARNING"><?= $Page->WARNING->caption() ?></span></td>
        <td data-name="WARNING" <?= $Page->WARNING->cellAttributes() ?>>
<span id="el_GOODS_WARNING">
<span<?= $Page->WARNING->viewAttributes() ?>>
<?= $Page->WARNING->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK->Visible) { // STOCK ?>
    <tr id="r_STOCK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_STOCK"><?= $Page->STOCK->caption() ?></span></td>
        <td data-name="STOCK" <?= $Page->STOCK->cellAttributes() ?>>
<span id="el_GOODS_STOCK">
<span<?= $Page->STOCK->viewAttributes() ?>>
<?= $Page->STOCK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISACTIVE->Visible) { // ISACTIVE ?>
    <tr id="r_ISACTIVE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_ISACTIVE"><?= $Page->ISACTIVE->caption() ?></span></td>
        <td data-name="ISACTIVE" <?= $Page->ISACTIVE->cellAttributes() ?>>
<span id="el_GOODS_ISACTIVE">
<span<?= $Page->ISACTIVE->viewAttributes() ?>>
<?= $Page->ISACTIVE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISALKES->Visible) { // ISALKES ?>
    <tr id="r_ISALKES">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_ISALKES"><?= $Page->ISALKES->caption() ?></span></td>
        <td data-name="ISALKES" <?= $Page->ISALKES->cellAttributes() ?>>
<span id="el_GOODS_ISALKES">
<span<?= $Page->ISALKES->viewAttributes() ?>>
<?= $Page->ISALKES->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->SIZE_ORDER->Visible) { // SIZE_ORDER ?>
    <tr id="r_SIZE_ORDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_SIZE_ORDER"><?= $Page->SIZE_ORDER->caption() ?></span></td>
        <td data-name="SIZE_ORDER" <?= $Page->SIZE_ORDER->cellAttributes() ?>>
<span id="el_GOODS_SIZE_ORDER">
<span<?= $Page->SIZE_ORDER->viewAttributes() ?>>
<?= $Page->SIZE_ORDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
    <tr id="r_ORDER_PRICE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></td>
        <td data-name="ORDER_PRICE" <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el_GOODS_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISFORMULARIUM->Visible) { // ISFORMULARIUM ?>
    <tr id="r_ISFORMULARIUM">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_ISFORMULARIUM"><?= $Page->ISFORMULARIUM->caption() ?></span></td>
        <td data-name="ISFORMULARIUM" <?= $Page->ISFORMULARIUM->cellAttributes() ?>>
<span id="el_GOODS_ISFORMULARIUM">
<span<?= $Page->ISFORMULARIUM->viewAttributes() ?>>
<?= $Page->ISFORMULARIUM->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISESSENTIAL->Visible) { // ISESSENTIAL ?>
    <tr id="r_ISESSENTIAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_ISESSENTIAL"><?= $Page->ISESSENTIAL->caption() ?></span></td>
        <td data-name="ISESSENTIAL" <?= $Page->ISESSENTIAL->cellAttributes() ?>>
<span id="el_GOODS_ISESSENTIAL">
<span<?= $Page->ISESSENTIAL->viewAttributes() ?>>
<?= $Page->ISESSENTIAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AVGDATE->Visible) { // AVGDATE ?>
    <tr id="r_AVGDATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_AVGDATE"><?= $Page->AVGDATE->caption() ?></span></td>
        <td data-name="AVGDATE" <?= $Page->AVGDATE->cellAttributes() ?>>
<span id="el_GOODS_AVGDATE">
<span<?= $Page->AVGDATE->viewAttributes() ?>>
<?= $Page->AVGDATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL->Visible) { // STOCK_MINIMAL ?>
    <tr id="r_STOCK_MINIMAL">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_STOCK_MINIMAL"><?= $Page->STOCK_MINIMAL->caption() ?></span></td>
        <td data-name="STOCK_MINIMAL" <?= $Page->STOCK_MINIMAL->cellAttributes() ?>>
<span id="el_GOODS_STOCK_MINIMAL">
<span<?= $Page->STOCK_MINIMAL->viewAttributes() ?>>
<?= $Page->STOCK_MINIMAL->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL_APT->Visible) { // STOCK_MINIMAL_APT ?>
    <tr id="r_STOCK_MINIMAL_APT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_STOCK_MINIMAL_APT"><?= $Page->STOCK_MINIMAL_APT->caption() ?></span></td>
        <td data-name="STOCK_MINIMAL_APT" <?= $Page->STOCK_MINIMAL_APT->cellAttributes() ?>>
<span id="el_GOODS_STOCK_MINIMAL_APT">
<span<?= $Page->STOCK_MINIMAL_APT->viewAttributes() ?>>
<?= $Page->STOCK_MINIMAL_APT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->HET->Visible) { // HET ?>
    <tr id="r_HET">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_HET"><?= $Page->HET->caption() ?></span></td>
        <td data-name="HET" <?= $Page->HET->cellAttributes() ?>>
<span id="el_GOODS_HET">
<span<?= $Page->HET->viewAttributes() ?>>
<?= $Page->HET->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->default_margin->Visible) { // default_margin ?>
    <tr id="r_default_margin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_GOODS_default_margin"><?= $Page->default_margin->caption() ?></span></td>
        <td data-name="default_margin" <?= $Page->default_margin->cellAttributes() ?>>
<span id="el_GOODS_default_margin">
<span<?= $Page->default_margin->viewAttributes() ?>>
<?= $Page->default_margin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
