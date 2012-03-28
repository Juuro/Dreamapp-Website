<?php
error_reporting(E_ALL);
include $abs.'/kopf.php';

$file = false;
$p = 0;
$d = 0;
$inhalt = false;
$pfad = "./";
$x1 = opendir($pfad);
$datei = readdir($x1); 

echo "<table border='1' cellpadding='5'>";

while (gettype($datei = readdir($x1)) != "boolean") {
    
    
   if($datei != ".." && $datei != ".") {
         
        
        
      if(is_dir($pfad."".$datei)) {   
         $p++;
         $x2 = opendir($pfad."".$datei);
         $inhalt = false;
         while ($datei2 = readdir($x2)) {
            if ($datei2 != ".." && $datei2 != ".") {
               $inhalt = true;
            }
         }
         closedir($x2);
         
         
         
      if($inhalt) {
            echo "<tr>";
            echo "<td width='100'>";					   						
            echo "<a href='".$pfad."".$datei."'><font color='#E60000'><b>".$datei."</b></font></a><br>";
			echo "</td>";
			echo "<td width='60'>";
            $size = filesize($datei)/1000000;
            echo round($size, 3)." MB";
            echo "</td>";
            echo "<td width='150'>";
            $unixTime = filemtime($datei);
            echo date("d.m.Y, H:i", $unixTime)." Uhr";	
            echo "</td>";
            echo "</tr>";
         } else {
		 	echo "<table border='1' cellpadding='5'>";
            echo "<tr>";
            echo "<td width='100'>";
            echo "<font color='#E60000'>".$datei."</font><br>";			
			echo "</td>";
			echo "<td width='60'>";
            $size = filesize($datei)/1000000;
            echo round($size, 3)." MB";
            echo "</td>";
            echo "<td width='150'>";
            $unixTime = filemtime($datei);
            echo date("d.m.Y, H:i", $unixTime)." Uhr";	
            echo "</td>";
            echo "</tr>";
         }
      } elseif ($abs !== $verz and $datei !== "index.php" and $datei !== "kopf.php" and $datei !== "fuss.php" and $datei !== "inhalt.php") {
         	$file = true;
         	//echo "<table border='1' cellpadding='5'>";
            echo "<tr>";
            echo "<td width='100'>";
            echo "<a href='".$pfad."".$datei."' target='_blank'><font color='#008000'><b>".$datei."</b></font></a><br>";
            echo "</td>";
            echo "<td width='60'>";
            $size = filesize($datei)/1000000;
            echo round($size, 3)." MB";
            echo "</td>";
            echo "<td width='150'>";
            $unixTime = filemtime($datei);
            echo date("d.m.Y, H:i", $unixTime)." Uhr";	
            echo "</td>";
            echo "</tr>";
                     
         $d++;
      }
   }
}
echo "</table>";
closedir($x1);

echo "<br><br>";
if ($abs !== $verz){
		echo "<a href='../'>&nbsp;zur&uuml;ck&nbsp;</a><br>";																												
		echo "<a href='".$start."'>&nbsp;<b>Startseite</b>&nbsp;</a>";
}
echo "<br>----------------------------------------------------------------------<br><br>";
echo $p." <font color='#E60000'>Ordner</font><br>".$d." <font color='#008000'>Dateien</font>";


																																																														
include $abs.'/fuss.php';
?>