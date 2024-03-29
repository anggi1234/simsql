<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for PASIEN_DIAGNOSAS
 */
class PasienDiagnosas extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $PASIEN_DIAGNOSA_ID;
    public $DIAGNOSA_ID;
    public $DIAGNOSA_NAME;
    public $DIAGNOSA_DESC;
    public $DIAG_CAT;
    public $MODIFIED_DATE;
    public $MODIFIED_BY;
    public $SUFFER_TYPE;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'PASIEN_DIAGNOSAS';
        $this->TableName = 'PASIEN_DIAGNOSAS';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[PASIEN_DIAGNOSAS]";
        $this->Dbid = 'DB';
        $this->ExportAll = false;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // PASIEN_DIAGNOSA_ID
        $this->PASIEN_DIAGNOSA_ID = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_PASIEN_DIAGNOSA_ID', 'PASIEN_DIAGNOSA_ID', '[PASIEN_DIAGNOSA_ID]', '[PASIEN_DIAGNOSA_ID]', 200, 50, -1, false, '[PASIEN_DIAGNOSA_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->PASIEN_DIAGNOSA_ID->IsPrimaryKey = true; // Primary key field
        $this->PASIEN_DIAGNOSA_ID->Nullable = false; // NOT NULL field
        $this->PASIEN_DIAGNOSA_ID->Required = true; // Required field
        $this->PASIEN_DIAGNOSA_ID->Sortable = true; // Allow sort
        $this->PASIEN_DIAGNOSA_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->PASIEN_DIAGNOSA_ID->Param, "CustomMsg");
        $this->Fields['PASIEN_DIAGNOSA_ID'] = &$this->PASIEN_DIAGNOSA_ID;

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_DIAGNOSA_ID', 'DIAGNOSA_ID', '[DIAGNOSA_ID]', '[DIAGNOSA_ID]', 200, 50, -1, false, '[DIAGNOSA_ID]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_ID->IsPrimaryKey = true; // Primary key field
        $this->DIAGNOSA_ID->Nullable = false; // NOT NULL field
        $this->DIAGNOSA_ID->Required = true; // Required field
        $this->DIAGNOSA_ID->Sortable = true; // Allow sort
        $this->DIAGNOSA_ID->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_ID->Param, "CustomMsg");
        $this->Fields['DIAGNOSA_ID'] = &$this->DIAGNOSA_ID;

        // DIAGNOSA_NAME
        $this->DIAGNOSA_NAME = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_DIAGNOSA_NAME', 'DIAGNOSA_NAME', '[DIAGNOSA_NAME]', '[DIAGNOSA_NAME]', 200, 250, -1, false, '[DIAGNOSA_NAME]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_NAME->Sortable = true; // Allow sort
        $this->DIAGNOSA_NAME->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_NAME->Param, "CustomMsg");
        $this->Fields['DIAGNOSA_NAME'] = &$this->DIAGNOSA_NAME;

        // DIAGNOSA_DESC
        $this->DIAGNOSA_DESC = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_DIAGNOSA_DESC', 'DIAGNOSA_DESC', '[DIAGNOSA_DESC]', '[DIAGNOSA_DESC]', 200, 250, -1, false, '[DIAGNOSA_DESC]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAGNOSA_DESC->Sortable = true; // Allow sort
        $this->DIAGNOSA_DESC->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAGNOSA_DESC->Param, "CustomMsg");
        $this->Fields['DIAGNOSA_DESC'] = &$this->DIAGNOSA_DESC;

        // DIAG_CAT
        $this->DIAG_CAT = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_DIAG_CAT', 'DIAG_CAT', '[DIAG_CAT]', 'CAST([DIAG_CAT] AS NVARCHAR)', 17, 1, -1, false, '[DIAG_CAT]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DIAG_CAT->Sortable = true; // Allow sort
        $this->DIAG_CAT->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->DIAG_CAT->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DIAG_CAT->Param, "CustomMsg");
        $this->Fields['DIAG_CAT'] = &$this->DIAG_CAT;

        // MODIFIED_DATE
        $this->MODIFIED_DATE = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_MODIFIED_DATE', 'MODIFIED_DATE', '[MODIFIED_DATE]', CastDateFieldForLike("[MODIFIED_DATE]", 0, "DB"), 135, 8, 0, false, '[MODIFIED_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_DATE->Sortable = true; // Allow sort
        $this->MODIFIED_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->MODIFIED_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_DATE->Param, "CustomMsg");
        $this->Fields['MODIFIED_DATE'] = &$this->MODIFIED_DATE;

        // MODIFIED_BY
        $this->MODIFIED_BY = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_MODIFIED_BY', 'MODIFIED_BY', '[MODIFIED_BY]', '[MODIFIED_BY]', 200, 50, -1, false, '[MODIFIED_BY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->MODIFIED_BY->Sortable = true; // Allow sort
        $this->MODIFIED_BY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->MODIFIED_BY->Param, "CustomMsg");
        $this->Fields['MODIFIED_BY'] = &$this->MODIFIED_BY;

        // SUFFER_TYPE
        $this->SUFFER_TYPE = new DbField('PASIEN_DIAGNOSAS', 'PASIEN_DIAGNOSAS', 'x_SUFFER_TYPE', 'SUFFER_TYPE', '[SUFFER_TYPE]', 'CAST([SUFFER_TYPE] AS NVARCHAR)', 17, 1, -1, false, '[SUFFER_TYPE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->SUFFER_TYPE->Sortable = true; // Allow sort
        $this->SUFFER_TYPE->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->SUFFER_TYPE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->SUFFER_TYPE->Param, "CustomMsg");
        $this->Fields['SUFFER_TYPE'] = &$this->SUFFER_TYPE;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[PASIEN_DIAGNOSAS]";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('PASIEN_DIAGNOSA_ID', $rs)) {
                AddFilter($where, QuotedName('PASIEN_DIAGNOSA_ID', $this->Dbid) . '=' . QuotedValue($rs['PASIEN_DIAGNOSA_ID'], $this->PASIEN_DIAGNOSA_ID->DataType, $this->Dbid));
            }
            if (array_key_exists('DIAGNOSA_ID', $rs)) {
                AddFilter($where, QuotedName('DIAGNOSA_ID', $this->Dbid) . '=' . QuotedValue($rs['DIAGNOSA_ID'], $this->DIAGNOSA_ID->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->PASIEN_DIAGNOSA_ID->DbValue = $row['PASIEN_DIAGNOSA_ID'];
        $this->DIAGNOSA_ID->DbValue = $row['DIAGNOSA_ID'];
        $this->DIAGNOSA_NAME->DbValue = $row['DIAGNOSA_NAME'];
        $this->DIAGNOSA_DESC->DbValue = $row['DIAGNOSA_DESC'];
        $this->DIAG_CAT->DbValue = $row['DIAG_CAT'];
        $this->MODIFIED_DATE->DbValue = $row['MODIFIED_DATE'];
        $this->MODIFIED_BY->DbValue = $row['MODIFIED_BY'];
        $this->SUFFER_TYPE->DbValue = $row['SUFFER_TYPE'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[PASIEN_DIAGNOSA_ID] = '@PASIEN_DIAGNOSA_ID@' AND [DIAGNOSA_ID] = '@DIAGNOSA_ID@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->PASIEN_DIAGNOSA_ID->CurrentValue : $this->PASIEN_DIAGNOSA_ID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->DIAGNOSA_ID->CurrentValue : $this->DIAGNOSA_ID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 2) {
            if ($current) {
                $this->PASIEN_DIAGNOSA_ID->CurrentValue = $keys[0];
            } else {
                $this->PASIEN_DIAGNOSA_ID->OldValue = $keys[0];
            }
            if ($current) {
                $this->DIAGNOSA_ID->CurrentValue = $keys[1];
            } else {
                $this->DIAGNOSA_ID->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('PASIEN_DIAGNOSA_ID', $row) ? $row['PASIEN_DIAGNOSA_ID'] : null;
        } else {
            $val = $this->PASIEN_DIAGNOSA_ID->OldValue !== null ? $this->PASIEN_DIAGNOSA_ID->OldValue : $this->PASIEN_DIAGNOSA_ID->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@PASIEN_DIAGNOSA_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('DIAGNOSA_ID', $row) ? $row['DIAGNOSA_ID'] : null;
        } else {
            $val = $this->DIAGNOSA_ID->OldValue !== null ? $this->DIAGNOSA_ID->OldValue : $this->DIAGNOSA_ID->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@DIAGNOSA_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("PasienDiagnosasList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "PasienDiagnosasView") {
            return $Language->phrase("View");
        } elseif ($pageName == "PasienDiagnosasEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "PasienDiagnosasAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "PasienDiagnosasView";
            case Config("API_ADD_ACTION"):
                return "PasienDiagnosasAdd";
            case Config("API_EDIT_ACTION"):
                return "PasienDiagnosasEdit";
            case Config("API_DELETE_ACTION"):
                return "PasienDiagnosasDelete";
            case Config("API_LIST_ACTION"):
                return "PasienDiagnosasList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "PasienDiagnosasList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PasienDiagnosasView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PasienDiagnosasView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PasienDiagnosasAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "PasienDiagnosasAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("PasienDiagnosasEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("PasienDiagnosasAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("PasienDiagnosasDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "PASIEN_DIAGNOSA_ID:" . JsonEncode($this->PASIEN_DIAGNOSA_ID->CurrentValue, "string");
        $json .= ",DIAGNOSA_ID:" . JsonEncode($this->DIAGNOSA_ID->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->PASIEN_DIAGNOSA_ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->PASIEN_DIAGNOSA_ID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->DIAGNOSA_ID->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->DIAGNOSA_ID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [141, 201, 203, 128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("PASIEN_DIAGNOSA_ID") ?? Route("PASIEN_DIAGNOSA_ID")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("DIAGNOSA_ID") ?? Route("DIAGNOSA_ID")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->PASIEN_DIAGNOSA_ID->CurrentValue = $key[0];
            } else {
                $this->PASIEN_DIAGNOSA_ID->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->DIAGNOSA_ID->CurrentValue = $key[1];
            } else {
                $this->DIAGNOSA_ID->OldValue = $key[1];
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->PASIEN_DIAGNOSA_ID->setDbValue($row['PASIEN_DIAGNOSA_ID']);
        $this->DIAGNOSA_ID->setDbValue($row['DIAGNOSA_ID']);
        $this->DIAGNOSA_NAME->setDbValue($row['DIAGNOSA_NAME']);
        $this->DIAGNOSA_DESC->setDbValue($row['DIAGNOSA_DESC']);
        $this->DIAG_CAT->setDbValue($row['DIAG_CAT']);
        $this->MODIFIED_DATE->setDbValue($row['MODIFIED_DATE']);
        $this->MODIFIED_BY->setDbValue($row['MODIFIED_BY']);
        $this->SUFFER_TYPE->setDbValue($row['SUFFER_TYPE']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // PASIEN_DIAGNOSA_ID

        // DIAGNOSA_ID

        // DIAGNOSA_NAME

        // DIAGNOSA_DESC

        // DIAG_CAT

        // MODIFIED_DATE

        // MODIFIED_BY

        // SUFFER_TYPE

        // PASIEN_DIAGNOSA_ID
        $this->PASIEN_DIAGNOSA_ID->ViewValue = $this->PASIEN_DIAGNOSA_ID->CurrentValue;
        $this->PASIEN_DIAGNOSA_ID->ViewCustomAttributes = "";

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->ViewValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->DIAGNOSA_ID->ViewCustomAttributes = "";

        // DIAGNOSA_NAME
        $this->DIAGNOSA_NAME->ViewValue = $this->DIAGNOSA_NAME->CurrentValue;
        $this->DIAGNOSA_NAME->ViewCustomAttributes = "";

        // DIAGNOSA_DESC
        $this->DIAGNOSA_DESC->ViewValue = $this->DIAGNOSA_DESC->CurrentValue;
        $this->DIAGNOSA_DESC->ViewCustomAttributes = "";

        // DIAG_CAT
        $this->DIAG_CAT->ViewValue = $this->DIAG_CAT->CurrentValue;
        $this->DIAG_CAT->ViewValue = FormatNumber($this->DIAG_CAT->ViewValue, 0, -2, -2, -2);
        $this->DIAG_CAT->ViewCustomAttributes = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->ViewValue = $this->MODIFIED_DATE->CurrentValue;
        $this->MODIFIED_DATE->ViewValue = FormatDateTime($this->MODIFIED_DATE->ViewValue, 0);
        $this->MODIFIED_DATE->ViewCustomAttributes = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->ViewValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->ViewCustomAttributes = "";

        // SUFFER_TYPE
        $this->SUFFER_TYPE->ViewValue = $this->SUFFER_TYPE->CurrentValue;
        $this->SUFFER_TYPE->ViewValue = FormatNumber($this->SUFFER_TYPE->ViewValue, 0, -2, -2, -2);
        $this->SUFFER_TYPE->ViewCustomAttributes = "";

        // PASIEN_DIAGNOSA_ID
        $this->PASIEN_DIAGNOSA_ID->LinkCustomAttributes = "";
        $this->PASIEN_DIAGNOSA_ID->HrefValue = "";
        $this->PASIEN_DIAGNOSA_ID->TooltipValue = "";

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->LinkCustomAttributes = "";
        $this->DIAGNOSA_ID->HrefValue = "";
        $this->DIAGNOSA_ID->TooltipValue = "";

        // DIAGNOSA_NAME
        $this->DIAGNOSA_NAME->LinkCustomAttributes = "";
        $this->DIAGNOSA_NAME->HrefValue = "";
        $this->DIAGNOSA_NAME->TooltipValue = "";

        // DIAGNOSA_DESC
        $this->DIAGNOSA_DESC->LinkCustomAttributes = "";
        $this->DIAGNOSA_DESC->HrefValue = "";
        $this->DIAGNOSA_DESC->TooltipValue = "";

        // DIAG_CAT
        $this->DIAG_CAT->LinkCustomAttributes = "";
        $this->DIAG_CAT->HrefValue = "";
        $this->DIAG_CAT->TooltipValue = "";

        // MODIFIED_DATE
        $this->MODIFIED_DATE->LinkCustomAttributes = "";
        $this->MODIFIED_DATE->HrefValue = "";
        $this->MODIFIED_DATE->TooltipValue = "";

        // MODIFIED_BY
        $this->MODIFIED_BY->LinkCustomAttributes = "";
        $this->MODIFIED_BY->HrefValue = "";
        $this->MODIFIED_BY->TooltipValue = "";

        // SUFFER_TYPE
        $this->SUFFER_TYPE->LinkCustomAttributes = "";
        $this->SUFFER_TYPE->HrefValue = "";
        $this->SUFFER_TYPE->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // PASIEN_DIAGNOSA_ID
        $this->PASIEN_DIAGNOSA_ID->EditAttrs["class"] = "form-control";
        $this->PASIEN_DIAGNOSA_ID->EditCustomAttributes = "";
        if (!$this->PASIEN_DIAGNOSA_ID->Raw) {
            $this->PASIEN_DIAGNOSA_ID->CurrentValue = HtmlDecode($this->PASIEN_DIAGNOSA_ID->CurrentValue);
        }
        $this->PASIEN_DIAGNOSA_ID->EditValue = $this->PASIEN_DIAGNOSA_ID->CurrentValue;
        $this->PASIEN_DIAGNOSA_ID->PlaceHolder = RemoveHtml($this->PASIEN_DIAGNOSA_ID->caption());

        // DIAGNOSA_ID
        $this->DIAGNOSA_ID->EditAttrs["class"] = "form-control";
        $this->DIAGNOSA_ID->EditCustomAttributes = "";
        if (!$this->DIAGNOSA_ID->Raw) {
            $this->DIAGNOSA_ID->CurrentValue = HtmlDecode($this->DIAGNOSA_ID->CurrentValue);
        }
        $this->DIAGNOSA_ID->EditValue = $this->DIAGNOSA_ID->CurrentValue;
        $this->DIAGNOSA_ID->PlaceHolder = RemoveHtml($this->DIAGNOSA_ID->caption());

        // DIAGNOSA_NAME
        $this->DIAGNOSA_NAME->EditAttrs["class"] = "form-control";
        $this->DIAGNOSA_NAME->EditCustomAttributes = "";
        if (!$this->DIAGNOSA_NAME->Raw) {
            $this->DIAGNOSA_NAME->CurrentValue = HtmlDecode($this->DIAGNOSA_NAME->CurrentValue);
        }
        $this->DIAGNOSA_NAME->EditValue = $this->DIAGNOSA_NAME->CurrentValue;
        $this->DIAGNOSA_NAME->PlaceHolder = RemoveHtml($this->DIAGNOSA_NAME->caption());

        // DIAGNOSA_DESC
        $this->DIAGNOSA_DESC->EditAttrs["class"] = "form-control";
        $this->DIAGNOSA_DESC->EditCustomAttributes = "";
        if (!$this->DIAGNOSA_DESC->Raw) {
            $this->DIAGNOSA_DESC->CurrentValue = HtmlDecode($this->DIAGNOSA_DESC->CurrentValue);
        }
        $this->DIAGNOSA_DESC->EditValue = $this->DIAGNOSA_DESC->CurrentValue;
        $this->DIAGNOSA_DESC->PlaceHolder = RemoveHtml($this->DIAGNOSA_DESC->caption());

        // DIAG_CAT
        $this->DIAG_CAT->EditAttrs["class"] = "form-control";
        $this->DIAG_CAT->EditCustomAttributes = "";
        $this->DIAG_CAT->EditValue = $this->DIAG_CAT->CurrentValue;
        $this->DIAG_CAT->PlaceHolder = RemoveHtml($this->DIAG_CAT->caption());

        // MODIFIED_DATE
        $this->MODIFIED_DATE->EditAttrs["class"] = "form-control";
        $this->MODIFIED_DATE->EditCustomAttributes = "";
        $this->MODIFIED_DATE->EditValue = FormatDateTime($this->MODIFIED_DATE->CurrentValue, 8);
        $this->MODIFIED_DATE->PlaceHolder = RemoveHtml($this->MODIFIED_DATE->caption());

        // MODIFIED_BY
        $this->MODIFIED_BY->EditAttrs["class"] = "form-control";
        $this->MODIFIED_BY->EditCustomAttributes = "";
        if (!$this->MODIFIED_BY->Raw) {
            $this->MODIFIED_BY->CurrentValue = HtmlDecode($this->MODIFIED_BY->CurrentValue);
        }
        $this->MODIFIED_BY->EditValue = $this->MODIFIED_BY->CurrentValue;
        $this->MODIFIED_BY->PlaceHolder = RemoveHtml($this->MODIFIED_BY->caption());

        // SUFFER_TYPE
        $this->SUFFER_TYPE->EditAttrs["class"] = "form-control";
        $this->SUFFER_TYPE->EditCustomAttributes = "";
        $this->SUFFER_TYPE->EditValue = $this->SUFFER_TYPE->CurrentValue;
        $this->SUFFER_TYPE->PlaceHolder = RemoveHtml($this->SUFFER_TYPE->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->PASIEN_DIAGNOSA_ID);
                    $doc->exportCaption($this->DIAGNOSA_ID);
                    $doc->exportCaption($this->DIAGNOSA_NAME);
                    $doc->exportCaption($this->DIAGNOSA_DESC);
                    $doc->exportCaption($this->DIAG_CAT);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->SUFFER_TYPE);
                } else {
                    $doc->exportCaption($this->PASIEN_DIAGNOSA_ID);
                    $doc->exportCaption($this->DIAGNOSA_ID);
                    $doc->exportCaption($this->DIAGNOSA_NAME);
                    $doc->exportCaption($this->DIAGNOSA_DESC);
                    $doc->exportCaption($this->DIAG_CAT);
                    $doc->exportCaption($this->MODIFIED_DATE);
                    $doc->exportCaption($this->MODIFIED_BY);
                    $doc->exportCaption($this->SUFFER_TYPE);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->PASIEN_DIAGNOSA_ID);
                        $doc->exportField($this->DIAGNOSA_ID);
                        $doc->exportField($this->DIAGNOSA_NAME);
                        $doc->exportField($this->DIAGNOSA_DESC);
                        $doc->exportField($this->DIAG_CAT);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->SUFFER_TYPE);
                    } else {
                        $doc->exportField($this->PASIEN_DIAGNOSA_ID);
                        $doc->exportField($this->DIAGNOSA_ID);
                        $doc->exportField($this->DIAGNOSA_NAME);
                        $doc->exportField($this->DIAGNOSA_DESC);
                        $doc->exportField($this->DIAG_CAT);
                        $doc->exportField($this->MODIFIED_DATE);
                        $doc->exportField($this->MODIFIED_BY);
                        $doc->exportField($this->SUFFER_TYPE);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
