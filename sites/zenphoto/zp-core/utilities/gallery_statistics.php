<?php
/**
 * Detailed Gallery Statistics
 * 
 * This plugin shows statistical graphs and info about your gallery\'s images and albums
 * 
 * @package admin
 */

$button_text = gettext('Gallery Statistics');
$button_hint = gettext('Shows statistical graphs and info about your gallery\'s images and albums.');
$button_icon = 'images/bar_graph.png';

define('OFFSET_PATH', 3);
define('RECORD_SEPARATOR', ':****:');
define('TABLE_SEPARATOR', '::');
define('RESPOND_COUNTER', 1000);
chdir(dirname(dirname(__FILE__)));

require_once(dirname(dirname(__FILE__)).'/admin-functions.php');


if (getOption('zenphoto_release') != ZENPHOTO_RELEASE) {
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/setup.php");
	exit();
}

if (!($_zp_loggedin & (ADMIN_RIGHTS | MAIN_RIGHTS))) { // prevent nefarious access to this page.
	header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin.php");
	exit();
}

$gallery = new Gallery();
$webpath = WEBPATH.'/'.ZENFOLDER.'/';

printAdminHeader($webpath);
?>
<link rel="stylesheet" href="gallery_statistics.css" type="text/css" />
<?php
/**
 * Prints a table with a bar graph of the values.
 *
 * @param string $sortorder "popular", "mostrated","toprated","mostcommented" or - only if $type = "albums"! - "mostimages" 
 * @param string_type $type "albums" or "images"
 * @param int $limit Number of entries to show
 */
function printBarGraph($sortorder="mostimages",$type="albums",$from_number=0, $to_number=10) {
	global $gallery, $webpath;
	$limit = $from_number.",".$to_number;
	$bargraphmaxsize = 400;
	switch ($type) {
		case "albums":
			$typename = gettext("Albums");
			$dbquery = "SELECT id, title, folder, hitcounter, total_votes, total_value, `show` FROM ".prefix('albums');
			break;
		case "images":
			$typename = gettext("Images");
			$dbquery = "SELECT id, title, filename, albumid, hitcounter, total_votes, total_value, `show` FROM ".prefix('images');
			break;
	}
	switch($sortorder) {
		case "popular":
			$itemssorted = query_full_array($dbquery." ORDER BY hitcounter DESC LIMIT ".$limit);
			if(empty($itemssorted)) {
				$maxvalue = 0;
			} else {
				$maxvalue = $itemssorted[0]['hitcounter'];
			}
			$headline = $typename." - ".gettext("most viewed");
			break;
		case "mostrated":
			$itemssorted = query_full_array($dbquery." ORDER BY total_votes DESC LIMIT ".$limit);
			if(empty($itemssorted)) {
				$maxvalue = 0;
			} else {
				$maxvalue = $itemssorted[0]['total_votes'];
			}
			$headline = $typename." - ".gettext("most rated");
			break;
		case "toprated":
			switch($type) {
				case "albums":
					$itemssorted = query_full_array("SELECT * FROM " . prefix('albums') ." ORDER BY (total_value/total_votes) DESC LIMIT $limit");
					break;
				case "images":
					$itemssorted = query_full_array("SELECT * FROM " . prefix('images') ." ORDER BY (total_value/total_votes) DESC LIMIT $limit");
					break;
			}
			if(empty($itemssorted)) {
				$maxvalue = 0;
			} else {
				if($itemssorted[0]['total_votes'] != 0) {
					$maxvalue = ($itemssorted[0]['total_value'] / $itemssorted[0]['total_votes']);
				} else {
					$maxvalue = 0;
				}
			}
			$headline = $typename." - ".gettext("top rated");
			break;
		case "mostcommented":
			switch($type) {
				case "albums":
					$itemssorted = query_full_array("SELECT comments.ownerid, count(*) as commentcount, albums.* FROM ".prefix('comments')." AS comments, ".prefix('albums')." AS albums WHERE albums.id=comments.ownerid AND type = 'albums' GROUP BY comments.ownerid ORDER BY commentcount DESC LIMIT ".$limit); 
					break;
				case "images":
					$itemssorted = query_full_array("SELECT comments.ownerid, count(*) as commentcount, images.* FROM ".prefix('comments')." AS comments, ".prefix('images')." AS images WHERE images.id=comments.ownerid AND type = 'images' GROUP BY comments.ownerid ORDER BY commentcount DESC LIMIT ".$limit); 
					break;
			}
			if(empty($itemssorted)) {
				$maxvalue = 0;
			} else {
				$maxvalue = $itemssorted[0]['commentcount'];
			}
			$headline = $typename." - ".gettext("most commented");
			break;
		case "mostimages":
			$itemssorted = query_full_array("SELECT images.albumid, count(*) as imagenumber, albums.* FROM ".prefix('images')." AS images, ".prefix('albums')." AS albums WHERE albums.id=images.albumid GROUP BY images.albumid ORDER BY imagenumber DESC LIMIT ".$limit); 
			if(empty($itemssorted)) {
				$maxvalue = 0;
			} else {
				$maxvalue =  $itemssorted[0]['imagenumber'];
			}
			$headline = $typename." - ".gettext("most images");
			break;
		case "latest":
			switch($type) {
				case "albums":
					$allalbums = query_full_array($dbquery." ORDER BY id DESC LIMIT ".$limit);
					$albums = array();
					foreach ($allalbums as $album) {
						$albumobj = new Album($gallery,$album['folder']);
						$albumentry = array("id" => $albumobj->get('id'), "title" => $albumobj->getTitle(), "folder" => $albumobj->name,"imagenumber" => $albumobj->getNumImages(), "show" => $albumobj->get("show"));
						array_unshift($albums,$albumentry);
					}
					$maxvalue = 0;
					if(empty($albums)) {
						$itemssorted = array();
					} else {
						foreach ($albums as $entry) {
							if (array_key_exists('imagenumber', $entry)) {
								$v = $entry['imagenumber'];
								if ($v > $maxvalue) $maxvalue = $v;
							}
						}
						$itemssorted = $albums; // The items are originally sorted by id;
					}
					$headline = $typename." - ".gettext("latest");
					break;
				case "images":
					$itemssorted = query_full_array($dbquery." ORDER BY id DESC LIMIT ".$limit);
					$barsize = 0;
					$maxvalue = 1;
					$headline = $typename." - ".gettext("latest");
					break;
			}
			break;
		 case "latestupdated":
		 		// part taken from the image_albums_statistics - could probably be optimized regarding queries...
		 		// get all albums
		 		$allalbums = query_full_array("SELECT id, title, folder, `show` FROM " . prefix('albums'));
		 		$albums = array();
		 		$latestimages = array();
		 		foreach ($allalbums as $album) {
					$albumobj = new Album($gallery,$album['folder']);
					$albumentry = array("id" => $albumobj->get('id'), "title" => $albumobj->getTitle(), "folder" => $albumobj->name,"imagenumber" => $albumobj->getNumImages(), "show" => $albumobj->get("show"));
					array_unshift($albums,$albumentry);
				}
		 	 	// get latest images of each album
				$count = 0;
		 		foreach($albums as $album) {
		 			$count++;
		 			$image = query_single_row("SELECT id, albumid, mtime FROM " . prefix('images'). " WHERE albumid = ".$album['id'] . " ORDER BY id DESC LIMIT 1");
					if (is_array($image)) array_push($latestimages, $image);
		 			if($count === $to_number) {
		 				break;
		 			}
		 		} 
		 		// sort latest image by mtime
		 		$latestimages = sortMultiArray($latestimages,"mtime","desc",false,false);
		 		//echo "<pre>"; print_r($albums); echo "</pre>";
		 		$itemssorted = array();
		 		$count = 0;
		 		foreach($latestimages as $latestimage) {
		 			$count++;
		 			foreach($allalbums as $album) {
		 				if($album['id'] === $latestimage['albumid']) {
		 					array_push($albums,$album);
		 				}
		 			}
		 			if($count === $to_number) {
		 				break;
		 			}
		 		}
		 		if($to_number < 1) {
		 			$stopelement = 1;
		 		} else {
		 			$stopelement = $to_number;
		 		}
		 		$albums = array_slice($albums,0,$stopelement); // clear unnessesary items fron array
		 		$maxvalue = 0;
		 		if(empty($albums)) {
		 			$itemssorted = array();
		 		} else {
					foreach ($albums as $key=>$entry) {
						if (array_key_exists('imagenumber', $entry)) {
							$v = $entry['imagenumber'];
							if ($v > $maxvalue) $maxvalue = $v;
						} else {
							unset($albums[$key]); // if it has no imagenumber it must not be a valid entry!
						}
					}
		 			$itemssorted = $albums; // The items are originally sorted by id;
		 		}
		 		$headline = $typename." - ".gettext("latest updated");
		 		//echo "<pre>"; print_r($albums); echo "</pre>";
			break; 
	}
	if($maxvalue == 0 OR empty($itemssorted)) {
		$maxvalue = 1;
		$no_statistic_message = "<tr><td><em>".gettext("No statistic available")."</em></td><td></td><td></td><td></td></tr>";
	} else {
		$no_statistic_message = "";
	}
	if($from_number <= 1) {
		$count = 1;
	} else {
		$count = $from_number;
	}
	$countlines = 0;
	echo "<table class='bordered'>";
	echo "<tr><th colspan='4'><strong>".$headline."</strong>";
	
	if(isset($_GET['stats'])) {
		echo "<a href='gallery_statistics.php'> | ".gettext("Back to the top 10 lists")."</a>";
	} else {
		if(empty($no_statistic_message)) {
			echo "<a href='gallery_statistics.php?stats=".$sortorder."&amp;type=".$type."'> | ".gettext("View more")."</a>";
		}
		echo "<a href='#top'> | ".gettext("top")."</a>";
	}
	echo "</th></tr>";
	echo $no_statistic_message;
	foreach ($itemssorted as $item) {
		if(array_key_exists("filename",$item)) {
			$name = $item['filename'];
		} else if(array_key_exists("folder",$item)){
			$name = $item['folder'];
		}
		switch($sortorder) {
			case "popular":
				$barsize = round($item['hitcounter'] / $maxvalue * $bargraphmaxsize);
				$value = $item['hitcounter'];
				break;
			case "mostrated":
				if($item['total_votes'] != 0) {
					$barsize = round($item['total_votes'] / $maxvalue * $bargraphmaxsize);
				} else {
					$barsize = 0;
				}
				$value = $item['total_votes'];
				break;
			case "toprated":
				if($item['total_votes'] != 0) {
					$barsize = round(($item['total_value'] / $item['total_votes']) / $maxvalue * $bargraphmaxsize);
					$value = round($item['total_value'] / $item['total_votes']);
				} else {
					$barsize = 0;
					$value = 0;
				}
				break;
			case "mostcommented":
				if($maxvalue != 0) {
					$barsize = round($item['commentcount'] / $maxvalue * $bargraphmaxsize);
				} else {
					$barsize = 0;
				}
				$value = $item['commentcount'];
				break;
			case "mostimages":
				$barsize = round($item['imagenumber'] / $maxvalue * $bargraphmaxsize);
				$value = $item['imagenumber'];
				break;
			case "latest":
				switch($type) {
					case "albums":
						$barsize = 0; //round($item['imagenumber'] / $maxvalue * $bargraphmaxsize);
						$value = sprintf(gettext("%s images"),$item['imagenumber']); 
						break;
					case "images":
						$barsize = 0;
						$value = "";
						break;
				}
				break;		
			case "latestupdated":
				$barsize = 0; //round($item['imagenumber'] / $maxvalue * $bargraphmaxsize);
				$value = sprintf(gettext("%s images"),$item['imagenumber']); 
				break;
		}
		// counter to have a gray background of every second line
		if($countlines === 1) {
			$style = "style='background-color: #f4f4f4'";	// a little ugly but the already attached class for the table is so easiest overriden...	
			$countlines = 0;
		} else {
			$style = "";
			$countlines++;
		}
		switch($type) {
			case "albums":
				$editurl=  $webpath."/admin.php?page=edit&amp;album=".$name;
				$viewurl = WEBPATH."/index.php?album=".$name;
				break;
			case "images":
				$getalbumfolder = query_single_row("SELECT title, folder, `show` from ".prefix("albums"). " WHERE id = ".$item['albumid']);
				if($sortorder === "latest") {
					$value = "<span";
					if($getalbumfolder['show'] != "1") {
						$value = $value." class='unpublished_item'";
					}					
					$value = $value.">".get_language_string($getalbumfolder['title'])."</span> (".$getalbumfolder['folder'].")";
				}
				$editurl=  $webpath."/admin.php?page=edit&amp;album=".$getalbumfolder['folder']."&amp;image=".$item['filename']."&amp;tab=imageinfo#IT";
				$viewurl = WEBPATH."/index.php?album=".$getalbumfolder['folder']."&amp;image=".$name;
				break;
		}
		if($item['show'] != "1") {
			$show = " class='unpublished_item'";
		} else {
			$show = "";
		}
		if($value != 0 OR $sortorder === "latest") {
		?>
		<tr class="statistic_wrapper">
		<td class="statistic_counter" <?php echo $style; ?>><?php echo $count; ?></td>
		<td class="statistic_title" <?php echo $style; ?>><strong<?php echo $show; ?>><?php echo get_language_string($item['title']); ?></strong> (<?php echo $name; ?>)</td>
		<td class="statistic_graphwrap" <?php echo $style; ?>><div class="statistic_bargraph" style="width: <?php echo $barsize; ?>px"></div><div class="statistic_value"><?php echo $value; ?></div></td>
		<td class="statistic_link" <?php echo $style; ?>>
		<?php
		echo "<a href='".$editurl."' title='".$name."'>".gettext("Edit")."</a> | <a href='".$viewurl."' title='".$name."'>".gettext("View")."</a></td";
		echo "</tr>";
		$count++; 	
		if($count === $limit) { break; }
		} 
	} // foreach end
	echo "</table>";
}
echo '</head>';
?>

<body>
<?php printLogoAndLinks(); ?>
<div id="main">
<a name="top"></a>
<?php printTabs('database'); 

// getting the counts
$albumcount = $gallery->getNumAlbums(true);
$albumscount_unpub = $albumcount-$gallery->getNumAlbums(true,true);
$imagecount = $gallery->getNumImages();
$imagecount_unpub = $imagecount-$gallery->getNumImages(true);
?>
<div id="content">
<h1><?php echo gettext("Gallery Statistics"); ?></h1>
<p><?php echo gettext("This page shows more detailed statistics of your gallery. For album statistics the bar graph always shows the total number of images in that album. For image statistics always the album the image is in is shown.<br />Unpublished items are marked in darkred. Images are marked unpublished if their (direct) album is, too."); ?></p>

<ul class="statistics_general"><li>
<?php 
if ($imagecount_unpub > 0) {
	printf(gettext('<strong>%1$u</strong> images (%2$u not visible)'),$imagecount, $imagecount_unpub);
} else {
	printf(gettext('<strong>%u</strong> images'),$imagecount);
}
?>
</li><li>
<?php
if ($albumscount_unpub > 0) {
	printf(gettext('<strong>%1$u</strong> albums (%2$u not published)'),$albumcount, $albumscount_unpub);
} else {
	printf(gettext('<strong>%u</strong> albums'),$albumcount);
}
?>
</li>
<li>
<?php
$commentcount = $gallery->getNumComments(true);
$commentcount_mod = $commentcount - $gallery->getNumComments(false);
if ($commentcount_mod > 0) {
	if ($commentcount != 1) {
		printf(gettext('<strong>%1$u</strong> comments (%2$u in moderation)'),$commentcount, $commentcount_mod);
	} else {
		printf(gettext('<strong>1</strong> comment (%u in moderation)'), $commentcount_mod);
	}
} else {
	if ($commentcount != 1) {
		printf(gettext('<strong>%u</strong> comments'),$commentcount);
	} else {
		echo gettext('<strong>1</strong> comment');
	}
}
?>
</li></ul>
	
<?php
if(!isset($_GET['stats']) AND !isset($_GET['fulllist'])) {
	?>
	<ul class="statistic_navlist">
		<li><strong><?php echo gettext("Images"); ?></strong>
		<ul>
				<li><a href="#images-latest"><?php echo gettext("latest"); ?></a> | </li>
				<li><a href="#images-popular"><?php echo gettext("most viewed"); ?></a> | </li>
				<li><a href="#images-mostrated"><?php echo gettext("most rated"); ?></a> | </li>
				<li><a href="#images-toprated"><?php echo gettext("top rated"); ?></a> | </li>
				<li><a href="#images-mostcommented"><?php echo gettext("most commented"); ?></a></li>
		</ul>
		</li>
		<li><strong><?php echo gettext("Albums"); ?></strong>
		<ul>
				<li><a href="#albums-latest"><?php echo gettext("latest"); ?></a> | </li>
				<li><a href="#albums-latestupdated"><?php echo gettext("latest updated"); ?></a> | </li>
				<li><a href="#albums-mostimages"><?php echo gettext("most images"); ?></a> | </li>
				<li><a href="#albums-popular"><?php echo gettext("most viewed"); ?></a> | </li>
				<li><a href="#albums-mostrated"><?php echo gettext("most rated"); ?></a> | </li>
				<li><a href="#albums-toprated"><?php echo gettext("top rated"); ?></a> | </li>
				<li><a href="#albums-mostcommented"><?php echo gettext("most commented"); ?></a></li>
		</ul>
		</li>
</ul>
<br style="clear:both" />

<!-- images --> 
<a name="images-latest"></a>
<?php printBarGraph("latest","images"); ?>
	
<a name="images-popular"></a>
<?php printBarGraph("popular","images"); ?>
  
<a name="images-mostrated"></a>
<?php printBarGraph("mostrated","images"); ?>
  
<a name="images-toprated"></a>
<?php printBarGraph("toprated","images"); ?>
  
<a name="images-mostcommented"></a>
<?php printBarGraph("mostcommented","images"); ?>

<!-- albums --> 
<a name="albums-latest"></a>
<?php printBarGraph("latest","albums"); ?>

<a name="albums-latestupdated"></a>
<?php printBarGraph("latestupdated","albums"); ?>

<a name="albums-mostimages"></a>
<?php printBarGraph("mostimages","albums"); ?>

<a name="albums-popular"></a>
<?php printBarGraph("popular","albums"); ?>
	
<a name="albums-mostrated"></a>
<?php printBarGraph("mostrated","albums"); ?>
	
<a name="albums-toprated"></a>
<?php printBarGraph("toprated","albums"); ?>

<a name="albums-mostcommented"></a>
<?php printBarGraph("mostcommented","albums"); ?>

<?php }
// If a single list is requested
if(isset($_GET['type'])) {
	if(!isset($_GET['from_number'])) {
		$from_number = 0;
		$from_number_display = 1;
	} else {
		$from_number = sanitize_numeric($_GET['from_number'])-1;
		$from_number_display = sanitize_numeric($_GET['from_number']);
	}
	if(!isset($_GET['to_number'])) {
		$to_number = 50;
		if($_GET['type'] === "images" AND $to_number > $imagecount) {
			$to_number = $imagecount;
		}
		if($_GET['type'] === "albums" AND $to_number > $albumcount) {
			$to_number = $albumcount;
		} 
		$to_number_display = $to_number;
	} else {
		$to_number = sanitize_numeric($_GET['to_number']);
		$to_number_display = $to_number;
		if($from_number < $to_number) {
			$to_number_display = $to_number;
			$to_number = $to_number-$from_number;
		} 
	}
	?>
		<form name="limit" id="limit" action="gallery_statistics.php">
		<label for="from_number"><?php echo gettext("From "); ?></label>
		<input type ="text" size="10" id="from_number" name="from_number" value="<?php echo $from_number_display; ?>" /> 
		<label for="to_number"><?php echo gettext("to "); ?></label>
		<input type ="text" size="10" id="to_number" name="to_number" value="<?php echo $to_number_display; ?>" /> 
		<input type="hidden" name="stats"	value="<?php echo sanitize($_GET['stats']); ?>" /> 
		<input type="hidden" name="type"value="<?php echo sanitize($_GET['type']); ?>" /> 
		<input type="submit" value="<?php echo gettext("Show"); ?>" />
		</form>
		<br />
		<?php
		switch ($_GET['type']) {
			case "albums":
				switch ($_GET['stats']) {
					case "latest":
						printBarGraph("latest","albums",$from_number,$to_number);
						break;
					case "latestupdated":
						printBarGraph("latestupdated","albums",$from_number,$to_number);
						break;
					case "popular":
						printBarGraph("popular","albums",$from_number,$to_number);
						break;
					case "mostrated":
						printBarGraph("mostrated","albums",$from_number,$to_number);
						break;
					case "toprated":
						printBarGraph("toprated","albums",$from_number,$to_number);
						break;
					case "mostcommented":
						printBarGraph("mostcommented","albums",$from_number,$to_number);
						break;
					case "mostimages":
						printBarGraph("mostimages","albums",$from_number,$to_number);
						break;
				}
				break;
					case "images":

						switch ($_GET['stats']) {
							case "latest":
								printBarGraph("latest","images",$from_number,$to_number);
								break;
							case "popular":
								printBarGraph("popular","images",$from_number,$to_number);
								break;
							case "mostrated":
								printBarGraph("mostrated","images",$from_number,$to_number);
								break;
							case "toprated":
								printBarGraph("toprated","images",$from_number,$to_number);
								break;
							case "mostcommented":
								printBarGraph("mostcommented","images",$from_number,$to_number);
								break;
						}
						break;
		} // main switch end
		echo "<a href='#top'>".gettext("Back to top")."</a>";
} // main if end

?>
</div><!-- content -->
<?php printAdminFooter(); ?>
</div><!-- main -->
</body>
<?php echo "</html>"; ?>