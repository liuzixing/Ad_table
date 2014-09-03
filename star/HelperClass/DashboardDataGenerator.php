<?php
class DashboardDataGenerator {
    static function getRealTimeInitialData($client) {
        $now   = date('Y-m-d H:i:s', time());
        $today = date('Y-m-d', time());
        // $yesterday =   date('Y-m-d ', mktime(0, 0, 0, date("m"), date("d") - 1   ,   date("Y")));
        return self::getRealTimeData($client,$today,$now);
    }
    static function getLiveData($client) {
        $now            = date('Y-m-d H:i:s', time());
        $someSecondsAgo = date('Y-m-d H:i:s', time() - 100);
       return self::getRealTimeData($client,$someSecondsAgo,$now);
    }
    static function getPlotLineData($theBrandId){
        $now   = new DateTime();
        $theSQLDate = $now->format('Y-m-d');
        $detections_url   = 'https://api.tvty.tv/ws/ads/detections/fr?partner=54e2baa8b1619e0c88ef418cee21f85f40b3deb4&brand=' . $theBrandId . '&start=' . $theSQLDate . '&end=' . $theSQLDate . '&tz=Europe/paris';
        $detections_text  = file_get_contents($detections_url);
        $detections_text  = str_replace("\x00", "", $detections_text);
        $detections_lines = explode("\n", $detections_text);
        $data = array();
        foreach ($detections_lines as $detections_line) {
            $detections_line = trim($detections_line);
            if ($detections_line == "")
                continue;
            $line_fields = explode(";", $detections_line);
            $line_data   = array();
            if ($line_data['date'] == 'Date')
                continue;
            $data[] = Array(
                strtotime(trim($line_fields[0]) . " " . trim($line_fields[1])) * 1000,
                trim($line_fields[2])
            );
        }
        return $data;
    }
    static function getRealTimeData($client,$from,$to){
        // connect to MySQL
        require_once('/home/www/mymedia_fr/lib/dblib.php');
        if (!($con = db_connect_client_return($client))) die('DB Err');
        $request_id = "SELECT idsite from reeperf_site where name='".$client."'";
        $result_id = mysql_query($request_id) or die('ID Request Error');
        if ($idrow = mysql_fetch_assoc($result_id))
            $idsite = $idrow['idsite'];
        else
            echo "No ID found";
        $sqlrequest = "SELECT CONVERT_TZ(`datetime`, '+00:00', '+2:00') as datetime, nbvisit as visits
                FROM `realtime_" . $idsite . "`
                WHERE  CONVERT_TZ(`datetime`, '+00:00', '+2:00') BETWEEN '" . $from . "' AND '" . $to . "'";
        $result = mysql_query($sqlrequest) or die(mysql_error());
        $rows = array();
        while ($row = mysql_fetch_assoc($result)) {
            $datetime = $row['datetime'];
            $visits   = $row['visits'];
            $rows[]   = array(strtotime($datetime) * 1000,(int) $visits);
        }
        mysql_close($con);

        return $rows;
    }
}
?>