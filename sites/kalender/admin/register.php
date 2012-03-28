<?php
include "auth.php";
?>
<!DOCTYPE HTML>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <!--
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/custom.js" type="text/javascript"></script>
    -->
    <title>Kalender</title>  
    
    
</head>
<body>

<?php

include "../inc/db.php";

if (isset($_POST['active'])){
    $id = 0;
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $birthday_show = $_POST['birthday_show'];
    $reg_date = $_POST['reg_date'];
    $last_login_date = $_POST['last_login_date'];
    $status = $_POST['status'];
    $active = $_POST['active'];
    
    $sql = "INSERT INTO
                user
            VALUES
                ('".$id."',
                '".$username."',
                '".$password."',
                '".$email."',
                '".$firstname."',
                '".$lastname."',
                '".$birthday."',
                '".$birthday_show."',
                '".$reg_date."',
                '".$last_login_date."',
                '".$status."',
                '".$active."'
                )";
    $result = mysql_query($sql);
	if (!$result) {
		die('UngŸltige Abfrage: ' . mysql_error());
	}
	else {
		echo "Erfolgreich gespeichert!";
	}
}
else {

echo "<div id='stylized' class='myform'>";
	echo "<form id='form' method='post' action='register.php'>";
	echo "	<h1>Registrieren</h1>";
	echo "	<p>Einen neuen User anlegen</p>";
	echo "  <fieldset>";
    echo "  <label>Username";
    echo "  <span class='small'></span>";
    echo "  </label>";
	echo "	<input id='username' name='username' />";
	
    echo "  <label>Password";
    echo "  <span class='small'></span>";
    echo "  </label>";
	echo "	<input id='password' name='password' type='password' />";
	
    echo "  <label>E-Mail";
    echo "  <span class='small'></span>";
    echo "  </label>";
	echo "	<input id='email' name='email' />";
		
    echo "  <label>Vorname";
    echo "  <span class='small'></span>";
    echo "  </label>";
	echo "	<input id='firstname' name='firstname' />";
	
    echo "  <label>Nachname";
    echo "  <span class='small'></span>";
    echo "  </label>";
	echo "	<input id='lastname' name='lastname' />";
	
	/*
    echo "  <label>Geburtstag";
    echo "  <span class='small'>z.B. 13.09.1985</span>";
    echo "  </label>";
	echo "	<input id='birthday' name='birthday' />";
	
    echo "  <label>";
    echo "  <span class='small'>Geburtsag im Kalender anzeigen</span>";
    echo "  </label>";
	echo "	<input id='birthday_show' name='birthday_show' type='checkbox' value='1' />";
	*/
	
    echo "  <label>Status";
    echo "  <span class='small'></span>";
    echo "  </label>";
	echo "	<select id='status' name='status'>";
	echo "     <option value='admin'>Administrator</option>";
	echo "     <option value='user'>Benutzer</option>";
	echo "  </select>";
	
	echo "  <input id='reg_date' name='reg_date' type='hidden' value='".date("d.m.Y",time())."' />";
	echo "  <input id='last_login_date' name='last_login_date' type='hidden' value='' />";
	echo "  <input id='active' name='active' type='hidden' value='0' />";
	
    echo "	<button type='submit'>eintragen</button>";
	echo "  </fieldset>";
    echo "  <div class='spacer'></div>";
	
	echo "</form>";
	echo "</div>";
	
}
?>
</body>
</html>