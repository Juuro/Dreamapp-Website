
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
</tr>
</table>
<br />

<form method="post" action="{S_SPLIT_ACTION}">
{TPL_HDR1}{L_SPLIT_TOPIC}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
	<td colspan="3" align="center" class="row"><span class="gensmall">{L_SPLIT_TOPIC_EXPLAIN}</span></td>
</tr>
<tr> 
	<td class="row" nowrap="nowrap"><span class="gen">{L_SPLIT_SUBJECT}</span></td>
	<td class="row" colspan="2"><input class="post" type="text" size="35" style="width: 350px" maxlength="60" name="subject" /></td>
</tr>
<tr> 
	<td class="row" nowrap="nowrap"><span class="gen">{L_SPLIT_FORUM}</span></td>
	<td class="row" colspan="2">{S_FORUM_SELECT}</td>
</tr>
<tr> 
	<td class="catBottom" colspan="3" height="28" align="right"><input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" />&nbsp;<input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" /></td>
</tr>
<tr> 
	<th nowrap="nowrap">{L_AUTHOR}</th>
	<th nowrap="nowrap">{L_MESSAGE}</th>
	<th nowrap="nowrap">{L_SELECT}</th>
</tr>
<!-- BEGIN postrow -->
<tr> 
	<td align="left" valign="top" class="row"><span class="gen"><a name="{postrow.U_POST_ID}"></a>{postrow.POSTER_NAME}<br /><br /><span class="gensmall">{postrow.POST_DATE}</span></span></td>
	<td width="100%" valign="top" class="row"><span class="postdetails">{postrow.POST_SUBJECT}</span><br />
		<hr size="1" />
		<span class="postbody">{postrow.MESSAGE}</span></td> 
	</td>
	<td width="5%" align="center" class="row">{postrow.S_SPLIT_CHECKBOX}</td>
</tr>
<!-- END postrow -->
<tr> 
	<td class="catBottom" colspan="3" height="28" align="right"><input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" />&nbsp;<input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" />{S_HIDDEN_FIELDS}</td>
</tr>
</table>{TPL_FTR}

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>
