<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GoodsDelete extends Goods
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'GOODS';

    // Page object name
    public $PageObjName = "GoodsDelete";

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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("GoodsList"); // Prevent SQL injection, return to list
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
                $this->terminate("GoodsList"); // Return to list
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
        $row = [];
        $row['CODE_5'] = null;
        $row['BRAND_ID'] = null;
        $row['NAME'] = null;
        $row['OTHER_CODE'] = null;
        $row['BARCODE'] = null;
        $row['DESCRIPTION'] = null;
        $row['REORDER_POINT'] = null;
        $row['SIZE_GOODS'] = null;
        $row['MEASURE_DOSIS'] = null;
        $row['MEASURE_ID'] = null;
        $row['MEASURE_ID2'] = null;
        $row['SIZE_KEMASAN'] = null;
        $row['MEASURE_ID3'] = null;
        $row['COMPANY_ID'] = null;
        $row['NET_PRICE'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['TH'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['MATERIAL_ID'] = null;
        $row['FORM_ID'] = null;
        $row['ISGENERIC'] = null;
        $row['REGULATE_ID'] = null;
        $row['PREGNANCY_INDEX'] = null;
        $row['INDICATION'] = null;
        $row['TAKE_RULE'] = null;
        $row['SIDE_EFFECT'] = null;
        $row['INTERACTION'] = null;
        $row['CONTRA_INDICATION'] = null;
        $row['WARNING'] = null;
        $row['STOCK'] = null;
        $row['ISACTIVE'] = null;
        $row['ISALKES'] = null;
        $row['SIZE_ORDER'] = null;
        $row['ORDER_PRICE'] = null;
        $row['ISFORMULARIUM'] = null;
        $row['ISESSENTIAL'] = null;
        $row['AVGDATE'] = null;
        $row['STOCK_MINIMAL'] = null;
        $row['STOCK_MINIMAL_APT'] = null;
        $row['HET'] = null;
        $row['default_margin'] = null;
        return $row;
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
                $thisKey .= $row['BRAND_ID'];
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GoodsList"), "", $this->TableVar, true);
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
