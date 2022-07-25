<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$PoInvoiceitemDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fPO_INVOICEITEMdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fPO_INVOICEITEMdelete = currentForm = new ew.Form("fPO_INVOICEITEMdelete", "delete");
    loadjs.done("fPO_INVOICEITEMdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.PO_INVOICEITEM) ew.vars.tables.PO_INVOICEITEM = <?= JsonEncode(GetClientVar("tables", "PO_INVOICEITEM")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fPO_INVOICEITEMdelete" id="fPO_INVOICEITEMdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="PO_INVOICEITEM">
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
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ORG_UNIT_CODE" class="PO_INVOICEITEM_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <th class="<?= $Page->ITEM_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ITEM_ID" class="PO_INVOICEITEM_ITEM_ID"><?= $Page->ITEM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_INVOICE_ID" class="PO_INVOICEITEM_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <th class="<?= $Page->BRAND_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_BRAND_ID" class="PO_INVOICEITEM_BRAND_ID"><?= $Page->BRAND_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <th class="<?= $Page->BRAND_NAME->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_BRAND_NAME" class="PO_INVOICEITEM_BRAND_NAME"><?= $Page->BRAND_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <th class="<?= $Page->ORDER_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ORDER_DATE" class="PO_INVOICEITEM_ORDER_DATE"><?= $Page->ORDER_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <th class="<?= $Page->ATP_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ATP_DATE" class="PO_INVOICEITEM_ATP_DATE"><?= $Page->ATP_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <th class="<?= $Page->DELIVERY_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_DELIVERY_DATE" class="PO_INVOICEITEM_DELIVERY_DATE"><?= $Page->DELIVERY_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <th class="<?= $Page->PO->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_PO" class="PO_INVOICEITEM_PO"><?= $Page->PO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UNIT_PRICE->Visible) { // UNIT_PRICE ?>
        <th class="<?= $Page->UNIT_PRICE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_UNIT_PRICE" class="PO_INVOICEITEM_UNIT_PRICE"><?= $Page->UNIT_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_COMPANY_ID" class="PO_INVOICEITEM_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <th class="<?= $Page->ORDER_QUANTITY->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ORDER_QUANTITY" class="PO_INVOICEITEM_ORDER_QUANTITY"><?= $Page->ORDER_QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <th class="<?= $Page->RECEIVED_QUANTITY->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_RECEIVED_QUANTITY" class="PO_INVOICEITEM_RECEIVED_QUANTITY"><?= $Page->RECEIVED_QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <th class="<?= $Page->DISCOUNT->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_DISCOUNT" class="PO_INVOICEITEM_DISCOUNT"><?= $Page->DISCOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <th class="<?= $Page->DISCOUNT2->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_DISCOUNT2" class="PO_INVOICEITEM_DISCOUNT2"><?= $Page->DISCOUNT2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <th class="<?= $Page->DISCOUNTOFF->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_DISCOUNTOFF" class="PO_INVOICEITEM_DISCOUNTOFF"><?= $Page->DISCOUNTOFF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <th class="<?= $Page->MEASURE_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MEASURE_ID" class="PO_INVOICEITEM_MEASURE_ID"><?= $Page->MEASURE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <th class="<?= $Page->SIZE_GOODS->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_SIZE_GOODS" class="PO_INVOICEITEM_SIZE_GOODS"><?= $Page->SIZE_GOODS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <th class="<?= $Page->MEASURE_DOSIS->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MEASURE_DOSIS" class="PO_INVOICEITEM_MEASURE_DOSIS"><?= $Page->MEASURE_DOSIS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_AMOUNT_PAID" class="PO_INVOICEITEM_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <th class="<?= $Page->ORDER_PRICE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ORDER_PRICE" class="PO_INVOICEITEM_ORDER_PRICE"><?= $Page->ORDER_PRICE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_QUANTITY" class="PO_INVOICEITEM_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <th class="<?= $Page->MEASURE_ID3->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MEASURE_ID3" class="PO_INVOICEITEM_MEASURE_ID3"><?= $Page->MEASURE_ID3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <th class="<?= $Page->SIZE_KEMASAN->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_SIZE_KEMASAN" class="PO_INVOICEITEM_SIZE_KEMASAN"><?= $Page->SIZE_KEMASAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <th class="<?= $Page->MEASURE_ID2->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MEASURE_ID2" class="PO_INVOICEITEM_MEASURE_ID2"><?= $Page->MEASURE_ID2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <th class="<?= $Page->DESCRIPTION->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_DESCRIPTION" class="PO_INVOICEITEM_DESCRIPTION"><?= $Page->DESCRIPTION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MODIFIED_DATE" class="PO_INVOICEITEM_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MODIFIED_BY" class="PO_INVOICEITEM_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_ISCETAK" class="PO_INVOICEITEM_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_PRINT_DATE" class="PO_INVOICEITEM_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_PRINTED_BY" class="PO_INVOICEITEM_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_PRINTQ" class="PO_INVOICEITEM_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <th class="<?= $Page->BATCH_NO->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_BATCH_NO" class="PO_INVOICEITEM_BATCH_NO"><?= $Page->BATCH_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <th class="<?= $Page->SERIAL_NB->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_SERIAL_NB" class="PO_INVOICEITEM_SERIAL_NB"><?= $Page->SERIAL_NB->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <th class="<?= $Page->EXPIRY_DATE->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_EXPIRY_DATE" class="PO_INVOICEITEM_EXPIRY_DATE"><?= $Page->EXPIRY_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <th class="<?= $Page->STATUS_PASIEN_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_STATUS_PASIEN_ID" class="PO_INVOICEITEM_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <th class="<?= $Page->MONTH_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_MONTH_ID" class="PO_INVOICEITEM_MONTH_ID"><?= $Page->MONTH_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th class="<?= $Page->YEAR_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_YEAR_ID" class="PO_INVOICEITEM_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
        <th class="<?= $Page->IDX->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_IDX" class="PO_INVOICEITEM_IDX"><?= $Page->IDX->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_CLINIC_ID" class="PO_INVOICEITEM_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <th class="<?= $Page->PPN->headerCellClass() ?>"><span id="elh_PO_INVOICEITEM_PPN" class="PO_INVOICEITEM_PPN"><?= $Page->PPN->caption() ?></span></th>
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
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <td <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORG_UNIT_CODE" class="PO_INVOICEITEM_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ITEM_ID->Visible) { // ITEM_ID ?>
        <td <?= $Page->ITEM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ITEM_ID" class="PO_INVOICEITEM_ITEM_ID">
<span<?= $Page->ITEM_ID->viewAttributes() ?>>
<?= $Page->ITEM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_INVOICE_ID" class="PO_INVOICEITEM_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_ID->Visible) { // BRAND_ID ?>
        <td <?= $Page->BRAND_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_BRAND_ID" class="PO_INVOICEITEM_BRAND_ID">
<span<?= $Page->BRAND_ID->viewAttributes() ?>>
<?= $Page->BRAND_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BRAND_NAME->Visible) { // BRAND_NAME ?>
        <td <?= $Page->BRAND_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_BRAND_NAME" class="PO_INVOICEITEM_BRAND_NAME">
<span<?= $Page->BRAND_NAME->viewAttributes() ?>>
<?= $Page->BRAND_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_DATE->Visible) { // ORDER_DATE ?>
        <td <?= $Page->ORDER_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORDER_DATE" class="PO_INVOICEITEM_ORDER_DATE">
<span<?= $Page->ORDER_DATE->viewAttributes() ?>>
<?= $Page->ORDER_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ATP_DATE->Visible) { // ATP_DATE ?>
        <td <?= $Page->ATP_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ATP_DATE" class="PO_INVOICEITEM_ATP_DATE">
<span<?= $Page->ATP_DATE->viewAttributes() ?>>
<?= $Page->ATP_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DELIVERY_DATE->Visible) { // DELIVERY_DATE ?>
        <td <?= $Page->DELIVERY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DELIVERY_DATE" class="PO_INVOICEITEM_DELIVERY_DATE">
<span<?= $Page->DELIVERY_DATE->viewAttributes() ?>>
<?= $Page->DELIVERY_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PO->Visible) { // PO ?>
        <td <?= $Page->PO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PO" class="PO_INVOICEITEM_PO">
<span<?= $Page->PO->viewAttributes() ?>>
<?= $Page->PO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->UNIT_PRICE->Visible) { // UNIT_PRICE ?>
        <td <?= $Page->UNIT_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_UNIT_PRICE" class="PO_INVOICEITEM_UNIT_PRICE">
<span<?= $Page->UNIT_PRICE->viewAttributes() ?>>
<?= $Page->UNIT_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_COMPANY_ID" class="PO_INVOICEITEM_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_QUANTITY->Visible) { // ORDER_QUANTITY ?>
        <td <?= $Page->ORDER_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORDER_QUANTITY" class="PO_INVOICEITEM_ORDER_QUANTITY">
<span<?= $Page->ORDER_QUANTITY->viewAttributes() ?>>
<?= $Page->ORDER_QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->RECEIVED_QUANTITY->Visible) { // RECEIVED_QUANTITY ?>
        <td <?= $Page->RECEIVED_QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_RECEIVED_QUANTITY" class="PO_INVOICEITEM_RECEIVED_QUANTITY">
<span<?= $Page->RECEIVED_QUANTITY->viewAttributes() ?>>
<?= $Page->RECEIVED_QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT->Visible) { // DISCOUNT ?>
        <td <?= $Page->DISCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DISCOUNT" class="PO_INVOICEITEM_DISCOUNT">
<span<?= $Page->DISCOUNT->viewAttributes() ?>>
<?= $Page->DISCOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNT2->Visible) { // DISCOUNT2 ?>
        <td <?= $Page->DISCOUNT2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DISCOUNT2" class="PO_INVOICEITEM_DISCOUNT2">
<span<?= $Page->DISCOUNT2->viewAttributes() ?>>
<?= $Page->DISCOUNT2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DISCOUNTOFF->Visible) { // DISCOUNTOFF ?>
        <td <?= $Page->DISCOUNTOFF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DISCOUNTOFF" class="PO_INVOICEITEM_DISCOUNTOFF">
<span<?= $Page->DISCOUNTOFF->viewAttributes() ?>>
<?= $Page->DISCOUNTOFF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID->Visible) { // MEASURE_ID ?>
        <td <?= $Page->MEASURE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_ID" class="PO_INVOICEITEM_MEASURE_ID">
<span<?= $Page->MEASURE_ID->viewAttributes() ?>>
<?= $Page->MEASURE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_GOODS->Visible) { // SIZE_GOODS ?>
        <td <?= $Page->SIZE_GOODS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_SIZE_GOODS" class="PO_INVOICEITEM_SIZE_GOODS">
<span<?= $Page->SIZE_GOODS->viewAttributes() ?>>
<?= $Page->SIZE_GOODS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_DOSIS->Visible) { // MEASURE_DOSIS ?>
        <td <?= $Page->MEASURE_DOSIS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_DOSIS" class="PO_INVOICEITEM_MEASURE_DOSIS">
<span<?= $Page->MEASURE_DOSIS->viewAttributes() ?>>
<?= $Page->MEASURE_DOSIS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_AMOUNT_PAID" class="PO_INVOICEITEM_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORDER_PRICE->Visible) { // ORDER_PRICE ?>
        <td <?= $Page->ORDER_PRICE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ORDER_PRICE" class="PO_INVOICEITEM_ORDER_PRICE">
<span<?= $Page->ORDER_PRICE->viewAttributes() ?>>
<?= $Page->ORDER_PRICE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_QUANTITY" class="PO_INVOICEITEM_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID3->Visible) { // MEASURE_ID3 ?>
        <td <?= $Page->MEASURE_ID3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_ID3" class="PO_INVOICEITEM_MEASURE_ID3">
<span<?= $Page->MEASURE_ID3->viewAttributes() ?>>
<?= $Page->MEASURE_ID3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SIZE_KEMASAN->Visible) { // SIZE_KEMASAN ?>
        <td <?= $Page->SIZE_KEMASAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_SIZE_KEMASAN" class="PO_INVOICEITEM_SIZE_KEMASAN">
<span<?= $Page->SIZE_KEMASAN->viewAttributes() ?>>
<?= $Page->SIZE_KEMASAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MEASURE_ID2->Visible) { // MEASURE_ID2 ?>
        <td <?= $Page->MEASURE_ID2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MEASURE_ID2" class="PO_INVOICEITEM_MEASURE_ID2">
<span<?= $Page->MEASURE_ID2->viewAttributes() ?>>
<?= $Page->MEASURE_ID2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <td <?= $Page->DESCRIPTION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_DESCRIPTION" class="PO_INVOICEITEM_DESCRIPTION">
<span<?= $Page->DESCRIPTION->viewAttributes() ?>>
<?= $Page->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MODIFIED_DATE" class="PO_INVOICEITEM_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MODIFIED_BY" class="PO_INVOICEITEM_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_ISCETAK" class="PO_INVOICEITEM_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PRINT_DATE" class="PO_INVOICEITEM_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PRINTED_BY" class="PO_INVOICEITEM_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PRINTQ" class="PO_INVOICEITEM_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->BATCH_NO->Visible) { // BATCH_NO ?>
        <td <?= $Page->BATCH_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_BATCH_NO" class="PO_INVOICEITEM_BATCH_NO">
<span<?= $Page->BATCH_NO->viewAttributes() ?>>
<?= $Page->BATCH_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->SERIAL_NB->Visible) { // SERIAL_NB ?>
        <td <?= $Page->SERIAL_NB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_SERIAL_NB" class="PO_INVOICEITEM_SERIAL_NB">
<span<?= $Page->SERIAL_NB->viewAttributes() ?>>
<?= $Page->SERIAL_NB->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EXPIRY_DATE->Visible) { // EXPIRY_DATE ?>
        <td <?= $Page->EXPIRY_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_EXPIRY_DATE" class="PO_INVOICEITEM_EXPIRY_DATE">
<span<?= $Page->EXPIRY_DATE->viewAttributes() ?>>
<?= $Page->EXPIRY_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <td <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_STATUS_PASIEN_ID" class="PO_INVOICEITEM_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MONTH_ID->Visible) { // MONTH_ID ?>
        <td <?= $Page->MONTH_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_MONTH_ID" class="PO_INVOICEITEM_MONTH_ID">
<span<?= $Page->MONTH_ID->viewAttributes() ?>>
<?= $Page->MONTH_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_YEAR_ID" class="PO_INVOICEITEM_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IDX->Visible) { // IDX ?>
        <td <?= $Page->IDX->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_IDX" class="PO_INVOICEITEM_IDX">
<span<?= $Page->IDX->viewAttributes() ?>>
<?= $Page->IDX->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_CLINIC_ID" class="PO_INVOICEITEM_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPN->Visible) { // PPN ?>
        <td <?= $Page->PPN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_PO_INVOICEITEM_PPN" class="PO_INVOICEITEM_PPN">
<span<?= $Page->PPN->viewAttributes() ?>>
<?= $Page->PPN->getViewValue() ?></span>
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
