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


header("Content-type: application/json");
//echo json_encode( array($_POST['requestType']));
$res = array();

 // if ($_POST['requestType'] != "ALL"){
 //    echo json_encode( "ooooops!");
 // }else{
 //   // echo "I get it!!!!!!!";
 // }
$versionName = array();
$LengthsName = array();
$cpviRows = array();
$cpviAVGTable = array();

 require_once("getSQLString.php");
$flag = false;
$testString;
if (!empty($_POST["requestType"])){
    $sqlrequest = getSQLString($_POST,$testString);
    $flag = $_POST["requestType"] == "part";
}

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

$LengthsName =  array_unique($LengthsName);
$versionName = array_unique($versionName);
$channelName = array_unique($columnName);
$dataFields = array_unique($columnName);


//get  cpvi AVG Table
foreach($channelName as $c) {
    $cpviAVGTable[$c] = $cpviAVGTable[$c]["value"] / $cpviAVGTable[$c]["count"];
}

//create json format column data
$jsonColumn = array(array("text"=>"DayPart-Ecran","columnGroup"=>"Option","align"=>"center","datafield"=>"name","width"=>130));
foreach($channelName as $c) {
    $jsonColumn[] = array("text"=>$c,"columnGroup"=>"Channel","align"=>"center","datafield"=>$c,"width"=>112,"cellsAlign"=>'center',"cellsformat"=> 'c2');
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

// create column filter list.
$columnListSource = array(array("label"=>"Select all","value"=>"Select all","checked"=>true));
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

// create length filter list.
$lengthListSource = array(array("label"=>"Select all","value"=>"Select all","checked"=>true));
foreach($LengthsName as $l) {
    $lengthListSource[] = array("label"=>$l,"value"=>$l,"checked"=>true);
}
$res[] = $lengthListSource;

// create version filter list.
$verisonListSource = array(array("label"=>"Select all","value"=>"Select all","checked"=>true));
foreach($versionName as $v) {
    $verisonListSource[] = array("label"=>$v,"value"=>$v,"checked"=>true);
}
$res[]  = $verisonListSource;
// print "<pre>";
// print_r ($res);

// print "</pre>";
//header("Content-type: application/json");
// if (!$flag){
//     echo json_encode($res);
// }

$res[] = $sqlrequest;
echo json_encode($res);

?>