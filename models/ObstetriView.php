<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ObstetriView extends Obstetri
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'OBSTETRI';

    // Page object name
    public $PageObjName = "ObstetriView";

    // Rendering View
    public $RenderingView = false;

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
        if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
            $this->RecKey["ID"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

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

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

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
        $this->CurrentAction = Param("action"); // Set up current action
        $this->ORG_UNIT_CODE->setVisibility();
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

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->RecKey["ID"] = $this->ID->QueryStringValue;
            } elseif (Post("ID") !== null) {
                $this->ID->setFormValue(Post("ID"));
                $this->RecKey["ID"] = $this->ID->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->RecKey["ID"] = $this->ID->QueryStringValue;
            } else {
                $returnUrl = "ObstetriList"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "ObstetriList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "ObstetriList"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

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
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

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

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ObstetriList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
}
