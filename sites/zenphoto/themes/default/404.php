<?php if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Object not found"); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
</head>

<body>

<div id="main">

	<div id="gallerytitle">
		<h2>
		<span>
		<?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo getGalleryTitle();?></a>
		</span> | <?php echo gettext("Object not found"); ?>
		</h2>
	</div>

		<div id="padbox">
 		<?php
		echo gettext("The Zenphoto object you are requesting cannot be found.");
		if (isset($album)) {
			echo '<br />'.sprintf(gettext('Album: %s'),sanitize($album));
		}
		if (isset($image)) {
			echo '<br />'.sprintf(gettext('Image: %s'),sanitize($image));
		}
		if (isset($obj)) {
			echo '<br />'.sprintf(gettext('Page: %s'),substr(basename($obj),0,-4));
		}
 		?>
	</div>

</div>

<div id="credit">
<?php printZenphotoLink(); ?>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
