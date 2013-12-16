<?php 
	require_once './php/classes.php';

	if (isset($_POST['UserID'])) {
		$UserID = $_POST['UserID'];
		$User = new User();
		$UserDetail = $User->userCheck($UserID);
	}
 ?>
<!doctype html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>User</title>
 	<link rel="stylesheet" href="./css/userDetail.css">
 </head>
 <body>
 	<div id="page">
 		<div id="body">
	 		<header>
	 			<a href="index.html">User Menu</a>
	 		</header>
	 		<div id="search">
	 			<form action="userDetail.php" method="post">
	 				<input type="text" name="UserID" placeholder="User ID" required>
	 				<input type="submit" value="Search">
	 			</form>
	 		</div>
			<div id="ListTitle">
				<?php 
				if (isset($_POST['UserID'])) {
					?>
					<ul id="title">
						<li>User ID</li>
						<li>Name</li>
						<li>Company</li>
						<li>Address</li>
						<li>Borrow</li>
					</ul>
					<hr>
					<?php
					if (!is_array($UserDetail)) {
						echo "No user whoes id ".$UserID;
					}else{
						foreach ($UserDetail as $row) {
							echo "
							<div class=\"book\">
							<ul id=\"detail\">
								<li>".$row['UserID']."</li>
								<li>".$row['UserName']."</li>
								<li>".$row['UserCompany']."</li>
								<li>".$row['UserAddress']."</li>
								<li>".$row['BorrowNum']."</li>
							</ul>
						</div>";		
						}
					}
				}
				 ?>
			</div>
 		</div>
 	</div>
 </body>
 </html>