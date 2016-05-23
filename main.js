
function sendNote(login){

	$.post(
		"ajaxController.php",
		{
			'title':  $('input[name=title]').val(),
			'text': $('textarea[name=text]').val(),
			'color': $('input[name=color]').val(),
			'login': login
		},onAjaxSuccess
		
	);
}

function onAjaxSuccess(){
	$("input[name=title]").val('');
	$("textarea[name=text]").val('');
	window.location.reload(true); 
}

function deleteNote(id){
	$.post(
		"ajaxController.php",
		{
			'delete':  id
		}
	);
	$('#'+id).remove();
}

function updateNote(id){
	var title = $("#"+id+" .title").text();
	var myText = $("#"+id+" .text").text();
	var color = $("#"+id).css("background-color");
	color=getHexRGBColor(color);
	
	$("#"+id+" .title").replaceWith("<input name='title' class='chTitle' id='chTitle"+id+"' type='text' value="+ title +">");
	$("#"+id+" .text").replaceWith("<textarea name='text' class='chText' id='chText"+id+"'>"+ myText +"</textarea>");  //"<input name='text' id='chText"+id+"' type='textarea' value="+ myText +">");
	$("#"+id+" .time").replaceWith('<input name="color" id="chTime'+id+'" type="color" value="#'+color+'">');
	if(!$("#"+id+" button").hasClass("myButton")){
		$("#"+id).append("<button class='myButton' onclick='sendNoteUpdate(parentElement)' >Save</button>");//onclick='sendNoteUpdate(\'"+id+"\')'
	}
	
	
}

function getHexRGBColor(color)
{
	  color = color.replace(/\s/g,"");
	  var aRGB = color.match(/^rgb\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);

	  if(aRGB)
	  {
		color = '';
		for (var i=1;  i<=3; i++) color += Math.round((aRGB[i][aRGB[i].length-1]=="%"?2.55:1)*parseInt(aRGB[i])).toString(16).replace(/^(.)$/,'0$1');
	  }
	  else color = color.replace(/^#?([\da-f])([\da-f])([\da-f])$/i, '$1$1$2$2$3$3');
	  
	  return color;
}



function sendNoteUpdate(myDiv){
	
	$.post(
		"ajaxController.php",
		{
			'title':  $('input[name=title]').val(),
			'text': $('textarea[name=text]').val(),
			'color': $('input[name=color]').val(),
			'id': myDiv.id,
			'update': true
		},
		function(){
			var today = new Date();
			var options = {
			  year: 'numeric',
			  month: 'long',
			  day: 'numeric',
			  weekday: 'long',
			  hour: 'numeric',
			  minute: 'numeric',
			  second: 'numeric'
			};
			var date = today.toLocaleString("en-US", options);
			var newColor=getHexRGBColor($('input[name=color]').val());
			
			$("#chTitle"+myDiv.id).replaceWith("<div class='title'><b>"+ $('input[name=title]').val() +"</b></div>");
			$("#chText"+myDiv.id).replaceWith("<div class='text'>"+ $('textarea[name=text]').val() +"</div>");
			$("#chTime"+myDiv.id).replaceWith("<div class='time'>"+ date +"</div>");
			$("#"+myDiv.id+" .myButton").remove();
			$("#"+myDiv.id).css("background-color", newColor);
		}
	);
	
}

function checkForm(){
	
	var pass = document.getElementsByName("password")[0].value;
	var checkPass = document.getElementsByName("сonfPassword")[0].value;
	var email = document.getElementsByName("email")[0].value;
	var regEmail= /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
	
	
	if(pass!=checkPass){
		
		alert("Ваши пароли не совпадают");
		return false;
	}
	
	if(!regEmail.test(email)){
		alert("Ваш email не коректен");
		return false;
	}
	
}

