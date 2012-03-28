<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:56
         compiled from /home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/preview_iframe.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_getFile', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/preview_iframe.tpl', 15, false),)), $this); ?>
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
    <title><?php echo @SERENDIPITY_ADMIN_SUITE; ?>
</title>
    <meta name="Powered-By" content="Serendipity v.<?php echo $this->_tpl_vars['head_version']; ?>
" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['head_link_stylesheet']; ?>
" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo serendipity_smarty_getFile(array('file' => "s9y.css"), $this);?>
" media="screen" />
    <script type="text/javascript">
       window.onload = function() {
          parent.document.getElementById('serendipity_iframe').style.height = document.getElementById('content').offsetHeight + 'px';
          parent.document.getElementById('serendipity_iframe').scrolling    = 'no';
          parent.document.getElementById('serendipity_iframe').style.border = 0;
       }
    </script>
</head>

<body>
    <div class="bgimage">
        <div id="page">
            <div id="content" class="narrowcolumn">
            <?php echo $this->_tpl_vars['preview']; ?>

            </div>
        </div>
    </div>
</body>
</html>