<?php
require_once("getSQLString.php");
require_once("../GridHelperLibrary/getResponse.php");

$settingString = array(
    "Chaine",
    "Weekday",
    "MMDayPart",
    "CPVI" ,
    "Indice" ,
    "positif" ,
    "total" ,
    "BRUIT",
    "FIABILITE",
    "DE",
    "A"
);

header("Content-type: application/json");
echo json_encode(ResponseProcessor::getResponse($settingString,getSQLString()));

?>
