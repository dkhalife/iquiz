<html>
	<head>
		<style>
			label, input { display:block; }
			input.text { margin-bottom:12px; width:95%; padding: .4em; }
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

<div align="center" id="peffect">
	<input type="hidden" id="correctA">
	<input type="hidden" id="myans">
	<table width="60%" id="set1">
		<tr>
			<td width="15%">True</td>
			<td>
				<div id="stats-true" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td width="15%">False</td>
			<td>
				<div id="stats-false" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td width="15%" id="c1">Choice 1</td>
			<td>
				<div id="stats-c1" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td width="15%" id="c2">Choice 2</td>
			<td>
				<div id="stats-c2" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td width="15%" id="c3">Choice 3</td>
			<td>
				<div id="stats-c3" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td width="15%" id="c4">Choice 4</td>
			<td>
				<div id="stats-c4" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td width="15%" id="c5">Choice 5</td>
			<td>
				<div id="stats-c5" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
	</table>
	<table width="60%" id="set2">
		<tr>
			<td width="15%" id="s0"></td>
			<td>
				<div id="stats-0" style="background-color:red; width:0px;" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" align="center" float="left" id="true">&nbsp;</div>
			</td>
		</tr>
	</table>
</div>


		</div>
		<script>

function statsE(data){
	data=data.split("';&");
	for(j=0; j<data.length; j++){
		tmp=data[j].split("='");
		tmp[1]=tmp[1].replace("';","");
		switch(tmp[0]){
			case "type":
				if(tmp[1]=="2"){
					$("#peffect #set1").hide()
					$("#peffect #set2").show()
				}
				else{
					$("#peffect #set1").show()
					$("#peffect #set2").hide()
				}
			break;

			case "ans" :
				$("#correctA").val(tmp[1]);
			break;

			case "my" :
				$("#myans").val(tmp[1]);
			break;

			case "c1" :
				if(tmp[1]!=";"){
					$("#c1").html(tmp[1].split(";")[0]);
					$($("#stats-c1")[0].parentNode.parentNode).show();
					$("#stats-c1").attr("name",tmp[1].split(";")[1]);
					$('#stats-c1').animate(
						{
							width: "+="+tmp[1].split(";")[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("c1");
						}
					);
				}
				else{
					$($("#stats-c1")[0].parentNode.parentNode).hide();
				}
			break;

			case "c2" :
				if(tmp[1]!=";"){
					$("#c2").html(tmp[1].split(";")[0]);
					$($("#stats-c2")[0].parentNode.parentNode).show();
					$("#stats-c2").attr("name",tmp[1].split(";")[1]);
					$('#stats-c2').animate(
						{
							width: "+="+tmp[1].split(";")[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("c2");
						}
					);
				}
				else{
					$($("#stats-c2")[0].parentNode.parentNode).hide();
				}
			break;

			case "c3" :
				if(tmp[1]!=";"){
					$("#c3").html(tmp[1].split(";")[0]);
					$($("#stats-c3")[0].parentNode.parentNode).show();
					$("#stats-c3").attr("name",tmp[1].split(";")[1]);
					$('#stats-c3').animate(
						{
							width: "+="+tmp[1].split(";")[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("c3");
						}
					);
				}
				else{
					$($("#stats-c3")[0].parentNode.parentNode).hide();
				}
			break;

			case "c4" :
				if(tmp[1]!=";"){
					$("#c4").html(tmp[1].split(";")[0]);
					$($("#stats-c4")[0].parentNode.parentNode).show();
					$("#stats-c4").attr("name",tmp[1].split(";")[1]);
					$('#stats-c4').animate(
						{
							width: "+="+tmp[1].split(";")[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("c4");
						}
					);
				}
				else{
					$($("#stats-c4")[0].parentNode.parentNode).hide();
				}
			break;

			case "c5" :
				if(tmp[1]!=";"){
					$("#c5").html(tmp[1].split(";")[0]);
					$($("#stats-c5")[0].parentNode.parentNode).show();
					$("#stats-c5").attr("name",tmp[1].split(";")[1]);
					$('#stats-c5').animate(
						{
							width: "+="+tmp[1].split(";")[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("c5");
						}
					);
				}
				else{
					$($("#stats-c5")[0].parentNode.parentNode).hide();
				}
			break;

			case "true" :
				if(tmp[1]!=""){
					$($("#stats-true")[0].parentNode.parentNode).show();
					$("#stats-true").attr("name",tmp[1]);
					$('#stats-true').animate(
						{
							width: "+="+tmp[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("true");
						}
					);
				}
				else{
					$($("#stats-true")[0].parentNode.parentNode).hide();
				}
			break;

			case "false" :
				if(tmp[1]!=""){
					$($("#stats-false")[0].parentNode.parentNode).show();
					$("#stats-false").attr("name",tmp[1]);
					$('#stats-false').animate(
						{
							width: "+="+tmp[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA("false");
						}
					);
				}
				else{
					$($("#stats-false")[0].parentNode.parentNode).hide();
				}
			break;

			case "ua" :
				ua=tmp[1].split("['")[1].split("']")[0].split("'~'");
				for(k=0; k<ua.length; k++){
					if(k>0){
						// Make new row
						$("#set2 tr:eq(0)").clone().appendTo("#set2");
						// Update ids
						$("#set2 tr:last-child td:eq(0)").attr("id","s"+k);
						$("#set2 tr:last-child div").attr("id","stats-"+k);
					}
					tmp2=ua[k].split("','");
					$("#s"+k).html(tmp2[0]);
					$("#stats-"+k).attr("name",tmp2[1]);
					$('#stats-'+k).animate(
						{
							width: "+="+tmp2[1]+"%",
						},
						3000,
						'easeOutBounce',
						function() {
							$(this).html($(this).attr("name")+"%");
							checkA($(this).attr("id").match(/\d+/)[0]);
						}
					);
				}
			break;
		}
	}
}

function checkA(type){
	if(type==$("#correctA").val()){
		for(i=0; i<11; i++){
			window.setTimeout(function(){
				$("#stats-"+$("#correctA").val()).toggleClass("ui-state-active");
				if($("#myans").val()!=$("#correctA").val()){
					$("#stats-"+$("#myans").val()).toggleClass("ui-state-error");
				}
			},500+i*125);
		}
	}
}

function cleanE(){
	$("#peffect .ui-state-active").each(function(){
		$(this).removeClass("ui-state-active");
	});
	$("#peffect .ui-state-error").each(function(){
		$(this).removeClass("ui-state-error");
	});
	// Remove all elements except first in set 2
	$("#set2 tr").each(function(int){
		if(int>0){
			$(this).remove();
		}
	});
}

// T or F
//statsE("type='0';&ans='true';&my='false';&c1=';';&c2=';';&c3=';';&c4=';';&c5=';';&true='20';&false='80';");

// 3 Choices
//statsE("type='1';&ans='c1';&my='c1';&c1='Choix 1;30';&c2='Choix 2;50';&c3='Choix 3;20';&c4=';';&c5=';';&true='';&false='';");

// 5 Choices
//statsE("type='1';&ans='c1';&my='c1';&c1='Choix 1;30';&c2='Choix 2;50';&c3='Choix 3;3';&c4='Choix 4;5';&c5='Choix 5;12';&true='';&false='';");

// User answers
statsE("type='2';&ans='2';&my='2';&c1=';';&c2=';';&c3=';';&c4=';';&c5=';';&true='';&false='';&ua='['Q=2','20'~'Q=3','30'~'Q=3/2','50']';");

setTimeout(cleanE,5000);
		</script>
	</body>
</html>
