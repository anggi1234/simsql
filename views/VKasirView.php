<?php

namespace PHPMaker2021\simrs;

// Page object
$VKasirView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fV_KASIRview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fV_KASIRview = currentForm = new ew.Form("fV_KASIRview", "view");
    loadjs.done("fV_KASIRview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.V_KASIR) ew.vars.tables.V_KASIR = <?= JsonEncode(GetClientVar("tables", "V_KASIR")) ?>;
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
<form name="fV_KASIRview" id="fV_KASIRview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="V_KASIR">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->CETAK->Visible) { // CETAK ?>
    <tr id="r_CETAK">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_CETAK"><?= $Page->CETAK->caption() ?></span></td>
        <td data-name="CETAK" <?= $Page->CETAK->cellAttributes() ?>>
<span id="el_V_KASIR_CETAK">
<span<?= $Page->CETAK->viewAttributes() ?>><script>

function Buka(link="") {
	window.open(link, 'newwindow', 'width=800,height=400');
	return false;
}
</script>
<div class="btn-group btn-group-sm ew-btn-group">
	<a class="btn bg-navy ew-row-link ew-detail" href="print.html"
	onclick="Buka('/simrs/reporting/nota_kwitansi_semua.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">NOTA</a>
	<button class="dropdown-toggle btn bg-navy ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="">
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rekap_total.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Rekap Total</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rincian_tindakan.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Tindakan</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_pelayanan_kasir_ranap.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">CESMIX Ringkas</a>
		</li>
		<li class="divider" style="border-bottom:1px solid #ccc!important"></li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rincian_inacbg.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">INACBG</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="#"
			 onclick="Buka('/simrs/reporting/nota_rincian_inadrg.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">INADRG</a>
		</li>
	</ul>
</div>
<div class="btn-group btn-group-sm ew-btn-group">
	<a class="btn btn-primary ew-row-link ew-detail" href="print.html"
	onclick="Buka('/simrs/reporting/jasper.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">RESUME MEDIS</a>
	<button class="dropdown-toggle btn btn-primary ew-detail" data-toggle="dropdown" aria-expanded="false"></button>
	<ul class="dropdown-menu" style="">
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_ranap.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Rawat Inap</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_rajal.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Rawat Jalan</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_pasien.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Pasien</a>
		</li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_keterangan_meninggal.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Ket. Meninggal</a>
		</li>
		<li class="divider" style="border-bottom:1px solid #ccc!important"></li>
		<li>
			<a class="dropdown-item ew-row-link ew-detail-edit" href="print.html"
			 onclick="Buka('/simrs/reporting/surat_kontrol.php?id=<?php echo urlencode(CurrentPage()->VISIT_ID->CurrentValue)?>'); return false">Surat Kontrol</a>
		</li>
	</ul>
</div>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
    <tr id="r_NO_REGISTRATION">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_NO_REGISTRATION"><?= $Page->NO_REGISTRATION->caption() ?></span></td>
        <td data-name="NO_REGISTRATION" <?= $Page->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_KASIR_NO_REGISTRATION">
<span<?= $Page->NO_REGISTRATION->viewAttributes() ?>>
<?= $Page->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_ID->Visible) { // VISIT_ID ?>
    <tr id="r_VISIT_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_VISIT_ID"><?= $Page->VISIT_ID->caption() ?></span></td>
        <td data-name="VISIT_ID" <?= $Page->VISIT_ID->cellAttributes() ?>>
<span id="el_V_KASIR_VISIT_ID">
<span<?= $Page->VISIT_ID->viewAttributes() ?>>
<?= $Page->VISIT_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->STATUS_PASIEN_ID->Visible) { // STATUS_PASIEN_ID ?>
    <tr id="r_STATUS_PASIEN_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_STATUS_PASIEN_ID"><?= $Page->STATUS_PASIEN_ID->caption() ?></span></td>
        <td data-name="STATUS_PASIEN_ID" <?= $Page->STATUS_PASIEN_ID->cellAttributes() ?>>
<span id="el_V_KASIR_STATUS_PASIEN_ID">
<span<?= $Page->STATUS_PASIEN_ID->viewAttributes() ?>>
<?= $Page->STATUS_PASIEN_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISIT_DATE->Visible) { // VISIT_DATE ?>
    <tr id="r_VISIT_DATE">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_VISIT_DATE"><?= $Page->VISIT_DATE->caption() ?></span></td>
        <td data-name="VISIT_DATE" <?= $Page->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_KASIR_VISIT_DATE">
<span<?= $Page->VISIT_DATE->viewAttributes() ?>>
<?= $Page->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->CLINIC_ID->Visible) { // CLINIC_ID ?>
    <tr id="r_CLINIC_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_CLINIC_ID"><?= $Page->CLINIC_ID->caption() ?></span></td>
        <td data-name="CLINIC_ID" <?= $Page->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_KASIR_CLINIC_ID">
<span<?= $Page->CLINIC_ID->viewAttributes() ?>>
<?= $Page->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
    <tr id="r_DIANTAR_OLEH">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_DIANTAR_OLEH"><?= $Page->DIANTAR_OLEH->caption() ?></span></td>
        <td data-name="DIANTAR_OLEH" <?= $Page->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KASIR_DIANTAR_OLEH">
<span<?= $Page->DIANTAR_OLEH->viewAttributes() ?>>
<?= $Page->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->GENDER->Visible) { // GENDER ?>
    <tr id="r_GENDER">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_GENDER"><?= $Page->GENDER->caption() ?></span></td>
        <td data-name="GENDER" <?= $Page->GENDER->cellAttributes() ?>>
<span id="el_V_KASIR_GENDER">
<span<?= $Page->GENDER->viewAttributes() ?>>
<?= $Page->GENDER->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
    <tr id="r_VISITOR_ADDRESS">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_VISITOR_ADDRESS"><?= $Page->VISITOR_ADDRESS->caption() ?></span></td>
        <td data-name="VISITOR_ADDRESS" <?= $Page->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_KASIR_VISITOR_ADDRESS">
<span<?= $Page->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $Page->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
    <tr id="r_EMPLOYEE_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_EMPLOYEE_ID"><?= $Page->EMPLOYEE_ID->caption() ?></span></td>
        <td data-name="EMPLOYEE_ID" <?= $Page->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_KASIR_EMPLOYEE_ID">
<span<?= $Page->EMPLOYEE_ID->viewAttributes() ?>>
<?= $Page->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TICKET_NO->Visible) { // TICKET_NO ?>
    <tr id="r_TICKET_NO">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_TICKET_NO"><?= $Page->TICKET_NO->caption() ?></span></td>
        <td data-name="TICKET_NO" <?= $Page->TICKET_NO->cellAttributes() ?>>
<span id="el_V_KASIR_TICKET_NO">
<span<?= $Page->TICKET_NO->viewAttributes() ?>>
<?= $Page->TICKET_NO->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->AGEYEAR->Visible) { // AGEYEAR ?>
    <tr id="r_AGEYEAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_AGEYEAR"><?= $Page->AGEYEAR->caption() ?></span></td>
        <td data-name="AGEYEAR" <?= $Page->AGEYEAR->cellAttributes() ?>>
<span id="el_V_KASIR_AGEYEAR">
<span<?= $Page->AGEYEAR->viewAttributes() ?>>
<?= $Page->AGEYEAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->TRANS_ID->Visible) { // TRANS_ID ?>
    <tr id="r_TRANS_ID">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_TRANS_ID"><?= $Page->TRANS_ID->caption() ?></span></td>
        <td data-name="TRANS_ID" <?= $Page->TRANS_ID->cellAttributes() ?>>
<span id="el_V_KASIR_TRANS_ID">
<span<?= $Page->TRANS_ID->viewAttributes() ?>>
<?= $Page->TRANS_ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
    <tr id="r_IDXDAFTAR">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_V_KASIR_IDXDAFTAR"><?= $Page->IDXDAFTAR->caption() ?></span></td>
        <td data-name="IDXDAFTAR" <?= $Page->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_KASIR_IDXDAFTAR">
<span<?= $Page->IDXDAFTAR->viewAttributes() ?>>
<?= $Page->IDXDAFTAR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("TREATMENT_BILL", explode(",", $Page->getCurrentDetailTable())) && $TREATMENT_BILL->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("TREATMENT_BILL", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "TreatmentBillGrid.php" ?>
<?php } ?>
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
