<?php

    //Datenbankverbindung lokal und Server
    
    //$db = @new mysqli('127.0.0.1', 'sebastian-engel', 'jMuaeObS4a', 'sengel_kalender_beta');
    
    $hostname = "127.0.0.1";
    $database = "sengel_kalender";
    $username = "sebastian-engel";
    $password = "jMuaeObS4a";

    $link = mysql_connect($hostname,$username,$password);
    
    mysql_select_db($database);
    
    if (mysqli_connect_errno()) {
        die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
	}
    
?>