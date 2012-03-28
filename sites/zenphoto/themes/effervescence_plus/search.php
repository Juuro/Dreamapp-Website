<?php
define('ALBUMCOLUMNS', 3);
define('IMAGECOLUMNS', 5);
if (!defined('WEBPATH')) die();
$_noFlash = true;  /* don't know how to deal with the variable folder depth file names
if ((getOption('Use_Simpleviewer')==0) || !getOption('mod_rewrite')) { $_noFlash = true; }

if (isset($_GET['noflash'])) {
	$_noFlash = true;
	zp_setcookie("noFlash", "noFlash");
	} elseif (zp_getCookie("noFlash") != '') {
	$_noFlash = true;
	}
	*/

if (!isset($_GET['format']) || $_GET['format'] != 'xml') {
require_once ('customfunctions.php');

// Change the configuration here

$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
$firstPageImages = normalizeColumns(ALBUMCOLUMNS, IMAGECOLUMNS);
if ($_noFlash) {
	$backgroundColor = "#0";  /* who cares, we won't use it */
} else {
	$backgroundColor = parseCSSDef($zenCSS);
}

$maxImageWidth="600";
$maxImageHeight="600";

$preloaderColor="0xFFFFFF";
$textColor="0xFFFFFF";
$frameColor="0xFFFFFF";

$frameWidth="10";
$stagePadding="20";

$thumbnailColumns="3";
$thumbnailRows="6";
$navPosition="left";

$enableRightClickOpen="true";

$backgroundImagePath="";
// End of config

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Search"); ?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/bluranchors.js"></script>
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/swfobject.js"></script>
</head>

<body onload="blurAnchors()">

<!-- Wrap Header -->
<div id="header">
	<div id="gallerytitle">

<!-- Logo -->
	<div id="logo">
	<?php
	if (getOption('Allow_search')) {  printSearchForm(NULL, '', $_zp_themeroot.'/images/search.png'); }
		echo printLogo();
	?>
	</div> <!-- logo -->
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
		<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>">
		<?php echo getGalleryTitle();	?></a></span> |
		<?php
		  echo "<em>".gettext('Search')."</em>";
		?>
	</div>
</div> <!-- wrapnav -->

</div> <!-- header -->

<!-- Wrap Subalbums -->
<div id="subcontent">
<div id="submain">

<!-- Album Description -->
<div id="description">
		<?php
			$total = getNumAlbums() + getNumImages();
			$searchwords = getSearchWords();
			$searchdate = getSearchDate();
			if (!empty($searchdate)) {
				if (!empty($seachwords)) {
					$searchwords .= ": ";
				}
				$searchwords .= $searchdate;
			}
			if ($total > 0 ) {
				if ($total > 1) { 
					printf('%1$u Hits for <em>%2$s</em>', $total, $searchwords); 
				} else {
					printf('1 Hit for <em>%s</em>', $searchwords); 
				}
			}
		?>
</div>

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
			<?php $annotate = annotateAlbum();?>
			<div class="imagethumb">
			<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo $annotate; ?>">
				<?php printCustomAlbumThumbImage($annotate, null, 180, null, 180, 80); ?></a></div>
				<h4><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo $annotate;	?>">
			<?php printAlbumTitle(); ?></a></h4></li>
		<?php
			}
		?>
	</ul>
	<div class="clearage"></div>
	<?php printNofM('Album', $firstAlbum, $lastAlbum, getNumAlbums()); ?>
</div>

<!-- Wrap Main Body -->
 	<?php
 	if (getNumImages() > 0){  /* Only print if we have images. */
 		if ($_noFlash) {
	 ?>
 			<div id="content">
 				<div id="main">
 					<div id="images">
 			<?php

			$firstImage = null;
			$lastImage = null;
			while (next_image(false, $firstPageImages)){
							if (is_null($firstImage)) {
								$lastImage = imageNumber();
								$firstImage = $lastImage;
							} else {
								$lastImage++;
							}
 						echo '<div class="image">' . "\n";
 						echo '<div class="imagethumb">' . "\n";
 						echo '<a href="' . htmlspecialchars(getImageLinkURL()) .'" title="' . GetBareImageTitle() . '">' . "\n";
 						echo printImageThumb(annotateImage()) . "</a>\n";
 						echo "</div>\n";
 						echo "</div>\n";
 					} ?>
 					</div>
 					</div> <!-- main -->
		 			<div class="clearage"></div>
 					<?php
					if (function_exists('printSlideShowLink')) {
						echo "<p align=\"center\">";
						printSlideShowLink(gettext('View Slideshow'));
						echo "</p>";
					}
 					printNofM('Photo', $firstImage, $lastImage, getNumImages());
 					?>
 					</div> <!-- content -->
	 		<?php
	 		} else {  /* flash */
	 			if ($imagePage = isImagePage()) {
	 			?>
 					<div id="flash">
 					<p align=center><font color=#663300><?php echo gettext('For the best viewing experience').' '; ?><a href="http://www.macromedia.com/go/getflashplayer/"><?php echo gettext('get Adobe Flash.'); ?></a></p>
 					<p align="center"><a href="
 					<?php
 					if ($imagePage) {
 						$url = htmlspecialchars(getPageURL(getTotalPages(true)));
 					} else {
 						$url = htmlspecialchars(getPageURL(getCurrentPage()));
 					}
 					if (substr($url, -1, 1) == '/') {$url = substr($url, 0, (strlen($url)-1));}
 					echo $url = $url . (getOption("mod_rewrite") ? "?" : "&amp;") . 'noflash';
 					?>">
 					View gallery without Flash</a>.</p>
 					</div> <!-- flash -->
 					<?php
 					$flash_url = "index.php?p=search" . getSearchParams() . "&amp;format=xml";
 					?>
 					<script type="text/javascript">
									var fo = new SWFObject("<?php echo  $_zp_themeroot ?>/simpleviewer.swf", "viewer", "100%", "100%", "7", "<?php echo $backgroundColor ?>");
									fo.addVariable("preloaderColor", "<?php echo $preloaderColor ?>");
									fo.addVariable("xmlDataPath", "<?php echo $flash_url ?>");
									fo.addVariable("width", "100%");
									fo.addVariable("height", "100%");
									fo.write("flash");
 					</script>
 					<?php
	 			}
	 		} /* image loop */
	 	} else { /* no images to display */
			if (getNumAlbums() == 0){
			?>
				<div id="main3">
				<div id="main2">
				<br />
				<p align="center">
			<?php
				if (empty($searchwords)) {
					echo gettext('Enter your search criteria.');
				} else {
					printf(gettext('Sorry, no matches for <em>%s</em>. Try refining your search.'),$searchwords);
				}
			?>
			</p>
			</div>
			</div> <!-- main3 -->
		<?php
	 		}
	 	} ?>

<!-- Page Numbers -->

		<div id="pagenumbers">
		<?php
		if ((getNumAlbums() != 0) || $_noFlash){
			printPageListWithNav("&laquo; prev", "next &raquo;", !$_noFlash);
		}
		?>
		</div> <!-- pagenumbers -->
</div> <!-- subcontent -->

<!-- Footer -->
<div class="footlinks">

<?php
if (getOption('Use_Simpleviewer') && !getOption('mod_rewrite')) {
	/* display missing css file error */
	echo '<div class="errorbox" id="message">';
	echo  "<h2>" . gettext('Simpleviewer requires <em>mod_rewrite</em> to be set. Simpleviewer is disabled.') . "</h2>";
	echo '</div>';
} ?>

<?php printThemeInfo(); ?>
<?php printZenphotoLink(); ?>
<?php
if (function_exists('printUserLogout')) {
	printUserLogout('<br />', '', true);
}
?>

</div> <!-- footerlinks -->


<?php if (function_exists('printAdminToolbox')) printAdminToolbox(); ?>

</body>
</html>
<?php
} else {
header ('Content-Type: application/xml');

$path = '..';

echo '<?xml version="1.0" encoding="UTF-8"?>
<simpleviewerGallery title=""  maxImageWidth="'.$maxImageWidth.'" maxImageHeight="'.$maxImageHeight.
'" textColor="'.$textColor.'" frameColor="'.$frameColor.'" frameWidth="'.$frameWidth.'" stagePadding="'.
$stagePadding.'" thumbnailColumns="'.$thumbnailColumns.'" thumbnailows="'.$thumbnailRows.'" navPosition="'.
$navPosition.'" enableRightClickOpen="'.$enableRightClickOpen.'" backgroundImagePath="'.$backgroundImagePath.
'" imagePath="'.$path.'" thumbPath="'.$path.'">'; ?>

<?php while (next_image(true)): ?><image><filename><?php echo htmlspecialchars(getFullImageURL());?></filename><caption><![CDATA[<a href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo gettext('Open in a new window'); ?>">
<font face="Times"><u><b><em><?php echo getImageTitle() ?></font></em></b></u></a></u>
<br></font><?php echo getImageDesc() ?>]]></caption></image><?php endwhile; ?></simpleviewerGallery><?php } ?>