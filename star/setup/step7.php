<?php
	$dayseline_infos = get_dayseline_infos($infoClient['clientName']);
	$error = 0;
?>
<div class="setup-box-content">
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<p class='msg'>
			Résultats de la comparaison :<br/>
			<p class='info'>Si vous venez de faire une modification sur votre plan de taggage,
			il vous faudra revenir dans deux jours pour que vous puissiez recetter une journée complète propre.</p><br/>
			<div class="center">
				<table class="center">
				<tr><th colspan="4"> <?php echo $dayseline_infos['date']; ?> </th></tr>
					<tr>
						<th>
							KPIs
						</th>
						<th>
							LeadsMonitor
						</th>
						<th>
							<?php echo $infoClient['clientName']; ?>
						</th>
						<th>
							Comparaison
						</th>
					</tr>
					<?php
						$kpiArray = explode("|", $infoClient['kpis']);
						foreach ($kpiArray as $i => $kpi)
						{
							if (recette_valide($dayseline_infos["count".($i + 1)], $dayseline_infos["count".($i + 1)."_client"]))
								$comparaison = "<img src='../img/OK_icon.png'>";
							else
							{
								$comparaison = "<img src='../img/invalid-icon.png'>";
								if ($kpi == "Visites")
								{
									$error = 1;
								}
								else
								{
									if ($error != 1)
										$error = 2;
								}
							}
							echo "<tr>
								<td class='comparaison'>
									".$kpi."
								</td>
								<td class='comparaison'>
									".$dayseline_infos["count".($i + 1)]."
								</td>
								<td class='comparaison'>
									".$dayseline_infos["count".($i + 1)."_client"]."
								</td>
								<td class='comparaison'>
									".$comparaison."
								</td>
							</tr>";
						}
					?>
				</table>
			</div>
		</p>
		<br/> <br/> <br/> <br/>
		<input type="hidden" name="error" value="<?php echo $error; ?>"/>
		<input type="hidden" name="step" value="8"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
<div class="setup-box-footer">
	<?php if ($error != 1) echo '<a class="checkout-button" onclick="continueToConcurrent('.$error.')"> Dernière étape : Concurrence </a>'; ?>
</div>
<script language="javascript" type="text/javascript">
	function continueToConcurrent(error)
	{
		if (error != 0)
		{
			if (confirm("Attention ! Si vous passez cette étape, vous risque de vous retrouver avec des chiffres incorrects concernant les valeurs non validées. Confirmez-vous votre choix?") == true)
			{
				document.getElementById("nextStep").submit();
			}
		}
		else
			document.getElementById("nextStep").submit();
	}
</script>