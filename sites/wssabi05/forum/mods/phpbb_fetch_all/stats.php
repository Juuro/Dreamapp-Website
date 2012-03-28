<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions for fetching board statistic data.         ##
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
// Timespan in seconds that determines if a user is considered being online or
// not. A higher value will probably produce more online users.
//

$CFG['stats_session_time'] = 300;

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
## phpbb_fetch_stats()                                                       ##
## ------------------------------------------------------------------------- ##
## Fetches user online, total posts, total topics, total users and newest    ##
## user.                                                                     ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $stats = phpbb_fetch_stats();                                         ##
##                                                                           ##
##     echo 'We have '   . $stats['total_posts']  . ' articles.';            ##
##     echo 'We have '   . $stats['total_topics'] . ' topics.';              ##
##     echo 'We have '   . $stats['total_users']  . ' users.';               ##
##     echo 'There are ' . $stats['user_online']  . ' users online.';        ##
##     echo 'The newest user is ' . $stats['username'] . '.';                ##
##                                                                           ##
###############################################################################

function phpbb_fetch_stats()
{
	global $CFG;

	$result = array();

	//
	// total posts
	//

	$result['total_posts'] = get_db_stat('postcount');

	//
	// total users
	//

	$result['total_users'] = get_db_stat('usercount');

	//
	// newest user
	//

	$newest_user           = get_db_stat('newestuser');
	$result['user_id']     = $newest_user['user_id'];
	$result['username']    = $newest_user['username'];

	//
	// user online
	//

	$sql = 'SELECT session_id
			FROM ' . SESSIONS_TABLE . '
			WHERE session_time >= '
				. (time() - $CFG['stats_session_time']) . '
				GROUP BY session_ip';

	$user_online = phpbb_fetch_rows($sql);
	$result['user_online'] = count($user_online);

	//
	// total topics
	//

	$sql = 'SELECT COUNT( topic_id ) AS topics
				FROM ' . TOPICS_TABLE;

	$total_topics = phpbb_fetch_rows($sql);
	$result['total_topics'] = $total_topics[0][0];

	return $result;
} // end func phpbb_fetch_stats

?>
