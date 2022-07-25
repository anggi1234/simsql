<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodsAdd extends Goods
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOODS';

    // Page object name
    public $PageObjName = "GoodsAdd";

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

        // Table object (GOODS)
        if (!isset($GLOBALS["GOODS"]) || get_class($GLOBALS["GOODS"]) == PROJECT_NAMESPACE . "GOODS") {
            $GLOBALS["GOODS"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "GoodsView") {
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

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

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
            if (($keyValue = Get("BRAND_ID") ?? Route("BRAND_ID")) !== null) {
                $this->BRAND_ID->setQueryStringValue($keyValue);
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
                    $this->terminate("GoodsList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "GoodsList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "GoodsView") {
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
        $this->CODE_5->CurrentValue = null;
        $this->CODE_5->OldValue = $this->CODE_5->CurrentValue;
        $this->BRAND_ID->CurrentValue = null;
        $this->BRAND_ID->OldValue = $this->BRAND_ID->CurrentValue;
        $this->NAME->CurrentValue = null;
        $this->NAME->OldValue = $this->NAME->CurrentValue;
        $this->OTHER_CODE->CurrentValue = null;
        $this->OTHER_CODE->OldValue = $this->OTHER_CODE->CurrentValue;
        $this->_BARCODE->CurrentValue = null;
        $this->_BARCODE->OldValue = $this->_BARCODE->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->REORDER_POINT->CurrentValue = null;
        $this->REORDER_POINT->OldValue = $this->REORDER_POINT->CurrentValue;
        $this->SIZE_GOODS->CurrentValue = null;
        $this->SIZE_GOODS->OldValue = $this->SIZE_GOODS->CurrentValue;
        $this->MEASURE_DOSIS->CurrentValue = 15;
        $this->MEASURE_ID->CurrentValue = 3;
        $this->MEASURE_ID2->CurrentValue = 3;
        $this->SIZE_KEMASAN->CurrentValue = 1;
        $this->MEASURE_ID3->CurrentValue = 21;
        $this->COMPANY_ID->CurrentValue = null;
        $this->COMPANY_ID->OldValue = $this->COMPANY_ID->CurrentValue;
        $this->NET_PRICE->CurrentValue = null;
        $this->NET_PRICE->OldValue = $this->NET_PRICE->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->TH->CurrentValue = null;
        $this->TH->OldValue = $this->TH->CurrentValue;
        $this->STATUS_PASIEN_ID->CurrentValue = 1;
        $this->MATERIAL_ID->CurrentValue = null;
        $this->MATERIAL_ID->OldValue = $this->MATERIAL_ID->CurrentValue;
        $this->FORM_ID->CurrentValue = null;
        $this->FORM_ID->OldValue = $this->FORM_ID->CurrentValue;
        $this->ISGENERIC->CurrentValue = null;
        $this->ISGENERIC->OldValue = $this->ISGENERIC->CurrentValue;
        $this->REGULATE_ID->CurrentValue = null;
        $this->REGULATE_ID->OldValue = $this->REGULATE_ID->CurrentValue;
        $this->PREGNANCY_INDEX->CurrentValue = null;
        $this->PREGNANCY_INDEX->OldValue = $this->PREGNANCY_INDEX->CurrentValue;
        $this->INDICATION->CurrentValue = null;
        $this->INDICATION->OldValue = $this->INDICATION->CurrentValue;
        $this->TAKE_RULE->CurrentValue = null;
        $this->TAKE_RULE->OldValue = $this->TAKE_RULE->CurrentValue;
        $this->SIDE_EFFECT->CurrentValue = null;
        $this->SIDE_EFFECT->OldValue = $this->SIDE_EFFECT->CurrentValue;
        $this->INTERACTION->CurrentValue = null;
        $this->INTERACTION->OldValue = $this->INTERACTION->CurrentValue;
        $this->CONTRA_INDICATION->CurrentValue = null;
        $this->CONTRA_INDICATION->OldValue = $this->CONTRA_INDICATION->CurrentValue;
        $this->WARNING->CurrentValue = null;
        $this->WARNING->OldValue = $this->WARNING->CurrentValue;
        $this->STOCK->CurrentValue = 0;
        $this->ISACTIVE->CurrentValue = "1";
        $this->ISALKES->CurrentValue = "0";
        $this->SIZE_ORDER->CurrentValue = null;
        $this->SIZE_ORDER->OldValue = $this->SIZE_ORDER->CurrentValue;
        $this->ORDER_PRICE->CurrentValue = null;
        $this->ORDER_PRICE->OldValue = $this->ORDER_PRICE->CurrentValue;
        $this->ISFORMULARIUM->CurrentValue = null;
        $this->ISFORMULARIUM->OldValue = $this->ISFORMULARIUM->CurrentValue;
        $this->ISESSENTIAL->CurrentValue = null;
        $this->ISESSENTIAL->OldValue = $this->ISESSENTIAL->CurrentValue;
        $this->AVGDATE->CurrentValue = null;
        $this->AVGDATE->OldValue = $this->AVGDATE->CurrentValue;
        $this->STOCK_MINIMAL->CurrentValue = null;
        $this->STOCK_MINIMAL->OldValue = $this->STOCK_MINIMAL->CurrentValue;
        $this->STOCK_MINIMAL_APT->CurrentValue = null;
        $this->STOCK_MINIMAL_APT->OldValue = $this->STOCK_MINIMAL_APT->CurrentValue;
        $this->HET->CurrentValue = null;
        $this->HET->OldValue = $this->HET->CurrentValue;
        $this->default_margin->CurrentValue = null;
        $this->default_margin->OldValue = $this->default_margin->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'CODE_5' first before field var 'x_CODE_5'
        $val = $CurrentForm->hasValue("CODE_5") ? $CurrentForm->getValue("CODE_5") : $CurrentForm->getValue("x_CODE_5");
        if (!$this->CODE_5->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CODE_5->Visible = false; // Disable update for API request
            } else {
                $this->CODE_5->setFormValue($val);
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

        // Check field name 'NAME' first before field var 'x_NAME'
        $val = $CurrentForm->hasValue("NAME") ? $CurrentForm->getValue("NAME") : $CurrentForm->getValue("x_NAME");
        if (!$this->NAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NAME->Visible = false; // Disable update for API request
            } else {
                $this->NAME->setFormValue($val);
            }
        }

        // Check field name 'OTHER_CODE' first before field var 'x_OTHER_CODE'
        $val = $CurrentForm->hasValue("OTHER_CODE") ? $CurrentForm->getValue("OTHER_CODE") : $CurrentForm->getValue("x_OTHER_CODE");
        if (!$this->OTHER_CODE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->OTHER_CODE->Visible = false; // Disable update for API request
            } else {
                $this->OTHER_CODE->setFormValue($val);
            }
        }

        // Check field name 'BARCODE' first before field var 'x__BARCODE'
        $val = $CurrentForm->hasValue("BARCODE") ? $CurrentForm->getValue("BARCODE") : $CurrentForm->getValue("x__BARCODE");
        if (!$this->_BARCODE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_BARCODE->Visible = false; // Disable update for API request
            } else {
                $this->_BARCODE->setFormValue($val);
            }
        }

        // Check field name 'DESCRIPTION' first before field var 'x_DESCRIPTION'
        $val = $CurrentForm->hasValue("DESCRIPTION") ? $CurrentForm->getValue("DESCRIPTION") : $CurrentForm->getValue("x_DESCRIPTION");
        if (!$this->DESCRIPTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DESCRIPTION->Visible = false; // Disable update for API request
            } else {
                $this->DESCRIPTION->setFormValue($val);
            }
        }

        // Check field name 'REORDER_POINT' first before field var 'x_REORDER_POINT'
        $val = $CurrentForm->hasValue("REORDER_POINT") ? $CurrentForm->getValue("REORDER_POINT") : $CurrentForm->getValue("x_REORDER_POINT");
        if (!$this->REORDER_POINT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REORDER_POINT->Visible = false; // Disable update for API request
            } else {
                $this->REORDER_POINT->setFormValue($val);
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

        // Check field name 'MEASURE_ID' first before field var 'x_MEASURE_ID'
        $val = $CurrentForm->hasValue("MEASURE_ID") ? $CurrentForm->getValue("MEASURE_ID") : $CurrentForm->getValue("x_MEASURE_ID");
        if (!$this->MEASURE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID->setFormValue($val);
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

        // Check field name 'SIZE_KEMASAN' first before field var 'x_SIZE_KEMASAN'
        $val = $CurrentForm->hasValue("SIZE_KEMASAN") ? $CurrentForm->getValue("SIZE_KEMASAN") : $CurrentForm->getValue("x_SIZE_KEMASAN");
        if (!$this->SIZE_KEMASAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_KEMASAN->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_KEMASAN->setFormValue($val);
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

        // Check field name 'COMPANY_ID' first before field var 'x_COMPANY_ID'
        $val = $CurrentForm->hasValue("COMPANY_ID") ? $CurrentForm->getValue("COMPANY_ID") : $CurrentForm->getValue("x_COMPANY_ID");
        if (!$this->COMPANY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_ID->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_ID->setFormValue($val);
            }
        }

        // Check field name 'NET_PRICE' first before field var 'x_NET_PRICE'
        $val = $CurrentForm->hasValue("NET_PRICE") ? $CurrentForm->getValue("NET_PRICE") : $CurrentForm->getValue("x_NET_PRICE");
        if (!$this->NET_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NET_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->NET_PRICE->setFormValue($val);
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
            $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
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

        // Check field name 'TH' first before field var 'x_TH'
        $val = $CurrentForm->hasValue("TH") ? $CurrentForm->getValue("TH") : $CurrentForm->getValue("x_TH");
        if (!$this->TH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TH->Visible = false; // Disable update for API request
            } else {
                $this->TH->setFormValue($val);
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

        // Check field name 'MATERIAL_ID' first before field var 'x_MATERIAL_ID'
        $val = $CurrentForm->hasValue("MATERIAL_ID") ? $CurrentForm->getValue("MATERIAL_ID") : $CurrentForm->getValue("x_MATERIAL_ID");
        if (!$this->MATERIAL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MATERIAL_ID->Visible = false; // Disable update for API request
            } else {
                $this->MATERIAL_ID->setFormValue($val);
            }
        }

        // Check field name 'FORM_ID' first before field var 'x_FORM_ID'
        $val = $CurrentForm->hasValue("FORM_ID") ? $CurrentForm->getValue("FORM_ID") : $CurrentForm->getValue("x_FORM_ID");
        if (!$this->FORM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FORM_ID->Visible = false; // Disable update for API request
            } else {
                $this->FORM_ID->setFormValue($val);
            }
        }

        // Check field name 'ISGENERIC' first before field var 'x_ISGENERIC'
        $val = $CurrentForm->hasValue("ISGENERIC") ? $CurrentForm->getValue("ISGENERIC") : $CurrentForm->getValue("x_ISGENERIC");
        if (!$this->ISGENERIC->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISGENERIC->Visible = false; // Disable update for API request
            } else {
                $this->ISGENERIC->setFormValue($val);
            }
        }

        // Check field name 'REGULATE_ID' first before field var 'x_REGULATE_ID'
        $val = $CurrentForm->hasValue("REGULATE_ID") ? $CurrentForm->getValue("REGULATE_ID") : $CurrentForm->getValue("x_REGULATE_ID");
        if (!$this->REGULATE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REGULATE_ID->Visible = false; // Disable update for API request
            } else {
                $this->REGULATE_ID->setFormValue($val);
            }
        }

        // Check field name 'PREGNANCY_INDEX' first before field var 'x_PREGNANCY_INDEX'
        $val = $CurrentForm->hasValue("PREGNANCY_INDEX") ? $CurrentForm->getValue("PREGNANCY_INDEX") : $CurrentForm->getValue("x_PREGNANCY_INDEX");
        if (!$this->PREGNANCY_INDEX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PREGNANCY_INDEX->Visible = false; // Disable update for API request
            } else {
                $this->PREGNANCY_INDEX->setFormValue($val);
            }
        }

        // Check field name 'INDICATION' first before field var 'x_INDICATION'
        $val = $CurrentForm->hasValue("INDICATION") ? $CurrentForm->getValue("INDICATION") : $CurrentForm->getValue("x_INDICATION");
        if (!$this->INDICATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INDICATION->Visible = false; // Disable update for API request
            } else {
                $this->INDICATION->setFormValue($val);
            }
        }

        // Check field name 'TAKE_RULE' first before field var 'x_TAKE_RULE'
        $val = $CurrentForm->hasValue("TAKE_RULE") ? $CurrentForm->getValue("TAKE_RULE") : $CurrentForm->getValue("x_TAKE_RULE");
        if (!$this->TAKE_RULE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TAKE_RULE->Visible = false; // Disable update for API request
            } else {
                $this->TAKE_RULE->setFormValue($val);
            }
        }

        // Check field name 'SIDE_EFFECT' first before field var 'x_SIDE_EFFECT'
        $val = $CurrentForm->hasValue("SIDE_EFFECT") ? $CurrentForm->getValue("SIDE_EFFECT") : $CurrentForm->getValue("x_SIDE_EFFECT");
        if (!$this->SIDE_EFFECT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIDE_EFFECT->Visible = false; // Disable update for API request
            } else {
                $this->SIDE_EFFECT->setFormValue($val);
            }
        }

        // Check field name 'INTERACTION' first before field var 'x_INTERACTION'
        $val = $CurrentForm->hasValue("INTERACTION") ? $CurrentForm->getValue("INTERACTION") : $CurrentForm->getValue("x_INTERACTION");
        if (!$this->INTERACTION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INTERACTION->Visible = false; // Disable update for API request
            } else {
                $this->INTERACTION->setFormValue($val);
            }
        }

        // Check field name 'CONTRA_INDICATION' first before field var 'x_CONTRA_INDICATION'
        $val = $CurrentForm->hasValue("CONTRA_INDICATION") ? $CurrentForm->getValue("CONTRA_INDICATION") : $CurrentForm->getValue("x_CONTRA_INDICATION");
        if (!$this->CONTRA_INDICATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CONTRA_INDICATION->Visible = false; // Disable update for API request
            } else {
                $this->CONTRA_INDICATION->setFormValue($val);
            }
        }

        // Check field name 'WARNING' first before field var 'x_WARNING'
        $val = $CurrentForm->hasValue("WARNING") ? $CurrentForm->getValue("WARNING") : $CurrentForm->getValue("x_WARNING");
        if (!$this->WARNING->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->WARNING->Visible = false; // Disable update for API request
            } else {
                $this->WARNING->setFormValue($val);
            }
        }

        // Check field name 'STOCK' first before field var 'x_STOCK'
        $val = $CurrentForm->hasValue("STOCK") ? $CurrentForm->getValue("STOCK") : $CurrentForm->getValue("x_STOCK");
        if (!$this->STOCK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK->Visible = false; // Disable update for API request
            } else {
                $this->STOCK->setFormValue($val);
            }
        }

        // Check field name 'ISACTIVE' first before field var 'x_ISACTIVE'
        $val = $CurrentForm->hasValue("ISACTIVE") ? $CurrentForm->getValue("ISACTIVE") : $CurrentForm->getValue("x_ISACTIVE");
        if (!$this->ISACTIVE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISACTIVE->Visible = false; // Disable update for API request
            } else {
                $this->ISACTIVE->setFormValue($val);
            }
        }

        // Check field name 'ISALKES' first before field var 'x_ISALKES'
        $val = $CurrentForm->hasValue("ISALKES") ? $CurrentForm->getValue("ISALKES") : $CurrentForm->getValue("x_ISALKES");
        if (!$this->ISALKES->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISALKES->Visible = false; // Disable update for API request
            } else {
                $this->ISALKES->setFormValue($val);
            }
        }

        // Check field name 'SIZE_ORDER' first before field var 'x_SIZE_ORDER'
        $val = $CurrentForm->hasValue("SIZE_ORDER") ? $CurrentForm->getValue("SIZE_ORDER") : $CurrentForm->getValue("x_SIZE_ORDER");
        if (!$this->SIZE_ORDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_ORDER->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_ORDER->setFormValue($val);
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

        // Check field name 'ISFORMULARIUM' first before field var 'x_ISFORMULARIUM'
        $val = $CurrentForm->hasValue("ISFORMULARIUM") ? $CurrentForm->getValue("ISFORMULARIUM") : $CurrentForm->getValue("x_ISFORMULARIUM");
        if (!$this->ISFORMULARIUM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISFORMULARIUM->Visible = false; // Disable update for API request
            } else {
                $this->ISFORMULARIUM->setFormValue($val);
            }
        }

        // Check field name 'ISESSENTIAL' first before field var 'x_ISESSENTIAL'
        $val = $CurrentForm->hasValue("ISESSENTIAL") ? $CurrentForm->getValue("ISESSENTIAL") : $CurrentForm->getValue("x_ISESSENTIAL");
        if (!$this->ISESSENTIAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISESSENTIAL->Visible = false; // Disable update for API request
            } else {
                $this->ISESSENTIAL->setFormValue($val);
            }
        }

        // Check field name 'AVGDATE' first before field var 'x_AVGDATE'
        $val = $CurrentForm->hasValue("AVGDATE") ? $CurrentForm->getValue("AVGDATE") : $CurrentForm->getValue("x_AVGDATE");
        if (!$this->AVGDATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AVGDATE->Visible = false; // Disable update for API request
            } else {
                $this->AVGDATE->setFormValue($val);
            }
            $this->AVGDATE->CurrentValue = UnFormatDateTime($this->AVGDATE->CurrentValue, 0);
        }

        // Check field name 'STOCK_MINIMAL' first before field var 'x_STOCK_MINIMAL'
        $val = $CurrentForm->hasValue("STOCK_MINIMAL") ? $CurrentForm->getValue("STOCK_MINIMAL") : $CurrentForm->getValue("x_STOCK_MINIMAL");
        if (!$this->STOCK_MINIMAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_MINIMAL->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_MINIMAL->setFormValue($val);
            }
        }

        // Check field name 'STOCK_MINIMAL_APT' first before field var 'x_STOCK_MINIMAL_APT'
        $val = $CurrentForm->hasValue("STOCK_MINIMAL_APT") ? $CurrentForm->getValue("STOCK_MINIMAL_APT") : $CurrentForm->getValue("x_STOCK_MINIMAL_APT");
        if (!$this->STOCK_MINIMAL_APT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STOCK_MINIMAL_APT->Visible = false; // Disable update for API request
            } else {
                $this->STOCK_MINIMAL_APT->setFormValue($val);
            }
        }

        // Check field name 'HET' first before field var 'x_HET'
        $val = $CurrentForm->hasValue("HET") ? $CurrentForm->getValue("HET") : $CurrentForm->getValue("x_HET");
        if (!$this->HET->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->HET->Visible = false; // Disable update for API request
            } else {
                $this->HET->setFormValue($val);
            }
        }

        // Check field name 'default_margin' first before field var 'x_default_margin'
        $val = $CurrentForm->hasValue("default_margin") ? $CurrentForm->getValue("default_margin") : $CurrentForm->getValue("x_default_margin");
        if (!$this->default_margin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->default_margin->Visible = false; // Disable update for API request
            } else {
                $this->default_margin->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->CODE_5->CurrentValue = $this->CODE_5->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->NAME->CurrentValue = $this->NAME->FormValue;
        $this->OTHER_CODE->CurrentValue = $this->OTHER_CODE->FormValue;
        $this->_BARCODE->CurrentValue = $this->_BARCODE->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->REORDER_POINT->CurrentValue = $this->REORDER_POINT->FormValue;
        $this->SIZE_GOODS->CurrentValue = $this->SIZE_GOODS->FormValue;
        $this->MEASURE_DOSIS->CurrentValue = $this->MEASURE_DOSIS->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->MEASURE_ID2->CurrentValue = $this->MEASURE_ID2->FormValue;
        $this->SIZE_KEMASAN->CurrentValue = $this->SIZE_KEMASAN->FormValue;
        $this->MEASURE_ID3->CurrentValue = $this->MEASURE_ID3->FormValue;
        $this->COMPANY_ID->CurrentValue = $this->COMPANY_ID->FormValue;
        $this->NET_PRICE->CurrentValue = $this->NET_PRICE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->TH->CurrentValue = $this->TH->FormValue;
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->MATERIAL_ID->CurrentValue = $this->MATERIAL_ID->FormValue;
        $this->FORM_ID->CurrentValue = $this->FORM_ID->FormValue;
        $this->ISGENERIC->CurrentValue = $this->ISGENERIC->FormValue;
        $this->REGULATE_ID->CurrentValue = $this->REGULATE_ID->FormValue;
        $this->PREGNANCY_INDEX->CurrentValue = $this->PREGNANCY_INDEX->FormValue;
        $this->INDICATION->CurrentValue = $this->INDICATION->FormValue;
        $this->TAKE_RULE->CurrentValue = $this->TAKE_RULE->FormValue;
        $this->SIDE_EFFECT->CurrentValue = $this->SIDE_EFFECT->FormValue;
        $this->INTERACTION->CurrentValue = $this->INTERACTION->FormValue;
        $this->CONTRA_INDICATION->CurrentValue = $this->CONTRA_INDICATION->FormValue;
        $this->WARNING->CurrentValue = $this->WARNING->FormValue;
        $this->STOCK->CurrentValue = $this->STOCK->FormValue;
        $this->ISACTIVE->CurrentValue = $this->ISACTIVE->FormValue;
        $this->ISALKES->CurrentValue = $this->ISALKES->FormValue;
        $this->SIZE_ORDER->CurrentValue = $this->SIZE_ORDER->FormValue;
        $this->ORDER_PRICE->CurrentValue = $this->ORDER_PRICE->FormValue;
        $this->ISFORMULARIUM->CurrentValue = $this->ISFORMULARIUM->FormValue;
        $this->ISESSENTIAL->CurrentValue = $this->ISESSENTIAL->FormValue;
        $this->AVGDATE->CurrentValue = $this->AVGDATE->FormValue;
        $this->AVGDATE->CurrentValue = UnFormatDateTime($this->AVGDATE->CurrentValue, 0);
        $this->STOCK_MINIMAL->CurrentValue = $this->STOCK_MINIMAL->FormValue;
        $this->STOCK_MINIMAL_APT->CurrentValue = $this->STOCK_MINIMAL_APT->FormValue;
        $this->HET->CurrentValue = $this->HET->FormValue;
        $this->default_margin->CurrentValue = $this->default_margin->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['CODE_5'] = $this->CODE_5->CurrentValue;
        $row['BRAND_ID'] = $this->BRAND_ID->CurrentValue;
        $row['NAME'] = $this->NAME->CurrentValue;
        $row['OTHER_CODE'] = $this->OTHER_CODE->CurrentValue;
        $row['BARCODE'] = $this->_BARCODE->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['REORDER_POINT'] = $this->REORDER_POINT->CurrentValue;
        $row['SIZE_GOODS'] = $this->SIZE_GOODS->CurrentValue;
        $row['MEASURE_DOSIS'] = $this->MEASURE_DOSIS->CurrentValue;
        $row['MEASURE_ID'] = $this->MEASURE_ID->CurrentValue;
        $row['MEASURE_ID2'] = $this->MEASURE_ID2->CurrentValue;
        $row['SIZE_KEMASAN'] = $this->SIZE_KEMASAN->CurrentValue;
        $row['MEASURE_ID3'] = $this->MEASURE_ID3->CurrentValue;
        $row['COMPANY_ID'] = $this->COMPANY_ID->CurrentValue;
        $row['NET_PRICE'] = $this->NET_PRICE->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['TH'] = $this->TH->CurrentValue;
        $row['STATUS_PASIEN_ID'] = $this->STATUS_PASIEN_ID->CurrentValue;
        $row['MATERIAL_ID'] = $this->MATERIAL_ID->CurrentValue;
        $row['FORM_ID'] = $this->FORM_ID->CurrentValue;
        $row['ISGENERIC'] = $this->ISGENERIC->CurrentValue;
        $row['REGULATE_ID'] = $this->REGULATE_ID->CurrentValue;
        $row['PREGNANCY_INDEX'] = $this->PREGNANCY_INDEX->CurrentValue;
        $row['INDICATION'] = $this->INDICATION->CurrentValue;
        $row['TAKE_RULE'] = $this->TAKE_RULE->CurrentValue;
        $row['SIDE_EFFECT'] = $this->SIDE_EFFECT->CurrentValue;
        $row['INTERACTION'] = $this->INTERACTION->CurrentValue;
        $row['CONTRA_INDICATION'] = $this->CONTRA_INDICATION->CurrentValue;
        $row['WARNING'] = $this->WARNING->CurrentValue;
        $row['STOCK'] = $this->STOCK->CurrentValue;
        $row['ISACTIVE'] = $this->ISACTIVE->CurrentValue;
        $row['ISALKES'] = $this->ISALKES->CurrentValue;
        $row['SIZE_ORDER'] = $this->SIZE_ORDER->CurrentValue;
        $row['ORDER_PRICE'] = $this->ORDER_PRICE->CurrentValue;
        $row['ISFORMULARIUM'] = $this->ISFORMULARIUM->CurrentValue;
        $row['ISESSENTIAL'] = $this->ISESSENTIAL->CurrentValue;
        $row['AVGDATE'] = $this->AVGDATE->CurrentValue;
        $row['STOCK_MINIMAL'] = $this->STOCK_MINIMAL->CurrentValue;
        $row['STOCK_MINIMAL_APT'] = $this->STOCK_MINIMAL_APT->CurrentValue;
        $row['HET'] = $this->HET->CurrentValue;
        $row['default_margin'] = $this->default_margin->CurrentValue;
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // CODE_5
            $this->CODE_5->EditAttrs["class"] = "form-control";
            $this->CODE_5->EditCustomAttributes = "";
            if (!$this->CODE_5->Raw) {
                $this->CODE_5->CurrentValue = HtmlDecode($this->CODE_5->CurrentValue);
            }
            $this->CODE_5->EditValue = HtmlEncode($this->CODE_5->CurrentValue);
            $this->CODE_5->PlaceHolder = RemoveHtml($this->CODE_5->caption());

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            if (!$this->BRAND_ID->Raw) {
                $this->BRAND_ID->CurrentValue = HtmlDecode($this->BRAND_ID->CurrentValue);
            }
            $this->BRAND_ID->EditValue = HtmlEncode($this->BRAND_ID->CurrentValue);
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // NAME
            $this->NAME->EditAttrs["class"] = "form-control";
            $this->NAME->EditCustomAttributes = "";
            if (!$this->NAME->Raw) {
                $this->NAME->CurrentValue = HtmlDecode($this->NAME->CurrentValue);
            }
            $this->NAME->EditValue = HtmlEncode($this->NAME->CurrentValue);
            $this->NAME->PlaceHolder = RemoveHtml($this->NAME->caption());

            // OTHER_CODE
            $this->OTHER_CODE->EditAttrs["class"] = "form-control";
            $this->OTHER_CODE->EditCustomAttributes = "";
            if (!$this->OTHER_CODE->Raw) {
                $this->OTHER_CODE->CurrentValue = HtmlDecode($this->OTHER_CODE->CurrentValue);
            }
            $this->OTHER_CODE->EditValue = HtmlEncode($this->OTHER_CODE->CurrentValue);
            $this->OTHER_CODE->PlaceHolder = RemoveHtml($this->OTHER_CODE->caption());

            // BARCODE
            $this->_BARCODE->EditAttrs["class"] = "form-control";
            $this->_BARCODE->EditCustomAttributes = "";
            if (!$this->_BARCODE->Raw) {
                $this->_BARCODE->CurrentValue = HtmlDecode($this->_BARCODE->CurrentValue);
            }
            $this->_BARCODE->EditValue = HtmlEncode($this->_BARCODE->CurrentValue);
            $this->_BARCODE->PlaceHolder = RemoveHtml($this->_BARCODE->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // REORDER_POINT
            $this->REORDER_POINT->EditAttrs["class"] = "form-control";
            $this->REORDER_POINT->EditCustomAttributes = "";
            $this->REORDER_POINT->EditValue = HtmlEncode($this->REORDER_POINT->CurrentValue);
            $this->REORDER_POINT->PlaceHolder = RemoveHtml($this->REORDER_POINT->caption());
            if (strval($this->REORDER_POINT->EditValue) != "" && is_numeric($this->REORDER_POINT->EditValue)) {
                $this->REORDER_POINT->EditValue = FormatNumber($this->REORDER_POINT->EditValue, -2, -2, -2, -2);
            }

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

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // MEASURE_ID2
            $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID2->EditCustomAttributes = "";
            $this->MEASURE_ID2->EditValue = HtmlEncode($this->MEASURE_ID2->CurrentValue);
            $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->EditAttrs["class"] = "form-control";
            $this->SIZE_KEMASAN->EditCustomAttributes = "";
            $this->SIZE_KEMASAN->EditValue = HtmlEncode($this->SIZE_KEMASAN->CurrentValue);
            $this->SIZE_KEMASAN->PlaceHolder = RemoveHtml($this->SIZE_KEMASAN->caption());
            if (strval($this->SIZE_KEMASAN->EditValue) != "" && is_numeric($this->SIZE_KEMASAN->EditValue)) {
                $this->SIZE_KEMASAN->EditValue = FormatNumber($this->SIZE_KEMASAN->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID3
            $this->MEASURE_ID3->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID3->EditCustomAttributes = "";
            $this->MEASURE_ID3->EditValue = HtmlEncode($this->MEASURE_ID3->CurrentValue);
            $this->MEASURE_ID3->PlaceHolder = RemoveHtml($this->MEASURE_ID3->caption());

            // COMPANY_ID
            $this->COMPANY_ID->EditAttrs["class"] = "form-control";
            $this->COMPANY_ID->EditCustomAttributes = "";
            if (!$this->COMPANY_ID->Raw) {
                $this->COMPANY_ID->CurrentValue = HtmlDecode($this->COMPANY_ID->CurrentValue);
            }
            $this->COMPANY_ID->EditValue = HtmlEncode($this->COMPANY_ID->CurrentValue);
            $this->COMPANY_ID->PlaceHolder = RemoveHtml($this->COMPANY_ID->caption());

            // NET_PRICE
            $this->NET_PRICE->EditAttrs["class"] = "form-control";
            $this->NET_PRICE->EditCustomAttributes = "";
            $this->NET_PRICE->EditValue = HtmlEncode($this->NET_PRICE->CurrentValue);
            $this->NET_PRICE->PlaceHolder = RemoveHtml($this->NET_PRICE->caption());
            if (strval($this->NET_PRICE->EditValue) != "" && is_numeric($this->NET_PRICE->EditValue)) {
                $this->NET_PRICE->EditValue = FormatNumber($this->NET_PRICE->EditValue, -2, -2, -2, -2);
            }

            // MODIFIED_DATE
            $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
            $this->MODIFIED_DATE->EditCustomAttributes = "";
            $this->MODIFIED_DATE->EditValue = HtmlEncode(FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8));
            $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

            // MODIFIED_BY
            $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
            $this->MODIFIED_BY->EditCustomAttributes = "";
            if (!$this->MODIFIED_BY->Raw) {
                $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
            }
            $this->MODIFIED_BY->EditValue = HtmlEncode($this->MODIFIED_BY->CurrentValue);
            $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

            // TH
            $this->TH->EditAttrs["class"] = "form-control";
            $this->TH->EditCustomAttributes = "";
            $this->TH->EditValue = HtmlEncode($this->TH->CurrentValue);
            $this->TH->PlaceHolder = RemoveHtml($this->TH->caption());

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $this->STATUS_PASIEN_ID->EditValue = HtmlEncode($this->STATUS_PASIEN_ID->CurrentValue);
            $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

            // MATERIAL_ID
            $this->MATERIAL_ID->EditAttrs["class"] = "form-control";
            $this->MATERIAL_ID->EditCustomAttributes = "";
            $this->MATERIAL_ID->EditValue = HtmlEncode($this->MATERIAL_ID->CurrentValue);
            $this->MATERIAL_ID->PlaceHolder = RemoveHtml($this->MATERIAL_ID->caption());

            // FORM_ID
            $this->FORM_ID->EditAttrs["class"] = "form-control";
            $this->FORM_ID->EditCustomAttributes = "";
            $this->FORM_ID->EditValue = HtmlEncode($this->FORM_ID->CurrentValue);
            $this->FORM_ID->PlaceHolder = RemoveHtml($this->FORM_ID->caption());

            // ISGENERIC
            $this->ISGENERIC->EditAttrs["class"] = "form-control";
            $this->ISGENERIC->EditCustomAttributes = "";
            if (!$this->ISGENERIC->Raw) {
                $this->ISGENERIC->CurrentValue = HtmlDecode($this->ISGENERIC->CurrentValue);
            }
            $this->ISGENERIC->EditValue = HtmlEncode($this->ISGENERIC->CurrentValue);
            $this->ISGENERIC->PlaceHolder = RemoveHtml($this->ISGENERIC->caption());

            // REGULATE_ID
            $this->REGULATE_ID->EditAttrs["class"] = "form-control";
            $this->REGULATE_ID->EditCustomAttributes = "";
            $this->REGULATE_ID->EditValue = HtmlEncode($this->REGULATE_ID->CurrentValue);
            $this->REGULATE_ID->PlaceHolder = RemoveHtml($this->REGULATE_ID->caption());

            // PREGNANCY_INDEX
            $this->PREGNANCY_INDEX->EditAttrs["class"] = "form-control";
            $this->PREGNANCY_INDEX->EditCustomAttributes = "";
            if (!$this->PREGNANCY_INDEX->Raw) {
                $this->PREGNANCY_INDEX->CurrentValue = HtmlDecode($this->PREGNANCY_INDEX->CurrentValue);
            }
            $this->PREGNANCY_INDEX->EditValue = HtmlEncode($this->PREGNANCY_INDEX->CurrentValue);
            $this->PREGNANCY_INDEX->PlaceHolder = RemoveHtml($this->PREGNANCY_INDEX->caption());

            // INDICATION
            $this->INDICATION->EditAttrs["class"] = "form-control";
            $this->INDICATION->EditCustomAttributes = "";
            if (!$this->INDICATION->Raw) {
                $this->INDICATION->CurrentValue = HtmlDecode($this->INDICATION->CurrentValue);
            }
            $this->INDICATION->EditValue = HtmlEncode($this->INDICATION->CurrentValue);
            $this->INDICATION->PlaceHolder = RemoveHtml($this->INDICATION->caption());

            // TAKE_RULE
            $this->TAKE_RULE->EditAttrs["class"] = "form-control";
            $this->TAKE_RULE->EditCustomAttributes = "";
            if (!$this->TAKE_RULE->Raw) {
                $this->TAKE_RULE->CurrentValue = HtmlDecode($this->TAKE_RULE->CurrentValue);
            }
            $this->TAKE_RULE->EditValue = HtmlEncode($this->TAKE_RULE->CurrentValue);
            $this->TAKE_RULE->PlaceHolder = RemoveHtml($this->TAKE_RULE->caption());

            // SIDE_EFFECT
            $this->SIDE_EFFECT->EditAttrs["class"] = "form-control";
            $this->SIDE_EFFECT->EditCustomAttributes = "";
            if (!$this->SIDE_EFFECT->Raw) {
                $this->SIDE_EFFECT->CurrentValue = HtmlDecode($this->SIDE_EFFECT->CurrentValue);
            }
            $this->SIDE_EFFECT->EditValue = HtmlEncode($this->SIDE_EFFECT->CurrentValue);
            $this->SIDE_EFFECT->PlaceHolder = RemoveHtml($this->SIDE_EFFECT->caption());

            // INTERACTION
            $this->INTERACTION->EditAttrs["class"] = "form-control";
            $this->INTERACTION->EditCustomAttributes = "";
            if (!$this->INTERACTION->Raw) {
                $this->INTERACTION->CurrentValue = HtmlDecode($this->INTERACTION->CurrentValue);
            }
            $this->INTERACTION->EditValue = HtmlEncode($this->INTERACTION->CurrentValue);
            $this->INTERACTION->PlaceHolder = RemoveHtml($this->INTERACTION->caption());

            // CONTRA_INDICATION
            $this->CONTRA_INDICATION->EditAttrs["class"] = "form-control";
            $this->CONTRA_INDICATION->EditCustomAttributes = "";
            if (!$this->CONTRA_INDICATION->Raw) {
                $this->CONTRA_INDICATION->CurrentValue = HtmlDecode($this->CONTRA_INDICATION->CurrentValue);
            }
            $this->CONTRA_INDICATION->EditValue = HtmlEncode($this->CONTRA_INDICATION->CurrentValue);
            $this->CONTRA_INDICATION->PlaceHolder = RemoveHtml($this->CONTRA_INDICATION->caption());

            // WARNING
            $this->WARNING->EditAttrs["class"] = "form-control";
            $this->WARNING->EditCustomAttributes = "";
            if (!$this->WARNING->Raw) {
                $this->WARNING->CurrentValue = HtmlDecode($this->WARNING->CurrentValue);
            }
            $this->WARNING->EditValue = HtmlEncode($this->WARNING->CurrentValue);
            $this->WARNING->PlaceHolder = RemoveHtml($this->WARNING->caption());

            // STOCK
            $this->STOCK->EditAttrs["class"] = "form-control";
            $this->STOCK->EditCustomAttributes = "";
            $this->STOCK->EditValue = HtmlEncode($this->STOCK->CurrentValue);
            $this->STOCK->PlaceHolder = RemoveHtml($this->STOCK->caption());
            if (strval($this->STOCK->EditValue) != "" && is_numeric($this->STOCK->EditValue)) {
                $this->STOCK->EditValue = FormatNumber($this->STOCK->EditValue, -2, -2, -2, -2);
            }

            // ISACTIVE
            $this->ISACTIVE->EditAttrs["class"] = "form-control";
            $this->ISACTIVE->EditCustomAttributes = "";
            if (!$this->ISACTIVE->Raw) {
                $this->ISACTIVE->CurrentValue = HtmlDecode($this->ISACTIVE->CurrentValue);
            }
            $this->ISACTIVE->EditValue = HtmlEncode($this->ISACTIVE->CurrentValue);
            $this->ISACTIVE->PlaceHolder = RemoveHtml($this->ISACTIVE->caption());

            // ISALKES
            $this->ISALKES->EditAttrs["class"] = "form-control";
            $this->ISALKES->EditCustomAttributes = "";
            if (!$this->ISALKES->Raw) {
                $this->ISALKES->CurrentValue = HtmlDecode($this->ISALKES->CurrentValue);
            }
            $this->ISALKES->EditValue = HtmlEncode($this->ISALKES->CurrentValue);
            $this->ISALKES->PlaceHolder = RemoveHtml($this->ISALKES->caption());

            // SIZE_ORDER
            $this->SIZE_ORDER->EditAttrs["class"] = "form-control";
            $this->SIZE_ORDER->EditCustomAttributes = "";
            $this->SIZE_ORDER->EditValue = HtmlEncode($this->SIZE_ORDER->CurrentValue);
            $this->SIZE_ORDER->PlaceHolder = RemoveHtml($this->SIZE_ORDER->caption());
            if (strval($this->SIZE_ORDER->EditValue) != "" && is_numeric($this->SIZE_ORDER->EditValue)) {
                $this->SIZE_ORDER->EditValue = FormatNumber($this->SIZE_ORDER->EditValue, -2, -2, -2, -2);
            }

            // ORDER_PRICE
            $this->ORDER_PRICE->EditAttrs["class"] = "form-control";
            $this->ORDER_PRICE->EditCustomAttributes = "";
            $this->ORDER_PRICE->EditValue = HtmlEncode($this->ORDER_PRICE->CurrentValue);
            $this->ORDER_PRICE->PlaceHolder = RemoveHtml($this->ORDER_PRICE->caption());
            if (strval($this->ORDER_PRICE->EditValue) != "" && is_numeric($this->ORDER_PRICE->EditValue)) {
                $this->ORDER_PRICE->EditValue = FormatNumber($this->ORDER_PRICE->EditValue, -2, -2, -2, -2);
            }

            // ISFORMULARIUM
            $this->ISFORMULARIUM->EditAttrs["class"] = "form-control";
            $this->ISFORMULARIUM->EditCustomAttributes = "";
            if (!$this->ISFORMULARIUM->Raw) {
                $this->ISFORMULARIUM->CurrentValue = HtmlDecode($this->ISFORMULARIUM->CurrentValue);
            }
            $this->ISFORMULARIUM->EditValue = HtmlEncode($this->ISFORMULARIUM->CurrentValue);
            $this->ISFORMULARIUM->PlaceHolder = RemoveHtml($this->ISFORMULARIUM->caption());

            // ISESSENTIAL
            $this->ISESSENTIAL->EditAttrs["class"] = "form-control";
            $this->ISESSENTIAL->EditCustomAttributes = "";
            if (!$this->ISESSENTIAL->Raw) {
                $this->ISESSENTIAL->CurrentValue = HtmlDecode($this->ISESSENTIAL->CurrentValue);
            }
            $this->ISESSENTIAL->EditValue = HtmlEncode($this->ISESSENTIAL->CurrentValue);
            $this->ISESSENTIAL->PlaceHolder = RemoveHtml($this->ISESSENTIAL->caption());

            // AVGDATE
            $this->AVGDATE->EditAttrs["class"] = "form-control";
            $this->AVGDATE->EditCustomAttributes = "";
            $this->AVGDATE->EditValue = HtmlEncode(FormatDateTime($this->AVGDATE->CurrentValue, 8));
            $this->AVGDATE->PlaceHolder = RemoveHtml($this->AVGDATE->caption());

            // STOCK_MINIMAL
            $this->STOCK_MINIMAL->EditAttrs["class"] = "form-control";
            $this->STOCK_MINIMAL->EditCustomAttributes = "";
            $this->STOCK_MINIMAL->EditValue = HtmlEncode($this->STOCK_MINIMAL->CurrentValue);
            $this->STOCK_MINIMAL->PlaceHolder = RemoveHtml($this->STOCK_MINIMAL->caption());
            if (strval($this->STOCK_MINIMAL->EditValue) != "" && is_numeric($this->STOCK_MINIMAL->EditValue)) {
                $this->STOCK_MINIMAL->EditValue = FormatNumber($this->STOCK_MINIMAL->EditValue, -2, -2, -2, -2);
            }

            // STOCK_MINIMAL_APT
            $this->STOCK_MINIMAL_APT->EditAttrs["class"] = "form-control";
            $this->STOCK_MINIMAL_APT->EditCustomAttributes = "";
            $this->STOCK_MINIMAL_APT->EditValue = HtmlEncode($this->STOCK_MINIMAL_APT->CurrentValue);
            $this->STOCK_MINIMAL_APT->PlaceHolder = RemoveHtml($this->STOCK_MINIMAL_APT->caption());
            if (strval($this->STOCK_MINIMAL_APT->EditValue) != "" && is_numeric($this->STOCK_MINIMAL_APT->EditValue)) {
                $this->STOCK_MINIMAL_APT->EditValue = FormatNumber($this->STOCK_MINIMAL_APT->EditValue, -2, -2, -2, -2);
            }

            // HET
            $this->HET->EditAttrs["class"] = "form-control";
            $this->HET->EditCustomAttributes = "";
            $this->HET->EditValue = HtmlEncode($this->HET->CurrentValue);
            $this->HET->PlaceHolder = RemoveHtml($this->HET->caption());
            if (strval($this->HET->EditValue) != "" && is_numeric($this->HET->EditValue)) {
                $this->HET->EditValue = FormatNumber($this->HET->EditValue, -2, -2, -2, -2);
            }

            // default_margin
            $this->default_margin->EditAttrs["class"] = "form-control";
            $this->default_margin->EditCustomAttributes = "";
            if (!$this->default_margin->Raw) {
                $this->default_margin->CurrentValue = HtmlDecode($this->default_margin->CurrentValue);
            }
            $this->default_margin->EditValue = HtmlEncode($this->default_margin->CurrentValue);
            $this->default_margin->PlaceHolder = RemoveHtml($this->default_margin->caption());

            // Add refer script

            // CODE_5
            $this->CODE_5->LinkCustomAttributes = "";
            $this->CODE_5->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // NAME
            $this->NAME->LinkCustomAttributes = "";
            $this->NAME->HrefValue = "";

            // OTHER_CODE
            $this->OTHER_CODE->LinkCustomAttributes = "";
            $this->OTHER_CODE->HrefValue = "";

            // BARCODE
            $this->_BARCODE->LinkCustomAttributes = "";
            $this->_BARCODE->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // REORDER_POINT
            $this->REORDER_POINT->LinkCustomAttributes = "";
            $this->REORDER_POINT->HrefValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";

            // NET_PRICE
            $this->NET_PRICE->LinkCustomAttributes = "";
            $this->NET_PRICE->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // TH
            $this->TH->LinkCustomAttributes = "";
            $this->TH->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // MATERIAL_ID
            $this->MATERIAL_ID->LinkCustomAttributes = "";
            $this->MATERIAL_ID->HrefValue = "";

            // FORM_ID
            $this->FORM_ID->LinkCustomAttributes = "";
            $this->FORM_ID->HrefValue = "";

            // ISGENERIC
            $this->ISGENERIC->LinkCustomAttributes = "";
            $this->ISGENERIC->HrefValue = "";

            // REGULATE_ID
            $this->REGULATE_ID->LinkCustomAttributes = "";
            $this->REGULATE_ID->HrefValue = "";

            // PREGNANCY_INDEX
            $this->PREGNANCY_INDEX->LinkCustomAttributes = "";
            $this->PREGNANCY_INDEX->HrefValue = "";

            // INDICATION
            $this->INDICATION->LinkCustomAttributes = "";
            $this->INDICATION->HrefValue = "";

            // TAKE_RULE
            $this->TAKE_RULE->LinkCustomAttributes = "";
            $this->TAKE_RULE->HrefValue = "";

            // SIDE_EFFECT
            $this->SIDE_EFFECT->LinkCustomAttributes = "";
            $this->SIDE_EFFECT->HrefValue = "";

            // INTERACTION
            $this->INTERACTION->LinkCustomAttributes = "";
            $this->INTERACTION->HrefValue = "";

            // CONTRA_INDICATION
            $this->CONTRA_INDICATION->LinkCustomAttributes = "";
            $this->CONTRA_INDICATION->HrefValue = "";

            // WARNING
            $this->WARNING->LinkCustomAttributes = "";
            $this->WARNING->HrefValue = "";

            // STOCK
            $this->STOCK->LinkCustomAttributes = "";
            $this->STOCK->HrefValue = "";

            // ISACTIVE
            $this->ISACTIVE->LinkCustomAttributes = "";
            $this->ISACTIVE->HrefValue = "";

            // ISALKES
            $this->ISALKES->LinkCustomAttributes = "";
            $this->ISALKES->HrefValue = "";

            // SIZE_ORDER
            $this->SIZE_ORDER->LinkCustomAttributes = "";
            $this->SIZE_ORDER->HrefValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";

            // ISFORMULARIUM
            $this->ISFORMULARIUM->LinkCustomAttributes = "";
            $this->ISFORMULARIUM->HrefValue = "";

            // ISESSENTIAL
            $this->ISESSENTIAL->LinkCustomAttributes = "";
            $this->ISESSENTIAL->HrefValue = "";

            // AVGDATE
            $this->AVGDATE->LinkCustomAttributes = "";
            $this->AVGDATE->HrefValue = "";

            // STOCK_MINIMAL
            $this->STOCK_MINIMAL->LinkCustomAttributes = "";
            $this->STOCK_MINIMAL->HrefValue = "";

            // STOCK_MINIMAL_APT
            $this->STOCK_MINIMAL_APT->LinkCustomAttributes = "";
            $this->STOCK_MINIMAL_APT->HrefValue = "";

            // HET
            $this->HET->LinkCustomAttributes = "";
            $this->HET->HrefValue = "";

            // default_margin
            $this->default_margin->LinkCustomAttributes = "";
            $this->default_margin->HrefValue = "";
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
        if ($this->CODE_5->Required) {
            if (!$this->CODE_5->IsDetailKey && EmptyValue($this->CODE_5->FormValue)) {
                $this->CODE_5->addErrorMessage(str_replace("%s", $this->CODE_5->caption(), $this->CODE_5->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_ID->Required) {
            if (!$this->BRAND_ID->IsDetailKey && EmptyValue($this->BRAND_ID->FormValue)) {
                $this->BRAND_ID->addErrorMessage(str_replace("%s", $this->BRAND_ID->caption(), $this->BRAND_ID->RequiredErrorMessage));
            }
        }
        if ($this->NAME->Required) {
            if (!$this->NAME->IsDetailKey && EmptyValue($this->NAME->FormValue)) {
                $this->NAME->addErrorMessage(str_replace("%s", $this->NAME->caption(), $this->NAME->RequiredErrorMessage));
            }
        }
        if ($this->OTHER_CODE->Required) {
            if (!$this->OTHER_CODE->IsDetailKey && EmptyValue($this->OTHER_CODE->FormValue)) {
                $this->OTHER_CODE->addErrorMessage(str_replace("%s", $this->OTHER_CODE->caption(), $this->OTHER_CODE->RequiredErrorMessage));
            }
        }
        if ($this->_BARCODE->Required) {
            if (!$this->_BARCODE->IsDetailKey && EmptyValue($this->_BARCODE->FormValue)) {
                $this->_BARCODE->addErrorMessage(str_replace("%s", $this->_BARCODE->caption(), $this->_BARCODE->RequiredErrorMessage));
            }
        }
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
            }
        }
        if ($this->REORDER_POINT->Required) {
            if (!$this->REORDER_POINT->IsDetailKey && EmptyValue($this->REORDER_POINT->FormValue)) {
                $this->REORDER_POINT->addErrorMessage(str_replace("%s", $this->REORDER_POINT->caption(), $this->REORDER_POINT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->REORDER_POINT->FormValue)) {
            $this->REORDER_POINT->addErrorMessage($this->REORDER_POINT->getErrorMessage(false));
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
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
        }
        if ($this->MEASURE_ID2->Required) {
            if (!$this->MEASURE_ID2->IsDetailKey && EmptyValue($this->MEASURE_ID2->FormValue)) {
                $this->MEASURE_ID2->addErrorMessage(str_replace("%s", $this->MEASURE_ID2->caption(), $this->MEASURE_ID2->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID2->FormValue)) {
            $this->MEASURE_ID2->addErrorMessage($this->MEASURE_ID2->getErrorMessage(false));
        }
        if ($this->SIZE_KEMASAN->Required) {
            if (!$this->SIZE_KEMASAN->IsDetailKey && EmptyValue($this->SIZE_KEMASAN->FormValue)) {
                $this->SIZE_KEMASAN->addErrorMessage(str_replace("%s", $this->SIZE_KEMASAN->caption(), $this->SIZE_KEMASAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_KEMASAN->FormValue)) {
            $this->SIZE_KEMASAN->addErrorMessage($this->SIZE_KEMASAN->getErrorMessage(false));
        }
        if ($this->MEASURE_ID3->Required) {
            if (!$this->MEASURE_ID3->IsDetailKey && EmptyValue($this->MEASURE_ID3->FormValue)) {
                $this->MEASURE_ID3->addErrorMessage(str_replace("%s", $this->MEASURE_ID3->caption(), $this->MEASURE_ID3->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID3->FormValue)) {
            $this->MEASURE_ID3->addErrorMessage($this->MEASURE_ID3->getErrorMessage(false));
        }
        if ($this->COMPANY_ID->Required) {
            if (!$this->COMPANY_ID->IsDetailKey && EmptyValue($this->COMPANY_ID->FormValue)) {
                $this->COMPANY_ID->addErrorMessage(str_replace("%s", $this->COMPANY_ID->caption(), $this->COMPANY_ID->RequiredErrorMessage));
            }
        }
        if ($this->NET_PRICE->Required) {
            if (!$this->NET_PRICE->IsDetailKey && EmptyValue($this->NET_PRICE->FormValue)) {
                $this->NET_PRICE->addErrorMessage(str_replace("%s", $this->NET_PRICE->caption(), $this->NET_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->NET_PRICE->FormValue)) {
            $this->NET_PRICE->addErrorMessage($this->NET_PRICE->getErrorMessage(false));
        }
        if ($this->MODIFIED_DATE->Required) {
            if (!$this->MODIFIED_DATE->IsDetailKey && EmptyValue($this->MODIFIED_DATE->FormValue)) {
                $this->MODIFIED_DATE->addErrorMessage(str_replace("%s", $this->MODIFIED_DATE->caption(), $this->MODIFIED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->MODIFIED_DATE->FormValue)) {
            $this->MODIFIED_DATE->addErrorMessage($this->MODIFIED_DATE->getErrorMessage(false));
        }
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->TH->Required) {
            if (!$this->TH->IsDetailKey && EmptyValue($this->TH->FormValue)) {
                $this->TH->addErrorMessage(str_replace("%s", $this->TH->caption(), $this->TH->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->TH->FormValue)) {
            $this->TH->addErrorMessage($this->TH->getErrorMessage(false));
        }
        if ($this->STATUS_PASIEN_ID->Required) {
            if (!$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_PASIEN_ID->FormValue)) {
            $this->STATUS_PASIEN_ID->addErrorMessage($this->STATUS_PASIEN_ID->getErrorMessage(false));
        }
        if ($this->MATERIAL_ID->Required) {
            if (!$this->MATERIAL_ID->IsDetailKey && EmptyValue($this->MATERIAL_ID->FormValue)) {
                $this->MATERIAL_ID->addErrorMessage(str_replace("%s", $this->MATERIAL_ID->caption(), $this->MATERIAL_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MATERIAL_ID->FormValue)) {
            $this->MATERIAL_ID->addErrorMessage($this->MATERIAL_ID->getErrorMessage(false));
        }
        if ($this->FORM_ID->Required) {
            if (!$this->FORM_ID->IsDetailKey && EmptyValue($this->FORM_ID->FormValue)) {
                $this->FORM_ID->addErrorMessage(str_replace("%s", $this->FORM_ID->caption(), $this->FORM_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FORM_ID->FormValue)) {
            $this->FORM_ID->addErrorMessage($this->FORM_ID->getErrorMessage(false));
        }
        if ($this->ISGENERIC->Required) {
            if (!$this->ISGENERIC->IsDetailKey && EmptyValue($this->ISGENERIC->FormValue)) {
                $this->ISGENERIC->addErrorMessage(str_replace("%s", $this->ISGENERIC->caption(), $this->ISGENERIC->RequiredErrorMessage));
            }
        }
        if ($this->REGULATE_ID->Required) {
            if (!$this->REGULATE_ID->IsDetailKey && EmptyValue($this->REGULATE_ID->FormValue)) {
                $this->REGULATE_ID->addErrorMessage(str_replace("%s", $this->REGULATE_ID->caption(), $this->REGULATE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->REGULATE_ID->FormValue)) {
            $this->REGULATE_ID->addErrorMessage($this->REGULATE_ID->getErrorMessage(false));
        }
        if ($this->PREGNANCY_INDEX->Required) {
            if (!$this->PREGNANCY_INDEX->IsDetailKey && EmptyValue($this->PREGNANCY_INDEX->FormValue)) {
                $this->PREGNANCY_INDEX->addErrorMessage(str_replace("%s", $this->PREGNANCY_INDEX->caption(), $this->PREGNANCY_INDEX->RequiredErrorMessage));
            }
        }
        if ($this->INDICATION->Required) {
            if (!$this->INDICATION->IsDetailKey && EmptyValue($this->INDICATION->FormValue)) {
                $this->INDICATION->addErrorMessage(str_replace("%s", $this->INDICATION->caption(), $this->INDICATION->RequiredErrorMessage));
            }
        }
        if ($this->TAKE_RULE->Required) {
            if (!$this->TAKE_RULE->IsDetailKey && EmptyValue($this->TAKE_RULE->FormValue)) {
                $this->TAKE_RULE->addErrorMessage(str_replace("%s", $this->TAKE_RULE->caption(), $this->TAKE_RULE->RequiredErrorMessage));
            }
        }
        if ($this->SIDE_EFFECT->Required) {
            if (!$this->SIDE_EFFECT->IsDetailKey && EmptyValue($this->SIDE_EFFECT->FormValue)) {
                $this->SIDE_EFFECT->addErrorMessage(str_replace("%s", $this->SIDE_EFFECT->caption(), $this->SIDE_EFFECT->RequiredErrorMessage));
            }
        }
        if ($this->INTERACTION->Required) {
            if (!$this->INTERACTION->IsDetailKey && EmptyValue($this->INTERACTION->FormValue)) {
                $this->INTERACTION->addErrorMessage(str_replace("%s", $this->INTERACTION->caption(), $this->INTERACTION->RequiredErrorMessage));
            }
        }
        if ($this->CONTRA_INDICATION->Required) {
            if (!$this->CONTRA_INDICATION->IsDetailKey && EmptyValue($this->CONTRA_INDICATION->FormValue)) {
                $this->CONTRA_INDICATION->addErrorMessage(str_replace("%s", $this->CONTRA_INDICATION->caption(), $this->CONTRA_INDICATION->RequiredErrorMessage));
            }
        }
        if ($this->WARNING->Required) {
            if (!$this->WARNING->IsDetailKey && EmptyValue($this->WARNING->FormValue)) {
                $this->WARNING->addErrorMessage(str_replace("%s", $this->WARNING->caption(), $this->WARNING->RequiredErrorMessage));
            }
        }
        if ($this->STOCK->Required) {
            if (!$this->STOCK->IsDetailKey && EmptyValue($this->STOCK->FormValue)) {
                $this->STOCK->addErrorMessage(str_replace("%s", $this->STOCK->caption(), $this->STOCK->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK->FormValue)) {
            $this->STOCK->addErrorMessage($this->STOCK->getErrorMessage(false));
        }
        if ($this->ISACTIVE->Required) {
            if (!$this->ISACTIVE->IsDetailKey && EmptyValue($this->ISACTIVE->FormValue)) {
                $this->ISACTIVE->addErrorMessage(str_replace("%s", $this->ISACTIVE->caption(), $this->ISACTIVE->RequiredErrorMessage));
            }
        }
        if ($this->ISALKES->Required) {
            if (!$this->ISALKES->IsDetailKey && EmptyValue($this->ISALKES->FormValue)) {
                $this->ISALKES->addErrorMessage(str_replace("%s", $this->ISALKES->caption(), $this->ISALKES->RequiredErrorMessage));
            }
        }
        if ($this->SIZE_ORDER->Required) {
            if (!$this->SIZE_ORDER->IsDetailKey && EmptyValue($this->SIZE_ORDER->FormValue)) {
                $this->SIZE_ORDER->addErrorMessage(str_replace("%s", $this->SIZE_ORDER->caption(), $this->SIZE_ORDER->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_ORDER->FormValue)) {
            $this->SIZE_ORDER->addErrorMessage($this->SIZE_ORDER->getErrorMessage(false));
        }
        if ($this->ORDER_PRICE->Required) {
            if (!$this->ORDER_PRICE->IsDetailKey && EmptyValue($this->ORDER_PRICE->FormValue)) {
                $this->ORDER_PRICE->addErrorMessage(str_replace("%s", $this->ORDER_PRICE->caption(), $this->ORDER_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_PRICE->FormValue)) {
            $this->ORDER_PRICE->addErrorMessage($this->ORDER_PRICE->getErrorMessage(false));
        }
        if ($this->ISFORMULARIUM->Required) {
            if (!$this->ISFORMULARIUM->IsDetailKey && EmptyValue($this->ISFORMULARIUM->FormValue)) {
                $this->ISFORMULARIUM->addErrorMessage(str_replace("%s", $this->ISFORMULARIUM->caption(), $this->ISFORMULARIUM->RequiredErrorMessage));
            }
        }
        if ($this->ISESSENTIAL->Required) {
            if (!$this->ISESSENTIAL->IsDetailKey && EmptyValue($this->ISESSENTIAL->FormValue)) {
                $this->ISESSENTIAL->addErrorMessage(str_replace("%s", $this->ISESSENTIAL->caption(), $this->ISESSENTIAL->RequiredErrorMessage));
            }
        }
        if ($this->AVGDATE->Required) {
            if (!$this->AVGDATE->IsDetailKey && EmptyValue($this->AVGDATE->FormValue)) {
                $this->AVGDATE->addErrorMessage(str_replace("%s", $this->AVGDATE->caption(), $this->AVGDATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->AVGDATE->FormValue)) {
            $this->AVGDATE->addErrorMessage($this->AVGDATE->getErrorMessage(false));
        }
        if ($this->STOCK_MINIMAL->Required) {
            if (!$this->STOCK_MINIMAL->IsDetailKey && EmptyValue($this->STOCK_MINIMAL->FormValue)) {
                $this->STOCK_MINIMAL->addErrorMessage(str_replace("%s", $this->STOCK_MINIMAL->caption(), $this->STOCK_MINIMAL->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_MINIMAL->FormValue)) {
            $this->STOCK_MINIMAL->addErrorMessage($this->STOCK_MINIMAL->getErrorMessage(false));
        }
        if ($this->STOCK_MINIMAL_APT->Required) {
            if (!$this->STOCK_MINIMAL_APT->IsDetailKey && EmptyValue($this->STOCK_MINIMAL_APT->FormValue)) {
                $this->STOCK_MINIMAL_APT->addErrorMessage(str_replace("%s", $this->STOCK_MINIMAL_APT->caption(), $this->STOCK_MINIMAL_APT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->STOCK_MINIMAL_APT->FormValue)) {
            $this->STOCK_MINIMAL_APT->addErrorMessage($this->STOCK_MINIMAL_APT->getErrorMessage(false));
        }
        if ($this->HET->Required) {
            if (!$this->HET->IsDetailKey && EmptyValue($this->HET->FormValue)) {
                $this->HET->addErrorMessage(str_replace("%s", $this->HET->caption(), $this->HET->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->HET->FormValue)) {
            $this->HET->addErrorMessage($this->HET->getErrorMessage(false));
        }
        if ($this->default_margin->Required) {
            if (!$this->default_margin->IsDetailKey && EmptyValue($this->default_margin->FormValue)) {
                $this->default_margin->addErrorMessage(str_replace("%s", $this->default_margin->caption(), $this->default_margin->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        if ($this->BRAND_ID->CurrentValue != "") { // Check field with unique index
            $filter = "([BRAND_ID] = '" . AdjustSql($this->BRAND_ID->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->BRAND_ID->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->BRAND_ID->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // CODE_5
        $this->CODE_5->setDbValueDef($rsnew, $this->CODE_5->CurrentValue, "", false);

        // BRAND_ID
        $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", false);

        // NAME
        $this->NAME->setDbValueDef($rsnew, $this->NAME->CurrentValue, null, false);

        // OTHER_CODE
        $this->OTHER_CODE->setDbValueDef($rsnew, $this->OTHER_CODE->CurrentValue, null, false);

        // BARCODE
        $this->_BARCODE->setDbValueDef($rsnew, $this->_BARCODE->CurrentValue, null, false);

        // DESCRIPTION
        $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, false);

        // REORDER_POINT
        $this->REORDER_POINT->setDbValueDef($rsnew, $this->REORDER_POINT->CurrentValue, null, false);

        // SIZE_GOODS
        $this->SIZE_GOODS->setDbValueDef($rsnew, $this->SIZE_GOODS->CurrentValue, null, false);

        // MEASURE_DOSIS
        $this->MEASURE_DOSIS->setDbValueDef($rsnew, $this->MEASURE_DOSIS->CurrentValue, null, strval($this->MEASURE_DOSIS->CurrentValue) == "");

        // MEASURE_ID
        $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, strval($this->MEASURE_ID->CurrentValue) == "");

        // MEASURE_ID2
        $this->MEASURE_ID2->setDbValueDef($rsnew, $this->MEASURE_ID2->CurrentValue, null, strval($this->MEASURE_ID2->CurrentValue) == "");

        // SIZE_KEMASAN
        $this->SIZE_KEMASAN->setDbValueDef($rsnew, $this->SIZE_KEMASAN->CurrentValue, null, strval($this->SIZE_KEMASAN->CurrentValue) == "");

        // MEASURE_ID3
        $this->MEASURE_ID3->setDbValueDef($rsnew, $this->MEASURE_ID3->CurrentValue, null, strval($this->MEASURE_ID3->CurrentValue) == "");

        // COMPANY_ID
        $this->COMPANY_ID->setDbValueDef($rsnew, $this->COMPANY_ID->CurrentValue, null, false);

        // NET_PRICE
        $this->NET_PRICE->setDbValueDef($rsnew, $this->NET_PRICE->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // TH
        $this->TH->setDbValueDef($rsnew, $this->TH->CurrentValue, null, false);

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->setDbValueDef($rsnew, $this->STATUS_PASIEN_ID->CurrentValue, null, strval($this->STATUS_PASIEN_ID->CurrentValue) == "");

        // MATERIAL_ID
        $this->MATERIAL_ID->setDbValueDef($rsnew, $this->MATERIAL_ID->CurrentValue, null, false);

        // FORM_ID
        $this->FORM_ID->setDbValueDef($rsnew, $this->FORM_ID->CurrentValue, null, false);

        // ISGENERIC
        $this->ISGENERIC->setDbValueDef($rsnew, $this->ISGENERIC->CurrentValue, null, false);

        // REGULATE_ID
        $this->REGULATE_ID->setDbValueDef($rsnew, $this->REGULATE_ID->CurrentValue, null, false);

        // PREGNANCY_INDEX
        $this->PREGNANCY_INDEX->setDbValueDef($rsnew, $this->PREGNANCY_INDEX->CurrentValue, null, false);

        // INDICATION
        $this->INDICATION->setDbValueDef($rsnew, $this->INDICATION->CurrentValue, null, false);

        // TAKE_RULE
        $this->TAKE_RULE->setDbValueDef($rsnew, $this->TAKE_RULE->CurrentValue, null, false);

        // SIDE_EFFECT
        $this->SIDE_EFFECT->setDbValueDef($rsnew, $this->SIDE_EFFECT->CurrentValue, null, false);

        // INTERACTION
        $this->INTERACTION->setDbValueDef($rsnew, $this->INTERACTION->CurrentValue, null, false);

        // CONTRA_INDICATION
        $this->CONTRA_INDICATION->setDbValueDef($rsnew, $this->CONTRA_INDICATION->CurrentValue, null, false);

        // WARNING
        $this->WARNING->setDbValueDef($rsnew, $this->WARNING->CurrentValue, null, false);

        // STOCK
        $this->STOCK->setDbValueDef($rsnew, $this->STOCK->CurrentValue, null, strval($this->STOCK->CurrentValue) == "");

        // ISACTIVE
        $this->ISACTIVE->setDbValueDef($rsnew, $this->ISACTIVE->CurrentValue, null, strval($this->ISACTIVE->CurrentValue) == "");

        // ISALKES
        $this->ISALKES->setDbValueDef($rsnew, $this->ISALKES->CurrentValue, null, strval($this->ISALKES->CurrentValue) == "");

        // SIZE_ORDER
        $this->SIZE_ORDER->setDbValueDef($rsnew, $this->SIZE_ORDER->CurrentValue, null, false);

        // ORDER_PRICE
        $this->ORDER_PRICE->setDbValueDef($rsnew, $this->ORDER_PRICE->CurrentValue, null, false);

        // ISFORMULARIUM
        $this->ISFORMULARIUM->setDbValueDef($rsnew, $this->ISFORMULARIUM->CurrentValue, null, false);

        // ISESSENTIAL
        $this->ISESSENTIAL->setDbValueDef($rsnew, $this->ISESSENTIAL->CurrentValue, null, false);

        // AVGDATE
        $this->AVGDATE->setDbValueDef($rsnew, UnFormatDateTime($this->AVGDATE->CurrentValue, 0), null, false);

        // STOCK_MINIMAL
        $this->STOCK_MINIMAL->setDbValueDef($rsnew, $this->STOCK_MINIMAL->CurrentValue, null, false);

        // STOCK_MINIMAL_APT
        $this->STOCK_MINIMAL_APT->setDbValueDef($rsnew, $this->STOCK_MINIMAL_APT->CurrentValue, null, false);

        // HET
        $this->HET->setDbValueDef($rsnew, $this->HET->CurrentValue, null, false);

        // default_margin
        $this->default_margin->setDbValueDef($rsnew, $this->default_margin->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['BRAND_ID']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GoodsList"), "", $this->TableVar, true);
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
