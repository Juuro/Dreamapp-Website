<?php /* Smarty version 2.6.26, created on 2010-10-28 15:05:05
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/commentform.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_hookPlugin', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/imprezz/commentform.tpl', 19, false),)), $this); ?>
<div id="serendipityCommentFormC" class="add_comment">
    <h3 id="respond"><?php echo @ADD_COMMENT; ?>
</h3>
    <div id="serendipity_replyform_0"></div>
    <a id="serendipity_CommentForm"></a>
    <form id="commentform" action="<?php echo $this->_tpl_vars['commentform_action']; ?>
#feedback" method="post">
        <div id="hidden_fields">
            <input type="hidden" name="serendipity[entry_id]" value="<?php echo $this->_tpl_vars['commentform_id']; ?>
" />
            <input type="hidden" name="serendipity[replyTo]" value="0" />
        </div>

        <div class="text_fields">
            <p><label for="author"><small><?php echo @NAME; ?>
</small></label><input type="text" id="author" name="serendipity[name]" value="<?php echo $this->_tpl_vars['commentform_name']; ?>
" size="22" tabindex="1" /></p>
            <p><label for="email"><small><?php echo @EMAIL; ?>
</small></label><input type="text" id="email" name="serendipity[email]" value="<?php echo $this->_tpl_vars['commentform_email']; ?>
" size="22" tabindex="2" /></p>
            <p><label for="url"><small><?php echo @HOMEPAGE; ?>
</small></label><input type="text" id="url" name="serendipity[url]" value="<?php echo $this->_tpl_vars['commentform_url']; ?>
" size="22" tabindex="3" /></p>
        </div>

        <p class="text_area"><textarea rows="10" cols="100%" tabindex="4" id="comment" name="serendipity[comment]"><?php echo $this->_tpl_vars['commentform_data']; ?>
</textarea></p>

        <?php echo serendipity_smarty_hookPlugin(array('hook' => 'frontend_comment','data' => $this->_tpl_vars['commentform_entry']), $this);?>

    <?php if ($this->_tpl_vars['is_commentform_showToolbar']): ?>
        <p class="check_fields"><input id="checkbox_remember" type="checkbox" name="serendipity[remember]" <?php echo $this->_tpl_vars['commentform_remember']; ?>
 /><label for="checkbox_remember"><?php echo @REMEMBER_INFO; ?>
</label></p>
      <?php if ($this->_tpl_vars['is_allowSubscriptions']): ?>
        <p class="check_fields"><input id="checkbox_subscribe" type="checkbox" name="serendipity[subscribe]" <?php echo $this->_tpl_vars['commentform_subscribe']; ?>
 /><label for="checkbox_subscribe"><?php echo @SUBSCRIBE_TO_THIS_ENTRY; ?>
</label></p>
      <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['is_moderate_comments']): ?>
        <p class="serendipity_msg_important"><?php echo @COMMENTS_WILL_BE_MODERATED; ?>
</p>
    <?php endif; ?>

        <p class="submit_btn"><input id="submit" type="submit" name="serendipity[submit]" value="<?php echo @SUBMIT_COMMENT; ?>
" /></p>
        <p class="submit_btn"><input type="submit" id="preview" name="serendipity[preview]" value="<?php echo @PREVIEW; ?>
" /></p>
    </form>
</div>