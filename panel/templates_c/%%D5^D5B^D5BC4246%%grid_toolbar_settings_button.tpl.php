	<?php if (isset ( $this->_tpl_vars['PageNavigator'] ) || $this->_tpl_vars['DataGrid']['EnableRunTimeCustomization']): ?>
    <div class="btn-group">
        <button class="btn btn-default" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PageSettings'); ?>
" data-toggle="modal" data-target="#page-settings">
            <i class="icon-settings"></i>
        </button>
    </div>
<?php endif; ?>
