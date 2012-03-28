<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_SEARCH}">{L_SEARCH}</a></span></td>
</tr>
</table>
<br />

{TPL_HDR1_ORANGE}{L_SEARCH_MATCHES}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
  <tr> 
	<th width="4%" height="25" nowrap="nowrap">&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
  </tr>
  <!-- BEGIN searchresults -->
  <tr> 
	<td class="row" align="center" valign="middle"><img src="{searchresults.TOPIC_FOLDER_IMG}" width="19" height="17" alt="{searchresults.L_TOPIC_FOLDER_ALT}" title="{searchresults.L_TOPIC_FOLDER_ALT}" /></td>
	<td class="row"><span class="topiclink"><a href="{searchresults.U_VIEW_FORUM}" class="topiclink">{searchresults.FORUM_NAME}</a></span></td>
	<td class="row"><span class="genmed">{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}" class="topiclink">{searchresults.TOPIC_TITLE}</a></span><br /><span class="gensmall">{searchresults.GOTO_PAGE}</span></td>
	<td class="row" align="center" valign="middle"><span class="gensmall">{searchresults.TOPIC_AUTHOR}</span></td>
	<td class="row" align="center" valign="middle"><span class="gensmall">{searchresults.REPLIES}</span></td>
	<td class="row" align="center" valign="middle"><span class="gensmall">{searchresults.VIEWS}</span></td>
	<td class="row" align="center" valign="middle" nowrap="nowrap"><span class="gensmall">{searchresults.LAST_POST_TIME}<br />{searchresults.LAST_POST_AUTHOR} {searchresults.LAST_POST_IMG}</span></td>
  </tr>
  <!-- END searchresults -->
</table>{TPL_FTR}

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="top"><span class="gen">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><div class="pagination">{PAGINATION}</div><br /><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
