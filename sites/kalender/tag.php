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
        $tag = (int)date("d",$timestamp);	
        $monat = (int)date("m",$timestamp);	
        $jahr = (int)date("Y",$timestamp);	
	}
	
	echo "<ul id='timeunit'>";
	echo "	<li>".getPreviousDay($tag, $monat, $jahr)."</li>";
	echo "	<li class='active'><a href='tag.php'>Tag</a></li>";
	echo "	<li><a href='index.php'>Monat</a></li>";
	echo "	<li><a href='jahr.php'>Jahr</a></li>";
	echo "	<li>".getNextDay($tag, $monat, $jahr)."</li>";
	echo "</ul>";
    
    //oeffnet wrap
	echo "<div id='wrap'>";
    echo "     <div id='div_titel'>";
	echo           "<h1>".$tag.".".$monat.".".$jahr."</h1>";
	echo "           <div id='untertitel'>";
	echo "             <a href='belegungsformular.php'>Heersberg Online-Belegungskalender</a>";
	echo "           </div>";
	echo "     </div>";
     
    $belegungen = array_merge(getDateCompleteDay($timestamp), getDatePreviousDay($timestamp), getDateFollowDay($timestamp), getDateActualDay($timestamp));
    
    echo "<table class='datedetails datelist'>";
    if(count($belegungen) != 0){
        ?>
                <tr>
                    <th>Gruppe</th>
                    <th>Anreise</th>
                    <th>Abreise</th>
                </tr>       
        <?php
        for($i=0;$i<count($belegungen);$i++){
            $datedetails = getDateDetails($belegungen[$i]);
            
            for ($j=1;$j<count($datedetails)-2;$j++){
                if(preg_match("/^\d{10}$/",$datedetails[$j])){
                    $datedetails[$j] = date("d.m.Y",$datedetails[$j])." ".date("H:i",$datedetails[$j])." Uhr";
                }
            }
            
            echo "<tr>";
            for($k=1;$k<count($datedetails)-2;$k++){ 
                echo "  <td>".$datedetails[$k]."</td>";
            }
            echo "</tr>";
        }
    }
    else {
    ?>
    	<tr>
    		<th>Dieser Tag ist nicht belegt!</th>
    	</tr>
    <?php
    }
    echo "</table>";
	
	//schliesst wrap
	echo "</div>";

?>
		
		




</body>
</html>