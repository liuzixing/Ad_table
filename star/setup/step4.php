<div class="setup-box-content">
<div class="setup-box-content-container">
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<p class='msg'>
			Vous pouvez désormais envoyer le PDF ci-dessous à votre DSI pour qu'il mette en place le plan de taggage.
			Cliquez ci-dessous pour le télécharger.<br/><br/>
			<img src="../img/greenarrow.png"><br/><br/>
			<!-- Créer le plan de taggage + update la date du plan de taggage en base -->
			<a href="createTagPlanTXT.php?token=<?php echo $token; ?>" class="btn">Plan de taggage <?php echo $infoClient['clientName']; ?>.txt </a>
		</p>
		<br/> <br/>
		<input type="hidden" name="step" value="5"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
</div>
<div class="setup-box-footer">
	<a class="checkout-button" onclick='document.getElementById("nextStep").submit()'> Cinquième étape : Import des campagnes et Détection automatique de vos tags </a>
</div>