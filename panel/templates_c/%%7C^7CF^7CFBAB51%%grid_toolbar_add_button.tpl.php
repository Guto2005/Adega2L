<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escapeurl', 'list/grid_toolbar_add_button.tpl', 5, false),array('modifier', 'sprintf', 'list/grid_toolbar_add_button.tpl', 37, false),)), $this); ?>
<?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton']): ?>
    <div class="btn-group">
        <?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'modal' || $this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'inline'): ?>
            <button class="btn btn-default pgui-add"
                    data-content-link="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['ModalInsertDialog'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"
                    data-<?php echo $this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton']; ?>
-insert="true"
                    title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
">
                <i class="icon-plus"></i>
                <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
</span>
            </button>
        <?php else: ?>
            <a class="btn btn-default pgui-add" href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['SimpleAddNewRow'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"
               title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
">
                <i class="icon-plus"></i>
                <span class="visible-lg-inline"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AddNewRecord'); ?>
</span>
            </a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['DataGrid']['AddNewChoices']): ?>
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <?php $_from = $this->_tpl_vars['DataGrid']['AddNewChoices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['choice']):
?>
                    <li>
                        <?php if ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'modal'): ?>
                            <a href="#"
                               data-modal-insert="true"
                               data-content-link="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['ModalInsertDialog'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
&count=<?php echo $this->_tpl_vars['choice']; ?>
">
                        <?php elseif ($this->_tpl_vars['DataGrid']['ActionsPanel']['AddNewButton'] == 'inline'): ?>
                            <a href="#"
                               data-inline-insert="true"
                               data-content-link="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['ModalInsertDialog'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
"
                               data-count="<?php echo $this->_tpl_vars['choice']; ?>
">
                        <?php else: ?>
                            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['DataGrid']['Links']['SimpleAddNewRow'])) ? $this->_run_mod_handler('escapeurl', true, $_tmp) : smarty_modifier_escapeurl($_tmp)); ?>
&count=<?php echo $this->_tpl_vars['choice']; ?>
">
                        <?php endif; ?>
                                <?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('AddMultipleRecords'), $this->_tpl_vars['choice']); ?>

                            </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>