
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
	<td class="nav navform" align="right" valign="middle"><span class="nav"><form action="{CA_SEARCH_INDEX}" method="post" style="display: inline;">
			<input type="hidden" name="show_results" value="topics" />
			<input type="text" name="search_keywords" class="post" size="15" />
			<input type="submit" value="{L_SEARCH}" class="mainoption" />
	</form></span></td>
</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="gensmall">
	<!-- BEGIN switch_user_logged_in -->
	{PRIVATE_MESSAGE_INFO}<br />
	{LAST_VISIT_DATE}<br />
	<!-- END switch_user_logged_in -->
	{CURRENT_TIME}<br />
	{S_TIMEZONE}<br />
	</span></td>
	<td align="right" valign="bottom" class="gensmall">
		<!-- BEGIN switch_user_logged_in -->
		<a href="{U_MARK_READ}">{L_MARK_FORUMS_READ}</a><br />
		<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br />
		<a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
		<!-- END switch_user_logged_in -->
		<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a></td>
  </tr>
</table>

<!-- BEGIN switch_xs_enabled -->
<?php

$catrow_count = ( isset($this->_tpldata['catrow.']) ) ?  sizeof($this->_tpldata['catrow.']) : 0;
if($this->vars['TPL_HDR1_BLUE'])
{
	for($catrow_i = 0; $catrow_i < $catrow_count; $catrow_i++)
	{
		$catrow_item = &$this->_tpldata['catrow.'][$catrow_i];
		// check for new messages
		$new_msg = false;
		$forumrow_count = ( isset($catrow_item['forumrow.']) ) ? sizeof($catrow_item['forumrow.']) : 0;
		for ($forumrow_i = 0; $forumrow_i < $forumrow_count; $forumrow_i++)
		{
			$forumrow_item = &$catrow_item['forumrow.'][$forumrow_i];
			$new_item = strpos($forumrow_item['FORUM_FOLDER_IMG'], '_new') > 0 ? true : false;
			if($new_item)
			{
				$new_msg = true;
				$forumrow_item['XS_NEW'] = '_new';
			}
		}
		// add xs switch
		$catrow_item['TPL_HDR1'] = $new_msg ? $this->vars['TPL_HDR1_ORANGE'] : $this->vars['TPL_HDR1_BLUE'];
	}
	$old_hdr = $this->vars['TPL_HDR1_BLUE'];
	$this->vars['TPL_HDR1_BLUE'] = '';
}
?>
<!-- END switch_xs_enabled -->

<!-- BEGIN catrow -->
{catrow.TPL_HDR1}{TPL_HDR1_BLUE}<a href="javascript:ShowHide('cat_{catrow.CAT_ID}','cat2_{catrow.CAT_ID}','catrow_{catrow.CAT_ID}');">{catrow.CAT_DESC}</a>{TPL_HDR2}<div id="cat_{catrow.CAT_ID}" style="display: ''; position: relative;"><table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<tr> 
	<th colspan="2" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
</tr>
<!-- BEGIN forumrow -->
<tr> 
	<td class="row" align="center" valign="middle" width="30" height="30"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="28" height="32" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row" width="70%"><a class="forumlink{catrow.forumrow.XS_NEW}" href="{catrow.forumrow.U_VIEWFORUM}">{catrow.forumrow.FORUM_NAME}</a><br />
	  <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
	  </span><span class="moderators">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
	<td class="row" align="center" valign="middle"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	<td class="row" align="center" valign="middle"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	<td class="row" align="center" valign="middle" width="130"><span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
</tr>
<!-- END forumrow -->
</table></div><div id="cat2_{catrow.CAT_ID}" style="display: none; position: relative;"><table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline"><tr><td class="spacerow" width="100%" height="3"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="3" border="0" alt="" /></td></tr></table></div>{TPL_FTR}
<script language="javascript" type="text/javascript">
<!--
tmp = 'catrow_{catrow.CAT_ID}';
if(GetCookie(tmp) == '2')
{
	ShowHide('cat_{catrow.CAT_ID}','cat2_{catrow.CAT_ID}','catrow_{catrow.CAT_ID}');
}
//-->
</script>
<!-- END catrow -->
<!-- BEGIN switch_xs_enabled -->
<?php
	$this->vars['TPL_HDR1_BLUE'] = $old_hdr;
?>
<!-- END switch_xs_enabled -->

{TPL_HDR1}<a href="{U_VIEWONLINE}">{L_WHO_IS_ONLINE}</a>{TPL_HDR2}<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr> 
	<!-- BEGIN switch_user_logged_in -->
	<td class="row" align="center" valign="middle" rowspan="2"><img src="{T_TEMPLATE_PATH}/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<!-- END switch_user_logged_in -->
	<!-- BEGIN switch_user_logged_out -->
	<td class="row" align="center" valign="middle" rowspan="3"><img src="{T_TEMPLATE_PATH}/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<!-- END switch_user_logged_out -->
	<td class="row" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>
	</td>
</tr>
<tr> 
	<td class="row" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}<br />{L_ONLINE_EXPLAIN}</span></td>
</tr>
<!-- BEGIN switch_user_logged_out -->
<tr>
	<td class="row" align="center"><form method="post" action="{S_LOGIN_ACTION}"><span class="gensmall">
		{L_USERNAME}: <input class="post" type="text" name="username" size="10" />
		&nbsp;&nbsp;{L_PASSWORD}: <input class="post" type="password" name="password" size="10" maxlength="32" />
		&nbsp;&nbsp;<label>{L_AUTO_LOGIN} <input class="text" type="checkbox" name="autologin" checked="checked" /></label>
		&nbsp;&nbsp; <input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
	</span></form></td>
</tr>
<!-- END switch_user_logged_out -->
</table>{TPL_FTR}

<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="{T_TEMPLATE_PATH}/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{T_TEMPLATE_PATH}/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>
