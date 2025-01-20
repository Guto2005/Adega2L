<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', 'common/user_menu.tpl', 25, false),)), $this); ?>
<ul id="nav-menu" class="nav navbar-nav navbar-right">
    <?php if ($this->_tpl_vars['Authentication']['LoggedIn']): ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-user"></i>
                <?php if ($this->_tpl_vars['Authentication']['CurrentUser']['Name'] == 'guest'): ?>
                    <?php echo $this->_tpl_vars['Captions']->GetMessageString('Guest'); ?>

                <?php else: ?>
                    <?php echo $this->_tpl_vars['Authentication']['CurrentUser']['Name']; ?>

                <?php endif; ?>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <?php if ($this->_tpl_vars['Authentication']['isAdminPanelVisible']): ?>
                    <li><a href="phpgen_admin.php" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('AdminPage'); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AdminPage'); ?>
</a></li>
                    <li role="separator" class="divider"></li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Authentication']['CanChangeOwnPassword']): ?>
                    <li><a id="self-change-password" href="#" title="<?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePassword'); ?>
"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePassword'); ?>
</a></li>
                <?php endif; ?>
                <li><a href="login.php?operation=logout"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Logout'); ?>
</a></li>
            </ul>
        </li>
    <?php else: ?>
        <li><a href="login.php<?php if ($this->_tpl_vars['Page'] && $this->_tpl_vars['Page']->getLink()): ?>?redirect=<?php echo urlencode($this->_tpl_vars['Page']->getLink()); ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Login'); ?>
</a></li>
    <?php endif; ?>
</ul>