<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:04
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/sidebar.tpl */ ?>
<ul>
<?php $_from = $this->_tpl_vars['plugindata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <?php if ($this->_tpl_vars['item']['class'] == 'serendipity_quicksearch_plugin'): ?>
  <?php elseif ($this->_tpl_vars['item']['class'] == 'serendipity_plugin_twitter' && $this->_tpl_vars['template_option']['twitterwidget'] == 'true'): ?>
  <?php else: ?>
   <li class="container_<?php echo $this->_tpl_vars['item']['class']; ?>
">
     <?php if ($this->_tpl_vars['item']['title'] != ""): ?>
       <h2><?php echo $this->_tpl_vars['item']['title']; ?>
</h2>
     <?php endif; ?>
       <div class="sidebar-plugin"><?php echo $this->_tpl_vars['item']['content']; ?>
</div>
   </li>
  <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</ul>