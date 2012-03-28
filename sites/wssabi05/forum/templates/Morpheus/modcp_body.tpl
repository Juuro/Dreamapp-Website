
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
</tr>
</table>
<br />

<form method="post" action="{S_MODCP_ACTION}">

{TPL_HDR1}{L_MOD_CP}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
	<td class="row" colspan="5" align="center"><span class="gensmall">{L_MOD_CP_EXPLAIN}</span></td>
</tr>
	<tr> 
	  <th nowrap="nowrap" colspan="2">&nbsp;{L_TOPICS}&nbsp;</th>
	  <th width="8%" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	  <th width="17%" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	  <th width="5%" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	</tr>
	<!-- BEGIN topicrow -->
	<tr> 
	  <td class="row" align="center" valign="middle" style="padding: 1px;"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="17" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row">&nbsp;<span class="topictitle">{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span></td>
	  <td class="row" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row" align="center" valign="middle"><span class="postdetails">{topicrow.LAST_POST_TIME}</span></td>
	  <td class="row" align="center" valign="middle"><input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}" /></td>
	</tr>
	<!-- END topicrow -->
	<tr> 
	  <td class="th" align="right" colspan="5" height="29"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="delete" class="liteoption" value="{L_DELETE}" />
		&nbsp; 
		<input type="submit" name="move" class="liteoption" value="{L_MOVE}" />
		&nbsp; 
		<input type="submit" name="lock" class="liteoption" value="{L_LOCK}" />
		&nbsp; 
		<input type="submit" name="unlock" class="liteoption" value="{L_UNLOCK}" />
	  </td>
	</tr>
</table>{TPL_FTR}

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="middle"><span class="gen">{PAGE_NUMBER}</b></span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><div class="pagination">{PAGINATION}</div></td>
  </tr>
</table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td align="right">{JUMPBOX}</td>
  </tr>
</table>
