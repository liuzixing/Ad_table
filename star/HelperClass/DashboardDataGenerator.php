<?php
class DashboardDataGenerator {
    function getRealTimeInitialData($idsite) {
        if ($idsite && !preg_match('/^[0-9]+$/', $idsite)) {
            die("Invalid idsite parameter: $idsite");
        }
        // connect to MySQL
        if (self::db_connect())
            die('DB Err');
        $ret = array();
        $now   = date('Y-m-d H:i:s', time());
        $today = date('Y-m-d', time());
        $yesterday =   date('Y-m-d ', mktime(0, 0, 0, date("m"), date("d") - 1   ,   date("Y")));

        $sqlrequest = "SELECT CONVERT_TZ(`datetime`, '+00:00', '+2:00') as datetime, nbvisit as visits
                FROM `realtime_" . $idsite . "`
                WHERE  CONVERT_TZ(`datetime`, '+00:00', '+2:00') BETWEEN '" . $yesterday . "' AND '" . $now . "'";
        $result = mysql_query($sqlrequest) or die(mysql_error());
        $rows = array();
        while ($row = mysql_fetch_assoc($result)) {
            $datetime = $row['datetime'];
            $visits   = $row['visits'];
            $rows[]   = array(strtotime($datetime) * 1000,(int) $visits);
        }
        return $rows;
    }
    function getLiveData($idsite) {
        if ($idsite && !preg_match('/^[0-9]+$/', $idsite)) {
            die("Invalid idsite parameter: $idsite");
        }
        if (self::db_connect())
            die('DB Err');
        $now            = date('Y-m-d H:i:s', time());
        $someSecondsAgo = date('Y-m-d H:i:s', time() - 50);
        $sqlrequest     = "SELECT CONVERT_TZ(`datetime`, '+00:00', '+2:00') as datetime, nbvisit as visits
                FROM `realtime_" . $idsite . "`
                WHERE  CONVERT_TZ(`datetime`, '+00:00', '+2:00') BETWEEN '" . $someSecondsAgo . "' AND '" . $now . "'";
        $result = mysql_query($sqlrequest) or die(mysql_error());
        $rows = array();
        while ($row = mysql_fetch_assoc($result)) {
            $datetime = $row['datetime'];
            $visits   = $row['visits'];
            $rows[]   = array(strtotime($datetime) * 1000, (int) $visits);
        }
        return $rows;
    }
    function db_connect() {
        $link = mysql_connect("173.194.251.92", "root", "MMpwk84") or die("Impossible de se connecter : " . mysql_error());
        if ($link) {
            $db = mysql_select_db("reeperf", $link) or die("Couldn\'t select database");
            return 0;
        }
        return 1;
    }
}
?>