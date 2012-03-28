<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Modulo</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div id="umg">
<div id="formular">
<form id="modulo" action="modulo.php" method="post">

<fieldset>
<legend>Modulo</legend>

<label for="Name">
    a =
    <input id="a" name="a" type="text"/>
</label>
mod
<label for="email">
    b =
    <input id="b" name="b" type="text"/>
</label>

<input id="abschicken" type="submit" value="berechnen"/>

</fieldset>
</form>
</div>
</div>
<br />
<br />

<div id="code">


<?php
//Modulo-Rechner

echo '<br /><br />';

$zahl1 = $_POST["a"];
$zahl2 = $_POST["b"];
$ergebnis = '';

//2147483647^15000 durch 20000 teilen
$ergebnis = $zahl1 / $zahl2;
echo 'Rest: ' . $zahl1%$zahl2;

//Ergebnis abrunden auf 0 Stellen nach dem Komma
$ergebnis = round ($ergebnis,0);

//gerundetes Ergebnis mal 20000 nehmen und von 2147483647^15000 abziehen
$ergebnis = $zahl1 -($ergebnis * $zahl2);

//es kommt der Rest 8647 heraus
echo 'Das Ergebnis ist '.$ergebnis.'!';

?>

</body>
</html>