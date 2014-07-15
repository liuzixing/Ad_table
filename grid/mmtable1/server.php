<?php
require_once("../GridHelperLibrary/dbhelper.php");
require_once("getSQLString.php");
require_once("../GridHelperLibrary/getColourLevel.php");
require_once("../GridHelperLibrary/gridCellSetting.php");
$response    = array();
$cellData    = array();
$colourTable = array();
if (DBHelper::Query(getSQLString())) {
    $indice     = 10.00;
    $minus      = 0;
    $num_rows   = DBHelper::getQueryRowNumber();
    $array_size = floatval(20 / ($num_rows - 1));
    $positif    = 0;
    $total      = 0;
    $fiability2 = 0;
    $row        = array();
    while ($sqlrow = DBHelper::getRow()) {
        $total      = $sqlrow['total'];
        $positif    = $sqlrow['positif'];
        $fiability2 = floatval((1 - (($total - $positif + 1) / $positif)));
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
$settingString = array(
    "CHAINE"=>array("format"=>"","type"=>"string") ,
    "WEEKDAY"=>array("format"=>"","type"=>"string") ,
    "MMDayPart"=>array("format"=>"","type"=>"string") ,
    "CPVI"=>array("format"=>"f2","type"=>"float") ,
    "Indice"=>array("format"=>"f2","type"=>"float") ,
    "positif"=>array("format"=>"d","type"=>"number") ,
    "total"=>array("format"=>"d","type"=>"number") ,
    "FIABILITE-1"=>array("format"=>"p","type"=>"float") ,
    "BRUIT"=>array("format"=>"p","type"=>"float") ,
    "FIABILITE-2"=>array("format"=>"p","type"=>"float") ,
    "Campaign"=>array("format"=>"","type"=>"string") ,
    "DE"=>array("format"=>"","type"=>"string") ,
    "A"=>array("format"=>"", "type"=>"string")
);

$cellsetting = new GridCellSetting($settingString);
$response[]  = $cellsetting->getNewColumnsWithNewFormat();
$response[] =  $cellsetting->getNewDataFieldWithNewType();
$response[] = $cellData;
$response[] = $colourTable;
$response[] =  $cellsetting->getNewColumnFilterSetting();

header("Content-type: application/json");
echo json_encode($response);
?>