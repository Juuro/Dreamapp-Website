<?php
/**
 * Use this utility to reset your album thumbnails to either "random" or "first image"
 * 
 * @package admin
 */

$button_text = gettext('Reset thumbs');
$button_hint = gettext('Reset album thumbnails.');
$button_icon = 'images/burst1.png';
$button_rights = ADMIN_RIGHTS;

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

if (!is_null(getOption('admin_reset_date'))) {
	if (!($_zp_loggedin & ADMIN_RIGHTS)) { // prevent nefarious access to this page.
		header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin.php");
		exit();
	}
}

$buffer = '';
$gallery = new Gallery();
$webpath = WEBPATH.'/'.ZENFOLDER.'/';

printAdminHeader($webpath);
echo '</head>';
?>

<body>
<?php printLogoAndLinks(); ?>
<div id="main">
<?php printTabs('database'); ?>
<div id="content">
<h1><?php echo (gettext('Reset your album thumbnails')); ?></h1>
<?php
if (isset($_REQUEST['thumbtype']) && db_connect()) {
	$value = sanitize($_REQUEST['thumbtype'], 3);
	$sql = 'UPDATE '.prefix('albums').' SET `thumb`="'.$value.'"';
	if (query($sql)) {
		if ($value == '') {
			$reset = 'Random';
		} else {
			$reset = 'most recent';
		}
		?>
		<div class="messagebox" id="fade-message">
		<h2><?php printf(gettext("Thumbnails all set to <em>%s</em>."), $reset); ?></h2>
		</div>
		<?php
	} else {
		?>
		<div class="errorbox" id="fade-message">
		<h2><?php echo gettext("Thumbnail reset query failed"); ?></h2>
		</div>
		<?php
	}
}
if (db_connect()) {
	?>
	<form name="set_random" action="">
	<input type="hidden" name="thumbtype" value="">
	<div class="buttons pad_button" id="set_random">
	<button class="tooltip" type="submit" title="<?php echo gettext("Sets all album thumbs to <em>random</em>."); ?>">
		<img src="<?php echo $webpath; ?>images/burst1.png" alt="" /> <?php echo gettext("Set to random"); ?>
	</button>
	</div>
	<br clear="all" />
	<br clear="all" />
	</form>
	<br />
	<br />
		<form name="set_first" action="">
		<input type="hidden" name="thumbtype" value="1">
		<div class="buttons pad_button" id="set_first">
		<button class="tooltip" type="submit" title="<?php echo gettext("Set all album thumbs to use the <em>most recent</em> image."); ?>">
			<img src="<?php echo $webpath; ?>images/burst1.png" alt="" /> <?php echo gettext("Set to most recent"); ?>
		</button>
		</div>
		<br clear="all" />
		<br clear="all" />
		</form>
	<?php
} else {
	echo "<h3>".gettext("database not connected")."</h3>";
	echo "<p>".gettext("Check the zp-config.php file to make sure you've got the right username, password, host, and database. If you haven't created the database yet, now would be a good time.");
}
echo	'<p>';
echo gettext('This utility allows you to set all of your album thumbs to either a <em>random</em> image or to the <em>most recent</em> image.').' '; 
echo gettext('This will override any album thumb selections you have made on individual albums.').' ';
echo '</p>'
?>
</div>
<!-- content --></div>
<!-- main -->
<?php printAdminFooter(); ?>
</body>
<?php echo "</html>"; ?>




