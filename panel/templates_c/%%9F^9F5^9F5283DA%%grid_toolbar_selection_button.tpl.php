<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'sprintf', 'list/grid_toolbar_selection_button.tpl', 6, false),)), $this); ?>
<?php if ($this->_tpl_vars['DataGrid']['AllowSelect']): ?>
    <div class="btn-group js-selection-actions-container fade" style="display: none">
        <div class="btn-group">
            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">
                                <?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('ItemsSelected'), '<span class="js-count">0</span>'); ?>

                            </span>
                <span class="js-count visible-xs-inline">0</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" class="js-action" data-type="clear"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Clear'); ?>
</a></li>
                <?php if ($this->_tpl_vars['DataGrid']['SelectionFilterAllowed']): ?>
                    <li class="divider"></li>
                    <li class="dropdown dropdown-sub-menu">
                        <a href="#"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SelectionFilter'); ?>
</a>
                        <ul class="dropdown-menu sub-menu">
                            <li><a href="#" class="js-action" data-type="select" data-condition="selected" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ShowSelectedOnly'); ?>
</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="js-action" data-type="select" data-condition="unselected" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ShowUnselectedOnly'); ?>
</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="js-action" data-type="select" data-condition="all" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ShowAll'); ?>
</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['DataGrid']['AllowCompare']): ?>
                    <li class="divider"></li>
                    <li><a href="#" class="js-action" data-type="compare" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CompareSelected'); ?>
</a></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['DataGrid']['AllowExportSelected']): ?>
                    <li class="divider"></li>
                    <li class="dropdown dropdown-sub-menu">
                        <a href="#"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Export'); ?>
</a>
                        <ul class="dropdown-menu sub-menu">
                            <?php $_from = $this->_tpl_vars['Page']->getExportSelectedRecordsViewData(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Item']):
?>
                                <li><a href="#"<?php echo $this->_tpl_vars['Item']['Target']; ?>
 class="js-action" data-type="export" data-export-type="<?php echo $this->_tpl_vars['Item']['Type']; ?>
" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Item']['Caption']; ?>
</a></li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['DataGrid']['AllowPrintSelected']): ?>
                    <li class="divider"></li>
                    <li><a href="#"<?php echo $this->_tpl_vars['DataGrid']['PrintLinkTarget']; ?>
 class="js-action" data-type="print" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('PrintSelected'); ?>
</a></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['DataGrid']['MultiEditAllowed']): ?>
                    <li class="divider"></li>
                    <li><a href="#" class="js-action" data-type="update" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
" <?php if ($this->_tpl_vars['DataGrid']['UseModalMultiEdit']): ?>data-modal-operation="multiple-edit" data-multiple-edit-handler-name="<?php echo $this->_tpl_vars['Page']->GetGridMultiEditHandler(); ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['Captions']->GetMessageString('Update'); ?>
</a></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['DataGrid']['AllowDeleteSelected']): ?>
                    <li class="divider"></li>
                    <li><a href="#" class="js-action" data-type="delete" data-url="<?php echo $this->_tpl_vars['Page']->getLink(); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('DeleteSelected'); ?>
</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>