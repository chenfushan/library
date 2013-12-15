$(document).ready(function() {
	$('#AddButton').click(function() {
		var catalog = $('#catalog').val();
		var title = $('#title').val();
		var author = $('#author').val();
		var price = $('#price').val();
		var number = $('#number').val();

		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else{
			xmlhttp = new AcitiveXObject("Microsoft.XMLHTTP");
		}
		var url = "catalog="+catalog+"&title="+title+"&author="+author+"&price="+price+"&number="+number;
//		alert(url);
		xmlhttp.open("POST","./php/addBookResult.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var Info = xmlhttp.responseText;
				if (Info == "true") {
					alert("Successfully!");
					document.forms[0].reset();
				}else{
					if (Info == "repeat") {
						alert("The catalog have been used !\nplease change another!");
					}else{
						alert("Database error !\n"+Info);
					}
				}
			}
		}
		xmlhttp.send(url);
	});
});