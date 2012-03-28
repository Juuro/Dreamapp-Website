<?php
	include "admin/auth.php";
    include "functions.php";	
	include "inc/db.php";
	include "inc/read-cookie.php";
	
	if(isset($_GET['monat'])){
        $monat = $_GET['monat'];
        $jahr = $_GET['jahr'];
    	$timestamp = (int)mktime(0, 0, 0, $monat, date("d",time()), $jahr);
	}
	else {
        $timestamp = (int)time();
        $monat = (int)date("m",$timestamp);	
	}	
	
	$a_monat = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
	$a_wtag = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
?>

<!DOCTYPE HTML>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
   	<link rel="stylesheet" type="text/css" href="css/style.css" />
    
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
	
		
	$tag = date("d",$timestamp);
	$wtag = date ("w",$timestamp);
	$numberofdays = date("t",$timestamp);	 
	$jahr = date("Y",$timestamp);
	
	$comparedate = $timestamp;
	
	
	//hier steht drin welcher Tag einen Termin hat
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
    
    
    echo "<ul id='timeunit'>";
	echo "	<li>".getPreviousMonth($monat, $jahr, $a_monat)."</li>";
	echo "	<li><a href='tag.php'>Tag</a></li>";
	echo "	<li class='active'><a href='index.php'>Monat</a></li>";
	echo "	<li><a href='jahr.php'>Jahr</a></li>";
	echo "	<li>".getNextMonth($monat, $jahr, $a_monat)."</li>";
	echo "</ul>";
	
		
	//oeffnet wrap
	echo "<div id='wrap'>";
	
	//header start
	echo "     <div id='div_titel'>";
	echo           "<h1>".$a_monat[$monat]." ".$jahr."</h1>";
	echo "           <div id='untertitel'><a href='belegungsformular.php'>Heersberg Online-Belegungskalender</a>";
	echo "           </div>";
	//echo "         <div id='untertitel'><a href='index.php'>Heute ist ".$a_wtag[(int)date ("w",time())]." der ".(int)date("d",time()).". ".$a_monat[(int)date("m",time())].", ".date("G",time()).":".date("i",time())." Uhr ".date("Y",time())."</a></div>";
	echo "     </div>";
	//header end
	
	
	echo "<table class='daytable'><tr>";	
	
	//Tage anzeigen
	for($i=1;$i<$numberofdays+1;$i++){
    	$emonat = mktime(0, 0, 0, $monat, $i, $jahr);
		$e = date("w",$emonat);
		echo "<td";
		if(date("d.m.Y",time())==date("d.m.Y",$emonat)){
            echo " class='heute ".$emonat."'";
		}
		else {
            echo " class='tagfeld ".$emonat."'";
		}
		echo ">";
		echo "    <div class='tag'>";
		echo "        <span id='tag".$i."' class='ntag'>".$i."</span>";
		echo " ";
		echo "        <span class='wtag'>".substr($a_wtag[($e)], 0, 2)."</span>";
		echo "    </div>";
		
		echo "    <div class='termin_block'>";
		
		//ist ein Tag belegt oder nicht?
		if($belegtetage[$i] == 1){
    		echo "<span class='termin'><a href='tag.php?jahr=".$jahr."&amp;monat=".$monat."&amp;tag=".$i."'><img src='img/circle_red_16.png' alt='belegt' title='belegt' /></a></span>";
        }
        else {
            echo "<a href='belegungsformular.php?jahr=".$jahr."&amp;monat=".$monat."&amp;tag=".$i."'><img src='img/add_16.png' alt='Termin hinzuf&uuml;gen' title='hinzufügen' /></a>";
        }
		echo "    </div>";
		echo "</td>";
		if($i==7 || $i==14 || $i==21 || $i==28){
			echo "</tr><tr>";
		}
	}
	echo "</tr></table>";
	
	include "inc/footer.php";
	
	//schliesst wrap
	echo "</div>";
	
	mysql_close($link);
    unset($result);
?>


</body>
</html>