<?php
#########################################################
#                     ParaNews v3.3a                     #
#             Copyright (c) by Chris Rolle              #
#     [ chris AT monxoom DOT de | www.monxoom.de ]      #
#########################################################
#    This script can be used freely as long as this     #
#     copyright-notice remains here. Furthermore a      #
#   copyright-notice must be displayed on the website   #
#              where this script is used.               #
#                                                       #
#    See readme.htm for further copyright information   #
#     IF YOU USE THIS SCRIPT, YOU ACCEPT THESE TERMS    #
#########################################################


#########################################
#               DETAILS                 #
#########################################
if($_GET['pn_go'] == 'details'){
/* Ausgabe des betreffenden Newseintrags */
	for ($i=0; $i < $zeilen; $i++) {
		$eintrag = explode('§',$zeile[$i]);
		
		if ($eintrag[0] == $_GET['id']) {
			$datum = formatdate($eintrag[6], $dateformat);
			$eintrag[1] = getname($eintrag[1],'news/inc/pn_userdata.php');
			$eintrag[2]	= formattext($eintrag[2], $smilies, $smiliespath, $myBoardCodeTags, $texthtml);
			$eintrag[3]	= formattext($eintrag[3], $smilies, $smiliespath, $myBoardCodeTags, $texthtml);
			
			if($eintrag[4] != '') {
				$eintrag[4]	= formattext($eintrag[4], $smilies, $smiliespath, $myBoardCodeTags, $texthtml);
				$eintrag[3] = $eintrag[3].'<br /><br /><b>More:</b><br />'.$eintrag[4];
			}
			
			/* Kategorie-System */
			if($showcat=='yes') $eintrag[5] = getcat($eintrag[5],'news/inc/pn_categories.dat','catpics', $catpics);
			else $eintrag[5] = '';
			/* ---------------- */
			
			$commentscount = commentscount($eintrag[0]);
			$comments = '<a href="'.$_SERVER['PHP_SELF'].'?pn_go=details&id='.$eintrag[0].$params.'">Comments ('.$commentscount.')</a>';

			$tpl->set_var(array(
				'cat'    	=> $eintrag[5],
				'newsnr'	=> $newsnr,
				'autor'     => $eintrag[1],
				'title'     => $eintrag[2],
				'news'      => $eintrag[3],
				'datum'     => $datum,
				'readmore'  => $readmore,				
				'comments'  => $comments
			));
			
			$tpl->parse("LOOPSECTION", "LOOP", true);
		}
	}
	/* ------------------------------------- */
	
	/* Kommentarübersicht anzeigen */

		$tpl->parse("HEADER", "COMMENTSHEADER", true);
		$tpl->set_var(array("commentscount" => $commentscount));
	
	/* --------------------------- */

	/* Kommentare anzeigen */
	$cf = 'news/inc/pn_comments.dat';
	$zeile 	= file($cf);
	$zeilen = sizeof($zeile);
	$commentnr=0;
	
	for ($i=0; $i < $zeilen; $i++) { 
	    
		$eintrag = explode("§",$zeile[$i]);
		
		if ($eintrag[1] == $_GET['id']) {
			$datum = formatdate($eintrag[5], $dateformat);
			$eintrag[2]	= formattext($eintrag[2], $smilies, $smiliespath, $myBoardCodeTags, $commenthtml);
			$author = '<a href="mailto:'.$eintrag[4].'">'.$eintrag[3].'</a>';
			
			$commentnr++;
			$tpl->set_var(array(
				"datum"		=> $datum,
				"comment"	=> $eintrag[2],
				"autor"		=> $author,
				"commentnr"	=> '#'.$commentnr));
				$tpl->parse("COMMENTSECTION", "COMMENTS", true);
		}
	}
	/* ------------------- */

	/* Kommentarform anzeigen */
	$saveurl = $newsoutput.'?pn_go=savecomment'.$params;
	
	$tpl->parse("FORM", "COMMENTFORM", true);
	$tpl->set_var(array(
		'saveurl' => $saveurl,
		'commentid' => $_GET['id'],
		'backurl' => $_SERVER['HTTP_REFERER']));	
}
#########################################



#########################################
#             SAVECOMMENT               #
#########################################
if ($_GET['pn_go'] == 'savecomment') {

	if (($_POST['name']=='') OR ($_POST['comment']=='')) {
		echo '<br /><br /><br /><div align="center">Bitte fülle alle Felder aus! Du wirst in 3 Sekunden weitergeleitet.<br /><a href="'.$_SERVER['HTTP_REFERER'].'">Wenn Du nicht länger warten willst, klicke hier</a>.</div>';
		echo '<meta http-equiv="refresh" content="3; URL='.$_SERVER['HTTP_REFERER'].'">';		
	} else {
		
		$cf = 'news/inc/pn_comments.dat';
		$zeile = file($cf);
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

		$_POST['name']		= cleantext($_POST['name'], 1);
		$_POST['email']		= cleantext($_POST['email'], 1);
		$_POST['comment']	= cleantext($_POST['comment']);
		$datum = time();
		$nl = chr(13).chr(10);
		
		$fp = fopen($cf,"a");
		flock($fp,2);
		fwrite($fp, my_nl2br(implode(array ($id, $_POST['commentid'], $_POST['comment'], $_POST['name'], $_POST['email'], $datum) ,"§")) . $nl);
		flock($fp,3);
		fclose($fp);

		echo '<br /><br /><br /><div align="center">Dein Kommentar wurde erfolgreich eingetragen. Du wirst in 3 Sekunden weitergeleitet.<br /><a href="'.$_POST['backurl'].'">Wenn Du nicht länger warten willst, klicke hier</a>.</div>';
		echo '<meta http-equiv="refresh" content="3; URL='.$_POST['backurl'].'">';
	}
}
#########################################

?>
