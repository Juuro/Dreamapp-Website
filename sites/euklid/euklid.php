<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Euklid'scher Algorithmus</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div id="umg">
<div id="formular">
<form id="Euklid" action="euklid.php" method="post">

<fieldset>
<legend>Euklid'scher Algorithmus</legend>

<label for="Name">
    a =
    <input id="a" name="a" type="text"/>
</label>

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
    
    $i = 1;
    $a[1] = $_POST["a"];
    $b[1] = $_POST["b"];
    
    if($a[1] != 0 && $b[1] != 0){
    $g = $b[$i];
    echo 'Ihre eingegebenen Werte:';
    echo '<br />';
    echo 'a = ' . $a[$i];
    echo '<br />';
    echo 'b = ' . $b[$i];
    
    $a[$i] = abs($a[$i]);
    $b[$i] = abs($b[$i]);
    
    echo '<br />';
    echo '<br />';
    
    while($g != 0){
        echo '<br />';
        echo '<b>Schritt ' . $i . '</b>';
        echo '<div id="schritt">';
        if($a[$i] > $b[$i]){
            echo $a[$i] . ' > ' . $b[$i];
            echo '<br />';
            $a[$i+1] = $a[$i] - $b[$i];
            echo 'a = a - b';
            echo '<br />';
            echo 'a = ' . $a[$i+1];
            echo '<br />';
            echo 'b = ' . $b[$i];
            echo '<br />';
            $b[$i+1] = $b[$i];
        }
        else{
            echo $a[$i] . ' <= ' . $b[$i];
            echo '<br />';
            $b[$i+1] = $b[$i] - $a[$i];
            $g = $b[$i+1];
            echo 'b = b - a';
            echo '<br />';
            echo 'a = ' . $a[$i];
            echo '<br />';
            echo 'b = ' . $b[$i+1];
            echo '<br />';
            $a[$i+1] = $a[$i];
        
        }
        if($g != 0){
            echo $g . ' ist nicht 0';
            echo '</div>';
        }
        else{
            echo $g . ' = ' . 0;
            echo '</div>';
            echo '<br />';
            echo '<br />';
            echo '=> Abbruch';
        }
        $i++;
    }
    echo '<br />';
    echo '<br />';
    echo 'ggt(' . $a[1] . ', ' . $b[1] .') = ' . $a[$i];
    echo '<br />';
    echo 'Es wurden ' . ($i-1) . ' Schritte ben&ouml;tigt!';
    }    
    else{
        echo 'Bitte geben Sie eine Zahl an die verschieden von Null ist an.';
    }
    
echo '</div>';
    
include 'footer.php';
?>

</body>
</html>