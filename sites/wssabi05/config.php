<?php    
    $dateien = array(); // ein Leeres Array erzeugen
    $dateien['news'] = "news.php";
	$dateien['bilder'] = "bilder/index.php";
    	$dateien['gallery'] = "inc/pic_index.txt";		
		$dateien['pic_upload'] = "inc/pic_upload.php";
	
    $dateien['guest'] = "guestbuch/index.php";
	$dateien['links'] = "inc/links.inc";
	$dateien['impressum'] = "inc/impressum.inc";
	$dateien['sprueche'] = "inc/sprueche.inc";
	$dateien['gremien'] = "inc/gremien.inc";
	
	$dateien['pers_berichte'] = "inc/pers_berichte.inc";
		$dateien['upload'] = "inc/upload.inc";
		$dateien['auslese'] = "inc/auslese.inc";
    // ...
	
	define('MYSQL_HOST', 'localhost');
    define('MYSQL_USER', 'web651'); // kann ich ja schlecht für
                                    // eure MySQL wissen
    define('MYSQL_PASS', 'alumniboy'); // s.o.
    define('MYSQL_DATABASE', 'usr_web651_1');  // s.o.
?>