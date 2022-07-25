<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CustomView1Add extends CustomView1
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'CustomView1';

    // Page object name
    public $PageObjName = "CustomView1Add";

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

        // Table object (CustomView1)
        if (!isset($GLOBALS["CustomView1"]) || get_class($GLOBALS["CustomView1"]) == PROJECT_NAMESPACE . "CustomView1") {
            $GLOBALS["CustomView1"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'CustomView1');
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
                $doc = new $class(Container("CustomView1"));
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
                    if ($pageName == "CustomView1View") {
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
        $this->VISIT_ID->setVisibility();
        $this->BILL_ID->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->THENAME->setVisibility();
        $this->THEADDRESS->setVisibility();
        $this->THEID->setVisibility();
        $this->TARIF_ID->setVisibility();
        $this->CLASS_ID->Visible = false;
        $this->CLINIC_ID->Visible = false;
        $this->CLINIC_ID_FROM->Visible = false;
        $this->TREATMENT->setVisibility();
        $this->TREAT_DATE->Visible = false;
        $this->sell_price->Visible = false;
        $this->QUANTITY->setVisibility();
        $this->amount_paid->Visible = false;
        $this->AMOUNT->Visible = false;
        $this->POKOK_JUAL->Visible = false;
        $this->PPN->Visible = false;
        $this->SUBSIDI->Visible = false;
        $this->KUITANSI_ID->Visible = false;
        $this->NOTA_NO->Visible = false;
        $this->ISCETAK->Visible = false;
        $this->PRINT_DATE->Visible = false;
        $this->diskon->Visible = false;
        $this->TAGIHAN->Visible = false;
        $this->TRANS_ID->setVisibility();
        $this->ID->Visible = false;
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
        $this->setupLookupOptions($this->NO_REGISTRATION);
        $this->setupLookupOptions($this->TARIF_ID);
        $this->setupLookupOptions($this->CLINIC_ID);

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
            if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                $this->ID->setQueryStringValue($keyValue);
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
                    $this->terminate("CustomView1List"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "CustomView1List") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "CustomView1View") {
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
        $this->VISIT_ID->CurrentValue = null;
        $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
        $this->BILL_ID->CurrentValue = null;
        $this->BILL_ID->OldValue = $this->BILL_ID->CurrentValue;
        $this->NO_REGISTRATION->CurrentValue = null;
        $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
        $this->THENAME->CurrentValue = null;
        $this->THENAME->OldValue = $this->THENAME->CurrentValue;
        $this->THEADDRESS->CurrentValue = null;
        $this->THEADDRESS->OldValue = $this->THEADDRESS->CurrentValue;
        $this->THEID->CurrentValue = null;
        $this->THEID->OldValue = $this->THEID->CurrentValue;
        $this->TARIF_ID->CurrentValue = null;
        $this->TARIF_ID->OldValue = $this->TARIF_ID->CurrentValue;
        $this->CLASS_ID->CurrentValue = 0;
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->CLINIC_ID_FROM->CurrentValue = null;
        $this->CLINIC_ID_FROM->OldValue = $this->CLINIC_ID_FROM->CurrentValue;
        $this->TREATMENT->CurrentValue = null;
        $this->TREATMENT->OldValue = $this->TREATMENT->CurrentValue;
        $this->TREAT_DATE->CurrentValue = CurrentDateTime();
        $this->sell_price->CurrentValue = null;
        $this->sell_price->OldValue = $this->sell_price->CurrentValue;
        $this->QUANTITY->CurrentValue = 1;
        $this->amount_paid->CurrentValue = 0;
        $this->AMOUNT->CurrentValue = null;
        $this->AMOUNT->OldValue = $this->AMOUNT->CurrentValue;
        $this->POKOK_JUAL->CurrentValue = 0;
        $this->PPN->CurrentValue = 0;
        $this->SUBSIDI->CurrentValue = 0;
        $this->KUITANSI_ID->CurrentValue = null;
        $this->KUITANSI_ID->OldValue = $this->KUITANSI_ID->CurrentValue;
        $this->NOTA_NO->CurrentValue = null;
        $this->NOTA_NO->OldValue = $this->NOTA_NO->CurrentValue;
        $this->ISCETAK->CurrentValue = "1";
        $this->PRINT_DATE->CurrentValue = null;
        $this->PRINT_DATE->OldValue = $this->PRINT_DATE->CurrentValue;
        $this->diskon->CurrentValue = null;
        $this->diskon->OldValue = $this->diskon->CurrentValue;
        $this->TAGIHAN->CurrentValue = null;
        $this->TAGIHAN->OldValue = $this->TAGIHAN->CurrentValue;
        $this->TRANS_ID->CurrentValue = null;
        $this->TRANS_ID->OldValue = $this->TRANS_ID->CurrentValue;
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'VISIT_ID' first before field var 'x_VISIT_ID'
        $val = $CurrentForm->hasValue("VISIT_ID") ? $CurrentForm->getValue("VISIT_ID") : $CurrentForm->getValue("x_VISIT_ID");
        if (!$this->VISIT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_ID->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_ID->setFormValue($val);
            }
        }

        // Check field name 'BILL_ID' first before field var 'x_BILL_ID'
        $val = $CurrentForm->hasValue("BILL_ID") ? $CurrentForm->getValue("BILL_ID") : $CurrentForm->getValue("x_BILL_ID");
        if (!$this->BILL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BILL_ID->Visible = false; // Disable update for API request
            } else {
                $this->BILL_ID->setFormValue($val);
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

        // Check field name 'THENAME' first before field var 'x_THENAME'
        $val = $CurrentForm->hasValue("THENAME") ? $CurrentForm->getValue("THENAME") : $CurrentForm->getValue("x_THENAME");
        if (!$this->THENAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THENAME->Visible = false; // Disable update for API request
            } else {
                $this->THENAME->setFormValue($val);
            }
        }

        // Check field name 'THEADDRESS' first before field var 'x_THEADDRESS'
        $val = $CurrentForm->hasValue("THEADDRESS") ? $CurrentForm->getValue("THEADDRESS") : $CurrentForm->getValue("x_THEADDRESS");
        if (!$this->THEADDRESS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THEADDRESS->Visible = false; // Disable update for API request
            } else {
                $this->THEADDRESS->setFormValue($val);
            }
        }

        // Check field name 'THEID' first before field var 'x_THEID'
        $val = $CurrentForm->hasValue("THEID") ? $CurrentForm->getValue("THEID") : $CurrentForm->getValue("x_THEID");
        if (!$this->THEID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->THEID->Visible = false; // Disable update for API request
            } else {
                $this->THEID->setFormValue($val);
            }
        }

        // Check field name 'TARIF_ID' first before field var 'x_TARIF_ID'
        $val = $CurrentForm->hasValue("TARIF_ID") ? $CurrentForm->getValue("TARIF_ID") : $CurrentForm->getValue("x_TARIF_ID");
        if (!$this->TARIF_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TARIF_ID->Visible = false; // Disable update for API request
            } else {
                $this->TARIF_ID->setFormValue($val);
            }
        }

        // Check field name 'TREATMENT' first before field var 'x_TREATMENT'
        $val = $CurrentForm->hasValue("TREATMENT") ? $CurrentForm->getValue("TREATMENT") : $CurrentForm->getValue("x_TREATMENT");
        if (!$this->TREATMENT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TREATMENT->Visible = false; // Disable update for API request
            } else {
                $this->TREATMENT->setFormValue($val);
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

        // Check field name 'TRANS_ID' first before field var 'x_TRANS_ID'
        $val = $CurrentForm->hasValue("TRANS_ID") ? $CurrentForm->getValue("TRANS_ID") : $CurrentForm->getValue("x_TRANS_ID");
        if (!$this->TRANS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->TRANS_ID->Visible = false; // Disable update for API request
            } else {
                $this->TRANS_ID->setFormValue($val);
            }
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->BILL_ID->CurrentValue = $this->BILL_ID->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->THENAME->CurrentValue = $this->THENAME->FormValue;
        $this->THEADDRESS->CurrentValue = $this->THEADDRESS->FormValue;
        $this->THEID->CurrentValue = $this->THEID->FormValue;
        $this->TARIF_ID->CurrentValue = $this->TARIF_ID->FormValue;
        $this->TREATMENT->CurrentValue = $this->TREATMENT->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
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
        $this->BILL_ID->setDbValue($row['BILL_ID']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->THEADDRESS->setDbValue($row['THEADDRESS']);
        $this->THEID->setDbValue($row['THEID']);
        $this->TARIF_ID->setDbValue($row['TARIF_ID']);
        $this->CLASS_ID->setDbValue($row['CLASS_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->CLINIC_ID_FROM->setDbValue($row['CLINIC_ID_FROM']);
        $this->TREATMENT->setDbValue($row['TREATMENT']);
        $this->TREAT_DATE->setDbValue($row['TREAT_DATE']);
        $this->sell_price->setDbValue($row['sell_price']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->amount_paid->setDbValue($row['amount_paid']);
        $this->AMOUNT->setDbValue($row['AMOUNT']);
        $this->POKOK_JUAL->setDbValue($row['POKOK_JUAL']);
        $this->PPN->setDbValue($row['PPN']);
        $this->SUBSIDI->setDbValue($row['SUBSIDI']);
        $this->KUITANSI_ID->setDbValue($row['KUITANSI_ID']);
        $this->NOTA_NO->setDbValue($row['NOTA_NO']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->diskon->setDbValue($row['diskon']);
        $this->TAGIHAN->setDbValue($row['TAGIHAN']);
        $this->TRANS_ID->setDbValue($row['TRANS_ID']);
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['VISIT_ID'] = $this->VISIT_ID->CurrentValue;
        $row['BILL_ID'] = $this->BILL_ID->CurrentValue;
        $row['NO_REGISTRATION'] = $this->NO_REGISTRATION->CurrentValue;
        $row['THENAME'] = $this->THENAME->CurrentValue;
        $row['THEADDRESS'] = $this->THEADDRESS->CurrentValue;
        $row['THEID'] = $this->THEID->CurrentValue;
        $row['TARIF_ID'] = $this->TARIF_ID->CurrentValue;
        $row['CLASS_ID'] = $this->CLASS_ID->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['CLINIC_ID_FROM'] = $this->CLINIC_ID_FROM->CurrentValue;
        $row['TREATMENT'] = $this->TREATMENT->CurrentValue;
        $row['TREAT_DATE'] = $this->TREAT_DATE->CurrentValue;
        $row['sell_price'] = $this->sell_price->CurrentValue;
        $row['QUANTITY'] = $this->QUANTITY->CurrentValue;
        $row['amount_paid'] = $this->amount_paid->CurrentValue;
        $row['AMOUNT'] = $this->AMOUNT->CurrentValue;
        $row['POKOK_JUAL'] = $this->POKOK_JUAL->CurrentValue;
        $row['PPN'] = $this->PPN->CurrentValue;
        $row['SUBSIDI'] = $this->SUBSIDI->CurrentValue;
        $row['KUITANSI_ID'] = $this->KUITANSI_ID->CurrentValue;
        $row['NOTA_NO'] = $this->NOTA_NO->CurrentValue;
        $row['ISCETAK'] = $this->ISCETAK->CurrentValue;
        $row['PRINT_DATE'] = $this->PRINT_DATE->CurrentValue;
        $row['diskon'] = $this->diskon->CurrentValue;
        $row['TAGIHAN'] = $this->TAGIHAN->CurrentValue;
        $row['TRANS_ID'] = $this->TRANS_ID->CurrentValue;
        $row['ID'] = $this->ID->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // VISIT_ID

        // BILL_ID

        // NO_REGISTRATION

        // THENAME

        // THEADDRESS

        // THEID

        // TARIF_ID

        // CLASS_ID

        // CLINIC_ID

        // CLINIC_ID_FROM

        // TREATMENT

        // TREAT_DATE

        // sell_price

        // QUANTITY

        // amount_paid

        // AMOUNT

        // POKOK_JUAL

        // PPN

        // SUBSIDI

        // KUITANSI_ID

        // NOTA_NO

        // ISCETAK

        // PRINT_DATE

        // diskon

        // TAGIHAN

        // TRANS_ID

        // ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // BILL_ID
            $this->BILL_ID->ViewValue = $this->BILL_ID->CurrentValue;
            $this->BILL_ID->ViewCustomAttributes = "";

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

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // THEADDRESS
            $this->THEADDRESS->ViewValue = $this->THEADDRESS->CurrentValue;
            $this->THEADDRESS->ViewCustomAttributes = "";

            // THEID
            $this->THEID->ViewValue = $this->THEID->CurrentValue;
            $this->THEID->ViewCustomAttributes = "";

            // TARIF_ID
            $curVal = trim(strval($this->TARIF_ID->CurrentValue));
            if ($curVal != "") {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
                if ($this->TARIF_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[TARIF_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[IMPLEMENTED] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->TARIF_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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
            $this->CLINIC_ID_FROM->ViewValue = $this->CLINIC_ID_FROM->CurrentValue;
            $this->CLINIC_ID_FROM->ViewCustomAttributes = "";

            // TREATMENT
            $this->TREATMENT->ViewValue = $this->TREATMENT->CurrentValue;
            $this->TREATMENT->ViewCustomAttributes = "";

            // TREAT_DATE
            $this->TREAT_DATE->ViewValue = $this->TREAT_DATE->CurrentValue;
            $this->TREAT_DATE->ViewValue = FormatDateTime($this->TREAT_DATE->ViewValue, 11);
            $this->TREAT_DATE->ViewCustomAttributes = "";

            // sell_price
            $this->sell_price->ViewValue = $this->sell_price->CurrentValue;
            $this->sell_price->ViewValue = FormatNumber($this->sell_price->ViewValue, 0, -2, -2, -2);
            $this->sell_price->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 0, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // amount_paid
            $this->amount_paid->ViewValue = $this->amount_paid->CurrentValue;
            $this->amount_paid->ViewValue = FormatNumber($this->amount_paid->ViewValue, 2, -2, -2, -2);
            $this->amount_paid->ViewCustomAttributes = "";

            // AMOUNT
            $this->AMOUNT->ViewValue = $this->AMOUNT->CurrentValue;
            $this->AMOUNT->ViewValue = FormatNumber($this->AMOUNT->ViewValue, 0, -2, -2, -2);
            $this->AMOUNT->ViewCustomAttributes = "";

            // POKOK_JUAL
            $this->POKOK_JUAL->ViewValue = $this->POKOK_JUAL->CurrentValue;
            $this->POKOK_JUAL->ViewValue = FormatNumber($this->POKOK_JUAL->ViewValue, 2, -2, -2, -2);
            $this->POKOK_JUAL->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 2, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // SUBSIDI
            $this->SUBSIDI->ViewValue = $this->SUBSIDI->CurrentValue;
            $this->SUBSIDI->ViewValue = FormatNumber($this->SUBSIDI->ViewValue, 2, -2, -2, -2);
            $this->SUBSIDI->ViewCustomAttributes = "";

            // KUITANSI_ID
            $this->KUITANSI_ID->ViewValue = $this->KUITANSI_ID->CurrentValue;
            $this->KUITANSI_ID->ViewCustomAttributes = "";

            // NOTA_NO
            $this->NOTA_NO->ViewValue = $this->NOTA_NO->CurrentValue;
            $this->NOTA_NO->ViewCustomAttributes = "";

            // ISCETAK
            $this->ISCETAK->ViewValue = $this->ISCETAK->CurrentValue;
            $this->ISCETAK->ViewCustomAttributes = "";

            // PRINT_DATE
            $this->PRINT_DATE->ViewValue = $this->PRINT_DATE->CurrentValue;
            $this->PRINT_DATE->ViewValue = FormatDateTime($this->PRINT_DATE->ViewValue, 0);
            $this->PRINT_DATE->ViewCustomAttributes = "";

            // diskon
            $this->diskon->ViewValue = $this->diskon->CurrentValue;
            $this->diskon->ViewValue = FormatNumber($this->diskon->ViewValue, 2, -2, -2, -2);
            $this->diskon->ViewCustomAttributes = "";

            // TAGIHAN
            $this->TAGIHAN->ViewValue = $this->TAGIHAN->CurrentValue;
            $this->TAGIHAN->ViewValue = FormatNumber($this->TAGIHAN->ViewValue, 0, -2, -2, -2);
            $this->TAGIHAN->ViewCustomAttributes = "";

            // TRANS_ID
            $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
            $this->TRANS_ID->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";

            // BILL_ID
            $this->BILL_ID->LinkCustomAttributes = "";
            $this->BILL_ID->HrefValue = "";
            $this->BILL_ID->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

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

            // TARIF_ID
            $this->TARIF_ID->LinkCustomAttributes = "";
            $this->TARIF_ID->HrefValue = "";
            $this->TARIF_ID->TooltipValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";
            $this->TREATMENT->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // TRANS_ID
            $this->TRANS_ID->LinkCustomAttributes = "";
            $this->TRANS_ID->HrefValue = "";
            $this->TRANS_ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if ($this->VISIT_ID->getSessionValue() != "") {
                $this->VISIT_ID->CurrentValue = GetForeignKeyValue($this->VISIT_ID->getSessionValue());
                $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
                $this->VISIT_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->VISIT_ID->Raw) {
                    $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
                }
                $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
                $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());
            }

            // BILL_ID
            $this->BILL_ID->EditAttrs["class"] = "form-control";
            $this->BILL_ID->EditCustomAttributes = 'readonly';
            if (!$this->BILL_ID->Raw) {
                $this->BILL_ID->CurrentValue = HtmlDecode($this->BILL_ID->CurrentValue);
            }
            $this->BILL_ID->EditValue = HtmlEncode($this->BILL_ID->CurrentValue);
            $this->BILL_ID->PlaceHolder = RemoveHtml($this->BILL_ID->caption());

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if ($this->NO_REGISTRATION->getSessionValue() != "") {
                $this->NO_REGISTRATION->CurrentValue = GetForeignKeyValue($this->NO_REGISTRATION->getSessionValue());
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
            } else {
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
            }

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
                $this->THENAME->EditValue = HtmlEncode($this->THENAME->CurrentValue);
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
                $this->THEADDRESS->EditValue = HtmlEncode($this->THEADDRESS->CurrentValue);
                $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());
            }

            // THEID
            $this->THEID->EditAttrs["class"] = "form-control";
            $this->THEID->EditCustomAttributes = "";
            if (!$this->THEID->Raw) {
                $this->THEID->CurrentValue = HtmlDecode($this->THEID->CurrentValue);
            }
            $this->THEID->EditValue = HtmlEncode($this->THEID->CurrentValue);
            $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

            // TARIF_ID
            $this->TARIF_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->TARIF_ID->CurrentValue));
            if ($curVal != "") {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->lookupCacheOption($curVal);
            } else {
                $this->TARIF_ID->ViewValue = $this->TARIF_ID->Lookup !== null && is_array($this->TARIF_ID->Lookup->Options) ? $curVal : null;
            }
            if ($this->TARIF_ID->ViewValue !== null) { // Load from cache
                $this->TARIF_ID->EditValue = array_values($this->TARIF_ID->Lookup->Options);
                if ($this->TARIF_ID->ViewValue == "") {
                    $this->TARIF_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "[TARIF_ID]" . SearchString("=", $this->TARIF_ID->CurrentValue, DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return "[IMPLEMENTED] = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->TARIF_ID->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->TARIF_ID->Lookup->renderViewRow($rswrk[0]);
                    $this->TARIF_ID->ViewValue = $this->TARIF_ID->displayValue($arwrk);
                } else {
                    $this->TARIF_ID->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->TARIF_ID->Lookup->renderViewRow($row);
                $this->TARIF_ID->EditValue = $arwrk;
            }
            $this->TARIF_ID->PlaceHolder = RemoveHtml($this->TARIF_ID->caption());

            // TREATMENT
            $this->TREATMENT->EditAttrs["class"] = "form-control";
            $this->TREATMENT->EditCustomAttributes = "";
            if (!$this->TREATMENT->Raw) {
                $this->TREATMENT->CurrentValue = HtmlDecode($this->TREATMENT->CurrentValue);
            }
            $this->TREATMENT->EditValue = HtmlEncode($this->TREATMENT->CurrentValue);
            $this->TREATMENT->PlaceHolder = RemoveHtml($this->TREATMENT->caption());

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // TRANS_ID
            $this->TRANS_ID->EditAttrs["class"] = "form-control";
            $this->TRANS_ID->EditCustomAttributes = "";
            if ($this->TRANS_ID->getSessionValue() != "") {
                $this->TRANS_ID->CurrentValue = GetForeignKeyValue($this->TRANS_ID->getSessionValue());
                $this->TRANS_ID->ViewValue = $this->TRANS_ID->CurrentValue;
                $this->TRANS_ID->ViewCustomAttributes = "";
            } else {
                if (!$this->TRANS_ID->Raw) {
                    $this->TRANS_ID->CurrentValue = HtmlDecode($this->TRANS_ID->CurrentValue);
                }
                $this->TRANS_ID->EditValue = HtmlEncode($this->TRANS_ID->CurrentValue);
                $this->TRANS_ID->PlaceHolder = RemoveHtml($this->TRANS_ID->caption());
            }

            // Add refer script

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";

            // BILL_ID
            $this->BILL_ID->LinkCustomAttributes = "";
            $this->BILL_ID->HrefValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";

            // THEID
            $this->THEID->LinkCustomAttributes = "";
            $this->THEID->HrefValue = "";

            // TARIF_ID
            $this->TARIF_ID->LinkCustomAttributes = "";
            $this->TARIF_ID->HrefValue = "";

            // TREATMENT
            $this->TREATMENT->LinkCustomAttributes = "";
            $this->TREATMENT->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

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
        if ($this->VISIT_ID->Required) {
            if (!$this->VISIT_ID->IsDetailKey && EmptyValue($this->VISIT_ID->FormValue)) {
                $this->VISIT_ID->addErrorMessage(str_replace("%s", $this->VISIT_ID->caption(), $this->VISIT_ID->RequiredErrorMessage));
            }
        }
        if ($this->BILL_ID->Required) {
            if (!$this->BILL_ID->IsDetailKey && EmptyValue($this->BILL_ID->FormValue)) {
                $this->BILL_ID->addErrorMessage(str_replace("%s", $this->BILL_ID->caption(), $this->BILL_ID->RequiredErrorMessage));
            }
        }
        if ($this->NO_REGISTRATION->Required) {
            if (!$this->NO_REGISTRATION->IsDetailKey && EmptyValue($this->NO_REGISTRATION->FormValue)) {
                $this->NO_REGISTRATION->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION->caption(), $this->NO_REGISTRATION->RequiredErrorMessage));
            }
        }
        if ($this->THENAME->Required) {
            if (!$this->THENAME->IsDetailKey && EmptyValue($this->THENAME->FormValue)) {
                $this->THENAME->addErrorMessage(str_replace("%s", $this->THENAME->caption(), $this->THENAME->RequiredErrorMessage));
            }
        }
        if ($this->THEADDRESS->Required) {
            if (!$this->THEADDRESS->IsDetailKey && EmptyValue($this->THEADDRESS->FormValue)) {
                $this->THEADDRESS->addErrorMessage(str_replace("%s", $this->THEADDRESS->caption(), $this->THEADDRESS->RequiredErrorMessage));
            }
        }
        if ($this->THEID->Required) {
            if (!$this->THEID->IsDetailKey && EmptyValue($this->THEID->FormValue)) {
                $this->THEID->addErrorMessage(str_replace("%s", $this->THEID->caption(), $this->THEID->RequiredErrorMessage));
            }
        }
        if ($this->TARIF_ID->Required) {
            if (!$this->TARIF_ID->IsDetailKey && EmptyValue($this->TARIF_ID->FormValue)) {
                $this->TARIF_ID->addErrorMessage(str_replace("%s", $this->TARIF_ID->caption(), $this->TARIF_ID->RequiredErrorMessage));
            }
        }
        if ($this->TREATMENT->Required) {
            if (!$this->TREATMENT->IsDetailKey && EmptyValue($this->TREATMENT->FormValue)) {
                $this->TREATMENT->addErrorMessage(str_replace("%s", $this->TREATMENT->caption(), $this->TREATMENT->RequiredErrorMessage));
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
        if ($this->TRANS_ID->Required) {
            if (!$this->TRANS_ID->IsDetailKey && EmptyValue($this->TRANS_ID->FormValue)) {
                $this->TRANS_ID->addErrorMessage(str_replace("%s", $this->TRANS_ID->caption(), $this->TRANS_ID->RequiredErrorMessage));
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

        // Check referential integrity for master table 'CustomView1'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_V_LABORATORIUM();
        if (strval($this->VISIT_ID->CurrentValue) != "") {
            $masterFilter = str_replace("@VISIT_ID@", AdjustSql($this->VISIT_ID->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if (strval($this->NO_REGISTRATION->CurrentValue) != "") {
            $masterFilter = str_replace("@NO_REGISTRATION@", AdjustSql($this->NO_REGISTRATION->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if (strval($this->TRANS_ID->CurrentValue) != "") {
            $masterFilter = str_replace("@TRANS_ID@", AdjustSql($this->TRANS_ID->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("V_LABORATORIUM")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "V_LABORATORIUM", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Check referential integrity for master table 'CustomView1'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_V_RADIOLOGI();
        if (strval($this->VISIT_ID->CurrentValue) != "") {
            $masterFilter = str_replace("@VISIT_ID@", AdjustSql($this->VISIT_ID->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if (strval($this->TRANS_ID->CurrentValue) != "") {
            $masterFilter = str_replace("@TRANS_ID@", AdjustSql($this->TRANS_ID->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if (strval($this->NO_REGISTRATION->CurrentValue) != "") {
            $masterFilter = str_replace("@NO_REGISTRATION@", AdjustSql($this->NO_REGISTRATION->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("V_RADIOLOGI")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "V_RADIOLOGI", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Check referential integrity for master table 'CustomView1'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_V_KASIR();
        if (strval($this->VISIT_ID->CurrentValue) != "") {
            $masterFilter = str_replace("@VISIT_ID@", AdjustSql($this->VISIT_ID->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if (strval($this->NO_REGISTRATION->CurrentValue) != "") {
            $masterFilter = str_replace("@NO_REGISTRATION@", AdjustSql($this->NO_REGISTRATION->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("V_KASIR")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "V_KASIR", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // VISIT_ID
        $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, "", false);

        // BILL_ID
        $this->BILL_ID->setDbValueDef($rsnew, $this->BILL_ID->CurrentValue, "", false);

        // NO_REGISTRATION
        $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, "", false);

        // THENAME
        $this->THENAME->setDbValueDef($rsnew, $this->THENAME->CurrentValue, null, false);

        // THEADDRESS
        $this->THEADDRESS->setDbValueDef($rsnew, $this->THEADDRESS->CurrentValue, null, false);

        // THEID
        $this->THEID->setDbValueDef($rsnew, $this->THEID->CurrentValue, null, false);

        // TARIF_ID
        $this->TARIF_ID->setDbValueDef($rsnew, $this->TARIF_ID->CurrentValue, null, false);

        // TREATMENT
        $this->TREATMENT->setDbValueDef($rsnew, $this->TREATMENT->CurrentValue, null, false);

        // QUANTITY
        $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, false);

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
            if ($masterTblVar == "PASIEN_VISITATION") {
                $validMaster = true;
                $masterTbl = Container("PASIEN_VISITATION");
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_VISITOR_ADDRESS", Get("THEADDRESS"))) !== null) {
                    $masterTbl->VISITOR_ADDRESS->setQueryStringValue($parm);
                    $this->THEADDRESS->setQueryStringValue($masterTbl->VISITOR_ADDRESS->QueryStringValue);
                    $this->THEADDRESS->setSessionValue($this->THEADDRESS->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_DIANTAR_OLEH", Get("THENAME"))) !== null) {
                    $masterTbl->DIANTAR_OLEH->setQueryStringValue($parm);
                    $this->THENAME->setQueryStringValue($masterTbl->DIANTAR_OLEH->QueryStringValue);
                    $this->THENAME->setSessionValue($this->THENAME->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_TRANS_ID", Get("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setQueryStringValue($parm);
                    $this->TRANS_ID->setQueryStringValue($masterTbl->TRANS_ID->QueryStringValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_LABORATORIUM") {
                $validMaster = true;
                $masterTbl = Container("V_LABORATORIUM");
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_TRANS_ID", Get("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setQueryStringValue($parm);
                    $this->TRANS_ID->setQueryStringValue($masterTbl->TRANS_ID->QueryStringValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_RADIOLOGI") {
                $validMaster = true;
                $masterTbl = Container("V_RADIOLOGI");
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_TRANS_ID", Get("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setQueryStringValue($parm);
                    $this->TRANS_ID->setQueryStringValue($masterTbl->TRANS_ID->QueryStringValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_FARMASI") {
                $validMaster = true;
                $masterTbl = Container("V_FARMASI");
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_KASIR") {
                $validMaster = true;
                $masterTbl = Container("V_KASIR");
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_REKAM_MEDIS") {
                $validMaster = true;
                $masterTbl = Container("V_REKAM_MEDIS");
                if (($parm = Get("fk_VISIT_ID", Get("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setQueryStringValue($parm);
                    $this->VISIT_ID->setQueryStringValue($masterTbl->VISIT_ID->QueryStringValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->QueryStringValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Get("fk_NO_REGISTRATION", Get("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setQueryStringValue($parm);
                    $this->NO_REGISTRATION->setQueryStringValue($masterTbl->NO_REGISTRATION->QueryStringValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->QueryStringValue);
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
            if ($masterTblVar == "PASIEN_VISITATION") {
                $validMaster = true;
                $masterTbl = Container("PASIEN_VISITATION");
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_VISITOR_ADDRESS", Post("THEADDRESS"))) !== null) {
                    $masterTbl->VISITOR_ADDRESS->setFormValue($parm);
                    $this->THEADDRESS->setFormValue($masterTbl->VISITOR_ADDRESS->FormValue);
                    $this->THEADDRESS->setSessionValue($this->THEADDRESS->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_DIANTAR_OLEH", Post("THENAME"))) !== null) {
                    $masterTbl->DIANTAR_OLEH->setFormValue($parm);
                    $this->THENAME->setFormValue($masterTbl->DIANTAR_OLEH->FormValue);
                    $this->THENAME->setSessionValue($this->THENAME->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_TRANS_ID", Post("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setFormValue($parm);
                    $this->TRANS_ID->setFormValue($masterTbl->TRANS_ID->FormValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_LABORATORIUM") {
                $validMaster = true;
                $masterTbl = Container("V_LABORATORIUM");
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_TRANS_ID", Post("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setFormValue($parm);
                    $this->TRANS_ID->setFormValue($masterTbl->TRANS_ID->FormValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_RADIOLOGI") {
                $validMaster = true;
                $masterTbl = Container("V_RADIOLOGI");
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_TRANS_ID", Post("TRANS_ID"))) !== null) {
                    $masterTbl->TRANS_ID->setFormValue($parm);
                    $this->TRANS_ID->setFormValue($masterTbl->TRANS_ID->FormValue);
                    $this->TRANS_ID->setSessionValue($this->TRANS_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_FARMASI") {
                $validMaster = true;
                $masterTbl = Container("V_FARMASI");
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_KASIR") {
                $validMaster = true;
                $masterTbl = Container("V_KASIR");
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "V_REKAM_MEDIS") {
                $validMaster = true;
                $masterTbl = Container("V_REKAM_MEDIS");
                if (($parm = Post("fk_VISIT_ID", Post("VISIT_ID"))) !== null) {
                    $masterTbl->VISIT_ID->setFormValue($parm);
                    $this->VISIT_ID->setFormValue($masterTbl->VISIT_ID->FormValue);
                    $this->VISIT_ID->setSessionValue($this->VISIT_ID->FormValue);
                } else {
                    $validMaster = false;
                }
                if (($parm = Post("fk_NO_REGISTRATION", Post("NO_REGISTRATION"))) !== null) {
                    $masterTbl->NO_REGISTRATION->setFormValue($parm);
                    $this->NO_REGISTRATION->setFormValue($masterTbl->NO_REGISTRATION->FormValue);
                    $this->NO_REGISTRATION->setSessionValue($this->NO_REGISTRATION->FormValue);
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
            if ($masterTblVar != "PASIEN_VISITATION") {
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->THEADDRESS->CurrentValue == "") {
                    $this->THEADDRESS->setSessionValue("");
                }
                if ($this->THENAME->CurrentValue == "") {
                    $this->THENAME->setSessionValue("");
                }
                if ($this->TRANS_ID->CurrentValue == "") {
                    $this->TRANS_ID->setSessionValue("");
                }
            }
            if ($masterTblVar != "V_LABORATORIUM") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
                if ($this->TRANS_ID->CurrentValue == "") {
                    $this->TRANS_ID->setSessionValue("");
                }
            }
            if ($masterTblVar != "V_RADIOLOGI") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->TRANS_ID->CurrentValue == "") {
                    $this->TRANS_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
            }
            if ($masterTblVar != "V_FARMASI") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
            }
            if ($masterTblVar != "V_KASIR") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
                }
            }
            if ($masterTblVar != "V_REKAM_MEDIS") {
                if ($this->VISIT_ID->CurrentValue == "") {
                    $this->VISIT_ID->setSessionValue("");
                }
                if ($this->NO_REGISTRATION->CurrentValue == "") {
                    $this->NO_REGISTRATION->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CustomView1List"), "", $this->TableVar, true);
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
                case "x_NO_REGISTRATION":
                    break;
                case "x_TARIF_ID":
                    $lookupFilter = function () {
                        return "[IMPLEMENTED] = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_CLINIC_ID":
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
