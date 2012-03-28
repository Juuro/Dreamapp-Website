<?php
/**
 * Filters out images/albums from the filesystem lists
 * @package plugins
 */
$plugin_description = gettext("Filter out files from albums and image searches that we do not want shown. See the plugin options for configuration.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0.0';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---filter-file_searches.php.html";
$option_interface = new filter_file_searches_options();

$mysetoptions = array();
$alloptionlist = getOptionList();
$enablealbum = false;
$enableimage = false;

foreach ($alloptionlist as $key=>$option) {
	if (($option == 1) && strpos($key, 'filter_file_searches_') === 0) {
		$mysetoptions[] = $key;
		if (strpos($key, 'filter_file_searches_albums_') === 0) {
			$enablealbum = true;
		}
		if (strpos($key, 'filter_file_searches_images_') === 0) {
			$enableimage = true;
		}
	}
}
if ($enablealbum) register_filter('album_filter', 'filterAlbums');
if ($enableimage) register_filter('image_filter', 'filterImages');

/**
 * Plugin option handling class
 *
 */
class filter_file_searches_options {

	function filter_file_searches_options() {
	}

	function getOptionsSupported() {
		global $_zp_supported_images, $_zp_extra_filetypes, $mysetoptions;
		$albums = $this->loadAlbumNames(getAlbumFolder());
		$albums = array_unique($albums);
		natsort($albums);
		$lista = array();
		foreach ($albums as $album) {
			$lista[$album] = 'filter_file_searches_albums_'.$album;
		}
		natsort($_zp_supported_images);
		$types = array_keys($_zp_extra_filetypes);
		natsort($types);
		$list = array_merge($_zp_supported_images, $types);
		$listi = array();
		foreach ($list as $suffix) {
			$listi[$suffix] = 'filter_file_searches_images_'.$suffix;
		}
		return array(	gettext('Albums') => array('key' => 'filter_file_searches_albums', 'type' => 7,
										'checkboxes' => $lista,
										'currentvalues' => $mysetoptions,
										'desc' => gettext("Check album names to be ignored.")),
		gettext('Images') => array('key' => 'filter_file_searches_images', 'type' => 7,
										'checkboxes' => $listi,
										'currentvalues' => $mysetoptions,
										'desc' => gettext('Check image suffixes to be ingnored.'))
		);
	}
	function handleOption($option, $currentValue) {
	}

	function loadAlbumNames($albumdir) {
		if (!is_dir($albumdir) || !is_readable($albumdir)) {
			return array();
		}

		$dir = opendir($albumdir);
		$albums = array();

		while ($dirname = readdir($dir)) {
			$dirname = FilesystemToUTF8($dirname);
			if ((is_dir($albumdir.$dirname) && (substr($dirname, 0, 1) != '.'))) {
				$albums[] = $dirname;
				$albums = array_merge($albums, $this->loadAlbumNames($albumdir.$dirname.'/'));
			}
		}
		closedir($dir);
		return $albums;
	}
}

/**
 * Removes unwanted albums from the list found on Disk
 *
 * @param array $album_array list of albums found
 * @return array
 */
function filterAlbums($album_array) {
	$new_list = array();
	foreach ($album_array as $album) {
		if (!getOption('filter_file_searches_albums_'.$album)) {
			$new_list[] = $album;
		}
	}
	return $new_list;
}

/**
 * Removes unwanted images from the list returned from the filesystem
 *
 * @param array $image_array the list of images found
 * @return array
 */
function filterImages($image_array) {
	$new_list = array();
	foreach ($image_array as $image) {
		if (!getOption('filter_file_searches_images_'.strtolower(substr(strrchr($image, "."), 1)))) {
			$new_list[] = $image;
		}
	}
	return $new_list;
}

?>