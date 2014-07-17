<?php
function calAVG($channelName, $t){
	$t = calTheFuckingAVG($channelName, $t);
	foreach ($channelName as $cn) {
		if($cn == "total")
			continue;
		$t[$cn] = $t[$cn]["cpvi"];
	}
	return $t;
}
function calTheFuckingAVG($channelName, $t) {
	if (!array_key_exists("children", $t)) {
		$t["total"] = 0;
		$budgetnet = 0;
		$apres = 0;
		$avant = 0;
		foreach ($channelName as $cn) {
			if (array_key_exists($cn, $t) && $cn != "total") {
				$budgetnet += $t[$cn]["budgetnet"];
				$apres += $t[$cn]["apres"];
				$avant += $t[$cn]["avant"];
			}
		}
		$t["total"] = $budgetnet / ($apres  - $avant );
		return $t;
	}
	$t["total"] = 0;
	$child      = array();
	for ($i = 0; $i < count($t["children"]); $i++) {
		$child[] = calTheFuckingAVG($channelName, $t["children"][$i]);
	}
	$t["children"] = $child;
	foreach ($channelName as $cn) {
		if ($cn == "total")
			continue;
		// $t[$cn]["budgetnet"]  = 0;
		// $t[$cn]["apres"] = 0;
		// $t[$cn]["avant"] = 0;
		for ($i = 0; $i < count($child); $i++) {
			if (array_key_exists($cn, $t) && array_key_exists($cn, $child[$i])) {
				$t[$cn]["budgetnet"] += $child[$i][$cn]["budgetnet"];
				$t[$cn]["apres"] += $child[$i][$cn]["apres"];
				$t[$cn]["avant"] += $child[$i][$cn]["avant"];
			}
		}
		//$t[$cn]["cpvi"] = 0;
		if ($t[$cn]["budgetnet"]){
			$t[$cn]["cpvi"] = $t[$cn]["budgetnet"] / ($t[$cn]["apres"] - $t[$cn]["avant"]);
		}
	}
	// cal total

	$budgetnet = 0;
	$apres = 0;
	$avant = 0;
	foreach ($channelName as $cn) {
		if (array_key_exists($cn, $t) && $cn != "total") {
			$budgetnet += $t[$cn]["budgetnet"];
			$apres += $t[$cn]["apres"];
			$avant += $t[$cn]["avant"];
		}
	}
	$t["total"] = $budgetnet / ($apres  - $avant );

	//set array to value.
	foreach ($channelName as $cn) {
		if($cn == "total"){
			continue;
		}
		for ($i = 0; $i < count($t["children"]); $i++) {
			if (array_key_exists($cn, $t) && array_key_exists($cn, $t["children"][$i])) {
				$t["children"][$i][$cn] = $t["children"][$i][$cn]["cpvi"];
			}
		}
	}

	return $t;
}
?>