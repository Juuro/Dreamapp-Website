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
    
    <script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js" type="text/javascript"></script>
    <script src="../js/custom.js" type="text/javascript"></script>
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
    $tag = date("d",$timestamp);
	$wtag = date ("w",$timestamp);
	$mtag = date("t",$timestamp);	
	$vergleichsdate = date("Ymd",$timestamp);
	
	//oeffnet wrap
	echo "<div id='wrap'>";	
	echo "<div id='stylized' class='myform'>";
	echo "<form id='form' method='post' action='verarbeiten.php'>";
	echo "	<h1>Neuer Termin</h1>";
	echo "	<p>Tragen Sie hier ihren Termin ein</p>";
	echo "  <fieldset>";
    echo "  <label>Ankunftsdatum";
    echo "  <span class='small'>z.B.: 04.01.2009</span>";
    echo "  </label>";
	echo "	<input type='text' id='start_date' name='start_date' value='".$tag.".".$monat.".".$jahr."' />";
	
    echo "  <label>Ankunftszeit";
    echo "  <span class='small'>z.B.: 08:15</span>";
    echo "  </label>";
	echo "	<input type='text' id='stime' name='stime' value='".date("H:i",time())."' />";
		
    echo "  <label>Abreisedatum";
    echo "  <span class='small'>z.B.: 11.04.2009</span>";
    echo "  </label>";
	echo "	<input type='text' id='end_date' name='end_date' />";
	
    echo "  <label>Abreisezeit";
    echo "  <span class='small'>z.B.: 18:30</span>";
    echo "  </label>";
	echo "	<input type='text' id='etime' name='etime' value='".date("H:i",time())."' />";
	
    echo "  <label>Titel";
    echo "  <span class='small'>Beschreibung</span>";
    echo "  </label>";
	echo "	<input type='text' id='titel' name='titel' />";
	
    echo "  <label>Notizen";
    echo "  <span class='small'>Kommentare</span>";
    echo "  </label>";
	echo "	<textarea id='notizen' name='notizen' rows='4' cols='10'></textarea>";
	
    echo "	<input type='submit' value='eintragen' />";
	echo "  </fieldset>";
    echo "  <div class='spacer'></div>";
	
	echo "</form>";
	echo "</div>";
	
	include "../inc/footer.php";
	
	//schliesst wrap
	echo "</div>";
    
?>

</body>
</html>