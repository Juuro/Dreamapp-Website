<?php
	include "admin/auth.php";	
	include "inc/db.php";
	include "inc/read-cookie.php";
?>

<!DOCTYPE HTML>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!--
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/custom.js" type="text/javascript"></script>
    -->
    <title>Kalender</title>  
    
    
</head>
<body>

	<p id="links">
		<a href="./admin/">Admin Interface</a> &bull; <a href="belegungsformular.php">Buchungstermin anfragen</a>
	</p>
	<p id="logoff">
		<?php
			if (!isset($_SESSION['angemeldet']) || !$_SESSION['angemeldet']) {
				echo "<a href='admin/login.php'>anmelden</a>";
			}
			else {
				echo "Angemeldet als ".$_SESSION['name']." &bull; <a href='admin/logout.php'>abmelden</a>";
			}
		?>
	</p>

<?
$gruppe = $_GET['gruppe'];
$belegung_von = $_GET['belegung_von'];
$von_jahr = $_GET['von_jahr'];
$von_uhr = $_GET['von_uhr'];
$belegung_bis = $_GET['belegung_bis'];
$bis_jahr = $_GET['bis_jahr'];
$bis_uhr = $_GET['bis_uhr'];
$rubrik = $_GET['rubrik'];
$verein = $_GET['verein'];
$vorname  = $_GET['vorname'];
$nachname = $_GET['nachname'];
$strasse = $_GET['strasse'];
$plz_ort = $_GET['plz_ort'];
$telefon = $_GET['telefon'];
$fax = $_GET['fax'];
$handy = $_GET['handy'];
$email = $_GET['email'];
$comment = $_GET['comment'];

$an = "michael@michaelstauss.de";
//$an = "mail@sebastian-engel.de";
$betreff = "Belegungsanfrage Heersberg ".$gruppe;

$mailtext01 = "Belegungsanfrage von: ".$belegung_von.$von_jahr.", ".$von_uhr." Uhr \n bis: ".$belegung_bis.$bis_jahr.", ".$bis_uhr." Uhr \n \n";
$mailtext02 = "Gruppe: ".$gruppe." \n Rubrik: ".$rubrik."  \n \n";
$mailtext03 = "Verein: ".$verein." \n  \n ";
$mailtext04 = "Name     : ".$vorname." ".$nachname." \n ";
$mailtext05 = "Anschrift: ".$strasse." \n ";
$mailtext06 = "           ".$plz_ort." \n \n";
$mailtext07 = "Telefon  : ".$telefon." \n ";
$mailtext08 = "FAX      : ".$fax." \n ";
$mailtext09 = "Handy    : ".$handy ."\n ";
$mailtext10 = "eMail    : ".$email." \n \n";
$mailtext11 = "sontiges : ".$comment." \n ";

$mailtext = $mailtext01.$mailtext02.$mailtext03.$mailtext04.$mailtext05.$mailtext06.$mailtext07.$mailtext08.$mailtext09.$mailtext10.$mailtext11;

mail($an,utf8_decode($betreff),utf8_decode($mailtext),"From: belegung_heersberg@cvjm-ebingen.de");
?>
<div id="wrap">
	<p class="cvjm-logo"><img src="img/cvjm-logo.png" width="130" height="110" /></p>
	<p>Vielen Dank für Ihre Belegungsanfrage unserer Heersberghütte</p>
	<p>Wir werden uns schnellstmöglich mit Ihnen in Verbindung setzen und Ihre Anfrage bestätigen bzw. Ihnen einen Ersatztermin mitteilen.</p>
	
	<p><strong>CVJM Ebingen e.V., Kapellstr. 10, 72458 Albstadt</strong></p>
    <p>&nbsp;</p>
	<p><a href="index.php">zur&uuml;ck zum Kalender</a></p>
</div>

</body>
</html>
