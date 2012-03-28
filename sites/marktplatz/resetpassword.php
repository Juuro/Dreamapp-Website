<?php 
    include_once "common/database.php"; 
 
    if(isset($_GET['v']) && isset($_GET['e'])) 
    { 
        include_once "inc/class.users.inc.php"; 
        $users = new MarktPlatzUsers($db); 
        $ret = $users->verifyAccount(); 
    } 
    elseif(isset($_POST['v'])) 
    { 
        include_once "inc/class.users.inc.php"; 
        $users = new MarktPlatzUsers($db); 
        $status = $users->updatePassword() ? "changed" : "failed"; 
        header("Location: /accounts.php?password=$status"); 
        exit; 
    } 
    else 
    { 
        header("Location: /login.php"); 
        exit; 
    } 
 
    $pageTitle = "Reset Your Password"; 
    include_once "common/header.php"; 

    include_once("common/sidebar.php"); 
 
    if(isset($ret[0])): 
        echo isset($ret[1]) ? $ret[1] : NULL; 
 
        if($ret[0]<3): 
?> 

<article id="main"> 
	<div id="loginbox">	
        <form action="accountverify.php" method="post">
			<fieldset>
				<legend>Login</legend>
				<p> 
                	<label for="p">Choose a New Password:</label> 
               		<input type="password" name="p" id="p" attribut="login" />
               	</p>
               	<p>               
	                <label for="r">Re-Type Password:</label> 
    	            <input type="password" name="r" id="r" attribut="login" /><br /> 
    	        </p>
                <p>
                	<input type="hidden" name="v" value="<?php echo $_GET['v'] ?>" /> 
	                <input type="submit" name="verify" id="verify" value="Reset Your Password" class="button" /> 
	           	</p>
            </div> 
        </form> 
	</div>
</articel>        
 
<?php 
        endif; 
    else: 
        echo '<meta http-equiv="refresh" content="0;/">'; 
    endif; 
 
    include_once 'common/footer.php'; 
?>