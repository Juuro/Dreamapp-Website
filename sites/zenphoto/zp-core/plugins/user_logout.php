<?php
/**
 * Provides a link so that users who have logged into zenphoto can logout.
 *
 * Place a call on printUserLogout() where you want the logout link to appear.
 *
 * @author Stephen Billard (sbillard)
 * @version 1.0.0
 * @package plugins
 */

$plugin_description = gettext("Provides a means for placing a user logout link on your theme pages.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0.0';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---user_logout.php.html";

$cookiepath = WEBPATH;
if (WEBPATH == '') { $cookiepath = '/'; }

if (!OFFSET_PATH) {
	$cookies = array();
	$candidate = array();
	if (isset($_COOKIE)) $candidate = $_COOKIE;
	if (isset($_SESSION)) $candidate = Array_merge($candidate, $_SESSION);
	$candidate = array_unique($candidate);
	foreach ($candidate as $cookie=>$value) {
		if ($cookie == 'zenphoto_auth' || $cookie == 'zp_gallery_auth' || $cookie == 'zp_search_auth' || strpos($cookie, 'zp_album_auth_') !== false) {
			$cookies[] = $cookie;
		}
	}
	
	if (isset($_GET['userlog'])) { // process the logout.
		if ($_GET['userlog'] == 0) {
			foreach($cookies as $cookie) {
				zp_setcookie($cookie, "", time()-368000, $cookiepath);
			}
			$_zp_loggedin = false;
			$saved_auth = NULL;
			$cookies = array();
			$_zp_pre_authorization = array();
		}
	}
}

/**
 * Prints the logout link if the user is logged in.
 * This is for album passwords only, not admin users;
 *
 * @param string $before before text
 * @param string $after after text
 * @param bool $showLoginForm set to true to display a login form if no one is logged in
 */
function printUserLogout($before='', $after='', $showLoginForm=false) {
	global $cookies;
	if ($showLoginForm) {
		$showLoginForm = !checkforPassword(true);
	}
	if (empty($cookies)) {
		if ($showLoginForm) {
			printPasswordForm('', false);
		}
	} else {
		echo $before.'<a href="?userlog=0" title="'.gettext("logout").'" >'.gettext("logout").'</a>'.$after;
	}
}

?>