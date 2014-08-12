<?php
require_once("../HelperClass/DashboardDataGenerator.php");
$res =new DashboardDataGenerator();
header("Content-type: application/json");
echo json_encode($res->getRealTimeInitialData($_GET['idsite']));
?>