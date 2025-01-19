<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/grid_toolbar_refresh_button.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['RefreshButton'] && ! $this->_tpl_vars['isInline']): ?>
    <div class="btn-group">
        <a class="btn btn-default" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['Refresh'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Refresh'); ?>
">
            <i class="icon-page-refresh"></i>
            <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Refresh'); ?>
</span>
        </a>
    </div>
<?php endif; ?>
