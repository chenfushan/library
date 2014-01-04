<?php 
	require_once 'classes.php';
	$userid = $_POST['userid'];
	$bookid = $_POST['bookid'];

	$borrowBookOrder = new borrowBookOrder($userid, $bookid);
	$User = new User();
	//borrow book from library
	$User->borrowBook($borrowBookOrder);
 ?>