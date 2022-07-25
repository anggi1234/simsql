<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Page object
$InvoiceView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fINVOICEview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fINVOICEview = currentForm = new ew.Form("fINVOICEview", "view");
    loadjs.done("fINVOICEview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.INVOICE) ew.vars.tables.INVOICE = <?= JsonEncode(GetClientVar("tables", "INVOICE")) ?>;
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
<form name="fINVOICEview" id="fINVOICEview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="INVOICE">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-bordered table-hover ew-view-table">
<?php if ($Page->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
    <tr id="r_ORG_UNIT_CODE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ORG_UNIT_CODE"><?= $Page->ORG_UNIT_CODE->caption() ?></span></td>
        <td data-name="ORG_UNIT_CODE" <?= $Page->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_INVOICE_ORG_UNIT_CODE">
<span<?= $Page->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $Page->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_ID->Visible) { // INVOICE_ID ?>
    <tr id="r_INVOICE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INVOICE_ID"><?= $Page->INVOICE_ID->caption() ?></span></td>
        <td data-name="INVOICE_ID" <?= $Page->INVOICE_ID->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_ID">
<span<?= $Page->INVOICE_ID->viewAttributes() ?>>
<?= $Page->INVOICE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_TYPE->Visible) { // INVOICE_TYPE ?>
    <tr id="r_INVOICE_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INVOICE_TYPE"><?= $Page->INVOICE_TYPE->caption() ?></span></td>
        <td data-name="INVOICE_TYPE" <?= $Page->INVOICE_TYPE->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_TYPE">
<span<?= $Page->INVOICE_TYPE->viewAttributes() ?>>
<?= $Page->INVOICE_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_NO->Visible) { // INVOICE_NO ?>
    <tr id="r_INVOICE_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INVOICE_NO"><?= $Page->INVOICE_NO->caption() ?></span></td>
        <td data-name="INVOICE_NO" <?= $Page->INVOICE_NO->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_NO">
<span<?= $Page->INVOICE_NO->viewAttributes() ?>>
<?= $Page->INVOICE_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INV_COUNTER->Visible) { // INV_COUNTER ?>
    <tr id="r_INV_COUNTER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INV_COUNTER"><?= $Page->INV_COUNTER->caption() ?></span></td>
        <td data-name="INV_COUNTER" <?= $Page->INV_COUNTER->cellAttributes() ?>>
<span id="el_INVOICE_INV_COUNTER">
<span<?= $Page->INV_COUNTER->viewAttributes() ?>>
<?= $Page->INV_COUNTER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INV_DATE->Visible) { // INV_DATE ?>
    <tr id="r_INV_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INV_DATE"><?= $Page->INV_DATE->caption() ?></span></td>
        <td data-name="INV_DATE" <?= $Page->INV_DATE->cellAttributes() ?>>
<span id="el_INVOICE_INV_DATE">
<span<?= $Page->INV_DATE->viewAttributes() ?>>
<?= $Page->INV_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_TRANS->Visible) { // INVOICE_TRANS ?>
    <tr id="r_INVOICE_TRANS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INVOICE_TRANS"><?= $Page->INVOICE_TRANS->caption() ?></span></td>
        <td data-name="INVOICE_TRANS" <?= $Page->INVOICE_TRANS->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_TRANS">
<span<?= $Page->INVOICE_TRANS->viewAttributes() ?>>
<?= $Page->INVOICE_TRANS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->INVOICE_DUE->Visible) { // INVOICE_DUE ?>
    <tr id="r_INVOICE_DUE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_INVOICE_DUE"><?= $Page->INVOICE_DUE->caption() ?></span></td>
        <td data-name="INVOICE_DUE" <?= $Page->INVOICE_DUE->cellAttributes() ?>>
<span id="el_INVOICE_INVOICE_DUE">
<span<?= $Page->INVOICE_DUE->viewAttributes() ?>>
<?= $Page->INVOICE_DUE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REF_TYPE->Visible) { // REF_TYPE ?>
    <tr id="r_REF_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_REF_TYPE"><?= $Page->REF_TYPE->caption() ?></span></td>
        <td data-name="REF_TYPE" <?= $Page->REF_TYPE->cellAttributes() ?>>
<span id="el_INVOICE_REF_TYPE">
<span<?= $Page->REF_TYPE->viewAttributes() ?>>
<?= $Page->REF_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REF_NO->Visible) { // REF_NO ?>
    <tr id="r_REF_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_REF_NO"><?= $Page->REF_NO->caption() ?></span></td>
        <td data-name="REF_NO" <?= $Page->REF_NO->cellAttributes() ?>>
<span id="el_INVOICE_REF_NO">
<span<?= $Page->REF_NO->viewAttributes() ?>>
<?= $Page->REF_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REF_NO2->Visible) { // REF_NO2 ?>
    <tr id="r_REF_NO2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_REF_NO2"><?= $Page->REF_NO2->caption() ?></span></td>
        <td data-name="REF_NO2" <?= $Page->REF_NO2->cellAttributes() ?>>
<span id="el_INVOICE_REF_NO2">
<span<?= $Page->REF_NO2->viewAttributes() ?>>
<?= $Page->REF_NO2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->REF_DATE->Visible) { // REF_DATE ?>
    <tr id="r_REF_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_REF_DATE"><?= $Page->REF_DATE->caption() ?></span></td>
        <td data-name="REF_DATE" <?= $Page->REF_DATE->cellAttributes() ?>>
<span id="el_INVOICE_REF_DATE">
<span<?= $Page->REF_DATE->viewAttributes() ?>>
<?= $Page->REF_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACCOUNT_ID->Visible) { // ACCOUNT_ID ?>
    <tr id="r_ACCOUNT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ACCOUNT_ID"><?= $Page->ACCOUNT_ID->caption() ?></span></td>
        <td data-name="ACCOUNT_ID" <?= $Page->ACCOUNT_ID->cellAttributes() ?>>
<span id="el_INVOICE_ACCOUNT_ID">
<span<?= $Page->ACCOUNT_ID->viewAttributes() ?>>
<?= $Page->ACCOUNT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->YEAR_ID->Visible) { // YEAR_ID ?>
    <tr id="r_YEAR_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_YEAR_ID"><?= $Page->YEAR_ID->caption() ?></span></td>
        <td data-name="YEAR_ID" <?= $Page->YEAR_ID->cellAttributes() ?>>
<span id="el_INVOICE_YEAR_ID">
<span<?= $Page->YEAR_ID->viewAttributes() ?>>
<?= $Page->YEAR_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ORG_ID->Visible) { // ORG_ID ?>
    <tr id="r_ORG_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ORG_ID"><?= $Page->ORG_ID->caption() ?></span></td>
        <td data-name="ORG_ID" <?= $Page->ORG_ID->cellAttributes() ?>>
<span id="el_INVOICE_ORG_ID">
<span<?= $Page->ORG_ID->viewAttributes() ?>>
<?= $Page->ORG_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PROGRAM_ID->Visible) { // PROGRAM_ID ?>
    <tr id="r_PROGRAM_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PROGRAM_ID"><?= $Page->PROGRAM_ID->caption() ?></span></td>
        <td data-name="PROGRAM_ID" <?= $Page->PROGRAM_ID->cellAttributes() ?>>
<span id="el_INVOICE_PROGRAM_ID">
<span<?= $Page->PROGRAM_ID->viewAttributes() ?>>
<?= $Page->PROGRAM_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PROGRAMS->Visible) { // PROGRAMS ?>
    <tr id="r_PROGRAMS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PROGRAMS"><?= $Page->PROGRAMS->caption() ?></span></td>
        <td data-name="PROGRAMS" <?= $Page->PROGRAMS->cellAttributes() ?>>
<span id="el_INVOICE_PROGRAMS">
<span<?= $Page->PROGRAMS->viewAttributes() ?>>
<?= $Page->PROGRAMS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PACTIVITY_ID->Visible) { // PACTIVITY_ID ?>
    <tr id="r_PACTIVITY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PACTIVITY_ID"><?= $Page->PACTIVITY_ID->caption() ?></span></td>
        <td data-name="PACTIVITY_ID" <?= $Page->PACTIVITY_ID->cellAttributes() ?>>
<span id="el_INVOICE_PACTIVITY_ID">
<span<?= $Page->PACTIVITY_ID->viewAttributes() ?>>
<?= $Page->PACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACTIVITY_ID->Visible) { // ACTIVITY_ID ?>
    <tr id="r_ACTIVITY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ACTIVITY_ID"><?= $Page->ACTIVITY_ID->caption() ?></span></td>
        <td data-name="ACTIVITY_ID" <?= $Page->ACTIVITY_ID->cellAttributes() ?>>
<span id="el_INVOICE_ACTIVITY_ID">
<span<?= $Page->ACTIVITY_ID->viewAttributes() ?>>
<?= $Page->ACTIVITY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ACTIVITY_NAME->Visible) { // ACTIVITY_NAME ?>
    <tr id="r_ACTIVITY_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ACTIVITY_NAME"><?= $Page->ACTIVITY_NAME->caption() ?></span></td>
        <td data-name="ACTIVITY_NAME" <?= $Page->ACTIVITY_NAME->cellAttributes() ?>>
<span id="el_INVOICE_ACTIVITY_NAME">
<span<?= $Page->ACTIVITY_NAME->viewAttributes() ?>>
<?= $Page->ACTIVITY_NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->KEPERLUAN->Visible) { // KEPERLUAN ?>
    <tr id="r_KEPERLUAN">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_KEPERLUAN"><?= $Page->KEPERLUAN->caption() ?></span></td>
        <td data-name="KEPERLUAN" <?= $Page->KEPERLUAN->cellAttributes() ?>>
<span id="el_INVOICE_KEPERLUAN">
<span<?= $Page->KEPERLUAN->viewAttributes() ?>>
<?= $Page->KEPERLUAN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPTK->Visible) { // PPTK ?>
    <tr id="r_PPTK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PPTK"><?= $Page->PPTK->caption() ?></span></td>
        <td data-name="PPTK" <?= $Page->PPTK->cellAttributes() ?>>
<span id="el_INVOICE_PPTK">
<span<?= $Page->PPTK->viewAttributes() ?>>
<?= $Page->PPTK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPTK_NAME->Visible) { // PPTK_NAME ?>
    <tr id="r_PPTK_NAME">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PPTK_NAME"><?= $Page->PPTK_NAME->caption() ?></span></td>
        <td data-name="PPTK_NAME" <?= $Page->PPTK_NAME->cellAttributes() ?>>
<span id="el_INVOICE_PPTK_NAME">
<span<?= $Page->PPTK_NAME->viewAttributes() ?>>
<?= $Page->PPTK_NAME->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_ID->Visible) { // COMPANY_ID ?>
    <tr id="r_COMPANY_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_ID"><?= $Page->COMPANY_ID->caption() ?></span></td>
        <td data-name="COMPANY_ID" <?= $Page->COMPANY_ID->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_ID">
<span<?= $Page->COMPANY_ID->viewAttributes() ?>>
<?= $Page->COMPANY_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_TO->Visible) { // COMPANY_TO ?>
    <tr id="r_COMPANY_TO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_TO"><?= $Page->COMPANY_TO->caption() ?></span></td>
        <td data-name="COMPANY_TO" <?= $Page->COMPANY_TO->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_TO">
<span<?= $Page->COMPANY_TO->viewAttributes() ?>>
<?= $Page->COMPANY_TO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_TYPE->Visible) { // COMPANY_TYPE ?>
    <tr id="r_COMPANY_TYPE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_TYPE"><?= $Page->COMPANY_TYPE->caption() ?></span></td>
        <td data-name="COMPANY_TYPE" <?= $Page->COMPANY_TYPE->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_TYPE">
<span<?= $Page->COMPANY_TYPE->viewAttributes() ?>>
<?= $Page->COMPANY_TYPE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY->Visible) { // COMPANY ?>
    <tr id="r_COMPANY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY"><?= $Page->COMPANY->caption() ?></span></td>
        <td data-name="COMPANY" <?= $Page->COMPANY->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY">
<span<?= $Page->COMPANY->viewAttributes() ?>>
<?= $Page->COMPANY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_CHIEF->Visible) { // COMPANY_CHIEF ?>
    <tr id="r_COMPANY_CHIEF">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_CHIEF"><?= $Page->COMPANY_CHIEF->caption() ?></span></td>
        <td data-name="COMPANY_CHIEF" <?= $Page->COMPANY_CHIEF->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_CHIEF">
<span<?= $Page->COMPANY_CHIEF->viewAttributes() ?>>
<?= $Page->COMPANY_CHIEF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_INFO->Visible) { // COMPANY_INFO ?>
    <tr id="r_COMPANY_INFO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_INFO"><?= $Page->COMPANY_INFO->caption() ?></span></td>
        <td data-name="COMPANY_INFO" <?= $Page->COMPANY_INFO->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_INFO">
<span<?= $Page->COMPANY_INFO->viewAttributes() ?>>
<?= $Page->COMPANY_INFO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CONTRACT_NO->Visible) { // CONTRACT_NO ?>
    <tr id="r_CONTRACT_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_CONTRACT_NO"><?= $Page->CONTRACT_NO->caption() ?></span></td>
        <td data-name="CONTRACT_NO" <?= $Page->CONTRACT_NO->cellAttributes() ?>>
<span id="el_INVOICE_CONTRACT_NO">
<span<?= $Page->CONTRACT_NO->viewAttributes() ?>>
<?= $Page->CONTRACT_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NPWP->Visible) { // NPWP ?>
    <tr id="r_NPWP">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_NPWP"><?= $Page->NPWP->caption() ?></span></td>
        <td data-name="NPWP" <?= $Page->NPWP->cellAttributes() ?>>
<span id="el_INVOICE_NPWP">
<span<?= $Page->NPWP->viewAttributes() ?>>
<?= $Page->NPWP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_BANK->Visible) { // COMPANY_BANK ?>
    <tr id="r_COMPANY_BANK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_BANK"><?= $Page->COMPANY_BANK->caption() ?></span></td>
        <td data-name="COMPANY_BANK" <?= $Page->COMPANY_BANK->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_BANK">
<span<?= $Page->COMPANY_BANK->viewAttributes() ?>>
<?= $Page->COMPANY_BANK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->COMPANY_ACCOUNT->Visible) { // COMPANY_ACCOUNT ?>
    <tr id="r_COMPANY_ACCOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_COMPANY_ACCOUNT"><?= $Page->COMPANY_ACCOUNT->caption() ?></span></td>
        <td data-name="COMPANY_ACCOUNT" <?= $Page->COMPANY_ACCOUNT->cellAttributes() ?>>
<span id="el_INVOICE_COMPANY_ACCOUNT">
<span<?= $Page->COMPANY_ACCOUNT->viewAttributes() ?>>
<?= $Page->COMPANY_ACCOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAGU->Visible) { // PAGU ?>
    <tr id="r_PAGU">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PAGU"><?= $Page->PAGU->caption() ?></span></td>
        <td data-name="PAGU" <?= $Page->PAGU->cellAttributes() ?>>
<span id="el_INVOICE_PAGU">
<span<?= $Page->PAGU->viewAttributes() ?>>
<?= $Page->PAGU->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAGU_REALISASI->Visible) { // PAGU_REALISASI ?>
    <tr id="r_PAGU_REALISASI">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PAGU_REALISASI"><?= $Page->PAGU_REALISASI->caption() ?></span></td>
        <td data-name="PAGU_REALISASI" <?= $Page->PAGU_REALISASI->cellAttributes() ?>>
<span id="el_INVOICE_PAGU_REALISASI">
<span<?= $Page->PAGU_REALISASI->viewAttributes() ?>>
<?= $Page->PAGU_REALISASI->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT->Visible) { // AMOUNT ?>
    <tr id="r_AMOUNT">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_AMOUNT"><?= $Page->AMOUNT->caption() ?></span></td>
        <td data-name="AMOUNT" <?= $Page->AMOUNT->cellAttributes() ?>>
<span id="el_INVOICE_AMOUNT">
<span<?= $Page->AMOUNT->viewAttributes() ?>>
<?= $Page->AMOUNT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AMOUNT_PAID->Visible) { // AMOUNT_PAID ?>
    <tr id="r_AMOUNT_PAID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_AMOUNT_PAID"><?= $Page->AMOUNT_PAID->caption() ?></span></td>
        <td data-name="AMOUNT_PAID" <?= $Page->AMOUNT_PAID->cellAttributes() ?>>
<span id="el_INVOICE_AMOUNT_PAID">
<span<?= $Page->AMOUNT_PAID->viewAttributes() ?>>
<?= $Page->AMOUNT_PAID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PAYMENT_INSTRUCTIONS->Visible) { // PAYMENT_INSTRUCTIONS ?>
    <tr id="r_PAYMENT_INSTRUCTIONS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PAYMENT_INSTRUCTIONS"><?= $Page->PAYMENT_INSTRUCTIONS->caption() ?></span></td>
        <td data-name="PAYMENT_INSTRUCTIONS" <?= $Page->PAYMENT_INSTRUCTIONS->cellAttributes() ?>>
<span id="el_INVOICE_PAYMENT_INSTRUCTIONS">
<span<?= $Page->PAYMENT_INSTRUCTIONS->viewAttributes() ?>>
<?= $Page->PAYMENT_INSTRUCTIONS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISAPPROVED->Visible) { // ISAPPROVED ?>
    <tr id="r_ISAPPROVED">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ISAPPROVED"><?= $Page->ISAPPROVED->caption() ?></span></td>
        <td data-name="ISAPPROVED" <?= $Page->ISAPPROVED->cellAttributes() ?>>
<span id="el_INVOICE_ISAPPROVED">
<span<?= $Page->ISAPPROVED->viewAttributes() ?>>
<?= $Page->ISAPPROVED->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->APPROVED_BY->Visible) { // APPROVED_BY ?>
    <tr id="r_APPROVED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_APPROVED_BY"><?= $Page->APPROVED_BY->caption() ?></span></td>
        <td data-name="APPROVED_BY" <?= $Page->APPROVED_BY->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_BY">
<span<?= $Page->APPROVED_BY->viewAttributes() ?>>
<?= $Page->APPROVED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->APPROVED_DATE->Visible) { // APPROVED_DATE ?>
    <tr id="r_APPROVED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_APPROVED_DATE"><?= $Page->APPROVED_DATE->caption() ?></span></td>
        <td data-name="APPROVED_DATE" <?= $Page->APPROVED_DATE->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_DATE">
<span<?= $Page->APPROVED_DATE->viewAttributes() ?>>
<?= $Page->APPROVED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ISCETAK->Visible) { // ISCETAK ?>
    <tr id="r_ISCETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_ISCETAK"><?= $Page->ISCETAK->caption() ?></span></td>
        <td data-name="ISCETAK" <?= $Page->ISCETAK->cellAttributes() ?>>
<span id="el_INVOICE_ISCETAK">
<span<?= $Page->ISCETAK->viewAttributes() ?>>
<?= $Page->ISCETAK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTQ->Visible) { // PRINTQ ?>
    <tr id="r_PRINTQ">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PRINTQ"><?= $Page->PRINTQ->caption() ?></span></td>
        <td data-name="PRINTQ" <?= $Page->PRINTQ->cellAttributes() ?>>
<span id="el_INVOICE_PRINTQ">
<span<?= $Page->PRINTQ->viewAttributes() ?>>
<?= $Page->PRINTQ->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINT_DATE->Visible) { // PRINT_DATE ?>
    <tr id="r_PRINT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PRINT_DATE"><?= $Page->PRINT_DATE->caption() ?></span></td>
        <td data-name="PRINT_DATE" <?= $Page->PRINT_DATE->cellAttributes() ?>>
<span id="el_INVOICE_PRINT_DATE">
<span<?= $Page->PRINT_DATE->viewAttributes() ?>>
<?= $Page->PRINT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PRINTED_BY->Visible) { // PRINTED_BY ?>
    <tr id="r_PRINTED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PRINTED_BY"><?= $Page->PRINTED_BY->caption() ?></span></td>
        <td data-name="PRINTED_BY" <?= $Page->PRINTED_BY->cellAttributes() ?>>
<span id="el_INVOICE_PRINTED_BY">
<span<?= $Page->PRINTED_BY->viewAttributes() ?>>
<?= $Page->PRINTED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_DATE->Visible) { // MODIFIED_DATE ?>
    <tr id="r_MODIFIED_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_MODIFIED_DATE"><?= $Page->MODIFIED_DATE->caption() ?></span></td>
        <td data-name="MODIFIED_DATE" <?= $Page->MODIFIED_DATE->cellAttributes() ?>>
<span id="el_INVOICE_MODIFIED_DATE">
<span<?= $Page->MODIFIED_DATE->viewAttributes() ?>>
<?= $Page->MODIFIED_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->MODIFIED_BY->Visible) { // MODIFIED_BY ?>
    <tr id="r_MODIFIED_BY">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_MODIFIED_BY"><?= $Page->MODIFIED_BY->caption() ?></span></td>
        <td data-name="MODIFIED_BY" <?= $Page->MODIFIED_BY->cellAttributes() ?>>
<span id="el_INVOICE_MODIFIED_BY">
<span<?= $Page->MODIFIED_BY->viewAttributes() ?>>
<?= $Page->MODIFIED_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->PPTK_TITLE->Visible) { // PPTK_TITLE ?>
    <tr id="r_PPTK_TITLE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_PPTK_TITLE"><?= $Page->PPTK_TITLE->caption() ?></span></td>
        <td data-name="PPTK_TITLE" <?= $Page->PPTK_TITLE->cellAttributes() ?>>
<span id="el_INVOICE_PPTK_TITLE">
<span<?= $Page->PPTK_TITLE->viewAttributes() ?>>
<?= $Page->PPTK_TITLE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->APPROVED_ID->Visible) { // APPROVED_ID ?>
    <tr id="r_APPROVED_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_APPROVED_ID"><?= $Page->APPROVED_ID->caption() ?></span></td>
        <td data-name="APPROVED_ID" <?= $Page->APPROVED_ID->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_ID">
<span<?= $Page->APPROVED_ID->viewAttributes() ?>>
<?= $Page->APPROVED_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->APPROVED_TITLE->Visible) { // APPROVED_TITLE ?>
    <tr id="r_APPROVED_TITLE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_INVOICE_APPROVED_TITLE"><?= $Page->APPROVED_TITLE->caption() ?></span></td>
        <td data-name="APPROVED_TITLE" <?= $Page->APPROVED_TITLE->cellAttributes() ?>>
<span id="el_INVOICE_APPROVED_TITLE">
<span<?= $Page->APPROVED_TITLE->viewAttributes() ?>>
<?= $Page->APPROVED_TITLE->getViewValue() ?></span>
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
