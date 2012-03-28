<?php
/**
 * provides the Upload tab of admin
 * @package admin
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-functions.php');

if (!($_zp_loggedin & (UPLOAD_RIGHTS | ADMIN_RIGHTS))) { // prevent nefarious access to this page.
	header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php?from=' . currentRelativeURL() );
	exit();
}

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

$gallery = new Gallery();

/* handle posts */
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'upload') {

		// Check for files.
		$files_empty = true;
		if (isset($_FILES['files']))
		foreach($_FILES['files']['name'] as $name) { if (!empty($name)) $files_empty = false; }
		$newAlbum = (($_POST['existingfolder'] == 'false') || isset($_POST['newalbum']));
		// Make sure the folder exists. If not, create it.
		if (isset($_POST['processed']) && !empty($_POST['folder']) && ($newAlbum || !$files_empty)) {

			$folder = sanitize_path($_POST['folder']);
			$uploaddir = $gallery->albumdir . UTF8ToFilesystem($folder);
			if (!is_dir($uploaddir)) {
				mkdir ($uploaddir, CHMOD_VALUE);
			}
			@chmod($uploaddir, CHMOD_VALUE);
			
			$album = new Album($gallery, $folder);
			if ($album->exists) {
				if (!isset($_POST['publishalbum'])) {
					$album->setShow(false);
				}
				$title = sanitize($_POST['albumtitle'], 2);
				if (!empty($title) && $newAlbum) {
					$album->setTitle($title);
				}
				$album->save();
			} else {
				$AlbumDirName = str_replace(SERVERPATH, '', $gallery->albumdir);
				zp_error(gettext("The album couldn't be created in the 'albums' folder. This is usually a permissions problem. Try setting the permissions on the albums and cache folders to be world-writable using a shell:")." <code>chmod 777 " . $AlbumDirName . CACHEFOLDER ."</code>, "
				. gettext("or use your FTP program to give everyone write permissions to those folders."));
			}
			
			$error = false;
			foreach ($_FILES['files']['error'] as $key => $error) {
				if ($_FILES['files']['name'][$key] == "") continue;
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['files']['tmp_name'][$key];
					$name = $_FILES['files']['name'][$key];
					$soename = UTF8toFilesystem(seoFriendlyURL($name));
					if (is_valid_image($name) || is_valid_other_type($name)) {
						$uploadfile = $uploaddir . '/' . $soename;
						move_uploaded_file($tmp_name, $uploadfile);
						@chmod($uploadfile, 0666 & CHMOD_VALUE);
						$image = newImage($album, $soename);
						if ($name != $soename) {
							$image->setTitle($name);
							$image->save();
						}
					} else if (is_zip($name)) {
						unzip($tmp_name, $uploaddir);
					}
				}
			}
			header('Location: '.FULLWEBPATH.'/'.ZENFOLDER.'/admin-edit.php?page=edit&album='.urlencode($folder).'&uploaded&subpage=1&tab=imageinfo');
			exit();

		} else {
			// Handle the error and return to the upload page.
			$page = "upload";
			$_GET['page'] = 'upload';
			$error = true;
			if ($files_empty) {
				$errormsg = gettext("You must upload at least one file.");
			} else if (empty($_POST['folder'])) {
				$errormsg = gettext("You must enter a folder name for your new album.");
			} else if (empty($_POST['processed'])) {
				$errormsg = gettext("You've most likely exceeded the upload limits. Try uploading fewer files at a time, or use a ZIP file.");

			} else {
				$errormsg = gettext("There was an error submitting the form. Please try again. If this keeps happening, check your server and PHP configuration (make sure file uploads are enabled, and upload_max_filesize is set high enough)")
				. gettext("If you think this is a bug, file a bug report. Thanks!");
			}
		}
	}
}

printAdminHeader();
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('upload');
echo "\n" . '<div id="content">';

			$albumlist = array();
			genAlbumUploadList($albumlist);
			?> 
			<script type="text/javascript">
				window.totalinputs = 5;
				// Array of album names for javascript functions.
				var albumArray = new Array (
					<?php
					$separator = '';
					foreach($albumlist as $key => $value) {
						echo $separator . "'" . addslashes($key) . "'";
						$separator = ", ";
					}
					?> );
			</script>

<h1><?php echo gettext("Upload Photos"); ?></h1>
<p>
<?php 
natsort($_zp_supported_images);
$types = array_keys($_zp_extra_filetypes);
natsort($types);
$last = strtoupper(array_pop($types));
$s1 = strtoupper(implode(', ', $_zp_supported_images));
$s2 = strtoupper(implode(', ', $types));
printf(gettext('This web-based upload accepts ZenPhoto formats: %s, %s, and %s.'), $s1, $s2, $last);
echo gettext("You can also upload a <strong>ZIP</strong> archive containing any of those file types."); ?></p>
<!--<p><em>Note:</em> When uploading archives, <strong>all</strong> images in the archive are added to the album, regardles of directory structure.</p>-->
<p>
<?php echo sprintf(gettext("The maximum size for any one file is <strong>%sB</strong>."), ini_get('upload_max_filesize')); ?>
<?php echo gettext('Don\'t forget, you can also use <acronym title="File Transfer Protocol">FTP</acronym> to upload folders of images into the albums directory!'); ?>
</p>

<?php if (isset($error) && $error) { ?>
<div class="errorbox" id="fade-message">
<h2><?php echo gettext("Something went wrong..."); ?></h2>
<?php echo (empty($errormsg) ? gettext("There was an error submitting the form. Please try again.") : $errormsg); ?>
</div>
<?php
}
if (ini_get('safe_mode')) { ?>
<div class="warningbox" id="fade-message">
<h2><?php echo gettext("PHP Safe Mode Restrictions in effect!"); ?></h2>
<p><?php echo gettext("Zenphoto may be unable to perform uploads when PHP Safe Mode restrictions are in effect"); ?></p>
</div>
<?php
}
?>

<form name="uploadform" enctype="multipart/form-data"
	action="?action=upload" method="POST"
	onSubmit="return validateFolder(document.uploadform.folder,'<?php echo gettext('That name is already used.'); ?>','<?php echo gettext('This upload has to have a folder. Type a title or folder name to continue...'); ?>');">
	<input type="hidden" name="processed" value="1" /> 
	<input type="hidden" name="existingfolder" value="false" />

<div id="albumselect"><?php echo gettext("Upload to:"); ?> <?php if (isset($_GET['new'])) { 
	$checked = "checked=\"checked\"";
} else {
	$checked = '';
}
?> <select id="albumselectmenu" name="albumselect" onChange="albumSwitch(this,true,'<?php echo gettext('That name is already used.'); ?>','<?php echo gettext('This upload has to have a folder. Type a title or folder name to continue...'); ?>')">
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
	if (isset($_GET['album']) && ($_GET['album'] == $fullfolder)) {
		$selected = " SELECTED=\"true\" ";
	} else {
		$selected = "";
	}
	// Get rid of the slashes in the subalbum, while also making a subalbum prefix for the menu.
	while (strstr($singlefolder, '/') !== false) {
		$singlefolder = substr(strstr($singlefolder, '/'), 1);
		$saprefix = "&nbsp; &nbsp;&raquo;&nbsp;" . $saprefix;
		$salevel++;
	}
	echo '<option value="' . $fullfolder . '"' . ($salevel > 0 ? ' style="background-color: '.$bglevels[$salevel].'; border-bottom: 1px dotted #ccc;"' : '')
	. "$selected>" . $saprefix . $singlefolder . " (" . $albumtitle . ')' . "</option>\n";
}
?>
</select>

<div id="newalbumbox" style="margin-top: 5px;">
<div><label><input type="checkbox" name="newalbum"
<?php echo $checked; ?> onClick="albumSwitch(this.form.albumselect,false,'<?php echo gettext('That name is already used.'); ?>','<?php echo gettext('This upload has to have a folder. Type a title or folder name to continue...'); ?>')">
<?php echo gettext("Make a new Album"); ?></label></div>
<div id="publishtext"><?php echo gettext("and"); ?><label><input type="checkbox"
	name="publishalbum" id="publishalbum" value="1" checked="checked" /> <?php echo gettext("Publish the album so everyone can see it."); ?></label></div>
</div>

<div id="albumtext" style="margin-top: 5px;"><?php echo gettext("called:"); ?> <input
	id="albumtitle" size="42" type="text" name="albumtitle" value=""
	onKeyUp="updateFolder(this, 'folderdisplay', 'autogen', '<?php echo gettext('That name is already used.'); ?>','<?php echo gettext('This upload has to have a folder. Type a title or folder name to continue...'); ?>');" />

<div style="position: relative; margin-top: 4px;"><?php echo gettext("with the folder name:"); ?>
<div id="foldererror"
	style="display: none; color: #D66; position: absolute; z-index: 100; top: 2.5em; left: 0px;"></div>
<input id="folderdisplay" size="18" type="text" name="folderdisplay"
	disabled="DISABLED" onKeyUp="validateFolder(this,'<?php echo gettext('That name is already used.'); ?>','<?php echo gettext('This upload has to have a folder. Type a title or folder name to continue...'); ?>');" /> <label><input
	type="checkbox" name="autogenfolder" id="autogen" checked="checked"
	onClick="toggleAutogen('folderdisplay', 'albumtitle', this);" />
<?php echo gettext("Auto-generate"); ?></label> <br />
<br />
</div>

<input type="hidden" name="folder" value="" /></div>

</div>

<div id="uploadboxes" style="display: none;">
<hr />
<!-- This first one is the template that others are copied from -->
<div class="fileuploadbox" id="filetemplate"><input type="file"
	size="40" name="files[]" /></div>
<div class="fileuploadbox"><input type="file" size="40" name="files[]" />
</div>
<div class="fileuploadbox"><input type="file" size="40" name="files[]" />
</div>
<div class="fileuploadbox"><input type="file" size="40" name="files[]" />
</div>
<div class="fileuploadbox"><input type="file" size="40" name="files[]" />
</div>

<div id="place" style="display: none;"></div>
<!-- New boxes get inserted before this -->

<p id="addUploadBoxes"><a href="javascript:addUploadBoxes('place','filetemplate',5)" title="<?php echo gettext("Doesn't reload!"); ?>">+ <?php echo gettext("Add more upload boxes"); ?></a> <small>
<?php echo gettext("(won't reload the page, but remember your upload limits!)"); ?></small></p>


<p><input type="submit" value="<?php echo gettext('Upload'); ?>"
	onClick="this.form.folder.value = this.form.folderdisplay.value;"
	class="button" /></p>

</div>

</form>
<script type="text/javascript">albumSwitch(document.uploadform.albumselect,false,'<?php echo gettext('That name is already used.'); ?>','<?php echo gettext('This upload has to have a folder. Type a title or folder name to continue...'); ?>');</script>

<?php
printAdminFooter();
echo "\n</body>";
echo "\n</html>";
?>



