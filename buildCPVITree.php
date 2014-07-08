<?php
function buildCPVITree($array, $delimiter = '_')
{
    if(!is_array($array)) return false;
	$count = 1;
    $splitRE   = '/' . preg_quote($delimiter, '/') . '/';
    $returnArr = array();
    foreach ($array as $key => $val) {
        // Get parent parts and the current leaf
        $parts  = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
        $leafPart = array_pop($parts);
		$leafPart = array_pop($parts);
        // Build parent structure
        $parentArr = &$returnArr;
        foreach ($parts as $part) {
			$indx = -1;
			for ($i = 0;$i < count($parentArr);$i++){
				if ($parentArr[$i]["name"] == $part) {
					$parentArr[$i][$val[1]] =  0;
					$indx = $i;
				}
			}
			if($indx < 0){
				$parentArr[]= array("id"=>$count,"name" => $part,$val[1]=>0,"children" =>array());
				$count++;
				$indx = count($parentArr) - 1;
			}
			
            $parentArr = &$parentArr[$indx]["children"];
        }

        // Add the final part to the structure
		$indx = -1;
		for ($j = 0;$j < count($parentArr);$j++){
			if ($parentArr[$j]["name"] == $leafPart) {
				$parentArr[$j][$val[1]] =  $val[0];
				$indx = $j;
			}
		}
		if($indx < 0){
			$parentArr[]= array("id"=>$count,"name" => $leafPart,$val[1]=>$val[0]);
			$count++;
		}
    }
    return $returnArr;
}
?>