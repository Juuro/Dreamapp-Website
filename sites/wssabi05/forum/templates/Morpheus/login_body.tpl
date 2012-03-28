
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />
 
<form action="{S_LOGIN_ACTION}" method="post">
{TPL_HDR1}{L_ENTER_PASSWORD}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline" align="center">
<tr> 
	<td class="row"><table border="0" cellpadding="3" cellspacing="1" width="100%">
		  <tr> 
			<td colspan="2" align="center">&nbsp;</td>
		  </tr>
		  <tr> 
			<td width="45%" align="right"><span class="gen">{L_USERNAME}:</span></td>
			<td> 
			  <input type="text" name="username" class="post" size="25" maxlength="40" value="{USERNAME}" />
			</td>
		  </tr>
		  <tr> 
			<td align="right"><span class="gen">{L_PASSWORD}:</span></td>
			<td> 
			  <input type="password" name="password" class="post" size="25" maxlength="32" />
			</td>
		  </tr>
		  <tr align="center"> 
			<td colspan="2"><span class="gen"><label>{L_AUTO_LOGIN}: <input type="checkbox" name="autologin" checked="checked" /></label></span></td>
		  </tr>
		  <tr align="center"> 
			<td colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="login" class="mainoption" value="{L_LOGIN}" /></td>
		  </tr>
		  <tr align="center"> 
			<td colspan="2"><span class="gensmall"><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a></span></td>
		  </tr>
		</table></td>
</tr>
</table>{TPL_FTR}
</form>
