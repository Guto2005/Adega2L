<?php if ($this->_tpl_vars['DataGrid']['ColumnFilter']->hasColumns()): ?>
    <ul class="nav nav-pills pull-right js-column-filter-container grid-card-column-filter">
        <?php $_from = $this->_tpl_vars['DataGrid']['ColumnFilter']->getColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Column']):
?>
            <li data-name="<?php echo $this->_tpl_vars['Column']->getFieldName(); ?>
"<?php if ($this->_tpl_vars['DataGrid']['ColumnFilter']->isColumnActive($this->_tpl_vars['Column']->getFieldName())): ?> class="active"<?php endif; ?>>
                <a href="#" class="js-filter-trigger" title="<?php echo $this->_tpl_vars['DataGrid']['ColumnFilter']->toStringFor($this->_tpl_vars['Column']->getFieldName(),$this->_tpl_vars['Captions']); ?>
">
                    <i class="icon-filter"></i>&nbsp;
                    <?php echo $this->_tpl_vars['Column']->getCaption(); ?>

                </a>
            </li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
<?php endif; ?>

<div class="clearfix"></div>