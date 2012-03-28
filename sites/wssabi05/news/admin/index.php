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

session_start();
include '../inc/functions.inc.php';
include '../inc/config.inc.php';
checklogin();

if ($_GET['pane'] == 'left') {
echo '
<html>
<head>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<title>.::paranews [admin-navi]::.</title>
<meta http-equiv="Content-Type" content="text/html"; charset="iso-8859-1">
<link rel="stylesheet" href="pn_styles.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<center>
<br />
<h3>.:Admin:.</h3>
  <table width="100%" border="0" cellspacing="0" cellpadding="2" class="rahmen">
    <tr class="tr2">
      <td><b>Optionen:</b></td>
    </tr>
    <tr class="tr1"> 
      <td><b>News</b><br />
        <a href="../'.$newsoutput.'" target="main">Ansicht</a><br />
        <a href="pn_write.php?'.$session.'" target="main">Schreiben</a><br />
        <a href="pn_edit.php?'.$session.'" target="main">Editieren</a><br />';

if($_SESSION['loginlevel'] == 'admin') {       
	echo'<br />
        <b>User</b><br />
        <a href="pn_users.php?'.$session.'" target="main">Alle User</a><br />
        <a href="pn_users.php?go=adduser&'.$session.'\" target="main">Neuer User</a><br />
        <br />
        <b>Layout</b><br />
        <a href="pn_layout.php?go=file&file=../template.htm&'.$session.'" target="main">Ausgabe</a><br />
        <a href="pn_settings.php?'.$session.'" target="main">Einstellungen</a><br />
		<a href="pn_categories.php?'.$session.'" target="main">Kategorien</a>';
	}

	echo'</td>
    </tr>
    <tr class="tr2"> 
      <td> <b><a href="pn_logout.php?'.$session.'" target="_parent">Logout</a></b></td>
    </tr>
  </table>
<br />
Eingeloggt als<br />
<b>'.$_SESSION['loginuser'].'</b>
</center>
</body>
</html>';
exit();
}

if ($_GET['pane'] == 'right') {
	drawheader('.:ParaNews '.$version.':.');
	echo'<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
		  	<tr valign="top" class="tr1">
	    		<td>';
	echo'
	<p><b>Willkommen im Admin-Center der ParaNews!</b></p>
	<p>Um zu den einzelnen Kategorien zu gelangen, benutze einfach die Navigationsbar am linken Bildschirmrand.
	<br />Hast du Fragen zum Script oder allgemein zur Gestaltung von WebSites? 
	Dann besuche das <a href="http://labstation.de/forum" target="blank">LabStation</a>-Board!</p><br />';
	
		echo'</td>
			  </tr>
			</table>';
	drawfooter($version);
	
	exit();
}  

else {   

echo '  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>.::paranews [admin]::.</title>
</head>
<frameset cols="100,*" rows="*" border="0" framespacing="0" frameborder="NO">
  <frame src="index.php?pane=left&'.$session.'" name="nav" noresize marginwidth="3" marginheight="0" scrolling="no">
  <frame src="index.php?pane=right&'.$session.'" name="main" marginwidth="10" marginheight="0" scrolling="auto">
	<noframes>
		<p>Sorry, your browser doesn´t seem to support frames</p>
	</noframes>
</frameset>
</html>';

}
?>
