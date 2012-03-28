<?php
/*
#    FK PHP Passwort Version 1.0 - letzte �nderung 2000-10-28
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


	/* Einstellungen */
	$admin="Juuro"; // Name des Admins
	$pwd="Airmail"; // dazugeh�riges passwort
	$mysql_class="mysql.class.php"; // Weg zu Datei mysql.class.php
	require($mysql_class); // nicht ver�ndern ...
	
	$database=new databaseConnection;
	
	/* nichts mehr ver�ndern */
	$fehler_meldung="Zutritt verboten";
	if(!isset($PHP_AUTH_USER)) {
		Header("WWW-Authenticate: Basic realm=\"Admin-Bereich\"");
		Header("HTTP/1.0 401 Unauthorized");
		echo $fehler_meldung;
		exit;
	} else {
		
		if($PHP_AUTH_USER==$admin && $PHP_AUTH_PW==$pwd) {
			$loggedin=1;
		} else {
			Header("WWW-Authenticate: Basic realm=\"Admin-Bereich\"");
			Header("HTTP/1.0 401 Unauthorized");
			echo $fehler_meldung;
			exit;
		}
	}
	
	function showAdminFunctions() {
		GLOBAL $PHP_SELF,$database;
	?>
<html>
<form action="<?php echo $PHP_SELF ?>" method="post"><input type="hidden" name="action" value="adduser">
<b>Benutzer hinzuf�gen</b><br><br>
Benutzername: <input type=text name="user"><br>
Passwort:<input type=text name="upwd"><br><br>
<input type=submit value="hinzuf�gen">
</form><br><br><br>
<form action="<?php echo $PHP_SELF ?>" method="post"><input type="hidden" name="action" value="deluser">
<b>Benutzer (ev. l�schen)</b><br><br>
<?
$database=new databaseConnection;
$database->connect();
$res=$database->query("select username,passwort from ".$database->mysqlTabelle." order by username");
for($i=0;$i<count($res);$i++) {
	echo "Nutzername: ".$res[$i][username]."<br>Passwort: ".$res[$i][passwort]."<br><input type=checkbox name=\"user[]\" value=\"".$res[$i][username]."\"> l�schen?<br><br><br>";
}
$database->disconnect();
?>
<input type=submit value=" benutzer l�schen">
</form>
</html>
	<?
	}
	
	function adduser() {
		GLOBAL $user,$upwd,$database;
		$database=new databaseConnection;
		$database->connect();
		$database->query("insert into ".$database->mysqlTabelle." (username,passwort) values ('$user','$upwd')",false,"Der Benutzername ist doppelt");
		$database->disconnect();
		echo "<html>Befehl erfolgreich ausgef�hrt</html>";
	}
	
	function deluser() {
		GLOBAL $user,$database;
		$database=new databaseConnection;
		$database->connect();
		for($i=0;$i<count($user);$i++) {
			$database->query("delete from ".$database->mysqlTabelle." where username like '$user[$i]' LIMIT 1");
		}
		$database->disconnect();
		echo "<html>Befehl erfolgreich ausgef�hrt</html>";		
	}
	
	if($loggedin) {
		if(!isset($action))
			$action="showAdminFunctions";
		$action();
	}
?>