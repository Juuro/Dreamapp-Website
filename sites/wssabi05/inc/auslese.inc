<?php
if($loggedin) {
?>
<head>
<title>UPLOAD</title>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<?php
echo "<h2>.personen berichte</h2>";
echo "<br>";
echo "<br>";
echo "Hier findet ihr alle bisher hochgeladenen Schülerberichte!";
echo "<br>";
echo "<br>";

$i=0;
$ordner = "pers_berichte/daten";
$handle = opendir($ordner);
while ($file = readdir ($handle)) {
    if($file != "." && $file != "..") {
        if(is_dir($ordner."/".$file)) {
		
            echo "/".$file."<br/>";
        } else {
            // kompletter Pfad
            $compl = $ordner."/".$file;
            echo "<a href=\"".$compl."\">".$file."</a><br/>";
			$i++;
        }
    }
}
closedir($handle);
echo "<br>";
echo "<br>"; 
echo "<br>";
echo "Verzeichnis beinhaltet ".$i." Personenbeschreibungen.";
?>
<?php } ?>