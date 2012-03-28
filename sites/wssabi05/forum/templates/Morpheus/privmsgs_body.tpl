
<form method="post" name="privmsg_list" action="{S_PRIVMSGS_ACTION}">

<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_PRIVATEMSGS}">{L_PRIVATEMSGS}</a></span></td>
</tr>
</table>
<br />

<script language="Javascript" type="text/javascript">
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		for (i = 0; i < document.privmsg_list.length; i++)
		{
			document.privmsg_list.elements[i].checked = status;
		}
	}
</script>

<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
  <tr> 
	<td align="left" valign="bottom">{POST_PM_IMG}</td>
	<td valign="top" align="center" width="100%"> 
	  <table height="40" cellspacing="2" cellpadding="2" border="0">
		<tr valign="middle"> 
		  <td><span class="forumlink">{INBOX} &nbsp;</span></td>
		  <td><span class="forumlink">{SENTBOX} &nbsp;</span></td>
		  <td><span class="forumlink">{OUTBOX} &nbsp;</span></td>
		  <td><span class="forumlink">{SAVEBOX} &nbsp;</span></td>
		</tr>
	  </table>
	</td>
	<td align="right"> 
	  <!-- BEGIN switch_box_size_notice -->
	  <table width="190" cellspacing="1" cellpadding="2" border="0" class="forumline">
		<tr> 
		  <td colspan="3" width="190" class="row" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
		</tr>
		<tr> 
		  <td colspan="3" width="190" class="row" nowrap="nowrap"><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/voting_left.gif" width="4" height="14" border="0" /><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/voting_bar.gif" width="{INBOX_LIMIT_IMG_WIDTH}" height="14" alt="{INBOX_LIMIT_PERCENT}" /><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/voting_right.gif" width="4" height="14" border="0" alt="" /></td>
		</tr>
		<tr> 
		  <td width="33%" class="row"><span class="gensmall">0%</span></td>
		  <td width="34%" align="center" class="row"><span class="gensmall">50%</span></td>
		  <td width="33%" align="right" class="row"><span class="gensmall">100%</span></td>
		</tr>
	  </table>
	  <!-- END switch_box_size_notice -->
	</td>
  </tr>
</table>

<br />

{TPL_HDR1}{BOX_NAME}{TPL_HDR2}<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <th nowrap="nowrap" colspan="2">&nbsp;{L_SUBJECT}&nbsp;</th>
	  <th width="20%" nowrap="nowrap">&nbsp;{L_FROM_OR_TO}&nbsp;</th>
	  <th width="15%" nowrap="nowrap">&nbsp;{L_DATE}&nbsp;</th>
	  <th width="5%" nowrap="nowrap">&nbsp;{L_MARK}&nbsp;</th>
	</tr>
	<!-- BEGIN listrow -->
	<tr> 
	  <td class="row" width="21" align="center" valign="middle" style="padding: 1px;"><img src="{listrow.PRIVMSG_FOLDER_IMG}" width="19" height="17" alt="{listrow.L_PRIVMSG_FOLDER_ALT}" title="{listrow.L_PRIVMSG_FOLDER_ALT}" /></td>
	  <td valign="middle" class="row"><span class="topiclink">&nbsp;<a href="{listrow.U_READ}" class="topiclink">{listrow.SUBJECT}</a></span></td>
	  <td width="20%" valign="middle" align="center" class="row"><span class="gensmall">&nbsp;<a href="{listrow.U_FROM_USER_PROFILE}">{listrow.FROM}</a></span></td>
	  <td width="15%" align="center" valign="middle" class="row"><span class="gensmall">{listrow.DATE}</span></td>
	  <td width="5%" align="center" valign="middle" class="row"><input type="checkbox" name="mark[]2" value="{listrow.S_MARK_ID}" /></td>
	</tr>
	<!-- END listrow -->
	<!-- BEGIN switch_no_messages -->
	<tr> 
	  <td class="row" colspan="5" align="center" valign="middle"><span class="gen">{L_NO_MESSAGES}</span></td>
	</tr>
	<!-- END switch_no_messages -->
	<tr> 
	  <td class="catBottom" colspan="5" height="25" valign="middle"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	  <tr>
		<td nowrap="nowrap" valign="middle"><span class="gensmall" style="color: #FFF; font-weight: bold;">&nbsp;{L_DISPLAY_MESSAGES}:&nbsp;</span></td>
		<td nowrap="nowrap"><select name="msgdays">{S_SELECT_MSG_DAYS}</select> <input type="submit" value="{L_GO}" name="submit_msgdays" class="liteoption" /></td>
		<td width="100%" align="right" nowrap="nowrap">
		{S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MARKED}" class="mainoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MARKED}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="deleteall" value="{L_DELETE_ALL}" class="liteoption" />
		</td>
	  </tr>
	  </table></td>
	</tr>
  </table>{TPL_FTR}

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="left" valign="middle"><span class="gen">{POST_PM_IMG}</span></td>
	  <td align="left" valign="middle" width="100%"><span class="gen">{PAGE_NUMBER}</span></td>
	  <td align="right" valign="top" nowrap="nowrap"><span class="gensmall"><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL}</a> :: <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL}</a></span><br /><div class="pagination">{PAGINATION}</div><br /><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>

<table width="100%" border="0">
  <tr> 
	<td align="right" valign="top">{JUMPBOX}</td>
  </tr>
</table>
