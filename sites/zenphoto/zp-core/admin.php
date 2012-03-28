<?php
/**
 * admin.php is the main script for administrative functions.
 * @package admin
 */

// force UTF-8 Ø

/* Don't put anything before this line! */
define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-functions.php');

if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

if (zp_loggedin()) { /* Display the admin pages. Do action handling first. */
	if (($_zp_null_account = ($_zp_loggedin == ADMIN_RIGHTS)) || ($_zp_loggedin == NO_RIGHTS)) { // user/password set required.
		header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-options.php");
	}

	$gallery = new Gallery();
	$gallery->garbageCollect();
	if (isset($_GET['action'])) {
		$action = $_GET['action'];

		/** clear the cache ***********************************************************/
		/******************************************************************************/
		if ($action == "clear_cache") {
			$gallery->clearCache();
			$msg = gettext('Cache cleared.');
		}

		/** Reset hitcounters ***********************************************************/
		/********************************************************************************/
		if ($action == "reset_hitcounters") {
			query("UPDATE " . prefix('albums') . " SET `hitcounter`= 0");
			query("UPDATE " . prefix('images') . " SET `hitcounter`= 0");
			$msg = gettext('Hitcounters reset');
		}		
	}

/************************************************************************************/
/** End Action Handling *************************************************************/
/************************************************************************************/

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else if (empty($page)) {
		$page = "home";
	}

	switch ($page) {
		case 'comments':
			if (!($_zp_loggedin & (ADMIN_RIGHTS | COMMENT_RIGHTS))) $page = '';
			break;
		case 'upload':
			if (!($_zp_loggedin & (ADMIN_RIGHTS | UPLOAD_RIGHTS))) $page = '';
			break;
		case 'edit':
			if (!($_zp_loggedin & (ADMIN_RIGHTS | EDIT_RIGHTS))) $page = '';
			break;
		case 'themes':
			if (!($_zp_loggedin & (ADMIN_RIGHTS | THEMES_RIGHTS))) $page = '';
			break;
		case 'plugins':
			if (!($_zp_loggedin & (ADMIN_RIGHTS | ADMIN_RIGHTS))) $page = '';
			break;
		case 'home':
			if (!($_zp_loggedin & (ADMIN_RIGHTS | MAIN_RIGHTS))) {
				$page='options';
			}
			break;
	}

	
	$q = '?page='.$page;
	foreach ($_GET as $opt=>$value) {
		if ($opt != 'page') {
			$q .= '&'.$opt.'='.$value;
		}
	}
	switch ($page) {
		case 'editcomment':
		case 'comments':
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-comments.php".$q);
			exit();
		case 'edit':
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-edit.php".$q);
			exit();
		case 'upload':
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-upload.php".$q);
			exit();
		case 'themes':
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-themes.php".$q);
			exit();
		case 'plugins':
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-plugins.php".$q);
			exit();
		case 'options':
			header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-options.php".$q);
			exit();
		default:
	}
}

// Print our header
printAdminHeader();

echo "\n</head>";
?>

<body>

<?php
// If they are not logged in, display the login form and exit

if (!zp_loggedin()) {
	$from = isset($_GET['from']) ? $_GET['from'] : null;
	printLoginForm($from);
	echo "\n</body>";
	echo "\n</html>";
	exit();

} else { /* Admin-only content safe from here on. */
	printLogoAndLinks();
	?>
<div id="main">
<?php printTabs($page); ?>
<div id="content">
<?php


/*** HOME ***************************************************************************/
/************************************************************************************/

$page = "home"; ?>
<?php
if (!empty($msg)) {
	echo '<div class="messagebox" id="fade-message">';
	echo  "<h2>$msg</h2>";
	echo '</div>';
}
?>
<div id="overview-leftcolumn">

<div class="box" id="overview-comments">
<h2 class="h2_bordered"><?php echo gettext("Gallery Stats"); ?></h2>
<ul>
<li>
<?php
$t = $gallery->getNumImages();
$c = $t-$gallery->getNumImages(true);
if ($c > 0) {
	printf(gettext('<strong>%1$u</strong> images (%2$u not visible)'),$t, $c);
} else {
	printf(gettext('<strong>%u</strong> images'),$t);
}
?>
</li>
<li>
<?php
$t = $gallery->getNumAlbums(true);
$c = $t-$gallery->getNumAlbums(true,true);
if ($c > 0) {
	printf(gettext('<strong>%1$u</strong> albums (%2$u not published)'),$t, $c);
} else {
	printf(gettext('<strong>%u</strong> albums'),$t);
}
?>
</li>

<li>
<?php $t = $gallery->getNumComments(true);
$c = $t - $gallery->getNumComments(false);
if ($c > 0) {
	if ($t != 1) {
		printf(gettext('<strong>%1$u</strong> comments (%2$u in moderation)'),$t, $c);
	} else {
		printf(gettext('<strong>1</strong> comment (%u in moderation)'), $c);
	}
} else {
	if ($t != 1) {
		printf(gettext('<strong>%u</strong> comments'),$t);
	} else {
		echo gettext('<strong>1</strong> comment');
	}
}
?>
</li></ul>
</div>

<div class="box" id="overview-comments">
<h2 class="h2_bordered"><?php echo gettext("Installation information"); ?></h2> 
<ul>
<?php

if (defined('RELEASE')) {
		$official = gettext('Official Build');
	} else {
		$official = gettext('SVN');
	}
	?>
	<li><?php printf(gettext('Zenphoto version <strong>%1$s [%2$s] (%3$s)</strong>'),ZENPHOTO_VERSION,ZENPHOTO_RELEASE,$official); ?></li>
	<?php	if (isset($zenpage_version)) printf(gettext('zenpage version <strong>%1$s [%2$s]</strong>'),$zenpage_version,ZENPAGE_RELEASE);	?>
	<li><?php printf(gettext('Current gallery theme: <strong>%1$s</strong>'),$gallery->getCurrentTheme()); ?></li> 
	<li><?php printf(gettext('PHP version: <strong>%1$s</strong>'),phpversion()); ?></li>
	<li><?php printf(gettext('PHP memory limit: <strong>%1$s</strong> (Note: Your server might allocate less!)'),INI_GET('memory_limit')); ?></li>
	<li><?php printf(gettext('MySQL version: <strong>%1$s</strong>'),mysql_get_client_info()); ?></li>
	<li><?php printf(gettext('Database name: <strong>%1$s</strong>'),$_zp_conf_vars['mysql_database']); ?></li>
	<li>
	<?php
	if(!empty($_zp_conf_vars['mysql_prefix'])) { 
		echo sprintf(gettext('Table prefix: <strong>%1$s</strong>'),$_zp_conf_vars['mysql_prefix']); 
	}
	?>
	</li>
	<li><?php printf(gettext('Spam filter: <strong>%s</strong>'), getOption('spam_filter')) ?></li>
	<li><?php printf(gettext('Captcha generator: <strong>%s</strong>'), getOption('captcha')) ?></li>
	</ul>

	<h3><?php echo gettext("Active plugins:"); ?></h3>
	<ul class="plugins">
	<?php
	$plugins = getEnabledPlugins();
	if (count($plugins) > 0) {
		natsort($plugins);
		foreach ($plugins as $extension) {
			$ext = substr($extension, 0, strlen($extension)-4);
			echo "<li>".$ext."</li>";
		}
	} else {
		echo '<li>'.gettext('<em>none</em>').'</li>';
	}
	?>
	</ul>
	<?php
	$filters = $_zp_filters;
	ksort($filters);
	?>
	<h3><?php echo gettext("Active filters:"); ?></h3>
	<ul class="plugins">
	<?php
	if (count($filters) > 0) {
		foreach ($filters as $filter=>$array_of_priority) {
			foreach ($array_of_priority as $priority=>$array_of_filters) {
				echo "<li><em>$filter</em>";
				?>
				<ul class="filters">
				<?php
				foreach ($array_of_filters as $data) {
					echo "<li><em>$priority</em>: ".$data['script'].' => '.$data['function'].'</li>';
				}
				echo '</li>';
				?>
				</ul>
				<?php
			}
		}
	} else {
		echo '<li>'.gettext('<em>none</em>').'</li>';
	}
	?>
	</ul>
</div>
<br clear="all" />
<?php
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'check_for_update') {
	$v = checkForUpdate();
	if (!empty($v)) {
		if ($v == 'X') {
			echo "\n<div style=\"font-size:150%;color:#ff0000;text-align:center;\">".gettext("Could not connect to  <a href=\"http://www.zenphoto.org\">zenphoto.org</a>")."</div>\n";
		} else {
			echo "\n<div style=\"font-size:150%;text-align:center;\"><a href=\"http://www.zenphoto.org\">". sprintf(gettext("zenphoto version %s is available."), $v)."</a></div>\n";
		}
	} else {
		echo "\n<div style=\"font-size:150%;color:#33cc33;text-align:center;\">".gettext("You are running the latest zenphoto version.")."</div>\n";
	}
}
?>

</div><!-- overview leftcolumn end -->
<div id="overview-rightcolumn">

<?php
$buttonlist = array();

$buttonlist[gettext("Check for zenphoto update")] = array(
							'formname'=>'check_updates',
							'action'=>'admin.php?check_for_update',
							'icon'=>'images/accept.png', 
							'title'=>gettext("Queries the Zenphoto web site for the latest version and compares that with the one that is running."),
							'alt'=>'',
							'hidden'=> '<input type="hidden" name="action" value="check_for_update">',
							'rights'=> ADMIN_RIGHTS
							);
$buttonlist[gettext("Refresh the Database")] = array(
							'formname'=>'prune_gallery',
							'action'=>'admin-refresh-metadata.php?prune',
							'icon'=>'images/refresh.png', 
							'title'=>gettext("Cleans the database and removes any orphan entries for comments, images, and albums."),
							'alt'=>'',
							'hidden'=> '<input type="hidden" name="prune" value="true">',
							'rights'=> ADMIN_RIGHTS
							);
$buttonlist[gettext("Purge cache")] = array(
							'formname'=>'clear_cache',
							'action'=>'admin.php?action=clear_cache=true',
							'icon'=>'images/edit-delete.png', 
							'title'=>gettext("Clears the image cache. Images will be re-cached as they are viewed."),
							'alt'=>'',
							'hidden'=> '<input type="hidden" name="action" value="clear_cache">',
							'rights'=> ADMIN_RIGHTS
							);
$buttonlist[gettext("Pre-Cache Images")] = array(
							'formname'=>'cache_images',
							'action'=>'admin-cache-images.php',
							'icon'=>'images/cache1.png', 
							'title'=>gettext("Finds newly uploaded images that have not been cached and creates the cached version. It also refreshes the numbers above. If you have a large number of images in your gallery you might consider using the <em>pre-cache image</em> link for each album to avoid swamping your browser."),
							'alt'=>'',
							'hidden'=> '',
							'rights'=> ADMIN_RIGHTS
							);
$buttonlist[gettext("Refresh Metadata")] = array(
							'formname'=>'refresh_metadata',
							'action'=>'admin-refresh-metadata.php',
							'icon'=>'images/redo.png', 
							'title'=>gettext("Forces a refresh of the EXIF and IPTC data for all images."),
							'alt'=>'',
							'hidden'=> '',
							'rights'=> ADMIN_RIGHTS
							);
$buttonlist[gettext("Reset hitcounters")] = array(
							'formname'=>'reset_hitcounters',
							'action'=>'admin.php?action=reset_hitcounters=true',
							'icon'=>'images/reset1.png', 
							'title'=>gettext("Sets all album and image hitcounters to zero."),
							'alt'=>'Reset hitcounters',
							'hidden'=> '<input type="hidden" name="action" value="reset_hitcounters">',
							'rights'=> ADMIN_RIGHTS
							);
?>
<div class="box" id="overview-maint">
<h2 class="h2_bordered"><?php echo gettext("Utility functions"); ?></h2>
<?php
$curdir = getcwd();
chdir(SERVERPATH . "/" . ZENFOLDER . UTILITIES_FOLDER);
$filelist = safe_glob('*'.'php');
natcasesort($filelist);
foreach ($filelist as $utility) {
	$button_text = '';
	$button_hint = '';
	$button_icon = '';
	$button_rights = false;
	
	$utilityStream = file_get_contents($utility);
	eval(isolate('$button_text', $utilityStream));
	eval(isolate('$button_hint', $utilityStream));
	eval(isolate('$button_icon', $utilityStream));
	eval(isolate('$button_rights', $utilityStream));
	
	$buttonlist[$button_text] = array(
								'formname'=>$utility,
								'action'=>'utilities/'.$utility,
								'icon'=>$button_icon, 
								'title'=>$button_hint,
								'alt'=>'',
								'hidden'=> '',
								'rights'=> $button_rights  | ADMIN_RIGHTS
								);
								
}
ksort($buttonlist);
$count = 0;
foreach ($buttonlist as $name=>$button) {
	if (zp_loggedin($button['rights'])) {
		$count ++;
	} else {
		unset($buttonlist[$name]);
	}
}
$count = round($count/2);
?>
	<div id="overview-maint_l">
	<?php
	foreach ($buttonlist as $name=>$button) {
		$button_icon = $button['icon'];
		?>
		<form name="<?php echo $button['formname']; ?>"	action="<?php echo $button['action']; ?>">
			<?php echo $button['hidden']; ?>
			<div class="buttons" id="home_exif">
			<button class="tooltip" type="submit"	title="<?php echo $button['title']; ?>">
			<?php if(!empty($button_icon)) echo '<img src="'.$button_icon.'" alt="'.$button['alt'].'" />'; echo $name; ?>
			</button>
			</div>
			<br clear="all" />
			<br clear="all" />
		</form>
		<?php
		$count --;
		if (!$count) { // half way through
			?>
			</div>
			<div id="overview-maint_r">
			<?php
		}
	}
	?>
	</div>
</div>
<div class="box" id="overview-maint">
<h2 class="h2_bordered"><?php echo gettext("10 Most Recent Comments"); ?></h2>
<ul>
<?php
$comments = fetchComments(10);
foreach ($comments as $comment) {
	$id = $comment['id'];
	$author = $comment['name'];
	$email = $comment['email'];
	$link = gettext('<strong>database error</strong> '); // incase of such
	
	// establish default values for all these fields in case of an error.
	if(getOption("zp_plugin_zenpage")) {
		require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-class-page.php');
		require_once(dirname(__FILE__).'/plugins/zenpage/zenpage-class-news.php');
	}
	// ZENPAGE: switch added for zenpage comment support
	switch ($comment['type']) {
		case "albums":
			$image = '';
			$title = '';
			$albmdata = query_full_array("SELECT `title`, `folder` FROM ". prefix('albums') .
 										" WHERE `id`=" . $comment['ownerid']);
			if ($albmdata) {
				$albumdata = $albmdata[0];
				$album = $albumdata['folder'];
				$albumtitle = get_language_string($albumdata['title']);
				$link = "<a href=\"".rewrite_path("/$album","/index.php?album=".urlencode($album))."\">".$albumtitle.$title."</a>";
				if (empty($albumtitle)) $albumtitle = $album;
			}
			break;
		case "news": // ZENPAGE: if plugin is installed
			if(getOption("zp_plugin_zenpage")) {
				$titlelink = '';
				$title = '';
				$newsdata = query_full_array("SELECT `title`, `titlelink` FROM ". prefix('zenpage_news') .
 										" WHERE `id`=" . $comment['ownerid']);
				if ($newsdata) {
					$newsdata = $newsdata[0];
					$titlelink = $newsdata['titlelink'];
					$title = get_language_string($newsdata['title']);
					$link = "<a href=\"".rewrite_path("/".ZENPAGE_NEWS."/".$titlelink,"/index.php?p=".ZENPAGE_NEWS."&amp;title=".urlencode($titlelink))."\">".$title."</a> ".gettext("[news]");
				}
			}
			break;
		case "pages": // ZENPAGE: if plugin is installed
			if(getOption("zp_plugin_zenpage")) {
				$image = '';
				$title = '';
				$pagesdata = query_full_array("SELECT `title`, `titlelink` FROM ". prefix('zenpage_pages') .
 										" WHERE `id`=" . $comment['ownerid']);
				if ($pagesdata) {
					$pagesdata = $pagesdata[0];
					$titlelink = $pagesdata['titlelink'];
					$title = get_language_string($pagesdata['title']);
					$link = "<a href=\"".rewrite_path("/".ZENPAGE_PAGES."/".$titlelink,"/index.php?p=".ZENPAGE_PAGES."&amp;title=".urlencode($titlelink))."\">".$title."</a> ".gettext("[page]");
				}
			}
			break;
		default: // all of the image types
			$imagedata = query_full_array("SELECT `title`, `filename`, `albumid` FROM ". prefix('images') .
 										" WHERE `id`=" . $comment['ownerid']);
			if ($imagedata) {
				$imgdata = $imagedata[0];
				$image = $imgdata['filename'];
				if ($imgdata['title'] == "") $title = $image; else $title = get_language_string($imgdata['title']);
				$title = '/ ' . $title;
				$albmdata = query_full_array("SELECT `folder`, `title` FROM ". prefix('albums') .
 											" WHERE `id`=" . $imgdata['albumid']);
				if ($albmdata) {
					$albumdata = $albmdata[0];
					$album = $albumdata['folder'];
					$albumtitle = get_language_string($albumdata['title']);
					$link = "<a href=\"".rewrite_path("/$album/$image","/index.php?album=".urlencode($album).	"&amp;image=".urlencode($image))."\">".$albumtitle.$title."</a>";
					if (empty($albumtitle)) $albumtitle = $album;
				}
			}
			break;
	}
	$comment = truncate_string($comment['comment'], 123);
	echo "<li><div class=\"commentmeta\">".sprintf(gettext('<em>%1$s</em> commented on %2$s:'),$author,$link)."</div><div class=\"commentbody\">$comment</div></li>";
}
?>
</ul>
</div>



</div><!-- overview rightcolumn end -->
<br clear="all" />
</div><!-- content -->
<?php
printAdminFooter();
} /* No admin-only content allowed after this bracket! */ ?></div>
<!-- main -->
</body>
<?php // to fool the validator
echo "\n</html>";
?>
