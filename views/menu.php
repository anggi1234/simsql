<?php

namespace PHPMaker2021\simrs;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(6281, "mi_Dashboard2", $MenuLanguage->MenuPhrase("6281", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}Dashboard'), false, false, "", "", false);
$sideMenu->addMenuItem(6798, "mi_call_stored_procedure", $MenuLanguage->MenuPhrase("6798", "MenuText"), $MenuRelativePath . "CallStoredProcedure", 6281, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}call_stored_procedure.php'), false, false, "", "", false);
$sideMenu->addMenuItem(7322, "mci_Antrian", $MenuLanguage->MenuPhrase("7322", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6801, "mi_ANTRIAN_PENDAFTARAN_DISABILITAS", $MenuLanguage->MenuPhrase("6801", "MenuText"), $MenuRelativePath . "AntrianPendaftaranDisabilitasList", 7322, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}ANTRIAN_PENDAFTARAN_DISABILITAS'), false, false, "", "", false);
$sideMenu->addMenuItem(25, "mi_ANTRIAN_POLI", $MenuLanguage->MenuPhrase("25", "MenuText"), $MenuRelativePath . "AntrianPoliList", 7322, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}ANTRIAN_POLI'), false, false, "", "", false);
$sideMenu->addMenuItem(24, "mi_ANTRIAN_PENDAFTARAN", $MenuLanguage->MenuPhrase("24", "MenuText"), $MenuRelativePath . "AntrianPendaftaranList", 7322, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}ANTRIAN_PENDAFTARAN'), false, false, "", "", false);
$sideMenu->addMenuItem(467, "mci_Pendaftaran", $MenuLanguage->MenuPhrase("467", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(7848, "mci_Daftar", $MenuLanguage->MenuPhrase("7848", "MenuText"), $MenuRelativePath . "CvPasienAdd", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(7324, "mi_cv_pasien", $MenuLanguage->MenuPhrase("7324", "MenuText"), $MenuRelativePath . "CvPasienList", 467, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}cv_pasien'), false, false, "", "", false);
$sideMenu->addMenuItem(470, "mci_Daftar_Rajal/IGD", $MenuLanguage->MenuPhrase("470", "MenuText"), $MenuRelativePath . "PasienVisitationAdd?showdetail=", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(5761, "mci_Daftar_Pasien_Baru", $MenuLanguage->MenuPhrase("5761", "MenuText"), $MenuRelativePath . "PasienAdd", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6269, "mi_v_riwayat_sep", $MenuLanguage->MenuPhrase("6269", "MenuText"), $MenuRelativePath . "VRiwayatSepList", 467, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}v_riwayat_sep'), false, false, "", "", false);
$sideMenu->addMenuItem(471, "mi_V_DAFTAR_PASIEN", $MenuLanguage->MenuPhrase("471", "MenuText"), $MenuRelativePath . "VDaftarPasienList", 467, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_DAFTAR_PASIEN'), false, false, "", "", false);
$sideMenu->addMenuItem(2837, "mci_Laporan", $MenuLanguage->MenuPhrase("2837", "MenuText"), "", 467, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(2840, "mi_V_SENSUS", $MenuLanguage->MenuPhrase("2840", "MenuText"), $MenuRelativePath . "VSensusList", 2837, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_SENSUS'), false, false, "", "", false);
$sideMenu->addMenuItem(6267, "mi_V_KUNJUNGAN", $MenuLanguage->MenuPhrase("6267", "MenuText"), $MenuRelativePath . "VKunjunganList", 2837, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_KUNJUNGAN'), false, false, "", "", false);
$sideMenu->addMenuItem(468, "mci_Rawat_Jalan", $MenuLanguage->MenuPhrase("468", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(321, "mi_PASIEN_VISITATION", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "PasienVisitationList", 468, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}PASIEN_VISITATION'), false, false, "", "", false);
$sideMenu->addMenuItem(4786, "mci_Laporan", $MenuLanguage->MenuPhrase("4786", "MenuText"), "", 468, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4287, "mi_register_pasien", $MenuLanguage->MenuPhrase("4287", "MenuText"), $MenuRelativePath . "RegisterPasien", 4786, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}register_pasien'), false, false, "", "", false);
$sideMenu->addMenuItem(5274, "mi_register_cara_bayar", $MenuLanguage->MenuPhrase("5274", "MenuText"), $MenuRelativePath . "RegisterCaraBayar", 4786, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}register_cara_bayar'), false, false, "", "", false);
$sideMenu->addMenuItem(6282, "mi_register_perpoli_harian", $MenuLanguage->MenuPhrase("6282", "MenuText"), $MenuRelativePath . "RegisterPerpoliHarian", 4786, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}register_perpoli_harian'), false, false, "", "", false);
$sideMenu->addMenuItem(6283, "mi_register_perpoli_bulanan", $MenuLanguage->MenuPhrase("6283", "MenuText"), $MenuRelativePath . "RegisterPerpoliBulanan", 4786, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}register_perpoli_bulanan'), false, false, "", "", false);
$sideMenu->addMenuItem(6284, "mi_register_perpoli_tahunan", $MenuLanguage->MenuPhrase("6284", "MenuText"), $MenuRelativePath . "RegisterPerpoliTahunan", 4786, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}register_perpoli_tahunan'), false, false, "", "", false);
$sideMenu->addMenuItem(148, "mi_EMPLOYEE_ALL", $MenuLanguage->MenuPhrase("148", "MenuText"), $MenuRelativePath . "EmployeeAllList", 3323, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}EMPLOYEE_ALL'), false, false, "", "", false);
$sideMenu->addMenuItem(1413, "mci_Rawat_Inap", $MenuLanguage->MenuPhrase("1413", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4288, "mi_V_KUNJUNGAN_PASIEN", $MenuLanguage->MenuPhrase("4288", "MenuText"), $MenuRelativePath . "VKunjunganPasienList", 1413, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_KUNJUNGAN_PASIEN'), false, false, "", "", false);
$sideMenu->addMenuItem(6799, "mi_V_RAWAT_INAP", $MenuLanguage->MenuPhrase("6799", "MenuText"), $MenuRelativePath . "VRawatInapList", 1413, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_RAWAT_INAP'), false, false, "", "", false);
$sideMenu->addMenuItem(76, "mi_CLASS_ROOM", $MenuLanguage->MenuPhrase("76", "MenuText"), $MenuRelativePath . "ClassRoomList", 1413, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}CLASS_ROOM'), false, false, "", "", false);
$sideMenu->addMenuItem(5273, "mci_Laporan", $MenuLanguage->MenuPhrase("5273", "MenuText"), "", 1413, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6285, "mi_register_ranap", $MenuLanguage->MenuPhrase("6285", "MenuText"), $MenuRelativePath . "RegisterRanap", 5273, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}register_ranap'), false, false, "", "", false);
$sideMenu->addMenuItem(3804, "mci_Laboratorium", $MenuLanguage->MenuPhrase("3804", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6277, "mi_V_LABORATORIUM", $MenuLanguage->MenuPhrase("6277", "MenuText"), $MenuRelativePath . "VLaboratoriumList", 3804, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_LABORATORIUM'), false, false, "", "", false);
$sideMenu->addMenuItem(4281, "mci_Radiologi", $MenuLanguage->MenuPhrase("4281", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6278, "mi_V_RADIOLOGI", $MenuLanguage->MenuPhrase("6278", "MenuText"), $MenuRelativePath . "VRadiologiList", 4281, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_RADIOLOGI'), false, false, "", "", false);
$sideMenu->addMenuItem(1881, "mci_Farmasi", $MenuLanguage->MenuPhrase("1881", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6274, "mi_V_FARMASI", $MenuLanguage->MenuPhrase("6274", "MenuText"), $MenuRelativePath . "VFarmasiList", 1881, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_FARMASI'), false, false, "", "", false);
$sideMenu->addMenuItem(1880, "mci_Kasir", $MenuLanguage->MenuPhrase("1880", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(466, "mi_V_TREATMENTBILL", $MenuLanguage->MenuPhrase("466", "MenuText"), $MenuRelativePath . "VTreatmentbillList", 1880, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_TREATMENTBILL'), false, false, "", "", false);
$sideMenu->addMenuItem(6275, "mi_V_KASIR", $MenuLanguage->MenuPhrase("6275", "MenuText"), $MenuRelativePath . "VKasirList", 1880, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_KASIR'), false, false, "", "", false);
$sideMenu->addMenuItem(2363, "mci_Rekam_Medik", $MenuLanguage->MenuPhrase("2363", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(6276, "mi_V_REKAM_MEDIS", $MenuLanguage->MenuPhrase("6276", "MenuText"), $MenuRelativePath . "VRekamMedisList", 2363, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_REKAM_MEDIS'), false, false, "", "", false);
$sideMenu->addMenuItem(293, "mi_OBSTETRI", $MenuLanguage->MenuPhrase("293", "MenuText"), $MenuRelativePath . "ObstetriList", 2363, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}OBSTETRI'), false, false, "", "", false);
$sideMenu->addMenuItem(6268, "mi_V_RIWAYAT_RM", $MenuLanguage->MenuPhrase("6268", "MenuText"), $MenuRelativePath . "VRiwayatRmList", 2363, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}V_RIWAYAT_RM'), false, false, "", "", false);
$sideMenu->addMenuItem(6261, "mci_Laporan", $MenuLanguage->MenuPhrase("6261", "MenuText"), "", 2363, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(5762, "mi_penyakit_menular", $MenuLanguage->MenuPhrase("5762", "MenuText"), $MenuRelativePath . "PenyakitMenular", 6261, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}penyakit_menular'), false, false, "", "", false);
$sideMenu->addMenuItem(6265, "mi_mata_dan_syaraf", $MenuLanguage->MenuPhrase("6265", "MenuText"), $MenuRelativePath . "MataDanSyaraf", 6261, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}mata_dan_syaraf'), false, false, "", "", false);
$sideMenu->addMenuItem(6263, "mci_Master", $MenuLanguage->MenuPhrase("6263", "MenuText"), "", 2363, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(123, "mi_DIAGNOSA", $MenuLanguage->MenuPhrase("123", "MenuText"), $MenuRelativePath . "DiagnosaList", 6263, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}DIAGNOSA'), false, false, "", "", false);
$sideMenu->addMenuItem(1882, "mci_CSSD", $MenuLanguage->MenuPhrase("1882", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(1885, "mci_Sterilisasi_Alat", $MenuLanguage->MenuPhrase("1885", "MenuText"), "", 1882, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4787, "mci_Master", $MenuLanguage->MenuPhrase("4787", "MenuText"), "", 1882, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(4284, "mi_l_set_cssd", $MenuLanguage->MenuPhrase("4284", "MenuText"), $MenuRelativePath . "LSetCssdList", 4787, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}l_set_cssd'), false, false, "", "", false);
$sideMenu->addMenuItem(4285, "mi_m_alat_cssd", $MenuLanguage->MenuPhrase("4285", "MenuText"), $MenuRelativePath . "MAlatCssdList", 4787, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}m_alat_cssd'), false, false, "", "", false);
$sideMenu->addMenuItem(1883, "mci_Mutasi_Barang", $MenuLanguage->MenuPhrase("1883", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(1887, "mci_Permintaan_Barang_Alkes", $MenuLanguage->MenuPhrase("1887", "MenuText"), $MenuRelativePath . "MutationDocsAdd?showdetail=", 1883, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(284, "mi_MUTATION_DOCS", $MenuLanguage->MenuPhrase("284", "MenuText"), $MenuRelativePath . "MutationDocsList", 1883, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}MUTATION_DOCS'), false, false, "", "", false);
$sideMenu->addMenuItem(6797, "mci_Gudang_Farmasi", $MenuLanguage->MenuPhrase("6797", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(173, "mi_GOOD_GF", $MenuLanguage->MenuPhrase("173", "MenuText"), $MenuRelativePath . "GoodGfList?cmd=resetall", 6797, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}GOOD_GF'), false, false, "", "", false);
$sideMenu->addMenuItem(177, "mi_GOODS", $MenuLanguage->MenuPhrase("177", "MenuText"), $MenuRelativePath . "GoodsList", 173, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}GOODS'), false, false, "", "", false);
$sideMenu->addMenuItem(240, "mi_ITEM_CONDITION", $MenuLanguage->MenuPhrase("240", "MenuText"), $MenuRelativePath . "ItemConditionList", 173, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}ITEM_CONDITION'), false, false, "", "", false);
$sideMenu->addMenuItem(182, "mi_GOODS_STOCK", $MenuLanguage->MenuPhrase("182", "MenuText"), $MenuRelativePath . "GoodsStockList", 173, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}GOODS_STOCK'), false, false, "", "", false);
$sideMenu->addMenuItem(273, "mi_MEASUREMENT", $MenuLanguage->MenuPhrase("273", "MenuText"), $MenuRelativePath . "MeasurementList", 6797, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}MEASUREMENT'), false, false, "", "", false);
$sideMenu->addMenuItem(178, "mi_GOODS_FORM", $MenuLanguage->MenuPhrase("178", "MenuText"), $MenuRelativePath . "GoodsFormList", 6797, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}GOODS_FORM'), false, false, "", "", false);
$sideMenu->addMenuItem(940, "mci_Setting", $MenuLanguage->MenuPhrase("940", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(448, "mi_USER_LOGIN", $MenuLanguage->MenuPhrase("448", "MenuText"), $MenuRelativePath . "UserLoginList", 940, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}USER_LOGIN'), false, false, "", "", false);
$sideMenu->addMenuItem(430, "mi_TREAT_TARIF", $MenuLanguage->MenuPhrase("430", "MenuText"), $MenuRelativePath . "TreatTarifList", 940, "", AllowListMenu('{EC51D6F4-271B-4304-A9FC-094E2F86F527}TREAT_TARIF'), false, false, "", "", false);
echo $sideMenu->toScript();
