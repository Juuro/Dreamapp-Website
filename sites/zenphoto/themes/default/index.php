<?php if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); $firstPageImages = normalizeColumns('2', '6');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>

<body>

<div id="main">

	<div id="gallerytitle">
		<?php if (getOption('Allow_search')) {  printSearchForm(''); } ?>
		<h2><?php printHomeLink('', ' | '); echo getGalleryTitle(); ?></h2>
	</div>

		<div id="padbox">

		<div id="albums">
			<?php while (next_album()): ?>
			<div class="album">
						<div class="thumb">
					<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
 						 </div>
						<div class="albumdesc">
					<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
 							<small><?php printAlbumDate(""); ?></small>
					<p><?php printAlbumDesc(); ?></p>
				</div>
				<p style="clear: both; "></p>
			</div>
			<?php endwhile; ?>
		</div>
		<br clear="all" />
		<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;"); ?>
	</div>

</div>
<?php if (function_exists('printLanguageSelector')) { printLanguageSelector(); } ?>

<div id="credit"><?php printRSSLink('Gallery','','RSS', ' | '); ?> <?php printCustomPageURL(gettext("Archive View"),"archive"); ?> | 
<?php printZenphotoLink(); ?>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
