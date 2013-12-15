$(document).ready(function() {
	$('#RegButton').click(
		function() {
			var name = $('input#name').val();
			var company = $('input#company').val();
			var address = $('input#address').val();

			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else{
				xmlhttp = new AcitiveXObject("Microsoft.XMLHTTP");
			}
//			alert("button click!");
			var url = "name="+name+"&company="+company+"&address="+address;
//			alert(url);
			xmlhttp.open("POST","./php/registerResult.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					var Info = xmlhttp.responseText;
					if (Info != "false") {
						alert("Your User id is:"+Info);
						location.href = "index.html";
					} else{
						alert("Register Error !");
					}
				}
			}
			xmlhttp.send(url);
		});
});