<?php
function getSQLString($post, &$testString) {
	$requestType = $post["requestType"];
	$verisonList = $post["verisonList"];
	$lengthList  = $post["lengthList"];

	if ($requestType == "ALL") {
		$condition = "";
	} else {
		$verisonList = "'".implode("', '", array_keys($post["verisonList"]))."'";
		$lengthList  = implode(',', array_map("intval", array_keys($post["lengthList"])));
		$condition   = "length in (".$lengthList.") AND crea in (".$verisonList.") AND ";
		//echo json_encode(array("x"=>$condition));
	}

	return "select mm.cpvi as cpvi,mm.budgetnet as budgetnet,mm.apres as apres,mm.avant as avant, mm.nb as positif, mm.nb as total, mm.client, mm.channel as channel , mm.mmdaypart as MMDayPart, mm.campaign as campaign,dmin,dmax, mm.weekday as WEEKDAY, mm.screen as screen, mm.daypart as daypart , mm.length as format , mm.crea as crea from ((SELECT (sum(`budgetnet`) / sum( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet) as budgetnet,sum(`apres-count1`) as apres, screen,crea,length , sum(`avant-count1`) as avant,client, campaign ,count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
THEN replace( time, time, 'Access18' )
WHEN (
 hour( time ) =19
)
THEN replace( time, time, 'Access19' )
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
THEN replace( time, time, 'Access' )
ELSE 'Night'
END ) AS DayPart
FROM `spotleads`
WHERE  ".$condition." ( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month) and stataud  in (0,1) and  campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
group by campaign, screen, channel
ORDER BY cpvi ASC ) as mm , (SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,Max(date) as dmax,crea, length, MIN(date) as dmin, client,campaign, screen, count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
THEN replace( time, time, 'Access18' )
WHEN (
 hour( time ) =19
)
THEN replace( time, time, 'Access19' )
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
THEN replace( time, time, 'Access' )
ELSE 'Night'
END ) AS DayPart
FROM `spotleads`
WHERE ".$condition." isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) and campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
group by channel, screen, campaign
ORDER BY cpvi ASC) as mm1 ) where mm.weekday = mm1.weekday and mm.mmdaypart = mm1.mmdaypart and mm.channel = mm1.channel and mm.campaign = mm1.campaign  and mm.screen = mm1.screen and mm.daypart = mm1.daypart and mm.crea = mm1.crea and mm.length = mm1.length  order by mm.cpvi ";
}
?>