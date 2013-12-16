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
 </head>
 <body>
 	<div id="page">
 		<a href="index.html">User Menu</a>
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
				<ul>
					<li>User ID</li>
					<li>User Name</li>
					<li>Company</li>
					<li>Address</li>
					<li>Borrow book number</li>
				</ul>
				<?php
				if (!is_array($UserDetail)) {
					echo "No user whoes id ".$UserID;
				}else{
					foreach ($UserDetail as $row) {
						echo "
						<div class=\"book\">
						<ul>
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
 </body>
 </html>