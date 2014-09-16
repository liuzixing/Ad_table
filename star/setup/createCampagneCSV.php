<?
	require_once('/home/www/mymedia_fr/tyco/api/setup/setuplib.php');
	
	function outputCSV($data)
	{
		$output = fopen("php://output", "w");
		foreach ($data as $row)
			fputcsv($output, $row);

		fclose($output);
	}

	$csv = getFormatCampagneCSV();
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=ModeleCampagneMyMedia.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	outputCSV(array(array($csv)));
	exit();
?>