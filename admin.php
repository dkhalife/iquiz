<html>
	<head>
		<style>
			label, input { display:block; }
			input.text { margin-bottom:12px; width:95%; padding: .4em; }
			fieldset { padding:0; border:0; margin-top:25px; }
			h1 { font-size: 1.2em; margin: .6em 0; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.validateTips, .usersLookupTips { border: 1px solid transparent; padding: 0.3em; }
		</style>
		<link rel="stylesheet" href="css/start/jquery-ui-1.8.11.custom.css" type="text/css">
		<script src="js/jquery-1.5.1.min.js">
		</script>
		<script src="js/jquery-ui-1.8.11.custom.min.js">
		</script>
		<script src="js/jquery.tablesorter.min.js">
		</script>
	</head>
	<body bgcolor="lightblue">
		<div align=center>
			<h1 class="ui-widget-header" style="width:60%" valign="center"><br>iQuiz - Admin View<br></h1>
			<div id="logerror" style="width: 40%">
				<br>
				<div class="ui-corner-all ui-state-error" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
					<strong>Alert:</strong> An error occured, please try again later.</p>
				</div>
			</div>
			<div id="session-form1" title="Waiting for users to join (0 so far)<br>&nbsp;&nbsp;&nbsp;<img height='10' src='ajax-loader.gif'>">
				<div class="ui-widget">
					<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						<strong>When you want to start the session click Start.</p>
					</div>
				</div>
				<ul id="userlist" class="ui-widget ui-helper-clearfix">
				
				</ul>
			</div>
			
			<div id="session-form2" title="Room">
				<div class="ui-widget" id="set1">
					<div id="tabs">
						<ul>
							<li><a href="#tabs-1">Ask a Question</a></li>
							<li><a href="#tabs-2">Stats</a></li>
						</ul>
						<div id="tabs-1">
							<h2 align="center" id="tracker">Question 1</h2>
							<div align="center"><span class="validateTips2"></span></div><br>
							<h2>Select a question type:</h2>
							<div id="type">
								<input type="radio" value="0" id="radio1" onclick="ChooseType(0)" name="type" /><label for="radio1">True or False</label>
								<input type="radio" value="1" id="radio2" onclick="ChooseType(1)" name="type" /><label for="radio2">Multiple Choice</label>
								<input type="radio" value="2" id="radio3" onclick="ChooseType(2)" name="type" /><label for="radio3">Specific Value</label>
							</div>
							<div class="qtype">
								<h2>True or False</h2>
								Question :<br>
								<textarea rows="3" type="text" style="width:100%" name="question0"></textarea>
								Answer : <br>
								<div id="tf">
									<input type="radio" value="true" id="tf1" name="tf" /><label for="tf1">False</label>
									<input type="radio" value="false" id="tf2" name="tf" /><label for="tf2">True</label>
								</div>
							</div>
							<div class="qtype">
								<h2>Multiple Choice</h2>
								Question :<br>
								<textarea rows="3" type="text" style="width:100%" name="question1"></textarea>
								Answers : <br>
								<div id="mc">
									<input type="radio" value="0" id="mc1" name="mc" /><label for="mc1"><input size="5" type="text" id="ansq1" /></label>
									<input type="radio" value="1" id="mc2" name="mc" /><label for="mc2"><input size="5" type="text" id="ansq2" /></label>
									<input type="radio" value="2" id="mc3" name="mc" /><label for="mc3"><input size="5" type="text" id="ansq3" /></label>
									<input type="radio" value="3" id="mc4" name="mc" /><label for="mc4"><input size="5" type="text" id="ansq4" /></label>
									<input type="radio" value="4" id="mc5" name="mc" /><label for="mc5"><input size="5" type="text" id="ansq5" /></label>
								</div>
							</div>
							<div class="qtype">
								<h2>Specific Value</h2>
								Question :<br>
								<textarea rows="3" type="text" style="width:100%" name="question2"></textarea>
								Answer : <br>
								<input type="text" style="width:100%" id="answer">
							</div>
							<br>
							<h2>Additional Image</h2>
							File : <br>
							<input type="file" id="image" name="image">
							<br id="breakmark">
							<table>
								<tr>
									<td colspan="4"><h2>Time Limit</h2></td>
								</tr>
								<tr>
									<td>Min :</td>
									<td><input type="text" id="min" size="2" maxlength="2"></td>
									<td>Sec :</td>
									<td><input type="text" id="sec" size="2" maxlength="2"></td>
								</tr>
							</table>
						</div>
						<div id="tabs-2" align="center">
							<table class="ui-widget ui-widget-content" id="stats" style="width:85%" class="tablesorter">
								<thead>
									<tr class="ui-widget-header ">
										<th>Rank</th>
										<th>Name</th>
										<th>Correct Answers</th>
										<th>Wrong Answers</th>
										<th>Unanswered</th>
										<th>Percentage Correct</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td align="center">1</td>
										<td align="center">Student</td>
										<td align="center">2</td>
										<td align="center">2</td>
										<td align="center">0</td>
										<td align="center">50%</td>
									</tr>
									<tr>
										<td align="center">2</td>
										<td align="center">Student2</td>
										<td align="center">2</td>
										<td align="center">0</td>
										<td align="center">80%</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div id="questionsubmitted" align="center">
						<br><br><br><br><br><br><br><br>
						<h2>Waiting...</h2><br><br>
						<img src='ajax-loader.gif'>
						<br><br>
						<span><b><font size="2px" id="timer">0:20</font></b></span>
						<br><br><br><br><br><br><br><br>
					</div>
				</div>
				<div id="set2" align="center" class="ui-widget">
					<br><br><br><br><br><br><br><br>
					<h2>Waiting...</h2><br><br>
					<img src='ajax-loader.gif'>
					<br><br><br><br><br><br><br><br>
				</div>
			</div>
			
			<div id="dialog-form" title="Create a session">
				<span class="validateTips">All form fields are required.</span><br>
				<form id="createform">
					<fieldset>
						<label for="room">Room</label>
						<input type="text" name="room" id="room" class="text ui-widget-content ui-corner-all">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
						<label for="user">Username</label>
						<input type="text" name="user" id="user" value="" class="text ui-widget-content ui-corner-all">
					</fieldset>
				</form>
				<form enctype="multipart/form-data" method="POST" action="ask.php" target="askquestionresult" id="asksub">
				</form>
			</div>
		</div>
		<script src="js.php?mode=admin">
		</script>
		<iframe id="askquestionresult" name="askquestionresult" style="display:none" />
	</body>
</html>
