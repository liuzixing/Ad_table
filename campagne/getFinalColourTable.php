<?php
function getFinalColourTable($channelName,$t,&$colourTable,$cpviAVG){
	if (!array_key_exists("children",$t)){
		$t["total"] = 0;
		$budgetnet = 0;
		$apres = 0;
		$avant = 0;
		$total = 0;
		$positif = 0;
		foreach ($channelName as $cn) {
			if (array_key_exists($cn, $t) && $cn != "total") {
				$budgetnet += $t[$cn]["budgetnet"];
				$apres += $t[$cn]["apres"];
				$avant += $t[$cn]["avant"];
				$total += $child[$i][$cn]["total"];
				$positif += $child[$i][$cn]["positif"];
			}
		}
		$t["total"] = $budgetnet / ($apres  - $avant );
		$fiabilite = floatval((1-(($total - $positif + 1) / $positif)));
		$colourTable[$t["id"]]["total"] = getColourString($fiabilite,$t["total"],$cpviAVG);
		return $t;
	}
	$t["total"] = 0;
	$child = array();
	for ($i = 0; $i < count($t["children"]);$i++){
		$child[] = getFinalColourTable($channelName,$t["children"][$i],$colourTable,$cpviAVG);
	}

	$t["children"] = $child;
	foreach($channelName as $cn){
		if ($cn == "total")
			continue;
		for ($i = 0; $i < count($child);$i++){

			if (array_key_exists($cn,$t) && array_key_exists($cn,$child[$i])){

				$t[$cn]["total"] += $child[$i][$cn]["total"];
				$t[$cn]["positif"] += $child[$i][$cn]["positif"];
				$t[$cn]["budgetnet"] += $child[$i][$cn]["budgetnet"];
				$t[$cn]["apres"] += $child[$i][$cn]["apres"];
				$t[$cn]["avant"] += $child[$i][$cn]["avant"];
			}
		}
		if ($t[$cn]["budgetnet"]){
			$t[$cn]["cpvi"] = $t[$cn]["budgetnet"] / ($t[$cn]["apres"] - $t[$cn]["avant"]);
		}
		$t[$cn]["fiabilite"] = floatval((1-(($t[$cn]["total"]-$t[$cn]["positif"]+1)/$t[$cn]["positif"])));

		require_once("getColourString.php");
		$colourTable[$t["id"]][$cn] = getColourString($t[$cn]["fiabilite"],$t[$cn]["cpvi"],$cpviAVG);

	}
	// cal total
	$budgetnet = 0;
	$apres = 0;
	$avant = 0;
	$total = 0;
	$positif = 0;
	foreach ($channelName as $cn) {
		if (array_key_exists($cn, $t) && $cn != "total") {
			$budgetnet += $t[$cn]["budgetnet"];
			$apres += $t[$cn]["apres"];
			$avant += $t[$cn]["avant"];
			$total += $child[$i][$cn]["total"];
			$positif += $child[$i][$cn]["positif"];
		}
	}
	$t["total"] = $budgetnet / ($apres  - $avant );
	$fiabilite = floatval((1-(($total - $positif + 1) / $positif)));
	$colourTable[$t["id"]]["total"] = getColourString($fiabilite,$t["total"],$cpviAVG);
	return $t;
}
?>