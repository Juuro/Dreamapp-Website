<?php if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); $firstPageImages = normalizeColumns('2', '6');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Search"); ?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
  <script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/prototype.js" type="text/javascript"></script>
</head>

<body>

<div id="main">

	<div id="gallerytitle">
		<?php
			printSearchForm();
		?>
		<h2><span><?php printHomeLink('', ' | '); ?><a href="
		<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo ('Gallery Index'); ?>">
		<?php echo getGalleryTitle();?></a></span> |
		<?php
		  echo "<em>".gettext("Search")."</em>";
		?>
		</h2>
	</div>

		<div id="padbox">
		<?php
		if (($total = getNumImages() + getNumAlbums()) > 0) {
			if (isset($_REQUEST['date'])){
				$searchwords = getSearchDate();
 		} else { $searchwords = getSearchWords(); }
			echo '<p>'.sprintf(gettext('Total matches for <em>%1$s</em>: %2$u'), $searchwords, $total).'</p>';
		}
		$c = 0;
		?>
<div id="albums">
			<?php while (next_album()): $c++;?>
				<div class="album">
					<div class="thumb">
						<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:');?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
					</div>
					<div class="albumdesc">
						<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:');?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
						<p><?php printAlbumDesc(); ?></p>
						<small><?php printAlbumDate(gettext("Date:").' '); ?> </small>
					</div>
					<p style="clear: both; "></p>
				</div>
			<?php endwhile; ?>
			</div>

			<div id="images">
				<?php while (next_image(false, $firstPageImages)): $c++;?>
				<div class="image">
					<div class="imagethumb"><a href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getAnnotatedImageTitle()); ?></a></div>
				</div>
				<?php endwhile; ?>
			</div>
		<br clear=all>
		<?php
		if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow'));
		if ($c == 0) {
				echo "<p>".gettext("Sorry, no image matches. Try refining your search.")."</p>";
			}

			printPageListWithNav("&laquo; ".gettext("prev"),gettext("next")." &raquo;");
			?>

	</div>

</div>

<div id="credit"><?php printRSSLink('Gallery', '', gettext('Gallery RSS'), ' | '); ?> <?php printCustomPageURL(gettext("Archive View"),"archive"); ?> | 
<?php printZenphotoLink(); ?>
</div>

<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>