<?php

namespace PHPMaker2021\simrs;

// Table
$V_KUNJUNGAN_PASIEN = Container("V_KUNJUNGAN_PASIEN");
?>
<?php if ($V_KUNJUNGAN_PASIEN->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_KUNJUNGAN_PASIENmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_KUNJUNGAN_PASIEN->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_NO_REGISTRATION">
<span<?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_DIANTAR_OLEH">
<span<?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->GENDER->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->GENDER->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_GENDER">
<span<?= $V_KUNJUNGAN_PASIEN->GENDER->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->AGEYEAR->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->AGEYEAR->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_AGEYEAR">
<span<?= $V_KUNJUNGAN_PASIEN->AGEYEAR->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
        <tr id="r_STATUS_PASIEN_ID">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_STATUS_PASIEN_ID">
<span<?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->TREATMENT->Visible) { // TREATMENT ?>
        <tr id="r_TREATMENT">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->TREATMENT->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->TREATMENT->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_TREATMENT">
<span<?= $V_KUNJUNGAN_PASIEN->TREATMENT->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->TREATMENT->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->CLASS_ROOM_ID->Visible) { // CLASS_ROOM_ID ?>
        <tr id="r_CLASS_ROOM_ID">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->CLASS_ROOM_ID->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->CLASS_ROOM_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_CLASS_ROOM_ID">
<span<?= $V_KUNJUNGAN_PASIEN->CLASS_ROOM_ID->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->CLASS_ROOM_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->BED_ID->Visible) { // BED_ID ?>
        <tr id="r_BED_ID">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->BED_ID->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->BED_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_BED_ID">
<span<?= $V_KUNJUNGAN_PASIEN->BED_ID->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->BED_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->DOCTOR->Visible) { // DOCTOR ?>
        <tr id="r_DOCTOR">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->DOCTOR->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->DOCTOR->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_DOCTOR">
<span<?= $V_KUNJUNGAN_PASIEN->DOCTOR->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->DOCTOR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->SERVED_INAP->Visible) { // SERVED_INAP ?>
        <tr id="r_SERVED_INAP">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->SERVED_INAP->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->SERVED_INAP->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_SERVED_INAP">
<span<?= $V_KUNJUNGAN_PASIEN->SERVED_INAP->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->SERVED_INAP->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->EXIT_DATE->Visible) { // EXIT_DATE ?>
        <tr id="r_EXIT_DATE">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->EXIT_DATE->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->EXIT_DATE->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_EXIT_DATE">
<span<?= $V_KUNJUNGAN_PASIEN->EXIT_DATE->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->EXIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KUNJUNGAN_PASIEN->KELUAR_ID->Visible) { // KELUAR_ID ?>
        <tr id="r_KELUAR_ID">
            <td class="<?= $V_KUNJUNGAN_PASIEN->TableLeftColumnClass ?>"><?= $V_KUNJUNGAN_PASIEN->KELUAR_ID->caption() ?></td>
            <td <?= $V_KUNJUNGAN_PASIEN->KELUAR_ID->cellAttributes() ?>>
<span id="el_V_KUNJUNGAN_PASIEN_KELUAR_ID">
<span<?= $V_KUNJUNGAN_PASIEN->KELUAR_ID->viewAttributes() ?>>
<?= $V_KUNJUNGAN_PASIEN->KELUAR_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
