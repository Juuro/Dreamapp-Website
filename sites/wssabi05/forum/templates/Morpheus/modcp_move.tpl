
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

<form action="{S_MODCP_ACTION}" method="post">
{TPL_HDR1}{MESSAGE_TITLE}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <td class="row"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center"><span class="gen">{L_MOVE_TO_FORUM} &nbsp; {S_FORUM_SELECT}<br /><br />
			  <label><input type="checkbox" name="move_leave_shadow" />{L_LEAVESHADOW}</label><br />
			  <br />
			  {MESSAGE_TEXT}</span><br />
			  <br />
			  {S_HIDDEN_FIELDS} 
			  <input class="mainoption" type="submit" name="confirm" value="{L_YES}" />
			  &nbsp;&nbsp; 
			  <input class="liteoption" type="submit" name="cancel" value="{L_NO}" />
			</td>
		  </tr>
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>{TPL_FTR}
</form>
