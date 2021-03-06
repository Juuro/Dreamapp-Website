<?php

   #################################################################
   ## EasyUpload V1.1 - http://www.codeschnipsel.net              ##
   ## Fragen, Anregungen: info@codeschnipsel.net                  ##
   ##                                                             ##
   ## Alle Rechte vorbehalten                                     ##
   ## Copyright Hendrik Walter                                    ##
   ## Dieses Script darf unver�ndert zum Donwload                 ##
   ## angeboten werden, der Hinweis auf den                       ##
   ## Rechteinhaber darf nicht entfernt werden.                   ##
   #################################################################


   ##### KONFIGURATION #############################################


   // Absoluter Pfad zum Ordner in den die Datei hochgeladen werden soll.
   $pfad = "pers_berichte/daten";

   // Soll eine maximale Gr��e der Datei festgelegt werden ?
   $sizeabfrage = "yes";

   // Maximale Gr��e der Datei (Falls $sizeabfrage = "yes" ist)
   $filesize = "50000";

   // Soll die maximale Gr��e auch angezeigt werden ?
   $sizeanzeige = "yes";

   // Was f�r Dateitypen sollen erlaubt sein ?
   $extend = "jpg|gif|txt|htm|html|doc";

   // Sollen die erlaubten Dateitypen angezeigt werden ?
   $extendanzeige = "yes";

   // Layout
   $body = "<body bgcolor=#ffffff text=#000000 link=#FF0000 alink=#FF0000 vlink=#FF0000>";
   $font = "<font face=verdana size=2>";


   ##### Style KONFIGURATION #######################################
?>

<html>
<head>
<title>UPLOAD</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
   echo "$body";
   echo "$font";
?>
<?

##### Ab hier nichts mehr �ndern !! ################################

   $fehler = FALSE;

   if ($senden) {
      if ($file_name == "") {
         echo "<BR><font color=#FF0000><b>Es wurde keine Datei ausgew�hlt!</b></font>";
         $fehler = TRUE;
      }

      if (!$fehler)
      if (file_exists("$pfad/$file_name")) {
         echo "<BR><font color=#FF0000><b>Dateiname schon vorhanden!</b></font>";
         $fehler = TRUE;
      }

      if (!$fehler)
      if ($sizeabfrage == "yes") {
         if ($file_size > $filesize) {
            echo "<BR><font color=#FF0000><b>Die Datei ist zu gro�!</b></font>";
            $fehler = TRUE;
         }
      }

      if (!$fehler)
      if (!eregi("($extend)$", $file_name)) {
         echo "<BR><font color=#FF0000><b>Dieser Dateityp ist nicht erlaubt!</b></font>";
         $fehler = TRUE;
      }

      if (!$fehler) {
         if (copy($file, $pfad."/".$file_name)) {
            echo "<BR><font color=#00FF00><b>Datei hochgeladen</b></font><BR>
			<br>
			zur�ck zur <a href='http://www.nachderschule.com/abi'>Startseite</a><BR>
			<br>
			<a href='http://www.nachderschule.com/abi/upload.php'>noch eine Datei hochladen</a>";
            $fehler = FALSE;
         }
         else {
            echo "<BR><font color=#FF0000><b>Datei nicht hochgeladen</b></font>";
            $fehler = TRUE;
         }

      }
   }

   if ($fehler || !$senden) {

?>
<div align="left">
  <table align="center">
    <form action="<?php $PHP_SELF; ?>" method="post" enctype="multipart/form-data">
      <BR>
      <b>Bitte Datei ausw�hlen:</b> <BR>
      <?
   if ($sizeanzeige == "yes") {
      echo ("Maximale Gr��e: ".$filesize." Byte");
   }
?>
      <BR>
      <?
   if ($extendanzeige == "yes") {
      echo ("Erlaubte Dateitypen: ".$extend);
   }
?>
      <BR>
      <BR>
	  <font size="-1"><b>Bitte beachten:</b> Im Dateinamen der hochgeladenen Datei d�rfen sich keine �, �, � oder � befinden! Sonst kann der Internet Explorer in der Schule die Dateien nicht anzeigen!</font>
	  <BR>
      <BR>
      &nbsp;
      <input type="file" size="30" name="file">
      <BR>
      &nbsp;
      <input type="Submit" name="senden" value="Hochladen">
    </form>
  </table>
  <?
}
 echo "<BR><hr width=100>";
 echo "<font size=1><a href=\"http://www.codeschnipsel.net\" target=\"_blank\">EasyUpload V1.1</a></font>";
?></font>
  </div>
</body>
</html>
