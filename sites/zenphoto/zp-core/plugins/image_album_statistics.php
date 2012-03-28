<?php
/**
 * image_album_statistics -- support functions for "statistics" about images and albums.
 *
 * Supports such statistics as "most popular", "latest", "top rated", etc.
 *
 * C A U T I O N: With 1.0.4.7 the usage to get an specific album changes. You now have to pass the foldername of an album instead the album title.
 *
 * @author Malte Müller (acrylian), Stephen Billard (sbillard)
 * @version 1.0.7
 * @package plugins
 */

$plugin_description = gettext("Functions that provide various statistics about images and albums in the gallery.");
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard)";
$plugin_version = '1.0.7';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---image_album_statistics.php.html";

/**
 * Retuns a list of album statistic accordingly to $option
 *
 * @param int $number the number of albums to get
 * @param string $option "popular" for the most popular albums,
 *     "latest" for the latest uploaded, "mostrated" for the most voted,
 *     "toprated" for the best voted
 * 		 "latestupdated" for the latest updated
 * @return string
 */
function getAlbumStatistic($number=5, $option) {
	$passwordcheck = '';
	if (zp_loggedin()) {
		$albumWhere = "";
	} else {
		$albumscheck = query_full_array("SELECT * FROM " . prefix('albums'). " ORDER BY title");
		foreach($albumscheck as $albumcheck) {
			if(!checkAlbumPassword($albumcheck['folder'], $hint)) {
				$albumpasswordcheck= " AND id != ".$albumcheck['id'];
				$passwordcheck = $passwordcheck.$albumpasswordcheck;
			}
		}
		$albumWhere = "WHERE `show`=1".$passwordcheck;
	}
	switch($option) {
		case "popular":
			$sortorder = "hitcounter";
			break;
		case "latest":
			$sortorder = "id";
			break;
		case "mostrated":
			$sortorder = "total_votes"; break;
		case "toprated":
			$sortorder = "(total_value/total_votes)"; break;
		case "latestupdated":
			// get all albums
			$allalbums = query_full_array("SELECT id, title, folder, thumb FROM " . prefix('albums'). $albumWhere);
			$latestimages = array();

			// get latest images of each album
			foreach($allalbums as $album) {
				$image = query_single_row("SELECT id, albumid FROM " . prefix('images'). " WHERE albumid = ".$album['id'] . " AND `show` = 1 ORDER BY id DESC");
				array_push($latestimages, $image);
			}
			// sort latest image by mtime
			arsort($latestimages);
			//print_r($latestimages);
			$updatedalbums = array();
			$count = 0;
			foreach($latestimages as $latestimage) {
				$count++;
				foreach($allalbums as $album) {
					if($album['id'] === $latestimage['albumid']) {
						array_push($updatedalbums,$album);
					}
				}
				if($count == $number) {
					break;
				}
			}
			break;
	}
	if($option === "latestupdated") {
		return $updatedalbums;
	} else {
		$albums = query_full_array("SELECT id, title, folder, thumb FROM " . prefix('albums') . $albumWhere . " ORDER BY ".$sortorder." DESC LIMIT $number");
		return $albums;
	}
}

/**
 * Prints album statistic according to $option as an unordered HTML list
 * A css id is attached by default named '$option_album'
 *
 * @param string $number the number of albums to get
 * @param string $option "popular" for the most popular albums,
 *                  "latest" for the latest uploaded,
 *                  "mostrated" for the most voted,
 *                  "toprated" for the best voted
 * 									"latestupdated" for the latest updated
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printAlbumStatistic($number, $option, $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true) {
	$albums = getAlbumStatistic($number, $option);
	echo "\n<div id=\"".$option."_album\">\n";
	echo "<ul>";
	foreach($albums as $album) {
		printAlbumStatisticItem($album, $option,$showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop);
	}
	echo "</ul></div>\n";
}

/**
 * A helper function that only prints a item of the loop within printAlbumStatistic()
 * Not for standalone use.
 *
 * @param array $album the array that getAlbumsStatistic() submitted
 * @param string $option "popular" for the most popular albums,
 *                  "latest" for the latest uploaded,
 *                  "mostrated" for the most voted,
 *                  "toprated" for the best voted
 * 									"latestupdated" for the latest updated
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printAlbumStatisticItem($album, $option, $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true) {
	global $_zp_gallery;
	$albumpath = rewrite_path("/", "index.php?album=");
	$tempalbum = new Album($_zp_gallery, $album['folder']);
		echo "<li><a href=\"".$albumpath.pathurlencode($tempalbum->name)."\" title=\"" . html_encode($tempalbum->getTitle()) . "\">\n";
		$albumthumb = $tempalbum->getAlbumThumbImage();
		$thumb = newImage($tempalbum, $albumthumb->filename);
		if($crop) {
			echo "<img src=\"".$thumb->getCustomImage(NULL, $width, $height, $width, $height, NULL, NULL, TRUE)."\" alt=\"" . html_encode($thumb->getTitle()) . "\" /></a>\n<br />";
		} else {
			echo "<img src=\"".$thumb->getCustomImage($width, NULL, NULL, NULL, NULL, NULL, NULL, TRUE)."\" alt=\"" . html_encode($thumb->getTitle()) . "\" /></a>\n<br />";
		}
		if($showtitle) {
			echo "<h3><a href=\"".$albumpath.pathurlencode($tempalbum->name)."\" title=\"" . html_encode($tempalbum->getTitle()) . "\">\n";
			echo $tempalbum->getTitle()."</a></h3>\n";
		}
		if($showdate) {
			if($option === "latestupdated") {
				$filechangedate = filectime(getAlbumFolder().UTF8ToFilesystem($tempalbum->name));
				$latestimage = query_single_row("SELECT mtime FROM " . prefix('images'). " WHERE albumid = ".$tempalbum->getAlbumID() . " AND `show` = 1 ORDER BY id DESC");
				$lastuploaded = query("SELECT COUNT(*) FROM ".prefix('images')." WHERE albumid = ".$tempalbum->getAlbumID() . " AND mtime = ". $latestimage['mtime']);
				$row = mysql_fetch_row($lastuploaded);
				$count = $row[0];
				echo "<p>".sprintf(gettext("Last update: %s"),zpFormattedDate(getOption('date_format'),$filechangedate))."</p>";
				if($count <= 1) {
					$image = gettext("image");
				} else {
					$image = gettext("images");
				}
				echo "<span>".sprintf(gettext('%1$u new %2$s'),$count,$image)."</span>";
			} else {
				echo "<p>". zpFormattedDate(getOption('date_format'),strtotime($tempalbum->getDateTime()))."</p>";
			}
		}
		if($showstatistic === "rating" OR $showstatistic === "rating+hitcounter") {
			$votes = $tempalbum->get("total_votes");
			$value = $tempalbum->get("total_value");
			if($votes != 0) {
				$rating =  round($value/$votes, 1);
			}
			echo "<p>".sprintf(gettext('Rating: %1$u (Votes: %2$u )'),$rating,$tempalbum->get("total_votes"))."</p>";
		}
		if($showstatistic === "hitcounter" OR $showstatistic === "rating+hitcounter") {
			$hitcounter = $tempalbum->get("hitcounter");
			if(empty($hitcounter)) { $hitcounter = "0"; }
			echo "<p>".sprintf(gettext("Views: %u"),$hitcounter)."</p>";
		}
		if($showdesc) {
			echo "<p>".truncate_string($tempalbum->getDesc(), $desclength)."</p>";
		}
		echo "</li>";
}

/**
 * Prints the most popular albums
 *
 * @param string $number the number of albums to get
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printPopularAlbums($number=5,$showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='hitcounter',$width=85,$height=85,$crop=true) {
	printAlbumStatistic($number,"popular",$showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop);
}

/**
 * Prints the latest albums
 *
 * @param string $number the number of albums to get
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printLatestAlbums($number=5,$showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true) {
	printAlbumStatistic($number,"latest",$showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop);
}

/**
 * Prints the most rated albums
 *
 * @param string $number the number of albums to get
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printMostRatedAlbums($number=5,$showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true) {
	printAlbumStatistic($number,"mostrated",$showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop);
}

/**
 * Prints the top voted albums
 *
 * @param string $number the number of albums to get
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printTopRatedAlbums($number=5,$showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true) {
	printAlbumStatistic($number,"toprated",$showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop);
}

/**
 * Prints the top voted albums
 *
 * @param string $number the number of albums to get
 * @param bool $showtitle if the album title should be shown
 * @param bool $showdate if the album date should be shown
 * @param bool $showdesc if the album description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 */
function printLatestUpdatedAlbums($number=5,$showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true) {
	printAlbumStatistic($number,"latestupdated",$showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop);
}

/**
 * Returns a list of image statistic according to $option
 *
 * @param string $number the number of images to get
 * @param string $option "popular" for the most popular images,
 *                       "latest" for the latest uploaded,
 *                       "latest-date" for the latest uploaded, but fetched by date,
 * 											 "latest-mtime" for the latest uploaded, but fetched by mtime,
 *                       "mostrated" for the most voted,
 *                       "toprated" for the best voted
 * @param string $albumfolder foldername of an specific album
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 * @return string
 */
function getImageStatistic($number, $option, $albumfolder='',$collection=false) {
	global $_zp_gallery;
	if (zp_loggedin()) {
		$albumWhere = " AND albums.folder != ''";
		$imageWhere = "";
		$passwordcheck = "";
	} else {
		$passwordcheck = '';
		$albumscheck = query_full_array("SELECT * FROM " . prefix('albums'). " ORDER BY title");
		foreach($albumscheck as $albumcheck) {
			if(!checkAlbumPassword($albumcheck['folder'], $hint)) {
				$albumpasswordcheck= " AND albums.id != ".$albumcheck['id'];
				$passwordcheck = $passwordcheck.$albumpasswordcheck;
			}
		}
		$albumWhere = " AND albums.folder != '' AND albums.show=1".$passwordcheck;
		$imageWhere = " AND images.show=1";
	}
	if(!empty($albumfolder)) {
		if($collection) {
				$specificalbum = " albums.folder LIKE '".$albumfolder."/%' AND ";
		} else {
				$specificalbum = " albums.folder = '".$albumfolder."' AND ";
		}
	} else {
		$specificalbum = "";
	}
	switch ($option) {
		case "popular":
			$sortorder = "images.hitcounter"; break;
		case "latest-date":
			$sortorder = "images.date"; break;
		case "latest-mtime":
			$sortorder = "images.mtime"; break;
		case "latest":
			$sortorder = "images.id"; break;
		case "mostrated":
			$sortorder = "images.total_votes"; break;
		case "toprated":
			$sortorder = "(images.total_value/images.total_votes)"; break;
	}
	$imageArray = array();
	$images = query_full_array("SELECT images.albumid, images.filename AS filename, images.mtime as mtime, images.title AS title, " .
 														"albums.folder AS folder, images.show, albums.show, albums.password FROM " .
	prefix('images') . " AS images, " . prefix('albums') . " AS albums " .
															" WHERE ".$specificalbum."images.albumid = albums.id " . $imageWhere . $albumWhere .
															" AND albums.folder != ''".
															" ORDER BY ".$sortorder." DESC LIMIT $number");
	foreach ($images as $imagerow) {
		$filename = $imagerow['filename'];
		$albumfolder2 = $imagerow['folder'];
		$desc = $imagerow['title'];
		// Album is set as a reference, so we can't re-assign to the same variable!
		$image = newImage(new Album($_zp_gallery, $albumfolder2), $filename);
		$imageArray [] = $image;
	}
	return $imageArray;
}

/**
 * Prints image statistic according to $option as an unordered HTML list
 * A css id is attached by default named accordingly'$option'
 *
 * @param string $number the number of albums to get
 * @param string $option "popular" for the most popular images,
 *                       "latest" for the latest uploaded,
 *                       "latest-date" for the latest uploaded, but fetched by date,
 * 											 "latest-mtime" for the latest uploaded, but fetched by mtime,
 *                       "mostrated" for the most voted,
 *                       "toprated" for the best voted
 * @param string $albumfolder foldername of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 * 
 * @return string
 */
function printImageStatistic($number, $option, $albumfolder='', $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	$images = getImageStatistic($number, $option, $albumfolder,$collection);
	echo "\n<div id=\"$option\">\n";
	echo "<ul>";
	foreach ($images as $image) {
		echo "<li><a href=\"" . $image->getImageLink() . "\" title=\"" . html_encode($image->getTitle()) . "\">\n";
		if($crop) {
			echo "<img src=\"".$image->getCustomImage(NULL, $width, $height, $width, $height, NULL, NULL, TRUE)."\" alt=\"" . html_encode($image->getTitle()) . "\" /></a>\n";
		} else {
			echo "<img src=\"".$image->getCustomImage($width, NULL, NULL, NULL, NULL, NULL, NULL, TRUE)."\"alt=\"" . html_encode($image->getTitle()) . "\" /></a>\n";
		}
		if($showtitle) {
			echo "<h3><a href=\"".$image->getImageLink()."\" title=\"" . html_encode($image->getTitle()) . "\">\n";
			echo $image->getTitle()."</a></h3>\n";
		}
		if($showdate) {
			echo "<p>". zpFormattedDate(getOption('date_format'),strtotime($image->getDateTime()))."</p>";
		}
		if($showstatistic === "rating" OR $showstatistic === "rating+hitcounter") {
			$votes = $image->get("total_votes");
			$value = $image->get("total_value");
			if($votes != 0) {
				$rating =  round($value/$votes, 1);
			}
			echo "<p>".sprintf(gettext('Rating: %1$u (Votes: %2$u)'),$rating,$votes)."</p>";
		}
		if($showstatistic === "hitcounter" OR $showstatistic === "rating+hitcounter") {
			$hitcounter = $image->get("hitcounter");
			if(empty($hitcounter)) { $hitcounter = "0"; }
			echo "<p>".sprintf(gettext("Views: %u"),$hitcounter)."</p>";
		}
		if($showdesc) {
			echo "<p>".truncate_string($image->getDesc(), $desclength)."</p>";
		}
		echo "</li>";
	}
	echo "</ul></div>\n";
}

/**
 * Prints the most popular images
 *
 * @param string $number the number of images to get
 * @param string $albumfolder folder of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
* @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 */
function printPopularImages($number=5, $albumfolder='', $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	printImageStatistic($number, "popular",$albumfolder, $showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop,$collection);
}

/**
 * Prints the n top rated images
 *
 * @param int $number The number if images desired
 * @param string $albumfolder folder of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 */
function printTopRatedImages($number=5, $albumfolder="", $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	printImageStatistic($number, "toprated",$albumfolder, $showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop,$collection);
}


/**
 * Prints the n most rated images
 *
 * @param int $number The number if images desired
 * @param string $albumfolder folder of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 */
function printMostRatedImages($number=5, $albumfolder='', $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	printImageStatistic($number, "mostrated", $albumfolder, $showtitle, $showdate, $showdesc, $desclength, $showstatistic,$width,$height,$crop,$collection);
}

/**
 * Prints the latest images by ID (the order zenphoto recognized the images on the filesystem)
 *
 * @param string $number the number of images to get
 * @param string $albumfolder folder of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
* @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 */
function printLatestImages($number=5, $albumfolder='', $showtitle=false, $showdate=false, $showdesc=false, $desclength=40, $showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	printImageStatistic($number, "latest", $albumfolder, $showtitle, $showdate, $showdesc, $desclength, $showstatistic,$width,$height,$crop,$collection);
}

/**
 * Prints the latest images by date order (date taken order)
 *
 * @param string $number the number of images to get
 * @param string $albumfolder folder of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 */
function printLatestImagesByDate($number=5, $albumfolder='', $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	printImageStatistic($number, "latest-date", $albumfolder, $showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop,$collection);
}

/**
 * Prints the latest images by mtime order (date uploaded order)
 *
 * @param string $number the number of images to get
 * @param string $albumfolder folder of an specific album
 * @param bool $showtitle if the image title should be shown
 * @param bool $showdate if the image date should be shown
 * @param bool $showdesc if the image description should be shown
 * @param integer $desclength the length of the description to be shown
 * @param string $showstatistic "hitcounter" for showing the hitcounter (views),
 * 															"rating" for rating,
 * 															"rating+hitcounter" for both.
 * @param integer $width the width/cropwidth of the thumb if crop=true else $width is longest size. (Default 85px)
 * @param integer $height the height/cropheight of the thumb if crop=true else not used.  (Default 85px)
 * @param bool $crop 'true' (default) if the thumb should be cropped, 'false' if not
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 */
function printLatestImagesByMtime($number=5, $albumfolder='', $showtitle=false, $showdate=false, $showdesc=false, $desclength=40,$showstatistic='',$width=85,$height=85,$crop=true,$collection=false) {
	printImageStatistic($number, "latest-date", $albumfolder, $showtitle, $showdate, $showdesc, $desclength,$showstatistic,$width,$height,$crop,$collection);
}
?>