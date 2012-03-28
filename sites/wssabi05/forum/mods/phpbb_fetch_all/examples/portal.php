<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## A portal example file.                                                    ##
##                                                                           ##
###############################################################################
##                                                                           ##
## Authors: Volker 'Ca5ey' Rattel <webmaster@phpbbfetchall.com>              ##
##          http://www.phpbbfetchall.com/                                    ##
##                                                                           ##
## This file is free software; you can redistribute it and/or modify it      ##
## under the terms of the GNU General Public License as published  by the    ##
## Free Software Foundation; either version 2, or (at your option) any later ##
## version.                                                                  ##
##                                                                           ##
## This file is distributed in the hope that it will be useful, but WITHOUT  ##
## ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     ##
## FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  ##
## more details.                                                             ##
##                                                                           ##
###############################################################################

//
// This path points to the directory where phpBB is installed. Do
// not enter an URL here. The path must end with a trailing
// slash.
//
// Examples:
// forum in /aaa/bbb/ccc/ and script in /aaa/bbb/ccc/
// --> $phpbb_root_path = './';
// forum in /aaa/bbb/ccc/ and script in /aaa/bbb/
// --> $phpbb_root_path = './ccc/';
// forum in /aaa/bbb/ccc/ and script in /aaa/bbb/ddd/
// --> $phpbb_root_path = '../ccc/';
//

$phpbb_root_path = '../../../';

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

//
// start session management
//

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

//
// since we are demonstrating span pages we need to set the page offset
//

if (isset($HTTP_GET_VARS['start']) or isset($HTTP_POST_VARS['start']))
{
	$CFG['posts_span_pages_offset'] = isset($HTTP_GET_VARS['start'])
	? $HTTP_GET_VARS['start'] : $HTTP_POST_VARS['start'];
	if (!intval($CFG['posts_span_pages_offset']))
	{
		$CFG['posts_span_pages_offset'] = 0;
	}
}

// fetch new posts since last visit
$new_posts = phpbb_fetch_new_posts();

// fetch user online, total posts, etc
$stats = phpbb_fetch_stats();

// fetch online users
$online = phpbb_fetch_online_users();

// fetch five users by total posts
$top_poster = phpbb_fetch_top_poster();

// fetch a random user
$random_user = phpbb_fetch_random_user();

// fetch forum structure
$forums = phpbb_fetch_forums();

// fetch user of a specific group
// This function is disabled because fetching without a specific
// user group can produces a lot of results (all registered users)
// and this may result in an internal server error. If you want to
// use this feature please specify the group id.
#$member = phpbb_fetch_users();

// fetch a poll
$poll = phpbb_fetch_poll();

// fetch a single topic by topic id
// You will need to specify a certain topic id to use this function.
// The first post of that topic will be displayed in a box to the upper right.
#$topic = phpbb_fetch_topics();

// fetch latest postings
$CFG['posts_trim_topic_number'] = 25;
$recent = phpbb_fetch_posts(null, POSTS_FETCH_LAST);

// fetch postings
$CFG['posts_trim_topic_number'] = 0;
$CFG['posts_span_pages']        = true;
$news = phpbb_fetch_posts();

//
// disconnect from the database
//

phpbb_disconnect();

?>
<?php echo '<?xml version="1.0" encoding="iso-8859-1"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC  "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<title><?php echo htmlspecialchars($board_config['sitename']); ?>
Portal</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="<?php echo $phpbb_root_path; ?>templates/subSilver/subSilver.css" type="text/css" />
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5493B4">

<table align="center" border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
<td class="bodyline" valign="top" width="100%">

<table width="100%" cellspacing="0" cellpadding="10" border="0">
<tr>
<td style="background-image:url('<?php echo $phpbb_root_path;
?>mods/phpbb_fetch_all/examples/header_bg.png');
background-repeat:repeat-x;" width="100%" valign="top"><span
class="maintitle"><?php echo
htmlspecialchars($board_config['sitename']); ?> Portal</span><br /><span
class="gen"><?php echo htmlspecialchars($board_config['site_desc']);
?></span></td>
</tr>
</table>

<br />

<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>
<td valign="top" width="25%">

<!-- USER -->
<?php if ($userdata) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Profile']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
<?php if ($userdata['session_logged_in']) { ?>
<table>
<tr>
<td valign="top"><?php echo phpbb_avatar_image($userdata['user_avatar_type'], $userdata['user_avatar']); ?></td>
<td valign="top">
<span class="gensmall">
<?php printf($lang['Welcome_subject'], $board_config['sitename']); ?>, <?php echo $userdata['username']; ?>.<br />
<?php printf($lang['You_last_visit'], create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone'])); ?><p />
</span>
</td>
</tr>
</table>
<span class="gensmall">
<a href="<?php echo append_sid($phpbb_root_path .
'privmsg.php?folder=inbox');?>"><?php
if ($userdata['user_new_privmsg'] == 0) {
echo $lang['No_new_pm']; }
elseif ($userdata['user_new_privmsg'] == 1) {
printf($lang['New_pm'], $userdata['user_new_privmsg']); }
else {
printf($lang['New_pms'], $userdata['user_new_privmsg']); } ?></a><br />
<a href="<?php echo append_sid($phpbb_root_path . 'search.php?search_id=newposts'); ?>"><?php echo $lang['Search_new']; ?> (<?php echo $new_posts['total']; ?>)</a><br />
<a href="<?php echo append_sid($phpbb_root_path . 'search.php?search_id=egosearch'); ?>"><?php echo $lang['Search_your_posts']; ?></a><br />
<a href="<?php echo append_sid($phpbb_root_path . 'search.php?search_id=unanswered'); ?>"><?php echo $lang['Search_unanswered']; ?></a>
</span>
<?php } else { ?>
<span class="gensmall"><?php printf($lang['Welcome_subject'],
$board_config['sitename']); ?>, <?php echo $lang['Guest']; ?>.
<br />&nbsp;<br /> <a href="<?php echo append_sid($phpbb_root_path .
'profile.php?mode=register'); ?>"><?php echo $lang['Register']; ?></a>
</span>
<?php } ?>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- USER -->

<!-- LOGIN -->
<?php if (!$userdata or !$userdata['session_logged_in']) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Login']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="center" width="100%">
<table align="center">
<tr>
<td>
<form action="<?php echo $phpbb_root_path; ?>login.php" method="post" target="_top">
<span class="gensmall">
<?php echo $lang['Username']; ?>:<br />
<input type="text" name="username" size="20" maxlength="40" value="" /><br />
<?php echo $lang['Password']; ?>:<br />
<input type="password" name="password" size="20" maxlength="25" /><br />
<input type="checkbox" name="autologin" /> <?php echo $lang['Log_me_in']; ?>
<br />&nbsp;<br />
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
<input type="hidden" name="redirect" value="<?php echo substr($phpbb_root_path, 0, -1) . $PHP_SELF; ?>" />
<input type="hidden" name="sid" value="<?php echo $userdata['session_id']; ?>" />
<input type="hidden" name="outside" value="1" />
<div align="center"><input type="submit" class="mainoption" name="login" value="<?php echo $lang['Login']; ?>" />
<br />&nbsp;<br />
<a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=sendpassword'); ?>"><?php echo $lang['Forgotten_password']; ?></a></div>
</span>
</form>
</td>
</tr>
</table>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- LOGIN -->

<!-- SEARCH -->
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Search']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="center" width="100%">
<form action="<?php echo append_sid($phpbb_root_path . 'search.php?mode=results'); ?>" method="post" target="_top">
<input type="text" class="post" name="search_keywords" size="20" />&nbsp;
<input type="submit" class="mainoption" name="login" value="<?php echo $lang['Go']; ?>" /><br />
<span class="gensmall">
<a href="<?php echo append_sid($phpbb_root_path . 'search.php'); ?>"><?php echo $lang['Search_options']; ?></a>
</span>
</form>
    </td>
  </tr>
</table>
<br />
<!-- SEARCH -->

<!-- STATS -->
<?php if (isset($stats)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Information']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php printf($lang['Posted_articles_total'], $stats['total_posts']); ?><br />
<?php printf($lang['Registered_users_total'], $stats['total_users']); ?><br />
<?php printf($lang['Newest_user'], '<a href="' . append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $stats['user_id']) . '">', $stats['username'], '</a>'); ?>
      </span>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- STATS -->

<!-- ONLINE USERS -->
<?php if (isset($online)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Who_is_Online']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php for ($i = 0; $i < count($online); $i++) { ?>
<a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $online[$i]['user_id']); ?>"><?php echo $online[$i]['username']; ?></a><?php if ($i < count($online) - 1) { ?>, <?php } ?>
<?php } ?>
<?php if ($i) { ?>, <?php } ?>
<?php if ($stats['user_online'] - $i == 1) { printf($lang['Guest_user_total'], $stats['user_online'] - $i); }
 else { printf($lang['Guest_users_total'], $stats['user_online'] - $i); } ?>
      </span>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- ONLINE USERS -->

<!-- TOP POSTER -->
<?php if (isset($top_poster)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Sort_Top_Ten']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
<table>
<?php for ($i = 0; $i < count($top_poster); $i++) { ?>
<tr>
<td><span class="gensmall">#<?php echo ($i+1); ?></span></td>
<td width="100%"><span class="gensmall"><a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $top_poster[$i]['user_id']); ?>"><?php echo $top_poster[$i]['username']; ?></a></span></td>
<td align="right"><span class="gensmall"><?php echo $top_poster[$i]['user_posts']; ?></span></td>
</tr>
<?php } ?>
</table>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- TOP POSTER -->

<!-- RANDOM USER -->
<?php if (isset($random_user)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php printf($lang['About_user'], $random_user['username']); ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php printf($lang['Viewing_user_profile'], '<a href="' . append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $random_user['user_id']). '"><b>' . $random_user['username'] . '</b></a>'); ?><br />
      </span>
<?php if ($random_user['user_avatar_type'] > 0) { ?>
<table>
<tr>
<td valign="top"><?php echo phpbb_avatar_image($random_user['user_avatar_type'], $random_user['user_avatar']); ?></td>
<td valign="top">
<?php } ?>
<span class="gensmall">
<?php echo $lang['Joined']; ?>: <?php
$since = intval((time() - $random_user['user_regdate']) / 86400);
if ($since == 0) {
echo 'today';
} elseif ($since == 1) {
echo '1 day';
} else {
echo $since . ' ' . $lang['Days'];
} ?><br />
<?php echo $lang['Posts']; ?>: <?php echo $random_user['user_posts']; ?><br />
<?php echo $lang['Location']; ?>: <?php echo $random_user['user_from']; ?><br />
</span>
<?php if ($random_user['user_avatar_type'] > 0) { ?>
</td>
</tr>
</table>
<?php } ?>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- RANDOM USER -->

</td>
<td valign="top" width="50%">

<!-- FORUMS -->
<?php if (isset($forums)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <th class="thTop" height="28"><?php echo $lang['Forum']; ?></th>
    <th class="thTop" height="28"><?php echo $lang['Topics']; ?></th>
    <th class="thTop" height="28"><?php echo $lang['Posts']; ?></th>
  </tr>
<?php $last_cat = -1; ?>
<?php for ($i = 0; $i < count($forums); $i++) { ?>
<?php if ($last_cat != $forums[$i]['cat_id']) { ?>
<?php $last_cat = $forums[$i]['cat_id']; ?>
  <tr>
    <td class="catLeft" colspan="3" height="28"><span class="cattitle"><a href="<?php echo append_sid($phpbb_root_path . 'index.php?c=' . $forums[$i]['cat_id']); ?>" class="cattitle"><?php echo $forums[$i]['cat_title']; ?></a></span></td>
  </tr>
<?php } ?>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="forumlink">
      <a href="<?php echo append_sid($phpbb_root_path . 'viewforum.php?f=' . $forums[$i]['forum_id']); ?>" class="forumlink"><?php echo $forums[$i]['forum_name']; ?></a><br />
      </span>
      <span class="genmed">
<?php echo $forums[$i]['forum_desc']; ?>
      </span>
    </td>
    <td class="row1" align="center" width="100%">
      <span class="genmed">
<?php echo $forums[$i]['forum_topics']; ?>
      </span>
    </td>
    <td class="row1" align="center" width="100%">
      <span class="genmed">
<?php echo $forums[$i]['forum_posts']; ?>
      </span>
    </td>
  </tr>
<?php } ?>
</table>
<br />
<?php } ?>
<!-- FORUMS -->

<!-- SPAN PAGES -->
<div align="right">
<span class="gensmall"><b><?php echo phpbb_span_pages($CFG['posts_span_pages_numrows'], $CFG['posts_limit'], $CFG['posts_span_pages_offset'], false); ?></b></span>
</div>
<!-- SPAN PAGES -->

<br />

<!-- NEWS -->
<?php for ($i = 0; $i < count($news); $i++) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <th class="thTop" height="28"><?php echo $news[$i]['topic_title']; ?><?php if ($news[$i]['topic_trimmed']) { echo '...'; } ?></th>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php echo $lang['Author']; ?>:
<a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $news[$i]['user_id']); ?>">
<?php echo $news[$i]['username']; ?></a> ::
<?php echo $lang['Posted']; ?>:
<?php echo create_date($board_config['default_dateformat'], $news[$i]['post_time'], $board_config['board_timezone']); ?>
      </span>
      <span class="gen">
<hr size="1"/>
<?php echo $news[$i]['post_text']; ?><?php if ($news[$i]['trimmed']) { echo '...'; } ?>
      </span>
<hr size="1"/>
      <span class="gensmall">
<div align="right"><font color="#333333" face="Verdana" size="1">(<?php echo $news[$i]['topic_replies']; ?>)
<a href="<?php echo append_sid($phpbb_root_path . 'viewtopic.php?t=' . $news[$i]['topic_id']); ?>">
<?php echo $lang['Replies']; ?></a></font></div>
      </span>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- NEWS -->

<!-- SPAN PAGES -->
<div align="right">
<span class="gensmall"><b><?php echo phpbb_span_pages($CFG['posts_span_pages_numrows'], $CFG['posts_limit'], $CFG['posts_span_pages_offset'], false); ?></b></span>
</div>
<!-- SPAN PAGES -->

</td>
<td valign="top" width="25%">

<!-- TOPIC -->
<?php if (isset($topic) and !empty($topic)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $topic[0]['topic_title']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php echo $topic[0]['post_text']; ?>
      </span>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- TOPIC -->

<!-- RECENT -->
<?php if (isset($recent)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Topics']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php for ($i = 0; $i < count($recent); $i++) { ?>
<?php echo create_date($board_config['default_dateformat'], $recent[$i]['post_time'], $board_config['board_timezone']); ?> <a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $recent[$i]['user_id']); ?>"><?php echo $recent[$i]['username']; ?></a><br /><img src="<?php echo $phpbb_root_path; ?>templates/subSilver/images/icon_latest_reply.gif" border="0" align="absmiddle" /> <a href="<?php echo append_sid($phpbb_root_path . 'viewtopic.php?p=' . $recent[$i]['post_id'] . '#' . $recent[$i]['post_id']); ?>"><b><?php echo $recent[$i]['topic_title']; ?><?php if ($recent[$i]['topic_trimmed']) { echo '...'; } ?></b></a><br />
<?php } ?>
      </span>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- RECENT -->

<!-- POLL -->
<?php if (isset($poll)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $lang['Poll_question']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="center" width="100%">
<?php if (!$poll) { ?>
<span class="gensmall"><b>No poll at the moment.</b></span>
<?php } else { ?>
<span class="gensmall"><b><?php echo $poll['vote_text']; ?></b></span>
</font>
<form method="post" action="<?php echo append_sid($phpbb_root_path . 'posting.php?t=' . $poll['topic_id']); ?>">
<table>
<?php for ($i = 0; $i < count($poll['options']); $i++) { ?>
<tr>
<td>
<input type="radio" name="vote_id" value="<?php echo $poll['options'][$i]['vote_option_id']; ?>">
</td>
<td>
<span class="gensmall"><?php echo $poll['options'][$i]['vote_option_text']; ?></span>
</td>
<td nowrap="nowrap">
<span class="gensmall">[&nbsp;<?php echo $poll['options'][$i]['vote_result']; ?>&nbsp;]</span>
</td>
</tr>
<?php } ?>
</table>
<?php if ($userdata['session_logged_in']) { ?>
<input type="submit" class="mainoption" name="submit" value="<?php echo $lang['Submit_vote']; ?>">
<input type="hidden" name="topic_id" value="<?php echo $poll['topic_id']; ?>">
<input type="hidden" name="mode" value="vote">
<?php } else { ?>
<span class="gensmall"><?php echo $lang['Rules_vote_cannot']; ?></span>
<?php } ?>
<br />
<span class="gensmall"><a href="<?php echo append_sid($phpbb_root_path . 'viewtopic.php?t=' . $poll['topic_id'] . '&amp;vote=viewresult'); ?>"><?php echo $lang['View_results']; ?></a></span>
</form>
<?php } ?>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- POLL -->


<!-- MEMBER -->
<?php if (isset($member)) { ?>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <td class="catHead" height="28"><span class="cattitle"><?php echo $member[0]['group_name']; ?></span></td>
  </tr>
  <tr>
    <td class="row1" align="left" width="100%">
      <span class="gensmall">
<?php for ($i = 0; $i < count($member); $i++) { ?>
<a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $member[$i]['user_id']); ?>"><b><?php echo $member[$i]['username']; ?></b></a><?php if ($i < (count($member)-1)) { ?>,
<?php } ?>
<?php } ?>
      </span>
    </td>
  </tr>
</table>
<br />
<?php } ?>
<!-- MEMBER -->

</td>
</tr>
</table>

<div align="center"><span class="copyright"><br />
Powered by <a href="http://www.phpbb.com/" target="_phpbb" class="copyright">phpBB</a> <?php echo '2' . $board_config['version']; ?> &copy; 2001, 2002 phpBB Group.<br />
Fetched by <a href="http://www.phpbbfetchall.com/" target="_blank" class="copyright">phpBB Fetch All</a> <?php echo $CFG['version']; ?></span></div>
</td>
</tr>
</table>

</body>
</html>
