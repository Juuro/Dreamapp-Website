<?php

class MarktPlatzUsers {
	/** 
     * The database object  
     * 
     * @var object 
     */ 
    private $_db; 
 
    /** 
     * Checks for a database object and creates one if none is found 
     * 
     * @param object $db 
     * @return void 
     */ 
    public function __construct($db=NULL) 
    { 
        if(is_object($db)) 
        { 
            $this->_db = $db; 
        } 
        else 
        { 
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME; 
            $this->_db = new PDO($dsn, DB_USER, DB_PASS); 
        } 
    }
    
 
    /** 
     * Checks and inserts a new account email into the database 
     * 
     * @return string    a message indicating the action status 
     */ 
	public function createAccount() 
    { 
        $id = 0;
	    $active = 0;
	    $mode = 1; 
	    // 0 = admin, 1 = retailer
	    $username = trim($_POST['username']);
	    $prename = trim($_POST['prename']);
	    $surname = trim($_POST['surname']);
	    $firm = trim($_POST['firm']);
	    $street = trim($_POST['street']);
	    $housenumber = trim($_POST['housenumber']);
	    $plz = trim($_POST['plz']);
	    $city = trim($_POST['city']);
	    $phone = trim($_POST['phone']);
	    $mail = trim($_POST['mail']);
	    $url = trim($_POST['url']);
	    $paypal = trim($_POST['paypal']);
	    $reg_date = time();
	    $last_login_date;
        $ver = sha1(time()); 
        
        $sql = "SELECT COUNT(mail) AS theCount 
                FROM users
                WHERE mail=:email"; 
        
        if($stmt = $this->_db->prepare($sql)) { 
            $stmt->bindParam(":email", $mail, PDO::PARAM_STR); 
            $stmt->execute(); 
            $row = $stmt->fetch(); 
            if($row['theCount']!=0) { 
                return "<h2> Error </h2>" 
                    . "<p> Sorry, that email is already in use. " 
                    . "Please try again. </p>"; 
            } 
            if(!$this->sendVerificationEmail($mail, $username, $ver)) { 
                return "<h2> Error </h2>" 
                    . "<p> There was an error sending your" 
                    . " verification email. Please " 
                    . "<a href=\"mailto:info@marktplatz.cc\">contact " 
                    . "us</a> for support. We apologize for the " 
                    . "inconvenience. </p>"; 
            } 
            $stmt->closeCursor(); 
        }
	    
	    $sql = 'INSERT INTO users(active, mode, username, prename, surname, firm, street, housenumber, plz, city, phone, mail, url, paypal, reg_date, last_login_date, ver_code) 
	    		VALUES(:active, :mode, :username, :prename, :surname, :firm, :street, :housenumber, :plz, :city, :phone, :mail, :url, :paypal, :reg_date, :last_login_date, :ver)';
	    
	    if($entry = $this->_db->prepare($sql)){
	    	$entry->bindParam(":active", $active);
	    	$entry->bindParam(":mode", $mode);
	    	$entry->bindParam(":username", $username);
	    	$entry->bindParam(":prename", $prename);
	    	$entry->bindParam(":surname", $surname);
	    	$entry->bindParam(":firm", $firm);
	    	$entry->bindParam(":street", $street);
	    	$entry->bindParam(":housenumber", $housenumber);
	    	$entry->bindParam(":plz", $plz);
	    	$entry->bindParam(":city", $city);
	    	$entry->bindParam(":phone", $phone);
	    	$entry->bindParam(":mail", $mail);
	    	$entry->bindParam(":url", $url);
	    	$entry->bindParam(":paypal", $paypal);
	    	$entry->bindParam(":reg_date", $reg_date);
	    	$entry->bindParam(":last_login_date", $last_login_date);
            $entry->bindParam(":ver", $ver); 
	    	$entry->execute();
	    	$entry->closeCursor();	
	    	
	    	return "Your account was successfully created with the username <strong>".$username."</strong>. Check you email!";
	    }
	    else {
	    	return "<h2> Error </h2><p> Couldn't insert the user information into the database. </p>"; 
	    }
	}
	
	/** 
     * Sends an email to a user with a link to verify their new account 
     * 
     * @param string $email    The user's email address 
     * @param string $ver    The random verification code for the user 
     * @return boolean        TRUE on successful send and FALSE on failure 
     */ 
    function sendVerificationEmail($email, $username, $ver) 
    { 
        $e = sha1($email); // For verification purposes 
        $to = trim($email); 
     
        $subject = "[Marktplatz.cc] Please Verify Your Account"; 
 
        $headers = <<<MESSAGE
From: Marktplatz.cc <donotreply@i-wars.net>
Content-Type: text/plain;
MESSAGE;
 
 
        $msg = <<<EMAIL
You have a new account at Marktplatz.cc!

To get started, please activate your account and choose a password by following the link below.

Your Username: $username

Activate your account: http://www.vollrot.de/marktplatz/accountverify.php?v=$ver&e=$e

If you have any questions, please contact help@marktplatz.cc.

--

Thanks!

www.marktplatz.cc
EMAIL;
 
        return mail($to, $subject, $msg, $headers); 
    } 
	
	/** 
     * Checks credentials and verifies a user account 
     * 
     * @return array    an array containing a status code and status message 
     */ 
    public function verifyAccount() 
    { 
        $sql = "SELECT username
                FROM users
                WHERE ver_code=:ver
                AND SHA1(mail)=:mail
                AND active=0"; 
 
        if($stmt = $this->_db->prepare($sql))
        { 
            $stmt->bindParam(':ver', $_GET['v'], PDO::PARAM_STR); 
            $stmt->bindParam(':mail', $_GET['e'], PDO::PARAM_STR); 
            $stmt->execute(); 
            $row = $stmt->fetch(); 
            if(isset($row['username'])) 
            { 
                // Logs the user in if verification is successful 
                $_SESSION['Username'] = $row['username']; 
                $_SESSION['LoggedIn'] = 1; 
            } 
            else 
            { 
                return array(4, "<h2>Verification Error</h2>\n" 
                    . "<p>This account has already been verified. " 
                    . "Did you <a href=\"password.php\">forget " 
                    . "your password?</a>"); 
            } 
            $stmt->closeCursor(); 
 
            // No error message is required if verification is successful 
            return array(0, NULL); 
        } 
        else 
        { 
            return array(2, "<h2>Error</h2>\n<p>Database error.</p>"); 
        } 
    }
     
    
    /** 
     * Changes the user's password 
     * 
     * @return boolean    TRUE on success and FALSE on failure 
     */ 
    public function updatePassword() 
    { 
        if(isset($_POST['p']) 
        && isset($_POST['r']) 
        && $_POST['p']==$_POST['r']) 
        { 
            $sql = "UPDATE users 
                    SET password=sha1(:pass), active=1 
                    WHERE ver_code=:ver 
                    LIMIT 1"; 
            try 
            { 
                $stmt = $this->_db->prepare($sql); 
                $stmt->bindParam(":pass", $_POST['p'], PDO::PARAM_STR); 
                $stmt->bindParam(":ver", $_POST['v'], PDO::PARAM_STR); 
                $stmt->execute(); 
                $stmt->closeCursor(); 
 
                return TRUE; 
            } 
            catch(PDOException $e) 
            { 
                return FALSE; 
            } 
        } 
        else 
        { 
            return FALSE; 
        } 
    }
    
    
    
    /** 
     * Checks credentials and logs in the user 
     * 
     * @return boolean    TRUE on success and FALSE on failure 
     */ 
    public function accountLogin() 
    { 
        $sql = "SELECT username 
                FROM users 
                WHERE username=:user 
                AND password=sha1(:pass) 
                AND active=1
                LIMIT 1"; 
        try 
        { 
            $stmt = $this->_db->prepare($sql); 
            $stmt->bindParam(':user', $_POST['username'], PDO::PARAM_STR); 
            $stmt->bindParam(':pass', $_POST['password'], PDO::PARAM_STR); 
            $stmt->execute(); 
            if($stmt->rowCount()==1) 
            { 
                $_SESSION['Username'] = htmlentities($_POST['username'], ENT_QUOTES); 
                $_SESSION['LoggedIn'] = 1; 
                return TRUE; 
            } 
            else 
            { 
                return FALSE; 
            } 
        } 
        catch(PDOException $e) 
        { 
            return FALSE; 
        } 
    } 
    
    
    /** 
     * Retrieves the ID and verification code for a user 
     * 
     * @return mixed    an array of info or FALSE on failure 
     */ 
    /*
public function retrieveAccountInfo() 
    { 
        $sql = "SELECT id, ver_code 
                FROM users 
                WHERE username=:user"; 
        try 
        { 
            $stmt = $this->_db->prepare($sql); 
            $stmt->bindParam(':user', $_SESSION['Username'], PDO::PARAM_STR); 
            $stmt->execute(); 
            $row = $stmt->fetch(); 
            $stmt->closeCursor(); 
            return array($row['id'], $row['ver_code']); 
        } 
        catch(PDOException $e) 
        { 
            return FALSE; 
        } 
    } 
*/
    
    public function retrieveUserData() 
    { 
        $sql = "SELECT id, active, mode, username, prename, surname, firm, street, housenumber, plz, city, phone, mail, url, paypal, reg_date, last_login_date, ver_code 
                FROM users 
                WHERE username=:user"; 
        try 
        { 
            $stmt = $this->_db->prepare($sql); 
            $stmt->bindParam(':user', $_SESSION['Username'], PDO::PARAM_STR); 
            $stmt->execute(); 
            $row = $stmt->fetch(); 
            $stmt->closeCursor(); 
            return array($row['id'], $row['active'], $row['mode'], $row['username'], $row['prename'], $row['surname'], $row['firm'], $row['street'], $row['housenumber'], $row['plz'], $row['city'], $row['phone'], $row['mail'], $row['url'], $row['paypal'], $row['reg_date'], $row['last_login_date'], $row['ver_code']); 
        } 
        catch(PDOException $e) 
        { 
            return FALSE; 
        } 
    }
	
	
    
    /** 
     * Changes a user's email address 
     * 
     * @return boolean    TRUE on success and FALSE on failure 
     */ 
    public function updateEmail() 
    { 
        $sql = "UPDATE users 
                SET mail=:mail 
                WHERE id=:id 
                LIMIT 1"; 
        try 
        { 
            $stmt = $this->_db->prepare($sql); 
            $stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR); 
            $stmt->bindParam(':id', $_POST['userid'], PDO::PARAM_INT); 
            $stmt->execute(); 
            $stmt->closeCursor(); 
     
            return TRUE; 
        } 
        catch(PDOException $e) 
        { 
            return FALSE; 
        } 
    }
    
    public function updateUserData() 
    { 
        $sql = "UPDATE users 
                SET prename=:prename, surname=:surname, firm=:firm, street=:street, housenumber=:housenumber, plz=:plz, city=:city, phone=:phone, url=:url, paypal=:paypal  
                WHERE id=:id 
                LIMIT 1"; 
        try 
        { 
            $stmt = $this->_db->prepare($sql);  
            $stmt->bindParam(':prename', $_POST['prename'], PDO::PARAM_STR);
            $stmt->bindParam(':surname', $_POST['surname'], PDO::PARAM_STR); 
            $stmt->bindParam(':firm', $_POST['firm'], PDO::PARAM_STR); 
            $stmt->bindParam(':street', $_POST['street'], PDO::PARAM_STR); 
            $stmt->bindParam(':housenumber', $_POST['housenumber'], PDO::PARAM_STR); 
            $stmt->bindParam(':plz', $_POST['plz'], PDO::PARAM_STR); 
            $stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':url', $_POST['url'], PDO::PARAM_STR);
            $stmt->bindParam(':paypal', $_POST['paypal'], PDO::PARAM_STR);
            
            $stmt->bindParam(':id', $_POST['userid'], PDO::PARAM_INT); 
            $stmt->execute(); 
            $stmt->closeCursor(); 
     
            return TRUE; 
        } 
        catch(PDOException $e) 
        { 
            return FALSE; 
        } 
    }
    
    /** 
     * Deletes an account and all associated lists and items 
     * 
     * @return void 
     */ 
    public function deleteAccount() 
    { 
        if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1) 
        {              
            // Delete the user 
            $sql = "DELETE FROM users 
                    WHERE id=:user 
                    AND username=:username"; 
            try 
            { 
                $stmt = $this->_db->prepare($sql); 
                $stmt->bindParam(":user", $_POST['userid'], PDO::PARAM_INT); 
                $stmt->bindParam(":username", $_SESSION['Username'], PDO::PARAM_STR); 
                $stmt->execute(); 
                $stmt->closeCursor(); 
            } 
            catch(PDOException $e) 
            { 
                die($e->getMessage()); 
            } 
 
            // Destroy the user's session and send to a confirmation page 
            unset($_SESSION['LoggedIn'], $_SESSION['Username']); 
            header("Location: /gone.php"); 
            exit; 
        } 
        else 
        { 
            header("Location: /accounts.php?delete=failed"); 
            exit; 
        } 
    } 
    
    /** 
     * Resets a user's status to unverified and sends them an email 
     * 
     * @return mixed    TRUE on success and a message on failure 
     */ 
    public function resetPassword() 
    { 	    	
        $ver = sha1(time());
        $sql = "UPDATE users 
                SET active=0, ver_code=:ver
                WHERE mail=:mail 
                LIMIT 1"; 
        try 
        { 
            $stmt = $this->_db->prepare($sql); 
            $stmt->bindParam(":mail", $_POST['mail'], PDO::PARAM_STR); 
            $stmt->bindParam(":ver", $ver, PDO::PARAM_STR); 
            $stmt->execute(); 
            $stmt->closeCursor(); 
        } 
        catch(PDOException $e) 
        { 
            return $e->getMessage(); 
        } 
 
        // Send the reset email 
        if(!$this->sendResetEmail($_POST['mail'], $ver)) 
        { 
            return "Sending the email failed!"; 
        } 
        return TRUE; 
    }
    
    /** 
     * Sends a link to a user that lets them reset their password 
     * 
     * @param string $email    the user's email address 
     * @param string $ver    the user's verification code 
     * @return boolean        TRUE on success and FALSE on failure 
     */ 
    private function sendResetEmail($email, $ver) 
    { 
        $e = sha1($email); // For verification purposes 
        $to = trim($email); 
     
        $subject = "[Marktplatz.cc] Request to Reset Your Password";
 
        $headers = <<<MESSAGE
From: Marktplatz.cc <donotreply@marktplatz.cc>
Content-Type: text/plain;
MESSAGE;
 
        $msg = <<<EMAIL
We just heard you forgot your password! Bummer! To get going again,
head over to the link below and choose a new password.

Follow this link to reset your password:
http://www.vollrot.de/marktplatz/resetpassword.php?v=$ver&e=$e

If you have any questions, please contact info@coloredlists.com.

--
Thanks!

EMAIL;
 
        return mail($to, $subject, $msg, $headers); 
    }
    
}

?>