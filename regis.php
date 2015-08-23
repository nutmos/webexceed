<?php

	include 'libaweb/seculib.php';
	include 'libaweb/dblib.php';
	
	$pass = "1234";//$_POST["pss"];

	$dbContoller = new DbContoller();

	if(!$dbContoller->isConn){
		echo "connect is fail!";
	}
	else{
		$dbContoller->noAutoCommit();
		try {
			//query here
			$newSalt = genSalt();
			$pass = createHash($newSalt, $pass);

			$dbContoller->createPassword($pass, $newSalt);

			$dbContoller->commit();
			echo "success";
	
		} catch (Exception $e) {
			$dbContoller->rollback();
			echo "Error : " . $e .". Please try again...";
		}
	}

	$dbContoller->dbClose();
?>