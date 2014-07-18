<?php
function getFinalColourTable($channelName,$t,&$colourTable,$cpviAVGTable){
	if (!array_key_exists("children",$t)){
		return $t;
	}
	$child = array();
	for ($i = 0; $i < count($t["children"]);$i++){
		$child[] = getFinalColourTable($channelName,$t["children"][$i],$colourTable);
	}
	
	$t["children"] = $child;
	foreach($channelName as $cn){
		$cal = 0;
		for ($i = 0; $i < count($child);$i++){
			
			if (array_key_exists($cn,$t) && array_key_exists($cn,$child[$i])){
				$t[$cn]["total"] += $child[$i][$cn]["total"];
				$t[$cn]["positif"] += $child[$i][$cn]["positif"];
				$t[$cn]["cpvi"] += $child[$i][$cn]["cpvi"];
				$cal++;
			}
		}
		if ($cal){
			$t[$cn]["cpvi"] = floatval($t[$cn]["cpvi"] / $cal);
		}
		$t[$cn]["fiabilite"] = floatval((1-(($t[$cn]["total"]-$t[$cn]["positif"]+1)/$t[$cn]["positif"])));
		
		require_once("getColourString.php");
		$colourTable[$t["id"]][$cn] = getColourString($t[$cn]["fiabilite"],$t[$cn]["cpvi"],$cpviAVGTable[$cn]);
		/* if($t[$cn]["fiabilite"] >= 0.5){
			$colourTable[$t["id"]][$cn] = 1;
		} */
	}
	return $t;
}
?>