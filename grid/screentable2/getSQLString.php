<?php
function getSQLString() {
    return "
  SELECT  mm.cpvi as cpvi, mm.nb as positif, mm1.nb as total, mm.screen as screen ,mm.client, mm1.channel as channel , mm.weekday as WEEKDAY, dmin,dmax, mm.campaign as campaign from (( select (sum(`budgetnet`) / sum( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client,  campaign , count(*) as nb, channel,
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
  screen
FROM `spotleads`
WHERE
( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month) and stataud  in (0,1)  and  campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
GROUP BY screen, WEEKDAY, channel, campaign order by cpvi ) as mm , ( select AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client, count(*) as nb, channel,Max(date) as dmax, MIN(date) as dmin,
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
screen
FROM `spotleads`
WHERE isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1)  and  campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
GROUP BY screen, WEEKDAY, channel, campaign  order by cpvi ) as mm1 ) where   mm.client = mm1.client and mm.channel = mm1.channel and mm.screen = mm1.screen and mm.weekday = mm1.weekday order by cpvi " ;
}
?>