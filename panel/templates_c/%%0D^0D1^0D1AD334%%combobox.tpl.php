<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'editors/combobox.tpl', 15, false),)), $this); ?>
<?php if (isset ( $this->_tpl_vars['ColumnViewData']['NestedInsertFormLink'] )): ?>
    <div class="input-group" style="width: 100%">
<?php endif; ?>

    <select
        class="form-control <?php if (isset ( $this->_tpl_vars['ColumnViewData']['NestedInsertFormLink'] )): ?>form-control-nested-form<?php endif; ?>"
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>>

        <?php if ($this->_tpl_vars['Editor']->hasEmptyChoice()): ?>
            <option value=""><?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
</option>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['Editor']->HasMFUChoices()): ?>
            <?php $_from = $this->_tpl_vars['Editor']->getMFUChoices(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['displayValue']):
?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['displayValue']; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
            <option value="----------" disabled="disabled">----------</option>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['Editor']->getChoices(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['displayValue']):
?>
            <?php if ($this->_tpl_vars['value'] !== ''): ?>
                <option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php if ($this->_tpl_vars['Editor']->getValue() == $this->_tpl_vars['value']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['displayValue']; ?>
</option>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </select>
    <?php if (isset ( $this->_tpl_vars['ColumnViewData']['NestedInsertFormLink'] ) && isset ( $this->_tpl_vars['ColumnViewData']['DisplayFieldName'] )): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'editors/nested_insert_button.tpl', 'smarty_include_vars' => array('NestedInsertFormLink' => $this->_tpl_vars['ColumnViewData']['NestedInsertFormLink'],'LookupDisplayFieldName' => $this->_tpl_vars['ColumnViewData']['DisplayFieldName'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

<?php if (isset ( $this->_tpl_vars['ColumnViewData']['NestedInsertFormLink'] )): ?>
    </div>
<?php endif; ?>