<div id="{$plugin_contactform_pagetitle}" class="post">
  {if $plugin_contactform_articleformat}
    <h2 class="pagetitle">{$plugin_contactform_name}</h2>
  {else}
    <h2 class="pagetitle">{$plugin_contactform_pagetitle}</h2>
  {/if}

    <div>{$plugin_contactform_preface}</div>

  {if $is_contactform_sent}
    <p class="serendipity_msg_notice">{$plugin_contactform_sent}</p>
  {else}
    {if $is_contactform_error}
    <p class="serendipity_msg_important">{$plugin_contactform_error}</p>

    {foreach from=$comments_messagestack item="message"}
    <p class="serendipity_msg_important">{$message}</p>
    {/foreach}
    {/if}

    <div class="add_comment serendipityCommentForm">
        <a id="serendipity_CommentForm"></a>

        <form id="commentform" action="{$commentform_action}#feedback" method="post">
        <div>
    	    <input type="hidden" name="serendipity[subpage]" value="{$commentform_sname}" />
            <input type="hidden" name="serendipity[commentform]" value="true" />
	</div>

        <div class="text_fields">
            <p><label for="author">{$CONST.NAME}</label>
               <input type="text" id="author" name="serendipity[name]" value="{$commentform_name}" size="22" /></p>
            <p><label for="email">{$CONST.EMAIL}</label>
               <input type="text" id="email" name="serendipity[email]" value="{$commentform_email}" size="22" /></p>

            <p><label for="url">{$CONST.HOMEPAGE}</label>
               <input type="text" id="url" name="serendipity[url]" value="{$commentform_url}" size="22" /></p>
        </div>

        <p class="text_area"><textarea rows="10" cols="100%" id="comment" name="serendipity[comment]">{$commentform_data}</textarea></p>

        {serendipity_hookPlugin hook="frontend_comment" data=$commentform_entry}

        <p class="submit_btn"><input id="submit" type="submit" name="serendipity[submit]" value="{$CONST.SUBMIT_COMMENT}" /></p>
        </form>
    </div>
{/if}
</div>
