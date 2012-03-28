<?php
/**
 * functions used in password hashing for zenphoto
 * 
 * @package functions
 * 
 * At least in theory one should be able to replace this script with
 * an alternate to change how Admin users are validated and stored.
 * However, this has not actually been tried yet.
 * 
 * The global $_zp_current_admin is referenced throuought Zenphoto, so the 
 * elements of the array need to be present in any alternate implementation.
 * in particular, there should be array elements for:
 * 		'id' (unique), 'user' (unique),	'password',	'name', 'email', and 'rights'
 * 
 * So long as all these indices are populated it should not matter when and where
 * the data is stored.
 */

// admin rights
define('NO_RIGHTS', 2);
define('MAIN_RIGHTS', 4);
define('VIEWALL_RIGHTS', 8);
define('UPLOAD_RIGHTS', 16);
define('COMMENT_RIGHTS', 64);
define('EDIT_RIGHTS', 256);
define('ALL_ALBUMS_RIGHTS', 512);
define('THEMES_RIGHTS', 1024);
define('ZENPAGE_RIGHTS',2048);
define('OPTIONS_RIGHTS', 8192);
define('ADMIN_RIGHTS', 65536);
define('ALL_RIGHTS', 07777777777);

/**
 * Returns the hash of the zenphoto password
 *
 * @param string $user
 * @param string $pass
 * @return string
 */
function passwordHash($user, $pass) {
	return md5($user . $pass);
}

//admin user handling
$_zp_current_admin = null;
$_zp_admin_users = null;

/**
 * Saves an admin user's settings
 *
 * @param string $user The username of the admin
 * @param string $pass The password associated with the user name (md5)
 * @param string $name The display name of the admin
 * @param string $email The email address of the admin
 * @param bit $rights The administrating rites for the admin
 * @param array $albums an array of albums that the admin can access. (If empty, access is to all albums)
 */
function saveAdmin($user, $pass, $name, $email, $rights, $albums) {

	if (DEBUG_LOGIN) { debugLog("saveAdmin($user, $pass, $name, $email, $rights, $albums)"); }

	$sql = "SELECT `name`, `id` FROM " . prefix('administrators') . " WHERE `user` = '$user'";
	$result = query_single_row($sql);
	if ($result) {
		$id = $result['id'];
		if (is_null($pass)) {
			$password = '';
		} else {
			$password = "' ,`password`='" . escape($pass);
		}
		if (is_null($rights)) {
			$rightsset = '';
		} else {
			$rightsset = "', `rights`='" . escape($rights);
		}
		$sql = "UPDATE " . prefix('administrators') . "SET `name`='" . escape($name) . $password .
 					"', `email`='" . escape($email) . $rightsset . "' WHERE `id`='" . $id ."'";
		$result = query($sql);

		if (DEBUG_LOGIN) { debugLog("updating[$id]:$result");	}

	} else {
		if (is_null($pass)) $pass = passwordHash($user, $pass);
		$sql = "INSERT INTO " . prefix('administrators') . " (user, password, name, email, rights) VALUES ('" .
		escape($user) . "','" . escape($pass) . "','" . escape($name) . "','" . escape($email) . "','" . $rights . "')";
		$result = query($sql);
		$sql = "SELECT `name`, `id` FROM " . prefix('administrators') . " WHERE `user` = '$user'";
		$result = query_single_row($sql);
		$id = $result['id'];

		if (DEBUG_LOGIN) { debugLog("inserting[$id]:$result"); }

	}
	$gallery = new Gallery();
	if (is_array($albums)) {
		$sql = "DELETE FROM ".prefix('admintoalbum')." WHERE `adminid`=$id";
		$result = query($sql);
		foreach ($albums as $albumname) {
			$album = new Album($gallery, $albumname);
			$albumid = $album->getAlbumID();
			$sql = "INSERT INTO ".prefix('admintoalbum')." (adminid, albumid) VALUES ($id, $albumid)";
			$result = query($sql);
		}
	}
}

/**
 * Returns an array of admin users, indexed by the userid
 *
 * The array contains the hashed password, user's name, email, and admin priviledges
 *
 * @return array
 */
function getAdministrators() {
	global $_zp_admin_users;
	if (is_null($_zp_admin_users)) {
		$_zp_admin_users = array();
		$sql = "SELECT `user`, `password`, `name`, `email`, `rights`, `id` FROM ".prefix('administrators')."ORDER BY `rights` DESC, `id`";
		$admins = query_full_array($sql, true);
		if ($admins !== false) {
			foreach($admins as $user) {
				if (NO_RIGHTS == 2) {
					if (($rights = $user['rights']) & 1) { // old compressed rights
						$newrights = MAIN_RIGHTS;
						if ($rights & 2) $newrights = $newrights | UPLOAD_RIGHTS;
						if ($rights & 4) $newrights = $newrights | COMMENT_RIGHTS;
						if ($rights & 8) $newrights = $newrights | EDIT_RIGHTS;
						if ($rights & 16) $newrights = $newrights | THEMES_RIGHTS;
						if ($rights & 32) $newrights = $newrights | OPTIONS_RIGHTS;
						if ($rights & 16384) $newrights = $newrights | ADMIN_RIGHTS;
						$user['rights'] = $newrights;
					}
				} else {
					if (!(($rights = $user['rights']) & 1)) { // new expanded rights
						$newrights = MAIN_RIGHTS;
						if ($rights & 16) $newrights = $newrights | UPLOAD_RIGHTS;
						if ($rights & 64) $newrights = $newrights | COMMENT_RIGHTS;
						if ($rights & 256) $newrights = $newrights | EDIT_RIGHTS;
						if ($rights & 1024) $newrights = $newrights | THEMES_RIGHTS;
						if ($rights & 8192) $newrights = $newrights | OPTIONS_RIGHTS;
						if ($rights & 65536) $newrights = $newrights | ADMIN_RIGHTS;
						$user['rights'] = $newrights;
					}
				}
				$_zp_admin_users[$user['id']] = array('user' => $user['user'], 'pass' => $user['password'],
 												'name' => $user['name'], 'email' => $user['email'], 'rights' => $user['rights'],
 												'id' => $user['id']);
			}
		}
	}
	return $_zp_admin_users;
}

/**
 * Retuns the administration rights of a saved authorization code
 *
 * @param string $authCode the md5 code to check
 *
 * @return bit
 */
function checkAuthorization($authCode) {

	if (DEBUG_LOGIN) { debugLogBacktrace("checkAuthorization($authCode)");	}

	global $_zp_current_admin;
	$admins = getAdministrators();
	if (DEBUG_LOGIN) { debugLogArray("admins",$admins);	}
	$reset_date = getOption('admin_reset_date');
	if ((count($admins) == 0) || empty($reset_date)) {
		$_zp_current_admin = null;

		if (DEBUG_LOGIN) { debugLog("no admin or reset request"); }

		return ADMIN_RIGHTS; //no admins or reset request
	}
	if (empty($authCode)) return 0; //  so we don't "match" with an empty password
	$i = 0;
	foreach($admins as $key=>$user) {

		if (DEBUG_LOGIN) { debugLog("checking: $key");	}

		if ($user['pass'] == $authCode) {
			$_zp_current_admin = $user;
			$result = $user['rights'];
			if ($i == 0) { // the first admin is the master.
				$result = $result | ADMIN_RIGHTS;
			}

			if (DEBUG_LOGIN) { debugLog("match");	}

			return $result;
		}
		$i++;
	}
	$_zp_current_admin = null;
	return 0; // no rights
}

/**
 * Checks a logon user/password against the list of admins
 *
 * Returns true if there is a match
 *
 * @param string $user
 * @param string $pass
 * @return bool
 */
function checkLogon($user, $pass) {
	$admins = getAdministrators();
	foreach ($admins as $admin) {
		if ($admin['user'] == $user) {
			$md5 = passwordHash($user, $pass);
			if ($admin['pass'] == $md5) {
				return checkAuthorization($md5);
			}
		}
	}
	return false;
}

/**
 * Returns the email addresses of the Admin with ADMIN_USERS rights
 *
 * @param bit $rights what kind of admins to retrieve
 * @return array
 */
function getAdminEmail($rights=ADMIN_RIGHTS) {
	$emails = array();
	$admins = getAdministrators();
	$user = array_shift($admins);
	if (!empty($user['email'])) {
		$emails[] = $user['email'];
	}
	foreach ($admins as $user) {
		if (($user['rights'] & $rights)  && !empty($user['email'])) {
			$emails[] = $user['email'];
		}
	}
	return $emails;
}

?>