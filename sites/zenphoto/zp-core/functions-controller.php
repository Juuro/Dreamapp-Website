<?php
/**
 * functions-controller.php **************************************************
 * Common functions used in the controller for getting/setting current classes,
 * redirecting URLs, and working with the context.
 * @package core
 */

// force UTF-8 Ø



/*** Context Manipulation Functions *******/
/******************************************/

/* Contexts are simply constants that tell us what variables are available to us
 * at any given time. They should be set and unset with those variables.
 */

// Contexts (Bitwise and combinable)
define("ZP_INDEX",   1);
define("ZP_ALBUM",   2);
define("ZP_IMAGE",   4);
define("ZP_COMMENT", 8);
define("ZP_SEARCH", 16);
define("ZP_SEARCH_LINKED", 32);
define("ZP_ALBUM_LINKED", 64);
define('ZP_IMAGE_LINKED', 128);
// ZENPAGE: load zenpage class if present, used for zp_handle_comment() only
if(getOption('zp_plugin_zenpage')) {
	require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-class-news.php');
	require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-class-page.php');
	require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-template-functions.php');
}
function get_context() {
	global $_zp_current_context;
	return $_zp_current_context;
}
function set_context($context) {
	global $_zp_current_context;
	$_zp_current_context = $context;
}
function in_context($context) {
	return get_context() & $context;
}
function add_context($context) {
	set_context(get_context() | $context);
}
function rem_context($context) {
	global $_zp_current_context;
	set_context(get_context() & ~$context);
}
// Use save and restore rather than add/remove when modifying contexts.
function save_context() {
	global $_zp_current_context, $_zp_current_context_restore;
	$_zp_current_context_restore = $_zp_current_context;
}
function restore_context() {
	global $_zp_current_context, $_zp_current_context_restore;
	$_zp_current_context = $_zp_current_context_restore;
}


function im_suffix() {
	return getOption('mod_rewrite_image_suffix');
}


// Determines if this request used a query string (as opposed to mod_rewrite).
// A valid encoded URL is only allowed to have one question mark: for a query string.
function is_query_request() {
	return (strpos($_SERVER['REQUEST_URI'], '?') !== false);
}


/**
 * Returns the URL of any main page (image/album/page#/etc.) in any form
 * desired (rewrite or query-string).
 * @param $with_rewrite boolean or null, whether the returned path should be in rewrite form.
 *   Defaults to null, meaning use the mod_rewrite configuration to decide.
 * @param $album : the Album object to use in the path. Defaults to the current album (if null).
 * @param $image : the Image object to use in the path. Defaults to the current image (if null).
 * @param $page : the page number to use in the path. Defaults to the current page (if null).
 */
function zpurl($with_rewrite=NULL, $album=NULL, $image=NULL, $page=NULL, $special='') {
	global $_zp_current_album, $_zp_current_image, $_zp_page;
	// Set defaults
	if ($with_rewrite === NULL)  $with_rewrite = getOption('mod_rewrite');
	if (!$album)  $album = $_zp_current_album;
	if (!$image)  $image = $_zp_current_image;
	if (!$page)   $page  = $_zp_page;

	$url = '';
	if ($with_rewrite) {
		if (in_context(ZP_IMAGE)) {
			$encoded_suffix = implode('/', array_map('rawurlencode', explode('/', im_suffix())));
			$url = pathurlencode($album->name) . '/' . rawurlencode($image->filename) . $encoded_suffix;
		} else if (in_context(ZP_ALBUM)) {
			$url = pathurlencode($album->name) . ($page > 1 ? '/page/'.$page : '');
		} else if (in_context(ZP_INDEX)) {
			$url = ($page > 1 ? 'page/' . $page : '');
		}
	} else {
		if (in_context(ZP_IMAGE)) {
			$url = 'index.php?album=' . pathurlencode($album->name) . '&image='. rawurlencode($image->filename);
		} else if (in_context(ZP_ALBUM)) {
			$url = 'index.php?album=' . pathurlencode($album->name) . ($page > 1 ? '&page='.$page : '');
		} else if (in_context(ZP_INDEX)) {
			$url = 'index.php' . ($page > 1 ? '?page='.$page : '');
		}
	}
	if ($url == im_suffix() || empty($url)) { $url = ''; }
	if (!empty($url) && !(empty($special))) {
		if ($page > 1) {
			$url .= "&$special";
		} else {
			$url .= "?$special";
		}
	}
	return $url;
}


/**
 * Checks to see if the current URL matches the correct one, redirects to the
 * corrected URL if not with a 301 Moved Permanently.
 */
function fix_path_redirect() {
	$sfx = im_suffix();
	$request_uri = urldecode($_SERVER['REQUEST_URI']);
	$i = strpos($request_uri, '?');
	if ($i !== false) {
		$params = substr($request_uri, $i+1);
		$request_uri = substr($request_uri, 0, $i);
	} else {
		$params = '';
	}
	if (getOption('mod_rewrite') && strlen($sfx) > 0
				&& in_context(ZP_IMAGE) && substr($request_uri, -strlen($sfx)) != $sfx ) {				
		$redirecturl = zpurl(true, NULL, NULL, NULL, $params);
		header("HTTP/1.0 301 Moved Permanently");
		header('Location: ' . FULLWEBPATH . '/' . $redirecturl);
		exit();
	}
}


/******************************************************************************
 ***** Action Handling and context data loading functions *********************
 ******************************************************************************/

function zp_handle_comment() {
	global $_zp_current_image, $_zp_current_album, $_zp_comment_stored, $_zp_current_zenpage_news, $_zp_current_zenpage_page;
	$activeImage = false;
	$comment_error = 0;
	$cookie = zp_getCookie('zenphoto');
	if (isset($_POST['comment'])) {
		// ZENPAGE:  if else constructs added
		if(getOption('zp_plugin_zenpage')) {
			//zenpage_news = new ZenpageNews();
			//$zenpage_pages = new ZenpagePage();
			$zenpage_news_context = isPage(ZENPAGE_NEWS);
			$zenpage_pages_context = isPage(ZENPAGE_PAGES);
		} else {
			$zenpage_news_context = FALSE;
			$zenpage_pages_context = FALSE;
		}
		if($zenpage_news_context) {
			$redirectTo = FULLWEBPATH . '/index.php?p='.ZENPAGE_NEWS.'&title='.$_zp_current_zenpage_news->getTitlelink();
		} else if ($zenpage_pages_context) {
			$redirectTo = FULLWEBPATH . '/index.php?p='.ZENPAGE_NEWS.'&title='.$_zp_current_zenpage_page->getTitlelink();
		} else {
			$redirectTo = FULLWEBPATH . '/' . zpurl();
		}
		if ((in_context(ZP_ALBUM) || $zenpage_news_context || $zenpage_pages_context)) {
			$p_name = sanitize($_POST['name'],3);
			if (isset($_POST['email'])) {
				$p_email = sanitize($_POST['email'], 3);
			} else {
				$p_email = "";
			}
			if (isset($_POST['website'])) {
				$p_website = sanitize($_POST['website'], 3);
			} else {
				$p_website = "";
			}
			$p_comment = sanitize($_POST['comment'], 1);
			$p_server = sanitize($_SERVER['REMOTE_ADDR'], 3);
			if (isset($_POST['code'])) {
				$code1 = sanitize($_POST['code'], 3);
				$code2 = sanitize($_POST['code_h'], 3);
			} else {
				$code1 = '';
				$code2 = '';
			}
			$p_private = isset($_POST['private']);
			$p_anon = isset($_POST['anon']);

			if (isset($_POST['imageid'])) {  //used (only?) by the tricasa hack to know which image the client is working with.
				$activeImage = zp_load_image_from_id(strip_tags($_POST['imageid']));
				if ($activeImage !== false) {
					$commentadded = $activeImage->addComment($p_name, $p_email,	$p_website, $p_comment,
																							$code1, $code2,	$p_server, $p_private, $p_anon);
	 				$redirectTo = $activeImage->getImageLink();
					}
			} else {
				// ZENPAGE: if else change
				if (in_context(ZP_IMAGE) AND in_context(ZP_ALBUM)) {
					$commentobject = $_zp_current_image;
					$redirectTo = $_zp_current_image->getImageLink();
				} else if (!in_context(ZP_IMAGE) AND in_context(ZP_ALBUM)){
					$commentobject = $_zp_current_album;
					$redirectTo = $_zp_current_album->getAlbumLink();
				} else 	if($zenpage_news_context) {
					$commentobject = $_zp_current_zenpage_news;
					$redirectTo = FULLWEBPATH . '/index.php?p='.ZENPAGE_NEWS.'&title='.$_zp_current_zenpage_news->getTitlelink();
				} else if ($zenpage_pages_context) {
					$commentobject = $_zp_current_zenpage_page;
					$redirectTo = FULLWEBPATH . '/index.php?p='.ZENPAGE_NEWS.'&title='.$_zp_current_zenpage_page->getTitlelink();
				}
				$commentadded = $commentobject->addComment($p_name, $p_email, $p_website, $p_comment,
													$code1, $code2,	$p_server, $p_private, $p_anon);
			}
			if ($commentadded == 2) {
				$comment_error = 0;
				if (isset($_POST['remember'])) {
					// Should always re-cookie to update info in case it's changed...
					$info = array($p_name, $p_email, $p_website, '', false, $p_private, $p_anon);
					zp_setcookie('zenphoto', implode('|~*~|', $info), time()+COOKIE_PESISTENCE, '/');
				} else {
					zp_setcookie('zenphoto', '', time()-368000, '/');
				}
				//use $redirectTo to send users back to where they came from instead of booting them back to the gallery index. (default behaviour)
				//TODO: this does not work for IIS. How to detect IIS server and just fall through?
				// if you are running IIS, delete the next two lines
				header('Location: ' . $redirectTo);
				exit();
			} else {
				$_zp_comment_stored = array($p_name, $p_email, $p_website, $p_comment, false, $p_private, $p_anon);
				if (isset($_POST['remember'])) $_zp_comment_stored[4] = true;
				$comment_error = 1 + $commentadded;
				// ZENPAGE: if statements added
				if ($activeImage !== false AND !$zenpage_news_context AND !$zenpage_pages_context) { // tricasa hack? Set the context to the image on which the comment was posted
					$_zp_current_image = $activeImage;
					$_zp_current_album = $activeImage->getAlbum();
					set_context(ZP_IMAGE | ZP_ALBUM | ZP_INDEX);
				}
			}
		}
	} else  if (!empty($cookie)) {
		// Comment form was not submitted; get the saved info from the cookie.
		$_zp_comment_stored = explode('|~*~|', stripslashes($cookie));
		$_zp_comment_stored[4] = true;
		if (!isset($_zp_comment_stored[5])) $_zp_comment_stored[5] = false;
		if (!isset($_zp_comment_stored[6])) $_zp_comment_stored[6] = false;
	} else {
		$_zp_comment_stored = array('','','', '', false, false, false);
	}
return $comment_error;
}
/**
 *checks for album password posting
 */
function zp_handle_password() {
	global $_zp_loggedin, $_zp_login_error, $_zp_current_album;
	if (zp_loggedin()) { return; } // who cares, we don't need any authorization
	$cookiepath = WEBPATH;
	if (WEBPATH == '') { $cookiepath = '/'; }
	$check_auth = '';
	if (in_context(ZP_SEARCH)) {  // search page
		$authType = 'zp_search_auth';
		$check_auth = getOption('search_password');
		$check_user = getOption('search_user');
	} else if (in_context(ZP_ALBUM)) { // album page
		$authType = "zp_album_auth_" . cookiecode($_zp_current_album->name);
		$check_auth = $_zp_current_album->getPassword();
		$check_user = $_zp_current_album->getUser();
		if (empty($check_auth)) {
			$parent = $_zp_current_album->getParent();
			while (!is_null($parent)) {
				$check_auth = $parent->getPassword();
				$check_user = $parent->getUser();
				$authType = "zp_album_auth_" . cookiecode($parent->name);
				if (!empty($check_auth)) { break; }
				$parent = $parent->getParent();
			}
		}
	}
	if (empty($check_auth)) { // anything else is controlled by the gallery credentials
		$authType = 'zp_gallery_auth';
		$check_auth = getOption('gallery_password');
		$check_user = getOption('gallery_user');
	}
	// Handle the login form.
	if (isset($_POST['password']) && isset($_POST['pass'])) {
		$post_user = $_POST['user'];
		$post_pass = $_POST['pass'];
		$auth = md5($post_user . $post_pass);
		if ($_zp_loggedin = checkLogon($post_user, $post_pass)) {	// allow Admin user login
			zp_setcookie("zenphoto_auth", $auth, time()+COOKIE_PESISTENCE, $cookiepath);
		} else {
			if (($auth == $check_auth) && $post_user == $check_user) {
				// Correct auth info. Set the cookie.
				zp_setcookie($authType, $auth, time()+COOKIE_PESISTENCE, $cookiepath);
			} else {
				// Clear the cookie, just in case
				zp_setcookie($authType, "", time()-368000, $cookiepath);
				$_zp_login_error = true;
			}
		}
		return;
	}
	if (empty($check_auth)) { //no password on record
		return;
	}
	if (($saved_auth = zp_getCookie($authType)) != '') {
		if ($saved_auth == $check_auth) {
			return;
		} else {
			// Clear the cookie
			zp_setcookie($authType, "", time()-368000, $cookiepath);
		}
	}
}


function zp_load_page($pagenum=NULL) {
	global $_zp_page;
	if (!is_numeric($pagenum)) {
		$_zp_page = isset($_GET['page']) ? $_GET['page'] : 1;
	} else {
		$_zp_page = round($pagenum);
	}
}


/**
 * Loads the gallery if it hasn't already been loaded. This function doesn't
 * really do anything, since the gallery is always loaded in init...
 */
function zp_load_gallery() {
	global $_zp_gallery;
	if ($_zp_gallery == NULL)
	$_zp_gallery = new Gallery();
	set_context(ZP_INDEX);
	return $_zp_gallery;
}

/**
 * Loads the search object if it hasn't already been loaded.
 */
function zp_load_search() {
	global $_zp_current_search;
	if ($_zp_current_search == NULL)
		$_zp_current_search = new SearchEngine();
	set_context(ZP_INDEX | ZP_SEARCH);
	$cookiepath = WEBPATH;
	if (WEBPATH == '') { $cookiepath = '/'; }
	$params = $_zp_current_search->getSearchParams();
	zp_setcookie("zenphoto_image_search_params", $params, 0, $cookiepath);
	return $_zp_current_search;
}

/**
 * zp_load_album - loads the album given by the folder name $folder into the
 * global context, and sets the context appropriately.
 * @param $folder the folder name of the album to load. Ex: 'testalbum', 'test/subalbum', etc.
 * @param $force_cache whether to force the use of the global object cache.
 * @return the loaded album object on success, or (===false) on failure.
 */
function zp_load_album($folder, $force_nocache=false) {
	global $_zp_current_album, $_zp_gallery, $_zp_dynamic_album;
	$_zp_current_album = new Album($_zp_gallery, $folder, !$force_nocache);
	if (!$_zp_current_album->exists) return false;
	if ($_zp_current_album->isDynamic()) {
		$_zp_dynamic_album = $_zp_current_album;
	} else {
		$_zp_dynamic_album = null;
	}
	set_context(ZP_ALBUM | ZP_INDEX);
	return $_zp_current_album;
}

/**
 * zp_load_image - loads the image given by the $folder and $filename into the
 * global context, and sets the context appropriately.
 * @param $folder is the folder name of the album this image is in. Ex: 'testalbum'
 * @param $filename is the filename of the image to load.
 * @return the loaded album object on success, or (===false) on failure.
 */
function zp_load_image($folder, $filename) {
	global $_zp_current_image, $_zp_current_album, $_zp_current_search;
	if ($_zp_current_album == NULL || $_zp_current_album->name != $folder) {
		$album = zp_load_album($folder);
	} else {
		$album = $_zp_current_album;
	}
	if (!$_zp_current_album->exists) return false;
	$_zp_current_image = newImage($album, $filename);
	if (!$_zp_current_image->exists) return false;
	set_context(ZP_IMAGE | ZP_ALBUM | ZP_INDEX);
	return $_zp_current_image;
}

/**
 * zp_load_image_from_id - loads and returns the image "id" from the database, without
 * altering the global context or zp_current_image.
 * @param $id the database id-field of the image.
 * @return the loaded image object on success, or (===false) on failure.
 */
function zp_load_image_from_id($id){
	$sql = "SELECT `albumid`, `filename` FROM " .prefix('images') ." WHERE `id` = " . $id;
	$result = query_single_row($sql);
	$filename = $result['filename'];
	$albumid = $result['albumid'];

	$sql = "SELECT `folder` FROM ". prefix('albums') ." WHERE `id` = " . $albumid;
	$result = query_single_row($sql);
	$folder = $result['folder'];

	$album = zp_load_album($folder);
	$currentImage = newImage($album, $filename);
	if (!$currentImage->exists) return false;
	return $currentImage;
}


function zp_load_request() {
	list($album, $image) = rewrite_get_album_image('album','image');
	zp_load_page();
	$success = true;
	if (!empty($image)) {
		$success = zp_load_image($album, $image);
	} else if (!empty($album)) {
		$success = zp_load_album($album);
	}
	if (isset($_GET['p'])) {
		$page = str_replace(array('/','\\','.'), '', $_GET['p']);
		if ($page == "search") {
			$success = zp_load_search();
		}
	}
	return $success;
}

?>