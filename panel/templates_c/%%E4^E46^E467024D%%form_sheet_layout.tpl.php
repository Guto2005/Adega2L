<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'style_block', 'forms/form_sheet_layout.tpl', 5, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['FormSheet']->getGroups(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Group']):
?>
    <?php if ($this->_tpl_vars['Group']->getVisible() && count ( $this->_tpl_vars['Group']->getRows() ) > 0): ?>
        <?php $this->assign('customAttributes', $this->_tpl_vars['Group']->getCustomAttributes()); ?>
        <?php $this->assign('inlineStyles', $this->_tpl_vars['Group']->getInlineStyles()); ?>
        <fieldset class="col-md-<?php echo $this->_tpl_vars['Group']->getWidth(); ?>
<?php if ($this->_tpl_vars['isViewForm']): ?> form-static<?php endif; ?><?php if ($this->_tpl_vars['Group']->isHorizontal()): ?> form-horizontal<?php endif; ?>"<?php if ($this->_tpl_vars['customAttributes']): ?> <?php echo $this->_tpl_vars['customAttributes']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['inlineStyles']): ?> <?php $this->_tag_stack[] = array('style_block', array()); $_block_repeat=true;smarty_block_style_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['inlineStyles']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_style_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?><?php endif; ?>>
            <?php if ($this->_tpl_vars['Group']->getName()): ?>
                <legend>
                    <?php echo $this->_tpl_vars['Group']->getName(); ?>

                </legend>
            <?php endif; ?>
            <?php $_from = $this->_tpl_vars['Group']->getRows(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Row']):
?>
                <div class="row">
                    <?php $_from = $this->_tpl_vars['Row']->getCols(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Col']):
?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_field.tpl', 'smarty_include_vars' => array('isHorizontalMode' => $this->_tpl_vars['Group']->isHorizontal())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            <?php endforeach; endif; unset($_from); ?>
        </fieldset>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>