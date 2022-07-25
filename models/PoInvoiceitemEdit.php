<?php

namespace PHPMaker2021\SIMRSSQLSERVER;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PoInvoiceitemEdit extends PoInvoiceitem
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'PO_INVOICEITEM';

    // Page object name
    public $PageObjName = "PoInvoiceitemEdit";

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

        // Table object (PO_INVOICEITEM)
        if (!isset($GLOBALS["PO_INVOICEITEM"]) || get_class($GLOBALS["PO_INVOICEITEM"]) == PROJECT_NAMESPACE . "PO_INVOICEITEM") {
            $GLOBALS["PO_INVOICEITEM"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'PO_INVOICEITEM');
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
                $doc = new $class(Container("PO_INVOICEITEM"));
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
                    if ($pageName == "PoInvoiceitemView") {
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
            $key .= @$ar['ITEM_ID'];
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
            $this->IDX->Visible = false;
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
        $this->ORG_UNIT_CODE->setVisibility();
        $this->ITEM_ID->setVisibility();
        $this->INVOICE_ID->setVisibility();
        $this->BRAND_ID->setVisibility();
        $this->BRAND_NAME->setVisibility();
        $this->ORDER_DATE->setVisibility();
        $this->ATP_DATE->setVisibility();
        $this->DELIVERY_DATE->setVisibility();
        $this->PO->setVisibility();
        $this->UNIT_PRICE->setVisibility();
        $this->COMPANY_ID->setVisibility();
        $this->ORDER_QUANTITY->setVisibility();
        $this->RECEIVED_QUANTITY->setVisibility();
        $this->DISCOUNT->setVisibility();
        $this->DISCOUNT2->setVisibility();
        $this->DISCOUNTOFF->setVisibility();
        $this->MEASURE_ID->setVisibility();
        $this->SIZE_GOODS->setVisibility();
        $this->MEASURE_DOSIS->setVisibility();
        $this->AMOUNT_PAID->setVisibility();
        $this->ORDER_PRICE->setVisibility();
        $this->QUANTITY->setVisibility();
        $this->MEASURE_ID3->setVisibility();
        $this->SIZE_KEMASAN->setVisibility();
        $this->MEASURE_ID2->setVisibility();
        $this->DESCRIPTION->setVisibility();
        $this->MODIFIED_DATE->setVisibility();
        $this->MODIFIED_BY->setVisibility();
        $this->ISCETAK->setVisibility();
        $this->PRINT_DATE->setVisibility();
        $this->PRINTED_BY->setVisibility();
        $this->PRINTQ->setVisibility();
        $this->BATCH_NO->setVisibility();
        $this->SERIAL_NB->setVisibility();
        $this->EXPIRY_DATE->setVisibility();
        $this->STATUS_PASIEN_ID->setVisibility();
        $this->MONTH_ID->setVisibility();
        $this->YEAR_ID->setVisibility();
        $this->IDX->setVisibility();
        $this->CLINIC_ID->setVisibility();
        $this->PPN->setVisibility();
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
            if (($keyValue = Get("ITEM_ID") ?? Key(1) ?? Route(3)) !== null) {
                $this->ITEM_ID->setQueryStringValue($keyValue);
                $this->ITEM_ID->setOldValue($this->ITEM_ID->QueryStringValue);
            } elseif (Post("ITEM_ID") !== null) {
                $this->ITEM_ID->setFormValue(Post("ITEM_ID"));
                $this->ITEM_ID->setOldValue($this->ITEM_ID->FormValue);
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
                if (($keyValue = Get("ITEM_ID") ?? Route("ITEM_ID")) !== null) {
                    $this->ITEM_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ITEM_ID->CurrentValue = null;
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
                    $this->terminate("PoInvoiceitemList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "PoInvoiceitemList") {
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

        // Check field name 'ITEM_ID' first before field var 'x_ITEM_ID'
        $val = $CurrentForm->hasValue("ITEM_ID") ? $CurrentForm->getValue("ITEM_ID") : $CurrentForm->getValue("x_ITEM_ID");
        if (!$this->ITEM_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ITEM_ID->Visible = false; // Disable update for API request
            } else {
                $this->ITEM_ID->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ITEM_ID")) {
            $this->ITEM_ID->setOldValue($CurrentForm->getValue("o_ITEM_ID"));
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

        // Check field name 'BRAND_ID' first before field var 'x_BRAND_ID'
        $val = $CurrentForm->hasValue("BRAND_ID") ? $CurrentForm->getValue("BRAND_ID") : $CurrentForm->getValue("x_BRAND_ID");
        if (!$this->BRAND_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_ID->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_ID->setFormValue($val);
            }
        }

        // Check field name 'BRAND_NAME' first before field var 'x_BRAND_NAME'
        $val = $CurrentForm->hasValue("BRAND_NAME") ? $CurrentForm->getValue("BRAND_NAME") : $CurrentForm->getValue("x_BRAND_NAME");
        if (!$this->BRAND_NAME->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BRAND_NAME->Visible = false; // Disable update for API request
            } else {
                $this->BRAND_NAME->setFormValue($val);
            }
        }

        // Check field name 'ORDER_DATE' first before field var 'x_ORDER_DATE'
        $val = $CurrentForm->hasValue("ORDER_DATE") ? $CurrentForm->getValue("ORDER_DATE") : $CurrentForm->getValue("x_ORDER_DATE");
        if (!$this->ORDER_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_DATE->setFormValue($val);
            }
            $this->ORDER_DATE->CurrentValue = UnFormatDateTime($this->ORDER_DATE->CurrentValue, 11);
        }

        // Check field name 'ATP_DATE' first before field var 'x_ATP_DATE'
        $val = $CurrentForm->hasValue("ATP_DATE") ? $CurrentForm->getValue("ATP_DATE") : $CurrentForm->getValue("x_ATP_DATE");
        if (!$this->ATP_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ATP_DATE->Visible = false; // Disable update for API request
            } else {
                $this->ATP_DATE->setFormValue($val);
            }
            $this->ATP_DATE->CurrentValue = UnFormatDateTime($this->ATP_DATE->CurrentValue, 11);
        }

        // Check field name 'DELIVERY_DATE' first before field var 'x_DELIVERY_DATE'
        $val = $CurrentForm->hasValue("DELIVERY_DATE") ? $CurrentForm->getValue("DELIVERY_DATE") : $CurrentForm->getValue("x_DELIVERY_DATE");
        if (!$this->DELIVERY_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DELIVERY_DATE->Visible = false; // Disable update for API request
            } else {
                $this->DELIVERY_DATE->setFormValue($val);
            }
            $this->DELIVERY_DATE->CurrentValue = UnFormatDateTime($this->DELIVERY_DATE->CurrentValue, 111);
        }

        // Check field name 'PO' first before field var 'x_PO'
        $val = $CurrentForm->hasValue("PO") ? $CurrentForm->getValue("PO") : $CurrentForm->getValue("x_PO");
        if (!$this->PO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PO->Visible = false; // Disable update for API request
            } else {
                $this->PO->setFormValue($val);
            }
        }

        // Check field name 'UNIT_PRICE' first before field var 'x_UNIT_PRICE'
        $val = $CurrentForm->hasValue("UNIT_PRICE") ? $CurrentForm->getValue("UNIT_PRICE") : $CurrentForm->getValue("x_UNIT_PRICE");
        if (!$this->UNIT_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UNIT_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->UNIT_PRICE->setFormValue($val);
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

        // Check field name 'ORDER_QUANTITY' first before field var 'x_ORDER_QUANTITY'
        $val = $CurrentForm->hasValue("ORDER_QUANTITY") ? $CurrentForm->getValue("ORDER_QUANTITY") : $CurrentForm->getValue("x_ORDER_QUANTITY");
        if (!$this->ORDER_QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_QUANTITY->setFormValue($val);
            }
        }

        // Check field name 'RECEIVED_QUANTITY' first before field var 'x_RECEIVED_QUANTITY'
        $val = $CurrentForm->hasValue("RECEIVED_QUANTITY") ? $CurrentForm->getValue("RECEIVED_QUANTITY") : $CurrentForm->getValue("x_RECEIVED_QUANTITY");
        if (!$this->RECEIVED_QUANTITY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->RECEIVED_QUANTITY->Visible = false; // Disable update for API request
            } else {
                $this->RECEIVED_QUANTITY->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT' first before field var 'x_DISCOUNT'
        $val = $CurrentForm->hasValue("DISCOUNT") ? $CurrentForm->getValue("DISCOUNT") : $CurrentForm->getValue("x_DISCOUNT");
        if (!$this->DISCOUNT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNT2' first before field var 'x_DISCOUNT2'
        $val = $CurrentForm->hasValue("DISCOUNT2") ? $CurrentForm->getValue("DISCOUNT2") : $CurrentForm->getValue("x_DISCOUNT2");
        if (!$this->DISCOUNT2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNT2->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNT2->setFormValue($val);
            }
        }

        // Check field name 'DISCOUNTOFF' first before field var 'x_DISCOUNTOFF'
        $val = $CurrentForm->hasValue("DISCOUNTOFF") ? $CurrentForm->getValue("DISCOUNTOFF") : $CurrentForm->getValue("x_DISCOUNTOFF");
        if (!$this->DISCOUNTOFF->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->DISCOUNTOFF->Visible = false; // Disable update for API request
            } else {
                $this->DISCOUNTOFF->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID' first before field var 'x_MEASURE_ID'
        $val = $CurrentForm->hasValue("MEASURE_ID") ? $CurrentForm->getValue("MEASURE_ID") : $CurrentForm->getValue("x_MEASURE_ID");
        if (!$this->MEASURE_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID->setFormValue($val);
            }
        }

        // Check field name 'SIZE_GOODS' first before field var 'x_SIZE_GOODS'
        $val = $CurrentForm->hasValue("SIZE_GOODS") ? $CurrentForm->getValue("SIZE_GOODS") : $CurrentForm->getValue("x_SIZE_GOODS");
        if (!$this->SIZE_GOODS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_GOODS->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_GOODS->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_DOSIS' first before field var 'x_MEASURE_DOSIS'
        $val = $CurrentForm->hasValue("MEASURE_DOSIS") ? $CurrentForm->getValue("MEASURE_DOSIS") : $CurrentForm->getValue("x_MEASURE_DOSIS");
        if (!$this->MEASURE_DOSIS->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_DOSIS->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_DOSIS->setFormValue($val);
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

        // Check field name 'ORDER_PRICE' first before field var 'x_ORDER_PRICE'
        $val = $CurrentForm->hasValue("ORDER_PRICE") ? $CurrentForm->getValue("ORDER_PRICE") : $CurrentForm->getValue("x_ORDER_PRICE");
        if (!$this->ORDER_PRICE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ORDER_PRICE->Visible = false; // Disable update for API request
            } else {
                $this->ORDER_PRICE->setFormValue($val);
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

        // Check field name 'MEASURE_ID3' first before field var 'x_MEASURE_ID3'
        $val = $CurrentForm->hasValue("MEASURE_ID3") ? $CurrentForm->getValue("MEASURE_ID3") : $CurrentForm->getValue("x_MEASURE_ID3");
        if (!$this->MEASURE_ID3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID3->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID3->setFormValue($val);
            }
        }

        // Check field name 'SIZE_KEMASAN' first before field var 'x_SIZE_KEMASAN'
        $val = $CurrentForm->hasValue("SIZE_KEMASAN") ? $CurrentForm->getValue("SIZE_KEMASAN") : $CurrentForm->getValue("x_SIZE_KEMASAN");
        if (!$this->SIZE_KEMASAN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SIZE_KEMASAN->Visible = false; // Disable update for API request
            } else {
                $this->SIZE_KEMASAN->setFormValue($val);
            }
        }

        // Check field name 'MEASURE_ID2' first before field var 'x_MEASURE_ID2'
        $val = $CurrentForm->hasValue("MEASURE_ID2") ? $CurrentForm->getValue("MEASURE_ID2") : $CurrentForm->getValue("x_MEASURE_ID2");
        if (!$this->MEASURE_ID2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MEASURE_ID2->Visible = false; // Disable update for API request
            } else {
                $this->MEASURE_ID2->setFormValue($val);
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
            $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
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

        // Check field name 'ISCETAK' first before field var 'x_ISCETAK'
        $val = $CurrentForm->hasValue("ISCETAK") ? $CurrentForm->getValue("ISCETAK") : $CurrentForm->getValue("x_ISCETAK");
        if (!$this->ISCETAK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ISCETAK->Visible = false; // Disable update for API request
            } else {
                $this->ISCETAK->setFormValue($val);
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

        // Check field name 'PRINTQ' first before field var 'x_PRINTQ'
        $val = $CurrentForm->hasValue("PRINTQ") ? $CurrentForm->getValue("PRINTQ") : $CurrentForm->getValue("x_PRINTQ");
        if (!$this->PRINTQ->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PRINTQ->Visible = false; // Disable update for API request
            } else {
                $this->PRINTQ->setFormValue($val);
            }
        }

        // Check field name 'BATCH_NO' first before field var 'x_BATCH_NO'
        $val = $CurrentForm->hasValue("BATCH_NO") ? $CurrentForm->getValue("BATCH_NO") : $CurrentForm->getValue("x_BATCH_NO");
        if (!$this->BATCH_NO->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->BATCH_NO->Visible = false; // Disable update for API request
            } else {
                $this->BATCH_NO->setFormValue($val);
            }
        }

        // Check field name 'SERIAL_NB' first before field var 'x_SERIAL_NB'
        $val = $CurrentForm->hasValue("SERIAL_NB") ? $CurrentForm->getValue("SERIAL_NB") : $CurrentForm->getValue("x_SERIAL_NB");
        if (!$this->SERIAL_NB->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->SERIAL_NB->Visible = false; // Disable update for API request
            } else {
                $this->SERIAL_NB->setFormValue($val);
            }
        }

        // Check field name 'EXPIRY_DATE' first before field var 'x_EXPIRY_DATE'
        $val = $CurrentForm->hasValue("EXPIRY_DATE") ? $CurrentForm->getValue("EXPIRY_DATE") : $CurrentForm->getValue("x_EXPIRY_DATE");
        if (!$this->EXPIRY_DATE->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->EXPIRY_DATE->Visible = false; // Disable update for API request
            } else {
                $this->EXPIRY_DATE->setFormValue($val);
            }
            $this->EXPIRY_DATE->CurrentValue = UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0);
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

        // Check field name 'MONTH_ID' first before field var 'x_MONTH_ID'
        $val = $CurrentForm->hasValue("MONTH_ID") ? $CurrentForm->getValue("MONTH_ID") : $CurrentForm->getValue("x_MONTH_ID");
        if (!$this->MONTH_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->MONTH_ID->Visible = false; // Disable update for API request
            } else {
                $this->MONTH_ID->setFormValue($val);
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

        // Check field name 'IDX' first before field var 'x_IDX'
        $val = $CurrentForm->hasValue("IDX") ? $CurrentForm->getValue("IDX") : $CurrentForm->getValue("x_IDX");
        if (!$this->IDX->IsDetailKey) {
            $this->IDX->setFormValue($val);
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

        // Check field name 'PPN' first before field var 'x_PPN'
        $val = $CurrentForm->hasValue("PPN") ? $CurrentForm->getValue("PPN") : $CurrentForm->getValue("x_PPN");
        if (!$this->PPN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->PPN->Visible = false; // Disable update for API request
            } else {
                $this->PPN->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ORG_UNIT_CODE->CurrentValue = $this->ORG_UNIT_CODE->FormValue;
        $this->ITEM_ID->CurrentValue = $this->ITEM_ID->FormValue;
        $this->INVOICE_ID->CurrentValue = $this->INVOICE_ID->FormValue;
        $this->BRAND_ID->CurrentValue = $this->BRAND_ID->FormValue;
        $this->BRAND_NAME->CurrentValue = $this->BRAND_NAME->FormValue;
        $this->ORDER_DATE->CurrentValue = $this->ORDER_DATE->FormValue;
        $this->ORDER_DATE->CurrentValue = UnFormatDateTime($this->ORDER_DATE->CurrentValue, 11);
        $this->ATP_DATE->CurrentValue = $this->ATP_DATE->FormValue;
        $this->ATP_DATE->CurrentValue = UnFormatDateTime($this->ATP_DATE->CurrentValue, 11);
        $this->DELIVERY_DATE->CurrentValue = $this->DELIVERY_DATE->FormValue;
        $this->DELIVERY_DATE->CurrentValue = UnFormatDateTime($this->DELIVERY_DATE->CurrentValue, 111);
        $this->PO->CurrentValue = $this->PO->FormValue;
        $this->UNIT_PRICE->CurrentValue = $this->UNIT_PRICE->FormValue;
        $this->COMPANY_ID->CurrentValue = $this->COMPANY_ID->FormValue;
        $this->ORDER_QUANTITY->CurrentValue = $this->ORDER_QUANTITY->FormValue;
        $this->RECEIVED_QUANTITY->CurrentValue = $this->RECEIVED_QUANTITY->FormValue;
        $this->DISCOUNT->CurrentValue = $this->DISCOUNT->FormValue;
        $this->DISCOUNT2->CurrentValue = $this->DISCOUNT2->FormValue;
        $this->DISCOUNTOFF->CurrentValue = $this->DISCOUNTOFF->FormValue;
        $this->MEASURE_ID->CurrentValue = $this->MEASURE_ID->FormValue;
        $this->SIZE_GOODS->CurrentValue = $this->SIZE_GOODS->FormValue;
        $this->MEASURE_DOSIS->CurrentValue = $this->MEASURE_DOSIS->FormValue;
        $this->AMOUNT_PAID->CurrentValue = $this->AMOUNT_PAID->FormValue;
        $this->ORDER_PRICE->CurrentValue = $this->ORDER_PRICE->FormValue;
        $this->QUANTITY->CurrentValue = $this->QUANTITY->FormValue;
        $this->MEASURE_ID3->CurrentValue = $this->MEASURE_ID3->FormValue;
        $this->SIZE_KEMASAN->CurrentValue = $this->SIZE_KEMASAN->FormValue;
        $this->MEASURE_ID2->CurrentValue = $this->MEASURE_ID2->FormValue;
        $this->DESCRIPTION->CurrentValue = $this->DESCRIPTION->FormValue;
        $this->MODIFIED_DATE->CurrentValue = $this->MODIFIED_DATE->FormValue;
        $this->MODIFIED_DATE->CurrentValue = UnFormatDateTime($this->MODIFIED_DATE->CurrentValue, 11);
        $this->MODIFIED_BY->CurrentValue = $this->MODIFIED_BY->FormValue;
        $this->ISCETAK->CurrentValue = $this->ISCETAK->FormValue;
        $this->PRINT_DATE->CurrentValue = $this->PRINT_DATE->FormValue;
        $this->PRINT_DATE->CurrentValue = UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0);
        $this->PRINTED_BY->CurrentValue = $this->PRINTED_BY->FormValue;
        $this->PRINTQ->CurrentValue = $this->PRINTQ->FormValue;
        $this->BATCH_NO->CurrentValue = $this->BATCH_NO->FormValue;
        $this->SERIAL_NB->CurrentValue = $this->SERIAL_NB->FormValue;
        $this->EXPIRY_DATE->CurrentValue = $this->EXPIRY_DATE->FormValue;
        $this->EXPIRY_DATE->CurrentValue = UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0);
        $this->STATUS_PASIEN_ID->CurrentValue = $this->STATUS_PASIEN_ID->FormValue;
        $this->MONTH_ID->CurrentValue = $this->MONTH_ID->FormValue;
        $this->YEAR_ID->CurrentValue = $this->YEAR_ID->FormValue;
        $this->IDX->CurrentValue = $this->IDX->FormValue;
        $this->CLINIC_ID->CurrentValue = $this->CLINIC_ID->FormValue;
        $this->PPN->CurrentValue = $this->PPN->FormValue;
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
        $this->INVOICE_ID->setDbValue($row['INVOICE_ID']);
        $this->BRAND_ID->setDbValue($row['BRAND_ID']);
        $this->BRAND_NAME->setDbValue($row['BRAND_NAME']);
        $this->ORDER_DATE->setDbValue($row['ORDER_DATE']);
        $this->ATP_DATE->setDbValue($row['ATP_DATE']);
        $this->DELIVERY_DATE->setDbValue($row['DELIVERY_DATE']);
        $this->PO->setDbValue($row['PO']);
        $this->UNIT_PRICE->setDbValue($row['UNIT_PRICE']);
        $this->COMPANY_ID->setDbValue($row['COMPANY_ID']);
        $this->ORDER_QUANTITY->setDbValue($row['ORDER_QUANTITY']);
        $this->RECEIVED_QUANTITY->setDbValue($row['RECEIVED_QUANTITY']);
        $this->DISCOUNT->setDbValue($row['DISCOUNT']);
        $this->DISCOUNT2->setDbValue($row['DISCOUNT2']);
        $this->DISCOUNTOFF->setDbValue($row['DISCOUNTOFF']);
        $this->MEASURE_ID->setDbValue($row['MEASURE_ID']);
        $this->SIZE_GOODS->setDbValue($row['SIZE_GOODS']);
        $this->MEASURE_DOSIS->setDbValue($row['MEASURE_DOSIS']);
        $this->AMOUNT_PAID->setDbValue($row['AMOUNT_PAID']);
        $this->ORDER_PRICE->setDbValue($row['ORDER_PRICE']);
        $this->QUANTITY->setDbValue($row['QUANTITY']);
        $this->MEASURE_ID3->setDbValue($row['MEASURE_ID3']);
        $this->SIZE_KEMASAN->setDbValue($row['SIZE_KEMASAN']);
        $this->MEASURE_ID2->setDbValue($row['MEASURE_ID2']);
        $this->DESCRIPTION->setDbValue($row['DESCRIPTION']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->ISCETAK->setDbValue($row['ISCETAK']);
        $this->PRINT_DATE->setDbValue($row['PRINT_DATE']);
        $this->PRINTED_BY->setDbValue($row['PRINTED_BY']);
        $this->PRINTQ->setDbValue($row['PRINTQ']);
        $this->BATCH_NO->setDbValue($row['BATCH_NO']);
        $this->SERIAL_NB->setDbValue($row['SERIAL_NB']);
        $this->EXPIRY_DATE->setDbValue($row['EXPIRY_DATE']);
        $this->STATUS_PASIEN_ID->setDbValue($row['STATUS_PASIEN_ID']);
        $this->MONTH_ID->setDbValue($row['MONTH_ID']);
        $this->YEAR_ID->setDbValue($row['YEAR_ID']);
        $this->IDX->setDbValue($row['IDX']);
        $this->CLINIC_ID->setDbValue($row['CLINIC_ID']);
        $this->PPN->setDbValue($row['PPN']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ORG_UNIT_CODE'] = null;
        $row['ITEM_ID'] = null;
        $row['INVOICE_ID'] = null;
        $row['BRAND_ID'] = null;
        $row['BRAND_NAME'] = null;
        $row['ORDER_DATE'] = null;
        $row['ATP_DATE'] = null;
        $row['DELIVERY_DATE'] = null;
        $row['PO'] = null;
        $row['UNIT_PRICE'] = null;
        $row['COMPANY_ID'] = null;
        $row['ORDER_QUANTITY'] = null;
        $row['RECEIVED_QUANTITY'] = null;
        $row['DISCOUNT'] = null;
        $row['DISCOUNT2'] = null;
        $row['DISCOUNTOFF'] = null;
        $row['MEASURE_ID'] = null;
        $row['SIZE_GOODS'] = null;
        $row['MEASURE_DOSIS'] = null;
        $row['AMOUNT_PAID'] = null;
        $row['ORDER_PRICE'] = null;
        $row['QUANTITY'] = null;
        $row['MEASURE_ID3'] = null;
        $row['SIZE_KEMASAN'] = null;
        $row['MEASURE_ID2'] = null;
        $row['DESCRIPTION'] = null;
        $row['MODIFIED_DATE'] = null;
        $row['MODIFIED_BY'] = null;
        $row['ISCETAK'] = null;
        $row['PRINT_DATE'] = null;
        $row['PRINTED_BY'] = null;
        $row['PRINTQ'] = null;
        $row['BATCH_NO'] = null;
        $row['SERIAL_NB'] = null;
        $row['EXPIRY_DATE'] = null;
        $row['STATUS_PASIEN_ID'] = null;
        $row['MONTH_ID'] = null;
        $row['YEAR_ID'] = null;
        $row['IDX'] = null;
        $row['CLINIC_ID'] = null;
        $row['PPN'] = null;
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
        if ($this->UNIT_PRICE->FormValue == $this->UNIT_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->UNIT_PRICE->CurrentValue))) {
            $this->UNIT_PRICE->CurrentValue = ConvertToFloatString($this->UNIT_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_QUANTITY->FormValue == $this->ORDER_QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_QUANTITY->CurrentValue))) {
            $this->ORDER_QUANTITY->CurrentValue = ConvertToFloatString($this->ORDER_QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->RECEIVED_QUANTITY->FormValue == $this->RECEIVED_QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->RECEIVED_QUANTITY->CurrentValue))) {
            $this->RECEIVED_QUANTITY->CurrentValue = ConvertToFloatString($this->RECEIVED_QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT->FormValue == $this->DISCOUNT->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT->CurrentValue))) {
            $this->DISCOUNT->CurrentValue = ConvertToFloatString($this->DISCOUNT->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNT2->FormValue == $this->DISCOUNT2->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNT2->CurrentValue))) {
            $this->DISCOUNT2->CurrentValue = ConvertToFloatString($this->DISCOUNT2->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->DISCOUNTOFF->FormValue == $this->DISCOUNTOFF->CurrentValue && is_numeric(ConvertToFloatString($this->DISCOUNTOFF->CurrentValue))) {
            $this->DISCOUNTOFF->CurrentValue = ConvertToFloatString($this->DISCOUNTOFF->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_GOODS->FormValue == $this->SIZE_GOODS->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_GOODS->CurrentValue))) {
            $this->SIZE_GOODS->CurrentValue = ConvertToFloatString($this->SIZE_GOODS->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->AMOUNT_PAID->FormValue == $this->AMOUNT_PAID->CurrentValue && is_numeric(ConvertToFloatString($this->AMOUNT_PAID->CurrentValue))) {
            $this->AMOUNT_PAID->CurrentValue = ConvertToFloatString($this->AMOUNT_PAID->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ORDER_PRICE->FormValue == $this->ORDER_PRICE->CurrentValue && is_numeric(ConvertToFloatString($this->ORDER_PRICE->CurrentValue))) {
            $this->ORDER_PRICE->CurrentValue = ConvertToFloatString($this->ORDER_PRICE->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->QUANTITY->FormValue == $this->QUANTITY->CurrentValue && is_numeric(ConvertToFloatString($this->QUANTITY->CurrentValue))) {
            $this->QUANTITY->CurrentValue = ConvertToFloatString($this->QUANTITY->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->SIZE_KEMASAN->FormValue == $this->SIZE_KEMASAN->CurrentValue && is_numeric(ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue))) {
            $this->SIZE_KEMASAN->CurrentValue = ConvertToFloatString($this->SIZE_KEMASAN->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ORG_UNIT_CODE

        // ITEM_ID

        // INVOICE_ID

        // BRAND_ID

        // BRAND_NAME

        // ORDER_DATE

        // ATP_DATE

        // DELIVERY_DATE

        // PO

        // UNIT_PRICE

        // COMPANY_ID

        // ORDER_QUANTITY

        // RECEIVED_QUANTITY

        // DISCOUNT

        // DISCOUNT2

        // DISCOUNTOFF

        // MEASURE_ID

        // SIZE_GOODS

        // MEASURE_DOSIS

        // AMOUNT_PAID

        // ORDER_PRICE

        // QUANTITY

        // MEASURE_ID3

        // SIZE_KEMASAN

        // MEASURE_ID2

        // DESCRIPTION

        // MODIFIED_DATE

        // MODIFIED_BY

        // ISCETAK

        // PRINT_DATE

        // PRINTED_BY

        // PRINTQ

        // BATCH_NO

        // SERIAL_NB

        // EXPIRY_DATE

        // STATUS_PASIEN_ID

        // MONTH_ID

        // YEAR_ID

        // IDX

        // CLINIC_ID

        // PPN
        if ($this->RowType == ROWTYPE_VIEW) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->ViewValue = $this->ORG_UNIT_CODE->CurrentValue;
            $this->ORG_UNIT_CODE->ViewCustomAttributes = "";

            // ITEM_ID
            $this->ITEM_ID->ViewValue = $this->ITEM_ID->CurrentValue;
            $this->ITEM_ID->ViewCustomAttributes = "";

            // INVOICE_ID
            $this->INVOICE_ID->ViewValue = $this->INVOICE_ID->CurrentValue;
            $this->INVOICE_ID->ViewCustomAttributes = "";

            // BRAND_ID
            $this->BRAND_ID->ViewValue = $this->BRAND_ID->CurrentValue;
            $this->BRAND_ID->ViewCustomAttributes = "";

            // BRAND_NAME
            $this->BRAND_NAME->ViewValue = $this->BRAND_NAME->CurrentValue;
            $this->BRAND_NAME->ViewCustomAttributes = "";

            // ORDER_DATE
            $this->ORDER_DATE->ViewValue = $this->ORDER_DATE->CurrentValue;
            $this->ORDER_DATE->ViewValue = FormatDateTime($this->ORDER_DATE->ViewValue, 11);
            $this->ORDER_DATE->ViewCustomAttributes = "";

            // ATP_DATE
            $this->ATP_DATE->ViewValue = $this->ATP_DATE->CurrentValue;
            $this->ATP_DATE->ViewValue = FormatDateTime($this->ATP_DATE->ViewValue, 11);
            $this->ATP_DATE->ViewCustomAttributes = "";

            // DELIVERY_DATE
            $this->DELIVERY_DATE->ViewValue = $this->DELIVERY_DATE->CurrentValue;
            $this->DELIVERY_DATE->ViewValue = FormatDateTime($this->DELIVERY_DATE->ViewValue, 111);
            $this->DELIVERY_DATE->ViewCustomAttributes = "";

            // PO
            $this->PO->ViewValue = $this->PO->CurrentValue;
            $this->PO->ViewCustomAttributes = "";

            // UNIT_PRICE
            $this->UNIT_PRICE->ViewValue = $this->UNIT_PRICE->CurrentValue;
            $this->UNIT_PRICE->ViewValue = FormatNumber($this->UNIT_PRICE->ViewValue, 0, -2, -2, -2);
            $this->UNIT_PRICE->ViewCustomAttributes = "";

            // COMPANY_ID
            $this->COMPANY_ID->ViewValue = $this->COMPANY_ID->CurrentValue;
            $this->COMPANY_ID->ViewCustomAttributes = "";

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->ViewValue = $this->ORDER_QUANTITY->CurrentValue;
            $this->ORDER_QUANTITY->ViewValue = FormatNumber($this->ORDER_QUANTITY->ViewValue, 0, -2, -2, -2);
            $this->ORDER_QUANTITY->ViewCustomAttributes = "";

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->ViewValue = $this->RECEIVED_QUANTITY->CurrentValue;
            $this->RECEIVED_QUANTITY->ViewValue = FormatNumber($this->RECEIVED_QUANTITY->ViewValue, 0, -2, -2, -2);
            $this->RECEIVED_QUANTITY->ViewCustomAttributes = "";

            // DISCOUNT
            $this->DISCOUNT->ViewValue = $this->DISCOUNT->CurrentValue;
            $this->DISCOUNT->ViewValue = FormatNumber($this->DISCOUNT->ViewValue, 0, -2, -2, -2);
            $this->DISCOUNT->ViewCustomAttributes = "";

            // DISCOUNT2
            $this->DISCOUNT2->ViewValue = $this->DISCOUNT2->CurrentValue;
            $this->DISCOUNT2->ViewValue = FormatNumber($this->DISCOUNT2->ViewValue, 0, -2, -2, -2);
            $this->DISCOUNT2->ViewCustomAttributes = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->ViewValue = $this->DISCOUNTOFF->CurrentValue;
            $this->DISCOUNTOFF->ViewValue = FormatNumber($this->DISCOUNTOFF->ViewValue, 0, -2, -2, -2);
            $this->DISCOUNTOFF->ViewCustomAttributes = "";

            // MEASURE_ID
            $this->MEASURE_ID->ViewValue = $this->MEASURE_ID->CurrentValue;
            $this->MEASURE_ID->ViewValue = FormatNumber($this->MEASURE_ID->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID->ViewCustomAttributes = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->ViewValue = $this->SIZE_GOODS->CurrentValue;
            $this->SIZE_GOODS->ViewValue = FormatNumber($this->SIZE_GOODS->ViewValue, 0, -2, -2, -2);
            $this->SIZE_GOODS->ViewCustomAttributes = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->ViewValue = $this->MEASURE_DOSIS->CurrentValue;
            $this->MEASURE_DOSIS->ViewValue = FormatNumber($this->MEASURE_DOSIS->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_DOSIS->ViewCustomAttributes = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->ViewValue = $this->AMOUNT_PAID->CurrentValue;
            $this->AMOUNT_PAID->ViewValue = FormatNumber($this->AMOUNT_PAID->ViewValue, 0, -2, -2, -2);
            $this->AMOUNT_PAID->ViewCustomAttributes = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->ViewValue = $this->ORDER_PRICE->CurrentValue;
            $this->ORDER_PRICE->ViewValue = FormatNumber($this->ORDER_PRICE->ViewValue, 0, -2, -2, -2);
            $this->ORDER_PRICE->ViewCustomAttributes = "";

            // QUANTITY
            $this->QUANTITY->ViewValue = $this->QUANTITY->CurrentValue;
            $this->QUANTITY->ViewValue = FormatNumber($this->QUANTITY->ViewValue, 0, -2, -2, -2);
            $this->QUANTITY->ViewCustomAttributes = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->ViewValue = $this->MEASURE_ID3->CurrentValue;
            $this->MEASURE_ID3->ViewValue = FormatNumber($this->MEASURE_ID3->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID3->ViewCustomAttributes = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->ViewValue = $this->SIZE_KEMASAN->CurrentValue;
            $this->SIZE_KEMASAN->ViewValue = FormatNumber($this->SIZE_KEMASAN->ViewValue, 0, -2, -2, -2);
            $this->SIZE_KEMASAN->ViewCustomAttributes = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->ViewValue = $this->MEASURE_ID2->CurrentValue;
            $this->MEASURE_ID2->ViewValue = FormatNumber($this->MEASURE_ID2->ViewValue, 0, -2, -2, -2);
            $this->MEASURE_ID2->ViewCustomAttributes = "";

            // DESCRIPTION
            $this->DESCRIPTION->ViewValue = $this->DESCRIPTION->CurrentValue;
            $this->DESCRIPTION->ViewCustomAttributes = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
            $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 11);
            $this->MODIFIED_DATE->ViewCustomAttributes = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
            $this->MODIFIED_BY->ViewCustomAttributes = "";

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

            // BATCH_NO
            $this->BATCH_NO->ViewValue = $this->BATCH_NO->CurrentValue;
            $this->BATCH_NO->ViewCustomAttributes = "";

            // SERIAL_NB
            $this->SERIAL_NB->ViewValue = $this->SERIAL_NB->CurrentValue;
            $this->SERIAL_NB->ViewCustomAttributes = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->ViewValue = $this->EXPIRY_DATE->CurrentValue;
            $this->EXPIRY_DATE->ViewValue = FormatDateTime($this->EXPIRY_DATE->ViewValue, 0);
            $this->EXPIRY_DATE->ViewCustomAttributes = "";

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

            // IDX
            $this->IDX->ViewValue = $this->IDX->CurrentValue;
            $this->IDX->ViewCustomAttributes = "";

            // CLINIC_ID
            $this->CLINIC_ID->ViewValue = $this->CLINIC_ID->CurrentValue;
            $this->CLINIC_ID->ViewCustomAttributes = "";

            // PPN
            $this->PPN->ViewValue = $this->PPN->CurrentValue;
            $this->PPN->ViewValue = FormatNumber($this->PPN->ViewValue, 0, -2, -2, -2);
            $this->PPN->ViewCustomAttributes = "";

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";
            $this->ORG_UNIT_CODE->TooltipValue = "";

            // ITEM_ID
            $this->ITEM_ID->LinkCustomAttributes = "";
            $this->ITEM_ID->HrefValue = "";
            $this->ITEM_ID->TooltipValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";
            $this->INVOICE_ID->TooltipValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";
            $this->BRAND_ID->TooltipValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";
            $this->BRAND_NAME->TooltipValue = "";

            // ORDER_DATE
            $this->ORDER_DATE->LinkCustomAttributes = "";
            $this->ORDER_DATE->HrefValue = "";
            $this->ORDER_DATE->TooltipValue = "";

            // ATP_DATE
            $this->ATP_DATE->LinkCustomAttributes = "";
            $this->ATP_DATE->HrefValue = "";
            $this->ATP_DATE->TooltipValue = "";

            // DELIVERY_DATE
            $this->DELIVERY_DATE->LinkCustomAttributes = "";
            $this->DELIVERY_DATE->HrefValue = "";
            $this->DELIVERY_DATE->TooltipValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";
            $this->PO->TooltipValue = "";

            // UNIT_PRICE
            $this->UNIT_PRICE->LinkCustomAttributes = "";
            $this->UNIT_PRICE->HrefValue = "";
            $this->UNIT_PRICE->TooltipValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";
            $this->COMPANY_ID->TooltipValue = "";

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->LinkCustomAttributes = "";
            $this->ORDER_QUANTITY->HrefValue = "";
            $this->ORDER_QUANTITY->TooltipValue = "";

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->LinkCustomAttributes = "";
            $this->RECEIVED_QUANTITY->HrefValue = "";
            $this->RECEIVED_QUANTITY->TooltipValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";
            $this->DISCOUNT->TooltipValue = "";

            // DISCOUNT2
            $this->DISCOUNT2->LinkCustomAttributes = "";
            $this->DISCOUNT2->HrefValue = "";
            $this->DISCOUNT2->TooltipValue = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";
            $this->DISCOUNTOFF->TooltipValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";
            $this->MEASURE_ID->TooltipValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";
            $this->SIZE_GOODS->TooltipValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";
            $this->MEASURE_DOSIS->TooltipValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";
            $this->AMOUNT_PAID->TooltipValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";
            $this->ORDER_PRICE->TooltipValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";
            $this->QUANTITY->TooltipValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";
            $this->MEASURE_ID3->TooltipValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";
            $this->SIZE_KEMASAN->TooltipValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";
            $this->MEASURE_ID2->TooltipValue = "";

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

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";
            $this->ISCETAK->TooltipValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";
            $this->PRINT_DATE->TooltipValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";
            $this->PRINTED_BY->TooltipValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";
            $this->PRINTQ->TooltipValue = "";

            // BATCH_NO
            $this->BATCH_NO->LinkCustomAttributes = "";
            $this->BATCH_NO->HrefValue = "";
            $this->BATCH_NO->TooltipValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";
            $this->SERIAL_NB->TooltipValue = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";
            $this->EXPIRY_DATE->TooltipValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";
            $this->STATUS_PASIEN_ID->TooltipValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";
            $this->MONTH_ID->TooltipValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";
            $this->YEAR_ID->TooltipValue = "";

            // IDX
            $this->IDX->LinkCustomAttributes = "";
            $this->IDX->HrefValue = "";
            $this->IDX->TooltipValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";
            $this->CLINIC_ID->TooltipValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
            $this->PPN->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->EditAttrs["class"] = "form-control";
            $this->ORG_UNIT_CODE->EditCustomAttributes = "";
            if (!$this->ORG_UNIT_CODE->Raw) {
                $this->ORG_UNIT_CODE->CurrentValue = HtmlDecode($this->ORG_UNIT_CODE->CurrentValue);
            }
            $this->ORG_UNIT_CODE->EditValue = HtmlEncode($this->ORG_UNIT_CODE->CurrentValue);
            $this->ORG_UNIT_CODE->PlaceHolder = RemoveHtml($this->ORG_UNIT_CODE->caption());

            // ITEM_ID
            $this->ITEM_ID->EditAttrs["class"] = "form-control";
            $this->ITEM_ID->EditCustomAttributes = "";
            if (!$this->ITEM_ID->Raw) {
                $this->ITEM_ID->CurrentValue = HtmlDecode($this->ITEM_ID->CurrentValue);
            }
            $this->ITEM_ID->EditValue = HtmlEncode($this->ITEM_ID->CurrentValue);
            $this->ITEM_ID->PlaceHolder = RemoveHtml($this->ITEM_ID->caption());

            // INVOICE_ID
            $this->INVOICE_ID->EditAttrs["class"] = "form-control";
            $this->INVOICE_ID->EditCustomAttributes = "";
            if (!$this->INVOICE_ID->Raw) {
                $this->INVOICE_ID->CurrentValue = HtmlDecode($this->INVOICE_ID->CurrentValue);
            }
            $this->INVOICE_ID->EditValue = HtmlEncode($this->INVOICE_ID->CurrentValue);
            $this->INVOICE_ID->PlaceHolder = RemoveHtml($this->INVOICE_ID->caption());

            // BRAND_ID
            $this->BRAND_ID->EditAttrs["class"] = "form-control";
            $this->BRAND_ID->EditCustomAttributes = "";
            if (!$this->BRAND_ID->Raw) {
                $this->BRAND_ID->CurrentValue = HtmlDecode($this->BRAND_ID->CurrentValue);
            }
            $this->BRAND_ID->EditValue = HtmlEncode($this->BRAND_ID->CurrentValue);
            $this->BRAND_ID->PlaceHolder = RemoveHtml($this->BRAND_ID->caption());

            // BRAND_NAME
            $this->BRAND_NAME->EditAttrs["class"] = "form-control";
            $this->BRAND_NAME->EditCustomAttributes = "";
            if (!$this->BRAND_NAME->Raw) {
                $this->BRAND_NAME->CurrentValue = HtmlDecode($this->BRAND_NAME->CurrentValue);
            }
            $this->BRAND_NAME->EditValue = HtmlEncode($this->BRAND_NAME->CurrentValue);
            $this->BRAND_NAME->PlaceHolder = RemoveHtml($this->BRAND_NAME->caption());

            // ORDER_DATE
            $this->ORDER_DATE->EditAttrs["class"] = "form-control";
            $this->ORDER_DATE->EditCustomAttributes = "";
            $this->ORDER_DATE->EditValue = HtmlEncode(FormatDateTime($this->ORDER_DATE->CurrentValue, 11));
            $this->ORDER_DATE->PlaceHolder = RemoveHtml($this->ORDER_DATE->caption());

            // ATP_DATE
            $this->ATP_DATE->EditAttrs["class"] = "form-control";
            $this->ATP_DATE->EditCustomAttributes = "";
            $this->ATP_DATE->EditValue = HtmlEncode(FormatDateTime($this->ATP_DATE->CurrentValue, 11));
            $this->ATP_DATE->PlaceHolder = RemoveHtml($this->ATP_DATE->caption());

            // DELIVERY_DATE
            $this->DELIVERY_DATE->EditAttrs["class"] = "form-control";
            $this->DELIVERY_DATE->EditCustomAttributes = "";
            $this->DELIVERY_DATE->EditValue = HtmlEncode(FormatDateTime($this->DELIVERY_DATE->CurrentValue, 111));
            $this->DELIVERY_DATE->PlaceHolder = RemoveHtml($this->DELIVERY_DATE->caption());

            // PO
            $this->PO->EditAttrs["class"] = "form-control";
            $this->PO->EditCustomAttributes = "";
            if (!$this->PO->Raw) {
                $this->PO->CurrentValue = HtmlDecode($this->PO->CurrentValue);
            }
            $this->PO->EditValue = HtmlEncode($this->PO->CurrentValue);
            $this->PO->PlaceHolder = RemoveHtml($this->PO->caption());

            // UNIT_PRICE
            $this->UNIT_PRICE->EditAttrs["class"] = "form-control";
            $this->UNIT_PRICE->EditCustomAttributes = "";
            $this->UNIT_PRICE->EditValue = HtmlEncode($this->UNIT_PRICE->CurrentValue);
            $this->UNIT_PRICE->PlaceHolder = RemoveHtml($this->UNIT_PRICE->caption());
            if (strval($this->UNIT_PRICE->EditValue) != "" && is_numeric($this->UNIT_PRICE->EditValue)) {
                $this->UNIT_PRICE->EditValue = FormatNumber($this->UNIT_PRICE->EditValue, -2, -2, -2, -2);
            }

            // COMPANY_ID
            $this->COMPANY_ID->EditAttrs["class"] = "form-control";
            $this->COMPANY_ID->EditCustomAttributes = "";
            if (!$this->COMPANY_ID->Raw) {
                $this->COMPANY_ID->CurrentValue = HtmlDecode($this->COMPANY_ID->CurrentValue);
            }
            $this->COMPANY_ID->EditValue = HtmlEncode($this->COMPANY_ID->CurrentValue);
            $this->COMPANY_ID->PlaceHolder = RemoveHtml($this->COMPANY_ID->caption());

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->EditAttrs["class"] = "form-control";
            $this->ORDER_QUANTITY->EditCustomAttributes = "";
            $this->ORDER_QUANTITY->EditValue = HtmlEncode($this->ORDER_QUANTITY->CurrentValue);
            $this->ORDER_QUANTITY->PlaceHolder = RemoveHtml($this->ORDER_QUANTITY->caption());
            if (strval($this->ORDER_QUANTITY->EditValue) != "" && is_numeric($this->ORDER_QUANTITY->EditValue)) {
                $this->ORDER_QUANTITY->EditValue = FormatNumber($this->ORDER_QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->EditAttrs["class"] = "form-control";
            $this->RECEIVED_QUANTITY->EditCustomAttributes = "";
            $this->RECEIVED_QUANTITY->EditValue = HtmlEncode($this->RECEIVED_QUANTITY->CurrentValue);
            $this->RECEIVED_QUANTITY->PlaceHolder = RemoveHtml($this->RECEIVED_QUANTITY->caption());
            if (strval($this->RECEIVED_QUANTITY->EditValue) != "" && is_numeric($this->RECEIVED_QUANTITY->EditValue)) {
                $this->RECEIVED_QUANTITY->EditValue = FormatNumber($this->RECEIVED_QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT
            $this->DISCOUNT->EditAttrs["class"] = "form-control";
            $this->DISCOUNT->EditCustomAttributes = "";
            $this->DISCOUNT->EditValue = HtmlEncode($this->DISCOUNT->CurrentValue);
            $this->DISCOUNT->PlaceHolder = RemoveHtml($this->DISCOUNT->caption());
            if (strval($this->DISCOUNT->EditValue) != "" && is_numeric($this->DISCOUNT->EditValue)) {
                $this->DISCOUNT->EditValue = FormatNumber($this->DISCOUNT->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNT2
            $this->DISCOUNT2->EditAttrs["class"] = "form-control";
            $this->DISCOUNT2->EditCustomAttributes = "";
            $this->DISCOUNT2->EditValue = HtmlEncode($this->DISCOUNT2->CurrentValue);
            $this->DISCOUNT2->PlaceHolder = RemoveHtml($this->DISCOUNT2->caption());
            if (strval($this->DISCOUNT2->EditValue) != "" && is_numeric($this->DISCOUNT2->EditValue)) {
                $this->DISCOUNT2->EditValue = FormatNumber($this->DISCOUNT2->EditValue, -2, -2, -2, -2);
            }

            // DISCOUNTOFF
            $this->DISCOUNTOFF->EditAttrs["class"] = "form-control";
            $this->DISCOUNTOFF->EditCustomAttributes = "";
            $this->DISCOUNTOFF->EditValue = HtmlEncode($this->DISCOUNTOFF->CurrentValue);
            $this->DISCOUNTOFF->PlaceHolder = RemoveHtml($this->DISCOUNTOFF->caption());
            if (strval($this->DISCOUNTOFF->EditValue) != "" && is_numeric($this->DISCOUNTOFF->EditValue)) {
                $this->DISCOUNTOFF->EditValue = FormatNumber($this->DISCOUNTOFF->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID
            $this->MEASURE_ID->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID->EditCustomAttributes = "";
            $this->MEASURE_ID->EditValue = HtmlEncode($this->MEASURE_ID->CurrentValue);
            $this->MEASURE_ID->PlaceHolder = RemoveHtml($this->MEASURE_ID->caption());

            // SIZE_GOODS
            $this->SIZE_GOODS->EditAttrs["class"] = "form-control";
            $this->SIZE_GOODS->EditCustomAttributes = "";
            $this->SIZE_GOODS->EditValue = HtmlEncode($this->SIZE_GOODS->CurrentValue);
            $this->SIZE_GOODS->PlaceHolder = RemoveHtml($this->SIZE_GOODS->caption());
            if (strval($this->SIZE_GOODS->EditValue) != "" && is_numeric($this->SIZE_GOODS->EditValue)) {
                $this->SIZE_GOODS->EditValue = FormatNumber($this->SIZE_GOODS->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->EditAttrs["class"] = "form-control";
            $this->MEASURE_DOSIS->EditCustomAttributes = "";
            $this->MEASURE_DOSIS->EditValue = HtmlEncode($this->MEASURE_DOSIS->CurrentValue);
            $this->MEASURE_DOSIS->PlaceHolder = RemoveHtml($this->MEASURE_DOSIS->caption());

            // AMOUNT_PAID
            $this->AMOUNT_PAID->EditAttrs["class"] = "form-control";
            $this->AMOUNT_PAID->EditCustomAttributes = "";
            $this->AMOUNT_PAID->EditValue = HtmlEncode($this->AMOUNT_PAID->CurrentValue);
            $this->AMOUNT_PAID->PlaceHolder = RemoveHtml($this->AMOUNT_PAID->caption());
            if (strval($this->AMOUNT_PAID->EditValue) != "" && is_numeric($this->AMOUNT_PAID->EditValue)) {
                $this->AMOUNT_PAID->EditValue = FormatNumber($this->AMOUNT_PAID->EditValue, -2, -2, -2, -2);
            }

            // ORDER_PRICE
            $this->ORDER_PRICE->EditAttrs["class"] = "form-control";
            $this->ORDER_PRICE->EditCustomAttributes = "";
            $this->ORDER_PRICE->EditValue = HtmlEncode($this->ORDER_PRICE->CurrentValue);
            $this->ORDER_PRICE->PlaceHolder = RemoveHtml($this->ORDER_PRICE->caption());
            if (strval($this->ORDER_PRICE->EditValue) != "" && is_numeric($this->ORDER_PRICE->EditValue)) {
                $this->ORDER_PRICE->EditValue = FormatNumber($this->ORDER_PRICE->EditValue, -2, -2, -2, -2);
            }

            // QUANTITY
            $this->QUANTITY->EditAttrs["class"] = "form-control";
            $this->QUANTITY->EditCustomAttributes = "";
            $this->QUANTITY->EditValue = HtmlEncode($this->QUANTITY->CurrentValue);
            $this->QUANTITY->PlaceHolder = RemoveHtml($this->QUANTITY->caption());
            if (strval($this->QUANTITY->EditValue) != "" && is_numeric($this->QUANTITY->EditValue)) {
                $this->QUANTITY->EditValue = FormatNumber($this->QUANTITY->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID3
            $this->MEASURE_ID3->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID3->EditCustomAttributes = "";
            $this->MEASURE_ID3->EditValue = HtmlEncode($this->MEASURE_ID3->CurrentValue);
            $this->MEASURE_ID3->PlaceHolder = RemoveHtml($this->MEASURE_ID3->caption());

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->EditAttrs["class"] = "form-control";
            $this->SIZE_KEMASAN->EditCustomAttributes = "";
            $this->SIZE_KEMASAN->EditValue = HtmlEncode($this->SIZE_KEMASAN->CurrentValue);
            $this->SIZE_KEMASAN->PlaceHolder = RemoveHtml($this->SIZE_KEMASAN->caption());
            if (strval($this->SIZE_KEMASAN->EditValue) != "" && is_numeric($this->SIZE_KEMASAN->EditValue)) {
                $this->SIZE_KEMASAN->EditValue = FormatNumber($this->SIZE_KEMASAN->EditValue, -2, -2, -2, -2);
            }

            // MEASURE_ID2
            $this->MEASURE_ID2->EditAttrs["class"] = "form-control";
            $this->MEASURE_ID2->EditCustomAttributes = "";
            $this->MEASURE_ID2->EditValue = HtmlEncode($this->MEASURE_ID2->CurrentValue);
            $this->MEASURE_ID2->PlaceHolder = RemoveHtml($this->MEASURE_ID2->caption());

            // DESCRIPTION
            $this->DESCRIPTION->EditAttrs["class"] = "form-control";
            $this->DESCRIPTION->EditCustomAttributes = "";
            if (!$this->DESCRIPTION->Raw) {
                $this->DESCRIPTION->CurrentValue = HtmlDecode($this->DESCRIPTION->CurrentValue);
            }
            $this->DESCRIPTION->EditValue = HtmlEncode($this->DESCRIPTION->CurrentValue);
            $this->DESCRIPTION->PlaceHolder = RemoveHtml($this->DESCRIPTION->caption());

            // MODIFIED_DATE

            // MODIFIED_BY

            // ISCETAK
            $this->ISCETAK->EditAttrs["class"] = "form-control";
            $this->ISCETAK->EditCustomAttributes = "";
            if (!$this->ISCETAK->Raw) {
                $this->ISCETAK->CurrentValue = HtmlDecode($this->ISCETAK->CurrentValue);
            }
            $this->ISCETAK->EditValue = HtmlEncode($this->ISCETAK->CurrentValue);
            $this->ISCETAK->PlaceHolder = RemoveHtml($this->ISCETAK->caption());

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

            // PRINTQ
            $this->PRINTQ->EditAttrs["class"] = "form-control";
            $this->PRINTQ->EditCustomAttributes = "";
            $this->PRINTQ->EditValue = HtmlEncode($this->PRINTQ->CurrentValue);
            $this->PRINTQ->PlaceHolder = RemoveHtml($this->PRINTQ->caption());

            // BATCH_NO
            $this->BATCH_NO->EditAttrs["class"] = "form-control";
            $this->BATCH_NO->EditCustomAttributes = "";
            if (!$this->BATCH_NO->Raw) {
                $this->BATCH_NO->CurrentValue = HtmlDecode($this->BATCH_NO->CurrentValue);
            }
            $this->BATCH_NO->EditValue = HtmlEncode($this->BATCH_NO->CurrentValue);
            $this->BATCH_NO->PlaceHolder = RemoveHtml($this->BATCH_NO->caption());

            // SERIAL_NB
            $this->SERIAL_NB->EditAttrs["class"] = "form-control";
            $this->SERIAL_NB->EditCustomAttributes = "";
            if (!$this->SERIAL_NB->Raw) {
                $this->SERIAL_NB->CurrentValue = HtmlDecode($this->SERIAL_NB->CurrentValue);
            }
            $this->SERIAL_NB->EditValue = HtmlEncode($this->SERIAL_NB->CurrentValue);
            $this->SERIAL_NB->PlaceHolder = RemoveHtml($this->SERIAL_NB->caption());

            // EXPIRY_DATE
            $this->EXPIRY_DATE->EditAttrs["class"] = "form-control";
            $this->EXPIRY_DATE->EditCustomAttributes = "";
            $this->EXPIRY_DATE->EditValue = HtmlEncode(FormatDateTime($this->EXPIRY_DATE->CurrentValue, 8));
            $this->EXPIRY_DATE->PlaceHolder = RemoveHtml($this->EXPIRY_DATE->caption());

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->EditAttrs["class"] = "form-control";
            $this->STATUS_PASIEN_ID->EditCustomAttributes = "";
            $this->STATUS_PASIEN_ID->EditValue = HtmlEncode($this->STATUS_PASIEN_ID->CurrentValue);
            $this->STATUS_PASIEN_ID->PlaceHolder = RemoveHtml($this->STATUS_PASIEN_ID->caption());

            // MONTH_ID
            $this->MONTH_ID->EditAttrs["class"] = "form-control";
            $this->MONTH_ID->EditCustomAttributes = "";
            $this->MONTH_ID->EditValue = HtmlEncode($this->MONTH_ID->CurrentValue);
            $this->MONTH_ID->PlaceHolder = RemoveHtml($this->MONTH_ID->caption());

            // YEAR_ID
            $this->YEAR_ID->EditAttrs["class"] = "form-control";
            $this->YEAR_ID->EditCustomAttributes = "";
            $this->YEAR_ID->EditValue = HtmlEncode($this->YEAR_ID->CurrentValue);
            $this->YEAR_ID->PlaceHolder = RemoveHtml($this->YEAR_ID->caption());

            // IDX
            $this->IDX->EditAttrs["class"] = "form-control";
            $this->IDX->EditCustomAttributes = "";
            $this->IDX->EditValue = HtmlEncode($this->IDX->CurrentValue);
            $this->IDX->PlaceHolder = RemoveHtml($this->IDX->caption());

            // CLINIC_ID
            $this->CLINIC_ID->EditAttrs["class"] = "form-control";
            $this->CLINIC_ID->EditCustomAttributes = "";
            if (!$this->CLINIC_ID->Raw) {
                $this->CLINIC_ID->CurrentValue = HtmlDecode($this->CLINIC_ID->CurrentValue);
            }
            $this->CLINIC_ID->EditValue = HtmlEncode($this->CLINIC_ID->CurrentValue);
            $this->CLINIC_ID->PlaceHolder = RemoveHtml($this->CLINIC_ID->caption());

            // PPN
            $this->PPN->EditAttrs["class"] = "form-control";
            $this->PPN->EditCustomAttributes = "";
            $this->PPN->EditValue = HtmlEncode($this->PPN->CurrentValue);
            $this->PPN->PlaceHolder = RemoveHtml($this->PPN->caption());

            // Edit refer script

            // ORG_UNIT_CODE
            $this->ORG_UNIT_CODE->LinkCustomAttributes = "";
            $this->ORG_UNIT_CODE->HrefValue = "";

            // ITEM_ID
            $this->ITEM_ID->LinkCustomAttributes = "";
            $this->ITEM_ID->HrefValue = "";

            // INVOICE_ID
            $this->INVOICE_ID->LinkCustomAttributes = "";
            $this->INVOICE_ID->HrefValue = "";

            // BRAND_ID
            $this->BRAND_ID->LinkCustomAttributes = "";
            $this->BRAND_ID->HrefValue = "";

            // BRAND_NAME
            $this->BRAND_NAME->LinkCustomAttributes = "";
            $this->BRAND_NAME->HrefValue = "";

            // ORDER_DATE
            $this->ORDER_DATE->LinkCustomAttributes = "";
            $this->ORDER_DATE->HrefValue = "";

            // ATP_DATE
            $this->ATP_DATE->LinkCustomAttributes = "";
            $this->ATP_DATE->HrefValue = "";

            // DELIVERY_DATE
            $this->DELIVERY_DATE->LinkCustomAttributes = "";
            $this->DELIVERY_DATE->HrefValue = "";

            // PO
            $this->PO->LinkCustomAttributes = "";
            $this->PO->HrefValue = "";

            // UNIT_PRICE
            $this->UNIT_PRICE->LinkCustomAttributes = "";
            $this->UNIT_PRICE->HrefValue = "";

            // COMPANY_ID
            $this->COMPANY_ID->LinkCustomAttributes = "";
            $this->COMPANY_ID->HrefValue = "";

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->LinkCustomAttributes = "";
            $this->ORDER_QUANTITY->HrefValue = "";

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->LinkCustomAttributes = "";
            $this->RECEIVED_QUANTITY->HrefValue = "";

            // DISCOUNT
            $this->DISCOUNT->LinkCustomAttributes = "";
            $this->DISCOUNT->HrefValue = "";

            // DISCOUNT2
            $this->DISCOUNT2->LinkCustomAttributes = "";
            $this->DISCOUNT2->HrefValue = "";

            // DISCOUNTOFF
            $this->DISCOUNTOFF->LinkCustomAttributes = "";
            $this->DISCOUNTOFF->HrefValue = "";

            // MEASURE_ID
            $this->MEASURE_ID->LinkCustomAttributes = "";
            $this->MEASURE_ID->HrefValue = "";

            // SIZE_GOODS
            $this->SIZE_GOODS->LinkCustomAttributes = "";
            $this->SIZE_GOODS->HrefValue = "";

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->LinkCustomAttributes = "";
            $this->MEASURE_DOSIS->HrefValue = "";

            // AMOUNT_PAID
            $this->AMOUNT_PAID->LinkCustomAttributes = "";
            $this->AMOUNT_PAID->HrefValue = "";

            // ORDER_PRICE
            $this->ORDER_PRICE->LinkCustomAttributes = "";
            $this->ORDER_PRICE->HrefValue = "";

            // QUANTITY
            $this->QUANTITY->LinkCustomAttributes = "";
            $this->QUANTITY->HrefValue = "";

            // MEASURE_ID3
            $this->MEASURE_ID3->LinkCustomAttributes = "";
            $this->MEASURE_ID3->HrefValue = "";

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->LinkCustomAttributes = "";
            $this->SIZE_KEMASAN->HrefValue = "";

            // MEASURE_ID2
            $this->MEASURE_ID2->LinkCustomAttributes = "";
            $this->MEASURE_ID2->HrefValue = "";

            // DESCRIPTION
            $this->DESCRIPTION->LinkCustomAttributes = "";
            $this->DESCRIPTION->HrefValue = "";

            // MODIFIED_DATE
            $this->MODIFIED_DATE->LinkCustomAttributes = "";
            $this->MODIFIED_DATE->HrefValue = "";

            // MODIFIED_BY
            $this->MODIFIED_BY->LinkCustomAttributes = "";
            $this->MODIFIED_BY->HrefValue = "";

            // ISCETAK
            $this->ISCETAK->LinkCustomAttributes = "";
            $this->ISCETAK->HrefValue = "";

            // PRINT_DATE
            $this->PRINT_DATE->LinkCustomAttributes = "";
            $this->PRINT_DATE->HrefValue = "";

            // PRINTED_BY
            $this->PRINTED_BY->LinkCustomAttributes = "";
            $this->PRINTED_BY->HrefValue = "";

            // PRINTQ
            $this->PRINTQ->LinkCustomAttributes = "";
            $this->PRINTQ->HrefValue = "";

            // BATCH_NO
            $this->BATCH_NO->LinkCustomAttributes = "";
            $this->BATCH_NO->HrefValue = "";

            // SERIAL_NB
            $this->SERIAL_NB->LinkCustomAttributes = "";
            $this->SERIAL_NB->HrefValue = "";

            // EXPIRY_DATE
            $this->EXPIRY_DATE->LinkCustomAttributes = "";
            $this->EXPIRY_DATE->HrefValue = "";

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->LinkCustomAttributes = "";
            $this->STATUS_PASIEN_ID->HrefValue = "";

            // MONTH_ID
            $this->MONTH_ID->LinkCustomAttributes = "";
            $this->MONTH_ID->HrefValue = "";

            // YEAR_ID
            $this->YEAR_ID->LinkCustomAttributes = "";
            $this->YEAR_ID->HrefValue = "";

            // IDX
            $this->IDX->LinkCustomAttributes = "";
            $this->IDX->HrefValue = "";

            // CLINIC_ID
            $this->CLINIC_ID->LinkCustomAttributes = "";
            $this->CLINIC_ID->HrefValue = "";

            // PPN
            $this->PPN->LinkCustomAttributes = "";
            $this->PPN->HrefValue = "";
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
        if ($this->ITEM_ID->Required) {
            if (!$this->ITEM_ID->IsDetailKey && EmptyValue($this->ITEM_ID->FormValue)) {
                $this->ITEM_ID->addErrorMessage(str_replace("%s", $this->ITEM_ID->caption(), $this->ITEM_ID->RequiredErrorMessage));
            }
        }
        if ($this->INVOICE_ID->Required) {
            if (!$this->INVOICE_ID->IsDetailKey && EmptyValue($this->INVOICE_ID->FormValue)) {
                $this->INVOICE_ID->addErrorMessage(str_replace("%s", $this->INVOICE_ID->caption(), $this->INVOICE_ID->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_ID->Required) {
            if (!$this->BRAND_ID->IsDetailKey && EmptyValue($this->BRAND_ID->FormValue)) {
                $this->BRAND_ID->addErrorMessage(str_replace("%s", $this->BRAND_ID->caption(), $this->BRAND_ID->RequiredErrorMessage));
            }
        }
        if ($this->BRAND_NAME->Required) {
            if (!$this->BRAND_NAME->IsDetailKey && EmptyValue($this->BRAND_NAME->FormValue)) {
                $this->BRAND_NAME->addErrorMessage(str_replace("%s", $this->BRAND_NAME->caption(), $this->BRAND_NAME->RequiredErrorMessage));
            }
        }
        if ($this->ORDER_DATE->Required) {
            if (!$this->ORDER_DATE->IsDetailKey && EmptyValue($this->ORDER_DATE->FormValue)) {
                $this->ORDER_DATE->addErrorMessage(str_replace("%s", $this->ORDER_DATE->caption(), $this->ORDER_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->ORDER_DATE->FormValue)) {
            $this->ORDER_DATE->addErrorMessage($this->ORDER_DATE->getErrorMessage(false));
        }
        if ($this->ATP_DATE->Required) {
            if (!$this->ATP_DATE->IsDetailKey && EmptyValue($this->ATP_DATE->FormValue)) {
                $this->ATP_DATE->addErrorMessage(str_replace("%s", $this->ATP_DATE->caption(), $this->ATP_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->ATP_DATE->FormValue)) {
            $this->ATP_DATE->addErrorMessage($this->ATP_DATE->getErrorMessage(false));
        }
        if ($this->DELIVERY_DATE->Required) {
            if (!$this->DELIVERY_DATE->IsDetailKey && EmptyValue($this->DELIVERY_DATE->FormValue)) {
                $this->DELIVERY_DATE->addErrorMessage(str_replace("%s", $this->DELIVERY_DATE->caption(), $this->DELIVERY_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->DELIVERY_DATE->FormValue)) {
            $this->DELIVERY_DATE->addErrorMessage($this->DELIVERY_DATE->getErrorMessage(false));
        }
        if ($this->PO->Required) {
            if (!$this->PO->IsDetailKey && EmptyValue($this->PO->FormValue)) {
                $this->PO->addErrorMessage(str_replace("%s", $this->PO->caption(), $this->PO->RequiredErrorMessage));
            }
        }
        if ($this->UNIT_PRICE->Required) {
            if (!$this->UNIT_PRICE->IsDetailKey && EmptyValue($this->UNIT_PRICE->FormValue)) {
                $this->UNIT_PRICE->addErrorMessage(str_replace("%s", $this->UNIT_PRICE->caption(), $this->UNIT_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->UNIT_PRICE->FormValue)) {
            $this->UNIT_PRICE->addErrorMessage($this->UNIT_PRICE->getErrorMessage(false));
        }
        if ($this->COMPANY_ID->Required) {
            if (!$this->COMPANY_ID->IsDetailKey && EmptyValue($this->COMPANY_ID->FormValue)) {
                $this->COMPANY_ID->addErrorMessage(str_replace("%s", $this->COMPANY_ID->caption(), $this->COMPANY_ID->RequiredErrorMessage));
            }
        }
        if ($this->ORDER_QUANTITY->Required) {
            if (!$this->ORDER_QUANTITY->IsDetailKey && EmptyValue($this->ORDER_QUANTITY->FormValue)) {
                $this->ORDER_QUANTITY->addErrorMessage(str_replace("%s", $this->ORDER_QUANTITY->caption(), $this->ORDER_QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_QUANTITY->FormValue)) {
            $this->ORDER_QUANTITY->addErrorMessage($this->ORDER_QUANTITY->getErrorMessage(false));
        }
        if ($this->RECEIVED_QUANTITY->Required) {
            if (!$this->RECEIVED_QUANTITY->IsDetailKey && EmptyValue($this->RECEIVED_QUANTITY->FormValue)) {
                $this->RECEIVED_QUANTITY->addErrorMessage(str_replace("%s", $this->RECEIVED_QUANTITY->caption(), $this->RECEIVED_QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->RECEIVED_QUANTITY->FormValue)) {
            $this->RECEIVED_QUANTITY->addErrorMessage($this->RECEIVED_QUANTITY->getErrorMessage(false));
        }
        if ($this->DISCOUNT->Required) {
            if (!$this->DISCOUNT->IsDetailKey && EmptyValue($this->DISCOUNT->FormValue)) {
                $this->DISCOUNT->addErrorMessage(str_replace("%s", $this->DISCOUNT->caption(), $this->DISCOUNT->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT->FormValue)) {
            $this->DISCOUNT->addErrorMessage($this->DISCOUNT->getErrorMessage(false));
        }
        if ($this->DISCOUNT2->Required) {
            if (!$this->DISCOUNT2->IsDetailKey && EmptyValue($this->DISCOUNT2->FormValue)) {
                $this->DISCOUNT2->addErrorMessage(str_replace("%s", $this->DISCOUNT2->caption(), $this->DISCOUNT2->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNT2->FormValue)) {
            $this->DISCOUNT2->addErrorMessage($this->DISCOUNT2->getErrorMessage(false));
        }
        if ($this->DISCOUNTOFF->Required) {
            if (!$this->DISCOUNTOFF->IsDetailKey && EmptyValue($this->DISCOUNTOFF->FormValue)) {
                $this->DISCOUNTOFF->addErrorMessage(str_replace("%s", $this->DISCOUNTOFF->caption(), $this->DISCOUNTOFF->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->DISCOUNTOFF->FormValue)) {
            $this->DISCOUNTOFF->addErrorMessage($this->DISCOUNTOFF->getErrorMessage(false));
        }
        if ($this->MEASURE_ID->Required) {
            if (!$this->MEASURE_ID->IsDetailKey && EmptyValue($this->MEASURE_ID->FormValue)) {
                $this->MEASURE_ID->addErrorMessage(str_replace("%s", $this->MEASURE_ID->caption(), $this->MEASURE_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID->FormValue)) {
            $this->MEASURE_ID->addErrorMessage($this->MEASURE_ID->getErrorMessage(false));
        }
        if ($this->SIZE_GOODS->Required) {
            if (!$this->SIZE_GOODS->IsDetailKey && EmptyValue($this->SIZE_GOODS->FormValue)) {
                $this->SIZE_GOODS->addErrorMessage(str_replace("%s", $this->SIZE_GOODS->caption(), $this->SIZE_GOODS->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_GOODS->FormValue)) {
            $this->SIZE_GOODS->addErrorMessage($this->SIZE_GOODS->getErrorMessage(false));
        }
        if ($this->MEASURE_DOSIS->Required) {
            if (!$this->MEASURE_DOSIS->IsDetailKey && EmptyValue($this->MEASURE_DOSIS->FormValue)) {
                $this->MEASURE_DOSIS->addErrorMessage(str_replace("%s", $this->MEASURE_DOSIS->caption(), $this->MEASURE_DOSIS->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_DOSIS->FormValue)) {
            $this->MEASURE_DOSIS->addErrorMessage($this->MEASURE_DOSIS->getErrorMessage(false));
        }
        if ($this->AMOUNT_PAID->Required) {
            if (!$this->AMOUNT_PAID->IsDetailKey && EmptyValue($this->AMOUNT_PAID->FormValue)) {
                $this->AMOUNT_PAID->addErrorMessage(str_replace("%s", $this->AMOUNT_PAID->caption(), $this->AMOUNT_PAID->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->AMOUNT_PAID->FormValue)) {
            $this->AMOUNT_PAID->addErrorMessage($this->AMOUNT_PAID->getErrorMessage(false));
        }
        if ($this->ORDER_PRICE->Required) {
            if (!$this->ORDER_PRICE->IsDetailKey && EmptyValue($this->ORDER_PRICE->FormValue)) {
                $this->ORDER_PRICE->addErrorMessage(str_replace("%s", $this->ORDER_PRICE->caption(), $this->ORDER_PRICE->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ORDER_PRICE->FormValue)) {
            $this->ORDER_PRICE->addErrorMessage($this->ORDER_PRICE->getErrorMessage(false));
        }
        if ($this->QUANTITY->Required) {
            if (!$this->QUANTITY->IsDetailKey && EmptyValue($this->QUANTITY->FormValue)) {
                $this->QUANTITY->addErrorMessage(str_replace("%s", $this->QUANTITY->caption(), $this->QUANTITY->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->QUANTITY->FormValue)) {
            $this->QUANTITY->addErrorMessage($this->QUANTITY->getErrorMessage(false));
        }
        if ($this->MEASURE_ID3->Required) {
            if (!$this->MEASURE_ID3->IsDetailKey && EmptyValue($this->MEASURE_ID3->FormValue)) {
                $this->MEASURE_ID3->addErrorMessage(str_replace("%s", $this->MEASURE_ID3->caption(), $this->MEASURE_ID3->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID3->FormValue)) {
            $this->MEASURE_ID3->addErrorMessage($this->MEASURE_ID3->getErrorMessage(false));
        }
        if ($this->SIZE_KEMASAN->Required) {
            if (!$this->SIZE_KEMASAN->IsDetailKey && EmptyValue($this->SIZE_KEMASAN->FormValue)) {
                $this->SIZE_KEMASAN->addErrorMessage(str_replace("%s", $this->SIZE_KEMASAN->caption(), $this->SIZE_KEMASAN->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->SIZE_KEMASAN->FormValue)) {
            $this->SIZE_KEMASAN->addErrorMessage($this->SIZE_KEMASAN->getErrorMessage(false));
        }
        if ($this->MEASURE_ID2->Required) {
            if (!$this->MEASURE_ID2->IsDetailKey && EmptyValue($this->MEASURE_ID2->FormValue)) {
                $this->MEASURE_ID2->addErrorMessage(str_replace("%s", $this->MEASURE_ID2->caption(), $this->MEASURE_ID2->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MEASURE_ID2->FormValue)) {
            $this->MEASURE_ID2->addErrorMessage($this->MEASURE_ID2->getErrorMessage(false));
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
        if ($this->MODIFIED_BY->Required) {
            if (!$this->MODIFIED_BY->IsDetailKey && EmptyValue($this->MODIFIED_BY->FormValue)) {
                $this->MODIFIED_BY->addErrorMessage(str_replace("%s", $this->MODIFIED_BY->caption(), $this->MODIFIED_BY->RequiredErrorMessage));
            }
        }
        if ($this->ISCETAK->Required) {
            if (!$this->ISCETAK->IsDetailKey && EmptyValue($this->ISCETAK->FormValue)) {
                $this->ISCETAK->addErrorMessage(str_replace("%s", $this->ISCETAK->caption(), $this->ISCETAK->RequiredErrorMessage));
            }
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
        if ($this->PRINTQ->Required) {
            if (!$this->PRINTQ->IsDetailKey && EmptyValue($this->PRINTQ->FormValue)) {
                $this->PRINTQ->addErrorMessage(str_replace("%s", $this->PRINTQ->caption(), $this->PRINTQ->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PRINTQ->FormValue)) {
            $this->PRINTQ->addErrorMessage($this->PRINTQ->getErrorMessage(false));
        }
        if ($this->BATCH_NO->Required) {
            if (!$this->BATCH_NO->IsDetailKey && EmptyValue($this->BATCH_NO->FormValue)) {
                $this->BATCH_NO->addErrorMessage(str_replace("%s", $this->BATCH_NO->caption(), $this->BATCH_NO->RequiredErrorMessage));
            }
        }
        if ($this->SERIAL_NB->Required) {
            if (!$this->SERIAL_NB->IsDetailKey && EmptyValue($this->SERIAL_NB->FormValue)) {
                $this->SERIAL_NB->addErrorMessage(str_replace("%s", $this->SERIAL_NB->caption(), $this->SERIAL_NB->RequiredErrorMessage));
            }
        }
        if ($this->EXPIRY_DATE->Required) {
            if (!$this->EXPIRY_DATE->IsDetailKey && EmptyValue($this->EXPIRY_DATE->FormValue)) {
                $this->EXPIRY_DATE->addErrorMessage(str_replace("%s", $this->EXPIRY_DATE->caption(), $this->EXPIRY_DATE->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->EXPIRY_DATE->FormValue)) {
            $this->EXPIRY_DATE->addErrorMessage($this->EXPIRY_DATE->getErrorMessage(false));
        }
        if ($this->STATUS_PASIEN_ID->Required) {
            if (!$this->STATUS_PASIEN_ID->IsDetailKey && EmptyValue($this->STATUS_PASIEN_ID->FormValue)) {
                $this->STATUS_PASIEN_ID->addErrorMessage(str_replace("%s", $this->STATUS_PASIEN_ID->caption(), $this->STATUS_PASIEN_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->STATUS_PASIEN_ID->FormValue)) {
            $this->STATUS_PASIEN_ID->addErrorMessage($this->STATUS_PASIEN_ID->getErrorMessage(false));
        }
        if ($this->MONTH_ID->Required) {
            if (!$this->MONTH_ID->IsDetailKey && EmptyValue($this->MONTH_ID->FormValue)) {
                $this->MONTH_ID->addErrorMessage(str_replace("%s", $this->MONTH_ID->caption(), $this->MONTH_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->MONTH_ID->FormValue)) {
            $this->MONTH_ID->addErrorMessage($this->MONTH_ID->getErrorMessage(false));
        }
        if ($this->YEAR_ID->Required) {
            if (!$this->YEAR_ID->IsDetailKey && EmptyValue($this->YEAR_ID->FormValue)) {
                $this->YEAR_ID->addErrorMessage(str_replace("%s", $this->YEAR_ID->caption(), $this->YEAR_ID->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->YEAR_ID->FormValue)) {
            $this->YEAR_ID->addErrorMessage($this->YEAR_ID->getErrorMessage(false));
        }
        if ($this->IDX->Required) {
            if (!$this->IDX->IsDetailKey && EmptyValue($this->IDX->FormValue)) {
                $this->IDX->addErrorMessage(str_replace("%s", $this->IDX->caption(), $this->IDX->RequiredErrorMessage));
            }
        }
        if ($this->CLINIC_ID->Required) {
            if (!$this->CLINIC_ID->IsDetailKey && EmptyValue($this->CLINIC_ID->FormValue)) {
                $this->CLINIC_ID->addErrorMessage(str_replace("%s", $this->CLINIC_ID->caption(), $this->CLINIC_ID->RequiredErrorMessage));
            }
        }
        if ($this->PPN->Required) {
            if (!$this->PPN->IsDetailKey && EmptyValue($this->PPN->FormValue)) {
                $this->PPN->addErrorMessage(str_replace("%s", $this->PPN->caption(), $this->PPN->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->PPN->FormValue)) {
            $this->PPN->addErrorMessage($this->PPN->getErrorMessage(false));
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

            // ITEM_ID
            $this->ITEM_ID->setDbValueDef($rsnew, $this->ITEM_ID->CurrentValue, "", $this->ITEM_ID->ReadOnly);

            // INVOICE_ID
            $this->INVOICE_ID->setDbValueDef($rsnew, $this->INVOICE_ID->CurrentValue, null, $this->INVOICE_ID->ReadOnly);

            // BRAND_ID
            $this->BRAND_ID->setDbValueDef($rsnew, $this->BRAND_ID->CurrentValue, "", $this->BRAND_ID->ReadOnly);

            // BRAND_NAME
            $this->BRAND_NAME->setDbValueDef($rsnew, $this->BRAND_NAME->CurrentValue, null, $this->BRAND_NAME->ReadOnly);

            // ORDER_DATE
            $this->ORDER_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ORDER_DATE->CurrentValue, 11), null, $this->ORDER_DATE->ReadOnly);

            // ATP_DATE
            $this->ATP_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->ATP_DATE->CurrentValue, 11), null, $this->ATP_DATE->ReadOnly);

            // DELIVERY_DATE
            $this->DELIVERY_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->DELIVERY_DATE->CurrentValue, 111), null, $this->DELIVERY_DATE->ReadOnly);

            // PO
            $this->PO->setDbValueDef($rsnew, $this->PO->CurrentValue, null, $this->PO->ReadOnly);

            // UNIT_PRICE
            $this->UNIT_PRICE->setDbValueDef($rsnew, $this->UNIT_PRICE->CurrentValue, null, $this->UNIT_PRICE->ReadOnly);

            // COMPANY_ID
            $this->COMPANY_ID->setDbValueDef($rsnew, $this->COMPANY_ID->CurrentValue, null, $this->COMPANY_ID->ReadOnly);

            // ORDER_QUANTITY
            $this->ORDER_QUANTITY->setDbValueDef($rsnew, $this->ORDER_QUANTITY->CurrentValue, null, $this->ORDER_QUANTITY->ReadOnly);

            // RECEIVED_QUANTITY
            $this->RECEIVED_QUANTITY->setDbValueDef($rsnew, $this->RECEIVED_QUANTITY->CurrentValue, null, $this->RECEIVED_QUANTITY->ReadOnly);

            // DISCOUNT
            $this->DISCOUNT->setDbValueDef($rsnew, $this->DISCOUNT->CurrentValue, null, $this->DISCOUNT->ReadOnly);

            // DISCOUNT2
            $this->DISCOUNT2->setDbValueDef($rsnew, $this->DISCOUNT2->CurrentValue, null, $this->DISCOUNT2->ReadOnly);

            // DISCOUNTOFF
            $this->DISCOUNTOFF->setDbValueDef($rsnew, $this->DISCOUNTOFF->CurrentValue, null, $this->DISCOUNTOFF->ReadOnly);

            // MEASURE_ID
            $this->MEASURE_ID->setDbValueDef($rsnew, $this->MEASURE_ID->CurrentValue, null, $this->MEASURE_ID->ReadOnly);

            // SIZE_GOODS
            $this->SIZE_GOODS->setDbValueDef($rsnew, $this->SIZE_GOODS->CurrentValue, null, $this->SIZE_GOODS->ReadOnly);

            // MEASURE_DOSIS
            $this->MEASURE_DOSIS->setDbValueDef($rsnew, $this->MEASURE_DOSIS->CurrentValue, null, $this->MEASURE_DOSIS->ReadOnly);

            // AMOUNT_PAID
            $this->AMOUNT_PAID->setDbValueDef($rsnew, $this->AMOUNT_PAID->CurrentValue, null, $this->AMOUNT_PAID->ReadOnly);

            // ORDER_PRICE
            $this->ORDER_PRICE->setDbValueDef($rsnew, $this->ORDER_PRICE->CurrentValue, null, $this->ORDER_PRICE->ReadOnly);

            // QUANTITY
            $this->QUANTITY->setDbValueDef($rsnew, $this->QUANTITY->CurrentValue, null, $this->QUANTITY->ReadOnly);

            // MEASURE_ID3
            $this->MEASURE_ID3->setDbValueDef($rsnew, $this->MEASURE_ID3->CurrentValue, null, $this->MEASURE_ID3->ReadOnly);

            // SIZE_KEMASAN
            $this->SIZE_KEMASAN->setDbValueDef($rsnew, $this->SIZE_KEMASAN->CurrentValue, null, $this->SIZE_KEMASAN->ReadOnly);

            // MEASURE_ID2
            $this->MEASURE_ID2->setDbValueDef($rsnew, $this->MEASURE_ID2->CurrentValue, null, $this->MEASURE_ID2->ReadOnly);

            // DESCRIPTION
            $this->DESCRIPTION->setDbValueDef($rsnew, $this->DESCRIPTION->CurrentValue, null, $this->DESCRIPTION->ReadOnly);

            // MODIFIED_DATE
            $this->MODIFIED_DATE->CurrentValue = CurrentDateTime();
            $this->MODIFIED_DATE->setDbValueDef($rsnew, $this->MODIFIED_DATE->CurrentValue, null);

            // MODIFIED_BY
            $this->MODIFIED_BY->CurrentValue = CurrentUserName();
            $this->MODIFIED_BY->setDbValueDef($rsnew, $this->MODIFIED_BY->CurrentValue, null);

            // ISCETAK
            $this->ISCETAK->setDbValueDef($rsnew, $this->ISCETAK->CurrentValue, null, $this->ISCETAK->ReadOnly);

            // PRINT_DATE
            $this->PRINT_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->PRINT_DATE->CurrentValue, 0), null, $this->PRINT_DATE->ReadOnly);

            // PRINTED_BY
            $this->PRINTED_BY->setDbValueDef($rsnew, $this->PRINTED_BY->CurrentValue, null, $this->PRINTED_BY->ReadOnly);

            // PRINTQ
            $this->PRINTQ->setDbValueDef($rsnew, $this->PRINTQ->CurrentValue, null, $this->PRINTQ->ReadOnly);

            // BATCH_NO
            $this->BATCH_NO->setDbValueDef($rsnew, $this->BATCH_NO->CurrentValue, null, $this->BATCH_NO->ReadOnly);

            // SERIAL_NB
            $this->SERIAL_NB->setDbValueDef($rsnew, $this->SERIAL_NB->CurrentValue, null, $this->SERIAL_NB->ReadOnly);

            // EXPIRY_DATE
            $this->EXPIRY_DATE->setDbValueDef($rsnew, UnFormatDateTime($this->EXPIRY_DATE->CurrentValue, 0), null, $this->EXPIRY_DATE->ReadOnly);

            // STATUS_PASIEN_ID
            $this->STATUS_PASIEN_ID->setDbValueDef($rsnew, $this->STATUS_PASIEN_ID->CurrentValue, null, $this->STATUS_PASIEN_ID->ReadOnly);

            // MONTH_ID
            $this->MONTH_ID->setDbValueDef($rsnew, $this->MONTH_ID->CurrentValue, null, $this->MONTH_ID->ReadOnly);

            // YEAR_ID
            $this->YEAR_ID->setDbValueDef($rsnew, $this->YEAR_ID->CurrentValue, null, $this->YEAR_ID->ReadOnly);

            // CLINIC_ID
            $this->CLINIC_ID->setDbValueDef($rsnew, $this->CLINIC_ID->CurrentValue, null, $this->CLINIC_ID->ReadOnly);

            // PPN
            $this->PPN->setDbValueDef($rsnew, $this->PPN->CurrentValue, null, $this->PPN->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PoInvoiceitemList"), "", $this->TableVar, true);
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
