<?php 

	/**
	* Database contoller.
	*/
	class DbContoller
	{
		public $database;
		private $servername = "onestone.eng.src.ku.ac.th";
		private	$username = "specail";
		private	$password = "123456789";
		private	$dbname = "specailproject";
		public $isConn = false;
		
		function __construct()
		{
			$this->database = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

			// Check connection
			if ($this->database->connect_error) {
			    echo "<script>alert(\"Connection is failed..\");</script>";
			}else $this->isConn = true; 
		}

		/*function createPassword($pass, $salt){
			if($this->isConn){
				$stmt = $this->database->prepare("INSERT INTO exeed12_password (password, salt) VALUES (?, ?)");
				$stmt->bind_param("ss", $pass, $salt);
								
				$stmt->execute();
				$stmt->close();
			}
		}*/

		function readLog(){
			if($this->isConn){
				$returned_log = $this->database->query("SELECT * FROM exeed12_log");
				$row = $returned_log->fetch_assoc();

				return $returned_log->num_rows;
			}
			return false;
		}

		function insertLog($alcohol){
			if($this->isConn){
				$stmt = $this->database->prepare("INSERT INTO exeed12_log (alcohol) VALUES (?)");
				$stmt->bind_param("s", $alcohol);
								
				$stmt->execute();
				$stmt->close();
				return true;
			}
			else
				return false;
		}

		function updatePassword($newPass, $newSalt){
			if($this->isConn){
				$stmt = $this->database->prepare("UPDATE exeed12_password SET password=?, salt=?");
				$stmt->bind_param("ss", $newPass, $newSalt);
								
				$stmt->execute();
				$stmt->close();
				return true;
			}
			return false;
		}

		function selectPassword(){
			if($this->isConn){
				$returned_pass = $this->database->query("SELECT * FROM exeed12_password");

				if(!$returned_pass->num_rows > 0) return false;
				else {
					$row = $returned_pass->fetch_assoc();
					$result = array('password' => $row["password"], 'salt' => $row["salt"]);
					return $result;
				}
			}
			return false;
		}

		function rollback(){
			if($this->isConn) $this->database->rollback();
		}

		function commit(){
			if($this->isConn) $this->database->commit();
		}

		function dbClose(){
			if($this->isConn) $this->database->close();
		}

		function noAutoCommit(){
			if($this->isConn) $this->database->autocommit(false);
		}
	}
?>