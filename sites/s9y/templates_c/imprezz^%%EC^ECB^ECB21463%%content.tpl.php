<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:04
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/content.tpl */ ?>
<?php if ($this->_tpl_vars['searchresult_tooShort']): ?>
    <h2 class="pagetitle"><?php echo @QUICKSEARCH; ?>
</h2>
    <p class="serendipity_search_tooshort"><?php echo $this->_tpl_vars['content_message']; ?>
</p>
<?php elseif ($this->_tpl_vars['searchresult_error']): ?>
    <h2 class="pagetitle"><?php echo @QUICKSEARCH; ?>
</h2>
    <p class="serendipity_search_error"><?php echo $this->_tpl_vars['content_message']; ?>
</p>
<?php elseif ($this->_tpl_vars['searchresult_noEntries']): ?>
    <h2 class="pagetitle"><?php echo @QUICKSEARCH; ?>
</h2>
    <p class="serendipity_search_noentries"><?php echo $this->_tpl_vars['content_message']; ?>
</p>
<?php elseif ($this->_tpl_vars['searchresult_results']): ?>
    <h2 class="pagetitle"><?php echo @QUICKSEARCH; ?>
</h2>
    <p class="serendipity_search_results"><?php echo $this->_tpl_vars['content_message']; ?>
</p>
<?php elseif ($this->_tpl_vars['content_message']): ?>
    <p class="serendipity_content_message"><?php echo $this->_tpl_vars['content_message']; ?>
</p>
<?php endif; ?>
<?php echo $this->_tpl_vars['ENTRIES']; ?>

<?php echo $this->_tpl_vars['ARCHIVES']; ?>
