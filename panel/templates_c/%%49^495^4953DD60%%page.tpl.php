<!DOCTYPE html>
<html<?php if ($this->_tpl_vars['Page']->GetPageDirection() != null): ?> dir="<?php echo $this->_tpl_vars['Page']->GetPageDirection(); ?>
"<?php endif; ?>>
    <head>
        <title><?php echo $this->_tpl_vars['Page']->GetTitle(); ?>
</title>
        <meta http-equiv="content-type" content="text/html<?php if ($this->_tpl_vars['Page']->GetContentEncoding() != null): ?>; charset=<?php echo $this->_tpl_vars['Page']->GetContentEncoding(); ?>
<?php endif; ?>">
        <link rel="stylesheet" href="components/assets/css/print.css">
        <link rel="stylesheet" href="components/assets/css/user_print.css">
</head>
<body style="background-color:white" id="print-<?php echo $this->_tpl_vars['Page']->GetPageId(); ?>
">
    <h1><?php echo $this->_tpl_vars['Page']->GetTitle(); ?>
</h1>
    <?php echo $this->_tpl_vars['Grid']; ?>

</body>
</html>