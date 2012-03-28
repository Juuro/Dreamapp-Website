{if $staticpage_articleformat}
<div class="serendipity_Entry_Date">
    <h3 class="serendipity_date">{$staticpage_articleformattitle|@escape}</h3>
{/if}

    <h4 class="serendipity_title"><a href="#">{$staticpage_headline|@escape}</a></h4>

{if $staticpage_navigation AND $staticpage_shownavi}
    <ul class="staticpage_navigation">
      <li class="staticpage_navigation_left"><a href="{$staticpage_navigation.prev.link}" title="prev">{$staticpage_navigation.prev.name|@escape}</a></li>
      <li class="staticpage_navigation_center"><a href="{$staticpage_navigation.top.link}" title="top">{$staticpage_navigation.top.name|@escape}</a></li>
      <li class="staticpage_navigation_right"><a href="{$staticpage_navigation.next.link}" title="next">{$staticpage_navigation.next.name|@escape}</a></li>
    </ul>
{/if}

{if $staticpage_articleformat}
    <div class="serendipity_entry">
        <div class="serendipity_entry_body">
{/if}

{if $staticpage_pass AND $staticpage_form_pass != $staticpage_pass}
        <div class="staticpage_password">{$CONST.STATICPAGE_PASSWORD_NOTICE}</div>
        <form action="{$staticpage_form_url}" method="post">
            <div>
                <input type="password" name="serendipity[pass]" value="" />
                <input type="submit" name="submit" value="{$CONST.GO}" />
             </div>
        </form>
{else}
<dl class="staticpage_list_of_childpages">
{foreach from=$staticpage_extchildpages item="child"}
  <dt>{if $child.image}<img src="{$child.image}" alt="" />{/if}<a href="{$child.permalink}">{$child.pagetitle}</a></dt>
  <dd>{$child.precontent|truncate:200:"...":true}</dd>
{/foreach}
</dl>
{/if}

{if $staticpage_articleformat}
        </div>
    </div>
</div>
{/if}

{if $staticpage_articleformat}
<div class="serendipity_Entry_Date serendipity_staticpage">
{/if}

{if $staticpage_author}
    <div class="staticpage_author">{$staticpage_author|@escape}</div>
{/if}

    <div class="staticpage_metainfo">
{if $staticpage_lastchange}
    <span class="staticpage_metainfo_lastchange">{$staticpage_lastchange|date_format:"%Y-%m-%d"}</span>
{/if}

{if $staticpage_adminlink AND $staticpage_adminlink.page_user}
    | <a class="staticpage_metainfo_editlink" href="{$staticpage_adminlink.link_edit}">{$staticpage_adminlink.link_name|@escape}</a>
{/if}
    </div>
{if $staticpage_articleformat}
</div>
{/if}
