<?php if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); $firstPageImages = normalizeColumns('2', '6');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Archive View"); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>

<body>

<div id="main">

	<div id="gallerytitle">
			<?php if (getOption('Allow_search')) {  printSearchForm(); } ?>
		<h2>
		<span>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo getGalleryTitle();?></a>
		</span> | <?php echo gettext("Archive View"); ?>
		</h2>
	</div>

		<div id="padbox">
 		<?php if (!checkForPassword()) {?>
		<div id="archive"><?php printAllDates(); ?></div>
		<div id="tag_cloud">
					<p><? echo gettext('Popular Tags'); ?></p>
			<?php printAllTagsAs('cloud', 'tags'); ?>
				</div>
 		<?php } ?>
	</div>

</div>

<div id="credit"><?php printRSSLink('Gallery','','RSS', ' | '); ?> 
<?php printZenphotoLink(); ?>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
