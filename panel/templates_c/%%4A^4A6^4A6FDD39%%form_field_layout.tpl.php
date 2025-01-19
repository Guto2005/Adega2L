<?php ob_start(); ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/field_label.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('FormControlLabel', ob_get_contents());ob_end_clean(); ?>

<?php if ($this->_tpl_vars['isHorizontalMode']): ?>
    <div class="form-group form-group-label col-sm-<?php echo $this->_tpl_vars['Col']->getLabelWidth(); ?>
"<?php echo $this->_tpl_vars['FormControlStyles']; ?>
>
        <?php echo $this->_tpl_vars['FormControlLabel']; ?>

    </div>
    <div class="form-group col-sm-<?php echo $this->_tpl_vars['Col']->getInputWidth(); ?>
"<?php echo $this->_tpl_vars['FormControlStyles']; ?>
>
        <?php echo $this->_tpl_vars['FormControl']; ?>

    </div>
<?php else: ?>
    <div class="form-group col-sm-<?php echo $this->_tpl_vars['Col']->getWidth(); ?>
"<?php echo $this->_tpl_vars['FormControlStyles']; ?>
>
        <?php echo $this->_tpl_vars['FormControlLabel']; ?>

        <?php echo $this->_tpl_vars['FormControl']; ?>

    </div>
<?php endif; ?>