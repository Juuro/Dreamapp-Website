<?php if (!defined('WEBPATH')) die(); normalizeColumns(1, 7);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
		<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
<div id="main">
		<div id="gallerytitle">
			<h2><?php printHomeLink('', ' | '); echo getGalleryTitle();?></h2>
			<?php	if (getOption('Allow_search')) {  printSearchForm(); } ?>
		</div>

		<hr />
		<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;"); ?>

		<div id="albums">
			<?php while (next_album()): ?>

 			<div class="album">
					<div class="albumthumb">
							<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
						<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
						</div>
					<div class="albumtitle">
							<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
						<?php printAlbumTitle(); ?></a></h3> <?php printAlbumDate(); ?>
						</div>
					<div class="albumdesc"><?php printAlbumDesc(); ?></div>
			</div>
			<hr />

			<?php endwhile; ?>
		</div>
		<?php if (function_exists('printLanguageSelector')) { printLanguageSelector(); } ?>

		<?php printPageNav("&laquo; ".gettext("prev"), "|", gettext("next")." &raquo;"); ?>

		<div id="credit"><?php printRSSLink('Gallery','','RSS', ''); ?> | 
		<?php printZenphotoLink(); ?>
		 | <?php printCustomPageURL(gettext("Archive View"),"archive"); ?>
		<?php
		if (function_exists('printUserLogout')) {
			printUserLogout(' | ', '', true);
		}
		?>
		</div>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
