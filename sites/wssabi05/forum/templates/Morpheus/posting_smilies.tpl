
<script language="javascript" type="text/javascript">
<!--
function emoticon(text) {
	text = ' ' + text + ' ';
	if (opener.document.forms['post'].message.createTextRange && opener.document.forms['post'].message.caretPos) {
		var caretPos = opener.document.forms['post'].message.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		opener.document.forms['post'].message.focus();
	} else {
	opener.document.forms['post'].message.value  += text;
	opener.document.forms['post'].message.focus();
	}
}
//-->
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td>

{TPL_HDR1}{L_EMOTICONS}{TPL_HDR2}<table width="100%" border="0" cellspacing="1" cellpadding="3" class="forumline">
			<tr>
				<td class="row"><table width="100" border="0" cellspacing="0" cellpadding="4">
					<!-- BEGIN smilies_row -->
					<tr align="center" valign="middle"> 
						<!-- BEGIN smilies_col -->
						<td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
						<!-- END smilies_col -->
					</tr>
					<!-- END smilies_row -->
					<!-- BEGIN switch_smilies_extra -->
					<tr align="center"> 
						<td colspan="{S_SMILIES_COLSPAN}"><span class="genmed"><a href="{U_MORE_SMILIES}" onclick="open_window('{U_MORE_SMILIES}', 250, 300);return false" target="_smilies" class="genmed">{L_MORE_SMILIES}</a></td>
					</tr>
					<!-- END switch_smilies_extra -->
				</table></td>
			</tr>
			<tr>
				<td class="catBottom" align="center" valign="middle"><a href="javascript:window.close();" class="genmed"  style="color: #FFF; font-weight: bold">{L_CLOSE_WINDOW}</a></td>
			</tr>
		</table>{TPL_FTR}

		</td>
	</tr>
</table>
