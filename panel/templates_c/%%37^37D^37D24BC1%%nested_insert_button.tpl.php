<?php if (isset ( $this->_tpl_vars['NestedInsertFormLink'] ) && ! isset ( $this->_tpl_vars['isSingleFieldForm'] )): ?>
    <div class="btn-group input-group-btn">
        <button
            type="button"
            class="btn btn-default js-nested-insert"
            data-content-link="<?php echo $this->_tpl_vars['NestedInsertFormLink']; ?>
"
            <?php if (isset ( $this->_tpl_vars['LookupDisplayFieldName'] )): ?>
                data-display-field-name="<?php echo $this->_tpl_vars['LookupDisplayFieldName']; ?>
"
	    <?php endif; ?>
            <?php if (isset ( $this->_tpl_vars['StoredFieldName'] )): ?>
                data-stored-field-name="<?php echo $this->_tpl_vars['StoredFieldName']; ?>
"
	    <?php endif; ?>
            title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('InsertRecord'); ?>
">
            <span class="icon-plus"></span>
        </button>
    </div>
<?php endif; ?>