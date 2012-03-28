<?php
/**
 * google_maps -- provides for placing google maps on image and album pages.
 * Updated to use the standard phoogle class
 *
 * Plugin Option 'gmaps_apikey' is used to supply the sit Google Maps API key.
 *
 * @author Dustin Brewer (mankind), Stephen Billard (sbillard), Eric Bayard (babar)
 * @version 1.3.0
 *
 * @package plugins
 */

$plugin_description = gettext("Support for providing Google Maps based on EXIF latitude and longitude in the images.");
$plugin_author = 'Dustin Brewer (mankind), Stephen Billard (sbillard), Eric Bayard (babar)';
$plugin_version = '1.3';
$plugin_URL = "";
$option_interface = new google_mapsOptions();

$mapkey = getOption('gmaps_apikey');
if (isset($_zp_gallery_page) && $_zp_gallery_page != 'index.php' && !empty($mapkey)) {
	// NOTE: This is copied from the printGoogleJS function in the phoogle class.
	//       If you update the phoogle class be sure this has not changed.
	addPluginScript('<script src="http://maps.google.com/maps?file=api&v=2&key='.$mapkey.'" type="text/javascript"></script>');
	addPluginScript('<script type="text/javascript" src="' . WEBPATH . '/' . ZENFOLDER . PLUGIN_FOLDER . 'google_maps/gmaps.js"></script>');
	addPluginScript('<script type="text/javascript">var map;</script>');
}


/**
 * Plugin option handling class
 *
 */
class google_mapsOptions {

	function google_mapsOptions() {
		/* put any setup code needed here */
		setOptionDefault('gmaps_apikey', '');
		setOptionDefault('gmaps_show_all_album_points', 0);
		setOptionDefault('gmaps_width', 595);
		setOptionDefault('gmaps_height', 300);
		setOptionDefault('gmaps_maptype_P', 0);
		setOptionDefault('gmaps_maptype_3D', 0);
		setOptionDefault('gmaps_maptype_map', 1);
		setOptionDefault('gmaps_maptype_hyb', 1);
		setOptionDefault('gmaps_maptype_sat', 1);
		setOptionDefault('gmaps_control_maptype', 1);
		setOptionDefault('gmaps_control', 'None');
		setOptionDefault('gmaps_background', '');
		setOptionDefault('gmaps_starting_map', 'G_SATELLITE_MAP');
	}

	function getOptionsSupported() {
		$MapTypes =  array(); // order matters here because the first allowed map is selected if the 'gmaps_starting_map' is not allowed
		if (getOption('gmaps_maptype_map')) $MapTypes[gettext('Map')] = 'G_NORMAL_MAP';
		if (getOption('gmaps_maptype_hyb')) $MapTypes[gettext('Hybrid')] = 'G_HYBRID_MAP';
		if (getOption('gmaps_maptype_sat')) $MapTypes[gettext('Satellite')] = 'G_SATELLITE_MAP';
		if (getOption('gmaps_maptype_P')) $MapTypes[gettext('Terrain')] = 'G_PHYSICAL_MAP';
		if (getOption('gmaps_maptype_3D')) $MapTypes[gettext('Google Earth')] = 'G_SATELLITE_3D_MAP';
		
		$defaultmap = getOption('gmaps_starting_map');
		if (array_search($defaultmap, $MapTypes) === false) { // the starting map is not allowed, pick a new one
			$temp = $MapTypes;
			$defaultmap = array_shift($temp);
			setOption('gmaps_starting_map', $defaultmap);
		}
				
		return array(	gettext('Google Maps API key') => array('key' => 'gmaps_apikey', 'type' => 0,
																	'desc' => gettext('If you are going to be using Google Maps, <a	href="http://www.google.com/apis/maps/signup.html" target="_blank">get an API key</a> and enter it here.')),
									gettext('All album points') => array ('key' => 'gmaps_show_all_album_points', 'type' => 1,
																	'desc' => gettext('Controls which image points are shown on an album page. Check to show points for all images in the album. If not checked points are shown only for those images whose thumbs are on the page.')),
									gettext('Map dimensions—width') => array('key' => 'gmaps_width', 'type' => 0,
																	'desc' => gettext('The default width of the map.')),
									gettext('Map dimensions—height') => array('key' => 'gmaps_height', 'type' => 0,
																	'desc' => gettext('The default height of the map.')),
									gettext('Allowed maps') => array('key' => 'gmaps_allowed_maps', 'type' => 6,
																	'checkboxes' => array(gettext('Map') => 'gmaps_maptype_map', gettext('Satellite') => 'gmaps_maptype_sat' ,gettext('Hybrid') => 'gmaps_maptype_hyb' ,gettext('Terrain') => 'gmaps_maptype_P', gettext('Google Earth') => 'gmaps_maptype_3D'),
																	'desc' => gettext('Select the map types that are allowed.')),
/* Not yet implemented
									gettext('Add Wikipedia') => array('key' => 'gmaps_wiki_layer', 'type' => 1,
																	'desc' => gettext('Adds wikipedia georeferenced data on your maps.')),
*/
									gettext('Map type selector') => array('key' => 'gmaps_control_maptype', 'type' => 4,'buttons' => array(gettext('Buttons') => 1,gettext('List') => 2),
																	'desc' => gettext('Use buttons or list for the map type selector.')),
									gettext('Map controls') => array('key' => 'gmaps_control', 'type' => 4,'buttons' => array(gettext('None') => 'None',gettext('Small') => 'Small',gettext('Large') => 'Large'),
																	'desc' => gettext('Select the kind of map controls.')),
									gettext('Map background') => array('key' => 'gmaps_background', 'type' => 0,
																	'desc' => gettext('Set the map background color to match the one of your theme. (Use the same <em>color</em> values as in your CSS background statements.)')),
									gettext('Initial map display selection') => array('key' => 'gmaps_starting_map', 'type' => 5, 'selections' => $MapTypes,
																	'desc' => gettext('Select the initial type of map to display. <br /><strong>Note:</strong> If <code>Google Earth</code> is selected the <em>toggle</em> function which initially hides the map is ignored. The browser <em>Google Earth Plugin</em> does not initialize properly when the map is hidden.'))
									);
	}

	function handleOption($option, $currentValue) {}
}

if($apiKey = getOption('gmaps_apikey')){
	require_once(SERVERPATH.'/'.ZENFOLDER.'/plugins/'.substr(basename(__FILE__), 0, -4).'/phoogle.php');
	$_zp_phoogle = new PhoogleMap();
	$_zp_phoogle->setAPIkey($apiKey);
} else {
	$_zp_phoogle = NULL;
}

/**
 * Returns true if the current image has EXIF location data
 *
 * @return bool
 */
function hasMapData() {
	if(getOption('gmaps_apikey') != ''){
		$exif = getImageEXIFData();
		if(!empty($exif['EXIFGPSLatitude']) && !empty($exif['EXIFGPSLongitude'])){
			return true;
		}
	}
	return false;
}

/**
 * Adds a geoPoint after first insuring it uses periods for the decimal separator
 *
 * @param string $lat Latitude of the point
 * @param string $long Longitude of the point
 */
function addPoint($lat, $long, $html) {
	global $_zp_phoogle;
	$_zp_phoogle->addGeoPoint(str_replace(',', '.', $lat), str_replace(',', '.', $long), $html);
}

function setupAllowedMaps($defaultmap, $allowedmaps) {
	global $_zp_phoogle;
	if (is_null($allowedmaps)) {
		$allowedmaps = array();
		if (getOption('gmaps_maptype_map')) $allowedmaps[gettext('Map')] = 'G_NORMAL_MAP';
		if (getOption('gmaps_maptype_hyb')) $allowedmaps[gettext('Hybrid')] = 'G_HYBRID_MAP';
		if (getOption('gmaps_maptype_sat')) $allowedmaps[gettext('Satellite')] = 'G_SATELLITE_MAP';
		if (getOption('gmaps_maptype_P')) $allowedmaps[gettext('Terrain')] = 'G_PHYSICAL_MAP';
		if (getOption('gmaps_maptype_3D')) $allowedmaps[gettext('Google Earth')] = 'G_SATELLITE_3D_MAP';
	}
	if (is_null($defaultmap))	$defaultmap = getOption('gmaps_starting_map');
	if (array_search($defaultmap, $allowedmaps) === false) { // the starting map is not allowed, pick a new one
		$temp = $allowedmaps;
		$defaultmap = array_shift($temp);
	}
	$_zp_phoogle->setMapType($defaultmap);
	$_zp_phoogle->clearMaps();
	foreach ($allowedmaps as $map) {
		$_zp_phoogle->addMap($map);
	}
	$_zp_phoogle->setMapType($defaultmap);
	return $defaultmap;
}
/**
 * Causes a Google map to be printed based on the gps data in the current image
 * @param string $zoomlevel the zoom in for the map
 * @param string $defaultmaptype the starting display of the map valid values are G_NORMAL_MAP | G_SATELLITE_MAP | G_HYBRID_MAP | G_PHYSICAL_MAP | G_SATELLITE_3D_MAP
 * @param int $width is the image width of the map. NULL will use the default
 * @param int $height is the image height of the map. NULL will use the default
 * @param string $text text for the pop-up link
 * @param bool $toggle set to true to hide initially
 * @param string $id DIV id
 * @param array $mapselections array of the maps to be used.
 * @param bool $addphysical Adds physical map.
 * @param bool $addwiki Adds wikipedia georeferenced data on your maps
 * @param string $background the background color for the map
 * @param string $mapcontrol values None | Small | Large
 * @param string $maptypecontrol values Buttons | List
 * @param string $customJS the extra javascript needed by the theme
 */
function printImageMap($zoomlevel=NULL, $defaultmaptype=NULL, $width=NULL, $height=NULL, $text=NULL, $toggle=true, $id='googlemap', $mapselections=NULL, $addwiki=NULL, $background=NULL, $mapcontrol=NULL, $maptypecontrol=NULL, $customJS=NULL) {
	global $_zp_phoogle;
	if(getOption('gmaps_apikey') != ''){

		$exif = getImageEXIFData();
		if(!empty($exif['EXIFGPSLatitude']) && !empty($exif['EXIFGPSLongitude'])){

			$defaultmaptype = setupAllowedMaps($defaultmaptype, $mapselections);
			
			if($zoomlevel){
				$_zp_phoogle->zoomLevel = $zoomlevel;
			}
			if (!is_null($width)) {
				$_zp_phoogle->setWidth($width);
			} else {
				$_zp_phoogle->setWidth(getOption('gmaps_width'));
			}
			if (!is_null($height)) {
				$_zp_phoogle->setHeight($height);
			} else {
				$_zp_phoogle->setHeight(getOption('gmaps_height'));
			}
			if (!is_null($mapcontrol)) {
				$_zp_phoogle->setControlMap($mapcontrol);
			} else {
				$_zp_phoogle->setControlMap(getOption('gmaps_control'));
			}
			if (!is_null($maptypecontrol)) {
				$_zp_phoogle->setControlMapType($maptypecontrol);
			} else {
				$_zp_phoogle->setControlMapType(getOption('gmaps_control_maptype'));
			}
			if (!is_null($background)) {
				$_zp_phoogle->setBackGround($background);
			} else {
				$_zp_phoogle->setBackGround(getOption('gmaps_background'));
			}
			if (!is_null($customJS)) {
				$_zp_phoogle->customJS=$customJS;
			}
			$lat = $exif['EXIFGPSLatitude'];
			$long = $exif['EXIFGPSLongitude'];
			if($exif['EXIFGPSLatitudeRef'] == 'S'){  $lat = '-' . $lat; }
			if($exif['EXIFGPSLongitudeRef'] == 'W'){  $long = '-' . $long; }
			$desc = getImageDesc();
			if (empty($desc)) $desc = getImageTitle();
			addPoint($lat, $long, js_encode($desc));
			$dataid = $id.'_data';
			//to avoid problems with google earth and the toggle options, the toggle option is removed from here when GE is activated
			//it is possible to have both functionnality work but the toogle option should then be integrated in the phoogle map class dirctly within the script
			//that calls the map and should alos trigger a map type change. check Sobre theme or  have alook at www.kaugite.com for an example
			$toggle = $toggle && $defaultmaptype != 'G_SATELLITE_3D_MAP';
			if (is_null($text)) $text = gettext('Google Map');
			echo "<a href=\"javascript: vtoggle('$dataid');\" title=\"".gettext('Display or hide the Google Map.')."\">";
			echo $text;
			echo "</a>\n";
			echo "  <div id=\"$dataid\"" . ($toggle ? " style=\"color:black; visibility: hidden;position:absolute;left: -3000px;top: -3000px\"" : '') . ">\n";
			$_zp_phoogle->showMap();
			echo "  </div>\n";
		}
	}
}

/**
 * Causes a Google map to be printed based on the gps data in all the images in the album
 * @param  string $zoomlevel the zoom in for the map. NULL will use the default
 * @param string $defaultmaptype the starting display of the map valid values are G_NORMAL_MAP | G_SATELLITE_MAP | G_HYBRID_MAP | G_PHYSICAL_MAP | G_SATELLITE_3D_MAP
 * @param int $width is the image width of the map. NULL will use the default
 * @param int $height is the image height of the map. NULL will use the default
 * @param string $text text for the pop-up link
 * @param bool $toggle set to true to hide initially
 * @param string $id DIV id
 * @param int $firstPageImages the number of images on transition pages.
 * @param array $mapselections array of the maps to be used.
 * @param bool $addphysical Adds physical map.
 * @param bool $addwiki Adds wikipedia georeferenced data on your maps
 * @param string $background the background color for the map
 * @param string $mapcontrol values None | Small | Large
 * @param string $maptypecontrol values Buttons | List
 * @param string $customJS the extra javascript needed by the theme
 */
function printAlbumMap($zoomlevel=NULL, $defaultmaptype=NULL, $width=NULL, $height=NULL, $text='', $toggle=true, $id='googlemap', $firstPageImages=0, $mapselections=NULL, $addwiki=NULL, $background=NULL, $mapcontrol=NULL, $maptypecontrol=NULL, $customJS=NULL){
	global $_zp_phoogle, $_zp_images, $_zp_current_album, $_zp_current_image;
	if(getOption('gmaps_apikey') != ''){
		$foundLocation = false;
		$defaultmaptype = setupAllowedMaps($defaultmaptype, $mapselections);		
		if($zoomlevel){
			$_zp_phoogle->zoomLevel = $zoomlevel;
		}
		if (!is_null($width)) {
			$_zp_phoogle->setWidth($width);
		} else {
			$_zp_phoogle->setWidth(getOption('gmaps_width'));
		}
		if (!is_null($height)) {
			$_zp_phoogle->setHeight($height);
		} else {
			$_zp_phoogle->setHeight(getOption('gmaps_height'));
		}
		if (!is_null($mapcontrol)) {
			$_zp_phoogle->setControlMap($mapcontrol);
		} else {
			$_zp_phoogle->setControlMap(getOption('gmaps_control'));
		}
		if (!is_null($maptypecontrol)) {
			$_zp_phoogle->setControlMapType($maptypecontrol);
		} else {
			$_zp_phoogle->setControlMapType(getOption('gmaps_control_maptype'));
		}
		if (!is_null($background)) {
			$_zp_phoogle->setBackGround($background);
		} else {
			$_zp_phoogle->setBackGround(getOption('gmaps_background'));
		}
		if (!is_null($customJS)) {
			$_zp_phoogle->customJS=$customJS;
		}
		resetCurrentAlbum(); // start from scratch
		while (next_image(getOption('gmaps_show_all_album_points'), $firstPageImages)) {
			$exif = getImageEXIFData();
			if(!empty($exif['EXIFGPSLatitude']) && !empty($exif['EXIFGPSLongitude'])){
				$foundLocation = true;
				$lat = $exif['EXIFGPSLatitude'];
				$long = $exif['EXIFGPSLongitude'];
				if($exif['EXIFGPSLatitudeRef'] == 'S'){  $lat = '-' . $lat; }
				if($exif['EXIFGPSLongitudeRef'] == 'W'){  $long = '-' . $long; }
				$infoHTML = '<a href="' . pathurlencode(getImageLinkURL()) . '"><img src="' .
				pathurlencode(getImageThumb()) . '" alt="' . getImageDesc() . '" ' .
					'style=" margin-left: 30%; margin-right: 10%; border: 0px; "/></a>' .
					'<p>' . getImageDesc() . '</p>';
				addPoint($lat, $long, js_encode($infoHTML));
			}
		}
		resetCurrentAlbum(); // clear out any 'damage'

		if($foundLocation){
			$dataid = $id.'_data';
			//to avoid problems with google earth and the toggle options, the toggle option is removed from here when GE is activated
			//it is possible to have both functionnality work but the toogle option should then be integrated in the phoogle map class dirctly within the script
			//that calls the map and should alos trigger a map type change. check Sobre theme or  have alook at www.kaugite.com for an example
			$toggle = $toggle && $defaultmaptype != 'G_SATELLITE_3D_MAP';

			if (is_null($text)) $text = gettext('Google Map');
			echo "<a href=\"javascript: vtoggle('$dataid');\" title=\"".gettext('Display or hide the Google Map.')."\">";
			echo $text;
			echo "</a>\n";
			echo "  <div id=\"$dataid\"" . ($toggle ? " style=\"color:black; visibility: hidden;position:absolute;left: -3000px;top: -3000px\"" : '') . ">\n";
			$_zp_phoogle->showMap(is_null($zoomlevel));
			echo "  </div>\n";
		}
	}
}

?>