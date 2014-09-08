<?php
require_once("../HelperClass/DashboardDataGenerator.php");
//$res =new DashboardDataGenerator();
header("Content-type: application/json");
$res = array();
$res[] = DashboardDataGenerator::getRealTimeInitialData($_GET['client']);
$res[] = DashboardDataGenerator::getPlotLineData($_GET['client']);
//'0f5151d07515f82a6447378175fb18f2c14416b9'
echo json_encode($res);
?>