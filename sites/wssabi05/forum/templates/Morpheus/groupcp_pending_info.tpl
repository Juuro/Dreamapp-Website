{TPL_HDR1}{L_PENDING_MEMBERS}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
	<th height="25">{L_PM}</th>
	<th>{L_USERNAME}</th>
	<th>{L_POSTS}</th>
	<th>{L_FROM}</th>
	<th>{L_EMAIL}</th>
	<th>{L_WEBSITE}</th>
	<th>{L_SELECT}</th>
</tr>
<!-- BEGIN pending_members_row -->
<tr> 
	<td class="row" align="center"> {pending_members_row.PM_IMG} </td>
	<td class="row" align="center"><span class="gen"><a href="{pending_members_row.U_VIEWPROFILE}" class="gen">{pending_members_row.USERNAME}</a></span></td>
	<td class="row" align="center"><span class="gen">{pending_members_row.POSTS}</span></td>
	<td class="row" align="center"><span class="gen">{pending_members_row.FROM}</span></td>
	<td class="row" align="center"><span class="gen">{pending_members_row.EMAIL_IMG}</span></td>
	<td class="row" align="center"><span class="gen">{pending_members_row.WWW_IMG}</span></td>
	<td class="row" align="center"><input type="checkbox" name="pending_members[]" value="{pending_members_row.USER_ID}" checked="checked" /></td>
</tr>
<!-- END pending_members_row -->
<tr> 
	<td class="catBottom" colspan="8" align="right"><span class="gen"><input type="submit" name="approve" value="{L_APPROVE_SELECTED}" class="mainoption" />&nbsp;<input type="submit" name="deny" value="{L_DENY_SELECTED}" class="liteoption" /></span></td>
</tr>
</table>{TPL_FTR}
