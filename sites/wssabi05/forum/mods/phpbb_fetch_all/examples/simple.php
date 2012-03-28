<?php
###############################################################################
##                                                                           ##
## phpBB Fetch All - A modification to phpBB that displays data from the     ##
##                   forum on any page of a website.                         ##
## ------------------------------------------------------------------------- ##
## A simple example file.                                                    ##
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

//
// prevent hacking attempts - phpBB needs this line to work
//

define ('IN_PHPBB', true);

//
// lets make a little check if your root_path is correct ;-)
//

if (!file_exists($phpbb_root_path . 'extension.inc'))
{
	die ('<tt><b>phpBB Fetch All:</b>
		$phpbb_root_path is wrong and does not point to your forum.</tt>');
}

//
// now we include (integrate) some files which we need
//

//
// this is a phpBB file
//

include_once ($phpbb_root_path . 'extension.inc');

//
// again a phpBB file
//

include_once ($phpbb_root_path . 'common.' . $phpEx);

//
// phpBB file, too
//

include_once ($phpbb_root_path . 'includes/bbcode.' . $phpEx);

//
// well, this is 'our' file - the common Fetch All file needed
// every time you use Fetch All
//

include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/common.' . $phpEx);

//
// since we are 'only' displaying some news we only need this one
//

include_once ($phpbb_root_path . 'mods/phpbb_fetch_all/posts.' . $phpEx);

//
// these lines will setup the phpBB session management which we need
// for proper security settings - just don't touch them unless you know
// what you are doing
//

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

//
// here we go: fetch some news!
//

$news = phpbb_fetch_posts();

//
// disconnect from the database
//

phpbb_disconnect();

//
// Hint:
//
// If you are curious what's in the $news array
// --> uncomment the following line
// You will see all elements of the array along with
// their keys and values.
//

// echo ('<pre>'); print_r($news); die();

?>
<html>
<head>
<title>phpBB Fetch All - simple example</title>
</head>
<body>
<center>

<table width="50%" border="0">
<tr>
<th>phpBB Fetch All - simple.php</th>
</tr>
<tr>
<td align="left" width="100%">
This example fetches the latest postings out of the forum.
As you can see the output is rather black and white without
any fancy style settings.
</td>
</tr>
</table>

<p>
<?php

//
// output all postings - this is the common method of displaying
// fetched data --> it is called a for() loop
//
// the for loop will go through every element of our result; thus
// it displays all entries
//
// an element will be displayed by
//
//     echo $news[$i]['topic_title'];
//
// which displays the topic title of the current posting of the loop
//

for ($i = 0; $i < count($news); $i++) {

?>
<table width="50%" border="1">
<tr>
<th><?php echo $news[$i]['topic_title']; ?></th>
</tr>
<tr>
<td align="left" width="100%">
Posted by
<a href="<?php echo append_sid($phpbb_root_path . 'profile.php?mode=viewprofile&amp;u=' . $news[$i]['user_id']); ?>">
<?php echo $news[$i]['username']; ?></a>
on <?php echo $news[$i]['date']; ?> at <?php echo $news[$i]['time']; ?>

<hr size="1"/>
<?php echo $news[$i]['post_text']; ?>
<hr size="1"/>

<div align="right">(<?php echo $news[$i]['topic_replies']; ?>)
<a href="<?php echo append_sid($phpbb_root_path . 'viewtopic.php?t=' . $news[$i]['topic_id']); ?>">
Comment<?php if ($news[$i]['topic_replies'] != 1) { echo 's'; } ?></a></div>
</td>
</tr>
</table>
<p />
<?php

}

?>
</center>
</body>
</html>
