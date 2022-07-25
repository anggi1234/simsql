<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VTreatmentbillList extends VTreatmentbill
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'V_TREATMENTBILL';

    // Page object name
    public $PageObjName = "VTreatmentbillList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fV_TREATMENTBILLlist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (V_TREATMENTBILL)
        if (!isset($GLOBALS["V_TREATMENTBILL"]) || get_class($GLOBALS["V_TREATMENTBILL"]) == PROJECT_NAMESPACE . "V_TREATMENTBILL") {
            $GLOBALS["V_TREATMENTBILL"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "VTreatmentbillAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "VTreatmentbillDelete";
        $this->MultiUpdateUrl = "VTreatmentbillUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'V_TREATMENTBILL');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fV_TREATMENTBILLlistsrch";

        // List actions
        $this->ListActions = new ListActions();
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
                $doc = new $class(Container("V_TREATMENTBILL"));
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
            $key .= @$ar['visit_id'];
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
        if ($this->isAddOrEdit()) {
            $this->KALURAHAN->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->name_of_clinic->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->booked_Date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->visit_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->visit_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->isattended->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->diantar_oleh->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->visitor_address->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->address_of_rujukan->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->rujukan_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->patient_category_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->payor_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->reason_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->DESCRIPTION->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->way_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->follow_up->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->isnew->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->family_status_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->class_room_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->STATUS_PASIEN_ID->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fullname->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->employee_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->employee_id_from->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->clinic_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->clinic_id_FROM->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->doctor->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->bed_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->keluar_id->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->treat_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->exit_date->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->name_of_class->Visible = false;
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 5;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "5,10,20,50"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } elseif (IsPost()) {
            if (Post("exporttype") !== null) {
                $this->Export = Post("exporttype");
            }
            $custom = Post("custom", "");
        } elseif (Get("cmd") == "json") {
            $this->Export = Get("cmd");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header

        // Update Export URLs
        if (Config("USE_PHPEXCEL")) {
            $this->ExportExcelCustom = false;
        }
        if (Config("USE_PHPWORD")) {
            $this->ExportWordCustom = false;
        }
        if ($this->ExportExcelCustom) {
            $this->ExportExcelUrl .= "&amp;custom=1";
        }
        if ($this->ExportWordCustom) {
            $this->ExportWordUrl .= "&amp;custom=1";
        }
        if ($this->ExportPdfCustom) {
            $this->ExportPdfUrl .= "&amp;custom=1";
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
        $this->NAME_OF_PASIEN->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->ORG_UNIT_CODE->setVisibility();
        $this->date_of_birth->setVisibility();
        $this->CONTACT_ADDRESS->setVisibility();
        $this->PHONE_NUMBER->setVisibility();
        $this->MOBILE->setVisibility();
        $this->KAL_ID->setVisibility();
        $this->PLACE_OF_BIRTH->setVisibility();
        $this->KALURAHAN->setVisibility();
        $this->name_of_clinic->setVisibility();
        $this->booked_Date->setVisibility();
        $this->visit_date->setVisibility();
        $this->visit_id->setVisibility();
        $this->isattended->setVisibility();
        $this->diantar_oleh->setVisibility();
        $this->visitor_address->setVisibility();
        $this->address_of_rujukan->setVisibility();
        $this->rujukan_id->setVisibility();
        $this->patient_category_id->setVisibility();
        $this->payor_id->setVisibility();
        $this->reason_id->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->way_id->setVisibility();
        $this->follow_up->setVisibility();
        $this->isnew->setVisibility();
        $this->family_status_id->setVisibility();
        $this->class_room_id->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->fullname->setVisibility();
        $this->employee_id->setVisibility();
        $this->employee_id_from->setVisibility();
        $this->clinic_id->setVisibility();
        $this->clinic_id_FROM->setVisibility();
        $this->doctor->setVisibility();
        $this->bed_id->setVisibility();
        $this->keluar_id->setVisibility();
        $this->treat_date->setVisibility();
        $this->exit_date->setVisibility();
        $this->name_of_class->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 5; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 5; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->NAME_OF_PASIEN->AdvancedSearch->toJson(), ","); // Field NAME_OF_PASIEN
        $filterList = Concat($filterList, $this->NO_REGISTRATION->AdvancedSearch->toJson(), ","); // Field NO_REGISTRATION
        $filterList = Concat($filterList, $this->ORG_UNIT_CODE->AdvancedSearch->toJson(), ","); // Field ORG_UNIT_CODE
        $filterList = Concat($filterList, $this->date_of_birth->AdvancedSearch->toJson(), ","); // Field date_of_birth
        $filterList = Concat($filterList, $this->CONTACT_ADDRESS->AdvancedSearch->toJson(), ","); // Field CONTACT_ADDRESS
        $filterList = Concat($filterList, $this->PHONE_NUMBER->AdvancedSearch->toJson(), ","); // Field PHONE_NUMBER
        $filterList = Concat($filterList, $this->MOBILE->AdvancedSearch->toJson(), ","); // Field MOBILE
        $filterList = Concat($filterList, $this->KAL_ID->AdvancedSearch->toJson(), ","); // Field KAL_ID
        $filterList = Concat($filterList, $this->PLACE_OF_BIRTH->AdvancedSearch->toJson(), ","); // Field PLACE_OF_BIRTH
        $filterList = Concat($filterList, $this->KALURAHAN->AdvancedSearch->toJson(), ","); // Field KALURAHAN
        $filterList = Concat($filterList, $this->name_of_clinic->AdvancedSearch->toJson(), ","); // Field name_of_clinic
        $filterList = Concat($filterList, $this->booked_Date->AdvancedSearch->toJson(), ","); // Field booked_Date
        $filterList = Concat($filterList, $this->visit_date->AdvancedSearch->toJson(), ","); // Field visit_date
        $filterList = Concat($filterList, $this->visit_id->AdvancedSearch->toJson(), ","); // Field visit_id
        $filterList = Concat($filterList, $this->isattended->AdvancedSearch->toJson(), ","); // Field isattended
        $filterList = Concat($filterList, $this->diantar_oleh->AdvancedSearch->toJson(), ","); // Field diantar_oleh
        $filterList = Concat($filterList, $this->visitor_address->AdvancedSearch->toJson(), ","); // Field visitor_address
        $filterList = Concat($filterList, $this->address_of_rujukan->AdvancedSearch->toJson(), ","); // Field address_of_rujukan
        $filterList = Concat($filterList, $this->rujukan_id->AdvancedSearch->toJson(), ","); // Field rujukan_id
        $filterList = Concat($filterList, $this->patient_category_id->AdvancedSearch->toJson(), ","); // Field patient_category_id
        $filterList = Concat($filterList, $this->payor_id->AdvancedSearch->toJson(), ","); // Field payor_id
        $filterList = Concat($filterList, $this->reason_id->AdvancedSearch->toJson(), ","); // Field reason_id
        $filterList = Concat($filterList, $this->DESCRIPTION->AdvancedSearch->toJson(), ","); // Field DESCRIPTION
        $filterList = Concat($filterList, $this->way_id->AdvancedSearch->toJson(), ","); // Field way_id
        $filterList = Concat($filterList, $this->follow_up->AdvancedSearch->toJson(), ","); // Field follow_up
        $filterList = Concat($filterList, $this->isnew->AdvancedSearch->toJson(), ","); // Field isnew
        $filterList = Concat($filterList, $this->family_status_id->AdvancedSearch->toJson(), ","); // Field family_status_id
        $filterList = Concat($filterList, $this->class_room_id->AdvancedSearch->toJson(), ","); // Field class_room_id
        $filterList = Concat($filterList, $this->STATUS_PASIEN_ID->AdvancedSearch->toJson(), ","); // Field STATUS_PASIEN_ID
        $filterList = Concat($filterList, $this->fullname->AdvancedSearch->toJson(), ","); // Field fullname
        $filterList = Concat($filterList, $this->employee_id->AdvancedSearch->toJson(), ","); // Field employee_id
        $filterList = Concat($filterList, $this->employee_id_from->AdvancedSearch->toJson(), ","); // Field employee_id_from
        $filterList = Concat($filterList, $this->clinic_id->AdvancedSearch->toJson(), ","); // Field clinic_id
        $filterList = Concat($filterList, $this->clinic_id_FROM->AdvancedSearch->toJson(), ","); // Field clinic_id_FROM
        $filterList = Concat($filterList, $this->doctor->AdvancedSearch->toJson(), ","); // Field doctor
        $filterList = Concat($filterList, $this->bed_id->AdvancedSearch->toJson(), ","); // Field bed_id
        $filterList = Concat($filterList, $this->keluar_id->AdvancedSearch->toJson(), ","); // Field keluar_id
        $filterList = Concat($filterList, $this->treat_date->AdvancedSearch->toJson(), ","); // Field treat_date
        $filterList = Concat($filterList, $this->exit_date->AdvancedSearch->toJson(), ","); // Field exit_date
        $filterList = Concat($filterList, $this->name_of_class->AdvancedSearch->toJson(), ","); // Field name_of_class
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fV_TREATMENTBILLlistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field NAME_OF_PASIEN
        $this->NAME_OF_PASIEN->AdvancedSearch->SearchValue = @$filter["x_NAME_OF_PASIEN"];
        $this->NAME_OF_PASIEN->AdvancedSearch->SearchOperator = @$filter["z_NAME_OF_PASIEN"];
        $this->NAME_OF_PASIEN->AdvancedSearch->SearchCondition = @$filter["v_NAME_OF_PASIEN"];
        $this->NAME_OF_PASIEN->AdvancedSearch->SearchValue2 = @$filter["y_NAME_OF_PASIEN"];
        $this->NAME_OF_PASIEN->AdvancedSearch->SearchOperator2 = @$filter["w_NAME_OF_PASIEN"];
        $this->NAME_OF_PASIEN->AdvancedSearch->save();

        // Field NO_REGISTRATION
        $this->NO_REGISTRATION->AdvancedSearch->SearchValue = @$filter["x_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchOperator = @$filter["z_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchCondition = @$filter["v_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchValue2 = @$filter["y_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchOperator2 = @$filter["w_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->save();

        // Field ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue = @$filter["x_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator = @$filter["z_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchCondition = @$filter["v_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue2 = @$filter["y_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->save();

        // Field date_of_birth
        $this->date_of_birth->AdvancedSearch->SearchValue = @$filter["x_date_of_birth"];
        $this->date_of_birth->AdvancedSearch->SearchOperator = @$filter["z_date_of_birth"];
        $this->date_of_birth->AdvancedSearch->SearchCondition = @$filter["v_date_of_birth"];
        $this->date_of_birth->AdvancedSearch->SearchValue2 = @$filter["y_date_of_birth"];
        $this->date_of_birth->AdvancedSearch->SearchOperator2 = @$filter["w_date_of_birth"];
        $this->date_of_birth->AdvancedSearch->save();

        // Field CONTACT_ADDRESS
        $this->CONTACT_ADDRESS->AdvancedSearch->SearchValue = @$filter["x_CONTACT_ADDRESS"];
        $this->CONTACT_ADDRESS->AdvancedSearch->SearchOperator = @$filter["z_CONTACT_ADDRESS"];
        $this->CONTACT_ADDRESS->AdvancedSearch->SearchCondition = @$filter["v_CONTACT_ADDRESS"];
        $this->CONTACT_ADDRESS->AdvancedSearch->SearchValue2 = @$filter["y_CONTACT_ADDRESS"];
        $this->CONTACT_ADDRESS->AdvancedSearch->SearchOperator2 = @$filter["w_CONTACT_ADDRESS"];
        $this->CONTACT_ADDRESS->AdvancedSearch->save();

        // Field PHONE_NUMBER
        $this->PHONE_NUMBER->AdvancedSearch->SearchValue = @$filter["x_PHONE_NUMBER"];
        $this->PHONE_NUMBER->AdvancedSearch->SearchOperator = @$filter["z_PHONE_NUMBER"];
        $this->PHONE_NUMBER->AdvancedSearch->SearchCondition = @$filter["v_PHONE_NUMBER"];
        $this->PHONE_NUMBER->AdvancedSearch->SearchValue2 = @$filter["y_PHONE_NUMBER"];
        $this->PHONE_NUMBER->AdvancedSearch->SearchOperator2 = @$filter["w_PHONE_NUMBER"];
        $this->PHONE_NUMBER->AdvancedSearch->save();

        // Field MOBILE
        $this->MOBILE->AdvancedSearch->SearchValue = @$filter["x_MOBILE"];
        $this->MOBILE->AdvancedSearch->SearchOperator = @$filter["z_MOBILE"];
        $this->MOBILE->AdvancedSearch->SearchCondition = @$filter["v_MOBILE"];
        $this->MOBILE->AdvancedSearch->SearchValue2 = @$filter["y_MOBILE"];
        $this->MOBILE->AdvancedSearch->SearchOperator2 = @$filter["w_MOBILE"];
        $this->MOBILE->AdvancedSearch->save();

        // Field KAL_ID
        $this->KAL_ID->AdvancedSearch->SearchValue = @$filter["x_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchOperator = @$filter["z_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchCondition = @$filter["v_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchValue2 = @$filter["y_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->save();

        // Field PLACE_OF_BIRTH
        $this->PLACE_OF_BIRTH->AdvancedSearch->SearchValue = @$filter["x_PLACE_OF_BIRTH"];
        $this->PLACE_OF_BIRTH->AdvancedSearch->SearchOperator = @$filter["z_PLACE_OF_BIRTH"];
        $this->PLACE_OF_BIRTH->AdvancedSearch->SearchCondition = @$filter["v_PLACE_OF_BIRTH"];
        $this->PLACE_OF_BIRTH->AdvancedSearch->SearchValue2 = @$filter["y_PLACE_OF_BIRTH"];
        $this->PLACE_OF_BIRTH->AdvancedSearch->SearchOperator2 = @$filter["w_PLACE_OF_BIRTH"];
        $this->PLACE_OF_BIRTH->AdvancedSearch->save();

        // Field KALURAHAN
        $this->KALURAHAN->AdvancedSearch->SearchValue = @$filter["x_KALURAHAN"];
        $this->KALURAHAN->AdvancedSearch->SearchOperator = @$filter["z_KALURAHAN"];
        $this->KALURAHAN->AdvancedSearch->SearchCondition = @$filter["v_KALURAHAN"];
        $this->KALURAHAN->AdvancedSearch->SearchValue2 = @$filter["y_KALURAHAN"];
        $this->KALURAHAN->AdvancedSearch->SearchOperator2 = @$filter["w_KALURAHAN"];
        $this->KALURAHAN->AdvancedSearch->save();

        // Field name_of_clinic
        $this->name_of_clinic->AdvancedSearch->SearchValue = @$filter["x_name_of_clinic"];
        $this->name_of_clinic->AdvancedSearch->SearchOperator = @$filter["z_name_of_clinic"];
        $this->name_of_clinic->AdvancedSearch->SearchCondition = @$filter["v_name_of_clinic"];
        $this->name_of_clinic->AdvancedSearch->SearchValue2 = @$filter["y_name_of_clinic"];
        $this->name_of_clinic->AdvancedSearch->SearchOperator2 = @$filter["w_name_of_clinic"];
        $this->name_of_clinic->AdvancedSearch->save();

        // Field booked_Date
        $this->booked_Date->AdvancedSearch->SearchValue = @$filter["x_booked_Date"];
        $this->booked_Date->AdvancedSearch->SearchOperator = @$filter["z_booked_Date"];
        $this->booked_Date->AdvancedSearch->SearchCondition = @$filter["v_booked_Date"];
        $this->booked_Date->AdvancedSearch->SearchValue2 = @$filter["y_booked_Date"];
        $this->booked_Date->AdvancedSearch->SearchOperator2 = @$filter["w_booked_Date"];
        $this->booked_Date->AdvancedSearch->save();

        // Field visit_date
        $this->visit_date->AdvancedSearch->SearchValue = @$filter["x_visit_date"];
        $this->visit_date->AdvancedSearch->SearchOperator = @$filter["z_visit_date"];
        $this->visit_date->AdvancedSearch->SearchCondition = @$filter["v_visit_date"];
        $this->visit_date->AdvancedSearch->SearchValue2 = @$filter["y_visit_date"];
        $this->visit_date->AdvancedSearch->SearchOperator2 = @$filter["w_visit_date"];
        $this->visit_date->AdvancedSearch->save();

        // Field visit_id
        $this->visit_id->AdvancedSearch->SearchValue = @$filter["x_visit_id"];
        $this->visit_id->AdvancedSearch->SearchOperator = @$filter["z_visit_id"];
        $this->visit_id->AdvancedSearch->SearchCondition = @$filter["v_visit_id"];
        $this->visit_id->AdvancedSearch->SearchValue2 = @$filter["y_visit_id"];
        $this->visit_id->AdvancedSearch->SearchOperator2 = @$filter["w_visit_id"];
        $this->visit_id->AdvancedSearch->save();

        // Field isattended
        $this->isattended->AdvancedSearch->SearchValue = @$filter["x_isattended"];
        $this->isattended->AdvancedSearch->SearchOperator = @$filter["z_isattended"];
        $this->isattended->AdvancedSearch->SearchCondition = @$filter["v_isattended"];
        $this->isattended->AdvancedSearch->SearchValue2 = @$filter["y_isattended"];
        $this->isattended->AdvancedSearch->SearchOperator2 = @$filter["w_isattended"];
        $this->isattended->AdvancedSearch->save();

        // Field diantar_oleh
        $this->diantar_oleh->AdvancedSearch->SearchValue = @$filter["x_diantar_oleh"];
        $this->diantar_oleh->AdvancedSearch->SearchOperator = @$filter["z_diantar_oleh"];
        $this->diantar_oleh->AdvancedSearch->SearchCondition = @$filter["v_diantar_oleh"];
        $this->diantar_oleh->AdvancedSearch->SearchValue2 = @$filter["y_diantar_oleh"];
        $this->diantar_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_diantar_oleh"];
        $this->diantar_oleh->AdvancedSearch->save();

        // Field visitor_address
        $this->visitor_address->AdvancedSearch->SearchValue = @$filter["x_visitor_address"];
        $this->visitor_address->AdvancedSearch->SearchOperator = @$filter["z_visitor_address"];
        $this->visitor_address->AdvancedSearch->SearchCondition = @$filter["v_visitor_address"];
        $this->visitor_address->AdvancedSearch->SearchValue2 = @$filter["y_visitor_address"];
        $this->visitor_address->AdvancedSearch->SearchOperator2 = @$filter["w_visitor_address"];
        $this->visitor_address->AdvancedSearch->save();

        // Field address_of_rujukan
        $this->address_of_rujukan->AdvancedSearch->SearchValue = @$filter["x_address_of_rujukan"];
        $this->address_of_rujukan->AdvancedSearch->SearchOperator = @$filter["z_address_of_rujukan"];
        $this->address_of_rujukan->AdvancedSearch->SearchCondition = @$filter["v_address_of_rujukan"];
        $this->address_of_rujukan->AdvancedSearch->SearchValue2 = @$filter["y_address_of_rujukan"];
        $this->address_of_rujukan->AdvancedSearch->SearchOperator2 = @$filter["w_address_of_rujukan"];
        $this->address_of_rujukan->AdvancedSearch->save();

        // Field rujukan_id
        $this->rujukan_id->AdvancedSearch->SearchValue = @$filter["x_rujukan_id"];
        $this->rujukan_id->AdvancedSearch->SearchOperator = @$filter["z_rujukan_id"];
        $this->rujukan_id->AdvancedSearch->SearchCondition = @$filter["v_rujukan_id"];
        $this->rujukan_id->AdvancedSearch->SearchValue2 = @$filter["y_rujukan_id"];
        $this->rujukan_id->AdvancedSearch->SearchOperator2 = @$filter["w_rujukan_id"];
        $this->rujukan_id->AdvancedSearch->save();

        // Field patient_category_id
        $this->patient_category_id->AdvancedSearch->SearchValue = @$filter["x_patient_category_id"];
        $this->patient_category_id->AdvancedSearch->SearchOperator = @$filter["z_patient_category_id"];
        $this->patient_category_id->AdvancedSearch->SearchCondition = @$filter["v_patient_category_id"];
        $this->patient_category_id->AdvancedSearch->SearchValue2 = @$filter["y_patient_category_id"];
        $this->patient_category_id->AdvancedSearch->SearchOperator2 = @$filter["w_patient_category_id"];
        $this->patient_category_id->AdvancedSearch->save();

        // Field payor_id
        $this->payor_id->AdvancedSearch->SearchValue = @$filter["x_payor_id"];
        $this->payor_id->AdvancedSearch->SearchOperator = @$filter["z_payor_id"];
        $this->payor_id->AdvancedSearch->SearchCondition = @$filter["v_payor_id"];
        $this->payor_id->AdvancedSearch->SearchValue2 = @$filter["y_payor_id"];
        $this->payor_id->AdvancedSearch->SearchOperator2 = @$filter["w_payor_id"];
        $this->payor_id->AdvancedSearch->save();

        // Field reason_id
        $this->reason_id->AdvancedSearch->SearchValue = @$filter["x_reason_id"];
        $this->reason_id->AdvancedSearch->SearchOperator = @$filter["z_reason_id"];
        $this->reason_id->AdvancedSearch->SearchCondition = @$filter["v_reason_id"];
        $this->reason_id->AdvancedSearch->SearchValue2 = @$filter["y_reason_id"];
        $this->reason_id->AdvancedSearch->SearchOperator2 = @$filter["w_reason_id"];
        $this->reason_id->AdvancedSearch->save();

        // Field DESCRIPTION
        $this->DESCRIPTION->AdvancedSearch->SearchValue = @$filter["x_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator = @$filter["z_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchCondition = @$filter["v_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchValue2 = @$filter["y_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator2 = @$filter["w_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->save();

        // Field way_id
        $this->way_id->AdvancedSearch->SearchValue = @$filter["x_way_id"];
        $this->way_id->AdvancedSearch->SearchOperator = @$filter["z_way_id"];
        $this->way_id->AdvancedSearch->SearchCondition = @$filter["v_way_id"];
        $this->way_id->AdvancedSearch->SearchValue2 = @$filter["y_way_id"];
        $this->way_id->AdvancedSearch->SearchOperator2 = @$filter["w_way_id"];
        $this->way_id->AdvancedSearch->save();

        // Field follow_up
        $this->follow_up->AdvancedSearch->SearchValue = @$filter["x_follow_up"];
        $this->follow_up->AdvancedSearch->SearchOperator = @$filter["z_follow_up"];
        $this->follow_up->AdvancedSearch->SearchCondition = @$filter["v_follow_up"];
        $this->follow_up->AdvancedSearch->SearchValue2 = @$filter["y_follow_up"];
        $this->follow_up->AdvancedSearch->SearchOperator2 = @$filter["w_follow_up"];
        $this->follow_up->AdvancedSearch->save();

        // Field isnew
        $this->isnew->AdvancedSearch->SearchValue = @$filter["x_isnew"];
        $this->isnew->AdvancedSearch->SearchOperator = @$filter["z_isnew"];
        $this->isnew->AdvancedSearch->SearchCondition = @$filter["v_isnew"];
        $this->isnew->AdvancedSearch->SearchValue2 = @$filter["y_isnew"];
        $this->isnew->AdvancedSearch->SearchOperator2 = @$filter["w_isnew"];
        $this->isnew->AdvancedSearch->save();

        // Field family_status_id
        $this->family_status_id->AdvancedSearch->SearchValue = @$filter["x_family_status_id"];
        $this->family_status_id->AdvancedSearch->SearchOperator = @$filter["z_family_status_id"];
        $this->family_status_id->AdvancedSearch->SearchCondition = @$filter["v_family_status_id"];
        $this->family_status_id->AdvancedSearch->SearchValue2 = @$filter["y_family_status_id"];
        $this->family_status_id->AdvancedSearch->SearchOperator2 = @$filter["w_family_status_id"];
        $this->family_status_id->AdvancedSearch->save();

        // Field class_room_id
        $this->class_room_id->AdvancedSearch->SearchValue = @$filter["x_class_room_id"];
        $this->class_room_id->AdvancedSearch->SearchOperator = @$filter["z_class_room_id"];
        $this->class_room_id->AdvancedSearch->SearchCondition = @$filter["v_class_room_id"];
        $this->class_room_id->AdvancedSearch->SearchValue2 = @$filter["y_class_room_id"];
        $this->class_room_id->AdvancedSearch->SearchOperator2 = @$filter["w_class_room_id"];
        $this->class_room_id->AdvancedSearch->save();

        // Field STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue = @$filter["x_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator = @$filter["z_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchCondition = @$filter["v_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->save();

        // Field fullname
        $this->fullname->AdvancedSearch->SearchValue = @$filter["x_fullname"];
        $this->fullname->AdvancedSearch->SearchOperator = @$filter["z_fullname"];
        $this->fullname->AdvancedSearch->SearchCondition = @$filter["v_fullname"];
        $this->fullname->AdvancedSearch->SearchValue2 = @$filter["y_fullname"];
        $this->fullname->AdvancedSearch->SearchOperator2 = @$filter["w_fullname"];
        $this->fullname->AdvancedSearch->save();

        // Field employee_id
        $this->employee_id->AdvancedSearch->SearchValue = @$filter["x_employee_id"];
        $this->employee_id->AdvancedSearch->SearchOperator = @$filter["z_employee_id"];
        $this->employee_id->AdvancedSearch->SearchCondition = @$filter["v_employee_id"];
        $this->employee_id->AdvancedSearch->SearchValue2 = @$filter["y_employee_id"];
        $this->employee_id->AdvancedSearch->SearchOperator2 = @$filter["w_employee_id"];
        $this->employee_id->AdvancedSearch->save();

        // Field employee_id_from
        $this->employee_id_from->AdvancedSearch->SearchValue = @$filter["x_employee_id_from"];
        $this->employee_id_from->AdvancedSearch->SearchOperator = @$filter["z_employee_id_from"];
        $this->employee_id_from->AdvancedSearch->SearchCondition = @$filter["v_employee_id_from"];
        $this->employee_id_from->AdvancedSearch->SearchValue2 = @$filter["y_employee_id_from"];
        $this->employee_id_from->AdvancedSearch->SearchOperator2 = @$filter["w_employee_id_from"];
        $this->employee_id_from->AdvancedSearch->save();

        // Field clinic_id
        $this->clinic_id->AdvancedSearch->SearchValue = @$filter["x_clinic_id"];
        $this->clinic_id->AdvancedSearch->SearchOperator = @$filter["z_clinic_id"];
        $this->clinic_id->AdvancedSearch->SearchCondition = @$filter["v_clinic_id"];
        $this->clinic_id->AdvancedSearch->SearchValue2 = @$filter["y_clinic_id"];
        $this->clinic_id->AdvancedSearch->SearchOperator2 = @$filter["w_clinic_id"];
        $this->clinic_id->AdvancedSearch->save();

        // Field clinic_id_FROM
        $this->clinic_id_FROM->AdvancedSearch->SearchValue = @$filter["x_clinic_id_FROM"];
        $this->clinic_id_FROM->AdvancedSearch->SearchOperator = @$filter["z_clinic_id_FROM"];
        $this->clinic_id_FROM->AdvancedSearch->SearchCondition = @$filter["v_clinic_id_FROM"];
        $this->clinic_id_FROM->AdvancedSearch->SearchValue2 = @$filter["y_clinic_id_FROM"];
        $this->clinic_id_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_clinic_id_FROM"];
        $this->clinic_id_FROM->AdvancedSearch->save();

        // Field doctor
        $this->doctor->AdvancedSearch->SearchValue = @$filter["x_doctor"];
        $this->doctor->AdvancedSearch->SearchOperator = @$filter["z_doctor"];
        $this->doctor->AdvancedSearch->SearchCondition = @$filter["v_doctor"];
        $this->doctor->AdvancedSearch->SearchValue2 = @$filter["y_doctor"];
        $this->doctor->AdvancedSearch->SearchOperator2 = @$filter["w_doctor"];
        $this->doctor->AdvancedSearch->save();

        // Field bed_id
        $this->bed_id->AdvancedSearch->SearchValue = @$filter["x_bed_id"];
        $this->bed_id->AdvancedSearch->SearchOperator = @$filter["z_bed_id"];
        $this->bed_id->AdvancedSearch->SearchCondition = @$filter["v_bed_id"];
        $this->bed_id->AdvancedSearch->SearchValue2 = @$filter["y_bed_id"];
        $this->bed_id->AdvancedSearch->SearchOperator2 = @$filter["w_bed_id"];
        $this->bed_id->AdvancedSearch->save();

        // Field keluar_id
        $this->keluar_id->AdvancedSearch->SearchValue = @$filter["x_keluar_id"];
        $this->keluar_id->AdvancedSearch->SearchOperator = @$filter["z_keluar_id"];
        $this->keluar_id->AdvancedSearch->SearchCondition = @$filter["v_keluar_id"];
        $this->keluar_id->AdvancedSearch->SearchValue2 = @$filter["y_keluar_id"];
        $this->keluar_id->AdvancedSearch->SearchOperator2 = @$filter["w_keluar_id"];
        $this->keluar_id->AdvancedSearch->save();

        // Field treat_date
        $this->treat_date->AdvancedSearch->SearchValue = @$filter["x_treat_date"];
        $this->treat_date->AdvancedSearch->SearchOperator = @$filter["z_treat_date"];
        $this->treat_date->AdvancedSearch->SearchCondition = @$filter["v_treat_date"];
        $this->treat_date->AdvancedSearch->SearchValue2 = @$filter["y_treat_date"];
        $this->treat_date->AdvancedSearch->SearchOperator2 = @$filter["w_treat_date"];
        $this->treat_date->AdvancedSearch->save();

        // Field exit_date
        $this->exit_date->AdvancedSearch->SearchValue = @$filter["x_exit_date"];
        $this->exit_date->AdvancedSearch->SearchOperator = @$filter["z_exit_date"];
        $this->exit_date->AdvancedSearch->SearchCondition = @$filter["v_exit_date"];
        $this->exit_date->AdvancedSearch->SearchValue2 = @$filter["y_exit_date"];
        $this->exit_date->AdvancedSearch->SearchOperator2 = @$filter["w_exit_date"];
        $this->exit_date->AdvancedSearch->save();

        // Field name_of_class
        $this->name_of_class->AdvancedSearch->SearchValue = @$filter["x_name_of_class"];
        $this->name_of_class->AdvancedSearch->SearchOperator = @$filter["z_name_of_class"];
        $this->name_of_class->AdvancedSearch->SearchCondition = @$filter["v_name_of_class"];
        $this->name_of_class->AdvancedSearch->SearchValue2 = @$filter["y_name_of_class"];
        $this->name_of_class->AdvancedSearch->SearchOperator2 = @$filter["w_name_of_class"];
        $this->name_of_class->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->NAME_OF_PASIEN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NO_REGISTRATION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CONTACT_ADDRESS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PHONE_NUMBER, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MOBILE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KAL_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PLACE_OF_BIRTH, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KALURAHAN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->name_of_clinic, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->visit_id, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isattended, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->diantar_oleh, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->visitor_address, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->address_of_rujukan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->payor_id, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DESCRIPTION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isnew, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->class_room_id, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->fullname, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->employee_id, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->employee_id_from, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->clinic_id, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->clinic_id_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->doctor, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->name_of_class, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->NAME_OF_PASIEN); // NAME_OF_PASIEN
            $this->updateSort($this->NO_REGISTRATION); // NO_REGISTRATION
            $this->updateSort($this->ORG_UNIT_CODE); // ORG_UNIT_CODE
            $this->updateSort($this->date_of_birth); // date_of_birth
            $this->updateSort($this->CONTACT_ADDRESS); // CONTACT_ADDRESS
            $this->updateSort($this->PHONE_NUMBER); // PHONE_NUMBER
            $this->updateSort($this->MOBILE); // MOBILE
            $this->updateSort($this->KAL_ID); // KAL_ID
            $this->updateSort($this->PLACE_OF_BIRTH); // PLACE_OF_BIRTH
            $this->updateSort($this->KALURAHAN); // KALURAHAN
            $this->updateSort($this->name_of_clinic); // name_of_clinic
            $this->updateSort($this->booked_Date); // booked_Date
            $this->updateSort($this->visit_date); // visit_date
            $this->updateSort($this->visit_id); // visit_id
            $this->updateSort($this->isattended); // isattended
            $this->updateSort($this->diantar_oleh); // diantar_oleh
            $this->updateSort($this->visitor_address); // visitor_address
            $this->updateSort($this->address_of_rujukan); // address_of_rujukan
            $this->updateSort($this->rujukan_id); // rujukan_id
            $this->updateSort($this->patient_category_id); // patient_category_id
            $this->updateSort($this->payor_id); // payor_id
            $this->updateSort($this->reason_id); // reason_id
            $this->updateSort($this->DESCRIPTION); // DESCRIPTION
            $this->updateSort($this->way_id); // way_id
            $this->updateSort($this->follow_up); // follow_up
            $this->updateSort($this->isnew); // isnew
            $this->updateSort($this->family_status_id); // family_status_id
            $this->updateSort($this->class_room_id); // class_room_id
            $this->updateSort($this->STATUS_PASIEN_ID); // STATUS_PASIEN_ID
            $this->updateSort($this->fullname); // fullname
            $this->updateSort($this->employee_id); // employee_id
            $this->updateSort($this->employee_id_from); // employee_id_from
            $this->updateSort($this->clinic_id); // clinic_id
            $this->updateSort($this->clinic_id_FROM); // clinic_id_FROM
            $this->updateSort($this->doctor); // doctor
            $this->updateSort($this->bed_id); // bed_id
            $this->updateSort($this->keluar_id); // keluar_id
            $this->updateSort($this->treat_date); // treat_date
            $this->updateSort($this->exit_date); // exit_date
            $this->updateSort($this->name_of_class); // name_of_class
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "[visit_date] DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->visit_date->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->visit_date->setSort("DESC");
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->NAME_OF_PASIEN->setSort("");
                $this->NO_REGISTRATION->setSort("");
                $this->ORG_UNIT_CODE->setSort("");
                $this->date_of_birth->setSort("");
                $this->CONTACT_ADDRESS->setSort("");
                $this->PHONE_NUMBER->setSort("");
                $this->MOBILE->setSort("");
                $this->KAL_ID->setSort("");
                $this->PLACE_OF_BIRTH->setSort("");
                $this->KALURAHAN->setSort("");
                $this->name_of_clinic->setSort("");
                $this->booked_Date->setSort("");
                $this->visit_date->setSort("");
                $this->visit_id->setSort("");
                $this->isattended->setSort("");
                $this->diantar_oleh->setSort("");
                $this->visitor_address->setSort("");
                $this->address_of_rujukan->setSort("");
                $this->rujukan_id->setSort("");
                $this->patient_category_id->setSort("");
                $this->payor_id->setSort("");
                $this->reason_id->setSort("");
                $this->DESCRIPTION->setSort("");
                $this->way_id->setSort("");
                $this->follow_up->setSort("");
                $this->isnew->setSort("");
                $this->family_status_id->setSort("");
                $this->class_room_id->setSort("");
                $this->STATUS_PASIEN_ID->setSort("");
                $this->fullname->setSort("");
                $this->employee_id->setSort("");
                $this->employee_id_from->setSort("");
                $this->clinic_id->setSort("");
                $this->clinic_id_FROM->setSort("");
                $this->doctor->setSort("");
                $this->bed_id->setSort("");
                $this->keluar_id->setSort("");
                $this->treat_date->setSort("");
                $this->exit_date->setSort("");
                $this->name_of_class->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->moveTo(0);
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = true;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") { // View mode
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->visit_id->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fV_TREATMENTBILLlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fV_TREATMENTBILLlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fV_TREATMENTBILLlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->NAME_OF_PASIEN->setDbValue($row['NAME_OF_PASIEN']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->date_of_birth->setDbValue($row['date_of_birth']);
        $this->CONTACT_ADDRESS->setDbValue($row['CONTACT_ADDRESS']);
        $this->PHONE_NUMBER->setDbValue($row['PHONE_NUMBER']);
        $this->MOBILE->setDbValue($row['MOBILE']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->PLACE_OF_BIRTH->setDbValue($row['PLACE_OF_BIRTH']);
        $this->KALURAHAN->setDbValue($row['KALURAHAN']);
        $this->name_of_clinic->setDbValue($row['name_of_clinic']);
        $this->booked_Date->setDbValue($row['booked_Date']);
        $this->visit_date->setDbValue($row['visit_date']);
        $this->visit_id->setDbValue($row['visit_id']);
        $this->isattended->setDbValue($row['isattended']);
        $this->diantar_oleh->setDbValue($row['diantar_oleh']);
        $this->visitor_address->setDbValue($row['visitor_address']);
        $this->address_of_rujukan->setDbValue($row['address_of_rujukan']);
        $this->rujukan_id->setDbValue($row['rujukan_id']);
        $this->patient_category_id->setDbValue($row['patient_category_id']);
        $this->payor_id->setDbValue($row['payor_id']);
        $this->reason_id->setDbValue($row['reason_id']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->way_id->setDbValue($row['way_id']);
        $this->follow_up->setDbValue($row['follow_up']);
        $this->isnew->setDbValue($row['isnew']);
        $this->family_status_id->setDbValue($row['family_status_id']);
        $this->class_room_id->setDbValue($row['class_room_id']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->fullname->setDbValue($row['fullname']);
        $this->employee_id->setDbValue($row['employee_id']);
        $this->employee_id_from->setDbValue($row['employee_id_from']);
        $this->clinic_id->setDbValue($row['clinic_id']);
        $this->clinic_id_FROM->setDbValue($row['clinic_id_FROM']);
        $this->doctor->setDbValue($row['doctor']);
        $this->bed_id->setDbValue($row['bed_id']);
        $this->keluar_id->setDbValue($row['keluar_id']);
        $this->treat_date->setDbValue($row['treat_date']);
        $this->exit_date->setDbValue($row['exit_date']);
        $this->name_of_class->setDbValue($row['name_of_class']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['NAME_OF_PASIEN'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['ORG_UNIT_CODE'] = null;
        $row['date_of_birth'] = null;
        $row['CONTACT_ADDRESS'] = null;
        $row['PHONE_NUMBER'] = null;
        $row['MOBILE'] = null;
        $row['KAL_ID'] = null;
        $row['PLACE_OF_BIRTH'] = null;
        $row['KALURAHAN'] = null;
        $row['name_of_clinic'] = null;
        $row['booked_Date'] = null;
        $row['visit_date'] = null;
        $row['visit_id'] = null;
        $row['isattended'] = null;
        $row['diantar_oleh'] = null;
        $row['visitor_address'] = null;
        $row['address_of_rujukan'] = null;
        $row['rujukan_id'] = null;
        $row['patient_category_id'] = null;
        $row['payor_id'] = null;
        $row['reason_id'] = null;
        $row['DESCRIPTION'] = null;
        $row['way_id'] = null;
        $row['follow_up'] = null;
        $row['isnew'] = null;
        $row['family_status_id'] = null;
        $row['class_room_id'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['fullname'] = null;
        $row['employee_id'] = null;
        $row['employee_id_from'] = null;
        $row['clinic_id'] = null;
        $row['clinic_id_FROM'] = null;
        $row['doctor'] = null;
        $row['bed_id'] = null;
        $row['keluar_id'] = null;
        $row['treat_date'] = null;
        $row['exit_date'] = null;
        $row['name_of_class'] = null;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // NAME_OF_PASIEN

        // NO_REGISTRATION

        // ORG_UNIT_CODE

        // date_of_birth

        // CONTACT_ADDRESS

        // PHONE_NUMBER

        // MOBILE

        // KAL_ID

        // PLACE_OF_BIRTH

        // KALURAHAN

        // name_of_clinic

        // booked_Date

        // visit_date

        // visit_id

        // isattended

        // diantar_oleh

        // visitor_address

        // address_of_rujukan

        // rujukan_id

        // patient_category_id

        // payor_id

        // reason_id

        // DESCRIPTION

        // way_id

        // follow_up

        // isnew

        // family_status_id

        // class_room_id

        // STATUS_PASIEN_ID

        // fullname

        // employee_id

        // employee_id_from

        // clinic_id

        // clinic_id_FROM

        // doctor

        // bed_id

        // keluar_id

        // treat_date

        // exit_date

        // name_of_class
        if ($this->RowType == ROWTYPE_VIEW) {
            // NAME_OF_PASIEN
            $this->NAME_OF_PASIEN->ViewValue = $this->NAME_OF_PASIEN->CurrentValue;
            $this->NAME_OF_PASIEN->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // date_of_birth
            $this->date_of_birth->ViewValue = $this->date_of_birth->CurrentValue;
            $this->date_of_birth->ViewValue = FormatDateTime($this->date_of_birth->ViewValue, 0);
            $this->date_of_birth->ViewCustomAttributes = "";

            // CONTACT_ADDRESS
            $this->CONTACT_ADDRESS->ViewValue = $this->CONTACT_ADDRESS->CurrentValue;
            $this->CONTACT_ADDRESS->ViewCustomAttributes = "";

            // PHONE_NUMBER
            $this->PHONE_NUMBER->ViewValue = $this->PHONE_NUMBER->CurrentValue;
            $this->PHONE_NUMBER->ViewCustomAttributes = "";

            // MOBILE
            $this->MOBILE->ViewValue = $this->MOBILE->CurrentValue;
            $this->MOBILE->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // PLACE_OF_BIRTH
            $this->PLACE_OF_BIRTH->ViewValue = $this->PLACE_OF_BIRTH->CurrentValue;
            $this->PLACE_OF_BIRTH->ViewCustomAttributes = "";

            // KALURAHAN
            $this->KALURAHAN->ViewValue = $this->KALURAHAN->CurrentValue;
            $this->KALURAHAN->ViewCustomAttributes = "";

            // name_of_clinic
            $this->name_of_clinic->ViewValue = $this->name_of_clinic->CurrentValue;
            $this->name_of_clinic->ViewCustomAttributes = "";

            // booked_Date
            $this->booked_Date->ViewValue = $this->booked_Date->CurrentValue;
            $this->booked_Date->ViewValue = FormatDateTime($this->booked_Date->ViewValue, 0);
            $this->booked_Date->ViewCustomAttributes = "";

            // visit_date
            $this->visit_date->ViewValue = $this->visit_date->CurrentValue;
            $this->visit_date->ViewValue = FormatDateTime($this->visit_date->ViewValue, 0);
            $this->visit_date->ViewCustomAttributes = "";

            // visit_id
            $this->visit_id->ViewValue = $this->visit_id->CurrentValue;
            $this->visit_id->ViewCustomAttributes = "";

            // isattended
            $this->isattended->ViewValue = $this->isattended->CurrentValue;
            $this->isattended->ViewCustomAttributes = "";

            // diantar_oleh
            $this->diantar_oleh->ViewValue = $this->diantar_oleh->CurrentValue;
            $this->diantar_oleh->ViewCustomAttributes = "";

            // visitor_address
            $this->visitor_address->ViewValue = $this->visitor_address->CurrentValue;
            $this->visitor_address->ViewCustomAttributes = "";

            // address_of_rujukan
            $this->address_of_rujukan->ViewValue = $this->address_of_rujukan->CurrentValue;
            $this->address_of_rujukan->ViewCustomAttributes = "";

            // rujukan_id
            $this->rujukan_id->ViewValue = $this->rujukan_id->CurrentValue;
            $this->rujukan_id->ViewValue = FormatNumber($this->rujukan_id->ViewValue, 0, -2, -2, -2);
            $this->rujukan_id->ViewCustomAttributes = "";

            // patient_category_id
            $this->patient_category_id->ViewValue = $this->patient_category_id->CurrentValue;
            $this->patient_category_id->ViewValue = FormatNumber($this->patient_category_id->ViewValue, 0, -2, -2, -2);
            $this->patient_category_id->ViewCustomAttributes = "";

            // payor_id
            $this->payor_id->ViewValue = $this->payor_id->CurrentValue;
            $this->payor_id->ViewCustomAttributes = "";

            // reason_id
            $this->reason_id->ViewValue = $this->reason_id->CurrentValue;
            $this->reason_id->ViewValue = FormatNumber($this->reason_id->ViewValue, 0, -2, -2, -2);
            $this->reason_id->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // way_id
            $this->way_id->ViewValue = $this->way_id->CurrentValue;
            $this->way_id->ViewValue = FormatNumber($this->way_id->ViewValue, 0, -2, -2, -2);
            $this->way_id->ViewCustomAttributes = "";

            // follow_up
            $this->follow_up->ViewValue = $this->follow_up->CurrentValue;
            $this->follow_up->ViewValue = FormatNumber($this->follow_up->ViewValue, 0, -2, -2, -2);
            $this->follow_up->ViewCustomAttributes = "";

            // isnew
            $this->isnew->ViewValue = $this->isnew->CurrentValue;
            $this->isnew->ViewCustomAttributes = "";

            // family_status_id
            $this->family_status_id->ViewValue = $this->family_status_id->CurrentValue;
            $this->family_status_id->ViewValue = FormatNumber($this->family_status_id->ViewValue, 0, -2, -2, -2);
            $this->family_status_id->ViewCustomAttributes = "";

            // class_room_id
            $this->class_room_id->ViewValue = $this->class_room_id->CurrentValue;
            $this->class_room_id->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // fullname
            $this->fullname->ViewValue = $this->fullname->CurrentValue;
            $this->fullname->ViewCustomAttributes = "";

            // employee_id
            $this->employee_id->ViewValue = $this->employee_id->CurrentValue;
            $this->employee_id->ViewCustomAttributes = "";

            // employee_id_from
            $this->employee_id_from->ViewValue = $this->employee_id_from->CurrentValue;
            $this->employee_id_from->ViewCustomAttributes = "";

            // clinic_id
            $this->clinic_id->ViewValue = $this->clinic_id->CurrentValue;
            $this->clinic_id->ViewCustomAttributes = "";

            // clinic_id_FROM
            $this->clinic_id_FROM->ViewValue = $this->clinic_id_FROM->CurrentValue;
            $this->clinic_id_FROM->ViewCustomAttributes = "";

            // doctor
            $this->doctor->ViewValue = $this->doctor->CurrentValue;
            $this->doctor->ViewCustomAttributes = "";

            // bed_id
            $this->bed_id->ViewValue = $this->bed_id->CurrentValue;
            $this->bed_id->ViewValue = FormatNumber($this->bed_id->ViewValue, 0, -2, -2, -2);
            $this->bed_id->ViewCustomAttributes = "";

            // keluar_id
            $this->keluar_id->ViewValue = $this->keluar_id->CurrentValue;
            $this->keluar_id->ViewValue = FormatNumber($this->keluar_id->ViewValue, 0, -2, -2, -2);
            $this->keluar_id->ViewCustomAttributes = "";

            // treat_date
            $this->treat_date->ViewValue = $this->treat_date->CurrentValue;
            $this->treat_date->ViewValue = FormatDateTime($this->treat_date->ViewValue, 0);
            $this->treat_date->ViewCustomAttributes = "";

            // exit_date
            $this->exit_date->ViewValue = $this->exit_date->CurrentValue;
            $this->exit_date->ViewValue = FormatDateTime($this->exit_date->ViewValue, 0);
            $this->exit_date->ViewCustomAttributes = "";

            // name_of_class
            $this->name_of_class->ViewValue = $this->name_of_class->CurrentValue;
            $this->name_of_class->ViewCustomAttributes = "";

            // NAME_OF_PASIEN
            $this->NAME_OF_PASIEN->LinkCustomAttributes = "";
            $this->NAME_OF_PASIEN->HrefValue = "";
            $this->NAME_OF_PASIEN->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // date_of_birth
            $this->date_of_birth->LinkCustomAttributes = "";
            $this->date_of_birth->HrefValue = "";
            $this->date_of_birth->TooltipValue = "";

            // CONTACT_ADDRESS
            $this->CONTACT_ADDRESS->LinkCustomAttributes = "";
            $this->CONTACT_ADDRESS->HrefValue = "";
            $this->CONTACT_ADDRESS->TooltipValue = "";

            // PHONE_NUMBER
            $this->PHONE_NUMBER->LinkCustomAttributes = "";
            $this->PHONE_NUMBER->HrefValue = "";
            $this->PHONE_NUMBER->TooltipValue = "";

            // MOBILE
            $this->MOBILE->LinkCustomAttributes = "";
            $this->MOBILE->HrefValue = "";
            $this->MOBILE->TooltipValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";
            $this->KAL_ID->TooltipValue = "";

            // PLACE_OF_BIRTH
            $this->PLACE_OF_BIRTH->LinkCustomAttributes = "";
            $this->PLACE_OF_BIRTH->HrefValue = "";
            $this->PLACE_OF_BIRTH->TooltipValue = "";

            // KALURAHAN
            $this->KALURAHAN->LinkCustomAttributes = "";
            $this->KALURAHAN->HrefValue = "";
            $this->KALURAHAN->TooltipValue = "";

            // name_of_clinic
            $this->name_of_clinic->LinkCustomAttributes = "";
            $this->name_of_clinic->HrefValue = "";
            $this->name_of_clinic->TooltipValue = "";

            // booked_Date
            $this->booked_Date->LinkCustomAttributes = "";
            $this->booked_Date->HrefValue = "";
            $this->booked_Date->TooltipValue = "";

            // visit_date
            $this->visit_date->LinkCustomAttributes = "";
            $this->visit_date->HrefValue = "";
            $this->visit_date->TooltipValue = "";

            // visit_id
            $this->visit_id->LinkCustomAttributes = "";
            $this->visit_id->HrefValue = "";
            $this->visit_id->TooltipValue = "";

            // isattended
            $this->isattended->LinkCustomAttributes = "";
            $this->isattended->HrefValue = "";
            $this->isattended->TooltipValue = "";

            // diantar_oleh
            $this->diantar_oleh->LinkCustomAttributes = "";
            $this->diantar_oleh->HrefValue = "";
            $this->diantar_oleh->TooltipValue = "";

            // visitor_address
            $this->visitor_address->LinkCustomAttributes = "";
            $this->visitor_address->HrefValue = "";
            $this->visitor_address->TooltipValue = "";

            // address_of_rujukan
            $this->address_of_rujukan->LinkCustomAttributes = "";
            $this->address_of_rujukan->HrefValue = "";
            $this->address_of_rujukan->TooltipValue = "";

            // rujukan_id
            $this->rujukan_id->LinkCustomAttributes = "";
            $this->rujukan_id->HrefValue = "";
            $this->rujukan_id->TooltipValue = "";

            // patient_category_id
            $this->patient_category_id->LinkCustomAttributes = "";
            $this->patient_category_id->HrefValue = "";
            $this->patient_category_id->TooltipValue = "";

            // payor_id
            $this->payor_id->LinkCustomAttributes = "";
            $this->payor_id->HrefValue = "";
            $this->payor_id->TooltipValue = "";

            // reason_id
            $this->reason_id->LinkCustomAttributes = "";
            $this->reason_id->HrefValue = "";
            $this->reason_id->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // way_id
            $this->way_id->LinkCustomAttributes = "";
            $this->way_id->HrefValue = "";
            $this->way_id->TooltipValue = "";

            // follow_up
            $this->follow_up->LinkCustomAttributes = "";
            $this->follow_up->HrefValue = "";
            $this->follow_up->TooltipValue = "";

            // isnew
            $this->isnew->LinkCustomAttributes = "";
            $this->isnew->HrefValue = "";
            $this->isnew->TooltipValue = "";

            // family_status_id
            $this->family_status_id->LinkCustomAttributes = "";
            $this->family_status_id->HrefValue = "";
            $this->family_status_id->TooltipValue = "";

            // class_room_id
            $this->class_room_id->LinkCustomAttributes = "";
            $this->class_room_id->HrefValue = "";
            $this->class_room_id->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // fullname
            $this->fullname->LinkCustomAttributes = "";
            $this->fullname->HrefValue = "";
            $this->fullname->TooltipValue = "";

            // employee_id
            $this->employee_id->LinkCustomAttributes = "";
            $this->employee_id->HrefValue = "";
            $this->employee_id->TooltipValue = "";

            // employee_id_from
            $this->employee_id_from->LinkCustomAttributes = "";
            $this->employee_id_from->HrefValue = "";
            $this->employee_id_from->TooltipValue = "";

            // clinic_id
            $this->clinic_id->LinkCustomAttributes = "";
            $this->clinic_id->HrefValue = "";
            $this->clinic_id->TooltipValue = "";

            // clinic_id_FROM
            $this->clinic_id_FROM->LinkCustomAttributes = "";
            $this->clinic_id_FROM->HrefValue = "";
            $this->clinic_id_FROM->TooltipValue = "";

            // doctor
            $this->doctor->LinkCustomAttributes = "";
            $this->doctor->HrefValue = "";
            $this->doctor->TooltipValue = "";

            // bed_id
            $this->bed_id->LinkCustomAttributes = "";
            $this->bed_id->HrefValue = "";
            $this->bed_id->TooltipValue = "";

            // keluar_id
            $this->keluar_id->LinkCustomAttributes = "";
            $this->keluar_id->HrefValue = "";
            $this->keluar_id->TooltipValue = "";

            // treat_date
            $this->treat_date->LinkCustomAttributes = "";
            $this->treat_date->HrefValue = "";
            $this->treat_date->TooltipValue = "";

            // exit_date
            $this->exit_date->LinkCustomAttributes = "";
            $this->exit_date->HrefValue = "";
            $this->exit_date->TooltipValue = "";

            // name_of_class
            $this->name_of_class->LinkCustomAttributes = "";
            $this->name_of_class->HrefValue = "";
            $this->name_of_class->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fV_TREATMENTBILLlist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fV_TREATMENTBILLlist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fV_TREATMENTBILLlist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\">" . $Language->phrase("ExportToPDF") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ",url:'" . $pageUrl . "export=email&amp;custom=1'" : "";
            return '<button id="emf_V_TREATMENTBILL" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_V_TREATMENTBILL\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fV_TREATMENTBILLlist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = false;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = false;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to Html
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to Xml
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to Csv
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to Pdf
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->add($this->ExportOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fV_TREATMENTBILLlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
