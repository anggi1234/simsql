<?php

namespace PHPMaker2021\simrs;

// Table
$PASIEN_VISITATION = Container("PASIEN_VISITATION");
?>
<?php if ($PASIEN_VISITATION->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_PASIEN_VISITATIONmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($PASIEN_VISITATION->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->NO_REGISTRATION->caption() ?></td>
            <td <?= $PASIEN_VISITATION->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_NO_REGISTRATION">
<span<?= $PASIEN_VISITATION->NO_REGISTRATION->viewAttributes() ?>>
<?= $PASIEN_VISITATION->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->DIANTAR_OLEH->caption() ?></td>
            <td <?= $PASIEN_VISITATION->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_DIANTAR_OLEH">
<span<?= $PASIEN_VISITATION->DIANTAR_OLEH->viewAttributes() ?>>
<?= $PASIEN_VISITATION->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->GENDER->caption() ?></td>
            <td <?= $PASIEN_VISITATION->GENDER->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_GENDER">
<span<?= $PASIEN_VISITATION->GENDER->viewAttributes() ?>>
<?= $PASIEN_VISITATION->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $PASIEN_VISITATION->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISITOR_ADDRESS">
<span<?= $PASIEN_VISITATION->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $PASIEN_VISITATION->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->VISIT_DATE->caption() ?></td>
            <td <?= $PASIEN_VISITATION->VISIT_DATE->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_VISIT_DATE">
<span<?= $PASIEN_VISITATION->VISIT_DATE->viewAttributes() ?>>
<?= $PASIEN_VISITATION->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->CLINIC_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->CLINIC_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLINIC_ID">
<span<?= $PASIEN_VISITATION->CLINIC_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->EMPLOYEE_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_EMPLOYEE_ID">
<span<?= $PASIEN_VISITATION->EMPLOYEE_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->PAYOR_ID->Visible) { // PAYOR_ID ?>
        <tr id="r_PAYOR_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->PAYOR_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->PAYOR_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PAYOR_ID">
<span<?= $PASIEN_VISITATION->PAYOR_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->PAYOR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->CLASS_ID->Visible) { // CLASS_ID ?>
        <tr id="r_CLASS_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->CLASS_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->CLASS_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_CLASS_ID">
<span<?= $PASIEN_VISITATION->CLASS_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->CLASS_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->PASIEN_ID->Visible) { // PASIEN_ID ?>
        <tr id="r_PASIEN_ID">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->PASIEN_ID->caption() ?></td>
            <td <?= $PASIEN_VISITATION->PASIEN_ID->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_PASIEN_ID">
<span<?= $PASIEN_VISITATION->PASIEN_ID->viewAttributes() ?>>
<?= $PASIEN_VISITATION->PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($PASIEN_VISITATION->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $PASIEN_VISITATION->TableLeftColumnClass ?>"><?= $PASIEN_VISITATION->AGEYEAR->caption() ?></td>
            <td <?= $PASIEN_VISITATION->AGEYEAR->cellAttributes() ?>>
<span id="el_PASIEN_VISITATION_AGEYEAR">
<span<?= $PASIEN_VISITATION->AGEYEAR->viewAttributes() ?>>
<?= $PASIEN_VISITATION->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
