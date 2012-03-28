<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

<table cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
  <td><span class="forumlink">{INBOX} &nbsp;</span></td>
  <td><span class="forumlink">{SENTBOX} &nbsp;</span></td>
  <td><span class="forumlink">{OUTBOX} &nbsp;</span></td>
  <td><span class="forumlink">{SAVEBOX} &nbsp;</span></td>
  </tr>
</table>

<br />

<form method="post" action="{S_PRIVMSGS_ACTION}">
{S_HIDDEN_FIELDS}

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	  <td valign="middle">{REPLY_PM_IMG}</td>
  </tr>
</table>

{TPL_HDR1_NEW}{POST_SUBJECT}{TPL_HDR2}<table border="0" cellpadding="0" cellspacing="0" width="100%" class="post">
<tr>
	<td width="150" class="row" align="center" valign="top" style="padding: 2px;" rowspan="2">
		<div style="padding: 3px;"><span class="name">{MESSAGE_FROM}</span><br /></div>
		<br />
		<table width="100%" cellspacing="5" cellpadding="0">
			<tr>
				<td align="left" nowrap="nowrap"><span class="postdetails">{L_POSTED}:</span></td>
				<td align="left" width="100%"><span class="postdetails">{POST_DATE}</span></td>
			</tr>
		</table>
		<img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="150" height="1" border="0" alt="" />
	</td>
	<td width="1" class="postborder" rowspan="2"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="100" alt="" /></td>
	<td width="100%" class="row" align="left" valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="50%" align="left" style="padding: 3px;"><span class="postdate">{L_POSTED}: {POST_DATE}</span></td>
		<td width="50%"></td>
		<td width="23" valign="top" class="posttop" align="left"><img src="{T_TEMPLATE_PATH}/images/posttop_left.gif" width="23" height="9" border="0" alt="" /></td>
		<td class="posttop" nowrap="nowrap" valign="top">{QUOTE_PM_IMG}{EDIT_PM_IMG}</td>
	</tr>
	<tr>
		<td width="50%" class="postline" height="1"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="100" height="1" alt="" /></td>
		<td colspan="3" height="1"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="1" alt="" /></td>
	</tr>
	</table>
	<div style="padding: 4px;" class="postbody">{MESSAGE}</div>
	</td>
</tr>
<tr>
	<td align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="postbottom" nowrap="nowrap" valign="bottom">{PROFILE_IMG}{PM_IMG}{EMAIL_IMG}{WWW_IMG}{AIM_IMG}{YIM_IMG}{MSN_IMG}{ICQ_IMG}</td>
		<td width="22" align="left" valign="bottom"><img src="{T_TEMPLATE_PATH}/images/postbottom_right.gif" width="22" height="9" alt="" /></td>
		<td width="100%" align="right" valign="bottom"><span class="gensmall"><input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption" />&nbsp;<input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption" />&nbsp;</span></td>
	</tr>
	</table></td>
</tr>
</table>{TPL_FTR}

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td>{REPLY_PM_IMG}</td>
	  <td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table>
</form>



<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td valign="top" align="right"><span class="gensmall">{JUMPBOX}</span></td>
  </tr>
</table>
