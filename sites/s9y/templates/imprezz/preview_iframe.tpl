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
    <title>{$CONST.SERENDIPITY_ADMIN_SUITE}</title>
    <meta name="Powered-By" content="Serendipity v.{$head_version}" />
    <link rel="stylesheet" type="text/css" href="{$head_link_stylesheet}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{serendipity_getFile file="s9y.css"}" media="screen" />
    <script type="text/javascript">
       window.onload = function() {ldelim}
          parent.document.getElementById('serendipity_iframe').style.height = document.getElementById('content').offsetHeight + 'px';
          parent.document.getElementById('serendipity_iframe').scrolling    = 'no';
          parent.document.getElementById('serendipity_iframe').style.border = 0;
       {rdelim}
    </script>
</head>

<body>
    <div class="bgimage">
        <div id="page">
            <div id="content" class="narrowcolumn">
            {$preview}
            </div>
        </div>
    </div>
</body>
</html>
