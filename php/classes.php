<?php 
	/**
	* User in library
	*/
	class User
	{
		
		function __construct()
		{
		}
		public function register($name, $company, $address)
		{
			$mySql = new mySQL();
			$db = $mySql->dbConnect();
			$name = addslashes($name);
			$company = addslashes($company);
			$address = addslashes($address);
			$result = $db->query("insert into user(UserID, UserName, UserCompany, UserAddress, BorrowNum) values('','".$name."','".$company."','".$address."','');");
			if (!$result) {
				echo "false";
			} else {
				$UserID = $db->insert_id;
				echo $UserID;	
			}
			
		}
		public function userCheck($UserID)
		{
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			$result = $db->query("select * from user where UserID = '".$UserID."';");
			if (!$result || $result->num_rows == 0) {
				return false;
			}else{
				$result = $mySql->resultToArray($result);
				return $result;
			}
		}
		public function bookSelect($bookName)
		{
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			$bookName = addslashes($bookName);
			$result = $db->query("select * from book where BookName like '%".$bookName."%';");
			if (!$result || $result->num_rows == 0) {
				return false;
			}else{
				$result = $mySql->resultToArray($result);
				return $result;
			}
		}
		public function returnBook($returnOrder)
		{
			$UserID = $returnOrder->UserID;
			$BookID = $returnOrder->BookID;
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			$query = "select datediff(current_date(), BorrowDate) from borrow where UserID= '".$UserID."' and BookID = '".$BookID."';";
			$result = $db->query($query);
			if (!$result) {
				echo "falseA";
				return false;
			}
			if ($result->num_rows == 0) {
				echo "falseB";
				return false;
			}
			$result = $mySql->resultToArray($result);
			foreach ($result as $row) {
				echo $row['datediff(current_date(), BorrowDate)'];
			}
			$result = $db->query("delete from borrow where UserID='".$UserID."' and BookID = '".$BookID."';");
			$result = $db->query("update user set BorrowNum = BorrowNum-1 where UserID='".$UserID."';");
			$result = $db->query("update book set BookLeft = BookLeft+1 where BookID='".$BookID."';");

		}
		public function borrowBook($borrowOrder)
		{
			$UserID = $borrowOrder->UserID;
			$BookID = $borrowOrder->BookID;
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			$query = "select UserID,BorrowNum from user where UserID='".$UserID."';";
			$result = $db->query($query);
			if (!$result) {
				echo "falseA";
				return false;
			}
			if ($result->num_rows == 0) {
				echo "falseB";
				return false;
			}
			$result = $mySql->resultToArray($result);
			foreach ($result as $row) {
				if ($row['BorrowNum'] >= 5) {
					echo "falseD";
					return false;
				}
			}
			$query = "select BookLeft from book where BookID = '".$BookID."';";
			$result = $db->query($query);
			if (!$result) {
				echo "falseA";
				return false;
			}
			if ($result->num_rows == 0) {
				echo "falseE";
				return false;
			}
			$result = $mySql->resultToArray($result);
			foreach ($result as $row) {
				if ($row['BookLeft'] <= 0) {
					echo "falseF";
					return false;
				}
			}
			$query = "insert into borrow(UserID, BookID, BorrowDate) values('".$UserID."','".$BookID."',current_date());";
			$result = $db->query($query);
			if (!$result) {
				echo "falseC";
				return false;
			}
			$result = $db->query("update user set BorrowNum = BorrowNum+1 where UserID='".$UserID."';");
			$result = $db->query("update book set BookLeft = BookLeft-1 where BookID='".$BookID."';");
			if (!$result) {
				echo "falseA";
				return false;
			}else{
				echo "true";
			}

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
			$result = $mySql->resultToArray($result);
			foreach ($result as $row) {
				if ($row['BookNum'] > $number && $row['BookLeft'] > $number) {
					$query = "update book set BookNum = BookNum-".$number.", BookLeft = BookLeft-".$number." where BookID = '".$BookID."';";
					$result = $db->query($query);
					if (!$result) {
						echo "falseA";
						return false;
					}else{
						echo "true";
						return true;
					}

				}else{
					if ($row['BookLeft'] < $number && $row['BookNum'] >= $number) {
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
		public $UserID = 0;
		public $BookID = 0;
		function __construct($UserID, $BookID)
		{
			$this->UserID = $UserID;
			$this->BookID = $BookID;
		}
	}

	/**
	* borrow book Order
	*/
	class borrowBookOrder
	{
		public $UserID = 0;
		public $BookID = 0;
		function __construct($UserID, $BookID)
		{
			$this->UserID = $UserID;
			$this->BookID = $BookID;
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