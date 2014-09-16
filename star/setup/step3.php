<div class="setup-box-content">
<div class="setup-box-content-container">
	<form id="nextStep" action="setupStepBridge.php" method="POST">
		<p class='msg'>
			Choix techniques :
			<div class="checkbox">
			<table>
				<tr>
					<td>
						<input type="radio" name="typeTag" value="Cookie" checked />
						&nbsp; Cookie
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Un plan de taggage type "Cookie" comporte des tags contenant du JavaScript comme le montre l'exemple.
							</span>
						</a>
					</td> 
				</tr>
				<tr>
					<td>
						Exemple : <br/>
						<pre>
							&lt;script type="text/javascript"&gt;
								window.reeperfAsyncInit = function ()
								  {
									try
									{
										var url=(("https:" == document.location.protocol) ? "https" : "http") + "://tracker.reeperf.com/";
										var reeperf = Reeperf.getTracker(url+"reeperf.php", 21);
										reeperf.trackPageView();
										reeperf.enableLinkTracking(true);
									}catch(err) {}
								  };
							&lt;/script&gt;
							&lt;script type="text/javascript" src="http://tracker.reeperf.com/trackreeperf.js">&lt;/script&gt;
							&lt;noscript>&lt;img src="http://tracker.reeperf.com/reeperf.php?idsite=21&rec=1" style="border:0;" alt="" /&gt;&lt;/noscript&gt;
						</pre>
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" name="typeTag" value="Pixel" />
						&nbsp; Pixel
						<a class="info">
							<img src="../img/questionmark.png"/>
							<span>
								Un plan de taggage type "Pixel" contient des tags type "image".
							</span>
						</a>
					</td> 
				</tr>
				<tr>
					<td>
						Exemple : <br/>
						<pre>
							&lt;img src="http://tracker.reeperf.com/reeperf.php?idsite=7&rec=1" style="border:0;" alt="" /&gt;');
						</pre>
					</td>
				</tr>
			</table>
			</div>
		</p>
		<br/> <br/> <br/> <br/>
		<input type="hidden" name="step" value="4"/>
		<input type="hidden" id="token" name="token" value="<?php echo $token; ?>"/>
	</form>
</div>
</div>
<div class="setup-box-footer">
	<a class="checkout-button" onclick='document.getElementById("nextStep").submit()'> Quatrième étape : Plan de taggage à installer </a>
</div>