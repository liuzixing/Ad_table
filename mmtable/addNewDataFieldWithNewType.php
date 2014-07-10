<?php
function addNewDataFieldWithNewType($fields,$dataType){
    $res = array();
    foreach ($fields as $key) {
        $res[] =
        array(
            "name"        => $key,
            "cellsformat" => $dataType
        );
    }
    return $res;
}
?>