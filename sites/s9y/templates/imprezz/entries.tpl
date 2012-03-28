{serendipity_hookPlugin hook="entries_header" addData="$entry_id"}

{foreach from=$entries item="dategroup"}
  {foreach from=$dategroup.entries item="entry"}
    <div id="post-{$entry.id}" class="post">
        <div class="PostHead">
            <div class="PostTime">
                <b>{$entry.timestamp|@formatTime:'%d'}</b>
                <i>{$entry.timestamp|@formatTime:'%b %Y'}</i>
            </div>

            <h2><a title="Permanent Link: {$entry.title}" href="{$entry.link}" rel="bookmark">{$entry.title}</a>{if $dategroup.is_sticky} ({$CONST.STICKY_POSTINGS}){/if}</h2>

            <small class="PostDet">{if $entry.is_entry_owner and not $is_preview}<a href="{$entry.link_edit}">{$CONST.EDIT_ENTRY}</a> | {/if}Author: {$entry.author}{if $entry.categories} | Filed under: {foreach from=$entry.categories item="entry_category" name="categories"}<a href="{$entry_category.category_link}">{$entry_category.category_name|@escape}</a>{if not $smarty.foreach.categories.last}, {/if}{/foreach}{/if}</small>
        </div><!-- /.PostHead -->

        <div class="entry">
            {$entry.body}
          {if $entry.is_extended}
            <div id="extended">{$entry.extended}</div>
          {/if}
          {if $entry.has_extended and not $is_single_entry and not $entry.is_extended}
            <p class="serif"><a href="{$entry.link}#extended">Read the rest of this entry &raquo;</a></p>
          {/if}
        </div><!-- /.entry -->

        <p class="postmetadata">
        {$entry.add_footer}
        {$entry.plugin_display_dat}
        </p>

      {if $entry.has_comments and not $is_single_entry}
        <div class="comments"><a href="{$entry.link}#comments"><span> {$entry.comments} </span> {$entry.label_comments}</a></div>
      {/if}

        <!--
        <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                 xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/"
                 xmlns:dc="http://purl.org/dc/elements/1.1/">
        <rdf:Description
                 rdf:about="{$entry.link_rdf}"
                 trackback:ping="{$entry.link_trackback}"
                 dc:title="{$entry.title_rdf|@default:$entry.title}"
                 dc:identifier="{$entry.rdf_ident}" />
        </rdf:RDF>
        -->

    {if $is_single_entry and not $use_popups and not $is_preview}
      {if $CONST.DATA_UNSUBSCRIBED}
        <p class="serendipity_msg_notice">{$CONST.DATA_UNSUBSCRIBED|@sprintf:$CONST.UNSUBSCRIBE_OK}</p>
      {/if}
      {if $CONST.DATA_TRACKBACK_DELETED}
        <p class="serendipity_msg_notice">{$CONST.DATA_TRACKBACK_DELETED|@sprintf:$CONST.TRACKBACK_DELETED}</p>
      {/if}
      {if $CONST.DATA_TRACKBACK_APPROVED}
        <p class="serendipity_msg_notice">{$CONST.DATA_TRACKBACK_APPROVED|@sprintf:$CONST.TRACKBACK_APPROVED}</p>
      {/if}
      {if $CONST.DATA_COMMENT_DELETED}
        <p class="serendipity_msg_notice">{$CONST.DATA_COMMENT_DELETED|@sprintf:$CONST.COMMENT_DELETED}</p>
      {/if}
      {if $CONST.DATA_COMMENT_APPROVED}
        <p class="serendipity_msg_notice">{$CONST.DATA_COMMENT_APPROVED|@sprintf:$CONST.COMMENT_APPROVED}</p>
      {/if}

        <div class="CommWidth">
            <h3 id="trackbacks">{$entry.trackbacks} {$entry.label_trackbacks}</h3>

            <p id="trackback-url"><a rel="nofollow" href="{$entry.link_trackback}" onclick="alert('{$CONST.TRACKBACK_SPECIFIC_ON_CLICK|@escape:html}'); return false;" title="{$CONST.TRACKBACK_SPECIFIC_ON_CLICK|@escape}">{$CONST.TRACKBACK_SPECIFIC}</a></p>

            {serendipity_printTrackbacks entry=$entry.id}
        </div><!-- /.CommWidth -->
    {/if}

    {if $is_single_entry and not $is_preview}
        <div class="CommWidth">
            <h3 id="comments">{$entry.comments} {$entry.label_comments}</h3>                
            {serendipity_printComments entry=$entry.id mode=$entry.viewmode}
        {if $entry.is_entry_owner}
          {if $entry.allow_comments}
            <p>(<a href="{$entry.link_deny_comments}">{$CONST.COMMENTS_DISABLE}</a>)</p>
          {else}
            <p>(<a href="{$entry.link_allow_comments}">{$CONST.COMMENTS_ENABLE}</a>)</p>
          {/if}
        {/if}
            <a id="feedback"></a>
          {foreach from=$comments_messagestack item="message"}
            <p class="serendipity_msg_important">{$message}</p>
          {/foreach}
          {if $is_comment_added}
            <p class="serendipity_msg_notice">{$CONST.COMMENT_ADDED}</p>
          {elseif $is_comment_moderate}
            <p class="serendipity_msg_notice"><strong>{$CONST.COMMENT_ADDED}:</strong>{$CONST.THIS_COMMENT_NEEDS_REVIEW}</p>
          {elseif not $entry.allow_comments}
            <p class="serendipity_msg_important">{$CONST.COMMENTS_CLOSED}</p>
          {else}
            {$COMMENTFORM}
          {/if}
        </div><!-- /.CommWidth -->
    {/if}
    </div><!-- /.post -->
  {$entry.backend_preview}
  {/foreach}
{foreachelse}
  {if not $plugin_clean_page}
    <p>{$CONST.NO_ENTRIES_TO_PRINT}</p>
  {/if}
{/foreach}

    <div class="serendipity_pageFooter">
    {if $footer_prev_page}
        <a class="prev-page" href="{$footer_prev_page}">&laquo; {$CONST.PREVIOUS_PAGE}</a>
    {/if}
    {if $footer_next_page}
        <a class="next-page" href="{$footer_next_page}">{$CONST.NEXT_PAGE} &raquo;</a>
    {/if}
    {serendipity_hookPlugin hook="entries_footer"}
    </div>
