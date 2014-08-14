<?php
require_once("../HelperClass/DashboardDataGenerator.php");
header("Content-type: application/json");
echo json_encode(DashboardDataGenerator::getLiveData($_GET['client']));
?>