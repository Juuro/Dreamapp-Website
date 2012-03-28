  {serendipity_hookPlugin hook="entries_header"}

  <h2 class="pagetitle">{$CONST.ARCHIVES}</h2>
{foreach from=$archives item="archive"}
  <h2 class="archive-title">{$archive.year}</h2>

  <ul class="archive-year plainList">
  {foreach from=$archive.months item="month"}
     <li><span class="archive-month">{$month.date|@formatTime:"%B"}: {$month.entry_count} {$CONST.ENTRIES}</span> <span class="archive-links">{if $month.entry_count}<a href="{$month.link}">{/if}{$CONST.VIEW_FULL}{if $month.entry_count}</a>{/if}/{if $month.entry_count}<a href="{$month.link_summary}">{/if}{$CONST.VIEW_TOPICS}{if $month.entry_count}</a>{/if}</span></li>
  {/foreach}
  </ul>
{/foreach}

  <div class="serendipity_pageFooter" style="text-align: center">
  {serendipity_hookPlugin hook="entries_footer"}
  </div>
