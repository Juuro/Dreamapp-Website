<ol class="commentlist">
{foreach from=$trackbacks item=trackback}
   <li class="authorli">
       <div id="comment-{$trackback.id}" class="authordiv {cycle values="even,alt"}">
           <cite><a href="{$trackback.url|@strip_tags}" {'blank'|@xhtml_target}>{$trackback.author|@default:$CONST.ANONYMOUS}</a> says:</cite>
           <small class="commentmetadata"><a href="#comment-{$trackback.id}">{$trackback.timestamp|@formatTime:$CONST.DATE_FORMAT_ENTRY} {$CONST.AT} {$trackback.timestamp|@formatTime:'%H:%M'}</a></small>
       </div>
   </li>
   <li><h4>{$trackback.title}</h4>
       {$trackback.body|@strip_tags|@escape:all}
   </li>
{foreachelse}
    <li class="nocomments"><p>{$CONST.NO_TRACKBACKS}</p></li>
{/foreach}
</ol>
