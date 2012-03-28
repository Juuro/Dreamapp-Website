<?php

if(isset($_COOKIE['username'])){
    
   	$username = $_COOKIE['username'];
	$password = $_COOKIE['password'];
	
	$sql = "SELECT password
				FROM user
			WHERE username
				LIKE '".$username."'";
				
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	
	if ($password == $row[0]) {
		session_start();
		$_SESSION['angemeldet'] = true;
		$_SESSION['admin'] = true;
		$_SESSION['name'] = $username;
		
		setcookie(username, $username, time()+60*60*24*15, "/"); // 1 Minute
		setcookie(password, $password, time()+60*60*24*15, "/"); // 1 Minute
		
		$hostname = $_SERVER['HTTP_HOST'];
		$path = dirname($_SERVER['PHP_SELF']);

	}
}
   
?>