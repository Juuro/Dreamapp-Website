<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />


<script language="JavaScript" type="text/javascript">
<!--
function checkForm(formObj) {

	formErrors = false;    

	if (formObj.message.value.length < 2) {
		formErrors = "{L_EMPTY_MESSAGE_EMAIL}";
	}
	else if ( formObj.subject.value.length < 2)
	{
		formErrors = "{L_EMPTY_SUBJECT_EMAIL}";
	}

	if (formErrors) {
		alert(formErrors);
		return false;
	}
}
//-->
</script>

<form action="{S_POST_ACTION}" method="post" name="post" onSubmit="return checkForm(this)">

{ERROR_BOX}

{TPL_HDR1}{L_SEND_EMAIL_MSG}{TPL_HDR2}<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<td class="row" width="22%"><span class="gen"><b>{L_RECIPIENT}</b></span></td>
		<td class="row" width="78%"><span class="gen"><b>{USERNAME}</b></span> </td>
	</tr>
	<tr> 
		<td class="row" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
		<td class="row" width="78%"><span class="gen"><input type="text" name="subject" size="45" maxlength="100" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" /></span> </td>
	</tr>
	<tr> 
		<td class="row" valign="top"><span class="gen"><b>{L_MESSAGE_BODY}</b></span><br /><span class="gensmall">{L_MESSAGE_BODY_DESC}</span></td>
		<td class="row"><span class="gen"><textarea name="message" rows="25" cols="40" wrap="virtual" style="width:500px" tabindex="3" class="post">{MESSAGE}</textarea></span></td>
	</tr>
	<tr> 
		<td class="row" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span></td>
		<td class="row"><table cellspacing="0" cellpadding="1" border="0">
			<tr> 
				<td><input type="checkbox" name="cc_email"  value="1" checked="checked" /></td>
				<td><span class="gen">{L_CC_EMAIL}</span></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td class="th" colspan="2" align="center" height="25">{S_HIDDEN_FIELDS}<input type="submit" tabindex="6" name="submit" class="mainoption" value="{L_SEND_EMAIL}" /></td>
	</tr>
</table>{TPL_FTR}

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
		<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table></form>

<table width="100%" cellspacing="2" border="0" align="center">
	<tr>
		<td valign="top" align="right">{JUMPBOX}</td>
	</tr>
</table>
