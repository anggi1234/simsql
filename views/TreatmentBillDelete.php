<?php

namespace PHPMaker2021\simrs;

// Page object
$TreatmentBillDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fTREATMENT_BILLdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fTREATMENT_BILLdelete = currentForm = new ew.Form("fTREATMENT_BILLdelete", "delete");
    loadjs.done("fTREATMENT_BILLdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.TREATMENT_BILL) ew.vars.tables.TREATMENT_BILL = <?= JsonEncode(GetClientVar("tables", "TREATMENT_BILL")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fTREATMENT_BILLdelete" id="fTREATMENT_BILLdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="TREATMENT_BILL">
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
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <th class="<?= $Page->NO_REGISTRATION->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_NO_REGISTRATION" class="TREATMENT_BILL_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></th>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <th class="<?= $Page->VISIT_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_VISIT_ID" class="TREATMENT_BILL_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <th class="<?= $Page->TARIF_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_TARIF_ID" class="TREATMENT_BILL_TARIF_ID"><?= $Page->TARIF_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <th class="<?= $Page->CLINIC_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_CLINIC_ID" class="TREATMENT_BILL_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <th class="<?= $Page->TREATMENT->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_TREATMENT" class="TREATMENT_BILL_TREATMENT"><?= $Page->TREATMENT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <th class="<?= $Page->TREAT_DATE->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_TREAT_DATE" class="TREATMENT_BILL_TREAT_DATE"><?= $Page->TREAT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th class="<?= $Page->AMOUNT->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_AMOUNT" class="TREATMENT_BILL_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <th class="<?= $Page->QUANTITY->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_QUANTITY" class="TREATMENT_BILL_QUANTITY"><?= $Page->QUANTITY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
        <th class="<?= $Page->ISLUNAS->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_ISLUNAS" class="TREATMENT_BILL_ISLUNAS"><?= $Page->ISLUNAS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <th class="<?= $Page->NOTA_NO->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_NOTA_NO" class="TREATMENT_BILL_NOTA_NO"><?= $Page->NOTA_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <th class="<?= $Page->EMPLOYEE_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_EMPLOYEE_ID" class="TREATMENT_BILL_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <th class="<?= $Page->DOCTOR->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_DOCTOR" class="TREATMENT_BILL_DOCTOR"><?= $Page->DOCTOR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <th class="<?= $Page->amount_paid->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_amount_paid" class="TREATMENT_BILL_amount_paid"><?= $Page->amount_paid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <th class="<?= $Page->THENAME->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_THENAME" class="TREATMENT_BILL_THENAME"><?= $Page->THENAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <th class="<?= $Page->THEADDRESS->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_THEADDRESS" class="TREATMENT_BILL_THEADDRESS"><?= $Page->THEADDRESS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <th class="<?= $Page->THEID->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_THEID" class="TREATMENT_BILL_THEID"><?= $Page->THEID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <th class="<?= $Page->ISRJ->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_ISRJ" class="TREATMENT_BILL_ISRJ"><?= $Page->ISRJ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <th class="<?= $Page->sell_price->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_sell_price" class="TREATMENT_BILL_sell_price"><?= $Page->sell_price->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <th class="<?= $Page->TAGIHAN->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_TAGIHAN" class="TREATMENT_BILL_TAGIHAN"><?= $Page->TAGIHAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
        <th class="<?= $Page->profession->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_profession" class="TREATMENT_BILL_profession"><?= $Page->profession->caption() ?></span></th>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <th class="<?= $Page->TRANS_ID->headerCellClass() ?>"><span id="elh_TREATMENT_BILL_TRANS_ID" class="TREATMENT_BILL_TRANS_ID"><?= $Page->TRANS_ID->caption() ?></span></th>
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
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <td <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_NO_REGISTRATION" class="TREATMENT_BILL_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
        <td <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_VISIT_ID" class="TREATMENT_BILL_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TARIF_ID->Visible) { // TARIF_ID ?>
        <td <?= $Page->TARIF_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_TARIF_ID" class="TREATMENT_BILL_TARIF_ID">
<span<?= $Page->TARIF_ID->viewAttributes() ?>>
<?= $Page->TARIF_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <td <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_CLINIC_ID" class="TREATMENT_BILL_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREATMENT->Visible) { // TREATMENT ?>
        <td <?= $Page->TREATMENT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_TREATMENT" class="TREATMENT_BILL_TREATMENT">
<span<?= $Page->TREATMENT->viewAttributes() ?>>
<?= $Page->TREATMENT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <td <?= $Page->TREAT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_TREAT_DATE" class="TREATMENT_BILL_TREAT_DATE">
<span<?= $Page->TREAT_DATE->viewAttributes() ?>>
<?= $Page->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_AMOUNT" class="TREATMENT_BILL_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->QUANTITY->Visible) { // QUANTITY ?>
        <td <?= $Page->QUANTITY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_QUANTITY" class="TREATMENT_BILL_QUANTITY">
<span<?= $Page->QUANTITY->viewAttributes() ?>>
<?= $Page->QUANTITY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISLUNAS->Visible) { // ISLUNAS ?>
        <td <?= $Page->ISLUNAS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_ISLUNAS" class="TREATMENT_BILL_ISLUNAS">
<span<?= $Page->ISLUNAS->viewAttributes() ?>>
<?= $Page->ISLUNAS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NOTA_NO->Visible) { // NOTA_NO ?>
        <td <?= $Page->NOTA_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_NOTA_NO" class="TREATMENT_BILL_NOTA_NO">
<span<?= $Page->NOTA_NO->viewAttributes() ?>>
<?= $Page->NOTA_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <td <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_EMPLOYEE_ID" class="TREATMENT_BILL_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->DOCTOR->Visible) { // DOCTOR ?>
        <td <?= $Page->DOCTOR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_DOCTOR" class="TREATMENT_BILL_DOCTOR">
<span<?= $Page->DOCTOR->viewAttributes() ?>>
<?= $Page->DOCTOR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amount_paid->Visible) { // amount_paid ?>
        <td <?= $Page->amount_paid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_amount_paid" class="TREATMENT_BILL_amount_paid">
<span<?= $Page->amount_paid->viewAttributes() ?>>
<?= $Page->amount_paid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THENAME->Visible) { // THENAME ?>
        <td <?= $Page->THENAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_THENAME" class="TREATMENT_BILL_THENAME">
<span<?= $Page->THENAME->viewAttributes() ?>>
<?= $Page->THENAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEADDRESS->Visible) { // THEADDRESS ?>
        <td <?= $Page->THEADDRESS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_THEADDRESS" class="TREATMENT_BILL_THEADDRESS">
<span<?= $Page->THEADDRESS->viewAttributes() ?>>
<?= $Page->THEADDRESS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->THEID->Visible) { // THEID ?>
        <td <?= $Page->THEID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_THEID" class="TREATMENT_BILL_THEID">
<span<?= $Page->THEID->viewAttributes() ?>>
<?= $Page->THEID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISRJ->Visible) { // ISRJ ?>
        <td <?= $Page->ISRJ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_ISRJ" class="TREATMENT_BILL_ISRJ">
<span<?= $Page->ISRJ->viewAttributes() ?>>
<?= $Page->ISRJ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sell_price->Visible) { // sell_price ?>
        <td <?= $Page->sell_price->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_sell_price" class="TREATMENT_BILL_sell_price">
<span<?= $Page->sell_price->viewAttributes() ?>>
<?= $Page->sell_price->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TAGIHAN->Visible) { // TAGIHAN ?>
        <td <?= $Page->TAGIHAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_TAGIHAN" class="TREATMENT_BILL_TAGIHAN">
<span<?= $Page->TAGIHAN->viewAttributes() ?>>
<?= $Page->TAGIHAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->profession->Visible) { // profession ?>
        <td <?= $Page->profession->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_profession" class="TREATMENT_BILL_profession">
<span<?= $Page->profession->viewAttributes() ?>>
<?= $Page->profession->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
        <td <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_TREATMENT_BILL_TRANS_ID" class="TREATMENT_BILL_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
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
