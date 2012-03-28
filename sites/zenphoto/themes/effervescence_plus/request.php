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
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Register"); ?></title>
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
		  echo "<em>".gettext('Register')."</em>";
		?>
	</div>
</div> <!-- wrapnav -->

</div> <!-- header -->

<!-- Wrap Subalbums -->
<div id="subcontent">
<div id="submain">

<?php  printRegistrationForm();  ?>
</div>


<!-- Footer -->
<div class="footlinks">

<?php printThemeInfo(); ?>
<?php printZenphotoLink(); ?>

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