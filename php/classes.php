<?php 
	/**
	* User in library
	*/
	class User
	{
		//construct function
		function __construct()
		{
		}

		//function register, register new user
		//@param $name is a string, $company is string, address is string
		//@return boolean
		public function register($name, $company, $address)
		{
			$mySql = new mySQL();
			$db = $mySql->dbConnect();
			$name = addslashes($name);
			$company = addslashes($company);
			$address = addslashes($address);
			//database control, insert user information to database
			$result = $db->query("insert into user(UserID, UserName, UserCompany, UserAddress, BorrowNum) values('','".$name."','".$company."','".$address."','');");
			//judge the resutl which returns by database
			if (!$result) {
				echo "false";
			} else {
				//get primary id insert the last time
				$UserID = $db->insert_id;
				echo $UserID;	
			}
			
		}

		//function userCheck, select user
		//@param UserID is a int which is primary id for user
		//@return boolean
		public function userCheck($UserID)
		{
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			//database control, select user information from database
			$result = $db->query("select * from user where UserID = '".$UserID."';");
			//judge the resutl which returns by database
			if (!$result || $result->num_rows == 0) {
				return false;
			}else{
				//translate the database result to array
				$result = $mySql->resultToArray($result);
				return $result;
			}
		}

		//function boolSelect, select book
		//@param bookName is a string value
		//@return book information
		public function bookSelect($bookName)
		{
			$mySql = new MySQL();
			$db = $mySql->dbConnect();
			//format the book name
			$bookName = addslashes($bookName);
			//select book information like book name
			$result = $db->query("select * from book where BookName like '%".$bookName."%';");
			//judge the result which returns by database
			//if empty return false
			if (!$result || $result->num_rows == 0) {
				return false;
			}else{
				//translate the database result to array
				//return the book information
				$result = $mySql->resultToArray($result);
				return $result;
			}
		}
		public function returnBook($returnOrder)
		{
			//get Order information
			$UserID = $returnOrder->UserID;
			$BookID = $returnOrder->BookID;
			$mySql = new MySQL();
			//connect to database
			$db = $mySql->dbConnect();
			//select the data count from borrow to return date which order matches userid and bookid
			$query = "select datediff(current_date(), BorrowDate) from borrow where UserID= '".$UserID."' and BookID = '".$BookID."';";
			//execute the query
			$result = $db->query($query);
			//judge the result which returns by database
			if (!$result) {
				echo "falseA";
				return false;
			}
			//if empty return false
			if ($result->num_rows == 0) {
				echo "falseB";
				return false;
			}
			//translate the database result to array
			$result = $mySql->resultToArray($result);
			//traversal the result array and return
			foreach ($result as $row) {
				echo $row['datediff(current_date(), BorrowDate)'];
			}
			//delete the borrow order from database
			$result = $db->query("delete from borrow where UserID='".$UserID."' and BookID = '".$BookID."';");
			//update the user's borrow book number
			$result = $db->query("update user set BorrowNum = BorrowNum-1 where UserID='".$UserID."';");
			//update book's left in library
			$result = $db->query("update book set BookLeft = BookLeft+1 where BookID='".$BookID."';");

		}
		public function borrowBook($borrowOrder)
		{
			//get Order information
			$UserID = $borrowOrder->UserID;
			$BookID = $borrowOrder->BookID;
			$mySql = new MySQL();
			//connect to database
			$db = $mySql->dbConnect();
			//select user id and borrow number from database whoes id is UserID
			$query = "select UserID,BorrowNum from user where UserID='".$UserID."';";
			//execute the query
			$result = $db->query($query);
			//judge the result which returns by database
			if (!$result) {
				echo "falseA";
				return false;
			}
			//if empty return false
			if ($result->num_rows == 0) {
				echo "falseB";
				return false;
			}
			//translate the database result to array
			$result = $mySql->resultToArray($result);
			//traversal the result array and return
			foreach ($result as $row) {
				if ($row['BorrowNum'] >= 5) {
					echo "falseD";
					return false;
				}
			}
			//select book left in library which book's id is BookID
			$query = "select BookLeft from book where BookID = '".$BookID."';";
			//execute the query
			$result = $db->query($query);
			//judge the result which returns by database
			if (!$result) {
				echo "falseA";
				return false;
			}
			//if empty return false
			if ($result->num_rows == 0) {
				echo "falseE";
				return false;
			}
			//translate the database result to array
			$result = $mySql->resultToArray($result);
			//traversal the result array and return
			foreach ($result as $row) {
				if ($row['BookLeft'] <= 0) {
					echo "falseF";
					return false;
				}
			}
			//insert the borrowOrder to database
			$query = "insert into borrow(UserID, BookID, BorrowDate) values('".$UserID."','".$BookID."',current_date());";
			//execute the query
			$result = $db->query($query);
			//judge the result which returns by database
			if (!$result) {
				echo "falseC";
				return false;
			}
			//update the user's borrow number up one
			$result = $db->query("update user set BorrowNum = BorrowNum+1 where UserID='".$UserID."';");
			//update book left reduce one in library
			$result = $db->query("update book set BookLeft = BookLeft-1 where BookID='".$BookID."';");
			//judge the result which returns by database
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
			//get book information
			$catalog = $book->catalog;
			//format the data
			$bookName = addslashes($book->bookName);
			$author = addslashes($book->author);
			$price = $book->price;
			$mySql = new mySQL();
			//connect to database
			$db = $mySql->dbConnect();
			//select book information whiches book's id equal catalog
			$query = "select * from book where BookID='".$catalog."';";
			//execute the query
			$result = $db->query($query);
			//judge the result which returns by database
			if (!$result) {
				echo "select BookID error";
				return false;
			}else{
				//if empty return false
				if ($result->num_rows > 0) {
					echo "repeat";
					return false;
				}
			}
			//insert the book to database
			$query = "insert into book values('".$catalog."','".$bookName."','".$author."',
				'".$price."','".$numBook."','".$numBook."',current_date());";
			//execute the query
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
			//get cancellation Book Order information
			$BookID = $cancellationBookOrder->BookID;
			$number = $cancellationBookOrder->bookNum;
			$mySql = new MySQL();
			//connect to database
			$db = $mySql->dbConnect();
			//select book nunber and book left number in library which book's id is BookID
			$query = "select BookNum,BookLeft from book where BookID= '".$BookID."';";
			//execute the query
			$result = $db->query($query);
			if (!$result) {
				echo "falseA";
				return false;
			}
			////if empty return false
			if ($result->num_rows == 0) {
				echo "falseB";
				return false;
			}
			//translate the database result to array
			$result = $mySql->resultToArray($result);
			//travesal the result array
			foreach ($result as $row) {
				//if number is low
				if ($row['BookNum'] > $number && $row['BookLeft'] > $number) {
					//cancellation book in database
					$query = "update book set BookNum = BookNum-".$number.", BookLeft = BookLeft-".$number." where BookID = '".$BookID."';";
					//execute the query
					$result = $db->query($query);
					if (!$result) {
						echo "falseA";
						return false;
					}else{
						echo "true";
						return true;
					}

				}else{
					//if cancellation number is between left and total number
					if ($row['BookLeft'] < $number && $row['BookNum'] >= $number) {
						echo "falseC";
						return false;
					}else{
						//if there is no enough book in library
						if ($row['BookNum'] < $number) {
							echo "falseD";
							return false;
						}
						//if cancellation number is just equal the total number
						if ($row['BookNum'] == $number) {
							//delete the book from library
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
		//connect to database
		public function dbConnect()
		{
			//connect
			$result = new mysqli('localhost', 'yangfan', 'yangfan', 'library');
			//connect result
			if (!$result) {
				return false;
			}
			$result->autocommit(TRUE);
			return $result;
		}
		//translate the database operate result to array
		//@param database operate result
		//@return array
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