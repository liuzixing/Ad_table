<?php
	require_once('/home/www/mymedia_fr/tyco/api/setup/setuplib.php');
	session_start();

	// On récupère les infos du client
	$infoClient = get_client_infos($_SESSION[$_GET['token']]['mymedia_username']);


	$kpiArray = explode("|", $infoClient['kpis']);
	
	$fileName = "Plan de taggage ".$infoClient['clientName'].".txt";
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename='".str_replace(" ", "_", $fileName)."'");

	print "Plan de taggage ".$infoClient['clientName']." (".date("Y-m-d H:m").")\r\n\r\n";
	if ($infoClient['typeTag'] == "Pixel")
	{
		print "1) Tag Visites : A poser sur TOUTES les pages du site, sauf les pages possédant un tag particulier."."\r\n";
		print "<img src='http://".$infoClient['urlTracker']."/reeperf.php?idsite=".$infoClient['idsite']."&rec=1' style='border:0;' alt='' />"."\r\n";
		print "\r\n";

		$i = 2;
		foreach ($kpiArray as $kpi)
		{
			if ($kpi == "Visites" ||
				$kpi == "Devices" ||
				$kpi == "Newvisitors" ||
				$kpi == "Rebonds")
				continue;
			print "$i) Tag ".$kpi."\r\n";
			print "<img src='http://".$infoClient['urlTracker']."/reeperf.php?idsite=".$infoClient['idsite']."&idgoal=".$i."&rec=1' style='border:0;' alt='' />\r\n";
			print "\r\n";
			$i++;
		}
	}
	else
	{
		print "1) Tag Visites : A poser sur TOUTES les pages du site, sauf les pages possédant un tag particulier."."\r\n";

		print '<script type="text/javascript">
	window.reeperfAsyncInit = function ()
	  {
		try
		{
			var url=(("https:" == document.location.protocol) ? "https" : "http") + "://'.$infoClient['urlTracker'].'/";
			var reeperf = Reeperf.getTracker(url+"reeperf.php", '.$infoClient['idsite'].');
			reeperf.trackPageView();
			reeperf.enableLinkTracking(true);
		}catch(err) {}
	  };
</script>
<script type="text/javascript" src="http://'.$infoClient['urlTracker'].'/trackreeperf.js"></script>
<noscript><img src="http://'.$infoClient['urlTracker'].'/reeperf.php?idsite='.$infoClient['idsite'].'&rec=1" style="border:0;" alt="" /></noscript>'."\r\n";

		print "\r\n";

		$i = 2;
		foreach ($kpiArray as $kpi)
		{
			if ($kpi == "Visites" ||
				$kpi == "Devices" ||
				$kpi == "Newvisitors" ||
				$kpi == "Rebonds")
				continue;
			print "$i) Tag ".$kpi."\r\n";

			print '<script type="text/javascript">
	window.reeperfAsyncInit = function ()
	{
		try
		{
			var url=(("https:" == document.location.protocol) ? "https" : "http") + "://'.$infoClient['urlTracker'].'/";
			var reeperf = Reeperf.getTracker(url+"reeperf.php", '.$infoClient['idsite'].');
			reeperf.trackGoal('.$i.');
			reeperf.trackPageView();
			reeperf.enableLinkTracking(true);
		}catch(err) {}
	};
</script>
<script type="text/javascript" src="http://'.$infoClient['urlTracker'].'/trackreeperf.js"></script>
<noscript><img src="http://'.$infoClient['urlTracker'].'/reeperf.php?idsite='.$infoClient['idsite'].'&idgoal='.$i.'&rec=1" style="border:0;" alt="" /></noscript>'."\r\n";

			$i++;
		}
	}
	
	// On met à jour la date de la dernière génération de plan de taggage
	set_taggingPlan_date($infoClient['clientName'], date("Y-m-d H:m"));
?>