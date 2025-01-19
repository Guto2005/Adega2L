<label class="control-label"<?php if (! $this->_tpl_vars['isViewForm']): ?> for="<?php echo $this->_tpl_vars['EditorId']; ?>
"<?php endif; ?> data-column="<?php echo $this->_tpl_vars['ColumnViewData']['FieldName']; ?>
">
    <?php if (! $this->_tpl_vars['isViewForm'] && $this->_tpl_vars['ColumnViewData']['EditorHint']): ?>
        <span class="commented js-hint" data-hint="<?php echo $this->_tpl_vars['ColumnViewData']['EditorHint']; ?>
"><?php echo $this->_tpl_vars['Col']->getCaption(); ?>
</span>
    <?php else: ?>
        <?php echo $this->_tpl_vars['Col']->getCaption(); ?>

    <?php endif; ?>

    <?php if (! $this->_tpl_vars['isViewForm']): ?>
        <span class="required-mark"<?php if (! $this->_tpl_vars['ColumnViewData']['Required']): ?> style="display: none"<?php endif; ?>>*</span>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "edit_field_options.tpl", 'smarty_include_vars' => array('Column' => $this->_tpl_vars['ColumnViewData'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
</label>