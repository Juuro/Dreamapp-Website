<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:04
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_hookPlugin', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 1, false),array('function', 'serendipity_printTrackbacks', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 70, false),array('function', 'serendipity_printComments', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 77, false),array('modifier', 'formatTime', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 8, false),array('modifier', 'escape', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 14, false),array('modifier', 'default', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 43, false),array('modifier', 'sprintf', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/entries.tpl', 50, false),)), $this); ?>
<?php echo serendipity_smarty_hookPlugin(array('hook' => 'entries_header','addData' => ($this->_tpl_vars['entry_id'])), $this);?>


<?php $_from = $this->_tpl_vars['entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dategroup']):
?>
  <?php $_from = $this->_tpl_vars['dategroup']['entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
    <div id="post-<?php echo $this->_tpl_vars['entry']['id']; ?>
" class="post">
        <div class="PostHead">
            <div class="PostTime">
                <b><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], '%d'); ?>
</b>
                <i><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], '%b %Y'); ?>
</i>
            </div>

            <h2><a title="Permanent Link: <?php echo $this->_tpl_vars['entry']['title']; ?>
" href="<?php echo $this->_tpl_vars['entry']['link']; ?>
" rel="bookmark"><?php echo $this->_tpl_vars['entry']['title']; ?>
</a><?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?> (<?php echo @STICKY_POSTINGS; ?>
)<?php endif; ?></h2>

            <small class="PostDet"><?php if ($this->_tpl_vars['entry']['is_entry_owner'] && ! $this->_tpl_vars['is_preview']): ?><a href="<?php echo $this->_tpl_vars['entry']['link_edit']; ?>
"><?php echo @EDIT_ENTRY; ?>
</a> | <?php endif; ?>Author: <?php echo $this->_tpl_vars['entry']['author']; ?>
<?php if ($this->_tpl_vars['entry']['categories']): ?> | Filed under: <?php $_from = $this->_tpl_vars['entry']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry_category']):
        $this->_foreach['categories']['iteration']++;
?><a href="<?php echo $this->_tpl_vars['entry_category']['category_link']; ?>
"><?php echo smarty_modifier_escape($this->_tpl_vars['entry_category']['category_name']); ?>
</a><?php if (! ($this->_foreach['categories']['iteration'] == $this->_foreach['categories']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?><?php endif; ?></small>
        </div><!-- /.PostHead -->

        <div class="entry">
            <?php echo $this->_tpl_vars['entry']['body']; ?>

          <?php if ($this->_tpl_vars['entry']['is_extended']): ?>
            <div id="extended"><?php echo $this->_tpl_vars['entry']['extended']; ?>
</div>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['entry']['has_extended'] && ! $this->_tpl_vars['is_single_entry'] && ! $this->_tpl_vars['entry']['is_extended']): ?>
            <p class="serif"><a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#extended">Read the rest of this entry &raquo;</a></p>
          <?php endif; ?>
        </div><!-- /.entry -->

        <p class="postmetadata">
        <?php echo $this->_tpl_vars['entry']['add_footer']; ?>

        <?php echo $this->_tpl_vars['entry']['plugin_display_dat']; ?>

        </p>

      <?php if ($this->_tpl_vars['entry']['has_comments'] && ! $this->_tpl_vars['is_single_entry']): ?>
        <div class="comments"><a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><span> <?php echo $this->_tpl_vars['entry']['comments']; ?>
 </span> <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
</a></div>
      <?php endif; ?>

        <!--
        <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                 xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/"
                 xmlns:dc="http://purl.org/dc/elements/1.1/">
        <rdf:Description
                 rdf:about="<?php echo $this->_tpl_vars['entry']['link_rdf']; ?>
"
                 trackback:ping="<?php echo $this->_tpl_vars['entry']['link_trackback']; ?>
"
                 dc:title="<?php echo smarty_modifier_default(@$this->_tpl_vars['entry']['title_rdf'], @$this->_tpl_vars['entry']['title']); ?>
"
                 dc:identifier="<?php echo $this->_tpl_vars['entry']['rdf_ident']; ?>
" />
        </rdf:RDF>
        -->

    <?php if ($this->_tpl_vars['is_single_entry'] && ! $this->_tpl_vars['use_popups'] && ! $this->_tpl_vars['is_preview']): ?>
      <?php if (@DATA_UNSUBSCRIBED): ?>
        <p class="serendipity_msg_notice"><?php echo sprintf(@DATA_UNSUBSCRIBED, @UNSUBSCRIBE_OK); ?>
</p>
      <?php endif; ?>
      <?php if (@DATA_TRACKBACK_DELETED): ?>
        <p class="serendipity_msg_notice"><?php echo sprintf(@DATA_TRACKBACK_DELETED, @TRACKBACK_DELETED); ?>
</p>
      <?php endif; ?>
      <?php if (@DATA_TRACKBACK_APPROVED): ?>
        <p class="serendipity_msg_notice"><?php echo sprintf(@DATA_TRACKBACK_APPROVED, @TRACKBACK_APPROVED); ?>
</p>
      <?php endif; ?>
      <?php if (@DATA_COMMENT_DELETED): ?>
        <p class="serendipity_msg_notice"><?php echo sprintf(@DATA_COMMENT_DELETED, @COMMENT_DELETED); ?>
</p>
      <?php endif; ?>
      <?php if (@DATA_COMMENT_APPROVED): ?>
        <p class="serendipity_msg_notice"><?php echo sprintf(@DATA_COMMENT_APPROVED, @COMMENT_APPROVED); ?>
</p>
      <?php endif; ?>

        <div class="CommWidth">
            <h3 id="trackbacks"><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
</h3>

            <p id="trackback-url"><a rel="nofollow" href="<?php echo $this->_tpl_vars['entry']['link_trackback']; ?>
" onclick="alert('<?php echo smarty_modifier_escape(@TRACKBACK_SPECIFIC_ON_CLICK, 'html'); ?>
'); return false;" title="<?php echo smarty_modifier_escape(@TRACKBACK_SPECIFIC_ON_CLICK); ?>
"><?php echo @TRACKBACK_SPECIFIC; ?>
</a></p>

            <?php echo serendipity_smarty_printTrackbacks(array('entry' => $this->_tpl_vars['entry']['id']), $this);?>

        </div><!-- /.CommWidth -->
    <?php endif; ?>

    <?php if ($this->_tpl_vars['is_single_entry'] && ! $this->_tpl_vars['is_preview']): ?>
        <div class="CommWidth">
            <h3 id="comments"><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
</h3>                
            <?php echo serendipity_smarty_printComments(array('entry' => $this->_tpl_vars['entry']['id'],'mode' => $this->_tpl_vars['entry']['viewmode']), $this);?>

        <?php if ($this->_tpl_vars['entry']['is_entry_owner']): ?>
          <?php if ($this->_tpl_vars['entry']['allow_comments']): ?>
            <p>(<a href="<?php echo $this->_tpl_vars['entry']['link_deny_comments']; ?>
"><?php echo @COMMENTS_DISABLE; ?>
</a>)</p>
          <?php else: ?>
            <p>(<a href="<?php echo $this->_tpl_vars['entry']['link_allow_comments']; ?>
"><?php echo @COMMENTS_ENABLE; ?>
</a>)</p>
          <?php endif; ?>
        <?php endif; ?>
            <a id="feedback"></a>
          <?php $_from = $this->_tpl_vars['comments_messagestack']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
            <p class="serendipity_msg_important"><?php echo $this->_tpl_vars['message']; ?>
</p>
          <?php endforeach; endif; unset($_from); ?>
          <?php if ($this->_tpl_vars['is_comment_added']): ?>
            <p class="serendipity_msg_notice"><?php echo @COMMENT_ADDED; ?>
</p>
          <?php elseif ($this->_tpl_vars['is_comment_moderate']): ?>
            <p class="serendipity_msg_notice"><strong><?php echo @COMMENT_ADDED; ?>
:</strong><?php echo @THIS_COMMENT_NEEDS_REVIEW; ?>
</p>
          <?php elseif (! $this->_tpl_vars['entry']['allow_comments']): ?>
            <p class="serendipity_msg_important"><?php echo @COMMENTS_CLOSED; ?>
</p>
          <?php else: ?>
            <?php echo $this->_tpl_vars['COMMENTFORM']; ?>

          <?php endif; ?>
        </div><!-- /.CommWidth -->
    <?php endif; ?>
    </div><!-- /.post -->
  <?php echo $this->_tpl_vars['entry']['backend_preview']; ?>

  <?php endforeach; endif; unset($_from); ?>
<?php endforeach; else: ?>
  <?php if (! $this->_tpl_vars['plugin_clean_page']): ?>
    <p><?php echo @NO_ENTRIES_TO_PRINT; ?>
</p>
  <?php endif; ?>
<?php endif; unset($_from); ?>

    <div class="serendipity_pageFooter">
    <?php if ($this->_tpl_vars['footer_prev_page']): ?>
        <a class="prev-page" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
">&laquo; <?php echo @PREVIOUS_PAGE; ?>
</a>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['footer_next_page']): ?>
        <a class="next-page" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><?php echo @NEXT_PAGE; ?>
 &raquo;</a>
    <?php endif; ?>
    <?php echo serendipity_smarty_hookPlugin(array('hook' => 'entries_footer'), $this);?>

    </div>