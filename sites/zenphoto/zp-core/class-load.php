<?php
/*******************************************************************************
* Load the base classes (Image, Album, Gallery, etc.)                          *
*******************************************************************************/

require_once(dirname(__FILE__).'/classes.php');
require_once(dirname(__FILE__).'/class-image.php');
require_once(dirname(__FILE__).'/class-album.php');
require_once(dirname(__FILE__).'/class-gallery.php');
require_once(dirname(__FILE__).'/class-search.php');
require_once(dirname(__FILE__).'/class-transientimage.php');

// load the class plugins
$class_optionInterface = array();
foreach (getEnabledPlugins() as $extension) {
	if (strpos($extension, 'class-') !== false) {
		$option_interface = NULL;
		require_once(SERVERPATH . "/" . ZENFOLDER . PLUGIN_FOLDER . $extension);
		if (!is_null($option_interface)) {
			$class_optionInterface[$extension] = $option_interface;
		}
	}
}

?>