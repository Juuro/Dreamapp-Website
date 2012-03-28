<div id="serendipityCommentFormC" class="add_comment">
    <h3 id="respond">{$CONST.ADD_COMMENT}</h3>
    <div id="serendipity_replyform_0"></div>
    <a id="serendipity_CommentForm"></a>
    <form id="commentform" action="{$commentform_action}#feedback" method="post">
        <div id="hidden_fields">
            <input type="hidden" name="serendipity[entry_id]" value="{$commentform_id}" />
            <input type="hidden" name="serendipity[replyTo]" value="0" />
        </div>

        <div class="text_fields">
            <p><label for="author"><small>{$CONST.NAME}</small></label><input type="text" id="author" name="serendipity[name]" value="{$commentform_name}" size="22" tabindex="1" /></p>
            <p><label for="email"><small>{$CONST.EMAIL}</small></label><input type="text" id="email" name="serendipity[email]" value="{$commentform_email}" size="22" tabindex="2" /></p>
            <p><label for="url"><small>{$CONST.HOMEPAGE}</small></label><input type="text" id="url" name="serendipity[url]" value="{$commentform_url}" size="22" tabindex="3" /></p>
        </div>

        <p class="text_area"><textarea rows="10" cols="100%" tabindex="4" id="comment" name="serendipity[comment]">{$commentform_data}</textarea></p>

        {serendipity_hookPlugin hook="frontend_comment" data=$commentform_entry}
    {if $is_commentform_showToolbar}
        <p class="check_fields"><input id="checkbox_remember" type="checkbox" name="serendipity[remember]" {$commentform_remember} /><label for="checkbox_remember">{$CONST.REMEMBER_INFO}</label></p>
      {if $is_allowSubscriptions}
        <p class="check_fields"><input id="checkbox_subscribe" type="checkbox" name="serendipity[subscribe]" {$commentform_subscribe} /><label for="checkbox_subscribe">{$CONST.SUBSCRIBE_TO_THIS_ENTRY}</label></p>
      {/if}
    {/if}
    {if $is_moderate_comments}
        <p class="serendipity_msg_important">{$CONST.COMMENTS_WILL_BE_MODERATED}</p>
    {/if}

        <p class="submit_btn"><input id="submit" type="submit" name="serendipity[submit]" value="{$CONST.SUBMIT_COMMENT}" /></p>
        <p class="submit_btn"><input type="submit" id="preview" name="serendipity[preview]" value="{$CONST.PREVIEW}" /></p>
    </form>
</div>
