{TPL_HDR1_BLUE}{MESSAGE_TITLE}{TPL_HDR2}<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
<tr> 
  <td class="row" colspan="2"><br clear="all" />
	<table cellspacing="0" cellpadding="3" border="0" align="center">
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{POLL_QUESTION}</b></span></td>
	  </tr>
	  <tr> 
		<td align="center"> 
		  <table cellspacing="0" cellpadding="2" border="0">
			<!-- BEGIN poll_option -->
			<tr> 
			  <td align="left"><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
			  <td align="left"> 
				<table cellspacing="0" cellpadding="0" border="0">
				  <tr> 
					<td><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/voting_left.gif" width="4" alt="" height="14" /></td>
					<td><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/voting_bar.gif" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="14" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
					<td><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/voting_right.gif" width="4" alt="" height="14" /></td>
				  </tr>
				</table>
			  </td>
			  <td align="center"><b><span class="gen">&nbsp;{poll_option.POLL_OPTION_PERCENT}&nbsp;</span></b></td>
			  <td align="center"><span class="gen">[ {poll_option.POLL_OPTION_RESULT} ]</span></td>
			</tr>
			<!-- END poll_option -->
		  </table>
		</td>
	  </tr>
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span></td>
	  </tr>
	</table>
	<br clear="all" />
  </td>
</tr>
</table>{TPL_FTR}
