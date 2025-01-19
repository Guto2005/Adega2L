<div class="input-group" style="width: 100%;max-width:100%">

<?php $this->assign('NestedInsertFormLink', $this->_tpl_vars['Editor']->getNestedInsertFormLink()); ?>
<input
    type="hidden"
    class="form-control<?php if ($this->_tpl_vars['NestedInsertFormLink']): ?> form-control-nested-form<?php endif; ?>"
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    data-max-selection-size="<?php echo $this->_tpl_vars['Editor']->getMaxSelectionSize(); ?>
"
    data-placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
"
    data-url="<?php echo $this->_tpl_vars['Editor']->GetDataUrl(); ?>
"
    value="<?php echo $this->_tpl_vars['Editor']->GetValue(); ?>
"
>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'editors/nested_insert_button.tpl', 'smarty_include_vars' => array('StoredFieldName' => $this->_tpl_vars['Editor']->getStoredFieldName())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</div>