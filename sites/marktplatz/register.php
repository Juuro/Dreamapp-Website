<?php
	include_once "common/database.php"; 
    $pageTitle = "Register"; 
    include_once "common/header.php"; 
 
    if(!empty($_POST['username'])){ 
        include_once "inc/class.users.inc.php"; 
        $users = new MarktPlatzUsers($db); 
        echo $users->createAccount(); 
    }
    else{

?>
<div id="main">

	<div class="content">
		<h2>Registrieren</h2>
		<form id="form" method="post" action="register.php">
			<p><label for="username">Username</label><input id="username" name="username" /></p>
			
			<p><label for="prename">Vorname</label><input id="prename" name="prename" /></p>
			
			<p><label for="surname">Nachname</label><input id="surname" name="surname" /></p>
			
			<p><label for="firm">Firma</label><input id="firm" name="firm" /></p>
			
			<p><label for="street">Straße</label><input id="street" name="street" /></p>
			
			<p><label for="housenumber">Hausnummer</label><input id="housenumber" name="housenumber" /></p>
			
			<p><label for="plz">PLZ</label><input id="plz" name="plz" /></p>
			
			<p><label for="city">Stadt</label><input id="city" name="city" /></p>
			
			<p><label for="phone">Telefon</label><input type="tel" id="phone" name="phone" /></p>
			
			<p><label for="mail">Mail</label><input type="email "id="mail" name="mail" /></p>
			
			<p><label for="url">URL</label><input type="url" id="url" name="url" /></p>
			
			<p><label for="paypal">Paypal</label><input id="paypal" name="paypal" /></p>
			
			<input type="submit" name="submit" value="Eintragen" />
			<input type="reset" name="submit" value="Abbrechen" />
		</form>
	</div>
<div id="main">

<?php } ?>

<?php include_once "common/footer.php"; ?>