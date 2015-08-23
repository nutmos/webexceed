<?php 

	function genSalt(){
		return mcrypt_create_iv(64, MCRYPT_DEV_URANDOM);
	}
	
	function createHash($salt, $string){
		$data = substr($salt, 0, 31) . $string . substr($salt, 31);
		return hash("sha512", $data);
	}

	function clean($string){
		return htmlspecialchars($string);
	}
?>