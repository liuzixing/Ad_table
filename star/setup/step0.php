<div class="setup-box-content">
<div class="setup-box-content-container">
	<p class='intro'>
		Vous allez être guidé dans l’installation de votre LeadsMonitor. <br/>
		Sachez que vous pourrez toujours modifier ces paramètres par la suite. <br/>
		La première étape de l'installation prendra environ 10 minutes.
	</p>
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<input type="hidden" id="step" name="step" value="1"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
</div>
<div class="setup-box-footer">
	<a class="checkout-button" onclick='document.getElementById("nextStep").submit()'> Première étape : Choix des tags </a>
</div>