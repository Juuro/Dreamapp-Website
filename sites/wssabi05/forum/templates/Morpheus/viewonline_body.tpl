
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

{TPL_HDR1_ORANGE}{L_WHO_IS_ONLINE}{TPL_HDR2}<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th width="35%" height="25">&nbsp;{L_USERNAME}&nbsp;</th>
	<th width="25%">&nbsp;{L_LAST_UPDATE}&nbsp;</th>
	<th width="40%">&nbsp;{L_FORUM_LOCATION}&nbsp;</th>
  </tr>
  <tr> 
	<td class="row" colspan="3" height="28"><span class="genmed"><b>{TOTAL_REGISTERED_USERS_ONLINE}</b></span></td>
  </tr>
  <!-- BEGIN reg_user_row -->
  <tr> 
	<td width="35%" class="row">&nbsp;<span class="gen"><a href="{reg_user_row.U_USER_PROFILE}" class="gen">{reg_user_row.USERNAME}</a></span>&nbsp;</td>
	<td width="25%" align="center" nowrap="nowrap" class="row">&nbsp;<span class="gen">{reg_user_row.LASTUPDATE}</span>&nbsp;</td>
	<td width="40%" class="row">&nbsp;<span class="gen"><a href="{reg_user_row.U_FORUM_LOCATION}" class="gen">{reg_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
  </tr>
  <!-- END reg_user_row -->
  <tr> 
	<td colspan="3" height="1" class="spacerow"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="1" alt="."></td>
  </tr>
  <tr> 
	<td class="row" colspan="3" height="28"><span class="genmed"><b>{TOTAL_GUEST_USERS_ONLINE}</b></span></td>
  </tr>
  <!-- BEGIN guest_user_row -->
  <tr> 
	<td width="35%" class="row">&nbsp;<span class="gen">{guest_user_row.USERNAME}</span>&nbsp;</td>
	<td width="25%" align="center" nowrap="nowrap" class="row">&nbsp;<span class="gen">{guest_user_row.LASTUPDATE}</span>&nbsp;</td>
	<td width="40%" class="row">&nbsp;<span class="gen"><a href="{guest_user_row.U_FORUM_LOCATION}" class="gen">{guest_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
  </tr>
  <!-- END guest_user_row -->
</table>{TPL_FTR}

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
	<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<br />

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>

