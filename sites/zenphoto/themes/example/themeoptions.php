<?php
	
class ThemeOptions {

	
	function ThemeOptions() {
		/* put any setup code needed here */
		setOptionDefault('Allow_comments', true);
		setOptionDefault('Allow_search', true);
		setOptionDefault('Use_flv_playlist', false);
		setOptionDefault('flv_playlist_option', false);
	}
	
	function getOptionsSupported() {
		if (!getOption('zp_plugin_flv_playlist')) {
			$flv_playlist_missing = ' <strong>'.gettext("The flv_playlist plugin is not enabled. It must be enabled for this option to have effect.").'</strong>';
		} else {
			$flv_playlist_missing = '';
		}
		if (!getOption('zp_plugin_flvplayer')) {
			$flv_player_missing = ' <strong>'.gettext("The flvplayer plugin is not enabled. It must be enabled for this option to have effect.").'</strong>';
		} else {
			$flv_player_missing = '';
		}
		return array(	gettext('Allow comments') => array('key' => 'Allow_comments', 'type' => 1, 'desc' => gettext('Check to enable comment section.')),
		gettext('Use flv playlist') => array('key' => 'Use_flv_playlist', 'type' => 1, 'desc' => gettext('Check and the theme will use the flv_playlist plugin in place of the next_image loop.').$flv_playlist_missing.$flv_player_missing),
		gettext('flv playlist option') => array('key' => 'flv_playlist_option', 'type' => 5,
						'selections' => array(gettext('Players')=>'players', gettext('Playlist')=>'playlist'),
						'desc' => gettext('Select the option for the <em>flv_playlist()</em> function.')),
		gettext('Allow search') => array('key' => 'Allow_search', 'type' => 1, 'desc' => gettext('Check to enable search form.'))
		);
	}
	function handleOption($option, $currentValue) {
	}
}
?>
