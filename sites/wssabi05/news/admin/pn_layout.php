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

include '../inc/functions.inc.php';
checklogin();
adminonlyaccess($_SESSION['loginlevel']);

drawheader('Edit Layout');
print'<table width="90%" border="0" cellspacing="1" cellpadding="0" align="center" class="rahmen">
	  	<tr class="tr3" valign="top">
    		<td colspan="3"><b>Hier kannst du das Layout der Ausgabeseite anpassen.</b>';

if ($_GET['go'] == 'save') {
	$_POST['content'] = unspecialchars($_POST['content']);
	
	$fp = fopen($_GET['file'],"w+");
	fputs($fp,$_POST['content']);
	fclose($fp);
	print '<br /><br /><b>Erfolgreich gespeichert</b>';
  }

print'</td></tr><tr class="tr1">';

  // Zeigt die Tabelle mit dem Textfield an
	print'<td valign="top"><form method="post" action="'.$_SERVER['PHP_SELF'].'?go=save&file='.$_GET['file'].'">
  				<div align="center">
					<textarea name="content" wrap="off" cols="70" rows="63">';
						$ef = $_GET['file'];
						$fp = fopen($ef,"r");
						while (feof($fp) != 1)
						echo addslashes(htmlspecialchars(fgets($fp,1024))); 
		print'</textarea>
    			</div>
        	<input type="submit" name="Save" value="&Auml;nderungen speichern">
      	</form>
    	</td>
		  <td>

	<table width="100%" border="0" cellspacing="0" cellpadding="1">
	  <tr class="tr1">
	    <td colspan="2">Dieses Template bestimmt zusammen mit dem CSS das Aussehen
      der Ausgabe-Seite.<br>
      Das Template hat mehrere Bl&ouml;cke:</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>&lt;!-- BEGIN Blockname--&gt;</b></td>
	    <td>- Kennzeichnet den Beginn des Blocks &quot;Blockname&quot;</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>&lt;!-- END Blockname --&gt;</b> <b>	      </b></td>
	    <td>- Kennzeichnet dessen Ende</td>
      </tr>
	  <tr class="tr1">
	    <td colspan="2"><br>
	      Der Loop-Block <b>muss auf jeden Fall</b> erhalten bleiben.
	      Wer das Kommentar-System nicht nutzen m&ouml;chte, kann die anderen Bl&ouml;cke
	      l&ouml;schen (inklusive den Begin- und End-Kennzeichnern).<br />
Der Block &quot;Commentsheader&quot; ist <b>optional</b> und schr&auml;nkt bei
Entfernen nicht den Funktionsumfang des Scripts ein.<br>
<br>
<b>Der Loop-Block:</b><br />
In diesem Bereich wird <b>alles</b> so oft wiederholt, wie Newsartikel vorhanden
sind, d.h. alles was in diesem Bereich steht, wird &quot;geloopt&quot;. Diese
Kommentare <b>m&uuml;ssen</b> erhalten bleiben:</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%cat%%</b></td>
	    <td>- Anzeige der News-Kategorie</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%newsnr%%</b></td>
	    <td>- Die News bekommen Nummern</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%title%%</b></td>
	    <td>- Titel der News</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%autor%%</b></td>
	    <td>- Anzeige des Redakteurs</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%news%%</b></td>
	    <td>- Der Artikel</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%datum%%</b></td>
	    <td>- Datum der News</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%readmore%%</b> </td>
	    <td>- Der Link zur ausf&uuml;hrlichen News</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%comments%%</b></td>
	    <td> - Der Link zur Kommentaranzeige</td>
      </tr>
	  <tr class="tr1">
	    <td colspan="2"><b><br>
        Der Commentsheader-Block:</b><br />
Hier bekommt der Besucher einen &Uuml;berblick &uuml;ber die vorhandenen Kommentare.</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%commentscount%%</b> </td>
	    <td>- Die Anzahl vorhandener Kommentare</td>
      </tr>
	  <tr class="tr1">
	    <td colspan="2"><b><br>
        Der Comments-Block:</b><br />
In diesem Block erscheinen alle Kommentare, die zu einer News abgegeben wurden.</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%commentnr%%</b></td>
	    <td> -Nummern zu den Kommentare</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%datum%%</b> </td>
	    <td>- Datum des Kommentars</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%autor%%</b></td>
	    <td>- Der Verfasser</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%comment%%</b> </td>
	    <td>- Der Kommentar-Text</td>
      </tr>
	  <tr class="tr1">
	    <td colspan="2"><b><br>
        Der Commentform-Block:</b><br />
Dieser Block sorgt daf&uuml;r, da&szlig; ein Formular zum Verfassen neuer News
erscheint. Er kann frei bearbeitet werden, jedoch m&uuml;ssen die ersten drei Tags 
des Formulars (<em>form action sowie 2x input</em>) unver&auml;ndert erhalten
bleiben.<b><br>
<br>
Variablen au&szlig;erhalb von Bl&ouml;cken:</b></td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%backlink%%</b></td>
	    <td>- Wenn man z.B. von einem Kommentar zur&uuml;ck zur Hauptseite will</td>
      </tr>
	  <tr class="tr1" valign="top">
	    <td><b>%%last%%</b> und <b>%%next%%</b> </td>
	    <td>- Bl&auml;ttern zwischen News</td>
      </tr>
	  <tr class="tr2" valign="top">
	    <td><b>%%top%%</b></td>
	    <td>- Link, um nach oben zu scrollen</td>
      </tr>
	  <tr class="tr1">
	    <td colspan="2"><br>
	      Fragen zur Anpassung des Scripts oder zum Script selbst? <br />
Besucht das <a href="http://labstation.de/forum" target="blank">LabStation</a>-Board! </td>
      </tr>
</table>

		</td>
		  </tr>
		</table>';
drawfooter($version);
?>
