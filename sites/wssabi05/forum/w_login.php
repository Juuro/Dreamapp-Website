<?php
$phpbb_root_path = './forum/';

define ('IN_PHPBB', true);

if (!file_exists($phpbb_root_path . 'extension.inc'))
{
	die ('<tt><b>phpBB Fetch All:</b>
		$phpbb_root_path is wrong and does not point to your forum.</tt>');
}
//
// phpBB related files
//

include_once ($phpbb_root_path . 'extension.inc');
include_once ($phpbb_root_path . 'common.' . $phpEx);
include_once ($phpbb_root_path . 'includes/bbcode.' . $phpEx);

//
// Fetch All related files - we do need all these because the portal is a
// huge example
//

include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/common.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/stats.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/users.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/polls.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/posts.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/forums.' . $phpEx);
?>

<table align="center">
        
  <tr> 
    <td> <form action="<?php echo $phpbb_root_path; ?>login.php" method="post" target="_top">
        <blockquote>
          <div align="left"><span class="gensmall">Username:<br />
            <input type="text" name="username" size="20" maxlength="40" value="" />
            <br />
            Passwort:<br />
            <input type="password" name="password" size="20" maxlength="25" />
            <br />
            <input type="checkbox" name="autologin" />
            Beim nächsten mal automatisch einloggen <br />
            &nbsp;<br />
            <?php
   //
   // NOTE: Redirecting to the portal after login works only
   // if the portal.php is within your phpBB2 root folder. If
   // you move the portal.php outside the root folder you will
   // have to change the redirect value by hand. See also
   // http://www.phpbbfetchall.com/docs/redirecting/
   // for further information.
   //
?>
            <input type="hidden" name="redirect" value="<?php echo substr(0, -1) . $PHP_SELF; ?>" />
            <input type="hidden" name="sid" value="<?php echo $userdata['session_id']; ?>" />
            <input type="hidden" name="outside" value="1" />
            </span> <span class="gensmall"> 
            <input type="submit" class="mainoption" name="login" value="Login" />
            <br />
            &nbsp;<br />
            <a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=sendpassword'); ?>"><?php echo $lang['Forgotten_password']; ?></a></span></div>
        </blockquote>
      </form></td>
        </tr>
      </table>