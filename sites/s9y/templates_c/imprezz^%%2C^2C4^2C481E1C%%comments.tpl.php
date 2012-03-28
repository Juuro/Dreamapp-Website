<?php /* Smarty version 2.6.26, created on 2010-10-28 15:05:06
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/comments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/comments.tpl', 4, false),array('modifier', 'escape', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/comments.tpl', 8, false),array('modifier', 'default', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/comments.tpl', 8, false),array('modifier', 'formatTime', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/comments.tpl', 9, false),)), $this); ?>
<ol class="commentlist">
<?php $_from = $this->_tpl_vars['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['comments'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['comments']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['comment']):
        $this->_foreach['comments']['iteration']++;
?>
   <li class="authorli">
       <div id="comment-<?php echo $this->_tpl_vars['comment']['id']; ?>
" class="authordiv <?php echo smarty_function_cycle(array('values' => "even,alt"), $this);?>
">
         <?php if ($this->_tpl_vars['comment']['avatar']): ?>
           <?php echo $this->_tpl_vars['comment']['avatar']; ?>

         <?php endif; ?>
           <cite><?php if ($this->_tpl_vars['comment']['url']): ?><a href="<?php echo $this->_tpl_vars['comment']['url']; ?>
" title="<?php echo smarty_modifier_escape($this->_tpl_vars['comment']['url']); ?>
"><?php endif; ?><?php echo smarty_modifier_default(@$this->_tpl_vars['comment']['author'], @ANONYMOUS); ?>
<?php if ($this->_tpl_vars['comment']['url']): ?></a><?php endif; ?> says:</cite>
           <small class="commentmetadata"><a href="#comment-<?php echo $this->_tpl_vars['comment']['id']; ?>
"><?php echo serendipity_smarty_formatTime($this->_tpl_vars['comment']['timestamp'], @DATE_FORMAT_ENTRY); ?>
 <?php echo @AT; ?>
 <?php echo serendipity_smarty_formatTime($this->_tpl_vars['comment']['timestamp'], '%H:%M'); ?>
</a></small>
       </div>
   </li>
   <li>
     <?php if ($this->_tpl_vars['comment']['body'] == 'COMMENT_DELETED'): ?>
       <p><?php echo @COMMENT_IS_DELETED; ?>
</p>
     <?php else: ?>
       <?php echo $this->_tpl_vars['comment']['body']; ?>

     <?php endif; ?>
   </li>
<?php endforeach; else: ?>
    <li class="nocomments"><p><?php echo @NO_COMMENTS; ?>
</p></li>
<?php endif; unset($_from); ?>
</ol>