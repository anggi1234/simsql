<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Table
$V_RAWAT_INAP = Container("V_RAWAT_INAP");
?>
<?php if ($V_RAWAT_INAP->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_RAWAT_INAPmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_RAWAT_INAP->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_RAWAT_INAP->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_NO_REGISTRATION">
<span<?= $V_RAWAT_INAP->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_RAWAT_INAP->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->THENAME->Visible) { // THENAME ?>
        <tr id="r_THENAME">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->THENAME->caption() ?></td>
            <td <?= $V_RAWAT_INAP->THENAME->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_THENAME">
<span<?= $V_RAWAT_INAP->THENAME->viewAttributes() ?>>
<?= $V_RAWAT_INAP->THENAME->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->THEADDRESS->Visible) { // THEADDRESS ?>
        <tr id="r_THEADDRESS">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->THEADDRESS->caption() ?></td>
            <td <?= $V_RAWAT_INAP->THEADDRESS->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_THEADDRESS">
<span<?= $V_RAWAT_INAP->THEADDRESS->viewAttributes() ?>>
<?= $V_RAWAT_INAP->THEADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->CLINIC_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_CLINIC_ID">
<span<?= $V_RAWAT_INAP->CLINIC_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->TREATMENT->Visible) { // TREATMENT ?>
        <tr id="r_TREATMENT">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->TREATMENT->caption() ?></td>
            <td <?= $V_RAWAT_INAP->TREATMENT->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_TREATMENT">
<span<?= $V_RAWAT_INAP->TREATMENT->viewAttributes() ?>>
<?= $V_RAWAT_INAP->TREATMENT->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <tr id="r_TREAT_DATE">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->TREAT_DATE->caption() ?></td>
            <td <?= $V_RAWAT_INAP->TREAT_DATE->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_TREAT_DATE">
<span<?= $V_RAWAT_INAP->TREAT_DATE->viewAttributes() ?>>
<?= $V_RAWAT_INAP->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <tr id="r_DESCRIPTION">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->DESCRIPTION->caption() ?></td>
            <td <?= $V_RAWAT_INAP->DESCRIPTION->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_DESCRIPTION">
<span<?= $V_RAWAT_INAP->DESCRIPTION->viewAttributes() ?>>
<?= $V_RAWAT_INAP->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <tr id="r_CLASS_ROOM_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->CLASS_ROOM_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_CLASS_ROOM_ID">
<span<?= $V_RAWAT_INAP->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <tr id="r_KELUAR_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->KELUAR_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->KELUAR_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_KELUAR_ID">
<span<?= $V_RAWAT_INAP->KELUAR_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->BED_ID->Visible) { // BED_ID ?>
        <tr id="r_BED_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->BED_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->BED_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_BED_ID">
<span<?= $V_RAWAT_INAP->BED_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->BED_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_RAWAT_INAP->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_EMPLOYEE_ID">
<span<?= $V_RAWAT_INAP->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_RAWAT_INAP->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_RAWAT_INAP->NO_SURAT_KET->Visible) { // NO_SURAT_KET ?>
        <tr id="r_NO_SURAT_KET">
            <td class="<?= $V_RAWAT_INAP->TableLeftColumnClass ?>"><?= $V_RAWAT_INAP->NO_SURAT_KET->caption() ?></td>
            <td <?= $V_RAWAT_INAP->NO_SURAT_KET->cellAttributes() ?>>
<span id="el_V_RAWAT_INAP_NO_SURAT_KET">
<span<?= $V_RAWAT_INAP->NO_SURAT_KET->viewAttributes() ?>>
<?= $V_RAWAT_INAP->NO_SURAT_KET->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
