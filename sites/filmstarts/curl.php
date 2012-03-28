<?php

/* gets the data from a URL */
function get_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


// $z = mktime(0, 0, 0, 12, 30, 2010);
$z = time();

//two years: 
$end = $z+86400*365*2;
//one day: 
//$end = $z+86400*200;

while($z<=$end){
    /* URL to curl */
	$week = "http://www.filmstarts.de/kritiken/vorschau/wochenkalender/?week=".date("Y-m-d", $z);
	
	$returned_content = get_data($week);
	/* weekly */
	$z+=86400*7;
	
	/* Eliminate all breaks in the curl-result. The result is an very large one-liner. */
	$without_breaks = preg_replace('/\s/', ' ', $returned_content);
	
	/* Find all occurrences of "movie title ... Kinostart:"+87 chars in the one-liner */
	preg_match_all('/\<a href\=\'\/kritiken\/.*\.html\'\>(.*)\<\/a\>\<\/h2\>.*Kinostart\:\s*(.{87})/U', $without_breaks, $matches, PREG_SET_ORDER);
	
	/* Print $matches. For testing.
	echo "<pre>";
	print_r($matches);
	echo "</pre>";
     */
	
	foreach($matches as $val){
        /* Find a valid date in the 87 chars. */
        if (preg_match('/([0-9]{2})\.([0-9]{2})\.([0-9]{4})/', $val[2], $date_match)){    		
    		$tsY = $date_match[3];
			$tsm = $date_match[2];
			$tsd = $date_match[1];
			$tsH = 20;
			$tsi = 0;
			$tss = 0;
			$title = $val[1];
		
            /* If found, put a ne event with the actual date und movie title together. */
			$e = new vevent();
			$e->setProperty( 'categories', 'FAMILY' );
			$e->setProperty( 'dtstart',  $tsY, $tsm, $tsd, $tsH, $tsi, $tss, "Europe/Berlin" );
			$e->setProperty( 'location', 'Kino' );
			$e->setProperty( 'duration', 0, 0, 3 );
			//$e->setProperty( 'description', 'blablabla' );
			$e->setProperty('SUMMARY', $title);
			$e->setProperty( "transp", "TRANSPARENT" );
			$e->setProperty( "sequence" );
			$e->setProperty( "dtstamp", $tsY, $tsm, $tsd, $tsH, $tsi, $tss );
			$v->addComponent( $e ); 
			
            /* Delete variables. */
            unset($e);
            unset($tsY);
            unset($tsm);
            unset($tsd);
            unset($tsH);
            unset($tsi);
            unset($tss);
            unset($title);  
            unset($date_match);
        }   
        unset($val);
	}
	
    /* Delete variables. */
	unset($week);
	unset($returned_content);
	unset($without_breaks);
	unset($matches);
}

unset($z);
unset($end);

?>