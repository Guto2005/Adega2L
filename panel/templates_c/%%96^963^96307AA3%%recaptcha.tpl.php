<?php if (isset ( $this->_tpl_vars['ReCaptcha'] )): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php if ($this->_tpl_vars['ReCaptcha']->isInvisibleCaptcha()): ?>
        <script>
            <?php echo '
            function onReCaptchaFormSubmit(token) {
                $(\'#submit-recaptcha\').hide();
                $(\'#submit-form\').show().click();
            }
            function onReCaptchaExpired() {
                $(\'#submit-recaptcha\').show();
                $(\'#submit-form\').hide();
            }
            '; ?>

        </script>
    <?php endif; ?>
<?php endif; ?>