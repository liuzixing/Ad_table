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
if ($sqlresult = mysql_query($sqlrequest)){	

	while ($sqlrow = mysql_fetch_assoc($sqlresult)) {
		$rows["/".$sqlrow['channel']."/".$sqlrow['WEEKDAY']."/".$sqlrow['daypart']."/".$sqlrow['MMDayPart']."/".$sqlrow['screen']] =round(floatval($sqlrow['cpvi']),2);
	}
};

function explodeTree($array, $delimiter = '_', $baseval = false)
{
    if(!is_array($array)) return false;
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
            if (!isset($parentArr[$part])) {
                $parentArr[$part] = array();
            } elseif (!is_array($parentArr[$part])) {
                if ($baseval) {
                    $parentArr[$part] = array('__base_val' => $parentArr[$part]);
                } else {
                    $parentArr[$part] = array();
                }
            }
            $parentArr = &$parentArr[$part];
        }

        // Add the final part to the structure
        if (empty($parentArr[$leafPart])) {
            $parentArr[$leafPart] = $val;
        } elseif ($baseval && is_array($parentArr[$leafPart])) {
            $parentArr[$leafPart]['__base_val'] = $val;
        }
    }
    return $returnArr;
}
$tree = explodeTree($rows,"/", true);
//$tree = explodeTree($rows,"/", true);

#header("Content-type: application/json");
#header('Content-Type: text/javascript');
#echo $sqlrequest;
 print "<pre>";

print_r($tree);
print "</pre>"; 
#echo json_encode($tree ); 
?>
		
