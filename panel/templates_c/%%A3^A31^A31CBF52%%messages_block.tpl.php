<?php if (isset ( $this->_tpl_vars['GridMessages']['MessageDisplayTime'] )): ?>
    <?php $this->assign('displayTime', $this->_tpl_vars['GridMessages']['MessageDisplayTime']); ?>
<?php else: ?>
    <?php $this->assign('displayTime', null); ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'danger','messages' => $this->_tpl_vars['GridMessages']['ErrorMessages'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'success','messages' => $this->_tpl_vars['GridMessages']['Messages'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
