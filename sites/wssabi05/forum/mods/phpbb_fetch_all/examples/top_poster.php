<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## An early template example.                                                ##
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

$phpbb_root_path = '../../../';

define ('IN_PHPBB', true);

if (!file_exists($phpbb_root_path . 'extension.inc'))
{
	die ('<tt><b>phpBB Fetch All:</b>
		$phpbb_root_path is wrong and does not point to your forum.</tt>');
}

include_once ($phpbb_root_path . 'extension.inc');
include_once ($phpbb_root_path . 'common.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/common.' . $phpEx);
include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/users.' . $phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$top_poster = phpbb_fetch_top_poster();

include_once ($phpbb_root_path . 'includes/page_header.' . $phpEx);

$template->set_filenames(array('body' => 'top_poster_body.tpl'));

for ($i = 0; $i < count($top_poster); $i++) {
	// transfer all the 'normal' keys/values into the array
	// with the while() we transfer all pairs at once
	while (list($k, $v) = each($top_poster[$i])) {
		$vars[strtoupper($k)] = $v;
	}
	// assign special values
	$vars['RANK']           = $i+1;
	$vars['U_USER_PROFILE'] = append_sid($phpbb_root_path
		. 'profile.'
		. $phpEx
		. '?mode=viewprofile&amp;u='
		. $top_poster[$i]['user_id']);
	// finally assign them
	$template->assign_block_vars('top_poster', $vars);
}

$template->pparse('body');

include_once ($phpbb_root_path . 'includes/page_tail.' . $phpEx);

?>
