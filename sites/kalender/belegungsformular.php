<?php
	include "admin/auth.php";
	include "functions.php";
	include "inc/db.php";
	include "inc/read-cookie.php";
?>

<!DOCTYPE HTML>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script src="js/custom.js" type="text/javascript"></script>
    
    <title>Kalender</title>  
    
    
</head>
<body>

	<p id="links">
		<a href="./" title="Haben Sie sich Verlaufen?">&larr; Zurück zum Kalender</a> &bull; <a href="./admin/">Admin Interface</a> &bull; <a href="belegungsformular.php">Buchungstermin anfragen</a>
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
	<p id="adress">
	    H&uuml;ttenwart und Belegung<br />
	    <b>Michael Stau&szlig;</b><br />
	    Ostheimstra&szlig;e 11<br />
	    72458 Albstadt<br />
	    Tel.: 0 74 31 / 58 3 99 (bis 20.00 Uhr)<br />
	    Handy: 01 75 / 15 95 699<br />
	    Fax: 07431/ 93 48 77<br />
	    e-mail: <a href="mailto:michael@michaelstauss.de">michael@michaelstauss.de</a>
	</p>

<?php	
    
    $a_monat = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
	$a_wtag = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
	
	
	if(isset($_GET[monat])){
        $tag = $_GET[tag];
        $monat = $_GET[monat];
        $jahr = $_GET[jahr];        
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
	
	$vorm = $zurueckm = $monat;
	
	if($tag == 1){
	   $zuruecktimestamp = mktime(0, 0, 0, $monat-1, $tag, $jahr);
	   $zurueckt = date("t",$zuruecktimestamp);
	   
	   if($monat == 1){
	       $zurueckm = 12;
        }
        else {
	       $zurueckm = $monat-1;
        }   
	}
	else {
	   $zurueckt = $tag-1;
	}
	
	if($tag == date("t",$timestamp)){
	   $vort = 1;
	   
	   if($monat == 12){
	       $vorm = 1;
        }
        else {
	       $vorm = $monat+1;
        } 	   
	}
	else {
	   $vort = $tag+1;
	}
	
	
	//header
?>

<br />
<div id='stylized' class='myform'>
    <form action="send_heersberg.php" method="get">
        <h1>Belegungsformular</h1>
        <p>Heersbergh&uuml;tte des CVJM-Ebingen e.V.</p>
        <fieldset>
            <label>von
                <span class='small'>z.B.: 04.01.2009</span>
            </label>
            <?php
            echo "<input type='text' name='belegung_von' value='".$tag.".".$monat.".".$jahr."' id='start_date' />";
            ?>
            
            <!--            
            <label>
                <span class='small'>Jahr</span>
            </label>            
            <select name="von_jahr"> <option selected="selected">2008</option> <option>2009</option></select>
            -->

            <label>
                <span class='small'>Uhrzeit</span>
            </label>
            <input type="text" name="von_uhr" id="start_time" />
                        
            <label>bis
                <span class='small'>z.B.: 14.01.2009</span>
            </label>
            <input type="text" name="belegung_bis" id="end_date" />
            
            <!--
            <label>
                <span class='small'>Jahr</span>
            </label>            
            <select name="bis_jahr"> <option selected="selected">2008</option> <option>2009</option></select>
            -->
            
            <label>&nbsp;
                <span class='small'>Uhrzeit</span>
            </label>
            <input type="text" name="bis_uhr" id="end_time" />
                        
            <label>Gruppe
                <span class='small'> </span>
            </label>       
            <input type="text" name="gruppe" id="group" />
            
            <!--
            <label>Rubrik
                <span class='small'> </span>
            </label>
            <select size="1" name="rubrik"> <option selected="selected">CVJM-Ebingen (Vereinsgruppen)</option> <option>Dauerbelegungen</option> <option>Fremdgruppen</option> <option>Privatbelegung</option></select>
            -->
            
            <label>Verein
                <span class='small'> </span>
            </label>
            <input type="text" name="verein" id="association" />
            
            <label>Vorname
                <span class='small'> </span>
            </label>
            <input type="text" name="vorname" id="surname" />
            
            <label>Nachname
                <span class='small'> </span>
            </label>
            <input type="text" name="nachname" id="lastname" />
            
            <label>Stra&szlig;e
                <span class='small'> </span>
            </label>
            <input type="text" name="strasse" id="street" />
            
            <label>PLZ, Wohnort
                <span class='small'> </span>
            </label>
            <input type="text" name="plz_ort" id="city" />
            
            <label>Telefon
                <span class='small'> </span>
            </label>
            <input type="text" name="telefon" id="phone" />
            
            <label>Fax
                <span class='small'> </span>
            </label>
            <input type="text" name="fax" id="fax" />
            
            <label>Handy
                <span class='small'> </span>
            </label>
            <input type="text" name="handy" id="handy" />
            
            <label>E-Mail
                <span class='small'>unbedingt angeben, sonst keine Best&auml;tigung</span>
            </label>
            <input type="text" name="email" id="email" />
            
            <label>Kommentar
                <span class='small'> </span>
            </label>
            <textarea name="comment" rows='4' cols='10' id="comment"></textarea>
            
            <input name="B1" type="submit" />
            <input name="B2" type="reset" />

        </fieldset>
    </form>
</div>

<?php
    include "inc/footer.php";
?>

</div>
</body>
</html>