<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## This module contains functions for fetching data from the phpbb_pafiledb  ##
## mod (http://www.phpbb.com/phpBB/viewtopic.php?t=56035)                    ##
##                                                                           ##
###############################################################################
##                                                                           ##
## Authors: 'Odin'                                                           ##
##          http://www.nma-fallout.com/                                      ##
##          Volker 'Ca5ey' Rattel <webmaster@phpbbfetchall.com>              ##
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
// determines the type of file list you want
// newest = fetches the latest file(s)
// random = fetches a random file(s)
// top = fetches the top downloaded file(s)
//

$CFG['pafiledb_fetch_files'] = 'newest';

//
// Number of files to display
// Default set to 10

$CFG['pafiledb_file_limit'] = '10';

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
## pafiledb_fetch_files()                                                    ##
## ------------------------------------------------------------------------- ##
## Fetches the latest files from the phpBB_pafiledb mod                      ##
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
##     $file = pafiledb_fetch_files();                                       ##
##                                                                           ##
##     echo '<a href="/phpBB2/dload.php?action=file&file_id='                ##
##         . $file['file_id']'">"' . $file['file_name']'"</a>;               ##
##                                                                           ##
###############################################################################

function pafiledb_fetch_files($category_id = null)
{
	global $CFG;

	$sql = 'SELECT * FROM phpbb_pa_files WHERE file_approved = 1';

	if ($category_id)
	{
		if (!is_array($category_id))
		{
			$sql .= '
				AND file_catid = ' . $category_id;
		}
		else
		{
			$sql .= '
				AND file_catid IN (';

			for ($i = 0; $i < count($category_id); $i++)
			{
				$sql .= $category_id[$i] . ',';
			}

			$sql = substr($sql, 0, strlen($sql) -1);

			$sql .= ')';
		}
	}

	if ($CFG['pafiledb_fetch_files'] == 'newest')
	{
		$sql .= '
			ORDER BY file_time DESC';
	}

	if ($CFG['pafiledb_fetch_files'] == 'top')
	{
		$sql .= '
			ORDER BY file_dls DESC';
	}

	if ($CFG['pafiledb_fetch_files'] == 'random')
	{
		$sql .= '
			ORDER BY RAND()';
	}

	$sql .= ' LIMIT 0, ' . $CFG['file_limit'];
   
	$result = phpbb_fetch_rows($sql);

	return $result;
} // end func pafiledb_fetch_files

?>
