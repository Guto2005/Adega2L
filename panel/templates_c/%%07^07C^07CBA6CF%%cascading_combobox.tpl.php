<table <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> class="pgui-cascading-editor">
    <tbody>
    <?php $_from = $this->_tpl_vars['Editor']->getLevels(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Editors'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Editors']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['LevelEditor']):
        $this->_foreach['Editors']['iteration']++;
?>
    <tr>
        <td><span><?php echo $this->_tpl_vars['LevelEditor']->getCaption(); ?>
</span></td>
        <td>
            <?php if ($this->_tpl_vars['LevelEditor']->getNestedInsertFormLink()): ?>
            <div class="input-group" style="width: 100%">
            <?php endif; ?>
                <select
                    class="form-control <?php if ($this->_tpl_vars['LevelEditor']->getNestedInsertFormLink()): ?>form-control-nested-form<?php endif; ?>"
                    data-id="<?php echo $this->_tpl_vars['FormId']; ?>
_<?php echo $this->_tpl_vars['LevelEditor']->GetName(); ?>
"
                    name="<?php echo $this->_tpl_vars['LevelEditor']->getName(); ?>
"
                    <?php if ($this->_tpl_vars['LevelEditor']->getParentLevelName()): ?>
                        data-parent-level="<?php echo $this->_tpl_vars['FormId']; ?>
_<?php echo $this->_tpl_vars['LevelEditor']->getParentLevelName(); ?>
"
                        data-parent-link-field-name="<?php echo $this->_tpl_vars['LevelEditor']->getParentLinkFieldName(); ?>
"
                    <?php endif; ?>
                    data-url="<?php echo $this->_tpl_vars['LevelEditor']->getDataURL(); ?>
"
                    <?php if (($this->_foreach['Editors']['iteration'] == $this->_foreach['Editors']['total'])): ?>
                    data-editor-main="true"
                    <?php echo $this->_tpl_vars['ViewData']['Validators']['InputAttributes']; ?>

                    <?php endif; ?>
                    value="<?php echo $this->_tpl_vars['LevelEditor']->getValue(); ?>
">
                    <option value=""><?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
</option>
                    <?php $_from = $this->_tpl_vars['LevelEditor']->getValues(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['displayValue']):
?>
                        <?php if ($this->_tpl_vars['value'] !== ''): ?>
                            <option value="<?php echo $this->_tpl_vars['value']; ?>
"<?php if ($this->_tpl_vars['LevelEditor']->getValue() == $this->_tpl_vars['value']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['displayValue']; ?>
</option>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'editors/nested_insert_button.tpl', 'smarty_include_vars' => array('NestedInsertFormLink' => $this->_tpl_vars['LevelEditor']->getNestedInsertFormLink(),'LookupDisplayFieldName' => $this->_tpl_vars['LevelEditor']->GetCaptionFieldName())));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php if ($this->_tpl_vars['LevelEditor']->getNestedInsertFormLink()): ?>
            </div>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>