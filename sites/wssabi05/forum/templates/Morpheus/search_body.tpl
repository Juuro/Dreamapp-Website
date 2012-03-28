<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="nav">
<tr>
	<td class="nav" align="left" valign="middle"><span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span></td>
</tr>
</table>
<br />

<form action="{S_SEARCH_ACTION}" method="POST">
{TPL_HDR1}{L_SEARCH_QUERY}{TPL_HDR2}<table class="forumline" width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr> 
		<td class="row" colspan="2" width="50%"><span class="gen">{L_SEARCH_KEYWORDS}:</span><br /><span class="gensmall">{L_SEARCH_KEYWORDS_EXPLAIN}</span></td>
		<td class="row" colspan="2" valign="top"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_keywords" size="30" /><br /><input type="radio" name="search_terms" value="any" /> {L_SEARCH_ANY_TERMS}<br /><input type="radio" name="search_terms" value="all" checked="checked" /> {L_SEARCH_ALL_TERMS}</span></td>
	</tr>
	<tr> 
		<td class="row" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}:</span><br /><span class="gensmall">{L_SEARCH_AUTHOR_EXPLAIN}</span></td>
		<td class="row" colspan="2" valign="middle"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_author" size="30" /></span></td>
	</tr>
	<tr> 
		<th colspan="4" height="25">{L_SEARCH_OPTIONS}</th>
	</tr>
	<tr> 
		<td class="row" align="right"><span class="gen">{L_FORUM}:&nbsp;</span></td>
		<td class="row"><span class="genmed"><select class="post" name="search_forum">{S_FORUM_OPTIONS}</select></span></td>
		<td class="row" align="right" nowrap="nowrap"><span class="gen">{L_SEARCH_PREVIOUS}:&nbsp;</span></td>
		<td class="row" valign="middle"><span class="genmed"><select class="post" name="search_time">{S_TIME_OPTIONS}</select><br /><input type="radio" name="search_fields" value="all" checked="checked" /> {L_SEARCH_MESSAGE_TITLE}<br /><input type="radio" name="search_fields" value="msgonly" /> {L_SEARCH_MESSAGE_ONLY}</span></td>
	</tr>
	<tr> 
		<td class="row" align="right"><span class="gen">{L_CATEGORY}:&nbsp;</span></td>
		<td class="row"><span class="genmed"><select class="post" name="search_cat">{S_CATEGORY_OPTIONS}
		</select></span></td>
		<td class="row" align="right"><span class="gen">{L_SORT_BY}:&nbsp;</span></td>
		<td class="row" valign="middle" nowrap="nowrap"><span class="genmed"><select class="post" name="sort_by">{S_SORT_OPTIONS}</select><br /><input type="radio" name="sort_dir" value="ASC" /> {L_SORT_ASCENDING}<br /><input type="radio" name="sort_dir" value="DESC" checked /> {L_SORT_DESCENDING}</span>&nbsp;</td>
	</tr>
	<tr> 
		<td class="row" align="right" nowrap="nowrap"><span class="gen">{L_DISPLAY_RESULTS}:&nbsp;</span></td>
		<td class="row" nowrap="nowrap"><input type="radio" name="show_results" value="posts" /><span class="genmed">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked" />{L_TOPICS}</span></td>
		<td class="row" align="right"><span class="gen">{L_RETURN_FIRST}</span></td>
		<td class="row"><span class="genmed"><select class="post" name="return_chars">{S_CHARACTER_OPTIONS}</select> {L_CHARACTERS}</span></td>
	</tr>
	<tr> 
		<td class="catBottom" colspan="4" align="center" height="27">{S_HIDDEN_FIELDS}<input class="liteoption" type="submit" value="{L_SEARCH}" /></td>
	</tr>
</table>{TPL_FTR}

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="right" valign="middle"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table></form>

<table width="100%" border="0">
	<tr>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>
