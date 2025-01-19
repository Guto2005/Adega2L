<?php if (( $this->_tpl_vars['DataGrid']['FilterBuilder']->hasColumns() || $this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumns() || $this->_tpl_vars['DataGrid']['QuickFilter']->hasColumns() || isset ( $this->_tpl_vars['FilterStatus'] ) )): ?>
    <div class="filter-status js-filter-status">
        <?php if (isset ( $this->_tpl_vars['FilterStatus'] )): ?><?php echo $this->_tpl_vars['FilterStatus']; ?>
<?php endif; ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/selection_filter_status.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/filter_status_value.tpl', 'smarty_include_vars' => array('filter' => $this->_tpl_vars['DataGrid']['FilterBuilder'],'id' => 'filterBuilder','typeClass' => 'filter-builder','isEditable' => true,'isToggable' => true,'icon' => 'filter-alt','ignoreDisabled' => false,'stringRepresentation' => $this->_tpl_vars['DataGrid']['FilterBuilder']->toString($this->_tpl_vars['Captions'],'<span class="filter-status-value-disabled-component">%s</span>'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/filter_status_value.tpl', 'smarty_include_vars' => array('filter' => $this->_tpl_vars['DataGrid']['ColumnFilter'],'id' => 'columnFilter','typeClass' => 'column-filter','isEditable' => false,'isToggable' => true,'icon' => 'filter','ignoreDisabled' => true,'stringRepresentation' => $this->_tpl_vars['DataGrid']['ColumnFilter']->toString($this->_tpl_vars['Captions']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<?php endif; ?>
