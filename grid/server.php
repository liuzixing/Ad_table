<?php
require_once("getSQLString.php");
require_once("GridHelperLibrary/getResponse.php");
$settingString = array(
    "TTR",
    "Visites Gagnnees" ,
    "Nombre de Contacts",
    "Chaine",
    "Weekday",
    "MMDayPart"
);
header("Content-type: application/json");

echo json_encode(ResponseProcessor::getBubbleFormatDataResponse($settingString,getSQLString()));
?>