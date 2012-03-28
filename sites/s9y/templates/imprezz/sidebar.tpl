<ul>
{foreach from=$plugindata item=item}
  {if $item.class == "serendipity_quicksearch_plugin"}
  {elseif $item.class == "serendipity_plugin_twitter" and $template_option.twitterwidget == 'true'}
  {else}
   <li class="container_{$item.class}">
     {if $item.title != ""}
       <h2>{$item.title}</h2>
     {/if}
       <div class="sidebar-plugin">{$item.content}</div>
   </li>
  {/if}
{/foreach}
</ul>
