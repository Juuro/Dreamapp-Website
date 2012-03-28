<?php

if($loggedin) {
?>
<h2>.neues bilder-album hochladen</h2>
Hier könnt Ihr eure Bilder-Alben selbst hochladen. Es wird aber momentan noch nciht sofort zu sehen sein, da es noch vom Admin manuell eingerichtet werden muss.
<br>
<br>
<?php
error_reporting(E_ALL);
set_time_limit(1200);
//erlaubte Dateitypen
$extend = "zip";
//Auslesen welche Dateien und Ordner vorhanden sind

function func_ausgabe() {
echo "<br><br><br>";
echo "Bisher hochgeladene Ordner und <u>Dateien</u>:<br>";
$i=0;
$ordner = "bilder";
$handle = opendir($ordner);
while ($file = readdir ($handle)) {
    if($file != "." && $file != "..") {
		
        if(is_dir($ordner."/".$file)) {
		
            echo $file."<br/>";
        } else {
            // kompletter Pfad
            $compl = $ordner."/".$file;
            echo "<a href=\"".$compl."\">".$file."</a><br/>";
			$i++;
        }
    }
}
closedir($handle);
}


?>
Erlaubte Dateitypen: <?php echo ($extend); ?><br>
<br>
<form enctype="multipart/form-data" action="index.php?section=pic_upload" method="POST">
Bitte geben Sie den Namen des zu erstellenden Bilder-Albums an:<br>
<input name="dirname" type="text" size="20">
<br>
<br>
Bitte wählen Sie die Datei mit den Bildern aus:<br>
  <input type="file" size="30" name="file">
  <br>
<br>
<input type="hidden" name="senden" value="ja" />
<input type="Submit" value="senden">
</form>

<?php

if (isset($_POST['senden'])) { //wenn $senden gedrückt wird
	if (!eregi("($extend)$", $file_name)) {
	echo "<BR><font color=#FF0000><b>Dieser Dateityp ist nicht erlaubt!</b></font>";
	$fehler = TRUE;
	}
	else {
	echo $extend."-Datei erfolgreich hochgeladen!<br>";
	$fehler = FALSE;
	}


	if (!$fehler) { //wenn eine Bedingung für das Hochladen nciht erfüllt ist bzw. wenn fehler = TRUE;
		
		/*
		//Ordner erstellen
		if(isset($_POST['dirname']) && isset($_FILES['file']) > "0")
		{
		$oldumask = umask(0);
		mkdir ($_POST['dirname'], 0777);
		umask($oldumask); 
		echo "Bilder-Album ".$_POST['dirname']." erfolgreich erstellt!";
		$erstellt = "yes";
		func_ausgabe();
		}
		elseif(isset($_POST['dirname']) > "0") {
		echo "Bilder-Album konnte nicht erstellt werden!<br>";
		echo "Bitte geben Sie eine Datei zm Upload an!";
		func_ausgabe();
		}
		elseif(isset($_FILES['file']) > "0") {
		echo "Bilder-Album konnte nicht erstellt werden!<br>";
		echo "Bitte geben Sie einen Namen für das neue Bilder-Album an!";
		func_ausgabe();
		}
		else {
		echo "Bilder-Album konnte nicht erstellt werden!<br>";
		echo "Bitte geben Sie einen Namen für das neue Bilder-Album an!<br>";
		echo "Bitte geben Sie eine Datei zum Upload an!";
		$erstellt = "no";
		func_ausgabe();
		}
		*/
		
		//Datei hochladen
		if(isset($_POST['senden']) && $_POST['senden'] == "ja")
	    {

		//Pfad zum Ordner, in dem die Datei gespeichert werden soll//
		$uploaddir = "bilder";
		//Dieser Ordner muss Schreibrechte besitzen (Chmod 777)//
		$new_name = ($_POST['dirname']);
        
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . "/" . $new_name . "." . $extend)) {
		print "Datei erfolgreich hochgeladen.\n";
		$erstellt = "yes";
		func_ausgabe();
		}
		else
		{
		print "Fehler beim Hochladen der Datei. Fehlermeldung:\n";
		print_r($_FILES);
		func_ausgabe();
		}

    } 
	
	}//wenn eine Bedingung für das Hochladen nciht erfüllt ist bzw. wenn fehler = TRUE;
}//wenn $senden gedrückt wird




?>
<?php } ?>