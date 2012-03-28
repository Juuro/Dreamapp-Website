<?php require ('customfunctions.php');
define('ALBUMCOLUMNS', 3);
define('IMAGECOLUMNS', 5);
$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
normalizeColumns(ALBUMCOLUMNS, IMAGECOLUMNS);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext('Archive'); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/bluranchors.js"></script>
</head>

<body onload="blurAnchors()">

	<!-- Wrap Header -->
	<div id="header">
		<div id="gallerytitle">

		<!-- Logo -->
			<div id="logo">
			<?php printLogo(); ?>
			</div>
		</div> <!-- gallerytitle -->

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
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a></span>  | <?php echo gettext('Archive View'); ?>
			</div>
		</div> <!-- wrapnav -->

		<!-- Random Image -->
		<?php printHeadingImage(getRandomImages()); ?>
	</div> <!-- header -->

	<!-- Wrap Main Body -->
	<div id="content">
	
		<small>&nbsp;</small>
		<div id="main2">
		<?php 
		if ($zenpage = getOption('zp_plugin_zenpage')) {
		?>
			<div id="content-left">
			<?php 
		}
			 if (!checkForPassword()) {?>
				<!-- Date List -->
				<div id="archive"><p><?php echo gettext('Images By Date'); ?></p><?php printAllDates('archive', 'year', 'month', 'desc'); ?></div>
				<div id="tag_cloud"><p><?php echo gettext('Popular Tags'); ?></p><?php printAllTagsAs('cloud', 'tags'); ?></div>
					<?php if ($zenpage = getOption('zp_plugin_zenpage')) { ?>
					<?php if(function_exists("printNewsArchive")) { ?>
						<div id="archive_news"><p><?php echo('News archive') ?></p><?php printNewsArchive("archive");	?></div>
					<?php }	?>
					</div><!-- content left-->
					<div id="sidebar">
					<?php include("sidebar.php"); ?>
					</div><!-- sidebar -->
				<?php 
				}
			} ?>
			<br style="clear:both" />
		</div> <!-- main2 -->
		
	</div> <!-- content -->

<?php printFooter('rchive'); ?>

</body>
</html>