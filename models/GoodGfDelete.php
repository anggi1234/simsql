<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodGfDelete extends GoodGf
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOOD_GF';

    // Page object name
    public $PageObjName = "GoodGfDelete";

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
        $this->ITEM_ID->Visible = false;
        $this->ORG_ID->setVisibility();
        $this->BATCH_NO->Visible = false;
        $this->BRAND_ID->setVisibility();
        $this->ROOMS_ID->setVisibility();
        $this->SHELF_NO->Visible = false;
        $this->EXPIRY_DATE->Visible = false;
        $this->SERIAL_NB->Visible = false;
        $this->FROM_ROOMS_ID->setVisibility();
        $this->ISOUTLET->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->DISTRIBUTION_TYPE->setVisibility();
        $this->CONDITION->setVisibility();
        $this->ALLOCATED_DATE->setVisibility();
        $this->STOCKOPNAME_DATE->setVisibility();
        $this->INVOICE_ID->Visible = false;
        $this->ALLOCATED_FROM->Visible = false;
        $this->PRICE->Visible = false;
        $this->DISCOUNT->Visible = false;
        $this->DISCOUNT2->Visible = false;
        $this->DISCOUNTOFF->Visible = false;
        $this->ORG_UNIT_FROM->setVisibility();
        $this->ITEM_ID_FROM->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->STOCK_OPNAME->setVisibility();
        $this->STOK_AWAL->setVisibility();
        $this->STOCK_LALU->Visible = false;
        $this->STOCK_KOREKSI->setVisibility();
        $this->DITERIMA->Visible = false;
        $this->DISTRIBUSI->Visible = false;
        $this->DIJUAL->Visible = false;
        $this->DIHAPUS->Visible = false;
        $this->DIMINTA->Visible = false;
        $this->DIRETUR->Visible = false;
        $this->PO->Visible = false;
        $this->COMPANY_ID->Visible = false;
        $this->FUND_ID->Visible = false;
        $this->INVOICE_ID2->Visible = false;
        $this->MEASURE_ID3->Visible = false;
        $this->SIZE_KEMASAN->Visible = false;
        $this->BRAND_NAME->setVisibility();
        $this->MEASURE_ID2->Visible = false;
        $this->RETUR_ID->Visible = false;
        $this->SIZE_GOODS->Visible = false;
        $this->MEASURE_DOSIS->Visible = false;
        $this->ORDER_PRICE->Visible = false;
        $this->STOCK_AVAILABLE->Visible = false;
        $this->STATUS_PASIEN_ID->Visible = false;
        $this->MONTH_ID->setVisibility();
        $this->YEAR_ID->setVisibility();
        $this->CORRECTION_DOC->Visible = false;
        $this->CORRECTIONS->Visible = false;
        $this->CORRECTION_DATE->Visible = false;
        $this->DOC_NO->setVisibility();
        $this->ORDER_ID->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->Visible = false;
        $this->PRINTED_BY->Visible = false;
        $this->PRINTQ->Visible = false;
        $this->avgprice->Visible = false;
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

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("GoodGfList"); // Prevent SQL injection, return to list
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
                $this->terminate("GoodGfList"); // Return to list
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
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['ITEM_ID'] = null;
        $row['ORG_ID'] = null;
        $row['BATCH_NO'] = null;
        $row['BRAND_ID'] = null;
        $row['ROOMS_ID'] = null;
        $row['SHELF_NO'] = null;
        $row['EXPIRY_DATE'] = null;
        $row['SERIAL_NB'] = null;
        $row['FROM_ROOMS_ID'] = null;
        $row['ISOUTLET'] = null;
        $row['QUANTITY'] = null;
        $row['MEASURE_ID'] = null;
        $row['DISTRIBUTION_TYPE'] = null;
        $row['CONDITION'] = null;
        $row['ALLOCATED_DATE'] = null;
        $row['STOCKOPNAME_DATE'] = null;
        $row['INVOICE_ID'] = null;
        $row['ALLOCATED_FROM'] = null;
        $row['PRICE'] = null;
        $row['DISCOUNT'] = null;
        $row['DISCOUNT2'] = null;
        $row['DISCOUNTOFF'] = null;
        $row['ORG_UNIT_FROM'] = null;
        $row['ITEM_ID_FROM'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['STOCK_OPNAME'] = null;
        $row['STOK_AWAL'] = null;
        $row['STOCK_LALU'] = null;
        $row['STOCK_KOREKSI'] = null;
        $row['DITERIMA'] = null;
        $row['DISTRIBUSI'] = null;
        $row['DIJUAL'] = null;
        $row['DIHAPUS'] = null;
        $row['DIMINTA'] = null;
        $row['DIRETUR'] = null;
        $row['PO'] = null;
        $row['COMPANY_ID'] = null;
        $row['FUND_ID'] = null;
        $row['INVOICE_ID2'] = null;
        $row['MEASURE_ID3'] = null;
        $row['SIZE_KEMASAN'] = null;
        $row['BRAND_NAME'] = null;
        $row['MEASURE_ID2'] = null;
        $row['RETUR_ID'] = null;
        $row['SIZE_GOODS'] = null;
        $row['MEASURE_DOSIS'] = null;
        $row['ORDER_PRICE'] = null;
        $row['STOCK_AVAILABLE'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['MONTH_ID'] = null;
        $row['YEAR_ID'] = null;
        $row['CORRECTION_DOC'] = null;
        $row['CORRECTIONS'] = null;
        $row['CORRECTION_DATE'] = null;
        $row['DOC_NO'] = null;
        $row['ORDER_ID'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['PRINTQ'] = null;
        $row['avgprice'] = null;
        $row['idx'] = null;
        return $row;
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
        if ($this->STOCK_OPNAME->FormValue == $this->STOCK_OPNAME->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_OPNAME->CurrentValue))) {
            $this->STOCK_OPNAME->CurrentValue = ConvertToFloatString($this->STOCK_OPNAME->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOK_AWAL->FormValue == $this->STOK_AWAL->CurrentValue && is_numeric(ConvertToFloatString($this->STOK_AWAL->CurrentValue))) {
            $this->STOK_AWAL->CurrentValue = ConvertToFloatString($this->STOK_AWAL->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->STOCK_KOREKSI->FormValue == $this->STOCK_KOREKSI->CurrentValue && is_numeric(ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue))) {
            $this->STOCK_KOREKSI->CurrentValue = ConvertToFloatString($this->STOCK_KOREKSI->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // ITEM_ID
        $this->ITEM_ID->CellCssStyle = "white-space: nowrap;";

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

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // ROOMS_ID
            $this->ROOMS_ID->LinkCustomAttributes = "";
            $this->ROOMS_ID->HrefValue = "";
            $this->ROOMS_ID->TooltipValue = "";

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

            // STOCK_KOREKSI
            $this->STOCK_KOREKSI->LinkCustomAttributes = "";
            $this->STOCK_KOREKSI->HrefValue = "";
            $this->STOCK_KOREKSI->TooltipValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";
            $this->BRAND_NAME->TooltipValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";
            $this->MONTH_ID->TooltipValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";
            $this->YEAR_ID->TooltipValue = "";

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
                $thisKey .= $row['idx'];
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
}
