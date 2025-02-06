<?php
$erro = '';
$sucesso = '';

// Verificar se o token foi fornecido via URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $expiracao = $_GET['expiracao'];

    // Verificar se o token ainda é válido
    if (time() > $expiracao) {
        $erro = "O token expirou. Solicite um novo link de recuperação.";
    }
} else {
    $erro = "Token não fornecido. Verifique o link de recuperação enviado.";
}

// Verificar se o formulário de redefinição foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($erro)) {
    // Conectar ao banco de dados para atualizar a senha
    $host = 'cc220df3eb53.sn.mynetname.net';
    $dbname = 'gto_caveira';
    $user = 'gto_caveira';
    $password = 'gto416966';

    $conn = mysqli_connect($host, $user, $password, $dbname);
    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }

    $nova_senha = $_POST['novaSenha'];

    // Aqui você pode atualizar a senha do usuário com base no token e e-mail
    // Este é um exemplo simples, sem o uso de token armazenado no banco
    $atualiza_senha = "UPDATE ADG2L_Usuarios SET senhaUsuario = '$nova_senha' WHERE emailUsuario = (SELECT emailUsuario FROM ADG2L_Usuarios WHERE senhaUsuario = '$nova_senha')";
    
    if (mysqli_query($conn, $atualiza_senha)) {
        $sucesso = "Senha alterada com sucesso!";
    } else {
        $erro = "Erro ao alterar a senha. Tente novamente.";
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Redefinir Senha</h1>

    <!-- Exibe mensagens de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php elseif ($sucesso): ?>
        <div class="alert alert-success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="novaSenha" class="form-label">Nova Senha</label>
            <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
        </div>

        <button type="submit" class="btn btn-primary">Alterar Senha</button>
    </form>
</div>

</body>
</html>

config apache
*/https://php.net/smtp-port
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = isabella.asltavares@gmail.com
sendmail_path = write_sendmail.exe_path/*


*/sendmail.ini smtp_server=smtp.gmail.com
   smtp_port=587
   error_logfile=error.log
   debug_logfile=debug.log
   auth_username=isabella.asltavares@gmail.com
auth_password=app_password_after_enabling_two_factor_authentication_for_your_mail_id
   force_sender=isabella.asltavares@gmail.com/*
