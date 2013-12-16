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
 	<link rel="stylesheet" href="./css/bookList.css">
 </head>
 <body>
 	<div id="page">
 		<div id="body">
	 		<header>
	 			<a href="index.html">User Menu</a>
	 		</header>	
	 		<div id="search">
	 			<form action="bookList.php" method="post">
	 				<input type="text" name="bookName" placeholder="Book Name" required>
	 				<input type="submit" value="Search">
	 			</form>
	 		</div>
	 		<div id="BookList">
	 			<div id="ListTitle">
	 				<ul id="title">
	 					<li>Book ID</li>
	 					<li class="bookName">Book Name</li>
	 					<li>Author</li>
	 					<li>Price</li>
	 					<li class="left">Total</li>
	 					<li class="left">Left</li>
	 				</ul>
	 				<hr>
	 			</div>
	 				<?php 
	 				if (!is_array($bookList)) {
	 					echo "No book like ".$bookName;
	 				}else{
	 					foreach ($bookList as $row) {
	 						echo "
								<ul id=\"detail\">
									<li>".$row['BookID']."</li>
									<li class=\"bookName\">".$row['BookName']."</li>
									<li>".$row['BookAuthor']."</li>
									<li>".$row['BookPrice']."</li>
									<li class=\"left\">".$row['BookNum']."</li>
									<li class=\"left\">".$row['BookLeft']."</li>
								</ul>";		
	 					}
	 				}
	 				 ?>
	 		</div>
 		</div>
 	</div>
 </body>
 </html>