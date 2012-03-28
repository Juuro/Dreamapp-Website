<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions common for all other modules.              ##
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

###############################################################################
## CONFIGURATION
###############################################################################

//
// URL to your smilie directory without trailing slash.
//

$CFG['smilie_url'] = $phpbb_root_path . 'images/smiles';

//
// Allows you to override the smilie settings in a posting.
// true = enabled
// false = disabled
//

$CFG['enable_smilies'] = true;

//
// URL to your avatar directory without trailing slash.
//
// NOTE: THIS IS DEPRECATED SINCE VERSION 2.0.4 AND REMAINS HERE FOR
//       BACKWARD COMPATIBILITY ONLY. YOU DO NOT NEED THIS OPTION ANY
//       MORE SINCE IT WILL BE AUTOMATICALLY HANDLED BY
//       phpbb_avatar_image()
//

$CFG['avatar_url'] = $phpbb_root_path . 'images/avatars';

//
// URL to your avatar gallery directory without trailing slash.
//
// NOTE: THIS IS DEPRECATED SINCE VERSION 2.0.4 AND REMAINS HERE FOR
//       BACKWARD COMPATIBILITY ONLY. YOU DO NOT NEED THIS OPTION ANY
//       MORE SINCE IT WILL BE AUTOMATICALLY HANDLED BY
//       phpbb_avatar_image()
//

$CFG['avatar_gallery_url'] = $phpbb_root_path . 'images/avatars/gallery';

//
// When set to true the script will check postings and other
// things against the permissions of the user who views the
// script. If no permission for the particular action exists the
// script will not fetch and display the data.
//
// true  = enabled (default)
// false = disabled
//
// IMPORTANT: Using auth check will require these two lines in
//            your script to work properly:
//
// $userdata = session_pagestart($user_ip, PAGE_INDEX);
// init_userprefs($userdata);
//

$CFG['auth_check'] = true;

//
// If you want to adjust the time in the output to reflect your
// local time you can set your time zone here. You can use this
// variable later on in the output to adjust all the time and
// date values.
//
// server time 00:00
// local time  01:00
// $CFG['time_zone'] = 1 * 3600;
//
// server time 01:00
// local time  00:00
// $CFG['time_zone'] = -1 * 3600;
//

$CFG['time_zone'] = 0 * 3600;

//
// This lets you specify the date format in the output.
// See http://www.php.net/date for a reference.
//

$CFG['date_format'] = 'd.m.';

//
// This lets you specify the time format in the output.
// See http://www.php.net/date for a reference.
//

$CFG['time_format'] = 'H:i';

//
// This can be set to determine the behaviour of the script if an
// error occurs.
//
// die      = uses PHP die() function (default)
// phpbb    = uses phpBB message_die() function
// redirect = uses a redirect to another page
//
// Setting this to die will produces a white page, setting this
// to phpbb will give you a phpBB error page and setting this to
// redirect will make your visitors see (for example) a nice
// 'this site is offline' page. This is useful if your database
// is sometimes down. ;)
//

$CFG['on_error'] = 'die';

//
// You can specify the URL to which will be redirected in case of
// an error.
//

$CFG['redirect'] = '';

//
// Turn on/off additional error messages (i.e. SQL dump)
//
// true  = enabled (default)
// false = disabled
//

$CFG['debug'] = true;

###############################################################################
## NO CHANGES NEEDED BELOW
###############################################################################

$CFG['version'] = '2.0.14';
$CFG['auth_list'] = array();
$CFG['auth_called'] = false;

//
// prevent hacking attempt
//

if (!defined('IN_PHPBB'))
{
	die ('hacking attempt');
}

###############################################################################
##                                                                           ##
## phpbb_raise_error()                                                       ##
## ------------------------------------------------------------------------- ##
## Produces an error message or redirects the browser to a given URL. You    ##
## can use this function for your entire site to ensure that all scripts     ##
## exits nicely on an error. The redirect option will forward the browser to ##
## another page which is very useful if (for example) the database is down   ##
## and you want to show a 'site offline' page automatically.                 ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     message                                                               ##
##                                                                           ##
##         The error message.                                                ##
##                                                                           ##
##     file                                                                  ##
##                                                                           ##
##         File name; use __FILE__ if you call this function from your own   ##
##         scripts.                                                          ##
##                                                                           ##
##     line                                                                  ##
##                                                                           ##
##         Line number; use __LINE__ if you call this function from your own ##
##         scripts.                                                          ##
##                                                                           ##
##     sql                                                                   ##
##                                                                           ##
##         SQL query string which will be print if $CFG['debug'] is set to   ##
##         true                                                              ##
##                                                                           ##
###############################################################################

function phpbb_raise_error($message = null, $file = null, $line = null,
	$sql = null)
{
	global $CFG;

	if ($CFG['debug'] and $sql)
	{
		$message .= '<br />&nbsp;<br />SQL: ' . $sql . '<br />&nbsp;<br />';
	}

	switch ($CFG['on_error'])
	{
		//
		// page redirect
		//

		case 'redirect':
			if ($CFG['redirect'])
			{
				header ('Location: ' . $CFG['redirect']);
			}
			else
			{
				$CFG['on_error'] = 'die';
				phpbb_raise_error($message, $file, $line, $sql);
			}
			break;

		//
		// phpBB's message_die()
		//

		case 'phpbb':
			message_die(GENERAL_MESSAGE,
				'<b>phpbb Fetch All error:</b> ' . $message, '',
				 __FILE__, __LINE__);
			break;

		//
		// PHP's die()
		//

		default:
			die('<tt><b>phpbb Fetch All error:</b> ' . $message . ' at '
				. $file . ':' . $line . '</tt>');
	}

	exit;
} // end func phpbb_raise_error

###############################################################################
##                                                                           ##
## phpbb_fetch_row()                                                         ##
## ------------------------------------------------------------------------- ##
## Performs a SQL database query and returns the result in a single array    ##
## like this                                                                 ##
##                                                                           ##
##     $result['field1']                                                     ##
##     $result['field2']                                                     ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     sql                                                                   ##
##                                                                           ##
##         the SQL statement                                                 ##
##                                                                           ##
###############################################################################

function phpbb_fetch_row($sql = null)
{
	global $db;

	if (!$sql)
	{
		return;
	}

	$query = phpbb_query($sql);

	$result = $db->sql_fetchrow($query);

	return $result;
} // end func phpbb_fetch_row

###############################################################################
##                                                                           ##
## phpbb_fetch_rows()                                                        ##
## ------------------------------------------------------------------------- ##
## Performs a SQL database query and returns the result in a multi-          ##
## dimensional array like this                                               ##
##                                                                           ##
##     $result[0]['field1']                                                  ##
##     $result[0]['field2']                                                  ##
##     $result[1]['field1']                                                  ##
##     $result[1]['field2']                                                  ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     sql                                                                   ##
##                                                                           ##
##         the SQL statement                                                 ##
##                                                                           ##
###############################################################################

function phpbb_fetch_rows($sql = null)
{
	global $db;

	if (!$sql)
	{
		return;
	}

	$query = phpbb_query($sql);

	$result = array();

	while ($row = $db->sql_fetchrow($query))
	{
		$result[] = $row;
	}

	return $result;
} // end func phpbb_fetch_rows

###############################################################################
##                                                                           ##
## phpbb_query()                                                             ##
## ------------------------------------------------------------------------- ##
## Executes a query through the phpBB DB API and returns the result. On an   ##
## error phpbb_raise_error() will be called so you can make your own error   ##
## handler with this.                                                        ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     sql                                                                   ##
##                                                                           ##
##         the SQL query statement                                           ##
##                                                                           ##
###############################################################################

function phpbb_query($sql = null)
{
	global $db;

	if (!$query = $db->sql_query($sql))
	{
		phpbb_raise_error('database query failed', __FILE__, __LINE__, $sql);
	}

	return $query;
} // end func phpbb_query

###############################################################################
##                                                                           ##
## phpbb_numrows()                                                           ##
## ------------------------------------------------------------------------- ##
## Returns the number of rows in the result of a query.                      ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     query                                                                 ##
##                                                                           ##
##         the DB handle to the query                                        ##
##                                                                           ##
###############################################################################

function phpbb_numrows($query = null)
{
	global $db;

	return $db->sql_numrows($query);
} // end func phpbb_numrows

###############################################################################
##                                                                           ##
## phpbb_disconnect()                                                        ##
## ------------------------------------------------------------------------- ##
## Disconnects from the database using the phpBB DB API.                     ##
##                                                                           ##
###############################################################################

function phpbb_disconnect()
{
	global $db;

	$db->sql_close();
} // end func phpbb_disconnect

###############################################################################
##                                                                           ##
## phpbb_parse_text()                                                        ##
## ------------------------------------------------------------------------- ##
## Parses text according to phpBB (BBCode, smilies, etc).                    ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     text                                                                  ##
##                                                                           ##
##         the text to be parsed                                             ##
##                                                                           ##
##     bbcode_uid                                                            ##
##                                                                           ##
##         bbcode identifier                                                 ##
##                                                                           ##
##     enable_smilies                                                        ##
##                                                                           ##
##         If true all smilies will be parsed with their icon                ##
##         otherwise you will only see the smilie code.                      ##
##                                                                           ##
##     enable_bbcode                                                         ##
##                                                                           ##
##         If true all bbcodes will be parsed otherwise they won't. The      ##
##         global board setting will overwrite this function.                ##
##                                                                           ##
##     enable_html                                                           ##
##                                                                           ##
##         If true html codes will be parsed otherwise they won't. The       ##
##         global board setting will overwrite this function.                ##
##                                                                           ##
##     hide_images                                                           ##
##                                                                           ##
##         If false all images will be left untouched otherwise all          ##
##         images will be replaced with the text in the next                 ##
##         parameter.                                                        ##
##                                                                           ##
##     replace_images                                                        ##
##                                                                           ##
##         text to replace images with                                       ##
##                                                                           ##
###############################################################################

function phpbb_parse_text($text = null,
	$bbcode_uid = null,
	$enable_smilies = true,
	$enable_bbcode = true,
	$enable_html = true,
	$hide_images = false,
	$replace_images = '')
{
	global $CFG;

	if (!$text)
	{
		return;
	}

	//
	// remove slashes
	//

	stripslashes($text);

	//
	// remove images if requested
	//

	if ($hide_images)
	{
		if ($replace_images)
		{
			$replacement = '[url=\\1]' . $replace_images . '[/url]';
		}
		else
		{
			$replacement = '';
		}
		$text =
			preg_replace("#\[img:$bbcode_uid\](.*?)\[/img:$bbcode_uid\]#si",
				$replacement, $text);
	}

	//
	// parse html
	//

	if (!$enable_html)
	{
		$text = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;",
			$text);
	}

	//
	// parse bbcode
	//

	if ($enable_bbcode)
	{
		$text = bbencode_second_pass($text, $bbcode_uid);
	}
	else
	{
		$text = preg_replace('/\:[0-9a-z\:]+\]/si', ']', $text);
	}

	//
	// parse smilies if requested
	//

	if ($enable_smilies == 1 and $CFG['enable_smilies'] == true)
	{
		$text = smilies_pass($text);

		//
		// need to overwrite the smilie path since we might not be
		// within the phpBB directory
		//

		$text = preg_replace("/images\/smiles/", $CFG['smilie_url'],
			$text);
	}

	//
	// parse url's
	//

	$text = make_clickable($text);

	//
	// change newlines to HTML
	//

	$text = str_replace("\n", "\n<br />\n", $text);

	return $text;
} // end func phpbb_parse_text

###############################################################################
##                                                                           ##
## phpbb_trim_text()                                                         ##
## ------------------------------------------------------------------------- ##
## This function can trim a text by number of characters or the first        ##
## appearence of a character combination.                                    ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     text                                                                  ##
##                                                                           ##
##         contains the text which should be trimmed                         ##
##                                                                           ##
##     is_trimmed                                                            ##
##                                                                           ##
##         will be false if no trimming has been done and true if the text   ##
##         has been trimmed                                                  ##
##                                                                           ##
##     character                                                             ##
##                                                                           ##
##         a character combination ('<br />')                                ##
##                                                                           ##
##     number                                                                ##
##                                                                           ##
##         a number of characters ('150')                                    ##
##                                                                           ##
##     words                                                                 ##
##                                                                           ##
##         a number of words ('5')                                           ##
##                                                                           ##
###############################################################################

function phpbb_trim_text(&$text,
	&$is_trimmed,
	$character = null,
	$number = 0,
	$words = 0)
{
	//
	// trim by character combination
	//

	if ($character != '' and eregi($character, $text))
	{
		$trimmed    = explode($character, $text);
		$text       = $trimmed[0];
		$is_trimmed = true;
	}

	//
	// trim by number
	//

	if ($number != 0 and strlen($text) > $number)
	{
		$text       = substr($text, 0, $number);
		$is_trimmed = true;
	}

	//
	// trim by words
	//

	if ($words != 0)
	{
		$exploded = explode(' ', $text);
		if (count($exploded) > $words)
		{
			$text = '';
			for ($i = 0; $i < $words; $i++)
			{
				$text .= $exploded[$i] . ' ';
			}
			$text = substr($text, 0, -1);
			$is_trimmed = true;
		}
	}

	return true;
} // end func phpbb_trim_text

###############################################################################
##                                                                           ##
## phpbb_span_pages()                                                        ##
## ------------------------------------------------------------------------- ##
## Calculates the span pages. Returns a string with all available pages like ##
##                                                                           ##
##     Goto page 1,2,3 Next                                                  ##
##                                                                           ##
## The 'goto page' is being set by your local language setup. The string is  ##
## being formatted and contains a link on the calling script (PHP_SELF).     ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     numrows                                                               ##
##                                                                           ##
##        number of rows of the result query                                 ##
##                                                                           ##
##     limit                                                                 ##
##                                                                           ##
##        number of entries to show on one page                              ##
##                                                                           ##
##     offset                                                                ##
##                                                                           ##
##        number of entry from which the output starts                       ##
##                                                                           ##
##     add_prevnext_text                                                     ##
##                                                                           ##
##        true  = adds the previous/next text                                ##
##        false = do not add it                                              ##
##                                                                           ##
###############################################################################

function phpbb_span_pages($numrows = 0,
	$limit = 0,
	$offset = 0,
	$add_prevnext_text = true)
{
	global $PHP_SELF;

	//
	// avoid a division by zero error from phpBB
	//

	if ($limit == 0)
	{
		$limit = 100;
	}

	//
	// do a little string replace to fix the original output of the phpBB
	// pagination function (replace '&' with '?')
	//

	$result = eregi_replace('&amp;start',
	'start',
	generate_pagination($PHP_SELF . '?',
		$numrows,
		$limit,
		$offset,
		$add_prevnext_text));

	return $result;
} // end func phpbb_span_pages

###############################################################################
##                                                                           ##
## phpbb_get_auth_list()                                                     ##
## ------------------------------------------------------------------------- ##
## This function will fetch the list of forums which the user is able to     ##
## 'view'. The list will be saved within $CFG['auth_list'] so it is global   ##
## available for every function. This function will run only once to reduce  ##
## SQL queries.                                                              ##
##                                                                           ##
###############################################################################

function phpbb_get_auth_list()
{
	global $CFG, $userdata;

	if (!$CFG['auth_called'] and $CFG['auth_check'])
	{
		$is_auth = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

		while (list($k, $v) = each($is_auth))
		{
			if ($v['auth_view'])
			{
				$CFG['auth_list'][] = $k;
			}
		}

		$CFG['auth_called'] = true;
	}

	return true;
} // end func phpbb_get_auth_list

###############################################################################
##                                                                           ##
## phpbb_get_forum_list()                                                    ##
## ------------------------------------------------------------------------- ##
## This function will create a list of forums based on the forums passed as  ##
## a parameter and the forums which are in $CFG['auth_list']. Basically it   ##
## will filter the forums passed by against the allowed forums (if auth      ##
## check is enabled).                                                        ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     forum_id                                                              ##
##                                                                           ##
##         A single forums id or an array of multiple id's.                  ##
##                                                                           ##
###############################################################################

function phpbb_get_forum_list($forum_id = null)
{
	global $CFG;

	$result = '';

	if (!$forum_id and $CFG['auth_check'])
	{
		reset($CFG['auth_list']);

		while (list($k, $v) = each($CFG['auth_list']))
		{
			$result .= $v . ',';
		}

		if ($result)
		{
			$result = substr($result, 0, strlen($result) -1);
		}
	}

	if ($forum_id)
	{
		if (!is_array($forum_id))
		{
			if (!intval($forum_id))
			{
				phpbb_raise_error('Forum ID must be a numeric value.',
					__FILE__, __LINE__);
			}

			if ($CFG['auth_check'])
			{
				if (in_array($forum_id, $CFG['auth_list']))
				{
					$result = $forum_id;
				}
			}
			else
			{
				$result = $forum_id;
			}
		}
		else
		{
			for ($i = 0; $i < count($forum_id); $i++)
			{
				if (!intval($forum_id[$i]))
				{
					phpbb_raise_error('Forum ID must be a numeric value.',
						__FILE__, __LINE__);
				}

				if ($CFG['auth_check'])
				{
					if (in_array($forum_id[$i], $CFG['auth_list']))
					{
						$result .= $forum_id[$i] . ',';
					}
				}
				else
				{
					$result .= $forum_id[$i] . ',';
				}
			}
			if ($result)
			{
				$result = substr($result, 0, strlen($result) -1);
			}
		}
	}

	//
	// exclude forums from result?
	//

	if ($result and isset($CFG['posts_exclude_forums']))
	{
		if (!is_array($CFG['posts_exclude_forums']))
		{
			$CFG['posts_exclude_forums'] = array($CFG['posts_exclude_forums']);
		}

		$arr = explode(',', $result);
		$result = '';

		while (list($k, $v) = each($arr))
		{
			if (!in_array($v, $CFG['posts_exclude_forums']))
			{
				$result .= $v . ',';
			}
		}

		if ($result)
		{
			$result = substr($result, 0, strlen($result) -1);
		}
	}

	return $result;
} // end func phpbb_get_forum_list

###############################################################################
##                                                                           ##
## phpbb_avatar_image()                                                      ##
## ------------------------------------------------------------------------- ##
## This function will return a valid image URL for the user avatar.          ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     avatar_type                                                           ##
##                                                                           ##
##         Type of the avatar: uploaded, remote or gallery.                  ##
##                                                                           ##
##     avatar                                                                ##
##                                                                           ##
##         user avatar                                                       ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     echo phpbb_avatar_image($userdata['user_avatar_type'],                ##
##         $userdata['user_avatar']);                                        ##
##                                                                           ##
###############################################################################

function phpbb_avatar_image($avatar_type = null, $avatar = null)
{
	global $board_config, $phpbb_root_path;

	$image = '';

	switch($avatar_type)
	{
		case USER_AVATAR_UPLOAD:
			$image = ($board_config['allow_avatar_upload'])
				? '<img src="' . $phpbb_root_path
					. $board_config['avatar_path'] . '/' . $avatar
					. '" alt="" border="0" />'
				: '';
			break;
		case USER_AVATAR_REMOTE:
			$image = ($board_config['allow_avatar_remote'])
				? '<img src="' . $avatar . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$image = ($board_config['allow_avatar_local'])
				? '<img src="' . $phpbb_root_path .
					$board_config['avatar_gallery_path'] . '/' . $avatar
					. '" alt="" border="0" />'
				: '';
			break;
	}

	return $image;
} // end func phpbb_avatar_image

###############################################################################
##                                                                           ##
## phpbb_fetch_style()                                                       ##
## ------------------------------------------------------------------------- ##
## Fetches the template name from the user's settings. If board is set to    ##
## only one style, it will use the default.                                  ##
##                                                                           ##
## This function returns the template name e.g. 'subSilver'.                 ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     user_id                                                               ##
##                                                                           ##
##         the user's ID                                                     ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $forum_style = phpbb_fetch_style($userdata['user_id']);               ##
##     echo 'The path to my templates is' . $phpbb_root_path;                ##
##     echo 'templates/' . $forum_style;                                     ##
##                                                                           ##
## AUTHOR                                                                    ##
##                                                                           ##
##     RyanThaDude29 <ryan@ryansmadhouse.com>                                ##
##     http://www.ryansmadhouse.com/                                         ##
##                                                                           ##
###############################################################################

function phpbb_fetch_style($user_id = null)
{
	global $userdata, $board_config, $phpbb_root_path;

	if ($board_config['override_user_style'])
	{
		$style = $board_config['default_style'];
	}
	else
	{
		if ($userdata['session_logged_in'])
		{
			$style = $userdata['user_style'];
		}
		else
		{
			$style = $board_config['default_style'];
		}
	}

	$sql = 'SELECT *
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . $style;
	$row = phpbb_fetch_row($sql);

	return $row['template_name'];
} // end func phpbb_fetch_style

?>
