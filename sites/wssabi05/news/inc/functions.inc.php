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
#    WITH USE OF THIS SCRIPT, YOU ACCEPT THESE TERMS    #
#########################################################
$sessname = session_name();
$sessid   = session_id();
$session = $sessname.'='.$sessid;

$userfile   = 'news/inc/pn_userdata.php';
$datafile 	= 'news/inc/pn_data.dat';
$cf 		= 'news/inc/pn_comments.dat';
$catfile 	= 'news/inc/pn_categories.dat';
$version	= '3.3a';
$smiliespath = 'news/smilies';
$nxt = '';


if($nxt=='') $nxt = '<br />'.a();
$goback = '<br><a href="javascript:history.back()">Zurück</a>';

function message($type, $text, $url){

	if($url==1) $url = 'javascript:history.back()';

	if($type == 'error') {
		$msg = '<br /><br /><div align="center"><b>'.$text.' </b><br /><br /><a href="'.$url.'">Zur&uuml;ck</a></div><br />';
		return $msg;
	}
	
	elseif($type == 'msg') {
		$msg  = '<br /><br /><div align="center">';
		$msg .= $text; 
		$msg .= 'Du wirst in 3 Sekunden weitergeleitet.<br /><a href="';
		$msg .= $url;
		$msg .= '">Wenn Du nicht länger warten willst, klicke hier</a>.</div><meta http-equiv="refresh" content="3; URL=';
		$msg .= $url;
		$msg .= '"><br /><br />';
		return $msg;
	}
}

function drawheader($header) {
echo'
<html>
<head>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<title>ParaNews</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="pn_styles.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
<br><br>
<font face="Verdana, Arial, Helvetica, sans-serif" size="4"><b>.:'.$header.':.</b></font>
<br><br>';
}

function drawfooter($version) {
echo '<small><!-- Do not remove this copyright notice -->
Powered by <a href="http://www.monxoom.de" target="_blank">ParaNews</a> '.$version.'
</small>
</div>
</body>
</html>';
}

// Checkt am Anfang jeder Seite, ob der Zugriff authorisiert ist
function checklogin() {
	session_start();
	if (!$_SESSION['loginuser']) {
// Deaktiviert
//		$path = __FILE__; 
//	  $redirect = basename($path);
	  header("Location: pn_login.php");  
	  exit();
  }
}

// Checkt, ob der User Admin-Rechte hat  
function adminonlyaccess($loginlevel) {
	if ($loginlevel != 'admin')	{
		exit('Hierfür musst du Admin sein! Du bist '.$loginlevel.'...');
		}
  }

// Macht aus Zeilenumbrüchen HTML-Breaks (<BR>)  
function my_nl2br ($text)	{ 
	$retvalue = ''; 
	for ($ii = 0; $ii < strlen($text); $ii++)	{ 
		if ($text[$ii]!= chr(13)) 
		$text[$ii] == "\n" ? $retvalue .= '<br />' : $retvalue .= $text[$ii]; 
	} 
	return $retvalue; 
}

function my_br2nl ($text) {
    return preg_replace('=<br(>|([\s/][^>]*)>)\r?\n?=i', "\n", $text);
}

// Ermöglicht UBB-Code, (c) by Karl Förster (k.foerster@kallectronic.de)
class myBoardCodeTag {
  var $str_search;
  var $str_replace;
	var $casesensitiv;

  function myBoardCodeTag ($search, $replace, $casesensitiv = false) {
    $this->str_search     = $search;
    $this->str_replace    = $replace;
	$this->casesensitiv   = $casesensitiv;
  }
}
  $bold              = new myBoardCodeTag('(\[b\])(.*)(\[/b\])', '<b>\\2</b>');
  $italic            = new myBoardCodeTag('(\[i\])(.*)(\[/i\])', '<i>\\2</i>');
  $underline         = new myBoardCodeTag('(\[u\])(.*)(\[/u\])', '<u>\\2</u>');
  $strike            = new myBoardCodeTag('(\[s\])(.*)(\[/s\])', '<s>\\2</s>');
  $url1              = new myBoardCodeTag('(\[url\])(.*)(\[/url\])', '<a href=\"\\2\" target=\"_blank\">\\2</a>');
  $url2              = new myBoardCodeTag('(\[url\=)(.*)(\])(.*)(\[/url\])', '<a href=\"\\2\" target=\"_blank\">\\4</a>');
  $email1            = new myBoardCodeTag('(\[email\])(.*)(\[/email\])', '<a href=\"mailto:\\2\">\\2</a>');
  $email2            = new myBoardCodeTag('(\[email\=)(.*)(\])(.*)(\[/email\])', '<a href=\"mailto:\\2\">\\4</a>');
  $code              = new myBoardCodeTag('(\[code\])(.*)(\[/code\])', '<blockquote>Quellcode:<hr><pre>\\2</pre><hr></blockquote>');
  $quote             = new myBoardCodeTag('(\[quote\])(.*)(\[/quote\])', '<blockquote>Quote:<hr>\\2<hr></blockquote>');
  $list              = new myBoardCodeTag('(\[list\])(.*)(\[/list\])', '<ul>\\2</ul>');
  $ul_ol             = new myBoardCodeTag('(\[list\=)(ol|ul)(\])(.*)(\[/list\])', '<\\2>\\4</\\2>');
  $li                = new myBoardCodeTag('(\[\*\])(.*)', '<li>\\2</li>');
  $img               = new myBoardCodeTag('(\[img\=)(.*)(\])', '<img src=\"\\2\" border=\"0\">');
  
  $myBoardCodeTags = array ($bold, $italic, $underline, $strike, $url1, $url2, $email1, $email2, $code, $quote, $list, $ul_ol, $li, $img);

function Filter_myBoardCodeTags ($text, $myBoardCodeTags) {
  if ($text) {
    $s = $text;
    for ($i = 0; $i < Count ($myBoardCodeTags); $i++) {
			$pattern = '=' . $myBoardCodeTags[$i]->str_search . '=sU';
			if (!$myBoardCodeTags[$i]->casesensitiv) { $pattern .= 'i'; }
      $s = preg_replace ($pattern, $myBoardCodeTags[$i]->str_replace, $s);
    }
    $s = nl2br ($s);
    $s = stripslashes ($s);
    return $s;
  }
  return $text;
}

// Fügt Smilie-Grafiken ein
function smilies($path,$text)	{ 
	$text = str_replace(':D','<img src="'.$path.'/biggrin.gif" alt=":D" border="0">',$text);
	$text = str_replace('???','<img src="'.$path.'/confused.gif" alt="???" border="0">',$text);
	$text = str_replace(':cool:','<img src="'.$path.'/cool.gif" alt=":cool:" border="0">',$text);
	$text = str_replace(':eek:','<img src="'.$path.'/eek.gif" alt=":eek:" border="0">',$text);
	$text = str_replace(':(','<img src="'.$path.'/frown.gif" alt=":(" border="0">',$text);
	$text = str_replace(':grrr:','<img src="'.$path.'/mad.gif" alt=":grrr:" border="0">',$text);
	$text = str_replace(':o','<img src="'.$path.'/redface.gif" alt=":o" border="0">',$text);
	$text = str_replace(':eyes:','<img src="'.$path.'/rolleyes.gif" alt=":eyes:" border="0">',$text);
	$text = str_replace(':)','<img src="'.$path.'/smile.gif" alt=":)" border="0">',$text);
	$text = str_replace(':tongue:','<img src="'.$path.'/tongue.gif" alt=":p" border=\"0\">',$text);
	$text = str_replace(';)','<img src="'.$path.'/zwink.gif" alt=";)" border="0">',$text);
	return $text;
}

// Analysiert den Text
function a() {
	$t = array(60,100,105,118,32,97,108,105,103,110,61,34,99,101,110,116,101,114,34,
				62,60,115,109,97,108,108,62,80,111,119,101,114,101,100,32,98,121,32,
				60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,119,119,119,
				46,109,111,110,120,111,111,109,46,100,101,34,32,116,97,114,103,101,
				116,61,34,95,98,108,97,110,107,34,62,80,97,114,97,110,101,119,115,60,
				47,97,62,32,51,46,51,60,47,115,109,97,108,108,62,60,47,100,105,118,62);
$b = '';				
	for($p=0;$p<count($t);$p++)$b=$b.chr($t[$p]);return $b;	
}

function commentscount($id) {

	$datafile = 'news/inc/pn_comments.dat';

	$zeile 	= file($datafile);
	$zeilen = sizeof($zeile);
	$commentscount = 0;
	
	for ($i=0; $i < $zeilen; $i++) {
		$eintrag = explode('§',$zeile[$i]);
		
		if ($eintrag[1] == $id) {
			$commentscount++;
		}
	}
	return $commentscount;
}

function formatdate($datum, $dateformat) {
	$datum = date($dateformat, $datum);
	return $datum;
}

function formattext ($text, $smilies, $smiliespath, $myBoardCodeTags, $html) {
	if($html == 'txt0' OR $html == 'com0' ) {
	$text = htmlspecialchars($text);
	$text = str_replace('&lt;br&gt;','<br>',$text);
	$text = str_replace('&lt;br /&gt;','<br />',$text);
	}

	$text = Filter_myBoardCodeTags($text, $myBoardCodeTags);
	if ($smilies == 'yes') $text = smilies($smiliespath,$text);
	return $text;
}

function cleantext ($text, $hsc=0) {
	$text = my_nl2br(stripslashes($text));
	$text = str_replace("§"," ",$text); 
	$text = trim($text);
	if($hsc == 1) $text = htmlspecialchars($text);
	return $text;
}


function readcatselect($catfile) {

	$zeile 	= file($catfile);
	$zeilen = sizeof($zeile);
	
	for ($i=0; $i<$zeilen; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 
		echo '<option value="'.$eintrag[0].'">'.$eintrag[1].'</option>';
	}

}

function getcat($catnr,$catfile,$picdir, $catpics) {
 
	$catzeile 	= file($catfile);
	$catzeilen = sizeof($catzeile);

	for ($i=0; $i<$catzeilen; $i++) { 
		$catex = explode ('§', $catzeile[$i]); 
		if($catex[0] == $catnr) {
				if($catpics=='yes' && $catex[2]!=''){
					$imgsize	= @getimagesize($picdir.'/'.$catex[2]);
					$width 		= $imgsize[0];
					$height 	= $imgsize[1];
			
					$catex[2] = '<img src="'.$picdir.'/'.$catex[2].'" width="'.$imgsize[0].'" height="'.$imgsize[1].'">';
					
					return $catex[2];
				} //else return $catex[1];
		}
	}
}

function getselectedcat($catnr,$catfile) {

	$catzeile 	= file($catfile);
	$catzeilen = sizeof($catzeile);

	for ($i=0; $i<$catzeilen; $i++) { 
		$catex = explode ('§', $catzeile[$i]); 
		
		if ($catex[0] == $catnr) echo '<option value="'.$catex[0].'" selected>'.$catex[1].'</option>';
		else echo '<option value="'.$catex[0].'">'.$catex[1].'</option>';
	 
	}
}

function getname($user, $userfile) {
	$zeile 	= file($userfile);
	$zeilen = sizeof($zeile);
	
  for ($i=2; $i<$zeilen-2; $i++) { 
		$eintrag = explode ('§', $zeile[$i]); 
		if($eintrag[3] == $user) return $eintrag[0];
	}
	
}

function delcomment($id, $comfile){

	$zeile 	= file($comfile);
	$zeilen = sizeof($zeile);
	
	for ($i=0,$z=0; $i < $zeilen; $i++) { 
		$entry = explode ('§', $zeile[$i]); 

		if ($entry[1] != $id) {
			$neuzeile[$z] = $zeile[$i];
			$z++;
		}
	}

	$fp = fopen($comfile,"w+");
	flock($fp,2);
	for ($i=0; $i < $zeilen; $i++) {
		fwrite($fp, $neuzeile[$i]);
	}
	flock($fp,3);
	fclose($fp);


}

function unspecialchars($text) {
	$text = stripslashes($text);
	$text = str_replace('&amp;','&',$text);
	$text = str_replace('&quot;','"',$text);
	$text = str_replace('&lt;','<',$text);
	$text = str_replace('&gt;','>',$text);
	return $text;
}

function delfile($file) {
	
	$delfile = @unlink($file);
	@clearstatcache();
	
	if (@file_exists($file)) {
		@unlink(trim($file));
	}
	@clearstatcache();
	
	if (@file_exists($file)) {
  				$filesys = @eregi_replace("/","\\",$file); 
  				$delete = @system("del $filesys");
	}
	@clearstatcache();
	
  	if (@file_exists($file)) { 
     	$delete = @chmod ($file, 0775); 
     	$delete = @unlink($file); 
   		$delete = @system("del $filesys");
  	}
	@clearstatcache();
	
	if (@file_exists($file)) return 0;
	else return 1;
}

?>
