<?php
function addNewColumnFilterSetting($columns){
    $res = array();
    foreach ($columns as $key) {
        $res[] =
        array(
            "label"   => $key,
            "value"   => $key,
            "checked" => true
        );
    }
    return $res;
}
?>