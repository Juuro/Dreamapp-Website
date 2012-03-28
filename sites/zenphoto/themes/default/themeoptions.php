<?php

/* Plug-in for theme option handling 
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 * 
 * Interface functions:
 *     getOptionsSupported()
 *        returns an array of the option names the theme supports
 *        the array is indexed by the option name. The value for each option
 *          a value of 0 says for admin to use standard processing for the option
 *          a value of 1 will cause admin to call handleThemeOption to generate the HTML for the option
 *             
 *     handleThemeOption($option, $currentValue)
 *       $option is the name of the option being processed
 *       $currentValue is the "before" value of the option
 *
 *       this function is called by admin from within the table row/column where the option field is placed
 *       It must write the HTML that does the option handling UI
 *
 *       the version below provides a dropdown list of all the CSS files in the theme folder. It is used by themes
 *       which support selectable CSS files for different color schemes.
 */

require_once(SERVERPATH . "/" . ZENFOLDER . "/admin-functions.php");

class ThemeOptions {
	
	function ThemeOptions() {
		setOptionDefault('Allow_comments', true);
		setOptionDefault('Allow_search', true);
		setOptionDefault('Theme_colors', 'light'); 
	}
	
	function getOptionsSupported() {
		return array(	gettext('Allow comments') => array('key' => 'Allow_comments', 'type' => 1, 'desc' => gettext('Check to enable comment section.')),
									gettext('Allow search') => array('key' => 'Allow_search', 'type' => 1, 'desc' => gettext('Check to enable search form.')),
									gettext('Theme colors') => array('key' => 'Theme_colors', 'type' => 2, 'desc' => gettext('Select the colors of the theme'))
								);
	}

	function handleOption($option, $currentValue) {
		if ($option == 'Theme_colors') {
			$theme = basename(dirname(__FILE__));
			$themeroot = SERVERPATH . "/themes/$theme/styles";
			echo '<select id="themeselect" name="' . $option . '"' . ">\n";
			generateListFromFiles($currentValue, $themeroot , '.css');
			echo "</select>\n";
		}
	}
}
?>
