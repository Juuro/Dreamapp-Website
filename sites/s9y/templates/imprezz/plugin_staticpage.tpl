<div id="post_{$staticpage_pagetitle|@makeFilename}" class="post">
  {if $staticpage_articleformat}
    <h2 class="page_title">{$staticpage_articleformattitle|@escape}</h2>
  {else}
    <h2 class="page_title">{$staticpage_headline|@escape}</h2>
  {/if}

    <div class="entry">
      {if $staticpage_pass AND $staticpage_form_pass != $staticpage_pass}
        <h3>{$CONST.STATICPAGE_PASSWORD_NOTICE}</h3>

        <form class="staticpage_password_form" action="{$staticpage_form_url}" method="post">
            <div>
                <input type="password" name="serendipity[pass]" value="" />
                <input type="submit" name="submit" value="{$CONST.GO}" />
             </div>
        </form>
      {else}
        <div class="staticpage_precontent">{$staticpage_precontent}</div>
        <div class="staticpage_content">{$staticpage_content}</div>
        {if is_array($staticpage_childpages)}
        <ul id="staticpage_childpages" class="plainList">
          {foreach from=$staticpage_childpages item="childpage"}
           <li><a href="{$childpage.permalink|@escape}">{$childpage.pagetitle|@escape}</a></li>
          {/foreach}
        </ul>
        {/if}
      {/if}
    </div>
</div>