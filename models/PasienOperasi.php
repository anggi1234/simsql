<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for PASIEN_OPERASI
 */
class PasienOperasi extends DbTable
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
    public $VACTINATION_ID;
    public $NO_REGISTRATION;
    public $VISIT_ID;
    public $BILL_ID;
    public $CLINIC_ID;
    public $VALIDATION;
    public $TERLAYANI;
    public $EMPLOYEE_ID;
    public $PATIENT_CATEGORY_ID;
    public $VACTINATION_DATE;
    public $DESCRIPTION;
    public $MODIFIED_DATE;
    public $MODIFIED_BY;
    public $MODIFIED_FROM;
    public $THENAME;
    public $THEADDRESS;
    public $THEID;
    public $ISRJ;
    public $AGEYEAR;
    public $AGEMONTH;
    public $AGEDAY;
    public $STATUS_PASIEN_ID;
    public $GENDER;
    public $DOCTOR;
    public $KAL_ID;
    public $CLASS_ROOM_ID;
    public $BED_ID;
    public $KELUAR_ID;
    public $ROOMS_ID;
    public $OPERATION_TYPE;
    public $ANESTESI_TYPE;
    public $DIAGNOSA_PRA;
    public $DIAGNOSA_PASCA;
    public $START_OPERATION;
    public $END_OPERATION;
    public $START_ANESTESI;
    public $END_ANESTESI;
    public $RESULT_ID;
    public $TARIF_ID;
    public $DR_OPR;
    public $DR_OPR1;
    public $DR_OPR2;
    public $DR_ANES;
    public $PERAWAT;
    public $PENATA_ANES;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'PASIEN_OPERASI';
        $this->TableName = 'PASIEN_OPERASI';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[PASIEN_OPERASI]";
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
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_ORG_UNIT_CODE', 'ORG_UNIT_CODE', '[ORG_UNIT_CODE]', '[ORG_UNIT_CODE]', 200, 50, -1, false, '[ORG_UNIT_CODE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ORG_UNIT_CODE->IsPrimaryKey = true; // Primary key field
        $this->ORG_UNIT_CODE->Nullable = false; // NOT NULL field
        $this->ORG_UNIT_CODE->Required = true; // Required field
        $this->ORG_UNIT_CODE->Sortable = true; // Allow sort
        $this->ORG_UNIT_CODE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ORG_UNIT_CODE->Param, "CustomMsg");
        $this->Fields['ORG_UNIT_CODE'] = &$this->ORG_UNIT_CODE;

        // VACTINATION_ID
        $this->VACTINATION_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_VACTINATION_ID', 'VACTINATION_ID', '[VACTINATION_ID]', '[VACTINATION_ID]', 200, 50, -1, false, '[VACTINATION_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VACTINATION_ID->IsPrimaryKey = true; // Primary key field
        $this->VACTINATION_ID->Nullable = false; // NOT NULL field
        $this->VACTINATION_ID->Required = true; // Required field
        $this->VACTINATION_ID->Sortable = true; // Allow sort
        $this->VACTINATION_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VACTINATION_ID->Param, "CustomMsg");
        $this->Fields['VACTINATION_ID'] = &$this->VACTINATION_ID;

        // NO_REGISTRATION
        $this->NO_REGISTRATION = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_NO_REGISTRATION', 'NO_REGISTRATION', '[NO_REGISTRATION]', '[NO_REGISTRATION]', 200, 50, -1, false, '[NO_REGISTRATION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NO_REGISTRATION->Sortable = true; // Allow sort
        $this->NO_REGISTRATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NO_REGISTRATION->Param, "CustomMsg");
        $this->Fields['NO_REGISTRATION'] = &$this->NO_REGISTRATION;

        // VISIT_ID
        $this->VISIT_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_VISIT_ID', 'VISIT_ID', '[VISIT_ID]', '[VISIT_ID]', 200, 50, -1, false, '[VISIT_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VISIT_ID->Sortable = true; // Allow sort
        $this->VISIT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VISIT_ID->Param, "CustomMsg");
        $this->Fields['VISIT_ID'] = &$this->VISIT_ID;

        // BILL_ID
        $this->BILL_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_BILL_ID', 'BILL_ID', '[BILL_ID]', '[BILL_ID]', 200, 50, -1, false, '[BILL_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BILL_ID->Sortable = true; // Allow sort
        $this->BILL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BILL_ID->Param, "CustomMsg");
        $this->Fields['BILL_ID'] = &$this->BILL_ID;

        // CLINIC_ID
        $this->CLINIC_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_CLINIC_ID', 'CLINIC_ID', '[CLINIC_ID]', '[CLINIC_ID]', 200, 8, -1, false, '[CLINIC_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLINIC_ID->Sortable = true; // Allow sort
        $this->CLINIC_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLINIC_ID->Param, "CustomMsg");
        $this->Fields['CLINIC_ID'] = &$this->CLINIC_ID;

        // VALIDATION
        $this->VALIDATION = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_VALIDATION', 'VALIDATION', '[VALIDATION]', 'CAST([VALIDATION] AS NVARCHAR)', 17, 1, -1, false, '[VALIDATION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VALIDATION->Sortable = true; // Allow sort
        $this->VALIDATION->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->VALIDATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VALIDATION->Param, "CustomMsg");
        $this->Fields['VALIDATION'] = &$this->VALIDATION;

        // TERLAYANI
        $this->TERLAYANI = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_TERLAYANI', 'TERLAYANI', '[TERLAYANI]', 'CAST([TERLAYANI] AS NVARCHAR)', 17, 1, -1, false, '[TERLAYANI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TERLAYANI->Sortable = true; // Allow sort
        $this->TERLAYANI->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->TERLAYANI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TERLAYANI->Param, "CustomMsg");
        $this->Fields['TERLAYANI'] = &$this->TERLAYANI;

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_EMPLOYEE_ID', 'EMPLOYEE_ID', '[EMPLOYEE_ID]', '[EMPLOYEE_ID]', 200, 15, -1, false, '[EMPLOYEE_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->EMPLOYEE_ID->Sortable = true; // Allow sort
        $this->EMPLOYEE_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->EMPLOYEE_ID->Param, "CustomMsg");
        $this->Fields['EMPLOYEE_ID'] = &$this->EMPLOYEE_ID;

        // PATIENT_CATEGORY_ID
        $this->PATIENT_CATEGORY_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_PATIENT_CATEGORY_ID', 'PATIENT_CATEGORY_ID', '[PATIENT_CATEGORY_ID]', 'CAST([PATIENT_CATEGORY_ID] AS NVARCHAR)', 17, 1, -1, false, '[PATIENT_CATEGORY_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PATIENT_CATEGORY_ID->Sortable = true; // Allow sort
        $this->PATIENT_CATEGORY_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->PATIENT_CATEGORY_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PATIENT_CATEGORY_ID->Param, "CustomMsg");
        $this->Fields['PATIENT_CATEGORY_ID'] = &$this->PATIENT_CATEGORY_ID;

        // VACTINATION_DATE
        $this->VACTINATION_DATE = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_VACTINATION_DATE', 'VACTINATION_DATE', '[VACTINATION_DATE]', CastDateFieldForLike("[VACTINATION_DATE]", 0, "DB"), 135, 8, 0, false, '[VACTINATION_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->VACTINATION_DATE->Sortable = true; // Allow sort
        $this->VACTINATION_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->VACTINATION_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->VACTINATION_DATE->Param, "CustomMsg");
        $this->Fields['VACTINATION_DATE'] = &$this->VACTINATION_DATE;

        // DESCRIPTION
        $this->DESCRIPTION = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DESCRIPTION', 'DESCRIPTION', '[DESCRIPTION]', '[DESCRIPTION]', 200, 255, -1, false, '[DESCRIPTION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DESCRIPTION->Sortable = true; // Allow sort
        $this->DESCRIPTION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DESCRIPTION->Param, "CustomMsg");
        $this->Fields['DESCRIPTION'] = &$this->DESCRIPTION;

        // MODIFIED_DATE
        $this->MODIFIED_DATE = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_MODIFIED_DATE', 'MODIFIED_DATE', '[MODIFIED_DATE]', CastDateFieldForLike("[MODIFIED_DATE]", 0, "DB"), 135, 8, 0, false, '[MODIFIED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_DATE->Sortable = true; // Allow sort
        $this->MODIFIED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->MODIFIED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_DATE->Param, "CustomMsg");
        $this->Fields['MODIFIED_DATE'] = &$this->MODIFIED_DATE;

        // MODIFIED_BY
        $this->MODIFIED_BY = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_MODIFIED_BY', 'MODIFIED_BY', '[MODIFIED_BY]', '[MODIFIED_BY]', 200, 50, -1, false, '[MODIFIED_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_BY->Sortable = true; // Allow sort
        $this->MODIFIED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_BY->Param, "CustomMsg");
        $this->Fields['MODIFIED_BY'] = &$this->MODIFIED_BY;

        // MODIFIED_FROM
        $this->MODIFIED_FROM = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_MODIFIED_FROM', 'MODIFIED_FROM', '[MODIFIED_FROM]', '[MODIFIED_FROM]', 200, 50, -1, false, '[MODIFIED_FROM]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_FROM->Sortable = true; // Allow sort
        $this->MODIFIED_FROM->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_FROM->Param, "CustomMsg");
        $this->Fields['MODIFIED_FROM'] = &$this->MODIFIED_FROM;

        // THENAME
        $this->THENAME = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_THENAME', 'THENAME', '[THENAME]', '[THENAME]', 200, 100, -1, false, '[THENAME]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THENAME->Sortable = true; // Allow sort
        $this->THENAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THENAME->Param, "CustomMsg");
        $this->Fields['THENAME'] = &$this->THENAME;

        // THEADDRESS
        $this->THEADDRESS = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_THEADDRESS', 'THEADDRESS', '[THEADDRESS]', '[THEADDRESS]', 200, 150, -1, false, '[THEADDRESS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEADDRESS->Sortable = true; // Allow sort
        $this->THEADDRESS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEADDRESS->Param, "CustomMsg");
        $this->Fields['THEADDRESS'] = &$this->THEADDRESS;

        // THEID
        $this->THEID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_THEID', 'THEID', '[THEID]', '[THEID]', 200, 50, -1, false, '[THEID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->THEID->Sortable = true; // Allow sort
        $this->THEID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->THEID->Param, "CustomMsg");
        $this->Fields['THEID'] = &$this->THEID;

        // ISRJ
        $this->ISRJ = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_ISRJ', 'ISRJ', '[ISRJ]', '[ISRJ]', 129, 1, -1, false, '[ISRJ]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ISRJ->Sortable = true; // Allow sort
        $this->ISRJ->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ISRJ->Param, "CustomMsg");
        $this->Fields['ISRJ'] = &$this->ISRJ;

        // AGEYEAR
        $this->AGEYEAR = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_AGEYEAR', 'AGEYEAR', '[AGEYEAR]', 'CAST([AGEYEAR] AS NVARCHAR)', 17, 1, -1, false, '[AGEYEAR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEYEAR->Sortable = true; // Allow sort
        $this->AGEYEAR->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEYEAR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEYEAR->Param, "CustomMsg");
        $this->Fields['AGEYEAR'] = &$this->AGEYEAR;

        // AGEMONTH
        $this->AGEMONTH = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_AGEMONTH', 'AGEMONTH', '[AGEMONTH]', 'CAST([AGEMONTH] AS NVARCHAR)', 17, 1, -1, false, '[AGEMONTH]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEMONTH->Sortable = true; // Allow sort
        $this->AGEMONTH->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEMONTH->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEMONTH->Param, "CustomMsg");
        $this->Fields['AGEMONTH'] = &$this->AGEMONTH;

        // AGEDAY
        $this->AGEDAY = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_AGEDAY', 'AGEDAY', '[AGEDAY]', 'CAST([AGEDAY] AS NVARCHAR)', 17, 1, -1, false, '[AGEDAY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->AGEDAY->Sortable = true; // Allow sort
        $this->AGEDAY->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->AGEDAY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->AGEDAY->Param, "CustomMsg");
        $this->Fields['AGEDAY'] = &$this->AGEDAY;

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_STATUS_PASIEN_ID', 'STATUS_PASIEN_ID', '[STATUS_PASIEN_ID]', 'CAST([STATUS_PASIEN_ID] AS NVARCHAR)', 17, 1, -1, false, '[STATUS_PASIEN_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->STATUS_PASIEN_ID->Sortable = true; // Allow sort
        $this->STATUS_PASIEN_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->STATUS_PASIEN_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->STATUS_PASIEN_ID->Param, "CustomMsg");
        $this->Fields['STATUS_PASIEN_ID'] = &$this->STATUS_PASIEN_ID;

        // GENDER
        $this->GENDER = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_GENDER', 'GENDER', '[GENDER]', '[GENDER]', 129, 1, -1, false, '[GENDER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->GENDER->Sortable = true; // Allow sort
        $this->GENDER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->GENDER->Param, "CustomMsg");
        $this->Fields['GENDER'] = &$this->GENDER;

        // DOCTOR
        $this->DOCTOR = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DOCTOR', 'DOCTOR', '[DOCTOR]', '[DOCTOR]', 200, 150, -1, false, '[DOCTOR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DOCTOR->Sortable = true; // Allow sort
        $this->DOCTOR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DOCTOR->Param, "CustomMsg");
        $this->Fields['DOCTOR'] = &$this->DOCTOR;

        // KAL_ID
        $this->KAL_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_KAL_ID', 'KAL_ID', '[KAL_ID]', '[KAL_ID]', 200, 50, -1, false, '[KAL_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KAL_ID->Sortable = true; // Allow sort
        $this->KAL_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KAL_ID->Param, "CustomMsg");
        $this->Fields['KAL_ID'] = &$this->KAL_ID;

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_CLASS_ROOM_ID', 'CLASS_ROOM_ID', '[CLASS_ROOM_ID]', '[CLASS_ROOM_ID]', 200, 15, -1, false, '[CLASS_ROOM_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->CLASS_ROOM_ID->Sortable = true; // Allow sort
        $this->CLASS_ROOM_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->CLASS_ROOM_ID->Param, "CustomMsg");
        $this->Fields['CLASS_ROOM_ID'] = &$this->CLASS_ROOM_ID;

        // BED_ID
        $this->BED_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_BED_ID', 'BED_ID', '[BED_ID]', 'CAST([BED_ID] AS NVARCHAR)', 17, 1, -1, false, '[BED_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BED_ID->Sortable = true; // Allow sort
        $this->BED_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->BED_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BED_ID->Param, "CustomMsg");
        $this->Fields['BED_ID'] = &$this->BED_ID;

        // KELUAR_ID
        $this->KELUAR_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_KELUAR_ID', 'KELUAR_ID', '[KELUAR_ID]', 'CAST([KELUAR_ID] AS NVARCHAR)', 17, 1, -1, false, '[KELUAR_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KELUAR_ID->Sortable = true; // Allow sort
        $this->KELUAR_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->KELUAR_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KELUAR_ID->Param, "CustomMsg");
        $this->Fields['KELUAR_ID'] = &$this->KELUAR_ID;

        // ROOMS_ID
        $this->ROOMS_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_ROOMS_ID', 'ROOMS_ID', '[ROOMS_ID]', '[ROOMS_ID]', 200, 10, -1, false, '[ROOMS_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ROOMS_ID->Sortable = true; // Allow sort
        $this->ROOMS_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ROOMS_ID->Param, "CustomMsg");
        $this->Fields['ROOMS_ID'] = &$this->ROOMS_ID;

        // OPERATION_TYPE
        $this->OPERATION_TYPE = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_OPERATION_TYPE', 'OPERATION_TYPE', '[OPERATION_TYPE]', '[OPERATION_TYPE]', 200, 25, -1, false, '[OPERATION_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->OPERATION_TYPE->Sortable = true; // Allow sort
        $this->OPERATION_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->OPERATION_TYPE->Param, "CustomMsg");
        $this->Fields['OPERATION_TYPE'] = &$this->OPERATION_TYPE;

        // ANESTESI_TYPE
        $this->ANESTESI_TYPE = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_ANESTESI_TYPE', 'ANESTESI_TYPE', '[ANESTESI_TYPE]', 'CAST([ANESTESI_TYPE] AS NVARCHAR)', 17, 1, -1, false, '[ANESTESI_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ANESTESI_TYPE->Sortable = true; // Allow sort
        $this->ANESTESI_TYPE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ANESTESI_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ANESTESI_TYPE->Param, "CustomMsg");
        $this->Fields['ANESTESI_TYPE'] = &$this->ANESTESI_TYPE;

        // DIAGNOSA_PRA
        $this->DIAGNOSA_PRA = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DIAGNOSA_PRA', 'DIAGNOSA_PRA', '[DIAGNOSA_PRA]', '[DIAGNOSA_PRA]', 200, 250, -1, false, '[DIAGNOSA_PRA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_PRA->Sortable = true; // Allow sort
        $this->DIAGNOSA_PRA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_PRA->Param, "CustomMsg");
        $this->Fields['DIAGNOSA_PRA'] = &$this->DIAGNOSA_PRA;

        // DIAGNOSA_PASCA
        $this->DIAGNOSA_PASCA = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DIAGNOSA_PASCA', 'DIAGNOSA_PASCA', '[DIAGNOSA_PASCA]', '[DIAGNOSA_PASCA]', 200, 250, -1, false, '[DIAGNOSA_PASCA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_PASCA->Sortable = true; // Allow sort
        $this->DIAGNOSA_PASCA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_PASCA->Param, "CustomMsg");
        $this->Fields['DIAGNOSA_PASCA'] = &$this->DIAGNOSA_PASCA;

        // START_OPERATION
        $this->START_OPERATION = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_START_OPERATION', 'START_OPERATION', '[START_OPERATION]', CastDateFieldForLike("[START_OPERATION]", 0, "DB"), 135, 8, 0, false, '[START_OPERATION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->START_OPERATION->Sortable = true; // Allow sort
        $this->START_OPERATION->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->START_OPERATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->START_OPERATION->Param, "CustomMsg");
        $this->Fields['START_OPERATION'] = &$this->START_OPERATION;

        // END_OPERATION
        $this->END_OPERATION = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_END_OPERATION', 'END_OPERATION', '[END_OPERATION]', CastDateFieldForLike("[END_OPERATION]", 0, "DB"), 135, 8, 0, false, '[END_OPERATION]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->END_OPERATION->Sortable = true; // Allow sort
        $this->END_OPERATION->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->END_OPERATION->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->END_OPERATION->Param, "CustomMsg");
        $this->Fields['END_OPERATION'] = &$this->END_OPERATION;

        // START_ANESTESI
        $this->START_ANESTESI = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_START_ANESTESI', 'START_ANESTESI', '[START_ANESTESI]', CastDateFieldForLike("[START_ANESTESI]", 0, "DB"), 135, 8, 0, false, '[START_ANESTESI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->START_ANESTESI->Sortable = true; // Allow sort
        $this->START_ANESTESI->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->START_ANESTESI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->START_ANESTESI->Param, "CustomMsg");
        $this->Fields['START_ANESTESI'] = &$this->START_ANESTESI;

        // END_ANESTESI
        $this->END_ANESTESI = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_END_ANESTESI', 'END_ANESTESI', '[END_ANESTESI]', CastDateFieldForLike("[END_ANESTESI]", 0, "DB"), 135, 8, 0, false, '[END_ANESTESI]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->END_ANESTESI->Sortable = true; // Allow sort
        $this->END_ANESTESI->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->END_ANESTESI->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->END_ANESTESI->Param, "CustomMsg");
        $this->Fields['END_ANESTESI'] = &$this->END_ANESTESI;

        // RESULT_ID
        $this->RESULT_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_RESULT_ID', 'RESULT_ID', '[RESULT_ID]', '[RESULT_ID]', 200, 2, -1, false, '[RESULT_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->RESULT_ID->Sortable = true; // Allow sort
        $this->RESULT_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->RESULT_ID->Param, "CustomMsg");
        $this->Fields['RESULT_ID'] = &$this->RESULT_ID;

        // TARIF_ID
        $this->TARIF_ID = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_TARIF_ID', 'TARIF_ID', '[TARIF_ID]', '[TARIF_ID]', 200, 50, -1, false, '[TARIF_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TARIF_ID->Sortable = true; // Allow sort
        $this->TARIF_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TARIF_ID->Param, "CustomMsg");
        $this->Fields['TARIF_ID'] = &$this->TARIF_ID;

        // DR_OPR
        $this->DR_OPR = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DR_OPR', 'DR_OPR', '[DR_OPR]', '[DR_OPR]', 200, 50, -1, false, '[DR_OPR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DR_OPR->Sortable = true; // Allow sort
        $this->DR_OPR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DR_OPR->Param, "CustomMsg");
        $this->Fields['DR_OPR'] = &$this->DR_OPR;

        // DR_OPR1
        $this->DR_OPR1 = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DR_OPR1', 'DR_OPR1', '[DR_OPR1]', '[DR_OPR1]', 200, 50, -1, false, '[DR_OPR1]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DR_OPR1->Sortable = true; // Allow sort
        $this->DR_OPR1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DR_OPR1->Param, "CustomMsg");
        $this->Fields['DR_OPR1'] = &$this->DR_OPR1;

        // DR_OPR2
        $this->DR_OPR2 = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DR_OPR2', 'DR_OPR2', '[DR_OPR2]', '[DR_OPR2]', 200, 50, -1, false, '[DR_OPR2]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DR_OPR2->Sortable = true; // Allow sort
        $this->DR_OPR2->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DR_OPR2->Param, "CustomMsg");
        $this->Fields['DR_OPR2'] = &$this->DR_OPR2;

        // DR_ANES
        $this->DR_ANES = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_DR_ANES', 'DR_ANES', '[DR_ANES]', '[DR_ANES]', 200, 50, -1, false, '[DR_ANES]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DR_ANES->Sortable = true; // Allow sort
        $this->DR_ANES->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DR_ANES->Param, "CustomMsg");
        $this->Fields['DR_ANES'] = &$this->DR_ANES;

        // PERAWAT
        $this->PERAWAT = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_PERAWAT', 'PERAWAT', '[PERAWAT]', '[PERAWAT]', 200, 50, -1, false, '[PERAWAT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PERAWAT->Sortable = true; // Allow sort
        $this->PERAWAT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PERAWAT->Param, "CustomMsg");
        $this->Fields['PERAWAT'] = &$this->PERAWAT;

        // PENATA_ANES
        $this->PENATA_ANES = new DbField('PASIEN_OPERASI', 'PASIEN_OPERASI', 'x_PENATA_ANES', 'PENATA_ANES', '[PENATA_ANES]', '[PENATA_ANES]', 200, 50, -1, false, '[PENATA_ANES]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PENATA_ANES->Sortable = true; // Allow sort
        $this->PENATA_ANES->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PENATA_ANES->Param, "CustomMsg");
        $this->Fields['PENATA_ANES'] = &$this->PENATA_ANES;
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[PASIEN_OPERASI]";
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
            if (array_key_exists('ORG_UNIT_CODE', $rs)) {
                AddFilter($where, QuotedName('ORG_UNIT_CODE', $this->Dbid) . '=' . QuotedValue($rs['ORG_UNIT_CODE'], $this->ORG_UNIT_CODE->DataType, $this->Dbid));
            }
            if (array_key_exists('VACTINATION_ID', $rs)) {
                AddFilter($where, QuotedName('VACTINATION_ID', $this->Dbid) . '=' . QuotedValue($rs['VACTINATION_ID'], $this->VACTINATION_ID->DataType, $this->Dbid));
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
        $this->VACTINATION_ID->DbValue = $row['VACTINATION_ID'];
        $this->NO_REGISTRATION->DbValue = $row['NO_REGISTRATION'];
        $this->VISIT_ID->DbValue = $row['VISIT_ID'];
        $this->BILL_ID->DbValue = $row['BILL_ID'];
        $this->CLINIC_ID->DbValue = $row['CLINIC_ID'];
        $this->VALIDATION->DbValue = $row['VALIDATION'];
        $this->TERLAYANI->DbValue = $row['TERLAYANI'];
        $this->EMPLOYEE_ID->DbValue = $row['EMPLOYEE_ID'];
        $this->PATIENT_CATEGORY_ID->DbValue = $row['PATIENT_CATEGORY_ID'];
        $this->VACTINATION_DATE->DbValue = $row['VACTINATION_DATE'];
        $this->DESCRIPTION->DbValue = $row['DESCRIPTION'];
        $this->MODIFIED_DATE->DbValue = $row['MODIFIED_DATE'];
        $this->MODIFIED_BY->DbValue = $row['MODIFIED_BY'];
        $this->MODIFIED_FROM->DbValue = $row['MODIFIED_FROM'];
        $this->THENAME->DbValue = $row['THENAME'];
        $this->THEADDRESS->DbValue = $row['THEADDRESS'];
        $this->THEID->DbValue = $row['THEID'];
        $this->ISRJ->DbValue = $row['ISRJ'];
        $this->AGEYEAR->DbValue = $row['AGEYEAR'];
        $this->AGEMONTH->DbValue = $row['AGEMONTH'];
        $this->AGEDAY->DbValue = $row['AGEDAY'];
        $this->STATUS_PASIEN_ID->DbValue = $row['STATUS_PASIEN_ID'];
        $this->GENDER->DbValue = $row['GENDER'];
        $this->DOCTOR->DbValue = $row['DOCTOR'];
        $this->KAL_ID->DbValue = $row['KAL_ID'];
        $this->CLASS_ROOM_ID->DbValue = $row['CLASS_ROOM_ID'];
        $this->BED_ID->DbValue = $row['BED_ID'];
        $this->KELUAR_ID->DbValue = $row['KELUAR_ID'];
        $this->ROOMS_ID->DbValue = $row['ROOMS_ID'];
        $this->OPERATION_TYPE->DbValue = $row['OPERATION_TYPE'];
        $this->ANESTESI_TYPE->DbValue = $row['ANESTESI_TYPE'];
        $this->DIAGNOSA_PRA->DbValue = $row['DIAGNOSA_PRA'];
        $this->DIAGNOSA_PASCA->DbValue = $row['DIAGNOSA_PASCA'];
        $this->START_OPERATION->DbValue = $row['START_OPERATION'];
        $this->END_OPERATION->DbValue = $row['END_OPERATION'];
        $this->START_ANESTESI->DbValue = $row['START_ANESTESI'];
        $this->END_ANESTESI->DbValue = $row['END_ANESTESI'];
        $this->RESULT_ID->DbValue = $row['RESULT_ID'];
        $this->TARIF_ID->DbValue = $row['TARIF_ID'];
        $this->DR_OPR->DbValue = $row['DR_OPR'];
        $this->DR_OPR1->DbValue = $row['DR_OPR1'];
        $this->DR_OPR2->DbValue = $row['DR_OPR2'];
        $this->DR_ANES->DbValue = $row['DR_ANES'];
        $this->PERAWAT->DbValue = $row['PERAWAT'];
        $this->PENATA_ANES->DbValue = $row['PENATA_ANES'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[ORG_UNIT_CODE] = '@ORG_UNIT_CODE@' AND [VACTINATION_ID] = '@VACTINATION_ID@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->ORG_UNIT_CODE->CurrentValue : $this->ORG_UNIT_CODE->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->VACTINATION_ID->CurrentValue : $this->VACTINATION_ID->OldValue;
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
        if (count($keys) == 2) {
            if ($current) {
                $this->ORG_UNIT_CODE->CurrentValue = $keys[0];
            } else {
                $this->ORG_UNIT_CODE->OldValue = $keys[0];
            }
            if ($current) {
                $this->VACTINATION_ID->CurrentValue = $keys[1];
            } else {
                $this->VACTINATION_ID->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('ORG_UNIT_CODE', $row) ? $row['ORG_UNIT_CODE'] : null;
        } else {
            $val = $this->ORG_UNIT_CODE->OldValue !== null ? $this->ORG_UNIT_CODE->OldValue : $this->ORG_UNIT_CODE->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ORG_UNIT_CODE@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('VACTINATION_ID', $row) ? $row['VACTINATION_ID'] : null;
        } else {
            $val = $this->VACTINATION_ID->OldValue !== null ? $this->VACTINATION_ID->OldValue : $this->VACTINATION_ID->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@VACTINATION_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("PasienOperasiList");
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
        if ($pageName == "PasienOperasiView") {
            return $Language->phrase("View");
        } elseif ($pageName == "PasienOperasiEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "PasienOperasiAdd") {
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
                return "PasienOperasiView";
            case Config("API_ADD_ACTION"):
                return "PasienOperasiAdd";
            case Config("API_EDIT_ACTION"):
                return "PasienOperasiEdit";
            case Config("API_DELETE_ACTION"):
                return "PasienOperasiDelete";
            case Config("API_LIST_ACTION"):
                return "PasienOperasiList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "PasienOperasiList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PasienOperasiView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PasienOperasiView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PasienOperasiAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "PasienOperasiAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("PasienOperasiEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("PasienOperasiAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("PasienOperasiDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "ORG_UNIT_CODE:" . JsonEncode($this->ORG_UNIT_CODE->CurrentValue, "string");
        $json .= ",VACTINATION_ID:" . JsonEncode($this->VACTINATION_ID->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->ORG_UNIT_CODE->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->ORG_UNIT_CODE->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->VACTINATION_ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->VACTINATION_ID->CurrentValue);
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("ORG_UNIT_CODE") ?? Route("ORG_UNIT_CODE")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("VACTINATION_ID") ?? Route("VACTINATION_ID")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
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
                $this->ORG_UNIT_CODE->CurrentValue = $key[0];
            } else {
                $this->ORG_UNIT_CODE->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->VACTINATION_ID->CurrentValue = $key[1];
            } else {
                $this->VACTINATION_ID->OldValue = $key[1];
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
        $this->VACTINATION_ID->setDbValue($row['VACTINATION_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->BILL_ID->setDbValue($row['BILL_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->VALIDATION->setDbValue($row['VALIDATION']);
        $this->TERLAYANI->setDbValue($row['TERLAYANI']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->PATIENT_CATEGORY_ID->setDbValue($row['PATIENT_CATEGORY_ID']);
        $this->VACTINATION_DATE->setDbValue($row['VACTINATION_DATE']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->ROOMS_ID->setDbValue($row['ROOMS_ID']);
        $this->OPERATION_TYPE->setDbValue($row['OPERATION_TYPE']);
        $this->ANESTESI_TYPE->setDbValue($row['ANESTESI_TYPE']);
        $this->DIAGNOSA_PRA->setDbValue($row['DIAGNOSA_PRA']);
        $this->DIAGNOSA_PASCA->setDbValue($row['DIAGNOSA_PASCA']);
        $this->START_OPERATION->setDbValue($row['START_OPERATION']);
        $this->END_OPERATION->setDbValue($row['END_OPERATION']);
        $this->START_ANESTESI->setDbValue($row['START_ANESTESI']);
        $this->END_ANESTESI->setDbValue($row['END_ANESTESI']);
        $this->RESULT_ID->setDbValue($row['RESULT_ID']);
        $this->TARIF_ID->setDbValue($row['TARIF_ID']);
        $this->DR_OPR->setDbValue($row['DR_OPR']);
        $this->DR_OPR1->setDbValue($row['DR_OPR1']);
        $this->DR_OPR2->setDbValue($row['DR_OPR2']);
        $this->DR_ANES->setDbValue($row['DR_ANES']);
        $this->PERAWAT->setDbValue($row['PERAWAT']);
        $this->PENATA_ANES->setDbValue($row['PENATA_ANES']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // ORG_UNIT_CODE

        // VACTINATION_ID

        // NO_REGISTRATION

        // VISIT_ID

        // BILL_ID

        // CLINIC_ID

        // VALIDATION

        // TERLAYANI

        // EMPLOYEE_ID

        // PATIENT_CATEGORY_ID

        // VACTINATION_DATE

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // MODIFIED_FROM

        // THENAME

        // THEADDRESS

        // THEID

        // ISRJ

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // STATUS_PASIEN_ID

        // GENDER

        // DOCTOR

        // KAL_ID

        // CLASS_ROOM_ID

        // BED_ID

        // KELUAR_ID

        // ROOMS_ID

        // OPERATION_TYPE

        // ANESTESI_TYPE

        // DIAGNOSA_PRA

        // DIAGNOSA_PASCA

        // START_OPERATION

        // END_OPERATION

        // START_ANESTESI

        // END_ANESTESI

        // RESULT_ID

        // TARIF_ID

        // DR_OPR

        // DR_OPR1

        // DR_OPR2

        // DR_ANES

        // PERAWAT

        // PENATA_ANES

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

        // VACTINATION_ID
        $this->VACTINATION_ID->ViewValue = $this->VACTINATION_ID->CurrentValue;
        $this->VACTINATION_ID->ViewCustomAttributes = "";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
        $this->NO_REGISTRATION->ViewCustomAttributes = "";

        // VISIT_ID
        $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
        $this->VISIT_ID->ViewCustomAttributes = "";

        // BILL_ID
        $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
        $this->BILL_ID->ViewCustomAttributes = "";

        // CLINIC_ID
        $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
        $this->CLINIC_ID->ViewCustomAttributes = "";

        // VALIDATION
        $this->VALIDATION->ViewValue = $this->VALIDATION->CurrentValue;
        $this->VALIDATION->ViewValue = FormatNumber($this->VALIDATION->ViewValue, 0, -2, -2, -2);
        $this->VALIDATION->ViewCustomAttributes = "";

        // TERLAYANI
        $this->TERLAYANI->ViewValue = $this->TERLAYANI->CurrentValue;
        $this->TERLAYANI->ViewValue = FormatNumber($this->TERLAYANI->ViewValue, 0, -2, -2, -2);
        $this->TERLAYANI->ViewCustomAttributes = "";

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->EMPLOYEE_ID->ViewCustomAttributes = "";

        // PATIENT_CATEGORY_ID
        $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
        $this->PATIENT_CATEGORY_ID->ViewValue = FormatNumber($this->PATIENT_CATEGORY_ID->ViewValue, 0, -2, -2, -2);
        $this->PATIENT_CATEGORY_ID->ViewCustomAttributes = "";

        // VACTINATION_DATE
        $this->VACTINATION_DATE->ViewValue = $this->VACTINATION_DATE->CurrentValue;
        $this->VACTINATION_DATE->ViewValue = FormatDateTime($this->VACTINATION_DATE->ViewValue, 0);
        $this->VACTINATION_DATE->ViewCustomAttributes = "";

        // DESCRIPTION
        $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
        $this->DESCRIPTION->ViewCustomAttributes = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
        $this->MODIFIED_DATE->ViewCustomAttributes = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->ViewCustomAttributes = "";

        // MODIFIED_FROM
        $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
        $this->MODIFIED_FROM->ViewCustomAttributes = "";

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

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
        $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

        // GENDER
        $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
        $this->GENDER->ViewCustomAttributes = "";

        // DOCTOR
        $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
        $this->DOCTOR->ViewCustomAttributes = "";

        // KAL_ID
        $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
        $this->KAL_ID->ViewCustomAttributes = "";

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
        $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

        // BED_ID
        $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
        $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
        $this->BED_ID->ViewCustomAttributes = "";

        // KELUAR_ID
        $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->CurrentValue;
        $this->KELUAR_ID->ViewValue = FormatNumber($this->KELUAR_ID->ViewValue, 0, -2, -2, -2);
        $this->KELUAR_ID->ViewCustomAttributes = "";

        // ROOMS_ID
        $this->ROOMS_ID->ViewValue = $this->ROOMS_ID->CurrentValue;
        $this->ROOMS_ID->ViewCustomAttributes = "";

        // OPERATION_TYPE
        $this->OPERATION_TYPE->ViewValue = $this->OPERATION_TYPE->CurrentValue;
        $this->OPERATION_TYPE->ViewCustomAttributes = "";

        // ANESTESI_TYPE
        $this->ANESTESI_TYPE->ViewValue = $this->ANESTESI_TYPE->CurrentValue;
        $this->ANESTESI_TYPE->ViewValue = FormatNumber($this->ANESTESI_TYPE->ViewValue, 0, -2, -2, -2);
        $this->ANESTESI_TYPE->ViewCustomAttributes = "";

        // DIAGNOSA_PRA
        $this->DIAGNOSA_PRA->ViewValue = $this->DIAGNOSA_PRA->CurrentValue;
        $this->DIAGNOSA_PRA->ViewCustomAttributes = "";

        // DIAGNOSA_PASCA
        $this->DIAGNOSA_PASCA->ViewValue = $this->DIAGNOSA_PASCA->CurrentValue;
        $this->DIAGNOSA_PASCA->ViewCustomAttributes = "";

        // START_OPERATION
        $this->START_OPERATION->ViewValue = $this->START_OPERATION->CurrentValue;
        $this->START_OPERATION->ViewValue = FormatDateTime($this->START_OPERATION->ViewValue, 0);
        $this->START_OPERATION->ViewCustomAttributes = "";

        // END_OPERATION
        $this->END_OPERATION->ViewValue = $this->END_OPERATION->CurrentValue;
        $this->END_OPERATION->ViewValue = FormatDateTime($this->END_OPERATION->ViewValue, 0);
        $this->END_OPERATION->ViewCustomAttributes = "";

        // START_ANESTESI
        $this->START_ANESTESI->ViewValue = $this->START_ANESTESI->CurrentValue;
        $this->START_ANESTESI->ViewValue = FormatDateTime($this->START_ANESTESI->ViewValue, 0);
        $this->START_ANESTESI->ViewCustomAttributes = "";

        // END_ANESTESI
        $this->END_ANESTESI->ViewValue = $this->END_ANESTESI->CurrentValue;
        $this->END_ANESTESI->ViewValue = FormatDateTime($this->END_ANESTESI->ViewValue, 0);
        $this->END_ANESTESI->ViewCustomAttributes = "";

        // RESULT_ID
        $this->RESULT_ID->ViewValue = $this->RESULT_ID->CurrentValue;
        $this->RESULT_ID->ViewCustomAttributes = "";

        // TARIF_ID
        $this->TARIF_ID->ViewValue = $this->TARIF_ID->CurrentValue;
        $this->TARIF_ID->ViewCustomAttributes = "";

        // DR_OPR
        $this->DR_OPR->ViewValue = $this->DR_OPR->CurrentValue;
        $this->DR_OPR->ViewCustomAttributes = "";

        // DR_OPR1
        $this->DR_OPR1->ViewValue = $this->DR_OPR1->CurrentValue;
        $this->DR_OPR1->ViewCustomAttributes = "";

        // DR_OPR2
        $this->DR_OPR2->ViewValue = $this->DR_OPR2->CurrentValue;
        $this->DR_OPR2->ViewCustomAttributes = "";

        // DR_ANES
        $this->DR_ANES->ViewValue = $this->DR_ANES->CurrentValue;
        $this->DR_ANES->ViewCustomAttributes = "";

        // PERAWAT
        $this->PERAWAT->ViewValue = $this->PERAWAT->CurrentValue;
        $this->PERAWAT->ViewCustomAttributes = "";

        // PENATA_ANES
        $this->PENATA_ANES->ViewValue = $this->PENATA_ANES->CurrentValue;
        $this->PENATA_ANES->ViewCustomAttributes = "";

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
        $this->ORG_UNIT_CODE->HrefValue = "";
        $this->ORG_UNIT_CODE->TooltipValue = "";

        // VACTINATION_ID
        $this->VACTINATION_ID->LinkCustomAttributes = "";
        $this->VACTINATION_ID->HrefValue = "";
        $this->VACTINATION_ID->TooltipValue = "";

        // NO_REGISTRATION
        $this->NO_REGISTRATION->LinkCustomAttributes = "";
        $this->NO_REGISTRATION->HrefValue = "";
        $this->NO_REGISTRATION->TooltipValue = "";

        // VISIT_ID
        $this->VISIT_ID->LinkCustomAttributes = "";
        $this->VISIT_ID->HrefValue = "";
        $this->VISIT_ID->TooltipValue = "";

        // BILL_ID
        $this->BILL_ID->LinkCustomAttributes = "";
        $this->BILL_ID->HrefValue = "";
        $this->BILL_ID->TooltipValue = "";

        // CLINIC_ID
        $this->CLINIC_ID->LinkCustomAttributes = "";
        $this->CLINIC_ID->HrefValue = "";
        $this->CLINIC_ID->TooltipValue = "";

        // VALIDATION
        $this->VALIDATION->LinkCustomAttributes = "";
        $this->VALIDATION->HrefValue = "";
        $this->VALIDATION->TooltipValue = "";

        // TERLAYANI
        $this->TERLAYANI->LinkCustomAttributes = "";
        $this->TERLAYANI->HrefValue = "";
        $this->TERLAYANI->TooltipValue = "";

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->LinkCustomAttributes = "";
        $this->EMPLOYEE_ID->HrefValue = "";
        $this->EMPLOYEE_ID->TooltipValue = "";

        // PATIENT_CATEGORY_ID
        $this->PATIENT_CATEGORY_ID->LinkCustomAttributes = "";
        $this->PATIENT_CATEGORY_ID->HrefValue = "";
        $this->PATIENT_CATEGORY_ID->TooltipValue = "";

        // VACTINATION_DATE
        $this->VACTINATION_DATE->LinkCustomAttributes = "";
        $this->VACTINATION_DATE->HrefValue = "";
        $this->VACTINATION_DATE->TooltipValue = "";

        // DESCRIPTION
        $this->DESCRIPTION->LinkCustomAttributes = "";
        $this->DESCRIPTION->HrefValue = "";
        $this->DESCRIPTION->TooltipValue = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->LinkCustomAttributes = "";
        $this->MODIFIED_DATE->HrefValue = "";
        $this->MODIFIED_DATE->TooltipValue = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->LinkCustomAttributes = "";
        $this->MODIFIED_BY->HrefValue = "";
        $this->MODIFIED_BY->TooltipValue = "";

        // MODIFIED_FROM
        $this->MODIFIED_FROM->LinkCustomAttributes = "";
        $this->MODIFIED_FROM->HrefValue = "";
        $this->MODIFIED_FROM->TooltipValue = "";

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

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
        $this->STATUS_PASIEN_ID->HrefValue = "";
        $this->STATUS_PASIEN_ID->TooltipValue = "";

        // GENDER
        $this->GENDER->LinkCustomAttributes = "";
        $this->GENDER->HrefValue = "";
        $this->GENDER->TooltipValue = "";

        // DOCTOR
        $this->DOCTOR->LinkCustomAttributes = "";
        $this->DOCTOR->HrefValue = "";
        $this->DOCTOR->TooltipValue = "";

        // KAL_ID
        $this->KAL_ID->LinkCustomAttributes = "";
        $this->KAL_ID->HrefValue = "";
        $this->KAL_ID->TooltipValue = "";

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
        $this->CLASS_ROOM_ID->HrefValue = "";
        $this->CLASS_ROOM_ID->TooltipValue = "";

        // BED_ID
        $this->BED_ID->LinkCustomAttributes = "";
        $this->BED_ID->HrefValue = "";
        $this->BED_ID->TooltipValue = "";

        // KELUAR_ID
        $this->KELUAR_ID->LinkCustomAttributes = "";
        $this->KELUAR_ID->HrefValue = "";
        $this->KELUAR_ID->TooltipValue = "";

        // ROOMS_ID
        $this->ROOMS_ID->LinkCustomAttributes = "";
        $this->ROOMS_ID->HrefValue = "";
        $this->ROOMS_ID->TooltipValue = "";

        // OPERATION_TYPE
        $this->OPERATION_TYPE->LinkCustomAttributes = "";
        $this->OPERATION_TYPE->HrefValue = "";
        $this->OPERATION_TYPE->TooltipValue = "";

        // ANESTESI_TYPE
        $this->ANESTESI_TYPE->LinkCustomAttributes = "";
        $this->ANESTESI_TYPE->HrefValue = "";
        $this->ANESTESI_TYPE->TooltipValue = "";

        // DIAGNOSA_PRA
        $this->DIAGNOSA_PRA->LinkCustomAttributes = "";
        $this->DIAGNOSA_PRA->HrefValue = "";
        $this->DIAGNOSA_PRA->TooltipValue = "";

        // DIAGNOSA_PASCA
        $this->DIAGNOSA_PASCA->LinkCustomAttributes = "";
        $this->DIAGNOSA_PASCA->HrefValue = "";
        $this->DIAGNOSA_PASCA->TooltipValue = "";

        // START_OPERATION
        $this->START_OPERATION->LinkCustomAttributes = "";
        $this->START_OPERATION->HrefValue = "";
        $this->START_OPERATION->TooltipValue = "";

        // END_OPERATION
        $this->END_OPERATION->LinkCustomAttributes = "";
        $this->END_OPERATION->HrefValue = "";
        $this->END_OPERATION->TooltipValue = "";

        // START_ANESTESI
        $this->START_ANESTESI->LinkCustomAttributes = "";
        $this->START_ANESTESI->HrefValue = "";
        $this->START_ANESTESI->TooltipValue = "";

        // END_ANESTESI
        $this->END_ANESTESI->LinkCustomAttributes = "";
        $this->END_ANESTESI->HrefValue = "";
        $this->END_ANESTESI->TooltipValue = "";

        // RESULT_ID
        $this->RESULT_ID->LinkCustomAttributes = "";
        $this->RESULT_ID->HrefValue = "";
        $this->RESULT_ID->TooltipValue = "";

        // TARIF_ID
        $this->TARIF_ID->LinkCustomAttributes = "";
        $this->TARIF_ID->HrefValue = "";
        $this->TARIF_ID->TooltipValue = "";

        // DR_OPR
        $this->DR_OPR->LinkCustomAttributes = "";
        $this->DR_OPR->HrefValue = "";
        $this->DR_OPR->TooltipValue = "";

        // DR_OPR1
        $this->DR_OPR1->LinkCustomAttributes = "";
        $this->DR_OPR1->HrefValue = "";
        $this->DR_OPR1->TooltipValue = "";

        // DR_OPR2
        $this->DR_OPR2->LinkCustomAttributes = "";
        $this->DR_OPR2->HrefValue = "";
        $this->DR_OPR2->TooltipValue = "";

        // DR_ANES
        $this->DR_ANES->LinkCustomAttributes = "";
        $this->DR_ANES->HrefValue = "";
        $this->DR_ANES->TooltipValue = "";

        // PERAWAT
        $this->PERAWAT->LinkCustomAttributes = "";
        $this->PERAWAT->HrefValue = "";
        $this->PERAWAT->TooltipValue = "";

        // PENATA_ANES
        $this->PENATA_ANES->LinkCustomAttributes = "";
        $this->PENATA_ANES->HrefValue = "";
        $this->PENATA_ANES->TooltipValue = "";

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
        if (!$this->ORG_UNIT_CODE->Raw) {
            $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
        }
        $this->ORG_UNIT_CODE->EditValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

        // VACTINATION_ID
        $this->VACTINATION_ID->EditAttrs["class"] = "form-control";
        $this->VACTINATION_ID->EditCustomAttributes = "";
        if (!$this->VACTINATION_ID->Raw) {
            $this->VACTINATION_ID->CurrentValue = HtmlDecode($this->VACTINATION_ID->CurrentValue);
        }
        $this->VACTINATION_ID->EditValue = $this->VACTINATION_ID->CurrentValue;
        $this->VACTINATION_ID->PlaceHolder = RemoveHtml($this->VACTINATION_ID->caption());

        // NO_REGISTRATION
        $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
        $this->NO_REGISTRATION->EditCustomAttributes = "";
        if (!$this->NO_REGISTRATION->Raw) {
            $this->NO_REGISTRATION->CurrentValue = HtmlDecode($this->NO_REGISTRATION->CurrentValue);
        }
        $this->NO_REGISTRATION->EditValue = $this->NO_REGISTRATION->CurrentValue;
        $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

        // VISIT_ID
        $this->VISIT_ID->EditAttrs["class"] = "form-control";
        $this->VISIT_ID->EditCustomAttributes = "";
        if (!$this->VISIT_ID->Raw) {
            $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
        }
        $this->VISIT_ID->EditValue = $this->VISIT_ID->CurrentValue;
        $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());

        // BILL_ID
        $this->BILL_ID->EditAttrs["class"] = "form-control";
        $this->BILL_ID->EditCustomAttributes = "";
        if (!$this->BILL_ID->Raw) {
            $this->BILL_ID->CurrentValue = HtmlDecode($this->BILL_ID->CurrentValue);
        }
        $this->BILL_ID->EditValue = $this->BILL_ID->CurrentValue;
        $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());

        // CLINIC_ID
        $this->CLINIC_ID->EditAttrs["class"] = "form-control";
        $this->CLINIC_ID->EditCustomAttributes = "";
        if (!$this->CLINIC_ID->Raw) {
            $this->CLINIC_ID->CurrentValue = HtmlDecode($this->CLINIC_ID->CurrentValue);
        }
        $this->CLINIC_ID->EditValue = $this->CLINIC_ID->CurrentValue;
        $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

        // VALIDATION
        $this->VALIDATION->EditAttrs["class"] = "form-control";
        $this->VALIDATION->EditCustomAttributes = "";
        $this->VALIDATION->EditValue = $this->VALIDATION->CurrentValue;
        $this->VALIDATION->PlaceHolder = RemoveHtml($this->VALIDATION->caption());

        // TERLAYANI
        $this->TERLAYANI->EditAttrs["class"] = "form-control";
        $this->TERLAYANI->EditCustomAttributes = "";
        $this->TERLAYANI->EditValue = $this->TERLAYANI->CurrentValue;
        $this->TERLAYANI->PlaceHolder = RemoveHtml($this->TERLAYANI->caption());

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
        $this->EMPLOYEE_ID->EditCustomAttributes = "";
        if (!$this->EMPLOYEE_ID->Raw) {
            $this->EMPLOYEE_ID->CurrentValue = HtmlDecode($this->EMPLOYEE_ID->CurrentValue);
        }
        $this->EMPLOYEE_ID->EditValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

        // PATIENT_CATEGORY_ID
        $this->PATIENT_CATEGORY_ID->EditAttrs["class"] = "form-control";
        $this->PATIENT_CATEGORY_ID->EditCustomAttributes = "";
        $this->PATIENT_CATEGORY_ID->EditValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
        $this->PATIENT_CATEGORY_ID->PlaceHolder = RemoveHtml($this->PATIENT_CATEGORY_ID->caption());

        // VACTINATION_DATE
        $this->VACTINATION_DATE->EditAttrs["class"] = "form-control";
        $this->VACTINATION_DATE->EditCustomAttributes = "";
        $this->VACTINATION_DATE->EditValue = FormatDateTime($this->VACTINATION_DATE->CurrentValue, 8);
        $this->VACTINATION_DATE->PlaceHolder = RemoveHtml($this->VACTINATION_DATE->caption());

        // DESCRIPTION
        $this->DESCRIPTION->EditAttrs["class"] = "form-control";
        $this->DESCRIPTION->EditCustomAttributes = "";
        if (!$this->DESCRIPTION->Raw) {
            $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
        }
        $this->DESCRIPTION->EditValue = $this->DESCRIPTION->CurrentValue;
        $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

        // MODIFIED_DATE
        $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
        $this->MODIFIED_DATE->EditCustomAttributes = "";
        $this->MODIFIED_DATE->EditValue = FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8);
        $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

        // MODIFIED_BY
        $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
        $this->MODIFIED_BY->EditCustomAttributes = "";
        if (!$this->MODIFIED_BY->Raw) {
            $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
        }
        $this->MODIFIED_BY->EditValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

        // MODIFIED_FROM
        $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
        $this->MODIFIED_FROM->EditCustomAttributes = "";
        if (!$this->MODIFIED_FROM->Raw) {
            $this->MODIFIED_FROM->CurrentValue = HtmlDecode($this->MODIFIED_FROM->CurrentValue);
        }
        $this->MODIFIED_FROM->EditValue = $this->MODIFIED_FROM->CurrentValue;
        $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

        // THENAME
        $this->THENAME->EditAttrs["class"] = "form-control";
        $this->THENAME->EditCustomAttributes = "";
        if (!$this->THENAME->Raw) {
            $this->THENAME->CurrentValue = HtmlDecode($this->THENAME->CurrentValue);
        }
        $this->THENAME->EditValue = $this->THENAME->CurrentValue;
        $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());

        // THEADDRESS
        $this->THEADDRESS->EditAttrs["class"] = "form-control";
        $this->THEADDRESS->EditCustomAttributes = "";
        if (!$this->THEADDRESS->Raw) {
            $this->THEADDRESS->CurrentValue = HtmlDecode($this->THEADDRESS->CurrentValue);
        }
        $this->THEADDRESS->EditValue = $this->THEADDRESS->CurrentValue;
        $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());

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

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
        $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
        $this->STATUS_PASIEN_ID->EditValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

        // GENDER
        $this->GENDER->EditAttrs["class"] = "form-control";
        $this->GENDER->EditCustomAttributes = "";
        if (!$this->GENDER->Raw) {
            $this->GENDER->CurrentValue = HtmlDecode($this->GENDER->CurrentValue);
        }
        $this->GENDER->EditValue = $this->GENDER->CurrentValue;
        $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

        // DOCTOR
        $this->DOCTOR->EditAttrs["class"] = "form-control";
        $this->DOCTOR->EditCustomAttributes = "";
        if (!$this->DOCTOR->Raw) {
            $this->DOCTOR->CurrentValue = HtmlDecode($this->DOCTOR->CurrentValue);
        }
        $this->DOCTOR->EditValue = $this->DOCTOR->CurrentValue;
        $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

        // KAL_ID
        $this->KAL_ID->EditAttrs["class"] = "form-control";
        $this->KAL_ID->EditCustomAttributes = "";
        if (!$this->KAL_ID->Raw) {
            $this->KAL_ID->CurrentValue = HtmlDecode($this->KAL_ID->CurrentValue);
        }
        $this->KAL_ID->EditValue = $this->KAL_ID->CurrentValue;
        $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
        $this->CLASS_ROOM_ID->EditCustomAttributes = "";
        if (!$this->CLASS_ROOM_ID->Raw) {
            $this->CLASS_ROOM_ID->CurrentValue = HtmlDecode($this->CLASS_ROOM_ID->CurrentValue);
        }
        $this->CLASS_ROOM_ID->EditValue = $this->CLASS_ROOM_ID->CurrentValue;
        $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

        // BED_ID
        $this->BED_ID->EditAttrs["class"] = "form-control";
        $this->BED_ID->EditCustomAttributes = "";
        $this->BED_ID->EditValue = $this->BED_ID->CurrentValue;
        $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

        // KELUAR_ID
        $this->KELUAR_ID->EditAttrs["class"] = "form-control";
        $this->KELUAR_ID->EditCustomAttributes = "";
        $this->KELUAR_ID->EditValue = $this->KELUAR_ID->CurrentValue;
        $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

        // ROOMS_ID
        $this->ROOMS_ID->EditAttrs["class"] = "form-control";
        $this->ROOMS_ID->EditCustomAttributes = "";
        if (!$this->ROOMS_ID->Raw) {
            $this->ROOMS_ID->CurrentValue = HtmlDecode($this->ROOMS_ID->CurrentValue);
        }
        $this->ROOMS_ID->EditValue = $this->ROOMS_ID->CurrentValue;
        $this->ROOMS_ID->PlaceHolder = RemoveHtml($this->ROOMS_ID->caption());

        // OPERATION_TYPE
        $this->OPERATION_TYPE->EditAttrs["class"] = "form-control";
        $this->OPERATION_TYPE->EditCustomAttributes = "";
        if (!$this->OPERATION_TYPE->Raw) {
            $this->OPERATION_TYPE->CurrentValue = HtmlDecode($this->OPERATION_TYPE->CurrentValue);
        }
        $this->OPERATION_TYPE->EditValue = $this->OPERATION_TYPE->CurrentValue;
        $this->OPERATION_TYPE->PlaceHolder = RemoveHtml($this->OPERATION_TYPE->caption());

        // ANESTESI_TYPE
        $this->ANESTESI_TYPE->EditAttrs["class"] = "form-control";
        $this->ANESTESI_TYPE->EditCustomAttributes = "";
        $this->ANESTESI_TYPE->EditValue = $this->ANESTESI_TYPE->CurrentValue;
        $this->ANESTESI_TYPE->PlaceHolder = RemoveHtml($this->ANESTESI_TYPE->caption());

        // DIAGNOSA_PRA
        $this->DIAGNOSA_PRA->EditAttrs["class"] = "form-control";
        $this->DIAGNOSA_PRA->EditCustomAttributes = "";
        if (!$this->DIAGNOSA_PRA->Raw) {
            $this->DIAGNOSA_PRA->CurrentValue = HtmlDecode($this->DIAGNOSA_PRA->CurrentValue);
        }
        $this->DIAGNOSA_PRA->EditValue = $this->DIAGNOSA_PRA->CurrentValue;
        $this->DIAGNOSA_PRA->PlaceHolder = RemoveHtml($this->DIAGNOSA_PRA->caption());

        // DIAGNOSA_PASCA
        $this->DIAGNOSA_PASCA->EditAttrs["class"] = "form-control";
        $this->DIAGNOSA_PASCA->EditCustomAttributes = "";
        if (!$this->DIAGNOSA_PASCA->Raw) {
            $this->DIAGNOSA_PASCA->CurrentValue = HtmlDecode($this->DIAGNOSA_PASCA->CurrentValue);
        }
        $this->DIAGNOSA_PASCA->EditValue = $this->DIAGNOSA_PASCA->CurrentValue;
        $this->DIAGNOSA_PASCA->PlaceHolder = RemoveHtml($this->DIAGNOSA_PASCA->caption());

        // START_OPERATION
        $this->START_OPERATION->EditAttrs["class"] = "form-control";
        $this->START_OPERATION->EditCustomAttributes = "";
        $this->START_OPERATION->EditValue = FormatDateTime($this->START_OPERATION->CurrentValue, 8);
        $this->START_OPERATION->PlaceHolder = RemoveHtml($this->START_OPERATION->caption());

        // END_OPERATION
        $this->END_OPERATION->EditAttrs["class"] = "form-control";
        $this->END_OPERATION->EditCustomAttributes = "";
        $this->END_OPERATION->EditValue = FormatDateTime($this->END_OPERATION->CurrentValue, 8);
        $this->END_OPERATION->PlaceHolder = RemoveHtml($this->END_OPERATION->caption());

        // START_ANESTESI
        $this->START_ANESTESI->EditAttrs["class"] = "form-control";
        $this->START_ANESTESI->EditCustomAttributes = "";
        $this->START_ANESTESI->EditValue = FormatDateTime($this->START_ANESTESI->CurrentValue, 8);
        $this->START_ANESTESI->PlaceHolder = RemoveHtml($this->START_ANESTESI->caption());

        // END_ANESTESI
        $this->END_ANESTESI->EditAttrs["class"] = "form-control";
        $this->END_ANESTESI->EditCustomAttributes = "";
        $this->END_ANESTESI->EditValue = FormatDateTime($this->END_ANESTESI->CurrentValue, 8);
        $this->END_ANESTESI->PlaceHolder = RemoveHtml($this->END_ANESTESI->caption());

        // RESULT_ID
        $this->RESULT_ID->EditAttrs["class"] = "form-control";
        $this->RESULT_ID->EditCustomAttributes = "";
        if (!$this->RESULT_ID->Raw) {
            $this->RESULT_ID->CurrentValue = HtmlDecode($this->RESULT_ID->CurrentValue);
        }
        $this->RESULT_ID->EditValue = $this->RESULT_ID->CurrentValue;
        $this->RESULT_ID->PlaceHolder = RemoveHtml($this->RESULT_ID->caption());

        // TARIF_ID
        $this->TARIF_ID->EditAttrs["class"] = "form-control";
        $this->TARIF_ID->EditCustomAttributes = "";
        if (!$this->TARIF_ID->Raw) {
            $this->TARIF_ID->CurrentValue = HtmlDecode($this->TARIF_ID->CurrentValue);
        }
        $this->TARIF_ID->EditValue = $this->TARIF_ID->CurrentValue;
        $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

        // DR_OPR
        $this->DR_OPR->EditAttrs["class"] = "form-control";
        $this->DR_OPR->EditCustomAttributes = "";
        if (!$this->DR_OPR->Raw) {
            $this->DR_OPR->CurrentValue = HtmlDecode($this->DR_OPR->CurrentValue);
        }
        $this->DR_OPR->EditValue = $this->DR_OPR->CurrentValue;
        $this->DR_OPR->PlaceHolder = RemoveHtml($this->DR_OPR->caption());

        // DR_OPR1
        $this->DR_OPR1->EditAttrs["class"] = "form-control";
        $this->DR_OPR1->EditCustomAttributes = "";
        if (!$this->DR_OPR1->Raw) {
            $this->DR_OPR1->CurrentValue = HtmlDecode($this->DR_OPR1->CurrentValue);
        }
        $this->DR_OPR1->EditValue = $this->DR_OPR1->CurrentValue;
        $this->DR_OPR1->PlaceHolder = RemoveHtml($this->DR_OPR1->caption());

        // DR_OPR2
        $this->DR_OPR2->EditAttrs["class"] = "form-control";
        $this->DR_OPR2->EditCustomAttributes = "";
        if (!$this->DR_OPR2->Raw) {
            $this->DR_OPR2->CurrentValue = HtmlDecode($this->DR_OPR2->CurrentValue);
        }
        $this->DR_OPR2->EditValue = $this->DR_OPR2->CurrentValue;
        $this->DR_OPR2->PlaceHolder = RemoveHtml($this->DR_OPR2->caption());

        // DR_ANES
        $this->DR_ANES->EditAttrs["class"] = "form-control";
        $this->DR_ANES->EditCustomAttributes = "";
        if (!$this->DR_ANES->Raw) {
            $this->DR_ANES->CurrentValue = HtmlDecode($this->DR_ANES->CurrentValue);
        }
        $this->DR_ANES->EditValue = $this->DR_ANES->CurrentValue;
        $this->DR_ANES->PlaceHolder = RemoveHtml($this->DR_ANES->caption());

        // PERAWAT
        $this->PERAWAT->EditAttrs["class"] = "form-control";
        $this->PERAWAT->EditCustomAttributes = "";
        if (!$this->PERAWAT->Raw) {
            $this->PERAWAT->CurrentValue = HtmlDecode($this->PERAWAT->CurrentValue);
        }
        $this->PERAWAT->EditValue = $this->PERAWAT->CurrentValue;
        $this->PERAWAT->PlaceHolder = RemoveHtml($this->PERAWAT->caption());

        // PENATA_ANES
        $this->PENATA_ANES->EditAttrs["class"] = "form-control";
        $this->PENATA_ANES->EditCustomAttributes = "";
        if (!$this->PENATA_ANES->Raw) {
            $this->PENATA_ANES->CurrentValue = HtmlDecode($this->PENATA_ANES->CurrentValue);
        }
        $this->PENATA_ANES->EditValue = $this->PENATA_ANES->CurrentValue;
        $this->PENATA_ANES->PlaceHolder = RemoveHtml($this->PENATA_ANES->caption());

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
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->VACTINATION_ID);
                    $doc->exportCaption($this->NO_REGISTRATION);
                    $doc->exportCaption($this->VISIT_ID);
                    $doc->exportCaption($this->BILL_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->VALIDATION);
                    $doc->exportCaption($this->TERLAYANI);
                    $doc->exportCaption($this->EMPLOYEE_ID);
                    $doc->exportCaption($this->PATIENT_CATEGORY_ID);
                    $doc->exportCaption($this->VACTINATION_DATE);
                    $doc->exportCaption($this->DESCRIPTION);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->MODIFIED_FROM);
                    $doc->exportCaption($this->THENAME);
                    $doc->exportCaption($this->THEADDRESS);
                    $doc->exportCaption($this->THEID);
                    $doc->exportCaption($this->ISRJ);
                    $doc->exportCaption($this->AGEYEAR);
                    $doc->exportCaption($this->AGEMONTH);
                    $doc->exportCaption($this->AGEDAY);
                    $doc->exportCaption($this->STATUS_PASIEN_ID);
                    $doc->exportCaption($this->GENDER);
                    $doc->exportCaption($this->DOCTOR);
                    $doc->exportCaption($this->KAL_ID);
                    $doc->exportCaption($this->CLASS_ROOM_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->ROOMS_ID);
                    $doc->exportCaption($this->OPERATION_TYPE);
                    $doc->exportCaption($this->ANESTESI_TYPE);
                    $doc->exportCaption($this->DIAGNOSA_PRA);
                    $doc->exportCaption($this->DIAGNOSA_PASCA);
                    $doc->exportCaption($this->START_OPERATION);
                    $doc->exportCaption($this->END_OPERATION);
                    $doc->exportCaption($this->START_ANESTESI);
                    $doc->exportCaption($this->END_ANESTESI);
                    $doc->exportCaption($this->RESULT_ID);
                    $doc->exportCaption($this->TARIF_ID);
                    $doc->exportCaption($this->DR_OPR);
                    $doc->exportCaption($this->DR_OPR1);
                    $doc->exportCaption($this->DR_OPR2);
                    $doc->exportCaption($this->DR_ANES);
                    $doc->exportCaption($this->PERAWAT);
                    $doc->exportCaption($this->PENATA_ANES);
                } else {
                    $doc->exportCaption($this->ORG_UNIT_CODE);
                    $doc->exportCaption($this->VACTINATION_ID);
                    $doc->exportCaption($this->NO_REGISTRATION);
                    $doc->exportCaption($this->VISIT_ID);
                    $doc->exportCaption($this->BILL_ID);
                    $doc->exportCaption($this->CLINIC_ID);
                    $doc->exportCaption($this->VALIDATION);
                    $doc->exportCaption($this->TERLAYANI);
                    $doc->exportCaption($this->EMPLOYEE_ID);
                    $doc->exportCaption($this->PATIENT_CATEGORY_ID);
                    $doc->exportCaption($this->VACTINATION_DATE);
                    $doc->exportCaption($this->DESCRIPTION);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->MODIFIED_FROM);
                    $doc->exportCaption($this->THENAME);
                    $doc->exportCaption($this->THEADDRESS);
                    $doc->exportCaption($this->THEID);
                    $doc->exportCaption($this->ISRJ);
                    $doc->exportCaption($this->AGEYEAR);
                    $doc->exportCaption($this->AGEMONTH);
                    $doc->exportCaption($this->AGEDAY);
                    $doc->exportCaption($this->STATUS_PASIEN_ID);
                    $doc->exportCaption($this->GENDER);
                    $doc->exportCaption($this->DOCTOR);
                    $doc->exportCaption($this->KAL_ID);
                    $doc->exportCaption($this->CLASS_ROOM_ID);
                    $doc->exportCaption($this->BED_ID);
                    $doc->exportCaption($this->KELUAR_ID);
                    $doc->exportCaption($this->ROOMS_ID);
                    $doc->exportCaption($this->OPERATION_TYPE);
                    $doc->exportCaption($this->ANESTESI_TYPE);
                    $doc->exportCaption($this->DIAGNOSA_PRA);
                    $doc->exportCaption($this->DIAGNOSA_PASCA);
                    $doc->exportCaption($this->START_OPERATION);
                    $doc->exportCaption($this->END_OPERATION);
                    $doc->exportCaption($this->START_ANESTESI);
                    $doc->exportCaption($this->END_ANESTESI);
                    $doc->exportCaption($this->RESULT_ID);
                    $doc->exportCaption($this->TARIF_ID);
                    $doc->exportCaption($this->DR_OPR);
                    $doc->exportCaption($this->DR_OPR1);
                    $doc->exportCaption($this->DR_OPR2);
                    $doc->exportCaption($this->DR_ANES);
                    $doc->exportCaption($this->PERAWAT);
                    $doc->exportCaption($this->PENATA_ANES);
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
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->VACTINATION_ID);
                        $doc->exportField($this->NO_REGISTRATION);
                        $doc->exportField($this->VISIT_ID);
                        $doc->exportField($this->BILL_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->VALIDATION);
                        $doc->exportField($this->TERLAYANI);
                        $doc->exportField($this->EMPLOYEE_ID);
                        $doc->exportField($this->PATIENT_CATEGORY_ID);
                        $doc->exportField($this->VACTINATION_DATE);
                        $doc->exportField($this->DESCRIPTION);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->MODIFIED_FROM);
                        $doc->exportField($this->THENAME);
                        $doc->exportField($this->THEADDRESS);
                        $doc->exportField($this->THEID);
                        $doc->exportField($this->ISRJ);
                        $doc->exportField($this->AGEYEAR);
                        $doc->exportField($this->AGEMONTH);
                        $doc->exportField($this->AGEDAY);
                        $doc->exportField($this->STATUS_PASIEN_ID);
                        $doc->exportField($this->GENDER);
                        $doc->exportField($this->DOCTOR);
                        $doc->exportField($this->KAL_ID);
                        $doc->exportField($this->CLASS_ROOM_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->ROOMS_ID);
                        $doc->exportField($this->OPERATION_TYPE);
                        $doc->exportField($this->ANESTESI_TYPE);
                        $doc->exportField($this->DIAGNOSA_PRA);
                        $doc->exportField($this->DIAGNOSA_PASCA);
                        $doc->exportField($this->START_OPERATION);
                        $doc->exportField($this->END_OPERATION);
                        $doc->exportField($this->START_ANESTESI);
                        $doc->exportField($this->END_ANESTESI);
                        $doc->exportField($this->RESULT_ID);
                        $doc->exportField($this->TARIF_ID);
                        $doc->exportField($this->DR_OPR);
                        $doc->exportField($this->DR_OPR1);
                        $doc->exportField($this->DR_OPR2);
                        $doc->exportField($this->DR_ANES);
                        $doc->exportField($this->PERAWAT);
                        $doc->exportField($this->PENATA_ANES);
                    } else {
                        $doc->exportField($this->ORG_UNIT_CODE);
                        $doc->exportField($this->VACTINATION_ID);
                        $doc->exportField($this->NO_REGISTRATION);
                        $doc->exportField($this->VISIT_ID);
                        $doc->exportField($this->BILL_ID);
                        $doc->exportField($this->CLINIC_ID);
                        $doc->exportField($this->VALIDATION);
                        $doc->exportField($this->TERLAYANI);
                        $doc->exportField($this->EMPLOYEE_ID);
                        $doc->exportField($this->PATIENT_CATEGORY_ID);
                        $doc->exportField($this->VACTINATION_DATE);
                        $doc->exportField($this->DESCRIPTION);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->MODIFIED_FROM);
                        $doc->exportField($this->THENAME);
                        $doc->exportField($this->THEADDRESS);
                        $doc->exportField($this->THEID);
                        $doc->exportField($this->ISRJ);
                        $doc->exportField($this->AGEYEAR);
                        $doc->exportField($this->AGEMONTH);
                        $doc->exportField($this->AGEDAY);
                        $doc->exportField($this->STATUS_PASIEN_ID);
                        $doc->exportField($this->GENDER);
                        $doc->exportField($this->DOCTOR);
                        $doc->exportField($this->KAL_ID);
                        $doc->exportField($this->CLASS_ROOM_ID);
                        $doc->exportField($this->BED_ID);
                        $doc->exportField($this->KELUAR_ID);
                        $doc->exportField($this->ROOMS_ID);
                        $doc->exportField($this->OPERATION_TYPE);
                        $doc->exportField($this->ANESTESI_TYPE);
                        $doc->exportField($this->DIAGNOSA_PRA);
                        $doc->exportField($this->DIAGNOSA_PASCA);
                        $doc->exportField($this->START_OPERATION);
                        $doc->exportField($this->END_OPERATION);
                        $doc->exportField($this->START_ANESTESI);
                        $doc->exportField($this->END_ANESTESI);
                        $doc->exportField($this->RESULT_ID);
                        $doc->exportField($this->TARIF_ID);
                        $doc->exportField($this->DR_OPR);
                        $doc->exportField($this->DR_OPR1);
                        $doc->exportField($this->DR_OPR2);
                        $doc->exportField($this->DR_ANES);
                        $doc->exportField($this->PERAWAT);
                        $doc->exportField($this->PENATA_ANES);
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
