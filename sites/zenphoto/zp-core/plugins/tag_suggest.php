<?php
/**
 * tag suggest plugin draft based on Remy Sharp's jQuery Tag Suggestion plugin
 * Just activate the plugin and the feature is available on the theme's search field.
 *
 * @author Malte Müller (acrylian), Stephen Billard (sbillard) - an adaption of Remy Sharp's <a href='http://remysharp.com/2007/12/28/jquery-tag-suggestion/ '>jQuery Tag Suggestion</a>
 * @version 1.0.0
 * @package plugins
 */

$plugin_description = gettext("Enables jQuery tag suggestions on the search field. Just activate the plugin and the feature is available on the theme's search field.");
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard) — ".gettext("an adaption of Remy Sharp's <a href='http://remysharp.com/2007/12/28/jquery-tag-suggestion/ '>jQuery Tag Suggestion</a>");
$plugin_version = '1.0.0';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---tag_suggest.php.html";

// register the scripts needed
addPluginScript('<script type="text/javascript" src="' . WEBPATH . '/' . ZENFOLDER . '/js/tag.js"></script>');
addPluginScript('<link type="text/css" rel="stylesheet" href="' . WEBPATH . '/' . ZENFOLDER . '/plugins/tag_suggest/tag.css" />');
$taglist = getAllTagsUnique();
$c = 0;
$list = '';
foreach ($taglist AS $tag) {
	if ($c>0) $list .= ',';
	$c++;
	$list .= '"'.htmlspecialchars(htmlspecialchars_decode($tag), ENT_QUOTES).'"';
}
$js = '<script type="text/javascript">'.
			'$(function () {'.
				"$('#search_input').tagSuggest({".
					'tags: ['.$list.']'.
				'});'.
			'});'.
		'</script>';

addPluginScript($js);
?>