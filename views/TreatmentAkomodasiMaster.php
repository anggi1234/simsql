<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

// Table
$TREATMENT_AKOMODASI = Container("TREATMENT_AKOMODASI");
?>
<?php if ($TREATMENT_AKOMODASI->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_TREATMENT_AKOMODASImaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($TREATMENT_AKOMODASI->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->CLINIC_ID->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->CLINIC_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_CLINIC_ID">
<span<?= $TREATMENT_AKOMODASI->CLINIC_ID->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->TREATMENT->Visible) { // TREATMENT ?>
        <tr id="r_TREATMENT">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->TREATMENT->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->TREATMENT->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_TREATMENT">
<span<?= $TREATMENT_AKOMODASI->TREATMENT->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->TREATMENT->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->TREAT_DATE->Visible) { // TREAT_DATE ?>
        <tr id="r_TREAT_DATE">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->TREAT_DATE->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->TREAT_DATE->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_TREAT_DATE">
<span<?= $TREATMENT_AKOMODASI->TREAT_DATE->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->TREAT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->DESCRIPTION->Visible) { // DESCRIPTION ?>
        <tr id="r_DESCRIPTION">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->DESCRIPTION->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->DESCRIPTION->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_DESCRIPTION">
<span<?= $TREATMENT_AKOMODASI->DESCRIPTION->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->DESCRIPTION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <tr id="r_CLASS_ROOM_ID">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->CLASS_ROOM_ID->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_CLASS_ROOM_ID">
<span<?= $TREATMENT_AKOMODASI->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <tr id="r_KELUAR_ID">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->KELUAR_ID->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->KELUAR_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_KELUAR_ID">
<span<?= $TREATMENT_AKOMODASI->KELUAR_ID->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->BED_ID->Visible) { // BED_ID ?>
        <tr id="r_BED_ID">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->BED_ID->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->BED_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_BED_ID">
<span<?= $TREATMENT_AKOMODASI->BED_ID->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->BED_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->EMPLOYEE_ID->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_EMPLOYEE_ID">
<span<?= $TREATMENT_AKOMODASI->EMPLOYEE_ID->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->NO_SURAT_KET->Visible) { // NO_SURAT_KET ?>
        <tr id="r_NO_SURAT_KET">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->NO_SURAT_KET->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->NO_SURAT_KET->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_NO_SURAT_KET">
<span<?= $TREATMENT_AKOMODASI->NO_SURAT_KET->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->NO_SURAT_KET->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($TREATMENT_AKOMODASI->ID->Visible) { // ID ?>
        <tr id="r_ID">
            <td class="<?= $TREATMENT_AKOMODASI->TableLeftColumnClass ?>"><?= $TREATMENT_AKOMODASI->ID->caption() ?></td>
            <td <?= $TREATMENT_AKOMODASI->ID->cellAttributes() ?>>
<span id="el_TREATMENT_AKOMODASI_ID">
<span<?= $TREATMENT_AKOMODASI->ID->viewAttributes() ?>>
<?= $TREATMENT_AKOMODASI->ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
