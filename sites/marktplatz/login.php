<?php 
    include_once "common/database.php"; 
    $pageTitle = "Login"; 
    include_once "common/header.php"; 
 
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])): 
?> 
<article id="main"> 
	<div class="content">
 
        <p>You are currently <strong>logged in.</strong></p> 
        <p><a href="logout.php">Log out</a></p> 
<?php 
    elseif(!empty($_POST['username']) && !empty($_POST['password'])): 
        include_once 'inc/class.users.inc.php'; 
        $users = new MarktPlatzUsers($db); 
        if($users->accountLogin()===TRUE): 
            echo "<meta http-equiv='refresh' content='0;./'>"; 
            exit; 
        else: 
?> 
<article id="main"> 
	<div id="loginbox">		
		<form action="login.php" method="post">
			<fieldset>
				<legend>Login</legend>
				<p>
					<label for="username">Username</label><br />
					<input type="text" attribut="login" name="username" id="username" />
				</p>
				<p>
					<label for="password">Passwort</label><br />
					<input type="password" attribut="login" name="password" id="password" />
				</p>

				<p class="forgetmenot">
					<input name="rememberme" type="checkbox" id="rememberme" value="true" tabindex="90" /><label for="rememberme"> Passwort speichern</label>
				</p>
				<p class="submit">
					<input type="submit" value="Anmelden" id="login" class="button" />
				</p>
			</fieldset>
		</form>

		<p id="nav">
			<a href="password.php" title="Passwortfundb&uuml;ro">Passwort vergessen?</a>
		</p>			
	</div>
<?php 
        endif; 
    else: 
?> 
<article id="main"> 

	<div id="loginbox">		
		<form action="login.php" method="post">
			<fieldset>
				<legend>Login</legend>
				<p>
					<label for="username">Username</label><br />
					<input type="text" attribut="login" name="username" id="username" />
				</p>
				<p>
					<label for="password">Passwort</label><br />
					<input type="password" attribut="login" name="password" id="password" />
				</p>

				<p class="forgetmenot">
					<input name="rememberme" type="checkbox" id="rememberme" value="true" tabindex="90" /><label for="rememberme"> Passwort speichern</label>
				</p>
				<p class="submit">
					<input type="submit" value="Anmelden" id="login" class="button" />
				</p>
			</fieldset>
			
			<p id="nav">
				<a href="password.php" title="Passwortfundb&uuml;ro">Passwort vergessen?</a>
			</p>	
		</form>		
		
		
		<!--
<p id="nav">
				<a href="password.php" title="Passwortfundb&uuml;ro">Passwort vergessen?</a>
			</p>
-->
	</div>
	
	
	
<?php 
    endif; 
?> 
</article>

<?php 
    include_once "common/footer.php"; 
?>