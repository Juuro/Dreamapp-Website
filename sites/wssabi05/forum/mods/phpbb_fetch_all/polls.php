<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions for fetching poll related data.            ##
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
## phpbb_fetch_poll()                                                        ##
## ------------------------------------------------------------------------- ##
## Fetches a poll and the vote results. You can specify the forum from which ##
## the poll will be fetched. If auth_check is enabled the the poll will be   ##
## checked against the user permissions.                                     ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     forum_id                                                              ##
##                                                                           ##
##         this can be either null to fetch the latest poll from the whole   ##
##         board like                                                        ##
##                                                                           ##
##             $poll = phpbb_fetch_poll();                                   ##
##                                                                           ##
##         or you can specify a single forum with                            ##
##                                                                           ##
##             $poll = phpbb_fetch_poll(1);                                  ##
##                                                                           ##
##         or - finally - you can specify a list of forums with              ##
##                                                                           ##
##             $poll = phpbb_fetch_poll(array(1, 2, 3));                     ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $poll = phpbb_fetch_poll();                                           ##
##                                                                           ##
##     if ($poll)                                                            ##
##     {                                                                     ##
##         echo $poll['vote_text'];                                          ##
##         echo '<form method="post" action="' . $phpbb_root_path;           ##
##         echo 'posting.php?t=' . $poll['topic_id'] . '">';                 ##
##         for ($i = 0; $i < count($poll['options']); $i++)                  ##
##         {                                                                 ##
##             echo '<input type="radio" name="vote_id" value="';            ##
##             echo $poll['options'][$i]['vote_option_id'] . '">';           ##
##             echo $poll['options'][$i]['vote_option_text'];                ##
##             echo '<br>';                                                  ##
##         }                                                                 ##
##         echo '<input type="hidden" name="topic_id" value="';              ##
##         echo $poll['topic_id'] . '">';                                    ##
##         echo '<input type="hidden" name="mode" value="vote">';            ##
##         echo '<input type="submit" name="submit" value="Vote">';          ##
##     }                                                                     ##
##                                                                           ##
###############################################################################

function phpbb_fetch_poll($forum_id = null)
{
	global $CFG;

	//
	// create a list of forums with read permission
	// (only takes action when auth_check is enabled)
	//

	phpbb_get_auth_list();

	//
	// determine the forum list based on the user input
	// and/or permissions (depends on auth check)
	//

	$forum_list = phpbb_get_forum_list($forum_id);

	//
	// if read permissions do not allow us to fetch anything
	// we return nicely
	//

	if (!$forum_list and $CFG['auth_check'])
	{
		return;
	}

	$sql = 'SELECT f.*, p.*, pt.*, t.*, u.*, vd.*
				FROM ' . TOPICS_TABLE     . ' AS t,
					 ' . USERS_TABLE      . ' AS u,
					 ' . POSTS_TEXT_TABLE . ' AS pt,
					 ' . POSTS_TABLE      . ' AS p,
					 ' . FORUMS_TABLE     . ' AS f,
					 ' . VOTE_DESC_TABLE  . ' AS vd
				WHERE t.topic_poster = u.user_id
					AND t.topic_first_post_id = pt.post_id
					AND t.topic_first_post_id = p.post_id
					AND t.topic_status <> 1
					AND t.topic_status <> 2
					AND t.topic_vote = 1
					AND t.forum_id = f.forum_id
					AND t.topic_id = vd.topic_id';

	if ($forum_list)
	{
		$sql .= '
					AND t.forum_id IN (' . $forum_list . ')';
	}

	$sql .= '
				ORDER BY p.post_time DESC
				LIMIT 0,1';

	$result = phpbb_fetch_row($sql);

	if ($result)
	{
		$sql = 'SELECT *
					FROM ' . VOTE_RESULTS_TABLE . '
					WHERE vote_id = ' . $result['vote_id'] . '
					ORDER BY vote_option_id';

		$result['options'] = phpbb_fetch_rows($sql);
	}

	return $result;
} // end func phpbb_fetch_poll

###############################################################################
##                                                                           ##
## phpbb_fetch_poll_bt()                                                     ##
## ------------------------------------------------------------------------- ##
## Fetches a poll and the vote results. You can specify the topic id from    ##
## which the poll will be fetched. Thanks to abravorus.                      ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     topic_id                                                              ##
##                                                                           ##
##         a single topic id                                                 ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $poll = phpbb_fetch_poll_bt(1);                                       ##
##                                                                           ##
##     if ($poll)                                                            ##
##     {                                                                     ##
##         echo $poll['vote_text'];                                          ##
##         echo '<form method="post" action="' . $phpbb_root_path;           ##
##         echo 'posting.php?t=' . $poll['topic_id'] . '">';                 ##
##         for ($i = 0; $i < count($poll['options']); $i++)                  ##
##         {                                                                 ##
##             echo '<input type="radio" name="vote_id" value="';            ##
##             echo $poll['options'][$i]['vote_option_id'] . '">';           ##
##             echo $poll['options'][$i]['vote_option_text'];                ##
##             echo '<br>';                                                  ##
##         }                                                                 ##
##         echo '<input type="hidden" name="topic_id" value="';              ##
##         echo $poll['topic_id'] . '">';                                    ##
##         echo '<input type="hidden" name="mode" value="vote">';            ##
##         echo '<input type="submit" name="submit" value="Vote">';          ##
##     }                                                                     ##
##                                                                           ##
###############################################################################

function phpbb_fetch_poll_bt($topic_id = null)
{
	global $CFG;

	if (!isset($topic_id))
	{
		return;
	}

	$sql = 'SELECT f.*, p.*, pt.*, t.*, u.*, vd.*
				FROM ' . TOPICS_TABLE     . ' AS t,
					 ' . USERS_TABLE      . ' AS u,
					 ' . POSTS_TEXT_TABLE . ' AS pt,
					 ' . POSTS_TABLE      . ' AS p,
					 ' . FORUMS_TABLE     . ' AS f,
					 ' . VOTE_DESC_TABLE  . ' AS vd
				WHERE vd.topic_id = ' . $topic_id . '
					AND t.topic_poster = u.user_id
					AND t.topic_first_post_id = pt.post_id
					AND t.topic_first_post_id = p.post_id
					AND t.topic_status <> 1
					AND t.topic_status <> 2
					AND t.topic_vote = 1
					AND t.forum_id = f.forum_id
					AND t.topic_id = vd.topic_id';

	$sql .= '
				ORDER BY p.post_time DESC
				LIMIT 0,1';

	$result = phpbb_fetch_row($sql);

	if ($result)
	{
		//
		// perform an auth check if requested
		//

		if ($CFG['auth_check'])
		{
			phpbb_get_auth_list();

			if (!in_array($result['forum_id'], $CFG['auth_list']))
			{
				return;
			}
		}

		$sql = 'SELECT *
					FROM ' . VOTE_RESULTS_TABLE . '
					WHERE vote_id = ' . $result['vote_id'] . '
					ORDER BY vote_option_id';

		 $result['options'] = phpbb_fetch_rows($sql);
	}

	return $result;
} // end func phpbb_fetch_poll_bt

###############################################################################
##                                                                           ##
## phpbb_fetch_poll_voters()                                                 ##
## ------------------------------------------------------------------------- ##
## Fetches all users who voted for the given poll.                           ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     vote_id                                                               ##
##                                                                           ##
##         a single vote id                                                  ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $voted  = false;                                                      ##
##     $poll   = phpbb_fetch_poll();                                         ##
##     $voters = phpbb_fetch_poll_voters($poll['vote_id']);                  ##
##                                                                           ##
##     for ($i = 0; $i < count($voters); $i++)                               ##
##     {                                                                     ##
##         if ($voters[$i]['vote_user_id'] == $userdata['user_id'])          ##
##         {                                                                 ##
##             $voted = true;                                                ##
##         }                                                                 ##
##     }                                                                     ##
##                                                                           ##
##     echo $voted ? 'true' : 'false';                                       ##
##                                                                           ##
###############################################################################

function phpbb_fetch_poll_voters($vote_id = null)
{
	if ($vote_id and !intval($vote_id))
	{
		phpbb_raise_error('Vote ID must be a numeric value.',
			__FILE__, __LINE__);
	}

	$sql = 'SELECT * FROM ' . VOTE_USERS_TABLE . '
		WHERE vote_id = ' . $vote_id . '
		ORDER BY vote_user_id';

	$result = phpbb_fetch_rows($sql);

	return $result;
} // end func phpbb_fetch_poll_voters

?>
