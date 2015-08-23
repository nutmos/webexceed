<?php 

	include 'libaweb/seculib.php';
	include 'libaweb/dblib.php';

	$pass = $_GET['pwd'];
	$pass = clean($pass);
	$dbContoller = new DbContoller();

	if(!$dbContoller->isConn){
		echo "connect is fail!";
	}
	else{

		$return_pass = $dbContoller->selectPassword();
		$dbContoller->dbClose();
		
		if($return_pass){
			$salt = $return_pass["salt"];
			$hash_string = createHash($salt, $pass);
			
			if($hash_string == $return_pass["password"]){
				header( "location: car.php");
			}
			else echo "fail!";
		}
		else echo "Pass invalid...";
	}
?>