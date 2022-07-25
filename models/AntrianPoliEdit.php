<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class AntrianPoliEdit extends AntrianPoli
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'ANTRIAN_POLI';

    // Page object name
    public $PageObjName = "AntrianPoliEdit";

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

        // Table object (ANTRIAN_POLI)
        if (!isset($GLOBALS["ANTRIAN_POLI"]) || get_class($GLOBALS["ANTRIAN_POLI"]) == PROJECT_NAMESPACE . "ANTRIAN_POLI") {
            $GLOBALS["ANTRIAN_POLI"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'ANTRIAN_POLI');
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
                $doc = new $class(Container("ANTRIAN_POLI"));
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
                    if ($pageName == "AntrianPoliView") {
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
            $key .= @$ar['VISIT_ID'];
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
        $this->Id->setVisibility();
        $this->no_urut->setVisibility();
        $this->tanggal_daftar->setVisibility();
        $this->tanggal_panggil->setVisibility();
        $this->loket->setVisibility();
        $this->status_panggil->setVisibility();
        $this->NO_REGISTRATION->setVisibility();
        $this->THENAME->setVisibility();
        $this->VISIT_ID->setVisibility();
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
            if (($keyValue = Get("VISIT_ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->VISIT_ID->setQueryStringValue($keyValue);
                $this->VISIT_ID->setOldValue($this->VISIT_ID->QueryStringValue);
            } elseif (Post("VISIT_ID") !== null) {
                $this->VISIT_ID->setFormValue(Post("VISIT_ID"));
                $this->VISIT_ID->setOldValue($this->VISIT_ID->FormValue);
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
                if (($keyValue = Get("VISIT_ID") ?? Route("VISIT_ID")) !== null) {
                    $this->VISIT_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->VISIT_ID->CurrentValue = null;
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
                    $this->terminate("AntrianPoliList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "AntrianPoliList") {
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

        // Check field name 'Id' first before field var 'x_Id'
        $val = $CurrentForm->hasValue("Id") ? $CurrentForm->getValue("Id") : $CurrentForm->getValue("x_Id");
        if (!$this->Id->IsDetailKey) {
            $this->Id->setFormValue($val);
        }

        // Check field name 'no_urut' first before field var 'x_no_urut'
        $val = $CurrentForm->hasValue("no_urut") ? $CurrentForm->getValue("no_urut") : $CurrentForm->getValue("x_no_urut");
        if (!$this->no_urut->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_urut->Visible = false; // Disable update for API request
            } else {
                $this->no_urut->setFormValue($val);
            }
        }

        // Check field name 'tanggal_daftar' first before field var 'x_tanggal_daftar'
        $val = $CurrentForm->hasValue("tanggal_daftar") ? $CurrentForm->getValue("tanggal_daftar") : $CurrentForm->getValue("x_tanggal_daftar");
        if (!$this->tanggal_daftar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_daftar->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_daftar->setFormValue($val);
            }
            $this->tanggal_daftar->CurrentValue = UnFormatDateTime($this->tanggal_daftar->CurrentValue, 0);
        }

        // Check field name 'tanggal_panggil' first before field var 'x_tanggal_panggil'
        $val = $CurrentForm->hasValue("tanggal_panggil") ? $CurrentForm->getValue("tanggal_panggil") : $CurrentForm->getValue("x_tanggal_panggil");
        if (!$this->tanggal_panggil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_panggil->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_panggil->setFormValue($val);
            }
            $this->tanggal_panggil->CurrentValue = UnFormatDateTime($this->tanggal_panggil->CurrentValue, 0);
        }

        // Check field name 'loket' first before field var 'x_loket'
        $val = $CurrentForm->hasValue("loket") ? $CurrentForm->getValue("loket") : $CurrentForm->getValue("x_loket");
        if (!$this->loket->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->loket->Visible = false; // Disable update for API request
            } else {
                $this->loket->setFormValue($val);
            }
        }

        // Check field name 'status_panggil' first before field var 'x_status_panggil'
        $val = $CurrentForm->hasValue("status_panggil") ? $CurrentForm->getValue("status_panggil") : $CurrentForm->getValue("x_status_panggil");
        if (!$this->status_panggil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_panggil->Visible = false; // Disable update for API request
            } else {
                $this->status_panggil->setFormValue($val);
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

        // Check field name 'VISIT_ID' first before field var 'x_VISIT_ID'
        $val = $CurrentForm->hasValue("VISIT_ID") ? $CurrentForm->getValue("VISIT_ID") : $CurrentForm->getValue("x_VISIT_ID");
        if (!$this->VISIT_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->VISIT_ID->Visible = false; // Disable update for API request
            } else {
                $this->VISIT_ID->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_VISIT_ID")) {
            $this->VISIT_ID->setOldValue($CurrentForm->getValue("o_VISIT_ID"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Id->CurrentValue = $this->Id->FormValue;
        $this->no_urut->CurrentValue = $this->no_urut->FormValue;
        $this->tanggal_daftar->CurrentValue = $this->tanggal_daftar->FormValue;
        $this->tanggal_daftar->CurrentValue = UnFormatDateTime($this->tanggal_daftar->CurrentValue, 0);
        $this->tanggal_panggil->CurrentValue = $this->tanggal_panggil->FormValue;
        $this->tanggal_panggil->CurrentValue = UnFormatDateTime($this->tanggal_panggil->CurrentValue, 0);
        $this->loket->CurrentValue = $this->loket->FormValue;
        $this->status_panggil->CurrentValue = $this->status_panggil->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->THENAME->CurrentValue = $this->THENAME->FormValue;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
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
        $this->no_urut->setDbValue($row['no_urut']);
        $this->tanggal_daftar->setDbValue($row['tanggal_daftar']);
        $this->tanggal_panggil->setDbValue($row['tanggal_panggil']);
        $this->loket->setDbValue($row['loket']);
        $this->status_panggil->setDbValue($row['status_panggil']);
        $this->NO_REGISTRATION->setDbValue($row['NO_REGISTRATION']);
        $this->THENAME->setDbValue($row['THENAME']);
        $this->VISIT_ID->setDbValue($row['VISIT_ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Id'] = null;
        $row['no_urut'] = null;
        $row['tanggal_daftar'] = null;
        $row['tanggal_panggil'] = null;
        $row['loket'] = null;
        $row['status_panggil'] = null;
        $row['NO_REGISTRATION'] = null;
        $row['THENAME'] = null;
        $row['VISIT_ID'] = null;
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

        // no_urut

        // tanggal_daftar

        // tanggal_panggil

        // loket

        // status_panggil

        // NO_REGISTRATION

        // THENAME

        // VISIT_ID
        if ($this->RowType == ROWTYPE_VIEW) {
            // Id
            $this->Id->ViewValue = $this->Id->CurrentValue;
            $this->Id->ViewCustomAttributes = "";

            // no_urut
            $this->no_urut->ViewValue = $this->no_urut->CurrentValue;
            $this->no_urut->ViewValue = FormatNumber($this->no_urut->ViewValue, 0, -2, -2, -2);
            $this->no_urut->ViewCustomAttributes = "";

            // tanggal_daftar
            $this->tanggal_daftar->ViewValue = $this->tanggal_daftar->CurrentValue;
            $this->tanggal_daftar->ViewValue = FormatDateTime($this->tanggal_daftar->ViewValue, 0);
            $this->tanggal_daftar->ViewCustomAttributes = "";

            // tanggal_panggil
            $this->tanggal_panggil->ViewValue = $this->tanggal_panggil->CurrentValue;
            $this->tanggal_panggil->ViewValue = FormatDateTime($this->tanggal_panggil->ViewValue, 0);
            $this->tanggal_panggil->ViewCustomAttributes = "";

            // loket
            $this->loket->ViewValue = $this->loket->CurrentValue;
            $this->loket->ViewCustomAttributes = "";

            // status_panggil
            $this->status_panggil->ViewValue = $this->status_panggil->CurrentValue;
            $this->status_panggil->ViewValue = FormatNumber($this->status_panggil->ViewValue, 0, -2, -2, -2);
            $this->status_panggil->ViewCustomAttributes = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->ViewValue = $this->NO_REGISTRATION->CurrentValue;
            $this->NO_REGISTRATION->ViewCustomAttributes = "";

            // THENAME
            $this->THENAME->ViewValue = $this->THENAME->CurrentValue;
            $this->THENAME->ViewCustomAttributes = "";

            // VISIT_ID
            $this->VISIT_ID->ViewValue = $this->VISIT_ID->CurrentValue;
            $this->VISIT_ID->ViewCustomAttributes = "";

            // Id
            $this->Id->LinkCustomAttributes = "";
            $this->Id->HrefValue = "";
            $this->Id->TooltipValue = "";

            // no_urut
            $this->no_urut->LinkCustomAttributes = "";
            $this->no_urut->HrefValue = "";
            $this->no_urut->TooltipValue = "";

            // tanggal_daftar
            $this->tanggal_daftar->LinkCustomAttributes = "";
            $this->tanggal_daftar->HrefValue = "";
            $this->tanggal_daftar->TooltipValue = "";

            // tanggal_panggil
            $this->tanggal_panggil->LinkCustomAttributes = "";
            $this->tanggal_panggil->HrefValue = "";
            $this->tanggal_panggil->TooltipValue = "";

            // loket
            $this->loket->LinkCustomAttributes = "";
            $this->loket->HrefValue = "";
            $this->loket->TooltipValue = "";

            // status_panggil
            $this->status_panggil->LinkCustomAttributes = "";
            $this->status_panggil->HrefValue = "";
            $this->status_panggil->TooltipValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";
            $this->NO_REGISTRATION->TooltipValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";
            $this->THENAME->TooltipValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
            $this->VISIT_ID->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // Id
            $this->Id->EditAttrs["class"] = "form-control";
            $this->Id->EditCustomAttributes = "";
            $this->Id->EditValue = HtmlEncode($this->Id->CurrentValue);
            $this->Id->PlaceHolder = RemoveHtml($this->Id->caption());

            // no_urut
            $this->no_urut->EditAttrs["class"] = "form-control";
            $this->no_urut->EditCustomAttributes = "";
            $this->no_urut->EditValue = HtmlEncode($this->no_urut->CurrentValue);
            $this->no_urut->PlaceHolder = RemoveHtml($this->no_urut->caption());

            // tanggal_daftar
            $this->tanggal_daftar->EditAttrs["class"] = "form-control";
            $this->tanggal_daftar->EditCustomAttributes = "";
            $this->tanggal_daftar->EditValue = HtmlEncode(FormatDateTime($this->tanggal_daftar->CurrentValue, 8));
            $this->tanggal_daftar->PlaceHolder = RemoveHtml($this->tanggal_daftar->caption());

            // tanggal_panggil
            $this->tanggal_panggil->EditAttrs["class"] = "form-control";
            $this->tanggal_panggil->EditCustomAttributes = "";
            $this->tanggal_panggil->EditValue = HtmlEncode(FormatDateTime($this->tanggal_panggil->CurrentValue, 8));
            $this->tanggal_panggil->PlaceHolder = RemoveHtml($this->tanggal_panggil->caption());

            // loket
            $this->loket->EditAttrs["class"] = "form-control";
            $this->loket->EditCustomAttributes = "";
            if (!$this->loket->Raw) {
                $this->loket->CurrentValue = HtmlDecode($this->loket->CurrentValue);
            }
            $this->loket->EditValue = HtmlEncode($this->loket->CurrentValue);
            $this->loket->PlaceHolder = RemoveHtml($this->loket->caption());

            // status_panggil
            $this->status_panggil->EditAttrs["class"] = "form-control";
            $this->status_panggil->EditCustomAttributes = "";
            $this->status_panggil->EditValue = HtmlEncode($this->status_panggil->CurrentValue);
            $this->status_panggil->PlaceHolder = RemoveHtml($this->status_panggil->caption());

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION->Raw) {
                $this->NO_REGISTRATION->CurrentValue = HtmlDecode($this->NO_REGISTRATION->CurrentValue);
            }
            $this->NO_REGISTRATION->EditValue = HtmlEncode($this->NO_REGISTRATION->CurrentValue);
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

            // THENAME
            $this->THENAME->EditAttrs["class"] = "form-control";
            $this->THENAME->EditCustomAttributes = "";
            if (!$this->THENAME->Raw) {
                $this->THENAME->CurrentValue = HtmlDecode($this->THENAME->CurrentValue);
            }
            $this->THENAME->EditValue = HtmlEncode($this->THENAME->CurrentValue);
            $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if (!$this->VISIT_ID->Raw) {
                $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
            }
            $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
            $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());

            // Edit refer script

            // Id
            $this->Id->LinkCustomAttributes = "";
            $this->Id->HrefValue = "";

            // no_urut
            $this->no_urut->LinkCustomAttributes = "";
            $this->no_urut->HrefValue = "";

            // tanggal_daftar
            $this->tanggal_daftar->LinkCustomAttributes = "";
            $this->tanggal_daftar->HrefValue = "";

            // tanggal_panggil
            $this->tanggal_panggil->LinkCustomAttributes = "";
            $this->tanggal_panggil->HrefValue = "";

            // loket
            $this->loket->LinkCustomAttributes = "";
            $this->loket->HrefValue = "";

            // status_panggil
            $this->status_panggil->LinkCustomAttributes = "";
            $this->status_panggil->HrefValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";
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
        if ($this->Id->Required) {
            if (!$this->Id->IsDetailKey && EmptyValue($this->Id->FormValue)) {
                $this->Id->addErrorMessage(str_replace("%s", $this->Id->caption(), $this->Id->RequiredErrorMessage));
            }
        }
        if ($this->no_urut->Required) {
            if (!$this->no_urut->IsDetailKey && EmptyValue($this->no_urut->FormValue)) {
                $this->no_urut->addErrorMessage(str_replace("%s", $this->no_urut->caption(), $this->no_urut->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->no_urut->FormValue)) {
            $this->no_urut->addErrorMessage($this->no_urut->getErrorMessage(false));
        }
        if ($this->tanggal_daftar->Required) {
            if (!$this->tanggal_daftar->IsDetailKey && EmptyValue($this->tanggal_daftar->FormValue)) {
                $this->tanggal_daftar->addErrorMessage(str_replace("%s", $this->tanggal_daftar->caption(), $this->tanggal_daftar->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_daftar->FormValue)) {
            $this->tanggal_daftar->addErrorMessage($this->tanggal_daftar->getErrorMessage(false));
        }
        if ($this->tanggal_panggil->Required) {
            if (!$this->tanggal_panggil->IsDetailKey && EmptyValue($this->tanggal_panggil->FormValue)) {
                $this->tanggal_panggil->addErrorMessage(str_replace("%s", $this->tanggal_panggil->caption(), $this->tanggal_panggil->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_panggil->FormValue)) {
            $this->tanggal_panggil->addErrorMessage($this->tanggal_panggil->getErrorMessage(false));
        }
        if ($this->loket->Required) {
            if (!$this->loket->IsDetailKey && EmptyValue($this->loket->FormValue)) {
                $this->loket->addErrorMessage(str_replace("%s", $this->loket->caption(), $this->loket->RequiredErrorMessage));
            }
        }
        if ($this->status_panggil->Required) {
            if (!$this->status_panggil->IsDetailKey && EmptyValue($this->status_panggil->FormValue)) {
                $this->status_panggil->addErrorMessage(str_replace("%s", $this->status_panggil->caption(), $this->status_panggil->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->status_panggil->FormValue)) {
            $this->status_panggil->addErrorMessage($this->status_panggil->getErrorMessage(false));
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
        if ($this->VISIT_ID->Required) {
            if (!$this->VISIT_ID->IsDetailKey && EmptyValue($this->VISIT_ID->FormValue)) {
                $this->VISIT_ID->addErrorMessage(str_replace("%s", $this->VISIT_ID->caption(), $this->VISIT_ID->RequiredErrorMessage));
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

            // no_urut
            $this->no_urut->setDbValueDef($rsnew, $this->no_urut->CurrentValue, null, $this->no_urut->ReadOnly);

            // tanggal_daftar
            $this->tanggal_daftar->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_daftar->CurrentValue, 0), null, $this->tanggal_daftar->ReadOnly);

            // tanggal_panggil
            $this->tanggal_panggil->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_panggil->CurrentValue, 0), null, $this->tanggal_panggil->ReadOnly);

            // loket
            $this->loket->setDbValueDef($rsnew, $this->loket->CurrentValue, null, $this->loket->ReadOnly);

            // status_panggil
            $this->status_panggil->setDbValueDef($rsnew, $this->status_panggil->CurrentValue, null, $this->status_panggil->ReadOnly);

            // NO_REGISTRATION
            $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, null, $this->NO_REGISTRATION->ReadOnly);

            // THENAME
            $this->THENAME->setDbValueDef($rsnew, $this->THENAME->CurrentValue, null, $this->THENAME->ReadOnly);

            // VISIT_ID
            $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, "", $this->VISIT_ID->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AntrianPoliList"), "", $this->TableVar, true);
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
