<?php
/**
 * Contact form
 *
 * Prints a e-mail contact form that uses Zenphoto's internal validation functions for e-mail and URL. 
 * Name, e-mail adress, subject and message are required fields by default. 
 * You need to enter a custom mail adress that should be use for the messages. 
 * 
 * Supports Zenphoto's captcha and confirmation before the message is sent. No other spam filter support, since mail providers have this anyway.
 * 
 * The contact form itself is a separate file and located within /contact_form/form.php so that it can be style as needed.
 *
 * @author Malte Müller (acrylian), Stephen Billard (sbillard)
 * @version 1.1.3.2
 * @package plugins
 */

$plugin_description = gettext("Prints a e-mail contact form that uses Zenphotos internal validation functions for e-mail and URL. Name, e-mail adress, subject and message (and if enabled Captcha) are required fields. You need to enter a custom mail adress that should be use for the messages. Supports Zenphoto's captcha and confirmation before the message is sent. No other spam filter support, since mail providers have this anyway.");
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard)";
$plugin_version = '1.1.3.2';
$plugin_URL = "";
$option_interface = new contactformOptions();

require_once(SERVERPATH . "/" . ZENFOLDER . "/admin-functions.php");
if (getOption('zp_plugin_zenpage')) require_once("zenpage/zenpage-template-functions.php");
/**
 * Plugin option handling class
 *
 */
class contactformOptions {
	
	function contactformOptions() {
		setOptionDefault('contactform_introtext', '<p>Fields with <strong>*</strong> are required. HTML or any other code is not allowed. A copy of your e-mail will automatically be sent to the address you provided for your own records.</p>');
		setOptionDefault('contactform_confirmtext', '<p>Please confirm that you really want to send this email. Thanks.</p>');
		setOptionDefault('contactform_thankstext', '<p>Thanks for your message. A copy has been sent to your provided e-mail adress for your own records.</p>');
		setOptionDefault('contactform_title', "show");
		setOptionDefault('contactform_name', "required");
		setOptionDefault('contactform_company', "show");
		setOptionDefault('contactform_street',"show");
		setOptionDefault('contactform_city', "show");
		setOptionDefault('contactform_country', "show");
		setOptionDefault('contactform_email', "required");
		setOptionDefault('contactform_website', "show");
		setOptionDefault('contactform_phone', "show");
		setOptionDefault('contactform_captcha', 0);
		setOptionDefault('contactform_subject', "required");
		setOptionDefault('contactform_message', "required");
		$admins = getAdministrators();
		$admin = array_shift($admins);
		$adminname = $admin['user'];
		$adminemail = $admin['email'];
		setOptionDefault('contactform_mailaddress', $adminemail);
	}


	function getOptionsSupported() {
		$list = array(gettext("required") => "required",gettext("show") => "show",gettext("omitted") => "omitted");
		$mailfieldinstruction = gettext(" Set if the field should be required, just shown or omitted");
		return array(	gettext('Intro text') => array('key' => 'contactform_introtext', 'type' => 3,
										'desc' => gettext("The intro text for your contact form")),
									gettext('Confirm text') => array('key' => 'contactform_confirmtext', 'type' => 3,
										'desc' => gettext("The text that asks the vistior to confirm that he really wants to send the message.")),
									gettext('Thanks text') => array('key' => 'contactform_thankstext', 'type' => 3,
										'desc' => gettext("The text that is shown after a message has been confirmed and sent.")),
									gettext('Mail address') => array('key' => 'contactform_mailaddress', 'type' => 0,
										'desc' => gettext("The e-mail address the messages should be sent to.")),
									gettext('01. Title field') => array('key' => 'contactform_title', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Title field.").$mailfieldinstruction),
									gettext('02. Name field') => array('key' => 'contactform_name', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Name field.").$mailfieldinstruction),
									gettext('03. Company field') => array('key' => 'contactform_company', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Country field.").$mailfieldinstruction),
									gettext('04. Street field') => array('key' => 'contactform_street', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Street field.").$mailfieldinstruction),
									gettext('05. City field') => array('key' => 'contactform_city', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("City field.").$mailfieldinstruction),
									gettext('06. Country field') => array('key' => 'contactform_country', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Country field.").$mailfieldinstruction),
									gettext('07. E-mail field') => array('key' => 'contactform_email', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("E-mail field.").$mailfieldinstruction),
									gettext('08. Website field') => array('key' => 'contactform_website', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Website field.").$mailfieldinstruction),
									gettext('09. Captcha field') => array('key' => 'contactform_captcha', 'type' => 1,
										'desc' => gettext("If Captcha should be required.")),
									gettext('10. Phone field') => array('key' => 'contactform_phone', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Phone number field.").$mailfieldinstruction),
									gettext('11. Subject field') => array('key' => 'contactform_subject', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Subject field.").$mailfieldinstruction),
									gettext('12. Message field') => array('key' => 'contactform_message', 'type' => 4, 'buttons' => $list,
										'desc' => gettext("Message field.").$mailfieldinstruction),
		);
	}
}


/**
 * Retrieves the post field if it exists
 *
 * @param string $field
 * @param int $level
 * @return string
 */
function getField($field, $level=3) {
	if (isset($_POST[$field])) {
		return sanitize($_POST[$field], $level);
	} else {
		return '';
	}
}
/**
 * Prints the mail contact form, handles checks and the mail sending. It uses Zenphoto's check for valid e-mail adress and website url and also supports Captcha.
 * The contact form itself is a separate file and is located within the /contact_form/form.php so that it can be style as needed.
 *
 */
function printContactForm() {
	global $_zp_UTF8, $_zp_captcha;
	$error = array();
	if(isset($_POST['sendmail'])) {
		$mailcontent = array();
		$mailcontent['title'] = getField('title');
		$mailcontent['name'] = getField('name');
		$mailcontent['company'] = getField('company');
		$mailcontent['street'] = getField('street');
		$mailcontent['city'] = getField('city');
		$mailcontent['country'] = getField('country');
		$mailcontent['email'] = getField('email');
		$mailcontent['website'] = getField('website');
		$mailcontent['phone'] = getField('phone');
		$mailcontent['subject'] = getField('subject');
		$mailcontent['message'] = getField('message',1);
		
		// if you want other required fiels or less add/modify their checks here
		if (getOption('contactform_title') == "required" && empty($mailcontent['title'])) { $error[1] = gettext("a <strong>title</strong>"); }
		if (getOption('contactform_name') == "required" && empty($mailcontent['name'])) { $error[2] = gettext("a <strong>name</strong>"); }
		if (getOption('contactform_company') == "required" && empty($mailcontent['company'])) { $error[3] = gettext("a <strong>company</strong>"); }
		if (getOption('contactform_street') == "required" && empty($mailcontent['street'])) { $error[4] = gettext("a <strong>street</strong>"); }
		if (getOption('contactform_city') == "required" && empty($mailcontent['city'])) { $error[5] = gettext("a <strong>city</strong>"); }
		if (getOption('contactform_country') == "required" && empty($mailcontent['country'])) { $error[6] = gettext("a <strong>country</strong>"); }
		if (getOption('contactform_email') == "required" && empty($mailcontent['email']) || !is_valid_email_zp($mailcontent['email'])) { $error[7] = gettext("a <strong>valid email adress</strong>"); }
		if (getOption('contactform_website') == "required" && empty($mailcontent['website'])) {
			$error[8] = gettext('a <strong>website</strong>');
		} else {
			if(!empty($mailcontent['website'])) {
				if (substr($mailcontent['website'], 0, 7) != "http://") {
					$mailcontent['website'] = "http://" . $mailcontent['website'];
				}
			}
		}
		if (getOption("contactform_phone") == "required" && empty($mailcontent['phone'])) { $error[9] = gettext("a <strong>phone number</strong>"); }
		if (getOption("contactform_subject") == "required" && empty($mailcontent['subject'])) { $error[10] = gettext("a <strong>subject</strong>"); }
		if (getOption("contactform_message") == "required" && empty($mailcontent['message'])) { $error[11] = gettext("a <strong>message</strong>"); }
				
		// captcha start
		if(getOption("contactform_captcha")) {
			$code_ok = trim($_POST['code_h']);
			$code = trim($_POST['code']);
			if (!$_zp_captcha->checkCaptcha($code, $code_ok)) { $error[5] = gettext("<strong>the correct captcha verification code</strong>"); } // no ticket
		} 
		// captcha end
		
		// If required fields are empty or not valide print note
		if(count($error) != 0) {
			echo gettext("<p style='color:red'>Please enter ");
			$count = 0;
			foreach($error as $err) {
				$count++;
				if(count($error) > 1) { $separator = ", "; }
				echo $err;
				if($count != count($error)) {
					if ($count === (count($error) - 1)) {
						$separator = gettext(" and ");
					}
					echo $separator;
				}
			}
			echo gettext(". Thanks.</p>");
		} else {
			$mailaddress = $mailcontent['email'];
			$name = $mailcontent['name'];
			$headers = 'From: '.$mailaddress.''."\r\n";
			//$headers .= 'Cc: '.$mailaddress.''."\r\n"; // somehow does not work on all servers!
			$subject = $mailcontent['subject']." (".getBareGalleryTitle().")";
			$message = $mailcontent['message']."\n";
			if(!empty($mailcontent['title'])) { $message .= $mailcontent['title']; }
			if(!empty($mailcontent['name'])) { $message .= $mailcontent['name']."\n"; }
			if(!empty($mailcontent['company'])) { $message .= $mailcontent['company']."\n"; }
			if(!empty($mailcontent['street'])) { $message .= $mailcontent['street']."\n"; }
			if(!empty($mailcontent['city'])) { $message .= $mailcontent['city']."\n"; }
			if(!empty($mailcontent['country'])) { $message .= $mailcontent['country']."\n"; }
			if(!empty($mailcontent['email'])) { $message .= $mailcontent['email']."\n"; }
			if(!empty($mailcontent['phone'])) { $message .= $mailcontent['phone']."\n"; }
			if(!empty($mailcontent['website'])) { $message .= $mailcontent['website']."\n"; }
			$message .= "\n\n";
			echo getOption("contactform_confirmtext");
			?>
<div>
	<form id="confirm" action="<?php echo sanitize($_SERVER['REQUEST_URI']); ?>" method="post" accept-charset="UTF-8" style="float: left">
		<input type="hidden" id="confirm" name="confirm" value="confirm" />
		<input type="hidden" id="subject" name="subject"	value="<?php echo $subject; ?>" />
		<input type="hidden" id="message"	name="message" value="<?php echo $message; ?>" />
		<input type="hidden" id="headers" name="headers" value="<?php echo $headers; ?>" />
		<input type="hidden" id="mailaddress" name="mailaddress" value="<?php echo $mailaddress; ?>" />
		<input type="submit" value="<?php echo gettext("Confirm"); ?>" />
	</form>
	<form id="discard" action="<?php echo sanitize($_SERVER['REQUEST_URI']); ?>" method="post" accept-charset="UTF-8">
		<input type="hidden" id="discard" name="discard" value="discard" />
		<input type="submit" value="<?php echo gettext("Discard"); ?>" />
	</form>
</div>
			<?php
		}
	}
	if(isset($_POST['confirm'])) {
		$subject = sanitize($_POST['subject']);
		$message = sanitize($_POST['message'],1);
		$headers = sanitize($_POST['headers']);
		$mailaddress = sanitize($_POST['mailaddress']);
		$_zp_UTF8->send_mail(getOption("contactform_mailaddress").",".$mailaddress, $subject, $message, $headers);
		echo getOption("contactform_thankstext");
	}
	if (count($error) <= 0) {
		$mailcontent = array();
		$mailcontent['title'] = '';
		$mailcontent['name'] = '';
		$mailcontent['company'] = '';
		$mailcontent['street'] = '';
		$mailcontent['city'] = '';
		$mailcontent['country'] = '';
		$mailcontent['email'] = '';
		$mailcontent['website'] = '';
		$mailcontent['phone'] = '';
		$mailcontent['subject'] = '';
		$mailcontent['message'] ='';
	}
	if (count($error) > 0 || !isset($_POST['sendmail'])) {
		echo getOption("contactform_introtext");
		include(SERVERPATH . "/" . ZENFOLDER . "/plugins/contact_form/form.php");
	}
}

/**
 * Helper function that checks if a field should be shown ("required" or "show") or omitted ("ommitt").
 * Only for the fields set by radioboxes.
 *
 * @param string $option The option value
 * @return bool
 */
function showOrNotShowField($option) {
	if($option == "required" or  $option == "show") {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Helper function that checks if the field is a required one. If it returns '*" to be appended to the field name as an indicator. 
 * Not for the captcha field that is always required if shown...
 *
 * @param string $option the option value
 * @return string
 */
function checkRequiredField($option) {
	if($option == "required") {
		return "*";
	} else {
		return "";
	}
}
?>