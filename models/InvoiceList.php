<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class InvoiceList extends Invoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'INVOICE';

    // Page object name
    public $PageObjName = "InvoiceList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fINVOICElist";
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

        // Table object (INVOICE)
        if (!isset($GLOBALS["INVOICE"]) || get_class($GLOBALS["INVOICE"]) == PROJECT_NAMESPACE . "INVOICE") {
            $GLOBALS["INVOICE"] = &$this;
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
        $this->AddUrl = "InvoiceAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "InvoiceDelete";
        $this->MultiUpdateUrl = "InvoiceUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'INVOICE');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fINVOICElistsrch";

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
                $doc = new $class(Container("INVOICE"));
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
            $key .= @$ar['ORG_UNIT_CODE'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['INVOICE_ID'];
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
    public $PageSizes = "5,10,20,50,-1"; // Page sizes (comma separated)
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
    public $MultiColumnClass = "col-sm-3";
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
        $this->ORG_UNIT_CODE->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->INVOICE_TYPE->setVisibility();
        $this->INVOICE_NO->setVisibility();
        $this->INV_COUNTER->setVisibility();
        $this->INV_DATE->setVisibility();
        $this->INVOICE_TRANS->setVisibility();
        $this->INVOICE_DUE->setVisibility();
        $this->REF_TYPE->setVisibility();
        $this->REF_NO->setVisibility();
        $this->REF_NO2->setVisibility();
        $this->REF_DATE->setVisibility();
        $this->ACCOUNT_ID->setVisibility();
        $this->YEAR_ID->setVisibility();
        $this->ORG_ID->setVisibility();
        $this->PROGRAM_ID->setVisibility();
        $this->PROGRAMS->setVisibility();
        $this->PACTIVITY_ID->setVisibility();
        $this->ACTIVITY_ID->setVisibility();
        $this->ACTIVITY_NAME->setVisibility();
        $this->KEPERLUAN->setVisibility();
        $this->PPTK->setVisibility();
        $this->PPTK_NAME->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->COMPANY_TO->setVisibility();
        $this->COMPANY_TYPE->setVisibility();
        $this->COMPANY->setVisibility();
        $this->COMPANY_CHIEF->setVisibility();
        $this->COMPANY_INFO->setVisibility();
        $this->CONTRACT_NO->setVisibility();
        $this->NPWP->setVisibility();
        $this->COMPANY_BANK->setVisibility();
        $this->COMPANY_ACCOUNT->setVisibility();
        $this->PAGU->setVisibility();
        $this->PAGU_REALISASI->setVisibility();
        $this->AMOUNT->setVisibility();
        $this->AMOUNT_PAID->setVisibility();
        $this->PAYMENT_INSTRUCTIONS->setVisibility();
        $this->ISAPPROVED->setVisibility();
        $this->APPROVED_BY->setVisibility();
        $this->APPROVED_DATE->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->PPTK_TITLE->setVisibility();
        $this->APPROVED_ID->setVisibility();
        $this->APPROVED_TITLE->setVisibility();
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
        $filterList = Concat($filterList, $this->ORG_UNIT_CODE->AdvancedSearch->toJson(), ","); // Field ORG_UNIT_CODE
        $filterList = Concat($filterList, $this->INVOICE_ID->AdvancedSearch->toJson(), ","); // Field INVOICE_ID
        $filterList = Concat($filterList, $this->INVOICE_TYPE->AdvancedSearch->toJson(), ","); // Field INVOICE_TYPE
        $filterList = Concat($filterList, $this->INVOICE_NO->AdvancedSearch->toJson(), ","); // Field INVOICE_NO
        $filterList = Concat($filterList, $this->INV_COUNTER->AdvancedSearch->toJson(), ","); // Field INV_COUNTER
        $filterList = Concat($filterList, $this->INV_DATE->AdvancedSearch->toJson(), ","); // Field INV_DATE
        $filterList = Concat($filterList, $this->INVOICE_TRANS->AdvancedSearch->toJson(), ","); // Field INVOICE_TRANS
        $filterList = Concat($filterList, $this->INVOICE_DUE->AdvancedSearch->toJson(), ","); // Field INVOICE_DUE
        $filterList = Concat($filterList, $this->REF_TYPE->AdvancedSearch->toJson(), ","); // Field REF_TYPE
        $filterList = Concat($filterList, $this->REF_NO->AdvancedSearch->toJson(), ","); // Field REF_NO
        $filterList = Concat($filterList, $this->REF_NO2->AdvancedSearch->toJson(), ","); // Field REF_NO2
        $filterList = Concat($filterList, $this->REF_DATE->AdvancedSearch->toJson(), ","); // Field REF_DATE
        $filterList = Concat($filterList, $this->ACCOUNT_ID->AdvancedSearch->toJson(), ","); // Field ACCOUNT_ID
        $filterList = Concat($filterList, $this->YEAR_ID->AdvancedSearch->toJson(), ","); // Field YEAR_ID
        $filterList = Concat($filterList, $this->ORG_ID->AdvancedSearch->toJson(), ","); // Field ORG_ID
        $filterList = Concat($filterList, $this->PROGRAM_ID->AdvancedSearch->toJson(), ","); // Field PROGRAM_ID
        $filterList = Concat($filterList, $this->PROGRAMS->AdvancedSearch->toJson(), ","); // Field PROGRAMS
        $filterList = Concat($filterList, $this->PACTIVITY_ID->AdvancedSearch->toJson(), ","); // Field PACTIVITY_ID
        $filterList = Concat($filterList, $this->ACTIVITY_ID->AdvancedSearch->toJson(), ","); // Field ACTIVITY_ID
        $filterList = Concat($filterList, $this->ACTIVITY_NAME->AdvancedSearch->toJson(), ","); // Field ACTIVITY_NAME
        $filterList = Concat($filterList, $this->KEPERLUAN->AdvancedSearch->toJson(), ","); // Field KEPERLUAN
        $filterList = Concat($filterList, $this->PPTK->AdvancedSearch->toJson(), ","); // Field PPTK
        $filterList = Concat($filterList, $this->PPTK_NAME->AdvancedSearch->toJson(), ","); // Field PPTK_NAME
        $filterList = Concat($filterList, $this->COMPANY_ID->AdvancedSearch->toJson(), ","); // Field COMPANY_ID
        $filterList = Concat($filterList, $this->COMPANY_TO->AdvancedSearch->toJson(), ","); // Field COMPANY_TO
        $filterList = Concat($filterList, $this->COMPANY_TYPE->AdvancedSearch->toJson(), ","); // Field COMPANY_TYPE
        $filterList = Concat($filterList, $this->COMPANY->AdvancedSearch->toJson(), ","); // Field COMPANY
        $filterList = Concat($filterList, $this->COMPANY_CHIEF->AdvancedSearch->toJson(), ","); // Field COMPANY_CHIEF
        $filterList = Concat($filterList, $this->COMPANY_INFO->AdvancedSearch->toJson(), ","); // Field COMPANY_INFO
        $filterList = Concat($filterList, $this->CONTRACT_NO->AdvancedSearch->toJson(), ","); // Field CONTRACT_NO
        $filterList = Concat($filterList, $this->NPWP->AdvancedSearch->toJson(), ","); // Field NPWP
        $filterList = Concat($filterList, $this->COMPANY_BANK->AdvancedSearch->toJson(), ","); // Field COMPANY_BANK
        $filterList = Concat($filterList, $this->COMPANY_ACCOUNT->AdvancedSearch->toJson(), ","); // Field COMPANY_ACCOUNT
        $filterList = Concat($filterList, $this->PAGU->AdvancedSearch->toJson(), ","); // Field PAGU
        $filterList = Concat($filterList, $this->PAGU_REALISASI->AdvancedSearch->toJson(), ","); // Field PAGU_REALISASI
        $filterList = Concat($filterList, $this->AMOUNT->AdvancedSearch->toJson(), ","); // Field AMOUNT
        $filterList = Concat($filterList, $this->AMOUNT_PAID->AdvancedSearch->toJson(), ","); // Field AMOUNT_PAID
        $filterList = Concat($filterList, $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->toJson(), ","); // Field PAYMENT_INSTRUCTIONS
        $filterList = Concat($filterList, $this->ISAPPROVED->AdvancedSearch->toJson(), ","); // Field ISAPPROVED
        $filterList = Concat($filterList, $this->APPROVED_BY->AdvancedSearch->toJson(), ","); // Field APPROVED_BY
        $filterList = Concat($filterList, $this->APPROVED_DATE->AdvancedSearch->toJson(), ","); // Field APPROVED_DATE
        $filterList = Concat($filterList, $this->ISCETAK->AdvancedSearch->toJson(), ","); // Field ISCETAK
        $filterList = Concat($filterList, $this->PRINTQ->AdvancedSearch->toJson(), ","); // Field PRINTQ
        $filterList = Concat($filterList, $this->PRINT_DATE->AdvancedSearch->toJson(), ","); // Field PRINT_DATE
        $filterList = Concat($filterList, $this->PRINTED_BY->AdvancedSearch->toJson(), ","); // Field PRINTED_BY
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->PPTK_TITLE->AdvancedSearch->toJson(), ","); // Field PPTK_TITLE
        $filterList = Concat($filterList, $this->APPROVED_ID->AdvancedSearch->toJson(), ","); // Field APPROVED_ID
        $filterList = Concat($filterList, $this->APPROVED_TITLE->AdvancedSearch->toJson(), ","); // Field APPROVED_TITLE
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fINVOICElistsrch", $filters);
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

        // Field ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue = @$filter["x_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator = @$filter["z_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchCondition = @$filter["v_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchValue2 = @$filter["y_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_UNIT_CODE"];
        $this->ORG_UNIT_CODE->AdvancedSearch->save();

        // Field INVOICE_ID
        $this->INVOICE_ID->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->save();

        // Field INVOICE_TYPE
        $this->INVOICE_TYPE->AdvancedSearch->SearchValue = @$filter["x_INVOICE_TYPE"];
        $this->INVOICE_TYPE->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_TYPE"];
        $this->INVOICE_TYPE->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_TYPE"];
        $this->INVOICE_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_TYPE"];
        $this->INVOICE_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_TYPE"];
        $this->INVOICE_TYPE->AdvancedSearch->save();

        // Field INVOICE_NO
        $this->INVOICE_NO->AdvancedSearch->SearchValue = @$filter["x_INVOICE_NO"];
        $this->INVOICE_NO->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_NO"];
        $this->INVOICE_NO->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_NO"];
        $this->INVOICE_NO->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_NO"];
        $this->INVOICE_NO->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_NO"];
        $this->INVOICE_NO->AdvancedSearch->save();

        // Field INV_COUNTER
        $this->INV_COUNTER->AdvancedSearch->SearchValue = @$filter["x_INV_COUNTER"];
        $this->INV_COUNTER->AdvancedSearch->SearchOperator = @$filter["z_INV_COUNTER"];
        $this->INV_COUNTER->AdvancedSearch->SearchCondition = @$filter["v_INV_COUNTER"];
        $this->INV_COUNTER->AdvancedSearch->SearchValue2 = @$filter["y_INV_COUNTER"];
        $this->INV_COUNTER->AdvancedSearch->SearchOperator2 = @$filter["w_INV_COUNTER"];
        $this->INV_COUNTER->AdvancedSearch->save();

        // Field INV_DATE
        $this->INV_DATE->AdvancedSearch->SearchValue = @$filter["x_INV_DATE"];
        $this->INV_DATE->AdvancedSearch->SearchOperator = @$filter["z_INV_DATE"];
        $this->INV_DATE->AdvancedSearch->SearchCondition = @$filter["v_INV_DATE"];
        $this->INV_DATE->AdvancedSearch->SearchValue2 = @$filter["y_INV_DATE"];
        $this->INV_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_INV_DATE"];
        $this->INV_DATE->AdvancedSearch->save();

        // Field INVOICE_TRANS
        $this->INVOICE_TRANS->AdvancedSearch->SearchValue = @$filter["x_INVOICE_TRANS"];
        $this->INVOICE_TRANS->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_TRANS"];
        $this->INVOICE_TRANS->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_TRANS"];
        $this->INVOICE_TRANS->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_TRANS"];
        $this->INVOICE_TRANS->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_TRANS"];
        $this->INVOICE_TRANS->AdvancedSearch->save();

        // Field INVOICE_DUE
        $this->INVOICE_DUE->AdvancedSearch->SearchValue = @$filter["x_INVOICE_DUE"];
        $this->INVOICE_DUE->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_DUE"];
        $this->INVOICE_DUE->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_DUE"];
        $this->INVOICE_DUE->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_DUE"];
        $this->INVOICE_DUE->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_DUE"];
        $this->INVOICE_DUE->AdvancedSearch->save();

        // Field REF_TYPE
        $this->REF_TYPE->AdvancedSearch->SearchValue = @$filter["x_REF_TYPE"];
        $this->REF_TYPE->AdvancedSearch->SearchOperator = @$filter["z_REF_TYPE"];
        $this->REF_TYPE->AdvancedSearch->SearchCondition = @$filter["v_REF_TYPE"];
        $this->REF_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_REF_TYPE"];
        $this->REF_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_REF_TYPE"];
        $this->REF_TYPE->AdvancedSearch->save();

        // Field REF_NO
        $this->REF_NO->AdvancedSearch->SearchValue = @$filter["x_REF_NO"];
        $this->REF_NO->AdvancedSearch->SearchOperator = @$filter["z_REF_NO"];
        $this->REF_NO->AdvancedSearch->SearchCondition = @$filter["v_REF_NO"];
        $this->REF_NO->AdvancedSearch->SearchValue2 = @$filter["y_REF_NO"];
        $this->REF_NO->AdvancedSearch->SearchOperator2 = @$filter["w_REF_NO"];
        $this->REF_NO->AdvancedSearch->save();

        // Field REF_NO2
        $this->REF_NO2->AdvancedSearch->SearchValue = @$filter["x_REF_NO2"];
        $this->REF_NO2->AdvancedSearch->SearchOperator = @$filter["z_REF_NO2"];
        $this->REF_NO2->AdvancedSearch->SearchCondition = @$filter["v_REF_NO2"];
        $this->REF_NO2->AdvancedSearch->SearchValue2 = @$filter["y_REF_NO2"];
        $this->REF_NO2->AdvancedSearch->SearchOperator2 = @$filter["w_REF_NO2"];
        $this->REF_NO2->AdvancedSearch->save();

        // Field REF_DATE
        $this->REF_DATE->AdvancedSearch->SearchValue = @$filter["x_REF_DATE"];
        $this->REF_DATE->AdvancedSearch->SearchOperator = @$filter["z_REF_DATE"];
        $this->REF_DATE->AdvancedSearch->SearchCondition = @$filter["v_REF_DATE"];
        $this->REF_DATE->AdvancedSearch->SearchValue2 = @$filter["y_REF_DATE"];
        $this->REF_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_REF_DATE"];
        $this->REF_DATE->AdvancedSearch->save();

        // Field ACCOUNT_ID
        $this->ACCOUNT_ID->AdvancedSearch->SearchValue = @$filter["x_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchOperator = @$filter["z_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchCondition = @$filter["v_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchValue2 = @$filter["y_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ACCOUNT_ID"];
        $this->ACCOUNT_ID->AdvancedSearch->save();

        // Field YEAR_ID
        $this->YEAR_ID->AdvancedSearch->SearchValue = @$filter["x_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchOperator = @$filter["z_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchCondition = @$filter["v_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchValue2 = @$filter["y_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->save();

        // Field ORG_ID
        $this->ORG_ID->AdvancedSearch->SearchValue = @$filter["x_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator = @$filter["z_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchCondition = @$filter["v_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchValue2 = @$filter["y_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->save();

        // Field PROGRAM_ID
        $this->PROGRAM_ID->AdvancedSearch->SearchValue = @$filter["x_PROGRAM_ID"];
        $this->PROGRAM_ID->AdvancedSearch->SearchOperator = @$filter["z_PROGRAM_ID"];
        $this->PROGRAM_ID->AdvancedSearch->SearchCondition = @$filter["v_PROGRAM_ID"];
        $this->PROGRAM_ID->AdvancedSearch->SearchValue2 = @$filter["y_PROGRAM_ID"];
        $this->PROGRAM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PROGRAM_ID"];
        $this->PROGRAM_ID->AdvancedSearch->save();

        // Field PROGRAMS
        $this->PROGRAMS->AdvancedSearch->SearchValue = @$filter["x_PROGRAMS"];
        $this->PROGRAMS->AdvancedSearch->SearchOperator = @$filter["z_PROGRAMS"];
        $this->PROGRAMS->AdvancedSearch->SearchCondition = @$filter["v_PROGRAMS"];
        $this->PROGRAMS->AdvancedSearch->SearchValue2 = @$filter["y_PROGRAMS"];
        $this->PROGRAMS->AdvancedSearch->SearchOperator2 = @$filter["w_PROGRAMS"];
        $this->PROGRAMS->AdvancedSearch->save();

        // Field PACTIVITY_ID
        $this->PACTIVITY_ID->AdvancedSearch->SearchValue = @$filter["x_PACTIVITY_ID"];
        $this->PACTIVITY_ID->AdvancedSearch->SearchOperator = @$filter["z_PACTIVITY_ID"];
        $this->PACTIVITY_ID->AdvancedSearch->SearchCondition = @$filter["v_PACTIVITY_ID"];
        $this->PACTIVITY_ID->AdvancedSearch->SearchValue2 = @$filter["y_PACTIVITY_ID"];
        $this->PACTIVITY_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PACTIVITY_ID"];
        $this->PACTIVITY_ID->AdvancedSearch->save();

        // Field ACTIVITY_ID
        $this->ACTIVITY_ID->AdvancedSearch->SearchValue = @$filter["x_ACTIVITY_ID"];
        $this->ACTIVITY_ID->AdvancedSearch->SearchOperator = @$filter["z_ACTIVITY_ID"];
        $this->ACTIVITY_ID->AdvancedSearch->SearchCondition = @$filter["v_ACTIVITY_ID"];
        $this->ACTIVITY_ID->AdvancedSearch->SearchValue2 = @$filter["y_ACTIVITY_ID"];
        $this->ACTIVITY_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ACTIVITY_ID"];
        $this->ACTIVITY_ID->AdvancedSearch->save();

        // Field ACTIVITY_NAME
        $this->ACTIVITY_NAME->AdvancedSearch->SearchValue = @$filter["x_ACTIVITY_NAME"];
        $this->ACTIVITY_NAME->AdvancedSearch->SearchOperator = @$filter["z_ACTIVITY_NAME"];
        $this->ACTIVITY_NAME->AdvancedSearch->SearchCondition = @$filter["v_ACTIVITY_NAME"];
        $this->ACTIVITY_NAME->AdvancedSearch->SearchValue2 = @$filter["y_ACTIVITY_NAME"];
        $this->ACTIVITY_NAME->AdvancedSearch->SearchOperator2 = @$filter["w_ACTIVITY_NAME"];
        $this->ACTIVITY_NAME->AdvancedSearch->save();

        // Field KEPERLUAN
        $this->KEPERLUAN->AdvancedSearch->SearchValue = @$filter["x_KEPERLUAN"];
        $this->KEPERLUAN->AdvancedSearch->SearchOperator = @$filter["z_KEPERLUAN"];
        $this->KEPERLUAN->AdvancedSearch->SearchCondition = @$filter["v_KEPERLUAN"];
        $this->KEPERLUAN->AdvancedSearch->SearchValue2 = @$filter["y_KEPERLUAN"];
        $this->KEPERLUAN->AdvancedSearch->SearchOperator2 = @$filter["w_KEPERLUAN"];
        $this->KEPERLUAN->AdvancedSearch->save();

        // Field PPTK
        $this->PPTK->AdvancedSearch->SearchValue = @$filter["x_PPTK"];
        $this->PPTK->AdvancedSearch->SearchOperator = @$filter["z_PPTK"];
        $this->PPTK->AdvancedSearch->SearchCondition = @$filter["v_PPTK"];
        $this->PPTK->AdvancedSearch->SearchValue2 = @$filter["y_PPTK"];
        $this->PPTK->AdvancedSearch->SearchOperator2 = @$filter["w_PPTK"];
        $this->PPTK->AdvancedSearch->save();

        // Field PPTK_NAME
        $this->PPTK_NAME->AdvancedSearch->SearchValue = @$filter["x_PPTK_NAME"];
        $this->PPTK_NAME->AdvancedSearch->SearchOperator = @$filter["z_PPTK_NAME"];
        $this->PPTK_NAME->AdvancedSearch->SearchCondition = @$filter["v_PPTK_NAME"];
        $this->PPTK_NAME->AdvancedSearch->SearchValue2 = @$filter["y_PPTK_NAME"];
        $this->PPTK_NAME->AdvancedSearch->SearchOperator2 = @$filter["w_PPTK_NAME"];
        $this->PPTK_NAME->AdvancedSearch->save();

        // Field COMPANY_ID
        $this->COMPANY_ID->AdvancedSearch->SearchValue = @$filter["x_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->save();

        // Field COMPANY_TO
        $this->COMPANY_TO->AdvancedSearch->SearchValue = @$filter["x_COMPANY_TO"];
        $this->COMPANY_TO->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_TO"];
        $this->COMPANY_TO->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_TO"];
        $this->COMPANY_TO->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_TO"];
        $this->COMPANY_TO->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_TO"];
        $this->COMPANY_TO->AdvancedSearch->save();

        // Field COMPANY_TYPE
        $this->COMPANY_TYPE->AdvancedSearch->SearchValue = @$filter["x_COMPANY_TYPE"];
        $this->COMPANY_TYPE->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_TYPE"];
        $this->COMPANY_TYPE->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_TYPE"];
        $this->COMPANY_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_TYPE"];
        $this->COMPANY_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_TYPE"];
        $this->COMPANY_TYPE->AdvancedSearch->save();

        // Field COMPANY
        $this->COMPANY->AdvancedSearch->SearchValue = @$filter["x_COMPANY"];
        $this->COMPANY->AdvancedSearch->SearchOperator = @$filter["z_COMPANY"];
        $this->COMPANY->AdvancedSearch->SearchCondition = @$filter["v_COMPANY"];
        $this->COMPANY->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY"];
        $this->COMPANY->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY"];
        $this->COMPANY->AdvancedSearch->save();

        // Field COMPANY_CHIEF
        $this->COMPANY_CHIEF->AdvancedSearch->SearchValue = @$filter["x_COMPANY_CHIEF"];
        $this->COMPANY_CHIEF->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_CHIEF"];
        $this->COMPANY_CHIEF->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_CHIEF"];
        $this->COMPANY_CHIEF->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_CHIEF"];
        $this->COMPANY_CHIEF->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_CHIEF"];
        $this->COMPANY_CHIEF->AdvancedSearch->save();

        // Field COMPANY_INFO
        $this->COMPANY_INFO->AdvancedSearch->SearchValue = @$filter["x_COMPANY_INFO"];
        $this->COMPANY_INFO->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_INFO"];
        $this->COMPANY_INFO->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_INFO"];
        $this->COMPANY_INFO->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_INFO"];
        $this->COMPANY_INFO->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_INFO"];
        $this->COMPANY_INFO->AdvancedSearch->save();

        // Field CONTRACT_NO
        $this->CONTRACT_NO->AdvancedSearch->SearchValue = @$filter["x_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchOperator = @$filter["z_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchCondition = @$filter["v_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchValue2 = @$filter["y_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->SearchOperator2 = @$filter["w_CONTRACT_NO"];
        $this->CONTRACT_NO->AdvancedSearch->save();

        // Field NPWP
        $this->NPWP->AdvancedSearch->SearchValue = @$filter["x_NPWP"];
        $this->NPWP->AdvancedSearch->SearchOperator = @$filter["z_NPWP"];
        $this->NPWP->AdvancedSearch->SearchCondition = @$filter["v_NPWP"];
        $this->NPWP->AdvancedSearch->SearchValue2 = @$filter["y_NPWP"];
        $this->NPWP->AdvancedSearch->SearchOperator2 = @$filter["w_NPWP"];
        $this->NPWP->AdvancedSearch->save();

        // Field COMPANY_BANK
        $this->COMPANY_BANK->AdvancedSearch->SearchValue = @$filter["x_COMPANY_BANK"];
        $this->COMPANY_BANK->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_BANK"];
        $this->COMPANY_BANK->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_BANK"];
        $this->COMPANY_BANK->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_BANK"];
        $this->COMPANY_BANK->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_BANK"];
        $this->COMPANY_BANK->AdvancedSearch->save();

        // Field COMPANY_ACCOUNT
        $this->COMPANY_ACCOUNT->AdvancedSearch->SearchValue = @$filter["x_COMPANY_ACCOUNT"];
        $this->COMPANY_ACCOUNT->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_ACCOUNT"];
        $this->COMPANY_ACCOUNT->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_ACCOUNT"];
        $this->COMPANY_ACCOUNT->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_ACCOUNT"];
        $this->COMPANY_ACCOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_ACCOUNT"];
        $this->COMPANY_ACCOUNT->AdvancedSearch->save();

        // Field PAGU
        $this->PAGU->AdvancedSearch->SearchValue = @$filter["x_PAGU"];
        $this->PAGU->AdvancedSearch->SearchOperator = @$filter["z_PAGU"];
        $this->PAGU->AdvancedSearch->SearchCondition = @$filter["v_PAGU"];
        $this->PAGU->AdvancedSearch->SearchValue2 = @$filter["y_PAGU"];
        $this->PAGU->AdvancedSearch->SearchOperator2 = @$filter["w_PAGU"];
        $this->PAGU->AdvancedSearch->save();

        // Field PAGU_REALISASI
        $this->PAGU_REALISASI->AdvancedSearch->SearchValue = @$filter["x_PAGU_REALISASI"];
        $this->PAGU_REALISASI->AdvancedSearch->SearchOperator = @$filter["z_PAGU_REALISASI"];
        $this->PAGU_REALISASI->AdvancedSearch->SearchCondition = @$filter["v_PAGU_REALISASI"];
        $this->PAGU_REALISASI->AdvancedSearch->SearchValue2 = @$filter["y_PAGU_REALISASI"];
        $this->PAGU_REALISASI->AdvancedSearch->SearchOperator2 = @$filter["w_PAGU_REALISASI"];
        $this->PAGU_REALISASI->AdvancedSearch->save();

        // Field AMOUNT
        $this->AMOUNT->AdvancedSearch->SearchValue = @$filter["x_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT"];
        $this->AMOUNT->AdvancedSearch->save();

        // Field AMOUNT_PAID
        $this->AMOUNT_PAID->AdvancedSearch->SearchValue = @$filter["x_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchOperator = @$filter["z_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchCondition = @$filter["v_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchValue2 = @$filter["y_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->SearchOperator2 = @$filter["w_AMOUNT_PAID"];
        $this->AMOUNT_PAID->AdvancedSearch->save();

        // Field PAYMENT_INSTRUCTIONS
        $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->SearchValue = @$filter["x_PAYMENT_INSTRUCTIONS"];
        $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->SearchOperator = @$filter["z_PAYMENT_INSTRUCTIONS"];
        $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->SearchCondition = @$filter["v_PAYMENT_INSTRUCTIONS"];
        $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->SearchValue2 = @$filter["y_PAYMENT_INSTRUCTIONS"];
        $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->SearchOperator2 = @$filter["w_PAYMENT_INSTRUCTIONS"];
        $this->PAYMENT_INSTRUCTIONS->AdvancedSearch->save();

        // Field ISAPPROVED
        $this->ISAPPROVED->AdvancedSearch->SearchValue = @$filter["x_ISAPPROVED"];
        $this->ISAPPROVED->AdvancedSearch->SearchOperator = @$filter["z_ISAPPROVED"];
        $this->ISAPPROVED->AdvancedSearch->SearchCondition = @$filter["v_ISAPPROVED"];
        $this->ISAPPROVED->AdvancedSearch->SearchValue2 = @$filter["y_ISAPPROVED"];
        $this->ISAPPROVED->AdvancedSearch->SearchOperator2 = @$filter["w_ISAPPROVED"];
        $this->ISAPPROVED->AdvancedSearch->save();

        // Field APPROVED_BY
        $this->APPROVED_BY->AdvancedSearch->SearchValue = @$filter["x_APPROVED_BY"];
        $this->APPROVED_BY->AdvancedSearch->SearchOperator = @$filter["z_APPROVED_BY"];
        $this->APPROVED_BY->AdvancedSearch->SearchCondition = @$filter["v_APPROVED_BY"];
        $this->APPROVED_BY->AdvancedSearch->SearchValue2 = @$filter["y_APPROVED_BY"];
        $this->APPROVED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_APPROVED_BY"];
        $this->APPROVED_BY->AdvancedSearch->save();

        // Field APPROVED_DATE
        $this->APPROVED_DATE->AdvancedSearch->SearchValue = @$filter["x_APPROVED_DATE"];
        $this->APPROVED_DATE->AdvancedSearch->SearchOperator = @$filter["z_APPROVED_DATE"];
        $this->APPROVED_DATE->AdvancedSearch->SearchCondition = @$filter["v_APPROVED_DATE"];
        $this->APPROVED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_APPROVED_DATE"];
        $this->APPROVED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_APPROVED_DATE"];
        $this->APPROVED_DATE->AdvancedSearch->save();

        // Field ISCETAK
        $this->ISCETAK->AdvancedSearch->SearchValue = @$filter["x_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator = @$filter["z_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchCondition = @$filter["v_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchValue2 = @$filter["y_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator2 = @$filter["w_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->save();

        // Field PRINTQ
        $this->PRINTQ->AdvancedSearch->SearchValue = @$filter["x_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator = @$filter["z_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchCondition = @$filter["v_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchValue2 = @$filter["y_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->save();

        // Field PRINT_DATE
        $this->PRINT_DATE->AdvancedSearch->SearchValue = @$filter["x_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchOperator = @$filter["z_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchCondition = @$filter["v_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchValue2 = @$filter["y_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_PRINT_DATE"];
        $this->PRINT_DATE->AdvancedSearch->save();

        // Field PRINTED_BY
        $this->PRINTED_BY->AdvancedSearch->SearchValue = @$filter["x_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchOperator = @$filter["z_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchCondition = @$filter["v_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchValue2 = @$filter["y_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTED_BY"];
        $this->PRINTED_BY->AdvancedSearch->save();

        // Field MODIFIED_DATE
        $this->MODIFIED_DATE->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_DATE"];
        $this->MODIFIED_DATE->AdvancedSearch->save();

        // Field MODIFIED_BY
        $this->MODIFIED_BY->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_BY"];
        $this->MODIFIED_BY->AdvancedSearch->save();

        // Field PPTK_TITLE
        $this->PPTK_TITLE->AdvancedSearch->SearchValue = @$filter["x_PPTK_TITLE"];
        $this->PPTK_TITLE->AdvancedSearch->SearchOperator = @$filter["z_PPTK_TITLE"];
        $this->PPTK_TITLE->AdvancedSearch->SearchCondition = @$filter["v_PPTK_TITLE"];
        $this->PPTK_TITLE->AdvancedSearch->SearchValue2 = @$filter["y_PPTK_TITLE"];
        $this->PPTK_TITLE->AdvancedSearch->SearchOperator2 = @$filter["w_PPTK_TITLE"];
        $this->PPTK_TITLE->AdvancedSearch->save();

        // Field APPROVED_ID
        $this->APPROVED_ID->AdvancedSearch->SearchValue = @$filter["x_APPROVED_ID"];
        $this->APPROVED_ID->AdvancedSearch->SearchOperator = @$filter["z_APPROVED_ID"];
        $this->APPROVED_ID->AdvancedSearch->SearchCondition = @$filter["v_APPROVED_ID"];
        $this->APPROVED_ID->AdvancedSearch->SearchValue2 = @$filter["y_APPROVED_ID"];
        $this->APPROVED_ID->AdvancedSearch->SearchOperator2 = @$filter["w_APPROVED_ID"];
        $this->APPROVED_ID->AdvancedSearch->save();

        // Field APPROVED_TITLE
        $this->APPROVED_TITLE->AdvancedSearch->SearchValue = @$filter["x_APPROVED_TITLE"];
        $this->APPROVED_TITLE->AdvancedSearch->SearchOperator = @$filter["z_APPROVED_TITLE"];
        $this->APPROVED_TITLE->AdvancedSearch->SearchCondition = @$filter["v_APPROVED_TITLE"];
        $this->APPROVED_TITLE->AdvancedSearch->SearchValue2 = @$filter["y_APPROVED_TITLE"];
        $this->APPROVED_TITLE->AdvancedSearch->SearchOperator2 = @$filter["w_APPROVED_TITLE"];
        $this->APPROVED_TITLE->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->REF_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->REF_NO2, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ACCOUNT_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PROGRAM_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PROGRAMS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PACTIVITY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ACTIVITY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ACTIVITY_NAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KEPERLUAN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PPTK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PPTK_NAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_TO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_TYPE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_CHIEF, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_INFO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CONTRACT_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NPWP, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_BANK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_ACCOUNT, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PAYMENT_INSTRUCTIONS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISAPPROVED, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->APPROVED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISCETAK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PRINTED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PPTK_TITLE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->APPROVED_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->APPROVED_TITLE, $arKeywords, $type);
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
            $this->updateSort($this->ORG_UNIT_CODE); // ORG_UNIT_CODE
            $this->updateSort($this->INVOICE_ID); // INVOICE_ID
            $this->updateSort($this->INVOICE_TYPE); // INVOICE_TYPE
            $this->updateSort($this->INVOICE_NO); // INVOICE_NO
            $this->updateSort($this->INV_COUNTER); // INV_COUNTER
            $this->updateSort($this->INV_DATE); // INV_DATE
            $this->updateSort($this->INVOICE_TRANS); // INVOICE_TRANS
            $this->updateSort($this->INVOICE_DUE); // INVOICE_DUE
            $this->updateSort($this->REF_TYPE); // REF_TYPE
            $this->updateSort($this->REF_NO); // REF_NO
            $this->updateSort($this->REF_NO2); // REF_NO2
            $this->updateSort($this->REF_DATE); // REF_DATE
            $this->updateSort($this->ACCOUNT_ID); // ACCOUNT_ID
            $this->updateSort($this->YEAR_ID); // YEAR_ID
            $this->updateSort($this->ORG_ID); // ORG_ID
            $this->updateSort($this->PROGRAM_ID); // PROGRAM_ID
            $this->updateSort($this->PROGRAMS); // PROGRAMS
            $this->updateSort($this->PACTIVITY_ID); // PACTIVITY_ID
            $this->updateSort($this->ACTIVITY_ID); // ACTIVITY_ID
            $this->updateSort($this->ACTIVITY_NAME); // ACTIVITY_NAME
            $this->updateSort($this->KEPERLUAN); // KEPERLUAN
            $this->updateSort($this->PPTK); // PPTK
            $this->updateSort($this->PPTK_NAME); // PPTK_NAME
            $this->updateSort($this->COMPANY_ID); // COMPANY_ID
            $this->updateSort($this->COMPANY_TO); // COMPANY_TO
            $this->updateSort($this->COMPANY_TYPE); // COMPANY_TYPE
            $this->updateSort($this->COMPANY); // COMPANY
            $this->updateSort($this->COMPANY_CHIEF); // COMPANY_CHIEF
            $this->updateSort($this->COMPANY_INFO); // COMPANY_INFO
            $this->updateSort($this->CONTRACT_NO); // CONTRACT_NO
            $this->updateSort($this->NPWP); // NPWP
            $this->updateSort($this->COMPANY_BANK); // COMPANY_BANK
            $this->updateSort($this->COMPANY_ACCOUNT); // COMPANY_ACCOUNT
            $this->updateSort($this->PAGU); // PAGU
            $this->updateSort($this->PAGU_REALISASI); // PAGU_REALISASI
            $this->updateSort($this->AMOUNT); // AMOUNT
            $this->updateSort($this->AMOUNT_PAID); // AMOUNT_PAID
            $this->updateSort($this->PAYMENT_INSTRUCTIONS); // PAYMENT_INSTRUCTIONS
            $this->updateSort($this->ISAPPROVED); // ISAPPROVED
            $this->updateSort($this->APPROVED_BY); // APPROVED_BY
            $this->updateSort($this->APPROVED_DATE); // APPROVED_DATE
            $this->updateSort($this->ISCETAK); // ISCETAK
            $this->updateSort($this->PRINTQ); // PRINTQ
            $this->updateSort($this->PRINT_DATE); // PRINT_DATE
            $this->updateSort($this->PRINTED_BY); // PRINTED_BY
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->PPTK_TITLE); // PPTK_TITLE
            $this->updateSort($this->APPROVED_ID); // APPROVED_ID
            $this->updateSort($this->APPROVED_TITLE); // APPROVED_TITLE
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
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
                $this->ORG_UNIT_CODE->setSort("");
                $this->INVOICE_ID->setSort("");
                $this->INVOICE_TYPE->setSort("");
                $this->INVOICE_NO->setSort("");
                $this->INV_COUNTER->setSort("");
                $this->INV_DATE->setSort("");
                $this->INVOICE_TRANS->setSort("");
                $this->INVOICE_DUE->setSort("");
                $this->REF_TYPE->setSort("");
                $this->REF_NO->setSort("");
                $this->REF_NO2->setSort("");
                $this->REF_DATE->setSort("");
                $this->ACCOUNT_ID->setSort("");
                $this->YEAR_ID->setSort("");
                $this->ORG_ID->setSort("");
                $this->PROGRAM_ID->setSort("");
                $this->PROGRAMS->setSort("");
                $this->PACTIVITY_ID->setSort("");
                $this->ACTIVITY_ID->setSort("");
                $this->ACTIVITY_NAME->setSort("");
                $this->KEPERLUAN->setSort("");
                $this->PPTK->setSort("");
                $this->PPTK_NAME->setSort("");
                $this->COMPANY_ID->setSort("");
                $this->COMPANY_TO->setSort("");
                $this->COMPANY_TYPE->setSort("");
                $this->COMPANY->setSort("");
                $this->COMPANY_CHIEF->setSort("");
                $this->COMPANY_INFO->setSort("");
                $this->CONTRACT_NO->setSort("");
                $this->NPWP->setSort("");
                $this->COMPANY_BANK->setSort("");
                $this->COMPANY_ACCOUNT->setSort("");
                $this->PAGU->setSort("");
                $this->PAGU_REALISASI->setSort("");
                $this->AMOUNT->setSort("");
                $this->AMOUNT_PAID->setSort("");
                $this->PAYMENT_INSTRUCTIONS->setSort("");
                $this->ISAPPROVED->setSort("");
                $this->APPROVED_BY->setSort("");
                $this->APPROVED_DATE->setSort("");
                $this->ISCETAK->setSort("");
                $this->PRINTQ->setSort("");
                $this->PRINT_DATE->setSort("");
                $this->PRINTED_BY->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->PPTK_TITLE->setSort("");
                $this->APPROVED_ID->setSort("");
                $this->APPROVED_TITLE->setSort("");
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

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

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
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->ORG_UNIT_CODE->CurrentValue . Config("COMPOSITE_KEY_SEPARATOR") . $this->INVOICE_ID->CurrentValue) . "\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fINVOICElistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fINVOICElistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fINVOICElist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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

    // Get multi column CSS class for record DIV
    public function getMultiColumnClass()
    {
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isInlineActionRow()) {
            return "p-3 " . $this->MultiColumnEditClass; // Occupy a whole row
        }
        return $this->MultiColumnClass; // Occupy a column only
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
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->INVOICE_TYPE->setDbValue($row['INVOICE_TYPE']);
        $this->INVOICE_NO->setDbValue($row['INVOICE_NO']);
        $this->INV_COUNTER->setDbValue($row['INV_COUNTER']);
        $this->INV_DATE->setDbValue($row['INV_DATE']);
        $this->INVOICE_TRANS->setDbValue($row['INVOICE_TRANS']);
        $this->INVOICE_DUE->setDbValue($row['INVOICE_DUE']);
        $this->REF_TYPE->setDbValue($row['REF_TYPE']);
        $this->REF_NO->setDbValue($row['REF_NO']);
        $this->REF_NO2->setDbValue($row['REF_NO2']);
        $this->REF_DATE->setDbValue($row['REF_DATE']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->PROGRAM_ID->setDbValue($row['PROGRAM_ID']);
        $this->PROGRAMS->setDbValue($row['PROGRAMS']);
        $this->PACTIVITY_ID->setDbValue($row['PACTIVITY_ID']);
        $this->ACTIVITY_ID->setDbValue($row['ACTIVITY_ID']);
        $this->ACTIVITY_NAME->setDbValue($row['ACTIVITY_NAME']);
        $this->KEPERLUAN->setDbValue($row['KEPERLUAN']);
        $this->PPTK->setDbValue($row['PPTK']);
        $this->PPTK_NAME->setDbValue($row['PPTK_NAME']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->COMPANY_TO->setDbValue($row['COMPANY_TO']);
        $this->COMPANY_TYPE->setDbValue($row['COMPANY_TYPE']);
        $this->COMPANY->setDbValue($row['COMPANY']);
        $this->COMPANY_CHIEF->setDbValue($row['COMPANY_CHIEF']);
        $this->COMPANY_INFO->setDbValue($row['COMPANY_INFO']);
        $this->CONTRACT_NO->setDbValue($row['CONTRACT_NO']);
        $this->NPWP->setDbValue($row['NPWP']);
        $this->COMPANY_BANK->setDbValue($row['COMPANY_BANK']);
        $this->COMPANY_ACCOUNT->setDbValue($row['COMPANY_ACCOUNT']);
        $this->PAGU->setDbValue($row['PAGU']);
        $this->PAGU_REALISASI->setDbValue($row['PAGU_REALISASI']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->AMOUNT_PAID->setDbValue($row['AMOUNT_PAID']);
        $this->PAYMENT_INSTRUCTIONS->setDbValue($row['PAYMENT_INSTRUCTIONS']);
        $this->ISAPPROVED->setDbValue($row['ISAPPROVED']);
        $this->APPROVED_BY->setDbValue($row['APPROVED_BY']);
        $this->APPROVED_DATE->setDbValue($row['APPROVED_DATE']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->PPTK_TITLE->setDbValue($row['PPTK_TITLE']);
        $this->APPROVED_ID->setDbValue($row['APPROVED_ID']);
        $this->APPROVED_TITLE->setDbValue($row['APPROVED_TITLE']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['INVOICE_ID'] = null;
        $row['INVOICE_TYPE'] = null;
        $row['INVOICE_NO'] = null;
        $row['INV_COUNTER'] = null;
        $row['INV_DATE'] = null;
        $row['INVOICE_TRANS'] = null;
        $row['INVOICE_DUE'] = null;
        $row['REF_TYPE'] = null;
        $row['REF_NO'] = null;
        $row['REF_NO2'] = null;
        $row['REF_DATE'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['YEAR_ID'] = null;
        $row['ORG_ID'] = null;
        $row['PROGRAM_ID'] = null;
        $row['PROGRAMS'] = null;
        $row['PACTIVITY_ID'] = null;
        $row['ACTIVITY_ID'] = null;
        $row['ACTIVITY_NAME'] = null;
        $row['KEPERLUAN'] = null;
        $row['PPTK'] = null;
        $row['PPTK_NAME'] = null;
        $row['COMPANY_ID'] = null;
        $row['COMPANY_TO'] = null;
        $row['COMPANY_TYPE'] = null;
        $row['COMPANY'] = null;
        $row['COMPANY_CHIEF'] = null;
        $row['COMPANY_INFO'] = null;
        $row['CONTRACT_NO'] = null;
        $row['NPWP'] = null;
        $row['COMPANY_BANK'] = null;
        $row['COMPANY_ACCOUNT'] = null;
        $row['PAGU'] = null;
        $row['PAGU_REALISASI'] = null;
        $row['AMOUNT'] = null;
        $row['AMOUNT_PAID'] = null;
        $row['PAYMENT_INSTRUCTIONS'] = null;
        $row['ISAPPROVED'] = null;
        $row['APPROVED_BY'] = null;
        $row['APPROVED_DATE'] = null;
        $row['ISCETAK'] = null;
        $row['PRINTQ'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['PPTK_TITLE'] = null;
        $row['APPROVED_ID'] = null;
        $row['APPROVED_TITLE'] = null;
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

        // Convert decimal values if posted back
        if ($this->PAGU->FormValue == $this->PAGU->CurrentValue && is_numeric(ConvertToFloatString($this->PAGU->CurrentValue))) {
            $this->PAGU->CurrentValue = ConvertToFloatString($this->PAGU->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PAGU_REALISASI->FormValue == $this->PAGU_REALISASI->CurrentValue && is_numeric(ConvertToFloatString($this->PAGU_REALISASI->CurrentValue))) {
            $this->PAGU_REALISASI->CurrentValue = ConvertToFloatString($this->PAGU_REALISASI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT->FormValue == $this->AMOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT->CurrentValue))) {
            $this->AMOUNT->CurrentValue = ConvertToFloatString($this->AMOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT_PAID->FormValue == $this->AMOUNT_PAID->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PAID->CurrentValue))) {
            $this->AMOUNT_PAID->CurrentValue = ConvertToFloatString($this->AMOUNT_PAID->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // INVOICE_ID

        // INVOICE_TYPE

        // INVOICE_NO

        // INV_COUNTER

        // INV_DATE

        // INVOICE_TRANS

        // INVOICE_DUE

        // REF_TYPE

        // REF_NO

        // REF_NO2

        // REF_DATE

        // ACCOUNT_ID

        // YEAR_ID

        // ORG_ID

        // PROGRAM_ID

        // PROGRAMS

        // PACTIVITY_ID

        // ACTIVITY_ID

        // ACTIVITY_NAME

        // KEPERLUAN

        // PPTK

        // PPTK_NAME

        // COMPANY_ID

        // COMPANY_TO

        // COMPANY_TYPE

        // COMPANY

        // COMPANY_CHIEF

        // COMPANY_INFO

        // CONTRACT_NO

        // NPWP

        // COMPANY_BANK

        // COMPANY_ACCOUNT

        // PAGU

        // PAGU_REALISASI

        // AMOUNT

        // AMOUNT_PAID

        // PAYMENT_INSTRUCTIONS

        // ISAPPROVED

        // APPROVED_BY

        // APPROVED_DATE

        // ISCETAK

        // PRINTQ

        // PRINT_DATE

        // PRINTED_BY

        // MODIFIED_DATE

        // MODIFIED_BY

        // PPTK_TITLE

        // APPROVED_ID

        // APPROVED_TITLE
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // INVOICE_TYPE
            $this->INVOICE_TYPE->ViewValue = $this->INVOICE_TYPE->CurrentValue;
            $this->INVOICE_TYPE->ViewValue = FormatNumber($this->INVOICE_TYPE->ViewValue, 0, -2, -2, -2);
            $this->INVOICE_TYPE->ViewCustomAttributes = "";

            // INVOICE_NO
            $this->INVOICE_NO->ViewValue = $this->INVOICE_NO->CurrentValue;
            $this->INVOICE_NO->ViewCustomAttributes = "";

            // INV_COUNTER
            $this->INV_COUNTER->ViewValue = $this->INV_COUNTER->CurrentValue;
            $this->INV_COUNTER->ViewValue = FormatNumber($this->INV_COUNTER->ViewValue, 0, -2, -2, -2);
            $this->INV_COUNTER->ViewCustomAttributes = "";

            // INV_DATE
            $this->INV_DATE->ViewValue = $this->INV_DATE->CurrentValue;
            $this->INV_DATE->ViewValue = FormatDateTime($this->INV_DATE->ViewValue, 0);
            $this->INV_DATE->ViewCustomAttributes = "";

            // INVOICE_TRANS
            $this->INVOICE_TRANS->ViewValue = $this->INVOICE_TRANS->CurrentValue;
            $this->INVOICE_TRANS->ViewValue = FormatDateTime($this->INVOICE_TRANS->ViewValue, 0);
            $this->INVOICE_TRANS->ViewCustomAttributes = "";

            // INVOICE_DUE
            $this->INVOICE_DUE->ViewValue = $this->INVOICE_DUE->CurrentValue;
            $this->INVOICE_DUE->ViewValue = FormatDateTime($this->INVOICE_DUE->ViewValue, 0);
            $this->INVOICE_DUE->ViewCustomAttributes = "";

            // REF_TYPE
            $this->REF_TYPE->ViewValue = $this->REF_TYPE->CurrentValue;
            $this->REF_TYPE->ViewValue = FormatNumber($this->REF_TYPE->ViewValue, 0, -2, -2, -2);
            $this->REF_TYPE->ViewCustomAttributes = "";

            // REF_NO
            $this->REF_NO->ViewValue = $this->REF_NO->CurrentValue;
            $this->REF_NO->ViewCustomAttributes = "";

            // REF_NO2
            $this->REF_NO2->ViewValue = $this->REF_NO2->CurrentValue;
            $this->REF_NO2->ViewCustomAttributes = "";

            // REF_DATE
            $this->REF_DATE->ViewValue = $this->REF_DATE->CurrentValue;
            $this->REF_DATE->ViewValue = FormatDateTime($this->REF_DATE->ViewValue, 0);
            $this->REF_DATE->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // YEAR_ID
            $this->YEAR_ID->ViewValue = $this->YEAR_ID->CurrentValue;
            $this->YEAR_ID->ViewValue = FormatNumber($this->YEAR_ID->ViewValue, 0, -2, -2, -2);
            $this->YEAR_ID->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // PROGRAM_ID
            $this->PROGRAM_ID->ViewValue = $this->PROGRAM_ID->CurrentValue;
            $this->PROGRAM_ID->ViewCustomAttributes = "";

            // PROGRAMS
            $this->PROGRAMS->ViewValue = $this->PROGRAMS->CurrentValue;
            $this->PROGRAMS->ViewCustomAttributes = "";

            // PACTIVITY_ID
            $this->PACTIVITY_ID->ViewValue = $this->PACTIVITY_ID->CurrentValue;
            $this->PACTIVITY_ID->ViewCustomAttributes = "";

            // ACTIVITY_ID
            $this->ACTIVITY_ID->ViewValue = $this->ACTIVITY_ID->CurrentValue;
            $this->ACTIVITY_ID->ViewCustomAttributes = "";

            // ACTIVITY_NAME
            $this->ACTIVITY_NAME->ViewValue = $this->ACTIVITY_NAME->CurrentValue;
            $this->ACTIVITY_NAME->ViewCustomAttributes = "";

            // KEPERLUAN
            $this->KEPERLUAN->ViewValue = $this->KEPERLUAN->CurrentValue;
            $this->KEPERLUAN->ViewCustomAttributes = "";

            // PPTK
            $this->PPTK->ViewValue = $this->PPTK->CurrentValue;
            $this->PPTK->ViewCustomAttributes = "";

            // PPTK_NAME
            $this->PPTK_NAME->ViewValue = $this->PPTK_NAME->CurrentValue;
            $this->PPTK_NAME->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // COMPANY_TO
            $this->COMPANY_TO->ViewValue = $this->COMPANY_TO->CurrentValue;
            $this->COMPANY_TO->ViewCustomAttributes = "";

            // COMPANY_TYPE
            $this->COMPANY_TYPE->ViewValue = $this->COMPANY_TYPE->CurrentValue;
            $this->COMPANY_TYPE->ViewCustomAttributes = "";

            // COMPANY
            $this->COMPANY->ViewValue = $this->COMPANY->CurrentValue;
            $this->COMPANY->ViewCustomAttributes = "";

            // COMPANY_CHIEF
            $this->COMPANY_CHIEF->ViewValue = $this->COMPANY_CHIEF->CurrentValue;
            $this->COMPANY_CHIEF->ViewCustomAttributes = "";

            // COMPANY_INFO
            $this->COMPANY_INFO->ViewValue = $this->COMPANY_INFO->CurrentValue;
            $this->COMPANY_INFO->ViewCustomAttributes = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->ViewValue = $this->CONTRACT_NO->CurrentValue;
            $this->CONTRACT_NO->ViewCustomAttributes = "";

            // NPWP
            $this->NPWP->ViewValue = $this->NPWP->CurrentValue;
            $this->NPWP->ViewCustomAttributes = "";

            // COMPANY_BANK
            $this->COMPANY_BANK->ViewValue = $this->COMPANY_BANK->CurrentValue;
            $this->COMPANY_BANK->ViewCustomAttributes = "";

            // COMPANY_ACCOUNT
            $this->COMPANY_ACCOUNT->ViewValue = $this->COMPANY_ACCOUNT->CurrentValue;
            $this->COMPANY_ACCOUNT->ViewCustomAttributes = "";

            // PAGU
            $this->PAGU->ViewValue = $this->PAGU->CurrentValue;
            $this->PAGU->ViewValue = FormatNumber($this->PAGU->ViewValue, 2, -2, -2, -2);
            $this->PAGU->ViewCustomAttributes = "";

            // PAGU_REALISASI
            $this->PAGU_REALISASI->ViewValue = $this->PAGU_REALISASI->CurrentValue;
            $this->PAGU_REALISASI->ViewValue = FormatNumber($this->PAGU_REALISASI->ViewValue, 2, -2, -2, -2);
            $this->PAGU_REALISASI->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->ViewValue = $this->AMOUNT_PAID->CurrentValue;
            $this->AMOUNT_PAID->ViewValue = FormatNumber($this->AMOUNT_PAID->ViewValue, 2, -2, -2, -2);
            $this->AMOUNT_PAID->ViewCustomAttributes = "";

            // PAYMENT_INSTRUCTIONS
            $this->PAYMENT_INSTRUCTIONS->ViewValue = $this->PAYMENT_INSTRUCTIONS->CurrentValue;
            $this->PAYMENT_INSTRUCTIONS->ViewCustomAttributes = "";

            // ISAPPROVED
            $this->ISAPPROVED->ViewValue = $this->ISAPPROVED->CurrentValue;
            $this->ISAPPROVED->ViewCustomAttributes = "";

            // APPROVED_BY
            $this->APPROVED_BY->ViewValue = $this->APPROVED_BY->CurrentValue;
            $this->APPROVED_BY->ViewCustomAttributes = "";

            // APPROVED_DATE
            $this->APPROVED_DATE->ViewValue = $this->APPROVED_DATE->CurrentValue;
            $this->APPROVED_DATE->ViewValue = FormatDateTime($this->APPROVED_DATE->ViewValue, 0);
            $this->APPROVED_DATE->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // PRINTQ
            $this->PRINTQ->ViewValue = $this->PRINTQ->CurrentValue;
            $this->PRINTQ->ViewValue = FormatNumber($this->PRINTQ->ViewValue, 0, -2, -2, -2);
            $this->PRINTQ->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // PRINTED_BY
            $this->PRINTED_BY->ViewValue = $this->PRINTED_BY->CurrentValue;
            $this->PRINTED_BY->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // PPTK_TITLE
            $this->PPTK_TITLE->ViewValue = $this->PPTK_TITLE->CurrentValue;
            $this->PPTK_TITLE->ViewCustomAttributes = "";

            // APPROVED_ID
            $this->APPROVED_ID->ViewValue = $this->APPROVED_ID->CurrentValue;
            $this->APPROVED_ID->ViewCustomAttributes = "";

            // APPROVED_TITLE
            $this->APPROVED_TITLE->ViewValue = $this->APPROVED_TITLE->CurrentValue;
            $this->APPROVED_TITLE->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // INVOICE_TYPE
            $this->INVOICE_TYPE->LinkCustomAttributes = "";
            $this->INVOICE_TYPE->HrefValue = "";
            $this->INVOICE_TYPE->TooltipValue = "";

            // INVOICE_NO
            $this->INVOICE_NO->LinkCustomAttributes = "";
            $this->INVOICE_NO->HrefValue = "";
            $this->INVOICE_NO->TooltipValue = "";

            // INV_COUNTER
            $this->INV_COUNTER->LinkCustomAttributes = "";
            $this->INV_COUNTER->HrefValue = "";
            $this->INV_COUNTER->TooltipValue = "";

            // INV_DATE
            $this->INV_DATE->LinkCustomAttributes = "";
            $this->INV_DATE->HrefValue = "";
            $this->INV_DATE->TooltipValue = "";

            // INVOICE_TRANS
            $this->INVOICE_TRANS->LinkCustomAttributes = "";
            $this->INVOICE_TRANS->HrefValue = "";
            $this->INVOICE_TRANS->TooltipValue = "";

            // INVOICE_DUE
            $this->INVOICE_DUE->LinkCustomAttributes = "";
            $this->INVOICE_DUE->HrefValue = "";
            $this->INVOICE_DUE->TooltipValue = "";

            // REF_TYPE
            $this->REF_TYPE->LinkCustomAttributes = "";
            $this->REF_TYPE->HrefValue = "";
            $this->REF_TYPE->TooltipValue = "";

            // REF_NO
            $this->REF_NO->LinkCustomAttributes = "";
            $this->REF_NO->HrefValue = "";
            $this->REF_NO->TooltipValue = "";

            // REF_NO2
            $this->REF_NO2->LinkCustomAttributes = "";
            $this->REF_NO2->HrefValue = "";
            $this->REF_NO2->TooltipValue = "";

            // REF_DATE
            $this->REF_DATE->LinkCustomAttributes = "";
            $this->REF_DATE->HrefValue = "";
            $this->REF_DATE->TooltipValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";
            $this->ACCOUNT_ID->TooltipValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";
            $this->YEAR_ID->TooltipValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";
            $this->ORG_ID->TooltipValue = "";

            // PROGRAM_ID
            $this->PROGRAM_ID->LinkCustomAttributes = "";
            $this->PROGRAM_ID->HrefValue = "";
            $this->PROGRAM_ID->TooltipValue = "";

            // PROGRAMS
            $this->PROGRAMS->LinkCustomAttributes = "";
            $this->PROGRAMS->HrefValue = "";
            $this->PROGRAMS->TooltipValue = "";

            // PACTIVITY_ID
            $this->PACTIVITY_ID->LinkCustomAttributes = "";
            $this->PACTIVITY_ID->HrefValue = "";
            $this->PACTIVITY_ID->TooltipValue = "";

            // ACTIVITY_ID
            $this->ACTIVITY_ID->LinkCustomAttributes = "";
            $this->ACTIVITY_ID->HrefValue = "";
            $this->ACTIVITY_ID->TooltipValue = "";

            // ACTIVITY_NAME
            $this->ACTIVITY_NAME->LinkCustomAttributes = "";
            $this->ACTIVITY_NAME->HrefValue = "";
            $this->ACTIVITY_NAME->TooltipValue = "";

            // KEPERLUAN
            $this->KEPERLUAN->LinkCustomAttributes = "";
            $this->KEPERLUAN->HrefValue = "";
            $this->KEPERLUAN->TooltipValue = "";

            // PPTK
            $this->PPTK->LinkCustomAttributes = "";
            $this->PPTK->HrefValue = "";
            $this->PPTK->TooltipValue = "";

            // PPTK_NAME
            $this->PPTK_NAME->LinkCustomAttributes = "";
            $this->PPTK_NAME->HrefValue = "";
            $this->PPTK_NAME->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // COMPANY_TO
            $this->COMPANY_TO->LinkCustomAttributes = "";
            $this->COMPANY_TO->HrefValue = "";
            $this->COMPANY_TO->TooltipValue = "";

            // COMPANY_TYPE
            $this->COMPANY_TYPE->LinkCustomAttributes = "";
            $this->COMPANY_TYPE->HrefValue = "";
            $this->COMPANY_TYPE->TooltipValue = "";

            // COMPANY
            $this->COMPANY->LinkCustomAttributes = "";
            $this->COMPANY->HrefValue = "";
            $this->COMPANY->TooltipValue = "";

            // COMPANY_CHIEF
            $this->COMPANY_CHIEF->LinkCustomAttributes = "";
            $this->COMPANY_CHIEF->HrefValue = "";
            $this->COMPANY_CHIEF->TooltipValue = "";

            // COMPANY_INFO
            $this->COMPANY_INFO->LinkCustomAttributes = "";
            $this->COMPANY_INFO->HrefValue = "";
            $this->COMPANY_INFO->TooltipValue = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->LinkCustomAttributes = "";
            $this->CONTRACT_NO->HrefValue = "";
            $this->CONTRACT_NO->TooltipValue = "";

            // NPWP
            $this->NPWP->LinkCustomAttributes = "";
            $this->NPWP->HrefValue = "";
            $this->NPWP->TooltipValue = "";

            // COMPANY_BANK
            $this->COMPANY_BANK->LinkCustomAttributes = "";
            $this->COMPANY_BANK->HrefValue = "";
            $this->COMPANY_BANK->TooltipValue = "";

            // COMPANY_ACCOUNT
            $this->COMPANY_ACCOUNT->LinkCustomAttributes = "";
            $this->COMPANY_ACCOUNT->HrefValue = "";
            $this->COMPANY_ACCOUNT->TooltipValue = "";

            // PAGU
            $this->PAGU->LinkCustomAttributes = "";
            $this->PAGU->HrefValue = "";
            $this->PAGU->TooltipValue = "";

            // PAGU_REALISASI
            $this->PAGU_REALISASI->LinkCustomAttributes = "";
            $this->PAGU_REALISASI->HrefValue = "";
            $this->PAGU_REALISASI->TooltipValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";
            $this->AMOUNT->TooltipValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";
            $this->AMOUNT_PAID->TooltipValue = "";

            // PAYMENT_INSTRUCTIONS
            $this->PAYMENT_INSTRUCTIONS->LinkCustomAttributes = "";
            $this->PAYMENT_INSTRUCTIONS->HrefValue = "";
            $this->PAYMENT_INSTRUCTIONS->TooltipValue = "";

            // ISAPPROVED
            $this->ISAPPROVED->LinkCustomAttributes = "";
            $this->ISAPPROVED->HrefValue = "";
            $this->ISAPPROVED->TooltipValue = "";

            // APPROVED_BY
            $this->APPROVED_BY->LinkCustomAttributes = "";
            $this->APPROVED_BY->HrefValue = "";
            $this->APPROVED_BY->TooltipValue = "";

            // APPROVED_DATE
            $this->APPROVED_DATE->LinkCustomAttributes = "";
            $this->APPROVED_DATE->HrefValue = "";
            $this->APPROVED_DATE->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";
            $this->PRINTQ->TooltipValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";
            $this->PRINTED_BY->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // PPTK_TITLE
            $this->PPTK_TITLE->LinkCustomAttributes = "";
            $this->PPTK_TITLE->HrefValue = "";
            $this->PPTK_TITLE->TooltipValue = "";

            // APPROVED_ID
            $this->APPROVED_ID->LinkCustomAttributes = "";
            $this->APPROVED_ID->HrefValue = "";
            $this->APPROVED_ID->TooltipValue = "";

            // APPROVED_TITLE
            $this->APPROVED_TITLE->LinkCustomAttributes = "";
            $this->APPROVED_TITLE->HrefValue = "";
            $this->APPROVED_TITLE->TooltipValue = "";
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
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fINVOICElist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fINVOICElist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fINVOICElist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
            return '<button id="emf_INVOICE" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_INVOICE\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fINVOICElist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fINVOICElistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
