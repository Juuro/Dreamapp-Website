
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

{TPL_HDR1}{L_IP_INFO}{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
	<th height="25">{L_THIS_POST_IP}</th>
</tr>
<tr> 
	<td class="row"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen"><a href="http://whois.sc/{IP}" target="_blank">{IP}</a> [ {POSTS} ]</span></td>
		  <td align="right"><span class="gen">[ <a href="{U_LOOKUP_IP}">{L_LOOKUP_IP}</a> 
			]&nbsp;</span></td>
		</tr>
	  </table>
	</td>
</tr>
<tr> 
	<th height="25">{L_OTHER_USERS}</th>
</tr>
<!-- BEGIN userrow -->
<tr> 
	<td class="row"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen"><a href="{userrow.U_PROFILE}">{userrow.USERNAME}</a> [ {userrow.POSTS} ]</span></td>
		  <td align="right">[ <a href="{userrow.U_SEARCHPOSTS}" title="{userrow.L_SEARCH_POSTS}">{L_SEARCH}</a>  ]
			&nbsp;</td>
		</tr>
	  </table>
	</td>
</tr>
<!-- END userrow -->
<tr> 
	<th height="25">{L_OTHER_IPS}</th>
</tr>
<!-- BEGIN iprow -->
<tr> 
	<td class="row"><table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen"><a href="http://whois.sc/{iprow.IP}" target="_blank">{iprow.IP}</a> [ {iprow.POSTS} ]</span></td>
		  <td align="right"><span class="gen">[ <a href="{iprow.U_LOOKUP_IP}">{L_LOOKUP_IP}</a> 
			]&nbsp;</span></td>
		</tr>
	</table></td>
</tr>
<!-- END iprow -->
</table>{TPL_FTR}
