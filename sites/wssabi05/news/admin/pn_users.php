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
$goback = '<br /><a href=javascript:history.back()>Zurück</a>';

$datafile = '../inc/pn_userdata.php';
if (!file_exists($datafile)) fclose(fopen($datafile,"w+"));
$zeile = file($datafile);
$zeilen = sizeof($zeile);

#########################################################
#                       STANDARD                        #
#########################################################
if (!$_GET['go']) {

	/* Standard-Ausgabe */
	drawheader('View Users'); 

	/* Ausgabe aller User */
	echo '<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
			<tr class="tr2">
				<td><b>Login-Name</b></td>
					<td><b>Level</b></td>
				    <td></td>
			    </tr>';

	for($i=2; $i<sizeof($zeile)-2; $i++) { 
		$eintrag = explode('§',$zeile[$i]);

		echo'<tr class="tr1">
				<td width="50%">'.$eintrag[0].'</td>
				<td width="30%">'.$eintrag[1].'</td>
				<td width="20%">
					<a href="pn_users.php?go=changeuser&id='.$eintrag[3].'">Bearbeiten</a> - 
					<a href="pn_users.php?go=deluser&id='.$eintrag[3].'">Löschen</a> 
				</td>
			</tr>';
	}
	/* ------------------ */
	echo '</table><br /><a href="pn_users.php?go=adduser">User hinzuf&uuml;gen</a><br /><br />'; 
}
#########################################################
#                        ADDUSER                        #
#########################################################
if ($_GET['go'] == 'adduser') {

	drawheader('Neuer Benutzer');

	echo'<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
			<tr class="tr2">
				<td>
	      <b>Hier kannst Du beliebig viele neue Benutzer erstellen.</b><br />
	      Ein Benutzer mit dem Level &quot;User&quot; kann sich einloggen, Nachrichten 
	  		schreiben, editieren und l&ouml;schen. Er kann aber keine Benutzerdaten editieren, 
	  		Benutzer l&ouml;schen oder &Auml;nderungen an den Konfiguration des Scripts 
	  		vornehmen. Dies kann nur ein Benutzer mit dem Level &quot;Admin&quot;
	      </td>
	    </tr>
	    <tr class="tr1">
	      <td>';
		  
		  
#########################################################
#                 ADDUSER - NO ACTION                   #
#########################################################
if (!$_GET['action']) {  
	echo'<form method="POST" action="'.$_SERVER['PHP_SELF'].'?go=adduser&action=save">
	  <table width="80%" border="0" cellspacing="1" cellpadding="0">
	    <tr class="tr1"> 
	      <td width="200">Login-Name:</td>
	      <td> 
	        <input type="text" name="user" size="30" maxlength="150">
	      </td>
	    </tr>
	    <tr class="tr1"> 
	      <td width="200">Passwort:</td>
	      <td>
	        <input type="password" name="pwd" size="30" maxlength="150">
	      </td>
	    </tr>
	    <tr class="tr1"> 
	      <td width="200">Nochmal:</td>
	      <td>
	        <input type="password" name="pwd2" size="30" maxlength="150">
	      </td>
	    </tr>
	    <tr class="tr1"> 
	      <td width="200">Level:</td>
	      <td>
	        <select name="level">
	          <option value="user">User</option>
	          <option value="admin">Admin</option>
	        </select>
	      </td>
	    </tr>
	    <tr class="tr1"> 
	      <td width="200">&nbsp;</td>
	      <td>
	        <input type="submit" value="Send" name="submit">
	      </td>
	    </tr>
	  </table>
	</form>';
}
#########################################################
#                   ADDUSER - SAVE                      #
######################################################### 

if($_GET['action'] == 'save') {

	if(($_POST['user'] == '') OR ($_POST['pwd'] == '') OR ($_POST['pwd2'] == '')) {
    	echo message('error', 'Bitte fülle alle Felder aus!',1);
		echo'</td></tr></table>';
		drawfooter($version);
		exit();
    }

	if($_POST['pwd'] != $_POST['pwd2']) {
		echo message('error', 'Unterschiedliche Passw&ouml;rter angegeben!',1);
		echo'</td></tr></table>';
		drawfooter($version);
		exit();
  	}

	// find max id
	$fp = fopen($datafile,"r");
	for ($i=2; $i<$zeilen-2; $i++)
	{
    $eintrag = explode('§',$zeile[$i]);
    if($i==2) $id = $eintrag[3];
    else $eintrag[3] > $id ? $id = $eintrag[3] : 0; 
  }
	fclose($fp);
  
  // add 1 to max id to get new id
  $id++;

	if ($zeilen) {
		if(strlen($id)==1) $id = '00'.$id; 
		if(strlen($id)==2) $id = '0'.$id;
	} else $id = 1;

  $_POST['user'] 	= cleantext($_POST['user']);
	$_POST['pwd'] 	= crypt($_POST['pwd'], 'lala');
  $nl = chr(13).chr(10);
	

  $fp = fopen($datafile,"w+");
  flock($fp,2);
  fwrite($fp, '<?php'.$nl );
  fwrite($fp, '/*' .$nl );
  for ($i=2; $i<$zeilen-2; $i++)
  fwrite($fp, $zeile[$i]);
  fwrite($fp, my_nl2br(implode(array ($_POST['user'], $_POST['level'], $_POST['pwd'], $id, '') ,'§')) . $nl);
  fwrite($fp, '*/' .$nl );
  fwrite($fp, '?>' );
  flock($fp,3);
  fclose($fp);

	echo'<br />
	User erfolgreich hinzugefügt!<br />
	Hier nochmal die Daten:<br />
	Login-name: <b>'.$_POST['user'].'</b><br />
	Passwort(verschlüsselt): <b>'.$_POST['pwd'].'</b><br />
	Level: <b>'.$_POST['level'].'</b>';

}
#########################################################
	echo'</td>
	    </tr>
	  </table>';
	        
}
#########################################################
#                      CHANGEUSER                       #
#########################################################
if ($_GET['go'] == 'changeuser') {

	drawheader('Benutzerdaten &auml;ndern');
	echo'<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
					<tr class="tr2">
						<td>Hier kannst Du die Daten eines Benutzers ab&auml;ndern.<br />
								Beachte, da&szlig; derjenige User Vollzugriff auf alle Optionen des Scripts 
	  						erh&auml;lt, dem Du den Level &quot;Admin&quot; zuteilst.
            </td>
	    		</tr>
	    		<tr class="tr1">
	      		<td>';

#########################################################
#                CHANGEUSER - NO ACTION                 #
#########################################################            
            
	if (!$_GET['action']) {

   for ($i=2; $i < $zeilen-2; $i++) { 
    $eintrag = explode('§', $zeile[$i]); 
    if ($eintrag[3] == $_GET['id']) {
	  	echo '
			<form method="POST" action="'.$_SERVER['PHP_SELF'].'?go=changeuser&action=save">
		  	<input type="hidden" name="saveid" value="'.$_GET['id'].'">
        <input type="hidden" name="savepw3" value="'.$eintrag[2].'">
			  <table width="80%" border="0" cellspacing="1" cellpadding="0">
			    <tr class="tr1"> 
			      <td>Loginname:</td>
			      <td>
			        <input type="text" name="saveuser" size="30" maxlength="150" value="'.$eintrag[0].'">
			      </td>
			    </tr>
			    <tr class="tr1">
			      <td>Passwort (verschlüsselt):</td>
			      <td>
			        <input type="password" name="savepw" size="30" maxlength="150" value="'.$eintrag[2].'">
			      </td>
			    </tr>
			    <tr class="tr1">
			      <td>Passwort wiederholen:</td>
			      <td>
			        <input type="password" name="savepw2" size="30" maxlength="150" value="'.$eintrag[2].'">
			      </td>
			    </tr>
			    <tr class="tr1">
			      <td>Level:</td>
			      <td>
			        <select name="savelevel">';

			if ($eintrag[1] == 'user') { echo '<option value="user" selected>User</option>'; } 
			else {echo '<option value="user">User</option>'; }
			if ($eintrag[1] == 'admin') { echo '<option value="admin" selected>Admin</option>'; } 
			else {echo '<option value="admin">Admin</option>'; }

			echo '</select>
			      </td>
			    </tr>
			    <tr class="tr1">
			      <td>&nbsp;</td>
			      <td>
			        <input type="submit" value="Send" name="submit">
			      </td>
			    </tr>
        </table>
        </td>';
      	}
			}
    }
 
#########################################################
#                  CHANGEUSER - SAVE                    #
######################################################### 

	if($_GET['action'] == 'save') {

		if ($_SESSION['loginlevel'] != 'admin') echo message('error', 'Sorry, nur Admins dürfen Userdaten ändern!',1);
		
		else if ($_POST['savepw'] != $_POST['savepw2']) echo message('error', 'Unterschiedliche Passwörter angegeben!',1);
		
		else {


			for ($i=0; $i<$zeilen; $i++) {
				$eintrag = explode('§',$zeile[$i]);

				if ($eintrag[3] == $_POST['saveid']) {
					$eintrag[0] = $_POST['saveuser'];
		        	$eintrag[1] = $_POST['savelevel'];


    				if ($_POST['savepw2'] != $_POST['savepw3'])	{
    					$_POST['savepw'] = crypt($_POST['savepw'], 'lala');
              			$eintrag[2] = $_POST['savepw'];
      				}
		        }
          	$zeile[$i] = implode($eintrag,'§');
		    }

      $nl = chr(13).chr(10);
      $fp = fopen($datafile,"w+");
      fwrite($fp, '<?php' .$nl );
      fwrite($fp, '/*'.$nl  );
      for ($i=2; $i<$zeilen-2; $i++)
      fwrite($fp, $zeile[$i]);
      fwrite($fp, '*/' .$nl );
      fwrite($fp, '?>' );
      fclose($fp);
 
		  echo 'Gespeichert!<br /><br />
			Userdaten erfolgreich geändert!<br />
			Hier nochmal die Daten:<br />
			Loginname: <b>'.$_POST['saveuser'].'</b><br />
			Level: <b>'.$_POST['savelevel'].'</b><br /><br />
			<b>Damit die geänderten Einstellungen wirksam werden, musst Du Dich neu einloggen!</b>';
			}

	}
#########################################################
	echo'</td>
	    </tr>
	  </table>';

  }
#########################################################
#                        DELUSER                        #
#########################################################
if ($_GET['go'] == 'deluser') {
	
	drawheader('Benutzer l&ouml;schen');
	echo'<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
		  <tr class="tr1">
		    <td>';
        
	if ($_SESSION['loginlevel'] != 'admin') {
		echo message('error', 'Sorry, nur Admins dürfen User löschen!',1);
		
	} else {
  		for ($i=0; $i < $zeilen; $i++) { 
    		$eintrag = explode("§", $zeile[$i]); 
	    
			if ($eintrag[3] == $_GET['id']) { 
	      		$zeilen--; 
	      		
				for ($j=$i; $j < $zeilen; $j++) {
					$zeile[$j]=$zeile[$j+1]; 
				}
	      	} 
	    }
		$fp = fopen($datafile,"w+"); 
		for ($i=0; $i < $zeilen; $i++) 
		fwrite($fp, $zeile[$i]); 
		fclose($fp);
		echo message('msg', 'User gel&ouml;scht!',1);
	}
	
		echo'</td>
		    </tr>
		  </table>';
	
	}
drawfooter($version);
?>
