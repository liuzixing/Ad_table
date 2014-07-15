<?php
function getSQLString() {
    return "
 select mm.grp as grp, mm.nb as positif, mm1.nb as total, mm.client, mm1.channel,mm.campaign as campaign,dmin,dmax, mm.weekday as WEEKDAY ,mm.screen as screen,
  mm.visits as visits, mm.contacts as contacts from ((SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`)
  ,client, campaign ,count(*) as nb, channel,
 ((sum(`apres-count1`) - sum(`avant-count1`))/(sum(grpref)*59093000/100)) as grp,(sum(`apres-count1`) - sum(`avant-count1`)) as visits, (sum(grpref)*59093000/100) as contacts,
  if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY,screen
FROM `spotleads`
WHERE
( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month) and stataud  in (0,1)  and  campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
GROUP BY screen, WEEKDAY, channel, campaign order by cpvi ) as mm , ( select AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client, count(*) as nb, channel,Max(date) as dmax, MIN(date) as dmin,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY,screen
FROM `spotleads`
WHERE isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1)  and  campaign in (select distinct(campaign) from (select * from spotleads where
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
GROUP BY screen, WEEKDAY, channel, campaign  order by cpvi ) as mm1 ) where   mm.client = mm1.client and mm.channel = mm1.channel and mm.screen = mm1.screen and mm.weekday = mm1.weekday order by grp desc " ;
}
?>