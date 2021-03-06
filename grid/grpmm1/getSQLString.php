<?php
function getSQLString() {
    return

"select mm.grp as grp, mm.nb as positif, mm1.nb as total, mm.client, mm1.channel, mm.mmdaypart as MMDayPart,mm.campaign as campaign,dmin,dmax, mm1.weekday as WEEKDAY , mm.visits as visits , mm.contacts as contacts from ((SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client, campaign ,count(*) as nb, channel,
sum(`apres-count1` - `avant-count1`) as visits, (sum(grpref)*59093000/100) as contacts,
( CASE
WHEN (
dayofweek(date)=1
)
THEN replace( date, date, 'Dimanche' )
 WHEN (
dayofweek(date)=2
)
THEN replace( date, date, 'Lundi' )
 WHEN (
dayofweek(date)=3
)
THEN replace( date, date, 'Mardi' )
WHEN (
dayofweek(date)=4
)
THEN replace( date, date, 'Mercredi' )
 WHEN (
dayofweek(date)=5
)
THEN replace( date, date, 'Jeudi' )
    WHEN (
dayofweek(date)=6
)
THEN replace( date, date, 'Vendredi' )
 WHEN (
dayofweek(date)=7
)
THEN replace( date, date, 'Samedi' )
END)
 AS WEEKDAY,
 (sum(`apres-count1` - `avant-count1`)/(sum(grpref)*59093000/100)) as grp, (
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
END ) AS MMDayPart
FROM `spotleads`
WHERE  ( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month) and stataud  in (0,1) and  campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
group by channel, WEEKDAY, MMDayPart,campaign
ORDER BY cpvi ASC ) as mm , (SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,Max(date) as dmax, MIN(date) as dmin, client,campaign, count(*) as nb, channel,
(
    CASE
WHEN (
dayofweek(date)=1
)
THEN replace( date, date, 'Dimanche' )
 WHEN (
dayofweek(date)=2
)
THEN replace( date, date, 'Lundi' )
 WHEN (
dayofweek(date)=3
)
THEN replace( date, date, 'Mardi' )
WHEN (
dayofweek(date)=4
)
THEN replace( date, date, 'Mercredi' )
 WHEN (
dayofweek(date)=5
)
THEN replace( date, date, 'Jeudi' )
    WHEN (
dayofweek(date)=6
)
THEN replace( date, date, 'Vendredi' )
 WHEN (
dayofweek(date)=7
)
THEN replace( date, date, 'Samedi' )
END)
 AS WEEKDAY,
 (
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
END ) AS MMDayPart
FROM `spotleads`
WHERE  isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) and campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
group by channel, WEEKDAY, MMDayPart,campaign
ORDER BY cpvi ASC) as mm1 ) where mm.weekday = mm1.weekday and mm.mmdaypart = mm1.mmdaypart and mm.channel = mm1.channel and mm.campaign = mm1.campaign order by mm.grp desc " ;
}
?>