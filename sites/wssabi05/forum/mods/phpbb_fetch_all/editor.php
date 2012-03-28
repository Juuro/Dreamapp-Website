<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions for modifying post data.                   ##
##                                                                           ##
## WARNING                                                                   ##
##                                                                           ##
##     USE THESE MODULE WITH CARE SINCE YOU CAN DAMAGE BOARD DATA WITH IT.   ##
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
## NO CHANGES NEEDED BELOW
###############################################################################

//
// prevent hacking attempt
//

if (!defined('IN_PHPBB'))
{
	die('hacking attempt');
}

###############################################################################
##                                                                           ##
## phpbb_insert_post()                                                       ##
## ------------------------------------------------------------------------- ##
## Inserts a new topic into a given forum. Use with care since there is no   ##
## authentication check! This function returns the topic id and the post id  ##
## in an array on success.                                                   ##
##                                                                           ##
## WARNING                                                                   ##
##                                                                           ##
##     USE THIS FUNCTION WITH CARE SINCE YOU CAN DAMAGE BOARD DATA WITH IT.  ##
##                                                                           ##
## NOTE                                                                      ##
##                                                                           ##
##     To use this function add those two lines to your calling script       ##
##                                                                           ##
##     include_once($phpbb_root_path . 'includes/functions_post.' . $phpEx); ##
##     include_once($phpbb_root_path .                                       ##
##         'mods/phpbb_fetch_all/editor.' . $phpEx);                         ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     forum_id                                                              ##
##                                                                           ##
##         Specifies the forum in which the topic will be inserted.          ##
##                                                                           ##
##     username                                                              ##
##                                                                           ##
##         User ID which that topic will belong.                             ##
##                                                                           ##
##     subject                                                               ##
##                                                                           ##
##         Topic title.                                                      ##
##                                                                           ##
##     message                                                               ##
##                                                                           ##
##         Post text.                                                        ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $result = phpbb_insert_post(1, 1, 'Test', 'Hello World');             ##
##     echo 'Topic ID: ' . $result[0];                                       ##
##     echo 'Post ID:'   . $result[1];                                       ##
##                                                                           ##
###############################################################################

function phpbb_insert_post($forum_id = null, $username = null,
	 $subject = null, $message = null)
{
	global $CFG, $userdata, $phpbb_root_path, $phpEx;

	if (empty($username))
	{
		phpbb_raise_error('Username must not be empty.');
	}

	if (empty($subject))
	{
		phpbb_raise_error('Subject must not be empty.');
	}

	if (empty($message))
	{
		phpbb_raise_error('Message must not be empty.');
	}

	if (empty($forum_id))
	{
		phpbb_raise_error('Forum does not exists.');
	}

	$sql = 'SELECT *
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $forum_id;

	$result = phpbb_fetch_row($sql);
	if ($result)
	{
		$forum_id   = $result['forum_id'];
		$forum_name = $result['forum_name'];
	}
	else
	{
		phpbb_raise_error('Forum does not exists.', __FILE__, __LINE__, $sql);
	}

	//
	// save the username and override it for assigning the post to the given
	// user
	//

	$old_username = $userdata['user_id'];
	$userdata['user_id'] = $username;

	$error_msg      = '';
	$return_message = '';
	$return_meta    = '';
	$mode           = 'newtopic';
	$post_data      = array();
	$bbcode_on      = 1;
	$html_on        = 1;
	$smilies_on     = 0;
	$poll_title     = '';
	$poll_options   = '';
	$poll_length    = '';
	$bbcode_uid     = '';
	$attach_sig     = 0;

	prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on,
		$error_msg, $username, $bbcode_uid, $subject, $message, $poll_title,
		$poll_options, $poll_length);

	if ($error_msg == '')
	{
		$topic_type = POST_NORMAL;
		submit_post($mode, $post_data, $return_message, $return_meta,
			$forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on,
			$html_on, $smilies_on, $attach_sig, $bbcode_uid,
			str_replace("\'", "''", $username),
			str_replace("\'", "''", $subject),
			str_replace("\'", "''", $message),
			str_replace("\'", "''", $poll_title), $poll_options, $poll_length);

		if ($error_msg == '')
		{
			update_post_stats($mode, $post_data, $forum_id, $topic_id,
				$post_id, $username);

			if ($error_msg != '')
			{
				phpbb_raise_error($error_msg);
			}
			add_search_words('single', $post_id, stripslashes($message),
				stripslashes($subject));
		}
		else
		{
			phpbb_raise_error($error_msg);
		}
	}
	else
	{
		phpbb_raise_error($error_msg);
	}

	$userdata['user_id'] = $old_username;

	return array($topic_id, $post_id);
} // end func phpbb_insert_post

###############################################################################
##                                                                           ##
## phpbb_insert_reply()                                                      ##
## ------------------------------------------------------------------------- ##
## Inserts a reply into a given topic. Use with care since there is no       ##
## authentication check! This function returns the post id on success.       ##
##                                                                           ##
## WARNING                                                                   ##
##                                                                           ##
##     USE THIS FUNCTION WITH CARE SINCE YOU CAN DAMAGE BOARD DATA WITH IT.  ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     topic_id                                                              ##
##                                                                           ##
##         Specifies the topic in which the reply will be inserted.          ##
##                                                                           ##
##     username                                                              ##
##                                                                           ##
##         User ID which that topic will belong.                             ##
##                                                                           ##
##     subject                                                               ##
##                                                                           ##
##         Topic title.                                                      ##
##                                                                           ##
##     message                                                               ##
##                                                                           ##
##         Post text.                                                        ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $result = phpbb_insert_reply(1, 1, 'Test', 'Hello World');            ##
##     echo 'Post ID:'   . $result;                                          ##
##                                                                           ##
###############################################################################

function phpbb_insert_reply($topic_id = null, $username = null,
	$subject = null, $message = null)
{
	global $CFG, $userdata, $phpbb_root_path, $phpEx;
	include_once($phpbb_root_path . 'includes/functions_post.' . $phpEx);

	if (empty($username))
	{
		phpbb_raise_error('Username must not be empty.');
	}

	if (empty($subject))
	{
		phpbb_raise_error('Subject must not be empty.');
	}

	if (empty($message))
	{
		phpbb_raise_error('Message must not be empty.');
	}

	if (empty($topic_id))
	{
		phpbb_raise_error('Topic does not exists.');
	}

	$sql = 'SELECT f.*, t.topic_status, t.topic_title
				FROM ' . FORUMS_TABLE . ' f, ' . TOPICS_TABLE . ' t
				WHERE t.topic_id = ' . $topic_id . '
				AND f.forum_id = t.forum_id';

	$result = phpbb_fetch_row($sql);
	if ($result)
	{
		$forum_id   = $result['forum_id'];
		$forum_name = $result['forum_name'];
	}
	else
	{
		phpbb_raise_error('Forum does not exists.', __FILE__, __LINE__, $sql);
	}

	//
	// save the username and override it for assigning the post to the given
	// user
	//

	$old_username = $userdata['user_id'];
	$userdata['user_id'] = $username;

	$error_msg      = '';
	$return_message = '';
	$return_meta    = '';
	$mode           = 'reply';
	$post_data      = array();
	$bbcode_on      = TRUE;
	$html_on        = TRUE;
	$smilies_on     = 0;
	$poll_title     = '';
	$poll_options   = '';
	$poll_length    = '';
	$bbcode_uid     = '';
	$attach_sig     = 0;

	prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on,
		 $error_msg, $username, $bbcode_uid, $subject, $message, $poll_title,
		 $poll_options, $poll_length);

	if ($error_msg == '')
	{
		$topic_type = POST_NORMAL;
		submit_post($mode, $post_data, $return_message, $return_meta,
			$forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on,
			$html_on, $smilies_on, $attach_sig, $bbcode_uid,
			str_replace("\'", "''", $username),
			str_replace("\'", "''", $subject),
			str_replace("\'", "''", $message),
			str_replace("\'", "''", $poll_title), $poll_options, $poll_length);

		if ($error_msg == '')
		{
			update_post_stats($mode, $post_data, $forum_id, $topic_id,
				$post_id, $username);

			if ($error_msg != '')
			{
				phpbb_raise_error($error_msg);
			}
			add_search_words('single', $post_id, stripslashes($message),
				 stripslashes($subject));
		}
		else
		{
			phpbb_raise_error($error_msg);
		}
	}
	else
	{
		phpbb_raise_error($error_msg);
	}

	$userdata['user_id'] = $old_username;

	return $post_id;
} // end func phpbb_insert_reply

###############################################################################
##                                                                           ##
## phpbb_edit_post()                                                         ##
## ------------------------------------------------------------------------- ##
## Modifies a posting. Use with care since there is no authentication check! ##
## To use this function be sure to include the functions_posts.php file,     ##
## too.                                                                      ##
##                                                                           ##
## WARNING                                                                   ##
##                                                                           ##
##     USE THIS FUNCTION WITH CARE SINCE YOU CAN DAMAGE BOARD DATA WITH IT.  ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     post_id                                                               ##
##                                                                           ##
##         Specifies the posting which will be modified.                     ##
##                                                                           ##
##     subject                                                               ##
##                                                                           ##
##         Topic title.                                                      ##
##                                                                           ##
##     message                                                               ##
##                                                                           ##
##         Post text.                                                        ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     include_once($phpbb_root_path . 'includes/functions_post.' . $phpEx); ##
##     phpbb_edit_post(1, 'Test', 'Hello World');                            ##
##                                                                           ##
###############################################################################

function phpbb_edit_post($post_id = null, $subject = null, $message = null)
{
	global $CFG, $userdata, $phpbb_root_path, $phpEx;
	include_once($phpbb_root_path . 'includes/functions_post.' . $phpEx);
	include_once($phpbb_root_path . 'includes/functions_search.' . $phpEx);

	if (empty($subject))
	{
		phpbb_raise_error('Subject must not be empty.');
	}

	if (empty($message))
	{
		phpbb_raise_error('Message must not be empty.');
	}

	if (empty($post_id))
	{
		phpbb_raise_error('Post does not exists.');
	}

	$sql = 'SELECT *
				FROM ' . POSTS_TABLE . '
				WHERE post_id = ' . $post_id;

	$result = phpbb_fetch_row($sql);
	if ($result)
	{
		$topic_id  = $result['topic_id'];
	}
	else
	{
		phpbb_raise_error('Post does not exists.', __FILE__, __LINE__, $sql);
	}

	$sql = 'SELECT *
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . $topic_id;
	$topic_info = phpbb_fetch_row($sql);

	remove_search_post($post_id);

	if ($post_id == $topic_info['topic_first_post_id'])
	{
		$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_title = \'' .
						str_replace("\'", "''", $subject) . '\'
					WHERE topic_id = ' . $topic_id;
		phpbb_query($sql);
	}

	$sql = 'UPDATE ' . POSTS_TEXT_TABLE . '
				SET post_text = \'' . str_replace("\'", "''", $message) . '\',
					post_subject = \'' .
						str_replace("\'", "''", $subject) . '\'
				WHERE post_id = ' . $post_id;
	phpbb_query($sql);

	add_search_words('single', $post_id, stripslashes($message),
		 stripslashes($subject));
} // end func phpbb_edit_post

###############################################################################
##                                                                           ##
## phpbb_increase_topic_counter()                                            ##
## ------------------------------------------------------------------------- ##
## Increases the counter of a given topic.                                   ##
##                                                                           ##
## WARNING                                                                   ##
##                                                                           ##
##     USE THIS FUNCTION WITH CARE SINCE YOU CAN DAMAGE BOARD DATA WITH IT.  ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     topic_id                                                              ##
##                                                                           ##
##         Specifies the topic.                                              ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     phpbb_increase_topic_counter(1);                                      ##
##                                                                           ##
###############################################################################

function phpbb_increase_topic_counter($topic_id = null)
{
	if (!intval($topic_id))
	{
		phpbb_raise_error('Topic ID must be a numeric value.',
			__FILE__, __LINE__);
	}

	$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET topic_views = topic_views + 1
			WHERE topic_id = ' . $topic_id;

	phpbb_query($sql);
}

?>
