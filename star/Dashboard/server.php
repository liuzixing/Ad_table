<?php
require_once("../HelperClass/DashboardDataGenerator.php");
header("Content-type: application/json");
$res = array();
$res[] = DashboardDataGenerator::getRealTimeInitialData($_GET['client']);
$res[] = DashboardDataGenerator::getPlotLineData($_GET['client']);
echo json_encode($res);
?>