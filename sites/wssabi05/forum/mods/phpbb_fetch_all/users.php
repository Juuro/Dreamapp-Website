<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions for fetching user related data.            ##
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
// This value specifies how many users some functions from this module
// will fetch. Setting this to zero will fetch all particular users.
//

$CFG['users_limit'] = 10;

//
// Timespan in seconds that determines if a user is considered being online or
// not. A higher value will probably produce more online users.
//

$CFG['users_session_time'] = 300;

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
## phpbb_fetch_top_poster()                                                  ##
## ------------------------------------------------------------------------- ##
## Fetches users ordered by their amount of total posts. The amount of users ##
## can be limited with $CFG['users_limit'].                                  ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     group_id                                                              ##
##                                                                           ##
##         Set to null (empty) to fetch from the whole board.                ##
##                                                                           ##
##             $member = phpbb_fetch_users();                                ##
##                                                                           ##
##         Set to a single group id to fetch from that specific group.       ##
##                                                                           ##
##             $member = phpbb_fetch_users(1);                               ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $top_poster = phpbb_fetch_top_poster();                               ##
##                                                                           ##
##     if ($top_poster)                                                      ##
##     {                                                                     ##
##         for ($i = 0; $i < count($top_poster); $i++)                       ##
##         {                                                                 ##
##             echo ($i+1) . '. ' . $top_poster[$i]['username'];             ##
##             echo ' (' . $top_poster[$i]['user_posts'] . ')<br>';          ##
##         }                                                                 ##
##     }                                                                     ##
##                                                                           ##
###############################################################################

function phpbb_fetch_top_poster($group_id = null)
{
	global $CFG;

	//
	// sanity check
	//

	if ($group_id and !intval($group_id))
	{
		phpbb_raise_error('Group ID must be a numeric value.',
			__FILE__, __LINE__);
	}

	//
	// build the sql string
	//

	$sql = 'SELECT u.*';

	if ($group_id)
	{
		$sql .= ', g.*, ug.*';
	}

	$sql .= '
		FROM ' . USERS_TABLE . ' AS u';

	if ($group_id)
	{
		$sql .= ',
			' . GROUPS_TABLE     . ' AS g,
			' . USER_GROUP_TABLE . ' AS ug';
	}

	$sql .= '
		WHERE u.user_id <> -1';

	if ($group_id)
	{
		$sql .= '
			AND g.group_id = '  . $group_id . '
			AND ug.group_id = ' . $group_id . '
			AND u.user_id = ug.user_id
			AND ug.user_pending = 0';
	}

	$sql .= '
		ORDER BY u.user_posts DESC';

	if ($CFG['users_limit'])
	{
		$sql .= '
			LIMIT 0,' . $CFG['users_limit'];
	}

	$result = phpbb_fetch_rows($sql);

	return $result;
} // end func phpbb_fetch_top_poster

###############################################################################
##                                                                           ##
## phpbb_fetch_random_user()                                                 ##
## ------------------------------------------------------------------------- ##
## Fetches a random user with at least one posting.                          ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     group_id                                                              ##
##                                                                           ##
##         Set to null (empty) to fetch from the whole board.                ##
##                                                                           ##
##             $member = phpbb_fetch_random_users();                         ##
##                                                                           ##
##         Set to a single group id to fetch from that specific group.       ##
##                                                                           ##
##             $member = phpbb_fetch_random_users(1);                        ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $random_user = phpbb_fetch_random_user();                             ##
##                                                                           ##
##     echo 'User of the moment is ' . $random_user['username'];             ##
##                                                                           ##
###############################################################################

function phpbb_fetch_random_user($group_id = null)
{
	//
	// sanity check
	//

	if ($group_id and !intval($group_id))
	{
		phpbb_raise_error('Group ID must be a numeric value.',
			__FILE__, __LINE__);
	}

	//
	// build the sql string
	//

	$sql = 'SELECT u.user_id';

	if ($group_id)
	{
		$sql .= ', g.*, ug.*';
	}

	$sql .= '
		FROM ' . USERS_TABLE . ' AS u';

	if ($group_id)
	{
		$sql .= ',
			' . GROUPS_TABLE     . ' AS g,
			' . USER_GROUP_TABLE . ' AS ug';
	}

	$sql .= '
		WHERE u.user_id <> -1
		AND u.user_posts > 0';

	if ($group_id)
	{
		$sql .= '
			AND g.group_id = '  . $group_id . '
			AND ug.group_id = ' . $group_id . '
			AND u.user_id = ug.user_id
			AND ug.user_pending = 0';
	}

	$result = phpbb_fetch_rows($sql);

	//
	// initialize random generator and determine the lucky one :-)
	//

	srand ((double)microtime()*1000000);
	$the_one = rand(0, count($result) - 1);

	$sql = 'SELECT u.*
			FROM ' . USERS_TABLE . ' AS u
			WHERE u.user_id = ' . $result[$the_one]['user_id'];

	$result = phpbb_fetch_row($sql);

	return $result;
} // end func phpbb_fetch_random_user

###############################################################################
##                                                                           ##
## phpbb_fetch_users()                                                       ##
## ------------------------------------------------------------------------- ##
## Fetches users of a specific group. If $group_id is emtpy all users of the ##
## board will be fetched; otherwise only the member of the specific group.   ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     group_id                                                              ##
##                                                                           ##
##         Set to null (empty) to fetch from the whole board. This can       ##
##         produce an internal server error if your board is very huge. Be   ##
##         sure to test this before you implement this to a production       ##
##         system.                                                           ##
##                                                                           ##
##             $member = phpbb_fetch_users();                                ##
##                                                                           ##
##         Set to a single group id to fetch from that specific group.       ##
##                                                                           ##
##             $member = phpbb_fetch_users(1);                               ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $member = phpbb_fetch_users();                                        ##
##                                                                           ##
##     if ($member)                                                          ##
##     {                                                                     ##
##         for ($i = 0; $i < count($member); $i++)                           ##
##         {                                                                 ##
##             echo $member['username'] . '<br>';                            ##
##         }                                                                 ##
##     }                                                                     ##
##                                                                           ##
###############################################################################

function phpbb_fetch_users($group_id = null)
{
	//
	// prevent SQL injection
	//

	if ($group_id and !intval($group_id))
	{
		phpbb_raise_error('Group ID must be a numeric value.',
			__FILE__, __LINE__);
	}

	$result = array();

	$sql = 'SELECT u.*';

	if ($group_id)
	{
		$sql .= ', g.*, ug.*';
	}

	$sql .= '
				FROM ' . USERS_TABLE      . ' AS u';

	if ($group_id)
	{
		$sql .= ',
					' . GROUPS_TABLE     . ' AS g,
					' . USER_GROUP_TABLE . ' AS ug';
	}

	$sql .= '
				WHERE u.user_active = 1';

	if ($group_id)
	{
		$sql .= '
					AND g.group_id = '  . $group_id . '
					AND ug.group_id = ' . $group_id . '
					AND u.user_id = ug.user_id
					AND ug.user_pending = 0';
	}

	$sql .= '
				ORDER BY u.username';

	$result = phpbb_fetch_rows($sql);

	return $result;
} // end func phpbb_fetch_users

###############################################################################
##                                                                           ##
## phpbb_fetch_online_users()                                                ##
## ------------------------------------------------------------------------- ##
## Fetches a list of usernames which are currently logged in.                ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     group_id                                                              ##
##                                                                           ##
##         Set to null (empty) to fetch from the whole board.                ##
##                                                                           ##
##             $member = phpbb_fetch_users();                                ##
##                                                                           ##
##         Set to a single group id to fetch from that specific group.       ##
##                                                                           ##
##             $member = phpbb_fetch_users(1);                               ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $online = phpbb_fetch_online_users();                                 ##
##                                                                           ##
##     for ($i = 0; $i < count($online); $i++)                               ##
##     {                                                                     ##
##         echo $online[$i]['username'];                                     ##
##         if ($i < count($online) - 1)                                      ##
##         {                                                                 ##
##             echo ', ';                                                    ##
##         }                                                                 ##
##     }                                                                     ##
##                                                                           ##
###############################################################################

function phpbb_fetch_online_users($group_id = null)
{
	global $CFG;

	//
	// sanity check
	//

	if ($group_id and !intval($group_id))
	{
		phpbb_raise_error('Group ID must be a numeric value.',
			__FILE__, __LINE__);
	}

	//
	// build the sql string
	//

	$sql = 'SELECT u.user_id, u.username, u.user_allow_viewonline,
			u.user_level, s.session_logged_in, s.session_time';

	if ($group_id)
	{
		$sql .= ', g.*, ug.*';
	}

	$sql .= '
		FROM
		' . USERS_TABLE    . ' AS u,
		' . SESSIONS_TABLE . ' AS s';

	if ($group_id)
	{
		$sql .= ',
			' . GROUPS_TABLE     . ' AS g,
			' . USER_GROUP_TABLE . ' AS ug';
	}

	$sql .= '
		WHERE u.user_id = s.session_user_id
		AND s.session_time >= '
		. (time() - $CFG['users_session_time']);

	if ($group_id)
	{
		$sql .= '
			AND g.group_id = '  . $group_id . '
			AND ug.group_id = ' . $group_id . '
			AND u.user_id = ug.user_id
			AND ug.user_pending = 0';
	}

	$sql .= '
		ORDER BY u.username ASC';

	$result = phpbb_fetch_rows($sql);

	//
	// delete hidden and guest users
	//

	$cleanup = array();
	$prev_user = 0;

	for ($i = 0; $i < count($result); $i++)
	{
		if ($result[$i]['session_logged_in'])
		{
			$user_id = $result[$i]['user_id'];
			if ($user_id != $prev_user)
			{
				if ($result[$i]['user_allow_viewonline'])
				{
					$cleanup[] = $result[$i];
				}
				$prev_user = $user_id;
			}
		}
	}

	return $cleanup;
} // end func phpbb_fetch_online_users

?>
