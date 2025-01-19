<?php if ($this->_tpl_vars['Page']->getDetailedDescription()): ?>
    <div class="btn-group">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#detailedDescriptionModal-<?php echo $this->_tpl_vars['Page']->GetPageId(); ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PageDescription'); ?>
"><i class="icon-question"></i></button>
    </div>

    <div class="modal fade" id="detailedDescriptionModal-<?php echo $this->_tpl_vars['Page']->GetPageId(); ?>
" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->_tpl_vars['Page']->getDetailedDescription(); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>
</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>