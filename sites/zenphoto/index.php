<?php

// force UTF-8 Ø

if (!defined('ZENFOLDER')) { define('ZENFOLDER', 'zp-core'); }

if (!file_exists(dirname(__FILE__) . '/' . ZENFOLDER . "/zp-config.php")) {
	$dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
	if (substr($dir, -1) == '/') $dir = substr($dir, 0, -1);
	$location = "http://". $_SERVER['HTTP_HOST']. $dir . "/" . ZENFOLDER . "/setup.php";
	header("Location: $location" );
}
define('OFFSET_PATH', 0);

require_once(ZENFOLDER . "/template-functions.php");
if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

$_zp_plugin_scripts = array();
$_zp_flash_player = NULL;
$_zp_HTML_cache = NULL;

header ('Content-Type: text/html; charset=' . getOption('charset'));
$obj = '';

// Display an arbitrary theme-included PHP page
// If the 'p' parameter starts with * (star) then include the file from the zp-core folder.
if (isset($_GET['p'])) {
	handleSearchParms('page', $_zp_current_album, $_zp_current_image);
	$theme = setupTheme();
	$page = str_replace(array('/','\\','.'), '', sanitize($_GET['p']));
	if (substr($page, 0, 1) == "*") {
		$_zp_gallery_page = basename($obj = ZENFOLDER."/".substr($page, 1) . ".php");
	} else {
		$obj = THEMEFOLDER."/$theme/$page.php";
		$_zp_gallery_page = basename($obj);
		if (file_exists(SERVERPATH . "/" . UTF8ToFilesystem($obj))) {
		}
	}

// Display an Image page.
} else if (in_context(ZP_IMAGE)) {
	handleSearchParms('image', $_zp_current_album, $_zp_current_image);
	$theme = setupTheme();
	$_zp_gallery_page = basename($obj = THEMEFOLDER."/$theme/image.php");
	//update hit counter
	if (!isMyALbum($_zp_current_album->name, ALL_RIGHTS)) {
		$hc = $_zp_current_image->get('hitcounter')+1;
		$_zp_current_image->set('hitcounter', $hc);
		$_zp_current_image->save();
	}
	
// Display an Album page.
} else if (in_context(ZP_ALBUM)) {
	if ($_zp_current_album->isDynamic()) {
		$search = $_zp_current_album->getSearchEngine();
		$cookiepath = WEBPATH;
		if (WEBPATH == '') { $cookiepath = '/'; }
		zp_setcookie("zenphoto_image_search_params", $search->getSearchParams(), 0, $cookiepath);
		set_context(ZP_INDEX | ZP_ALBUM);
		$theme = setupTheme();
		$_zp_gallery_page = basename($obj = THEMEFOLDER."/$theme/album.php");
	} else {
		handleSearchParms('album', $_zp_current_album);
		$theme = setupTheme();
		$_zp_gallery_page = basename($obj = THEMEFOLDER."/$theme/album.php");
	}
	// update hit counter
	if (!isMyALbum($_zp_current_album->name, ALL_RIGHTS) && getCurrentPage() == 1) {
		$hc = $_zp_current_album->get('hitcounter')+1;
		$_zp_current_album->set('hitcounter', $hc);
		$_zp_current_album->save();
	}

	// Display the Index page.
} else if (in_context(ZP_INDEX)) {
	handleSearchParms('index');
	$theme = setupTheme();
	$_zp_gallery_page = basename($obj = THEMEFOLDER."/$theme/index.php");
}

// Load plugins, then load the requested $obj (page, image, album, or index; defined above).
$_zp_loaded_plugins = array();
if (file_exists(SERVERPATH . "/" . UTF8ToFilesystem($obj)) && $zp_request) {
	foreach (getEnabledPlugins() as $extension) {
		$_zp_loaded_plugins[] = $extension;
		require_once(SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . $extension);
	}

	// Zenpage automatic hitcounter update support
	if(function_exists("is_NewsArticle") AND !$_zp_loggedin) {
		if(is_NewsArticle()) {
			$hc = $_zp_current_zenpage_news->get('hitcounter')+1;
			$_zp_current_zenpage_news->set('hitcounter', $hc);
			$_zp_current_zenpage_news->save();
		}
		if(is_NewsCategory()) {
			$catname = sanitize($_GET['category']);
			query("UPDATE ".prefix('zenpage_news_categories')." SET `hitcounter` = `hitcounter`+1 WHERE `cat_link` = '".$catname."'",true);
		}
		if(is_Pages()) {
			$hc = $_zp_current_zenpage_page->get('hitcounter')+1;
			$_zp_current_zenpage_page->set('hitcounter', $hc);
			$_zp_current_zenpage_page->save();
		}
	}

	// re-initialize video dimensions if needed
	if (isImageVideo() & !is_null($_zp_flash_player)) $_zp_current_image->updateDimensions();

	// Display the page itself
	if(!is_null($_zp_HTML_cache)) { $_zp_HTML_cache->startHTMLCache(); }
		// Include the appropriate page for the requested object, and a 200 OK header.
		header("HTTP/1.0 200 OK");
		header("Status: 200 OK");
		include($obj);

} else {
	// If the requested object does not exist, issue a 404 and redirect to the theme's
	// 404.php page, or a 404.php in the zp-core folder.

	list($album, $image) = rewrite_get_album_image('album','image');
	$_zp_gallery_page = '404.php';
	$errpage = THEMEFOLDER.'/'.UTF8ToFilesystem($theme).'/404.php';
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	if (file_exists(SERVERPATH . "/" . $errpage)) {
		include($errpage);
	} else {
		include(ZENFOLDER. '/404.php');
	}

}

exposeZenPhotoInformations( $obj, $_zp_loaded_plugins, $theme, $_zp_filters );

if(!is_null($_zp_HTML_cache)) { $_zp_HTML_cache->endHTMLCache(); }

?>
