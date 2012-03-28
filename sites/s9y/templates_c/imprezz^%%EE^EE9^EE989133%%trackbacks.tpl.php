<?php /* Smarty version 2.6.26, created on 2010-10-28 15:05:06
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl', 4, false),array('modifier', 'strip_tags', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl', 5, false),array('modifier', 'xhtml_target', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl', 5, false),array('modifier', 'default', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl', 5, false),array('modifier', 'formatTime', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl', 6, false),array('modifier', 'escape', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/trackbacks.tpl', 10, false),)), $this); ?>
<ol class="commentlist">
<?php $_from = $this->_tpl_vars['trackbacks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['trackback']):
?>
   <li class="authorli">
       <div id="comment-<?php echo $this->_tpl_vars['trackback']['id']; ?>
" class="authordiv <?php echo smarty_function_cycle(array('values' => "even,alt"), $this);?>
">
           <cite><a href="<?php echo smarty_modifier_strip_tags($this->_tpl_vars['trackback']['url']); ?>
" <?php echo serendipity_xhtml_target('blank'); ?>
><?php echo smarty_modifier_default(@$this->_tpl_vars['trackback']['author'], @ANONYMOUS); ?>
</a> says:</cite>
           <small class="commentmetadata"><a href="#comment-<?php echo $this->_tpl_vars['trackback']['id']; ?>
"><?php echo serendipity_smarty_formatTime($this->_tpl_vars['trackback']['timestamp'], @DATE_FORMAT_ENTRY); ?>
 <?php echo @AT; ?>
 <?php echo serendipity_smarty_formatTime($this->_tpl_vars['trackback']['timestamp'], '%H:%M'); ?>
</a></small>
       </div>
   </li>
   <li><h4><?php echo $this->_tpl_vars['trackback']['title']; ?>
</h4>
       <?php echo smarty_modifier_escape(smarty_modifier_strip_tags($this->_tpl_vars['trackback']['body']), 'all'); ?>

   </li>
<?php endforeach; else: ?>
    <li class="nocomments"><p><?php echo @NO_TRACKBACKS; ?>
</p></li>
<?php endif; unset($_from); ?>
</ol>