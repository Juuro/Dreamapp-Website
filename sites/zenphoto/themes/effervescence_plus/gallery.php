<?php require ('customfunctions.php'); $themeResult = getTheme($zenCSS, $themeColor, 'effervescence');normalizeColumns(3, 5);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/bluranchors.js"></script>
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); 	?>
</head>

<body onload="blurAnchors()">

	<!-- Wrap Header -->
	<div id="header">

	<!-- Logo -->
		<div id="gallerytitle">
			<div id="logo">
				<?php
				if (getOption('Allow_search')) {  printSearchForm(NULL, '', $_zp_themeroot.'/images/search.png'); }
				echo printLogo();
				?>
			</div>
		</div> <!-- gallerytitle -->

	<!-- Crumb Trail Navigation -->
		<div id="wrapnav">
			<div id="navbar">
				<span><?php printHomeLink('', ' | ');?>
				<?php
				if (getOption('custom_index_page') === 'gallery') {
				?>
				<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> | 
				<?php	
				}					
 				printGalleryTitle();
 				?>
				</span>
			</div>
		</div> <!-- wrapnav -->
	</div> <!-- header -->
	<!-- Random Image -->
	<?php printHeadingImage(getRandomImages()); ?>

	<!-- Wrap Main Body -->
	<div id="content">
		<div id="main">

		<!-- Album List -->
		<ul id="albums">
			<?php
			$firstAlbum = null;
			$lastAlbum = null;
			while (next_album()){
				if (is_null($firstAlbum)) {
					$lastAlbum = albumNumber();
					$firstAlbum = $lastAlbum;
				} else {
					$lastAlbum++;
				}
			?>
			<li>
				<?php $annotate =  annotateAlbum();	?>
				<div class="imagethumb">
				<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo $annotate; ?>">
						<?php printCustomAlbumThumbImage($annotate, null, 180, null, 180, 80); ?>
 				</a>
				</div>
				<h4><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo $annotate; ?>"><?php printAlbumTitle(); ?></a></h4>
			</li>
			<?php } ?>
		</ul>
		<div class="clearage"></div>
		<?php printNofM('Album', $firstAlbum, $lastAlbum, getNumAlbums()); ?>

		</div> <!-- main -->
		<!-- Page Numbers -->
		<div id="pagenumbers">
			<?php printPageListWithNav("&laquo; ".gettext('prev'), gettext('next')." &raquo;"); ?>
		</div>
	</div> <!-- content -->
	
	<br style="clear:all" />	

	<?php printFooter('gallery')?>

</body>
</html>