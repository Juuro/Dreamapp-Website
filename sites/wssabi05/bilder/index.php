<? /*         +    toms-galerie V 1.3
              +    automatische PHP-Bildergalerie
              +
+ + + + + + + + + + + + + + + + + + + + + + + + + + + + +
              +
              +    Autor: Thomas Fischer
              +    Internet: http://www.tomshaus.de
              +    Mail: script@tomshaus.de
              +
              +
              +
              +
              +    aktualisiert: 20.12.2005

  --- Configuration: hier wird die Galerie angepasst ---

Um die Galerie anzupassen koennen die Werte der Variablen geaendert werden (nach dem = ).
Werte in  Anfuehrungszeichen "" muessen auch wieder innerhalb der "" stehen!
Achtung! Keinesfalls das Semikolon ; entfernen!
Hinter den doppelten Schraegstrichen // sind Erklaerungen.
Farben und Schriftformatierung werden in der Datei form.css angepasst.
Des weiteren kann an den dafuer vorgesehenen Stellen (diese sind eindeutig ausgezeichnet)
eigener HTML-Code eingefuegt werden um die Galerie optimal an die eigene Homepage anzupassen.                                                                                                                              */



// Das Aussehen der Galerie:

$max[spalten] = 4 ;                          // maximale Anzahl der Spalten in den Uebersichten
$max[tmb_width] = 90 ;                       // Maximalbreite oder Hoehe der Thumbnails in der Uebersicht
$max[tmb_bild_width] = 90 ;                  // Maximalbreite oder Hoehe der Thumbnails in der mittleren Ansicht (die kleinen Bildchen bei weiter und zurueck)
$max[tmb_gal_width] = 70 ;                   // Maximalbreite oder Hoehe der Thumbnails fuer die Galerievorschau
$max[bild_width] = 500;                      // Maximalbreite oder Hoehe des mittleren Vorschaubildes
$max[vorschaubilder] = 20 ;                  // Maximale Anzahl der gezeigten Vorschaubilder pro Seite (Beachte: Wenn die Zahl nicht durch die Spaltenzahl teilbar ist wird automatisch die letzte Zeile gefuellt, d.h.: es werden bei $max[vorschaubilder] = 10  und $max[spalten] = 4 immer 12 Bilder pro Seite angezeigt. Auf der letztn Seite wird die Tabelle immer gefuellt, also z.B. 12 Bilder. was die Zaehlweise rueckwaerts etws aendert.)

$max[originalbilddateigroesse] = 500000 ;    // Maximale Dateigroesse des Originalbildes in Byte
$max[originalbildbreite] = 1600 ;            // Maximalbreite des Originalbildes (groessere Bilder werden vom Script ignoriert)
$max[originalbildhoehe] = 1600 ;             // Maximalhoehe  des Originalbildes (groessere Bilder werden vom Script ignoriert)
$min[originalbildbreite] = 1 ;               // Minimalbreite des Originalbildes (kleinere Bilder werden vom Script ignoriert)
$min[originalbildhoehe] = 1 ;                // Minimalbreite des Originalbildes (kleinere Bilder werden vom Script ignoriert)
$min[originalbilddateigroesse] = 1 ;         // Minimale Dateigroesse des Originalbildes in Byte

$sort[bilder] = "filename" ;                  // Sortierung der Bilder nach "filename" (Dateiname), "filetime" (Dateidatum), "width" (Breite), "height" (Hoehe)
$sort[galerievorschau] = "filename" ;          // Erzeugung des Galerievorschaubildes, sortiert nach "filename" (Dateiname), "filetime" (Dateidatum), "width" (Breite), "height" (Hoehe)
$sort[galerie] = "galeriename" ;              // Sortierung der Galerien nach "galeriename" (Galeriename), "galeriedatum" (Datum der Erstellung der Galerie), "bilddatumneu" (neustes Bild in einer Galerie), "bildanzahl" (Anzahl der Bilder in einer Galerie)
$sort[umkehren] = "nein" ;                    // Sortierung umkehren = "ja" (also zB von Z nach A)

$css[galerierahmen] = 1   ;                       // Rahmendicke um die gesamte Galerie
$css[galeriehintergrund] = 15 ;                   // Abstand vom Aussenrahmen zur Galerie
$css[tabellenrahmen] = 2 ;                        // Rahmendicke um die einzelnen Zellen der Galerie
$css[tabellenhintergrund] = 15 ;                  // Abstand vom Rahmen der Zellen zur den Inhalten

$textlaenge[bild] = 500;                     // Legt die Laenge des gekuezten Beschreibungstextes fuer Bilder fest.
$textlaenge[bilduebersicht] = 20;            // Legt die Laenge des gekuezten Beschreibungstextes fuer Bilderuebersicht fest.
$textlaenge[galerie] = 300;                  // Legt die Laenge des gekuezten Beschreibungstextes fuer Galerien fest.

// Mit den Zeige-Variablen kann detailliert eingestellt werden, was (wo) angezeigt wird.
$zeige[titel] = 1 ;                           // Legt fest, ob der Galeriename ueber der Galerie angezeigt wird : 0=nein 1=ja
$zeige[bildname] = 0 ;                        // Zeige den Dateinamen des Bildes: 0 = nie, 1 = nur in Uebersicht, 2 = nur in Bildmodus, 3 = immer
$zeige[galerie] = 0  ;                        // Zeige Galerien: 0 = untereinander, 1 = nebeneinander. (Empfehlung = untereinander)
$zeige[galeriename] = 4 ;                     // Zeige Galeriename: 0 = nie , 1 = auch in Galerieuebersicht, 2 = auch in Bilduebersicht, 3 = auch in Bildansicht  , 4 = immer (Es kann kombiniert werden, immer kleine Zahl zuerst: zB 13 bedeutet in Galerieuebersicht und Bildansicht, aber nicht in Bilduebersicht)
$zeige[galeriezahl] = 4 ;                     // Zeige Galeriezahl (also Galerie 1 ... Galerie 2): 0 = nie, 1 = in Galerieuebersicht, 2 = in Bilduebersicht, 3 = in Bildansicht, 4 = immer (Es kann kombiniert werden, immer kleine Zahl zuerst: zB 12 bedeutet in Galerieuebersicht und Bilduebersicht, aber nicht in Bildansicht)
$zeige[galerieanzahl] = 1 ;                   // Zeige Anzahl der Galerien: 0 = nein, 1 = ja (in Galerieuebersicht
$zeige[bildanzahl] = 3 ;                      // Zeige Anzahl der Bilder: 0 = nie, 1 = nur in Galerieuebersicht, 2 = nur in Bilduebersicht, 3 = immer
$zeige[bildzahl] = 3 ;                        // Zeige Bildzahl (also z.B. Bild 1): 0 = nie , 1 = nur in Uebersicht , 2 = nur in Einzelbildansicht , 3 = immer
$zeige[bildtext] = 1 ;                        // Zeige den Text zum Bild: 0 = nicht, 1 = unter dem Bild, 2 = ueber dem Bild
$zeige[bildtext_uebersicht] = 1 ;             // Zeige den Text zum Bild: 0 = nicht, 1 = unter dem Bild, 2 = ueber dem Bild
$zeige[bildgroesse] = 3 ;                     // Zeige Bildgroesse (Pixel):  0 = nie , 1 = in Bilduebersicht , 2 = in Bildansicht , 3 = immer
$zeige[bildgroesse_vollbild] = 3 ;            // Zeige Bildgroesse im Link auf Vollbild (Pixel): 0 = nie , 1 = in Bilduebersicht , 2 = in Bildansicht , 3 = immer
$zeige[vollbildlink] = 3 ;                    // Zeige Link zum Vollbild (im Extrafenster): 0 = nie , 1 = nur in Bilduebersicht , 2 = nur in Bildansicht , 3 = immer
$zeige[cachestatus] = 0 ;                     // Zeige Cachestatus: 0 = nein, 1 = ja
$zeige[erlklaerung] = 0 ;                     // Zeige Zeichenerklaerung: 0 = nein, 1 = ja
$zeige[titelbox] = 4 ;                        // Zeige die Box ueber Galerie bzw. Bild mit der Bezeichnung: 0 = nie, 1 = in Galerieuebersicht, 2 = in Bilduebersicht, 3 = in Bildansicht, 4 = immer
$zeige[linkbox] = 4 ;                         // Zeige die Box unter der Galerie bzw. Bild mit den Navigationslinks: 0 = nie, 1 = in Galerieuebersicht, 2 = in Bilduebersicht, 3 = in Bildansicht, 4 = immer
$zeige[galerienavbox] = 3 ;                   // Zeige die Box mit der Galerienavigation: 0 = keine, 1 = nur ueber der Galerie, 2 = nur unter der Galerie, 3 = beide
$zeige[bildnavbox] = 1 ;                      // Zeige die Box mit der Bildnavigation (Direktwahl) unter der Galerie: 0 = nein, 1 = ja

// In den Namevariablen werden verschiedene Beschriftungen gespeichert.
$name[browsertitel] = "Abi-Bilder WSS '05" ; // Name der Galerie wird oben im Titel des Browsers angezeigt  (nicht bei include)
$name[titel] = "Abi-Bilder" ;       // Name der Galerie wird ueber der Galerie angezeigt
$name[galerie] = "Galerie" ;                 // Der Begriff "Galerie" (wenns kein Link ist)
$name[bild] = "Bild" ;                       // Der Begriff "Bild" ( z.B. ueber dem Bild: "Bild 1")
$name[erklaerung] = "* Originalgröße<br>( ) Bild wird im Extrafenster geöffnet<br><br>" ;
$name[rueckpfeil] = "&lt;&lt;" ;             //  <<  Zeichen
$name[weiterpfeil] = "&gt;&gt;" ;            //  >>  Zeichen
$name[trenner] = "---" ;                     // Trennzeichen

// In den Linkvariablen werden die Beschriftungen der Lins gespeichert.
$link[gal] = "Galerie&uuml;bersicht" ;        // Bezeichnet den Link zur Galerieuebersicht
$link[startseite] = "Startseite" ;            // Bezeichnet den Link zur Startseite
$link[galerie] = "Galerie" ;                  // Bezeichnet den Link zu einer Galerie (zusammen mit Galerienummer)
$link[gal_weiter] = "weiter" ;                // Bezeichnet den Link "weiter" fuer Galerienavigation
$link[gal_zurueck] = "zur&uuml;ck" ;          // Bezeichnet den Link "zurück" fuer Galerienavigation
$link[bild_weiter] = "weiter" ;               // Bezeichnet den Link "weiter" fuer Bildnavigation
$link[bild_alt_weiter] = "weiter zu Bild" ;   // Bezeichnet Alttext des Bildes ueber dem Link "weiter" fuer Bildnavigation
$link[bild_zurueck] = "zur&uuml;ck" ;         // Bezeichnet den Link "zurück" fuer Bildnavigation
$link[bild_alt_zurueck] = "zur&uuml;ck zu Bild" ; // Bezeichnet Alttext des Bildes ueber dem Link "zurück" fuer Bildnavigation
$link[text_all] = "Eintrag vollst&auml;ndig ansehen" ;   // Bezeichnet den Link zum vollstaendigen Text
$link[text_kurz] = "Eintrag k&uuml;rzen" ;    // Bezeichnet den Link zum gekuerzten Text
$link[vollbild] = "gr&ouml;&szlig;er... " ;  // Bezeichnet den Link zum Vollbild in Bildansicht (erscheint vor der Groessenangabe)
$link[vollbild_u] = "" ;                      // Bezeichnet den Link zum Vollbild in Bilduebersicht (erscheint vor der Groessenangabe)


// Anpassung an die eigene Homepage:

$setup[startseite] = "http://www.tomshaus.de" ;     // Startseite der eigenen Homepage
$setup[dateiname] = "index.php" ;                 // Name dieser Datei  (bzw. der Datei, die diese per include einfuegt)
$setup[thumbnail] = "thumbnail2.php" ;              // Datei zum Bilderzeugen (Bei älteren Servern sollte  "thumbnail.php" gewählt werden.
$setup[path_gal] = "bilder/" ;                      // Pfad zu den Galerien  (relativ vom Script aus, Achtung bei Include, vom Hauptscript aus)
$setup[path_cache] = "cache/" ;                     // Pfad zum Cache, wo die Thumnails gespeichert werden (relativ vom Script aus)
$setup[nullgif] = "0.gif" ;                         // Leeres tranzparentes Gifbild

$setup[gif] = 2 ;                                   // Unterstützung von Gif-Bildern = 1 (Achtung nicht alle GD-Versionen unterstützen Gif) PNG=3, SWF=4, NUR JPG=2 (Grundeinstellung)

$setup[cache] = 2 ;                                 // Thumbnails cachen 0 = nein , 1 = nur kleine Thumbnails , 2 = alle

$include = 0 ;                                      // Galerie wird includet: 0 = nein, 1 = ja
//$setup[inc_var] = "nav"  ;                          // Include Variable  (frei definierbare Variable, die bei internen Links mit uebertragen wird, hier zB die Variable $nav )
//$setup[inc_name] = "bilder" ;                       // Wert der Include Variabele (hier: $nav="bilder")


$setup[linkanhang] = "?nav=bilder" ;                 // Wird bei allen Links angehangen (so koennen nun beliebig viele Variablen mit uebergeben werden, z.B.: "?path=galery/index.php&user=otto&quark=lecker" - beachte vorgeschriebene schreibweise fuer php-variablenuebergabe!)

/* Es besteht die Moeglichkeit eigenen HTML-Code und die Metatags zur einfachereren
 Handhabung in externen Dateien zu verwalten. Diese Dateien sollten nur den HTML-Body
 (also das was zwischen <body> und </body> steht!), bzw. nur Metatags enthalten.                                                   */

$html_oben = "galerie_oben.html" ;                    // Name der Datei, in der der Code oberhalb der Galerie  steht
$html_unten = "galerie_unten.html" ;                  // Name der Datei, in der der Code unterhalb der Galerie steht
$html_meta = "galerie_meta.html" ;                    // Name der Datei, die Metatags enthält

// --- Ende Config ---------------------------------------------------------------------------

import_request_variables ('g');   // GET Variablen feischalten
$version = "toms-galerie V1.3" ;
error_reporting(0);



?>
<!--//


             +
             +
             +
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
             +
             +  Diese Seite wurde generiert von <?=$version?>  .
             +
             +  Wollen sie auch so eine Bildergalerie auf ihrer Homepage haben?
             +
             +
             +  Besuchen sie meine Seite:    http://www.tomshaus.de
             +
             +
             +
             +
             +
             +
             +  mfg Tom






Bitte diesen Hinweis nicht aus dem Quelltext entfernen!! Danke. :-)
//-->
<?
if ($include == 0) {

// oberer Bereich der HTML-Seite (ab <html> ) wird nur erzeugt wenn die Datei nicht includet wird ?>

<html>
<head>
<title><?=$name[browsertitel]?></title>
<?
if (is_file($html_meta)) {
   include ($html_meta) ;
   }
?>
<!--Eigene Megatags-->

<!--Ende Eigene Megatags-->
<link rel="stylesheet" href="form.css" type="text/css">
</head>
<body>

<? }
if (is_file($html_oben)) {
   include ($html_oben) ;
   }
/* -----------------------------------------------------------------------------------------------
 --- ab der naechten Zeile kann HTML-Code eingefuegt/geaendert werden, der ueber der Galerie ausgefuehrt wird ---   */ ?>










<? /*    --- Ab hier sollten keine Aenderungen mehr vorgenommen werden !!! ---
----------------------------------------------------------------------------------------------------------  */



$path_img = $setup[path_gal] ;  //Pfad zu den Bildern
//Galerien aus Verzeichnis in Aray lesen
$verz1=opendir($path_img);
while ($file = readdir ($verz1)) {  //Hauptbilderverzeichnis lesen

      //Bilder im Hauptverzeichnis lesen
      @$info = getimagesize($path_img.$file);
      $width = $info[0];
      $height = $info[1];
      $filetime = filemtime($path_img.$file);
      $filezugriff = fileatime($path_img.$file);
      $filesize = filesize($path_img.$file);
      if (is_file($path_img.$file) && ($info[2]==2 or $info[2]==$setup[gif]) && $info[0]<=$max[originalbildbreite] && $info[0]>=$min[originalbildbreite] && $info[1]<=$max[originalbildhoehe] && $info[1]>=$min[originalbildhoehe] && $max[originalbilddateigroesse]>=$filesize && $min[originalbilddateigroesse]<=$filesize) {
         $filename = $file ;
         $bilderdaten = array($file,$filesize,$filetime,$filezugriff,$info[0],$info[1],$info[2],$info[3]) ;
         $bilder["Hauptverzeichnis"][] = $bilderdaten ;

         $sort_bilder[] = $$sort[bilder];

         }


      if (is_dir($path_img.$file) && $file != "." && $file != "..") {  //Wenn ein Verzeichnis

         //Bilder aus Unterverzeichnis in Aray lesen
         $verz2=opendir($path_img.$file."/");
         while ($filename = readdir ($verz2)) {
               @$info = getimagesize($path_img.$file."/".$filename);
               $width = $info[0];
               $height = $info[1];
               $filetime = filemtime($path_img.$file."/".$filename);
               $filezugriff = fileatime($path_img.$file."/".$filename);
               $filesize = filesize($path_img.$file."/".$filename);
               if (is_file($path_img.$file."/".$filename) && ($info[2]==2 or $info[2]==$setup[gif]) && $info[0]<=$max[originalbildbreite] && $info[0]>=$min[originalbildbreite] && $info[1]<=$max[originalbildhoehe] && $info[1]>=$min[originalbildhoehe] && $max[originalbilddateigroesse]>=$filesize && $min[originalbilddateigroesse]<=$filesize) {
                  $bilderdaten = array($filename,$filesize,$filetime,$filezugriff,$info[0],$info[1],$info[2],$info[3]) ;
                  $bilder[$file][] = $bilderdaten ;
                  $galerievorschaubild[] = $bilderdaten ;
                  $sort_bilder[] = $$sort[bilder];
                  $sort_galerievorschau[] = $$sort[galerievorschau] ;
                  $bilderfiletime[] = $filetime;
                  }
               }
         closedir($verz2);

         //Bilder sortieren
         if (($sort[bilder] == "filename" && $sort[umkehren] != "ja") || ($sort[bilder] != "filename" && $sort[umkehren] == "ja"))
            array_multisort ($sort_bilder,SORT_ASC,$bilder[$file]);
         else
             array_multisort ($sort_bilder,SORT_DESC,$bilder[$file]);
         $sort_bilder = "";


         //Galerievorschaubild erzeugen
         if (($sort[galerievorschau] == "filename" && $sort[umkehren] != "ja") || ($sort[galerievorschau] != "filename" && $sort[umkehren] == "ja"))
            array_multisort ($sort_galerievorschau, $galerievorschaubild);
         else
             array_multisort ($sort_galerievorschau,SORT_DESC,$galerievorschaubild);
         $galerievorschau[$file] = $galerievorschaubild[0] ;
         $sort_galerievorschau = "" ;
         $galerievorschaubild = "" ;


         //Galeriedaten aufbereiten
         sort($bilderfiletime);
         $galeriename = $file ;
         $galeriedatum = filemtime($path_img.$file);
         $bilddatumneu =  end($bilderfiletime) ;
         $bilddatumalt =  reset($bilderfiletime) ;
         $bilderfiletime = "" ;
         $bildanzahl =  count($bilder[$file]) ;

         // Galeriedaten in Array lesen
         $galeriedaten = array($file,$galeriedatum,$bilddatumneu,$bilddatumalt,$bildanzahl) ;
         $galerie[] = $galeriedaten ;
         $sort_galerie[] = $$sort[galerie];

         // Anzahl der Bilder in Galerie berechnen
         $galeriebilder[$file] = $bildanzahl;

         }


      }
closedir($verz1);
//Galerien sortieren
if ((isset($galerie) && $sort[galerie] == "galeriename" && $sort[umkehren] != "ja") || (isset($galerie) && $sort[galerie] != "galeriename" && $sort[umkehren] == "ja"))
   array_multisort ($sort_galerie,SORT_ASC,$galerie );
elseif (isset($galerie))
       array_multisort ($sort_galerie,SORT_DESC,$galerie );


//Pfadvariable zu den Bildern definieren
if (isset($gal)) {
 $g = $galerie[$gal-1][0]."/" ;
 $path_img = $path_img.$g ;
 $galeriename = $galerie[$gal-1][0];
}
else $galeriename = "" ;
if (empty($gal) && isset($bilder["Hauptverzeichnis"])) $galeriename = "Hauptverzeichnis" ;


// Spaltenbreite in Prozent und Anzahl berechnen
if($max[spalten] < 1) $max[spalten] = 1 ;
$sg = count($galerie);
$sb = count($bilder[$galeriename]);
if ($sg < $max[spalten]) $max[spalten_galerie] = $sg ;
   else $max[spalten_galerie] = $max[spalten] ;
if ($sb < $max[spalten]) $max[spalten_bilder] = $sb ;
   else $max[spalten_bilder] = $max[spalten] ;
if($zeige[galerie] == 0) $max[spalten_galerie] = 0;
@$max[spaltenprozent_g] = 100 / $max[spalten_galerie];
@$max[spaltenprozent_b] = 100 / $max[spalten_bilder];

$copy ="<div align=\"right\"><span style=\" { font-size:8pt; color:#787C78; letter-spacing:2.5pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">$version<br>
</span><a href=\"http://www.tomshaus.de\" target=\"_blank\"><span style=\" { font-size:7pt; color:#787C78; letter-spacing:1pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">powered by</span> <span style=\" { font-size:14pt; color:#408080; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">t</span><span style=\" { font-size:8pt; color:#9B9B00; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">o</span><span style=\" { font-size:8pt; color:#8A0000; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">m</span><span style=\" { font-size:8pt; color:#0000A0; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">s</span><span style=\" { font-size:8pt; color:#7D007D; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">h</span><span style=\" { font-size:8pt; color:#6B6BB6; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">a</span><span style=\" { font-size:8pt; color:#00974B; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">u</span><span style=\" { font-size:8pt; color:#5B0000; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">s</span><span style=\" { font-size:10pt; color:#CCCC00; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">.</span><span style=\" { font-size:8pt; color:#9D0000; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">d</span><span style=\" { font-size:8pt; color:#DF7000; letter-spacing:2pt;  font-family:Verdana,Arial,sans-serif; font-weight:100; }\">e</span> <br></a>&nbsp;&nbsp;</div>" ;

//<span style=\"font-size:8pt; color:#9B9B00; letter-spacing:2pt; font-family:Verdana,Arial,sans-serif; font-weight:100;\">

//mittlerer Bereich der HTML-Seite (Gallerie) ?>

<div align="center">
<table class="galeriehintergrundrahmen" BORDER="0" CELLSPACING="<?=$css[galerierahmen]?>" CELLPADDING="<?=$css[galeriehintergrund]?>">
<tr>
 <td class="galeriehintergrund">
 <? if ($zeige[titel] == 1) { ?>
 <div align="center"><span class="gross"><?=$name[titel]?></span><br><br></div>
 <? } ?>
 <div align="center">



 <?
 // Zeige Galerie-Uebersicht in Uebersicht und Galerie, wenn  vorhanden



  //Galerieuebersicht untereinander
 if(!empty($galerie) && empty($bild) && empty($gal) && $max[spalten_galerie] == 0) { ?>

<table WIDTH="100%" class="tabellenrahmen" BORDER="0" CELLSPACING="<?=$css[tabellenrahmen]?>" CELLPADDING="<?=$css[tabellenhintergrund]?>">
 <? if($zeige[titelbox] == 1 || $zeige[titelbox] == 4 || $zeige[titelbox] == 12 || $zeige[titelbox] == 13) { ?>
 <tr>
     <td class="tabellenhintergrund" colspan="2">
      <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>"><b><?=$link[gal]?></b></a>
      <nobr><span class="klein">
      <?
      if ($zeige[galerieanzahl] == 1) {
      echo " $name[trenner] (Es  " ;
      if (count($galerie) > 1) echo "sind " ;
        else echo "ist " ;
      if (isset($galerie)) echo count($galerie) . " Galerie" ;
      if (count($galerie) > 1) echo "n " ;
      echo " vorhanden.)" ;
      } ?>
      </span></nobr>
     </td>
 </tr>
 <? }
 for ($i=0;$i<count($galerie);$i++) { ?>
 <tr>

    <td class="tabellenhintergrund" VALIGN="TOP" WIDTH="1%">
    <?
    if ($galerie[$i][0]!="") { ?>
    <div align="center">
    <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$i+1?>">
    <?
       $g = $galerie[$i][0] ;
       $img = $galerievorschau[$galerie[$i][0]][0] ;
       $tumb = $setup[path_cache]."t_".$max[tmb_gal_width]."_".$g."_".$img ;
       $im = $setup[path_gal].$galerie[$i][0]."/".$img;
       $info = getimagesize($im);  //Bildgröße
       if ($info[1] < $info[0])  $a = $info[0] / $max[tmb_gal_width]; //Thumbnailgröße Vorschau
       else $a = $info[1] / $max[tmb_gal_width];
       $tx = round($info[0] / $a);
       $ty = round($info[1] / $a);
       if ($max[tmb_gal_width] < $info[0]) {  // Wenn Originalbild groesser als Thumbnail
          if (is_file($tumb)) {  // wenn ein Thumbnail im Cache, dann zeigen ?>
             <img src="<?=$tumb?>" width="<?=$tx?>" height="<?=$ty?>" alt="<?=$galerie[$i][0]?>" border="0">
          <? } else { // sonst erzeugen ?>
             <img  src="<?=$setup[thumbnail]?>?path_img=<?=$setup[path_gal].$galerie[$i][0]."/"?>&img=<?=$img?>&path_cache=<?=$setup[path_cache]?>&max=<?=$max[tmb_gal_width]?>&cache=<?=$setup[cache]?>&gal=<?=$g?>" width="<?=$tx?>" height="<?=$ty?>" border="0" alt="<?=$galerie[$i][0]?>">
          <? }
          }
        else { ?>
             <img src="<?=$im?>" width="<?=$info[0]?>" height="<?=$info[1]?>" border="0" alt="">
        <? } ?>
    </span></a>
    </div>
    <?
    $beschreibung = $setup[path_gal].$galerie[$i][0].'.txt' ;
    if (is_file($beschreibung)) { ?>

    <? }
    } ?>
    </td>
    <td class="tabellenhintergrund" VALIGN="TOP" WIDTH="99%">
    <span class="klein">
    <?
    $g=$i+1;
    if ($zeige[galeriezahl] == 1 || $zeige[galeriezahl] == 4 || $zeige[galeriezahl] == 12 || $zeige[galeriezahl] == 13) echo "<nobr><b>$name[galerie] $g</b> $name[trenner]";
    if ($zeige[galeriename] == 1 || $zeige[galeriename] == 4 || $zeige[galeriename] == 12 || $zeige[galeriename] == 13) echo "<a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$g\"> ". $galerie[$i][0]."</a> $name[trenner]" ;
    if ($zeige[bildanzahl] == 1 || $zeige[bildanzahl] == 3) {
       echo "(";
       if ($galeriebilder[$galerie[$i][0]] == 0) echo "kein " ;
       else echo $galeriebilder[$galerie[$i][0]] ?>
    Bild<? if ($galeriebilder[$galerie[$i][0]] > 1) echo "er " ;?> vorhanden.)</nobr>
    <? } ?>
    <hr noshade size="1">
    <span class="beschreibung_galerie">
    <?
    $text = nl2br(htmlentities(strip_tags(stripslashes(implode('',file($beschreibung))))));
    if (strlen($text) > $textlaenge[galerie] && $action !="gesamt".$i) {
       $text = wordwrap($text,$textlaenge[galerie],"%@@%");
       $text = substr($text,0,strpos($text,"%@@%"));
       echo $text." <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&action=gesamt$i\">[...]<div align=\"right\"><nobr> $link[text_all]</nobr></div></a>";
    }
    else echo $text;
    if (strlen($text) > $textlaenge[galerie] && $action =="gesamt".$i)
       echo " <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]\"><div align=\"right\"><nobr>$link[text_kurz]</nobr></div></a>";
    ?>
    </span>
    </td>
 </tr>
 <?  }
 if($zeige[linkbox] == 1 || $zeige[linkbox] == 4 || $zeige[linkbox] == 12 || $zeige[linkbox] == 13) { ?>
 <tr>
     <td class="tabellenhintergrund" colspan="2">
     <a href="<?=$setup[startseite]?>" target="_top"><span class="klein"><?=$link[startseite]?></span></a>
     </td>
 </tr>
 <? } ?>
 </table>

 <? }


 //Galerieuebersicht nebeneinander
 elseif (!empty($galerie) && empty($bild) && empty($gal) && $max[spalten_galerie] != 0) {   ?>
 <table class="tabellenrahmen" BORDER="0" CELLSPACING="<?=$css[tabellenrahmen]?>" CELLPADDING="<?=$css[tabellenhintergrund]?>">
 <? if($zeige[titelbox] == 1 || $zeige[titelbox] == 4 || $zeige[titelbox] == 12 || $zeige[titelbox] == 13) { ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_galerie]?>">
      <div align="center"><a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>"><b><?=$link[gal]?></b></a><br><br>
      <nobr><span class="klein">
      <?
      echo "Es  " ;
      if (count($galerie) > 1) echo "sind " ;
        else echo "ist " ;
      if (isset($galerie)) echo count($galerie) . " Galerie" ;
      if (count($galerie) > 1) echo "n " ;
      echo " vorhanden.<br>" ;
      ?>
      </span></nobr>
      </div>
     </td>
 </tr>
 <? }
  for ($i=0;$i<count($galerie);$i++) { ?>
 <tr>
 <? for ($j=0;$j<$max[spalten_galerie];$j++) { ?>
    <td class="tabellenhintergrund" VALIGN="TOP" WIDTH="<?=$max[spaltenprozent_g]?>%">
    <?
    if ($galerie[$i][0]!="") { ?>
    <div align="center">
    <span class="klein"><b>Galerie <?=$i+1?></b><br>
    <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$i+1?>"> <nobr><?=$galerie[$i][0]?></nobr> <br><br>
    <?
       $g = $galerie[$i][0] ;
       $img = $galerievorschau[$galerie[$i][0]][0] ;
       $tumb = $setup[path_cache]."t_".$max[tmb_gal_width]."_".$g."_".$img ;
       $im = $setup[path_gal].$galerie[$i][0]."/".$img;
       $info = getimagesize($im);  //Bildgröße
       if ($info[1] < $info[0])  $a = $info[0] / $max[tmb_gal_width]; //Thumbnailgröße Vorschau
       else $a = $info[1] / $max[tmb_gal_width];
       $tx = round($info[0] / $a);
       $ty = round($info[1] / $a);
       if ($max[tmb_gal_width] < $info[0]) {  // Wenn Originalbild groesser als Thumbnail
          if (is_file($tumb)) {  // wenn ein Thumbnail im Cache, dann zeigen ?>
             <img src="<?=$tumb?>" width="<?=$tx?>" height="<?=$ty?>" alt="<?=$galerie[$i][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de" border="0">
             <? } else { // sonst erzeugen ?>
             <img  src="<?=$setup[thumbnail]?>?path_img=<?=$setup[path_gal].$galerie[$i][0]."/"?>&img=<?=$img?>&path_cache=<?=$setup[path_cache]?>&max=<?=$max[tmb_gal_width]?>&cache=<?=$setup[cache]?>&gal=<?=$g?>" width="<?=$tx?>" height="<?=$ty?>" border="0" alt="<?=$galerie[$i][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de">
          <? }
          }
        else { ?>
             <img src="<?=$im?>" width="<?=$info[0]?>" height="<?=$info[1]?>" border="0" alt="">
        <? } ?>
    </span></a>
    </div>
    <?
    $beschreibung = $setup[path_gal].$galerie[$i][0].'.txt' ;
    if (is_file($beschreibung)) { ?>
    <span class="beschreibung_galerie">
    <?
    $text = nl2br(htmlentities(strip_tags(stripslashes(implode('',file($beschreibung))))));
    if (strlen($text) > $textlaenge[galerie] && $action !="gesamt".$i) {
       $text = wordwrap($text,$textlaenge[galerie],"%@@%");
       $text = substr($text,0,strpos($text,"%@@%"));
       echo $text." <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&action=gesamt$i\">[...]</a>";
    }
    else echo $text;
    if (strlen($text) > $textlaenge[galerie] && $action =="gesamt".$i)
       echo " <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]\"><div align=\"right\"><nobr>Eintrag k&uuml;rzen</nobr></div></a>";
    ?>
    </span>
    <? } ?>
    <? $i++; } ?>
    </td>
    <? } ?>
 </tr>
 <? $i--; } ?>
 <?
 if($zeige[linkbox] == 1 || $zeige[linkbox] == 4 || $zeige[linkbox] == 12 || $zeige[linkbox] == 13) { ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_galerie]?>">
     <div align="center">
     <a href="<?=$setup[startseite]?>" target="_top"><span class="klein"><?=$link[startseite]?></span></a>
     </div>
     </td>
 </tr>
 <? } ?>
 </table>
 <? }
 // Ende Galerieuebersicht


 // Zeige Bilderuebersicht, wenn kein Bild gewaehlt aber nur wenn Bild vorhanden

 if ((empty($bild) && isset($bilder[$galeriename])) || (empty($bild) && empty($bilder[$galeriename]) && !empty($gal)) || (empty($bild) && empty($bilder) && empty($galerie))) {  ?>
 <table class="tabellenrahmen" BORDER="0" CELLSPACING="<?=$css[tabellenrahmen]?>" CELLPADDING="<?=$css[tabellenhintergrund]?>" WIDTH="100%">
 <? if (!empty($gal) && ($zeige[galerienavbox] == 1 || $zeige[galerienavbox] ==3)) {  ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_bilder]?>">
         <div align="center">
         <span class="klein"><?=$name[galerie]?>
         <?
          for ($i=0;$i<count($galerie);$i++) {
              $j = $i + 1;
              echo "<a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$j\">$j</a> " ;
              }
         ?>
         <br><br></span>
         <table WIDTH="99%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
         <tr>
           <?
           $back = $gal -1;   // Navberechnungen
           $next = $gal +1;
           if ($back < 0) $back = "" ;
           if ($next > count($galerie)) $next = "" ;
           ?>
             <td WIDTH="33%"><div align="left">
                 <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$back?>">
                 <span class="klein"><?=$link[gal_zurueck]?></span></a></div></td>
             <td WIDTH="33%"><div align="center">
                 <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>">
                 <span class="klein"><?=$link[gal]?></span></a></div></td>
             <td WIDTH="33%"><div align="right">
                 <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$next?>">
                 <span class="klein"><?=$link[gal_weiter]?></span></a></div></td>
         </tr>
         </table>
         </div>
     </td>
 </tr>
 <? }
 if($zeige[titelbox] == 2 || $zeige[titelbox] == 4 || $zeige[titelbox] == 12 || $zeige[titelbox] == 23) { ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_bilder]?>">
     <div align="center">
     <? if (!empty($gal)) { ?>
     <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$gal?>"><b>
     <? echo $link[galerie];
        if ($zeige[galeriezahl] == 2 || $zeige[galeriezahl] == 4 || $zeige[galeriezahl] == 12 || $zeige[galeriezahl] == 23) echo " ".$gal ;
        if ($zeige[galeriename] == 2 || $zeige[galeriename] == 4 || $zeige[galeriename] == 12 || $zeige[galeriename] == 23) echo ": ".$galerie[$gal-1][0]; ?></b></a>
     <? } ?>
     <span class="klein">
     <?
     if ($zeige[bildanzahl] == 2 || $zeige[bildanzahl] == 3) {
     echo "<br><br>Es  " ;
     if ((count($galerie) > 1 && empty($gal)) || count($bilder[$galeriename]) > 1) echo "sind " ;
        else echo "ist " ;
     if (isset($galerie) && empty($gal)) echo count($galerie) . " Galerie" ;
     if (count($galerie) > 1 && empty($gal)) echo "n " ;
     if (isset($bilder[$galeriename]) && isset($galerie) && empty($gal)) echo " und " ;
     if (isset($bilder[$galeriename])) echo count($bilder[$galeriename]) . " Bild" ;
     if (!isset($bilder[$galeriename]) || !isset($galerie) && isset($gal))  echo " kein Bild" ;
     if (count($bilder[$galeriename]) > 1) echo "er " ;
     if ($zeige[galeriezahl] == 2 || $zeige[galeriezahl] == 4 || $zeige[galeriezahl] == 12 || $zeige[galeriezahl] == 23) {
        if (!empty($gal)) echo " in $name[galerie] " . $gal ;
        }
     echo " vorhanden.<br>" ;
     } ?>
     </span>
     </div>
     </td>
 </tr>
 <? }
 //Berechnung max Bilder pro Seite
 if (empty($bildzaehler)) $bildzaehler = 0 ;
 $bildzaehlerstop = $max[vorschaubilder] + $bildzaehler ;
 if ($bildzaehlerstop > count($bilder[$galeriename])) $bildzaehlerstop = count($bilder[$galeriename]) ;
  for ($i=$bildzaehler ; $i < $bildzaehlerstop ; $i++) { ?>
 <tr>
 <? for ($j=0;$j<$max[spalten_bilder];$j++) { ?>
    <td class="tabellenhintergrund" VALIGN="TOP" WIDTH="<?=$max[spaltenprozent_b]?>%">
    <?
    if ($bilder[$galeriename][$i][0]!="") {
    $info = getimagesize($path_img.$bilder[$galeriename][$i][0]);  //Bildgröße
                                               //Bildgröße für mittleres Bild berechnen
    if ($max[bild_width] > $info[0]) {
       $x = $info[0];
       $y = $info[1];
       }
    else {
      if ($info[1] < $info[0])  $a = $info[0] / $max[bild_width];
      else $a = $info[1] / $max[bild_width];
      $x = round($info[0] / $a);
      $y = round($info[1] / $a);
      }

    if ($info[1] < $info[0])  $a = $info[0] / $max[tmb_width];
      else $a = $info[1] / $max[tmb_width];
      $tx = round($info[0] / $a);
      $ty = round($info[1] / $a);
    ?>
    <div align="center"> <span class="klein">
    <?
    $b=$i+1;
    if ($zeige[bildzahl]==1 || $zeige[bildzahl]==3) echo "<b>$name[bild] $b</b>";
    $beschreibung = $path_img.$bilder[$galeriename][$i][0].'.txt' ;
    if (is_file($beschreibung) && $zeige[bildtext_uebersicht]==2) {
    echo "<br>";
    $text = nl2br(htmlentities(strip_tags(stripslashes(implode('',file($beschreibung))))));
    if (strlen($text) > $textlaenge[bilduebersicht] && $action !="gesamt") {
       $text = wordwrap($text,$textlaenge[bilduebersicht],"%@@%");
       $text = substr($text,0,strpos($text,"%@@%"));
       echo $text."<a href=\"$beschreibung\" target=\"_blank\">...</a>";
    }
    else echo $text;
    }

    if ($zeige[bildname] == 1 || $zeige[bildname] == 3) echo "<br>" . $bilder[$galeriename][$i][0]; ?>
    <br><br>
    <?
    $img = $bilder[$galeriename][$i][0] ;
    $tumb = $setup[path_cache]."t_".$max[tmb_width]."_".$galeriename."_".$img ;
    if ($max[tmb_width] < $info[0]) { //Wenn Originalbild groesser als Thumbnail ?>
          <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&bild=<?=$i+1?>&gal=<?=$gal?>">
          <? if (is_file($tumb)) {  // wenn ein Thumbnail im Cache, dann zeigen ?>
          <img src="<?=$tumb?>" width="<?=$tx?>" height="<?=$ty?>" alt="<?=$bilder[$galeriename][$i][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de" border="0"><br>
          <? } else { // sonst erzeugen ?>
          <img  src="<?=$setup[thumbnail]?>?path_img=<?=$path_img?>&img=<?=$bilder[$galeriename][$i][0]?>&path_cache=<?=$setup[path_cache]?>&max=<?=$max[tmb_width]?>&cache=<?=$setup[cache]?>&gal=<?=$galeriename?>" width="<?=$tx?>" height="<?=$ty?>" border="0" alt="<?=$bilder[$galeriename][$i][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de"><br>
          <? } ?>
    <? } else { ?>
     <img src="<?=$path_img.$img?>" width="<?=$info[0]?>" height="<?=$info[1]?>" border="0" alt="<?=$bilder[$galeriename][$i][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de"><br>
    <? } ?>
    <nobr>
    <? if ($zeige[bildgroesse] == 1 || $zeige[bildgroesse] == 3) {
          echo $x." X ".$y ;
          if ($max[bild_width] > $info[0]) echo "*" ;
          echo "</nobr><br>" ;
       } ?>
    </span></a>
    <? if ($max[bild_width] < $info[0] && $zeige[vollbildlink] > 0) { ?>
    <a href="<?=$path_img.$bilder[$galeriename][$i][0]?>" target="_blank">
    <span class="klein"><nobr>
    <?=$link[vollbild_u] ;
    if ($zeige[bildgroesse_vollbild] == 1 || $zeige[bildgroesse_vollbild] == 3) echo " (".$info[0]." X ".$info[1].") *" ; ?>
    </nobr></span></a>
    <? } ?>
    <br><span class="klein">
    <?
    $beschreibung = $path_img.$bilder[$galeriename][$i][0].'.txt' ;
    if (is_file($beschreibung) && $zeige[bildtext_uebersicht]==1) {
    $text = nl2br(htmlentities(strip_tags(stripslashes(implode('',file($beschreibung))))));
    if (strlen($text) > $textlaenge[bilduebersicht] && $action !="gesamt") {
       $text = wordwrap($text,$textlaenge[bilduebersicht],"%@@%");
       $text = substr($text,0,strpos($text,"%@@%"));
       echo $text."<a href=\"$beschreibung\" target=\"_blank\">...</a>";
    }
    else echo $text;
    }
    ?></span>
    </div>
    <? $i++; } ?>
    </td>
 <? } ?>
 </tr>
 <? $i--; }
if ($max[vorschaubilder] < count($bilder[$galeriename])) {
 $bildanzahl = $i - $bildzaehler ;
 $bildzaehler_weiter = $i;
 if(($bildzaehler_weiter + $bildanzahl) > count($bilder[$galeriename])) $bildzaehler_weiter = count($bilder[$galeriename]) - $bildanzahl;
 $bildzaehler_zuruck = $bildzaehler - $bildanzahl;
 if ($bildzaehler_zuruck < 0) $bildzaehler_zuruck = 0 ;
 ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_bilder]?>">
         <table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
         <tr>
             <td>
             <span class="klein">
             <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$gal?>&bildzaehler=<?=$bildzaehler_zuruck?>">
             <?
             $von = $bildzaehler_zuruck +1;
             if ($von < 1) $von = 1 ;
             $bis = $von + $bildanzahl -1;
             echo "$name[rueckpfeil] $name[bild] $von bis $bis";
             ?></a></span>
             </td>
             <td>
             <div align="right">
             <span class="klein">
             <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$gal?>&bildzaehler=<?=$bildzaehler_weiter?>">
             <?
             $von = $bildzaehler_weiter + 1;
             $bis = $von + $bildanzahl -1;
             if ($bis > count($bilder[$galeriename])) $bis = count($bilder[$galeriename]) ;
             echo "$name[bild] $von bis $bis $name[weiterpfeil]";
             ?></a></span></div>
             </td>
         </tr>
         </table>
     </td>
 </tr>
<? }
 if($zeige[linkbox] == 2 || $zeige[linkbox] == 4 || $zeige[linkbox] == 12 || $zeige[linkbox] == 23) { ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_bilder]?>">
     <div align="center">
     <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>"><span class="mittel"><b><?=$link[gal]?></b></span></a><br>
     <a href="<?=$setup[startseite]?>" target="_top"><span class="klein"><?=$link[startseite]?></span></a>
     </div>
     </td>
 </tr>
 <? }
  if (!empty($gal) && ($zeige[galerienavbox] == 2 || $zeige[galerienavbox] ==3)) {  ?>
 <tr>
     <td class="tabellenhintergrund" colspan="<?=$max[spalten_bilder]?>">
         <div align="center"><span class="mittel">
         <?=$name[galerie]?>
         <?
         for ($i=0;$i<count($galerie);$i++) {
         $j = $i + 1;
         echo "<a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$j\">$j</a> " ;
         }
         ?>
         </span></div>
     </td>
 </tr>
 <? } ?>
 </table>
 <? }

 // Ende Uebersicht

 // Zeige Bild, wenn Bild gewaehlt

 elseif (!empty($bild) && isset($bilder)) {
 $back = $bild -1;   // Navberechnungen
 $im =  $bild -1;
 $next = $bild +1;
 $t_back = $bild -2;
 if ($back < 1) $back = "" ;
 if ($next > count($bilder[$galeriename])) $next = "" ;
 $info = getimagesize($path_img.$bilder[$galeriename][$im][0]);  //Bildgröße
 if ($info[1] < $info[0])  $a = $info[0] / $max[bild_width]; //Thumbnailgröße Vorschau
 else $a = $info[1] / $max[bild_width];
 $tx = round($info[0] / $a);
 $ty = round($info[1] / $a);
 $beschreibung = $path_img.$bilder[$galeriename][$im][0].'.txt' ;
 ?>
 <table WIDTH="1%" class="tabellenrahmen" BORDER="0" CELLSPACING="<?=$css[tabellenrahmen]?>" CELLPADDING="<?=$css[tabellenhintergrund]?>">
 <? if($zeige[titelbox] == 3 || $zeige[titelbox] == 4 || $zeige[titelbox] == 13 || $zeige[titelbox] == 23) { ?>
 <tr>
     <td class="tabellenhintergrund">
     <table WIDTH="99%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
     <tr>
         <td WIDTH="33%" VALIGN="TOP">
         <div align="left"><a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&bild=<?=$back?>&gal=<?=$gal?>"><span class="klein"><?=$link[bild_zurueck]?></span></a></div></td>
         <td WIDTH="33%" VALIGN="BOTTOM">
         <div align="center">
         <? if ($zeige[bildzahl]==2 || $zeige[bildzahl]==3) echo "<b>Bild $bild";?>
         <br><span class="klein">
         <? if ($zeige[bildname] == 2 || $zeige[bildname] == 3) echo "<br>" . $bilder[$galeriename][$im][0] . "<br>"; ?>
         </span></div> </td>
         <td WIDTH="33%" VALIGN="TOP">
         <div align="right"><a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&bild=<?=$next?>&gal=<?=$gal?>"><span class="klein"><?=$link[bild_weiter]?></span></a></div></td>
     </tr>
     </table>
     </td>
 </tr>
 <? }
 if (is_file($beschreibung) && $zeige[bildtext]==2) { ?>
 <tr>
     <td class="tabellenhintergrund">
     <span class="beschreibung_bild">
     <?
    $text = nl2br(htmlentities(strip_tags(stripslashes(implode('',file($beschreibung))))));
    if (strlen($text) > $textlaenge[bild] && $action !="gesamt") {
       $text = wordwrap($text,$textlaenge[bild],"%@@%");
       $text = substr($text,0,strpos($text,"%@@%"));
       echo $text." <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$gal&bild=$bild&action=gesamt\">[...]<div align=\"right\"><nobr> Eintrag vollständig ansehen</nobr></div></a>";
    }
    else echo $text;
    if (strlen($text) > $textlaenge[bild] && $action =="gesamt".$i)
       echo " <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$gal&bild=$bild\"><div align=\"right\"><nobr>Eintrag k&uuml;rzen</nobr></div></a>";
    ?>
    </span>
    </td>
 </tr>
 <? } ?>
 <tr>
     <td class="tabellenhintergrund">
     <div align="center">
     <? if ($max[bild_width] < $info[0]) { ?>
        <a href="<?=$path_img.$bilder[$galeriename][$im][0]?>" target="_blank">
        <?
        if ($setup[cache] == 1) $setup[cache] = 0 ;
        $img = $bilder[$galeriename][$im][0] ;
        $tumb = $setup[path_cache]."t_".$max[bild_width]."_".$galeriename."_".$img ;
        if (is_file($tumb)) {  // wenn ein Thumbnail im Cache, dann zeigen ?>
           <img src="<?=$tumb?>" width="<?=$tx?>" height="<?=$ty?>" alt="<?=$bilder[$galeriename][$im][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de" border="0"><br>
        <? } else { // sonst erzeugen ?>
           <img  src="<?=$setup[thumbnail]?>?path_img=<?=$path_img?>&img=<?=$bilder[$galeriename][$im][0]?>&path_cache=<?=$setup[path_cache]?>&max=<?=$max[bild_width]?>&cache=<?=$setup[cache]?>&gal=<?=$galeriename?>" width="<?=$tx?>" height="<?=$ty?>" border="0" alt="<?=$bilder[$galeriename][$im][0]?> --- erstellt mit <?=$version?> - www.tomshaus.de"><br>
        <? } ?>
     <nobr><span class="klein"><?=$link[vollbild] ;
     if ($zeige[bildgroesse_vollbild] == 2 || $zeige[bildgroesse_vollbild] == 3) echo " (".$info[0]." X ".$info[1].") *" ; ?>
     </span></a>
     <? } else { ?>
     <img src="<?=$path_img.$bilder[$galeriename][$im][0]?>" width="<?=$info[0]?>" height="<?=$info[1]?>" border="0" alt=""><br>
     <span class="klein">
     <? if ($zeige[bildgroesse] == 2 || $zeige[bildgroesse] == 3) echo $info[0]." X ".$info[1]." *" ; ?>
     </span></nobr>
     <? } ?>
     <br>
     </td>
 </tr>
 <?
 if (is_file($beschreibung) && $zeige[bildtext]==1) { ?>
 <tr>
     <td class="tabellenhintergrund">
     <span class="beschreibung_bild">
     <?
    $text = nl2br(htmlentities(strip_tags(stripslashes(implode('',file($beschreibung))))));
    if (strlen($text) > $textlaenge[bild] && $action !="gesamt") {
       $text = wordwrap($text,$textlaenge[bild],"%@@%");
       $text = substr($text,0,strpos($text,"%@@%"));
       echo $text." <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$gal&bild=$bild&action=gesamt\">[...]<div align=\"right\"><nobr> Eintrag vollständig ansehen</nobr></div></a>";
    }
    else echo $text;
    if (strlen($text) > $textlaenge[bild] && $action =="gesamt".$i)
       echo " <a href=\"$setup[dateiname]?$setup[inc_var]=$setup[inc_name]&gal=$gal&bild=$bild\"><div align=\"right\"><nobr>Eintrag k&uuml;rzen</nobr></div></a>";
    ?>
    </span>
    </td>
 </tr>
 <? }
 if($zeige[linkbox] == 3 || $zeige[linkbox] == 4 || $zeige[linkbox] == 13 || $zeige[linkbox] == 23) { ?>
 <tr>
     <td class="tabellenhintergrund">
     <table WIDTH="99%" BORDER="0" CELLSPACING="0" CELLPADDING="4">
     <tr>
         <td WIDTH="33%" VALIGN="BOTTOM">
         <div align="left">
         <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&bild=<?=$back?>&gal=<?=$gal?>">
         <?
         $img = $bilder[$galeriename][$back-1][0] ;
         $tumb = $setup[path_cache]."t_".$max[tmb_bild_width]."_".$galeriename."_".$img ;
         if ($max[tmb_width] < $bilder[$galeriename][$back-1][4] || $img == "") {
               if (is_file($tumb)) {  // wenn ein Thumbnail im Cache, dann zeigen ?>
                  <img src="<?=$tumb?>" alt="<?="$link[bild_alt_zurueck] $back"?>" border="0"><br>
               <? } elseif (empty($img)) {
                    if (is_file($setup[nullgif])) { ?>
                       <img src="<?=$setup[nullgif]?>" width="<?=$max[tmb_bild_width]?>" height="<?=$max[tmb_bild_width]?>" border="0" alt="<?=$link[gal]?>"><br>
               <? }} else { // sonst erzeugen ?>
                  <img  src="<?=$setup[thumbnail]?>?path_img=<?=$path_img?>&img=<?=$bilder[$galeriename][$back-1][0]?>&path_cache=<?=$setup[path_cache]?>&max=<?=$max[tmb_bild_width]?>&cache=<?=$setup[cache]?>&gal=<?=$galeriename?>" border="0" alt="<?="$link[bild_alt_zurueck] $back"?>"><br>
               <? }
            }
          else { ?>
               <img src="<?=$path_img.$bilder[$galeriename][$back-1][0]?>" border="0" alt="<?="$link[bild_alt_zurueck] $back"?>"><br>
              <? }
         if (empty($img)) { ?>
         <span class="klein"><?=$link[gal]?></span></a>
         <? } else { ?>
         <span class="klein"><?=$link[bild_zurueck]?></span></a>
         <? } ?>
         </div></td>
         <td WIDTH="33%" VALIGN="TOP">
         <div align="center">
         <br>
         <? if(isset($galerie)) { ?>
         <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&gal=<?=$gal?>"><nobr><b>
         <? echo $link[galerie];
            if ($zeige[galeriezahl] == 3 || $zeige[galeriezahl] == 4 || $zeige[galeriezahl] == 13 || $zeige[galeriezahl] == 23) echo " ".$gal ;
            if ($zeige[galeriename] == 3 || $zeige[galeriename] == 4 || $zeige[galeriename] == 13 || $zeige[galeriename] == 23) echo ": ".$galerie[$gal-1][0]; ?></b></nobr></a><br><br>
         <? } ?>
         <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>"><span class="mittel"><b><?=$link[gal]?></b></span></a><br><br>
         <a href="<?=$setup[startseite]?>" target="_top"><span class="klein"><?=$link[startseite]?></span></a>
         </div></td>
         <td WIDTH="33%" VALIGN="BOTTOM">
         <div align="right">
         <a href="<?=$setup[dateiname]?><?=$setup[linkanhang]?>&bild=<?=$next?>&gal=<?=$gal?>">
         <?
         $img = $bilder[$galeriename][$bild][0] ;
         $tumb = $setup[path_cache]."t_".$max[tmb_bild_width]."_".$galeriename."_".$img ;

         if ($max[tmb_width] < $bilder[$galeriename][$bild][4] || $img == "") {

               if (is_file($tumb)) {  // wenn ein Thumbnail im Cache, dann zeigen ?>
               <img src="<?=$tumb?>" alt="<?="$link[bild_alt_weiter] $next"?>" border="0"><br>
               <? } elseif (empty($img)) {
                     if (is_file($setup[nullgif])) { ?>
                     <img src="<?=$setup[nullgif]?>" width="<?=$max[tmb_bild_width]?>" height="<?=$max[tmb_bild_width]?>" border="0" alt="<?=$link[gal]?>"><br>
               <? }} else { // sonst erzeugen ?>
               <img  src="<?=$setup[thumbnail]?>?path_img=<?=$path_img?>&img=<?=$bilder[$galeriename][$bild][0]?>&path_cache=<?=$setup[path_cache]?>&max=<?=$max[tmb_bild_width]?>&cache=<?=$setup[cache]?>&gal=<?=$galeriename?>" border="0" alt="<?="$link[bild_alt_weiter] $next"?>"><br>
               <? }
               }
          else { ?>
               <img src="<?=$path_img.$bilder[$galeriename][$bild][0]?>" border="0" alt="<?="$link[bild_alt_weiter] $next"?>"><br>
              <? }


         if (empty($img)) { ?>
         <span class="klein"><?=$link[gal]?></span></a>
         <? } else { ?>
         <span class="klein"><?=$link[bild_weiter]?></span></a>
         <? } ?>
         </div></td>
     </tr>
     </table></div>
     </td>
 </tr>
 <? }
 if ($zeige[bildnavbox] == 1) { ?>
 <tr>
     <td class="tabellenhintergrund">
         <div align="center"><span class="mittel">
         <?=$name[bild]?>
         <?
         for ($i=0;$i<count($bilder[$galeriename]);$i++) {
         $j = $i + 1;
         echo "<a href=\"$setup[dateiname]$setup[linkanhang]&gal=$gal&bild=$j\">$j</a> " ;
         }
         ?>
         </span></div>
     </td>
 </tr>
 <? } ?>
 </table>


 <? }
 //Ende Bild  ?>



 </div>
 <span class="klein"><br>
 <? if (isset($bilder) && $zeige[erlklaerung] == 1)
       echo $name[erklaerung];

if ($zeige[cachestatus] == 1) {
    echo "Cache: " ;
    if ($setup[cache] == 2 ) echo "alle Vorschaubilder" ;
    elseif ($setup[cache] == 1 ) echo "nur kleine Vorschaubilder" ;
    else echo "aus" ;
}
?>
</span>
 <?=$copy?>
 </td>
</tr>
</table></div>

<?
if (is_file($html_unten)) {
   include ($html_unten) ;
   }
/*  --------------------------------------------------------------------------------------------
  --- Ende des mittlerern Bereiches der HTML-Seite (Gallerie) ---
--- ab der naechten Zeile kann HTML-Code eingefuegt/geaendert werden, der unter der Galerie ausgefuehrt wird ---   */ ?>










<? /* --- Ab hier sollten keine Aenderungen mehr vorgenommen werden !!! ---
----------------------------------------------------------------------------------------------- */
if ($include == 0) echo "</body></html>" ;
// --- Ende des Scripts ----------------------------------------------------------------------- ?>