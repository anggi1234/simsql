<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for TREATMENT_AKOMODASI
 */
class TreatmentAkomodasi extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $ORG_UNIT_CODE;
    public $BILL_ID;
    public $NO_REGISTRATION;
    public $VISIT_ID;
    public $TARIF_ID;
    public $CLASS_ID;
    public $CLINIC_ID;
    public $CLINIC_ID_FROM;
    public $TREATMENT;
    public $TREAT_DATE;
    public $QUANTITY;
    public $MEASURE_ID;
    public $DESCRIPTION;
    public $CLASS_ROOM_ID;
    public $KELUAR_ID;
    public $BED_ID;
    public $EMPLOYEE_ID;
    public $DOCTOR;
    public $EXIT_DATE;
    public $EMPLOYEE_ID_FROM;
    public $DOCTOR_FROM;
    public $STATUS_PASIEN_ID;
    public $DIAGNOSA_ID;
    public $THENAME;
    public $THEADDRESS;
    public $THEID;
    public $ISRJ;
    public $AGEYEAR;
    public $AGEMONTH;
    public $AGEDAY;
    public $GENDER;
    public $KARYAWAN;
    public $MODIFIED_BY;
    public $MODIFIED_DATE;
    public $MODIFIED_FROM;
    public $POTONGAN;
    public $BAYAR;
    public $RETUR;
    public $TARIF_TYPE;
    public $PPNVALUE;
    public $TAGIHAN;
    public $KOREKSI;
    public $AMOUNT_PAID;
    public $DISKON;
    public $NOTA_NO;
    public $SELL_PRICE;
    public $ACCOUNT_ID;
    public $subsidi;
    public $DISCOUNT;
    public $AMOUNT;
    public $PPN;
    public $SUBSIDISAT;
    public $PRINTQ;
    public $PRINTED_BY;
    public $STATUS_TARIF;
    public $CLINIC_TYPE;
    public $PACKAGE_ID;
    public $MODULE_ID;
    public $THEORDER;
    public $CORRECTION_ID;
    public $CORRECTION_BY;
    public $CASHIER;
    public $PAYOR_ID;
    public $KAL_ID;
    public $NO_SKPINAP;
    public $RESPON;
    public $NOKARTU;
    public $PASIEN_ID;
    public $modified_datesys;
    public $MAPPING_SEP;
    public $TRANS_ID;
    public $SPPBILL;
    public $SPPBILLDATE;
    public $SPPBILLUSER;
    public $SPPKASIR;
    public $SPPKASIRDATE;
    public $SPPKASIRUSER;
    public $SPPPOLI;
    public $SPPPOLIUSER;
    public $SPPPOLIDATE;
    public $NO_SURAT_KET;
    public $ID;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'TREATMENT_AKOMODASI';
        $this->TableName = 'TREATMENT_AKOMODASI';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[TREATMENT_AKOMODASI]";
        $this->Dbid = 'DB';
        $this->ExportAll = false;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_ORG_UNIT_CODE', 'ORG_UNIT_CODE', '[ORG_UNIT_CODE]', '[ORG_UNIT_CODE]', 200, 50, -1, false, '[ORG_UNIT_CODE]', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->ORG_UNIT_CODE->Sortable = false; // Allow sort
        $this->ORG_UNIT_CODE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORG_UNIT_CODE->Param, "CustomMsg");
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValueDefault = "1604031";
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperatorDefault = "LIKE";
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperatorDefault2 = "";
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchConditionDefault = "AND";
        $this->Fields['ORG_UNIT_CODE'] = &$this->ORG_UNIT_CODE;

        // BILL_ID
        $this->BILL_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_BILL_ID', 'BILL_ID', '[BILL_ID]', '[BILL_ID]', 200, 50, -1, false, '[BILL_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BILL_ID->Nullable = false; // NOT NULL field
        $this->BILL_ID->Required = true; // Required field
        $this->BILL_ID->Sortable = false; // Allow sort
        $this->BILL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BILL_ID->Param, "CustomMsg");
        $this->Fields['BILL_ID'] = &$this->BILL_ID;

        // NO_REGISTRATION
        $this->NO_REGISTRATION = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_NO_REGISTRATION', 'NO_REGISTRATION', '[NO_REGISTRATION]', '[NO_REGISTRATION]', 200, 25, -1, false, '[NO_REGISTRATION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_REGISTRATION->IsForeignKey = true; // Foreign key field
        $this->NO_REGISTRATION->Nullable = false; // NOT NULL field
        $this->NO_REGISTRATION->Required = true; // Required field
        $this->NO_REGISTRATION->Sortable = false; // Allow sort
        $this->NO_REGISTRATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_REGISTRATION->Param, "CustomMsg");
        $this->Fields['NO_REGISTRATION'] = &$this->NO_REGISTRATION;

        // VISIT_ID
        $this->VISIT_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_VISIT_ID', 'VISIT_ID', '[VISIT_ID]', '[VISIT_ID]', 200, 50, -1, false, '[VISIT_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISIT_ID->IsForeignKey = true; // Foreign key field
        $this->VISIT_ID->Nullable = false; // NOT NULL field
        $this->VISIT_ID->Required = true; // Required field
        $this->VISIT_ID->Sortable = false; // Allow sort
        $this->VISIT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_ID->Param, "CustomMsg");
        $this->Fields['VISIT_ID'] = &$this->VISIT_ID;

        // TARIF_ID
        $this->TARIF_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_TARIF_ID', 'TARIF_ID', '[TARIF_ID]', '[TARIF_ID]', 200, 25, -1, false, '[TARIF_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->TARIF_ID->Sortable = false; // Allow sort
        $this->TARIF_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->TARIF_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->TARIF_ID->Lookup = new Lookup('TARIF_ID', 'TREAT_TARIF', false, 'TARIF_ID', ["TARIF_NAME","","",""], [], [], [], [], ["TARIF_NAME"], ["x_TREATMENT"], '', '');
                break;
            default:
                $this->TARIF_ID->Lookup = new Lookup('TARIF_ID', 'TREAT_TARIF', false, 'TARIF_ID', ["TARIF_NAME","","",""], [], [], [], [], ["TARIF_NAME"], ["x_TREATMENT"], '', '');
                break;
        }
        $this->TARIF_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TARIF_ID->Param, "CustomMsg");
        $this->Fields['TARIF_ID'] = &$this->TARIF_ID;

        // CLASS_ID
        $this->CLASS_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CLASS_ID', 'CLASS_ID', '[CLASS_ID]', 'CAST([CLASS_ID] AS NVARCHAR)', 17, 1, -1, false, '[CLASS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ID->Sortable = false; // Allow sort
        $this->CLASS_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLASS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ID->Param, "CustomMsg");
        $this->Fields['CLASS_ID'] = &$this->CLASS_ID;

        // CLINIC_ID
        $this->CLINIC_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CLINIC_ID', 'CLINIC_ID', '[CLINIC_ID]', '[CLINIC_ID]', 200, 15, -1, false, '[CLINIC_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLINIC_ID->Sortable = false; // Allow sort
        $this->CLINIC_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLINIC_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLINIC_ID->Lookup = new Lookup('CLINIC_ID', 'CLINIC', false, 'CLINIC_ID', ["NAME_OF_CLINIC","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CLINIC_ID->Lookup = new Lookup('CLINIC_ID', 'CLINIC', false, 'CLINIC_ID', ["NAME_OF_CLINIC","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CLINIC_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID->Param, "CustomMsg");
        $this->Fields['CLINIC_ID'] = &$this->CLINIC_ID;

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CLINIC_ID_FROM', 'CLINIC_ID_FROM', '[CLINIC_ID_FROM]', '[CLINIC_ID_FROM]', 200, 15, -1, false, '[CLINIC_ID_FROM]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLINIC_ID_FROM->Sortable = false; // Allow sort
        $this->CLINIC_ID_FROM->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLINIC_ID_FROM->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLINIC_ID_FROM->Lookup = new Lookup('CLINIC_ID_FROM', 'CLINIC', false, 'CLINIC_ID', ["CLINIC_TYPE","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CLINIC_ID_FROM->Lookup = new Lookup('CLINIC_ID_FROM', 'CLINIC', false, 'CLINIC_ID', ["CLINIC_TYPE","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CLINIC_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID_FROM->Param, "CustomMsg");
        $this->Fields['CLINIC_ID_FROM'] = &$this->CLINIC_ID_FROM;

        // TREATMENT
        $this->TREATMENT = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_TREATMENT', 'TREATMENT', '[TREATMENT]', '[TREATMENT]', 200, 200, -1, false, '[TREATMENT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREATMENT->Sortable = false; // Allow sort
        $this->TREATMENT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREATMENT->Param, "CustomMsg");
        $this->Fields['TREATMENT'] = &$this->TREATMENT;

        // TREAT_DATE
        $this->TREAT_DATE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_TREAT_DATE', 'TREAT_DATE', '[TREAT_DATE]', CastDateFieldForLike("[TREAT_DATE]", 111, "DB"), 135, 8, 111, false, '[TREAT_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TREAT_DATE->Sortable = true; // Allow sort
        $this->TREAT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->TREAT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TREAT_DATE->Param, "CustomMsg");
        $this->Fields['TREAT_DATE'] = &$this->TREAT_DATE;

        // QUANTITY
        $this->QUANTITY = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_QUANTITY', 'QUANTITY', '[QUANTITY]', 'CAST([QUANTITY] AS NVARCHAR)', 131, 8, -1, false, '[QUANTITY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->QUANTITY->Sortable = false; // Allow sort
        $this->QUANTITY->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->QUANTITY->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->QUANTITY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->QUANTITY->Param, "CustomMsg");
        $this->Fields['QUANTITY'] = &$this->QUANTITY;

        // MEASURE_ID
        $this->MEASURE_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_MEASURE_ID', 'MEASURE_ID', '[MEASURE_ID]', 'CAST([MEASURE_ID] AS NVARCHAR)', 2, 2, -1, false, '[MEASURE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MEASURE_ID->Sortable = false; // Allow sort
        $this->MEASURE_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->MEASURE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MEASURE_ID->Param, "CustomMsg");
        $this->Fields['MEASURE_ID'] = &$this->MEASURE_ID;

        // DESCRIPTION
        $this->DESCRIPTION = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_DESCRIPTION', 'DESCRIPTION', '[DESCRIPTION]', '[DESCRIPTION]', 200, 200, -1, false, '[DESCRIPTION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DESCRIPTION->Sortable = false; // Allow sort
        $this->DESCRIPTION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DESCRIPTION->Param, "CustomMsg");
        $this->Fields['DESCRIPTION'] = &$this->DESCRIPTION;

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CLASS_ROOM_ID', 'CLASS_ROOM_ID', '[CLASS_ROOM_ID]', '[CLASS_ROOM_ID]', 200, 16, -1, false, '[CLASS_ROOM_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->CLASS_ROOM_ID->Sortable = false; // Allow sort
        $this->CLASS_ROOM_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->CLASS_ROOM_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->CLASS_ROOM_ID->Lookup = new Lookup('CLASS_ROOM_ID', 'CLASS_ROOM', false, 'CLASS_ROOM_ID', ["NAME_OF_CLASS","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->CLASS_ROOM_ID->Lookup = new Lookup('CLASS_ROOM_ID', 'CLASS_ROOM', false, 'CLASS_ROOM_ID', ["NAME_OF_CLASS","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->CLASS_ROOM_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ROOM_ID->Param, "CustomMsg");
        $this->Fields['CLASS_ROOM_ID'] = &$this->CLASS_ROOM_ID;

        // KELUAR_ID
        $this->KELUAR_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_KELUAR_ID', 'KELUAR_ID', '[KELUAR_ID]', 'CAST([KELUAR_ID] AS NVARCHAR)', 17, 1, -1, false, '[KELUAR_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->KELUAR_ID->Sortable = false; // Allow sort
        $this->KELUAR_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->KELUAR_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->KELUAR_ID->Lookup = new Lookup('KELUAR_ID', 'CARA_KELUAR', false, 'KELUAR_ID', ["CARA_KELUAR","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->KELUAR_ID->Lookup = new Lookup('KELUAR_ID', 'CARA_KELUAR', false, 'KELUAR_ID', ["CARA_KELUAR","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->KELUAR_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->KELUAR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KELUAR_ID->Param, "CustomMsg");
        $this->Fields['KELUAR_ID'] = &$this->KELUAR_ID;

        // BED_ID
        $this->BED_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_BED_ID', 'BED_ID', '[BED_ID]', 'CAST([BED_ID] AS NVARCHAR)', 17, 1, -1, false, '[BED_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->BED_ID->Sortable = false; // Allow sort
        $this->BED_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->BED_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->BED_ID->Lookup = new Lookup('BED_ID', 'BEDS', false, 'BED_ID', ["BED_ID","CLASS_ROOM_ID","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->BED_ID->Lookup = new Lookup('BED_ID', 'BEDS', false, 'BED_ID', ["BED_ID","CLASS_ROOM_ID","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->BED_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->BED_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BED_ID->Param, "CustomMsg");
        $this->Fields['BED_ID'] = &$this->BED_ID;

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_EMPLOYEE_ID', 'EMPLOYEE_ID', '[EMPLOYEE_ID]', '[EMPLOYEE_ID]', 200, 15, -1, false, '[EMPLOYEE_ID]', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->EMPLOYEE_ID->Sortable = false; // Allow sort
        $this->EMPLOYEE_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->EMPLOYEE_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->EMPLOYEE_ID->Lookup = new Lookup('EMPLOYEE_ID', 'EMPLOYEE_ALL', false, 'EMPLOYEE_ID', ["FULLNAME","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->EMPLOYEE_ID->Lookup = new Lookup('EMPLOYEE_ID', 'EMPLOYEE_ALL', false, 'EMPLOYEE_ID', ["FULLNAME","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->EMPLOYEE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID->Param, "CustomMsg");
        $this->Fields['EMPLOYEE_ID'] = &$this->EMPLOYEE_ID;

        // DOCTOR
        $this->DOCTOR = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_DOCTOR', 'DOCTOR', '[DOCTOR]', '[DOCTOR]', 200, 100, -1, false, '[DOCTOR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DOCTOR->Sortable = false; // Allow sort
        $this->DOCTOR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DOCTOR->Param, "CustomMsg");
        $this->Fields['DOCTOR'] = &$this->DOCTOR;

        // EXIT_DATE
        $this->EXIT_DATE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_EXIT_DATE', 'EXIT_DATE', '[EXIT_DATE]', CastDateFieldForLike("[EXIT_DATE]", 17, "DB"), 135, 8, 17, false, '[EXIT_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EXIT_DATE->Sortable = false; // Allow sort
        $this->EXIT_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
        $this->EXIT_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EXIT_DATE->Param, "CustomMsg");
        $this->Fields['EXIT_DATE'] = &$this->EXIT_DATE;

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_EMPLOYEE_ID_FROM', 'EMPLOYEE_ID_FROM', '[EMPLOYEE_ID_FROM]', '[EMPLOYEE_ID_FROM]', 200, 50, -1, false, '[EMPLOYEE_ID_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EMPLOYEE_ID_FROM->Sortable = false; // Allow sort
        $this->EMPLOYEE_ID_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID_FROM->Param, "CustomMsg");
        $this->Fields['EMPLOYEE_ID_FROM'] = &$this->EMPLOYEE_ID_FROM;

        // DOCTOR_FROM
        $this->DOCTOR_FROM = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_DOCTOR_FROM', 'DOCTOR_FROM', '[DOCTOR_FROM]', '[DOCTOR_FROM]', 200, 50, -1, false, '[DOCTOR_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DOCTOR_FROM->Sortable = false; // Allow sort
        $this->DOCTOR_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DOCTOR_FROM->Param, "CustomMsg");
        $this->Fields['DOCTOR_FROM'] = &$this->DOCTOR_FROM;

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_STATUS_PASIEN_ID', 'STATUS_PASIEN_ID', '[STATUS_PASIEN_ID]', 'CAST([STATUS_PASIEN_ID] AS NVARCHAR)', 17, 1, -1, false, '[STATUS_PASIEN_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STATUS_PASIEN_ID->Sortable = false; // Allow sort
        $this->STATUS_PASIEN_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->STATUS_PASIEN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STATUS_PASIEN_ID->Param, "CustomMsg");
        $this->Fields['STATUS_PASIEN_ID'] = &$this->STATUS_PASIEN_ID;

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_DIAGNOSA_ID', 'DIAGNOSA_ID', '[DIAGNOSA_ID]', '[DIAGNOSA_ID]', 200, 50, -1, false, '[DIAGNOSA_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_ID->Sortable = false; // Allow sort
        $this->DIAGNOSA_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_ID->Param, "CustomMsg");
        $this->Fields['DIAGNOSA_ID'] = &$this->DIAGNOSA_ID;

        // THENAME
        $this->THENAME = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_THENAME', 'THENAME', '[THENAME]', '[THENAME]', 200, 100, -1, false, '[THENAME]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THENAME->IsForeignKey = true; // Foreign key field
        $this->THENAME->Sortable = false; // Allow sort
        $this->THENAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THENAME->Param, "CustomMsg");
        $this->Fields['THENAME'] = &$this->THENAME;

        // THEADDRESS
        $this->THEADDRESS = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_THEADDRESS', 'THEADDRESS', '[THEADDRESS]', '[THEADDRESS]', 200, 150, -1, false, '[THEADDRESS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEADDRESS->IsForeignKey = true; // Foreign key field
        $this->THEADDRESS->Sortable = false; // Allow sort
        $this->THEADDRESS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEADDRESS->Param, "CustomMsg");
        $this->Fields['THEADDRESS'] = &$this->THEADDRESS;

        // THEID
        $this->THEID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_THEID', 'THEID', '[THEID]', '[THEID]', 200, 25, -1, false, '[THEID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEID->Sortable = false; // Allow sort
        $this->THEID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEID->Param, "CustomMsg");
        $this->Fields['THEID'] = &$this->THEID;

        // ISRJ
        $this->ISRJ = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_ISRJ', 'ISRJ', '[ISRJ]', '[ISRJ]', 129, 1, -1, false, '[ISRJ]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISRJ->Sortable = false; // Allow sort
        $this->ISRJ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISRJ->Param, "CustomMsg");
        $this->Fields['ISRJ'] = &$this->ISRJ;

        // AGEYEAR
        $this->AGEYEAR = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_AGEYEAR', 'AGEYEAR', '[AGEYEAR]', 'CAST([AGEYEAR] AS NVARCHAR)', 17, 1, -1, false, '[AGEYEAR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEYEAR->Sortable = false; // Allow sort
        $this->AGEYEAR->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEYEAR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEYEAR->Param, "CustomMsg");
        $this->Fields['AGEYEAR'] = &$this->AGEYEAR;

        // AGEMONTH
        $this->AGEMONTH = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_AGEMONTH', 'AGEMONTH', '[AGEMONTH]', 'CAST([AGEMONTH] AS NVARCHAR)', 17, 1, -1, false, '[AGEMONTH]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEMONTH->Sortable = false; // Allow sort
        $this->AGEMONTH->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEMONTH->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEMONTH->Param, "CustomMsg");
        $this->Fields['AGEMONTH'] = &$this->AGEMONTH;

        // AGEDAY
        $this->AGEDAY = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_AGEDAY', 'AGEDAY', '[AGEDAY]', 'CAST([AGEDAY] AS NVARCHAR)', 17, 1, -1, false, '[AGEDAY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEDAY->Sortable = false; // Allow sort
        $this->AGEDAY->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEDAY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEDAY->Param, "CustomMsg");
        $this->Fields['AGEDAY'] = &$this->AGEDAY;

        // GENDER
        $this->GENDER = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_GENDER', 'GENDER', '[GENDER]', '[GENDER]', 129, 1, -1, false, '[GENDER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->GENDER->Sortable = false; // Allow sort
        $this->GENDER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->GENDER->Param, "CustomMsg");
        $this->Fields['GENDER'] = &$this->GENDER;

        // KARYAWAN
        $this->KARYAWAN = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_KARYAWAN', 'KARYAWAN', '[KARYAWAN]', '[KARYAWAN]', 200, 50, -1, false, '[KARYAWAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KARYAWAN->Sortable = false; // Allow sort
        $this->KARYAWAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KARYAWAN->Param, "CustomMsg");
        $this->Fields['KARYAWAN'] = &$this->KARYAWAN;

        // MODIFIED_BY
        $this->MODIFIED_BY = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_MODIFIED_BY', 'MODIFIED_BY', '[MODIFIED_BY]', '[MODIFIED_BY]', 200, 200, -1, false, '[MODIFIED_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_BY->Sortable = false; // Allow sort
        $this->MODIFIED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_BY->Param, "CustomMsg");
        $this->Fields['MODIFIED_BY'] = &$this->MODIFIED_BY;

        // MODIFIED_DATE
        $this->MODIFIED_DATE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_MODIFIED_DATE', 'MODIFIED_DATE', '[MODIFIED_DATE]', CastDateFieldForLike("[MODIFIED_DATE]", 17, "DB"), 135, 8, 17, false, '[MODIFIED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_DATE->Sortable = false; // Allow sort
        $this->MODIFIED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
        $this->MODIFIED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_DATE->Param, "CustomMsg");
        $this->Fields['MODIFIED_DATE'] = &$this->MODIFIED_DATE;

        // MODIFIED_FROM
        $this->MODIFIED_FROM = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_MODIFIED_FROM', 'MODIFIED_FROM', '[MODIFIED_FROM]', '[MODIFIED_FROM]', 200, 50, -1, false, '[MODIFIED_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_FROM->Sortable = false; // Allow sort
        $this->MODIFIED_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_FROM->Param, "CustomMsg");
        $this->Fields['MODIFIED_FROM'] = &$this->MODIFIED_FROM;

        // POTONGAN
        $this->POTONGAN = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_POTONGAN', 'POTONGAN', '[POTONGAN]', 'CAST([POTONGAN] AS NVARCHAR)', 6, 8, -1, false, '[POTONGAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->POTONGAN->Sortable = false; // Allow sort
        $this->POTONGAN->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->POTONGAN->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->POTONGAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->POTONGAN->Param, "CustomMsg");
        $this->Fields['POTONGAN'] = &$this->POTONGAN;

        // BAYAR
        $this->BAYAR = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_BAYAR', 'BAYAR', '[BAYAR]', 'CAST([BAYAR] AS NVARCHAR)', 6, 8, -1, false, '[BAYAR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BAYAR->Sortable = false; // Allow sort
        $this->BAYAR->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->BAYAR->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->BAYAR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BAYAR->Param, "CustomMsg");
        $this->Fields['BAYAR'] = &$this->BAYAR;

        // RETUR
        $this->RETUR = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_RETUR', 'RETUR', '[RETUR]', 'CAST([RETUR] AS NVARCHAR)', 6, 8, -1, false, '[RETUR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RETUR->Sortable = false; // Allow sort
        $this->RETUR->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->RETUR->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->RETUR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RETUR->Param, "CustomMsg");
        $this->Fields['RETUR'] = &$this->RETUR;

        // TARIF_TYPE
        $this->TARIF_TYPE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_TARIF_TYPE', 'TARIF_TYPE', '[TARIF_TYPE]', '[TARIF_TYPE]', 200, 50, -1, false, '[TARIF_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TARIF_TYPE->Sortable = false; // Allow sort
        $this->TARIF_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TARIF_TYPE->Param, "CustomMsg");
        $this->Fields['TARIF_TYPE'] = &$this->TARIF_TYPE;

        // PPNVALUE
        $this->PPNVALUE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PPNVALUE', 'PPNVALUE', '[PPNVALUE]', 'CAST([PPNVALUE] AS NVARCHAR)', 6, 8, -1, false, '[PPNVALUE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PPNVALUE->Sortable = false; // Allow sort
        $this->PPNVALUE->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->PPNVALUE->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->PPNVALUE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PPNVALUE->Param, "CustomMsg");
        $this->Fields['PPNVALUE'] = &$this->PPNVALUE;

        // TAGIHAN
        $this->TAGIHAN = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_TAGIHAN', 'TAGIHAN', '[TAGIHAN]', 'CAST([TAGIHAN] AS NVARCHAR)', 6, 8, -1, false, '[TAGIHAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TAGIHAN->Sortable = false; // Allow sort
        $this->TAGIHAN->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->TAGIHAN->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->TAGIHAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TAGIHAN->Param, "CustomMsg");
        $this->Fields['TAGIHAN'] = &$this->TAGIHAN;

        // KOREKSI
        $this->KOREKSI = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_KOREKSI', 'KOREKSI', '[KOREKSI]', 'CAST([KOREKSI] AS NVARCHAR)', 6, 8, -1, false, '[KOREKSI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KOREKSI->Sortable = false; // Allow sort
        $this->KOREKSI->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->KOREKSI->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->KOREKSI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KOREKSI->Param, "CustomMsg");
        $this->Fields['KOREKSI'] = &$this->KOREKSI;

        // AMOUNT_PAID
        $this->AMOUNT_PAID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_AMOUNT_PAID', 'AMOUNT_PAID', '[AMOUNT_PAID]', 'CAST([AMOUNT_PAID] AS NVARCHAR)', 6, 8, -1, false, '[AMOUNT_PAID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AMOUNT_PAID->Sortable = false; // Allow sort
        $this->AMOUNT_PAID->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->AMOUNT_PAID->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->AMOUNT_PAID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AMOUNT_PAID->Param, "CustomMsg");
        $this->Fields['AMOUNT_PAID'] = &$this->AMOUNT_PAID;

        // DISKON
        $this->DISKON = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_DISKON', 'DISKON', '[DISKON]', 'CAST([DISKON] AS NVARCHAR)', 6, 8, -1, false, '[DISKON]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DISKON->Sortable = false; // Allow sort
        $this->DISKON->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DISKON->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DISKON->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DISKON->Param, "CustomMsg");
        $this->Fields['DISKON'] = &$this->DISKON;

        // NOTA_NO
        $this->NOTA_NO = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_NOTA_NO', 'NOTA_NO', '[NOTA_NO]', '[NOTA_NO]', 200, 50, -1, false, '[NOTA_NO]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOTA_NO->Sortable = false; // Allow sort
        $this->NOTA_NO->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOTA_NO->Param, "CustomMsg");
        $this->Fields['NOTA_NO'] = &$this->NOTA_NO;

        // SELL_PRICE
        $this->SELL_PRICE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SELL_PRICE', 'SELL_PRICE', '[SELL_PRICE]', 'CAST([SELL_PRICE] AS NVARCHAR)', 6, 8, -1, false, '[SELL_PRICE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SELL_PRICE->Sortable = false; // Allow sort
        $this->SELL_PRICE->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->SELL_PRICE->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->SELL_PRICE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SELL_PRICE->Param, "CustomMsg");
        $this->Fields['SELL_PRICE'] = &$this->SELL_PRICE;

        // ACCOUNT_ID
        $this->ACCOUNT_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_ACCOUNT_ID', 'ACCOUNT_ID', '[ACCOUNT_ID]', '[ACCOUNT_ID]', 200, 50, -1, false, '[ACCOUNT_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ACCOUNT_ID->Sortable = false; // Allow sort
        $this->ACCOUNT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ACCOUNT_ID->Param, "CustomMsg");
        $this->Fields['ACCOUNT_ID'] = &$this->ACCOUNT_ID;

        // subsidi
        $this->subsidi = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_subsidi', 'subsidi', '[subsidi]', 'CAST([subsidi] AS NVARCHAR)', 6, 8, -1, false, '[subsidi]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->subsidi->Sortable = false; // Allow sort
        $this->subsidi->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->subsidi->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->subsidi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->subsidi->Param, "CustomMsg");
        $this->Fields['subsidi'] = &$this->subsidi;

        // DISCOUNT
        $this->DISCOUNT = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_DISCOUNT', 'DISCOUNT', '[DISCOUNT]', 'CAST([DISCOUNT] AS NVARCHAR)', 131, 8, -1, false, '[DISCOUNT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DISCOUNT->Sortable = false; // Allow sort
        $this->DISCOUNT->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->DISCOUNT->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->DISCOUNT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DISCOUNT->Param, "CustomMsg");
        $this->Fields['DISCOUNT'] = &$this->DISCOUNT;

        // AMOUNT
        $this->AMOUNT = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_AMOUNT', 'AMOUNT', '[AMOUNT]', 'CAST([AMOUNT] AS NVARCHAR)', 6, 8, -1, false, '[AMOUNT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AMOUNT->Sortable = false; // Allow sort
        $this->AMOUNT->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->AMOUNT->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->AMOUNT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AMOUNT->Param, "CustomMsg");
        $this->Fields['AMOUNT'] = &$this->AMOUNT;

        // PPN
        $this->PPN = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PPN', 'PPN', '[PPN]', 'CAST([PPN] AS NVARCHAR)', 131, 8, -1, false, '[PPN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PPN->Sortable = false; // Allow sort
        $this->PPN->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->PPN->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->PPN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PPN->Param, "CustomMsg");
        $this->Fields['PPN'] = &$this->PPN;

        // SUBSIDISAT
        $this->SUBSIDISAT = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SUBSIDISAT', 'SUBSIDISAT', '[SUBSIDISAT]', 'CAST([SUBSIDISAT] AS NVARCHAR)', 6, 8, -1, false, '[SUBSIDISAT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SUBSIDISAT->Sortable = false; // Allow sort
        $this->SUBSIDISAT->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->SUBSIDISAT->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->SUBSIDISAT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SUBSIDISAT->Param, "CustomMsg");
        $this->Fields['SUBSIDISAT'] = &$this->SUBSIDISAT;

        // PRINTQ
        $this->PRINTQ = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PRINTQ', 'PRINTQ', '[PRINTQ]', 'CAST([PRINTQ] AS NVARCHAR)', 2, 2, -1, false, '[PRINTQ]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PRINTQ->Sortable = false; // Allow sort
        $this->PRINTQ->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->PRINTQ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PRINTQ->Param, "CustomMsg");
        $this->Fields['PRINTQ'] = &$this->PRINTQ;

        // PRINTED_BY
        $this->PRINTED_BY = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PRINTED_BY', 'PRINTED_BY', '[PRINTED_BY]', '[PRINTED_BY]', 200, 50, -1, false, '[PRINTED_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PRINTED_BY->Sortable = false; // Allow sort
        $this->PRINTED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PRINTED_BY->Param, "CustomMsg");
        $this->Fields['PRINTED_BY'] = &$this->PRINTED_BY;

        // STATUS_TARIF
        $this->STATUS_TARIF = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_STATUS_TARIF', 'STATUS_TARIF', '[STATUS_TARIF]', 'CAST([STATUS_TARIF] AS NVARCHAR)', 2, 2, -1, false, '[STATUS_TARIF]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STATUS_TARIF->Sortable = false; // Allow sort
        $this->STATUS_TARIF->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->STATUS_TARIF->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STATUS_TARIF->Param, "CustomMsg");
        $this->Fields['STATUS_TARIF'] = &$this->STATUS_TARIF;

        // CLINIC_TYPE
        $this->CLINIC_TYPE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CLINIC_TYPE', 'CLINIC_TYPE', '[CLINIC_TYPE]', 'CAST([CLINIC_TYPE] AS NVARCHAR)', 17, 1, -1, false, '[CLINIC_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_TYPE->Sortable = false; // Allow sort
        $this->CLINIC_TYPE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->CLINIC_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_TYPE->Param, "CustomMsg");
        $this->Fields['CLINIC_TYPE'] = &$this->CLINIC_TYPE;

        // PACKAGE_ID
        $this->PACKAGE_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PACKAGE_ID', 'PACKAGE_ID', '[PACKAGE_ID]', '[PACKAGE_ID]', 200, 50, -1, false, '[PACKAGE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PACKAGE_ID->Sortable = false; // Allow sort
        $this->PACKAGE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PACKAGE_ID->Param, "CustomMsg");
        $this->Fields['PACKAGE_ID'] = &$this->PACKAGE_ID;

        // MODULE_ID
        $this->MODULE_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_MODULE_ID', 'MODULE_ID', '[MODULE_ID]', '[MODULE_ID]', 200, 50, -1, false, '[MODULE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODULE_ID->Sortable = false; // Allow sort
        $this->MODULE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODULE_ID->Param, "CustomMsg");
        $this->Fields['MODULE_ID'] = &$this->MODULE_ID;

        // THEORDER
        $this->THEORDER = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_THEORDER', 'THEORDER', '[THEORDER]', 'CAST([THEORDER] AS NVARCHAR)', 2, 2, -1, false, '[THEORDER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEORDER->Sortable = false; // Allow sort
        $this->THEORDER->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->THEORDER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEORDER->Param, "CustomMsg");
        $this->Fields['THEORDER'] = &$this->THEORDER;

        // CORRECTION_ID
        $this->CORRECTION_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CORRECTION_ID', 'CORRECTION_ID', '[CORRECTION_ID]', '[CORRECTION_ID]', 200, 50, -1, false, '[CORRECTION_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CORRECTION_ID->Sortable = false; // Allow sort
        $this->CORRECTION_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CORRECTION_ID->Param, "CustomMsg");
        $this->Fields['CORRECTION_ID'] = &$this->CORRECTION_ID;

        // CORRECTION_BY
        $this->CORRECTION_BY = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CORRECTION_BY', 'CORRECTION_BY', '[CORRECTION_BY]', '[CORRECTION_BY]', 200, 50, -1, false, '[CORRECTION_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CORRECTION_BY->Sortable = false; // Allow sort
        $this->CORRECTION_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CORRECTION_BY->Param, "CustomMsg");
        $this->Fields['CORRECTION_BY'] = &$this->CORRECTION_BY;

        // CASHIER
        $this->CASHIER = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_CASHIER', 'CASHIER', '[CASHIER]', '[CASHIER]', 200, 50, -1, false, '[CASHIER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CASHIER->Sortable = false; // Allow sort
        $this->CASHIER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CASHIER->Param, "CustomMsg");
        $this->Fields['CASHIER'] = &$this->CASHIER;

        // PAYOR_ID
        $this->PAYOR_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PAYOR_ID', 'PAYOR_ID', '[PAYOR_ID]', '[PAYOR_ID]', 200, 50, -1, false, '[PAYOR_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PAYOR_ID->Sortable = false; // Allow sort
        $this->PAYOR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PAYOR_ID->Param, "CustomMsg");
        $this->Fields['PAYOR_ID'] = &$this->PAYOR_ID;

        // KAL_ID
        $this->KAL_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_KAL_ID', 'KAL_ID', '[KAL_ID]', '[KAL_ID]', 200, 50, -1, false, '[KAL_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KAL_ID->Sortable = false; // Allow sort
        $this->KAL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KAL_ID->Param, "CustomMsg");
        $this->Fields['KAL_ID'] = &$this->KAL_ID;

        // NO_SKPINAP
        $this->NO_SKPINAP = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_NO_SKPINAP', 'NO_SKPINAP', '[NO_SKPINAP]', '[NO_SKPINAP]', 200, 50, -1, false, '[NO_SKPINAP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_SKPINAP->Sortable = false; // Allow sort
        $this->NO_SKPINAP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_SKPINAP->Param, "CustomMsg");
        $this->Fields['NO_SKPINAP'] = &$this->NO_SKPINAP;

        // RESPON
        $this->RESPON = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_RESPON', 'RESPON', '[RESPON]', '[RESPON]', 201, 0, -1, false, '[RESPON]', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->RESPON->Sortable = false; // Allow sort
        $this->RESPON->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESPON->Param, "CustomMsg");
        $this->Fields['RESPON'] = &$this->RESPON;

        // NOKARTU
        $this->NOKARTU = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_NOKARTU', 'NOKARTU', '[NOKARTU]', '[NOKARTU]', 200, 50, -1, false, '[NOKARTU]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOKARTU->Sortable = false; // Allow sort
        $this->NOKARTU->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOKARTU->Param, "CustomMsg");
        $this->Fields['NOKARTU'] = &$this->NOKARTU;

        // PASIEN_ID
        $this->PASIEN_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_PASIEN_ID', 'PASIEN_ID', '[PASIEN_ID]', '[PASIEN_ID]', 200, 50, -1, false, '[PASIEN_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PASIEN_ID->Sortable = false; // Allow sort
        $this->PASIEN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PASIEN_ID->Param, "CustomMsg");
        $this->Fields['PASIEN_ID'] = &$this->PASIEN_ID;

        // modified_datesys
        $this->modified_datesys = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_modified_datesys', 'modified_datesys', '[modified_datesys]', CastDateFieldForLike("[modified_datesys]", 0, "DB"), 135, 8, 0, false, '[modified_datesys]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->modified_datesys->Sortable = false; // Allow sort
        $this->modified_datesys->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->modified_datesys->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->modified_datesys->Param, "CustomMsg");
        $this->Fields['modified_datesys'] = &$this->modified_datesys;

        // MAPPING_SEP
        $this->MAPPING_SEP = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_MAPPING_SEP', 'MAPPING_SEP', '[MAPPING_SEP]', '[MAPPING_SEP]', 200, 250, -1, false, '[MAPPING_SEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MAPPING_SEP->Sortable = false; // Allow sort
        $this->MAPPING_SEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MAPPING_SEP->Param, "CustomMsg");
        $this->Fields['MAPPING_SEP'] = &$this->MAPPING_SEP;

        // TRANS_ID
        $this->TRANS_ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_TRANS_ID', 'TRANS_ID', '[TRANS_ID]', '[TRANS_ID]', 200, 50, -1, false, '[TRANS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TRANS_ID->IsForeignKey = true; // Foreign key field
        $this->TRANS_ID->Sortable = false; // Allow sort
        $this->TRANS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TRANS_ID->Param, "CustomMsg");
        $this->Fields['TRANS_ID'] = &$this->TRANS_ID;

        // SPPBILL
        $this->SPPBILL = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPBILL', 'SPPBILL', '[SPPBILL]', '[SPPBILL]', 200, 50, -1, false, '[SPPBILL]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPBILL->Sortable = false; // Allow sort
        $this->SPPBILL->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPBILL->Param, "CustomMsg");
        $this->Fields['SPPBILL'] = &$this->SPPBILL;

        // SPPBILLDATE
        $this->SPPBILLDATE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPBILLDATE', 'SPPBILLDATE', '[SPPBILLDATE]', CastDateFieldForLike("[SPPBILLDATE]", 0, "DB"), 135, 8, 0, false, '[SPPBILLDATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPBILLDATE->Sortable = false; // Allow sort
        $this->SPPBILLDATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->SPPBILLDATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPBILLDATE->Param, "CustomMsg");
        $this->Fields['SPPBILLDATE'] = &$this->SPPBILLDATE;

        // SPPBILLUSER
        $this->SPPBILLUSER = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPBILLUSER', 'SPPBILLUSER', '[SPPBILLUSER]', '[SPPBILLUSER]', 200, 50, -1, false, '[SPPBILLUSER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPBILLUSER->Sortable = false; // Allow sort
        $this->SPPBILLUSER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPBILLUSER->Param, "CustomMsg");
        $this->Fields['SPPBILLUSER'] = &$this->SPPBILLUSER;

        // SPPKASIR
        $this->SPPKASIR = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPKASIR', 'SPPKASIR', '[SPPKASIR]', '[SPPKASIR]', 200, 50, -1, false, '[SPPKASIR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPKASIR->Sortable = false; // Allow sort
        $this->SPPKASIR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPKASIR->Param, "CustomMsg");
        $this->Fields['SPPKASIR'] = &$this->SPPKASIR;

        // SPPKASIRDATE
        $this->SPPKASIRDATE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPKASIRDATE', 'SPPKASIRDATE', '[SPPKASIRDATE]', CastDateFieldForLike("[SPPKASIRDATE]", 0, "DB"), 135, 8, 0, false, '[SPPKASIRDATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPKASIRDATE->Sortable = false; // Allow sort
        $this->SPPKASIRDATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->SPPKASIRDATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPKASIRDATE->Param, "CustomMsg");
        $this->Fields['SPPKASIRDATE'] = &$this->SPPKASIRDATE;

        // SPPKASIRUSER
        $this->SPPKASIRUSER = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPKASIRUSER', 'SPPKASIRUSER', '[SPPKASIRUSER]', '[SPPKASIRUSER]', 200, 50, -1, false, '[SPPKASIRUSER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPKASIRUSER->Sortable = false; // Allow sort
        $this->SPPKASIRUSER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPKASIRUSER->Param, "CustomMsg");
        $this->Fields['SPPKASIRUSER'] = &$this->SPPKASIRUSER;

        // SPPPOLI
        $this->SPPPOLI = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPPOLI', 'SPPPOLI', '[SPPPOLI]', '[SPPPOLI]', 200, 50, -1, false, '[SPPPOLI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPPOLI->Sortable = false; // Allow sort
        $this->SPPPOLI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPPOLI->Param, "CustomMsg");
        $this->Fields['SPPPOLI'] = &$this->SPPPOLI;

        // SPPPOLIUSER
        $this->SPPPOLIUSER = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPPOLIUSER', 'SPPPOLIUSER', '[SPPPOLIUSER]', '[SPPPOLIUSER]', 200, 50, -1, false, '[SPPPOLIUSER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPPOLIUSER->Sortable = false; // Allow sort
        $this->SPPPOLIUSER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPPOLIUSER->Param, "CustomMsg");
        $this->Fields['SPPPOLIUSER'] = &$this->SPPPOLIUSER;

        // SPPPOLIDATE
        $this->SPPPOLIDATE = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_SPPPOLIDATE', 'SPPPOLIDATE', '[SPPPOLIDATE]', CastDateFieldForLike("[SPPPOLIDATE]", 0, "DB"), 135, 8, 0, false, '[SPPPOLIDATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SPPPOLIDATE->Sortable = false; // Allow sort
        $this->SPPPOLIDATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->SPPPOLIDATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SPPPOLIDATE->Param, "CustomMsg");
        $this->Fields['SPPPOLIDATE'] = &$this->SPPPOLIDATE;

        // NO_SURAT_KET
        $this->NO_SURAT_KET = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_NO_SURAT_KET', 'NO_SURAT_KET', '[NO_SURAT_KET]', '[NO_SURAT_KET]', 200, 50, -1, false, '[NO_SURAT_KET]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_SURAT_KET->Sortable = false; // Allow sort
        $this->NO_SURAT_KET->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_SURAT_KET->Param, "CustomMsg");
        $this->Fields['NO_SURAT_KET'] = &$this->NO_SURAT_KET;

        // ID
        $this->ID = new DbField('TREATMENT_AKOMODASI', 'TREATMENT_AKOMODASI', 'x_ID', 'ID', '[ID]', 'CAST([ID] AS NVARCHAR)', 3, 4, -1, false, '[ID]', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->ID->IsAutoIncrement = true; // Autoincrement field
        $this->ID->IsPrimaryKey = true; // Primary key field
        $this->ID->Nullable = false; // NOT NULL field
        $this->ID->Sortable = false; // Allow sort
        $this->ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ID->Param, "CustomMsg");
        $this->Fields['ID'] = &$this->ID;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "PASIEN_VISITATION") {
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("[NO_REGISTRATION]", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->VISIT_ID->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[VISIT_ID]", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THENAME->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[DIANTAR_OLEH]", $this->THENAME->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THEADDRESS->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[VISITOR_ADDRESS]", $this->THEADDRESS->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $masterFilter .= " AND " . GetForeignKeySql("[TRANS_ID]", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "PASIEN_VISITATION") {
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("[NO_REGISTRATION]", $this->NO_REGISTRATION->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->VISIT_ID->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("[VISIT_ID]", $this->VISIT_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THENAME->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("[THENAME]", $this->THENAME->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->THEADDRESS->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("[THEADDRESS]", $this->THEADDRESS->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
            if ($this->TRANS_ID->getSessionValue() != "") {
                $detailFilter .= " AND " . GetForeignKeySql("[TRANS_ID]", $this->TRANS_ID->getSessionValue(), DATATYPE_STRING, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_PASIEN_VISITATION()
    {
        return "[NO_REGISTRATION]='@NO_REGISTRATION@' AND [VISIT_ID]='@VISIT_ID@' AND [DIANTAR_OLEH]='@DIANTAR_OLEH@' AND [VISITOR_ADDRESS]='@VISITOR_ADDRESS@' AND [TRANS_ID]='@TRANS_ID@'";
    }
    // Detail filter
    public function sqlDetailFilter_PASIEN_VISITATION()
    {
        return "[NO_REGISTRATION]='@NO_REGISTRATION@' AND [VISIT_ID]='@VISIT_ID@' AND [THENAME]='@THENAME@' AND [THEADDRESS]='@THEADDRESS@' AND [TRANS_ID]='@TRANS_ID@'";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[TREATMENT_AKOMODASI]";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->ID->setDbValue($conn->lastInsertId());
            $rs['ID'] = $this->ID->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('ID', $rs)) {
                AddFilter($where, QuotedName('ID', $this->Dbid) . '=' . QuotedValue($rs['ID'], $this->ID->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->ORG_UNIT_CODE->DbValue = $row['ORG_UNIT_CODE'];
        $this->BILL_ID->DbValue = $row['BILL_ID'];
        $this->NO_REGISTRATION->DbValue = $row['NO_REGISTRATION'];
        $this->VISIT_ID->DbValue = $row['VISIT_ID'];
        $this->TARIF_ID->DbValue = $row['TARIF_ID'];
        $this->CLASS_ID->DbValue = $row['CLASS_ID'];
        $this->CLINIC_ID->DbValue = $row['CLINIC_ID'];
        $this->CLINIC_ID_FROM->DbValue = $row['CLINIC_ID_FROM'];
        $this->TREATMENT->DbValue = $row['TREATMENT'];
        $this->TREAT_DATE->DbValue = $row['TREAT_DATE'];
        $this->QUANTITY->DbValue = $row['QUANTITY'];
        $this->MEASURE_ID->DbValue = $row['MEASURE_ID'];
        $this->DESCRIPTION->DbValue = $row['DESCRIPTION'];
        $this->CLASS_ROOM_ID->DbValue = $row['CLASS_ROOM_ID'];
        $this->KELUAR_ID->DbValue = $row['KELUAR_ID'];
        $this->BED_ID->DbValue = $row['BED_ID'];
        $this->EMPLOYEE_ID->DbValue = $row['EMPLOYEE_ID'];
        $this->DOCTOR->DbValue = $row['DOCTOR'];
        $this->EXIT_DATE->DbValue = $row['EXIT_DATE'];
        $this->EMPLOYEE_ID_FROM->DbValue = $row['EMPLOYEE_ID_FROM'];
        $this->DOCTOR_FROM->DbValue = $row['DOCTOR_FROM'];
        $this->STATUS_PASIEN_ID->DbValue = $row['STATUS_PASIEN_ID'];
        $this->DIAGNOSA_ID->DbValue = $row['DIAGNOSA_ID'];
        $this->THENAME->DbValue = $row['THENAME'];
        $this->THEADDRESS->DbValue = $row['THEADDRESS'];
        $this->THEID->DbValue = $row['THEID'];
        $this->ISRJ->DbValue = $row['ISRJ'];
        $this->AGEYEAR->DbValue = $row['AGEYEAR'];
        $this->AGEMONTH->DbValue = $row['AGEMONTH'];
        $this->AGEDAY->DbValue = $row['AGEDAY'];
        $this->GENDER->DbValue = $row['GENDER'];
        $this->KARYAWAN->DbValue = $row['KARYAWAN'];
        $this->MODIFIED_BY->DbValue = $row['MODIFIED_BY'];
        $this->MODIFIED_DATE->DbValue = $row['MODIFIED_DATE'];
        $this->MODIFIED_FROM->DbValue = $row['MODIFIED_FROM'];
        $this->POTONGAN->DbValue = $row['POTONGAN'];
        $this->BAYAR->DbValue = $row['BAYAR'];
        $this->RETUR->DbValue = $row['RETUR'];
        $this->TARIF_TYPE->DbValue = $row['TARIF_TYPE'];
        $this->PPNVALUE->DbValue = $row['PPNVALUE'];
        $this->TAGIHAN->DbValue = $row['TAGIHAN'];
        $this->KOREKSI->DbValue = $row['KOREKSI'];
        $this->AMOUNT_PAID->DbValue = $row['AMOUNT_PAID'];
        $this->DISKON->DbValue = $row['DISKON'];
        $this->NOTA_NO->DbValue = $row['NOTA_NO'];
        $this->SELL_PRICE->DbValue = $row['SELL_PRICE'];
        $this->ACCOUNT_ID->DbValue = $row['ACCOUNT_ID'];
        $this->subsidi->DbValue = $row['subsidi'];
        $this->DISCOUNT->DbValue = $row['DISCOUNT'];
        $this->AMOUNT->DbValue = $row['AMOUNT'];
        $this->PPN->DbValue = $row['PPN'];
        $this->SUBSIDISAT->DbValue = $row['SUBSIDISAT'];
        $this->PRINTQ->DbValue = $row['PRINTQ'];
        $this->PRINTED_BY->DbValue = $row['PRINTED_BY'];
        $this->STATUS_TARIF->DbValue = $row['STATUS_TARIF'];
        $this->CLINIC_TYPE->DbValue = $row['CLINIC_TYPE'];
        $this->PACKAGE_ID->DbValue = $row['PACKAGE_ID'];
        $this->MODULE_ID->DbValue = $row['MODULE_ID'];
        $this->THEORDER->DbValue = $row['THEORDER'];
        $this->CORRECTION_ID->DbValue = $row['CORRECTION_ID'];
        $this->CORRECTION_BY->DbValue = $row['CORRECTION_BY'];
        $this->CASHIER->DbValue = $row['CASHIER'];
        $this->PAYOR_ID->DbValue = $row['PAYOR_ID'];
        $this->KAL_ID->DbValue = $row['KAL_ID'];
        $this->NO_SKPINAP->DbValue = $row['NO_SKPINAP'];
        $this->RESPON->DbValue = $row['RESPON'];
        $this->NOKARTU->DbValue = $row['NOKARTU'];
        $this->PASIEN_ID->DbValue = $row['PASIEN_ID'];
        $this->modified_datesys->DbValue = $row['modified_datesys'];
        $this->MAPPING_SEP->DbValue = $row['MAPPING_SEP'];
        $this->TRANS_ID->DbValue = $row['TRANS_ID'];
        $this->SPPBILL->DbValue = $row['SPPBILL'];
        $this->SPPBILLDATE->DbValue = $row['SPPBILLDATE'];
        $this->SPPBILLUSER->DbValue = $row['SPPBILLUSER'];
        $this->SPPKASIR->DbValue = $row['SPPKASIR'];
        $this->SPPKASIRDATE->DbValue = $row['SPPKASIRDATE'];
        $this->SPPKASIRUSER->DbValue = $row['SPPKASIRUSER'];
        $this->SPPPOLI->DbValue = $row['SPPPOLI'];
        $this->SPPPOLIUSER->DbValue = $row['SPPPOLIUSER'];
        $this->SPPPOLIDATE->DbValue = $row['SPPPOLIDATE'];
        $this->NO_SURAT_KET->DbValue = $row['NO_SURAT_KET'];
        $this->ID->DbValue = $row['ID'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[ID] = @ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->ID->CurrentValue : $this->ID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->ID->CurrentValue = $keys[0];
            } else {
                $this->ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('ID', $row) ? $row['ID'] : null;
        } else {
            $val = $this->ID->OldValue !== null ? $this->ID->OldValue : $this->ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("TreatmentAkomodasiList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "TreatmentAkomodasiView") {
            return $Language->phrase("View");
        } elseif ($pageName == "TreatmentAkomodasiEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "TreatmentAkomodasiAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "TreatmentAkomodasiView";
            case Config("API_ADD_ACTION"):
                return "TreatmentAkomodasiAdd";
            case Config("API_EDIT_ACTION"):
                return "TreatmentAkomodasiEdit";
            case Config("API_DELETE_ACTION"):
                return "TreatmentAkomodasiDelete";
            case Config("API_LIST_ACTION"):
                return "TreatmentAkomodasiList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "TreatmentAkomodasiList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TreatmentAkomodasiView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TreatmentAkomodasiView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "TreatmentAkomodasiAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "TreatmentAkomodasiAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("TreatmentAkomodasiEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("TreatmentAkomodasiAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("TreatmentAkomodasiDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "PASIEN_VISITATION" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_NO_REGISTRATION", $this->NO_REGISTRATION->CurrentValue ?? $this->NO_REGISTRATION->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_VISIT_ID", $this->VISIT_ID->CurrentValue ?? $this->VISIT_ID->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_DIANTAR_OLEH", $this->THENAME->CurrentValue ?? $this->THENAME->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_VISITOR_ADDRESS", $this->THEADDRESS->CurrentValue ?? $this->THEADDRESS->getSessionValue());
            $url .= "&" . GetForeignKeyUrl("fk_TRANS_ID", $this->TRANS_ID->CurrentValue ?? $this->TRANS_ID->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "ID:" . JsonEncode($this->ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->ID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [141, 201, 203, 128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("ID") ?? Route("ID")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->ID->CurrentValue = $key;
            } else {
                $this->ID->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->BILL_ID->setDbValue($row['BILL_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->TARIF_ID->setDbValue($row['TARIF_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->TREATMENT->setDbValue($row['TREATMENT']);
        $this->TREAT_DATE->setDbValue($row['TREAT_DATE']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->EMPLOYEE_ID_FROM->setDbValue($row['EMPLOYEE_ID_FROM']);
        $this->DOCTOR_FROM->setDbValue($row['DOCTOR_FROM']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->DIAGNOSA_ID->setDbValue($row['DIAGNOSA_ID']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->KARYAWAN->setDbValue($row['KARYAWAN']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->POTONGAN->setDbValue($row['POTONGAN']);
        $this->BAYAR->setDbValue($row['BAYAR']);
        $this->RETUR->setDbValue($row['RETUR']);
        $this->TARIF_TYPE->setDbValue($row['TARIF_TYPE']);
        $this->PPNVALUE->setDbValue($row['PPNVALUE']);
        $this->TAGIHAN->setDbValue($row['TAGIHAN']);
        $this->KOREKSI->setDbValue($row['KOREKSI']);
        $this->AMOUNT_PAID->setDbValue($row['AMOUNT_PAID']);
        $this->DISKON->setDbValue($row['DISKON']);
        $this->NOTA_NO->setDbValue($row['NOTA_NO']);
        $this->SELL_PRICE->setDbValue($row['SELL_PRICE']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->subsidi->setDbValue($row['subsidi']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->PPN->setDbValue($row['PPN']);
        $this->SUBSIDISAT->setDbValue($row['SUBSIDISAT']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->STATUS_TARIF->setDbValue($row['STATUS_TARIF']);
        $this->CLINIC_TYPE->setDbValue($row['CLINIC_TYPE']);
        $this->PACKAGE_ID->setDbValue($row['PACKAGE_ID']);
        $this->MODULE_ID->setDbValue($row['MODULE_ID']);
        $this->THEORDER->setDbValue($row['THEORDER']);
        $this->CORRECTION_ID->setDbValue($row['CORRECTION_ID']);
        $this->CORRECTION_BY->setDbValue($row['CORRECTION_BY']);
        $this->CASHIER->setDbValue($row['CASHIER']);
        $this->PAYOR_ID->setDbValue($row['PAYOR_ID']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->NO_SKPINAP->setDbValue($row['NO_SKPINAP']);
        $this->RESPON->setDbValue($row['RESPON']);
        $this->NOKARTU->setDbValue($row['NOKARTU']);
        $this->PASIEN_ID->setDbValue($row['PASIEN_ID']);
        $this->modified_datesys->setDbValue($row['modified_datesys']);
        $this->MAPPING_SEP->setDbValue($row['MAPPING_SEP']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->SPPBILL->setDbValue($row['SPPBILL']);
        $this->SPPBILLDATE->setDbValue($row['SPPBILLDATE']);
        $this->SPPBILLUSER->setDbValue($row['SPPBILLUSER']);
        $this->SPPKASIR->setDbValue($row['SPPKASIR']);
        $this->SPPKASIRDATE->setDbValue($row['SPPKASIRDATE']);
        $this->SPPKASIRUSER->setDbValue($row['SPPKASIRUSER']);
        $this->SPPPOLI->setDbValue($row['SPPPOLI']);
        $this->SPPPOLIUSER->setDbValue($row['SPPPOLIUSER']);
        $this->SPPPOLIDATE->setDbValue($row['SPPPOLIDATE']);
        $this->NO_SURAT_KET->setDbValue($row['NO_SURAT_KET']);
        $this->ID->setDbValue($row['ID']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->CellCssStyle = "white-space: nowrap;";

        // BILL_ID
        $this->BILL_ID->CellCssStyle = "white-space: nowrap;";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->CellCssStyle = "white-space: nowrap;";

        // VISIT_ID
        $this->VISIT_ID->CellCssStyle = "white-space: nowrap;";

        // TARIF_ID
        $this->TARIF_ID->CellCssStyle = "white-space: nowrap;";

        // CLASS_ID
        $this->CLASS_ID->CellCssStyle = "white-space: nowrap;";

        // CLINIC_ID
        $this->CLINIC_ID->CellCssStyle = "white-space: nowrap;";

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->CellCssStyle = "white-space: nowrap;";

        // TREATMENT
        $this->TREATMENT->CellCssStyle = "white-space: nowrap;";

        // TREAT_DATE
        $this->TREAT_DATE->CellCssStyle = "white-space: nowrap;";

        // QUANTITY
        $this->QUANTITY->CellCssStyle = "white-space: nowrap;";

        // MEASURE_ID
        $this->MEASURE_ID->CellCssStyle = "white-space: nowrap;";

        // DESCRIPTION
        $this->DESCRIPTION->CellCssStyle = "white-space: nowrap;";

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->CellCssStyle = "white-space: nowrap;";

        // KELUAR_ID
        $this->KELUAR_ID->CellCssStyle = "white-space: nowrap;";

        // BED_ID
        $this->BED_ID->CellCssStyle = "white-space: nowrap;";

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->CellCssStyle = "white-space: nowrap;";

        // DOCTOR
        $this->DOCTOR->CellCssStyle = "white-space: nowrap;";

        // EXIT_DATE
        $this->EXIT_DATE->CellCssStyle = "white-space: nowrap;";

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->CellCssStyle = "white-space: nowrap;";

        // DOCTOR_FROM
        $this->DOCTOR_FROM->CellCssStyle = "white-space: nowrap;";

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->CellCssStyle = "white-space: nowrap;";

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->CellCssStyle = "white-space: nowrap;";

        // THENAME
        $this->THENAME->CellCssStyle = "white-space: nowrap;";

        // THEADDRESS
        $this->THEADDRESS->CellCssStyle = "white-space: nowrap;";

        // THEID
        $this->THEID->CellCssStyle = "white-space: nowrap;";

        // ISRJ
        $this->ISRJ->CellCssStyle = "white-space: nowrap;";

        // AGEYEAR
        $this->AGEYEAR->CellCssStyle = "white-space: nowrap;";

        // AGEMONTH
        $this->AGEMONTH->CellCssStyle = "white-space: nowrap;";

        // AGEDAY
        $this->AGEDAY->CellCssStyle = "white-space: nowrap;";

        // GENDER
        $this->GENDER->CellCssStyle = "white-space: nowrap;";

        // KARYAWAN
        $this->KARYAWAN->CellCssStyle = "white-space: nowrap;";

        // MODIFIED_BY
        $this->MODIFIED_BY->CellCssStyle = "white-space: nowrap;";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->CellCssStyle = "white-space: nowrap;";

        // MODIFIED_FROM
        $this->MODIFIED_FROM->CellCssStyle = "white-space: nowrap;";

        // POTONGAN
        $this->POTONGAN->CellCssStyle = "white-space: nowrap;";

        // BAYAR
        $this->BAYAR->CellCssStyle = "white-space: nowrap;";

        // RETUR
        $this->RETUR->CellCssStyle = "white-space: nowrap;";

        // TARIF_TYPE
        $this->TARIF_TYPE->CellCssStyle = "white-space: nowrap;";

        // PPNVALUE
        $this->PPNVALUE->CellCssStyle = "white-space: nowrap;";

        // TAGIHAN
        $this->TAGIHAN->CellCssStyle = "white-space: nowrap;";

        // KOREKSI
        $this->KOREKSI->CellCssStyle = "white-space: nowrap;";

        // AMOUNT_PAID
        $this->AMOUNT_PAID->CellCssStyle = "white-space: nowrap;";

        // DISKON
        $this->DISKON->CellCssStyle = "white-space: nowrap;";

        // NOTA_NO
        $this->NOTA_NO->CellCssStyle = "white-space: nowrap;";

        // SELL_PRICE
        $this->SELL_PRICE->CellCssStyle = "white-space: nowrap;";

        // ACCOUNT_ID
        $this->ACCOUNT_ID->CellCssStyle = "white-space: nowrap;";

        // subsidi
        $this->subsidi->CellCssStyle = "white-space: nowrap;";

        // DISCOUNT
        $this->DISCOUNT->CellCssStyle = "white-space: nowrap;";

        // AMOUNT
        $this->AMOUNT->CellCssStyle = "white-space: nowrap;";

        // PPN
        $this->PPN->CellCssStyle = "white-space: nowrap;";

        // SUBSIDISAT
        $this->SUBSIDISAT->CellCssStyle = "white-space: nowrap;";

        // PRINTQ
        $this->PRINTQ->CellCssStyle = "white-space: nowrap;";

        // PRINTED_BY
        $this->PRINTED_BY->CellCssStyle = "white-space: nowrap;";

        // STATUS_TARIF
        $this->STATUS_TARIF->CellCssStyle = "white-space: nowrap;";

        // CLINIC_TYPE
        $this->CLINIC_TYPE->CellCssStyle = "white-space: nowrap;";

        // PACKAGE_ID
        $this->PACKAGE_ID->CellCssStyle = "white-space: nowrap;";

        // MODULE_ID
        $this->MODULE_ID->CellCssStyle = "white-space: nowrap;";

        // THEORDER
        $this->THEORDER->CellCssStyle = "white-space: nowrap;";

        // CORRECTION_ID
        $this->CORRECTION_ID->CellCssStyle = "white-space: nowrap;";

        // CORRECTION_BY
        $this->CORRECTION_BY->CellCssStyle = "white-space: nowrap;";

        // CASHIER
        $this->CASHIER->CellCssStyle = "white-space: nowrap;";

        // PAYOR_ID
        $this->PAYOR_ID->CellCssStyle = "white-space: nowrap;";

        // KAL_ID
        $this->KAL_ID->CellCssStyle = "white-space: nowrap;";

        // NO_SKPINAP
        $this->NO_SKPINAP->CellCssStyle = "white-space: nowrap;";

        // RESPON
        $this->RESPON->CellCssStyle = "white-space: nowrap;";

        // NOKARTU
        $this->NOKARTU->CellCssStyle = "white-space: nowrap;";

        // PASIEN_ID
        $this->PASIEN_ID->CellCssStyle = "white-space: nowrap;";

        // modified_datesys
        $this->modified_datesys->CellCssStyle = "white-space: nowrap;";

        // MAPPING_SEP
        $this->MAPPING_SEP->CellCssStyle = "white-space: nowrap;";

        // TRANS_ID
        $this->TRANS_ID->CellCssStyle = "white-space: nowrap;";

        // SPPBILL
        $this->SPPBILL->CellCssStyle = "white-space: nowrap;";

        // SPPBILLDATE
        $this->SPPBILLDATE->CellCssStyle = "white-space: nowrap;";

        // SPPBILLUSER
        $this->SPPBILLUSER->CellCssStyle = "white-space: nowrap;";

        // SPPKASIR
        $this->SPPKASIR->CellCssStyle = "white-space: nowrap;";

        // SPPKASIRDATE
        $this->SPPKASIRDATE->CellCssStyle = "white-space: nowrap;";

        // SPPKASIRUSER
        $this->SPPKASIRUSER->CellCssStyle = "white-space: nowrap;";

        // SPPPOLI
        $this->SPPPOLI->CellCssStyle = "white-space: nowrap;";

        // SPPPOLIUSER
        $this->SPPPOLIUSER->CellCssStyle = "white-space: nowrap;";

        // SPPPOLIDATE
        $this->SPPPOLIDATE->CellCssStyle = "white-space: nowrap;";

        // NO_SURAT_KET
        $this->NO_SURAT_KET->CellCssStyle = "white-space: nowrap;";

        // ID
        $this->ID->CellCssStyle = "white-space: nowrap;";

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

        // BILL_ID
        $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
        $this->BILL_ID->ViewCustomAttributes = "";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
        $this->NO_REGISTRATION->ViewCustomAttributes = "";

        // VISIT_ID
        $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
        $this->VISIT_ID->ViewCustomAttributes = "";

        // TARIF_ID
        $curVal = trim(strval($this->TARIF_ID->CurrentValue));
        if ($curVal != "") {
            $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
            if ($this->TARIF_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[TARIF_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->TARIF_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->TARIF_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->TARIF_ID->ViewValue = $this->TARIF_ID->displayValue($arwrk);
                } else {
                    $this->TARIF_ID->ViewValue = $this->TARIF_ID->CurrentValue;
                }
            }
        } else {
            $this->TARIF_ID->ViewValue = null;
        }
        $this->TARIF_ID->ViewCustomAttributes = "";

        // CLASS_ID
        $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
        $this->CLASS_ID->ViewValue = FormatNumber($this->CLASS_ID->ViewValue, 0, -2, -2, -2);
        $this->CLASS_ID->ViewCustomAttributes = "";

        // CLINIC_ID
        $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
        if ($curVal != "") {
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
            if ($this->CLINIC_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CLINIC_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->displayValue($arwrk);
                } else {
                    $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
                }
            }
        } else {
            $this->CLINIC_ID->ViewValue = null;
        }
        $this->CLINIC_ID->ViewCustomAttributes = "";

        // CLINIC_ID_FROM
        $curVal = trim(strval($this->CLINIC_ID_FROM->CurrentValue));
        if ($curVal != "") {
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->lookupCacheOption($curVal);
            if ($this->CLINIC_ID_FROM->ViewValue === null) { // Lookup from database
                $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $lookupFilter = function() {
                    return "[STYPE_ID] = 0";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->CLINIC_ID_FROM->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CLINIC_ID_FROM->Lookup->renderViewRow($rswrk[0]);
                    $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->displayValue($arwrk);
                } else {
                    $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
                }
            }
        } else {
            $this->CLINIC_ID_FROM->ViewValue = null;
        }
        $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

        // TREATMENT
        $this->TREATMENT->ViewValue = $this->TREATMENT->CurrentValue;
        $this->TREATMENT->ViewCustomAttributes = "";

        // TREAT_DATE
        $this->TREAT_DATE->ViewValue = $this->TREAT_DATE->CurrentValue;
        $this->TREAT_DATE->ViewValue = FormatDateTime($this->TREAT_DATE->ViewValue, 111);
        $this->TREAT_DATE->ViewCustomAttributes = "";

        // QUANTITY
        $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
        $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
        $this->QUANTITY->ViewCustomAttributes = "";

        // MEASURE_ID
        $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
        $this->MEASURE_ID->ViewCustomAttributes = "";

        // DESCRIPTION
        $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
        $this->DESCRIPTION->ViewCustomAttributes = "";

        // CLASS_ROOM_ID
        $curVal = trim(strval($this->CLASS_ROOM_ID->CurrentValue));
        if ($curVal != "") {
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->lookupCacheOption($curVal);
            if ($this->CLASS_ROOM_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[CLASS_ROOM_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->CLASS_ROOM_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CLASS_ROOM_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->displayValue($arwrk);
                } else {
                    $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
                }
            }
        } else {
            $this->CLASS_ROOM_ID->ViewValue = null;
        }
        $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

        // KELUAR_ID
        $curVal = trim(strval($this->KELUAR_ID->CurrentValue));
        if ($curVal != "") {
            $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->lookupCacheOption($curVal);
            if ($this->KELUAR_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[KELUAR_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->KELUAR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->KELUAR_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->displayValue($arwrk);
                } else {
                    $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
                }
            }
        } else {
            $this->KELUAR_ID->ViewValue = null;
        }
        $this->KELUAR_ID->ViewCustomAttributes = "";

        // BED_ID
        $curVal = trim(strval($this->BED_ID->CurrentValue));
        if ($curVal != "") {
            $this->BED_ID->ViewValue = $this->BED_ID->lookupCacheOption($curVal);
            if ($this->BED_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[BED_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->BED_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->BED_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->BED_ID->ViewValue = $this->BED_ID->displayValue($arwrk);
                } else {
                    $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
                }
            }
        } else {
            $this->BED_ID->ViewValue = null;
        }
        $this->BED_ID->ViewCustomAttributes = "";

        // EMPLOYEE_ID
        $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
        if ($curVal != "") {
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
            if ($this->EMPLOYEE_ID->ViewValue === null) { // Lookup from database
                $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->EMPLOYEE_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->displayValue($arwrk);
                } else {
                    $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
                }
            }
        } else {
            $this->EMPLOYEE_ID->ViewValue = null;
        }
        $this->EMPLOYEE_ID->ViewCustomAttributes = "";

        // DOCTOR
        $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
        $this->DOCTOR->ViewCustomAttributes = "";

        // EXIT_DATE
        $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
        $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 17);
        $this->EXIT_DATE->ViewCustomAttributes = "";

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

        // DOCTOR_FROM
        $this->DOCTOR_FROM->ViewValue = $this->DOCTOR_FROM->CurrentValue;
        $this->DOCTOR_FROM->ViewCustomAttributes = "";

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
        $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->DIAGNOSA_ID->ViewCustomAttributes = "";

        // THENAME
        $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
        $this->THENAME->ViewCustomAttributes = "";

        // THEADDRESS
        $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
        $this->THEADDRESS->ViewCustomAttributes = "";

        // THEID
        $this->THEID->ViewValue = $this->THEID->CurrentValue;
        $this->THEID->ViewCustomAttributes = "";

        // ISRJ
        $this->ISRJ->ViewValue = $this->ISRJ->CurrentValue;
        $this->ISRJ->ViewCustomAttributes = "";

        // AGEYEAR
        $this->AGEYEAR->ViewValue = $this->AGEYEAR->CurrentValue;
        $this->AGEYEAR->ViewValue = FormatNumber($this->AGEYEAR->ViewValue, 0, -2, -2, -2);
        $this->AGEYEAR->ViewCustomAttributes = "";

        // AGEMONTH
        $this->AGEMONTH->ViewValue = $this->AGEMONTH->CurrentValue;
        $this->AGEMONTH->ViewValue = FormatNumber($this->AGEMONTH->ViewValue, 0, -2, -2, -2);
        $this->AGEMONTH->ViewCustomAttributes = "";

        // AGEDAY
        $this->AGEDAY->ViewValue = $this->AGEDAY->CurrentValue;
        $this->AGEDAY->ViewValue = FormatNumber($this->AGEDAY->ViewValue, 0, -2, -2, -2);
        $this->AGEDAY->ViewCustomAttributes = "";

        // GENDER
        $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
        $this->GENDER->ViewCustomAttributes = "";

        // KARYAWAN
        $this->KARYAWAN->ViewValue = $this->KARYAWAN->CurrentValue;
        $this->KARYAWAN->ViewCustomAttributes = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->ViewCustomAttributes = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 17);
        $this->MODIFIED_DATE->ViewCustomAttributes = "";

        // MODIFIED_FROM
        $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
        $this->MODIFIED_FROM->ViewCustomAttributes = "";

        // POTONGAN
        $this->POTONGAN->ViewValue = $this->POTONGAN->CurrentValue;
        $this->POTONGAN->ViewValue = FormatNumber($this->POTONGAN->ViewValue, 2, -2, -2, -2);
        $this->POTONGAN->ViewCustomAttributes = "";

        // BAYAR
        $this->BAYAR->ViewValue = $this->BAYAR->CurrentValue;
        $this->BAYAR->ViewValue = FormatNumber($this->BAYAR->ViewValue, 2, -2, -2, -2);
        $this->BAYAR->ViewCustomAttributes = "";

        // RETUR
        $this->RETUR->ViewValue = $this->RETUR->CurrentValue;
        $this->RETUR->ViewValue = FormatNumber($this->RETUR->ViewValue, 2, -2, -2, -2);
        $this->RETUR->ViewCustomAttributes = "";

        // TARIF_TYPE
        $this->TARIF_TYPE->ViewValue = $this->TARIF_TYPE->CurrentValue;
        $this->TARIF_TYPE->ViewCustomAttributes = "";

        // PPNVALUE
        $this->PPNVALUE->ViewValue = $this->PPNVALUE->CurrentValue;
        $this->PPNVALUE->ViewValue = FormatNumber($this->PPNVALUE->ViewValue, 2, -2, -2, -2);
        $this->PPNVALUE->ViewCustomAttributes = "";

        // TAGIHAN
        $this->TAGIHAN->ViewValue = $this->TAGIHAN->CurrentValue;
        $this->TAGIHAN->ViewValue = FormatNumber($this->TAGIHAN->ViewValue, 2, -2, -2, -2);
        $this->TAGIHAN->ViewCustomAttributes = "";

        // KOREKSI
        $this->KOREKSI->ViewValue = $this->KOREKSI->CurrentValue;
        $this->KOREKSI->ViewValue = FormatNumber($this->KOREKSI->ViewValue, 2, -2, -2, -2);
        $this->KOREKSI->ViewCustomAttributes = "";

        // AMOUNT_PAID
        $this->AMOUNT_PAID->ViewValue = $this->AMOUNT_PAID->CurrentValue;
        $this->AMOUNT_PAID->ViewValue = FormatNumber($this->AMOUNT_PAID->ViewValue, 2, -2, -2, -2);
        $this->AMOUNT_PAID->ViewCustomAttributes = "";

        // DISKON
        $this->DISKON->ViewValue = $this->DISKON->CurrentValue;
        $this->DISKON->ViewValue = FormatNumber($this->DISKON->ViewValue, 2, -2, -2, -2);
        $this->DISKON->ViewCustomAttributes = "";

        // NOTA_NO
        $this->NOTA_NO->ViewValue = $this->NOTA_NO->CurrentValue;
        $this->NOTA_NO->ViewCustomAttributes = "";

        // SELL_PRICE
        $this->SELL_PRICE->ViewValue = $this->SELL_PRICE->CurrentValue;
        $this->SELL_PRICE->ViewValue = FormatNumber($this->SELL_PRICE->ViewValue, 2, -2, -2, -2);
        $this->SELL_PRICE->ViewCustomAttributes = "";

        // ACCOUNT_ID
        $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
        $this->ACCOUNT_ID->ViewCustomAttributes = "";

        // subsidi
        $this->subsidi->ViewValue = $this->subsidi->CurrentValue;
        $this->subsidi->ViewValue = FormatNumber($this->subsidi->ViewValue, 2, -2, -2, -2);
        $this->subsidi->ViewCustomAttributes = "";

        // DISCOUNT
        $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
        $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
        $this->DISCOUNT->ViewCustomAttributes = "";

        // AMOUNT
        $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
        $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
        $this->AMOUNT->ViewCustomAttributes = "";

        // PPN
        $this->PPN->ViewValue = $this->PPN->CurrentValue;
        $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
        $this->PPN->ViewCustomAttributes = "";

        // SUBSIDISAT
        $this->SUBSIDISAT->ViewValue = $this->SUBSIDISAT->CurrentValue;
        $this->SUBSIDISAT->ViewValue = FormatNumber($this->SUBSIDISAT->ViewValue, 2, -2, -2, -2);
        $this->SUBSIDISAT->ViewCustomAttributes = "";

        // PRINTQ
        $this->PRINTQ->ViewValue = $this->PRINTQ->CurrentValue;
        $this->PRINTQ->ViewValue = FormatNumber($this->PRINTQ->ViewValue, 0, -2, -2, -2);
        $this->PRINTQ->ViewCustomAttributes = "";

        // PRINTED_BY
        $this->PRINTED_BY->ViewValue = $this->PRINTED_BY->CurrentValue;
        $this->PRINTED_BY->ViewCustomAttributes = "";

        // STATUS_TARIF
        $this->STATUS_TARIF->ViewValue = $this->STATUS_TARIF->CurrentValue;
        $this->STATUS_TARIF->ViewValue = FormatNumber($this->STATUS_TARIF->ViewValue, 0, -2, -2, -2);
        $this->STATUS_TARIF->ViewCustomAttributes = "";

        // CLINIC_TYPE
        $this->CLINIC_TYPE->ViewValue = $this->CLINIC_TYPE->CurrentValue;
        $this->CLINIC_TYPE->ViewValue = FormatNumber($this->CLINIC_TYPE->ViewValue, 0, -2, -2, -2);
        $this->CLINIC_TYPE->ViewCustomAttributes = "";

        // PACKAGE_ID
        $this->PACKAGE_ID->ViewValue = $this->PACKAGE_ID->CurrentValue;
        $this->PACKAGE_ID->ViewCustomAttributes = "";

        // MODULE_ID
        $this->MODULE_ID->ViewValue = $this->MODULE_ID->CurrentValue;
        $this->MODULE_ID->ViewCustomAttributes = "";

        // THEORDER
        $this->THEORDER->ViewValue = $this->THEORDER->CurrentValue;
        $this->THEORDER->ViewValue = FormatNumber($this->THEORDER->ViewValue, 0, -2, -2, -2);
        $this->THEORDER->ViewCustomAttributes = "";

        // CORRECTION_ID
        $this->CORRECTION_ID->ViewValue = $this->CORRECTION_ID->CurrentValue;
        $this->CORRECTION_ID->ViewCustomAttributes = "";

        // CORRECTION_BY
        $this->CORRECTION_BY->ViewValue = $this->CORRECTION_BY->CurrentValue;
        $this->CORRECTION_BY->ViewCustomAttributes = "";

        // CASHIER
        $this->CASHIER->ViewValue = $this->CASHIER->CurrentValue;
        $this->CASHIER->ViewCustomAttributes = "";

        // PAYOR_ID
        $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
        $this->PAYOR_ID->ViewCustomAttributes = "";

        // KAL_ID
        $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
        $this->KAL_ID->ViewCustomAttributes = "";

        // NO_SKPINAP
        $this->NO_SKPINAP->ViewValue = $this->NO_SKPINAP->CurrentValue;
        $this->NO_SKPINAP->ViewCustomAttributes = "";

        // RESPON
        $this->RESPON->ViewValue = $this->RESPON->CurrentValue;
        $this->RESPON->ViewCustomAttributes = "";

        // NOKARTU
        $this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
        $this->NOKARTU->ViewCustomAttributes = "";

        // PASIEN_ID
        $this->PASIEN_ID->ViewValue = $this->PASIEN_ID->CurrentValue;
        $this->PASIEN_ID->ViewCustomAttributes = "";

        // modified_datesys
        $this->modified_datesys->ViewValue = $this->modified_datesys->CurrentValue;
        $this->modified_datesys->ViewValue = FormatDateTime($this->modified_datesys->ViewValue, 0);
        $this->modified_datesys->ViewCustomAttributes = "";

        // MAPPING_SEP
        $this->MAPPING_SEP->ViewValue = $this->MAPPING_SEP->CurrentValue;
        $this->MAPPING_SEP->ViewCustomAttributes = "";

        // TRANS_ID
        $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
        $this->TRANS_ID->ViewCustomAttributes = "";

        // SPPBILL
        $this->SPPBILL->ViewValue = $this->SPPBILL->CurrentValue;
        $this->SPPBILL->ViewCustomAttributes = "";

        // SPPBILLDATE
        $this->SPPBILLDATE->ViewValue = $this->SPPBILLDATE->CurrentValue;
        $this->SPPBILLDATE->ViewValue = FormatDateTime($this->SPPBILLDATE->ViewValue, 0);
        $this->SPPBILLDATE->ViewCustomAttributes = "";

        // SPPBILLUSER
        $this->SPPBILLUSER->ViewValue = $this->SPPBILLUSER->CurrentValue;
        $this->SPPBILLUSER->ViewCustomAttributes = "";

        // SPPKASIR
        $this->SPPKASIR->ViewValue = $this->SPPKASIR->CurrentValue;
        $this->SPPKASIR->ViewCustomAttributes = "";

        // SPPKASIRDATE
        $this->SPPKASIRDATE->ViewValue = $this->SPPKASIRDATE->CurrentValue;
        $this->SPPKASIRDATE->ViewValue = FormatDateTime($this->SPPKASIRDATE->ViewValue, 0);
        $this->SPPKASIRDATE->ViewCustomAttributes = "";

        // SPPKASIRUSER
        $this->SPPKASIRUSER->ViewValue = $this->SPPKASIRUSER->CurrentValue;
        $this->SPPKASIRUSER->ViewCustomAttributes = "";

        // SPPPOLI
        $this->SPPPOLI->ViewValue = $this->SPPPOLI->CurrentValue;
        $this->SPPPOLI->ViewCustomAttributes = "";

        // SPPPOLIUSER
        $this->SPPPOLIUSER->ViewValue = $this->SPPPOLIUSER->CurrentValue;
        $this->SPPPOLIUSER->ViewCustomAttributes = "";

        // SPPPOLIDATE
        $this->SPPPOLIDATE->ViewValue = $this->SPPPOLIDATE->CurrentValue;
        $this->SPPPOLIDATE->ViewValue = FormatDateTime($this->SPPPOLIDATE->ViewValue, 0);
        $this->SPPPOLIDATE->ViewCustomAttributes = "";

        // NO_SURAT_KET
        $this->NO_SURAT_KET->ViewValue = $this->NO_SURAT_KET->CurrentValue;
        $this->NO_SURAT_KET->ViewCustomAttributes = "";

        // ID
        $this->ID->ViewValue = $this->ID->CurrentValue;
        $this->ID->ViewCustomAttributes = "";

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
        $this->ORG_UNIT_CODE->HrefValue = "";
        $this->ORG_UNIT_CODE->TooltipValue = "";

        // BILL_ID
        $this->BILL_ID->LinkCustomAttributes = "";
        $this->BILL_ID->HrefValue = "";
        $this->BILL_ID->TooltipValue = "";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->LinkCustomAttributes = "";
        $this->NO_REGISTRATION->HrefValue = "";
        $this->NO_REGISTRATION->TooltipValue = "";

        // VISIT_ID
        $this->VISIT_ID->LinkCustomAttributes = "";
        $this->VISIT_ID->HrefValue = "";
        $this->VISIT_ID->TooltipValue = "";

        // TARIF_ID
        $this->TARIF_ID->LinkCustomAttributes = "";
        $this->TARIF_ID->HrefValue = "";
        $this->TARIF_ID->TooltipValue = "";

        // CLASS_ID
        $this->CLASS_ID->LinkCustomAttributes = "";
        $this->CLASS_ID->HrefValue = "";
        $this->CLASS_ID->TooltipValue = "";

        // CLINIC_ID
        $this->CLINIC_ID->LinkCustomAttributes = "";
        $this->CLINIC_ID->HrefValue = "";
        $this->CLINIC_ID->TooltipValue = "";

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->LinkCustomAttributes = "";
        $this->CLINIC_ID_FROM->HrefValue = "";
        $this->CLINIC_ID_FROM->TooltipValue = "";

        // TREATMENT
        $this->TREATMENT->LinkCustomAttributes = "";
        $this->TREATMENT->HrefValue = "";
        $this->TREATMENT->TooltipValue = "";

        // TREAT_DATE
        $this->TREAT_DATE->LinkCustomAttributes = "";
        $this->TREAT_DATE->HrefValue = "";
        $this->TREAT_DATE->TooltipValue = "";

        // QUANTITY
        $this->QUANTITY->LinkCustomAttributes = "";
        $this->QUANTITY->HrefValue = "";
        $this->QUANTITY->TooltipValue = "";

        // MEASURE_ID
        $this->MEASURE_ID->LinkCustomAttributes = "";
        $this->MEASURE_ID->HrefValue = "";
        $this->MEASURE_ID->TooltipValue = "";

        // DESCRIPTION
        $this->DESCRIPTION->LinkCustomAttributes = "";
        $this->DESCRIPTION->HrefValue = "";
        $this->DESCRIPTION->TooltipValue = "";

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
        $this->CLASS_ROOM_ID->HrefValue = "";
        $this->CLASS_ROOM_ID->TooltipValue = "";

        // KELUAR_ID
        $this->KELUAR_ID->LinkCustomAttributes = "";
        $this->KELUAR_ID->HrefValue = "";
        $this->KELUAR_ID->TooltipValue = "";

        // BED_ID
        $this->BED_ID->LinkCustomAttributes = "";
        $this->BED_ID->HrefValue = "";
        $this->BED_ID->TooltipValue = "";

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->LinkCustomAttributes = "";
        $this->EMPLOYEE_ID->HrefValue = "";
        $this->EMPLOYEE_ID->TooltipValue = "";

        // DOCTOR
        $this->DOCTOR->LinkCustomAttributes = "";
        $this->DOCTOR->HrefValue = "";
        $this->DOCTOR->TooltipValue = "";

        // EXIT_DATE
        $this->EXIT_DATE->LinkCustomAttributes = "";
        $this->EXIT_DATE->HrefValue = "";
        $this->EXIT_DATE->TooltipValue = "";

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->LinkCustomAttributes = "";
        $this->EMPLOYEE_ID_FROM->HrefValue = "";
        $this->EMPLOYEE_ID_FROM->TooltipValue = "";

        // DOCTOR_FROM
        $this->DOCTOR_FROM->LinkCustomAttributes = "";
        $this->DOCTOR_FROM->HrefValue = "";
        $this->DOCTOR_FROM->TooltipValue = "";

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
        $this->STATUS_PASIEN_ID->HrefValue = "";
        $this->STATUS_PASIEN_ID->TooltipValue = "";

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->LinkCustomAttributes = "";
        $this->DIAGNOSA_ID->HrefValue = "";
        $this->DIAGNOSA_ID->TooltipValue = "";

        // THENAME
        $this->THENAME->LinkCustomAttributes = "";
        $this->THENAME->HrefValue = "";
        $this->THENAME->TooltipValue = "";

        // THEADDRESS
        $this->THEADDRESS->LinkCustomAttributes = "";
        $this->THEADDRESS->HrefValue = "";
        $this->THEADDRESS->TooltipValue = "";

        // THEID
        $this->THEID->LinkCustomAttributes = "";
        $this->THEID->HrefValue = "";
        $this->THEID->TooltipValue = "";

        // ISRJ
        $this->ISRJ->LinkCustomAttributes = "";
        $this->ISRJ->HrefValue = "";
        $this->ISRJ->TooltipValue = "";

        // AGEYEAR
        $this->AGEYEAR->LinkCustomAttributes = "";
        $this->AGEYEAR->HrefValue = "";
        $this->AGEYEAR->TooltipValue = "";

        // AGEMONTH
        $this->AGEMONTH->LinkCustomAttributes = "";
        $this->AGEMONTH->HrefValue = "";
        $this->AGEMONTH->TooltipValue = "";

        // AGEDAY
        $this->AGEDAY->LinkCustomAttributes = "";
        $this->AGEDAY->HrefValue = "";
        $this->AGEDAY->TooltipValue = "";

        // GENDER
        $this->GENDER->LinkCustomAttributes = "";
        $this->GENDER->HrefValue = "";
        $this->GENDER->TooltipValue = "";

        // KARYAWAN
        $this->KARYAWAN->LinkCustomAttributes = "";
        $this->KARYAWAN->HrefValue = "";
        $this->KARYAWAN->TooltipValue = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->LinkCustomAttributes = "";
        $this->MODIFIED_BY->HrefValue = "";
        $this->MODIFIED_BY->TooltipValue = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->LinkCustomAttributes = "";
        $this->MODIFIED_DATE->HrefValue = "";
        $this->MODIFIED_DATE->TooltipValue = "";

        // MODIFIED_FROM
        $this->MODIFIED_FROM->LinkCustomAttributes = "";
        $this->MODIFIED_FROM->HrefValue = "";
        $this->MODIFIED_FROM->TooltipValue = "";

        // POTONGAN
        $this->POTONGAN->LinkCustomAttributes = "";
        $this->POTONGAN->HrefValue = "";
        $this->POTONGAN->TooltipValue = "";

        // BAYAR
        $this->BAYAR->LinkCustomAttributes = "";
        $this->BAYAR->HrefValue = "";
        $this->BAYAR->TooltipValue = "";

        // RETUR
        $this->RETUR->LinkCustomAttributes = "";
        $this->RETUR->HrefValue = "";
        $this->RETUR->TooltipValue = "";

        // TARIF_TYPE
        $this->TARIF_TYPE->LinkCustomAttributes = "";
        $this->TARIF_TYPE->HrefValue = "";
        $this->TARIF_TYPE->TooltipValue = "";

        // PPNVALUE
        $this->PPNVALUE->LinkCustomAttributes = "";
        $this->PPNVALUE->HrefValue = "";
        $this->PPNVALUE->TooltipValue = "";

        // TAGIHAN
        $this->TAGIHAN->LinkCustomAttributes = "";
        $this->TAGIHAN->HrefValue = "";
        $this->TAGIHAN->TooltipValue = "";

        // KOREKSI
        $this->KOREKSI->LinkCustomAttributes = "";
        $this->KOREKSI->HrefValue = "";
        $this->KOREKSI->TooltipValue = "";

        // AMOUNT_PAID
        $this->AMOUNT_PAID->LinkCustomAttributes = "";
        $this->AMOUNT_PAID->HrefValue = "";
        $this->AMOUNT_PAID->TooltipValue = "";

        // DISKON
        $this->DISKON->LinkCustomAttributes = "";
        $this->DISKON->HrefValue = "";
        $this->DISKON->TooltipValue = "";

        // NOTA_NO
        $this->NOTA_NO->LinkCustomAttributes = "";
        $this->NOTA_NO->HrefValue = "";
        $this->NOTA_NO->TooltipValue = "";

        // SELL_PRICE
        $this->SELL_PRICE->LinkCustomAttributes = "";
        $this->SELL_PRICE->HrefValue = "";
        $this->SELL_PRICE->TooltipValue = "";

        // ACCOUNT_ID
        $this->ACCOUNT_ID->LinkCustomAttributes = "";
        $this->ACCOUNT_ID->HrefValue = "";
        $this->ACCOUNT_ID->TooltipValue = "";

        // subsidi
        $this->subsidi->LinkCustomAttributes = "";
        $this->subsidi->HrefValue = "";
        $this->subsidi->TooltipValue = "";

        // DISCOUNT
        $this->DISCOUNT->LinkCustomAttributes = "";
        $this->DISCOUNT->HrefValue = "";
        $this->DISCOUNT->TooltipValue = "";

        // AMOUNT
        $this->AMOUNT->LinkCustomAttributes = "";
        $this->AMOUNT->HrefValue = "";
        $this->AMOUNT->TooltipValue = "";

        // PPN
        $this->PPN->LinkCustomAttributes = "";
        $this->PPN->HrefValue = "";
        $this->PPN->TooltipValue = "";

        // SUBSIDISAT
        $this->SUBSIDISAT->LinkCustomAttributes = "";
        $this->SUBSIDISAT->HrefValue = "";
        $this->SUBSIDISAT->TooltipValue = "";

        // PRINTQ
        $this->PRINTQ->LinkCustomAttributes = "";
        $this->PRINTQ->HrefValue = "";
        $this->PRINTQ->TooltipValue = "";

        // PRINTED_BY
        $this->PRINTED_BY->LinkCustomAttributes = "";
        $this->PRINTED_BY->HrefValue = "";
        $this->PRINTED_BY->TooltipValue = "";

        // STATUS_TARIF
        $this->STATUS_TARIF->LinkCustomAttributes = "";
        $this->STATUS_TARIF->HrefValue = "";
        $this->STATUS_TARIF->TooltipValue = "";

        // CLINIC_TYPE
        $this->CLINIC_TYPE->LinkCustomAttributes = "";
        $this->CLINIC_TYPE->HrefValue = "";
        $this->CLINIC_TYPE->TooltipValue = "";

        // PACKAGE_ID
        $this->PACKAGE_ID->LinkCustomAttributes = "";
        $this->PACKAGE_ID->HrefValue = "";
        $this->PACKAGE_ID->TooltipValue = "";

        // MODULE_ID
        $this->MODULE_ID->LinkCustomAttributes = "";
        $this->MODULE_ID->HrefValue = "";
        $this->MODULE_ID->TooltipValue = "";

        // THEORDER
        $this->THEORDER->LinkCustomAttributes = "";
        $this->THEORDER->HrefValue = "";
        $this->THEORDER->TooltipValue = "";

        // CORRECTION_ID
        $this->CORRECTION_ID->LinkCustomAttributes = "";
        $this->CORRECTION_ID->HrefValue = "";
        $this->CORRECTION_ID->TooltipValue = "";

        // CORRECTION_BY
        $this->CORRECTION_BY->LinkCustomAttributes = "";
        $this->CORRECTION_BY->HrefValue = "";
        $this->CORRECTION_BY->TooltipValue = "";

        // CASHIER
        $this->CASHIER->LinkCustomAttributes = "";
        $this->CASHIER->HrefValue = "";
        $this->CASHIER->TooltipValue = "";

        // PAYOR_ID
        $this->PAYOR_ID->LinkCustomAttributes = "";
        $this->PAYOR_ID->HrefValue = "";
        $this->PAYOR_ID->TooltipValue = "";

        // KAL_ID
        $this->KAL_ID->LinkCustomAttributes = "";
        $this->KAL_ID->HrefValue = "";
        $this->KAL_ID->TooltipValue = "";

        // NO_SKPINAP
        $this->NO_SKPINAP->LinkCustomAttributes = "";
        $this->NO_SKPINAP->HrefValue = "";
        $this->NO_SKPINAP->TooltipValue = "";

        // RESPON
        $this->RESPON->LinkCustomAttributes = "";
        $this->RESPON->HrefValue = "";
        $this->RESPON->TooltipValue = "";

        // NOKARTU
        $this->NOKARTU->LinkCustomAttributes = "";
        $this->NOKARTU->HrefValue = "";
        $this->NOKARTU->TooltipValue = "";

        // PASIEN_ID
        $this->PASIEN_ID->LinkCustomAttributes = "";
        $this->PASIEN_ID->HrefValue = "";
        $this->PASIEN_ID->TooltipValue = "";

        // modified_datesys
        $this->modified_datesys->LinkCustomAttributes = "";
        $this->modified_datesys->HrefValue = "";
        $this->modified_datesys->TooltipValue = "";

        // MAPPING_SEP
        $this->MAPPING_SEP->LinkCustomAttributes = "";
        $this->MAPPING_SEP->HrefValue = "";
        $this->MAPPING_SEP->TooltipValue = "";

        // TRANS_ID
        $this->TRANS_ID->LinkCustomAttributes = "";
        $this->TRANS_ID->HrefValue = "";
        $this->TRANS_ID->TooltipValue = "";

        // SPPBILL
        $this->SPPBILL->LinkCustomAttributes = "";
        $this->SPPBILL->HrefValue = "";
        $this->SPPBILL->TooltipValue = "";

        // SPPBILLDATE
        $this->SPPBILLDATE->LinkCustomAttributes = "";
        $this->SPPBILLDATE->HrefValue = "";
        $this->SPPBILLDATE->TooltipValue = "";

        // SPPBILLUSER
        $this->SPPBILLUSER->LinkCustomAttributes = "";
        $this->SPPBILLUSER->HrefValue = "";
        $this->SPPBILLUSER->TooltipValue = "";

        // SPPKASIR
        $this->SPPKASIR->LinkCustomAttributes = "";
        $this->SPPKASIR->HrefValue = "";
        $this->SPPKASIR->TooltipValue = "";

        // SPPKASIRDATE
        $this->SPPKASIRDATE->LinkCustomAttributes = "";
        $this->SPPKASIRDATE->HrefValue = "";
        $this->SPPKASIRDATE->TooltipValue = "";

        // SPPKASIRUSER
        $this->SPPKASIRUSER->LinkCustomAttributes = "";
        $this->SPPKASIRUSER->HrefValue = "";
        $this->SPPKASIRUSER->TooltipValue = "";

        // SPPPOLI
        $this->SPPPOLI->LinkCustomAttributes = "";
        $this->SPPPOLI->HrefValue = "";
        $this->SPPPOLI->TooltipValue = "";

        // SPPPOLIUSER
        $this->SPPPOLIUSER->LinkCustomAttributes = "";
        $this->SPPPOLIUSER->HrefValue = "";
        $this->SPPPOLIUSER->TooltipValue = "";

        // SPPPOLIDATE
        $this->SPPPOLIDATE->LinkCustomAttributes = "";
        $this->SPPPOLIDATE->HrefValue = "";
        $this->SPPPOLIDATE->TooltipValue = "";

        // NO_SURAT_KET
        $this->NO_SURAT_KET->LinkCustomAttributes = "";
        $this->NO_SURAT_KET->HrefValue = "";
        $this->NO_SURAT_KET->TooltipValue = "";

        // ID
        $this->ID->LinkCustomAttributes = "";
        $this->ID->HrefValue = "";
        $this->ID->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
        $this->ORG_UNIT_CODE->EditCustomAttributes = "";

        // BILL_ID
        $this->BILL_ID->EditAttrs["class"] = "form-control";
        $this->BILL_ID->EditCustomAttributes = "";
        if (!$this->BILL_ID->Raw) {
            $this->BILL_ID->CurrentValue = HtmlDecode($this->BILL_ID->CurrentValue);
        }
        $this->BILL_ID->EditValue = $this->BILL_ID->CurrentValue;
        $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());

        // NO_REGISTRATION
        $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
        $this->NO_REGISTRATION->EditCustomAttributes = "";
        $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->CurrentValue;
        $this->NO_REGISTRATION->ViewCustomAttributes = "";

        // VISIT_ID
        $this->VISIT_ID->EditAttrs["class"] = "form-control";
        $this->VISIT_ID->EditCustomAttributes = "";
        $this->VISIT_ID->EditValue = $this->VISIT_ID->CurrentValue;
        $this->VISIT_ID->ViewCustomAttributes = "";

        // TARIF_ID
        $this->TARIF_ID->EditAttrs["class"] = "form-control";
        $this->TARIF_ID->EditCustomAttributes = "";
        $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

        // CLASS_ID
        $this->CLASS_ID->EditAttrs["class"] = "form-control";
        $this->CLASS_ID->EditCustomAttributes = "";
        $this->CLASS_ID->EditValue = $this->CLASS_ID->CurrentValue;
        $this->CLASS_ID->PlaceHolder = RemoveHtml($this->CLASS_ID->caption());

        // CLINIC_ID
        $this->CLINIC_ID->EditAttrs["class"] = "form-control";
        $this->CLINIC_ID->EditCustomAttributes = "";
        $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
        if ($curVal != "") {
            $this->CLINIC_ID->EditValue = $this->CLINIC_ID->lookupCacheOption($curVal);
            if ($this->CLINIC_ID->EditValue === null) { // Lookup from database
                $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->CLINIC_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->CLINIC_ID->EditValue = $this->CLINIC_ID->displayValue($arwrk);
                } else {
                    $this->CLINIC_ID->EditValue = $this->CLINIC_ID->CurrentValue;
                }
            }
        } else {
            $this->CLINIC_ID->EditValue = null;
        }
        $this->CLINIC_ID->ViewCustomAttributes = "";

        // CLINIC_ID_FROM
        $this->CLINIC_ID_FROM->EditAttrs["class"] = "form-control";
        $this->CLINIC_ID_FROM->EditCustomAttributes = "";
        $this->CLINIC_ID_FROM->PlaceHolder = RemoveHtml($this->CLINIC_ID_FROM->caption());

        // TREATMENT
        $this->TREATMENT->EditAttrs["class"] = "form-control";
        $this->TREATMENT->EditCustomAttributes = "";
        $this->TREATMENT->EditValue = $this->TREATMENT->CurrentValue;
        $this->TREATMENT->ViewCustomAttributes = "";

        // TREAT_DATE
        $this->TREAT_DATE->EditAttrs["class"] = "form-control";
        $this->TREAT_DATE->EditCustomAttributes = "";
        $this->TREAT_DATE->EditValue = $this->TREAT_DATE->CurrentValue;
        $this->TREAT_DATE->EditValue = FormatDateTime($this->TREAT_DATE->EditValue, 111);
        $this->TREAT_DATE->ViewCustomAttributes = "";

        // QUANTITY
        $this->QUANTITY->EditAttrs["class"] = "form-control";
        $this->QUANTITY->EditCustomAttributes = "";
        $this->QUANTITY->EditValue = $this->QUANTITY->CurrentValue;
        $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
        if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
            $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
        }

        // MEASURE_ID
        $this->MEASURE_ID->EditAttrs["class"] = "form-control";
        $this->MEASURE_ID->EditCustomAttributes = "";
        $this->MEASURE_ID->EditValue = $this->MEASURE_ID->CurrentValue;
        $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

        // DESCRIPTION
        $this->DESCRIPTION->EditAttrs["class"] = "form-control";
        $this->DESCRIPTION->EditCustomAttributes = "";
        if (!$this->DESCRIPTION->Raw) {
            $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
        }
        $this->DESCRIPTION->EditValue = $this->DESCRIPTION->CurrentValue;
        $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
        $this->CLASS_ROOM_ID->EditCustomAttributes = "";
        $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

        // KELUAR_ID
        $this->KELUAR_ID->EditAttrs["class"] = "form-control";
        $this->KELUAR_ID->EditCustomAttributes = "";
        $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

        // BED_ID
        $this->BED_ID->EditAttrs["class"] = "form-control";
        $this->BED_ID->EditCustomAttributes = "";
        $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
        $this->EMPLOYEE_ID->EditCustomAttributes = "";
        $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

        // DOCTOR
        $this->DOCTOR->EditAttrs["class"] = "form-control";
        $this->DOCTOR->EditCustomAttributes = "";
        if (!$this->DOCTOR->Raw) {
            $this->DOCTOR->CurrentValue = HtmlDecode($this->DOCTOR->CurrentValue);
        }
        $this->DOCTOR->EditValue = $this->DOCTOR->CurrentValue;
        $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

        // EXIT_DATE
        $this->EXIT_DATE->EditAttrs["class"] = "form-control";
        $this->EXIT_DATE->EditCustomAttributes = "";
        $this->EXIT_DATE->EditValue = FormatDateTime($this->EXIT_DATE->CurrentValue, 17);
        $this->EXIT_DATE->PlaceHolder = RemoveHtml($this->EXIT_DATE->caption());

        // EMPLOYEE_ID_FROM
        $this->EMPLOYEE_ID_FROM->EditAttrs["class"] = "form-control";
        $this->EMPLOYEE_ID_FROM->EditCustomAttributes = "";
        if (!$this->EMPLOYEE_ID_FROM->Raw) {
            $this->EMPLOYEE_ID_FROM->CurrentValue = HtmlDecode($this->EMPLOYEE_ID_FROM->CurrentValue);
        }
        $this->EMPLOYEE_ID_FROM->EditValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->EMPLOYEE_ID_FROM->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID_FROM->caption());

        // DOCTOR_FROM
        $this->DOCTOR_FROM->EditAttrs["class"] = "form-control";
        $this->DOCTOR_FROM->EditCustomAttributes = "";
        if (!$this->DOCTOR_FROM->Raw) {
            $this->DOCTOR_FROM->CurrentValue = HtmlDecode($this->DOCTOR_FROM->CurrentValue);
        }
        $this->DOCTOR_FROM->EditValue = $this->DOCTOR_FROM->CurrentValue;
        $this->DOCTOR_FROM->PlaceHolder = RemoveHtml($this->DOCTOR_FROM->caption());

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
        $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
        $this->STATUS_PASIEN_ID->EditValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->EditAttrs["class"] = "form-control";
        $this->DIAGNOSA_ID->EditCustomAttributes = "";
        if (!$this->DIAGNOSA_ID->Raw) {
            $this->DIAGNOSA_ID->CurrentValue = HtmlDecode($this->DIAGNOSA_ID->CurrentValue);
        }
        $this->DIAGNOSA_ID->EditValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->DIAGNOSA_ID->PlaceHolder = RemoveHtml($this->DIAGNOSA_ID->caption());

        // THENAME
        $this->THENAME->EditAttrs["class"] = "form-control";
        $this->THENAME->EditCustomAttributes = "";
        if ($this->THENAME->getSessionValue() != "") {
            $this->THENAME->CurrentValue = GetForeignKeyValue($this->THENAME->getSessionValue());
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";
        } else {
            if (!$this->THENAME->Raw) {
                $this->THENAME->CurrentValue = HtmlDecode($this->THENAME->CurrentValue);
            }
            $this->THENAME->EditValue = $this->THENAME->CurrentValue;
            $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());
        }

        // THEADDRESS
        $this->THEADDRESS->EditAttrs["class"] = "form-control";
        $this->THEADDRESS->EditCustomAttributes = "";
        if ($this->THEADDRESS->getSessionValue() != "") {
            $this->THEADDRESS->CurrentValue = GetForeignKeyValue($this->THEADDRESS->getSessionValue());
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";
        } else {
            if (!$this->THEADDRESS->Raw) {
                $this->THEADDRESS->CurrentValue = HtmlDecode($this->THEADDRESS->CurrentValue);
            }
            $this->THEADDRESS->EditValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());
        }

        // THEID
        $this->THEID->EditAttrs["class"] = "form-control";
        $this->THEID->EditCustomAttributes = "";
        if (!$this->THEID->Raw) {
            $this->THEID->CurrentValue = HtmlDecode($this->THEID->CurrentValue);
        }
        $this->THEID->EditValue = $this->THEID->CurrentValue;
        $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

        // ISRJ
        $this->ISRJ->EditAttrs["class"] = "form-control";
        $this->ISRJ->EditCustomAttributes = "";
        if (!$this->ISRJ->Raw) {
            $this->ISRJ->CurrentValue = HtmlDecode($this->ISRJ->CurrentValue);
        }
        $this->ISRJ->EditValue = $this->ISRJ->CurrentValue;
        $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

        // AGEYEAR
        $this->AGEYEAR->EditAttrs["class"] = "form-control";
        $this->AGEYEAR->EditCustomAttributes = "";
        $this->AGEYEAR->EditValue = $this->AGEYEAR->CurrentValue;
        $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

        // AGEMONTH
        $this->AGEMONTH->EditAttrs["class"] = "form-control";
        $this->AGEMONTH->EditCustomAttributes = "";
        $this->AGEMONTH->EditValue = $this->AGEMONTH->CurrentValue;
        $this->AGEMONTH->PlaceHolder = RemoveHtml($this->AGEMONTH->caption());

        // AGEDAY
        $this->AGEDAY->EditAttrs["class"] = "form-control";
        $this->AGEDAY->EditCustomAttributes = "";
        $this->AGEDAY->EditValue = $this->AGEDAY->CurrentValue;
        $this->AGEDAY->PlaceHolder = RemoveHtml($this->AGEDAY->caption());

        // GENDER
        $this->GENDER->EditAttrs["class"] = "form-control";
        $this->GENDER->EditCustomAttributes = "";
        if (!$this->GENDER->Raw) {
            $this->GENDER->CurrentValue = HtmlDecode($this->GENDER->CurrentValue);
        }
        $this->GENDER->EditValue = $this->GENDER->CurrentValue;
        $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

        // KARYAWAN
        $this->KARYAWAN->EditAttrs["class"] = "form-control";
        $this->KARYAWAN->EditCustomAttributes = "";
        if (!$this->KARYAWAN->Raw) {
            $this->KARYAWAN->CurrentValue = HtmlDecode($this->KARYAWAN->CurrentValue);
        }
        $this->KARYAWAN->EditValue = $this->KARYAWAN->CurrentValue;
        $this->KARYAWAN->PlaceHolder = RemoveHtml($this->KARYAWAN->caption());

        // MODIFIED_BY

        // MODIFIED_DATE

        // MODIFIED_FROM
        $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
        $this->MODIFIED_FROM->EditCustomAttributes = "";
        if (!$this->MODIFIED_FROM->Raw) {
            $this->MODIFIED_FROM->CurrentValue = HtmlDecode($this->MODIFIED_FROM->CurrentValue);
        }
        $this->MODIFIED_FROM->EditValue = $this->MODIFIED_FROM->CurrentValue;
        $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

        // POTONGAN
        $this->POTONGAN->EditAttrs["class"] = "form-control";
        $this->POTONGAN->EditCustomAttributes = "";
        $this->POTONGAN->EditValue = $this->POTONGAN->CurrentValue;
        $this->POTONGAN->PlaceHolder = RemoveHtml($this->POTONGAN->caption());
        if (strval($this->POTONGAN->EditValue) != "" && is_numeric($this->POTONGAN->EditValue)) {
            $this->POTONGAN->EditValue = FormatNumber($this->POTONGAN->EditValue, -2, -2, -2, -2);
        }

        // BAYAR
        $this->BAYAR->EditAttrs["class"] = "form-control";
        $this->BAYAR->EditCustomAttributes = "";
        $this->BAYAR->EditValue = $this->BAYAR->CurrentValue;
        $this->BAYAR->PlaceHolder = RemoveHtml($this->BAYAR->caption());
        if (strval($this->BAYAR->EditValue) != "" && is_numeric($this->BAYAR->EditValue)) {
            $this->BAYAR->EditValue = FormatNumber($this->BAYAR->EditValue, -2, -2, -2, -2);
        }

        // RETUR
        $this->RETUR->EditAttrs["class"] = "form-control";
        $this->RETUR->EditCustomAttributes = "";
        $this->RETUR->EditValue = $this->RETUR->CurrentValue;
        $this->RETUR->PlaceHolder = RemoveHtml($this->RETUR->caption());
        if (strval($this->RETUR->EditValue) != "" && is_numeric($this->RETUR->EditValue)) {
            $this->RETUR->EditValue = FormatNumber($this->RETUR->EditValue, -2, -2, -2, -2);
        }

        // TARIF_TYPE
        $this->TARIF_TYPE->EditAttrs["class"] = "form-control";
        $this->TARIF_TYPE->EditCustomAttributes = "";
        if (!$this->TARIF_TYPE->Raw) {
            $this->TARIF_TYPE->CurrentValue = HtmlDecode($this->TARIF_TYPE->CurrentValue);
        }
        $this->TARIF_TYPE->EditValue = $this->TARIF_TYPE->CurrentValue;
        $this->TARIF_TYPE->PlaceHolder = RemoveHtml($this->TARIF_TYPE->caption());

        // PPNVALUE
        $this->PPNVALUE->EditAttrs["class"] = "form-control";
        $this->PPNVALUE->EditCustomAttributes = "";
        $this->PPNVALUE->EditValue = $this->PPNVALUE->CurrentValue;
        $this->PPNVALUE->PlaceHolder = RemoveHtml($this->PPNVALUE->caption());
        if (strval($this->PPNVALUE->EditValue) != "" && is_numeric($this->PPNVALUE->EditValue)) {
            $this->PPNVALUE->EditValue = FormatNumber($this->PPNVALUE->EditValue, -2, -2, -2, -2);
        }

        // TAGIHAN
        $this->TAGIHAN->EditAttrs["class"] = "form-control";
        $this->TAGIHAN->EditCustomAttributes = "";
        $this->TAGIHAN->EditValue = $this->TAGIHAN->CurrentValue;
        $this->TAGIHAN->PlaceHolder = RemoveHtml($this->TAGIHAN->caption());
        if (strval($this->TAGIHAN->EditValue) != "" && is_numeric($this->TAGIHAN->EditValue)) {
            $this->TAGIHAN->EditValue = FormatNumber($this->TAGIHAN->EditValue, -2, -2, -2, -2);
        }

        // KOREKSI
        $this->KOREKSI->EditAttrs["class"] = "form-control";
        $this->KOREKSI->EditCustomAttributes = "";
        $this->KOREKSI->EditValue = $this->KOREKSI->CurrentValue;
        $this->KOREKSI->PlaceHolder = RemoveHtml($this->KOREKSI->caption());
        if (strval($this->KOREKSI->EditValue) != "" && is_numeric($this->KOREKSI->EditValue)) {
            $this->KOREKSI->EditValue = FormatNumber($this->KOREKSI->EditValue, -2, -2, -2, -2);
        }

        // AMOUNT_PAID
        $this->AMOUNT_PAID->EditAttrs["class"] = "form-control";
        $this->AMOUNT_PAID->EditCustomAttributes = "";
        $this->AMOUNT_PAID->EditValue = $this->AMOUNT_PAID->CurrentValue;
        $this->AMOUNT_PAID->PlaceHolder = RemoveHtml($this->AMOUNT_PAID->caption());
        if (strval($this->AMOUNT_PAID->EditValue) != "" && is_numeric($this->AMOUNT_PAID->EditValue)) {
            $this->AMOUNT_PAID->EditValue = FormatNumber($this->AMOUNT_PAID->EditValue, -2, -2, -2, -2);
        }

        // DISKON
        $this->DISKON->EditAttrs["class"] = "form-control";
        $this->DISKON->EditCustomAttributes = "";
        $this->DISKON->EditValue = $this->DISKON->CurrentValue;
        $this->DISKON->PlaceHolder = RemoveHtml($this->DISKON->caption());
        if (strval($this->DISKON->EditValue) != "" && is_numeric($this->DISKON->EditValue)) {
            $this->DISKON->EditValue = FormatNumber($this->DISKON->EditValue, -2, -2, -2, -2);
        }

        // NOTA_NO
        $this->NOTA_NO->EditAttrs["class"] = "form-control";
        $this->NOTA_NO->EditCustomAttributes = "";
        $this->NOTA_NO->EditValue = $this->NOTA_NO->CurrentValue;
        $this->NOTA_NO->ViewCustomAttributes = "";

        // SELL_PRICE
        $this->SELL_PRICE->EditAttrs["class"] = "form-control";
        $this->SELL_PRICE->EditCustomAttributes = "";
        $this->SELL_PRICE->EditValue = $this->SELL_PRICE->CurrentValue;
        $this->SELL_PRICE->PlaceHolder = RemoveHtml($this->SELL_PRICE->caption());
        if (strval($this->SELL_PRICE->EditValue) != "" && is_numeric($this->SELL_PRICE->EditValue)) {
            $this->SELL_PRICE->EditValue = FormatNumber($this->SELL_PRICE->EditValue, -2, -2, -2, -2);
        }

        // ACCOUNT_ID
        $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
        $this->ACCOUNT_ID->EditCustomAttributes = "";
        if (!$this->ACCOUNT_ID->Raw) {
            $this->ACCOUNT_ID->CurrentValue = HtmlDecode($this->ACCOUNT_ID->CurrentValue);
        }
        $this->ACCOUNT_ID->EditValue = $this->ACCOUNT_ID->CurrentValue;
        $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

        // subsidi
        $this->subsidi->EditAttrs["class"] = "form-control";
        $this->subsidi->EditCustomAttributes = "";
        $this->subsidi->EditValue = $this->subsidi->CurrentValue;
        $this->subsidi->PlaceHolder = RemoveHtml($this->subsidi->caption());
        if (strval($this->subsidi->EditValue) != "" && is_numeric($this->subsidi->EditValue)) {
            $this->subsidi->EditValue = FormatNumber($this->subsidi->EditValue, -2, -2, -2, -2);
        }

        // DISCOUNT
        $this->DISCOUNT->EditAttrs["class"] = "form-control";
        $this->DISCOUNT->EditCustomAttributes = "";
        $this->DISCOUNT->EditValue = $this->DISCOUNT->CurrentValue;
        $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
        if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
            $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
        }

        // AMOUNT
        $this->AMOUNT->EditAttrs["class"] = "form-control";
        $this->AMOUNT->EditCustomAttributes = "";
        $this->AMOUNT->EditValue = $this->AMOUNT->CurrentValue;
        $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
        if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
            $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
        }

        // PPN
        $this->PPN->EditAttrs["class"] = "form-control";
        $this->PPN->EditCustomAttributes = "";
        $this->PPN->EditValue = $this->PPN->CurrentValue;
        $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());
        if (strval($this->PPN->EditValue) != "" && is_numeric($this->PPN->EditValue)) {
            $this->PPN->EditValue = FormatNumber($this->PPN->EditValue, -2, -2, -2, -2);
        }

        // SUBSIDISAT
        $this->SUBSIDISAT->EditAttrs["class"] = "form-control";
        $this->SUBSIDISAT->EditCustomAttributes = "";
        $this->SUBSIDISAT->EditValue = $this->SUBSIDISAT->CurrentValue;
        $this->SUBSIDISAT->PlaceHolder = RemoveHtml($this->SUBSIDISAT->caption());
        if (strval($this->SUBSIDISAT->EditValue) != "" && is_numeric($this->SUBSIDISAT->EditValue)) {
            $this->SUBSIDISAT->EditValue = FormatNumber($this->SUBSIDISAT->EditValue, -2, -2, -2, -2);
        }

        // PRINTQ
        $this->PRINTQ->EditAttrs["class"] = "form-control";
        $this->PRINTQ->EditCustomAttributes = "";
        $this->PRINTQ->EditValue = $this->PRINTQ->CurrentValue;
        $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

        // PRINTED_BY
        $this->PRINTED_BY->EditAttrs["class"] = "form-control";
        $this->PRINTED_BY->EditCustomAttributes = "";
        if (!$this->PRINTED_BY->Raw) {
            $this->PRINTED_BY->CurrentValue = HtmlDecode($this->PRINTED_BY->CurrentValue);
        }
        $this->PRINTED_BY->EditValue = $this->PRINTED_BY->CurrentValue;
        $this->PRINTED_BY->PlaceHolder = RemoveHtml($this->PRINTED_BY->caption());

        // STATUS_TARIF
        $this->STATUS_TARIF->EditAttrs["class"] = "form-control";
        $this->STATUS_TARIF->EditCustomAttributes = "";
        $this->STATUS_TARIF->EditValue = $this->STATUS_TARIF->CurrentValue;
        $this->STATUS_TARIF->PlaceHolder = RemoveHtml($this->STATUS_TARIF->caption());

        // CLINIC_TYPE
        $this->CLINIC_TYPE->EditAttrs["class"] = "form-control";
        $this->CLINIC_TYPE->EditCustomAttributes = "";
        $this->CLINIC_TYPE->EditValue = $this->CLINIC_TYPE->CurrentValue;
        $this->CLINIC_TYPE->PlaceHolder = RemoveHtml($this->CLINIC_TYPE->caption());

        // PACKAGE_ID
        $this->PACKAGE_ID->EditAttrs["class"] = "form-control";
        $this->PACKAGE_ID->EditCustomAttributes = "";
        if (!$this->PACKAGE_ID->Raw) {
            $this->PACKAGE_ID->CurrentValue = HtmlDecode($this->PACKAGE_ID->CurrentValue);
        }
        $this->PACKAGE_ID->EditValue = $this->PACKAGE_ID->CurrentValue;
        $this->PACKAGE_ID->PlaceHolder = RemoveHtml($this->PACKAGE_ID->caption());

        // MODULE_ID
        $this->MODULE_ID->EditAttrs["class"] = "form-control";
        $this->MODULE_ID->EditCustomAttributes = "";
        if (!$this->MODULE_ID->Raw) {
            $this->MODULE_ID->CurrentValue = HtmlDecode($this->MODULE_ID->CurrentValue);
        }
        $this->MODULE_ID->EditValue = $this->MODULE_ID->CurrentValue;
        $this->MODULE_ID->PlaceHolder = RemoveHtml($this->MODULE_ID->caption());

        // THEORDER
        $this->THEORDER->EditAttrs["class"] = "form-control";
        $this->THEORDER->EditCustomAttributes = "";
        $this->THEORDER->EditValue = $this->THEORDER->CurrentValue;
        $this->THEORDER->PlaceHolder = RemoveHtml($this->THEORDER->caption());

        // CORRECTION_ID
        $this->CORRECTION_ID->EditAttrs["class"] = "form-control";
        $this->CORRECTION_ID->EditCustomAttributes = "";
        if (!$this->CORRECTION_ID->Raw) {
            $this->CORRECTION_ID->CurrentValue = HtmlDecode($this->CORRECTION_ID->CurrentValue);
        }
        $this->CORRECTION_ID->EditValue = $this->CORRECTION_ID->CurrentValue;
        $this->CORRECTION_ID->PlaceHolder = RemoveHtml($this->CORRECTION_ID->caption());

        // CORRECTION_BY
        $this->CORRECTION_BY->EditAttrs["class"] = "form-control";
        $this->CORRECTION_BY->EditCustomAttributes = "";
        if (!$this->CORRECTION_BY->Raw) {
            $this->CORRECTION_BY->CurrentValue = HtmlDecode($this->CORRECTION_BY->CurrentValue);
        }
        $this->CORRECTION_BY->EditValue = $this->CORRECTION_BY->CurrentValue;
        $this->CORRECTION_BY->PlaceHolder = RemoveHtml($this->CORRECTION_BY->caption());

        // CASHIER
        $this->CASHIER->EditAttrs["class"] = "form-control";
        $this->CASHIER->EditCustomAttributes = "";
        if (!$this->CASHIER->Raw) {
            $this->CASHIER->CurrentValue = HtmlDecode($this->CASHIER->CurrentValue);
        }
        $this->CASHIER->EditValue = $this->CASHIER->CurrentValue;
        $this->CASHIER->PlaceHolder = RemoveHtml($this->CASHIER->caption());

        // PAYOR_ID
        $this->PAYOR_ID->EditAttrs["class"] = "form-control";
        $this->PAYOR_ID->EditCustomAttributes = "";
        if (!$this->PAYOR_ID->Raw) {
            $this->PAYOR_ID->CurrentValue = HtmlDecode($this->PAYOR_ID->CurrentValue);
        }
        $this->PAYOR_ID->EditValue = $this->PAYOR_ID->CurrentValue;
        $this->PAYOR_ID->PlaceHolder = RemoveHtml($this->PAYOR_ID->caption());

        // KAL_ID
        $this->KAL_ID->EditAttrs["class"] = "form-control";
        $this->KAL_ID->EditCustomAttributes = "";
        if (!$this->KAL_ID->Raw) {
            $this->KAL_ID->CurrentValue = HtmlDecode($this->KAL_ID->CurrentValue);
        }
        $this->KAL_ID->EditValue = $this->KAL_ID->CurrentValue;
        $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

        // NO_SKPINAP
        $this->NO_SKPINAP->EditAttrs["class"] = "form-control";
        $this->NO_SKPINAP->EditCustomAttributes = "";
        if (!$this->NO_SKPINAP->Raw) {
            $this->NO_SKPINAP->CurrentValue = HtmlDecode($this->NO_SKPINAP->CurrentValue);
        }
        $this->NO_SKPINAP->EditValue = $this->NO_SKPINAP->CurrentValue;
        $this->NO_SKPINAP->PlaceHolder = RemoveHtml($this->NO_SKPINAP->caption());

        // RESPON
        $this->RESPON->EditAttrs["class"] = "form-control";
        $this->RESPON->EditCustomAttributes = "";
        $this->RESPON->EditValue = $this->RESPON->CurrentValue;
        $this->RESPON->PlaceHolder = RemoveHtml($this->RESPON->caption());

        // NOKARTU
        $this->NOKARTU->EditAttrs["class"] = "form-control";
        $this->NOKARTU->EditCustomAttributes = "";
        if (!$this->NOKARTU->Raw) {
            $this->NOKARTU->CurrentValue = HtmlDecode($this->NOKARTU->CurrentValue);
        }
        $this->NOKARTU->EditValue = $this->NOKARTU->CurrentValue;
        $this->NOKARTU->PlaceHolder = RemoveHtml($this->NOKARTU->caption());

        // PASIEN_ID
        $this->PASIEN_ID->EditAttrs["class"] = "form-control";
        $this->PASIEN_ID->EditCustomAttributes = "";
        if (!$this->PASIEN_ID->Raw) {
            $this->PASIEN_ID->CurrentValue = HtmlDecode($this->PASIEN_ID->CurrentValue);
        }
        $this->PASIEN_ID->EditValue = $this->PASIEN_ID->CurrentValue;
        $this->PASIEN_ID->PlaceHolder = RemoveHtml($this->PASIEN_ID->caption());

        // modified_datesys
        $this->modified_datesys->EditAttrs["class"] = "form-control";
        $this->modified_datesys->EditCustomAttributes = "";
        $this->modified_datesys->EditValue = FormatDateTime($this->modified_datesys->CurrentValue, 8);
        $this->modified_datesys->PlaceHolder = RemoveHtml($this->modified_datesys->caption());

        // MAPPING_SEP
        $this->MAPPING_SEP->EditAttrs["class"] = "form-control";
        $this->MAPPING_SEP->EditCustomAttributes = "";
        if (!$this->MAPPING_SEP->Raw) {
            $this->MAPPING_SEP->CurrentValue = HtmlDecode($this->MAPPING_SEP->CurrentValue);
        }
        $this->MAPPING_SEP->EditValue = $this->MAPPING_SEP->CurrentValue;
        $this->MAPPING_SEP->PlaceHolder = RemoveHtml($this->MAPPING_SEP->caption());

        // TRANS_ID
        $this->TRANS_ID->EditAttrs["class"] = "form-control";
        $this->TRANS_ID->EditCustomAttributes = "";
        $this->TRANS_ID->EditValue = $this->TRANS_ID->CurrentValue;
        $this->TRANS_ID->ViewCustomAttributes = "";

        // SPPBILL
        $this->SPPBILL->EditAttrs["class"] = "form-control";
        $this->SPPBILL->EditCustomAttributes = "";
        if (!$this->SPPBILL->Raw) {
            $this->SPPBILL->CurrentValue = HtmlDecode($this->SPPBILL->CurrentValue);
        }
        $this->SPPBILL->EditValue = $this->SPPBILL->CurrentValue;
        $this->SPPBILL->PlaceHolder = RemoveHtml($this->SPPBILL->caption());

        // SPPBILLDATE
        $this->SPPBILLDATE->EditAttrs["class"] = "form-control";
        $this->SPPBILLDATE->EditCustomAttributes = "";
        $this->SPPBILLDATE->EditValue = FormatDateTime($this->SPPBILLDATE->CurrentValue, 8);
        $this->SPPBILLDATE->PlaceHolder = RemoveHtml($this->SPPBILLDATE->caption());

        // SPPBILLUSER
        $this->SPPBILLUSER->EditAttrs["class"] = "form-control";
        $this->SPPBILLUSER->EditCustomAttributes = "";
        if (!$this->SPPBILLUSER->Raw) {
            $this->SPPBILLUSER->CurrentValue = HtmlDecode($this->SPPBILLUSER->CurrentValue);
        }
        $this->SPPBILLUSER->EditValue = $this->SPPBILLUSER->CurrentValue;
        $this->SPPBILLUSER->PlaceHolder = RemoveHtml($this->SPPBILLUSER->caption());

        // SPPKASIR
        $this->SPPKASIR->EditAttrs["class"] = "form-control";
        $this->SPPKASIR->EditCustomAttributes = "";
        if (!$this->SPPKASIR->Raw) {
            $this->SPPKASIR->CurrentValue = HtmlDecode($this->SPPKASIR->CurrentValue);
        }
        $this->SPPKASIR->EditValue = $this->SPPKASIR->CurrentValue;
        $this->SPPKASIR->PlaceHolder = RemoveHtml($this->SPPKASIR->caption());

        // SPPKASIRDATE
        $this->SPPKASIRDATE->EditAttrs["class"] = "form-control";
        $this->SPPKASIRDATE->EditCustomAttributes = "";
        $this->SPPKASIRDATE->EditValue = FormatDateTime($this->SPPKASIRDATE->CurrentValue, 8);
        $this->SPPKASIRDATE->PlaceHolder = RemoveHtml($this->SPPKASIRDATE->caption());

        // SPPKASIRUSER
        $this->SPPKASIRUSER->EditAttrs["class"] = "form-control";
        $this->SPPKASIRUSER->EditCustomAttributes = "";
        if (!$this->SPPKASIRUSER->Raw) {
            $this->SPPKASIRUSER->CurrentValue = HtmlDecode($this->SPPKASIRUSER->CurrentValue);
        }
        $this->SPPKASIRUSER->EditValue = $this->SPPKASIRUSER->CurrentValue;
        $this->SPPKASIRUSER->PlaceHolder = RemoveHtml($this->SPPKASIRUSER->caption());

        // SPPPOLI
        $this->SPPPOLI->EditAttrs["class"] = "form-control";
        $this->SPPPOLI->EditCustomAttributes = "";
        if (!$this->SPPPOLI->Raw) {
            $this->SPPPOLI->CurrentValue = HtmlDecode($this->SPPPOLI->CurrentValue);
        }
        $this->SPPPOLI->EditValue = $this->SPPPOLI->CurrentValue;
        $this->SPPPOLI->PlaceHolder = RemoveHtml($this->SPPPOLI->caption());

        // SPPPOLIUSER
        $this->SPPPOLIUSER->EditAttrs["class"] = "form-control";
        $this->SPPPOLIUSER->EditCustomAttributes = "";
        if (!$this->SPPPOLIUSER->Raw) {
            $this->SPPPOLIUSER->CurrentValue = HtmlDecode($this->SPPPOLIUSER->CurrentValue);
        }
        $this->SPPPOLIUSER->EditValue = $this->SPPPOLIUSER->CurrentValue;
        $this->SPPPOLIUSER->PlaceHolder = RemoveHtml($this->SPPPOLIUSER->caption());

        // SPPPOLIDATE
        $this->SPPPOLIDATE->EditAttrs["class"] = "form-control";
        $this->SPPPOLIDATE->EditCustomAttributes = "";
        $this->SPPPOLIDATE->EditValue = FormatDateTime($this->SPPPOLIDATE->CurrentValue, 8);
        $this->SPPPOLIDATE->PlaceHolder = RemoveHtml($this->SPPPOLIDATE->caption());

        // NO_SURAT_KET
        $this->NO_SURAT_KET->EditAttrs["class"] = "form-control";
        $this->NO_SURAT_KET->EditCustomAttributes = "";
        if (!$this->NO_SURAT_KET->Raw) {
            $this->NO_SURAT_KET->CurrentValue = HtmlDecode($this->NO_SURAT_KET->CurrentValue);
        }
        $this->NO_SURAT_KET->EditValue = $this->NO_SURAT_KET->CurrentValue;
        $this->NO_SURAT_KET->PlaceHolder = RemoveHtml($this->NO_SURAT_KET->caption());

        // ID
        $this->ID->EditAttrs["class"] = "form-control";
        $this->ID->EditCustomAttributes = "";
        $this->ID->EditValue = $this->ID->CurrentValue;
        $this->ID->ViewCustomAttributes = "";

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->NO_REGISTRATION);
                    $doc->exportCaption($this->VISIT_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->TREATMENT);
                    $doc->exportCaption($this->TREAT_DATE);
                    $doc->exportCaption($this->DESCRIPTION);
                    $doc->exportCaption($this->CLASS_ROOM_ID);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->EMPLOYEE_ID);
                    $doc->exportCaption($this->THENAME);
                    $doc->exportCaption($this->THEADDRESS);
                    $doc->exportCaption($this->NOTA_NO);
                    $doc->exportCaption($this->TRANS_ID);
                    $doc->exportCaption($this->ID);
                } else {
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->NO_REGISTRATION);
                    $doc->exportCaption($this->VISIT_ID);
                    $doc->exportCaption($this->TARIF_ID);
                    $doc->exportCaption($this->CLASS_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->CLINIC_ID_FROM);
                    $doc->exportCaption($this->TREATMENT);
                    $doc->exportCaption($this->TREAT_DATE);
                    $doc->exportCaption($this->QUANTITY);
                    $doc->exportCaption($this->MEASURE_ID);
                    $doc->exportCaption($this->DESCRIPTION);
                    $doc->exportCaption($this->CLASS_ROOM_ID);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->EMPLOYEE_ID);
                    $doc->exportCaption($this->DOCTOR);
                    $doc->exportCaption($this->EXIT_DATE);
                    $doc->exportCaption($this->EMPLOYEE_ID_FROM);
                    $doc->exportCaption($this->DOCTOR_FROM);
                    $doc->exportCaption($this->STATUS_PASIEN_ID);
                    $doc->exportCaption($this->DIAGNOSA_ID);
                    $doc->exportCaption($this->THENAME);
                    $doc->exportCaption($this->THEADDRESS);
                    $doc->exportCaption($this->THEID);
                    $doc->exportCaption($this->ISRJ);
                    $doc->exportCaption($this->AGEYEAR);
                    $doc->exportCaption($this->AGEMONTH);
                    $doc->exportCaption($this->AGEDAY);
                    $doc->exportCaption($this->GENDER);
                    $doc->exportCaption($this->KARYAWAN);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_FROM);
                    $doc->exportCaption($this->POTONGAN);
                    $doc->exportCaption($this->BAYAR);
                    $doc->exportCaption($this->RETUR);
                    $doc->exportCaption($this->TARIF_TYPE);
                    $doc->exportCaption($this->PPNVALUE);
                    $doc->exportCaption($this->TAGIHAN);
                    $doc->exportCaption($this->KOREKSI);
                    $doc->exportCaption($this->AMOUNT_PAID);
                    $doc->exportCaption($this->DISKON);
                    $doc->exportCaption($this->NOTA_NO);
                    $doc->exportCaption($this->SELL_PRICE);
                    $doc->exportCaption($this->ACCOUNT_ID);
                    $doc->exportCaption($this->subsidi);
                    $doc->exportCaption($this->DISCOUNT);
                    $doc->exportCaption($this->AMOUNT);
                    $doc->exportCaption($this->PPN);
                    $doc->exportCaption($this->SUBSIDISAT);
                    $doc->exportCaption($this->PRINTQ);
                    $doc->exportCaption($this->PRINTED_BY);
                    $doc->exportCaption($this->STATUS_TARIF);
                    $doc->exportCaption($this->CLINIC_TYPE);
                    $doc->exportCaption($this->PACKAGE_ID);
                    $doc->exportCaption($this->MODULE_ID);
                    $doc->exportCaption($this->THEORDER);
                    $doc->exportCaption($this->CORRECTION_ID);
                    $doc->exportCaption($this->CORRECTION_BY);
                    $doc->exportCaption($this->CASHIER);
                    $doc->exportCaption($this->PAYOR_ID);
                    $doc->exportCaption($this->KAL_ID);
                    $doc->exportCaption($this->NO_SKPINAP);
                    $doc->exportCaption($this->NOKARTU);
                    $doc->exportCaption($this->PASIEN_ID);
                    $doc->exportCaption($this->modified_datesys);
                    $doc->exportCaption($this->MAPPING_SEP);
                    $doc->exportCaption($this->TRANS_ID);
                    $doc->exportCaption($this->SPPBILL);
                    $doc->exportCaption($this->SPPBILLDATE);
                    $doc->exportCaption($this->SPPBILLUSER);
                    $doc->exportCaption($this->SPPKASIR);
                    $doc->exportCaption($this->SPPKASIRDATE);
                    $doc->exportCaption($this->SPPKASIRUSER);
                    $doc->exportCaption($this->SPPPOLI);
                    $doc->exportCaption($this->SPPPOLIUSER);
                    $doc->exportCaption($this->SPPPOLIDATE);
                    $doc->exportCaption($this->NO_SURAT_KET);
                    $doc->exportCaption($this->ID);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->NO_REGISTRATION);
                        $doc->exportField($this->VISIT_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->TREATMENT);
                        $doc->exportField($this->TREAT_DATE);
                        $doc->exportField($this->DESCRIPTION);
                        $doc->exportField($this->CLASS_ROOM_ID);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->EMPLOYEE_ID);
                        $doc->exportField($this->THENAME);
                        $doc->exportField($this->THEADDRESS);
                        $doc->exportField($this->NOTA_NO);
                        $doc->exportField($this->TRANS_ID);
                        $doc->exportField($this->ID);
                    } else {
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->NO_REGISTRATION);
                        $doc->exportField($this->VISIT_ID);
                        $doc->exportField($this->TARIF_ID);
                        $doc->exportField($this->CLASS_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->CLINIC_ID_FROM);
                        $doc->exportField($this->TREATMENT);
                        $doc->exportField($this->TREAT_DATE);
                        $doc->exportField($this->QUANTITY);
                        $doc->exportField($this->MEASURE_ID);
                        $doc->exportField($this->DESCRIPTION);
                        $doc->exportField($this->CLASS_ROOM_ID);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->EMPLOYEE_ID);
                        $doc->exportField($this->DOCTOR);
                        $doc->exportField($this->EXIT_DATE);
                        $doc->exportField($this->EMPLOYEE_ID_FROM);
                        $doc->exportField($this->DOCTOR_FROM);
                        $doc->exportField($this->STATUS_PASIEN_ID);
                        $doc->exportField($this->DIAGNOSA_ID);
                        $doc->exportField($this->THENAME);
                        $doc->exportField($this->THEADDRESS);
                        $doc->exportField($this->THEID);
                        $doc->exportField($this->ISRJ);
                        $doc->exportField($this->AGEYEAR);
                        $doc->exportField($this->AGEMONTH);
                        $doc->exportField($this->AGEDAY);
                        $doc->exportField($this->GENDER);
                        $doc->exportField($this->KARYAWAN);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_FROM);
                        $doc->exportField($this->POTONGAN);
                        $doc->exportField($this->BAYAR);
                        $doc->exportField($this->RETUR);
                        $doc->exportField($this->TARIF_TYPE);
                        $doc->exportField($this->PPNVALUE);
                        $doc->exportField($this->TAGIHAN);
                        $doc->exportField($this->KOREKSI);
                        $doc->exportField($this->AMOUNT_PAID);
                        $doc->exportField($this->DISKON);
                        $doc->exportField($this->NOTA_NO);
                        $doc->exportField($this->SELL_PRICE);
                        $doc->exportField($this->ACCOUNT_ID);
                        $doc->exportField($this->subsidi);
                        $doc->exportField($this->DISCOUNT);
                        $doc->exportField($this->AMOUNT);
                        $doc->exportField($this->PPN);
                        $doc->exportField($this->SUBSIDISAT);
                        $doc->exportField($this->PRINTQ);
                        $doc->exportField($this->PRINTED_BY);
                        $doc->exportField($this->STATUS_TARIF);
                        $doc->exportField($this->CLINIC_TYPE);
                        $doc->exportField($this->PACKAGE_ID);
                        $doc->exportField($this->MODULE_ID);
                        $doc->exportField($this->THEORDER);
                        $doc->exportField($this->CORRECTION_ID);
                        $doc->exportField($this->CORRECTION_BY);
                        $doc->exportField($this->CASHIER);
                        $doc->exportField($this->PAYOR_ID);
                        $doc->exportField($this->KAL_ID);
                        $doc->exportField($this->NO_SKPINAP);
                        $doc->exportField($this->NOKARTU);
                        $doc->exportField($this->PASIEN_ID);
                        $doc->exportField($this->modified_datesys);
                        $doc->exportField($this->MAPPING_SEP);
                        $doc->exportField($this->TRANS_ID);
                        $doc->exportField($this->SPPBILL);
                        $doc->exportField($this->SPPBILLDATE);
                        $doc->exportField($this->SPPBILLUSER);
                        $doc->exportField($this->SPPKASIR);
                        $doc->exportField($this->SPPKASIRDATE);
                        $doc->exportField($this->SPPKASIRUSER);
                        $doc->exportField($this->SPPPOLI);
                        $doc->exportField($this->SPPPOLIUSER);
                        $doc->exportField($this->SPPPOLIDATE);
                        $doc->exportField($this->NO_SURAT_KET);
                        $doc->exportField($this->ID);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
