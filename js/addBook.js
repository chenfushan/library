$(document).ready(function() {
	$('#AddButton').click(function() {
		/*
		* get element value by id
		*/
		var catalog = $('#catalog').val();
		var title = $('#title').val();
		var author = $('#author').val();
		var price = $('#price').val();
		var number = $('#number').val();
		
		//create ajax
		var xmlhttp;
		if (window.XMLHttpRequest) {
			//new xmlhttp
			xmlhttp = new XMLHttpRequest();
		} else{
			xmlhttp = new AcitiveXObject("Microsoft.XMLHTTP");
		}
		var url = "catalog="+catalog+"&title="+title+"&author="+author+"&ysprice="+price+"&number="+number;
//		alert(url);
		//use post method to send data to background
		xmlhttp.open("POST","./php/addBookResult.php",true);
		//set header
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//get response message
				var Info = xmlhttp.responseText;
				if (Info == "true") {
					alert("Successfully!");
					//empty forms
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
		//send url to back
		xmlhttp.send(url);
	});
});