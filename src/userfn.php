<?php

namespace PHPMaker2021\simrs;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function CurrentOrgId() {
    $sText = "1";
    return $sText;}

/*function VisitId() {
    $idVisit = ExecuteScalar("SELECT ((((((CONVERT([varchar](4),datepart(year,getdate()),(0))+right(CONVERT([varchar](4),datepart(month,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(day,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(hour,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(minute,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(second,getdate())+(100),(0)),(2)))+left(newid(),(7)))");
    return $idVisit;}*/

/*function BillId(){
	$idBill = ExecuteScalar ("SELECT ((((((CONVERT([varchar](4),datepart(year,getdate()),(0))+right(CONVERT([varchar](4),datepart(month,getdate())+(100),0),(2)))+right(CONVERT([varchar](3),datepart(day,getdate())+(100),0),(2)))+right(CONVERT([varchar](3),datepart(hour,getdate())+(100),0),(2)))+right(CONVERT([varchar](3),datepart(minute,getdate())+(100),0),(2)))+right(CONVERT([varchar](3),datepart(second,getdate())+(100),0),(2)))+left(newid(),(7)))");
	return idBill;}*/

/*function BayarBillId() {
    $bayarBill = ExecuteScalar("SELECT ((((((CONVERT([varchar](4),datepart(year,getdate()),(0))+right(CONVERT([varchar](4),datepart(month,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(day,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(hour,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(minute,getdate())+(100),(0)),(2)))+right(CONVERT([varchar](3),datepart(second,getdate())+(100),(0)),(2)))+left(newid(),(7)))");
    return bayarBill;}*/

/*function GetNomr(){
	$nomorCm = ExecuteScalar("EXEC dbo.SP_NOMR;");
	return nomorCm;}*/

/*function GetNextNomr()
{
	$sNextKode = "";
	$sLastKode = "";
	$value = ExecuteScalar("SELECT CAST((ISNULL(max(convert(INTEGER,ltrim(NO_REGISTRATION))),0) +1)  AS VARCHAR(10))FROM PASIEN WHERE len(NO_REGISTRATION)=6 AND (NO_REGISTRATION < '250676')");
	if ($value != "") { 
		$sLastKode = intval(substr($value, 1, 6));
		$sLastKode = intval($sLastKode) + 1;
		$sNextKode = sprintf('%06s', $sLastKode); 
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { 
		$sNextKode = "000001";
	}
	return $sNextKode;
}*/
