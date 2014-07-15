<?php
class GridCellSetting {
    var $columnSetting;
    function GridCellSetting($cs){
        $this->columnSetting = $cs;
    }
    function getNewColumnFilterSetting(){
        $res = array(array(
                "label"   => "Select all",
                "value"   => "Select all",
                "checked" => true
            ));
        foreach ($this->columnSetting as $key=>$val) {
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
        foreach ($this->columnSetting as $key=>$val) {
            $res[] = array(
                "text"        => $key,
                "columnGroup" => "Option",
                "align"       => "center",
                "datafield"   => $key,
                "width"       => 100/count($this->columnSetting)."%",
                "cellsAlign"  => 'center',
                "cellsformat" => $val["format"]
            );
        }
        return $res;
    }
    function getNewDataFieldWithNewType(){
        $res = array();
        foreach ($this->columnSetting as $key =>$val) {
            $res[] = array(
                "name"        => $key,
                "cellsformat" => $val["type"]
            );
        }
        return $res;
    }
}
?>