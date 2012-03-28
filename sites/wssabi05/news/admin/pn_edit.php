<?php
#########################################################
#                     ParaNews v3.3a                    #
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

#########################################
#           STANDARDAUSGABE             #
#########################################
drawheader('Edit News');


/* Ausgabe aller Newseinträge */
if (!$_GET['go']) {

	$zeile 	= file($datafile);
	$zeilen = sizeof($zeile);

	echo '<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
			<tr class="tr2">
				<td width="30"><b>Datum</b></td>
				<td><b>Titel</b></td>
				<td width="20"><b>Bearbeiten</b></td>
			    <td width="20"><b>L&ouml;schen</b></td>
			</tr>';

	$seiten = ceil($zeilen / $newsperpage);
	$zeile 	= array_reverse($zeile);

	if (!$_GET['page']) $_GET['page'] = 1; 
	$y = $_GET['page'] * $newsperpage; 
	$x = $y - $newsperpage;
	if ($y > $zeilen) $y = $zeilen;
	if ($zeilen > 0) {
		for ($i= $x; $i < $y ; $i++) {
			$eintrag= explode("§",$zeile[$i]);
			$datum	= formatdate($eintrag[6], $dateformat);

			echo'<tr class="tr1">
				<td width="20%"><b>'.$datum.'</b></td>
				<td width="60%">'.$eintrag[2].'</td>
				<td width="10%"><a href="'.$_SERVER['PHP_SELF'].'?go=edit&nr='.$eintrag[0].'">Bearbeiten</a></td>
		    	<td width="10%"><a href="'.$_SERVER['PHP_SELF'].'?go=delete&nr='.$eintrag[0].'">Löschen</a></td>
				</tr>';
	    }
	}
	/* -------------------------- */

	echo '</table>';

	/* Berechnung + Anzeige der Navigationlinks */  
	if ($zeilen > $newsperpage) {
		$nextid = $_GET['page'] - 1;  
		$lastid = $_GET['page'] + 1;

		if ($nextid != 0) {$last = "<a href=\"$PHP_SELF?page=$nextid\">$lasttext</a>";}
		else {$last = $lasttext;}

		$top = "<a href=#top>nach oben</a>";  

		if ($lastid <= $seiten) $next =  "<a href=\"$PHP_SELF?page=$lastid\">$nexttext</a>"; 
		else $next = $nexttext;
	}

	echo "<center>$last  $top  $next</center>";

}
#########################################


#########################################
#          Eintrag Editieren            #
#########################################
if ($_GET['go'] == 'edit') {

	$zeile 	= file($datafile);
	$zeilen = sizeof($zeile);

	for ($i=0; $i<$zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 
		if ($eintrag[0] == $_GET['nr']) { 
			$eintrag[3] = my_br2nl($eintrag[3]);
			echo'<form action="'.$_SERVER['PHP_SELF'].'?go=save" method="post">
					<input type="hidden" name="nr" value="'.$_GET['nr'].'">
  					<table width="90%" cellpadding="1" cellspacing="1" border="0" class="rahmen">
						<tr class="tr1"> 
							<td colspan="2"><b>Titel:</b><br /><input type="text" name="title" size="45" value="'.htmlspecialchars($eintrag[2]).'"><br /></td>
						</tr>
						<tr class="tr1"> 
							<td colspan="2"><b>Kategorie:</b><br />
								<select name="cat">';
								echo getselectedcat($eintrag[5],'../inc/pn_categories.dat');
							echo '</select><br />
							</td>
						</tr>						
						<tr class="tr1"> 
							<td colspan="2"><b>News-Beitrag (kurz):</b><br /><textarea name="news" cols="100" rows="4">'.htmlspecialchars($eintrag[3]).'</textarea><br /></td>
						</tr>
						<tr class="tr1"> 
							<td colspan="2"><b>Kompletter News-Beitrag:</b><br /><textarea name="newslang" cols="100" rows="8">'.htmlspecialchars($eintrag[4]).'</textarea><br /></td>
						</tr>						
						<tr class="tr1"> 
							<td width="50%"><input type="SUBMIT" value="Save"></td>
						    <td width="50%"><a href="'.$_SERVER['PHP_SELF'].'?go=edit&view=comments&nr='.$_GET['nr'].'">Kommentare anzeigen</a></td>
						</tr>
					</table>
				    <br>
				</form>';
		}
	}

	if ($_GET['view'] == 'comments') {

	echo '<form action="'.$_SERVER['PHP_SELF'].'?go=commentsave" method="post">
						<input type="hidden" name="nr" value="'.$_GET['nr'].'">
							<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
								<tr class="tr2">
									<td width="30"><b>Author</b></td>
									<td><b>Comment</b></td>
									<td width="20"><b>Bearbeiten</b></td>
								    <td width="20"><b>L&ouml;schen</b></td>
								</tr>';

	$zeile 	= file($cf);
	$zeilen = sizeof($zeile);

		for ($i=0; $i<$zeilen; $i++) { 
			$eintrag = explode ('§', $zeile[$i]); 
			
			if ($eintrag[1] == $_GET['nr']) { 
				echo'<tr class="tr1">
						<td width="20%"><b>'.$eintrag[3].'</b></td>
						<td width="60%">'.$eintrag[2].'</td>
						<td width="10%"><a href="'.$_SERVER['PHP_SELF'].'?go=editcomment&nr='.$eintrag[0].'">Bearbeiten</a></td>
						<td width="10%"><a href="'.$_SERVER['PHP_SELF'].'?go=deletecomment&nr='.$eintrag[0].'">Löschen</a></td>
					</tr>';
			}
		}
	
	echo '</table></form>';
	
	}

}
#########################################


#########################################
#          Comment Editieren            #
#########################################
if ($_GET['go'] == 'editcomment') {

	$zeile 	= file($cf);
	$zeilen = sizeof($zeile);
	
	for ($i=0; $i<$zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 
		if ($eintrag[0] == $_GET['nr']) {
				$eintrag[2] = my_br2nl($eintrag[2]); 
				echo'<form action="'.$_SERVER['PHP_SELF'].'?go=savecomment" method="post">
						<input type="hidden" name="nr" value="'.$_GET['nr'].'">
	  					<table cellpadding="1" cellspacing="1" border="0" class="rahmen">
							<tr class="tr1"> 
								<td><b>Author:</b><br /><input type="text" name="author" size="45" value="'.htmlspecialchars($eintrag[3]).'"><br /></td>
							    <td><b>eMail:</b><br /><input type="text" name="email" size="45" value="'.htmlspecialchars($eintrag[4]).'"><br /></td>
							</tr>
							<tr class="tr1"> 
								<td colspan="2"><b>Comment:</b><br /><textarea name="comment" cols="100" rows="10">'.htmlspecialchars($eintrag[2]).'</textarea><br /></td>
							</tr>
							<tr class="tr1"> 
								<td colspan="2"><input type="SUBMIT" value="Save"></td>
							</tr>
						</table>
					    <br>
						</form>';
		}
	}
}
#########################################


#########################################
#     Editierten Eintrag speichern      #
#########################################
if ($_GET['go'] == 'save') {

	$zeile 	= file($datafile);
	$zeilen = sizeof($zeile);

	for ($i=0; $i<$zeilen; $i++) {
		$eintrag = explode('§', $zeile[$i]);

		if ($eintrag[0] == $_POST['nr']) {
				$eintrag[2] = unspecialchars($_POST['title']);
				$eintrag[2] = cleantext($_POST['title']);
				$eintrag[3] = unspecialchars($_POST['news']);
				$eintrag[3] = cleantext($_POST['news']);
				$eintrag[4] = unspecialchars($_POST['newslang']);
				$eintrag[4] = cleantext($_POST['newslang']);
				$eintrag[5] = $_POST['cat'];
        }
		$zeile[$i] = implode($eintrag,"§");
	}

	$fp = fopen($datafile,"w+");
	flock($fp,2);
	
	for ($i=0; $i<$zeilen; $i++) {
		fwrite($fp, $zeile[$i]);
	}
	
	flock($fp,3);
	fclose($fp);
	
	echo 'Eintrag gespeichert!';
	

	
	
}
#########################################


#########################################
#     Editierten Comment speichern      #
#########################################
if ($_GET['go'] == 'savecomment') {

	$zeile 	= file($cf);
	$zeilen = sizeof($zeile);

	for ($i=0; $i<$zeilen; $i++) {
		$eintrag = explode('§', $zeile[$i]);

		if ($eintrag[0] == $_POST['nr']) {
			$eintrag[2] = unspecialchars($_POST['comment']);
			$eintrag[2] = cleantext($_POST['comment']);
			$eintrag[3] = unspecialchars($_POST['author']);
			$eintrag[3] = cleantext($_POST['author']);
			$eintrag[4] = unspecialchars($_POST['email']);
			$eintrag[4] = cleantext($_POST['email']);
        }
		$zeile[$i] = implode($eintrag,"§");
	}
	
	$fp = fopen($cf,"w+");
	flock($fp,2);
	for ($i=0; $i<$zeilen; $i++) {
		fwrite($fp, $zeile[$i]);
	}
	flock($fp,3);
	fclose($fp);
	
	echo 'Comment gespeichert!';
}
#########################################


#########################################
#           Eintrag löschen             #
#########################################
if ($_GET['go'] == 'delete') { 

	$zeile 	= file($datafile);
	$zeilen = sizeof($zeile);
	

	for ($i=0; $i < $zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 

		if ($eintrag[0] == $_GET['nr']) { 
			delcomment($eintrag[0], '../inc/pn_comments.dat');
			$zeilen--; 

			for ($j=$i; $j<$zeilen; $j++) {
				$zeile[$j]=$zeile[$j+1];
			}

		}
	}
	
	$fp = fopen($datafile,"w+");
	flock($fp,2);
	for ($i=0; $i < $zeilen; $i++) {
		fwrite($fp, $zeile[$i]);
	}
	flock($fp,3);
	fclose($fp);
	
	echo 'Eintrag gel&ouml;scht!';  
}
#########################################


#########################################
#           Comment löschen             #
#########################################
if ($_GET['go'] == 'deletecomment') { 

	$zeile 	= file($cf);
	$zeilen = sizeof($zeile);
		
	for ($i=0; $i < $zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 

		if ($eintrag[0] == $_GET['nr']) { 
			$zeilen--; 

			for ($j=$i; $j<$zeilen; $j++) {
				$zeile[$j]=$zeile[$j+1];
			}

		}
	}

	$fp = fopen($cf,"w+");
	flock($fp,2);
	for ($i=0; $i < $zeilen; $i++) {
		fwrite($fp, $zeile[$i]);
	}
	flock($fp,3);
	fclose($fp);
	
	echo 'Comment gel&ouml;scht!';  
}
#########################################

/* Seitenende */
echo '<br /><br />';
drawfooter($version);
?>
