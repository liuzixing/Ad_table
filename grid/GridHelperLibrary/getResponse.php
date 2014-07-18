<?php
class ResponseProcessor{
       static function getResponse($settingString,$SQLString){

            require_once("gridCellDataGenerator.php");
            $response    = array();
            $generator = new gridCellDataGenerator(self::subSettingString($settingString));
            $response[]  = $generator->getNewColumnsWithNewFormat();
            $response[] =  $generator->getNewDataFieldWithNewType();
            if ($generator->setUp($SQLString)){
                    $response[] = $generator->getCellData();
                    $response[] = $generator->getColourTable();
            }
            $response[] =  $generator->getNewColumnFilterSetting();
            return $response;
        }
        static function getBubbleFormatDataResponse($settingString,$SQLString){
            require_once("gridCellDataGenerator.php");
            $generator = new gridCellDataGenerator(self::subSettingString($settingString));
            $response = array();
            $response[] = $settingString;
            if ($generator->setUp($SQLString)){
                $bubbleData = $generator->getCellData();
            }
             foreach ($bubbleData as $key => $value) {
                 $row = array();
                 $row[] = $value["TTR"];
                 $row[] = floatval($value["Visites Gagnnees"]);
                 $row[] = floatval(substr($value["Nombre de Contacts"],0,-1))*1000;
                 $row[] = $value["Chaine"].",".$value["Weekday"].",".$value["MMDayPart"];
                 $bubbleData[$key] = $row;
             }
             $response[] = $bubbleData;
            return $response;
        }
      function subSettingString($setting){
        $allSetting = array(
            "Chaine"=>array("format"=>"","type"=>"string") ,
            "Ecran"=>array("format"=>"","type"=>"string") ,
            "Weekday"=>array("format"=>"","type"=>"string") ,
            "MMDayPart"=>array("format"=>"","type"=>"string") ,
            "CPVI"=>array("format"=>"f2","type"=>"float") ,
            "Indice"=>array("format"=>"f2","type"=>"float") ,
            "positif"=>array("format"=>"","type"=>"number") ,
            "total"=>array("format"=>"","type"=>"number") ,
            "DayPart"=>array("format"=>"","type"=>"string") ,
            "TTR"=>array("format"=>"c","type"=>"float") ,
            "Nombre de Contacts"=>array("format"=>"","type"=>"string") ,
            "Visites Gagnnees"=>array("format"=>"","type"=>"number") ,
            "BRUIT"=>array("format"=>"p","type"=>"float") ,
            "FIABILITE-2"=>array("format"=>"p","type"=>"float") ,
            "FIABILITE"=>array("format"=>"p","type"=>"float") ,
            "FIABILITE-1"=>array("format"=>"p","type"=>"float") ,
            "Campaigne"=>array("format"=>"","type"=>"string") ,
            "DE"=>array("format"=>"","type"=>"string") ,
            "A"=>array("format"=>"", "type"=>"string")
            );
           $res = array();
            foreach ($setting as $key => $value) {
                $res[$value] = $allSetting[$value];
            }
            return $res;
        }
    }
?>
