<?php
if (!defined('WEBPATH')) die();
require_once('normalizer.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> &gt; <?php echo getBareAlbumTitle(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $_zp_themeroot ?>/css/master.css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>

<body class="gallery">
		<?php
		echo getGalleryTitle();
			if (getOption('Allow_search')) {  printSearchForm(); }
		?>

		<div id="content">

				<div class="galleryinfo">
					<h1><?php printAlbumTitle(true);?></h1>
					<p class="desc"><?php printAlbumDesc(true); ?></p>
				</div>

		<?php
				$first = true;
				while (next_album()) {
					if ($first) {
						echo '<div class="galleries">';
						echo "\n<h2></h2>\n<ul>\n";
						$first = false;
					}
				?>
				<li class="gal">
					<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:').' '; echo getAnnotatedAlbumTitle();?>" class="img"><?php printCustomAlbumThumbImage(getAnnotatedAlbumTitle(), null, 210, null, 210, 60); ?></a>
					<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:').' '; echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
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
						if(strlen($text) > 50) {
							$text = preg_replace("/[^ ]*$/", '', substr($text, 0, 50))."...";
						}
						echo $text;
					?>
					</p>
				</li>
		<?php
			}
			if (!$first) { echo "\n</ul>\n</div>\n"; }
		?>

		<ul class="slideset">
		<?php

			$firstImage = null;
			$lastImage = null;
			if ($myimagepage > 1) {
			?>
			<li class="thumb"><span class="backward"><em style="background-image:url('<?php echo $_zp_themeroot ?>/images/moreslide_prev.gif');"><a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>" style="background:#fff;"><?php echo gettext('Next page'); ?></a></em></span></li>
			<?php
			}
			while (next_image(false, $firstPageImages)) {
				if (is_null($firstImage)) {
					$lastImage = imageNumber();
					$firstImage = $lastImage;
				} else {
					$lastImage++;
				}
			if (isLandscape()) {
				$iw = 89;
				$ih = NULL;
				$cw = 89;
				$ch = 67;
			} else {
				$iw = NULL;
				$ih = 89;
				$ch = 89;
				$cw = 67;
			}
			echo '<li class="thumb"><span><em style="background-image:url(' . htmlspecialchars($_zp_current_image->getCustomImage(NULL, $iw, $ih, $cw, $ch, NULL, NULL, true)) . '); "><a href="' . htmlspecialchars(getImageLinkURL()) . '" title="' . getAnnotatedImageTitle() . '" style="background:#fff;">"'.getImageTitle().'"</a></em></span></li>';
			}
			if (!is_null($lastImage)  && $lastImage < getNumImages()) {
				$np = getCurrentPage()+1;
			?>
			<li class="thumb"><span class="forward"><em style="background-image:url('<?php echo $_zp_themeroot ?>/images/moreslide_next.gif');">
			<a href="<?php echo htmlspecialchars(getPageURL($np, $np)); ?>" style="background:#fff;"><?php echo gettext('Next page'); ?></a></em></span></li>
		<?php
			}
		?>
		</ul>

			<div class="galleryinfo">
				<br />
				<p><?php printRSSLink('Album', '', gettext('Album RSS feed').' ', '', true, 'i'); ?></p>
				<br />
				<p>
				<?php
					if (!is_null($firstImage)) {
						echo '<em class="count">';
						printf(gettext('photos %1$u-%2$u of %3$u'), $firstImage, $lastImage, getNumImages());
						echo "</em>";
						}
				?>
				<?php if (function_exists('printSlideShowLink') && isImagePage()) printSlideShowLink(gettext('View Slideshow')); ?>
				<?php if (hasPrevPage()) { ?>
						<a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>" accesskey="x">&laquo; <?php echo gettext('prev page'); ?></a>
				<?php } ?>
				<?php if (hasNextPage()) { if (hasPrevPage()) { echo '&nbsp;'; } ?>
						<a href="<?php echo htmlspecialchars(getNextPageURL()); ?>" accesskey="x"><?php echo gettext('next page'); ?> &raquo;</a>
				<?php } ?>
				</p>
			</div>
		</div>

		<p id="path">
			<?php printHomeLink('', ' > '); ?>
			<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> &gt; 
			<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> &gt; <?php printParentBreadcrumb("", " > ", " > "); ?> <?php printAlbumTitle(false);?>
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
