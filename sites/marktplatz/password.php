<?php 
    include_once "common/database.php"; 
    $pageTitle = "Reset Your Password"; 
    include_once "common/header.php";
?> 
<article id="main">
	<div id="loginbox">		
		<form action="db-interaction/users.php" method="post">
			<fieldset>
				<legend>Passwort zurücksetzen</legend>
                <input type="hidden" name="action" value="resetpassword" /> 
                <p>
                	<label for="mail">Bitte geben Sie die E-Mail-Adresse ein mit Sie sich angemeldet haben. Wir werden Ihnen einen Link schicken mit dem Sie Ihr Passwort zurücksetzen können!</label>
	                <input type="text" name="mail" id="mail" attribut="login" /> 
	            </p>
	            <p class="submit">
	                <input type="submit" name="reset" id="reset" value="Reset Password" class="button" />
	            </p>
            
            </fieldset>
        </form> 
	</div>	
</article>


<?php  
    include_once "common/footer.php"; 
?>