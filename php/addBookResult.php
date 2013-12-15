<?php 
	require_once 'classes.php';

	$catalog = $_POST['catalog'];
	$title = $_POST['title'];
	$author = $_POST['author'];
	$price = $_POST['price'];
	$number = $_POST['number'];

	$book = new book($catalog, $title, $author, $price);
	$library = new library();
	$library->addBooks($book, $number);
 ?>