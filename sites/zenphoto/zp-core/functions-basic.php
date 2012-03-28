<?php
/**
 * basic functions used by zenphoto i.php
 * Keep this file to the minimum to allow the largest available memory for processing images!
 * Headers not sent yet!
 * @package functions
 *
 */

// force UTF-8 Ø


define('FILESYSTEM_CHARSET', 'ISO-8859-1');
define('DEBUG_LOGIN', false); // set to true to log admin saves and login attempts
define('DEBUG_ERROR', false); // set to true to  supplies the calling sequence with zp_error messages
define('DEBUG_IMAGE', false); // set to true to log image processing debug information.

// Set error reporting.
error_reporting(E_ALL ^E_NOTICE);
$_zp_error = false;

if (function_exists('date_default_timezone_set')) { // insure a correct timezone 
	$tz = date_default_timezone_get();
	date_default_timezone_set($tz); 
	ini_set('date.timezone', $tz);
} 

require_once(dirname(__FILE__).'/lib-utf8.php');
$_zp_UTF8 = new utf8();

include(dirname(__FILE__).'/version.php'); // Include the version info.

if (!defined('CHMOD_VALUE')) { define('CHMOD_VALUE', 0777); }
if (!defined('ZENFOLDER')) { define('ZENFOLDER', 'zp-core'); }
if (!defined('OFFSET_PATH')) { define('OFFSET_PATH', 0); }
define('COOKIE_PESISTENCE', 5184000);

// Set the memory limit higher just in case -- suppress errors if user doesn't have control.
// 100663296 bytes = 96M
if (ini_get('memory_limit') && parse_size(ini_get('memory_limit')) < 100663296) {
	@ini_set('memory_limit','96M');
}

if (!file_exists(dirname(__FILE__) . "/zp-config.php")) {
	die (sprintf(gettext("<strong>Zenphoto error:</strong> zp-config.php not found. Perhaps you need to run <a href=\"%s/setup.php\">setup</a> (or migrate your old config.php)"),ZENFOLDER));
}

// Including zp-config.php more than once is OK, and avoids $conf missing.
require(dirname(__FILE__).'/zp-config.php');

// If the server protocol is not set, set it to the default (obscure zp-config.php change).
if (!isset($_zp_conf_vars['server_protocol'])) $_zp_conf_vars['server_protocol'] = 'http';

require_once(dirname(__FILE__).'/functions-db.php');
require_once(dirname(__FILE__).'/lib-encryption.php');

switch (OFFSET_PATH) {
	case 0:	// starts from the root index.php
		$const_webpath = dirname($_SERVER['SCRIPT_NAME']);
		break;
	case 1:  // starts from the zp-core folder
	case 2:
		$const_webpath = dirname(dirname($_SERVER['SCRIPT_NAME']));
		break;
	case 3: // starts from the plugins folder
		$const_webpath = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
		break;
	case 4: // starts from within a folder within the plugins folder
		$const_webpath = dirname(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))));
		break;
	case 5: // $const_webpath provided by the "loading function"
		break;
}
$const_webpath = str_replace("\\", '/', $const_webpath);
if ($const_webpath == '/') $const_webpath = '';
if (!defined('WEBPATH')) { define('WEBPATH', $const_webpath); }
if (!defined('SERVERPATH')) define('SERVERPATH', str_replace("\\", '/', dirname(dirname(__FILE__))));
define('PROTOCOL', getOption('server_protocol'));
define('FULLWEBPATH', PROTOCOL."://" . $_SERVER['HTTP_HOST'] . WEBPATH);
define('SAFE_MODE_ALBUM_SEP', '__');
define('CACHEFOLDER', '/cache/');
define('SERVERCACHE', SERVERPATH . substr(CACHEFOLDER, 0, -1));

// Set the version number.
$_zp_conf_vars['version'] = ZENPHOTO_VERSION;

// the options array
$_zp_options = NULL;

define('ALBUMFOLDER', '/albums/');
if (!defined('PLUGIN_FOLDER')) { define('PLUGIN_FOLDER', '/plugins/'); }
define("THEMEFOLDER", 'themes');
define('BACKUPFOLDER', 'backup');
define('UTILITIES_FOLDER', '/utilities/');


/**
 * Decodes HTML Special Characters.  Function for backwards compatability with PHP 4.1.
 *
 * @param string $text
 * @param string $quote_style
 * @return string
 */
if (!function_exists("htmlspecialchars_decode")) {
	function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT) {
		$translation_table = get_html_translation_table(HTML_SPECIALCHARS, $quote_style);
		$translation_table["'"] = '&#039;';
		return (strtr($string, array_flip($translation_table)));
	}
}

/**
 * encodes a pre-sanitized string to be used in an HTML text-only field (value, alt, title, etc.)
 *
 * @param string $this_string
 * @return string
 */
function html_encode($this_string, $striptags=true) {
	if ($striptags) {$this_string = strip_tags($this_string);}
	$this_string = htmlspecialchars_decode($this_string, ENT_QUOTES);
	return htmlspecialchars($this_string, ENT_QUOTES, "UTF-8");
}

/**
 * encodes a pre-sanitized string to be used in a Javascript alert box
 *
 * @param string $this_string
 * @return string
 */
function js_encode($this_string) {
	global $_zp_UTF8;
	$this_string = preg_replace("/\r?\n/", "\\n", $this_string);
	$this_string = $_zp_UTF8->encode_javascript($this_string);
	return $this_string;
}

/**
 * Get a option stored in the database.
 * This function reads the options only once, in order to improve performance.
 * @param string $key the name of the option.
 * @param bool $db set to true to force retrieval from the database.
 */
function getOption($key, $db=false) {
	global $_zp_conf_vars, $_zp_options, $_zp_optionDB_hasownerid;
	if (is_null($_zp_options)) {
		$_zp_options = array();
	
		$sql = "SELECT `name`, `value` FROM ".prefix('options').' WHERE `ownerid`=0';
		$optionlist = query_full_array($sql, true);
		if ($optionlist == false) { // might be old, un-migrated option table during setup--retry without the `ownerid`.
			$sql = "SELECT `name`, `value` FROM ".prefix('options');
			$optionlist = query_full_array($sql, true);
		}
		if ($optionlist !== false) {
			foreach($optionlist as $option) {
				$_zp_options[$option['name']] = $option['value'];
			}
		}
	} else {
		if ($db) {
			$sql = "SELECT `value` FROM ".prefix('options')." WHERE `name`='".$key."' AND `ownerid`=0";
			$optionlist = query_single_row($sql);
			return $optionlist['value'];
		}
	}
	if (array_key_exists($key, $_zp_options)) {
		return $_zp_options[$key];
	} else {
		if (array_key_exists($key, $_zp_conf_vars)) {
			return $_zp_conf_vars[$key];
		} else {
			return NULL;
		}
	}
}

/**
 * Stores an option value.
 *
 * @param string $key name of the option.
 * @param mixed $value new value of the option.
 * @param bool $persistent set to false if the option is stored in memory only
 * otherwise it is preserved in the database
 */
function setOption($key, $value, $persistent=true) {
	global $_zp_conf_vars, $_zp_options;
	if ($persistent) {
		$result = query_single_row("SELECT `value` FROM ".prefix('options')." WHERE `name`='".$key."' AND `ownerid`=0", true);
		if (is_array($result) && array_key_exists('value', $result)) { // option already exists.
			if (is_null($value)) {
				$sql = "UPDATE " . prefix('options') . " SET `value`=NULL WHERE `name`='" . mysql_real_escape_string($key) ."' AND `ownerid`=0";
			} else {
				$sql = "UPDATE " . prefix('options') . " SET `value`='" . mysql_real_escape_string($value) . "' WHERE `name`='" . mysql_real_escape_string($key) ."' AND `ownerid`=0";
			}
			$result = query($sql, true);
		} else {
			if (is_null($value)) {
				$sql = "INSERT INTO " . prefix('options') . " (name, value, ownerid) VALUES ('" . mysql_real_escape_string($key) . "',NULL, 0)";
			} else {
				$sql = "INSERT INTO " . prefix('options') . " (name, value, ownerid) VALUES ('" . mysql_real_escape_string($key) . "','" . mysql_real_escape_string($value) . "', 0)";
			}
			$result = query($sql, true);
		}
	} else {
		$result = true;
	}
	if ($result) {
		$_zp_options[$key] = $value;
		return true;
	} else {
		return false;
	}
}

/**
 * Converts a boolean value to 1 or 0 and sets the option with it
 *
 * @param string $key the option
 * @param bool $value the value to be set
 */
function setBoolOption($key, $value) {
	if ($value) {
		setOption($key, '1');
	} else {
		setOption($key, '0');
	}
}

/**
 * Sets the default value of an option.
 *
 * If the option has never been set it is set to the value passed
 *
 * @param string $key the option name
 * @param mixed $default the value to be used as the default
 */
function setOptionDefault($key, $default) {
	global $_zp_conf_vars, $_zp_options;
	if (NULL == $_zp_options) { getOption('nil'); } // pre-load from the database
	if (!array_key_exists($key, $_zp_options)) {
		if (is_null($default)) {
			$sql = "INSERT INTO " . prefix('options') . " (`name`, `value`, `ownerid`) VALUES ('" . mysql_real_escape_string($key) . "', NULL, 0);";
		} else {
			$sql = "INSERT INTO " . prefix('options') . " (`name`, `value`, `ownerid`) VALUES ('" . mysql_real_escape_string($key) . "', '".
			mysql_real_escape_string($default) . "', 0);";
		}
		query($sql, true);
		$_zp_options[$key] = $default;
	}
}

/**
 * Retuns the option array
 *
 * @return array
 */
function getOptionList() {
	global $_zp_options;
	if (NULL == $_zp_options) { getOption('nil'); } // pre-load from the database
	return $_zp_options;
}

// Set up assertions for debugging.
assert_options(ASSERT_ACTIVE, 0);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);
/**
 * Emits an assertion error
 *
 * @param string $file the script file
 * @param string $line the line of the assertion
 * @param string $code the error message
 */
function assert_handler($file, $line, $code) {
	dmesg(gettext("ERROR: Assertion failed in")." [$file:$line]: $code");
}
// Set up assertion callback
assert_options(ASSERT_CALLBACK, 'assert_handler');


/**
 * rewrite_get_album_image - Fix special characters in the album and image names if mod_rewrite is on:
 * This is redundant and hacky; we need to either make the rewriting completely internal,
 * or fix the bugs in mod_rewrite. The former is probably a good idea.
 *
 *  Old explanation:
 *    rewrite_get_album_image() parses the album and image from the requested URL
 *    if mod_rewrite is on, and replaces the query variables with corrected ones.
 *    This is because of bugs in mod_rewrite that disallow certain characters.
 *
 * @param string $albumvar "$_GET" parameter for the album
 * @param string $imagevar "$_GET" parameter for the image
 */
function rewrite_get_album_image($albumvar, $imagevar) {
	if (getOption('mod_rewrite')) {
		$uri = urldecode(sanitize($_SERVER['REQUEST_URI'], 0));
		$path = substr($uri, strlen(WEBPATH)+1);
		// Only extract the path when the request doesn't include the running php file (query request).
		if (strlen($path) > 0 && strpos($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF']) === false && isset($_GET[$albumvar])) {
			$im_suffix = getOption('mod_rewrite_image_suffix');
			$suf_len = strlen($im_suffix);
			$qspos = strpos($path, '?');
			if ($qspos !== false) $path = substr($path, 0, $qspos);
			// Strip off the image suffix (could interfere with the rest, needs to go anyway).
			if ($suf_len > 0 && substr($path, -($suf_len)) == $im_suffix) {
				$path = substr($path, 0, -($suf_len));
			}
			if (substr($path, -1, 1) == '/') $path = substr($path, 0, strlen($path)-1);
			$pagepos  = strpos($path, '/page/');
			$slashpos = strrpos($path, '/');
			$imagepos = strpos($path, '/image/');
			$albumpos = strpos($path, '/album/');
			if ($imagepos !== false) {
				$ralbum = substr($path, 0, $imagepos);
				$rimage = substr($path, $slashpos+1);
			} else if ($albumpos !== false) {
				$ralbum = substr($path, 0, $albumpos);
				$rimage = substr($path, $slashpos+1);
			} else if ($pagepos !== false) {
				$ralbum = substr($path, 0, $pagepos);
				$rimage = null;
			} else if ($slashpos !== false) {
				$ralbum = substr($path, 0, $slashpos);
				$rimage = substr($path, $slashpos+1);
				if ((is_dir(getAlbumFolder() . UTF8ToFilesystem($ralbum . '/' . $rimage)) || hasDyanmicAlbumSuffix($rimage))) {
					$ralbum = $ralbum . '/' . $rimage;
					$rimage = null;
				}
			} else {
				$ralbum = $path;
				$rimage = null;
			}
			return array($ralbum, $rimage);
		}
	}
	// No mod_rewrite, or no album, etc. Just send back the query args.
	$ralbum = isset($_GET[$albumvar]) ? sanitize_path($_GET[$albumvar]) : null;
	$rimage = isset($_GET[$imagevar]) ? sanitize_path($_GET[$imagevar]) : null;
	return array($ralbum, $rimage);
}

/**
 * Returns the path of an image for uses in caching it
 * NOTE: character set if for the filesystem
 *
 * @param string $album album folder
 * @param string $image image file name
 * @param array $args cropping arguments
 * @return string
 */
function getImageCacheFilename($album8, $image8, $args) {
	// this function works in FILESYSTEM_CHARSET, so convert the file names
	$album = UTF8ToFilesystem($album8);
	$image = UTF8ToFilesystem($image8);
	// Set default variable values.
	$postfix = getImageCachePostfix($args);
	if (empty($album)) {
		$albumsep = '';
	} else {
		if (ini_get('safe_mode')) {
			$albumsep = SAFE_MODE_ALBUM_SEP;
			$album = str_replace(array('/',"\\"), $albumsep, $album);
		} else {
			$albumsep = '/';
		}
	}
	return '/' . $album . $albumsep . $image . $postfix . '.jpg';
}

/**
 * Returns the crop/sizing string to postfix to a cache image
 *
 * @param array $args cropping arguments
 * @return string
 */
function getImageCachePostfix($args) {
	list($size, $width, $height, $cw, $ch, $cx, $cy, $quality, $thumb, $crop, $thumbStandin, $thumbWM, $adminrequest) = $args;
	$postfix_string = ($size ? "_$size" : "") . ($width ? "_w$width" : "")
	. ($height ? "_h$height" : "") . ($cw ? "_cw$cw" : "") . ($ch ? "_ch$ch" : "")
	. (is_numeric($cx) ? "_cx$cx" : "") . (is_numeric($cy) ? "_cy$cy" : "")
	. ($thumb || $thumbStandin ? '_thumb' : '')
	. ($adminrequest ? '_admin' : '');
	return $postfix_string;
}


/**
 * Validates and edits image size/cropping parameters
 *
 * @param array $args cropping arguments
 * @return array
 */
function getImageParameters($args) {
	$thumb_crop = getOption('thumb_crop');
	$thumb_size = getOption('thumb_size');
	$thumb_crop_width = getOption('thumb_crop_width');
	$thumb_crop_height = getOption('thumb_crop_height');
	$thumb_quality = getOption('thumb_quality');
	$image_default_size = getOption('image_size');
	$quality = getOption('image_quality');
	// Set up the parameters
	$thumb = $crop = false;
	@list($size, $width, $height, $cw, $ch, $cx, $cy, $quality, $thumb, $crop, $thumbstandin, $thumbWM, $adminrequest) = $args;
	$thumb = $thumbstandin;
	if ($size == 'thumb') {
		$thumb = true;
		if ($thumb_crop) {
			$cw = $thumb_crop_width;
			$ch = $thumb_crop_height;
		}
		$size = round($thumb_size);
		$quality = round($thumb_quality);
		
	} else {
		if ($size == 'default') {
			$size = $image_default_size;
		} else if (empty($size) || !is_numeric($size)) {
			$size = false; // 0 isn't a valid size anyway, so this is OK.
		} else {
			$size = round($size);
		}
	}

	// Round each numeric variable, or set it to false if not a number.
	list($width, $height, $cw, $ch, $cx, $cy, $quality) =	array_map('sanitize_numeric', array($width, $height, $cw, $ch, $cx, $cy, $quality));
	if (empty($cw) && empty($ch)) $crop = false; else $crop = true;
	if (empty($quality)) $quality = getOption('image_quality');

	// Return an array of parameters used in image conversion.
	return array($size, $width, $height, $cw, $ch, $cx, $cy, $quality, $thumb, $crop, $thumbstandin, $thumbWM, $adminrequest);
}

/** Takes user input meant to be used within a path to a file or folder and
 * removes anything that could be insecure or malicious, or result in duplicate
 * representations for the same physical file.
 *
 * Returns the sanitized path
 *
 * @param string $filename is the path text to filter.
 * @return string
 */
function sanitize_path($filename) {
	if (get_magic_quotes_gpc()) $filename = stripslashes($filename);
	$filename = str_replace(chr(0), " ", $filename);
	$filename = strip_tags($filename);
	$filename = preg_replace(array('/^\/+/','/\/+$/','/\/\/+/','/\.\.+/'), '', $filename);
	return $filename;
}

/**
 * Checks if the input is numeric, rounds if so, otherwise returns false.
 *
 * @param mixed $num the number to be sanitized
 * @return int
 */
function sanitize_numeric($num) {
	if (is_numeric($num)) {
		return abs(round($num));
	} else {
		return false;
	}
}

/** Make strings generally clean.  Takes an input string and cleans out
 * null-bytes, slashes (if magic_quotes_gpc is on), and optionally use KSES
 * library to prevent XSS attacks and other malicious user input.
 * @param string $input_string is a string that needs cleaning.
 * @param string $sanitize_level is a number between 0 and 3 that describes the
 * type of sanitizing to perform on $input_string.
 *   0 - Basic sanitation. Only strips null bytes. Not recommended for submitted form data.
 *   1 - User specified. (User defined code is allowed. Used for descriptions and comments.)
 *   2 - Text style/formatting. (Text style codes allowed. Used for titles.)
 *   3 - Full sanitation. (Default. No code allowed. Used for text only fields)
 * @return string the sanitized string.
 */
function sanitize($input_string, $sanitize_level=3) {
	if (is_array($input_string)) {
		$output_string = array();
		foreach ($input_string as $output_key => $output_value) {
			$output_string[$output_key] = sanitize_string($output_value, $sanitize_level);
		}
	} else {
		$output_string = sanitize_string($input_string, $sanitize_level);
	}
	return $output_string;
}

/** returns a sanitized string for the sanitize function
 * @param string $input_string
 * @param string $sanitize_level
 * @return string the sanitized string.
 */
function sanitize_string($input_string, $sanitize_level) {
	// Strip slashes if get_magic_quotes_gpc is enabled.
	if (get_magic_quotes_gpc()) $input_string = stripslashes($input_string);
	// Basic sanitation.
	if ($sanitize_level === 0) {
		return str_replace(chr(0), " ", $input_string);
    }
	// User specified sanititation.
	require_once(dirname(__FILE__).'/lib-htmlawed.php');

	if ($sanitize_level === 1) {
		$user_tags = "(".getOption('allowed_tags').")";
		$allowed_tags = parseAllowedTags($user_tags);
		if ($allowed_tags === false) { $allowed_tags = array(); } // someone has screwed with the 'allowed_tags' option row in the database, but better safe than sorry
		$input_string = kses($input_string, $allowed_tags);

	// Text formatting sanititation.
	} else if ($sanitize_level === 2) {
		$style_tags = "(".getOption('style_tags').")";
		$allowed_tags = parseAllowedTags($style_tags);
		if ($allowed_tags === false) { $allowed_tags = array(); } // someone has screwed with the 'style_tags' option row in the database, but better safe than sorry
		$input_string = kses($input_string, $allowed_tags);

	// Full sanitation.  Strips all code.
	} else if ($sanitize_level === 3) {
		$allowed_tags = array();
		$input_string = kses($input_string, $allowed_tags);
	}
	return $input_string;
}

/**
 * Formats an error message
 * If DEBUG_ERROR is set, supplies the calling sequence
 *
 * @param string $message
 */
function zp_error($message) {
	global $_zp_error;
	if (!$_zp_error) {
		echo '<div style="padding: 15px; border: 1px solid #F99; background-color: #FFF0F0; margin: 20px; font-family: Arial, Helvetica, sans-serif; font-size: 12pt;">'
		. ' <h2 style="margin: 0px 0px 5px; color: #C30;">Zenphoto Error</h2><div style=" color:#000;">' . "\n\n" . $message . '</div>';
		if (DEBUG_ERROR) {
			// Get a backtrace.
			$bt = debug_backtrace();
			array_shift($bt); // Get rid of zp_error in the backtrace.
			$prefix = '  ';
			echo "\n\n<p><strong>Backtrace:</strong> <br />\n<pre>\n";
			foreach($bt as $b) {
				echo $prefix . ' in '
				. (isset($b['class']) ? $b['class'] : '')
				. (isset($b['type']) ? $b['type'] : '')
				. $b['function']
				. ' (' . basename($b['file'])
				. ' [' . $b['line'] . "])\n";
				$prefix .= '  ';
			}
			echo "</p>\n";
		}
		echo "</div>\n";
		$_zp_error = true;
		exit();
	}
}

/**
 * Returns either the rewrite path or the plain, non-mod_rewrite path
 * based on the mod_rewrite option in zp-config.php.
 * The given paths can start /with or without a slash, it doesn't matter.
 *
 * IDEA: this function could be used to specially escape items in
 * the rewrite chain, like the # character (a bug in mod_rewrite).
 *
 * This is here because it's used in both template-functions.php and in the classes.
 * @param string $rewrite is the path to return if rewrite is enabled. (eg: "/myalbum")
 * @param string $plain is the path if rewrite is disabled (eg: "/?album=myalbum")
 * @return string
 */
function rewrite_path($rewrite, $plain) {
	$path = null;
	if (getOption('mod_rewrite')) {
		$path = $rewrite;
	} else {
		$path = $plain;
	}
	if (substr($path, 0, 1) == "/") $path = substr($path, 1);
	return WEBPATH . "/" . $path;
}

/**
 * rawurlencode function that is path-safe (does not encode /)
 *
 * @param string $path URL
 * @return string
 */
function pathurlencode($path) {
	return implode("/", array_map("rawurlencode", explode("/", $path)));
}


/**
 * Return human readable sizes
 * From: http://aidan.dotgeek.org/lib/
 *
 * @param       int    $size        Size
 * @param       int    $unit        The maximum unit
 * @param       int    $retstring   The return string format
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.1.0
 */
function size_readable($size, $unit = null, $retstring = null)
{
	// Units
	$sizes = array('B', 'KB', 'MB', 'GB', 'TB');
	$ii = count($sizes) - 1;

	// Max unit
	$unit = array_search((string) $unit, $sizes);
	if ($unit === null || $unit === false) {
		$unit = $ii;
	}

	// Return string
	if ($retstring === null) {
		$retstring = '%01.2f %s';
	}

	// Loop
	$i = 0;
	while ($unit != $i && $size >= 1024 && $i < $ii) {
		$size /= 1024;
		$i++;
	}

	return sprintf($retstring, $size, $sizes[$i]);
}

/**
 * Returns the fully qualified path to the album folders
 *
 * @param string $root the base from whence the path dereives
 * @return sting
 */
$_zp_album_folder = null;
function getAlbumFolder($root=SERVERPATH) {
	global $_zp_album_folder, $_zp_conf_vars;
	if (is_null($_zp_album_folder)) {
		if (!isset($_zp_conf_vars['external_album_folder']) || is_null($_zp_conf_vars['external_album_folder'])) {
			if (is_null($_zp_conf_vars['album_folder'])) {
				$_zp_album_folder = ALBUMFOLDER;
			} else {
				$_zp_album_folder = $_zp_conf_vars['album_folder'];
			}
		} else {
			$_zp_conf_vars['album_folder_class'] = 'external';
			$_zp_album_folder = $_zp_conf_vars['external_album_folder'];
		}
		if (substr($_zp_album_folder, -1) != '/') $_zp_album_folder .= '/';
	}
	if (!isset($_zp_conf_vars['album_folder_class'])) {
		$_zp_conf_vars['album_folder_class'] = 'std';
	}
	switch ($_zp_conf_vars['album_folder_class']) {
		case 'std':
			return $root . $_zp_album_folder;
		case 'in_webpath':
			if (WEBPATH) { 			// strip off the WEBPATH
				$root = dirname($root);
				if ($root == '/') {
					$root = '';
				}
			}
			return $root . $_zp_album_folder;
		case 'external':
			return $_zp_album_folder;
	}
}


/**
 * Write output to the debug log
 * Use this for debugging when echo statements would come before headers are sent
 * or would create havoc in the HTML.
 * Creates (or adds to) a file named debug_log.txt which is located in the zenphoto core folder
 *
 * @param string $message the debug information
 * @param bool $reset set to true to reset the log to zero before writing the message
 */
function debugLog($message, $reset=false) {
	if ($reset) { $mode = 'w'; } else { $mode = 'a'; }
	$f = fopen(dirname(dirname(__FILE__)) . '/' . ZENFOLDER . '/debug_log.txt', $mode);
	fwrite($f, $message . "\n");
	fclose($f);
}

/**
 * "print_r" equivalent for the debug log
 *
 * @param string $name the name (or message) to display for the array
 * @param array $source
 */
function debugLogArray($name, $source, $indent=0, $trail='') {
	if (is_array($source)) {
		$msg = str_repeat(' ', $indent)."$name => ( ";
		if (count($source) > 0) {
			foreach ($source as $key => $val) {
				if (strlen($msg) > 72) {
					debugLog($msg);
					$msg = str_repeat(' ', $indent);
				}
				if (is_array($val)) {
					if (!empty($msg)) debugLog($msg);
					debugLogArray($key, $val, $indent+5, ',');
					$msg = '';
				} else {
					$msg .= $key . " => " . $val. ', ';
				}
			}

			$msg = substr($msg, 0, strrpos($msg, ',')) . " )".$trail;
		} else {
			$msg .= ")";
		}
		debugLog($msg);
	} else {
		debugLog($name.' parameter is not an array.');
	}
}

/**
 * Logs the calling stack
 *
 * @param string $message Message to prefix the backtrace
 */
function debugLogBacktrace($message) {
	debugLog("Backtrace: $message");
	// Get a backtrace.
	$bt = debug_backtrace();
	array_shift($bt); // Get rid of debug_backtrace in the backtrace.
	$prefix = '';
	$line = '';
	$caller = '';
	foreach($bt as $b) {
		$caller = (isset($b['class']) ? $b['class'] : '')	. (isset($b['type']) ? $b['type'] : '')	. $b['function'];
		if (!empty($line)) { // skip first output to match up functions with line where they are used.

			$msg = $prefix . ' from ';
			debugLog($msg.$caller.' ('.$line.')');
			$prefix .= '  ';
		} else {
			debugLog($caller.' called');
		}
		if (isset($b['file']) && isset($b['line'])) {
			$line = basename($b['file'])	. ' [' . $b['line'] . "]";
		} else {
			$line = 'unknown';
		}
	}
	if (!empty($line)) {
		debugLog($prefix.' from '.$line);
	}
}


/**
 * Makes directory recursively, returns TRUE if exists or was created sucessfuly.
 * Note: PHP5 includes a recursive parameter to mkdir, but PHP4 does not, so this
 *   is required to target PHP4.
 * @param string $pathname The directory path to be created.
 * @return boolean TRUE if exists or made or FALSE on failure.
 */

function mkdir_recursive($pathname, $mode=0777) {
	is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
	return is_dir($pathname) || @mkdir($pathname, $mode);
}

/**
 * Parses a byte size from a size value (eg: 100M) for comparison.
 */
function parse_size($size) {
	$suffixes = array(
    '' => 1,
    'k' => 1024,
    'm' => 1048576, // 1024 * 1024
    'g' => 1073741824, // 1024 * 1024 * 1024
	);
	if (preg_match('/([0-9]+)\s*(k|m|g)?(b?(ytes?)?)/i', $size, $match)) {
		return $match[1] * $suffixes[strtolower($match[2])];
	}
}

/**
 * Converts a file system filename to UTF-8 for zenphoto internal storage
 *
 * @param string $filename the file name to convert
 * @return string
 */
function fileSystemToUTF8($filename) {
	global $_zp_UTF8;
	return $_zp_UTF8->convert($filename, FILESYSTEM_CHARSET, 'UTF-8');
}

/**
 * Converts a Zenphoto Internal filename string to one compatible with the file system
 *
 * @param string $filename the file name to convert
 * @return string
 */
function UTF8ToFileSystem($filename) {
	global $_zp_UTF8;
	return $_zp_UTF8->convert($filename, 'UTF-8', FILESYSTEM_CHARSET);
}

/** getAlbumArray - returns an array of folder names corresponding to the
 *     given album string.
 * @param string $albumstring is the path to the album as a string. Ex: album/subalbum/my-album
 * @param string $includepaths is a boolean whether or not to include the full path to the album
 *    in each item of the array. Ex: when $includepaths==false, the above array would be
 *    ['album', 'subalbum', 'my-album'], and with $includepaths==true,
 *    ['album', 'album/subalbum', 'album/subalbum/my-album']
 *  @return array
 */
function getAlbumArray($albumstring, $includepaths=false) {
	if ($includepaths) {
		$array = array($albumstring);
		while($slashpos = strrpos($albumstring, '/')) {
			$albumstring = substr($albumstring, 0, $slashpos);
			array_unshift($array, $albumstring);
		}
		return $array;
	} else {
		return explode('/', $albumstring);
	}
}

/**
 * Returns true if the file is a video file
 *
 * @param string $filename the name of the target
 * @return bool
 */
function is_valid_video($filename) {
	global $_zp_extra_filetypes;
	$ext = strtolower(substr(strrchr($filename, "."), 1));
	return isset($_zp_extra_filetypes[$ext]) && $_zp_extra_filetypes[$ext] == 'Video';
}

/**
 * Returns true if we are running on a Windows server
 *
 * @return bool
 */
function isWin() {  
	return (strtoupper (substr(PHP_OS, 0,3)) == 'WIN' ) ;  
}  

/**
 * Returns an img src URI encoded based on the OS of the server
 *
 * @param string $uri uri in FILESYSTEM_CHARSET encoding
 * @return string
 */
function imgSrcURI($uri) {
	if (getOption('UTF8_image_URI')) return filesystemToUTF8($uri);
	return $uri;
}

?>
