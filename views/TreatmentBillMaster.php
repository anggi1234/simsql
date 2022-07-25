<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Table
$TREATMENT_BILL = Container("TREATMENT_BILL");
?>
<?php if ($TREATMENT_BILL->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_TREATMENT_BILLmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($TREATMENT_BILL->ORG_UNIT_CODE->Visible) { // ORG_UNIT_CODE ?>
        <tr id="r_ORG_UNIT_CODE">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->ORG_UNIT_CODE->caption() ?></td>
            <td <?= $TREATMENT_BILL->ORG_UNIT_CODE->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_ORG_UNIT_CODE">
<span<?= $TREATMENT_BILL->ORG_UNIT_CODE->viewAttributes() ?>>
<?= $TREATMENT_BILL->ORG_UNIT_CODE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->NO_REGISTRATION->caption() ?></td>
            <td <?= $TREATMENT_BILL->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_NO_REGISTRATION">
<span<?= $TREATMENT_BILL->NO_REGISTRATION->viewAttributes() ?>>
<?= $TREATMENT_BILL->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->VISIT_ID->Visible) { // VISIT_ID ?>
        <tr id="r_VISIT_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->VISIT_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->VISIT_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_VISIT_ID">
<span<?= $TREATMENT_BILL->VISIT_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->VISIT_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->TARIF_ID->Visible) { // TARIF_ID ?>
        <tr id="r_TARIF_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->TARIF_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->TARIF_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_TARIF_ID">
<span<?= $TREATMENT_BILL->TARIF_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->TARIF_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->CLINIC_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_CLINIC_ID">
<span<?= $TREATMENT_BILL->CLINIC_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <tr id="r_TREAT_DATE">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->TREAT_DATE->caption() ?></td>
            <td <?= $TREATMENT_BILL->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_TREAT_DATE">
<span<?= $TREATMENT_BILL->TREAT_DATE->viewAttributes() ?>>
<?= $TREATMENT_BILL->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->QUANTITY->Visible) { // QUANTITY ?>
        <tr id="r_QUANTITY">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->QUANTITY->caption() ?></td>
            <td <?= $TREATMENT_BILL->QUANTITY->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_QUANTITY">
<span<?= $TREATMENT_BILL->QUANTITY->viewAttributes() ?>>
<?= $TREATMENT_BILL->QUANTITY->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->EMPLOYEE_ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_EMPLOYEE_ID">
<span<?= $TREATMENT_BILL->EMPLOYEE_ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->amount_paid->Visible) { // amount_paid ?>
        <tr id="r_amount_paid">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->amount_paid->caption() ?></td>
            <td <?= $TREATMENT_BILL->amount_paid->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_amount_paid">
<span<?= $TREATMENT_BILL->amount_paid->viewAttributes() ?>>
<?= $TREATMENT_BILL->amount_paid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->THENAME->Visible) { // THENAME ?>
        <tr id="r_THENAME">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->THENAME->caption() ?></td>
            <td <?= $TREATMENT_BILL->THENAME->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_THENAME">
<span<?= $TREATMENT_BILL->THENAME->viewAttributes() ?>>
<?= $TREATMENT_BILL->THENAME->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->THEADDRESS->Visible) { // THEADDRESS ?>
        <tr id="r_THEADDRESS">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->THEADDRESS->caption() ?></td>
            <td <?= $TREATMENT_BILL->THEADDRESS->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_THEADDRESS">
<span<?= $TREATMENT_BILL->THEADDRESS->viewAttributes() ?>>
<?= $TREATMENT_BILL->THEADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->THEID->Visible) { // THEID ?>
        <tr id="r_THEID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->THEID->caption() ?></td>
            <td <?= $TREATMENT_BILL->THEID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_THEID">
<span<?= $TREATMENT_BILL->THEID->viewAttributes() ?>>
<?= $TREATMENT_BILL->THEID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->ISRJ->Visible) { // ISRJ ?>
        <tr id="r_ISRJ">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->ISRJ->caption() ?></td>
            <td <?= $TREATMENT_BILL->ISRJ->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_ISRJ">
<span<?= $TREATMENT_BILL->ISRJ->viewAttributes() ?>>
<?= $TREATMENT_BILL->ISRJ->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->GENDER->caption() ?></td>
            <td <?= $TREATMENT_BILL->GENDER->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_GENDER">
<span<?= $TREATMENT_BILL->GENDER->viewAttributes() ?>>
<?= $TREATMENT_BILL->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_BILL->ID->Visible) { // ID ?>
        <tr id="r_ID">
            <td class="<?= $TREATMENT_BILL->TableLeftColumnClass ?>"><?= $TREATMENT_BILL->ID->caption() ?></td>
            <td <?= $TREATMENT_BILL->ID->cellAttributes() ?>>
<span id="el_TREATMENT_BILL_ID">
<span<?= $TREATMENT_BILL->ID->viewAttributes() ?>>
<?= $TREATMENT_BILL->ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
