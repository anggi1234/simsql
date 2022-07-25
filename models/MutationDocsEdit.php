<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MutationDocsEdit extends MutationDocs
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'MUTATION_DOCS';

    // Page object name
    public $PageObjName = "MutationDocsEdit";

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

        // Table object (MUTATION_DOCS)
        if (!isset($GLOBALS["MUTATION_DOCS"]) || get_class($GLOBALS["MUTATION_DOCS"]) == PROJECT_NAMESPACE . "MUTATION_DOCS") {
            $GLOBALS["MUTATION_DOCS"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'MUTATION_DOCS');
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
                $doc = new $class(Container("MUTATION_DOCS"));
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
                    if ($pageName == "MutationDocsView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->ORG_UNIT_CODE->Visible = false;
        $this->DOC_NO->setVisibility();
        $this->ORDER_ID->Visible = false;
        $this->ORG_UNIT_FROM->Visible = false;
        $this->ORG_ID->Visible = false;
        $this->CLINIC_ID->setVisibility();
        $this->ORG_ID_TO->Visible = false;
        $this->CLINIC_ID_TO->setVisibility();
        $this->MUTATION_DATE->setVisibility();
        $this->MUTATION_BY->Visible = false;
        $this->ORDER_VALUE->setVisibility();
        $this->MUTATION_VALUE->setVisibility();
        $this->YEAR_ID->Visible = false;
        $this->RECEIVED_BY->setVisibility();
        $this->ACCOUNT_ID->Visible = false;
        $this->FINANCE_ID->Visible = false;
        $this->DESCRIPTION->Visible = false;
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->MODIFIED_DATE->Visible = false;
        $this->MODIFIED_BY->Visible = false;
        $this->ACKNOWLEDGEBY->Visible = false;
        $this->COMPANY_ID->Visible = false;
        $this->ID->Visible = false;
        $this->hideFieldsForAddEdit();
        $this->DOC_NO->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->CLINIC_ID);
        $this->setupLookupOptions($this->CLINIC_ID_TO);
        $this->setupLookupOptions($this->DISTRIBUTION_TYPE);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->ID->setOldValue($this->ID->QueryStringValue);
            } elseif (Post("ID") !== null) {
                $this->ID->setFormValue(Post("ID"));
                $this->ID->setOldValue($this->ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                    $this->ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ID->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("MutationDocsList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                $returnUrl = 'MutationDocsView/'.urlencode(CurrentPage()->ID->CurrentValue).'?showdetail=GOOD_GF';
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'DOC_NO' first before field var 'x_DOC_NO'
        $val = $CurrentForm->hasValue("DOC_NO") ? $CurrentForm->getValue("DOC_NO") : $CurrentForm->getValue("x_DOC_NO");
        if (!$this->DOC_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOC_NO->Visible = false; // Disable update for API request
            } else {
                $this->DOC_NO->setFormValue($val);
            }
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

        // Check field name 'CLINIC_ID_TO' first before field var 'x_CLINIC_ID_TO'
        $val = $CurrentForm->hasValue("CLINIC_ID_TO") ? $CurrentForm->getValue("CLINIC_ID_TO") : $CurrentForm->getValue("x_CLINIC_ID_TO");
        if (!$this->CLINIC_ID_TO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLINIC_ID_TO->Visible = false; // Disable update for API request
            } else {
                $this->CLINIC_ID_TO->setFormValue($val);
            }
        }

        // Check field name 'MUTATION_DATE' first before field var 'x_MUTATION_DATE'
        $val = $CurrentForm->hasValue("MUTATION_DATE") ? $CurrentForm->getValue("MUTATION_DATE") : $CurrentForm->getValue("x_MUTATION_DATE");
        if (!$this->MUTATION_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MUTATION_DATE->Visible = false; // Disable update for API request
            } else {
                $this->MUTATION_DATE->setFormValue($val);
            }
            $this->MUTATION_DATE->CurrentValue = UnFormatDateTime($this->MUTATION_DATE->CurrentValue, 11);
        }

        // Check field name 'ORDER_VALUE' first before field var 'x_ORDER_VALUE'
        $val = $CurrentForm->hasValue("ORDER_VALUE") ? $CurrentForm->getValue("ORDER_VALUE") : $CurrentForm->getValue("x_ORDER_VALUE");
        if (!$this->ORDER_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_VALUE->setFormValue($val);
            }
        }

        // Check field name 'MUTATION_VALUE' first before field var 'x_MUTATION_VALUE'
        $val = $CurrentForm->hasValue("MUTATION_VALUE") ? $CurrentForm->getValue("MUTATION_VALUE") : $CurrentForm->getValue("x_MUTATION_VALUE");
        if (!$this->MUTATION_VALUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MUTATION_VALUE->Visible = false; // Disable update for API request
            } else {
                $this->MUTATION_VALUE->setFormValue($val);
            }
        }

        // Check field name 'RECEIVED_BY' first before field var 'x_RECEIVED_BY'
        $val = $CurrentForm->hasValue("RECEIVED_BY") ? $CurrentForm->getValue("RECEIVED_BY") : $CurrentForm->getValue("x_RECEIVED_BY");
        if (!$this->RECEIVED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECEIVED_BY->Visible = false; // Disable update for API request
            } else {
                $this->RECEIVED_BY->setFormValue($val);
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

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey) {
            $this->ID->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ID->CurrentValue = $this->ID->FormValue;
        $this->DOC_NO->CurrentValue = $this->DOC_NO->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->CLINIC_ID_TO->CurrentValue = $this->CLINIC_ID_TO->FormValue;
        $this->MUTATION_DATE->CurrentValue = $this->MUTATION_DATE->FormValue;
        $this->MUTATION_DATE->CurrentValue = UnFormatDateTime($this->MUTATION_DATE->CurrentValue, 11);
        $this->ORDER_VALUE->CurrentValue = $this->ORDER_VALUE->FormValue;
        $this->MUTATION_VALUE->CurrentValue = $this->MUTATION_VALUE->FormValue;
        $this->RECEIVED_BY->CurrentValue = $this->RECEIVED_BY->FormValue;
        $this->DISTRIBUTION_TYPE->CurrentValue = $this->DISTRIBUTION_TYPE->FormValue;
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
        $this->DOC_NO->setDbValue($row['DOC_NO']);
        $this->ORDER_ID->setDbValue($row['ORDER_ID']);
        $this->ORG_UNIT_FROM->setDbValue($row['ORG_UNIT_FROM']);
        $this->ORG_ID->setDbValue($row['ORG_ID']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->ORG_ID_TO->setDbValue($row['ORG_ID_TO']);
        $this->CLINIC_ID_TO->setDbValue($row['CLINIC_ID_TO']);
        $this->MUTATION_DATE->setDbValue($row['MUTATION_DATE']);
        $this->MUTATION_BY->setDbValue($row['MUTATION_BY']);
        $this->ORDER_VALUE->setDbValue($row['ORDER_VALUE']);
        $this->MUTATION_VALUE->setDbValue($row['MUTATION_VALUE']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->RECEIVED_BY->setDbValue($row['RECEIVED_BY']);
        $this->ACCOUNT_ID->setDbValue($row['ACCOUNT_ID']);
        $this->FINANCE_ID->setDbValue($row['FINANCE_ID']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->DISTRIBUTION_TYPE->setDbValue($row['DISTRIBUTION_TYPE']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->ACKNOWLEDGEBY->setDbValue($row['ACKNOWLEDGEBY']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->ID->setDbValue($row['ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['DOC_NO'] = null;
        $row['ORDER_ID'] = null;
        $row['ORG_UNIT_FROM'] = null;
        $row['ORG_ID'] = null;
        $row['CLINIC_ID'] = null;
        $row['ORG_ID_TO'] = null;
        $row['CLINIC_ID_TO'] = null;
        $row['MUTATION_DATE'] = null;
        $row['MUTATION_BY'] = null;
        $row['ORDER_VALUE'] = null;
        $row['MUTATION_VALUE'] = null;
        $row['YEAR_ID'] = null;
        $row['RECEIVED_BY'] = null;
        $row['ACCOUNT_ID'] = null;
        $row['FINANCE_ID'] = null;
        $row['DESCRIPTION'] = null;
        $row['DISTRIBUTION_TYPE'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['ACKNOWLEDGEBY'] = null;
        $row['COMPANY_ID'] = null;
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

        // Convert decimal values if posted back
        if ($this->ORDER_VALUE->FormValue == $this->ORDER_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_VALUE->CurrentValue))) {
            $this->ORDER_VALUE->CurrentValue = ConvertToFloatString($this->ORDER_VALUE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->MUTATION_VALUE->FormValue == $this->MUTATION_VALUE->CurrentValue && is_numeric(ConvertToFloatString($this->MUTATION_VALUE->CurrentValue))) {
            $this->MUTATION_VALUE->CurrentValue = ConvertToFloatString($this->MUTATION_VALUE->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // DOC_NO

        // ORDER_ID

        // ORG_UNIT_FROM

        // ORG_ID

        // CLINIC_ID

        // ORG_ID_TO

        // CLINIC_ID_TO

        // MUTATION_DATE

        // MUTATION_BY

        // ORDER_VALUE

        // MUTATION_VALUE

        // YEAR_ID

        // RECEIVED_BY

        // ACCOUNT_ID

        // FINANCE_ID

        // DESCRIPTION

        // DISTRIBUTION_TYPE

        // MODIFIED_DATE

        // MODIFIED_BY

        // ACKNOWLEDGEBY

        // COMPANY_ID

        // ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // DOC_NO
            $this->DOC_NO->ViewValue = $this->DOC_NO->CurrentValue;
            $this->DOC_NO->ViewCustomAttributes = "";

            // ORDER_ID
            $this->ORDER_ID->ViewValue = $this->ORDER_ID->CurrentValue;
            $this->ORDER_ID->ViewCustomAttributes = "";

            // ORG_UNIT_FROM
            $this->ORG_UNIT_FROM->ViewValue = $this->ORG_UNIT_FROM->CurrentValue;
            $this->ORG_UNIT_FROM->ViewCustomAttributes = "";

            // ORG_ID
            $this->ORG_ID->ViewValue = $this->ORG_ID->CurrentValue;
            $this->ORG_ID->ViewCustomAttributes = 'hidden';

            // CLINIC_ID
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 70 or [STYPE_ID] = 73";
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

            // ORG_ID_TO
            $this->ORG_ID_TO->ViewValue = $this->ORG_ID_TO->CurrentValue;
            $this->ORG_ID_TO->ViewCustomAttributes = 'hidden';

            // CLINIC_ID_TO
            $curVal = trim(strval($this->CLINIC_ID_TO->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID_TO->ViewValue = $this->CLINIC_ID_TO->lookupCacheOption($curVal);
                if ($this->CLINIC_ID_TO->ViewValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 1 or [STYPE_ID] = 2 or [STYPE_ID] = 3 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->CLINIC_ID_TO->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID_TO->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID_TO->ViewValue = $this->CLINIC_ID_TO->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID_TO->ViewValue = $this->CLINIC_ID_TO->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID_TO->ViewValue = null;
            }
            $this->CLINIC_ID_TO->ViewCustomAttributes = "";

            // MUTATION_DATE
            $this->MUTATION_DATE->ViewValue = $this->MUTATION_DATE->CurrentValue;
            $this->MUTATION_DATE->ViewValue = FormatDateTime($this->MUTATION_DATE->ViewValue, 11);
            $this->MUTATION_DATE->ViewCustomAttributes = "";

            // MUTATION_BY
            $this->MUTATION_BY->ViewValue = $this->MUTATION_BY->CurrentValue;
            $this->MUTATION_BY->ViewCustomAttributes = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->ViewValue = $this->ORDER_VALUE->CurrentValue;
            $this->ORDER_VALUE->ViewValue = FormatNumber($this->ORDER_VALUE->ViewValue, 2, -2, -2, -2);
            $this->ORDER_VALUE->ViewCustomAttributes = "";

            // MUTATION_VALUE
            $this->MUTATION_VALUE->ViewValue = $this->MUTATION_VALUE->CurrentValue;
            $this->MUTATION_VALUE->ViewValue = FormatNumber($this->MUTATION_VALUE->ViewValue, 2, -2, -2, -2);
            $this->MUTATION_VALUE->ViewCustomAttributes = "";

            // YEAR_ID
            $this->YEAR_ID->ViewValue = $this->YEAR_ID->CurrentValue;
            $this->YEAR_ID->ViewValue = FormatNumber($this->YEAR_ID->ViewValue, 0, -2, -2, -2);
            $this->YEAR_ID->ViewCustomAttributes = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->ViewValue = $this->RECEIVED_BY->CurrentValue;
            $this->RECEIVED_BY->ViewCustomAttributes = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->ViewValue = $this->ACCOUNT_ID->CurrentValue;
            $this->ACCOUNT_ID->ViewCustomAttributes = "";

            // FINANCE_ID
            $this->FINANCE_ID->ViewValue = $this->FINANCE_ID->CurrentValue;
            $this->FINANCE_ID->ViewValue = FormatNumber($this->FINANCE_ID->ViewValue, 0, -2, -2, -2);
            $this->FINANCE_ID->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // DISTRIBUTION_TYPE
            $curVal = trim(strval($this->DISTRIBUTION_TYPE->CurrentValue));
            if ($curVal != "") {
                $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->lookupCacheOption($curVal);
                if ($this->DISTRIBUTION_TYPE->ViewValue === null) { // Lookup from database
                    $filterWrk = "[DISTRIBUTION_TYPE]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->DISTRIBUTION_TYPE->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->DISTRIBUTION_TYPE->Lookup->renderViewRow($rswrk[0]);
                        $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->displayValue($arwrk);
                    } else {
                        $this->DISTRIBUTION_TYPE->ViewValue = $this->DISTRIBUTION_TYPE->CurrentValue;
                    }
                }
            } else {
                $this->DISTRIBUTION_TYPE->ViewValue = null;
            }
            $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

            // ACKNOWLEDGEBY
            $this->ACKNOWLEDGEBY->ViewValue = $this->ACKNOWLEDGEBY->CurrentValue;
            $this->ACKNOWLEDGEBY->ViewCustomAttributes = "";

            // COMPANY_ID
            if (strval($this->COMPANY_ID->CurrentValue) != "") {
                $this->COMPANY_ID->ViewValue = new OptionValues();
                $arwrk = explode(",", strval($this->COMPANY_ID->CurrentValue));
                $cnt = count($arwrk);
                for ($ari = 0; $ari < $cnt; $ari++)
                    $this->COMPANY_ID->ViewValue->add($this->COMPANY_ID->optionCaption(trim($arwrk[$ari])));
            } else {
                $this->COMPANY_ID->ViewValue = null;
            }
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";
            $this->DOC_NO->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // CLINIC_ID_TO
            $this->CLINIC_ID_TO->LinkCustomAttributes = "";
            $this->CLINIC_ID_TO->HrefValue = "";
            $this->CLINIC_ID_TO->TooltipValue = "";

            // MUTATION_DATE
            $this->MUTATION_DATE->LinkCustomAttributes = "";
            $this->MUTATION_DATE->HrefValue = "";
            $this->MUTATION_DATE->TooltipValue = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->LinkCustomAttributes = "";
            $this->ORDER_VALUE->HrefValue = "";
            $this->ORDER_VALUE->TooltipValue = "";

            // MUTATION_VALUE
            $this->MUTATION_VALUE->LinkCustomAttributes = "";
            $this->MUTATION_VALUE->HrefValue = "";
            $this->MUTATION_VALUE->TooltipValue = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->LinkCustomAttributes = "";
            $this->RECEIVED_BY->HrefValue = "";
            $this->RECEIVED_BY->TooltipValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";
            $this->DISTRIBUTION_TYPE->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // DOC_NO
            $this->DOC_NO->EditAttrs["class"] = "form-control";
            $this->DOC_NO->EditCustomAttributes = "";
            $this->DOC_NO->EditValue = $this->DOC_NO->CurrentValue;
            $this->DOC_NO->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID->EditValue = $this->CLINIC_ID->lookupCacheOption($curVal);
                if ($this->CLINIC_ID->EditValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 70 or [STYPE_ID] = 73";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->CLINIC_ID->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID->EditValue = $this->CLINIC_ID->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID->EditValue = $this->CLINIC_ID->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID->EditValue = null;
            }
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // CLINIC_ID_TO
            $this->CLINIC_ID_TO->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID_TO->EditCustomAttributes = "";
            $curVal = trim(strval($this->CLINIC_ID_TO->CurrentValue));
            if ($curVal != "") {
                $this->CLINIC_ID_TO->EditValue = $this->CLINIC_ID_TO->lookupCacheOption($curVal);
                if ($this->CLINIC_ID_TO->EditValue === null) { // Lookup from database
                    $filterWrk = "[CLINIC_ID]" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $lookupFilter = function() {
                        return "[STYPE_ID] = 1 or [STYPE_ID] = 2 or [STYPE_ID] = 3 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->CLINIC_ID_TO->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->CLINIC_ID_TO->Lookup->renderViewRow($rswrk[0]);
                        $this->CLINIC_ID_TO->EditValue = $this->CLINIC_ID_TO->displayValue($arwrk);
                    } else {
                        $this->CLINIC_ID_TO->EditValue = $this->CLINIC_ID_TO->CurrentValue;
                    }
                }
            } else {
                $this->CLINIC_ID_TO->EditValue = null;
            }
            $this->CLINIC_ID_TO->ViewCustomAttributes = "";

            // MUTATION_DATE
            $this->MUTATION_DATE->EditAttrs["class"] = "form-control";
            $this->MUTATION_DATE->EditCustomAttributes = "";
            $this->MUTATION_DATE->EditValue = $this->MUTATION_DATE->CurrentValue;
            $this->MUTATION_DATE->EditValue = FormatDateTime($this->MUTATION_DATE->EditValue, 11);
            $this->MUTATION_DATE->ViewCustomAttributes = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->EditAttrs["class"] = "form-control";
            $this->ORDER_VALUE->EditCustomAttributes = "";
            $this->ORDER_VALUE->EditValue = $this->ORDER_VALUE->CurrentValue;
            $this->ORDER_VALUE->EditValue = FormatNumber($this->ORDER_VALUE->EditValue, 2, -2, -2, -2);
            $this->ORDER_VALUE->ViewCustomAttributes = "";

            // MUTATION_VALUE
            $this->MUTATION_VALUE->EditAttrs["class"] = "form-control";
            $this->MUTATION_VALUE->EditCustomAttributes = "";
            $this->MUTATION_VALUE->EditValue = $this->MUTATION_VALUE->CurrentValue;
            $this->MUTATION_VALUE->EditValue = FormatNumber($this->MUTATION_VALUE->EditValue, 2, -2, -2, -2);
            $this->MUTATION_VALUE->ViewCustomAttributes = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->EditAttrs["class"] = "form-control";
            $this->RECEIVED_BY->EditCustomAttributes = "";
            $this->RECEIVED_BY->EditValue = $this->RECEIVED_BY->CurrentValue;
            $this->RECEIVED_BY->ViewCustomAttributes = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->EditAttrs["class"] = "form-control";
            $this->DISTRIBUTION_TYPE->EditCustomAttributes = "";
            $curVal = trim(strval($this->DISTRIBUTION_TYPE->CurrentValue));
            if ($curVal != "") {
                $this->DISTRIBUTION_TYPE->EditValue = $this->DISTRIBUTION_TYPE->lookupCacheOption($curVal);
                if ($this->DISTRIBUTION_TYPE->EditValue === null) { // Lookup from database
                    $filterWrk = "[DISTRIBUTION_TYPE]" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->DISTRIBUTION_TYPE->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->DISTRIBUTION_TYPE->Lookup->renderViewRow($rswrk[0]);
                        $this->DISTRIBUTION_TYPE->EditValue = $this->DISTRIBUTION_TYPE->displayValue($arwrk);
                    } else {
                        $this->DISTRIBUTION_TYPE->EditValue = $this->DISTRIBUTION_TYPE->CurrentValue;
                    }
                }
            } else {
                $this->DISTRIBUTION_TYPE->EditValue = null;
            }
            $this->DISTRIBUTION_TYPE->ViewCustomAttributes = "";

            // Edit refer script

            // DOC_NO
            $this->DOC_NO->LinkCustomAttributes = "";
            $this->DOC_NO->HrefValue = "";
            $this->DOC_NO->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // CLINIC_ID_TO
            $this->CLINIC_ID_TO->LinkCustomAttributes = "";
            $this->CLINIC_ID_TO->HrefValue = "";
            $this->CLINIC_ID_TO->TooltipValue = "";

            // MUTATION_DATE
            $this->MUTATION_DATE->LinkCustomAttributes = "";
            $this->MUTATION_DATE->HrefValue = "";
            $this->MUTATION_DATE->TooltipValue = "";

            // ORDER_VALUE
            $this->ORDER_VALUE->LinkCustomAttributes = "";
            $this->ORDER_VALUE->HrefValue = "";
            $this->ORDER_VALUE->TooltipValue = "";

            // MUTATION_VALUE
            $this->MUTATION_VALUE->LinkCustomAttributes = "";
            $this->MUTATION_VALUE->HrefValue = "";
            $this->MUTATION_VALUE->TooltipValue = "";

            // RECEIVED_BY
            $this->RECEIVED_BY->LinkCustomAttributes = "";
            $this->RECEIVED_BY->HrefValue = "";
            $this->RECEIVED_BY->TooltipValue = "";

            // DISTRIBUTION_TYPE
            $this->DISTRIBUTION_TYPE->LinkCustomAttributes = "";
            $this->DISTRIBUTION_TYPE->HrefValue = "";
            $this->DISTRIBUTION_TYPE->TooltipValue = "";
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
        if ($this->DOC_NO->Required) {
            if (!$this->DOC_NO->IsDetailKey && EmptyValue($this->DOC_NO->FormValue)) {
                $this->DOC_NO->addErrorMessage(str_replace("%s", $this->DOC_NO->caption(), $this->DOC_NO->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID_TO->Required) {
            if (!$this->CLINIC_ID_TO->IsDetailKey && EmptyValue($this->CLINIC_ID_TO->FormValue)) {
                $this->CLINIC_ID_TO->addErrorMessage(str_replace("%s", $this->CLINIC_ID_TO->caption(), $this->CLINIC_ID_TO->RequiredErrorMessage));
            }
        }
        if ($this->MUTATION_DATE->Required) {
            if (!$this->MUTATION_DATE->IsDetailKey && EmptyValue($this->MUTATION_DATE->FormValue)) {
                $this->MUTATION_DATE->addErrorMessage(str_replace("%s", $this->MUTATION_DATE->caption(), $this->MUTATION_DATE->RequiredErrorMessage));
            }
        }
        if ($this->ORDER_VALUE->Required) {
            if (!$this->ORDER_VALUE->IsDetailKey && EmptyValue($this->ORDER_VALUE->FormValue)) {
                $this->ORDER_VALUE->addErrorMessage(str_replace("%s", $this->ORDER_VALUE->caption(), $this->ORDER_VALUE->RequiredErrorMessage));
            }
        }
        if ($this->MUTATION_VALUE->Required) {
            if (!$this->MUTATION_VALUE->IsDetailKey && EmptyValue($this->MUTATION_VALUE->FormValue)) {
                $this->MUTATION_VALUE->addErrorMessage(str_replace("%s", $this->MUTATION_VALUE->caption(), $this->MUTATION_VALUE->RequiredErrorMessage));
            }
        }
        if ($this->RECEIVED_BY->Required) {
            if (!$this->RECEIVED_BY->IsDetailKey && EmptyValue($this->RECEIVED_BY->FormValue)) {
                $this->RECEIVED_BY->addErrorMessage(str_replace("%s", $this->RECEIVED_BY->caption(), $this->RECEIVED_BY->RequiredErrorMessage));
            }
        }
        if ($this->DISTRIBUTION_TYPE->Required) {
            if (!$this->DISTRIBUTION_TYPE->IsDetailKey && EmptyValue($this->DISTRIBUTION_TYPE->FormValue)) {
                $this->DISTRIBUTION_TYPE->addErrorMessage(str_replace("%s", $this->DISTRIBUTION_TYPE->caption(), $this->DISTRIBUTION_TYPE->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("GoodGfGrid");
        if (in_array("GOOD_GF", $detailTblVar) && $detailPage->DetailEdit) {
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
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

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

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("GoodGfGrid");
                    if (in_array("GOOD_GF", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "GOOD_GF"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
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
            if (in_array("GOOD_GF", $detailTblVar)) {
                $detailPageObj = Container("GoodGfGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->ROOMS_ID->IsDetailKey = true;
                    $detailPageObj->ROOMS_ID->CurrentValue = $this->CLINIC_ID_TO->CurrentValue;
                    $detailPageObj->ROOMS_ID->setSessionValue($detailPageObj->ROOMS_ID->CurrentValue);
                    $detailPageObj->ORG_ID->IsDetailKey = true;
                    $detailPageObj->ORG_ID->CurrentValue = $this->CLINIC_ID_TO->CurrentValue;
                    $detailPageObj->ORG_ID->setSessionValue($detailPageObj->ORG_ID->CurrentValue);
                    $detailPageObj->FROM_ROOMS_ID->IsDetailKey = true;
                    $detailPageObj->FROM_ROOMS_ID->CurrentValue = $this->CLINIC_ID->CurrentValue;
                    $detailPageObj->FROM_ROOMS_ID->setSessionValue($detailPageObj->FROM_ROOMS_ID->CurrentValue);
                    $detailPageObj->DOC_NO->IsDetailKey = true;
                    $detailPageObj->DOC_NO->CurrentValue = $this->DOC_NO->CurrentValue;
                    $detailPageObj->DOC_NO->setSessionValue($detailPageObj->DOC_NO->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MutationDocsList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_CLINIC_ID":
                    $lookupFilter = function () {
                        return "[STYPE_ID] = 70 or [STYPE_ID] = 73";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_CLINIC_ID_TO":
                    $lookupFilter = function () {
                        return "[STYPE_ID] = 1 or [STYPE_ID] = 2 or [STYPE_ID] = 3 OR [STYPE_ID] = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_DISTRIBUTION_TYPE":
                    break;
                case "x_COMPANY_ID":
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
}
