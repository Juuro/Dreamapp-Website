<?php
/**
 * slideshow -- Supports showing slideshows of images in an album.
 *
 * 	Plugin Option 'slideshow_size' -- Size of the images
 *	Plugin Option 'slideshow_mode' -- The player to be used
 *	Plugin Option 'slideshow_effect' -- The cycle effect
 *	Plugin Option 'slideshow_speed' -- How fast it runs
 *	Plugin Option 'slideshow_timeout' -- Transition time
 *	Plugin Option 'slideshow_showdesc' -- Allows the show to display image descriptions
 *
 * The theme files 'slideshow.php', 'slideshow.css', and 'slideshow-controls.png' must reside in the theme
 * folder. If you are creating a custom theme, copy these files form the "default" theme of the Zenphoto
 * distribution.
 *
 * NOTE: The jQuery mode does not support movie and audio files anymore. If you need to show them please use the Flash mode.
 *
 * @author Malte Müller (acrylian), Stephen Billard (sbillard), Don Peterson (dpeterson)
 * @version 1.0.6.6
 * @package plugins
 */

$plugin_description = gettext("Adds a theme function to call a slideshow either based on jQuery (default) or Flash using Flowplayer if installed. Additionally the files <em>slideshow.php</em>, <em>slideshow.css</em> and <em>slideshow-controls.png</em> need to be present in the theme folder.");
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard), Don Peterson (dpeterson)";
$plugin_version = '1.0.6.6';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---slideshow.php.html";
$option_interface = new slideshowOptions();

/**
 * Plugin option handling class
 *
 */
class slideshowOptions {

	function slideshowOptions() {
	 	setOptionDefault('slideshow_size', '595');
		setOptionDefault('slideshow_mode', 'jQuery');
		setOptionDefault('slideshow_effect', 'fade');
		setOptionDefault('slideshow_speed', '500');
		setOptionDefault('slideshow_timeout', '3000');
		setOptionDefault('slideshow_showdesc', '');
		// incase the flowplayer has not been enabled!!!
		setOptionDefault('slideshow_flow_player_width', '640');
		setOptionDefault('slideshow_flow_player_height', '480');
	}


	function getOptionsSupported() {
		return array(	gettext('Size') => array('key' => 'slideshow_size', 'type' => 0,
										'desc' => gettext("Size of the images in the slideshow. <em>[jQuery mode option]</em><br />If empty the theme options <em>image size</em> is used.")),
									gettext('Mode') => array('key' => 'slideshow_mode', 'type' => 5,
										'selections' => array(gettext("jQuery")=>"jQuery", gettext("flash")=>"flash"),
										'desc' => gettext("<em>jQuery</em> for JS ajax slideshow, <em>flash</em> for flash based slideshow (requires Flowplayer.)")),
									gettext('Effect') => array('key' => 'slideshow_effect', 'type' => 5,
										'selections' => array(gettext('fade')=>"fade", gettext('shuffle')=>"shuffle", gettext('zoom')=>"zoom", gettext('slide X')=>"slideX", gettext('slide Y')=>"slideY", gettext('scroll up')=>"scrollUp", gettext('scroll down')=>"scrollDown", gettext('scroll left')=>"scrollLeft", gettext('scroll right')=>"scrollRight"),
										'desc' => gettext("The cycle slide effect to be used. <em>[jQuery mode option]</em>")),
									gettext('Speed') => array('key' => 'slideshow_speed', 'type' => 0,
										'desc' => gettext("Speed of the transition in milliseconds.")),
									gettext('Timeout') => array('key' => 'slideshow_timeout', 'type' => 0,
										'desc' => gettext("Milliseconds between slide transitions (0 to disable auto advance.) <em>[jQuery mode option]</em>")),
									gettext('Description') => array('key' => 'slideshow_showdesc', 'type' => 1,
										'desc' => gettext("Check if you want to show the image's description below the slideshow <em>[jQuery mode option]</em>.")),
									gettext('flow player width') => array('key' => 'slideshow_flow_player_width', 'type' => 0,
										'desc' => gettext("Width of the Flowplayer display for the slideshow <em>(Flash mode)</em>.")),
									gettext('flow player height') => array('key' => 'slideshow_flow_player_height', 'type' => 0,
										'desc' => gettext("Height of the Flowplayer display for the slideshow <em>(Flash mode)</em>."))
		);
	}

	function handleOption($option, $currentValue) {
	}

}

$slideshow_instance = 0;

/**
 * Prints a link to call the slideshow (not shown if there are no images in the album)
 * To be used on album.php and image.php
 * A CSS id names 'slideshowlink' is attached to the link so it can be directly styled.
 *
 * @param string $linktext Text for the link
 */
function printSlideShowLink($linktext='') {
	global $_zp_current_image, $_zp_current_album, $_zp_current_search, $slideshow_instance;
	if (checkForPassword(true)) return;
	if(empty($_GET['page'])) {
		$pagenr = 1;
	} else {
		$pagenr = $_GET['page'];
	}
	$slideshowhidden = '';
	if (in_context(ZP_SEARCH)) {
		$imagenumber = '';
		$imagefile = '';
		$albumnr = 0;
		$slideshowlink = rewrite_path("/page/slideshow","index.php?p=slideshow");
		$slideshowhidden = '<input type="hidden" name="preserve_search_params" value="'.$_zp_current_search->getSearchParams().'" />';
	} else {
		if(in_context(ZP_IMAGE)) {
			$imagenumber = imageNumber();
			$imagefile = $_zp_current_image->filename;
		} else {
			$imagenumber = "";
			$imagefile = "";
		}
		if (in_context(ZP_SEARCH_LINKED)) {
			$albumnr = -getAlbumID();
		} else {
			$albumnr = getAlbumID();
		}
		$slideshowlink = rewrite_path(pathurlencode($_zp_current_album->getFolder())."/page/slideshow","index.php?p=slideshow&amp;album=".urlencode($_zp_current_album->getFolder()));
	}
	$numberofimages = getNumImages();
	if($numberofimages != 0) {
		?>
		<form name="slideshow_<?php echo $slideshow_instance; ?>" method="post" action="<?php echo $slideshowlink; ?>">
			<?php echo $slideshowhidden; ?>
			<input type="hidden" name="pagenr" value="<?php echo $pagenr;?>" />
			<input type="hidden" name="albumid" value="<?php echo $albumnr;?>" />
			<input type="hidden" name="numberofimages" value="<?php echo $numberofimages;?>" />
			<input type="hidden" name="imagenumber" value="<?php echo $imagenumber;?>" />
			<input type="hidden" name="imagefile" value="<?php echo html_encode($imagefile);?>" />
			<a id="slideshowlink_<?php echo $slideshow_instance; ?>" href="javascript:document.slideshow_<?php echo $slideshow_instance; ?>.submit()"><?php echo $linktext; ?></a>
		</form>
<?php }
	$slideshow_instance ++;
}


/**
 * Prints the slideshow using the jQuery plugin Cycle (http://http://www.malsup.com/jquery/cycle/)
 * or Flash based using Flowplayer http://flowplayer.org if installed
 * If called from image.php it starts with that image, called from album.php it starts with the first image (jQuery only)
 * To be used on slideshow.php only and called from album.php or image.php.
 * Image size is taken from the calling link or if not specified there the sized image size from the options
 *
 * NOTE: The jQuery mode does not support movie and audio files anymore. If you need to show them please use the Flash mode.
 *
 * @param bool $heading set to true (default) to emit the slideshow breadcrumbs in flash mode
 * @param bool $speedctl controls whether an option box for controlling transition speed is displayed
 */
function printSlideShow($heading = true, $speedctl = false) {
	if (!isset($_POST['albumid'])) {
		echo "<div class=\"errorbox\" id=\"message\"><h2>".gettext("Invalid linking to the slideshow page.")."</h2></div>";
		echo "</div></body></html>";
		exit();
	}
	global $_zp_flash_player;
	if(empty($_POST['imagenumber'])) {
		$imagenumber = 0;
		$count = 0;
	} else {
		$imagenumber = ($_POST['imagenumber']-1); // slideshows starts with 0, but zp with 1.
		$count = $_POST['imagenumber'];
	}
	$numberofimages = sanitize_numeric($_POST['numberofimages']);
	$albumid = sanitize_numeric($_POST['albumid']);
	if(getOption("slideshow_size")) {
		$imagesize = getOption("slideshow_size");
	} else {
		$imagesize = getOption("image_size");
	}
	$option = getOption("slideshow_mode");
	// jQuery Cycle slideshow config
	// get slideshow data

	$gallery = new Gallery();
	if ($albumid <= 0) { // search page
		$dynamic = 2;
		$search = new SearchEngine();
		$params = $_POST['preserve_search_params'];		
		$search->setSearchParams($params);
		$images = $search->getImages(0);
		$searchwords = $search->words;
		$searchdate = $search->dates;
		$searchfields = $search->fields;
		$page = $search->page;
		if (empty($_POST['imagenumber'])) {
			$albumq = query_single_row("SELECT title, folder FROM ". prefix('albums') ." WHERE id = ".abs($albumid));
			$album = new Album($gallery, $albumq['folder']);
			$returnpath = rewrite_path('/'.pathurlencode($album->name).'/page/'.$_POST['pagenr'],'/index.php?album='.urlencode($album->name).'&page='.$_POST['pagenr']);
		} else {
			$returnpath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
		}
		$albumtitle = gettext('Search');
	} else {
		$albumq = query_single_row("SELECT title, folder FROM ". prefix('albums') ." WHERE id = ".$albumid);
		$album = new Album($gallery, $albumq['folder']);
		$albumtitle = $album->getTitle();
		if(!checkAlbumPassword($albumq['folder'], $hint)) {
			echo gettext("This album is password protected!"); exit;
		}
		$dynamic = $album->isDynamic();
		$images = $album->getImages(0);
		// return path to get back to the page we called the slideshow from
		if (empty($_POST['imagenumber'])) {
			$returnpath = rewrite_path('/'.pathurlencode($album->name).'/page/'.$_POST['pagenr'],'/index.php?album='.urlencode($album->name).'&page='.$_POST['pagenr']);
		} else {
			$returnpath = rewrite_path('/'.pathurlencode($album->name).'/'.rawurlencode($_POST['imagefile']).getOption('mod_rewrite_image_suffix'),'/index.php?album='.urlencode($album->name).'&image='.urlencode($_POST['imagefile']));
		}
	}
	// slideshow display section
	switch($option) {
		case "jQuery":
?>
<script type="text/javascript">
	$(document).ready(function(){
		$(function() {
			var ThisGallery = '<?php echo html_encode($albumtitle); ?>';
			var ImageList = new Array();
			var TitleList = new Array();
			var DescList = new Array();
			var ImageNameList = new Array();
			var DynTime=(<?php echo getOption("slideshow_timeout"); ?>) * 1.0;	// force numeric
<?php
			for ($cntr = 0, $idx = $imagenumber; $cntr < $numberofimages; $cntr++, $idx++) {
				if ($dynamic) {
					$filename = $images[$idx]['filename'];
					$album = new Album($gallery, $images[$idx]['folder']);
					$image = newImage($album, $filename);
				} else {
					$filename = $images[$idx];
					$image = newImage($album, $filename);
				}
				$ext = strtolower(strrchr($filename, "."));

				// 2008-08-02 acrylian: This at least make the urls correct, the flashplayer does not load anyway...
				if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4")) {
					$img = FULLWEBPATH.'/albums/'.pathurlencode($image->album->name) .'/'. urlencode($filename);
				} else {
					$img = WEBPATH . '/' . ZENFOLDER . '/i.php?a=' . pathurlencode($image->album->name) . '&i=' . urlencode($filename) . '&s=' . $imagesize;
				}
				echo 'ImageList[' . $cntr . '] = "' . $img . '";'. "\n";
				echo 'TitleList[' . $cntr . '] = "' . js_encode($image->getTitle()) . '";'. "\n";
				if(getOption("slideshow_showdesc")) {
					$desc = $image->getDesc();
					$desc = str_replace("\r\n", '<br />', $desc); 
					$desc = str_replace("\r", '<br />', $desc); 
					echo 'DescList[' . $cntr . '] = "' . js_encode($desc) . '";'. "\n";
				} else {
					echo 'DescList[' . $cntr . '] = "";'. "\n";
				}
				if ($idx == $numberofimages - 1) { $idx = -1; }
				echo 'ImageNameList[' . $cntr . '] = "'.urlencode($filename).'";'. "\n";
			}
			echo "\n";

?>
			var countOffset = <?php echo $imagenumber; ?>;
			var totalSlideCount = <?php echo $numberofimages; ?>;
			var currentslide = 2;

			function onBefore(curr, next, opts) {
				if (opts.timeout != DynTime) {
					opts.timeout = DynTime;
				}
				if (!opts.addSlide)
					return;
				
				var currentImageNum = currentslide;
				currentslide++;
				if (currentImageNum == totalSlideCount) {
					opts.addSlide = null;
					return;
				}
				var relativeSlot = (currentslide + countOffset) % totalSlideCount;
				if (relativeSlot == 0) {relativeSlot = totalSlideCount;}
				var htmlblock = "<span class='slideimage'><h4><strong>" + ThisGallery + ":</strong> ";
				htmlblock += TitleList[currentImageNum]  + " (" + relativeSlot + "/" + totalSlideCount + ")</h4>";
				htmlblock += "<img src='" + ImageList[currentImageNum] + "'/>";
				htmlblock += "<p class='imgdesc'>" + DescList[currentImageNum] + "</p></span>";
				opts.addSlide(htmlblock);
			}

			function onAfter(curr, next, opts){
				<?php if (!isMyALbum($album->name, ALL_RIGHTS)) { ?>
				//Only register at hit count the first time the image is viewed.
				if ($(next).attr( 'viewed') != 1) {
					$.get("<?php echo FULLWEBPATH .'/'. ZENFOLDER . PLUGIN_FOLDER; ?>slideshow/slideshow-counter.php?album=<?php echo pathurlencode($album->name); ?>&img="+ImageNameList[opts.currSlide]);
					$(next).attr( 'viewed', 1 );
				}
				<?php } ?>
			}

			$('#slides').cycle({
					fx:     '<?php echo getOption("slideshow_effect"); ?>',
					speed:   <?php echo getOption("slideshow_speed"); ?>,
					timeout: DynTime,
					next:   '#next',
					prev:   '#prev',
					cleartype: 1,
					before: onBefore,
					after: onAfter
			});

			$('#speed').change(function () {
				DynTime = this.value;
				return false;
			});

			$('#pause').click(function() { $('#slides').cycle('pause'); return false; });
			$('#play').click(function() { $('#slides').cycle('resume'); return false; });
		});

	});	// Documentready()

	</script>
<div id="slideshow" align="center">
<?php
// 7/21/08dp
if ($speedctl) {
      echo '<div id="speedcontrol">'; // just to keep it away from controls for sake of this demo
      $minto = getOption("slideshow_speed");
      while ($minto % 500 != 0) {
      	$minto += 100;
      	if ($minto > 10000) { break; }  // emergency bailout!
      }
      $dflttimeout = getOption("slideshow_timeout");
	  /* don't let min timeout = speed */
	  $thistimeout = ($minto == getOption("slideshow_speed")? $minto + 250 : $minto);
	  echo 'Select Speed: <select id="speed" name="speed">';
      while ( $thistimeout <= 60000) {  // "around" 1 minute :)
      	echo "<option value=$thistimeout " . ($thistimeout == $dflttimeout?" selected='selected'>" :">") . round($thistimeout/1000,1) . " sec</option>";
		  /* put back timeout to even increments of .5 */
		if ($thistimeout % 500 != 0) { $thistimeout -= 250; }
      	$thistimeout += ($thistimeout < 1000? 500:($thistimeout < 10000? 1000:5000));
      }
      echo "</select> </div>";
}
?>

	<div id="controls">
			<div>
				<span><a href="#" id="prev" title="<?php echo gettext("Previous"); ?>"></a></span>
				<a href="<?php echo $returnpath; ?>" id="stop" title="<?php echo gettext("Stop and return to album or image page"); ?>"></a>
  				<a href="#" id="pause" title="<?php echo gettext("Pause (to stop the slideshow without returning)"); ?>"></a>
				<a href="#" id="play" title="<?php echo gettext("Play"); ?>"></a>
				<a href="#" id="next" title="<?php echo gettext("Next"); ?>"></a>
			</div>
		</div>
<div id="slides" class="pics">

<?php

		for ($cntr = 0, $idx = $imagenumber; $cntr < 2; $cntr++, $idx++) {
			$count++;
			if($count > $numberofimages){
				$count = 1;
			}
			if ($idx >= $numberofimages) { $idx = 0; }
			if ($dynamic) {
				$folder = $images[$idx]['folder'];
				$dalbum = new Album($gallery, $folder);
				$filename = $images[$idx]['filename'];
				$image = newImage($dalbum, $filename);
				$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".urlencode($filename);
			} else {
				$folder = $album->name;
				$filename = $images[$idx];
				//$filename = $animage;
				$image = newImage($album, $filename);
				$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".urlencode($filename);

			}
			$ext = strtolower(strrchr($filename, "."));
			echo "<span class='slideimage'><h4><strong>".$albumtitle.gettext(":")."</strong> ".$image->getTitle()." (". ($idx + 1) ."/".$numberofimages.")</h4>";

			if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4")) {
				//Player Embed...
				if (is_null($_zp_flash_player)) {
					echo "<img src='" . WEBPATH . '/' . ZENFOLDER . "'/images/err-noflashplayer.gif' alt='".gettext("No flash player installed.")."' />";
				} else {
					//FIX ME: The slideshow should really handle playing this when type=jquery but it currently does not. 
					//$_zp_flash_player->printPlayerConfig($imagepath,html_encode($image->getTitle()),$count);
				}
			}
			elseif ($ext == ".3gp") {
				echo '</a>
				<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="352" height="304" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
				<param name="src" value="' . $imagepath. '"/>
				<param name="autoplay" value="false" />
				<param name="type" value="video/quicktime" />
				<param name="controller" value="true" />
				<embed src="' . $imagepath. '" width="352" height="304" autoplay="false" controller"true" type="video/quicktime"
				pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
				</object><a>';
			}
			elseif ($ext == ".mov") {
				echo '</a>
		 		<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="640" height="496" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
			 	<param name="src" value="' . $imagepath. '"/>
			 	<param name="autoplay" value="false" />
			 	<param name="type" value="video/quicktime" />
			 	<param name="controller" value="true" />
			 	<embed src="'  . $imagepath. '" width="640" height="496" autoplay="false" controller"true" type="video/quicktime"
			 	pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
				</object><a>';
		} else {
			echo "<img src='".WEBPATH."/".ZENFOLDER."/i.php?a=".urlencode($folder)."&i=".urlencode($filename)."&s=".$imagesize."' alt='".html_encode($image->getTitle())."' title='".html_encode($image->getTitle())."' />\n";
		}
		if(getOption("slideshow_showdesc")) { 
			$desc = $image->getDesc();
			$desc = str_replace("\r\n", '<br />', $desc); 
			$desc = str_replace("\r", '<br />', $desc); 
			echo "<p class='imgdesc'>".$desc."</p>"; 
		}
		echo "</span>";
	}

	break;

case "flash":
	if ($heading) {
		echo "<span class='slideimage'><h4><strong>".$albumtitle."</strong> (".$numberofimages." images) | <a style='color: white' href='".$returnpath."' title='".gettext("back")."'>".gettext("back")."</a></h4>";
	}
	echo "<span id='slideshow'></span>";
	?>
<script type="text/javascript">
$("#slideshow").flashembed({
      src:'<?php echo FULLWEBPATH . '/' . ZENFOLDER; ?>/plugins/flowplayer/FlowPlayerLight.swf',
      width:<?php echo getOption("slideshow_flow_player_width"); ?>,
      height:<?php echo getOption("slideshow_flow_player_height"); ?>
    },
    {config: {
      autoPlay: true,
      useNativeFullScreen: true,
      playList: [
<?php
	$count = 0;
	foreach($images as $animage) {
			if ($dynamic) {
				$folder = $animage['folder'];
				$filename = $animage['filename'];
				$image = newImage($dalbum, $filename);
				$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($salbum->name)."/".urlencode($filename);
			} else {
				$folder = $album->name;
				$filename = $animage;
				$image = newImage($album, $filename);
				$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".pathurlencode($filename);
			}
		$count++;
		$ext = strtolower(strrchr($filename, "."));
		if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4")) {
			$duration = "";
		} else {
			$duration = " duration: ".getOption("slideshow_speed")/10;
		}
		echo "{ url: '".FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".urlencode($filename)."', ".$duration." }\n";
		if($count < $numberofimages) { echo ","; }
	}
?>
     ],
      showPlayListButtons: true,
      showStopButton: true,
      controlBarBackgroundColor: 0,
     	showPlayListButtons: true,
     	controlsOverVideo: 'ease',
     	controlBarBackgroundColor: '<?php echo getOption('flow_player_controlbarbackgroundcolor'); ?>',
      controlsAreaBorderColor: '<?php echo getOption('flow_player_controlsareabordercolor'); ?>'
    }}
  );
</script>


<?php
	echo "</span>";
	echo "<p>";
	printf (gettext("Click on %s on the right in the player control bar to view full size."), "<img style='position: relative; top: 4px; border: 1px solid gray' src='".WEBPATH . "/" . ZENFOLDER."/plugins/slideshow/flowplayerfullsizeicon.png' />");
	echo "</p>";
	break;
}
?>
</div>
</div>
<?php
}


/**
 * Prints the path to the slideshow JS and CSS (printed because some values need to be changed dynamically).
 * CSS can be adjusted
 * To be used on slideshow.php
 *
 */
function printSlideShowJS() {
?>
	<script src="<?php echo FULLWEBPATH . '/' . ZENFOLDER ?>/plugins/slideshow/jquery.cycle.all.pack.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo WEBPATH . "/" . ZENFOLDER; ?>/plugins/flowplayer/flashembed-0.34.pack.js"></script>
<?php
}

?>
