<?php
/**
 * Prints a paged thumbs navigation on image.php, independ of the album.php's thumbs
 * 
 * NOTE: With version 1.0.2 $size is no longer an option for this plugin. This plugin now uses the new maxspace function if crop set to false.
 *  
 * The function contains some predefined CSS ids you can use for styling. The function prints the following html:
 *
 * <div id="pagedthumbsnav">
 * <a href="" id="pagedthumbsnav-prev">Previous thumbnail list</a>
 * <img><img> (...) (the active thumb has class="pagedthumbsnav-active")
 * <a href="" id="pagedthumbsnav-next">Next thumbnail list</a>
 * <p id="pagethumbsnav-counter>Images 1 - 10 of 20 (1/3)</p> (optional)
 * </div>
 *
 * @param int $imagesperpage How many thumbs you want to display per list page
 * @param bool $counter If you want to show the counter of for example "Images 1 - 10 of 20 (1/3)"
 * @param string $prev The previous thumb list link text
 * @param string $next The next thumb list link text
 * @param int $width The thumbnail crop width, if empty the general admin setting is used
 * @param int $height The thumbnail crop height, if empty the general admin setting is used
 * @param bool $crop If you want cropped thumbs
 * 
 * @author Malte Müller (acrylian)
 * @version 1.0.2
 * @package plugins 
 */
$plugin_description = gettext("Prints a paged thumbs navigation on image.php, independend of the album.php's thumbsThe function contains some predefined CSS ids you can use for styling. Please see the documentation for more info.");
$plugin_author = "Malte Müller (acrylian)";
$plugin_version = '1.0.2';
$plugin_URL = "";
$option_interface = new pagedthumbsOptions();

/**
 * Plugin option handling class
 *
 */
class pagedthumbsOptions {

	function pagedthumbsOptions() {
		setOptionDefault('pagedthumbs_imagesperpage', '10');
		setOptionDefault('pagedthumbs_counter', '');
		setOptionDefault('pagedthumbs_prevtext', '« prev thumbs');
		setOptionDefault('pagedthumbs_nexttext', 'next thumbs »');
		setOptionDefault('pagedthumbs_width', '50');
		setOptionDefault('pagedthumbs_height', '50');
		setOptionDefault('pagedthumbs_crop', '1');
	}


	function getOptionsSupported() {
		return array(	gettext('Thumbs per page') => array('key' => 'pagedthumbs_imagesperpage', 'type' => 0,
										'desc' => gettext("Controls the number of images on a page. You might need to change	this after switching themes to make it look better.")),
									gettext('Counter') => array('key' => 'pagedthumbs_counter', 'type' => 1,
										'desc' => gettext("If you want to show the counter 'x - y of z images'.")),
									gettext('Prevtext') => array('key' => 'pagedthumbs_prevtext', 'type' => 0,
										'desc' => gettext("The text for the previous thumbs.")),
									gettext('Nexttext') => array('key' => 'pagedthumbs_nexttext', 'type' => 0,
										'desc' => gettext("The text for the next thumbs.")),
									gettext('Crop width') => array('key' => 'pagedthumbs_width', 'type' => 0,
										'desc' => gettext("The thumb crop width is the maximum width when height is the shortest side")),
									gettext('Crop height') => array('key' => 'pagedthumbs_height', 'type' => 0,
										'desc' => gettext("The thumb crop height is the maximum height when width is the shortest side")),
									gettext('Crop') => array('key' => 'pagedthumbs_crop', 'type' => 1,
										'desc' => gettext("If checked the thumbnail will be a centered portion of the	image with the given width and height after being resized to thumb	size (by shortest side). Otherwise, it will be the full image resized to thumb size (by shortest side)."))
		);
	}

}

function printPagedThumbsNav($imagesperpage='', $counter='', $prev='', $next='', $width=NULL, $height=NULL, $crop=false) {
	global $_zp_current_album, $_zp_current_image;
	// in case someone wants to override the options by parameter
	if(empty($imagesperpage)) {
		$imagesperpage = getOption("pagedthumbs_imagesperpage");
	}
	if(empty($width)) {
		$width = getOption("pagedthumbs_width");
	} else {
		$width = sanitize_numeric($width);
	}
	if(empty($height)) {
		$height = getOption("pagedthumbs_height");
	} else {
		$height = sanitize_numeric($height);
	}
	if(empty($prev)) {
		$prev = getOption("pagedthumbs_prevtext");
	}
	if(empty($next)) {
		$next = getOption("pagedthumbs_nexttext");
	}
	if(empty($counter)) {
		$counter = getOption("pagedthumbs_counter");
	}
	
	// get the image of current album
	$images = $_zp_current_album->getImages();
	$totalimages = getNumImages();
	$totalpages = ceil($totalimages / $imagesperpage);
	$currentimgnr = imageNumber();
	for ($nr = 1;$nr <= $totalpages; $nr++)	{
		$startimg[$nr] = $nr*$imagesperpage - ($imagesperpage - 1); // get start image number for thumb pagination
		$endimg[$nr] = $nr * $imagesperpage; // get end image number for thumb pagination
	}
	
	// get current page number
	for ($nr = 1;$nr <= $totalpages; $nr++)	{
		if ($startimg[$nr] <= $currentimgnr) {
			$currentpage = $nr;
		}
		if ($endimg[$nr] >= $currentimgnr) {
			$currentpage = $nr; break;
		}
	}
	echo "<div id=\"pagedthumbsnav\">\n";
	echo "<div class=\"pagedthumbsnav-prev\">\n";
	// Prev thumbnails - show only if there is a prev page
	if ($totalpages > 1)	{
		$prevpageimagenr = ($currentpage * $imagesperpage) - ($imagesperpage+1);
		if ($currentpage > 1) {
			$prevpageimage = newImage($_zp_current_album,$images[$prevpageimagenr]);
			echo "<a href=\"".$prevpageimage->getImageLink()."\" title=\"".gettext("previous thumbs")."\">".$prev."</a>\n";
		} 
	}
		echo "</div>\n";
	// the thumbnails
	$number = $startimg[$currentpage] - 2;
	for ($nr = 1;$nr <= $imagesperpage; $nr++) {
		$number++;
		if($number == $totalimages) {
			break;
		}
		$image = newImage($_zp_current_album,$images[$number]);
		if($image->id === getImageID()) {
			$css = " id='pagedthumbsnav-active' ";
		} else {
			$css = "";
		}
		echo "<a $css href=\"".$image->getImageLink()."\" title=\"".strip_tags($image->getTitle())."\">";
		if(getOption("pagedthumbs_crop") OR $crop) {
			echo "<img src='".$image->getCustomImage(null, $width, $height, $width, $height, null, null, true)."' alt=\"".strip_tags($image->getTitle())."\" width='".$width."' height='".$height."' />";
		} else {
			$_zp_current_image = $image;
			printCustomSizedImageThumbMaxSpace(strip_tags($image->getTitle()),$width,$height);
		}
		echo "</a>\n";
		if ($number == $endimg[$currentpage]) {
			break;
		}
	}

	
	// next thumbnails - show only if there is a next page
	echo "<div class=\"pagedthumbsnav-next\">\n";
	if ($totalpages > 1)	{
		if ($currentpage < $totalpages) 	{
			$nextpageimagenr = $currentpage * $imagesperpage;
			$nextpageimage = newImage($_zp_current_album,$images[$nextpageimagenr]);
			echo "<a href=\"".$nextpageimage->getImageLink()."\" title=\"".gettext("next thumbs")."\">".$next."</a>\n";
		} 
	} //first if
	echo "</div>\n";
	
		// image counter
	if($counter) {
		$fromimage = ($startimg[$currentpage]);
		if($totalimages < $endimg[$currentpage]) {
			$toimage = $totalimages;
		} else {
			$toimage = $endimg[$currentpage];
		}
		echo "<p id=\"pagedthumbsnav-counter\">".sprintf(gettext('Images %1$u-%2$u of %3$u (%4$u/%5$u)'),$fromimage,$toimage,$totalimages,$currentpage,$totalpages)."</p>\n";
	}
	echo "</div>\n";
}
?>