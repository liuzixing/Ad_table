<?php
require_once("getSQLString.php");
require_once("HelperClass/getResponse.php");

$settingString = array(
   "Chaine",
            "Ecran",
            "Weekday",
            "MMDayPart",
            "CPVI" ,
            "Indice" ,
            "positif",
            "total",
            "DayPart",
            "TTR",
            "Nombre de Contacts",
            "Visites Gagnnees",
            "BRUIT",
            "FIABILITE-2",
            "FIABILITE",
            "FIABILITE-1",
            "Campaigne",
            "DE",
            "A"
);

header("Content-type: application/json");
echo json_encode(ResponseProcessor::getResponse($settingString,getSQLString()));

?>
