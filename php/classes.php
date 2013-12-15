<?php 
	/**
	* User in library
	*/
	class User
	{
		
		function __construct()
		{
			$mySql = new mySQL();
			$db = $mySql->dbConnect();
		}
		public function register($name, $company, $address)
		{
			$mySql = new mySQL();
			$db = $mySql->dbConnect();
			$name = addslashes($name);
			$company = addslashes($company);
			$address = addslashes($address);
			$result = $db->query("insert into user values('','".$name."','".$company."','".$address."','');");
			if (!$result) {
				echo "false";
			} else {
				$UserID = $db->insert_id;
				echo $UserID;	
			}
			
		}
		public function userCheck($num)
		{
			
		}
		public function bookSelect($bookName)
		{
			
		}
		public function returnBook($returnOrder)
		{
			
		}
		public function borrowBook($borrowOrder)
		{
			
		}
	}

	/**
	* library add or delete book
	*/
	class library
	{
		
		function __construct()
		{
		}
		public function addBooks($book, $numBook)
		{
			$catalog = $book->catalog;
			$bookName = addslashes($book->bookName);
			$author = addslashes($book->author);
			$price = $book->price;
			$mySql = new mySQL();
			$db = $mySql->dbConnect();
			$query = "select * from book where BookID='".$catalog."';";
			$result = $db->query($query);
			if (!$result) {
				echo "select BookID error";
				return false;
			}else{
				if ($result->num_rows > 0) {
					echo "repeat";
					return false;
				}
			}
			$query = "insert into book values('".$catalog."','".$bookName."','".$author."',
				'".$price."','".$numBook."','".$numBook."',current_date());";
			$result = $db->query($query);
			if (!$result) {
				echo "insert book error";
				return false;
			} else {
				echo "true";
			}
		}

		public function cancellationBooks($cancellationBookOrder)
		{
			$BookID = $cancellationBookOrder->BookID;
			$number = $cancellationBookOrder->bookNum;
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			$query = "select BookNum,BookLeft from book where BookID= '".$BookID."';";
			$result = $db->query($query);
			if (!$result) {
				echo "falseA";
				return false;
			}
			if ($result->num_rows == 0) {
				echo "falseB";
				return false;
			}
			// $query = "select BookNum from book where BookID= '".$BookID."' and BookLeft > ".$number.";";
			// $result = $db->query($query);
			// if (!$result) {
			// 	echo "falseA";
			// 	return false;
			// }
			// if ($result->num_rows == 0) {
			// 	echo "falseC";
			// 	return false;
			// }
			$result = $mySql->resultToArray($result);
			foreach ($result as $row) {
				if ($row['BookNum'] > $number && $row['BookLeft'] > $number) {
					$query = "update book set BookNum = BookNum-".$number." and BookLeft = BookLeft-".$number." where BookID = '".$BookID."';";
					$result = $db->query($query);
					if (!$result) {
						echo "falseA";
						return false;
					}else{
						echo "true";
						return true;
					}

				}else{
					if ($row['BookLeft'] < $number && $row['BookNum'] > $number) {
						echo "falseC";
						return false;
					}else{
						if ($row['BookNum'] < $number) {
							echo "falseD";
							return false;
						}
						if ($row['BookNum'] == $number) {
							$query = "delete from book where BookID = '".$BookID."';";
							$result = $db->query($query);
							if (!$result) {
								echo "falseA";
								return false;
							}else{
								echo "true";
								return true;
							}
						}
					}
				}
			}
		}
	}

	/**
	* Book 
	*/
	class book
	{
		public $catalog = 0;
		public $bookName;
		public $author;
		public $price;
		function __construct($catalog, $bookName, $author, $price)
		{
			$this->catalog = $catalog;
			$this->bookName = $bookName;
			$this->author = $author;
			$this->price = $price;
		}
	}

	/**
	* return book order
	*/
	class returnBookOrder
	{
		public $num = 0;
		public $bookNum = 0;
		function __construct($num, $bookNum)
		{
			$this->num = $num;
			$this->bookNum = $bookNum;
		}
	}

	/**
	* borrow book Order
	*/
	class borrowBookOrder
	{
		public $num = 0;
		public $bookNum = 0;
		function __construct($num, $bookNum)
		{
			$this->num = $num;
			$this->bookNum = $bookNum;
		}
	}

	/**
	* cancellation book order
	*/
	class cancellationBookOrder 
	{
		public $BookID = 0;
		public $bookNum = 0;	
		function __construct($BookID, $bookNum)
		{
			$this->BookID = $BookID;
			$this->bookNum = $bookNum;	
		}
	}

	/**
	* sql
	*/
	class mySQL
	{
		
		function __construct()
		{
		}
		public function dbConnect()
		{
			$result = new mysqli('localhost', 'yangfan', 'yangfan', 'library');
			if (!$result) {
				return false;
			}
			$result->autocommit(TRUE);
			return $result;
		}
		public function resultToArray($result)
		{
			$resArray = array();
			for ($count=0; $row = $result->fetch_assoc(); $count++) { 
				$resArray[$count] = $row;
			}
			return $resArray;
		}
	}

 ?>