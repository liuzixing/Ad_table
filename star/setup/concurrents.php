<?php
	require_once('/home/www/mymedia_fr/tyco/api/setup/setuplib.php');
	
	// On crée cette variable pour afficher le message d'erreur sur le client essaie d'ajouter un concurrent de plus alors qu'il n'a pas le droit
	$noError = 1;
	if ($_POST['conc'])
	{
		if ($_POST['action'] == 'add')
		{
			if ($noError = authorize_add_concurrent($_POST['clientName']))
				add_concurrent(utf8_decode($_POST['conc']), $_POST['clientName']);
		}
		else
			delete_concurrent(utf8_decode($_POST['conc']), $_POST['clientName']);
	}

	$concurrents = get_concurrents($_POST['clientName']);

	if (!$noError)
		echo "<div class='errorMsg'>Vous avez atteint la limite de 10 concurrents. Veuillez supprimer un concurrent pour en ajouter un autre ou changer votre niveau de service.</div>";
	
	echo "<div id='concurrents'>";
	if (!$noError)
		echo "<div class='errorMsg'>Vous avez atteint la limite de 10 concurrents. Veuillez supprimer un concurrent pour en ajouter un autre ou changer votre niveau de service.</div>";
	echo "Votre liste de concurrents :
				<ul>";
	foreach ($concurrents as $concurrent)
	{
		echo "<li>".utf8_encode($concurrent)." <a class='delete-button' onclick='deleteConcurrent(\"".utf8_encode($concurrent)."\")'> Supprimer </a></li>";
	}
	echo "</ul></div>";
?>