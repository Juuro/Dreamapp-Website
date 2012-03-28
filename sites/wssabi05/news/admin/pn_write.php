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

include "../inc/config.inc.php";
include "../inc/functions.inc.php";
checklogin();

?>
<html>
<head>
<title>.:ParaNews <?=$version?>:.</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<script language="JavaScript"> 
<!--
function smilies(Zeichen) { 
  document.posting.newslang.value = 
  document.posting.newslang.value + Zeichen; 
} 

 
function setcode(code,prompttext) {
		inserttext = prompt("Zu formatierenden Text eingeben:"+"\n",prompttext);
		if ((inserttext != null) && (inserttext != ""))
		document.posting.newslang.value += "["+code+"]"+inserttext+"[/"+code+"] ";
	document.posting.newslang.focus();
}


function seturl(type) {
	description = prompt("Beschreibungstext eingeben (optional)","");
	if (type == "URL") {
		text = "Link eingeben";
		content = "http://";
		}
	else {
		text = "eMail-Adresse eingeben";
		content = "";
		}
	url = prompt(text,content);
	if ((url != null) && (url != "")) {
		if ((description != null) && (description != ""))
			document.posting.newslang.value += "["+type+"="+url+"]" +description+  "[/"+type+"] ";
		else
			document.posting.newslang.value += "["+type+"]"+url+"[/"+type+"] ";
		}	
	document.posting.newslang.focus();
}


function setimgurl(type1,type2) {	
	pic_text = "URL des Bildes angeben";
	pic_content = "http://";
	picurl = prompt(pic_text,pic_content);
	link_text = "Seite, die nach Klick auf das Bild aufgerufen werden soll (optional)";
	link_content = "http://";
	url = prompt(link_text,link_content);
	if ((picurl != null) && (picurl != "")) {
		if ((url != null) && (url != "http://") && (url != ""))
			document.posting.newslang.value += "["+type2+"="+url+"]"+"["+type1+"="+picurl+"]"+"[/"+type2+"] ";
		else
			document.posting.newslang.value += "["+type1+"="+picurl+"] ";
		}	
	document.posting.newslang.focus();
}
//-->
</script>
<link rel="stylesheet" href="pn_styles.css" type="text/css">
</head>
<body>
<br /><br />
<div align="center">
<font face="Verdana, Arial, Helvetica, sans-serif" size="4"><b>.:Neue Nachricht:.</b></font>
<br /><br />
  <form name="posting"  method="POST" action="<?PHP echo $_SERVER['PHP_SELF'].'?go=save'; ?>">
    
  <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
    <tr class="tr2"> 
        
      <td colspan="2"><b>&raquo; News-Einstellungen</b></td>
      </tr>
      <tr class="tr1">
        <td width="100">&Uuml;berschrift</td>
        <td><input type="text" name="title" size="60" maxlength="150"></td>
      </tr>
      <tr class="tr1"> 
        
      <td width="100">Kategorie</td>
        
      <td> 
		<select name="cat">
			<?php readcatselect('../inc/pn_categories.dat'); ?>
		</select>
        </td>
      </tr>
      <tr class="tr2">
        <td colspan="2"><b>&raquo; News schreiben</b></td>
      </tr>
      <tr class="tr1">
        <td width="100">Code <small>[<a href="pn_help.php" target="_blank">Hilfe</a>]</small> </td>
        <td><input type="button" name="[b]" title="Fett" value=" B " onClick="javascript:setcode('B','')">
          <input type="button" name="[i]" title="Kursiv" value=" I " onClick="javascript:setcode('I','')">
          <input type="button" name="[u]" title="Unterstrichen" value=" U " onClick="javascript:setcode('U','')">
          <input type="button" name="[url]" title="Link einf&uuml;gen" value="http" onClick="javascript:seturl('URL')">
          <input type="button" name="[email]" title="Email-Link einf&uuml;gen" value="@" onClick="javascript:seturl('EMAIL')">
          <input type="button" name="[img]" title="Bild einf&uuml;gen" value="IMG" onClick="javascript:setimgurl('IMG','URL')">
          <input type="button" name="[#]" title="Code-Text einf&uuml;gen" value="CODE" onClick="javascript:setcode('CODE','')">
          <input type="button" name="[quote]" title="Zitat einf&uuml;gen" value="Quote" onClick="javascript:setcode('QUOTE','')")></td>
      </tr>
      <tr class="tr1">
		<td width="100" rowspan="3" align="center" valign="top"><br>
			<table border="0" cellspacing="1" cellpadding="1" align="center" width="60">
				<tr class="tr2">
					<td align="center">Smilies:</td>
				</tr>
				<tr class="tr1">
					<td align="center"> <img src="../<?=$smiliespath;?>/biggrin.gif" alt="biggrin.gif" width="15" height="15" onClick=javascript:smilies(':D')> <img src="../<?=$smiliespath;?>/confused.gif" alt="confused.gif" width="15" height="22" onClick=javascript:smilies('???')> <img src="../<?=$smiliespath;?>/cool.gif" alt="cool.gif" width="15" height="15" onClick=javascript:smilies(':cool:')><br />
						<img src="../<?=$smiliespath;?>/eek.gif" alt="eek.gif" width="15" height="15" onClick=javascript:smilies(':eek:')> <img src="../<?=$smiliespath;?>/frown.gif" alt="frown.gif" width="15" height="15" onClick=javascript:smilies(':(')> <img src="../<?=$smiliespath;?>/mad.gif" alt="mad.gif" width="15" height="15" onClick=javascript:smilies(':grrr:')><br />
						<img src="../<?=$smiliespath;?>/redface.gif" alt="redface.gif" width="15" height="15" onClick=javascript:smilies(':o')> <img src="../<?=$smiliespath;?>/rolleyes.gif" alt="rolleyes.gif" width="15" height="15" onClick=javascript:smilies(':eyes:')> <img src="../<?=$smiliespath;?>/smile.gif" alt="smile.gif" width="15" height="15" onClick=javascript:smilies(':)')><br />
						<img src="../<?=$smiliespath;?>/zwink.gif" alt="zwink.gif" width="15" height="15" onClick=javascript:smilies(';)')> <img src="../<?=$smiliespath;?>/tongue.gif" alt="tongue.gif" width="15" height="15" onClick=javascript:smilies(':tongue:')> </td>
				</tr>
			</table>
		</td> 
        
      <td>News-Beitrag (kurz)<br>
        <textarea name="news" rows="4" cols="60"></textarea></td>
      </tr>
      <tr class="tr1">
        <td>Kompletter News-Beitrag<br>
        <textarea name="newslang" rows="8" cols="60" id="newslang"></textarea></td>
      </tr>
      <tr class="tr1">
        <td width="90%"> 
        <input type=submit value="Send" name="submit">
        </td>
      </tr>
    </table>
  </form>
<?
if($_GET['go'] == 'save') {
	
  if (($_POST['title']=='') OR ($_POST['news']=='')) {
  	echo message('error', 'Bitte fülle alle Felder aus!',$_SERVER['HTTP_REFERER']);
    drawfooter($version);
	exit ();
  }
  
  include '../inc/config.inc.php';
  $datafile = '../inc/pn_data.dat';

  if ($_POST['news']) {
    $zeile = file($datafile);
    $zeilen = sizeof($zeile);

	if ($zeilen) {
		$eintrag = explode("§",$zeile[$zeilen-1]);
		$id = $eintrag[0]+1;

		if(strlen($id)==1) $id = "000000".$id; 
    	if(strlen($id)==2) $id = "00000".$id; 
    	if(strlen($id)==3) $id = "0000".$id; 
    	if(strlen($id)==4) $id = "000".$id; 
		if(strlen($id)==5) $id = "00".$id; 
		if(strlen($id)==6) $id = "0".$id; 
	} else $id = 1;
	 
	$author = $_SESSION['loginid'];
	$_POST['title'] 	= cleantext($_POST['title']);
	$_POST['news'] 		= cleantext($_POST['news']);
	$_POST['newslang'] 	= cleantext($_POST['newslang']);
		
	$datum = time();
	$nl = chr(13) . chr(10);
	
	$fp = fopen($datafile,"a");
	fwrite($fp, my_nl2br(implode(array ($id, $author, $_POST['title'], $_POST['news'], $_POST['newslang'], $_POST['cat'], $datum) ,"§")) . $nl);
	fclose($fp);
  }  
	echo message('msg', 'Erfolgreich gespeichert!','../'.$newsoutput.'');
}

drawfooter($version);
?>
