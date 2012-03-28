<?php
/**
 * flvplayer -- plugin support for the flvplayer flash video player. Support for version 3 and 4.
 * NOTE: Flash players do not support external albums!
 *
 * @author Malte Müller (acrylian), Stephen Billard (sbillard)
 * @version 1.0.3
 * @package plugins
 */

$plugin_description = ($external = (getOption('album_folder_class') === 'external'))? gettext('<strong>Flash players do not support <em>External Albums</em>!</strong>'): gettext("Enable <strong>FLV</strong> player to handle multimedia files. IMPORTANT: Only one multimedia player plugin can be enabled at the time.<br> <strong>NOTE: You need to buy a licence from the player's developer LongTail Video if you intend to use this plugin for commercial purposes.</strong> Please see <a href='http://www.longtailvideo.com/players/jw-flv-player/'>LongTail Video - JW players</a> for more info about the player and its licence.");
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard)";
$plugin_version = '1.0.3';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---flvplayer.php.html";
$plugin_disable = $external;
$option_interface = new flvplayer();
$_zp_flash_player = $option_interface; // claim to be the flash player.

if ($external) return; // can't process external album images

// register the scripts needed
addPluginScript('<script type="text/javascript" src="' . WEBPATH . '/' . ZENFOLDER . '/plugins/flvplayer/flvplayer.js"></script>');


define ('FLV_PLAYER_MP3_HEIGHT', 20);
/**
 * Plugin option handling class
 *
 */
class flvplayer {
	
	function flvplayer() {
		setOptionDefault('flv_player_width', '320');
		setOptionDefault('flv_player_height', '240');
		setOptionDefault('flv_player_backcolor', '0xFFFFFF');
		setOptionDefault('flv_player_frontcolor', '0x000000');
		setOptionDefault('flv_player_lightcolor', '0x000000');
		setOptionDefault('flv_player_screencolor', '0x000000');
		setOptionDefault('flv_player_displayheight', '240');
		setOptionDefault('flv_player_autostart', '');
		setOptionDefault('flv_player_buffer','0');
		setOptionDefault('flv_player_version','player3');
		setOptionDefault('flv_player_controlbar','over');
		//setOptionDefault('flv_player_ignoresize_for_mp3', 'true');
	}

	function getOptionsSupported() {
		return array(	gettext('flv player width') => array('key' => 'flv_player_width', 'type' => 0,
										'desc' => gettext("Player width (ignored for <em>mp3</em> files.)")),
		gettext('flv player height') => array('key' => 'flv_player_height', 'type' => 0,
										'desc' => gettext("Player height (ignored for .<em>mp3</em> files if there is no preview image available.)")),
		gettext('Backcolor') => array('key' => 'flv_player_backcolor', 'type' => 0,
										'desc' => gettext("Backgroundcolor of the controls, in HEX format. <em>Player version 3 only!</em>")),
		gettext('Frontcolor') => array('key' => 'flv_player_frontcolor', 'type' => 0,
										'desc' => gettext("Texts & buttons color of the controls, in HEX format. <em>Player version 3 only!</em>")),
		gettext('Lightcolor') => array('key' => 'flv_player_lightcolor', 'type' => 0,
										'desc' => gettext("Rollover color of the controls, in HEX format. <em>Player version 3 only!</em>")),
		gettext('Screencolor') => array('key' => 'flv_player_screencolor', 'type' => 0,
										'desc' => gettext("Color of the display area, in HEX format. <em>Player version 3 only!</em>")),
		gettext('Displayheight') => array('key' => 'flv_player_displayheight', 'type' => 0,
										'desc' => gettext("The height of the player display. Generally it should be the same as the height. (ignored for .<em>mp3</em> files if there is no preview image available.)")),
		gettext('Autostart') => array('key' => 'flv_player_autostart', 'type' => 1,
										'desc' => gettext("Should the video start automatically. Yes if selected.")),
		gettext('BufferSize') => array('key' => 'flv_player_buffer', 'type' => 0,
										'desc' => /*xgettext:no-php-format*/ gettext("Size of the buffer in % before the video starts.")),
		gettext('FLV Player version') => array('key' => 'flv_player_version', 'type' => 5,
										'selections' => array(gettext('Version 3')=>"player3", gettext('Version 4')=>"player4"),
										'desc' => gettext("The FLV Player version to be used. Note that due to API changes version 3 and 4 support not all the same options as noted.")),
		gettext('Controlbar position') => array('key' => 'flv_player_controlbar', 'type' => 5,
										'selections' => array(gettext('Bottom')=>"bottom", gettext('Over')=>"over", gettext('None')=>"none"),
										'desc' => gettext("The position of the controlbar. <em>Player version 4 only!</em>")),
		
		
		);
	}

	/**
	 * Prints the JS configuration of flv player
	 *
	 * @param string $moviepath the direct path of a movie (within the slideshow), if empty (within albums) the zenphoto function getUnprotectedImageURL() is used
	 * @param string $imagetitle the title of the movie to be passed to the player for display (within slideshow), if empty (within albums) the function getImageTitle() is used
	 * @param string $count unique text for when there are multiple player items on a page
	 */
	function getPlayerConfig($moviepath='',$imagetitle='',$count ='') {
		global $_zp_current_image, $_zp_current_album;
		if(empty($moviepath)) {
			$moviepath = getUnprotectedImageURL();
			$ext = strtolower(strrchr(getUnprotectedImageURL(), "."));
		} else {
			$ext = strtolower(strrchr($moviepath, "."));
		}
		if(empty($imagetitle)) {
			$imagetitle = getImageTitle();
		}
		if(!empty($count)) {
			$count = "-".$count;
		}
		$imgextensions = array(".jpg",".jpeg",".gif",".png");
		if(is_null($_zp_current_image)) {
			$albumfolder = $moviepath;
			$filename = $imagetitle;
			$videoThumb = '';
		} else {
			$album = $_zp_current_image->getAlbum();
			$albumfolder = $album->name;
			$filename = $_zp_current_image->filename;
			$videoThumb = checkObjectsThumb(getAlbumFolder().$albumfolder, $filename);
			if (!empty($videoThumb)) {
				$videoThumb = getAlbumFolder(WEBPATH).$albumfolder.'/'.$videoThumb;
			}
		}
		$output = '';
		$output .= '<p id="player'.$count.'"><a href="http://www.macromedia.com/go/getflashplayer">'.gettext("Get Flash").'</a> to see this player.</p>
			<script type="text/javascript">';
		if($ext === ".mp3" AND !isset($videoThumb)) {
			$output .= '	var so = new SWFObject("' . WEBPATH . '/' . ZENFOLDER . '/plugins/flvplayer/'.getOption("flv_player_version").'.swf","player'.$count.'","'.getOption('flv_player_width').'","'.FLV_PLAYER_MP3_HEIGHT.'","7");';
		} else {
			$output .= '	var so = new SWFObject("' . WEBPATH . '/' . ZENFOLDER . '/plugins/flvplayer/'.getOption("flv_player_version").'.swf","player'.$count.'","'.getOption('flv_player_width').'","'.getOption('flv_player_height').'","7");';
			$output .=  'so.addVariable("displayheight","'.getOption('flv_player_displayheight').'");';
		}
		$output .= 'so.addParam("allowfullscreen","true");
			so.addVariable("file","' . $moviepath . '&amp;title=' . strip_tags($imagetitle) . '");
			' . (!empty($videoThumb) ? 'so.addVariable("image","' . $videoThumb . '")' : '') . '
			so.addVariable("backcolor","'.getOption('flv_player_backcolor').'");
			so.addVariable("frontcolor","'.getOption('flv_player_frontkcolor').'");
			so.addVariable("lightcolor","'.getOption('flv_player_lightcolor').'");
			so.addVariable("screencolor","'.getOption('flv_player_screencolor').'");
			so.addVariable("autostart","' . (getOption('flv_player_autostart') ? 'true' : 'false') . '");
			so.addVariable("overstretch","true");
			so.addVariable("bufferlength","'.getOption('flv_player_buffer').'");
			so.addVariable("controlbar","'.getOption('flv_player_controlbar').'");
			so.write("player'.$count.'");
			</script>';
		return $output;
	}
	
	/**
	 * outputs the player configuration HTML
	 *
	 * @param string $moviepath the direct path of a movie (within the slideshow), if empty (within albums) the zenphoto function getUnprotectedImageURL() is used
	 * @param string $imagetitle the title of the movie to be passed to the player for display (within slideshow), if empty (within albums) the function getImageTitle() is used
	 * @param string $count unique text for when there are multiple player items on a page
	 */
	function printPlayerConfig($moviepath='',$imagetitle='',$count ='') {
		echo $this->getPlayerConfig($moviepath,$imagetitle,$count);
	}

	/**
	 * Returns the height of the player
	 * @param object $image the image for which the width is requested
	 *
	 * @return int
	 */
	function getVideoWidth($image=NULL) {
		return getOption('flv_player_width');
	}

	/**
	 * Returns the width of the player
	 * @param object $image the image for which the height is requested
	 *
	 * @return int
	 */
	function getVideoHeigth($image=NULL) {
		if (!is_null($image) && strtolower(strrchr($image->filename, ".") == '.mp3')) {
			return FLV_PLAYER_MP3_HEIGHT;
		}
		return getOption('flv_player_height');
	}
}
?>