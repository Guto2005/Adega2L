<?php if ($this->_tpl_vars['DataGrid']['FilterBuilder']->hasColumns()): ?>
    <div class="btn-group">
        <button type="button" class="btn btn-default js-filter-builder-open" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('EditFilter'); ?>
">
            <i class="icon-filter-alt"></i>
        </button>
    </div>
<?php endif; ?>
