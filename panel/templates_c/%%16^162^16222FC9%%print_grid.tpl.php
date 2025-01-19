<table>
    <?php $_from = $this->_tpl_vars['Columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Key'] => $this->_tpl_vars['Column']):
?>
        <tr>
            <td><b><?php echo $this->_tpl_vars['Column']->GetCaption(); ?>
</b></td>
            <td><?php echo $this->_tpl_vars['Rows'][0][$this->_tpl_vars['Key']]; ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>