<?php
require_once("HelperClass/loginHandler.php");
header("Content-type: application/json");
//echo json_encode($_POST);
echo json_encode(loginHandler($_POST["tag"]));

?>
