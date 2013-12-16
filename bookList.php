<?php 
	require_once './php/classes.php';

	$bookName = $_POST['bookName'];
	$User = new User();
	$bookList = $User->bookSelect($bookName);
 ?>
 <!doctype html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Book</title>
 </head>
 <body>
 	<div id="page">
 		<a href="index.html">User Menu</a>
 		<div id="search">
 			<form action="bookList.php" method="post">
 				<input type="text" name="bookName" placeholder="Book Name" required>
 				<input type="submit" value="Search">
 			</form>
 		</div>
 		<div id="BookList">
 			<div id="ListTitle">
 				<ul>
 					<li>Book ID</li>
 					<li>Book Name</li>
 					<li>Author</li>
 					<li>Price</li>
 					<li>Total</li>
 					<li>Left</li>
 				</ul>
 			</div>
 				<?php 
 				if (!is_array($bookList)) {
 					echo "No book like ".$bookName;
 				}else{
 					foreach ($bookList as $row) {
 						echo "
 						<div class=\"book\">
							<ul>
								<li>".$row['BookID']."</li>
								<li>".$row['BookName']."</li>
								<li>".$row['BookAuthor']."</li>
								<li>".$row['BookPrice']."</li>
								<li>".$row['BookNum']."</li>
								<li>".$row['BookLeft']."</li>
							</ul>
						</div>";		
 					}
 				}
 				 ?>
 		</div>
 	</div>
 </body>
 </html>