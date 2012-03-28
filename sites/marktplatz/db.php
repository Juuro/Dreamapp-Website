<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Switch the values below with your own info.

$server = '127.0.0.1';
$dbusername = 'sebastian-engel';
$dbpassword = 'jMuaeObS4a';
$db = 'sengel_marktplatz';

//define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']));


$mysqli = @new mysqli($server, $dbusername, $dbpassword, $db) or die('There was a problem connecting');
if (mysqli_connect_errno() == 0){
	$stmt = $mysqli->query("SELECT * FROM `user` ORDER BY `id`");
	//$stmt->execute();
	//$stmt->bind_result($id, $active, $mode, $username, $password, $prename, $surname, $firm, $street, $housenumber, $plz, $city, $phone, $mail, $url, $paypal, $reg_date, $last_login_date); 
	
	
	while($row = $stmt->fetch_object()){ 
		echo $row->username;
	}
}
else
{
    // Es konnte keine Datenbankverbindung aufgebaut werden
    echo 'Die Datenbank konnte nicht erreicht werden. Folgender Fehler trat auf: <span class="hinweis">' .mysqli_connect_errno(). ' : ' .mysqli_connect_error(). '</span>';
}

$mysqli->close();


?>