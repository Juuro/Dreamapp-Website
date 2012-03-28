<?php
/**
 * Provides a means where visitors can select the size of the image on the image page.
 *
 * The default size and list of allowed sizes may be set in the plugin options or
 * passed as a parameter to the support functions.
 *
 * The user selects a size to view from a radio button list. This size is then saved in
 * a cookie and used as the default for future image viewing.
 *
 * Sizes as used for the default size and the allowed size list are strings with the
 * The form is "$s=<size>" or "$h=<height>,$w=<width>;".... See printCustomSizedImage() for
 * information about how these values are used.
 *
 * If "$s" is present, the plugin will use printCustomSizedImage() to display the image. Otherwise
 * both "$w" and "$h" must be present. Then printCustomSizedImageMaxSpace() is used for
 * displaying the image.
 *
 * @author Stephen Billard (sbillard)
 * @version 1.0.0
 * @package plugins
 */

$plugin_description = gettext("Provides a means allowing users to select the image size to view.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0.0';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---viewer_size_image.php.html";
$option_interface = new viewer_size_image_options();

/**
 * Plugin option handling class
 *
 */
class viewer_size_image_options {

	function viewer_size_image_options() {
		$default = getOption('image_size');
		setOptionDefault('viewer_size_image_sizes', '$s='.($default-200).'; $s='.($default-100).'; $s='.($default).'; $s='.($default+100).'; $s='.($default+200).';');
		setOptionDefault('viewer_size_image_default', '$s='.$default);
	}

	function getOptionsSupported() {
		return array(	gettext('Image sizes allowed') => array('key' => 'viewer_size_image_sizes', 'type' => 3,
										'desc' => gettext('List of sizes from which the viewer may select.<br />The form is "$s=<size>" or "$h=<height>,$w=<width>;"....<br />See printCustomSizedImage() for details')),
		gettext('Default size') => array('key' => 'viewer_size_image_default', 'type' => 0,
										'desc' => gettext('The initial size for the image. Format is a single instance of the sizes list.'))
		);
	}
	function handleOption($option, $currentValue) {
	}
}

if (!OFFSET_PATH) {
	$cookiepath = WEBPATH;
	if (WEBPATH == '') { $cookiepath = '/'; }
	$saved = zp_getCookie('viewer_size_image_saved');
	if (empty($saved)) {
		$postdefault = trim(getOption('viewer_size_image_default'));
	} else {
		$_POST['viewer_size_image_selection'] = true; // ignore default size
		$postdefault = $saved;
	}
}

/**
 * prints the radio button image size selection list
 *
 * @param string $text text to introduce the radio button list
 * @param string $default the default (initial) for the image sizing
 * @param array $usersizes an array of sizes which may be choosen.
 */
function printUserSizeSelectior($text='', $default=NULL, $usersizes=NULL) {
	$size = $width = $height = NULL;
	getViewerImageSize($default, $size, $width, $height);
	if (!empty($size)) {
		$current = $size;
	} else {
		$current = $width.'x'.$height;
	}
	$sizes = array();
	if (empty($text)) $text = gettext('Select image size');
	if (is_null($usersizes)) {
		$inputs = explode(';', trim(getOption('viewer_size_image_sizes')));
		if(!empty($inputs)) {
			foreach ($inputs as $size) {
				if (!empty($size)) {
					$size = str_replace(',',';',$size).';';
					$s = $w = $h = NULL;
					if (false === eval($size)) {
						trigger_error(gettext('There is a format error in your <em>viewer_size_image_sizes</em> option string.'), E_USER_NOTICE);
					}
					if (!empty($s)) {
						$key = $s;
					} else {
						$key = $w.'x'.$h;
					}
					$sizes[$key] = array('$s'=>$s, '$h'=>$h, '$w'=>$w);
				}
			}
		}
	} else {
		foreach ($usersizes as $key=>$size) {
			if (!empty($size)) {
				$size = str_replace(',',';',$size).';';
				$s = $w = $h = NULL;
				if (false === eval($size)) {
					trigger_error(gettext('There is a format error in your $usersizes string.'), E_USER_NOTICE);
				}
				if (!empty($s)) {
					$key = $s;
				} else {
					$key = $w.'x'.$h;
				}
				$sizes[$key] = array('$s'=>$s, '$h'=>$h, '$w'=>$w);
			}
		}
	}
	$cookiepath = WEBPATH;
	if (WEBPATH == '') { $cookiepath = '/'; }
	?>
	<script>
		function switchimage(obj){
			var url = $(obj).attr('url');
			$('#image img').attr('src',url);
			document.cookie='viewer_size_image_saved='+$(obj).attr('value')+'; expires=<?php echo time()+COOKIE_PESISTENCE ?>; path=<?php echo $cookiepath ?>;';
			console.log(document.cookie);
		}
	</script>
	<div>
	<?php
	echo $text;
	foreach($sizes as $key=>$size) {
		if (empty($size['$s'])) {
			$display = sprintf(gettext('%1$s x %2$s px'), $size['$w'],$size['$h']);
			$url = getCustomImageURL(null, $size['$w'],$size['$h'], null, null, null, null, false);
			$value='$h='.$size['$h'].',$w='.$size['$w'];
		} else {
			$display = sprintf(gettext('%s px'),$size['$s']);
			$url = getCustomImageURL($size['$s'], null, null, null, null, null, null, false);
			$value='$s='.$size['$s'];
		}
		$checked ="";
		if($key == $current) {
			$checked = 'checked="CHECKED" '; 
		}
		?>
		<input type="radio" name="viewer_size_image_selection" id="s<?php echo $key; ?>" url="<?php echo $url;?>" value="<?php echo $value; ?>" <?php echo $checked; ?> onclick="switchimage(this);" />
		<label for="s<?php echo $key; ?>"> <?php echo $display; ?></label>
		<?php
	}
	?>
	</div>
	<?php
}
/**
 * returns the current values for the image size or its height & width
 * This information comes form (in order of priority)
 *   1. The posting of a radio button selection
 *   2. A cookie stored from #1
 *   3. The default (either as passed, or from the plugin option.)
 *
 * The function is used internally, so the above priority determines the
 * image sizing.
 *
 * @param string $default the default (initial) value for the image sizing
 * @param int $size The size of the image (Width and Height are NULL)
 * @param int $width The width of the image (size is null)
 * @param int $height The height of the image (size is null)
 */
function getViewerImageSize($default, &$size, &$width, &$height) {
	global $postdefault;
	if (isset($_POST['viewer_size_image_selection']) || empty($default)) {
		$postdefault = str_replace(',',';',$postdefault);
		$postdefault = str_replace(' ','',$postdefault).';';
		$s = $w = $h  = NULL;
		if (false === eval($postdefault)) {
			trigger_error(gettext('There is a format error in user size selection'), E_USER_NOTICE);
		}
		$size = $s;
		$width = $w;
		$height = $h;
	} else {
		$default = str_replace(',',';',$default).';';
		$s = $w = $h  = NULL;
		if (false === eval($default)) {
			trigger_error(gettext('There is a format error in your $default parameter'), E_USER_NOTICE);
		}
		if (!empty($s)) {
			$size = $s;
			$width = $height  = NULL;
		} else {
			$size = NULL;
			$width = $w;
			$height = $h;
		}
	}
}

/**
 * prints the image according to the size chosen
 *
 * @param string $alt alt text for the img src Tag
 * @param string $default the default (initial) value for the image sizing
 * @param string $class if not empty will be used as the image class tag
 * @param string $id if not empty will be used as the image id tag
 */
function printUserSizeImage($alt, $default=NULL, $class=NULL, $id=NULL) {
	$size = $width = $height = NULL;
	getViewerImageSize($default, $size, $width, $height);
	if (empty($size)) {
		printCustomSizedImageMaxSpace($alt,$width,$height,$class,$id);
	} else {
		printCustomSizedImage($alt, $size, $width, $height, NULL, NULL, NULL, NULL, $class, $id, false);
	}
}
?>
