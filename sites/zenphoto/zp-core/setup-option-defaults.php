<?php

// force UTF-8 Ø

/**
 * stores all the default values for options
 * @package setup
 */

/**
 * sets option defaults from the zp-config.php file if they exist there.
 *
 * @param string $option
 * @param mixed $default
 */
function setDefault($option, $default) {
	global $conf;
	if (isset($conf[$option])) {
		$v = sanitize($conf[$option],2);
	}
	if (!isset($v) || empty($v)) {
		$v = $default;
	}
	setOptionDefault($option, $v);
}

	require(dirname(__FILE__).'/zp-config.php');
	setOption('zenphoto_release', ZENPHOTO_RELEASE);

	//clear out old admin user and cleartext password
	unset($_zp_conf_vars['adminuser']);
	unset($_zp_conf_vars['adminpass']);
	$admin = getOption('adminuser');
	if (!empty($admin)) {   // transfer the old credentials and then remove them
		if ((count(getAdministrators()) == 0)) {  // don't revert anything!
			$pass = getOption('adminpass');
			$string = preg_replace("/[^a-f0-9]/","",$pass);
			if ((strlen($pass) == 32) && ($pass == $string)){  // best guess it that it is a md5 pasword, not cleartext
				saveAdmin($admin, $pass, getOption('admin_name') , getOption('admin_email'), ALL_RIGHTS, array());
			}
		}
		$sql = 'DELETE FROM '.prefix('options').' WHERE `name`="adminuser"';
		query($sql);
		$sql = 'DELETE FROM '.prefix('options').' WHERE `name`="adminpass"';
		query($sql);
		$sql = 'DELETE FROM '.prefix('options').' WHERE `name`="admin_name"';
		query($sql);
		$sql = 'DELETE FROM '.prefix('options').' WHERE `name`="admin_email"';
		query($sql);
  }

	// old zp-config.php opitons. preserve them
	$conf = $_zp_conf_vars;
	setDefault('gallery_title', "Gallery");
	setDefault('website_title', "");
	setDefault('website_url', "");
	setDefault('time_offset', 0);
	if (isset($_GET['mod_rewrite']) && $_GET['mod_rewrite'] == 'ON') {
		$rw = 1;
	} else {
		$rw = 0;
	}
	setDefault('mod_rewrite', $rw);
	setDefault('mod_rewrite_image_suffix', ".php");
	setDefault('server_protocol', "http");
	setDefault('charset', "UTF-8");
	setDefault('image_quality', 85);
	setDefault('thumb_quality', 75);
	setDefault('image_size', 595);
	if (!getOption('image_use_longest_side') === '0') {
		setDefault('image_use_side', 'width');
	} else {
		setDefault('image_use_side', 'longest');
	}
	setDefault('image_allow_upscale', 0);
	setDefault('thumb_size', 100);
	setDefault('thumb_crop', 1);
	setDefault('thumb_crop_width', 85);
	setDefault('thumb_crop_height', 85);
	setDefault('thumb_sharpen', 0);
	setDefault('image_sharpen', 0);
	setDefault('albums_per_page', 5);
	setDefault('images_per_page', 15);

	setOptionDefault('gallery_password', '');
	setOptionDefault('gallery_hint', NULL);
	setOptionDefault('search_password', '');
	setOptionDefault('search_hint', NULL);
	setOptionDefault('gmaps_apikey', "");
	setOptionDefault('album_session', 0);
	
	if (getOption('perform_watermark')) {
		$v = str_replace('.png', "", basename(getOption('watermark_image')));
		setoptionDefault('fullimage_watermark', $v);
	}
	
	setOptionDefault('watermark_h_offset', 90);
	setOptionDefault('watermark_w_offset', 90);
	setOptionDefault('watermark_scale', 5);
	setOptionDefault('watermark_allow_upscale', 1);
	setOptionDefault('perform_video_watermark', 0);
	
	if (getOption('perform_video_watermark')) {
		$v = str_replace('.png', "", basename(getOption('video_watermark_image')));
		setoptionDefault('Video_watermark', $v);
	}
	
	setOptionDefault('spam_filter', 'none');
	setOptionDefault('email_new_comments', 1);
	setOptionDefault('gallery_sorttype', 'ID');
	setOptionDefault('gallery_sortdirection', '0');
	setOptionDefault('image_sorttype', 'Filename');
	setOptionDefault('image_sortdirection', '0');
	setOptionDefault('hotlink_protection', '1');
	setOptionDefault('current_theme', 'default');
	setOptionDefault('feed_items', 10);
	setOptionDefault('feed_imagesize', 240);
	setOptionDefault('feed_sortorder', 'latest');
	setOptionDefault('feed_enclosure', '0');
	setOptionDefault('feed_mediarss', '0');
	setOptionDefault('search_fields', 32767);
	$a =							"a => (href => () title => ())\n" .
	 									"abbr =>(title =>())\n" .
	 									"acronym =>(title =>())\n" .
	 									"b => ()\n" .
	 									"blockquote =>(cite =>())\n" .
	 									"code => ()\n" .
	 									"em => ()\n" .
	 									"i => () \n" .
	 									"strike => ()\n" .
	 									"strong => ()\n" .
	 									"ul => ()\n" .
	 									"ol => ()\n" .
	 									"li => ()\n" .
										"p => (style=>())\n" .
										"h1=>(style=>())\n" .
										"h2=>(style=>())\n" .
										"h3=>(style=>())\n" .
										"h4=>(style=>())\n" .
										"h5=>(style=>())\n" .
										"h6=>(style=>())\n" .
										"pre=>(style=>())\n" .
										"address=>(style=>())\n" .
										"span=>(style=>())\n".
										"img=>(style=>() src=>() title=>() alt=>() width=>() height=>())\n"
										;
	setOptionDefault('allowed_tags_default', $a); 
	setOptionDefault('allowed_tags', $a);
	setOptionDefault('style_tags', 
										"abbr => (title => ())\n" .
	 									"acronym => (title => ())\n" .
	 									"b => ()\n" .
	 									"em => ()\n" .
	 									"i => () \n" .
	 									"strike => ()\n" .
	 									"strong => ()\n");
	setOptionDefault('comment_name_required', 1);
	setOptionDefault('comment_email_required', 1);
	setOptionDefault('comment_web_required', 0);
	setOptionDefault('Use_Captcha', false);
	setOptionDefault('full_image_quality', 75);
	setOptionDefault('persistent_archive', 0);

	if (getOption('protect_full_image') === '0') {
		$protection = 'Unprotected';
	} else if (getOption('protect_full_image') === '1') {
		if (getOption('full_image_download')) {
			$protection = 'Download';
		} else {
			$protection = 'Protected view';
		}
	} else {
		$protection = false;
	}
	if ($protection) {
		setOption('protect_full_image', $protection);
	} else {
		setOptionDefault('protect_full_image', 'Protected view');
	}

	setOptionDefault('locale', '');
	setOptionDefault('date_format', '%c');

	// plugins--default to enabled
	setOptionDefault('zp_plugin_google_maps', 1);
	setOptionDefault('zp_plugin_rating', 1);
	setOptionDefault('zp_plugin_image_album_statistics', 1);
	setOptionDefault('zp_plugin_flowplayer', 1);
	
	setOption('zp_plugin_admin_toolbox', 0); //deprecated plugin
	
	setOptionDefault('zp_plugin_class-video', 1);
	setOptionDefault('zp_plugin_filter-zenphoto_seo', 1);
	
	setOptionDefault('use_lock_image', 1);
	setOptionDefault('gallery_user', '');
	setOptionDefault('search_user', '');
	setOptionDefault('album_use_new_image_date', 0);
	setOptionDefault('thumb_select_images', 1);
	setOptionDefault('Gallery_description', 'You can insert your Gallery description using on the Admin Options tab.');
	setOptionDefault('multi_lingual', 0);
	setOptionDefault('login_user_field', 1);
	setOptionDefault('tagsort', 0);
	setOptionDefault('albumimagesort', 'ID');
	setOptionDefault('albumimagedirection', 'DESC');
	setOptionDefault('cache_full_image', 0);
	setOptionDefault('custom_index_page', '');
	setOptionDefault('picture_of_the_day', serialize(array('day'=>NULL,'folder'=>NULL,'filename'=>NULL)));
	setOptionDefault('exact_tag_match', 0);
	
	setOptionDefault('EXIFMake', 1);
	setOptionDefault('EXIFModel', 1);
	setOptionDefault('EXIFExposureTime', 1);
	setOptionDefault('EXIFFNumber', 1);
	setOptionDefault('EXIFFocalLength', 1);
	setOptionDefault('EXIFFocalLength35mm', 1);
	setOptionDefault('EXIFISOSpeedRatings', 1);
	setOptionDefault('EXIFDateTimeOriginal', 1);
	setOptionDefault('EXIFExposureBiasValue', 1);
	setOptionDefault('EXIFMeteringMode', 1);
	setOptionDefault('EXIFFlash', 1);
	foreach ($_zp_exifvars as $key=>$item) {
		setOptionDefault($key, 0);
	}
	setOptionDefault('user_registration_page', '');
	setOptionDefault('user_registration_text', gettext('Register'));
	setOptionDefault('user_registration_tip', gettext('Click here to register for this site.'));
	setOptionDefault('auto_rotate', 0);
	setOptionDefault('IPTC_encoding', 'ISO-8859-1');
	setOptionDefault('Allow_comments', 1);
	
	setOptionDefault('UTF8_image_URI', 0);
	setOptionDefault('captcha', 'zenphoto');
	
	setOptionDefault('sharpen_amount', 40);
	setOptionDefault('sharpen_radius', 0.5);
	setOptionDefault('sharpen_threshold', 3);
	
?>
