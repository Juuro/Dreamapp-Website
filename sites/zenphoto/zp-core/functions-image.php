<?php
/**
 * image processing functions
 * @package core
 *
 */

// force UTF-8 Ø

// functions-image.php - HEADERS NOT SENT YET!

// Don't let anything get above this, to save the server from burning up...
define('MAX_SIZE', 3000);

/**
 * If in debug mode, prints the given error message and continues; otherwise redirects
 * to the given error message image and exits; designed for a production gallery.
 * @param $errormessage string the error message to print if $_GET['debug'] is set.
 * @param $errorimg string the filename of the error image to display for production. Defaults
 *   to 'err-imagegeneral.gif'. Images should be located in /zen/images .
 */
function imageError($errormessage, $errorimg='err-imagegeneral.gif') {
	global $newfilename, $album, $image;
	$debug = isset($_GET['debug']);
	if ($debug) {
		echo('<strong>'.sprintf(gettext('Zenphoto Image Processing Error: %s'), $errormessage).'</strong>'
		. '<br /><br />'.sprintf(gettext('Request URI: [ <code>%s</code> ]'), sanitize($_SERVER['REQUEST_URI'], 3))
		. '<br />PHP_SELF: [ <code>' . sanitize($_SERVER['PHP_SELF'], 3) . '</code> ]'
		. (empty($newfilename) ? '' : '<br />'.sprintf(gettext('Cache: [<code>%s</code>]'), substr(CACHEFOLDER, 0, -1) . sanitize($newfilename, 3)).' ')
		. (empty($image) || empty($album) ? '' : ' <br />'.sprintf(gettext('Image: [<code>%s</code>]'),sanitize($album.'/'.$image, 3)).' <br />'));
	} else {
		header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/images/' . $errorimg);
		exit();
	}
}

/**
 * Prints debug information from the arguments to i.php.
 *
 * @param string $album alubm name
 * @param string $image image name
 * @param array $args size/crop arguments
 */
function imageDebug($album, $image, $args) {
	list($size, $width, $height, $cw, $ch, $cx, $cy, $quality, $thumb, $crop) = $args;
	echo "Album: [ " . $album . " ], Image: [ " . $image . " ]<br/><br/>";
	echo "<strong>".gettext("Debug")." <code>i.php</code> | ".gettext("Arguments:")."</strong><br />\n\n"
	.  "<ul><li>".gettext("size =")."    <strong>" . sanitize($size, 3)     . "</strong></li>\n"
	.  "<li>".gettext("width =")."   <strong>" . sanitize($width, 3)    . "</strong></li>\n"
	.  "<li>".gettext("height =")."  <strong>" . sanitize($height, 3)   . "</strong></li>\n"
	.  "<li>".gettext("cw =")."      <strong>" . sanitize($cw, 3)       . "</strong></li>\n"
	.  "<li>".gettext("ch =")."      <strong>" . sanitize($ch, 3)       . "</strong></li>\n"
	.  "<li>".gettext("cx =")."      <strong>" . sanitize($cx, 3)       . "</strong></li>\n"
	.  "<li>".gettext("cy =")."      <strong>" . sanitize($cy, 3)       . "</strong></li>\n"
	.  "<li>".gettext("quality =")." <strong>" . sanitize($quality, 3)  . "</strong></li>\n"
	.  "<li>".gettext("thumb =")."   <strong>" . sanitize($thumb, 3)    . "</strong></li>\n"
	.  "<li>".gettext("crop =")."    <strong>" . sanitize($crop, 3)     . "</strong></li></ul>\n";
}

/**
 * Takes an image filename and returns a GD Image using the correct function
 * for the image's format (imagecreatefrom*). Supports JPEG, GIF, and PNG.
 * @param string $imagefile the full path and filename of the image to load.
 * @return image the loaded GD image object.
 *
 */
function get_image($imgfile) {
	$ext = strtolower(substr(strrchr($imgfile, "."), 1));
	if ($ext == "jpg" || $ext == "jpeg") {
		return imagecreatefromjpeg($imgfile);
	} else if ($ext == "gif") {
		return imagecreatefromgif($imgfile);
	} else if ($ext == "png") {
		return imagecreatefrompng($imgfile);
	} else {
		return false;
	}
}

/**
 * Sharpens an image using an Unsharp Mask filter.
 *
 * Original description from the author:
 *
 * WARNING ! Due to a known bug in PHP 4.3.2 this script is not working well in this
 * version. The sharpened images get too dark. The bug is fixed in version 4.3.3.
 *
 * From version 2 (July 17 2006) the script uses the imageconvolution function in
 * PHP version >= 5.1, which improves the performance considerably.
 *
 * Unsharp masking is a traditional darkroom technique that has proven very
 * suitable for digital imaging. The principle of unsharp masking is to create a
 * blurred copy of the image and compare it to the underlying original. The
 * difference in colour values between the two images is greatest for the pixels
 * near sharp edges. When this difference is subtracted from the original image,
 * the edges will be accentuated.
 *
 * The Amount parameter simply says how much of the effect you want. 100 is
 * 'normal'. Radius is the radius of the blurring circle of the mask. 'Threshold'
 * is the least difference in colour values that is allowed between the original
 * and the mask. In practice this means that low-contrast areas of the picture are
 * left unrendered whereas edges are treated normally. This is good for pictures of
 * e.g. skin or blue skies.
 *
 * Any suggenstions for improvement of the algorithm, expecially regarding the
 * speed and the roundoff errors in the Gaussian blur process, are welcome.
 *
 * Permission to license this code under the GPL was granted by the author on 2/12/2007.
 *
 * @param image $img the GD format image to sharpen. This is not a URL string, but
 *   should be the result of a GD image function.
 * @param int $amount the strength of the sharpening effect. Nominal values are between 0 and 100.
 * @param int $radius the pixel radius of the sharpening mask. A smaller radius sharpens smaller
 *   details, and a larger radius sharpens larger details.
 * @param int $threshold the color difference threshold required for sharpening. A low threshold
 *   sharpens all edges including faint ones, while a higher threshold only sharpens more distinct edges.
 * @return image the input image with the specified sharpening applied.
 */
function unsharp_mask($img, $amount, $radius, $threshold) {
	/*
	 Unsharp Mask for PHP - version 2.0
	 Unsharp mask algorithm by Torstein Hønsi 2003-06.
	 Please leave this notice.
	 */

	// $img is an image that is already created within php using
	// imgcreatetruecolor. No url! $img must be a truecolor image.

	// Attempt to calibrate the parameters to Photoshop:
	if ($amount > 500)    $amount = 500;
	$amount = $amount * 0.016;
	if ($radius > 50)    $radius = 50;
	$radius = $radius * 2;
	if ($threshold > 255)    $threshold = 255;

	$radius = abs(round($radius));     // Only integers make sense.
	if ($radius == 0) return $img;
	$w = imagesx($img); $h = imagesy($img);
	$imgCanvas = imagecreatetruecolor($w, $h);
	$imgCanvas2 = imagecreatetruecolor($w, $h);
	$imgBlur = imagecreatetruecolor($w, $h);
	$imgBlur2 = imagecreatetruecolor($w, $h);
	imagecopy ($imgCanvas, $img, 0, 0, 0, 0, $w, $h);
	imagecopy ($imgCanvas2, $img, 0, 0, 0, 0, $w, $h);


	// Gaussian blur matrix:
	//    1    2    1
	//    2    4    2
	//    1    2    1
	//////////////////////////////////////////////////

	imagecopy($imgBlur, $imgCanvas, 0, 0, 0, 0, $w, $h); // background

	for ($i = 0; $i < $radius; $i++)    {
		if (function_exists('imageconvolution')) { // PHP >= 5.1
			$matrix = array(
			array( 1, 2, 1 ),
			array( 2, 4, 2 ),
			array( 1, 2, 1 )
			);
			imageconvolution($imgCanvas, $matrix, 16, 0);
		} else {

			// Move copies of the image around one pixel at the time and merge them with weight
			// according to the matrix. The same matrix is simply repeated for higher radii.

			imagecopy      ($imgBlur, $imgCanvas, 0, 0, 1, 1, $w - 1, $h - 1); // up left
			imagecopymerge ($imgBlur, $imgCanvas, 1, 1, 0, 0, $w, $h, 50); // down right
			imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 1, 0, $w - 1, $h, 33.33333); // down left
			imagecopymerge ($imgBlur, $imgCanvas, 1, 0, 0, 1, $w, $h - 1, 25); // up right
			imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 1, 0, $w - 1, $h, 33.33333); // left
			imagecopymerge ($imgBlur, $imgCanvas, 1, 0, 0, 0, $w, $h, 25); // right
			imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 20 ); // up
			imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 16.666667); // down
			imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 0, $w, $h, 50); // center
			imagecopy      ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h);

			// During the loop above the blurred copy darkens, possibly due to a roundoff
			// error. Therefore the sharp picture has to go through the same loop to
			// produce a similar image for comparison. This is not a good thing, as processing
			// time increases heavily.
			imagecopy      ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 50);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 33.33333);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 25);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 33.33333);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 25);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 20 );
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 16.666667);
			imagecopymerge ($imgBlur2, $imgCanvas2, 0, 0, 0, 0, $w, $h, 50);
			imagecopy      ($imgCanvas2, $imgBlur2, 0, 0, 0, 0, $w, $h);
		}
	}

	// Calculate the difference between the blurred pixels and the original
	// and set the pixels
	for ($x = 0; $x < $w; $x++)    { // each row
		for ($y = 0; $y < $h; $y++)    { // each pixel

			$rgbOrig = ImageColorAt($imgCanvas2, $x, $y);
			$rOrig = (($rgbOrig >> 16) & 0xFF);
			$gOrig = (($rgbOrig >> 8) & 0xFF);
			$bOrig = ($rgbOrig & 0xFF);

			$rgbBlur = ImageColorAt($imgCanvas, $x, $y);

			$rBlur = (($rgbBlur >> 16) & 0xFF);
			$gBlur = (($rgbBlur >> 8) & 0xFF);
			$bBlur = ($rgbBlur & 0xFF);

			// When the masked pixels differ less from the original
			// than the threshold specifies, they are set to their original value.
			$rNew = (abs($rOrig - $rBlur) >= $threshold)
			? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
			: $rOrig;
			$gNew = (abs($gOrig - $gBlur) >= $threshold)
			? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
			: $gOrig;
			$bNew = (abs($bOrig - $bBlur) >= $threshold)
			? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
			: $bOrig;

			if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
				$pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
				ImageSetPixel($img, $x, $y, $pixCol);
			}
		}
	}
	return $img;
}

/**
/**
 * Resize a PNG file with transparency to given dimensions
 * and still retain the alpha channel information
 * Author:  Alex Le - http://www.alexle.net
 *
 *
 * @param image $src
 * @param int $w
 * @param int $h
 * @return image
 */
function imageResizeAlpha(&$src, $w, $h) {
	/* create a new image with the new width and height */
	$temp = imagecreatetruecolor($w, $h);

	/* making the new image transparent */
	$background = imagecolorallocate($temp, 0, 0, 0);
	imagecolortransparent($temp, $background); // make the new temp image all transparent
	imagealphablending($temp, false); // turn off the alpha blending to keep the alpha channel

	/* Resize the PNG file */
	/* use imagecopyresized to gain some performance but loose some quality */
	imagecopyresampled($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
	/* use imagecopyresampled if you concern more about the quality */
	//imagecopyresampled($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
	return $temp;
}

/**
 * Calculates proprotional width and height
 * Used internally by cacheImage
 * 
 * Returns array containing the new width and height
 *
 * @param int $size
 * @param int $width
 * @param int $height
 * @param int $w
 * @param int $h
 * @param int $thumb
 * @param int $image_use_side
 * @param int $dim
 * @return array
 */
function propSizes($size, $width, $height, $w, $h, $thumb, $image_use_side, $dim) {	
	$hprop = round(($h / $w) * $dim);
	$wprop = round(($w / $h) * $dim);
	if ($size) {
		if ((($thumb || ($image_use_side == 'longest')) && $h > $w) || ($image_use_side == 'height') || ($image_use_side == 'shortest' && $h < $w)) {
			$newh = $dim;  // height is the size and width is proportional
			$neww = $wprop;
		} else {
			$neww = $dim;  // width is the size and height is proportional
			$newh = $hprop; 
		}
	} else { // length and/or width is set, size is NULL (Thumbs work the same as image in this case)
		if ($height) { 
			$newh = $height;  // height is supplied, use it
		} else {
			$newh = $hprop;		// height not supplied, use the proprotional
		}
		if ($width) {
			$neww = $width;   // width is supplied, use it
		} else {
			$neww = $wprop;   // width is not supplied, use the proportional
		}
	}
	if (DEBUG_IMAGE) debugLog("propSizes($size, $width, $height, $w, $h, $thumb, $image_use_side, $wprop, $hprop)::\$neww=$neww; \$newh=$newh");	
	return array($neww, $newh);
}

/**
 * Creates the cache folder version of the image, including watermarking
 *
 * @param string $newfilename the name of the file when it is in the cache
 * @param string $imgfile the image name
 * @param array $args the cropping arguments
 * @param bool $allow_watermark set to true if image may be watermarked
 * @param bool $force_cache set to true to force the image into the cache folders
 * @param string $theme the current theme
 */
function cacheImage($newfilename, $imgfile, $args, $allow_watermark=false, $force_cache=false, $theme) {
	@list($size, $width, $height, $cw, $ch, $cx, $cy, $quality, $thumb, $crop, $thumbstandin, $thumbWM, $adminrequest) = $args;
	// Set the config variables for convenience.
	$image_use_side = getOption('image_use_side');
	$upscale = getOption('image_allow_upscale');
	$allowscale = true;
	$sharpenthumbs = getOption('thumb_sharpen');
	$sharpenimages = getOption('image_sharpen');
	$newfile = SERVERCACHE . $newfilename;
	if (DEBUG_IMAGE) debugLog("cacheImage(\$imgfile=".basename($imgfile).", \$newfilename=$newfilename, \$allow_watermark=$allow_watermark, \$force_cache=$force_cache, \$theme=$theme) \$size=$size, \$width=$width, \$height=$height, \$cw=$cw, \$ch=$ch, \$cx=$cx, \$cy=$cy, \$quality=$quality, \$thumb=$thumb, \$crop=$crop \$image_use_side=$image_use_side; \$upscale=$upscale;");
	// Check for GD
	if (!function_exists('imagecreatetruecolor'))
		imageError(gettext('The GD Library is not installed or not available.'), 'err-nogd.gif');
	// Check for the source image.
	if (!file_exists($imgfile) || !is_readable($imgfile)) {
		imageError(gettext('Image not found or is unreadable.'), 'err-imagenotfound.gif');
	}
	$rotate = false;
	if (function_exists('imagerotate') && getOption('auto_rotate'))  {
		$rotate = getImageRotation($imgfile);
	}

	if ($im = get_image($imgfile)) {
		if ($rotate) {
			$newim_rot = imagerotate($im, $rotate, 0);
			imagedestroy($im);
			$im = $newim_rot;
		}
		$w = imagesx($im);
		$h = imagesy($im);
		// Give the sizing dimension to $dim
		$ratio_in = '';
		$ratio_out = '';
		$crop = ($crop || $cw != 0 || $ch != 0);
		if (!empty($size)) {
			$dim = $size;
			$width = $height = false;
			if ($crop) {		
				$dim = $size;
				if (!$ch) $ch = $size;
				if (!$cw) $cw = $size;
			}
		} else if (!empty($width) && !empty($height)) {
			$ratio_in = $h / $w;
			$ratio_out = $height / $width;
			if ($ratio_in > $ratio_out) { // image is taller than desired, $height is the determining factor
				$thumb = true;
				$dim = $width;
				if (!$ch) $ch = $height;
			} else { // image is wider than desired, $width is the determining factor
				$dim = $height;
				if (!$cw) $cw = $width;
			}
		} else if (!empty($width)) {
			$dim = $width;
			$size = $height = false;
		} else if (!empty($height)) {
			$dim = $height;
			$size = $width = false;
		} else {
			// There's a problem up there somewhere...
			imageError(gettext("Unknown error! Please report to the developers at <a href=\"http://www.zenphoto.org/\">www.zenphoto.org</a>"), 'err-imagegeneral.gif');
		}
	
		$sizes = propSizes($size, $width, $height, $w, $h, $thumb, $image_use_side, $dim);
		list($neww, $newh) = $sizes;
		
		if (DEBUG_IMAGE) debugLog("cacheImage:".basename($imgfile).": \$size=$size, \$width=$width, \$height=$height, \$w=$w; \$h=$h; \$cw=$cw, \$ch=$ch, \$cx=$cx, \$cy=$cy, \$quality=$quality, \$thumb=$thumb, \$crop=$crop, \$newh=$newh, \$neww=$neww, \$dim=$dim, \$ratio_in=$ratio_in, \$ratio_out=$ratio_out \$upscale=$upscale \$rotate=$rotate \$force_cache=$force_cache");
		
		if (!$upscale && $newh >= $h && $neww >= $w) { // image is the same size or smaller than the request
			if (!getOption('watermark_image') && !($crop || $thumb || $rotate || $force_cache)) { // no processing needed
				if (DEBUG_IMAGE) debugLog("Serve ".basename($imgfile)." from original image.");
				if (getOption('album_folder_class') != 'external') { // local album system, return the image directly
					$image = substr(strrchr($imgfile, '/'), 1);
					$album = substr($imgfile, strlen(getAlbumFolder()));
					$album = substr($album, 0, strlen($album) - strlen($image) - 1);
					header("Location: " . getAlbumFolder(FULLWEBPATH) . pathurlencode($album) . "/" . rawurlencode($image));
					exit();
				} else {  // the web server does not have access to the image, have to supply it
					$suffix = strtolower(substr(strrchr($filename, "."), 1));
					$fp = fopen($imgfile, 'rb');
					// send the right headers
					header("Content-Type: image/$suffix");
					header("Content-Length: " . filesize($imgfile));
					// dump the picture and stop the script
					fpassthru($fp);
					fclose($fp);
					exit();
				}
			}
			$neww = $w;
			$newh = $h;
			$allowscale = false;
			if ($crop) {
				if ($width > $neww) {
					$width = $neww;
				}
				if ($height > $newh) {
					$height = $newh;
				}
			}
			if (DEBUG_IMAGE) debugLog("cacheImage:no upscale ".basename($imgfile).":  \$newh=$newh, \$neww=$neww");
		}
		// Crop the image if requested.
		if ($crop) {
				if ($cw > $ch) {
					$ir = $ch/$cw;
				} else {
					$ir = $cw/$ch;
				}
				if ($size) {
					$ts = $size;
					$neww = $size;
					$newh = $ir*$size;
				} else {
					$neww = $width;
					$newh = $height;
					if ($neww > $newh) {
						$ts = $neww;
						if ($newh === false) {
							$newh = $ir*$neww;
						}
					} else {
						$ts = $newh;
						if ($neww === false) {
							$neww = $ir*$newh;
						}
					}
				}
			
			$cr = min($w, $h)/$ts;
			if (!$cx) {
				if (!$cw) {
					$cw = $w;
				} else {
					$cw = round($cw*$cr);
				}
				$cx = round(($w - $cw) / 2);
			} else { // custom crop
				if (!$cw || $cw > $w) $cw = $w;
			}
			if (!$cy) {
				if (!$ch) {
					$ch = $h;
				} else {
					$ch = round($ch*$cr);
				}
				$cy = round(($h - $ch) / 2);
			} else { // custom crop
				if (!$ch || $ch > $h) $ch = $h;
			}
			if ($cw + $cx > $w) $cx = $w - $cw;
			if ($cx < 0) {
				$cw = $cw + $cx;
				$cx = 0;
			}
			if ($ch + $cy > $h) $cy = $h - $ch;
			if ($cy < 0) {
				$ch = $ch + $cy;
				$cy = 0;
			}
			if (DEBUG_IMAGE) debugLog("cacheImage:crop ".basename($imgfile).":\$size=$size, \$width=$width, \$height=$height, \$cw=$cw, \$ch=$ch, \$cx=$cx, \$cy=$cy, \$quality=$quality, \$thumb=$thumb, \$crop=$crop, \$rotate=$rotate");
			$newim = imagecreatetruecolor($neww, $newh);
			imagecopyresampled($newim, $im, 0, 0, $cx, $cy, $neww, $newh, $cw, $ch);
		} else {
			if ($allowscale) {
				$sizes = propSizes($size, $width, $height, $w, $h, $thumb, $image_use_side, $dim);
				list($neww, $newh) = $sizes;
				
			}
			if (DEBUG_IMAGE) debugLog("cacheImage:no crop ".basename($imgfile).":\$size=$size, \$width=$width, \$height=$height, \$dim=$dim, \$neww=$neww; \$newh=$newh; \$quality=$quality, \$thumb=$thumb, \$crop=$crop, \$rotate=$rotate; \$allowscale=$allowscale;");
			$newim = imagecreatetruecolor($neww, $newh);
			imagecopyresampled($newim, $im, 0, 0, 0, 0, $neww, $newh, $w, $h);
		}		
		
		
		if (($thumb && $sharpenthumbs) || (!$thumb && $sharpenimages)) {
			unsharp_mask($newim, getOption('sharpen_amount'), getOption('sharpen_radius'), getOption('sharpen_threshold'));
		}
		$watermark_image = false;
		if ($thumbWM) {
			if ($thumb || !$allow_watermark) {
				$watermark_image = SERVERPATH . '/' . ZENFOLDER . '/watermarks/' . UTF8ToFileSystem($thumbWM).'.png';
				if (!file_exists($watermark_image)) $watermark_image = SERVERPATH . '/' . ZENFOLDER . '/images/imageDefault.png';
			}
		} else {
			if ($allow_watermark) {
				$watermark_image = getOption('fullimage_watermark');
				if ($watermark_image) {
					$watermark_image = SERVERPATH . '/' . ZENFOLDER . '/watermarks/' . UTF8ToFileSystem($watermark_image).'.png';
					if (!file_exists($watermark_image)) $watermark_image = SERVERPATH . '/' . ZENFOLDER . '/images/imageDefault.png';
				}
			}
		}
		if ($watermark_image) {
			$offset_h = getOption('watermark_h_offset') / 100;
			$offset_w = getOption('watermark_w_offset') / 100;
			$watermark = imagecreatefrompng($watermark_image);
			$watermark_width = imagesx($watermark);
			$watermark_height = imagesy($watermark);
			$imw = imagesx($newim);
			$imh = imagesy($newim);
			$percent = getOption('watermark_scale')/100;
			$r = sqrt(($imw * $imh * $percent) / ($watermark_width * $watermark_height));
			if (!getOption('watermark_allow_upscale')) {
				$r = min(1, $r);
			}
			$nw = round($watermark_width * $r);
			$nh = round($watermark_height * $r);
			if (($nw != $watermark_width) || ($nh != $watermark_height)) {
				$watermark = imageResizeAlpha($watermark, $nw, $nh);
			}
			// Position Overlay in Bottom Right
			$dest_x = max(0, floor(($imw - $nw) * $offset_w));
			$dest_y = max(0, floor(($imh - $nh) * $offset_h));
			if (DEBUG_IMAGE) debugLog("Watermark:".basename($imgfile).": \$offset_h=$offset_h, \$offset_w=$offset_w, \$watermark_height=$watermark_height, \$watermark_width=$watermark_width, \$imw=$imw, \$imh=$imh, \$percent=$percent, \$r=$r, \$nw=$nw, \$nh=$nh, \$dest_x=$dest_x, \$dest_y=$dest_y");
			imagecopy($newim, $watermark, $dest_x, $dest_y, 0, 0, $nw, $nh);
			imagedestroy($watermark);
		}

		// Create the cached file (with lots of compatibility)...
		mkdir_recursive(dirname($newfile));
		if (imagejpeg($newim, $newfile, $quality)) {
			if (DEBUG_IMAGE) debugLog('Finished:'.basename($imgfile));
		} else {
			if (DEBUG_IMAGE) debugLog('cacheImage: failed to create '.$newfile);
		}
		@chmod($newfile, 0666 & CHMOD_VALUE);
		imagedestroy($newim);
		imagedestroy($im);
	}
}

 /* Determines the rotation of the image looking EXIF information.  
  *   
  * @param string $imgfile the image name  
  * @return false when the image should not be rotated, or the degrees the  
  *         image should be rotated otherwise.  
  *  
  * FIXME: PHP GD do not support flips so when a flip is needed we make a  
  * rotation that get close to that flip. But I don't think any camera will  
  * fill a flipped value in the tag.  
  */  
function getImageRotation($imgfile) {
	$imgfile = substr($imgfile, strlen(getAlbumFolder()));
  $result = query_single_row('SELECT EXIFOrientation FROM '.prefix('images').' AS i JOIN '.prefix('albums').' as a ON i.albumid = a.id WHERE "'.$imgfile.'" = CONCAT(a.folder,"/",i.filename)');
	if (is_array($result) && array_key_exists('EXIFOrientation', $result)) {
		$splits = preg_split('/!([(0-9)])/', $result['EXIFOrientation']);
		$rotation = $splits[0];
		switch ($rotation) {
			case 1 : return false; break;
			case 2 : return false; break; // mirrored
			case 3 : return 180;   break; // upsidedown (not 180 but close)
			case 4 : return 180;   break; // upsidedown mirrored
			case 5 : return 270;   break; // 90 CW mirrored (not 270 but close)
			case 6 : return 270;   break; // 90 CCW
			case 7 : return 90;    break; // 90 CCW mirrored (not 90 but close)
			case 8 : return 90;    break; // 90 CW
			default: return false;
		}
	}
	return false;
}

?>
