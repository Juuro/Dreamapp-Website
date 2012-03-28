<?php 
    include_once "common/database.php"; 
    $pageTitle = "Verify Your Account"; 
    include_once "common/header.php"; 
 
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
        $ret = $users->updatePassword(); 
    } 
    else 
    { 
        header("Location: register.php"); 
        exit; 
    } 
 
    if(isset($ret[0])): 
        echo isset($ret[1]) ? $ret[1] : NULL; 
 
        if($ret[0]<3): 
?> 
 
        <h2>Choose a Password</h2> 
 
        <form method="post" action="accountverify.php"> 
            <div> 
                <label for="p">Choose a Password:</label> 
                <input type="password" name="p" id="p" /><br />                 
                <label for="r">Re-Type Password:</label> 
                <input type="password" name="r" id="r" /><br /> 
                <input type="hidden" name="v" value="<?php echo $_GET['v'] ?>" /> 
                <input type="submit" name="verify" id="verify" value="Verify Your Account" /> 
            </div> 
        </form> 
 
<?php 
        endif; 
    else: 
        echo '<meta http-equiv="refresh" content="0;./index.php">'; 
    endif; 
 
    include_once 'common/footer.php'; 
?>