<?php
//--------------------------------------------------------------------------------------------------

$db_connected = false;

function dblib_db_connect ()

                {
                global $db_connected;
                global $db_sqlconnexion;

                if ($db_connected) return true;

                $db_sqlconnexion = mysql_connect("babel.mymedia.fr", "lmuser", "lmuser")
                               or die('Could not connect: ' . mysql_error());
                $db_connected = mysql_select_db("leadsmonitor");

                return $db_connected;
                };

function dblib_db_disconnect ()

                {
                global $db_sqlconnexion;

                mysql_close($db_sqlconnexion);
                };

		
		
//--------------------------------------------------------------------------------------------------

 dblib_db_connect();
 //"Call indice('tripadvisor')";

$sqlrequest = "
  select mm.cpvi as cpvi, mm.nb as positif, mm1.nb as total, mm.client, mm1.channel as channel , mm1.mmdaypart as MMDayPart, mm.campaign as campaign,dmin,dmax, mm1.weekday as WEEKDAY, mm1.screen as screen, mm1.daypart as daypart from ((SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , screen, sum(`avant-count1`) ,client, campaign ,count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

CASE 
WHEN (
hour( time ) <=09
AND hour( time ) >=3
)
THEN replace( time, time, 'Day0309' ) 
when(hour( time ) <=11
AND hour( time ) >=10
)
THEN replace( time, time, 'Day1011' ) 
when(hour( time ) <=13
AND hour( time ) >=12
)
THEN replace( time, time, 'Day1213' )
when(hour( time ) <=15
AND hour( time ) >=14
)
THEN replace( time, time, 'Day1415' )
when(
    hour( time ) <=17
AND hour( time ) >=16
)
THEN replace( time, time, 'Day1617' )   
WHEN (
hour( time ) <=21
AND hour( time ) >=20
)
THEN replace( time, time, 'Peak' ) 

WHEN (
 hour( time ) =18
)
THEN replace( time, time, 'Acess18' ) 
WHEN (
 hour( time ) =19
)
THEN replace( time, time, 'Acess19' ) 
when (hour( time ) <=23
AND hour( time ) >=22
)
THEN replace( time, time, 'Night2223' )
when (((hour( time ))%24) <=02
AND ((hour( time ))%24) >=0
)
THEN replace( time, time, 'Night0002' )
END ) AS MMDayPart , (

CASE 
WHEN (
hour( time ) <=17
AND hour( time ) >=3
)
THEN replace( time, time, 'Day' ) 
WHEN (
hour( time ) <=21
AND hour( time ) >=20
)
THEN replace( time, time, 'Peak' ) 
WHEN (
hour( time ) <=19
AND hour( time ) >=18
)
THEN replace( time, time, 'Acess' ) 
ELSE 'Night'
END ) AS DayPart
FROM `spotleads` 
WHERE  ( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month) and stataud  in (0,1) and  campaign in (select distinct(campaign) from (select * from spotleads where 
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
group by campaign, screen, channel  
ORDER BY cpvi ASC ) as mm , (SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,Max(date) as dmax, MIN(date) as dmin, client,campaign, screen, count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

CASE 
WHEN (
hour( time ) <=09
AND hour( time ) >=3
)
THEN replace( time, time, 'Day0309' ) 
when(hour( time ) <=11
AND hour( time ) >=10
)
THEN replace( time, time, 'Day1011' ) 
when(hour( time ) <=13
AND hour( time ) >=12
)
THEN replace( time, time, 'Day1213' )
when(hour( time ) <=15
AND hour( time ) >=14
)
THEN replace( time, time, 'Day1415' )
when(
    hour( time ) <=17
AND hour( time ) >=16
)
THEN replace( time, time, 'Day1617' )   
WHEN (
hour( time ) <=21
AND hour( time ) >=20
)
THEN replace( time, time, 'Peak' ) 

WHEN (
 hour( time ) =18
)
THEN replace( time, time, 'Acess18' ) 
WHEN (
 hour( time ) =19
)
THEN replace( time, time, 'Acess19' ) 
when (hour( time ) <=23
AND hour( time ) >=22
)
THEN replace( time, time, 'Night2223' )
when (((hour( time ))%24) <=02
AND ((hour( time ))%24) >=0
)
THEN replace( time, time, 'Night0002' )
END ) AS MMDayPart , (

CASE 
WHEN (
hour( time ) <=17
AND hour( time ) >=3
)
THEN replace( time, time, 'Day' ) 
WHEN (
hour( time ) <=21
AND hour( time ) >=20
)
THEN replace( time, time, 'Peak' ) 
WHEN (
hour( time ) <=19
AND hour( time ) >=18
)
THEN replace( time, time, 'Acess' ) 
ELSE 'Night'
END ) AS DayPart
FROM `spotleads` 
WHERE  isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) and campaign in (select distinct(campaign) from (select * from spotleads where 
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
group by channel, screen, campaign 
ORDER BY cpvi ASC) as mm1 ) where mm.weekday = mm1.weekday and mm.mmdaypart = mm1.mmdaypart and mm.channel = mm1.channel and mm.campaign = mm1.campaign  and mm.screen = mm1.screen and mm.daypart = mm1.daypart order by mm.cpvi " ;

$rows = array();
 //MMDayPart channel WEEKDAY screen daypart
//GROUP BY DayPart, WEEKDAY, channel, campaign
$columnName = array();
if ($sqlresult = mysql_query($sqlrequest)){	

	while ($sqlrow = mysql_fetch_assoc($sqlresult)) {
		$rows["/DayType/".$sqlrow['WEEKDAY']."/".$sqlrow['daypart']."/".$sqlrow['MMDayPart']."/".$sqlrow['screen']] = array(round(floatval($sqlrow['cpvi']),2),$sqlrow['channel']);
		$columnName[] = $sqlrow['channel'];
	}
};

//record channel and datafield array
$channelName = array_unique($columnName);
$dataFields = array_unique($columnName+array("name"));

//change list data to tree data
function explodeTree($array, $delimiter = '_')
{
    if(!is_array($array)) return false;
	$count = 1;
    $splitRE   = '/' . preg_quote($delimiter, '/') . '/';
    $returnArr = array();
    foreach ($array as $key => $val) {
        // Get parent parts and the current leaf
        $parts  = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
        $leafPart = array_pop($parts);

        // Build parent structure
        // Might be slow for really deep and large structures
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
		for ($i = 0;$i < count($parentArr);$i++){
			if ($parentArr[$i]["name"] == $leafPart) {
				$parentArr[$i][$val[1]] =  $val[0];
				$indx = $i;
			}
		}
		if($indx < 0){
			$parentArr[]= array("id"=>$count,"name" => $leafPart,$val[1]=>$val[0]);
			$count++;
		}
    }
    return $returnArr;
}
function calTheFuckingAVG($t){
/* 	print "<pre>";
	print_r ($t);
	print "</pre>"; */

	if (!array_key_exists("children",$t)){
		return $t;
	}
	global $channelName;
	//$child = calTheFuckingAVG($t["children"]);
	foreach($channelName as $cn){
		$cal = 0;
		for ($i = 0; $i < count($t["children"]);$i++){
			$child = calTheFuckingAVG($t["children"][$i]);
			if (array_key_exists($cn,$t)){
				$t[$cn] += $child[$i][$cn];
				$cal++;
			}
		}
		if ($cal){
			$t[$cn] = $t[$cn] / $cal;
		}
		print "<pre>";
		print_r ($t[$cn]);
		print "</pre>";
	}
	return $t;
}
//create json format column data
$jsonColumn = array(array("text"=>"Channel","columnGroup"=>"JSTCorp","align"=>"center","dataField"=>"name","width"=>150));
foreach($channelName as $c) {
	$jsonColumn[] = array("text"=>$c,"columnGroup"=>"JSTCorp","align"=>"center","dataField"=>$c,"width"=>120);
}
//create json format datafield data
$jsonDataField = array(array("name"=>"id","type"=>"number"));
$jsonDataField[] =  array("name"=>"children","type"=>"array");
foreach($dataFields as $d) {
	$jsonDataField[] = array("name"=>$d,"type"=>"string");
}
$tree = array();
$tree[] = $jsonColumn;
$tree[] = $jsonDataField;
$tmp = explodeTree($rows,"/");
#$tmp[0] = calTheFuckingAVG($tmp[0]);
$tree[] = $tmp;
//$tree = explodeTree($rows,"/", true);

header("Content-type: application/json");
#header('Content-Type: text/javascript');
#echo $sqlrequest;
/* print "<pre>";
print_r ($tmp);
print "</pre>";   */ 
echo json_encode($tree); 
#echo calTheFuckingAVG(explodeTree($rows,"/"));
?>
		
