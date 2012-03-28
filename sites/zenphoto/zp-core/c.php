<?php
/**
 * creates the captcha images
 * @package core
 */

// force UTF-8 Ø

require_once(dirname(__FILE__).'/functions.php');
require_once(dirname(__FILE__).'/lib-encryption.php');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
header ("Content-type: image/png");
$cypher = preg_replace('/[^0-9a-f]/', '', $_GET['i']);

$key = getOption('zenphoto_captcha_key');
$string = rc4($key, pack("H*", $cypher));

$image = imagecreate(65, 20);
$background = imagecreatefrompng(SERVERPATH.'/'.ZENFOLDER.'/images/captcha_background.png');
imagecopy($image, $background, 0, 0, rand(0,10), rand(0,10), 65, 20);

$lettre = imagecolorallocate($image,5,5,5);
$len = strlen($string);
$sz = floor(55/$len);
$start = rand(2,55-$sz*$len);
for ($i=0; $i<$len; $i++) {
	$l = $start+$i*($sz)+rand(2,4);
	imagestring($image,5,$l,rand(0,3),substr($string, $i, 1),$lettre);
}

$rectangle = imagecolorallocate($image,48,57,85);
ImageRectangle ($image,0,0,64,19,$rectangle);

imagepng($image, NULL, 0);

?>

