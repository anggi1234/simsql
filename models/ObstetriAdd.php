<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ObstetriAdd extends Obstetri
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'OBSTETRI';

    // Page object name
    public $PageObjName = "ObstetriAdd";

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

        // Table object (OBSTETRI)
        if (!isset($GLOBALS["OBSTETRI"]) || get_class($GLOBALS["OBSTETRI"]) == PROJECT_NAMESPACE . "OBSTETRI") {
            $GLOBALS["OBSTETRI"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "ObstetriView") {
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
                    $this->terminate("ObstetriList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->GetViewUrl();
                    if (GetPageName($returnUrl) == "ObstetriList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ObstetriView") {
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
        $this->ORG_UNIT_CODE->CurrentValue = null;
        $this->ORG_UNIT_CODE->OldValue = $this->ORG_UNIT_CODE->CurrentValue;
        $this->OBSTETRI_ID->CurrentValue = null;
        $this->OBSTETRI_ID->OldValue = $this->OBSTETRI_ID->CurrentValue;
        $this->HPHT->CurrentValue = null;
        $this->HPHT->OldValue = $this->HPHT->CurrentValue;
        $this->HTP->CurrentValue = null;
        $this->HTP->OldValue = $this->HTP->CurrentValue;
        $this->PASIEN_DIAGNOSA_ID->CurrentValue = null;
        $this->PASIEN_DIAGNOSA_ID->OldValue = $this->PASIEN_DIAGNOSA_ID->CurrentValue;
        $this->DIAGNOSA_ID->CurrentValue = null;
        $this->DIAGNOSA_ID->OldValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->NO_REGISTRATION->CurrentValue = null;
        $this->NO_REGISTRATION->OldValue = $this->NO_REGISTRATION->CurrentValue;
        $this->KOHORT_NB->CurrentValue = null;
        $this->KOHORT_NB->OldValue = $this->KOHORT_NB->CurrentValue;
        $this->BIRTH_NB->CurrentValue = null;
        $this->BIRTH_NB->OldValue = $this->BIRTH_NB->CurrentValue;
        $this->BIRTH_DURATION->CurrentValue = null;
        $this->BIRTH_DURATION->OldValue = $this->BIRTH_DURATION->CurrentValue;
        $this->BIRTH_PLACE->CurrentValue = null;
        $this->BIRTH_PLACE->OldValue = $this->BIRTH_PLACE->CurrentValue;
        $this->ANTE_NATAL->CurrentValue = null;
        $this->ANTE_NATAL->OldValue = $this->ANTE_NATAL->CurrentValue;
        $this->EMPLOYEE_ID->CurrentValue = null;
        $this->EMPLOYEE_ID->OldValue = $this->EMPLOYEE_ID->CurrentValue;
        $this->CLINIC_ID->CurrentValue = null;
        $this->CLINIC_ID->OldValue = $this->CLINIC_ID->CurrentValue;
        $this->BIRTH_WAY->CurrentValue = null;
        $this->BIRTH_WAY->OldValue = $this->BIRTH_WAY->CurrentValue;
        $this->BIRTH_BY->CurrentValue = null;
        $this->BIRTH_BY->OldValue = $this->BIRTH_BY->CurrentValue;
        $this->BIRTH_DATE->CurrentValue = null;
        $this->BIRTH_DATE->OldValue = $this->BIRTH_DATE->CurrentValue;
        $this->GESTASI->CurrentValue = null;
        $this->GESTASI->OldValue = $this->GESTASI->CurrentValue;
        $this->PARITY->CurrentValue = null;
        $this->PARITY->OldValue = $this->PARITY->CurrentValue;
        $this->NB_BABY->CurrentValue = null;
        $this->NB_BABY->OldValue = $this->NB_BABY->CurrentValue;
        $this->BABY_DIE->CurrentValue = null;
        $this->BABY_DIE->OldValue = $this->BABY_DIE->CurrentValue;
        $this->ABORTUS_KE->CurrentValue = null;
        $this->ABORTUS_KE->OldValue = $this->ABORTUS_KE->CurrentValue;
        $this->ABORTUS_ID->CurrentValue = null;
        $this->ABORTUS_ID->OldValue = $this->ABORTUS_ID->CurrentValue;
        $this->ABORTION_DATE->CurrentValue = null;
        $this->ABORTION_DATE->OldValue = $this->ABORTION_DATE->CurrentValue;
        $this->BIRTH_CAT->CurrentValue = null;
        $this->BIRTH_CAT->OldValue = $this->BIRTH_CAT->CurrentValue;
        $this->BIRTH_CON->CurrentValue = null;
        $this->BIRTH_CON->OldValue = $this->BIRTH_CON->CurrentValue;
        $this->BIRTH_RISK->CurrentValue = null;
        $this->BIRTH_RISK->OldValue = $this->BIRTH_RISK->CurrentValue;
        $this->RISK_TYPE->CurrentValue = null;
        $this->RISK_TYPE->OldValue = $this->RISK_TYPE->CurrentValue;
        $this->FOLLOW_UP->CurrentValue = null;
        $this->FOLLOW_UP->OldValue = $this->FOLLOW_UP->CurrentValue;
        $this->DIRUJUK_OLEH->CurrentValue = null;
        $this->DIRUJUK_OLEH->OldValue = $this->DIRUJUK_OLEH->CurrentValue;
        $this->INSPECTION_DATE->CurrentValue = null;
        $this->INSPECTION_DATE->OldValue = $this->INSPECTION_DATE->CurrentValue;
        $this->PORSIO->CurrentValue = null;
        $this->PORSIO->OldValue = $this->PORSIO->CurrentValue;
        $this->PEMBUKAAN->CurrentValue = null;
        $this->PEMBUKAAN->OldValue = $this->PEMBUKAAN->CurrentValue;
        $this->KETUBAN->CurrentValue = null;
        $this->KETUBAN->OldValue = $this->KETUBAN->CurrentValue;
        $this->PRESENTASI->CurrentValue = null;
        $this->PRESENTASI->OldValue = $this->PRESENTASI->CurrentValue;
        $this->POSISI->CurrentValue = null;
        $this->POSISI->OldValue = $this->POSISI->CurrentValue;
        $this->PENURUNAN->CurrentValue = null;
        $this->PENURUNAN->OldValue = $this->PENURUNAN->CurrentValue;
        $this->HEART_ID->CurrentValue = null;
        $this->HEART_ID->OldValue = $this->HEART_ID->CurrentValue;
        $this->JANIN_ID->CurrentValue = null;
        $this->JANIN_ID->OldValue = $this->JANIN_ID->CurrentValue;
        $this->FREK_DJJ->CurrentValue = null;
        $this->FREK_DJJ->OldValue = $this->FREK_DJJ->CurrentValue;
        $this->PLACENTA->CurrentValue = null;
        $this->PLACENTA->OldValue = $this->PLACENTA->CurrentValue;
        $this->LOCHIA->CurrentValue = null;
        $this->LOCHIA->OldValue = $this->LOCHIA->CurrentValue;
        $this->BAB_TYPE->CurrentValue = null;
        $this->BAB_TYPE->OldValue = $this->BAB_TYPE->CurrentValue;
        $this->BAB_BAB_TYPE->CurrentValue = null;
        $this->BAB_BAB_TYPE->OldValue = $this->BAB_BAB_TYPE->CurrentValue;
        $this->RAHIM_ID->CurrentValue = null;
        $this->RAHIM_ID->OldValue = $this->RAHIM_ID->CurrentValue;
        $this->BIR_RAHIM_ID->CurrentValue = null;
        $this->BIR_RAHIM_ID->OldValue = $this->BIR_RAHIM_ID->CurrentValue;
        $this->VISIT_ID->CurrentValue = null;
        $this->VISIT_ID->OldValue = $this->VISIT_ID->CurrentValue;
        $this->BLOODING->CurrentValue = null;
        $this->BLOODING->OldValue = $this->BLOODING->CurrentValue;
        $this->DESCRIPTION->CurrentValue = null;
        $this->DESCRIPTION->OldValue = $this->DESCRIPTION->CurrentValue;
        $this->MODIFIED_DATE->CurrentValue = null;
        $this->MODIFIED_DATE->OldValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_BY->CurrentValue = null;
        $this->MODIFIED_BY->OldValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_FROM->CurrentValue = null;
        $this->MODIFIED_FROM->OldValue = $this->MODIFIED_FROM->CurrentValue;
        $this->RAHIM_SALIN->CurrentValue = null;
        $this->RAHIM_SALIN->OldValue = $this->RAHIM_SALIN->CurrentValue;
        $this->RAHIM_NIFAS->CurrentValue = null;
        $this->RAHIM_NIFAS->OldValue = $this->RAHIM_NIFAS->CurrentValue;
        $this->BAK_TYPE->CurrentValue = null;
        $this->BAK_TYPE->OldValue = $this->BAK_TYPE->CurrentValue;
        $this->THENAME->CurrentValue = null;
        $this->THENAME->OldValue = $this->THENAME->CurrentValue;
        $this->THEADDRESS->CurrentValue = null;
        $this->THEADDRESS->OldValue = $this->THEADDRESS->CurrentValue;
        $this->THEID->CurrentValue = null;
        $this->THEID->OldValue = $this->THEID->CurrentValue;
        $this->STATUS_PASIEN_ID->CurrentValue = null;
        $this->STATUS_PASIEN_ID->OldValue = $this->STATUS_PASIEN_ID->CurrentValue;
        $this->ISRJ->CurrentValue = null;
        $this->ISRJ->OldValue = $this->ISRJ->CurrentValue;
        $this->AGEYEAR->CurrentValue = null;
        $this->AGEYEAR->OldValue = $this->AGEYEAR->CurrentValue;
        $this->AGEMONTH->CurrentValue = null;
        $this->AGEMONTH->OldValue = $this->AGEMONTH->CurrentValue;
        $this->AGEDAY->CurrentValue = null;
        $this->AGEDAY->OldValue = $this->AGEDAY->CurrentValue;
        $this->GENDER->CurrentValue = "2";
        $this->CLASS_ROOM_ID->CurrentValue = null;
        $this->CLASS_ROOM_ID->OldValue = $this->CLASS_ROOM_ID->CurrentValue;
        $this->BED_ID->CurrentValue = null;
        $this->BED_ID->OldValue = $this->BED_ID->CurrentValue;
        $this->KELUAR_ID->CurrentValue = null;
        $this->KELUAR_ID->OldValue = $this->KELUAR_ID->CurrentValue;
        $this->DOCTOR->CurrentValue = null;
        $this->DOCTOR->OldValue = $this->DOCTOR->CurrentValue;
        $this->NB_OBSTETRI->CurrentValue = 1;
        $this->OBSTETRI_DIE->CurrentValue = 0;
        $this->KAL_ID->CurrentValue = null;
        $this->KAL_ID->OldValue = $this->KAL_ID->CurrentValue;
        $this->DIAGNOSA_ID2->CurrentValue = null;
        $this->DIAGNOSA_ID2->OldValue = $this->DIAGNOSA_ID2->CurrentValue;
        $this->APGAR_ID->CurrentValue = null;
        $this->APGAR_ID->OldValue = $this->APGAR_ID->CurrentValue;
        $this->BIRTH_LAST_ID->CurrentValue = null;
        $this->BIRTH_LAST_ID->OldValue = $this->BIRTH_LAST_ID->CurrentValue;
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'OBSTETRI_ID' first before field var 'x_OBSTETRI_ID'
        $val = $CurrentForm->hasValue("OBSTETRI_ID") ? $CurrentForm->getValue("OBSTETRI_ID") : $CurrentForm->getValue("x_OBSTETRI_ID");
        if (!$this->OBSTETRI_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->OBSTETRI_ID->Visible = false; // Disable update for API request
            } else {
                $this->OBSTETRI_ID->setFormValue($val);
            }
        }

        // Check field name 'HPHT' first before field var 'x_HPHT'
        $val = $CurrentForm->hasValue("HPHT") ? $CurrentForm->getValue("HPHT") : $CurrentForm->getValue("x_HPHT");
        if (!$this->HPHT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->HPHT->Visible = false; // Disable update for API request
            } else {
                $this->HPHT->setFormValue($val);
            }
            $this->HPHT->CurrentValue = UnFormatDateTime($this->HPHT->CurrentValue, 0);
        }

        // Check field name 'HTP' first before field var 'x_HTP'
        $val = $CurrentForm->hasValue("HTP") ? $CurrentForm->getValue("HTP") : $CurrentForm->getValue("x_HTP");
        if (!$this->HTP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->HTP->Visible = false; // Disable update for API request
            } else {
                $this->HTP->setFormValue($val);
            }
            $this->HTP->CurrentValue = UnFormatDateTime($this->HTP->CurrentValue, 0);
        }

        // Check field name 'PASIEN_DIAGNOSA_ID' first before field var 'x_PASIEN_DIAGNOSA_ID'
        $val = $CurrentForm->hasValue("PASIEN_DIAGNOSA_ID") ? $CurrentForm->getValue("PASIEN_DIAGNOSA_ID") : $CurrentForm->getValue("x_PASIEN_DIAGNOSA_ID");
        if (!$this->PASIEN_DIAGNOSA_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PASIEN_DIAGNOSA_ID->Visible = false; // Disable update for API request
            } else {
                $this->PASIEN_DIAGNOSA_ID->setFormValue($val);
            }
        }

        // Check field name 'DIAGNOSA_ID' first before field var 'x_DIAGNOSA_ID'
        $val = $CurrentForm->hasValue("DIAGNOSA_ID") ? $CurrentForm->getValue("DIAGNOSA_ID") : $CurrentForm->getValue("x_DIAGNOSA_ID");
        if (!$this->DIAGNOSA_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIAGNOSA_ID->Visible = false; // Disable update for API request
            } else {
                $this->DIAGNOSA_ID->setFormValue($val);
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

        // Check field name 'KOHORT_NB' first before field var 'x_KOHORT_NB'
        $val = $CurrentForm->hasValue("KOHORT_NB") ? $CurrentForm->getValue("KOHORT_NB") : $CurrentForm->getValue("x_KOHORT_NB");
        if (!$this->KOHORT_NB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KOHORT_NB->Visible = false; // Disable update for API request
            } else {
                $this->KOHORT_NB->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_NB' first before field var 'x_BIRTH_NB'
        $val = $CurrentForm->hasValue("BIRTH_NB") ? $CurrentForm->getValue("BIRTH_NB") : $CurrentForm->getValue("x_BIRTH_NB");
        if (!$this->BIRTH_NB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_NB->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_NB->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_DURATION' first before field var 'x_BIRTH_DURATION'
        $val = $CurrentForm->hasValue("BIRTH_DURATION") ? $CurrentForm->getValue("BIRTH_DURATION") : $CurrentForm->getValue("x_BIRTH_DURATION");
        if (!$this->BIRTH_DURATION->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_DURATION->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_DURATION->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_PLACE' first before field var 'x_BIRTH_PLACE'
        $val = $CurrentForm->hasValue("BIRTH_PLACE") ? $CurrentForm->getValue("BIRTH_PLACE") : $CurrentForm->getValue("x_BIRTH_PLACE");
        if (!$this->BIRTH_PLACE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_PLACE->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_PLACE->setFormValue($val);
            }
        }

        // Check field name 'ANTE_NATAL' first before field var 'x_ANTE_NATAL'
        $val = $CurrentForm->hasValue("ANTE_NATAL") ? $CurrentForm->getValue("ANTE_NATAL") : $CurrentForm->getValue("x_ANTE_NATAL");
        if (!$this->ANTE_NATAL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ANTE_NATAL->Visible = false; // Disable update for API request
            } else {
                $this->ANTE_NATAL->setFormValue($val);
            }
        }

        // Check field name 'EMPLOYEE_ID' first before field var 'x_EMPLOYEE_ID'
        $val = $CurrentForm->hasValue("EMPLOYEE_ID") ? $CurrentForm->getValue("EMPLOYEE_ID") : $CurrentForm->getValue("x_EMPLOYEE_ID");
        if (!$this->EMPLOYEE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EMPLOYEE_ID->Visible = false; // Disable update for API request
            } else {
                $this->EMPLOYEE_ID->setFormValue($val);
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

        // Check field name 'BIRTH_WAY' first before field var 'x_BIRTH_WAY'
        $val = $CurrentForm->hasValue("BIRTH_WAY") ? $CurrentForm->getValue("BIRTH_WAY") : $CurrentForm->getValue("x_BIRTH_WAY");
        if (!$this->BIRTH_WAY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_WAY->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_WAY->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_BY' first before field var 'x_BIRTH_BY'
        $val = $CurrentForm->hasValue("BIRTH_BY") ? $CurrentForm->getValue("BIRTH_BY") : $CurrentForm->getValue("x_BIRTH_BY");
        if (!$this->BIRTH_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_BY->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_BY->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_DATE' first before field var 'x_BIRTH_DATE'
        $val = $CurrentForm->hasValue("BIRTH_DATE") ? $CurrentForm->getValue("BIRTH_DATE") : $CurrentForm->getValue("x_BIRTH_DATE");
        if (!$this->BIRTH_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_DATE->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_DATE->setFormValue($val);
            }
            $this->BIRTH_DATE->CurrentValue = UnFormatDateTime($this->BIRTH_DATE->CurrentValue, 0);
        }

        // Check field name 'GESTASI' first before field var 'x_GESTASI'
        $val = $CurrentForm->hasValue("GESTASI") ? $CurrentForm->getValue("GESTASI") : $CurrentForm->getValue("x_GESTASI");
        if (!$this->GESTASI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GESTASI->Visible = false; // Disable update for API request
            } else {
                $this->GESTASI->setFormValue($val);
            }
        }

        // Check field name 'PARITY' first before field var 'x_PARITY'
        $val = $CurrentForm->hasValue("PARITY") ? $CurrentForm->getValue("PARITY") : $CurrentForm->getValue("x_PARITY");
        if (!$this->PARITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PARITY->Visible = false; // Disable update for API request
            } else {
                $this->PARITY->setFormValue($val);
            }
        }

        // Check field name 'NB_BABY' first before field var 'x_NB_BABY'
        $val = $CurrentForm->hasValue("NB_BABY") ? $CurrentForm->getValue("NB_BABY") : $CurrentForm->getValue("x_NB_BABY");
        if (!$this->NB_BABY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NB_BABY->Visible = false; // Disable update for API request
            } else {
                $this->NB_BABY->setFormValue($val);
            }
        }

        // Check field name 'BABY_DIE' first before field var 'x_BABY_DIE'
        $val = $CurrentForm->hasValue("BABY_DIE") ? $CurrentForm->getValue("BABY_DIE") : $CurrentForm->getValue("x_BABY_DIE");
        if (!$this->BABY_DIE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BABY_DIE->Visible = false; // Disable update for API request
            } else {
                $this->BABY_DIE->setFormValue($val);
            }
        }

        // Check field name 'ABORTUS_KE' first before field var 'x_ABORTUS_KE'
        $val = $CurrentForm->hasValue("ABORTUS_KE") ? $CurrentForm->getValue("ABORTUS_KE") : $CurrentForm->getValue("x_ABORTUS_KE");
        if (!$this->ABORTUS_KE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ABORTUS_KE->Visible = false; // Disable update for API request
            } else {
                $this->ABORTUS_KE->setFormValue($val);
            }
        }

        // Check field name 'ABORTUS_ID' first before field var 'x_ABORTUS_ID'
        $val = $CurrentForm->hasValue("ABORTUS_ID") ? $CurrentForm->getValue("ABORTUS_ID") : $CurrentForm->getValue("x_ABORTUS_ID");
        if (!$this->ABORTUS_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ABORTUS_ID->Visible = false; // Disable update for API request
            } else {
                $this->ABORTUS_ID->setFormValue($val);
            }
        }

        // Check field name 'ABORTION_DATE' first before field var 'x_ABORTION_DATE'
        $val = $CurrentForm->hasValue("ABORTION_DATE") ? $CurrentForm->getValue("ABORTION_DATE") : $CurrentForm->getValue("x_ABORTION_DATE");
        if (!$this->ABORTION_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ABORTION_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ABORTION_DATE->setFormValue($val);
            }
            $this->ABORTION_DATE->CurrentValue = UnFormatDateTime($this->ABORTION_DATE->CurrentValue, 0);
        }

        // Check field name 'BIRTH_CAT' first before field var 'x_BIRTH_CAT'
        $val = $CurrentForm->hasValue("BIRTH_CAT") ? $CurrentForm->getValue("BIRTH_CAT") : $CurrentForm->getValue("x_BIRTH_CAT");
        if (!$this->BIRTH_CAT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_CAT->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_CAT->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_CON' first before field var 'x_BIRTH_CON'
        $val = $CurrentForm->hasValue("BIRTH_CON") ? $CurrentForm->getValue("BIRTH_CON") : $CurrentForm->getValue("x_BIRTH_CON");
        if (!$this->BIRTH_CON->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_CON->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_CON->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_RISK' first before field var 'x_BIRTH_RISK'
        $val = $CurrentForm->hasValue("BIRTH_RISK") ? $CurrentForm->getValue("BIRTH_RISK") : $CurrentForm->getValue("x_BIRTH_RISK");
        if (!$this->BIRTH_RISK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_RISK->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_RISK->setFormValue($val);
            }
        }

        // Check field name 'RISK_TYPE' first before field var 'x_RISK_TYPE'
        $val = $CurrentForm->hasValue("RISK_TYPE") ? $CurrentForm->getValue("RISK_TYPE") : $CurrentForm->getValue("x_RISK_TYPE");
        if (!$this->RISK_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RISK_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->RISK_TYPE->setFormValue($val);
            }
        }

        // Check field name 'FOLLOW_UP' first before field var 'x_FOLLOW_UP'
        $val = $CurrentForm->hasValue("FOLLOW_UP") ? $CurrentForm->getValue("FOLLOW_UP") : $CurrentForm->getValue("x_FOLLOW_UP");
        if (!$this->FOLLOW_UP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FOLLOW_UP->Visible = false; // Disable update for API request
            } else {
                $this->FOLLOW_UP->setFormValue($val);
            }
        }

        // Check field name 'DIRUJUK_OLEH' first before field var 'x_DIRUJUK_OLEH'
        $val = $CurrentForm->hasValue("DIRUJUK_OLEH") ? $CurrentForm->getValue("DIRUJUK_OLEH") : $CurrentForm->getValue("x_DIRUJUK_OLEH");
        if (!$this->DIRUJUK_OLEH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIRUJUK_OLEH->Visible = false; // Disable update for API request
            } else {
                $this->DIRUJUK_OLEH->setFormValue($val);
            }
        }

        // Check field name 'INSPECTION_DATE' first before field var 'x_INSPECTION_DATE'
        $val = $CurrentForm->hasValue("INSPECTION_DATE") ? $CurrentForm->getValue("INSPECTION_DATE") : $CurrentForm->getValue("x_INSPECTION_DATE");
        if (!$this->INSPECTION_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->INSPECTION_DATE->Visible = false; // Disable update for API request
            } else {
                $this->INSPECTION_DATE->setFormValue($val);
            }
            $this->INSPECTION_DATE->CurrentValue = UnFormatDateTime($this->INSPECTION_DATE->CurrentValue, 0);
        }

        // Check field name 'PORSIO' first before field var 'x_PORSIO'
        $val = $CurrentForm->hasValue("PORSIO") ? $CurrentForm->getValue("PORSIO") : $CurrentForm->getValue("x_PORSIO");
        if (!$this->PORSIO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PORSIO->Visible = false; // Disable update for API request
            } else {
                $this->PORSIO->setFormValue($val);
            }
        }

        // Check field name 'PEMBUKAAN' first before field var 'x_PEMBUKAAN'
        $val = $CurrentForm->hasValue("PEMBUKAAN") ? $CurrentForm->getValue("PEMBUKAAN") : $CurrentForm->getValue("x_PEMBUKAAN");
        if (!$this->PEMBUKAAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PEMBUKAAN->Visible = false; // Disable update for API request
            } else {
                $this->PEMBUKAAN->setFormValue($val);
            }
        }

        // Check field name 'KETUBAN' first before field var 'x_KETUBAN'
        $val = $CurrentForm->hasValue("KETUBAN") ? $CurrentForm->getValue("KETUBAN") : $CurrentForm->getValue("x_KETUBAN");
        if (!$this->KETUBAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KETUBAN->Visible = false; // Disable update for API request
            } else {
                $this->KETUBAN->setFormValue($val);
            }
        }

        // Check field name 'PRESENTASI' first before field var 'x_PRESENTASI'
        $val = $CurrentForm->hasValue("PRESENTASI") ? $CurrentForm->getValue("PRESENTASI") : $CurrentForm->getValue("x_PRESENTASI");
        if (!$this->PRESENTASI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRESENTASI->Visible = false; // Disable update for API request
            } else {
                $this->PRESENTASI->setFormValue($val);
            }
        }

        // Check field name 'POSISI' first before field var 'x_POSISI'
        $val = $CurrentForm->hasValue("POSISI") ? $CurrentForm->getValue("POSISI") : $CurrentForm->getValue("x_POSISI");
        if (!$this->POSISI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->POSISI->Visible = false; // Disable update for API request
            } else {
                $this->POSISI->setFormValue($val);
            }
        }

        // Check field name 'PENURUNAN' first before field var 'x_PENURUNAN'
        $val = $CurrentForm->hasValue("PENURUNAN") ? $CurrentForm->getValue("PENURUNAN") : $CurrentForm->getValue("x_PENURUNAN");
        if (!$this->PENURUNAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PENURUNAN->Visible = false; // Disable update for API request
            } else {
                $this->PENURUNAN->setFormValue($val);
            }
        }

        // Check field name 'HEART_ID' first before field var 'x_HEART_ID'
        $val = $CurrentForm->hasValue("HEART_ID") ? $CurrentForm->getValue("HEART_ID") : $CurrentForm->getValue("x_HEART_ID");
        if (!$this->HEART_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->HEART_ID->Visible = false; // Disable update for API request
            } else {
                $this->HEART_ID->setFormValue($val);
            }
        }

        // Check field name 'JANIN_ID' first before field var 'x_JANIN_ID'
        $val = $CurrentForm->hasValue("JANIN_ID") ? $CurrentForm->getValue("JANIN_ID") : $CurrentForm->getValue("x_JANIN_ID");
        if (!$this->JANIN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->JANIN_ID->Visible = false; // Disable update for API request
            } else {
                $this->JANIN_ID->setFormValue($val);
            }
        }

        // Check field name 'FREK_DJJ' first before field var 'x_FREK_DJJ'
        $val = $CurrentForm->hasValue("FREK_DJJ") ? $CurrentForm->getValue("FREK_DJJ") : $CurrentForm->getValue("x_FREK_DJJ");
        if (!$this->FREK_DJJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->FREK_DJJ->Visible = false; // Disable update for API request
            } else {
                $this->FREK_DJJ->setFormValue($val);
            }
        }

        // Check field name 'PLACENTA' first before field var 'x_PLACENTA'
        $val = $CurrentForm->hasValue("PLACENTA") ? $CurrentForm->getValue("PLACENTA") : $CurrentForm->getValue("x_PLACENTA");
        if (!$this->PLACENTA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PLACENTA->Visible = false; // Disable update for API request
            } else {
                $this->PLACENTA->setFormValue($val);
            }
        }

        // Check field name 'LOCHIA' first before field var 'x_LOCHIA'
        $val = $CurrentForm->hasValue("LOCHIA") ? $CurrentForm->getValue("LOCHIA") : $CurrentForm->getValue("x_LOCHIA");
        if (!$this->LOCHIA->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->LOCHIA->Visible = false; // Disable update for API request
            } else {
                $this->LOCHIA->setFormValue($val);
            }
        }

        // Check field name 'BAB_TYPE' first before field var 'x_BAB_TYPE'
        $val = $CurrentForm->hasValue("BAB_TYPE") ? $CurrentForm->getValue("BAB_TYPE") : $CurrentForm->getValue("x_BAB_TYPE");
        if (!$this->BAB_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BAB_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->BAB_TYPE->setFormValue($val);
            }
        }

        // Check field name 'BAB_BAB_TYPE' first before field var 'x_BAB_BAB_TYPE'
        $val = $CurrentForm->hasValue("BAB_BAB_TYPE") ? $CurrentForm->getValue("BAB_BAB_TYPE") : $CurrentForm->getValue("x_BAB_BAB_TYPE");
        if (!$this->BAB_BAB_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BAB_BAB_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->BAB_BAB_TYPE->setFormValue($val);
            }
        }

        // Check field name 'RAHIM_ID' first before field var 'x_RAHIM_ID'
        $val = $CurrentForm->hasValue("RAHIM_ID") ? $CurrentForm->getValue("RAHIM_ID") : $CurrentForm->getValue("x_RAHIM_ID");
        if (!$this->RAHIM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RAHIM_ID->Visible = false; // Disable update for API request
            } else {
                $this->RAHIM_ID->setFormValue($val);
            }
        }

        // Check field name 'BIR_RAHIM_ID' first before field var 'x_BIR_RAHIM_ID'
        $val = $CurrentForm->hasValue("BIR_RAHIM_ID") ? $CurrentForm->getValue("BIR_RAHIM_ID") : $CurrentForm->getValue("x_BIR_RAHIM_ID");
        if (!$this->BIR_RAHIM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIR_RAHIM_ID->Visible = false; // Disable update for API request
            } else {
                $this->BIR_RAHIM_ID->setFormValue($val);
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

        // Check field name 'BLOODING' first before field var 'x_BLOODING'
        $val = $CurrentForm->hasValue("BLOODING") ? $CurrentForm->getValue("BLOODING") : $CurrentForm->getValue("x_BLOODING");
        if (!$this->BLOODING->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BLOODING->Visible = false; // Disable update for API request
            } else {
                $this->BLOODING->setFormValue($val);
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

        // Check field name 'MODIFIED_FROM' first before field var 'x_MODIFIED_FROM'
        $val = $CurrentForm->hasValue("MODIFIED_FROM") ? $CurrentForm->getValue("MODIFIED_FROM") : $CurrentForm->getValue("x_MODIFIED_FROM");
        if (!$this->MODIFIED_FROM->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MODIFIED_FROM->Visible = false; // Disable update for API request
            } else {
                $this->MODIFIED_FROM->setFormValue($val);
            }
        }

        // Check field name 'RAHIM_SALIN' first before field var 'x_RAHIM_SALIN'
        $val = $CurrentForm->hasValue("RAHIM_SALIN") ? $CurrentForm->getValue("RAHIM_SALIN") : $CurrentForm->getValue("x_RAHIM_SALIN");
        if (!$this->RAHIM_SALIN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RAHIM_SALIN->Visible = false; // Disable update for API request
            } else {
                $this->RAHIM_SALIN->setFormValue($val);
            }
        }

        // Check field name 'RAHIM_NIFAS' first before field var 'x_RAHIM_NIFAS'
        $val = $CurrentForm->hasValue("RAHIM_NIFAS") ? $CurrentForm->getValue("RAHIM_NIFAS") : $CurrentForm->getValue("x_RAHIM_NIFAS");
        if (!$this->RAHIM_NIFAS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RAHIM_NIFAS->Visible = false; // Disable update for API request
            } else {
                $this->RAHIM_NIFAS->setFormValue($val);
            }
        }

        // Check field name 'BAK_TYPE' first before field var 'x_BAK_TYPE'
        $val = $CurrentForm->hasValue("BAK_TYPE") ? $CurrentForm->getValue("BAK_TYPE") : $CurrentForm->getValue("x_BAK_TYPE");
        if (!$this->BAK_TYPE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BAK_TYPE->Visible = false; // Disable update for API request
            } else {
                $this->BAK_TYPE->setFormValue($val);
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

        // Check field name 'STATUS_PASIEN_ID' first before field var 'x_STATUS_PASIEN_ID'
        $val = $CurrentForm->hasValue("STATUS_PASIEN_ID") ? $CurrentForm->getValue("STATUS_PASIEN_ID") : $CurrentForm->getValue("x_STATUS_PASIEN_ID");
        if (!$this->STATUS_PASIEN_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->STATUS_PASIEN_ID->Visible = false; // Disable update for API request
            } else {
                $this->STATUS_PASIEN_ID->setFormValue($val);
            }
        }

        // Check field name 'ISRJ' first before field var 'x_ISRJ'
        $val = $CurrentForm->hasValue("ISRJ") ? $CurrentForm->getValue("ISRJ") : $CurrentForm->getValue("x_ISRJ");
        if (!$this->ISRJ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISRJ->Visible = false; // Disable update for API request
            } else {
                $this->ISRJ->setFormValue($val);
            }
        }

        // Check field name 'AGEYEAR' first before field var 'x_AGEYEAR'
        $val = $CurrentForm->hasValue("AGEYEAR") ? $CurrentForm->getValue("AGEYEAR") : $CurrentForm->getValue("x_AGEYEAR");
        if (!$this->AGEYEAR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEYEAR->Visible = false; // Disable update for API request
            } else {
                $this->AGEYEAR->setFormValue($val);
            }
        }

        // Check field name 'AGEMONTH' first before field var 'x_AGEMONTH'
        $val = $CurrentForm->hasValue("AGEMONTH") ? $CurrentForm->getValue("AGEMONTH") : $CurrentForm->getValue("x_AGEMONTH");
        if (!$this->AGEMONTH->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEMONTH->Visible = false; // Disable update for API request
            } else {
                $this->AGEMONTH->setFormValue($val);
            }
        }

        // Check field name 'AGEDAY' first before field var 'x_AGEDAY'
        $val = $CurrentForm->hasValue("AGEDAY") ? $CurrentForm->getValue("AGEDAY") : $CurrentForm->getValue("x_AGEDAY");
        if (!$this->AGEDAY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->AGEDAY->Visible = false; // Disable update for API request
            } else {
                $this->AGEDAY->setFormValue($val);
            }
        }

        // Check field name 'GENDER' first before field var 'x_GENDER'
        $val = $CurrentForm->hasValue("GENDER") ? $CurrentForm->getValue("GENDER") : $CurrentForm->getValue("x_GENDER");
        if (!$this->GENDER->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->GENDER->Visible = false; // Disable update for API request
            } else {
                $this->GENDER->setFormValue($val);
            }
        }

        // Check field name 'CLASS_ROOM_ID' first before field var 'x_CLASS_ROOM_ID'
        $val = $CurrentForm->hasValue("CLASS_ROOM_ID") ? $CurrentForm->getValue("CLASS_ROOM_ID") : $CurrentForm->getValue("x_CLASS_ROOM_ID");
        if (!$this->CLASS_ROOM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->CLASS_ROOM_ID->Visible = false; // Disable update for API request
            } else {
                $this->CLASS_ROOM_ID->setFormValue($val);
            }
        }

        // Check field name 'BED_ID' first before field var 'x_BED_ID'
        $val = $CurrentForm->hasValue("BED_ID") ? $CurrentForm->getValue("BED_ID") : $CurrentForm->getValue("x_BED_ID");
        if (!$this->BED_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BED_ID->Visible = false; // Disable update for API request
            } else {
                $this->BED_ID->setFormValue($val);
            }
        }

        // Check field name 'KELUAR_ID' first before field var 'x_KELUAR_ID'
        $val = $CurrentForm->hasValue("KELUAR_ID") ? $CurrentForm->getValue("KELUAR_ID") : $CurrentForm->getValue("x_KELUAR_ID");
        if (!$this->KELUAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KELUAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->KELUAR_ID->setFormValue($val);
            }
        }

        // Check field name 'DOCTOR' first before field var 'x_DOCTOR'
        $val = $CurrentForm->hasValue("DOCTOR") ? $CurrentForm->getValue("DOCTOR") : $CurrentForm->getValue("x_DOCTOR");
        if (!$this->DOCTOR->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DOCTOR->Visible = false; // Disable update for API request
            } else {
                $this->DOCTOR->setFormValue($val);
            }
        }

        // Check field name 'NB_OBSTETRI' first before field var 'x_NB_OBSTETRI'
        $val = $CurrentForm->hasValue("NB_OBSTETRI") ? $CurrentForm->getValue("NB_OBSTETRI") : $CurrentForm->getValue("x_NB_OBSTETRI");
        if (!$this->NB_OBSTETRI->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NB_OBSTETRI->Visible = false; // Disable update for API request
            } else {
                $this->NB_OBSTETRI->setFormValue($val);
            }
        }

        // Check field name 'OBSTETRI_DIE' first before field var 'x_OBSTETRI_DIE'
        $val = $CurrentForm->hasValue("OBSTETRI_DIE") ? $CurrentForm->getValue("OBSTETRI_DIE") : $CurrentForm->getValue("x_OBSTETRI_DIE");
        if (!$this->OBSTETRI_DIE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->OBSTETRI_DIE->Visible = false; // Disable update for API request
            } else {
                $this->OBSTETRI_DIE->setFormValue($val);
            }
        }

        // Check field name 'KAL_ID' first before field var 'x_KAL_ID'
        $val = $CurrentForm->hasValue("KAL_ID") ? $CurrentForm->getValue("KAL_ID") : $CurrentForm->getValue("x_KAL_ID");
        if (!$this->KAL_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->KAL_ID->Visible = false; // Disable update for API request
            } else {
                $this->KAL_ID->setFormValue($val);
            }
        }

        // Check field name 'DIAGNOSA_ID2' first before field var 'x_DIAGNOSA_ID2'
        $val = $CurrentForm->hasValue("DIAGNOSA_ID2") ? $CurrentForm->getValue("DIAGNOSA_ID2") : $CurrentForm->getValue("x_DIAGNOSA_ID2");
        if (!$this->DIAGNOSA_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DIAGNOSA_ID2->Visible = false; // Disable update for API request
            } else {
                $this->DIAGNOSA_ID2->setFormValue($val);
            }
        }

        // Check field name 'APGAR_ID' first before field var 'x_APGAR_ID'
        $val = $CurrentForm->hasValue("APGAR_ID") ? $CurrentForm->getValue("APGAR_ID") : $CurrentForm->getValue("x_APGAR_ID");
        if (!$this->APGAR_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->APGAR_ID->Visible = false; // Disable update for API request
            } else {
                $this->APGAR_ID->setFormValue($val);
            }
        }

        // Check field name 'BIRTH_LAST_ID' first before field var 'x_BIRTH_LAST_ID'
        $val = $CurrentForm->hasValue("BIRTH_LAST_ID") ? $CurrentForm->getValue("BIRTH_LAST_ID") : $CurrentForm->getValue("x_BIRTH_LAST_ID");
        if (!$this->BIRTH_LAST_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BIRTH_LAST_ID->Visible = false; // Disable update for API request
            } else {
                $this->BIRTH_LAST_ID->setFormValue($val);
            }
        }

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->OBSTETRI_ID->CurrentValue = $this->OBSTETRI_ID->FormValue;
        $this->HPHT->CurrentValue = $this->HPHT->FormValue;
        $this->HPHT->CurrentValue = UnFormatDateTime($this->HPHT->CurrentValue, 0);
        $this->HTP->CurrentValue = $this->HTP->FormValue;
        $this->HTP->CurrentValue = UnFormatDateTime($this->HTP->CurrentValue, 0);
        $this->PASIEN_DIAGNOSA_ID->CurrentValue = $this->PASIEN_DIAGNOSA_ID->FormValue;
        $this->DIAGNOSA_ID->CurrentValue = $this->DIAGNOSA_ID->FormValue;
        $this->NO_REGISTRATION->CurrentValue = $this->NO_REGISTRATION->FormValue;
        $this->KOHORT_NB->CurrentValue = $this->KOHORT_NB->FormValue;
        $this->BIRTH_NB->CurrentValue = $this->BIRTH_NB->FormValue;
        $this->BIRTH_DURATION->CurrentValue = $this->BIRTH_DURATION->FormValue;
        $this->BIRTH_PLACE->CurrentValue = $this->BIRTH_PLACE->FormValue;
        $this->ANTE_NATAL->CurrentValue = $this->ANTE_NATAL->FormValue;
        $this->EMPLOYEE_ID->CurrentValue = $this->EMPLOYEE_ID->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->BIRTH_WAY->CurrentValue = $this->BIRTH_WAY->FormValue;
        $this->BIRTH_BY->CurrentValue = $this->BIRTH_BY->FormValue;
        $this->BIRTH_DATE->CurrentValue = $this->BIRTH_DATE->FormValue;
        $this->BIRTH_DATE->CurrentValue = UnFormatDateTime($this->BIRTH_DATE->CurrentValue, 0);
        $this->GESTASI->CurrentValue = $this->GESTASI->FormValue;
        $this->PARITY->CurrentValue = $this->PARITY->FormValue;
        $this->NB_BABY->CurrentValue = $this->NB_BABY->FormValue;
        $this->BABY_DIE->CurrentValue = $this->BABY_DIE->FormValue;
        $this->ABORTUS_KE->CurrentValue = $this->ABORTUS_KE->FormValue;
        $this->ABORTUS_ID->CurrentValue = $this->ABORTUS_ID->FormValue;
        $this->ABORTION_DATE->CurrentValue = $this->ABORTION_DATE->FormValue;
        $this->ABORTION_DATE->CurrentValue = UnFormatDateTime($this->ABORTION_DATE->CurrentValue, 0);
        $this->BIRTH_CAT->CurrentValue = $this->BIRTH_CAT->FormValue;
        $this->BIRTH_CON->CurrentValue = $this->BIRTH_CON->FormValue;
        $this->BIRTH_RISK->CurrentValue = $this->BIRTH_RISK->FormValue;
        $this->RISK_TYPE->CurrentValue = $this->RISK_TYPE->FormValue;
        $this->FOLLOW_UP->CurrentValue = $this->FOLLOW_UP->FormValue;
        $this->DIRUJUK_OLEH->CurrentValue = $this->DIRUJUK_OLEH->FormValue;
        $this->INSPECTION_DATE->CurrentValue = $this->INSPECTION_DATE->FormValue;
        $this->INSPECTION_DATE->CurrentValue = UnFormatDateTime($this->INSPECTION_DATE->CurrentValue, 0);
        $this->PORSIO->CurrentValue = $this->PORSIO->FormValue;
        $this->PEMBUKAAN->CurrentValue = $this->PEMBUKAAN->FormValue;
        $this->KETUBAN->CurrentValue = $this->KETUBAN->FormValue;
        $this->PRESENTASI->CurrentValue = $this->PRESENTASI->FormValue;
        $this->POSISI->CurrentValue = $this->POSISI->FormValue;
        $this->PENURUNAN->CurrentValue = $this->PENURUNAN->FormValue;
        $this->HEART_ID->CurrentValue = $this->HEART_ID->FormValue;
        $this->JANIN_ID->CurrentValue = $this->JANIN_ID->FormValue;
        $this->FREK_DJJ->CurrentValue = $this->FREK_DJJ->FormValue;
        $this->PLACENTA->CurrentValue = $this->PLACENTA->FormValue;
        $this->LOCHIA->CurrentValue = $this->LOCHIA->FormValue;
        $this->BAB_TYPE->CurrentValue = $this->BAB_TYPE->FormValue;
        $this->BAB_BAB_TYPE->CurrentValue = $this->BAB_BAB_TYPE->FormValue;
        $this->RAHIM_ID->CurrentValue = $this->RAHIM_ID->FormValue;
        $this->BIR_RAHIM_ID->CurrentValue = $this->BIR_RAHIM_ID->FormValue;
        $this->VISIT_ID->CurrentValue = $this->VISIT_ID->FormValue;
        $this->BLOODING->CurrentValue = $this->BLOODING->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->MODIFIED_FROM->CurrentValue = $this->MODIFIED_FROM->FormValue;
        $this->RAHIM_SALIN->CurrentValue = $this->RAHIM_SALIN->FormValue;
        $this->RAHIM_NIFAS->CurrentValue = $this->RAHIM_NIFAS->FormValue;
        $this->BAK_TYPE->CurrentValue = $this->BAK_TYPE->FormValue;
        $this->THENAME->CurrentValue = $this->THENAME->FormValue;
        $this->THEADDRESS->CurrentValue = $this->THEADDRESS->FormValue;
        $this->THEID->CurrentValue = $this->THEID->FormValue;
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->ISRJ->CurrentValue = $this->ISRJ->FormValue;
        $this->AGEYEAR->CurrentValue = $this->AGEYEAR->FormValue;
        $this->AGEMONTH->CurrentValue = $this->AGEMONTH->FormValue;
        $this->AGEDAY->CurrentValue = $this->AGEDAY->FormValue;
        $this->GENDER->CurrentValue = $this->GENDER->FormValue;
        $this->CLASS_ROOM_ID->CurrentValue = $this->CLASS_ROOM_ID->FormValue;
        $this->BED_ID->CurrentValue = $this->BED_ID->FormValue;
        $this->KELUAR_ID->CurrentValue = $this->KELUAR_ID->FormValue;
        $this->DOCTOR->CurrentValue = $this->DOCTOR->FormValue;
        $this->NB_OBSTETRI->CurrentValue = $this->NB_OBSTETRI->FormValue;
        $this->OBSTETRI_DIE->CurrentValue = $this->OBSTETRI_DIE->FormValue;
        $this->KAL_ID->CurrentValue = $this->KAL_ID->FormValue;
        $this->DIAGNOSA_ID2->CurrentValue = $this->DIAGNOSA_ID2->FormValue;
        $this->APGAR_ID->CurrentValue = $this->APGAR_ID->FormValue;
        $this->BIRTH_LAST_ID->CurrentValue = $this->BIRTH_LAST_ID->FormValue;
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
        $this->loadDefaultValues();
        $row = [];
        $row['ORG_UNIT_CODE'] = $this->ORG_UNIT_CODE->CurrentValue;
        $row['OBSTETRI_ID'] = $this->OBSTETRI_ID->CurrentValue;
        $row['HPHT'] = $this->HPHT->CurrentValue;
        $row['HTP'] = $this->HTP->CurrentValue;
        $row['PASIEN_DIAGNOSA_ID'] = $this->PASIEN_DIAGNOSA_ID->CurrentValue;
        $row['DIAGNOSA_ID'] = $this->DIAGNOSA_ID->CurrentValue;
        $row['NO_REGISTRATION'] = $this->NO_REGISTRATION->CurrentValue;
        $row['KOHORT_NB'] = $this->KOHORT_NB->CurrentValue;
        $row['BIRTH_NB'] = $this->BIRTH_NB->CurrentValue;
        $row['BIRTH_DURATION'] = $this->BIRTH_DURATION->CurrentValue;
        $row['BIRTH_PLACE'] = $this->BIRTH_PLACE->CurrentValue;
        $row['ANTE_NATAL'] = $this->ANTE_NATAL->CurrentValue;
        $row['EMPLOYEE_ID'] = $this->EMPLOYEE_ID->CurrentValue;
        $row['CLINIC_ID'] = $this->CLINIC_ID->CurrentValue;
        $row['BIRTH_WAY'] = $this->BIRTH_WAY->CurrentValue;
        $row['BIRTH_BY'] = $this->BIRTH_BY->CurrentValue;
        $row['BIRTH_DATE'] = $this->BIRTH_DATE->CurrentValue;
        $row['GESTASI'] = $this->GESTASI->CurrentValue;
        $row['PARITY'] = $this->PARITY->CurrentValue;
        $row['NB_BABY'] = $this->NB_BABY->CurrentValue;
        $row['BABY_DIE'] = $this->BABY_DIE->CurrentValue;
        $row['ABORTUS_KE'] = $this->ABORTUS_KE->CurrentValue;
        $row['ABORTUS_ID'] = $this->ABORTUS_ID->CurrentValue;
        $row['ABORTION_DATE'] = $this->ABORTION_DATE->CurrentValue;
        $row['BIRTH_CAT'] = $this->BIRTH_CAT->CurrentValue;
        $row['BIRTH_CON'] = $this->BIRTH_CON->CurrentValue;
        $row['BIRTH_RISK'] = $this->BIRTH_RISK->CurrentValue;
        $row['RISK_TYPE'] = $this->RISK_TYPE->CurrentValue;
        $row['FOLLOW_UP'] = $this->FOLLOW_UP->CurrentValue;
        $row['DIRUJUK_OLEH'] = $this->DIRUJUK_OLEH->CurrentValue;
        $row['INSPECTION_DATE'] = $this->INSPECTION_DATE->CurrentValue;
        $row['PORSIO'] = $this->PORSIO->CurrentValue;
        $row['PEMBUKAAN'] = $this->PEMBUKAAN->CurrentValue;
        $row['KETUBAN'] = $this->KETUBAN->CurrentValue;
        $row['PRESENTASI'] = $this->PRESENTASI->CurrentValue;
        $row['POSISI'] = $this->POSISI->CurrentValue;
        $row['PENURUNAN'] = $this->PENURUNAN->CurrentValue;
        $row['HEART_ID'] = $this->HEART_ID->CurrentValue;
        $row['JANIN_ID'] = $this->JANIN_ID->CurrentValue;
        $row['FREK_DJJ'] = $this->FREK_DJJ->CurrentValue;
        $row['PLACENTA'] = $this->PLACENTA->CurrentValue;
        $row['LOCHIA'] = $this->LOCHIA->CurrentValue;
        $row['BAB_TYPE'] = $this->BAB_TYPE->CurrentValue;
        $row['BAB_BAB_TYPE'] = $this->BAB_BAB_TYPE->CurrentValue;
        $row['RAHIM_ID'] = $this->RAHIM_ID->CurrentValue;
        $row['BIR_RAHIM_ID'] = $this->BIR_RAHIM_ID->CurrentValue;
        $row['VISIT_ID'] = $this->VISIT_ID->CurrentValue;
        $row['BLOODING'] = $this->BLOODING->CurrentValue;
        $row['DESCRIPTION'] = $this->DESCRIPTION->CurrentValue;
        $row['MODIFIED_DATE'] = $this->MODIFIED_DATE->CurrentValue;
        $row['MODIFIED_BY'] = $this->MODIFIED_BY->CurrentValue;
        $row['MODIFIED_FROM'] = $this->MODIFIED_FROM->CurrentValue;
        $row['RAHIM_SALIN'] = $this->RAHIM_SALIN->CurrentValue;
        $row['RAHIM_NIFAS'] = $this->RAHIM_NIFAS->CurrentValue;
        $row['BAK_TYPE'] = $this->BAK_TYPE->CurrentValue;
        $row['THENAME'] = $this->THENAME->CurrentValue;
        $row['THEADDRESS'] = $this->THEADDRESS->CurrentValue;
        $row['THEID'] = $this->THEID->CurrentValue;
        $row['STATUS_PASIEN_ID'] = $this->STATUS_PASIEN_ID->CurrentValue;
        $row['ISRJ'] = $this->ISRJ->CurrentValue;
        $row['AGEYEAR'] = $this->AGEYEAR->CurrentValue;
        $row['AGEMONTH'] = $this->AGEMONTH->CurrentValue;
        $row['AGEDAY'] = $this->AGEDAY->CurrentValue;
        $row['GENDER'] = $this->GENDER->CurrentValue;
        $row['CLASS_ROOM_ID'] = $this->CLASS_ROOM_ID->CurrentValue;
        $row['BED_ID'] = $this->BED_ID->CurrentValue;
        $row['KELUAR_ID'] = $this->KELUAR_ID->CurrentValue;
        $row['DOCTOR'] = $this->DOCTOR->CurrentValue;
        $row['NB_OBSTETRI'] = $this->NB_OBSTETRI->CurrentValue;
        $row['OBSTETRI_DIE'] = $this->OBSTETRI_DIE->CurrentValue;
        $row['KAL_ID'] = $this->KAL_ID->CurrentValue;
        $row['DIAGNOSA_ID2'] = $this->DIAGNOSA_ID2->CurrentValue;
        $row['APGAR_ID'] = $this->APGAR_ID->CurrentValue;
        $row['BIRTH_LAST_ID'] = $this->BIRTH_LAST_ID->CurrentValue;
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // OBSTETRI_ID
            $this->OBSTETRI_ID->EditAttrs["class"] = "form-control";
            $this->OBSTETRI_ID->EditCustomAttributes = "";
            if (!$this->OBSTETRI_ID->Raw) {
                $this->OBSTETRI_ID->CurrentValue = HtmlDecode($this->OBSTETRI_ID->CurrentValue);
            }
            $this->OBSTETRI_ID->EditValue = HtmlEncode($this->OBSTETRI_ID->CurrentValue);
            $this->OBSTETRI_ID->PlaceHolder = RemoveHtml($this->OBSTETRI_ID->caption());

            // HPHT
            $this->HPHT->EditAttrs["class"] = "form-control";
            $this->HPHT->EditCustomAttributes = "";
            $this->HPHT->EditValue = HtmlEncode(FormatDateTime($this->HPHT->CurrentValue, 8));
            $this->HPHT->PlaceHolder = RemoveHtml($this->HPHT->caption());

            // HTP
            $this->HTP->EditAttrs["class"] = "form-control";
            $this->HTP->EditCustomAttributes = "";
            $this->HTP->EditValue = HtmlEncode(FormatDateTime($this->HTP->CurrentValue, 8));
            $this->HTP->PlaceHolder = RemoveHtml($this->HTP->caption());

            // PASIEN_DIAGNOSA_ID
            $this->PASIEN_DIAGNOSA_ID->EditAttrs["class"] = "form-control";
            $this->PASIEN_DIAGNOSA_ID->EditCustomAttributes = "";
            if (!$this->PASIEN_DIAGNOSA_ID->Raw) {
                $this->PASIEN_DIAGNOSA_ID->CurrentValue = HtmlDecode($this->PASIEN_DIAGNOSA_ID->CurrentValue);
            }
            $this->PASIEN_DIAGNOSA_ID->EditValue = HtmlEncode($this->PASIEN_DIAGNOSA_ID->CurrentValue);
            $this->PASIEN_DIAGNOSA_ID->PlaceHolder = RemoveHtml($this->PASIEN_DIAGNOSA_ID->caption());

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->EditAttrs["class"] = "form-control";
            $this->DIAGNOSA_ID->EditCustomAttributes = "";
            if (!$this->DIAGNOSA_ID->Raw) {
                $this->DIAGNOSA_ID->CurrentValue = HtmlDecode($this->DIAGNOSA_ID->CurrentValue);
            }
            $this->DIAGNOSA_ID->EditValue = HtmlEncode($this->DIAGNOSA_ID->CurrentValue);
            $this->DIAGNOSA_ID->PlaceHolder = RemoveHtml($this->DIAGNOSA_ID->caption());

            // NO_REGISTRATION
            $this->NO_REGISTRATION->EditAttrs["class"] = "form-control";
            $this->NO_REGISTRATION->EditCustomAttributes = "";
            if (!$this->NO_REGISTRATION->Raw) {
                $this->NO_REGISTRATION->CurrentValue = HtmlDecode($this->NO_REGISTRATION->CurrentValue);
            }
            $this->NO_REGISTRATION->EditValue = HtmlEncode($this->NO_REGISTRATION->CurrentValue);
            $this->NO_REGISTRATION->PlaceHolder = RemoveHtml($this->NO_REGISTRATION->caption());

            // KOHORT_NB
            $this->KOHORT_NB->EditAttrs["class"] = "form-control";
            $this->KOHORT_NB->EditCustomAttributes = "";
            if (!$this->KOHORT_NB->Raw) {
                $this->KOHORT_NB->CurrentValue = HtmlDecode($this->KOHORT_NB->CurrentValue);
            }
            $this->KOHORT_NB->EditValue = HtmlEncode($this->KOHORT_NB->CurrentValue);
            $this->KOHORT_NB->PlaceHolder = RemoveHtml($this->KOHORT_NB->caption());

            // BIRTH_NB
            $this->BIRTH_NB->EditAttrs["class"] = "form-control";
            $this->BIRTH_NB->EditCustomAttributes = "";
            $this->BIRTH_NB->EditValue = HtmlEncode($this->BIRTH_NB->CurrentValue);
            $this->BIRTH_NB->PlaceHolder = RemoveHtml($this->BIRTH_NB->caption());

            // BIRTH_DURATION
            $this->BIRTH_DURATION->EditAttrs["class"] = "form-control";
            $this->BIRTH_DURATION->EditCustomAttributes = "";
            $this->BIRTH_DURATION->EditValue = HtmlEncode($this->BIRTH_DURATION->CurrentValue);
            $this->BIRTH_DURATION->PlaceHolder = RemoveHtml($this->BIRTH_DURATION->caption());

            // BIRTH_PLACE
            $this->BIRTH_PLACE->EditAttrs["class"] = "form-control";
            $this->BIRTH_PLACE->EditCustomAttributes = "";
            $this->BIRTH_PLACE->EditValue = HtmlEncode($this->BIRTH_PLACE->CurrentValue);
            $this->BIRTH_PLACE->PlaceHolder = RemoveHtml($this->BIRTH_PLACE->caption());

            // ANTE_NATAL
            $this->ANTE_NATAL->EditAttrs["class"] = "form-control";
            $this->ANTE_NATAL->EditCustomAttributes = "";
            $this->ANTE_NATAL->EditValue = HtmlEncode($this->ANTE_NATAL->CurrentValue);
            $this->ANTE_NATAL->PlaceHolder = RemoveHtml($this->ANTE_NATAL->caption());

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->EditAttrs["class"] = "form-control";
            $this->EMPLOYEE_ID->EditCustomAttributes = "";
            if (!$this->EMPLOYEE_ID->Raw) {
                $this->EMPLOYEE_ID->CurrentValue = HtmlDecode($this->EMPLOYEE_ID->CurrentValue);
            }
            $this->EMPLOYEE_ID->EditValue = HtmlEncode($this->EMPLOYEE_ID->CurrentValue);
            $this->EMPLOYEE_ID->PlaceHolder = RemoveHtml($this->EMPLOYEE_ID->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            if (!$this->CLINIC_ID->Raw) {
                $this->CLINIC_ID->CurrentValue = HtmlDecode($this->CLINIC_ID->CurrentValue);
            }
            $this->CLINIC_ID->EditValue = HtmlEncode($this->CLINIC_ID->CurrentValue);
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // BIRTH_WAY
            $this->BIRTH_WAY->EditAttrs["class"] = "form-control";
            $this->BIRTH_WAY->EditCustomAttributes = "";
            if (!$this->BIRTH_WAY->Raw) {
                $this->BIRTH_WAY->CurrentValue = HtmlDecode($this->BIRTH_WAY->CurrentValue);
            }
            $this->BIRTH_WAY->EditValue = HtmlEncode($this->BIRTH_WAY->CurrentValue);
            $this->BIRTH_WAY->PlaceHolder = RemoveHtml($this->BIRTH_WAY->caption());

            // BIRTH_BY
            $this->BIRTH_BY->EditAttrs["class"] = "form-control";
            $this->BIRTH_BY->EditCustomAttributes = "";
            $this->BIRTH_BY->EditValue = HtmlEncode($this->BIRTH_BY->CurrentValue);
            $this->BIRTH_BY->PlaceHolder = RemoveHtml($this->BIRTH_BY->caption());

            // BIRTH_DATE
            $this->BIRTH_DATE->EditAttrs["class"] = "form-control";
            $this->BIRTH_DATE->EditCustomAttributes = "";
            $this->BIRTH_DATE->EditValue = HtmlEncode(FormatDateTime($this->BIRTH_DATE->CurrentValue, 8));
            $this->BIRTH_DATE->PlaceHolder = RemoveHtml($this->BIRTH_DATE->caption());

            // GESTASI
            $this->GESTASI->EditAttrs["class"] = "form-control";
            $this->GESTASI->EditCustomAttributes = "";
            $this->GESTASI->EditValue = HtmlEncode($this->GESTASI->CurrentValue);
            $this->GESTASI->PlaceHolder = RemoveHtml($this->GESTASI->caption());

            // PARITY
            $this->PARITY->EditAttrs["class"] = "form-control";
            $this->PARITY->EditCustomAttributes = "";
            $this->PARITY->EditValue = HtmlEncode($this->PARITY->CurrentValue);
            $this->PARITY->PlaceHolder = RemoveHtml($this->PARITY->caption());

            // NB_BABY
            $this->NB_BABY->EditAttrs["class"] = "form-control";
            $this->NB_BABY->EditCustomAttributes = "";
            $this->NB_BABY->EditValue = HtmlEncode($this->NB_BABY->CurrentValue);
            $this->NB_BABY->PlaceHolder = RemoveHtml($this->NB_BABY->caption());

            // BABY_DIE
            $this->BABY_DIE->EditAttrs["class"] = "form-control";
            $this->BABY_DIE->EditCustomAttributes = "";
            $this->BABY_DIE->EditValue = HtmlEncode($this->BABY_DIE->CurrentValue);
            $this->BABY_DIE->PlaceHolder = RemoveHtml($this->BABY_DIE->caption());

            // ABORTUS_KE
            $this->ABORTUS_KE->EditAttrs["class"] = "form-control";
            $this->ABORTUS_KE->EditCustomAttributes = "";
            $this->ABORTUS_KE->EditValue = HtmlEncode($this->ABORTUS_KE->CurrentValue);
            $this->ABORTUS_KE->PlaceHolder = RemoveHtml($this->ABORTUS_KE->caption());

            // ABORTUS_ID
            $this->ABORTUS_ID->EditAttrs["class"] = "form-control";
            $this->ABORTUS_ID->EditCustomAttributes = "";
            if (!$this->ABORTUS_ID->Raw) {
                $this->ABORTUS_ID->CurrentValue = HtmlDecode($this->ABORTUS_ID->CurrentValue);
            }
            $this->ABORTUS_ID->EditValue = HtmlEncode($this->ABORTUS_ID->CurrentValue);
            $this->ABORTUS_ID->PlaceHolder = RemoveHtml($this->ABORTUS_ID->caption());

            // ABORTION_DATE
            $this->ABORTION_DATE->EditAttrs["class"] = "form-control";
            $this->ABORTION_DATE->EditCustomAttributes = "";
            $this->ABORTION_DATE->EditValue = HtmlEncode(FormatDateTime($this->ABORTION_DATE->CurrentValue, 8));
            $this->ABORTION_DATE->PlaceHolder = RemoveHtml($this->ABORTION_DATE->caption());

            // BIRTH_CAT
            $this->BIRTH_CAT->EditAttrs["class"] = "form-control";
            $this->BIRTH_CAT->EditCustomAttributes = "";
            if (!$this->BIRTH_CAT->Raw) {
                $this->BIRTH_CAT->CurrentValue = HtmlDecode($this->BIRTH_CAT->CurrentValue);
            }
            $this->BIRTH_CAT->EditValue = HtmlEncode($this->BIRTH_CAT->CurrentValue);
            $this->BIRTH_CAT->PlaceHolder = RemoveHtml($this->BIRTH_CAT->caption());

            // BIRTH_CON
            $this->BIRTH_CON->EditAttrs["class"] = "form-control";
            $this->BIRTH_CON->EditCustomAttributes = "";
            $this->BIRTH_CON->EditValue = HtmlEncode($this->BIRTH_CON->CurrentValue);
            $this->BIRTH_CON->PlaceHolder = RemoveHtml($this->BIRTH_CON->caption());

            // BIRTH_RISK
            $this->BIRTH_RISK->EditAttrs["class"] = "form-control";
            $this->BIRTH_RISK->EditCustomAttributes = "";
            $this->BIRTH_RISK->EditValue = HtmlEncode($this->BIRTH_RISK->CurrentValue);
            $this->BIRTH_RISK->PlaceHolder = RemoveHtml($this->BIRTH_RISK->caption());

            // RISK_TYPE
            $this->RISK_TYPE->EditAttrs["class"] = "form-control";
            $this->RISK_TYPE->EditCustomAttributes = "";
            $this->RISK_TYPE->EditValue = HtmlEncode($this->RISK_TYPE->CurrentValue);
            $this->RISK_TYPE->PlaceHolder = RemoveHtml($this->RISK_TYPE->caption());

            // FOLLOW_UP
            $this->FOLLOW_UP->EditAttrs["class"] = "form-control";
            $this->FOLLOW_UP->EditCustomAttributes = "";
            $this->FOLLOW_UP->EditValue = HtmlEncode($this->FOLLOW_UP->CurrentValue);
            $this->FOLLOW_UP->PlaceHolder = RemoveHtml($this->FOLLOW_UP->caption());

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->EditAttrs["class"] = "form-control";
            $this->DIRUJUK_OLEH->EditCustomAttributes = "";
            if (!$this->DIRUJUK_OLEH->Raw) {
                $this->DIRUJUK_OLEH->CurrentValue = HtmlDecode($this->DIRUJUK_OLEH->CurrentValue);
            }
            $this->DIRUJUK_OLEH->EditValue = HtmlEncode($this->DIRUJUK_OLEH->CurrentValue);
            $this->DIRUJUK_OLEH->PlaceHolder = RemoveHtml($this->DIRUJUK_OLEH->caption());

            // INSPECTION_DATE
            $this->INSPECTION_DATE->EditAttrs["class"] = "form-control";
            $this->INSPECTION_DATE->EditCustomAttributes = "";
            $this->INSPECTION_DATE->EditValue = HtmlEncode(FormatDateTime($this->INSPECTION_DATE->CurrentValue, 8));
            $this->INSPECTION_DATE->PlaceHolder = RemoveHtml($this->INSPECTION_DATE->caption());

            // PORSIO
            $this->PORSIO->EditAttrs["class"] = "form-control";
            $this->PORSIO->EditCustomAttributes = "";
            if (!$this->PORSIO->Raw) {
                $this->PORSIO->CurrentValue = HtmlDecode($this->PORSIO->CurrentValue);
            }
            $this->PORSIO->EditValue = HtmlEncode($this->PORSIO->CurrentValue);
            $this->PORSIO->PlaceHolder = RemoveHtml($this->PORSIO->caption());

            // PEMBUKAAN
            $this->PEMBUKAAN->EditAttrs["class"] = "form-control";
            $this->PEMBUKAAN->EditCustomAttributes = "";
            if (!$this->PEMBUKAAN->Raw) {
                $this->PEMBUKAAN->CurrentValue = HtmlDecode($this->PEMBUKAAN->CurrentValue);
            }
            $this->PEMBUKAAN->EditValue = HtmlEncode($this->PEMBUKAAN->CurrentValue);
            $this->PEMBUKAAN->PlaceHolder = RemoveHtml($this->PEMBUKAAN->caption());

            // KETUBAN
            $this->KETUBAN->EditAttrs["class"] = "form-control";
            $this->KETUBAN->EditCustomAttributes = "";
            if (!$this->KETUBAN->Raw) {
                $this->KETUBAN->CurrentValue = HtmlDecode($this->KETUBAN->CurrentValue);
            }
            $this->KETUBAN->EditValue = HtmlEncode($this->KETUBAN->CurrentValue);
            $this->KETUBAN->PlaceHolder = RemoveHtml($this->KETUBAN->caption());

            // PRESENTASI
            $this->PRESENTASI->EditAttrs["class"] = "form-control";
            $this->PRESENTASI->EditCustomAttributes = "";
            if (!$this->PRESENTASI->Raw) {
                $this->PRESENTASI->CurrentValue = HtmlDecode($this->PRESENTASI->CurrentValue);
            }
            $this->PRESENTASI->EditValue = HtmlEncode($this->PRESENTASI->CurrentValue);
            $this->PRESENTASI->PlaceHolder = RemoveHtml($this->PRESENTASI->caption());

            // POSISI
            $this->POSISI->EditAttrs["class"] = "form-control";
            $this->POSISI->EditCustomAttributes = "";
            if (!$this->POSISI->Raw) {
                $this->POSISI->CurrentValue = HtmlDecode($this->POSISI->CurrentValue);
            }
            $this->POSISI->EditValue = HtmlEncode($this->POSISI->CurrentValue);
            $this->POSISI->PlaceHolder = RemoveHtml($this->POSISI->caption());

            // PENURUNAN
            $this->PENURUNAN->EditAttrs["class"] = "form-control";
            $this->PENURUNAN->EditCustomAttributes = "";
            if (!$this->PENURUNAN->Raw) {
                $this->PENURUNAN->CurrentValue = HtmlDecode($this->PENURUNAN->CurrentValue);
            }
            $this->PENURUNAN->EditValue = HtmlEncode($this->PENURUNAN->CurrentValue);
            $this->PENURUNAN->PlaceHolder = RemoveHtml($this->PENURUNAN->caption());

            // HEART_ID
            $this->HEART_ID->EditAttrs["class"] = "form-control";
            $this->HEART_ID->EditCustomAttributes = "";
            $this->HEART_ID->EditValue = HtmlEncode($this->HEART_ID->CurrentValue);
            $this->HEART_ID->PlaceHolder = RemoveHtml($this->HEART_ID->caption());

            // JANIN_ID
            $this->JANIN_ID->EditAttrs["class"] = "form-control";
            $this->JANIN_ID->EditCustomAttributes = "";
            $this->JANIN_ID->EditValue = HtmlEncode($this->JANIN_ID->CurrentValue);
            $this->JANIN_ID->PlaceHolder = RemoveHtml($this->JANIN_ID->caption());

            // FREK_DJJ
            $this->FREK_DJJ->EditAttrs["class"] = "form-control";
            $this->FREK_DJJ->EditCustomAttributes = "";
            $this->FREK_DJJ->EditValue = HtmlEncode($this->FREK_DJJ->CurrentValue);
            $this->FREK_DJJ->PlaceHolder = RemoveHtml($this->FREK_DJJ->caption());
            if (strval($this->FREK_DJJ->EditValue) != "" && is_numeric($this->FREK_DJJ->EditValue)) {
                $this->FREK_DJJ->EditValue = FormatNumber($this->FREK_DJJ->EditValue, -2, -2, -2, -2);
            }

            // PLACENTA
            $this->PLACENTA->EditAttrs["class"] = "form-control";
            $this->PLACENTA->EditCustomAttributes = "";
            if (!$this->PLACENTA->Raw) {
                $this->PLACENTA->CurrentValue = HtmlDecode($this->PLACENTA->CurrentValue);
            }
            $this->PLACENTA->EditValue = HtmlEncode($this->PLACENTA->CurrentValue);
            $this->PLACENTA->PlaceHolder = RemoveHtml($this->PLACENTA->caption());

            // LOCHIA
            $this->LOCHIA->EditAttrs["class"] = "form-control";
            $this->LOCHIA->EditCustomAttributes = "";
            if (!$this->LOCHIA->Raw) {
                $this->LOCHIA->CurrentValue = HtmlDecode($this->LOCHIA->CurrentValue);
            }
            $this->LOCHIA->EditValue = HtmlEncode($this->LOCHIA->CurrentValue);
            $this->LOCHIA->PlaceHolder = RemoveHtml($this->LOCHIA->caption());

            // BAB_TYPE
            $this->BAB_TYPE->EditAttrs["class"] = "form-control";
            $this->BAB_TYPE->EditCustomAttributes = "";
            $this->BAB_TYPE->EditValue = HtmlEncode($this->BAB_TYPE->CurrentValue);
            $this->BAB_TYPE->PlaceHolder = RemoveHtml($this->BAB_TYPE->caption());

            // BAB_BAB_TYPE
            $this->BAB_BAB_TYPE->EditAttrs["class"] = "form-control";
            $this->BAB_BAB_TYPE->EditCustomAttributes = "";
            $this->BAB_BAB_TYPE->EditValue = HtmlEncode($this->BAB_BAB_TYPE->CurrentValue);
            $this->BAB_BAB_TYPE->PlaceHolder = RemoveHtml($this->BAB_BAB_TYPE->caption());

            // RAHIM_ID
            $this->RAHIM_ID->EditAttrs["class"] = "form-control";
            $this->RAHIM_ID->EditCustomAttributes = "";
            if (!$this->RAHIM_ID->Raw) {
                $this->RAHIM_ID->CurrentValue = HtmlDecode($this->RAHIM_ID->CurrentValue);
            }
            $this->RAHIM_ID->EditValue = HtmlEncode($this->RAHIM_ID->CurrentValue);
            $this->RAHIM_ID->PlaceHolder = RemoveHtml($this->RAHIM_ID->caption());

            // BIR_RAHIM_ID
            $this->BIR_RAHIM_ID->EditAttrs["class"] = "form-control";
            $this->BIR_RAHIM_ID->EditCustomAttributes = "";
            if (!$this->BIR_RAHIM_ID->Raw) {
                $this->BIR_RAHIM_ID->CurrentValue = HtmlDecode($this->BIR_RAHIM_ID->CurrentValue);
            }
            $this->BIR_RAHIM_ID->EditValue = HtmlEncode($this->BIR_RAHIM_ID->CurrentValue);
            $this->BIR_RAHIM_ID->PlaceHolder = RemoveHtml($this->BIR_RAHIM_ID->caption());

            // VISIT_ID
            $this->VISIT_ID->EditAttrs["class"] = "form-control";
            $this->VISIT_ID->EditCustomAttributes = "";
            if (!$this->VISIT_ID->Raw) {
                $this->VISIT_ID->CurrentValue = HtmlDecode($this->VISIT_ID->CurrentValue);
            }
            $this->VISIT_ID->EditValue = HtmlEncode($this->VISIT_ID->CurrentValue);
            $this->VISIT_ID->PlaceHolder = RemoveHtml($this->VISIT_ID->caption());

            // BLOODING
            $this->BLOODING->EditAttrs["class"] = "form-control";
            $this->BLOODING->EditCustomAttributes = "";
            if (!$this->BLOODING->Raw) {
                $this->BLOODING->CurrentValue = HtmlDecode($this->BLOODING->CurrentValue);
            }
            $this->BLOODING->EditValue = HtmlEncode($this->BLOODING->CurrentValue);
            $this->BLOODING->PlaceHolder = RemoveHtml($this->BLOODING->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

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

            // MODIFIED_FROM
            $this->MODIFIED_FROM->EditAttrs["class"] = "form-control";
            $this->MODIFIED_FROM->EditCustomAttributes = "";
            if (!$this->MODIFIED_FROM->Raw) {
                $this->MODIFIED_FROM->CurrentValue = HtmlDecode($this->MODIFIED_FROM->CurrentValue);
            }
            $this->MODIFIED_FROM->EditValue = HtmlEncode($this->MODIFIED_FROM->CurrentValue);
            $this->MODIFIED_FROM->PlaceHolder = RemoveHtml($this->MODIFIED_FROM->caption());

            // RAHIM_SALIN
            $this->RAHIM_SALIN->EditAttrs["class"] = "form-control";
            $this->RAHIM_SALIN->EditCustomAttributes = "";
            if (!$this->RAHIM_SALIN->Raw) {
                $this->RAHIM_SALIN->CurrentValue = HtmlDecode($this->RAHIM_SALIN->CurrentValue);
            }
            $this->RAHIM_SALIN->EditValue = HtmlEncode($this->RAHIM_SALIN->CurrentValue);
            $this->RAHIM_SALIN->PlaceHolder = RemoveHtml($this->RAHIM_SALIN->caption());

            // RAHIM_NIFAS
            $this->RAHIM_NIFAS->EditAttrs["class"] = "form-control";
            $this->RAHIM_NIFAS->EditCustomAttributes = "";
            if (!$this->RAHIM_NIFAS->Raw) {
                $this->RAHIM_NIFAS->CurrentValue = HtmlDecode($this->RAHIM_NIFAS->CurrentValue);
            }
            $this->RAHIM_NIFAS->EditValue = HtmlEncode($this->RAHIM_NIFAS->CurrentValue);
            $this->RAHIM_NIFAS->PlaceHolder = RemoveHtml($this->RAHIM_NIFAS->caption());

            // BAK_TYPE
            $this->BAK_TYPE->EditAttrs["class"] = "form-control";
            $this->BAK_TYPE->EditCustomAttributes = "";
            $this->BAK_TYPE->EditValue = HtmlEncode($this->BAK_TYPE->CurrentValue);
            $this->BAK_TYPE->PlaceHolder = RemoveHtml($this->BAK_TYPE->caption());

            // THENAME
            $this->THENAME->EditAttrs["class"] = "form-control";
            $this->THENAME->EditCustomAttributes = "";
            if (!$this->THENAME->Raw) {
                $this->THENAME->CurrentValue = HtmlDecode($this->THENAME->CurrentValue);
            }
            $this->THENAME->EditValue = HtmlEncode($this->THENAME->CurrentValue);
            $this->THENAME->PlaceHolder = RemoveHtml($this->THENAME->caption());

            // THEADDRESS
            $this->THEADDRESS->EditAttrs["class"] = "form-control";
            $this->THEADDRESS->EditCustomAttributes = "";
            if (!$this->THEADDRESS->Raw) {
                $this->THEADDRESS->CurrentValue = HtmlDecode($this->THEADDRESS->CurrentValue);
            }
            $this->THEADDRESS->EditValue = HtmlEncode($this->THEADDRESS->CurrentValue);
            $this->THEADDRESS->PlaceHolder = RemoveHtml($this->THEADDRESS->caption());

            // THEID
            $this->THEID->EditAttrs["class"] = "form-control";
            $this->THEID->EditCustomAttributes = "";
            if (!$this->THEID->Raw) {
                $this->THEID->CurrentValue = HtmlDecode($this->THEID->CurrentValue);
            }
            $this->THEID->EditValue = HtmlEncode($this->THEID->CurrentValue);
            $this->THEID->PlaceHolder = RemoveHtml($this->THEID->caption());

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $this->STATUS_PASIEN_ID->EditValue = HtmlEncode($this->STATUS_PASIEN_ID->CurrentValue);
            $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

            // ISRJ
            $this->ISRJ->EditAttrs["class"] = "form-control";
            $this->ISRJ->EditCustomAttributes = "";
            if (!$this->ISRJ->Raw) {
                $this->ISRJ->CurrentValue = HtmlDecode($this->ISRJ->CurrentValue);
            }
            $this->ISRJ->EditValue = HtmlEncode($this->ISRJ->CurrentValue);
            $this->ISRJ->PlaceHolder = RemoveHtml($this->ISRJ->caption());

            // AGEYEAR
            $this->AGEYEAR->EditAttrs["class"] = "form-control";
            $this->AGEYEAR->EditCustomAttributes = "";
            $this->AGEYEAR->EditValue = HtmlEncode($this->AGEYEAR->CurrentValue);
            $this->AGEYEAR->PlaceHolder = RemoveHtml($this->AGEYEAR->caption());

            // AGEMONTH
            $this->AGEMONTH->EditAttrs["class"] = "form-control";
            $this->AGEMONTH->EditCustomAttributes = "";
            $this->AGEMONTH->EditValue = HtmlEncode($this->AGEMONTH->CurrentValue);
            $this->AGEMONTH->PlaceHolder = RemoveHtml($this->AGEMONTH->caption());

            // AGEDAY
            $this->AGEDAY->EditAttrs["class"] = "form-control";
            $this->AGEDAY->EditCustomAttributes = "";
            $this->AGEDAY->EditValue = HtmlEncode($this->AGEDAY->CurrentValue);
            $this->AGEDAY->PlaceHolder = RemoveHtml($this->AGEDAY->caption());

            // GENDER
            $this->GENDER->EditAttrs["class"] = "form-control";
            $this->GENDER->EditCustomAttributes = "";
            if (!$this->GENDER->Raw) {
                $this->GENDER->CurrentValue = HtmlDecode($this->GENDER->CurrentValue);
            }
            $this->GENDER->EditValue = HtmlEncode($this->GENDER->CurrentValue);
            $this->GENDER->PlaceHolder = RemoveHtml($this->GENDER->caption());

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->EditAttrs["class"] = "form-control";
            $this->CLASS_ROOM_ID->EditCustomAttributes = "";
            if (!$this->CLASS_ROOM_ID->Raw) {
                $this->CLASS_ROOM_ID->CurrentValue = HtmlDecode($this->CLASS_ROOM_ID->CurrentValue);
            }
            $this->CLASS_ROOM_ID->EditValue = HtmlEncode($this->CLASS_ROOM_ID->CurrentValue);
            $this->CLASS_ROOM_ID->PlaceHolder = RemoveHtml($this->CLASS_ROOM_ID->caption());

            // BED_ID
            $this->BED_ID->EditAttrs["class"] = "form-control";
            $this->BED_ID->EditCustomAttributes = "";
            $this->BED_ID->EditValue = HtmlEncode($this->BED_ID->CurrentValue);
            $this->BED_ID->PlaceHolder = RemoveHtml($this->BED_ID->caption());

            // KELUAR_ID
            $this->KELUAR_ID->EditAttrs["class"] = "form-control";
            $this->KELUAR_ID->EditCustomAttributes = "";
            $this->KELUAR_ID->EditValue = HtmlEncode($this->KELUAR_ID->CurrentValue);
            $this->KELUAR_ID->PlaceHolder = RemoveHtml($this->KELUAR_ID->caption());

            // DOCTOR
            $this->DOCTOR->EditAttrs["class"] = "form-control";
            $this->DOCTOR->EditCustomAttributes = "";
            if (!$this->DOCTOR->Raw) {
                $this->DOCTOR->CurrentValue = HtmlDecode($this->DOCTOR->CurrentValue);
            }
            $this->DOCTOR->EditValue = HtmlEncode($this->DOCTOR->CurrentValue);
            $this->DOCTOR->PlaceHolder = RemoveHtml($this->DOCTOR->caption());

            // NB_OBSTETRI
            $this->NB_OBSTETRI->EditAttrs["class"] = "form-control";
            $this->NB_OBSTETRI->EditCustomAttributes = "";
            $this->NB_OBSTETRI->EditValue = HtmlEncode($this->NB_OBSTETRI->CurrentValue);
            $this->NB_OBSTETRI->PlaceHolder = RemoveHtml($this->NB_OBSTETRI->caption());

            // OBSTETRI_DIE
            $this->OBSTETRI_DIE->EditAttrs["class"] = "form-control";
            $this->OBSTETRI_DIE->EditCustomAttributes = "";
            $this->OBSTETRI_DIE->EditValue = HtmlEncode($this->OBSTETRI_DIE->CurrentValue);
            $this->OBSTETRI_DIE->PlaceHolder = RemoveHtml($this->OBSTETRI_DIE->caption());

            // KAL_ID
            $this->KAL_ID->EditAttrs["class"] = "form-control";
            $this->KAL_ID->EditCustomAttributes = "";
            if (!$this->KAL_ID->Raw) {
                $this->KAL_ID->CurrentValue = HtmlDecode($this->KAL_ID->CurrentValue);
            }
            $this->KAL_ID->EditValue = HtmlEncode($this->KAL_ID->CurrentValue);
            $this->KAL_ID->PlaceHolder = RemoveHtml($this->KAL_ID->caption());

            // DIAGNOSA_ID2
            $this->DIAGNOSA_ID2->EditAttrs["class"] = "form-control";
            $this->DIAGNOSA_ID2->EditCustomAttributes = "";
            if (!$this->DIAGNOSA_ID2->Raw) {
                $this->DIAGNOSA_ID2->CurrentValue = HtmlDecode($this->DIAGNOSA_ID2->CurrentValue);
            }
            $this->DIAGNOSA_ID2->EditValue = HtmlEncode($this->DIAGNOSA_ID2->CurrentValue);
            $this->DIAGNOSA_ID2->PlaceHolder = RemoveHtml($this->DIAGNOSA_ID2->caption());

            // APGAR_ID
            $this->APGAR_ID->EditAttrs["class"] = "form-control";
            $this->APGAR_ID->EditCustomAttributes = "";
            if (!$this->APGAR_ID->Raw) {
                $this->APGAR_ID->CurrentValue = HtmlDecode($this->APGAR_ID->CurrentValue);
            }
            $this->APGAR_ID->EditValue = HtmlEncode($this->APGAR_ID->CurrentValue);
            $this->APGAR_ID->PlaceHolder = RemoveHtml($this->APGAR_ID->caption());

            // BIRTH_LAST_ID
            $this->BIRTH_LAST_ID->EditAttrs["class"] = "form-control";
            $this->BIRTH_LAST_ID->EditCustomAttributes = "";
            if (!$this->BIRTH_LAST_ID->Raw) {
                $this->BIRTH_LAST_ID->CurrentValue = HtmlDecode($this->BIRTH_LAST_ID->CurrentValue);
            }
            $this->BIRTH_LAST_ID->EditValue = HtmlEncode($this->BIRTH_LAST_ID->CurrentValue);
            $this->BIRTH_LAST_ID->PlaceHolder = RemoveHtml($this->BIRTH_LAST_ID->caption());

            // Add refer script

            // OBSTETRI_ID
            $this->OBSTETRI_ID->LinkCustomAttributes = "";
            $this->OBSTETRI_ID->HrefValue = "";

            // HPHT
            $this->HPHT->LinkCustomAttributes = "";
            $this->HPHT->HrefValue = "";

            // HTP
            $this->HTP->LinkCustomAttributes = "";
            $this->HTP->HrefValue = "";

            // PASIEN_DIAGNOSA_ID
            $this->PASIEN_DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->PASIEN_DIAGNOSA_ID->HrefValue = "";

            // DIAGNOSA_ID
            $this->DIAGNOSA_ID->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID->HrefValue = "";

            // NO_REGISTRATION
            $this->NO_REGISTRATION->LinkCustomAttributes = "";
            $this->NO_REGISTRATION->HrefValue = "";

            // KOHORT_NB
            $this->KOHORT_NB->LinkCustomAttributes = "";
            $this->KOHORT_NB->HrefValue = "";

            // BIRTH_NB
            $this->BIRTH_NB->LinkCustomAttributes = "";
            $this->BIRTH_NB->HrefValue = "";

            // BIRTH_DURATION
            $this->BIRTH_DURATION->LinkCustomAttributes = "";
            $this->BIRTH_DURATION->HrefValue = "";

            // BIRTH_PLACE
            $this->BIRTH_PLACE->LinkCustomAttributes = "";
            $this->BIRTH_PLACE->HrefValue = "";

            // ANTE_NATAL
            $this->ANTE_NATAL->LinkCustomAttributes = "";
            $this->ANTE_NATAL->HrefValue = "";

            // EMPLOYEE_ID
            $this->EMPLOYEE_ID->LinkCustomAttributes = "";
            $this->EMPLOYEE_ID->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // BIRTH_WAY
            $this->BIRTH_WAY->LinkCustomAttributes = "";
            $this->BIRTH_WAY->HrefValue = "";

            // BIRTH_BY
            $this->BIRTH_BY->LinkCustomAttributes = "";
            $this->BIRTH_BY->HrefValue = "";

            // BIRTH_DATE
            $this->BIRTH_DATE->LinkCustomAttributes = "";
            $this->BIRTH_DATE->HrefValue = "";

            // GESTASI
            $this->GESTASI->LinkCustomAttributes = "";
            $this->GESTASI->HrefValue = "";

            // PARITY
            $this->PARITY->LinkCustomAttributes = "";
            $this->PARITY->HrefValue = "";

            // NB_BABY
            $this->NB_BABY->LinkCustomAttributes = "";
            $this->NB_BABY->HrefValue = "";

            // BABY_DIE
            $this->BABY_DIE->LinkCustomAttributes = "";
            $this->BABY_DIE->HrefValue = "";

            // ABORTUS_KE
            $this->ABORTUS_KE->LinkCustomAttributes = "";
            $this->ABORTUS_KE->HrefValue = "";

            // ABORTUS_ID
            $this->ABORTUS_ID->LinkCustomAttributes = "";
            $this->ABORTUS_ID->HrefValue = "";

            // ABORTION_DATE
            $this->ABORTION_DATE->LinkCustomAttributes = "";
            $this->ABORTION_DATE->HrefValue = "";

            // BIRTH_CAT
            $this->BIRTH_CAT->LinkCustomAttributes = "";
            $this->BIRTH_CAT->HrefValue = "";

            // BIRTH_CON
            $this->BIRTH_CON->LinkCustomAttributes = "";
            $this->BIRTH_CON->HrefValue = "";

            // BIRTH_RISK
            $this->BIRTH_RISK->LinkCustomAttributes = "";
            $this->BIRTH_RISK->HrefValue = "";

            // RISK_TYPE
            $this->RISK_TYPE->LinkCustomAttributes = "";
            $this->RISK_TYPE->HrefValue = "";

            // FOLLOW_UP
            $this->FOLLOW_UP->LinkCustomAttributes = "";
            $this->FOLLOW_UP->HrefValue = "";

            // DIRUJUK_OLEH
            $this->DIRUJUK_OLEH->LinkCustomAttributes = "";
            $this->DIRUJUK_OLEH->HrefValue = "";

            // INSPECTION_DATE
            $this->INSPECTION_DATE->LinkCustomAttributes = "";
            $this->INSPECTION_DATE->HrefValue = "";

            // PORSIO
            $this->PORSIO->LinkCustomAttributes = "";
            $this->PORSIO->HrefValue = "";

            // PEMBUKAAN
            $this->PEMBUKAAN->LinkCustomAttributes = "";
            $this->PEMBUKAAN->HrefValue = "";

            // KETUBAN
            $this->KETUBAN->LinkCustomAttributes = "";
            $this->KETUBAN->HrefValue = "";

            // PRESENTASI
            $this->PRESENTASI->LinkCustomAttributes = "";
            $this->PRESENTASI->HrefValue = "";

            // POSISI
            $this->POSISI->LinkCustomAttributes = "";
            $this->POSISI->HrefValue = "";

            // PENURUNAN
            $this->PENURUNAN->LinkCustomAttributes = "";
            $this->PENURUNAN->HrefValue = "";

            // HEART_ID
            $this->HEART_ID->LinkCustomAttributes = "";
            $this->HEART_ID->HrefValue = "";

            // JANIN_ID
            $this->JANIN_ID->LinkCustomAttributes = "";
            $this->JANIN_ID->HrefValue = "";

            // FREK_DJJ
            $this->FREK_DJJ->LinkCustomAttributes = "";
            $this->FREK_DJJ->HrefValue = "";

            // PLACENTA
            $this->PLACENTA->LinkCustomAttributes = "";
            $this->PLACENTA->HrefValue = "";

            // LOCHIA
            $this->LOCHIA->LinkCustomAttributes = "";
            $this->LOCHIA->HrefValue = "";

            // BAB_TYPE
            $this->BAB_TYPE->LinkCustomAttributes = "";
            $this->BAB_TYPE->HrefValue = "";

            // BAB_BAB_TYPE
            $this->BAB_BAB_TYPE->LinkCustomAttributes = "";
            $this->BAB_BAB_TYPE->HrefValue = "";

            // RAHIM_ID
            $this->RAHIM_ID->LinkCustomAttributes = "";
            $this->RAHIM_ID->HrefValue = "";

            // BIR_RAHIM_ID
            $this->BIR_RAHIM_ID->LinkCustomAttributes = "";
            $this->BIR_RAHIM_ID->HrefValue = "";

            // VISIT_ID
            $this->VISIT_ID->LinkCustomAttributes = "";
            $this->VISIT_ID->HrefValue = "";

            // BLOODING
            $this->BLOODING->LinkCustomAttributes = "";
            $this->BLOODING->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // MODIFIED_FROM
            $this->MODIFIED_FROM->LinkCustomAttributes = "";
            $this->MODIFIED_FROM->HrefValue = "";

            // RAHIM_SALIN
            $this->RAHIM_SALIN->LinkCustomAttributes = "";
            $this->RAHIM_SALIN->HrefValue = "";

            // RAHIM_NIFAS
            $this->RAHIM_NIFAS->LinkCustomAttributes = "";
            $this->RAHIM_NIFAS->HrefValue = "";

            // BAK_TYPE
            $this->BAK_TYPE->LinkCustomAttributes = "";
            $this->BAK_TYPE->HrefValue = "";

            // THENAME
            $this->THENAME->LinkCustomAttributes = "";
            $this->THENAME->HrefValue = "";

            // THEADDRESS
            $this->THEADDRESS->LinkCustomAttributes = "";
            $this->THEADDRESS->HrefValue = "";

            // THEID
            $this->THEID->LinkCustomAttributes = "";
            $this->THEID->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // ISRJ
            $this->ISRJ->LinkCustomAttributes = "";
            $this->ISRJ->HrefValue = "";

            // AGEYEAR
            $this->AGEYEAR->LinkCustomAttributes = "";
            $this->AGEYEAR->HrefValue = "";

            // AGEMONTH
            $this->AGEMONTH->LinkCustomAttributes = "";
            $this->AGEMONTH->HrefValue = "";

            // AGEDAY
            $this->AGEDAY->LinkCustomAttributes = "";
            $this->AGEDAY->HrefValue = "";

            // GENDER
            $this->GENDER->LinkCustomAttributes = "";
            $this->GENDER->HrefValue = "";

            // CLASS_ROOM_ID
            $this->CLASS_ROOM_ID->LinkCustomAttributes = "";
            $this->CLASS_ROOM_ID->HrefValue = "";

            // BED_ID
            $this->BED_ID->LinkCustomAttributes = "";
            $this->BED_ID->HrefValue = "";

            // KELUAR_ID
            $this->KELUAR_ID->LinkCustomAttributes = "";
            $this->KELUAR_ID->HrefValue = "";

            // DOCTOR
            $this->DOCTOR->LinkCustomAttributes = "";
            $this->DOCTOR->HrefValue = "";

            // NB_OBSTETRI
            $this->NB_OBSTETRI->LinkCustomAttributes = "";
            $this->NB_OBSTETRI->HrefValue = "";

            // OBSTETRI_DIE
            $this->OBSTETRI_DIE->LinkCustomAttributes = "";
            $this->OBSTETRI_DIE->HrefValue = "";

            // KAL_ID
            $this->KAL_ID->LinkCustomAttributes = "";
            $this->KAL_ID->HrefValue = "";

            // DIAGNOSA_ID2
            $this->DIAGNOSA_ID2->LinkCustomAttributes = "";
            $this->DIAGNOSA_ID2->HrefValue = "";

            // APGAR_ID
            $this->APGAR_ID->LinkCustomAttributes = "";
            $this->APGAR_ID->HrefValue = "";

            // BIRTH_LAST_ID
            $this->BIRTH_LAST_ID->LinkCustomAttributes = "";
            $this->BIRTH_LAST_ID->HrefValue = "";
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
        if ($this->OBSTETRI_ID->Required) {
            if (!$this->OBSTETRI_ID->IsDetailKey && EmptyValue($this->OBSTETRI_ID->FormValue)) {
                $this->OBSTETRI_ID->addErrorMessage(str_replace("%s", $this->OBSTETRI_ID->caption(), $this->OBSTETRI_ID->RequiredErrorMessage));
            }
        }
        if ($this->HPHT->Required) {
            if (!$this->HPHT->IsDetailKey && EmptyValue($this->HPHT->FormValue)) {
                $this->HPHT->addErrorMessage(str_replace("%s", $this->HPHT->caption(), $this->HPHT->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->HPHT->FormValue)) {
            $this->HPHT->addErrorMessage($this->HPHT->getErrorMessage(false));
        }
        if ($this->HTP->Required) {
            if (!$this->HTP->IsDetailKey && EmptyValue($this->HTP->FormValue)) {
                $this->HTP->addErrorMessage(str_replace("%s", $this->HTP->caption(), $this->HTP->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->HTP->FormValue)) {
            $this->HTP->addErrorMessage($this->HTP->getErrorMessage(false));
        }
        if ($this->PASIEN_DIAGNOSA_ID->Required) {
            if (!$this->PASIEN_DIAGNOSA_ID->IsDetailKey && EmptyValue($this->PASIEN_DIAGNOSA_ID->FormValue)) {
                $this->PASIEN_DIAGNOSA_ID->addErrorMessage(str_replace("%s", $this->PASIEN_DIAGNOSA_ID->caption(), $this->PASIEN_DIAGNOSA_ID->RequiredErrorMessage));
            }
        }
        if ($this->DIAGNOSA_ID->Required) {
            if (!$this->DIAGNOSA_ID->IsDetailKey && EmptyValue($this->DIAGNOSA_ID->FormValue)) {
                $this->DIAGNOSA_ID->addErrorMessage(str_replace("%s", $this->DIAGNOSA_ID->caption(), $this->DIAGNOSA_ID->RequiredErrorMessage));
            }
        }
        if ($this->NO_REGISTRATION->Required) {
            if (!$this->NO_REGISTRATION->IsDetailKey && EmptyValue($this->NO_REGISTRATION->FormValue)) {
                $this->NO_REGISTRATION->addErrorMessage(str_replace("%s", $this->NO_REGISTRATION->caption(), $this->NO_REGISTRATION->RequiredErrorMessage));
            }
        }
        if ($this->KOHORT_NB->Required) {
            if (!$this->KOHORT_NB->IsDetailKey && EmptyValue($this->KOHORT_NB->FormValue)) {
                $this->KOHORT_NB->addErrorMessage(str_replace("%s", $this->KOHORT_NB->caption(), $this->KOHORT_NB->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_NB->Required) {
            if (!$this->BIRTH_NB->IsDetailKey && EmptyValue($this->BIRTH_NB->FormValue)) {
                $this->BIRTH_NB->addErrorMessage(str_replace("%s", $this->BIRTH_NB->caption(), $this->BIRTH_NB->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_NB->FormValue)) {
            $this->BIRTH_NB->addErrorMessage($this->BIRTH_NB->getErrorMessage(false));
        }
        if ($this->BIRTH_DURATION->Required) {
            if (!$this->BIRTH_DURATION->IsDetailKey && EmptyValue($this->BIRTH_DURATION->FormValue)) {
                $this->BIRTH_DURATION->addErrorMessage(str_replace("%s", $this->BIRTH_DURATION->caption(), $this->BIRTH_DURATION->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_DURATION->FormValue)) {
            $this->BIRTH_DURATION->addErrorMessage($this->BIRTH_DURATION->getErrorMessage(false));
        }
        if ($this->BIRTH_PLACE->Required) {
            if (!$this->BIRTH_PLACE->IsDetailKey && EmptyValue($this->BIRTH_PLACE->FormValue)) {
                $this->BIRTH_PLACE->addErrorMessage(str_replace("%s", $this->BIRTH_PLACE->caption(), $this->BIRTH_PLACE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_PLACE->FormValue)) {
            $this->BIRTH_PLACE->addErrorMessage($this->BIRTH_PLACE->getErrorMessage(false));
        }
        if ($this->ANTE_NATAL->Required) {
            if (!$this->ANTE_NATAL->IsDetailKey && EmptyValue($this->ANTE_NATAL->FormValue)) {
                $this->ANTE_NATAL->addErrorMessage(str_replace("%s", $this->ANTE_NATAL->caption(), $this->ANTE_NATAL->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ANTE_NATAL->FormValue)) {
            $this->ANTE_NATAL->addErrorMessage($this->ANTE_NATAL->getErrorMessage(false));
        }
        if ($this->EMPLOYEE_ID->Required) {
            if (!$this->EMPLOYEE_ID->IsDetailKey && EmptyValue($this->EMPLOYEE_ID->FormValue)) {
                $this->EMPLOYEE_ID->addErrorMessage(str_replace("%s", $this->EMPLOYEE_ID->caption(), $this->EMPLOYEE_ID->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_WAY->Required) {
            if (!$this->BIRTH_WAY->IsDetailKey && EmptyValue($this->BIRTH_WAY->FormValue)) {
                $this->BIRTH_WAY->addErrorMessage(str_replace("%s", $this->BIRTH_WAY->caption(), $this->BIRTH_WAY->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_BY->Required) {
            if (!$this->BIRTH_BY->IsDetailKey && EmptyValue($this->BIRTH_BY->FormValue)) {
                $this->BIRTH_BY->addErrorMessage(str_replace("%s", $this->BIRTH_BY->caption(), $this->BIRTH_BY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_BY->FormValue)) {
            $this->BIRTH_BY->addErrorMessage($this->BIRTH_BY->getErrorMessage(false));
        }
        if ($this->BIRTH_DATE->Required) {
            if (!$this->BIRTH_DATE->IsDetailKey && EmptyValue($this->BIRTH_DATE->FormValue)) {
                $this->BIRTH_DATE->addErrorMessage(str_replace("%s", $this->BIRTH_DATE->caption(), $this->BIRTH_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->BIRTH_DATE->FormValue)) {
            $this->BIRTH_DATE->addErrorMessage($this->BIRTH_DATE->getErrorMessage(false));
        }
        if ($this->GESTASI->Required) {
            if (!$this->GESTASI->IsDetailKey && EmptyValue($this->GESTASI->FormValue)) {
                $this->GESTASI->addErrorMessage(str_replace("%s", $this->GESTASI->caption(), $this->GESTASI->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->GESTASI->FormValue)) {
            $this->GESTASI->addErrorMessage($this->GESTASI->getErrorMessage(false));
        }
        if ($this->PARITY->Required) {
            if (!$this->PARITY->IsDetailKey && EmptyValue($this->PARITY->FormValue)) {
                $this->PARITY->addErrorMessage(str_replace("%s", $this->PARITY->caption(), $this->PARITY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PARITY->FormValue)) {
            $this->PARITY->addErrorMessage($this->PARITY->getErrorMessage(false));
        }
        if ($this->NB_BABY->Required) {
            if (!$this->NB_BABY->IsDetailKey && EmptyValue($this->NB_BABY->FormValue)) {
                $this->NB_BABY->addErrorMessage(str_replace("%s", $this->NB_BABY->caption(), $this->NB_BABY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->NB_BABY->FormValue)) {
            $this->NB_BABY->addErrorMessage($this->NB_BABY->getErrorMessage(false));
        }
        if ($this->BABY_DIE->Required) {
            if (!$this->BABY_DIE->IsDetailKey && EmptyValue($this->BABY_DIE->FormValue)) {
                $this->BABY_DIE->addErrorMessage(str_replace("%s", $this->BABY_DIE->caption(), $this->BABY_DIE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BABY_DIE->FormValue)) {
            $this->BABY_DIE->addErrorMessage($this->BABY_DIE->getErrorMessage(false));
        }
        if ($this->ABORTUS_KE->Required) {
            if (!$this->ABORTUS_KE->IsDetailKey && EmptyValue($this->ABORTUS_KE->FormValue)) {
                $this->ABORTUS_KE->addErrorMessage(str_replace("%s", $this->ABORTUS_KE->caption(), $this->ABORTUS_KE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ABORTUS_KE->FormValue)) {
            $this->ABORTUS_KE->addErrorMessage($this->ABORTUS_KE->getErrorMessage(false));
        }
        if ($this->ABORTUS_ID->Required) {
            if (!$this->ABORTUS_ID->IsDetailKey && EmptyValue($this->ABORTUS_ID->FormValue)) {
                $this->ABORTUS_ID->addErrorMessage(str_replace("%s", $this->ABORTUS_ID->caption(), $this->ABORTUS_ID->RequiredErrorMessage));
            }
        }
        if ($this->ABORTION_DATE->Required) {
            if (!$this->ABORTION_DATE->IsDetailKey && EmptyValue($this->ABORTION_DATE->FormValue)) {
                $this->ABORTION_DATE->addErrorMessage(str_replace("%s", $this->ABORTION_DATE->caption(), $this->ABORTION_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ABORTION_DATE->FormValue)) {
            $this->ABORTION_DATE->addErrorMessage($this->ABORTION_DATE->getErrorMessage(false));
        }
        if ($this->BIRTH_CAT->Required) {
            if (!$this->BIRTH_CAT->IsDetailKey && EmptyValue($this->BIRTH_CAT->FormValue)) {
                $this->BIRTH_CAT->addErrorMessage(str_replace("%s", $this->BIRTH_CAT->caption(), $this->BIRTH_CAT->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_CON->Required) {
            if (!$this->BIRTH_CON->IsDetailKey && EmptyValue($this->BIRTH_CON->FormValue)) {
                $this->BIRTH_CON->addErrorMessage(str_replace("%s", $this->BIRTH_CON->caption(), $this->BIRTH_CON->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_CON->FormValue)) {
            $this->BIRTH_CON->addErrorMessage($this->BIRTH_CON->getErrorMessage(false));
        }
        if ($this->BIRTH_RISK->Required) {
            if (!$this->BIRTH_RISK->IsDetailKey && EmptyValue($this->BIRTH_RISK->FormValue)) {
                $this->BIRTH_RISK->addErrorMessage(str_replace("%s", $this->BIRTH_RISK->caption(), $this->BIRTH_RISK->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BIRTH_RISK->FormValue)) {
            $this->BIRTH_RISK->addErrorMessage($this->BIRTH_RISK->getErrorMessage(false));
        }
        if ($this->RISK_TYPE->Required) {
            if (!$this->RISK_TYPE->IsDetailKey && EmptyValue($this->RISK_TYPE->FormValue)) {
                $this->RISK_TYPE->addErrorMessage(str_replace("%s", $this->RISK_TYPE->caption(), $this->RISK_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->RISK_TYPE->FormValue)) {
            $this->RISK_TYPE->addErrorMessage($this->RISK_TYPE->getErrorMessage(false));
        }
        if ($this->FOLLOW_UP->Required) {
            if (!$this->FOLLOW_UP->IsDetailKey && EmptyValue($this->FOLLOW_UP->FormValue)) {
                $this->FOLLOW_UP->addErrorMessage(str_replace("%s", $this->FOLLOW_UP->caption(), $this->FOLLOW_UP->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->FOLLOW_UP->FormValue)) {
            $this->FOLLOW_UP->addErrorMessage($this->FOLLOW_UP->getErrorMessage(false));
        }
        if ($this->DIRUJUK_OLEH->Required) {
            if (!$this->DIRUJUK_OLEH->IsDetailKey && EmptyValue($this->DIRUJUK_OLEH->FormValue)) {
                $this->DIRUJUK_OLEH->addErrorMessage(str_replace("%s", $this->DIRUJUK_OLEH->caption(), $this->DIRUJUK_OLEH->RequiredErrorMessage));
            }
        }
        if ($this->INSPECTION_DATE->Required) {
            if (!$this->INSPECTION_DATE->IsDetailKey && EmptyValue($this->INSPECTION_DATE->FormValue)) {
                $this->INSPECTION_DATE->addErrorMessage(str_replace("%s", $this->INSPECTION_DATE->caption(), $this->INSPECTION_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->INSPECTION_DATE->FormValue)) {
            $this->INSPECTION_DATE->addErrorMessage($this->INSPECTION_DATE->getErrorMessage(false));
        }
        if ($this->PORSIO->Required) {
            if (!$this->PORSIO->IsDetailKey && EmptyValue($this->PORSIO->FormValue)) {
                $this->PORSIO->addErrorMessage(str_replace("%s", $this->PORSIO->caption(), $this->PORSIO->RequiredErrorMessage));
            }
        }
        if ($this->PEMBUKAAN->Required) {
            if (!$this->PEMBUKAAN->IsDetailKey && EmptyValue($this->PEMBUKAAN->FormValue)) {
                $this->PEMBUKAAN->addErrorMessage(str_replace("%s", $this->PEMBUKAAN->caption(), $this->PEMBUKAAN->RequiredErrorMessage));
            }
        }
        if ($this->KETUBAN->Required) {
            if (!$this->KETUBAN->IsDetailKey && EmptyValue($this->KETUBAN->FormValue)) {
                $this->KETUBAN->addErrorMessage(str_replace("%s", $this->KETUBAN->caption(), $this->KETUBAN->RequiredErrorMessage));
            }
        }
        if ($this->PRESENTASI->Required) {
            if (!$this->PRESENTASI->IsDetailKey && EmptyValue($this->PRESENTASI->FormValue)) {
                $this->PRESENTASI->addErrorMessage(str_replace("%s", $this->PRESENTASI->caption(), $this->PRESENTASI->RequiredErrorMessage));
            }
        }
        if ($this->POSISI->Required) {
            if (!$this->POSISI->IsDetailKey && EmptyValue($this->POSISI->FormValue)) {
                $this->POSISI->addErrorMessage(str_replace("%s", $this->POSISI->caption(), $this->POSISI->RequiredErrorMessage));
            }
        }
        if ($this->PENURUNAN->Required) {
            if (!$this->PENURUNAN->IsDetailKey && EmptyValue($this->PENURUNAN->FormValue)) {
                $this->PENURUNAN->addErrorMessage(str_replace("%s", $this->PENURUNAN->caption(), $this->PENURUNAN->RequiredErrorMessage));
            }
        }
        if ($this->HEART_ID->Required) {
            if (!$this->HEART_ID->IsDetailKey && EmptyValue($this->HEART_ID->FormValue)) {
                $this->HEART_ID->addErrorMessage(str_replace("%s", $this->HEART_ID->caption(), $this->HEART_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->HEART_ID->FormValue)) {
            $this->HEART_ID->addErrorMessage($this->HEART_ID->getErrorMessage(false));
        }
        if ($this->JANIN_ID->Required) {
            if (!$this->JANIN_ID->IsDetailKey && EmptyValue($this->JANIN_ID->FormValue)) {
                $this->JANIN_ID->addErrorMessage(str_replace("%s", $this->JANIN_ID->caption(), $this->JANIN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->JANIN_ID->FormValue)) {
            $this->JANIN_ID->addErrorMessage($this->JANIN_ID->getErrorMessage(false));
        }
        if ($this->FREK_DJJ->Required) {
            if (!$this->FREK_DJJ->IsDetailKey && EmptyValue($this->FREK_DJJ->FormValue)) {
                $this->FREK_DJJ->addErrorMessage(str_replace("%s", $this->FREK_DJJ->caption(), $this->FREK_DJJ->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->FREK_DJJ->FormValue)) {
            $this->FREK_DJJ->addErrorMessage($this->FREK_DJJ->getErrorMessage(false));
        }
        if ($this->PLACENTA->Required) {
            if (!$this->PLACENTA->IsDetailKey && EmptyValue($this->PLACENTA->FormValue)) {
                $this->PLACENTA->addErrorMessage(str_replace("%s", $this->PLACENTA->caption(), $this->PLACENTA->RequiredErrorMessage));
            }
        }
        if ($this->LOCHIA->Required) {
            if (!$this->LOCHIA->IsDetailKey && EmptyValue($this->LOCHIA->FormValue)) {
                $this->LOCHIA->addErrorMessage(str_replace("%s", $this->LOCHIA->caption(), $this->LOCHIA->RequiredErrorMessage));
            }
        }
        if ($this->BAB_TYPE->Required) {
            if (!$this->BAB_TYPE->IsDetailKey && EmptyValue($this->BAB_TYPE->FormValue)) {
                $this->BAB_TYPE->addErrorMessage(str_replace("%s", $this->BAB_TYPE->caption(), $this->BAB_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BAB_TYPE->FormValue)) {
            $this->BAB_TYPE->addErrorMessage($this->BAB_TYPE->getErrorMessage(false));
        }
        if ($this->BAB_BAB_TYPE->Required) {
            if (!$this->BAB_BAB_TYPE->IsDetailKey && EmptyValue($this->BAB_BAB_TYPE->FormValue)) {
                $this->BAB_BAB_TYPE->addErrorMessage(str_replace("%s", $this->BAB_BAB_TYPE->caption(), $this->BAB_BAB_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BAB_BAB_TYPE->FormValue)) {
            $this->BAB_BAB_TYPE->addErrorMessage($this->BAB_BAB_TYPE->getErrorMessage(false));
        }
        if ($this->RAHIM_ID->Required) {
            if (!$this->RAHIM_ID->IsDetailKey && EmptyValue($this->RAHIM_ID->FormValue)) {
                $this->RAHIM_ID->addErrorMessage(str_replace("%s", $this->RAHIM_ID->caption(), $this->RAHIM_ID->RequiredErrorMessage));
            }
        }
        if ($this->BIR_RAHIM_ID->Required) {
            if (!$this->BIR_RAHIM_ID->IsDetailKey && EmptyValue($this->BIR_RAHIM_ID->FormValue)) {
                $this->BIR_RAHIM_ID->addErrorMessage(str_replace("%s", $this->BIR_RAHIM_ID->caption(), $this->BIR_RAHIM_ID->RequiredErrorMessage));
            }
        }
        if ($this->VISIT_ID->Required) {
            if (!$this->VISIT_ID->IsDetailKey && EmptyValue($this->VISIT_ID->FormValue)) {
                $this->VISIT_ID->addErrorMessage(str_replace("%s", $this->VISIT_ID->caption(), $this->VISIT_ID->RequiredErrorMessage));
            }
        }
        if ($this->BLOODING->Required) {
            if (!$this->BLOODING->IsDetailKey && EmptyValue($this->BLOODING->FormValue)) {
                $this->BLOODING->addErrorMessage(str_replace("%s", $this->BLOODING->caption(), $this->BLOODING->RequiredErrorMessage));
            }
        }
        if ($this->DESCRIPTION->Required) {
            if (!$this->DESCRIPTION->IsDetailKey && EmptyValue($this->DESCRIPTION->FormValue)) {
                $this->DESCRIPTION->addErrorMessage(str_replace("%s", $this->DESCRIPTION->caption(), $this->DESCRIPTION->RequiredErrorMessage));
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
        if ($this->MODIFIED_FROM->Required) {
            if (!$this->MODIFIED_FROM->IsDetailKey && EmptyValue($this->MODIFIED_FROM->FormValue)) {
                $this->MODIFIED_FROM->addErrorMessage(str_replace("%s", $this->MODIFIED_FROM->caption(), $this->MODIFIED_FROM->RequiredErrorMessage));
            }
        }
        if ($this->RAHIM_SALIN->Required) {
            if (!$this->RAHIM_SALIN->IsDetailKey && EmptyValue($this->RAHIM_SALIN->FormValue)) {
                $this->RAHIM_SALIN->addErrorMessage(str_replace("%s", $this->RAHIM_SALIN->caption(), $this->RAHIM_SALIN->RequiredErrorMessage));
            }
        }
        if ($this->RAHIM_NIFAS->Required) {
            if (!$this->RAHIM_NIFAS->IsDetailKey && EmptyValue($this->RAHIM_NIFAS->FormValue)) {
                $this->RAHIM_NIFAS->addErrorMessage(str_replace("%s", $this->RAHIM_NIFAS->caption(), $this->RAHIM_NIFAS->RequiredErrorMessage));
            }
        }
        if ($this->BAK_TYPE->Required) {
            if (!$this->BAK_TYPE->IsDetailKey && EmptyValue($this->BAK_TYPE->FormValue)) {
                $this->BAK_TYPE->addErrorMessage(str_replace("%s", $this->BAK_TYPE->caption(), $this->BAK_TYPE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BAK_TYPE->FormValue)) {
            $this->BAK_TYPE->addErrorMessage($this->BAK_TYPE->getErrorMessage(false));
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
        if ($this->STATUS_PASIEN_ID->Required) {
            if (!$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_PASIEN_ID->FormValue)) {
            $this->STATUS_PASIEN_ID->addErrorMessage($this->STATUS_PASIEN_ID->getErrorMessage(false));
        }
        if ($this->ISRJ->Required) {
            if (!$this->ISRJ->IsDetailKey && EmptyValue($this->ISRJ->FormValue)) {
                $this->ISRJ->addErrorMessage(str_replace("%s", $this->ISRJ->caption(), $this->ISRJ->RequiredErrorMessage));
            }
        }
        if ($this->AGEYEAR->Required) {
            if (!$this->AGEYEAR->IsDetailKey && EmptyValue($this->AGEYEAR->FormValue)) {
                $this->AGEYEAR->addErrorMessage(str_replace("%s", $this->AGEYEAR->caption(), $this->AGEYEAR->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEYEAR->FormValue)) {
            $this->AGEYEAR->addErrorMessage($this->AGEYEAR->getErrorMessage(false));
        }
        if ($this->AGEMONTH->Required) {
            if (!$this->AGEMONTH->IsDetailKey && EmptyValue($this->AGEMONTH->FormValue)) {
                $this->AGEMONTH->addErrorMessage(str_replace("%s", $this->AGEMONTH->caption(), $this->AGEMONTH->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEMONTH->FormValue)) {
            $this->AGEMONTH->addErrorMessage($this->AGEMONTH->getErrorMessage(false));
        }
        if ($this->AGEDAY->Required) {
            if (!$this->AGEDAY->IsDetailKey && EmptyValue($this->AGEDAY->FormValue)) {
                $this->AGEDAY->addErrorMessage(str_replace("%s", $this->AGEDAY->caption(), $this->AGEDAY->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->AGEDAY->FormValue)) {
            $this->AGEDAY->addErrorMessage($this->AGEDAY->getErrorMessage(false));
        }
        if ($this->GENDER->Required) {
            if (!$this->GENDER->IsDetailKey && EmptyValue($this->GENDER->FormValue)) {
                $this->GENDER->addErrorMessage(str_replace("%s", $this->GENDER->caption(), $this->GENDER->RequiredErrorMessage));
            }
        }
        if ($this->CLASS_ROOM_ID->Required) {
            if (!$this->CLASS_ROOM_ID->IsDetailKey && EmptyValue($this->CLASS_ROOM_ID->FormValue)) {
                $this->CLASS_ROOM_ID->addErrorMessage(str_replace("%s", $this->CLASS_ROOM_ID->caption(), $this->CLASS_ROOM_ID->RequiredErrorMessage));
            }
        }
        if ($this->BED_ID->Required) {
            if (!$this->BED_ID->IsDetailKey && EmptyValue($this->BED_ID->FormValue)) {
                $this->BED_ID->addErrorMessage(str_replace("%s", $this->BED_ID->caption(), $this->BED_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->BED_ID->FormValue)) {
            $this->BED_ID->addErrorMessage($this->BED_ID->getErrorMessage(false));
        }
        if ($this->KELUAR_ID->Required) {
            if (!$this->KELUAR_ID->IsDetailKey && EmptyValue($this->KELUAR_ID->FormValue)) {
                $this->KELUAR_ID->addErrorMessage(str_replace("%s", $this->KELUAR_ID->caption(), $this->KELUAR_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->KELUAR_ID->FormValue)) {
            $this->KELUAR_ID->addErrorMessage($this->KELUAR_ID->getErrorMessage(false));
        }
        if ($this->DOCTOR->Required) {
            if (!$this->DOCTOR->IsDetailKey && EmptyValue($this->DOCTOR->FormValue)) {
                $this->DOCTOR->addErrorMessage(str_replace("%s", $this->DOCTOR->caption(), $this->DOCTOR->RequiredErrorMessage));
            }
        }
        if ($this->NB_OBSTETRI->Required) {
            if (!$this->NB_OBSTETRI->IsDetailKey && EmptyValue($this->NB_OBSTETRI->FormValue)) {
                $this->NB_OBSTETRI->addErrorMessage(str_replace("%s", $this->NB_OBSTETRI->caption(), $this->NB_OBSTETRI->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->NB_OBSTETRI->FormValue)) {
            $this->NB_OBSTETRI->addErrorMessage($this->NB_OBSTETRI->getErrorMessage(false));
        }
        if ($this->OBSTETRI_DIE->Required) {
            if (!$this->OBSTETRI_DIE->IsDetailKey && EmptyValue($this->OBSTETRI_DIE->FormValue)) {
                $this->OBSTETRI_DIE->addErrorMessage(str_replace("%s", $this->OBSTETRI_DIE->caption(), $this->OBSTETRI_DIE->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->OBSTETRI_DIE->FormValue)) {
            $this->OBSTETRI_DIE->addErrorMessage($this->OBSTETRI_DIE->getErrorMessage(false));
        }
        if ($this->KAL_ID->Required) {
            if (!$this->KAL_ID->IsDetailKey && EmptyValue($this->KAL_ID->FormValue)) {
                $this->KAL_ID->addErrorMessage(str_replace("%s", $this->KAL_ID->caption(), $this->KAL_ID->RequiredErrorMessage));
            }
        }
        if ($this->DIAGNOSA_ID2->Required) {
            if (!$this->DIAGNOSA_ID2->IsDetailKey && EmptyValue($this->DIAGNOSA_ID2->FormValue)) {
                $this->DIAGNOSA_ID2->addErrorMessage(str_replace("%s", $this->DIAGNOSA_ID2->caption(), $this->DIAGNOSA_ID2->RequiredErrorMessage));
            }
        }
        if ($this->APGAR_ID->Required) {
            if (!$this->APGAR_ID->IsDetailKey && EmptyValue($this->APGAR_ID->FormValue)) {
                $this->APGAR_ID->addErrorMessage(str_replace("%s", $this->APGAR_ID->caption(), $this->APGAR_ID->RequiredErrorMessage));
            }
        }
        if ($this->BIRTH_LAST_ID->Required) {
            if (!$this->BIRTH_LAST_ID->IsDetailKey && EmptyValue($this->BIRTH_LAST_ID->FormValue)) {
                $this->BIRTH_LAST_ID->addErrorMessage(str_replace("%s", $this->BIRTH_LAST_ID->caption(), $this->BIRTH_LAST_ID->RequiredErrorMessage));
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

        // OBSTETRI_ID
        $this->OBSTETRI_ID->setDbValueDef($rsnew, $this->OBSTETRI_ID->CurrentValue, "", strval($this->OBSTETRI_ID->CurrentValue) == "");

        // HPHT
        $this->HPHT->setDbValueDef($rsnew, UnFormatDateTime($this->HPHT->CurrentValue, 0), null, false);

        // HTP
        $this->HTP->setDbValueDef($rsnew, UnFormatDateTime($this->HTP->CurrentValue, 0), null, false);

        // PASIEN_DIAGNOSA_ID
        $this->PASIEN_DIAGNOSA_ID->setDbValueDef($rsnew, $this->PASIEN_DIAGNOSA_ID->CurrentValue, null, false);

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->setDbValueDef($rsnew, $this->DIAGNOSA_ID->CurrentValue, null, false);

        // NO_REGISTRATION
        $this->NO_REGISTRATION->setDbValueDef($rsnew, $this->NO_REGISTRATION->CurrentValue, null, false);

        // KOHORT_NB
        $this->KOHORT_NB->setDbValueDef($rsnew, $this->KOHORT_NB->CurrentValue, null, false);

        // BIRTH_NB
        $this->BIRTH_NB->setDbValueDef($rsnew, $this->BIRTH_NB->CurrentValue, null, false);

        // BIRTH_DURATION
        $this->BIRTH_DURATION->setDbValueDef($rsnew, $this->BIRTH_DURATION->CurrentValue, null, false);

        // BIRTH_PLACE
        $this->BIRTH_PLACE->setDbValueDef($rsnew, $this->BIRTH_PLACE->CurrentValue, null, false);

        // ANTE_NATAL
        $this->ANTE_NATAL->setDbValueDef($rsnew, $this->ANTE_NATAL->CurrentValue, null, false);

        // EMPLOYEE_ID
        $this->EMPLOYEE_ID->setDbValueDef($rsnew, $this->EMPLOYEE_ID->CurrentValue, null, false);

        // CLINIC_ID
        $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, false);

        // BIRTH_WAY
        $this->BIRTH_WAY->setDbValueDef($rsnew, $this->BIRTH_WAY->CurrentValue, null, false);

        // BIRTH_BY
        $this->BIRTH_BY->setDbValueDef($rsnew, $this->BIRTH_BY->CurrentValue, null, false);

        // BIRTH_DATE
        $this->BIRTH_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->BIRTH_DATE->CurrentValue, 0), null, false);

        // GESTASI
        $this->GESTASI->setDbValueDef($rsnew, $this->GESTASI->CurrentValue, null, false);

        // PARITY
        $this->PARITY->setDbValueDef($rsnew, $this->PARITY->CurrentValue, null, false);

        // NB_BABY
        $this->NB_BABY->setDbValueDef($rsnew, $this->NB_BABY->CurrentValue, null, false);

        // BABY_DIE
        $this->BABY_DIE->setDbValueDef($rsnew, $this->BABY_DIE->CurrentValue, null, false);

        // ABORTUS_KE
        $this->ABORTUS_KE->setDbValueDef($rsnew, $this->ABORTUS_KE->CurrentValue, null, false);

        // ABORTUS_ID
        $this->ABORTUS_ID->setDbValueDef($rsnew, $this->ABORTUS_ID->CurrentValue, null, false);

        // ABORTION_DATE
        $this->ABORTION_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ABORTION_DATE->CurrentValue, 0), null, false);

        // BIRTH_CAT
        $this->BIRTH_CAT->setDbValueDef($rsnew, $this->BIRTH_CAT->CurrentValue, null, false);

        // BIRTH_CON
        $this->BIRTH_CON->setDbValueDef($rsnew, $this->BIRTH_CON->CurrentValue, null, false);

        // BIRTH_RISK
        $this->BIRTH_RISK->setDbValueDef($rsnew, $this->BIRTH_RISK->CurrentValue, null, false);

        // RISK_TYPE
        $this->RISK_TYPE->setDbValueDef($rsnew, $this->RISK_TYPE->CurrentValue, null, false);

        // FOLLOW_UP
        $this->FOLLOW_UP->setDbValueDef($rsnew, $this->FOLLOW_UP->CurrentValue, null, false);

        // DIRUJUK_OLEH
        $this->DIRUJUK_OLEH->setDbValueDef($rsnew, $this->DIRUJUK_OLEH->CurrentValue, null, false);

        // INSPECTION_DATE
        $this->INSPECTION_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->INSPECTION_DATE->CurrentValue, 0), null, false);

        // PORSIO
        $this->PORSIO->setDbValueDef($rsnew, $this->PORSIO->CurrentValue, null, false);

        // PEMBUKAAN
        $this->PEMBUKAAN->setDbValueDef($rsnew, $this->PEMBUKAAN->CurrentValue, null, false);

        // KETUBAN
        $this->KETUBAN->setDbValueDef($rsnew, $this->KETUBAN->CurrentValue, null, false);

        // PRESENTASI
        $this->PRESENTASI->setDbValueDef($rsnew, $this->PRESENTASI->CurrentValue, null, false);

        // POSISI
        $this->POSISI->setDbValueDef($rsnew, $this->POSISI->CurrentValue, null, false);

        // PENURUNAN
        $this->PENURUNAN->setDbValueDef($rsnew, $this->PENURUNAN->CurrentValue, null, false);

        // HEART_ID
        $this->HEART_ID->setDbValueDef($rsnew, $this->HEART_ID->CurrentValue, null, false);

        // JANIN_ID
        $this->JANIN_ID->setDbValueDef($rsnew, $this->JANIN_ID->CurrentValue, null, false);

        // FREK_DJJ
        $this->FREK_DJJ->setDbValueDef($rsnew, $this->FREK_DJJ->CurrentValue, null, false);

        // PLACENTA
        $this->PLACENTA->setDbValueDef($rsnew, $this->PLACENTA->CurrentValue, null, false);

        // LOCHIA
        $this->LOCHIA->setDbValueDef($rsnew, $this->LOCHIA->CurrentValue, null, false);

        // BAB_TYPE
        $this->BAB_TYPE->setDbValueDef($rsnew, $this->BAB_TYPE->CurrentValue, null, false);

        // BAB_BAB_TYPE
        $this->BAB_BAB_TYPE->setDbValueDef($rsnew, $this->BAB_BAB_TYPE->CurrentValue, null, false);

        // RAHIM_ID
        $this->RAHIM_ID->setDbValueDef($rsnew, $this->RAHIM_ID->CurrentValue, null, false);

        // BIR_RAHIM_ID
        $this->BIR_RAHIM_ID->setDbValueDef($rsnew, $this->BIR_RAHIM_ID->CurrentValue, null, false);

        // VISIT_ID
        $this->VISIT_ID->setDbValueDef($rsnew, $this->VISIT_ID->CurrentValue, null, false);

        // BLOODING
        $this->BLOODING->setDbValueDef($rsnew, $this->BLOODING->CurrentValue, null, false);

        // DESCRIPTION
        $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, false);

        // MODIFIED_DATE
        $this->MODIFIED_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 0), null, false);

        // MODIFIED_BY
        $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null, false);

        // MODIFIED_FROM
        $this->MODIFIED_FROM->setDbValueDef($rsnew, $this->MODIFIED_FROM->CurrentValue, null, false);

        // RAHIM_SALIN
        $this->RAHIM_SALIN->setDbValueDef($rsnew, $this->RAHIM_SALIN->CurrentValue, null, false);

        // RAHIM_NIFAS
        $this->RAHIM_NIFAS->setDbValueDef($rsnew, $this->RAHIM_NIFAS->CurrentValue, null, false);

        // BAK_TYPE
        $this->BAK_TYPE->setDbValueDef($rsnew, $this->BAK_TYPE->CurrentValue, null, false);

        // THENAME
        $this->THENAME->setDbValueDef($rsnew, $this->THENAME->CurrentValue, null, false);

        // THEADDRESS
        $this->THEADDRESS->setDbValueDef($rsnew, $this->THEADDRESS->CurrentValue, null, false);

        // THEID
        $this->THEID->setDbValueDef($rsnew, $this->THEID->CurrentValue, null, false);

        // STATUS_PASIEN_ID
        $this->STATUS_PASIEN_ID->setDbValueDef($rsnew, $this->STATUS_PASIEN_ID->CurrentValue, null, false);

        // ISRJ
        $this->ISRJ->setDbValueDef($rsnew, $this->ISRJ->CurrentValue, null, false);

        // AGEYEAR
        $this->AGEYEAR->setDbValueDef($rsnew, $this->AGEYEAR->CurrentValue, null, false);

        // AGEMONTH
        $this->AGEMONTH->setDbValueDef($rsnew, $this->AGEMONTH->CurrentValue, null, false);

        // AGEDAY
        $this->AGEDAY->setDbValueDef($rsnew, $this->AGEDAY->CurrentValue, null, false);

        // GENDER
        $this->GENDER->setDbValueDef($rsnew, $this->GENDER->CurrentValue, null, strval($this->GENDER->CurrentValue) == "");

        // CLASS_ROOM_ID
        $this->CLASS_ROOM_ID->setDbValueDef($rsnew, $this->CLASS_ROOM_ID->CurrentValue, null, false);

        // BED_ID
        $this->BED_ID->setDbValueDef($rsnew, $this->BED_ID->CurrentValue, null, false);

        // KELUAR_ID
        $this->KELUAR_ID->setDbValueDef($rsnew, $this->KELUAR_ID->CurrentValue, null, false);

        // DOCTOR
        $this->DOCTOR->setDbValueDef($rsnew, $this->DOCTOR->CurrentValue, null, false);

        // NB_OBSTETRI
        $this->NB_OBSTETRI->setDbValueDef($rsnew, $this->NB_OBSTETRI->CurrentValue, null, strval($this->NB_OBSTETRI->CurrentValue) == "");

        // OBSTETRI_DIE
        $this->OBSTETRI_DIE->setDbValueDef($rsnew, $this->OBSTETRI_DIE->CurrentValue, null, strval($this->OBSTETRI_DIE->CurrentValue) == "");

        // KAL_ID
        $this->KAL_ID->setDbValueDef($rsnew, $this->KAL_ID->CurrentValue, null, false);

        // DIAGNOSA_ID2
        $this->DIAGNOSA_ID2->setDbValueDef($rsnew, $this->DIAGNOSA_ID2->CurrentValue, null, false);

        // APGAR_ID
        $this->APGAR_ID->setDbValueDef($rsnew, $this->APGAR_ID->CurrentValue, null, false);

        // BIRTH_LAST_ID
        $this->BIRTH_LAST_ID->setDbValueDef($rsnew, $this->BIRTH_LAST_ID->CurrentValue, null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ObstetriList"), "", $this->TableVar, true);
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
