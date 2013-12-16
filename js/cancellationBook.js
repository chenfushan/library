$(document).ready(function() {
	$('#cancelButton').click(function() {
		var catalog = $('#catalog').val();
		var number = $('#number').val();

		var r = confirm("Are you sure?");
		if (r == true) {
		}else{
			return;
		}

		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else{
			xmlhttp = new AcitiveXObject("Microsoft.XMLHTTP");
		}
		var url = "catalog="+catalog+"&number="+number;
//		alert(url);
		xmlhttp.open("POST","./php/cancellationBookResult.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var Info = xmlhttp.responseText;
				if (Info == "true") {
					alert("Successfully!");
					document.forms[0].reset();
				} else{
					if (Info == "falseA") {
						alert("Database Error!");
						return;
					}
					if (Info == "falseB") {
						alert("There is no this book!");
						return;
					}
					if (Info == "falseC") {
						alert("Please return the book first!");
						return;
					}
					if (Info == "falseD") {
						alert("There is no enough book in library!");
						return;
					}else{
						alert(Info);
					}
				}
			}
		}
		xmlhttp.send(url);
	});
});