<?php 
	require_once 'classes.php';
	$name = $_POST['name'];
	$company = $_POST['company'];
	$address = $_POST['address'];

	$user = new user();
	$user->register($name, $company, $address);
 ?>