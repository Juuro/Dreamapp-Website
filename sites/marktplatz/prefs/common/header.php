<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Marktplatz.cc | <?php echo $pageTitle ?></title>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
    
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

	<script type="text/javascript" src="../js/jquery.js"></script>	
	<script type="text/javascript" src="../js/custom.js"></script>	
	<script type="text/javascript" src="../js/getUrlParam.js"></script>
	<!--[if IE]>
		<script src="../../html5.js"></script>	
	<![endif]-->
	
</head>

<body>

	

    <div id="page-wrap">

        <header id="header">
        	<p id="backto">
				<a href="../" title="Haben Sie sich Verlaufen?">← Home</a>
			</p>

			<div id="control">
			
			    <?php 
			        if(isset($_SESSION['LoggedIn']) && isset($_SESSION['Username']) && $_SESSION['LoggedIn']==1){ 
			    ?> 
			    				
			                    <p>Angemeldet als <span class="username"><?php echo $_SESSION['Username'] ?></span> &bull; <a href="../logout.php" class="button">Log out</a> &bull; <a href="index.php" class="button">Your Account</a></p> 
			    <?php }else{ ?> 
			                    <p><a class="button" href="register.php">Register</a> &bull; <a class="button" href="login.php">Log in</a></p> 
			    <?php } ?>
			
			</div>
        </header>