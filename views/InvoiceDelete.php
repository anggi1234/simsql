<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$InvoiceDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fINVOICEdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fINVOICEdelete = currentForm = new ew.Form("fINVOICEdelete", "delete");
    loadjs.done("fINVOICEdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.INVOICE) ew.vars.tables.INVOICE = <?= JsonEncode(GetClientVar("tables", "INVOICE")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fINVOICEdelete" id="fINVOICEdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="INVOICE">
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
        <th class="<?= $Page->ORG_UNIT_CODE->headerCellClass() ?>"><span id="elh_INVOICE_ORG_UNIT_CODE" class="INVOICE_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <th class="<?= $Page->INVOICE_ID->headerCellClass() ?>"><span id="elh_INVOICE_INVOICE_ID" class="INVOICE_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
        <th class="<?= $Page->INVOICE_TYPE->headerCellClass() ?>"><span id="elh_INVOICE_INVOICE_TYPE" class="INVOICE_INVOICE_TYPE"><?= $Page->INVOICE_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
        <th class="<?= $Page->INVOICE_NO->headerCellClass() ?>"><span id="elh_INVOICE_INVOICE_NO" class="INVOICE_INVOICE_NO"><?= $Page->INVOICE_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
        <th class="<?= $Page->INV_COUNTER->headerCellClass() ?>"><span id="elh_INVOICE_INV_COUNTER" class="INVOICE_INV_COUNTER"><?= $Page->INV_COUNTER->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
        <th class="<?= $Page->INV_DATE->headerCellClass() ?>"><span id="elh_INVOICE_INV_DATE" class="INVOICE_INV_DATE"><?= $Page->INV_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
        <th class="<?= $Page->INVOICE_TRANS->headerCellClass() ?>"><span id="elh_INVOICE_INVOICE_TRANS" class="INVOICE_INVOICE_TRANS"><?= $Page->INVOICE_TRANS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
        <th class="<?= $Page->INVOICE_DUE->headerCellClass() ?>"><span id="elh_INVOICE_INVOICE_DUE" class="INVOICE_INVOICE_DUE"><?= $Page->INVOICE_DUE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
        <th class="<?= $Page->REF_TYPE->headerCellClass() ?>"><span id="elh_INVOICE_REF_TYPE" class="INVOICE_REF_TYPE"><?= $Page->REF_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REF_NO->Visible) { // REF_NO ?>
        <th class="<?= $Page->REF_NO->headerCellClass() ?>"><span id="elh_INVOICE_REF_NO" class="INVOICE_REF_NO"><?= $Page->REF_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
        <th class="<?= $Page->REF_NO2->headerCellClass() ?>"><span id="elh_INVOICE_REF_NO2" class="INVOICE_REF_NO2"><?= $Page->REF_NO2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
        <th class="<?= $Page->REF_DATE->headerCellClass() ?>"><span id="elh_INVOICE_REF_DATE" class="INVOICE_REF_DATE"><?= $Page->REF_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <th class="<?= $Page->ACCOUNT_ID->headerCellClass() ?>"><span id="elh_INVOICE_ACCOUNT_ID" class="INVOICE_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <th class="<?= $Page->YEAR_ID->headerCellClass() ?>"><span id="elh_INVOICE_YEAR_ID" class="INVOICE_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <th class="<?= $Page->ORG_ID->headerCellClass() ?>"><span id="elh_INVOICE_ORG_ID" class="INVOICE_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
        <th class="<?= $Page->PROGRAM_ID->headerCellClass() ?>"><span id="elh_INVOICE_PROGRAM_ID" class="INVOICE_PROGRAM_ID"><?= $Page->PROGRAM_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
        <th class="<?= $Page->PROGRAMS->headerCellClass() ?>"><span id="elh_INVOICE_PROGRAMS" class="INVOICE_PROGRAMS"><?= $Page->PROGRAMS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
        <th class="<?= $Page->PACTIVITY_ID->headerCellClass() ?>"><span id="elh_INVOICE_PACTIVITY_ID" class="INVOICE_PACTIVITY_ID"><?= $Page->PACTIVITY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
        <th class="<?= $Page->ACTIVITY_ID->headerCellClass() ?>"><span id="elh_INVOICE_ACTIVITY_ID" class="INVOICE_ACTIVITY_ID"><?= $Page->ACTIVITY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
        <th class="<?= $Page->ACTIVITY_NAME->headerCellClass() ?>"><span id="elh_INVOICE_ACTIVITY_NAME" class="INVOICE_ACTIVITY_NAME"><?= $Page->ACTIVITY_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
        <th class="<?= $Page->KEPERLUAN->headerCellClass() ?>"><span id="elh_INVOICE_KEPERLUAN" class="INVOICE_KEPERLUAN"><?= $Page->KEPERLUAN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPTK->Visible) { // PPTK ?>
        <th class="<?= $Page->PPTK->headerCellClass() ?>"><span id="elh_INVOICE_PPTK" class="INVOICE_PPTK"><?= $Page->PPTK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
        <th class="<?= $Page->PPTK_NAME->headerCellClass() ?>"><span id="elh_INVOICE_PPTK_NAME" class="INVOICE_PPTK_NAME"><?= $Page->PPTK_NAME->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <th class="<?= $Page->COMPANY_ID->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_ID" class="INVOICE_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
        <th class="<?= $Page->COMPANY_TO->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_TO" class="INVOICE_COMPANY_TO"><?= $Page->COMPANY_TO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
        <th class="<?= $Page->COMPANY_TYPE->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_TYPE" class="INVOICE_COMPANY_TYPE"><?= $Page->COMPANY_TYPE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY->Visible) { // COMPANY ?>
        <th class="<?= $Page->COMPANY->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY" class="INVOICE_COMPANY"><?= $Page->COMPANY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
        <th class="<?= $Page->COMPANY_CHIEF->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_CHIEF" class="INVOICE_COMPANY_CHIEF"><?= $Page->COMPANY_CHIEF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
        <th class="<?= $Page->COMPANY_INFO->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_INFO" class="INVOICE_COMPANY_INFO"><?= $Page->COMPANY_INFO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <th class="<?= $Page->CONTRACT_NO->headerCellClass() ?>"><span id="elh_INVOICE_CONTRACT_NO" class="INVOICE_CONTRACT_NO"><?= $Page->CONTRACT_NO->caption() ?></span></th>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <th class="<?= $Page->NPWP->headerCellClass() ?>"><span id="elh_INVOICE_NPWP" class="INVOICE_NPWP"><?= $Page->NPWP->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
        <th class="<?= $Page->COMPANY_BANK->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_BANK" class="INVOICE_COMPANY_BANK"><?= $Page->COMPANY_BANK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
        <th class="<?= $Page->COMPANY_ACCOUNT->headerCellClass() ?>"><span id="elh_INVOICE_COMPANY_ACCOUNT" class="INVOICE_COMPANY_ACCOUNT"><?= $Page->COMPANY_ACCOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAGU->Visible) { // PAGU ?>
        <th class="<?= $Page->PAGU->headerCellClass() ?>"><span id="elh_INVOICE_PAGU" class="INVOICE_PAGU"><?= $Page->PAGU->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
        <th class="<?= $Page->PAGU_REALISASI->headerCellClass() ?>"><span id="elh_INVOICE_PAGU_REALISASI" class="INVOICE_PAGU_REALISASI"><?= $Page->PAGU_REALISASI->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <th class="<?= $Page->AMOUNT->headerCellClass() ?>"><span id="elh_INVOICE_AMOUNT" class="INVOICE_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <th class="<?= $Page->AMOUNT_PAID->headerCellClass() ?>"><span id="elh_INVOICE_AMOUNT_PAID" class="INVOICE_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
        <th class="<?= $Page->PAYMENT_INSTRUCTIONS->headerCellClass() ?>"><span id="elh_INVOICE_PAYMENT_INSTRUCTIONS" class="INVOICE_PAYMENT_INSTRUCTIONS"><?= $Page->PAYMENT_INSTRUCTIONS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
        <th class="<?= $Page->ISAPPROVED->headerCellClass() ?>"><span id="elh_INVOICE_ISAPPROVED" class="INVOICE_ISAPPROVED"><?= $Page->ISAPPROVED->caption() ?></span></th>
<?php } ?>
<?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
        <th class="<?= $Page->APPROVED_BY->headerCellClass() ?>"><span id="elh_INVOICE_APPROVED_BY" class="INVOICE_APPROVED_BY"><?= $Page->APPROVED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
        <th class="<?= $Page->APPROVED_DATE->headerCellClass() ?>"><span id="elh_INVOICE_APPROVED_DATE" class="INVOICE_APPROVED_DATE"><?= $Page->APPROVED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <th class="<?= $Page->ISCETAK->headerCellClass() ?>"><span id="elh_INVOICE_ISCETAK" class="INVOICE_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <th class="<?= $Page->PRINTQ->headerCellClass() ?>"><span id="elh_INVOICE_PRINTQ" class="INVOICE_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <th class="<?= $Page->PRINT_DATE->headerCellClass() ?>"><span id="elh_INVOICE_PRINT_DATE" class="INVOICE_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <th class="<?= $Page->PRINTED_BY->headerCellClass() ?>"><span id="elh_INVOICE_PRINTED_BY" class="INVOICE_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <th class="<?= $Page->MODIFIED_DATE->headerCellClass() ?>"><span id="elh_INVOICE_MODIFIED_DATE" class="INVOICE_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <th class="<?= $Page->MODIFIED_BY->headerCellClass() ?>"><span id="elh_INVOICE_MODIFIED_BY" class="INVOICE_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
        <th class="<?= $Page->PPTK_TITLE->headerCellClass() ?>"><span id="elh_INVOICE_PPTK_TITLE" class="INVOICE_PPTK_TITLE"><?= $Page->PPTK_TITLE->caption() ?></span></th>
<?php } ?>
<?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
        <th class="<?= $Page->APPROVED_ID->headerCellClass() ?>"><span id="elh_INVOICE_APPROVED_ID" class="INVOICE_APPROVED_ID"><?= $Page->APPROVED_ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
        <th class="<?= $Page->APPROVED_TITLE->headerCellClass() ?>"><span id="elh_INVOICE_APPROVED_TITLE" class="INVOICE_APPROVED_TITLE"><?= $Page->APPROVED_TITLE->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_UNIT_CODE" class="INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
        <td <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_ID" class="INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
        <td <?= $Page->INVOICE_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TYPE" class="INVOICE_INVOICE_TYPE">
<span<?= $Page->INVOICE_TYPE->viewAttributes() ?>>
<?= $Page->INVOICE_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
        <td <?= $Page->INVOICE_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_NO" class="INVOICE_INVOICE_NO">
<span<?= $Page->INVOICE_NO->viewAttributes() ?>>
<?= $Page->INVOICE_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
        <td <?= $Page->INV_COUNTER->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_COUNTER" class="INVOICE_INV_COUNTER">
<span<?= $Page->INV_COUNTER->viewAttributes() ?>>
<?= $Page->INV_COUNTER->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
        <td <?= $Page->INV_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INV_DATE" class="INVOICE_INV_DATE">
<span<?= $Page->INV_DATE->viewAttributes() ?>>
<?= $Page->INV_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
        <td <?= $Page->INVOICE_TRANS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_TRANS" class="INVOICE_INVOICE_TRANS">
<span<?= $Page->INVOICE_TRANS->viewAttributes() ?>>
<?= $Page->INVOICE_TRANS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
        <td <?= $Page->INVOICE_DUE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_INVOICE_DUE" class="INVOICE_INVOICE_DUE">
<span<?= $Page->INVOICE_DUE->viewAttributes() ?>>
<?= $Page->INVOICE_DUE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
        <td <?= $Page->REF_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_TYPE" class="INVOICE_REF_TYPE">
<span<?= $Page->REF_TYPE->viewAttributes() ?>>
<?= $Page->REF_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REF_NO->Visible) { // REF_NO ?>
        <td <?= $Page->REF_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO" class="INVOICE_REF_NO">
<span<?= $Page->REF_NO->viewAttributes() ?>>
<?= $Page->REF_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
        <td <?= $Page->REF_NO2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_NO2" class="INVOICE_REF_NO2">
<span<?= $Page->REF_NO2->viewAttributes() ?>>
<?= $Page->REF_NO2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
        <td <?= $Page->REF_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_REF_DATE" class="INVOICE_REF_DATE">
<span<?= $Page->REF_DATE->viewAttributes() ?>>
<?= $Page->REF_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
        <td <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACCOUNT_ID" class="INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
        <td <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_YEAR_ID" class="INVOICE_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
        <td <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ORG_ID" class="INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
        <td <?= $Page->PROGRAM_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAM_ID" class="INVOICE_PROGRAM_ID">
<span<?= $Page->PROGRAM_ID->viewAttributes() ?>>
<?= $Page->PROGRAM_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
        <td <?= $Page->PROGRAMS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PROGRAMS" class="INVOICE_PROGRAMS">
<span<?= $Page->PROGRAMS->viewAttributes() ?>>
<?= $Page->PROGRAMS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
        <td <?= $Page->PACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PACTIVITY_ID" class="INVOICE_PACTIVITY_ID">
<span<?= $Page->PACTIVITY_ID->viewAttributes() ?>>
<?= $Page->PACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
        <td <?= $Page->ACTIVITY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_ID" class="INVOICE_ACTIVITY_ID">
<span<?= $Page->ACTIVITY_ID->viewAttributes() ?>>
<?= $Page->ACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
        <td <?= $Page->ACTIVITY_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ACTIVITY_NAME" class="INVOICE_ACTIVITY_NAME">
<span<?= $Page->ACTIVITY_NAME->viewAttributes() ?>>
<?= $Page->ACTIVITY_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
        <td <?= $Page->KEPERLUAN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_KEPERLUAN" class="INVOICE_KEPERLUAN">
<span<?= $Page->KEPERLUAN->viewAttributes() ?>>
<?= $Page->KEPERLUAN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPTK->Visible) { // PPTK ?>
        <td <?= $Page->PPTK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK" class="INVOICE_PPTK">
<span<?= $Page->PPTK->viewAttributes() ?>>
<?= $Page->PPTK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
        <td <?= $Page->PPTK_NAME->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_NAME" class="INVOICE_PPTK_NAME">
<span<?= $Page->PPTK_NAME->viewAttributes() ?>>
<?= $Page->PPTK_NAME->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
        <td <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ID" class="INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
        <td <?= $Page->COMPANY_TO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TO" class="INVOICE_COMPANY_TO">
<span<?= $Page->COMPANY_TO->viewAttributes() ?>>
<?= $Page->COMPANY_TO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
        <td <?= $Page->COMPANY_TYPE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_TYPE" class="INVOICE_COMPANY_TYPE">
<span<?= $Page->COMPANY_TYPE->viewAttributes() ?>>
<?= $Page->COMPANY_TYPE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY->Visible) { // COMPANY ?>
        <td <?= $Page->COMPANY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY" class="INVOICE_COMPANY">
<span<?= $Page->COMPANY->viewAttributes() ?>>
<?= $Page->COMPANY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
        <td <?= $Page->COMPANY_CHIEF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_CHIEF" class="INVOICE_COMPANY_CHIEF">
<span<?= $Page->COMPANY_CHIEF->viewAttributes() ?>>
<?= $Page->COMPANY_CHIEF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
        <td <?= $Page->COMPANY_INFO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_INFO" class="INVOICE_COMPANY_INFO">
<span<?= $Page->COMPANY_INFO->viewAttributes() ?>>
<?= $Page->COMPANY_INFO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
        <td <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_CONTRACT_NO" class="INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
        <td <?= $Page->NPWP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_NPWP" class="INVOICE_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
        <td <?= $Page->COMPANY_BANK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_BANK" class="INVOICE_COMPANY_BANK">
<span<?= $Page->COMPANY_BANK->viewAttributes() ?>>
<?= $Page->COMPANY_BANK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
        <td <?= $Page->COMPANY_ACCOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_COMPANY_ACCOUNT" class="INVOICE_COMPANY_ACCOUNT">
<span<?= $Page->COMPANY_ACCOUNT->viewAttributes() ?>>
<?= $Page->COMPANY_ACCOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAGU->Visible) { // PAGU ?>
        <td <?= $Page->PAGU->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU" class="INVOICE_PAGU">
<span<?= $Page->PAGU->viewAttributes() ?>>
<?= $Page->PAGU->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
        <td <?= $Page->PAGU_REALISASI->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAGU_REALISASI" class="INVOICE_PAGU_REALISASI">
<span<?= $Page->PAGU_REALISASI->viewAttributes() ?>>
<?= $Page->PAGU_REALISASI->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
        <td <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT" class="INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
        <td <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_AMOUNT_PAID" class="INVOICE_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
        <td <?= $Page->PAYMENT_INSTRUCTIONS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PAYMENT_INSTRUCTIONS" class="INVOICE_PAYMENT_INSTRUCTIONS">
<span<?= $Page->PAYMENT_INSTRUCTIONS->viewAttributes() ?>>
<?= $Page->PAYMENT_INSTRUCTIONS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
        <td <?= $Page->ISAPPROVED->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISAPPROVED" class="INVOICE_ISAPPROVED">
<span<?= $Page->ISAPPROVED->viewAttributes() ?>>
<?= $Page->ISAPPROVED->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
        <td <?= $Page->APPROVED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_BY" class="INVOICE_APPROVED_BY">
<span<?= $Page->APPROVED_BY->viewAttributes() ?>>
<?= $Page->APPROVED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
        <td <?= $Page->APPROVED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_DATE" class="INVOICE_APPROVED_DATE">
<span<?= $Page->APPROVED_DATE->viewAttributes() ?>>
<?= $Page->APPROVED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
        <td <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_ISCETAK" class="INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
        <td <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTQ" class="INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
        <td <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINT_DATE" class="INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
        <td <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PRINTED_BY" class="INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
        <td <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_DATE" class="INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
        <td <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_MODIFIED_BY" class="INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
        <td <?= $Page->PPTK_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_PPTK_TITLE" class="INVOICE_PPTK_TITLE">
<span<?= $Page->PPTK_TITLE->viewAttributes() ?>>
<?= $Page->PPTK_TITLE->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
        <td <?= $Page->APPROVED_ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_ID" class="INVOICE_APPROVED_ID">
<span<?= $Page->APPROVED_ID->viewAttributes() ?>>
<?= $Page->APPROVED_ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
        <td <?= $Page->APPROVED_TITLE->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_INVOICE_APPROVED_TITLE" class="INVOICE_APPROVED_TITLE">
<span<?= $Page->APPROVED_TITLE->viewAttributes() ?>>
<?= $Page->APPROVED_TITLE->getViewValue() ?></span>
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
