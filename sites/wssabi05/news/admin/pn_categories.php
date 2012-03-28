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
include '../inc/config.inc.php';
checklogin();
adminonlyaccess($_SESSION['loginlevel']);

$dir = "../catpics/"; // chmod 777!

#########################################
#           STANDARDAUSGABE             #
#########################################
drawheader('Edit Categories');


/* Ausgabe aller Kategorien */
if (!$_GET['go']) {

	$zeile 	= file($catfile);
	$zeilen = sizeof($zeile);
	

	echo '<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
			<tr class="tr2">
				<td width="30"><b>Kategorie</b></td>
				<td><b>Bild</b></td>
				<td width="20"><b>Bearbeiten</b></td>
			    <td width="20"><b>L&ouml;schen</b></td>
			</tr>';
	
	for ($i=0; $i<$zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]);
		$eintrag[2] = getcat($eintrag[0],'../inc/pn_categories.dat','../catpics',$catpics); 
			echo'<tr class="tr1">
				<td width="20%"><b>'.$eintrag[1].'</b></td>
				<td width="60%">'.$eintrag[2].'</td>
				<td width="10%"><a href="'.$_SERVER['PHP_SELF'].'?go=edit&catid='.$eintrag[0].'">Bearbeiten</a></td>
		    	<td width="10%"><a href="'.$_SERVER['PHP_SELF'].'?go=delete&catid='.$eintrag[0].'">Löschen</a></td>
				</tr>';
	}			

	/* -------------------------- */

	echo '</table><br /><br /><a href="'.$_SERVER['PHP_SELF'].'?go=addcat">Kategorie hinzuf&uuml;gen</a>';

}
#########################################


#########################################
#         Kategorie Editieren           #
#########################################
if ($_GET['go'] == 'edit') {

	$zeile 	= file($catfile);
	$zeilen = sizeof($zeile);
	
	for ($i=0; $i<$zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 
		if ($eintrag[0] == $_GET['catid']) {
			$eintrag[2] = my_br2nl($eintrag[2]);
			$eintrag[2] = getcat($eintrag[0],'../inc/pn_categories.dat','../catpics', $catpics);
			 
			echo'<form action="'.$_SERVER['PHP_SELF'].'?go=save" method="post" enctype="multipart/form-data">
					<input type="hidden" name="catid" value="'.$_GET['catid'].'">
  					<table cellpadding="1" cellspacing="1" border="0" class="rahmen">
						<tr class="tr1"> 
							<td colspan="2"><b>Name:</b><br />
								<input type="text" name="name" size=25" value="'.$eintrag[1].'"><br />
							</td>
				        </tr>
						<tr class="tr1" valign="top">'; 
							
				if($catpics=='no')
				{
					echo'<td>
							<b>Aktuelles Bild:</b><br /><br />						    	
							<small>Die Bildanzeige f&uuml;r Kategorien ist deaktiviert.</small>
						</td>';
				
				}
				else
				{
					echo'<td width="50%">
								<b>Aktuelles Bild:</b><br /><br />
						    	'.$eintrag[2].'
								<br />
							</td>
						    <td width="50%">
								<b>Neues Bild hochladen:</b><br /><br />
					        	<input name="file" type="file" size="20">
							</td>';
				}
							
							
						
						
						
						echo'</tr>
						<tr class="tr1"> 
							<td colspan="2"><input type="SUBMIT" value="Save"></td>
						</tr>
					</table>
				</form>';
		}
	}

}
#########################################

#########################################
#     Editierte Kategorie speichern     #
#########################################
if ($_GET['go'] == 'save') {

	if ($_POST['name'] == '') {
	    echo 'Der Kategorie-Name fehlt!<br /><br />';
		drawfooter($version);
		exit();
	}
	
	if(!$_FILES['file']['name'] == '') {
		/* Datei-Upload */
	
		if($_FILES['file']['size'] > $maxsize) {
			echo 'Die Datei '.$_FILES['file']['name'].' ist zu gross! <br />';
			exit();
		}
		  
		if (move_uploaded_file($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name'])) {
			echo $_FILES['file']['name'].' wurde hochgeladen!<br />';
			$uploaded = 1;
			$upflname = $_FILES['file']['name'];
		} else {
			echo 'Fehler! Die Datei konnte nicht hochgeladen werden!<br />';
		}	
		/* ------------ */
	}
	else
	{
		$upflname = '';
	}
	
	$zeile 	= file($catfile);
	$zeilen = sizeof($zeile);
	
	for ($i=0; $i<$zeilen; $i++) {
		$eintrag = explode('§', $zeile[$i]);
	
		if ($eintrag[0] == $_POST['catid']) {
			$eintrag[1] = cleantext($_POST['name']);
			
			if($uploaded == 1) {
				// Alte Datei löschen
				$file = $dir.$eintrag[2];
				if(delfile($file) == 0) echo 'Alte Datei konnte nicht gelöscht werden!';
				// Neuen Dateinamen in DB eintragen
				if($upflname != '') $eintrag[2] = $upflname;
			}
		}
		$zeile[$i] = implode($eintrag,"§");
	}
	
	$fp = fopen($catfile,"r+");
	flock($fp,2);
	for ($i=0; $i<$zeilen; $i++) {
		fwrite($fp, $zeile[$i]);
	}
	flock($fp,3);
	fclose($fp);
	
	echo 'Kategorie erfolgreich editiert!';

}
#########################################

#########################################
#          Kategorie löschen            #
#########################################
if ($_GET['go'] == 'delete') { 
	
	$zeile 	= file($catfile);
	$zeilen = sizeof($zeile);
	
	for ($i=0; $i < $zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 

		if ($eintrag[0] == $_GET['catid']) { 
				
			if($eintrag[2] != '')
			{
				// Alte Datei löschen
				$file = $dir.$eintrag[2];
				if(delfile($file) == 0) echo 'Alte Datei konnte nicht gelöscht werden!';			
			}

			$zeilen--; 

			for ($j=$i; $j<$zeilen; $j++) {
				$zeile[$j]=$zeile[$j+1];
			}

		}
	}

	$fp = fopen($catfile,"w+");
	flock($fp,2);
	for ($i=0; $i < $zeilen; $i++) {
		fwrite($fp, $zeile[$i]);
	}
	flock($fp,3);
	fclose($fp);

	/* News der gelöschten Kategorie löschen */

	$zeile 	= file($datafile);
	$zeilen = sizeof($zeile);

	for ($i=0,$z=0; $i < $zeilen; $i++) { 
		$entry = explode ('§', $zeile[$i]); 

		if ($entry[5] != $_GET['catid']) {
			$neuzeile[$z] = $zeile[$i];
			$z++;
		} else delcomment($entry[0], '../inc/pn_comments.dat');
	}

	$fp = fopen($datafile,"w+");
	flock($fp,2);
	for ($i=0; $i < $zeilen; $i++) {
		fwrite($fp, $neuzeile[$i]);
	}
	flock($fp,3);
	fclose($fp);

	echo 'Kategorie gel&ouml;scht!';
}
#########################################

#########################################
#        Kategorie hinzufügen           #
#########################################
if ($_GET['go'] == 'addcat') { 
	
	echo'<form method="POST" action="'.$_SERVER['PHP_SELF'].'?go=addcat&action=save"  enctype="multipart/form-data">
			<table cellpadding="1" cellspacing="1" border="0" class="rahmen">
				<tr class="tr1"> 
					<td><b>Name:</b><br />
						<input type="text" name="name" size=25" value="'.$eintrag[1].'"><br />
					</td>
		        </tr>
				<tr class="tr1" valign="top"> 
					<td>
						<br />
						<b>Kategorie-Bild hochladen:</b><br /><br />';
	
		if($catpics == 'no')
		{
			echo'<small>Die Bildanzeige f&uuml;r Kategorien ist deaktiviert.</small>';
		}
		else
		{
			echo'<input name="file" type="file" size="20">';
		}
						
						
				  echo'</td>
			    </tr>
				<tr class="tr1"> 
					<td><input type="SUBMIT" value="Save"></td>
				</tr>
			</table>
		</form>';
	
	if ($_GET['action'] == 'save') {

		if ($_POST['name'] == '') {
		    echo 'Der Kategorie-Name fehlt!<br /><br />';
			drawfooter($version);
			exit();
		}
		
		if($_FILES['file']['name']=='' && $catpics=='yes') {
		    echo 'Fehler: Kein Kategorie-Bild angegeben!<br /><br />';
			drawfooter($version);
			exit();
		}
	
		$zeile 	= file($catfile);
		$zeilen = sizeof($zeile);		
		
		$eintrag = explode("§",$zeile[$zeilen-1]);
		$id = $eintrag[0]+1;
	
		if ($zeilen) {
			if(strlen($id)==1) $id = '00'.$id; 
			if(strlen($id)==2) $id = '0'.$id;
		} else $id = 1;
	
	   	$_POST['name']	= cleantext($_POST['name']);

		if($_FILES['file']['name']!='')
		{
			/* Datei-Upload */
			$dir = "../catpics/"; // chmod 777!
			
			if($_FILES['file']['size'] > $maxsize) {
				echo 'Die Datei '.$_FILES['file']['name'].' ist zu gross! <br /><br />';
				drawfooter($version);
				exit();
			}
	 
			if (move_uploaded_file($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name'])) {
				echo $_FILES['file']['name'].' wurde hochgeladen!<br />';
				$upflname = $_FILES['file']['name'];
			} else {
				echo 'Fehler! Die Datei konnte nicht hochgeladen werden!<br /><br />';
				drawfooter($version);
				exit();
			}	
			/* ------------ */
		}
		else
		{
			$upflname = '';
		}

	   	$nl = chr(13).chr(10);

		$fp = fopen($catfile,"a");
		flock($fp,2);
	   	fwrite($fp, my_nl2br(implode(array ($id, $_POST['name'], $upflname, '', '') ,'§')) . $nl);
	 	flock($fp,3);
		fclose($fp);		

		echo 'Kategorie erfolgreich hinzugef&uuml;gt!<br /><br />';	
    
	}
  
}
#########################################

/* Seitenende */
echo '<br /><br />';
drawfooter($version);
?>
