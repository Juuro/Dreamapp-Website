<?php
	session_start();
	session_destroy();
	
	setcookie(username, "", time()-60*60, "/");
	setcookie(password, "", time()-60*60, "/");
	
	$hostname = $_SERVER['HTTP_HOST'];
	$path = dirname($_SERVER['PHP_SELF']);
	
	header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php?s=lo');
?>
