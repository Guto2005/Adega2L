<?php $this->assign('ContentBlockClass', "col-md-8 col-md-offset-2"); ?>
<?php ob_start(); ?>
<div class="alert alert-danger">
    <h3><?php echo $this->_tpl_vars['ErrorTitle']; ?>
</h3>

    <?php if (isset ( $this->_tpl_vars['ErrorContent'] )): ?><?php echo $this->_tpl_vars['ErrorContent']; ?>
<?php endif; ?>

    <?php if (( $this->_tpl_vars['DisplayDebugInfo'] == 1 )): ?>
        <hr>
        <h3>Additional exception info:</h3>
        <strong>File:</strong> <?php echo $this->_tpl_vars['File']; ?>
<br>
        <strong>Line:</strong> <?php echo $this->_tpl_vars['Line']; ?>

        <p>
            <strong>Trace:</strong><br>
            <pre><?php echo $this->_tpl_vars['Trace']; ?>
</pre>
        </p>
    <?php endif; ?>
</div>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/layout.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>