<?php
require_once("getSQLString.php");
require_once("../GridHelperLibrary/getResponse.php");
$settingString = array(
    "Chaine"=>array("format"=>"","type"=>"string") ,
    "Ecran"=>array("format"=>"","type"=>"string") ,
    "Weekday"=>array("format"=>"","type"=>"string") ,
    "TTR"=>array("format"=>"f2","type"=>"float") ,
    "Nombre de Contacts"=>array("format"=>"","type"=>"string") ,
    "Visites Gagnnees"=>array("format"=>"d","type"=>"number") ,
    "Indice"=>array("format"=>"f2","type"=>"float") ,
    "positif"=>array("format"=>"d","type"=>"number") ,
    "total"=>array("format"=>"d","type"=>"number") ,
    "BRUIT"=>array("format"=>"p","type"=>"float") ,
    "FIABILITE"=>array("format"=>"p","type"=>"float") ,
    "Campaigne"=>array("format"=>"","type"=>"string") ,
    "DE"=>array("format"=>"","type"=>"string") ,
    "A"=>array("format"=>"", "type"=>"string")
);
header("Content-type: application/json");
echo json_encode(getResponse($settingString,getSQLString()));
?>