<ol class="commentlist">
{foreach from=$comments item=comment name="comments"}
   <li class="authorli">
       <div id="comment-{$comment.id}" class="authordiv {cycle values="even,alt"}">
         {if $comment.avatar}
           {$comment.avatar}
         {/if}
           <cite>{if $comment.url}<a href="{$comment.url}" title="{$comment.url|@escape}">{/if}{$comment.author|@default:$CONST.ANONYMOUS}{if $comment.url}</a>{/if} says:</cite>
           <small class="commentmetadata"><a href="#comment-{$comment.id}">{$comment.timestamp|@formatTime:$CONST.DATE_FORMAT_ENTRY} {$CONST.AT} {$comment.timestamp|@formatTime:'%H:%M'}</a></small>
       </div>
   </li>
   <li>
     {if $comment.body == 'COMMENT_DELETED'}
       <p>{$CONST.COMMENT_IS_DELETED}</p>
     {else}
       {$comment.body}
     {/if}
   </li>
{foreachelse}
    <li class="nocomments"><p>{$CONST.NO_COMMENTS}</p></li>
{/foreach}
</ol>
