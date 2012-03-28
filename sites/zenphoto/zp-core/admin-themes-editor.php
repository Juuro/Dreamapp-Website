<?php
/**
 * Theme file editor
 * @package admin
 * @author Ozh
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-functions.php');

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

if (!($_zp_loggedin & (THEMES_RIGHTS | ADMIN_RIGHTS))) { // prevent nefarious access to this page.
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin.php");
	exit();
}

if (!isset($_GET['theme'])) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-themes.php");
	exit();
}

$gallery = new Gallery();

printAdminHeader();
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('themes');
echo "\n" . '<div id="content">';

// First, set up a few vars:
$message = $file_to_edit = $file_content = null;
$themes = $gallery->getThemes();
$theme = $_GET['theme'];
$themedir = SERVERPATH . '/themes/'.UTF8ToFilesystem($theme);
$themefiles = listDirectoryFiles($themedir);
$themefiles_to_ext = array();
foreach ($themefiles as $file) {
	if (isTextFile($file)) {
		$path_info = pathinfo($file);
		$themefiles_to_ext[$path_info['extension']][] = $file; // array(['php']=>array('file.php', 'image.php'),['css']=>array('style.css'))
	} else {
		unset($themefiles[$file]); // $themefile will eventually have all editable files and nothing else
	}
}

if (isset($_GET['file']))
	$file_to_edit = str_replace ('\\', '/', realpath (SERVERPATH . '/themes/'.UTF8ToFilesystem($theme) . '/'. $_GET['file'])) ;
	// realpath() to take care of ../../file.php schemes, str_replace() to sanitize Win32 filenames

// If we're attempting to edit a file from a bundled theme, this is an illegal attempt
if (!themeIsEditable($theme, $themes))
	die(gettext('Cannot edit this file!'));

// If we're attempting to edit a file that's not a text file or that does not belong to the theme directory, this is an illegal attempt
if ( $file_to_edit ) {
	if ( !in_array( $file_to_edit, $themefiles ) or !isTextFile( $file_to_edit ) or filesize( $file_to_edit ) == 0)
		die(gettext('Cannot edit this file!'));
}

// Handle POST that updates a file
if (isset($_POST['action']) && $_POST['action'] == 'edit_file' && $file_to_edit ) {
	$file_content = stripslashes($_POST['newcontent']);
	$theme = urlencode($theme);
	if (is_writeable($file_to_edit)) {
		//is_writable() not always reliable, check return value. see comments @ http://uk.php.net/is_writable
		$f = @fopen($file_to_edit, 'w+');
		if ($f !== FALSE) {
			@fwrite($f, $file_content);
			fclose($f);
			$message = gettext('File updated successfully');
		} else {
			$message = gettext('Could not write file. Please check its write permissions');
		}
	} else {
		$message = gettext('Could not write file. Please check its write permissions');
	}
}

// Get file contents
if ( $file_to_edit ) {
	$f = @fopen($file_to_edit, 'r');
	$file_content = @fread($f, filesize($file_to_edit));
	$file_content = htmlspecialchars($file_content);
	fclose($f);
}

?>


<h1><?php echo gettext('Theme File Editor'); ?></h1>

<?php if ($message) {
	echo '<div class="messagebox" id="fade-message">';
	echo  "<h2>$message</h2>";
	echo '</div>';
} ?>

<div id="theme-editor">

	<div id="files">
		<?php
		foreach ($themefiles_to_ext as $ext=>$files) {
			echo '<h2 class="h2_bordered">';
			switch($ext) {
			case 'php':
				echo gettext('Theme template files (.php)');
				break;
			case 'js':
				echo gettext('Javascript files (.js)');
				break;
			case 'css':
				echo gettext('Stylesheets (.css)');
				break;
			default:
				echo gettext('Other text files');
			}
			echo '</h2><ul>';
			foreach ($files as $file) {
				$file = str_replace ($themedir.'/', '', $file);
				echo "<li><a title='". gettext('Edit this file') ."' href='?theme=$theme&file=$file'>$file</a></li>";
			}
			echo '</ul>';
		}
		?>
	</div>
	

	<?php if ($file_to_edit) { ?>

		<div id="editor">
			<h2 class="h2_bordered"><?php echo sprintf(gettext('File <tt>%s</tt> from theme %s'), $_GET['file'], $themes[$theme]['name']); ?></h2>
			<form method="post" action="">
			<p><textarea cols="70" rows="25" name="newcontent" id="newcontent"><?php echo $file_content ?></textarea></p>
			<input type="hidden" name="action" value="edit_file"/>
			<p><input class="button" type="submit" value="<?php echo gettext('Update File'); ?>" /></p>
			</form>
		</div>

	<?php } else { ?>

		<p><?php echo gettext('Select a file to edit from the list on your right hand. Keep in mind that you can <strong>break everything</strong> if you are not careful when updating files.'); ?></p>

	<?php } ?>

</div> <!-- theme-editor -->

<?php

echo "\n" . '</div>';  //content
echo "\n" . '</div>';  //main

printAdminFooter();
echo "\n</body>";
echo "\n</html>";
?>



