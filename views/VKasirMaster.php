<?php

namespace PHPMaker2021\simrs;

// Table
$V_KASIR = Container("V_KASIR");
?>
<?php if ($V_KASIR->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_V_KASIRmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($V_KASIR->CETAK->Visible) { // CETAK ?>
        <tr id="r_CETAK">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->CETAK->caption() ?></td>
            <td <?= $V_KASIR->CETAK->cellAttributes() ?>>
<span id="el_V_KASIR_CETAK">
<span<?= $V_KASIR->CETAK->viewAttributes() ?>><script>

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
<?php if ($V_KASIR->NO_REGISTRATION->Visible) { // NO_REGISTRATION ?>
        <tr id="r_NO_REGISTRATION">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->NO_REGISTRATION->caption() ?></td>
            <td <?= $V_KASIR->NO_REGISTRATION->cellAttributes() ?>>
<span id="el_V_KASIR_NO_REGISTRATION">
<span<?= $V_KASIR->NO_REGISTRATION->viewAttributes() ?>>
<?= $V_KASIR->NO_REGISTRATION->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->VISIT_DATE->Visible) { // VISIT_DATE ?>
        <tr id="r_VISIT_DATE">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->VISIT_DATE->caption() ?></td>
            <td <?= $V_KASIR->VISIT_DATE->cellAttributes() ?>>
<span id="el_V_KASIR_VISIT_DATE">
<span<?= $V_KASIR->VISIT_DATE->viewAttributes() ?>>
<?= $V_KASIR->VISIT_DATE->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->CLINIC_ID->Visible) { // CLINIC_ID ?>
        <tr id="r_CLINIC_ID">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->CLINIC_ID->caption() ?></td>
            <td <?= $V_KASIR->CLINIC_ID->cellAttributes() ?>>
<span id="el_V_KASIR_CLINIC_ID">
<span<?= $V_KASIR->CLINIC_ID->viewAttributes() ?>>
<?= $V_KASIR->CLINIC_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->DIANTAR_OLEH->Visible) { // DIANTAR_OLEH ?>
        <tr id="r_DIANTAR_OLEH">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->DIANTAR_OLEH->caption() ?></td>
            <td <?= $V_KASIR->DIANTAR_OLEH->cellAttributes() ?>>
<span id="el_V_KASIR_DIANTAR_OLEH">
<span<?= $V_KASIR->DIANTAR_OLEH->viewAttributes() ?>>
<?= $V_KASIR->DIANTAR_OLEH->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->GENDER->Visible) { // GENDER ?>
        <tr id="r_GENDER">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->GENDER->caption() ?></td>
            <td <?= $V_KASIR->GENDER->cellAttributes() ?>>
<span id="el_V_KASIR_GENDER">
<span<?= $V_KASIR->GENDER->viewAttributes() ?>>
<?= $V_KASIR->GENDER->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->VISITOR_ADDRESS->Visible) { // VISITOR_ADDRESS ?>
        <tr id="r_VISITOR_ADDRESS">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->VISITOR_ADDRESS->caption() ?></td>
            <td <?= $V_KASIR->VISITOR_ADDRESS->cellAttributes() ?>>
<span id="el_V_KASIR_VISITOR_ADDRESS">
<span<?= $V_KASIR->VISITOR_ADDRESS->viewAttributes() ?>>
<?= $V_KASIR->VISITOR_ADDRESS->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->EMPLOYEE_ID->Visible) { // EMPLOYEE_ID ?>
        <tr id="r_EMPLOYEE_ID">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->EMPLOYEE_ID->caption() ?></td>
            <td <?= $V_KASIR->EMPLOYEE_ID->cellAttributes() ?>>
<span id="el_V_KASIR_EMPLOYEE_ID">
<span<?= $V_KASIR->EMPLOYEE_ID->viewAttributes() ?>>
<?= $V_KASIR->EMPLOYEE_ID->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->TICKET_NO->Visible) { // TICKET_NO ?>
        <tr id="r_TICKET_NO">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->TICKET_NO->caption() ?></td>
            <td <?= $V_KASIR->TICKET_NO->cellAttributes() ?>>
<span id="el_V_KASIR_TICKET_NO">
<span<?= $V_KASIR->TICKET_NO->viewAttributes() ?>>
<?= $V_KASIR->TICKET_NO->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->AGEYEAR->Visible) { // AGEYEAR ?>
        <tr id="r_AGEYEAR">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->AGEYEAR->caption() ?></td>
            <td <?= $V_KASIR->AGEYEAR->cellAttributes() ?>>
<span id="el_V_KASIR_AGEYEAR">
<span<?= $V_KASIR->AGEYEAR->viewAttributes() ?>>
<?= $V_KASIR->AGEYEAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($V_KASIR->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
        <tr id="r_IDXDAFTAR">
            <td class="<?= $V_KASIR->TableLeftColumnClass ?>"><?= $V_KASIR->IDXDAFTAR->caption() ?></td>
            <td <?= $V_KASIR->IDXDAFTAR->cellAttributes() ?>>
<span id="el_V_KASIR_IDXDAFTAR">
<span<?= $V_KASIR->IDXDAFTAR->viewAttributes() ?>>
<?= $V_KASIR->IDXDAFTAR->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
