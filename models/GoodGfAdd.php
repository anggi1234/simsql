<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodGfAdd extends GoodGf
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOOD_GF';

    // Page object name
    public $PageObjName = "GoodGfAdd";

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

        // Table object (GOOD_GF)
        if (!isset($GLOBALS["GOOD_GF"]) || get_class($GLOBALS["GOOD_GF"]) == PROJECT_NAMESPACE . "GOOD_GF") {
            $GLOBALS["GOOD_GF"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "GoodGfView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->ORG_UNIT_CODE->setVisibility();
        $this->ITEM_ID->Visible = false;
        $this->ORG_ID->setVisibility();
        $this->BATCH_NO->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->ROOMS_ID->setVisibility();
        $this->SHELF_NO->setVisibility();
        $this->EXPIRY_DATE->setVisibility();
        $this->SERIAL_NB->setVisibility();
        $this->FROM_ROOMS_ID->setVisibility();
        $this->ISOUTLET->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->CONDITION->setVisibility();
        $this->ALLOCATED_DATE->setVisibility();
        $this->STOCKOPNAME_DATE->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->ALLOCATED_FROM->setVisibility();
        $this->PRICE->setVisibility();
        $this->DISCOUNT->setVisibility();
        $this->DISCOUNT2->setVisibility();
        $this->DISCOUNTOFF->setVisibility();
        $this->ORG_UNIT_FROM->setVisibility();
        $this->ITEM_ID_FROM->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->STOCK_OPNAME->setVisibility();
        $this->STOK_AWAL->setVisibility();
        $this->STOCK_LALU->setVisibility();
        $this->STOCK_KOREKSI->setVisibility();
        $this->DITERIMA->setVisibility();
        $this->DISTRIBUSI->setVisibility();
        $this->DIJUAL->setVisibility();
        $this->DIHAPUS->setVisibility();
        $this->DIMINTA->setVisibility();
        $this->DIRETUR->setVisibility();
        $this->PO->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->FUND_ID->setVisibility();
        $this->INVOICE_ID2->setVisibility();
        $this->MEASURE_ID3->setVisibility();
        $this->SIZE_KEMASAN->setVisibility();
        $this->BRAND_NAME->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->RETUR_ID->setVisibility();
        $this->SIZE_GOODS->setVisibility();
        $this->MEASURE_DOSIS->setVisibility();
        $this->ORDER_PRICE->setVisibility();
        $this->STOCK_AVAILABLE->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->MONTH_ID->setVisibility();
        $this->YEAR_ID->setVisibility();
        $this->CORRECTION_DOC->setVisibility();
        $this->CORRECTIONS->setVisibility();
        $this->CORRECTION_DATE->setVisibility();
        $this->DOC_NO->setVisibility();
        $this->ORDER_ID->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->avgprice->setVisibility();
        $this->idx->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->BRAND_ID);

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
            if (($keyValue = Get("idx") ?? Route("idx")) !== null) {
                $this->idx->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

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
                    $this->terminate("GoodGfList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "GoodGfList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "GoodGfView") {
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

        // Check field name 'BATCH_NO' first before field var 'x_BATCH_NO'
        $val = $CurrentForm->hasValue("BATCH_NO") ? $CurrentForm->getValue("BATCH_NO") : $CurrentForm->getValue("x_BATCH_NO");
        if (!$this->BATCH_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BATCH_NO->Visible = false; // Disable update for API request
            } else {
                $this->BATCH_NO->setFormValue($val);
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

        // Check field name 'SHELF_NO' first before field var 'x_SHELF_NO'
        $val = $CurrentForm->hasValue("SHELF_NO") ? $CurrentForm->getValue("SHELF_NO") : $CurrentForm->getValue("x_SHELF_NO");
        if (!$this->SHELF_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SHELF_NO->Visible = false; // Disable update for API request
            } else {
                $this->SHELF_NO->setFormValue($val);
            }
        }

        // Check field name 'EXPIRY_DATE' first before field var 'x_EXPIRY_DATE'
        $val = $CurrentForm->hasValue("EXPIRY_DATE") ? $CurrentForm->getValue("EXPIRY_DATE") : $CurrentForm->getValue("x_EXPIRY_DATE");
        if (!$this->EXPIRY_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EXPIRY_DATE->Visible = false; // Disable update for API request
            } else {
                $this->EXPIRY_DATE->setFormValue($val);
            }
            $this->EXPIRY_DATE->CurrentValue = UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0);
        }

        // Check field name 'SERIAL_NB' first before field var 'x_SERIAL_NB'
        $val = $CurrentForm->hasValue("SERIAL_NB") ? $CurrentForm->getValue("SERIAL_NB") : $CurrentForm->getValue("x_SERIAL_NB");
        if (!$this->SERIAL_NB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERIAL_NB->Visible = false; // Disable update for API request
            } else {
                $this->SERIAL_NB->setFormValue($val);
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

        // Check field name 'INVOICE_ID' first before field var 'x_INVOICE_ID'
        $val = $CurrentForm->hasValue("INVOICE_ID") ? $CurrentForm->getValue("INVOICE_ID") : $CurrentForm->getValue("x_INVOICE_ID");
        if (!$this->INVOICE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_ID->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_ID->setFormValue($val);
            }
        }

        // Check field name 'ALLOCATED_FROM' first before field var 'x_ALLOCATED_FROM'
        $val = $CurrentForm->hasValue("ALLOCATED_FROM") ? $CurrentForm->getValue("ALLOCATED_FROM") : $CurrentForm->getValue("x_ALLOCATED_FROM");
        if (!$this->ALLOCATED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ALLOCATED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->ALLOCATED_FROM->setFormValue($val);
            }
        }

        // Check field name 'PRICE' first before field var 'x_PRICE'
        $val = $CurrentForm->hasValue("PRICE") ? $CurrentForm->getValue("PRICE") : $CurrentForm->getValue("x_PRICE");
        if (!$this->PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRICE->Visible = false; // Disable update for API request
            } else {
                $this->PRICE->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT' first before field var 'x_DISCOUNT'
        $val = $CurrentForm->hasValue("DISCOUNT") ? $CurrentForm->getValue("DISCOUNT") : $CurrentForm->getValue("x_DISCOUNT");
        if (!$this->DISCOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT2' first before field var 'x_DISCOUNT2'
        $val = $CurrentForm->hasValue("DISCOUNT2") ? $CurrentForm->getValue("DISCOUNT2") : $CurrentForm->getValue("x_DISCOUNT2");
        if (!$this->DISCOUNT2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT2->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT2->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNTOFF' first before field var 'x_DISCOUNTOFF'
        $val = $CurrentForm->hasValue("DISCOUNTOFF") ? $CurrentForm->getValue("DISCOUNTOFF") : $CurrentForm->getValue("x_DISCOUNTOFF");
        if (!$this->DISCOUNTOFF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNTOFF->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNTOFF->setFormValue($val);
            }
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

        // Check field name 'STOCK_LALU' first before field var 'x_STOCK_LALU'
        $val = $CurrentForm->hasValue("STOCK_LALU") ? $CurrentForm->getValue("STOCK_LALU") : $CurrentForm->getValue("x_STOCK_LALU");
        if (!$this->STOCK_LALU->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_LALU->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_LALU->setFormValue($val);
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

        // Check field name 'DITERIMA' first before field var 'x_DITERIMA'
        $val = $CurrentForm->hasValue("DITERIMA") ? $CurrentForm->getValue("DITERIMA") : $CurrentForm->getValue("x_DITERIMA");
        if (!$this->DITERIMA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DITERIMA->Visible = false; // Disable update for API request
            } else {
                $this->DITERIMA->setFormValue($val);
            }
        }

        // Check field name 'DISTRIBUSI' first before field var 'x_DISTRIBUSI'
        $val = $CurrentForm->hasValue("DISTRIBUSI") ? $CurrentForm->getValue("DISTRIBUSI") : $CurrentForm->getValue("x_DISTRIBUSI");
        if (!$this->DISTRIBUSI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISTRIBUSI->Visible = false; // Disable update for API request
            } else {
                $this->DISTRIBUSI->setFormValue($val);
            }
        }

        // Check field name 'DIJUAL' first before field var 'x_DIJUAL'
        $val = $CurrentForm->hasValue("DIJUAL") ? $CurrentForm->getValue("DIJUAL") : $CurrentForm->getValue("x_DIJUAL");
        if (!$this->DIJUAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIJUAL->Visible = false; // Disable update for API request
            } else {
                $this->DIJUAL->setFormValue($val);
            }
        }

        // Check field name 'DIHAPUS' first before field var 'x_DIHAPUS'
        $val = $CurrentForm->hasValue("DIHAPUS") ? $CurrentForm->getValue("DIHAPUS") : $CurrentForm->getValue("x_DIHAPUS");
        if (!$this->DIHAPUS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIHAPUS->Visible = false; // Disable update for API request
            } else {
                $this->DIHAPUS->setFormValue($val);
            }
        }

        // Check field name 'DIMINTA' first before field var 'x_DIMINTA'
        $val = $CurrentForm->hasValue("DIMINTA") ? $CurrentForm->getValue("DIMINTA") : $CurrentForm->getValue("x_DIMINTA");
        if (!$this->DIMINTA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIMINTA->Visible = false; // Disable update for API request
            } else {
                $this->DIMINTA->setFormValue($val);
            }
        }

        // Check field name 'DIRETUR' first before field var 'x_DIRETUR'
        $val = $CurrentForm->hasValue("DIRETUR") ? $CurrentForm->getValue("DIRETUR") : $CurrentForm->getValue("x_DIRETUR");
        if (!$this->DIRETUR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIRETUR->Visible = false; // Disable update for API request
            } else {
                $this->DIRETUR->setFormValue($val);
            }
        }

        // Check field name 'PO' first before field var 'x_PO'
        $val = $CurrentForm->hasValue("PO") ? $CurrentForm->getValue("PO") : $CurrentForm->getValue("x_PO");
        if (!$this->PO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO->Visible = false; // Disable update for API request
            } else {
                $this->PO->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_ID' first before field var 'x_COMPANY_ID'
        $val = $CurrentForm->hasValue("COMPANY_ID") ? $CurrentForm->getValue("COMPANY_ID") : $CurrentForm->getValue("x_COMPANY_ID");
        if (!$this->COMPANY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_ID->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_ID->setFormValue($val);
            }
        }

        // Check field name 'FUND_ID' first before field var 'x_FUND_ID'
        $val = $CurrentForm->hasValue("FUND_ID") ? $CurrentForm->getValue("FUND_ID") : $CurrentForm->getValue("x_FUND_ID");
        if (!$this->FUND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FUND_ID->Visible = false; // Disable update for API request
            } else {
                $this->FUND_ID->setFormValue($val);
            }
        }

        // Check field name 'INVOICE_ID2' first before field var 'x_INVOICE_ID2'
        $val = $CurrentForm->hasValue("INVOICE_ID2") ? $CurrentForm->getValue("INVOICE_ID2") : $CurrentForm->getValue("x_INVOICE_ID2");
        if (!$this->INVOICE_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_ID2->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_ID2->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID3' first before field var 'x_MEASURE_ID3'
        $val = $CurrentForm->hasValue("MEASURE_ID3") ? $CurrentForm->getValue("MEASURE_ID3") : $CurrentForm->getValue("x_MEASURE_ID3");
        if (!$this->MEASURE_ID3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID3->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID3->setFormValue($val);
            }
        }

        // Check field name 'SIZE_KEMASAN' first before field var 'x_SIZE_KEMASAN'
        $val = $CurrentForm->hasValue("SIZE_KEMASAN") ? $CurrentForm->getValue("SIZE_KEMASAN") : $CurrentForm->getValue("x_SIZE_KEMASAN");
        if (!$this->SIZE_KEMASAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_KEMASAN->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_KEMASAN->setFormValue($val);
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

        // Check field name 'MEASURE_ID2' first before field var 'x_MEASURE_ID2'
        $val = $CurrentForm->hasValue("MEASURE_ID2") ? $CurrentForm->getValue("MEASURE_ID2") : $CurrentForm->getValue("x_MEASURE_ID2");
        if (!$this->MEASURE_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID2->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID2->setFormValue($val);
            }
        }

        // Check field name 'RETUR_ID' first before field var 'x_RETUR_ID'
        $val = $CurrentForm->hasValue("RETUR_ID") ? $CurrentForm->getValue("RETUR_ID") : $CurrentForm->getValue("x_RETUR_ID");
        if (!$this->RETUR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RETUR_ID->Visible = false; // Disable update for API request
            } else {
                $this->RETUR_ID->setFormValue($val);
            }
        }

        // Check field name 'SIZE_GOODS' first before field var 'x_SIZE_GOODS'
        $val = $CurrentForm->hasValue("SIZE_GOODS") ? $CurrentForm->getValue("SIZE_GOODS") : $CurrentForm->getValue("x_SIZE_GOODS");
        if (!$this->SIZE_GOODS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_GOODS->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_GOODS->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_DOSIS' first before field var 'x_MEASURE_DOSIS'
        $val = $CurrentForm->hasValue("MEASURE_DOSIS") ? $CurrentForm->getValue("MEASURE_DOSIS") : $CurrentForm->getValue("x_MEASURE_DOSIS");
        if (!$this->MEASURE_DOSIS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_DOSIS->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_DOSIS->setFormValue($val);
            }
        }

        // Check field name 'ORDER_PRICE' first before field var 'x_ORDER_PRICE'
        $val = $CurrentForm->hasValue("ORDER_PRICE") ? $CurrentForm->getValue("ORDER_PRICE") : $CurrentForm->getValue("x_ORDER_PRICE");
        if (!$this->ORDER_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_PRICE->setFormValue($val);
            }
        }

        // Check field name 'STOCK_AVAILABLE' first before field var 'x_STOCK_AVAILABLE'
        $val = $CurrentForm->hasValue("STOCK_AVAILABLE") ? $CurrentForm->getValue("STOCK_AVAILABLE") : $CurrentForm->getValue("x_STOCK_AVAILABLE");
        if (!$this->STOCK_AVAILABLE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_AVAILABLE->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_AVAILABLE->setFormValue($val);
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

        // Check field name 'CORRECTION_DOC' first before field var 'x_CORRECTION_DOC'
        $val = $CurrentForm->hasValue("CORRECTION_DOC") ? $CurrentForm->getValue("CORRECTION_DOC") : $CurrentForm->getValue("x_CORRECTION_DOC");
        if (!$this->CORRECTION_DOC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CORRECTION_DOC->Visible = false; // Disable update for API request
            } else {
                $this->CORRECTION_DOC->setFormValue($val);
            }
        }

        // Check field name 'CORRECTIONS' first before field var 'x_CORRECTIONS'
        $val = $CurrentForm->hasValue("CORRECTIONS") ? $CurrentForm->getValue("CORRECTIONS") : $CurrentForm->getValue("x_CORRECTIONS");
        if (!$this->CORRECTIONS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CORRECTIONS->Visible = false; // Disable update for API request
            } else {
                $this->CORRECTIONS->setFormValue($val);
            }
        }

        // Check field name 'CORRECTION_DATE' first before field var 'x_CORRECTION_DATE'
        $val = $CurrentForm->hasValue("CORRECTION_DATE") ? $CurrentForm->getValue("CORRECTION_DATE") : $CurrentForm->getValue("x_CORRECTION_DATE");
        if (!$this->CORRECTION_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CORRECTION_DATE->Visible = false; // Disable update for API request
            } else {
                $this->CORRECTION_DATE->setFormValue($val);
            }
            $this->CORRECTION_DATE->CurrentValue = UnFormatDateTime($this->CORRECTION_DATE->CurrentValue, 11);
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

        // Check field name 'PRINT_DATE' first before field var 'x_PRINT_DATE'
        $val = $CurrentForm->hasValue("PRINT_DATE") ? $CurrentForm->getValue("PRINT_DATE") : $CurrentForm->getValue("x_PRINT_DATE");
        if (!$this->PRINT_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINT_DATE->Visible = false; // Disable update for API request
            } else {
                $this->PRINT_DATE->setFormValue($val);
            }
            $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        }

        // Check field name 'PRINTED_BY' first before field var 'x_PRINTED_BY'
        $val = $CurrentForm->hasValue("PRINTED_BY") ? $CurrentForm->getValue("PRINTED_BY") : $CurrentForm->getValue("x_PRINTED_BY");
        if (!$this->PRINTED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTED_BY->Visible = false; // Disable update for API request
            } else {
                $this->PRINTED_BY->setFormValue($val);
            }
        }

        // Check field name 'PRINTQ' first before field var 'x_PRINTQ'
        $val = $CurrentForm->hasValue("PRINTQ") ? $CurrentForm->getValue("PRINTQ") : $CurrentForm->getValue("x_PRINTQ");
        if (!$this->PRINTQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTQ->Visible = false; // Disable update for API request
            } else {
                $this->PRINTQ->setFormValue($val);
            }
        }

        // Check field name 'avgprice' first before field var 'x_avgprice'
        $val = $CurrentForm->hasValue("avgprice") ? $CurrentForm->getValue("avgprice") : $CurrentForm->getValue("x_avgprice");
        if (!$this->avgprice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->avgprice->Visible = false; // Disable update for API request
            } else {
                $this->avgprice->setFormValue($val);
            }
        }

        // Check field name 'idx' first before field var 'x_idx'
        $val = $CurrentForm->hasValue("idx") ? $CurrentForm->getValue("idx") : $CurrentForm->getValue("x_idx");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->ORG_ID->CurrentValue = $this->ORG_ID->FormValue;
        $this->BATCH_NO->CurrentValue = $this->BATCH_NO->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->ROOMS_ID->CurrentValue = $this->ROOMS_ID->FormValue;
        $this->SHELF_NO->CurrentValue = $this->SHELF_NO->FormValue;
        $this->EXPIRY_DATE->CurrentValue = $this->EXPIRY_DATE->FormValue;
        $this->EXPIRY_DATE->CurrentValue = UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0);
        $this->SERIAL_NB->CurrentValue = $this->SERIAL_NB->FormValue;
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
        $this->INVOICE_ID->CurrentValue = $this->INVOICE_ID->FormValue;
        $this->ALLOCATED_FROM->CurrentValue = $this->ALLOCATED_FROM->FormValue;
        $this->PRICE->CurrentValue = $this->PRICE->FormValue;
        $this->DISCOUNT->CurrentValue = $this->DISCOUNT->FormValue;
        $this->DISCOUNT2->CurrentValue = $this->DISCOUNT2->FormValue;
        $this->DISCOUNTOFF->CurrentValue = $this->DISCOUNTOFF->FormValue;
        $this->ORG_UNIT_FROM->CurrentValue = $this->ORG_UNIT_FROM->FormValue;
        $this->ITEM_ID_FROM->CurrentValue = $this->ITEM_ID_FROM->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->STOCK_OPNAME->CurrentValue = $this->STOCK_OPNAME->FormValue;
        $this->STOK_AWAL->CurrentValue = $this->STOK_AWAL->FormValue;
        $this->STOCK_LALU->CurrentValue = $this->STOCK_LALU->FormValue;
        $this->STOCK_KOREKSI->CurrentValue = $this->STOCK_KOREKSI->FormValue;
        $this->DITERIMA->CurrentValue = $this->DITERIMA->FormValue;
        $this->DISTRIBUSI->CurrentValue = $this->DISTRIBUSI->FormValue;
        $this->DIJUAL->CurrentValue = $this->DIJUAL->FormValue;
        $this->DIHAPUS->CurrentValue = $this->DIHAPUS->FormValue;
        $this->DIMINTA->CurrentValue = $this->DIMINTA->FormValue;
        $this->DIRETUR->CurrentValue = $this->DIRETUR->FormValue;
        $this->PO->CurrentValue = $this->PO->FormValue;
        $this->COMPANY_ID->CurrentValue = $this->COMPANY_ID->FormValue;
        $this->FUND_ID->CurrentValue = $this->FUND_ID->FormValue;
        $this->INVOICE_ID2->CurrentValue = $this->INVOICE_ID2->FormValue;
        $this->MEASURE_ID3->CurrentValue = $this->MEASURE_ID3->FormValue;
        $this->SIZE_KEMASAN->CurrentValue = $this->SIZE_KEMASAN->FormValue;
        $this->BRAND_NAME->CurrentValue = $this->BRAND_NAME->FormValue;
        $this->MEASURE_ID2->CurrentValue = $this->MEASURE_ID2->FormValue;
        $this->RETUR_ID->CurrentValue = $this->RETUR_ID->FormValue;
        $this->SIZE_GOODS->CurrentValue = $this->SIZE_GOODS->FormValue;
        $this->MEASURE_DOSIS->CurrentValue = $this->MEASURE_DOSIS->FormValue;
        $this->ORDER_PRICE->CurrentValue = $this->ORDER_PRICE->FormValue;
        $this->STOCK_AVAILABLE->CurrentValue = $this->STOCK_AVAILABLE->FormValue;
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->MONTH_ID->CurrentValue = $this->MONTH_ID->FormValue;
        $this->YEAR_ID->CurrentValue = $this->YEAR_ID->FormValue;
        $this->CORRECTION_DOC->CurrentValue = $this->CORRECTION_DOC->FormValue;
        $this->CORRECTIONS->CurrentValue = $this->CORRECTIONS->FormValue;
        $this->CORRECTION_DATE->CurrentValue = $this->CORRECTION_DATE->FormValue;
        $this->CORRECTION_DATE->CurrentValue = UnFormatDateTime($this->CORRECTION_DATE->CurrentValue, 11);
        $this->DOC_NO->CurrentValue = $this->DOC_NO->FormValue;
        $this->ORDER_ID->CurrentValue = $this->ORDER_ID->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->avgprice->CurrentValue = $this->avgprice->FormValue;
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

        // Convert decimal values if posted back
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->PRICE->FormValue == $this->PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->PRICE->CurrentValue))) {
            $this->PRICE->CurrentValue = ConvertToFloatString($this->PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT->FormValue == $this->DISCOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT->CurrentValue))) {
            $this->DISCOUNT->CurrentValue = ConvertToFloatString($this->DISCOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT2->FormValue == $this->DISCOUNT2->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT2->CurrentValue))) {
            $this->DISCOUNT2->CurrentValue = ConvertToFloatString($this->DISCOUNT2->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNTOFF->FormValue == $this->DISCOUNTOFF->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNTOFF->CurrentValue))) {
            $this->DISCOUNTOFF->CurrentValue = ConvertToFloatString($this->DISCOUNTOFF->CurrentValue);
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
        if ($this->STOCK_LALU->FormValue == $this->STOCK_LALU->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_LALU->CurrentValue))) {
            $this->STOCK_LALU->CurrentValue = ConvertToFloatString($this->STOCK_LALU->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_KOREKSI->FormValue == $this->STOCK_KOREKSI->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue))) {
            $this->STOCK_KOREKSI->CurrentValue = ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DITERIMA->FormValue == $this->DITERIMA->CurrentValue && is_numeric(ConvertToFloatString($this->DITERIMA->CurrentValue))) {
            $this->DITERIMA->CurrentValue = ConvertToFloatString($this->DITERIMA->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISTRIBUSI->FormValue == $this->DISTRIBUSI->CurrentValue && is_numeric(ConvertToFloatString($this->DISTRIBUSI->CurrentValue))) {
            $this->DISTRIBUSI->CurrentValue = ConvertToFloatString($this->DISTRIBUSI->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIJUAL->FormValue == $this->DIJUAL->CurrentValue && is_numeric(ConvertToFloatString($this->DIJUAL->CurrentValue))) {
            $this->DIJUAL->CurrentValue = ConvertToFloatString($this->DIJUAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIHAPUS->FormValue == $this->DIHAPUS->CurrentValue && is_numeric(ConvertToFloatString($this->DIHAPUS->CurrentValue))) {
            $this->DIHAPUS->CurrentValue = ConvertToFloatString($this->DIHAPUS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIMINTA->FormValue == $this->DIMINTA->CurrentValue && is_numeric(ConvertToFloatString($this->DIMINTA->CurrentValue))) {
            $this->DIMINTA->CurrentValue = ConvertToFloatString($this->DIMINTA->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DIRETUR->FormValue == $this->DIRETUR->CurrentValue && is_numeric(ConvertToFloatString($this->DIRETUR->CurrentValue))) {
            $this->DIRETUR->CurrentValue = ConvertToFloatString($this->DIRETUR->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_KEMASAN->FormValue == $this->SIZE_KEMASAN->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue))) {
            $this->SIZE_KEMASAN->CurrentValue = ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_GOODS->FormValue == $this->SIZE_GOODS->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_GOODS->CurrentValue))) {
            $this->SIZE_GOODS->CurrentValue = ConvertToFloatString($this->SIZE_GOODS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_PRICE->FormValue == $this->ORDER_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_PRICE->CurrentValue))) {
            $this->ORDER_PRICE->CurrentValue = ConvertToFloatString($this->ORDER_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_AVAILABLE->FormValue == $this->STOCK_AVAILABLE->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_AVAILABLE->CurrentValue))) {
            $this->STOCK_AVAILABLE->CurrentValue = ConvertToFloatString($this->STOCK_AVAILABLE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->avgprice->FormValue == $this->avgprice->CurrentValue && is_numeric(ConvertToFloatString($this->avgprice->CurrentValue))) {
            $this->avgprice->CurrentValue = ConvertToFloatString($this->avgprice->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // ITEM_ID

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

            // BATCH_NO
            $this->BATCH_NO->LinkCustomAttributes = "";
            $this->BATCH_NO->HrefValue = "";
            $this->BATCH_NO->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";
            $this->ROOMS_ID->TooltipValue = "";

            // SHELF_NO
            $this->SHELF_NO->LinkCustomAttributes = "";
            $this->SHELF_NO->HrefValue = "";
            $this->SHELF_NO->TooltipValue = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";
            $this->EXPIRY_DATE->TooltipValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";
            $this->SERIAL_NB->TooltipValue = "";

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

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->LinkCustomAttributes = "";
            $this->ALLOCATED_FROM->HrefValue = "";
            $this->ALLOCATED_FROM->TooltipValue = "";

            // PRICE
            $this->PRICE->LinkCustomAttributes = "";
            $this->PRICE->HrefValue = "";
            $this->PRICE->TooltipValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";
            $this->DISCOUNT->TooltipValue = "";

            // DISCOUNT2
            $this->DISCOUNT2->LinkCustomAttributes = "";
            $this->DISCOUNT2->HrefValue = "";
            $this->DISCOUNT2->TooltipValue = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";
            $this->DISCOUNTOFF->TooltipValue = "";

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

            // STOCK_LALU
            $this->STOCK_LALU->LinkCustomAttributes = "";
            $this->STOCK_LALU->HrefValue = "";
            $this->STOCK_LALU->TooltipValue = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";
            $this->STOCK_KOREKSI->TooltipValue = "";

            // DITERIMA
            $this->DITERIMA->LinkCustomAttributes = "";
            $this->DITERIMA->HrefValue = "";
            $this->DITERIMA->TooltipValue = "";

            // DISTRIBUSI
            $this->DISTRIBUSI->LinkCustomAttributes = "";
            $this->DISTRIBUSI->HrefValue = "";
            $this->DISTRIBUSI->TooltipValue = "";

            // DIJUAL
            $this->DIJUAL->LinkCustomAttributes = "";
            $this->DIJUAL->HrefValue = "";
            $this->DIJUAL->TooltipValue = "";

            // DIHAPUS
            $this->DIHAPUS->LinkCustomAttributes = "";
            $this->DIHAPUS->HrefValue = "";
            $this->DIHAPUS->TooltipValue = "";

            // DIMINTA
            $this->DIMINTA->LinkCustomAttributes = "";
            $this->DIMINTA->HrefValue = "";
            $this->DIMINTA->TooltipValue = "";

            // DIRETUR
            $this->DIRETUR->LinkCustomAttributes = "";
            $this->DIRETUR->HrefValue = "";
            $this->DIRETUR->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";
            $this->FUND_ID->TooltipValue = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->LinkCustomAttributes = "";
            $this->INVOICE_ID2->HrefValue = "";
            $this->INVOICE_ID2->TooltipValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";
            $this->MEASURE_ID3->TooltipValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";
            $this->SIZE_KEMASAN->TooltipValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";
            $this->BRAND_NAME->TooltipValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";
            $this->MEASURE_ID2->TooltipValue = "";

            // RETUR_ID
            $this->RETUR_ID->LinkCustomAttributes = "";
            $this->RETUR_ID->HrefValue = "";
            $this->RETUR_ID->TooltipValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";
            $this->SIZE_GOODS->TooltipValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";
            $this->MEASURE_DOSIS->TooltipValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";
            $this->ORDER_PRICE->TooltipValue = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->LinkCustomAttributes = "";
            $this->STOCK_AVAILABLE->HrefValue = "";
            $this->STOCK_AVAILABLE->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";
            $this->MONTH_ID->TooltipValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";
            $this->YEAR_ID->TooltipValue = "";

            // CORRECTION_DOC
            $this->CORRECTION_DOC->LinkCustomAttributes = "";
            $this->CORRECTION_DOC->HrefValue = "";
            $this->CORRECTION_DOC->TooltipValue = "";

            // CORRECTIONS
            $this->CORRECTIONS->LinkCustomAttributes = "";
            $this->CORRECTIONS->HrefValue = "";
            $this->CORRECTIONS->TooltipValue = "";

            // CORRECTION_DATE
            $this->CORRECTION_DATE->LinkCustomAttributes = "";
            $this->CORRECTION_DATE->HrefValue = "";
            $this->CORRECTION_DATE->TooltipValue = "";

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

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";
            $this->PRINTED_BY->TooltipValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";
            $this->PRINTQ->TooltipValue = "";

            // avgprice
            $this->avgprice->LinkCustomAttributes = "";
            $this->avgprice->HrefValue = "";
            $this->avgprice->TooltipValue = "";
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

            // BATCH_NO
            $this->BATCH_NO->EditAttrs["class"] = "form-control";
            $this->BATCH_NO->EditCustomAttributes = "";
            if (!$this->BATCH_NO->Raw) {
                $this->BATCH_NO->CurrentValue = HtmlDecode($this->BATCH_NO->CurrentValue);
            }
            $this->BATCH_NO->EditValue = HtmlEncode($this->BATCH_NO->CurrentValue);
            $this->BATCH_NO->PlaceHolder = RemoveHtml($this->BATCH_NO->caption());

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

            // SHELF_NO
            $this->SHELF_NO->EditAttrs["class"] = "form-control";
            $this->SHELF_NO->EditCustomAttributes = "";
            $this->SHELF_NO->EditValue = HtmlEncode($this->SHELF_NO->CurrentValue);
            $this->SHELF_NO->PlaceHolder = RemoveHtml($this->SHELF_NO->caption());

            // EXPIRY_DATE
            $this->EXPIRY_DATE->EditAttrs["class"] = "form-control";
            $this->EXPIRY_DATE->EditCustomAttributes = "";
            $this->EXPIRY_DATE->EditValue = HtmlEncode(FormatDateTime($this->EXPIRY_DATE->CurrentValue, 8));
            $this->EXPIRY_DATE->PlaceHolder = RemoveHtml($this->EXPIRY_DATE->caption());

            // SERIAL_NB
            $this->SERIAL_NB->EditAttrs["class"] = "form-control";
            $this->SERIAL_NB->EditCustomAttributes = "";
            if (!$this->SERIAL_NB->Raw) {
                $this->SERIAL_NB->CurrentValue = HtmlDecode($this->SERIAL_NB->CurrentValue);
            }
            $this->SERIAL_NB->EditValue = HtmlEncode($this->SERIAL_NB->CurrentValue);
            $this->SERIAL_NB->PlaceHolder = RemoveHtml($this->SERIAL_NB->caption());

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

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->CurrentValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->EditAttrs["class"] = "form-control";
            $this->ALLOCATED_FROM->EditCustomAttributes = "";
            if (!$this->ALLOCATED_FROM->Raw) {
                $this->ALLOCATED_FROM->CurrentValue = HtmlDecode($this->ALLOCATED_FROM->CurrentValue);
            }
            $this->ALLOCATED_FROM->EditValue = HtmlEncode($this->ALLOCATED_FROM->CurrentValue);
            $this->ALLOCATED_FROM->PlaceHolder = RemoveHtml($this->ALLOCATED_FROM->caption());

            // PRICE
            $this->PRICE->EditAttrs["class"] = "form-control";
            $this->PRICE->EditCustomAttributes = "";
            $this->PRICE->EditValue = HtmlEncode($this->PRICE->CurrentValue);
            $this->PRICE->PlaceHolder = RemoveHtml($this->PRICE->caption());
            if (strval($this->PRICE->EditValue) != "" && is_numeric($this->PRICE->EditValue)) {
                $this->PRICE->EditValue = FormatNumber($this->PRICE->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT
            $this->DISCOUNT->EditAttrs["class"] = "form-control";
            $this->DISCOUNT->EditCustomAttributes = "";
            $this->DISCOUNT->EditValue = HtmlEncode($this->DISCOUNT->CurrentValue);
            $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
            if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
                $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT2
            $this->DISCOUNT2->EditAttrs["class"] = "form-control";
            $this->DISCOUNT2->EditCustomAttributes = "";
            $this->DISCOUNT2->EditValue = HtmlEncode($this->DISCOUNT2->CurrentValue);
            $this->DISCOUNT2->PlaceHolder = RemoveHtml($this->DISCOUNT2->caption());
            if (strval($this->DISCOUNT2->EditValue) != "" && is_numeric($this->DISCOUNT2->EditValue)) {
                $this->DISCOUNT2->EditValue = FormatNumber($this->DISCOUNT2->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNTOFF
            $this->DISCOUNTOFF->EditAttrs["class"] = "form-control";
            $this->DISCOUNTOFF->EditCustomAttributes = "";
            $this->DISCOUNTOFF->EditValue = HtmlEncode($this->DISCOUNTOFF->CurrentValue);
            $this->DISCOUNTOFF->PlaceHolder = RemoveHtml($this->DISCOUNTOFF->caption());
            if (strval($this->DISCOUNTOFF->EditValue) != "" && is_numeric($this->DISCOUNTOFF->EditValue)) {
                $this->DISCOUNTOFF->EditValue = FormatNumber($this->DISCOUNTOFF->EditValue, -2, -2, -2, -2);
            }

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

            // STOCK_LALU
            $this->STOCK_LALU->EditAttrs["class"] = "form-control";
            $this->STOCK_LALU->EditCustomAttributes = "";
            $this->STOCK_LALU->EditValue = HtmlEncode($this->STOCK_LALU->CurrentValue);
            $this->STOCK_LALU->PlaceHolder = RemoveHtml($this->STOCK_LALU->caption());
            if (strval($this->STOCK_LALU->EditValue) != "" && is_numeric($this->STOCK_LALU->EditValue)) {
                $this->STOCK_LALU->EditValue = FormatNumber($this->STOCK_LALU->EditValue, -2, -2, -2, -2);
            }

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->EditAttrs["class"] = "form-control";
            $this->STOCK_KOREKSI->EditCustomAttributes = "";
            $this->STOCK_KOREKSI->EditValue = HtmlEncode($this->STOCK_KOREKSI->CurrentValue);
            $this->STOCK_KOREKSI->PlaceHolder = RemoveHtml($this->STOCK_KOREKSI->caption());
            if (strval($this->STOCK_KOREKSI->EditValue) != "" && is_numeric($this->STOCK_KOREKSI->EditValue)) {
                $this->STOCK_KOREKSI->EditValue = FormatNumber($this->STOCK_KOREKSI->EditValue, -2, -2, -2, -2);
            }

            // DITERIMA
            $this->DITERIMA->EditAttrs["class"] = "form-control";
            $this->DITERIMA->EditCustomAttributes = "";
            $this->DITERIMA->EditValue = HtmlEncode($this->DITERIMA->CurrentValue);
            $this->DITERIMA->PlaceHolder = RemoveHtml($this->DITERIMA->caption());
            if (strval($this->DITERIMA->EditValue) != "" && is_numeric($this->DITERIMA->EditValue)) {
                $this->DITERIMA->EditValue = FormatNumber($this->DITERIMA->EditValue, -2, -2, -2, -2);
            }

            // DISTRIBUSI
            $this->DISTRIBUSI->EditAttrs["class"] = "form-control";
            $this->DISTRIBUSI->EditCustomAttributes = "";
            $this->DISTRIBUSI->EditValue = HtmlEncode($this->DISTRIBUSI->CurrentValue);
            $this->DISTRIBUSI->PlaceHolder = RemoveHtml($this->DISTRIBUSI->caption());
            if (strval($this->DISTRIBUSI->EditValue) != "" && is_numeric($this->DISTRIBUSI->EditValue)) {
                $this->DISTRIBUSI->EditValue = FormatNumber($this->DISTRIBUSI->EditValue, -2, -2, -2, -2);
            }

            // DIJUAL
            $this->DIJUAL->EditAttrs["class"] = "form-control";
            $this->DIJUAL->EditCustomAttributes = "";
            $this->DIJUAL->EditValue = HtmlEncode($this->DIJUAL->CurrentValue);
            $this->DIJUAL->PlaceHolder = RemoveHtml($this->DIJUAL->caption());
            if (strval($this->DIJUAL->EditValue) != "" && is_numeric($this->DIJUAL->EditValue)) {
                $this->DIJUAL->EditValue = FormatNumber($this->DIJUAL->EditValue, -2, -2, -2, -2);
            }

            // DIHAPUS
            $this->DIHAPUS->EditAttrs["class"] = "form-control";
            $this->DIHAPUS->EditCustomAttributes = "";
            $this->DIHAPUS->EditValue = HtmlEncode($this->DIHAPUS->CurrentValue);
            $this->DIHAPUS->PlaceHolder = RemoveHtml($this->DIHAPUS->caption());
            if (strval($this->DIHAPUS->EditValue) != "" && is_numeric($this->DIHAPUS->EditValue)) {
                $this->DIHAPUS->EditValue = FormatNumber($this->DIHAPUS->EditValue, -2, -2, -2, -2);
            }

            // DIMINTA
            $this->DIMINTA->EditAttrs["class"] = "form-control";
            $this->DIMINTA->EditCustomAttributes = "";
            $this->DIMINTA->EditValue = HtmlEncode($this->DIMINTA->CurrentValue);
            $this->DIMINTA->PlaceHolder = RemoveHtml($this->DIMINTA->caption());
            if (strval($this->DIMINTA->EditValue) != "" && is_numeric($this->DIMINTA->EditValue)) {
                $this->DIMINTA->EditValue = FormatNumber($this->DIMINTA->EditValue, -2, -2, -2, -2);
            }

            // DIRETUR
            $this->DIRETUR->EditAttrs["class"] = "form-control";
            $this->DIRETUR->EditCustomAttributes = "";
            $this->DIRETUR->EditValue = HtmlEncode($this->DIRETUR->CurrentValue);
            $this->DIRETUR->PlaceHolder = RemoveHtml($this->DIRETUR->caption());
            if (strval($this->DIRETUR->EditValue) != "" && is_numeric($this->DIRETUR->EditValue)) {
                $this->DIRETUR->EditValue = FormatNumber($this->DIRETUR->EditValue, -2, -2, -2, -2);
            }

            // PO
            $this->PO->EditAttrs["class"] = "form-control";
            $this->PO->EditCustomAttributes = "";
            if (!$this->PO->Raw) {
                $this->PO->CurrentValue = HtmlDecode($this->PO->CurrentValue);
            }
            $this->PO->EditValue = HtmlEncode($this->PO->CurrentValue);
            $this->PO->PlaceHolder = RemoveHtml($this->PO->caption());

            // COMPANY_ID
            $this->COMPANY_ID->EditAttrs["class"] = "form-control";
            $this->COMPANY_ID->EditCustomAttributes = "";
            if (!$this->COMPANY_ID->Raw) {
                $this->COMPANY_ID->CurrentValue = HtmlDecode($this->COMPANY_ID->CurrentValue);
            }
            $this->COMPANY_ID->EditValue = HtmlEncode($this->COMPANY_ID->CurrentValue);
            $this->COMPANY_ID->PlaceHolder = RemoveHtml($this->COMPANY_ID->caption());

            // FUND_ID
            $this->FUND_ID->EditAttrs["class"] = "form-control";
            $this->FUND_ID->EditCustomAttributes = "";
            $this->FUND_ID->EditValue = HtmlEncode($this->FUND_ID->CurrentValue);
            $this->FUND_ID->PlaceHolder = RemoveHtml($this->FUND_ID->caption());

            // INVOICE_ID2
            $this->INVOICE_ID2->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID2->EditCustomAttributes = "";
            if (!$this->INVOICE_ID2->Raw) {
                $this->INVOICE_ID2->CurrentValue = HtmlDecode($this->INVOICE_ID2->CurrentValue);
            }
            $this->INVOICE_ID2->EditValue = HtmlEncode($this->INVOICE_ID2->CurrentValue);
            $this->INVOICE_ID2->PlaceHolder = RemoveHtml($this->INVOICE_ID2->caption());

            // MEASURE_ID3
            $this->MEASURE_ID3->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID3->EditCustomAttributes = "";
            $this->MEASURE_ID3->EditValue = HtmlEncode($this->MEASURE_ID3->CurrentValue);
            $this->MEASURE_ID3->PlaceHolder = RemoveHtml($this->MEASURE_ID3->caption());

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->EditAttrs["class"] = "form-control";
            $this->SIZE_KEMASAN->EditCustomAttributes = "";
            $this->SIZE_KEMASAN->EditValue = HtmlEncode($this->SIZE_KEMASAN->CurrentValue);
            $this->SIZE_KEMASAN->PlaceHolder = RemoveHtml($this->SIZE_KEMASAN->caption());
            if (strval($this->SIZE_KEMASAN->EditValue) != "" && is_numeric($this->SIZE_KEMASAN->EditValue)) {
                $this->SIZE_KEMASAN->EditValue = FormatNumber($this->SIZE_KEMASAN->EditValue, -2, -2, -2, -2);
            }

            // BRAND_NAME
            $this->BRAND_NAME->EditAttrs["class"] = "form-control";
            $this->BRAND_NAME->EditCustomAttributes = "";
            if (!$this->BRAND_NAME->Raw) {
                $this->BRAND_NAME->CurrentValue = HtmlDecode($this->BRAND_NAME->CurrentValue);
            }
            $this->BRAND_NAME->EditValue = HtmlEncode($this->BRAND_NAME->CurrentValue);
            $this->BRAND_NAME->PlaceHolder = RemoveHtml($this->BRAND_NAME->caption());

            // MEASURE_ID2
            $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID2->EditCustomAttributes = "";
            $this->MEASURE_ID2->EditValue = HtmlEncode($this->MEASURE_ID2->CurrentValue);
            $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

            // RETUR_ID
            $this->RETUR_ID->EditAttrs["class"] = "form-control";
            $this->RETUR_ID->EditCustomAttributes = "";
            if (!$this->RETUR_ID->Raw) {
                $this->RETUR_ID->CurrentValue = HtmlDecode($this->RETUR_ID->CurrentValue);
            }
            $this->RETUR_ID->EditValue = HtmlEncode($this->RETUR_ID->CurrentValue);
            $this->RETUR_ID->PlaceHolder = RemoveHtml($this->RETUR_ID->caption());

            // SIZE_GOODS
            $this->SIZE_GOODS->EditAttrs["class"] = "form-control";
            $this->SIZE_GOODS->EditCustomAttributes = "";
            $this->SIZE_GOODS->EditValue = HtmlEncode($this->SIZE_GOODS->CurrentValue);
            $this->SIZE_GOODS->PlaceHolder = RemoveHtml($this->SIZE_GOODS->caption());
            if (strval($this->SIZE_GOODS->EditValue) != "" && is_numeric($this->SIZE_GOODS->EditValue)) {
                $this->SIZE_GOODS->EditValue = FormatNumber($this->SIZE_GOODS->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->EditAttrs["class"] = "form-control";
            $this->MEASURE_DOSIS->EditCustomAttributes = "";
            $this->MEASURE_DOSIS->EditValue = HtmlEncode($this->MEASURE_DOSIS->CurrentValue);
            $this->MEASURE_DOSIS->PlaceHolder = RemoveHtml($this->MEASURE_DOSIS->caption());

            // ORDER_PRICE
            $this->ORDER_PRICE->EditAttrs["class"] = "form-control";
            $this->ORDER_PRICE->EditCustomAttributes = "";
            $this->ORDER_PRICE->EditValue = HtmlEncode($this->ORDER_PRICE->CurrentValue);
            $this->ORDER_PRICE->PlaceHolder = RemoveHtml($this->ORDER_PRICE->caption());
            if (strval($this->ORDER_PRICE->EditValue) != "" && is_numeric($this->ORDER_PRICE->EditValue)) {
                $this->ORDER_PRICE->EditValue = FormatNumber($this->ORDER_PRICE->EditValue, -2, -2, -2, -2);
            }

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->EditAttrs["class"] = "form-control";
            $this->STOCK_AVAILABLE->EditCustomAttributes = "";
            $this->STOCK_AVAILABLE->EditValue = HtmlEncode($this->STOCK_AVAILABLE->CurrentValue);
            $this->STOCK_AVAILABLE->PlaceHolder = RemoveHtml($this->STOCK_AVAILABLE->caption());
            if (strval($this->STOCK_AVAILABLE->EditValue) != "" && is_numeric($this->STOCK_AVAILABLE->EditValue)) {
                $this->STOCK_AVAILABLE->EditValue = FormatNumber($this->STOCK_AVAILABLE->EditValue, -2, -2, -2, -2);
            }

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $this->STATUS_PASIEN_ID->EditValue = HtmlEncode($this->STATUS_PASIEN_ID->CurrentValue);
            $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

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

            // CORRECTION_DOC
            $this->CORRECTION_DOC->EditAttrs["class"] = "form-control";
            $this->CORRECTION_DOC->EditCustomAttributes = "";
            if (!$this->CORRECTION_DOC->Raw) {
                $this->CORRECTION_DOC->CurrentValue = HtmlDecode($this->CORRECTION_DOC->CurrentValue);
            }
            $this->CORRECTION_DOC->EditValue = HtmlEncode($this->CORRECTION_DOC->CurrentValue);
            $this->CORRECTION_DOC->PlaceHolder = RemoveHtml($this->CORRECTION_DOC->caption());

            // CORRECTIONS
            $this->CORRECTIONS->EditAttrs["class"] = "form-control";
            $this->CORRECTIONS->EditCustomAttributes = "";
            if (!$this->CORRECTIONS->Raw) {
                $this->CORRECTIONS->CurrentValue = HtmlDecode($this->CORRECTIONS->CurrentValue);
            }
            $this->CORRECTIONS->EditValue = HtmlEncode($this->CORRECTIONS->CurrentValue);
            $this->CORRECTIONS->PlaceHolder = RemoveHtml($this->CORRECTIONS->caption());

            // CORRECTION_DATE

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

            // PRINT_DATE

            // PRINTED_BY

            // PRINTQ
            $this->PRINTQ->EditAttrs["class"] = "form-control";
            $this->PRINTQ->EditCustomAttributes = "";
            $this->PRINTQ->EditValue = HtmlEncode($this->PRINTQ->CurrentValue);
            $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

            // avgprice
            $this->avgprice->EditAttrs["class"] = "form-control";
            $this->avgprice->EditCustomAttributes = "";
            $this->avgprice->EditValue = HtmlEncode($this->avgprice->CurrentValue);
            $this->avgprice->PlaceHolder = RemoveHtml($this->avgprice->caption());
            if (strval($this->avgprice->EditValue) != "" && is_numeric($this->avgprice->EditValue)) {
                $this->avgprice->EditValue = FormatNumber($this->avgprice->EditValue, -2, -2, -2, -2);
            }

            // Add refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";

            // BATCH_NO
            $this->BATCH_NO->LinkCustomAttributes = "";
            $this->BATCH_NO->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";

            // SHELF_NO
            $this->SHELF_NO->LinkCustomAttributes = "";
            $this->SHELF_NO->HrefValue = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";

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

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";

            // ALLOCATED_FROM
            $this->ALLOCATED_FROM->LinkCustomAttributes = "";
            $this->ALLOCATED_FROM->HrefValue = "";

            // PRICE
            $this->PRICE->LinkCustomAttributes = "";
            $this->PRICE->HrefValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";

            // DISCOUNT2
            $this->DISCOUNT2->LinkCustomAttributes = "";
            $this->DISCOUNT2->HrefValue = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";

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

            // STOCK_LALU
            $this->STOCK_LALU->LinkCustomAttributes = "";
            $this->STOCK_LALU->HrefValue = "";

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";

            // DITERIMA
            $this->DITERIMA->LinkCustomAttributes = "";
            $this->DITERIMA->HrefValue = "";

            // DISTRIBUSI
            $this->DISTRIBUSI->LinkCustomAttributes = "";
            $this->DISTRIBUSI->HrefValue = "";

            // DIJUAL
            $this->DIJUAL->LinkCustomAttributes = "";
            $this->DIJUAL->HrefValue = "";

            // DIHAPUS
            $this->DIHAPUS->LinkCustomAttributes = "";
            $this->DIHAPUS->HrefValue = "";

            // DIMINTA
            $this->DIMINTA->LinkCustomAttributes = "";
            $this->DIMINTA->HrefValue = "";

            // DIRETUR
            $this->DIRETUR->LinkCustomAttributes = "";
            $this->DIRETUR->HrefValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";

            // FUND_ID
            $this->FUND_ID->LinkCustomAttributes = "";
            $this->FUND_ID->HrefValue = "";

            // INVOICE_ID2
            $this->INVOICE_ID2->LinkCustomAttributes = "";
            $this->INVOICE_ID2->HrefValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";

            // RETUR_ID
            $this->RETUR_ID->LinkCustomAttributes = "";
            $this->RETUR_ID->HrefValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";

            // STOCK_AVAILABLE
            $this->STOCK_AVAILABLE->LinkCustomAttributes = "";
            $this->STOCK_AVAILABLE->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";

            // CORRECTION_DOC
            $this->CORRECTION_DOC->LinkCustomAttributes = "";
            $this->CORRECTION_DOC->HrefValue = "";

            // CORRECTIONS
            $this->CORRECTIONS->LinkCustomAttributes = "";
            $this->CORRECTIONS->HrefValue = "";

            // CORRECTION_DATE
            $this->CORRECTION_DATE->LinkCustomAttributes = "";
            $this->CORRECTION_DATE->HrefValue = "";

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";

            // ORDER_ID
            $this->ORDER_ID->LinkCustomAttributes = "";
            $this->ORDER_ID->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";

            // avgprice
            $this->avgprice->LinkCustomAttributes = "";
            $this->avgprice->HrefValue = "";
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
        if ($this->BATCH_NO->Required) {
            if (!$this->BATCH_NO->IsDetailKey && EmptyValue($this->BATCH_NO->FormValue)) {
                $this->BATCH_NO->addErrorMessage(str_replace("%s", $this->BATCH_NO->caption(), $this->BATCH_NO->RequiredErrorMessage));
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
        if ($this->SHELF_NO->Required) {
            if (!$this->SHELF_NO->IsDetailKey && EmptyValue($this->SHELF_NO->FormValue)) {
                $this->SHELF_NO->addErrorMessage(str_replace("%s", $this->SHELF_NO->caption(), $this->SHELF_NO->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->SHELF_NO->FormValue)) {
            $this->SHELF_NO->addErrorMessage($this->SHELF_NO->getErrorMessage(false));
        }
        if ($this->EXPIRY_DATE->Required) {
            if (!$this->EXPIRY_DATE->IsDetailKey && EmptyValue($this->EXPIRY_DATE->FormValue)) {
                $this->EXPIRY_DATE->addErrorMessage(str_replace("%s", $this->EXPIRY_DATE->caption(), $this->EXPIRY_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->EXPIRY_DATE->FormValue)) {
            $this->EXPIRY_DATE->addErrorMessage($this->EXPIRY_DATE->getErrorMessage(false));
        }
        if ($this->SERIAL_NB->Required) {
            if (!$this->SERIAL_NB->IsDetailKey && EmptyValue($this->SERIAL_NB->FormValue)) {
                $this->SERIAL_NB->addErrorMessage(str_replace("%s", $this->SERIAL_NB->caption(), $this->SERIAL_NB->RequiredErrorMessage));
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
        if ($this->INVOICE_ID->Required) {
            if (!$this->INVOICE_ID->IsDetailKey && EmptyValue($this->INVOICE_ID->FormValue)) {
                $this->INVOICE_ID->addErrorMessage(str_replace("%s", $this->INVOICE_ID->caption(), $this->INVOICE_ID->RequiredErrorMessage));
            }
        }
        if ($this->ALLOCATED_FROM->Required) {
            if (!$this->ALLOCATED_FROM->IsDetailKey && EmptyValue($this->ALLOCATED_FROM->FormValue)) {
                $this->ALLOCATED_FROM->addErrorMessage(str_replace("%s", $this->ALLOCATED_FROM->caption(), $this->ALLOCATED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->PRICE->Required) {
            if (!$this->PRICE->IsDetailKey && EmptyValue($this->PRICE->FormValue)) {
                $this->PRICE->addErrorMessage(str_replace("%s", $this->PRICE->caption(), $this->PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PRICE->FormValue)) {
            $this->PRICE->addErrorMessage($this->PRICE->getErrorMessage(false));
        }
        if ($this->DISCOUNT->Required) {
            if (!$this->DISCOUNT->IsDetailKey && EmptyValue($this->DISCOUNT->FormValue)) {
                $this->DISCOUNT->addErrorMessage(str_replace("%s", $this->DISCOUNT->caption(), $this->DISCOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT->FormValue)) {
            $this->DISCOUNT->addErrorMessage($this->DISCOUNT->getErrorMessage(false));
        }
        if ($this->DISCOUNT2->Required) {
            if (!$this->DISCOUNT2->IsDetailKey && EmptyValue($this->DISCOUNT2->FormValue)) {
                $this->DISCOUNT2->addErrorMessage(str_replace("%s", $this->DISCOUNT2->caption(), $this->DISCOUNT2->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT2->FormValue)) {
            $this->DISCOUNT2->addErrorMessage($this->DISCOUNT2->getErrorMessage(false));
        }
        if ($this->DISCOUNTOFF->Required) {
            if (!$this->DISCOUNTOFF->IsDetailKey && EmptyValue($this->DISCOUNTOFF->FormValue)) {
                $this->DISCOUNTOFF->addErrorMessage(str_replace("%s", $this->DISCOUNTOFF->caption(), $this->DISCOUNTOFF->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNTOFF->FormValue)) {
            $this->DISCOUNTOFF->addErrorMessage($this->DISCOUNTOFF->getErrorMessage(false));
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
        if ($this->STOCK_LALU->Required) {
            if (!$this->STOCK_LALU->IsDetailKey && EmptyValue($this->STOCK_LALU->FormValue)) {
                $this->STOCK_LALU->addErrorMessage(str_replace("%s", $this->STOCK_LALU->caption(), $this->STOCK_LALU->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_LALU->FormValue)) {
            $this->STOCK_LALU->addErrorMessage($this->STOCK_LALU->getErrorMessage(false));
        }
        if ($this->STOCK_KOREKSI->Required) {
            if (!$this->STOCK_KOREKSI->IsDetailKey && EmptyValue($this->STOCK_KOREKSI->FormValue)) {
                $this->STOCK_KOREKSI->addErrorMessage(str_replace("%s", $this->STOCK_KOREKSI->caption(), $this->STOCK_KOREKSI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_KOREKSI->FormValue)) {
            $this->STOCK_KOREKSI->addErrorMessage($this->STOCK_KOREKSI->getErrorMessage(false));
        }
        if ($this->DITERIMA->Required) {
            if (!$this->DITERIMA->IsDetailKey && EmptyValue($this->DITERIMA->FormValue)) {
                $this->DITERIMA->addErrorMessage(str_replace("%s", $this->DITERIMA->caption(), $this->DITERIMA->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DITERIMA->FormValue)) {
            $this->DITERIMA->addErrorMessage($this->DITERIMA->getErrorMessage(false));
        }
        if ($this->DISTRIBUSI->Required) {
            if (!$this->DISTRIBUSI->IsDetailKey && EmptyValue($this->DISTRIBUSI->FormValue)) {
                $this->DISTRIBUSI->addErrorMessage(str_replace("%s", $this->DISTRIBUSI->caption(), $this->DISTRIBUSI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISTRIBUSI->FormValue)) {
            $this->DISTRIBUSI->addErrorMessage($this->DISTRIBUSI->getErrorMessage(false));
        }
        if ($this->DIJUAL->Required) {
            if (!$this->DIJUAL->IsDetailKey && EmptyValue($this->DIJUAL->FormValue)) {
                $this->DIJUAL->addErrorMessage(str_replace("%s", $this->DIJUAL->caption(), $this->DIJUAL->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DIJUAL->FormValue)) {
            $this->DIJUAL->addErrorMessage($this->DIJUAL->getErrorMessage(false));
        }
        if ($this->DIHAPUS->Required) {
            if (!$this->DIHAPUS->IsDetailKey && EmptyValue($this->DIHAPUS->FormValue)) {
                $this->DIHAPUS->addErrorMessage(str_replace("%s", $this->DIHAPUS->caption(), $this->DIHAPUS->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DIHAPUS->FormValue)) {
            $this->DIHAPUS->addErrorMessage($this->DIHAPUS->getErrorMessage(false));
        }
        if ($this->DIMINTA->Required) {
            if (!$this->DIMINTA->IsDetailKey && EmptyValue($this->DIMINTA->FormValue)) {
                $this->DIMINTA->addErrorMessage(str_replace("%s", $this->DIMINTA->caption(), $this->DIMINTA->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DIMINTA->FormValue)) {
            $this->DIMINTA->addErrorMessage($this->DIMINTA->getErrorMessage(false));
        }
        if ($this->DIRETUR->Required) {
            if (!$this->DIRETUR->IsDetailKey && EmptyValue($this->DIRETUR->FormValue)) {
                $this->DIRETUR->addErrorMessage(str_replace("%s", $this->DIRETUR->caption(), $this->DIRETUR->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DIRETUR->FormValue)) {
            $this->DIRETUR->addErrorMessage($this->DIRETUR->getErrorMessage(false));
        }
        if ($this->PO->Required) {
            if (!$this->PO->IsDetailKey && EmptyValue($this->PO->FormValue)) {
                $this->PO->addErrorMessage(str_replace("%s", $this->PO->caption(), $this->PO->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_ID->Required) {
            if (!$this->COMPANY_ID->IsDetailKey && EmptyValue($this->COMPANY_ID->FormValue)) {
                $this->COMPANY_ID->addErrorMessage(str_replace("%s", $this->COMPANY_ID->caption(), $this->COMPANY_ID->RequiredErrorMessage));
            }
        }
        if ($this->FUND_ID->Required) {
            if (!$this->FUND_ID->IsDetailKey && EmptyValue($this->FUND_ID->FormValue)) {
                $this->FUND_ID->addErrorMessage(str_replace("%s", $this->FUND_ID->caption(), $this->FUND_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FUND_ID->FormValue)) {
            $this->FUND_ID->addErrorMessage($this->FUND_ID->getErrorMessage(false));
        }
        if ($this->INVOICE_ID2->Required) {
            if (!$this->INVOICE_ID2->IsDetailKey && EmptyValue($this->INVOICE_ID2->FormValue)) {
                $this->INVOICE_ID2->addErrorMessage(str_replace("%s", $this->INVOICE_ID2->caption(), $this->INVOICE_ID2->RequiredErrorMessage));
            }
        }
        if ($this->MEASURE_ID3->Required) {
            if (!$this->MEASURE_ID3->IsDetailKey && EmptyValue($this->MEASURE_ID3->FormValue)) {
                $this->MEASURE_ID3->addErrorMessage(str_replace("%s", $this->MEASURE_ID3->caption(), $this->MEASURE_ID3->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID3->FormValue)) {
            $this->MEASURE_ID3->addErrorMessage($this->MEASURE_ID3->getErrorMessage(false));
        }
        if ($this->SIZE_KEMASAN->Required) {
            if (!$this->SIZE_KEMASAN->IsDetailKey && EmptyValue($this->SIZE_KEMASAN->FormValue)) {
                $this->SIZE_KEMASAN->addErrorMessage(str_replace("%s", $this->SIZE_KEMASAN->caption(), $this->SIZE_KEMASAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_KEMASAN->FormValue)) {
            $this->SIZE_KEMASAN->addErrorMessage($this->SIZE_KEMASAN->getErrorMessage(false));
        }
        if ($this->BRAND_NAME->Required) {
            if (!$this->BRAND_NAME->IsDetailKey && EmptyValue($this->BRAND_NAME->FormValue)) {
                $this->BRAND_NAME->addErrorMessage(str_replace("%s", $this->BRAND_NAME->caption(), $this->BRAND_NAME->RequiredErrorMessage));
            }
        }
        if ($this->MEASURE_ID2->Required) {
            if (!$this->MEASURE_ID2->IsDetailKey && EmptyValue($this->MEASURE_ID2->FormValue)) {
                $this->MEASURE_ID2->addErrorMessage(str_replace("%s", $this->MEASURE_ID2->caption(), $this->MEASURE_ID2->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID2->FormValue)) {
            $this->MEASURE_ID2->addErrorMessage($this->MEASURE_ID2->getErrorMessage(false));
        }
        if ($this->RETUR_ID->Required) {
            if (!$this->RETUR_ID->IsDetailKey && EmptyValue($this->RETUR_ID->FormValue)) {
                $this->RETUR_ID->addErrorMessage(str_replace("%s", $this->RETUR_ID->caption(), $this->RETUR_ID->RequiredErrorMessage));
            }
        }
        if ($this->SIZE_GOODS->Required) {
            if (!$this->SIZE_GOODS->IsDetailKey && EmptyValue($this->SIZE_GOODS->FormValue)) {
                $this->SIZE_GOODS->addErrorMessage(str_replace("%s", $this->SIZE_GOODS->caption(), $this->SIZE_GOODS->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_GOODS->FormValue)) {
            $this->SIZE_GOODS->addErrorMessage($this->SIZE_GOODS->getErrorMessage(false));
        }
        if ($this->MEASURE_DOSIS->Required) {
            if (!$this->MEASURE_DOSIS->IsDetailKey && EmptyValue($this->MEASURE_DOSIS->FormValue)) {
                $this->MEASURE_DOSIS->addErrorMessage(str_replace("%s", $this->MEASURE_DOSIS->caption(), $this->MEASURE_DOSIS->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_DOSIS->FormValue)) {
            $this->MEASURE_DOSIS->addErrorMessage($this->MEASURE_DOSIS->getErrorMessage(false));
        }
        if ($this->ORDER_PRICE->Required) {
            if (!$this->ORDER_PRICE->IsDetailKey && EmptyValue($this->ORDER_PRICE->FormValue)) {
                $this->ORDER_PRICE->addErrorMessage(str_replace("%s", $this->ORDER_PRICE->caption(), $this->ORDER_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_PRICE->FormValue)) {
            $this->ORDER_PRICE->addErrorMessage($this->ORDER_PRICE->getErrorMessage(false));
        }
        if ($this->STOCK_AVAILABLE->Required) {
            if (!$this->STOCK_AVAILABLE->IsDetailKey && EmptyValue($this->STOCK_AVAILABLE->FormValue)) {
                $this->STOCK_AVAILABLE->addErrorMessage(str_replace("%s", $this->STOCK_AVAILABLE->caption(), $this->STOCK_AVAILABLE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_AVAILABLE->FormValue)) {
            $this->STOCK_AVAILABLE->addErrorMessage($this->STOCK_AVAILABLE->getErrorMessage(false));
        }
        if ($this->STATUS_PASIEN_ID->Required) {
            if (!$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_PASIEN_ID->FormValue)) {
            $this->STATUS_PASIEN_ID->addErrorMessage($this->STATUS_PASIEN_ID->getErrorMessage(false));
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
        if ($this->CORRECTION_DOC->Required) {
            if (!$this->CORRECTION_DOC->IsDetailKey && EmptyValue($this->CORRECTION_DOC->FormValue)) {
                $this->CORRECTION_DOC->addErrorMessage(str_replace("%s", $this->CORRECTION_DOC->caption(), $this->CORRECTION_DOC->RequiredErrorMessage));
            }
        }
        if ($this->CORRECTIONS->Required) {
            if (!$this->CORRECTIONS->IsDetailKey && EmptyValue($this->CORRECTIONS->FormValue)) {
                $this->CORRECTIONS->addErrorMessage(str_replace("%s", $this->CORRECTIONS->caption(), $this->CORRECTIONS->RequiredErrorMessage));
            }
        }
        if ($this->CORRECTION_DATE->Required) {
            if (!$this->CORRECTION_DATE->IsDetailKey && EmptyValue($this->CORRECTION_DATE->FormValue)) {
                $this->CORRECTION_DATE->addErrorMessage(str_replace("%s", $this->CORRECTION_DATE->caption(), $this->CORRECTION_DATE->RequiredErrorMessage));
            }
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
        if ($this->PRINT_DATE->Required) {
            if (!$this->PRINT_DATE->IsDetailKey && EmptyValue($this->PRINT_DATE->FormValue)) {
                $this->PRINT_DATE->addErrorMessage(str_replace("%s", $this->PRINT_DATE->caption(), $this->PRINT_DATE->RequiredErrorMessage));
            }
        }
        if ($this->PRINTED_BY->Required) {
            if (!$this->PRINTED_BY->IsDetailKey && EmptyValue($this->PRINTED_BY->FormValue)) {
                $this->PRINTED_BY->addErrorMessage(str_replace("%s", $this->PRINTED_BY->caption(), $this->PRINTED_BY->RequiredErrorMessage));
            }
        }
        if ($this->PRINTQ->Required) {
            if (!$this->PRINTQ->IsDetailKey && EmptyValue($this->PRINTQ->FormValue)) {
                $this->PRINTQ->addErrorMessage(str_replace("%s", $this->PRINTQ->caption(), $this->PRINTQ->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PRINTQ->FormValue)) {
            $this->PRINTQ->addErrorMessage($this->PRINTQ->getErrorMessage(false));
        }
        if ($this->avgprice->Required) {
            if (!$this->avgprice->IsDetailKey && EmptyValue($this->avgprice->FormValue)) {
                $this->avgprice->addErrorMessage(str_replace("%s", $this->avgprice->caption(), $this->avgprice->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->avgprice->FormValue)) {
            $this->avgprice->addErrorMessage($this->avgprice->getErrorMessage(false));
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

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // ORG_UNIT_CODE
        $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, null, false);

        // ORG_ID
        $this->ORG_ID->setDbValueDef($rsnew, $this->ORG_ID->CurrentValue, null, false);

        // BATCH_NO
        $this->BATCH_NO->setDbValueDef($rsnew, $this->BATCH_NO->CurrentValue, null, false);

        // BRAND_ID
        $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", false);

        // ROOMS_ID
        $this->ROOMS_ID->setDbValueDef($rsnew, $this->ROOMS_ID->CurrentValue, "", false);

        // SHELF_NO
        $this->SHELF_NO->setDbValueDef($rsnew, $this->SHELF_NO->CurrentValue, null, false);

        // EXPIRY_DATE
        $this->EXPIRY_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0), null, false);

        // SERIAL_NB
        $this->SERIAL_NB->setDbValueDef($rsnew, $this->SERIAL_NB->CurrentValue, null, false);

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

        // INVOICE_ID
        $this->INVOICE_ID->setDbValueDef($rsnew, $this->INVOICE_ID->CurrentValue, null, false);

        // ALLOCATED_FROM
        $this->ALLOCATED_FROM->setDbValueDef($rsnew, $this->ALLOCATED_FROM->CurrentValue, null, false);

        // PRICE
        $this->PRICE->setDbValueDef($rsnew, $this->PRICE->CurrentValue, null, false);

        // DISCOUNT
        $this->DISCOUNT->setDbValueDef($rsnew, $this->DISCOUNT->CurrentValue, null, false);

        // DISCOUNT2
        $this->DISCOUNT2->setDbValueDef($rsnew, $this->DISCOUNT2->CurrentValue, null, false);

        // DISCOUNTOFF
        $this->DISCOUNTOFF->setDbValueDef($rsnew, $this->DISCOUNTOFF->CurrentValue, null, false);

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

        // STOCK_LALU
        $this->STOCK_LALU->setDbValueDef($rsnew, $this->STOCK_LALU->CurrentValue, null, false);

        // STOCK_KOREKSI
        $this->STOCK_KOREKSI->setDbValueDef($rsnew, $this->STOCK_KOREKSI->CurrentValue, null, false);

        // DITERIMA
        $this->DITERIMA->setDbValueDef($rsnew, $this->DITERIMA->CurrentValue, null, false);

        // DISTRIBUSI
        $this->DISTRIBUSI->setDbValueDef($rsnew, $this->DISTRIBUSI->CurrentValue, null, false);

        // DIJUAL
        $this->DIJUAL->setDbValueDef($rsnew, $this->DIJUAL->CurrentValue, null, false);

        // DIHAPUS
        $this->DIHAPUS->setDbValueDef($rsnew, $this->DIHAPUS->CurrentValue, null, false);

        // DIMINTA
        $this->DIMINTA->setDbValueDef($rsnew, $this->DIMINTA->CurrentValue, null, false);

        // DIRETUR
        $this->DIRETUR->setDbValueDef($rsnew, $this->DIRETUR->CurrentValue, null, false);

        // PO
        $this->PO->setDbValueDef($rsnew, $this->PO->CurrentValue, null, false);

        // COMPANY_ID
        $this->COMPANY_ID->setDbValueDef($rsnew, $this->COMPANY_ID->CurrentValue, null, false);

        // FUND_ID
        $this->FUND_ID->setDbValueDef($rsnew, $this->FUND_ID->CurrentValue, null, false);

        // INVOICE_ID2
        $this->INVOICE_ID2->setDbValueDef($rsnew, $this->INVOICE_ID2->CurrentValue, null, false);

        // MEASURE_ID3
        $this->MEASURE_ID3->setDbValueDef($rsnew, $this->MEASURE_ID3->CurrentValue, null, false);

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN->setDbValueDef($rsnew, $this->SIZE_KEMASAN->CurrentValue, null, false);

        // BRAND_NAME
        $this->BRAND_NAME->setDbValueDef($rsnew, $this->BRAND_NAME->CurrentValue, null, false);

        // MEASURE_ID2
        $this->MEASURE_ID2->setDbValueDef($rsnew, $this->MEASURE_ID2->CurrentValue, null, false);

        // RETUR_ID
        $this->RETUR_ID->setDbValueDef($rsnew, $this->RETUR_ID->CurrentValue, null, false);

        // SIZE_GOODS
        $this->SIZE_GOODS->setDbValueDef($rsnew, $this->SIZE_GOODS->CurrentValue, null, false);

        // MEASURE_DOSIS
        $this->MEASURE_DOSIS->setDbValueDef($rsnew, $this->MEASURE_DOSIS->CurrentValue, null, false);

        // ORDER_PRICE
        $this->ORDER_PRICE->setDbValueDef($rsnew, $this->ORDER_PRICE->CurrentValue, null, false);

        // STOCK_AVAILABLE
        $this->STOCK_AVAILABLE->setDbValueDef($rsnew, $this->STOCK_AVAILABLE->CurrentValue, null, false);

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->setDbValueDef($rsnew, $this->STATUS_PASIEN_ID->CurrentValue, null, false);

        // MONTH_ID
        $this->MONTH_ID->setDbValueDef($rsnew, $this->MONTH_ID->CurrentValue, null, false);

        // YEAR_ID
        $this->YEAR_ID->setDbValueDef($rsnew, $this->YEAR_ID->CurrentValue, null, false);

        // CORRECTION_DOC
        $this->CORRECTION_DOC->setDbValueDef($rsnew, $this->CORRECTION_DOC->CurrentValue, null, false);

        // CORRECTIONS
        $this->CORRECTIONS->setDbValueDef($rsnew, $this->CORRECTIONS->CurrentValue, null, false);

        // CORRECTION_DATE
        $this->CORRECTION_DATE->CurrentValue = CurrentDateTime();
        $this->CORRECTION_DATE->setDbValueDef($rsnew, $this->CORRECTION_DATE->CurrentValue, null);

        // DOC_NO
        $this->DOC_NO->setDbValueDef($rsnew, $this->DOC_NO->CurrentValue, null, false);

        // ORDER_ID
        $this->ORDER_ID->setDbValueDef($rsnew, $this->ORDER_ID->CurrentValue, null, false);

        // ISCETAK
        $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, false);

        // PRINT_DATE
        $this->PRINT_DATE->CurrentValue = CurrentDateTime();
        $this->PRINT_DATE->setDbValueDef($rsnew, $this->PRINT_DATE->CurrentValue, null);

        // PRINTED_BY
        $this->PRINTED_BY->CurrentValue = CurrentUserName();
        $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null);

        // PRINTQ
        $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, false);

        // avgprice
        $this->avgprice->setDbValueDef($rsnew, $this->avgprice->CurrentValue, null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GoodGfList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
