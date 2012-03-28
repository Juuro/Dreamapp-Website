<?php
error_reporting(E_ALL);
//erlaubte Dateitypen
$extend = "zip";
//Auslesen welche Dateien und Ordner vorhanden sind

function func_ausgabe() {
echo "<br><br><br>";
echo "Bisher hochgeladene Ordner und <u>Dateien</u>:<br>";
$i=0;
$ordner = ".";
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
<form enctype="multipart/form-data" action="<?PHP echo $PHP_SELF; ?>" method="POST">
<input name="dirname" type="text" size="20">&nbsp;Namen des zu erstellenden Bilder-Albums angeben
<br>
<input type="file" size="30" name="file">&nbsp;Bitte wählen Sie die Datei mit den Bildern aus!
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
		$uploaddir = ".";
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