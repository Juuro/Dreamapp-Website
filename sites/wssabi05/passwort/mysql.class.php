<?
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

	class databaseConnection {

		var $conn;
		var $mysqlHost="localhost";
		var $mysqlUser="web651";
		var $mysqlPwd="alumniboy";
		var $mysqlDb="usr_web651_1";
		var $mysqlTabelle="passwort";


		function disconnect() {
			mysql_close($this->conn);
		}

		function connect() {
			GLOBAL $mysqlHost,$mysqlUser,$mysqlPwd,$mysqlDb;
			$this->conn = mysql_connect($this->mysqlHost, $this->mysqlUser, $this->mysqlPwd) or die ("Konnte keine MySql Verbindung aufbauen");
			mysql_select_db($this->mysqlDb, $this->conn) or die ("Konnte die MySql-Datenbank nicht auswählen");
			return(true);
		}


		function query($query,$numrowsonly=false,$error="Es ist ein Fehler aufgetreten,benachrichtigen Sie bitte den Administrator") {
			$i=0;
			$enderg=Array();
			if(ereg("select",$query) || ereg("SELECT",$query)) {
				if(!$numrowsonly) {
					$this->result=Array();
					$ergebnis=mysql_query($query) or die($error);
					$this->numres=mysql_num_rows($ergebnis);
					while ($row = mysql_fetch_row($ergebnis, MYSQL_ASSOC)) {
							$enderg[]=$row;
						$i++;
					}
				} else {
					$ergebnis=mysql_query($query) or die($error);
					$enderg["zeilen"]=mysql_num_rows($ergebnis);
				}
			} else {
				$ergebnis=mysql_query($query) or die($error);
			}
			return $enderg;
		}


	}
?>