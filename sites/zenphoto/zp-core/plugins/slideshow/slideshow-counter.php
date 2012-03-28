<?php
/**
 * Hitcounter handler for slidshow
 * 
 * @package plugins 
 */

require_once("../../class-load.php");

$album_name = $_GET["album"];
$img_name = $_GET["img"];

if ($album_name && $img_name ) {
	$gallery = new Gallery();
	$album = new Album($gallery, $album_name);
	$image = newImage($album, $img_name);	
	//update hit counter
	if (!isMyALbum($album->name, ALL_RIGHTS)) {
		$hc = $image->get('hitcounter')+1;
		$image->set('hitcounter', $hc);
		$image->save();
	}
}
?>
