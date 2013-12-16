$(document).ready(function() {
	$('#returnButton').click(function() {
		var userid = $('#userid').val();
		var bookid = $('#bookid').val();

		if (userid == '') {
			alert("user id can't be empty !");
			return ;
		}
		if (bookid == '') {
			alert("book id can't be empty !");
			return ;
		}

		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else{
			xmlhttp = new AcitiveXObject("Microsoft.XMLHTTP");
		}
		var url = "userid="+userid+"&bookid="+bookid;
		xmlhttp.open("POST","./php/returnBookResult.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var Info = xmlhttp.responseText;
				if (Info == "falseA" ) {
					alert("Datebase Error!");
				}else{
					if (Info == "falseB") {
						alert("You have not borrow this book!");
						return;
					}else{
						if (Info > 30) {
							var money = (Info-30)/10;
							var r = confirm("Your book has expired!\n\nPlease pay fines: "+money+"yuan.");
							if (r == true) {
								alert("Thank you~");
							}else{
								alert("Wait you for next time!");
							}
						}else{
							alert("Return successfully!");
						}
					}
				}
			}
		}
		xmlhttp.send(url);
	});
});