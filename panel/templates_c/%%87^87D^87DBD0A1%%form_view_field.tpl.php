<?php $this->assign('ColumnName', $this->_tpl_vars['Col']->getName()); ?>
<?php if (isset ( $this->_tpl_vars['Grid']['CellEditUrls'][$this->_tpl_vars['ColumnName']] )): ?>
    <?php $this->assign('CellEditUrl', $this->_tpl_vars['Grid']['CellEditUrls'][$this->_tpl_vars['ColumnName']]); ?>
<?php endif; ?>

<?php ob_start(); ?>
    <div class="form-control-static<?php if (isset ( $this->_tpl_vars['CellEditUrl'] )): ?> pgui-cell-edit<?php endif; ?>"<?php if (isset ( $this->_tpl_vars['CellEditUrl'] )): ?> data-column-name="<?php echo $this->_tpl_vars['ColumnName']; ?>
" data-edit-url="<?php echo $this->_tpl_vars['CellEditUrl']; ?>
"<?php endif; ?>>
        <?php echo $this->_tpl_vars['Col']->getDisplayValue($this->_tpl_vars['Renderer']); ?>

    </div>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ViewControl', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_field_layout.tpl', 'smarty_include_vars' => array('FormControl' => $this->_tpl_vars['ViewControl'],'FormControlStyles' => '')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>