<?php require ('customfunctions.php');
$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext('Object not found'); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
</head>

<body>

	<!-- Wrap Header -->
	<div id="header">
		<div id="gallerytitle">

		<!-- Logo -->
			<div id="logo">
			<?php printLogo(); ?>
			</div>
		</div>

		<!-- Crumb Trail Navigation -->
		<div id="wrapnav">
			<div id="navbar">
				<span><?php printHomeLink('', ' | '); ?>
				<?php
			if (getOption('custom_index_page') === 'gallery') {
				?>
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> | 
				<?php	
				}					
				?>
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a></span>  | 
				<?php echo gettext('Object not found'); ?>
			</div>
		</div>

	</div>

	<!-- Wrap Main Body -->
	<div id="content">
		<small>&nbsp;</small>
		<div id="main">
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

	<!-- Footer -->
	<div class="footlinks">
		<small><?php printThemeInfo(); ?></small>
		<?php printZenphotoLink(); ?>
		<br/>
	</div>
	
<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>