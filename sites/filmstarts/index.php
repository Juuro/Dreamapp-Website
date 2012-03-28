<?php
/*
echo ini_get('memory_limit');
echo " ".memory_get_usage()."<br /> ";
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

$ts = time();

$tsY = date('Y', $ts);
$tsm = date('m', $ts);
$tsd = date('d', $ts);
$tsH = date('H', $ts);
$tsi = date('i', $ts);
$tss = date('s', $ts);


require_once 'inc/iCalcreator.class.php';


/* new vcalendar with name of the timezone, name of the calendar */
$v = new vcalendar();
$v->setProperty( "method", "PUBLISH" );
$v->setProperty( 'X-WR-TIMEZONE', 'Europe/Berlin' );
$v->setProperty( "x-wr-calname", "Filmstarts Deutschland" );
$v->setProperty( "calscale", "GREGORIAN" );
//$v->setConfig( "filename", "filmstarts_de.ics" );


/* define timezone */
$timezone = new vtimezone();
$timezone->setProperty( "Tzid", "Europe/Berlin" );

/*
$timezonedaylight = new vtimezone( "daylight" );
$timezonedaylight->setProperty( "tzoffsetfrom", "+0100" );
$timezonedaylight->setProperty('dtstart', 2006, 8, 11, 7, 30, 1);
$timezonedaylight->setProperty( "tzname", "GMT+02:00" );
$timezonedaylight->setProperty( "tzoffsetto", "+0200" );
$timezonedaylight->setProperty( "rrule", array("freq" => "YEARLY", "bymonth" => 3, "byday" => array( array(-1, "DAY" => "SU" ))) );
*/

$timezonestandard = new vtimezone( "standard" );
$timezonestandard->setProperty( "tzoffsetfrom", "+0200" );
$timezonestandard->setProperty('dtstart', 2006, 8, 11, 7, 30, 1);
$timezonestandard->setProperty( "tzname", "GMT+01:00" );
$timezonestandard->setProperty( "tzoffsetto", "+0100" );
$timezonestandard->setProperty( "rrule", array("freq" => "YEARLY", "bymonth" => 10, "byday" => array( array(-1, "DAY" => "SU" ))) );

//$timezone->addSubComponent( $timezonedaylight ); 
$timezone->addSubComponent( $timezonestandard ); 
$v->addComponent( $timezone ); 


unset($timezone);
unset($timezonestandard);


require_once 'curl.php';

			

$v->returnCalendar();




?>