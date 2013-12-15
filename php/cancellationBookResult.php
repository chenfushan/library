<?php 
	require_once 'classes.php';
	$BookID = $_POST['catalog'];
	$number = $_POST['number'];

	$cancelBookOrder = new cancellationBookOrder($BookID, $number);
	$library = new library();
	$library->cancellationBooks($cancelBookOrder);
 ?>