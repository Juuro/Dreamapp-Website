<?php
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

include '../inc/functions.inc.php';
checklogin();
adminonlyaccess($_SESSION['loginlevel']);
$configfile = '../inc/config.inc.php';


drawheader('Edit Settings');
echo'<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
	  	<tr valign="top" class="tr3">
    		<td width="50%">';

if ($_GET['go'] == 'save') {
	if($_POST['newsperpage'] == 0) 	$_POST['newsperpage'] = 1;
	if($_POST['maxsize'] == '') 	$_POST['maxsize'] = 1048576;
	if($_POST['more'] == '') 		$_POST['more'] = 'Read More';
	if($_POST['logoutjump1'] == 0)	$_POST['logoutjump'] = '';
	if($_POST['logoutjump1'] == 1)	$_POST['logoutjump'] = $_POST['logoutjump'];
  	$fp = fopen($configfile,"w+");
	
	$inhalt = "<?php\n";
	$inhalt.= "\$smilies		= '".$_POST['smilies']."';\n";
	$inhalt.= "\$newsperpage	= '".$_POST['newsperpage']."';\n";
	$inhalt.= "\$texthtml		= '".$_POST['texthtml']."';\n";
	$inhalt.= "\$commenthtml	= '".$_POST['commenthtml']."';\n";
	$inhalt.= "\$maxsize		= '".$_POST['maxsize']."';\n";
	$inhalt.= "\$more			= '".$_POST['more']."';\n";
	$inhalt.= "\$nexttext		= '".$_POST['nexttext']."';\n";
	$inhalt.= "\$lasttext		= '".$_POST['lasttext']."';\n";
	$inhalt.= "\$showcat		= '".$_POST['showcat']."';\n";
	$inhalt.= "\$catpics		= '".$_POST['catpics']."';\n";
	$inhalt.= "\$dateformat		= '".$_POST['dateformat']."';\n";
	$inhalt.= "\$newsoutput		= '".$_POST['newsoutput']."';\n";
	$inhalt.= "\$params			= '".$_POST['params']."';\n";
	$inhalt.= "\$logoutjump		= '".$_POST['logoutjump']."';\n";
	$inhalt.= "?>";
	
    fputs($fp,$inhalt);
		fclose($fp);
    echo '<b>Erfolgreich gespeichert!</b>';
}

include($configfile);
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>?go=save">
<b>In diesem Bereich k&ouml;nnen verschiedene Optionen der ParaNews angepasst 
werden.</b>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
 <tr class="tr1">
   <td width="50%">Text-Smilies wie &quot;:)&quot; oder &quot;:P&quot; gegen Bilder ersetzen?</td>
   <td width="50%">
	<select name="smilies"><?php
	if($smilies == 'no') echo'<option value="no" selected>Nein</option>';
	else echo'<option value="no">Nein</option>';
	if($smilies == 'yes') echo'<option value="yes" selected>Ja</option>';
	else echo'<option value="yes">Ja</option>';	
	?></select>
</td>
 </tr>
 <tr class="tr2">
   <td width="50%">News pro Seite:</td>
   <td width="50%">
	<input type="text" name="newsperpage" value="<?=$newsperpage?>">
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">HTML in den News-Texten?:</td>
   <td width="50%">
	<select name="texthtml"><?php
	if($texthtml == 'txt0') echo'<option value="txt0" selected>Nein</option>';
	else echo'<option value="txt0">Nein</option>';
	if($texthtml == 'txt1') echo'<option value="txt1" selected>Ja</option>';
	else echo'<option value="txt1">Ja</option>';	
	?></select>
</td>
 </tr>
 <tr class="tr2">
   <td width="50%">HTML in den Kommentaren?:</td>
   <td width="50%">
	<select name="commenthtml"><?php
	if($commenthtml == 'com0') echo'<option value="com0" selected>Nein</option>';
	else echo'<option value="com0">Nein</option>';
	if($commenthtml == 'com1') echo'<option value="com1" selected>Ja</option>';
	else echo'<option value="com1">Ja</option>';	
	?></select>
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">Maximale Größe (in Byte) für eine hochgeladene Datei:</td>
   <td width="50%">
	<input type="text" name="maxsize" value="<?=$maxsize?>">
</td>
 </tr>
 <tr class="tr2">
   <td width="50%">Wie soll der Link aussehen, der zur gesamten Newsartikel führt?</td>
   <td width="50%">
	<input type="text" name="more" value="<?=$more?>">
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">Wie soll der Link zum Vorbl&auml;ttern aussehen?</td>
   <td width="50%">
	<input type="text" name="nexttext" value="<?=$nexttext?>">
</td>
 </tr>
 <tr class="tr2">
   <td width="50%">Wie soll der Link zum Zur&uuml;ckbl&auml;ttern aussehen?</td>
   <td width="50%">
	<input type="text" name="lasttext" value="<?=$lasttext?>">
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">Kategoriesystem verwenden?:</td>
   <td width="50%">
	<select name="showcat"><?php
	if($showcat == 'no') echo'<option value="no" selected>Nein</option>';
	else echo'<option value="no">Nein</option>';
	if($showcat == 'yes') echo'<option value="yes" selected>Ja</option>';
	else echo'<option value="yes">Ja</option>';	
	?></select>
</td>
 </tr>
 <tr class="tr2">
   <td width="50%">Bilder oder Text-Anzeige für Kategorien?:</td>
   <td width="50%">
	<select name="catpics"><?php
	if($catpics == 'no') echo'<option value="no" selected>Text</option>';
	else echo'<option value="no">Text</option>';
	if($catpics == 'yes') echo'<option value="yes" selected>Bilder</option>';
	else echo'<option value="yes">Bilder</option>';	
	?></select>
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">Wie soll das Datum formatiert werden? (Die Parameter dazu <a href="http://de3.php.net/manual/de/function.date.php" target="_blank">hier</a>)</td>
   <td width="50%">
	<input type="text" name="dateformat" value="<?=$dateformat?>">
</td>
 </tr>
 <tr class="tr2">
   <td colspan="2">
	<b>Falls die ParaNews in eine Site-Engine eingebaut werden:</b>
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">Wie hei&szlig;t die Datei, die die News ausgibt (normalerweise <em>index.php</em>)?</td>
   <td width="50%">
	<input type="text" name="newsoutput" value="<?=$newsoutput?>">
</td>
 </tr>
 <tr class="tr2">
   <td width="50%">Zusätzliche Parameter, falls die News in eine Site-Engine eingebunden werden sollen (<em>z.B. &action=news</em> oder <em>&site=bla&target=paranews</em>)</td>
   <td width="50%">
	<input type="text" name="params" value="<?=$params?>">
</td>
 </tr>
 <tr class="tr1">
   <td width="50%">Seite, die nach dem Logout aufgerufen wird</td>
   <td width="50%">
	<select name="logoutjump1"><?php
	if($logoutjump == '') echo'<option value="0" selected>Standard</option>';
	else echo'<option value="0">Standard</option>';
	if($logoutjump != '') echo'<option value="1" selected>Andere -></option>';
	else echo'<option value="1">Andere -></option>';	
	?></select>	
	<input type="text" name="logoutjump" value="<?=$logoutjump?>">
</td>
 </tr>
 <tr class="tr2">
   <td colspan="2">
	<input type="submit" name="Abschicken" value="&Auml;nderungen speichern">
</td>
 </tr>
</table>
</form>
<?php
	echo'</td>
		  </tr>
		</table>';
drawfooter($version);
?>
