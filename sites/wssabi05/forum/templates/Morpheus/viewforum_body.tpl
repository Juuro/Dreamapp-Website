<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
	<td class="nav navform" align="right" valign="middle" nowrap="nowrap"><span class="nav"><form action="{CA_SEARCH_INDEX}" method="post" style="display: inline;"><input type="hidden" name="show_results" value="topics" /><input type="hidden" name="search_forum" value="{CA_SEARCH_FORUM}" />
	<input type="text" name="search_keywords" class="post" size="15" />
	<input type="submit" value="{L_SEARCH}" class="mainoption" />
	</form></span></td>
</tr>
</table>
<br />

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr> 
	<td align="left" valign="bottom" width="70%"><span class="gensmall">{L_MODERATOR}: {MODERATORS}<br />{LOGGED_IN_USER_LIST}</span></td>
	<td align="right" valign="bottom"><span class="gensmall"><a href="{U_MARK_READ}">{L_MARK_TOPICS_READ}</a></span></td>
</tr>
<tr> 
	<td align="left" valign="middle"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	<td align="right" valign="bottom" nowrap="nowrap"><div class="pagination">{PAGINATION}</div></td>
</tr>
</table>

<form method="post" action="{S_POST_DAYS_ACTION}" style="display: inline;">
{TPL_HDR1}<a href="{U_VIEW_FORUM}">{FORUM_NAME}</a>{TPL_HDR2}<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <th colspan="2" align="center" height="25" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	  <th width="50" align="center" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	  <th width="100" align="center" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	  <th width="50" align="center" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
	  <th align="center" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- BEGIN switch_xs_enabled -->
<?php
if(empty($xs_tmp_topicrow))
{
	$topicrow_count = ( isset($this->_tpldata['topicrow.']) ) ?  sizeof($this->_tpldata['topicrow.']) : 0;
	// check own posts
	global $userdata, $db;
	$topic_ids = array();
	$user_topics = array();
	if ($userdata['user_id'] != ANONYMOUS)
	{
		for ($topicrow_i = 0; $topicrow_i < $topicrow_count; $topicrow_i++)
		{
			$topicrow_item = &$this->_tpldata['topicrow.'][$topicrow_i];
			$topic_ids[] = $topicrow_item['TOPIC_ID'];
		}
		if (!empty($topic_ids))
		{
			// check the posts
			$s_topic_ids = implode(', ', $topic_ids);
			$sql = "SELECT DISTINCT topic_id FROM " . POSTS_TABLE . " 
				WHERE topic_id IN ($s_topic_ids)
					AND poster_id = " . $userdata['user_id'];
			if ( ($result = $db->sql_query($sql)) )
			{
				while ($row = $db->sql_fetchrow($result))
				{
					$user_topics[$row['topic_id']] = true;
				}
			}
		}
	}
	// check for new posts and change folder for own posts
	for ($topicrow_i = 0; $topicrow_i < $topicrow_count; $topicrow_i++)
	{
		$topicrow_item = &$this->_tpldata['topicrow.'][$topicrow_i];
		$topicrow_item['XS_NEW'] = strpos($topicrow_item['TOPIC_FOLDER_IMG'], '_new') > 0 ? '_new' : '';
		$user_replied = isset($user_topics[$topicrow_item['TOPIC_ID']]);
		if($user_replied)
		{
			$topicrow_item['TOPIC_FOLDER_IMG'] = str_replace('.gif', '_own.gif', $topicrow_item['TOPIC_FOLDER_IMG']);
		}
	}
	$xs_tmp_topicrow = true;
}
?>
	<!-- END switch_xs_enabled -->
	<!-- BEGIN topicrow -->
	<tr> 
	  <td class="row" align="center" valign="middle" width="21" style="padding: 1px;"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="17" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row" width="100%"><span class="genmed">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}</span><span class="topiclink{topicrow.XS_NEW}"><a class="topiclink{topicrow.XS_NEW}" href="{topicrow.U_VIEW_TOPIC}">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		<div class="gotopage">{topicrow.GOTO_PAGE}</div></span></td>
	  <td class="row" align="center" valign="middle"><span class="gen">{topicrow.REPLIES}</span></td>
	  <td class="row" align="center" valign="middle"><span class="gensmall">{topicrow.TOPIC_AUTHOR}</span></td>
	  <td class="row" align="center" valign="middle"><span class="gen">{topicrow.VIEWS}</span></td>
	  <td class="row" align="center" valign="middle" nowrap="nowrap"><span class="gensmall">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- BEGIN switch_no_topics -->
	<tr> 
	  <td class="row" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->
	<tr> 
	  <td class="catBottom" align="right" valign="middle" colspan="6" height="25"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	  <tr>
		<td valign="middle" nowrap="nowrap"><span class="genmed" style="font-weight: bold; color: #FFF;">&nbsp;{L_DISPLAY_TOPICS}:</span></td>
		<td valign="middle" nowrap="nowrap">&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp;<input type="submit" class="liteoption" value="{L_GO}" name="submit" /></td>
		<td valign="middle" align="right" width="100%"><span class="genmed" style="font-weight: bold; color: #FFF;">{S_TIMEZONE}&nbsp;</span></td>
	  </tr></table></td>
	</tr>
</table>{TPL_FTR}
</form>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
<tr> 
	<td align="left" valign="top" nowrap="nowrap">
		<a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a><br /><br />
		<table cellspacing="2" cellpadding="0" border="0">
			<tr>
				<td width="20" align="center"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" width="19" height="17" /></td>
				<td class="gensmall">{L_NEW_POSTS}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" width="19" height="17" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS}</td>
				<td>&nbsp;&nbsp;</td>
			</tr>
			<tr> 
				<td width="20" align="center"><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" width="19" height="17" /></td>
				<td class="gensmall">{L_NEW_POSTS_HOT}</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" align="center"><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" width="19" height="17" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS_HOT}</td>
				<td>&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td class="gensmall" align="center"><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_TOPIC_LOCKED}" width="19" height="17" /></td>
				<td class="gensmall">{L_NEW_POSTS_LOCKED}</td>
				<td>&nbsp;&nbsp;</td>
				<td class="gensmall" align="center"><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_TOPIC_LOCKED}" width="19" height="17" /></td>
				<td class="gensmall">{L_NO_NEW_POSTS_LOCKED}</td>
				<td>&nbsp;&nbsp;</td>
			</tr>
		</table><br />
		{JUMPBOX}<br />
	</td>
	<td align="right" valign="top" nowrap="nowrap">
		<div class="pagination">{PAGINATION}</div><br />
		<span class="gensmall">{S_AUTH_LIST}</span><br />
	</td>
</tr>
</table>

