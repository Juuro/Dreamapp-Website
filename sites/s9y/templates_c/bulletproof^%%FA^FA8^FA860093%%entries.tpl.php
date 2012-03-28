<?php /* Smarty version 2.6.26, created on 2010-10-28 14:45:07
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_hookPlugin', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 2, false),array('function', 'serendipity_printTrackbacks', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 320, false),array('function', 'serendipity_printComments', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 335, false),array('function', 'serendipity_getFile', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 381, false),array('function', 'eval', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 420, false),array('modifier', 'formatTime', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 11, false),array('modifier', 'makeFilename', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 17, false),array('modifier', 'escape', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 28, false),array('modifier', 'emptyPrefix', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 128, false),array('modifier', 'truncate', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 137, false),array('modifier', 'sprintf', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 138, false),array('modifier', 'default', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 287, false),array('modifier', 'string_format', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/entries.tpl', 431, false),)), $this); ?>
<!-- ENTRIES START -->
<?php echo serendipity_smarty_hookPlugin(array('hook' => 'entries_header','addData' => ($this->_tpl_vars['entry_id'])), $this);?>


<?php $_from = $this->_tpl_vars['entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dategroup']):
?>
<div class="hentry serendipity_Entry_Date<?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?> serendipity_Sticky_Entry<?php endif; ?>">
    <?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?>
        <?php if ($this->_tpl_vars['template_option']['show_sticky_entry_heading'] == 'true'): ?>
            <h3 class="serendipity_date"><?php echo @STICKY_POSTINGS; ?>
</h3>
        <?php endif; ?>
    <?php else: ?>
        <h3 class="serendipity_date"><abbr class="published" title="<?php echo serendipity_smarty_formatTime($this->_tpl_vars['dategroup']['date'], '%Y-%m-%dT%H:%M:%S%Z'); ?>
"><?php echo serendipity_smarty_formatTime($this->_tpl_vars['dategroup']['date'], $this->_tpl_vars['template_option']['date_format']); ?>
</abbr></h3>
    <?php endif; ?>

    <?php $_from = $this->_tpl_vars['dategroup']['entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
        <h4 class="entry-title serendipity_title"><a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
" rel="bookmark"><?php echo $this->_tpl_vars['entry']['title']; ?>
</a></h4>

        <div class="serendipity_entry serendipity_entry_author_<?php echo serendipity_makeFilename($this->_tpl_vars['entry']['author']); ?>
 <?php if ($this->_tpl_vars['entry']['is_entry_owner']): ?>serendipity_entry_author_self<?php endif; ?>">

            <?php if (( ! $this->_tpl_vars['dategroup']['is_sticky'] || ( $this->_tpl_vars['dategroup']['is_sticky'] && $this->_tpl_vars['template_option']['show_sticky_entry_footer'] == 'true' ) )): ?>
                <?php if ($this->_tpl_vars['template_option']['entryfooterpos'] == 'belowtitle'): ?>
                    <div class='serendipity_entryFooter belowtitle'>
                        <?php if ($this->_tpl_vars['template_option']['footerauthor'] == 'true'): ?>
                            <?php echo @POSTED_BY; ?>
 <address class="author"><a href="<?php echo $this->_tpl_vars['entry']['link_author']; ?>
"><?php echo $this->_tpl_vars['entry']['author']; ?>
</a></address>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footercategories'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['categories']): ?>
                                <?php echo @IN; ?>
 <?php $_from = $this->_tpl_vars['entry']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry_category']):
        $this->_foreach['categories']['iteration']++;
?><a href="<?php echo $this->_tpl_vars['entry_category']['category_link']; ?>
"><?php echo smarty_modifier_escape($this->_tpl_vars['entry_category']['category_name']); ?>
</a><?php if (! ($this->_foreach['categories']['iteration'] == $this->_foreach['categories']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footertimestamp'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?>
                                <?php echo @ON; ?>

                            <?php else: ?>
                                <?php echo @AT; ?>

                            <?php endif; ?>
                            <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
"><?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], $this->_tpl_vars['template_option']['date_format']); ?>
 <?php endif; ?><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], '%H:%M'); ?>
</a>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footercomments'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['has_comments']): ?>
                                <?php if ($this->_tpl_vars['use_popups']): ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_comments']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php if ($this->_tpl_vars['entry']['comments'] == 0): ?><?php echo @NO_COMMENTS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_comments']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php echo $this->_tpl_vars['entry']['label_comments']; ?>
 (<?php echo $this->_tpl_vars['entry']['comments']; ?>
)</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><?php if ($this->_tpl_vars['entry']['comments'] == 0): ?><?php echo @NO_COMMENTS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><?php echo $this->_tpl_vars['entry']['label_comments']; ?>
 (<?php echo $this->_tpl_vars['entry']['comments']; ?>
)</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footertrackbacks'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['has_trackbacks']): ?>
                                <?php if ($this->_tpl_vars['use_popups']): ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_trackbacks']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php if ($this->_tpl_vars['entry']['trackbacks'] == 0): ?><?php echo @NO_TRACKBACKS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_trackbacks']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
 (<?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
)</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#trackbacks"><?php if ($this->_tpl_vars['entry']['trackbacks'] == 0): ?><?php echo @NO_TRACKBACKS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#trackbacks"><?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
 (<?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
)</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['entry']['is_entry_owner'] && ! $this->_tpl_vars['is_preview']): ?>
                        <div class="editentrylink"><a href="<?php echo $this->_tpl_vars['entry']['link_edit']; ?>
"><?php echo @EDIT_ENTRY; ?>
</a></div>
                        <?php endif; ?>

                        <?php echo $this->_tpl_vars['entry']['add_footer']; ?>


                        <?php if ($this->_tpl_vars['template_option']['addthiswidget'] == 'true'): ?>
                            <div class="addthiswidget">
                                <script type="text/javascript">
                                    addthis_url = '<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['rdf_ident'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
';
                                    addthis_title = '<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
';
                                    addthis_pub = '<?php echo $this->_tpl_vars['template_option']['addthisaccount']; ?>
';
                                </script>
                                <script type="text/javascript" src="http://s7.addthis.com/js/addthis_widget.php?v=12" ></script>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['template_option']['entryfooterpos'] == 'splitfoot'): ?>
                  <?php if ($this->_tpl_vars['template_option']['footerauthor'] == 'false' && $this->_tpl_vars['template_option']['footercategories'] == 'false' && $this->_tpl_vars['template_option']['footertimestamp'] == 'false'): ?>
                  <?php else: ?>
                    <div class='serendipity_entryFooter byline'>
                        <?php if ($this->_tpl_vars['template_option']['footerauthor'] == 'true'): ?>
                            <?php echo @POSTED_BY; ?>
 <address class="author"><a href="<?php echo $this->_tpl_vars['entry']['link_author']; ?>
"><?php echo $this->_tpl_vars['entry']['author']; ?>
</a></address>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footercategories'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['categories']): ?>
                                <?php echo @IN; ?>
 <?php $_from = $this->_tpl_vars['entry']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry_category']):
        $this->_foreach['categories']['iteration']++;
?><a href="<?php echo $this->_tpl_vars['entry_category']['category_link']; ?>
"><?php echo smarty_modifier_escape($this->_tpl_vars['entry_category']['category_name']); ?>
</a><?php if (! ($this->_foreach['categories']['iteration'] == $this->_foreach['categories']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footertimestamp'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?>
                                <?php echo @ON; ?>

                            <?php else: ?>
                                <?php echo @AT; ?>

                            <?php endif; ?>
                            <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
"><?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], $this->_tpl_vars['template_option']['date_format']); ?>
 <?php endif; ?><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], '%H:%M'); ?>
</a>
                        <?php endif; ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['entry']['categories']): ?>
                <span class="serendipity_entryIcon">
                    <?php $_from = $this->_tpl_vars['entry']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry_category']):
?>
                        <?php if ($this->_tpl_vars['entry_category']['category_icon']): ?>
                            <a href="<?php echo $this->_tpl_vars['entry_category']['category_link']; ?>
"><img class="serendipity_entryIcon" title="<?php echo smarty_modifier_escape($this->_tpl_vars['entry_category']['category_name']); ?>
<?php echo serendipity_emptyPrefix($this->_tpl_vars['entry_category']['category_description']); ?>
" alt="<?php echo smarty_modifier_escape($this->_tpl_vars['entry_category']['category_name']); ?>
" src="<?php echo $this->_tpl_vars['entry_category']['category_icon']; ?>
" /></a>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
               </span>
            <?php endif; ?>
  
            <div class="entry-content serendipity_entry_body">
                <?php echo $this->_tpl_vars['entry']['body']; ?>

                <?php if ($this->_tpl_vars['entry']['has_extended'] && ! $this->_tpl_vars['is_single_entry'] && ! $this->_tpl_vars['entry']['is_extended']): ?>
                    <?php $this->assign('shorttitle', smarty_modifier_truncate($this->_tpl_vars['entry']['title'], 50, '...')); ?>
                    <span class="continue_reading"><a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#extended" title='<?php echo sprintf(@VIEW_EXTENDED_ENTRY, $this->_tpl_vars['shorttitle']); ?>
'><?php echo sprintf(@VIEW_EXTENDED_ENTRY, $this->_tpl_vars['shorttitle']); ?>
 &#187;</a></span>
                <?php endif; ?>
           </div>

            <?php if ($this->_tpl_vars['entry']['is_extended']): ?>
                <div class="serendipity_entry_extended"><a id="extended"></a><?php echo $this->_tpl_vars['entry']['extended']; ?>
</div>
            <?php endif; ?>

            <?php if (( ! $this->_tpl_vars['dategroup']['is_sticky'] || ( $this->_tpl_vars['dategroup']['is_sticky'] && $this->_tpl_vars['template_option']['show_sticky_entry_footer'] == 'true' ) )): ?>
                <?php if ($this->_tpl_vars['template_option']['entryfooterpos'] == 'belowentry'): ?>
                    <div class='serendipity_entryFooter belowentry'>
                        <?php if ($this->_tpl_vars['template_option']['footerauthor'] == 'true'): ?>
                            <?php echo @POSTED_BY; ?>
 <address class="author"><a href="<?php echo $this->_tpl_vars['entry']['link_author']; ?>
"><?php echo $this->_tpl_vars['entry']['author']; ?>
</a></address>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footercategories'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['categories']): ?>
                                <?php echo @IN; ?>
 <?php $_from = $this->_tpl_vars['entry']['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entry_category']):
        $this->_foreach['categories']['iteration']++;
?><a href="<?php echo $this->_tpl_vars['entry_category']['category_link']; ?>
"><?php echo smarty_modifier_escape($this->_tpl_vars['entry_category']['category_name']); ?>
</a><?php if (! ($this->_foreach['categories']['iteration'] == $this->_foreach['categories']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footertimestamp'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?>
                                <?php echo @ON; ?>

                            <?php else: ?>
                                <?php echo @AT; ?>

                            <?php endif; ?>
                                <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
"><?php if ($this->_tpl_vars['dategroup']['is_sticky']): ?><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], $this->_tpl_vars['template_option']['date_format']); ?>
 <?php endif; ?><?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry']['timestamp'], '%H:%M'); ?>
</a>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footercomments'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['has_comments']): ?>
                                <?php if ($this->_tpl_vars['use_popups']): ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_comments']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php if ($this->_tpl_vars['entry']['comments'] == 0): ?><?php echo @NO_COMMENTS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_comments']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php echo $this->_tpl_vars['entry']['label_comments']; ?>
 (<?php echo $this->_tpl_vars['entry']['comments']; ?>
)</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><?php if ($this->_tpl_vars['entry']['comments'] == 0): ?><?php echo @NO_COMMENTS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><?php echo $this->_tpl_vars['entry']['label_comments']; ?>
 (<?php echo $this->_tpl_vars['entry']['comments']; ?>
)</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footertrackbacks'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['has_trackbacks']): ?>
                                <?php if ($this->_tpl_vars['use_popups']): ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_trackbacks']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php if ($this->_tpl_vars['entry']['trackbacks'] == 0): ?><?php echo @NO_TRACKBACKS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_trackbacks']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
 (<?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
)</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#trackbacks"><?php if ($this->_tpl_vars['entry']['trackbacks'] == 0): ?><?php echo @NO_TRACKBACKS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#trackbacks"><?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
 (<?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
)</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['entry']['is_entry_owner'] && ! $this->_tpl_vars['is_preview']): ?>
                            <div class="editentrylink"><a href="<?php echo $this->_tpl_vars['entry']['link_edit']; ?>
"><?php echo @EDIT_ENTRY; ?>
</a></div>
                        <?php endif; ?>

                        <?php echo $this->_tpl_vars['entry']['add_footer']; ?>


                        <?php if ($this->_tpl_vars['template_option']['addthiswidget'] == 'true'): ?>
                            <div class="addthiswidget">
                                <a href="http://www.addthis.com/bookmark.php?v=250" onmouseover="return addthis_open(this, '', encodeURIComponent('<?php echo $this->_tpl_vars['entry']['rdf_ident']; ?>
'), encodeURIComponent('<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
'));" onmouseout="addthis_close()" onclick="return addthis_sendto()" title="Bookmark and Share" target="_blank"><img src="http://s7.addthis.com/static/btn/lg-bookmark-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0" /></a>
                                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=<?php echo $this->_tpl_vars['template_option']['addthisaccount']; ?>
"></script>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['template_option']['entryfooterpos'] == 'splitfoot'): ?>
                    <div class='serendipity_entryFooter infofooter'>
                        <?php if ($this->_tpl_vars['template_option']['footercomments'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['has_comments']): ?>
                                <?php if ($this->_tpl_vars['use_popups']): ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        <a href="<?php echo $this->_tpl_vars['entry']['link_popup_comments']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php if ($this->_tpl_vars['entry']['comments'] == 0): ?><?php echo @NO_COMMENTS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo $this->_tpl_vars['entry']['link_popup_comments']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php echo $this->_tpl_vars['entry']['label_comments']; ?>
 (<?php echo $this->_tpl_vars['entry']['comments']; ?>
)</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><?php if ($this->_tpl_vars['entry']['comments'] == 0): ?><?php echo @NO_COMMENTS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['comments']; ?>
 <?php echo $this->_tpl_vars['entry']['label_comments']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#comments"><?php echo $this->_tpl_vars['entry']['label_comments']; ?>
 (<?php echo $this->_tpl_vars['entry']['comments']; ?>
)</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['template_option']['footertrackbacks'] == 'true'): ?>
                            <?php if ($this->_tpl_vars['entry']['has_trackbacks']): ?>
                                <?php if ($this->_tpl_vars['use_popups']): ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_trackbacks']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php if ($this->_tpl_vars['entry']['trackbacks'] == 0): ?><?php echo @NO_TRACKBACKS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link_popup_trackbacks']; ?>
" onclick="window.open(this.href, 'comments', 'width=600,height=600,scrollbars=yes,resizable=yes'); return false;"><?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
 (<?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
)</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['template_option']['altcommtrack'] == 'true'): ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#trackbacks"><?php if ($this->_tpl_vars['entry']['trackbacks'] == 0): ?><?php echo @NO_TRACKBACKS; ?>
<?php else: ?><?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
 <?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
<?php endif; ?></a>
                                    <?php else: ?>
                                        | <a href="<?php echo $this->_tpl_vars['entry']['link']; ?>
#trackbacks"><?php echo $this->_tpl_vars['entry']['label_trackbacks']; ?>
 (<?php echo $this->_tpl_vars['entry']['trackbacks']; ?>
)</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['entry']['is_entry_owner'] && ! $this->_tpl_vars['is_preview']): ?>
                            <div class="editentrylink"><a href="<?php echo $this->_tpl_vars['entry']['link_edit']; ?>
"><?php echo @EDIT_ENTRY; ?>
</a></div>
                        <?php endif; ?>

                        <?php echo $this->_tpl_vars['entry']['add_footer']; ?>


                        <?php if ($this->_tpl_vars['template_option']['addthiswidget'] == 'true'): ?>
                            <div class="addthiswidget">
                                <script type="text/javascript">
                                    addthis_url = '<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['rdf_ident'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
';
                                    addthis_title = '<?php echo ((is_array($_tmp=$this->_tpl_vars['entry']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
';
                                    addthis_pub = '<?php echo $this->_tpl_vars['template_option']['addthisaccount']; ?>
';
                                </script>
                                <script type="text/javascript" src="http://s7.addthis.com/js/addthis_widget.php?v=12" ></script>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

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
        <?php echo $this->_tpl_vars['entry']['plugin_display_dat']; ?>


        <?php if ($this->_tpl_vars['is_single_entry'] && ! $this->_tpl_vars['use_popups'] && ! $this->_tpl_vars['is_preview']): ?>
            <?php if (@DATA_UNSUBSCRIBED): ?>
                <div class="serendipity_center serendipity_msg_notice"><?php echo sprintf(@DATA_UNSUBSCRIBED, @UNSUBSCRIBE_OK); ?>
</div>
            <?php endif; ?>

            <?php if (@DATA_TRACKBACK_DELETED): ?>
                <div class="serendipity_center serendipity_msg_notice"><?php echo sprintf(@DATA_TRACKBACK_DELETED, @TRACKBACK_DELETED); ?>
</div>
            <?php endif; ?>

            <?php if (@DATA_TRACKBACK_APPROVED): ?>
                <div class="serendipity_center serendipity_msg_notice"><?php echo sprintf(@DATA_TRACKBACK_APPROVED, @TRACKBACK_APPROVED); ?>
</div>
            <?php endif; ?>

            <?php if (@DATA_COMMENT_DELETED): ?>
                <div class="serendipity_center serendipity_msg_notice"><?php echo sprintf(@DATA_COMMENT_DELETED, @COMMENT_DELETED); ?>
</div>
            <?php endif; ?>

            <?php if (@DATA_COMMENT_APPROVED): ?>
                <div class="serendipity_center serendipity_msg_notice"><?php echo sprintf(@DATA_COMMENT_APPROVED, @COMMENT_APPROVED); ?>
</div>
            <?php endif; ?>

            <div class="serendipity_comments serendipity_section_trackbacks">
                <a id="trackbacks"></a>
                <div class="serendipity_commentsTitle"><?php echo @TRACKBACKS; ?>
</div>
                <div class="serendipity_center">
                    <a rel="nofollow" style="font-weight: normal" href="<?php echo $this->_tpl_vars['entry']['link_trackback']; ?>
" onclick="alert('<?php echo smarty_modifier_escape(@TRACKBACK_SPECIFIC_ON_CLICK, 'html'); ?>
'); return false;" title="<?php echo smarty_modifier_escape(@TRACKBACK_SPECIFIC_ON_CLICK); ?>
"><?php echo @TRACKBACK_SPECIFIC; ?>
</a>
                </div>
                <div id="serendipity_trackbacklist"><?php echo serendipity_smarty_printTrackbacks(array('entry' => $this->_tpl_vars['entry']['id']), $this);?>
</div>
            </div>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['is_single_entry'] && ! $this->_tpl_vars['is_preview']): ?>
            <div class="serendipity_comments serendipity_section_comments">
                <a id="comments"></a>
                <div class="serendipity_commentsTitle"><?php echo @COMMENTS; ?>
</div>
                <div class="serendipity_center"><?php echo @DISPLAY_COMMENTS_AS; ?>

                    <?php if ($this->_tpl_vars['entry']['viewmode'] == @VIEWMODE_LINEAR): ?>
                        (<?php echo @COMMENTS_VIEWMODE_LINEAR; ?>
 | <a href="<?php echo $this->_tpl_vars['entry']['link_viewmode_threaded']; ?>
#comments" rel="nofollow"><?php echo @COMMENTS_VIEWMODE_THREADED; ?>
</a>)
                    <?php else: ?>
                        (<a rel="nofollow" href="<?php echo $this->_tpl_vars['entry']['link_viewmode_linear']; ?>
#comments"><?php echo @COMMENTS_VIEWMODE_LINEAR; ?>
</a> | <?php echo @COMMENTS_VIEWMODE_THREADED; ?>
)
                    <?php endif; ?>
                </div>
                <div id="serendipity_commentlist"><?php echo serendipity_smarty_printComments(array('entry' => $this->_tpl_vars['entry']['id'],'mode' => $this->_tpl_vars['entry']['viewmode']), $this);?>
</div>

                <?php if ($this->_tpl_vars['entry']['is_entry_owner']): ?>
                    <?php if ($this->_tpl_vars['entry']['allow_comments']): ?>
                        <div class="serendipity_center">(<a href="<?php echo $this->_tpl_vars['entry']['link_deny_comments']; ?>
"><?php echo @COMMENTS_DISABLE; ?>
</a>)</div>
                    <?php else: ?>
                        <div class="serendipity_center">(<a href="<?php echo $this->_tpl_vars['entry']['link_allow_comments']; ?>
"><?php echo @COMMENTS_ENABLE; ?>
</a>)</div>
                    <?php endif; ?>
                <?php endif; ?>
                <a id="feedback"></a>

                <?php $_from = $this->_tpl_vars['comments_messagestack']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['message']):
?>
                    <div class="serendipity_center serendipity_msg_important"><?php echo $this->_tpl_vars['message']; ?>
</div>
                <?php endforeach; endif; unset($_from); ?>

                <?php if ($this->_tpl_vars['is_comment_added']): ?>
                    <div class="serendipity_center serendipity_msg_notice"><?php echo @COMMENT_ADDED; ?>
</div>
                <?php elseif ($this->_tpl_vars['is_comment_moderate']): ?>
                    <div class="serendipity_center serendipity_msg_notice"><?php echo @COMMENT_ADDED; ?>
<br /><?php echo @THIS_COMMENT_NEEDS_REVIEW; ?>
</div>
                <?php elseif (! $this->_tpl_vars['entry']['allow_comments']): ?>
                    <div class="serendipity_center serendipity_msg_important"><?php echo @COMMENTS_CLOSED; ?>
</div>
                <?php else: ?>
                   <div class="serendipity_section_commentform">
                       <div class="serendipity_commentsTitle"><?php echo @ADD_COMMENT; ?>
</div>
                       <?php echo $this->_tpl_vars['COMMENTFORM']; ?>

                   </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php echo $this->_tpl_vars['entry']['backend_preview']; ?>

    <?php endforeach; endif; unset($_from); ?>
</div>

<?php endforeach; else: ?>
    <?php if (! $this->_tpl_vars['plugin_clean_page']): ?>
        <div class="serendipity_overview_noentries">
            <?php echo @NO_ENTRIES_TO_PRINT; ?>

        </div>
    <?php endif; ?>
<?php endif; unset($_from); ?>

<div class='serendipity_pageFooter' style="text-align: center">
    <?php if ($this->_tpl_vars['footer_prev_page']): ?>
        <?php if ($this->_tpl_vars['template_option']['prev_next_style'] == 'texticon'): ?>
            <?php if ($this->_tpl_vars['template_option']['colorset'] == 'blank'): ?>
                <a title="<?php echo @PREVIOUS_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
"><img alt="<?php echo @PREVIOUS_PAGE; ?>
" title="<?php echo @PREVIOUS_PAGE; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/back.png"), $this);?>
" /><?php echo @PREVIOUS_PAGE; ?>
</a>
            <?php else: ?>
                <a title="<?php echo @PREVIOUS_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
"><img alt="<?php echo @PREVIOUS_PAGE; ?>
" title="<?php echo @PREVIOUS_PAGE; ?>
" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_back.png" /><?php echo @PREVIOUS_PAGE; ?>
</a>
            <?php endif; ?>
        <?php elseif ($this->_tpl_vars['template_option']['prev_next_style'] == 'icon'): ?>
            <?php if ($this->_tpl_vars['template_option']['colorset'] == 'blank'): ?>
                <a title="<?php echo @PREVIOUS_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
"><img alt="<?php echo @PREVIOUS_PAGE; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/back.png"), $this);?>
" /><?php echo @PREVIOUS_PAGE; ?>
</a>
            <?php else: ?>
                <a title="<?php echo @PREVIOUS_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
"><img alt="<?php echo @PREVIOUS_PAGE; ?>
" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_back.png" /></a>
            <?php endif; ?>
        <?php elseif ($this->_tpl_vars['template_option']['prev_next_style'] == 'text'): ?>
            <a title="<?php echo @PREVIOUS_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
">&#171; <?php echo @PREVIOUS_PAGE; ?>
</a>&#160;&#160;
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['footer_info']): ?>
        (<?php echo $this->_tpl_vars['footer_info']; ?>
)
    <?php endif; ?>

    <?php if ($this->_tpl_vars['footer_next_page']): ?>
        <?php if ($this->_tpl_vars['template_option']['prev_next_style'] == 'texticon'): ?>
            <?php if ($this->_tpl_vars['template_option']['colorset'] == 'blank'): ?>
                <a title="<?php echo @NEXT_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><?php echo @NEXT_PAGE; ?>
<img alt="<?php echo @NEXT_PAGE; ?>
" title="<?php echo @NEXT_PAGE; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/forward.png"), $this);?>
" /></a>
            <?php else: ?>
                <a title="<?php echo @NEXT_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><?php echo @NEXT_PAGE; ?>
<img alt="<?php echo @NEXT_PAGE; ?>
" title="<?php echo @NEXT_PAGE; ?>
" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_forward.png" /></a>
            <?php endif; ?>
        <?php elseif ($this->_tpl_vars['template_option']['prev_next_style'] == 'icon'): ?>
            <?php if ($this->_tpl_vars['template_option']['colorset'] == 'blank'): ?>
                <a title="<?php echo @NEXT_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><img alt="<?php echo @NEXT_PAGE; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/forward.png"), $this);?>
" /></a>
            <?php else: ?>
                <a title="<?php echo @NEXT_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><img alt="<?php echo @NEXT_PAGE; ?>
" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_forward.png" /></a>
            <?php endif; ?>
        <?php elseif ($this->_tpl_vars['template_option']['prev_next_style'] == 'text'): ?>
             <a title="<?php echo @NEXT_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><?php echo @NEXT_PAGE; ?>
 &#187;</a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['template_option']['show_pagination'] == 'true' && $this->_tpl_vars['footer_totalPages'] > 1): ?>
        <div class="pagination">
            <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['footer_currentPage']-3,'assign' => 'paginationStartPage'), $this);?>

            <?php if ($this->_tpl_vars['footer_currentPage']+3 > $this->_tpl_vars['footer_totalPages']): ?>
                <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['footer_totalPages']-6,'assign' => 'paginationStartPage'), $this);?>

            <?php endif; ?>
            <?php if ($this->_tpl_vars['paginationStartPage'] <= 0): ?>
                <?php $this->assign('paginationStartPage', '1'); ?>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['footer_prev_page']): ?>
                <a title="<?php echo @PREVIOUS_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_prev_page']; ?>
"><span class="pagearrow">&#9668;</span></a>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['paginationStartPage'] > 1): ?>
                <a href="<?php echo ((is_array($_tmp='1')) ? $this->_run_mod_handler('string_format', true, $_tmp, $this->_tpl_vars['footer_pageLink']) : smarty_modifier_string_format($_tmp, $this->_tpl_vars['footer_pageLink'])); ?>
">1</a>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['paginationStartPage'] > 2): ?>
                &hellip;
            <?php endif; ?>
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['start'] = (int)$this->_tpl_vars['paginationStartPage'];
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['footer_totalPages']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['max'] = (int)7;
$this->_sections['i']['show'] = true;
if ($this->_sections['i']['max'] < 0)
    $this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                <?php if ($this->_sections['i']['index'] != $this->_tpl_vars['footer_currentPage']): ?>
                    <a href="<?php echo ((is_array($_tmp=$this->_sections['i']['index'])) ? $this->_run_mod_handler('string_format', true, $_tmp, $this->_tpl_vars['footer_pageLink']) : smarty_modifier_string_format($_tmp, $this->_tpl_vars['footer_pageLink'])); ?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
                <?php else: ?>
                    <span id="thispage"><?php echo $this->_sections['i']['index']; ?>
</span>
                <?php endif; ?>
            <?php endfor; endif; ?>
            <?php if ($this->_sections['i']['index'] < $this->_tpl_vars['footer_totalPages']): ?>
                &hellip;
            <?php endif; ?>
            <?php if ($this->_sections['i']['index'] <= $this->_tpl_vars['footer_totalPages']): ?>
                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['footer_totalPages'])) ? $this->_run_mod_handler('string_format', true, $_tmp, $this->_tpl_vars['footer_pageLink']) : smarty_modifier_string_format($_tmp, $this->_tpl_vars['footer_pageLink'])); ?>
"><?php echo $this->_tpl_vars['footer_totalPages']; ?>
</a>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['footer_next_page']): ?>
                <a title="<?php echo @NEXT_PAGE; ?>
" href="<?php echo $this->_tpl_vars['footer_next_page']; ?>
"><span class="pagearrow">&#9658;</span></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <?php echo serendipity_smarty_hookPlugin(array('hook' => 'entries_footer'), $this);?>

</div>
<!-- ENTRIES END -->