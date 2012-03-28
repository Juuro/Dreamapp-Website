<?php /* Smarty version 2.6.26, created on 2010-10-28 14:45:08
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/sidebar.tpl */ ?>
<?php if ($this->_tpl_vars['is_raw_mode']): ?>
<div id="serendipity<?php echo $this->_tpl_vars['pluginside']; ?>
SideBar">
<?php endif; ?>
<?php $_from = $this->_tpl_vars['plugindata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
   <?php if ($this->_tpl_vars['item']['class'] == 'serendipity_quicksearch_plugin' && $this->_tpl_vars['template_option']['sitenav_quicksearch'] == 'true' && ( $this->_tpl_vars['template_option']['sitenavpos'] == 'above' || $this->_tpl_vars['template_option']['sitenavpos'] == 'below' )): ?>
<!-- do nothing thereby supressing quicksearch in the sidebar when enabled in  -->
<!-- navigation menu bar and ONLY when navigation bar is above or below header -->
   <?php else: ?>
      <div class="serendipitySideBarItem container_<?php echo $this->_tpl_vars['item']['class']; ?>
">
         <?php if ($this->_tpl_vars['item']['title'] != ""): ?>
            <h3 class="serendipitySideBarTitle <?php echo $this->_tpl_vars['item']['class']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</h3>
         <?php else: ?>
            <div class="serendipitySideBarTitleEmpty"></div>
         <?php endif; ?>
         <div class="serendipitySideBarContent"><?php echo $this->_tpl_vars['item']['content']; ?>
</div>
         <div class="serendipitySideBarFooter"></div>
      </div>
   <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['is_raw_mode']): ?>
</div>
<?php endif; ?>