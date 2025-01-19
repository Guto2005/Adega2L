<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'forms/modal_form.tpl', 62, false),)), $this); ?>
<div class="modal-dialog <?php echo $this->_tpl_vars['modalSizeClass']; ?>
">
    <div class="modal-content js-form-container">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $this->_tpl_vars['Grid']['Title']; ?>
</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 js-form-collection">
                    <?php $_from = $this->_tpl_vars['Forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['forms'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['forms']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Form']):
        $this->_foreach['forms']['iteration']++;
?>
                        <?php echo $this->_tpl_vars['Form']; ?>

                        <?php if (! ($this->_foreach['forms']['iteration'] == $this->_foreach['forms']['total'])): ?><hr><?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>

            <?php if ($this->_tpl_vars['Grid']['AllowAddMultipleRecords']): ?>
                <div class="row form-add-another-record">
                    <a href="#" class="js-form-add col-md-12<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?> col-md-offset-3<?php endif; ?>">
                        <span class="icon-plus"></span> <?php echo $this->_tpl_vars['Captions']->GetMessageString('FormAdd'); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <div class="btn-toolbar pull-right">

                <div class="btn-group">
                    <button class="btn btn-default" data-dismiss="modal" aria-label="Close">
                        <?php echo $this->_tpl_vars['Captions']->GetMessageString('Cancel'); ?>

                    </button>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary js-save js-primary-save">
                        <?php if ($this->_tpl_vars['isMultiEditOperation']): ?>
                        <?php echo $this->_tpl_vars['Captions']->GetMessageString('Update'); ?>

                        <?php else: ?>
                        <?php echo $this->_tpl_vars['Captions']->GetMessageString('Save'); ?>

                        <?php endif; ?>
                    </button>
                    <?php if (! $this->_tpl_vars['isNested'] && ! $this->_tpl_vars['isMultiEditOperation']): ?>
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="js-save"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveAndBackToList'); ?>
</a></li>
                            <?php if ($this->_tpl_vars['EditOperationIsEnabled']): ?>
                                <li><a href="#" class="js-save js-multiple-insert-hide" data-action="edit"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveAndEdit'); ?>
</a></li>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['InsertOperationIsEnabled']): ?>
                                <li><a href="#" class="js-save js-save-insert" data-action="insert"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveAndInsert'); ?>
</a></li>
                            <?php endif; ?>

                            <?php if ($this->_tpl_vars['Grid']['Details'] && count ( $this->_tpl_vars['Grid']['Details'] ) > 0): ?>
                                <li class="divider js-multiple-insert-hide"></li>
                            <?php endif; ?>

                            <?php $_from = $this->_tpl_vars['Grid']['Details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Details'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Details']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Detail']):
        $this->_foreach['Details']['iteration']++;
?>
                                <li><a class="js-save js-multiple-insert-hide" href="#" data-action="details" data-index="<?php echo ($this->_foreach['Details']['iteration']-1); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['Detail']['Caption'])) ? $this->_run_mod_handler('string_format', true, $_tmp, $this->_tpl_vars['Captions']->GetMessageString('SaveAndOpenDetail')) : smarty_modifier_string_format($_tmp, $this->_tpl_vars['Captions']->GetMessageString('SaveAndOpenDetail'))); ?>
</a></li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_scripts.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
</div>