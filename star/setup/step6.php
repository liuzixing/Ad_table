<?php
	$successArray = verifyCSVHistorique($infoClient);
	if ($_GET['error'])
		$error = $_GET['error'];
	if ($successArray[0])
		$success = $successArray[1];
	else
		if ($successArray[1] != "")
			$error = $successArray[1];
	$first_visit_date = whenWasTagImplemented($infoClient['clientName']);
?>
<div class="setup-box-content">
	<p class='msg'>
		Import de l'historique : comparaison des données afin de vérifier que nous sommes en phase<br/><br/>
		<div class="center">
				<?php
					// Si nous avons 1 jour complet de données
					if (date("Y-m-d", strtotime("+1 day", strtotime($first_visit_date))) < date("Y-m-d"))
						echo "Voici le modèle CSV à remplir afin que nous puissions vérifier si les données trackées sont bien en phase avec les vôtres.
						Dès que le fichier contenant votre historique est prêt, vous pourrez le charger ici afin que nous puissions lancer la comparaison.<br/>
						<u><b> Si un paramètre est manquant chez vous, remplissez la colonne correspondante avec la valeur \"NONE\". Cette étape est très importante.</b></u>";
					else
						echo "Attendons d'avoir plus de données pour faire la comparaison : nous avons besoin d'un jour complet. Revenez le ".date("d/m/Y", strtotime("+2 days", strtotime($first_visit_date))).".";
				?>
				<br/><br/>
				<a href="createHistoriqueCSV.php?token=<?php echo $token; ?>" class="btn">Modèle CSV à respecter pour l'import Historique </a>
				<br/><br/>
				<div class="center">
					<?php 
						if (isset($error))
							echo "<p class='errorMsg'> ".$error."<br/></p>";
						if (isset($success) && !isset($error))
							echo "<p class='successMsg'> ".$success."<br/></p>";
					?>
					<form method="POST" id="upload" action="setupStepBridge.php" enctype="multipart/form-data">
						<input type="hidden" name="MAX_FILE_SIZE" value="10000000000">
						<input type="hidden" name="step" value="7"/>
						<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
						<input type="file" name="historique"> <br/><br/>
						<input class="upload-button" type="submit" onclick='document.getElementById("upload").submit()' name="upload" value="Charger le fichier">
					</form>
				</div>
		</div>
	</p>
	<br/> <br/> <br/> <br/>
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<input type="hidden" name="step" value="7"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
<div class="setup-box-footer">
	<?php if (isset($success)) echo "<a class='checkout-button' onclick='document.getElementById(\"nextStep\").submit()'> Septième étape : Résultats de la comparaison </a>"; ?>
</div>