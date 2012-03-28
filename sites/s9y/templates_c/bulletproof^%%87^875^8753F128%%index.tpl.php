<?php /* Smarty version 2.6.26, created on 2010-10-28 14:45:07
         compiled from /home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/index.tpl', 10, false),array('modifier', 'truncate', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/index.tpl', 109, false),array('function', 'serendipity_hookPlugin', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/index.tpl', 11, false),array('function', 'serendipity_getFile', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/index.tpl', 20, false),array('function', 'serendipity_printSidebar', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/index.tpl', 153, false),)), $this); ?>
<?php if ($this->_tpl_vars['is_embedded'] != true): ?>
    <?php if ($this->_tpl_vars['is_xhtml']): ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <?php else: ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <?php endif; ?>

    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_tpl_vars['lang']; ?>
" lang="<?php echo $this->_tpl_vars['lang']; ?>
">
    <head>
        <title><?php echo smarty_modifier_default(@$this->_tpl_vars['head_title'], @$this->_tpl_vars['blogTitle']); ?>
<?php if ($this->_tpl_vars['head_subtitle']): ?> - <?php echo $this->_tpl_vars['head_subtitle']; ?>
<?php endif; ?></title>
        <?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_header'), $this);?>

        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['head_charset']; ?>
" />
        <meta name="Powered-By" content="Serendipity v.<?php echo $this->_tpl_vars['head_version']; ?>
" />
        <link rel="alternate"  type="application/rss+xml" title="<?php echo $this->_tpl_vars['blogTitle']; ?>
 RSS feed" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
<?php echo $this->_tpl_vars['serendipityRewritePrefix']; ?>
feeds/index.rss2" />
        <link rel="alternate"  type="application/x.atom+xml"  title="<?php echo $this->_tpl_vars['blogTitle']; ?>
 Atom feed"  href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
<?php echo $this->_tpl_vars['serendipityRewritePrefix']; ?>
feeds/atom.xml" />
        <?php if ($this->_tpl_vars['entry_id']): ?><link rel="pingback" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
comment.php?type=pingback&amp;entry_id=<?php echo $this->_tpl_vars['entry_id']; ?>
" /><?php endif; ?>
        <!-- uncomment the line below if your site uses a favicon -->
        <!--   <link rel="shortcut icon" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
favicon.ico" /> -->
        <!-- base styles needed for bulletproof -->
        <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "base.css"), $this);?>
" />
        <!-- style.css -->
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['head_link_stylesheet']; ?>
" />
        <!--[if IE 5]>
            <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "ie5.css"), $this);?>
" />
        <![endif]-->
        <!--[if IE 6]>
            <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "ie6.css"), $this);?>
" />
        <![endif]-->
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "ie7.css"), $this);?>
" />
        <![endif]-->
        <!-- additional colorset stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_style.css" />
        <?php if ($this->_tpl_vars['template_option']['custheader'] == 'true'): ?>
        <style type="text/css">
            #serendipity_banner {
            background-image: url(<?php echo smarty_modifier_default(@$this->_tpl_vars['random_headerimage'], @$this->_tpl_vars['template_option']['headerimage']); ?>
);
            background-position: <?php echo $this->_tpl_vars['template_option']['headerposhor']; ?>
 <?php echo $this->_tpl_vars['template_option']['headerposver']; ?>
;
            <?php if ($this->_tpl_vars['template_option']['headertype'] == 'banner'): ?>
                background-repeat: no-repeat;
            <?php elseif ($this->_tpl_vars['template_option']['headertype'] == 'htiled'): ?>
                background-repeat: repeat-x;
            <?php elseif ($this->_tpl_vars['template_option']['headertype'] == 'vtiled'): ?>
                background-repeat: repeat-y;
            <?php elseif ($this->_tpl_vars['template_option']['headertype'] == 'btiled'): ?>
                background-repeat: repeat;
            <?php endif; ?>}
        </style>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['template_option']['jscolumns'] == 'true'): ?><script type="text/javascript" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/js/p7_eqCols2_10.js"></script><?php endif; ?>
        <!-- print media stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "print.css"), $this);?>
" media="print" />
        <!-- additional user stylesheet: this can be used to override selected styles -->
        <?php if ($this->_tpl_vars['template_option']['userstylesheet'] == 'true'): ?><link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "user.css"), $this);?>
" media="screen" /><?php endif; ?>
    </head>

    <body<?php if ($this->_tpl_vars['template_option']['jscolumns'] == 'true'): ?> onload="P7_equalCols2(0,<?php if ($this->_tpl_vars['template_option']['layouttype'] != '1col'): ?>'content','DIV',<?php endif; ?>'serendipityLeftSideBar','DIV','serendipityRightSideBar','DIV')"<?php endif; ?>>
<?php else: ?>
    <?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_header'), $this);?>

<?php endif; ?>

<?php if ($this->_tpl_vars['is_raw_mode'] != true): ?>

    <!-- #skiplinks: these are links used to navigate quickly in text-based browsers -->
    <!--             they are of little use in modern graphical browsers, so the are -->
    <!--             hidden using CSS                                                -->
    <div id="skiplinks">
        <ul>
            <?php if ($this->_tpl_vars['template_option']['sitenavpos'] != 'none'): ?><li lang="en"><a href="<?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left'): ?>#sbsitenav<?php elseif ($this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>#sbsitenav<?php else: ?>#sitenav<?php endif; ?>">Skip to site navigation</a></li><?php endif; ?>
            <li lang="en"><a href="#content">Skip to blog entries</a></li>
            <li lang="en"><a href="<?php echo $this->_tpl_vars['serendipityArchiveURL']; ?>
">Skip to archive page</a></li>
            <?php if ($this->_tpl_vars['template_option']['layouttype'] != '2bs'): ?><li lang="en"><a href="#serendipityLeftSideBar">Skip to left sidebar</a></li><?php endif; ?>
            <?php if ($this->_tpl_vars['template_option']['layouttype'] != '2sb'): ?><li lang="en"><a href="#serendipityRightSideBar">Skip to right sidebar</a></li><?php endif; ?>
        </ul>
    </div>

    <!-- #wrapper: this wrapper div holds the actual blog content; it can be used to -->
    <!--           give the blog a width in px or % plus an additional max-width in  -->
    <!--           order to limit the width in high resolutions to limit the length  -->
    <!--           of a line                                                         -->
    <div id="wrapper">
        <div id="wrapper_top"></div>

        <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'above'): ?>
            <!-- #sitenav: this holds a list of navigational links which can be customized   -->
            <!--           in the theme configurator                                         -->
            <div id="sitenav" class="snabove">
                <ul>
                    <?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['navbar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['navbar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['navbar']['iteration']++;
?>
                        <li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['navbar']['iteration'] <= 1)): ?> navlink_first<?php endif; ?><?php if (($this->_foreach['navbar']['iteration'] == $this->_foreach['navbar']['total'])): ?> navlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
                <!-- quicksearch option in the navigational link menu bar only when navbar is    -->
                <!-- above or below the banner                                                   -->
                <?php if ($this->_tpl_vars['template_option']['sitenav_quicksearch'] == 'true'): ?>
                    <form id="searchform" action="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
<?php echo $this->_tpl_vars['serendipityIndexFile']; ?>
" method="get">
                        <input type="hidden" name="serendipity[action]" value="search" />
                        <input alt="<?php echo @QUICKSEARCH; ?>
" type="text" id="serendipityQuickSearchTermField" name="serendipity[searchTerm]" value="<?php echo @QUICKSEARCH; ?>
..." onfocus="if(this.value=='<?php echo @QUICKSEARCH; ?>
...')value=''" onblur="if(this.value=='')value='<?php echo @QUICKSEARCH; ?>
...';" />
                        <div id="LSResult" style="display: none;"><div id="LSShadow"></div></div>
                    </form>
                    <?php echo serendipity_smarty_hookPlugin(array('hook' => 'quicksearch_plugin','hookAll' => 'true'), $this);?>

                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- #serendipity_banner: this is the header area. it holds the blog title and   -->
        <!--                      description headlines                                  -->
        <div id="serendipity_banner">
            <h1><span class="<?php if ($this->_tpl_vars['template_option']['firbtitle'] == 'false'): ?>in<?php endif; ?>visible"><a class="homelink1" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
"><?php echo ((is_array($_tmp=smarty_modifier_default(@$this->_tpl_vars['head_title'], @$this->_tpl_vars['blogTitle']))) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, " ...") : smarty_modifier_truncate($_tmp, 80, " ...")); ?>
</a></span></h1>
            <h2><span class="<?php if ($this->_tpl_vars['template_option']['firbdescr'] == 'false'): ?>in<?php endif; ?>visible"><a class="homelink2" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
"><?php echo smarty_modifier_default(@$this->_tpl_vars['head_subtitle'], @$this->_tpl_vars['blogDescription']); ?>
</a></span></h2>
        </div>
        <div id="serendipity_below_banner"></div>

        <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'below'): ?>
            <!-- #sitenav: this holds a list of navigational links which can be customized   -->
            <!--           in the theme configurator                                         -->
            <div id="sitenav" class="snbelow">
                <ul>
                    <?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['navbar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['navbar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['navbar']['iteration']++;
?>
                        <li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['navbar']['iteration'] <= 1)): ?> navlink_first<?php endif; ?><?php if (($this->_foreach['navbar']['iteration'] == $this->_foreach['navbar']['total'])): ?> navlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
                <!-- quicksearch option in the navigational link menu bar only when navbar is    -->
                <!-- above or below the banner                                                   -->
                <?php if ($this->_tpl_vars['template_option']['sitenav_quicksearch'] == 'true'): ?>
                    <form id="searchform" action="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
<?php echo $this->_tpl_vars['serendipityIndexFile']; ?>
" method="get">
                        <input type="hidden" name="serendipity[action]" value="search" />
                        <input alt="<?php echo @QUICKSEARCH; ?>
" type="text" id="serendipityQuickSearchTermField" name="serendipity[searchTerm]" value="<?php echo @QUICKSEARCH; ?>
..." onfocus="if(this.value=='<?php echo @QUICKSEARCH; ?>
...')value=''" onblur="if(this.value=='')value='<?php echo @QUICKSEARCH; ?>
...';" />
                        <div id="LSResult" style="display: none;"><div id="LSShadow"></div></div>
                    </form>
                    <?php echo serendipity_smarty_hookPlugin(array('hook' => 'quicksearch_plugin','hookAll' => 'true'), $this);?>

                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- this is the actual content of the blog, entries column plus one or two      -->
        <!-- sidebars, depending on how users configure their sidebar plugins            -->

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '3sbs'): ?>
            <!-- case 1: 3 columns, sidebar-content-sidebar -->
            <div id="serendipityLeftSideBar" class="threeside layout3sbs_left">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            </div>
            <div id="content" class="threemain layout3sbs_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
            <div id="serendipityRightSideBar" class="threeside layout3sbs_right">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>    
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '3bss'): ?>
            <!-- case 2: 3 columns, content-sidebar-sidebar -->
            <div id="content" class="threemain layout3bss_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
            <div id="serendipityLeftSideBar" class="threeside layout3bss_left">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>    
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            </div>
            <div id="serendipityRightSideBar" class="threeside layout3bss_right">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '3ssb'): ?>
            <!-- case 3: 3 columns, sidebar-sidebar-content -->
            <div id="serendipityLeftSideBar" class="threeside layout3ssb_left">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            </div>
            <div id="serendipityRightSideBar" class="threeside layout3ssb_right">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
            <div id="content" class="threemain layout3ssb_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '2sb'): ?>
            <!-- case 4: 2 columns, left sidebar only -->
            <div id="serendipityLeftSideBar" class="twoside layout2sb_left">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left' || $this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
                <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
            <div id="content" class="twomain layout2sb_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '2bs'): ?>
            <!-- case 5: 2 columns, right sidebar only -->
            <div id="content" class="twomain layout2bs_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
            <div id="serendipityRightSideBar" class="twoside layout2bs_right">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left' || $this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
                <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '1col'): ?>
            <!-- case 6: 1 column, sidebar(s) below -->
            <div id="content" class="onemain layout1col_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>

            <div id="serendipityRightSideBar" class="onefull layout1col_right_full">
            <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left' || $this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
            <!-- #sbsitenav: like #sitenav, but placed within the sidebar -->
                <div id="sbsitenav" class="serendipitySideBarItem">
                    <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                    <div class="serendipitySideBarContent">
            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                        <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                    </div>
                    <div class="serendipitySideBarFooter"></div>
                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '2sbf'): ?>
            <!-- case 7: 2 columns, left sidebar plus sidebar below -->
            <div id="serendipityLeftSideBar" class="twoside layout2sb_left">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            </div>
            <div id="content" class="twomain layout2sb_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
            <div id="serendipityRightSideBar" class="onefull layout1col_right_full">
            <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
            <!-- #sbsitenav: like #sitenav, but placed within the sidebar -->
                <div id="sbsitenav" class="serendipitySideBarItem">
                    <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                    <div class="serendipitySideBarContent">
            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                        <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                    </div>
                    <div class="serendipitySideBarFooter"></div>
                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['template_option']['layouttype'] == '2bsf'): ?>
            <!-- case 8: 2 columns, right sidebar plus sidebar below -->
            <div id="content" class="twomain layout2bs_content hfeed">
                <?php echo $this->_tpl_vars['CONTENT']; ?>

            </div>
            <div id="serendipityRightSideBar" class="twoside layout2bs_right">
                <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'right'): ?>
                    <!-- #sbsitenav: like #sitenav, but placed within the sidebar                    -->
                    <div id="sbsitenav" class="serendipitySideBarItem">
                        <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                        <div class="serendipitySideBarContent">
                            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                            <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                        </div>
                        <div class="serendipitySideBarFooter"></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
            </div>
            <div id="serendipityLeftSideBar" class="onefull layout1col_right_full">
            <?php if ($this->_tpl_vars['template_option']['sitenavpos'] == 'left'): ?>
            <!-- #sbsitenav: like #sitenav, but placed within the sidebar -->
                <div id="sbsitenav" class="serendipitySideBarItem">
                    <h3 class="serendipitySideBarTitle"><?php echo $this->_tpl_vars['template_option']['sitenav_sidebar_title']; ?>
</h3>
                    <div class="serendipitySideBarContent">
            <!-- the line below must remain as a single uninterrupted line to display correctly in ie6 -->
                        <ul><?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sbnav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sbnav']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['sbnav']['iteration']++;
?><li class="<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?>currentpage<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] <= 1)): ?> sbnavlink_first<?php endif; ?><?php if (($this->_foreach['sbnav']['iteration'] == $this->_foreach['sbnav']['total'])): ?> sbnavlink_last<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li><?php endforeach; endif; unset($_from); ?></ul>
                    </div>
                    <div class="serendipitySideBarFooter"></div>
                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- #footer: the page footer can be used for additional information             -->
        <div id="footer">
            <?php if ($this->_tpl_vars['template_option']['footer_text_toggle'] == 'true'): ?>
                <p><?php echo $this->_tpl_vars['template_option']['footer_text']; ?>
</p>
            <?php endif; ?>

            <!-- ************************************************************** -->
            <!-- The image and link below must remain if you use this template  -->
            <!-- or create your own template based on the bulletproof framework -->
            <!-- ************************************************************** -->

            <div id="serendipity_bulletproof_button"><a href="http://s9y-bulletproof.com" title="Based on the s9y Bulletproof template framework"><img src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/bulletproof_button.png" alt="Based on the s9y Bulletproof template framework" width="100" height="28" /></a></div>

            <!-- ************************************************************** -->
            <!-- Feel free to insert your own "Template by" name and link below -->
            <!-- if you create a custom template based on bulletproof.          -->
            <!-- ************************************************************** -->

            <div id="serendipity_credit_line"><?php echo @POWERED_BY; ?>
 <a href="http://www.s9y.org">s9y</a> &ndash; Template by <a href="http://s9y-bulletproof.com">Bulletproof development team</a>.<br /><?php echo $this->_tpl_vars['template_option']['colorset_data']['attribution']; ?>
</div>
            
            <?php if ($this->_tpl_vars['template_option']['counter_code_toggle'] == 'true'): ?>
                <div class="counter_code"><?php echo $this->_tpl_vars['template_option']['counter_code']; ?>
</div>
            <?php endif; ?>
            <!-- option to display navigation links in the footer                            -->
            <?php if (( $this->_tpl_vars['template_option']['sitenavpos'] != 'none' && $this->_tpl_vars['template_option']['sitenav_footer'] == 'true' )): ?>
                <div id="footer_sitenav">
                    <ul>
                        <?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['navbar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['navbar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['navbar']['iteration']++;
?>
                            <li<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href'] || $this->_tpl_vars['currpage2'] == $this->_tpl_vars['navlink']['href']): ?> class="currentpage"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
" title="<?php echo $this->_tpl_vars['navlink']['title']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div id="wrapper_footer"></div>
    </div>
<?php endif; ?>

<?php echo $this->_tpl_vars['raw_data']; ?>


<?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_footer'), $this);?>

<?php if ($this->_tpl_vars['is_embedded'] != true): ?>
    </body>
    </html>
<?php endif; ?>