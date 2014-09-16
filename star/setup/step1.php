<div class="setup-box-content">
<div class="setup-box-content-container">
<form id="nextStep" action="setupStepBridge.php" method="POST">
	<p class='msg'>
		Vous pouvez choisir parmis les tags suivant ceux que vous souhaitez suivre :<br/><br/>
		<div class="checkbox">
		<table>
			<tr>
				<td>
					<input type="checkbox" name="KPI_Visites" class="checkbox" onclick="return false" onkeydown="return false" checked />
				</td>
				<td>
					&nbsp;Visites
				</td>
				<td>
					<a class="info">
						<img src="../img/questionmark.png"/>
						<span>
							Le tag visite étant le tag général, il est obligé d'être présent.
						</span>
					</a>
				</td> 
			</tr>
			<tr>
				<td>
					<input type='hidden' value='off' name='KPI_Leads'>
					<input type="checkbox" name="KPI_Leads" class="checkbox" <?php if (strstr($infoClient['kpis'], "Leads")) echo "checked"; else echo ""; ?>/>
				</td>
				<td>
					&nbsp;Leads
				</td>
				<td>
					<a class="info">
						<img src="../img/questionmark.png"/>
						<span>
							Vous devrez placer un tag correspondant aux Leads sur votre site, et ce tag sera reporté dans vos statistiques.
						</span>
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<input type='hidden' value='off' name='KPI_Conversions'>
					<input type="checkbox" name="KPI_Conversions" class="checkbox" <?php if (strstr($infoClient['kpis'], "Conversions")) echo "checked"; else echo ""; ?>/>
				</td>
				<td>
					&nbsp;Conversions
				</td>
				<td>
					<a class="info">
						<img src="../img/questionmark.png"/>
						<span>
							Vous devrez placer un tag correspondant aux Conversions sur votre site, et ce tag sera reporté dans vos statistiques.
						</span>
					</a>
				</td>
			</tr>
		</table>
		</div>
	</p>
	<br/> <br/> <br/> <br/>
	<input type="hidden" name="step" value="2"/>
	<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
</form>
</div>
</div>
<div class="setup-box-footer">
	<a class="checkout-button" onclick='document.getElementById("nextStep").submit();'> Seconde étape : Tags supplémentaires </a>
</div>