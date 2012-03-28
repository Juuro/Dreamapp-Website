
<form method="post" action="{S_MODE_ACTION}">
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
	<td class="nav" align="right" nowrap="nowrap"><span class="nav">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" /></span></td>
</tr>
</table>
<br />

{TPL_HDR1}{PAGE_TITLE}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" nowrap="nowrap">#</th>
	  <th nowrap="nowrap">&nbsp;</th>
	  <th nowrap="nowrap">{L_USERNAME}</th>
	  <th nowrap="nowrap">{L_EMAIL}</th>
	  <th nowrap="nowrap">{L_FROM}</th>
	  <th nowrap="nowrap">{L_JOINED}</th>
	  <th nowrap="nowrap">{L_POSTS}</th>
	  <th nowrap="nowrap">{L_WEBSITE}</th>
	</tr>
	<!-- BEGIN memberrow -->
	<tr> 
	  <td class="row" align="center"><span class="gen">&nbsp;{memberrow.ROW_NUMBER}&nbsp;</span></td>
	  <td class="row" align="center">&nbsp;{memberrow.PM_IMG}&nbsp;</td>
	  <td class="row" align="center"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a></span></td>
	  <td class="row" align="center" valign="middle">&nbsp;{memberrow.EMAIL_IMG}&nbsp;</td>
	  <td class="row" align="center" valign="middle"><span class="gen">{memberrow.FROM}</span></td>
	  <td class="row" align="center" valign="middle"><span class="gensmall">{memberrow.JOINED}</span></td>
	  <td class="row" align="center" valign="middle"><span class="gen">{memberrow.POSTS}</span></td>
	  <td class="row" align="center">&nbsp;{memberrow.WWW_IMG}&nbsp;</td>
	</tr>
	<!-- END memberrow -->
</table>{TPL_FTR}

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
	<td><span class="gen">{PAGE_NUMBER}</span></td>
	<td align="right"><div class="pagination">{PAGINATION}</div></td>
  </tr>
</table>
</form>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
