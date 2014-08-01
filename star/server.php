<?php
require_once("getSQLString.php");
require_once("HelperClass/getResponse.php");

$settingString = array(
    "Chaine",
    "Weekday",
    "MMDayPart",
    "CPVI" ,
    "Indice"
);

header("Content-type: application/json");
echo json_encode(ResponseProcessor::getResponse($settingString,getSQLString()));

?>
