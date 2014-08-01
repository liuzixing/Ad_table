<?php

class gridCellDataGenerator{
    var $dataField;
    var $cellData = array();
    var $colourTable = array();
    function gridCellDataGenerator($df){
        $this->dataField = $df;
    }
    function getCellData(){
        return $this->cellData;
    }
    function getColourTable(){
        return $this->colourTable;
    }
    function getColourLevel($indice,$fiability2){
        if ($indice > 7.5 and $fiability2 >= 0.5) {
            return "levelOne";
        } elseif ($indice > 5 and $indice < 7.5 and $fiability2 >= 0.5) {
            return "levelTwo";
        } elseif ($indice > 4.5 and $indice < 5 and $fiability2 >= 0.5) {
            return "levelThree";
        } elseif ($indice < 2 and $indice > 1 and $fiability2 >= 0.5) {
            return "levelFour";
        } elseif ($indice < 1 and $fiability2 >= 0.5) {
            return "levelFive";
        } else {
            return "";
        }
    }
    function setUp($SQLString){
        require_once("dbhelper.php");
        if ($sqlrequest = DBHelper::Query($SQLString)){
            $indice     = 10.00;
            $minus      = 0;
            $num_rows   = DBHelper::getQueryRowNumber();
            $array_size = floatval(20 / ($num_rows - 1));
            $positif    = 0;
            $total      = 0;
            $fiability2 = 0;
            $row = array();
            while($sqlrow = DBHelper::getRow()){
                $total      = $sqlrow['total'];
                $positif    = $sqlrow['positif'];
                $fiability2 = floatval((1 - (($total - $positif + 1) / $positif)));
                foreach ($this->dataField as $key => $value) {
                    switch ($key) {
                        case 'Chaine':
                            $row["Chaine"] = $sqlrow['channel'];
                            break;
                        case 'Weekday':
                            $row["Weekday"]  = $sqlrow['WEEKDAY'];
                            break;
                        case 'MMDayPart':
                            $row["MMDayPart"] = $sqlrow['MMDayPart'];
                            break;
                        case 'CPVI':
                            $row["CPVI"] = floatval($sqlrow['cpvi']);
                            break;
                        case 'Indice':
                            if ($indice - $array_size > 0) {
                                $row["Indice"] = round($indice - $minus, 2);
                                $minus         = $array_size;
                                $indice        = $indice - $minus;
                            } else {
                                $row["Indice"] = 0.00;
                            }
                            break;
                        case 'positif':
                            $row["positif"]     = $sqlrow['positif'];
                            break;
                        case 'total':
                            $row["total"]     = $sqlrow['total'];
                            break;
                        case "FIABILITE-1":
                            $row["FIABILITE-1"] = intval((1 - (1 / $positif)) * 100);
                            break;
                        case 'BRUIT':
                            $row["BRUIT"]     = intval((($total - $positif) / $total) * 100);
                            break;
                        case "DayPart":
                            $row["DayPart"] = $sqlrow['DayPart'];
                            break;
                        case "TTR":
                            $row["TTR"]      = ((round(floatval($sqlrow['grp']),4))*1000);
                            break;
                        case "Nombre de Contacts":
                            $row["Nombre de Contacts"] = round(floatval($sqlrow['contacts'])/1000,1)."K";
                            break;
                        case "Visites Gagnnees":
                            $row["Visites Gagnnees"] = $sqlrow['visits'];
                            break;
                        case "FIABILITE-2":
                            $row["FIABILITE-2"] = intval((1 - (($total - $positif + 1) / $positif)) * 100);
                            break;
                        case "FIABILITE":
                            $row["FIABILITE"] = intval((1 - (($total - $positif + 1) / $positif)) * 100);
                            break;
                        case "Campaigne":
                            $row["Campaigne"]    = $sqlrow['campaign'];
                            break;
                        case "DE":
                            $row["DE"]          = $sqlrow['dmin'];
                            break;
                        case "A":
                            $row["A"]           = $sqlrow['dmax'];
                            break;
                        case "Ecran":
                            $row["Ecran"] = $sqlrow['screen'];
                    }
                }
                $this->colourTable[] = self::getColourLevel($indice,$fiability2);
                $this->cellData[]      = $row;
            }
        }
        return $sqlrequest;
    }
    function getNewColumnFilterSetting(){
        $res = array(array(
                "label"   => "Select all",
                "value"   => "Select all",
                "checked" => true
            ));
        foreach ($this->dataField as $key=>$val) {
            $res[] = array(
                "label"   => $key,
                "value"   => $key,
                "checked" => true
            );
        }
        return $res;
    }
    function getNewColumnsWithNewFormat(){
        $res = array();
        foreach ($this->dataField as $key=>$val) {
            $res[] = array(
                "text"        => $key,
                "columnGroup" => "Option",
                "align"       => "center",
                "datafield"   => $key,
                "width"       => 100/count($this->dataField)."%",
                "cellsAlign"  => 'center',
                "cellsformat" => $val["format"]
            );
        }
        return $res;
    }
    function getNewDataFieldWithNewType(){
        $res = array();
        foreach ($this->dataField as $key =>$val) {
            $res[] = array(
                "name"        => $key,
                "cellsformat" => $val["type"]
            );
        }
        return $res;
    }

}
?>