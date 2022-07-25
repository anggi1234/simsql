<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodsList extends Goods
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOODS';

    // Page object name
    public $PageObjName = "GoodsList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fGOODSlist";
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

        // Table object (GOODS)
        if (!isset($GLOBALS["GOODS"]) || get_class($GLOBALS["GOODS"]) == PROJECT_NAMESPACE . "GOODS") {
            $GLOBALS["GOODS"] = &$this;
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
        $this->AddUrl = "GoodsAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "GoodsDelete";
        $this->MultiUpdateUrl = "GoodsUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'GOODS');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fGOODSlistsrch";

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
                $doc = new $class(Container("GOODS"));
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
            $key .= @$ar['BRAND_ID'];
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
        $this->CODE_5->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->NAME->setVisibility();
        $this->OTHER_CODE->setVisibility();
        $this->_BARCODE->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->REORDER_POINT->setVisibility();
        $this->SIZE_GOODS->setVisibility();
        $this->MEASURE_DOSIS->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->SIZE_KEMASAN->setVisibility();
        $this->MEASURE_ID3->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->NET_PRICE->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->TH->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->MATERIAL_ID->setVisibility();
        $this->FORM_ID->setVisibility();
        $this->ISGENERIC->setVisibility();
        $this->REGULATE_ID->setVisibility();
        $this->PREGNANCY_INDEX->setVisibility();
        $this->INDICATION->setVisibility();
        $this->TAKE_RULE->setVisibility();
        $this->SIDE_EFFECT->setVisibility();
        $this->INTERACTION->setVisibility();
        $this->CONTRA_INDICATION->setVisibility();
        $this->WARNING->setVisibility();
        $this->STOCK->setVisibility();
        $this->ISACTIVE->setVisibility();
        $this->ISALKES->setVisibility();
        $this->SIZE_ORDER->setVisibility();
        $this->ORDER_PRICE->setVisibility();
        $this->ISFORMULARIUM->setVisibility();
        $this->ISESSENTIAL->setVisibility();
        $this->AVGDATE->setVisibility();
        $this->STOCK_MINIMAL->setVisibility();
        $this->STOCK_MINIMAL_APT->setVisibility();
        $this->HET->setVisibility();
        $this->default_margin->setVisibility();
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
        $filterList = Concat($filterList, $this->CODE_5->AdvancedSearch->toJson(), ","); // Field CODE_5
        $filterList = Concat($filterList, $this->BRAND_ID->AdvancedSearch->toJson(), ","); // Field BRAND_ID
        $filterList = Concat($filterList, $this->NAME->AdvancedSearch->toJson(), ","); // Field NAME
        $filterList = Concat($filterList, $this->OTHER_CODE->AdvancedSearch->toJson(), ","); // Field OTHER_CODE
        $filterList = Concat($filterList, $this->_BARCODE->AdvancedSearch->toJson(), ","); // Field BARCODE
        $filterList = Concat($filterList, $this->DESCRIPTION->AdvancedSearch->toJson(), ","); // Field DESCRIPTION
        $filterList = Concat($filterList, $this->REORDER_POINT->AdvancedSearch->toJson(), ","); // Field REORDER_POINT
        $filterList = Concat($filterList, $this->SIZE_GOODS->AdvancedSearch->toJson(), ","); // Field SIZE_GOODS
        $filterList = Concat($filterList, $this->MEASURE_DOSIS->AdvancedSearch->toJson(), ","); // Field MEASURE_DOSIS
        $filterList = Concat($filterList, $this->MEASURE_ID->AdvancedSearch->toJson(), ","); // Field MEASURE_ID
        $filterList = Concat($filterList, $this->MEASURE_ID2->AdvancedSearch->toJson(), ","); // Field MEASURE_ID2
        $filterList = Concat($filterList, $this->SIZE_KEMASAN->AdvancedSearch->toJson(), ","); // Field SIZE_KEMASAN
        $filterList = Concat($filterList, $this->MEASURE_ID3->AdvancedSearch->toJson(), ","); // Field MEASURE_ID3
        $filterList = Concat($filterList, $this->COMPANY_ID->AdvancedSearch->toJson(), ","); // Field COMPANY_ID
        $filterList = Concat($filterList, $this->NET_PRICE->AdvancedSearch->toJson(), ","); // Field NET_PRICE
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->TH->AdvancedSearch->toJson(), ","); // Field TH
        $filterList = Concat($filterList, $this->STATUS_PASIEN_ID->AdvancedSearch->toJson(), ","); // Field STATUS_PASIEN_ID
        $filterList = Concat($filterList, $this->MATERIAL_ID->AdvancedSearch->toJson(), ","); // Field MATERIAL_ID
        $filterList = Concat($filterList, $this->FORM_ID->AdvancedSearch->toJson(), ","); // Field FORM_ID
        $filterList = Concat($filterList, $this->ISGENERIC->AdvancedSearch->toJson(), ","); // Field ISGENERIC
        $filterList = Concat($filterList, $this->REGULATE_ID->AdvancedSearch->toJson(), ","); // Field REGULATE_ID
        $filterList = Concat($filterList, $this->PREGNANCY_INDEX->AdvancedSearch->toJson(), ","); // Field PREGNANCY_INDEX
        $filterList = Concat($filterList, $this->INDICATION->AdvancedSearch->toJson(), ","); // Field INDICATION
        $filterList = Concat($filterList, $this->TAKE_RULE->AdvancedSearch->toJson(), ","); // Field TAKE_RULE
        $filterList = Concat($filterList, $this->SIDE_EFFECT->AdvancedSearch->toJson(), ","); // Field SIDE_EFFECT
        $filterList = Concat($filterList, $this->INTERACTION->AdvancedSearch->toJson(), ","); // Field INTERACTION
        $filterList = Concat($filterList, $this->CONTRA_INDICATION->AdvancedSearch->toJson(), ","); // Field CONTRA_INDICATION
        $filterList = Concat($filterList, $this->WARNING->AdvancedSearch->toJson(), ","); // Field WARNING
        $filterList = Concat($filterList, $this->STOCK->AdvancedSearch->toJson(), ","); // Field STOCK
        $filterList = Concat($filterList, $this->ISACTIVE->AdvancedSearch->toJson(), ","); // Field ISACTIVE
        $filterList = Concat($filterList, $this->ISALKES->AdvancedSearch->toJson(), ","); // Field ISALKES
        $filterList = Concat($filterList, $this->SIZE_ORDER->AdvancedSearch->toJson(), ","); // Field SIZE_ORDER
        $filterList = Concat($filterList, $this->ORDER_PRICE->AdvancedSearch->toJson(), ","); // Field ORDER_PRICE
        $filterList = Concat($filterList, $this->ISFORMULARIUM->AdvancedSearch->toJson(), ","); // Field ISFORMULARIUM
        $filterList = Concat($filterList, $this->ISESSENTIAL->AdvancedSearch->toJson(), ","); // Field ISESSENTIAL
        $filterList = Concat($filterList, $this->AVGDATE->AdvancedSearch->toJson(), ","); // Field AVGDATE
        $filterList = Concat($filterList, $this->STOCK_MINIMAL->AdvancedSearch->toJson(), ","); // Field STOCK_MINIMAL
        $filterList = Concat($filterList, $this->STOCK_MINIMAL_APT->AdvancedSearch->toJson(), ","); // Field STOCK_MINIMAL_APT
        $filterList = Concat($filterList, $this->HET->AdvancedSearch->toJson(), ","); // Field HET
        $filterList = Concat($filterList, $this->default_margin->AdvancedSearch->toJson(), ","); // Field default_margin
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fGOODSlistsrch", $filters);
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

        // Field CODE_5
        $this->CODE_5->AdvancedSearch->SearchValue = @$filter["x_CODE_5"];
        $this->CODE_5->AdvancedSearch->SearchOperator = @$filter["z_CODE_5"];
        $this->CODE_5->AdvancedSearch->SearchCondition = @$filter["v_CODE_5"];
        $this->CODE_5->AdvancedSearch->SearchValue2 = @$filter["y_CODE_5"];
        $this->CODE_5->AdvancedSearch->SearchOperator2 = @$filter["w_CODE_5"];
        $this->CODE_5->AdvancedSearch->save();

        // Field BRAND_ID
        $this->BRAND_ID->AdvancedSearch->SearchValue = @$filter["x_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator = @$filter["z_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchCondition = @$filter["v_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchValue2 = @$filter["y_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->save();

        // Field NAME
        $this->NAME->AdvancedSearch->SearchValue = @$filter["x_NAME"];
        $this->NAME->AdvancedSearch->SearchOperator = @$filter["z_NAME"];
        $this->NAME->AdvancedSearch->SearchCondition = @$filter["v_NAME"];
        $this->NAME->AdvancedSearch->SearchValue2 = @$filter["y_NAME"];
        $this->NAME->AdvancedSearch->SearchOperator2 = @$filter["w_NAME"];
        $this->NAME->AdvancedSearch->save();

        // Field OTHER_CODE
        $this->OTHER_CODE->AdvancedSearch->SearchValue = @$filter["x_OTHER_CODE"];
        $this->OTHER_CODE->AdvancedSearch->SearchOperator = @$filter["z_OTHER_CODE"];
        $this->OTHER_CODE->AdvancedSearch->SearchCondition = @$filter["v_OTHER_CODE"];
        $this->OTHER_CODE->AdvancedSearch->SearchValue2 = @$filter["y_OTHER_CODE"];
        $this->OTHER_CODE->AdvancedSearch->SearchOperator2 = @$filter["w_OTHER_CODE"];
        $this->OTHER_CODE->AdvancedSearch->save();

        // Field BARCODE
        $this->_BARCODE->AdvancedSearch->SearchValue = @$filter["x__BARCODE"];
        $this->_BARCODE->AdvancedSearch->SearchOperator = @$filter["z__BARCODE"];
        $this->_BARCODE->AdvancedSearch->SearchCondition = @$filter["v__BARCODE"];
        $this->_BARCODE->AdvancedSearch->SearchValue2 = @$filter["y__BARCODE"];
        $this->_BARCODE->AdvancedSearch->SearchOperator2 = @$filter["w__BARCODE"];
        $this->_BARCODE->AdvancedSearch->save();

        // Field DESCRIPTION
        $this->DESCRIPTION->AdvancedSearch->SearchValue = @$filter["x_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator = @$filter["z_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchCondition = @$filter["v_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchValue2 = @$filter["y_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator2 = @$filter["w_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->save();

        // Field REORDER_POINT
        $this->REORDER_POINT->AdvancedSearch->SearchValue = @$filter["x_REORDER_POINT"];
        $this->REORDER_POINT->AdvancedSearch->SearchOperator = @$filter["z_REORDER_POINT"];
        $this->REORDER_POINT->AdvancedSearch->SearchCondition = @$filter["v_REORDER_POINT"];
        $this->REORDER_POINT->AdvancedSearch->SearchValue2 = @$filter["y_REORDER_POINT"];
        $this->REORDER_POINT->AdvancedSearch->SearchOperator2 = @$filter["w_REORDER_POINT"];
        $this->REORDER_POINT->AdvancedSearch->save();

        // Field SIZE_GOODS
        $this->SIZE_GOODS->AdvancedSearch->SearchValue = @$filter["x_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchOperator = @$filter["z_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchCondition = @$filter["v_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchValue2 = @$filter["y_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->SearchOperator2 = @$filter["w_SIZE_GOODS"];
        $this->SIZE_GOODS->AdvancedSearch->save();

        // Field MEASURE_DOSIS
        $this->MEASURE_DOSIS->AdvancedSearch->SearchValue = @$filter["x_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_DOSIS"];
        $this->MEASURE_DOSIS->AdvancedSearch->save();

        // Field MEASURE_ID
        $this->MEASURE_ID->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->save();

        // Field MEASURE_ID2
        $this->MEASURE_ID2->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->save();

        // Field SIZE_KEMASAN
        $this->SIZE_KEMASAN->AdvancedSearch->SearchValue = @$filter["x_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchOperator = @$filter["z_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchCondition = @$filter["v_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchValue2 = @$filter["y_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchOperator2 = @$filter["w_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->save();

        // Field MEASURE_ID3
        $this->MEASURE_ID3->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->save();

        // Field COMPANY_ID
        $this->COMPANY_ID->AdvancedSearch->SearchValue = @$filter["x_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->save();

        // Field NET_PRICE
        $this->NET_PRICE->AdvancedSearch->SearchValue = @$filter["x_NET_PRICE"];
        $this->NET_PRICE->AdvancedSearch->SearchOperator = @$filter["z_NET_PRICE"];
        $this->NET_PRICE->AdvancedSearch->SearchCondition = @$filter["v_NET_PRICE"];
        $this->NET_PRICE->AdvancedSearch->SearchValue2 = @$filter["y_NET_PRICE"];
        $this->NET_PRICE->AdvancedSearch->SearchOperator2 = @$filter["w_NET_PRICE"];
        $this->NET_PRICE->AdvancedSearch->save();

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

        // Field TH
        $this->TH->AdvancedSearch->SearchValue = @$filter["x_TH"];
        $this->TH->AdvancedSearch->SearchOperator = @$filter["z_TH"];
        $this->TH->AdvancedSearch->SearchCondition = @$filter["v_TH"];
        $this->TH->AdvancedSearch->SearchValue2 = @$filter["y_TH"];
        $this->TH->AdvancedSearch->SearchOperator2 = @$filter["w_TH"];
        $this->TH->AdvancedSearch->save();

        // Field STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue = @$filter["x_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator = @$filter["z_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchCondition = @$filter["v_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->save();

        // Field MATERIAL_ID
        $this->MATERIAL_ID->AdvancedSearch->SearchValue = @$filter["x_MATERIAL_ID"];
        $this->MATERIAL_ID->AdvancedSearch->SearchOperator = @$filter["z_MATERIAL_ID"];
        $this->MATERIAL_ID->AdvancedSearch->SearchCondition = @$filter["v_MATERIAL_ID"];
        $this->MATERIAL_ID->AdvancedSearch->SearchValue2 = @$filter["y_MATERIAL_ID"];
        $this->MATERIAL_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MATERIAL_ID"];
        $this->MATERIAL_ID->AdvancedSearch->save();

        // Field FORM_ID
        $this->FORM_ID->AdvancedSearch->SearchValue = @$filter["x_FORM_ID"];
        $this->FORM_ID->AdvancedSearch->SearchOperator = @$filter["z_FORM_ID"];
        $this->FORM_ID->AdvancedSearch->SearchCondition = @$filter["v_FORM_ID"];
        $this->FORM_ID->AdvancedSearch->SearchValue2 = @$filter["y_FORM_ID"];
        $this->FORM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FORM_ID"];
        $this->FORM_ID->AdvancedSearch->save();

        // Field ISGENERIC
        $this->ISGENERIC->AdvancedSearch->SearchValue = @$filter["x_ISGENERIC"];
        $this->ISGENERIC->AdvancedSearch->SearchOperator = @$filter["z_ISGENERIC"];
        $this->ISGENERIC->AdvancedSearch->SearchCondition = @$filter["v_ISGENERIC"];
        $this->ISGENERIC->AdvancedSearch->SearchValue2 = @$filter["y_ISGENERIC"];
        $this->ISGENERIC->AdvancedSearch->SearchOperator2 = @$filter["w_ISGENERIC"];
        $this->ISGENERIC->AdvancedSearch->save();

        // Field REGULATE_ID
        $this->REGULATE_ID->AdvancedSearch->SearchValue = @$filter["x_REGULATE_ID"];
        $this->REGULATE_ID->AdvancedSearch->SearchOperator = @$filter["z_REGULATE_ID"];
        $this->REGULATE_ID->AdvancedSearch->SearchCondition = @$filter["v_REGULATE_ID"];
        $this->REGULATE_ID->AdvancedSearch->SearchValue2 = @$filter["y_REGULATE_ID"];
        $this->REGULATE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_REGULATE_ID"];
        $this->REGULATE_ID->AdvancedSearch->save();

        // Field PREGNANCY_INDEX
        $this->PREGNANCY_INDEX->AdvancedSearch->SearchValue = @$filter["x_PREGNANCY_INDEX"];
        $this->PREGNANCY_INDEX->AdvancedSearch->SearchOperator = @$filter["z_PREGNANCY_INDEX"];
        $this->PREGNANCY_INDEX->AdvancedSearch->SearchCondition = @$filter["v_PREGNANCY_INDEX"];
        $this->PREGNANCY_INDEX->AdvancedSearch->SearchValue2 = @$filter["y_PREGNANCY_INDEX"];
        $this->PREGNANCY_INDEX->AdvancedSearch->SearchOperator2 = @$filter["w_PREGNANCY_INDEX"];
        $this->PREGNANCY_INDEX->AdvancedSearch->save();

        // Field INDICATION
        $this->INDICATION->AdvancedSearch->SearchValue = @$filter["x_INDICATION"];
        $this->INDICATION->AdvancedSearch->SearchOperator = @$filter["z_INDICATION"];
        $this->INDICATION->AdvancedSearch->SearchCondition = @$filter["v_INDICATION"];
        $this->INDICATION->AdvancedSearch->SearchValue2 = @$filter["y_INDICATION"];
        $this->INDICATION->AdvancedSearch->SearchOperator2 = @$filter["w_INDICATION"];
        $this->INDICATION->AdvancedSearch->save();

        // Field TAKE_RULE
        $this->TAKE_RULE->AdvancedSearch->SearchValue = @$filter["x_TAKE_RULE"];
        $this->TAKE_RULE->AdvancedSearch->SearchOperator = @$filter["z_TAKE_RULE"];
        $this->TAKE_RULE->AdvancedSearch->SearchCondition = @$filter["v_TAKE_RULE"];
        $this->TAKE_RULE->AdvancedSearch->SearchValue2 = @$filter["y_TAKE_RULE"];
        $this->TAKE_RULE->AdvancedSearch->SearchOperator2 = @$filter["w_TAKE_RULE"];
        $this->TAKE_RULE->AdvancedSearch->save();

        // Field SIDE_EFFECT
        $this->SIDE_EFFECT->AdvancedSearch->SearchValue = @$filter["x_SIDE_EFFECT"];
        $this->SIDE_EFFECT->AdvancedSearch->SearchOperator = @$filter["z_SIDE_EFFECT"];
        $this->SIDE_EFFECT->AdvancedSearch->SearchCondition = @$filter["v_SIDE_EFFECT"];
        $this->SIDE_EFFECT->AdvancedSearch->SearchValue2 = @$filter["y_SIDE_EFFECT"];
        $this->SIDE_EFFECT->AdvancedSearch->SearchOperator2 = @$filter["w_SIDE_EFFECT"];
        $this->SIDE_EFFECT->AdvancedSearch->save();

        // Field INTERACTION
        $this->INTERACTION->AdvancedSearch->SearchValue = @$filter["x_INTERACTION"];
        $this->INTERACTION->AdvancedSearch->SearchOperator = @$filter["z_INTERACTION"];
        $this->INTERACTION->AdvancedSearch->SearchCondition = @$filter["v_INTERACTION"];
        $this->INTERACTION->AdvancedSearch->SearchValue2 = @$filter["y_INTERACTION"];
        $this->INTERACTION->AdvancedSearch->SearchOperator2 = @$filter["w_INTERACTION"];
        $this->INTERACTION->AdvancedSearch->save();

        // Field CONTRA_INDICATION
        $this->CONTRA_INDICATION->AdvancedSearch->SearchValue = @$filter["x_CONTRA_INDICATION"];
        $this->CONTRA_INDICATION->AdvancedSearch->SearchOperator = @$filter["z_CONTRA_INDICATION"];
        $this->CONTRA_INDICATION->AdvancedSearch->SearchCondition = @$filter["v_CONTRA_INDICATION"];
        $this->CONTRA_INDICATION->AdvancedSearch->SearchValue2 = @$filter["y_CONTRA_INDICATION"];
        $this->CONTRA_INDICATION->AdvancedSearch->SearchOperator2 = @$filter["w_CONTRA_INDICATION"];
        $this->CONTRA_INDICATION->AdvancedSearch->save();

        // Field WARNING
        $this->WARNING->AdvancedSearch->SearchValue = @$filter["x_WARNING"];
        $this->WARNING->AdvancedSearch->SearchOperator = @$filter["z_WARNING"];
        $this->WARNING->AdvancedSearch->SearchCondition = @$filter["v_WARNING"];
        $this->WARNING->AdvancedSearch->SearchValue2 = @$filter["y_WARNING"];
        $this->WARNING->AdvancedSearch->SearchOperator2 = @$filter["w_WARNING"];
        $this->WARNING->AdvancedSearch->save();

        // Field STOCK
        $this->STOCK->AdvancedSearch->SearchValue = @$filter["x_STOCK"];
        $this->STOCK->AdvancedSearch->SearchOperator = @$filter["z_STOCK"];
        $this->STOCK->AdvancedSearch->SearchCondition = @$filter["v_STOCK"];
        $this->STOCK->AdvancedSearch->SearchValue2 = @$filter["y_STOCK"];
        $this->STOCK->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK"];
        $this->STOCK->AdvancedSearch->save();

        // Field ISACTIVE
        $this->ISACTIVE->AdvancedSearch->SearchValue = @$filter["x_ISACTIVE"];
        $this->ISACTIVE->AdvancedSearch->SearchOperator = @$filter["z_ISACTIVE"];
        $this->ISACTIVE->AdvancedSearch->SearchCondition = @$filter["v_ISACTIVE"];
        $this->ISACTIVE->AdvancedSearch->SearchValue2 = @$filter["y_ISACTIVE"];
        $this->ISACTIVE->AdvancedSearch->SearchOperator2 = @$filter["w_ISACTIVE"];
        $this->ISACTIVE->AdvancedSearch->save();

        // Field ISALKES
        $this->ISALKES->AdvancedSearch->SearchValue = @$filter["x_ISALKES"];
        $this->ISALKES->AdvancedSearch->SearchOperator = @$filter["z_ISALKES"];
        $this->ISALKES->AdvancedSearch->SearchCondition = @$filter["v_ISALKES"];
        $this->ISALKES->AdvancedSearch->SearchValue2 = @$filter["y_ISALKES"];
        $this->ISALKES->AdvancedSearch->SearchOperator2 = @$filter["w_ISALKES"];
        $this->ISALKES->AdvancedSearch->save();

        // Field SIZE_ORDER
        $this->SIZE_ORDER->AdvancedSearch->SearchValue = @$filter["x_SIZE_ORDER"];
        $this->SIZE_ORDER->AdvancedSearch->SearchOperator = @$filter["z_SIZE_ORDER"];
        $this->SIZE_ORDER->AdvancedSearch->SearchCondition = @$filter["v_SIZE_ORDER"];
        $this->SIZE_ORDER->AdvancedSearch->SearchValue2 = @$filter["y_SIZE_ORDER"];
        $this->SIZE_ORDER->AdvancedSearch->SearchOperator2 = @$filter["w_SIZE_ORDER"];
        $this->SIZE_ORDER->AdvancedSearch->save();

        // Field ORDER_PRICE
        $this->ORDER_PRICE->AdvancedSearch->SearchValue = @$filter["x_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchOperator = @$filter["z_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchCondition = @$filter["v_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchValue2 = @$filter["y_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchOperator2 = @$filter["w_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->save();

        // Field ISFORMULARIUM
        $this->ISFORMULARIUM->AdvancedSearch->SearchValue = @$filter["x_ISFORMULARIUM"];
        $this->ISFORMULARIUM->AdvancedSearch->SearchOperator = @$filter["z_ISFORMULARIUM"];
        $this->ISFORMULARIUM->AdvancedSearch->SearchCondition = @$filter["v_ISFORMULARIUM"];
        $this->ISFORMULARIUM->AdvancedSearch->SearchValue2 = @$filter["y_ISFORMULARIUM"];
        $this->ISFORMULARIUM->AdvancedSearch->SearchOperator2 = @$filter["w_ISFORMULARIUM"];
        $this->ISFORMULARIUM->AdvancedSearch->save();

        // Field ISESSENTIAL
        $this->ISESSENTIAL->AdvancedSearch->SearchValue = @$filter["x_ISESSENTIAL"];
        $this->ISESSENTIAL->AdvancedSearch->SearchOperator = @$filter["z_ISESSENTIAL"];
        $this->ISESSENTIAL->AdvancedSearch->SearchCondition = @$filter["v_ISESSENTIAL"];
        $this->ISESSENTIAL->AdvancedSearch->SearchValue2 = @$filter["y_ISESSENTIAL"];
        $this->ISESSENTIAL->AdvancedSearch->SearchOperator2 = @$filter["w_ISESSENTIAL"];
        $this->ISESSENTIAL->AdvancedSearch->save();

        // Field AVGDATE
        $this->AVGDATE->AdvancedSearch->SearchValue = @$filter["x_AVGDATE"];
        $this->AVGDATE->AdvancedSearch->SearchOperator = @$filter["z_AVGDATE"];
        $this->AVGDATE->AdvancedSearch->SearchCondition = @$filter["v_AVGDATE"];
        $this->AVGDATE->AdvancedSearch->SearchValue2 = @$filter["y_AVGDATE"];
        $this->AVGDATE->AdvancedSearch->SearchOperator2 = @$filter["w_AVGDATE"];
        $this->AVGDATE->AdvancedSearch->save();

        // Field STOCK_MINIMAL
        $this->STOCK_MINIMAL->AdvancedSearch->SearchValue = @$filter["x_STOCK_MINIMAL"];
        $this->STOCK_MINIMAL->AdvancedSearch->SearchOperator = @$filter["z_STOCK_MINIMAL"];
        $this->STOCK_MINIMAL->AdvancedSearch->SearchCondition = @$filter["v_STOCK_MINIMAL"];
        $this->STOCK_MINIMAL->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_MINIMAL"];
        $this->STOCK_MINIMAL->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_MINIMAL"];
        $this->STOCK_MINIMAL->AdvancedSearch->save();

        // Field STOCK_MINIMAL_APT
        $this->STOCK_MINIMAL_APT->AdvancedSearch->SearchValue = @$filter["x_STOCK_MINIMAL_APT"];
        $this->STOCK_MINIMAL_APT->AdvancedSearch->SearchOperator = @$filter["z_STOCK_MINIMAL_APT"];
        $this->STOCK_MINIMAL_APT->AdvancedSearch->SearchCondition = @$filter["v_STOCK_MINIMAL_APT"];
        $this->STOCK_MINIMAL_APT->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_MINIMAL_APT"];
        $this->STOCK_MINIMAL_APT->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_MINIMAL_APT"];
        $this->STOCK_MINIMAL_APT->AdvancedSearch->save();

        // Field HET
        $this->HET->AdvancedSearch->SearchValue = @$filter["x_HET"];
        $this->HET->AdvancedSearch->SearchOperator = @$filter["z_HET"];
        $this->HET->AdvancedSearch->SearchCondition = @$filter["v_HET"];
        $this->HET->AdvancedSearch->SearchValue2 = @$filter["y_HET"];
        $this->HET->AdvancedSearch->SearchOperator2 = @$filter["w_HET"];
        $this->HET->AdvancedSearch->save();

        // Field default_margin
        $this->default_margin->AdvancedSearch->SearchValue = @$filter["x_default_margin"];
        $this->default_margin->AdvancedSearch->SearchOperator = @$filter["z_default_margin"];
        $this->default_margin->AdvancedSearch->SearchCondition = @$filter["v_default_margin"];
        $this->default_margin->AdvancedSearch->SearchValue2 = @$filter["y_default_margin"];
        $this->default_margin->AdvancedSearch->SearchOperator2 = @$filter["w_default_margin"];
        $this->default_margin->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->CODE_5, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BRAND_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->OTHER_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->_BARCODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DESCRIPTION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISGENERIC, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PREGNANCY_INDEX, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INDICATION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->TAKE_RULE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->SIDE_EFFECT, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INTERACTION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CONTRA_INDICATION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->WARNING, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISACTIVE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISALKES, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISFORMULARIUM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISESSENTIAL, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->default_margin, $arKeywords, $type);
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
            $this->updateSort($this->CODE_5); // CODE_5
            $this->updateSort($this->BRAND_ID); // BRAND_ID
            $this->updateSort($this->NAME); // NAME
            $this->updateSort($this->OTHER_CODE); // OTHER_CODE
            $this->updateSort($this->_BARCODE); // BARCODE
            $this->updateSort($this->DESCRIPTION); // DESCRIPTION
            $this->updateSort($this->REORDER_POINT); // REORDER_POINT
            $this->updateSort($this->SIZE_GOODS); // SIZE_GOODS
            $this->updateSort($this->MEASURE_DOSIS); // MEASURE_DOSIS
            $this->updateSort($this->MEASURE_ID); // MEASURE_ID
            $this->updateSort($this->MEASURE_ID2); // MEASURE_ID2
            $this->updateSort($this->SIZE_KEMASAN); // SIZE_KEMASAN
            $this->updateSort($this->MEASURE_ID3); // MEASURE_ID3
            $this->updateSort($this->COMPANY_ID); // COMPANY_ID
            $this->updateSort($this->NET_PRICE); // NET_PRICE
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->TH); // TH
            $this->updateSort($this->STATUS_PASIEN_ID); // STATUS_PASIEN_ID
            $this->updateSort($this->MATERIAL_ID); // MATERIAL_ID
            $this->updateSort($this->FORM_ID); // FORM_ID
            $this->updateSort($this->ISGENERIC); // ISGENERIC
            $this->updateSort($this->REGULATE_ID); // REGULATE_ID
            $this->updateSort($this->PREGNANCY_INDEX); // PREGNANCY_INDEX
            $this->updateSort($this->INDICATION); // INDICATION
            $this->updateSort($this->TAKE_RULE); // TAKE_RULE
            $this->updateSort($this->SIDE_EFFECT); // SIDE_EFFECT
            $this->updateSort($this->INTERACTION); // INTERACTION
            $this->updateSort($this->CONTRA_INDICATION); // CONTRA_INDICATION
            $this->updateSort($this->WARNING); // WARNING
            $this->updateSort($this->STOCK); // STOCK
            $this->updateSort($this->ISACTIVE); // ISACTIVE
            $this->updateSort($this->ISALKES); // ISALKES
            $this->updateSort($this->SIZE_ORDER); // SIZE_ORDER
            $this->updateSort($this->ORDER_PRICE); // ORDER_PRICE
            $this->updateSort($this->ISFORMULARIUM); // ISFORMULARIUM
            $this->updateSort($this->ISESSENTIAL); // ISESSENTIAL
            $this->updateSort($this->AVGDATE); // AVGDATE
            $this->updateSort($this->STOCK_MINIMAL); // STOCK_MINIMAL
            $this->updateSort($this->STOCK_MINIMAL_APT); // STOCK_MINIMAL_APT
            $this->updateSort($this->HET); // HET
            $this->updateSort($this->default_margin); // default_margin
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
                $this->CODE_5->setSort("");
                $this->BRAND_ID->setSort("");
                $this->NAME->setSort("");
                $this->OTHER_CODE->setSort("");
                $this->_BARCODE->setSort("");
                $this->DESCRIPTION->setSort("");
                $this->REORDER_POINT->setSort("");
                $this->SIZE_GOODS->setSort("");
                $this->MEASURE_DOSIS->setSort("");
                $this->MEASURE_ID->setSort("");
                $this->MEASURE_ID2->setSort("");
                $this->SIZE_KEMASAN->setSort("");
                $this->MEASURE_ID3->setSort("");
                $this->COMPANY_ID->setSort("");
                $this->NET_PRICE->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->TH->setSort("");
                $this->STATUS_PASIEN_ID->setSort("");
                $this->MATERIAL_ID->setSort("");
                $this->FORM_ID->setSort("");
                $this->ISGENERIC->setSort("");
                $this->REGULATE_ID->setSort("");
                $this->PREGNANCY_INDEX->setSort("");
                $this->INDICATION->setSort("");
                $this->TAKE_RULE->setSort("");
                $this->SIDE_EFFECT->setSort("");
                $this->INTERACTION->setSort("");
                $this->CONTRA_INDICATION->setSort("");
                $this->WARNING->setSort("");
                $this->STOCK->setSort("");
                $this->ISACTIVE->setSort("");
                $this->ISALKES->setSort("");
                $this->SIZE_ORDER->setSort("");
                $this->ORDER_PRICE->setSort("");
                $this->ISFORMULARIUM->setSort("");
                $this->ISESSENTIAL->setSort("");
                $this->AVGDATE->setSort("");
                $this->STOCK_MINIMAL->setSort("");
                $this->STOCK_MINIMAL_APT->setSort("");
                $this->HET->setSort("");
                $this->default_margin->setSort("");
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->BRAND_ID->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fGOODSlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fGOODSlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fGOODSlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->CODE_5->setDbValue($row['CODE_5']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->NAME->setDbValue($row['NAME']);
        $this->OTHER_CODE->setDbValue($row['OTHER_CODE']);
        $this->_BARCODE->setDbValue($row['BARCODE']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->REORDER_POINT->setDbValue($row['REORDER_POINT']);
        $this->SIZE_GOODS->setDbValue($row['SIZE_GOODS']);
        $this->MEASURE_DOSIS->setDbValue($row['MEASURE_DOSIS']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->SIZE_KEMASAN->setDbValue($row['SIZE_KEMASAN']);
        $this->MEASURE_ID3->setDbValue($row['MEASURE_ID3']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->NET_PRICE->setDbValue($row['NET_PRICE']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->TH->setDbValue($row['TH']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->MATERIAL_ID->setDbValue($row['MATERIAL_ID']);
        $this->FORM_ID->setDbValue($row['FORM_ID']);
        $this->ISGENERIC->setDbValue($row['ISGENERIC']);
        $this->REGULATE_ID->setDbValue($row['REGULATE_ID']);
        $this->PREGNANCY_INDEX->setDbValue($row['PREGNANCY_INDEX']);
        $this->INDICATION->setDbValue($row['INDICATION']);
        $this->TAKE_RULE->setDbValue($row['TAKE_RULE']);
        $this->SIDE_EFFECT->setDbValue($row['SIDE_EFFECT']);
        $this->INTERACTION->setDbValue($row['INTERACTION']);
        $this->CONTRA_INDICATION->setDbValue($row['CONTRA_INDICATION']);
        $this->WARNING->setDbValue($row['WARNING']);
        $this->STOCK->setDbValue($row['STOCK']);
        $this->ISACTIVE->setDbValue($row['ISACTIVE']);
        $this->ISALKES->setDbValue($row['ISALKES']);
        $this->SIZE_ORDER->setDbValue($row['SIZE_ORDER']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->ISFORMULARIUM->setDbValue($row['ISFORMULARIUM']);
        $this->ISESSENTIAL->setDbValue($row['ISESSENTIAL']);
        $this->AVGDATE->setDbValue($row['AVGDATE']);
        $this->STOCK_MINIMAL->setDbValue($row['STOCK_MINIMAL']);
        $this->STOCK_MINIMAL_APT->setDbValue($row['STOCK_MINIMAL_APT']);
        $this->HET->setDbValue($row['HET']);
        $this->default_margin->setDbValue($row['default_margin']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['CODE_5'] = null;
        $row['BRAND_ID'] = null;
        $row['NAME'] = null;
        $row['OTHER_CODE'] = null;
        $row['BARCODE'] = null;
        $row['DESCRIPTION'] = null;
        $row['REORDER_POINT'] = null;
        $row['SIZE_GOODS'] = null;
        $row['MEASURE_DOSIS'] = null;
        $row['MEASURE_ID'] = null;
        $row['MEASURE_ID2'] = null;
        $row['SIZE_KEMASAN'] = null;
        $row['MEASURE_ID3'] = null;
        $row['COMPANY_ID'] = null;
        $row['NET_PRICE'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['TH'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['MATERIAL_ID'] = null;
        $row['FORM_ID'] = null;
        $row['ISGENERIC'] = null;
        $row['REGULATE_ID'] = null;
        $row['PREGNANCY_INDEX'] = null;
        $row['INDICATION'] = null;
        $row['TAKE_RULE'] = null;
        $row['SIDE_EFFECT'] = null;
        $row['INTERACTION'] = null;
        $row['CONTRA_INDICATION'] = null;
        $row['WARNING'] = null;
        $row['STOCK'] = null;
        $row['ISACTIVE'] = null;
        $row['ISALKES'] = null;
        $row['SIZE_ORDER'] = null;
        $row['ORDER_PRICE'] = null;
        $row['ISFORMULARIUM'] = null;
        $row['ISESSENTIAL'] = null;
        $row['AVGDATE'] = null;
        $row['STOCK_MINIMAL'] = null;
        $row['STOCK_MINIMAL_APT'] = null;
        $row['HET'] = null;
        $row['default_margin'] = null;
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
        if ($this->REORDER_POINT->FormValue == $this->REORDER_POINT->CurrentValue && is_numeric(ConvertToFloatString($this->REORDER_POINT->CurrentValue))) {
            $this->REORDER_POINT->CurrentValue = ConvertToFloatString($this->REORDER_POINT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_GOODS->FormValue == $this->SIZE_GOODS->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_GOODS->CurrentValue))) {
            $this->SIZE_GOODS->CurrentValue = ConvertToFloatString($this->SIZE_GOODS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_KEMASAN->FormValue == $this->SIZE_KEMASAN->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue))) {
            $this->SIZE_KEMASAN->CurrentValue = ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->NET_PRICE->FormValue == $this->NET_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->NET_PRICE->CurrentValue))) {
            $this->NET_PRICE->CurrentValue = ConvertToFloatString($this->NET_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK->FormValue == $this->STOCK->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK->CurrentValue))) {
            $this->STOCK->CurrentValue = ConvertToFloatString($this->STOCK->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_ORDER->FormValue == $this->SIZE_ORDER->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_ORDER->CurrentValue))) {
            $this->SIZE_ORDER->CurrentValue = ConvertToFloatString($this->SIZE_ORDER->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_PRICE->FormValue == $this->ORDER_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_PRICE->CurrentValue))) {
            $this->ORDER_PRICE->CurrentValue = ConvertToFloatString($this->ORDER_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_MINIMAL->FormValue == $this->STOCK_MINIMAL->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_MINIMAL->CurrentValue))) {
            $this->STOCK_MINIMAL->CurrentValue = ConvertToFloatString($this->STOCK_MINIMAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_MINIMAL_APT->FormValue == $this->STOCK_MINIMAL_APT->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_MINIMAL_APT->CurrentValue))) {
            $this->STOCK_MINIMAL_APT->CurrentValue = ConvertToFloatString($this->STOCK_MINIMAL_APT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->HET->FormValue == $this->HET->CurrentValue && is_numeric(ConvertToFloatString($this->HET->CurrentValue))) {
            $this->HET->CurrentValue = ConvertToFloatString($this->HET->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // CODE_5

        // BRAND_ID

        // NAME

        // OTHER_CODE

        // BARCODE

        // DESCRIPTION

        // REORDER_POINT

        // SIZE_GOODS

        // MEASURE_DOSIS

        // MEASURE_ID

        // MEASURE_ID2

        // SIZE_KEMASAN

        // MEASURE_ID3

        // COMPANY_ID

        // NET_PRICE

        // MODIFIED_DATE

        // MODIFIED_BY

        // TH

        // STATUS_PASIEN_ID

        // MATERIAL_ID

        // FORM_ID

        // ISGENERIC

        // REGULATE_ID

        // PREGNANCY_INDEX

        // INDICATION

        // TAKE_RULE

        // SIDE_EFFECT

        // INTERACTION

        // CONTRA_INDICATION

        // WARNING

        // STOCK

        // ISACTIVE

        // ISALKES

        // SIZE_ORDER

        // ORDER_PRICE

        // ISFORMULARIUM

        // ISESSENTIAL

        // AVGDATE

        // STOCK_MINIMAL

        // STOCK_MINIMAL_APT

        // HET

        // default_margin
        if ($this->RowType == ROWTYPE_VIEW) {
            // CODE_5
            $this->CODE_5->ViewValue = $this->CODE_5->CurrentValue;
            $this->CODE_5->ViewCustomAttributes = "";

            // BRAND_ID
            $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
            $this->BRAND_ID->ViewCustomAttributes = "";

            // NAME
            $this->NAME->ViewValue = $this->NAME->CurrentValue;
            $this->NAME->ViewCustomAttributes = "";

            // OTHER_CODE
            $this->OTHER_CODE->ViewValue = $this->OTHER_CODE->CurrentValue;
            $this->OTHER_CODE->ViewCustomAttributes = "";

            // BARCODE
            $this->_BARCODE->ViewValue = $this->_BARCODE->CurrentValue;
            $this->_BARCODE->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // REORDER_POINT
            $this->REORDER_POINT->ViewValue = $this->REORDER_POINT->CurrentValue;
            $this->REORDER_POINT->ViewValue = FormatNumber($this->REORDER_POINT->ViewValue, 2, -2, -2, -2);
            $this->REORDER_POINT->ViewCustomAttributes = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->ViewValue = $this->SIZE_GOODS->CurrentValue;
            $this->SIZE_GOODS->ViewValue = FormatNumber($this->SIZE_GOODS->ViewValue, 2, -2, -2, -2);
            $this->SIZE_GOODS->ViewCustomAttributes = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->ViewValue = $this->MEASURE_DOSIS->CurrentValue;
            $this->MEASURE_DOSIS->ViewValue = FormatNumber($this->MEASURE_DOSIS->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_DOSIS->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
            $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID2->ViewCustomAttributes = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->ViewValue = $this->SIZE_KEMASAN->CurrentValue;
            $this->SIZE_KEMASAN->ViewValue = FormatNumber($this->SIZE_KEMASAN->ViewValue, 2, -2, -2, -2);
            $this->SIZE_KEMASAN->ViewCustomAttributes = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->ViewValue = $this->MEASURE_ID3->CurrentValue;
            $this->MEASURE_ID3->ViewValue = FormatNumber($this->MEASURE_ID3->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID3->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // NET_PRICE
            $this->NET_PRICE->ViewValue = $this->NET_PRICE->CurrentValue;
            $this->NET_PRICE->ViewValue = FormatNumber($this->NET_PRICE->ViewValue, 2, -2, -2, -2);
            $this->NET_PRICE->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // TH
            $this->TH->ViewValue = $this->TH->CurrentValue;
            $this->TH->ViewValue = FormatNumber($this->TH->ViewValue, 0, -2, -2, -2);
            $this->TH->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // MATERIAL_ID
            $this->MATERIAL_ID->ViewValue = $this->MATERIAL_ID->CurrentValue;
            $this->MATERIAL_ID->ViewValue = FormatNumber($this->MATERIAL_ID->ViewValue, 0, -2, -2, -2);
            $this->MATERIAL_ID->ViewCustomAttributes = "";

            // FORM_ID
            $this->FORM_ID->ViewValue = $this->FORM_ID->CurrentValue;
            $this->FORM_ID->ViewValue = FormatNumber($this->FORM_ID->ViewValue, 0, -2, -2, -2);
            $this->FORM_ID->ViewCustomAttributes = "";

            // ISGENERIC
            $this->ISGENERIC->ViewValue = $this->ISGENERIC->CurrentValue;
            $this->ISGENERIC->ViewCustomAttributes = "";

            // REGULATE_ID
            $this->REGULATE_ID->ViewValue = $this->REGULATE_ID->CurrentValue;
            $this->REGULATE_ID->ViewValue = FormatNumber($this->REGULATE_ID->ViewValue, 0, -2, -2, -2);
            $this->REGULATE_ID->ViewCustomAttributes = "";

            // PREGNANCY_INDEX
            $this->PREGNANCY_INDEX->ViewValue = $this->PREGNANCY_INDEX->CurrentValue;
            $this->PREGNANCY_INDEX->ViewCustomAttributes = "";

            // INDICATION
            $this->INDICATION->ViewValue = $this->INDICATION->CurrentValue;
            $this->INDICATION->ViewCustomAttributes = "";

            // TAKE_RULE
            $this->TAKE_RULE->ViewValue = $this->TAKE_RULE->CurrentValue;
            $this->TAKE_RULE->ViewCustomAttributes = "";

            // SIDE_EFFECT
            $this->SIDE_EFFECT->ViewValue = $this->SIDE_EFFECT->CurrentValue;
            $this->SIDE_EFFECT->ViewCustomAttributes = "";

            // INTERACTION
            $this->INTERACTION->ViewValue = $this->INTERACTION->CurrentValue;
            $this->INTERACTION->ViewCustomAttributes = "";

            // CONTRA_INDICATION
            $this->CONTRA_INDICATION->ViewValue = $this->CONTRA_INDICATION->CurrentValue;
            $this->CONTRA_INDICATION->ViewCustomAttributes = "";

            // WARNING
            $this->WARNING->ViewValue = $this->WARNING->CurrentValue;
            $this->WARNING->ViewCustomAttributes = "";

            // STOCK
            $this->STOCK->ViewValue = $this->STOCK->CurrentValue;
            $this->STOCK->ViewValue = FormatNumber($this->STOCK->ViewValue, 2, -2, -2, -2);
            $this->STOCK->ViewCustomAttributes = "";

            // ISACTIVE
            $this->ISACTIVE->ViewValue = $this->ISACTIVE->CurrentValue;
            $this->ISACTIVE->ViewCustomAttributes = "";

            // ISALKES
            $this->ISALKES->ViewValue = $this->ISALKES->CurrentValue;
            $this->ISALKES->ViewCustomAttributes = "";

            // SIZE_ORDER
            $this->SIZE_ORDER->ViewValue = $this->SIZE_ORDER->CurrentValue;
            $this->SIZE_ORDER->ViewValue = FormatNumber($this->SIZE_ORDER->ViewValue, 2, -2, -2, -2);
            $this->SIZE_ORDER->ViewCustomAttributes = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
            $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_PRICE->ViewCustomAttributes = "";

            // ISFORMULARIUM
            $this->ISFORMULARIUM->ViewValue = $this->ISFORMULARIUM->CurrentValue;
            $this->ISFORMULARIUM->ViewCustomAttributes = "";

            // ISESSENTIAL
            $this->ISESSENTIAL->ViewValue = $this->ISESSENTIAL->CurrentValue;
            $this->ISESSENTIAL->ViewCustomAttributes = "";

            // AVGDATE
            $this->AVGDATE->ViewValue = $this->AVGDATE->CurrentValue;
            $this->AVGDATE->ViewValue = FormatDateTime($this->AVGDATE->ViewValue, 0);
            $this->AVGDATE->ViewCustomAttributes = "";

            // STOCK_MINIMAL
            $this->STOCK_MINIMAL->ViewValue = $this->STOCK_MINIMAL->CurrentValue;
            $this->STOCK_MINIMAL->ViewValue = FormatNumber($this->STOCK_MINIMAL->ViewValue, 2, -2, -2, -2);
            $this->STOCK_MINIMAL->ViewCustomAttributes = "";

            // STOCK_MINIMAL_APT
            $this->STOCK_MINIMAL_APT->ViewValue = $this->STOCK_MINIMAL_APT->CurrentValue;
            $this->STOCK_MINIMAL_APT->ViewValue = FormatNumber($this->STOCK_MINIMAL_APT->ViewValue, 2, -2, -2, -2);
            $this->STOCK_MINIMAL_APT->ViewCustomAttributes = "";

            // HET
            $this->HET->ViewValue = $this->HET->CurrentValue;
            $this->HET->ViewValue = FormatNumber($this->HET->ViewValue, 2, -2, -2, -2);
            $this->HET->ViewCustomAttributes = "";

            // default_margin
            $this->default_margin->ViewValue = $this->default_margin->CurrentValue;
            $this->default_margin->ViewCustomAttributes = "";

            // CODE_5
            $this->CODE_5->LinkCustomAttributes = "";
            $this->CODE_5->HrefValue = "";
            $this->CODE_5->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // NAME
            $this->NAME->LinkCustomAttributes = "";
            $this->NAME->HrefValue = "";
            $this->NAME->TooltipValue = "";

            // OTHER_CODE
            $this->OTHER_CODE->LinkCustomAttributes = "";
            $this->OTHER_CODE->HrefValue = "";
            $this->OTHER_CODE->TooltipValue = "";

            // BARCODE
            $this->_BARCODE->LinkCustomAttributes = "";
            $this->_BARCODE->HrefValue = "";
            $this->_BARCODE->TooltipValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";
            $this->DESCRIPTION->TooltipValue = "";

            // REORDER_POINT
            $this->REORDER_POINT->LinkCustomAttributes = "";
            $this->REORDER_POINT->HrefValue = "";
            $this->REORDER_POINT->TooltipValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";
            $this->SIZE_GOODS->TooltipValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";
            $this->MEASURE_DOSIS->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";
            $this->MEASURE_ID2->TooltipValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";
            $this->SIZE_KEMASAN->TooltipValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";
            $this->MEASURE_ID3->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // NET_PRICE
            $this->NET_PRICE->LinkCustomAttributes = "";
            $this->NET_PRICE->HrefValue = "";
            $this->NET_PRICE->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // TH
            $this->TH->LinkCustomAttributes = "";
            $this->TH->HrefValue = "";
            $this->TH->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // MATERIAL_ID
            $this->MATERIAL_ID->LinkCustomAttributes = "";
            $this->MATERIAL_ID->HrefValue = "";
            $this->MATERIAL_ID->TooltipValue = "";

            // FORM_ID
            $this->FORM_ID->LinkCustomAttributes = "";
            $this->FORM_ID->HrefValue = "";
            $this->FORM_ID->TooltipValue = "";

            // ISGENERIC
            $this->ISGENERIC->LinkCustomAttributes = "";
            $this->ISGENERIC->HrefValue = "";
            $this->ISGENERIC->TooltipValue = "";

            // REGULATE_ID
            $this->REGULATE_ID->LinkCustomAttributes = "";
            $this->REGULATE_ID->HrefValue = "";
            $this->REGULATE_ID->TooltipValue = "";

            // PREGNANCY_INDEX
            $this->PREGNANCY_INDEX->LinkCustomAttributes = "";
            $this->PREGNANCY_INDEX->HrefValue = "";
            $this->PREGNANCY_INDEX->TooltipValue = "";

            // INDICATION
            $this->INDICATION->LinkCustomAttributes = "";
            $this->INDICATION->HrefValue = "";
            $this->INDICATION->TooltipValue = "";

            // TAKE_RULE
            $this->TAKE_RULE->LinkCustomAttributes = "";
            $this->TAKE_RULE->HrefValue = "";
            $this->TAKE_RULE->TooltipValue = "";

            // SIDE_EFFECT
            $this->SIDE_EFFECT->LinkCustomAttributes = "";
            $this->SIDE_EFFECT->HrefValue = "";
            $this->SIDE_EFFECT->TooltipValue = "";

            // INTERACTION
            $this->INTERACTION->LinkCustomAttributes = "";
            $this->INTERACTION->HrefValue = "";
            $this->INTERACTION->TooltipValue = "";

            // CONTRA_INDICATION
            $this->CONTRA_INDICATION->LinkCustomAttributes = "";
            $this->CONTRA_INDICATION->HrefValue = "";
            $this->CONTRA_INDICATION->TooltipValue = "";

            // WARNING
            $this->WARNING->LinkCustomAttributes = "";
            $this->WARNING->HrefValue = "";
            $this->WARNING->TooltipValue = "";

            // STOCK
            $this->STOCK->LinkCustomAttributes = "";
            $this->STOCK->HrefValue = "";
            $this->STOCK->TooltipValue = "";

            // ISACTIVE
            $this->ISACTIVE->LinkCustomAttributes = "";
            $this->ISACTIVE->HrefValue = "";
            $this->ISACTIVE->TooltipValue = "";

            // ISALKES
            $this->ISALKES->LinkCustomAttributes = "";
            $this->ISALKES->HrefValue = "";
            $this->ISALKES->TooltipValue = "";

            // SIZE_ORDER
            $this->SIZE_ORDER->LinkCustomAttributes = "";
            $this->SIZE_ORDER->HrefValue = "";
            $this->SIZE_ORDER->TooltipValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";
            $this->ORDER_PRICE->TooltipValue = "";

            // ISFORMULARIUM
            $this->ISFORMULARIUM->LinkCustomAttributes = "";
            $this->ISFORMULARIUM->HrefValue = "";
            $this->ISFORMULARIUM->TooltipValue = "";

            // ISESSENTIAL
            $this->ISESSENTIAL->LinkCustomAttributes = "";
            $this->ISESSENTIAL->HrefValue = "";
            $this->ISESSENTIAL->TooltipValue = "";

            // AVGDATE
            $this->AVGDATE->LinkCustomAttributes = "";
            $this->AVGDATE->HrefValue = "";
            $this->AVGDATE->TooltipValue = "";

            // STOCK_MINIMAL
            $this->STOCK_MINIMAL->LinkCustomAttributes = "";
            $this->STOCK_MINIMAL->HrefValue = "";
            $this->STOCK_MINIMAL->TooltipValue = "";

            // STOCK_MINIMAL_APT
            $this->STOCK_MINIMAL_APT->LinkCustomAttributes = "";
            $this->STOCK_MINIMAL_APT->HrefValue = "";
            $this->STOCK_MINIMAL_APT->TooltipValue = "";

            // HET
            $this->HET->LinkCustomAttributes = "";
            $this->HET->HrefValue = "";
            $this->HET->TooltipValue = "";

            // default_margin
            $this->default_margin->LinkCustomAttributes = "";
            $this->default_margin->HrefValue = "";
            $this->default_margin->TooltipValue = "";
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
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fGOODSlist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fGOODSlist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fGOODSlist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
            return '<button id="emf_GOODS" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_GOODS\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fGOODSlist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fGOODSlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
