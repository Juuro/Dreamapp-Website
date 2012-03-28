<?php
/**
 * This script is used to create dynamic albums from a search.
 * @package core
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/template-functions.php');
require_once(dirname(__FILE__).'/admin-functions.php');

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

$imagelist = array();

function getSubalbumImages($folder) {
	global $imagelist;
	if (hasDyanmicAlbumSuffix($folder)) { return; }
	$album = new Album($gallery, $folder);
	$images = $album->getImages();
	foreach ($images as $image) {
		$imagelist[] = '/'.$folder.'/'.$image;
	}
	$albums = $album->getSubalbums();
	foreach ($albums as $folder) {
		getSubalbumImages($folder);
	}
}

if (!zp_loggedin()) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin.php");
	exit();
}
$search = new SearchEngine();
if (isset($_POST['savealbum'])) {
	$albumname = $_POST['album'];
	if (!isMyAlbum($albumname, EDIT_RIGHTS)) {
		die(gettext("You do not have edit rights on this album."));
	}
	$album = $_POST['albumselect'];
	$words = $_POST['words'];
	if (isset($_POST['thumb'])) {
		$thumb = $_POST['thumb'];
	} else {
		$thumb = '';
	}
	$fields = $search->fields;
	$redirect = $album.'/'.$albumname.".alb";

	if (!empty($albumname)) {
		$f = fopen(UTF8ToFilesystem(getAlbumFolder().$redirect), 'w');
		if ($f !== false) {
			fwrite($f,"WORDS=$words\nTHUMB=$thumb\nFIELDS=$fields\n");
			fclose($f);
			// redirct to edit of this album
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-edit.php?page=edit&album=" . urlencode($redirect));
			exit();
		}
	}
}
$_GET['page'] = 'edit'; // pretend to be the edit page.
printAdminHeader();
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('edit');
echo "\n" . '<div id="content">';
echo "<h1>".gettext("zenphoto Create Dynamic Album")."</h1>\n";

if (isset($_POST['savealbum'])) { // we fell through, some kind of error
	echo "<div class=\"errorbox space\">";
	echo "<h2>".gettext("Failed to save the album file")."</h2>";
	echo "</div>\n";
}

$gallery = new Gallery();
$albumlist = array();
genAlbumUploadList($albumlist);
$params = trim(zp_getCookie('zenphoto_image_search_params'));
$search->setSearchParams($params);
$fields = $search->fields;
$words = trim($search->words);
$images = $search->getImages(0);
foreach ($images as $image) {
	$folder = $image['folder'];
	$filename = $image['filename'];
	$imagelist[] = '/'.$folder.'/'.$filename;
}
$subalbums = $search->getAlbums(0);
foreach ($subalbums as $folder) {
	getSubalbumImages($folder);
}
$albumname = trim($words);
$albumname = str_replace('!', ' NOT ', $albumname);
$albumname = str_replace('&', ' AND ', $albumname);
$albumname = str_replace('|', ' OR ', $albumname);
$albumname = sanitize_path($albumname);
$albumname = seoFriendlyURL($albumname);
$old = '';
while ($old != $albumname) {
	$old = $albumname;
	$albumname = str_replace('--', '-', $albumname);
}
?>
<form action="?savealbum" method="post"><input type="hidden"
	name="savealbum" value="yes" />
<table>
	<tr>
		<td><?php echo gettext("Album name:"); ?></td>
		<td><input type="text" size="40" name="album"
			value="<?php echo $albumname ?>" /></td>
	</tr>
	<tr>
		<td><?php echo gettext("Create in:"); ?></td>
		<td><select id="albumselectmenu" name="albumselect">
		<?php
		if (isMyAlbum('/', UPLOAD_RIGHTS)) {
			?>
			<option value="" selected="SELECTED" style="font-weight: bold;">/</option>
			<?php
}
$bglevels = array('#fff','#f8f8f8','#efefef','#e8e8e8','#dfdfdf','#d8d8d8','#cfcfcf','#c8c8c8');
foreach ($albumlist as $fullfolder => $albumtitle) {
	$singlefolder = $fullfolder;
	$saprefix = "";
	$salevel = 0;
	// Get rid of the slashes in the subalbum, while also making a subalbum prefix for the menu.
	while (strstr($singlefolder, '/') !== false) {
		$singlefolder = substr(strstr($singlefolder, '/'), 1);
		$saprefix = "&nbsp; &nbsp;&raquo;&nbsp;" . $saprefix;
		$salevel++;
	}
	echo '<option value="' . $fullfolder . '"' . ($salevel > 0 ? ' style="background-color: '.$bglevels[$salevel].'; border-bottom: 1px dotted #ccc;"' : '')
	. ">" . $saprefix . $singlefolder . " (" . $albumtitle . ')' . "</option>\n";
}
?>
		</select></td>
	</tr>
	<tr>
		<td><?php echo gettext("Thumbnail:"); ?></td>
		<td><select id="thumb" name="thumb">
		<?php
		$showThumb = getOption('thumb_select_images');
		echo "\n<option";
		if ($showThumb) echo " class=\"thumboption\" value=\"\" style=\"background-color:#B1F7B6\"";
		echo ' value="1">'.gettext('most recent');
		echo '</option>';
		echo "\n<option";
		if ($showThumb) echo " class=\"thumboption\" value=\"\" style=\"background-color:#B1F7B6\"";
		echo " selected=\"selected\"";
		echo ' value="">'.gettext('randomly selected');
		echo '</option>';
		foreach ($imagelist as $imagepath) {
			$pieces = explode('/', $imagepath);
			$filename = array_pop($pieces);;
			$folder = implode('/', $pieces);
			$albumx = new Album($gallery, $folder);
			$image = newImage($albumx, $filename);
			if (is_valid_image($filename)) {
				echo "\n<option class=\"thumboption\"";
				if ($showThumb) {
					echo " style=\"background-image: url(" . $image->getThumb() .
									"); background-repeat: no-repeat;\"";
				}
				echo " value=\"".$imagepath."\"";
				echo ">" . $image->getTitle();
				echo  " ($imagepath)";
				echo "</option>";
			}
		}
		?>
		</select></td>
	</tr>
	<tr>
		<td><?php echo gettext("Search criteria:"); ?></td>
		<td><input type="text" size="60" name="words"
			value="<?php echo $words ?>" /></td>
	</tr>
	<tr>
		<td><?php echo gettext("Search fields:"); ?></td>
		<td>
		<?php 
		echo '<ul class="searchchecklist">'."\n";
		$selected_fields = array();
		$engine = new SearchEngine();
		$available_fields = $engine->allowedSearchFields();
		foreach ($available_fields as $key=>$value) {
			if ($value & $fields) {
				$selected_fields[$key] = $value;
			}
		}
		
		generateUnorderedListFromArray($selected_fields, $available_fields, '_SEARCH_', false, true, true);
		echo '</ul>';
		?>		
		</td>
	</tr>

</table>

<input type="submit" value="<?php echo gettext('Create the album');?>"
	class="button" /></form>

<?php

echo "\n" . '</div>';
echo "\n" . '</div>';

printAdminFooter();

echo "\n</body>";
echo "\n</html>";
?>

