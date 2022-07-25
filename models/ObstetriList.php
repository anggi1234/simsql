<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ObstetriList extends Obstetri
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'OBSTETRI';

    // Page object name
    public $PageObjName = "ObstetriList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fOBSTETRIlist";
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

        // Table object (OBSTETRI)
        if (!isset($GLOBALS["OBSTETRI"]) || get_class($GLOBALS["OBSTETRI"]) == PROJECT_NAMESPACE . "OBSTETRI") {
            $GLOBALS["OBSTETRI"] = &$this;
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
        $this->AddUrl = "ObstetriAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "ObstetriDelete";
        $this->MultiUpdateUrl = "ObstetriUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'OBSTETRI');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fOBSTETRIlistsrch";

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
                $doc = new $class(Container("OBSTETRI"));
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
            $key .= @$ar['ID'];
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
            $this->ID->Visible = false;
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
        $this->ORG_UNIT_CODE->Visible = false;
        $this->OBSTETRI_ID->setVisibility();
        $this->HPHT->setVisibility();
        $this->HTP->setVisibility();
        $this->PASIEN_DIAGNOSA_ID->setVisibility();
        $this->DIAGNOSA_ID->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->KOHORT_NB->setVisibility();
        $this->BIRTH_NB->setVisibility();
        $this->BIRTH_DURATION->setVisibility();
        $this->BIRTH_PLACE->setVisibility();
        $this->ANTE_NATAL->setVisibility();
        $this->EMPLOYEE_ID->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->BIRTH_WAY->setVisibility();
        $this->BIRTH_BY->setVisibility();
        $this->BIRTH_DATE->setVisibility();
        $this->GESTASI->setVisibility();
        $this->PARITY->setVisibility();
        $this->NB_BABY->setVisibility();
        $this->BABY_DIE->setVisibility();
        $this->ABORTUS_KE->setVisibility();
        $this->ABORTUS_ID->setVisibility();
        $this->ABORTION_DATE->setVisibility();
        $this->BIRTH_CAT->setVisibility();
        $this->BIRTH_CON->setVisibility();
        $this->BIRTH_RISK->setVisibility();
        $this->RISK_TYPE->setVisibility();
        $this->FOLLOW_UP->setVisibility();
        $this->DIRUJUK_OLEH->setVisibility();
        $this->INSPECTION_DATE->setVisibility();
        $this->PORSIO->setVisibility();
        $this->PEMBUKAAN->setVisibility();
        $this->KETUBAN->setVisibility();
        $this->PRESENTASI->setVisibility();
        $this->POSISI->setVisibility();
        $this->PENURUNAN->setVisibility();
        $this->HEART_ID->setVisibility();
        $this->JANIN_ID->setVisibility();
        $this->FREK_DJJ->setVisibility();
        $this->PLACENTA->setVisibility();
        $this->LOCHIA->setVisibility();
        $this->BAB_TYPE->setVisibility();
        $this->BAB_BAB_TYPE->setVisibility();
        $this->RAHIM_ID->setVisibility();
        $this->BIR_RAHIM_ID->setVisibility();
        $this->VISIT_ID->setVisibility();
        $this->BLOODING->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->MODIFIED_FROM->setVisibility();
        $this->RAHIM_SALIN->setVisibility();
        $this->RAHIM_NIFAS->setVisibility();
        $this->BAK_TYPE->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->THEID->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->ISRJ->setVisibility();
        $this->AGEYEAR->setVisibility();
        $this->AGEMONTH->setVisibility();
        $this->AGEDAY->setVisibility();
        $this->GENDER->setVisibility();
        $this->CLASS_ROOM_ID->setVisibility();
        $this->BED_ID->setVisibility();
        $this->KELUAR_ID->setVisibility();
        $this->DOCTOR->setVisibility();
        $this->NB_OBSTETRI->setVisibility();
        $this->OBSTETRI_DIE->setVisibility();
        $this->KAL_ID->setVisibility();
        $this->DIAGNOSA_ID2->setVisibility();
        $this->APGAR_ID->setVisibility();
        $this->BIRTH_LAST_ID->setVisibility();
        $this->ID->setVisibility();
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
        $filterList = Concat($filterList, $this->OBSTETRI_ID->AdvancedSearch->toJson(), ","); // Field OBSTETRI_ID
        $filterList = Concat($filterList, $this->HPHT->AdvancedSearch->toJson(), ","); // Field HPHT
        $filterList = Concat($filterList, $this->HTP->AdvancedSearch->toJson(), ","); // Field HTP
        $filterList = Concat($filterList, $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->toJson(), ","); // Field PASIEN_DIAGNOSA_ID
        $filterList = Concat($filterList, $this->DIAGNOSA_ID->AdvancedSearch->toJson(), ","); // Field DIAGNOSA_ID
        $filterList = Concat($filterList, $this->NO_REGISTRATION->AdvancedSearch->toJson(), ","); // Field NO_REGISTRATION
        $filterList = Concat($filterList, $this->KOHORT_NB->AdvancedSearch->toJson(), ","); // Field KOHORT_NB
        $filterList = Concat($filterList, $this->BIRTH_NB->AdvancedSearch->toJson(), ","); // Field BIRTH_NB
        $filterList = Concat($filterList, $this->BIRTH_DURATION->AdvancedSearch->toJson(), ","); // Field BIRTH_DURATION
        $filterList = Concat($filterList, $this->BIRTH_PLACE->AdvancedSearch->toJson(), ","); // Field BIRTH_PLACE
        $filterList = Concat($filterList, $this->ANTE_NATAL->AdvancedSearch->toJson(), ","); // Field ANTE_NATAL
        $filterList = Concat($filterList, $this->EMPLOYEE_ID->AdvancedSearch->toJson(), ","); // Field EMPLOYEE_ID
        $filterList = Concat($filterList, $this->CLINIC_ID->AdvancedSearch->toJson(), ","); // Field CLINIC_ID
        $filterList = Concat($filterList, $this->BIRTH_WAY->AdvancedSearch->toJson(), ","); // Field BIRTH_WAY
        $filterList = Concat($filterList, $this->BIRTH_BY->AdvancedSearch->toJson(), ","); // Field BIRTH_BY
        $filterList = Concat($filterList, $this->BIRTH_DATE->AdvancedSearch->toJson(), ","); // Field BIRTH_DATE
        $filterList = Concat($filterList, $this->GESTASI->AdvancedSearch->toJson(), ","); // Field GESTASI
        $filterList = Concat($filterList, $this->PARITY->AdvancedSearch->toJson(), ","); // Field PARITY
        $filterList = Concat($filterList, $this->NB_BABY->AdvancedSearch->toJson(), ","); // Field NB_BABY
        $filterList = Concat($filterList, $this->BABY_DIE->AdvancedSearch->toJson(), ","); // Field BABY_DIE
        $filterList = Concat($filterList, $this->ABORTUS_KE->AdvancedSearch->toJson(), ","); // Field ABORTUS_KE
        $filterList = Concat($filterList, $this->ABORTUS_ID->AdvancedSearch->toJson(), ","); // Field ABORTUS_ID
        $filterList = Concat($filterList, $this->ABORTION_DATE->AdvancedSearch->toJson(), ","); // Field ABORTION_DATE
        $filterList = Concat($filterList, $this->BIRTH_CAT->AdvancedSearch->toJson(), ","); // Field BIRTH_CAT
        $filterList = Concat($filterList, $this->BIRTH_CON->AdvancedSearch->toJson(), ","); // Field BIRTH_CON
        $filterList = Concat($filterList, $this->BIRTH_RISK->AdvancedSearch->toJson(), ","); // Field BIRTH_RISK
        $filterList = Concat($filterList, $this->RISK_TYPE->AdvancedSearch->toJson(), ","); // Field RISK_TYPE
        $filterList = Concat($filterList, $this->FOLLOW_UP->AdvancedSearch->toJson(), ","); // Field FOLLOW_UP
        $filterList = Concat($filterList, $this->DIRUJUK_OLEH->AdvancedSearch->toJson(), ","); // Field DIRUJUK_OLEH
        $filterList = Concat($filterList, $this->INSPECTION_DATE->AdvancedSearch->toJson(), ","); // Field INSPECTION_DATE
        $filterList = Concat($filterList, $this->PORSIO->AdvancedSearch->toJson(), ","); // Field PORSIO
        $filterList = Concat($filterList, $this->PEMBUKAAN->AdvancedSearch->toJson(), ","); // Field PEMBUKAAN
        $filterList = Concat($filterList, $this->KETUBAN->AdvancedSearch->toJson(), ","); // Field KETUBAN
        $filterList = Concat($filterList, $this->PRESENTASI->AdvancedSearch->toJson(), ","); // Field PRESENTASI
        $filterList = Concat($filterList, $this->POSISI->AdvancedSearch->toJson(), ","); // Field POSISI
        $filterList = Concat($filterList, $this->PENURUNAN->AdvancedSearch->toJson(), ","); // Field PENURUNAN
        $filterList = Concat($filterList, $this->HEART_ID->AdvancedSearch->toJson(), ","); // Field HEART_ID
        $filterList = Concat($filterList, $this->JANIN_ID->AdvancedSearch->toJson(), ","); // Field JANIN_ID
        $filterList = Concat($filterList, $this->FREK_DJJ->AdvancedSearch->toJson(), ","); // Field FREK_DJJ
        $filterList = Concat($filterList, $this->PLACENTA->AdvancedSearch->toJson(), ","); // Field PLACENTA
        $filterList = Concat($filterList, $this->LOCHIA->AdvancedSearch->toJson(), ","); // Field LOCHIA
        $filterList = Concat($filterList, $this->BAB_TYPE->AdvancedSearch->toJson(), ","); // Field BAB_TYPE
        $filterList = Concat($filterList, $this->BAB_BAB_TYPE->AdvancedSearch->toJson(), ","); // Field BAB_BAB_TYPE
        $filterList = Concat($filterList, $this->RAHIM_ID->AdvancedSearch->toJson(), ","); // Field RAHIM_ID
        $filterList = Concat($filterList, $this->BIR_RAHIM_ID->AdvancedSearch->toJson(), ","); // Field BIR_RAHIM_ID
        $filterList = Concat($filterList, $this->VISIT_ID->AdvancedSearch->toJson(), ","); // Field VISIT_ID
        $filterList = Concat($filterList, $this->BLOODING->AdvancedSearch->toJson(), ","); // Field BLOODING
        $filterList = Concat($filterList, $this->DESCRIPTION->AdvancedSearch->toJson(), ","); // Field DESCRIPTION
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->MODIFIED_FROM->AdvancedSearch->toJson(), ","); // Field MODIFIED_FROM
        $filterList = Concat($filterList, $this->RAHIM_SALIN->AdvancedSearch->toJson(), ","); // Field RAHIM_SALIN
        $filterList = Concat($filterList, $this->RAHIM_NIFAS->AdvancedSearch->toJson(), ","); // Field RAHIM_NIFAS
        $filterList = Concat($filterList, $this->BAK_TYPE->AdvancedSearch->toJson(), ","); // Field BAK_TYPE
        $filterList = Concat($filterList, $this->THENAME->AdvancedSearch->toJson(), ","); // Field THENAME
        $filterList = Concat($filterList, $this->THEADDRESS->AdvancedSearch->toJson(), ","); // Field THEADDRESS
        $filterList = Concat($filterList, $this->THEID->AdvancedSearch->toJson(), ","); // Field THEID
        $filterList = Concat($filterList, $this->STATUS_PASIEN_ID->AdvancedSearch->toJson(), ","); // Field STATUS_PASIEN_ID
        $filterList = Concat($filterList, $this->ISRJ->AdvancedSearch->toJson(), ","); // Field ISRJ
        $filterList = Concat($filterList, $this->AGEYEAR->AdvancedSearch->toJson(), ","); // Field AGEYEAR
        $filterList = Concat($filterList, $this->AGEMONTH->AdvancedSearch->toJson(), ","); // Field AGEMONTH
        $filterList = Concat($filterList, $this->AGEDAY->AdvancedSearch->toJson(), ","); // Field AGEDAY
        $filterList = Concat($filterList, $this->GENDER->AdvancedSearch->toJson(), ","); // Field GENDER
        $filterList = Concat($filterList, $this->CLASS_ROOM_ID->AdvancedSearch->toJson(), ","); // Field CLASS_ROOM_ID
        $filterList = Concat($filterList, $this->BED_ID->AdvancedSearch->toJson(), ","); // Field BED_ID
        $filterList = Concat($filterList, $this->KELUAR_ID->AdvancedSearch->toJson(), ","); // Field KELUAR_ID
        $filterList = Concat($filterList, $this->DOCTOR->AdvancedSearch->toJson(), ","); // Field DOCTOR
        $filterList = Concat($filterList, $this->NB_OBSTETRI->AdvancedSearch->toJson(), ","); // Field NB_OBSTETRI
        $filterList = Concat($filterList, $this->OBSTETRI_DIE->AdvancedSearch->toJson(), ","); // Field OBSTETRI_DIE
        $filterList = Concat($filterList, $this->KAL_ID->AdvancedSearch->toJson(), ","); // Field KAL_ID
        $filterList = Concat($filterList, $this->DIAGNOSA_ID2->AdvancedSearch->toJson(), ","); // Field DIAGNOSA_ID2
        $filterList = Concat($filterList, $this->APGAR_ID->AdvancedSearch->toJson(), ","); // Field APGAR_ID
        $filterList = Concat($filterList, $this->BIRTH_LAST_ID->AdvancedSearch->toJson(), ","); // Field BIRTH_LAST_ID
        $filterList = Concat($filterList, $this->ID->AdvancedSearch->toJson(), ","); // Field ID
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fOBSTETRIlistsrch", $filters);
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

        // Field OBSTETRI_ID
        $this->OBSTETRI_ID->AdvancedSearch->SearchValue = @$filter["x_OBSTETRI_ID"];
        $this->OBSTETRI_ID->AdvancedSearch->SearchOperator = @$filter["z_OBSTETRI_ID"];
        $this->OBSTETRI_ID->AdvancedSearch->SearchCondition = @$filter["v_OBSTETRI_ID"];
        $this->OBSTETRI_ID->AdvancedSearch->SearchValue2 = @$filter["y_OBSTETRI_ID"];
        $this->OBSTETRI_ID->AdvancedSearch->SearchOperator2 = @$filter["w_OBSTETRI_ID"];
        $this->OBSTETRI_ID->AdvancedSearch->save();

        // Field HPHT
        $this->HPHT->AdvancedSearch->SearchValue = @$filter["x_HPHT"];
        $this->HPHT->AdvancedSearch->SearchOperator = @$filter["z_HPHT"];
        $this->HPHT->AdvancedSearch->SearchCondition = @$filter["v_HPHT"];
        $this->HPHT->AdvancedSearch->SearchValue2 = @$filter["y_HPHT"];
        $this->HPHT->AdvancedSearch->SearchOperator2 = @$filter["w_HPHT"];
        $this->HPHT->AdvancedSearch->save();

        // Field HTP
        $this->HTP->AdvancedSearch->SearchValue = @$filter["x_HTP"];
        $this->HTP->AdvancedSearch->SearchOperator = @$filter["z_HTP"];
        $this->HTP->AdvancedSearch->SearchCondition = @$filter["v_HTP"];
        $this->HTP->AdvancedSearch->SearchValue2 = @$filter["y_HTP"];
        $this->HTP->AdvancedSearch->SearchOperator2 = @$filter["w_HTP"];
        $this->HTP->AdvancedSearch->save();

        // Field PASIEN_DIAGNOSA_ID
        $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->SearchValue = @$filter["x_PASIEN_DIAGNOSA_ID"];
        $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->SearchOperator = @$filter["z_PASIEN_DIAGNOSA_ID"];
        $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->SearchCondition = @$filter["v_PASIEN_DIAGNOSA_ID"];
        $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->SearchValue2 = @$filter["y_PASIEN_DIAGNOSA_ID"];
        $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->SearchOperator2 = @$filter["w_PASIEN_DIAGNOSA_ID"];
        $this->PASIEN_DIAGNOSA_ID->AdvancedSearch->save();

        // Field DIAGNOSA_ID
        $this->DIAGNOSA_ID->AdvancedSearch->SearchValue = @$filter["x_DIAGNOSA_ID"];
        $this->DIAGNOSA_ID->AdvancedSearch->SearchOperator = @$filter["z_DIAGNOSA_ID"];
        $this->DIAGNOSA_ID->AdvancedSearch->SearchCondition = @$filter["v_DIAGNOSA_ID"];
        $this->DIAGNOSA_ID->AdvancedSearch->SearchValue2 = @$filter["y_DIAGNOSA_ID"];
        $this->DIAGNOSA_ID->AdvancedSearch->SearchOperator2 = @$filter["w_DIAGNOSA_ID"];
        $this->DIAGNOSA_ID->AdvancedSearch->save();

        // Field NO_REGISTRATION
        $this->NO_REGISTRATION->AdvancedSearch->SearchValue = @$filter["x_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchOperator = @$filter["z_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchCondition = @$filter["v_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchValue2 = @$filter["y_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->SearchOperator2 = @$filter["w_NO_REGISTRATION"];
        $this->NO_REGISTRATION->AdvancedSearch->save();

        // Field KOHORT_NB
        $this->KOHORT_NB->AdvancedSearch->SearchValue = @$filter["x_KOHORT_NB"];
        $this->KOHORT_NB->AdvancedSearch->SearchOperator = @$filter["z_KOHORT_NB"];
        $this->KOHORT_NB->AdvancedSearch->SearchCondition = @$filter["v_KOHORT_NB"];
        $this->KOHORT_NB->AdvancedSearch->SearchValue2 = @$filter["y_KOHORT_NB"];
        $this->KOHORT_NB->AdvancedSearch->SearchOperator2 = @$filter["w_KOHORT_NB"];
        $this->KOHORT_NB->AdvancedSearch->save();

        // Field BIRTH_NB
        $this->BIRTH_NB->AdvancedSearch->SearchValue = @$filter["x_BIRTH_NB"];
        $this->BIRTH_NB->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_NB"];
        $this->BIRTH_NB->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_NB"];
        $this->BIRTH_NB->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_NB"];
        $this->BIRTH_NB->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_NB"];
        $this->BIRTH_NB->AdvancedSearch->save();

        // Field BIRTH_DURATION
        $this->BIRTH_DURATION->AdvancedSearch->SearchValue = @$filter["x_BIRTH_DURATION"];
        $this->BIRTH_DURATION->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_DURATION"];
        $this->BIRTH_DURATION->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_DURATION"];
        $this->BIRTH_DURATION->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_DURATION"];
        $this->BIRTH_DURATION->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_DURATION"];
        $this->BIRTH_DURATION->AdvancedSearch->save();

        // Field BIRTH_PLACE
        $this->BIRTH_PLACE->AdvancedSearch->SearchValue = @$filter["x_BIRTH_PLACE"];
        $this->BIRTH_PLACE->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_PLACE"];
        $this->BIRTH_PLACE->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_PLACE"];
        $this->BIRTH_PLACE->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_PLACE"];
        $this->BIRTH_PLACE->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_PLACE"];
        $this->BIRTH_PLACE->AdvancedSearch->save();

        // Field ANTE_NATAL
        $this->ANTE_NATAL->AdvancedSearch->SearchValue = @$filter["x_ANTE_NATAL"];
        $this->ANTE_NATAL->AdvancedSearch->SearchOperator = @$filter["z_ANTE_NATAL"];
        $this->ANTE_NATAL->AdvancedSearch->SearchCondition = @$filter["v_ANTE_NATAL"];
        $this->ANTE_NATAL->AdvancedSearch->SearchValue2 = @$filter["y_ANTE_NATAL"];
        $this->ANTE_NATAL->AdvancedSearch->SearchOperator2 = @$filter["w_ANTE_NATAL"];
        $this->ANTE_NATAL->AdvancedSearch->save();

        // Field EMPLOYEE_ID
        $this->EMPLOYEE_ID->AdvancedSearch->SearchValue = @$filter["x_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchOperator = @$filter["z_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchCondition = @$filter["v_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchValue2 = @$filter["y_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_EMPLOYEE_ID"];
        $this->EMPLOYEE_ID->AdvancedSearch->save();

        // Field CLINIC_ID
        $this->CLINIC_ID->AdvancedSearch->SearchValue = @$filter["x_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchOperator = @$filter["z_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchCondition = @$filter["v_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchValue2 = @$filter["y_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CLINIC_ID"];
        $this->CLINIC_ID->AdvancedSearch->save();

        // Field BIRTH_WAY
        $this->BIRTH_WAY->AdvancedSearch->SearchValue = @$filter["x_BIRTH_WAY"];
        $this->BIRTH_WAY->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_WAY"];
        $this->BIRTH_WAY->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_WAY"];
        $this->BIRTH_WAY->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_WAY"];
        $this->BIRTH_WAY->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_WAY"];
        $this->BIRTH_WAY->AdvancedSearch->save();

        // Field BIRTH_BY
        $this->BIRTH_BY->AdvancedSearch->SearchValue = @$filter["x_BIRTH_BY"];
        $this->BIRTH_BY->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_BY"];
        $this->BIRTH_BY->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_BY"];
        $this->BIRTH_BY->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_BY"];
        $this->BIRTH_BY->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_BY"];
        $this->BIRTH_BY->AdvancedSearch->save();

        // Field BIRTH_DATE
        $this->BIRTH_DATE->AdvancedSearch->SearchValue = @$filter["x_BIRTH_DATE"];
        $this->BIRTH_DATE->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_DATE"];
        $this->BIRTH_DATE->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_DATE"];
        $this->BIRTH_DATE->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_DATE"];
        $this->BIRTH_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_DATE"];
        $this->BIRTH_DATE->AdvancedSearch->save();

        // Field GESTASI
        $this->GESTASI->AdvancedSearch->SearchValue = @$filter["x_GESTASI"];
        $this->GESTASI->AdvancedSearch->SearchOperator = @$filter["z_GESTASI"];
        $this->GESTASI->AdvancedSearch->SearchCondition = @$filter["v_GESTASI"];
        $this->GESTASI->AdvancedSearch->SearchValue2 = @$filter["y_GESTASI"];
        $this->GESTASI->AdvancedSearch->SearchOperator2 = @$filter["w_GESTASI"];
        $this->GESTASI->AdvancedSearch->save();

        // Field PARITY
        $this->PARITY->AdvancedSearch->SearchValue = @$filter["x_PARITY"];
        $this->PARITY->AdvancedSearch->SearchOperator = @$filter["z_PARITY"];
        $this->PARITY->AdvancedSearch->SearchCondition = @$filter["v_PARITY"];
        $this->PARITY->AdvancedSearch->SearchValue2 = @$filter["y_PARITY"];
        $this->PARITY->AdvancedSearch->SearchOperator2 = @$filter["w_PARITY"];
        $this->PARITY->AdvancedSearch->save();

        // Field NB_BABY
        $this->NB_BABY->AdvancedSearch->SearchValue = @$filter["x_NB_BABY"];
        $this->NB_BABY->AdvancedSearch->SearchOperator = @$filter["z_NB_BABY"];
        $this->NB_BABY->AdvancedSearch->SearchCondition = @$filter["v_NB_BABY"];
        $this->NB_BABY->AdvancedSearch->SearchValue2 = @$filter["y_NB_BABY"];
        $this->NB_BABY->AdvancedSearch->SearchOperator2 = @$filter["w_NB_BABY"];
        $this->NB_BABY->AdvancedSearch->save();

        // Field BABY_DIE
        $this->BABY_DIE->AdvancedSearch->SearchValue = @$filter["x_BABY_DIE"];
        $this->BABY_DIE->AdvancedSearch->SearchOperator = @$filter["z_BABY_DIE"];
        $this->BABY_DIE->AdvancedSearch->SearchCondition = @$filter["v_BABY_DIE"];
        $this->BABY_DIE->AdvancedSearch->SearchValue2 = @$filter["y_BABY_DIE"];
        $this->BABY_DIE->AdvancedSearch->SearchOperator2 = @$filter["w_BABY_DIE"];
        $this->BABY_DIE->AdvancedSearch->save();

        // Field ABORTUS_KE
        $this->ABORTUS_KE->AdvancedSearch->SearchValue = @$filter["x_ABORTUS_KE"];
        $this->ABORTUS_KE->AdvancedSearch->SearchOperator = @$filter["z_ABORTUS_KE"];
        $this->ABORTUS_KE->AdvancedSearch->SearchCondition = @$filter["v_ABORTUS_KE"];
        $this->ABORTUS_KE->AdvancedSearch->SearchValue2 = @$filter["y_ABORTUS_KE"];
        $this->ABORTUS_KE->AdvancedSearch->SearchOperator2 = @$filter["w_ABORTUS_KE"];
        $this->ABORTUS_KE->AdvancedSearch->save();

        // Field ABORTUS_ID
        $this->ABORTUS_ID->AdvancedSearch->SearchValue = @$filter["x_ABORTUS_ID"];
        $this->ABORTUS_ID->AdvancedSearch->SearchOperator = @$filter["z_ABORTUS_ID"];
        $this->ABORTUS_ID->AdvancedSearch->SearchCondition = @$filter["v_ABORTUS_ID"];
        $this->ABORTUS_ID->AdvancedSearch->SearchValue2 = @$filter["y_ABORTUS_ID"];
        $this->ABORTUS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ABORTUS_ID"];
        $this->ABORTUS_ID->AdvancedSearch->save();

        // Field ABORTION_DATE
        $this->ABORTION_DATE->AdvancedSearch->SearchValue = @$filter["x_ABORTION_DATE"];
        $this->ABORTION_DATE->AdvancedSearch->SearchOperator = @$filter["z_ABORTION_DATE"];
        $this->ABORTION_DATE->AdvancedSearch->SearchCondition = @$filter["v_ABORTION_DATE"];
        $this->ABORTION_DATE->AdvancedSearch->SearchValue2 = @$filter["y_ABORTION_DATE"];
        $this->ABORTION_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_ABORTION_DATE"];
        $this->ABORTION_DATE->AdvancedSearch->save();

        // Field BIRTH_CAT
        $this->BIRTH_CAT->AdvancedSearch->SearchValue = @$filter["x_BIRTH_CAT"];
        $this->BIRTH_CAT->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_CAT"];
        $this->BIRTH_CAT->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_CAT"];
        $this->BIRTH_CAT->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_CAT"];
        $this->BIRTH_CAT->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_CAT"];
        $this->BIRTH_CAT->AdvancedSearch->save();

        // Field BIRTH_CON
        $this->BIRTH_CON->AdvancedSearch->SearchValue = @$filter["x_BIRTH_CON"];
        $this->BIRTH_CON->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_CON"];
        $this->BIRTH_CON->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_CON"];
        $this->BIRTH_CON->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_CON"];
        $this->BIRTH_CON->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_CON"];
        $this->BIRTH_CON->AdvancedSearch->save();

        // Field BIRTH_RISK
        $this->BIRTH_RISK->AdvancedSearch->SearchValue = @$filter["x_BIRTH_RISK"];
        $this->BIRTH_RISK->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_RISK"];
        $this->BIRTH_RISK->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_RISK"];
        $this->BIRTH_RISK->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_RISK"];
        $this->BIRTH_RISK->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_RISK"];
        $this->BIRTH_RISK->AdvancedSearch->save();

        // Field RISK_TYPE
        $this->RISK_TYPE->AdvancedSearch->SearchValue = @$filter["x_RISK_TYPE"];
        $this->RISK_TYPE->AdvancedSearch->SearchOperator = @$filter["z_RISK_TYPE"];
        $this->RISK_TYPE->AdvancedSearch->SearchCondition = @$filter["v_RISK_TYPE"];
        $this->RISK_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_RISK_TYPE"];
        $this->RISK_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_RISK_TYPE"];
        $this->RISK_TYPE->AdvancedSearch->save();

        // Field FOLLOW_UP
        $this->FOLLOW_UP->AdvancedSearch->SearchValue = @$filter["x_FOLLOW_UP"];
        $this->FOLLOW_UP->AdvancedSearch->SearchOperator = @$filter["z_FOLLOW_UP"];
        $this->FOLLOW_UP->AdvancedSearch->SearchCondition = @$filter["v_FOLLOW_UP"];
        $this->FOLLOW_UP->AdvancedSearch->SearchValue2 = @$filter["y_FOLLOW_UP"];
        $this->FOLLOW_UP->AdvancedSearch->SearchOperator2 = @$filter["w_FOLLOW_UP"];
        $this->FOLLOW_UP->AdvancedSearch->save();

        // Field DIRUJUK_OLEH
        $this->DIRUJUK_OLEH->AdvancedSearch->SearchValue = @$filter["x_DIRUJUK_OLEH"];
        $this->DIRUJUK_OLEH->AdvancedSearch->SearchOperator = @$filter["z_DIRUJUK_OLEH"];
        $this->DIRUJUK_OLEH->AdvancedSearch->SearchCondition = @$filter["v_DIRUJUK_OLEH"];
        $this->DIRUJUK_OLEH->AdvancedSearch->SearchValue2 = @$filter["y_DIRUJUK_OLEH"];
        $this->DIRUJUK_OLEH->AdvancedSearch->SearchOperator2 = @$filter["w_DIRUJUK_OLEH"];
        $this->DIRUJUK_OLEH->AdvancedSearch->save();

        // Field INSPECTION_DATE
        $this->INSPECTION_DATE->AdvancedSearch->SearchValue = @$filter["x_INSPECTION_DATE"];
        $this->INSPECTION_DATE->AdvancedSearch->SearchOperator = @$filter["z_INSPECTION_DATE"];
        $this->INSPECTION_DATE->AdvancedSearch->SearchCondition = @$filter["v_INSPECTION_DATE"];
        $this->INSPECTION_DATE->AdvancedSearch->SearchValue2 = @$filter["y_INSPECTION_DATE"];
        $this->INSPECTION_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_INSPECTION_DATE"];
        $this->INSPECTION_DATE->AdvancedSearch->save();

        // Field PORSIO
        $this->PORSIO->AdvancedSearch->SearchValue = @$filter["x_PORSIO"];
        $this->PORSIO->AdvancedSearch->SearchOperator = @$filter["z_PORSIO"];
        $this->PORSIO->AdvancedSearch->SearchCondition = @$filter["v_PORSIO"];
        $this->PORSIO->AdvancedSearch->SearchValue2 = @$filter["y_PORSIO"];
        $this->PORSIO->AdvancedSearch->SearchOperator2 = @$filter["w_PORSIO"];
        $this->PORSIO->AdvancedSearch->save();

        // Field PEMBUKAAN
        $this->PEMBUKAAN->AdvancedSearch->SearchValue = @$filter["x_PEMBUKAAN"];
        $this->PEMBUKAAN->AdvancedSearch->SearchOperator = @$filter["z_PEMBUKAAN"];
        $this->PEMBUKAAN->AdvancedSearch->SearchCondition = @$filter["v_PEMBUKAAN"];
        $this->PEMBUKAAN->AdvancedSearch->SearchValue2 = @$filter["y_PEMBUKAAN"];
        $this->PEMBUKAAN->AdvancedSearch->SearchOperator2 = @$filter["w_PEMBUKAAN"];
        $this->PEMBUKAAN->AdvancedSearch->save();

        // Field KETUBAN
        $this->KETUBAN->AdvancedSearch->SearchValue = @$filter["x_KETUBAN"];
        $this->KETUBAN->AdvancedSearch->SearchOperator = @$filter["z_KETUBAN"];
        $this->KETUBAN->AdvancedSearch->SearchCondition = @$filter["v_KETUBAN"];
        $this->KETUBAN->AdvancedSearch->SearchValue2 = @$filter["y_KETUBAN"];
        $this->KETUBAN->AdvancedSearch->SearchOperator2 = @$filter["w_KETUBAN"];
        $this->KETUBAN->AdvancedSearch->save();

        // Field PRESENTASI
        $this->PRESENTASI->AdvancedSearch->SearchValue = @$filter["x_PRESENTASI"];
        $this->PRESENTASI->AdvancedSearch->SearchOperator = @$filter["z_PRESENTASI"];
        $this->PRESENTASI->AdvancedSearch->SearchCondition = @$filter["v_PRESENTASI"];
        $this->PRESENTASI->AdvancedSearch->SearchValue2 = @$filter["y_PRESENTASI"];
        $this->PRESENTASI->AdvancedSearch->SearchOperator2 = @$filter["w_PRESENTASI"];
        $this->PRESENTASI->AdvancedSearch->save();

        // Field POSISI
        $this->POSISI->AdvancedSearch->SearchValue = @$filter["x_POSISI"];
        $this->POSISI->AdvancedSearch->SearchOperator = @$filter["z_POSISI"];
        $this->POSISI->AdvancedSearch->SearchCondition = @$filter["v_POSISI"];
        $this->POSISI->AdvancedSearch->SearchValue2 = @$filter["y_POSISI"];
        $this->POSISI->AdvancedSearch->SearchOperator2 = @$filter["w_POSISI"];
        $this->POSISI->AdvancedSearch->save();

        // Field PENURUNAN
        $this->PENURUNAN->AdvancedSearch->SearchValue = @$filter["x_PENURUNAN"];
        $this->PENURUNAN->AdvancedSearch->SearchOperator = @$filter["z_PENURUNAN"];
        $this->PENURUNAN->AdvancedSearch->SearchCondition = @$filter["v_PENURUNAN"];
        $this->PENURUNAN->AdvancedSearch->SearchValue2 = @$filter["y_PENURUNAN"];
        $this->PENURUNAN->AdvancedSearch->SearchOperator2 = @$filter["w_PENURUNAN"];
        $this->PENURUNAN->AdvancedSearch->save();

        // Field HEART_ID
        $this->HEART_ID->AdvancedSearch->SearchValue = @$filter["x_HEART_ID"];
        $this->HEART_ID->AdvancedSearch->SearchOperator = @$filter["z_HEART_ID"];
        $this->HEART_ID->AdvancedSearch->SearchCondition = @$filter["v_HEART_ID"];
        $this->HEART_ID->AdvancedSearch->SearchValue2 = @$filter["y_HEART_ID"];
        $this->HEART_ID->AdvancedSearch->SearchOperator2 = @$filter["w_HEART_ID"];
        $this->HEART_ID->AdvancedSearch->save();

        // Field JANIN_ID
        $this->JANIN_ID->AdvancedSearch->SearchValue = @$filter["x_JANIN_ID"];
        $this->JANIN_ID->AdvancedSearch->SearchOperator = @$filter["z_JANIN_ID"];
        $this->JANIN_ID->AdvancedSearch->SearchCondition = @$filter["v_JANIN_ID"];
        $this->JANIN_ID->AdvancedSearch->SearchValue2 = @$filter["y_JANIN_ID"];
        $this->JANIN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_JANIN_ID"];
        $this->JANIN_ID->AdvancedSearch->save();

        // Field FREK_DJJ
        $this->FREK_DJJ->AdvancedSearch->SearchValue = @$filter["x_FREK_DJJ"];
        $this->FREK_DJJ->AdvancedSearch->SearchOperator = @$filter["z_FREK_DJJ"];
        $this->FREK_DJJ->AdvancedSearch->SearchCondition = @$filter["v_FREK_DJJ"];
        $this->FREK_DJJ->AdvancedSearch->SearchValue2 = @$filter["y_FREK_DJJ"];
        $this->FREK_DJJ->AdvancedSearch->SearchOperator2 = @$filter["w_FREK_DJJ"];
        $this->FREK_DJJ->AdvancedSearch->save();

        // Field PLACENTA
        $this->PLACENTA->AdvancedSearch->SearchValue = @$filter["x_PLACENTA"];
        $this->PLACENTA->AdvancedSearch->SearchOperator = @$filter["z_PLACENTA"];
        $this->PLACENTA->AdvancedSearch->SearchCondition = @$filter["v_PLACENTA"];
        $this->PLACENTA->AdvancedSearch->SearchValue2 = @$filter["y_PLACENTA"];
        $this->PLACENTA->AdvancedSearch->SearchOperator2 = @$filter["w_PLACENTA"];
        $this->PLACENTA->AdvancedSearch->save();

        // Field LOCHIA
        $this->LOCHIA->AdvancedSearch->SearchValue = @$filter["x_LOCHIA"];
        $this->LOCHIA->AdvancedSearch->SearchOperator = @$filter["z_LOCHIA"];
        $this->LOCHIA->AdvancedSearch->SearchCondition = @$filter["v_LOCHIA"];
        $this->LOCHIA->AdvancedSearch->SearchValue2 = @$filter["y_LOCHIA"];
        $this->LOCHIA->AdvancedSearch->SearchOperator2 = @$filter["w_LOCHIA"];
        $this->LOCHIA->AdvancedSearch->save();

        // Field BAB_TYPE
        $this->BAB_TYPE->AdvancedSearch->SearchValue = @$filter["x_BAB_TYPE"];
        $this->BAB_TYPE->AdvancedSearch->SearchOperator = @$filter["z_BAB_TYPE"];
        $this->BAB_TYPE->AdvancedSearch->SearchCondition = @$filter["v_BAB_TYPE"];
        $this->BAB_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_BAB_TYPE"];
        $this->BAB_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_BAB_TYPE"];
        $this->BAB_TYPE->AdvancedSearch->save();

        // Field BAB_BAB_TYPE
        $this->BAB_BAB_TYPE->AdvancedSearch->SearchValue = @$filter["x_BAB_BAB_TYPE"];
        $this->BAB_BAB_TYPE->AdvancedSearch->SearchOperator = @$filter["z_BAB_BAB_TYPE"];
        $this->BAB_BAB_TYPE->AdvancedSearch->SearchCondition = @$filter["v_BAB_BAB_TYPE"];
        $this->BAB_BAB_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_BAB_BAB_TYPE"];
        $this->BAB_BAB_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_BAB_BAB_TYPE"];
        $this->BAB_BAB_TYPE->AdvancedSearch->save();

        // Field RAHIM_ID
        $this->RAHIM_ID->AdvancedSearch->SearchValue = @$filter["x_RAHIM_ID"];
        $this->RAHIM_ID->AdvancedSearch->SearchOperator = @$filter["z_RAHIM_ID"];
        $this->RAHIM_ID->AdvancedSearch->SearchCondition = @$filter["v_RAHIM_ID"];
        $this->RAHIM_ID->AdvancedSearch->SearchValue2 = @$filter["y_RAHIM_ID"];
        $this->RAHIM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_RAHIM_ID"];
        $this->RAHIM_ID->AdvancedSearch->save();

        // Field BIR_RAHIM_ID
        $this->BIR_RAHIM_ID->AdvancedSearch->SearchValue = @$filter["x_BIR_RAHIM_ID"];
        $this->BIR_RAHIM_ID->AdvancedSearch->SearchOperator = @$filter["z_BIR_RAHIM_ID"];
        $this->BIR_RAHIM_ID->AdvancedSearch->SearchCondition = @$filter["v_BIR_RAHIM_ID"];
        $this->BIR_RAHIM_ID->AdvancedSearch->SearchValue2 = @$filter["y_BIR_RAHIM_ID"];
        $this->BIR_RAHIM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BIR_RAHIM_ID"];
        $this->BIR_RAHIM_ID->AdvancedSearch->save();

        // Field VISIT_ID
        $this->VISIT_ID->AdvancedSearch->SearchValue = @$filter["x_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchOperator = @$filter["z_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchCondition = @$filter["v_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchValue2 = @$filter["y_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->SearchOperator2 = @$filter["w_VISIT_ID"];
        $this->VISIT_ID->AdvancedSearch->save();

        // Field BLOODING
        $this->BLOODING->AdvancedSearch->SearchValue = @$filter["x_BLOODING"];
        $this->BLOODING->AdvancedSearch->SearchOperator = @$filter["z_BLOODING"];
        $this->BLOODING->AdvancedSearch->SearchCondition = @$filter["v_BLOODING"];
        $this->BLOODING->AdvancedSearch->SearchValue2 = @$filter["y_BLOODING"];
        $this->BLOODING->AdvancedSearch->SearchOperator2 = @$filter["w_BLOODING"];
        $this->BLOODING->AdvancedSearch->save();

        // Field DESCRIPTION
        $this->DESCRIPTION->AdvancedSearch->SearchValue = @$filter["x_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator = @$filter["z_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchCondition = @$filter["v_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchValue2 = @$filter["y_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->SearchOperator2 = @$filter["w_DESCRIPTION"];
        $this->DESCRIPTION->AdvancedSearch->save();

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

        // Field MODIFIED_FROM
        $this->MODIFIED_FROM->AdvancedSearch->SearchValue = @$filter["x_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchOperator = @$filter["z_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchCondition = @$filter["v_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchValue2 = @$filter["y_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_MODIFIED_FROM"];
        $this->MODIFIED_FROM->AdvancedSearch->save();

        // Field RAHIM_SALIN
        $this->RAHIM_SALIN->AdvancedSearch->SearchValue = @$filter["x_RAHIM_SALIN"];
        $this->RAHIM_SALIN->AdvancedSearch->SearchOperator = @$filter["z_RAHIM_SALIN"];
        $this->RAHIM_SALIN->AdvancedSearch->SearchCondition = @$filter["v_RAHIM_SALIN"];
        $this->RAHIM_SALIN->AdvancedSearch->SearchValue2 = @$filter["y_RAHIM_SALIN"];
        $this->RAHIM_SALIN->AdvancedSearch->SearchOperator2 = @$filter["w_RAHIM_SALIN"];
        $this->RAHIM_SALIN->AdvancedSearch->save();

        // Field RAHIM_NIFAS
        $this->RAHIM_NIFAS->AdvancedSearch->SearchValue = @$filter["x_RAHIM_NIFAS"];
        $this->RAHIM_NIFAS->AdvancedSearch->SearchOperator = @$filter["z_RAHIM_NIFAS"];
        $this->RAHIM_NIFAS->AdvancedSearch->SearchCondition = @$filter["v_RAHIM_NIFAS"];
        $this->RAHIM_NIFAS->AdvancedSearch->SearchValue2 = @$filter["y_RAHIM_NIFAS"];
        $this->RAHIM_NIFAS->AdvancedSearch->SearchOperator2 = @$filter["w_RAHIM_NIFAS"];
        $this->RAHIM_NIFAS->AdvancedSearch->save();

        // Field BAK_TYPE
        $this->BAK_TYPE->AdvancedSearch->SearchValue = @$filter["x_BAK_TYPE"];
        $this->BAK_TYPE->AdvancedSearch->SearchOperator = @$filter["z_BAK_TYPE"];
        $this->BAK_TYPE->AdvancedSearch->SearchCondition = @$filter["v_BAK_TYPE"];
        $this->BAK_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_BAK_TYPE"];
        $this->BAK_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_BAK_TYPE"];
        $this->BAK_TYPE->AdvancedSearch->save();

        // Field THENAME
        $this->THENAME->AdvancedSearch->SearchValue = @$filter["x_THENAME"];
        $this->THENAME->AdvancedSearch->SearchOperator = @$filter["z_THENAME"];
        $this->THENAME->AdvancedSearch->SearchCondition = @$filter["v_THENAME"];
        $this->THENAME->AdvancedSearch->SearchValue2 = @$filter["y_THENAME"];
        $this->THENAME->AdvancedSearch->SearchOperator2 = @$filter["w_THENAME"];
        $this->THENAME->AdvancedSearch->save();

        // Field THEADDRESS
        $this->THEADDRESS->AdvancedSearch->SearchValue = @$filter["x_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchOperator = @$filter["z_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchCondition = @$filter["v_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchValue2 = @$filter["y_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->SearchOperator2 = @$filter["w_THEADDRESS"];
        $this->THEADDRESS->AdvancedSearch->save();

        // Field THEID
        $this->THEID->AdvancedSearch->SearchValue = @$filter["x_THEID"];
        $this->THEID->AdvancedSearch->SearchOperator = @$filter["z_THEID"];
        $this->THEID->AdvancedSearch->SearchCondition = @$filter["v_THEID"];
        $this->THEID->AdvancedSearch->SearchValue2 = @$filter["y_THEID"];
        $this->THEID->AdvancedSearch->SearchOperator2 = @$filter["w_THEID"];
        $this->THEID->AdvancedSearch->save();

        // Field STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue = @$filter["x_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator = @$filter["z_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchCondition = @$filter["v_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->save();

        // Field ISRJ
        $this->ISRJ->AdvancedSearch->SearchValue = @$filter["x_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchOperator = @$filter["z_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchCondition = @$filter["v_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchValue2 = @$filter["y_ISRJ"];
        $this->ISRJ->AdvancedSearch->SearchOperator2 = @$filter["w_ISRJ"];
        $this->ISRJ->AdvancedSearch->save();

        // Field AGEYEAR
        $this->AGEYEAR->AdvancedSearch->SearchValue = @$filter["x_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchOperator = @$filter["z_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchCondition = @$filter["v_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchValue2 = @$filter["y_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->SearchOperator2 = @$filter["w_AGEYEAR"];
        $this->AGEYEAR->AdvancedSearch->save();

        // Field AGEMONTH
        $this->AGEMONTH->AdvancedSearch->SearchValue = @$filter["x_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchOperator = @$filter["z_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchCondition = @$filter["v_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchValue2 = @$filter["y_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->SearchOperator2 = @$filter["w_AGEMONTH"];
        $this->AGEMONTH->AdvancedSearch->save();

        // Field AGEDAY
        $this->AGEDAY->AdvancedSearch->SearchValue = @$filter["x_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchOperator = @$filter["z_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchCondition = @$filter["v_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchValue2 = @$filter["y_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->SearchOperator2 = @$filter["w_AGEDAY"];
        $this->AGEDAY->AdvancedSearch->save();

        // Field GENDER
        $this->GENDER->AdvancedSearch->SearchValue = @$filter["x_GENDER"];
        $this->GENDER->AdvancedSearch->SearchOperator = @$filter["z_GENDER"];
        $this->GENDER->AdvancedSearch->SearchCondition = @$filter["v_GENDER"];
        $this->GENDER->AdvancedSearch->SearchValue2 = @$filter["y_GENDER"];
        $this->GENDER->AdvancedSearch->SearchOperator2 = @$filter["w_GENDER"];
        $this->GENDER->AdvancedSearch->save();

        // Field CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue = @$filter["x_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchOperator = @$filter["z_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchCondition = @$filter["v_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchValue2 = @$filter["y_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_CLASS_ROOM_ID"];
        $this->CLASS_ROOM_ID->AdvancedSearch->save();

        // Field BED_ID
        $this->BED_ID->AdvancedSearch->SearchValue = @$filter["x_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchOperator = @$filter["z_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchCondition = @$filter["v_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchValue2 = @$filter["y_BED_ID"];
        $this->BED_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BED_ID"];
        $this->BED_ID->AdvancedSearch->save();

        // Field KELUAR_ID
        $this->KELUAR_ID->AdvancedSearch->SearchValue = @$filter["x_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchOperator = @$filter["z_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchCondition = @$filter["v_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchValue2 = @$filter["y_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KELUAR_ID"];
        $this->KELUAR_ID->AdvancedSearch->save();

        // Field DOCTOR
        $this->DOCTOR->AdvancedSearch->SearchValue = @$filter["x_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchOperator = @$filter["z_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchCondition = @$filter["v_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchValue2 = @$filter["y_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->SearchOperator2 = @$filter["w_DOCTOR"];
        $this->DOCTOR->AdvancedSearch->save();

        // Field NB_OBSTETRI
        $this->NB_OBSTETRI->AdvancedSearch->SearchValue = @$filter["x_NB_OBSTETRI"];
        $this->NB_OBSTETRI->AdvancedSearch->SearchOperator = @$filter["z_NB_OBSTETRI"];
        $this->NB_OBSTETRI->AdvancedSearch->SearchCondition = @$filter["v_NB_OBSTETRI"];
        $this->NB_OBSTETRI->AdvancedSearch->SearchValue2 = @$filter["y_NB_OBSTETRI"];
        $this->NB_OBSTETRI->AdvancedSearch->SearchOperator2 = @$filter["w_NB_OBSTETRI"];
        $this->NB_OBSTETRI->AdvancedSearch->save();

        // Field OBSTETRI_DIE
        $this->OBSTETRI_DIE->AdvancedSearch->SearchValue = @$filter["x_OBSTETRI_DIE"];
        $this->OBSTETRI_DIE->AdvancedSearch->SearchOperator = @$filter["z_OBSTETRI_DIE"];
        $this->OBSTETRI_DIE->AdvancedSearch->SearchCondition = @$filter["v_OBSTETRI_DIE"];
        $this->OBSTETRI_DIE->AdvancedSearch->SearchValue2 = @$filter["y_OBSTETRI_DIE"];
        $this->OBSTETRI_DIE->AdvancedSearch->SearchOperator2 = @$filter["w_OBSTETRI_DIE"];
        $this->OBSTETRI_DIE->AdvancedSearch->save();

        // Field KAL_ID
        $this->KAL_ID->AdvancedSearch->SearchValue = @$filter["x_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchOperator = @$filter["z_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchCondition = @$filter["v_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchValue2 = @$filter["y_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KAL_ID"];
        $this->KAL_ID->AdvancedSearch->save();

        // Field DIAGNOSA_ID2
        $this->DIAGNOSA_ID2->AdvancedSearch->SearchValue = @$filter["x_DIAGNOSA_ID2"];
        $this->DIAGNOSA_ID2->AdvancedSearch->SearchOperator = @$filter["z_DIAGNOSA_ID2"];
        $this->DIAGNOSA_ID2->AdvancedSearch->SearchCondition = @$filter["v_DIAGNOSA_ID2"];
        $this->DIAGNOSA_ID2->AdvancedSearch->SearchValue2 = @$filter["y_DIAGNOSA_ID2"];
        $this->DIAGNOSA_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_DIAGNOSA_ID2"];
        $this->DIAGNOSA_ID2->AdvancedSearch->save();

        // Field APGAR_ID
        $this->APGAR_ID->AdvancedSearch->SearchValue = @$filter["x_APGAR_ID"];
        $this->APGAR_ID->AdvancedSearch->SearchOperator = @$filter["z_APGAR_ID"];
        $this->APGAR_ID->AdvancedSearch->SearchCondition = @$filter["v_APGAR_ID"];
        $this->APGAR_ID->AdvancedSearch->SearchValue2 = @$filter["y_APGAR_ID"];
        $this->APGAR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_APGAR_ID"];
        $this->APGAR_ID->AdvancedSearch->save();

        // Field BIRTH_LAST_ID
        $this->BIRTH_LAST_ID->AdvancedSearch->SearchValue = @$filter["x_BIRTH_LAST_ID"];
        $this->BIRTH_LAST_ID->AdvancedSearch->SearchOperator = @$filter["z_BIRTH_LAST_ID"];
        $this->BIRTH_LAST_ID->AdvancedSearch->SearchCondition = @$filter["v_BIRTH_LAST_ID"];
        $this->BIRTH_LAST_ID->AdvancedSearch->SearchValue2 = @$filter["y_BIRTH_LAST_ID"];
        $this->BIRTH_LAST_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BIRTH_LAST_ID"];
        $this->BIRTH_LAST_ID->AdvancedSearch->save();

        // Field ID
        $this->ID->AdvancedSearch->SearchValue = @$filter["x_ID"];
        $this->ID->AdvancedSearch->SearchOperator = @$filter["z_ID"];
        $this->ID->AdvancedSearch->SearchCondition = @$filter["v_ID"];
        $this->ID->AdvancedSearch->SearchValue2 = @$filter["y_ID"];
        $this->ID->AdvancedSearch->SearchOperator2 = @$filter["w_ID"];
        $this->ID->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->OBSTETRI_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PASIEN_DIAGNOSA_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DIAGNOSA_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->NO_REGISTRATION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KOHORT_NB, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->EMPLOYEE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLINIC_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BIRTH_WAY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ABORTUS_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BIRTH_CAT, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DIRUJUK_OLEH, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PORSIO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PEMBUKAAN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KETUBAN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PRESENTASI, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->POSISI, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PENURUNAN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PLACENTA, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->LOCHIA, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RAHIM_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BIR_RAHIM_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->VISIT_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BLOODING, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DESCRIPTION, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RAHIM_SALIN, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RAHIM_NIFAS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->THENAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->THEADDRESS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->THEID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISRJ, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->GENDER, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CLASS_ROOM_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DOCTOR, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->KAL_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DIAGNOSA_ID2, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->APGAR_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BIRTH_LAST_ID, $arKeywords, $type);
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
            $this->updateSort($this->OBSTETRI_ID); // OBSTETRI_ID
            $this->updateSort($this->HPHT); // HPHT
            $this->updateSort($this->HTP); // HTP
            $this->updateSort($this->PASIEN_DIAGNOSA_ID); // PASIEN_DIAGNOSA_ID
            $this->updateSort($this->DIAGNOSA_ID); // DIAGNOSA_ID
            $this->updateSort($this->NO_REGISTRATION); // NO_REGISTRATION
            $this->updateSort($this->KOHORT_NB); // KOHORT_NB
            $this->updateSort($this->BIRTH_NB); // BIRTH_NB
            $this->updateSort($this->BIRTH_DURATION); // BIRTH_DURATION
            $this->updateSort($this->BIRTH_PLACE); // BIRTH_PLACE
            $this->updateSort($this->ANTE_NATAL); // ANTE_NATAL
            $this->updateSort($this->EMPLOYEE_ID); // EMPLOYEE_ID
            $this->updateSort($this->CLINIC_ID); // CLINIC_ID
            $this->updateSort($this->BIRTH_WAY); // BIRTH_WAY
            $this->updateSort($this->BIRTH_BY); // BIRTH_BY
            $this->updateSort($this->BIRTH_DATE); // BIRTH_DATE
            $this->updateSort($this->GESTASI); // GESTASI
            $this->updateSort($this->PARITY); // PARITY
            $this->updateSort($this->NB_BABY); // NB_BABY
            $this->updateSort($this->BABY_DIE); // BABY_DIE
            $this->updateSort($this->ABORTUS_KE); // ABORTUS_KE
            $this->updateSort($this->ABORTUS_ID); // ABORTUS_ID
            $this->updateSort($this->ABORTION_DATE); // ABORTION_DATE
            $this->updateSort($this->BIRTH_CAT); // BIRTH_CAT
            $this->updateSort($this->BIRTH_CON); // BIRTH_CON
            $this->updateSort($this->BIRTH_RISK); // BIRTH_RISK
            $this->updateSort($this->RISK_TYPE); // RISK_TYPE
            $this->updateSort($this->FOLLOW_UP); // FOLLOW_UP
            $this->updateSort($this->DIRUJUK_OLEH); // DIRUJUK_OLEH
            $this->updateSort($this->INSPECTION_DATE); // INSPECTION_DATE
            $this->updateSort($this->PORSIO); // PORSIO
            $this->updateSort($this->PEMBUKAAN); // PEMBUKAAN
            $this->updateSort($this->KETUBAN); // KETUBAN
            $this->updateSort($this->PRESENTASI); // PRESENTASI
            $this->updateSort($this->POSISI); // POSISI
            $this->updateSort($this->PENURUNAN); // PENURUNAN
            $this->updateSort($this->HEART_ID); // HEART_ID
            $this->updateSort($this->JANIN_ID); // JANIN_ID
            $this->updateSort($this->FREK_DJJ); // FREK_DJJ
            $this->updateSort($this->PLACENTA); // PLACENTA
            $this->updateSort($this->LOCHIA); // LOCHIA
            $this->updateSort($this->BAB_TYPE); // BAB_TYPE
            $this->updateSort($this->BAB_BAB_TYPE); // BAB_BAB_TYPE
            $this->updateSort($this->RAHIM_ID); // RAHIM_ID
            $this->updateSort($this->BIR_RAHIM_ID); // BIR_RAHIM_ID
            $this->updateSort($this->VISIT_ID); // VISIT_ID
            $this->updateSort($this->BLOODING); // BLOODING
            $this->updateSort($this->DESCRIPTION); // DESCRIPTION
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->MODIFIED_FROM); // MODIFIED_FROM
            $this->updateSort($this->RAHIM_SALIN); // RAHIM_SALIN
            $this->updateSort($this->RAHIM_NIFAS); // RAHIM_NIFAS
            $this->updateSort($this->BAK_TYPE); // BAK_TYPE
            $this->updateSort($this->THENAME); // THENAME
            $this->updateSort($this->THEADDRESS); // THEADDRESS
            $this->updateSort($this->THEID); // THEID
            $this->updateSort($this->STATUS_PASIEN_ID); // STATUS_PASIEN_ID
            $this->updateSort($this->ISRJ); // ISRJ
            $this->updateSort($this->AGEYEAR); // AGEYEAR
            $this->updateSort($this->AGEMONTH); // AGEMONTH
            $this->updateSort($this->AGEDAY); // AGEDAY
            $this->updateSort($this->GENDER); // GENDER
            $this->updateSort($this->CLASS_ROOM_ID); // CLASS_ROOM_ID
            $this->updateSort($this->BED_ID); // BED_ID
            $this->updateSort($this->KELUAR_ID); // KELUAR_ID
            $this->updateSort($this->DOCTOR); // DOCTOR
            $this->updateSort($this->NB_OBSTETRI); // NB_OBSTETRI
            $this->updateSort($this->OBSTETRI_DIE); // OBSTETRI_DIE
            $this->updateSort($this->KAL_ID); // KAL_ID
            $this->updateSort($this->DIAGNOSA_ID2); // DIAGNOSA_ID2
            $this->updateSort($this->APGAR_ID); // APGAR_ID
            $this->updateSort($this->BIRTH_LAST_ID); // BIRTH_LAST_ID
            $this->updateSort($this->ID); // ID
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
                $this->OBSTETRI_ID->setSort("");
                $this->HPHT->setSort("");
                $this->HTP->setSort("");
                $this->PASIEN_DIAGNOSA_ID->setSort("");
                $this->DIAGNOSA_ID->setSort("");
                $this->NO_REGISTRATION->setSort("");
                $this->KOHORT_NB->setSort("");
                $this->BIRTH_NB->setSort("");
                $this->BIRTH_DURATION->setSort("");
                $this->BIRTH_PLACE->setSort("");
                $this->ANTE_NATAL->setSort("");
                $this->EMPLOYEE_ID->setSort("");
                $this->CLINIC_ID->setSort("");
                $this->BIRTH_WAY->setSort("");
                $this->BIRTH_BY->setSort("");
                $this->BIRTH_DATE->setSort("");
                $this->GESTASI->setSort("");
                $this->PARITY->setSort("");
                $this->NB_BABY->setSort("");
                $this->BABY_DIE->setSort("");
                $this->ABORTUS_KE->setSort("");
                $this->ABORTUS_ID->setSort("");
                $this->ABORTION_DATE->setSort("");
                $this->BIRTH_CAT->setSort("");
                $this->BIRTH_CON->setSort("");
                $this->BIRTH_RISK->setSort("");
                $this->RISK_TYPE->setSort("");
                $this->FOLLOW_UP->setSort("");
                $this->DIRUJUK_OLEH->setSort("");
                $this->INSPECTION_DATE->setSort("");
                $this->PORSIO->setSort("");
                $this->PEMBUKAAN->setSort("");
                $this->KETUBAN->setSort("");
                $this->PRESENTASI->setSort("");
                $this->POSISI->setSort("");
                $this->PENURUNAN->setSort("");
                $this->HEART_ID->setSort("");
                $this->JANIN_ID->setSort("");
                $this->FREK_DJJ->setSort("");
                $this->PLACENTA->setSort("");
                $this->LOCHIA->setSort("");
                $this->BAB_TYPE->setSort("");
                $this->BAB_BAB_TYPE->setSort("");
                $this->RAHIM_ID->setSort("");
                $this->BIR_RAHIM_ID->setSort("");
                $this->VISIT_ID->setSort("");
                $this->BLOODING->setSort("");
                $this->DESCRIPTION->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->MODIFIED_FROM->setSort("");
                $this->RAHIM_SALIN->setSort("");
                $this->RAHIM_NIFAS->setSort("");
                $this->BAK_TYPE->setSort("");
                $this->THENAME->setSort("");
                $this->THEADDRESS->setSort("");
                $this->THEID->setSort("");
                $this->STATUS_PASIEN_ID->setSort("");
                $this->ISRJ->setSort("");
                $this->AGEYEAR->setSort("");
                $this->AGEMONTH->setSort("");
                $this->AGEDAY->setSort("");
                $this->GENDER->setSort("");
                $this->CLASS_ROOM_ID->setSort("");
                $this->BED_ID->setSort("");
                $this->KELUAR_ID->setSort("");
                $this->DOCTOR->setSort("");
                $this->NB_OBSTETRI->setSort("");
                $this->OBSTETRI_DIE->setSort("");
                $this->KAL_ID->setSort("");
                $this->DIAGNOSA_ID2->setSort("");
                $this->APGAR_ID->setSort("");
                $this->BIRTH_LAST_ID->setSort("");
                $this->ID->setSort("");
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->ID->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        if (IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"OBSTETRI\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("AddLink") . "</a>";
        }
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fOBSTETRIlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fOBSTETRIlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fOBSTETRIlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->ORG_UNIT_CODE->setDbValue($row['ORG_UNIT_CODE']);
        $this->OBSTETRI_ID->setDbValue($row['OBSTETRI_ID']);
        $this->HPHT->setDbValue($row['HPHT']);
        $this->HTP->setDbValue($row['HTP']);
        $this->PASIEN_DIAGNOSA_ID->setDbValue($row['PASIEN_DIAGNOSA_ID']);
        $this->DIAGNOSA_ID->setDbValue($row['DIAGNOSA_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->KOHORT_NB->setDbValue($row['KOHORT_NB']);
        $this->BIRTH_NB->setDbValue($row['BIRTH_NB']);
        $this->BIRTH_DURATION->setDbValue($row['BIRTH_DURATION']);
        $this->BIRTH_PLACE->setDbValue($row['BIRTH_PLACE']);
        $this->ANTE_NATAL->setDbValue($row['ANTE_NATAL']);
        $this->EMPLOYEE_ID->setDbValue($row['EMPLOYEE_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->BIRTH_WAY->setDbValue($row['BIRTH_WAY']);
        $this->BIRTH_BY->setDbValue($row['BIRTH_BY']);
        $this->BIRTH_DATE->setDbValue($row['BIRTH_DATE']);
        $this->GESTASI->setDbValue($row['GESTASI']);
        $this->PARITY->setDbValue($row['PARITY']);
        $this->NB_BABY->setDbValue($row['NB_BABY']);
        $this->BABY_DIE->setDbValue($row['BABY_DIE']);
        $this->ABORTUS_KE->setDbValue($row['ABORTUS_KE']);
        $this->ABORTUS_ID->setDbValue($row['ABORTUS_ID']);
        $this->ABORTION_DATE->setDbValue($row['ABORTION_DATE']);
        $this->BIRTH_CAT->setDbValue($row['BIRTH_CAT']);
        $this->BIRTH_CON->setDbValue($row['BIRTH_CON']);
        $this->BIRTH_RISK->setDbValue($row['BIRTH_RISK']);
        $this->RISK_TYPE->setDbValue($row['RISK_TYPE']);
        $this->FOLLOW_UP->setDbValue($row['FOLLOW_UP']);
        $this->DIRUJUK_OLEH->setDbValue($row['DIRUJUK_OLEH']);
        $this->INSPECTION_DATE->setDbValue($row['INSPECTION_DATE']);
        $this->PORSIO->setDbValue($row['PORSIO']);
        $this->PEMBUKAAN->setDbValue($row['PEMBUKAAN']);
        $this->KETUBAN->setDbValue($row['KETUBAN']);
        $this->PRESENTASI->setDbValue($row['PRESENTASI']);
        $this->POSISI->setDbValue($row['POSISI']);
        $this->PENURUNAN->setDbValue($row['PENURUNAN']);
        $this->HEART_ID->setDbValue($row['HEART_ID']);
        $this->JANIN_ID->setDbValue($row['JANIN_ID']);
        $this->FREK_DJJ->setDbValue($row['FREK_DJJ']);
        $this->PLACENTA->setDbValue($row['PLACENTA']);
        $this->LOCHIA->setDbValue($row['LOCHIA']);
        $this->BAB_TYPE->setDbValue($row['BAB_TYPE']);
        $this->BAB_BAB_TYPE->setDbValue($row['BAB_BAB_TYPE']);
        $this->RAHIM_ID->setDbValue($row['RAHIM_ID']);
        $this->BIR_RAHIM_ID->setDbValue($row['BIR_RAHIM_ID']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
        $this->BLOODING->setDbValue($row['BLOODING']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->MODIFIED_FROM->setDbValue($row['MODIFIED_FROM']);
        $this->RAHIM_SALIN->setDbValue($row['RAHIM_SALIN']);
        $this->RAHIM_NIFAS->setDbValue($row['RAHIM_NIFAS']);
        $this->BAK_TYPE->setDbValue($row['BAK_TYPE']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->ISRJ->setDbValue($row['ISRJ']);
        $this->AGEYEAR->setDbValue($row['AGEYEAR']);
        $this->AGEMONTH->setDbValue($row['AGEMONTH']);
        $this->AGEDAY->setDbValue($row['AGEDAY']);
        $this->GENDER->setDbValue($row['GENDER']);
        $this->CLASS_ROOM_ID->setDbValue($row['CLASS_ROOM_ID']);
        $this->BED_ID->setDbValue($row['BED_ID']);
        $this->KELUAR_ID->setDbValue($row['KELUAR_ID']);
        $this->DOCTOR->setDbValue($row['DOCTOR']);
        $this->NB_OBSTETRI->setDbValue($row['NB_OBSTETRI']);
        $this->OBSTETRI_DIE->setDbValue($row['OBSTETRI_DIE']);
        $this->KAL_ID->setDbValue($row['KAL_ID']);
        $this->DIAGNOSA_ID2->setDbValue($row['DIAGNOSA_ID2']);
        $this->APGAR_ID->setDbValue($row['APGAR_ID']);
        $this->BIRTH_LAST_ID->setDbValue($row['BIRTH_LAST_ID']);
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['OBSTETRI_ID'] = null;
        $row['HPHT'] = null;
        $row['HTP'] = null;
        $row['PASIEN_DIAGNOSA_ID'] = null;
        $row['DIAGNOSA_ID'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['KOHORT_NB'] = null;
        $row['BIRTH_NB'] = null;
        $row['BIRTH_DURATION'] = null;
        $row['BIRTH_PLACE'] = null;
        $row['ANTE_NATAL'] = null;
        $row['EMPLOYEE_ID'] = null;
        $row['CLINIC_ID'] = null;
        $row['BIRTH_WAY'] = null;
        $row['BIRTH_BY'] = null;
        $row['BIRTH_DATE'] = null;
        $row['GESTASI'] = null;
        $row['PARITY'] = null;
        $row['NB_BABY'] = null;
        $row['BABY_DIE'] = null;
        $row['ABORTUS_KE'] = null;
        $row['ABORTUS_ID'] = null;
        $row['ABORTION_DATE'] = null;
        $row['BIRTH_CAT'] = null;
        $row['BIRTH_CON'] = null;
        $row['BIRTH_RISK'] = null;
        $row['RISK_TYPE'] = null;
        $row['FOLLOW_UP'] = null;
        $row['DIRUJUK_OLEH'] = null;
        $row['INSPECTION_DATE'] = null;
        $row['PORSIO'] = null;
        $row['PEMBUKAAN'] = null;
        $row['KETUBAN'] = null;
        $row['PRESENTASI'] = null;
        $row['POSISI'] = null;
        $row['PENURUNAN'] = null;
        $row['HEART_ID'] = null;
        $row['JANIN_ID'] = null;
        $row['FREK_DJJ'] = null;
        $row['PLACENTA'] = null;
        $row['LOCHIA'] = null;
        $row['BAB_TYPE'] = null;
        $row['BAB_BAB_TYPE'] = null;
        $row['RAHIM_ID'] = null;
        $row['BIR_RAHIM_ID'] = null;
        $row['VISIT_ID'] = null;
        $row['BLOODING'] = null;
        $row['DESCRIPTION'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['MODIFIED_FROM'] = null;
        $row['RAHIM_SALIN'] = null;
        $row['RAHIM_NIFAS'] = null;
        $row['BAK_TYPE'] = null;
        $row['THENAME'] = null;
        $row['THEADDRESS'] = null;
        $row['THEID'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['ISRJ'] = null;
        $row['AGEYEAR'] = null;
        $row['AGEMONTH'] = null;
        $row['AGEDAY'] = null;
        $row['GENDER'] = null;
        $row['CLASS_ROOM_ID'] = null;
        $row['BED_ID'] = null;
        $row['KELUAR_ID'] = null;
        $row['DOCTOR'] = null;
        $row['NB_OBSTETRI'] = null;
        $row['OBSTETRI_DIE'] = null;
        $row['KAL_ID'] = null;
        $row['DIAGNOSA_ID2'] = null;
        $row['APGAR_ID'] = null;
        $row['BIRTH_LAST_ID'] = null;
        $row['ID'] = null;
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
        if ($this->FREK_DJJ->FormValue == $this->FREK_DJJ->CurrentValue && is_numeric(ConvertToFloatString($this->FREK_DJJ->CurrentValue))) {
            $this->FREK_DJJ->CurrentValue = ConvertToFloatString($this->FREK_DJJ->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // OBSTETRI_ID

        // HPHT

        // HTP

        // PASIEN_DIAGNOSA_ID

        // DIAGNOSA_ID

        // NO_REGISTRATION

        // KOHORT_NB

        // BIRTH_NB

        // BIRTH_DURATION

        // BIRTH_PLACE

        // ANTE_NATAL

        // EMPLOYEE_ID

        // CLINIC_ID

        // BIRTH_WAY

        // BIRTH_BY

        // BIRTH_DATE

        // GESTASI

        // PARITY

        // NB_BABY

        // BABY_DIE

        // ABORTUS_KE

        // ABORTUS_ID

        // ABORTION_DATE

        // BIRTH_CAT

        // BIRTH_CON

        // BIRTH_RISK

        // RISK_TYPE

        // FOLLOW_UP

        // DIRUJUK_OLEH

        // INSPECTION_DATE

        // PORSIO

        // PEMBUKAAN

        // KETUBAN

        // PRESENTASI

        // POSISI

        // PENURUNAN

        // HEART_ID

        // JANIN_ID

        // FREK_DJJ

        // PLACENTA

        // LOCHIA

        // BAB_TYPE

        // BAB_BAB_TYPE

        // RAHIM_ID

        // BIR_RAHIM_ID

        // VISIT_ID

        // BLOODING

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // MODIFIED_FROM

        // RAHIM_SALIN

        // RAHIM_NIFAS

        // BAK_TYPE

        // THENAME

        // THEADDRESS

        // THEID

        // STATUS_PASIEN_ID

        // ISRJ

        // AGEYEAR

        // AGEMONTH

        // AGEDAY

        // GENDER

        // CLASS_ROOM_ID

        // BED_ID

        // KELUAR_ID

        // DOCTOR

        // NB_OBSTETRI

        // OBSTETRI_DIE

        // KAL_ID

        // DIAGNOSA_ID2

        // APGAR_ID

        // BIRTH_LAST_ID

        // ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // OBSTETRI_ID
            $this->OBSTETRI_ID->ViewValue = $this->OBSTETRI_ID->CurrentValue;
            $this->OBSTETRI_ID->ViewCustomAttributes = "";

            // HPHT
            $this->HPHT->ViewValue = $this->HPHT->CurrentValue;
            $this->HPHT->ViewValue = FormatDateTime($this->HPHT->ViewValue, 0);
            $this->HPHT->ViewCustomAttributes = "";

            // HTP
            $this->HTP->ViewValue = $this->HTP->CurrentValue;
            $this->HTP->ViewValue = FormatDateTime($this->HTP->ViewValue, 0);
            $this->HTP->ViewCustomAttributes = "";

            // PASIEN_DIAGNOSA_ID
            $this->PASIEN_DIAGNOSA_ID->ViewValue = $this->PASIEN_DIAGNOSA_ID->CurrentValue;
            $this->PASIEN_DIAGNOSA_ID->ViewCustomAttributes = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
            $this->DIAGNOSA_ID->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // KOHORT_NB
            $this->KOHORT_NB->ViewValue = $this->KOHORT_NB->CurrentValue;
            $this->KOHORT_NB->ViewCustomAttributes = "";

            // BIRTH_NB
            $this->BIRTH_NB->ViewValue = $this->BIRTH_NB->CurrentValue;
            $this->BIRTH_NB->ViewValue = FormatNumber($this->BIRTH_NB->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_NB->ViewCustomAttributes = "";

            // BIRTH_DURATION
            $this->BIRTH_DURATION->ViewValue = $this->BIRTH_DURATION->CurrentValue;
            $this->BIRTH_DURATION->ViewValue = FormatNumber($this->BIRTH_DURATION->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_DURATION->ViewCustomAttributes = "";

            // BIRTH_PLACE
            $this->BIRTH_PLACE->ViewValue = $this->BIRTH_PLACE->CurrentValue;
            $this->BIRTH_PLACE->ViewValue = FormatNumber($this->BIRTH_PLACE->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_PLACE->ViewCustomAttributes = "";

            // ANTE_NATAL
            $this->ANTE_NATAL->ViewValue = $this->ANTE_NATAL->CurrentValue;
            $this->ANTE_NATAL->ViewValue = FormatNumber($this->ANTE_NATAL->ViewValue, 0, -2, -2, -2);
            $this->ANTE_NATAL->ViewCustomAttributes = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->ViewValue = $this->EMPLOYEE_ID->CurrentValue;
            $this->EMPLOYEE_ID->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // BIRTH_WAY
            $this->BIRTH_WAY->ViewValue = $this->BIRTH_WAY->CurrentValue;
            $this->BIRTH_WAY->ViewCustomAttributes = "";

            // BIRTH_BY
            $this->BIRTH_BY->ViewValue = $this->BIRTH_BY->CurrentValue;
            $this->BIRTH_BY->ViewValue = FormatNumber($this->BIRTH_BY->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_BY->ViewCustomAttributes = "";

            // BIRTH_DATE
            $this->BIRTH_DATE->ViewValue = $this->BIRTH_DATE->CurrentValue;
            $this->BIRTH_DATE->ViewValue = FormatDateTime($this->BIRTH_DATE->ViewValue, 0);
            $this->BIRTH_DATE->ViewCustomAttributes = "";

            // GESTASI
            $this->GESTASI->ViewValue = $this->GESTASI->CurrentValue;
            $this->GESTASI->ViewValue = FormatNumber($this->GESTASI->ViewValue, 0, -2, -2, -2);
            $this->GESTASI->ViewCustomAttributes = "";

            // PARITY
            $this->PARITY->ViewValue = $this->PARITY->CurrentValue;
            $this->PARITY->ViewValue = FormatNumber($this->PARITY->ViewValue, 0, -2, -2, -2);
            $this->PARITY->ViewCustomAttributes = "";

            // NB_BABY
            $this->NB_BABY->ViewValue = $this->NB_BABY->CurrentValue;
            $this->NB_BABY->ViewValue = FormatNumber($this->NB_BABY->ViewValue, 0, -2, -2, -2);
            $this->NB_BABY->ViewCustomAttributes = "";

            // BABY_DIE
            $this->BABY_DIE->ViewValue = $this->BABY_DIE->CurrentValue;
            $this->BABY_DIE->ViewValue = FormatNumber($this->BABY_DIE->ViewValue, 0, -2, -2, -2);
            $this->BABY_DIE->ViewCustomAttributes = "";

            // ABORTUS_KE
            $this->ABORTUS_KE->ViewValue = $this->ABORTUS_KE->CurrentValue;
            $this->ABORTUS_KE->ViewValue = FormatNumber($this->ABORTUS_KE->ViewValue, 0, -2, -2, -2);
            $this->ABORTUS_KE->ViewCustomAttributes = "";

            // ABORTUS_ID
            $this->ABORTUS_ID->ViewValue = $this->ABORTUS_ID->CurrentValue;
            $this->ABORTUS_ID->ViewCustomAttributes = "";

            // ABORTION_DATE
            $this->ABORTION_DATE->ViewValue = $this->ABORTION_DATE->CurrentValue;
            $this->ABORTION_DATE->ViewValue = FormatDateTime($this->ABORTION_DATE->ViewValue, 0);
            $this->ABORTION_DATE->ViewCustomAttributes = "";

            // BIRTH_CAT
            $this->BIRTH_CAT->ViewValue = $this->BIRTH_CAT->CurrentValue;
            $this->BIRTH_CAT->ViewCustomAttributes = "";

            // BIRTH_CON
            $this->BIRTH_CON->ViewValue = $this->BIRTH_CON->CurrentValue;
            $this->BIRTH_CON->ViewValue = FormatNumber($this->BIRTH_CON->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_CON->ViewCustomAttributes = "";

            // BIRTH_RISK
            $this->BIRTH_RISK->ViewValue = $this->BIRTH_RISK->CurrentValue;
            $this->BIRTH_RISK->ViewValue = FormatNumber($this->BIRTH_RISK->ViewValue, 0, -2, -2, -2);
            $this->BIRTH_RISK->ViewCustomAttributes = "";

            // RISK_TYPE
            $this->RISK_TYPE->ViewValue = $this->RISK_TYPE->CurrentValue;
            $this->RISK_TYPE->ViewValue = FormatNumber($this->RISK_TYPE->ViewValue, 0, -2, -2, -2);
            $this->RISK_TYPE->ViewCustomAttributes = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->ViewValue = $this->FOLLOW_UP->CurrentValue;
            $this->FOLLOW_UP->ViewValue = FormatNumber($this->FOLLOW_UP->ViewValue, 0, -2, -2, -2);
            $this->FOLLOW_UP->ViewCustomAttributes = "";

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->ViewValue = $this->DIRUJUK_OLEH->CurrentValue;
            $this->DIRUJUK_OLEH->ViewCustomAttributes = "";

            // INSPECTION_DATE
            $this->INSPECTION_DATE->ViewValue = $this->INSPECTION_DATE->CurrentValue;
            $this->INSPECTION_DATE->ViewValue = FormatDateTime($this->INSPECTION_DATE->ViewValue, 0);
            $this->INSPECTION_DATE->ViewCustomAttributes = "";

            // PORSIO
            $this->PORSIO->ViewValue = $this->PORSIO->CurrentValue;
            $this->PORSIO->ViewCustomAttributes = "";

            // PEMBUKAAN
            $this->PEMBUKAAN->ViewValue = $this->PEMBUKAAN->CurrentValue;
            $this->PEMBUKAAN->ViewCustomAttributes = "";

            // KETUBAN
            $this->KETUBAN->ViewValue = $this->KETUBAN->CurrentValue;
            $this->KETUBAN->ViewCustomAttributes = "";

            // PRESENTASI
            $this->PRESENTASI->ViewValue = $this->PRESENTASI->CurrentValue;
            $this->PRESENTASI->ViewCustomAttributes = "";

            // POSISI
            $this->POSISI->ViewValue = $this->POSISI->CurrentValue;
            $this->POSISI->ViewCustomAttributes = "";

            // PENURUNAN
            $this->PENURUNAN->ViewValue = $this->PENURUNAN->CurrentValue;
            $this->PENURUNAN->ViewCustomAttributes = "";

            // HEART_ID
            $this->HEART_ID->ViewValue = $this->HEART_ID->CurrentValue;
            $this->HEART_ID->ViewValue = FormatNumber($this->HEART_ID->ViewValue, 0, -2, -2, -2);
            $this->HEART_ID->ViewCustomAttributes = "";

            // JANIN_ID
            $this->JANIN_ID->ViewValue = $this->JANIN_ID->CurrentValue;
            $this->JANIN_ID->ViewValue = FormatNumber($this->JANIN_ID->ViewValue, 0, -2, -2, -2);
            $this->JANIN_ID->ViewCustomAttributes = "";

            // FREK_DJJ
            $this->FREK_DJJ->ViewValue = $this->FREK_DJJ->CurrentValue;
            $this->FREK_DJJ->ViewValue = FormatNumber($this->FREK_DJJ->ViewValue, 2, -2, -2, -2);
            $this->FREK_DJJ->ViewCustomAttributes = "";

            // PLACENTA
            $this->PLACENTA->ViewValue = $this->PLACENTA->CurrentValue;
            $this->PLACENTA->ViewCustomAttributes = "";

            // LOCHIA
            $this->LOCHIA->ViewValue = $this->LOCHIA->CurrentValue;
            $this->LOCHIA->ViewCustomAttributes = "";

            // BAB_TYPE
            $this->BAB_TYPE->ViewValue = $this->BAB_TYPE->CurrentValue;
            $this->BAB_TYPE->ViewValue = FormatNumber($this->BAB_TYPE->ViewValue, 0, -2, -2, -2);
            $this->BAB_TYPE->ViewCustomAttributes = "";

            // BAB_BAB_TYPE
            $this->BAB_BAB_TYPE->ViewValue = $this->BAB_BAB_TYPE->CurrentValue;
            $this->BAB_BAB_TYPE->ViewValue = FormatNumber($this->BAB_BAB_TYPE->ViewValue, 0, -2, -2, -2);
            $this->BAB_BAB_TYPE->ViewCustomAttributes = "";

            // RAHIM_ID
            $this->RAHIM_ID->ViewValue = $this->RAHIM_ID->CurrentValue;
            $this->RAHIM_ID->ViewCustomAttributes = "";

            // BIR_RAHIM_ID
            $this->BIR_RAHIM_ID->ViewValue = $this->BIR_RAHIM_ID->CurrentValue;
            $this->BIR_RAHIM_ID->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // BLOODING
            $this->BLOODING->ViewValue = $this->BLOODING->CurrentValue;
            $this->BLOODING->ViewCustomAttributes = "";

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

            // RAHIM_SALIN
            $this->RAHIM_SALIN->ViewValue = $this->RAHIM_SALIN->CurrentValue;
            $this->RAHIM_SALIN->ViewCustomAttributes = "";

            // RAHIM_NIFAS
            $this->RAHIM_NIFAS->ViewValue = $this->RAHIM_NIFAS->CurrentValue;
            $this->RAHIM_NIFAS->ViewCustomAttributes = "";

            // BAK_TYPE
            $this->BAK_TYPE->ViewValue = $this->BAK_TYPE->CurrentValue;
            $this->BAK_TYPE->ViewValue = FormatNumber($this->BAK_TYPE->ViewValue, 0, -2, -2, -2);
            $this->BAK_TYPE->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // THEID
            $this->THEID->ViewValue = $this->THEID->CurrentValue;
            $this->THEID->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

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

            // DOCTOR
            $this->DOCTOR->ViewValue = $this->DOCTOR->CurrentValue;
            $this->DOCTOR->ViewCustomAttributes = "";

            // NB_OBSTETRI
            $this->NB_OBSTETRI->ViewValue = $this->NB_OBSTETRI->CurrentValue;
            $this->NB_OBSTETRI->ViewValue = FormatNumber($this->NB_OBSTETRI->ViewValue, 0, -2, -2, -2);
            $this->NB_OBSTETRI->ViewCustomAttributes = "";

            // OBSTETRI_DIE
            $this->OBSTETRI_DIE->ViewValue = $this->OBSTETRI_DIE->CurrentValue;
            $this->OBSTETRI_DIE->ViewValue = FormatNumber($this->OBSTETRI_DIE->ViewValue, 0, -2, -2, -2);
            $this->OBSTETRI_DIE->ViewCustomAttributes = "";

            // KAL_ID
            $this->KAL_ID->ViewValue = $this->KAL_ID->CurrentValue;
            $this->KAL_ID->ViewCustomAttributes = "";

            // DIAGNOSA_ID2
            $this->DIAGNOSA_ID2->ViewValue = $this->DIAGNOSA_ID2->CurrentValue;
            $this->DIAGNOSA_ID2->ViewCustomAttributes = "";

            // APGAR_ID
            $this->APGAR_ID->ViewValue = $this->APGAR_ID->CurrentValue;
            $this->APGAR_ID->ViewCustomAttributes = "";

            // BIRTH_LAST_ID
            $this->BIRTH_LAST_ID->ViewValue = $this->BIRTH_LAST_ID->CurrentValue;
            $this->BIRTH_LAST_ID->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // OBSTETRI_ID
            $this->OBSTETRI_ID->LinkCustomAttributes = "";
            $this->OBSTETRI_ID->HrefValue = "";
            $this->OBSTETRI_ID->TooltipValue = "";

            // HPHT
            $this->HPHT->LinkCustomAttributes = "";
            $this->HPHT->HrefValue = "";
            $this->HPHT->TooltipValue = "";

            // HTP
            $this->HTP->LinkCustomAttributes = "";
            $this->HTP->HrefValue = "";
            $this->HTP->TooltipValue = "";

            // PASIEN_DIAGNOSA_ID
            $this->PASIEN_DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->PASIEN_DIAGNOSA_ID->HrefValue = "";
            $this->PASIEN_DIAGNOSA_ID->TooltipValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID->HrefValue = "";
            $this->DIAGNOSA_ID->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // KOHORT_NB
            $this->KOHORT_NB->LinkCustomAttributes = "";
            $this->KOHORT_NB->HrefValue = "";
            $this->KOHORT_NB->TooltipValue = "";

            // BIRTH_NB
            $this->BIRTH_NB->LinkCustomAttributes = "";
            $this->BIRTH_NB->HrefValue = "";
            $this->BIRTH_NB->TooltipValue = "";

            // BIRTH_DURATION
            $this->BIRTH_DURATION->LinkCustomAttributes = "";
            $this->BIRTH_DURATION->HrefValue = "";
            $this->BIRTH_DURATION->TooltipValue = "";

            // BIRTH_PLACE
            $this->BIRTH_PLACE->LinkCustomAttributes = "";
            $this->BIRTH_PLACE->HrefValue = "";
            $this->BIRTH_PLACE->TooltipValue = "";

            // ANTE_NATAL
            $this->ANTE_NATAL->LinkCustomAttributes = "";
            $this->ANTE_NATAL->HrefValue = "";
            $this->ANTE_NATAL->TooltipValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";
            $this->EMPLOYEE_ID->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // BIRTH_WAY
            $this->BIRTH_WAY->LinkCustomAttributes = "";
            $this->BIRTH_WAY->HrefValue = "";
            $this->BIRTH_WAY->TooltipValue = "";

            // BIRTH_BY
            $this->BIRTH_BY->LinkCustomAttributes = "";
            $this->BIRTH_BY->HrefValue = "";
            $this->BIRTH_BY->TooltipValue = "";

            // BIRTH_DATE
            $this->BIRTH_DATE->LinkCustomAttributes = "";
            $this->BIRTH_DATE->HrefValue = "";
            $this->BIRTH_DATE->TooltipValue = "";

            // GESTASI
            $this->GESTASI->LinkCustomAttributes = "";
            $this->GESTASI->HrefValue = "";
            $this->GESTASI->TooltipValue = "";

            // PARITY
            $this->PARITY->LinkCustomAttributes = "";
            $this->PARITY->HrefValue = "";
            $this->PARITY->TooltipValue = "";

            // NB_BABY
            $this->NB_BABY->LinkCustomAttributes = "";
            $this->NB_BABY->HrefValue = "";
            $this->NB_BABY->TooltipValue = "";

            // BABY_DIE
            $this->BABY_DIE->LinkCustomAttributes = "";
            $this->BABY_DIE->HrefValue = "";
            $this->BABY_DIE->TooltipValue = "";

            // ABORTUS_KE
            $this->ABORTUS_KE->LinkCustomAttributes = "";
            $this->ABORTUS_KE->HrefValue = "";
            $this->ABORTUS_KE->TooltipValue = "";

            // ABORTUS_ID
            $this->ABORTUS_ID->LinkCustomAttributes = "";
            $this->ABORTUS_ID->HrefValue = "";
            $this->ABORTUS_ID->TooltipValue = "";

            // ABORTION_DATE
            $this->ABORTION_DATE->LinkCustomAttributes = "";
            $this->ABORTION_DATE->HrefValue = "";
            $this->ABORTION_DATE->TooltipValue = "";

            // BIRTH_CAT
            $this->BIRTH_CAT->LinkCustomAttributes = "";
            $this->BIRTH_CAT->HrefValue = "";
            $this->BIRTH_CAT->TooltipValue = "";

            // BIRTH_CON
            $this->BIRTH_CON->LinkCustomAttributes = "";
            $this->BIRTH_CON->HrefValue = "";
            $this->BIRTH_CON->TooltipValue = "";

            // BIRTH_RISK
            $this->BIRTH_RISK->LinkCustomAttributes = "";
            $this->BIRTH_RISK->HrefValue = "";
            $this->BIRTH_RISK->TooltipValue = "";

            // RISK_TYPE
            $this->RISK_TYPE->LinkCustomAttributes = "";
            $this->RISK_TYPE->HrefValue = "";
            $this->RISK_TYPE->TooltipValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->LinkCustomAttributes = "";
            $this->FOLLOW_UP->HrefValue = "";
            $this->FOLLOW_UP->TooltipValue = "";

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->LinkCustomAttributes = "";
            $this->DIRUJUK_OLEH->HrefValue = "";
            $this->DIRUJUK_OLEH->TooltipValue = "";

            // INSPECTION_DATE
            $this->INSPECTION_DATE->LinkCustomAttributes = "";
            $this->INSPECTION_DATE->HrefValue = "";
            $this->INSPECTION_DATE->TooltipValue = "";

            // PORSIO
            $this->PORSIO->LinkCustomAttributes = "";
            $this->PORSIO->HrefValue = "";
            $this->PORSIO->TooltipValue = "";

            // PEMBUKAAN
            $this->PEMBUKAAN->LinkCustomAttributes = "";
            $this->PEMBUKAAN->HrefValue = "";
            $this->PEMBUKAAN->TooltipValue = "";

            // KETUBAN
            $this->KETUBAN->LinkCustomAttributes = "";
            $this->KETUBAN->HrefValue = "";
            $this->KETUBAN->TooltipValue = "";

            // PRESENTASI
            $this->PRESENTASI->LinkCustomAttributes = "";
            $this->PRESENTASI->HrefValue = "";
            $this->PRESENTASI->TooltipValue = "";

            // POSISI
            $this->POSISI->LinkCustomAttributes = "";
            $this->POSISI->HrefValue = "";
            $this->POSISI->TooltipValue = "";

            // PENURUNAN
            $this->PENURUNAN->LinkCustomAttributes = "";
            $this->PENURUNAN->HrefValue = "";
            $this->PENURUNAN->TooltipValue = "";

            // HEART_ID
            $this->HEART_ID->LinkCustomAttributes = "";
            $this->HEART_ID->HrefValue = "";
            $this->HEART_ID->TooltipValue = "";

            // JANIN_ID
            $this->JANIN_ID->LinkCustomAttributes = "";
            $this->JANIN_ID->HrefValue = "";
            $this->JANIN_ID->TooltipValue = "";

            // FREK_DJJ
            $this->FREK_DJJ->LinkCustomAttributes = "";
            $this->FREK_DJJ->HrefValue = "";
            $this->FREK_DJJ->TooltipValue = "";

            // PLACENTA
            $this->PLACENTA->LinkCustomAttributes = "";
            $this->PLACENTA->HrefValue = "";
            $this->PLACENTA->TooltipValue = "";

            // LOCHIA
            $this->LOCHIA->LinkCustomAttributes = "";
            $this->LOCHIA->HrefValue = "";
            $this->LOCHIA->TooltipValue = "";

            // BAB_TYPE
            $this->BAB_TYPE->LinkCustomAttributes = "";
            $this->BAB_TYPE->HrefValue = "";
            $this->BAB_TYPE->TooltipValue = "";

            // BAB_BAB_TYPE
            $this->BAB_BAB_TYPE->LinkCustomAttributes = "";
            $this->BAB_BAB_TYPE->HrefValue = "";
            $this->BAB_BAB_TYPE->TooltipValue = "";

            // RAHIM_ID
            $this->RAHIM_ID->LinkCustomAttributes = "";
            $this->RAHIM_ID->HrefValue = "";
            $this->RAHIM_ID->TooltipValue = "";

            // BIR_RAHIM_ID
            $this->BIR_RAHIM_ID->LinkCustomAttributes = "";
            $this->BIR_RAHIM_ID->HrefValue = "";
            $this->BIR_RAHIM_ID->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // BLOODING
            $this->BLOODING->LinkCustomAttributes = "";
            $this->BLOODING->HrefValue = "";
            $this->BLOODING->TooltipValue = "";

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

            // RAHIM_SALIN
            $this->RAHIM_SALIN->LinkCustomAttributes = "";
            $this->RAHIM_SALIN->HrefValue = "";
            $this->RAHIM_SALIN->TooltipValue = "";

            // RAHIM_NIFAS
            $this->RAHIM_NIFAS->LinkCustomAttributes = "";
            $this->RAHIM_NIFAS->HrefValue = "";
            $this->RAHIM_NIFAS->TooltipValue = "";

            // BAK_TYPE
            $this->BAK_TYPE->LinkCustomAttributes = "";
            $this->BAK_TYPE->HrefValue = "";
            $this->BAK_TYPE->TooltipValue = "";

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

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

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

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";
            $this->DOCTOR->TooltipValue = "";

            // NB_OBSTETRI
            $this->NB_OBSTETRI->LinkCustomAttributes = "";
            $this->NB_OBSTETRI->HrefValue = "";
            $this->NB_OBSTETRI->TooltipValue = "";

            // OBSTETRI_DIE
            $this->OBSTETRI_DIE->LinkCustomAttributes = "";
            $this->OBSTETRI_DIE->HrefValue = "";
            $this->OBSTETRI_DIE->TooltipValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";
            $this->KAL_ID->TooltipValue = "";

            // DIAGNOSA_ID2
            $this->DIAGNOSA_ID2->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID2->HrefValue = "";
            $this->DIAGNOSA_ID2->TooltipValue = "";

            // APGAR_ID
            $this->APGAR_ID->LinkCustomAttributes = "";
            $this->APGAR_ID->HrefValue = "";
            $this->APGAR_ID->TooltipValue = "";

            // BIRTH_LAST_ID
            $this->BIRTH_LAST_ID->LinkCustomAttributes = "";
            $this->BIRTH_LAST_ID->HrefValue = "";
            $this->BIRTH_LAST_ID->TooltipValue = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";
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
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fOBSTETRIlist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fOBSTETRIlist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fOBSTETRIlist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
            return '<button id="emf_OBSTETRI" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_OBSTETRI\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fOBSTETRIlist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fOBSTETRIlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
