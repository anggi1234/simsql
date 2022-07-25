<?php

namespace PHPMaker2021\simrs;

// Table
$V_LABORATORIUM = Container("V_LABORATORIUM");
?>
<?php if ($V_LABORATORIUM->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_LABORATORIUMmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_LABORATORIUM->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_LABORATORIUM->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_NO_REGISTRATION">
<span<?= $V_LABORATORIUM->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_LABORATORIUM->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->VISIT_DATE->caption() ?></td>
            <td <?= $V_LABORATORIUM->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_VISIT_DATE">
<span<?= $V_LABORATORIUM->VISIT_DATE->viewAttributes() ?>>
<?= $V_LABORATORIUM->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->CLINIC_ID->caption() ?></td>
            <td <?= $V_LABORATORIUM->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_CLINIC_ID">
<span<?= $V_LABORATORIUM->CLINIC_ID->viewAttributes() ?>>
<?= $V_LABORATORIUM->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_LABORATORIUM->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_DIANTAR_OLEH">
<span<?= $V_LABORATORIUM->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_LABORATORIUM->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->GENDER->caption() ?></td>
            <td <?= $V_LABORATORIUM->GENDER->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_GENDER">
<span<?= $V_LABORATORIUM->GENDER->viewAttributes() ?>>
<?= $V_LABORATORIUM->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $V_LABORATORIUM->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_VISITOR_ADDRESS">
<span<?= $V_LABORATORIUM->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $V_LABORATORIUM->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_LABORATORIUM->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_EMPLOYEE_ID">
<span<?= $V_LABORATORIUM->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_LABORATORIUM->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->TICKET_NO->Visible) { // TICKET_NO ?>
        <tr id="r_TICKET_NO">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->TICKET_NO->caption() ?></td>
            <td <?= $V_LABORATORIUM->TICKET_NO->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_TICKET_NO">
<span<?= $V_LABORATORIUM->TICKET_NO->viewAttributes() ?>>
<?= $V_LABORATORIUM->TICKET_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->AGEYEAR->caption() ?></td>
            <td <?= $V_LABORATORIUM->AGEYEAR->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_AGEYEAR">
<span<?= $V_LABORATORIUM->AGEYEAR->viewAttributes() ?>>
<?= $V_LABORATORIUM->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_LABORATORIUM->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <tr id="r_IDXDAFTAR">
            <td class="<?= $V_LABORATORIUM->TableLeftColumnClass ?>"><?= $V_LABORATORIUM->IDXDAFTAR->caption() ?></td>
            <td <?= $V_LABORATORIUM->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_LABORATORIUM_IDXDAFTAR">
<span<?= $V_LABORATORIUM->IDXDAFTAR->viewAttributes() ?>>
<?= $V_LABORATORIUM->IDXDAFTAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
