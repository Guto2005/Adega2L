<?php $this->assign('pageTitleButtons', $this->_tpl_vars['Page']->GetExportListButtonsViewData()); ?>

<?php if ($this->_tpl_vars['pageTitleButtons']): ?>
    <div class="btn-group export-button">

        <?php if ($this->_tpl_vars['Page']->getExportListAvailable()): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "view/export_buttons.tpl", 'smarty_include_vars' => array('buttons' => $this->_tpl_vars['pageTitleButtons'],'spanClasses' => "visible-lg-inline")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['Page']->getPrintListAvailable()): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "view/print_buttons.tpl", 'smarty_include_vars' => array('buttons' => $this->_tpl_vars['pageTitleButtons'],'spanClasses' => "visible-lg-inline")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['Page']->GetRssLink()): ?>
            <a href="<?php echo $this->_tpl_vars['Page']->GetRssLink(); ?>
" class="btn btn-default" title="RSS">
                <i class="icon-rss"></i>
                <span class="visible-lg-inline">RSS</span>
            </a>
        <?php endif; ?>

    </div>
<?php endif; ?>
