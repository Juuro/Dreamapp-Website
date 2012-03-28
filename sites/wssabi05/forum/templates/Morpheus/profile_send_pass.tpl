<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

<form action="{S_PROFILE_ACTION}" method="post">
{TPL_HDR1}{L_SEND_PASSWORD}{TPL_HDR2}<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="row" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<tr> 
	  <td class="row" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
	  <td class="row"> 
		<input type="text" class="post" style="width: 200px" name="username" size="25" maxlength="40" value="{USERNAME}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
	  <td class="row"> 
		<input type="text" class="post" style="width: 200px" name="email" size="25" maxlength="255" value="{EMAIL}" />
	  </td>
	</tr>
	<tr> 
	  <td class="th" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	  </td>
	</tr>
  </table>{TPL_FTR}
</form>
