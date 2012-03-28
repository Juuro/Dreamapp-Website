<?php
session_start();
session_destroy();

include '../inc/functions.inc.php';
include '../inc/config.inc.php';

drawheader('Logout');

if ($logoutjump != '') $url = $logoutjump;
else $url = $newsoutput;

echo 'Ausgeloggt.<br /><a href="../' . $url . '">Zurück zu den News</a><br /><br />';
drawfooter($version);
?>