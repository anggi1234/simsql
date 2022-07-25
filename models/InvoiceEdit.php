<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class InvoiceEdit extends Invoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'INVOICE';

    // Page object name
    public $PageObjName = "InvoiceEdit";

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

        // Table object (INVOICE)
        if (!isset($GLOBALS["INVOICE"]) || get_class($GLOBALS["INVOICE"]) == PROJECT_NAMESPACE . "INVOICE") {
            $GLOBALS["INVOICE"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "InvoiceView") {
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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ORG_UNIT_CODE") ?? Key(0) ?? Route(2)) !== null) {
                $this->ORG_UNIT_CODE->setQueryStringValue($keyValue);
                $this->ORG_UNIT_CODE->setOldValue($this->ORG_UNIT_CODE->QueryStringValue);
            } elseif (Post("ORG_UNIT_CODE") !== null) {
                $this->ORG_UNIT_CODE->setFormValue(Post("ORG_UNIT_CODE"));
                $this->ORG_UNIT_CODE->setOldValue($this->ORG_UNIT_CODE->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }
            if (($keyValue = Get("INVOICE_ID") ?? Key(1) ?? Route(3)) !== null) {
                $this->INVOICE_ID->setQueryStringValue($keyValue);
                $this->INVOICE_ID->setOldValue($this->INVOICE_ID->QueryStringValue);
            } elseif (Post("INVOICE_ID") !== null) {
                $this->INVOICE_ID->setFormValue(Post("INVOICE_ID"));
                $this->INVOICE_ID->setOldValue($this->INVOICE_ID->FormValue);
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
                if (($keyValue = Get("ORG_UNIT_CODE") ?? Route("ORG_UNIT_CODE")) !== null) {
                    $this->ORG_UNIT_CODE->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ORG_UNIT_CODE->CurrentValue = null;
                }
                if (($keyValue = Get("INVOICE_ID") ?? Route("INVOICE_ID")) !== null) {
                    $this->INVOICE_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->INVOICE_ID->CurrentValue = null;
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
                    $this->terminate("InvoiceList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "InvoiceList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
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

        // Check field name 'ORG_UNIT_CODE' first before field var 'x_ORG_UNIT_CODE'
        $val = $CurrentForm->hasValue("ORG_UNIT_CODE") ? $CurrentForm->getValue("ORG_UNIT_CODE") : $CurrentForm->getValue("x_ORG_UNIT_CODE");
        if (!$this->ORG_UNIT_CODE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_UNIT_CODE->Visible = false; // Disable update for API request
            } else {
                $this->ORG_UNIT_CODE->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ORG_UNIT_CODE")) {
            $this->ORG_UNIT_CODE->setOldValue($CurrentForm->getValue("o_ORG_UNIT_CODE"));
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
        if ($CurrentForm->hasValue("o_INVOICE_ID")) {
            $this->INVOICE_ID->setOldValue($CurrentForm->getValue("o_INVOICE_ID"));
        }

        // Check field name 'INVOICE_TYPE' first before field var 'x_INVOICE_TYPE'
        $val = $CurrentForm->hasValue("INVOICE_TYPE") ? $CurrentForm->getValue("INVOICE_TYPE") : $CurrentForm->getValue("x_INVOICE_TYPE");
        if (!$this->INVOICE_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_TYPE->setFormValue($val);
            }
        }

        // Check field name 'INVOICE_NO' first before field var 'x_INVOICE_NO'
        $val = $CurrentForm->hasValue("INVOICE_NO") ? $CurrentForm->getValue("INVOICE_NO") : $CurrentForm->getValue("x_INVOICE_NO");
        if (!$this->INVOICE_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_NO->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_NO->setFormValue($val);
            }
        }

        // Check field name 'INV_COUNTER' first before field var 'x_INV_COUNTER'
        $val = $CurrentForm->hasValue("INV_COUNTER") ? $CurrentForm->getValue("INV_COUNTER") : $CurrentForm->getValue("x_INV_COUNTER");
        if (!$this->INV_COUNTER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INV_COUNTER->Visible = false; // Disable update for API request
            } else {
                $this->INV_COUNTER->setFormValue($val);
            }
        }

        // Check field name 'INV_DATE' first before field var 'x_INV_DATE'
        $val = $CurrentForm->hasValue("INV_DATE") ? $CurrentForm->getValue("INV_DATE") : $CurrentForm->getValue("x_INV_DATE");
        if (!$this->INV_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INV_DATE->Visible = false; // Disable update for API request
            } else {
                $this->INV_DATE->setFormValue($val);
            }
            $this->INV_DATE->CurrentValue = UnFormatDateTime($this->INV_DATE->CurrentValue, 0);
        }

        // Check field name 'INVOICE_TRANS' first before field var 'x_INVOICE_TRANS'
        $val = $CurrentForm->hasValue("INVOICE_TRANS") ? $CurrentForm->getValue("INVOICE_TRANS") : $CurrentForm->getValue("x_INVOICE_TRANS");
        if (!$this->INVOICE_TRANS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_TRANS->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_TRANS->setFormValue($val);
            }
            $this->INVOICE_TRANS->CurrentValue = UnFormatDateTime($this->INVOICE_TRANS->CurrentValue, 0);
        }

        // Check field name 'INVOICE_DUE' first before field var 'x_INVOICE_DUE'
        $val = $CurrentForm->hasValue("INVOICE_DUE") ? $CurrentForm->getValue("INVOICE_DUE") : $CurrentForm->getValue("x_INVOICE_DUE");
        if (!$this->INVOICE_DUE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INVOICE_DUE->Visible = false; // Disable update for API request
            } else {
                $this->INVOICE_DUE->setFormValue($val);
            }
            $this->INVOICE_DUE->CurrentValue = UnFormatDateTime($this->INVOICE_DUE->CurrentValue, 0);
        }

        // Check field name 'REF_TYPE' first before field var 'x_REF_TYPE'
        $val = $CurrentForm->hasValue("REF_TYPE") ? $CurrentForm->getValue("REF_TYPE") : $CurrentForm->getValue("x_REF_TYPE");
        if (!$this->REF_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REF_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->REF_TYPE->setFormValue($val);
            }
        }

        // Check field name 'REF_NO' first before field var 'x_REF_NO'
        $val = $CurrentForm->hasValue("REF_NO") ? $CurrentForm->getValue("REF_NO") : $CurrentForm->getValue("x_REF_NO");
        if (!$this->REF_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REF_NO->Visible = false; // Disable update for API request
            } else {
                $this->REF_NO->setFormValue($val);
            }
        }

        // Check field name 'REF_NO2' first before field var 'x_REF_NO2'
        $val = $CurrentForm->hasValue("REF_NO2") ? $CurrentForm->getValue("REF_NO2") : $CurrentForm->getValue("x_REF_NO2");
        if (!$this->REF_NO2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REF_NO2->Visible = false; // Disable update for API request
            } else {
                $this->REF_NO2->setFormValue($val);
            }
        }

        // Check field name 'REF_DATE' first before field var 'x_REF_DATE'
        $val = $CurrentForm->hasValue("REF_DATE") ? $CurrentForm->getValue("REF_DATE") : $CurrentForm->getValue("x_REF_DATE");
        if (!$this->REF_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->REF_DATE->Visible = false; // Disable update for API request
            } else {
                $this->REF_DATE->setFormValue($val);
            }
            $this->REF_DATE->CurrentValue = UnFormatDateTime($this->REF_DATE->CurrentValue, 0);
        }

        // Check field name 'ACCOUNT_ID' first before field var 'x_ACCOUNT_ID'
        $val = $CurrentForm->hasValue("ACCOUNT_ID") ? $CurrentForm->getValue("ACCOUNT_ID") : $CurrentForm->getValue("x_ACCOUNT_ID");
        if (!$this->ACCOUNT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACCOUNT_ID->Visible = false; // Disable update for API request
            } else {
                $this->ACCOUNT_ID->setFormValue($val);
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

        // Check field name 'ORG_ID' first before field var 'x_ORG_ID'
        $val = $CurrentForm->hasValue("ORG_ID") ? $CurrentForm->getValue("ORG_ID") : $CurrentForm->getValue("x_ORG_ID");
        if (!$this->ORG_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORG_ID->Visible = false; // Disable update for API request
            } else {
                $this->ORG_ID->setFormValue($val);
            }
        }

        // Check field name 'PROGRAM_ID' first before field var 'x_PROGRAM_ID'
        $val = $CurrentForm->hasValue("PROGRAM_ID") ? $CurrentForm->getValue("PROGRAM_ID") : $CurrentForm->getValue("x_PROGRAM_ID");
        if (!$this->PROGRAM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PROGRAM_ID->Visible = false; // Disable update for API request
            } else {
                $this->PROGRAM_ID->setFormValue($val);
            }
        }

        // Check field name 'PROGRAMS' first before field var 'x_PROGRAMS'
        $val = $CurrentForm->hasValue("PROGRAMS") ? $CurrentForm->getValue("PROGRAMS") : $CurrentForm->getValue("x_PROGRAMS");
        if (!$this->PROGRAMS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PROGRAMS->Visible = false; // Disable update for API request
            } else {
                $this->PROGRAMS->setFormValue($val);
            }
        }

        // Check field name 'PACTIVITY_ID' first before field var 'x_PACTIVITY_ID'
        $val = $CurrentForm->hasValue("PACTIVITY_ID") ? $CurrentForm->getValue("PACTIVITY_ID") : $CurrentForm->getValue("x_PACTIVITY_ID");
        if (!$this->PACTIVITY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PACTIVITY_ID->Visible = false; // Disable update for API request
            } else {
                $this->PACTIVITY_ID->setFormValue($val);
            }
        }

        // Check field name 'ACTIVITY_ID' first before field var 'x_ACTIVITY_ID'
        $val = $CurrentForm->hasValue("ACTIVITY_ID") ? $CurrentForm->getValue("ACTIVITY_ID") : $CurrentForm->getValue("x_ACTIVITY_ID");
        if (!$this->ACTIVITY_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACTIVITY_ID->Visible = false; // Disable update for API request
            } else {
                $this->ACTIVITY_ID->setFormValue($val);
            }
        }

        // Check field name 'ACTIVITY_NAME' first before field var 'x_ACTIVITY_NAME'
        $val = $CurrentForm->hasValue("ACTIVITY_NAME") ? $CurrentForm->getValue("ACTIVITY_NAME") : $CurrentForm->getValue("x_ACTIVITY_NAME");
        if (!$this->ACTIVITY_NAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ACTIVITY_NAME->Visible = false; // Disable update for API request
            } else {
                $this->ACTIVITY_NAME->setFormValue($val);
            }
        }

        // Check field name 'KEPERLUAN' first before field var 'x_KEPERLUAN'
        $val = $CurrentForm->hasValue("KEPERLUAN") ? $CurrentForm->getValue("KEPERLUAN") : $CurrentForm->getValue("x_KEPERLUAN");
        if (!$this->KEPERLUAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KEPERLUAN->Visible = false; // Disable update for API request
            } else {
                $this->KEPERLUAN->setFormValue($val);
            }
        }

        // Check field name 'PPTK' first before field var 'x_PPTK'
        $val = $CurrentForm->hasValue("PPTK") ? $CurrentForm->getValue("PPTK") : $CurrentForm->getValue("x_PPTK");
        if (!$this->PPTK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPTK->Visible = false; // Disable update for API request
            } else {
                $this->PPTK->setFormValue($val);
            }
        }

        // Check field name 'PPTK_NAME' first before field var 'x_PPTK_NAME'
        $val = $CurrentForm->hasValue("PPTK_NAME") ? $CurrentForm->getValue("PPTK_NAME") : $CurrentForm->getValue("x_PPTK_NAME");
        if (!$this->PPTK_NAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPTK_NAME->Visible = false; // Disable update for API request
            } else {
                $this->PPTK_NAME->setFormValue($val);
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

        // Check field name 'COMPANY_TO' first before field var 'x_COMPANY_TO'
        $val = $CurrentForm->hasValue("COMPANY_TO") ? $CurrentForm->getValue("COMPANY_TO") : $CurrentForm->getValue("x_COMPANY_TO");
        if (!$this->COMPANY_TO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_TO->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_TO->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_TYPE' first before field var 'x_COMPANY_TYPE'
        $val = $CurrentForm->hasValue("COMPANY_TYPE") ? $CurrentForm->getValue("COMPANY_TYPE") : $CurrentForm->getValue("x_COMPANY_TYPE");
        if (!$this->COMPANY_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_TYPE->setFormValue($val);
            }
        }

        // Check field name 'COMPANY' first before field var 'x_COMPANY'
        $val = $CurrentForm->hasValue("COMPANY") ? $CurrentForm->getValue("COMPANY") : $CurrentForm->getValue("x_COMPANY");
        if (!$this->COMPANY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_CHIEF' first before field var 'x_COMPANY_CHIEF'
        $val = $CurrentForm->hasValue("COMPANY_CHIEF") ? $CurrentForm->getValue("COMPANY_CHIEF") : $CurrentForm->getValue("x_COMPANY_CHIEF");
        if (!$this->COMPANY_CHIEF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_CHIEF->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_CHIEF->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_INFO' first before field var 'x_COMPANY_INFO'
        $val = $CurrentForm->hasValue("COMPANY_INFO") ? $CurrentForm->getValue("COMPANY_INFO") : $CurrentForm->getValue("x_COMPANY_INFO");
        if (!$this->COMPANY_INFO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_INFO->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_INFO->setFormValue($val);
            }
        }

        // Check field name 'CONTRACT_NO' first before field var 'x_CONTRACT_NO'
        $val = $CurrentForm->hasValue("CONTRACT_NO") ? $CurrentForm->getValue("CONTRACT_NO") : $CurrentForm->getValue("x_CONTRACT_NO");
        if (!$this->CONTRACT_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CONTRACT_NO->Visible = false; // Disable update for API request
            } else {
                $this->CONTRACT_NO->setFormValue($val);
            }
        }

        // Check field name 'NPWP' first before field var 'x_NPWP'
        $val = $CurrentForm->hasValue("NPWP") ? $CurrentForm->getValue("NPWP") : $CurrentForm->getValue("x_NPWP");
        if (!$this->NPWP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NPWP->Visible = false; // Disable update for API request
            } else {
                $this->NPWP->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_BANK' first before field var 'x_COMPANY_BANK'
        $val = $CurrentForm->hasValue("COMPANY_BANK") ? $CurrentForm->getValue("COMPANY_BANK") : $CurrentForm->getValue("x_COMPANY_BANK");
        if (!$this->COMPANY_BANK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_BANK->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_BANK->setFormValue($val);
            }
        }

        // Check field name 'COMPANY_ACCOUNT' first before field var 'x_COMPANY_ACCOUNT'
        $val = $CurrentForm->hasValue("COMPANY_ACCOUNT") ? $CurrentForm->getValue("COMPANY_ACCOUNT") : $CurrentForm->getValue("x_COMPANY_ACCOUNT");
        if (!$this->COMPANY_ACCOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->COMPANY_ACCOUNT->Visible = false; // Disable update for API request
            } else {
                $this->COMPANY_ACCOUNT->setFormValue($val);
            }
        }

        // Check field name 'PAGU' first before field var 'x_PAGU'
        $val = $CurrentForm->hasValue("PAGU") ? $CurrentForm->getValue("PAGU") : $CurrentForm->getValue("x_PAGU");
        if (!$this->PAGU->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAGU->Visible = false; // Disable update for API request
            } else {
                $this->PAGU->setFormValue($val);
            }
        }

        // Check field name 'PAGU_REALISASI' first before field var 'x_PAGU_REALISASI'
        $val = $CurrentForm->hasValue("PAGU_REALISASI") ? $CurrentForm->getValue("PAGU_REALISASI") : $CurrentForm->getValue("x_PAGU_REALISASI");
        if (!$this->PAGU_REALISASI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAGU_REALISASI->Visible = false; // Disable update for API request
            } else {
                $this->PAGU_REALISASI->setFormValue($val);
            }
        }

        // Check field name 'AMOUNT' first before field var 'x_AMOUNT'
        $val = $CurrentForm->hasValue("AMOUNT") ? $CurrentForm->getValue("AMOUNT") : $CurrentForm->getValue("x_AMOUNT");
        if (!$this->AMOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT->setFormValue($val);
            }
        }

        // Check field name 'AMOUNT_PAID' first before field var 'x_AMOUNT_PAID'
        $val = $CurrentForm->hasValue("AMOUNT_PAID") ? $CurrentForm->getValue("AMOUNT_PAID") : $CurrentForm->getValue("x_AMOUNT_PAID");
        if (!$this->AMOUNT_PAID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AMOUNT_PAID->Visible = false; // Disable update for API request
            } else {
                $this->AMOUNT_PAID->setFormValue($val);
            }
        }

        // Check field name 'PAYMENT_INSTRUCTIONS' first before field var 'x_PAYMENT_INSTRUCTIONS'
        $val = $CurrentForm->hasValue("PAYMENT_INSTRUCTIONS") ? $CurrentForm->getValue("PAYMENT_INSTRUCTIONS") : $CurrentForm->getValue("x_PAYMENT_INSTRUCTIONS");
        if (!$this->PAYMENT_INSTRUCTIONS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PAYMENT_INSTRUCTIONS->Visible = false; // Disable update for API request
            } else {
                $this->PAYMENT_INSTRUCTIONS->setFormValue($val);
            }
        }

        // Check field name 'ISAPPROVED' first before field var 'x_ISAPPROVED'
        $val = $CurrentForm->hasValue("ISAPPROVED") ? $CurrentForm->getValue("ISAPPROVED") : $CurrentForm->getValue("x_ISAPPROVED");
        if (!$this->ISAPPROVED->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISAPPROVED->Visible = false; // Disable update for API request
            } else {
                $this->ISAPPROVED->setFormValue($val);
            }
        }

        // Check field name 'APPROVED_BY' first before field var 'x_APPROVED_BY'
        $val = $CurrentForm->hasValue("APPROVED_BY") ? $CurrentForm->getValue("APPROVED_BY") : $CurrentForm->getValue("x_APPROVED_BY");
        if (!$this->APPROVED_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVED_BY->Visible = false; // Disable update for API request
            } else {
                $this->APPROVED_BY->setFormValue($val);
            }
        }

        // Check field name 'APPROVED_DATE' first before field var 'x_APPROVED_DATE'
        $val = $CurrentForm->hasValue("APPROVED_DATE") ? $CurrentForm->getValue("APPROVED_DATE") : $CurrentForm->getValue("x_APPROVED_DATE");
        if (!$this->APPROVED_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVED_DATE->Visible = false; // Disable update for API request
            } else {
                $this->APPROVED_DATE->setFormValue($val);
            }
            $this->APPROVED_DATE->CurrentValue = UnFormatDateTime($this->APPROVED_DATE->CurrentValue, 0);
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

        // Check field name 'PRINTQ' first before field var 'x_PRINTQ'
        $val = $CurrentForm->hasValue("PRINTQ") ? $CurrentForm->getValue("PRINTQ") : $CurrentForm->getValue("x_PRINTQ");
        if (!$this->PRINTQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTQ->Visible = false; // Disable update for API request
            } else {
                $this->PRINTQ->setFormValue($val);
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

        // Check field name 'PPTK_TITLE' first before field var 'x_PPTK_TITLE'
        $val = $CurrentForm->hasValue("PPTK_TITLE") ? $CurrentForm->getValue("PPTK_TITLE") : $CurrentForm->getValue("x_PPTK_TITLE");
        if (!$this->PPTK_TITLE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPTK_TITLE->Visible = false; // Disable update for API request
            } else {
                $this->PPTK_TITLE->setFormValue($val);
            }
        }

        // Check field name 'APPROVED_ID' first before field var 'x_APPROVED_ID'
        $val = $CurrentForm->hasValue("APPROVED_ID") ? $CurrentForm->getValue("APPROVED_ID") : $CurrentForm->getValue("x_APPROVED_ID");
        if (!$this->APPROVED_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVED_ID->Visible = false; // Disable update for API request
            } else {
                $this->APPROVED_ID->setFormValue($val);
            }
        }

        // Check field name 'APPROVED_TITLE' first before field var 'x_APPROVED_TITLE'
        $val = $CurrentForm->hasValue("APPROVED_TITLE") ? $CurrentForm->getValue("APPROVED_TITLE") : $CurrentForm->getValue("x_APPROVED_TITLE");
        if (!$this->APPROVED_TITLE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APPROVED_TITLE->Visible = false; // Disable update for API request
            } else {
                $this->APPROVED_TITLE->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->INVOICE_ID->CurrentValue = $this->INVOICE_ID->FormValue;
        $this->INVOICE_TYPE->CurrentValue = $this->INVOICE_TYPE->FormValue;
        $this->INVOICE_NO->CurrentValue = $this->INVOICE_NO->FormValue;
        $this->INV_COUNTER->CurrentValue = $this->INV_COUNTER->FormValue;
        $this->INV_DATE->CurrentValue = $this->INV_DATE->FormValue;
        $this->INV_DATE->CurrentValue = UnFormatDateTime($this->INV_DATE->CurrentValue, 0);
        $this->INVOICE_TRANS->CurrentValue = $this->INVOICE_TRANS->FormValue;
        $this->INVOICE_TRANS->CurrentValue = UnFormatDateTime($this->INVOICE_TRANS->CurrentValue, 0);
        $this->INVOICE_DUE->CurrentValue = $this->INVOICE_DUE->FormValue;
        $this->INVOICE_DUE->CurrentValue = UnFormatDateTime($this->INVOICE_DUE->CurrentValue, 0);
        $this->REF_TYPE->CurrentValue = $this->REF_TYPE->FormValue;
        $this->REF_NO->CurrentValue = $this->REF_NO->FormValue;
        $this->REF_NO2->CurrentValue = $this->REF_NO2->FormValue;
        $this->REF_DATE->CurrentValue = $this->REF_DATE->FormValue;
        $this->REF_DATE->CurrentValue = UnFormatDateTime($this->REF_DATE->CurrentValue, 0);
        $this->ACCOUNT_ID->CurrentValue = $this->ACCOUNT_ID->FormValue;
        $this->YEAR_ID->CurrentValue = $this->YEAR_ID->FormValue;
        $this->ORG_ID->CurrentValue = $this->ORG_ID->FormValue;
        $this->PROGRAM_ID->CurrentValue = $this->PROGRAM_ID->FormValue;
        $this->PROGRAMS->CurrentValue = $this->PROGRAMS->FormValue;
        $this->PACTIVITY_ID->CurrentValue = $this->PACTIVITY_ID->FormValue;
        $this->ACTIVITY_ID->CurrentValue = $this->ACTIVITY_ID->FormValue;
        $this->ACTIVITY_NAME->CurrentValue = $this->ACTIVITY_NAME->FormValue;
        $this->KEPERLUAN->CurrentValue = $this->KEPERLUAN->FormValue;
        $this->PPTK->CurrentValue = $this->PPTK->FormValue;
        $this->PPTK_NAME->CurrentValue = $this->PPTK_NAME->FormValue;
        $this->COMPANY_ID->CurrentValue = $this->COMPANY_ID->FormValue;
        $this->COMPANY_TO->CurrentValue = $this->COMPANY_TO->FormValue;
        $this->COMPANY_TYPE->CurrentValue = $this->COMPANY_TYPE->FormValue;
        $this->COMPANY->CurrentValue = $this->COMPANY->FormValue;
        $this->COMPANY_CHIEF->CurrentValue = $this->COMPANY_CHIEF->FormValue;
        $this->COMPANY_INFO->CurrentValue = $this->COMPANY_INFO->FormValue;
        $this->CONTRACT_NO->CurrentValue = $this->CONTRACT_NO->FormValue;
        $this->NPWP->CurrentValue = $this->NPWP->FormValue;
        $this->COMPANY_BANK->CurrentValue = $this->COMPANY_BANK->FormValue;
        $this->COMPANY_ACCOUNT->CurrentValue = $this->COMPANY_ACCOUNT->FormValue;
        $this->PAGU->CurrentValue = $this->PAGU->FormValue;
        $this->PAGU_REALISASI->CurrentValue = $this->PAGU_REALISASI->FormValue;
        $this->AMOUNT->CurrentValue = $this->AMOUNT->FormValue;
        $this->AMOUNT_PAID->CurrentValue = $this->AMOUNT_PAID->FormValue;
        $this->PAYMENT_INSTRUCTIONS->CurrentValue = $this->PAYMENT_INSTRUCTIONS->FormValue;
        $this->ISAPPROVED->CurrentValue = $this->ISAPPROVED->FormValue;
        $this->APPROVED_BY->CurrentValue = $this->APPROVED_BY->FormValue;
        $this->APPROVED_DATE->CurrentValue = $this->APPROVED_DATE->FormValue;
        $this->APPROVED_DATE->CurrentValue = UnFormatDateTime($this->APPROVED_DATE->CurrentValue, 0);
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->PPTK_TITLE->CurrentValue = $this->PPTK_TITLE->FormValue;
        $this->APPROVED_ID->CurrentValue = $this->APPROVED_ID->FormValue;
        $this->APPROVED_TITLE->CurrentValue = $this->APPROVED_TITLE->FormValue;
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->CurrentValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // INVOICE_TYPE
            $this->INVOICE_TYPE->EditAttrs["class"] = "form-control";
            $this->INVOICE_TYPE->EditCustomAttributes = "";
            $this->INVOICE_TYPE->EditValue = HtmlEncode($this->INVOICE_TYPE->CurrentValue);
            $this->INVOICE_TYPE->PlaceHolder = RemoveHtml($this->INVOICE_TYPE->caption());

            // INVOICE_NO
            $this->INVOICE_NO->EditAttrs["class"] = "form-control";
            $this->INVOICE_NO->EditCustomAttributes = "";
            if (!$this->INVOICE_NO->Raw) {
                $this->INVOICE_NO->CurrentValue = HtmlDecode($this->INVOICE_NO->CurrentValue);
            }
            $this->INVOICE_NO->EditValue = HtmlEncode($this->INVOICE_NO->CurrentValue);
            $this->INVOICE_NO->PlaceHolder = RemoveHtml($this->INVOICE_NO->caption());

            // INV_COUNTER
            $this->INV_COUNTER->EditAttrs["class"] = "form-control";
            $this->INV_COUNTER->EditCustomAttributes = "";
            $this->INV_COUNTER->EditValue = HtmlEncode($this->INV_COUNTER->CurrentValue);
            $this->INV_COUNTER->PlaceHolder = RemoveHtml($this->INV_COUNTER->caption());

            // INV_DATE
            $this->INV_DATE->EditAttrs["class"] = "form-control";
            $this->INV_DATE->EditCustomAttributes = "";
            $this->INV_DATE->EditValue = HtmlEncode(FormatDateTime($this->INV_DATE->CurrentValue, 8));
            $this->INV_DATE->PlaceHolder = RemoveHtml($this->INV_DATE->caption());

            // INVOICE_TRANS
            $this->INVOICE_TRANS->EditAttrs["class"] = "form-control";
            $this->INVOICE_TRANS->EditCustomAttributes = "";
            $this->INVOICE_TRANS->EditValue = HtmlEncode(FormatDateTime($this->INVOICE_TRANS->CurrentValue, 8));
            $this->INVOICE_TRANS->PlaceHolder = RemoveHtml($this->INVOICE_TRANS->caption());

            // INVOICE_DUE
            $this->INVOICE_DUE->EditAttrs["class"] = "form-control";
            $this->INVOICE_DUE->EditCustomAttributes = "";
            $this->INVOICE_DUE->EditValue = HtmlEncode(FormatDateTime($this->INVOICE_DUE->CurrentValue, 8));
            $this->INVOICE_DUE->PlaceHolder = RemoveHtml($this->INVOICE_DUE->caption());

            // REF_TYPE
            $this->REF_TYPE->EditAttrs["class"] = "form-control";
            $this->REF_TYPE->EditCustomAttributes = "";
            $this->REF_TYPE->EditValue = HtmlEncode($this->REF_TYPE->CurrentValue);
            $this->REF_TYPE->PlaceHolder = RemoveHtml($this->REF_TYPE->caption());

            // REF_NO
            $this->REF_NO->EditAttrs["class"] = "form-control";
            $this->REF_NO->EditCustomAttributes = "";
            if (!$this->REF_NO->Raw) {
                $this->REF_NO->CurrentValue = HtmlDecode($this->REF_NO->CurrentValue);
            }
            $this->REF_NO->EditValue = HtmlEncode($this->REF_NO->CurrentValue);
            $this->REF_NO->PlaceHolder = RemoveHtml($this->REF_NO->caption());

            // REF_NO2
            $this->REF_NO2->EditAttrs["class"] = "form-control";
            $this->REF_NO2->EditCustomAttributes = "";
            if (!$this->REF_NO2->Raw) {
                $this->REF_NO2->CurrentValue = HtmlDecode($this->REF_NO2->CurrentValue);
            }
            $this->REF_NO2->EditValue = HtmlEncode($this->REF_NO2->CurrentValue);
            $this->REF_NO2->PlaceHolder = RemoveHtml($this->REF_NO2->caption());

            // REF_DATE
            $this->REF_DATE->EditAttrs["class"] = "form-control";
            $this->REF_DATE->EditCustomAttributes = "";
            $this->REF_DATE->EditValue = HtmlEncode(FormatDateTime($this->REF_DATE->CurrentValue, 8));
            $this->REF_DATE->PlaceHolder = RemoveHtml($this->REF_DATE->caption());

            // ACCOUNT_ID
            $this->ACCOUNT_ID->EditAttrs["class"] = "form-control";
            $this->ACCOUNT_ID->EditCustomAttributes = "";
            if (!$this->ACCOUNT_ID->Raw) {
                $this->ACCOUNT_ID->CurrentValue = HtmlDecode($this->ACCOUNT_ID->CurrentValue);
            }
            $this->ACCOUNT_ID->EditValue = HtmlEncode($this->ACCOUNT_ID->CurrentValue);
            $this->ACCOUNT_ID->PlaceHolder = RemoveHtml($this->ACCOUNT_ID->caption());

            // YEAR_ID
            $this->YEAR_ID->EditAttrs["class"] = "form-control";
            $this->YEAR_ID->EditCustomAttributes = "";
            $this->YEAR_ID->EditValue = HtmlEncode($this->YEAR_ID->CurrentValue);
            $this->YEAR_ID->PlaceHolder = RemoveHtml($this->YEAR_ID->caption());

            // ORG_ID
            $this->ORG_ID->EditAttrs["class"] = "form-control";
            $this->ORG_ID->EditCustomAttributes = "";
            if (!$this->ORG_ID->Raw) {
                $this->ORG_ID->CurrentValue = HtmlDecode($this->ORG_ID->CurrentValue);
            }
            $this->ORG_ID->EditValue = HtmlEncode($this->ORG_ID->CurrentValue);
            $this->ORG_ID->PlaceHolder = RemoveHtml($this->ORG_ID->caption());

            // PROGRAM_ID
            $this->PROGRAM_ID->EditAttrs["class"] = "form-control";
            $this->PROGRAM_ID->EditCustomAttributes = "";
            if (!$this->PROGRAM_ID->Raw) {
                $this->PROGRAM_ID->CurrentValue = HtmlDecode($this->PROGRAM_ID->CurrentValue);
            }
            $this->PROGRAM_ID->EditValue = HtmlEncode($this->PROGRAM_ID->CurrentValue);
            $this->PROGRAM_ID->PlaceHolder = RemoveHtml($this->PROGRAM_ID->caption());

            // PROGRAMS
            $this->PROGRAMS->EditAttrs["class"] = "form-control";
            $this->PROGRAMS->EditCustomAttributes = "";
            if (!$this->PROGRAMS->Raw) {
                $this->PROGRAMS->CurrentValue = HtmlDecode($this->PROGRAMS->CurrentValue);
            }
            $this->PROGRAMS->EditValue = HtmlEncode($this->PROGRAMS->CurrentValue);
            $this->PROGRAMS->PlaceHolder = RemoveHtml($this->PROGRAMS->caption());

            // PACTIVITY_ID
            $this->PACTIVITY_ID->EditAttrs["class"] = "form-control";
            $this->PACTIVITY_ID->EditCustomAttributes = "";
            if (!$this->PACTIVITY_ID->Raw) {
                $this->PACTIVITY_ID->CurrentValue = HtmlDecode($this->PACTIVITY_ID->CurrentValue);
            }
            $this->PACTIVITY_ID->EditValue = HtmlEncode($this->PACTIVITY_ID->CurrentValue);
            $this->PACTIVITY_ID->PlaceHolder = RemoveHtml($this->PACTIVITY_ID->caption());

            // ACTIVITY_ID
            $this->ACTIVITY_ID->EditAttrs["class"] = "form-control";
            $this->ACTIVITY_ID->EditCustomAttributes = "";
            if (!$this->ACTIVITY_ID->Raw) {
                $this->ACTIVITY_ID->CurrentValue = HtmlDecode($this->ACTIVITY_ID->CurrentValue);
            }
            $this->ACTIVITY_ID->EditValue = HtmlEncode($this->ACTIVITY_ID->CurrentValue);
            $this->ACTIVITY_ID->PlaceHolder = RemoveHtml($this->ACTIVITY_ID->caption());

            // ACTIVITY_NAME
            $this->ACTIVITY_NAME->EditAttrs["class"] = "form-control";
            $this->ACTIVITY_NAME->EditCustomAttributes = "";
            if (!$this->ACTIVITY_NAME->Raw) {
                $this->ACTIVITY_NAME->CurrentValue = HtmlDecode($this->ACTIVITY_NAME->CurrentValue);
            }
            $this->ACTIVITY_NAME->EditValue = HtmlEncode($this->ACTIVITY_NAME->CurrentValue);
            $this->ACTIVITY_NAME->PlaceHolder = RemoveHtml($this->ACTIVITY_NAME->caption());

            // KEPERLUAN
            $this->KEPERLUAN->EditAttrs["class"] = "form-control";
            $this->KEPERLUAN->EditCustomAttributes = "";
            if (!$this->KEPERLUAN->Raw) {
                $this->KEPERLUAN->CurrentValue = HtmlDecode($this->KEPERLUAN->CurrentValue);
            }
            $this->KEPERLUAN->EditValue = HtmlEncode($this->KEPERLUAN->CurrentValue);
            $this->KEPERLUAN->PlaceHolder = RemoveHtml($this->KEPERLUAN->caption());

            // PPTK
            $this->PPTK->EditAttrs["class"] = "form-control";
            $this->PPTK->EditCustomAttributes = "";
            if (!$this->PPTK->Raw) {
                $this->PPTK->CurrentValue = HtmlDecode($this->PPTK->CurrentValue);
            }
            $this->PPTK->EditValue = HtmlEncode($this->PPTK->CurrentValue);
            $this->PPTK->PlaceHolder = RemoveHtml($this->PPTK->caption());

            // PPTK_NAME
            $this->PPTK_NAME->EditAttrs["class"] = "form-control";
            $this->PPTK_NAME->EditCustomAttributes = "";
            if (!$this->PPTK_NAME->Raw) {
                $this->PPTK_NAME->CurrentValue = HtmlDecode($this->PPTK_NAME->CurrentValue);
            }
            $this->PPTK_NAME->EditValue = HtmlEncode($this->PPTK_NAME->CurrentValue);
            $this->PPTK_NAME->PlaceHolder = RemoveHtml($this->PPTK_NAME->caption());

            // COMPANY_ID
            $this->COMPANY_ID->EditAttrs["class"] = "form-control";
            $this->COMPANY_ID->EditCustomAttributes = "";
            if (!$this->COMPANY_ID->Raw) {
                $this->COMPANY_ID->CurrentValue = HtmlDecode($this->COMPANY_ID->CurrentValue);
            }
            $this->COMPANY_ID->EditValue = HtmlEncode($this->COMPANY_ID->CurrentValue);
            $this->COMPANY_ID->PlaceHolder = RemoveHtml($this->COMPANY_ID->caption());

            // COMPANY_TO
            $this->COMPANY_TO->EditAttrs["class"] = "form-control";
            $this->COMPANY_TO->EditCustomAttributes = "";
            if (!$this->COMPANY_TO->Raw) {
                $this->COMPANY_TO->CurrentValue = HtmlDecode($this->COMPANY_TO->CurrentValue);
            }
            $this->COMPANY_TO->EditValue = HtmlEncode($this->COMPANY_TO->CurrentValue);
            $this->COMPANY_TO->PlaceHolder = RemoveHtml($this->COMPANY_TO->caption());

            // COMPANY_TYPE
            $this->COMPANY_TYPE->EditAttrs["class"] = "form-control";
            $this->COMPANY_TYPE->EditCustomAttributes = "";
            if (!$this->COMPANY_TYPE->Raw) {
                $this->COMPANY_TYPE->CurrentValue = HtmlDecode($this->COMPANY_TYPE->CurrentValue);
            }
            $this->COMPANY_TYPE->EditValue = HtmlEncode($this->COMPANY_TYPE->CurrentValue);
            $this->COMPANY_TYPE->PlaceHolder = RemoveHtml($this->COMPANY_TYPE->caption());

            // COMPANY
            $this->COMPANY->EditAttrs["class"] = "form-control";
            $this->COMPANY->EditCustomAttributes = "";
            if (!$this->COMPANY->Raw) {
                $this->COMPANY->CurrentValue = HtmlDecode($this->COMPANY->CurrentValue);
            }
            $this->COMPANY->EditValue = HtmlEncode($this->COMPANY->CurrentValue);
            $this->COMPANY->PlaceHolder = RemoveHtml($this->COMPANY->caption());

            // COMPANY_CHIEF
            $this->COMPANY_CHIEF->EditAttrs["class"] = "form-control";
            $this->COMPANY_CHIEF->EditCustomAttributes = "";
            if (!$this->COMPANY_CHIEF->Raw) {
                $this->COMPANY_CHIEF->CurrentValue = HtmlDecode($this->COMPANY_CHIEF->CurrentValue);
            }
            $this->COMPANY_CHIEF->EditValue = HtmlEncode($this->COMPANY_CHIEF->CurrentValue);
            $this->COMPANY_CHIEF->PlaceHolder = RemoveHtml($this->COMPANY_CHIEF->caption());

            // COMPANY_INFO
            $this->COMPANY_INFO->EditAttrs["class"] = "form-control";
            $this->COMPANY_INFO->EditCustomAttributes = "";
            if (!$this->COMPANY_INFO->Raw) {
                $this->COMPANY_INFO->CurrentValue = HtmlDecode($this->COMPANY_INFO->CurrentValue);
            }
            $this->COMPANY_INFO->EditValue = HtmlEncode($this->COMPANY_INFO->CurrentValue);
            $this->COMPANY_INFO->PlaceHolder = RemoveHtml($this->COMPANY_INFO->caption());

            // CONTRACT_NO
            $this->CONTRACT_NO->EditAttrs["class"] = "form-control";
            $this->CONTRACT_NO->EditCustomAttributes = "";
            if (!$this->CONTRACT_NO->Raw) {
                $this->CONTRACT_NO->CurrentValue = HtmlDecode($this->CONTRACT_NO->CurrentValue);
            }
            $this->CONTRACT_NO->EditValue = HtmlEncode($this->CONTRACT_NO->CurrentValue);
            $this->CONTRACT_NO->PlaceHolder = RemoveHtml($this->CONTRACT_NO->caption());

            // NPWP
            $this->NPWP->EditAttrs["class"] = "form-control";
            $this->NPWP->EditCustomAttributes = "";
            if (!$this->NPWP->Raw) {
                $this->NPWP->CurrentValue = HtmlDecode($this->NPWP->CurrentValue);
            }
            $this->NPWP->EditValue = HtmlEncode($this->NPWP->CurrentValue);
            $this->NPWP->PlaceHolder = RemoveHtml($this->NPWP->caption());

            // COMPANY_BANK
            $this->COMPANY_BANK->EditAttrs["class"] = "form-control";
            $this->COMPANY_BANK->EditCustomAttributes = "";
            if (!$this->COMPANY_BANK->Raw) {
                $this->COMPANY_BANK->CurrentValue = HtmlDecode($this->COMPANY_BANK->CurrentValue);
            }
            $this->COMPANY_BANK->EditValue = HtmlEncode($this->COMPANY_BANK->CurrentValue);
            $this->COMPANY_BANK->PlaceHolder = RemoveHtml($this->COMPANY_BANK->caption());

            // COMPANY_ACCOUNT
            $this->COMPANY_ACCOUNT->EditAttrs["class"] = "form-control";
            $this->COMPANY_ACCOUNT->EditCustomAttributes = "";
            if (!$this->COMPANY_ACCOUNT->Raw) {
                $this->COMPANY_ACCOUNT->CurrentValue = HtmlDecode($this->COMPANY_ACCOUNT->CurrentValue);
            }
            $this->COMPANY_ACCOUNT->EditValue = HtmlEncode($this->COMPANY_ACCOUNT->CurrentValue);
            $this->COMPANY_ACCOUNT->PlaceHolder = RemoveHtml($this->COMPANY_ACCOUNT->caption());

            // PAGU
            $this->PAGU->EditAttrs["class"] = "form-control";
            $this->PAGU->EditCustomAttributes = "";
            $this->PAGU->EditValue = HtmlEncode($this->PAGU->CurrentValue);
            $this->PAGU->PlaceHolder = RemoveHtml($this->PAGU->caption());
            if (strval($this->PAGU->EditValue) != "" && is_numeric($this->PAGU->EditValue)) {
                $this->PAGU->EditValue = FormatNumber($this->PAGU->EditValue, -2, -2, -2, -2);
            }

            // PAGU_REALISASI
            $this->PAGU_REALISASI->EditAttrs["class"] = "form-control";
            $this->PAGU_REALISASI->EditCustomAttributes = "";
            $this->PAGU_REALISASI->EditValue = HtmlEncode($this->PAGU_REALISASI->CurrentValue);
            $this->PAGU_REALISASI->PlaceHolder = RemoveHtml($this->PAGU_REALISASI->caption());
            if (strval($this->PAGU_REALISASI->EditValue) != "" && is_numeric($this->PAGU_REALISASI->EditValue)) {
                $this->PAGU_REALISASI->EditValue = FormatNumber($this->PAGU_REALISASI->EditValue, -2, -2, -2, -2);
            }

            // AMOUNT
            $this->AMOUNT->EditAttrs["class"] = "form-control";
            $this->AMOUNT->EditCustomAttributes = "";
            $this->AMOUNT->EditValue = HtmlEncode($this->AMOUNT->CurrentValue);
            $this->AMOUNT->PlaceHolder = RemoveHtml($this->AMOUNT->caption());
            if (strval($this->AMOUNT->EditValue) != "" && is_numeric($this->AMOUNT->EditValue)) {
                $this->AMOUNT->EditValue = FormatNumber($this->AMOUNT->EditValue, -2, -2, -2, -2);
            }

            // AMOUNT_PAID
            $this->AMOUNT_PAID->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PAID->EditCustomAttributes = "";
            $this->AMOUNT_PAID->EditValue = HtmlEncode($this->AMOUNT_PAID->CurrentValue);
            $this->AMOUNT_PAID->PlaceHolder = RemoveHtml($this->AMOUNT_PAID->caption());
            if (strval($this->AMOUNT_PAID->EditValue) != "" && is_numeric($this->AMOUNT_PAID->EditValue)) {
                $this->AMOUNT_PAID->EditValue = FormatNumber($this->AMOUNT_PAID->EditValue, -2, -2, -2, -2);
            }

            // PAYMENT_INSTRUCTIONS
            $this->PAYMENT_INSTRUCTIONS->EditAttrs["class"] = "form-control";
            $this->PAYMENT_INSTRUCTIONS->EditCustomAttributes = "";
            if (!$this->PAYMENT_INSTRUCTIONS->Raw) {
                $this->PAYMENT_INSTRUCTIONS->CurrentValue = HtmlDecode($this->PAYMENT_INSTRUCTIONS->CurrentValue);
            }
            $this->PAYMENT_INSTRUCTIONS->EditValue = HtmlEncode($this->PAYMENT_INSTRUCTIONS->CurrentValue);
            $this->PAYMENT_INSTRUCTIONS->PlaceHolder = RemoveHtml($this->PAYMENT_INSTRUCTIONS->caption());

            // ISAPPROVED
            $this->ISAPPROVED->EditAttrs["class"] = "form-control";
            $this->ISAPPROVED->EditCustomAttributes = "";
            if (!$this->ISAPPROVED->Raw) {
                $this->ISAPPROVED->CurrentValue = HtmlDecode($this->ISAPPROVED->CurrentValue);
            }
            $this->ISAPPROVED->EditValue = HtmlEncode($this->ISAPPROVED->CurrentValue);
            $this->ISAPPROVED->PlaceHolder = RemoveHtml($this->ISAPPROVED->caption());

            // APPROVED_BY
            $this->APPROVED_BY->EditAttrs["class"] = "form-control";
            $this->APPROVED_BY->EditCustomAttributes = "";
            if (!$this->APPROVED_BY->Raw) {
                $this->APPROVED_BY->CurrentValue = HtmlDecode($this->APPROVED_BY->CurrentValue);
            }
            $this->APPROVED_BY->EditValue = HtmlEncode($this->APPROVED_BY->CurrentValue);
            $this->APPROVED_BY->PlaceHolder = RemoveHtml($this->APPROVED_BY->caption());

            // APPROVED_DATE
            $this->APPROVED_DATE->EditAttrs["class"] = "form-control";
            $this->APPROVED_DATE->EditCustomAttributes = "";
            $this->APPROVED_DATE->EditValue = HtmlEncode(FormatDateTime($this->APPROVED_DATE->CurrentValue, 8));
            $this->APPROVED_DATE->PlaceHolder = RemoveHtml($this->APPROVED_DATE->caption());

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

            // PRINTQ
            $this->PRINTQ->EditAttrs["class"] = "form-control";
            $this->PRINTQ->EditCustomAttributes = "";
            $this->PRINTQ->EditValue = HtmlEncode($this->PRINTQ->CurrentValue);
            $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

            // PRINT_DATE
            $this->PRINT_DATE->EditAttrs["class"] = "form-control";
            $this->PRINT_DATE->EditCustomAttributes = "";
            $this->PRINT_DATE->EditValue = HtmlEncode(FormatDateTime($this->PRINT_DATE->CurrentValue, 8));
            $this->PRINT_DATE->PlaceHolder = RemoveHtml($this->PRINT_DATE->caption());

            // PRINTED_BY
            $this->PRINTED_BY->EditAttrs["class"] = "form-control";
            $this->PRINTED_BY->EditCustomAttributes = "";
            if (!$this->PRINTED_BY->Raw) {
                $this->PRINTED_BY->CurrentValue = HtmlDecode($this->PRINTED_BY->CurrentValue);
            }
            $this->PRINTED_BY->EditValue = HtmlEncode($this->PRINTED_BY->CurrentValue);
            $this->PRINTED_BY->PlaceHolder = RemoveHtml($this->PRINTED_BY->caption());

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

            // PPTK_TITLE
            $this->PPTK_TITLE->EditAttrs["class"] = "form-control";
            $this->PPTK_TITLE->EditCustomAttributes = "";
            if (!$this->PPTK_TITLE->Raw) {
                $this->PPTK_TITLE->CurrentValue = HtmlDecode($this->PPTK_TITLE->CurrentValue);
            }
            $this->PPTK_TITLE->EditValue = HtmlEncode($this->PPTK_TITLE->CurrentValue);
            $this->PPTK_TITLE->PlaceHolder = RemoveHtml($this->PPTK_TITLE->caption());

            // APPROVED_ID
            $this->APPROVED_ID->EditAttrs["class"] = "form-control";
            $this->APPROVED_ID->EditCustomAttributes = "";
            if (!$this->APPROVED_ID->Raw) {
                $this->APPROVED_ID->CurrentValue = HtmlDecode($this->APPROVED_ID->CurrentValue);
            }
            $this->APPROVED_ID->EditValue = HtmlEncode($this->APPROVED_ID->CurrentValue);
            $this->APPROVED_ID->PlaceHolder = RemoveHtml($this->APPROVED_ID->caption());

            // APPROVED_TITLE
            $this->APPROVED_TITLE->EditAttrs["class"] = "form-control";
            $this->APPROVED_TITLE->EditCustomAttributes = "";
            if (!$this->APPROVED_TITLE->Raw) {
                $this->APPROVED_TITLE->CurrentValue = HtmlDecode($this->APPROVED_TITLE->CurrentValue);
            }
            $this->APPROVED_TITLE->EditValue = HtmlEncode($this->APPROVED_TITLE->CurrentValue);
            $this->APPROVED_TITLE->PlaceHolder = RemoveHtml($this->APPROVED_TITLE->caption());

            // Edit refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";

            // INVOICE_TYPE
            $this->INVOICE_TYPE->LinkCustomAttributes = "";
            $this->INVOICE_TYPE->HrefValue = "";

            // INVOICE_NO
            $this->INVOICE_NO->LinkCustomAttributes = "";
            $this->INVOICE_NO->HrefValue = "";

            // INV_COUNTER
            $this->INV_COUNTER->LinkCustomAttributes = "";
            $this->INV_COUNTER->HrefValue = "";

            // INV_DATE
            $this->INV_DATE->LinkCustomAttributes = "";
            $this->INV_DATE->HrefValue = "";

            // INVOICE_TRANS
            $this->INVOICE_TRANS->LinkCustomAttributes = "";
            $this->INVOICE_TRANS->HrefValue = "";

            // INVOICE_DUE
            $this->INVOICE_DUE->LinkCustomAttributes = "";
            $this->INVOICE_DUE->HrefValue = "";

            // REF_TYPE
            $this->REF_TYPE->LinkCustomAttributes = "";
            $this->REF_TYPE->HrefValue = "";

            // REF_NO
            $this->REF_NO->LinkCustomAttributes = "";
            $this->REF_NO->HrefValue = "";

            // REF_NO2
            $this->REF_NO2->LinkCustomAttributes = "";
            $this->REF_NO2->HrefValue = "";

            // REF_DATE
            $this->REF_DATE->LinkCustomAttributes = "";
            $this->REF_DATE->HrefValue = "";

            // ACCOUNT_ID
            $this->ACCOUNT_ID->LinkCustomAttributes = "";
            $this->ACCOUNT_ID->HrefValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";

            // ORG_ID
            $this->ORG_ID->LinkCustomAttributes = "";
            $this->ORG_ID->HrefValue = "";

            // PROGRAM_ID
            $this->PROGRAM_ID->LinkCustomAttributes = "";
            $this->PROGRAM_ID->HrefValue = "";

            // PROGRAMS
            $this->PROGRAMS->LinkCustomAttributes = "";
            $this->PROGRAMS->HrefValue = "";

            // PACTIVITY_ID
            $this->PACTIVITY_ID->LinkCustomAttributes = "";
            $this->PACTIVITY_ID->HrefValue = "";

            // ACTIVITY_ID
            $this->ACTIVITY_ID->LinkCustomAttributes = "";
            $this->ACTIVITY_ID->HrefValue = "";

            // ACTIVITY_NAME
            $this->ACTIVITY_NAME->LinkCustomAttributes = "";
            $this->ACTIVITY_NAME->HrefValue = "";

            // KEPERLUAN
            $this->KEPERLUAN->LinkCustomAttributes = "";
            $this->KEPERLUAN->HrefValue = "";

            // PPTK
            $this->PPTK->LinkCustomAttributes = "";
            $this->PPTK->HrefValue = "";

            // PPTK_NAME
            $this->PPTK_NAME->LinkCustomAttributes = "";
            $this->PPTK_NAME->HrefValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";

            // COMPANY_TO
            $this->COMPANY_TO->LinkCustomAttributes = "";
            $this->COMPANY_TO->HrefValue = "";

            // COMPANY_TYPE
            $this->COMPANY_TYPE->LinkCustomAttributes = "";
            $this->COMPANY_TYPE->HrefValue = "";

            // COMPANY
            $this->COMPANY->LinkCustomAttributes = "";
            $this->COMPANY->HrefValue = "";

            // COMPANY_CHIEF
            $this->COMPANY_CHIEF->LinkCustomAttributes = "";
            $this->COMPANY_CHIEF->HrefValue = "";

            // COMPANY_INFO
            $this->COMPANY_INFO->LinkCustomAttributes = "";
            $this->COMPANY_INFO->HrefValue = "";

            // CONTRACT_NO
            $this->CONTRACT_NO->LinkCustomAttributes = "";
            $this->CONTRACT_NO->HrefValue = "";

            // NPWP
            $this->NPWP->LinkCustomAttributes = "";
            $this->NPWP->HrefValue = "";

            // COMPANY_BANK
            $this->COMPANY_BANK->LinkCustomAttributes = "";
            $this->COMPANY_BANK->HrefValue = "";

            // COMPANY_ACCOUNT
            $this->COMPANY_ACCOUNT->LinkCustomAttributes = "";
            $this->COMPANY_ACCOUNT->HrefValue = "";

            // PAGU
            $this->PAGU->LinkCustomAttributes = "";
            $this->PAGU->HrefValue = "";

            // PAGU_REALISASI
            $this->PAGU_REALISASI->LinkCustomAttributes = "";
            $this->PAGU_REALISASI->HrefValue = "";

            // AMOUNT
            $this->AMOUNT->LinkCustomAttributes = "";
            $this->AMOUNT->HrefValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";

            // PAYMENT_INSTRUCTIONS
            $this->PAYMENT_INSTRUCTIONS->LinkCustomAttributes = "";
            $this->PAYMENT_INSTRUCTIONS->HrefValue = "";

            // ISAPPROVED
            $this->ISAPPROVED->LinkCustomAttributes = "";
            $this->ISAPPROVED->HrefValue = "";

            // APPROVED_BY
            $this->APPROVED_BY->LinkCustomAttributes = "";
            $this->APPROVED_BY->HrefValue = "";

            // APPROVED_DATE
            $this->APPROVED_DATE->LinkCustomAttributes = "";
            $this->APPROVED_DATE->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // PPTK_TITLE
            $this->PPTK_TITLE->LinkCustomAttributes = "";
            $this->PPTK_TITLE->HrefValue = "";

            // APPROVED_ID
            $this->APPROVED_ID->LinkCustomAttributes = "";
            $this->APPROVED_ID->HrefValue = "";

            // APPROVED_TITLE
            $this->APPROVED_TITLE->LinkCustomAttributes = "";
            $this->APPROVED_TITLE->HrefValue = "";
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
        if ($this->INVOICE_ID->Required) {
            if (!$this->INVOICE_ID->IsDetailKey && EmptyValue($this->INVOICE_ID->FormValue)) {
                $this->INVOICE_ID->addErrorMessage(str_replace("%s", $this->INVOICE_ID->caption(), $this->INVOICE_ID->RequiredErrorMessage));
            }
        }
        if ($this->INVOICE_TYPE->Required) {
            if (!$this->INVOICE_TYPE->IsDetailKey && EmptyValue($this->INVOICE_TYPE->FormValue)) {
                $this->INVOICE_TYPE->addErrorMessage(str_replace("%s", $this->INVOICE_TYPE->caption(), $this->INVOICE_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->INVOICE_TYPE->FormValue)) {
            $this->INVOICE_TYPE->addErrorMessage($this->INVOICE_TYPE->getErrorMessage(false));
        }
        if ($this->INVOICE_NO->Required) {
            if (!$this->INVOICE_NO->IsDetailKey && EmptyValue($this->INVOICE_NO->FormValue)) {
                $this->INVOICE_NO->addErrorMessage(str_replace("%s", $this->INVOICE_NO->caption(), $this->INVOICE_NO->RequiredErrorMessage));
            }
        }
        if ($this->INV_COUNTER->Required) {
            if (!$this->INV_COUNTER->IsDetailKey && EmptyValue($this->INV_COUNTER->FormValue)) {
                $this->INV_COUNTER->addErrorMessage(str_replace("%s", $this->INV_COUNTER->caption(), $this->INV_COUNTER->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->INV_COUNTER->FormValue)) {
            $this->INV_COUNTER->addErrorMessage($this->INV_COUNTER->getErrorMessage(false));
        }
        if ($this->INV_DATE->Required) {
            if (!$this->INV_DATE->IsDetailKey && EmptyValue($this->INV_DATE->FormValue)) {
                $this->INV_DATE->addErrorMessage(str_replace("%s", $this->INV_DATE->caption(), $this->INV_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->INV_DATE->FormValue)) {
            $this->INV_DATE->addErrorMessage($this->INV_DATE->getErrorMessage(false));
        }
        if ($this->INVOICE_TRANS->Required) {
            if (!$this->INVOICE_TRANS->IsDetailKey && EmptyValue($this->INVOICE_TRANS->FormValue)) {
                $this->INVOICE_TRANS->addErrorMessage(str_replace("%s", $this->INVOICE_TRANS->caption(), $this->INVOICE_TRANS->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->INVOICE_TRANS->FormValue)) {
            $this->INVOICE_TRANS->addErrorMessage($this->INVOICE_TRANS->getErrorMessage(false));
        }
        if ($this->INVOICE_DUE->Required) {
            if (!$this->INVOICE_DUE->IsDetailKey && EmptyValue($this->INVOICE_DUE->FormValue)) {
                $this->INVOICE_DUE->addErrorMessage(str_replace("%s", $this->INVOICE_DUE->caption(), $this->INVOICE_DUE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->INVOICE_DUE->FormValue)) {
            $this->INVOICE_DUE->addErrorMessage($this->INVOICE_DUE->getErrorMessage(false));
        }
        if ($this->REF_TYPE->Required) {
            if (!$this->REF_TYPE->IsDetailKey && EmptyValue($this->REF_TYPE->FormValue)) {
                $this->REF_TYPE->addErrorMessage(str_replace("%s", $this->REF_TYPE->caption(), $this->REF_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->REF_TYPE->FormValue)) {
            $this->REF_TYPE->addErrorMessage($this->REF_TYPE->getErrorMessage(false));
        }
        if ($this->REF_NO->Required) {
            if (!$this->REF_NO->IsDetailKey && EmptyValue($this->REF_NO->FormValue)) {
                $this->REF_NO->addErrorMessage(str_replace("%s", $this->REF_NO->caption(), $this->REF_NO->RequiredErrorMessage));
            }
        }
        if ($this->REF_NO2->Required) {
            if (!$this->REF_NO2->IsDetailKey && EmptyValue($this->REF_NO2->FormValue)) {
                $this->REF_NO2->addErrorMessage(str_replace("%s", $this->REF_NO2->caption(), $this->REF_NO2->RequiredErrorMessage));
            }
        }
        if ($this->REF_DATE->Required) {
            if (!$this->REF_DATE->IsDetailKey && EmptyValue($this->REF_DATE->FormValue)) {
                $this->REF_DATE->addErrorMessage(str_replace("%s", $this->REF_DATE->caption(), $this->REF_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->REF_DATE->FormValue)) {
            $this->REF_DATE->addErrorMessage($this->REF_DATE->getErrorMessage(false));
        }
        if ($this->ACCOUNT_ID->Required) {
            if (!$this->ACCOUNT_ID->IsDetailKey && EmptyValue($this->ACCOUNT_ID->FormValue)) {
                $this->ACCOUNT_ID->addErrorMessage(str_replace("%s", $this->ACCOUNT_ID->caption(), $this->ACCOUNT_ID->RequiredErrorMessage));
            }
        }
        if ($this->YEAR_ID->Required) {
            if (!$this->YEAR_ID->IsDetailKey && EmptyValue($this->YEAR_ID->FormValue)) {
                $this->YEAR_ID->addErrorMessage(str_replace("%s", $this->YEAR_ID->caption(), $this->YEAR_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->YEAR_ID->FormValue)) {
            $this->YEAR_ID->addErrorMessage($this->YEAR_ID->getErrorMessage(false));
        }
        if ($this->ORG_ID->Required) {
            if (!$this->ORG_ID->IsDetailKey && EmptyValue($this->ORG_ID->FormValue)) {
                $this->ORG_ID->addErrorMessage(str_replace("%s", $this->ORG_ID->caption(), $this->ORG_ID->RequiredErrorMessage));
            }
        }
        if ($this->PROGRAM_ID->Required) {
            if (!$this->PROGRAM_ID->IsDetailKey && EmptyValue($this->PROGRAM_ID->FormValue)) {
                $this->PROGRAM_ID->addErrorMessage(str_replace("%s", $this->PROGRAM_ID->caption(), $this->PROGRAM_ID->RequiredErrorMessage));
            }
        }
        if ($this->PROGRAMS->Required) {
            if (!$this->PROGRAMS->IsDetailKey && EmptyValue($this->PROGRAMS->FormValue)) {
                $this->PROGRAMS->addErrorMessage(str_replace("%s", $this->PROGRAMS->caption(), $this->PROGRAMS->RequiredErrorMessage));
            }
        }
        if ($this->PACTIVITY_ID->Required) {
            if (!$this->PACTIVITY_ID->IsDetailKey && EmptyValue($this->PACTIVITY_ID->FormValue)) {
                $this->PACTIVITY_ID->addErrorMessage(str_replace("%s", $this->PACTIVITY_ID->caption(), $this->PACTIVITY_ID->RequiredErrorMessage));
            }
        }
        if ($this->ACTIVITY_ID->Required) {
            if (!$this->ACTIVITY_ID->IsDetailKey && EmptyValue($this->ACTIVITY_ID->FormValue)) {
                $this->ACTIVITY_ID->addErrorMessage(str_replace("%s", $this->ACTIVITY_ID->caption(), $this->ACTIVITY_ID->RequiredErrorMessage));
            }
        }
        if ($this->ACTIVITY_NAME->Required) {
            if (!$this->ACTIVITY_NAME->IsDetailKey && EmptyValue($this->ACTIVITY_NAME->FormValue)) {
                $this->ACTIVITY_NAME->addErrorMessage(str_replace("%s", $this->ACTIVITY_NAME->caption(), $this->ACTIVITY_NAME->RequiredErrorMessage));
            }
        }
        if ($this->KEPERLUAN->Required) {
            if (!$this->KEPERLUAN->IsDetailKey && EmptyValue($this->KEPERLUAN->FormValue)) {
                $this->KEPERLUAN->addErrorMessage(str_replace("%s", $this->KEPERLUAN->caption(), $this->KEPERLUAN->RequiredErrorMessage));
            }
        }
        if ($this->PPTK->Required) {
            if (!$this->PPTK->IsDetailKey && EmptyValue($this->PPTK->FormValue)) {
                $this->PPTK->addErrorMessage(str_replace("%s", $this->PPTK->caption(), $this->PPTK->RequiredErrorMessage));
            }
        }
        if ($this->PPTK_NAME->Required) {
            if (!$this->PPTK_NAME->IsDetailKey && EmptyValue($this->PPTK_NAME->FormValue)) {
                $this->PPTK_NAME->addErrorMessage(str_replace("%s", $this->PPTK_NAME->caption(), $this->PPTK_NAME->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_ID->Required) {
            if (!$this->COMPANY_ID->IsDetailKey && EmptyValue($this->COMPANY_ID->FormValue)) {
                $this->COMPANY_ID->addErrorMessage(str_replace("%s", $this->COMPANY_ID->caption(), $this->COMPANY_ID->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_TO->Required) {
            if (!$this->COMPANY_TO->IsDetailKey && EmptyValue($this->COMPANY_TO->FormValue)) {
                $this->COMPANY_TO->addErrorMessage(str_replace("%s", $this->COMPANY_TO->caption(), $this->COMPANY_TO->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_TYPE->Required) {
            if (!$this->COMPANY_TYPE->IsDetailKey && EmptyValue($this->COMPANY_TYPE->FormValue)) {
                $this->COMPANY_TYPE->addErrorMessage(str_replace("%s", $this->COMPANY_TYPE->caption(), $this->COMPANY_TYPE->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY->Required) {
            if (!$this->COMPANY->IsDetailKey && EmptyValue($this->COMPANY->FormValue)) {
                $this->COMPANY->addErrorMessage(str_replace("%s", $this->COMPANY->caption(), $this->COMPANY->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_CHIEF->Required) {
            if (!$this->COMPANY_CHIEF->IsDetailKey && EmptyValue($this->COMPANY_CHIEF->FormValue)) {
                $this->COMPANY_CHIEF->addErrorMessage(str_replace("%s", $this->COMPANY_CHIEF->caption(), $this->COMPANY_CHIEF->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_INFO->Required) {
            if (!$this->COMPANY_INFO->IsDetailKey && EmptyValue($this->COMPANY_INFO->FormValue)) {
                $this->COMPANY_INFO->addErrorMessage(str_replace("%s", $this->COMPANY_INFO->caption(), $this->COMPANY_INFO->RequiredErrorMessage));
            }
        }
        if ($this->CONTRACT_NO->Required) {
            if (!$this->CONTRACT_NO->IsDetailKey && EmptyValue($this->CONTRACT_NO->FormValue)) {
                $this->CONTRACT_NO->addErrorMessage(str_replace("%s", $this->CONTRACT_NO->caption(), $this->CONTRACT_NO->RequiredErrorMessage));
            }
        }
        if ($this->NPWP->Required) {
            if (!$this->NPWP->IsDetailKey && EmptyValue($this->NPWP->FormValue)) {
                $this->NPWP->addErrorMessage(str_replace("%s", $this->NPWP->caption(), $this->NPWP->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_BANK->Required) {
            if (!$this->COMPANY_BANK->IsDetailKey && EmptyValue($this->COMPANY_BANK->FormValue)) {
                $this->COMPANY_BANK->addErrorMessage(str_replace("%s", $this->COMPANY_BANK->caption(), $this->COMPANY_BANK->RequiredErrorMessage));
            }
        }
        if ($this->COMPANY_ACCOUNT->Required) {
            if (!$this->COMPANY_ACCOUNT->IsDetailKey && EmptyValue($this->COMPANY_ACCOUNT->FormValue)) {
                $this->COMPANY_ACCOUNT->addErrorMessage(str_replace("%s", $this->COMPANY_ACCOUNT->caption(), $this->COMPANY_ACCOUNT->RequiredErrorMessage));
            }
        }
        if ($this->PAGU->Required) {
            if (!$this->PAGU->IsDetailKey && EmptyValue($this->PAGU->FormValue)) {
                $this->PAGU->addErrorMessage(str_replace("%s", $this->PAGU->caption(), $this->PAGU->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PAGU->FormValue)) {
            $this->PAGU->addErrorMessage($this->PAGU->getErrorMessage(false));
        }
        if ($this->PAGU_REALISASI->Required) {
            if (!$this->PAGU_REALISASI->IsDetailKey && EmptyValue($this->PAGU_REALISASI->FormValue)) {
                $this->PAGU_REALISASI->addErrorMessage(str_replace("%s", $this->PAGU_REALISASI->caption(), $this->PAGU_REALISASI->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->PAGU_REALISASI->FormValue)) {
            $this->PAGU_REALISASI->addErrorMessage($this->PAGU_REALISASI->getErrorMessage(false));
        }
        if ($this->AMOUNT->Required) {
            if (!$this->AMOUNT->IsDetailKey && EmptyValue($this->AMOUNT->FormValue)) {
                $this->AMOUNT->addErrorMessage(str_replace("%s", $this->AMOUNT->caption(), $this->AMOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT->FormValue)) {
            $this->AMOUNT->addErrorMessage($this->AMOUNT->getErrorMessage(false));
        }
        if ($this->AMOUNT_PAID->Required) {
            if (!$this->AMOUNT_PAID->IsDetailKey && EmptyValue($this->AMOUNT_PAID->FormValue)) {
                $this->AMOUNT_PAID->addErrorMessage(str_replace("%s", $this->AMOUNT_PAID->caption(), $this->AMOUNT_PAID->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT_PAID->FormValue)) {
            $this->AMOUNT_PAID->addErrorMessage($this->AMOUNT_PAID->getErrorMessage(false));
        }
        if ($this->PAYMENT_INSTRUCTIONS->Required) {
            if (!$this->PAYMENT_INSTRUCTIONS->IsDetailKey && EmptyValue($this->PAYMENT_INSTRUCTIONS->FormValue)) {
                $this->PAYMENT_INSTRUCTIONS->addErrorMessage(str_replace("%s", $this->PAYMENT_INSTRUCTIONS->caption(), $this->PAYMENT_INSTRUCTIONS->RequiredErrorMessage));
            }
        }
        if ($this->ISAPPROVED->Required) {
            if (!$this->ISAPPROVED->IsDetailKey && EmptyValue($this->ISAPPROVED->FormValue)) {
                $this->ISAPPROVED->addErrorMessage(str_replace("%s", $this->ISAPPROVED->caption(), $this->ISAPPROVED->RequiredErrorMessage));
            }
        }
        if ($this->APPROVED_BY->Required) {
            if (!$this->APPROVED_BY->IsDetailKey && EmptyValue($this->APPROVED_BY->FormValue)) {
                $this->APPROVED_BY->addErrorMessage(str_replace("%s", $this->APPROVED_BY->caption(), $this->APPROVED_BY->RequiredErrorMessage));
            }
        }
        if ($this->APPROVED_DATE->Required) {
            if (!$this->APPROVED_DATE->IsDetailKey && EmptyValue($this->APPROVED_DATE->FormValue)) {
                $this->APPROVED_DATE->addErrorMessage(str_replace("%s", $this->APPROVED_DATE->caption(), $this->APPROVED_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->APPROVED_DATE->FormValue)) {
            $this->APPROVED_DATE->addErrorMessage($this->APPROVED_DATE->getErrorMessage(false));
        }
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
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
        if ($this->PRINT_DATE->Required) {
            if (!$this->PRINT_DATE->IsDetailKey && EmptyValue($this->PRINT_DATE->FormValue)) {
                $this->PRINT_DATE->addErrorMessage(str_replace("%s", $this->PRINT_DATE->caption(), $this->PRINT_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->PRINT_DATE->FormValue)) {
            $this->PRINT_DATE->addErrorMessage($this->PRINT_DATE->getErrorMessage(false));
        }
        if ($this->PRINTED_BY->Required) {
            if (!$this->PRINTED_BY->IsDetailKey && EmptyValue($this->PRINTED_BY->FormValue)) {
                $this->PRINTED_BY->addErrorMessage(str_replace("%s", $this->PRINTED_BY->caption(), $this->PRINTED_BY->RequiredErrorMessage));
            }
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
        if ($this->PPTK_TITLE->Required) {
            if (!$this->PPTK_TITLE->IsDetailKey && EmptyValue($this->PPTK_TITLE->FormValue)) {
                $this->PPTK_TITLE->addErrorMessage(str_replace("%s", $this->PPTK_TITLE->caption(), $this->PPTK_TITLE->RequiredErrorMessage));
            }
        }
        if ($this->APPROVED_ID->Required) {
            if (!$this->APPROVED_ID->IsDetailKey && EmptyValue($this->APPROVED_ID->FormValue)) {
                $this->APPROVED_ID->addErrorMessage(str_replace("%s", $this->APPROVED_ID->caption(), $this->APPROVED_ID->RequiredErrorMessage));
            }
        }
        if ($this->APPROVED_TITLE->Required) {
            if (!$this->APPROVED_TITLE->IsDetailKey && EmptyValue($this->APPROVED_TITLE->FormValue)) {
                $this->APPROVED_TITLE->addErrorMessage(str_replace("%s", $this->APPROVED_TITLE->caption(), $this->APPROVED_TITLE->RequiredErrorMessage));
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
            $this->ORG_UNIT_CODE->setDbValueDef($rsnew, $this->ORG_UNIT_CODE->CurrentValue, "", $this->ORG_UNIT_CODE->ReadOnly);

            // INVOICE_ID
            $this->INVOICE_ID->setDbValueDef($rsnew, $this->INVOICE_ID->CurrentValue, "", $this->INVOICE_ID->ReadOnly);

            // INVOICE_TYPE
            $this->INVOICE_TYPE->setDbValueDef($rsnew, $this->INVOICE_TYPE->CurrentValue, null, $this->INVOICE_TYPE->ReadOnly);

            // INVOICE_NO
            $this->INVOICE_NO->setDbValueDef($rsnew, $this->INVOICE_NO->CurrentValue, null, $this->INVOICE_NO->ReadOnly);

            // INV_COUNTER
            $this->INV_COUNTER->setDbValueDef($rsnew, $this->INV_COUNTER->CurrentValue, null, $this->INV_COUNTER->ReadOnly);

            // INV_DATE
            $this->INV_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->INV_DATE->CurrentValue, 0), null, $this->INV_DATE->ReadOnly);

            // INVOICE_TRANS
            $this->INVOICE_TRANS->setDbValueDef($rsnew, UnFormatDateTime($this->INVOICE_TRANS->CurrentValue, 0), null, $this->INVOICE_TRANS->ReadOnly);

            // INVOICE_DUE
            $this->INVOICE_DUE->setDbValueDef($rsnew, UnFormatDateTime($this->INVOICE_DUE->CurrentValue, 0), null, $this->INVOICE_DUE->ReadOnly);

            // REF_TYPE
            $this->REF_TYPE->setDbValueDef($rsnew, $this->REF_TYPE->CurrentValue, null, $this->REF_TYPE->ReadOnly);

            // REF_NO
            $this->REF_NO->setDbValueDef($rsnew, $this->REF_NO->CurrentValue, null, $this->REF_NO->ReadOnly);

            // REF_NO2
            $this->REF_NO2->setDbValueDef($rsnew, $this->REF_NO2->CurrentValue, null, $this->REF_NO2->ReadOnly);

            // REF_DATE
            $this->REF_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->REF_DATE->CurrentValue, 0), null, $this->REF_DATE->ReadOnly);

            // ACCOUNT_ID
            $this->ACCOUNT_ID->setDbValueDef($rsnew, $this->ACCOUNT_ID->CurrentValue, null, $this->ACCOUNT_ID->ReadOnly);

            // YEAR_ID
            $this->YEAR_ID->setDbValueDef($rsnew, $this->YEAR_ID->CurrentValue, null, $this->YEAR_ID->ReadOnly);

            // ORG_ID
            $this->ORG_ID->setDbValueDef($rsnew, $this->ORG_ID->CurrentValue, null, $this->ORG_ID->ReadOnly);

            // PROGRAM_ID
            $this->PROGRAM_ID->setDbValueDef($rsnew, $this->PROGRAM_ID->CurrentValue, null, $this->PROGRAM_ID->ReadOnly);

            // PROGRAMS
            $this->PROGRAMS->setDbValueDef($rsnew, $this->PROGRAMS->CurrentValue, null, $this->PROGRAMS->ReadOnly);

            // PACTIVITY_ID
            $this->PACTIVITY_ID->setDbValueDef($rsnew, $this->PACTIVITY_ID->CurrentValue, null, $this->PACTIVITY_ID->ReadOnly);

            // ACTIVITY_ID
            $this->ACTIVITY_ID->setDbValueDef($rsnew, $this->ACTIVITY_ID->CurrentValue, null, $this->ACTIVITY_ID->ReadOnly);

            // ACTIVITY_NAME
            $this->ACTIVITY_NAME->setDbValueDef($rsnew, $this->ACTIVITY_NAME->CurrentValue, null, $this->ACTIVITY_NAME->ReadOnly);

            // KEPERLUAN
            $this->KEPERLUAN->setDbValueDef($rsnew, $this->KEPERLUAN->CurrentValue, null, $this->KEPERLUAN->ReadOnly);

            // PPTK
            $this->PPTK->setDbValueDef($rsnew, $this->PPTK->CurrentValue, null, $this->PPTK->ReadOnly);

            // PPTK_NAME
            $this->PPTK_NAME->setDbValueDef($rsnew, $this->PPTK_NAME->CurrentValue, null, $this->PPTK_NAME->ReadOnly);

            // COMPANY_ID
            $this->COMPANY_ID->setDbValueDef($rsnew, $this->COMPANY_ID->CurrentValue, null, $this->COMPANY_ID->ReadOnly);

            // COMPANY_TO
            $this->COMPANY_TO->setDbValueDef($rsnew, $this->COMPANY_TO->CurrentValue, null, $this->COMPANY_TO->ReadOnly);

            // COMPANY_TYPE
            $this->COMPANY_TYPE->setDbValueDef($rsnew, $this->COMPANY_TYPE->CurrentValue, null, $this->COMPANY_TYPE->ReadOnly);

            // COMPANY
            $this->COMPANY->setDbValueDef($rsnew, $this->COMPANY->CurrentValue, null, $this->COMPANY->ReadOnly);

            // COMPANY_CHIEF
            $this->COMPANY_CHIEF->setDbValueDef($rsnew, $this->COMPANY_CHIEF->CurrentValue, null, $this->COMPANY_CHIEF->ReadOnly);

            // COMPANY_INFO
            $this->COMPANY_INFO->setDbValueDef($rsnew, $this->COMPANY_INFO->CurrentValue, null, $this->COMPANY_INFO->ReadOnly);

            // CONTRACT_NO
            $this->CONTRACT_NO->setDbValueDef($rsnew, $this->CONTRACT_NO->CurrentValue, null, $this->CONTRACT_NO->ReadOnly);

            // NPWP
            $this->NPWP->setDbValueDef($rsnew, $this->NPWP->CurrentValue, null, $this->NPWP->ReadOnly);

            // COMPANY_BANK
            $this->COMPANY_BANK->setDbValueDef($rsnew, $this->COMPANY_BANK->CurrentValue, null, $this->COMPANY_BANK->ReadOnly);

            // COMPANY_ACCOUNT
            $this->COMPANY_ACCOUNT->setDbValueDef($rsnew, $this->COMPANY_ACCOUNT->CurrentValue, null, $this->COMPANY_ACCOUNT->ReadOnly);

            // PAGU
            $this->PAGU->setDbValueDef($rsnew, $this->PAGU->CurrentValue, null, $this->PAGU->ReadOnly);

            // PAGU_REALISASI
            $this->PAGU_REALISASI->setDbValueDef($rsnew, $this->PAGU_REALISASI->CurrentValue, null, $this->PAGU_REALISASI->ReadOnly);

            // AMOUNT
            $this->AMOUNT->setDbValueDef($rsnew, $this->AMOUNT->CurrentValue, null, $this->AMOUNT->ReadOnly);

            // AMOUNT_PAID
            $this->AMOUNT_PAID->setDbValueDef($rsnew, $this->AMOUNT_PAID->CurrentValue, null, $this->AMOUNT_PAID->ReadOnly);

            // PAYMENT_INSTRUCTIONS
            $this->PAYMENT_INSTRUCTIONS->setDbValueDef($rsnew, $this->PAYMENT_INSTRUCTIONS->CurrentValue, null, $this->PAYMENT_INSTRUCTIONS->ReadOnly);

            // ISAPPROVED
            $this->ISAPPROVED->setDbValueDef($rsnew, $this->ISAPPROVED->CurrentValue, null, $this->ISAPPROVED->ReadOnly);

            // APPROVED_BY
            $this->APPROVED_BY->setDbValueDef($rsnew, $this->APPROVED_BY->CurrentValue, null, $this->APPROVED_BY->ReadOnly);

            // APPROVED_DATE
            $this->APPROVED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->APPROVED_DATE->CurrentValue, 0), null, $this->APPROVED_DATE->ReadOnly);

            // ISCETAK
            $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, $this->ISCETAK->ReadOnly);

            // PRINTQ
            $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, $this->PRINTQ->ReadOnly);

            // PRINT_DATE
            $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, $this->PRINT_DATE->ReadOnly);

            // PRINTED_BY
            $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, $this->PRINTED_BY->ReadOnly);

            // MODIFIED_DATE
            $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, $this->MODIFIED_DATE->ReadOnly);

            // MODIFIED_BY
            $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, $this->MODIFIED_BY->ReadOnly);

            // PPTK_TITLE
            $this->PPTK_TITLE->setDbValueDef($rsnew, $this->PPTK_TITLE->CurrentValue, null, $this->PPTK_TITLE->ReadOnly);

            // APPROVED_ID
            $this->APPROVED_ID->setDbValueDef($rsnew, $this->APPROVED_ID->CurrentValue, null, $this->APPROVED_ID->ReadOnly);

            // APPROVED_TITLE
            $this->APPROVED_TITLE->setDbValueDef($rsnew, $this->APPROVED_TITLE->CurrentValue, null, $this->APPROVED_TITLE->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("InvoiceList"), "", $this->TableVar, true);
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
