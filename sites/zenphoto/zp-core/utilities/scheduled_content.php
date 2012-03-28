<?php
/**
 * Manage the timing of publishing new content
 * 
 * This plugin allows you to change the default setting of the albums: published and 
 * the images: visible fields.
 * 
 * It also allows you to list unpublished albums and not visible images from before a
 * specific data and time. You can select albums and images from these lists to be published.
 * NOTE: currently there is no record of when albums were first encountered, so all unpublished 
 * albums are show.
 * 
 * So you can freely upload albums and images then on a periodic basis review which ones to make available
 * to visitors of your gallery.
 * 
 * @package admin
 */

$button_text = gettext('Publish content');
$button_hint = gettext('Manage unpublished content in your gallery.');
$button_icon = 'images/calendar.png';
$button_rights = EDIT_RIGHTS;

define('OFFSET_PATH', 3);
define('RECORD_SEPARATOR', ':****:');
define('TABLE_SEPARATOR', '::');
define('RESPOND_COUNTER', 1000);

chdir(dirname(dirname(__FILE__)));

require_once(dirname(dirname(__FILE__)).'/template-functions.php');
require_once(dirname(dirname(__FILE__)).'/admin-functions.php');


if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

if (!($_zp_loggedin & (ADMIN_RIGHTS | EDIT_RIGHTS))) { // prevent nefarious access to this page.
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin.php");
	exit();
}

$gallery = new Gallery();
$webpath = WEBPATH.'/'.ZENFOLDER.'/';

printAdminHeader($webpath);
?>
<style type="text/css">
.schedulealbumchecklist li {
	background: none;
	padding-left: 0;
	text-align: left;
	
}

.schedulealbumchecklist {
	border: 1px solid #ccc;
	list-style: none;
	height: 8em;
	overflow: auto;
	width: 50em;
	background-color: white;
}

.schedulealbumchecklist,.schedulealbumchecklist li {
	margin: 0;
	padding: 0;
	border-bottom: 1px dotted #C6D880;
}

.schedulealbumchecklist label {
	display: block;
	padding: 0 0.2em 0 25px;
	text-indent: -25px;
}

.schedulealbumchecklist label:hover,.schedulealbumchecklist label.hover {
	background: #777;
	color: #fff;
}

* html .schedulealbumchecklist label {
	height: 1%;
}
.schedulealbumchecklist li {
	background: none;
	padding-left: 0;
	text-align: left;
	
}

.scheduleimagechecklist {
	border: 1px solid #ccc;
	list-style: none;
	height: 20em;
	overflow: auto;
	width: 50em;
	background-color: white;
}

.scheduleimagechecklist,.scheduleimagechecklist li {
	margin: 0;
	padding: 0;
	border-bottom: 1px dotted #C6D880;
}

.scheduleimagechecklist label {
	display: block;
	padding: 0 0.2em 0 25px;
	text-indent: -25px;
}

.scheduleimagechecklist label:hover,.scheduleimagechecklist label.hover {
	background: #777;
	color: #fff;
}

* html .scheduleimagechecklist label {
	height: 1%;
}
</style>
<?php
echo '</head>';
?>

<body>
<?php printLogoAndLinks(); ?>
<div id="main">
<?php printTabs('content'); ?>
<div id="content">
<h1><?php echo (gettext('Manage content publication')); ?></h1>
<?php
$publish_albums_list = array();
$publish_images_list = array();
if (db_connect()) {
	if (isset($_POST['set_defaults'])) {
		if (isset($_POST['album_default'])) {
			$albpublish = 1;
		} else {
			$albpublish = 0;
		}
		$sql = "ALTER TABLE ".prefix('albums').' CHANGE `show` `show` INT( 1 ) NOT NULL DEFAULT "'.$albpublish.'"';
		query($sql);
		if (isset($_POST['image_default'])) {
			$imgpublish = 1;
		} else {
			$imgpublish = 0;
		}
		$sql = "ALTER TABLE ".prefix('images').' CHANGE `show` `show` INT( 1 ) NOT NULL DEFAULT "'.$imgpublish.'"';
		query($sql);
	} else if (isset($_POST['publish_albums'])) {
		$sql = '';
		unset($_POST['publish_albums']);
		foreach ($_POST as $key=>$albumid) {
			$albumid = sanitize_numeric($albumid);
			if (is_numeric($key)) {
				$sql .= '`id`="'.sanitize_numeric($albumid).'" OR ';
			}
		}
		if (!empty($sql)) {
			$sql = substr($sql, 0, -4);
			$sql = 'UPDATE '.prefix('albums').' SET `show`="1" WHERE '.$sql;
		query($sql);
		}
	} else if (isset($_POST['publish_images'])) {
		unset($_POST['publish_images']);
		$sql = '';
		foreach ($_POST as $key=>$imageid) {
			$imageid = sanitize_numeric($imageid);
			if (is_numeric($key)) {
				$sql .= '`id`="'.$imageid.'" OR ';
			}
		}
		if (!empty($sql)) {
			$sql = substr($sql, 0, -4);
			$sql = 'UPDATE '.prefix('images').' SET `show`="1" WHERE '.$sql;
			query($sql);
	}
	}
	?>
	<h3><?php gettext("database connected"); ?></h3>
	<br />
	<?php
	$sql = 'SHOW COLUMNS FROM '.prefix('albums');
	$result = query_full_array($sql);
	if (is_array($result)) {
		foreach ($result as $row) {
			if ($row['Field'] == 'show') {
				$albpublish = $row['Default'];
				break;	
			}
		}
	}
	$sql = 'SHOW COLUMNS FROM '.prefix('images');
	$result = query_full_array($sql);
	if (is_array($result)) {
		foreach ($result as $row) {
			if ($row['Field'] == 'show') {
				$imgpublish = $row['Default'];
				break;	
			}
		}
	}
	if (isset($_POST['publish_date']))	{
		$requestdate = dateTimeConvert(sanitize($_POST['publish_date']));
	} else {
		$requestdate = date('Y-m-d H:i:s');
	}
	
	$albumidlist = '';
	$albumids = '';
	if (!($_zp_loggedin & ADMIN_RIGHTS)) {
		$albumlist = getManagedAlbumList();
		$albumIDs = array();
		foreach ($albumlist as $albumname) {
			$subalbums = getAllSubAlbumIDs($albumname);
			foreach($subalbums as $ID) {
				$albumIDs[] = $ID['id'];
			}
		}
		$i = 0;
		foreach ($albumIDs as $ID) {
			if ($i>0) {
				$albumidlist .= ' OR ';
				$albumids .= ' OR ';
			}
			$albumidlist .= prefix('images').'.albumid='.$ID;
			$albumids .= '`id`='.$ID;
			$i++;
		}
		if (!empty($albumlist)) {
			$albumids = ' AND ('.$albumids.')';
			$albumidlist = ' AND ('.$albumidlist.')';
		}
	}

	$mtime = dateTimeConvert(sanitize($requestdate), true);
	$sql = "SELECT `folder`, `id` FROM ".prefix('albums').' WHERE `show`="0"'.$albumids;
	$result = query_full_array($sql);
	if (is_array($result)) {
		foreach ($result as $row) {
			$publish_albums_list[$row['folder']] = $row['id'];
		}
	}
	$sql = 'SELECT `filename`, '.prefix('images').'.id as id, folder FROM '.prefix('images').','.prefix('albums').' WHERE '.prefix('images').'.show="0" AND '.
					prefix('images').'.mtime < "'.$mtime.'" AND '.prefix('albums').'.id='.prefix('images').'.albumid'.$albumidlist;
	$result = query_full_array($sql);
	if (is_array($result)) {
		foreach ($result as $row) {
			$publish_images_list[$row['folder']][$row['filename']] =$row['id'];
		}
	}
	?>
<?php if ($_zp_loggedin & ADMIN_RIGHTS) { ?>
<form name="set_publication" action="" method="post">
<input type="hidden" name="set_defaults" value="true">
		<input type="checkbox" name="album_default"	value=1<?php if ($albpublish) echo ' checked'; ?>> <?php echo gettext("Publish albums by default"); ?>
		<br />
		<input type="checkbox" name="image_default"	value=1<?php if ($imgpublish) echo ' checked'; ?>> <?php echo gettext("Make images visible by default"); ?>
		<br />
<div class="buttons pad_button" id="setdefaults">
<button class="tooltip" type="submit" title="<?php echo gettext("Set defaults for album publishing and image visibility."); ?>">
	<img src="<?php echo $webpath; ?>images/burst1.png" alt="" /> <?php echo gettext("Set defaults"); ?>
</button>
</div>
<br clear="all" />
<br clear="all" />
</form>
<br />
<?php 
}
if (count($publish_albums_list) > 0) { 
?>
	<form name="publish" action="" method="post"><?php echo gettext('Unpublished albums:'); ?>
	<input type="hidden" name="publish_albums" value="true">
	<ul class="schedulealbumchecklist">
	<?php	generateUnorderedListFromArray($publish_albums_list, $publish_albums_list, '', false, true, true); ?>
	</ul>
	<div class="buttons pad_button" id="publishalbums">
	<button class="tooltip" type="submit" title="<?php echo gettext("Publish waiting albums."); ?>">
		<img src="<?php echo $webpath; ?>images/cache1.png" alt="" /> <?php echo gettext("Publish albums"); ?>
	</button>
	</div>
	<br clear="all" />
	<br clear="all" />
	</form>
<?php
	} else {
		echo '<p>'.gettext('No albums are unpublished.').'</p>';
	}
?>

<form name="review" action="" method="post">
<?php printf(gettext('Review images older than: %s'),'<input type="text" size="20" name="publish_date" value="'.$requestdate.'" />'); ?>
<input type="hidden" name="review" value="true">

<div class="buttons pad_button" id="reviewobjects">
<button class="tooltip" type="submit" title="<?php echo gettext("Review not visible images."); ?>">
	<img src="<?php echo $webpath; ?>images/quest.png" alt="" /> <?php echo gettext("Review images"); ?>
</button>
</div>
<br clear="all" />
<br clear="all" />
</form>

<?php
if (count($publish_images_list) > 0) { 
?>
	<form name="publish" action="" method="post"><?php echo gettext('Set visible:'); ?>
	<input type="hidden" name="publish_images" value="true">
	<ul class="scheduleimagechecklist">
	<?php
	foreach ($publish_images_list as $key=>$imagelist) {
		echo '<strong>'.$key.'</strong>';
		generateUnorderedListFromArray($imagelist, $imagelist, '', false, true, true); 
	}
	?>
	</ul>
	<div class="buttons pad_button" id="setvisible">
	<button class="tooltip" type="submit" title="<?php echo gettext("Set waiting images to visible."); ?>">
		<img src="<?php echo $webpath; ?>images/cache1.png" alt="" /> <?php echo gettext("Make images visible"); ?>
	</button>
	</div>
	<br clear="all" />
	<br clear="all" />
	</form>
<?php
	} else {
		echo '<p>'.gettext('No images meet the criteria.').'</p>';
	}
} else {
	echo "<h3>".gettext("database not connected")."</h3>";
	echo "<p>".gettext("Check the zp-config.php file to make sure you've got the right username, password, host, and database. If you haven't created the database yet, now would be a good time.");
}
?>
</div>
<!-- content --></div>
<!-- main -->
<?php printAdminFooter(); ?>
</body>
<?php echo "</html>"; ?>




