<?php
/**
 * rating plugin - Updates the rating in the database
 * @author Malte Müller (acrylian) and Stephen Billard (sbillard)
 * @version 1.0.1
 * @package plugins
 */
require('../../template-functions.php');
require_once('functions-rating.php');
$id = sanitize_numeric($_GET['id']);
$rating = sanitize_numeric($_GET['rating']);
$option = $_GET['option'];

	switch($option) {
		case "image":
			$dbtable =  prefix('images');
			break;
		case "album":
			$dbtable =  prefix('albums');
			break;
	}

if ($rating > 5) {
	$rating = 5;
}

$ip = sanitize($_SERVER['REMOTE_ADDR'], 0);
if(!checkForIP($ip,$id,$option)) {
	$_rating_current_IPlist[] = $ip;
	$insertip = serialize($_rating_current_IPlist);
	query("UPDATE ".$dbtable." SET total_votes = total_votes + 1, total_value = total_value + ".$rating.", used_ips='".$insertip."' WHERE id = '".$id."'");
}
?>
