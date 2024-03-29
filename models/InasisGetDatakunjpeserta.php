<?php

namespace PHPMaker2021\simrs;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for INASIS_GET_DATAKUNJPESERTA
 */
class InasisGetDatakunjpeserta extends DbTable
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
    public $NOKARTU;
    public $NOSEP;
    public $KDINACBG;
    public $KDSEVERITY;
    public $NMINACBG;
    public $BYTAGIHAN;
    public $BYTARIFGRUPER;
    public $BYTARIFRS;
    public $BYTOPUP;
    public $JNSPELAYANAN;
    public $NOMR_SEP;
    public $NOMR;
    public $NAMA;
    public $KDSTATSEP;
    public $NMSTATSEP;
    public $TGLPULANG;
    public $TGLSEP;
    public $REST_CODE;
    public $REST_MESSAGE;
    public $REST_DATE;
    public $REST_METHOD;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'INASIS_GET_DATAKUNJPESERTA';
        $this->TableName = 'INASIS_GET_DATAKUNJPESERTA';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "[dbo].[INASIS_GET_DATAKUNJPESERTA]";
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

        // NOKARTU
        $this->NOKARTU = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NOKARTU', 'NOKARTU', '[NOKARTU]', '[NOKARTU]', 200, 50, -1, false, '[NOKARTU]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOKARTU->IsPrimaryKey = true; // Primary key field
        $this->NOKARTU->Nullable = false; // NOT NULL field
        $this->NOKARTU->Required = true; // Required field
        $this->NOKARTU->Sortable = true; // Allow sort
        $this->NOKARTU->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOKARTU->Param, "CustomMsg");
        $this->Fields['NOKARTU'] = &$this->NOKARTU;

        // NOSEP
        $this->NOSEP = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NOSEP', 'NOSEP', '[NOSEP]', '[NOSEP]', 200, 50, -1, false, '[NOSEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOSEP->IsPrimaryKey = true; // Primary key field
        $this->NOSEP->Nullable = false; // NOT NULL field
        $this->NOSEP->Required = true; // Required field
        $this->NOSEP->Sortable = true; // Allow sort
        $this->NOSEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOSEP->Param, "CustomMsg");
        $this->Fields['NOSEP'] = &$this->NOSEP;

        // KDINACBG
        $this->KDINACBG = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_KDINACBG', 'KDINACBG', '[KDINACBG]', '[KDINACBG]', 200, 25, -1, false, '[KDINACBG]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDINACBG->Sortable = true; // Allow sort
        $this->KDINACBG->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDINACBG->Param, "CustomMsg");
        $this->Fields['KDINACBG'] = &$this->KDINACBG;

        // KDSEVERITY
        $this->KDSEVERITY = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_KDSEVERITY', 'KDSEVERITY', '[KDSEVERITY]', '[KDSEVERITY]', 200, 50, -1, false, '[KDSEVERITY]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDSEVERITY->Sortable = true; // Allow sort
        $this->KDSEVERITY->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDSEVERITY->Param, "CustomMsg");
        $this->Fields['KDSEVERITY'] = &$this->KDSEVERITY;

        // NMINACBG
        $this->NMINACBG = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NMINACBG', 'NMINACBG', '[NMINACBG]', '[NMINACBG]', 200, 250, -1, false, '[NMINACBG]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NMINACBG->Sortable = true; // Allow sort
        $this->NMINACBG->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NMINACBG->Param, "CustomMsg");
        $this->Fields['NMINACBG'] = &$this->NMINACBG;

        // BYTAGIHAN
        $this->BYTAGIHAN = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_BYTAGIHAN', 'BYTAGIHAN', '[BYTAGIHAN]', '[BYTAGIHAN]', 200, 50, -1, false, '[BYTAGIHAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BYTAGIHAN->Sortable = true; // Allow sort
        $this->BYTAGIHAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BYTAGIHAN->Param, "CustomMsg");
        $this->Fields['BYTAGIHAN'] = &$this->BYTAGIHAN;

        // BYTARIFGRUPER
        $this->BYTARIFGRUPER = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_BYTARIFGRUPER', 'BYTARIFGRUPER', '[BYTARIFGRUPER]', '[BYTARIFGRUPER]', 200, 50, -1, false, '[BYTARIFGRUPER]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BYTARIFGRUPER->Sortable = true; // Allow sort
        $this->BYTARIFGRUPER->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BYTARIFGRUPER->Param, "CustomMsg");
        $this->Fields['BYTARIFGRUPER'] = &$this->BYTARIFGRUPER;

        // BYTARIFRS
        $this->BYTARIFRS = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_BYTARIFRS', 'BYTARIFRS', '[BYTARIFRS]', '[BYTARIFRS]', 200, 50, -1, false, '[BYTARIFRS]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BYTARIFRS->Sortable = true; // Allow sort
        $this->BYTARIFRS->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BYTARIFRS->Param, "CustomMsg");
        $this->Fields['BYTARIFRS'] = &$this->BYTARIFRS;

        // BYTOPUP
        $this->BYTOPUP = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_BYTOPUP', 'BYTOPUP', '[BYTOPUP]', '[BYTOPUP]', 200, 50, -1, false, '[BYTOPUP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->BYTOPUP->Sortable = true; // Allow sort
        $this->BYTOPUP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->BYTOPUP->Param, "CustomMsg");
        $this->Fields['BYTOPUP'] = &$this->BYTOPUP;

        // JNSPELAYANAN
        $this->JNSPELAYANAN = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_JNSPELAYANAN', 'JNSPELAYANAN', '[JNSPELAYANAN]', '[JNSPELAYANAN]', 200, 10, -1, false, '[JNSPELAYANAN]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->JNSPELAYANAN->Sortable = true; // Allow sort
        $this->JNSPELAYANAN->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->JNSPELAYANAN->Param, "CustomMsg");
        $this->Fields['JNSPELAYANAN'] = &$this->JNSPELAYANAN;

        // NOMR_SEP
        $this->NOMR_SEP = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NOMR_SEP', 'NOMR_SEP', '[NOMR_SEP]', '[NOMR_SEP]', 200, 50, -1, false, '[NOMR_SEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOMR_SEP->Sortable = true; // Allow sort
        $this->NOMR_SEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOMR_SEP->Param, "CustomMsg");
        $this->Fields['NOMR_SEP'] = &$this->NOMR_SEP;

        // NOMR
        $this->NOMR = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NOMR', 'NOMR', '[NOMR]', '[NOMR]', 200, 50, -1, false, '[NOMR]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NOMR->Sortable = true; // Allow sort
        $this->NOMR->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NOMR->Param, "CustomMsg");
        $this->Fields['NOMR'] = &$this->NOMR;

        // NAMA
        $this->NAMA = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NAMA', 'NAMA', '[NAMA]', '[NAMA]', 200, 250, -1, false, '[NAMA]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NAMA->Sortable = true; // Allow sort
        $this->NAMA->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NAMA->Param, "CustomMsg");
        $this->Fields['NAMA'] = &$this->NAMA;

        // KDSTATSEP
        $this->KDSTATSEP = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_KDSTATSEP', 'KDSTATSEP', '[KDSTATSEP]', '[KDSTATSEP]', 200, 10, -1, false, '[KDSTATSEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->KDSTATSEP->Sortable = true; // Allow sort
        $this->KDSTATSEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->KDSTATSEP->Param, "CustomMsg");
        $this->Fields['KDSTATSEP'] = &$this->KDSTATSEP;

        // NMSTATSEP
        $this->NMSTATSEP = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_NMSTATSEP', 'NMSTATSEP', '[NMSTATSEP]', '[NMSTATSEP]', 200, 250, -1, false, '[NMSTATSEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->NMSTATSEP->Sortable = true; // Allow sort
        $this->NMSTATSEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->NMSTATSEP->Param, "CustomMsg");
        $this->Fields['NMSTATSEP'] = &$this->NMSTATSEP;

        // TGLPULANG
        $this->TGLPULANG = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_TGLPULANG', 'TGLPULANG', '[TGLPULANG]', CastDateFieldForLike("[TGLPULANG]", 0, "DB"), 135, 8, 0, false, '[TGLPULANG]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TGLPULANG->Sortable = true; // Allow sort
        $this->TGLPULANG->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->TGLPULANG->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TGLPULANG->Param, "CustomMsg");
        $this->Fields['TGLPULANG'] = &$this->TGLPULANG;

        // TGLSEP
        $this->TGLSEP = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_TGLSEP', 'TGLSEP', '[TGLSEP]', CastDateFieldForLike("[TGLSEP]", 0, "DB"), 135, 8, 0, false, '[TGLSEP]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->TGLSEP->Sortable = true; // Allow sort
        $this->TGLSEP->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->TGLSEP->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->TGLSEP->Param, "CustomMsg");
        $this->Fields['TGLSEP'] = &$this->TGLSEP;

        // REST_CODE
        $this->REST_CODE = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_REST_CODE', 'REST_CODE', '[REST_CODE]', '[REST_CODE]', 129, 3, -1, false, '[REST_CODE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->REST_CODE->Sortable = true; // Allow sort
        $this->REST_CODE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->REST_CODE->Param, "CustomMsg");
        $this->Fields['REST_CODE'] = &$this->REST_CODE;

        // REST_MESSAGE
        $this->REST_MESSAGE = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_REST_MESSAGE', 'REST_MESSAGE', '[REST_MESSAGE]', '[REST_MESSAGE]', 200, 150, -1, false, '[REST_MESSAGE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->REST_MESSAGE->Sortable = true; // Allow sort
        $this->REST_MESSAGE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->REST_MESSAGE->Param, "CustomMsg");
        $this->Fields['REST_MESSAGE'] = &$this->REST_MESSAGE;

        // REST_DATE
        $this->REST_DATE = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_REST_DATE', 'REST_DATE', '[REST_DATE]', CastDateFieldForLike("[REST_DATE]", 0, "DB"), 135, 8, 0, false, '[REST_DATE]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->REST_DATE->Sortable = true; // Allow sort
        $this->REST_DATE->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->REST_DATE->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->REST_DATE->Param, "CustomMsg");
        $this->Fields['REST_DATE'] = &$this->REST_DATE;

        // REST_METHOD
        $this->REST_METHOD = new DbField('INASIS_GET_DATAKUNJPESERTA', 'INASIS_GET_DATAKUNJPESERTA', 'x_REST_METHOD', 'REST_METHOD', '[REST_METHOD]', '[REST_METHOD]', 200, 10, -1, false, '[REST_METHOD]', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->REST_METHOD->Sortable = true; // Allow sort
        $this->REST_METHOD->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->REST_METHOD->Param, "CustomMsg");
        $this->Fields['REST_METHOD'] = &$this->REST_METHOD;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "[dbo].[INASIS_GET_DATAKUNJPESERTA]";
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
            if (array_key_exists('NOKARTU', $rs)) {
                AddFilter($where, QuotedName('NOKARTU', $this->Dbid) . '=' . QuotedValue($rs['NOKARTU'], $this->NOKARTU->DataType, $this->Dbid));
            }
            if (array_key_exists('NOSEP', $rs)) {
                AddFilter($where, QuotedName('NOSEP', $this->Dbid) . '=' . QuotedValue($rs['NOSEP'], $this->NOSEP->DataType, $this->Dbid));
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
        $this->NOKARTU->DbValue = $row['NOKARTU'];
        $this->NOSEP->DbValue = $row['NOSEP'];
        $this->KDINACBG->DbValue = $row['KDINACBG'];
        $this->KDSEVERITY->DbValue = $row['KDSEVERITY'];
        $this->NMINACBG->DbValue = $row['NMINACBG'];
        $this->BYTAGIHAN->DbValue = $row['BYTAGIHAN'];
        $this->BYTARIFGRUPER->DbValue = $row['BYTARIFGRUPER'];
        $this->BYTARIFRS->DbValue = $row['BYTARIFRS'];
        $this->BYTOPUP->DbValue = $row['BYTOPUP'];
        $this->JNSPELAYANAN->DbValue = $row['JNSPELAYANAN'];
        $this->NOMR_SEP->DbValue = $row['NOMR_SEP'];
        $this->NOMR->DbValue = $row['NOMR'];
        $this->NAMA->DbValue = $row['NAMA'];
        $this->KDSTATSEP->DbValue = $row['KDSTATSEP'];
        $this->NMSTATSEP->DbValue = $row['NMSTATSEP'];
        $this->TGLPULANG->DbValue = $row['TGLPULANG'];
        $this->TGLSEP->DbValue = $row['TGLSEP'];
        $this->REST_CODE->DbValue = $row['REST_CODE'];
        $this->REST_MESSAGE->DbValue = $row['REST_MESSAGE'];
        $this->REST_DATE->DbValue = $row['REST_DATE'];
        $this->REST_METHOD->DbValue = $row['REST_METHOD'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "[NOKARTU] = '@NOKARTU@' AND [NOSEP] = '@NOSEP@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->NOKARTU->CurrentValue : $this->NOKARTU->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->NOSEP->CurrentValue : $this->NOSEP->OldValue;
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
                $this->NOKARTU->CurrentValue = $keys[0];
            } else {
                $this->NOKARTU->OldValue = $keys[0];
            }
            if ($current) {
                $this->NOSEP->CurrentValue = $keys[1];
            } else {
                $this->NOSEP->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('NOKARTU', $row) ? $row['NOKARTU'] : null;
        } else {
            $val = $this->NOKARTU->OldValue !== null ? $this->NOKARTU->OldValue : $this->NOKARTU->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@NOKARTU@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('NOSEP', $row) ? $row['NOSEP'] : null;
        } else {
            $val = $this->NOSEP->OldValue !== null ? $this->NOSEP->OldValue : $this->NOSEP->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@NOSEP@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("InasisGetDatakunjpesertaList");
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
        if ($pageName == "InasisGetDatakunjpesertaView") {
            return $Language->phrase("View");
        } elseif ($pageName == "InasisGetDatakunjpesertaEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "InasisGetDatakunjpesertaAdd") {
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
                return "InasisGetDatakunjpesertaView";
            case Config("API_ADD_ACTION"):
                return "InasisGetDatakunjpesertaAdd";
            case Config("API_EDIT_ACTION"):
                return "InasisGetDatakunjpesertaEdit";
            case Config("API_DELETE_ACTION"):
                return "InasisGetDatakunjpesertaDelete";
            case Config("API_LIST_ACTION"):
                return "InasisGetDatakunjpesertaList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "InasisGetDatakunjpesertaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("InasisGetDatakunjpesertaView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("InasisGetDatakunjpesertaView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "InasisGetDatakunjpesertaAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "InasisGetDatakunjpesertaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("InasisGetDatakunjpesertaEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("InasisGetDatakunjpesertaAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("InasisGetDatakunjpesertaDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "NOKARTU:" . JsonEncode($this->NOKARTU->CurrentValue, "string");
        $json .= ",NOSEP:" . JsonEncode($this->NOSEP->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->NOKARTU->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->NOKARTU->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->NOSEP->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->NOSEP->CurrentValue);
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
            if (($keyValue = Param("NOKARTU") ?? Route("NOKARTU")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("NOSEP") ?? Route("NOSEP")) !== null) {
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
                $this->NOKARTU->CurrentValue = $key[0];
            } else {
                $this->NOKARTU->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->NOSEP->CurrentValue = $key[1];
            } else {
                $this->NOSEP->OldValue = $key[1];
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
        $this->NOKARTU->setDbValue($row['NOKARTU']);
        $this->NOSEP->setDbValue($row['NOSEP']);
        $this->KDINACBG->setDbValue($row['KDINACBG']);
        $this->KDSEVERITY->setDbValue($row['KDSEVERITY']);
        $this->NMINACBG->setDbValue($row['NMINACBG']);
        $this->BYTAGIHAN->setDbValue($row['BYTAGIHAN']);
        $this->BYTARIFGRUPER->setDbValue($row['BYTARIFGRUPER']);
        $this->BYTARIFRS->setDbValue($row['BYTARIFRS']);
        $this->BYTOPUP->setDbValue($row['BYTOPUP']);
        $this->JNSPELAYANAN->setDbValue($row['JNSPELAYANAN']);
        $this->NOMR_SEP->setDbValue($row['NOMR_SEP']);
        $this->NOMR->setDbValue($row['NOMR']);
        $this->NAMA->setDbValue($row['NAMA']);
        $this->KDSTATSEP->setDbValue($row['KDSTATSEP']);
        $this->NMSTATSEP->setDbValue($row['NMSTATSEP']);
        $this->TGLPULANG->setDbValue($row['TGLPULANG']);
        $this->TGLSEP->setDbValue($row['TGLSEP']);
        $this->REST_CODE->setDbValue($row['REST_CODE']);
        $this->REST_MESSAGE->setDbValue($row['REST_MESSAGE']);
        $this->REST_DATE->setDbValue($row['REST_DATE']);
        $this->REST_METHOD->setDbValue($row['REST_METHOD']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // NOKARTU

        // NOSEP

        // KDINACBG

        // KDSEVERITY

        // NMINACBG

        // BYTAGIHAN

        // BYTARIFGRUPER

        // BYTARIFRS

        // BYTOPUP

        // JNSPELAYANAN

        // NOMR_SEP

        // NOMR

        // NAMA

        // KDSTATSEP

        // NMSTATSEP

        // TGLPULANG

        // TGLSEP

        // REST_CODE

        // REST_MESSAGE

        // REST_DATE

        // REST_METHOD

        // NOKARTU
        $this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
        $this->NOKARTU->ViewCustomAttributes = "";

        // NOSEP
        $this->NOSEP->ViewValue = $this->NOSEP->CurrentValue;
        $this->NOSEP->ViewCustomAttributes = "";

        // KDINACBG
        $this->KDINACBG->ViewValue = $this->KDINACBG->CurrentValue;
        $this->KDINACBG->ViewCustomAttributes = "";

        // KDSEVERITY
        $this->KDSEVERITY->ViewValue = $this->KDSEVERITY->CurrentValue;
        $this->KDSEVERITY->ViewCustomAttributes = "";

        // NMINACBG
        $this->NMINACBG->ViewValue = $this->NMINACBG->CurrentValue;
        $this->NMINACBG->ViewCustomAttributes = "";

        // BYTAGIHAN
        $this->BYTAGIHAN->ViewValue = $this->BYTAGIHAN->CurrentValue;
        $this->BYTAGIHAN->ViewCustomAttributes = "";

        // BYTARIFGRUPER
        $this->BYTARIFGRUPER->ViewValue = $this->BYTARIFGRUPER->CurrentValue;
        $this->BYTARIFGRUPER->ViewCustomAttributes = "";

        // BYTARIFRS
        $this->BYTARIFRS->ViewValue = $this->BYTARIFRS->CurrentValue;
        $this->BYTARIFRS->ViewCustomAttributes = "";

        // BYTOPUP
        $this->BYTOPUP->ViewValue = $this->BYTOPUP->CurrentValue;
        $this->BYTOPUP->ViewCustomAttributes = "";

        // JNSPELAYANAN
        $this->JNSPELAYANAN->ViewValue = $this->JNSPELAYANAN->CurrentValue;
        $this->JNSPELAYANAN->ViewCustomAttributes = "";

        // NOMR_SEP
        $this->NOMR_SEP->ViewValue = $this->NOMR_SEP->CurrentValue;
        $this->NOMR_SEP->ViewCustomAttributes = "";

        // NOMR
        $this->NOMR->ViewValue = $this->NOMR->CurrentValue;
        $this->NOMR->ViewCustomAttributes = "";

        // NAMA
        $this->NAMA->ViewValue = $this->NAMA->CurrentValue;
        $this->NAMA->ViewCustomAttributes = "";

        // KDSTATSEP
        $this->KDSTATSEP->ViewValue = $this->KDSTATSEP->CurrentValue;
        $this->KDSTATSEP->ViewCustomAttributes = "";

        // NMSTATSEP
        $this->NMSTATSEP->ViewValue = $this->NMSTATSEP->CurrentValue;
        $this->NMSTATSEP->ViewCustomAttributes = "";

        // TGLPULANG
        $this->TGLPULANG->ViewValue = $this->TGLPULANG->CurrentValue;
        $this->TGLPULANG->ViewValue = FormatDateTime($this->TGLPULANG->ViewValue, 0);
        $this->TGLPULANG->ViewCustomAttributes = "";

        // TGLSEP
        $this->TGLSEP->ViewValue = $this->TGLSEP->CurrentValue;
        $this->TGLSEP->ViewValue = FormatDateTime($this->TGLSEP->ViewValue, 0);
        $this->TGLSEP->ViewCustomAttributes = "";

        // REST_CODE
        $this->REST_CODE->ViewValue = $this->REST_CODE->CurrentValue;
        $this->REST_CODE->ViewCustomAttributes = "";

        // REST_MESSAGE
        $this->REST_MESSAGE->ViewValue = $this->REST_MESSAGE->CurrentValue;
        $this->REST_MESSAGE->ViewCustomAttributes = "";

        // REST_DATE
        $this->REST_DATE->ViewValue = $this->REST_DATE->CurrentValue;
        $this->REST_DATE->ViewValue = FormatDateTime($this->REST_DATE->ViewValue, 0);
        $this->REST_DATE->ViewCustomAttributes = "";

        // REST_METHOD
        $this->REST_METHOD->ViewValue = $this->REST_METHOD->CurrentValue;
        $this->REST_METHOD->ViewCustomAttributes = "";

        // NOKARTU
        $this->NOKARTU->LinkCustomAttributes = "";
        $this->NOKARTU->HrefValue = "";
        $this->NOKARTU->TooltipValue = "";

        // NOSEP
        $this->NOSEP->LinkCustomAttributes = "";
        $this->NOSEP->HrefValue = "";
        $this->NOSEP->TooltipValue = "";

        // KDINACBG
        $this->KDINACBG->LinkCustomAttributes = "";
        $this->KDINACBG->HrefValue = "";
        $this->KDINACBG->TooltipValue = "";

        // KDSEVERITY
        $this->KDSEVERITY->LinkCustomAttributes = "";
        $this->KDSEVERITY->HrefValue = "";
        $this->KDSEVERITY->TooltipValue = "";

        // NMINACBG
        $this->NMINACBG->LinkCustomAttributes = "";
        $this->NMINACBG->HrefValue = "";
        $this->NMINACBG->TooltipValue = "";

        // BYTAGIHAN
        $this->BYTAGIHAN->LinkCustomAttributes = "";
        $this->BYTAGIHAN->HrefValue = "";
        $this->BYTAGIHAN->TooltipValue = "";

        // BYTARIFGRUPER
        $this->BYTARIFGRUPER->LinkCustomAttributes = "";
        $this->BYTARIFGRUPER->HrefValue = "";
        $this->BYTARIFGRUPER->TooltipValue = "";

        // BYTARIFRS
        $this->BYTARIFRS->LinkCustomAttributes = "";
        $this->BYTARIFRS->HrefValue = "";
        $this->BYTARIFRS->TooltipValue = "";

        // BYTOPUP
        $this->BYTOPUP->LinkCustomAttributes = "";
        $this->BYTOPUP->HrefValue = "";
        $this->BYTOPUP->TooltipValue = "";

        // JNSPELAYANAN
        $this->JNSPELAYANAN->LinkCustomAttributes = "";
        $this->JNSPELAYANAN->HrefValue = "";
        $this->JNSPELAYANAN->TooltipValue = "";

        // NOMR_SEP
        $this->NOMR_SEP->LinkCustomAttributes = "";
        $this->NOMR_SEP->HrefValue = "";
        $this->NOMR_SEP->TooltipValue = "";

        // NOMR
        $this->NOMR->LinkCustomAttributes = "";
        $this->NOMR->HrefValue = "";
        $this->NOMR->TooltipValue = "";

        // NAMA
        $this->NAMA->LinkCustomAttributes = "";
        $this->NAMA->HrefValue = "";
        $this->NAMA->TooltipValue = "";

        // KDSTATSEP
        $this->KDSTATSEP->LinkCustomAttributes = "";
        $this->KDSTATSEP->HrefValue = "";
        $this->KDSTATSEP->TooltipValue = "";

        // NMSTATSEP
        $this->NMSTATSEP->LinkCustomAttributes = "";
        $this->NMSTATSEP->HrefValue = "";
        $this->NMSTATSEP->TooltipValue = "";

        // TGLPULANG
        $this->TGLPULANG->LinkCustomAttributes = "";
        $this->TGLPULANG->HrefValue = "";
        $this->TGLPULANG->TooltipValue = "";

        // TGLSEP
        $this->TGLSEP->LinkCustomAttributes = "";
        $this->TGLSEP->HrefValue = "";
        $this->TGLSEP->TooltipValue = "";

        // REST_CODE
        $this->REST_CODE->LinkCustomAttributes = "";
        $this->REST_CODE->HrefValue = "";
        $this->REST_CODE->TooltipValue = "";

        // REST_MESSAGE
        $this->REST_MESSAGE->LinkCustomAttributes = "";
        $this->REST_MESSAGE->HrefValue = "";
        $this->REST_MESSAGE->TooltipValue = "";

        // REST_DATE
        $this->REST_DATE->LinkCustomAttributes = "";
        $this->REST_DATE->HrefValue = "";
        $this->REST_DATE->TooltipValue = "";

        // REST_METHOD
        $this->REST_METHOD->LinkCustomAttributes = "";
        $this->REST_METHOD->HrefValue = "";
        $this->REST_METHOD->TooltipValue = "";

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

        // NOKARTU
        $this->NOKARTU->EditAttrs["class"] = "form-control";
        $this->NOKARTU->EditCustomAttributes = "";
        if (!$this->NOKARTU->Raw) {
            $this->NOKARTU->CurrentValue = HtmlDecode($this->NOKARTU->CurrentValue);
        }
        $this->NOKARTU->EditValue = $this->NOKARTU->CurrentValue;
        $this->NOKARTU->PlaceHolder = RemoveHtml($this->NOKARTU->caption());

        // NOSEP
        $this->NOSEP->EditAttrs["class"] = "form-control";
        $this->NOSEP->EditCustomAttributes = "";
        if (!$this->NOSEP->Raw) {
            $this->NOSEP->CurrentValue = HtmlDecode($this->NOSEP->CurrentValue);
        }
        $this->NOSEP->EditValue = $this->NOSEP->CurrentValue;
        $this->NOSEP->PlaceHolder = RemoveHtml($this->NOSEP->caption());

        // KDINACBG
        $this->KDINACBG->EditAttrs["class"] = "form-control";
        $this->KDINACBG->EditCustomAttributes = "";
        if (!$this->KDINACBG->Raw) {
            $this->KDINACBG->CurrentValue = HtmlDecode($this->KDINACBG->CurrentValue);
        }
        $this->KDINACBG->EditValue = $this->KDINACBG->CurrentValue;
        $this->KDINACBG->PlaceHolder = RemoveHtml($this->KDINACBG->caption());

        // KDSEVERITY
        $this->KDSEVERITY->EditAttrs["class"] = "form-control";
        $this->KDSEVERITY->EditCustomAttributes = "";
        if (!$this->KDSEVERITY->Raw) {
            $this->KDSEVERITY->CurrentValue = HtmlDecode($this->KDSEVERITY->CurrentValue);
        }
        $this->KDSEVERITY->EditValue = $this->KDSEVERITY->CurrentValue;
        $this->KDSEVERITY->PlaceHolder = RemoveHtml($this->KDSEVERITY->caption());

        // NMINACBG
        $this->NMINACBG->EditAttrs["class"] = "form-control";
        $this->NMINACBG->EditCustomAttributes = "";
        if (!$this->NMINACBG->Raw) {
            $this->NMINACBG->CurrentValue = HtmlDecode($this->NMINACBG->CurrentValue);
        }
        $this->NMINACBG->EditValue = $this->NMINACBG->CurrentValue;
        $this->NMINACBG->PlaceHolder = RemoveHtml($this->NMINACBG->caption());

        // BYTAGIHAN
        $this->BYTAGIHAN->EditAttrs["class"] = "form-control";
        $this->BYTAGIHAN->EditCustomAttributes = "";
        if (!$this->BYTAGIHAN->Raw) {
            $this->BYTAGIHAN->CurrentValue = HtmlDecode($this->BYTAGIHAN->CurrentValue);
        }
        $this->BYTAGIHAN->EditValue = $this->BYTAGIHAN->CurrentValue;
        $this->BYTAGIHAN->PlaceHolder = RemoveHtml($this->BYTAGIHAN->caption());

        // BYTARIFGRUPER
        $this->BYTARIFGRUPER->EditAttrs["class"] = "form-control";
        $this->BYTARIFGRUPER->EditCustomAttributes = "";
        if (!$this->BYTARIFGRUPER->Raw) {
            $this->BYTARIFGRUPER->CurrentValue = HtmlDecode($this->BYTARIFGRUPER->CurrentValue);
        }
        $this->BYTARIFGRUPER->EditValue = $this->BYTARIFGRUPER->CurrentValue;
        $this->BYTARIFGRUPER->PlaceHolder = RemoveHtml($this->BYTARIFGRUPER->caption());

        // BYTARIFRS
        $this->BYTARIFRS->EditAttrs["class"] = "form-control";
        $this->BYTARIFRS->EditCustomAttributes = "";
        if (!$this->BYTARIFRS->Raw) {
            $this->BYTARIFRS->CurrentValue = HtmlDecode($this->BYTARIFRS->CurrentValue);
        }
        $this->BYTARIFRS->EditValue = $this->BYTARIFRS->CurrentValue;
        $this->BYTARIFRS->PlaceHolder = RemoveHtml($this->BYTARIFRS->caption());

        // BYTOPUP
        $this->BYTOPUP->EditAttrs["class"] = "form-control";
        $this->BYTOPUP->EditCustomAttributes = "";
        if (!$this->BYTOPUP->Raw) {
            $this->BYTOPUP->CurrentValue = HtmlDecode($this->BYTOPUP->CurrentValue);
        }
        $this->BYTOPUP->EditValue = $this->BYTOPUP->CurrentValue;
        $this->BYTOPUP->PlaceHolder = RemoveHtml($this->BYTOPUP->caption());

        // JNSPELAYANAN
        $this->JNSPELAYANAN->EditAttrs["class"] = "form-control";
        $this->JNSPELAYANAN->EditCustomAttributes = "";
        if (!$this->JNSPELAYANAN->Raw) {
            $this->JNSPELAYANAN->CurrentValue = HtmlDecode($this->JNSPELAYANAN->CurrentValue);
        }
        $this->JNSPELAYANAN->EditValue = $this->JNSPELAYANAN->CurrentValue;
        $this->JNSPELAYANAN->PlaceHolder = RemoveHtml($this->JNSPELAYANAN->caption());

        // NOMR_SEP
        $this->NOMR_SEP->EditAttrs["class"] = "form-control";
        $this->NOMR_SEP->EditCustomAttributes = "";
        if (!$this->NOMR_SEP->Raw) {
            $this->NOMR_SEP->CurrentValue = HtmlDecode($this->NOMR_SEP->CurrentValue);
        }
        $this->NOMR_SEP->EditValue = $this->NOMR_SEP->CurrentValue;
        $this->NOMR_SEP->PlaceHolder = RemoveHtml($this->NOMR_SEP->caption());

        // NOMR
        $this->NOMR->EditAttrs["class"] = "form-control";
        $this->NOMR->EditCustomAttributes = "";
        if (!$this->NOMR->Raw) {
            $this->NOMR->CurrentValue = HtmlDecode($this->NOMR->CurrentValue);
        }
        $this->NOMR->EditValue = $this->NOMR->CurrentValue;
        $this->NOMR->PlaceHolder = RemoveHtml($this->NOMR->caption());

        // NAMA
        $this->NAMA->EditAttrs["class"] = "form-control";
        $this->NAMA->EditCustomAttributes = "";
        if (!$this->NAMA->Raw) {
            $this->NAMA->CurrentValue = HtmlDecode($this->NAMA->CurrentValue);
        }
        $this->NAMA->EditValue = $this->NAMA->CurrentValue;
        $this->NAMA->PlaceHolder = RemoveHtml($this->NAMA->caption());

        // KDSTATSEP
        $this->KDSTATSEP->EditAttrs["class"] = "form-control";
        $this->KDSTATSEP->EditCustomAttributes = "";
        if (!$this->KDSTATSEP->Raw) {
            $this->KDSTATSEP->CurrentValue = HtmlDecode($this->KDSTATSEP->CurrentValue);
        }
        $this->KDSTATSEP->EditValue = $this->KDSTATSEP->CurrentValue;
        $this->KDSTATSEP->PlaceHolder = RemoveHtml($this->KDSTATSEP->caption());

        // NMSTATSEP
        $this->NMSTATSEP->EditAttrs["class"] = "form-control";
        $this->NMSTATSEP->EditCustomAttributes = "";
        if (!$this->NMSTATSEP->Raw) {
            $this->NMSTATSEP->CurrentValue = HtmlDecode($this->NMSTATSEP->CurrentValue);
        }
        $this->NMSTATSEP->EditValue = $this->NMSTATSEP->CurrentValue;
        $this->NMSTATSEP->PlaceHolder = RemoveHtml($this->NMSTATSEP->caption());

        // TGLPULANG
        $this->TGLPULANG->EditAttrs["class"] = "form-control";
        $this->TGLPULANG->EditCustomAttributes = "";
        $this->TGLPULANG->EditValue = FormatDateTime($this->TGLPULANG->CurrentValue, 8);
        $this->TGLPULANG->PlaceHolder = RemoveHtml($this->TGLPULANG->caption());

        // TGLSEP
        $this->TGLSEP->EditAttrs["class"] = "form-control";
        $this->TGLSEP->EditCustomAttributes = "";
        $this->TGLSEP->EditValue = FormatDateTime($this->TGLSEP->CurrentValue, 8);
        $this->TGLSEP->PlaceHolder = RemoveHtml($this->TGLSEP->caption());

        // REST_CODE
        $this->REST_CODE->EditAttrs["class"] = "form-control";
        $this->REST_CODE->EditCustomAttributes = "";
        if (!$this->REST_CODE->Raw) {
            $this->REST_CODE->CurrentValue = HtmlDecode($this->REST_CODE->CurrentValue);
        }
        $this->REST_CODE->EditValue = $this->REST_CODE->CurrentValue;
        $this->REST_CODE->PlaceHolder = RemoveHtml($this->REST_CODE->caption());

        // REST_MESSAGE
        $this->REST_MESSAGE->EditAttrs["class"] = "form-control";
        $this->REST_MESSAGE->EditCustomAttributes = "";
        if (!$this->REST_MESSAGE->Raw) {
            $this->REST_MESSAGE->CurrentValue = HtmlDecode($this->REST_MESSAGE->CurrentValue);
        }
        $this->REST_MESSAGE->EditValue = $this->REST_MESSAGE->CurrentValue;
        $this->REST_MESSAGE->PlaceHolder = RemoveHtml($this->REST_MESSAGE->caption());

        // REST_DATE
        $this->REST_DATE->EditAttrs["class"] = "form-control";
        $this->REST_DATE->EditCustomAttributes = "";
        $this->REST_DATE->EditValue = FormatDateTime($this->REST_DATE->CurrentValue, 8);
        $this->REST_DATE->PlaceHolder = RemoveHtml($this->REST_DATE->caption());

        // REST_METHOD
        $this->REST_METHOD->EditAttrs["class"] = "form-control";
        $this->REST_METHOD->EditCustomAttributes = "";
        if (!$this->REST_METHOD->Raw) {
            $this->REST_METHOD->CurrentValue = HtmlDecode($this->REST_METHOD->CurrentValue);
        }
        $this->REST_METHOD->EditValue = $this->REST_METHOD->CurrentValue;
        $this->REST_METHOD->PlaceHolder = RemoveHtml($this->REST_METHOD->caption());

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
                    $doc->exportCaption($this->NOKARTU);
                    $doc->exportCaption($this->NOSEP);
                    $doc->exportCaption($this->KDINACBG);
                    $doc->exportCaption($this->KDSEVERITY);
                    $doc->exportCaption($this->NMINACBG);
                    $doc->exportCaption($this->BYTAGIHAN);
                    $doc->exportCaption($this->BYTARIFGRUPER);
                    $doc->exportCaption($this->BYTARIFRS);
                    $doc->exportCaption($this->BYTOPUP);
                    $doc->exportCaption($this->JNSPELAYANAN);
                    $doc->exportCaption($this->NOMR_SEP);
                    $doc->exportCaption($this->NOMR);
                    $doc->exportCaption($this->NAMA);
                    $doc->exportCaption($this->KDSTATSEP);
                    $doc->exportCaption($this->NMSTATSEP);
                    $doc->exportCaption($this->TGLPULANG);
                    $doc->exportCaption($this->TGLSEP);
                    $doc->exportCaption($this->REST_CODE);
                    $doc->exportCaption($this->REST_MESSAGE);
                    $doc->exportCaption($this->REST_DATE);
                    $doc->exportCaption($this->REST_METHOD);
                } else {
                    $doc->exportCaption($this->NOKARTU);
                    $doc->exportCaption($this->NOSEP);
                    $doc->exportCaption($this->KDINACBG);
                    $doc->exportCaption($this->KDSEVERITY);
                    $doc->exportCaption($this->NMINACBG);
                    $doc->exportCaption($this->BYTAGIHAN);
                    $doc->exportCaption($this->BYTARIFGRUPER);
                    $doc->exportCaption($this->BYTARIFRS);
                    $doc->exportCaption($this->BYTOPUP);
                    $doc->exportCaption($this->JNSPELAYANAN);
                    $doc->exportCaption($this->NOMR_SEP);
                    $doc->exportCaption($this->NOMR);
                    $doc->exportCaption($this->NAMA);
                    $doc->exportCaption($this->KDSTATSEP);
                    $doc->exportCaption($this->NMSTATSEP);
                    $doc->exportCaption($this->TGLPULANG);
                    $doc->exportCaption($this->TGLSEP);
                    $doc->exportCaption($this->REST_CODE);
                    $doc->exportCaption($this->REST_MESSAGE);
                    $doc->exportCaption($this->REST_DATE);
                    $doc->exportCaption($this->REST_METHOD);
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
                        $doc->exportField($this->NOKARTU);
                        $doc->exportField($this->NOSEP);
                        $doc->exportField($this->KDINACBG);
                        $doc->exportField($this->KDSEVERITY);
                        $doc->exportField($this->NMINACBG);
                        $doc->exportField($this->BYTAGIHAN);
                        $doc->exportField($this->BYTARIFGRUPER);
                        $doc->exportField($this->BYTARIFRS);
                        $doc->exportField($this->BYTOPUP);
                        $doc->exportField($this->JNSPELAYANAN);
                        $doc->exportField($this->NOMR_SEP);
                        $doc->exportField($this->NOMR);
                        $doc->exportField($this->NAMA);
                        $doc->exportField($this->KDSTATSEP);
                        $doc->exportField($this->NMSTATSEP);
                        $doc->exportField($this->TGLPULANG);
                        $doc->exportField($this->TGLSEP);
                        $doc->exportField($this->REST_CODE);
                        $doc->exportField($this->REST_MESSAGE);
                        $doc->exportField($this->REST_DATE);
                        $doc->exportField($this->REST_METHOD);
                    } else {
                        $doc->exportField($this->NOKARTU);
                        $doc->exportField($this->NOSEP);
                        $doc->exportField($this->KDINACBG);
                        $doc->exportField($this->KDSEVERITY);
                        $doc->exportField($this->NMINACBG);
                        $doc->exportField($this->BYTAGIHAN);
                        $doc->exportField($this->BYTARIFGRUPER);
                        $doc->exportField($this->BYTARIFRS);
                        $doc->exportField($this->BYTOPUP);
                        $doc->exportField($this->JNSPELAYANAN);
                        $doc->exportField($this->NOMR_SEP);
                        $doc->exportField($this->NOMR);
                        $doc->exportField($this->NAMA);
                        $doc->exportField($this->KDSTATSEP);
                        $doc->exportField($this->NMSTATSEP);
                        $doc->exportField($this->TGLPULANG);
                        $doc->exportField($this->TGLSEP);
                        $doc->exportField($this->REST_CODE);
                        $doc->exportField($this->REST_MESSAGE);
                        $doc->exportField($this->REST_DATE);
                        $doc->exportField($this->REST_METHOD);
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
