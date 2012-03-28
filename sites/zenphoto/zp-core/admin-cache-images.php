<?php
/**
 * This template is used to generate cache images. Running it will process the entire gallery,
 * supplying an album name (ex: loadAlbums.php?album=newalbum) will only process the album named.
 * Passing clear=on will purge the designated cache before generating cache images
 * @package core
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-functions.php');
require_once(dirname(__FILE__).'/template-functions.php');

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

function loadAlbum($album) {
	global $gallery, $_zp_current_album, $_zp_current_image;
	$subalbums = $album->getSubAlbums();
	$count = 0;
	foreach ($subalbums as $folder) {
		$subalbum = new Album($gallery, $folder);
		$count = $count + loadAlbum($subalbum);
	}
	$_zp_current_album = $album;
	if (getNumImages() > 0) {
		echo "<br />" . $album->name . "{";
		while (next_image(true)) {
			if (isImagePhoto($_zp_current_image)) {
				echo '<img src="' . getImageThumb() . '" height="8" width="8" /> | <img src="' . getDefaultSizedImage() . '" height="20" width="20" />' . "\n";
			} else {
				echo '<img src="' . getImageThumb() . '" height="8" width="8" /> | ';
			}
				$count++;
		}
		echo "}<br/>\n";
	}
	return $count;
}

if (!($_zp_loggedin & ADMIN_RIGHTS)) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin.php");
	exit();
}

if (isset($_GET['album'])) {
	$alb = $_GET['album'];
} else if (isset($_POST['album'])) {
	$alb = urldecode($_POST['album']);
} else {
	$alb = '';
}
if ($alb) {
	$folder = sanitize_path($alb);
	$object = $folder;
	$tab = 'edit';
} else {
	$object = '<em>'.gettext('Gallery').'</em>';
	$tab = 'home';
}
printAdminHeader();
echo "\n</head>";
echo "\n<body>";

printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs($tab);
echo "\n" . '<div id="content">';

if (isset($_REQUEST['clear'])) {
	$clear = sprintf(gettext('Clearing and refreshing cache for %s'), $object);
} else {
	$clear = sprintf(gettext('Refreshing cache for %s'), $object);
}
global $_zp_gallery;
$count = 0;

$gallery = new Gallery();

if ($alb) {
	echo "\n<h2>".$clear."</h2>";
	if (isset($_REQUEST['clear'])) {
		$gallery->clearCache(SERVERCACHE . '/' . $folder); // clean out what was there
	}
	$album = new Album($gallery, $folder);
	$count = loadAlbum($album);
} else {
	echo "\n<h2>".$clear."</h2>";
	if (!empty($clear)) {
		$gallery->clearCache(); // clean out what was there.
	}
	$albums = $_zp_gallery->getAlbums();
	foreach ($albums as $folder) {
		$album = new Album($gallery, $folder);
		$count = $count + loadAlbum($album);
	}
}
echo "\n" . "<br/>".sprintf(gettext("Finished: Total of %u images."), $count);

if (isset($_REQUEST['return'])) {
	$ret = sanitize_path($_REQUEST['return']);
	if (substr($ret, 0, 1) == '*') {
		if (empty($ret) || $ret == '*.' || $ret == '*/') {
			$r = '?page=edit';
		} else {
			$r = '?page=edit&amp;album='.urlencode(substr($ret, 1)).'&amp;tab=subalbuminfo';
		}
	} else {
		$r = '?page=edit&amp;album='.urlencode($ret);
	}
} else {
	$r = '';
}
echo "<p><a href=\"admin.php$r\">&laquo; ".gettext("Back")."</a></p>"; //TODO: do we need a tab to return to?
echo "\n" . '</div>';
echo "\n" . '</div>';

printAdminFooter();

echo "\n</body>";
echo "\n</head>";
?>
