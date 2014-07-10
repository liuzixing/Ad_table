<?php
function calTheFuckingAVG($channelName, $t) {
	if (!array_key_exists("children", $t)) {
		$cal        = 0;
		$t["total"] = 0;
		foreach ($channelName as $cn) {
			if (array_key_exists($cn, $t) && $cn != "total") {
				$t["total"] += $t[$cn];
				$cal++;
			}
		}
		if ($cal) {
			$t["total"] = floatval($t["total"]/$cal);
		}
		return $t;
	}
	$t["total"] = 0;
	$child      = array();
	for ($i = 0; $i < count($t["children"]); $i++) {
		$child[] = calTheFuckingAVG($channelName, $t["children"][$i]);
	}
	$t["children"] = $child;
	foreach ($channelName as $cn) {
		$cal = 0;
		for ($i = 0; $i < count($child); $i++) {
			if (array_key_exists($cn, $t) && array_key_exists($cn, $child[$i])) {
				$t[$cn] += $child[$i][$cn];
				$cal++;
			}
		}
		if ($cal) {
			$t[$cn] = floatval($t[$cn]/$cal);
		}
	}
	return $t;
}
function calTheFuckingAVG2($channelName, $t) {
	if (!array_key_exists("children", $t)) {
		return $t;
	}
	$child = array();
	for ($i = 0; $i < count($t["children"]); $i++) {
		$child[] = calTheFuckingAVG($channelName, $t["children"][$i]);
	}
	$t["children"] = $child;
	foreach ($channelName as $cn) {
		$cal = 0;
		for ($i = 0; $i < count($child); $i++) {
			if (array_key_exists($cn, $t) && array_key_exists($cn, $child[$i])) {
				$t[$cn] += $child[$i][$cn];
				$cal++;
			}
		}
		if ($cal) {
			$t[$cn] = floatval($t[$cn]/$cal);
		}
	}
	return $t;
}
?>