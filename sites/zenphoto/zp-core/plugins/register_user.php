<?php
/**
 * Provides a means where visitors can register and get limited site privileges.
 *
 * Place a call on printRegistrationForm() where you want the form to appear.
 * Probably the best use is to create a new 'custom page' script just for handling these
 * user registrations. Then put a link to that script on your index page so that people
 * who wish to register will click on the link and be taken to the registration page.
 * 
 * When successfully registered, a new admin user will be created with no logon rights. An e-mail
 * will be sent to the user with a link to activate the user ID. When he clicks on that link
 * he will be taken to the registration page and the verification process will be completed. 
 * At this point the user ID rights is set to the value of the plugin default user rights option 
 * and an email is sent to the Gallery admin announcing the new registration.
 * 
 * NOTE: If you change the rights on a user pending verification you have verified the user.
 *
 * @author Stephen Billard (sbillard)
 * @version 1.0.0
 * @package plugins
 */

$plugin_description = gettext("Provides a means for placing a user logout link on your theme pages.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0.0';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---register_user.php.html";
$option_interface = new register_user_options();

/**
 * Plugin option handling class
 *
 */
class register_user_options {

	function register_user_options() {
		setOptionDefault('register_user_rights', NO_RIGHTS);
		setOptionDefault('register_user_notify', 1);
	}

	function getOptionsSupported() {
		return array(	gettext('Default user rights') => array('key' => 'register_user_rights', 'type' => 4,
										'buttons' => array(gettext('No rights') => NO_RIGHTS, gettext('View Rights') => VIEWALL_RIGHTS | NO_RIGHTS),
										'desc' => gettext("Initial rights for the new user.<br />Set to <em>No rights</em> if you want to approve the user.<br />Set to <em>View Rights</em> to allow viewing the gallery once the user is verified.")),
									gettext('Notify') => array('key' => 'register_user_notify', 'type' => 1, 
										'desc' => gettext('If checked, an e-mail notification is sent on new user registration.'))
		);
	}
	function handleOption($option, $currentValue) {
	}
}

if (!OFFSET_PATH) { // handle form post
	if (isset($_GET['verify'])) {
		$currentadmins = getAdministrators();
		$params = unserialize(pack("H*", $_GET['verify']));
		$adminuser = NULL;
		foreach ($currentadmins as $admin) {
			if ($admin['user'] == $params['user'] && $admin['email'] == $params['email']) {
				$adminuser = $admin;
				break;
			}
		}
		if (!is_null($adminuser)) {
			$rights = getOption('register_user_rights');
			saveAdmin($adminuser['user'], NULL, $admin_n = $adminuser['name'], $admin_e = $adminuser['email'], $rights, NULL);
			if (getOption('register_user_notify')) {
				zp_mail(gettext('Zenphoto Gallery registration'),
				sprintf(gettext('%1$s (%2$s) has registered for the zenphoto gallery providing an e-mail address of %3$s.'),$admin_n, $adminuser['user'], $admin_e));
			}
			$notify = 'verified';
		} else {
			$notify = 'not_verified';
		}
	}
	if (isset($_POST['register_user'])) {
		$pass = trim($_POST['adminpass']);
		$user = trim($_POST['adminuser']);
		$admin_n = trim($_POST['admin_name']);
		$admin_e = trim($_POST['admin_email']);
		if (!empty($user) && !(empty($admin_n)) && !empty($admin_e)) {
			if ($pass == trim($_POST['adminpass_2'])) {
				if (empty($pass)) {
					$pwd = null;
				} else {
					$pwd = passwordHash($_POST['adminuser'], $pass);
				}
				$notify = '';
				$currentadmins = getAdministrators();
				foreach ($currentadmins as $admin) {
					if ($admin['user'] == $user) {
						$notify = 'exists';
						break;
					}
				}
				if (!is_valid_email_zp($admin_e)) {
					$notify = 'invalidemail';
				}
				if (empty($notify)) {
					saveAdmin($user, $pwd, $admin_n, $admin_e, 0, NULL);
					$link = FULLWEBPATH.'/index.php?p='.substr($_zp_gallery_page,0, -4).'&verify='.bin2hex(serialize(array('user'=>$user,'email'=>$admin_e)));
					$message = sprintf(gettext('You have received this email because you registered on the site. To complete your registration visit %s.'), $link);
					$headers = "From: " . get_language_string(getOption('gallery_title'), getOption('locale')) . "<zenphoto@" . $_SERVER['SERVER_NAME'] . ">";
					$_zp_UTF8->send_mail($admin_e, gettext('Registration confirmation'), $message, $headers);
					$notify = 'accepted';
				}
			} else {
				$notify = 'mismatch';
			}
		} else {
			$notify = 'incomplete';
		}
	}
}

/**
 * places the user registration form
 *
 * @param string $thanks the message shown on successful registration
 */
function printRegistrationForm($thanks=NULL) {
	global $notify, $admin_e, $admin_n, $user;
	if (zp_loggedin()) {
		if (isset($_GET['userlog']) && $_GET['userlog'] == 1) {
			echo '<meta HTTP-EQUIV="REFRESH" content="0; url=/">';
		} else {
			echo '<div class="errorbox" id="fade-message">';
			echo  '<h2>'.gettext("you are already logged in.").'</h2>';
			echo '</div>';
		}
		return;
	}
	if (isset($notify)) {
		if ($notify == 'verified' || $notify == 'accepted') {
			if ($notify == 'verified') {
				if (is_null($thanks)) $thanks = gettext("Thank you for registering.");
			} else {
				$thanks = gettext('An email has been sent to you to verify your email address.');
			}
			echo '<div class="Messagebox" id="fade-message">';
			echo  '<h2>'.gettext('Your registration has been accepted.').'</h2>';
			echo  '<p>'.$thanks.'</p>';
			echo '</div>';
			if (function_exists('printUserLogout') && $notify == 'verified') {
				?>
				<p><?php echo gettext('You may now log onto the site.'); ?></p>
				<?php
				printPasswordForm('', false, true);
			}
			$notify = 'success';
		} else {
			echo '<div class="errorbox" id="fade-message">';
			echo  '<h2>'.gettext("Registration failed.").'</h2>';
			echo '<p>';
			switch ($notify) {
				case 'exists':
					echo gettext('The user ID you chose is already in use.');
					break;
				case 'mismatch':
					echo gettext('Your passwords did not match.');
					break;
				case 'incomplete':
					echo gettext('You have not filled in all the fields.');
					break;
				case 'notverified':
					echo gettext('Invalid verification link.');
					break;
				case 'invalidemail':
					echo gettext('Enter a valid email address.');
					break;
			}
			echo '</p>';
			echo '</div>';
		}
	}
	if ($notify != 'success') {
		require_once(dirname(__FILE__).'/'.substr(basename(__FILE__), 0, -4).'/'.'register_user_form.php');
	}
}
?>