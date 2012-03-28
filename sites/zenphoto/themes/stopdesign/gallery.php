<?php
if (!defined('WEBPATH')) die();
require_once('normalizer.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> <?php echo gettext("Archive"); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $_zp_themeroot ?>/css/master.css" />
	<?php
	printRSSHeaderLink('Gallery','Gallery RSS');
	setOption('thumb_crop_width', 85, false);
	setOption('thumb_crop_height', 85, false);
	?>
</head>

<body class="archive">
	<?php echo getGalleryTitle(); ?><?php if (getOption('Allow_search')) {  printSearchForm(); } ?>

<div id="content">

	<h1><?php printGalleryTitle(); echo ' | '.gettext('Archive'); ?></h1>

	<div class="galleries">
 	<?php if (!checkForPassword()) {?>
		<h2><?php echo gettext("All galleries"); ?></h2>
		<ul>
			<?php
			$counter = 0;
			while (next_album()):
			?>
			<li class="gal">
			<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:').' '; echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
			<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:').' '; echo getAnnotatedAlbumTitle();?>" class="img"><?php printCustomAlbumThumbImage(getAnnotatedAlbumTitle(), null, 210, 59, 210, 59); ?></a>
			<p>
			<?php
			$anumber = getNumSubalbums();
			$inumber = getNumImages();
			if ($anumber > 0 || $inumber > 0) {
				echo '<p><em>(';
				if ($anumber == 0 && $inumber == 1) {
					printf(gettext('1 photo'));
				} else if ($anumber == 0 && $inumber > 1) {
					printf(gettext('%u photos'), $inumber);
				} else if ($anumber == 1 && $inumber == 1) {
					printf(gettext('1 album,&nbsp;1 photo'));
				} else if ($anumber > 1 && $inumber == 1) {
					printf(gettext('%u album,&nbsp;1 photo'), $anumber);
				} else if ($anumber > 1 && $inumber > 1) {
					printf(gettext('%1$u album,&nbsp;%2$u photos'), $anumber, $inumber);
				} else if ($anumber == 1 && $inumber == 0) {
					printf(gettext('1 album'));
				} else if ($anumber > 1 && $inumber == 0) {
					printf(gettext('%u album'),$anumber);
				} else if ($anumber == 1 && $inumber > 1) {
					printf(gettext('1 album,&nbsp;%u photos'), $inumber);
				}
				echo ')</em><br/>';
			}
			$text = getAlbumDesc();
			if(strlen($text) > 100) { $text = preg_replace("/[^ ]*$/", '', substr($text, 0, 100)) . "..."; }
			echo $text;
			?></p>
			<div class="date"><?php printAlbumDate(); ?></div>
			</li>
			<?php
			if ($counter == 2) {
				echo "</ul><ul>";
			}
			$counter++;
			endwhile;
			?>
		</ul>
			<div class="archiveinfo">
				<br />
				<p>
				<?php if (hasPrevPage()) { ?>
						<a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>" accesskey="x">&laquo; <?php echo gettext('prev page'); ?></a>
				<?php } ?>
				<?php if (hasNextPage()) { if (hasPrevPage()) { echo '&nbsp;'; } ?>
						<a href="<?php echo htmlspecialchars(getNextPageURL()); ?>" accesskey="x"><?php echo gettext('next page'); ?> &raquo;</a>
				<?php } ?>
				</p>
			</div>
	<?php } ?>
</div>

<div id="feeds">
	<h2><?php echo gettext('Gallery Feeds'); ?></h2>
	<ul>
		<li><?php echo "<a href='http://".sanitize($_SERVER['HTTP_HOST']).WEBPATH."/rss.php' class=\"i\">"; ?><img src="<?php echo WEBPATH; ?>/zp-core/images/rss.gif" /> <?php echo gettext('Photos'); ?></a></li>
		<li><?php echo "<a href='http://".sanitize($_SERVER['HTTP_HOST']).WEBPATH."/rss-comments.php' class=\"i\">"; ?><img src="<?php echo WEBPATH; ?>/zp-core/images/rss.gif" /> <?php echo gettext('Comments'); ?></a></li>
	</ul>
</div>

</div>

<p id="path">
	<?php printHomeLink('', ' > '); ?>
	<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> &gt;
	<?php echo getGalleryTitle();?> 
	<?php echo gettext('Gallery Archive'); ?>
</p>

<div id="footer">
	<hr />
	<p>
		<?php echo gettext('<a href="http://stopdesign.com/templates/photos/">Photo Templates</a> from Stopdesign');?>.
		<?php printZenphotoLink(); ?>
	</p>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
