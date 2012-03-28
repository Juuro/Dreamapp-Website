{if $staticpage_results}
<h2 class="pagetitle">{$CONST.STATICPAGE_SEARCHRESULTS|sprintf:$staticpage_searchresults}</h2>

<ul class="staticpage_result">
{foreach from=$staticpage_results item="result"}
   <li><h3><a href="{$result.permalink|@escape}" title="{$result.pagetitle|@escape}">{$result.headline}</a></h3>
       {$result.content|@strip_tags|@strip|@truncate:200:" ... "}</li>
{/foreach}
</ul>
{/if}
