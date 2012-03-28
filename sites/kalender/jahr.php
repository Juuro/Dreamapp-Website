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
	<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
    
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/custom.js" type="text/javascript"></script>
    
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


<?php		
	
	$a_monat = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
	$a_wtag = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
	
	
	if(isset($_GET['jahr'])){
        $jahr = $_GET['jahr'];        
    	$timestamp = mktime(0, 0, 0, 0, 0, $jahr);
	}
	else {
        $timestamp = time();	 
		$jahr = date("Y",$timestamp);
	}
	
	$tag = date("d",$timestamp);
	$wtag = date ("w",$timestamp);
	
	$comparedate = $timestamp;
	
	echo "<ul id='timeunit'>";
	echo "	<li>".getPreviousYear($jahr)."</li>";
	echo "	<li><a href='tag.php'>Tag</a></li>";
	echo "	<li><a href='index.php'>Monat</a></li>";
	echo "	<li class='active'><a href='jahr.php'>Jahr</a></li>";
	echo "	<li>".getNextYear($jahr)."</li>";
	echo "</ul>";
	
	//oeffnet wrap
	echo "<div id='wrap'>";
	
	
	//header
	echo "     <div id='div_titel'>";
	echo           "<h1>Jahr ".$jahr."</h1>";
	
	echo "           <div id='untertitel'><a href='belegungsformular.php'>Heersberg Online-Belegungskalender</a>";
	echo "           </div>";
	echo "     </div>";
	//header
	
	
	for($monat=1;$monat<=12;$monat++){
		echo "<br />";
		echo $a_monat[$monat]." ".$jahr;
		
		echo "<table class='monate'><tr>";	
		
		$emonat = mktime(0, 0, 0, $monat, 1, $jahr);
		
		$numberofdays = date("t",$emonat);
		
		$comparedate = $emonat;
		
		$belegtetage = array();
		for($i=1;$i<=$numberofdays;$i++){
			$belegtetage[$i] = 0;
		} 
	   
	   	//pruefen ob es einen Termin gibt der den ganzen Monat betrifft
	   	$belegtetage = getDateCompleteMonth($comparedate, $numberofdays, $belegtetage);
		
        
    	//pruefen ob ein Termin in einem Vormonat startet und im aktuellen Monat endet
	    $belegtetage = getDatePreviousMonth($comparedate, $numberofdays, $belegtetage);
        
    	//pruefen ob ein Termin im aktuellen Monat startet und in einem Folgemonat endet
	    $belegtetage = getDateFollowMonth($comparedate, $numberofdays, $belegtetage);
    
    	//pruefen ob ein Termin im aktuellen Monat startet und endet
	    $belegtetage = getDateActualMonth($comparedate, $numberofdays, $belegtetage);
	 
    
     // und referenz zum objekt löschen, brauchen wir ja nicht mehr...
	   
        //Tag anzeigen
        for($i=1;$i<$numberofdays+1;$i++){
            $emonat = mktime(0, 0, 0, $monat, $i, $jahr);
            $e = date("w",$emonat);
            echo "<td";
            if(date("d.m.Y",time())==date("d.m.Y",$emonat)){
                echo " class='heute ".$emonat."'";
            }
            else {
                echo " class='jtagfeld ".$emonat."'";
            }
            echo ">";
            echo "    <div class='jtag'>";
            echo "        <span class='jntag'>".$i."</span>";
            echo " ";
            echo "        <span class='jwtag'>".substr($a_wtag[($e)], 0, 2)."</span>";
            echo "    </div>";
            
            echo "    <div class='jtermin_block'>";
            
            //ist ein Tag belegt oder nicht?
            if($belegtetage[$i] == 1){
                echo "<span class='jtermin'><a href='tag.php?jahr=".$jahr."&amp;monat=".$monat."&amp;tag=".$i."'><img src='img/circle_red_16.png' alt='belegt' title='belegt' /></a></span>";
            }
            else {
                echo "<a href='belegungsformular.php?jahr=".$jahr."&amp;monat=".$monat."&amp;tag=".$i."'><img src='img/add_16.png' alt='Termin hinzuf&uuml;gen' title='Termin hinzuf&uuml;gen' /></a>";
            }
            echo "    </div>";
        }
        echo "</tr></table>";
	}
	
	include "inc/footer.php";
	
	//schliesst wrap
	echo "</div>";	
	
	mysql_close($link);
    unset($result);
?>


</body>
</html>