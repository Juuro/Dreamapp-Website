<?php
/**
 * basic functions used by zenphoto
 * Headers not sent yet!
 * @package functions
 *
 */

// force UTF-8 Ø

require_once(dirname(__FILE__).'/functions-basic.php');
require_once(dirname(__FILE__).'/functions-auth.php');
require_once(dirname(__FILE__).'/functions-filter.php');

if(!function_exists("gettext")) {
	// load the drop-in replacement library
	require_once(dirname(__FILE__).'/lib-gettext/gettext.inc');
}

if (getOption('album_session') && OFFSET_PATH==0) {
	session_start();
}

$_zp_captcha = getOption('captcha');
if (empty($_zp_captcha)) 	$_zp_captcha = 'zenphoto';
require_once(dirname(__FILE__). PLUGIN_FOLDER . 'captcha/'.$_zp_captcha.'.php');
$_zp_captcha = new Captcha();

require_once(dirname(__FILE__).'/functions-i18n.php');

$_zp_setupCurrentLocale_result = setMainDomain();

/**
 * parses the allowed HTML tags for use by htmLawed
 *
 *@param string &$source by name, contains the string with the tag options
 *@return array the allowed_tags array.
 *@since 1.1.3
 **/
function parseAllowedTags(&$source) {
	$source = trim($source);
	if (substr($source, 0, 1) != "(") { return false; }
	$source = substr($source, 1); //strip off the open paren
	$a = array();
	while ((strlen($source) > 1) && (substr($source, 0, 1) != ")")) {
		$i = strpos($source, '=>');
		if ($i === false) { return false; }
		$tag = trim(substr($source, 0, $i));
		$source = trim(substr($source, $i+2));
		if (substr($source, 0, 1) != "(") { return false; }
		$x = parseAllowedTags($source);
		if ($x === false) { return false; }
		$a[$tag] = $x;
	}
	if (substr($source, 0, 1) != ')') { return false; }
	$source = trim(substr($source, 1)); //strip the close paren
	return $a;
}

	// Note: The database setup/upgrade uses this list, so if fields are added or deleted, setup.php should be
	//   run or the new data won't be stored (but existing fields will still work; nothing breaks).
	$_zp_exifvars = array(
		// Database Field       => array('IFDX', 	 'ExifKey',          'ZP Display Text',        				 	 Display?)
		'EXIFOrientation'       => array('IFD0',   'Orientation',       gettext('Orientation'),            false),
		'EXIFMake'              => array('IFD0',   'Make',              gettext('Camera Maker'),           true),
		'EXIFModel'             => array('IFD0',   'Model',             gettext('Camera Model'),           true),
		'EXIFExposureTime'      => array('SubIFD', 'ExposureTime',      gettext('Shutter Speed'),          true),
		'EXIFFNumber'           => array('SubIFD', 'FNumber',           gettext('Aperture'),               true),
		'EXIFFocalLength'       => array('SubIFD', 'FocalLength',       gettext('Focal Length'),           true),
		'EXIFFocalLength35mm'   => array('SubIFD', 'FocalLength35mmEquiv', gettext('35mm Equivalent Focal Length'), false),
		'EXIFISOSpeedRatings'   => array('SubIFD', 'ISOSpeedRatings',   gettext('ISO Sensitivity'),        true),
		'EXIFDateTimeOriginal'  => array('SubIFD', 'DateTimeOriginal',  gettext('Time Taken'),             true),
		'EXIFExposureBiasValue' => array('SubIFD', 'ExposureBiasValue', gettext('Exposure Compensation'),  true),
		'EXIFMeteringMode'      => array('SubIFD', 'MeteringMode',      gettext('Metering Mode'),          true),
		'EXIFFlash'             => array('SubIFD', 'Flash',             gettext('Flash Fired'),            true),
		'EXIFImageWidth'        => array('SubIFD', 'ExifImageWidth',    gettext('Original Width'),         false),
		'EXIFImageHeight'       => array('SubIFD', 'ExifImageHeight',   gettext('Original Height'),        false),
		'EXIFContrast'          => array('SubIFD', 'Contrast',          gettext('Contrast Setting'),       false),
		'EXIFSharpness'         => array('SubIFD', 'Sharpness',         gettext('Sharpness Setting'),      false),
		'EXIFSaturation'        => array('SubIFD', 'Saturation',        gettext('Saturation Setting'),     false),
		'EXIFWhiteBalance'			=> array('SubIFD', 'WhiteBalance',			gettext('White Balance'),					 false),
		'EXIFSubjectDistance'		=> array('SubIFD', 'SubjectDistance',		gettext('Subject Distance'),			 false),
		'EXIFGPSLatitude'       => array('GPS',    'Latitude',          gettext('Latitude'),               false),
		'EXIFGPSLatitudeRef'    => array('GPS',    'Latitude Reference',gettext('Latitude Reference'),     false),
		'EXIFGPSLongitude'      => array('GPS',    'Longitude',         gettext('Longitude'),              false),
		'EXIFGPSLongitudeRef'   => array('GPS',    'Longitude Reference',gettext('Longitude Reference'),   false),
		'EXIFGPSAltitude'       => array('GPS',    'Altitude',          gettext('Altitude'),               false),
		'EXIFGPSAltitudeRef'    => array('GPS',    'Altitude Reference',gettext('Altitude Reference'),     false)
		);

/**
 * initializes the $_zp_exifvars array display state
 *
 */
function setexifvars() {
	global $_zp_exifvars;
	foreach ($_zp_exifvars as $key=>$item) {
		$_zp_exifvars[$key][3] = getOption($key);
	}
}

$_zp_supported_images = array('jpg','jpeg','gif','png');
// Image utility functions
/**
 * Returns true if the file is an image
 *
 * @param string $filename the name of the target
 * @return bool
 */
function is_valid_image($filename) {
	global $_zp_supported_images;
	$ext = strtolower(substr(strrchr($filename, "."), 1));
	return in_array($ext, $_zp_supported_images);
}

//ZenVideo: Video utility functions

/**
 * Check if the image is a video thumb
 *
 * @param string $album folder path for the album
 * @param string $filename name of the target
 * @return bool
 *
 * Note: this function is inefficient and slows down the image file loop a lot.
 * Don't use it in a loop!
 */
function is_objectsThumb($album, $filename){
	global $_zp_extra_filetypes;
	$types = array_keys($_zp_extra_filetypes);
	$ext = strtolower(substr($fext = strrchr($filename, "."), 1));
	if (in_array($ext, $types)) {
		return str_replace($fext, '', $filename);
	}
	return false;
}

/**
 * Search for a thumbnail for the image
 *
 * @param string $album folder path of the album
 * @param string $video name of the target
 * @return string
 */
function checkObjectsThumb($album, $video){
	global $_zp_supported_images;
	$video = is_objectsThumb($album, $video);
	if($video) {
		foreach($_zp_supported_images as $ext) {
			if(file_exists(UTF8ToFilesystem($album."/".$video.'.'.$ext))) {
				return $video.'.'.$ext;
			}
		}
	}
	return NULL;
}

/**
 * Search for a high quality version of the video
 *
 * @param string $album folder path of the album
 * @param string $video name of the target
 * @return string
 */
function checkVideoOriginal($album, $video){
	$video = is_objectsThumb($album, $video);
	if ($video) {
		$extTab = array(".ogg",".OGG",".avi",".AVI",".wmv",".WMV");
		foreach($extTab as $ext) {
			if(file_exists(UTF8ToFilesystem($album."/".$video.$ext))) {
				return $video.$ext;
			}
		}
	}
	return NULL;
}

/**
 * Returns a truncated string
 *
 * @param string $string souirce string
 * @param int $length how long it should be
 * @param string $elipsis the text to tack on indicating shortening
 * @return string
 */
function truncate_string($string, $length, $elipsis='...') {
	if (strlen($string) > $length) {
		$pos = strpos($string, ' ', $length);
		if ($pos === FALSE) return substr($string, 0, $length) . $elipsis;
		return substr($string, 0, $pos) . $elipsis;
	}
	return $string;
}

/**
 * Returns the oldest ancestor of an alubm;
 *
 * @param string $album an album object
 * @return object
 */
function getUrAlbum($album) {
	if (!is_object($album)) return NULL;
	while (true) {
		$parent = $album->getParent();
		if (is_null($parent)) { return $album; }
		$album = $parent;
	}
}

/**
 * Returns a sort field part for querying
 * Note: $sorttype may be a comma separated list of field names. If so, 
 *       these are peckmarked and returned otherwise unchanged. 
 *
 * @param string $sorttype the 'Display" name of the sort
 * @param string $default the default if $sorttype is empty
 * @param string $filename the value to be used if $sorttype is 'Filename' since 
 * 												 the field is different between the album table and the image table.
 * @return string
 */
function lookupSortKey($sorttype, $default, $filename) {
	$sorttype = strtolower($sorttype);
	switch ($sorttype) {
		case "manual":
			return '`sort_order`';
		case "filename":
			return '`'.$filename.'`';
		default:
			if (empty($sorttype)) return $default;
			$list = explode(',', $sorttype);
			foreach ($list as $key=>$field) {
				$list[$key] = '`'.trim($field).'`';
			}
			return implode(',', $list);
	}
}

/**
 * Returns the DB sort key for an album sort type
 *
 * @param string $sorttype The sort type option
 * @return string
 */
function albumSortKey($sorttype) {
	return lookupSortKey($sorttype, 'filename', 'filename');
}
/**
 * Returns the DB key associated with the subalbum sort type
 *
 * @param string $sorttype subalbum sort type
 * @return string
 */
function subalbumSortKey($sorttype) {
	return lookupSortKey($sorttype, 'sort_order', 'folder');
}

/**
 * Returns a formated date for output
 *
 * @param string $format the "strftime" format string
 * @param date $dt the date to be output
 * @return string
 */
function zpFormattedDate($format, $dt) {
	global $_zp_UTF8;
	$fdate = strftime($format, $dt);
	$charset = 'ISO-8859-1';
	if (function_exists('mb_internal_encoding')) {
		if (($charset = mb_internal_encoding()) == 'UTF-8') {
			return $fdate;
		}
	}
	return $_zp_UTF8->convert($fdate, $charset);
}

/**
 * Simple mySQL timestamp formatting function.
 *
 * @param string $format formatting template
 * @param int $mytimestamp timestamp
 * @return string
 */
function myts_date($format,$mytimestamp)
{
	// If your server is in a different time zone than you, set this.
	$timezoneadjust = getOption('time_offset');

	$month  = substr($mytimestamp,4,2);
	$day    = substr($mytimestamp,6,2);
	$year   = substr($mytimestamp,0,4);

	$hour   = substr($mytimestamp,8,2);
	$min    = substr($mytimestamp,10,2);
	$sec    = substr($mytimestamp,12,2);

	$epoch  = mktime($hour+$timezoneadjust,$min,$sec,$month,$day,$year);
	$date   = zpFormattedDate($format, $epoch);
	return $date;
}

/**
 * Get the size of a directory.
 * From: http://aidan.dotgeek.org/lib/
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.0
 * @param       string $directory   Path to directory
 */
function dirsize($directory)
{
	$size = 0;
	if (substr($directory, -1, 1) !== DIRECTORY_SEPARATOR) {
		$directory .= DIRECTORY_SEPARATOR;
	}
	$stack = array($directory);
	for ($i = 0, $j = count($stack); $i < $j; ++$i) {
		if (is_file($stack[$i])) {
			$size += filesize($stack[$i]);
		} else if (is_dir($stack[$i])) {
			$dir = dir($stack[$i]);
			while (false !== ($entry = $dir->read())) {
				if ($entry == '.' || $entry == '..') continue;
				$add = $stack[$i] . $entry;
				if (is_dir($stack[$i] . $entry)) $add .= DIRECTORY_SEPARATOR;
				$stack[] = $add;
			}
			$dir->close();
		}
		$j = count($stack);
	}
	return $size;
}

// Text formatting and checking functions

/**
 * Determines if the input is an e-mail address. Adapted from WordPress.
 * Name changed to avoid conflicts in WP integrations.
 *
 * @param string $input_email email address?
 * @return bool
 */
function is_valid_email_zp($input_email) {
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	if(strstr($input_email, '@') && strstr($input_email, '.')) {
		if (preg_match($chars, $input_email)) {
			return true;
		}
	}
	return false;
}


/**
 * Send an mail to the admin user(s). We also attempt to intercept any form injection
 * attacks by slime ball spammers.
 *
 * @param string $subject  The subject of the email.
 * @param string $message  The message contents of the email.
 * @param string $headers  Optional headers for the email.
 * @param array $admin_emails a list of email addresses
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function zp_mail($subject, $message, $headers = '', $admin_emails=null) {
	global $_zp_UTF8;
	if (is_null($admin_emails)) { $admin_emails = getAdminEmail(); }
	if (count($admin_emails) > 0) {
		// Make sure no one is trying to use our forms to send Spam
		// Stolen from Hosting Place:
		//   http://support.hostingplace.co.uk/knowledgebase.php?action=displayarticle&cat=0000000039&id=0000000040
		$badStrings = array("Content-Type:", "MIME-Version:",	"Content-Transfer-Encoding:",	"bcc:",	"cc:");
		foreach($_POST as $k => $v) {
			foreach($badStrings as $v2) {
				if (strpos($v, $v2) !== false) {
					header("HTTP/1.0 403 Forbidden");
					die("Forbidden");
					exit();
				}
			}
		}

		foreach($_GET as $k => $v){
			foreach($badStrings as $v2){
				if (strpos($v, $v2) !== false){
					header("HTTP/1.0 403 Forbidden");
					die("Forbidden");
					exit();
				}
			}
		}

		if( $headers == '' ) {
			$headers = "From: " . get_language_string(getOption('gallery_title'), getOption('locale')) . "<zenphoto@" . $_SERVER['SERVER_NAME'] . ">";
		}

		// Convert to UTF-8
		if (getOption('charset') != 'UTF-8') {
			$subject = $_zp_UTF8->convert($subject, getOption('charset'));
			$message = $_zp_UTF8->convert($message, getOption('charset'));
		}

		// Send the mail
		foreach ($admin_emails as $email) {
			$_zp_UTF8->send_mail($email, $subject, $message, $headers);
		}
	}
}

/**
 * Sorts the results of a DB search by the current locale string for $field
 *
 * @param array $dbresult the result of the DB query
 * @param string $field the field name to sort on
 * @param bool $descending the direction of the sort
 * @return array the sorted result
 */
function sortByMultilingual($dbresult, $field, $descending) {
	$temp = array();
	foreach ($dbresult as $row) {
		$temp[] = get_language_string($row[$field]);
	}
	natcasesort($temp);
	$result = array();
	foreach ($temp as $key=>$title) {
		if ($descending) {
			array_unshift($result, $dbresult[$key]);
		} else {
			$result[] = $dbresult[$key];
		}
	}
	return $result;
}

/**
 * Sort the album array based on either according to the sort key.
 * Default is to sort on the `sort_order` field.
 *
 * Returns an array with the albums in the desired sort order
 *
 * @param  array $albums array of album names
 * @param  string $sortkey the sorting scheme
 * @return array
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function sortAlbumArray($parentalbum, $albums, $sortkey='`sort_order`') {
	global $_zp_gallery;
	if (count($albums) == 0) return array();
	if (is_null($parentalbum)) {
		$albumid = ' IS NULL';
	} else {
		$albumid = '="'.$parentalbum->id.'"';
	}
	$sql = 'SELECT `folder`, `sort_order`, `title`, `show`, `dynamic`, `search_params` FROM ' .
						prefix("albums") . ' WHERE `parentid`'.$albumid.' ORDER BY ' . $sortkey;
	$loop = 0;	
	do {
		$result = query($sql);
		$hidden = array();
		$results = array();
		while ($row = mysql_fetch_assoc($result)) {
			$results[] = $row;
		}
		if (strpos($sortkey,'title') !== false) {
			$results = sortByMultilingual($results, 'title', strpos($sortkey,'DESC') !== false);
		} else if (strpos($sortkey, 'folder') !== false) {
			if (strpos($sortkey,'DESC') !== false) $order = 'dsc'; else $order = 'asc';
			$results = sortMultiArray($results, 'folder', $order, true, false);
		}
		$i = 0;
		$albums_r = array_flip($albums);
		$albums_touched = array();
		foreach ($results as $row) {
			$folder = $row['folder'];
			$mine = isMyALbum($folder, ALL_RIGHTS);
			if (array_key_exists($folder, $albums_r)) {
				$albums_r[$folder] = $i;
				$albums_touched[] = $folder;
				if (!($row['show'] || $mine)) {  // you can see only your own unpublished content.
					$hidden[] = $folder;
				}
			}
			$i++;
		}
		$albums_untouched = array_diff($albums, $albums_touched);
		if (count($albums_untouched) > 0) { //found new albums
			$loop ++;
			foreach($albums_untouched as $alb) {
				$albobj = new Album($_zp_gallery, $alb); // force load to DB
				$albums_r[$alb] = -$i;  // place them in the front of the list
				$i++;
			}
		} else {
			$loop = 0;
		}
	} while ($loop==1);
	
	foreach($hidden as $alb) {
		unset($albums_r[$alb]);
	}

	$albums = array_flip($albums_r);
	ksort($albums);

	$albums_ordered = array();
	foreach($albums as $album) {
		$albums_ordered[] = $album;
	}

	return $albums_ordered;
}

/**
 * Checks to see access is allowed to an album
 * Returns true if access is allowed.
 * There is no password dialog--you must have already had authorization via a cookie.
 *
 * @param string $albumname the album
 * @param string &$hint becomes populated with the password hint.
 * @return bool
 */
function checkAlbumPassword($albumname, &$hint) {
	global $_zp_pre_authorization, $_zp_loggedin;
	if (zp_loggedin(ADMIN_RIGHTS | VIEWALL_RIGHTS | ALL_ALBUMS_RIGHTS)) { return true; }
	if ($_zp_loggedin) {
		if (isMyAlbum($albumname, ALL_RIGHTS)) { return true; }  // he is allowed to see it.
	}
	if (isset($_zp_pre_authorization[$albumname])) {
		return true;
	}
	$album = new album($_zp_gallery, $albumname);
	$hash = $album->getPassword();
	if (empty($hash)) {
		$album = $album->getParent();
		while (!is_null($album)) {
			$hash = $album->getPassword();
			$authType = "zp_album_auth_" . cookiecode($album->name);
			$saved_auth = zp_getCookie($authType);

			if (!empty($hash)) {
				if ($saved_auth != $hash) {
					$hint = $album->getPasswordHint();
					return false;
				}
			}
			$album = $album->getParent();
		}
		// revert all tlhe way to the gallery
		$hash = getOption('gallery_password');
		$authType = 'zp_gallery_auth';
		$saved_auth = zp_getCookie($authType);
		if (!empty($hash)) {
			if ($saved_auth != $hash) {
				$hint = get_language_string(getOption('gallery_hint'));
				return false;
			}
		}
	} else {
		$authType = "zp_album_auth_" . cookiecode($album->name);
		$saved_auth = zp_getCookie($authType);
		if ($saved_auth != $hash) {
			$hint = $album->getPasswordHint();
			return false;
		}
	}
	$_zp_pre_authorization[$albumname] = true;
	return true;
}

/**
 * Processes a file for createAlbumZip
 *
 * @param string $dest the source [sic] to process
 */
function printLargeFileContents($dest) {
	$total = filesize($dest);
	$blocksize = (2 << 20); //2M chunks
	$sent = 0;
	$handle	= fopen($dest, "r");
	while ($sent < $total) {
		echo fread($handle, $blocksize);
		$sent += $blocksize;
	}
}

/**
 * Returns the fully qualified "require" file name of the plugin file.
 *
 * @param  string $plugin is the name of the plugin file, typically something.php
 * @param  bool $inTheme tells where to find the plugin.
 *   true means look in the current theme
 *   false means look in the zp-core/plugins folder.
 *
 * @return string
 */
function getPlugin($plugin, $inTheme) {
	global $_zp_themeroot;
	$_zp_themeroot = WEBPATH . '/' . THEMEFOLDER . '/'. $inTheme;
	if ($inTheme) {
		$pluginFile = SERVERPATH . '/' . THEMEFOLDER . '/'. UTF8ToFilesystem($inTheme . '/' . $plugin);
	} else {
		$pluginFile = SERVERPATH . '/' . ZENFOLDER . PLUGIN_FOLDER . UTF8ToFilesystem($plugin);
	}
	if (file_exists($pluginFile)) {
		return $pluginFile;
	} else {
		return false;
	}
}

/**
 * Returns an array of the currently enabled plugins
 *
 * @return array
 */
function getEnabledPlugins() {
	$pluginlist = array();
	$curdir = getcwd();
	chdir(SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER);
	$filelist = safe_glob('*'.'php');
	chdir($curdir);
	foreach ($filelist as $extension) {
		$extension = FilesystemToUTF8($extension);
		$opt = 'zp_plugin_'.substr($extension, 0, strlen($extension)-4);
		if (getOption($opt)) {
			$pluginlist[] = $extension;
		}
	}
	return $pluginlist;
}

/**
 * Provides an error protected read of image EXIF/IPTC data
 * (requires PHP version 5 to protect the read)
 *
 * @param string $path image path
 * @return array
 */
function read_exif_data_protected($path) {
	if (version_compare(PHP_VERSION, '5.0.0') === 1) {
		eval('
		try {
			$rslt = read_exif_data_raw($path, false);
		} catch (Exception $e) {
			$rslt = array();
		}');
		return $rslt;
	} else {
		return read_exif_data_raw($path, false);
	}
}

/**
 * For internal use--fetches a single tag from IPTC data
 *
 * @param string $tag the metadata tag sought
 * @return string
 */
function getIPTCTag($tag) {
	global $iptc;
	if (isset($iptc[$tag])) {
		$iptcTag = $iptc[$tag];
		$r = "";
		$ct = count($iptcTag);
		for ($i=0; $i<$ct; $i++) {
			$w = $iptcTag[$i];
			if (!empty($r)) { $r .= ", "; }
			$r .= $w;
		}
		return $r;
	}
	return '';
}

/**
 * For internal use--fetches the IPTC array for a single tag.
 *
 * @param string $tag the metadata tag sought
 * @return array
 */
function getIPTCTagArray($tag) {
	global $iptc;
	if (array_key_exists($tag, $iptc)) {
		return $iptc[$tag];
	}
	return NULL;
}

/**
 * Returns the IPTC data converted into UTF8
 *
 * @param string $iptcstring the IPTC data
 * @param string $characterset the internal encoding of the data
 * @return string
 */
function prepIPTCString($iptcstring, $characterset) {
	global $_zp_UTF8;
	if ($characterset == 'UTF-8') return $iptcstring;
	$iptcstring = $_zp_UTF8->convert($iptcstring, $characterset);
	// Remove null byte at the end of the string if it exists.
	if (substr($iptcstring, -1) === 0x0) {
		$iptcstring = substr($iptcstring, 0, -1);
	}
	return $iptcstring;
}

/**
 * Parces IPTC data and returns those tags zenphoto is interested in
 * folds multiple tags into single zp data items based on precedence.
 *
 * @param string $imageName the name of the image
 * @return array
 */
function getImageMetadata($imageName) {
	require_once(dirname(__FILE__).'/exif/exif.php');
	global $iptc;

	$result = array();
	getimagesize($imageName, $imageInfo);
	if (is_array($imageInfo)) {
		$exifraw = read_exif_data_protected($imageName);
		if (isset($exifraw['SubIFD'])) {
			$subIFD = $exifraw['SubIFD'];
		} else {
			$subIFD = array();
		}
		
		/* EXIF date */
		if (isset($subIFD['DateTime'])) {
			$date = $subIFD['DateTime'];
		} else {
			$date = '';
		}
		if (empty($date) && isset($subIFD['DateTimeOriginal'])) {
			$date = $subIFD['DateTimeOriginal'];
		}
		if (empty($date)  && isset($subIFD['DateTimeDigitized'])) {
			$date = $subIFD['DateTimeDigitized'];
		}
		if (!empty($date)) {
			$result['date'] = $date;
		}

		/* check IPTC data */
		if (isset($imageInfo["APP13"])) {
			$iptc = iptcparse($imageInfo["APP13"]);
			if ($iptc) {
				$characterset = getIPTCTag('1#090');
				if (!$characterset) {
					$characterset = getOption('IPTC_encoding');
				} else if (substr($characterset, 0, 1) == chr(27)) { // IPTC escape encoding
					$characterset = substr($characterset, 1);
					if ($characterset == '%G') {
						$characterset = 'UTF-8';
					} else { // we don't know, need to understand the IPTC standard here. In the mean time, default it.
						$characterset = getOption('IPTC_encoding');
					}
				} else if ($characterset == 'UTF8') {
					$characterset = 'UTF-8';
				}
				/* iptc date */
				$date = getIPTCTag('2#055');
				if (!empty($date)) {
					$result['date'] = substr($date, 0, 4).'-'.substr($date, 4, 2).'-'.substr($date, 6, 2);
				}
				/* iptc title */
				$title = getIPTCTag('2#005');   /* Option Name */
				if (empty($title)) {
					$title = getIPTCTag('2#105'); /* Headline */
				}
				if (!empty($title)) {
					$result['title'] = prepIPTCString($title, $characterset);
				}

				/* iptc description */
				$caption= getIPTCTag('2#120');
				if (!empty($caption)) {
					$result['desc'] = prepIPTCString($caption, $characterset);
				}

				/* iptc location, state, country */
				$location = getIPTCTag('2#092');
				if (!empty($location)) {
					$result['location'] = prepIPTCString($location, $characterset);
				}
				$city = getIPTCTag('2#090');
				if (!empty($city)) {
					$result['city'] = prepIPTCString($city, $characterset);
				}
				$state = getIPTCTag('2#095');
				if (!empty($state)) {
					$result['state'] = prepIPTCString($state, $characterset);
				}
				$country = getIPTCTag('2#101');
				if (!empty($country)) {
					$result['country'] = prepIPTCString($country, $characterset);
				}
				/* iptc credit */
				$credit= getIPTCTag('2#080'); /* by-line */
				if (empty($credit)) {
					$credit = getIPTCTag('2#110'); /* credit */
				}
				if (empty($credit)) {
					$credit = getIPTCTag('2#115'); /* source */
				}
				if (!empty($credit)) {
					$result['credit'] = prepIPTCString($credit, $characterset);
				}

				/* iptc copyright */
				$copyright= getIPTCTag('2#116');
				if (!empty($copyright)) {
					$result['copyright'] = prepIPTCString($copyright, $characterset);
				}

				/* iptc keywords (tags) */
				$keywords = getIPTCTagArray('2#025');
				if (is_array($keywords)) {
					$taglist = array();
					foreach($keywords as $keyword) {
						$taglist[] = prepIPTCString($keyword, $characterset);
					}
					$result['tags'] = $taglist;
				}
			}
		}
	}
	return $result;
}

/**
 * Returns an array of $type, $class of the object passed
 *
 * @param object $receiver The object whose class we desire
 * @return array
 */
function commentObjectClass($receiver) {
	$class = strtolower(get_class($receiver));
	switch($class) {
		case "zenpagenews":
			$type = "news";
			break;
		case "zenpagepage":
			$type = "pages";
			break;
		default:
			$type = $class.'s'; // Historically we have stored "images" or "albums" as the type
			break;
	}
	return array($type, $class);
}

/**
 * Generic comment adding routine. Called by album objects or image objects
 * to add comments.
 *
 * Returns a code for the success of the comment add:
 *    0: Bad entry
 *    1: Marked for moderation
 *    2: Successfully posted
 *
 * @param string $name Comment author name
 * @param string $email Comment author email
 * @param string $website Comment author website
 * @param string $comment body of the comment
 * @param string $code Captcha code entered
 * @param string $code_ok Captcha md5 expected
 * @param string $type 'albums' if it is an album or 'images' if it is an image comment
 * @param object $receiver the object (image or album) to which to post the comment
 * @param string $ip the IP address of the comment poster
 * @param bool $private set to true if the comment is for the admin only
 * @param bool $anon set to true if the poster wishes to remain anonymous
 * @return int
 */
function postComment($name, $email, $website, $comment, $code, $code_ok, $receiver, $ip, $private, $anon) {
	global $_zp_captcha;
	$result = commentObjectClass($receiver);
	list($type, $class) = $result;
	$receiver->getComments();
	$name = trim($name);
	$email = trim($email);
	$website = trim($website);
	$admins = getAdministrators();
	$admin = array_shift($admins);
	$key = $admin['pass'];
	// Let the comment have trailing line breaks and space? Nah...
	// Also (in)validate HTML here, and in $name.
	$comment = trim($comment);
	if (getOption('comment_email_required') && (empty($email) || !is_valid_email_zp($email))) { return -2; }
	if (getOption('comment_name_required') && empty($name)) { return -3; }
	if (getOption('comment_web_required') && (empty($website) || !isValidURL($website))) { return -4; }
	if (getOption('Use_Captcha')) {
		if (!$_zp_captcha->checkCaptcha($code, $code_ok)) return -5;
	}
	if (empty($comment)) {
		return -6;
	}
	if (!empty($website) && substr($website, 0, 7) != "http://") {
		$website = "http://" . $website;
	}
	$goodMessage = 2;
	$gallery = new gallery();
	if (!(false === ($requirePath = getPlugin('spamfilters/'.UTF8ToFileSystem(getOption('spam_filter')).".php", false)))) {
		require_once($requirePath);
		$spamfilter = new SpamFilter();
		$goodMessage = $spamfilter->filterMessage($name, $email, $website, $comment, isImageClass($receiver)?$receiver->getFullImage():NULL, $ip);
	}
	if ($goodMessage) {
		if ($goodMessage == 1) {
			$moderate = 1;
		} else {
			$moderate = 0;
		}
		if ($private) $private = 1; else $private = 0;
		if ($anon) $anon = 1; else $anon = 0;
		$receiverid = $receiver->id;
		
		// Update the database entry with the new comment
		query("INSERT INTO " . prefix("comments") . " (`ownerid`, `name`, `email`, `website`, `comment`, `inmoderation`, `date`, `type`, `ip`, `private`, `anon`) VALUES " .
						' ("' . $receiverid .
						'", "' . mysql_real_escape_string($name) .
						'", "' . mysql_real_escape_string($email) .
						'", "' . mysql_real_escape_string($website) .
						'", "' . mysql_real_escape_string ($comment) .
						'", "' . $moderate .
						'", NOW()'.
						', "'.$type.
						'", "'.$ip .
						'", "'.$private.
						'", "'.$anon.'")');
		if ($moderate) {
			$action = "placed in moderation";
		} else {
			//  add to comments array and notify the admin user
			$newcomment = array();
			$newcomment['name'] = $name;
			$newcomment['email'] = $email;
			$newcomment['website'] = $website;
			$newcomment['comment'] = $comment;
			$newcomment['date'] = time();
			$receiver->comments[] = $newcomment;
			$action = "posted";
		}
	// switch added for zenpage support
	$class = get_class($receiver);
		switch ($class) {
			case "Albums":
				$on = $receiver->name;
				$url = "album=" . urlencode($receiver->name);
				$ur_album = getUrAlbum($receiver);
				break;
			case "ZenpageNews":
				$on = $receiver->getTitlelink();
				$url = "p=".ZENPAGE_NEWS."&title=" . urlencode($receiver->getTitlelink());
				break;
			case "ZenpagePage":
				$on = $receiver->getTitlelink();
				$url = "p=".ZENPAGE_PAGES."&title=" . urlencode($receiver->getTitlelink());
				break;
			default: // all image types
				$on = $receiver->getAlbumName() . " about " . $receiver->getTitle();
				$url = "album=" . urlencode($receiver->album->name) . "&image=" . urlencode($receiver->filename);
				$album = $receiver->getAlbum();
				$ur_album = getUrAlbum($album);
				break;
		}
		if (getOption('email_new_comments')) {
			$last_comment = fetchComments(1);
			$last_comment = $last_comment[0]['id'];
			$message = gettext("A comment has been $action in your album")." $on\n" .
 										"\n" .
 										"Author: " . $name . "\n" .
 										"Email: " . $email . "\n" .
 										"Website: " . $website . "\n" .
 										"Comment:\n" . $comment . "\n" .
 										"\n" .
 										"You can view all comments about this image here:\n" .
 										"http://" . $_SERVER['SERVER_NAME'] . WEBPATH . "/index.php?$url\n" .
 										"\n" .
 										"You can edit the comment here:\n" .
 										"http://" . $_SERVER['SERVER_NAME'] . WEBPATH . "/" . ZENFOLDER . "/admin-comments.php?page=editcomment&id=$last_comment\n";
			$emails = array();
			$admin_users = getAdministrators();
			foreach ($admin_users as $admin) {  // mail anyone else with full rights
				if (($admin['rights'] & ADMIN_RIGHTS) && ($admin['rights'] & COMMENT_RIGHTS) && !empty($admin['email'])) {
					$emails[] = $admin['email'];
					unset($admin_users[$admin['id']]);
				}
			}
			// take out for zenpage comments since there are no album admins
			if($type === "images" OR $type === "albums") {
				$id = $ur_album->getAlbumID();
				$sql = "SELECT `adminid` FROM ".prefix('admintoalbum')." WHERE `albumid`=$id";
				$result = query_full_array($sql);
				foreach ($result as $anadmin) {
					$admin = $admin_users[$anadmin['adminid']];
					if (!empty($admin['email'])) {
						$emails[] = $admin['email'];
					}
				}
			}
			zp_mail("[" . get_language_string(getOption('gallery_title'), getOption('locale')) . "] Comment posted on $on", $message, "", $emails);
		}
	}
	return $goodMessage;
}

/**
 * Populates and returns the $_zp_admin_album_list array
 *
 * @return array
 */
function getManagedAlbumList() {
	global $_zp_admin_album_list, $_zp_current_admin;
	$_zp_admin_album_list = array();
	$sql = "SELECT ".prefix('albums').".`folder` FROM ".prefix('albums').", ".
	prefix('admintoalbum')." WHERE ".prefix('admintoalbum').".adminid=".
	$_zp_current_admin['id']." AND ".prefix('albums').".id=".prefix('admintoalbum').".albumid";
	$albums = query_full_array($sql);
	foreach($albums as $album) {
		$_zp_admin_album_list[] =$album['folder'];
	}
	return $_zp_admin_album_list;
}

/**
 * Checks to see if the loggedin Admin has rights to the album
 *
 * @param string $albumfolder the album to be checked
 * @param int $action what the user wishes to do
 */
function isMyAlbum($albumfolder, $action) {
	global $_zp_loggedin, $_zp_admin_album_list;
	if ($_zp_loggedin & (ADMIN_RIGHTS | ALL_ALBUMS_RIGHTS)) {
		return true;
	}
	if (empty($albumfolder)) {
		return false;
	}
	if ($_zp_loggedin & $action) {
		if (is_null($_zp_admin_album_list)) {
			getManagedAlbumList();
		}
		if (count($_zp_admin_album_list) == 0) {
			return false;
		}
		foreach ($_zp_admin_album_list as $key => $adminalbum) { // see if it is one of the managed folders or a subfolder there of
			if (substr($albumfolder, 0, strlen($adminalbum)) == $adminalbum) {
				return true;
			}
		}
		return false;
	} else {
		return false;
	}
}
/**
 * Returns  an array of album ids whose parent is the folder
 * @param string $albumfolder folder name if you want a album different >>from the current album
 * @return array
 */
function getAllSubAlbumIDs($albumfolder='') {
	global $_zp_current_album;
	if (empty($albumfolder)) {
		if (isset($_zp_current_album)) {
			$albumfolder = $_zp_current_album->getFolder();
		} else {
			return null;
		}
	}
	$query = "SELECT `id`,`folder`, `show` FROM " . prefix('albums') . " WHERE `folder` LIKE '" . mysql_real_escape_string($albumfolder) . "%'";
	$subIDs = query_full_array($query);
	return $subIDs;
}

/**
 * recovers search parameters from stored cookie, clears the cookie
 *
 * @param string $what the page type
 * @param string $album Name of the album
 * @param string $image Name of the image
 */
function handleSearchParms($what, $album=NULL, $image=NULL) {
	global $_zp_current_search, $zp_request;
	$cookiepath = WEBPATH;
	if (WEBPATH == '') { $cookiepath = '/'; }
	if (is_null($album)) {
		if (is_object($zp_request)) {
			$reset = get_class($zp_request) != 'SearchEngine';
		} else {
			$reset = $zp_request;
		}
		if ($reset) { // clear the cookie if no album and not a search
			if (!isset($_REQUEST['preserve_serch_params'])) {
				zp_setcookie("zenphoto_image_search_params", "", time()-368000, $cookiepath);
			}
			return;
		}
	}
	$context = get_context();
	$params = zp_getCookie('zenphoto_image_search_params');
	if (!empty($params)) {
		$_zp_current_search = new SearchEngine();
		$_zp_current_search->setSearchParams($params);
		// check to see if we are still "in the search context"
		if (!is_null($image)) {
			if ($_zp_current_search->getImageIndex($album->name, $image->filename) !== false) {
				$context = $context | ZP_SEARCH_LINKED | ZP_IMAGE_LINKED;
			}
		}
		if (!is_null($album)) {
			$albumname = $album->name;
			$albumlist = $_zp_current_search->getAlbums(0);
			foreach ($albumlist as $searchalbum) {	
				if (strpos($albumname, $searchalbum) !== false) {
					$context = $context | ZP_SEARCH_LINKED | ZP_ALBUM_LINKED;
					break;
				}
			}
		}
		if (($context & ZP_SEARCH_LINKED)) {
			set_context($context);
		} else {
			$_zp_current_search = null;
		}
	}
}

/**
 * Returns the number of album thumbs that go on a gallery page
 *
 * @return int
 */
function galleryAlbumsPerPage() {
	return max(1, getOption('albums_per_page'));
}

/**
 * Returns the theme folder
 * If there is an album theme, loads the theme options.
 *
 * @return string
 */
function setupTheme() {
	global $_zp_gallery, $_zp_current_album, $_zp_current_search, $_zp_options, $_zp_themeroot;
	$albumtheme = '';
	if (in_context(ZP_SEARCH_LINKED)) {
		$name = $_zp_current_search->dynalbumname;
		if (!empty($name)) {
			$album = new Album($_zp_gallery, $name);
		} else {
			$album = NULL;
		}
	} else {
		$album = $_zp_current_album;
	}
	$theme = $_zp_gallery->getCurrentTheme();
	if (!is_null($album)) {
		$parent = getUrAlbum($album);
		$albumtheme = $parent->getAlbumTheme();
	}
	if (!(false === ($requirePath = getPlugin('themeoptions.php', $theme)))) {
		require_once($requirePath);
		$optionHandler = new ThemeOptions(); /* prime the theme options */
	}
	if (!empty($albumtheme)) {
		$theme = $albumtheme;
		$tbl = prefix('options').' WHERE `ownerid`='.$parent->id;
		//load the album theme options
		$sql = "SELECT `name`, `value` FROM ".$tbl;
		$optionlist = query_full_array($sql, true);
		if ($optionlist !== false) {
			foreach($optionlist as $option) {
				$_zp_options[$option['name']] = $option['value'];
			}
		}
	}
	$_zp_themeroot = WEBPATH . "/".THEMEFOLDER."/$theme";
	return $theme;
}

/**
 * Returns true if the file has the dynamic album suffix
 *
 * @param string $path
 * @return bool
 */
function hasDyanmicAlbumSuffix($path) {
	return strtolower(substr(strrchr($path, "."), 1)) == 'alb';
}

/**
 * Count Binary Ones
 *
 * Returns the number of bits set in $bits
 *
 * @param bit $bits the bit mask to count
 * @param int $limit the upper limit on the numer of bits;
 * @return int
 */
function cbone($bits, $limit) {
	$c = 0;
	for ($i=0; $i<$limit; $i++) {
		$x = pow(2, $i);
		if ($bits & $x) $c++;
	}
	return $c;
}

/**
 * Allows plugins to add to the scripts output by zenJavascript()
 *
 * @param string $script the text to be added.
 */
function addPluginScript($script) {
	global $_zp_plugin_scripts;
	$_zp_plugin_scripts[] = $script;
}

/**
 * Registers a plugin as handler for a file extension
 *
 * @param string $suffix the file extension
 * @param string $objectName the name of the object that handles this extension
 */
function addPluginType($suffix, $objectName) {
	global $_zp_extra_filetypes;
	$_zp_extra_filetypes[strtolower($suffix)] = $objectName;
}

/**
 * Returns true if the file is handled by a plugin object
 *
 * @param string $filename
 * @return bool
 */
function is_valid_other_type($filename) {
	global $_zp_extra_filetypes;
	$ext = strtolower(substr(strrchr($filename, "."), 1));
	if (array_key_exists($ext, $_zp_extra_filetypes)) {
		return $ext;
	} else {
		return false;
	}
}

// multidimensional array column sort - source: http://codingforums.com/showthread.php?t=71904
/**
 * Trims the tag values and eliminates duplicates.
 * Tags are case insensitive so only the first of 'Tag' and 'tag' will be preserved
 *
 * Returns the filtered tag array.
 *
 * @param array $tags
 * @return array
 */
function filterTags($tags) {
	$lc_tags = array();
	$filtered_tags = array();
	foreach ($tags as $key=>$tag) {
		$tag = trim($tag);
		if (!empty($tag)) {
			$lc_tag = strtolower($tag);
			if (!in_array($lc_tag, $lc_tags)) {
				$lc_tags[] = $lc_tag;
				$filtered_tags[] = $tag;
			}
		}
	}
	return $filtered_tags;
}

$_zp_unique_tags = NULL;
/**
 * Returns an array of unique tag names
 *
 * @return unknown
 */
function getAllTagsUnique() {
	global $_zp_unique_tags;
	if (!is_null($_zp_unique_tags)) return $_zp_unique_tags;  // cache them.
	$sql = "SELECT `name` FROM ".prefix('tags').' ORDER BY `name`';
	$result = query_full_array($sql);
	if (is_array($result)) {
		$_zp_unique_tags = array();
		foreach ($result as $row) {
			$_zp_unique_tags[] = $row['name'];
		}
		return $_zp_unique_tags;
	} else {
		return array();
	}
}

$_zp_count_tags = NULL;
/**
 * Returns an array indexed by 'tag' with the element value the count of the tag
 *
 * @return array
 */
function getAllTagsCount() {
	global $_zp_count_tags;
	if (!is_null($_zp_count_tags)) return $_zp_count_tags;
	$_zp_count_tags = array();
	$sql = "SELECT `name`, `id` from ".prefix('tags').' ORDER BY `name`';
	$tagresult = query_full_array($sql);
	if (is_array($tagresult)) {
		$sql = 'SELECT `tagid`, `objectid` FROM '.prefix('obj_to_tag').' ORDER BY `tagid`';
		$countresult = query_full_array($sql);
		if (is_array($countresult)) {
			$id = 0;
			$tagcounts = array();
			foreach ($countresult as $row) {
				if ($id != $row['tagid']) {
					$tagcounts[$id = $row['tagid']] = 0;
				}
				$tagcounts[$id] ++;
			}
			foreach ($tagresult as $row) {
				if (isset($tagcounts[$row['id']])) {
					$_zp_count_tags[$row['name']] = $tagcounts[$row['id']];
				} else {
					$_zp_count_tags[$row['name']] = 0;
				}
			}
		} else {
			foreach ($tagresult as $tag) {
				$_zp_count_tags[$tag] = 0;
			}
		}
	}
	return $_zp_count_tags;
}

/**
 * Stores tags for an album/image
 *
 * @param array $tags the tag values
 * @param int $id the record id of the album/image
 * @param string $tbl 'albums' or 'images'
 */
function storeTags($tags, $id, $tbl) {
	global $_zp_UTF8;
	$tags = filterTags($tags);
	$tagsLC = array();
	foreach ($tags as $tag) {
		$tagsLC[$tag] = $_zp_UTF8->strtolower($tag);
	}
	$sql = "SELECT `id`, `tagid` from ".prefix('obj_to_tag')." WHERE `objectid`='".$id."' AND `type`='".$tbl."'";
	$result = query_full_array($sql);
	$existing = array();
	if (is_array($result)) {
		foreach ($result as $row) {
			$dbtag = query_single_row("SELECT `name` FROM ".prefix('tags')." WHERE `id`='".$row['tagid']."'");
			$existingLC = $_zp_UTF8->strtolower($dbtag['name']);
			if (in_array($existingLC, $tagsLC)) { // tag already set no action needed
				$existing[] = $existingLC;
			} else { // tag no longer set, remove it
				query("DELETE FROM ".prefix('obj_to_tag')." WHERE `id`='".$row['id']."'");
			}
		}
	}
	$tags = array_flip(array_diff($tagsLC, $existing)); // new tags for the object
	foreach ($tags as $tag) {
		$dbtag = query_single_row("SELECT `id` FROM ".prefix('tags')." WHERE `name`='".mysql_real_escape_string($tag)."'");
		if (!is_array($dbtag)) { // tag does not exist
			query("INSERT INTO " . prefix('tags') . " (name) VALUES ('" . mysql_real_escape_string($tag) . "')");
			$dbtag = query_single_row("SELECT `id` FROM ".prefix('tags')." WHERE `name`='".mysql_real_escape_string($tag)."'");
		}
		query("INSERT INTO ".prefix('obj_to_tag'). "(`objectid`, `tagid`, `type`) VALUES (".$id.",".$dbtag['id'].",'".$tbl."')");
	}
}

/**
 * Retrieves the tags for an album/image
 * Returns them in an array
 *
 * @param int $id the record id of the album/image
 * @param string $tbl 'albums' or 'images'
 * @return unknown
 */
function readTags($id, $tbl) {
	$tags = array();
	$result = query_full_array("SELECT `tagid` FROM ".prefix('obj_to_tag')." WHERE `type`='".$tbl."' AND `objectid`='".$id."'");
	if (is_array($result)) {
		foreach ($result as $row) {
			$dbtag = query_single_row("SELECT `name` FROM".prefix('tags')." WHERE `id`='".$row['tagid']."'");
			$tags[] = $dbtag['name'];
		}
	}
	natcasesort($tags);
	return $tags;
}

/**
 * Creates the body of a select list
 *
 * @param array $currentValue list of items to be flagged as checked
 * @param array $list the elements of the select list
 * @param bool $descending set true for a reverse order sort
 */
function generateListFromArray($currentValue, $list, $descending, $localize) {
	if ($localize) {
		$list = array_flip($list);
		if ($descending) {
			arsort($list);
		} else {
			natcasesort($list);
		}
		$list = array_flip($list);
	} else {
		if ($descending) {
			rsort($list);
		} else {
			natcasesort($list);
		}
	}
	foreach($list as $key=>$item) {
		echo '<option value="' . $item . '"';		
		if (in_array($item, $currentValue)) {
			echo ' selected="selected"';
		}
		if ($localize) $display = $key; else $display = $item;
		echo '>' . $display . "</option>"."\n";
	}
}

/**
 * Generates a selection list from files found on disk
 *
 * @param strig $currentValue the current value of the selector
 * @param string $root directory path to search
 * @param string $suffix suffix to select for
 * @param bool $descending set true to get a reverse order sort
 */
function generateListFromFiles($currentValue, $root, $suffix, $descending=false) {
	$curdir = getcwd();
	chdir($root);
	$filelist = safe_glob('*'.$suffix);
	$list = array();
	foreach($filelist as $file) {
		$file = str_replace($suffix, '', $file);
		$list[] = FilesystemToUTF8($file);
	}
	generateListFromArray(array($currentValue), $list, $descending, false);
	chdir($curdir);
}

/**
 * General link printing function
 * @param string $url The link URL
 * @param string $text The text to go with the link
 * @param string $title Text for the title tag
 * @param string $class optional class
 * @param string $id optional id
 */
function printLink($url, $text, $title=NULL, $class=NULL, $id=NULL) {
	echo "<a href=\"" . htmlspecialchars($url) . "\"" .
	(($title) ? " title=\"" . html_encode($title) . "\"" : "") .
	(($class) ? " class=\"$class\"" : "") .
	(($id) ? " id=\"$id\"" : "") . ">" .
	$text . "</a>";
}

/**
 * multidimensional array column sort
 *
 * @param array $array The multidimensional array to be sorted
 * @param string $index Which key should be sorted by
 * @param string $order The order to sort by, "asc" or "desc"
 * @param bool $natsort If natural order should be used
 * @param bool $case_sensitive If the sort should be case sensitive
 * @return array
 *
 * @author redoc (http://codingforums.com/showthread.php?t=71904)
 */
function sortMultiArray($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) {
	if(is_array($array) && count($array)>0) {
		foreach(array_keys($array) as $key) {
			if (is_array($array[$key]) && array_key_exists($index, $array[$key])) {
				$temp[$key]=$array[$key][$index];
			} else {
				$temp[$key] = '';
			}
		}
		if(!$natsort) {
			if ($order=='asc') {
				asort($temp);
			} else {
				arsort($temp);
			}
		} else {
			if ($case_sensitive) {
				natsort($temp);
			} else {
				natcasesort($temp);
			}
			if($order!='asc')  {
				$temp=array_reverse($temp,TRUE);
			}
		}
		foreach(array_keys($temp) as $key) {
			if(is_numeric($key)) {
				$sorted[]=$array[$key];
			} else {
				$sorted[$key]=$array[$key];
			}
		}
		return $sorted;
	}
	return $array;
}

$_zp_not_viewable_album_list = NULL;
/**
 * Returns a list of album IDs that the current viewer is allowed to see
 *
 * @return array
 */
function getNotViewableAlbums() {
	if (zp_loggedin(ADMIN_RIGHTS | ALL_ALBUMS_RIGHTS)) return array(); //admins can see all
	$hint = '';
	global $_zp_not_viewable_album_list;
	if (is_null($_zp_not_viewable_album_list)) {
		$sql = 'SELECT `folder`, `id`, `password`, `show` FROM '.prefix('albums').' WHERE `show`=0 OR `password`!=""';
		$result = query_full_array($sql);
		if (is_array($result)) {
			$_zp_not_viewable_album_list = array();
			foreach ($result as $row) {
				if (!checkAlbumPassword($row['folder'], $hint)) {
					$_zp_not_viewable_album_list[] = $row['id'];
				} else {
					if (!($row['show'] || isMyAlbum($row['folder'], ALL_RIGHTS))) {
						$_zp_not_viewable_album_list[] = $row['id'];
					}
				}
			}
		}
	}
	return $_zp_not_viewable_album_list;
}

/**
 * Parses and sanitizes Theme definition text
 *
 * @param file $file theme file
 * @return string
 */
function parseThemeDef($file) {
	$file = UTF8ToFilesystem($file);
	$themeinfo = array();
	if (is_readable($file) && $fp = @fopen($file, "r")) {
		while($line = fgets($fp)) {
			if (substr(trim($line), 0, 1) != "#") {
				$item = explode("::", $line);
				$themeinfo[trim($item[0])] = sanitize(trim($item[1]), 1);
			}
		}
		return $themeinfo;
	} else {
		return false;
	}
}

/**
 * Emits a page error. Used for attempts to bypass password protection
 * 
 * @param string $err error code
 * @param string $text error message
 *
 */
function pageError($err,$text) {
	header("HTTP/1.0 ".$err.' '.$text);
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\"><head>	<title>".$err." - ".$text."</TITLE>	<META NAME=\"ROBOTS\" CONTENT=\"NOINDEX, FOLLOW\"></head>";
	echo "<BODY bgcolor=\"#ffffff\" text=\"#000000\" link=\"#0000ff\" vlink=\"#0000ff\" alink=\"#0000ff\">";
	echo "<FONT face=\"Helvitica,Arial,Sans-serif\" size=\"2\">";
	echo "<b>".sprintf(gettext('Page access %2$s (%1$s)'),$err, $text)."</b><br/><br/>";
	echo "</body></html>";
}

/**
 * Checks to see if a URL is valid
 *
 * @param string $url the URL being checked
 * @return bool
 */
function isValidURL($url) {
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

/**
 * Provide an alternative to glob which does not return filenames with accented charactes in them
 *
 * @param string $pattern the 'pattern' for matching files
 * @param bit $flags glob 'flags'
 */
function safe_glob($pattern, $flags=0) {
	$split=explode('/',$pattern);
	$match=array_pop($split);
	$path_return = $path = implode('/',$split);
	if (empty($path)) {
		$path = '.';
	} else {
		$path_return = $path_return . '/';
	}
	if (!is_dir($path)) return array();
	if (($dir=opendir($path))!==false) {
		$glob=array();
		while(($file=readdir($dir))!==false) {
			if (safe_fnmatch($match,$file)) {
				if ((is_dir("$path/$file"))||(!($flags&GLOB_ONLYDIR))) {
					if ($flags&GLOB_MARK) $file.='/';
					$glob[]=$path_return.$file;
				}
			}
		}
		closedir($dir);
		if (!($flags&GLOB_NOSORT)) sort($glob);
		return $glob;
	} else {
		return array();
	}
}

/**
 * pattern match function Works with accented characters where the PHP one does not.
 *
 * @param string $pattern pattern
 * @param string $string haystack
 * @return bool
 */
function safe_fnmatch($pattern, $string) {
	return @preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string);
}

/**
 * Returns the value of a cookie from either the cookies or from $_SESSION[]
 *
 * @param string $name the name of the cookie
 */
function zp_getCookie($name) {
	if (DEBUG_LOGIN) {
		if (isset($_SESSION[$name])) {
			$sessionv = $_SESSION[$name];
		} else {
			$sessionv = '';
		}
		if (isset($_COOKIE[$name])) {
			$cookiev = $_COOKIE[$name];
		} else {
			$cookiev = '';
		}
		debugLog("zp_getCookie($name): SESSION[".session_id()."]=".$sessionv.", COOKIE=".$cookiev);
	}
	if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) {
		return $_COOKIE[$name];
	}
	if (isset($_SESSION[$name])) {
		return $_SESSION[$name];
	}
	return false;
}

/**
 * Sets a cookie both in the browser cookies and in $_SESSION[]
 *
 * @param string $name The 'cookie' name
 * @param string $value The value to be stored
 * @param timestamp $time The time the cookie expires
 * @param string $path The path on the server in which the cookie will be available on
 */
function zp_setCookie($name, $value, $time=0, $path='/') {
	if (DEBUG_LOGIN) debugLog("zp_setCookie($name, $value, $time, $path)::album_session=".getOption('album_session'));
	if ($time < time() || !getOption('album_session')) {
		setcookie($name, $value, $time, $path);
	}
	if ($time < time()) {
		if (isset($_SESSION))	unset($_SESSION[$name]);
		if (isset($_COOKIE)) unset($_COOKIE[$name]);
	} else {
		$_SESSION[$name] = $value;
		$_COOKIE[$name] = $value;
	}
}

/**
 * encodes for cookie
 **/
function cookiecode($text) {
	return md5($text);
}

/**
 * returns a list of comment record 'types' for "images"
 * @param string $quote quotation mark to use
 *
 * @return string
 */
function zp_image_types($quote) {
	global $_zp_extra_filetypes;
	$typelist = $quote.'images'.$quote.','.$quote.'_images'.$quote.',';
	$types = array_unique($_zp_extra_filetypes);
	foreach ($types as $type) {
		$typelist .= $quote.strtolower($type).'s'.$quote.',';
	}
	return substr($typelist, 0, -1);
}
/**

 * Returns video argument of the current Image.
 *
 * @param object $image optional image object
 * @return bool
 */
function isImageVideo($image=NULL) {
	if (is_null($image)) {
		if (!in_context(ZP_IMAGE)) return false;
		global $_zp_current_image;
		$image = $_zp_current_image;
	}
	return strtolower(get_class($image)) == 'video';
}

/**
 * Returns true if the image is a standard photo type
 *
 * @param object $image optional image object
 * @return bool
 */
function isImagePhoto($image=NULL) {
	if (is_null($image)) {
		if (!in_context(ZP_IMAGE)) return false;
		global $_zp_current_image;
		$image = $_zp_current_image;
	}
	$class = strtolower(get_class($image));
	return $class == '_image' || $class == 'transientimage';
}

/**
 * Copies a directory recursively
 * @param string $srcdir the source directory.
 * @param string $dstdir the destination directory.
 * @return the total number of files copied.
 */
function dircopy($srcdir, $dstdir) {
	$num = 0;
	if(!is_dir($dstdir)) mkdir($dstdir);
	if($curdir = opendir($srcdir)) {
		while($file = readdir($curdir)) {
			if($file != '.' && $file != '..') {
				$srcfile = $srcdir . '/' . $file;
				$dstfile = $dstdir . '/' . $file;
				if(is_file($srcfile)) {
					if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
					if($ow > 0) {
						if(copy($srcfile, $dstfile)) {
							touch($dstfile, filemtime($srcfile)); $num++;
						}
					}
				}
				else if(is_dir($srcfile)) {
					$num += dircopy($srcfile, $dstfile, $verbose);
				}
			}
		}
		closedir($curdir);
	}
	return $num;
}

/**
 * Returns a byte size from a size value (eg: 100M).
 *
 * @param int $bytes
 * @return string
 */
function byteConvert( $bytes ) {

	if ($bytes<=0)
	return '0 Byte';

	$convention=1024; //[1000->10^x|1024->2^x]
	$s=array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
	$e=floor(log($bytes,$convention));
	return round($bytes/pow($convention,$e),2).' '.$s[$e];
}

/**
 * Returns an i.php "image name" for an image not within the albums structure
 *
 * @param string $image Path to the image
 * @return string
 */
function makeSpecialImageName($image) {
	$filename = basename($image);
	$i = strpos($image, ZENFOLDER);
	if ($i === false) {
		$folder = '_{'.basename(dirname(dirname($image))).'}_{'.basename(dirname($image)).'}_';
	} else {
		$folder = '_{'.ZENFOLDER.'}_{'.substr($image, $i + strlen(ZENFOLDER) + 1 , - strlen($filename) - 1).'}_';
	}
	return $folder.$filename;
}

/**
 * Converts a datetime to connoical form
 *
 * @param string $datetime input date/time string
 * @param bool $raw set to true to return the timestamp otherwise you get a string
 * @return mixed
 */
function dateTimeConvert($datetime, $raw=false) {
	// Convert 'yyyy:mm:dd hh:mm:ss' to 'yyyy-mm-dd hh:mm:ss' for Windows' strtotime compatibility
	$datetime = preg_replace('/(\d{4}):(\d{2}):(\d{2})/', ' \1-\2-\3', $datetime);
	$time = @strtotime($datetime);
	if ($time == -1 || $time == false) return false;
	if ($raw) return $time;
	return date('Y-m-d H:i:s', $time);
}

setexifvars();
?>
