<?php

/*
Das folgende Script entpackt ein ZIP File.
unzip muß installiert sein
safe_mode = off bzw. Zugriff auf das zip binary (meist /usr/bin/unzip)
*/

$path = './test';
$zip = '/usr/bin/unzip';
$archiv = '123.zip';
$dest = '../'.$archiv;

$cmd = sprintf('%s %s',$zip, $dest);

printf ('<h4>Shell: %s</h4>', $cmd);
chdir  ($path);


print ('<p>Anzeige der ausgepackten Dateien:</p>');
print (nl2br(shell_exec($cmd)));

shell_exec('/bin/chmod -R 0777 *');
chdir('../');



function dirlist($DIR = FALSE)
{
    $r = array();
    if ( ! $DIR OR ! is_dir($DIR))
        return $r; # $r ist hier noch leer

    if (substr($DIR,-1) != "/") $DIR .= "/";
    if (! is_readable($DIR))
        return $r; # $r ist hier noch leer

    if (false !== ($d = dir($DIR)))
    {
        while (false !== ($n = $d->read()))
        {
            if ($n == "." OR $n == "..") continue;
            if (is_file($DIR . $n)) $r[] = $DIR . $n;
            if (is_dir($DIR . $n))     $r = array_merge($r, dirlist($DIR . $n));
        }
        $d->close();
    }
    return $r;
}

$liste = dirlist($path);

print ('<p>folgende Files sind in diesem Ordner vorhanden:</p>');

print ('<pre>');
print_r ($liste);
print ('</pre>');

?> 