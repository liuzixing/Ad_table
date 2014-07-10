<?php
function addNewColumnsWithNewFormat($columns,$formatType){
    $res = array();
    foreach ($columns as $key) {
        $res[] =
        array(
            "text"        => $key,
            "columnGroup" => "Option",
            "align"       => "center",
            "datafield"   => $key,
            "width"       => 112,
            "cellsAlign"  => 'center',
            "cellsformat" => $formatType
        );
    }
    return $res;
}
?>