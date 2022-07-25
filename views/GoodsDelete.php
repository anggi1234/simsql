<?php

namespace PHPMaker2021\simrs;

// Page object
$GoodsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fGOODSdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fGOODSdelete = currentForm = new ew.Form("fGOODSdelete", "delete");
    loadjs.done("fGOODSdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.GOODS) ew.vars.tables.GOODS = <?= JsonEncode(GetClientVar("tables", "GOODS")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fGOODSdelete" id="fGOODSdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="GOODS">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->CODE_5->Visible) { // CODE_5 ?>
        <th class="<?= $Page->CODE_5->headerCellClass() ?>"><span id="elh_GOODS_CODE_5" class="GOODS_CODE_5"><?= $Page->CODE_5->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_GOODS_BRAND_ID" class="GOODS_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NAME->Visible) { // NAME ?>
        <th class="<?= $Page->NAME->headerCellClass() ?>"><span id="elh_GOODS_NAME" class="GOODS_NAME"><?= $Page->NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->OTHER_CODE->Visible) { // OTHER_CODE ?>
        <th class="<?= $Page->OTHER_CODE->headerCellClass() ?>"><span id="elh_GOODS_OTHER_CODE" class="GOODS_OTHER_CODE"><?= $Page->OTHER_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_BARCODE->Visible) { // BARCODE ?>
        <th class="<?= $Page->_BARCODE->headerCellClass() ?>"><span id="elh_GOODS__BARCODE" class="GOODS__BARCODE"><?= $Page->_BARCODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_GOODS_DESCRIPTION" class="GOODS_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REORDER_POINT->Visible) { // REORDER_POINT ?>
        <th class="<?= $Page->REORDER_POINT->headerCellClass() ?>"><span id="elh_GOODS_REORDER_POINT" class="GOODS_REORDER_POINT"><?= $Page->REORDER_POINT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><span id="elh_GOODS_SIZE_GOODS" class="GOODS_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><span id="elh_GOODS_MEASURE_DOSIS" class="GOODS_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_GOODS_MEASURE_ID" class="GOODS_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><span id="elh_GOODS_MEASURE_ID2" class="GOODS_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><span id="elh_GOODS_SIZE_KEMASAN" class="GOODS_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><span id="elh_GOODS_MEASURE_ID3" class="GOODS_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><span id="elh_GOODS_COMPANY_ID" class="GOODS_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NET_PRICE->Visible) { // NET_PRICE ?>
        <th class="<?= $Page->NET_PRICE->headerCellClass() ?>"><span id="elh_GOODS_NET_PRICE" class="GOODS_NET_PRICE"><?= $Page->NET_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_GOODS_MODIFIED_DATE" class="GOODS_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_GOODS_MODIFIED_BY" class="GOODS_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TH->Visible) { // TH ?>
        <th class="<?= $Page->TH->headerCellClass() ?>"><span id="elh_GOODS_TH" class="GOODS_TH"><?= $Page->TH->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_GOODS_STATUS_PASIEN_ID" class="GOODS_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MATERIAL_ID->Visible) { // MATERIAL_ID ?>
        <th class="<?= $Page->MATERIAL_ID->headerCellClass() ?>"><span id="elh_GOODS_MATERIAL_ID" class="GOODS_MATERIAL_ID"><?= $Page->MATERIAL_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
        <th class="<?= $Page->FORM_ID->headerCellClass() ?>"><span id="elh_GOODS_FORM_ID" class="GOODS_FORM_ID"><?= $Page->FORM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISGENERIC->Visible) { // ISGENERIC ?>
        <th class="<?= $Page->ISGENERIC->headerCellClass() ?>"><span id="elh_GOODS_ISGENERIC" class="GOODS_ISGENERIC"><?= $Page->ISGENERIC->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REGULATE_ID->Visible) { // REGULATE_ID ?>
        <th class="<?= $Page->REGULATE_ID->headerCellClass() ?>"><span id="elh_GOODS_REGULATE_ID" class="GOODS_REGULATE_ID"><?= $Page->REGULATE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PREGNANCY_INDEX->Visible) { // PREGNANCY_INDEX ?>
        <th class="<?= $Page->PREGNANCY_INDEX->headerCellClass() ?>"><span id="elh_GOODS_PREGNANCY_INDEX" class="GOODS_PREGNANCY_INDEX"><?= $Page->PREGNANCY_INDEX->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INDICATION->Visible) { // INDICATION ?>
        <th class="<?= $Page->INDICATION->headerCellClass() ?>"><span id="elh_GOODS_INDICATION" class="GOODS_INDICATION"><?= $Page->INDICATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TAKE_RULE->Visible) { // TAKE_RULE ?>
        <th class="<?= $Page->TAKE_RULE->headerCellClass() ?>"><span id="elh_GOODS_TAKE_RULE" class="GOODS_TAKE_RULE"><?= $Page->TAKE_RULE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIDE_EFFECT->Visible) { // SIDE_EFFECT ?>
        <th class="<?= $Page->SIDE_EFFECT->headerCellClass() ?>"><span id="elh_GOODS_SIDE_EFFECT" class="GOODS_SIDE_EFFECT"><?= $Page->SIDE_EFFECT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INTERACTION->Visible) { // INTERACTION ?>
        <th class="<?= $Page->INTERACTION->headerCellClass() ?>"><span id="elh_GOODS_INTERACTION" class="GOODS_INTERACTION"><?= $Page->INTERACTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONTRA_INDICATION->Visible) { // CONTRA_INDICATION ?>
        <th class="<?= $Page->CONTRA_INDICATION->headerCellClass() ?>"><span id="elh_GOODS_CONTRA_INDICATION" class="GOODS_CONTRA_INDICATION"><?= $Page->CONTRA_INDICATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->WARNING->Visible) { // WARNING ?>
        <th class="<?= $Page->WARNING->headerCellClass() ?>"><span id="elh_GOODS_WARNING" class="GOODS_WARNING"><?= $Page->WARNING->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK->Visible) { // STOCK ?>
        <th class="<?= $Page->STOCK->headerCellClass() ?>"><span id="elh_GOODS_STOCK" class="GOODS_STOCK"><?= $Page->STOCK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISACTIVE->Visible) { // ISACTIVE ?>
        <th class="<?= $Page->ISACTIVE->headerCellClass() ?>"><span id="elh_GOODS_ISACTIVE" class="GOODS_ISACTIVE"><?= $Page->ISACTIVE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISALKES->Visible) { // ISALKES ?>
        <th class="<?= $Page->ISALKES->headerCellClass() ?>"><span id="elh_GOODS_ISALKES" class="GOODS_ISALKES"><?= $Page->ISALKES->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_ORDER->Visible) { // SIZE_ORDER ?>
        <th class="<?= $Page->SIZE_ORDER->headerCellClass() ?>"><span id="elh_GOODS_SIZE_ORDER" class="GOODS_SIZE_ORDER"><?= $Page->SIZE_ORDER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><span id="elh_GOODS_ORDER_PRICE" class="GOODS_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISFORMULARIUM->Visible) { // ISFORMULARIUM ?>
        <th class="<?= $Page->ISFORMULARIUM->headerCellClass() ?>"><span id="elh_GOODS_ISFORMULARIUM" class="GOODS_ISFORMULARIUM"><?= $Page->ISFORMULARIUM->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISESSENTIAL->Visible) { // ISESSENTIAL ?>
        <th class="<?= $Page->ISESSENTIAL->headerCellClass() ?>"><span id="elh_GOODS_ISESSENTIAL" class="GOODS_ISESSENTIAL"><?= $Page->ISESSENTIAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AVGDATE->Visible) { // AVGDATE ?>
        <th class="<?= $Page->AVGDATE->headerCellClass() ?>"><span id="elh_GOODS_AVGDATE" class="GOODS_AVGDATE"><?= $Page->AVGDATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL->Visible) { // STOCK_MINIMAL ?>
        <th class="<?= $Page->STOCK_MINIMAL->headerCellClass() ?>"><span id="elh_GOODS_STOCK_MINIMAL" class="GOODS_STOCK_MINIMAL"><?= $Page->STOCK_MINIMAL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL_APT->Visible) { // STOCK_MINIMAL_APT ?>
        <th class="<?= $Page->STOCK_MINIMAL_APT->headerCellClass() ?>"><span id="elh_GOODS_STOCK_MINIMAL_APT" class="GOODS_STOCK_MINIMAL_APT"><?= $Page->STOCK_MINIMAL_APT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->HET->Visible) { // HET ?>
        <th class="<?= $Page->HET->headerCellClass() ?>"><span id="elh_GOODS_HET" class="GOODS_HET"><?= $Page->HET->caption() ?></span></th>
<?php } ?>
<?php if ($Page->default_margin->Visible) { // default_margin ?>
        <th class="<?= $Page->default_margin->headerCellClass() ?>"><span id="elh_GOODS_default_margin" class="GOODS_default_margin"><?= $Page->default_margin->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->CODE_5->Visible) { // CODE_5 ?>
        <td <?= $Page->CODE_5->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_CODE_5" class="GOODS_CODE_5">
<span<?= $Page->CODE_5->viewAttributes() ?>>
<?= $Page->CODE_5->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_BRAND_ID" class="GOODS_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NAME->Visible) { // NAME ?>
        <td <?= $Page->NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_NAME" class="GOODS_NAME">
<span<?= $Page->NAME->viewAttributes() ?>>
<?= $Page->NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->OTHER_CODE->Visible) { // OTHER_CODE ?>
        <td <?= $Page->OTHER_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_OTHER_CODE" class="GOODS_OTHER_CODE">
<span<?= $Page->OTHER_CODE->viewAttributes() ?>>
<?= $Page->OTHER_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_BARCODE->Visible) { // BARCODE ?>
        <td <?= $Page->_BARCODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS__BARCODE" class="GOODS__BARCODE">
<span<?= $Page->_BARCODE->viewAttributes() ?>>
<?= $Page->_BARCODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_DESCRIPTION" class="GOODS_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REORDER_POINT->Visible) { // REORDER_POINT ?>
        <td <?= $Page->REORDER_POINT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_REORDER_POINT" class="GOODS_REORDER_POINT">
<span<?= $Page->REORDER_POINT->viewAttributes() ?>>
<?= $Page->REORDER_POINT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIZE_GOODS" class="GOODS_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_DOSIS" class="GOODS_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_ID" class="GOODS_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_ID2" class="GOODS_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIZE_KEMASAN" class="GOODS_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MEASURE_ID3" class="GOODS_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_COMPANY_ID" class="GOODS_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NET_PRICE->Visible) { // NET_PRICE ?>
        <td <?= $Page->NET_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_NET_PRICE" class="GOODS_NET_PRICE">
<span<?= $Page->NET_PRICE->viewAttributes() ?>>
<?= $Page->NET_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MODIFIED_DATE" class="GOODS_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MODIFIED_BY" class="GOODS_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TH->Visible) { // TH ?>
        <td <?= $Page->TH->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_TH" class="GOODS_TH">
<span<?= $Page->TH->viewAttributes() ?>>
<?= $Page->TH->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STATUS_PASIEN_ID" class="GOODS_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MATERIAL_ID->Visible) { // MATERIAL_ID ?>
        <td <?= $Page->MATERIAL_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_MATERIAL_ID" class="GOODS_MATERIAL_ID">
<span<?= $Page->MATERIAL_ID->viewAttributes() ?>>
<?= $Page->MATERIAL_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->FORM_ID->Visible) { // FORM_ID ?>
        <td <?= $Page->FORM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_FORM_ID" class="GOODS_FORM_ID">
<span<?= $Page->FORM_ID->viewAttributes() ?>>
<?= $Page->FORM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISGENERIC->Visible) { // ISGENERIC ?>
        <td <?= $Page->ISGENERIC->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISGENERIC" class="GOODS_ISGENERIC">
<span<?= $Page->ISGENERIC->viewAttributes() ?>>
<?= $Page->ISGENERIC->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REGULATE_ID->Visible) { // REGULATE_ID ?>
        <td <?= $Page->REGULATE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_REGULATE_ID" class="GOODS_REGULATE_ID">
<span<?= $Page->REGULATE_ID->viewAttributes() ?>>
<?= $Page->REGULATE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PREGNANCY_INDEX->Visible) { // PREGNANCY_INDEX ?>
        <td <?= $Page->PREGNANCY_INDEX->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_PREGNANCY_INDEX" class="GOODS_PREGNANCY_INDEX">
<span<?= $Page->PREGNANCY_INDEX->viewAttributes() ?>>
<?= $Page->PREGNANCY_INDEX->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INDICATION->Visible) { // INDICATION ?>
        <td <?= $Page->INDICATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_INDICATION" class="GOODS_INDICATION">
<span<?= $Page->INDICATION->viewAttributes() ?>>
<?= $Page->INDICATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TAKE_RULE->Visible) { // TAKE_RULE ?>
        <td <?= $Page->TAKE_RULE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_TAKE_RULE" class="GOODS_TAKE_RULE">
<span<?= $Page->TAKE_RULE->viewAttributes() ?>>
<?= $Page->TAKE_RULE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIDE_EFFECT->Visible) { // SIDE_EFFECT ?>
        <td <?= $Page->SIDE_EFFECT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIDE_EFFECT" class="GOODS_SIDE_EFFECT">
<span<?= $Page->SIDE_EFFECT->viewAttributes() ?>>
<?= $Page->SIDE_EFFECT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INTERACTION->Visible) { // INTERACTION ?>
        <td <?= $Page->INTERACTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_INTERACTION" class="GOODS_INTERACTION">
<span<?= $Page->INTERACTION->viewAttributes() ?>>
<?= $Page->INTERACTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONTRA_INDICATION->Visible) { // CONTRA_INDICATION ?>
        <td <?= $Page->CONTRA_INDICATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_CONTRA_INDICATION" class="GOODS_CONTRA_INDICATION">
<span<?= $Page->CONTRA_INDICATION->viewAttributes() ?>>
<?= $Page->CONTRA_INDICATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->WARNING->Visible) { // WARNING ?>
        <td <?= $Page->WARNING->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_WARNING" class="GOODS_WARNING">
<span<?= $Page->WARNING->viewAttributes() ?>>
<?= $Page->WARNING->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK->Visible) { // STOCK ?>
        <td <?= $Page->STOCK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STOCK" class="GOODS_STOCK">
<span<?= $Page->STOCK->viewAttributes() ?>>
<?= $Page->STOCK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISACTIVE->Visible) { // ISACTIVE ?>
        <td <?= $Page->ISACTIVE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISACTIVE" class="GOODS_ISACTIVE">
<span<?= $Page->ISACTIVE->viewAttributes() ?>>
<?= $Page->ISACTIVE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISALKES->Visible) { // ISALKES ?>
        <td <?= $Page->ISALKES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISALKES" class="GOODS_ISALKES">
<span<?= $Page->ISALKES->viewAttributes() ?>>
<?= $Page->ISALKES->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_ORDER->Visible) { // SIZE_ORDER ?>
        <td <?= $Page->SIZE_ORDER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_SIZE_ORDER" class="GOODS_SIZE_ORDER">
<span<?= $Page->SIZE_ORDER->viewAttributes() ?>>
<?= $Page->SIZE_ORDER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ORDER_PRICE" class="GOODS_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISFORMULARIUM->Visible) { // ISFORMULARIUM ?>
        <td <?= $Page->ISFORMULARIUM->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISFORMULARIUM" class="GOODS_ISFORMULARIUM">
<span<?= $Page->ISFORMULARIUM->viewAttributes() ?>>
<?= $Page->ISFORMULARIUM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISESSENTIAL->Visible) { // ISESSENTIAL ?>
        <td <?= $Page->ISESSENTIAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_ISESSENTIAL" class="GOODS_ISESSENTIAL">
<span<?= $Page->ISESSENTIAL->viewAttributes() ?>>
<?= $Page->ISESSENTIAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AVGDATE->Visible) { // AVGDATE ?>
        <td <?= $Page->AVGDATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_AVGDATE" class="GOODS_AVGDATE">
<span<?= $Page->AVGDATE->viewAttributes() ?>>
<?= $Page->AVGDATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL->Visible) { // STOCK_MINIMAL ?>
        <td <?= $Page->STOCK_MINIMAL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STOCK_MINIMAL" class="GOODS_STOCK_MINIMAL">
<span<?= $Page->STOCK_MINIMAL->viewAttributes() ?>>
<?= $Page->STOCK_MINIMAL->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STOCK_MINIMAL_APT->Visible) { // STOCK_MINIMAL_APT ?>
        <td <?= $Page->STOCK_MINIMAL_APT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_STOCK_MINIMAL_APT" class="GOODS_STOCK_MINIMAL_APT">
<span<?= $Page->STOCK_MINIMAL_APT->viewAttributes() ?>>
<?= $Page->STOCK_MINIMAL_APT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->HET->Visible) { // HET ?>
        <td <?= $Page->HET->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_HET" class="GOODS_HET">
<span<?= $Page->HET->viewAttributes() ?>>
<?= $Page->HET->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->default_margin->Visible) { // default_margin ?>
        <td <?= $Page->default_margin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_GOODS_default_margin" class="GOODS_default_margin">
<span<?= $Page->default_margin->viewAttributes() ?>>
<?= $Page->default_margin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
