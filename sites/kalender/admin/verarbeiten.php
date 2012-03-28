<?php
    include "auth.php";
    include "../inc/db.php";
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
<!--


	
<script type="text/javascript">var client_id = 1;</script>
		<noscript>
		<p><img alt="" src="http://stats.byspirit.ro/image.php?client_id=1" width="1" height="1" /></p>
		</noscript>
	
-->	



	<p id="links">
		<a href="../" title="Haben Sie sich Verlaufen?">&larr; Zurück zum Kalender</a> &bull; <a href="./">Admin Interface</a>
	</p>
	<p id="logoff">
		Angemeldet als <?php echo $_SESSION['name']; ?> &bull; <a href="logout.php">abmelden</a>
	</p>
		
<?php
    
    $a_monat = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
	$a_wtag = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
	
	
	if(isset($_GET['monat'])){
        $tag = $_GET['tag'];
        $monat = $_GET['monat'];
        $jahr = $_GET['jahr'];        
    	$timestamp = (int)mktime(0, 0, 0, $monat, $tag, $jahr);
	}
	else {
        $timestamp = (int)time();  
        $monat = (int)date("m",$timestamp);
	}
    	
    $jahr = date("Y",$timestamp);
    $tag = (int)date("d",$timestamp);
	$wtag = date ("w",$timestamp);
	$mtag = date("t",$timestamp);	
	$vergleichsdate = date("Ymd",$timestamp);	
	
	//oeffnet wrap
	echo "<div id='wrap'>";
	
	
	$start_date = $_POST["start_date"];
	$end_date = $_POST["end_date"];
	$stime = $_POST["stime"];
	$etime = $_POST["etime"];
	$titel = $_POST["titel"];
	$notizen = $_POST["notizen"];
	
	//echo $edate.$stime.$etime.$titel.$notizen;
	
	$sdate = $start_date." ".$stime.":00";
	$sdate = strtotime($sdate);
    //$sdate = preg_replace("#([0-9]{2})\.([0-9]{2})\.([0-9]{4}) (.*)#","\\3-\\2-\\1 \\4",$sdate);
	$edate = $end_date." ".$etime.":00";
	$edate = strtotime($edate);
    //$edate = preg_replace("#([0-9]{2})\.([0-9]{2})\.([0-9]{4}) (.*)#","\\3-\\2-\\1 \\4",$edate);
    
   //header
    
    echo "<div id='stylized' class='myform'>";
    echo "<h1>Erfolgreich gespeichert!</h1>";
    echo "Folgende Daten wurden erfolgreich in den Kalender eingetragen:";
    echo "<br /><br />";
    //hier noch alle anderen Daten!!!
    echo "Ankunft: ".date("d.m.Y",$sdate)."<br />";
    echo "Abreise: ".date("d.m.Y",$edate)."<br />";
    echo "<br /><br />";
    echo "<a href='../index.php'>zum aktuellen Monat</a><br />";    
    
    echo "<a href='../index.php?monat=".date("n",$sdate)."&jahr=".date("Y",$sdate)."'>zum Monat der Ankunft</a>";    
	
	echo "</div>";
	
	//Datenbankverbindung Server
	/*
    $mysqlhost="127.0.0.1"; // MySQL-Host angeben
    $mysqluser="sebastian-engel"; // MySQL-User angeben
    $mysqlpwd="jMuaeObS4a"; // Passwort angeben
    $mysqldb="sengel_kalender_beta"; //Gewuenschte Datenbank angeben
    $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die("Verbindungsversuch fehlgeschlagen");
    mysql_select_db($mysqldb, $connection) or die("Konnte die Datenbank nicht waehlen.");    
    */
    $sql = "INSERT INTO 
                ereignisse (title, sdate, edate, notizen) 
            VALUES (
                '".$titel."',
                '".$sdate."',
                '".$edate."',
                '".$notizen."
                ')";
    $result = mysql_query($sql);
	if (!$result) {
		die('Ungültige Abfrage: ' . mysql_error());
	}

	mysql_close($link);
	
	include "../inc/footer.php";
	//schliesst wrap
	echo "</div>";
    
?>
		
		




</body>
</html>