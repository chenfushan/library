$(document).ready(function() {
	$('#borrowButton').click(function() {
		/*
		* get element value by id
		*/
		var userid = $('#userid').val();
		var bookid = $('#bookid').val();

		//create ajax
		var xmlhttp;
		if (window.XMLHttpRequest) {
			//new xmlhttp
			xmlhttp = new XMLHttpRequest();
		} else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var url = "userid="+userid+"&bookid="+bookid;
//		alert(url);
		//use post method to send data to background
		xmlhttp.open("POST","./php/borrowBookResult.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//get response message
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
						alert("Wrong User ID\nPlease register first");
						return;
					}if (Info == "falseC") {
						alert("You have already borrowed this book!");
						return;
					}
					if (Info == "falseD") {
						alert("You have already borrowed 5 books !")
						return;
					}
					if (Info == "falseE") {
						alert("Library don't have this book");
						return;
					}
					if (Info == "falseF") {
						alert("This book all have been borrowed");
						return;
					}
					else{
						alert(Info);
					}
				}
			}
		}
		xmlhttp.send(url);
	});
});