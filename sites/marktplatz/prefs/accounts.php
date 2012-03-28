<?php 
    include_once "common/database.php"; 
    $pageTitle = "Your Account";  
    
    if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1){  
    
		include_once "common/header.php";
		include_once "common/sidebar.php";
        include_once '../inc/class.users.inc.php';
        
        $users = new MarktPlatzUsers($db); 
        $user_data = new MarktPlatzUsers($db); 
 
        if(isset($_GET['email']) && $_GET['email']=="changed") 
        { 
            echo "<div id='main'><div class='message good'>Your email address " 
                . "has been changed.</div>"; 
        } 
        else if(isset($_GET['email']) && $_GET['email']=="failed") 
        { 
            echo "<div id='main'><div class='message bad'>There was an error " 
                . "changing your email address.</div>"; 
        }  
        else if(isset($_GET['password']) && $_GET['password']=="changed") 
        { 
            echo "<div id='main'><div class='message good'>Your password " 
                . "has been changed.</div>"; 
        } 
        elseif(isset($_GET['password']) && $_GET['password']=="nomatch") 
        { 
            echo "<div id='main'><div class='message bad'>The two passwords " 
                . "did not match. Try again!</div>"; 
        } 
        else if(isset($_GET['data']) && $_GET['data']=="changed") 
        { 
            echo "<div id='main'><div class='message good'>Your data " 
                . "has been changed.</div>"; 
        } 
        elseif(isset($_GET['data']) && $_GET['data']=="failed") 
        { 
            echo "<div id='main'><div class='message bad'>There was an error " 
                . "changing your data.</div>"; 
        }       
        else if(isset($_GET['delete']) && $_GET['delete']=="failed") 
        { 
            echo "<div id='main'><div class='message bad'>There was an error " 
                . "deleting your account.</div>"; 
        } 
        else {
        	echo "<div id='main'>";
        }
 
        //list($userID, $v) = $users->retrieveAccountInfo();
      
        list($id, $active, $mode, $username, $prename, $surname, $firm, $street, $housenumber, $plz, $city, $phone, $mail, $url, $paypal, $reg_date, $last_login_date, $ver_code) = $users->retrieveUserData(); 
        
?> 

	
	<div class="content">
		<div id="tab01" class="tab_content">
			<h2>Registrierungs-Details</h2>
	        <form method="post" action="db-interaction/users.php">
                <p>
		            <label for="mail">Change Email Address</label> 
		            <input type="hidden" name="userid" value="<?php echo $id ?>" />
		            <input type="hidden" name="action" value="changeemail" /> 
		            <input type="text" name="mail" id="mail" value="<?php echo $mail ?>" />
                	<input type="submit" name="change-email-submit" id="change-email-submit" value="Change Email" class="button" /> 
                </p>
	        </form>
 
	        <form method="post" action="db-interaction/users.php" id="change-password-form">
            	<p>
	                <label for="password">New Password</label> 
	                <input type="hidden" name="user-id" value="<?php echo $id ?>" />
	                <input type="hidden" name="v" value="<?php echo $ver_code ?>" /> 
	                <input type="hidden" name="action" value="changepassword" /> 
	                <input type="password" name="p" id="new-password" /> 
                </p>                
                <p>
	                <label for="password">Repeat New Password</label>
	                <input type="password" name="r" id="repeat-new-password" /> 
                	<input type="submit" name="change-password-submit" id="change-password-submit" value="Change Password" class="button" /> 
	            </p>
	        </form>
	 
	        <form method="post" action="db-interaction/users.php" id="delete-account-form">
            	<p>
	                <input type="hidden" name="userid" value="<?php echo $id ?>" /> 
	                <input type="hidden" name="action" value="deleteaccount" />
	                <input type="submit" name="delete-account-submit" id="delete-account-submit" value="Delete Account?" class="button" /> 
	            </p>
	        </form>
		</div>
		
		<div id="tab02" class="tab_content">
			<h2>Persönliche Daten</h2>
	        <form method="post" action="db-interaction/users.php" id="change-user-data-submit">
	            <input type="hidden" name="userid" value="<?php echo $id ?>" /> 
	            <input type="hidden" name="action" value="change-user-data-submit" />				
				<p><label for="prename">Vorname</label><input id="prename" name="prename" value="<?php echo $prename ?>" /></p>				
				<p><label for="surname">Nachname</label><input id="surname" name="surname" value="<?php echo $surname ?>" /></p>				
				<p><label for="firm">Firma</label><input id="firm" name="firm" value="<?php echo $firm ?>" /></p>				
				<p><label for="street">Straße</label><input id="street" name="street" value="<?php echo $street ?>" /></p>				
				<p><label for="housenumber">Hausnummer</label><input id="housenumber" name="housenumber" value="<?php echo $housenumber ?>" /></p>				
				<p><label for="plz">PLZ</label><input id="plz" name="plz" value="<?php echo $plz ?>" /></p>				
				<p><label for="city">Stadt</label><input id="city" name="city" value="<?php echo $city ?>" /></p>				
				<p><label for="phone">Telefon</label><input type="tel" id="phone" name="phone" value="<?php echo $phone ?>" /></p>				
				<p><label for="url">URL</label><input type="url" id="url" name="url" value="<?php echo $url ?>" /></p>				
				<p><label for="paypal">Paypal</label><input id="paypal" name="paypal" value="<?php echo $paypal ?>" /></p>				
                <input type="submit" name="change-user-data-submit" id="change-user-data-submit" class="button" /> 
	        </form>				
		</div>	
	</div>
</div>
 
<?php 
	}
    else{
        header("Location: ./"); 
        exit; 
    }
?> 
 <!--

<div class="clear"></div> 
-->
 
<?php
    include_once "common/footer.php"; 
?>