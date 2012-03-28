<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>regimmo</title>
		<script src="./js/jquery-1.3.2.min.js" type="text/javascript"></script>
		<script src="./js/ready.js" type="text/javascript"></script>		
		<script src="./js/jquery-validate/jquery.validate.js" type="text/javascript"></script>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>		
		<div id="wrapper">
			<div id="header">
				<img src="img/logo-regimmo.png" alt="logo-regimmo" width="600" height="193"/>
			</div>
			<div id="content">
				
					
			
				<?php
					if(isset($_POST["sent"])){
						$issue = $_POST["issue"];
						$adsize = $_POST["adsize"];
						if(isset($_POST["adsize_misc"]) && $_POST["adsize_misc"]!=""){
							$adsize_misc = $_POST["adsize_misc"];
						}
						$firm = $_POST["firm"];
						$lastname = $_POST["lastname"];
						$firstname = $_POST["firstname"];
						$street = $_POST["street"];
						$number = $_POST["number"];
						$city = $_POST["city"];
						$phone = $_POST["phone"];
						$fax = $_POST["fax"];
						$email = $_POST["email"];
						$misc = $_POST["misc"];
						$referer = $_POST["referer"];
						if(isset($_POST["referer_misc"]) && $_POST["referer_misc"]!=""){
							$referer_misc = $_POST["referer_misc"];
						}
						$newsletter = $_POST["newsletter"];
						$agb = $_POST["agb"];
						
						$mailtext = "<h1>Anzeigenbestellung</h1><p>Ausgabe: ".$issue."<br />
									Anzeigengröße: ".$adsize." ".$adsize_misc."<br />
									Firma: ".$firm."<br />
									Name: ".$lastname."<br />
									Vorname: ".$firstname."<br />
									Straße: ".$street."<br />
									Hausnummer: ".$number."<br />
									PLZ+Ort: ".$city."<br />
									Telefon: ".$phone."<br />
									Telefax: ".$fax."<br />
									E-Mail: <a href='mailto:".$email."'>".$email."</a><br />
									Sonstiges: ".$misc."<br />
									Woher kennen Sie uns? ".$referer." ".$referer_misc."<br />
									Newsletter: ".$newsletter."<br />
									AGB gelesen und akzepztiert".$agb."<br /></p>";
						
						echo $mailtext;
						
						/*	Bild hochladen	*/
						if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){						
							$target_path = "uploads/";
							
							$target_path = $target_path . basename( $_FILES['file']['name']); 
							
							if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
							    echo "<p>Die Datei ".basename( $_FILES['file']['name'])." wurde erfolgreich hochgeladen!</p>";
							    /* echo "<p><img src='./uploads/".basename( $_FILES['file']['name'])."' alt='".basename( $_FILES['file']['name'])."' width='' height='' class='uploadedimage' /></p>"; */
							} else{
							    echo "<p>Beim Hochladen der Datei ist ein Fehler aufgetreten, bitte versuchen Sie es erneut!</p>";
							}
						}	
												
						/*	E-Mail ersstellen	*/
					    require_once('./Rmail/Rmail.php');
					    
					    $mail = new Rmail(); 
					    $mail->setHTMLCharset('UTF-8');
					    $mail->setFrom('Anzeigenbestellformular <anzeigen@regimmo.net>');
					    $mail->setSubject('regimmo :: Anzeigenbestellung');
					    $mail->setHTML($mailtext);
					    $mail->setReceipt('mail@sebastian-engel.de');
					    if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
						    $mail->addAttachment(new FileAttachment('./uploads/'.basename( $_FILES['file']['name']).''));
						}
					    $result = $mail->send(array('mail@sebastian-engel.de, '.$email));
					    
					    /*	Bild wieder löschen	*/
					    if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){						
					    	unlink('./uploads/'.basename( $_FILES['file']['name']).'');
					    }
						
					}
					else {				
				?>
				
				<h1>Hiermit bestelle ich verbindlich folgende Anzeigenschaltung</h1>
			
				<form class="ad-orderform" action="ad-orderform.php" method="post" enctype="multipart/form-data">
					<p>
						<input type="hidden" name="sent" value="sent" />
						
						<label for="issue">Ausgabe:</label>
						<select name="issue" id="issue" onclick="return CheckAuswahl()">
							<option value="0">bitte wählen</option>
							<option>Oktober 2009 (Anzeigenschluss: 21.09.2009)</option>
							<option>November 2009 ( Anzeigenschluss: 19.10.2009)</option>
							<option>Dezember 2009 (Anzeigenschluss: 20.11.2009)</option>
							<option>Januar 2010 (Anzeigenschluss: 18.12.2009)</option>
							<option>Februar 2010 (Anzeigenschluss: 18.01.2010)</option>
						</select>
					</p>
					<p>
						<label for="adsize">Anzeigengröße:</label>
						<select name="adsize" id="adsize">
							<option value="0">bitte wählen</option>
							<option>1/1, 200mm breit x 280mm hoch - Preis: 459,-</option>
							<option>2/1, 425mm breit x 280mm hoch - Preis: 799,-</option>
							<option>1/2quer, 200mm breit x 140mm hoch - Preis: 299,-</option>
							<option>1/2hoch, 100mm breit x 280mm hoch - Preis: 299,-</option>
							<option>1/3quer, 200mm breit x 90mm hoch - Preis: 169,-</option>
							<option>1/4, 98mm breit x 138mm hoch - Preis: 129,-</option>
							<option>Sonderformat:</option>
						</select>
						<input type="text" name="adsize_misc" class="adsize_misc" />
					</p>
					<p>
						<label for="file">Anzeige (PDF, JPG, TIFF):</label>					
						<input type="file" name="file" id="file" />
					</p>
					<p>
						<label for="firm">Firma:</label>
						<input type="text" name="firm" id="firm" class="required" />
					</p>
					<p>
						<label for="lastname">Name:</label>
						<input type="text" name="lastname" id="lastname" />
					</p>
					<p>
						<label for="firstname">Vorname:</label>
						<input type="text" name="firstname" id="firstname" />
					</p>					
					<p>
						<label for="street">Straße und Hausnummer</label>
						<input type="text" name="street" id="street" />
						<input type="text" name="number" id="number" />
					</p>
					<p>
						<label for="city">PLZ und Ort</label>
						<input type="text" name="city" id="city" />
					</p>					
					<p>
						<label for="phone">Telefon:</label>
						<input type="text" name="phone" id="phone"/>
					</p>
					<p>
						<label for="fax">Telefax:</label>
						<input type="text" name="fax" id="fax" />
					</p>
					<p>
						<label for="email">E-Mail:</label>
						<input type="text" name="email" id="email" />
					</p>
					<p>
						<label for="misc">Sonstiges:</label>
						<textarea name="misc" id="misc" cols="50" rows="4"></textarea>
					</p>
					<p>
						<label for="referer">Woher kennen Sie uns?</label>
						<select name="referer" id="referer">
							<option value="0">bitte wählen</option>
							<option>Internet</option>
							<option>Mailing</option>
							<option>Freund</option>
							<option>Sonstiges:</option>
						</select>
						<input type="text" class="referer_misc" name="referer_misc" />
					</p>
					<p>
						<span>Newsletter:</span>
						<span class="left">
							<input type="radio" name="newsletter" value="ja" id="newsletter1" /><label for="newsletter1">ja</label>
							<input type="radio" name="newsletter" value="nein" id="newsletter2" /><label for="newsletter2">nein</label>
						</span>
					</p>
					<p>
						<span>Zahlungsart:</span>
						<span class="left">Vorkasse</span>
					</p>
					<p>
						<span>Bankkonditionen:</span>	
						<span class="left">
							neuewerber (A.Detzel)<br />
							Kreissparkasse Böblingen<br />
							Konto: 1000823664<br />
							BLZ: 603 501 30
						</span>
					</p>
					<p>
						<label for="agb"><a href="http://www.regimmo.net/PDF/Mediadaten2009.pdf">AGB</a> gelesen und akzeptiert:</label>
						<input type="checkbox" name="agb" value="agb" id="agb" />
					</p>
					<p>
						<span>&nbsp;</span>
						<span class="left">
							<input type="submit" value="Senden" />
							<input type="reset" value="Abbrechen" />
						</span>
					</p>
				</form>
					
				<?php
					}
				?>
				
			</div>
			<div id="footer"></div>
		</div>
	</body>
</html>
