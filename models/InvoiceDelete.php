<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class InvoiceDelete extends Invoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'INVOICE';

    // Page object name
    public $PageObjName = "InvoiceDelete";

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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("InvoiceList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("InvoiceList"); // Return to list
                return;
            }
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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        $conn->beginTransaction();

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['ORG_UNIT_CODE'];
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['INVOICE_ID'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("InvoiceList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
