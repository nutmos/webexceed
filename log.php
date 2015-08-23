<?php
	include 'libaweb/seculib.php';
	include 'libaweb/dblib.php';

	$alco = $_GET["alcohol"];
	$alco = clean($alco);

	$dbContoller = new DbContoller();

	if(!$dbContoller->isConn){
		echo "connect is fail!";
	}
	else if(strlen($alco) > 0)
	{
		if($dbContoller->insertLog($alco)) echo "success..";
		else echo "failed...";
	}
	else
		echo "failed...";
?>