<?php if (! $this->_tpl_vars['isMultiUploadOperation']): ?>
    <div class="row">
        <div class="<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?>col-sm-9 col-sm-offset-3<?php else: ?>col-md-12<?php endif; ?>">
            <span class="required-mark">*</span> - <?php echo $this->_tpl_vars['Captions']->GetMessageString('RequiredField'); ?>

        </div>
    </div>

    <?php if ($this->_tpl_vars['isMultiEditOperation']): ?>
        <?php $_from = $this->_tpl_vars['HiddenValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValueName'] => $this->_tpl_vars['HiddenArray']):
?>
            <?php $_from = $this->_tpl_vars['HiddenArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValue']):
?>
                <input type="hidden" name="<?php echo $this->_tpl_vars['HiddenValueName']; ?>
[]" value="<?php echo $this->_tpl_vars['HiddenValue']; ?>
" />
            <?php endforeach; endif; unset($_from); ?>
        <?php endforeach; endif; unset($_from); ?>
    <?php else: ?>
        <?php $_from = $this->_tpl_vars['HiddenValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HiddenValueName'] => $this->_tpl_vars['HiddenValue']):
?>
            <input type="hidden" name="<?php echo $this->_tpl_vars['HiddenValueName']; ?>
" value="<?php echo $this->_tpl_vars['HiddenValue']; ?>
" />
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
<?php endif; ?>