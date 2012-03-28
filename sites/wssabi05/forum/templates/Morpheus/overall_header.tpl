<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Author" content="http://www.phpbbstyles.com" />
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<link rel="stylesheet" href="{T_TEMPLATE_PATH}/style_{TPL_COLOR}.css" type="text/css" />
<style type="text/css">
<!--
@import url("{T_TEMPLATE_PATH}/formIE.css"); 
-->
</style>
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
{CA_XS_COMMENT_JS_START}
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
{CA_XS_COMMENT_JS_END}
//-->
</script>
<!-- END switch_enable_pm_popup -->
<script language="javascript" type="text/javascript">
<!--

var PreloadFlag = false;
var expDays = 90;
var exp = new Date(); 
var tmp = '';
var tmp_counter = 0;
var tmp_open = 0;

exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function SetCookie(name, value) 
{
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape(value) +
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
		((path == null) ? "" : ("; path=" + path)) +
		((domain == null) ? "" : ("; domain=" + domain)) +
		((secure == true) ? "; secure" : "");
}

function getCookieVal(offset) 
{
	var endstr = document.cookie.indexOf(";",offset);
	if (endstr == -1)
	{
		endstr = document.cookie.length;
	}
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie(name) 
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) 
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return getCookieVal(j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break;
	} 
	return null;
}

function ShowHide(id1, id2, id3) 
{
	var res = expMenu(id1);
	if (id2 != '') expMenu(id2);
	if (id3 != '') SetCookie(id3, res, exp);
}
	
function expMenu(id) 
{
	var itm = null;
	if (document.getElementById) 
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	} 
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	if (!itm) 
	{
		// do nothing
	}
	else if (itm.style) 
	{
		if (itm.style.display == "none")
		{ 
			itm.style.display = ""; 
			return 1;
		}
		else
		{
			itm.style.display = "none"; 
			return 2;
		}
	}
	else 
	{
		itm.visibility = "show"; 
		return 1;
	}
}

//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#3B88C5" vlink="#3279B2" alink="#FF9C00">
<a name="top"></a>
<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
<tr>
	<td width="10" class="border_left"><img src="{T_TEMPLATE_PATH}/images/spacer.gif" width="10" height="1" alt="" /></td>
	<td width="100%" height="100%" class="content" align="center" valign="top">
	<div id="header-box">
		<div id="header-left"><a href="{U_INDEX}"><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/logo_left.gif" width="125" height="69" alt="{L_INDEX}" /></a></div>
 		<div id="header-right"><img src="{T_TEMPLATE_PATH}/images/{TPL_COLOR}/logo_right.gif" width="125" height="69" alt="" /></div>
		<div id="header-center">
			<b>{SITENAME}</b><br />
			{SITE_DESCRIPTION}
		</div>
	</div>
	<div id="navigation">
			<!-- BEGIN switch_user_logged_out -->
			&nbsp;<a href="{U_REGISTER}">{L_REGISTER}</a>&nbsp; | 
			<!-- END switch_user_logged_out -->
			&nbsp;<a href="{U_FAQ}">{L_FAQ}</a>&nbsp; | 
			&nbsp;<a href="{U_SEARCH}">{L_SEARCH}</a>&nbsp; | 
			&nbsp;<a href="{U_MEMBERLIST}">{L_MEMBERLIST}</a>&nbsp; | 
			&nbsp;<a href="{U_GROUP_CP}">{L_USERGROUPS}</a>&nbsp; | 
			<!-- BEGIN switch_user_logged_in -->
			&nbsp;<a href="{U_PROFILE}">{L_PROFILE}</a>&nbsp; | 
			&nbsp;<a href="{U_PRIVATEMSGS}">{L_PRIVATEMSGS}{C_PM}</a>&nbsp; | 
			<!-- END switch_user_logged_in -->
			&nbsp;<a href="{U_LOGIN_LOGOUT}">{CA_L_LOGIN_LOGOUT}</a>&nbsp;
	</div>
	<div id="content">
	<!-- BEGIN switch_xs_enabled -->
	<?php if($this->vars['CA_NEW_MSGS'] && $this->vars['PRIVATE_MESSAGE_INFO'] !== $this->vars['CA_L_NO_MSG'] && !defined('CA_POPUP_SHOWED')) { ?>
	<div id="newmsgs"><a href="{U_PRIVATEMSGS}" class="newmsgs">{PRIVATE_MESSAGE_INFO}</a></div>
	<?php define('CA_POPUP_SHOWED', true); } ?>
	<!-- END switch_xs_enabled -->

	<!-- BEGIN ca_new_privmsgs -->
	{CA_XS_COMMENT_START}<div id="newmsgs"><a href="{U_PRIVATEMSGS}" class="newmsgs">{ca_new_privmsgs.TEXT}</a></div>{CA_XS_COMMENT_END}
	<!-- END ca_new_privmsgs -->
