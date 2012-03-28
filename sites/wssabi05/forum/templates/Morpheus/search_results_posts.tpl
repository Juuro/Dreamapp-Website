<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_SEARCH}">{L_SEARCH}</a> &raquo; <a href="#top">{L_SEARCH_MATCHES}</a></span></td>
	<td class="nav" align="right" valign="middle"><div class="pagination">{PAGINATION}</div></td>
</tr>
</table>
<br />

<!-- BEGIN searchresults -->
{TPL_HDR1}{TPL_HDR2}<table border="0" cellpadding="0" cellspacing="0" width="100%" class="post">
<tr>
	<td width="150" class="row" align="center" valign="top" style="padding: 2px;">
		<div style="padding: 3px;"><span class="name">{searchresults.POSTER_NAME}</span><br /></div>
		<br />
		<table width="100%" cellspacing="5" cellpadding="0">
			<tr><td align="left" nowrap="nowrap"><span class="postdetails">{searchresults.POST_DATE}</span></td></tr>
			<tr><td align="left" nowrap="nowrap"><span class="postdetails">{L_REPLIES}: {searchresults.TOPIC_REPLIES}</span></td></tr>
			<tr><td align="left" nowrap="nowrap"><span class="postdetails">{L_VIEWS}: {searchresults.TOPIC_VIEWS}</span></td></tr>
		</table>
		<img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="150" height="1" border="0" alt="" />
	</td>
	<td width="1" class="postborder"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="100" alt="" /></td>
	<td width="100%" class="row" align="left" valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="50%" align="left" style="padding: 3px;"><span class="postdate">
		{L_FORUM}: <a href="{searchresults.U_FORUM}">{searchresults.FORUM_NAME}</a><br />
		{L_SUBJECT}: <a href="{searchresults.U_TOPIC}">{searchresults.TOPIC_TITLE}</a><br />
		</span></td>
		<td width="50%"></td>
	</tr>
	<tr>
		<td width="50%" class="postline" height="1"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="100" height="1" alt="" /></td>
		<td height="1"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="1" alt="" /></td>
	</tr>
	</table>
	<div style="padding: 4px;"><span class="postbody">{searchresults.MESSAGE}</span></div>
	</td>
</tr>
</table>{TPL_FTR}
<!-- END searchresults -->

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="top"><span class="genmed">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><div class="pagination">{PAGINATION}</div><br /><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
