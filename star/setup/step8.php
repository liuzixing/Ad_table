<?php
	$tvtyClients = get_tvtyclient();
	$concurrents = get_concurrents($infoClient['clientName']);
?>
<div class="setup-box-content">
		<p class='msg'>
			Concurrence <br/><br/>
			<div class="checkbox">
				<select class="dropdown" id="concList" name="concList">
					<?php
						foreach ($tvtyClients as $client => $idtvty)
							echo "<option id='".$idtvty."' value='".$client."'>".utf8_encode($client)."</option>";
					?>
				</select>
				<?php
					echo '<a class="add-button" onclick="addConcurrent()"> Ajouter </a>';
				?>
			</div>
			<br/><br/>
			<div id="concurrents" class="concurrent">
				Votre liste de concurrents :
				<ul>
					<?php
						if (sizeof($concurrents) != 0)
							foreach ($concurrents as $concurrent)
								echo "<li>".$concurrent." <a class='delete-button' onclick='deleteConcurrent(\"".$concurrent."\")'> Supprimer </a></li>";
						else
							echo "Pas de concurrents.";
					?>
				</ul>
			</div>
		</p>
		<br/> <br/> <br/> <br/>
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<input type="hidden" name="step" value="9"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
<div class="setup-box-footer">
	<a class="checkout-button" onclick='document.getElementById("nextStep").submit()'> Terminer l'installation </a>
</div>
<script>
	function addConcurrent()
	{
		$("#concurrents").load("concurrents.php #concurrents", 
		{
			conc : $('#concList').val(),
			clientName : "<?php echo $infoClient['clientName']; ?>",
			action : "add"
		});
	}
	function deleteConcurrent(concurrent)
	{
		$("#concurrents").load("concurrents.php #concurrents",
		{
			conc : concurrent, 
			clientName : "<?php echo $infoClient['clientName']; ?>",
			action : "delete"
		});
	}
</script>