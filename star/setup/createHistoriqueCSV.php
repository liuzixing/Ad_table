<?
	require_once('/home/www/mymedia_fr/tyco/api/setup/setuplib.php');
	session_start();

	$infoClient = get_client_infos($_SESSION[$_GET['token']]['mymedia_username']);
	
	function outputCSV($data)
	{
		$output = fopen("php://output", "w");
		foreach ($data as $row)
			fputcsv($output, $row);
		fclose($output);
	}

	$csv = getFormatHistoCSV($infoClient['kpis']);
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=ModeleHistoriqueMyMedia.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	outputCSV(array(array(str_replace("\"", "", $csv))));
	exit();
?>