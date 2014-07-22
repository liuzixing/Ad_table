<?php
function getSQLString() {
    return
"select mm.cpvi as cpvi, mm.nb as positif, mm1.nb as total,  mm1.channel, mm.mmdaypart as MMDayPart,mm.campaign as campaign,dmin,dmax, mm1.weekday as WEEKDAY from (( select (sum(`budgetnet`) / sum( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client, campaign ,count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
END ) AS MMDayPart
FROM `spotleads`
WHERE  ( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client in ('Balsamik','TronerService', 'AmomaFR', 'Euroassurance', 'Calstaluna', 'sport2000', 'photobox') and date >  DATE_SUB(curdate(),INTERVAL 6 month) and stataud  in (0,1) and
campaign in (select distinct(campaign) from (select * from spotleads where  client = client in ('Balsamik','TronerService', 'AmomaFR', 'Euroassurance', 'Calstaluna', 'sport2000', 'photobox') and date >  DATE_SUB(curdate(),INTERVAL 6 month)   group by campaign having count(distinct(date))> 7)as camp)
group by channel, WEEKDAY, MMDayPart
ORDER BY cpvi ASC ) as mm , (SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,Max(date) as dmax, MIN(date) as dmin, client,campaign, count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
END ) AS MMDayPart
FROM `spotleads`
WHERE  isole =1 and client in ('Balsamik','TronerService', 'AmomaFR', 'Euroassurance', 'Calstaluna', 'sport2000', 'photobox') and date >  DATE_SUB(curdate(),INTERVAL 6 month)  and stataud  in (0,1) and campaign in (select distinct(campaign) from (select * from spotleads where  client in ('Balsamik','TronerService', 'AmomaFR', 'Euroassurance', 'Calstaluna', 'sport2000', 'photobox') and date >  DATE_SUB(curdate(),INTERVAL 6 month)  group by campaign having count(distinct(date))> 7)as camp)
group by channel, WEEKDAY, MMDayPart
ORDER BY cpvi ASC) as mm1 ) where mm.weekday = mm1.weekday and mm.mmdaypart = mm1.mmdaypart and mm.channel = mm1.channel and mm.campaign = mm1.campaign order by mm.cpvi " ;
}
?>