<?php /* Smarty version 2.6.26, created on 2010-10-28 14:45:07
         compiled from file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/plugin_calendar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'formatTime', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/plugin_calendar.tpl', 1, false),array('modifier', 'truncate', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/plugin_calendar.tpl', 35, false),array('modifier', 'default', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/plugin_calendar.tpl', 47, false),array('function', 'serendipity_getFile', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/plugin_calendar.tpl', 7, false),array('function', 'cycle', 'file:/home/sebastian-engel.de/hosts/twoseb.de/sites/s9y/templates/bulletproof/plugin_calendar.tpl', 44, false),)), $this); ?>
<table cellspacing="0" cellpadding="0" summary="this table is a calendar for the month of <?php echo serendipity_smarty_formatTime(time(), "%B, %Y"); ?>
" class="serendipity_calendar">
    <thead>
      <tr>
        <th id="back" scope="col" colspan="1" class="serendipity_calendarHeader" style="text-align: right">
        <?php if ($this->_tpl_vars['plugin_calendar_head']['minScroll'] <= $this->_tpl_vars['plugin_calendar_head']['month_date']): ?>
           <?php if ($this->_tpl_vars['template_option']['colorset'] == 'blank'): ?>
           <a title="<?php echo @BACK; ?>
" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_previous']; ?>
"><img alt="<?php echo @BACK; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/back.png"), $this);?>
" width="12" height="12" /></a>
           <?php else: ?>
           <a title="<?php echo @BACK; ?>
" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_previous']; ?>
"><img alt="<?php echo @BACK; ?>
" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_back.png" /></a>
           <?php endif; ?>
        <?php else: ?>
           <img alt="" src="<?php echo serendipity_smarty_getFile(array('file' => "img/blank.png"), $this);?>
" width="6" height="6" class="serendipity_calender_spacer" />
        <?php endif; ?>
        </th>

        <th id="month" scope="col" colspan="5" class="serendipity_calendarHeader" style="text-align: center">
            <b><a style="white-space: nowrap" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_month']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['plugin_calendar_head']['month_date'])) ? $this->_run_mod_handler('formatTime', true, $_tmp, "%B '%y", false) : serendipity_smarty_formatTime($_tmp, "%B '%y", false)); ?>
</a></b>
        </th>

        <th id="forward" scope="col" colspan="1" class="serendipity_calendarHeader" style="text-align: left">
        <?php if ($this->_tpl_vars['plugin_calendar_head']['maxScroll'] >= $this->_tpl_vars['plugin_calendar_head']['month_date']): ?>
            <?php if ($this->_tpl_vars['template_option']['colorset'] == 'blank'): ?>
            <a title="<?php echo @FORWARD; ?>
" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_next']; ?>
"><img alt="<?php echo @FORWARD; ?>
" src="<?php echo serendipity_smarty_getFile(array('file' => "img/forward.png"), $this);?>
" width="12" height="12" /></a>
            <?php else: ?>
            <a title="<?php echo @FORWARD; ?>
" href="<?php echo $this->_tpl_vars['plugin_calendar_head']['uri_next']; ?>
"><img alt="<?php echo @FORWARD; ?>
" src="<?php echo $this->_tpl_vars['serendipityHTTPPath']; ?>
templates/<?php echo $this->_tpl_vars['template']; ?>
/img/<?php echo $this->_tpl_vars['template_option']['colorset']; ?>
_forward.png" /></a>
            <?php endif; ?>
        <?php else: ?>
            <img alt="" src="<?php echo serendipity_smarty_getFile(array('file' => "img/blank.png"), $this);?>
" width="6" height="6" class="serendipity_calender_spacer" />
        <?php endif; ?>
        </th>
    </tr>

    <tr>
    <?php $_from = $this->_tpl_vars['plugin_calendar_dow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dow']):
?>
        <th id="<?php echo smarty_modifier_truncate(serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%a", false), 3, '', true); ?>
" scope="col" abbr="<?php echo serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%A", false); ?>
" title="<?php echo serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%A", false); ?>
" class="serendipity_weekDayName" align="center"><?php echo smarty_modifier_truncate(serendipity_smarty_formatTime($this->_tpl_vars['dow']['date'], "%a", false), 2, '', true); ?>
</th>
    <?php endforeach; endif; unset($_from); ?>
    </tr>
</thead>
<tfoot class="serendipity_calendarHeader">
<tr><td id="today" scope="col" colspan="7"><?php echo serendipity_smarty_formatTime(time(), $this->_tpl_vars['template_option']['date_format']); ?>
</td></tr>
</tfoot>
<tbody>
    <?php $_from = $this->_tpl_vars['plugin_calendar_weeks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['week']):
?>
        <tr class="serendipity_calendar <?php echo smarty_function_cycle(array('values' => "row1, row2, row3, row4, row5, row6"), $this);?>
">
        <?php $_from = $this->_tpl_vars['week']['days']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['day']):
?>
            <td class="serendipity_calendarDay <?php echo $this->_tpl_vars['day']['classes']; ?>
"<?php if (isset ( $this->_tpl_vars['day']['properties']['Title'] )): ?> title="<?php echo $this->_tpl_vars['day']['properties']['Title']; ?>
"<?php endif; ?>><?php if (isset ( $this->_tpl_vars['day']['properties']['Active'] ) && $this->_tpl_vars['day']['properties']['Active']): ?>
                <a href="<?php echo $this->_tpl_vars['day']['properties']['Link']; ?>
"><?php endif; ?><?php echo smarty_modifier_default(@$this->_tpl_vars['day']['name'], "&#160;"); ?>
<?php if (isset ( $this->_tpl_vars['day']['properties']['Active'] ) && $this->_tpl_vars['day']['properties']['Active']): ?></a><?php endif; ?></td>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</tbody>
</table>
