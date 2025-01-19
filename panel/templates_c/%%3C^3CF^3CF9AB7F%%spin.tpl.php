<input
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    type="number"
    class="form-control"
    value="<?php echo $this->_tpl_vars['Editor']->GetValue(); ?>
"
    <?php if ($this->_tpl_vars['Editor']->GetUseConstraints()): ?>
        min="<?php echo $this->_tpl_vars['Editor']->GetMinValue(); ?>
"
        max="<?php echo $this->_tpl_vars['Editor']->GetMaxValue(); ?>
"
    <?php endif; ?>
    <?php if ($this->_tpl_vars['Editor']->GetStep() != 1): ?>
        step="<?php echo $this->_tpl_vars['Editor']->GetStep(); ?>
"
    <?php endif; ?>
>