<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:04
         compiled from /home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/index.tpl', 13, false),array('function', 'serendipity_getFile', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/index.tpl', 16, false),array('function', 'serendipity_hookPlugin', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/index.tpl', 27, false),array('function', 'serendipity_printSidebar', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/index.tpl', 73, false),)), $this); ?>
<?php if ($this->_tpl_vars['is_embedded'] != true): ?>
<?php if ($this->_tpl_vars['is_xhtml']): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
           "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php else: ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
           "http://www.w3.org/TR/html4/loose.dtd">
<?php endif; ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_tpl_vars['lang']; ?>
" lang="<?php echo $this->_tpl_vars['lang']; ?>
">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['head_charset']; ?>
" />
    <title><?php echo smarty_modifier_default(@$this->_tpl_vars['head_title'], @$this->_tpl_vars['blogTitle']); ?>
 <?php if ($this->_tpl_vars['head_subtitle']): ?> - <?php echo $this->_tpl_vars['head_subtitle']; ?>
<?php endif; ?></title>
    <meta name="Powered-By" content="Serendipity v.<?php echo $this->_tpl_vars['head_version']; ?>
" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['head_link_stylesheet']; ?>
" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "s9y.css"), $this);?>
" media="screen" />
<?php if ($this->_tpl_vars['template_option']['externalfeed'] != ''): ?>
    <link rel="alternate"  type="application/rss+xml" title="<?php echo $this->_tpl_vars['blogTitle']; ?>
 RSS feed" href="<?php echo $this->_tpl_vars['template_option']['externalfeed']; ?>
" />
<?php else: ?>
    <link rel="alternate"  type="application/rss+xml" title="<?php echo $this->_tpl_vars['blogTitle']; ?>
 RSS feed" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
<?php echo $this->_tpl_vars['serendipityRewritePrefix']; ?>
feeds/index.rss2" />
<?php endif; ?>
    <link rel="alternate"  type="application/x.atom+xml"  title="<?php echo $this->_tpl_vars['blogTitle']; ?>
 Atom feed"  href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
<?php echo $this->_tpl_vars['serendipityRewritePrefix']; ?>
feeds/atom.xml" />
<?php if ($this->_tpl_vars['entry_id']): ?>
    <link rel="pingback" href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
comment.php?type=pingback&amp;entry_id=<?php echo $this->_tpl_vars['entry_id']; ?>
" />
<?php endif; ?>

<?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_header'), $this);?>

</head>

<body>
<?php else: ?>
<?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_header'), $this);?>

<?php endif; ?>

<?php if ($this->_tpl_vars['is_raw_mode'] != true): ?>
<div class="primarynav">
    <ul>    
       <li class="first"><a<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['serendipityBaseURL']): ?> class="current_page_item"<?php endif; ?> href="<?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
">Home</a></li>
    <?php $_from = $this->_tpl_vars['navlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['navbar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['navbar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['navlink']):
        $this->_foreach['navbar']['iteration']++;
?>
       <li<?php if ($this->_tpl_vars['currpage'] == $this->_tpl_vars['navlink']['href']): ?> class="current_page_item"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['navlink']['href']; ?>
"><?php echo $this->_tpl_vars['navlink']['title']; ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
    </ul>

    <a href="<?php if ($this->_tpl_vars['template_option']['externalfeed'] != ''): ?><?php echo $this->_tpl_vars['template_option']['externalfeed']; ?>
<?php else: ?><?php echo $this->_tpl_vars['serendipityBaseURL']; ?>
<?php echo $this->_tpl_vars['serendipityRewritePrefix']; ?>
feeds/index.rss2<?php endif; ?>" class="topnav_rss">RSS</a>
</div><!-- /.primarynav -->

<div class="bgimage">
    <div id="page">
        <div id="content" class="narrowcolumn<?php if ($this->_tpl_vars['staticpage_pagetitle']): ?> innerpage<?php endif; ?>">
        <?php if ($this->_tpl_vars['view'] == '404'): ?>
            <h2 class="center">Error 404 - Not Found</h2>
        <?php else: ?>
            <?php echo $this->_tpl_vars['CONTENT']; ?>

        <?php endif; ?>
        </div><!-- /#content -->

        <div id="sidebar">
	    <h1 class="logo"><a href="http://www.productivedreams.com"><?php echo $this->_tpl_vars['blogTitle']; ?>
</a></h1>

            <div class="searchfield">
                <span>SEARCH</span>
                <form method="get" id="searchform" action="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
<?php echo $this->_tpl_vars['serendipityIndexFile']; ?>
">
                    <div><input type="hidden" name="serendipity[action]" value="search" /></div>
                    <label class="hidden" for="s"><?php echo @QUICKSEARCH; ?>
</label>
                    <div>
                        <input type="text" value="" name="serendipity[searchTerm]" id="s" />
                        <input type="submit" value="<?php echo @QUICKSEARCH; ?>
" name="serendipity[searchButton]" id="searchsubmit" />
                    </div>
                </form>
                <?php echo serendipity_smarty_hookPlugin(array('hook' => 'quicksearch_plugin','hookAll' => 'true'), $this);?>

            </div><!-- /.searchfield -->

            <?php if ($this->_tpl_vars['leftSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'left'), $this);?>
<?php endif; ?>
            <?php if ($this->_tpl_vars['rightSidebarElements'] > 0): ?><?php echo serendipity_smarty_printSidebar(array('side' => 'right'), $this);?>
<?php endif; ?>
        </div><!-- /#sidebar -->

        <div class="sidebar-right"> 
          <?php if ($this->_tpl_vars['template_option']['twitterwidget'] == 'true'): ?>
            <div class="twitter">
                <div class="twitter-content">
                    <ul id="twitter_update_list">
                       <li><?php if ($this->_tpl_vars['template_option']['twitteruser'] == ''): ?>Wrong twitter username<?php endif; ?></li>
                    </ul>
                </div><!-- /.twitter-content -->
            <?php if ($this->_tpl_vars['template_option']['twitteruser'] != ''): ?>
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
                <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $this->_tpl_vars['template_option']['twitteruser']; ?>
.json?callback=twitterCallback2&amp;count=1"></script>

                <a class="followme" href="http://twitter.com/<?php echo $this->_tpl_vars['template_option']['twitteruser']; ?>
">Follow us on twitter</a>
            <?php endif; ?>
            </div><!-- /.twitter -->
          <?php endif; ?>
            <img src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/pdlogo.gif" alt="productivedreams" class="pdlogo"/>
        </div><!-- /.sidebar-right -->

      <?php if ($this->_tpl_vars['template_option']['googleads_use'] == 'true'): ?>
        <div class="google-ads">
        <?php echo $this->_tpl_vars['template_option']['googleads_code']; ?>

        </div><!-- /.google-ads -->
      <?php endif; ?>
    </div><!-- /#page -->
</div><!-- /.bgimage -->

<div id="footer">
    <div class="footerwrap">
        <div class="copyright"><?php echo $this->_tpl_vars['blogTitle']; ?>
 is designed by <a href="http://www.productivedreams.com/">productivedreams</a> for <a href="http://www.smashingmagazine.com">Smashing Magazine</a></div>
        <div class="copyright">Imprezz theme ported to <a href="http://www.s9y.org">Serendipity</a> by <a href="http://yellowled.de">YellowLed</a></div>
    </div><!-- /.footerwrap -->
</div><!-- /#footer -->
<?php endif; ?>

<?php echo $this->_tpl_vars['raw_data']; ?>

<?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_footer'), $this);?>

<?php if ($this->_tpl_vars['is_embedded'] != true): ?>
</body>
</html>
<?php endif; ?>