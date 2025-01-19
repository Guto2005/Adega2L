<div class="row">
    <?php if ($this->_tpl_vars['Grid']['FormLayout']->tabsEnabled()): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_tabs.tpl', 'smarty_include_vars' => array('NavStyle' => $this->_tpl_vars['Grid']['FormLayout']->getTabbedNavigationStyle(),'TabType' => $this->_tpl_vars['Grid']['FormLayout']->getTabType())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php else: ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_sheet_layout.tpl', 'smarty_include_vars' => array('FormSheet' => $this->_tpl_vars['Grid']['FormLayout'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
</div>