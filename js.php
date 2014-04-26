<?php
if($_GET["mode"]=="admin"){
?>
	var user = $("#user"),
	room = $("#room"),
	password = $("#password"),
	tips = $(".validateTips");
	tips2 = $(".validateTips2");

	function resetC(){
		// Remove classes
		$(".ui-state-error").each(function(){
			$(this).removeClass("ui-state-error");
		});
	}

	function updateTips(t,t2){
		tmp=typeof t2=="undefined"?tips:tips2;
		tmp.text(t).addClass("ui-state-highlight");
		setTimeout(function(){
			tmp.removeClass("ui-state-highlight", 1500);
		},500);
	}

	function checkLength(o, n, min, max){
		if(o.val().length>max || o.val().length<min){
			o.addClass("ui-state-error");
			updateTips("Length of "+n+" must be between "+min +" and "+max+".");
			return false;
		} else {
			return true;
		}
	}

	function resetC(){
		// Remove classes
		$(".ui-state-error").each(function(){
			$(this).removeClass("ui-state-error");
		});
		$("span[class^='validateTips']").each(function(){
			$(this).html("");
		});
	}

	function usersLookup(){
		if($("#session-form1").dialog("isOpen")){
			$.ajax({
				type : "POST",
				url : "waiting.php",
				data : $("#createform").serialize(),
				success : function(data){
					html="";
					if(data!=""){
						data=data.split(";");
						for(i=0; i<data.length; i++){
							html+="<li class='ui-state-default ui-corner-all' style='width:30%'><img src='user.png' height='32px' width='32px'>&nbsp;&nbsp;"+data[i]+"</li>";
						}
					}
					$("#ui-dialog-title-session-form1").html("Waiting for users to join ("+data.length+" so far)<br>&nbsp;&nbsp;&nbsp;<img height='10' src='ajax-loader.gif'>");
					$("#userlist").html(html);
				}
			});
			window.setTimeout(usersLookup,3000);
		}
	}

	function updateStats(){
		$("#stats").tablesorter();
		// set sorting column and direction, this will sort on the first and third column the column index starts at zero
		var sorting = [[5,1]];
		// sort on the first column
		$("#stats").trigger("sorton",[sorting]);
		$("#stats > tbody > tr > td:first-child").each(function(it){
			$(this).html(it+1);
		});
	}

	function ChooseType(ind){
		$(".qtype").each(function(dni){
			$(this).hide();
			if(dni==ind){
				$(this).fadeIn("slow");
			}
		});
	}

	function validateFile(file){
		if (file.indexOf('/')>-1){
			file = file.substring(file.lastIndexOf('/') + 1);
		}
		else if (file.indexOf('\\') > -1){
			file = file.substring(file.lastIndexOf('\\') + 1);
		}
		ext=file.match(/\.(\w+)/);
		allowed=["jpg","jpeg","gif","png"];
		if(ext!=null && allowed.indexOf(ext[1])>-1){
			return true;
		}
		else {
			$("#image").val("");
			return false;
		}
	}

	function processQ(){
		resetC();
		type=$("input[name='type']:checked");
		if(typeof type[0]=="undefined"){
			return updateTips("Please select a question type.",true);
		}
		type=type[0].value;

		question=$("textarea[name='question"+type+"']").val();
		if(question.length<1){
			$("textarea[name='question"+type+"']").addClass("ui-state-error");
			return updateTips("Please fill in your answer.",true);
		}
		image=$("#image");
		if(image.val().length>0 && !validateFile(image.val())){
			image.addClass("ui-state-error");
			return updateTips("Extensions allowed are only jpg, jpeg , gif and png.",true);
		}

		auth=$("#createform").serialize();
		nbr=$("#tracker")[0].innerHTML.match(/\d+/)[0];
		time=$("#min").val()*60+$("#sec").val()*1;
		mc="";
		// Data
		data=auth+"&nbr="+nbr+"&question="+question+"&type="+type+"&time="+time;
		switch(type){
			case "0":
				ans=$("input[name='tf']:checked").val();
				if(typeof ans=="undefined"){
					return updateTips("Please select the correct answer.",true);
				}
			break;

			case "1":
				if($("#ansq1").val()==""){
					$("#ansq1").addClass("ui-state-error");
					return updateTips("Please specify at least a first choice.",true);
				}
				mc+="&q1="+$("#ansq1").val();
				if($("#ansq2").val()==""){
					$("#ansq2").addClass("ui-state-error");
					return updateTips("Please specify at least a second choice.",true);
				}
				mc+="&q2="+$("#ansq2").val();
				if($("#ansq3").val()==""){
					$("#ansq3").addClass("ui-state-error");
					return updateTips("Please specify at least a third choice.",true);
				}
				mc+="&q3="+$("#ansq3").val();
				mc+="&q4="+$("#ansq4").val();
				mc+="&q5="+$("#ansq5").val();
				ans=$("input[name='mc']:checked").val();
				if(typeof ans=="undefined"){
					return updateTips("Please select the correct answer.",true);
				}
			break;

			case "2":
				ans=$("#answer").val();
				if(ans==""){
					$("#answer").addClass("ui-state-error");
					return updateTips("Please enter a correct answer.",true);
				}
			break;
		}
		data+=mc+"&ans="+ans+"&add_image="+(image.val().length>0);
		// Clean form
		$("#asksub").html("");
		if(image.val().length>0){
			$("#asksub").append(image);
		}
		// Replicate contents in that form
		replicateF(data);
		$("#askquestionresult").bind("load",submitQ);
		$("#asksub").submit();
		if(image.val().length>0){
			$("#breakmark").before($("#image"));
		}
	}

	function submitQ(){
		$("#askquestionresult").unbind("load",submitQ);
		data=$("#askquestionresult").contents().text();
		if(data=="success"){
			$("#tabs").hide();
			$("#session-form2").dialog("disable");
			$("#questionsubmitted").fadeIn();
			total=$("#min").val()*60+$("#sec").val()*1;
			if(total>0){
				min=Math.floor(total/60);
				sec=total-60*min;
				if(sec<10){
					sec="0"+sec;
				}
				$("#timer").html(min+":"+sec);
				timeit();
			}
			// Clear all values in ask form
			ChooseType(0);
			$("#type:eq(0)").attr("checked",true);
			$(".validateTips2").html("");
			$("textarea[name^='question']").each(function(){
				$(this).val("");
			});
			$("#image").val("");
			$("#answer").val("");
			$("#min").val("");
			$("#sec").val("");
			$("input[id^='ansq']").each(function(){
				$(this).val("");
			});
			waitResponse();
		}
		else{
			alert(data);
		}
	}

	function questionEnded(){
		$("#tabs").show();
		$("#session-form2").dialog("enable");
		$("#questionsubmitted").hide();
	}

	function waitResponse(){
		if($("#session-form2").dialog("isOpen")){
			$.ajax({
				type : "POST",
				url : "waiting.php",
				data : $("#createform").serialize()+"&mode=q&question="+$("#tracker")[0].innerHTML.match(/\d+/)[0],
				success : function(data){
					// If they all responded take action





				}
			});
			window.setTimeout(waitResponse,3000);
		}
	}

	function replicateF(dat){
		dat=dat.split("&");
		tmp=document.createElement("input");
		tmp.setAttribute("type","hidden");
		for(i=0; i<dat.length; i++){
			dat[i]=dat[i].split("=");
			tmp_=$(tmp).clone().attr("name",dat[i][0]).attr("value",dat[i][1]);
			$("#asksub")[0].appendChild(tmp_[0]);
		}
	}

	function timeit(){
		if($("#tabs").css("display")=="none"){
			[min,sec]=$("#timer").text().split(":");
			min=min-0;
			sec=sec-0;
			total=min*60+sec;
			total--;
			min=Math.floor(total/60);
			sec=total-60*min;
			if(sec<10){
				sec="0"+sec;
			}
			$("#timer").html(min+":"+sec);
			if(total<=10){
				if(total%2==0){
					$("#timer").stop().attr("size",8-total/2);
				}
				$("#timer").stop().css("color", "red").animate({ color: "black"}, 750);

			}
			if(total>0){
				setTimeout(timeit,1000);
			}
			else{
				$("#timer").stop().attr("size","2");
				questionEnded();
			}
		}
		else{
			// Hide Timer
			$("#timer").hide();
			$("#timer").css("color","");
		}
	}

	function createFSubmit(){
		var bValid = true;
		resetC();
		bValid = bValid && checkLength(room, "room", 4, 8);
		bValid = bValid && checkLength(password, "password", 6, 32);
		bValid = bValid && checkLength(user, "user", 4, 12);
		if(bValid){
			$.ajax({
				type : "POST",
				url : "create.php",
				data : $("#createform").serialize(),
				success : function(data){
					if(data.length!=0){
						data=data.split(";");
						if(data[0]=="room"){
							room.addClass("ui-state-error");
						}
						updateTips(data[1]);
						return;
					}

					$("#dialog-form").dialog("close");
					window.setTimeout(function(){
						$("#ui-dialog-title-session-form2").html("Room #"+room[0].value);
						$("#session-form1").dialog("open");
						usersLookup();
					},500);
				},
				error : function(){
					$("#logerror").find("div").addClass("ui-state-error");
					$("#logerror").show();
				}
			});
		}
	}

	$(document).ready(function(){
		$("#dialog-form").dialog({
			autoOpen: false,
			height: 320,
			width: 350,
			modal: true,
			show: "blind",
			hide: "explode",
			buttons: {
				Create : function() {
					createFSubmit();
				},
			}
		});

		$("#session-form1").dialog({
			autoOpen: false,
			height: 300,
			width: 500,
			show: "blind",
			hide: "explode",
			buttons: {
				Start : function() {
					$.ajax({
						type : "POST",
						url : "lock.php",
						data : $("#createform").serialize(),
						success : function(){
							$("#session-form1").dialog("close");
							window.setTimeout(function(){
								$("#session-form2").dialog("open");
							},500);
						}
					});
				},
			}
		});

		$("#set2").hide();
		$("#logerror").hide();
		$("#mc").buttonset();
		$("#tf").buttonset();
		$("#submitq").button();
		$("#type").buttonset();
		$("#tabs").tabs();
		$("#timer").hide();
		ChooseType(0);
		$("#type:eq(0)").attr("checked",true);
		$("#session-form2").dialog({
			autoOpen: false,
			height: 500,
			width: 800,
			show: "blind",
			hide: "explode",
			buttons: {
				"Send" : function(){
					processQ();
				},
				"End Session" : function() {
					$.ajax({
						type : "POST",
						url : "end.php",
						data : $("#createform").serialize(),
						success : function(){
							// Close everything and make clients disconnect
							$("#session-form2").dialog("close");
						}
					});
				},
			}
		});

		// Add Enter Event Listener
		$("#createform input").each(function(i){
			$(this).keypress(function(event){
				if (event.which == '13') {
					tmp=$(this).next();
					while(typeof tmp[0]!="undefined"){
						if(tmp[0].nodeName.toLowerCase()=="input"){
							break;
						}
						tmp=tmp.next();
					}
					if(typeof tmp[0]!="undefined"){
						tmp[0].focus();
					}
					else{
						createFSubmit();
					}
					event.preventDefault();
				}
			});
		});

		window.setTimeout(function(){
			$("#dialog-form").dialog("open");
			window.setTimeout(function(){
				$("#createform input")[0].focus();
			},1000);
		},250);
	});
<?
}
if($_GET["mode"]=="user"){
?>
	var user = $("#user"),
	room = $("#room"),
	password = $("#password"),
	allFields = $([]).add(user).add(room).add(password),
	tips = $(".validateTips");
	$(document).ready(function(){
		$("#questionplace").hide();
		$("div[name='mc']").buttonset();
		$("div[name='tf']").buttonset();
		$("#submita").button();
		$("#dialog-form").dialog({
			autoOpen: false,
			height: 320,
			width: 350,
			modal: true,
			show: "blind",
			hide: "explode",
			buttons: {
				Login : function() {
					loginFSubmit();
				},
			}
		});
		$("#session-form").dialog({
			autoOpen: false,
			height: 500,
			width: 800,
			show: "blind",
			hide: "explode",
			buttons: {
				Close : function() {
					$.ajax({
						type : "POST",
						url : "end.php?mode=user",
						data : $("#loginform").serialize(),
						success : function(){
							// Close everything and remove me from server
							$("#session-form").dialog("close");
						}
					});
				},
			}
		});

		// Add Enter Event Listener
		$("#loginform input").each(function(i){
			$(this).keypress(function(event){
				if (event.which == '13') {
					tmp=$(this).next();
					while(typeof tmp[0]!="undefined"){
						if(tmp[0].nodeName.toLowerCase()=="input"){
							break;
						}
						tmp=tmp.next();
					}
					if(typeof tmp[0]!="undefined"){
						tmp[0].focus();
					}
					else{
						loginFSubmit();
					}
					event.preventDefault();
				}
			});
		});

		window.setTimeout(function(){
			$("#dialog-form").dialog("open");
			window.setTimeout(function(){
				$("#loginform > fieldset > input")[0].focus();
			},1000);
		},250);
	});

	function loginFSubmit(){
		var bValid = true;
		allFields.removeClass("ui-state-error");

		bValid = bValid && checkLength(room, "room", 4, 8);
		bValid = bValid && checkLength(password, "password", 6, 32);
		bValid = bValid && checkLength(user, "user", 4, 12);

		if(bValid){
			bValid = $("#user").val().match(";")==null;
			if(bValid){
				$.ajax({
					type : "POST",
					url : "login.php",
					data : $("#loginform").serialize(),
					success : function(data){
						if(data.length!=0){
							data=data.split(";");
							$("#"+data[0]).addClass("ui-state-error");
							updateTips(data[1]);
							return;
						}

						$("#dialog-form").dialog("close");
						$("#loginer").hide();
						window.setTimeout(function(){
							$("#ui-dialog-title-session-form").html("Room #"+room[0].value);
							$("#session-form").dialog("open");
							sessionWStart();
						},500);
					},
				});
			}
			else{
				$("#user").addClass("ui-state-error");
				updateTips("Username contains certain restricted caracters.");
			}
		}
	}

	function updateTips(t,t2){
		tmp=typeof t2=="undefined"?tips:t2;
		tmp.text(t).addClass("ui-state-highlight");
		setTimeout(function(){
			tmp.removeClass("ui-state-highlight", 1500);
		},500);
	}

	function checkLength(o, n, min, max){
		if(o.val().length>max || o.val().length<min){
			o.addClass("ui-state-error");
			updateTips("Length of "+n+" must be between "+min +" and "+max+".");
			return false;
		} else {
			return true;
		}
	}

	function sessionWStart(){
		if($("#session-form").dialog("isOpen")){
			flag=true;
			$.ajax({
				type : "POST",
				url : "waiting.php?mode=uwait",
				data : $("#loginform").serialize(),
				success : function(data){false
					if(data=="true"){
						// Session started
						flag=false;
						$("#uwaitm").html("Session started. Waiting for a question.");
						sessionQwait();
					}
				}
			});
			if(flag){
				window.setTimeout(sessionWStart,3000);
			}
		}
	}

	function sessionQwait(){
		if($("#session-form").dialog("isOpen")){
			flag=true;
			$.ajax({
				type : "POST",
				url : "waiting.php?mode=qwait",
				data : $("#loginform").serialize()+"&nbr="+$("#tracker")[0].innerHTML.match(/\d+/)[0],
				success : function(data){
					if(data=="exit"){
						flag=false;
						$("#uwaitm").html("Session closed by admin. Exiting...");
						window.setTimeout(function(){
							$("#session-form").dialog("close");
						},750);
					}
					if(data.indexOf("question")==0){
						// We are receiving a question, process it once
						applyQ(data);
					}
					else{
						$("#session-form").dialog("enable");
						// Clean answer
						$("#answer").val("");
					}
				}
			});
			if(flag){
				window.setTimeout(sessionQwait,3000);
			}
		}
	}

	function type(t){
		$("#mc1").attr("checked",true).button("refresh");
		$("#tf1").attr("checked",true).button("refresh");
		if(t!=0){
			$("[name='tf']").each(function(){ $(this).hide(); });
		}
		if(t!=1){
			$("[name='mc']").each(function(){ $(this).hide(); });
		}
		if(t!=2){
			$("[name='sp']").each(function(){ $(this).hide(); });
		}
	}

	function applyQ(data){
		data=data.split("';&");
		$("div[name='mc']").buttonset("destroy");
		for(i=0; i<data.length; i++){
			tmp=data[i].split("='");
			tmp[1]=tmp[1].replace("';","");
			switch(tmp[0]){
				case "nbr":
					if(tmp[1]<=$("#history").val()){
						// Alraedy processed
						return;
					}
					$("#history").val(tmp[1]);
					$("#waiting").hide();
					$("#questionplace").fadeIn("slow");
				break;

				case "question":
					$("#question").html(tmp[1]);
				break;

				case "type":
					type(tmp[1]);
				break;

				case "q1":
					$("label[for='mc1']").html(tmp[1]);
				break;

				case "q2":
					$("label[for='mc2']").html(tmp[1]);
				break;

				case "q3":
					$("label[for='mc3']").html(tmp[1]);
				break;

				case "q4":
					if(tmp[1]!=""){
						$("#mc4").appendTo("div[name='mc']");
						$("label[for='mc4']").appendTo("div[name='mc']");
						$("label[for='mc4']").html(tmp[1]);
					}
					else{
						$("#mc4").appendTo("#sandbox");
						$("label[for='mc4']").appendTo("#sandbox");
					}
				break;

				case "q5":
					if(tmp[1]!=""){
						$("#mc5").appendTo("div[name='mc']");
						$("label[for='mc5']").appendTo("div[name='mc']");
						$("label[for='mc5']").html(tmp[1]);
					}
					else{
						$("#mc5").appendTo("#sandbox");
						$("label[for='mc5']").appendTo("#sandbox");
					}
				break;

				case "image":
					if(tmp[1]!=""){
						$("#image > img").attr("src",tmp[1]);
						$("#image").show();
					}
					else{
						$("#image").hide();
					}
				break;

				case "time":
					total=tmp[1];
					min=Math.floor(total/60);
					sec=total-60*min;
					if(sec<10){
						sec="0"+sec;
					}
					$("#timer").html(min+":"+sec);
					timeit();
				break;

				case "status":

				break;
			}
		}
		$("div[name='mc']").buttonset();
	}

	function timeit(){
		if($("#questionplace").css("display")!="none"){
			[min,sec]=$("#timer").text().split(":");
			min=min-0;
			sec=sec-0;
			total=min*60+sec;
			total--;
			min=Math.floor(total/60);
			sec=total-60*min;
			if(sec<10){
				sec="0"+sec;
			}
			$("#timer").html(min+":"+sec);
			if(total<=10){
				if(total%2==0){
					$("#timer").stop().attr("size",8-total/2);
				}
				$("#timer").stop().css("color", "red").animate({ color: "black"}, 750);
				if(total<=5){
					if(total>0){
						SoundS("beep2.mp3");
					}
					else{
						$("#timer").hide();
						$("#session-form").dialog("disable");
					}
				}
				else{
					SoundS("beep.mp3");
				}
			}
			if(total>0){
				setTimeout(timeit,1000);
			}
			else{
				$("#timer").stop().attr("size","2");
			}
		}
		else{
			// Hide Timer
			$("#timer").hide();
			$("#timer").css("color","");
		}
	}

	function SoundS(file){
		T=window.document.location.href.split("/");
		T.splice(T.length-1,1);
		T=T.join("/");
		$("#sound").html("<embed src='"+T+"/"+file+"' hidden='true' width='0'  height='0' autostart='true' loop='false' />")
	}
<?
}
?>