<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:35
         compiled from /home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_getFile', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl', 4, false),array('function', 'serendipity_hookPlugin', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl', 71, false),array('modifier', 'escape', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl', 22, false),array('modifier', 'formatTime', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl', 46, false),array('modifier', 'serendipity_refhookPlugin', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl', 203, false),array('modifier', 'emit_htmlarea_code', '/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/admin/entries.tpl', 221, false),)), $this); ?>
<!-- ADMIN-ENTRY TEMPLATE: entries.tpl START -->
<?php if ($this->_tpl_vars['entry_vars']['errMsg']): ?>
    <div class="serendipityAdminMsgError"><img style="width: 22px; height: 22px; border: 0px; padding-right: 4px; vertical-align: middle" src="<?php echo serendipity_smarty_getFile(array('file' => 'admin/img/admin_msg_error.png'), $this);?>
" alt="" /><?php echo $this->_tpl_vars['entry_vars']['errMsg']; ?>
</div>
<?php endif; ?>

<form <?php echo $this->_tpl_vars['entry_vars']['entry']['entry_form']; ?>
 action="<?php echo $this->_tpl_vars['entry_vars']['targetURL']; ?>
" method="post" name="serendipityEntry" id="serendipityEntry" style="margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px">
<?php echo $this->_tpl_vars['entry_vars']['hidden']; ?>


<table class="serendipityEntryEdit" border="0" width="100%">

        <tr>
        <td>
           <span><b><?php echo @TITLE; ?>
:</b></span>
        </td>
        <td colspan="2">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td><input class="input_textbox" type="text" id="entryTitle" name="serendipity[title]" value="<?php echo smarty_modifier_escape($this->_tpl_vars['entry_vars']['entry']['title']); ?>
" size="60" /></td>
                    <td align="right">
                        <select name="serendipity[isdraft]">
                            <?php if ($this->_tpl_vars['entry_vars']['serendipityRightPublish']): ?>
                            <option  value="false" <?php if ($this->_tpl_vars['entry_vars']['draft_mode'] == 'publish'): ?>selected="selected"<?php endif; ?>><?php echo @PUBLISH; ?>
</option>
                            <?php endif; ?>
                            <option  value="true"  <?php if ($this->_tpl_vars['entry_vars']['draft_mode'] == 'draft'): ?>selected="selected"<?php endif; ?>><?php echo @DRAFT; ?>
</option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>

        <?php if ($this->_tpl_vars['entry_vars']['allowDateManipulation']): ?>
        <td>
            <b><?php echo @DATE; ?>
:</b>
        </td>
        <td>
            <input type="hidden" name="serendipity[chk_timestamp]" value="<?php echo $this->_tpl_vars['entry_vars']['timestamp']; ?>
" />
            <input class="input_textbox" type="text" name="serendipity[new_timestamp]" id="serendipityNewTimestamp" value="<?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry_vars']['timestamp'], 'DATE_FORMAT_2', true, false, true); ?>
" />
            <a href="#" onclick="document.getElementById('serendipityNewTimestamp').value = '<?php echo serendipity_smarty_formatTime($this->_tpl_vars['entry_vars']['reset_timestamp'], 'DATE_FORMAT_2', true, false, true); ?>
'; return false;" title="<?php echo @RESET_DATE_DESC; ?>
"><img src="<?php echo serendipity_smarty_getFile(array('file' => 'admin/img/clock.png'), $this);?>
" border="0"  style="vertical-align: text-top;" alt="<?php echo @RESET_DATE; ?>
" /></a>
        </td>
        <td align="right">
    <?php else: ?>
        <td align="right" colspan="3">
    <?php endif; ?>
            <a style="border:0; text-decoration: none" href="#" onclick="showItem('categoryselector'); return false" title="<?php echo @TOGGLE_OPTION; ?>
"><img src="<?php echo serendipity_smarty_getFile(array('file' => 'img/plus.png'), $this);?>
" id="option_categoryselector" style="border: 20px" alt="" border="0" /></a> <b><?php echo @CATEGORY; ?>
:</b>
            <select id="categoryselector" name="serendipity[categories][]" style="vertical-align: middle;" multiple="multiple">
                <option value="0">[<?php echo @NO_CATEGORY; ?>
]</option>
                <?php $_from = $this->_tpl_vars['entry_vars']['category_options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry_cat']):
?>
                <option value="<?php echo $this->_tpl_vars['entry_cat']['categoryid']; ?>
" <?php if ($this->_tpl_vars['entry_cat']['is_selected']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['entry_cat']['depth_pad']; ?>
<?php echo $this->_tpl_vars['entry_cat']['category_name']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>

            <script type="text/javascript" language="JavaScript">

            var plus_img  = '<?php echo serendipity_smarty_getFile(array('file' => 'img/plus.png'), $this);?>
';
            var minus_img = '<?php echo serendipity_smarty_getFile(array('file' => 'img/minus.png'), $this);?>
';
            var cat_count = <?php echo $this->_tpl_vars['entry_vars']['cat_count']; ?>
;
            var selector_toggle  = new Array();
            var selector_store   = new Array();
            var selector_restore = new Array();

            function checkSave() {
                <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_entry_checkSave','hookAll' => 'true'), $this);?>

                return true;
            }

            selector_toggle['categoryselector'] = '<?php echo $this->_tpl_vars['entry_vars']['cat_state']; ?>
';
            </script>
            <script type="text/javascript" language="JavaScript" src="<?php echo serendipity_smarty_getFile(array('file' => 'admin/category_selector.js'), $this);?>
"></script>
            <script type="text/javascript" language="JavaScript">
             addLoadEvent(showItem);
            </script>
        </td>
    </tr>
    
        <tr>
        <?php if (! $this->_tpl_vars['entry_vars']['wysiwyg']): ?>
        <td colspan="2"><b><?php echo @ENTRY_BODY; ?>
</b></td>
        <td align="right">
            <?php if ($this->_tpl_vars['entry_vars']['wysiwyg_advanced']): ?>
            <script type="text/javascript" language="JavaScript">
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insI" value="I" accesskey="i" style="font-style: italic" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'<em>\',\'</em>\')" />');
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insB" value="B" accesskey="b" style="font-weight: bold" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'<strong>\',\'</strong>\')" />');
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insU" value="U" accesskey="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'<u>\',\'</u>\')" />');
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insQ" value="<?php echo @QUOTE; ?>
" accesskey="q" style="font-style: italic" onclick="wrapSelection(document.forms[\'serendipityEntry\'][\'serendipity[body]\'],\'<blockquote>\',\'</blockquote>\')" />');
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insJ" value="img" accesskey="j" onclick="wrapInsImage(document.forms[\'serendipityEntry\'][\'serendipity[body]\'])" />');
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insImage" value="<?php echo @MEDIA; ?>
" style="" onclick="window.open(\'serendipity_admin_image_selector.php?serendipity[textarea]=body\', \'ImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');" />');
                document.write('<input type="button" class="serendipityPrettyButton input_button" name="insURL" value="URL" accesskey="l" onclick="wrapSelectionWithLink(document.forms[\'serendipityEntry\'][\'serendipity[body]\'])" />');
            </script>
            <?php else: ?>
            <script type="text/javascript" language="JavaScript">
                document.write('<input type="button" class="serendipityPrettyButton input_button" value=" B " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[body]\'], \'b\')">');
                document.write('<input type="button" class="serendipityPrettyButton input_button" value=" U " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[body]\'], \'u\')">');
                document.write('<input type="button" class="serendipityPrettyButton input_button" value=" I " onclick="serendipity_insBasic(document.forms[\'serendipityEntry\'][\'serendipity[body]\'], \'i\')">');
                document.write('<input type="button" class="serendipityPrettyButton input_button" value="<img>" onclick="serendipity_insImage(document.forms[\'serendipityEntry\'][\'serendipity[body]\'])">');
                document.write('<input type="button" class="serendipityPrettyButton input_button" value="<?php echo @MEDIA; ?>
" onclick="window.open(\'serendipity_admin_image_selector.php?serendipity[textarea]=body\', \'ImageSel\', \'width=800,height=600,toolbar=no\');">');
                document.write('<input type="button" class="serendipityPrettyButton input_button" value="Link" onclick="serendipity_insLink(document.forms[\'serendipityEntry\'][\'serendipity[body]\'])">');
            </script>
            <?php endif; ?>
            <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_entry_toolbar_body','data' => $this->_tpl_vars['entry_data']['entry'],'hookAll' => 'true'), $this);?>

        </td>
        <?php else: ?>
        <td colspan="2"><b><?php echo @ENTRY_BODY; ?>
</b></td>
        <td><?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_entry_toolbar_body','data' => $this->_tpl_vars['entry_data']['entry'],'hookAll' => 'true'), $this);?>
</td>
        <?php endif; ?>
    </tr>
    
        <tr>
        <td colspan="3">
            <textarea style="width: 100%" name="serendipity[body]" id="serendipity[body]" cols="80" rows="20"><?php echo smarty_modifier_escape($this->_tpl_vars['entry_vars']['entry']['body']); ?>
</textarea>
        </td>
    </tr>
    
        <tr>
        <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" width="70%">
                        <input class="input_checkbox" id="checkbox_allow_comments" type="checkbox" name="serendipity[allow_comments]" value="true" <?php if ($this->_tpl_vars['entry_vars']['allow_comments']): ?>checked="checked"<?php endif; ?> /><label for="checkbox_allow_comments"><?php echo @COMMENTS_ENABLE; ?>
</label><br />
                        <input class="input_checkbox" id="checkbox_moderate_comments" type="checkbox" name="serendipity[moderate_comments]" value="true" <?php if ($this->_tpl_vars['entry_vars']['moderate_comments']): ?>checked="checked"<?php endif; ?> /><label for="checkbox_moderate_comments"><?php echo @COMMENTS_MODERATE; ?>
</label>
                    </td>
                    <td align="right" rowspan="2" valign="middle" width="30%">
                        <input accesskey="p" type="submit" value="- <?php echo @PREVIEW; ?>
 -" class="serendipityPrettyButton input_button"  style="width: 150px" onclick="document.forms['serendipityEntry'].elements['serendipity[preview]'].value='true';" /><br />
                        <input accesskey="s" type="submit" onclick="return checkSave();" value="- <?php echo @SAVE; ?>
 -" class="serendipityPrettyButton input_button" style="width: 150px" />
                    </td>
                </tr>
            </table>
            <br />
        </td>
    </tr>
    
        <tr>
        <td colspan="2">
            <?php if (! $this->_tpl_vars['entry_vars']['wysiwyg']): ?>
            <a style="border:0; text-decoration: none" href="#" onclick="toggle_extended(true); return false;" title="<?php echo @TOGGLE_OPTION; ?>
"><img src="<?php echo serendipity_smarty_getFile(array('file' => 'img/plus.png'), $this);?>
" id="option_extended" alt="+/-" border="0" /></a>
            <?php endif; ?>
            <b><?php echo @EXTENDED_BODY; ?>
</b>
        </td>

        <td align="right">
            <?php if (! $this->_tpl_vars['entry_vars']['wysiwyg']): ?>
            <div id="tools_extended" style="display: none">
                <?php if ($this->_tpl_vars['entry_vars']['wysiwyg_advanced']): ?>
                <input type="button" class="serendipityPrettyButton input_button" name="insI" value="I" accesskey="i" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'],'<em>','</em>')" />
                <input type="button" class="serendipityPrettyButton input_button" name="insB" value="B" accesskey="b" style="font-weight: bold" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'],'<strong>','</strong>')" />
                <input type="button" class="serendipityPrettyButton input_button" name="insU" value="U" accesskey="u" style="text-decoration: underline;" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'],'<u>','</u>')" />
                <input type="button" class="serendipityPrettyButton input_button" name="insQ" value="<?php echo @QUOTE; ?>
" accesskey="q" style="font-style: italic" onclick="wrapSelection(document.forms['serendipityEntry']['serendipity[extended]'],'<blockquote>','</blockquote>')" />
                <input type="button" class="serendipityPrettyButton input_button" name="insJ" value="img" accesskey="j" onclick="wrapInsImage(document.forms['serendipityEntry']['serendipity[extended]'])" />
                <input type="button" class="serendipityPrettyButton input_button" name="insImage" value="<?php echo @MEDIA; ?>
" onclick="window.open('serendipity_admin_image_selector.php?serendipity[textarea]=extended', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');" />
                <input type="button" class="serendipityPrettyButton input_button" name="insURL" value="URL" accesskey="l" onclick="wrapSelectionWithLink(document.forms['serendipityEntry']['serendipity[extended]'])" />
                <?php else: ?>
                <input type="button" class="serendipityPrettyButton input_button" value=" B " onclick="serendipity_insBasic(document.forms['serendipityEntry']['serendipity[extended]'], 'b')">
                <input type="button" class="serendipityPrettyButton input_button" value=" U " onclick="serendipity_insBasic(document.forms['serendipityEntry']['serendipity[extended]'], 'u')">
                <input type="button" class="serendipityPrettyButton input_button" value=" I " onclick="serendipity_insBasic(document.forms['serendipityEntry']['serendipity[extended]'], 'i')">
                <input type="button" class="serendipityPrettyButton input_button" value="<img>" onclick="serendipity_insImage(document.forms['serendipityEntry']['serendipity[extended]'])">
                <input type="button" class="serendipityPrettyButton input_button" value="<?php echo @MEDIA; ?>
" onclick="window.open('serendipity_admin_image_selector.php?serendipity[textarea]=extended', 'ImageSel', 'width=800,height=600,toolbar=no');">
                <input type="button" class="serendipityPrettyButton input_button" value="Link" onclick="serendipity_insLink(document.forms['serendipityEntry']['serendipity[extended]'])">
                <?php endif; ?>
                <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_entry_toolbar_extended','data' => $this->_tpl_vars['entry_data']['entry'],'hookAll' => 'true'), $this);?>

            </div>
            <?php else: ?>
                <?php echo serendipity_smarty_hookPlugin(array('hook' => 'backend_entry_toolbar_extended','data' => $this->_tpl_vars['entry_data']['entry'],'hookAll' => 'true'), $this);?>

            <?php endif; ?>
       </td>
    </tr>
    
        <tr>
        <td colspan="3">
            <textarea style="width: 100%;" name="serendipity[extended]" id="serendipity[extended]" cols="80" rows="20"><?php echo smarty_modifier_escape($this->_tpl_vars['entry_vars']['entry']['extended']); ?>
</textarea>
            <?php if (! $this->_tpl_vars['entry_vars']['wysiwyg']): ?>
            <script type="text/javascript" language="JavaScript">
               toggle_extended();
            </script>
            <?php endif; ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="3">
            <br />
            <fieldset>
                <legend><b><?php echo @ADVANCED_OPTIONS; ?>
</b></legend>
                    <?php echo serendipity_smarty_refhookPlugin($this->_tpl_vars['entry_vars']['entry'], 'backend_display'); ?>

                </fieldset>
        </td>
    </tr>
</table>
</form>

<?php if ($this->_tpl_vars['entry_vars']['show_wysiwyg']): ?>
<script type="text/javascript" language="JavaScript">
    toggle_extended();
</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['entry_vars']['wysiwyg']): ?>
    <?php $_from = $this->_tpl_vars['entry_vars']['wysiwyg_blocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['wysiwyg_block_jsname'] => $this->_tpl_vars['wysiwyg_block_item']):
?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['wysiwyg_block_item'])) ? $this->_run_mod_handler('emit_htmlarea_code', true, $_tmp, $this->_tpl_vars['wysiwyg_block_jsname']) : serendipity_emit_htmlarea_code($_tmp, $this->_tpl_vars['wysiwyg_block_jsname'])); ?>

    <?php endforeach; endif; unset($_from); ?>
    <?php echo serendipity_smarty_refhookPlugin($this->_tpl_vars['entry_vars']['wysiwyg_blocks'], 'backend_wysiwyg_finish'); ?>

<?php endif; ?>

<script type="text/javascript" language="JavaScript" src="serendipity_define.js.php"></script>
<script type="text/javascript" language="JavaScript" src="serendipity_editor.js"></script>
<!-- ADMIN-ENTRY TEMPLATE: entries.tpl END -->