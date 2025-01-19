<div class="modal-dialog <?php echo $this->_tpl_vars['modalSizeClass']; ?>
">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $this->_tpl_vars['Grid']['Title']; ?>
</h4>
        </div>
        <div class="modal-body">

            <div class="<?php if ($this->_tpl_vars['Grid']['FormLayout']->isHorizontal()): ?> form-horizontal<?php endif; ?>">
                <div class="row">
                    <div class="col-md-12 js-message-container"></div>

                    <div class="col-md-12">
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_fields.tpl', 'smarty_include_vars' => array('isViewForm' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>
</button>
        </div>
    </div>
</div>