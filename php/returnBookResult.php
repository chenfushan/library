<?php 
	require_once 'classes.php';
	$userid = $_POST['userid'];
	$bookid = $_POST['bookid'];

	$returnBookOrder = new returnBookOrder($userid, $bookid);
	$User = new User();
	//return books
	$User->returnBook($returnBookOrder);
 ?>