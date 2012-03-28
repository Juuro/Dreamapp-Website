<?php
/**
 *Video Class
 * @package classes
 */

// force UTF-8 Ø

$plugin_description = ($disable = (ZENPHOTO_RELEASE < 3112))? gettext('class-image is not compatible with this zenphoto release.') : gettext('Video and MP3/4 handling for Zenphoto.');
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0.0';
$plugin_disable = $disable;

if ($plugin_disable) return;
addPluginType('flv', 'Video');
addPluginType('3gp', 'Video');
addPluginType('mov', 'Video');
addPluginType('mp3', 'Video');
addPluginType('mp4', 'Video');

define('DEFAULT_MOV_HEIGHT', 496);
define('DEFAULT_MOV_WIDTH', 640);
define('DEFAULT_3GP_HEIGHT', 304);
define('DEFAULT_3GP_WIDTH', 352);

class Video extends _Image {

	/**
	 * Constructor for class-video
	 *
	 * @param object &$album the owning album
	 * @param sting $filename the filename of the image
	 * @return Image
	 */
	function Video(&$album, $filename) {
		// $album is an Album object; it should already be created.
		if (!is_object($album)) return NULL;
		$this->classSetup($album, $filename);
		$this->video = true;
		$this->objectsThumb = checkObjectsThumb($album->localpath, $filename);
		// Check if the file exists.
		if (!file_exists($this->localpath) || is_dir($this->localpath)) {
			$this->exists = false;
			return NULL;
		}


		// This is where the magic happens...
		$album_name = $album->name;
		$this->updateDimensions();  // TODO: figure out how to know if this should change. I.e. old videos, changes of the flash player.
		if ( parent::PersistentObject('images', array('filename'=>$filename, 'albumid'=>$this->album->id), 'filename', false, empty($album_name))) {
			$newDate = strftime('%Y/%m/%d %T', filemtime($this->localpath));
			$this->set('date', $newDate);
			$alb = $this->album;
			if (!is_null($alb)) {
				if (is_null($alb->getDateTime()) || getOption('album_use_new_image_date')) {
					$this->album->setDateTime($newDate);   //  not necessarily the right one, but will do. Can be changed in Admin
					$this->album->save();
				}
			}

			$title = $this->getDefaultTitle();
			$this->set('title', sanitize($title, 2));
			$this->set('mtime', filemtime($this->localpath));
			apply_filter('new_image', $this);
			$this->save();
		}
	}

	/**
	 * Update this object's values for width and height.
	 *
	 */
	function updateDimensions() {
		global $_zp_flash_player;
		$ext = strtolower(strrchr($this->filename, "."));
		if (is_null($_zp_flash_player) || $ext == '.3gp' || $ext == '.mov') {
			switch ($ext) {
				case '.3gp':
					$h = DEFAULT_3GP_HEIGHT;
					$w = DEFAULT_3GP_WIDTH;
					break;
				case '.mov':
					$h = DEFAULT_MOV_HEIGHT;
					$w = DEFAULT_MOV_WIDTH;
					break;
				default:
					$h = 240;
					$w = 320;
			}
		} else {
			$h = $_zp_flash_player->getVideoHeigth($this);
			$w = $_zp_flash_player->getVideoWidth($this);
		}
		$this->set('width', $w);
		$this->set('height', $h);
	}

	/**
	 * Returns the image file name for the thumbnail image.
	 *
	 * @return string
	 */
	function getThumbImageFile() {
		if ($this->objectsThumb != NULL) {
			$imgfile = getAlbumFolder().$this->album->name.'/'.$this->objectsThumb;
		} else {
			$imgfile = SERVERPATH . '/' . THEMEFOLDER . '/' . UTF8ToFilesystem($this->album->gallery->getCurrentTheme()) . '/images/multimediaDefault.png';
			if (!file_exists($imgfile)) {
				$imgfile = SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . substr(basename(__FILE__), 0, -4). '/multimediaDefault.png';
			}
		}
		return $imgfile;
	}

	/**
	 * Get a default-sized thumbnail of this image.
	 *
	 * @return string
	 */
	function getThumb($type='image') {
		if ($this->objectsThumb == NULL) {
			$filename = makeSpecialImageName($this->getThumbImageFile());
			$path = ZENFOLDER . '/i.php?a=' . urlencode($this->album->name) . '&i=' . urlencode($filename) . '&s=thumb';
			if ($type !== 'image') $path .= '&'.$type.'=true';
			return WEBPATH . "/" . $path;
		} else {
			$filename = $this->objectsThumb;
			$wmt = getOption(get_class($this).'_watermark');
			if ($wmt) $wmt = '&wmt='.$wmt;
			$cachefilename = getImageCacheFilename($alb = $this->album->name, $filename, getImageParameters(array('thumb')));
			if (file_exists(SERVERCACHE . $cachefilename)	&& filemtime(SERVERCACHE . $cachefilename) > $this->filemtime) {
				return WEBPATH . substr(CACHEFOLDER, 0, -1) . pathurlencode(imgSrcURI($cachefilename));
			} else {
				if (getOption('mod_rewrite') && empty($wmt) && !empty($alb)) {
					$path = pathurlencode($alb) . '/'.$type.'/thumb/' . urlencode($filename);
				} else {
					$path = ZENFOLDER . '/i.php?a=' . urlencode($this->album->name) . '&i=' . urlencode($filename) . '&s=thumb'.$wmt;
					if ($type !== 'image') $path .= '&'.$type.'=true';
				}
				if (substr($path, 0, 1) == "/") $path = substr($path, 1);
				return WEBPATH . "/" . $path;
			}
		}
	}

	/**
	 *  Get a custom sized version of this image based on the parameters.
	 *
	 * @param string $alt Alt text for the url
	 * @param int $size size
	 * @param int $width width
	 * @param int $height height
	 * @param int $cropw crop width
	 * @param int $croph crop height
	 * @param int $cropx crop x axis
	 * @param int $cropy crop y axis
	 * @param string $class Optional style class
	 * @param string $id Optional style id
	 * @param bool $thumbStandin set true to inhibit watermarking
	 * @return string
	 */
	function getCustomImage($size, $width, $height, $cropw, $croph, $cropx, $cropy, $thumbStandin=false) {
		if ($thumbStandin & 1) {
			if ($this->objectsThumb == NULL) {
				$filename = makeSpecialImageName($this->getThumbImageFile());
				$path = ZENFOLDER . '/i.php?a=' . urlencode($this->album->name) . '&i=' . urlencode($filename);
				return WEBPATH . "/" . $path
				. ($size ? "&s=$size" : "" ) . ($width ? "&w=$width" : "") . ($height ? "&h=$height" : "")
				. ($cropw ? "&cw=$cropw" : "") . ($croph ? "&ch=$croph" : "")
				. ($cropx ? "&cx=$cropx" : "") . ($cropy ? "&cy=$cropy" : "")
				. "&t=true";
			} else {
				$filename = $this->objectsThumb;
				$wmt = getOption(get_class($this).'_watermark');
				if ($wmt) $wmt = '&wmt='.$wmt;
				$cachefilename = getImageCacheFilename($alb = $this->album->name, $filename,
														getImageParameters(array($size, $width, $height, $cropw, $croph, $cropx, $cropy, NULL, NULL, NULL, $thumbStandin, NULL, NULL)));
				if (file_exists(SERVERCACHE . $cachefilename) && filemtime(SERVERCACHE . $cachefilename) > $this->filemtime) {
					return WEBPATH . substr(CACHEFOLDER, 0, -1) . pathurlencode(imgSrcURI($cachefilename));
				} else {
					$path = ZENFOLDER . '/i.php?a=' . urlencode($alb) . '&i=' . urlencode($filename);
					if (substr($path, 0, 1) == "/") $path = substr($path, 1);
					return WEBPATH . "/" . $path
					. ($size ? "&s=$size" : "" ) . ($width ? "&w=$width" : "") . ($height ? "&h=$height" : "")
					. ($cropw ? "&cw=$cropw" : "") . ($croph ? "&ch=$croph" : "")
					. ($cropx ? "&cx=$cropx" : "") . ($cropy ? "&cy=$cropy" : "")
					. "&t=true".$wmt;
				}
			}
		} else {
			$filename = $this->filename;
			$cachefilename = getImageCacheFilename($this->album->name, $filename,	getImageParameters(array($size, $width, $height, $cropw, $croph, $cropx, $cropy, NULL, NULL, NULL, $thumbStandin, NULL, NULL)));
			if (file_exists(SERVERCACHE . $cachefilename) && filemtime(SERVERCACHE . $cachefilename) > $this->filemtime) {
				return WEBPATH . substr(CACHEFOLDER, 0, -1) . pathurlencode(imgSrcURI($cachefilename));
			} else {
				return WEBPATH . '/' . ZENFOLDER . '/i.php?a=' . urlencode($this->album->name) . '&i=' . urlencode($filename)
				. ($size ? "&s=$size" : "" ) . ($width ? "&w=$width" : "") . ($height ? "&h=$height" : "")
				. ($cropw ? "&cw=$cropw" : "") . ($croph ? "&ch=$croph" : "")
				. ($cropx ? "&cx=$cropx" : "") . ($cropy ? "&cy=$cropy" : "");
			}
		}
	}
	
	function getBody() {
		global $_zp_flash_player;
		$w = $this->getWidth();
		$h = $this->getHeight();
		$ext = strtolower(strrchr($this->getFullImage(), "."));
		switch ($ext) {
			case '.flv':
			case '.mp3':
			case '.mp4':
				if (is_null($_zp_flash_player)) {
					return  "<img src='" . WEBPATH . '/' . ZENFOLDER . "'/images/err-noflashplayer.gif' alt='No flash player installed.' />";
				} else {
					return $_zp_flash_player->getPlayerConfig('',$this->getTitle());
				}
				break;
			case '.3gp':
				return '</a>
				<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="'.
					$w.'" height="'.$h.
					'" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
					<param name="src" value="' . $this->getFullImage() . '"/>
					<param name="autoplay" value="false" />
					<param name="type" value="video/quicktime" />
					<param name="controller" value="true" />
					<embed src="' . $this->getFullImage() . '" width="'.$w.'" height="'.$h.'" autoplay="false" controller"true" type="video/quicktime"
						pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
						</object><a>';
				break;
			case '.mov':
				return '</a>
			 		<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="'.$w.'" height="'.$h.'" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
				 	<param name="src" value="' . $this->getFullImage() . '"/>
				 	<param name="autoplay" value="false" />
				 	<param name="type" value="video/quicktime" />
				 	<param name="controller" value="true" />
				 	<embed src="' . $this->getFullImage() . '" width="'.$w.'" height="'.$h.'" autoplay="false" controller"true" type="video/quicktime"
				 		pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
					</object><a>';
				break;
		}		
	}

}
?>