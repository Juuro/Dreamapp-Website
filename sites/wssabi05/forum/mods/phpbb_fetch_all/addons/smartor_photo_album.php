<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions for fetching data from the Smartor Photo   ##
## Album Addon (http://smartor.is-root.com)                                  ##
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
// determines the type of image
// newest = fetches the latest image
// random = fetches a random image
//

$CFG['smartor_photo_album_display'] = 'newest';

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
## smartor_photo_album_fetch_image()                                         ##
## ------------------------------------------------------------------------- ##
## Fetches a picture from the album.                                         ##
##                                                                           ##
## PARAMETER                                                                 ##
##                                                                           ##
##     category_id                                                           ##
##                                                                           ##
##         Can be left blank to fetch from all categories or set to a single ##
##         category id to fetch that specific category. To fetch from        ##
##         multiple categories you can parse an array to it.                 ##
##                                                                           ##
## EXAMPLE                                                                   ##
##                                                                           ##
##     $image = smartor_photo_album_fetch_image();                           ##
##                                                                           ##
##     echo '<img src="/phpBB2/album_page?pic_id=' . $image['pic_id'];       ##
##     echo '" alt="' . $image['pic_desc'] . '" border="0" />';              ##
##                                                                           ##
###############################################################################

function smartor_photo_album_fetch_image($category_id = null)
{
	global $CFG;

	$sql = 'SELECT p.pic_id, p.pic_title, p.pic_username, p.pic_user_id,
			p.pic_time, p.pic_desc, p.pic_lock, p.pic_approval,
			u.username
			FROM ' . ALBUM_TABLE . ' AS p
			LEFT JOIN ' . USERS_TABLE . ' AS u
			ON p.pic_user_id = u.user_id
			WHERE pic_approval = 1 AND pic_lock = 0';

	if ($category_id)
	{
		if (!is_array($category_id))
		{
			$sql .= '
				AND pic_cat_id = ' . $category_id;
		}
		else
		{
			$sql .= '
				AND pic_cat_id IN (';

			for ($i = 0; $i < count($category_id); $i++)
			{
				$sql .= $category_id[$i] . ',';
			}

			$sql = substr($sql, 0, strlen($sql) -1);

			$sql .= ')';
		}
	}

	if ($CFG['smartor_photo_album_display'] == 'newest')
	{
		$sql .= '
				ORDER BY pic_time DESC';
	}

	if ($CFG['smartor_photo_album_display'] == 'random')
	{
		$sql .= '
			ORDER BY RAND()';
	}

	$sql .= '
			LIMIT 0, 1';

	$result = phpbb_fetch_row($sql);

	return $result;
} // end func smartor_photo_album_fetch_image

?>
