<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for AuditTrail
 */
class AuditTrail extends DbTable
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
    public $Id;
    public $DateTime;
    public $Script;
    public $User;
    public $_Action;
    public $_Table;
    public $Field;
    public $KeyValue;
    public $OldValue;
    public $NewValue;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'AuditTrail';
        $this->TableName = 'AuditTrail';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[AuditTrail]";
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

        // Id
        $this->Id = new DbField('AuditTrail', 'AuditTrail', 'x_Id', 'Id', '[Id]', 'CAST([Id] AS NVARCHAR)', 3, 4, -1, false, '[Id]', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->Id->IsAutoIncrement = true; // Autoincrement field
        $this->Id->IsPrimaryKey = true; // Primary key field
        $this->Id->Nullable = false; // NOT NULL field
        $this->Id->Sortable = true; // Allow sort
        $this->Id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Id->Param, "CustomMsg");
        $this->Fields['Id'] = &$this->Id;

        // DateTime
        $this->DateTime = new DbField('AuditTrail', 'AuditTrail', 'x_DateTime', 'DateTime', '[DateTime]', CastDateFieldForLike("[DateTime]", 0, "DB"), 135, 8, 0, false, '[DateTime]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->DateTime->Nullable = false; // NOT NULL field
        $this->DateTime->Required = true; // Required field
        $this->DateTime->Sortable = true; // Allow sort
        $this->DateTime->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->DateTime->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->DateTime->Param, "CustomMsg");
        $this->Fields['DateTime'] = &$this->DateTime;

        // Script
        $this->Script = new DbField('AuditTrail', 'AuditTrail', 'x_Script', 'Script', '[Script]', '[Script]', 202, 255, -1, false, '[Script]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Script->Sortable = true; // Allow sort
        $this->Script->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Script->Param, "CustomMsg");
        $this->Fields['Script'] = &$this->Script;

        // User
        $this->User = new DbField('AuditTrail', 'AuditTrail', 'x_User', 'User', '[User]', '[User]', 202, 255, -1, false, '[User]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->User->Sortable = true; // Allow sort
        $this->User->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->User->Param, "CustomMsg");
        $this->Fields['User'] = &$this->User;

        // Action
        $this->_Action = new DbField('AuditTrail', 'AuditTrail', 'x__Action', 'Action', '[Action]', '[Action]', 202, 255, -1, false, '[Action]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_Action->Sortable = true; // Allow sort
        $this->_Action->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_Action->Param, "CustomMsg");
        $this->Fields['Action'] = &$this->_Action;

        // Table
        $this->_Table = new DbField('AuditTrail', 'AuditTrail', 'x__Table', 'Table', '[Table]', '[Table]', 202, 255, -1, false, '[Table]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_Table->Sortable = true; // Allow sort
        $this->_Table->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_Table->Param, "CustomMsg");
        $this->Fields['Table'] = &$this->_Table;

        // Field
        $this->Field = new DbField('AuditTrail', 'AuditTrail', 'x_Field', 'Field', '[Field]', '[Field]', 202, 255, -1, false, '[Field]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->Field->Sortable = true; // Allow sort
        $this->Field->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->Field->Param, "CustomMsg");
        $this->Fields['Field'] = &$this->Field;

        // KeyValue
        $this->KeyValue = new DbField('AuditTrail', 'AuditTrail', 'x_KeyValue', 'KeyValue', '[KeyValue]', '[KeyValue]', 203, 0, -1, false, '[KeyValue]', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->KeyValue->Sortable = true; // Allow sort
        $this->KeyValue->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KeyValue->Param, "CustomMsg");
        $this->Fields['KeyValue'] = &$this->KeyValue;

        // OldValue
        $this->OldValue = new DbField('AuditTrail', 'AuditTrail', 'x_OldValue', 'OldValue', '[OldValue]', '[OldValue]', 203, 0, -1, false, '[OldValue]', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->OldValue->Sortable = true; // Allow sort
        $this->OldValue->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->OldValue->Param, "CustomMsg");
        $this->Fields['OldValue'] = &$this->OldValue;

        // NewValue
        $this->NewValue = new DbField('AuditTrail', 'AuditTrail', 'x_NewValue', 'NewValue', '[NewValue]', '[NewValue]', 203, 0, -1, false, '[NewValue]', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->NewValue->Sortable = true; // Allow sort
        $this->NewValue->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NewValue->Param, "CustomMsg");
        $this->Fields['NewValue'] = &$this->NewValue;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[AuditTrail]";
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
            // Get insert id if necessary
            $this->Id->setDbValue($conn->lastInsertId());
            $rs['Id'] = $this->Id->DbValue;
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
            if (array_key_exists('Id', $rs)) {
                AddFilter($where, QuotedName('Id', $this->Dbid) . '=' . QuotedValue($rs['Id'], $this->Id->DataType, $this->Dbid));
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
        $this->Id->DbValue = $row['Id'];
        $this->DateTime->DbValue = $row['DateTime'];
        $this->Script->DbValue = $row['Script'];
        $this->User->DbValue = $row['User'];
        $this->_Action->DbValue = $row['Action'];
        $this->_Table->DbValue = $row['Table'];
        $this->Field->DbValue = $row['Field'];
        $this->KeyValue->DbValue = $row['KeyValue'];
        $this->OldValue->DbValue = $row['OldValue'];
        $this->NewValue->DbValue = $row['NewValue'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[Id] = @Id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Id->CurrentValue : $this->Id->OldValue;
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
        if (count($keys) == 1) {
            if ($current) {
                $this->Id->CurrentValue = $keys[0];
            } else {
                $this->Id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Id', $row) ? $row['Id'] : null;
        } else {
            $val = $this->Id->OldValue !== null ? $this->Id->OldValue : $this->Id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("AuditTrailList");
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
        if ($pageName == "AuditTrailView") {
            return $Language->phrase("View");
        } elseif ($pageName == "AuditTrailEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "AuditTrailAdd") {
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
                return "AuditTrailView";
            case Config("API_ADD_ACTION"):
                return "AuditTrailAdd";
            case Config("API_EDIT_ACTION"):
                return "AuditTrailEdit";
            case Config("API_DELETE_ACTION"):
                return "AuditTrailDelete";
            case Config("API_LIST_ACTION"):
                return "AuditTrailList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "AuditTrailList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("AuditTrailView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("AuditTrailView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "AuditTrailAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "AuditTrailAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("AuditTrailEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("AuditTrailAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("AuditTrailDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "Id:" . JsonEncode($this->Id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->Id->CurrentValue);
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
        } else {
            if (($keyValue = Param("Id") ?? Route("Id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
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
                $this->Id->CurrentValue = $key;
            } else {
                $this->Id->OldValue = $key;
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
        $this->Id->setDbValue($row['Id']);
        $this->DateTime->setDbValue($row['DateTime']);
        $this->Script->setDbValue($row['Script']);
        $this->User->setDbValue($row['User']);
        $this->_Action->setDbValue($row['Action']);
        $this->_Table->setDbValue($row['Table']);
        $this->Field->setDbValue($row['Field']);
        $this->KeyValue->setDbValue($row['KeyValue']);
        $this->OldValue->setDbValue($row['OldValue']);
        $this->NewValue->setDbValue($row['NewValue']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // Id

        // DateTime

        // Script

        // User

        // Action

        // Table

        // Field

        // KeyValue

        // OldValue

        // NewValue

        // Id
        $this->Id->ViewValue = $this->Id->CurrentValue;
        $this->Id->ViewCustomAttributes = "";

        // DateTime
        $this->DateTime->ViewValue = $this->DateTime->CurrentValue;
        $this->DateTime->ViewValue = FormatDateTime($this->DateTime->ViewValue, 0);
        $this->DateTime->ViewCustomAttributes = "";

        // Script
        $this->Script->ViewValue = $this->Script->CurrentValue;
        $this->Script->ViewCustomAttributes = "";

        // User
        $this->User->ViewValue = $this->User->CurrentValue;
        $this->User->ViewCustomAttributes = "";

        // Action
        $this->_Action->ViewValue = $this->_Action->CurrentValue;
        $this->_Action->ViewCustomAttributes = "";

        // Table
        $this->_Table->ViewValue = $this->_Table->CurrentValue;
        $this->_Table->ViewCustomAttributes = "";

        // Field
        $this->Field->ViewValue = $this->Field->CurrentValue;
        $this->Field->ViewCustomAttributes = "";

        // KeyValue
        $this->KeyValue->ViewValue = $this->KeyValue->CurrentValue;
        $this->KeyValue->ViewCustomAttributes = "";

        // OldValue
        $this->OldValue->ViewValue = $this->OldValue->CurrentValue;
        $this->OldValue->ViewCustomAttributes = "";

        // NewValue
        $this->NewValue->ViewValue = $this->NewValue->CurrentValue;
        $this->NewValue->ViewCustomAttributes = "";

        // Id
        $this->Id->LinkCustomAttributes = "";
        $this->Id->HrefValue = "";
        $this->Id->TooltipValue = "";

        // DateTime
        $this->DateTime->LinkCustomAttributes = "";
        $this->DateTime->HrefValue = "";
        $this->DateTime->TooltipValue = "";

        // Script
        $this->Script->LinkCustomAttributes = "";
        $this->Script->HrefValue = "";
        $this->Script->TooltipValue = "";

        // User
        $this->User->LinkCustomAttributes = "";
        $this->User->HrefValue = "";
        $this->User->TooltipValue = "";

        // Action
        $this->_Action->LinkCustomAttributes = "";
        $this->_Action->HrefValue = "";
        $this->_Action->TooltipValue = "";

        // Table
        $this->_Table->LinkCustomAttributes = "";
        $this->_Table->HrefValue = "";
        $this->_Table->TooltipValue = "";

        // Field
        $this->Field->LinkCustomAttributes = "";
        $this->Field->HrefValue = "";
        $this->Field->TooltipValue = "";

        // KeyValue
        $this->KeyValue->LinkCustomAttributes = "";
        $this->KeyValue->HrefValue = "";
        $this->KeyValue->TooltipValue = "";

        // OldValue
        $this->OldValue->LinkCustomAttributes = "";
        $this->OldValue->HrefValue = "";
        $this->OldValue->TooltipValue = "";

        // NewValue
        $this->NewValue->LinkCustomAttributes = "";
        $this->NewValue->HrefValue = "";
        $this->NewValue->TooltipValue = "";

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

        // Id
        $this->Id->EditAttrs["class"] = "form-control";
        $this->Id->EditCustomAttributes = "";
        $this->Id->EditValue = $this->Id->CurrentValue;
        $this->Id->ViewCustomAttributes = "";

        // DateTime
        $this->DateTime->EditAttrs["class"] = "form-control";
        $this->DateTime->EditCustomAttributes = "";
        $this->DateTime->EditValue = FormatDateTime($this->DateTime->CurrentValue, 8);
        $this->DateTime->PlaceHolder = RemoveHtml($this->DateTime->caption());

        // Script
        $this->Script->EditAttrs["class"] = "form-control";
        $this->Script->EditCustomAttributes = "";
        if (!$this->Script->Raw) {
            $this->Script->CurrentValue = HtmlDecode($this->Script->CurrentValue);
        }
        $this->Script->EditValue = $this->Script->CurrentValue;
        $this->Script->PlaceHolder = RemoveHtml($this->Script->caption());

        // User
        $this->User->EditAttrs["class"] = "form-control";
        $this->User->EditCustomAttributes = "";
        if (!$this->User->Raw) {
            $this->User->CurrentValue = HtmlDecode($this->User->CurrentValue);
        }
        $this->User->EditValue = $this->User->CurrentValue;
        $this->User->PlaceHolder = RemoveHtml($this->User->caption());

        // Action
        $this->_Action->EditAttrs["class"] = "form-control";
        $this->_Action->EditCustomAttributes = "";
        if (!$this->_Action->Raw) {
            $this->_Action->CurrentValue = HtmlDecode($this->_Action->CurrentValue);
        }
        $this->_Action->EditValue = $this->_Action->CurrentValue;
        $this->_Action->PlaceHolder = RemoveHtml($this->_Action->caption());

        // Table
        $this->_Table->EditAttrs["class"] = "form-control";
        $this->_Table->EditCustomAttributes = "";
        if (!$this->_Table->Raw) {
            $this->_Table->CurrentValue = HtmlDecode($this->_Table->CurrentValue);
        }
        $this->_Table->EditValue = $this->_Table->CurrentValue;
        $this->_Table->PlaceHolder = RemoveHtml($this->_Table->caption());

        // Field
        $this->Field->EditAttrs["class"] = "form-control";
        $this->Field->EditCustomAttributes = "";
        if (!$this->Field->Raw) {
            $this->Field->CurrentValue = HtmlDecode($this->Field->CurrentValue);
        }
        $this->Field->EditValue = $this->Field->CurrentValue;
        $this->Field->PlaceHolder = RemoveHtml($this->Field->caption());

        // KeyValue
        $this->KeyValue->EditAttrs["class"] = "form-control";
        $this->KeyValue->EditCustomAttributes = "";
        $this->KeyValue->EditValue = $this->KeyValue->CurrentValue;
        $this->KeyValue->PlaceHolder = RemoveHtml($this->KeyValue->caption());

        // OldValue
        $this->OldValue->EditAttrs["class"] = "form-control";
        $this->OldValue->EditCustomAttributes = "";
        $this->OldValue->EditValue = $this->OldValue->CurrentValue;
        $this->OldValue->PlaceHolder = RemoveHtml($this->OldValue->caption());

        // NewValue
        $this->NewValue->EditAttrs["class"] = "form-control";
        $this->NewValue->EditCustomAttributes = "";
        $this->NewValue->EditValue = $this->NewValue->CurrentValue;
        $this->NewValue->PlaceHolder = RemoveHtml($this->NewValue->caption());

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
                    $doc->exportCaption($this->Id);
                    $doc->exportCaption($this->DateTime);
                    $doc->exportCaption($this->Script);
                    $doc->exportCaption($this->User);
                    $doc->exportCaption($this->_Action);
                    $doc->exportCaption($this->_Table);
                    $doc->exportCaption($this->Field);
                    $doc->exportCaption($this->KeyValue);
                    $doc->exportCaption($this->OldValue);
                    $doc->exportCaption($this->NewValue);
                } else {
                    $doc->exportCaption($this->Id);
                    $doc->exportCaption($this->DateTime);
                    $doc->exportCaption($this->Script);
                    $doc->exportCaption($this->User);
                    $doc->exportCaption($this->_Action);
                    $doc->exportCaption($this->_Table);
                    $doc->exportCaption($this->Field);
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
                        $doc->exportField($this->Id);
                        $doc->exportField($this->DateTime);
                        $doc->exportField($this->Script);
                        $doc->exportField($this->User);
                        $doc->exportField($this->_Action);
                        $doc->exportField($this->_Table);
                        $doc->exportField($this->Field);
                        $doc->exportField($this->KeyValue);
                        $doc->exportField($this->OldValue);
                        $doc->exportField($this->NewValue);
                    } else {
                        $doc->exportField($this->Id);
                        $doc->exportField($this->DateTime);
                        $doc->exportField($this->Script);
                        $doc->exportField($this->User);
                        $doc->exportField($this->_Action);
                        $doc->exportField($this->_Table);
                        $doc->exportField($this->Field);
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
