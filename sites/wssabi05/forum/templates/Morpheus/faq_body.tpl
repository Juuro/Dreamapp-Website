
<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a> &raquo; <a href="{U_FAQ}">{L_FAQ}</a></span></td>
</tr>
</table>
<br />

{TPL_HDR1_ORANGE}{L_FAQ_TITLE}{TPL_HDR2}<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr>
	<td class="row">
		<!-- BEGIN faq_block_link -->
		<span class="gen"><b>{faq_block_link.BLOCK_TITLE}</b></span><br />
		<!-- BEGIN faq_row_link -->
		<span class="gen"><a href="{faq_block_link.faq_row_link.U_FAQ_LINK}" class="postlink">{faq_block_link.faq_row_link.FAQ_LINK}</a></span><br />
		<!-- END faq_row_link -->
		<br />
		<!-- END faq_block_link -->
	</td>
</tr>
</table>{TPL_FTR}

<!-- BEGIN faq_block -->
{TPL_HDR1}{faq_block.BLOCK_TITLE}{TPL_HDR2}<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<!-- BEGIN faq_row -->  
<tr> 
	<td class="row" align="left" valign="top"><span class="postbody"><a name="{faq_block.faq_row.U_FAQ_ID}"></a><b>{faq_block.faq_row.FAQ_QUESTION}</b></span><br /><span class="postbody">{faq_block.faq_row.FAQ_ANSWER}<br /><a class="postlink" href="#top">{L_BACK_TO_TOP}</a></span></td>
</tr>
<tr>
	<td class="spacerow"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" alt="" width="1" height="1" /></td>
</tr>
<!-- END faq_row -->
</table>{TPL_FTR}
<!-- END faq_block -->

<table width="100%" cellspacing="2" border="0" align="center">
	<tr>
		<td align="right" valign="middle" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><br />{JUMPBOX}</td> 
	</tr>
</table>
