<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodGfList extends GoodGf
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOOD_GF';

    // Page object name
    public $PageObjName = "GoodGfList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fGOOD_GFlist";
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

        // Table object (GOOD_GF)
        if (!isset($GLOBALS["GOOD_GF"]) || get_class($GLOBALS["GOOD_GF"]) == PROJECT_NAMESPACE . "GOOD_GF") {
            $GLOBALS["GOOD_GF"] = &$this;
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
        $this->AddUrl = "GoodGfAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "GoodGfDelete";
        $this->MultiUpdateUrl = "GoodGfUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'GOOD_GF');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fGOOD_GFlistsrch";

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
                $doc = new $class(Container("GOOD_GF"));
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
            $key .= @$ar['idx'];
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
            $this->MODIFIED_DATE->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->MODIFIED_BY->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->CORRECTION_DATE->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->PRINT_DATE->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->PRINTED_BY->Visible = false;
        }
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->idx->Visible = false;
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

        // Create form object
        $CurrentForm = new HttpForm();

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
        $this->ITEM_ID->Visible = false;
        $this->ORG_ID->setVisibility();
        $this->BATCH_NO->Visible = false;
        $this->BRAND_ID->setVisibility();
        $this->ROOMS_ID->setVisibility();
        $this->SHELF_NO->Visible = false;
        $this->EXPIRY_DATE->Visible = false;
        $this->SERIAL_NB->Visible = false;
        $this->FROM_ROOMS_ID->setVisibility();
        $this->ISOUTLET->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->CONDITION->setVisibility();
        $this->ALLOCATED_DATE->setVisibility();
        $this->STOCKOPNAME_DATE->setVisibility();
        $this->INVOICE_ID->Visible = false;
        $this->ALLOCATED_FROM->Visible = false;
        $this->PRICE->Visible = false;
        $this->DISCOUNT->Visible = false;
        $this->DISCOUNT2->Visible = false;
        $this->DISCOUNTOFF->Visible = false;
        $this->ORG_UNIT_FROM->setVisibility();
        $this->ITEM_ID_FROM->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->STOCK_OPNAME->setVisibility();
        $this->STOK_AWAL->setVisibility();
        $this->STOCK_LALU->Visible = false;
        $this->STOCK_KOREKSI->setVisibility();
        $this->DITERIMA->Visible = false;
        $this->DISTRIBUSI->Visible = false;
        $this->DIJUAL->Visible = false;
        $this->DIHAPUS->Visible = false;
        $this->DIMINTA->Visible = false;
        $this->DIRETUR->Visible = false;
        $this->PO->Visible = false;
        $this->COMPANY_ID->Visible = false;
        $this->FUND_ID->Visible = false;
        $this->INVOICE_ID2->Visible = false;
        $this->MEASURE_ID3->Visible = false;
        $this->SIZE_KEMASAN->Visible = false;
        $this->BRAND_NAME->setVisibility();
        $this->MEASURE_ID2->Visible = false;
        $this->RETUR_ID->Visible = false;
        $this->SIZE_GOODS->Visible = false;
        $this->MEASURE_DOSIS->Visible = false;
        $this->ORDER_PRICE->Visible = false;
        $this->STOCK_AVAILABLE->Visible = false;
        $this->STATUS_PASIEN_ID->Visible = false;
        $this->MONTH_ID->setVisibility();
        $this->YEAR_ID->setVisibility();
        $this->CORRECTION_DOC->Visible = false;
        $this->CORRECTIONS->Visible = false;
        $this->CORRECTION_DATE->Visible = false;
        $this->DOC_NO->setVisibility();
        $this->ORDER_ID->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->Visible = false;
        $this->PRINTED_BY->Visible = false;
        $this->PRINTQ->Visible = false;
        $this->avgprice->Visible = false;
        $this->idx->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

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
        $this->setupLookupOptions($this->BRAND_ID);

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

            // Check QueryString parameters
            if (Get("action") !== null) {
                $this->CurrentAction = Get("action");

                // Clear inline mode
                if ($this->isCancel()) {
                    $this->clearInlineMode();
                }

                // Switch to inline edit mode
                if ($this->isEdit()) {
                    $this->inlineEditMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Inline Update
                    if (($this->isUpdate() || $this->isOverwrite()) && Session(SESSION_INLINE_MODE) == "edit") {
                        $this->setKey(Post($this->OldKeyName));
                        $this->inlineUpdate();
                    }
                }
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

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "MUTATION_DOCS") {
            $masterTbl = Container("MUTATION_DOCS");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("MutationDocsList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->QUANTITY->FormValue = ""; // Clear form value
        $this->STOCK_OPNAME->FormValue = ""; // Clear form value
        $this->STOK_AWAL->FormValue = ""; // Clear form value
        $this->STOCK_KOREKSI->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Inline Edit mode
    protected function inlineEditMode()
    {
        global $Security, $Language;
        if (!$Security->canEdit()) {
            return false; // Edit not allowed
        }
        $inlineEdit = true;
        if (($keyValue = Get("idx") ?? Route("idx")) !== null) {
            $this->idx->setQueryStringValue($keyValue);
        } else {
            $inlineEdit = false;
        }
        if ($inlineEdit) {
            if ($this->loadRow()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey); // Set to OldValue
                $_SESSION[SESSION_INLINE_MODE] = "edit"; // Enable inline edit
            }
        }
        return true;
    }

    // Perform update to Inline Edit record
    protected function inlineUpdate()
    {
        global $Language, $CurrentForm;
        $CurrentForm->Index = 1;
        $this->loadFormValues(); // Get form values

        // Validate form
        $inlineUpdate = true;
        if (!$this->validateForm()) {
            $inlineUpdate = false; // Form error, reset action
        } else {
            $inlineUpdate = false;
            $this->SendEmail = true; // Send email on update success
            $inlineUpdate = $this->editRow(); // Update record
        }
        if ($inlineUpdate) { // Update success
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
            $this->EventCancelled = true; // Cancel event
            $this->CurrentAction = "edit"; // Stay in edit mode
        }
    }

    // Check Inline Edit key
    public function checkInlineEditKey()
    {
        if (!SameString($this->idx->OldValue, $this->idx->CurrentValue)) {
            return false;
        }
        return true;
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
        $filterList = Concat($filterList, $this->ITEM_ID->AdvancedSearch->toJson(), ","); // Field ITEM_ID
        $filterList = Concat($filterList, $this->ORG_ID->AdvancedSearch->toJson(), ","); // Field ORG_ID
        $filterList = Concat($filterList, $this->BATCH_NO->AdvancedSearch->toJson(), ","); // Field BATCH_NO
        $filterList = Concat($filterList, $this->BRAND_ID->AdvancedSearch->toJson(), ","); // Field BRAND_ID
        $filterList = Concat($filterList, $this->ROOMS_ID->AdvancedSearch->toJson(), ","); // Field ROOMS_ID
        $filterList = Concat($filterList, $this->SHELF_NO->AdvancedSearch->toJson(), ","); // Field SHELF_NO
        $filterList = Concat($filterList, $this->EXPIRY_DATE->AdvancedSearch->toJson(), ","); // Field EXPIRY_DATE
        $filterList = Concat($filterList, $this->SERIAL_NB->AdvancedSearch->toJson(), ","); // Field SERIAL_NB
        $filterList = Concat($filterList, $this->FROM_ROOMS_ID->AdvancedSearch->toJson(), ","); // Field FROM_ROOMS_ID
        $filterList = Concat($filterList, $this->ISOUTLET->AdvancedSearch->toJson(), ","); // Field ISOUTLET
        $filterList = Concat($filterList, $this->QUANTITY->AdvancedSearch->toJson(), ","); // Field QUANTITY
        $filterList = Concat($filterList, $this->MEASURE_ID->AdvancedSearch->toJson(), ","); // Field MEASURE_ID
        $filterList = Concat($filterList, $this->DISTRIBUTION_TYPE->AdvancedSearch->toJson(), ","); // Field DISTRIBUTION_TYPE
        $filterList = Concat($filterList, $this->CONDITION->AdvancedSearch->toJson(), ","); // Field CONDITION
        $filterList = Concat($filterList, $this->ALLOCATED_DATE->AdvancedSearch->toJson(), ","); // Field ALLOCATED_DATE
        $filterList = Concat($filterList, $this->STOCKOPNAME_DATE->AdvancedSearch->toJson(), ","); // Field STOCKOPNAME_DATE
        $filterList = Concat($filterList, $this->INVOICE_ID->AdvancedSearch->toJson(), ","); // Field INVOICE_ID
        $filterList = Concat($filterList, $this->ALLOCATED_FROM->AdvancedSearch->toJson(), ","); // Field ALLOCATED_FROM
        $filterList = Concat($filterList, $this->PRICE->AdvancedSearch->toJson(), ","); // Field PRICE
        $filterList = Concat($filterList, $this->DISCOUNT->AdvancedSearch->toJson(), ","); // Field DISCOUNT
        $filterList = Concat($filterList, $this->DISCOUNT2->AdvancedSearch->toJson(), ","); // Field DISCOUNT2
        $filterList = Concat($filterList, $this->DISCOUNTOFF->AdvancedSearch->toJson(), ","); // Field DISCOUNTOFF
        $filterList = Concat($filterList, $this->ORG_UNIT_FROM->AdvancedSearch->toJson(), ","); // Field ORG_UNIT_FROM
        $filterList = Concat($filterList, $this->ITEM_ID_FROM->AdvancedSearch->toJson(), ","); // Field ITEM_ID_FROM
        $filterList = Concat($filterList, $this->MODIFIED_DATE->AdvancedSearch->toJson(), ","); // Field MODIFIED_DATE
        $filterList = Concat($filterList, $this->MODIFIED_BY->AdvancedSearch->toJson(), ","); // Field MODIFIED_BY
        $filterList = Concat($filterList, $this->STOCK_OPNAME->AdvancedSearch->toJson(), ","); // Field STOCK_OPNAME
        $filterList = Concat($filterList, $this->STOK_AWAL->AdvancedSearch->toJson(), ","); // Field STOK_AWAL
        $filterList = Concat($filterList, $this->STOCK_LALU->AdvancedSearch->toJson(), ","); // Field STOCK_LALU
        $filterList = Concat($filterList, $this->STOCK_KOREKSI->AdvancedSearch->toJson(), ","); // Field STOCK_KOREKSI
        $filterList = Concat($filterList, $this->DITERIMA->AdvancedSearch->toJson(), ","); // Field DITERIMA
        $filterList = Concat($filterList, $this->DISTRIBUSI->AdvancedSearch->toJson(), ","); // Field DISTRIBUSI
        $filterList = Concat($filterList, $this->DIJUAL->AdvancedSearch->toJson(), ","); // Field DIJUAL
        $filterList = Concat($filterList, $this->DIHAPUS->AdvancedSearch->toJson(), ","); // Field DIHAPUS
        $filterList = Concat($filterList, $this->DIMINTA->AdvancedSearch->toJson(), ","); // Field DIMINTA
        $filterList = Concat($filterList, $this->DIRETUR->AdvancedSearch->toJson(), ","); // Field DIRETUR
        $filterList = Concat($filterList, $this->PO->AdvancedSearch->toJson(), ","); // Field PO
        $filterList = Concat($filterList, $this->COMPANY_ID->AdvancedSearch->toJson(), ","); // Field COMPANY_ID
        $filterList = Concat($filterList, $this->FUND_ID->AdvancedSearch->toJson(), ","); // Field FUND_ID
        $filterList = Concat($filterList, $this->INVOICE_ID2->AdvancedSearch->toJson(), ","); // Field INVOICE_ID2
        $filterList = Concat($filterList, $this->MEASURE_ID3->AdvancedSearch->toJson(), ","); // Field MEASURE_ID3
        $filterList = Concat($filterList, $this->SIZE_KEMASAN->AdvancedSearch->toJson(), ","); // Field SIZE_KEMASAN
        $filterList = Concat($filterList, $this->BRAND_NAME->AdvancedSearch->toJson(), ","); // Field BRAND_NAME
        $filterList = Concat($filterList, $this->MEASURE_ID2->AdvancedSearch->toJson(), ","); // Field MEASURE_ID2
        $filterList = Concat($filterList, $this->RETUR_ID->AdvancedSearch->toJson(), ","); // Field RETUR_ID
        $filterList = Concat($filterList, $this->SIZE_GOODS->AdvancedSearch->toJson(), ","); // Field SIZE_GOODS
        $filterList = Concat($filterList, $this->MEASURE_DOSIS->AdvancedSearch->toJson(), ","); // Field MEASURE_DOSIS
        $filterList = Concat($filterList, $this->ORDER_PRICE->AdvancedSearch->toJson(), ","); // Field ORDER_PRICE
        $filterList = Concat($filterList, $this->STOCK_AVAILABLE->AdvancedSearch->toJson(), ","); // Field STOCK_AVAILABLE
        $filterList = Concat($filterList, $this->STATUS_PASIEN_ID->AdvancedSearch->toJson(), ","); // Field STATUS_PASIEN_ID
        $filterList = Concat($filterList, $this->MONTH_ID->AdvancedSearch->toJson(), ","); // Field MONTH_ID
        $filterList = Concat($filterList, $this->YEAR_ID->AdvancedSearch->toJson(), ","); // Field YEAR_ID
        $filterList = Concat($filterList, $this->CORRECTION_DOC->AdvancedSearch->toJson(), ","); // Field CORRECTION_DOC
        $filterList = Concat($filterList, $this->CORRECTIONS->AdvancedSearch->toJson(), ","); // Field CORRECTIONS
        $filterList = Concat($filterList, $this->CORRECTION_DATE->AdvancedSearch->toJson(), ","); // Field CORRECTION_DATE
        $filterList = Concat($filterList, $this->DOC_NO->AdvancedSearch->toJson(), ","); // Field DOC_NO
        $filterList = Concat($filterList, $this->ORDER_ID->AdvancedSearch->toJson(), ","); // Field ORDER_ID
        $filterList = Concat($filterList, $this->ISCETAK->AdvancedSearch->toJson(), ","); // Field ISCETAK
        $filterList = Concat($filterList, $this->PRINT_DATE->AdvancedSearch->toJson(), ","); // Field PRINT_DATE
        $filterList = Concat($filterList, $this->PRINTED_BY->AdvancedSearch->toJson(), ","); // Field PRINTED_BY
        $filterList = Concat($filterList, $this->PRINTQ->AdvancedSearch->toJson(), ","); // Field PRINTQ
        $filterList = Concat($filterList, $this->avgprice->AdvancedSearch->toJson(), ","); // Field avgprice
        $filterList = Concat($filterList, $this->idx->AdvancedSearch->toJson(), ","); // Field idx
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fGOOD_GFlistsrch", $filters);
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

        // Field ITEM_ID
        $this->ITEM_ID->AdvancedSearch->SearchValue = @$filter["x_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchOperator = @$filter["z_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchCondition = @$filter["v_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchValue2 = @$filter["y_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ITEM_ID"];
        $this->ITEM_ID->AdvancedSearch->save();

        // Field ORG_ID
        $this->ORG_ID->AdvancedSearch->SearchValue = @$filter["x_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator = @$filter["z_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchCondition = @$filter["v_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchValue2 = @$filter["y_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_ID"];
        $this->ORG_ID->AdvancedSearch->save();

        // Field BATCH_NO
        $this->BATCH_NO->AdvancedSearch->SearchValue = @$filter["x_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchOperator = @$filter["z_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchCondition = @$filter["v_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchValue2 = @$filter["y_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->SearchOperator2 = @$filter["w_BATCH_NO"];
        $this->BATCH_NO->AdvancedSearch->save();

        // Field BRAND_ID
        $this->BRAND_ID->AdvancedSearch->SearchValue = @$filter["x_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator = @$filter["z_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchCondition = @$filter["v_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchValue2 = @$filter["y_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_BRAND_ID"];
        $this->BRAND_ID->AdvancedSearch->save();

        // Field ROOMS_ID
        $this->ROOMS_ID->AdvancedSearch->SearchValue = @$filter["x_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchOperator = @$filter["z_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchCondition = @$filter["v_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchValue2 = @$filter["y_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ROOMS_ID"];
        $this->ROOMS_ID->AdvancedSearch->save();

        // Field SHELF_NO
        $this->SHELF_NO->AdvancedSearch->SearchValue = @$filter["x_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchOperator = @$filter["z_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchCondition = @$filter["v_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchValue2 = @$filter["y_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->SearchOperator2 = @$filter["w_SHELF_NO"];
        $this->SHELF_NO->AdvancedSearch->save();

        // Field EXPIRY_DATE
        $this->EXPIRY_DATE->AdvancedSearch->SearchValue = @$filter["x_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchOperator = @$filter["z_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchCondition = @$filter["v_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchValue2 = @$filter["y_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_EXPIRY_DATE"];
        $this->EXPIRY_DATE->AdvancedSearch->save();

        // Field SERIAL_NB
        $this->SERIAL_NB->AdvancedSearch->SearchValue = @$filter["x_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchOperator = @$filter["z_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchCondition = @$filter["v_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchValue2 = @$filter["y_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->SearchOperator2 = @$filter["w_SERIAL_NB"];
        $this->SERIAL_NB->AdvancedSearch->save();

        // Field FROM_ROOMS_ID
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchValue = @$filter["x_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchOperator = @$filter["z_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchCondition = @$filter["v_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchValue2 = @$filter["y_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FROM_ROOMS_ID"];
        $this->FROM_ROOMS_ID->AdvancedSearch->save();

        // Field ISOUTLET
        $this->ISOUTLET->AdvancedSearch->SearchValue = @$filter["x_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchOperator = @$filter["z_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchCondition = @$filter["v_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchValue2 = @$filter["y_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->SearchOperator2 = @$filter["w_ISOUTLET"];
        $this->ISOUTLET->AdvancedSearch->save();

        // Field QUANTITY
        $this->QUANTITY->AdvancedSearch->SearchValue = @$filter["x_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchOperator = @$filter["z_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchCondition = @$filter["v_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchValue2 = @$filter["y_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->SearchOperator2 = @$filter["w_QUANTITY"];
        $this->QUANTITY->AdvancedSearch->save();

        // Field MEASURE_ID
        $this->MEASURE_ID->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID"];
        $this->MEASURE_ID->AdvancedSearch->save();

        // Field DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchValue = @$filter["x_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchOperator = @$filter["z_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchCondition = @$filter["v_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchValue2 = @$filter["y_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->SearchOperator2 = @$filter["w_DISTRIBUTION_TYPE"];
        $this->DISTRIBUTION_TYPE->AdvancedSearch->save();

        // Field CONDITION
        $this->CONDITION->AdvancedSearch->SearchValue = @$filter["x_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchOperator = @$filter["z_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchCondition = @$filter["v_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchValue2 = @$filter["y_CONDITION"];
        $this->CONDITION->AdvancedSearch->SearchOperator2 = @$filter["w_CONDITION"];
        $this->CONDITION->AdvancedSearch->save();

        // Field ALLOCATED_DATE
        $this->ALLOCATED_DATE->AdvancedSearch->SearchValue = @$filter["x_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchOperator = @$filter["z_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchCondition = @$filter["v_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchValue2 = @$filter["y_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_ALLOCATED_DATE"];
        $this->ALLOCATED_DATE->AdvancedSearch->save();

        // Field STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchValue = @$filter["x_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchOperator = @$filter["z_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchCondition = @$filter["v_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchValue2 = @$filter["y_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_STOCKOPNAME_DATE"];
        $this->STOCKOPNAME_DATE->AdvancedSearch->save();

        // Field INVOICE_ID
        $this->INVOICE_ID->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID"];
        $this->INVOICE_ID->AdvancedSearch->save();

        // Field ALLOCATED_FROM
        $this->ALLOCATED_FROM->AdvancedSearch->SearchValue = @$filter["x_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchOperator = @$filter["z_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchCondition = @$filter["v_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchValue2 = @$filter["y_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_ALLOCATED_FROM"];
        $this->ALLOCATED_FROM->AdvancedSearch->save();

        // Field PRICE
        $this->PRICE->AdvancedSearch->SearchValue = @$filter["x_PRICE"];
        $this->PRICE->AdvancedSearch->SearchOperator = @$filter["z_PRICE"];
        $this->PRICE->AdvancedSearch->SearchCondition = @$filter["v_PRICE"];
        $this->PRICE->AdvancedSearch->SearchValue2 = @$filter["y_PRICE"];
        $this->PRICE->AdvancedSearch->SearchOperator2 = @$filter["w_PRICE"];
        $this->PRICE->AdvancedSearch->save();

        // Field DISCOUNT
        $this->DISCOUNT->AdvancedSearch->SearchValue = @$filter["x_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNT"];
        $this->DISCOUNT->AdvancedSearch->save();

        // Field DISCOUNT2
        $this->DISCOUNT2->AdvancedSearch->SearchValue = @$filter["x_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNT2"];
        $this->DISCOUNT2->AdvancedSearch->save();

        // Field DISCOUNTOFF
        $this->DISCOUNTOFF->AdvancedSearch->SearchValue = @$filter["x_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchOperator = @$filter["z_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchCondition = @$filter["v_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchValue2 = @$filter["y_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->SearchOperator2 = @$filter["w_DISCOUNTOFF"];
        $this->DISCOUNTOFF->AdvancedSearch->save();

        // Field ORG_UNIT_FROM
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchValue = @$filter["x_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchOperator = @$filter["z_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchCondition = @$filter["v_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchValue2 = @$filter["y_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_ORG_UNIT_FROM"];
        $this->ORG_UNIT_FROM->AdvancedSearch->save();

        // Field ITEM_ID_FROM
        $this->ITEM_ID_FROM->AdvancedSearch->SearchValue = @$filter["x_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchOperator = @$filter["z_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchCondition = @$filter["v_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchValue2 = @$filter["y_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->SearchOperator2 = @$filter["w_ITEM_ID_FROM"];
        $this->ITEM_ID_FROM->AdvancedSearch->save();

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

        // Field STOCK_OPNAME
        $this->STOCK_OPNAME->AdvancedSearch->SearchValue = @$filter["x_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchOperator = @$filter["z_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchCondition = @$filter["v_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_OPNAME"];
        $this->STOCK_OPNAME->AdvancedSearch->save();

        // Field STOK_AWAL
        $this->STOK_AWAL->AdvancedSearch->SearchValue = @$filter["x_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchOperator = @$filter["z_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchCondition = @$filter["v_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchValue2 = @$filter["y_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->SearchOperator2 = @$filter["w_STOK_AWAL"];
        $this->STOK_AWAL->AdvancedSearch->save();

        // Field STOCK_LALU
        $this->STOCK_LALU->AdvancedSearch->SearchValue = @$filter["x_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchOperator = @$filter["z_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchCondition = @$filter["v_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_LALU"];
        $this->STOCK_LALU->AdvancedSearch->save();

        // Field STOCK_KOREKSI
        $this->STOCK_KOREKSI->AdvancedSearch->SearchValue = @$filter["x_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchOperator = @$filter["z_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchCondition = @$filter["v_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_KOREKSI"];
        $this->STOCK_KOREKSI->AdvancedSearch->save();

        // Field DITERIMA
        $this->DITERIMA->AdvancedSearch->SearchValue = @$filter["x_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchOperator = @$filter["z_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchCondition = @$filter["v_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchValue2 = @$filter["y_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->SearchOperator2 = @$filter["w_DITERIMA"];
        $this->DITERIMA->AdvancedSearch->save();

        // Field DISTRIBUSI
        $this->DISTRIBUSI->AdvancedSearch->SearchValue = @$filter["x_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchOperator = @$filter["z_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchCondition = @$filter["v_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchValue2 = @$filter["y_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->SearchOperator2 = @$filter["w_DISTRIBUSI"];
        $this->DISTRIBUSI->AdvancedSearch->save();

        // Field DIJUAL
        $this->DIJUAL->AdvancedSearch->SearchValue = @$filter["x_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchOperator = @$filter["z_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchCondition = @$filter["v_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchValue2 = @$filter["y_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->SearchOperator2 = @$filter["w_DIJUAL"];
        $this->DIJUAL->AdvancedSearch->save();

        // Field DIHAPUS
        $this->DIHAPUS->AdvancedSearch->SearchValue = @$filter["x_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchOperator = @$filter["z_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchCondition = @$filter["v_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchValue2 = @$filter["y_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->SearchOperator2 = @$filter["w_DIHAPUS"];
        $this->DIHAPUS->AdvancedSearch->save();

        // Field DIMINTA
        $this->DIMINTA->AdvancedSearch->SearchValue = @$filter["x_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchOperator = @$filter["z_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchCondition = @$filter["v_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchValue2 = @$filter["y_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->SearchOperator2 = @$filter["w_DIMINTA"];
        $this->DIMINTA->AdvancedSearch->save();

        // Field DIRETUR
        $this->DIRETUR->AdvancedSearch->SearchValue = @$filter["x_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchOperator = @$filter["z_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchCondition = @$filter["v_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchValue2 = @$filter["y_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->SearchOperator2 = @$filter["w_DIRETUR"];
        $this->DIRETUR->AdvancedSearch->save();

        // Field PO
        $this->PO->AdvancedSearch->SearchValue = @$filter["x_PO"];
        $this->PO->AdvancedSearch->SearchOperator = @$filter["z_PO"];
        $this->PO->AdvancedSearch->SearchCondition = @$filter["v_PO"];
        $this->PO->AdvancedSearch->SearchValue2 = @$filter["y_PO"];
        $this->PO->AdvancedSearch->SearchOperator2 = @$filter["w_PO"];
        $this->PO->AdvancedSearch->save();

        // Field COMPANY_ID
        $this->COMPANY_ID->AdvancedSearch->SearchValue = @$filter["x_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator = @$filter["z_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchCondition = @$filter["v_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchValue2 = @$filter["y_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->SearchOperator2 = @$filter["w_COMPANY_ID"];
        $this->COMPANY_ID->AdvancedSearch->save();

        // Field FUND_ID
        $this->FUND_ID->AdvancedSearch->SearchValue = @$filter["x_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchOperator = @$filter["z_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchCondition = @$filter["v_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchValue2 = @$filter["y_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->SearchOperator2 = @$filter["w_FUND_ID"];
        $this->FUND_ID->AdvancedSearch->save();

        // Field INVOICE_ID2
        $this->INVOICE_ID2->AdvancedSearch->SearchValue = @$filter["x_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchOperator = @$filter["z_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchCondition = @$filter["v_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_INVOICE_ID2"];
        $this->INVOICE_ID2->AdvancedSearch->save();

        // Field MEASURE_ID3
        $this->MEASURE_ID3->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID3"];
        $this->MEASURE_ID3->AdvancedSearch->save();

        // Field SIZE_KEMASAN
        $this->SIZE_KEMASAN->AdvancedSearch->SearchValue = @$filter["x_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchOperator = @$filter["z_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchCondition = @$filter["v_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchValue2 = @$filter["y_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->SearchOperator2 = @$filter["w_SIZE_KEMASAN"];
        $this->SIZE_KEMASAN->AdvancedSearch->save();

        // Field BRAND_NAME
        $this->BRAND_NAME->AdvancedSearch->SearchValue = @$filter["x_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchOperator = @$filter["z_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchCondition = @$filter["v_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchValue2 = @$filter["y_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->SearchOperator2 = @$filter["w_BRAND_NAME"];
        $this->BRAND_NAME->AdvancedSearch->save();

        // Field MEASURE_ID2
        $this->MEASURE_ID2->AdvancedSearch->SearchValue = @$filter["x_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator = @$filter["z_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchCondition = @$filter["v_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchValue2 = @$filter["y_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->SearchOperator2 = @$filter["w_MEASURE_ID2"];
        $this->MEASURE_ID2->AdvancedSearch->save();

        // Field RETUR_ID
        $this->RETUR_ID->AdvancedSearch->SearchValue = @$filter["x_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchOperator = @$filter["z_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchCondition = @$filter["v_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchValue2 = @$filter["y_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_RETUR_ID"];
        $this->RETUR_ID->AdvancedSearch->save();

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

        // Field ORDER_PRICE
        $this->ORDER_PRICE->AdvancedSearch->SearchValue = @$filter["x_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchOperator = @$filter["z_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchCondition = @$filter["v_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchValue2 = @$filter["y_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->SearchOperator2 = @$filter["w_ORDER_PRICE"];
        $this->ORDER_PRICE->AdvancedSearch->save();

        // Field STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue = @$filter["x_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchOperator = @$filter["z_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchCondition = @$filter["v_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchValue2 = @$filter["y_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->SearchOperator2 = @$filter["w_STOCK_AVAILABLE"];
        $this->STOCK_AVAILABLE->AdvancedSearch->save();

        // Field STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue = @$filter["x_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator = @$filter["z_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchCondition = @$filter["v_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchValue2 = @$filter["y_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_STATUS_PASIEN_ID"];
        $this->STATUS_PASIEN_ID->AdvancedSearch->save();

        // Field MONTH_ID
        $this->MONTH_ID->AdvancedSearch->SearchValue = @$filter["x_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchOperator = @$filter["z_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchCondition = @$filter["v_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchValue2 = @$filter["y_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->SearchOperator2 = @$filter["w_MONTH_ID"];
        $this->MONTH_ID->AdvancedSearch->save();

        // Field YEAR_ID
        $this->YEAR_ID->AdvancedSearch->SearchValue = @$filter["x_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchOperator = @$filter["z_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchCondition = @$filter["v_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchValue2 = @$filter["y_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->SearchOperator2 = @$filter["w_YEAR_ID"];
        $this->YEAR_ID->AdvancedSearch->save();

        // Field CORRECTION_DOC
        $this->CORRECTION_DOC->AdvancedSearch->SearchValue = @$filter["x_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchOperator = @$filter["z_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchCondition = @$filter["v_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTION_DOC"];
        $this->CORRECTION_DOC->AdvancedSearch->save();

        // Field CORRECTIONS
        $this->CORRECTIONS->AdvancedSearch->SearchValue = @$filter["x_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchOperator = @$filter["z_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchCondition = @$filter["v_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTIONS"];
        $this->CORRECTIONS->AdvancedSearch->save();

        // Field CORRECTION_DATE
        $this->CORRECTION_DATE->AdvancedSearch->SearchValue = @$filter["x_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchOperator = @$filter["z_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchCondition = @$filter["v_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchValue2 = @$filter["y_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->SearchOperator2 = @$filter["w_CORRECTION_DATE"];
        $this->CORRECTION_DATE->AdvancedSearch->save();

        // Field DOC_NO
        $this->DOC_NO->AdvancedSearch->SearchValue = @$filter["x_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchOperator = @$filter["z_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchCondition = @$filter["v_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchValue2 = @$filter["y_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->SearchOperator2 = @$filter["w_DOC_NO"];
        $this->DOC_NO->AdvancedSearch->save();

        // Field ORDER_ID
        $this->ORDER_ID->AdvancedSearch->SearchValue = @$filter["x_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchOperator = @$filter["z_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchCondition = @$filter["v_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchValue2 = @$filter["y_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->SearchOperator2 = @$filter["w_ORDER_ID"];
        $this->ORDER_ID->AdvancedSearch->save();

        // Field ISCETAK
        $this->ISCETAK->AdvancedSearch->SearchValue = @$filter["x_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator = @$filter["z_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchCondition = @$filter["v_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchValue2 = @$filter["y_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->SearchOperator2 = @$filter["w_ISCETAK"];
        $this->ISCETAK->AdvancedSearch->save();

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

        // Field PRINTQ
        $this->PRINTQ->AdvancedSearch->SearchValue = @$filter["x_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator = @$filter["z_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchCondition = @$filter["v_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchValue2 = @$filter["y_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->SearchOperator2 = @$filter["w_PRINTQ"];
        $this->PRINTQ->AdvancedSearch->save();

        // Field avgprice
        $this->avgprice->AdvancedSearch->SearchValue = @$filter["x_avgprice"];
        $this->avgprice->AdvancedSearch->SearchOperator = @$filter["z_avgprice"];
        $this->avgprice->AdvancedSearch->SearchCondition = @$filter["v_avgprice"];
        $this->avgprice->AdvancedSearch->SearchValue2 = @$filter["y_avgprice"];
        $this->avgprice->AdvancedSearch->SearchOperator2 = @$filter["w_avgprice"];
        $this->avgprice->AdvancedSearch->save();

        // Field idx
        $this->idx->AdvancedSearch->SearchValue = @$filter["x_idx"];
        $this->idx->AdvancedSearch->SearchOperator = @$filter["z_idx"];
        $this->idx->AdvancedSearch->SearchCondition = @$filter["v_idx"];
        $this->idx->AdvancedSearch->SearchValue2 = @$filter["y_idx"];
        $this->idx->AdvancedSearch->SearchOperator2 = @$filter["w_idx"];
        $this->idx->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_CODE, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BATCH_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BRAND_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ROOMS_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->SERIAL_NB, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->FROM_ROOMS_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISOUTLET, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ALLOCATED_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORG_UNIT_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ITEM_ID_FROM, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->MODIFIED_BY, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->COMPANY_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->INVOICE_ID2, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->BRAND_NAME, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->RETUR_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CORRECTION_DOC, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->CORRECTIONS, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->DOC_NO, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ORDER_ID, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ISCETAK, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->PRINTED_BY, $arKeywords, $type);
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
            $this->updateSort($this->ORG_ID); // ORG_ID
            $this->updateSort($this->BRAND_ID); // BRAND_ID
            $this->updateSort($this->ROOMS_ID); // ROOMS_ID
            $this->updateSort($this->FROM_ROOMS_ID); // FROM_ROOMS_ID
            $this->updateSort($this->ISOUTLET); // ISOUTLET
            $this->updateSort($this->QUANTITY); // QUANTITY
            $this->updateSort($this->MEASURE_ID); // MEASURE_ID
            $this->updateSort($this->DISTRIBUTION_TYPE); // DISTRIBUTION_TYPE
            $this->updateSort($this->CONDITION); // CONDITION
            $this->updateSort($this->ALLOCATED_DATE); // ALLOCATED_DATE
            $this->updateSort($this->STOCKOPNAME_DATE); // STOCKOPNAME_DATE
            $this->updateSort($this->ORG_UNIT_FROM); // ORG_UNIT_FROM
            $this->updateSort($this->ITEM_ID_FROM); // ITEM_ID_FROM
            $this->updateSort($this->MODIFIED_DATE); // MODIFIED_DATE
            $this->updateSort($this->MODIFIED_BY); // MODIFIED_BY
            $this->updateSort($this->STOCK_OPNAME); // STOCK_OPNAME
            $this->updateSort($this->STOK_AWAL); // STOK_AWAL
            $this->updateSort($this->STOCK_KOREKSI); // STOCK_KOREKSI
            $this->updateSort($this->BRAND_NAME); // BRAND_NAME
            $this->updateSort($this->MONTH_ID); // MONTH_ID
            $this->updateSort($this->YEAR_ID); // YEAR_ID
            $this->updateSort($this->DOC_NO); // DOC_NO
            $this->updateSort($this->ORDER_ID); // ORDER_ID
            $this->updateSort($this->ISCETAK); // ISCETAK
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

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->ROOMS_ID->setSessionValue("");
                        $this->ORG_ID->setSessionValue("");
                        $this->FROM_ROOMS_ID->setSessionValue("");
                        $this->DOC_NO->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->ORG_UNIT_CODE->setSort("");
                $this->ITEM_ID->setSort("");
                $this->ORG_ID->setSort("");
                $this->BATCH_NO->setSort("");
                $this->BRAND_ID->setSort("");
                $this->ROOMS_ID->setSort("");
                $this->SHELF_NO->setSort("");
                $this->EXPIRY_DATE->setSort("");
                $this->SERIAL_NB->setSort("");
                $this->FROM_ROOMS_ID->setSort("");
                $this->ISOUTLET->setSort("");
                $this->QUANTITY->setSort("");
                $this->MEASURE_ID->setSort("");
                $this->DISTRIBUTION_TYPE->setSort("");
                $this->CONDITION->setSort("");
                $this->ALLOCATED_DATE->setSort("");
                $this->STOCKOPNAME_DATE->setSort("");
                $this->INVOICE_ID->setSort("");
                $this->ALLOCATED_FROM->setSort("");
                $this->PRICE->setSort("");
                $this->DISCOUNT->setSort("");
                $this->DISCOUNT2->setSort("");
                $this->DISCOUNTOFF->setSort("");
                $this->ORG_UNIT_FROM->setSort("");
                $this->ITEM_ID_FROM->setSort("");
                $this->MODIFIED_DATE->setSort("");
                $this->MODIFIED_BY->setSort("");
                $this->STOCK_OPNAME->setSort("");
                $this->STOK_AWAL->setSort("");
                $this->STOCK_LALU->setSort("");
                $this->STOCK_KOREKSI->setSort("");
                $this->DITERIMA->setSort("");
                $this->DISTRIBUSI->setSort("");
                $this->DIJUAL->setSort("");
                $this->DIHAPUS->setSort("");
                $this->DIMINTA->setSort("");
                $this->DIRETUR->setSort("");
                $this->PO->setSort("");
                $this->COMPANY_ID->setSort("");
                $this->FUND_ID->setSort("");
                $this->INVOICE_ID2->setSort("");
                $this->MEASURE_ID3->setSort("");
                $this->SIZE_KEMASAN->setSort("");
                $this->BRAND_NAME->setSort("");
                $this->MEASURE_ID2->setSort("");
                $this->RETUR_ID->setSort("");
                $this->SIZE_GOODS->setSort("");
                $this->MEASURE_DOSIS->setSort("");
                $this->ORDER_PRICE->setSort("");
                $this->STOCK_AVAILABLE->setSort("");
                $this->STATUS_PASIEN_ID->setSort("");
                $this->MONTH_ID->setSort("");
                $this->YEAR_ID->setSort("");
                $this->CORRECTION_DOC->setSort("");
                $this->CORRECTIONS->setSort("");
                $this->CORRECTION_DATE->setSort("");
                $this->DOC_NO->setSort("");
                $this->ORDER_ID->setSort("");
                $this->ISCETAK->setSort("");
                $this->PRINT_DATE->setSort("");
                $this->PRINTED_BY->setSort("");
                $this->PRINTQ->setSort("");
                $this->avgprice->setSort("");
                $this->idx->setSort("");
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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }
        $pageUrl = $this->pageUrl();

        // "edit"
        $opt = $this->ListOptions["edit"];
        if ($this->isInlineEditRow()) { // Inline-Edit
            $this->ListOptions->CustomItem = "edit"; // Show edit column only
            $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $opt->Body = "<div" . (($opt->OnLeft) ? " class=\"text-right\"" : "") . ">" .
                "<a class=\"ew-grid-link ew-inline-update\" title=\"" . HtmlTitle($Language->phrase("UpdateLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("UpdateLink")) . "\" href=\"#\" onclick=\"ew.forms.get(this).submit(event, '" . UrlAddHash($this->pageName(), "r" . $this->RowCount . "_" . $this->TableVar) . "'); return false;\">" . $Language->phrase("UpdateLink") . "</a>&nbsp;" .
                "<a class=\"ew-grid-link ew-inline-cancel\" title=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("CancelLink") . "</a>" .
                "<input type=\"hidden\" name=\"action\" id=\"action\" value=\"update\"></div>";
            $opt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . HtmlEncode($this->idx->CurrentValue) . "\">";
            return;
        }
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
                $opt->Body .= "<a class=\"ew-row-link ew-inline-edit\" title=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" href=\"" . HtmlEncode(UrlAddHash(GetUrl($this->InlineEditUrl), "r" . $this->RowCount . "_" . $this->TableVar)) . "\">" . $Language->phrase("InlineEditLink") . "</a>";
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
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->idx->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fGOOD_GFlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fGOOD_GFlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fGOOD_GFlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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

    // Load default values
    protected function loadDefaultValues()
    {
        $this->ORG_UNIT_CODE->CurrentValue = "1604031";
        $this->ITEM_ID->CurrentValue = null;
        $this->ITEM_ID->OldValue = $this->ITEM_ID->CurrentValue;
        $this->ORG_ID->CurrentValue = null;
        $this->ORG_ID->OldValue = $this->ORG_ID->CurrentValue;
        $this->BATCH_NO->CurrentValue = null;
        $this->BATCH_NO->OldValue = $this->BATCH_NO->CurrentValue;
        $this->BRAND_ID->CurrentValue = null;
        $this->BRAND_ID->OldValue = $this->BRAND_ID->CurrentValue;
        $this->ROOMS_ID->CurrentValue = null;
        $this->ROOMS_ID->OldValue = $this->ROOMS_ID->CurrentValue;
        $this->SHELF_NO->CurrentValue = null;
        $this->SHELF_NO->OldValue = $this->SHELF_NO->CurrentValue;
        $this->EXPIRY_DATE->CurrentValue = null;
        $this->EXPIRY_DATE->OldValue = $this->EXPIRY_DATE->CurrentValue;
        $this->SERIAL_NB->CurrentValue = null;
        $this->SERIAL_NB->OldValue = $this->SERIAL_NB->CurrentValue;
        $this->FROM_ROOMS_ID->CurrentValue = null;
        $this->FROM_ROOMS_ID->OldValue = $this->FROM_ROOMS_ID->CurrentValue;
        $this->ISOUTLET->CurrentValue = null;
        $this->ISOUTLET->OldValue = $this->ISOUTLET->CurrentValue;
        $this->QUANTITY->CurrentValue = null;
        $this->QUANTITY->OldValue = $this->QUANTITY->CurrentValue;
        $this->MEASURE_ID->CurrentValue = null;
        $this->MEASURE_ID->OldValue = $this->MEASURE_ID->CurrentValue;
        $this->DISTRIBUTION_TYPE->CurrentValue = null;
        $this->DISTRIBUTION_TYPE->OldValue = $this->DISTRIBUTION_TYPE->CurrentValue;
        $this->CONDITION->CurrentValue = null;
        $this->CONDITION->OldValue = $this->CONDITION->CurrentValue;
        $this->ALLOCATED_DATE->CurrentValue = null;
        $this->ALLOCATED_DATE->OldValue = $this->ALLOCATED_DATE->CurrentValue;
        $this->STOCKOPNAME_DATE->CurrentValue = null;
        $this->STOCKOPNAME_DATE->OldValue = $this->STOCKOPNAME_DATE->CurrentValue;
        $this->INVOICE_ID->CurrentValue = null;
        $this->INVOICE_ID->OldValue = $this->INVOICE_ID->CurrentValue;
        $this->ALLOCATED_FROM->CurrentValue = null;
        $this->ALLOCATED_FROM->OldValue = $this->ALLOCATED_FROM->CurrentValue;
        $this->PRICE->CurrentValue = null;
        $this->PRICE->OldValue = $this->PRICE->CurrentValue;
        $this->DISCOUNT->CurrentValue = null;
        $this->DISCOUNT->OldValue = $this->DISCOUNT->CurrentValue;
        $this->DISCOUNT2->CurrentValue = null;
        $this->DISCOUNT2->OldValue = $this->DISCOUNT2->CurrentValue;
        $this->DISCOUNTOFF->CurrentValue = null;
        $this->DISCOUNTOFF->OldValue = $this->DISCOUNTOFF->CurrentValue;
        $this->ORG_UNIT_FROM->CurrentValue = null;
        $this->ORG_UNIT_FROM->OldValue = $this->ORG_UNIT_FROM->CurrentValue;
        $this->ITEM_ID_FROM->CurrentValue = null;
        $this->ITEM_ID_FROM->OldValue = $this->ITEM_ID_FROM->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->STOCK_OPNAME->CurrentValue = null;
        $this->STOCK_OPNAME->OldValue = $this->STOCK_OPNAME->CurrentValue;
        $this->STOK_AWAL->CurrentValue = null;
        $this->STOK_AWAL->OldValue = $this->STOK_AWAL->CurrentValue;
        $this->STOCK_LALU->CurrentValue = null;
        $this->STOCK_LALU->OldValue = $this->STOCK_LALU->CurrentValue;
        $this->STOCK_KOREKSI->CurrentValue = null;
        $this->STOCK_KOREKSI->OldValue = $this->STOCK_KOREKSI->CurrentValue;
        $this->DITERIMA->CurrentValue = null;
        $this->DITERIMA->OldValue = $this->DITERIMA->CurrentValue;
        $this->DISTRIBUSI->CurrentValue = null;
        $this->DISTRIBUSI->OldValue = $this->DISTRIBUSI->CurrentValue;
        $this->DIJUAL->CurrentValue = null;
        $this->DIJUAL->OldValue = $this->DIJUAL->CurrentValue;
        $this->DIHAPUS->CurrentValue = null;
        $this->DIHAPUS->OldValue = $this->DIHAPUS->CurrentValue;
        $this->DIMINTA->CurrentValue = null;
        $this->DIMINTA->OldValue = $this->DIMINTA->CurrentValue;
        $this->DIRETUR->CurrentValue = null;
        $this->DIRETUR->OldValue = $this->DIRETUR->CurrentValue;
        $this->PO->CurrentValue = null;
        $this->PO->OldValue = $this->PO->CurrentValue;
        $this->COMPANY_ID->CurrentValue = null;
        $this->COMPANY_ID->OldValue = $this->COMPANY_ID->CurrentValue;
        $this->FUND_ID->CurrentValue = null;
        $this->FUND_ID->OldValue = $this->FUND_ID->CurrentValue;
        $this->INVOICE_ID2->CurrentValue = null;
        $this->INVOICE_ID2->OldValue = $this->INVOICE_ID2->CurrentValue;
        $this->MEASURE_ID3->CurrentValue = null;
        $this->MEASURE_ID3->OldValue = $this->MEASURE_ID3->CurrentValue;
        $this->SIZE_KEMASAN->CurrentValue = null;
        $this->SIZE_KEMASAN->OldValue = $this->SIZE_KEMASAN->CurrentValue;
        $this->BRAND_NAME->CurrentValue = null;
        $this->BRAND_NAME->OldValue = $this->BRAND_NAME->CurrentValue;
        $this->MEASURE_ID2->CurrentValue = null;
        $this->MEASURE_ID2->OldValue = $this->MEASURE_ID2->CurrentValue;
        $this->RETUR_ID->CurrentValue = null;
        $this->RETUR_ID->OldValue = $this->RETUR_ID->CurrentValue;
        $this->SIZE_GOODS->CurrentValue = null;
        $this->SIZE_GOODS->OldValue = $this->SIZE_GOODS->CurrentValue;
        $this->MEASURE_DOSIS->CurrentValue = null;
        $this->MEASURE_DOSIS->OldValue = $this->MEASURE_DOSIS->CurrentValue;
        $this->ORDER_PRICE->CurrentValue = null;
        $this->ORDER_PRICE->OldValue = $this->ORDER_PRICE->CurrentValue;
        $this->STOCK_AVAILABLE->CurrentValue = null;
        $this->STOCK_AVAILABLE->OldValue = $this->STOCK_AVAILABLE->CurrentValue;
        $this->STATUS_PASIEN_ID->CurrentValue = null;
        $this->STATUS_PASIEN_ID->OldValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->MONTH_ID->CurrentValue = null;
        $this->MONTH_ID->OldValue = $this->MONTH_ID->CurrentValue;
        $this->YEAR_ID->CurrentValue = null;
        $this->YEAR_ID->OldValue = $this->YEAR_ID->CurrentValue;
        $this->CORRECTION_DOC->CurrentValue = null;
        $this->CORRECTION_DOC->OldValue = $this->CORRECTION_DOC->CurrentValue;
        $this->CORRECTIONS->CurrentValue = null;
        $this->CORRECTIONS->OldValue = $this->CORRECTIONS->CurrentValue;
        $this->CORRECTION_DATE->CurrentValue = null;
        $this->CORRECTION_DATE->OldValue = $this->CORRECTION_DATE->CurrentValue;
        $this->DOC_NO->CurrentValue = null;
        $this->DOC_NO->OldValue = $this->DOC_NO->CurrentValue;
        $this->ORDER_ID->CurrentValue = null;
        $this->ORDER_ID->OldValue = $this->ORDER_ID->CurrentValue;
        $this->ISCETAK->CurrentValue = null;
        $this->ISCETAK->OldValue = $this->ISCETAK->CurrentValue;
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->PRINTED_BY->CurrentValue = null;
        $this->PRINTED_BY->OldValue = $this->PRINTED_BY->CurrentValue;
        $this->PRINTQ->CurrentValue = null;
        $this->PRINTQ->OldValue = $this->PRINTQ->CurrentValue;
        $this->avgprice->CurrentValue = null;
        $this->avgprice->OldValue = $this->avgprice->CurrentValue;
        $this->idx->CurrentValue = null;
        $this->idx->OldValue = $this->idx->CurrentValue;
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

        // Check field name 'ORG_ID' first before field var 'x_ORG_ID'
        $val = $CurrentForm->hasValue("ORG_ID") ? $CurrentForm->getValue("ORG_ID") : $CurrentForm->getValue("x_ORG_ID");
        if (!$this->ORG_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_ID->Visible = false; // Disable update for API request
            } else {
                $this->ORG_ID->setFormValue($val);
            }
        }

        // Check field name 'BRAND_ID' first before field var 'x_BRAND_ID'
        $val = $CurrentForm->hasValue("BRAND_ID") ? $CurrentForm->getValue("BRAND_ID") : $CurrentForm->getValue("x_BRAND_ID");
        if (!$this->BRAND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_ID->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_ID->setFormValue($val);
            }
        }

        // Check field name 'ROOMS_ID' first before field var 'x_ROOMS_ID'
        $val = $CurrentForm->hasValue("ROOMS_ID") ? $CurrentForm->getValue("ROOMS_ID") : $CurrentForm->getValue("x_ROOMS_ID");
        if (!$this->ROOMS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ROOMS_ID->Visible = false; // Disable update for API request
            } else {
                $this->ROOMS_ID->setFormValue($val);
            }
        }

        // Check field name 'FROM_ROOMS_ID' first before field var 'x_FROM_ROOMS_ID'
        $val = $CurrentForm->hasValue("FROM_ROOMS_ID") ? $CurrentForm->getValue("FROM_ROOMS_ID") : $CurrentForm->getValue("x_FROM_ROOMS_ID");
        if (!$this->FROM_ROOMS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FROM_ROOMS_ID->Visible = false; // Disable update for API request
            } else {
                $this->FROM_ROOMS_ID->setFormValue($val);
            }
        }

        // Check field name 'ISOUTLET' first before field var 'x_ISOUTLET'
        $val = $CurrentForm->hasValue("ISOUTLET") ? $CurrentForm->getValue("ISOUTLET") : $CurrentForm->getValue("x_ISOUTLET");
        if (!$this->ISOUTLET->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISOUTLET->Visible = false; // Disable update for API request
            } else {
                $this->ISOUTLET->setFormValue($val);
            }
        }

        // Check field name 'QUANTITY' first before field var 'x_QUANTITY'
        $val = $CurrentForm->hasValue("QUANTITY") ? $CurrentForm->getValue("QUANTITY") : $CurrentForm->getValue("x_QUANTITY");
        if (!$this->QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->QUANTITY->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID' first before field var 'x_MEASURE_ID'
        $val = $CurrentForm->hasValue("MEASURE_ID") ? $CurrentForm->getValue("MEASURE_ID") : $CurrentForm->getValue("x_MEASURE_ID");
        if (!$this->MEASURE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID->setFormValue($val);
            }
        }

        // Check field name 'DISTRIBUTION_TYPE' first before field var 'x_DISTRIBUTION_TYPE'
        $val = $CurrentForm->hasValue("DISTRIBUTION_TYPE") ? $CurrentForm->getValue("DISTRIBUTION_TYPE") : $CurrentForm->getValue("x_DISTRIBUTION_TYPE");
        if (!$this->DISTRIBUTION_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISTRIBUTION_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->DISTRIBUTION_TYPE->setFormValue($val);
            }
        }

        // Check field name 'CONDITION' first before field var 'x_CONDITION'
        $val = $CurrentForm->hasValue("CONDITION") ? $CurrentForm->getValue("CONDITION") : $CurrentForm->getValue("x_CONDITION");
        if (!$this->CONDITION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CONDITION->Visible = false; // Disable update for API request
            } else {
                $this->CONDITION->setFormValue($val);
            }
        }

        // Check field name 'ALLOCATED_DATE' first before field var 'x_ALLOCATED_DATE'
        $val = $CurrentForm->hasValue("ALLOCATED_DATE") ? $CurrentForm->getValue("ALLOCATED_DATE") : $CurrentForm->getValue("x_ALLOCATED_DATE");
        if (!$this->ALLOCATED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ALLOCATED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ALLOCATED_DATE->setFormValue($val);
            }
            $this->ALLOCATED_DATE->CurrentValue = UnFormatDateTime($this->ALLOCATED_DATE->CurrentValue, 0);
        }

        // Check field name 'STOCKOPNAME_DATE' first before field var 'x_STOCKOPNAME_DATE'
        $val = $CurrentForm->hasValue("STOCKOPNAME_DATE") ? $CurrentForm->getValue("STOCKOPNAME_DATE") : $CurrentForm->getValue("x_STOCKOPNAME_DATE");
        if (!$this->STOCKOPNAME_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCKOPNAME_DATE->Visible = false; // Disable update for API request
            } else {
                $this->STOCKOPNAME_DATE->setFormValue($val);
            }
            $this->STOCKOPNAME_DATE->CurrentValue = UnFormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 0);
        }

        // Check field name 'ORG_UNIT_FROM' first before field var 'x_ORG_UNIT_FROM'
        $val = $CurrentForm->hasValue("ORG_UNIT_FROM") ? $CurrentForm->getValue("ORG_UNIT_FROM") : $CurrentForm->getValue("x_ORG_UNIT_FROM");
        if (!$this->ORG_UNIT_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_UNIT_FROM->Visible = false; // Disable update for API request
            } else {
                $this->ORG_UNIT_FROM->setFormValue($val);
            }
        }

        // Check field name 'ITEM_ID_FROM' first before field var 'x_ITEM_ID_FROM'
        $val = $CurrentForm->hasValue("ITEM_ID_FROM") ? $CurrentForm->getValue("ITEM_ID_FROM") : $CurrentForm->getValue("x_ITEM_ID_FROM");
        if (!$this->ITEM_ID_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ITEM_ID_FROM->Visible = false; // Disable update for API request
            } else {
                $this->ITEM_ID_FROM->setFormValue($val);
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

        // Check field name 'MODIFIED_BY' first before field var 'x_MODIFIED_BY'
        $val = $CurrentForm->hasValue("MODIFIED_BY") ? $CurrentForm->getValue("MODIFIED_BY") : $CurrentForm->getValue("x_MODIFIED_BY");
        if (!$this->MODIFIED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_BY->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_BY->setFormValue($val);
            }
        }

        // Check field name 'STOCK_OPNAME' first before field var 'x_STOCK_OPNAME'
        $val = $CurrentForm->hasValue("STOCK_OPNAME") ? $CurrentForm->getValue("STOCK_OPNAME") : $CurrentForm->getValue("x_STOCK_OPNAME");
        if (!$this->STOCK_OPNAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_OPNAME->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_OPNAME->setFormValue($val);
            }
        }

        // Check field name 'STOK_AWAL' first before field var 'x_STOK_AWAL'
        $val = $CurrentForm->hasValue("STOK_AWAL") ? $CurrentForm->getValue("STOK_AWAL") : $CurrentForm->getValue("x_STOK_AWAL");
        if (!$this->STOK_AWAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOK_AWAL->Visible = false; // Disable update for API request
            } else {
                $this->STOK_AWAL->setFormValue($val);
            }
        }

        // Check field name 'STOCK_KOREKSI' first before field var 'x_STOCK_KOREKSI'
        $val = $CurrentForm->hasValue("STOCK_KOREKSI") ? $CurrentForm->getValue("STOCK_KOREKSI") : $CurrentForm->getValue("x_STOCK_KOREKSI");
        if (!$this->STOCK_KOREKSI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_KOREKSI->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_KOREKSI->setFormValue($val);
            }
        }

        // Check field name 'BRAND_NAME' first before field var 'x_BRAND_NAME'
        $val = $CurrentForm->hasValue("BRAND_NAME") ? $CurrentForm->getValue("BRAND_NAME") : $CurrentForm->getValue("x_BRAND_NAME");
        if (!$this->BRAND_NAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_NAME->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_NAME->setFormValue($val);
            }
        }

        // Check field name 'MONTH_ID' first before field var 'x_MONTH_ID'
        $val = $CurrentForm->hasValue("MONTH_ID") ? $CurrentForm->getValue("MONTH_ID") : $CurrentForm->getValue("x_MONTH_ID");
        if (!$this->MONTH_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MONTH_ID->Visible = false; // Disable update for API request
            } else {
                $this->MONTH_ID->setFormValue($val);
            }
        }

        // Check field name 'YEAR_ID' first before field var 'x_YEAR_ID'
        $val = $CurrentForm->hasValue("YEAR_ID") ? $CurrentForm->getValue("YEAR_ID") : $CurrentForm->getValue("x_YEAR_ID");
        if (!$this->YEAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->YEAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->YEAR_ID->setFormValue($val);
            }
        }

        // Check field name 'DOC_NO' first before field var 'x_DOC_NO'
        $val = $CurrentForm->hasValue("DOC_NO") ? $CurrentForm->getValue("DOC_NO") : $CurrentForm->getValue("x_DOC_NO");
        if (!$this->DOC_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOC_NO->Visible = false; // Disable update for API request
            } else {
                $this->DOC_NO->setFormValue($val);
            }
        }

        // Check field name 'ORDER_ID' first before field var 'x_ORDER_ID'
        $val = $CurrentForm->hasValue("ORDER_ID") ? $CurrentForm->getValue("ORDER_ID") : $CurrentForm->getValue("x_ORDER_ID");
        if (!$this->ORDER_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_ID->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_ID->setFormValue($val);
            }
        }

        // Check field name 'ISCETAK' first before field var 'x_ISCETAK'
        $val = $CurrentForm->hasValue("ISCETAK") ? $CurrentForm->getValue("ISCETAK") : $CurrentForm->getValue("x_ISCETAK");
        if (!$this->ISCETAK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISCETAK->Visible = false; // Disable update for API request
            } else {
                $this->ISCETAK->setFormValue($val);
            }
        }

        // Check field name 'idx' first before field var 'x_idx'
        $val = $CurrentForm->hasValue("idx") ? $CurrentForm->getValue("idx") : $CurrentForm->getValue("x_idx");
        if (!$this->idx->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->idx->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->idx->CurrentValue = $this->idx->FormValue;
        }
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->ORG_ID->CurrentValue = $this->ORG_ID->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->ROOMS_ID->CurrentValue = $this->ROOMS_ID->FormValue;
        $this->FROM_ROOMS_ID->CurrentValue = $this->FROM_ROOMS_ID->FormValue;
        $this->ISOUTLET->CurrentValue = $this->ISOUTLET->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->DISTRIBUTION_TYPE->CurrentValue = $this->DISTRIBUTION_TYPE->FormValue;
        $this->CONDITION->CurrentValue = $this->CONDITION->FormValue;
        $this->ALLOCATED_DATE->CurrentValue = $this->ALLOCATED_DATE->FormValue;
        $this->ALLOCATED_DATE->CurrentValue = UnFormatDateTime($this->ALLOCATED_DATE->CurrentValue, 0);
        $this->STOCKOPNAME_DATE->CurrentValue = $this->STOCKOPNAME_DATE->FormValue;
        $this->STOCKOPNAME_DATE->CurrentValue = UnFormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 0);
        $this->ORG_UNIT_FROM->CurrentValue = $this->ORG_UNIT_FROM->FormValue;
        $this->ITEM_ID_FROM->CurrentValue = $this->ITEM_ID_FROM->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->STOCK_OPNAME->CurrentValue = $this->STOCK_OPNAME->FormValue;
        $this->STOK_AWAL->CurrentValue = $this->STOK_AWAL->FormValue;
        $this->STOCK_KOREKSI->CurrentValue = $this->STOCK_KOREKSI->FormValue;
        $this->BRAND_NAME->CurrentValue = $this->BRAND_NAME->FormValue;
        $this->MONTH_ID->CurrentValue = $this->MONTH_ID->FormValue;
        $this->YEAR_ID->CurrentValue = $this->YEAR_ID->FormValue;
        $this->DOC_NO->CurrentValue = $this->DOC_NO->FormValue;
        $this->ORDER_ID->CurrentValue = $this->ORDER_ID->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
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
        $this->ITEM_ID->setDbValue($row['ITEM_ID']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->BATCH_NO->setDbValue($row['BATCH_NO']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->ROOMS_ID->setDbValue($row['ROOMS_ID']);
        $this->SHELF_NO->setDbValue($row['SHELF_NO']);
        $this->EXPIRY_DATE->setDbValue($row['EXPIRY_DATE']);
        $this->SERIAL_NB->setDbValue($row['SERIAL_NB']);
        $this->FROM_ROOMS_ID->setDbValue($row['FROM_ROOMS_ID']);
        $this->ISOUTLET->setDbValue($row['ISOUTLET']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->DISTRIBUTION_TYPE->setDbValue($row['DISTRIBUTION_TYPE']);
        $this->CONDITION->setDbValue($row['CONDITION']);
        $this->ALLOCATED_DATE->setDbValue($row['ALLOCATED_DATE']);
        $this->STOCKOPNAME_DATE->setDbValue($row['STOCKOPNAME_DATE']);
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->ALLOCATED_FROM->setDbValue($row['ALLOCATED_FROM']);
        $this->PRICE->setDbValue($row['PRICE']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->DISCOUNT2->setDbValue($row['DISCOUNT2']);
        $this->DISCOUNTOFF->setDbValue($row['DISCOUNTOFF']);
        $this->ORG_UNIT_FROM->setDbValue($row['ORG_UNIT_FROM']);
        $this->ITEM_ID_FROM->setDbValue($row['ITEM_ID_FROM']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->STOCK_OPNAME->setDbValue($row['STOCK_OPNAME']);
        $this->STOK_AWAL->setDbValue($row['STOK_AWAL']);
        $this->STOCK_LALU->setDbValue($row['STOCK_LALU']);
        $this->STOCK_KOREKSI->setDbValue($row['STOCK_KOREKSI']);
        $this->DITERIMA->setDbValue($row['DITERIMA']);
        $this->DISTRIBUSI->setDbValue($row['DISTRIBUSI']);
        $this->DIJUAL->setDbValue($row['DIJUAL']);
        $this->DIHAPUS->setDbValue($row['DIHAPUS']);
        $this->DIMINTA->setDbValue($row['DIMINTA']);
        $this->DIRETUR->setDbValue($row['DIRETUR']);
        $this->PO->setDbValue($row['PO']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->FUND_ID->setDbValue($row['FUND_ID']);
        $this->INVOICE_ID2->setDbValue($row['INVOICE_ID2']);
        $this->MEASURE_ID3->setDbValue($row['MEASURE_ID3']);
        $this->SIZE_KEMASAN->setDbValue($row['SIZE_KEMASAN']);
        $this->BRAND_NAME->setDbValue($row['BRAND_NAME']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->RETUR_ID->setDbValue($row['RETUR_ID']);
        $this->SIZE_GOODS->setDbValue($row['SIZE_GOODS']);
        $this->MEASURE_DOSIS->setDbValue($row['MEASURE_DOSIS']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->STOCK_AVAILABLE->setDbValue($row['STOCK_AVAILABLE']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->MONTH_ID->setDbValue($row['MONTH_ID']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->CORRECTION_DOC->setDbValue($row['CORRECTION_DOC']);
        $this->CORRECTIONS->setDbValue($row['CORRECTIONS']);
        $this->CORRECTION_DATE->setDbValue($row['CORRECTION_DATE']);
        $this->DOC_NO->setDbValue($row['DOC_NO']);
        $this->ORDER_ID->setDbValue($row['ORDER_ID']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->avgprice->setDbValue($row['avgprice']);
        $this->idx->setDbValue($row['idx']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['ITEM_ID'] = $this->ITEM_ID->CurrentValue;
        $row['ORG_ID'] = $this->ORG_ID->CurrentValue;
        $row['BATCH_NO'] = $this->BATCH_NO->CurrentValue;
        $row['BRAND_ID'] = $this->BRAND_ID->CurrentValue;
        $row['ROOMS_ID'] = $this->ROOMS_ID->CurrentValue;
        $row['SHELF_NO'] = $this->SHELF_NO->CurrentValue;
        $row['EXPIRY_DATE'] = $this->EXPIRY_DATE->CurrentValue;
        $row['SERIAL_NB'] = $this->SERIAL_NB->CurrentValue;
        $row['FROM_ROOMS_ID'] = $this->FROM_ROOMS_ID->CurrentValue;
        $row['ISOUTLET'] = $this->ISOUTLET->CurrentValue;
        $row['QUANTITY'] = $this->QUANTITY->CurrentValue;
        $row['MEASURE_ID'] = $this->MEASURE_ID->CurrentValue;
        $row['DISTRIBUTION_TYPE'] = $this->DISTRIBUTION_TYPE->CurrentValue;
        $row['CONDITION'] = $this->CONDITION->CurrentValue;
        $row['ALLOCATED_DATE'] = $this->ALLOCATED_DATE->CurrentValue;
        $row['STOCKOPNAME_DATE'] = $this->STOCKOPNAME_DATE->CurrentValue;
        $row['INVOICE_ID'] = $this->INVOICE_ID->CurrentValue;
        $row['ALLOCATED_FROM'] = $this->ALLOCATED_FROM->CurrentValue;
        $row['PRICE'] = $this->PRICE->CurrentValue;
        $row['DISCOUNT'] = $this->DISCOUNT->CurrentValue;
        $row['DISCOUNT2'] = $this->DISCOUNT2->CurrentValue;
        $row['DISCOUNTOFF'] = $this->DISCOUNTOFF->CurrentValue;
        $row['ORG_UNIT_FROM'] = $this->ORG_UNIT_FROM->CurrentValue;
        $row['ITEM_ID_FROM'] = $this->ITEM_ID_FROM->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['STOCK_OPNAME'] = $this->STOCK_OPNAME->CurrentValue;
        $row['STOK_AWAL'] = $this->STOK_AWAL->CurrentValue;
        $row['STOCK_LALU'] = $this->STOCK_LALU->CurrentValue;
        $row['STOCK_KOREKSI'] = $this->STOCK_KOREKSI->CurrentValue;
        $row['DITERIMA'] = $this->DITERIMA->CurrentValue;
        $row['DISTRIBUSI'] = $this->DISTRIBUSI->CurrentValue;
        $row['DIJUAL'] = $this->DIJUAL->CurrentValue;
        $row['DIHAPUS'] = $this->DIHAPUS->CurrentValue;
        $row['DIMINTA'] = $this->DIMINTA->CurrentValue;
        $row['DIRETUR'] = $this->DIRETUR->CurrentValue;
        $row['PO'] = $this->PO->CurrentValue;
        $row['COMPANY_ID'] = $this->COMPANY_ID->CurrentValue;
        $row['FUND_ID'] = $this->FUND_ID->CurrentValue;
        $row['INVOICE_ID2'] = $this->INVOICE_ID2->CurrentValue;
        $row['MEASURE_ID3'] = $this->MEASURE_ID3->CurrentValue;
        $row['SIZE_KEMASAN'] = $this->SIZE_KEMASAN->CurrentValue;
        $row['BRAND_NAME'] = $this->BRAND_NAME->CurrentValue;
        $row['MEASURE_ID2'] = $this->MEASURE_ID2->CurrentValue;
        $row['RETUR_ID'] = $this->RETUR_ID->CurrentValue;
        $row['SIZE_GOODS'] = $this->SIZE_GOODS->CurrentValue;
        $row['MEASURE_DOSIS'] = $this->MEASURE_DOSIS->CurrentValue;
        $row['ORDER_PRICE'] = $this->ORDER_PRICE->CurrentValue;
        $row['STOCK_AVAILABLE'] = $this->STOCK_AVAILABLE->CurrentValue;
        $row['STATUS_PASIEN_ID'] = $this->STATUS_PASIEN_ID->CurrentValue;
        $row['MONTH_ID'] = $this->MONTH_ID->CurrentValue;
        $row['YEAR_ID'] = $this->YEAR_ID->CurrentValue;
        $row['CORRECTION_DOC'] = $this->CORRECTION_DOC->CurrentValue;
        $row['CORRECTIONS'] = $this->CORRECTIONS->CurrentValue;
        $row['CORRECTION_DATE'] = $this->CORRECTION_DATE->CurrentValue;
        $row['DOC_NO'] = $this->DOC_NO->CurrentValue;
        $row['ORDER_ID'] = $this->ORDER_ID->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['PRINTED_BY'] = $this->PRINTED_BY->CurrentValue;
        $row['PRINTQ'] = $this->PRINTQ->CurrentValue;
        $row['avgprice'] = $this->avgprice->CurrentValue;
        $row['idx'] = $this->idx->CurrentValue;
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
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_OPNAME->FormValue == $this->STOCK_OPNAME->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_OPNAME->CurrentValue))) {
            $this->STOCK_OPNAME->CurrentValue = ConvertToFloatString($this->STOCK_OPNAME->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOK_AWAL->FormValue == $this->STOK_AWAL->CurrentValue && is_numeric(ConvertToFloatString($this->STOK_AWAL->CurrentValue))) {
            $this->STOK_AWAL->CurrentValue = ConvertToFloatString($this->STOK_AWAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_KOREKSI->FormValue == $this->STOCK_KOREKSI->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue))) {
            $this->STOCK_KOREKSI->CurrentValue = ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // ITEM_ID
        $this->ITEM_ID->CellCssStyle = "white-space: nowrap;";

        // ORG_ID

        // BATCH_NO

        // BRAND_ID

        // ROOMS_ID

        // SHELF_NO

        // EXPIRY_DATE

        // SERIAL_NB

        // FROM_ROOMS_ID

        // ISOUTLET

        // QUANTITY

        // MEASURE_ID

        // DISTRIBUTION_TYPE

        // CONDITION

        // ALLOCATED_DATE

        // STOCKOPNAME_DATE

        // INVOICE_ID

        // ALLOCATED_FROM

        // PRICE

        // DISCOUNT

        // DISCOUNT2

        // DISCOUNTOFF

        // ORG_UNIT_FROM

        // ITEM_ID_FROM

        // MODIFIED_DATE

        // MODIFIED_BY

        // STOCK_OPNAME

        // STOK_AWAL

        // STOCK_LALU

        // STOCK_KOREKSI

        // DITERIMA

        // DISTRIBUSI

        // DIJUAL

        // DIHAPUS

        // DIMINTA

        // DIRETUR

        // PO

        // COMPANY_ID

        // FUND_ID

        // INVOICE_ID2

        // MEASURE_ID3

        // SIZE_KEMASAN

        // BRAND_NAME

        // MEASURE_ID2

        // RETUR_ID

        // SIZE_GOODS

        // MEASURE_DOSIS

        // ORDER_PRICE

        // STOCK_AVAILABLE

        // STATUS_PASIEN_ID

        // MONTH_ID

        // YEAR_ID

        // CORRECTION_DOC

        // CORRECTIONS

        // CORRECTION_DATE

        // DOC_NO

        // ORDER_ID

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // avgprice

        // idx
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = "";

            // BATCH_NO
            $this->BATCH_NO->ViewValue = $this->BATCH_NO->CurrentValue;
            $this->BATCH_NO->ViewCustomAttributes = "";

            // BRAND_ID
            $curVal = trim(strval($this->BRAND_ID->CurrentValue));
            if ($curVal != "") {
                $this->BRAND_ID->ViewValue = $this->BRAND_ID->lookupCacheOption($curVal);
                if ($this->BRAND_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[BRAND_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->BRAND_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->BRAND_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->BRAND_ID->ViewValue = $this->BRAND_ID->displayValue($arwrk);
                    } else {
                        $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
                    }
                }
            } else {
                $this->BRAND_ID->ViewValue = null;
            }
            $this->BRAND_ID->ViewCustomAttributes = "";

            // ROOMS_ID
            $this->ROOMS_ID->ViewValue = $this->ROOMS_ID->CurrentValue;
            $this->ROOMS_ID->ViewCustomAttributes = "";

            // SHELF_NO
            $this->SHELF_NO->ViewValue = $this->SHELF_NO->CurrentValue;
            $this->SHELF_NO->ViewValue = FormatNumber($this->SHELF_NO->ViewValue, 0, -2, -2, -2);
            $this->SHELF_NO->ViewCustomAttributes = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->ViewValue = $this->EXPIRY_DATE->CurrentValue;
            $this->EXPIRY_DATE->ViewValue = FormatDateTime($this->EXPIRY_DATE->ViewValue, 0);
            $this->EXPIRY_DATE->ViewCustomAttributes = "";

            // SERIAL_NB
            $this->SERIAL_NB->ViewValue = $this->SERIAL_NB->CurrentValue;
            $this->SERIAL_NB->ViewCustomAttributes = "";

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->ViewValue = $this->FROM_ROOMS_ID->CurrentValue;
            $this->FROM_ROOMS_ID->ViewCustomAttributes = "";

            // ISOUTLET
            $this->ISOUTLET->ViewValue = $this->ISOUTLET->CurrentValue;
            $this->ISOUTLET->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 2, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->CurrentValue;
            $this->DISTRIBUTION_TYPE->ViewValue = FormatNumber($this->DISTRIBUTION_TYPE->ViewValue, 0, -2, -2, -2);
            $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

            // CONDITION
            $this->CONDITION->ViewValue = $this->CONDITION->CurrentValue;
            $this->CONDITION->ViewValue = FormatNumber($this->CONDITION->ViewValue, 0, -2, -2, -2);
            $this->CONDITION->ViewCustomAttributes = "";

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->ViewValue = $this->ALLOCATED_DATE->CurrentValue;
            $this->ALLOCATED_DATE->ViewValue = FormatDateTime($this->ALLOCATED_DATE->ViewValue, 0);
            $this->ALLOCATED_DATE->ViewCustomAttributes = "";

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->ViewValue = $this->STOCKOPNAME_DATE->CurrentValue;
            $this->STOCKOPNAME_DATE->ViewValue = FormatDateTime($this->STOCKOPNAME_DATE->ViewValue, 0);
            $this->STOCKOPNAME_DATE->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->ViewValue = $this->ALLOCATED_FROM->CurrentValue;
            $this->ALLOCATED_FROM->ViewCustomAttributes = "";

            // PRICE
            $this->PRICE->ViewValue = $this->PRICE->CurrentValue;
            $this->PRICE->ViewValue = FormatNumber($this->PRICE->ViewValue, 2, -2, -2, -2);
            $this->PRICE->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // DISCOUNT2
            $this->DISCOUNT2->ViewValue = $this->DISCOUNT2->CurrentValue;
            $this->DISCOUNT2->ViewValue = FormatNumber($this->DISCOUNT2->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNT2->ViewCustomAttributes = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->ViewValue = $this->DISCOUNTOFF->CurrentValue;
            $this->DISCOUNTOFF->ViewValue = FormatNumber($this->DISCOUNTOFF->ViewValue, 2, -2, -2, -2);
            $this->DISCOUNTOFF->ViewCustomAttributes = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->ViewValue = $this->ORG_UNIT_FROM->CurrentValue;
            $this->ORG_UNIT_FROM->ViewCustomAttributes = "";

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->ViewValue = $this->ITEM_ID_FROM->CurrentValue;
            $this->ITEM_ID_FROM->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 11);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // STOCK_OPNAME
            $this->STOCK_OPNAME->ViewValue = $this->STOCK_OPNAME->CurrentValue;
            $this->STOCK_OPNAME->ViewValue = FormatNumber($this->STOCK_OPNAME->ViewValue, 2, -2, -2, -2);
            $this->STOCK_OPNAME->ViewCustomAttributes = "";

            // STOK_AWAL
            $this->STOK_AWAL->ViewValue = $this->STOK_AWAL->CurrentValue;
            $this->STOK_AWAL->ViewValue = FormatNumber($this->STOK_AWAL->ViewValue, 2, -2, -2, -2);
            $this->STOK_AWAL->ViewCustomAttributes = "";

            // STOCK_LALU
            $this->STOCK_LALU->ViewValue = $this->STOCK_LALU->CurrentValue;
            $this->STOCK_LALU->ViewValue = FormatNumber($this->STOCK_LALU->ViewValue, 2, -2, -2, -2);
            $this->STOCK_LALU->ViewCustomAttributes = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->ViewValue = $this->STOCK_KOREKSI->CurrentValue;
            $this->STOCK_KOREKSI->ViewValue = FormatNumber($this->STOCK_KOREKSI->ViewValue, 2, -2, -2, -2);
            $this->STOCK_KOREKSI->ViewCustomAttributes = "";

            // DITERIMA
            $this->DITERIMA->ViewValue = $this->DITERIMA->CurrentValue;
            $this->DITERIMA->ViewValue = FormatNumber($this->DITERIMA->ViewValue, 2, -2, -2, -2);
            $this->DITERIMA->ViewCustomAttributes = "";

            // DISTRIBUSI
            $this->DISTRIBUSI->ViewValue = $this->DISTRIBUSI->CurrentValue;
            $this->DISTRIBUSI->ViewValue = FormatNumber($this->DISTRIBUSI->ViewValue, 2, -2, -2, -2);
            $this->DISTRIBUSI->ViewCustomAttributes = "";

            // DIJUAL
            $this->DIJUAL->ViewValue = $this->DIJUAL->CurrentValue;
            $this->DIJUAL->ViewValue = FormatNumber($this->DIJUAL->ViewValue, 2, -2, -2, -2);
            $this->DIJUAL->ViewCustomAttributes = "";

            // DIHAPUS
            $this->DIHAPUS->ViewValue = $this->DIHAPUS->CurrentValue;
            $this->DIHAPUS->ViewValue = FormatNumber($this->DIHAPUS->ViewValue, 2, -2, -2, -2);
            $this->DIHAPUS->ViewCustomAttributes = "";

            // DIMINTA
            $this->DIMINTA->ViewValue = $this->DIMINTA->CurrentValue;
            $this->DIMINTA->ViewValue = FormatNumber($this->DIMINTA->ViewValue, 2, -2, -2, -2);
            $this->DIMINTA->ViewCustomAttributes = "";

            // DIRETUR
            $this->DIRETUR->ViewValue = $this->DIRETUR->CurrentValue;
            $this->DIRETUR->ViewValue = FormatNumber($this->DIRETUR->ViewValue, 2, -2, -2, -2);
            $this->DIRETUR->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // FUND_ID
            $this->FUND_ID->ViewValue = $this->FUND_ID->CurrentValue;
            $this->FUND_ID->ViewValue = FormatNumber($this->FUND_ID->ViewValue, 0, -2, -2, -2);
            $this->FUND_ID->ViewCustomAttributes = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->ViewValue = $this->INVOICE_ID2->CurrentValue;
            $this->INVOICE_ID2->ViewCustomAttributes = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->ViewValue = $this->MEASURE_ID3->CurrentValue;
            $this->MEASURE_ID3->ViewValue = FormatNumber($this->MEASURE_ID3->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID3->ViewCustomAttributes = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->ViewValue = $this->SIZE_KEMASAN->CurrentValue;
            $this->SIZE_KEMASAN->ViewValue = FormatNumber($this->SIZE_KEMASAN->ViewValue, 2, -2, -2, -2);
            $this->SIZE_KEMASAN->ViewCustomAttributes = "";

            // BRAND_NAME
            $this->BRAND_NAME->ViewValue = $this->BRAND_NAME->CurrentValue;
            $this->BRAND_NAME->ViewCustomAttributes = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
            $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID2->ViewCustomAttributes = "";

            // RETUR_ID
            $this->RETUR_ID->ViewValue = $this->RETUR_ID->CurrentValue;
            $this->RETUR_ID->ViewCustomAttributes = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->ViewValue = $this->SIZE_GOODS->CurrentValue;
            $this->SIZE_GOODS->ViewValue = FormatNumber($this->SIZE_GOODS->ViewValue, 2, -2, -2, -2);
            $this->SIZE_GOODS->ViewCustomAttributes = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->ViewValue = $this->MEASURE_DOSIS->CurrentValue;
            $this->MEASURE_DOSIS->ViewValue = FormatNumber($this->MEASURE_DOSIS->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_DOSIS->ViewCustomAttributes = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
            $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_PRICE->ViewCustomAttributes = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->ViewValue = $this->STOCK_AVAILABLE->CurrentValue;
            $this->STOCK_AVAILABLE->ViewValue = FormatNumber($this->STOCK_AVAILABLE->ViewValue, 2, -2, -2, -2);
            $this->STOCK_AVAILABLE->ViewCustomAttributes = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->ViewValue = $this->STATUS_PASIEN_ID->CurrentValue;
            $this->STATUS_PASIEN_ID->ViewValue = FormatNumber($this->STATUS_PASIEN_ID->ViewValue, 0, -2, -2, -2);
            $this->STATUS_PASIEN_ID->ViewCustomAttributes = "";

            // MONTH_ID
            $this->MONTH_ID->ViewValue = $this->MONTH_ID->CurrentValue;
            $this->MONTH_ID->ViewValue = FormatNumber($this->MONTH_ID->ViewValue, 0, -2, -2, -2);
            $this->MONTH_ID->ViewCustomAttributes = "";

            // YEAR_ID
            $this->YEAR_ID->ViewValue = $this->YEAR_ID->CurrentValue;
            $this->YEAR_ID->ViewValue = FormatNumber($this->YEAR_ID->ViewValue, 0, -2, -2, -2);
            $this->YEAR_ID->ViewCustomAttributes = "";

            // CORRECTION_DOC
            $this->CORRECTION_DOC->ViewValue = $this->CORRECTION_DOC->CurrentValue;
            $this->CORRECTION_DOC->ViewCustomAttributes = "";

            // CORRECTIONS
            $this->CORRECTIONS->ViewValue = $this->CORRECTIONS->CurrentValue;
            $this->CORRECTIONS->ViewCustomAttributes = "";

            // CORRECTION_DATE
            $this->CORRECTION_DATE->ViewValue = $this->CORRECTION_DATE->CurrentValue;
            $this->CORRECTION_DATE->ViewValue = FormatDateTime($this->CORRECTION_DATE->ViewValue, 11);
            $this->CORRECTION_DATE->ViewCustomAttributes = "";

            // DOC_NO
            $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
            $this->DOC_NO->ViewCustomAttributes = "";

            // ORDER_ID
            $this->ORDER_ID->ViewValue = $this->ORDER_ID->CurrentValue;
            $this->ORDER_ID->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // PRINTED_BY
            $this->PRINTED_BY->ViewValue = $this->PRINTED_BY->CurrentValue;
            $this->PRINTED_BY->ViewCustomAttributes = "";

            // PRINTQ
            $this->PRINTQ->ViewValue = $this->PRINTQ->CurrentValue;
            $this->PRINTQ->ViewValue = FormatNumber($this->PRINTQ->ViewValue, 0, -2, -2, -2);
            $this->PRINTQ->ViewCustomAttributes = "";

            // avgprice
            $this->avgprice->ViewValue = $this->avgprice->CurrentValue;
            $this->avgprice->ViewValue = FormatNumber($this->avgprice->ViewValue, 2, -2, -2, -2);
            $this->avgprice->ViewCustomAttributes = "";

            // idx
            $this->idx->ViewValue = $this->idx->CurrentValue;
            $this->idx->ViewValue = FormatNumber($this->idx->ViewValue, 0, -2, -2, -2);
            $this->idx->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";
            $this->ORG_ID->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";
            $this->ROOMS_ID->TooltipValue = "";

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->LinkCustomAttributes = "";
            $this->FROM_ROOMS_ID->HrefValue = "";
            $this->FROM_ROOMS_ID->TooltipValue = "";

            // ISOUTLET
            $this->ISOUTLET->LinkCustomAttributes = "";
            $this->ISOUTLET->HrefValue = "";
            $this->ISOUTLET->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";
            $this->DISTRIBUTION_TYPE->TooltipValue = "";

            // CONDITION
            $this->CONDITION->LinkCustomAttributes = "";
            $this->CONDITION->HrefValue = "";
            $this->CONDITION->TooltipValue = "";

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->LinkCustomAttributes = "";
            $this->ALLOCATED_DATE->HrefValue = "";
            $this->ALLOCATED_DATE->TooltipValue = "";

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->LinkCustomAttributes = "";
            $this->STOCKOPNAME_DATE->HrefValue = "";
            $this->STOCKOPNAME_DATE->TooltipValue = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->LinkCustomAttributes = "";
            $this->ORG_UNIT_FROM->HrefValue = "";
            $this->ORG_UNIT_FROM->TooltipValue = "";

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->LinkCustomAttributes = "";
            $this->ITEM_ID_FROM->HrefValue = "";
            $this->ITEM_ID_FROM->TooltipValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";
            $this->MODIFIED_DATE->TooltipValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";
            $this->MODIFIED_BY->TooltipValue = "";

            // STOCK_OPNAME
            $this->STOCK_OPNAME->LinkCustomAttributes = "";
            $this->STOCK_OPNAME->HrefValue = "";
            $this->STOCK_OPNAME->TooltipValue = "";

            // STOK_AWAL
            $this->STOK_AWAL->LinkCustomAttributes = "";
            $this->STOK_AWAL->HrefValue = "";
            $this->STOK_AWAL->TooltipValue = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";
            $this->STOCK_KOREKSI->TooltipValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";
            $this->BRAND_NAME->TooltipValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";
            $this->MONTH_ID->TooltipValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";
            $this->YEAR_ID->TooltipValue = "";

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";
            $this->DOC_NO->TooltipValue = "";

            // ORDER_ID
            $this->ORDER_ID->LinkCustomAttributes = "";
            $this->ORDER_ID->HrefValue = "";
            $this->ORDER_ID->TooltipValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            $this->ORG_UNIT_CODE->CurrentValue = "1604031";

            // ORG_ID
            $this->ORG_ID->EditAttrs["class"] = "form-control";
            $this->ORG_ID->EditCustomAttributes = "";
            if ($this->ORG_ID->getSessionValue() != "") {
                $this->ORG_ID->CurrentValue = GetForeignKeyValue($this->ORG_ID->getSessionValue());
                $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
                $this->ORG_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->ORG_ID->Raw) {
                    $this->ORG_ID->CurrentValue = HtmlDecode($this->ORG_ID->CurrentValue);
                }
                $this->ORG_ID->EditValue = HtmlEncode($this->ORG_ID->CurrentValue);
                $this->ORG_ID->PlaceHolder = RemoveHtml($this->ORG_ID->caption());
            }

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // ROOMS_ID
            $this->ROOMS_ID->EditAttrs["class"] = "form-control";
            $this->ROOMS_ID->EditCustomAttributes = "";
            if ($this->ROOMS_ID->getSessionValue() != "") {
                $this->ROOMS_ID->CurrentValue = GetForeignKeyValue($this->ROOMS_ID->getSessionValue());
                $this->ROOMS_ID->ViewValue = $this->ROOMS_ID->CurrentValue;
                $this->ROOMS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->ROOMS_ID->Raw) {
                    $this->ROOMS_ID->CurrentValue = HtmlDecode($this->ROOMS_ID->CurrentValue);
                }
                $this->ROOMS_ID->EditValue = HtmlEncode($this->ROOMS_ID->CurrentValue);
                $this->ROOMS_ID->PlaceHolder = RemoveHtml($this->ROOMS_ID->caption());
            }

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->EditAttrs["class"] = "form-control";
            $this->FROM_ROOMS_ID->EditCustomAttributes = "";
            if ($this->FROM_ROOMS_ID->getSessionValue() != "") {
                $this->FROM_ROOMS_ID->CurrentValue = GetForeignKeyValue($this->FROM_ROOMS_ID->getSessionValue());
                $this->FROM_ROOMS_ID->ViewValue = $this->FROM_ROOMS_ID->CurrentValue;
                $this->FROM_ROOMS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->FROM_ROOMS_ID->Raw) {
                    $this->FROM_ROOMS_ID->CurrentValue = HtmlDecode($this->FROM_ROOMS_ID->CurrentValue);
                }
                $this->FROM_ROOMS_ID->EditValue = HtmlEncode($this->FROM_ROOMS_ID->CurrentValue);
                $this->FROM_ROOMS_ID->PlaceHolder = RemoveHtml($this->FROM_ROOMS_ID->caption());
            }

            // ISOUTLET
            $this->ISOUTLET->EditAttrs["class"] = "form-control";
            $this->ISOUTLET->EditCustomAttributes = "";
            if (!$this->ISOUTLET->Raw) {
                $this->ISOUTLET->CurrentValue = HtmlDecode($this->ISOUTLET->CurrentValue);
            }
            $this->ISOUTLET->EditValue = HtmlEncode($this->ISOUTLET->CurrentValue);
            $this->ISOUTLET->PlaceHolder = RemoveHtml($this->ISOUTLET->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->EditAttrs["class"] = "form-control";
            $this->DISTRIBUTION_TYPE->EditCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->EditValue = HtmlEncode($this->DISTRIBUTION_TYPE->CurrentValue);
            $this->DISTRIBUTION_TYPE->PlaceHolder = RemoveHtml($this->DISTRIBUTION_TYPE->caption());

            // CONDITION
            $this->CONDITION->EditAttrs["class"] = "form-control";
            $this->CONDITION->EditCustomAttributes = "";
            $this->CONDITION->EditValue = HtmlEncode($this->CONDITION->CurrentValue);
            $this->CONDITION->PlaceHolder = RemoveHtml($this->CONDITION->caption());

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->EditAttrs["class"] = "form-control";
            $this->ALLOCATED_DATE->EditCustomAttributes = "";
            $this->ALLOCATED_DATE->EditValue = HtmlEncode(FormatDateTime($this->ALLOCATED_DATE->CurrentValue, 8));
            $this->ALLOCATED_DATE->PlaceHolder = RemoveHtml($this->ALLOCATED_DATE->caption());

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->EditAttrs["class"] = "form-control";
            $this->STOCKOPNAME_DATE->EditCustomAttributes = "";
            $this->STOCKOPNAME_DATE->EditValue = HtmlEncode(FormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 8));
            $this->STOCKOPNAME_DATE->PlaceHolder = RemoveHtml($this->STOCKOPNAME_DATE->caption());

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_FROM->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_FROM->Raw) {
                $this->ORG_UNIT_FROM->CurrentValue = HtmlDecode($this->ORG_UNIT_FROM->CurrentValue);
            }
            $this->ORG_UNIT_FROM->EditValue = HtmlEncode($this->ORG_UNIT_FROM->CurrentValue);
            $this->ORG_UNIT_FROM->PlaceHolder = RemoveHtml($this->ORG_UNIT_FROM->caption());

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->EditAttrs["class"] = "form-control";
            $this->ITEM_ID_FROM->EditCustomAttributes = "";
            if (!$this->ITEM_ID_FROM->Raw) {
                $this->ITEM_ID_FROM->CurrentValue = HtmlDecode($this->ITEM_ID_FROM->CurrentValue);
            }
            $this->ITEM_ID_FROM->EditValue = HtmlEncode($this->ITEM_ID_FROM->CurrentValue);
            $this->ITEM_ID_FROM->PlaceHolder = RemoveHtml($this->ITEM_ID_FROM->caption());

            // MODIFIED_DATE

            // MODIFIED_BY

            // STOCK_OPNAME
            $this->STOCK_OPNAME->EditAttrs["class"] = "form-control";
            $this->STOCK_OPNAME->EditCustomAttributes = "";
            $this->STOCK_OPNAME->EditValue = HtmlEncode($this->STOCK_OPNAME->CurrentValue);
            $this->STOCK_OPNAME->PlaceHolder = RemoveHtml($this->STOCK_OPNAME->caption());
            if (strval($this->STOCK_OPNAME->EditValue) != "" && is_numeric($this->STOCK_OPNAME->EditValue)) {
                $this->STOCK_OPNAME->EditValue = FormatNumber($this->STOCK_OPNAME->EditValue, -2, -2, -2, -2);
            }

            // STOK_AWAL
            $this->STOK_AWAL->EditAttrs["class"] = "form-control";
            $this->STOK_AWAL->EditCustomAttributes = "";
            $this->STOK_AWAL->EditValue = HtmlEncode($this->STOK_AWAL->CurrentValue);
            $this->STOK_AWAL->PlaceHolder = RemoveHtml($this->STOK_AWAL->caption());
            if (strval($this->STOK_AWAL->EditValue) != "" && is_numeric($this->STOK_AWAL->EditValue)) {
                $this->STOK_AWAL->EditValue = FormatNumber($this->STOK_AWAL->EditValue, -2, -2, -2, -2);
            }

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->EditAttrs["class"] = "form-control";
            $this->STOCK_KOREKSI->EditCustomAttributes = "";
            $this->STOCK_KOREKSI->EditValue = HtmlEncode($this->STOCK_KOREKSI->CurrentValue);
            $this->STOCK_KOREKSI->PlaceHolder = RemoveHtml($this->STOCK_KOREKSI->caption());
            if (strval($this->STOCK_KOREKSI->EditValue) != "" && is_numeric($this->STOCK_KOREKSI->EditValue)) {
                $this->STOCK_KOREKSI->EditValue = FormatNumber($this->STOCK_KOREKSI->EditValue, -2, -2, -2, -2);
            }

            // BRAND_NAME
            $this->BRAND_NAME->EditAttrs["class"] = "form-control";
            $this->BRAND_NAME->EditCustomAttributes = "";
            if (!$this->BRAND_NAME->Raw) {
                $this->BRAND_NAME->CurrentValue = HtmlDecode($this->BRAND_NAME->CurrentValue);
            }
            $this->BRAND_NAME->EditValue = HtmlEncode($this->BRAND_NAME->CurrentValue);
            $this->BRAND_NAME->PlaceHolder = RemoveHtml($this->BRAND_NAME->caption());

            // MONTH_ID
            $this->MONTH_ID->EditAttrs["class"] = "form-control";
            $this->MONTH_ID->EditCustomAttributes = "";
            $this->MONTH_ID->EditValue = HtmlEncode($this->MONTH_ID->CurrentValue);
            $this->MONTH_ID->PlaceHolder = RemoveHtml($this->MONTH_ID->caption());

            // YEAR_ID
            $this->YEAR_ID->EditAttrs["class"] = "form-control";
            $this->YEAR_ID->EditCustomAttributes = "";
            $this->YEAR_ID->EditValue = HtmlEncode($this->YEAR_ID->CurrentValue);
            $this->YEAR_ID->PlaceHolder = RemoveHtml($this->YEAR_ID->caption());

            // DOC_NO
            $this->DOC_NO->EditAttrs["class"] = "form-control";
            $this->DOC_NO->EditCustomAttributes = "";
            if ($this->DOC_NO->getSessionValue() != "") {
                $this->DOC_NO->CurrentValue = GetForeignKeyValue($this->DOC_NO->getSessionValue());
                $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
                $this->DOC_NO->ViewCustomAttributes = "";
            } else {
                if (!$this->DOC_NO->Raw) {
                    $this->DOC_NO->CurrentValue = HtmlDecode($this->DOC_NO->CurrentValue);
                }
                $this->DOC_NO->EditValue = HtmlEncode($this->DOC_NO->CurrentValue);
                $this->DOC_NO->PlaceHolder = RemoveHtml($this->DOC_NO->caption());
            }

            // ORDER_ID
            $this->ORDER_ID->EditAttrs["class"] = "form-control";
            $this->ORDER_ID->EditCustomAttributes = "";
            if (!$this->ORDER_ID->Raw) {
                $this->ORDER_ID->CurrentValue = HtmlDecode($this->ORDER_ID->CurrentValue);
            }
            $this->ORDER_ID->EditValue = HtmlEncode($this->ORDER_ID->CurrentValue);
            $this->ORDER_ID->PlaceHolder = RemoveHtml($this->ORDER_ID->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->LinkCustomAttributes = "";
            $this->FROM_ROOMS_ID->HrefValue = "";

            // ISOUTLET
            $this->ISOUTLET->LinkCustomAttributes = "";
            $this->ISOUTLET->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";

            // CONDITION
            $this->CONDITION->LinkCustomAttributes = "";
            $this->CONDITION->HrefValue = "";

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->LinkCustomAttributes = "";
            $this->ALLOCATED_DATE->HrefValue = "";

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->LinkCustomAttributes = "";
            $this->STOCKOPNAME_DATE->HrefValue = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->LinkCustomAttributes = "";
            $this->ORG_UNIT_FROM->HrefValue = "";

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->LinkCustomAttributes = "";
            $this->ITEM_ID_FROM->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // STOCK_OPNAME
            $this->STOCK_OPNAME->LinkCustomAttributes = "";
            $this->STOCK_OPNAME->HrefValue = "";

            // STOK_AWAL
            $this->STOK_AWAL->LinkCustomAttributes = "";
            $this->STOK_AWAL->HrefValue = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";

            // ORDER_ID
            $this->ORDER_ID->LinkCustomAttributes = "";
            $this->ORDER_ID->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->EditAttrs["class"] = "form-control";
            $this->ORG_ID->EditCustomAttributes = "";
            if ($this->ORG_ID->getSessionValue() != "") {
                $this->ORG_ID->CurrentValue = GetForeignKeyValue($this->ORG_ID->getSessionValue());
                $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
                $this->ORG_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->ORG_ID->Raw) {
                    $this->ORG_ID->CurrentValue = HtmlDecode($this->ORG_ID->CurrentValue);
                }
                $this->ORG_ID->EditValue = HtmlEncode($this->ORG_ID->CurrentValue);
                $this->ORG_ID->PlaceHolder = RemoveHtml($this->ORG_ID->caption());
            }

            // BRAND_ID
            $this->BRAND_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->BRAND_ID->CurrentValue));
            if ($curVal != "") {
                $this->BRAND_ID->ViewValue = $this->BRAND_ID->lookupCacheOption($curVal);
            } else {
                $this->BRAND_ID->ViewValue = $this->BRAND_ID->Lookup !== null && is_array($this->BRAND_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->BRAND_ID->ViewValue !== null) { // Load from cache
                $this->BRAND_ID->EditValue = array_values($this->BRAND_ID->Lookup->Options);
                if ($this->BRAND_ID->ViewValue == "") {
                    $this->BRAND_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[BRAND_ID]" . SearchString("=", $this->BRAND_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->BRAND_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->BRAND_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->BRAND_ID->ViewValue = $this->BRAND_ID->displayValue($arwrk);
                } else {
                    $this->BRAND_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->BRAND_ID->Lookup->renderViewRow($row);
                $this->BRAND_ID->EditValue = $arwrk;
            }
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // ROOMS_ID
            $this->ROOMS_ID->EditAttrs["class"] = "form-control";
            $this->ROOMS_ID->EditCustomAttributes = "";
            if ($this->ROOMS_ID->getSessionValue() != "") {
                $this->ROOMS_ID->CurrentValue = GetForeignKeyValue($this->ROOMS_ID->getSessionValue());
                $this->ROOMS_ID->ViewValue = $this->ROOMS_ID->CurrentValue;
                $this->ROOMS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->ROOMS_ID->Raw) {
                    $this->ROOMS_ID->CurrentValue = HtmlDecode($this->ROOMS_ID->CurrentValue);
                }
                $this->ROOMS_ID->EditValue = HtmlEncode($this->ROOMS_ID->CurrentValue);
                $this->ROOMS_ID->PlaceHolder = RemoveHtml($this->ROOMS_ID->caption());
            }

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->EditAttrs["class"] = "form-control";
            $this->FROM_ROOMS_ID->EditCustomAttributes = "";
            if ($this->FROM_ROOMS_ID->getSessionValue() != "") {
                $this->FROM_ROOMS_ID->CurrentValue = GetForeignKeyValue($this->FROM_ROOMS_ID->getSessionValue());
                $this->FROM_ROOMS_ID->ViewValue = $this->FROM_ROOMS_ID->CurrentValue;
                $this->FROM_ROOMS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->FROM_ROOMS_ID->Raw) {
                    $this->FROM_ROOMS_ID->CurrentValue = HtmlDecode($this->FROM_ROOMS_ID->CurrentValue);
                }
                $this->FROM_ROOMS_ID->EditValue = HtmlEncode($this->FROM_ROOMS_ID->CurrentValue);
                $this->FROM_ROOMS_ID->PlaceHolder = RemoveHtml($this->FROM_ROOMS_ID->caption());
            }

            // ISOUTLET
            $this->ISOUTLET->EditAttrs["class"] = "form-control";
            $this->ISOUTLET->EditCustomAttributes = "";
            if (!$this->ISOUTLET->Raw) {
                $this->ISOUTLET->CurrentValue = HtmlDecode($this->ISOUTLET->CurrentValue);
            }
            $this->ISOUTLET->EditValue = HtmlEncode($this->ISOUTLET->CurrentValue);
            $this->ISOUTLET->PlaceHolder = RemoveHtml($this->ISOUTLET->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->EditAttrs["class"] = "form-control";
            $this->DISTRIBUTION_TYPE->EditCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->EditValue = HtmlEncode($this->DISTRIBUTION_TYPE->CurrentValue);
            $this->DISTRIBUTION_TYPE->PlaceHolder = RemoveHtml($this->DISTRIBUTION_TYPE->caption());

            // CONDITION
            $this->CONDITION->EditAttrs["class"] = "form-control";
            $this->CONDITION->EditCustomAttributes = "";
            $this->CONDITION->EditValue = HtmlEncode($this->CONDITION->CurrentValue);
            $this->CONDITION->PlaceHolder = RemoveHtml($this->CONDITION->caption());

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->EditAttrs["class"] = "form-control";
            $this->ALLOCATED_DATE->EditCustomAttributes = "";
            $this->ALLOCATED_DATE->EditValue = HtmlEncode(FormatDateTime($this->ALLOCATED_DATE->CurrentValue, 8));
            $this->ALLOCATED_DATE->PlaceHolder = RemoveHtml($this->ALLOCATED_DATE->caption());

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->EditAttrs["class"] = "form-control";
            $this->STOCKOPNAME_DATE->EditCustomAttributes = "";
            $this->STOCKOPNAME_DATE->EditValue = HtmlEncode(FormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 8));
            $this->STOCKOPNAME_DATE->PlaceHolder = RemoveHtml($this->STOCKOPNAME_DATE->caption());

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_FROM->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_FROM->Raw) {
                $this->ORG_UNIT_FROM->CurrentValue = HtmlDecode($this->ORG_UNIT_FROM->CurrentValue);
            }
            $this->ORG_UNIT_FROM->EditValue = HtmlEncode($this->ORG_UNIT_FROM->CurrentValue);
            $this->ORG_UNIT_FROM->PlaceHolder = RemoveHtml($this->ORG_UNIT_FROM->caption());

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->EditAttrs["class"] = "form-control";
            $this->ITEM_ID_FROM->EditCustomAttributes = "";
            if (!$this->ITEM_ID_FROM->Raw) {
                $this->ITEM_ID_FROM->CurrentValue = HtmlDecode($this->ITEM_ID_FROM->CurrentValue);
            }
            $this->ITEM_ID_FROM->EditValue = HtmlEncode($this->ITEM_ID_FROM->CurrentValue);
            $this->ITEM_ID_FROM->PlaceHolder = RemoveHtml($this->ITEM_ID_FROM->caption());

            // MODIFIED_DATE

            // MODIFIED_BY

            // STOCK_OPNAME
            $this->STOCK_OPNAME->EditAttrs["class"] = "form-control";
            $this->STOCK_OPNAME->EditCustomAttributes = "";
            $this->STOCK_OPNAME->EditValue = HtmlEncode($this->STOCK_OPNAME->CurrentValue);
            $this->STOCK_OPNAME->PlaceHolder = RemoveHtml($this->STOCK_OPNAME->caption());
            if (strval($this->STOCK_OPNAME->EditValue) != "" && is_numeric($this->STOCK_OPNAME->EditValue)) {
                $this->STOCK_OPNAME->EditValue = FormatNumber($this->STOCK_OPNAME->EditValue, -2, -2, -2, -2);
            }

            // STOK_AWAL
            $this->STOK_AWAL->EditAttrs["class"] = "form-control";
            $this->STOK_AWAL->EditCustomAttributes = "";
            $this->STOK_AWAL->EditValue = HtmlEncode($this->STOK_AWAL->CurrentValue);
            $this->STOK_AWAL->PlaceHolder = RemoveHtml($this->STOK_AWAL->caption());
            if (strval($this->STOK_AWAL->EditValue) != "" && is_numeric($this->STOK_AWAL->EditValue)) {
                $this->STOK_AWAL->EditValue = FormatNumber($this->STOK_AWAL->EditValue, -2, -2, -2, -2);
            }

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->EditAttrs["class"] = "form-control";
            $this->STOCK_KOREKSI->EditCustomAttributes = "";
            $this->STOCK_KOREKSI->EditValue = HtmlEncode($this->STOCK_KOREKSI->CurrentValue);
            $this->STOCK_KOREKSI->PlaceHolder = RemoveHtml($this->STOCK_KOREKSI->caption());
            if (strval($this->STOCK_KOREKSI->EditValue) != "" && is_numeric($this->STOCK_KOREKSI->EditValue)) {
                $this->STOCK_KOREKSI->EditValue = FormatNumber($this->STOCK_KOREKSI->EditValue, -2, -2, -2, -2);
            }

            // BRAND_NAME
            $this->BRAND_NAME->EditAttrs["class"] = "form-control";
            $this->BRAND_NAME->EditCustomAttributes = "";
            if (!$this->BRAND_NAME->Raw) {
                $this->BRAND_NAME->CurrentValue = HtmlDecode($this->BRAND_NAME->CurrentValue);
            }
            $this->BRAND_NAME->EditValue = HtmlEncode($this->BRAND_NAME->CurrentValue);
            $this->BRAND_NAME->PlaceHolder = RemoveHtml($this->BRAND_NAME->caption());

            // MONTH_ID
            $this->MONTH_ID->EditAttrs["class"] = "form-control";
            $this->MONTH_ID->EditCustomAttributes = "";
            $this->MONTH_ID->EditValue = HtmlEncode($this->MONTH_ID->CurrentValue);
            $this->MONTH_ID->PlaceHolder = RemoveHtml($this->MONTH_ID->caption());

            // YEAR_ID
            $this->YEAR_ID->EditAttrs["class"] = "form-control";
            $this->YEAR_ID->EditCustomAttributes = "";
            $this->YEAR_ID->EditValue = HtmlEncode($this->YEAR_ID->CurrentValue);
            $this->YEAR_ID->PlaceHolder = RemoveHtml($this->YEAR_ID->caption());

            // DOC_NO
            $this->DOC_NO->EditAttrs["class"] = "form-control";
            $this->DOC_NO->EditCustomAttributes = "";
            if ($this->DOC_NO->getSessionValue() != "") {
                $this->DOC_NO->CurrentValue = GetForeignKeyValue($this->DOC_NO->getSessionValue());
                $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
                $this->DOC_NO->ViewCustomAttributes = "";
            } else {
                if (!$this->DOC_NO->Raw) {
                    $this->DOC_NO->CurrentValue = HtmlDecode($this->DOC_NO->CurrentValue);
                }
                $this->DOC_NO->EditValue = HtmlEncode($this->DOC_NO->CurrentValue);
                $this->DOC_NO->PlaceHolder = RemoveHtml($this->DOC_NO->caption());
            }

            // ORDER_ID
            $this->ORDER_ID->EditAttrs["class"] = "form-control";
            $this->ORDER_ID->EditCustomAttributes = "";
            if (!$this->ORDER_ID->Raw) {
                $this->ORDER_ID->CurrentValue = HtmlDecode($this->ORDER_ID->CurrentValue);
            }
            $this->ORDER_ID->EditValue = HtmlEncode($this->ORDER_ID->CurrentValue);
            $this->ORDER_ID->PlaceHolder = RemoveHtml($this->ORDER_ID->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // Edit refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";

            // FROM_ROOMS_ID
            $this->FROM_ROOMS_ID->LinkCustomAttributes = "";
            $this->FROM_ROOMS_ID->HrefValue = "";

            // ISOUTLET
            $this->ISOUTLET->LinkCustomAttributes = "";
            $this->ISOUTLET->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";

            // CONDITION
            $this->CONDITION->LinkCustomAttributes = "";
            $this->CONDITION->HrefValue = "";

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->LinkCustomAttributes = "";
            $this->ALLOCATED_DATE->HrefValue = "";

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->LinkCustomAttributes = "";
            $this->STOCKOPNAME_DATE->HrefValue = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->LinkCustomAttributes = "";
            $this->ORG_UNIT_FROM->HrefValue = "";

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->LinkCustomAttributes = "";
            $this->ITEM_ID_FROM->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // STOCK_OPNAME
            $this->STOCK_OPNAME->LinkCustomAttributes = "";
            $this->STOCK_OPNAME->HrefValue = "";

            // STOK_AWAL
            $this->STOK_AWAL->LinkCustomAttributes = "";
            $this->STOK_AWAL->HrefValue = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";

            // ORDER_ID
            $this->ORDER_ID->LinkCustomAttributes = "";
            $this->ORDER_ID->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
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
        if ($this->ORG_ID->Required) {
            if (!$this->ORG_ID->IsDetailKey && EmptyValue($this->ORG_ID->FormValue)) {
                $this->ORG_ID->addErrorMessage(str_replace("%s", $this->ORG_ID->caption(), $this->ORG_ID->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_ID->Required) {
            if (!$this->BRAND_ID->IsDetailKey && EmptyValue($this->BRAND_ID->FormValue)) {
                $this->BRAND_ID->addErrorMessage(str_replace("%s", $this->BRAND_ID->caption(), $this->BRAND_ID->RequiredErrorMessage));
            }
        }
        if ($this->ROOMS_ID->Required) {
            if (!$this->ROOMS_ID->IsDetailKey && EmptyValue($this->ROOMS_ID->FormValue)) {
                $this->ROOMS_ID->addErrorMessage(str_replace("%s", $this->ROOMS_ID->caption(), $this->ROOMS_ID->RequiredErrorMessage));
            }
        }
        if ($this->FROM_ROOMS_ID->Required) {
            if (!$this->FROM_ROOMS_ID->IsDetailKey && EmptyValue($this->FROM_ROOMS_ID->FormValue)) {
                $this->FROM_ROOMS_ID->addErrorMessage(str_replace("%s", $this->FROM_ROOMS_ID->caption(), $this->FROM_ROOMS_ID->RequiredErrorMessage));
            }
        }
        if ($this->ISOUTLET->Required) {
            if (!$this->ISOUTLET->IsDetailKey && EmptyValue($this->ISOUTLET->FormValue)) {
                $this->ISOUTLET->addErrorMessage(str_replace("%s", $this->ISOUTLET->caption(), $this->ISOUTLET->RequiredErrorMessage));
            }
        }
        if ($this->QUANTITY->Required) {
            if (!$this->QUANTITY->IsDetailKey && EmptyValue($this->QUANTITY->FormValue)) {
                $this->QUANTITY->addErrorMessage(str_replace("%s", $this->QUANTITY->caption(), $this->QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY->FormValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
        }
        if ($this->DISTRIBUTION_TYPE->Required) {
            if (!$this->DISTRIBUTION_TYPE->IsDetailKey && EmptyValue($this->DISTRIBUTION_TYPE->FormValue)) {
                $this->DISTRIBUTION_TYPE->addErrorMessage(str_replace("%s", $this->DISTRIBUTION_TYPE->caption(), $this->DISTRIBUTION_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->DISTRIBUTION_TYPE->FormValue)) {
            $this->DISTRIBUTION_TYPE->addErrorMessage($this->DISTRIBUTION_TYPE->getErrorMessage(false));
        }
        if ($this->CONDITION->Required) {
            if (!$this->CONDITION->IsDetailKey && EmptyValue($this->CONDITION->FormValue)) {
                $this->CONDITION->addErrorMessage(str_replace("%s", $this->CONDITION->caption(), $this->CONDITION->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->CONDITION->FormValue)) {
            $this->CONDITION->addErrorMessage($this->CONDITION->getErrorMessage(false));
        }
        if ($this->ALLOCATED_DATE->Required) {
            if (!$this->ALLOCATED_DATE->IsDetailKey && EmptyValue($this->ALLOCATED_DATE->FormValue)) {
                $this->ALLOCATED_DATE->addErrorMessage(str_replace("%s", $this->ALLOCATED_DATE->caption(), $this->ALLOCATED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ALLOCATED_DATE->FormValue)) {
            $this->ALLOCATED_DATE->addErrorMessage($this->ALLOCATED_DATE->getErrorMessage(false));
        }
        if ($this->STOCKOPNAME_DATE->Required) {
            if (!$this->STOCKOPNAME_DATE->IsDetailKey && EmptyValue($this->STOCKOPNAME_DATE->FormValue)) {
                $this->STOCKOPNAME_DATE->addErrorMessage(str_replace("%s", $this->STOCKOPNAME_DATE->caption(), $this->STOCKOPNAME_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->STOCKOPNAME_DATE->FormValue)) {
            $this->STOCKOPNAME_DATE->addErrorMessage($this->STOCKOPNAME_DATE->getErrorMessage(false));
        }
        if ($this->ORG_UNIT_FROM->Required) {
            if (!$this->ORG_UNIT_FROM->IsDetailKey && EmptyValue($this->ORG_UNIT_FROM->FormValue)) {
                $this->ORG_UNIT_FROM->addErrorMessage(str_replace("%s", $this->ORG_UNIT_FROM->caption(), $this->ORG_UNIT_FROM->RequiredErrorMessage));
            }
        }
        if ($this->ITEM_ID_FROM->Required) {
            if (!$this->ITEM_ID_FROM->IsDetailKey && EmptyValue($this->ITEM_ID_FROM->FormValue)) {
                $this->ITEM_ID_FROM->addErrorMessage(str_replace("%s", $this->ITEM_ID_FROM->caption(), $this->ITEM_ID_FROM->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_DATE->Required) {
            if (!$this->MODIFIED_DATE->IsDetailKey && EmptyValue($this->MODIFIED_DATE->FormValue)) {
                $this->MODIFIED_DATE->addErrorMessage(str_replace("%s", $this->MODIFIED_DATE->caption(), $this->MODIFIED_DATE->RequiredErrorMessage));
            }
        }
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->STOCK_OPNAME->Required) {
            if (!$this->STOCK_OPNAME->IsDetailKey && EmptyValue($this->STOCK_OPNAME->FormValue)) {
                $this->STOCK_OPNAME->addErrorMessage(str_replace("%s", $this->STOCK_OPNAME->caption(), $this->STOCK_OPNAME->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_OPNAME->FormValue)) {
            $this->STOCK_OPNAME->addErrorMessage($this->STOCK_OPNAME->getErrorMessage(false));
        }
        if ($this->STOK_AWAL->Required) {
            if (!$this->STOK_AWAL->IsDetailKey && EmptyValue($this->STOK_AWAL->FormValue)) {
                $this->STOK_AWAL->addErrorMessage(str_replace("%s", $this->STOK_AWAL->caption(), $this->STOK_AWAL->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOK_AWAL->FormValue)) {
            $this->STOK_AWAL->addErrorMessage($this->STOK_AWAL->getErrorMessage(false));
        }
        if ($this->STOCK_KOREKSI->Required) {
            if (!$this->STOCK_KOREKSI->IsDetailKey && EmptyValue($this->STOCK_KOREKSI->FormValue)) {
                $this->STOCK_KOREKSI->addErrorMessage(str_replace("%s", $this->STOCK_KOREKSI->caption(), $this->STOCK_KOREKSI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_KOREKSI->FormValue)) {
            $this->STOCK_KOREKSI->addErrorMessage($this->STOCK_KOREKSI->getErrorMessage(false));
        }
        if ($this->BRAND_NAME->Required) {
            if (!$this->BRAND_NAME->IsDetailKey && EmptyValue($this->BRAND_NAME->FormValue)) {
                $this->BRAND_NAME->addErrorMessage(str_replace("%s", $this->BRAND_NAME->caption(), $this->BRAND_NAME->RequiredErrorMessage));
            }
        }
        if ($this->MONTH_ID->Required) {
            if (!$this->MONTH_ID->IsDetailKey && EmptyValue($this->MONTH_ID->FormValue)) {
                $this->MONTH_ID->addErrorMessage(str_replace("%s", $this->MONTH_ID->caption(), $this->MONTH_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MONTH_ID->FormValue)) {
            $this->MONTH_ID->addErrorMessage($this->MONTH_ID->getErrorMessage(false));
        }
        if ($this->YEAR_ID->Required) {
            if (!$this->YEAR_ID->IsDetailKey && EmptyValue($this->YEAR_ID->FormValue)) {
                $this->YEAR_ID->addErrorMessage(str_replace("%s", $this->YEAR_ID->caption(), $this->YEAR_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->YEAR_ID->FormValue)) {
            $this->YEAR_ID->addErrorMessage($this->YEAR_ID->getErrorMessage(false));
        }
        if ($this->DOC_NO->Required) {
            if (!$this->DOC_NO->IsDetailKey && EmptyValue($this->DOC_NO->FormValue)) {
                $this->DOC_NO->addErrorMessage(str_replace("%s", $this->DOC_NO->caption(), $this->DOC_NO->RequiredErrorMessage));
            }
        }
        if ($this->ORDER_ID->Required) {
            if (!$this->ORDER_ID->IsDetailKey && EmptyValue($this->ORDER_ID->FormValue)) {
                $this->ORDER_ID->addErrorMessage(str_replace("%s", $this->ORDER_ID->caption(), $this->ORDER_ID->RequiredErrorMessage));
            }
        }
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
            }
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, null, $this->ORG_UNIT_CODE->ReadOnly);

            // ORG_ID
            if ($this->ORG_ID->getSessionValue() != "") {
                $this->ORG_ID->ReadOnly = true;
            }
            $this->ORG_ID->setDbValueDef($rsnew, $this->ORG_ID->CurrentValue, null, $this->ORG_ID->ReadOnly);

            // BRAND_ID
            $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", $this->BRAND_ID->ReadOnly);

            // ROOMS_ID
            if ($this->ROOMS_ID->getSessionValue() != "") {
                $this->ROOMS_ID->ReadOnly = true;
            }
            $this->ROOMS_ID->setDbValueDef($rsnew, $this->ROOMS_ID->CurrentValue, "", $this->ROOMS_ID->ReadOnly);

            // FROM_ROOMS_ID
            if ($this->FROM_ROOMS_ID->getSessionValue() != "") {
                $this->FROM_ROOMS_ID->ReadOnly = true;
            }
            $this->FROM_ROOMS_ID->setDbValueDef($rsnew, $this->FROM_ROOMS_ID->CurrentValue, null, $this->FROM_ROOMS_ID->ReadOnly);

            // ISOUTLET
            $this->ISOUTLET->setDbValueDef($rsnew, $this->ISOUTLET->CurrentValue, null, $this->ISOUTLET->ReadOnly);

            // QUANTITY
            $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, $this->QUANTITY->ReadOnly);

            // MEASURE_ID
            $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, $this->MEASURE_ID->ReadOnly);

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->setDbValueDef($rsnew, $this->DISTRIBUTION_TYPE->CurrentValue, null, $this->DISTRIBUTION_TYPE->ReadOnly);

            // CONDITION
            $this->CONDITION->setDbValueDef($rsnew, $this->CONDITION->CurrentValue, null, $this->CONDITION->ReadOnly);

            // ALLOCATED_DATE
            $this->ALLOCATED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ALLOCATED_DATE->CurrentValue, 0), null, $this->ALLOCATED_DATE->ReadOnly);

            // STOCKOPNAME_DATE
            $this->STOCKOPNAME_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 0), null, $this->STOCKOPNAME_DATE->ReadOnly);

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->setDbValueDef($rsnew, $this->ORG_UNIT_FROM->CurrentValue, null, $this->ORG_UNIT_FROM->ReadOnly);

            // ITEM_ID_FROM
            $this->ITEM_ID_FROM->setDbValueDef($rsnew, $this->ITEM_ID_FROM->CurrentValue, null, $this->ITEM_ID_FROM->ReadOnly);

            // MODIFIED_DATE
            $this->MODIFIED_DATE->CurrentValue = CurrentDateTime();
            $this->MODIFIED_DATE->setDbValueDef($rsnew, $this->MODIFIED_DATE->CurrentValue, null);

            // MODIFIED_BY
            $this->MODIFIED_BY->CurrentValue = CurrentUserName();
            $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null);

            // STOCK_OPNAME
            $this->STOCK_OPNAME->setDbValueDef($rsnew, $this->STOCK_OPNAME->CurrentValue, null, $this->STOCK_OPNAME->ReadOnly);

            // STOK_AWAL
            $this->STOK_AWAL->setDbValueDef($rsnew, $this->STOK_AWAL->CurrentValue, null, $this->STOK_AWAL->ReadOnly);

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->setDbValueDef($rsnew, $this->STOCK_KOREKSI->CurrentValue, null, $this->STOCK_KOREKSI->ReadOnly);

            // BRAND_NAME
            $this->BRAND_NAME->setDbValueDef($rsnew, $this->BRAND_NAME->CurrentValue, null, $this->BRAND_NAME->ReadOnly);

            // MONTH_ID
            $this->MONTH_ID->setDbValueDef($rsnew, $this->MONTH_ID->CurrentValue, null, $this->MONTH_ID->ReadOnly);

            // YEAR_ID
            $this->YEAR_ID->setDbValueDef($rsnew, $this->YEAR_ID->CurrentValue, null, $this->YEAR_ID->ReadOnly);

            // DOC_NO
            if ($this->DOC_NO->getSessionValue() != "") {
                $this->DOC_NO->ReadOnly = true;
            }
            $this->DOC_NO->setDbValueDef($rsnew, $this->DOC_NO->CurrentValue, null, $this->DOC_NO->ReadOnly);

            // ORDER_ID
            $this->ORDER_ID->setDbValueDef($rsnew, $this->ORDER_ID->CurrentValue, null, $this->ORDER_ID->ReadOnly);

            // ISCETAK
            $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, $this->ISCETAK->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssoc($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['ORG_UNIT_CODE']); // ORG_UNIT_CODE
        $hash .= GetFieldHash($row['ORG_ID']); // ORG_ID
        $hash .= GetFieldHash($row['BRAND_ID']); // BRAND_ID
        $hash .= GetFieldHash($row['ROOMS_ID']); // ROOMS_ID
        $hash .= GetFieldHash($row['FROM_ROOMS_ID']); // FROM_ROOMS_ID
        $hash .= GetFieldHash($row['ISOUTLET']); // ISOUTLET
        $hash .= GetFieldHash($row['QUANTITY']); // QUANTITY
        $hash .= GetFieldHash($row['MEASURE_ID']); // MEASURE_ID
        $hash .= GetFieldHash($row['DISTRIBUTION_TYPE']); // DISTRIBUTION_TYPE
        $hash .= GetFieldHash($row['CONDITION']); // CONDITION
        $hash .= GetFieldHash($row['ALLOCATED_DATE']); // ALLOCATED_DATE
        $hash .= GetFieldHash($row['STOCKOPNAME_DATE']); // STOCKOPNAME_DATE
        $hash .= GetFieldHash($row['ORG_UNIT_FROM']); // ORG_UNIT_FROM
        $hash .= GetFieldHash($row['ITEM_ID_FROM']); // ITEM_ID_FROM
        $hash .= GetFieldHash($row['MODIFIED_DATE']); // MODIFIED_DATE
        $hash .= GetFieldHash($row['MODIFIED_BY']); // MODIFIED_BY
        $hash .= GetFieldHash($row['STOCK_OPNAME']); // STOCK_OPNAME
        $hash .= GetFieldHash($row['STOK_AWAL']); // STOK_AWAL
        $hash .= GetFieldHash($row['STOCK_KOREKSI']); // STOCK_KOREKSI
        $hash .= GetFieldHash($row['BRAND_NAME']); // BRAND_NAME
        $hash .= GetFieldHash($row['MONTH_ID']); // MONTH_ID
        $hash .= GetFieldHash($row['YEAR_ID']); // YEAR_ID
        $hash .= GetFieldHash($row['DOC_NO']); // DOC_NO
        $hash .= GetFieldHash($row['ORDER_ID']); // ORDER_ID
        $hash .= GetFieldHash($row['ISCETAK']); // ISCETAK
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, null, false);

        // ORG_ID
        $this->ORG_ID->setDbValueDef($rsnew, $this->ORG_ID->CurrentValue, null, false);

        // BRAND_ID
        $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", false);

        // ROOMS_ID
        $this->ROOMS_ID->setDbValueDef($rsnew, $this->ROOMS_ID->CurrentValue, "", false);

        // FROM_ROOMS_ID
        $this->FROM_ROOMS_ID->setDbValueDef($rsnew, $this->FROM_ROOMS_ID->CurrentValue, null, false);

        // ISOUTLET
        $this->ISOUTLET->setDbValueDef($rsnew, $this->ISOUTLET->CurrentValue, null, false);

        // QUANTITY
        $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, false);

        // MEASURE_ID
        $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, false);

        // DISTRIBUTION_TYPE
        $this->DISTRIBUTION_TYPE->setDbValueDef($rsnew, $this->DISTRIBUTION_TYPE->CurrentValue, null, false);

        // CONDITION
        $this->CONDITION->setDbValueDef($rsnew, $this->CONDITION->CurrentValue, null, false);

        // ALLOCATED_DATE
        $this->ALLOCATED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ALLOCATED_DATE->CurrentValue, 0), null, false);

        // STOCKOPNAME_DATE
        $this->STOCKOPNAME_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->STOCKOPNAME_DATE->CurrentValue, 0), null, false);

        // ORG_UNIT_FROM
        $this->ORG_UNIT_FROM->setDbValueDef($rsnew, $this->ORG_UNIT_FROM->CurrentValue, null, false);

        // ITEM_ID_FROM
        $this->ITEM_ID_FROM->setDbValueDef($rsnew, $this->ITEM_ID_FROM->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->CurrentValue = CurrentDateTime();
        $this->MODIFIED_DATE->setDbValueDef($rsnew, $this->MODIFIED_DATE->CurrentValue, null);

        // MODIFIED_BY
        $this->MODIFIED_BY->CurrentValue = CurrentUserName();
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null);

        // STOCK_OPNAME
        $this->STOCK_OPNAME->setDbValueDef($rsnew, $this->STOCK_OPNAME->CurrentValue, null, false);

        // STOK_AWAL
        $this->STOK_AWAL->setDbValueDef($rsnew, $this->STOK_AWAL->CurrentValue, null, false);

        // STOCK_KOREKSI
        $this->STOCK_KOREKSI->setDbValueDef($rsnew, $this->STOCK_KOREKSI->CurrentValue, null, false);

        // BRAND_NAME
        $this->BRAND_NAME->setDbValueDef($rsnew, $this->BRAND_NAME->CurrentValue, null, false);

        // MONTH_ID
        $this->MONTH_ID->setDbValueDef($rsnew, $this->MONTH_ID->CurrentValue, null, false);

        // YEAR_ID
        $this->YEAR_ID->setDbValueDef($rsnew, $this->YEAR_ID->CurrentValue, null, false);

        // DOC_NO
        $this->DOC_NO->setDbValueDef($rsnew, $this->DOC_NO->CurrentValue, null, false);

        // ORDER_ID
        $this->ORDER_ID->setDbValueDef($rsnew, $this->ORDER_ID->CurrentValue, null, false);

        // ISCETAK
        $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, false);

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

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fGOOD_GFlist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fGOOD_GFlist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fGOOD_GFlist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
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
            return '<button id="emf_GOOD_GF" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_GOOD_GF\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fGOOD_GFlist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fGOOD_GFlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "MUTATION_DOCS") {
                $validMaster = true;
                $masterTbl = Container("MUTATION_DOCS");
                if (($parm = Get("fk_CLINIC_ID_TO", Get("ROOMS_ID"))) !== null) {
                    $masterTbl->CLINIC_ID_TO->setQueryStringValue($parm);
                    $this->ROOMS_ID->setQueryStringValue($masterTbl->CLINIC_ID_TO->QueryStringValue);
                    $this->ROOMS_ID->setSessionValue($this->ROOMS_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_CLINIC_ID_TO", Get("ORG_ID"))) !== null) {
                    $masterTbl->CLINIC_ID_TO->setQueryStringValue($parm);
                    $this->ORG_ID->setQueryStringValue($masterTbl->CLINIC_ID_TO->QueryStringValue);
                    $this->ORG_ID->setSessionValue($this->ORG_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_CLINIC_ID", Get("FROM_ROOMS_ID"))) !== null) {
                    $masterTbl->CLINIC_ID->setQueryStringValue($parm);
                    $this->FROM_ROOMS_ID->setQueryStringValue($masterTbl->CLINIC_ID->QueryStringValue);
                    $this->FROM_ROOMS_ID->setSessionValue($this->FROM_ROOMS_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_DOC_NO", Get("DOC_NO"))) !== null) {
                    $masterTbl->DOC_NO->setQueryStringValue($parm);
                    $this->DOC_NO->setQueryStringValue($masterTbl->DOC_NO->QueryStringValue);
                    $this->DOC_NO->setSessionValue($this->DOC_NO->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "MUTATION_DOCS") {
                $validMaster = true;
                $masterTbl = Container("MUTATION_DOCS");
                if (($parm = Post("fk_CLINIC_ID_TO", Post("ROOMS_ID"))) !== null) {
                    $masterTbl->CLINIC_ID_TO->setFormValue($parm);
                    $this->ROOMS_ID->setFormValue($masterTbl->CLINIC_ID_TO->FormValue);
                    $this->ROOMS_ID->setSessionValue($this->ROOMS_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_CLINIC_ID_TO", Post("ORG_ID"))) !== null) {
                    $masterTbl->CLINIC_ID_TO->setFormValue($parm);
                    $this->ORG_ID->setFormValue($masterTbl->CLINIC_ID_TO->FormValue);
                    $this->ORG_ID->setSessionValue($this->ORG_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_CLINIC_ID", Post("FROM_ROOMS_ID"))) !== null) {
                    $masterTbl->CLINIC_ID->setFormValue($parm);
                    $this->FROM_ROOMS_ID->setFormValue($masterTbl->CLINIC_ID->FormValue);
                    $this->FROM_ROOMS_ID->setSessionValue($this->FROM_ROOMS_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_DOC_NO", Post("DOC_NO"))) !== null) {
                    $masterTbl->DOC_NO->setFormValue($parm);
                    $this->DOC_NO->setFormValue($masterTbl->DOC_NO->FormValue);
                    $this->DOC_NO->setSessionValue($this->DOC_NO->FormValue);
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "MUTATION_DOCS") {
                if ($this->ROOMS_ID->CurrentValue == "") {
                    $this->ROOMS_ID->setSessionValue("");
                }
                if ($this->ORG_ID->CurrentValue == "") {
                    $this->ORG_ID->setSessionValue("");
                }
                if ($this->FROM_ROOMS_ID->CurrentValue == "") {
                    $this->FROM_ROOMS_ID->setSessionValue("");
                }
                if ($this->DOC_NO->CurrentValue == "") {
                    $this->DOC_NO->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
                case "x_BRAND_ID":
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
