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
  select mm.cpvi as cpvi, mm.nb as positif, mm1.nb as total, mm.client, mm1.channel as channel , mm1.mmdaypart as MMDayPart, mm.campaign as campaign,dmin,dmax, mm1.weekday as WEEKDAY, mm1.screen as screen, mm1.daypart as daypart , mm1.length as format , mm1.crea as crea from ((SELECT AVG(`budgetnet` / ( `apres-count1` - `avant-count1` )) AS cpvi, sum(budgetnet),sum(`apres-count1`) , screen,crea,length , sum(`avant-count1`) ,client, campaign ,count(*) as nb, channel,if( weekday( date ) >4, replace( date, date, 'WE' ) , 'WD' ) AS WEEKDAY, (

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
group by campaign, screen, channel ,  crea, length
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
group by channel, screen, campaign ,  crea, length
ORDER BY cpvi ASC) as mm1 ) where mm.weekday = mm1.weekday and mm.mmdaypart = mm1.mmdaypart and mm.channel = mm1.channel and mm.campaign = mm1.campaign  and mm.screen = mm1.screen and mm.daypart = mm1.daypart and mm.crea = mm1.crea and mm.length = mm1.length order by mm.cpvi " ;


$versionName = array();
$LengthsName = array();
$cpviRows = array();
$cpviAVGTable = array();


if ($sqlresult = mysql_query($sqlrequest)){
    $indice= 10.00;
    $minus =0;
    $num_rows = mysql_num_rows($sqlresult);
    $array_size = floatval(20/($num_rows-1));
    $positif = 0;
    $total = 0;
    $fiability2 = 0;
    while ($sqlrow = mysql_fetch_assoc($sqlresult)) {

        $versionName[] = $sqlrow['crea'];
        $LengthsName[] = $sqlrow['format'];

        $cpviRows["/ALL/".$sqlrow['WEEKDAY']."/".$sqlrow['daypart']."/".$sqlrow['MMDayPart']."/".$sqlrow['screen']."/".$sqlrow['channel']] = array(floatval($sqlrow['cpvi']),$sqlrow['channel']);

        $cpviAVGTable[$sqlrow['channel']]["value"] += floatval($sqlrow['cpvi']);
        $cpviAVGTable[$sqlrow['channel']]["count"]++;

        //get colour table
        $total =  $sqlrow['total'];
        $positif = $sqlrow['positif'];
        $fiabilite = floatval((1-(($total-$positif+1)/$positif))) ;
        $colourRows["/ALL/".$sqlrow['WEEKDAY']."/".$sqlrow['daypart']."/".$sqlrow['MMDayPart']."/".$sqlrow['screen']."/".$sqlrow['channel']] = array(array("total" =>$total,"positif"=>$positif,"fiabilite"=>$fiabilite,"cpvi"=>floatval($sqlrow['cpvi'])),$sqlrow['channel']);

        //get columns
        $columnName[] = $sqlrow['channel'];

    }

};
$res = array();

$channelName = array_unique($columnName);
$dataFields = array_unique($columnName);


//get  cpvi AVG Table
foreach($channelName as $c) {
    $cpviAVGTable[$c] = $cpviAVGTable[$c]["value"] / $cpviAVGTable[$c]["count"];
}

//create json format column data
$jsonColumn = array(array("text"=>"DayPart-Ecran","columnGroup"=>"Option","align"=>"center","datafield"=>"name","width"=>130));
foreach($channelName as $c) {
    $jsonColumn[] = array("text"=>$c,"columnGroup"=>"Channel","align"=>"center","datafield"=>$c,"width"=>112,"cellsAlign"=>'center',"cellsformat"=> 'F2');
}
$res[] = $jsonColumn;


//create json format datafield data
$jsonDataField = array(array("name"=>"id","type"=>"number"));
$jsonDataField[] =  array("name"=>"name","type"=>"string");
$jsonDataField[] =  array("name"=>"children","type"=>"array");
foreach($dataFields as $d) {
    $jsonDataField[] = array("name"=>$d,"type"=>"float");
}
$res[] = $jsonDataField;

//change list data to tree data
require_once("buildCPVITree.php");
$cpviTree = buildCPVITree($cpviRows,"/");

//get avg data
require_once("calAVG.php");
$cpviTree[0] = calTheFuckingAVG($channelName,$cpviTree[0]);
$res[] = $cpviTree;

$columnListSource = array(array("label"=>"Select all","value"=>"all","checked"=>true));
foreach($channelName as $c) {
    $columnListSource[] = array("label"=>$c,"value"=>$c,"checked"=>true);
}
$res[] = $columnListSource;


//get Colour Tree
require_once("buildColourTree.php");
$colourTable;
$colourTree = buildColourTree($colourRows,"/",$colourTable,$cpviAVGTable);

//get final colour table
require_once("getFinalColourTable.php");
$colourTree[0] = getFinalColourTable($channelName,$colourTree[0],$colourTable,$cpviAVGTable);

$res[] = $colourTable;
// print "<pre>";
// print_r ($res);

// print "</pre>";
header("Content-type: application/json");
echo json_encode($res);
?>