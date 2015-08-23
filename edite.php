<?php 
	include 'libaweb/seculib.php';
	include 'libaweb/dblib.php';

	$pass = $_GET['pwd'];
	$newPass = $_GET['n-pwd'];
	$reNewPass = $_GET['re-n-pwd'];

	$dbContoller = new DbContoller();
	echo "string";
	if(!$dbContoller->isConn){
		echo "connect is fail!";
	}
	else if(strlen($pass) > 0 && strlen($newPass) > 0 && strlen($reNewPass) > 0)
	{
		$pass = clean($pass);
		$newPass = clean($newPass);
		$reNewPass = clean($reNewPass);

		$return_pass = $dbContoller->selectPassword();
		
		if($return_pass){
			echo $return_pass["salt"];
			$salt = $return_pass["salt"];
			//echo $salt . "<br/>";
			$hash_string = createHash($salt, $pass);
			if($hash_string == $return_pass["password"]){
				echo $hash_string;
				if($newPass == $reNewPass){
					$newSalt = genSalt();
					$newPass = createHash($newSalt, $newPass);

					$update = $dbContoller->updatePassword($newPass, $newSalt);
					if($update) header( "location: index.html");
					else echo "fail";
				}
				$dbContoller->dbClose();
			}
			else echo "Pass invalid...";
		}
		else
			echo "Connect is fail....";
	}
	else
		echo "Info is missing...";
?>