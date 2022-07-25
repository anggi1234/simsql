<?php

namespace PHPMaker2021\simrs;

// Table
$V_REKAM_MEDIS = Container("V_REKAM_MEDIS");
?>
<?php if ($V_REKAM_MEDIS->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_REKAM_MEDISmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_REKAM_MEDIS->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_NO_REGISTRATION">
<span<?= $V_REKAM_MEDIS->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->VISIT_DATE->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_VISIT_DATE">
<span<?= $V_REKAM_MEDIS->VISIT_DATE->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->CLINIC_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_CLINIC_ID">
<span<?= $V_REKAM_MEDIS->CLINIC_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_DIANTAR_OLEH">
<span<?= $V_REKAM_MEDIS->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->GENDER->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->GENDER->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_GENDER">
<span<?= $V_REKAM_MEDIS->GENDER->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_VISITOR_ADDRESS">
<span<?= $V_REKAM_MEDIS->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_EMPLOYEE_ID">
<span<?= $V_REKAM_MEDIS->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->TICKET_NO->Visible) { // TICKET_NO ?>
        <tr id="r_TICKET_NO">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->TICKET_NO->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->TICKET_NO->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_TICKET_NO">
<span<?= $V_REKAM_MEDIS->TICKET_NO->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->TICKET_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->AGEYEAR->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->AGEYEAR->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_AGEYEAR">
<span<?= $V_REKAM_MEDIS->AGEYEAR->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_REKAM_MEDIS->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <tr id="r_IDXDAFTAR">
            <td class="<?= $V_REKAM_MEDIS->TableLeftColumnClass ?>"><?= $V_REKAM_MEDIS->IDXDAFTAR->caption() ?></td>
            <td <?= $V_REKAM_MEDIS->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_REKAM_MEDIS_IDXDAFTAR">
<span<?= $V_REKAM_MEDIS->IDXDAFTAR->viewAttributes() ?>>
<?= $V_REKAM_MEDIS->IDXDAFTAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
