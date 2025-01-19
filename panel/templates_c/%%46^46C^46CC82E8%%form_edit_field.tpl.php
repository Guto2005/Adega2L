<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'forms/form_edit_field.tpl', 2, false),)), $this); ?>
<?php $this->assign('Editor', $this->_tpl_vars['ColumnViewData']['EditorViewData']['Editor']); ?>
<?php $this->assign('EditorId', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['Grid']['FormId'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['Editor']->getName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['Editor']->getName()))); ?>
<?php if ($this->_tpl_vars['Editor']->getVisible()): ?>
    <?php $this->assign('EditorControlStyles', ''); ?>
<?php else: ?>
    <?php $this->assign('EditorControlStyles', ' style="display: none"'); ?>
<?php endif; ?>

<?php ob_start(); ?>
    <div class="col-input" style="width:100%;max-width:<?php echo $this->_tpl_vars['Editor']->getMaxWidth(); ?>
" data-column="<?php echo $this->_tpl_vars['ColumnViewData']['FieldName']; ?>
">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp='editors/')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['Editor']->getEditorName()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['Editor']->getEditorName())))) ? $this->_run_mod_handler('cat', true, $_tmp, '.tpl') : smarty_modifier_cat($_tmp, '.tpl')), 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'],'ViewData' => $this->_tpl_vars['ColumnViewData']['EditorViewData'],'FormId' => $this->_tpl_vars['Grid']['FormId'],'id' => $this->_tpl_vars['EditorId'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('EditControl', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_field_layout.tpl', 'smarty_include_vars' => array('FormControl' => $this->_tpl_vars['EditControl'],'FormControlStyles' => $this->_tpl_vars['EditorControlStyles'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>