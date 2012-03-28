<?php
/**
 * support functions for Admin
 * @package admin
 */

// force UTF-8 Ø

if (session_id() == '') session_start();

$_zp_admin_ordered_taglist = NULL;
$_zp_admin_LC_taglist = NULL;
$_zp_admin_album_list = null;
define('TEXTAREA_COLUMNS', 50);
define('TEXT_INPUT_SIZE', 48);
require_once(dirname(__FILE__).'/class-load.php');
require_once(dirname(__FILE__).'/functions.php');

// load the filter plugins
foreach (getEnabledPlugins() as $extension) {
	if (strpos($extension, 'filter-') === 0) {
		$option_interface = NULL;
		require_once(SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . $extension);
		if (!is_null($option_interface)) {
			$class_optionInterface[$extension] = $option_interface;
		}
	}
}

$sortby = array(gettext('Filename') => 'filename',
								gettext('Date') => 'date',
								gettext('Title') => 'title',
								gettext('ID') => 'id',
								gettext('Filemtime') => 'mtime'
								);
$charsets = array("ASMO-708" => "Arabic",
									"BIG5" => "Chinese Traditional",
									"CP1026" => "IBM EBCDIC (Turkish Latin-5)",
									"cp866" => "Cyrillic (DOS)",
									"CP870" => "IBM EBCDIC (Multilingual Latin-2)",
									"CISO2022JP" => "Japanese (JIS-Allow 1 byte Kana)",
									"DOS-720" => "Arabic (DOS)",
									"DOS-862" => "Hebrew (DOS)",
									"EBCDIC-CP-US" => "IBM EBCDIC (US-Canada)",
									"EUC-CN" => "Chinese Simplified (EUC)",
									"EUC-JP" => "Japanese (EUC)",
									"EUC-KR" => "Korean (EUC)",
									"GB2312" => "Chinese Simplified (GB2312)",
									"HZ-GB-2312" => "Chinese Simplified (HZ)",
									"IBM437" => "OEM United States",
									"IBM737" => "Greek (DOS)",
									"IBM775" => "Baltic (DOS)",
									"IBM850" => "Western European (DOS)",
									"IBM852" => "Central European (DOS)",
									"IBM857" => "Turkish (DOS)",
									"IBM861" => "Icelandic (DOS)",
									"IBM869" => "Greek, Modern (DOS)",
									"ISO-2022-JP" => "Japanese (JIS)",
									"ISO-2022-JP" => "Japanese (JIS-Allow 1 byte Kana - SO/SI)",
									"ISO-2022-KR" => "Korean (ISO)",
									"ISO-8859-1" => "Western European (ISO)",
									"ISO-8859-15" => "Latin 9 (ISO)",
									"ISO-8859-2" => "Central European (ISO)",
									"ISO-8859-3" => "Latin 3 (ISO)",
									"ISO-8859-4" => "Baltic (ISO)",
									"ISO-8859-5" => "Cyrillic (ISO)",
									"ISO-8859-6" => "Arabic (ISO)",
									"ISO-8859-7" => "Greek (ISO)",
									"ISO-8859-8" => "Hebrew (ISO-Visual)",
									"ISO-8859-8-i" => "Hebrew (ISO-Logical)",
									"ISO-8859-9" => "Turkish (ISO)",
									"JOHAB" => "Korean (Johab)",
									"KOi8-R" => "Cyrillic (KOI8-R)",
									"KOi8-U" => "Cyrillic (KOI8-U)",
									"KS_C_5601-1987" => "Korean",
									"MACINTOSH" => "Western European (MAC)",
									"SHIFT_JIS" => "Japanese (Shift-JIS)",
									"UNICODE" => "Unicode",
									"UNICODEFFFE" => "Unicode (Big-Endian)",
									"US-ASCII" => "US-ASCII",
									"UTF-7" => "Unicode (UTF-7)",
									"UTF-8" => "Unicode (UTF-8)",
									"WINDOWS-1250" => "Central European (Windows)",
									"WINDOWS-1251" => "Cyrillic (Windows)",
									"WINDOWS-1252" => "Western European (Windows)",
									"WINDOWS-1253" => "Greek (Windows)",
									"WINDOWS-1254" => "Turkish (Windows)",
									"WINDOWS-1255" => "Hebrew (Windows)",
									"WINDOWS-1256" => "Arabic (Windows)",
									"WINDOWS-1257" => "Baltic (Windows)",
									"WINDOWS-1258" => "Vietnamese (Windows)",
									"WINDOWS-874" => "Thai (Windows)",
									"X-CHINESE-CNS" => "Chinese Traditional (CNS)",
									"X-CHINESE-ETEN" => "Chinese Traditional (Eten)",
									"X-EBCDIC-Arabic" => "IBM EBCDIC (Arabic)",
									"X-EBCDIC-CP-US-EURO" => "IBM EBCDIC (US-Canada-Euro)",
									"X-EBCDIC-CYRILLICRUSSIAN" => "IBM EBCDIC (Cyrillic Russian)",
									"X-EBCDIC-CYRILLICSERBIANBULGARIAN" => "IBM EBCDIC (Cyrillic Serbian-Bulgarian)",
									"X-EBCDIC-DENMARKNORWAY" => "IBM EBCDIC (Denmark-Norway)",
									"X-EBCDIC-DENMARKNORWAY-euro" => "IBM EBCDIC (Denmark-Norway-Euro)",
									"X-EBCDIC-FINLANDSWEDEN" => "IBM EBCDIC (Finland-Sweden)",
									"X-EBCDIC-FINLANDSWEDEN-EURO" => "IBM EBCDIC (Finland-Sweden-Euro)",
									"X-EBCDIC-FINLANDSWEDEN-EURO" => "IBM EBCDIC (Finland-Sweden-Euro)",
									"X-EBCDIC-FRANCE-EURO" => "IBM EBCDIC (France-Euro)",
									"X-EBCDIC-GERMANY" => "IBM EBCDIC (Germany)",
									"X-EBCDIC-GERMANY-EURO" => "IBM EBCDIC (Germany-Euro)",
									"X-EBCDIC-GREEK" => "IBM EBCDIC (Greek)",
									"X-EBCDIC-GREEKMODERN" => "IBM EBCDIC (Greek Modern)",
									"X-EBCDIC-HEBREW" => "IBM EBCDIC (Hebrew)",
									"X-EBCDIC-ICELANDIC" => "IBM EBCDIC (Icelandic)",
									"X-EBCDIC-ICELANDIC-EURO" => "IBM EBCDIC (Icelandic-Euro)",
									"X-EBCDIC-INTERNATIONAL-EURO" => "IBM EBCDIC (International-Euro)",
									"X-EBCDIC-ITALY" => "IBM EBCDIC (Italy)",
									"X-EBCDIC-ITALY-EURO" => "IBM EBCDIC (Italy-Euro)",
									"X-EBCDIC-JAPANESEANDJAPANESELATIN" => "IBM EBCDIC (Japanese and Japanese-Latin)",
									"X-EBCDIC-JAPANESEANDKANA" => "IBM EBCDIC (Japanese and Japanese Katakana)",
									"X-EBCDIC-JAPANESEANDUSCANADA" => "IBM EBCDIC (Japanese and US-Canada)",
									"X-EBCDIC-JAPANESEKATAKANA" => "IBM EBCDIC (Japanese katakana)",
									"X-EBCDIC-KOREANANDKOREANEXTENDED" => "IBM EBCDIC (Korean and Korean EXtended)",
									"X-EBCDIC-KOREANEXTENDED" => "IBM EBCDIC (Korean EXtended)",
									"X-EBCDIC-SIMPLIFIEDCHINESE" => "IBM EBCDIC (Simplified Chinese)",
									"X-EBCDIC-SPAIN" => "IBM EBCDIC (Spain)",
									"X-ebcdic-SPAIN-EURO" => "IBM EBCDIC (Spain-Euro)",
									"X-EBCDIC-THAI" => "IBM EBCDIC (Thai)",
									"X-EBCDIC-TRADITIONALCHINESE" => "IBM EBCDIC (Traditional Chinese)",
									"X-EBCDIC-TURKISH" => "IBM EBCDIC (Turkish)",
									"X-EBCDIC-UK" => "IBM EBCDIC (UK)",
									"X-EBCDIC-UK-EURO" => "IBM EBCDIC (UK-Euro)",
									"X-EUROPA" => "Europa",
									"X-IA5" => "Western European (IA5)",
									"X-IA5-GERMAN" => "German (IA5)",
									"X-IA5-NORWEGIAN" => "Norwegian (IA5)",
									"X-IA5-SWEDISH" => "Swedish (IA5)",
									"X-ISCII-AS" => "ISCII Assamese",
									"X-ISCII-BE" => "ISCII Bengali",
									"X-ISCII-DE" => "ISCII Devanagari",
									"X-ISCII-GU" => "ISCII Gujarathi",
									"X-ISCII-KA" => "ISCII Kannada",
									"X-ISCII-MA" => "ISCII Malayalam",
									"X-ISCII-OR" => "ISCII Oriya",
									"X-ISCII-PA" => "ISCII Panjabi",
									"X-ISCII-TA" => "ISCII Tamil",
									"X-ISCII-TE" => "ISCII Telugu",
									"X-MAC-ARABIC" => "Arabic (Mac)",
									"X-MAC-CE" => "Central European (Mac)",
									"X-MAC-CHINESESIMP" => "Chinese Simplified (Mac)",
									"X-MAC-CHINESETRAD" => "Chinese Traditional (Mac)",
									"X-MAC-CYRILLIC" => "Cyrillic (Mac)",
									"X-MAC-GREEK" => "Greek (Mac)",
									"X-MAC-HEBREW" => "Hebrew (Mac)",
									"X-MAC-ICELANDIC" => "Icelandic (Mac)",
									"X-MAC-JAPANESE" => "Japanese (Mac)",
									"X-MAC-KOREAN" => "Korean (Mac)",
									"X-MAC-TURKISH" => "Turkish (Mac)"
									);

/**
 * Test to see whether we should be displaying a particular page.
 *
 * @param $page  The page we for which we are testing.
 *
 * @return True if this is the page, false otherwise.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function issetPage($page) {
	if (isset($_GET['page'])) {
		$pageval = strip($_GET['page']);
		if ($pageval == $page) {
			return true;
		}
	}
	return false;
}


/**
 * Print the footer <div> for the bottom of all admin pages.
 *
 * @param string $addl additional text to output on the footer.
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printAdminFooter($addl='') {
	echo "<div id=\"footer\">";
	echo "\n  <a href=\"http://www.zenphoto.org\" title=\"".gettext('A simpler web photo album')."\">zen<strong>photo</strong></a>";
	echo " version ". ZENPHOTO_VERSION.' ['.ZENPHOTO_RELEASE.']';
	if (!empty($addl)) {
		echo ' | '. $addl;
	}
	echo " | <a href=\"http://www.zenphoto.org/support/\" title=\"".gettext('Forum')."\">Forum</a> | <a href=\"http://www.zenphoto.org/trac/\" title=\"Trac\">Trac</a> | <a href=\"".WEBPATH."/".ZENFOLDER."/changelog.html\" title=\"".gettext('View Changelog')."\">Changelog</a>\n</div>";
}

/**
 * Print the header for all admin pages. Starts at <DOCTYPE> but does not include the </head> tag,
 * in case there is a need to add something further.
 *
 * @param string $path path to the admin files for use by plugins which are not located in the zp-core
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printAdminHeader($path='') {
	header ('Content-Type: text/html; charset=' . getOption('charset'));
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
	echo "\n<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	echo "\n<head>";
	echo "\n  <title>".gettext("zenphoto administration")."</title>";
	echo "\n  <link rel=\"stylesheet\" href=\"".$path."admin.css\" type=\"text/css\" />";
	echo "\n  <link rel=\"stylesheet\" href=\"".$path."js/toggleElements.css\" type=\"text/css\" />";
	echo "\n  <script src=\"".$path."js/jquery.js\" type=\"text/javascript\"></script>";
	echo "\n  <script src=\"".$path."js/zenphoto.js.php\" type=\"text/javascript\" ></script>";
	echo "\n  <script src=\"".$path."js/admin.js\" type=\"text/javascript\" ></script>";
	echo "\n  <script src=\"".$path."js/jquery.dimensions.js\" type=\"text/javascript\"></script>";
	echo "\n  <script src=\"".$path."js/jquery.tooltip.js\" type=\"text/javascript\"></script>";
	echo "\n  <script src=\"".$path."js/thickbox.js\" type=\"text/javascript\"></script>";
	echo "\n  <link rel=\"stylesheet\" href=\"".$path."js/thickbox.css\" type=\"text/css\" />";
	echo "\n  <script type=\"text/javascript\">";
	echo "\n  \tjQuery(function( $ ){";
	echo "\n  \t\t $(\"#fade-message\").fadeTo(5000, 1).fadeOut(1000);";
	echo "\n  \t\t $(\"#fade-message2\").fadeTo(5000, 1).fadeOut(1000);";
	echo "\n  \t\t $('.tooltip').tooltip();";
	echo "\n  \t});";
	echo "\n  </script>";
	?>
	<?php
	if (file_exists(dirname(__FILE__).'/js/editor_config.js.php')) require_once(dirname(__FILE__).'/js/editor_config.js.php');	
}

/**
 * Print a link to a particular album edit function.
 *
 * @param $param The album, etc parameters.
 * @param $text	Text for the hyperlink.
 * @param $title  Optional title attribute for the hyperlink. Default is NULL.
 * @param $class  Optional class attribute for the hyperlink.  Default is NULL.
 * @param $id		Optional id attribute for the hyperlink.  Default is NULL.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printAlbumEditLinks($param, $text, $title=NULL, $class=NULL, $id=NULL) {
	printLink("admin-edit.php?page=edit". $param, $text, $title, $class, $id);
}

/**
 * Print a link to the album sorting page. We will remain within the Edit tab of the admin section.
 *
 * @param $album The album name to sort.
 * @param $text  Text for the hyperlink.
 * @param $title Optional title attribute for the hyperlink. Default is NULL.
 * @param $class Optional class attribute for the hyperlink.  Default is NULL.
 * @param $id	 Optional id attribute for the hyperlink.  Default is NULL.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printSortLink($album, $text, $title=NULL, $class=NULL, $id=NULL) {
	printLink(WEBPATH . "/" . ZENFOLDER . "/admin-albumsort.php?page=edit&album=". urlencode( ($album->getFolder()) ), $text, $title, $class, $id);
}

/**
 * Print a link that will take the user to the actual album. E.g. useful for View Album.
 *
 * @param $album The album to view.
 * @param $text  Text for the hyperlink.
 * @param $title Optional title attribute for the hyperlink. Default is NULL.
 * @param $class Optional class attribute for the hyperlink.  Default is NULL.
 * @param $id	 Optional id attribute for the hyperlink.  Default is NULL.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printViewLink($album, $text, $title=NULL, $class=NULL, $id=NULL) {
	printLink(WEBPATH . "/index.php?album=". urlencode( ($album->getFolder()) ), $text, $title, $class, $id);
}

/**
 * Print the thumbnail for a particular Image.
 *
 * @param $image object The Image object whose thumbnail we want to display.
 * @param $class string Optional class attribute for the hyperlink.  Default is NULL.
 * @param $id	 string Optional id attribute for the hyperlink.  Default is NULL.
 * @param $bg    
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */

function adminPrintImageThumb($image, $class=NULL, $id=NULL) {
	echo "\n  <img class=\"imagethumb\" id=\"id_". $image->id ."\" src=\"" . $image->getThumb() . "\" alt=\"". html_encode($image->getTitle()) . "\" title=\"". html_encode($image->getTitle()) . " (". html_encode($image->getFileName()) . ")\"" .
	((getOption('thumb_crop')) ? " width=\"".getOption('thumb_crop_width')."\" height=\"".getOption('thumb_crop_height')."\"" : "") .
	(($class) ? " class=\"$class\"" : "") .
	(($id) ? " id=\"$id\"" : "") . " />";
}

/**
 * Print the login form for ZP. This will take into account whether mod_rewrite is enabled or not.
 *
 * @param string $redirect URL to return to after login
 * @param bool $logo set to true to display the ADMIN zenphoto logo.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printLoginForm($redirect=null, $logo=true) {
	global $_zp_login_error, $_zp_captcha;
	if (is_null($redirect)) { $redirect = "/" . ZENFOLDER . "/admin.php"; }
	if (isset($_POST['user'])) {
		$requestor = sanitize($_POST['user'], 3);
	} else {
		$requestor = '';
	}
	if (empty($requestor)) {
		if (isset($_GET['ref'])) {
			$requestor = sanitize($_GET['ref'], 0);
		}
	}

	if ($logo) echo "<p><img src=\"../" . ZENFOLDER . "/images/zen-logo.gif\" title=\"Zen Photo\" /></p>";
	if (count(getAdminEmail()) > 0) {
		$star = '*';
	} else {
		$star = '&nbsp;';
	}
	echo "\n  <div id=\"loginform\">";
	if ($_zp_login_error == 1) {
		echo "<div class=\"errorbox\" id=\"message\"><h2>".gettext("There was an error logging in.")."</h2> ".gettext("Check your username and password and try again.")."</div>";
	} else if ($_zp_login_error == 2){
		echo '<div class="messagebox" id="fade-message">';
		echo  "<h2>".gettext("A reset request has been sent.")."</h2>";
		echo '</div>';
	}
	echo "\n  <form name=\"login\" action=\"#\" method=\"POST\">";
	echo "\n	 <input type=\"hidden\" name=\"login\" value=\"1\" />";
	echo "\n	 <input type=\"hidden\" name=\"redirect\" value=\"$redirect\" />";

	echo "\n	 <table>";
	echo "\n		<tr><td align=\"right\"><h2>".gettext("Login").'&nbsp;'."</h2></td><td><input class=\"textfield\" name=\"user\" type=\"text\" size=\"20\" value=\"$requestor\" /></td></tr>";
	echo "\n		<tr><td align=\"right\"><h2>".gettext("Password").$star."</h2></td><td><input class=\"textfield\" name=\"pass\" type=\"password\" size=\"20\" /></td></tr>";
	if ($star == '*') {
		$captchaCode = $_zp_captcha->generateCaptcha($img);
		$html = "<input type=\"hidden\" name=\"code_h\" value=\"" . $captchaCode . "\"/><label for=\"code\"><img src=\"" . $img . "\" alt=\"Code\" align=\"bottom\"/></label>";
		echo "\n		<tr><td colspan=\"2\">";
		echo "\n		".sprintf(gettext("*Enter %s to email a password reset."), $html);
		echo "		</td></tr>";
	}
	echo "\n		<tr><td></td><td colspan=\"2\"><input class=\"button\" type=\"submit\" value=\"".gettext("Log in")."\" /></td></tr>";
	echo "\n	 </table>";
	echo "\n  </form>";
	echo "\n  </div>";
	echo "\n</body>";
	echo "\n</html>";
}


/**
 * Print the html required to display the ZP logo and links in the top section of the admin page.
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printLogoAndLinks() {
	global $_zp_current_admin;
	?>
	<span id="administration"><img id="logo" src="<?php echo WEBPATH.'/'.ZENFOLDER; ?>/images/zen-logo.gif" title="<?php echo gettext('Zenphoto Administration'); ?>" align="absbottom" />
	<?php //echo gettext("Administration"); ?>
	</span>
	<?php
	echo "\n<div id=\"links\">";
	echo "\n  ";
	if (!is_null($_zp_current_admin)) {
		printf(gettext("Logged in as %s"), $_zp_current_admin['user']);
		echo " &nbsp; | &nbsp <a href=\"".WEBPATH."/".ZENFOLDER."/admin.php?logout\">".gettext("Log Out")."</a> &nbsp; | &nbsp; ";
	}
	echo "<a href=\"".WEBPATH."/index.php";
	if ($specialpage = getOption('custom_index_page')) {
		if (file_exists(SERVERPATH.'/'.THEMEFOLDER.'/'.getOption('current_theme').'/'.UTF8ToFilesystem($specialpage).'.php')) {
			echo '?p='.$specialpage;
		}
	}
	echo "\">";
	$t = get_language_string(getOption('gallery_title'));
	if (!empty($t))	{
		printf(gettext("View Gallery: %s"), $t);
	} else {
		echo gettext("View Gallery");
	}
	echo "</a>";
	echo "\n</div>";
}

/**
 * Print the nav tabs for the admin section. We determine which tab should be highlighted
 * from the $_GET['page']. If none is set, we default to "home".
 *
 * @author Todd Papaioannou (lucky@luckyspin.org)
 * @since  1.0.0
 */
function printTabs($currenttab) {
	global $_zp_loggedin;

	echo "\n  <ul class=\"nav\">";
	if (($_zp_loggedin & (MAIN_RIGHTS | ADMIN_RIGHTS))) {
		echo "\n	 <li". (($currenttab == "home") ? " class=\"current\""		: "") .
 				"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin.php\">".gettext("overview")."</a></li>";
	}
	if (($_zp_loggedin & (COMMENT_RIGHTS | ADMIN_RIGHTS))) {
		echo "\n	 <li". (($currenttab == 'comments') ? " class=\"current\"" : "") .
 				"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin-comments.php\">".gettext("comments")."</a></li>";
	}
	if (($_zp_loggedin & (UPLOAD_RIGHTS | ADMIN_RIGHTS))) {
		echo "\n	 <li". (($currenttab =='upload') ? " class=\"current\""	: "") .
 				"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin-upload.php\">".gettext("upload")."</a></li>";
	}

	if (($_zp_loggedin & (EDIT_RIGHTS | ADMIN_RIGHTS))) {
		echo "\n	 <li". (($currenttab == 'edit') ? " class=\"current\""		: "") .
 				"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin-edit.php?page=edit\">".gettext("edit")."</a></li>";
	}
	if (($_zp_loggedin & ADMIN_RIGHTS)) {
		echo "\n	 <li". (($currenttab == 'tags') ? " class=\"current\""		: "") .
				"><a href=\"".WEBPATH."/".ZENFOLDER."/admin-tags.php\">".gettext('tags')."</a></li>";
	}
	echo "\n	 <li". (($currenttab == 'options') ? " class=\"current\""  : "") .
 			"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin-options.php\">".gettext("options")."</a></li>";
	if (($_zp_loggedin & (THEMES_RIGHTS | ADMIN_RIGHTS))) {
		echo "\n	 <li". (($currenttab == 'themes') ? " class=\"current\""  : "") .
 				"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin-themes.php\">".gettext("themes")."</a></li>";
	}
	if (($_zp_loggedin & ADMIN_RIGHTS)) {
		echo "\n	 <li". (($currenttab == 'plugins') ? " class=\"current\""  : "") .
 				"> <a href=\"".WEBPATH."/".ZENFOLDER."/admin-plugins.php\">".gettext("plugins")."</a></li>";
	}
	if (($_zp_loggedin & (ADMIN_RIGHTS | ZENPAGE_RIGHTS)) && getOption('zp_plugin_zenpage')) {
		echo "\n	 <li". (($currenttab == 'zenpage') ? " class=\"current\""		: "") .
 				"><a href=\"".WEBPATH."/".ZENFOLDER."/plugins/zenpage/\">zenpage</a></li>";
	}
	echo "\n  </ul>";

}

function getSubtabs($tabs) {
	if (isset($_GET['tab'])) {
		$current = sanitize($_GET['tab']);
	} else {
		$current = $tabs;
		$current = array_shift($current);
		$i = strrpos($current, '=');
		if ($i===false) {
			$current = '';
		} else {
			$current = substr($current, $i+1);
		}
	}
	return $current;
}

function printSubtabs($tabs) {
	$current = getSubtabs($tabs);
	?>
	<ul class="subnav">
	<?php
	foreach ($tabs as $key=>$link) {
		$tab = substr($link, strrpos($link, '=')+1);
		echo '<li'.(($current == $tab) ? ' class="current"' : '').'>'.
				 '<a href = "'.WEBPATH.'/'.ZENFOLDER.'/'.$link.'">'.$key.'</a></li>'."\n";
	}
	?>
	</ul>
	<?php
	return $current;
}
function checked($checked, $current) {
	if ( $checked == $current)
	echo ' checked="checked"';
}

function genAlbumUploadList(&$list, $curAlbum=NULL) {
	global $gallery;
	$albums = array();
	if (is_null($curAlbum)) {
		$albumsprime = $gallery->getAlbums(0);
		foreach ($albumsprime as $album) { // check for rights
			if (isMyAlbum($album, UPLOAD_RIGHTS)) {
				$albums[] = $album;
			}
		}
	} else {
		$albums = $curAlbum->getSubAlbums(0);
	}
	if (is_array($albums)) {
		foreach ($albums as $folder) {
			$album = new Album($gallery, $folder);
			if (!$album->isDynamic()) {
				$list[$album->getFolder()] = $album->getTitle();
				genAlbumUploadList($list, $album);  /* generate for subalbums */
			}
		}
	}
}

function displayDeleted() {
	/* Display a message if needed. Fade out and hide after 2 seconds. */
	if (isset($_GET['ndeleted'])) {
		$ntdel = strip($_GET['ndeleted']);
		if ($ntdel <= 2) {
			$msg = gettext("Image");
		} else {
			$msg = gettext("Album");
			$ntdel = $ntdel - 2;
		}
		if ($ntdel == 2) {
			$msg = sprintf(gettext("%s failed to delete."),$msg);
			$class = 'errorbox';
		} else {
			$msg = sprintf(gettext("%s deleted successfully."),$msg);
			$class = 'messagebox';
		}
		echo '<div class="' . $class . '" id="fade-message">';
		echo  "<h2>" . $msg . "</h2>";
		echo '</div>';
	}
}

function setThemeOption($album, $key, $value) {
	if (is_null($album)) {
		setOption($key, $value);
	} else {
		if (is_null($album)) {
			$id = 0;
		} else {
			$id = $album->id;
		}
		$exists = query_single_row("SELECT `name`, `value`, `id` FROM ".prefix('options')." WHERE `name`='".mysql_real_escape_string($key)."' AND `ownerid`=".$id, true);
		if ($exists) {
			if (is_null($value)) {
				$sql = "UPDATE " . prefix('options') . " SET `value`=NULL WHERE `id`=" . $exists['id'];
			} else {
				$sql = "UPDATE " . prefix('options') . " SET `value`='" . mysql_real_escape_string($value) . "' WHERE `id`=" . $exists['id'];
			}
		} else {
			if (is_null($value)) {
				$sql = "INSERT INTO " . prefix('options') . " (name, value, ownerid) VALUES ('" . mysql_real_escape_string($key) . "',NULL,$id)";
			} else {
				$sql = "INSERT INTO " . prefix('options') . " (name, value, ownerid) VALUES ('" . mysql_real_escape_string($key) . "','" . mysql_real_escape_string($value) . "',$id)";
			}
		}
		$result = query($sql);
	}
}

function setBoolThemeOption($album, $key, $bool) {
	if ($bool) {
		$value = 1;
	} else {
		$value = 0;
	}
	setThemeOption($album, $key, $value);
}

function getThemeOption($album, $option) {
	if (is_null($album)) {
		return getOption($option);
	}
	$alb = 'options';
	$where = ' AND `ownerid`='.$album->id;
	if (empty($alb)) {
		return getOption($option);
	}
	$sql = "SELECT `value` FROM " . prefix($alb) . " WHERE `name`='" . escape($option) . "'".$where;
	$db = query_single_row($sql);
	if (!$db) {
		return getOption($option);
	}
	return $db['value'];
}

define ('CUSTOM_OPTION_PREFIX', '_ZP_CUSTOM_');
/**
 * Generates the HTML for custom options (e.g. theme options, plugin options, etc.)
 *
 * @param object $optionHandler the object to handle custom options
 * @param string $indent used to indent the option for nested options
 * @param object $album if not null, the album to which the option belongs
 * @param bool $hide set to true to hide the output (used by the plugin-options folding
 *
 * There are four type of custom options:
 * 		0: a textbox
 * 		1: a checkbox
 * 		2: handled by $optionHandler->handleOption()
 * 		3: a textarea
 * 		4: radio buttons (button names are in the 'buttons' index of the supported options array)
 * 		5: selector (selection list is in the 'selections' index of the supported options array)
 * 		6: checkbox array (checkboxed list is in the 'checkboxes' index of the suppoprted options array.)
 * 		7: checkbox UL (checkboxed list is in the 'checkboxes' index of the suppoprted options array.)
 *
 * type 0 and 3 support multi-lingual strings.
 */
function customOptions($optionHandler, $indent="", $album=NULL, $hide=false) {
	$supportedOptions = $optionHandler->getOptionsSupported();
	if (count($supportedOptions) > 0) {
		$options = array_keys($supportedOptions);
		natcasesort($options);
		foreach($options as $option) {
			$row = $supportedOptions[$option];
			$type = $row['type'];
			$desc = $row['desc'];
			$multilingual = isset($row['multilingual']) && $row['multilingual'];
			if (isset($row['texteditor']) && $row['texteditor']) {
				$editor = 'texteditor';
			} else {
				$editor = '';
			}
			if (isset($row['key'])) {
				$key = $row['key'];
			} else { // backward compatibility
				$key = $option;
				$option = str_replace('_', ' ', $option);
			}
			if (is_null($album)) {
				$db = false;
			} else {
				$sql = "SELECT `value` FROM " . prefix('options') . " WHERE `name`='" . escape($key) .
										"' AND `ownerid`=".$album->id;

				$db = query_single_row($sql);
			}
			if (!$db) {
				$sql = "SELECT `value` FROM " . prefix('options') . " WHERE `name`='" . escape($key) . "';";
				$db = query_single_row($sql);
			}
			if ($db) {
				$v = $db['value'];
			} else {
				$v = 0;
			}

			if ($hide) echo "\n<tr class='".$hide."extrainfo' style='display:none'>\n";
			echo '<td width="175">' . $indent . $option . ":</td>\n";

			switch ($type) {
				case 0:  // text box
				case 3:  // text area
					echo '<td width="350px">';
					echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'text-'.$key.'" value=0 />'."\n";
					if ($multilingual || $type) {
						print_language_string_list($v, $key, $type, NULL, $editor);
					} else {
						echo '<input type="text" size="40" name="' . $key . '" style="width: 338px" value="' . html_encode($v) . '">' . "\n";
					}
					echo '</td>' . "\n";
					break;
				case 1:  // check box
					echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'chkbox-'.$key.'" value=0 />' . "\n";
					echo '<td width="350px"><input type="checkbox" name="'.$key.'" value="1"';
					echo checked('1', $v);
					echo " /></td>\n";
					break;
				case 2:  // custom handling
					echo '<td width="350px">' . "\n";
					echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'custom-'.$key.'" value=0 />' . "\n";
					$optionHandler->handleOption($key, $v);
					echo "</td>\n";
					break;
				case 4: // radio button
					echo '<td width="350px">' . "\n";
					echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'radio-'.$key.'" value=0 />' . "\n";
					generateRadiobuttonsFromArray($v,$row['buttons'],$key);
					echo "</td>\n";
					break;
				case 5: // selector
					echo '<td width="350px">' . "\n";
					echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'selector-'.$key.'" value=0 />' . "\n";
					echo '<select id="'.$option.'" name="'.$key.'">'."\n";
					generateListFromArray(array($v),$row['selections'], false, true);
					echo "</select>\n";
					echo "</td>\n";
					break;
				case 6: // checkbox array
					echo "<td width=\"350px>\"\n";
					foreach ($row['checkboxes'] as $display=>$checkbox) {
						$ck_sql = str_replace($key, $checkbox, $sql);
						$db = query_single_row($ck_sql);
						if ($db) {
							$v = $db['value'];
						} else {
							$v = 0;
						}
						$display = str_replace(' ', '&nbsp;', $display);
						echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'chkbox-'.$checkbox.'" value=0 />' . "\n";
						echo '<input type="checkbox" name="'.$checkbox.'" value="1"';
						echo checked('1', $v);
						echo " />&nbsp;$display\n";
					}
					echo "</td>\n";
					break;
				case 7: // checkbox UL
					echo "<td width=\"350px>\"\n";
					foreach ($row['checkboxes'] as $display=>$checkbox) {
						echo '<input type="hidden" name="'.CUSTOM_OPTION_PREFIX.'chkbox-'.$checkbox.'" value=0 />' . "\n";
					}
					echo '<ul class="customchecklist">'."\n";
					generateUnorderedListFromArray($row['currentvalues'], $row['checkboxes'], '', '', true, true);
					echo '</ul>';
					echo "</td>\n";
					break;
			}
			echo '<td>' . $desc . "</td>\n";
			echo "</tr>\n";
		}
	}
}

/**
 * Encodes for use as a $_POST index
 *
 * @param string $str
 */
function postIndexEncode($str) {
	$str = urlencode($str);
	return str_replace('.','%2E', $str);
}

/**
 * Decodes encoded $_POST index
 *
 * @param string $str
 * @return string
 */
function postIndexDecode($str) {
	$str = str_replace('%2E', '.', strip($str));
	return urldecode($str);
}


/**
 * Prints radio buttons from an array
 *
 * @param string $currentvalue The current selected value
 * @param string $list the array of the list items form is localtext => buttonvalue
 * @param string $option the name of the option for the input field name
 */
function generateRadiobuttonsFromArray($currentvalue,$list,$option) {
	foreach($list as $text=>$value) {
		$checked ="";
		if($value == $currentvalue) {
			$checked = "checked='checked' "; //the checked() function uses quotes the other way round...
		} 
		echo "<input type='radio' name='".$option."' id='".$value."-".$option."' value='".$value."' ".$checked."/><label for='".$value."-".$option."'> ".$text."</label> ";
	}
}

/**
 * Creates the body of an unordered list with checkbox label/input fields (scrollable sortables)
 *
 * @param array $currentValue list of items to be flagged as checked
 * @param array $list the elements of the select list
 * @param string $prefix prefix of the input item
 * @param string $alterrights are the items changable.
 */
function generateUnorderedListFromArray($currentValue, $list, $prefix, $alterrights, $sort, $localize) {
	if ($sort) {
		if ($localize) {
			$list = array_flip($list);
			natcasesort($list);
			$list = array_flip($list);
		} else {
			natcasesort($list);
		}
	}
	$cv = array_flip($currentValue);
	foreach($list as $key=>$item) {
		$listitem = postIndexEncode($prefix.$item);
		echo '<li><label for="'.$listitem.'"><input id="'.$listitem.'" name="'.$listitem.'" type="checkbox"';
		if (isset($cv[$item])) {
			echo ' checked="checked" ';
		}
		echo ' value="'.$item.'" ';
		if ($localize) $display = $key; else $display = $item;
		echo $alterrights.' /> ' . $display . "</label></li>"."\n";
	}
}

/**
 * Creates an unordered checklist of the tags
 *
 * @param object $that Object for which to get the tags
 * @param string $postit prefix to prepend for posting
 * @param bool $showCounts set to true to get tag count displayed
 */
function tagSelector($that, $postit, $showCounts=false, $mostused=false) {
	global $_zp_loggedin, $_zp_admin_ordered_taglist, $_zp_admin_LC_taglist, $_zp_UTF8;
	if (is_null($_zp_admin_ordered_taglist)) {
		if ($mostused || $showCounts) {
			$counts = getAllTagsCount();
			if ($mostused) arsort($counts, SORT_NUMERIC);
			$them = array();
			foreach ($counts as $tag=>$count) {
				$them[] = $tag;
			}
		} else {
			$them = getAllTagsUnique();
		}
		$_zp_admin_ordered_taglist = $them;
		$_zp_admin_LC_taglist = array();
		foreach ($them as $tag) {
			$_zp_admin_LC_taglist[] = $_zp_UTF8->strtolower($tag);
		}
	} else {
		$them = $_zp_admin_ordered_taglist;
	}

	if (is_null($that)) {
		$tags = array();
	} else {
		$tags = $that->getTags();
	}
	if (count($tags) > 0) {
		foreach ($tags as $tag) {
			$tagLC = 	$_zp_UTF8->strtolower($tag);
			$key = array_search($tagLC, $_zp_admin_LC_taglist);
			if ($key !== false) {
				unset($them[$key]);
			}
		}
	}
	echo '<ul class="tagchecklist">'."\n";
	if ($showCounts) {
		$displaylist = array();
		foreach ($them as $tag) {
			$displaylist[$tag.' ['.$counts[$tag].']'] = $tag;
		}
	} else {
		$displaylist = $them;
	}
	if (count($tags) > 0) {
		generateUnorderedListFromArray($tags, $tags, $postit, false, true, false);
		echo '<hr>';
	}
	generateUnorderedListFromArray(array(), $displaylist, $postit, false, true, false);
	echo '</ul>';
}

/**
 * emits the html for editing album information
 * called in edit album and mass edit
 *@param string param1 the index of the entry in mass edit or '0' if single album
 *@param object param2 the album object
 *@since 1.1.3
 */
function printAlbumEditForm($index, $album) {
	// Note: This is some pretty confusing spaghetti code with all the echo statements.
	// Please refactor it so the HTML is readable and easily editable.
	// FYI: It's perfectly acceptable to drop out of php-parsing mode in a function.
	// See the move/copy/rename block for an example.

	global $sortby, $gallery, $_zp_loggedin, $mcr_albumlist, $albumdbfields, $imagedbfields;
	$tagsort = getTagOrder();
	if ($index == 0) {
		if (isset($saved)) {
			$album->setSubalbumSortType('manual');
		}
		$suffix = $prefix = '';
	} else {
		$prefix = "$index-";
		$suffix = "_$index";
		echo "<p><em><strong>" . $album->name . "</strong></em></p>";
	}

	echo "\n<input type=\"hidden\" name=\"" . $prefix . "folder\" value=\"" . $album->name . "\" />";
	echo "\n".'<input type="hidden" name="tagsort" value='.$tagsort.' />';
	echo "\n<table>";
	echo "\n<td width = \"60%\">\n<table>\n<tr>";
	echo "\n<tr>";
	echo "<td align=\"right\" valign=\"top\" width=\"150\">".gettext("Album Title").": </td>";
	echo '<td>';
	print_language_string_list($album->get('title'), $prefix."albumtitle", false);
	echo "</td></tr>\n";
	echo '<tr><td></td>';
	$hc = $album->get('hitcounter');
	if (empty($hc)) { $hc = '0'; }
	echo "<td>";
	echo sprintf(gettext("Hit counter: %u"), $hc) . " <input type=\"checkbox\" name=\"reset_hitcounter\"> Reset";
	$tv = $album->get('total_value');
	$tc = $album->get('total_votes');
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	if ($tc > 0) {
		$hc = $tv/$tc;
		printf(gettext('Rating: <strong>%u</strong>'), $hc);
		echo "<label for=\"".$prefix."reset_rating\"><input type=\"checkbox\" id=\"".$prefix."reset_rating\" name=\"".$prefix."reset_rating\" value=1> ".gettext("Reset")."</label> ";
	} else {
		echo gettext("Rating: Unrated");
	}
	echo "</td>";
	echo '</tr>';
	echo "\n<tr><td align=\"right\" valign=\"top\">".gettext("Album Description:")." </td> <td>";
	print_language_string_list($album->get('desc'), $prefix."albumdesc", true, NULL, 'texteditor');
	echo "</td></tr>";
	echo "\n<tr><td align=\"right\" value=\"top\">".gettext("Album guest user:").'</td>';
	echo "\n<td><input type='text' size='48' name='".$prefix."albumuser' value='".$album->getUser()."' /></td></tr>";
	echo "\n<tr>";
	echo "\n<td align=\"right\">".gettext("Album password:")." <br/>".gettext("repeat:")." </td>";
	echo "\n<td>";
	$x = $album->getPassword();

	if (!empty($x)) {
		$x = '			 ';
	}

	echo "\n<input type=\"password\" size=\"48\" name=\"".$prefix."albumpass\"";
	echo "\nvalue=\"" . $x . '" /><br/>';
	echo "\n<input type=\"password\" size=\"48\" name=\"".$prefix."albumpass_2\"";
	echo "\nvalue=\"" . $x . '" />';
	echo "\n</td>";
	echo "\n</tr>";
	echo "\n<tr><td align=\"right\" valign=\"top\">".gettext("Password hint:")." </td> <td>";
	print_language_string_list($album->get('password_hint'), $prefix."albumpass_hint", false);
	echo "</td></tr>";

	$d = $album->getDateTime();
	if ($d == "0000-00-00 00:00:00") {
		$d = "";
	}

	echo "\n<tr><td align=\"right\" valign=\"top\">".gettext("Date:")." </td> <td width = \"400\"><input type=\"text\" size='48' name=\"".$prefix."albumdate\" value=\"" . $d . '" /></td></tr>';
	echo "\n<tr><td align=\"right\" valign=\"top\">".gettext("Location:")." </td> <td>";
	print_language_string_list($album->get('place'), $prefix."albumplace", false);
	echo "</td></tr>";
	echo "\n<tr><td align=\"right\" valign=\"top\">".gettext("Custom data:").	"</td><td>";
	print_language_string_list($album->get('custom_data'), $prefix."album_custom_data", true);
	echo "</td></tr>";
	$sort = $sortby;
	if (!$album->isDynamic()) {
		$sort[gettext('Manual')] = 'manual';
	}
	$sort[gettext('Custom')] = 'custom';
	echo "\n<tr>";
	echo "\n<td align=\"right\" valign=\"top\">".gettext("Sort subalbums by:")." </td>";
	echo "\n<td>";

	// script to test for what is selected
	$javaprefix = 'js_'.preg_replace("/[^a-z0-9_]/","",strtolower($prefix));

	?>
	<table>
		<tr>
			<td>
			<select id="sortselect" name="<?php echo $prefix; ?>subalbumsortby" onchange="update_direction(this,'<?php echo $javaprefix; ?>album_direction_div','<?php echo $javaprefix; ?>album_custom_div')">
			<?php
			if (is_null($album->getParent())) {
				$globalsort = gettext("gallery album sort order");
			} else {
				$globalsort = gettext("parent album subalbum sort order");
			}
			echo "\n<option value =''>$globalsort</option>";
			$cvt = $type = strtolower($album->get('subalbum_sort_type'));
			generateListFromArray(array($type), $sort, false, true);
			?>
			</select>
			</td>
		<td>
	<?php
	if (($type == 'manual') || ($type == '')) {
		$dsp = 'none';
	} else {
		$dsp = 'block';
	}
	echo "\n<span id=\"".$javaprefix."album_direction_div\" style=\"display:".$dsp."\">";
	echo "&nbsp;".gettext("Descending")." <input type=\"checkbox\" name=\"".$prefix."album_sortdirection\" value=\"1\"";

	if ($album->getSortDirection('album')) {
		echo "CHECKED";
	}
	echo ">";
	echo '</span>';
	$flip = array_flip($sort);
	if (empty($type) || isset($flip[$type])) {
		$dsp = 'none';
	} else {
		$dsp = 'block';
	}
	?>
		</td>
	</tr>
	<script type="text/javascript">
		$(function () {
			$('#<?php echo $javaprefix; ?>customalbumsort').tagSuggest({
				tags: [<?php echo $albumdbfields; ?>]
			});
		});
	</script>
	<tr>
		<td colspan="2">
		<span id="<?php echo $javaprefix; ?>album_custom_div" class="customText" style="display:<?php echo $dsp; ?>">
		<?php echo gettext('custom fields:') ?>
		<input id="<? echo $javaprefix; ?>customalbumsort" name="<? echo $prefix; ?>customalbumsort" type="text" value="<?php echo $cvt; ?>"></input>
		</span>
	
		</td>
	</tr>
</table>
	<?php
	echo "\n</td>";
	echo "\n</tr>";

	echo "\n<tr>";
	echo "\n<td align=\"right\" valign=\"top\">".gettext("Sort images by:")." </td>";
	echo "\n<td>";

	// script to test for what is selected
	$javaprefix = 'js_'.preg_replace("/[^a-z0-9_]/","",strtolower($prefix));

	?>
	<table>
		<tr>
			<td>
			<select id="sortselect" name="<?php echo $prefix; ?>sortby" onchange="update_direction(this,'<?php echo $javaprefix; ?>image_direction_div','<?php echo $javaprefix; ?>image_custom_div')">
			<?php
			if (is_null($album->getParent())) {
				$globalsort = gettext("gallery default image sort order");
			} else {
				$globalsort = gettext("parent album image sort order");
			}
			echo "\n<option value =''>$globalsort</option>";
			$cvt = $type = strtolower($album->get('sort_type'));
			generateListFromArray(array($type), $sort, false, true);
			?>
			</select>
			</td>
		<td>
	<?php
	if (($type == 'manual') || ($type == '')) {
		$dsp = 'none';
	} else {
		$dsp = 'block';
	}
	echo "\n<span id=\"".$javaprefix."image_direction_div\" style=\"display:".$dsp."\">";
	echo "&nbsp;".gettext("Descending")." <input type=\"checkbox\" name=\"".$prefix."image_sortdirection\" value=\"1\"";
	if ($album->getSortDirection('image')) {
		echo "CHECKED";
	}
	echo ">";
	echo '</span>';
	$flip = array_flip($sort);
	if (empty($type) || isset($flip[$type])) {
		$dsp = 'none';
	} else {
		$dsp = 'block';
	}
	?>
			</td>
		</tr>
		<script type="text/javascript">
			$(function () {
				$('#<?php echo $javaprefix; ?>customimagesort').tagSuggest({
					tags: [<?php echo $imagedbfields; ?>]
				});
			});
		</script>
		<tr>
			<td colspan="2">
			<span id="<?php echo $javaprefix; ?>image_custom_div" class="customText" style="display:<?php echo $dsp; ?>">
			<?php echo gettext('custom fields:') ?>
			<input id="<?php echo $javaprefix; ?>customimagesort" name="<?php echo $prefix; ?>customimagesort" type="text" value="<?php echo $cvt; ?>"></input>
			</span>
			</td>
		</tr>
	</table>
	<?php
	echo "\n</td>";
	echo "\n</tr>";

	echo "\n<tr>";
	echo "\n<td align=\"right\" valign=\"top\"></td><td><input type=\"checkbox\" name=\"" .
	$prefix."allowcomments\" value=\"1\"";
	if ($album->getCommentsAllowed()) {
		echo "CHECKED";
	}
	echo "> ".gettext("Allow Comments")." ";
	echo "<input type=\"checkbox\" name=\"" .
	$prefix."Published\" value=\"1\"";
	if ($album->getShow()) {
		echo "CHECKED";
	}
	echo "> ".gettext("Published")." ";
	echo "</td>\n</tr>";
	if (is_null($album->getParent())) {
		echo "\n<tr>";
		echo "\n<td align=\"right\" valign=\"top\">".gettext("Album theme:")." </td> ";
		echo "\n<td>";
		echo "\n<select id=\"album_theme\" class=\"album_theme\" name=\"".$prefix."album_theme\" ";
		if (!($_zp_loggedin & (ADMIN_RIGHTS | THEMES_RIGHTS))) echo "DISABLED ";
		echo ">";
		$themes = $gallery->getThemes();
		$oldtheme = $album->getAlbumTheme();
		if (empty($oldtheme)) {
			echo "<option value = \"\" selected=\"SELECTED\" />";
		} else {
			echo "<option value = \"\" />";
		}
		echo "</option>";

		foreach ($themes as $theme=>$themeinfo) {
			echo "<option value = \"$theme\"";
			if ($oldtheme == $theme) {
				echo "selected = \"SELECTED\"";
			}
			echo "	/>";
			echo $themeinfo['name'];
			echo "</option>";
		}
		echo "\n</select>";
		echo "\n</td>";
		echo "\n</tr>";
	}

	echo "\n</table>\n</td>";
	echo "\n<td valign=\"top\">";

	$bglevels = array('#fff','#f8f8f8','#efefef','#e8e8e8','#dfdfdf','#d8d8d8','#cfcfcf','#c8c8c8');

	/* **************** Move/Copy/Rename ****************** */
	?>

	<label for="a-<?php echo $prefix; ?>move" style="padding-right: .5em">
		<input type="radio" id="a-<?php echo $prefix; ?>move" name="a-<?php echo $prefix; ?>MoveCopyRename" value="move"
			onclick="toggleAlbumMoveCopyRename('<?php echo $prefix; ?>', 'movecopy');"/>
		<?php echo gettext("Move");?>
	</label>
	<label for="a-<?php echo $prefix; ?>copy" style="padding-right: .5em">
		<input type="radio" id="a-<?php echo $prefix; ?>copy" name="a-<?php echo $prefix; ?>MoveCopyRename" value="copy"
			onclick="toggleAlbumMoveCopyRename('<?php echo $prefix; ?>', 'movecopy');"/>
		<?php echo gettext("Copy");?>
	</label>
	<label for="a-<?php echo $prefix; ?>rename" style="padding-right: .5em">
		<input type="radio" id="a-<?php echo $prefix; ?>rename" name="a-<?php echo $prefix; ?>MoveCopyRename" value="rename"
			onclick="toggleAlbumMoveCopyRename('<?php echo $prefix; ?>', 'rename');"/>
		<?php echo gettext("Rename Folder");?>
	</label>


	<div id="a-<?php echo $prefix; ?>movecopydiv" style="padding-top: .5em; padding-left: .5em; display: none;">
		<?php echo gettext("to"); ?>: <select id="a-<?php echo $prefix; ?>albumselectmenu" name="a-<?php echo $prefix; ?>albumselect" onChange="">
			<option value="" selected="selected">/</option>
			<?php
				foreach ($mcr_albumlist as $fullfolder => $albumtitle) {
					$singlefolder = $fullfolder;
					$saprefix = "";
					$salevel = 0;
					$selected = "";
					if ($album->name == $fullfolder) {
						continue;
					}
					// Get rid of the slashes in the subalbum, while also making a subalbum prefix for the menu.
					while (strstr($singlefolder, '/') !== false) {
						$singlefolder = substr(strstr($singlefolder, '/'), 1);
						$saprefix = "&nbsp; &nbsp;&nbsp;" . $saprefix;
						$salevel++;
					}
					echo '<option value="' . $fullfolder . '"' . ($salevel > 0 ? ' style="background-color: '.$bglevels[$salevel].';"' : '')
					. "$selected>". $saprefix . $singlefolder ."</option>\n";
				}
			?>
		</select>
		<p style="text-align: right;">
			<a href="javascript:toggleAlbumMoveCopyRename('<?php echo $prefix; ?>', '');"><?php echo gettext("Cancel");?></a>
		</p>
	</div>
	<div id="a-<?php echo $prefix; ?>renamediv" style="padding-top: .5em; padding-left: .5em; display: none;">
		<?php echo gettext("to"); ?>: <input name="a-<?php echo $prefix; ?>renameto" type="text" size="35" value="<?php echo basename($album->name);?>"/><br />
		<p style="text-align: right; padding: .25em 0px;">
			<a href="javascript:toggleAlbumMoveCopyRename('<?php echo $prefix; ?>', '');"><?php echo gettext("Cancel");?></a>
		</p>
	</div>

	<br/><br />

	<?php

	echo gettext("Tags:");
	$tagsort = getTagOrder();
	tagSelector($album, 'tags_'.$prefix, false, $tagsort);
	echo "\n</td>\n</tr>";

	echo "\n</table>";

	echo  "\n<table>";
	if ($album->isDynamic()) {
		echo "\n<tr>";
		echo "\n<td> </td>";
		echo "\n<td align=\"right\" valign=\"top\" width=\"150\">".gettext("Dynamic album search:")."</td>";
		echo "\n<td>";
		echo "\n<table class=\"noinput\">";
		echo "\n<tr><td >" . urldecode($album->getSearchParams()) . "</td></tr>";
		echo "\n</table>";
		echo "\n</td>";
		echo "\n</tr>";
	}
	echo "\n<tr>";
	echo "\n<td> </td>";
	echo "\n<td align=\"right\" valign=\"top\" width=\"150\">".gettext("Thumbnail:")." </td> ";
	echo "\n<td>";
	$showThumb = getOption('thumb_select_images');
	if ($showThumb) echo "\n<script type=\"text/javascript\">updateThumbPreview(document.getElementById('thumbselect'));</script>";
	echo "\n<select id=\"\"";
	if ($showThumb) echo " class=\"thumbselect\" onChange=\"updateThumbPreview(this)\"";
	echo " name=\"".$prefix."thumb\">";
	$thumb = $album->get('thumb');
	echo "\n<option";
	if ($showThumb) echo " class=\"thumboption\" value=\"\" style=\"background-color:#B1F7B6\"";
	if ($thumb === '1') {
		echo " selected=\"selected\"";
	}
	echo ' value="1">'.gettext('most recent');
	echo '</option>';
	echo "\n<option";
	if ($showThumb) echo " class=\"thumboption\" value=\"\" style=\"background-color:#B1F7B6\"";
	if (empty($thumb) && $thumb !== '1') {
		echo " selected=\"selected\"";
	}
	echo ' value="">'.gettext('randomly selected');
	echo '</option>';
	if ($album->isDynamic()) {
		$params = $album->getSearchParams();
		$search = new SearchEngine();
		$search->setSearchParams($params);
		$images = $search->getImages(0);
		$thumb = $album->get('thumb');
		$imagelist = array();
		foreach ($images as $imagerow) {
			$folder = $imagerow['folder'];
			$filename = $imagerow['filename'];
			$imagelist[] = '/'.$folder.'/'.$filename;
		}
		if (count($imagelist) == 0) {
			$subalbums = $search->getAlbums(0);
			foreach ($subalbums as $folder) {
				$newalbum = new Album($gallery, $folder);
				if (!$newalbum->isDynamic()) {
					$images = $newalbum->getImages(0);
					foreach ($images as $filename) {
						$imagelist[] = '/'.$folder.'/'.$filename;
					}
				}
			}
		}
		foreach ($imagelist as $imagepath) {
			$list = explode('/', $imagepath);
			$filename = $list[count($list)-1];
			unset($list[count($list)-1]);
			$folder = implode('/', $list);
			$albumx = new Album($gallery, $folder);
			$image = newImage($albumx, $filename);
			$selected = ($imagepath == $thumb);
			echo "\n<option";
			if ($showThumb) {
				echo " class=\"thumboption\"";
				echo " style=\"background-image: url(" . $image->getThumb() .	"); background-repeat: no-repeat;\"";
			}
			echo " value=\"".$imagepath."\"";
			if ($selected) {
				echo " selected=\"selected\"";
			}
			echo ">" . $image->getTitle();
			echo  " ($imagepath)";
			echo "</option>";
		}
	} else {
		$images = $album->getImages();
		if (count($images) == 0 && count($album->getSubalbums()) > 0) {
			$imagearray = array();
			$albumnames = array();
			$strip = strlen($album->name) + 1;
			$subIDs = getAllSubAlbumIDs($album->name);
			if(!is_null($subIDs)) {
				foreach ($subIDs as $ID) {
					$albumnames[$ID['id']] = $ID['folder'];
					$query = 'SELECT `id` , `albumid` , `filename` , `title` FROM '.prefix('images').' WHERE `albumid` = "'.
					$ID['id'] .'"';
					$imagearray = array_merge($imagearray, query_full_array($query));
				}
				foreach ($imagearray as $imagerow) {
					$filename = $imagerow['filename'];
					$folder = $albumnames[$imagerow['albumid']];
					$imagepath = substr($folder, $strip).'/'.$filename;
					if (substr($imagepath, 0, 1) == '/') { $imagepath = substr($imagepath, 1); }
					$albumx = new Album($gallery, $folder);
					$image = newImage($albumx, $filename);
					if (is_valid_image($filename)) {
						$selected = ($imagepath == $thumb);
						echo "\n<option";
						if (getOption('thumb_select_images')) {
							echo " class=\"thumboption\"";
							echo " style=\"background-image: url(" . $image->getThumb() . "); background-repeat: no-repeat;\"";
						}
						echo " value=\"".$imagepath."\"";
						if ($selected) {
							echo " selected=\"selected\"";
						}
						echo ">" . $image->getTitle();
						echo  " ($imagepath)";
						echo "</option>";
					}
				}
			}
		} else {
			foreach ($images as $filename) {
				$image = newImage($album, $filename);
				$selected = ($filename == $album->get('thumb'));
				if (is_valid_image($filename)) {
					echo "\n<option";
					if (getOption('thumb_select_images')) {
						echo " class=\"thumboption\"";
						echo " style=\"background-image: url(" . $image->getThumb() . "); background-repeat: no-repeat;\"";
					}
					echo " value=\"" . $filename . "\"";
					if ($selected) {
						echo " selected=\"selected\"";
					}
					echo ">" . $image->getTitle();
					if ($filename != $image->getTitle()) {
						echo  " ($filename)";
					}
					echo "</option>";
				}
			}
		}
	}
	echo "\n</select>";
	echo "\n</td>";
	echo "\n</tr>";
	echo "\n</table>";

	echo "\n<input type=\"submit\" value=\"".gettext("save album")."\" />";

}
/**
 * puts out the maintenance buttons for an album
 *
 * @param object $album is the album being emitted
 */
function printAlbumButtons($album) {
	if ($album->getNumImages() > 0) {
	?>
	<table class="buttons">
	<tr>
	<?php
		echo "\n<td valign=\"top\">";
		echo "</form>";
		echo "<form name=\"clear-cache\" action=\"?action=clear_cache\"" . " method=\"post\">";
		echo "<input type=\"hidden\" name=\"action\" value=\"clear_cache\">";
		echo "<input type=\"hidden\" name=\"album\" value=" . urlencode($album->name) . ">";
		echo "<button type=\"submit\" class=\"tooltip\" id='edit_hitcounter' title=\"".gettext("Clears the album's cached images.")."\"><img src=\"images/edit-delete.png\" style=\"border: 0px;\" /> ".gettext("Clear album cache")."</button>";
		echo "</form>";

		echo "\n<td valign=\"top\">";
		echo "<form name=\"cache_images\" action=\"admin-cache-images.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"album\" value=" . urlencode($album->name) . ">";
		echo "<input type=\"hidden\" name=\"return\" value=" . urlencode($album->name) . ">";
		echo "<button type=\"submit\" class=\"tooltip\" id='edit_cache' title=\"".gettext("Cache newly uploaded images.")."\"><img src=\"images/cache1.png\" style=\"border: 0px;\" />";
		echo " ".gettext("Pre-Cache Images")."</Button>";
		echo "</form>\n</td>";

		echo "\n<td valign=\"top\">";
		echo "<form name=\"refresh_metadata\" action=\"admin-refresh-metadata.php\"?album=" . urlencode($album->name) . "\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"album\" value=" . urlencode($album->name) . ">";
		echo "<input type=\"hidden\" name=\"return\" value=" . urlencode($album->name) . ">";
		echo "<button type=\"submit\" class=\"tooltip\" id='edit_refresh' title=\"".gettext("Forces a refresh of the EXIF and IPTC data for all images in the album.")."\"><img src=\"images/redo.png\" style=\"border: 0px;\" /> ".gettext("Refresh Metadata")."</button>";
		echo "</form>";
		echo "\n</td>";

		echo "\n<td valign=\"top\">";
		echo "</form>";
		echo "<form name=\"reset_hitcounters\" action=\"?action=reset_hitcounters\"" . " method=\"post\">";
		echo "<input type=\"hidden\" name=\"action\" value=\"reset_hitcounters\">";
		echo "<input type=\"hidden\" name=\"albumid\" value=" . $album->getAlbumID() . ">";
		echo "<input type=\"hidden\" name=\"album\" value=" . urlencode($album->name) . ">";
		echo "<button type=\"submit\" class=\"tooltip\" id='edit_hitcounter' title=\"".gettext("Resets all hitcounters in the album.")."\"><img src=\"images/reset1.png\" style=\"border: 0px;\" /> ".gettext("Reset hitcounters")."</button>";
		echo "</form>";
?>
			</tr>
		</table>
<?php		
	}
}
/**
 * puts out a row in the edit album table
 *
 * @param object $album is the album being emitted
 **/
function printAlbumEditRow($album) {
	echo "\n<div id=\"id_" . $album->getAlbumID() . '">';
	echo '<table cellspacing="0" width="100%">';
	echo "\n<tr>";
	echo '<td class="handle"><img src="images/drag_handle.png" style="border: 0px;" alt="Drag the album '."'".$album->name."'".'" /></td>';
	echo '<td style="text-align: left;" width="80">';
	$thumb = $album->getAlbumThumb();
	if (strpos($thumb, '_%7B') !== false) { // it is the default image
		$thumb = 'images/imageDefault.png';
	}
	if (getOption('thumb_crop')) {
		$w = round(getOption('thumb_crop_width')/2);
		$h = round(getOption('thumb_crop_height')/2);
	} else {
		$w = $h = round(getOption('thumb_size')/2);
	}
	echo '<a href="?page=edit&album=' . urlencode($album->name) .'" title="'.sprintf(gettext('Edit this album:%s'), $album->name) .
 			'"><img src="' . $thumb . '" width="'.$w.'" height="'.$h.'" /></a>';
	echo "</td>\n";
	echo '<td  style="text-align: left;font-size:110%;" width="300"> <a href="?page=edit&album=' . urlencode($album->name) .
 			'" title="'.sprintf(gettext('Edit this album: %s'), $album->name) . '">' . $album->getTitle() . '</a>';
	echo "</td>\n";

	if ($album->isDynamic()) {
		$si = "Dynamic";
		$sa = '';
	} else {
		$ci = count($album->getImages());
		if ($ci > 0) {
			if ($ci > 1) {
				$si = sprintf(gettext('%u images'),$ci);
			}	else {
				$si = gettext('1 image');
			}
		} else {
			$si = gettext('no images');
		}
		if ($ci > 0) {
			$si = '<a href="?page=edit&album=' . urlencode($album->name) .'&tab=imageinfo" title="'.gettext('Subalbum List').'">'.$si.'</a>';
		}
		$ca = count($album->getSubalbums());
		if ($ca > 0) {
			if ($ca > 1) {
				$sa = sprintf(gettext("%u albums"), $ca);
			} else {
				$sa = gettext("1 album");
			}
		} else {
			$sa = '&nbsp;';
		}
		if ($ca > 0) {
			$sa = '<a href="?page=edit&album=' . urlencode($album->name) .'&tab=subalbuminfo" title="'.gettext('Subalbum List').'">'.$sa.'</a>';
		}
	}
	echo "<td style=\"text-align: right;\" width=\"80\">" . $sa . "</td>";
	echo "<td style=\"text-align: right;\" width=\"80\">" . $si . "</td>";

	$wide='40px';
	echo "\n<td><table width='100%'><tr>\n<td>";
	echo "\n<td style=\"text-align:center;\" width='$wide';>";

	$pwd = $album->getPassword();
	if (!empty($pwd)) {
		echo '<a title="'.gettext('Password protected').'"><img src="images/lock.png" style="border: 0px;" alt="'.gettext('Password protected').'" /></a>';
	}

	echo "</td>\n<td style=\"text-align:center;\" width='$wide';>";
	if ($album->getShow()) {
		echo '<a class="publish" href="?action=publish&value=0&amp;album=' . urlencode($album->name) .
 				'" title="'.sprintf(gettext('Unpublish the album %s'), $album->name) . '">';
		echo '<img src="images/pass.png" style="border: 0px;" alt="'.gettext('Published').'" /></a>';
	} else {
		echo '<a class="publish" href="?action=publish&value=1&amp;album=' . urlencode($album->name) .
 				'" title="'.sprintf(gettext('Publish the album %s'), $album->name) . '">';
		echo '<img src="images/action.png" style="border: 0px;" alt="Publish the album ' . $album->name . '" /></a>';
	}

	echo "</td>\n<td style=\"text-align:center;\" width='$wide';>";
	echo '<a class="cache" href="admin-cache-images.php?page=edit&amp;album='.urlencode($album->name)."&return=*".urlencode(dirname($album->name)).
 			'" title="'.sprintf(gettext('Pre-cache images in %s'), $album->name) . '">';
	echo '<img src="images/cache1.png" style="border: 0px;" alt="'.sprintf(gettext('Cache the album %s'), $album->name) . '" /></a>';

	echo "</td>\n<td style=\"text-align:center;\" width='$wide';>";
	echo '<a class="warn" href="admin-refresh-metadata.php?page=edit&amp;album=' . urlencode($album->name) . "&return=*".urlencode(dirname($album->name)) .
 			'" title="'.sprintf(gettext('Refresh metadata for the album %s'), $album->name) . '">';
	echo '<img src="images/redo1.png" style="border: 0px;" alt="'.sprintf(gettext('Refresh image metadata in the album %s'), $album->name) . '" /></a>';

	echo "</td>\n<td style=\"text-align:center;\" width='$wide';>";
	echo '<a class="reset" href="?action=reset_hitcounters&amp;albumid='.$album->getAlbumID().'&amp;album='.urlencode($album->name).'&subalbum=true" title="'.sprintf(gettext('Reset hitcounters for album %s'), $album->name) . '">';
	echo '<img src="images/reset.png" style="border: 0px;" alt="'.sprintf(gettext('Reset hitcounters for the album %s'), $album->name) . '" /></a>';

	echo "</td>\n<td style=\"text-align:center;\" width='$wide';>";
	echo "<a class=\"delete\" href=\"javascript: confirmDeleteAlbum('?page=edit&amp;action=deletealbum&amp;album=" . urlencode(urlencode($album->name)) .
			"','".js_encode(gettext("Are you sure you want to delete this entire album?"))."','".js_encode(gettext("Are you Absolutely Positively sure you want to delete the album? THIS CANNOT BE UNDONE!")).
			"');\" title=\"".sprintf(gettext("Delete the album %s"), js_encode($album->name)) . "\">";
	echo '<img src="images/fail.png" style="border: 0px;" alt="'.sprintf(gettext('Delete the album %s'), js_encode($album->name)) . '" /></a>';
	echo "</td>\n</tr></table>\n</td>";

	echo '</tr>';
	echo '</table>';
	echo "</div>\n";
}

/**
 * processes the post from the above
 *@param int param1 the index of the entry in mass edit or 0 if single album
 *@param object param2 the album object
 *@return string error flag if passwords don't match
 *@since 1.1.3
 */
function processAlbumEdit($index, $album) {
	if ($index == 0) {
		$prefix = '';
	} else {
		$prefix = "$index-";
	}
	$tagsprefix = 'tags_'.$prefix;
	$notify = '';
	$album->setTitle(process_language_string_save($prefix.'albumtitle', 2));
	$album->setDesc(process_language_string_save($prefix.'albumdesc', 1));
	$tags = array();
	for ($i=0; $i<4; $i++) {
		if (isset($_POST[$tagsprefix.'new_tag_value_'.$i])) {
			$tag = trim(strip($_POST[$tagsprefix.'new_tag_value_'.$i]));
			unset($_POST[$tagsprefix.'new_tag_value_'.$i]);
			if (!empty($tag)) {
				$tags[] = $tag;
			}
		}
	}
	$l = strlen($tagsprefix);
	foreach ($_POST as $key => $value) {
		$key = postIndexDecode($key);
		if (substr($key, 0, $l) == $tagsprefix) {
			if ($value) {
				$tags[] = substr($key, $l);
			}
		}
	}
	$tags = array_unique($tags);
	$album->setTags($tags);
	$album->setDateTime(strip($_POST[$prefix."albumdate"]));
	$album->setPlace(process_language_string_save($prefix.'albumplace', 3));
	if (isset($_POST[$prefix.'thumb'])) $album->setAlbumThumb(strip($_POST[$prefix.'thumb']));
	$album->setShow(isset($_POST[$prefix.'Published']));
	$album->setCommentsAllowed(isset($_POST[$prefix.'allowcomments']));
	$sorttype = strtolower(sanitize($_POST[$prefix.'sortby'], 3));
	if ($sorttype == 'custom') $sorttype = strtolower(sanitize($_POST[$prefix.'customimagesort'],3));
	$album->setSortType($sorttype);
	if ($sorttype == 'manual') {
		$album->setSortDirection('image', 0);
	} else {
		if (empty($sorttype)) {
			$direction = 0;
		} else {
			$direction = isset($_POST[$prefix.'image_sortdirection']);
		}
		$album->setSortDirection('image', $direction);
	}
	$sorttype = strtolower(sanitize($_POST[$prefix.'subalbumsortby'],3));
	if ($sorttype == 'custom') $sorttype = strtolower(sanitize($_POST[$prefix.'customalbumsort'],3));
	$album->setSubalbumSortType($sorttype);
	if ($sorttype == 'manual') {
		$album->setSortDirection('album', 0);
	} else {
		$album->setSortDirection('album', isset($_POST[$prefix.'album_sortdirection']));
	}
	if (isset($_POST[$prefix.'reset_hitcounter'])) {
		$album->set('hitcounter',0);
	}
	if (isset($_POST[$prefix.'reset_rating'])) {
		$album->set('total_value', 0);
		$album->set('total_votes', 0);
		$album->set('used_ips', 0);
	}
	$olduser = $album->getUser();
	$newuser = $_POST[$prefix.'albumuser'];
	$pwd = trim($_POST[$prefix.'albumpass']);
	$fail = '';
	if (($olduser != $newuser)) {
		if ($pwd != $_POST[$prefix.'albumpass_2']) {
			$pwd2 = trim($_POST[$prefix.'albumpass_2']);
			$_POST[$prefix.'albumpass'] = $pwd; // invalidate password, user changed without password beign set
			if (!empty($newuser) && empty($pwd) && empty($pwd2)) $fail = '&mismatch=user';
		}
	}
	if ($_POST[$prefix.'albumpass'] == $_POST[$prefix.'albumpass_2']) {
		$album->setUser($newuser);
		if (empty($pwd)) {
			if (empty($_POST[$prefix.'albumpass'])) {
				$album->setPassword(NULL);  // clear the gallery password
			}
		} else {
			$album->setPassword($pwd);
		}
	} else {
		if (empty($fail)) {
			$notify = '&mismatch=album';
		} else {
			$notify = $fail;
		}
	}
	$oldtheme = $album->getAlbumTheme();
	if (isset($_POST[$prefix.'album_theme'])) {
		$newtheme = strip($_POST[$prefix.'album_theme']);
		if ($oldtheme != $newtheme) {
			$album->setAlbumTheme($newtheme);
		}
	}
	$album->setPasswordHint(process_language_string_save($prefix.'albumpass_hint', 3));
	$album->setCustomData(process_language_string_save($prefix.'album_custom_data', 1));
	$album->save();

	// Move/Copy/Rename the album after saving.
	$movecopyrename_action = '';
	if (isset($_POST['a-'.$prefix.'MoveCopyRename'])) {
		$movecopyrename_action = sanitize($_POST['a-'.$prefix.'MoveCopyRename'],3);
	}

	if ($movecopyrename_action == 'move') {
		$dest = UTF8ToFileSystem(sanitize_path($_POST['a'.$prefix.'-albumselect'],3));
		// Append the album name.
		$dest = ($dest ? $dest . '/' : '') . (strpos($album->name, '/') === FALSE ? $album->name : basename($album->name));
		if ($dest && $dest != $album->name) {
			if ($returnalbum = $album->moveAlbum($dest)) {
				// A slight hack to redirect to the new album after moving.
				$_GET['album'] = $returnalbum;
			} else {
				$notify .= "&mcrerr=1";
			}
		} else {
			// Cannot move album to same album.
		}
	} else if ($movecopyrename_action == 'copy') {
		$dest = UTF8ToFileSystem(sanitize_path($_POST['a'.$prefix.'-albumselect'],3));
		// Append the album name.
		$dest = ($dest ? $dest . '/' : '') . (strpos($album->name, '/') === FALSE ? $album->name : basename($album->name));
		if ($dest && $dest != $album->name) {
			if(!$album->copyAlbum($dest)) {
				$notify .= "&mcrerr=1";
			}
		} else {
			// Cannot copy album to existing album.
			// Or, copy with rename?
		}
	} else if ($movecopyrename_action == 'rename') {
		$renameto = UTF8ToFileSystem(sanitize_path($_POST['a'.$prefix.'-renameto'],3));
		$renameto = str_replace(array('/', '\\'), '', $renameto);
		if (dirname($album->name) != '.') {
			$renameto = dirname($album->name) . '/' . $renameto;
		}
		if ($renameto != $album->name) {
			if ($returnalbum = $album->renameAlbum($renameto)) {
				// A slight hack to redirect to the new album after moving.
				$_GET['album'] = $returnalbum;
			} else {
				$notify .= "&mcrerr=1";
			}
		}
	}

	return $notify;
}

/**
 * Searches the zenphoto.org home page for the current zenphoto download
 * locates the version number of the download and compares it to the version
 * we are running.
 *
 *@rerturn string If there is a more current version on the WEB, returns its version number otherwise returns FALSE
 *@since 1.1.3
 */
function checkForUpdate() {
	global $_zp_WEB_Version;
	if (isset($_zp_WEB_Version)) { return $_zp_WEB_Version; }
	$c = ZENPHOTO_VERSION;
	$v = @file_get_contents('http://www.zenphoto.org/files/LATESTVERSION');
	if (empty($v)) {
		$_zp_WEB_Version = 'X';
	} else {
		$pot = array(1000000000, 10000000, 100000, 1);
		$wv = explode('.', $v);
		$wvd = 0;
		foreach ($wv as $i => $d) {
			$wvd = $wvd + $d * $pot[$i];
		}
		$cv = explode('.', $c);
		$cvd = 0;
		foreach ($cv as $i => $d) {
			$cvd = $cvd + $d * $pot[$i];
		}
		if ($wvd > $cvd) {
			$_zp_WEB_Version = $v;
		} else {
			$_zp_WEB_Version = '';
		}
	}
	Return $_zp_WEB_Version;
}

/**
 * Gets an array of comments for the current admin
 *
 * @param int $number how many comments desired
 * @return array
 */
function fetchComments($number) {
	if ($number) {
		$limit = " LIMIT $number";
	} else {
		$limit = '';
	}

	global $_zp_loggedin;
	$comments = array();
	if ($_zp_loggedin & ADMIN_RIGHTS) {
		$sql = "SELECT `id`, `name`, `website`, `type`, `ownerid`,"
		. " (date + 0) AS date, `comment`, `email`, `inmoderation`, `ip`, `private`, `anon` FROM ".prefix('comments')
		. " ORDER BY id DESC$limit";
		$comments = query_full_array($sql);
	} else  if ($_zp_loggedin & (COMMENT_RIGHTS)) {
		$albumlist = getManagedAlbumList();
		$albumIDs = array();
		foreach ($albumlist as $albumname) {
			$subalbums = getAllSubAlbumIDs($albumname);
			foreach($subalbums as $ID) {
				$albumIDs[] = $ID['id'];
			}
		}
		if (count($albumIDs) > 0) {
			$sql = "SELECT  `id`, `name`, `website`, `type`, `ownerid`,"
			." (`date` + 0) AS date, `comment`, `email`, `inmoderation`, `ip` "
			." FROM ".prefix('comments')." WHERE ";

			$sql .= " (`type`='albums' AND (";
			$i = 0;
			foreach ($albumIDs as $ID) {
				if ($i>0) { $sql .= " OR "; }
				$sql .= "(".prefix('comments').".ownerid=$ID)";
				$i++;
			}
			$sql .= ")) ";
			$sql .= " ORDER BY id DESC$limit";
			$albumcomments = query_full_array($sql);
			foreach ($albumcomments as $comment) {
				$comments[$comment['id']] = $comment;
			}
			$sql = "SELECT .".prefix('comments').".id as id, ".prefix('comments').".name as name, `website`, `type`, `ownerid`,"
			." (".prefix('comments').".date + 0) AS date, `comment`, `email`, `inmoderation`, `ip`, ".prefix('images').".`albumid` as albumid"
			." FROM ".prefix('comments').",".prefix('images')." WHERE ";
			
			$sql .= "(`type` IN (".zp_image_types("'").") AND (";
			$i = 0;
			foreach ($albumIDs as $ID) {
				if ($i>0) { $sql .= " OR "; }
				$sql .= "(".prefix('comments').".ownerid=".prefix('images').".id AND ".prefix('images')
				.".albumid=$ID)";
				$i++;
			}
			$sql .= "))";
			$sql .= " ORDER BY id DESC$limit";
			$imagecomments = query_full_array($sql);
			foreach ($imagecomments as $comment) {
				$comments[$comment['id']] = $comment;
			}
			krsort($comments);
			if ($number) {
				if ($number < count($comments)) {
					$comments = array_slice($comments, 0, $number);
				}
			}
		}
	}
	return $comments;
}

function adminPageNav($pagenum,$totalpages,$adminpage,$parms,$tab='') {
	if (empty($parms)) {
		$url = '?';
	} else {
		$url = $parms.'&amp;';
	}
	echo '<ul class="pagelist"><li class="prev">';
	if ($pagenum > 1) {
		echo '<a href='.$url.'subpage='.($p=$pagenum-1).$tab.' title="'.sprintf(gettext('page %u'),$p).'">'.'&laquo; '.gettext("Previous page").'</a>';
	} else {
		echo '<span class="disabledlink">&laquo; '.gettext("Previous page").'</span>';
	}
	echo "</li>";
	$start = max(1,$pagenum-7);
	$total = min($start+15,$totalpages+1);
	if ($start != 1) { echo "\n <li><a href=".$url.'subpage='.($p=max($start-8, 1)).$tab.' title="'.sprintf(gettext('page %u'),$p).'">. . .</a></li>'; }
	for ($i=$start; $i<$total; $i++) {
		if ($i == $pagenum) {
			echo "<li class=\"current\">".$i.'</li>';
		} else {
			echo '<li><a href='.$url.'subpage='.$i.$tab.' title="'.sprintf(gettext('page %u'),$i).'">'.$i.'</a></li>';
		}
	}
	if ($i < $totalpages) { echo "\n <li><a href=".$url.'subpage='.($p=min($pagenum+22,$totalpages+1)).$tab.' title="'.sprintf(gettext('page %u'),$p).'">. . .</a></li>'; }
	echo "<li class=\"next\">";
	if ($pagenum<$totalpages) {
		echo '<a href='.$url.'subpage='.($p=$pagenum+1).$tab.' title="'.sprintf(gettext('page %u'),$p).'">'.gettext("Next page").' &raquo;'.'</a>';
	} else {
		echo '<span class="disabledlink">'.gettext("Next page").' &raquo;</span>';
	}
	echo '</li></ul>';
}

$_zp_current_locale = NULL;
/**
 * Generates an editable list of language strings
 *
 * @param string $dbstring either a serialized languag string array or a single string
 * @param string $name the prefix for the label, id, and name tags
 * @param bool $textbox set to true for a textbox rather than a text field
 * @param string $locale optional locale of the translation desired
 * @param string $edit optional class
 */
function print_language_string_list($dbstring, $name, $textbox=false, $locale=NULL, $edit='') {
	global $_zp_languages, $_zp_active_languages, $_zp_current_locale;
	if (!empty($edit)) $edit = ' class="'.$edit.'"';
	if (is_null($locale)) {
		if (is_null($_zp_current_locale)) {
			$_zp_current_locale = getUserLocale();
			if (empty($_zp_current_locale)) $_zp_current_locale = 'en_US';
		}
		$locale = $_zp_current_locale;
	}
	if (preg_match('/^a:[0-9]+:{/', $dbstring)) {
		$strings = unserialize($dbstring);
	} else {
		$strings = array($locale=>$dbstring);
	}
	if (getOption('multi_lingual')) {
		if (is_null($_zp_active_languages)) {
			$_zp_active_languages = generateLanguageList();
		}
		$emptylang = array_flip($_zp_active_languages);
		unset($emptylang['']);
		natsort($emptylang);
		if ($textbox) $class = 'box'; else $class = '';
		echo "<ul class=\"language_string_list".$class."\">\n";
		$empty = true;
		foreach ($emptylang as $key=>$lang) {
			if (isset($strings[$key])) {
				$string = $strings[$key];
				if (!empty($string)) {
					unset($emptylang[$key]);
					$empty = false;
					echo '<li><label for="'.$name.'_'.$key.'">';
					echo $lang;
					if ($textbox) {
						echo "\n".'<textarea name="'.$name.'_'.$key.'"'.$edit.' cols="'.TEXTAREA_COLUMNS.'"	style="width: 310px" rows="6">'.$string.'</textarea>';
					} else {
						echo '<br /><input id="'.$name.'_'.$key.'" name="'.$name.'_'.$key.'" type="text" value="'.$string.'" style="width: 310px" size="'.TEXT_INPUT_SIZE.'" />';
					}
					echo "</label></li>\n";
				}
			}
		}
		if ($empty) {
			$element = $emptylang[$locale];
			unset($emptylang[$locale]);
			$emptylang = array_merge(array($locale=>$element), $emptylang);
		}
		foreach ($emptylang as $key=>$lang) {
			echo '<li><label for="'.$name.'_'.$key.'">';
			echo $lang;
			if ($textbox) {
				echo "\n".'<textarea name="'.$name.'_'.$key.'"'.$edit.' cols="'.TEXTAREA_COLUMNS.'"	style="width: 310px" rows="6"></textarea>';
			} else {
				echo '<br /><input id="'.$name.'_'.$key.'" name="'.$name.'_'.$key.'" type="text" value="" style="width: 310px" size="'.TEXT_INPUT_SIZE.'" />';
			}
			echo "</label></li>\n";

		}
		echo "</ul>\n";
	} else {
		if (empty($locale)) $locale = 'en_US';
		if (isset($strings[$locale])) {
			$dbstring = $strings[$locale];
		} else {
			$dbstring = array_shift($strings);
		}
		if ($textbox) {
			echo '<textarea name="'.$name.'_'.$locale.'"'.$edit.' cols="'.TEXTAREA_COLUMNS.'"	rows="6">'.$dbstring.'</textarea>';
		} else {
			echo '<input id="'.$name.'_'.$locale.'" name="'.$name.'_'.$locale.'" type="text" value="'.$dbstring.'" size="'.TEXT_INPUT_SIZE.'" />';
		}
	}
}

/**
 * process the post of a language string form
 *
 * @param string $name the prefix for the label, id, and name tags
 * @return string
 */
function process_language_string_save($name, $sanitize_level=3) {
	global $_zp_active_languages;
	if (is_null($_zp_active_languages)) {
		$_zp_active_languages = generateLanguageList();
	}
	$l = strlen($name)+1;
	$strings = array();
	foreach ($_POST as $key=>$value) {
		if (!empty($value) && preg_match('/^'.$name.'_[a-z]{2}_[A-Z]{2}$/', $key)) {
			$key = substr($key, $l);
			if (in_array($key, $_zp_active_languages)) {
				$strings[$key] = sanitize($value, $sanitize_level);
			}
		}
	}
	switch (count($strings)) {
		case 0:
			if (isset($_POST[$name])) {
				return sanitize($_POST[$name], $sanitize_level);
			} else {
				return '';
			}
		case 1:
			return array_shift($strings);
		default:
			return serialize($strings);
	}
}

/**
 * Returns the desired tagsort order (0 for alphabetic, 1 for most used)
 *
 * @return int
 */
function getTagOrder() {
	if (isset($_REQUEST['tagsort'])) {
		$tagsort = sanitize($_REQUEST['tagsort'], 0);
		setBoolOption('tagsort', $tagsort);
	} else {
		$tagsort = getOption('tagsort');
	}
	return $tagsort;
}

/**
 * Unzips an image archive
 *
 * @param file $file the archive
 * @param string $dir where the images go
 */
function unzip($file, $dir) { //check if zziplib is installed
	if(function_exists('zip_open')) {
		$zip = zip_open($file);
		if ($zip) {
			while ($zip_entry = zip_read($zip)) { // Skip non-images in the zip file.
				$fname = zip_entry_name($zip_entry);
				$soename = UTF8toFilesystem(seoFriendlyURL($fname));
				if (is_valid_image($soename) || is_valid_other_type($soename)) {
					if (zip_entry_open($zip, $zip_entry, "r")) {
						$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
						$path_file = str_replace("/",DIRECTORY_SEPARATOR, $dir . '/' . $soename);
						$fp = fopen($path_file, "w");
						fwrite($fp, $buf);
						fclose($fp);
						zip_entry_close($zip_entry);
						$albumname = substr($dir, strlen(getAlbumFolder()));
						$album = new Album(new Gallery(), $albumname);
						$image = newImage($album, $soename);
						if ($fname != $soename) {
							$image->setTitle($name);
							$image->save();
						}
					}
				}
			}
			zip_close($zip);
		}
	} else { // Use Zlib http://www.phpconcept.net/pclzip/index.en.php
		require_once(dirname(__FILE__).'/lib-pclzip.php');
		$zip = new PclZip($file);
		if ($zip->extract(PCLZIP_OPT_PATH, $dir, PCLZIP_OPT_REMOVE_ALL_PATH) == 0) {
			die("Error : ".$zip->errorInfo(true));
		}
	}
}

/**
 * Checks for a zip file
 *
 * @param string $filename name of the file
 * @return bool
 */
function is_zip($filename) {
	$ext = strtolower(strrchr($filename, "."));
	return ($ext == ".zip");
}

/**
 * Takes a comment and makes the body of an email.
 *
 * @param string $str comment
 * @param string $name author
 * @param string $albumtitle album
 * @param string $imagetitle image
 * @return string
 */
function commentReply($str, $name, $albumtitle, $imagetitle) {
	$str = wordwrap(strip_tags($str), 75, '\n');
	$lines = explode('\n', $str);
	$str = implode('%0D%0A', $lines);
	$str = "$name commented on $imagetitle in the album $albumtitle: %0D%0A%0D%0A" . $str;
	return $str;
}

/**
 * Extracts and returns a 'statement' from a PHP script for so that it may be 'evaled'
 *
 * @param string $target the pattern to match on
 * @param string $str the PHP script
 * @return string
 */
function isolate($target, $str) {
	$i = strpos($str, $target);
	if ($i === false) return false;
	$str = substr($str, $i);
	//$j = strpos($str, ";\n"); // This is wrong - PHP will not treat all newlines as \n.
	$j = strpos($str, ";"); // This is also wrong; it disallows semicolons in strings. We need a regexp.
	$str = substr($str, 0, $j+1);
	return $str;
}

function seoFriendlyURL($string) {
	return apply_filter('seoFriendlyURL', $string);	
}

/**
 * Return an array of files from a directory and sub directories
 *
 * This is a non recursive function that digs through a directory. More info here:
 * @link http://planetozh.com/blog/2005/12/php-non-recursive-function-through-directories/
 *
 * @param string $dir directory
 * @return array
 * @author Ozh
 * @since 1.3
 */
function listDirectoryFiles( $dir ) {
	$file_list = array();
	$stack[] = $dir;
	while ($stack) {
		$current_dir = array_pop($stack);
		if ($dh = @opendir($current_dir)) {
			while (($file = @readdir($dh)) !== false) {
				if ($file !== '.' AND $file !== '..') {
					$current_file = "{$current_dir}/{$file}";
					if ( is_file($current_file) && is_readable($current_file) ) {
						$file_list[] = "{$current_dir}/{$file}";
					} elseif (is_dir($current_file)) {
						$stack[] = $current_file;
					}
				}
			}
		}
	}
	return $file_list;
}


/**
 * Check if a file is a text file
 *
 * @param string $file 
 * @param array $ok_extensions array of file extensions that are OK to edit (ie text files)
 * @return bool
 * @author Ozh
 * @since 1.3
 */
function isTextFile ( $file, $ok_extensions = array('css','php','js','txt','inc') ) {
	$path_info = pathinfo($file);
	$ext = (isset($path_info['extension']) ? $path_info['extension'] : '');
	return ( !empty ( $ok_extensions ) && (in_array( $ext, $ok_extensions ) ) );
}

/**
 * Check if a theme is editable (ie not a bundled theme)
 *
 * @param $theme theme to check
 * @param $themes array of installed themes (eg result of getThemes())
 * @return bool
 * @author Ozh
 * @since 1.3
 */
function themeIsEditable($theme, $themes) {
	unset($themes['default']);
	unset($themes['effervescence_plus']);
	unset($themes['stopdesign']);
	unset($themes['example']);
	unset($themes['zenpage-default']);
	/* TODO: in case we change the number or names of bundled themes, need to edit this ! */

	return (in_array( $theme , array_keys($themes)));
}


/**
 * Copy a theme directory to create a new custom theme
 *
 * @param $source source directory
 * @param $target target directory
 * @return bool|string either true or an error message
 * @author Ozh
 * @since 1.3
 */
function copyThemeDirectory($source, $target, $newname) {
	global $_zp_current_admin;
	$message = true;
	$source  = SERVERPATH . '/themes/'.UTF8ToFilesystem($source);
	$target  = SERVERPATH . '/themes/'.UTF8ToFilesystem($target);
	
	// If the target theme already exists, nothing to do.
	if ( is_dir($target)) {
		return gettext('Cannot create new theme.') .' '. sprintf(gettext('Directory "%s" already exists!'), basename($target));
	}
	
	// If source dir is missing, exit too
	if ( !is_dir($source)) {
		return gettext('Cannot create new theme.') .' '.sprintf(gettext('Cannot find theme directory "%s" to copy!'), basename($source));
	}

	// We must be able to write to the themes dir.
	if (! is_writable( dirname( $target) )) {
		return gettext('Cannot create new theme.') .' '.gettext('The <tt>/themes</tt> directory is not writable!');
	}

	// We must be able to create the directory
	if (! mkdir($target, CHMOD_VALUE)) {
		return gettext('Cannot create new theme.') .' '.gettext('Could not create directory for the new theme');
	}
	chmod($target, CHMOD_VALUE);
	
	// Get a list of files to copy: get all files from the directory, remove those containing '/.svn/'
	$source_files = array_filter( listDirectoryFiles( $source ), create_function('$str', 'return strpos($str, "/.svn/") === false;') );
	
	// Determine nested (sub)directories structure to create: go through each file, explode path on "/"
	// and collect every unique directory
	$dirs_to_create = array();
	foreach ( $source_files as $path ) {
		$path = dirname ( str_replace( $source . '/', '', $path ) );
		$path = explode ('/', $path);
		$dirs = '';
		foreach ( $path as $subdir ) {
			if ( $subdir == '.svn' or $subdir == '.' ) {
				continue 2;
			}
			$dirs = "$dirs/$subdir";
			$dirs_to_create[$dirs] = $dirs;	
		}
	}
	/*
	Example result for theme 'effervescence_plus': $dirs_to_create = array (
		'/styles' => '/styles',
		'/scripts' => '/scripts',
		'/images' => '/images',
		'/images/smooth' => '/images/smooth',
		'/images/slimbox' => '/images/slimbox',
	);
	*/
	
	// Create new directory structure
	foreach ($dirs_to_create as $dir) {
		mkdir("$target/$dir", CHMOD_VALUE);
		chmod("$target/$dir", CHMOD_VALUE); // Using chmod as PHP doc suggested: "Avoid using umask() in multithreaded webservers. It is better to change the file permissions with chmod() after creating the file."
	}
	
	// Now copy every file
	foreach ( $source_files as $file ) {
		$newfile = str_replace($source, $target, $file);
		if (! copy("$file", "$newfile" ) )
			return sprintf(gettext("An error occured while copying files. Please delete manually the new theme directory '%s' and retry or copy files manually."), basename($target));
		chmod("$newfile", CHMOD_VALUE);	
	}	

	// Rewrite the theme header.
	if ( file_exists($target.'/theme_description.php') ) {		
		$theme_description = array();
		require($target.'/theme_description.php');
		$theme_description['desc'] = sprintf(gettext('Your theme, based on theme %s'), $theme_description['name']);
	} else  {
		$theme_description['desc'] = gettext('Your theme');	
	}
	$theme_description['name'] = $newname;
	$theme_description['author'] = $_zp_current_admin['user'];
	$theme_description['version'] = '1.0';
	$theme_description['date']  = date('d/m/Y');
	
	$description = sprintf('<'.'?php
// Zenphoto theme definition file
$theme_description["name"] = "%s";
$theme_description["author"] = "%s";
$theme_description["version"] = "%s";
$theme_description["date"] = "%s";
$theme_description["desc"] = "%s";
?'.'>' , htmlentities($theme_description['name'], ENT_COMPAT),
		htmlentities($theme_description['author'], ENT_COMPAT),
		htmlentities($theme_description['version'], ENT_COMPAT),
		htmlentities($theme_description['date'], ENT_COMPAT),
		htmlentities($theme_description['desc'], ENT_COMPAT));
	
	$f = fopen($target.'/theme_description.php', 'w');
	if ($f !== FALSE) {
		@fwrite($f, $description);
		fclose($f);
		$message = gettext('New custom theme created successfully!');
	} else {
		$message = gettext('New custom theme created, but its description could not be updated');
	}
	
	// Make a slightly custom theme image
	if (file_exists("$target/theme.png")) $themeimage = "$target/theme.png";
	else if (file_exists("$target/theme.gif")) $themeimage = "$target/theme.gif";
	else if (file_exists("$target/theme.jpg")) $themeimage = "$target/theme.jpg";
	else $themeimage = false;
	if ($themeimage) {
		require_once(dirname(__FILE__).'/functions-image.php');
		if ($im = get_image($themeimage)) {
			$x = imagesx($im)/2 - 45;
			$y = imagesy($im)/2 - 10;
			$text = "CUSTOM COPY";

			// create a blueish overlay
			$overlay = imagecreatetruecolor(imagesx($im), imagesy($im));
			imagefill ($overlay, 0, 0, 0x0606090);
			// Merge theme image and overlay
			imagecopymerge($im, $overlay, 0, 0, 0, 0, imagesx($im), imagesy($im), 45);
			// Add text
			imagestring ( $im,  5,  $x-1,  $y-1, $text,  0x0ffffff );
			imagestring ( $im,  5,  $x+1,  $y+1, $text,  0x0ffffff );
			imagestring ( $im,  5,  $x,  $y,   $text,  0x0ff0000 );
			// Save new theme image
			imagepng($im, $themeimage);
		}	
	}

	return $message;
}

/**
 * Return URL of current admin page, encoded for a form, relative to zp-core folder
 *
 * @return string current URL
 * @author Ozh
 * @since 1.3
 */
function currentRelativeURL() {
	$from = PROTOCOL."://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // full requested URL
	$from = str_replace( FULLWEBPATH , '', $from); // Make relative to zenphoto installation
	return urlencode(stripslashes( $from ));
}

?>
