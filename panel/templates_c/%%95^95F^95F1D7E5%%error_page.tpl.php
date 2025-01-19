<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'sprintf', 'list/error_page.tpl', 4, false),)), $this); ?>
<?php $this->assign('ErrorTitle', $this->_tpl_vars['Captions']->GetMessageString('ErrorsDuringDataRetrieving')); ?>
<?php ob_start(); ?>
<p><?php echo $this->_tpl_vars['ErrorMessage']; ?>
</p>
<p><?php echo sprintf($this->_tpl_vars['Captions']->GetMessageString('ReloadPageWithDefaults'), $this->_tpl_vars['ReloadWithDefaultsUrl']); ?>
</p>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ErrorContent', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/error.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>