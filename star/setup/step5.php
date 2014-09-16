<?php
	$successArray = verifyCSVCampagne($infoClient);
	if ($_GET['error'])
		$error = $_GET['error'];
	if ($successArray[0])
		$success = $successArray[1];
	else
		if ($successArray[1] != "")
			$error = $successArray[1];

	$detected = visits_detected($infoClient['clientName']);

	if (isset($_GET['error']))
		$error = $_GET['error'];
?>
<div class="setup-box-content">
	<p class='msg'>
		Import des campagnes et détection automatique de vos tags<br/><br/>
		<div class="center">
			En attendant que votre plan de taggage soit installé, vous pouvez déjà importer votre plan de campagne.
			Il vous sera toujours possible de le faire plus tard si vous souhaitez passer cette étape.<br/><br/>
			<br/><br/>
			<a href="createCampagneCSV.php?token=<?php echo $token; ?>" class="btn">Modèle CSV à respecter pour l'import Campagne </a>
			<br/><br/>
			<div class="center">
				<?php if (isset($error)) echo "<p class='errorMsg'> ".$error."</p>"; ?>
				<?php if (isset($success)) echo "<p class='successMsg'> ".$success."</p>"; ?>
				<form method="POST" id="upload" action="setupStepBridge.php" enctype="multipart/form-data">
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000000">
					<input type="hidden" name="step" value="6"/>
					<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
					<input type="file" name="plan_campagne"> <br/><br/>
					<input class="upload-button" type="submit" onclick='document.getElementById("upload").submit()' name="upload" value="Charger le fichier">
				</form>
			</div>
			<br/><br/>
			<?php
				if ($detected)
					echo "<img src='../img/OK_icon.png'> Félicitations, vos tags ont été détectés comme installés.
					Vous pouvez maintenant passer à l'étape de comparaison avec vos statistiques pour valider l'installation.";
				else
					echo "<img src='../img/invalid-icon.png'> Le plan de taggage n'a pas encore été installé.";
			?>
		</div>
	</p>
	<br/> <br/> <br/> <br/>
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<input type="hidden" name="step" value="6"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
<div class="setup-box-footer">
	<?php if ($detected) echo "<a class='checkout-button' onclick='document.getElementById(\"nextStep\").submit()'> Sixième étape : Import de votre historique </a>"; ?>
</div>