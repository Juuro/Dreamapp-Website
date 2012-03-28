<?php
include '../inc/functions.inc.php';
$datafile = '../inc/pn_userdata.php';
if (!file_exists($datafile)) fclose(fopen($datafile,"w+"));
$zeile = file($datafile);
$zeilen = sizeof($zeile);
/*************************************************************************************************/
if(!$_GET['go'])
{
	echo '
	<html><head>
	<title>.:ParaNews '.$version.':.</title>
	<link rel="stylesheet" href="pn_styles.css" type="text/css">
	</head>
	<body bgcolor="#FFFFFF">
	<div align="center">
	<br /><br />
		<form method="POST" action="'.$_SERVER['PHP_SELF'].'?go=login">
	    <p><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="4">.:Login:.</font></b></font></p>
	    <table align="center" cellpadding="0" cellspacing="1" border="0" class="rahmen">
		      <tr class="tr2"> 
  	      <td colspan="2"> 
	          <div align="center">Um diesen Bereich zu betreten, musst Du Dich einloggen!</div>
	        </td>
	      </tr>
	      <tr class="tr1"> 
	        <td width="100">&nbsp;Loginname</td>
	        <td width="300"> &nbsp;<select name="id">'; 
 				
		for ($i=2; $i<sizeof($zeile)-2; $i++) 
    { 
			$eintrag = explode('§',$zeile[$i]);
			echo'<option value="'.$eintrag[3].'">'.$eintrag[0].'</option>';
		}       

    echo '</select>
    			</td>
	      </tr>
	      <tr class="tr1"> 
	        <td width="100">&nbsp;Passwort</td>
	        <td width="300">&nbsp; 
	          <input type="password" name="pw" size="30" maxlength="150">
	        </td>
	      </tr>
	      <tr class="tr1"> 
	        <td width="100"></td>
	        <td width="300"> &nbsp; 
	          <input type="submit" value="Send" name="submit">
	        </td>
	      </tr>
	    </table>
	</form>
	<br /><br /><div align="center"><small><!-- Do not remove this copyright notice -->Powered by <a href="http://www.monxoom.de" target="_blank">ParaNews</a> '.$version.'</small></div>
	</html>';

}
/*************************************************************************************************/
if($_GET['go'] == 'login')
{
	@session_start();
	
	if (empty($_POST['id']) OR empty($_POST['pw'])) {
		exit('Komm schon, Name und Passwort - so schwer ist das nicht!? ...versuchs einfach nochmal =) <meta http-equiv="refresh" content="4; URL=pn_login.php">');
	}
	
	$_POST['pw'] = crypt($_POST['pw'], 'lala');

	for ($i=2; $i<$zeilen-2; $i++) {  
		$eintrag = explode('§', $zeile[$i]); 

		if ($eintrag[3] == $_POST['id']) {
			$_SESSION['loginuser'] 	= $eintrag[0];
			$_SESSION['loginlevel'] = $eintrag[1];      
			$_SESSION['loginpwd'] 	= $eintrag[2];
			$_SESSION['loginid'] 	= $eintrag[3];
		}
		
	}
    
	if($_SESSION['loginpwd'] != $_POST['pw']) {
		echo 'Falsches Passwort! '.$goback;
		session_destroy();
		exit;
    }
  
	header("Location: index.php?$session");  	 
}
/*************************************************************************************************/
?>
