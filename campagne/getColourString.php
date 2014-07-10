<?php
	function getColourString($fiabilite,$cpvi,$cpviAVG){
		if ($fiabilite >= 0.75 && $cpvi <= 0.25 * $cpviAVG){
			return "green";
		}elseif($fiabilite >= 0.5 && $fiabilite < 0.75 && $cpvi <= 0.25 * $cpviAVG){
			return "yellow";
		}elseif($fiabilite >= 0.5 && $fiabilite < 0.75 && $cpvi <= 0.5 * $cpviAVG && $cpvi > 0.25 * $cpviAVG){
			return "orange";
		}elseif($fiabilite >= 0.5 && $cpvi > 0.5 * $cpviAVG){
			return "red";
		}else{
			return "";
		}
	}
?>