<?php
if(isset($_GET['section']) AND ("auslese" == $_GET['section'])) {
	$mysql_class="passwort/mysql.class.php"; // Weg zu Datei mysql.class.php
	require_once($mysql_class); // nicht verändern ...
	$fehler_meldung="Man benötigt eine gültige ID + dazupassendes Passwort um diesen Teil der Homepage zu besuchen";
	$nameRestricted="Admin-Bereich"; // Name des geschützten Bereichs
	
	// MySQL
	//
	// Die folgenden Einstellungen müssen in der Datei mysql.class.php vorgenommen werden!!!!
	//
	// Konfigurations-Variablen
	//
	// var $mysqlHost="localhost"; // der mysql-host
	// var $mysqlUser="web651"; // ein mysql-benutzername
	// var $mysqlPwd="alumniboy"; // dazupassendes Passwort
	// var $mysqlDb="usr_web651_1"; // datenbank in der die tabelle gespeichert wird
	// var $mysqlTabelle="passwort"; // Mysql-Tabelle

	/* Eigentliches Script - nichts mehr ändern */
	$database=new databaseConnection;
	$database->connect();
	
	
		if(!isset($PHP_AUTH_USER)) {
		Header("WWW-Authenticate: Basic realm=\"$nameRestricted\"");
		Header("HTTP/1.0 401 Unauthorized");
		echo $fehler_meldung;
		exit;
	} else {
		$log=$database->query("select id from ".$database->mysqlTabelle." where username like '$PHP_AUTH_USER' and passwort like '$PHP_AUTH_PW'",true);
		
		if($log[zeilen] > 0) {
			$loggedin=1;
		} else {
			Header("WWW-Authenticate: Basic realm=\"$nameRestricted\"");
			Header("HTTP/1.0 401 Unauthorized");
			echo $fehler_meldung;
			exit;
		}
	}
	
	$database->disconnect();	
	}

 if(isset($_GET['section']) AND ("pic_upload" == $_GET['section'])) {
	$mysql_class="passwort/mysql.class.php"; // Weg zu Datei mysql.class.php
	require_once($mysql_class); // nicht verändern ...
	$fehler_meldung="Man benötigt eine gültige ID + dazupassendes Passwort um diesen Teil der Homepage zu besuchen";
	$nameRestricted="Admin-Bereich"; // Name des geschützten Bereichs
	
	// MySQL
	//
	// Die folgenden Einstellungen müssen in der Datei mysql.class.php vorgenommen werden!!!!
	//
	// Konfigurations-Variablen
	//
	// var $mysqlHost="localhost"; // der mysql-host
	// var $mysqlUser="web651"; // ein mysql-benutzername
	// var $mysqlPwd="alumniboy"; // dazupassendes Passwort
	// var $mysqlDb="usr_web651_1"; // datenbank in der die tabelle gespeichert wird
	// var $mysqlTabelle="passwort"; // Mysql-Tabelle

	/* Eigentliches Script - nichts mehr ändern */
	$database=new databaseConnection;
	$database->connect();
	
	
		if(!isset($PHP_AUTH_USER)) {
		Header("WWW-Authenticate: Basic realm=\"$nameRestricted\"");
		Header("HTTP/1.0 401 Unauthorized");
		echo $fehler_meldung;
		exit;
	} else {
		$log=$database->query("select id from ".$database->mysqlTabelle." where username like '$PHP_AUTH_USER' and passwort like '$PHP_AUTH_PW'",true);
		
		if($log[zeilen] > 0) {
			$loggedin=1;
		} else {
			Header("WWW-Authenticate: Basic realm=\"$nameRestricted\"");
			Header("HTTP/1.0 401 Unauthorized");
			echo $fehler_meldung;
			exit;
		}
	}
	
	$database->disconnect();		
	}
	
	//aktualisieren um erstellten Ordner anzeigen zu können
	if ($erstellt = "yes") {
	header ("Pragma:no-cache");
	header("Cache-Control:Private,no-store,no-cache,must-revalidate");
	}
	
    error_reporting(E_ALL);
    include "config.php"; // die Konfigurationsdateien lesen.
	
		
		
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n";
    echo "         \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
    echo "<html>\n";
    echo "    <head>\n";
    echo "        <title>Nichts ist erotischer als Erfolg!</title>\n";
    echo "        <link rel=\"SHORTCUT ICON\" href=\"/grfx/favicon.ico\">\n";
    echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />\n";
    echo "        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />\n";
	echo "		  <META NAME=\"language\" CONTENT=\"de\" />\n";
	echo "		  <META NAME=\"author\"      CONTENT=\"Sebastian Engel\" />\n";
	echo "		  <META NAME=\"publisher\"   CONTENT=\"Sebastian Engel\" />\n";
	echo "		  <META NAME=\"copyright\"   CONTENT=\"Sebastian Engel\" />\n";
	echo "		  <META NAME=\"keywords\"    CONTENT=\"Münzen, erdinger, Siemens s65, firmware, gulli, sperrmüll, koch, himmel, ikea, mp3 Player, Mainzelmännchen, Steckdose, Creative, die ärzte, sportfreunde stiller, h-blockx, beatsteaks, casio, rolex, nec, deutsche post, joghurt, landliebe, julia, ati, catalyst, 2005, jesus, peugeot, mamma mia, stuttgart 21, deutsche bahn, ferienticket, handy, s65 o2 online\" />\n";
	echo "		  <META NAME=\"page-topic\"  CONTENT=\"Hundehaltung, Erziehung von Hunden\" />\n";
	echo "		  <META NAME=\"page-type\"   CONTENT=\"Homepage\" />\n";
	echo "		  <META NAME=\"audience\"    CONTENT=\"Hundehalter, Fans\" />\n";
	echo "		  <META NAME=\"robots\"      CONTENT=\"index,follow\" />\n";

    echo "    </head>\n";
    echo "    <body>\n";

    echo "        <div id=\"root\">\n"; // ganz oberer Div-Holder
    echo "            <div id=\"banner\">\n"; // banner
    include "banner.php";
    echo "            </div>\n";
    echo "            <div id=\"links\">\n"; // linkes Menu
    include "menu.php";
    echo "            </div>\n";
    echo "            <div id=\"mitte\">\n"; // In der Mitte der Inhalt
    include "inhalt.php";
    echo "            </div>\n";
    echo "			  <div id=\"rechts\">\n"; // Rechte Infoseite
    include "right.php";
    echo "            </div>\n";
    echo "            <br style=\"clear:both;\" />\n"; // css-float beenden
    echo "       </div>\n";

    echo "    </body>\n";
    echo "</html>\n";
?>