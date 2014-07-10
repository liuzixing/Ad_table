<?php
//--------------------------------------------------------------------------------------------------

$db_connected = false;

function dblib_db_connect()
{
    global $db_connected;
    global $db_sqlconnexion;

    if ($db_connected)
        return true;

    $db_sqlconnexion = mysql_connect("babel.mymedia.fr", "lmuser", "lmuser") or die('Could not connect: ' . mysql_error());
    $db_connected = mysql_select_db("leadsmonitor");

    return $db_connected;
}
;

function dblib_db_disconnect()
{
    global $db_sqlconnexion;

    mysql_close($db_sqlconnexion);
}
;



//--------------------------------------------------------------------------------------------------

dblib_db_connect();
//"Call indice('tripadvisor')";
require_once("getSQLString.php");
$sqlrequest = getSQLString();

$response    = array();
$cellData    = array();
$colourTable = array();
if ($sqlresult = mysql_query($sqlrequest)) {

    $indice     = 10.00;
    $minus      = 0;
    $num_rows   = mysql_num_rows($sqlresult);
    $array_size = floatval(20 / ($num_rows - 1));
    $positif    = 0;
    $total      = 0;
    $fiability2 = 0;
    $row        = array();

    while ($sqlrow = mysql_fetch_assoc($sqlresult)) {
        $total      = $sqlrow['total'];
        $positif    = $sqlrow['positif'];
        $fiability2 = floatval((1 - (($total - $positif + 1) / $positif)));
        require_once("getColourLevel.php");
        $colourTable[] = getColourLevel($indice,$fiability2);
        $row["CHAINE"]    = $sqlrow['channel'];
        $row["WEEKDAY"]   = $sqlrow['WEEKDAY'];
        $row["MMDayPart"] = $sqlrow['MMDayPart'];
        $row["CPVI"]      = round(floatval($sqlrow['cpvi']), 2);
        if ($indice - $array_size > 0) {
            $row["Indice"] = round($indice - $minus, 2);
            $minus         = $array_size;
            $indice        = $indice - $minus;
        } else {
            $row["Indice"] = 0.00;
        }
        $row["positif"]     = $sqlrow['positif'];
        $row["total"]       = $sqlrow['total'];
        $row["FIABILITE-1"] = intval((1 - (1 / $positif)) * 100);
        $row["BRUIT"]       = intval((($total - $positif) / $total) * 100);
        $row["FIABILITE-2"] = intval((1 - (($total - $positif + 1) / $positif)) * 100);
        $row["Campaign"]    = $sqlrow['campaign'];
        $row["DE"]          = $sqlrow['dmin'];
        $row["A"]           = $sqlrow['dmax'];
        $cellData[]         = $row;

    }

}
$columnName = array(
    "CHAINE",
    "WEEKDAY",
    "MMDayPart",
    "CPVI",
    "Indice",
    "positif",
    "total",
    "FIABILITE-1",
    "BRUIT",
    "FIABILITE-2",
    "Campaign",
    "DE",
    "A"
);
//BRUIT,FIABILITE-2,Campaign,DE,A)
//CHAINE,WEEKDAY,MMDayPart,CPVI,Indice,positif,total,FIABILITE-1,
//BRUIT,FIABILITE-2,Campaign,DE,A
//0 :columnFormat
require_once("addNewColumnsWithNewFormat.php");
$columnFormat = addNewColumnsWithNewFormat(array(
    "CHAINE",
    "WEEKDAY",
    "MMDayPart",
    "Campaign",
    "DE",
    "A"
), "");
$columnFormat = array_merge($columnFormat, addNewColumnsWithNewFormat(array(
    "CPVI",
    "Indice"
), "f2"));
$columnFormat = array_merge($columnFormat, addNewColumnsWithNewFormat(array(
    "positif",
    "total"
), "d"));
$columnFormat = array_merge($columnFormat, addNewColumnsWithNewFormat(array(
    "BRUIT",
    "FIABILITE-2",
    "FIABILITE-1"
), "p"));
$response[]   = $columnFormat;
//1:dataFields
require_once("addNewDataFieldWithNewType.php");
$dataFields = array();
$dataFields = array_merge($dataFields, addNewDataFieldWithNewType(array(
    "CHAINE",
    "WEEKDAY",
    "MMDayPart",
    "Campaign",
    "DE",
    "A"
), "string"));
$dataFields = array_merge($dataFields, addNewDataFieldWithNewType(array(
    "CPVI",
    "Indice",
    "BRUIT",
    "FIABILITE-2",
    "FIABILITE-1"
), "float"));
$dataFields = array_merge($dataFields, addNewDataFieldWithNewType(array(
    "positif",
    "total"
), "number"));

$response[] = $dataFields;
//2:cell data
$response[] = $cellData;
//3:colour table
$response[] = $colourTable;

//4:column fitler
require_once("addNewColumnFilterSetting.php");
$columnFitlerSetting = addNewColumnFilterSetting(array_merge(array(
    "Select all"
), $columnName));

$response[] = $columnFitlerSetting;
header("Content-type: application/json");
echo json_encode($response);
// print "<pre>";
// print_r($response);
// print "</pre>";
?>