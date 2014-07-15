<?php
require_once("getSQLString.php");
require_once("../GridHelperLibrary/getResponse.php");

$settingString = array(
    "Chaine"=>array("format"=>"","type"=>"string") ,
    "Weekday"=>array("format"=>"","type"=>"string") ,
    "MMDayPart"=>array("format"=>"","type"=>"string") ,
    "CPVI"=>array("format"=>"f2","type"=>"float") ,
    "Indice"=>array("format"=>"f2","type"=>"float")
);

header("Content-type: application/json");
echo json_encode(getResponse($settingString,getSQLString()));

?>
