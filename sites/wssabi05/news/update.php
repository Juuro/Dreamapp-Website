<?
#########################################################
#                     ParaNews v3.3a                     #
#             Copyright (c) by Chris Rolle              #
#         [ chris@monxoom.de | www.monxoom.de ]         #
#########################################################
#    This script can be used freely as long as this     #
#     copyright-notice remains here. Furthermore a      #
#   copyright-notice must be displayed on the website   #
#              where this script is used.               #
#                                                       #
#    See readme.htm for further copyright information   #
#########################################################

#########################################################
#                      FUNCTIONS                        #
#########################################################	
function getid($user, $userfile) {
	$zeile 	= file($userfile);
	$zeilen = sizeof($zeile);

	for ($i=0; $i<$zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 
		if($eintrag[0] == $user) return $eintrag[3];
	}
}

function my_nl2br ($text) {
$retvalue = "";
for ($ii = 0; $ii < strlen($text); $ii++) {
	if ($text[$ii]!= chr(13))
	$text[$ii]=="\n" ? $retvalue .= "<br />" : $retvalue .= $text[$ii];
	}
return $retvalue;
}

function drawheader($header) {
echo'
<html>
<head>
<title>.:ParaNews 3.3a - Installation:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="admin/pn_styles.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
<br /><br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="4"><b>'.$header.'</b></font>
<br /><br />
<table width="90%" border="0" cellspacing="1" cellpadding="2" align="center" class="rahmen">
	  	<tr valign="top">
    		<td>';
}

function drawfooter() {
echo '<small><!-- Do not remove this copyright notice -->
Powered by <a href="http://www.monxoom.de" target="_blank">ParaNews</a> 3.3a
</small>
</div>
</body>
</html>';
}

#########################################################

if (file_exists('install.lock')) exit('Das Script wurde schon aktualisiert!');

if (!$_GET['go']) {
	drawheader('.:Update der User-Datenbank:.');
	echo"Das Script wird versuchen, die User-Datenbank (pn_userdata.php) zu aktualisieren.<br /><br />
	<b>Es ist empfehlenswert, vorher ein Backup der Datei anzulegen!</b><br />
	<br />
	Sollte das Update 
	fehlschlagen (was unwahrscheinlich ist, aber...), so wäre es nett, wenn ihr mir die Datei 
	mailen könntet, damit ich den Fehler untersuchen kann.<br /><br />";
	echo '<a href="'.$_SERVER['PHP_SELF'].'?art=upd&go=step2b">Fortfahren</a>';
}
#########################################################
#                        UPDATE                         #
#########################################################
if ($_GET['art'] == 'upd') {
#########################################################

	if ($_GET['go'] == 'step2b') {
	drawheader(".:Update der User-Datenbank:.");

      $datafile = 'inc/pn_userdata.php';
      $nl = chr(13).chr(10);
      
      
      
      $zeile = file($datafile);
      $zeilen = sizeof($zeile);
      
      $fp = fopen($datafile,"w+");
      fwrite($fp,'<?php'.$nl);
      fwrite($fp,'/*'.$nl);
      for ($i=0; $i<=$zeilen; $i++)
      fwrite($fp, $zeile[$i]);
      fwrite($fp, '*/' .$nl );
      fwrite($fp, '?>' );
      fclose($fp);


	echo 'Der Patch war erfolgreich!
	<br /><br />
	<a href="'.$_SERVER['PHP_SELF'].'?art=upd&go=step3">Fortfahren</a>';
	}
#########################################################
	if ($_GET['go'] == 'step3') {
	drawheader('.:Abschließende Hinweise:.');
	echo'Damit ist das Update auch schon abgeschlossen =)<br /><br />
	Du kannst Dich nun wie gehabt in das Admin-Center einloggen und das Script administrieren.<br />
	<br /><br />
	So, nun viel Spaß mit dem Script :) Wenn es dir gefällt, wenn du Bugs findest oder Vorschläge 
	für die nächste Version der ParaNews hast, würde ich mich über eine eMail freuen.
	<br />
	<b>Folge dem Link unten und lösche dann die Datei patch.php vom Server. Reloade danach die Seite.</b>
	<br /><br />
	<a href="index.php">Fortfahren (Ausgabeseite der ParaNews)</a>';
	
	$fp = fopen('install.lock', 'w+');
	fclose($fp);
	}
#########################################################
}
#########################################################
	echo'</td>
		  </tr>
		</table><br />';
drawfooter();


?>
