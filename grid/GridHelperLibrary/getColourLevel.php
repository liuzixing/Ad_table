<?php
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
?>