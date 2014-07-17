<?php
	function getColourString($fiabilite,$cpvi,$cpviAVG){
		if ($fiabilite < 0.5){
			return "";
		}
		if ($cpvi <= 0.5 * $cpviAVG){
			return "green";
		}elseif($cpvi <= $cpviAVG){
			return "yellow";
		}elseif($cpvi <= 1.5 * $cpviAVG){
			return "orange";
		}else{
			return "red";
		}
	}
?>