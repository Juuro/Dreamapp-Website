<?php

class ThemeOptions {

	function ThemeOptions() {
		/* put any setup code needed here */
		setOptionDefault('Allow_comments', true);
		setOptionDefault('Allow_search', true);
		setOptionDefault('Mini_slide_selector', 'Recent images');
	}
	
	function getOptionsSupported() {
		return array(	gettext('Allow comments') => array('key' => 'Allow_comments', 'type' => 1, 'desc' => gettext('Check to enable comment section.')),
									gettext('Allow search') => array('key' => 'Allow_search', 'type' => 1,
													'desc' => gettext('Check to enable search form.')),
									gettext('Mini slide selector') => array('key' => 'Mini_slide_selector', 'type' => 5,
													'selections' => array(gettext('Recent images') => 'Recent images', gettext('Random images') => 'Random images'),
													'desc' => gettext('Select what you want for the six special slides.'))
									);
	}
	function handleOption($option, $currentValue) {
	}

}
?>
