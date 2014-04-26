<html>
	<head>
		<style>
			label, input { display:block; }
			input.text { margin-bottom:12px; width:95%; padding: .4em; }
			fieldset { padding:0; border:0; margin-top:25px; }
			fieldset.q, #image img { -moz-border-radius: 11px; border-radius: 11px; }
			h1 { font-size: 1.2em; margin: .6em 0; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.validateTips { border: 1px solid transparent; padding: 0.3em; }
			#peffect .ui-state-active { font-weight : bold !important; }
			#peffect .ui-state-error { font-weight : bold !important; }
		</style>
		<link rel="stylesheet" href="css/start/jquery-ui-1.8.11.custom.css" type="text/css">
		<script src="js/jquery-1.5.1.min.js">
		</script>
		<script src="js/jquery-ui-1.8.11.custom.min.js">
		</script>
	</head>
	<body bgcolor="lightblue">
		<div align=center>
			<h1 class="ui-widget-header" style="width:60%" valign="center"><br>iQuiz<br></h1>
			<div align="center" id="loginer">
				<div class="ui-widget" style="width: 40%">
					<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						<strong>Error:</strong> You need to login in order to continue.</p>
					</div>
				</div>
			</div>
   			<div id="session-form" title="Room #">
				<span id="sound"></span>
				<div align=center id="waiting">
					<br><br><br><br><br><b>
					<span id="uwaitm">Waiting for session to start</span>
					</b><br><br>
					<img height='16' src='ajax-loader.gif'>
				</div>
				<div align="center" id="questionplace">
					<br>
					<fieldset class="q">
						<legend id="tracker">Question 1</legend>
						<div align="center">
							<span class="validateTips2"></span>
							<span style="float: right; padding: 0px 10px 0px 0px; position: absolute; right: 20px;"><b><font size="2px" id="timer">0:20</font></b></span>
						</div>
						<div align="center">
							<h2 name="tf">True or False</h2>
							<h2 name="mc">Multiple Choice</h2>
							<h2 name="sp">Specific Value</h2>
						</div>
						<div>
							<table style="width:100%">
								<tr>
									<td>
										<p align="left" id="question"></p>
									</td>
									<td id="image">
										<img width="250" hspace="0" height="183" border="0" align="right" src="">
									</td>
								</tr>
							</table>
							</p>
							<table style="width:100%">
								<tr>
									<td align="center">
										<p><b><u>Your Answer</u></b></p>
									</td>
									<td align="center">
										<div name="tf">
											<input type="radio" value="true" id="tf1" name="tf" /><label for="tf1">False</label>
											<input type="radio" value="false" id="tf2" name="tf" /><label for="tf2">True</label>
										</div>
										<div name="mc">
											<input type="radio" value="0" id="mc1" name="mc" /><label for="mc1"></label>
											<input type="radio" value="1" id="mc2" name="mc" /><label for="mc2"></label>
											<input type="radio" value="2" id="mc3" name="mc" /><label for="mc3"></label>
											<input type="radio" value="3" id="mc4" name="mc" /><label for="mc4"></label>
											<input type="radio" value="4" id="mc5" name="mc" /><label for="mc5"></label>
										</div>
										<div name="sp">
											<input type="text" style="width:100%" id="answer">
										</div>
										<span id="sandbox" style="display:none"></span>
									</td>
								</tr>
							</table><br>
							<div align="center">
								<input id="submita" value="Answer">
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div id="dialog-form" title="Join a session">
				<span class="validateTips">All form fields are required.</span><br>
				<form id="loginform">
					<fieldset>
						<label for="room">Room</label>
						<input type="text" name="room" id="room" class="text ui-widget-content ui-corner-all">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
						<label for="user">Username</label>
						<input type="text" name="user" id="user" value="" class="text ui-widget-content ui-corner-all">
					</fieldset>
				</form>
				<input type="hidden" id="history" value="0">
			</div>
		</div>
		<script src="js.php?mode=user">
		</script>
	</body>
</html>
