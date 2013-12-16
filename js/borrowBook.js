$(document).ready(function() {
	$('#borrowButton').click(function() {
		var userid = $('#userid').val();
		var bookid = $('#bookid').val();

		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else{
			xmlhttp = new AcitiveXObject("Microsoft.XMLHTTP");
		}
		var url = "userid="+userid+"&bookid="+bookid;
//		alert(url);
		xmlhttp.open("POST","./php/borrowBookResult.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var Info = xmlhttp.responseText;
				if (Info == "true") {
					alert("Borrow Successfully!");
					location.href ="index.html";
				}else{
					if (Info == "falseA") {
						alert("Database Error!");
						return;
					}
					if (Info == "falseB") {
						alert("You don't have a User ID\nPlease register first");
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