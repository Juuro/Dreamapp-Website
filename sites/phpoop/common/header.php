<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  

    <title>Colored Lists | <?php echo $pageTitle ?></title>

    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
</head>

<body>

    <div id="page-wrap">

        <div id="header">

            <h1><a href="">Colored Lists</a></h1>

            <div id="control">

                <?php 
                    if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username']) 
                        && $_SESSION['LoggedIn']==1){ 
                ?> 
                                <p><a href="logout.php" class="button">Log out</a> <a href="account.php" class="button">Your Account</a></p> 
                <?php }else{ ?> 
                                <p><a class="button" href="signup.php">Sign up</a> &nbsp; <a class="button" href="login.php">Log in</a></p> 
                <?php } ?>

            </div>

        </div>