<?php

namespace PHPMaker2021\simrs;

// Table
$MUTATION_DOCS = Container("MUTATION_DOCS");
?>
<?php if ($MUTATION_DOCS->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_MUTATION_DOCSmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($MUTATION_DOCS->DOC_NO->Visible) { // DOC_NO ?>
        <tr id="r_DOC_NO">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->DOC_NO->caption() ?></td>
            <td <?= $MUTATION_DOCS->DOC_NO->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_DOC_NO">
<span<?= $MUTATION_DOCS->DOC_NO->viewAttributes() ?>>
<?= $MUTATION_DOCS->DOC_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->CLINIC_ID->caption() ?></td>
            <td <?= $MUTATION_DOCS->CLINIC_ID->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_CLINIC_ID">
<span<?= $MUTATION_DOCS->CLINIC_ID->viewAttributes() ?>>
<?= $MUTATION_DOCS->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->CLINIC_ID_TO->Visible) { // CLINIC_ID_TO ?>
        <tr id="r_CLINIC_ID_TO">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->CLINIC_ID_TO->caption() ?></td>
            <td <?= $MUTATION_DOCS->CLINIC_ID_TO->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_CLINIC_ID_TO">
<span<?= $MUTATION_DOCS->CLINIC_ID_TO->viewAttributes() ?>>
<?= $MUTATION_DOCS->CLINIC_ID_TO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->MUTATION_DATE->Visible) { // MUTATION_DATE ?>
        <tr id="r_MUTATION_DATE">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->MUTATION_DATE->caption() ?></td>
            <td <?= $MUTATION_DOCS->MUTATION_DATE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_DATE">
<span<?= $MUTATION_DOCS->MUTATION_DATE->viewAttributes() ?>>
<?= $MUTATION_DOCS->MUTATION_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->MUTATION_BY->Visible) { // MUTATION_BY ?>
        <tr id="r_MUTATION_BY">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->MUTATION_BY->caption() ?></td>
            <td <?= $MUTATION_DOCS->MUTATION_BY->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_BY">
<span<?= $MUTATION_DOCS->MUTATION_BY->viewAttributes() ?>>
<?= $MUTATION_DOCS->MUTATION_BY->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->ORDER_VALUE->Visible) { // ORDER_VALUE ?>
        <tr id="r_ORDER_VALUE">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->ORDER_VALUE->caption() ?></td>
            <td <?= $MUTATION_DOCS->ORDER_VALUE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_ORDER_VALUE">
<span<?= $MUTATION_DOCS->ORDER_VALUE->viewAttributes() ?>>
<?= $MUTATION_DOCS->ORDER_VALUE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->MUTATION_VALUE->Visible) { // MUTATION_VALUE ?>
        <tr id="r_MUTATION_VALUE">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->MUTATION_VALUE->caption() ?></td>
            <td <?= $MUTATION_DOCS->MUTATION_VALUE->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_MUTATION_VALUE">
<span<?= $MUTATION_DOCS->MUTATION_VALUE->viewAttributes() ?>>
<?= $MUTATION_DOCS->MUTATION_VALUE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($MUTATION_DOCS->RECEIVED_BY->Visible) { // RECEIVED_BY ?>
        <tr id="r_RECEIVED_BY">
            <td class="<?= $MUTATION_DOCS->TableLeftColumnClass ?>"><?= $MUTATION_DOCS->RECEIVED_BY->caption() ?></td>
            <td <?= $MUTATION_DOCS->RECEIVED_BY->cellAttributes() ?>>
<span id="el_MUTATION_DOCS_RECEIVED_BY">
<span<?= $MUTATION_DOCS->RECEIVED_BY->viewAttributes() ?>>
<?= $MUTATION_DOCS->RECEIVED_BY->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
