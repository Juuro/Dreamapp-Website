<?php
/**
 * rating plugin - Updates the rating in the database
 * @author Malte Müller (acrylian) and Stephen Billard (sbillard)
 * @version 1.0.1
 * @package plugins
 */

$_rating_current_IPlist = array();
/**
* Returns true if the IP has voted
*
* @param string $ip the IP address to check
* @param int $id the record ID of the image
* @param string $option 'image' or 'album' depending on the requestor
* @return bool
*/
function checkForIp($ip, $id, $option) {
	global $_rating_current_IPlist;
	switch($option) {
		case "image":
			$dbtable = prefix('images');
			break;
		case "album":
			$dbtable = prefix('albums');
			break;
	}
	$IPlist = query_single_row("SELECT used_ips FROM $dbtable WHERE id= $id");
	if (is_array($IPlist)) {
		if (empty($IPlist['used_ips'])) {
			$_rating_current_IPlist = array();
			return false;
		}
		$_rating_current_IPlist = unserialize($IPlist['used_ips']);
		return in_array($ip, $_rating_current_IPlist);
	} else {
		$_rating_current_IPlist = array();
		return false;
	}
}

?>