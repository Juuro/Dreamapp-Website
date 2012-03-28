<?php
/**
 * provides the Themes tab of admin
 * @package admin
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-functions.php');

if (!($_zp_loggedin & (THEMES_RIGHTS | ADMIN_RIGHTS))) { // prevent nefarious access to this page.
	header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php?from=' . currentRelativeURL() );
	exit();
}

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

$gallery = new Gallery();
$_GET['page'] = 'themes';

/* handle posts */
$message = null; // will hold error/success message displayed in a fading box
if (isset($_GET['action'])) {
	// Set new theme
	if ($_GET['action'] == 'settheme') {
		if (isset($_GET['theme'])) {
			$alb = sanitize_path($_GET['themealbum']);
			$newtheme = strip($_GET['theme']);
			if (empty($alb)) {
				$gallery->setCurrentTheme($newtheme);
			} else {
				$album = new Album($gallery, $alb);
				$oldtheme = $album->getAlbumTheme();
				$album->setAlbumTheme($newtheme);
				$album->save();
			}
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-themes.php?themealbum=".$_GET['themealbum']);
		}
	
	// Duplicate a theme
	} elseif ($_GET['action'] == 'copytheme') {
		if (isset($_GET['source']) && isset($_GET['target']) && isset($_GET['name']) ) {
			$message = copyThemeDirectory($_GET['source'], $_GET['target'], $_GET['name']);		
		}	
	}
}


printAdminHeader();

// Script for the "Duplicate theme" feature
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('li.zp_copy_theme a').each(function(){
		var source = jQuery(this).attr('title');
		jQuery(this).click(function(){
			var targetname = prompt('<?php echo gettext('New theme name? (eg. "My Cool Theme")'); ?>', 'My Cool Theme');
			if (targetname) {
				var targetdir = prompt('<?php echo gettext('New directory name? (eg. "my_theme")'); ?>', targetname.toLowerCase().replace(/ /g,'_').replace(/[^A-Za-z0-9_]/g,'') );
				if (targetdir) {
					window.location =('?action=copytheme&source='+encodeURIComponent(source)+'&target='+encodeURIComponent(targetdir)+'&name='+encodeURIComponent(targetname));
					return false;
				}
			}
			return false;
		}).attr({data:source,title:'<?php echo gettext('Make a copy of this theme'); ?>'}).parent().toggle();
		
	});
});
</script>

<?php
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs('themes');
echo "\n" . '<div id="content">';

	$galleryTheme = $gallery->getCurrentTheme();
	$themelist = array();
	if ($_zp_loggedin & ADMIN_RIGHTS) {
		$gallery_title = get_language_string(getOption('gallery_title'));
		if ($gallery_title != gettext("Gallery")) {
			$gallery_title .= ' ('.gettext("Gallery").')';
		}
		$themelist[$gallery_title] = '';
	}
	$albums = $gallery->getAlbums(0);
	foreach ($albums as $alb) {
		if (isMyAlbum($alb, THEMES_RIGHTS)) {
			$album = new Album($gallery, $alb);
			$key = $album->getTitle();
			if ($key != $alb) {
				$key .= " ($alb)";
			}
			$themelist[$key] = urlencode($alb);
		}
	}
	if (!empty($_REQUEST['themealbum'])) {
		$alb = sanitize_path($_REQUEST['themealbum']);
		$album = new Album($gallery, $alb);
		$albumtitle = $album->getTitle();
		$themename = $album->getAlbumTheme();
		$current_theme = $themename;
	} else {
		$current_theme = $galleryTheme;
		foreach ($themelist as $albumtitle=>$alb) break;
		if (empty($alb)) {
			$themename = $gallery->getCurrentTheme();
		} else {
			$alb = sanitize_path($alb);
			$album = new Album($gallery, $alb);
			$albumtitle = $album->getTitle();
			$themename = $album->getAlbumTheme();
		}
	}
	$themes = $gallery->getThemes();
	if (empty($themename)) {
		$current_theme = $galleryTheme;
		$theme = $themes[$galleryTheme];
		$themenamedisplay = '</em><small>'.gettext("no theme assigned, defaulting to Gallery theme").'</small><em>';
		$gallerydefault = true;
	} else {
		$theme = $themes[$themename];
		$themenamedisplay = $theme['name'];
		$gallerydefault = false;
	}

	if (count($themelist) > 1) {
		echo '<form action="#" method="post">';
		echo gettext("Show theme for: ");
		echo '<select id="themealbum" name="themealbum" onchange="this.form.submit()">';
		generateListFromArray(array(urlencode($alb)), $themelist, false, false);
		echo '</select>';
		echo '</form>';
	}
	if (count($themelist) == 0) {
		echo '<div class="errorbox" id="no_themes">';
		echo  "<h2>".gettext("There are no themes for which you have rights to administer.")."</h2>";
		echo '</div>';
	} else {

	echo "<h1>".sprintf(gettext('Current theme for <code><strong>%1$s</strong></code>: <em>%2$s</em>'),$albumtitle,$themenamedisplay);
	if (!empty($alb) && !empty($themename)) {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".'<a class="reset" href="?action=settheme&themealbum='.urlencode($album->name).'&theme=" title="'.gettext('Clear theme assignment').$album->name.'">';
		echo '<img src="images/fail.png" style="border: 0px;" alt="'.gettext('Clear theme assignment').'" /></a>';
	}
	echo "</h1>\n";
?>

<?php if ($message) {
	echo '<div class="messagebox" id="fade-message">';
	echo  "<h2>$message</h2>";
	echo '</div>';
} ?>

<p>
	<?php echo gettext('Themes allow you to visually change the entire look and feel of your gallery. Theme files are located in your Zenphoto <code>/themes</code> folder.'); ?>
	<?php echo gettext('You can download more themes from the <a href="http://www.zenphoto.org/zp/theme/">zenphoto themes page</a>.'); ?>
	<?php echo gettext('Place the downloaded themes in the <code>/themes</code> folder and they will be available for your use.') ?>
</p>

<p>
	<?php echo gettext("You can edit files from custom themes. Official themes shipped with Zenphoto are not editable, since your changes would be lost on next update."); ?>
	<?php echo gettext("If you want to customize an official theme, please first <em>duplicate</em> it. This will place a copy in your <code>/themes</code> folder for you to edit."); ?>
</p>	
<table class="bordered">
	<thead>
		<th colspan="2"><b><?php echo gettext('Installed themes'); ?></b></th>
		<th><b><?php echo gettext('Action'); ?></b></th>
	</thead>
	<tbody>
	<?php
$themes = $gallery->getThemes();
$current_theme_style = "background-color: #ECF1F2;";
foreach($themes as $theme => $themeinfo):
	$style = ($theme == $current_theme) ? " style=\"$current_theme_style\"" : "";
	$themedir = SERVERPATH . '/themes/'.UTF8ToFilesystem($theme);
	$themeweb = WEBPATH . "/themes/$theme";
?>
	<tr>
		<td style="margin: 0px; padding: 0px;"><?php
		if (file_exists("$themedir/theme.png")) $themeimage = "$themeweb/theme.png";
		else if (file_exists("$themedir/theme.gif")) $themeimage = "$themeweb/theme.gif";
		else if (file_exists("$themedir/theme.jpg")) $themeimage = "$themeweb/theme.jpg";
		else $themeimage = false;
		if ($themeimage) { ?> <img height="150" width="150"
			src="<?php echo $themeimage; ?>" alt="Theme Screenshot" /> <?php } ?>
		</td>
		<td <?php echo $style; ?>><strong><?php echo $themeinfo['name']; ?></strong><br />
		<?php echo $themeinfo['author']; ?><br />
		Version <?php echo $themeinfo['version']; ?>, <?php echo $themeinfo['date']; ?><br />
		<?php echo $themeinfo['desc']; ?></td>
		<td width="100" <?php echo $style; ?>>
		<ul class="theme_links">
		<?php
		if ($theme != $current_theme) {
			echo '<li><a href="?action=settheme&themealbum='.urlencode($alb).'&theme='.$theme.'" title="';
			 echo gettext("Set this as your theme").'">'.gettext("Use this Theme");
			echo '</a></li>';
		} else {
			if ($gallerydefault) {
				echo '<li><a href="?action=settheme&themealbum='.urlencode($alb).'&theme='.$theme.'" title="';
			  echo gettext("Assign this as your album theme").'">'.gettext("Assign Theme");
				echo '</a></li>';
			} else {
				echo "<li><strong>".gettext("Current Theme")."</strong></li>";
			}
		}
		
		if (themeIsEditable($theme, $themes)) {
			echo '<li>';
			echo '<a href="admin-themes-editor.php?theme='.$theme.'" title="';
			echo gettext("Edit this theme").'">'.gettext("Edit");
			echo '</a></li>';
		}
		
		// The "Duplicate" link will be shown by JS if available, as it needs it
		echo '<li class="zp_copy_theme" style="display:none">';
		echo '<a href="?" title="'.$theme.'">'.gettext("Duplicate").'</a>';
		echo '</li>';
		
		?>
		</td>
	</tr>

	<?php endforeach; ?>
	</tbody>
</table>


<?php
}

echo "\n" . '</div>';  //content
echo "\n" . '</div>';  //main

printAdminFooter();
echo "\n</body>";
echo "\n</html>";
?>



