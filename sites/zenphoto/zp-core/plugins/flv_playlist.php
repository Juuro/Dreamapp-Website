<?php
/**
 * flvplayer playlist - A plugin to show the content of an media album with .flv/.mp4/.mp3 movie/audio files 

 * only as a playlist or as separate players with flv player (some options are also shared with that plugin)
 * NOTE: The flv player plugin needs to be installed (This plugin currently only uses FLV player 3!)
 * 
 * The playlist is meant to replace the 'next_image()' loop on a theme's album.php.
 * It can be used with a special 'album theme' that can be assigned to media albums with with .flv/.mp4/.mp3s 

 * movie/audio files only. See the examples below 
 * You can either show a 'one player window' playlist or show all items as separate players paginated 

 * (set in the settings for thumbs per page) on one page (like on a audio or podcast blog).
 *
 * If there is no preview image for a mp3 file existing only the player control bar is shown.
 * 
 * The two modes:
 * a) 'playlist' option
 * Replace the entire 'next_image()' loop on album.php with this:
 * <?php flvPlaylist("playlist"); ?>
 * 
 * b) 'players' option
 * Modify the 'next_image()' loop on album.php like this:
 * <?php	
 * while (next_image(false,$firstPageImages)):
 * printImageTitle();
 * flvPlaylist("players");
 * endwhile;
 * ?>
 * Of course you can add further functions to b) like title, description, date etc., too.
 *  
 * @author Malte Müller (acrylian), Stephen Billard (sbillard)
 * @version 1.0.5
 * @package plugins 
 */

$plugin_description = gettext("A plugin to show the content of an media album with .flv/.mp4/.mp3 movie/audio files only as a playlist or as separate players with flv player (some options are also shared with that plugin).<strong>Note:</strong>Currently supports only FLV player version 3.").
	' <strong>'.gettext("Requires flvplayer plugin. Also note the usage licence of FLV player on its plugin description").'</strong>';
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard)";
$plugin_version = '1.0.5';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---flv_playlist.php.html";
$option_interface = new flvplaylist();

/**
 * Plugin option handling class
 *
 */
class flvplaylist {

	function flvplaylist() {
		setOptionDefault('flvplaylist_width', '600');
		setOptionDefault('flvplaylist_height', '240');
		setOptionDefault('flvplaylist_displaywidth', '320');
		setOptionDefault('flvplaylist_displayheight', '240');
		setOptionDefault('flvplaylist_thumbsinplaylist', '');
	}

	function getOptionsSupported() {
		return array(	gettext('Width') => array('key' => 'flvplaylist_width', 'type' => 0,
										'desc' => gettext("Player width for the playlist")),
		gettext('Height') => array('key' => 'flvplaylist_height', 'type' => 0,
										'desc' => gettext("Player height for the playlist (ignored for .<em>mp3</em> files if there is no preview image available.)")),
		gettext('Displaywidth') => array('key' => 'flvplaylist_displaywidth', 'type' => 0,
										'desc' => gettext("Display width for the playlist. The display width is needed for the playlist menu to be shown. In this case the 'displaywidth - width = width of the playlist menu'. See the flv player site for more info about these options.")),
		gettext('Displayheight') => array('key' => 'flvplaylist_displayheight', 'type' => 0,
										'desc' => gettext("Display height for the playlist. If the width is too small to show the playlist menu, you can set the height higher to show it below the actual movie display. See the flv player site for more info about these options.")),
		gettext('Thumbs in playlist') => array('key' => 'flvplaylist_thumbsinplaylist', 'type' => 1,
										'desc' => gettext("Check if you want that thumbnails of the preview images should be shown in the playlist."))
		);
	}
}
	
function flvPlaylist($option='') {
	global $_zp_current_album, $_zp_current_image;
	if(checkAlbumPassword($_zp_current_album->getFolder(), $hint)) {
		if($option === "players") {
			$moviepath = getUnprotectedImageURL();
			$ext = strtolower(strrchr(getUnprotectedImageURL(), "."));
		}
		$imagetitle = getImageTitle();
	}
	$albumid = getAlbumID();

	switch($option) {
		case "playlist":
			?>
	<div id="flvplaylist"><?php echo gettext("The flv player is not installed. Please install or activate the flv player plugin."); ?></div>
	<script type="text/javascript">
		var so = new SWFObject('<?php echo WEBPATH."/".ZENFOLDER; ?>/plugins/flvplayer/player3.swf','jstest','<?php echo getOption('flvplaylist_width'); ?>','<?php echo getOption('flvplaylist_height'); ?>','8');
		so.addParam('allowfullscreen','true');
		so.addParam('overstretch','true');
		so.addVariable('displaywidth', '<?php echo getOption('flvplaylist_displaywidth'); ?>');
		so.addVariable('displayheight','<?php echo getOption('flvplaylist_displayheight'); ?>');
		so.addVariable('backcolor','<?php echo getOption('flv_player_backcolor'); ?>');
		so.addVariable('frontcolor','<?php echo getOption('flv_player_frontcolor'); ?>');
		so.addVariable('lightcolor','<?php echo getOption('flv_player_lightcolor'); ?>');
		so.addVariable('screencolor','<?php echo getOption('flv_player_screencolor'); ?>');
		so.addVariable('file','<?php echo WEBPATH."/".ZENFOLDER; ?>/plugins/flv_playlist/playlist.php?albumid=<?php echo $albumid; ?>');
		so.addVariable('javascriptid','jstest');
		so.addVariable('enablejs','true');
		so.addVariable('thumbsinplaylist','<?php echo (getOption('flvplaylist_thumbsinplaylist') ? 'true' : 'false') ?>');
		so.write('flvplaylist');
	</script>
	<?php
		break;

		case "players":
			if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4")) {
				echo "<div id=\"flvplaylist-".$imagetitle."\">".gettext("The flv player is not installed. Please install or activate the flv player plugin..")."</div>";
					
				// check if an image/videothumb is available - this shouldn't be hardcoded...
				$album = $_zp_current_image->getAlbum();
				$videoThumb = checkObjectsThumb($album->localpath, $_zp_current_image->filename);
				if (!empty($videoThumb)) {
					$videoThumb = getAlbumFolder(WEBPATH).$album->name.'/'.$videoThumb;
				}										
		?>
		<script type="text/javascript">
		 <?php 

		 if(($ext == ".mp3") && empty($videoThumb)) { 
		 ?> 
			var so = new SWFObject('<?php echo WEBPATH."/".ZENFOLDER; ?>/plugins/flvplayer/player3.swf','jstest','<?php echo getOption('flvplaylist_width'); ?>','20','8');
		<?php } else { ?>
			var so = new SWFObject('<?php echo WEBPATH."/".ZENFOLDER; ?>/plugins/flvplayer/player3.swf','jstest','<?php echo getOption('flvplaylist_width'); ?>','<?php echo getOption('flvplaylist_height'); ?>','8');
		<?php } ?>
			so.addParam('allowfullscreen','true');
			so.addParam('overstretch','true');
			so.addVariable("image",'<?php echo $videoThumb; ?>');
			so.addVariable('backcolor','<?php echo getOption('flv_player_backcolor'); ?>');
			so.addVariable('frontcolor','<?php echo getOption('flv_player_frontcolor'); ?>');
			so.addVariable('lightcolor','<?php echo getOption('flv_player_lightcolor'); ?>');
			so.addVariable('screencolor','<?php echo getOption('flv_player_screencolor'); ?>');
			so.addVariable('file','<?php echo $moviepath; ?>');
			so.addVariable('javascriptid','jstest');
			so.addVariable('enablejs','true');
			so.write('flvplaylist-<?php echo escape($imagetitle); ?>');
	<?php	} ?>
		</script>
	<?php
	break;
	}
} // password check end

