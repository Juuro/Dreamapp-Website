<?php

/**
 * Phoogle Maps 2.0 | Uses Google Maps API to create customizable maps
 * that can be embedded on your website
 *    Copyright (C) 2005  Justin Johnson
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 *
 * Phoogle Maps 2.0
 * Uses Google Maps Mapping API to create customizable
 * Google Maps that can be embedded on your website
 *
 * @class        Phoogle Maps 2.0
 * @author       Justin Johnson <justinjohnson@system7designs.com>
 * @copyright    2005 system7designs
 * @package plugins 
 *
 *@Modified in 2008 by Eric Bayard to include in Zenphoto
 *
 */




class PhoogleMap{
	/**
	 * validPoints : array
	 * Holds addresses and HTML Messages for points that are valid (ie: have longitude and latitutde)
	 */
	var $validPoints = array();
	/**
	 * invalidPoints : array
	 * Holds addresses and HTML Messages for points that are invalid (ie: don't have longitude and latitutde)
	 */
	var $invalidPoints = array();
	/**
	 * mapWidth
	 * width of the Google Map, in pixels
	 */
	var $mapWidth = 300;
	/**
	 * mapHeight
	 * height of the Google Map, in pixels
	 */
	var $mapHeight = 300;
	/**
	 * apiKey
	 * Google API Key
	 */
	var $apiKey = "";
	/**
	 * controlType
	 * display's either the large or the small controls on the map, or custom
	 */
	var $controlType = '';
	/**
	 * mapTypeControl
	 * Which type of map type control to display buttons, list or custom
	 */
	var $mapTypeControl = '';
	/**
	 * zoomLevel
	 * int: 0-17
	 * set's the initial zoom level of the map
	 */
	var $zoomLevel = 4;
	var $mapselections = ''; // list of the addmap calls
	/**
	 * backGround
	 * background color of the map
	 */
	var $backGround = '#E5E3DF';
	/**
	 * defaultMap
	 * The default displayed map
	 */
	var $defaultMap = 'G_NORMAL_MAP';
	/**
	 * customJS
	 * add custom javascript
	 */
	var $customJS = '';

	/**
	 * Add's an address to be displayed on the Google Map using latitude/longitude
	 *
	 * @param string $lat latitude
	 * @param string $long longitude
	 * @param string $infoHTML HTML to show with the point
	 */
	function addGeoPoint($lat,$long,$infoHTML){
		$pointer = count($this->validPoints);
		$this->validPoints[$pointer]['lat'] = $lat;
		$this->validPoints[$pointer]['long'] = $long;
		$this->validPoints[$pointer]['htmlMessage'] = $infoHTML;
	}

	/**
	 * Add's an address to be displayed on the Google Map
	 * (thus eliminating the need for two different show methods from version 1.0)
	 *
	 * @param string $address
	 * @param string $htmlMessage
	 */
	function addAddress($address,$htmlMessage=null){
		if (!is_string($address)){
			die("All Addresses must be passed as a string");
		}
		$apiURL = "http://maps.google.com/maps/geo?&output=xml&key=".$this->apiKey."&q=";
		$addressData = file_get_contents($apiURL.urlencode($address));

		$results = $this->xml2array(utf8_encode($addressData));
		if (empty($results['kml'][Response]['Placemark']['Point']['coordinates'])){
			$pointer = count($this->invalidPoints);
			$this->invalidPoints[$pointer]['lat']= $results['kml'][Response]['Placemark']['Point']['coordinates'][0];
			$this->invalidPoints[$pointer]['long']= $results['kml'][Response]['Placemark']['Point']['coordinates'][1];
			$this->invalidPoints[$pointer]['passedAddress'] = $address;
			$this->invalidPoints[$pointer]['htmlMessage'] = $htmlMessage;
		}else{
			$pointer = count($this->validPoints);
			$this->validPoints[$pointer]['lat']= $results['kml'][Response]['Placemark']['Point']['coordinates'];
			$this->validPoints[$pointer]['long']= $results['kml'][Response]['Placemark']['Point']['coordinates'];
			$this->validPoints[$pointer]['passedAddress'] = $address;
			$this->validPoints[$pointer]['htmlMessage'] = $htmlMessage;
		}
	}

	/**
	 * Displays either a table or a list of the address points that are valid.
	 * Mainly used for debugging but could be useful for showing a list of addresses
	 * on the map
	 *
	 * @param string $displayType
	 * @param string $css_id
	 */
	function showValidPoints($displayType,$css_id){
		$total = count($this->validPoints);
		if ($displayType == "table"){
			echo "<table id=\"".$css_id."\">\n<tr>\n\t<td>Address</td>\n</tr>\n";
			for ($t=0; $t<$total; $t++){
				echo"<tr>\n\t<td>".$this->validPoints[$t]['passedAddress']."</td>\n</tr>\n";
			}
			echo "</table>\n";
		}
		if ($displayType == "list"){
			echo "<ul id=\"".$css_id."\">\n";
			for ($lst=0; $lst<$total; $lst++){
				echo "<li>".$this->validPoints[$lst]['passedAddress']."</li>\n";
			}
			echo "</ul>\n";
		}
	}
	/**
	 * Displays either a table or a list of the address points that are invalid.
	 * Mainly used for debugging shows only the points that are NOT on the map
	 *
	 * @param string $displayType
	 * @param string $css_id
	 */
	function showInvalidPoints($displayType,$css_id){
		$total = count($this->invalidPoints);
		if ($displayType == "table"){
			echo "<table id=\"".$css_id."\">\n<tr>\n\t<td>Address</td>\n</tr>\n";
			for ($t=0; $t<$total; $t++){
				echo"<tr>\n\t<td>".$this->invalidPoints[$t]['passedAddress']."</td>\n</tr>\n";
			}
			echo "</table>\n";
		}
		if ($displayType == "list"){
			echo "<ul id=\"".$css_id."\">\n";
			for ($lst=0; $lst<$total; $lst++){
				echo "<li>".$this->invalidPoints[$lst]['passedAddress']."</li>\n";
			}
			echo "</ul>\n";
		}
	}
	/**
	 * Sets the width of the map to be displayed
	 *
	 * @param int $width
	 */
	function setWidth($width){
		$this->mapWidth = $width;
	}
	/**
	 * Sets the height of the map to be displayed
	 *
	 * @param int $height
	 */
	function setHeight($height){
		$this->mapHeight = $height;
	}
	/**
	 * Stores the API Key acquired from Google
	 *
	 * @param string $key
	 */
	function setAPIkey($key){
		$this->apiKey = $key;
	}
	/**
	 * Set the type of controls needed to change map type
	 *
	 * @param string $controlmaptype the control type
	 */
	function setControlMapType($controlmaptype){
		if(!empty($controlmaptype)){
			switch ($controlmaptype) {
				case 1:
					$this->mapTypeControl = 'map.addControl(new GMapTypeControl());';
					break;
				case 2:
					$this->mapTypeControl = 'var mapControl = new GMenuMapTypeControl(true); map.addControl(mapControl);';
					break;
				default:
					$this->mapTypeControl = $controlmaptype;
			}
		}
	}
	/**
	 * Set the type of controls needed to move,zoom,pan map
	 *
	 * @param string $controltype the
	 */
	function setControlMap($controlmap){
		if(!empty($controlmap)){
			switch($controlmap) {
				case 'None':
					$this->controlType = '';
					break;
				case 'Small':
					$this->controlType = 'map.addControl(new GSmallMapControl());';
					break;
				case 'Large':
					$this->controlType = 'map.addControl(new GLargeMapControl());';
					break;
				default:
					$this->controlType = $controlmap;
			}
		}
	}
	/**
	 * Sets the map selections to empty.
	 *
	 */
	function clearMaps() {
		$this->mapselections = '';
	}
	/**
	 * adds a map type to the list of selectable maps
	 *
	 * @param string $newMapType
	 */
	function addMap($newMapType){
		$this->mapselections .= 'map.addMapType('.strtoupper($newMapType).'); ';
	}
	/**
	 * sets the starting map type
	 *
	 * @param string $MapType
	 */
	function setMapType($MapType){
		$this->defaultMap = 'map.setMapType('.strtoupper($MapType).');';
	}
	/**
	 * Set the Map tiles background when loading the map
	 *
	 * @param string $backgroundcolor
	 */
	function setBackGround($backgroundcolor){
		if(!empty($backgroundcolor) && preg_match('#^\#[0-9a-f]{6}$#i', $backgroundcolor)){
			$this->backGround=$backgroundcolor;
		}
	}
	/**
	 * The necessary Javascript for the Google Map to function
	 * should be echoed in between the html <head></head> tags
	 *
	 * @return string
	 */
	function printGoogleJS(){
		return "\n<script src=\"http://maps.google.com/maps?file=api&v=2&key=".$this->apiKey."\" type=\"text/javascript\"></script>\n";
	}
	/**
	 * Displays the Google Map on the page
	 *
	 */
	function showMap($autozoom=false){
		echo "\n<div id=\"map\" style=\"width: ".$this->mapWidth."px; height: ".$this->mapHeight."px\">\n</div>\n";
		echo "    <script type=\"text/javascript\">\n
	
	function showmap(){
   	if (GBrowserIsCompatible()) {\n
     	map = new GMap(document.getElementById(\"map\"), {backgroundColor:'".$this->backGround."'});\n";
		echo "map.centerAndZoom(new GPoint(".$this->validPoints[0]['long'].",".$this->validPoints[0]['lat']."), ".$this->zoomLevel.");\n";
		echo "map.enableScrollWheelZoom();\n";
		echo $this->mapselections."\n";
		echo $this->mapTypeControl."\n";
		echo $this->controlType."\n";
		echo $this->defaultMap."\n";
		echo "var points = [];\n";
		
		$numPoints = count($this->validPoints);
		for ($g = 0; $g<$numPoints; $g++){
			echo "points[".$g."] = new GPoint(".$this->validPoints[$g]['long'].",".$this->validPoints[$g]['lat'].");\n";
			echo "var marker".$g." = new GMarker(points[".$g."]);\n";
			echo "map.addOverlay(marker".$g.");\n";
			echo "GEvent.addListener(marker".$g.", \"click\", function() {\n";
			if (isset($this->validPoints[$g]['htmlMessage'])) {
				echo "marker".$g.".openInfoWindowHtml(\"".$this->validPoints[$g]['htmlMessage']."\");\n";
			}else{
				if (isset($this->validPoints[$g]['passedAddress'])) {
					$addr = $this->validPoints[$g]['passedAddress'];
				} else {
					$addr = '';
				}
				echo "marker".$g.".openInfoWindowHtml(\"".$addr."\");\n";
			}
			echo "});\n";
		}
		if ($autozoom) {
			echo 'resizeMap( map, points );';
		}
		echo $this->customJS."\n";
		echo"} else {
		var text = document.createTextNode(\"".gettext('Your browser is not compatible with Google maps')."\");
		document.getElementById(\"map\").appendChild(text);
		}\n
	}\n";
		echo "window.onload = showmap;
		
    	</script>\n";
	}
	///////////THIS BLOCK OF CODE IS FROM Roger Veciana's CLASS (assoc_array2xml) OBTAINED FROM PHPCLASSES.ORG//////////////
	function xml2array($xml){
		$this->depth=-1;
		$this->xml_parser = xml_parser_create();
		xml_set_object($this->xml_parser, $this);
		xml_parser_set_option ($this->xml_parser,XML_OPTION_CASE_FOLDING,0);//Don't put tags uppercase
		xml_set_element_handler($this->xml_parser, "startElement", "endElement");
		xml_set_character_data_handler($this->xml_parser,"characterData");
		xml_parse($this->xml_parser,$xml,true);
		xml_parser_free($this->xml_parser);
		return $this->arrays[0];
	}
	function startElement($parser, $name, $attrs){
		$this->keys[]=$name;
		$this->node_flag=1;
		$this->depth++;
	}
	function characterData($parser,$data){
		$key=end($this->keys);
		$this->arrays[$this->depth][$key]=$data;
		$this->node_flag=0;
	}
	function endElement($parser, $name){
		$key=array_pop($this->keys);
		if($this->node_flag==1){
			$this->arrays[$this->depth][$key]=$this->arrays[$this->depth+1];
			unset($this->arrays[$this->depth+1]);
		}
		$this->node_flag=1;
		$this->depth--;
	}
	//////////////////END CODE FROM Roger Veciana's CLASS (assoc_array2xml) /////////////////////////////////


}//End Of Class


?>
