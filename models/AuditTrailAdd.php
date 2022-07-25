<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class AuditTrailAdd extends AuditTrail
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'AuditTrail';

    // Page object name
    public $PageObjName = "AuditTrailAdd";

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

        // Table object (AuditTrail)
        if (!isset($GLOBALS["AuditTrail"]) || get_class($GLOBALS["AuditTrail"]) == PROJECT_NAMESPACE . "AuditTrail") {
            $GLOBALS["AuditTrail"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'AuditTrail');
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
                $doc = new $class(Container("AuditTrail"));
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
                    if ($pageName == "AuditTrailView") {
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
            $key .= @$ar['Id'];
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
            $this->Id->Visible = false;
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
        $this->Id->Visible = false;
        $this->DateTime->setVisibility();
        $this->Script->setVisibility();
        $this->User->setVisibility();
        $this->_Action->setVisibility();
        $this->_Table->setVisibility();
        $this->Field->setVisibility();
        $this->KeyValue->setVisibility();
        $this->OldValue->setVisibility();
        $this->NewValue->setVisibility();
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
            if (($keyValue = Get("Id") ?? Route("Id")) !== null) {
                $this->Id->setQueryStringValue($keyValue);
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
                    $this->terminate("AuditTrailList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "AuditTrailList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "AuditTrailView") {
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
        $this->Id->CurrentValue = null;
        $this->Id->OldValue = $this->Id->CurrentValue;
        $this->DateTime->CurrentValue = null;
        $this->DateTime->OldValue = $this->DateTime->CurrentValue;
        $this->Script->CurrentValue = null;
        $this->Script->OldValue = $this->Script->CurrentValue;
        $this->User->CurrentValue = null;
        $this->User->OldValue = $this->User->CurrentValue;
        $this->_Action->CurrentValue = null;
        $this->_Action->OldValue = $this->_Action->CurrentValue;
        $this->_Table->CurrentValue = null;
        $this->_Table->OldValue = $this->_Table->CurrentValue;
        $this->Field->CurrentValue = null;
        $this->Field->OldValue = $this->Field->CurrentValue;
        $this->KeyValue->CurrentValue = null;
        $this->KeyValue->OldValue = $this->KeyValue->CurrentValue;
        $this->OldValue->CurrentValue = null;
        $this->OldValue->OldValue = $this->OldValue->CurrentValue;
        $this->NewValue->CurrentValue = null;
        $this->NewValue->OldValue = $this->NewValue->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'DateTime' first before field var 'x_DateTime'
        $val = $CurrentForm->hasValue("DateTime") ? $CurrentForm->getValue("DateTime") : $CurrentForm->getValue("x_DateTime");
        if (!$this->DateTime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DateTime->Visible = false; // Disable update for API request
            } else {
                $this->DateTime->setFormValue($val);
            }
            $this->DateTime->CurrentValue = UnFormatDateTime($this->DateTime->CurrentValue, 0);
        }

        // Check field name 'Script' first before field var 'x_Script'
        $val = $CurrentForm->hasValue("Script") ? $CurrentForm->getValue("Script") : $CurrentForm->getValue("x_Script");
        if (!$this->Script->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Script->Visible = false; // Disable update for API request
            } else {
                $this->Script->setFormValue($val);
            }
        }

        // Check field name 'User' first before field var 'x_User'
        $val = $CurrentForm->hasValue("User") ? $CurrentForm->getValue("User") : $CurrentForm->getValue("x_User");
        if (!$this->User->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->User->Visible = false; // Disable update for API request
            } else {
                $this->User->setFormValue($val);
            }
        }

        // Check field name 'Action' first before field var 'x__Action'
        $val = $CurrentForm->hasValue("Action") ? $CurrentForm->getValue("Action") : $CurrentForm->getValue("x__Action");
        if (!$this->_Action->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Action->Visible = false; // Disable update for API request
            } else {
                $this->_Action->setFormValue($val);
            }
        }

        // Check field name 'Table' first before field var 'x__Table'
        $val = $CurrentForm->hasValue("Table") ? $CurrentForm->getValue("Table") : $CurrentForm->getValue("x__Table");
        if (!$this->_Table->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Table->Visible = false; // Disable update for API request
            } else {
                $this->_Table->setFormValue($val);
            }
        }

        // Check field name 'Field' first before field var 'x_Field'
        $val = $CurrentForm->hasValue("Field") ? $CurrentForm->getValue("Field") : $CurrentForm->getValue("x_Field");
        if (!$this->Field->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Field->Visible = false; // Disable update for API request
            } else {
                $this->Field->setFormValue($val);
            }
        }

        // Check field name 'KeyValue' first before field var 'x_KeyValue'
        $val = $CurrentForm->hasValue("KeyValue") ? $CurrentForm->getValue("KeyValue") : $CurrentForm->getValue("x_KeyValue");
        if (!$this->KeyValue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KeyValue->Visible = false; // Disable update for API request
            } else {
                $this->KeyValue->setFormValue($val);
            }
        }

        // Check field name 'OldValue' first before field var 'x_OldValue'
        $val = $CurrentForm->hasValue("OldValue") ? $CurrentForm->getValue("OldValue") : $CurrentForm->getValue("x_OldValue");
        if (!$this->OldValue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->OldValue->Visible = false; // Disable update for API request
            } else {
                $this->OldValue->setFormValue($val);
            }
        }

        // Check field name 'NewValue' first before field var 'x_NewValue'
        $val = $CurrentForm->hasValue("NewValue") ? $CurrentForm->getValue("NewValue") : $CurrentForm->getValue("x_NewValue");
        if (!$this->NewValue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NewValue->Visible = false; // Disable update for API request
            } else {
                $this->NewValue->setFormValue($val);
            }
        }

        // Check field name 'Id' first before field var 'x_Id'
        $val = $CurrentForm->hasValue("Id") ? $CurrentForm->getValue("Id") : $CurrentForm->getValue("x_Id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->DateTime->CurrentValue = $this->DateTime->FormValue;
        $this->DateTime->CurrentValue = UnFormatDateTime($this->DateTime->CurrentValue, 0);
        $this->Script->CurrentValue = $this->Script->FormValue;
        $this->User->CurrentValue = $this->User->FormValue;
        $this->_Action->CurrentValue = $this->_Action->FormValue;
        $this->_Table->CurrentValue = $this->_Table->FormValue;
        $this->Field->CurrentValue = $this->Field->FormValue;
        $this->KeyValue->CurrentValue = $this->KeyValue->FormValue;
        $this->OldValue->CurrentValue = $this->OldValue->FormValue;
        $this->NewValue->CurrentValue = $this->NewValue->FormValue;
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
        $this->Id->setDbValue($row['Id']);
        $this->DateTime->setDbValue($row['DateTime']);
        $this->Script->setDbValue($row['Script']);
        $this->User->setDbValue($row['User']);
        $this->_Action->setDbValue($row['Action']);
        $this->_Table->setDbValue($row['Table']);
        $this->Field->setDbValue($row['Field']);
        $this->KeyValue->setDbValue($row['KeyValue']);
        $this->OldValue->setDbValue($row['OldValue']);
        $this->NewValue->setDbValue($row['NewValue']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['Id'] = $this->Id->CurrentValue;
        $row['DateTime'] = $this->DateTime->CurrentValue;
        $row['Script'] = $this->Script->CurrentValue;
        $row['User'] = $this->User->CurrentValue;
        $row['Action'] = $this->_Action->CurrentValue;
        $row['Table'] = $this->_Table->CurrentValue;
        $row['Field'] = $this->Field->CurrentValue;
        $row['KeyValue'] = $this->KeyValue->CurrentValue;
        $row['OldValue'] = $this->OldValue->CurrentValue;
        $row['NewValue'] = $this->NewValue->CurrentValue;
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

        // Id

        // DateTime

        // Script

        // User

        // Action

        // Table

        // Field

        // KeyValue

        // OldValue

        // NewValue
        if ($this->RowType == ROWTYPE_VIEW) {
            // Id
            $this->Id->ViewValue = $this->Id->CurrentValue;
            $this->Id->ViewCustomAttributes = "";

            // DateTime
            $this->DateTime->ViewValue = $this->DateTime->CurrentValue;
            $this->DateTime->ViewValue = FormatDateTime($this->DateTime->ViewValue, 0);
            $this->DateTime->ViewCustomAttributes = "";

            // Script
            $this->Script->ViewValue = $this->Script->CurrentValue;
            $this->Script->ViewCustomAttributes = "";

            // User
            $this->User->ViewValue = $this->User->CurrentValue;
            $this->User->ViewCustomAttributes = "";

            // Action
            $this->_Action->ViewValue = $this->_Action->CurrentValue;
            $this->_Action->ViewCustomAttributes = "";

            // Table
            $this->_Table->ViewValue = $this->_Table->CurrentValue;
            $this->_Table->ViewCustomAttributes = "";

            // Field
            $this->Field->ViewValue = $this->Field->CurrentValue;
            $this->Field->ViewCustomAttributes = "";

            // KeyValue
            $this->KeyValue->ViewValue = $this->KeyValue->CurrentValue;
            $this->KeyValue->ViewCustomAttributes = "";

            // OldValue
            $this->OldValue->ViewValue = $this->OldValue->CurrentValue;
            $this->OldValue->ViewCustomAttributes = "";

            // NewValue
            $this->NewValue->ViewValue = $this->NewValue->CurrentValue;
            $this->NewValue->ViewCustomAttributes = "";

            // DateTime
            $this->DateTime->LinkCustomAttributes = "";
            $this->DateTime->HrefValue = "";
            $this->DateTime->TooltipValue = "";

            // Script
            $this->Script->LinkCustomAttributes = "";
            $this->Script->HrefValue = "";
            $this->Script->TooltipValue = "";

            // User
            $this->User->LinkCustomAttributes = "";
            $this->User->HrefValue = "";
            $this->User->TooltipValue = "";

            // Action
            $this->_Action->LinkCustomAttributes = "";
            $this->_Action->HrefValue = "";
            $this->_Action->TooltipValue = "";

            // Table
            $this->_Table->LinkCustomAttributes = "";
            $this->_Table->HrefValue = "";
            $this->_Table->TooltipValue = "";

            // Field
            $this->Field->LinkCustomAttributes = "";
            $this->Field->HrefValue = "";
            $this->Field->TooltipValue = "";

            // KeyValue
            $this->KeyValue->LinkCustomAttributes = "";
            $this->KeyValue->HrefValue = "";
            $this->KeyValue->TooltipValue = "";

            // OldValue
            $this->OldValue->LinkCustomAttributes = "";
            $this->OldValue->HrefValue = "";
            $this->OldValue->TooltipValue = "";

            // NewValue
            $this->NewValue->LinkCustomAttributes = "";
            $this->NewValue->HrefValue = "";
            $this->NewValue->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // DateTime
            $this->DateTime->EditAttrs["class"] = "form-control";
            $this->DateTime->EditCustomAttributes = "";
            $this->DateTime->EditValue = HtmlEncode(FormatDateTime($this->DateTime->CurrentValue, 8));
            $this->DateTime->PlaceHolder = RemoveHtml($this->DateTime->caption());

            // Script
            $this->Script->EditAttrs["class"] = "form-control";
            $this->Script->EditCustomAttributes = "";
            if (!$this->Script->Raw) {
                $this->Script->CurrentValue = HtmlDecode($this->Script->CurrentValue);
            }
            $this->Script->EditValue = HtmlEncode($this->Script->CurrentValue);
            $this->Script->PlaceHolder = RemoveHtml($this->Script->caption());

            // User
            $this->User->EditAttrs["class"] = "form-control";
            $this->User->EditCustomAttributes = "";
            if (!$this->User->Raw) {
                $this->User->CurrentValue = HtmlDecode($this->User->CurrentValue);
            }
            $this->User->EditValue = HtmlEncode($this->User->CurrentValue);
            $this->User->PlaceHolder = RemoveHtml($this->User->caption());

            // Action
            $this->_Action->EditAttrs["class"] = "form-control";
            $this->_Action->EditCustomAttributes = "";
            if (!$this->_Action->Raw) {
                $this->_Action->CurrentValue = HtmlDecode($this->_Action->CurrentValue);
            }
            $this->_Action->EditValue = HtmlEncode($this->_Action->CurrentValue);
            $this->_Action->PlaceHolder = RemoveHtml($this->_Action->caption());

            // Table
            $this->_Table->EditAttrs["class"] = "form-control";
            $this->_Table->EditCustomAttributes = "";
            if (!$this->_Table->Raw) {
                $this->_Table->CurrentValue = HtmlDecode($this->_Table->CurrentValue);
            }
            $this->_Table->EditValue = HtmlEncode($this->_Table->CurrentValue);
            $this->_Table->PlaceHolder = RemoveHtml($this->_Table->caption());

            // Field
            $this->Field->EditAttrs["class"] = "form-control";
            $this->Field->EditCustomAttributes = "";
            if (!$this->Field->Raw) {
                $this->Field->CurrentValue = HtmlDecode($this->Field->CurrentValue);
            }
            $this->Field->EditValue = HtmlEncode($this->Field->CurrentValue);
            $this->Field->PlaceHolder = RemoveHtml($this->Field->caption());

            // KeyValue
            $this->KeyValue->EditAttrs["class"] = "form-control";
            $this->KeyValue->EditCustomAttributes = "";
            $this->KeyValue->EditValue = HtmlEncode($this->KeyValue->CurrentValue);
            $this->KeyValue->PlaceHolder = RemoveHtml($this->KeyValue->caption());

            // OldValue
            $this->OldValue->EditAttrs["class"] = "form-control";
            $this->OldValue->EditCustomAttributes = "";
            $this->OldValue->EditValue = HtmlEncode($this->OldValue->CurrentValue);
            $this->OldValue->PlaceHolder = RemoveHtml($this->OldValue->caption());

            // NewValue
            $this->NewValue->EditAttrs["class"] = "form-control";
            $this->NewValue->EditCustomAttributes = "";
            $this->NewValue->EditValue = HtmlEncode($this->NewValue->CurrentValue);
            $this->NewValue->PlaceHolder = RemoveHtml($this->NewValue->caption());

            // Add refer script

            // DateTime
            $this->DateTime->LinkCustomAttributes = "";
            $this->DateTime->HrefValue = "";

            // Script
            $this->Script->LinkCustomAttributes = "";
            $this->Script->HrefValue = "";

            // User
            $this->User->LinkCustomAttributes = "";
            $this->User->HrefValue = "";

            // Action
            $this->_Action->LinkCustomAttributes = "";
            $this->_Action->HrefValue = "";

            // Table
            $this->_Table->LinkCustomAttributes = "";
            $this->_Table->HrefValue = "";

            // Field
            $this->Field->LinkCustomAttributes = "";
            $this->Field->HrefValue = "";

            // KeyValue
            $this->KeyValue->LinkCustomAttributes = "";
            $this->KeyValue->HrefValue = "";

            // OldValue
            $this->OldValue->LinkCustomAttributes = "";
            $this->OldValue->HrefValue = "";

            // NewValue
            $this->NewValue->LinkCustomAttributes = "";
            $this->NewValue->HrefValue = "";
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
        if ($this->DateTime->Required) {
            if (!$this->DateTime->IsDetailKey && EmptyValue($this->DateTime->FormValue)) {
                $this->DateTime->addErrorMessage(str_replace("%s", $this->DateTime->caption(), $this->DateTime->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->DateTime->FormValue)) {
            $this->DateTime->addErrorMessage($this->DateTime->getErrorMessage(false));
        }
        if ($this->Script->Required) {
            if (!$this->Script->IsDetailKey && EmptyValue($this->Script->FormValue)) {
                $this->Script->addErrorMessage(str_replace("%s", $this->Script->caption(), $this->Script->RequiredErrorMessage));
            }
        }
        if ($this->User->Required) {
            if (!$this->User->IsDetailKey && EmptyValue($this->User->FormValue)) {
                $this->User->addErrorMessage(str_replace("%s", $this->User->caption(), $this->User->RequiredErrorMessage));
            }
        }
        if ($this->_Action->Required) {
            if (!$this->_Action->IsDetailKey && EmptyValue($this->_Action->FormValue)) {
                $this->_Action->addErrorMessage(str_replace("%s", $this->_Action->caption(), $this->_Action->RequiredErrorMessage));
            }
        }
        if ($this->_Table->Required) {
            if (!$this->_Table->IsDetailKey && EmptyValue($this->_Table->FormValue)) {
                $this->_Table->addErrorMessage(str_replace("%s", $this->_Table->caption(), $this->_Table->RequiredErrorMessage));
            }
        }
        if ($this->Field->Required) {
            if (!$this->Field->IsDetailKey && EmptyValue($this->Field->FormValue)) {
                $this->Field->addErrorMessage(str_replace("%s", $this->Field->caption(), $this->Field->RequiredErrorMessage));
            }
        }
        if ($this->KeyValue->Required) {
            if (!$this->KeyValue->IsDetailKey && EmptyValue($this->KeyValue->FormValue)) {
                $this->KeyValue->addErrorMessage(str_replace("%s", $this->KeyValue->caption(), $this->KeyValue->RequiredErrorMessage));
            }
        }
        if ($this->OldValue->Required) {
            if (!$this->OldValue->IsDetailKey && EmptyValue($this->OldValue->FormValue)) {
                $this->OldValue->addErrorMessage(str_replace("%s", $this->OldValue->caption(), $this->OldValue->RequiredErrorMessage));
            }
        }
        if ($this->NewValue->Required) {
            if (!$this->NewValue->IsDetailKey && EmptyValue($this->NewValue->FormValue)) {
                $this->NewValue->addErrorMessage(str_replace("%s", $this->NewValue->caption(), $this->NewValue->RequiredErrorMessage));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // DateTime
        $this->DateTime->setDbValueDef($rsnew, UnFormatDateTime($this->DateTime->CurrentValue, 0), CurrentDate(), false);

        // Script
        $this->Script->setDbValueDef($rsnew, $this->Script->CurrentValue, null, false);

        // User
        $this->User->setDbValueDef($rsnew, $this->User->CurrentValue, null, false);

        // Action
        $this->_Action->setDbValueDef($rsnew, $this->_Action->CurrentValue, null, false);

        // Table
        $this->_Table->setDbValueDef($rsnew, $this->_Table->CurrentValue, null, false);

        // Field
        $this->Field->setDbValueDef($rsnew, $this->Field->CurrentValue, null, false);

        // KeyValue
        $this->KeyValue->setDbValueDef($rsnew, $this->KeyValue->CurrentValue, null, false);

        // OldValue
        $this->OldValue->setDbValueDef($rsnew, $this->OldValue->CurrentValue, null, false);

        // NewValue
        $this->NewValue->setDbValueDef($rsnew, $this->NewValue->CurrentValue, null, false);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AuditTrailList"), "", $this->TableVar, true);
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
