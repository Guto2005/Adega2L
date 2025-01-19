<?php if ($this->_tpl_vars['DataGrid']['EnableSortDialog']): ?>
    <div class="btn-group">
        <button id="multi-sort-<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
" class="btn btn-default" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('Sort'); ?>
" data-toggle="modal" data-target="#multiple-sorting-<?php echo $this->_tpl_vars['DataGrid']['Id']; ?>
">
            <i class="icon-sort"></i>
        </button>
    </div>
<?php endif; ?>
