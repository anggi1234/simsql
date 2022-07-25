<?php

namespace PHPMaker2021\simrs;

// Table
$V_FARMASI = Container("V_FARMASI");
?>
<?php if ($V_FARMASI->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_FARMASImaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_FARMASI->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_FARMASI->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_FARMASI_NO_REGISTRATION">
<span<?= $V_FARMASI->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_FARMASI->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->VISIT_DATE->caption() ?></td>
            <td <?= $V_FARMASI->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_FARMASI_VISIT_DATE">
<span<?= $V_FARMASI->VISIT_DATE->viewAttributes() ?>>
<?= $V_FARMASI->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->CLINIC_ID->caption() ?></td>
            <td <?= $V_FARMASI->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_CLINIC_ID">
<span<?= $V_FARMASI->CLINIC_ID->viewAttributes() ?>>
<?= $V_FARMASI->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_FARMASI->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_FARMASI_DIANTAR_OLEH">
<span<?= $V_FARMASI->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_FARMASI->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->GENDER->caption() ?></td>
            <td <?= $V_FARMASI->GENDER->cellAttributes() ?>>
<span id="el_V_FARMASI_GENDER">
<span<?= $V_FARMASI->GENDER->viewAttributes() ?>>
<?= $V_FARMASI->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $V_FARMASI->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_FARMASI_VISITOR_ADDRESS">
<span<?= $V_FARMASI->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $V_FARMASI->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_FARMASI->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_FARMASI_EMPLOYEE_ID">
<span<?= $V_FARMASI->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_FARMASI->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->TICKET_NO->Visible) { // TICKET_NO ?>
        <tr id="r_TICKET_NO">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->TICKET_NO->caption() ?></td>
            <td <?= $V_FARMASI->TICKET_NO->cellAttributes() ?>>
<span id="el_V_FARMASI_TICKET_NO">
<span<?= $V_FARMASI->TICKET_NO->viewAttributes() ?>>
<?= $V_FARMASI->TICKET_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->AGEYEAR->caption() ?></td>
            <td <?= $V_FARMASI->AGEYEAR->cellAttributes() ?>>
<span id="el_V_FARMASI_AGEYEAR">
<span<?= $V_FARMASI->AGEYEAR->viewAttributes() ?>>
<?= $V_FARMASI->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_FARMASI->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <tr id="r_IDXDAFTAR">
            <td class="<?= $V_FARMASI->TableLeftColumnClass ?>"><?= $V_FARMASI->IDXDAFTAR->caption() ?></td>
            <td <?= $V_FARMASI->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_FARMASI_IDXDAFTAR">
<span<?= $V_FARMASI->IDXDAFTAR->viewAttributes() ?>>
<?= $V_FARMASI->IDXDAFTAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
