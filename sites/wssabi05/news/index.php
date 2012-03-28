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
#     IF YOU USE THIS SCRIPT, YOU ACCEPT THESE TERMS    #
#########################################################
error_reporting(0);

if (file_exists('patch.php')) exit('<body bgcolor="#EFEFEF"><br><br><center><b style="Font-Size : 12px; Font-Family: Verdana;">Bitte lösche zuerst die patch.php!</b></center>');

include 'inc/config.inc.php';
include 'inc/template.inc.php';
include 'inc/functions.inc.php';

/* Ein paar Template-Anweisungen */
$tpl = new Template();
$tpl->set_file('seite', 'news/template.htm');
$tpl->set_block('seite', 'LOOP', 'LOOPSECTION');
$tpl->set_block('seite', 'COMMENTS', 'COMMENTSECTION'); 
$tpl->set_block('seite', 'COMMENTSHEADER', 'HEADER');  
$tpl->set_block('seite', 'COMMENTFORM', 'FORM');
/* ----------------------------- */

$datafile = 'news/inc/pn_data.dat';
$zeile 	= file($datafile);
$zeilen = sizeof($zeile);
$seiten = ceil($zeilen / $newsperpage);
$zeile 	= array_reverse($zeile);

#########################################
#           STANDARDAUSGABE             #
#########################################
if(!$_GET['pn_go'] OR $_GET['pn_go']==''){
	
	/* Vorbereitende Berechnungen zu den Navigationslinks */
	if (!$_GET['page']) $_GET['page'] = 1; 
	$y = $_GET['page'] * $newsperpage; 
	$x = $y - $newsperpage;
	if ($y > $zeilen) $y = $zeilen;
	/* -------------------------------------------------- */
	
	/* Ausgabe aller Newseinträge */
	for ($i=$x; $i<$y ; $i++) {
		$eintrag = explode('§',$zeile[$i]);
		$datum 		= formatdate($eintrag[6], $dateformat);
		$eintrag[1] = getname($eintrag[1],'news/inc/pn_userdata.php');
		$eintrag[2]	= formattext($eintrag[2], $smilies, $smiliespath, $myBoardCodeTags, $texthtml);
		$eintrag[3]	= formattext($eintrag[3], $smilies, $smiliespath, $myBoardCodeTags, $texthtml);
		
		/* Kategorie-System */
		if($showcat=='yes') $eintrag[5] = getcat($eintrag[5],'news/inc/pn_categories.dat','catpics', $catpics);
		else $eintrag[5] = '';
		/* ---------------- */

		if($eintrag[4] != '') $readmore = '<a href="'.$_SERVER['PHP_SELF'].'?pn_go=details&id='.$eintrag[0].$params.'">'.$more.'</a>';
		else $readmore = '';

		$newsnr = $zeilen - $i.'.&nbsp;';
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
			'comments'  => $comments));

		$tpl->parse("LOOPSECTION", "LOOP", true);
	}
	/* -------------------------- */
}
#########################################

#########################################
#               DETAILS                 #
#########################################
if($_GET['pn_go'] == 'details' OR $_GET['pn_go'] == 'savecomment'){
	include 'news/comments.php';
}
#########################################

  
if(!$_GET['pn_go'] OR $_GET['pn_go']==''){
	/* Berechnung + Anzeige der Navigationlinks */
	$nxt = '<br />'.a();
	if ($zeilen > $newsperpage) {
		$nextid = $_GET['page'] - 1;  
		$lastid = $_GET['page'] + 1;
	  
		if ($nextid != 0) {
			$last = '<a href="'.$_SERVER['PHP_SELF'].'?page='.$nextid.'">'.$lasttext.'</a>';
		}else {
			$last = $lasttext;
		}
	
		$top = '<a href=#top>nach oben</a>';
	
		if ($lastid <= $seiten) {
			$next =  '<a href="'.$_SERVER['PHP_SELF'].'?page='.$lastid.'">'.$nexttext.'</a>';
		}else {
			$next = $nexttext;
		}

		$next = $next.$nxt;
	} else $next = $nxt;
	
	$tpl->set_var(array('last' 	=> $last,
						'top' 	=> $top,
						'next' 	=> $next));
	/* ---------------------------------------- */
} else {
	$next = '<br />'.a();
	if($_GET['pn_go'] != 'savecomment') $backlink = '<a href="'.$_SERVER['HTTP_REFERER'].'">Zur&uuml;ck</a>';
	$tpl->set_var(array('last' 	=> $last,
						'top' 	=> $top,
						'backlink'=> $backlink,
						'next' 	=> $next));
}

/* Seite Parsen und ausgeben */
$tpl->parse("out", "seite");
$tpl->p("out");
/* ------------------------- */
?>
