<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

<!-- BEGIN switch_groups_joined -->
{TPL_HDR1}{L_GROUP_MEMBERSHIP_DETAILS}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<!-- BEGIN switch_groups_member -->
<tr> 
	<td class="row"><span class="gen">{L_YOU_BELONG_GROUPS}</span></td>
	<td class="row" align="right"><table width="90%" cellspacing="0" cellpadding="0" border="0">
	<tr><form method="get" action="{S_USERGROUP_ACTION}">
		<td width="40%"><span class="gensmall">{GROUP_MEMBER_SELECT}</span></td>
		<td align="center" width="30%"> 
			<input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
		</td>
	</form></tr>
	</table></td>
</tr>
<!-- END switch_groups_member -->
<!-- BEGIN switch_groups_pending -->
<tr> 
	<td class="row"><span class="gen">{L_PENDING_GROUPS}</span></td>
	<td class="row" align="right"> 
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><span class="gensmall">{GROUP_PENDING_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
  </tr>
<!-- END switch_groups_pending -->
</table>{TPL_FTR}
<!-- END switch_groups_joined -->

<!-- BEGIN switch_groups_remaining -->
{TPL_HDR1}{L_JOIN_A_GROUP}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
	<td class="row"><span class="gen">{L_SELECT_A_GROUP}</span></td>
	<td class="row" align="right"> 
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><span class="gensmall">{GROUP_LIST_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
  </tr>
</table>{TPL_FTR}
<!-- END switch_groups_remaining -->

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<br />

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
