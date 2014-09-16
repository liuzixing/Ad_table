<?
	require_once('/home/www/mymedia_fr/tyco/api/setup/setuplib.php');
	session_start();
	
	if (isset($_GET['token']))
		$token = $_GET['token'];
	if (isset($_POST['token']))
		$token = $_POST['token'];
	$username = $_SESSION[$token]['mymedia_username'];
	// On récupère les infos du client
	$infoClient = get_client_infos($username);
	// Popup demande si le client veut vraiment revenir en arrière
	if (isset($_POST['step']))
		$step = update_client_step($_POST['step'], $infoClient['clientName']);
	else
		$step = $infoClient['setupStep'];
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<script src='//code.jquery.com/jquery-1.11.0.min.js'></script>
	<script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js'></script>
	<link rel="stylesheet" href="../css/admin.css" type="text/css" />
	<script type="text/javascript">

		var step = <?php echo $step; ?> ;

		function setTimelineTo (step)
		{

			var timeline = document.getElementById("timeline"),
				dots = timeline.getElementsByTagName("li");

			// Check all previous steps dots
			for (var dot in _.range(step))
				dots[dot].className = "checked";

			// Highlight current step dot
			dots[step].className = "active";
		}

		// Update Timeline when DOM is ready
		$(document).ready(function ()
		{
			setTimelineTo (step);
		});

	</script>
</head>
<body>
	<div class="overlay">
		<div class="overlay-wrapper">
			<div class="setup-box">
				<div class="setup-box-header">
					<img class="logo" src="../img/leadsmonitor.png">
					<ul id="timeline">
					<?php
						for($i = 0; $i < 9; $i++)
						{
							echo "<li>";
							if ($step > $i)
								echo "<a onclick='gotoStep(".$i.")' class='epure'>".$i."</a>";
							else
								echo $i;
							echo "</li>";
						}
					?>
					</ul>
					<a class="infoTimeline">
						<img src="../img/questionmark.png"/>
						<span>
							Il est possible de revenir en arrière à tout moment en cliquant sur les bulles en haut à droite.
						</span>
					</a>
				</div>
				<?
					include ("step".$step.".php");
				?>
			</div>
		</div>
	</div>
	<div class="page-container"></div>
	<script language="javascript" type="text/javascript">
		function gotoStep(step)
		{
			if (confirm("Attention ! Si vous retournez a l'etape " + step + ", vous devrez repasser par les etapes suivantes pour terminer l'installation. Confirmez-vous votre choix?") == true)
			{
				var url = 'setup.php?token=<?php echo $token; ?>';
				var form = $('<form action="' + url + '" method="post">' +
				  '<input type="hidden" name="step" value="' + step + '"/>' +
				  '</form>');
				$(form).appendTo('body').submit();
			}
		}
	</script>
</body>
</html>