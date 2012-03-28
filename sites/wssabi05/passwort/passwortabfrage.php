<?php
/*
#    FK PHP Passwort Version 1.0 - letzte Änderung 2000-10-28
# 
#
#    Copyright (C) 2000 Florian Krismer (fkrismer@gmx.at, http://fk.de.st)
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/ 

	/* Konfiguration */
	
	// Allgemein
	
	$mysql_class="mysql.class.php"; // Weg zu Datei mysql.class.php
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
	
?>