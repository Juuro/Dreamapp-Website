<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>erweiterter Euklid'scher Algorithmus</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div id="umg">
<div id="formular">
<form id="Euklid" action="e_euklid.php" method="post">

<fieldset>
<legend>erweiterter Euklid'scher Algorithmus</legend>

<label for="a">
    a =
    <input id="a" name="a" type="text"/>
</label>

<label for="b">
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
    $a = $_POST["a"];
    $b = $_POST["b"];
    $d;
    $s;
    $t;
    $s1;
    $t1;
    $g;
    $r;
    $x;
    $y;
    $z;
    
    if($a != 0 && $b != 0){
        echo 'Ihre eingegebenen Werte:';
        echo '<br />';
        echo 'a = ' . $a;
        echo '<br />';
        echo 'b = ' . $b;
        echo '<br />';
        echo '<br />';
        if(abs($a)>=abs($b)){
            $x=abs($a);
            $y=abs($b);
            echo 'Weil a >= b:';
            echo '<br />';
        }
        else{
            $x=abs($b);
            $y=abs($a);
            echo 'Weil a < b:';
            echo '<br />';
        }
        
        echo 'x = ' . $x;
        echo '<br />';
        echo 'y = ' . $y;
        echo '<br />';
        echo '<br />';
        
        $i=0;
        $s1=1;
        $s2=0;
        $s=0;
        $t1=0;
        $t2=1;
        $t=1;
        
        echo 'Startwerte:';
        echo '<br />';
        echo 's1 = ' . $s1;
        echo '<br />';
        echo 's2 = ' . $s2;
        echo '<br />';
        echo 's = ' . $s;
        echo '<br />';
        echo 't1 = ' . $t1;
        echo '<br />';
        echo 't2 = ' . $t2;
        echo '<br />';
        echo 't = ' . $t;
        echo '<br />';
        echo '<br />';
        
        
        while(($x%$y)!=0){
            $i++;
            echo '<br />';
            echo 'Schritt: ' . $i;
            echo '<div id="schritt">';
            echo 'Weil x mod y verschieden von Null ist:';
            echo '<br />';
            $g=round($x/$y);
            echo 'g = x div y = ' . $x . ' / ' . $y . ' = ' . $g;
            echo '<br />';
            $r=$x%$y;
            echo 'r = x mod y = ' . $x . ' mod ' . $y . ' = ' . $r;
            echo '<br />';
            $s=$s1-$g*$s2;
            echo 's = s1 - g * s2 = ' . $s1 . ' - ' . $g . ' * ' . $s2 . ' = ' . $s;
            echo '<br />';
            $t=$t1-$g*$t2;
            echo 't = t1 - g * t2 = ' . $t1 . ' - ' . $g . ' * ' . $t2 . ' = ' . $t;
            echo '<br />';
            $s1=$s2;
            echo 's1 = s2 = ' . $s2;
            echo '<br />';
            $s2=$s;
            echo 's2 = s = ' . $s;
            echo '<br />';
            $t1=$t2;
            echo 't1 = t2 = ' . $t2;
            echo '<br />';
            $t2=$t;
            echo 't2 = t = ' . $t;
            echo '<br />';
            $x=$y;
            echo 'x = y = ' . $y;
            echo '<br />';
            $y=$r;    
            echo 'y = r = ' . $r;
            echo '<br />';
            echo '<br />';
            echo 'x mod y = ' . $x . ' mod ' . $y . ' = ' . ($x%$y);
            echo '<br />';
            if(($x%$y)!=0){
                echo '=> weiter';
            }
            else{
                echo '=> abbrechen';
            }
            echo '</div>';   
        }
        echo '<br />';
        echo '<br />';
        
        if(abs($a)<abs($b)){
            echo 'Wenn |a| < |b|:';
            echo '<br />';
            $z=$s;
            echo 'z = s = ' . $s;
            echo '<br />';
            $s=$t;
            echo 's = t = ' . $t;
            echo '<br />';
            $t=$z;
            echo 't = z = ' . $z;
            echo '<br />';
            echo '<br />';
        }
        if(a<0){
            echo 'Wenn a < 0:';
            echo '<br />';
            $s=-$s;
            echo 's = -s = ' . -$s;
            echo '<br />';
            echo '<br />';
        }
        if(b<0){
            echo 'Wenn b < 0:';
            echo '<br />';
            $t=-$t;
            echo 't = -t = ' . -$t;
            echo '<br />';
            echo '<br />';
        }
        echo 'ggt(' . $a . ', ' . $b . ') = ' . $y;
        echo '<br />';
        
        
        
        echo 'y = sa + tb =';
        if($s+abs($s)!=0){
            echo $s . '*';
        }
        else {
            echo '(' . $s . ')*';
        }
        if($a+abs($a)!=0){
            echo $a . '+';
        }
        else {
            echo '(' . $a . ')+';
        }
        if($t+abs($t)!=0){
            echo $t . '*';
        }
        else {
            echo '(' . $t . ')*';
        }
        if($b+abs($b)!=0){
            echo $b;
        }
        else {
            echo '(' . $b . ')';
        }
        
        
        
        echo '<br />';
        echo '<br />';
        echo 'Es wurden ' . $i . ' Schritte ben&ouml;tigt!';
    }
    else{
        echo 'Bitte geben Sie eine Zahl an die verschieden von Null ist an.';
    }

echo '</div>';


include 'footer.php';
?>
</body>
</html>