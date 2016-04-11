
function sendNote(login){
	/*var title = $("input[name=title]").val();
	var mytext = $("input[name=text]").val();
	var color = $("input[name=color]").val();
	*/
	$.post(
		"ajaxController.php",
		{
			'title':  $('input[name=title]').val(),
			'text': $('input[name=text]').val(),
			'color': $('input[name=color]').val(),
			'login': login
		},onAjaxSuccess
		
	);
}

function onAjaxSuccess(){
	$("input[name=title]").val('');
	$("input[name=text]").val('');
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
	
}



//$("input[name=submit]").click(sendNote());
//$('#submit').click(sendNote());
/*
<script language="javascript" src="main.js">
function sendMyNote(){
	$.post(
		"model.php",
		{
			'title': $('title').value,
			'text': $('text').value,
			'color': $('color').value
		},
		
	);
	
}

</script>*/