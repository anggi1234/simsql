<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PasienVisitationAdd extends PasienVisitation
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PASIEN_VISITATION';

    // Page object name
    public $PageObjName = "PasienVisitationAdd";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (PASIEN_VISITATION)
        if (!isset($GLOBALS["PASIEN_VISITATION"]) || get_class($GLOBALS["PASIEN_VISITATION"]) == PROJECT_NAMESPACE . "PASIEN_VISITATION") {
            $GLOBALS["PASIEN_VISITATION"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PASIEN_VISITATION');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("PASIEN_VISITATION"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "PasienVisitationView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['IDXDAFTAR'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->IDXDAFTAR->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;
    public $DetailPages; // Detail pages object

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->VISIT_ID->Visible = false;
        $this->ORG_UNIT_CODE->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->DIANTAR_OLEH->setVisibility();
        $this->GENDER->setVisibility();
        $this->VISITOR_ADDRESS->setVisibility();
        $this->VISIT_DATE->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->EMPLOYEE_ID->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->RUJUKAN_ID->Visible = false;
        $this->ADDRESS_OF_RUJUKAN->Visible = false;
        $this->REASON_ID->Visible = false;
        $this->WAY_ID->Visible = false;
        $this->PATIENT_CATEGORY_ID->Visible = false;
        $this->BOOKED_DATE->Visible = false;
        $this->ISNEW->Visible = false;
        $this->FOLLOW_UP->Visible = false;
        $this->PLACE_TYPE->Visible = false;
        $this->CLINIC_ID_FROM->Visible = false;
        $this->CLASS_ROOM_ID->Visible = false;
        $this->BED_ID->Visible = false;
        $this->KELUAR_ID->setVisibility();
        $this->IN_DATE->setVisibility();
        $this->EXIT_DATE->Visible = false;
        $this->KODE_AGAMA->Visible = false;
        $this->DESCRIPTION->Visible = false;
        $this->MODIFIED_BY->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_FROM->setVisibility();
        $this->EMPLOYEE_ID_FROM->Visible = false;
        $this->RESPONSIBLE_ID->Visible = false;
        $this->RESPONSIBLE->Visible = false;
        $this->FAMILY_STATUS_ID->Visible = false;
        $this->TICKET_NO->Visible = false;
        $this->ISATTENDED->Visible = false;
        $this->PAYOR_ID->Visible = false;
        $this->CLASS_ID->Visible = false;
        $this->ISPERTARIF->Visible = false;
        $this->KAL_ID->Visible = false;
        $this->EMPLOYEE_INAP->Visible = false;
        $this->PASIEN_ID->Visible = false;
        $this->KARYAWAN->Visible = false;
        $this->ACCOUNT_ID->Visible = false;
        $this->CLASS_ID_PLAFOND->Visible = false;
        $this->BACKCHARGE->Visible = false;
        $this->COVERAGE_ID->Visible = false;
        $this->AGEYEAR->setVisibility();
        $this->AGEMONTH->Visible = false;
        $this->AGEDAY->Visible = false;
        $this->RECOMENDATION->Visible = false;
        $this->CONCLUSION->Visible = false;
        $this->SPECIMENNO->Visible = false;
        $this->LOCKED->Visible = false;
        $this->RM_OUT_DATE->Visible = false;
        $this->RM_IN_DATE->Visible = false;
        $this->LAMA_PINJAM->Visible = false;
        $this->STANDAR_RJ->Visible = false;
        $this->LENGKAP_RJ->Visible = false;
        $this->LENGKAP_RI->Visible = false;
        $this->RESEND_RM_DATE->Visible = false;
        $this->LENGKAP_RM1->Visible = false;
        $this->LENGKAP_RESUME->Visible = false;
        $this->LENGKAP_ANAMNESIS->Visible = false;
        $this->LENGKAP_CONSENT->Visible = false;
        $this->LENGKAP_ANESTESI->Visible = false;
        $this->LENGKAP_OP->Visible = false;
        $this->BACK_RM_DATE->Visible = false;
        $this->VALID_RM_DATE->Visible = false;
        $this->NO_SKP->Visible = false;
        $this->NO_SKPINAP->Visible = false;
        $this->DIAGNOSA_ID->Visible = false;
        $this->ticket_all->Visible = false;
        $this->tanggal_rujukan->Visible = false;
        $this->ISRJ->Visible = false;
        $this->NORUJUKAN->Visible = false;
        $this->PPKRUJUKAN->Visible = false;
        $this->LOKASILAKA->Visible = false;
        $this->KDPOLI->Visible = false;
        $this->EDIT_SEP->Visible = false;
        $this->DELETE_SEP->Visible = false;
        $this->DIAG_AWAL->Visible = false;
        $this->AKTIF->Visible = false;
        $this->BILL_INAP->Visible = false;
        $this->SEP_PRINTDATE->Visible = false;
        $this->MAPPING_SEP->Visible = false;
        $this->TRANS_ID->setVisibility();
        $this->KDPOLI_EKS->Visible = false;
        $this->COB->Visible = false;
        $this->PENJAMIN->Visible = false;
        $this->ASALRUJUKAN->Visible = false;
        $this->RESPONSEP->Visible = false;
        $this->APPROVAL_DESC->Visible = false;
        $this->APPROVAL_RESPONAJUKAN->Visible = false;
        $this->APPROVAL_RESPONAPPROV->Visible = false;
        $this->RESPONTGLPLG_DESC->Visible = false;
        $this->RESPONPOST_VKLAIM->Visible = false;
        $this->RESPONPUT_VKLAIM->Visible = false;
        $this->RESPONDEL_VKLAIM->Visible = false;
        $this->CALL_TIMES->Visible = false;
        $this->CALL_DATE->Visible = false;
        $this->CALL_DATES->Visible = false;
        $this->SERVED_DATE->Visible = false;
        $this->SERVED_INAP->Visible = false;
        $this->KDDPJP1->Visible = false;
        $this->KDDPJP->Visible = false;
        $this->IDXDAFTAR->Visible = false;
        $this->tgl_kontrol->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->NO_REGISTRATION);
        $this->setupLookupOptions($this->GENDER);
        $this->setupLookupOptions($this->CLINIC_ID);
        $this->setupLookupOptions($this->EMPLOYEE_ID);
        $this->setupLookupOptions($this->STATUS_PASIEN_ID);
        $this->setupLookupOptions($this->RUJUKAN_ID);
        $this->setupLookupOptions($this->REASON_ID);
        $this->setupLookupOptions($this->WAY_ID);
        $this->setupLookupOptions($this->PATIENT_CATEGORY_ID);
        $this->setupLookupOptions($this->CLINIC_ID_FROM);
        $this->setupLookupOptions($this->KELUAR_ID);
        $this->setupLookupOptions($this->KODE_AGAMA);
        $this->setupLookupOptions($this->RESPONSIBLE_ID);
        $this->setupLookupOptions($this->PAYOR_ID);
        $this->setupLookupOptions($this->CLASS_ID);
        $this->setupLookupOptions($this->KAL_ID);
        $this->setupLookupOptions($this->COVERAGE_ID);
        $this->setupLookupOptions($this->DIAGNOSA_ID);
        $this->setupLookupOptions($this->PPKRUJUKAN);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("IDXDAFTAR") ?? Route("IDXDAFTAR")) !== null) {
                $this->IDXDAFTAR->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PasienVisitationList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = "PasienVisitationList";
                    if (GetPageName($returnUrl) == "PasienVisitationList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "PasienVisitationView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->VISIT_ID->CurrentValue = null;
        $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
        $this->ORG_UNIT_CODE->CurrentValue = '1604031';
        $this->NO_REGISTRATION->CurrentValue = null;
        $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
        $this->DIANTAR_OLEH->CurrentValue = null;
        $this->DIANTAR_OLEH->OldValue = $this->DIANTAR_OLEH->CurrentValue;
        $this->GENDER->CurrentValue = null;
        $this->GENDER->OldValue = $this->GENDER->CurrentValue;
        $this->VISITOR_ADDRESS->CurrentValue = null;
        $this->VISITOR_ADDRESS->OldValue = $this->VISITOR_ADDRESS->CurrentValue;
        $this->VISIT_DATE->CurrentValue = CurrentDateTime();
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->EMPLOYEE_ID->CurrentValue = null;
        $this->EMPLOYEE_ID->OldValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->STATUS_PASIEN_ID->CurrentValue = "1";
        $this->RUJUKAN_ID->CurrentValue = null;
        $this->RUJUKAN_ID->OldValue = $this->RUJUKAN_ID->CurrentValue;
        $this->ADDRESS_OF_RUJUKAN->CurrentValue = null;
        $this->ADDRESS_OF_RUJUKAN->OldValue = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
        $this->REASON_ID->CurrentValue = "1";
        $this->WAY_ID->CurrentValue = "3";
        $this->PATIENT_CATEGORY_ID->CurrentValue = null;
        $this->PATIENT_CATEGORY_ID->OldValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
        $this->BOOKED_DATE->CurrentValue = null;
        $this->BOOKED_DATE->OldValue = $this->BOOKED_DATE->CurrentValue;
        $this->ISNEW->CurrentValue = null;
        $this->ISNEW->OldValue = $this->ISNEW->CurrentValue;
        $this->FOLLOW_UP->CurrentValue = null;
        $this->FOLLOW_UP->OldValue = $this->FOLLOW_UP->CurrentValue;
        $this->PLACE_TYPE->CurrentValue = null;
        $this->PLACE_TYPE->OldValue = $this->PLACE_TYPE->CurrentValue;
        $this->CLINIC_ID_FROM->CurrentValue = null;
        $this->CLINIC_ID_FROM->OldValue = $this->CLINIC_ID_FROM->CurrentValue;
        $this->CLASS_ROOM_ID->CurrentValue = null;
        $this->CLASS_ROOM_ID->OldValue = $this->CLASS_ROOM_ID->CurrentValue;
        $this->BED_ID->CurrentValue = null;
        $this->BED_ID->OldValue = $this->BED_ID->CurrentValue;
        $this->KELUAR_ID->CurrentValue = null;
        $this->KELUAR_ID->OldValue = $this->KELUAR_ID->CurrentValue;
        $this->IN_DATE->CurrentValue = CurrentDateTime();
        $this->EXIT_DATE->CurrentValue = CurrentDateTime();
        $this->KODE_AGAMA->CurrentValue = null;
        $this->KODE_AGAMA->OldValue = $this->KODE_AGAMA->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_FROM->CurrentValue = null;
        $this->MODIFIED_FROM->OldValue = $this->MODIFIED_FROM->CurrentValue;
        $this->EMPLOYEE_ID_FROM->CurrentValue = null;
        $this->EMPLOYEE_ID_FROM->OldValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $this->RESPONSIBLE_ID->CurrentValue = null;
        $this->RESPONSIBLE_ID->OldValue = $this->RESPONSIBLE_ID->CurrentValue;
        $this->RESPONSIBLE->CurrentValue = null;
        $this->RESPONSIBLE->OldValue = $this->RESPONSIBLE->CurrentValue;
        $this->FAMILY_STATUS_ID->CurrentValue = null;
        $this->FAMILY_STATUS_ID->OldValue = $this->FAMILY_STATUS_ID->CurrentValue;
        $this->TICKET_NO->CurrentValue = null;
        $this->TICKET_NO->OldValue = $this->TICKET_NO->CurrentValue;
        $this->ISATTENDED->CurrentValue = null;
        $this->ISATTENDED->OldValue = $this->ISATTENDED->CurrentValue;
        $this->PAYOR_ID->CurrentValue = null;
        $this->PAYOR_ID->OldValue = $this->PAYOR_ID->CurrentValue;
        $this->CLASS_ID->CurrentValue = null;
        $this->CLASS_ID->OldValue = $this->CLASS_ID->CurrentValue;
        $this->ISPERTARIF->CurrentValue = "1";
        $this->KAL_ID->CurrentValue = null;
        $this->KAL_ID->OldValue = $this->KAL_ID->CurrentValue;
        $this->EMPLOYEE_INAP->CurrentValue = null;
        $this->EMPLOYEE_INAP->OldValue = $this->EMPLOYEE_INAP->CurrentValue;
        $this->PASIEN_ID->CurrentValue = null;
        $this->PASIEN_ID->OldValue = $this->PASIEN_ID->CurrentValue;
        $this->KARYAWAN->CurrentValue = null;
        $this->KARYAWAN->OldValue = $this->KARYAWAN->CurrentValue;
        $this->ACCOUNT_ID->CurrentValue = null;
        $this->ACCOUNT_ID->OldValue = $this->ACCOUNT_ID->CurrentValue;
        $this->CLASS_ID_PLAFOND->CurrentValue = null;
        $this->CLASS_ID_PLAFOND->OldValue = $this->CLASS_ID_PLAFOND->CurrentValue;
        $this->BACKCHARGE->CurrentValue = null;
        $this->BACKCHARGE->OldValue = $this->BACKCHARGE->CurrentValue;
        $this->COVERAGE_ID->CurrentValue = null;
        $this->COVERAGE_ID->OldValue = $this->COVERAGE_ID->CurrentValue;
        $this->AGEYEAR->CurrentValue = null;
        $this->AGEYEAR->OldValue = $this->AGEYEAR->CurrentValue;
        $this->AGEMONTH->CurrentValue = null;
        $this->AGEMONTH->OldValue = $this->AGEMONTH->CurrentValue;
        $this->AGEDAY->CurrentValue = null;
        $this->AGEDAY->OldValue = $this->AGEDAY->CurrentValue;
        $this->RECOMENDATION->CurrentValue = null;
        $this->RECOMENDATION->OldValue = $this->RECOMENDATION->CurrentValue;
        $this->CONCLUSION->CurrentValue = null;
        $this->CONCLUSION->OldValue = $this->CONCLUSION->CurrentValue;
        $this->SPECIMENNO->CurrentValue = null;
        $this->SPECIMENNO->OldValue = $this->SPECIMENNO->CurrentValue;
        $this->LOCKED->CurrentValue = null;
        $this->LOCKED->OldValue = $this->LOCKED->CurrentValue;
        $this->RM_OUT_DATE->CurrentValue = null;
        $this->RM_OUT_DATE->OldValue = $this->RM_OUT_DATE->CurrentValue;
        $this->RM_IN_DATE->CurrentValue = null;
        $this->RM_IN_DATE->OldValue = $this->RM_IN_DATE->CurrentValue;
        $this->LAMA_PINJAM->CurrentValue = null;
        $this->LAMA_PINJAM->OldValue = $this->LAMA_PINJAM->CurrentValue;
        $this->STANDAR_RJ->CurrentValue = null;
        $this->STANDAR_RJ->OldValue = $this->STANDAR_RJ->CurrentValue;
        $this->LENGKAP_RJ->CurrentValue = null;
        $this->LENGKAP_RJ->OldValue = $this->LENGKAP_RJ->CurrentValue;
        $this->LENGKAP_RI->CurrentValue = null;
        $this->LENGKAP_RI->OldValue = $this->LENGKAP_RI->CurrentValue;
        $this->RESEND_RM_DATE->CurrentValue = null;
        $this->RESEND_RM_DATE->OldValue = $this->RESEND_RM_DATE->CurrentValue;
        $this->LENGKAP_RM1->CurrentValue = null;
        $this->LENGKAP_RM1->OldValue = $this->LENGKAP_RM1->CurrentValue;
        $this->LENGKAP_RESUME->CurrentValue = null;
        $this->LENGKAP_RESUME->OldValue = $this->LENGKAP_RESUME->CurrentValue;
        $this->LENGKAP_ANAMNESIS->CurrentValue = null;
        $this->LENGKAP_ANAMNESIS->OldValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
        $this->LENGKAP_CONSENT->CurrentValue = null;
        $this->LENGKAP_CONSENT->OldValue = $this->LENGKAP_CONSENT->CurrentValue;
        $this->LENGKAP_ANESTESI->CurrentValue = null;
        $this->LENGKAP_ANESTESI->OldValue = $this->LENGKAP_ANESTESI->CurrentValue;
        $this->LENGKAP_OP->CurrentValue = null;
        $this->LENGKAP_OP->OldValue = $this->LENGKAP_OP->CurrentValue;
        $this->BACK_RM_DATE->CurrentValue = null;
        $this->BACK_RM_DATE->OldValue = $this->BACK_RM_DATE->CurrentValue;
        $this->VALID_RM_DATE->CurrentValue = null;
        $this->VALID_RM_DATE->OldValue = $this->VALID_RM_DATE->CurrentValue;
        $this->NO_SKP->CurrentValue = null;
        $this->NO_SKP->OldValue = $this->NO_SKP->CurrentValue;
        $this->NO_SKPINAP->CurrentValue = null;
        $this->NO_SKPINAP->OldValue = $this->NO_SKPINAP->CurrentValue;
        $this->DIAGNOSA_ID->CurrentValue = null;
        $this->DIAGNOSA_ID->OldValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->ticket_all->CurrentValue = null;
        $this->ticket_all->OldValue = $this->ticket_all->CurrentValue;
        $this->tanggal_rujukan->CurrentValue = null;
        $this->tanggal_rujukan->OldValue = $this->tanggal_rujukan->CurrentValue;
        $this->ISRJ->CurrentValue = "1";
        $this->NORUJUKAN->CurrentValue = null;
        $this->NORUJUKAN->OldValue = $this->NORUJUKAN->CurrentValue;
        $this->PPKRUJUKAN->CurrentValue = null;
        $this->PPKRUJUKAN->OldValue = $this->PPKRUJUKAN->CurrentValue;
        $this->LOKASILAKA->CurrentValue = null;
        $this->LOKASILAKA->OldValue = $this->LOKASILAKA->CurrentValue;
        $this->KDPOLI->CurrentValue = null;
        $this->KDPOLI->OldValue = $this->KDPOLI->CurrentValue;
        $this->EDIT_SEP->CurrentValue = null;
        $this->EDIT_SEP->OldValue = $this->EDIT_SEP->CurrentValue;
        $this->DELETE_SEP->CurrentValue = null;
        $this->DELETE_SEP->OldValue = $this->DELETE_SEP->CurrentValue;
        $this->DIAG_AWAL->CurrentValue = null;
        $this->DIAG_AWAL->OldValue = $this->DIAG_AWAL->CurrentValue;
        $this->AKTIF->CurrentValue = null;
        $this->AKTIF->OldValue = $this->AKTIF->CurrentValue;
        $this->BILL_INAP->CurrentValue = null;
        $this->BILL_INAP->OldValue = $this->BILL_INAP->CurrentValue;
        $this->SEP_PRINTDATE->CurrentValue = null;
        $this->SEP_PRINTDATE->OldValue = $this->SEP_PRINTDATE->CurrentValue;
        $this->MAPPING_SEP->CurrentValue = null;
        $this->MAPPING_SEP->OldValue = $this->MAPPING_SEP->CurrentValue;
        $this->TRANS_ID->CurrentValue = null;
        $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
        $this->KDPOLI_EKS->CurrentValue = "0";
        $this->COB->CurrentValue = "0";
        $this->PENJAMIN->CurrentValue = null;
        $this->PENJAMIN->OldValue = $this->PENJAMIN->CurrentValue;
        $this->ASALRUJUKAN->CurrentValue = null;
        $this->ASALRUJUKAN->OldValue = $this->ASALRUJUKAN->CurrentValue;
        $this->RESPONSEP->CurrentValue = null;
        $this->RESPONSEP->OldValue = $this->RESPONSEP->CurrentValue;
        $this->APPROVAL_DESC->CurrentValue = null;
        $this->APPROVAL_DESC->OldValue = $this->APPROVAL_DESC->CurrentValue;
        $this->APPROVAL_RESPONAJUKAN->CurrentValue = null;
        $this->APPROVAL_RESPONAJUKAN->OldValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
        $this->APPROVAL_RESPONAPPROV->CurrentValue = null;
        $this->APPROVAL_RESPONAPPROV->OldValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
        $this->RESPONTGLPLG_DESC->CurrentValue = null;
        $this->RESPONTGLPLG_DESC->OldValue = $this->RESPONTGLPLG_DESC->CurrentValue;
        $this->RESPONPOST_VKLAIM->CurrentValue = null;
        $this->RESPONPOST_VKLAIM->OldValue = $this->RESPONPOST_VKLAIM->CurrentValue;
        $this->RESPONPUT_VKLAIM->CurrentValue = null;
        $this->RESPONPUT_VKLAIM->OldValue = $this->RESPONPUT_VKLAIM->CurrentValue;
        $this->RESPONDEL_VKLAIM->CurrentValue = null;
        $this->RESPONDEL_VKLAIM->OldValue = $this->RESPONDEL_VKLAIM->CurrentValue;
        $this->CALL_TIMES->CurrentValue = null;
        $this->CALL_TIMES->OldValue = $this->CALL_TIMES->CurrentValue;
        $this->CALL_DATE->CurrentValue = null;
        $this->CALL_DATE->OldValue = $this->CALL_DATE->CurrentValue;
        $this->CALL_DATES->CurrentValue = null;
        $this->CALL_DATES->OldValue = $this->CALL_DATES->CurrentValue;
        $this->SERVED_DATE->CurrentValue = null;
        $this->SERVED_DATE->OldValue = $this->SERVED_DATE->CurrentValue;
        $this->SERVED_INAP->CurrentValue = null;
        $this->SERVED_INAP->OldValue = $this->SERVED_INAP->CurrentValue;
        $this->KDDPJP1->CurrentValue = null;
        $this->KDDPJP1->OldValue = $this->KDDPJP1->CurrentValue;
        $this->KDDPJP->CurrentValue = null;
        $this->KDDPJP->OldValue = $this->KDDPJP->CurrentValue;
        $this->IDXDAFTAR->CurrentValue = null;
        $this->IDXDAFTAR->OldValue = $this->IDXDAFTAR->CurrentValue;
        $this->tgl_kontrol->CurrentValue = null;
        $this->tgl_kontrol->OldValue = $this->tgl_kontrol->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'ORG_UNIT_CODE' first before field var 'x_ORG_UNIT_CODE'
        $val = $CurrentForm->hasValue("ORG_UNIT_CODE") ? $CurrentForm->getValue("ORG_UNIT_CODE") : $CurrentForm->getValue("x_ORG_UNIT_CODE");
        if (!$this->ORG_UNIT_CODE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_UNIT_CODE->Visible = false; // Disable update for API request
            } else {
                $this->ORG_UNIT_CODE->setFormValue($val);
            }
        }

        // Check field name 'NO_REGISTRATION' first before field var 'x_NO_REGISTRATION'
        $val = $CurrentForm->hasValue("NO_REGISTRATION") ? $CurrentForm->getValue("NO_REGISTRATION") : $CurrentForm->getValue("x_NO_REGISTRATION");
        if (!$this->NO_REGISTRATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NO_REGISTRATION->Visible = false; // Disable update for API request
            } else {
                $this->NO_REGISTRATION->setFormValue($val);
            }
        }

        // Check field name 'DIANTAR_OLEH' first before field var 'x_DIANTAR_OLEH'
        $val = $CurrentForm->hasValue("DIANTAR_OLEH") ? $CurrentForm->getValue("DIANTAR_OLEH") : $CurrentForm->getValue("x_DIANTAR_OLEH");
        if (!$this->DIANTAR_OLEH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIANTAR_OLEH->Visible = false; // Disable update for API request
            } else {
                $this->DIANTAR_OLEH->setFormValue($val);
            }
        }

        // Check field name 'GENDER' first before field var 'x_GENDER'
        $val = $CurrentForm->hasValue("GENDER") ? $CurrentForm->getValue("GENDER") : $CurrentForm->getValue("x_GENDER");
        if (!$this->GENDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GENDER->Visible = false; // Disable update for API request
            } else {
                $this->GENDER->setFormValue($val);
            }
        }

        // Check field name 'VISITOR_ADDRESS' first before field var 'x_VISITOR_ADDRESS'
        $val = $CurrentForm->hasValue("VISITOR_ADDRESS") ? $CurrentForm->getValue("VISITOR_ADDRESS") : $CurrentForm->getValue("x_VISITOR_ADDRESS");
        if (!$this->VISITOR_ADDRESS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISITOR_ADDRESS->Visible = false; // Disable update for API request
            } else {
                $this->VISITOR_ADDRESS->setFormValue($val);
            }
        }

        // Check field name 'VISIT_DATE' first before field var 'x_VISIT_DATE'
        $val = $CurrentForm->hasValue("VISIT_DATE") ? $CurrentForm->getValue("VISIT_DATE") : $CurrentForm->getValue("x_VISIT_DATE");
        if (!$this->VISIT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_DATE->setFormValue($val);
            }
            $this->VISIT_DATE->CurrentValue = UnFormatDateTime($this->VISIT_DATE->CurrentValue, 11);
        }

        // Check field name 'CLINIC_ID' first before field var 'x_CLINIC_ID'
        $val = $CurrentForm->hasValue("CLINIC_ID") ? $CurrentForm->getValue("CLINIC_ID") : $CurrentForm->getValue("x_CLINIC_ID");
        if (!$this->CLINIC_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID->setFormValue($val);
            }
        }

        // Check field name 'EMPLOYEE_ID' first before field var 'x_EMPLOYEE_ID'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID") ? $CurrentForm->getValue("EMPLOYEE_ID") : $CurrentForm->getValue("x_EMPLOYEE_ID");
        if (!$this->EMPLOYEE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID->setFormValue($val);
            }
        }

        // Check field name 'STATUS_PASIEN_ID' first before field var 'x_STATUS_PASIEN_ID'
        $val = $CurrentForm->hasValue("STATUS_PASIEN_ID") ? $CurrentForm->getValue("STATUS_PASIEN_ID") : $CurrentForm->getValue("x_STATUS_PASIEN_ID");
        if (!$this->STATUS_PASIEN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STATUS_PASIEN_ID->Visible = false; // Disable update for API request
            } else {
                $this->STATUS_PASIEN_ID->setFormValue($val);
            }
        }

        // Check field name 'KELUAR_ID' first before field var 'x_KELUAR_ID'
        $val = $CurrentForm->hasValue("KELUAR_ID") ? $CurrentForm->getValue("KELUAR_ID") : $CurrentForm->getValue("x_KELUAR_ID");
        if (!$this->KELUAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KELUAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->KELUAR_ID->setFormValue($val);
            }
        }

        // Check field name 'IN_DATE' first before field var 'x_IN_DATE'
        $val = $CurrentForm->hasValue("IN_DATE") ? $CurrentForm->getValue("IN_DATE") : $CurrentForm->getValue("x_IN_DATE");
        if (!$this->IN_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IN_DATE->Visible = false; // Disable update for API request
            } else {
                $this->IN_DATE->setFormValue($val);
            }
            $this->IN_DATE->CurrentValue = UnFormatDateTime($this->IN_DATE->CurrentValue, 11);
        }

        // Check field name 'MODIFIED_BY' first before field var 'x_MODIFIED_BY'
        $val = $CurrentForm->hasValue("MODIFIED_BY") ? $CurrentForm->getValue("MODIFIED_BY") : $CurrentForm->getValue("x_MODIFIED_BY");
        if (!$this->MODIFIED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_BY->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_BY->setFormValue($val);
            }
        }

        // Check field name 'MODIFIED_DATE' first before field var 'x_MODIFIED_DATE'
        $val = $CurrentForm->hasValue("MODIFIED_DATE") ? $CurrentForm->getValue("MODIFIED_DATE") : $CurrentForm->getValue("x_MODIFIED_DATE");
        if (!$this->MODIFIED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_DATE->setFormValue($val);
            }
            $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
        }

        // Check field name 'MODIFIED_FROM' first before field var 'x_MODIFIED_FROM'
        $val = $CurrentForm->hasValue("MODIFIED_FROM") ? $CurrentForm->getValue("MODIFIED_FROM") : $CurrentForm->getValue("x_MODIFIED_FROM");
        if (!$this->MODIFIED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_FROM->setFormValue($val);
            }
        }

        // Check field name 'AGEYEAR' first before field var 'x_AGEYEAR'
        $val = $CurrentForm->hasValue("AGEYEAR") ? $CurrentForm->getValue("AGEYEAR") : $CurrentForm->getValue("x_AGEYEAR");
        if (!$this->AGEYEAR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEYEAR->Visible = false; // Disable update for API request
            } else {
                $this->AGEYEAR->setFormValue($val);
            }
        }

        // Check field name 'TRANS_ID' first before field var 'x_TRANS_ID'
        $val = $CurrentForm->hasValue("TRANS_ID") ? $CurrentForm->getValue("TRANS_ID") : $CurrentForm->getValue("x_TRANS_ID");
        if (!$this->TRANS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TRANS_ID->Visible = false; // Disable update for API request
            } else {
                $this->TRANS_ID->setFormValue($val);
            }
        }

        // Check field name 'IDXDAFTAR' first before field var 'x_IDXDAFTAR'
        $val = $CurrentForm->hasValue("IDXDAFTAR") ? $CurrentForm->getValue("IDXDAFTAR") : $CurrentForm->getValue("x_IDXDAFTAR");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->DIANTAR_OLEH->CurrentValue = $this->DIANTAR_OLEH->FormValue;
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->VISITOR_ADDRESS->CurrentValue = $this->VISITOR_ADDRESS->FormValue;
        $this->VISIT_DATE->CurrentValue = $this->VISIT_DATE->FormValue;
        $this->VISIT_DATE->CurrentValue = UnFormatDateTime($this->VISIT_DATE->CurrentValue, 11);
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->EMPLOYEE_ID->CurrentValue = $this->EMPLOYEE_ID->FormValue;
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->KELUAR_ID->CurrentValue = $this->KELUAR_ID->FormValue;
        $this->IN_DATE->CurrentValue = $this->IN_DATE->FormValue;
        $this->IN_DATE->CurrentValue = UnFormatDateTime($this->IN_DATE->CurrentValue, 11);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
        $this->MODIFIED_FROM->CurrentValue = $this->MODIFIED_FROM->FormValue;
        $this->AGEYEAR->CurrentValue = $this->AGEYEAR->FormValue;
        $this->TRANS_ID->CurrentValue = $this->TRANS_ID->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->DIANTAR_OLEH->setDbValue($row['DIANTAR_OLEH']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->VISITOR_ADDRESS->setDbValue($row['VISITOR_ADDRESS']);
        $this->VISIT_DATE->setDbValue($row['VISIT_DATE']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->RUJUKAN_ID->setDbValue($row['RUJUKAN_ID']);
        $this->ADDRESS_OF_RUJUKAN->setDbValue($row['ADDRESS_OF_RUJUKAN']);
        $this->REASON_ID->setDbValue($row['REASON_ID']);
        $this->WAY_ID->setDbValue($row['WAY_ID']);
        $this->PATIENT_CATEGORY_ID->setDbValue($row['PATIENT_CATEGORY_ID']);
        $this->BOOKED_DATE->setDbValue($row['BOOKED_DATE']);
        $this->ISNEW->setDbValue($row['ISNEW']);
        $this->FOLLOW_UP->setDbValue($row['FOLLOW_UP']);
        $this->PLACE_TYPE->setDbValue($row['PLACE_TYPE']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->IN_DATE->setDbValue($row['IN_DATE']);
        $this->EXIT_DATE->setDbValue($row['EXIT_DATE']);
        $this->KODE_AGAMA->setDbValue($row['KODE_AGAMA']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->EMPLOYEE_ID_FROM->setDbValue($row['EMPLOYEE_ID_FROM']);
        $this->RESPONSIBLE_ID->setDbValue($row['RESPONSIBLE_ID']);
        $this->RESPONSIBLE->setDbValue($row['RESPONSIBLE']);
        $this->FAMILY_STATUS_ID->setDbValue($row['FAMILY_STATUS_ID']);
        $this->TICKET_NO->setDbValue($row['TICKET_NO']);
        $this->ISATTENDED->setDbValue($row['ISATTENDED']);
        $this->PAYOR_ID->setDbValue($row['PAYOR_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->ISPERTARIF->setDbValue($row['ISPERTARIF']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->EMPLOYEE_INAP->setDbValue($row['EMPLOYEE_INAP']);
        $this->PASIEN_ID->setDbValue($row['PASIEN_ID']);
        $this->KARYAWAN->setDbValue($row['KARYAWAN']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->CLASS_ID_PLAFOND->setDbValue($row['CLASS_ID_PLAFOND']);
        $this->BACKCHARGE->setDbValue($row['BACKCHARGE']);
        $this->COVERAGE_ID->setDbValue($row['COVERAGE_ID']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->RECOMENDATION->setDbValue($row['RECOMENDATION']);
        $this->CONCLUSION->setDbValue($row['CONCLUSION']);
        $this->SPECIMENNO->setDbValue($row['SPECIMENNO']);
        $this->LOCKED->setDbValue($row['LOCKED']);
        $this->RM_OUT_DATE->setDbValue($row['RM_OUT_DATE']);
        $this->RM_IN_DATE->setDbValue($row['RM_IN_DATE']);
        $this->LAMA_PINJAM->setDbValue($row['LAMA_PINJAM']);
        $this->STANDAR_RJ->setDbValue($row['STANDAR_RJ']);
        $this->LENGKAP_RJ->setDbValue($row['LENGKAP_RJ']);
        $this->LENGKAP_RI->setDbValue($row['LENGKAP_RI']);
        $this->RESEND_RM_DATE->setDbValue($row['RESEND_RM_DATE']);
        $this->LENGKAP_RM1->setDbValue($row['LENGKAP_RM1']);
        $this->LENGKAP_RESUME->setDbValue($row['LENGKAP_RESUME']);
        $this->LENGKAP_ANAMNESIS->setDbValue($row['LENGKAP_ANAMNESIS']);
        $this->LENGKAP_CONSENT->setDbValue($row['LENGKAP_CONSENT']);
        $this->LENGKAP_ANESTESI->setDbValue($row['LENGKAP_ANESTESI']);
        $this->LENGKAP_OP->setDbValue($row['LENGKAP_OP']);
        $this->BACK_RM_DATE->setDbValue($row['BACK_RM_DATE']);
        $this->VALID_RM_DATE->setDbValue($row['VALID_RM_DATE']);
        $this->NO_SKP->setDbValue($row['NO_SKP']);
        $this->NO_SKPINAP->setDbValue($row['NO_SKPINAP']);
        $this->DIAGNOSA_ID->setDbValue($row['DIAGNOSA_ID']);
        $this->ticket_all->setDbValue($row['ticket_all']);
        $this->tanggal_rujukan->setDbValue($row['tanggal_rujukan']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->NORUJUKAN->setDbValue($row['NORUJUKAN']);
        $this->PPKRUJUKAN->setDbValue($row['PPKRUJUKAN']);
        $this->LOKASILAKA->setDbValue($row['LOKASILAKA']);
        $this->KDPOLI->setDbValue($row['KDPOLI']);
        $this->EDIT_SEP->setDbValue($row['EDIT_SEP']);
        $this->DELETE_SEP->setDbValue($row['DELETE_SEP']);
        $this->DIAG_AWAL->setDbValue($row['DIAG_AWAL']);
        $this->AKTIF->setDbValue($row['AKTIF']);
        $this->BILL_INAP->setDbValue($row['BILL_INAP']);
        $this->SEP_PRINTDATE->setDbValue($row['SEP_PRINTDATE']);
        $this->MAPPING_SEP->setDbValue($row['MAPPING_SEP']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->KDPOLI_EKS->setDbValue($row['KDPOLI_EKS']);
        $this->COB->setDbValue($row['COB']);
        $this->PENJAMIN->setDbValue($row['PENJAMIN']);
        $this->ASALRUJUKAN->setDbValue($row['ASALRUJUKAN']);
        $this->RESPONSEP->setDbValue($row['RESPONSEP']);
        $this->APPROVAL_DESC->setDbValue($row['APPROVAL_DESC']);
        $this->APPROVAL_RESPONAJUKAN->setDbValue($row['APPROVAL_RESPONAJUKAN']);
        $this->APPROVAL_RESPONAPPROV->setDbValue($row['APPROVAL_RESPONAPPROV']);
        $this->RESPONTGLPLG_DESC->setDbValue($row['RESPONTGLPLG_DESC']);
        $this->RESPONPOST_VKLAIM->setDbValue($row['RESPONPOST_VKLAIM']);
        $this->RESPONPUT_VKLAIM->setDbValue($row['RESPONPUT_VKLAIM']);
        $this->RESPONDEL_VKLAIM->setDbValue($row['RESPONDEL_VKLAIM']);
        $this->CALL_TIMES->setDbValue($row['CALL_TIMES']);
        $this->CALL_DATE->setDbValue($row['CALL_DATE']);
        $this->CALL_DATES->setDbValue($row['CALL_DATES']);
        $this->SERVED_DATE->setDbValue($row['SERVED_DATE']);
        $this->SERVED_INAP->setDbValue($row['SERVED_INAP']);
        $this->KDDPJP1->setDbValue($row['KDDPJP1']);
        $this->KDDPJP->setDbValue($row['KDDPJP']);
        $this->IDXDAFTAR->setDbValue($row['IDXDAFTAR']);
        $this->tgl_kontrol->setDbValue($row['tgl_kontrol']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['VISIT_ID'] = $this->VISIT_ID->CurrentValue;
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['NO_REGISTRATION'] = $this->NO_REGISTRATION->CurrentValue;
        $row['DIANTAR_OLEH'] = $this->DIANTAR_OLEH->CurrentValue;
        $row['GENDER'] = $this->GENDER->CurrentValue;
        $row['VISITOR_ADDRESS'] = $this->VISITOR_ADDRESS->CurrentValue;
        $row['VISIT_DATE'] = $this->VISIT_DATE->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['EMPLOYEE_ID'] = $this->EMPLOYEE_ID->CurrentValue;
        $row['STATUS_PASIEN_ID'] = $this->STATUS_PASIEN_ID->CurrentValue;
        $row['RUJUKAN_ID'] = $this->RUJUKAN_ID->CurrentValue;
        $row['ADDRESS_OF_RUJUKAN'] = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
        $row['REASON_ID'] = $this->REASON_ID->CurrentValue;
        $row['WAY_ID'] = $this->WAY_ID->CurrentValue;
        $row['PATIENT_CATEGORY_ID'] = $this->PATIENT_CATEGORY_ID->CurrentValue;
        $row['BOOKED_DATE'] = $this->BOOKED_DATE->CurrentValue;
        $row['ISNEW'] = $this->ISNEW->CurrentValue;
        $row['FOLLOW_UP'] = $this->FOLLOW_UP->CurrentValue;
        $row['PLACE_TYPE'] = $this->PLACE_TYPE->CurrentValue;
        $row['CLINIC_ID_FROM'] = $this->CLINIC_ID_FROM->CurrentValue;
        $row['CLASS_ROOM_ID'] = $this->CLASS_ROOM_ID->CurrentValue;
        $row['BED_ID'] = $this->BED_ID->CurrentValue;
        $row['KELUAR_ID'] = $this->KELUAR_ID->CurrentValue;
        $row['IN_DATE'] = $this->IN_DATE->CurrentValue;
        $row['EXIT_DATE'] = $this->EXIT_DATE->CurrentValue;
        $row['KODE_AGAMA'] = $this->KODE_AGAMA->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_FROM'] = $this->MODIFIED_FROM->CurrentValue;
        $row['EMPLOYEE_ID_FROM'] = $this->EMPLOYEE_ID_FROM->CurrentValue;
        $row['RESPONSIBLE_ID'] = $this->RESPONSIBLE_ID->CurrentValue;
        $row['RESPONSIBLE'] = $this->RESPONSIBLE->CurrentValue;
        $row['FAMILY_STATUS_ID'] = $this->FAMILY_STATUS_ID->CurrentValue;
        $row['TICKET_NO'] = $this->TICKET_NO->CurrentValue;
        $row['ISATTENDED'] = $this->ISATTENDED->CurrentValue;
        $row['PAYOR_ID'] = $this->PAYOR_ID->CurrentValue;
        $row['CLASS_ID'] = $this->CLASS_ID->CurrentValue;
        $row['ISPERTARIF'] = $this->ISPERTARIF->CurrentValue;
        $row['KAL_ID'] = $this->KAL_ID->CurrentValue;
        $row['EMPLOYEE_INAP'] = $this->EMPLOYEE_INAP->CurrentValue;
        $row['PASIEN_ID'] = $this->PASIEN_ID->CurrentValue;
        $row['KARYAWAN'] = $this->KARYAWAN->CurrentValue;
        $row['ACCOUNT_ID'] = $this->ACCOUNT_ID->CurrentValue;
        $row['CLASS_ID_PLAFOND'] = $this->CLASS_ID_PLAFOND->CurrentValue;
        $row['BACKCHARGE'] = $this->BACKCHARGE->CurrentValue;
        $row['COVERAGE_ID'] = $this->COVERAGE_ID->CurrentValue;
        $row['AGEYEAR'] = $this->AGEYEAR->CurrentValue;
        $row['AGEMONTH'] = $this->AGEMONTH->CurrentValue;
        $row['AGEDAY'] = $this->AGEDAY->CurrentValue;
        $row['RECOMENDATION'] = $this->RECOMENDATION->CurrentValue;
        $row['CONCLUSION'] = $this->CONCLUSION->CurrentValue;
        $row['SPECIMENNO'] = $this->SPECIMENNO->CurrentValue;
        $row['LOCKED'] = $this->LOCKED->CurrentValue;
        $row['RM_OUT_DATE'] = $this->RM_OUT_DATE->CurrentValue;
        $row['RM_IN_DATE'] = $this->RM_IN_DATE->CurrentValue;
        $row['LAMA_PINJAM'] = $this->LAMA_PINJAM->CurrentValue;
        $row['STANDAR_RJ'] = $this->STANDAR_RJ->CurrentValue;
        $row['LENGKAP_RJ'] = $this->LENGKAP_RJ->CurrentValue;
        $row['LENGKAP_RI'] = $this->LENGKAP_RI->CurrentValue;
        $row['RESEND_RM_DATE'] = $this->RESEND_RM_DATE->CurrentValue;
        $row['LENGKAP_RM1'] = $this->LENGKAP_RM1->CurrentValue;
        $row['LENGKAP_RESUME'] = $this->LENGKAP_RESUME->CurrentValue;
        $row['LENGKAP_ANAMNESIS'] = $this->LENGKAP_ANAMNESIS->CurrentValue;
        $row['LENGKAP_CONSENT'] = $this->LENGKAP_CONSENT->CurrentValue;
        $row['LENGKAP_ANESTESI'] = $this->LENGKAP_ANESTESI->CurrentValue;
        $row['LENGKAP_OP'] = $this->LENGKAP_OP->CurrentValue;
        $row['BACK_RM_DATE'] = $this->BACK_RM_DATE->CurrentValue;
        $row['VALID_RM_DATE'] = $this->VALID_RM_DATE->CurrentValue;
        $row['NO_SKP'] = $this->NO_SKP->CurrentValue;
        $row['NO_SKPINAP'] = $this->NO_SKPINAP->CurrentValue;
        $row['DIAGNOSA_ID'] = $this->DIAGNOSA_ID->CurrentValue;
        $row['ticket_all'] = $this->ticket_all->CurrentValue;
        $row['tanggal_rujukan'] = $this->tanggal_rujukan->CurrentValue;
        $row['ISRJ'] = $this->ISRJ->CurrentValue;
        $row['NORUJUKAN'] = $this->NORUJUKAN->CurrentValue;
        $row['PPKRUJUKAN'] = $this->PPKRUJUKAN->CurrentValue;
        $row['LOKASILAKA'] = $this->LOKASILAKA->CurrentValue;
        $row['KDPOLI'] = $this->KDPOLI->CurrentValue;
        $row['EDIT_SEP'] = $this->EDIT_SEP->CurrentValue;
        $row['DELETE_SEP'] = $this->DELETE_SEP->CurrentValue;
        $row['DIAG_AWAL'] = $this->DIAG_AWAL->CurrentValue;
        $row['AKTIF'] = $this->AKTIF->CurrentValue;
        $row['BILL_INAP'] = $this->BILL_INAP->CurrentValue;
        $row['SEP_PRINTDATE'] = $this->SEP_PRINTDATE->CurrentValue;
        $row['MAPPING_SEP'] = $this->MAPPING_SEP->CurrentValue;
        $row['TRANS_ID'] = $this->TRANS_ID->CurrentValue;
        $row['KDPOLI_EKS'] = $this->KDPOLI_EKS->CurrentValue;
        $row['COB'] = $this->COB->CurrentValue;
        $row['PENJAMIN'] = $this->PENJAMIN->CurrentValue;
        $row['ASALRUJUKAN'] = $this->ASALRUJUKAN->CurrentValue;
        $row['RESPONSEP'] = $this->RESPONSEP->CurrentValue;
        $row['APPROVAL_DESC'] = $this->APPROVAL_DESC->CurrentValue;
        $row['APPROVAL_RESPONAJUKAN'] = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
        $row['APPROVAL_RESPONAPPROV'] = $this->APPROVAL_RESPONAPPROV->CurrentValue;
        $row['RESPONTGLPLG_DESC'] = $this->RESPONTGLPLG_DESC->CurrentValue;
        $row['RESPONPOST_VKLAIM'] = $this->RESPONPOST_VKLAIM->CurrentValue;
        $row['RESPONPUT_VKLAIM'] = $this->RESPONPUT_VKLAIM->CurrentValue;
        $row['RESPONDEL_VKLAIM'] = $this->RESPONDEL_VKLAIM->CurrentValue;
        $row['CALL_TIMES'] = $this->CALL_TIMES->CurrentValue;
        $row['CALL_DATE'] = $this->CALL_DATE->CurrentValue;
        $row['CALL_DATES'] = $this->CALL_DATES->CurrentValue;
        $row['SERVED_DATE'] = $this->SERVED_DATE->CurrentValue;
        $row['SERVED_INAP'] = $this->SERVED_INAP->CurrentValue;
        $row['KDDPJP1'] = $this->KDDPJP1->CurrentValue;
        $row['KDDPJP'] = $this->KDDPJP->CurrentValue;
        $row['IDXDAFTAR'] = $this->IDXDAFTAR->CurrentValue;
        $row['tgl_kontrol'] = $this->tgl_kontrol->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // VISIT_ID

        // ORG_UNIT_CODE

        // NO_REGISTRATION

        // DIANTAR_OLEH

        // GENDER

        // VISITOR_ADDRESS

        // VISIT_DATE

        // CLINIC_ID

        // EMPLOYEE_ID

        // STATUS_PASIEN_ID

        // RUJUKAN_ID

        // ADDRESS_OF_RUJUKAN

        // REASON_ID

        // WAY_ID

        // PATIENT_CATEGORY_ID

        // BOOKED_DATE

        // ISNEW

        // FOLLOW_UP

        // PLACE_TYPE

        // CLINIC_ID_FROM

        // CLASS_ROOM_ID

        // BED_ID

        // KELUAR_ID

        // IN_DATE

        // EXIT_DATE

        // KODE_AGAMA

        // DESCRIPTION

        // MODIFIED_BY

        // MODIFIED_DATE

        // MODIFIED_FROM

        // EMPLOYEE_ID_FROM

        // RESPONSIBLE_ID

        // RESPONSIBLE

        // FAMILY_STATUS_ID

        // TICKET_NO

        // ISATTENDED

        // PAYOR_ID

        // CLASS_ID

        // ISPERTARIF

        // KAL_ID

        // EMPLOYEE_INAP

        // PASIEN_ID

        // KARYAWAN

        // ACCOUNT_ID

        // CLASS_ID_PLAFOND

        // BACKCHARGE

        // COVERAGE_ID

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // RECOMENDATION

        // CONCLUSION

        // SPECIMENNO

        // LOCKED

        // RM_OUT_DATE

        // RM_IN_DATE

        // LAMA_PINJAM

        // STANDAR_RJ

        // LENGKAP_RJ

        // LENGKAP_RI

        // RESEND_RM_DATE

        // LENGKAP_RM1

        // LENGKAP_RESUME

        // LENGKAP_ANAMNESIS

        // LENGKAP_CONSENT

        // LENGKAP_ANESTESI

        // LENGKAP_OP

        // BACK_RM_DATE

        // VALID_RM_DATE

        // NO_SKP

        // NO_SKPINAP

        // DIAGNOSA_ID

        // ticket_all

        // tanggal_rujukan

        // ISRJ

        // NORUJUKAN

        // PPKRUJUKAN

        // LOKASILAKA

        // KDPOLI

        // EDIT_SEP

        // DELETE_SEP

        // DIAG_AWAL

        // AKTIF

        // BILL_INAP

        // SEP_PRINTDATE

        // MAPPING_SEP

        // TRANS_ID

        // KDPOLI_EKS

        // COB

        // PENJAMIN

        // ASALRUJUKAN

        // RESPONSEP

        // APPROVAL_DESC

        // APPROVAL_RESPONAJUKAN

        // APPROVAL_RESPONAPPROV

        // RESPONTGLPLG_DESC

        // RESPONPOST_VKLAIM

        // RESPONPUT_VKLAIM

        // RESPONDEL_VKLAIM

        // CALL_TIMES

        // CALL_DATE

        // CALL_DATES

        // SERVED_DATE

        // SERVED_INAP

        // KDDPJP1

        // KDDPJP

        // IDXDAFTAR

        // tgl_kontrol
        if ($this->RowType == ROWTYPE_VIEW) {
            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $curVal = trim(strval($this->NO_REGISTRATION->CurrentValue));
            if ($curVal != "") {
                $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
                if ($this->NO_REGISTRATION->ViewValue === null) { // Lookup from database
                    $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->displayValue($arwrk);
                    } else {
                        $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
                    }
                }
            } else {
                $this->NO_REGISTRATION->ViewValue = null;
            }
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->ViewValue = $this->DIANTAR_OLEH->CurrentValue;
            $this->DIANTAR_OLEH->ViewCustomAttributes = "";

            // GENDER
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->ViewValue = $this->GENDER->lookupCacheOption($curVal);
                if ($this->GENDER->ViewValue === null) { // Lookup from database
                    $filterWrk = "[GENDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[GENDER] = 1 OR [GENDER] = 2";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->GENDER->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->GENDER->Lookup->renderViewRow($rswrk[0]);
                        $this->GENDER->ViewValue = $this->GENDER->displayValue($arwrk);
                    } else {
                        $this->GENDER->ViewValue = $this->GENDER->CurrentValue;
                    }
                }
            } else {
                $this->GENDER->ViewValue = null;
            }
            $this->GENDER->ViewCustomAttributes = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->ViewValue = $this->VISITOR_ADDRESS->CurrentValue;
            $this->VISITOR_ADDRESS->ViewCustomAttributes = "";

            // VISIT_DATE
            $this->VISIT_DATE->ViewValue = $this->VISIT_DATE->CurrentValue;
            $this->VISIT_DATE->ViewValue = FormatDateTime($this->VISIT_DATE->ViewValue, 11);
            $this->VISIT_DATE->ViewCustomAttributes = "";

            // CLINIC_ID
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 1 OR [STYPE_ID] = 2 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // EMPLOYEE_ID
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
                if ($this->EMPLOYEE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[OBJECT_CATEGORY_ID]= 20";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // STATUS_PASIEN_ID
            $curVal = trim(strval($this->STATUS_PASIEN_ID->CurrentValue));
            if ($curVal != "") {
                $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->lookupCacheOption($curVal);
                if ($this->STATUS_PASIEN_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[STATUS_PASIEN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "[ISACTIVE] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->STATUS_PASIEN_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->STATUS_PASIEN_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->displayValue($arwrk);
                    } else {
                        $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
                    }
                }
            } else {
                $this->STATUS_PASIEN_ID->ViewValue = null;
            }
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // RUJUKAN_ID
            $curVal = trim(strval($this->RUJUKAN_ID->CurrentValue));
            if ($curVal != "") {
                $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->lookupCacheOption($curVal);
                if ($this->RUJUKAN_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[RUJUKAN_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RUJUKAN_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RUJUKAN_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->displayValue($arwrk);
                    } else {
                        $this->RUJUKAN_ID->ViewValue = $this->RUJUKAN_ID->CurrentValue;
                    }
                }
            } else {
                $this->RUJUKAN_ID->ViewValue = null;
            }
            $this->RUJUKAN_ID->ViewCustomAttributes = "";

            // ADDRESS_OF_RUJUKAN
            $this->ADDRESS_OF_RUJUKAN->ViewValue = $this->ADDRESS_OF_RUJUKAN->CurrentValue;
            $this->ADDRESS_OF_RUJUKAN->ViewCustomAttributes = "";

            // REASON_ID
            $curVal = trim(strval($this->REASON_ID->CurrentValue));
            if ($curVal != "") {
                $this->REASON_ID->ViewValue = $this->REASON_ID->lookupCacheOption($curVal);
                if ($this->REASON_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[REASON_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->REASON_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->REASON_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->REASON_ID->ViewValue = $this->REASON_ID->displayValue($arwrk);
                    } else {
                        $this->REASON_ID->ViewValue = $this->REASON_ID->CurrentValue;
                    }
                }
            } else {
                $this->REASON_ID->ViewValue = null;
            }
            $this->REASON_ID->ViewCustomAttributes = "";

            // WAY_ID
            $curVal = trim(strval($this->WAY_ID->CurrentValue));
            if ($curVal != "") {
                $this->WAY_ID->ViewValue = $this->WAY_ID->lookupCacheOption($curVal);
                if ($this->WAY_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[WAY_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->WAY_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->WAY_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->WAY_ID->ViewValue = $this->WAY_ID->displayValue($arwrk);
                    } else {
                        $this->WAY_ID->ViewValue = $this->WAY_ID->CurrentValue;
                    }
                }
            } else {
                $this->WAY_ID->ViewValue = null;
            }
            $this->WAY_ID->ViewCustomAttributes = "";

            // PATIENT_CATEGORY_ID
            $curVal = trim(strval($this->PATIENT_CATEGORY_ID->CurrentValue));
            if ($curVal != "") {
                $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->lookupCacheOption($curVal);
                if ($this->PATIENT_CATEGORY_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[PATIENT_CATEGORY_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->PATIENT_CATEGORY_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PATIENT_CATEGORY_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->displayValue($arwrk);
                    } else {
                        $this->PATIENT_CATEGORY_ID->ViewValue = $this->PATIENT_CATEGORY_ID->CurrentValue;
                    }
                }
            } else {
                $this->PATIENT_CATEGORY_ID->ViewValue = null;
            }
            $this->PATIENT_CATEGORY_ID->ViewCustomAttributes = "";

            // BOOKED_DATE
            $this->BOOKED_DATE->ViewValue = $this->BOOKED_DATE->CurrentValue;
            $this->BOOKED_DATE->ViewValue = FormatDateTime($this->BOOKED_DATE->ViewValue, 11);
            $this->BOOKED_DATE->ViewCustomAttributes = "";

            // ISNEW
            if (strval($this->ISNEW->CurrentValue) != "") {
                $this->ISNEW->ViewValue = $this->ISNEW->optionCaption($this->ISNEW->CurrentValue);
            } else {
                $this->ISNEW->ViewValue = null;
            }
            $this->ISNEW->ViewCustomAttributes = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->CurrentValue;
            $this->FOLLOW_UP->ViewValue = FormatNumber($this->FOLLOW_UP->ViewValue, 0, -2, -2, -2);
            $this->FOLLOW_UP->ViewCustomAttributes = "";

            // PLACE_TYPE
            $this->PLACE_TYPE->ViewValue = $this->PLACE_TYPE->CurrentValue;
            $this->PLACE_TYPE->ViewValue = FormatNumber($this->PLACE_TYPE->ViewValue, 0, -2, -2, -2);
            $this->PLACE_TYPE->ViewCustomAttributes = "";

            // CLINIC_ID_FROM
            $curVal = trim(strval($this->CLINIC_ID_FROM->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->lookupCacheOption($curVal);
                if ($this->CLINIC_ID_FROM->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->CLINIC_ID_FROM->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->ViewValue = $this->CLASS_ROOM_ID->CurrentValue;
            $this->CLASS_ROOM_ID->ViewCustomAttributes = "";

            // BED_ID
            $this->BED_ID->ViewValue = $this->BED_ID->CurrentValue;
            $this->BED_ID->ViewValue = FormatNumber($this->BED_ID->ViewValue, 0, -2, -2, -2);
            $this->BED_ID->ViewCustomAttributes = "";

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

            // IN_DATE
            $this->IN_DATE->ViewValue = $this->IN_DATE->CurrentValue;
            $this->IN_DATE->ViewValue = FormatDateTime($this->IN_DATE->ViewValue, 11);
            $this->IN_DATE->ViewCustomAttributes = "";

            // EXIT_DATE
            $this->EXIT_DATE->ViewValue = $this->EXIT_DATE->CurrentValue;
            $this->EXIT_DATE->ViewValue = FormatDateTime($this->EXIT_DATE->ViewValue, 11);
            $this->EXIT_DATE->ViewCustomAttributes = "";

            // KODE_AGAMA
            $curVal = trim(strval($this->KODE_AGAMA->CurrentValue));
            if ($curVal != "") {
                $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->lookupCacheOption($curVal);
                if ($this->KODE_AGAMA->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KODE_AGAMA]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->KODE_AGAMA->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KODE_AGAMA->Lookup->renderViewRow($rswrk[0]);
                        $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->displayValue($arwrk);
                    } else {
                        $this->KODE_AGAMA->ViewValue = $this->KODE_AGAMA->CurrentValue;
                    }
                }
            } else {
                $this->KODE_AGAMA->ViewValue = null;
            }
            $this->KODE_AGAMA->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 11);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->ViewValue = $this->MODIFIED_FROM->CurrentValue;
            $this->MODIFIED_FROM->ViewCustomAttributes = "";

            // EMPLOYEE_ID_FROM
            $this->EMPLOYEE_ID_FROM->ViewValue = $this->EMPLOYEE_ID_FROM->CurrentValue;
            $this->EMPLOYEE_ID_FROM->ViewCustomAttributes = "";

            // RESPONSIBLE_ID
            $curVal = trim(strval($this->RESPONSIBLE_ID->CurrentValue));
            if ($curVal != "") {
                $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->lookupCacheOption($curVal);
                if ($this->RESPONSIBLE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[RESPONSIBLE_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->RESPONSIBLE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->RESPONSIBLE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->displayValue($arwrk);
                    } else {
                        $this->RESPONSIBLE_ID->ViewValue = $this->RESPONSIBLE_ID->CurrentValue;
                    }
                }
            } else {
                $this->RESPONSIBLE_ID->ViewValue = null;
            }
            $this->RESPONSIBLE_ID->ViewCustomAttributes = "";

            // RESPONSIBLE
            $this->RESPONSIBLE->ViewValue = $this->RESPONSIBLE->CurrentValue;
            $this->RESPONSIBLE->ViewCustomAttributes = "";

            // FAMILY_STATUS_ID
            $this->FAMILY_STATUS_ID->ViewValue = FormatNumber($this->FAMILY_STATUS_ID->ViewValue, 0, -2, -2, -2);
            $this->FAMILY_STATUS_ID->ViewCustomAttributes = "";

            // TICKET_NO
            $this->TICKET_NO->ViewValue = $this->TICKET_NO->CurrentValue;
            $this->TICKET_NO->ViewValue = FormatNumber($this->TICKET_NO->ViewValue, 0, -2, -2, -2);
            $this->TICKET_NO->ViewCustomAttributes = "";

            // ISATTENDED
            $this->ISATTENDED->ViewValue = $this->ISATTENDED->CurrentValue;
            $this->ISATTENDED->ViewCustomAttributes = "";

            // PAYOR_ID
            $curVal = trim(strval($this->PAYOR_ID->CurrentValue));
            if ($curVal != "") {
                $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->lookupCacheOption($curVal);
                if ($this->PAYOR_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[PAYOR_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->PAYOR_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PAYOR_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->displayValue($arwrk);
                    } else {
                        $this->PAYOR_ID->ViewValue = $this->PAYOR_ID->CurrentValue;
                    }
                }
            } else {
                $this->PAYOR_ID->ViewValue = null;
            }
            $this->PAYOR_ID->ViewCustomAttributes = "";

            // CLASS_ID
            $curVal = trim(strval($this->CLASS_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLASS_ID->ViewValue = $this->CLASS_ID->lookupCacheOption($curVal);
                if ($this->CLASS_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLASS_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->CLASS_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLASS_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLASS_ID->ViewValue = $this->CLASS_ID->displayValue($arwrk);
                    } else {
                        $this->CLASS_ID->ViewValue = $this->CLASS_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLASS_ID->ViewValue = null;
            }
            $this->CLASS_ID->ViewCustomAttributes = "";

            // ISPERTARIF
            $this->ISPERTARIF->ViewValue = $this->ISPERTARIF->CurrentValue;
            $this->ISPERTARIF->ViewCustomAttributes = "";

            // KAL_ID
            $curVal = trim(strval($this->KAL_ID->CurrentValue));
            if ($curVal != "") {
                $this->KAL_ID->ViewValue = $this->KAL_ID->lookupCacheOption($curVal);
                if ($this->KAL_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KAL_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->KAL_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->KAL_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->KAL_ID->ViewValue = $this->KAL_ID->displayValue($arwrk);
                    } else {
                        $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
                    }
                }
            } else {
                $this->KAL_ID->ViewValue = null;
            }
            $this->KAL_ID->ViewCustomAttributes = "";

            // EMPLOYEE_INAP
            $this->EMPLOYEE_INAP->ViewValue = $this->EMPLOYEE_INAP->CurrentValue;
            $this->EMPLOYEE_INAP->ViewCustomAttributes = "";

            // PASIEN_ID
            $this->PASIEN_ID->ViewValue = $this->PASIEN_ID->CurrentValue;
            $this->PASIEN_ID->ViewCustomAttributes = "";

            // KARYAWAN
            $this->KARYAWAN->ViewValue = $this->KARYAWAN->CurrentValue;
            $this->KARYAWAN->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // CLASS_ID_PLAFOND
            $this->CLASS_ID_PLAFOND->ViewValue = $this->CLASS_ID_PLAFOND->CurrentValue;
            $this->CLASS_ID_PLAFOND->ViewValue = FormatNumber($this->CLASS_ID_PLAFOND->ViewValue, 0, -2, -2, -2);
            $this->CLASS_ID_PLAFOND->ViewCustomAttributes = "";

            // BACKCHARGE
            $this->BACKCHARGE->ViewValue = $this->BACKCHARGE->CurrentValue;
            $this->BACKCHARGE->ViewCustomAttributes = "";

            // COVERAGE_ID
            $curVal = trim(strval($this->COVERAGE_ID->CurrentValue));
            if ($curVal != "") {
                $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->lookupCacheOption($curVal);
                if ($this->COVERAGE_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[COVERAGE_ID]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->COVERAGE_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->COVERAGE_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->displayValue($arwrk);
                    } else {
                        $this->COVERAGE_ID->ViewValue = $this->COVERAGE_ID->CurrentValue;
                    }
                }
            } else {
                $this->COVERAGE_ID->ViewValue = null;
            }
            $this->COVERAGE_ID->ViewCustomAttributes = "";

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

            // RECOMENDATION
            $this->RECOMENDATION->ViewValue = $this->RECOMENDATION->CurrentValue;
            $this->RECOMENDATION->ViewCustomAttributes = "";

            // CONCLUSION
            $this->CONCLUSION->ViewValue = $this->CONCLUSION->CurrentValue;
            $this->CONCLUSION->ViewCustomAttributes = "";

            // SPECIMENNO
            $this->SPECIMENNO->ViewValue = $this->SPECIMENNO->CurrentValue;
            $this->SPECIMENNO->ViewCustomAttributes = "";

            // LOCKED
            $this->LOCKED->ViewValue = $this->LOCKED->CurrentValue;
            $this->LOCKED->ViewCustomAttributes = "";

            // RM_OUT_DATE
            $this->RM_OUT_DATE->ViewValue = $this->RM_OUT_DATE->CurrentValue;
            $this->RM_OUT_DATE->ViewValue = FormatDateTime($this->RM_OUT_DATE->ViewValue, 0);
            $this->RM_OUT_DATE->ViewCustomAttributes = "";

            // RM_IN_DATE
            $this->RM_IN_DATE->ViewValue = $this->RM_IN_DATE->CurrentValue;
            $this->RM_IN_DATE->ViewValue = FormatDateTime($this->RM_IN_DATE->ViewValue, 0);
            $this->RM_IN_DATE->ViewCustomAttributes = "";

            // LAMA_PINJAM
            $this->LAMA_PINJAM->ViewValue = $this->LAMA_PINJAM->CurrentValue;
            $this->LAMA_PINJAM->ViewValue = FormatDateTime($this->LAMA_PINJAM->ViewValue, 0);
            $this->LAMA_PINJAM->ViewCustomAttributes = "";

            // STANDAR_RJ
            $this->STANDAR_RJ->ViewValue = $this->STANDAR_RJ->CurrentValue;
            $this->STANDAR_RJ->ViewCustomAttributes = "";

            // LENGKAP_RJ
            $this->LENGKAP_RJ->ViewValue = $this->LENGKAP_RJ->CurrentValue;
            $this->LENGKAP_RJ->ViewCustomAttributes = "";

            // LENGKAP_RI
            $this->LENGKAP_RI->ViewValue = $this->LENGKAP_RI->CurrentValue;
            $this->LENGKAP_RI->ViewCustomAttributes = "";

            // RESEND_RM_DATE
            $this->RESEND_RM_DATE->ViewValue = $this->RESEND_RM_DATE->CurrentValue;
            $this->RESEND_RM_DATE->ViewValue = FormatDateTime($this->RESEND_RM_DATE->ViewValue, 0);
            $this->RESEND_RM_DATE->ViewCustomAttributes = "";

            // LENGKAP_RM1
            $this->LENGKAP_RM1->ViewValue = $this->LENGKAP_RM1->CurrentValue;
            $this->LENGKAP_RM1->ViewCustomAttributes = "";

            // LENGKAP_RESUME
            $this->LENGKAP_RESUME->ViewValue = $this->LENGKAP_RESUME->CurrentValue;
            $this->LENGKAP_RESUME->ViewCustomAttributes = "";

            // LENGKAP_ANAMNESIS
            $this->LENGKAP_ANAMNESIS->ViewValue = $this->LENGKAP_ANAMNESIS->CurrentValue;
            $this->LENGKAP_ANAMNESIS->ViewCustomAttributes = "";

            // LENGKAP_CONSENT
            $this->LENGKAP_CONSENT->ViewValue = $this->LENGKAP_CONSENT->CurrentValue;
            $this->LENGKAP_CONSENT->ViewCustomAttributes = "";

            // LENGKAP_ANESTESI
            $this->LENGKAP_ANESTESI->ViewValue = $this->LENGKAP_ANESTESI->CurrentValue;
            $this->LENGKAP_ANESTESI->ViewCustomAttributes = "";

            // LENGKAP_OP
            $this->LENGKAP_OP->ViewValue = $this->LENGKAP_OP->CurrentValue;
            $this->LENGKAP_OP->ViewCustomAttributes = "";

            // BACK_RM_DATE
            $this->BACK_RM_DATE->ViewValue = $this->BACK_RM_DATE->CurrentValue;
            $this->BACK_RM_DATE->ViewValue = FormatDateTime($this->BACK_RM_DATE->ViewValue, 0);
            $this->BACK_RM_DATE->ViewCustomAttributes = "";

            // VALID_RM_DATE
            $this->VALID_RM_DATE->ViewValue = $this->VALID_RM_DATE->CurrentValue;
            $this->VALID_RM_DATE->ViewValue = FormatDateTime($this->VALID_RM_DATE->ViewValue, 0);
            $this->VALID_RM_DATE->ViewCustomAttributes = "";

            // NO_SKP
            $this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
            $this->NO_SKP->ViewCustomAttributes = "";

            // NO_SKPINAP
            $this->NO_SKPINAP->ViewValue = $this->NO_SKPINAP->CurrentValue;
            $this->NO_SKPINAP->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $curVal = trim(strval($this->DIAGNOSA_ID->CurrentValue));
            if ($curVal != "") {
                $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->lookupCacheOption($curVal);
                if ($this->DIAGNOSA_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[DIAGNOSA_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->DIAGNOSA_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->DIAGNOSA_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->displayValue($arwrk);
                    } else {
                        $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
                    }
                }
            } else {
                $this->DIAGNOSA_ID->ViewValue = null;
            }
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // ticket_all
            $this->ticket_all->ViewValue = $this->ticket_all->CurrentValue;
            $this->ticket_all->ViewValue = FormatNumber($this->ticket_all->ViewValue, 0, -2, -2, -2);
            $this->ticket_all->ViewCustomAttributes = "";

            // tanggal_rujukan
            $this->tanggal_rujukan->ViewValue = $this->tanggal_rujukan->CurrentValue;
            $this->tanggal_rujukan->ViewValue = FormatDateTime($this->tanggal_rujukan->ViewValue, 0);
            $this->tanggal_rujukan->ViewCustomAttributes = "";

            // ISRJ
            if (strval($this->ISRJ->CurrentValue) != "") {
                $this->ISRJ->ViewValue = $this->ISRJ->optionCaption($this->ISRJ->CurrentValue);
            } else {
                $this->ISRJ->ViewValue = null;
            }
            $this->ISRJ->ViewCustomAttributes = "";

            // NORUJUKAN
            $this->NORUJUKAN->ViewValue = $this->NORUJUKAN->CurrentValue;
            $this->NORUJUKAN->ViewCustomAttributes = "";

            // PPKRUJUKAN
            $curVal = trim(strval($this->PPKRUJUKAN->CurrentValue));
            if ($curVal != "") {
                $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->lookupCacheOption($curVal);
                if ($this->PPKRUJUKAN->ViewValue === null) { // Lookup from database
                    $filterWrk = "[KDPROVIDER]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->PPKRUJUKAN->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->PPKRUJUKAN->Lookup->renderViewRow($rswrk[0]);
                        $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->displayValue($arwrk);
                    } else {
                        $this->PPKRUJUKAN->ViewValue = $this->PPKRUJUKAN->CurrentValue;
                    }
                }
            } else {
                $this->PPKRUJUKAN->ViewValue = null;
            }
            $this->PPKRUJUKAN->ViewCustomAttributes = "";

            // LOKASILAKA
            $this->LOKASILAKA->ViewValue = $this->LOKASILAKA->CurrentValue;
            $this->LOKASILAKA->ViewCustomAttributes = "";

            // KDPOLI
            $this->KDPOLI->ViewValue = $this->KDPOLI->CurrentValue;
            $this->KDPOLI->ViewCustomAttributes = "";

            // EDIT_SEP
            $this->EDIT_SEP->ViewValue = $this->EDIT_SEP->CurrentValue;
            $this->EDIT_SEP->ViewCustomAttributes = "";

            // DELETE_SEP
            $this->DELETE_SEP->ViewValue = $this->DELETE_SEP->CurrentValue;
            $this->DELETE_SEP->ViewCustomAttributes = "";

            // DIAG_AWAL
            $this->DIAG_AWAL->ViewValue = $this->DIAG_AWAL->CurrentValue;
            $this->DIAG_AWAL->ViewCustomAttributes = "";

            // AKTIF
            $this->AKTIF->ViewValue = $this->AKTIF->CurrentValue;
            $this->AKTIF->ViewCustomAttributes = "";

            // BILL_INAP
            $this->BILL_INAP->ViewValue = $this->BILL_INAP->CurrentValue;
            $this->BILL_INAP->ViewCustomAttributes = "";

            // SEP_PRINTDATE
            $this->SEP_PRINTDATE->ViewValue = $this->SEP_PRINTDATE->CurrentValue;
            $this->SEP_PRINTDATE->ViewValue = FormatDateTime($this->SEP_PRINTDATE->ViewValue, 0);
            $this->SEP_PRINTDATE->ViewCustomAttributes = "";

            // MAPPING_SEP
            $this->MAPPING_SEP->ViewValue = $this->MAPPING_SEP->CurrentValue;
            $this->MAPPING_SEP->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // KDPOLI_EKS
            $this->KDPOLI_EKS->ViewValue = $this->KDPOLI_EKS->CurrentValue;
            $this->KDPOLI_EKS->ViewCustomAttributes = "";

            // COB
            if (strval($this->COB->CurrentValue) != "") {
                $this->COB->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->COB->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->COB->ViewValue->add($this->COB->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->COB->ViewValue = null;
            }
            $this->COB->ViewCustomAttributes = "";

            // PENJAMIN
            $this->PENJAMIN->ViewValue = $this->PENJAMIN->CurrentValue;
            $this->PENJAMIN->ViewCustomAttributes = "";

            // ASALRUJUKAN
            $this->ASALRUJUKAN->ViewValue = $this->ASALRUJUKAN->CurrentValue;
            $this->ASALRUJUKAN->ViewCustomAttributes = "";

            // RESPONSEP
            $this->RESPONSEP->ViewValue = $this->RESPONSEP->CurrentValue;
            $this->RESPONSEP->ViewCustomAttributes = "";

            // APPROVAL_DESC
            $this->APPROVAL_DESC->ViewValue = $this->APPROVAL_DESC->CurrentValue;
            $this->APPROVAL_DESC->ViewCustomAttributes = "";

            // APPROVAL_RESPONAJUKAN
            $this->APPROVAL_RESPONAJUKAN->ViewValue = $this->APPROVAL_RESPONAJUKAN->CurrentValue;
            $this->APPROVAL_RESPONAJUKAN->ViewCustomAttributes = "";

            // APPROVAL_RESPONAPPROV
            $this->APPROVAL_RESPONAPPROV->ViewValue = $this->APPROVAL_RESPONAPPROV->CurrentValue;
            $this->APPROVAL_RESPONAPPROV->ViewCustomAttributes = "";

            // RESPONTGLPLG_DESC
            $this->RESPONTGLPLG_DESC->ViewValue = $this->RESPONTGLPLG_DESC->CurrentValue;
            $this->RESPONTGLPLG_DESC->ViewCustomAttributes = "";

            // RESPONPOST_VKLAIM
            $this->RESPONPOST_VKLAIM->ViewValue = $this->RESPONPOST_VKLAIM->CurrentValue;
            $this->RESPONPOST_VKLAIM->ViewCustomAttributes = "";

            // RESPONPUT_VKLAIM
            $this->RESPONPUT_VKLAIM->ViewValue = $this->RESPONPUT_VKLAIM->CurrentValue;
            $this->RESPONPUT_VKLAIM->ViewCustomAttributes = "";

            // RESPONDEL_VKLAIM
            $this->RESPONDEL_VKLAIM->ViewValue = $this->RESPONDEL_VKLAIM->CurrentValue;
            $this->RESPONDEL_VKLAIM->ViewCustomAttributes = "";

            // CALL_TIMES
            $this->CALL_TIMES->ViewValue = $this->CALL_TIMES->CurrentValue;
            $this->CALL_TIMES->ViewValue = FormatNumber($this->CALL_TIMES->ViewValue, 0, -2, -2, -2);
            $this->CALL_TIMES->ViewCustomAttributes = "";

            // CALL_DATE
            $this->CALL_DATE->ViewValue = $this->CALL_DATE->CurrentValue;
            $this->CALL_DATE->ViewValue = FormatDateTime($this->CALL_DATE->ViewValue, 0);
            $this->CALL_DATE->ViewCustomAttributes = "";

            // CALL_DATES
            $this->CALL_DATES->ViewValue = $this->CALL_DATES->CurrentValue;
            $this->CALL_DATES->ViewValue = FormatDateTime($this->CALL_DATES->ViewValue, 0);
            $this->CALL_DATES->ViewCustomAttributes = "";

            // SERVED_DATE
            $this->SERVED_DATE->ViewValue = $this->SERVED_DATE->CurrentValue;
            $this->SERVED_DATE->ViewValue = FormatDateTime($this->SERVED_DATE->ViewValue, 0);
            $this->SERVED_DATE->ViewCustomAttributes = "";

            // SERVED_INAP
            $this->SERVED_INAP->ViewValue = $this->SERVED_INAP->CurrentValue;
            $this->SERVED_INAP->ViewValue = FormatDateTime($this->SERVED_INAP->ViewValue, 0);
            $this->SERVED_INAP->ViewCustomAttributes = "";

            // KDDPJP1
            $this->KDDPJP1->ViewValue = $this->KDDPJP1->CurrentValue;
            $this->KDDPJP1->ViewCustomAttributes = "";

            // KDDPJP
            $this->KDDPJP->ViewValue = $this->KDDPJP->CurrentValue;
            $this->KDDPJP->ViewCustomAttributes = "";

            // IDXDAFTAR
            $this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
            $this->IDXDAFTAR->ViewCustomAttributes = "";

            // tgl_kontrol
            $this->tgl_kontrol->ViewValue = $this->tgl_kontrol->CurrentValue;
            $this->tgl_kontrol->ViewValue = FormatDateTime($this->tgl_kontrol->ViewValue, 0);
            $this->tgl_kontrol->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";
            $this->DIANTAR_OLEH->TooltipValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";
            $this->GENDER->TooltipValue = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->LinkCustomAttributes = "";
            $this->VISITOR_ADDRESS->HrefValue = "";
            $this->VISITOR_ADDRESS->TooltipValue = "";

            // VISIT_DATE
            $this->VISIT_DATE->LinkCustomAttributes = "";
            $this->VISIT_DATE->HrefValue = "";
            $this->VISIT_DATE->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";
            $this->KELUAR_ID->TooltipValue = "";

            // IN_DATE
            $this->IN_DATE->LinkCustomAttributes = "";
            $this->IN_DATE->HrefValue = "";
            $this->IN_DATE->TooltipValue = "";

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

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";
            $this->AGEYEAR->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            $this->ORG_UNIT_CODE->CurrentValue = '1604031';

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            $curVal = trim(strval($this->NO_REGISTRATION->CurrentValue));
            if ($curVal != "") {
                $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->lookupCacheOption($curVal);
            } else {
                $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->Lookup !== null && is_array($this->NO_REGISTRATION->Lookup->Options) ? $curVal : null;
            }
            if ($this->NO_REGISTRATION->ViewValue !== null) { // Load from cache
                $this->NO_REGISTRATION->EditValue = array_values($this->NO_REGISTRATION->Lookup->Options);
                if ($this->NO_REGISTRATION->ViewValue == "") {
                    $this->NO_REGISTRATION->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[NO_REGISTRATION]" . SearchString("=", $this->NO_REGISTRATION->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->NO_REGISTRATION->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->NO_REGISTRATION->Lookup->renderViewRow($rswrk[0]);
                    $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->displayValue($arwrk);
                } else {
                    $this->NO_REGISTRATION->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->NO_REGISTRATION->EditValue = $arwrk;
            }
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->EditAttrs["class"] = "form-control";
            $this->DIANTAR_OLEH->EditCustomAttributes = "";
            if (!$this->DIANTAR_OLEH->Raw) {
                $this->DIANTAR_OLEH->CurrentValue = HtmlDecode($this->DIANTAR_OLEH->CurrentValue);
            }
            $this->DIANTAR_OLEH->EditValue = HtmlEncode($this->DIANTAR_OLEH->CurrentValue);
            $this->DIANTAR_OLEH->PlaceHolder = RemoveHtml($this->DIANTAR_OLEH->caption());

            // GENDER
            $this->GENDER->EditCustomAttributes = "";
            $curVal = trim(strval($this->GENDER->CurrentValue));
            if ($curVal != "") {
                $this->GENDER->ViewValue = $this->GENDER->lookupCacheOption($curVal);
            } else {
                $this->GENDER->ViewValue = $this->GENDER->Lookup !== null && is_array($this->GENDER->Lookup->Options) ? $curVal : null;
            }
            if ($this->GENDER->ViewValue !== null) { // Load from cache
                $this->GENDER->EditValue = array_values($this->GENDER->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[GENDER]" . SearchString("=", $this->GENDER->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[GENDER] = 1 OR [GENDER] = 2";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->GENDER->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->GENDER->EditValue = $arwrk;
            }
            $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->EditAttrs["class"] = "form-control";
            $this->VISITOR_ADDRESS->EditCustomAttributes = "";
            if (!$this->VISITOR_ADDRESS->Raw) {
                $this->VISITOR_ADDRESS->CurrentValue = HtmlDecode($this->VISITOR_ADDRESS->CurrentValue);
            }
            $this->VISITOR_ADDRESS->EditValue = HtmlEncode($this->VISITOR_ADDRESS->CurrentValue);
            $this->VISITOR_ADDRESS->PlaceHolder = RemoveHtml($this->VISITOR_ADDRESS->caption());

            // VISIT_DATE
            $this->VISIT_DATE->EditAttrs["class"] = "form-control";
            $this->VISIT_DATE->EditCustomAttributes = "";
            $this->VISIT_DATE->EditValue = HtmlEncode(FormatDateTime($this->VISIT_DATE->CurrentValue, 11));
            $this->VISIT_DATE->PlaceHolder = RemoveHtml($this->VISIT_DATE->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
            } else {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->Lookup !== null && is_array($this->CLINIC_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->CLINIC_ID->ViewValue !== null) { // Load from cache
                $this->CLINIC_ID->EditValue = array_values($this->CLINIC_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $this->CLINIC_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[STYPE_ID] = 1 OR [STYPE_ID] = 2 OR [STYPE_ID] = 5";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->CLINIC_ID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->CLINIC_ID->EditValue = $arwrk;
            }
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->EMPLOYEE_ID->CurrentValue));
            if ($curVal != "") {
                $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->lookupCacheOption($curVal);
            } else {
                $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->Lookup !== null && is_array($this->EMPLOYEE_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->EMPLOYEE_ID->ViewValue !== null) { // Load from cache
                $this->EMPLOYEE_ID->EditValue = array_values($this->EMPLOYEE_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[EMPLOYEE_ID]" . SearchString("=", $this->EMPLOYEE_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[OBJECT_CATEGORY_ID]= 20";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->EMPLOYEE_ID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->EMPLOYEE_ID->EditValue = $arwrk;
            }
            $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->STATUS_PASIEN_ID->CurrentValue));
            if ($curVal != "") {
                $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->lookupCacheOption($curVal);
            } else {
                $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->Lookup !== null && is_array($this->STATUS_PASIEN_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->STATUS_PASIEN_ID->ViewValue !== null) { // Load from cache
                $this->STATUS_PASIEN_ID->EditValue = array_values($this->STATUS_PASIEN_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[STATUS_PASIEN_ID]" . SearchString("=", $this->STATUS_PASIEN_ID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "[ISACTIVE] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->STATUS_PASIEN_ID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->STATUS_PASIEN_ID->EditValue = $arwrk;
            }
            $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

            // KELUAR_ID
            $this->KELUAR_ID->EditAttrs["class"] = "form-control";
            $this->KELUAR_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->KELUAR_ID->CurrentValue));
            if ($curVal != "") {
                $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->lookupCacheOption($curVal);
            } else {
                $this->KELUAR_ID->ViewValue = $this->KELUAR_ID->Lookup !== null && is_array($this->KELUAR_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->KELUAR_ID->ViewValue !== null) { // Load from cache
                $this->KELUAR_ID->EditValue = array_values($this->KELUAR_ID->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[KELUAR_ID]" . SearchString("=", $this->KELUAR_ID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->KELUAR_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->KELUAR_ID->EditValue = $arwrk;
            }
            $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

            // IN_DATE
            $this->IN_DATE->EditAttrs["class"] = "form-control";
            $this->IN_DATE->EditCustomAttributes = "";
            $this->IN_DATE->EditValue = HtmlEncode(FormatDateTime($this->IN_DATE->CurrentValue, 11));
            $this->IN_DATE->PlaceHolder = RemoveHtml($this->IN_DATE->caption());

            // MODIFIED_BY

            // MODIFIED_DATE

            // MODIFIED_FROM

            // AGEYEAR
            $this->AGEYEAR->EditAttrs["class"] = "form-control";
            $this->AGEYEAR->EditCustomAttributes = "";
            $this->AGEYEAR->EditValue = HtmlEncode($this->AGEYEAR->CurrentValue);
            $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if (!$this->TRANS_ID->Raw) {
                $this->TRANS_ID->CurrentValue = HtmlDecode($this->TRANS_ID->CurrentValue);
            }
            $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->CurrentValue);
            $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // DIANTAR_OLEH
            $this->DIANTAR_OLEH->LinkCustomAttributes = "";
            $this->DIANTAR_OLEH->HrefValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";

            // VISITOR_ADDRESS
            $this->VISITOR_ADDRESS->LinkCustomAttributes = "";
            $this->VISITOR_ADDRESS->HrefValue = "";

            // VISIT_DATE
            $this->VISIT_DATE->LinkCustomAttributes = "";
            $this->VISIT_DATE->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";

            // IN_DATE
            $this->IN_DATE->LinkCustomAttributes = "";
            $this->IN_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->LinkCustomAttributes = "";
            $this->MODIFIED_FROM->HrefValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->ORG_UNIT_CODE->Required) {
            if (!$this->ORG_UNIT_CODE->IsDetailKey && EmptyValue($this->ORG_UNIT_CODE->FormValue)) {
                $this->ORG_UNIT_CODE->addErrorMessage(str_replace("%s", $this->ORG_UNIT_CODE->caption(), $this->ORG_UNIT_CODE->RequiredErrorMessage));
            }
        }
        if ($this->NO_REGISTRATION->Required) {
            if (!$this->NO_REGISTRATION->IsDetailKey && EmptyValue($this->NO_REGISTRATION->FormValue)) {
                $this->NO_REGISTRATION->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION->caption(), $this->NO_REGISTRATION->RequiredErrorMessage));
            }
        }
        if ($this->DIANTAR_OLEH->Required) {
            if (!$this->DIANTAR_OLEH->IsDetailKey && EmptyValue($this->DIANTAR_OLEH->FormValue)) {
                $this->DIANTAR_OLEH->addErrorMessage(str_replace("%s", $this->DIANTAR_OLEH->caption(), $this->DIANTAR_OLEH->RequiredErrorMessage));
            }
        }
        if ($this->GENDER->Required) {
            if ($this->GENDER->FormValue == "") {
                $this->GENDER->addErrorMessage(str_replace("%s", $this->GENDER->caption(), $this->GENDER->RequiredErrorMessage));
            }
        }
        if ($this->VISITOR_ADDRESS->Required) {
            if (!$this->VISITOR_ADDRESS->IsDetailKey && EmptyValue($this->VISITOR_ADDRESS->FormValue)) {
                $this->VISITOR_ADDRESS->addErrorMessage(str_replace("%s", $this->VISITOR_ADDRESS->caption(), $this->VISITOR_ADDRESS->RequiredErrorMessage));
            }
        }
        if ($this->VISIT_DATE->Required) {
            if (!$this->VISIT_DATE->IsDetailKey && EmptyValue($this->VISIT_DATE->FormValue)) {
                $this->VISIT_DATE->addErrorMessage(str_replace("%s", $this->VISIT_DATE->caption(), $this->VISIT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->VISIT_DATE->FormValue)) {
            $this->VISIT_DATE->addErrorMessage($this->VISIT_DATE->getErrorMessage(false));
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->EMPLOYEE_ID->Required) {
            if (!$this->EMPLOYEE_ID->IsDetailKey && EmptyValue($this->EMPLOYEE_ID->FormValue)) {
                $this->EMPLOYEE_ID->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID->caption(), $this->EMPLOYEE_ID->RequiredErrorMessage));
            }
        }
        if ($this->STATUS_PASIEN_ID->Required) {
            if (!$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if ($this->KELUAR_ID->Required) {
            if (!$this->KELUAR_ID->IsDetailKey && EmptyValue($this->KELUAR_ID->FormValue)) {
                $this->KELUAR_ID->addErrorMessage(str_replace("%s", $this->KELUAR_ID->caption(), $this->KELUAR_ID->RequiredErrorMessage));
            }
        }
        if ($this->IN_DATE->Required) {
            if (!$this->IN_DATE->IsDetailKey && EmptyValue($this->IN_DATE->FormValue)) {
                $this->IN_DATE->addErrorMessage(str_replace("%s", $this->IN_DATE->caption(), $this->IN_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->IN_DATE->FormValue)) {
            $this->IN_DATE->addErrorMessage($this->IN_DATE->getErrorMessage(false));
        }
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_DATE->Required) {
            if (!$this->MODIFIED_DATE->IsDetailKey && EmptyValue($this->MODIFIED_DATE->FormValue)) {
                $this->MODIFIED_DATE->addErrorMessage(str_replace("%s", $this->MODIFIED_DATE->caption(), $this->MODIFIED_DATE->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_FROM->Required) {
            if (!$this->MODIFIED_FROM->IsDetailKey && EmptyValue($this->MODIFIED_FROM->FormValue)) {
                $this->MODIFIED_FROM->addErrorMessage(str_replace("%s", $this->MODIFIED_FROM->caption(), $this->MODIFIED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->AGEYEAR->Required) {
            if (!$this->AGEYEAR->IsDetailKey && EmptyValue($this->AGEYEAR->FormValue)) {
                $this->AGEYEAR->addErrorMessage(str_replace("%s", $this->AGEYEAR->caption(), $this->AGEYEAR->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEYEAR->FormValue)) {
            $this->AGEYEAR->addErrorMessage($this->AGEYEAR->getErrorMessage(false));
        }
        if ($this->TRANS_ID->Required) {
            if (!$this->TRANS_ID->IsDetailKey && EmptyValue($this->TRANS_ID->FormValue)) {
                $this->TRANS_ID->addErrorMessage(str_replace("%s", $this->TRANS_ID->caption(), $this->TRANS_ID->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("TreatmentBillGrid");
        if (in_array("TREATMENT_BILL", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("TreatmentAkomodasiGrid");
        if (in_array("TREATMENT_AKOMODASI", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, null, strval($this->ORG_UNIT_CODE->CurrentValue) == "");

        // NO_REGISTRATION
        $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", false);

        // DIANTAR_OLEH
        $this->DIANTAR_OLEH->setDbValueDef($rsnew, $this->DIANTAR_OLEH->CurrentValue, null, false);

        // GENDER
        $this->GENDER->setDbValueDef($rsnew, $this->GENDER->CurrentValue, null, false);

        // VISITOR_ADDRESS
        $this->VISITOR_ADDRESS->setDbValueDef($rsnew, $this->VISITOR_ADDRESS->CurrentValue, null, false);

        // VISIT_DATE
        $this->VISIT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->VISIT_DATE->CurrentValue, 11), null, false);

        // CLINIC_ID
        $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, false);

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->setDbValueDef($rsnew, $this->EMPLOYEE_ID->CurrentValue, null, false);

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->setDbValueDef($rsnew, $this->STATUS_PASIEN_ID->CurrentValue, null, false);

        // KELUAR_ID
        $this->KELUAR_ID->setDbValueDef($rsnew, $this->KELUAR_ID->CurrentValue, null, false);

        // IN_DATE
        $this->IN_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->IN_DATE->CurrentValue, 11), null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->CurrentValue = CurrentUserName();
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->CurrentValue = CurrentDateTime();
        $this->MODIFIED_DATE->setDbValueDef($rsnew, $this->MODIFIED_DATE->CurrentValue, null);

        // MODIFIED_FROM
        $this->MODIFIED_FROM->CurrentValue = CurrentUserName();
        $this->MODIFIED_FROM->setDbValueDef($rsnew, $this->MODIFIED_FROM->CurrentValue, null);

        // AGEYEAR
        $this->AGEYEAR->setDbValueDef($rsnew, $this->AGEYEAR->CurrentValue, null, false);

        // TRANS_ID
        $this->TRANS_ID->setDbValueDef($rsnew, $this->TRANS_ID->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("TreatmentBillGrid");
            if (in_array("TREATMENT_BILL", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->VISIT_ID->setSessionValue($this->VISIT_ID->CurrentValue); // Set master key
                $detailPage->TRANS_ID->setSessionValue($this->TRANS_ID->CurrentValue); // Set master key
                $detailPage->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->CurrentValue); // Set master key
                $detailPage->THENAME->setSessionValue($this->DIANTAR_OLEH->CurrentValue); // Set master key
                $detailPage->THEADDRESS->setSessionValue($this->VISITOR_ADDRESS->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "TREATMENT_BILL"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->VISIT_ID->setSessionValue(""); // Clear master key if insert failed
                $detailPage->TRANS_ID->setSessionValue(""); // Clear master key if insert failed
                $detailPage->NO_REGISTRATION->setSessionValue(""); // Clear master key if insert failed
                $detailPage->THENAME->setSessionValue(""); // Clear master key if insert failed
                $detailPage->THEADDRESS->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("TreatmentAkomodasiGrid");
            if (in_array("TREATMENT_AKOMODASI", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->CurrentValue); // Set master key
                $detailPage->VISIT_ID->setSessionValue($this->VISIT_ID->CurrentValue); // Set master key
                $detailPage->THENAME->setSessionValue($this->DIANTAR_OLEH->CurrentValue); // Set master key
                $detailPage->THEADDRESS->setSessionValue($this->VISITOR_ADDRESS->CurrentValue); // Set master key
                $detailPage->TRANS_ID->setSessionValue($this->TRANS_ID->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "TREATMENT_AKOMODASI"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->NO_REGISTRATION->setSessionValue(""); // Clear master key if insert failed
                $detailPage->VISIT_ID->setSessionValue(""); // Clear master key if insert failed
                $detailPage->THENAME->setSessionValue(""); // Clear master key if insert failed
                $detailPage->THEADDRESS->setSessionValue(""); // Clear master key if insert failed
                $detailPage->TRANS_ID->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("TREATMENT_BILL", $detailTblVar)) {
                $detailPageObj = Container("TreatmentBillGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->VISIT_ID->IsDetailKey = true;
                    $detailPageObj->VISIT_ID->CurrentValue = $this->VISIT_ID->CurrentValue;
                    $detailPageObj->VISIT_ID->setSessionValue($detailPageObj->VISIT_ID->CurrentValue);
                    $detailPageObj->TRANS_ID->IsDetailKey = true;
                    $detailPageObj->TRANS_ID->CurrentValue = $this->TRANS_ID->CurrentValue;
                    $detailPageObj->TRANS_ID->setSessionValue($detailPageObj->TRANS_ID->CurrentValue);
                    $detailPageObj->NO_REGISTRATION->IsDetailKey = true;
                    $detailPageObj->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->CurrentValue;
                    $detailPageObj->NO_REGISTRATION->setSessionValue($detailPageObj->NO_REGISTRATION->CurrentValue);
                    $detailPageObj->THENAME->IsDetailKey = true;
                    $detailPageObj->THENAME->CurrentValue = $this->DIANTAR_OLEH->CurrentValue;
                    $detailPageObj->THENAME->setSessionValue($detailPageObj->THENAME->CurrentValue);
                    $detailPageObj->THEADDRESS->IsDetailKey = true;
                    $detailPageObj->THEADDRESS->CurrentValue = $this->VISITOR_ADDRESS->CurrentValue;
                    $detailPageObj->THEADDRESS->setSessionValue($detailPageObj->THEADDRESS->CurrentValue);
                }
            }
            if (in_array("TREATMENT_AKOMODASI", $detailTblVar)) {
                $detailPageObj = Container("TreatmentAkomodasiGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->NO_REGISTRATION->IsDetailKey = true;
                    $detailPageObj->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->CurrentValue;
                    $detailPageObj->NO_REGISTRATION->setSessionValue($detailPageObj->NO_REGISTRATION->CurrentValue);
                    $detailPageObj->VISIT_ID->IsDetailKey = true;
                    $detailPageObj->VISIT_ID->CurrentValue = $this->VISIT_ID->CurrentValue;
                    $detailPageObj->VISIT_ID->setSessionValue($detailPageObj->VISIT_ID->CurrentValue);
                    $detailPageObj->THENAME->IsDetailKey = true;
                    $detailPageObj->THENAME->CurrentValue = $this->DIANTAR_OLEH->CurrentValue;
                    $detailPageObj->THENAME->setSessionValue($detailPageObj->THENAME->CurrentValue);
                    $detailPageObj->THEADDRESS->IsDetailKey = true;
                    $detailPageObj->THEADDRESS->CurrentValue = $this->VISITOR_ADDRESS->CurrentValue;
                    $detailPageObj->THEADDRESS->setSessionValue($detailPageObj->THEADDRESS->CurrentValue);
                    $detailPageObj->TRANS_ID->IsDetailKey = true;
                    $detailPageObj->TRANS_ID->CurrentValue = $this->TRANS_ID->CurrentValue;
                    $detailPageObj->TRANS_ID->setSessionValue($detailPageObj->TRANS_ID->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PasienVisitationList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('TREATMENT_BILL');
        $pages->add('TREATMENT_AKOMODASI');
        $this->DetailPages = $pages;
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_NO_REGISTRATION":
                    break;
                case "x_GENDER":
                    $lookupFilter = function () {
                        return "[GENDER] = 1 OR [GENDER] = 2";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_CLINIC_ID":
                    $lookupFilter = function () {
                        return "[STYPE_ID] = 1 OR [STYPE_ID] = 2 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_EMPLOYEE_ID":
                    $lookupFilter = function () {
                        return "[OBJECT_CATEGORY_ID]= 20";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_STATUS_PASIEN_ID":
                    $lookupFilter = function () {
                        return "[ISACTIVE] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_RUJUKAN_ID":
                    break;
                case "x_REASON_ID":
                    break;
                case "x_WAY_ID":
                    break;
                case "x_PATIENT_CATEGORY_ID":
                    break;
                case "x_ISNEW":
                    break;
                case "x_CLINIC_ID_FROM":
                    break;
                case "x_KELUAR_ID":
                    break;
                case "x_KODE_AGAMA":
                    break;
                case "x_RESPONSIBLE_ID":
                    break;
                case "x_PAYOR_ID":
                    break;
                case "x_CLASS_ID":
                    break;
                case "x_KAL_ID":
                    break;
                case "x_COVERAGE_ID":
                    break;
                case "x_DIAGNOSA_ID":
                    break;
                case "x_ISRJ":
                    break;
                case "x_PPKRUJUKAN":
                    break;
                case "x_COB":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
