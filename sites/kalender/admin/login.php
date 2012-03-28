<?php
    include "../inc/db.php";
    
    #################################
    
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
			
			header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
			exit;
	
		}
	}	
    
    ###############################
    
    
	
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		session_start();

		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$hostname = $_SERVER['HTTP_HOST'];
		$path = dirname($_SERVER['PHP_SELF']);
		
		$save_pwd = $_POST['rememberme'];
		
		$sql = "SELECT password
					FROM user
				WHERE username
					LIKE '".$username."'";
					
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);

		// Benutzername und Passwort werden überprüft
		if ($password == $row[0]) {
			$_SESSION['angemeldet'] = true;
			$_SESSION['admin'] = true;
			$_SESSION['name'] = $username;
			
			if(isset($save_pwd) && $save_pwd == true){
				setcookie(username, $username, time()+60*60*24*15, "/"); // 1 Minute
				setcookie(password, $password, time()+60*60*24*15, "/"); // 1 Minute
			}

			// Weiterleitung zur geschützten Startseite
			header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
			exit;
		}
		else {
			header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php?s=wd');
			exit;
		}
	}
	
?>


<!DOCTYPE HTML>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<title>Gesch&uuml;tzter Bereich</title>
	<link rel="stylesheet" type="text/css" href="css/login-style.css" />
	</head>
	<body>		
		<div id="loginbox">		
			<?php
				if (isset($_GET['s'])) {
					if ($_GET['s'] == 'lo'){						
						echo "<p class='message logoff'>	Sie haben sich erfolgreich abgemeldet.<br /></p>";
					}
					elseif ($_GET['s'] == 'wd') {
						echo "<p class='message login_error'><strong>Fehler</strong>: Falsche Login-Daten. <a href='' title='Passwortfundb&uuml;ro'>Passwort vergessen?</a><br /></p>";
					}
				}
			?>
			<form action="login.php" method="post">
				<fieldset>
					<legend>Login</legend>
					<p>
						<label for="username">Username</label><br />
						<input type="text" attribut="login" name="username" />
					</p>
					<p>
						<label for="password">Passwort</label><br />
						<input type="password" attribut="login" name="password" />
					</p>
					
					<p class="forgetmenot">
						<input name="rememberme" type="checkbox" id="rememberme" value="true" tabindex="90" /><label for="rememberme"> Passwort speichern</label>
					</p>
					<p class="submit">
						<input type="submit" value="Anmelden" />
					</p>
				</fieldset>
			</form>
			
			<p id="nav">
				<!-- <a href="" title="Passwortfundb&uuml;ro">Passwort vergessen?</a> -->
			</p>			
		</div>
			
		<p id="backto">
			<a href="../" title="Haben Sie sich Verlaufen?">&larr; Zurück zum Kalender</a>
		</p>	
		
	</body>
</html>