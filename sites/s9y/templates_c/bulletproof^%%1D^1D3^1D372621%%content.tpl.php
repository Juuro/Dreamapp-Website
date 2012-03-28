<?php /* Smarty version 2.6.26, created on 2010-10-28 14:45:07
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/content.tpl */ ?>
<!-- CONTENT START -->
<?php if ($this->_tpl_vars['searchresult_tooShort']): ?>
   <div class="serendipity_Entry_Date">
      <h3 class="serendipity_date"><?php echo @QUICKSEARCH; ?>
</h3>
      <div class="serendipity_search serendipity_search_tooshort"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
   </div>
<?php elseif ($this->_tpl_vars['searchresult_error']): ?>
   <div class="serendipity_Entry_Date">
      <h3 class="serendipity_date"><?php echo @QUICKSEARCH; ?>
</h3>
      <div class="serendipity_search serendipity_search_error"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
   </div>
<?php elseif ($this->_tpl_vars['searchresult_noEntries']): ?>
   <div class="serendipity_Entry_Date">
      <h3 class="serendipity_date"><?php echo @QUICKSEARCH; ?>
</h3>
      <div class="serendipity_search serendipity_search_noentries"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
   </div>
<?php elseif ($this->_tpl_vars['searchresult_results']): ?>
   <div class="serendipity_Entry_Date">
      <h3 class="serendipity_date"><?php echo @QUICKSEARCH; ?>
</h3>
      <div class="serendipity_search serendipity_search_results"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
   </div>
<?php elseif ($this->_tpl_vars['subscribe_confirm_error']): ?>
    <div class="serendipity_Entry_Date">
        <h3 class="serendipity_date"><?php echo @ERROR; ?>
</h3>
        <div class="serendipity_msg_important comment_subscribe_error"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
    </div>
<?php elseif ($this->_tpl_vars['subscribe_confirm_success']): ?>
    <div class="serendipity_Entry_Date">
        <h3 class="serendipity_date"><?php echo @SUCCESS; ?>
</h3>
        <div class="serendipity_msg_notice comment_subscribe_success"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
    </div>
<?php else: ?>
   <div class="serendipity_content_message"><?php echo $this->_tpl_vars['content_message']; ?>
</div>
<?php endif; ?>

<?php echo $this->_tpl_vars['ENTRIES']; ?>

<?php echo $this->_tpl_vars['ARCHIVES']; ?>

<!-- CONTENT END -->
