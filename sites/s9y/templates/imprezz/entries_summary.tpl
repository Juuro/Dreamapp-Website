  {serendipity_hookPlugin hook="entries_header"}

  <h2 class="pagetitle">{$CONST.TOPICS_OF} {$dateRange.0|@formatTime:"%B, %Y"}</h2>

  <ul class="archive-year plainList">
{foreach from=$entries item="entries"}
  {foreach from=$entries.entries item="entry"}
     <li><h3><a href="{$entry.link}">{$entry.title}</a></h3>
         <p><span class="archive-month">{$entry.author}</span> <span class="archive-links">{$entry.timestamp|@formatTime:DATE_FORMAT_ENTRY}</span></p>
     </li>
  {/foreach}
{/foreach}
  </ul>

<div class="serendipity_pageFooter" style="text-align: center">
{serendipity_hookPlugin hook="entries_footer"}
</div>
