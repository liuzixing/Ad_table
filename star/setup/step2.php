<?php
	$kpiLimit = get_kpi_limit($infoClient['clientName']);
	$jsKpiCount = 0;
	if (strstr($infoClient['kpis'], "Visites"))
		$jsKpiCount++;
	if (strstr($infoClient['kpis'], "Leads"))
		$jsKpiCount++;
	if (strstr($infoClient['kpis'], "Conversions"))
		$jsKpiCount++;
?>
<div class="setup-box-content">
<div class="setup-box-content-container">
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<p class='msg'>
			Vous pouvez rajouter des tags selon votre niveau de service (<?php echo $infoClient['serviceLevel'] ?>) :<br/>
			Vous avez le droit à <?php echo $kpiLimit; ?> tags en tout, il vous reste <?php echo $kpiLimit - $jsKpiCount; ?> tag(s) maximum à choisir. <br/>
			<div class="checkbox">
			<table>
				<tr>	
					<td>
						<input type='hidden' value='off' name='KPI_Devices'>
						<input type="checkbox" name="KPI_Devices" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Devices")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Type de device
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Pourcentages des visites Ordinateur/Mobile/Tablette
							</span>
						</a>
					</td> 
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Newvisitors'>
						<input type="checkbox" name="KPI_Newvisitors" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Newvisitors")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Nouveaux visiteurs immédiats (%)
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Il s'agit du pourcentage de nouveaux visiteurs après un spot TV.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Rebonds'>
						<input type="checkbox" name="KPI_Rebonds" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Rebonds")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Rebond immédiat
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Il s'agit du pourcentage de rebond des visiteurs après un spot TV.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Debutinscriptions'>
						<input type="checkbox" name="KPI_Debutinscriptions" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Debutinscriptions")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Début d'inscription
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Signalement du début d'inscription d'un visiteur.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Fininscriptions'>
						<input type="checkbox" name="KPI_Fininscriptions" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Fininscriptions")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Fin d'inscription
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Signalement de la fin d'inscription d'un visiteur.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Contacts'>
						<input type="checkbox" name="KPI_Contacts" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Contacts")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Contact
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Tracking des contacts sur le site.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Pagespecifique'>
						<input type="checkbox" name="KPI_Pagespecifique" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Pagespecifique")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Page spécifique
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Tracking d'une page spécifique du site.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Commandes'>
						<input type="checkbox" name="KPI_Commandes" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Pagespecifique")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Commande
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Tracking des commandes passées sur le site.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Perso'>
						<input type="checkbox" name="KPI_Perso" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Perso")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 2) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; KPI personnalisé
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Pour ce KPI personnalisé, il vous sera demandé d'importer vos propres données pour chaque jour.
							</span>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type='hidden' value='off' name='KPI_Miseaupanier'>
						<input type="checkbox" name="KPI_Miseaupanier" class="checkbox"
						<?php if (strstr($infoClient['kpis'], "Perso")) echo "checked"; else echo ""; ?>
						<?php if ($infoClient['nbServiceLevel'] < 3) echo "disabled"; else echo ""; ?>/>
					</td>
					<td>
						&nbsp; Mise au panier
					</td>
					<td>
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Chaque visite ayant comporté une ou plusieurs mises au panier quelconque sera comptée comme une visite ayant converti ce KPI.
							</span>
						</a>
					</td>
				</tr>
			</table>
			</div>
		</p>
		<br/> <br/> <br/> <br/>
		<input type="hidden" name="step" value="3"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
</div>
<div class="setup-box-footer">
	<a class="checkout-button" onclick='document.getElementById("nextStep").submit()'> Troisième étape : Choix techniques </a>
</div>
<script type="text/javascript">
checkboxlimit(document.forms.nextStep, <?php echo $kpiLimit - $jsKpiCount; ?>);
function checkboxlimit(checkgroup, limit)
{
	var checkgroup=checkgroup
	var limit=limit
	for (var i=0; i<checkgroup.length; i++)
	{
		checkgroup[i].onclick=function()
		{
			var checkedcount=0
			for (var i=0; i<checkgroup.length; i++)
				checkedcount+=(checkgroup[i].checked)? 1 : 0
			if (checkedcount>limit)
			{
				alert("Vous ne pouvez sélectionner qu'un maximum de "+limit+" tags.")
				this.checked=false
			}
		}
	}
}

</script>