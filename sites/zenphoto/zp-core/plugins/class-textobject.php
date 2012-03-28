<?php
/**
 * Plugin handler for "text" files
 * Text can be displayed in place of an image in themes
 *
 * This is not necessarily a useful "image" type. All you get is a block of text in place of an image.
 * The contents of the text file will be displayed. I guess you could stick HTML encoding into the file and
 * get some interesting results.
 * 
 * What this plugin really is for is to serve as a model of how a plugin can be made to handle file types 
 * that zenphoto does not handle natively.
 * 
 * Some key points to note:
 * 1. The naming convention for these plugins is class-«handler class».php. This is important because zenphoto 
 * keys on the string "class-" to know to load these plugins with the other zenphoto classes.
 * 2. These objects are extension to the zenphoto "Image" class. This means they have all the properties of 
 * an image plus whatever you add. Of course you will need to override some of the image class functions to 
 * implement the functionality of your new class.
 * 3. There is one VERY IMPORTANT method that you must provide which is not part of the "Image" base class. That
 * getBody() method. This method is called by template-functions.php in place of where it would normally put a URL
 * to the image to show. This method must do everything needed to cause your image object to be viewable by the 
 * browser.
 * 
 * So, briefly, the first four lines of code below are the standard plugin interface to Admin. There is one small
 * wrinkle you might notice--the code for 'plugin_description' includes a test which sets the variable $disable. 
 * As you might expect, there were some changes needed to zenphoto in order to get this concept to work.  $disable
 * is set to true if the revision  of zenphoto that is attempting to load this plugin is lower than the one where the
 * implementation first appeared. The interface variable 'plugin_disable' is set to this value telling Admin not to 
 * allow enabling of the plugin if the release level is too low.
 * 
 * The line that follows insures that the plugin will not load when it should be disabled--just in case.
 * 
 * Then there is a call on addPlginType(«file extension», «Object Name»); This function registers the plugin as the
 * handler for files with the specified extension. If the plugin can handle more than one file extension, make a call 
 * to the registration function for each extension that it handles.
 * 
 * The rest is the object class for handling these files.
 * The code of the object instantiation function is mostly required. Plugin "images" follow the lead of videos in that
 * if there is a real image file with the same name save the suffix, it will be considered the thumb image of the object.
 * This image is fetched by the call on checkObjectsThumb(). There is also code in the getThumb() method to deal with 
 * this property.
 * 
 * Since text files have no natural height and width, we set them based on the image size option. This happens after the call
 * PersistentObject(). The rest of the code there sets up the default title.
 * 
 * getThumb() is responsible for generating the thumbnail image for the object. As above, if there is a similar named real
 * image, it will be used. Otherwise [for this object implementation] we will use a thumbnail image provided with the plugin.
 * The particular form of the file name used when there is no thumb stand-in image allows zenphoto to choose an image in the
 * plugin folder. 
 * 
 * @author Stephen Billard (sbillard)
 * @version 1.0.0
 * @package plugins
 * 
 * */

$plugin_description = ($disable = (ZENPHOTO_RELEASE < 2492))? gettext('class-textobject requires Zenphoto v 1.2.1 or greater.') : gettext('Provides a means for showing text where zenphoto would normally display images. For documentation, see the script file.');
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0.0';
$plugin_disable = $disable;

if ($plugin_disable) return;
addPluginType('txt', 'TextObject');


class TextObject extends _Image {

	/**
	 * creates a textobject (image standin)
	 *
	 * @param object $album the owner album
	 * @param string $filename the filename of the text file
	 * @return TextObject
	 */
	function TextObject($album, $filename) {
		// $album is an Album object; it should already be created.
		if (!is_object($album)) return NULL;
		$this->classSetup($album, $filename);
		$this->objectsThumb = checkObjectsThumb($album->localpath, $filename);
		// Check if the file exists.
		if (!file_exists($this->localpath) || is_dir($this->localpath)) {
			$this->exists = false;
			return NULL;
		}
		if (parent::PersistentObject('images', array('filename'=>$filename, 'albumid'=>$this->album->id), 'filename', false, false)) {
			$this->updateDimensions();
			$title = $this->getDefaultTitle();
			$this->set('title', $title);
			$this->set('mtime', filemtime($this->localpath));
			apply_filter('new_image', $this);
			$this->save();
		}
	}

	/**
	 * Returns the image file name for the thumbnail image.
	 *
	 * @return s
	 */
	function getThumbImageFile() {
		if ($this->objectsThumb != NULL) {
			$imgfile = getAlbumFolder().$this->album->name.'/'.$this->objectsThumb;
		} else {
			$imgfile = SERVERPATH . '/' . THEMEFOLDER . '/' . UTF8ToFilesystem($this->album->gallery->getCurrentTheme()) . '/images/textDefault.png';
			if (!file_exists($imgfile)) {
				$imgfile = SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . substr(basename(__FILE__), 0, -4). '/textDefault.png';
			}
		}
	return $imgfile;
	}
	
	/**
	 * returns a link to the thumbnail for the text file.
	 *
	 * @param string $type 'image' or 'album'
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
	 * Returns the content of the text file
	 *
	 * @return string
	 */
	function getBody() {
		$text = @file_get_contents($this->localpath);
		return '<div class="textobject">'.$text.'</div>';
	}

	function getCustomImage($size, $width, $height, $cropw, $croph, $cropx, $cropy, $thumbStandin=false) {
		if ($thumbStandin) {
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
			return $this->getBody();
		}
	}

	function getSizedImage($size) {
		return $this->getBody();
	}

	function updateDimensions() {
		$this->set('width', getOption('image_size')); 
		$this->set('height', floor((getOption('image_size') * 24) / 36));
	}
	
}
?>