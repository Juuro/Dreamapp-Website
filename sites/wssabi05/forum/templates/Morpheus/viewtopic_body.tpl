<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
	<td class="nav navform" align="right" valign="middle" nowrap="nowrap"><span class="nav"><form action="{CA_SEARCH_INDEX}" method="post" style="display: inline;"><input type="hidden" name="show_results" value="topics" /><input type="hidden" name="search_forum" value="{CA_SEARCH_FORUM}" />
	<input type="text" name="search_keywords" class="post" size="15" />
	<input type="submit" value="{L_SEARCH}" class="mainoption" />
	</form></span></td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
    <td align="left" valign="middle"><a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></td>
	 <td align="right" valign="middle"><div class="pagination">{PAGINATION}</div></td>
  </tr>
</table>

{POLL_DISPLAY} 

<!-- BEGIN switch_xs_enabled -->
<?php

global $userdata, $board_config, $topic_id, $is_auth, $forum_topic_data, $lang, $phpEx;

if(!isset($can_reply))
{
	$can_reply = $userdata['session_logged_in'] ? true : false;
	if($can_reply)
	{
		$is_auth_type = 'auth_reply';
		if(!$is_auth[$is_auth_type])
		{
			$can_reply = false;
		}
		elseif ( ($forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED) && !$is_auth['auth_mod'] ) 
		{
			$can_reply = false;
		}
	}
	if($can_reply)
	{
		$this->assign_block_vars('xs_quick_reply', array());
	}
}

if($this->vars['TPL_HDR1_POST'])
{
	$postrow_count = ( isset($this->_tpldata['postrow.']) ) ?  sizeof($this->_tpldata['postrow.']) : 0;
	for ($postrow_i = 0; $postrow_i < $postrow_count; $postrow_i++)
	{
		$postrow_item = &$this->_tpldata['postrow.'][$postrow_i];
		// set profile link and search button
		if(!empty($postrow_item['PROFILE']) && strpos($postrow_item['POSTER_NAME'], '<') === false)
		{
			$postrow_item['SEARCH_IMG2'] = str_replace('%s', htmlspecialchars($postrow_item['POSTER_NAME']), $postrow_item['SEARCH_IMG']);
			$search = array($lang['Read_profile'], '<a ');
			$replace = array($postrow_item['POSTER_NAME'], '<a class="name" ');
			$postrow_item['POSTER_NAME'] = str_replace($search, $replace, $postrow_item['PROFILE']);
		}
		// check for new post
		$new_post = strpos($postrow_item['MINI_POST_IMG'], '_new') > 0 ? true : false;
		$postrow_item['TPL_HDR1'] = $new_post ? $this->vars['TPL_HDR1_NEW'] : $this->vars['TPL_HDR1_POST'];
	}	
	$old_hdr = $this->vars['TPL_HDR1_POST'];
	$this->vars['TPL_HDR1_POST'] = '';
}
?>
<!-- END switch_xs_enabled -->
<!-- BEGIN postrow -->
<a name="{postrow.U_POST_ID}"></a>
{TPL_HDR1_POST}{postrow.TPL_HDR1}{postrow.POST_SUBJECT}{TPL_HDR2}<table border="0" cellpadding="0" cellspacing="0" width="100%" class="post">
<tr>
	<td width="150" class="row" align="center" valign="top" style="padding: 2px;" rowspan="2">
		<div style="padding: 3px;"><span class="name">{postrow.POSTER_NAME}</span><br /></div>
		<div style="padding: 2px;"><span class="postdetails">{postrow.POSTER_RANK}</span><br /></div>
		{postrow.RANK_IMAGE}
		<div style="width: 140px; margin: auto; overflow: hidden">{postrow.POSTER_AVATAR}</div>
		<br />
		<table width="100%" cellspacing="5" cellpadding="0">
			<tr><td align="left"><span class="postdetails">{postrow.POSTER_JOINED}</span></td></tr>
			<tr><td align="left"><span class="postdetails">{postrow.POSTER_POSTS}</span></td></tr>
			<tr><td align="left"><span class="postdetails">{postrow.POSTER_FROM}</span></td></tr>
		</table>
		<img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="150" height="1" border="0" alt="" />
	</td>
	<td width="1" class="postborder" rowspan="2"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="100" alt="" /></td>
	<td width="100%" class="row" align="left" valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="50%" align="left" style="padding: 3px;"><span class="postdate"><a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a> {L_POSTED}: {postrow.POST_DATE}</span></td>
		<td width="50%"></td>
		<td width="23" valign="top" class="posttop" align="left"><img src="{T_TEMPLATE_PATH}/images/posttop_left.gif" width="23" height="9" border="0" alt="" /></td>
		<td class="posttop" nowrap="nowrap" valign="top">{postrow.QUOTE_IMG}{postrow.EDIT_IMG}{postrow.DELETE_IMG}{postrow.IP_IMG}</td>
	</tr>
	<tr>
		<td width="50%" class="postline" height="1"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="100" height="1" alt="" /></td>
		<td colspan="3" height="1"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="1" height="1" alt="" /></td>
	</tr>
	</table>
	<div style="padding: 4px;" class="postbody">{postrow.MESSAGE}</div>
	</td>
</tr>
<tr>
	<td align="left" valign="bottom">
	<div style="padding: 5px;" class="postbody"><span class="signature"><span class="gensmall">{postrow.EDITED_MESSAGE}</span>{postrow.SIGNATURE}</span></div>
	<table width="100%" height="9" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="postbottom" height="9" nowrap="nowrap">{postrow.PROFILE_IMG}{postrow.SEARCH_IMG2}{postrow.PM_IMG}{postrow.EMAIL_IMG}{postrow.WWW_IMG}{postrow.AIM_IMG}{postrow.YIM_IMG}{postrow.MSN_IMG}{postrow.ICQ_IMG}</td>
		<td width="100%" height="9" align="left"><img src="{T_TEMPLATE_PATH}/images/postbottom_right.gif" width="22" height="9" alt="" /></td>
	</tr>
	</table></td>
</tr>
</table>{TPL_FTR}
<!-- END postrow -->

{TPL_HDR1_ORANGE}<a href="{U_VIEW_TOPIC}">{TOPIC_TITLE}{TPL_HDR2}<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
<tr>
	<td class="row" align="left" valign="top">
	<table border="0" cellspacing="0" cellpadding="5" width="100%">
	<tr>
		<td align="left" valign="top">
			<span class="gensmall">{S_AUTH_LIST}</span>
		</td>
		<td align="right" valign="top">
			<span class="gensmall">{S_TIMEZONE}&nbsp;&nbsp;<br />
			{PAGE_NUMBER}&nbsp;&nbsp;</span>
			<div class="pagination">{PAGINATION}</div><br />
			<span class="gensmall">{S_WATCH_TOPIC}</span>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td class="catBottom" align="center" valign="middle" nowrap="nowrap"><table border="0" cellspacing="0" cellpadding="2" width="100%">
	<tr>
		<form method="post" action="{S_POST_DAYS_ACTION}" style="display: inline;"><td align="left" valign="middle" nowrap="nowrap">{S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></td></form>
		<td align="right" valign="middle" nowrap="nowrap">{JUMPBOX}</td>
	</tr>
	</table>
	</td>
</tr>
</table>{TPL_FTR}

<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
	<td class="nav navform" align="right" valign="middle" nowrap="nowrap"><span class="nav"><form action="{CA_SEARCH_INDEX}" method="post" style="display: inline;"><input type="hidden" name="show_results" value="topics" /><input type="hidden" name="search_forum" value="{CA_SEARCH_FORUM}" />
	<input type="text" name="search_keywords" class="post" size="15" />
	<input type="submit" value="{L_SEARCH}" class="mainoption" />
	</form></span></td>
</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td align="left" valign="top" style="padding-top: 5px; padding-bottom: 5px;">&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a>
	<!-- BEGIN xs_quick_reply -->
	&nbsp;<a href="javascript:ShowHide('quick_reply','quick_reply2');"><img src="{T_TEMPLATE_PATH}/images/lang_{LANG}/{TPL_COLOR}/quick_reply.gif" border="0" alt="{CA_QR_BUTTON}" align="middle" /></a>
	<!-- END xs_quick_reply -->
	</td>
	<td align="right" valign="top" style="padding-top: 5px;">{S_TOPIC_ADMIN}&nbsp;</td>
</tr>
</table>

<!-- BEGIN xs_quick_reply -->
<?php
	/*
		This is quick reply mod for Morpheus phpBB style.
		This code will be executed only if you have eXtreme Styles mod installed and if user has permission to post reply.
		If you do not have eXtreme Styles mod on your forum this code will not be visible and you can simply ignore it.
	*/
?>
<div id="quick_reply" style="display: none; position: relative; "><form action="<?php echo append_sid('posting.'.$phpEx); ?>" method="post" name="post" style="display: inline;">{S_HIDDEN_FIELDS}{TPL_HDR1}{CA_QR_BUTTON}{TPL_HDR2}<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
<tr> 
	<td class="row" width="200"><span class="gen"><b><?php echo $lang['Subject']; ?>:</b></span></td>
	<td class="row" width="100%"><input type="text" name="subject" size="45" maxlength="60" style="width:98%" tabindex="2" class="post" value="" /></td>
</tr>
<tr> 
	<td class="row" width="200"><span class="gen"><b><?php echo $lang['Message_body']; ?>:<br /><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="200" height="1" border="0" alt="" /></b></span></td>
	<td class="row" width="100%"><textarea name="message" rows="15" cols="35" wrap="virtual" style="width:98%" tabindex="3" class="post"></textarea></td>
</tr>
<tr> 
	<td class="row" valign="top"><span class="gen"><b><?php echo $lang['Options']; ?>:</b></span></td>
	<td class="row"><table cellspacing="0" cellpadding="1" border="0">
	<?php 
		$user_sig = ( $userdata['user_sig'] != '' && $board_config['allow_sig'] ) ? $userdata['user_sig'] : '';
		$html_on = $board_config['allow_html'] ? $userdata['user_allowhtml'] : 1;
		$bbcode_on = $board_config['allow_bbcode'] ? $userdata['user_allowbbcode'] : 0;
		$smilies_on = $board_config['allow_smilies'] ? $userdata['user_allowsmile'] : 0;
	?>
	<?php if($board_config['allow_html']) { ?>
	<tr> 
		<td><input type="checkbox" name="disable_html" <?php echo ($html_on ? '' : 'checked="checked"'); ?> /></td>
		<td><span class="gen"><?php echo $lang['Disable_HTML_post']; ?></span></td>
	</tr>
	<?php } else { ?><input type="hidden" name="disable_html" value="checked" /><?php } ?>
	<?php if($board_config['allow_bbcode']) { ?>
	<tr> 
		<td><input type="checkbox" name="disable_bbcode" <?php echo ($bbcode_on ? '' : 'checked="checked"'); ?> /></td>
		<td><span class="gen"><?php echo $lang['Disable_BBCode_post']; ?></span></td>
	</tr>
	<?php } else { ?><input type="hidden" name="disable_bbcode" value="checked" /><?php } ?>
	<?php if($board_config['allow_smilies']) { ?>
	<tr> 
		<td><input type="checkbox" name="disable_smilies" <?php echo ($smilies_on ? '' : 'checked="checked"'); ?>  /></td>
		<td><span class="gen"><?php echo $lang['Disable_Smilies_post']; ?></span></td>
	</tr>
	<?php } else { ?><input type="hidden" name="disable_smilies" value="checked" /><?php } ?>
	<?php if($user_sig) {  ?>
	<tr> 
		<td><input type="checkbox" name="attach_sig" <?php echo ($userdata['user_attachsig'] ? 'checked="checked"' : ''); ?> /></td>
		<td><span class="gen"><?php echo $lang['Attach_signature']; ?></span></td>
	</tr>
	<?php } else { ?><input type="hidden" name="attach_sig" value="" /><?php } ?>
	<tr> 
		<td><input type="checkbox" name="notify" <?php echo ($userdata['user_notify'] ? 'checked="checked"' : ''); ?> /></td>
		<td><span class="gen"><?php echo $lang['Notify']; ?></span></td>
	</tr>
	</table></td>
</tr>
<tr> 
	<td class="catBottom" colspan="2" align="center" height="25"> <input type="hidden" name="mode" value="reply" /><input type="hidden" name="t" value="<?php echo $topic_id; ?>" /><input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="<?php echo $lang['Submit']; ?>" />&nbsp;<input type="submit" tabindex="5" name="preview" class="mainoption" value="<?php echo $lang['Preview']; ?>" /></td>
</tr>
</table>{TPL_FTR}</form></div>
<!-- END xs_quick_reply -->
