{if $is_embedded != true}
{if $is_xhtml}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{else}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
           "http://www.w3.org/TR/html4/loose.dtd">
{/if}

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang}" lang="{$lang}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={$head_charset}" />
    <title>{$head_title|@default:$blogTitle} {if $head_subtitle} - {$head_subtitle}{/if}</title>
    <meta name="Powered-By" content="Serendipity v.{$head_version}" />
    <link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{serendipity_getFile file="s9y.css"}" media="screen" />
{if $template_option.externalfeed != ''}
    <link rel="alternate"  type="application/rss+xml" title="{$blogTitle} RSS feed" href="{$template_option.externalfeed}" />
{else}
    <link rel="alternate"  type="application/rss+xml" title="{$blogTitle} RSS feed" href="{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/index.rss2" />
{/if}
    <link rel="alternate"  type="application/x.atom+xml"  title="{$blogTitle} Atom feed"  href="{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/atom.xml" />
{if $entry_id}
    <link rel="pingback" href="{$serendipityBaseURL}comment.php?type=pingback&amp;entry_id={$entry_id}" />
{/if}

{serendipity_hookPlugin hook="frontend_header"}
</head>

<body>
{else}
{serendipity_hookPlugin hook="frontend_header"}
{/if}

{if $is_raw_mode != true}
<div class="primarynav">
    <ul>    
       <li class="first"><a{if $currpage == $serendipityBaseURL} class="current_page_item"{/if} href="{$serendipityBaseURL}">Home</a></li>
    {foreach from=$navlinks item="navlink" name=navbar}
       <li{if $currpage == $navlink.href} class="current_page_item"{/if}><a href="{$navlink.href}">{$navlink.title}</a></li>
    {/foreach}
    </ul>

    <a href="{if $template_option.externalfeed != ''}{$template_option.externalfeed}{else}{$serendipityBaseURL}{$serendipityRewritePrefix}feeds/index.rss2{/if}" class="topnav_rss">RSS</a>
</div><!-- /.primarynav -->

<div class="bgimage">
    <div id="page">
        <div id="content" class="narrowcolumn{if $staticpage_pagetitle} innerpage{/if}">
        {if $view == '404'}
            <h2 class="center">Error 404 - Not Found</h2>
        {else}
            {$CONTENT}
        {/if}
        </div><!-- /#content -->

        <div id="sidebar">
	    <h1 class="logo"><a href="http://www.productivedreams.com">{$blogTitle}</a></h1>

            <div class="searchfield">
                <span>SEARCH</span>
                <form method="get" id="searchform" action="{$serendipityHTTPPath}{$serendipityIndexFile}">
                    <div><input type="hidden" name="serendipity[action]" value="search" /></div>
                    <label class="hidden" for="s">{$CONST.QUICKSEARCH}</label>
                    <div>
                        <input type="text" value="" name="serendipity[searchTerm]" id="s" />
                        <input type="submit" value="{$CONST.QUICKSEARCH}" name="serendipity[searchButton]" id="searchsubmit" />
                    </div>
                </form>
                {serendipity_hookPlugin hook="quicksearch_plugin" hookAll="true"}
            </div><!-- /.searchfield -->

            {if $leftSidebarElements > 0}{serendipity_printSidebar side="left"}{/if}
            {if $rightSidebarElements > 0}{serendipity_printSidebar side="right"}{/if}
        </div><!-- /#sidebar -->

        <div class="sidebar-right"> 
          {if $template_option.twitterwidget == 'true'}
            <div class="twitter">
                <div class="twitter-content">
                    <ul id="twitter_update_list">
                       <li>{if $template_option.twitteruser == ''}Wrong twitter username{/if}</li>
                    </ul>
                </div><!-- /.twitter-content -->
            {if $template_option.twitteruser != ''}
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
                <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/{$template_option.twitteruser}.json?callback=twitterCallback2&amp;count=1"></script>

                <a class="followme" href="http://twitter.com/{$template_option.twitteruser}">Follow us on twitter</a>
            {/if}
            </div><!-- /.twitter -->
          {/if}
            <img src="{$serendipityHTTPPath}templates/{$template}/img/pdlogo.gif" alt="productivedreams" class="pdlogo"/>
        </div><!-- /.sidebar-right -->

      {if $template_option.googleads_use == 'true'}
        <div class="google-ads">
        {$template_option.googleads_code}
        </div><!-- /.google-ads -->
      {/if}
    </div><!-- /#page -->
</div><!-- /.bgimage -->

<div id="footer">
    <div class="footerwrap">
        <div class="copyright">{$blogTitle} is designed by <a href="http://www.productivedreams.com/">productivedreams</a> for <a href="http://www.smashingmagazine.com">Smashing Magazine</a></div>
        <div class="copyright">Imprezz theme ported to <a href="http://www.s9y.org">Serendipity</a> by <a href="http://yellowled.de">YellowLed</a></div>
    </div><!-- /.footerwrap -->
</div><!-- /#footer -->
{/if}

{$raw_data}
{serendipity_hookPlugin hook="frontend_footer"}
{if $is_embedded != true}
</body>
</html>
{/if}
