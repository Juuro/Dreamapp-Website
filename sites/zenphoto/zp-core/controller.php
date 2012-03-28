<?php

/**
 * controller.php
 * Root-level include that handles all user requests.
 * @package core
 */

// force UTF-8 Ø


require_once(dirname(__FILE__).'/functions-controller.php');


// Initialize the global objects and object arrays:
$_zp_gallery = new Gallery();

$_zp_current_album = NULL;
$_zp_current_album_restore = NULL;
$_zp_albums = NULL;
$_zp_current_image = NULL;
$_zp_current_image_restore = NULL;
$_zp_images = NULL;
$_zp_current_comment = NULL;
$_zp_comments = NULL;
$_zp_current_context = ZP_INDEX;
$_zp_current_context_restore = NULL;
$_zp_current_search = NULL;
$_zp_pre_authorization = array();


/*** Request Handler **********************
 ******************************************/
// This is the main top-level action handler for user requests. It parses a
// request, validates the input, loads the appropriate objects, and sets
// the context. All that is done in functions-controller.php.

// Handle the request for an image or album.
$zp_request = zp_load_request();

// handle any album passwords that might have been posted
zp_handle_password();

// Handle any comments that might be posted.

if (getOption('Allow_comments')) $_zp_comment_error = zp_handle_comment();

/*** Server-side AJAX Functions ***********
 ******************************************/
// These handle asynchronous requests from the client for updating the
// title and description, but only if the user is logged in.

if (zp_loggedin()) {

	/**
	 * Handle AJAX editing in place
	 *
	 * @param string $context 	either 'image' or 'album', object to be updated
	 * @param string $field		field of object to update (title, desc, etc...)
	 * @param string $value		new edited value of object field
	 * @since 1.3
	 * @author Ozh
	 **/
	function editInPlace_handle_request($context = '', $field = '', $value = '', $orig_value = '') {
		// Cannot edit when context not set in current page (should happen only when editing in place from index.php page)
		if ( !in_context(ZP_IMAGE) && !in_context(ZP_ALBUM) )
			die ($orig_value.'<script type="text/javascript">alert("'.gettext('Oops.. Cannot edit from this page').'");</script>');

		// Make a copy of context object
		switch ($context) {
		case 'image':
			global $_zp_current_image;
			$object = $_zp_current_image;
			break;
		case 'album':
			global $_zp_current_album;
			$object = $_zp_current_album;
			break;
		default:
			die (gettext('Error: malformed Ajax POST'));
		}
		
		// Dates need to be handled before stored
		if ($field == 'date') {
			$value = date('Y-m-d H:i:s', strtotime($value));
		}
		
		// Sanitize new value
		switch ($field) {
		case 'desc':
			$level = 1;
			break;
		case 'title':
			$level = 2;
			break;
		default:
			$level = 3;
		}
		$value = str_replace("\n", '<br/>', sanitize($value, $level)); // note: not using nl2br() here because it adds an extra "\n"
		
		// Write new value
		if ($field == '_update_tags') {
			$value = trim($value, ', ');
			$object->setTags($value);
		} else {
			$object->set($field, $value);
		}
		
		$result = $object->save();
		if ($result !== false) {
			echo $value;
		} else {
			echo ('<script type="text/javascript">alert("'.gettext('Could not save!').'");</script>'.$orig_value);
		}
		die();
	}
	
	if ( !empty($_POST["eip_context"] ) &&  !empty($_POST["eip_field"] ) )
		editInPlace_handle_request($_POST["eip_context"], $_POST["eip_field"], $_POST["new_value"], $_POST["orig_value"]);
}


/*** Consistent URL redirection ***********
 ******************************************/
// Check to see if we use mod_rewrite, but got a query-string request for a page.
// If so, redirect with a 301 to the correct URL. This must come AFTER the Ajax init above,
// and is mostly helpful for SEO, but also for users. Consistent URLs are a Good Thing.

fix_path_redirect();

?>
