<?php /* Smarty version 2.6.26, created on 2010-10-28 15:04:04
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/plugin_calendar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'serendipity_getFile', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/plugin_calendar.tpl', 5, false),array('modifier', 'formatTime', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/plugin_calendar.tpl', 10, false),array('modifier', 'default', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/default/plugin_calendar.tpl', 29, false),)), $this); ?>
<table style="width: 100%" cellspacing="0" cellpadding="0" class="serendipity_calendar">
    <tr>
        <td class="serendipity_calendarHeader">
<?php if ($this->_tpl_vars['plugin_calendar_head']['minScroll'] <= $this->_tpl_vars['plugin_calendar_head']['month_date']): ?>
            <a title="<?php echo @BACK; ?>
" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_previous']; ?>
"><img alt="<?php echo @BACK; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/back.png"), $this);?>
" width="16" height="12" style="border: 0px" /></a>
<?php endif; ?>
        </td>

        <td colspan="5" class="serendipity_calendarHeader" style="text-align: center; vertical-align: bottom">
            <b><a style="white-space: nowrap" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_month']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['plugin_calendar_head']['month_date'])) ? $this->_run_mod_handler('formatTime', true, $_tmp, "%B '%y", false) : serendipity_smarty_formatTime($_tmp, "%B '%y", false)); ?>
</a></b>
        </td>

        <td class="serendipity_calendarHeader" style="text-align: right">
<?php if ($this->_tpl_vars['plugin_calendar_head']['maxScroll'] >= $this->_tpl_vars['plugin_calendar_head']['month_date']): ?>
            <a title="<?php echo @FORWARD; ?>
" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_next']; ?>
"><img alt="<?php echo @FORWARD; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/forward.png"), $this);?>
" width="16" height="12" style="border: 0px" /></a>
<?php endif; ?>
        </td>
    </tr>

    <tr>
    <?php $_from = $this->_tpl_vars['plugin_calendar_dow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dow']):
?>
        <td scope="col" abbr="<?php echo serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%A", false); ?>
" title="<?php echo serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%A", false); ?>
" class="serendipity_weekDayName" align="center"><?php echo serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%a", false); ?>
</td>
    <?php endforeach; endif; unset($_from); ?>
    </tr>

    <?php $_from = $this->_tpl_vars['plugin_calendar_weeks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['week']):
?>
        <tr class="serendipity_calendar">
        <?php $_from = $this->_tpl_vars['week']['days']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['day']):
?>
            <td class="serendipity_calendarDay <?php echo $this->_tpl_vars['day']['classes']; ?>
"<?php if (isset ( $this->_tpl_vars['day']['properties']['Title'] )): ?> title="<?php echo $this->_tpl_vars['day']['properties']['Title']; ?>
"<?php endif; ?>><?php if (isset ( $this->_tpl_vars['day']['properties']['Active'] ) && $this->_tpl_vars['day']['properties']['Active']): ?><a href="<?php echo $this->_tpl_vars['day']['properties']['Link']; ?>
"><?php endif; ?><?php echo smarty_modifier_default(@$this->_tpl_vars['day']['name'], "&#160;"); ?>
<?php if (isset ( $this->_tpl_vars['day']['properties']['Active'] ) && $this->_tpl_vars['day']['properties']['Active']): ?></a><?php endif; ?></td>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>