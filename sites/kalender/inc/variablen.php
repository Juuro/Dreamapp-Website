<?php
$a_monat = array("", "Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
	$a_wtag = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
	
	
	if(isset($_GET[monat])){
        $tag = $_GET[tag];
        $monat = $_GET[monat];
        $jahr = $_GET[jahr];        
    	$timestamp = (int)mktime(0, 0, 0, $monat, $tag, $jahr);
	}
	else {
        $timestamp = (int)time();
        $monat = (int)date("m",$timestamp);	
	}
		
	$tag = date("d",$timestamp);
	$wtag = date ("w",$timestamp);
	$mtag = date("t",$timestamp);	 
	$jahr = date("Y",$timestamp);
	$vergleichsdate = date("Ym",$timestamp);	
	
?>