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
SELECT  mm.cpvi as cpvi, mm.nb as positif, mm1.nb as total, mm.client, mm1.channel, mm.daypart as daypart, mm.weekday as weekday, dmin,dmax, mm.campaign as campaign from (( select AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client,campaign, count(*) as nb, channel, if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
WHERE 
( `apres-count1` - `avant-count1` )>0  and budgetnet >0 and isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month) and stataud  in (0,1)  and  campaign in (select distinct(campaign) from (select * from spotleads where 
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp) 
GROUP BY DayPart, WEEKDAY, channel, campaign
ORDER BY cpvi ASC ) as mm , ( select AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , sum(`avant-count1`) ,client, count(*) as nb,Max(date) as dmax, MIN(date) as dmin, channel, if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
WHERE  isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1)  and  campaign in (select distinct(campaign) from (select * from spotleads where 
isole =1 and client = 'tripadvisor' and date >  DATE_SUB(curdate(),INTERVAL 2 month)  and stataud  in (0,1) group by campaign having count(distinct(date))> 7)as camp)
GROUP BY DayPart, WEEKDAY, channel, campaign
ORDER BY cpvi ASC )as mm1 ) where mm.client = mm1.client and mm.channel = mm1.channel and mm.daypart = mm1.daypart and mm.weekday = mm1.weekday order by cpvi" ;



//$values = array();

if ($sqlresult = mysql_query($sqlrequest))
		{	
		
			$indice= 10.00;	
			$minus =0;
			$num_rows = mysql_num_rows($sqlresult);
			$array_size = floatval(20/($num_rows-1));
			$positif = 0;
			$total = 0;
			$fiability2 = 0;
	echo "<table  align=center width=\"60%\"cellspacing=\"2\" cellpadding=\"0\" border=\"2\">\n";
		echo "<th align=center style=\"font-size:18px;\">\n";
		//echo  "tripadvisor";
		echo "</th></tr>\n";
		echo "<tr><th style=\"font-size:18px;\">\n";
		echo "CHAINE";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "WEEKDAY";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "MMDayPart";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "CPVI";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "Indice";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "positif";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "total";
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo utf8_encode("FIABILITE-1");
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo utf8_encode("BRUIT");
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo utf8_encode("FIABILITE-2");
		echo "</th>\n";
		echo "<th style=\"font-size:18px;\">\n";
		echo "Campaign";
		echo "</th>\n";
		echo "<th style=\"width:100px;font-size:18px;\">\n";
		echo "DE";
		echo "</th>\n";
		echo "<th style=\"width:100px;font-size:18px;\">\n";
		echo "A";
		echo "</th>\n";
		while ($sqlrow = mysql_fetch_assoc($sqlresult)) {
			$total =  $sqlrow['total'];
			$positif = $sqlrow['positif'];
			$fiability2 = floatval((1-(($total-$positif+1)/$positif))) ;
			
			if ( $indice > 7.5  and $fiability2 >= 0.5) {
			echo "<tr bgcolor=\"#D6FFAD\">";
			}elseif ( $indice > 5 and $indice < 7.5 and $fiability2 >= 0.5){
			echo "<tr bgcolor=\"#E5FFCA\">";
			}
			elseif( $indice > 4.5 and $indice < 5 and $fiability2 >= 0.5){
			echo "<tr bgcolor=\"#F7FFEF\">";
			}
			elseif( $indice < 2 and $indice > 1 and $fiability2 >= 0.5){
			echo "<tr bgcolor=\"#FF9D5C\">";
			}
			elseif( $indice < 1 and $fiability2 >= 0.5){
			echo "<tr bgcolor=\"#FF3333\">";
			}else{
			echo "<tr>";
			}
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['channel'];
			echo "</td>";
				echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['weekday'];
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['daypart'];
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	round(floatval($sqlrow['cpvi']),2);
			echo "</td>\n";	
		if ( $indice - $array_size  > 0) {
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	round($indice-$minus,2);
			echo "</td>\n";
			
			 $minus = $array_size;
			 $indice = $indice-$minus;
			}else {
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	0.00;
			echo "</td>\n";
			}
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['positif'];
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['total'];
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	intval((1-(1/$positif))*100)."%";
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	intval((($total-$positif)/$total)*100)."%";
			echo "</td>";
			
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	intval((1-(($total-$positif+1)/$positif))*100)."%";
			echo "</td>";
			
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['campaign'];
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['dmin'];
			echo "</td>";
			echo "<td align=center style=\"font-size:15px;\">\n";
			echo 	$sqlrow['dmax'];
			echo "</td></tr>";
			
			
			
		
};
};

 ?>