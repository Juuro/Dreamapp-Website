<?php
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> &gt; <?php echo gettext("Object not found"); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $_zp_themeroot ?>/css/master.css" />
</head>

<body class="gallery">
	<?php echo getGalleryTitle(); ?>

	<div id="content">

		<div class="galleryinfo">
		<?php
		  echo "<h1><em>". gettext('Object not found'). "</em></h1>";
		?>
		</div>

	<div class="galleryinfo">
		<?php
		echo gettext("The Zenphoto object you are requesting cannot be found.").'<br/>';
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

	<p id="path">
		<?php printHomeLink('', ' > '); ?>
		<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> &gt; 
		<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>">
		<?php echo getGalleryTitle();?></a> &gt;
		<?php
		echo "<em>".gettext('Object not found')."</em>";
		?>
	</p>

	<div id="footer">
		<hr />
		<p>
		<?php printZenphotoLink(); ?>
		</p>
	</div>
	<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>
</body>
</html>
