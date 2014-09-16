<?php
	require_once('/home/www/mymedia_fr/tyco/api/setup/setuplib.php');
	session_start();
	
	$token = $_POST['token'];
	$infoClient = get_client_infos($_SESSION[$token]['mymedia_username']);

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 1.
	*/
	function process_step1($infoClient, $POST_values)
	{
		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(1, $infoClient['IDcompte']);
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 2.
	*/
	function process_step2($infoClient, $POST_values)
	{
		$newKpis = array();
		$oldKpis = array();
		// On récupère les KPI cochés/décochés des checkbox du formulaire précédent
		foreach($POST_values as $name => $value)
		{
			if (substr($name, 0, 4) == "KPI_")
			{
				if ($value == "on")
					array_push($newKpis, substr($name, 4));
				else
					array_push($oldKpis, substr($name, 4));
			}
		}
		
		// Mise à jour des KPI
		update_kpi($newKpis, $oldKpis, $infoClient);

		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(2, $infoClient['IDcompte']);
		
		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 3.
	*/
	function process_step3($infoClient, $POST_values)
	{
		$newKpis = array();
		$oldKpis = array();
		
		// On récupère les KPI cochés/décochés des checkbox du formulaire précédent
		foreach($POST_values as $name => $value)
		{
			if (substr($name, 0, 4) == "KPI_")
			{
				if ($value == "on")
					array_push($newKpis, substr($name, 4));
				else
					array_push($oldKpis, substr($name, 4));
			}
		}
		
		// Mise à jour des KPI
		update_kpi($newKpis, $oldKpis, $infoClient);

		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(3, $infoClient['IDcompte']);
		
		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 4.
	*/
	function process_step4($infoClient, $POST_values)
	{
		// Mise à jour du type de plan de taggage
		update_typeTag($infoClient['IDcompte'], $POST_values['typeTag']);

		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(4, $infoClient['IDcompte']);
		
		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 5.
	*/
	function process_step5($infoClient, $POST_values)
	{
		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(5, $infoClient['IDcompte']);
		
		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 6, ainsi que celles de gestion des imports campagne.
	*/
	function process_step6($infoClient, $POST_values)
	{
		if (isset($POST_values['upload']))
		{
			$folder = '/home/ftp/'.$infoClient['clientName'].'/';
			$file = basename($_FILES['plan_campagne']['name']);
			$taille_maxi = 1000000000;
			$taille = filesize($_FILES['plan_campagne']['tmp_name']);
			$extensions = array('.csv');
			$extension = strrchr($_FILES['plan_campagne']['name'], '.');

			//Début des vérifications de sécurité
			if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
			{
				$erreur = 'Vous devez charger un fichier de type csv. ('.$extension.' ici)';
			}
			if ($taille > $taille_maxi)
			{
				$erreur = 'Le fichier est trop gros. (.'.($taille_maxi/1000000000).'Go max)';
			}
			if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
			{
				//On formate le nom du fichier ici
				$file = strtr($file, 
				'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
				'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
				$file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
				$newPath = $folder.$file;
				// On charge le fichier dans le dossier FTP du client
				if (move_uploaded_file($_FILES['plan_campagne']['tmp_name'], $newPath))
				{
					// Mettre à jour la table Campagne avec les données du CSV
					$error = populate_Campagne_FTP($newPath, $infoClient['clientName']);
					if ($error)
						header("Location: setup.php?token=".$POST_values['token']."&error=".$error);
					else
						header("Location: setup.php?token=".$POST_values['token']);
					exit();
				}
				else
				{
					$erreur = "Echec du chargement du plan campagne.";
				}
			}
			header("Location: setup.php?token=".$POST_values['token']."&error=".$erreur);
			exit();
		}
		else
			// Mise à jour de l'étape courante du setup du compte
			update_setup_state(6, $infoClient['IDcompte']);

		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 7.
	*/
	function process_step7($infoClient, $POST_values)
	{
		if (isset($POST_values['upload']))
		{
			$folder = '/home/ftp/'.$infoClient['clientName'].'/';
			$file = basename($_FILES['historique']['name']);
			$taille_maxi = 1000000000;
			$taille = filesize($_FILES['historique']['tmp_name']);
			$extensions = array('.csv');
			$extension = strrchr($_FILES['historique']['name'], '.');

			//Début des vérifications de sécurité
			if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
			{
				if ($extension == "")
					$extension = "fichier manquant";
				$erreur = 'Vous devez charger un fichier de type csv. ('.$extension.' ici)';
			}
			if ($taille > $taille_maxi)
			{
				$erreur = 'Le fichier est trop gros. (.'.($taille_maxi/1000000000).'Go max)';
			}
			if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
			{
				// On charge le fichier dans le dossier FTP du client
				if (move_uploaded_file($_FILES['historique']['tmp_name'], $folder."HistoriqueSetup.csv"))
				{
					// Mettre à jour la table Dayseline avec les données du CSV
					$error = populate_Dayseline_FTP($folder."HistoriqueSetup.csv", $infoClient['clientName']);
					if ($error)
						header("Location: setup.php?token=".$POST_values['token']."&error=".$error);
					else
						header("Location: setup.php?token=".$POST_values['token']);
					exit();
				}
				else
				{
					$erreur = "Echec du chargement de l'historique.";
				}
			}
			header("Location: setup.php?token=".$POST_values['token']."&error=".$erreur);
			exit();
		}
		else
			// Mise à jour de l'étape courante du setup du compte
			update_setup_state(7, $infoClient['IDcompte']);
		
		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à l'étape 8.
	*/
	function process_step8($infoClient, $POST_values)
	{
		// Si la comparaison était parfaite, on set la date de création du compte actif à ce jour-ci.
		if ($POST_values['error'] == 0)
		{
			set_client_creationDate($infoClient['clientName']);
		}
		
		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(8, $infoClient['IDcompte']);
		
		return 1;
	}

	/*
		Cette fonction s'occupe de toutes les actions requises pour accéder à la fin de l'installation.
	*/
	function process_step9($infoClient, $POST_values)
	{
		
		
		// Mise à jour de l'étape courante du setup du compte
		update_setup_state(9, $infoClient['IDcompte']);
		
		return 1;
	}

	// On appelle la fonction correspondante à l'étape du compte
	$func = "process_step".$_POST['step'];
	if ($func($infoClient, $_POST));
		header("Location: setup.php?token=".$token);
?>