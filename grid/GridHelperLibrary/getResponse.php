<?php
    function getResponse($settingString,$SQLString){
        require_once("gridCellSetting.php");
        require_once("gridCellDataGenerator.php");
        $response    = array();
        $cellsetting = new GridCellSetting($settingString);
        $generator = new gridCellDataGenerator($settingString);

        $response[]  = $cellsetting->getNewColumnsWithNewFormat();
        $response[] =  $cellsetting->getNewDataFieldWithNewType();
        if ($generator->setUp($SQLString)){
                $response[] = $generator->getCellData();
                $response[] = $generator->getColourTable();
        }
        $response[] =  $cellsetting->getNewColumnFilterSetting();
        return $response;
    }
?>