<?php 
    include_once "common/database.php"; 
    $pageTitle = "Your Account"; 

    
    if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1){  
    	include_once "common/header.php";    
        include_once 'inc/class.users.inc.php';
        
        $users = new MarktPlatzUsers($db); 
        $user_data = new MarktPlatzUsers($db); 
        
        echo "<div id='main'>";
 
        if(isset($_GET['email']) && $_GET['email']=="changed") 
        { 
            echo "<div class='message good'>Your email address " 
                . "has been changed.</div>"; 
        } 
        else if(isset($_GET['email']) && $_GET['email']=="failed") 
        { 
            echo "<div class='message bad'>There was an error " 
                . "changing your email address.</div>"; 
        }  
        else if(isset($_GET['password']) && $_GET['password']=="changed") 
        { 
            echo "<div class='message good'>Your password " 
                . "has been changed.</div>"; 
        } 
        elseif(isset($_GET['password']) && $_GET['password']=="nomatch") 
        { 
            echo "<div class='message bad'>The two passwords " 
                . "did not match. Try again!</div>"; 
        } 
        else if(isset($_GET['data']) && $_GET['data']=="changed") 
        { 
            echo "<div class='message good'>Your data " 
                . "has been changed.</div>"; 
        } 
        elseif(isset($_GET['data']) && $_GET['data']=="failed") 
        { 
            echo "<div class='message bad'>There was an error " 
                . "changing your data.</div>"; 
        }       
        else if(isset($_GET['delete']) && $_GET['delete']=="failed") 
        { 
            echo "<div class='message bad'>There was an error " 
                . "deleting your account.</div>"; 
        }
 
        //list($userID, $v) = $users->retrieveAccountInfo();
      
        list($id, $active, $mode, $username, $prename, $surname, $firm, $street, $housenumber, $plz, $city, $phone, $mail, $url, $paypal, $reg_date, $last_login_date, $ver_code) = $users->retrieveUserData(); 
        
?>


<?php include_once "common/sidebar.php"; ?>

<div id="content">
	bla
</div>















<?php 
	}
    else{
        header("Location: ./"); 
        exit; 
    }
?> 

 
<?php
    include_once "common/footer.php"; 
?>