
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr>
	<td valign="top" width="23%">

		  {TPL_HDR1_SMALL}{L_BOARD_NAVIGATION}{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="row1" align="left"><span class="genmed" style="line-height: 150%">
				<a href="{U_PORTAL}">{L_HOME}</a><br />
				<a href="{U_INDEX}">{L_FORUM}</a><br />
				<a href="{U_MEMBERLIST}">{L_MEMBERLIST}</a><br />
				<a href="{U_FAQ}">{L_FAQ}</a><br />
				<a href="{U_SEARCH}">{L_SEARCH}</a><br />
			</span></td>
		   </tr>
		  </table>

		  <br />

		  {TPL_HDR1_SMALL}{L_STATISTICS}{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS}<br />{NEWEST_USER}<br /><br/>{TOTAL_POSTS} {TOTAL_TOPICS}<br />&nbsp;</span></td>
		   </tr>
		  </table>
		  
		  <br />

		  {TPL_HDR1_SMALL}Links{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="row1" align="center">
				<a href="http://www.phpbbstyles.com" target="_blank"><img src="{T_TEMPLATE_PATH}/images/banner.gif" width="88" height="31" alt="phpBB Styles" border="0" vspace="3" /></a>
				<a href="http://smartor.is-root.com" target="_blank"><img src="images/smartorsite_logo.gif" width="88" height="31" alt="Smartor Site" border="0" vspace="3" /></a>
			</td>
		   </tr>
		  </table>
		  
	</td>
	<td width="10"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="10" height="1" border="0" alt="" /></td>
	<td valign="top" width="55%">	

		<!-- BEGIN welcome_text -->
		{TPL_HDR1}{L_NAME_WELCOME}{TPL_HDR2}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		  <tr>
			<td class="row1" align="left"><span class="gensmall" style="line-height:150%">{WELCOME_TEXT}<br />&nbsp;</span></td>
		  </tr>
		</table>{TPL_FTR}
		
		<!-- END welcome_text -->
		<!-- BEGIN fetchpost_row -->
		{TPL_HDR1_POST}{fetchpost_row.TITLE}{TPL_HDR2}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		  <tr>
			<td class="th" align="left"><span class="gensmall">&nbsp;{L_POSTED}: <b>{fetchpost_row.POSTER}</b> @ {fetchpost_row.TIME}</span></td>
		  </tr>
		  <tr>
			<td class="row1" align="left"><span class="gensmall" style="line-height:150%">{fetchpost_row.TEXT}<br /><br />{fetchpost_row.OPEN}<a href="{fetchpost_row.U_READ_FULL}">{fetchpost_row.L_READ_FULL}</a>{fetchpost_row.CLOSE}</span></td>
		  </tr>
		  <tr>
			<td class="row3" align="left" height="24"><span class="gensmall">{L_COMMENTS}: {fetchpost_row.REPLIES} :: <a href="{fetchpost_row.U_VIEW_COMMENTS}">{L_VIEW_COMMENTS}</a> (<a href="{fetchpost_row.U_POST_COMMENT}">{L_POST_COMMENT}</a>)</span></td>
		  </tr>
		</table>{TPL_FTR}

		<!-- END fetch_post_row -->
	</td>
	<td width="10"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="10" height="1" border="0" alt="" /></td>
	<td valign="top" width="22%">
		  {TPL_HDR1_SMALL}{L_NAME_WELCOME} {U_NAME_LINK}{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="row1" align="left"><span class="gensmall">
				<!-- BEGIN switch_user_logged_in -->
				<center><br />{AVATAR_IMG}</center>
				<br />{LAST_VISIT_DATE}<br /><br />
				<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br />
				<!-- END switch_user_logged_in -->
				<br />{CURRENT_TIME}<br /><br />{S_TIMEZONE}</span>
			</td>
		   </tr>
		  </table>
		  
		  <br />
		<!-- BEGIN switch_user_logged_out -->
		<form method="post" action="{S_LOGIN_ACTION}">
		  {TPL_HDR1_SMALL}{L_LOGIN}{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr> 
			<td class="row1"><span class="gensmall" style="line-height=150%">
			<input type="hidden" name="redirect" value="{U_PORTAL}" />
			{L_USERNAME}:<br /><input class="post" type="text" name="username" size="15" /><br />
			{L_PASSWORD}:<br /><input class="post" type="password" name="password" size="15" /><br />
			<label><input class="text" type="checkbox" name="autologin" />&nbsp;{L_REMEMBER_ME}</label><br/>
			<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" /><br /><br /><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a><br /><br />{L_REGISTER_NEW_ACCOUNT}<br />&nbsp;</span></td>
		   </tr>
		  </table>
		  <br />
		</form>
		<!-- END switch_user_logged_out -->
		 {TPL_HDR1_SMALL}{L_WHO_IS_ONLINE}{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE}<br /><br />{LOGGED_IN_USER_LIST}<br /><br /><center>[ <a href="{U_VIEWONLINE}">{L_VIEW_COMPLETE_LIST}</a> ]</center><br />{RECORD_USERS}<br />&nbsp;</span></td>
		   </tr>
		  </table>
		  
		  <br />

		  {TPL_HDR1_SMALL}{L_POLL}{TPL_HDR2_SMALL}<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		   <tr>
			<td class="row1" align="left"><span class="gensmall">
				<form method="post" action="{S_POLL_ACTION}">
				<center><b>{S_POLL_QUESTION}</b></center><br />
				<!-- BEGIN poll_option_row -->
				<input type="radio" name="vote_id" value="{poll_option_row.OPTION_ID}">{poll_option_row.OPTION_TEXT}&nbsp;[{poll_option_row.VOTE_RESULT}]<br />
				<!-- END poll_option_row -->
				<br />
				<!-- BEGIN switch_user_logged_out -->
				<center>{L_LOGIN_TO_VOTE}</center>
				<!-- END switch_user_logged_out -->
				<!-- BEGIN switch_user_logged_in -->
				<center><input type="submit" class="mainoption" name="submit" value="{L_VOTE_BUTTON}" {DISABLED}></center>
				<input type="hidden" name="topic_id" value="{S_TOPIC_ID}">
				<input type="hidden" name="mode" value="vote">
				<!-- END switch_user_logged_in -->
				</form><br />
			</span></td>
		   </tr>
		  </table>
		  
		  <br />

	</td>
  </tr>
</table>

<br />