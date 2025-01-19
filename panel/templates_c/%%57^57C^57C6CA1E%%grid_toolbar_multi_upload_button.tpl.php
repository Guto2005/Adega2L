<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/grid_toolbar_multi_upload_button.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['DataGrid']['AllowMultiUpload']): ?>
    <div class="btn-group">
        <a class="btn btn-default pgui-multi-upload" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['MultiUpload'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('UploadFiles'); ?>
">
            <i class="icon-upload"></i>
            <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('UploadFiles'); ?>
</span>
        </a>
    </div>
<?php endif; ?>
